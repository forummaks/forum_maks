<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

function send_pm($user_from_id, $user_to_id, $pm_subject, $pm_message)
{
	global $ft_cfg, $lang, $db;
	
	$sql = "SELECT *
		FROM " . USERS_TABLE . " 
		WHERE user_id = " . $user_to_id . "
		AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, $lang['non_existing_user'], '', __LINE__, __FILE__, $sql);
	}
	$usertodata = $db->sql_fetchrow($result);

	// prepare pm message
	$bbcode_uid = make_bbcode_uid();

	$pm_message = prepare_message($pm_message, 0, 1, 1, $bbcode_uid);


	$msg_time = time();

	// Do inbox limit stuff
	$sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time 
		FROM " . PRIVMSGS_TABLE . " 
		WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
			OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "  
			OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " ) 
			AND privmsgs_to_userid = " . $usertodata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_such_user']);
	}

	$sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

	if ( $inbox_info = $db->sql_fetchrow($result) )
	{
		if ( $inbox_info['inbox_items'] >= $ft_cfg['max_inbox_privmsgs'] )
		{
			$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . " 
				WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
					OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
					OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  ) 
					AND privmsgs_date = " . $inbox_info['oldest_post_time'] . " 
					AND privmsgs_to_userid = " . $usertodata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, $lang['not_delete_pm'], '', __LINE__, __FILE__, $sql);
			}
		}
	}

	$sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
		VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $pm_subject) . "', " . $user_from_id . ", " . $usertodata['user_id'] . ", $msg_time, '$user_ip', 0, 1, 1, 1)";

	if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
	{
		message_die(GENERAL_ERROR, $lang['no_sent_pm_insert'], "", __LINE__, __FILE__, $sql_info);
	}

	$privmsg_sent_id = $db->sql_nextid();

	$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
		VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $pm_message) . "')";

	if ( !$db->sql_query($sql, END_TRANSACTION) )
	{
		message_die(GENERAL_ERROR, $lang['no_sent_pm_insert'], "", __LINE__, __FILE__, $sql_info);
	}

	// Add to the users new pm counter
	$sql = "UPDATE " . USERS_TABLE . "
		SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . "
		WHERE user_id = " . $usertodata['user_id']; 
	if ( !$status = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, $lang['no_sent_pm_insert'], '', __LINE__, __FILE__, $sql);
	}


	return;
}