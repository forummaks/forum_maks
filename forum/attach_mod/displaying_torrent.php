<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

global $board_config, $bb_cfg, $forum_topic_data, $poster_id, $is_auth;

$change_peers_bgr_over = TRUE;
$bgr_class_1    = 'prow1';
$bgr_class_2    = 'prow2';
$bgr_class_over = 'prow3';

$show_peers_limit          = 300;
$max_peers_before_overflow = 20;
$peers_overflow_div_height = '400px';
$peers_div_style_normal    = 'padding: 3px;';
$peers_div_style_overflow  = "padding: 6px; height: $peers_overflow_div_height; overflow: auto; border: 1px inset;";
$s_last_seed_date_format   = 'Y-m-d';

$peers_cnt = $seed_count = 0;
$seeders = $leechers = '';
$template->assign_vars(array(
	'AUTH_MOVE'        => FALSE,
	'SEED_COUNT'       => FALSE,
	'LEECH_COUNT'      => FALSE,
	'PEERS_OVERFLOW'   => FALSE,
	'SEEDER_LAST_SEEN' => FALSE
));
// time=all - for debug (this will show peers from all time, i.e. including all dead peers)
$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();
$cfg_s_mode = $s_mode = $board_config['bt_show_peers_mode'];
$get_s_mode = (isset($_GET['spmode'])) ? $_GET['spmode'] : '';

// Define show peers mode (count only || user names with complete % || full details)
if ($board_config['bt_allow_spmode_change'])
{
	if ($get_s_mode == 'count')
	{
		$s_mode = 'count';
	}
	else if ($get_s_mode == 'names')
	{
		$s_mode = 'names';
	}
	else if ($get_s_mode == 'full')
	{
		$s_mode = 'full';
	}
	else if ($cfg_s_mode == SHOW_PEERS_COUNT)
	{
		$s_mode = 'count';
	}
	else if ($cfg_s_mode == SHOW_PEERS_NAMES)
	{
		$s_mode = 'names';
	}
	else if ($cfg_s_mode == SHOW_PEERS_FULL)
	{
		$s_mode = 'full';
	}
	else
	{
		message_die(GENERAL_ERROR, 'Invalid show peers mode');
	}
}

$template->assign_vars(array(
	'L_SEED'             => $lang['Seeders'],
	'L_LEECH'            => $lang['Leechers'],
	'L_SEED_ORDER_DESC'  => $lang['Sort_by'],
	'L_LEECH_ORDER_DESC' => $lang['Sort_by'],
	'L_TRACKER'          => $lang['Tracker'],
	'L_REGED'            => $lang['Registered'],
	'L_TORRENT_SIZE'     => $lang['Tor_Size'],
	'L_PIECE_LENGTH'     => $lang['Piece_length'],
	'L_COMPLETED'        => $lang['Completed'],
	'L_POSTED'           => $lang['Tor_Posted'],
	'L_CONFIRM'          => $lang['Confirm'],
	'L_DEL_TORRENT'      => $lang['Tor_Delete'] ,
	'L_DEL_MOVE_TORRENT' => $lang['Tor_Del_Move']
));

$bt_topic_id    = $forum_topic_data['topic_id'];
$attach_id      = $attachments['_'. $post_id][$i]['attach_id'];
$tracker_status = $attachments['_'. $post_id][$i]['tracker_status'];
$download_count = $attachments['_'. $post_id][$i]['download_count'];
$tor_file_size  = humn_size($attachments['_'. $post_id][$i]['filesize']);
$tor_file_time  = create_date($board_config['default_dateformat'], $attachments['_'. $post_id][$i]['filetime'], $board_config['board_timezone']);

$tor_reged = ($tracker_status) ? TRUE : FALSE;
$show_peers = ($board_config['bt_show_peers']) ? TRUE : FALSE;

$locked = ($forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED) ? TRUE : FALSE;
$tor_auth = ($userdata['user_id'] != ANONYMOUS && (($userdata['user_id'] == $poster_id && !$locked) || $is_auth['auth_mod'])) ? TRUE : FALSE;

