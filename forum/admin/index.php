<?php
$no_page_header = TRUE;
require('./pagestart.php');

function inarray($needle, $haystack)
{
	for($i = 0; $i < sizeof($haystack); $i++ )
	{
		if( $haystack[$i] == $needle )
		{
			return true;
		}
	}
	return false;
}

if( isset($_GET['pane']) && $_GET['pane'] == 'left' )
{
	$dir = @opendir(".");

	$setmodules = 1;
	while( $file = @readdir($dir) )
	{
		if( preg_match("/^admin_.*?\.php$/", $file) )
		{
			include($file);
		}
	}

	@closedir($dir);

	unset($setmodules);

	require('./page_header_admin.php');

	$template->set_filenames(array(
		"body" => "admin/index_navigate.tpl")
	);

	$template->assign_vars(array(
		"U_FORUM_INDEX" => append_sid("../index.php"),
		"U_ADMIN_INDEX" => append_sid("index.php?pane=right"),

		"L_FORUM_INDEX" => $lang['Main_index'],
		"L_ADMIN_INDEX" => $lang['Admin_Index'],
		"L_PREVIEW_FORUM" => $lang['Preview_forum'])
	);

	ksort($module);

	while( list($cat, $action_array) = each($module) )
	{
		$cat = ( !empty($lang[$cat]) ) ? $lang[$cat] : preg_replace("/_/", " ", $cat);

		$template->assign_block_vars("catrow", array(
			"ADMIN_CATEGORY" => $cat)
		);

		ksort($action_array);

		$row_count = 0;
		while( list($action, $file)	= each($action_array) )
		{
			$row_class = 'row2';

			$action = ( !empty($lang[$action]) ) ? $lang[$action] : preg_replace("/_/", " ", $action);

			$template->assign_block_vars("catrow.modulerow", array(
				"ROW_CLASS" => $row_class,
				"ADMIN_MODULE" => $action,
				"U_ADMIN_MODULE" => append_sid($file))
			);
			$row_count++;
		}
	}

	$template->pparse("body");

	require('./page_footer_admin.php');
}
elseif( isset($_GET['pane']) && $_GET['pane'] == 'right' )
{
	require('./page_header_admin.php');

	$template->set_filenames(array(
		"body" => "admin/index_body.tpl")
	);

	$template->assign_vars(array(
		"L_WELCOME" => $lang['Welcome_phpBB'],
		"L_ADMIN_INTRO" => $lang['Admin_intro'],
		"L_FORUM_STATS" => $lang['Forum_stats'],
		"L_WHO_IS_ONLINE" => $lang['Who_is_Online'],
		"L_USERNAME" => $lang['Username'],
		"L_LOCATION" => $lang['Location'],
		"L_LAST_UPDATE" => $lang['Last_updated'],
		"L_IP_ADDRESS" => $lang['IP_Address'],
		"L_STATISTIC" => $lang['Statistic'],
		"L_VALUE" => $lang['Value'],
		"L_NUMBER_POSTS" => $lang['Number_posts'],
		"L_POSTS_PER_DAY" => $lang['Posts_per_day'],
		"L_NUMBER_TOPICS" => $lang['Number_topics'],
		"L_TOPICS_PER_DAY" => $lang['Topics_per_day'],
		"L_NUMBER_USERS" => $lang['Number_users'],
		"L_USERS_PER_DAY" => $lang['Users_per_day'],
		"L_BOARD_STARTED" => $lang['Board_started'],
		"L_AVATAR_DIR_SIZE" => $lang['Avatar_dir_size'],
		"L_DB_SIZE" => $lang['Database_size'],
		"L_FORUM_LOCATION" => $lang['Forum_Location'],
		"L_STARTED" => $lang['Login'],
		"L_GZIP_COMPRESSION" => $lang['Gzip_compression'])
	);

	$total_posts = get_db_stat('postcount');
	$total_users = get_db_stat('usercount');
	$total_topics = get_db_stat('topiccount');

	$start_date = create_date($ft_cfg['default_dateformat'], $ft_cfg['board_startdate'], $ft_cfg['board_timezone']);

	$boarddays = ( time() - $ft_cfg['board_startdate'] ) / 86400;

	$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
	$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
	$users_per_day = sprintf("%.2f", $total_users / $boarddays);

	$avatar_dir_size = 0;

	if ($avatar_dir = @opendir(FT_ROOT . $ft_cfg['avatar_path']))
	{
		while( $file = @readdir($avatar_dir) )
		{
			if( $file != "." && $file != ".." )
			{
				$avatar_dir_size += @filesize(FT_ROOT . $ft_cfg['avatar_path'] . "/" . $file);
			}
		}
		@closedir($avatar_dir);

		if($avatar_dir_size >= 1048576)
		{
			$avatar_dir_size = round($avatar_dir_size / 1048576 * 100) / 100 . " MB";
		}
		else if($avatar_dir_size >= 1024)
		{
			$avatar_dir_size = round($avatar_dir_size / 1024 * 100) / 100 . " KB";
		}
		else
		{
			$avatar_dir_size = $avatar_dir_size . " Bytes";
		}

	}
	else
	{
		$avatar_dir_size = $lang['Not_available'];
	}

	if(intval($posts_per_day) > $total_posts)
	{
		$posts_per_day = $total_posts;
	}

	if(intval($topics_per_day) > $total_topics)
	{
		$topics_per_day = $total_topics;
	}

	if($users_per_day > $total_users)
	{
		$users_per_day = $total_users;
	}

	// DB size ... MySQL only
	$sql = "SELECT VERSION() AS mysql_version";
	if ($result = $db->sql_query($sql))
	{
		$row = $db->sql_fetchrow($result);
		$version = $row['mysql_version'];
		if (preg_match('/^(3\.23|4\.|5\.|10\.)/', $version))
		{

			$dblist = array();
			foreach ($ft_cfg['database'] as $name => $row)
			{
				$sql = "SHOW TABLE STATUS FROM {$row[1]}";
				if ($result = $db->sql_query($sql))
				{
					$tabledata_ary = $db->sql_fetchrowset($result);
					$dbsize = 0;
					for ($i = 0; $i < count($tabledata_ary); $i++)
					{
						if( @$tabledata_ary[$i]['Type'] != 'MRG_MYISAM' )
						{
							$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
						}
					}
					$dblist[] = '<span title="'. $name .'">'. humn_size($dbsize) .'</span>';
				}
			}
			$dbsize = implode('&nbsp;|&nbsp;', $dblist);
		}
		else
		{
			$dbsize = $lang['Not_available'];
		}
	}
	else
	{
		$dbsize = $lang['Not_available'];
	}

	$template->assign_vars(array(
		"NUMBER_OF_POSTS" => $total_posts,
		"NUMBER_OF_TOPICS" => $total_topics,
		"NUMBER_OF_USERS" => $total_users,
		"START_DATE" => $start_date,
		"POSTS_PER_DAY" => $posts_per_day,
		"TOPICS_PER_DAY" => $topics_per_day,
		"USERS_PER_DAY" => $users_per_day,
		"AVATAR_DIR_SIZE" => $avatar_dir_size,
		"DB_SIZE" => $dbsize,
		"GZIP_COMPRESSION" => ( $ft_cfg['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'])
	);

	$sql = "SELECT u.user_id, u.username, u.user_session_time, u.user_allow_viewonline, s.session_logged_in, s.session_ip, s.session_start
		FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
		WHERE s.session_logged_in = " . TRUE . "
			AND u.user_id = s.session_user_id
			AND u.user_id <> " . GUEST_UID . "
			AND s.session_time >= " . ( time() - 300 ) . "
		ORDER BY s.session_ip ASC, u.user_session_time DESC";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't obtain regd user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_reg = @$db->sql_fetchrowset($result);

	$sql = "SELECT session_logged_in, session_time, session_ip, session_start
		FROM " . SESSIONS_TABLE . "
		WHERE session_logged_in = 0
			AND session_time >= " . ( time() - 300 ) . "
		ORDER BY session_ip ASC, session_time DESC";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't obtain guest user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_guest = @$db->sql_fetchrowset($result);

	$sql = "SELECT forum_name, forum_id
		FROM " . FORUMS_TABLE;
	if($forums_result = $db->sql_query($sql))
	{
		while($forumsrow = $db->sql_fetchrow($forums_result))
		{
			$forum_data[$forumsrow['forum_id']] = $forumsrow['forum_name'];
		}
	}
	else
	{
		message_die(GENERAL_ERROR, "Couldn't obtain user/online forums information.", "", __LINE__, __FILE__, $sql);
	}

	$reg_userid_ary = array();

	if( count($onlinerow_reg) )
	{
		$registered_users = 0;

		for($i = 0; $i < count($onlinerow_reg); $i++)
		{
			if( !inarray($onlinerow_reg[$i]['user_id'], $reg_userid_ary) )
			{
				$reg_userid_ary[] = $onlinerow_reg[$i]['user_id'];

				$username = $onlinerow_reg[$i]['username'];

				if( $onlinerow_reg[$i]['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$registered_users++;
					$hidden = FALSE;
				}
				else
				{
					$hidden_users++;
					$hidden = TRUE;
				}

				$row_class = 'row2';

				$reg_ip = decode_ip($onlinerow_reg[$i]['session_ip']);

				$template->assign_block_vars("reg_user_row", array(
					"ROW_CLASS" => $row_class,
					"USERNAME" => $username,
					"STARTED" => create_date('H:i', $onlinerow_reg[$i]['session_start'], $ft_cfg['board_timezone']),
					"LASTUPDATE" => create_date('H:i', $onlinerow_reg[$i]['user_session_time'], $ft_cfg['board_timezone']),
					"IP_ADDRESS" => $reg_ip,

					"U_WHOIS_IP" => "http://www.dnsstuff.com/tools/whois.ch?ip=$reg_ip",
					"U_USER_PROFILE" => append_sid("admin_users.php?mode=edit&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),
				));
			}
		}

	}
	else
	{
		$template->assign_vars(array(
			"L_NO_REGISTERED_USERS_BROWSING" => $lang['No_users_browsing'])
		);
	}

	//
	// Guest users
	//
	if( count($onlinerow_guest) )
	{
		$guest_users = 0;

		for($i = 0; $i < count($onlinerow_guest); $i++)
		{
			$guest_userip_ary[] = $onlinerow_guest[$i]['session_ip'];
			$guest_users++;

			$row_class = 'row2';

			$guest_ip = decode_ip($onlinerow_guest[$i]['session_ip']);

			$template->assign_block_vars("guest_user_row", array(
				"ROW_CLASS" => $row_class,
				"USERNAME" => $lang['Guest'],
				"STARTED" => create_date('H:i', $onlinerow_guest[$i]['session_start'], $ft_cfg['board_timezone']),
				"LASTUPDATE" => create_date('H:i', $onlinerow_guest[$i]['session_time'], $ft_cfg['board_timezone']),
				"IP_ADDRESS" => $guest_ip,

				"U_WHOIS_IP" => "http://www.dnsstuff.com/tools/whois.ch?ip=$guest_ip",
			));
		}

	}
	else
	{
		$template->assign_vars(array(
			"L_NO_GUESTS_BROWSING" => $lang['No_users_browsing'])
		);
	}
	$template->pparse("body");

	require('./page_footer_admin.php');

}
else
{
	//
	// Generate frameset
	//
	$template->set_filenames(array(
		"body" => "admin/index_frameset.tpl")
	);

	$template->assign_vars(array(
		"S_FRAME_NAV" => append_sid("index.php?pane=left"),
		"S_FRAME_MAIN" => append_sid("index.php?pane=right"))
	);

	header ("Expires: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

	$template->pparse("body");

	$db->sql_close();
	exit;
}