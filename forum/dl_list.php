<?php

define('IN_FORUM', true);
define('FT_SCRIPT', 'dl_list');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');
require(FT_ROOT .'includes/functions_dl_list.php');

$forum_id = (isset($_REQUEST[POST_FORUM_URL])) ? intval($_REQUEST[POST_FORUM_URL]) : '';
$topic_id = (isset($_REQUEST[POST_TOPIC_URL])) ? intval($_REQUEST[POST_TOPIC_URL]) : '';
$mode = (isset($_REQUEST['mode'])) ? htmlspecialchars($_REQUEST['mode']) : '';
$sid = (isset($_REQUEST['sid'])) ? $_REQUEST['sid'] : '';

// Get new DL-status
if ($mode == 'set_dl_status' || $mode == 'set_topics_dl_status')
{
	if (isset($_POST['dl_set_will']))
	{
		$new_dl_status = DL_STATUS_WILL;
	}
	else if (isset($_POST['dl_set_down']))
	{
		$new_dl_status = DL_STATUS_DOWN;
	}
	else if (isset($_POST['dl_set_complete']))
	{
		$new_dl_status = DL_STATUS_COMPLETE;
	}
	else if (isset($_POST['dl_set_cancel']))
	{
		$new_dl_status = DL_STATUS_CANCEL;
	}
	else
	{
		message_die(GENERAL_ERROR, 'Invalid download status');
	}
}

$confirm = (isset($_POST['confirm'])) ? TRUE : FALSE;

// Define redirect URL
$full_url = (@$_POST['full_url']) ? str_replace('&amp;', '&', htmlspecialchars($_POST['full_url'])) : '';
if (@$_POST['redirect_type'] == 'search')
{
	$redirect_type = "search.php";
	$redirect = ($full_url) ? $full_url : '';
}
else
{
	$redirect_type = (!$topic_id) ? "viewforum.php" : "viewtopic.php";
	$redirect = ($full_url) ? $full_url : ((!$topic_id) ? POST_FORUM_URL ."=$forum_id" : POST_TOPIC_URL ."=$topic_id");
}

// Start session management
$user->session_start();

// Check if user logged in
if (!$userdata['session_logged_in'])
{
	redirect(append_sid("login.php?redirect=$redirect_type&$redirect", true));
}

$user_id = $userdata['user_id'];

// Check if user did not confirm
if (isset($_POST['cancel']))
{
	redirect(append_sid("$redirect_type?$redirect", true));
}

//
// Delete DL-list
//
if ($mode == 'dl_delete' && $topic_id)
{
	if (!$sid || $sid != $userdata['session_id'])
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	// Check if user is auth
	if ($userdata['user_level'] != ADMIN)
	{
		$sql = 'SELECT forum_id
			FROM '. TOPICS_TABLE ."
				WHERE topic_id = $topic_id";

		if (!$row = DB()->sql_fetchrow(DB()->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain forum_id for this topic', '', __LINE__, __FILE__, $sql);
		}

		$is_auth = auth(AUTH_ALL, $row['forum_id'], $userdata);

		if (!$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}
	}

	if (!$confirm)
	{
		$dl_hidden_fields = '<input type="hidden" name="'. POST_TOPIC_URL .'" value="'. $topic_id .'" />';
		$dl_hidden_fields .= '<input type="hidden" name="mode" value="dl_delete" />';
		$dl_hidden_fields .= '<input type="hidden" name="sid" value="'. $userdata['session_id'] .'" />';
		$l_confirm = $lang['DL_List_Del_Confirm'];

		require(FT_ROOT .'includes/page_header.php');

		$template->set_filenames(array('confirm_body' => 'confirm_body.tpl'));

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Information'],
			'MESSAGE_TEXT' => $l_confirm,
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'S_CONFIRM_ACTION' => append_sid("dl_list.php"),
			'S_HIDDEN_FIELDS' => $dl_hidden_fields
		));

		$template->pparse('confirm_body');

		require(FT_ROOT .'includes/page_tail.php');
	}

	clear_dl_list($topic_id);
	update_topics_dl_status($topic_id, 'DL-List deleted');

	redirect(append_sid("$redirect_type?$redirect", true));
}

//
// Update user and topic(s) status
//

// Get selected topics
$topics_ary = array();

if ($mode == 'set_topics_dl_status')
{
	if (!isset($_POST['dl_topics_id_list']))
	{
		message_die(GENERAL_MESSAGE, $lang['None_selected']);
	}

	for($i = 0; $i < count($_POST['dl_topics_id_list']); $i++)
	{
		$topics_ary[] = intval($_POST['dl_topics_id_list'][$i]);
	}
}
else if ($mode == 'set_dl_status')
{
	$topics_ary[] = $topic_id;
}

$current_time = time();
$topics = implode(',', $topics_ary);

//
// Update users DL-status
//
if ($topics && ($mode == 'set_dl_status' || $mode == 'set_topics_dl_status'))
{
	$sql = 'REPLACE INTO '. BT_USR_DL_STAT_TABLE .' (topic_id, user_id, user_status, update_time) VALUES ';

	for ($i=0, $cnt=count($topics_ary); $i < $cnt; $i++)
	{
		$sql .= "($topics_ary[$i], $user_id, $new_dl_status, $current_time)";
		$sql .= ($i != ($cnt - 1)) ? ', ' : '';
	}

	if (!DB()->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not insert user_id for DL-List", '', __LINE__, __FILE__, $sql);
	}

	//
	// Update topics DL-status
	//
	if ($new_dl_status == DL_STATUS_WILL)
	{
		update_topics_dl_status($topics, 'will');
	}
	else if ($new_dl_status == DL_STATUS_DOWN)
	{
		update_topics_dl_status($topics, 'down');
	}
	else if ($new_dl_status == DL_STATUS_COMPLETE)
	{
		update_topics_dl_status($topics, 'complete');
	}
	else if ($new_dl_status == DL_STATUS_CANCEL)
	{
		update_topics_dl_status($topics, 'cancel');
	}

	redirect(append_sid("$redirect_type?$redirect", true));
}

redirect(append_sid("index.php", true));
