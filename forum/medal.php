<?php

/* Settings */

// Number of recent articles you wish to display
$medal_num_recent = 10;

define('IN_FORUM',   true);
define('FT_SCRIPT', 'medal');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();
$user->session_start();
//
// Generate page
//
$start    = isset($_GET['start']) ? abs(intval($_GET['start'])) : 0;
$page_title = $lang['TOP_10'];
require(FT_ROOT . 'includes/page_header.php');
$template->set_filenames(array(
        'body' => 'medal_body.tpl')
);
make_jumpbox('viewforum.php');

$sql = " SELECT DISTINCT u.username, u.user_id, u.user_regdate, tr.user_id, tr.u_up_total AS u_up_total, tr.u_bonus_total, tr.u_down_total, bl.ban_userid
        FROM ( " . USERS_TABLE . " u LEFT JOIN " . BT_USERS_TABLE . " tr ON u.user_id=tr.user_id)LEFT JOIN " . BANLIST_TABLE . " bl ON u.user_id=bl.ban_userid
        WHERE bl.ban_userid Is Null
        ORDER BY u_up_total DESC
        LIMIT $medal_num_recent";
if( !($result = DB()->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, "Could not query users $sql", '', __LINE__, __FILE__, $sql);
}
if ( $row = DB()->sql_fetchrow($result) )
{
        $i = 0;
        do
        {
                $username = $row['username'];
                $user_id = $row['user_id'];
                $joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $ft_cfg['board_timezone']);
                $upload = $row['u_up_total'];
                $bonus = $row['u_bonus_total'];
                $download = $row['u_down_total'];
                $ratio = ($download) ? round((($upload + $bonus) / $download), 2) : '';

                $template->assign_block_vars('memberrow1', array(
                        'ROW_NUMBER' => $i + ( $start + 1 ),
                        'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                        'USERNAME' => $username,
                        'JOINED' => $joined,
                        'UP' => humn_size ($upload),
                        'BONUS' => humn_size ($bonus),
                        'DOWN' => humn_size ($download),
                        'UP_DOWN_RATIO' => $ratio,
                        'U_VIEWPROFILE' => append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
                );
                $i++;
        }
        while ( $row = DB()->sql_fetchrow($result) );
        DB()->sql_freeresult($result);
}

$sql = " SELECT DISTINCT u.username, u.user_id, u.user_regdate, tr.user_id, tr.u_up_total, tr.u_bonus_total, tr.u_down_total AS u_down_total, bl.ban_userid
        FROM ( " . USERS_TABLE . " u LEFT JOIN " . BT_USERS_TABLE . " tr ON u.user_id=tr.user_id)LEFT JOIN " . BANLIST_TABLE . " bl ON u.user_id=bl.ban_userid
        WHERE bl.ban_userid Is Null
        ORDER BY u_down_total DESC
        LIMIT $medal_num_recent";
if( !($result = DB()->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, "Could not query users $sql", '', __LINE__, __FILE__, $sql);
}
if ( $row = DB()->sql_fetchrow($result) )
{
        $i = 0;
        do
        {
                $username = $row['username'];
                $user_id = $row['user_id'];
                $joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $ft_cfg['board_timezone']);
                $upload = $row['u_up_total'];
                $bonus = $row['u_bonus_total']; 
                $download = $row['u_down_total'];
                $ratio = ($download) ? round((($upload + $bonus) / $download), 2) : '';

                $template->assign_block_vars('memberrow2', array(
                        'ROW_NUMBER' => $i + ( $start + 1 ),
                        'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                        'USERNAME' => $username,
                        'JOINED' => $joined,
                        'UP' => humn_size ($upload),
                        'BONUS' => humn_size ($bonus),
                        'DOWN' => humn_size ($download),
                        'UP_DOWN_RATIO' => $ratio,
                        'U_VIEWPROFILE' => append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
                );
                $i++;
        }
        while ( $row = DB()->sql_fetchrow($result) );
        DB()->sql_freeresult($result);
}

