<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

require(FT_ROOT . 'includes/functions_search.php');
require_once(FT_ROOT .'includes/function_sendpm.php');
require_once(FT_ROOT . 'includes/bbcode.php');
require_once(FT_ROOT . 'includes/functions_post.php');
require_once(FT_ROOT . 'includes/functions_admin.php');

function move($forum_id, $move_fid, $mode, $waits_days=0, $topic_id=0)
{
	global $db, $lang, $ft_cfg;

	// Before moving, lets try to clean up the invalid topic entries
	$sql = 'SELECT topic_id FROM ' . TOPICS_TABLE . '
		WHERE topic_last_post_id = 0';
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain lists of topics to sync', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		sync('topic', $row['topic_id']);
	}

	$db->sql_freeresult($result);

	switch ($mode)
	{
		case 2: $sql_where=" WHERE btt.topic_id = $topic_id"; break;
		case 3: $sql_where=" WHERE btt.topic_check_date < $waits_days AND btt.topic_check_status=3"; break;
		case 4: $sql_where=" WHERE btt.topic_id = $topic_id"; break;
		case 5: $sql_where=" WHERE btt.topic_check_date < $waits_days AND btt.topic_check_status=5";break;

	}
	$sql = "SELECT btt.*, t.topic_title, f.forum_name, u.username as poster_name
		FROM ".BT_TORRENTS_TABLE." btt
		JOIN ".TOPICS_TABLE." t on t.topic_id=btt.topic_id and t.forum_id=$forum_id
		JOIN ".USERS_TABLE." u on u.user_id=btt.poster_id
		JOIN ".FORUMS_TABLE." f on f.forum_id=t.forum_id";
	$sql.= $sql_where;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain lists of topics to move', '', __LINE__, __FILE__, $sql);
	}

	$sql_topics = '';
	$i=0;
	$send_pm_data=array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$sql_topics .= ( ( $sql_topics != '' ) ? ', ' : '' ) . $row['topic_id'];
		$send_pm_data[$i]=$row;
		$i++;

	}
	$db->sql_freeresult($result);
		
	if( $sql_topics != '')
	{
		$sql = "SELECT post_id
			FROM " . POSTS_TABLE . " 
			WHERE forum_id = $forum_id 
				AND topic_id IN ($sql_topics)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain list of posts to omove', '', __LINE__, __FILE__, $sql);
		}

		$sql_post = '';
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql_post .= ( ( $sql_post != '' ) ? ', ' : '' ) . $row['post_id'];
		}
		$db->sql_freeresult($result);

		if ( $sql_post != '' )
		{

			$sql = "update ".TOPICS_TABLE." set forum_id=$move_fid
				WHERE topic_id IN ($sql_topics)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not move topics during move', '', __LINE__, __FILE__, $sql);
			}
			$move_topics = $db->sql_affectedrows();

			$sql = "update ".POSTS_TABLE." set forum_id=$move_fid
				WHERE post_id IN ($sql_post)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not move post during move', '', __LINE__, __FILE__, $sql);
			}
			$move_posts = $db->sql_affectedrows();
			
			if (in_array($mode, array(2, 3, 4)))
			{			
				switch ($mode)
				{
					case 2:
						$sql = "update ".BT_TORRENTS_TABLE." set topic_check_first_fid=0
							WHERE topic_id IN ($sql_topics)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not ... ', '', __LINE__, __FILE__, $sql);
						}
					break;
					case 3:
					case 4:
						$sql = "update ".BT_TORRENTS_TABLE." set topic_check_status=4, topic_check_first_fid=$forum_id
							WHERE topic_id IN ($sql_topics)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not ... ', '', __LINE__, __FILE__, $sql);
						}
					break;
				}
	
				$script_path = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($ft_cfg['script_path']));
				$server_name = trim($ft_cfg['server_name']);
				$server_protocol = ( $ft_cfg['cookie_secure'] ) ? 'https://' : 'http://';
				$server_port = ( $ft_cfg['server_port'] <> 80 ) ? ':' . trim($ft_cfg['server_port']) . '/' : '/';
				$i=0;
				while( $i < count($send_pm_data) )
				{
					$user_from_id=$send_pm_data[$i]['topic_check_uid'];
					$user_to_id = $send_pm_data[$i]['poster_id'];
					switch ($mode)
					{
						case 2:
							$pm_subject='”ведомление о присвоении статуса "оформлено" дл€ вашего релиза.';
							$pm_message='ѕривет, '.$send_pm_data[$i]['poster_name'].'. \n\n'.'¬аша тема: '.'[url='.$server_protocol.$server_name.$server_port.$script_path.'/viewtopic.php?t='.$send_pm_data[$i]['topic_id'].']'.$send_pm_data[$i]['topic_title'].'[/url]'.', теперь соответствует правилам оформлени€ релизов и была перенесена в соответствующий '.'[url='.$server_protocol.$server_name.$server_port.$script_path.'/viewforum.php?f='.$move_fid.']форум[/url]';
						break;
						case 3:
						case 4:
							$pm_subject='”ведомление о переносе темы в форум неоформленных релизов.';
							$pm_message='ѕривет, '.$send_pm_data[$i]['poster_name'].'. \n\n'.'¬аша тема: '.'[url='.$server_protocol.$server_name.$server_port.$script_path.'/viewtopic.php?t='.$send_pm_data[$i]['topic_id'].']'.$send_pm_data[$i]['topic_title'].'[/url]'.', созданна€ в форуме '.'[url='.$server_protocol.$server_name.$server_port.$script_path.'/viewforum.php?f='.$forum_id.']'.$send_pm_data[$i]['forum_name'].'[/url]'.', была перенесена в форум [url='.$server_protocol.$server_name.$server_port.$script_path.'/viewforum.php?f='.$move_fid.']неоформленных релизов[/url]'.', как не соответствующа€ правилам оформлени€ релизов. ¬ернуть обратно тему вы сможете, после того как оформите тему по правилам и нажмете кнопку "исправил", после этого модератор проверит ее снова и если она будет соответствовать правилам, и не будет €вл€тьс€ повтором(на момент проверки), модератор перенесет ее обратно.';
						break;
					}
					send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message);
					$i++;
		
				}
			}
			return array ('topics' => $move_topics, 'posts' => $move_posts);
		}
	}

	return array('topics' => 0, 'posts' => 0);
}

