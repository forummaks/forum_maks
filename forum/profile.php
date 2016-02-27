<?php
define('IN_PROFILE', true);
define('FT_SCRIPT', 'profile');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$user->session_start();

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

$mode = request_var('mode', '');

switch($mode)
{
	case 'viewprofile':
		require(PROFILE_DIR . 'viewprofile.php');
		break;
		
	case 'register':
	case 'editprofile':
		if ( !$userdata['session_logged_in'] && $mode == 'editprofile' )
		{
			redirect(append_sid("login.php?redirect=profile.php&mode=editprofile", true));
		}
		
		require(PROFILE_DIR . 'register.php');
		break;
		
	case 'sendpassword':
		require(PROFILE_DIR . 'sendpasswd.php');
		break;
		
	case 'activate':
		require(PROFILE_DIR . 'activate.php');
		break;
		
	case 'email':
		require(PROFILE_DIR . 'email.php');
		break;
		
	default:
		die('Invalid mode');
}