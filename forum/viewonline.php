<?php
define('IN_FORUM', true);
define('FT_SCRIPT', 'online');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

// Start session management
$user->session_start();

if (!$userdata['session_logged_in']) {
    redirect(append_sid("login.php?redirect=viewonline.php", true));
}

//
// Output page header and load viewonline template
//
$page_title = $lang['Who_is_Online'];
require(FT_ROOT . 'includes/page_header.php');

$template->set_filenames(array(
        'body' => 'viewonline_body.tpl')
);
make_jumpbox('viewforum.php');

$template->assign_vars(array(
        'L_WHOSONLINE' => $lang['Who_is_Online'],
        'L_ONLINE_EXPLAIN' => $lang['Online_explain'],
        'L_USERNAME' => $lang['Username'],
        'L_FORUM_LOCATION' => $lang['Forum_Location'],
        'L_LAST_UPDATE' => $lang['Last_updated'])
);

//
// Forum info
//
$sql = "SELECT forum_name, forum_id
	FROM " . FORUMS_TABLE;
if ($result = DB()->sql_query($sql)) {
    while ($row = DB()->sql_fetchrow($result)) {
        $forum_data[$row['forum_id']] = $row['forum_name'];
    }
} else {
    message_die(GENERAL_ERROR, 'Could not obtain user/online forums information', '', __LINE__, __FILE__, $sql);
}

//
// Get auth data
//
$is_auth_ary = array();
$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

//
// Get user list
//
$sql = "SELECT u.user_id, u.username, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_time, s.session_ip
	FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
	WHERE u.user_id = s.session_user_id
		AND s.session_time >= " . (time() - 300) . "
	ORDER BY u.username ASC, s.session_ip ASC";
if (!($result = DB()->sql_query($sql))) {
    message_die(GENERAL_ERROR, 'Could not obtain regd user/online information', '', __LINE__, __FILE__, $sql);
}

$guest_users = 0;
$registered_users = 0;
$hidden_users = 0;

$reg_counter = 0;
$guest_counter = 0;
$prev_user = 0;
$prev_ip = '';

while ($row = DB()->sql_fetchrow($result)) {
    $view_online = false;

    if ($row['session_logged_in']) {
        $user_id = $row['user_id'];

        if ($user_id != $prev_user) {
            $username = $row['username'];

            $style_color = '';
            if ($row['user_level'] == ADMIN) {
                $username = '<b style="color:#' . $theme['fontcolor3'] . '">' . $username . '</b>';
            } else if ($row['user_level'] == MOD) {
                $username = '<b style="color:#' . $theme['fontcolor2'] . '">' . $username . '</b>';
            }

            if (!$row['user_allow_viewonline']) {
                $view_online = ($userdata['user_level'] == ADMIN) ? true : false;
                $hidden_users++;

                $username = '<i>' . $username . '</i>';
            } else {
                $view_online = true;
                $registered_users++;
            }

            $which_counter = 'reg_counter';
            $which_row = 'reg_user_row';
            $prev_user = $user_id;
        }
    } else {
        if ($row['session_ip'] != $prev_ip) {
            $username = $lang['Guest'];
            $view_online = true;
            $guest_users++;

            $which_counter = 'guest_counter';
            $which_row = 'guest_user_row';
        }
    }

    $prev_ip = $row['session_ip'];

    if ($view_online) {

        $template->assign_block_vars("$which_row", array(
                'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                'USERNAME' => $username,
                'LASTUPDATE' => create_date($ft_cfg['default_dateformat'], $row['session_time'], $ft_cfg['board_timezone']),
                'FORUM_LOCATION' => $location,

                'U_USER_PROFILE' => append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $user_id),
		));

        $$which_counter++;
    }
}

if ($registered_users == 0) {
    $l_r_user_s = $lang['Reg_users_zero_online'];
} else if ($registered_users == 1) {
    $l_r_user_s = $lang['Reg_user_online'];
} else {
    $l_r_user_s = $lang['Reg_users_online'];
}

if ($hidden_users == 0) {
    $l_h_user_s = $lang['Hidden_users_zero_online'];
} else if ($hidden_users == 1) {
    $l_h_user_s = $lang['Hidden_user_online'];
} else {
    $l_h_user_s = $lang['Hidden_users_online'];
}

if ($guest_users == 0) {
    $l_g_user_s = $lang['Guest_users_zero_online'];
} else if ($guest_users == 1) {
    $l_g_user_s = $lang['Guest_user_online'];
} else {
    $l_g_user_s = $lang['Guest_users_online'];
}

$template->assign_vars(array(
        'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users) . sprintf($l_h_user_s, $hidden_users),
        'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))
);

if ($registered_users + $hidden_users == 0) {
    $template->assign_vars(array(
            'L_NO_REGISTERED_USERS_BROWSING' => $lang['No_users_browsing'])
    );
}

if ($guest_users == 0) {
    $template->assign_vars(array(
            'L_NO_GUESTS_BROWSING' => $lang['No_users_browsing'])
    );
}

$template->pparse('body');

require(FT_ROOT . 'includes/page_tail.php');