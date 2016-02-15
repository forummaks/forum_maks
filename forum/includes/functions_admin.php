<?php
if (!defined('FT_ROOT')) die(basename(__FILE__));

function make_forum_select($box_name, $ignore_forum = false, $select_forum = '')
{
	global $db;

	$not_auth_forums = user_not_auth_forums(AUTH_VIEW);
	$ignore_forum_sql = ($not_auth_forums) ? "AND f.forum_id NOT IN($not_auth_forums)" : '';

	$sql = 'SELECT c.cat_id, c.cat_title, f.forum_id, f.forum_name, f.forum_parent
		FROM '. FORUMS_TABLE .' f, '. CATEGORIES_TABLE ." c
		WHERE f.cat_id = c.cat_id
			$ignore_forum_sql
		ORDER BY c.cat_order, f.cat_id, f.forum_order";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query cat/forum info', '', __LINE__, __FILE__, $sql);
	}

	if ($rowset = @$db->sql_fetchrowset($result))
	{
		$db->sql_freeresult($result);
		$forum_list = '';

		foreach ($rowset as $rid => $row)
		{
			$cat_forum[$row['cat_id']]['cat_title'] = $row['cat_title'];
			$cat_forum[$row['cat_id']]['f'][$row['forum_id']] = $row;
		}

		foreach ($cat_forum as $cid => $c)
		{
			$forum_list .= '<optgroup label="&nbsp;'. $c['cat_title'] .'">';

			foreach ($c['f'] as $fid => $f)
			{
				$selected = ($f['forum_id'] == $select_forum) ? ' selected="selected"' : '';
				$disabled = ($f['forum_id'] == $ignore_forum) ? ' disabled="disabled"' : '';
				$forum_list .= '<option value="'. $f['forum_id'] .'" '. $selected . $disabled .'>' . (($f['forum_parent']) ? SF_SEL_SPACER : '') . $f['forum_name'] . '</option>';
			}

			$forum_list .= '</optgroup>';
		}
	}
	else
	{
		$forum_list = '<option value="-1">-- ! No Forums ! --</option>';
	}

	return '<select name="'. $box_name .'">'. $forum_list .'</select>';
}

//
// Synchronise functions for forums/topics
//
function sync($type, $id = false)
{
	global $db;

	switch($type)
	{
		case 'all forums':
			$sql = "SELECT forum_id
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get forum IDs', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				sync('forum', $row['forum_id']);
			}
		   	break;

		case 'all topics':
			$sql = "SELECT topic_id
				FROM " . TOPICS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic ID', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				sync('topic', $row['topic_id']);
			}
			break;

	  	case 'forum':
			$sql = "SELECT MAX(post_id) AS last_post, COUNT(post_id) AS total
				FROM " . POSTS_TABLE . "
				WHERE forum_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post ID', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$last_post = ( $row['last_post'] ) ? $row['last_post'] : 0;
				$total_posts = ($row['total']) ? $row['total'] : 0;
			}
			else
			{
				$last_post = 0;
				$total_posts = 0;
			}

			$sql = "SELECT COUNT(topic_id) AS total
				FROM " . TOPICS_TABLE . "
				WHERE forum_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic count', '', __LINE__, __FILE__, $sql);
			}

			$total_topics = ( $row = $db->sql_fetchrow($result) ) ? ( ( $row['total'] ) ? $row['total'] : 0 ) : 0;

			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_last_post_id = $last_post, forum_posts = $total_posts, forum_topics = $total_topics
				WHERE forum_id = $id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update forum', '', __LINE__, __FILE__, $sql);
			}
			break;

		case 'topic':
			$sql = "SELECT MAX(post_id) AS last_post, MIN(post_id) AS first_post, COUNT(post_id) AS total_posts
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post ID', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$sql = ( $row['total_posts'] ) ? "UPDATE " . TOPICS_TABLE . " SET topic_replies = " . ( $row['total_posts'] - 1 ) . ", topic_first_post_id = " . $row['first_post'] . ", topic_last_post_id = " . $row['last_post'] . " WHERE topic_id = $id" : "DELETE FROM " . TOPICS_TABLE . " WHERE topic_id = $id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update topic', '', __LINE__, __FILE__, $sql);
				}
			}
			attachment_sync_topic($id);

			break;
	}

	return true;
}

?>