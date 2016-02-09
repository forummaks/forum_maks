<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

define('LAST_TOPIC_MAX_LEN', 30);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

$viewcat = ( !empty($HTTP_GET_VARS[POST_CAT_URL]) ) ? $HTTP_GET_VARS[POST_CAT_URL] : -1;

if( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = ( isset($HTTP_POST_VARS['mark']) ) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}

//
// Handle marking posts
//
if( $mark_read == 'forums' )
{
	if( $userdata['session_logged_in'] )
	{
		setcookie($board_config['cookie_name'] . '_f_all', time(), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}

	//mr ["mark all forums read" fix]
	$user_id = $userdata['user_id'];
	$user_ip = $userdata['session_ip'];
	$session_id = $userdata['session_id'];
	$current_time = time();

	if ($user_id != ANONYMOUS)
	{
		$sql = 'UPDATE ' . SESSIONS_TABLE . " SET
				session_start = $current_time,
				session_time = $current_time
			WHERE session_id = '$session_id'
				AND session_ip = '$user_ip'
				AND session_user_id = $user_id";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error updating session', '', __LINE__, __FILE__, $sql);
		}

		$sql = 'UPDATE ' . USERS_TABLE . " SET
				user_session_time = $current_time,
				user_lastvisit = $current_time
			WHERE user_id = $user_id";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
		}
	}

	setcookie($board_config['cookie_name'] .'_t', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	setcookie($board_config['cookie_name'] .'_f', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	//mr end

	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="3;url='  .append_sid("index.$phpEx") . '">')
	);

	$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');

	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_t"]) : array();
$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_f"]) : array();

//
// If you don't use these stats on your index you may want to consider
// removing them
//
$total_posts = get_db_stat('postcount');
$total_users = get_db_stat('usercount');
$newest_userdata = get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}

//
// Start page proper
//
$cat_forums = $forum_data = array();
$curr_sf_num = $last_sf_id = $last_root_forum_id = NULL;

$not_auth_forums = user_not_auth_forums(AUTH_VIEW);
$ignore_forum_sql = ($not_auth_forums) ? "AND f.forum_id NOT IN($not_auth_forums)" : '';

//flt - add [, t.topic_id AS last_topic_id, t.topic_title AS last_topic_title] and [LEFT JOIN " . TOPICS_TABLE ...]
$sql = 'SELECT c.cat_title, f.*, p.post_time, p.post_username, u.username, u.user_id, t.topic_id AS last_topic_id, t.topic_title AS last_topic_title
	FROM '. CATEGORIES_TABLE .' c
		LEFT JOIN '. FORUMS_TABLE ." f ON f.cat_id = c.cat_id $ignore_forum_sql
		LEFT JOIN ". POSTS_TABLE .' p ON p.post_id = f.forum_last_post_id
		LEFT JOIN '. USERS_TABLE .' u ON u.user_id = p.poster_id
		LEFT JOIN '. TOPICS_TABLE .' t ON t.topic_last_post_id = f.forum_last_post_id
	ORDER BY c.cat_order, f.cat_id, f.forum_order';

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
}

