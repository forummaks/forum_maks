<?php
if (!defined('FT_ROOT')) die(basename(__FILE__));

define('HEADER_INC', TRUE);

//sv
$template->assign_vars(array(
	'SVISTOK'  => FALSE,
	'PM_FLASH' => FALSE
));
//sv end

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

//
// Parse and show the overall header.
//
$template->set_filenames(array(
	'overall_header' => ( empty($gen_simple_header) ) ? 'overall_header.tpl' : 'simple_header.tpl')
);

//
// Generate logged in/logged out status
//
if ( @$userdata['session_logged_in'] )
{
	$u_login_logout = 'login.php?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = 'login.php';
	$l_login_logout = $lang['Login'];
}

$s_last_visit = ( @$userdata['session_logged_in'] ) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

//
// Get basic (usernames + totals) online
// situation
//
$logged_visible_online = 0;
$logged_hidden_online = 0;
$guests_online = 0;
$online_userlist = '';
$l_online_users = '';

$template->assign_vars(array('SHOW_ONLINE_LIST' => FALSE));

if (defined('SHOW_ONLINE') && $userdata['session_logged_in'] /* && $userdata['user_level'] > USER */)
{
	require_once(FT_ROOT .'includes/show_online_list.php');
}

//
// Obtain number of new private messages
// if user is logged in
//
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
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
			}

			$s_privmsg_new = 1;
			//sv
			$template->assign_vars(array('SVISTOK' => TRUE));
			//sv end
			$icon_pm = $images['pm_new_msg'];
		}
		else
		{
			$s_privmsg_new = 0;
			//sv
			$template->assign_vars(array('SVISTOK' => TRUE));
			//sv end
			$icon_pm = $images['pm_new_msg'];
		}
	}
	else
	{
		$l_privmsgs_text = $lang['No_new_pm'];

		$s_privmsg_new = 0;
		$icon_pm = $images['pm_no_new_msg'];
	}

	//sv
	// synch unread pm count
	if ($userdata['user_unread_privmsg'] && defined('IN_PM'))
	{
		$sql = 'SELECT COUNT(*) AS real_unread_pm_count
			FROM '. PRIVMSGS_TABLE .'
			WHERE privmsgs_to_userid = '. $userdata['user_id'] .'
				AND privmsgs_type = '. PRIVMSGS_UNREAD_MAIL .'
			GROUP BY privmsgs_to_userid
			LIMIT 1';

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query unread private messages count', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			$real_unread_pm_count = $row['real_unread_pm_count'];
		}
		else
		{
			$real_unread_pm_count = 0;
		}

		if ($userdata['user_unread_privmsg'] != $real_unread_pm_count)
		{
			$userdata['user_unread_privmsg'] = $real_unread_pm_count;

			$sql = 'UPDATE '. USERS_TABLE ." SET
					user_unread_privmsg = $real_unread_pm_count
				WHERE user_id = ". $userdata['user_id'] .'
				LIMIT 1';

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update unread private messages count', '', __LINE__, __FILE__, $sql);
			}
		}
	}
	//sv end

	if ( $userdata['user_unread_privmsg'] )
	{
		$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
		$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
		//sv
		$template->assign_vars(array('PM_FLASH' => (defined('IN_PM')) ? FALSE : TRUE));
		//sv end
	}
	else
	{
		$l_privmsgs_text_unread = $lang['No_unread_pm'];
		//sv
		$l_privmsgs_text_unread = (defined('IN_PM')) ? $lang['No_unread_pm'] : '';
		//sv end
	}
}
else
{
	$icon_pm = $images['pm_no_new_msg'];
	$l_privmsgs_text = $lang['Login_check_pm'];
	$l_privmsgs_text_unread = '';
	$s_privmsg_new = 0;
}

//
// Generate HTML required for Mozilla Navigation bar
//
if (!isset($nav_links))
{
	$nav_links = array();
}

