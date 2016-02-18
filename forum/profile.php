<?php

define('IN_PROFILE', true);
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);

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
		require(FT_ROOT . 'includes/usercp_viewprofile.php');
		break;
		
	case 'register':
	case 'editprofile':
		if ( !$userdata['session_logged_in'] && $mode == 'editprofile' )
		{
			redirect(append_sid("login.php?redirect=profile.php&mode=editprofile", true));
		}
		
		require(FT_ROOT . 'includes/usercp_register.php');
		break;
		
	case 'sendpassword':
		require(FT_ROOT . 'includes/usercp_sendpasswd.php');
		break;
		
	case 'activate':
		require(FT_ROOT . 'includes/usercp_activate.php');
		break;
		
	case 'email':
		require(FT_ROOT . 'includes/usercp_email.php');
		break;
		
	default:
		die('Invalid mode');
}