if ($rowset = $db->sql_fetchrowset($result))
{
	foreach ($rowset as $rid => $row)
	{
		if ($cat_id = $row['cat_id'])
		{
			$cat_forums[$cat_id]['cat_title'] = $row['cat_title'];

			if ($cat_id == $viewcat || $viewcat == -1)
			{
				if ($parent_id = $row['forum_parent'])
				{
					$parent =& $cat_forums[$cat_id]['f'][$parent_id];
                              $parent['has_sf'] = 1;
                              $parent['forum_posts'] += $row['forum_posts'];
                              $parent['forum_topics'] += $row['forum_topics'];

                              if ($row['post_time'] > $parent['post_time'])
                              {
                                $replace_in_parent = array(
                                  'forum_last_post_id',
                                  'last_topic_title',
                                  'last_topic_id',
                                  'post_time',
                                  'username',
                                  'user_id',
                                );
                                foreach ($replace_in_parent as $key)
                                {
                                  $parent[$key] = $row[$key];
                                }
                              }
                              $cat_forums[$cat_id]['f'][$parent_id]['forum_posts'] += $row['forum_posts'];
                              $cat_forums[$cat_id]['f'][$parent_id]['forum_topics'] += $row['forum_topics'];  

					if (SHOW_SUBFORUMS_ON_INDEX && $row['show_on_index'])
					{
						$cat_forums[$cat_id]['f'][$parent_id]['last_sf_id'] = $row['forum_id'];
					}
					else
					{
						continue;
					}
				}

				$cat_forums[$cat_id]['f'][$row['forum_id']] = $row;
			}
		}
	}
	$db->sql_freeresult($result);
	unset($rowset);
}

