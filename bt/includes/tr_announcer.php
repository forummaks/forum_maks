<?php

require(INC_TR_DB_INIT);

$up_add = $down_add = $bl_add = 0;
$output = $lp_inf = array();
$current_time = (isset($_GET['time']) && $_GET['time'] == 'all') ? 0 : time();

// Tracker config
if (!$tr_cfg)
{
	require_once(INC_TR_FUNC_CACHE);

	$tr_cfg = get_config_ary(BT_CONFIG_TABLE);

	if (TR_USE_CACHE && check_cache_dir(CACHE_DIR))
	{
		$cfg_cached = write_cfg_to_cache(CACHE_TR_CFG, $tr_cfg, '$tr_cfg');
	}
}

$u_stat_upd_intrv = $tr_cfg['user_statistic_upd_interval'] * 60;

// Output mode
init_output();

// Exit if tracker is disabled
if ($tr_cfg['off'])
{
	error_exit($tr_cfg['off_reason'], '', '', 'off');
}

// Browser redirect
if ($tr_cfg['browser_redirect_url'])
{
	browser_redirect();
}

// Clean peers table
if ($tr_cfg['autoclean'] && ($tr_cfg['last_clean_time'] + ($tr_cfg['autoclean_interval'] * 60)) < $current_time)
{
	$peer_dead_time = $current_time - ($tr_cfg['autoclean_interval'] * 60);

	$sql = 'DELETE FROM '. BT_TRACKER_TABLE ."
		WHERE expire_time < $peer_dead_time";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	$sql = 'UPDATE '. BT_CONFIG_TABLE ." SET
			config_value = $current_time
		WHERE config_name = 'last_clean_time'";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	$delete_cache = (TR_USE_CACHE) ? @unlink(CACHE_TR_CFG) : '';
}

// Recover info_hash if we use passkey
if (isset($_GET['?info_hash']) && !isset($_GET['info_hash']))
{
	$_GET['info_hash'] = $_GET['?info_hash'];
}

// Define input var names
// Strings
$input_vars_str = array(
	'info_hash',
	'peer_id',
	'ip',
	'event',
	$tr_cfg['auth_key_name']
);

// Numeric
$input_vars_num = array(
	'port',
	'uploaded',
	'downloaded',
	'left',
	'numwant',
	'compact',
	'no_peer_id'
);

// Init received variables
// Strings
foreach ($input_vars_str as $var_name)
{
	if (isset($_GET[$var_name]))
	{
		$$var_name = unesc($_GET[$var_name]);
	}
	else
	{
		unset($$var_name);
	}
}

// Numeric
foreach ($input_vars_num as $var_name)
{
	if (isset($_GET[$var_name]))
	{
		$$var_name = $_GET[$var_name] + 0;
	}
	else
	{
		unset($$var_name);
	}
}

// Define passkey
$auth_key = (isset($$tr_cfg['auth_key_name'])) ? $$tr_cfg['auth_key_name'] : '';

// Verify request
// Required params (info_hash, peer_id, port, uploaded, downloaded, left)
if (!isset($info_hash) || strlen($info_hash) != 20)
{
	error_exit('Invalid info_hash');
}
if (!isset($peer_id) || strlen($peer_id) != 20)
{
	error_exit('Invalid peer_id');
}
if (!isset($port) || $port < 0 || $port > 0xFFFF)
{
	error_exit('Invalid port');
}
if (!isset($uploaded) || $uploaded < 0)
{
	error_exit('Invalid uploaded value');
}
if (!isset($downloaded) || $downloaded < 0)
{
	error_exit('Invalid downloaded value');
}
if (!isset($left) || $left < 0)
{
	error_exit('Invalid left value');
}
// Optional params (numwant, event, auth_key)
if (isset($numwant) && $numwant < 0)
{
	error_exit('Invalid numwant request');
}
if (isset($event) && ($event != 'started') && ($event != 'completed') && ($event != 'stopped'))
{
	error_exit('Invalid event');
}
if ($auth_key && strlen($auth_key) != BT_AUTH_KEY_LENGTH)
{
	error_exit('Invalid passkey length');
}
if ($tr_cfg['use_auth_key'] && !$auth_key && !$tr_cfg['allow_guest_dl'])
{
	error_exit('Please LOG IN and REDOWNLOAD this torrent (passkey not found)');
}
if ($tr_cfg['compact_mode'] && !isset($compact))
{
	error_exit('Please enable COMPACT MODE in your client');
}

