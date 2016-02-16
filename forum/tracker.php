<?php

define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$userdata = session_pagestart($user_ip, PAGE_TRACKER);
init_userprefs($userdata);

$tor_search_limit    = 500;
$max_forum_sel_size  = 8;
$def_search_days     = 30;   // default search days option
$title_match_max_len = 60;
$poster_name_max_len = 25;
$clean_search_interv = 3;    // clean phpbb_bt_search_results table interval (in hours)
$tor_colspan         = 11;   // colspan with all columns

$tor_per_page        = $board_config['topics_per_page'];
$tracker_basename    = "tracker.php";

$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();
$time_format  = 'H:i';
$date_format  = 'd-M-m';

$row_class_1  = 'prow1';
$row_class_2  = 'prow2';

$sid   = (isset($_REQUEST['sid'])) ? $_REQUEST['sid'] : '';
$start = (isset($_REQUEST['start'])) ? abs(round(intval($_REQUEST['start']))) : 0;
$end   = $start + $tor_per_page;
$guest = (!$userdata['session_logged_in']) ? TRUE : FALSE;

if ($board_config['bt_tor_browse_only_reg'] && $guest)
{
	redirect(append_sid("login.php?redirect=$tracker_basename", TRUE));
}

$def        = (isset($_GET['def'])) ? TRUE : FALSE;
$user_id    = $userdata['user_id'];
$lastvisit  = (!$guest) ? $userdata['user_lastvisit'] : '';
$search_id  = (isset($_GET['search_id'])) ? intval($_GET['search_id']) : '';
$session_id = $userdata['session_id'];

$tor_list_sql = $tor_to_show_sql = $opt = $order_options = $time_options = $s_not_seen_options = '';
$tor_list_ary = $tor_to_show_ary = $allowed_cats = $allowed_forums = array();
$cat_forum = $search_in_forums_ary = $prev_set = $tmp = $subforums = array();
$row_num = $tor_count = $cat_forum_size = 0;
$req_poster_id = $title_match_sql = '';
$poster_error = FALSE;

$sl = ' selected="selected" ';
$ch = ' checked="checked" ';
$ds = ' disabled="disabled" ';

$torrents_tbl = BT_TORRENTS_TABLE    .' tor';
$cat_tbl      = CATEGORIES_TABLE     .' cat';
$forums_tbl   = FORUMS_TABLE         .' f';
$topics_tbl   = TOPICS_TABLE         .' t';
$users_tbl    = USERS_TABLE          .' u';
$tracker_tbl  = BT_TRACKER_TABLE     .' tr';
$dl_stat_tbl  = BT_USR_DL_STAT_TABLE .' dl';

$dl_st_ary = array(
	DL_STATUS_WILL     => 'dlWill',
	DL_STATUS_DOWN     => 'leechmed',
	DL_STATUS_COMPLETE => 'seedmed',
	DL_STATUS_CANCEL   => 'dlCancel'
);

//
// Define search options
//
// Key names
$active_key      = 'a';
$my_key          = 'my';
$cat_key         = 'c';
$forum_key       = 'f';
$new_key         = 'n';
$title_match_key = 'nm';
$order_key       = 'o';
$poster_id_key   = 'pid';
$poster_name_key = 'pn';
$sort_key        = 's';
$seed_exist_key  = 'sd';
$show_forum_key  = 'shf';
$show_author_key = 'sha';
$show_speed_key  = 'shs';
$sid_key         = 'sid';
$s_not_seen_key  = 'sns';
$topic_key       = 't';
$time_key        = 'tm';

// Key values
$search_all = -1;
$never      = -2;

$sort_asc   = 1;
$sort_desc  = 2;

$ord_posted = 1;
$ord_name   = 2;
$ord_forum  = 3;
$ord_compl  = 4;
$ord_size   = 5;
$ord_last_p = 6;
$ord_last_s = 7;

$def_order = $ord_posted;
$def_sort  = $sort_desc;

// Order options
$order_opt = array(
	$ord_posted => array(
		              'lang' => $lang['Registered'],
		              'sql'  => 'tor.reg_time'
		             ),
	$ord_name   => array(
		              'lang' => $lang['Bt_Topic_Title'],
		              'sql'  => 't.topic_title'
		             ),
	$ord_forum  => array(
		              'lang' => $lang['Bt_Sort_Forum'],
		              'sql'  => 'f.forum_name, t.topic_title'
		             ),
	$ord_compl  => array(
		              'lang' => $lang['Completed'],
		              'sql'  => 'tor.complete_count'
		             ),
	$ord_size   => array(
		              'lang' => $lang['Tor_Size'],
		              'sql'  => 'tor.size'
		             ),
	$ord_last_p => array(
		              'lang' => $lang['Bt_Last_post'],
		              'sql'  => 't.topic_last_post_id'
		             ),
	$ord_last_s => array(
		              'lang' => $lang['Bt_Seeder_last_seen'],
		              'sql'  => 'tor.seeder_last_seen'
		             )
);

// Sort direction
$sort_opt = array(
	$sort_asc  => array(
		             'lang' => $lang['Sort_Ascending'],
		             'sql'  => 'ASC'
		            ),
	$sort_desc => array(
		             'lang' => $lang['Sort_Descending'],
		             'sql'  => 'DESC'
		            )
);

