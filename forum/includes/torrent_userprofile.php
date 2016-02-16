<?php

if (!defined('IN_PROFILE')) die(basename(__FILE__));

if (!$profiledata['user_id'] || $profiledata['user_id'] == ANONYMOUS)
{
	message_die(GENERAL_ERROR, 'Invalid user_id');
}

$seeding = $leeching = array();

$seed = $release = $leech = $affected_torrents = $unsorted = $seed_cnt = $leech_cnt = $speed_up = $speed_down = $stats = array();	// seed-release-leech

$profile_user_id = intval($profiledata['user_id']);
$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();

// Get username
if (!$username = $profiledata['username'])
{
	message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user');
}

if ($profile_user_id == $userdata['user_id'])
{
	$template->assign_vars(array(
		'EDIT_PROF'      => TRUE,
		'L_EDIT_PROF'    => $lang['Edit_profile'],
		'EDIT_PROF_HREF' => append_sid("profile.php?mode=editprofile")
	));
}
else
{
	$template->assign_vars(array('EDIT_PROF' => FALSE));
}

// Get up/down stat & auth_key
$sql = 'SELECT *
	FROM '. BT_USERS_TABLE ."
	WHERE user_id = $profile_user_id";

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query users torrent profile information', '', __LINE__, __FILE__, $sql);
}

$user_tor_info = $db->sql_fetchrow($result);

$total_uploaded   = (@$user_tor_info['u_up_total']) ? $user_tor_info['u_up_total'] : 0;
$total_downloaded = (@$user_tor_info['u_down_total']) ? $user_tor_info['u_down_total'] : 0;
$total_bonus      = (@$user_tor_info['u_bonus_total']) ? $user_tor_info['u_bonus_total'] : 0;
$up_down_ratio = ($total_downloaded) ? round((($total_uploaded + $total_bonus) / $total_downloaded), 2) : '-';

$auth_key         = (@$user_tor_info['auth_key']) ? $user_tor_info['auth_key'] : '';

if ($userdata['user_level'] == ADMIN)
{
	$template->assign_block_vars('switch_auth_key', array());
	$template->assign_vars(array('AUTH_KEY' => $auth_key));
}

$template->assign_vars(array(
	'TOTAL_UPLOADED'   => humn_size($total_uploaded),
	'TOTAL_DOWNLOADED' => humn_size($total_downloaded),
	'TOTAL_BONUS'      => humn_size($total_bonus),
	'WHAT_IS_BONUS' => '<a href="'.append_sid("viewtopic.php?t=147").'" class="genmed">'.$lang['Bt_What_Is_Bonus'].'</a>',	
	'UP_DOWN_RATIO'    => $up_down_ratio
));

// get affected torrents
$sql = "SELECT torrent_id
		FROM " . BT_TRACKER_TABLE . " 
		WHERE user_id = " . $profile_user_id ;
$result = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Cant query affected torrents', '', __LINE__, __FILE__, $sql);
while($row = $db->sql_fetchrow($result))	
{
	$affected_torrents[] = $row['torrent_id'];
}
unset($row);

// Auth
$ignore_forum_sql = ($f = user_not_auth_forums(AUTH_VIEW)) ? "AND f.forum_id NOT IN($f)" : '';