function topics_move($forum_id, $mode, $topic_id=0, $first_fid=0)
{
	global $db, $lang;

		$sql = "SELECT *
			FROM ".TOPICS_MOVE_TABLE."
			WHERE forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not read move table', '', __LINE__, __FILE__, $sql);
		}

	switch($mode)
	{
		case 3:
	
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['check_freq'] && $row['waits_days'] )
			{
				$waits_days = time() - ( $row['waits_days'] * 86400 );
				$move_next = time() + ( $row['check_freq'] * 86400 );
				$move_fid=$row['move_fid'];
	
				move($forum_id, $move_fid, $mode, $waits_days);
		
				sync('forum', $move_fid);
				sync('forum', $forum_id);
				
	
	
				$sql = "UPDATE " . FORUMS_TABLE . " 
					SET move_next = $move_next 
					WHERE forum_id = $forum_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forum table', '', __LINE__, __FILE__, $sql);
				}
			}
	
		}
		break;
		case 4:
			$move_fid=0;
			if ( $row = $db->sql_fetchrow($result) )
			{
				$move_fid=$row['move_fid'];	
			}
			move($forum_id, $move_fid, $mode, null, $topic_id);
			sync('forum', $move_fid);
			sync('forum', $forum_id);
			
		break;
		case 5:
	
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['recycle_check_freq'] && $row['recycle_waits_days'] )
			{
				$recycle_waits_days = time() - ( $row['recycle_waits_days'] * 86400 );
				$recycle_move_next = time() + ( $row['recycle_check_freq'] * 86400 );
				$recycle_move_fid=$row['recycle_move_fid'];
	
				move($forum_id, $recycle_move_fid, $mode, $recycle_waits_days);
		
				sync('forum', $recycle_move_fid);
				sync('forum', $forum_id);
				
	
	
				$sql = "UPDATE " . FORUMS_TABLE . " 
					SET recycle_move_next = $recycle_move_next 
					WHERE forum_id = $forum_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forum table', '', __LINE__, __FILE__, $sql);
				}
			}
	
		}
		break;


	}

	return;
}