// Previous days
$time_opt = array(
	$search_all => array(
		     'lang' => $lang['Bt_All_Days_for'],
		     'sql'  => 0
		    ),
	1  => array(
		     'lang' => $lang['Bt_1_Day_for'],
		     'sql'  => $current_time - 86400
		    ),
	3  => array(
		     'lang' => $lang['Bt_3_Day_for'],
		     'sql'  => $current_time - 86400*3
		    ),
	7  => array(
		     'lang' => $lang['Bt_7_Days_for'],
		     'sql'  => $current_time - 86400*7
		    ),
	14 => array(
		     'lang' => $lang['Bt_2_Weeks_for'],
		     'sql'  => $current_time - 86400*14
		    ),
	30 => array(
		     'lang' => $lang['Bt_1_Month_for'],
		     'sql'  => $current_time - 86400*30
		    )
);

// Seeder not seen
$s_not_seen_opt = array(
	$search_all => array(
		     'lang' => $lang['Bt_Disregard'],
		     'sql'  => 0
		    ),
	$never  => array(
		     'lang' => $lang['Bt_Never'],
		     'sql'  => 0
		    ),
	30 => array(
		     'lang' => $lang['Bt_1_Month'],
		     'sql'  => $current_time - 86400*30
		    ),
	14 => array(
		     'lang' => $lang['Bt_2_Weeks'],
		     'sql'  => $current_time - 86400*14
		    ),
	7  => array(
		     'lang' => $lang['Bt_7_Days'],
		     'sql'  => $current_time - 86400*7
		    ),
	3  => array(
		     'lang' => $lang['Bt_3_Days'],
		     'sql'  => $current_time - 86400*3
		    )
);

// Define options and set default values
$new_val         = $def_new_val         = 0;
$seed_exist_val  = $def_seed_exist_val  = 0;
$active_val      = $def_active_val      = 1;
$my_val          = $def_my_val          = 0;
$forum_val       = $def_forum_val       = $search_all;
$poster_id_val   = $def_poster_id_val   = 0;
$poster_name_val = $def_poster_name_val = '';
$title_match_val = $def_title_match_val = '';
$s_not_seen_val  = $def_s_not_seen_val  = $search_all;
$order_val       = $def_order_val       = $ord_posted;
$sort_val        = $def_sort_val        = $sort_desc;
$time_val        = $def_time_val        = $def_search_days;
$show_forum_val  = $def_show_forum_val  = 1;
$show_author_val = $def_show_author_val = 1;
$show_speed_val  = $def_show_speed_val  = 0;
$sid_val         = $def_sid_val         = $session_id;

// Restore user search settings
if ($userdata['bt_tor_browse_set'] && !$guest)
{
	if ($tmp = unserialize($userdata['bt_tor_browse_set']))
	{
//	if ($tmp[$sid_key] == $session_id)
//	{
			$prev_set = $tmp;
			unset($tmp);
//	}
	}
}

// Restore torrents list and search settings if we have valid $search_id
if ($search_id)
{
	$sql = 'SELECT search_array, search_settings
		FROM '. BT_SEARCH_TABLE ."
		WHERE session_id = '$session_id'
			AND search_id = $search_id
		LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain torrent search results', '', __LINE__, __FILE__, $sql);
	}

	if ($row = $db->sql_fetchrow($result))
	{
		$prev_set     = unserialize($row['search_settings']);
		$tor_list_sql = $row['search_array'];
		$tor_list_ary = explode(',', $tor_list_sql);
		$tor_count    = count($tor_list_ary);
		unset($row);
	}
	else
	{
		redirect(append_sid($tracker_basename, TRUE));
	}
}

// Get allowed for searching forums list
$not_auth_forums = user_not_auth_forums(AUTH_VIEW);
$ignore_forum_sql = ($not_auth_forums) ? "AND f.forum_id NOT IN($not_auth_forums)" : '';

//sf - add [, f.forum_parent]
$sql = 'SELECT c.cat_id, c.cat_title, f.forum_id, f.forum_name, f.forum_parent
	FROM '. FORUMS_TABLE .' f, '. CATEGORIES_TABLE ." c
	WHERE f.allow_reg_tracker = 1
		AND f.cat_id = c.cat_id
		$ignore_forum_sql
	ORDER BY c.cat_order, f.cat_id, f.forum_order";

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query cat/forum info', '', __LINE__, __FILE__, $sql);
}

if ($rowset = @$db->sql_fetchrowset($result))
{
	$db->sql_freeresult($result);
	$template->assign_vars(array('SHOW_SEARCH_OPT' => TRUE));

	foreach ($rowset as $rid => $row)
	{
		$cat_forum[$row['cat_id']]['cat_title'] = $row['cat_title'];
		$cat_forum[$row['cat_id']]['f'][$row['forum_id']] = $row['forum_name'];

		if (isset($cat_forum[$row['cat_id']]['forums_sql']))
		{
			$cat_forum[$row['cat_id']]['forums_sql'] .= ','. $row['forum_id'];
		}
		else
		{
			$cat_forum[$row['cat_id']]['forums_sql'] = $row['forum_id'];
		}
		//sf
		if ($row['forum_parent'])
		{
			$subforums[] = $row['forum_id'];
		}
		//sf end

		$allowed_forums[] = intval($row['forum_id']);
		$cat_forum_size++;
	}

	$cat_forum_size += count($cat_forum);
	unset($rowset);
}