if ($affected_count = count($affected_torrents))
{
	$affected_torrents = implode(", ", $affected_torrents);
	$affected_torrents = 'AND tr.torrent_id IN (' . $affected_torrents . ')';
	
	$leech_cnt = $seed_cnt = $peer_cnt = $speed_up = $speed_down = array();
	
	$sql = " SELECT f.forum_id, f.forum_name, 
					t.topic_id, t.topic_title,
					tr.seeder, tr.releaser, tr.peer_id, tr.speed_up, tr.speed_down, tr.user_id, tr.torrent_id,
					tor.poster_id				
			 FROM	" . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . BT_TRACKER_TABLE . " tr, " . BT_TORRENTS_TABLE . " tor
			 WHERE	tr.expire_time > " . TIMENOW . "
			 AND 	tr.torrent_id = tor.torrent_id
			 AND 	tor.topic_id = t.topic_id
			 AND 	t.forum_id = f.forum_id

						$ignore_forum_sql
						$affected_torrents
			
			 ORDER BY f.forum_name, t.topic_title ";
	$result = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not query ', '', __LINE__, __FILE__, $sql);
	while($row = $db->sql_fetchrow($result))
	{
		$leech_cnt[$row['torrent_id']] = 0;
		$unsorted[] = $row;
		$speed_up[$row['torrent_id']] += $row['speed_up'];
		$speed_down[$row['torrent_id']] += $row['speed_down'];
		
		switch($row['seeder'])
		{
			case 1: $seed_cnt[$row['torrent_id']]++  ; break;
			case 0: $leech_cnt[$row['torrent_id']]++ ; break;	
		}
	}
		
	unset($row);
	
	$stats = array(
				  speed_up    => $speed_up
				, speed_down  => $speed_down
				, seed_count  => $seed_cnt
				, leech_count => $leech_cnt
				);
	$l = $m = $n = 0;
	
	$unsorted_count = count($unsorted);	
	for($i = 0; $i < $unsorted_count; $i++ )
	{		
		if( $unsorted[$i]['seeder'] && !$unsorted[$i]['releaser'] && ($unsorted[$i]['user_id'] == $profile_user_id) )
		{
			$seed[] = $unsorted[$i];			
			$seed[$l]['speed_up']    = $stats['speed_up'][$unsorted[$i]['torrent_id']];
			$seed[$l]['seed_count']  = $stats['seed_count'][$unsorted[$i]['torrent_id']];
			$seed[$l]['leech_count'] = $stats['leech_count'][$unsorted[$i]['torrent_id']];
		$l++;
		}		
		elseif( $unsorted[$i]['releaser'] && ($unsorted[$i]['user_id'] == $profile_user_id) )
		{
			
			$release[] = $unsorted[$i];
			$release[$m]['speed_up']    = $stats['speed_up'][$unsorted[$i]['torrent_id']];
			$release[$m]['seed_count']  = $stats['seed_count'][$unsorted[$i]['torrent_id']];
			$release[$m]['leech_count'] = $stats['leech_count'][$unsorted[$i]['torrent_id']];
		$m++;	
		}
		elseif( !$unsorted[$i]['seeder'] && ($unsorted[$i]['user_id'] == $profile_user_id) )
		{
			$leech[] = $unsorted[$i];
			$leech[$n]['speed_down']  = $stats['speed_down'][$unsorted[$i]['torrent_id']];
			$leech[$n]['seed_count']  = $stats['seed_count'][$unsorted[$i]['torrent_id']];
			$leech[$n]['leech_count'] = $stats['leech_count'][$unsorted[$i]['torrent_id']];
		$n++;	
		}
	}	
}

// seed output
if ($seeding_count = count($seed))
{
    $template->assign_block_vars('seed', array());

    for ($i=0; $i<$seeding_count; $i++)
    {
        $template->assign_block_vars('seed.seedrow', array(
            'F_SEED_COUNT' => $seed[$i]['seed_count'],
            'F_LEECH_COUNT'=> $seed[$i]['leech_count'] ,
            'F_SPEED_UP'   => humn_size($seed[$i]['speed_up']).'/s',
            'FORUM_NAME'   => $seed[$i]['forum_name'],
            'TOPIC_TITLE'  => $seed[$i]['topic_title'],
            'U_VIEW_FORUM' => "viewforum.php?". POST_FORUM_URL .'='. $seed[$i]['forum_id'],
            'U_VIEW_TOPIC' => "viewtopic.php?". POST_TOPIC_URL .'='. $seed[$i]['topic_id'] .'&amp;spmode=full#seeders'
        ));
    }
}
else
{
    $template->assign_block_vars('switch_seeding_none', array());
}

//release output
if ($release_count = count($release))
{
    $template->assign_block_vars('release', array());

    for ($i=0; $i<$release_count; $i++)
    {
        $template->assign_block_vars('release.releaserow', array(
            'F_SEED_COUNT' => $release[$i]['seed_count'],
            'F_LEECH_COUNT'=> $release[$i]['leech_count'],
            'F_SPEED_UP'   => humn_size($release[$i]['speed_up']).'/s',
            'FORUM_NAME'   => $release[$i]['forum_name'],
            'TOPIC_TITLE'  => $release[$i]['topic_title'],
            'U_VIEW_FORUM' => "viewforum.php?". POST_FORUM_URL .'='. $release[$i]['forum_id'],
            'U_VIEW_TOPIC' => "viewtopic.php?". POST_TOPIC_URL .'='. $release[$i]['topic_id'] .'&amp;spmode=full#seeders'
        ));
    }
}
else
{
    $template->assign_block_vars('switch_release_none', array());
}

