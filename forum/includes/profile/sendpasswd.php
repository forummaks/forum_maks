<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

if ( isset($HTTP_POST_VARS['submit']) )
{
	$username = ( !empty($HTTP_POST_VARS['username']) ) ? clean_username($HTTP_POST_VARS['username']) : '';
	$email = ( !empty($HTTP_POST_VARS['email']) ) ? trim(strip_tags(htmlspecialchars($HTTP_POST_VARS['email']))) : '';

	$sql = "SELECT user_id, username, user_email, user_active, user_lang
		FROM " . USERS_TABLE . "
		WHERE user_email = '" . str_replace("\'", "''", $email) . "'
			AND username = '" . str_replace("\'", "''", $username) . "'";
	if ( $result = $db->sql_query($sql) )
	{
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( !$row['user_active'] )
			{
				message_die(GENERAL_MESSAGE, $lang['No_send_account_inactive']);
			}

			$username = $row['username'];
			$user_id = $row['user_id'];

			$user_actkey = make_rand_str(true);
			$key_len = 54 - strlen($server_url);
			$key_len = ( $str_len > 6 ) ? $key_len : 6;
			$user_actkey = substr($user_actkey, 0, $key_len);
			$user_password = make_rand_str(false);

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_newpasswd = '" . md5($user_password) . "', user_actkey = '$user_actkey'
				WHERE user_id = " . $row['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update new password information', '', __LINE__, __FILE__, $sql);
			}

			require(FT_ROOT . 'includes/emailer.php');
			$emailer = new emailer($ft_cfg['smtp_delivery']);

			$emailer->from($ft_cfg['board_email']);
			$emailer->replyto($ft_cfg['board_email']);

			$emailer->use_template('user_activate_passwd', $row['user_lang']);
			$emailer->email_address($row['user_email']);
			$emailer->set_subject($lang['New_password_activation']);

			$emailer->assign_vars(array(
				'SITENAME' => $ft_cfg['sitename'],
				'USERNAME' => $username,
				'PASSWORD' => $user_password,
				'EMAIL_SIG' => (!empty($ft_cfg['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $ft_cfg['board_email_sig']) : '',

				'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
			);
			$emailer->send();
			$emailer->reset();

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="15;url=' . append_sid("index.php") . '">')
			);

			$message = $lang['Password_updated'] . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.php") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_email_match']);
		}
	}
	else
	{
		message_die(GENERAL_ERROR, 'Could not obtain user information for sendpassword', '', __LINE__, __FILE__, $sql);
	}
}
else
{
	$username = '';
	$email = '';
}

//
// Output basic page
//
require(FT_ROOT . 'includes/page_header.php');

$template->set_filenames(array(
	'body' => 'profile_send_pass.tpl')
);
make_jumpbox('viewforum.php');

$template->assign_vars(array(
	'USERNAME' => $username,
	'EMAIL' => $email,

	'L_SEND_PASSWORD' => $lang['Send_password'],
	'L_ITEMS_REQUIRED' => $lang['Items_required'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'S_HIDDEN_FIELDS' => '',
	'S_PROFILE_ACTION' => append_sid("profile.php?mode=sendpassword"))
);

$template->pparse('body');

require(FT_ROOT . 'includes/page_tail.php');