$allowed_forums_sql = implode(',', $allowed_forums);

//
// Get current search settings
// $def - use default
//
if (!$def)
{
	checkbox_get_val ($active_key,      $active_val,      $def_active_val);
	checkbox_get_val ($show_forum_key,  $show_forum_val,  $def_show_forum_val);
	checkbox_get_val ($show_author_key, $show_author_val, $def_show_author_val);
	checkbox_get_val ($show_speed_key,  $show_speed_val,  $def_show_speed_val);
	checkbox_get_val ($seed_exist_key,  $seed_exist_val,  $def_seed_exist_val);

	if (!$guest)
	{
		checkbox_get_val ($new_key, $new_val, $def_new_val);
		checkbox_get_val ($my_key,  $my_val,  $def_my_val);
	}

	// Search in forum or category
	// Get requested cat_id
	if (isset($_GET[$cat_key]))
	{
		$cat_id = intval($_GET[$cat_key]);
		$forum_val = '';

		// Validate requested cat_id and build forums list for SQL
		if ($cat_forum[$cat_id])
		{
			foreach ($cat_forum[$cat_id]['f'] as $forum_id => $forum_desc)
			{
				$search_in_forums_ary[] = $forum_id;
			}
			$forum_val = ($search_in_forums_ary) ? implode(',', $search_in_forums_ary) : '';
		}
	}
	// Get requested forum_id(s)
	else if (isset($_GET[$forum_key]))
	{
		$forum_val = intval($_GET[$forum_key]);
	}
	else if (isset($_POST[$forum_key]))
	{
		if (is_array($_POST[$forum_key]))
		{
			$forum_val = array();
			foreach ($_POST[$forum_key] as $rid => $forum)
			{
				$forum_val[] = intval($forum);
			}
			$forum_val = implode(',', $forum_val);
		}
		else
		{
			$forum_val = intval($_POST[$forum_key]);
		}
	}
	else if (isset($prev_set[$forum_key]))
	{
		$forum_val = $prev_set[$forum_key];
	}
	else
	{
		$forum_val = $search_all;
	}

	// Validate requested forum_id and build forums list ($forum_val) for SQL
	if ($forum_val != $search_all)
	{
		$forum_val_ary = explode(',', $forum_val);

		foreach ($forum_val_ary as $rid => $forum_id)
		{
			if (in_array($forum_id, $allowed_forums))
			{
				if (!in_array($forum_id, $search_in_forums_ary))
				{
					$search_in_forums_ary[] = $forum_id;
				}
			}
		}
		$forum_val = ($search_in_forums_ary) ? implode(',', $search_in_forums_ary) : '';
	}

	// Get poster_id
	if (!$my_val)
	{
		if (isset($_GET[$poster_id_key]) && !$search_id)
		{
			$req_poster_id = intval($_GET[$poster_id_key]);
		}
		else if (isset($_REQUEST[$poster_name_key]) && !$search_id)
		{
			if ($req_poster_name = substr(unesc(trim($_REQUEST[$poster_name_key])), 0, 25))
			{
				$poster_name_sql = bt_sql_esc($req_poster_name);

				if ($poster_id = get_user_id($poster_name_sql))
				{
					$poster_id_val = $poster_id;
					$poster_name_val = $req_poster_name;
				}
				else
				{
					$poster_name_val = $lang['Bt_User_not_found'];
					$poster_error = TRUE;
				}
			}
		}
		else if ($search_id && $prev_set[$poster_id_key])
		{
			$poster_id_val = intval($prev_set[$poster_id_key]);
			$poster_name_val = ($prev_set[$poster_name_key]) ? $prev_set[$poster_name_key] : '';
		}

		if ($req_poster_id)
		{
			if ($req_poster_id == ANONYMOUS)
			{
				$poster_id_val = ANONYMOUS;
				$poster_name_val = $lang['Guest'];
			}
			else if ($poster_name_val = get_username($req_poster_id))
			{
				$poster_id_val = $req_poster_id;
			}
		}
	}

	// Order by, Sort dir, Time
	select_get_val ($order_key,      $order_val,       $order_opt,       $def_order_val);
	select_get_val ($sort_key,       $sort_val,        $sort_opt,        $def_sort_val);
	select_get_val ($time_key,       $time_val,        $time_opt,        $def_time_val);
	select_get_val ($s_not_seen_key, $s_not_seen_val,  $s_not_seen_opt,  $def_s_not_seen_val);

	if (isset($_REQUEST[$title_match_key]))
	{
		if ($tmp = substr(unesc(trim($_REQUEST[$title_match_key])), 0, $title_match_max_len))
		{
			$title_match_val = htmlspecialchars($tmp);
			$title_match_sql = bt_sql_esc($tmp);
		}
	}
}