$tor_auth_reg = ($tor_auth && $forum_topic_data['allow_reg_tracker'] && $post_id == $forum_topic_data['topic_first_post_id']) ? TRUE : FALSE;
$tor_auth_del = ($tor_auth && $tor_reged) ? TRUE : FALSE;

$tracker_link  = ($tor_reged) ? $lang['Bt_Reg_YES'] : $lang['Bt_Reg_NO'];
$download_link = append_sid("download.$phpEx?id=$attach_id");
$description   = ($comment) ? $comment : preg_replace("#.torrent$#i", '', $display_name);

if ($tor_auth_reg || $tor_auth_del)
{
	$reg_href   = "torrent.$phpEx?mode=reg&amp;id=$attach_id&amp;sid="	. $userdata['session_id'];
	$unreg_href = "torrent.$phpEx?mode=unreg&amp;id=$attach_id&amp;sid=". $userdata['session_id'];

	$reg_tor_url   = '<a class="genmed" href="'.$reg_href.'">'   . $lang['Bt_Reg_on_tracker']     .'</a>';
	$unreg_tor_url = '<a class="genmed" href="'.$unreg_href.'">'. $lang['Bt_Unreg_from_tracker'] .'</a>';

	$tracker_link = ($tor_reged) ? $unreg_tor_url : $reg_tor_url;
}