$sql = " SELECT DISTINCT u.username, u.user_id, u.user_regdate, tr.user_id, tr.u_up_total, tr.u_down_total, tr.u_bonus_total, (tr.u_up_total + tr.u_bonus_total)/tr.u_down_total AS rat, bl.ban_userid
        FROM ( " . USERS_TABLE . " u LEFT JOIN " . BT_USERS_TABLE . " tr ON u.user_id=tr.user_id)LEFT JOIN " . BANLIST_TABLE . " bl ON u.user_id=bl.ban_userid
        WHERE bl.ban_userid Is Null
        AND tr.u_up_total > 2147483648
 
        ORDER BY rat DESC
        LIMIT $medal_num_recent";
if( !($result = DB()->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, "Could not query users $sql", '', __LINE__, __FILE__, $sql);
}
if ( $row = DB()->sql_fetchrow($result) )
{
        $i = 0;
        do
        {
                $username = $row['username'];
                $user_id = $row['user_id'];
                $joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $ft_cfg['board_timezone']);
                $upload = $row['u_up_total'];
                $bonus = $row['u_bonus_total'];
                $download = $row['u_down_total'];
                $ratio = ($download) ? round((($upload + $bonus) / $download), 2) : '';

                $template->assign_block_vars('memberrow3', array(
                        'ROW_NUMBER' => $i + ( $start + 1 ),
                        'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                        'USERNAME' => $username,
                        'JOINED' => $joined,
                        'UP' => humn_size ($upload),
                        'BONUS' => humn_size ($bonus),
                        'DOWN' => humn_size ($download),
                        'UP_DOWN_RATIO' => $ratio, 
                        'U_VIEWPROFILE' => append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
                );
                $i++;
        }
        while ( $row = DB()->sql_fetchrow($result) );
        DB()->sql_freeresult($result);
}

$sql = "SELECT count(uds.compl_count) AS complete, tor.*, t.*, u.username, u.user_id, f.forum_id, f.forum_name, cat.cat_id, cat.cat_title, t.topic_title, t.topic_id
       FROM " . BT_TORRENTS_TABLE . " tor, " . TOPICS_TABLE . " t , " . FORUMS_TABLE. " f , " . USERS_TABLE . " u , " . CATEGORIES_TABLE . " cat, " . BT_USR_DL_STAT_TABLE . " uds
       WHERE
                                 tor.topic_id = t.topic_id
                                AND tor.poster_id = u.user_id
                                AND t.forum_id = f.forum_id
                                AND f.cat_id = cat.cat_id
                                AND uds.topic_id = tor.topic_id
                                AND uds.user_status = 2
       GROUP BY uds.topic_id
       ORDER BY complete DESC
       LIMIT 10";
if( !($result = DB()->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, "Could not query torrent $sql", '', __LINE__, __FILE__, $sql);
}
if ( $row = DB()->sql_fetchrow($result) )
{
        $i = 0;
        do
        {
                $username = $row['username'];
                $user_id = $row['user_id'];
                $category = $row['cat_id'];
                $forum_name = $row ['forum_name'];
                $forum_id = $row['forum_id'];
                $complete = $row['complete'];
                $topic_title = $row['topic_title'];
                $topic_id = $row['topic_id'];
                $reg_time = create_date($lang['DATE_FORMAT'], $row['reg_time'], $ft_cfg['board_timezone']);

                $template->assign_block_vars('torrentsrow', array(
                        'ROW_NUMBER' => $i + ( $start + 1 ),
                        'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                        'USERNAME' => $username,
                        'CATEGORY' => $category,
                        'FORUM_NAME' => $forum_name,
                        'FORUM_HREF' => append_sid("viewforum.$phpEx?f=". $row['forum_id']),
                        'COMPLETE_COUNT' => $complete,
                        'REG_TIME' => $reg_time,
                        'TOPIC_TITLE' => $topic_title,
                        'TOPIC_HREF'   => append_sid("viewtopic.php?t=". $row['topic_id']),
                        'U_VIEWPROFILE' => append_sid("profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
                );
                $i++;
        }
        while ( $row = DB()->sql_fetchrow($result) );
        DB()->sql_freeresult($result);

}

$template->pparse('body');
require(FT_ROOT . 'includes/page_tail.php');