// Escape SQL string data
$info_hash_sql = rtrim(sqlesc($info_hash), ' ');
$peer_id_sql   = rtrim(sqlesc($peer_id), ' ');
$auth_key_sql  = sqlesc($auth_key);

// Define IP
if ($tr_cfg['ignor_given_ip'] || !isset($ip) || !$ip)
{
	$ip = $_SERVER['REMOTE_ADDR'];
}
// if IP is hostname
else if (!verify_ip($ip))
{
	if ($tr_cfg['allow_host_ip'])
	{
		$ip = gethostbyname($ip);

		if (!verify_ip($ip))
		{
			error_exit("Unable to resolve host name $ip");
		}
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
}

if (!verify_ip($ip))
{
	error_exit("Invalid IP: $ip");
}

// convert IP to phpBB compatible format
$ip = encode_ip($ip);

// Define "numwant"
if ($tr_cfg['ignor_numwant'] || !isset($numwant) || !$numwant)
{
	$numwant = $tr_cfg['numwant'];
}
else
{
	$numwant = min($numwant, $tr_cfg['numwant_max']);
}

// Define tracker peers-list output mode (standard, compact...) and events
$started   = (isset($event) && $event == 'started') ? TRUE : FALSE;
$stopped   = (isset($event) && $event == 'stopped') ? TRUE : FALSE;
$completed = (isset($event) && $event == 'completed') ? TRUE : FALSE;

$compact_mode    = ($tr_cfg['compact_mode'] || isset($compact)) ? TRUE : FALSE;
$no_peer_id_mode = (isset($no_peer_id)) ? TRUE : FALSE;

// Define if peer is seeder (this value will stored in DB)
$seeder = ($left == 0) ? 1 : 0;

// Verify if torrent registered on tracker and user authorized
if ($tr_cfg['use_auth_key'] && $auth_key)
{
	$sql = 'SELECT t.torrent_id, t.attach_id, t.topic_id, t.poster_id, t.size, t.seeder_last_seen, u.user_id, u.u_up_total, u.u_down_total
		FROM '. BT_TORRENTS_TABLE .' t
		LEFT JOIN '. BT_USERS_TABLE ." u ON u.auth_key = '$auth_key_sql'
		WHERE t.info_hash = '$info_hash_sql'
		LIMIT 1";
}
else
{
	$sql = 'SELECT torrent_id, attach_id, topic_id, poster_id, size, seeder_last_seen
		FROM '. BT_TORRENTS_TABLE ."
		WHERE info_hash = '$info_hash_sql'
		LIMIT 1";
}

if (!$result = $db->sql_query($sql))
{
	error_exit('DB error', __FILE__, __LINE__, 'db', 'info_hash_md5='. md5($info_hash) .', auth_key='. $auth_key);
}

$row = $db->sql_fetchrow($result);

if (!$row || !isset($row['torrent_id']))
{
	error_exit('Torrent not registered');
}

if ($tr_cfg['use_auth_key'] && !$tr_cfg['allow_guest_dl'] && !isset($row['user_id']))
{
	error_exit('Please LOG IN and REDOWNLOAD this torrent (error: user not found)');
}

$tor_size    = $row['size'];
$topic_id    = $row['topic_id'];
$attach_id   = $row['attach_id'];
$poster_id   = $row['poster_id'];
$torrent_id  = $row['torrent_id'];
$s_last_seen = $row['seeder_last_seen'];

$user_id = ($row['user_id']) ? $row['user_id'] : GUEST_UID;
$guest   = ($user_id == GUEST_UID) ? TRUE : FALSE;

$user_rating = ($row['u_down_total']) ? ($row['u_up_total'] / $row['u_down_total']) : 1;
$rating_msg = '';

if (TR_RATING_LIMITS && !$guest && !$seeder)
{
	foreach ($rating_limits_ary as $ratio => $limit)
	{
		if ($user_rating < $ratio)
		{
			$tr_cfg['limit_active_tor'] = 1;
			$tr_cfg['limit_leech_count'] = $limit;
			$rating_msg = " (ratio < $ratio)";
			break;
		}
	}
}

// Limit active torrents
if (!$guest && $tr_cfg['limit_active_tor'] && (($tr_cfg['limit_seed_count'] && $seeder) || ($tr_cfg['limit_leech_count'] && !$seeder)))
{
	$sql = 'SELECT COUNT(DISTINCT torrent_id) AS active_torrents
		FROM '. BT_TRACKER_TABLE ."
		WHERE user_id = $user_id
			AND seeder = $seeder
			AND torrent_id != $torrent_id";

	if (!$seeder && $tr_cfg['leech_expire_factor'] && $user_rating < 0.5)
	{
		$sql .= ' AND update_time > '. ($current_time - 60*$tr_cfg['leech_expire_factor']);
	}
	else
	{
		$sql .= " AND expire_time > $current_time";
	}

	$sql .= '	GROUP BY user_id';

	if (!$result = $db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	if ($row = $db->sql_fetchrow($result))
	{
		if ($seeder && $tr_cfg['limit_seed_count'] && $row['active_torrents'] >= $tr_cfg['limit_seed_count'])
		{
			error_exit('Only '. $tr_cfg['limit_seed_count'] .' torrent(s) allowed for seeding');
		}
		else if (!$seeder && $tr_cfg['limit_leech_count'] && $row['active_torrents'] >= $tr_cfg['limit_leech_count'])
		{
			error_exit('Only '. $tr_cfg['limit_leech_count'] .' torrent(s) allowed for leeching'. $rating_msg);
		}
	}
}

// Limit concurrent IP's
if (!$guest && $tr_cfg['limit_concurrent_ips'] && (($tr_cfg['limit_seed_ips'] && $seeder) || ($tr_cfg['limit_leech_ips'] && !$seeder)))
{
	$sql = 'SELECT COUNT(DISTINCT ip) AS ips
		FROM '. BT_TRACKER_TABLE ."
		WHERE torrent_id = $torrent_id
			AND user_id = $user_id
			AND seeder = $seeder
			AND ip != '$ip'";

	if (!$seeder && $tr_cfg['leech_expire_factor'])
	{
		$sql .= ' AND update_time > '. ($current_time - 60*$tr_cfg['leech_expire_factor']);
	}
	else
	{
		$sql .= " AND expire_time > $current_time";
	}

	$sql .= '	GROUP BY torrent_id';

	if (!$result = $db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	if ($row = $db->sql_fetchrow($result))
	{
		if ($seeder && $tr_cfg['limit_seed_ips'] && $row['ips'] >= $tr_cfg['limit_seed_ips'])
		{
			error_exit('You can seed only from '. $tr_cfg['limit_seed_ips'] ." IP's");
		}
		else if (!$seeder && $tr_cfg['limit_leech_ips'] && $row['ips'] >= $tr_cfg['limit_leech_ips'])
		{
			error_exit('You can leech only from '. $tr_cfg['limit_leech_ips'] ." IP's");
		}
	}
}

// Get peer info from previous announce $lp_inf (last peer info) if available
$sql = 'SELECT *
	FROM '. BT_TRACKER_TABLE ."
	WHERE torrent_id = $torrent_id
		AND peer_id = '$peer_id_sql'
	LIMIT 1";

if (!$result = $db->sql_query($sql))
{
	error_exit('DB error', __FILE__, __LINE__, 'db');
}

if ($lp_inf = $db->sql_fetchrow($result))
{
	$last_uploaded     = $lp_inf['uploaded'];
	$last_downloaded   = $lp_inf['downloaded'];
	$last_seeder       = $lp_inf['seeder'];
	$last_releaser     = $lp_inf['releaser'];
	$last_stored_up    = $lp_inf['last_stored_up'];
	$last_stored_down  = $lp_inf['last_stored_down'];
	$stat_last_updated = $lp_inf['stat_last_updated'];
	$last_update_time  = $lp_inf['update_time'];
}
else
{
	$last_stored_up    = $uploaded;
	$last_stored_down  = $downloaded;
	$stat_last_updated = $current_time - ($u_stat_upd_intrv / 2);

	// Delete old record (some clients change their peer_id on each connect)
	$sql = 'DELETE
		FROM '. BT_TRACKER_TABLE ."
		WHERE torrent_id = $torrent_id
			AND user_id = $user_id
			AND ip = '$ip'
			AND port = $port";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}
}

// Change users dl status to "Download" if dl-session started
if (!$guest && $left && !$lp_inf)
{
	include_once(INC_TR_FUNC_USER);
	change_user_dl_status(DL_STATUS_DOWN);
}

// Redefine $completed
// Set "$completed = TRUE" if client wasn't sent event=completed or we lost it
// Also ignore permanent sending event=completed from stupid clients
if ($seeder && $lp_inf)
{
	// if peer was leecher and became seeder
	if (!$last_seeder)
	{
		$completed = TRUE;
	}
	// if peer was seeder and remain seeder
	else if ($last_seeder)
	{
		$completed = FALSE;
	}
}

// Change users dl status to "Complete"
if (!$guest && ($completed || ($seeder && !$lp_inf)))
{
	include_once(INC_TR_FUNC_USER);
	change_user_dl_status(DL_STATUS_COMPLETE);

	if (defined('DL_STATUS_CHANGED') && defined('DL_COMPL_COUNT') && DL_COMPL_COUNT == 1)
	{
		// Increment completed counter for this torrent
		update_tor_complete_count($torrent_id);
	}
}

// Update seeder_last_seen time
if ($seeder && ($s_last_seen + ($tr_cfg['seed_last_seen_upd_interval'] * 60)) < $current_time)
{
	include_once(INC_TR_FUNC_USER);
	update_last_seeder_info($torrent_id, $user_id);
}

// Calculate up/down speed
$speed_up = $speed_down = 0;

if ($lp_inf)
{
	if ($current_time > $last_update_time)
	{
		if ($uploaded > $last_uploaded)
		{
			$speed_up = ceil(($uploaded - $last_uploaded) / ($current_time - $last_update_time));
		}
		if ($downloaded > $last_downloaded && !$completed)
		{
			$speed_down = ceil(($downloaded - $last_downloaded) / ($current_time - $last_update_time));
		}
	}
}

// Update user up/down statistics
if (!$lp_inf && !$guest)
{
	include_once(INC_TR_FUNC_USER);
	$curr_up_down_stat = get_user_tor_up_down($torrent_id, $user_id);

	// Insert empty up/down record
	if ($curr_up_down_stat === FALSE)
	{
		insert_empty_up_down_record($torrent_id, $user_id, $attach_id);
	}
}

// Update dl-statistics
if ($lp_inf)
{
	if ($uploaded > $last_stored_up)
	{
		$up_add = $uploaded - $last_stored_up;
	}

	if ($downloaded > $last_stored_down)
	{
		$down_add = $downloaded - $last_stored_down;
	}
$sql = "SELECT SUM(seeder) as seeders
        FROM " . BT_TRACKER_TABLE . "
       WHERE torrent_id = $torrent_id
      AND expire_time > $current_time ";

if ( !($result = $db->sql_query($sql)) )
{
   message_die(GENERAL_ERROR, 'Error getting information', '', __LINE__, __FILE__, $sql);
}

$row = $db->sql_fetchrow($result);
$seed_count =  $row['seeders'];

   if ($user_id == $poster_id || $seed_count == 1 && $user_id != $poster_id)
   {
      $bl_add = $up_add / 2;
   }
}

$releaser = ($user_id == $poster_id) ? 1 : 0 ;  // releaser flag

if ($tr_cfg['upd_user_up_down_stat'] && $lp_inf && !$guest && (($stat_last_updated + $u_stat_upd_intrv) < $current_time /* || $stopped */))
{
   if ($up_add || $bl_add || $down_add)
   {
      // for current torrent
      include_once(INC_TR_FUNC_USER);
      update_user_tor_up_down_stat($torrent_id, $user_id, $up_add, $down_add);

      // overall up/down statistics for this user
      update_user_up_down_stat($user_id, $up_add, $bl_add, $down_add);
   }

	$last_stored_up    = $uploaded;
	$last_stored_down  = $downloaded;
	$stat_last_updated = $current_time;
}

// Announce interval
$expire_factor = ($tr_cfg['expire_factor'] > 1) ? $tr_cfg['expire_factor'] : 2;
$announce_interval = ($tr_cfg['min_ann_intv']) ? $tr_cfg['min_ann_intv'] : 600;

// Expiration time offset
if ($stopped)
{
	$expire_time = $current_time;
}
else
{
	$expire_time = $current_time + floor($announce_interval * $expire_factor);
}

// Complete percent
$completed_size   = ($left && $tor_size && $tor_size > $left) ? ($tor_size - $left) : 0;
$complete_percent = ($completed_size) ? floor($completed_size * 100 / $tor_size) : 0;

// Redefine $complete_percent for seeders (will used for sorting all peers by complete_percent)
if ($seeder)
{
	if ($guest)
	{
		$complete_percent = $uploaded;
	}
	else
	{
		if (!$lp_inf)
		{
			$complete_percent = ($curr_up_down_stat['t_up_total']) ? $curr_up_down_stat['t_up_total'] : $uploaded;
		}
		else
		{
			$complete_percent = $lp_inf['complete_percent'] + $up_add;
		}
	}
}

// Insert/update peer info
if ($lp_inf)
{
	$sql  = 'UPDATE '. BT_TRACKER_TABLE ." SET update_time = $current_time, expire_time = $expire_time";

	$sql .= ($user_id != $lp_inf['user_id']) ? ", user_id = $user_id" : '';

	$sql .= ($ip != $lp_inf['ip']) ? ", ip = '$ip'" : '';
	$sql .= ($port != $lp_inf['port']) ? ", port = $port" : '';

	$sql .= ($uploaded != $last_uploaded) ? ", uploaded = $uploaded" : '';
	$sql .= ($downloaded != $last_downloaded) ? ", downloaded = $downloaded" : '';
	$sql .= ($complete_percent != $lp_inf['complete_percent']) ? ", complete_percent = $complete_percent" : '';

	$sql .= ($seeder != $last_seeder) ? ", seeder = $seeder" : '';
	$sql .= ($releaser != $last_releaser) ? ", releaser = $releaser" : '';

	$sql .= ($last_stored_up != $lp_inf['last_stored_up']) ? ", last_stored_up = $last_stored_up" : '';
	$sql .= ($last_stored_down != $lp_inf['last_stored_down']) ? ", last_stored_down = $last_stored_down" : '';
	$sql .= ($stat_last_updated != $lp_inf['stat_last_updated']) ? ", stat_last_updated = $stat_last_updated" : '';

	$sql .= ($speed_up != $lp_inf['speed_up']) ? ", speed_up = $speed_up" : '';
	$sql .= ($speed_down != $lp_inf['speed_down']) ? ", speed_down = $speed_down" : '';

	$sql .= " WHERE torrent_id = $torrent_id AND peer_id = '$peer_id_sql'";
	$sql .= ' LIMIT 1';

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}
}
else
{
	$columns = 'torrent_id,  peer_id,  user_id,  ip,  port,  uploaded,  downloaded,  complete_percent,  seeder,  releaser,  last_stored_up,  last_stored_down,  stat_last_updated,  speed_up,  speed_down,  update_time,  expire_time';
	$values = "$torrent_id, '$peer_id_sql', $user_id, '$ip', $port, $uploaded, $downloaded, $complete_percent, $seeder, $releaser, $last_stored_up, $last_stored_down, $stat_last_updated, $speed_up, $speed_down, $current_time, $expire_time";

	$sql = 'INSERT INTO '. BT_TRACKER_TABLE ." ($columns) VALUES ($values)";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}
}

// Exit if event='stopped'
if ($stopped)
{
	silent_exit();
}

// Retrieve peers
$peers = ($compact_mode) ? '' : array();

$sel_peer_id = ($compact_mode || $no_peer_id_mode) ? '' : ', peer_id ';

$sql = "SELECT ip, port $sel_peer_id
	FROM ". BT_TRACKER_TABLE ."
	WHERE torrent_id = $torrent_id
		AND expire_time > $current_time
	ORDER BY RAND()
	LIMIT $numwant";

if (!$result = $db->sql_query($sql))
{
	error_exit('DB error', __FILE__, __LINE__, 'db');
}

if ($rowset = @$db->sql_fetchrowset($result))
{
	if ($compact_mode)
	{
		foreach ($rowset as $i => $peer)
		{
			$peers .= pack('Nn', ip2long(decode_ip($peer['ip'])), $peer['port']);
		}
	}
	else if ($no_peer_id_mode)
	{
		foreach ($rowset as $i => $peer)
		{
			$peers[] = array(
				'ip' => decode_ip($peer['ip']),
				'port' => intval($peer['port'])
			);
		}
	}
	else
	{
		foreach ($rowset as $i => $peer)
		{
			$peers[] = array(
				'ip' => decode_ip($peer['ip']),
				'port' => intval($peer['port']),
				'peer id' => $peer['peer_id']
			);
		}
	}
}

// Return data to client
$output['interval'] = intval($announce_interval);
//$output['private']  = intval(1);
$output['peers']    = $peers;

echo bencode($output);

send_data_to_client();

?>