if ($forum_val && $allowed_forums_sql)
{
	if ($s_not_seen_val != $search_all)
	{
		$seed_exist_val = 0;
	}
	if ($seed_exist_val)
	{
		$active_val = 1;
	}
	// Current search settings array (will stored in DB)
	$curr_set = array(
		$sid_key         => $sid_val,
		$new_key         => $new_val,
		$seed_exist_key  => $seed_exist_val,
		$active_key      => $active_val,
		$my_key          => $my_val,
		$forum_key       => $forum_val,
		$poster_id_key   => $poster_id_val,
		$poster_name_key => $poster_name_val,
		$s_not_seen_key  => $s_not_seen_val,
		$order_key       => $order_val,
		$sort_key        => $sort_val,
		$time_key        => $time_val,
		$show_forum_key  => $show_forum_val,
		$show_author_key => $show_author_val,
		$show_speed_key  => $show_speed_val
	);

	$curr_set_sql = bt_sql_esc(serialize($curr_set));

	// Store search settings
	if (array_diff_assoc($curr_set, $prev_set) && !$guest)
	{
		$sql = 'UPDATE '. USERS_TABLE ." SET
				bt_tor_browse_set = '$curr_set_sql'
			WHERE user_id = $user_id
			LIMIT 1";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update torrent search settings', '', __LINE__, __FILE__, $sql);
		}
	}

	// Switches
	$only_new    = ($new_val && !$guest) ? TRUE : FALSE;
	$seed_exist  = ($seed_exist_val) ? TRUE : FALSE;
	$only_active = ($active_val) ? TRUE : FALSE;
	$only_my     = ($my_val && !$guest) ? TRUE : FALSE;
	$prev_days   = ($time_val != $search_all) ? TRUE : FALSE;
	$poster_id   = ($poster_id_val) ? TRUE : FALSE;
	$title_match = ($title_match_sql) ? TRUE : FALSE;
	$s_not_seen  = ($s_not_seen_val != $search_all) ? TRUE : FALSE;

	$hide_forum  = (!$show_forum_val) ? 1 : 0;
	$hide_author = (!$show_author_val) ? 1 : 0;
	$hide_speed  = (!$show_speed_val) ? 1 : 0;

	// Get torrents list
	if (!$tor_list_sql)
	{
		$reg_time    = $time_opt[$time_val]['sql'];
		$s_seen_time = $s_not_seen_opt[$s_not_seen_val]['sql'];
		$s_seen_sign = ($s_not_seen_val == $never) ? '=' : '<';
		$s_seen_exl  = ($s_not_seen_val == $never) ? '' : 'AND tor.seeder_last_seen != 0';

		$poster_id_sql    = intval($poster_id_val);
		$search_bool_mode = ($board_config['bt_search_bool_mode']) ? ' IN BOOLEAN MODE' : '';

		// SELECT
		$select_sql = 'SELECT tor.torrent_id';

		// FROM
		$from_sql = "FROM $torrents_tbl, $topics_tbl, $forums_tbl";
		$from_sql .= ($only_active) ? ", $tracker_tbl" : '';

		// WHERE
		$where_sql = '
			WHERE tor.topic_id = t.topic_id
				AND t.forum_id = f.forum_id
		';
		$where_sql .= ($poster_id) ? "
				AND tor.poster_id = $poster_id_sql
		" :	'';
		$where_sql .= ($only_new) ? "
				AND tor.reg_time > $lastvisit
		" :	'';
		$where_sql .= ($prev_days) ? "
				AND tor.reg_time > $reg_time
		" :	'';
		$where_sql .= ($s_not_seen) ? "
				AND tor.seeder_last_seen $s_seen_sign $s_seen_time
				$s_seen_exl
		" :	'';
		$where_sql .= ($only_my) ? "
				AND tor.poster_id = $user_id
		" :	'';
		$where_sql .= ($only_active) ? "
				AND tor.torrent_id = tr.torrent_id
				AND tr.expire_time > $current_time
		" :	'';
		$where_sql .= ($seed_exist) ? '
				AND tr.seeder = 1
		' :	'';
		$where_sql .= ($tcs_ids!='') ? '
				AND tor.topic_check_status in ('.$tcs_ids.')
		' :	'';
		$where_sql .= ($title_match) ? "
				AND MATCH (t.topic_title) AGAINST ('$title_match_sql'". $search_bool_mode .")
		" :	'';

		if ($search_in_forums_sql = implode(',', $search_in_forums_ary))
		{
			$where_sql .= "
				AND f.forum_id IN($search_in_forums_sql)
			";
		}
		else
		{
			$where_sql .= "
				AND f.forum_id IN($allowed_forums_sql)
			";
		}

		// GROUP
		$group_sql = ($only_active) ? 'GROUP BY tr.torrent_id' : '';

		// HAVING
		$having_sql = '';

		// ORDER
		$order_sql = 'ORDER BY '. $order_opt[$order_val]['sql'];

		// SORT
		$sort_sql = $sort_opt[$sort_val]['sql'];

		// LIMIT
		$limit = "LIMIT $tor_search_limit";

		// Full SQL query
		$sql = "
			$select_sql
			$from_sql
			$where_sql
			$group_sql
				$having_sql
			$order_sql
				$sort_sql
			$limit
		";

		if (!$result = $db->sql_query($sql))
		{
			if (!$def)
			{
				redirect(append_sid("$tracker_basename?def=1", TRUE));
			}
			else
			{
				message_die(GENERAL_ERROR, 'Could not query torrents information', '', __LINE__, __FILE__, $sql);
			}
		}

		if ($tor_rows = @$db->sql_fetchrowset($result))
		{
			$db->sql_freeresult($result);
			$tor_list_ary = array();

			foreach ($tor_rows as $rid => $row)
			{
				$tor_list_ary[] = $row['torrent_id'];
			}

			$tor_list_sql = implode(',', $tor_list_ary);
			$tor_count    = count($tor_list_ary);
			unset($tor_rows);
		}
	}

	if ($tor_list_sql && $tor_list_ary && $start < $tor_count)
	{
		if ($tor_count > $tor_per_page)
		{
			if (!$search_id)
			{
				// Delete old search results
				$clean_exp_time = $current_time - 60*60*$clean_search_interv;

				if ($board_config['bt_search_tbl_last_clean'] < $clean_exp_time)
				{
					$sql = 'DELETE FROM '. BT_SEARCH_TABLE ."
						WHERE added < $clean_exp_time";

					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not clean torrents search results table', '', __LINE__, __FILE__, $sql);
					}

					$sql = 'UPDATE '. CONFIG_TABLE ." SET
							config_value = $current_time
						WHERE config_name = 'bt_search_tbl_last_clean'";

					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update bt_search_tbl_last_clean in board config table', '', __LINE__, __FILE__, $sql);
					}
				}

				// Save result in DB
				mt_srand ((double) microtime() * 1000000);
				$search_id = mt_rand();

				$columns =  'session_id,   search_id,  added,          search_array,    search_settings';
				$values = "'$session_id', $search_id, $current_time, '$tor_list_sql', '$curr_set_sql'";

				$sql = 'REPLACE INTO '. BT_SEARCH_TABLE ." ($columns) VALUES ($values)";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not insert torrents search results', '', __LINE__, __FILE__, $sql);
				}
			}

			for ($i=$start; $i<$end; $i++)
			{
				if ($tor_list_ary[$i])
				{
					$tor_to_show_ary[] = $tor_list_ary[$i];
				}
				else
				{
					break;
				}
			}
		}
		else
		{
			$tor_to_show_ary = $tor_list_ary;
		}
	}

	if (!$tor_to_show_ary)
	{
		$template->assign_block_vars('tor_not_found', array('L_NO_MATCH' => $lang['No_match']));
	}
	else
	{
		// Get torrents info
		$tor_to_show_sql = implode(',', $tor_to_show_ary);

		// SELECT
		$select_sql = 'SELECT tor.*, t.*, u.username, f.forum_id, f.forum_name, cat.cat_id, cat.cat_title';
		$select_sql .= ($only_active) ? ', COUNT(tr.peer_id) as peers, SUM(tr.seeder) as seeders, SUM(tr.speed_up) as speed_up, SUM(tr.speed_down) as speed_down' : '';

		// FROM (??..it's better to use LEFT JOIN here..?? to combine with other queries)
		$from_sql = "FROM $torrents_tbl, $topics_tbl, $users_tbl, $forums_tbl, $cat_tbl";
		$from_sql .= ($only_active) ? ", $tracker_tbl" : '';

		// WHERE
		$where_sql = "
			WHERE tor.torrent_id IN($tor_to_show_sql)
				AND tor.topic_id = t.topic_id
				AND tor.poster_id = u.user_id
				AND t.forum_id = f.forum_id
				AND f.cat_id = cat.cat_id
		";
		$where_sql .= ($only_active) ? "
			AND tor.torrent_id = tr.torrent_id
			AND tr.expire_time > $current_time
		" :	'';

		// GROUP
		$group_sql = ($only_active) ? 'GROUP BY tr.torrent_id' : '';

		// Full SQL query
		$sql = "
			$select_sql
			$from_sql
			$where_sql
				$ignore_forum_sql
			$group_sql
		";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query torrents information', '', __LINE__, __FILE__, $sql);
		}

		if (!$tor_rows = @$db->sql_fetchrowset($result))
		{
			$template->assign_block_vars('tor_not_found', array('L_NO_MATCH' => $lang['No_match']));
		}
		else
		{
			$db->sql_freeresult($result);
			$torrents_sql = $topics_sql = array();

			foreach ($tor_rows as $rid => $row)
			{
				$torrents[$row['torrent_id']] = $row;
				$topics_sql[] = $row['topic_id'];
				$torrents_sql[] = $row['torrent_id'];
			}
			$topics_sql = implode(',', $topics_sql);
			$torrents_sql = implode(',', $torrents_sql);

			unset($tor_rows);

			// Get peers info
			if (!$only_active)
			{
				$sql = 'SELECT torrent_id, COUNT(peer_id) as peers, SUM(seeder) as seeders, SUM(speed_up) as speed_up, SUM(speed_down) as speed_down
					FROM '. BT_TRACKER_TABLE ."
					WHERE torrent_id IN($torrents_sql)
						AND expire_time > $current_time
					GROUP BY torrent_id";

				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not obtain peers information', '', __LINE__, __FILE__, $sql);
				}

				if ($peers_info = @$db->sql_fetchrowset($result))
				{
					$db->sql_freeresult($result);

					foreach ($peers_info as $rid => $row)
					{
						$tid = $row['torrent_id'];

						$torrents[$tid]['peers'] = $row['peers'];
						$torrents[$tid]['seeders'] = $row['seeders'];
						$torrents[$tid]['speed_up'] = $row['speed_up'];
						$torrents[$tid]['speed_down'] = $row['speed_down'];
					}
					unset($peers_info);
				}
			}

			// Get user DL status
			if (!$guest)
			{
				$sql = "SELECT tor.torrent_id, dl.user_status
					FROM $torrents_tbl, $dl_stat_tbl
					WHERE dl.topic_id IN($topics_sql)
						AND dl.user_id = $user_id
						AND dl.topic_id = tor.topic_id";

				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not obtain DL status information', '', __LINE__, __FILE__, $sql);
				}

				if ($dl_info = @$db->sql_fetchrowset($result))
				{
					$db->sql_freeresult($result);

					foreach ($dl_info as $rid => $row)
					{
						$tid = $row['torrent_id'];

						$torrents[$tid]['dl_stat'] = $row['user_status'];
					}
					unset($dl_info);
				}
			}

			// Build main table
			foreach ($tor_to_show_ary as $tor_id)
			{
				if (!$tor_row = $torrents[$tor_id])
				{
					continue;
				}

				$dl = (isset($tor_row['speed_down'])) ? $tor_row['speed_down'] : 0;
				$ul = (isset($tor_row['speed_up'])) ? $tor_row['speed_up'] : 0;

				$seeds  = (isset($tor_row['seeders'])) ? $tor_row['seeders'] : 0;
				$leechs = (isset($tor_row['peers'])) ? ($tor_row['peers'] - $tor_row['seeders']) : 0;

				$s_last = $tor_row['seeder_last_seen'];
				$att_id = $tor_row['attach_id'];
				$size   = $tor_row['size'];
				$compl  = $tor_row['complete_count'];
				$dl_sp  = ($dl) ? humn_size($dl, 0, 'KB') .'/s' : '-';
				$ul_sp  = ($ul) ? 'UL: '. humn_size($ul, 0, 'KB') .'/s' : '';

				if (!$guest && $tor_row['reg_time'] > $lastvisit)
				{
					$post_img = '<img src="'. $images['icon_minipost_new'] .'" width="12" height="9">';
				}
				else
				{
					$post_img = '<img src="'. $images['icon_minipost'] .'" width="12" height="9">';
				}

				$dl_class  = (isset($tor_row['dl_stat'])) ? $dl_st_ary[$tor_row['dl_stat']] : 'genmed';

				$row_class = (!($row_num % 2)) ? $row_class_1 : $row_class_2;
				$row_num++;

				 switch ($tor_row['topic_check_status'])
				         {
					        case 1: 
							$tcs_id='<span style="color:indigo;">&#9674;</span>'; 
							$tcs_title='Проверяется';
						break; 
						case 2: 
							$tcs_id='<span style="color:green;">&radic;</span>'; 
							$tcs_title='Оформлено';
						break; 
						case 3: 
							$tcs_id='<span style="color:#E6C506;">&#8776;</span>'; 
							$tcs_title='Недоофолмлено';
						break; 
					        case 4: 
							$tcs_id='<span style="color:red;">&#8800;</span>'; 
							$tcs_title='Неоформлено';
						break; 
					        case 5: 
							$tcs_id='<span style="color:blue;">&#8734;</span>'; 
							$tcs_title='Повтор';
						break; 
					        default: 
							$tcs_id='<span style="color:red;">?</span>';
							$tcs_title='Не проверено';

				         }

				$template->assign_block_vars('tor', array(
					'CAT_ID'       => $tor_row['cat_id'],
					'CAT_HREF'     => append_sid("$tracker_basename?$cat_key=". $tor_row['cat_id']),
					'CAT_TITLE'    => $tor_row['cat_title'],
					'FORUM_ID'     => $tor_row['forum_id'],
					'FORUM_HREF'   => append_sid("$tracker_basename?$forum_key=". $tor_row['forum_id']),
					'FORUM_NAME'   => $tor_row['forum_name'],
					'TOPIC_ID'     => $tor_row['topic_id'],
					'TOPIC_HREF'   => append_sid("viewtopic.php?$topic_key=". $tor_row['topic_id']),
					'TOPIC_TITLE'  => $tor_row['topic_title'],
					'POSTER_ID'    => $tor_row['poster_id'],
					'POSTER_HREF'  => append_sid("$tracker_basename?$poster_id_key=". $tor_row['poster_id']),
					'USERNAME'     => $tor_row['username'],
					'TITLE_AUTHOR' => ($show_author_val) ? '' : ' by: '. $tor_row['username'] .' ',
					'TCS_ID'       => $tcs_id,
					'TCS_TITLE'    => $tcs_title,
					'TITLE_SPEED'  => ($show_speed_val) ? '' : (($dl) ? " $dl_sp " : ''),

					'ROW_CLASS'    => $row_class,
					'ROW_NUM'      => $row_num,
					'DL_CLASS'     => $dl_class,
					'POST_IMG'     => $post_img,
					'USER_AUTHOR'  => (!$guest && $tor_row['poster_id'] == $user_id) ? TRUE : FALSE,

					'DL_TOR_HREF'  => append_sid("download.php?id=". $att_id),
					'TOR_SIZE_RAW' => $size,
					'TOR_SIZE'     => humn_size($size, '', '', ' '),
					'UL_SPEED'     => $ul_sp,
					'DL_SPEED'     => $dl_sp,
					'SEEDS'        => ($seeds) ? $seeds : 0,
					'SEEDS_TITLE'  => ($seeds) ? 'Seeders' : (" Last seen: \n ". (($s_last) ? create_date($date_format, $s_last, $board_config['board_timezone']) : 'Never')),
					'LEECHS'       => ($leechs) ? $leechs : 0,
					'COMPLETED'    => ($compl) ? $compl : 0,
					'ADDED_RAW'    => $tor_row['reg_time'],
					'ADDED_TIME'   => create_date($time_format, $tor_row['reg_time'], $board_config['board_timezone']),
					'ADDED_DATE'   => create_date($date_format, $tor_row['reg_time'], $board_config['board_timezone'])
				));
			}
		}
	}
}
else
{
	$template->assign_block_vars('tor_not_found', array('L_NO_MATCH' => $lang['Bt_No_searchable_forums']));
}

