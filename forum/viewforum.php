<?php
define('IN_FORUM',   true);
define('FT_SCRIPT', 'forum');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

define('LAST_TOPIC_MAX_LEN', 40);

if ( isset($_GET[POST_FORUM_URL]) || isset($_POST[POST_FORUM_URL]) )
{
	$forum_id = ( isset($_GET[POST_FORUM_URL]) ) ? intval($_GET[POST_FORUM_URL]) : intval($_POST[POST_FORUM_URL]);
}
else if ( isset($_GET['forum']))
{
	$forum_id = intval($_GET['forum']);
}
else
{
	$forum_id = '';
}

$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;

if ( isset($_GET['mark']) || isset($_POST['mark']) )
{
	$mark_read = (isset($_POST['mark'])) ? $_POST['mark'] : $_GET['mark'];
}
else
{
	$mark_read = '';
}
//
// End initial var setup
//

//
// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
//
if ( !empty($forum_id) )
{
	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
	}
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// If the query doesn't return any rows this isn't a valid forum. Inform
// the user.
//
if ( !($forum_row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_row);

if ( !$is_auth['auth_read'] || !$is_auth['auth_view'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = POST_FORUM_URL . "=$forum_id" . ( ( isset($start) ) ? "&start=$start" : '' );
		redirect(append_sid("login.php?redirect=viewforum.php&$redirect", true));
	}
	//
	// The user is not authed to read this forum ...
	//
	$message = ( !$is_auth['auth_view'] ) ? $lang['Forum_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End of auth check
//

//
// Handle marking posts
//
if ( $mark_read == 'topics' )
{
	if ( $userdata['session_logged_in'] )
	{
		$sql = "SELECT MAX(post_time) AS last_post
			FROM " . POSTS_TABLE . "
			WHERE forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$tracking_forums = ( isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_f']) : array();
			$tracking_topics = ( isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_t']) : array();

			if ( ( count($tracking_forums) + count($tracking_topics) ) >= 150 && empty($tracking_forums[$forum_id]) )
			{
				asort($tracking_forums);
				unset($tracking_forums[key($tracking_forums)]);
			}

			if ( $row['last_post'] > $userdata['user_lastvisit'] )
			{
				$tracking_forums[$forum_id] = time();

				setcookie($ft_cfg['cookie_name'] . '_f', serialize($tracking_forums), 0, $ft_cfg['cookie_path'], $ft_cfg['cookie_domain'], $ft_cfg['cookie_secure']);
			}
		}

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewforum.php?" . POST_FORUM_URL . "=$forum_id") . '">')
		);
	}

	$message = $lang['Topics_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.php?" . POST_FORUM_URL . "=$forum_id") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

$tracking_topics = ( isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_t']) : '';
$tracking_forums = ( isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$ft_cfg['cookie_prefix'] . '_f']) : '';

//
// Do the forum Prune
//
if ( $is_auth['auth_mod'] && $ft_cfg['prune_enable'] )
{
	if ( $forum_row['prune_next'] < time() && $forum_row['prune_enable'] )
	{
		require(FT_ROOT . 'includes/prune.php');
		require(FT_ROOT . 'includes/functions_admin.php');
		auto_prune($forum_id);
	}
}
//
// End of forum prune
//

//
// Do the forum topics move
//
        if ( $forum_row['move_next'] < time() && $forum_row['move_enable'] )
        {
                require_once(FT_ROOT . 'includes/function_topics_move.php');
                topics_move($forum_id, 3);
        }
        if ( $forum_row['recycle_move_next'] < time() && $forum_row['move_enable'] )
        {
                require_once(FT_ROOT . 'includes/function_topics_move.php');
                require_once(FT_ROOT . 'includes/functions_admin.php');
                topics_move($forum_id, 5);
        }
//
// End of forum topics move
//

//
// Obtain list of moderators of each forum
// First users, then groups ... broken into two queries
//
$sql = "SELECT u.user_id, u.username
	FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
	WHERE aa.forum_id = $forum_id
		AND aa.auth_mod = " . TRUE . "
		AND g.group_single_user = 1
		AND ug.group_id = aa.group_id
		AND g.group_id = aa.group_id
		AND u.user_id = ug.user_id
	GROUP BY u.user_id, u.username
	ORDER BY u.user_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
}

$moderators = array();
while( $row = $db->sql_fetchrow($result) )
{
	$moderators[] = '<a href="' . append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
}

$sql = "SELECT g.group_id, g.group_name
	FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
	WHERE aa.forum_id = $forum_id
		AND aa.auth_mod = " . TRUE . "
		AND g.group_single_user = 0
		AND g.group_type <> ". GROUP_HIDDEN ."
		AND ug.group_id = aa.group_id
		AND g.group_id = aa.group_id
	GROUP BY g.group_id, g.group_name
	ORDER BY g.group_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$moderators[] = '<a href="' . append_sid("groupcp.php?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
}

$l_moderators = ( count($moderators) == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
$forum_moderators = ( count($moderators) ) ? implode(', ', $moderators) : $lang['None'];
unset($moderators);

//
// Generate a 'Show topics in previous x days' select box. If the topicsdays var is sent
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Topics'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if ( !empty($HTTP_POST_VARS['topicdays']) || !empty($HTTP_GET_VARS['topicdays']) )
{
	$topic_days = ( !empty($HTTP_POST_VARS['topicdays']) ) ? intval($HTTP_POST_VARS['topicdays']) : intval($HTTP_GET_VARS['topicdays']);
	$min_topic_time = time() - ($topic_days * 86400);

	$sql = "SELECT COUNT(t.topic_id) AS forum_topics
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
		WHERE t.forum_id = $forum_id
			AND p.post_id = t.topic_last_post_id
			AND p.post_time >= $min_topic_time";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$topics_count = ( $row['forum_topics'] ) ? $row['forum_topics'] : 1;
	$limit_topics_time = "AND p.post_time >= $min_topic_time";

	if ( !empty($HTTP_POST_VARS['topicdays']) )
	{
		$start = 0;
	}
}
else
{
	$topics_count = ( $forum_row['forum_topics'] ) ? $forum_row['forum_topics'] : 1;

	$limit_topics_time = '';
	$topic_days = 0;
}

$select_topic_days = '<select name="topicdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($topic_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_topic_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_topic_days .= '</select>';


//// убрал вывод announcements на каждой странице
////
////  All announcement data, this keeps announcements
////  on each viewforum page ...
////
//// $sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_time, p.post_username
//// 	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . USERS_TABLE . " u2
//// 	WHERE t.forum_id = $forum_id
//// 		AND t.topic_poster = u.user_id
//// 		AND p.post_id = t.topic_last_post_id
//// 		AND p.poster_id = u2.user_id
//// 		AND t.topic_type = " . POST_ANNOUNCE . "
//// 	ORDER BY t.topic_last_post_id DESC ";
//// if ( !($result = $db->sql_query($sql)) )
//// {
////    message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
//// }

$topic_rowset = array();
//// $total_announcements = 0;
//// while( $row = $db->sql_fetchrow($result) )
//// {
//// 	$topic_rowset[] = $row;
//// 	$total_announcements++;
//// }

//// $db->sql_freeresult($result);

//
// Grab all the basic data (all topics except announcements)
// for this forum
//
//-- mod : topic display order
//-- add
// default forum values
$dft_sort = $forum_row['forum_display_sort'];
$dft_order = $forum_row['forum_display_order'];

// Sort def
$sort_value = $dft_sort;
if ( isset($HTTP_GET_VARS['sort']) || isset($HTTP_POST_VARS['sort']) )
{
	$sort_value = isset($HTTP_GET_VARS['sort']) ? intval($HTTP_GET_VARS['sort']) : intval($HTTP_POST_VARS['sort']);
}
$sort_list = '<select name="sort">' . get_forum_display_sort_option($sort_value, 'list', 'sort') . '</select>';

// Order def
$order_value = $dft_order;
if ( isset($HTTP_GET_VARS['order']) || isset($HTTP_POST_VARS['order']) )
{
	$order_value = isset($HTTP_GET_VARS['order']) ? intval($HTTP_GET_VARS['order']) : intval($HTTP_POST_VARS['order']);
}
$order_list = '<select name="order">' . get_forum_display_sort_option($order_value, 'list', 'order') . '</select>';

// display
$s_display_order = '&nbsp;' . $lang['Sort_by'] . ':&nbsp;' . $sort_list . $order_list . '&nbsp;';

// selected method
$sort_method = get_forum_display_sort_option($sort_value, 'field', 'sort');
$order_method = get_forum_display_sort_option($order_value, 'field', 'order');
//-- fin mod : topic display order
//-- mod : topic display order
// here we added
//	, $sort_method $order_method
//-- modify
$sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2
	WHERE t.forum_id = $forum_id
		AND t.topic_poster = u.user_id
		AND p.post_id = t.topic_first_post_id
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id
		$limit_topics_time
	ORDER BY t.topic_type DESC, $sort_method $order_method, t.topic_last_post_id DESC
	LIMIT $start, ".$ft_cfg['topics_per_page'];
if ( !($result = $db->sql_query($sql)) )
{
   message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

$total_topics = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_topics++;
}

$db->sql_freeresult($result);

//
// Total topics ...
//
//// $total_topics += $total_announcements;

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Post URL generation for templating vars
//
$template->assign_vars(array(
	'L_DISPLAY_TOPICS' => $lang['Display_topics'],

	'U_POST_NEW_TOPIC' => append_sid("posting.php?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id"),

	'S_SELECT_TOPIC_DAYS' => $select_topic_days,
	'S_POST_DAYS_ACTION' => append_sid("viewforum.php?" . POST_FORUM_URL . "=" . $forum_id . "&amp;start=$start"))
);

//
// User authorisation levels output
//
$s_auth_can = ( ( $is_auth['auth_post'] ) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_reply'] ) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_delete'] ) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';
attach_build_auth_levels($is_auth, $s_auth_can);

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');
}

//
// Mozilla navigation bar
//
$nav_links['up'] = array(
	'url' => append_sid('index.php'),
	'title' => sprintf($lang['Forum_Index'], $ft_cfg['sitename'])
);

//
// Dump out the page header and load viewforum template
//
define('SHOW_ONLINE', true);
$page_title = $forum_row['forum_name'];
require(FT_ROOT . 'includes/page_header.php');

$template->set_filenames(array(
	'body' => 'viewforum_body.tpl')
);
//sf
// make_jumpbox('viewforum.'.$phpEx);
$forums_ary = make_jumpbox('viewforum.php', 0, TRUE);

$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_NAME' => $forum_row['forum_name'],
	'MODERATORS' => $forum_moderators,
	'POST_IMG' => ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'],

	'FOLDER_IMG' => $images['folder'],
	'FOLDER_NEW_IMG' => $images['folder_new'],
	'FOLDER_HOT_IMG' => $images['folder_hot'],
	'FOLDER_HOT_NEW_IMG' => $images['folder_hot_new'],
	'FOLDER_LOCKED_IMG' => $images['folder_locked'],
	'FOLDER_LOCKED_NEW_IMG' => $images['folder_locked_new'],
	'FOLDER_STICKY_IMG' => $images['folder_sticky'],
	'FOLDER_STICKY_NEW_IMG' => $images['folder_sticky_new'],
	'FOLDER_ANNOUNCE_IMG' => $images['folder_announce'],
	'FOLDER_ANNOUNCE_NEW_IMG' => $images['folder_announce_new'],

	'L_TOPICS' => $lang['Topics'],
	'L_REPLIES' => $lang['Replies'],
	'L_VIEWS' => $lang['Views'],
	'L_POSTS' => $lang['Posts'],
	'L_LASTPOST' => $lang['Last_Post'],
	'L_MODERATOR' => $l_moderators,
	'L_MARK_TOPICS_READ' => $lang['Mark_all_topics'],
	'L_POST_NEW_TOPIC' => ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'],
	'L_NO_NEW_POSTS' => $lang['No_new_posts'],
	'L_NEW_POSTS' => $lang['New_posts'],
	'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'],
	'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'],
	'L_NO_NEW_POSTS_HOT' => $lang['No_new_posts_hot'],
	'L_NEW_POSTS_HOT' => $lang['New_posts_hot'],
	'L_ANNOUNCEMENT' => $lang['Post_Announcement'],
	'L_STICKY' => $lang['Post_Sticky'],
	'L_POSTED' => $lang['Posted'],
	'L_JOINED' => $lang['Joined'],
	'L_AUTHOR' => $lang['Author'],
	//bt
	'L_DOWNLOAD' => $lang['Post_Download'],
	'FOLDER_DOWNLOAD_IMG' => $images['folder_dl'],
	//bt end

	'S_AUTH_LIST' => $s_auth_can,

	'U_VIEW_FORUM' => append_sid("viewforum.php?" . POST_FORUM_URL ."=$forum_id"),

	'U_MARK_READ' => append_sid("viewforum.php?" . POST_FORUM_URL . "=$forum_id&amp;mark=topics"))
);
//
// End header
//