if ($cat_forums)
{
	//
	// Obtain list of moderators of each forum
	// First users, then groups ... broken into two queries
	//
	$sql = "SELECT aa.forum_id, u.user_id, u.username
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
		WHERE aa.auth_mod = " . TRUE . "
			AND g.group_single_user = 1
			AND ug.group_id = aa.group_id
			AND g.group_id = aa.group_id
			AND u.user_id = ug.user_id
		GROUP BY u.user_id, u.username, aa.forum_id
		ORDER BY aa.forum_id, u.user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	$forum_moderators = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a class="gensmall" href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
	}
	$db->sql_freeresult($result);

	$sql = "SELECT aa.forum_id, g.group_id, g.group_name
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
		WHERE aa.auth_mod = " . TRUE . "
			AND g.group_single_user = 0
			AND g.group_type <> " . GROUP_HIDDEN . "
			AND ug.group_id = aa.group_id
			AND g.group_id = aa.group_id
		GROUP BY g.group_id, g.group_name, aa.forum_id
		ORDER BY aa.forum_id, g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a class="gensmall" href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
	}
	$db->sql_freeresult($result);

	//
	// Start output of page
	//
	define('SHOW_ONLINE', true);
	$page_title = $lang['Index'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array('body' => 'index_body.tpl'));

	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'),

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
		'L_ONLINE_EXPLAIN' => $lang['Online_explain'],

		'L_MODERATOR' => $lang['Moderators'],
		'L_FORUM_LOCKED' => $lang['Forum_is_locked'],
		'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'],

		//flt
		'SHOW_LAST_TOPIC' => SHOW_FORUM_LAST_TOPIC,
		'L_NO_POSTS'      => $lang['No_Posts'],
		//flt end
		'L_SUBFORUMS' => $lang['SF_Subforums'],

		'U_MARK_READ' => append_sid("index.$phpEx?mark=forums"))
	);

	//
	// Okay, let's build the index
	//
	foreach ($cat_forums as $cat_id => $cat_data)
	{
		$template->assign_block_vars('catrow', array(
			'CAT_ID' => $cat_id,
			'CAT_DESC' => $cat_data['cat_title'],
			'U_VIEWCAT' => append_sid("index.$phpEx?". POST_CAT_URL ."=$cat_id")
		));

		if (!isset($cat_data['f']))
		{
			continue;
		}

		foreach ($cat_data['f'] as $forum_id => $forum_data)
		{
			if (!isset($forum_data['forum_id']))
			{
				continue;
			}

			if (!$forum_data['forum_parent'])
			{
				$last_root_forum_id = $forum_id;
				$curr_sf_num = 1;
				$last_sf_id = (isset($forum_data['last_sf_id'])) ? $forum_data['last_sf_id'] : NULL;
			}

			if ($forum_data['forum_status'] == FORUM_LOCKED)
			{
				$folder_image = $images['forum_locked'];
				$folder_alt = $lang['Forum_locked'];
			}
			else
			{
				$unread_topics = false;

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

						if (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']))
						{
							if ($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] > $forum_last_post_time)
							{
								$unread_topics = false;
							}
						}
					}
				}

				if (isset($forum_data['has_sf']))
				{
					$folder_image = ($unread_topics) ? $images['forums_new'] : $images['forums'];
				}
				else
				{
					$folder_image = ($unread_topics) ? $images['forum_new'] : $images['forum'];
				}
				$folder_alt = ($unread_topics) ? $lang['New_posts'] : $lang['No_new_posts'];
			}

			if ($forum_data['forum_parent'] == $last_root_forum_id)
			{
				$template->assign_block_vars('catrow.forumrow.sf', array(
					'SF_NUM'       => $curr_sf_num,
					'SF_NAME'      => $forum_data['forum_name'],
					'SF_DESC'      => $forum_data['forum_desc'],
					'SF_IMG_SRC'   => ($unread_topics) ? $images['icon_minipost_new'] : $images['icon_minipost'],
					'SF_IMG_TITLE' => ($unread_topics) ? $lang['New_posts'] : $lang['No_new_posts'],
					'SF_HREF'      => append_sid("viewforum.$phpEx?". POST_FORUM_URL ."=$forum_id"),
					'SF_LAST_SUBF' => ($forum_id == $last_sf_id) ? TRUE : FALSE,
					'ORDER'        => $forum_data['forum_order'],
				));

				$curr_sf_num++;
			}

			if ($forum_data['forum_parent'])
			{
				continue;
			}

			if ($forum_data['forum_last_post_id'])
			{
				$last_post_time = create_date($board_config['default_dateformat'], $forum_data['post_time'], $board_config['board_timezone']);

				$last_post = $last_post_time . '<br />';

				$last_post .= ($forum_data['user_id'] == ANONYMOUS) ? (($forum_data['post_username']) ? $forum_data['post_username'] .' ' : $lang['Guest'] .' ' ) : '<a href="'. append_sid("profile.$phpEx?mode=viewprofile&amp;". POST_USERS_URL .'='. $forum_data['user_id']) .'">'. $forum_data['username'] .'</a> ';

				$last_post .= '<a href="'. append_sid("viewtopic.$phpEx?". POST_POST_URL .'='. $forum_data['forum_last_post_id']) .'#'. $forum_data['forum_last_post_id'] .'"><img src="'. $images['icon_latest_reply'] .'" border="0" width="18" height="9" alt="'. $lang['View_latest_post'] .'" title="'. $lang['View_latest_post'] .'" /></a>';
			}
			else
			{
				$last_post = $lang['No_Posts'];
			}

			if (isset($forum_moderators[$forum_id]) && count($forum_moderators[$forum_id]) > 0)
			{
				$l_moderators = (count($forum_moderators[$forum_id]) == 1) ? $lang['Moderator'] : $lang['Moderators'];
				$moderator_list = implode(', ', $forum_moderators[$forum_id]);
			}
			else
			{
				$l_moderators = '';
				$moderator_list = '';
			}

			$template->assign_block_vars('catrow.forumrow',	array(
				'FORUM_FOLDER_IMG' => $folder_image,
				'FORUM_NAME' => $forum_data['forum_name'],
				'FORUM_DESC' => $forum_data['forum_desc'],
				'LAST_POST' => $last_post,
				'MODERATORS' => $moderator_list,
				'ORDER' => $forum_data['forum_order'],

				'L_MODERATOR' => $l_moderators,
				'L_FORUM_FOLDER_ALT' => $folder_alt,

				'U_VIEWFORUM' => append_sid("viewforum.$phpEx?". POST_FORUM_URL ."=$forum_id"))
			);

			//flt
			if ($forum_data['forum_last_post_id'])
			{
				if ($forum_data['user_id'] == ANONYMOUS)
				{
					$last_post_uname = ($forum_data['post_username']) ? $forum_data['post_username'] : $lang['Guest'];
				}
				else
				{
					$last_post_uname = $forum_data['username'];
				}

				$template->assign_block_vars('catrow.forumrow.last', array(
					'FORUM_LAST_POST'     => TRUE,
					'SHOW_LAST_TOPIC'     => SHOW_FORUM_LAST_TOPIC,
					'LAST_TOPIC_HREF'     => append_sid("viewtopic.$phpEx?". POST_TOPIC_URL .'='. $forum_data['last_topic_id']),
					'LAST_TOPIC_TIP'      => $forum_data['last_topic_title'],
					'LAST_TOPIC_TITLE'    => short_str($forum_data['last_topic_title'], LAST_TOPIC_MAX_LEN),

					'LAST_POST_TIME'      => create_date(LAST_POST_DATE_FORMAT, $forum_data['post_time'], $board_config['board_timezone']),
					'LAST_POST_HREF'      => append_sid("viewtopic.$phpEx?". POST_POST_URL .'='. $forum_data['forum_last_post_id']) .'#'. $forum_data['forum_last_post_id'],
					'LAST_POST_USER_NAME' => $last_post_uname,
					'LAST_POST_USER_HREF' => ($forum_data['user_id'] != ANONYMOUS) ? append_sid("profile.$phpEx?mode=viewprofile&amp;". POST_USERS_URL .'='. $forum_data['user_id']) : '',
					'ICON_LATEST_REPLY'   => $images['icon_latest_reply']
				));
			}
			else
			{
				$template->assign_block_vars('catrow.forumrow.last', array('FORUM_LAST_POST' => FALSE));
			}
			//flt end
		}
	} // for ... categories
}// if ... total_categories
else
{
	message_die(GENERAL_MESSAGE, $lang['No_forums']);
}

