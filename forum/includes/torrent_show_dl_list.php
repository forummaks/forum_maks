<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$show_canceled_in_count_mode  = FALSE;
$title_date_format            = 'Y-m-d';
$dl_list_sql_limit            = 300;              // DL-List overall limit
$max_dl_users_before_overflow = 100;              // for each dl-status
$dl_users_overflow_div_height = '120px';
$dl_users_div_style_normal    = 'padding: 0px;';
$dl_users_div_style_overflow  = "padding: 6px; height: $dl_users_overflow_div_height; overflow: auto; border: 1px inset;";

$count_mode = ($board_config['bt_dl_list_only_count'] && !(isset($_GET['dl']) && $_GET['dl'] == 'names')) ? TRUE : FALSE;
$peers_full_mode = (@$_GET['spmode'] == 'full') ? TRUE : FALSE;

$template->assign_vars(array('DL_BUTTONS' => FALSE));

$show_dl_list = ($forum_topic_data['topic_dl_type'] == TOPIC_DL_TYPE_DL && $board_config['bt_show_dl_list']) ? TRUE : FALSE;
if ($show_dl_list && ($board_config['bt_dl_list_only_1st_page'] && $start))
{
	$show_dl_list = FALSE;
}

// link to clear DL-List
if (($is_auth['auth_mod']) && ($forum_topic_data['topic_dl_type'] == TOPIC_DL_TYPE_DL))
{
	$s_dl_delete = "<br /><a href=\"dl_list.php?mode=dl_delete&amp;". POST_TOPIC_URL ."=$topic_id&amp;sid=". $userdata['session_id'] .'">'. $lang['DL_List_Del'] .'</a>';
	$template->assign_vars(array('S_DL_DELETE' => $s_dl_delete));
}

$dl_info = array();