//
// Okay, lets dump out the page ...
//
//-- mod : topic display order
//-- add
$template->assign_vars(array(
	'S_DISPLAY_ORDER' => $s_display_order,
	)
);
//-- fin mod : topic display order
//bt
$topics_sql = $tor_topics_sql = $topic_tor = array();
$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();
$template->assign_vars(array('TORRENT_TOPICS' => FALSE));

if ($total_topics && $forum_row['allow_reg_tracker'])
{
	foreach ($topic_rowset as $rid => $row)
	{
		$topics_sql[] = $row['topic_id'];
	}
	$topics_sql = implode(',', $topics_sql);

	$sql = 'SELECT *
		FROM '. BT_TORRENTS_TABLE ."
		WHERE topic_id IN($topics_sql)";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain torrents information', '', __LINE__, __FILE__, $sql);
	}

	if ($tor_info = @$db->sql_fetchrowset($result))
	{
		$db->sql_freeresult($result);

		foreach ($tor_info as $rid => $row)
		{
			$topic_tor[$row['topic_id']] = $row;
			$tor_topics_sql[] = $row['topic_id'];
		}

		if ($tor_topics_sql = implode(',', $tor_topics_sql))
		{
			$sql = 'SELECT tor.topic_id, COUNT(tr.peer_id) as peers, SUM(tr.seeder) as seeders
				FROM '. BT_TORRENTS_TABLE .' tor, '. BT_TRACKER_TABLE ." tr
				WHERE tor.topic_id IN($tor_topics_sql)
					AND tor.torrent_id = tr.torrent_id
					AND tr.expire_time > $current_time
				GROUP BY tr.torrent_id";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not obtain peers information', '', __LINE__, __FILE__, $sql);
			}

			if ($tr_info = @$db->sql_fetchrowset($result))
			{
				$db->sql_freeresult($result);

				foreach ($tr_info as $rid => $row)
				{
					$topic_tor[$row['topic_id']]['seeders'] = $row['seeders'];
					$topic_tor[$row['topic_id']]['leechers'] = $row['peers'] - $row['seeders'];
				}
			}
		}
		unset($tor_info, $tr_info);

		$template->assign_vars(array(
			'TORRENT_TOPICS' => TRUE,
			'L_COMPLETED'    => $lang['Bt_Completed'],
			'L_DL'           => $lang['Tor_DL']
		));
	}
}
//bt end