if (!$tor_reged)
{
	$template->assign_block_vars('postrow.attach.tor_not_reged', array(
		'DOWNLOAD_NAME'       => $display_name,
		'TRACKER_LINK'        => $tracker_link,

		'S_UPLOAD_IMAGE'      => $upload_image,
		'U_DOWNLOAD_LINK'     => $download_link,
		'FILESIZE'            => $tor_file_size,

		'L_DOWNLOADED_VIEWED' => $lang['Downloaded'],
		'L_DOWNLOAD_COUNT'    => sprintf($lang['Download_number'], $download_count),
		'POSTED_TIME'         => $tor_file_time
	));

	if ($comment)
	{
		$template->assign_block_vars('postrow.attach.tor_not_reged.comment', array('COMMENT' => $comment));
	}
}
else
{
	$sql = 'SELECT btt.*, u.username
            FROM '. BT_TORRENTS_TABLE .' btt
            LEFT JOIN '.USERS_TABLE.' u on u.user_id=btt.topic_check_uid
            WHERE btt.attach_id = '.$attach_id.'
            LIMIT 1';

	if (!$result = $db->sql_query($sql))
	{
		 message_die(GENERAL_ERROR, 'Could not obtain torrent information', '', __LINE__, __FILE__, $sql);
	}

	$tor_row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$tor_size = ($tor_row['size']) ? $tor_row['size'] : 0;
	$tor_id   = $tor_row['torrent_id'];

	switch ($tor_row['topic_check_status'])
	         {
	         case 1: $topic_check_status='<span style="color:indigo;font-weight:bold;">&#9674; Проверяется</span>.'; break; 
	         case 2: $topic_check_status='<span style="color:green;font-weight:bold;">&radic; Оформлено</span>.'; break; 
	         case 3: $topic_check_status='<span style="color:#E6C506;font-weight:bold;">&#8776; Недооформлено</span>.'; break; 
	         case 4: $topic_check_status='<span style="color:red;font-weight:bold;">&#8800; Неоформлено</span>.'; break; 
	         case 5: $topic_check_status='<span style="color:blue;font-weight:bold;">&#8734;  Повтор</span>'; 
			 $topic_check_status.=($tor_row['topic_check_duble_tid'])?' <a href="viewtopic.'.$phpEx.'?t='.$tor_row['topic_check_duble_tid'].'">(?)</a>.':'.';
		 break; 
	         default: $topic_check_status='<span style="color:red;font-weight:bold;">? Не проверено</span>.';
	         }
	if ($tor_row['topic_check_status'])
	{
		$topic_check_status.= '<span style="font-style:italic;">'.' (<a href="profile.'.$phpEx.'?mode=viewprofile&u='.$tor_row['topic_check_uid'].'"><b>'.$tor_row['username'].'</b></a>:'.create_date('d.m.Y, H:i:s', $tor_row['topic_check_date'], $userdata['user_timezone']).')</span>';
	}
	$download_url=(in_array($tor_row['topic_check_status'], array(4, 5)))? $lang['Download']:'<a href="'.$download_link.'" style="font-size: 13px; font-weight: bold; text-decoration: none">'.$lang['Download'].'</a>';

	$template->assign_block_vars('postrow.attach.tor_reged', array(
		'DOWNLOAD_NAME'       => $display_name,
		'TRACKER_LINK'        => $tracker_link,

		'S_UPLOAD_IMAGE'      => $upload_image,
		'U_DOWNLOAD_LINK'     => $download_link,
		'U_DOWNLOAD_URL'      => $download_url,
		'TOPIC_CHECK_STATUS'  => $topic_check_status,
		'FILESIZE'            => $tor_file_size,

		'L_DOWNLOADED_VIEWED' => $lang['Downloaded'],
		'L_DOWNLOAD_COUNT'    => sprintf($lang['Download_number'], $download_count),
		'REGED_TIME'          => create_date($board_config['default_dateformat'], $tor_row['reg_time'], $board_config['board_timezone']),

		'TORRENT_SIZE'        => humn_size($tor_size),
		'PIECE_LENGTH'        => humn_size($tor_row['piece_length']),
		'COMPLETED'           => sprintf($lang['Download_number'], $tor_row['complete_count'])
	));

	if ($is_auth['auth_mod'])
	{
		$template->assign_block_vars('postrow.attach.tor_reged.mod', array(
			'ACT' => "topic_check_status.$phpEx",
			'SID'       => $userdata['session_id'],
			'ATTACH_ID' => $attach_id,
			'IN_NATIVE_F' => (!$tor_row['topic_check_first_fid'])
		));
	}
	if ($userdata['user_id']==$poster_id && ($tor_row['topic_check_status']=='3' || $tor_row['topic_check_status']=='4') )
	{
		$template->assign_block_vars('postrow.attach.tor_reged.auther', array(
			'ACT' => "topic_check_status.$phpEx",
			'SID'       => $userdata['session_id'],
			'ATTACH_ID' => $attach_id
		));
	}

	if ($comment)
	{
		$template->assign_block_vars('postrow.attach.tor_reged.comment', array('COMMENT' => $comment));
	}

	if ($tor_auth_del)
	{
		$template->assign_block_vars('postrow.attach.tor_reged.controls', array(
			'ACTION'    => "torrent.$phpEx",
			'SID'       => $userdata['session_id'],
			'ATTACH_ID' => $attach_id
		));

		if ($forum_topic_data['self_moderated'] || $is_auth['auth_mod'])
		{
			$template->assign_vars(array('AUTH_MOVE' => TRUE));
		}
	}

      // torrent info
      if ($tor_reged && $bb_cfg['show_tor_info'])
      {
         $template->assign_vars(array(
            'SHOW_DL_LIST'          => true,
            'SHOW_DL_LIST_TOR_INFO' => true,

            'TOR_SIZE'      => humn_size($tor_size),
            'TOR_LONGEVITY' => create_date("d-M-y", $tor_row['reg_time'], $board_config['board_timezone']),
            'TOR_COMPLETED' => sprintf($lang['Download_number'], $tor_row['complete_count']),
         ));
      }
      // end torrent info

      $sql = "SELECT COUNT(torrent_id) as peers, SUM(speed_up) AS speed_up, SUM(speed_down) AS speed_down 
		FROM " . BT_TRACKER_TABLE . " 
		WHERE torrent_id = '".$tor_row['torrent_id']."' 
		AND expire_time > $current_time 
		GROUP BY torrent_id";

	if (!$result = $db->sql_query($sql)) 
	{ 
		 message_die(GENERAL_ERROR, 'Could not obtain torrent information', '', __LINE__, __FILE__, $sql); 
	} 
	while( $row = $db->sql_fetchrow($result) ) 
	{ 
	$speed_up = humn_size($row['speed_up']).'/s';
	$speed_down = humn_size($row['speed_down']).'/s'; 
	}
	$template->assign_vars(array(
		'SEED_SPEED' => $speed_up,
		'LEECH_SPEED' => $speed_down )); 

	// Show peers
	if ($show_peers)
	{
		// Sorting order in full mode
		if ($s_mode == 'full')
		{
			$full_mode_order = 'tr.complete_percent';
			$full_mode_sort_dir = 'DESC';

			if (isset($_REQUEST['psortasc']))
			{
				$full_mode_sort_dir = 'ASC';
			}
			else if (isset($_REQUEST['psortdesc']))
			{
				$full_mode_sort_dir = 'DESC';
			}

			if (isset($_REQUEST['porder']))
			{
				$peer_orders = array(
					'name'  => 'u.username',
					'ip'    => 'tr.ip',
					'port'  => 'tr.port',
					'compl' => 'tr.complete_percent',
					'cup'   => 'tr.uploaded',
					'tup'   => 'tst.t_up_total',
					'cdown' => 'tr.downloaded',
					'tdown' => 'tst.t_down_total',
					'sup'   => 'tr.speed_up',
					'sdown' => 'tr.speed_down'
				);

				foreach ($peer_orders as $get_key => $order_by_value)
				{
					if ($_REQUEST['porder'] == $get_key)
					{
						$full_mode_order = $order_by_value;
						break;
					}
				}
			}
		}

		// SQL for each mode
		if ($s_mode == 'count')
		{
			$sql = 'SELECT COUNT(DISTINCT ip) AS peers, seeder
				FROM '. BT_TRACKER_TABLE ."
				WHERE torrent_id = $tor_id
					AND expire_time > $current_time
				GROUP BY seeder, ip, port, user_id";
		}
		else if ($s_mode == 'names')
		{
			$sql = 'SELECT tr.user_id, tr.ip, tr.port, tr.complete_percent, tr.seeder, u.username
				FROM '. BT_TRACKER_TABLE .' tr, '. USERS_TABLE ." u
				WHERE tr.torrent_id = $tor_id
					AND tr.expire_time > $current_time
					AND u.user_id = tr.user_id
				GROUP BY tr.ip, tr.user_id, tr.port, tr.seeder
				ORDER BY u.username
				LIMIT $show_peers_limit";
		}
		else
		{
			$sql = 'SELECT tr.user_id, tr.ip, tr.port, tr.uploaded, tr.downloaded, tr.complete_percent, tr.seeder, tr.speed_up, tr.speed_down, tr.update_time, tr.expire_time, tst.t_up_total, tst.t_down_total, u.username
				FROM '. BT_TRACKER_TABLE .' tr
				LEFT JOIN '. USERS_TABLE .' u ON u.user_id = tr.user_id
				LEFT JOIN '. BT_TOR_DL_STAT_TABLE ." tst ON tst.torrent_id = tr.torrent_id AND tst.user_id = tr.user_id
				WHERE tr.torrent_id = $tor_id
					AND tr.expire_time > $current_time
				GROUP BY tr.ip, tr.user_id, tr.port, tr.seeder
				ORDER BY $full_mode_order $full_mode_sort_dir
				LIMIT $show_peers_limit";
		}

		if (!$result = $db->sql_query($sql))
		{
			 message_die(GENERAL_ERROR, 'Could not obtain peers information', '', __LINE__, __FILE__, $sql);
		}

		// Build peers table
		if ($peers = @$db->sql_fetchrowset($result))
		{
			$db->sql_freeresult($result);
			$peers_cnt = count($peers);

			$cnt = $tr = $sp_up = $sp_down = $sp_up_tot = $sp_down_tot = array();
			$cnt['s'] = $tr['s'] = $sp_up['s'] = $sp_down['s'] = $sp_up_tot['s'] = $sp_down_tot['s'] = 0;
			$cnt['l'] = $tr['l'] = $sp_up['l'] = $sp_down['l'] = $sp_up_tot['l'] = $sp_down_tot['l'] = 0;

			$max_up = $max_down = $max_sp_up = $max_sp_down = array();
			$max_up['s'] = $max_down['s'] = $max_sp_up['s'] = $max_sp_down['s'] = 0;
			$max_up['l'] = $max_down['l'] = $max_sp_up['l'] = $max_sp_down['l'] = 0;
			$max_up_id['s'] = $max_down_id['s'] = $max_sp_up_id['s'] = $max_sp_down_id['s'] = ($peers_cnt + 1);
			$max_up_id['l'] = $max_down_id['l'] = $max_sp_up_id['l'] = $max_sp_down_id['l'] = ($peers_cnt + 1);

			if ($s_mode == 'full')
			{
				foreach ($peers as $pid => $peer)
				{
					$x = ($peer['seeder']) ? 's' : 'l';
					$cnt[$x]++;
					$sp_up_tot[$x] += $peer['speed_up'];
					$sp_down_tot[$x] += $peer['speed_down'];

					$guest      = ($peer['user_id'] == ANONYMOUS) ? TRUE : FALSE;
					$p_max_up   = ($guest) ? $peer['uploaded'] : max($peer['t_up_total'], $peer['uploaded']);
					$p_max_down = ($guest) ? $peer['downloaded'] : max($peer['t_down_total'], $peer['downloaded']);

					if ($p_max_up > $max_up[$x])
					{
						$max_up[$x]	= $p_max_up;
						$max_up_id[$x] = $pid;
					}
					if ($peer['speed_up'] > $max_sp_up[$x])
					{
						$max_sp_up[$x] = $peer['speed_up'];
						$max_sp_up_id[$x] = $pid;
					}
					if ($p_max_down > $max_down[$x])
					{
						$max_down[$x] = $p_max_down;
						$max_down_id[$x] = $pid;
					}
					if ($peer['speed_down'] > $max_sp_down[$x])
					{
						$max_sp_down[$x] = $peer['speed_down'];
						$max_sp_down_id[$x] = $pid;
					}
				}
				$max_down_id['s'] = $max_sp_down_id['s'] = ($peers_cnt + 1);

				if ($cnt['s'] == 1)
				{
					$max_up_id['s'] = $max_sp_up_id['s'] = ($peers_cnt + 1);
				}
				if ($cnt['l'] == 1)
				{
					$max_up_id['l'] = $max_down_id['l'] = $max_sp_up_id['l'] = $max_sp_down_id['l'] = ($peers_cnt + 1);
				}
			}

			if ($s_mode == 'count')
			{
				$tmp = array();
				$tmp[0]['seeder'] = $tmp[0]['username'] = $tmp[1]['username'] = 0;
				$tmp[1]['seeder'] = 1;

				foreach ($peers as $pid => $peer)
				{
					if ($peer['seeder'])
					{
						$tmp[1]['username'] += $peer['peers'];
					}
					else
					{
						$tmp[0]['username'] += $peer['peers'];
					}
				}
				$peers = $tmp;
			}

			foreach ($peers as $pid => $peer)
			{
				if ($s_mode == 'count' || $peer['user_id'] == ANONYMOUS)
				{
					$u_prof_href = '#';
				}
				else
				{
					$u_prof_href = append_sid("profile.$phpEx?mode=viewprofile&amp;u=". $peer['user_id']) .'#torrent';
				}

				if (isset($peer['user_id']) && $peer['user_id'] == ANONYMOUS)
				{
					$peer['username'] = 'Guest';
				}

				// Full details mode
				if ($s_mode == 'full')
				{
					$guest = ($peer['user_id'] == ANONYMOUS) ? TRUE : FALSE;
					// peer max/current up/down
					$p_max_up   = ($guest) ? $peer['uploaded'] : max($peer['t_up_total'], $peer['uploaded']);
					$p_max_down = ($guest) ? $peer['downloaded'] : max($peer['t_down_total'], $peer['downloaded']);
					$p_cur_up   = $peer['uploaded'];
					$p_cur_down = $peer['downloaded'];
					$compl_prc_title = '';

					if ($peer['seeder'])
					{
						$x = 's';
						$x_row = 'srow';
						$x_full = 'sfull';
						$link_class = 'seedmed';

						if (!defined('SEEDER_EXIST'))
						{
							define('SEEDER_EXIST', TRUE);
							$seed_order_action = append_sid("viewtopic.$phpEx?". POST_TOPIC_URL ."=$bt_topic_id&amp;spmode=full") .'#seeders';

							$template->assign_block_vars("$x_full", array(
								'SEED_ORD_ACT'   => $seed_order_action,
								'SEEDERS_UP_TOT' => humn_size($sp_up_tot[$x], 0, 'KB') .'/s'
							));

							if ($is_auth['auth_mod'] || !$board_config['bt_show_ip_only_moder'])
							{
								$template->assign_block_vars("$x_full.iphead", array());
							}
							if ($is_auth['auth_mod'] || !$board_config['bt_show_port_only_moder'])
							{
								$template->assign_block_vars("$x_full.porthead", array());
							}
						}
						$complete_prc    = ($tor_size) ? round(($p_max_up / $tor_size), 1) : 0;
						$compl_prc_title = ($tor_size) ? round(($p_max_up / $tor_size), 2) : 0;
					}
					else
					{
						$x = 'l';
						$x_row = 'lrow';
						$x_full = 'lfull';
						$link_class = 'leechmed';

						if (!defined('LEECHER_EXIST'))
						{
							define('LEECHER_EXIST', TRUE);
							$leech_order_action = append_sid("viewtopic.$phpEx?". POST_TOPIC_URL ."=$bt_topic_id&amp;spmode=full") .'#leechers';

							$template->assign_block_vars("$x_full", array(
								'LEECH_ORD_ACT'     => $leech_order_action,
								'LEECHERS_UP_TOT'   => humn_size($sp_up_tot[$x], 0, 'KB') .'/s',
								'LEECHERS_DOWN_TOT' => humn_size($sp_down_tot[$x], 0, 'KB') .'/s'
							));

							if ($is_auth['auth_mod'] || !$board_config['bt_show_ip_only_moder'])
							{
								$template->assign_block_vars("$x_full.iphead", array());
							}
							if ($is_auth['auth_mod'] || !$board_config['bt_show_port_only_moder'])
							{
								$template->assign_block_vars("$x_full.porthead", array());
							}
						}
						$complete_prc = ($peer['complete_percent']) ? $peer['complete_percent'] : '0';
					}

					$rel_sign = (!$guest && $peer['user_id'] == $poster_id) ? '<span class="seed">&nbsp;<b><sup>&reg;</sup></b>&nbsp;</span>' : '';
					$name     = '<a href="'. $u_prof_href .'" class="'. $link_class .'">'. $peer['username'] .'</a>'. $rel_sign;
					$ip       = bt_show_ip($peer['ip']);
					$port     = bt_show_port($peer['port']);
					$up_cur   = ($p_cur_up)   ? humn_size($p_cur_up)   : 0;
					$down_cur = ($p_cur_down) ? humn_size($p_cur_down) : 0;
					$up_tot   = ($p_max_up)   ? humn_size($p_max_up)   : '-';
					$down_tot = ($p_max_down) ? humn_size($p_max_down) : '-';
					$up_ratio = ($p_max_down) ? round(($p_max_up / $p_max_down), 2) : '';
					$sp_up    = ($peer['speed_up'])   ? humn_size($peer['speed_up'],   0, 'KB') .'/s' : '-';
					$sp_down  = ($peer['speed_down']) ? humn_size($peer['speed_down'], 0, 'KB') .'/s' : '-';
					$upd_time = create_date('H:i', $peer['update_time'], $board_config['board_timezone']);
					$exp_time = create_date('H:i', $peer['expire_time'], $board_config['board_timezone']);

					$bgr_class = (!($tr[$x] % 2)) ? $bgr_class_1 : $bgr_class_2;
					$row_bgr   = ($change_peers_bgr_over) ? " class=\"$bgr_class\" onmouseover=\"this.className='$bgr_class_over';\" onmouseout=\"this.className='$bgr_class';\"" : '';
					$tr[$x]++;

					$template->assign_block_vars("$x_full.$x_row", array(
						'ROW_BGR'       => $row_bgr,
						'NAME'          => $name,
						'COMPL_PRC'     => $complete_prc,
						'COMPL_PRC_TTL' => $compl_prc_title,
						'UP_CURR'       => ($p_cur_up != $p_max_up)      ? "current: $up_cur"   : 'current',
						'DOWN_CURR'     => ($p_cur_down != $p_max_down)  ? "current: $down_cur" : 'current',
						'UP_TOTAL'      => ($max_up_id[$x] == $pid)      ? "<b>$up_tot</b>"    : $up_tot,
						'DOWN_TOTAL'    => ($max_down_id[$x] == $pid)    ? "<b>$down_tot</b>"  : $down_tot,
						'SPEED_UP'      => ($max_sp_up_id[$x] == $pid)   ? "<b>$sp_up</b>"    : $sp_up,
						'SPEED_DOWN'    => ($max_sp_down_id[$x] == $pid) ? "<b>$sp_down</b>"  : $sp_down,
						'UPD_EXP_TIME'  => "upd: $upd_time\nexp: $exp_time",
						'UP_DOWN_RATIO' => ($up_ratio) ? "UL/DL ratio: $up_ratio"  : ''
					));

					if ($ip)
					{
						$template->assign_block_vars("$x_full.$x_row.ip", array('IP' => $ip));
					}
					if (isset($port))
					{
						$template->assign_block_vars("$x_full.$x_row.port", array('PORT' => $port));
					}
				}
				// Count only & only names modes
				else
				{
					if ($peer['seeder'])
					{
						$seeders .= '<nobr><a href="'. $u_prof_href .'" class="seedmed">'. $peer['username'] .'</a>,</nobr> ';
						$seed_count = $peer['username'];
					}
					else
					{
						$leechers .= '<nobr><a href="'. $u_prof_href .'" class="leechmed">'. $peer['username'] .'</a>';
						$leechers .= ($s_mode == 'names') ? ' ['. $peer['complete_percent'] .'%]' : '';
						$leechers .= ',</nobr> ';
						$leech_count = $peer['username'];
					}
				}
			}

			if ($s_mode != 'full' && $seeders)
			{
				$seeders[strlen($seeders)-9] = ' ';
				$template->assign_vars(array('SEED_LIST' => $seeders));
				$template->assign_vars(array('SEED_COUNT' => ($seed_count) ? $seed_count : 0));
			}
			if ($s_mode != 'full' && $leechers)
			{
				$leechers[strlen($leechers)-9] = ' ';
				$template->assign_vars(array('LEECH_LIST' => $leechers));
				$template->assign_vars(array('LEECH_COUNT' => ($leech_count) ? $leech_count : 0));
			}
		}

		if ($s_mode == 'full' && (defined('SEEDER_EXIST') || defined('LEECHER_EXIST')))
		{
			$name_opt        = '<option value="name">Username</option>';
			$seed_compl_opt  = '<option value="tup">Upload ratio</option>';
			$leech_compl_opt = '<option value="compl">Completed</option>';

			$up_down_speed_opt = '
			<option value="tup">Uploaded</option>
			<option value="tdown">Downloaded</option>
			<option value="sup">Upload speed</option>
			<option value="sdown">Download speed</option>';

			$ip_opt = ($ip) ? '<option value="ip">IP</option>' : '';
			$port_opt = (isset($port)) ? '<option value="port">Port</option>' : '';

			if ($cnt['s'] > 2)
			{
				$seed_order_select = $name_opt . $seed_compl_opt . $up_down_speed_opt . $ip_opt . $port_opt;
				$template->assign_block_vars('sfull.sorder', array('SEED_ORDER_SELECT' => '<select name="porder" class="prow1">'. $seed_order_select .'</select>'));
			}
			if ($cnt['l'] > 2)
			{
				$leech_order_select = $name_opt . $leech_compl_opt . $up_down_speed_opt . $ip_opt . $port_opt;
				$template->assign_block_vars('lfull.lorder', array('LEECH_ORDER_SELECT' => '<select name="porder" class="prow1">'. $leech_order_select .'</select>'));
			}
		}

		// Show "seeder last seen info"
		if (($s_mode == 'count' && !$seed_count) || (!$seeders && !defined('SEEDER_EXIST')))
		{
			$last_seeder_name = '';
			$last_seen_time = ($tor_row['seeder_last_seen']) ? create_date($s_last_seed_date_format, $tor_row['seeder_last_seen'], $board_config['board_timezone']) : 'Никогда';

			if ($last_seeder_uid = $tor_row['last_seeder_uid'])
			{
				$sql = 'SELECT username
					FROM '. USERS_TABLE ."
					WHERE user_id = $last_seeder_uid
					LIMIT 1";
				$last_seeder_name = ($row = @$db->sql_fetchrow($db->sql_query($sql))) ? '<b><a class="seed" href="'. append_sid("profile.$phpEx?mode=viewprofile&amp;". POST_USERS_URL .'='. $tor_row['last_seeder_uid']) .'">'. $row['username'] .'</a></b>' : '';
			}
			$template->assign_vars(array('SEEDER_LAST_SEEN' => "Полный источник $last_seeder_name был: $last_seen_time"));
		}
	}

	$template->assign_block_vars('tor_title', array('U_DOWNLOAD_LINK' => $download_link));

	if ($peers_cnt > $max_peers_before_overflow && $s_mode == 'full')
	{
		$template->assign_vars(array('PEERS_DIV_STYLE' => $peers_div_style_overflow));
		$template->assign_vars(array('PEERS_OVERFLOW' => TRUE));
	}
	else
	{
		$template->assign_vars(array('PEERS_DIV_STYLE' => $peers_div_style_normal));
	}
}

if ($board_config['bt_allow_spmode_change'] && $s_mode != 'full')
{
	$template->assign_vars(array(
		'PEERS_FULL_LINK'  => TRUE,
		'SPMODE_FULL_HREF' => append_sid("viewtopic.$phpEx?". POST_TOPIC_URL ."=$bt_topic_id&amp;spmode=full") .'#seeders',
		'L_SPMODE_FULL'    => $lang['spmode_full']
	));
}

$template->assign_vars(array(
	'SHOW_TOR_ACT' => ($tor_reged && $show_peers) ? TRUE : FALSE,
	'S_MODE_COUNT' => ($s_mode == 'count') ? TRUE : FALSE,
	'S_MODE_NAMES' => ($s_mode == 'names') ? TRUE : FALSE,
	'S_MODE_FULL'  => ($s_mode == 'full') ? TRUE : FALSE,
	'PEER_EXIST'   => ($seeders || $leechers || defined('SEEDER_EXIST') || defined('LEECHER_EXIST')) ? TRUE : FALSE,
	'SEED_EXIST'   => ($seeders || defined('SEEDER_EXIST')) ? TRUE : FALSE,
	'LEECH_EXIST'  => ($leechers || defined('LEECHER_EXIST')) ? TRUE : FALSE
));

?>