//leech output
if ($leeching_count = count($leech))
{
    $template->assign_block_vars('leech', array());

    for ($i=0; $i<$leeching_count; $i++)
    {
        $template->assign_block_vars('leech.leechrow', array(
            'F_SEED_COUNT'        => $leech[$i]['seed_count'],
            'F_LEECH_COUNT'    => $leech[$i]['leech_count'],
            'F_SPEED_DOWN'     => humn_size($leech[$i]['speed_down']).'/s',
            'FORUM_NAME'       => $leech[$i]['forum_name'],
            'TOPIC_TITLE'      => $leech[$i]['topic_title'],
            'U_VIEW_FORUM'     => "viewforum.php?". POST_FORUM_URL .'='. $leech[$i]['forum_id'],
            'U_VIEW_TOPIC'     => "viewtopic.php?". POST_TOPIC_URL .'='. $leech[$i]['topic_id'] .'&amp;spmode=full#leechers'
        ));
    }
}
else
{
    $template->assign_block_vars('switch_leeching_none', array());
} 

$template->assign_vars(array(
	'USERNAME'   => $username,
	'L_NONE'     => $lang['None'],
	'L_FORUM'    => $lang['Forum'],
	'L_TOPICS'   => $lang['Topics'],
	'L_INFO'	 => $lang['Info'],
	'L_SEEDING'  => '<b>'. $lang['Seeding'] .'</b>'. (($seeding_count) ? "<br />[ <b>$seeding_count</b> ]" : ''),
	'L_LEECHING' => '<b>'. $lang['Leeching'] .'</b>'. (($leeching_count) ? "<br />[ <b>$leeching_count</b> ]" : ''),
	'L_RELEASING'=> '<b>'. $lang['Releasing'] .'</b>'. (($release_count) ? "<br />[ <b>$release_count</b> ]" : ''),

	'L_VIEW_TOR_PROF'  => sprintf($lang['Viewing_user_bt_profile'], $username),
	'L_CUR_ACTIVE_DLS' => $lang['Cur_active_dls'],
	'SEED_ROWSPAN'     => ($seeding_count) ? 'rowspan="'. ($seeding_count + 1) .'"' : '',
	'RELEASE_ROWSPAN'  => ($release_count) ? 'rowspan="'. ($release_count + 1) .'"' : '',
	'LEECH_ROWSPAN'    => ($leeching_count) ? 'rowspan="'. ($leeching_count + 1) .'"' : ''
));

$s_link_start = "search.php?search_id=dl&amp;dl_status=";
$s_link_end   = "&amp;dl_uid=$profile_user_id";

$template->assign_vars(array(
	'L_SEARCH_DL'          => $lang['Search_DL'],
	'L_SEARCH_DL_WILL'     => $lang['Search_DL_Will'],
	'L_SEARCH_DL_DOWN'     => $lang['Search_DL_Down'],
	'L_SEARCH_DL_COMPLETE' => $lang['Search_DL_Complete'],
	'L_SEARCH_DL_CANCEL'   => $lang['Search_DL_Cancel'],

	'U_SEARCH_DL_WILL'     => $s_link_start . DL_STATUS_WILL     . $s_link_end,
	'U_SEARCH_DL_DOWN'     => $s_link_start . DL_STATUS_DOWN     . $s_link_end,
	'U_SEARCH_DL_COMPLETE' => $s_link_start . DL_STATUS_COMPLETE . $s_link_end,
	'U_SEARCH_DL_CANCEL'   => $s_link_start . DL_STATUS_CANCEL   . $s_link_end
));

$template->assign_vars(array(
	'U_TORRENT_PROFILE' => append_sid("profile.php?mode=viewprofile&amp;u=". $profiledata['user_id']) . '#torrent',
	'L_TORRENT_PROFILE' => $lang['View_torrent_profile'],
      'U_SEARCH_RELEASES' => "tracker.php?pid={$profiledata['user_id']}" 
));