// Pagination
if ($tor_count)
{
	$base_url = $tracker_basename .'?search_id='. $search_id;
	$l_search_matches = ($tor_count == 1) ? sprintf($lang['Found_search_match'], $tor_count) : sprintf($lang['Found_search_matches'], $tor_count);
	$l_search_max = "(max: $tor_search_limit)";

	$template->assign_vars(array(
		'L_MATCHES'    => $l_search_matches,
		'L_SERACH_MAX' => $l_search_max,
		'PAGINATION'   => generate_pagination($base_url, $tor_count, $tor_per_page, $start),
		'PAGE_NUMBER'  => sprintf($lang['Page_of'], (floor($start / $tor_per_page) + 1), ceil($tor_count / $tor_per_page))
	));
}

// Forum select
$select_size = ($cat_forum_size < $max_forum_sel_size) ? $cat_forum_size : $max_forum_sel_size;

foreach ($cat_forum as $cat_id => $cat_row)
{
	$opt .= '<optgroup label="&nbsp;'. $cat_row['cat_title'] .'">';

	foreach ($cat_row['f'] as $forum_id => $forum_desc)
	{
		$selected = ($forum_val == $search_all || in_array($forum_id, $search_in_forums_ary)) ? $sl : '';
		//sf
		$opt .= '<option value="'. $forum_id .'" '. $selected .'>'. ((in_array($forum_id, $subforums)) ? SF_SEL_SPACER : '') . $forum_desc .'&nbsp;</option>';
	}

	$opt .= '</optgroup>';
}