if ($show_dl_list)
{
	$dl_status_val = array(
		DL_STATUS_WILL     => 'dlWill',
		DL_STATUS_DOWN     => 'dlDown',
		DL_STATUS_COMPLETE => 'dlComplete',
		DL_STATUS_CANCEL   => 'dlCancel'
	);
	$dl_cat   = array();
	$dl_count = array();

	foreach ($dl_status_val as $i => $desc)
	{
		$dl_cat[$i]   = '';
		$dl_count[$i] = 0;
	}

	$dl_count_only = ($count_mode && (!$board_config['bt_dl_list_expire'] || $peers_full_mode)) ? TRUE : FALSE;
	$expired_users  = array();
	$dl_expire_time = time() - ($board_config['bt_dl_list_expire'] * 60*60*24);

	if ($dl_count_only)
	{
		$sql = 'SELECT user_status, COUNT(*) AS username
			FROM '. BT_USR_DL_STAT_TABLE ."
			WHERE topic_id = $topic_id
			GROUP BY user_status";
	}
	else
	{
		$sql = 'SELECT d.user_status, d.user_id, d.update_time, u.username
			FROM '. BT_USR_DL_STAT_TABLE .' d, '. USERS_TABLE ." u
			WHERE d.topic_id = $topic_id
				AND d.user_id = u.user_id
			ORDER BY d.user_status ASC, d.update_time DESC
			LIMIT $dl_list_sql_limit";
	}

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain download data for this topic', '', __LINE__, __FILE__, $sql);
	}

	if ($dl_info = @$db->sql_fetchrowset($result))
	{
		$db->sql_freeresult($result);

		if ($count_mode)
		{
			$template->assign_block_vars('dl_counts', array());
		}
		else
		{
			$template->assign_block_vars('dl_users', array());
		}

		foreach ($dl_info as $i => $user)
		{
			$exp_time = '';

			if (!$dl_count_only && $board_config['bt_dl_list_expire'] && ($user['user_status'] == DL_STATUS_WILL || $user['user_status'] == DL_STATUS_DOWN))
			{
				if ($user['update_time'] < $dl_expire_time)
				{
					$expired_users[] = $user['user_id'];
					continue;
				}

				$exp_time = create_date($title_date_format, ($user['update_time'] + ($board_config['bt_dl_list_expire'] * 60*60*24)), $board_config['board_timezone']);
			}

			$upd_time = $upd_time_title = $u_prof_href = '';
			$u_link_class = $dl_status_val[$user['user_status']];

			if ($dl_count_only)
			{
				$dl_cat[$user['user_status']] = $user['username'];
				$dl_count[$user['user_status']] = $user['username'];
			}
			else
			{
				$upd_time = create_date($title_date_format, $user['update_time'], $board_config['board_timezone']);
				$upd_time_title = ($exp_time) ? " upd: $upd_time \n exp: $exp_time " : " $upd_time ";
				$u_prof_href = ($user['user_id'] == ANONYMOUS) ? '#' : append_sid("profile.php?mode=viewprofile&amp;u=". $user['user_id']) .'#torrent';
				$dl_cat[$user['user_status']] .= '<nobr><a class="'. $u_link_class .'" href="'. $u_prof_href .'" title="'. $upd_time_title .'">'. $user['username'] .'</a></nobr>, ';
				$dl_count[$user['user_status']]++;
			}
		}

		if ($expired_users = implode(',', $expired_users))
		{
			require_once(FT_ROOT .'includes/functions_dl_list.php');

			$sql = 'DELETE FROM '. BT_USR_DL_STAT_TABLE ."
				WHERE topic_id = $topic_id
					AND user_id IN($expired_users)";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete expired users from DL-List', '', __LINE__, __FILE__, $sql);
			}

			update_topics_dl_status($topic_id, 'expire');
		}

		foreach ($dl_status_val as $i => $desc)
		{
			if ($dl_cat[$i] && $count_mode && !$board_config['bt_dl_list_expire'])
			{
				if ($i == DL_STATUS_CANCEL && !$show_canceled_in_count_mode && !$peers_full_mode)
				{
					continue;
				}
				$dl_cat[$i][strlen($dl_cat[$i])-2] = ' ';
				$template->assign_block_vars('dl_counts.count_row', array(
					'DL_OPTION_NAME'   => $lang[$desc .'_2'],
					'DL_OPTION_USERS'  => $dl_cat[$i]));
			}
			else if ($dl_cat[$i] && !$count_mode)
			{
				$dl_users_div_style = ($dl_count[$i] > $max_dl_users_before_overflow) ? $dl_users_div_style_overflow : $dl_users_div_style_normal;
				$dl_cat[$i][strlen($dl_cat[$i])-2] = ' ';
				$dl_cat[$i] = "<span class=$desc>". $dl_cat[$i] .'</span>';
				$template->assign_block_vars('dl_users.users_row', array(
					'DL_OPTION_NAME'     => $lang[$desc .'_2'],
					'DL_OPTION_USERS'    => $dl_cat[$i],
					'DL_COUNT'           => $dl_count[$i],
					'DL_USERS_DIV_STYLE' => $dl_users_div_style));
			}
			else if ($dl_count[$i] && $count_mode)
			{
				if ($i == DL_STATUS_CANCEL && !$show_canceled_in_count_mode && !$peers_full_mode)
				{
					continue;
				}
				$template->assign_block_vars('dl_counts.count_row', array(
					'DL_OPTION_NAME'   => $lang[$desc .'_2'],
					'DL_OPTION_USERS'  => $dl_count[$i]));
			}
		}
	}
	else
	{
		$template->assign_block_vars('dl_list_none', array());
	}

	if ($board_config['bt_show_dl_list_buttons'] && $forum_topic_data['show_dl_buttons'] /* && $userdata['session_logged_in'] */)
	{
		$template->assign_vars(array(
			'DL_BUTTONS'    => TRUE,
			'DL_BUT_WILL'   => ($board_config['bt_show_dl_but_will']) ? TRUE : FALSE,
			'DL_BUT_DOWN'   => ($board_config['bt_show_dl_but_down']) ? TRUE : FALSE,
			'DL_BUT_COMPL'  => ($board_config['bt_show_dl_but_compl']) ? TRUE : FALSE,
			'DL_BUT_CANCEL' => ($board_config['bt_show_dl_but_cancel']) ? TRUE : FALSE
		));
	}

	$dl_hidden_fields = '
		<input type="hidden" name="sid" value="'. $userdata['session_id'] .'" />
		<input type="hidden" name="'. POST_FORUM_URL .'" value="'. $forum_id .'" />
		<input type="hidden" name="'. POST_TOPIC_URL .'" value="'. $topic_id .'" />
		<input type="hidden" name="mode" value="set_dl_status" />
	';

	$template->assign_vars(array(
		'L_DL_LIST_TIP_1'  => $lang['dl_list_tip_1'],
		'L_NONE'           => $lang['None'],
		'L_DL_WILL'        => $lang['dlWill'],
		'L_DL_DOWN'        => $lang['dlDown'],
		'L_DL_COMPLETE'    => $lang['dlComplete'],
		'L_DL_CANCEL'      => $lang['dlCancel'],
		'DL_HIDDEN_FIELDS' => $dl_hidden_fields,
		'S_DL_ACTION'      => append_sid("dl_list.php?". POST_TOPIC_URL ."=$topic_id")
		)
	);

//$template->set_filenames(array('dlbox' => 'dl_list.tpl'));
//$template->assign_var_from_handle('DLLIST_DISPLAY', 'dlbox');
}

$template->assign_vars(array('SHOW_DL_LIST' => $show_dl_list));
unset($dl_info);