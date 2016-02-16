<?php

define('IN_PROFILE', true);
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);
//
// End session management
//

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

function gen_rand_string($hash)
{
	$chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
	
	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);
	
	$rand_str = '';
	for($i = 0; $i < 8; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}

	return ( $hash ) ? md5($rand_str) : $rand_str;
}

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
		
	case 'confirm':
		if ( $userdata['session_logged_in'] )
		{
			exit;
		}
		require(FT_ROOT . 'includes/usercp_confirm.php');
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