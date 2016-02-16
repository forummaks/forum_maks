<?php

define('FT_ROOT', './');
require(FT_ROOT . 'common.php');
require_once(FT_ROOT .'includes/functions_torrent.php');

require_once(FT_ROOT .'includes/functions.php');
require_once(FT_ROOT .'includes/function_sendpm.php');
require_once(FT_ROOT . 'includes/bbcode.php');
require_once(FT_ROOT . 'includes/functions_post.php');

// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$user_id = $userdata['user_id'];
$current_time=time();

// Check if user logged in
if (!$userdata['session_logged_in'])
{
	redirect(append_sid("login.php?redirect=index.php", TRUE));
}

$sid = (isset($_REQUEST['sid'])) ? $_REQUEST['sid'] : '';

// check SID
if ($sid == '' || $sid !== $userdata['session_id'])
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

// Numeric
$input_vars_num = array('attach_id' => 'id', 'req_uid' => 'u');
foreach ($input_vars_num as $var => $param) $$var = (isset($_REQUEST[$param])) ? intval($_REQUEST[$param]) : '';


$sql="SELECT btt.*, f.forum_id, f.forum_name, f.move_enable, u.username as poster_name, t.topic_title
FROM ".BT_TORRENTS_TABLE." btt
JOIN ".USERS_TABLE." u on u.user_id=btt.poster_id
JOIN ".TOPICS_TABLE." t on t.topic_id=btt.topic_id
JOIN ".FORUMS_TABLE." f on f.forum_id=t.forum_id
WHERE btt.attach_id=$attach_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not . . .', '', __LINE__, __FILE__, $sql);
}
$tor_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

$forum_id = $tor_data['forum_id'];
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);



if ( isset($HTTP_POST_VARS['i_edited']) && $userdata['user_id']==$tor_data['poster_id'] && ($tor_data['topic_check_status']=="3" || $tor_data['topic_check_status']=="4") )
{
	$user_from_id=$user_id;
	$user_to_id = $tor_data['topic_check_uid'];
	$user_to_name=get_username($tor_data['topic_check_uid']);
	$pm_subject='”ведомление об исправлении оформлени€ релиза.';
	$pm_message='ѕривет, '.$user_to_name .'. \n\n'. 'я исправил недочеты оформлени€ моего релиза: '.'[url='. FT_ROOT .'/viewtopic.php?t='.$tor_data['topic_id'].']'.$tor_data['topic_title'].'[/url]';
	send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message);

	$sql = "update ".BT_TORRENTS_TABLE." set topic_check_status=1, topic_check_date=$current_time
	WHERE topic_id={$tor_data['topic_id']}";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not ... ', '', __LINE__, __FILE__, $sql);
	}

}