//bt search
$s_link = "search.$phpEx?search_id=dl&amp;dl_status=";

$template->assign_vars(array(
	'L_SEARCH_DL'          => $lang['Search_DL'],
	'L_SEARCH_DL_WILL'     => $lang['Search_DL_Will'],
	'L_SEARCH_DL_DOWN'     => $lang['Search_DL_Down'],
	'L_SEARCH_DL_COMPLETE' => $lang['Search_DL_Complete'],
	'L_SEARCH_DL_CANCEL'   => $lang['Search_DL_Cancel'],

	'U_SEARCH_DL_WILL'     => $s_link . DL_STATUS_WILL,
	'U_SEARCH_DL_DOWN'     => $s_link . DL_STATUS_DOWN,
	'U_SEARCH_DL_COMPLETE' => $s_link . DL_STATUS_COMPLETE,
	'U_SEARCH_DL_CANCEL'   => $s_link . DL_STATUS_CANCEL
));
//bt search end

//
//latest news
//
if ($bb_cfg['show_latest_news'] AND $news_forum_ids = $bb_cfg['latest_news_forum_id'])
{
	$template->assign_vars(array(
		'SHOW_LATEST_NEWS' => true,
	));
  $news_count = max($bb_cfg['latest_news_count'], 1);	
	
	$sql = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, p.post_time
		FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p, " . FORUMS_TABLE . " AS f
		WHERE t.forum_id = f.forum_id
		AND t.forum_id IN(" . $news_forum_ids .")
		AND  p.post_id = t.topic_last_post_id
		AND t.topic_moved_id = 0
		ORDER BY p.post_id DESC LIMIT $news_count";

	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not fetch latest news information.", '', __LINE__, __FILE__, $sql);
	}

while ( $row = $db->sql_fetchrow($result) )
	{	
	$template->assign_block_vars('news', array(
		'NEWS_TIME'       => create_date('d-M', $row['post_time'], $board_config['board_timezone']),
		'NEWS_TOPIC_ID'   => $row['topic_id'],
		'NEWS_TOPIC_NAME' => str_replace("'", "\'", $row['topic_title']),
		'NEWS_IS_NEW'     => $row['post_time'] > $userdata['user_lastvisit']	
	));
	}
}
//
//latest news end
//

