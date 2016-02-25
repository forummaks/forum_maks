<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$sql = "SELECT user_active, user_id, username, user_email, user_newpasswd, user_lang, user_actkey 
	FROM " . USERS_TABLE . "
	WHERE user_id = " . intval($HTTP_GET_VARS[POST_USERS_URL]);
if ( !($result = DB()->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
}

if ( $row = DB()->sql_fetchrow($result) )
{
	if ( $row['user_active'] && trim($row['user_actkey']) == '' )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid("index.php") . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Already_activated']);
	}
	else if ((trim($row['user_actkey']) == trim($HTTP_GET_VARS['act_key'])) && (trim($row['user_actkey']) != ''))
	{
		if (intval($ft_cfg['require_activation']) == USER_ACTIVATION_ADMIN && $userdata['user_level'] != ADMIN)
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
		}

		$sql_update_pass = ( $row['user_newpasswd'] != '' ) ? ", user_password = '" . str_replace("\'", "''", $row['user_newpasswd']) . "', user_newpasswd = ''" : '';

		$sql = "UPDATE " . USERS_TABLE . "
			SET user_active = 1, user_actkey = ''" . $sql_update_pass . " 
			WHERE user_id = " . $row['user_id']; 
		if ( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql_update);
		}

		if ( intval($ft_cfg['require_activation']) == USER_ACTIVATION_ADMIN && $sql_update_pass == '' )
		{
			require(FT_ROOT . 'includes/emailer.php');
			$emailer = new emailer($ft_cfg['smtp_delivery']);

			$emailer->from($ft_cfg['board_email']);
			$emailer->replyto($ft_cfg['board_email']);

			$emailer->use_template('admin_welcome_activated', $row['user_lang']);
			$emailer->email_address($row['user_email']);
			$emailer->set_subject($lang['Account_activated_subject']);

			$emailer->assign_vars(array(
				'SITENAME' => $ft_cfg['sitename'], 
				'USERNAME' => $row['username'],
				'PASSWORD' => $password_confirm,
				'EMAIL_SIG' => (!empty($ft_cfg['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $ft_cfg['board_email_sig']) : '')
			);
			$emailer->send();
			$emailer->reset();

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid("index.php") . '">')
			);

			message_die(GENERAL_MESSAGE, $lang['Account_active_admin']);
		}
		else
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid("index.php") . '">')
			);

			$message = ( $sql_update_pass == '' ) ? $lang['Account_active'] : $lang['Password_activated']; 
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Wrong_activation']);
	}
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_such_user']);
}