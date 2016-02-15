<?php

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path .'extension.inc');
include($phpbb_root_path .'common.'.$phpEx);
include_once($phpbb_root_path .'includes/functions_torrent.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$user_id = $userdata['user_id'];

// Check if user logged in
if (!$userdata['session_logged_in'])
{
	redirect(append_sid("login.$phpEx?redirect=index.$phpEx", TRUE));
}

$sid = (isset($_REQUEST['sid'])) ? $_REQUEST['sid'] : '';
$confirm = (isset($_POST['confirm'])) ? TRUE : FALSE;

// Set received variables
// Strings
$input_vars_str  = array(
	'mode' => 'mode'
);

// Numeric
$input_vars_num = array(
	'attach_id' => 'id',
	'req_uid' => 'u'
);

// Strings
foreach ($input_vars_str as $var => $param)
{
	$$var = (isset($_REQUEST[$param])) ? $_REQUEST[$param] : '';
}
// Numeric
foreach ($input_vars_num as $var => $param)
{
	$$var = (isset($_REQUEST[$param])) ? intval($_REQUEST[$param]) : '';
}

if (isset($_POST['del_torrent']))
{
	$mode = 'del';
}
else if (isset($_POST['del_torrent_move_topic']))
{
	$mode = 'del_move';
}

if (($mode == 'reg' || $mode == 'unreg' || $mode == 'del' || $mode == 'del_move') && !$attach_id)
{
	message_die(GENERAL_ERROR, 'Invalid attach_id');
}

// Show users torrent-profile
if ($mode == 'userprofile')
{
	redirect(append_sid("profile.$phpEx?mode=viewprofile&u=$req_uid"), TRUE);
}

// check SID
if ($sid == '' || $sid !== $userdata['session_id'])
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

// Register torrent on tracker
if ($mode == 'reg')
{
	tracker_register($attach_id, 'request');
	exit;
}

// Unregister torrent from tracker
if ($mode == 'unreg')
{
	tracker_unregister($attach_id, 'request');
	exit;
}

// Delete torrent
if ($mode == 'del' && $confirm)
{
	delete_torrent($attach_id, 'request');
	$redirect_url = append_sid("viewtopic.$phpEx?".POST_TOPIC_URL."=$topic_id");
	redirect($redirect_url);
}

// Delete torrent and move topic
if ($mode == 'del_move' && $confirm)
{
	delete_torrent($attach_id, 'request');

	$redirect_url = "modcp.$phpEx?".POST_TOPIC_URL."=$topic_id&mode=move&sid=". $userdata['session_id'];
	redirect($redirect_url);
}

// Generate passkey
if ($mode == 'gen_passkey')
{
	if ($req_uid == $user_id || $userdata['user_level'] == ADMIN)
	{
		generate_passkey($req_uid, FALSE);

		if (!defined('AUTH_KEY_INSERT_OK'))
		{
			message_die(GENERAL_ERROR, 'Could not insert passkey', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, $lang['Bt_Gen_Passkey_OK']);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
	}
}

message_die(GENERAL_ERROR, 'Not confirmed or invalid mode');

?>