//
// peer info begin
//
   $cur_time = time();
   $peers = $seeds = $leechs = $sl_ratio = $torrents = $torrents_size = $torrents_act = $up = $down = $total = 'unknown';
  //
  // peer, leech, seed
  //
   $sql = " SELECT COUNT(peer_id) AS peers, SUM(seeder) AS seeds
            FROM " . BT_TRACKER_TABLE . "
            WHERE  expire_time > $cur_time ";
        if ($row = $db->sql_fetchrow($db->sql_query($sql)))
        {
            $peers = ($row['peers']) ? $row['peers'] : 0;
            $seeds = ($row['seeds']) ? $row['seeds'] : 0;
            $leechs = $peers - $seeds;
        if ($leechs == 0) { $sl_ratio = 'infinity'; } else { $sl_ratio = round((($seeds - $leechs) / $seeds) * 100, 2); }
        }
   //
   // peer, leech, seed, speed_up, speed_down END
   //

   //
   // torrents overall
   //
      $sql = " SELECT COUNT(torrent_id) AS torrents, SUM(size) AS torrents_size
               FROM " . BT_TORRENTS_TABLE ;
                  if ($row = $db->sql_fetchrow($db->sql_query($sql)))
     					 {
                         $torrents = $row['torrents'];
                         $torrents_size  = humn_size($row['torrents_size']);
                         }
   //
   // torrents overall END
   //

   //
   // torrents active
   //
       $sql = " SELECT COUNT(DISTINCT tr.torrent_id) AS active_torrents
                FROM " . BT_TRACKER_TABLE . " tr
                LEFT JOIN " . BT_TORRENTS_TABLE. " tor ON tr.torrent_id = tor.torrent_id
                WHERE tr.expire_time > $cur_time";
                     if ($row = $db->sql_fetchrow($db->sql_query($sql)))
     					 {
                           $torrents_act = ($row['active_torrents']) ? $row['active_torrents'] : 0 ;
                         }
   //
   // torrents active END
   //

   //
   // up, down, total traf
   //

      $sql = " SELECT SUM(u_up_total) AS up, SUM(u_down_total) AS down
               FROM " . BT_USERS_TABLE ;
                   if ($row = $db->sql_fetchrow($db->sql_query($sql)))
     					 {
                            $up = humn_size($row['up']);
                            $down = humn_size($row['down']);
                            $total = humn_size($row['up'] + $row['down']);
                         }
   //
   // up, down, total traf
   //
//
// peer info end
//

//
// assign vars
//
   $template->assign_vars(array(
        'P_PEER'      		   => $peers ,
        'P_SEED'     		   => $seeds,
        'P_LEECH'              => $leechs,
        'T_TORRENTS'           => $torrents,
        'T_TORRENTS_SIZE'  	   => $torrents_size,
        'T_ACT_TORRENTS'   	   => $torrents_act,
        'TR_UP'                => $up,
        'TR_DOWN'              => $down,
        'TR_TRANSFER'          => $total,

        'L_PEER'               => $lang['L_PEER'],
        'L_SEED'               => $lang['L_SEED'],
        'L_LEECH'              => $lang['L_LEECH'],
        'L_TORRENTS'           => $lang['L_TORRENTS'],
        'L_TORRENTS_SIZE'      => $lang['L_TORRENTS_SIZE'],
        'L_ACT_TORRENTS'       => $lang['L_ACT_TORRENTS'],
        'L_UP'                 => $lang['L_UP'],
        'L_DOWN'               => $lang['L_DOWN'],
        'L_TRANSFER'           => $lang['L_TRANSFER'],
        'L_STATS'              => $lang['L_STATS']
        ));

//
// assign vars END
//

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>