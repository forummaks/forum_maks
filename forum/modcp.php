<?php
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');
require(FT_ROOT . 'includes/bbcode.php');
require(FT_ROOT . 'includes/functions_admin.php');

//
// Obtain initial var settings
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = (isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}
else
{
	$forum_id = '';
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
{
	$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = '';
}

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_POST_VARS[POST_TOPIC_URL]) )
{
	$topic_id = (isset($HTTP_POST_VARS[POST_TOPIC_URL])) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else
{
	$topic_id = '';
}

$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : 0;

//
// Continue var definitions
//
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

$delete = ( isset($HTTP_POST_VARS['delete']) ) ? TRUE : FALSE;
$move = ( isset($HTTP_POST_VARS['move']) ) ? TRUE : FALSE;
$lock = ( isset($HTTP_POST_VARS['lock']) ) ? TRUE : FALSE;
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	if ( $delete )
	{
		$mode = 'delete';
	}
	else if ( $move )
	{
		$mode = 'move';
	}
	else if ( $lock )
	{
		$mode = 'lock';
	}
	else if ( $unlock )
	{
		$mode = 'unlock';
	}
	else
	{
		$mode = '';
	}
}

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Obtain relevant data
//
if ( !empty($topic_id) )
{
	//bt :: add [, t.topic_poster, f.self_moderated]
	//mpd :: add [, t.topic_first_post_id]
	$sql = "SELECT f.forum_id, f.forum_name, f.forum_topics, t.topic_first_post_id, t.topic_poster, f.self_moderated
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE t.topic_id = " . $topic_id . "
			AND f.forum_id = t.forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_id = $topic_row['forum_id'];
	$forum_name = $topic_row['forum_name'];
}
else if ( !empty($forum_id) )
{
	$sql = "SELECT forum_name, forum_topics
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = " . $forum_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_name = $topic_row['forum_name'];
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

// session id check
if ($sid == '' || $sid != $userdata['session_id'])
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

//
// Check if user did or did not confirm
// If they did not, forward them to the last page they were on
//
if ( isset($HTTP_POST_VARS['cancel']) )
{
	if ( $topic_id )
	{
		$redirect = "viewtopic.php?" . POST_TOPIC_URL . "=$topic_id";
	}
	else if ( $forum_id )
	{
		$redirect = "viewforum.php?" . POST_FORUM_URL . "=$forum_id";
	}
	else
	{
		$redirect = "index.php";
	}

	redirect(append_sid($redirect, true));
}

//
// Start auth check
//
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

// перенос темы в другой форум если юзер является автором темы и выбран соотв. форум
//bt
$is_auth_move = FALSE;
if ($is_auth['auth_mod'] || ($mode == 'move' && $topic_id && $userdata['session_logged_in'] && $topic_row['topic_poster'] == $userdata['user_id'] && $topic_row['self_moderated']))
{
	$is_auth_move = TRUE;
}

//if (!$is_auth['auth_mod'])
if (!$is_auth['auth_mod'] && !$is_auth_move)
//bt end
{
	message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
}

//
// End Auth Check
//

//
// Do major work ...
//
switch( $mode )
{
	case 'delete':
		if (!$is_auth['auth_delete'])
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));
		}

		$page_title = $lang['Mod_CP'];
		require(FT_ROOT . 'includes/page_header.php');

		if ( $confirm )
		{
			require(FT_ROOT . 'includes/functions_search.php');

			$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

			$topic_id_sql = '';
			for($i = 0; $i < count($topics); $i++)
			{
				$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
			}

			$sql = "SELECT topic_id
				FROM " . TOPICS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic id information', '', __LINE__, __FILE__, $sql);
			}

			$topic_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$topic_id_sql .= (($topic_id_sql != '') ? ', ' : '') . intval($row['topic_id']);
			}
			$db->sql_freeresult($result);

			$sql = "SELECT poster_id, COUNT(post_id) AS posts
				FROM " . POSTS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)
				GROUP BY poster_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
			}

			$count_sql = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$count_sql[] = "UPDATE " . USERS_TABLE . "
					SET user_posts = user_posts - " . $row['posts'] . "
					WHERE user_id = " . $row['poster_id'];
			}
			$db->sql_freeresult($result);

			if ( sizeof($count_sql) )
			{
				for($i = 0; $i < sizeof($count_sql); $i++)
				{
					if ( !$db->sql_query($count_sql[$i]) )
					{
						message_die(GENERAL_ERROR, 'Could not update user post count information', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$sql = "SELECT post_id
				FROM " . POSTS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
			}

			$post_id_sql = '';
			while ( $row = $db->sql_fetchrow($result) )
			{
				$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . intval($row['post_id']);
			}
			$db->sql_freeresult($result);

			$sql = "SELECT vote_id
				FROM " . VOTE_DESC_TABLE . "
				WHERE topic_id IN ($topic_id_sql)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get vote id information', '', __LINE__, __FILE__, $sql);
			}

			$vote_id_sql = '';
			while ( $row = $db->sql_fetchrow($result) )
			{
				$vote_id_sql .= ( ( $vote_id_sql != '' ) ? ', ' : '' ) . $row['vote_id'];
			}
			$db->sql_freeresult($result);

			//
			// Got all required info so go ahead and start deleting everything
			//
			$sql = "DELETE
				FROM " . TOPICS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)
					OR topic_moved_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete topics', '', __LINE__, __FILE__, $sql);
			}

			//bt
			$sql = 'DELETE FROM '. BT_USR_DL_STAT_TABLE ."
				WHERE topic_id IN($topic_id_sql)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete downloads', '', __LINE__, __FILE__, $sql);
			}
			//bt end

			if ( $post_id_sql != '' )
			{
				$sql = "DELETE
					FROM " . POSTS_TABLE . "
					WHERE post_id IN ($post_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete posts', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE
					FROM " . POSTS_TEXT_TABLE . "
					WHERE post_id IN ($post_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete posts text', '', __LINE__, __FILE__, $sql);
				}

				remove_search_post($post_id_sql);
				delete_attachment(explode(', ', $post_id_sql));

			}

			if ( $vote_id_sql != '' )
			{
				$sql = "DELETE
					FROM " . VOTE_DESC_TABLE . "
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote descriptions', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE
					FROM " . VOTE_RESULTS_TABLE . "
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote results', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE
					FROM " . VOTE_USERS_TABLE . "
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote users', '', __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE
				FROM " . TOPICS_WATCH_TABLE . "
				WHERE topic_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql, END_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete watched post list', '', __LINE__, __FILE__, $sql);
			}

			sync('forum', $forum_id);

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewforum.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_forum'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $lang['Topics_Removed'] . '<br /><br />' . $l_redirect);
		}
		else
		{
			// Not confirmed, show confirmation message
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];
				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			//
			// Set template files
			//
			$template->set_filenames(array(
				'confirm' => 'confirm_body.tpl')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_delete_topic'],

				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'S_CONFIRM_ACTION' => append_sid("modcp.php"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			$template->pparse('confirm');

			require(FT_ROOT . 'includes/page_tail.php');
		}
		break;

	case 'move':
		$page_title = $lang['Mod_CP'];
		require(FT_ROOT . 'includes/page_header.php');

		if ( $confirm )
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$new_forum_id = intval($HTTP_POST_VARS['new_forum']);
			$old_forum_id = $forum_id;

			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $new_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}

			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}

			$db->sql_freeresult($result);

			if ( $new_forum_id != $old_forum_id )
			{
				$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

				$topic_list = '';
				for($i = 0; $i < count($topics); $i++)
				{
					$topic_list .= ( ( $topic_list != '' ) ? ', ' : '' ) . intval($topics[$i]);
				}

				$sql = "SELECT *
					FROM " . TOPICS_TABLE . "
					WHERE topic_id IN ($topic_list)
						AND forum_id = $old_forum_id
						AND topic_status <> " . TOPIC_MOVED;
				if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from topic table', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);

				//bt
				// Update users DL-status 'update_time'
				$dl_topics_sql = array();

				for ($i=0, $cnt=count($row); $i < $cnt; $i++)
				{
					if ($row[$i]['topic_dl_type'] == TOPIC_DL_TYPE_DL)
					{
						$dl_topics_sql[] = $row[$i]['topic_id'];
					}
				}

				if ($dl_topics_sql = implode(',', $dl_topics_sql))
				{
					$sql = 'UPDATE '. BT_USR_DL_STAT_TABLE .'
						SET update_time = '. time() ."
						WHERE topic_id IN($dl_topics_sql)
							AND user_status IN(". DL_STATUS_WILL .','. DL_STATUS_DOWN .')';

					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update users DL-status', '', __LINE__, __FILE__, $sql);
					}
				}
				//bt end

				for($i = 0; $i < count($row); $i++)
				{
					$topic_id = $row[$i]['topic_id'];

					if ( isset($HTTP_POST_VARS['move_leave_shadow']) )
					{
						// Insert topic in the old forum that indicates that the forum has moved.
						$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
							VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
						}
					}

					$sql = "UPDATE " . TOPICS_TABLE . "
						SET forum_id = $new_forum_id
						WHERE topic_id = $topic_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update old topic', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . POSTS_TABLE . "
						SET forum_id = $new_forum_id
						WHERE topic_id = $topic_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}

					//bot
					if (isset($_POST['insert_msg']) || !$is_auth['auth_mod'])
					{
						require_once(FT_ROOT . 'includes/functions_post.php');
						insert_post('after_move', $topic_id, $new_forum_id, $old_forum_id);
					}
					//bot end
				}

				// Sync the forum indexes
				sync('forum', $new_forum_id);
				sync('forum', $old_forum_id);

				$message = $lang['Topics_Moved'] . '<br /><br />';

			}
			else
			{
				$message = $lang['No_Topics_Moved'] . '<br /><br />';
			}

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];

				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			//
			// Set template files
			//
			// если юзер не модератор переносит свой топик - то не показывать "оставить ссылку"
			//bt
			if ($is_auth['auth_mod'])
			{
				$template->assign_block_vars('switch_show_leaveshadow', array());
			}
			//bt end

			//bot
			if ($is_auth['auth_mod'])
			{
				$template->assign_block_vars('switch_show_leave_msg', array());
				$template->assign_vars(array('L_LEAVE_MSG' => $lang['Bot_leave_msg_moved']));
			}
			//bot end

			$template->set_filenames(array(
				'movetopic' => 'modcp_move.tpl')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_move_topic'],

				'L_MOVE_TO_FORUM' => $lang['Move_to_forum'],
				'L_LEAVESHADOW' => $lang['Leave_shadow_topic'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'S_FORUM_SELECT' => make_forum_select('new_forum', $forum_id),
				'S_MODCP_ACTION' => append_sid("modcp.php"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			$template->pparse('movetopic');

			require(FT_ROOT . 'includes/page_tail.php');
		}
		break;

	case 'lock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . "
			SET topic_status = " . TOPIC_LOCKED . "
			WHERE topic_id IN ($topic_id_sql)
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Locked'] . '<br /><br />' . $message);

		break;

	case 'unlock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != "") ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . "
			SET topic_status = " . TOPIC_UNLOCKED . "
			WHERE topic_id IN ($topic_id_sql)
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Unlocked'] . '<br /><br />' . $message);

		break;

		//bt
		// Set or unset topics DL-type
		case 'set_download':
		case 'unset_download':
		if (empty($_POST['topic_id_list']) && empty($topic_id))
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = (isset($_POST['topic_id_list'])) ? $_POST['topic_id_list'] : array($topic_id);
		$topic_id_sql = '';

		for($i=0, $cnt=count($topics); $i < $cnt; $i++)
		{
			$topic_id_sql .= (($topic_id_sql) ? ',' : '') . intval($topics[$i]);
		}

		$topic_dl_type = ($mode == 'set_download') ? TOPIC_DL_TYPE_DL : TOPIC_DL_TYPE_NORMAL;

		$sql = 'UPDATE '. TOPICS_TABLE ." SET
				topic_dl_type = $topic_dl_type
			WHERE topic_id IN($topic_id_sql)
				AND forum_id = $forum_id
				AND topic_moved_id = 0";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ($mode == 'unset_download')
		{
			require_once(FT_ROOT .'includes/functions_dl_list.php');
			clear_dl_list($topic_id);
			update_topics_dl_status($topic_id, 'DL-List deleted');
		}

		if (!empty($topic_id))
		{
			$redirect_page = "viewtopic.php?". POST_TOPIC_URL ."=$topic_id&amp;sid=". $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="'. $redirect_page .'">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.php?". POST_FORUM_URL ."=$forum_id&amp;sid=". $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="'. $redirect_page .'">', '</a>');
		}

		$message = $message .'<br \><br \>'. sprintf($lang['Click_return_forum'], '<a href="'."viewforum.php?". POST_FORUM_URL ."=$forum_id&amp;sid=". $userdata['session_id'] .'">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url='. $redirect_page .'">')
		);

		$msg = ($mode == 'set_download') ? $lang['Topics_Down_Sets'] : $lang['Topics_Down_Unsets'];

		message_die(GENERAL_MESSAGE, $msg .'<br /><br />'. $message);

		break;
		//bt end

	case 'split':
		$page_title = $lang['Mod_CP'];
		require(FT_ROOT . 'includes/page_header.php');

		//mpd
		$delete_posts = (isset($_POST['delete_posts'])) ? TRUE : FALSE;
		$split = (isset($_POST['split_type_all']) || isset($_POST['split_type_beyond'])) ? TRUE : FALSE;
		$posts = (isset($_POST['post_id_list'])) ? $_POST['post_id_list'] : array();
		$start = /* (isset($_POST['start'])) ? intval($_POST['start']) : */ 0;
		$topic_first_post_id = (isset($topic_row['topic_first_post_id'])) ? $topic_row['topic_first_post_id'] : '';

		$post_id_sql = $req_post_id_sql = array();

		if (($split || $delete_posts) && ($posts && $topic_id && $forum_id && $topic_first_post_id) && $confirm)
		{
			foreach ($posts as $post_id)
			{
				if ($pid = intval($post_id))
				{
					$req_post_id_sql[] = $pid;
				}
			}

			if ($req_post_id_sql = implode(',', $req_post_id_sql))
			{
				$sql = 'SELECT post_id
					FROM '. POSTS_TABLE ."
					WHERE post_id IN($req_post_id_sql)
						AND post_id != $topic_first_post_id
						AND topic_id = $topic_id
						AND forum_id = $forum_id";

				if (!$rowset = @$db->sql_fetchrowset($db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
				}

				foreach ($rowset as $rid => $row)
				{
					$post_id_sql[] = $row['post_id'];
				}
				$post_id_sql = implode(',', $post_id_sql);
			}
		}

		if ($post_id_sql && $split)
		//mpd end
		{
			$sql = "SELECT post_id, poster_id, topic_id, post_time
				FROM " . POSTS_TABLE . "
				WHERE post_id IN ($post_id_sql)
				ORDER BY post_time ASC";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$first_poster = $row['poster_id'];
				$topic_id = $row['topic_id'];
				$post_time = $row['post_time'];

				$user_id_sql = '';
				$post_id_sql = '';
				do
				{
					$user_id_sql .= (($user_id_sql != '') ? ', ' : '') . intval($row['poster_id']);
					$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($row['post_id']);;
				}
				while ($row = $db->sql_fetchrow($result));

				$post_subject = trim(htmlspecialchars($HTTP_POST_VARS['subject']));
				if (empty($post_subject))
				{
					message_die(GENERAL_MESSAGE, $lang['Empty_subject']);
				}

				$new_forum_id = intval($HTTP_POST_VARS['new_forum_id']);
				$topic_time = time();

				$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . $new_forum_id;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
				}

				if (!$db->sql_fetchrow($result))
				{
					message_die(GENERAL_MESSAGE, 'New forum does not exist');
				}

				$db->sql_freeresult($result);

				$sql  = "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type)
					VALUES ('" . str_replace("\'", "''", $post_subject) . "', $first_poster, " . $topic_time . ", $new_forum_id, " . TOPIC_UNLOCKED . ", " . POST_NORMAL . ")";
				if (!($db->sql_query($sql, BEGIN_TRANSACTION)))
				{
					message_die(GENERAL_ERROR, 'Could not insert new topic', '', __LINE__, __FILE__, $sql);
				}

				$new_topic_id = $db->sql_nextid();

				// Update topic watch table, switch users whose posts
				// have moved, over to watching the new topic
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . "
					SET topic_id = $new_topic_id
					WHERE topic_id = $topic_id
						AND user_id IN ($user_id_sql)";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not update topics watch table', '', __LINE__, __FILE__, $sql);
				}

				$sql_where = (!empty($HTTP_POST_VARS['split_type_beyond'])) ? " post_time >= $post_time AND topic_id = $topic_id" : "post_id IN ($post_id_sql)";

				$sql = 	"UPDATE " . POSTS_TABLE . "
					SET topic_id = $new_topic_id, forum_id = $new_forum_id
					WHERE $sql_where";
				if (!$db->sql_query($sql, END_TRANSACTION))
				{
					message_die(GENERAL_ERROR, 'Could not update posts table', '', __LINE__, __FILE__, $sql);
				}

				//bot
				if (isset($_POST['after_split_to_old']))
				{
					require_once(FT_ROOT . 'includes/functions_post.php');
					insert_post('after_split_to_old', $topic_id, $forum_id, '', $new_topic_id, str_replace("\'", "''", $post_subject));
				}
				if (isset($_POST['after_split_to_new']))
				{
					require_once(FT_ROOT . 'includes/functions_post.php');
					insert_post('after_split_to_new', $new_topic_id, $new_forum_id, $forum_id, $new_topic_id, '', $topic_id);
				}
				//bot end

				sync('topic', $new_topic_id);
				sync('topic', $topic_id);
				sync('forum', $new_forum_id);
				sync('forum', $forum_id);

				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . "viewtopic.php?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'] . '">')
				);

				//bot
				$message = $lang['Topic_split'] .'<br /><br /><a href="' . "viewtopic.php?". POST_TOPIC_URL ."=$topic_id&amp;sid=". $userdata['session_id'] .'">'. $lang['Topic_split_old'] .'</a>';
				$message .= ' &nbsp;::&nbsp; <a href="' . "viewtopic.php?". POST_TOPIC_URL ."=$new_topic_id&amp;sid=". $userdata['session_id'] .'">'. $lang['Topic_split_new'] .'</a>';
				//bot end
				message_die(GENERAL_MESSAGE, $message);
			}
		}
		//mpd
		else if ($post_id_sql && $delete_posts)
		{
			if (!$is_auth['auth_delete'])
			{
				message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));
			}
			require(FT_ROOT .'includes/functions_search.php');

			$sql = 'SELECT poster_id, COUNT(post_id) AS posts
				FROM '. POSTS_TABLE ."
				WHERE post_id IN($post_id_sql)
				GROUP BY poster_id";

			if (!$result = $db->sql_query($sql, BEGIN_TRANSACTION))
			{
				message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
			}

			$count_sql = array();

			while ($row = $db->sql_fetchrow($result))
			{
				$count_sql[] = 'UPDATE '. USERS_TABLE ." SET
						user_posts = user_posts - {$row['posts']}
					WHERE user_id = {$row['poster_id']}";
			}
			$db->sql_freeresult($result);

			if ($count_sql)
			{
				foreach ($count_sql as $sql)
				{
					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update user post count information', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$sql = 'DELETE FROM '. POSTS_TABLE ."
				WHERE post_id IN($post_id_sql)";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete posts', '', __LINE__, __FILE__, $sql);
			}

			$sql = 'DELETE FROM '. POSTS_TEXT_TABLE ."
				WHERE post_id IN($post_id_sql)";

			if (!$db->sql_query($sql, END_TRANSACTION))
			{
				message_die(GENERAL_ERROR, 'Could not delete posts text', '', __LINE__, __FILE__, $sql);
			}

			if (@function_exists('delete_attachment'))
			{
				delete_attachment(explode(',', $post_id_sql));
			}
			remove_search_post($post_id_sql);

			sync('topic', $topic_id);
			sync('forum', $forum_id);

			$template->assign_vars(array('META' => '<meta http-equiv="refresh" content="10;url="viewtopic.php?'. POST_TOPIC_URL ."=$topic_id&amp;sid=". $userdata['session_id'] .'&amp;start='. $start .'">'));

			$message = $lang['Delete_posts_succesfully'] .'<br /><br />'. sprintf($lang['Click_return_topic'], '<a href="viewtopic.php?'. POST_TOPIC_URL ."=$topic_id&amp;sid=". $userdata['session_id'] .'&amp;start='. $start .'">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		//mpd end
		else
		{
			//
			// Set template files
			//
			$template->set_filenames(array(
				'split_body' => 'modcp_split.tpl')
			);

			$sql = "SELECT u.username, p.*, pt.post_text, pt.bbcode_uid, pt.post_subject, p.post_username
				FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
				WHERE p.topic_id = $topic_id
					AND p.poster_id = u.user_id
					AND p.post_id = pt.post_id
				ORDER BY p.post_time ASC";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic/post information', '', __LINE__, __FILE__, $sql);
			}

			$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" /><input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" /><input type="hidden" name="mode" value="split" />';

			if( ( $total_posts = $db->num_rows($result) ) > 0 )
			{
				$postrow = $db->sql_fetchrowset($result);

				$template->assign_vars(array(
					'L_SPLIT_TOPIC' => $lang['Split_Topic'],
					'L_SPLIT_TOPIC_EXPLAIN' => $lang['Split_Topic_explain'],
					'L_AUTHOR' => $lang['Author'],
					'L_MESSAGE' => $lang['Message'],
					'L_SELECT' => $lang['Select'],
					'L_SPLIT_SUBJECT' => $lang['Split_title'],
					'L_SPLIT_FORUM' => $lang['Split_forum'],
					'L_POSTED' => $lang['Posted'],
					'L_SPLIT_POSTS' => $lang['Split_posts'],
					'L_SUBMIT' => $lang['Submit'],
					'L_SPLIT_AFTER' => $lang['Split_after'],
					'L_POST_SUBJECT' => $lang['Post_subject'],
					'L_MARK_ALL' => $lang['Mark_all'],
					'L_UNMARK_ALL' => $lang['Unmark_all'],
					'L_POST' => $lang['Post'],

					//mpd
					'L_DELETE_POSTS' => $lang['Delete_posts'],
					//mpd end

					'FORUM_NAME' => $forum_name,

					'U_VIEW_FORUM' => append_sid("viewforum.php?" . POST_FORUM_URL . "=$forum_id"),

					//bot
					'L_AFTER_SPLIT_TO_OLD' => $lang['Bot_after_split_to_old'],
					'L_AFTER_SPLIT_TO_NEW' => $lang['Bot_after_split_to_new'],
					//bot end

					'S_SPLIT_ACTION' => append_sid("modcp.php"),
					'S_HIDDEN_FIELDS' => $s_hidden_fields,
					'S_FORUM_SELECT' => make_forum_select("new_forum_id", false, $forum_id))
				);

				//
				// Define censored word matches
				//
				$j = 0;
				$orig_word = array();
				$replacement_word = array();
				obtain_word_list($orig_word, $replacement_word);

				for($i = 0; $i < $total_posts; $i++)
				{
					$post_id = $postrow[$i]['post_id'];
					$poster_id = $postrow[$i]['poster_id'];
					$poster = $postrow[$i]['username'];

					$post_date = create_date($ft_cfg['default_dateformat'], $postrow[$i]['post_time'], $ft_cfg['board_timezone']);

					$bbcode_uid = $postrow[$i]['bbcode_uid'];
					$message = $postrow[$i]['post_text'];
					$post_subject = ( isset($postrow[$i]['post_subject']) ) ? $postrow[$i]['post_subject'] : $topic_title;

					//
					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone
					//
					//bot
					if (!$ft_cfg['allow_html'] && $poster_id != BOT_UID)
					//bot end
					{
						if ( $postrow[$i]['enable_html'] )
						{
							$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&lt;\\2&gt;', $message);
						}
					}

					if ( $bbcode_uid != '' )
					{
						$message = ( $ft_cfg['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
					}

					if ( count($orig_word) )
					{
						$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
						$message = preg_replace($orig_word, $replacement_word, $message);
					}

					$message = make_clickable($message);

					if ( $ft_cfg['allow_smilies'] && $postrow[$i]['enable_smilies'] )
					{
						$message = smilies_pass($message);
					}

					$message = str_replace("\n", '<br />', $message);

					$template->assign_block_vars('postrow', array(
						'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
						'POSTER_NAME' => $poster,
						'POST_DATE' => $post_date,
						'POST_SUBJECT' => $post_subject,
						'MESSAGE' => $message,

						'CHECKBOX' => (defined('BEGIN_CHECKBOX')) ? TRUE : FALSE,
						'POST_ID'  => $post_id,
						'ROW_ID'   => $i,
						'CB_ID'    => 'cb_'. $i
					));

					if ($post_id == $topic_first_post_id)
					{
						define('BEGIN_CHECKBOX', TRUE);
					}
				}

				$template->pparse('split_body');
			}
		}
		break;

	case 'ip':
		$page_title = $lang['Mod_CP'];
		require(FT_ROOT . 'includes/page_header.php');

		$rdns_ip_num = ( isset($HTTP_GET_VARS['rdns']) ) ? $HTTP_GET_VARS['rdns'] : "";

		if ( !$post_id )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		//
		// Set template files
		//
		$template->set_filenames(array(
			'viewip' => 'modcp_viewip.tpl')
		);

		// Look up relevent data for this post
		$sql = "SELECT poster_ip, poster_id
			FROM " . POSTS_TABLE . "
			WHERE post_id = $post_id
				AND forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster IP information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($post_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		$ip_this_post = decode_ip($post_row['poster_ip']);
		$ip_this_post = ( $rdns_ip_num == $ip_this_post ) ? gethostbyaddr($ip_this_post) : $ip_this_post;

		$poster_id = $post_row['poster_id'];

		$template->assign_vars(array(
			'L_IP_INFO' => $lang['IP_info'],
			'L_THIS_POST_IP' => $lang['This_posts_IP'],
			'L_OTHER_IPS' => $lang['Other_IP_this_user'],
			'L_OTHER_USERS' => $lang['Users_this_IP'],
			'L_LOOKUP_IP' => $lang['Lookup_IP'],
			'L_SEARCH' => $lang['Search'],

			'SEARCH_IMG' => $images['icon_search'],

			'IP' => $ip_this_post,

			'U_LOOKUP_IP' => "modcp.php?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=$ip_this_post&amp;sid=" . $userdata['session_id'])
		);

		//
		// Get other IP's this user has posted under
		//
		$sql = "SELECT poster_ip, COUNT(*) AS postings
			FROM " . POSTS_TABLE . "
			WHERE poster_id = $poster_id
			GROUP BY poster_ip
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get IP information for this user', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				if ( $row['poster_ip'] == $post_row['poster_ip'] )
				{
					$template->assign_vars(array(
						'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ))
					);
					continue;
				}

				$ip = decode_ip($row['poster_ip']);
				$ip = ( $rdns_ip_num == $row['poster_ip'] || $rdns_ip_num == 'all') ? gethostbyaddr($ip) : $ip;

				$template->assign_block_vars('iprow', array(
						'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
					'IP' => $ip,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),

					'U_LOOKUP_IP' => "modcp.php?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=" . $row['poster_ip'] . "&amp;sid=" . $userdata['session_id'])
				);

				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		//
		// Get other users who've posted under this IP
		//
		$sql = "SELECT u.user_id, u.username, COUNT(*) as postings
			FROM " . USERS_TABLE ." u, " . POSTS_TABLE . " p
			WHERE p.poster_id = u.user_id
				AND p.poster_ip = '" . $post_row['poster_ip'] . "'
			GROUP BY u.user_id, u.username
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get posters information based on IP', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$id = $row['user_id'];
				$username = ( $id == ANONYMOUS ) ? $lang['Guest'] : $row['username'];

				$template->assign_block_vars('userrow', array(
						'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
					'USERNAME' => $username,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),
					'L_SEARCH_POSTS' => sprintf($lang['Search_user_posts'], $username),

					'U_PROFILE' => ($id == ANONYMOUS) ? "modcp.php?mode=ip&amp;" . POST_POST_URL . "=" . $post_id . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'] : append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=$id"),
					'U_SEARCHPOSTS' => append_sid("search.php?search_author=" . urlencode($username) . "&amp;showresults=topics"))
				);

				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$template->pparse('viewip');

		break;

	default:
		$page_title = $lang['Mod_CP'];
		require(FT_ROOT . 'includes/page_header.php');

		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,

			'L_MOD_CP' => $lang['Mod_CP'],
			'L_MOD_CP_EXPLAIN' => $lang['Mod_CP_explain'],
			'L_SELECT' => $lang['Select'],
			'L_DELETE' => $lang['Delete'],
			'L_MOVE' => $lang['Move'],
			'L_LOCK' => $lang['Lock'],
			'L_UNLOCK' => $lang['Unlock'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_LASTPOST' => $lang['Last_Post'],
			'L_SELECT' => $lang['Select'],

			'U_VIEW_FORUM' => append_sid("viewforum.php?" . POST_FORUM_URL . "=$forum_id"),
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />',
			'S_MODCP_ACTION' => append_sid("modcp.php"),
		));

		$template->set_filenames(array(
			'body' => 'modcp_body.tpl')
		);
		make_jumpbox('modcp.php');

		//
		// Define censored word matches
		//
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);

		$sql = "SELECT t.*, u.username, u.user_id, p.post_time
			FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p
			WHERE t.forum_id = $forum_id
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_last_post_id
			ORDER BY t.topic_type DESC, p.post_time DESC
			LIMIT $start, " . $ft_cfg['topics_per_page'];
		if ( !($result = $db->sql_query($sql)) )
		{
	   		message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_title = '';

			if ( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder_img = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
			}
			else
			{
				if ( $row['topic_type'] == POST_ANNOUNCE )
				{
					$folder_img = $images['folder_announce'];
					$folder_alt = $lang['Topic_Announcement'];
				}
				else if ( $row['topic_type'] == POST_STICKY )
				{
					$folder_img = $images['folder_sticky'];
					$folder_alt = $lang['Topic_Sticky'];
				}
				//bt
				else if ( $row['topic_dl_type'] == TOPIC_DL_TYPE_DL )
				{
					$folder_img = $images['folder_dl'];
					$folder_alt = 'Download';
				}
				//bt end
				else
				{
					$folder_img = $images['folder'];
					$folder_alt = $lang['No_new_posts'];
				}
			}

			$topic_id = $row['topic_id'];
			$topic_type = $row['topic_type'];
			$topic_status = $row['topic_status'];

			if ( $topic_type == POST_ANNOUNCE )
			{
				$topic_type = $lang['Topic_Announcement'] . ' ';
			}
			else if ( $topic_type == POST_STICKY )
			{
				$topic_type = $lang['Topic_Sticky'] . ' ';
			}
			else if ( $topic_status == TOPIC_MOVED )
			{
				$topic_type = $lang['Topic_Moved'] . ' ';
			}
			else
			{
				$topic_type = '';
			}

			if ( $row['topic_vote'] )
			{
				$topic_type .= $lang['Topic_Poll'] . ' ';
			}

			$topic_title = $row['topic_title'];
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			$u_view_topic = "modcp.php?mode=split&amp;" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$topic_replies = $row['topic_replies'];

			$last_post_time = create_date($ft_cfg['default_dateformat'], $row['post_time'], $ft_cfg['board_timezone']);

			$template->assign_block_vars('topicrow', array(
				'U_VIEW_TOPIC' => $u_view_topic,

				'TOPIC_FOLDER_IMG' => $folder_img,
				'TOPIC_TYPE' => $topic_type,
				'TOPIC_TITLE' => $topic_title,
				'REPLIES' => $topic_replies,
				'LAST_POST_TIME' => $last_post_time,
				'TOPIC_ID' => $topic_id,
				'TOPIC_ATTACHMENT_IMG' => topic_attachment_image($row['topic_attachment']),

				'L_TOPIC_FOLDER_ALT' => $folder_alt,
			));
		}

		$template->assign_vars(array(
			'PAGINATION' => generate_pagination("modcp.php?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'], $forum_topics, $ft_cfg['topics_per_page'], $start),
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $ft_cfg['topics_per_page'] ) + 1 ), ceil( $forum_topics / $ft_cfg['topics_per_page'] )),
			'L_GOTO_PAGE' => $lang['Goto_page']
		));

		$template->pparse('body');

		break;
}

require(FT_ROOT . 'includes/page_tail.php');