<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));
if (defined('PAGE_HEADER_SENT')) return;

// Parse and show the overall page header

global $page_cfg, $userdata, $user, $ft_cfg, $template, $lang, $images;

$logged_in = (int) !empty($userdata['session_logged_in']);

// Generate logged in/logged out status
if ($logged_in)
{
	$u_login_logout = FT_ROOT . LOGIN_URL . "?logout=1";
}
else
{
	$u_login_logout = FT_ROOT . LOGIN_URL;
}

if (defined('SHOW_ONLINE') && SHOW_ONLINE)
{
	$online_full = !empty($_REQUEST['online_full']);
	$online_list = ($online_full) ? 'online_'.$userdata['user_lang'] : 'online_short_'.$userdata['user_lang'];

	${$online_list} = array(
		'stat'     => '',
		'userlist' => '',
		'cnt'      => '',
	);

	if (defined('IS_GUEST') && !(IS_GUEST || IS_USER))
	{
		$template->assign_var('SHOW_ONLINE_LIST');

		if (!${$online_list} = CACHE('ft_cache')->get($online_list))
		{
			require(INC_DIR .'show_online_list.php');
		}
	}

	$template->assign_vars(array(
		'TOTAL_USERS_ONLINE'  => ${$online_list}['stat'],
		'LOGGED_IN_USER_LIST' => ${$online_list}['userlist'],
		'USERS_ONLINE_COUNTS' => ${$online_list}['cnt'],
		'RECORD_USERS'        => sprintf($lang['RECORD_ONLINE_USERS'], $ft_cfg['record_online_users'], create_date($ft_cfg['default_dateformat'], $ft_cfg['record_online_date'], $ft_cfg['board_timezone'])),
	));
}

// Obtain number of new private messages
if ( (@$userdata['session_logged_in']) && (empty($gen_simple_header)) )
{
	if ( $userdata['user_new_privmsg'] )
	{
		$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
		$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

		if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
				WHERE user_id = " . $userdata['user_id'];
			if ( !DB()->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
			}

			$s_privmsg_new = 1;
			$icon_pm = $images['pm_new_msg'];
		}
		else
		{
			$s_privmsg_new = 0;
			$icon_pm = $images['pm_new_msg'];
		}
	}
	else
	{
		$l_privmsgs_text = $lang['No_new_pm'];

		$s_privmsg_new = 0;
		$icon_pm = $images['pm_no_new_msg'];
	}

	if ( $userdata['user_unread_privmsg'] )
	{
		$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
		$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
	}
	else
	{
		$l_privmsgs_text_unread = $lang['No_unread_pm'];
	}
}
else
{
	$icon_pm = $images['pm_no_new_msg'];
	$l_privmsgs_text = $lang['Login_check_pm'];
	$l_privmsgs_text_unread = '';
	$s_privmsg_new = 0;
}
$template->assign_vars(array(
	'PRIVATE_MESSAGE_INFO' 			=> $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' 	=> $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' 		=> $s_privmsg_new,
));