if ( isset($HTTP_POST_VARS['topic_check_status']) || isset($HTTP_GET_VARS['topic_check_status']) )
{
	if (!$is_auth['auth_mod'])
	{
		message_die(GENERAL_ERROR, 'You are not a moderator in this forum.');
	}
	$topic_check_status = ( isset($HTTP_POST_VARS['topic_check_status']) ) ? $HTTP_POST_VARS['topic_check_status'] : $HTTP_GET_VARS['topic_check_status'];

	if ($topic_check_status >0 && $tor_data['topic_check_status']!=$topic_check_status)
	{
		$sql="UPDATE ".BT_TORRENTS_TABLE." SET topic_check_status=$topic_check_status, topic_check_uid=$user_id, topic_check_date=$current_time WHERE topic_id={$tor_data['topic_id']}";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not . . .', '', __LINE__, __FILE__, $sql);
		}
	
		switch ($topic_check_status)
		{
			case 2:
				if ($tor_data['topic_check_first_fid']) 
				{
					require_once(FT_ROOT . 'includes/function_topics_move.php');
					move($forum_id, $tor_data['topic_check_first_fid'], 2, null, $tor_data['topic_id']);
					sync('forum', $tor_data['topic_check_first_fid']);
					sync('forum', $forum_id);
					
				}
			break;
		        case 3: 
				$user_from_id=$user_id;
				$user_to_id = $tor_data['poster_id'];
				$pm_subject='”ведомление о недооформленном релизе.';
				$willmove= ($tor_data['move_enable'])? ' в течение суток, иначе тема будет перенесена в форум неоформленных релизов':'';
				$pm_message='ѕривет, '.$tor_data['poster_name'] .'. \n\n'. '¬аша тема: '.'[url='. FT_ROOT .'/viewtopic.php?t='.$tor_data['topic_id'].']'.$tor_data['topic_title'].'[/url]'. ' создана с нарушением правил оформлени€ релизов форума: '.'[url='. FT_ROOT .'/viewforum.php?f='.$tor_data['forum_id'].']'.$tor_data['forum_name'].'[/url]'. ' в св€зи с этим вам следует исправить недочеты и нажать кнопку "€ исправил"'.$willmove.'. ≈сли у вас возникнут вопросы, вы можете отправить мне личное сообщение.' ;
				send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message);
			break; 
		        case 4:
				if ($tor_data['move_enable'] && empty($tor_data['topic_check_first_fid']))
				{
					require_once(FT_ROOT . 'includes/function_topics_move.php');
					topics_move($forum_id, 4, $tor_data['topic_id']);
				}else{
					$user_from_id=$user_id;
					$user_to_id = $tor_data['poster_id'];
					$pm_subject='”ведомление о неоформленном релизе.';
					if (!empty($tor_data['topic_check_first_fid']))
					{
						$pm_message='ѕривет, '.$tor_data['poster_name'] .'. \n\n'. '¬аша тема: '.'[url='. FT_ROOT .'/viewtopic.php?t='.$tor_data['topic_id'].']'.$tor_data['topic_title'].'[/url]'. ' по прежнему не соответствует правилам оформлени€ релизов. „тобы вернуть тему обратно, вам следует устранить недостатки оформлени€ и нажать кнопку "€ исправил", после этого модератор снова ее проверит и если она будет соответствовать правилам и не будет €вл€тьс€ (на тот момент) повтором, модератор перенес ее обратно о чем вы будете уведомлены.' ;
					}else{
						$pm_message='ѕривет, '.$tor_data['poster_name'] .'. \n\n'. '¬аша тема: '.'[url='. FT_ROOT .'/viewtopic.php?t='.$tor_data['topic_id'].']'.$tor_data['topic_title'].'[/url]'. ' создана с нарушением правил оформлени€ релизов форума: '.'[url='. FT_ROOT .'/viewforum.php?f='.$tor_data['forum_id'].']'.$tor_data['forum_name'].'[/url]'. ' в св€зи с этим вам следует исправить недочеты. ≈сли у вас возникнут вопросы вы можете отправить мне личное собщение.' ;

					}
					send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message);
				}
			break; 
		        case 5:
				if ( isset($HTTP_POST_VARS['duble_tid']) || isset($HTTP_GET_VARS['duble_tid']) ) 
				{
					$duble_tid = ( isset($HTTP_POST_VARS['duble_tid']) ) ? intval($HTTP_POST_VARS['duble_tid']) : intval($HTTP_GET_VARS['duble_tid']);
					$sql="UPDATE ".BT_TORRENTS_TABLE." SET topic_check_duble_tid=$duble_tid WHERE topic_id={$tor_data['topic_id']}";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not . . .', '', __LINE__, __FILE__, $sql);
					}
		
				}
				$sql = "UPDATE " . TOPICS_TABLE . " 
					SET topic_status = " . TOPIC_LOCKED . " 
					WHERE topic_id = {$tor_data['topic_id']} 
						AND forum_id = $forum_id
						AND topic_moved_id = 0";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
				}
	//			require_once($phpbb_root_path .'includes/functions_torrent.'.$phpEx);
	//			tracker_unregister($attach_id);
	
				$user_from_id=$user_id;
				$user_to_id = $tor_data['poster_id'];
				$pm_subject='”ведомление о создании темы-повтор.';
				$pm_duble_topic_link= ($duble_tid)? '[url='. FT_ROOT .'/viewtopic.php?t='.$duble_tid.']этой темы[/url] ' :'';
				$pm_message='ѕривет, '.$tor_data['poster_name'] .'. \n\n'. '¬аша тема: '.'[url='. FT_ROOT .'/viewtopic.php?t='.$tor_data['topic_id'].']'.$tor_data['topic_title'].'[/url]'. ' €вл€етс€ повтором '.$pm_duble_topic_link.'и поэтому будет перенесена в корзину';
				send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message);
	
				break; 
		}
	}

	
}

redirect(append_sid("viewtopic.php?t=".$tor_data['topic_id'], TRUE));