if( $total_topics )
{
	for($i = 0; $i < $total_topics; $i++)
	{
		$topic_id = $topic_rowset[$i]['topic_id'];

		$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

		$replies = $topic_rowset[$i]['topic_replies'];

		$topic_type = $topic_rowset[$i]['topic_type'];

		if( $topic_type == POST_ANNOUNCE )
		{
			$topic_type = $lang['Topic_Announcement'] . ' ';
		}
		else if( $topic_type == POST_STICKY )
		{
			$topic_type = $lang['Topic_Sticky'] . ' ';
		}
		else
		{
			$topic_type = '';
		}

		//ts
		$topic_type = '';
		//ts end

		//bt
		if ($topic_rowset[$i]['topic_dl_type'] == TOPIC_DL_TYPE_DL)
		{
			$topic_type = $lang['Topic_DL'];
		}
		//bt end

		if( $topic_rowset[$i]['topic_vote'] )
		{
			$topic_type .= $lang['Topic_Poll'] . ' ';
		}

		if( $topic_rowset[$i]['topic_status'] == TOPIC_MOVED )
		{
			$topic_type = $lang['Topic_Moved'] . ' ';
			$topic_id = $topic_rowset[$i]['topic_moved_id'];

			$folder_image =  $images['folder'];
			$folder_alt = $lang['Topics_Moved'];
			$newest_post_img = '';
		}
		else
		{
			if( $topic_rowset[$i]['topic_type'] == POST_ANNOUNCE )
			{
				$folder = $images['folder_announce'];
				$folder_new = $images['folder_announce_new'];
			}
			else if( $topic_rowset[$i]['topic_type'] == POST_STICKY )
			{
				$folder = $images['folder_sticky'];
				$folder_new = $images['folder_sticky_new'];
			}
			else if( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED )
			{
				$folder = $images['folder_locked'];
				$folder_new = $images['folder_locked_new'];
			}
			//bt
			else if ($topic_rowset[$i]['topic_dl_type'] == TOPIC_DL_TYPE_DL)
			{
				if ($replies >= $ft_cfg['hot_threshold'])
				{
					$folder = $images['folder_dl_hot'];
					$folder_new = $images['folder_dl_hot_new'];
				}
				else
				{
					$folder = $images['folder_dl'];
					$folder_new = $images['folder_dl_new'];
				}
			}
			//bt end
			else
			{
				if($replies >= $ft_cfg['hot_threshold'])
				{
					$folder = $images['folder_hot'];
					$folder_new = $images['folder_hot_new'];
				}
				else
				{
					$folder = $images['folder'];
					$folder_new = $images['folder_new'];
				}
			}

			$newest_post_img = '';
			if( $userdata['session_logged_in'] )
			{
				if( $topic_rowset[$i]['post_time'] > $userdata['user_lastvisit'] )
				{
					if( !empty($tracking_topics) || !empty($tracking_forums) || isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_name'] . '_f_all']) )
					{
						$unread_topics = true;

						if( !empty($tracking_topics[$topic_id]) )
						{
							if( $tracking_topics[$topic_id] >= $topic_rowset[$i]['post_time'] )
							{
								$unread_topics = false;
							}
						}

						if( !empty($tracking_forums[$forum_id]) )
						{
							if( $tracking_forums[$forum_id] >= $topic_rowset[$i]['post_time'] )
							{
								$unread_topics = false;
							}
						}

						if( isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_name'] . '_f_all']) )
						{
							if( $HTTP_COOKIE_VARS[$ft_cfg['cookie_name'] . '_f_all'] >= $topic_rowset[$i]['post_time'] )
							{
								$unread_topics = false;
							}
						}

						if( $unread_topics )
						{
							$folder_image = $folder_new;
							$folder_alt = $lang['New_posts'];

							$newest_post_img = '<a href="' . append_sid("viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" width="18" height="9" /></a> ';
						}
						else
						{
							$folder_image = $folder;
							$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

							$newest_post_img = '';
						}
					}
					else
					{
						$folder_image = $folder_new;
						$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['New_posts'];

						$newest_post_img = '<a href="' . append_sid("viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" width="18" height="9" /></a> ';
					}
				}
				else
				{
					$folder_image = $folder;
					$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

					$newest_post_img = '';
				}
			}
			else
			{
				$folder_image = $folder;
				$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

				$newest_post_img = '';
			}
		}

		if( ( $replies + 1 ) > $ft_cfg['posts_per_page'] )
		{
			$total_pages = ceil( ( $replies + 1 ) / $ft_cfg['posts_per_page'] );
			$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="' . $lang['Goto_page'] . '" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';

			$times = 1;
			for($j = 0; $j < $replies + 1; $j += $ft_cfg['posts_per_page'])
			{
				$goto_page .= '<a href="' . append_sid("viewtopic.php?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
				if( $times == 1 && $total_pages > 4 )
				{
					$goto_page .= ' ... ';
					$times = $total_pages - 3;
					$j += ( $total_pages - 4 ) * $ft_cfg['posts_per_page'];
				}
				else if ( $times < $total_pages )
				{
					$goto_page .= ', ';
				}
				$times++;
			}
			$goto_page .= ' ] ';
		}
		else
		{
			$goto_page = '';
		}

		$view_topic_url = append_sid("viewtopic.php?" . POST_TOPIC_URL . "=$topic_id");

		$topic_author = ( $topic_rowset[$i]['user_id'] != GUEST_UID ) ? '<a href="' . append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $topic_rowset[$i]['user_id']) . '">' : '';
		$topic_author .= ( $topic_rowset[$i]['user_id'] != GUEST_UID ) ? $topic_rowset[$i]['username'] : ( ( $topic_rowset[$i]['post_username'] != '' ) ? $topic_rowset[$i]['post_username'] : $lang['Guest'] );

		$topic_author .= ( $topic_rowset[$i]['user_id'] != GUEST_UID ) ? '</a>' : '';

		$first_post_time = create_date($ft_cfg['default_dateformat'], $topic_rowset[$i]['topic_time'], $ft_cfg['board_timezone']);

		$last_post_time = create_date($ft_cfg['default_dateformat'], $topic_rowset[$i]['post_time'], $ft_cfg['board_timezone']);

		$last_post_author = ( $topic_rowset[$i]['id2'] == GUEST_UID ) ? ( ($topic_rowset[$i]['post_username2'] != '' ) ? $topic_rowset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $topic_rowset[$i]['id2']) . '">' . $topic_rowset[$i]['user2'] . '</a>';

		$last_post_url = '<a href="' . append_sid("viewtopic.php?"  . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" width="18" height="9" /></a>';

		$views = $topic_rowset[$i]['topic_views'];

		//ts
		$topics_separator = '';

		if ($topic_rowset[$i]['topic_type'] == POST_ANNOUNCE && !defined('ANNOUNCE_SEP'))
		{
			define('ANNOUNCE_SEP', TRUE);
			$topics_separator = $lang['Topics_Announcement'];
		}
		else if ($topic_rowset[$i]['topic_type'] == POST_STICKY && !defined('STICKY_SEP'))
		{
			define('STICKY_SEP', TRUE);
			$topics_separator = $lang['Topics_Sticky'];
		}
		else if ($topic_rowset[$i]['topic_type'] == POST_NORMAL && !defined('NORMAL_SEP'))
		{
			if (defined('ANNOUNCE_SEP') || defined('STICKY_SEP'))
			{
				define('NORMAL_SEP', TRUE);
				$topics_separator = $lang['Topics_Normal'];
			}
		}
		//ts end

	    if (isset($topic_tor[$topic_id]))
	    {
		    switch ($topic_tor[$topic_id]['topic_check_status'])
		    {
		        case 1: $topic_check_status='<span style="color:indigo;">&#9674;</span>'; break; 
		        case 2: $topic_check_status='<span style="color:green;">&radic;</span>'; break; 
		        case 3: $topic_check_status='<span style="color:#E6C506;">&#8776;</span>'; break; 
		        case 4: $topic_check_status='<span style="color:red;">&#8800;</span>'; break; 
		        case 5: $topic_check_status='<span style="color:blue;">&#8734;</span>'; break; 
		        default: $topic_check_status='<span style="color:red;">?</span>';
		    }
	    }

		$template->assign_block_vars('topicrow', array(
				'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
			'FORUM_ID' => $forum_id,
			'TOPIC_ID' => $topic_id,
			'TOPIC_FOLDER_IMG' => $folder_image,
			'TOPIC_AUTHOR' => $topic_author,
			'GOTO_PAGE' => $goto_page,
			'REPLIES' => $replies,
			'NEWEST_POST_IMG' => $newest_post_img,
			'TOPIC_ATTACHMENT_IMG' => topic_attachment_image($topic_rowset[$i]['topic_attachment']),
			'TOPIC_TITLE' => $topic_title,
			'TOPIC_TYPE' => $topic_type,
			'VIEWS' => $views,
			'FIRST_POST_TIME' => $first_post_time,
			'LAST_POST_TIME' => $last_post_time,
			'LAST_POST_AUTHOR' => $last_post_author,
			'LAST_POST_IMG' => $last_post_url,
			'TOPIC_CHECK_STATUS' => (isset($topic_tor[$topic_id]))? $topic_check_status." &#183; ":"",

			//ts
			'TOPICS_SEPARATOR' => $topics_separator,
			//ts end

			'L_TOPIC_FOLDER_ALT' => $folder_alt,

			'U_VIEW_TOPIC' => $view_topic_url)
		);
		//bt
		if (isset($topic_tor[$topic_id]))
		{
			$seeds  = (isset($topic_tor[$topic_id]['seeders'])) ? $topic_tor[$topic_id]['seeders'] : 0;
			$leechs = (isset($topic_tor[$topic_id]['leechers'])) ? $topic_tor[$topic_id]['leechers'] : 0;

			$s_last = $topic_tor[$topic_id]['seeder_last_seen'];
			$compl  = $topic_tor[$topic_id]['complete_count'];
			$att_id = $topic_tor[$topic_id]['attach_id'];
			$size   = $topic_tor[$topic_id]['size'];

			$template->assign_block_vars('topicrow.tor', array(
				'SEEDERS'         => ($seeds) ? $seeds : 0,
				'SEEDERS_TITLE'   => ($seeds) ? 'Seeders' : ( " Seeder last seen: \n " . (($s_last) ? create_date($ft_cfg['default_dateformat'], $s_last, $ft_cfg['board_timezone']) : 'Never') ),
				'LEECHERS'        => ($leechs) ? $leechs : 0,
				'TORRENT_SIZE'    => humn_size($size),
				'DL_TORRENT_HREF' => append_sid("download.php?id=" . $att_id)
			));
		}
		$template->assign_block_vars('topicrow.compl', array('COMPLETED' => (isset($compl)) ? $compl : ''));
		unset($compl);
		//bt end
	}

////	$topics_count -= $total_announcements;

	$template->assign_vars(array(
//-- mod : topic display order
// here we added
//	&amp;sort=$sort_value&amp;order=$order_value
//-- modify
		'PAGINATION' => generate_pagination("viewforum.php?" . POST_FORUM_URL . "=$forum_id&amp;topicdays=$topic_days&amp;sort=$sort_value&amp;order=$order_value", $topics_count, $ft_cfg['topics_per_page'], $start),
//-- fin mod : topic display order
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $ft_cfg['topics_per_page'] ) + 1 ), ceil( $topics_count / $ft_cfg['topics_per_page'] )),

		'L_GOTO_PAGE' => $lang['Goto_page'])
	);
}
else
{
	//
	// No topics
	//
	$no_topics_msg = ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['No_topics_post_one'];
	$template->assign_vars(array(
		'L_NO_TOPICS' => $no_topics_msg)
	);

	$template->assign_block_vars('switch_no_topics', array() );

}

//sf
$template->assign_vars(array(
	'HAS_PARENT_FORUM'  => FALSE,
	'DISPLAY_SUBFORUMS' => FALSE
));

if (!$forum_row['forum_parent'] && isset($forums_ary[$forum_id]['subforums']))
{
	$not_auth_forums = user_not_auth_forums(AUTH_VIEW);
	$ignore_forum_sql = ($not_auth_forums) ? "AND f.forum_id NOT IN($not_auth_forums)" : '';

	$sql = 'SELECT f.*, p.post_time, p.post_username, u.username, u.user_id, t.topic_id AS last_topic_id, t.topic_title AS last_topic_title
		FROM '. FORUMS_TABLE .' f
		LEFT JOIN '. POSTS_TABLE .' p ON p.post_id = f.forum_last_post_id
		LEFT JOIN '. USERS_TABLE .' u ON u.user_id = p.poster_id
		LEFT JOIN '. TOPICS_TABLE ." t ON t.topic_last_post_id = f.forum_last_post_id
		WHERE f.forum_parent = $forum_id
			$ignore_forum_sql
		ORDER BY f.cat_id, f.forum_order";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query subforums information', '', __LINE__, __FILE__, $sql);
	}

	if ($rowset = @$db->sql_fetchrowset($result))
	{
		$db->sql_freeresult($result);

		foreach ($rowset as $rid => $forum_data)
		{
			if ($forum_data['forum_status'] == FORUM_LOCKED)
			{
				$folder_image = $images['forum_locked'];
				$folder_alt = $lang['Forum_locked'];
			}
			else
			{
				$unread_topics = false;
				$forum_id = $forum_data['forum_id'];

				if ($userdata['session_logged_in'])
				{
					if ($forum_data['post_time'] > $userdata['user_lastvisit'])
					{
						$forum_last_post_time = 0;
						$check_topic_id = $forum_data['last_topic_id'];
						$check_post_time = $forum_data['post_time'];

						if (!isset($tracking_topics[$check_topic_id]))
						{
							$unread_topics = true;
							$forum_last_post_time = max($check_post_time, $forum_last_post_time);
						}
						else
						{
							if ($tracking_topics[$check_topic_id] < $check_post_time)
							{
								$unread_topics = true;
								$forum_last_post_time = max($check_post_time, $forum_last_post_time);
							}
						}

						if (isset($tracking_forums[$forum_id]))
						{
							if ($tracking_forums[$forum_id] > $forum_last_post_time)
							{
								$unread_topics = false;
							}
						}

						if (isset($HTTP_COOKIE_VARS[$ft_cfg['cookie_name'] . '_f_all']))
						{
							if ($HTTP_COOKIE_VARS[$ft_cfg['cookie_name'] . '_f_all'] > $forum_last_post_time)
							{
								$unread_topics = false;
							}
						}
					}
				}

				$folder_image = ($unread_topics) ? $images['forum_new'] : $images['forum'];
				$folder_alt = ($unread_topics) ? $lang['New_posts'] : $lang['No_new_posts'];
			}

			$posts = $forum_data['forum_posts'];
			$topics = $forum_data['forum_topics'];

			if ($forum_data['forum_last_post_id'])
			{
				$last_post_time = create_date($ft_cfg['default_dateformat'], $forum_data['post_time'], $ft_cfg['board_timezone']);

				$last_post = $last_post_time . '<br />';

				$last_post .= ($forum_data['user_id'] == GUEST_UID) ? (($forum_data['post_username']) ? $forum_data['post_username'] .' ' : $lang['Guest'] .' ' ) : '<a href="'. append_sid("profile.php?mode=viewprofile&amp;". POST_USERS_URL .'='. $forum_data['user_id']) .'">'. $forum_data['username'] .'</a> ';

				$last_post .= '<a href="'. append_sid("viewtopic.php?". POST_POST_URL .'='. $forum_data['forum_last_post_id']) .'#'. $forum_data['forum_last_post_id'] .'"><img src="'. $images['icon_latest_reply'] .'" border="0" width="18" height="9" alt="'. $lang['View_latest_post'] .'" title="'. $lang['View_latest_post'] .'" /></a>';
			}
			else
			{
				$last_post = $lang['No_Posts'];
			}

			$template->assign_block_vars('forumrow',	array(
					'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
				'FORUM_FOLDER_IMG' => $folder_image,
				'FORUM_NAME' => $forum_data['forum_name'],
				'FORUM_DESC' => $forum_data['forum_desc'],
				'POSTS' => $forum_data['forum_posts'],
				'TOPICS' => $forum_data['forum_topics'],
				'LAST_POST' => $last_post,
				'MODERATORS' => '',

				'L_FORUM_FOLDER_ALT' => $folder_alt,

				'U_VIEWFORUM' => append_sid("viewforum.php?". POST_FORUM_URL ."=$forum_id"))
			);

			//flt
			if ($forum_data['forum_last_post_id'])
			{
				if ($forum_data['user_id'] == GUEST_UID)
				{
					$last_post_uname = ($forum_data['post_username']) ? $forum_data['post_username'] : $lang['Guest'];
				}
				else
				{
					$last_post_uname = $forum_data['username'];
				}

				$template->assign_block_vars('forumrow.last', array(
					'FORUM_LAST_POST'     => TRUE,
					'SHOW_LAST_TOPIC'     => SHOW_FORUM_LAST_TOPIC,
					'LAST_TOPIC_HREF'     => append_sid("viewtopic.php?". POST_TOPIC_URL .'='. $forum_data['last_topic_id']),
					'LAST_TOPIC_TIP'      => $forum_data['last_topic_title'],
					'LAST_TOPIC_TITLE'    => str_short($forum_data['last_topic_title'], LAST_TOPIC_MAX_LEN),

					'LAST_POST_TIME'      => create_date(LAST_POST_DATE_FORMAT, $forum_data['post_time'], $ft_cfg['board_timezone']),
					'LAST_POST_HREF'      => append_sid("viewtopic.php?". POST_POST_URL .'='. $forum_data['forum_last_post_id']) .'#'. $forum_data['forum_last_post_id'],
					'LAST_POST_USER_NAME' => $last_post_uname,
					'LAST_POST_USER_HREF' => ($forum_data['user_id'] != GUEST_UID) ? append_sid("profile.php?mode=viewprofile&amp;". POST_USERS_URL .'='. $forum_data['user_id']) : '',
					'ICON_LATEST_REPLY'   => $images['icon_latest_reply']
				));
			}
			else
			{
				$template->assign_block_vars('forumrow.last', array('FORUM_LAST_POST' => FALSE));
			}
			//flt end
		}

		$template->assign_vars(array(
			'HAS_PARENT_FORUM' => FALSE,
			'DISPLAY_SUBFORUMS' => TRUE,

			'FORUM_IMG' => $images['forum'],
			'FORUM_NEW_IMG' => $images['forum_new'],
			'FORUM_LOCKED_IMG' => $images['forum_locked'],

			'L_FORUM' => $lang['Forum'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_VIEWS' => $lang['Views'],
			'L_POSTS' => $lang['Posts'],
			'L_LASTPOST' => $lang['Last_Post'],
			'L_NO_NEW_POSTS' => $lang['No_new_posts'],
			'L_NEW_POSTS' => $lang['New_posts'],
			'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'],
			'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'],
			'L_FORUM_LOCKED' => $lang['Forum_is_locked'],

			//flt
			'SHOW_LAST_TOPIC' => SHOW_FORUM_LAST_TOPIC,
			'L_NO_POSTS'      => $lang['No_Posts'],
			//flt end
		));
	}
}
else if ($forum_row['forum_parent'])
{
	$template->assign_vars(array(
		'HAS_PARENT_FORUM'  => TRUE,
		'PARENT_FORUM_HREF'	=> append_sid("viewforum.php?". POST_FORUM_URL .'='. $forum_row['forum_parent']),
		'PARENT_FORUM_NAME' => $forums_ary[$forum_row['forum_parent']]['forum_name']
	));
}
//sf end

//
// Parse the page and print
//
$template->pparse('body');

//
// Page footer
//
require(FT_ROOT . 'includes/page_tail.php');