$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
while( list($nav_item, $nav_array) = @each($nav_links) )
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, append_sid($nav_array['url']), $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		while( list(,$nested_array) = each($nav_array) )
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];
//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$template->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'],
	'PAGE_TITLE' => (isset($page_title)) ? $page_title : '',
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,

	'LOGGED_IN' => @$userdata['session_logged_in'],

	'PRIVMSG_IMG' => $icon_pm,

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $lang['Private_Messages'],
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
      'L_TOP-10' => $lang['Top-10'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => $lang['Search_new'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),

	'U_SEARCH_UNANSWERED' => append_sid('search.php?search_id=unanswered'),
	'U_SEARCH_SELF' => append_sid('search.php?search_id=egosearch'),
	'U_SEARCH_NEW' => append_sid('search.php?search_id=newposts'),
	'U_INDEX' => append_sid('index.php'),
	'U_REGISTER' => append_sid('profile.php?mode=register'),
	'U_PROFILE' => append_sid('profile.php?mode=editprofile'),
      'U_EDIT_PROFILE' => append_sid('profile.php?mode=editprofile'),
	'U_PRIVATEMSGS' => append_sid('privmsg.php?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' => append_sid('privmsg.php?mode=newpm'),
	'U_SEARCH' => append_sid('search.php'),
	'U_MEMBERLIST' => append_sid('memberlist.php'),
      'U_TOP-10' => append_sid('medal.php'),
	'U_MODCP' => append_sid('modcp.php'),
	'U_FAQ' => append_sid('faq.php'),
	'U_VIEWONLINE' => append_sid('viewonline.php'),
	'U_LOGIN_LOGOUT' => append_sid($u_login_logout),
      'U_SEND_PASSWORD' => append_sid("profile.php?mode=sendpassword"),
	'U_GROUP_CP' => append_sid('groupcp.php'),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('login.php'),

	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TR_CLASS1' => $theme['tr_class1'],
	'T_TR_CLASS2' => $theme['tr_class2'],
	'T_TR_CLASS3' => $theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$theme['th_color1'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TH_COLOR3' => '#'.$theme['th_color3'],
	'T_TH_CLASS1' => $theme['th_class1'],
	'T_TH_CLASS2' => $theme['th_class2'],
	'T_TH_CLASS3' => $theme['th_class3'],
	'T_TD_COLOR1' => '#'.$theme['td_color1'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_TD_COLOR3' => '#'.$theme['td_color3'],
	'T_TD_CLASS1' => $theme['td_class1'],
	'T_TD_CLASS2' => $theme['td_class2'],
	'T_TD_CLASS3' => $theme['td_class3'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTFACE2' => $theme['fontface2'],
	'T_FONTFACE3' => $theme['fontface3'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTSIZE3' => $theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$theme['fontcolor2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	'T_SPAN_CLASS1' => $theme['span_class1'],
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],

	'NAV_LINKS' => $nav_links_html)
);

//qr
$template->assign_vars(array('INCL_BBCODE_JS' => (defined('INCL_BBCODE_JS')) ? TRUE : FALSE));
//qr end

//bt
if (@$userdata['session_logged_in'])
{
	$template->assign_vars(array(
		'U_PROFILE' => append_sid("profile.php?mode=viewprofile&amp;u=". $userdata['user_id']) .'#torrent',
		'L_TRACKER' => $lang['Tracker']
	));
}
$template->assign_vars(array('TRACKER_HREF' => append_sid("tracker.php")));
// bt end

//bt
if ($board_config['bt_show_dl_stat_on_index'] && $userdata['session_logged_in'])
{
   $sql = 'SELECT u_up_total, u_down_total, u_bonus_total
      FROM '. BT_USERS_TABLE .'
      WHERE user_id = '. $userdata['user_id'];

   if (!$result = $db->sql_query($sql))
   {
      message_die(GENERAL_ERROR, 'Could not query ', '', __LINE__, __FILE__, $sql);
   }

   $row = $db->sql_fetchrow($result);

   $ul    = ($row['u_up_total']) ? $row['u_up_total'] : 0;
   $dl    = ($row['u_down_total']) ? $row['u_down_total'] : 0;
   $bl    = ($row['u_bonus_total']) ? $row['u_bonus_total'] : 0;
   $ratio = ($dl) ? round((($ul + $bl) / $dl), 2) : 0;

   $template->assign_block_vars('user_ratio', array(
		'U_UP_TOTAL'    => ($ul) ? humn_size($ul) : 0,
            'U_BONUS_TOTAL' => ($bl) ? humn_size($bl) : 0,
		'U_DOWN_TOTAL'  => ($dl) ? humn_size($dl) : 0,
		'U_RATIO'       => ($ratio) ? $ratio : '-'
   ));
}
//bt end

//
// Login box?
//
if ( !@$userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_user_logged_out', array());
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());

	if ( !empty($userdata['user_popup_pm']) )
	{
		$template->assign_block_vars('switch_enable_pm_popup', array());
	}
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

$template->pparse('overall_header');

?>