$template->assign_vars(array(
	'SIMPLE_HEADER'      => !empty($gen_simple_header),
	'CONTENT_ENCODING'   => 'ru_RU.UTF-8',
	
	'IN_ADMIN'           => defined('IN_ADMIN'),
	'USER_HIDE_CAT'      => (FT_SCRIPT == 'index'),
	
	'USER_LANG'          => $userdata['user_lang'],
	
	'INCLUDE_BBCODE_JS'  => !empty($page_cfg['include_bbcode_js']),
	'USER_OPTIONS_JS'    => (IS_GUEST) ? '{}' : ft_json_encode($user->opt_js),
	
	'USE_TABLESORTER'    => !empty($page_cfg['use_tablesorter']),
	
	'SITENAME' 			 => $ft_cfg['sitename'],
	'U_INDEX' 			 => FT_ROOT . 'index.php',
	'PAGE_TITLE' 		 => (isset($page_title)) ? $page_title : '',
		
	'IS_GUEST'           => IS_GUEST,
	'IS_USER'            => IS_USER,
	'IS_ADMIN'           => IS_ADMIN,
	'IS_MOD'             => IS_MOD,
	'IS_AM'              => IS_AM,
	
	'FORUM_PATH'         => FORUM_PATH,
	'FULL_URL'           => FULL_URL,
	
	'CURRENT_TIME' 		 => sprintf($lang['Current_time'], create_date($ft_cfg['default_dateformat'], time(), $ft_cfg['board_timezone'])),
	'S_TIMEZONE'         => preg_replace('/\(.*?\)/', '', sprintf($lang['ALL_TIMES'], $lang['TZ'][str_replace(',', '.', floatval($ft_cfg['board_timezone']))])),
	'BOARD_TIMEZONE'     => $ft_cfg['board_timezone'],
	
	'PRIVMSG_IMG' 		 => $icon_pm,
	
	'LOGGED_IN'          => $logged_in,
	'SESSION_USER_ID'    => $userdata['user_id'],
	'THIS_USER'          => $userdata['username'],
	'SHOW_LOGIN_LINK'    => !defined('IN_LOGIN'),
	'AUTOLOGIN_DISABLED' => !$ft_cfg['allow_autologin'],
	'S_LOGIN_ACTION'     => LOGIN_URL,
	
	'U_SEARCH_UNANSWERED' => 'search.php?search_id=unanswered',
	'U_SEARCH_SELF' 	 => 'search.php?search_id=egosearch',
	'U_SEARCH_NEW' 		 => 'search.php?search_id=newposts',
	'U_REGISTER' 		 => 'profile.php?mode=register',
	'U_PROFILE' 		 => 'profile.php?mode=editprofile',
    'U_EDIT_PROFILE' 	 => 'profile.php?mode=editprofile',
	'U_PRIVATEMSGS' 	 => 'privmsg.php?folder=inbox',
	'U_PRIVATEMSGS_POPUP' => 'privmsg.php?mode=newpm',
	'U_SEARCH' 			 => 'search.php',
	'U_MEMBERLIST' 		 => 'memberlist.php',
    'U_TOP-10' 			 => 'medal.php',
	'U_MODCP' 			 => 'modcp.php',
	'U_FAQ' 			 => 'faq.php',
	'U_VIEWONLINE' 		 => 'viewonline.php',
	'U_LOGIN_LOGOUT' 	 => $u_login_logout,
    'U_SEND_PASSWORD' 	 => "profile.php?mode=sendpassword",
	'U_GROUP_CP' 		 => 'groupcp.php',
	'U_PROFILE' 		 => "profile.php?mode=viewprofile&amp;u=". $userdata['user_id'],
	'TRACKER_HREF' 		 => "tracker.php",
	
	'SHOW_SIDEBAR1'      => (!empty($page_cfg['show_sidebar1'][FT_SCRIPT]) || $ft_cfg['show_sidebar1_on_every_page']),
	'SHOW_SIDEBAR2'      => (!empty($page_cfg['show_sidebar2'][FT_SCRIPT]) || $ft_cfg['show_sidebar2_on_every_page']),
	
	// Common urls
	'CAT_URL'            => FT_ROOT . CAT_URL,
	'DOWNLOAD_URL'       => FT_ROOT . DOWNLOAD_URL,
	'FORUM_URL'          => FT_ROOT . FORUM_URL,
	'GROUP_URL'          => FT_ROOT . GROUP_URL,
	'LOGIN_URL'          => $ft_cfg['login_url'],
	'NEWEST_URL'         => '&amp;view=newest#newest',
	'PM_URL'             => $ft_cfg['pm_url'],
	'POST_URL'           => FT_ROOT . POST_URL,
	'POSTING_URL'        => $ft_cfg['posting_url'],
	'PROFILE_URL'        => FT_ROOT . PROFILE_URL,
	'TOPIC_URL'          => FT_ROOT . TOPIC_URL,
	
	'ONLY_NEW_POSTS'     => ONLY_NEW_POSTS,
	'ONLY_NEW_TOPICS'    => ONLY_NEW_TOPICS,

	// Misc
	'BOT_UID'            => BOT_UID,
	'COOKIE_MARK'        => COOKIE_MARK,
	'SID'                => $userdata['session_id'],
	'SID_HIDDEN'         => '<input type="hidden" name="sid" value="'. $userdata['session_id'] .'" />',
	
	'CHECKED'            => HTML_CHECKED,
	'DISABLED'           => HTML_DISABLED,
	'READONLY'           => HTML_READONLY,
	'SELECTED'           => HTML_SELECTED,

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $ft_cfg['sitename']),
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $lang['Private_Messages'],
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
      'L_TOP-10' => $lang['Top-10'],
	'L_FAQ' => $lang['FAQ'],
	'L_TRACKER' 		 => $lang['Tracker'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => $lang['Search_new'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span class="colorAdmin">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span class="colorMod">', '</span>'),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT']
));

//qr
$template->assign_vars(array('INCL_BBCODE_JS' => (defined('INCL_BBCODE_JS')) ? TRUE : FALSE));
//qr end

// Login box
$in_out = ($logged_in) ? 'in' : 'out';
$template->assign_block_vars("switch_user_logged_{$in_out}", array());

if (!GUEST_UID)
{
	header('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
	header('Expires: 0');
	header('Pragma: no-cache');
}

$template->set_filenames(array('overall_header' => 'overall_header.tpl'));
$template->pparse('overall_header');

define('PAGE_HEADER_SENT', true);

if (!$ft_cfg['gzip_compress'])
{
	flush();
}