$cat_forum_select = '<select name="'. $forum_key .'[]" multiple="multiple" size="'. $select_size .'"><option value="'. $search_all .'">&nbsp;'. $lang['All_available'] .'</option>'. $opt .'</select>';

// Order select
foreach ($order_opt as $val => $opt)
{
	$selected = ($val == $order_val) ? $sl : '';
	$order_options .= '<option value="'. $val .'" '. $selected .'>&nbsp;'. $opt['lang'] .'&nbsp;</option>';
}

// Search time
foreach ($time_opt as $val => $opt)
{
	$selected = ($val == $time_val) ? $sl : '';
	$time_options .= '<option value="'. $val .'" '. $selected .'>&nbsp;'. $opt['lang'] .'&nbsp;</option>';
}

// Seeder not seen
foreach ($s_not_seen_opt as $val => $opt)
{
	$selected = ($val == $s_not_seen_val) ? $sl : '';
	$s_not_seen_options .= '<option value="'. $val .'" '. $selected .'>&nbsp;'. $opt['lang'] .'&nbsp;</option>';
}

// Sort dir
$template->assign_vars(array(
	'SORT_NAME'           => $sort_key,
	'SORT_ASC'            => $sort_asc,
	'SORT_DESC'           => $sort_desc,
	'SORT_ASC_CHECKED'    => ($sort_val == $sort_asc) ? $ch : '',
	'SORT_DESC_CHECKED'   => ($sort_val == $sort_desc) ? $ch : ''
));

