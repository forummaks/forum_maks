<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));
if (defined('PAGE_HEADER_SENT')) return;

// Parse and show the overall page header
global $page_cfg, $userdata, $ads, $ft_cfg, $template, $lang, $images;

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

$s_last_visit = ( @$userdata['session_logged_in'] ) ? create_date($ft_cfg['default_dateformat'], $userdata['user_lastvisit'], $ft_cfg['board_timezone']) : '';

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

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $ft_cfg['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $ft_cfg['board_timezone'])] : $lang[number_format($ft_cfg['board_timezone'])];
//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$template->assign_vars(array(
	'SIMPLE_HEADER'      => !empty($gen_simple_header),
	'IN_ADMIN'           => defined('IN_ADMIN'),
	'SITENAME' 			 => $ft_cfg['sitename'],
	'SITE_DESCRIPTION' 	 => $ft_cfg['site_desc'],
	'PAGE_TITLE' 		 => (isset($page_title)) ? $page_title : '',
	'LAST_VISIT_DATE' 	 => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' 		 => sprintf($lang['Current_time'], create_date($ft_cfg['default_dateformat'], time(), $ft_cfg['board_timezone'])),
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' 		 => sprintf($lang['Record_online_users'], $ft_cfg['record_online_users'], create_date($ft_cfg['default_dateformat'], $ft_cfg['record_online_date'], $ft_cfg['board_timezone'])),
	'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
	
	'FORUM_PATH'         => FORUM_PATH,
	'FULL_URL'           => FULL_URL,
	
	'SHOW_SIDEBAR1'      => (!empty($page_cfg['show_sidebar1'][FT_SCRIPT]) || $ft_cfg['show_sidebar1_on_every_page']),
	'SHOW_SIDEBAR2'      => (!empty($page_cfg['show_sidebar2'][FT_SCRIPT]) || $ft_cfg['show_sidebar2_on_every_page']),

	'LOGGED_IN' 		 => @$userdata['session_logged_in'],
	
	// Misc
	'BOT_UID'            => BOT_UID,
	'COOKIE_MARK'        => COOKIE_MARK,
	'SID'                => $userdata['session_id'],
	'SID_HIDDEN'         => '<input type="hidden" name="sid" value="'. $userdata['session_id'] .'" />',
	
	'CHECKED'            => HTML_CHECKED,
	'DISABLED'           => HTML_DISABLED,
	'READONLY'           => HTML_READONLY,
	'SELECTED'           => HTML_SELECTED,

	'PRIVMSG_IMG' 		 => $icon_pm,

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $ft_cfg['sitename']),
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
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span class="colorAdmin">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span class="colorMod">', '</span>'),

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
	'U_PROFILE' => append_sid("profile.php?mode=viewprofile&amp;u=". $userdata['user_id']) .'#torrent',
	'L_TRACKER' => $lang['Tracker'],
	'TRACKER_HREF' => append_sid("tracker.php"),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('login.php')
	));

//qr
$template->assign_vars(array('INCL_BBCODE_JS' => (defined('INCL_BBCODE_JS')) ? TRUE : FALSE));
//qr end

//bt
if ($ft_cfg['bt_show_dl_stat_on_index'] && $userdata['session_logged_in'])
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