// Displaying options
$template->assign_vars(array(
	'SHOW_FORUM_NAME'     => $show_forum_key,
	'SHOW_FORUM_VAL'      => $show_forum_val,
	'SHOW_FORUM_CHECKED'  => ($show_forum_val) ? $ch : '',
	'SHOW_AUTHOR_NAME'    => $show_author_key,
	'SHOW_AUTHOR_VAL'     => $show_author_val,
	'SHOW_AUTHOR_CHECKED' => ($show_author_val) ? $ch : '',
	'SHOW_SPEED_NAME'     => $show_speed_key,
	'SHOW_SPEED_VAL'      => $show_speed_val,
	'SHOW_SPEED_CHECKED'  => ($show_speed_val) ? $ch : '',
	'SEED_EXIST_NAME'     => $seed_exist_key,
	'SEED_EXIST_VAL'      => $seed_exist_val,
	'SEED_EXIST_CHECKED'  => ($seed_exist) ? $ch : '',
	'ONLY_ACTIVE_NAME'    => $active_key,
	'ONLY_ACTIVE_VAL'     => $active_val,
	'ONLY_ACTIVE_CHECKED' => ($only_active) ? $ch : '',
	'ONLY_MY_NAME'        => $my_key,
	'ONLY_MY_VAL'         => $my_val,
	'ONLY_MY_CHECKED'     => ($only_my) ? $ch : '',
	'ONLY_NEW_NAME'       => $new_key,
	'ONLY_NEW_VAL'        => $new_val,
	'ONLY_NEW_CHECKED'    => ($only_new) ? $ch : '',

	'ONLY_NEW_DISABLED'   => ($guest) ? $ds : '',
	'ONLY_MY_DISABLED'    => ($guest) ? $ds : '',

	'ORDER_NAME'          => $order_key,
	'ORDER_VAL'           => $order_val,
	'TIME_NAME'           => $time_key,
	'TIME_VAL'            => $time_val,
	'S_NOT_SEEN_NAME'     => $s_not_seen_key,
	'S_NOT_SEEN_VAL'      => $s_not_seen_val,
	'POSTER_NAME_NAME'    => $poster_name_key,
	'POSTER_NAME_VAL'     => htmlspecialchars($poster_name_val),
	'TITLE_MATCH_NAME'    => $title_match_key,
	'TITLE_MATCH_VAL'     => $title_match_val
));

// Set colspan
$tor_colspan = $tor_colspan - $hide_forum - $hide_author - $hide_speed;

$template->assign_vars(array(
	'CAT_FORUM_SELECT'   => $cat_forum_select,
	'ORDER_OPTIONS'      => $order_options,
	'TIME_OPTIONS'       => $time_options,
	'S_NOT_SEEN_OPTIONS' => $s_not_seen_options,
	'TOR_SEARCH_ACTION'  => $tracker_basename,
	'TOR_COLSPAN'        => $tor_colspan,
	'TITLE_MATCH_MAX'    => $title_match_max_len,
	'POSTER_NAME_MAX'    => $poster_name_max_len,
	'POSTER_ERROR'       => $poster_error,
	'TP_VER'             => TP_VER,

	'SHOW_FORUM'         => $show_forum_val,
	'SHOW_AUTHOR'        => $show_author_val,
	'SHOW_SPEED'         => $show_speed_val
));

$template->assign_vars(array(
	'L_AUTHOR'        => $lang['Author'],
	'L_CATEGORY'      => $lang['Category'],
	'L_COMPL'         => $lang['Completed'],
	'L_DL'            => $lang['Tor_DL'],
	'L_FORUM'         => $lang['Forum'],
	'L_LASTPOST'      => $lang['Last_Post'],
	'L_LEECHERS'      => $lang['Leechers'],
	'L_POSTED'        => $lang['Posted'],
	'L_POSTS'         => $lang['Posts'],
	'L_REPLIES'       => $lang['Replies'],
	'L_SEEDERS'       => $lang['Seeders'],
	'L_SIZE'          => $lang['Tor_Size'],
	'L_DL_SPEED'      => $lang['Bt_DL_speed'],
	'L_TOPIC'         => $lang['Topic'],
	'L_TOPICS'        => $lang['Topics'],
	'L_VIEWS'         => $lang['Views'],
	'L_SEARCH'        => $lang['Search'],
	'L_ONLY_ACTIVE'   => $lang['Bt_Only_Active'],
	'L_ONLY_MY'       => $lang['Bt_Only_My'],
	'L_SEED_EXIST'    => $lang['Bt_Seed_exist'],
	'L_SEED_GT'       => $lang['Bt_Seed_gt'],
	'L_ONLY_NEW'      => $lang['Bt_Only_New'],
	'L_ONLY_NEW_IMG'  => $images['icon_minipost_new'],
	'L_SHOW_CAT'      => $lang['Bt_Show_Cat'],
	'L_SHOW_FORUM'    => $lang['Bt_Show_Forum'],
	'L_SHOW_AUTHOR'   => $lang['Bt_Show_Author'],
	'L_SHOW_SPEED'    => $lang['Bt_Show_Speed'],
	'L_SORT_ASC'      => $lang['Sort_Ascending'],
	'L_SORT_DESC'     => $lang['Sort_Descending'],
	'L_SEARCH_IN'     => $lang['Bt_Search_in'],
	'L_SORT_BY'       => $lang['Sort_by'],
	'L_POSTS_FROM'    => $lang['Bt_Posts_from'],
	'L_SHOW_ONLY'     => $lang['Bt_Show_only'],
	'L_DISPLAYING'    => $lang['Bt_Displaying'],
	'L_SEED_NOT_SEEN' => $lang['Bt_Seed_not_seen'],
	'L_TITLE_MATCH'   => $lang['Bt_Title_match']
));

$page_title = 'Трекер';
include(FT_ROOT .'includes/page_header.php');

$template->set_filenames(array('body' => 'tracker.tpl'));

$template->pparse('body');

include(FT_ROOT .'includes/page_tail.php');