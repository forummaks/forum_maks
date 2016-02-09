<?php

function change_user_dl_status ($new_dl_status)
{
	global $tr_cfg, $user_id, $topic_id, $poster_id, $current_time;
	global $db, $sql;

	$can_update = $curr_dl_status = FALSE;
	$compl_count = 0;

	if ($topic_id && $poster_id && $user_id != $poster_id)
	{
		if ($new_dl_status == DL_STATUS_DOWN && $tr_cfg['update_users_dl_status'])
		{
			$can_update = TRUE;
		}
		else if ($new_dl_status == DL_STATUS_COMPLETE && $tr_cfg['update_users_compl_status'])
		{
			$can_update = TRUE;
		}
	}

	if (!$can_update)
	{
		return FALSE;
	}

	if ($row = get_user_dl_status($topic_id, $user_id))
	{
		$curr_dl_status = $row['user_status'];
		$compl_count = $row['compl_count'];
	}

	if ($new_dl_status == DL_STATUS_COMPLETE)
	{
		$compl_count++;
	}

	// insert new record
	if ($curr_dl_status === FALSE)
	{
		$columns = 'topic_id,  user_id,  user_status,    compl_count,  update_time';
		$values = "$topic_id, $user_id, $new_dl_status, $compl_count, $current_time";

		$sql = 'INSERT INTO '. BT_USR_DL_STAT_TABLE ." ($columns) VALUES ($values)";

		if (!$db->sql_query($sql))
		{
			error_exit('DB error', __FILE__, __LINE__, 'db');
		}

		define('DL_STATUS_CHANGED', TRUE);
	}
	// update dl status
	else if ($curr_dl_status != $new_dl_status)
	{
		$sql = 'UPDATE '. BT_USR_DL_STAT_TABLE ." SET
				user_status = $new_dl_status,
				compl_count = $compl_count
			WHERE topic_id = $topic_id
				AND user_id = $user_id
			LIMIT 1";

		if (!$db->sql_query($sql))
		{
			error_exit('DB error', __FILE__, __LINE__, 'db');
		}

		define('DL_STATUS_CHANGED', TRUE);
	}

	define('DL_COMPL_COUNT', $compl_count);

	return;
}

function get_user_tor_up_down ($torrent_id, $user_id)
{
	global $db, $sql;

	$sql = 'SELECT t_up_total, t_down_total
		FROM '. BT_TOR_DL_STAT_TABLE ."
		WHERE torrent_id = $torrent_id
			AND user_id = $user_id
		LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	if ($row = $db->sql_fetchrow($result))
	{
		return $row;
	}
	else
	{
		return FALSE;
	}
}

function update_user_tor_up_down_stat ($torrent_id, $user_id, $up_add, $down_add)
{
	global $db, $sql;

	$sql = 'UPDATE '. BT_TOR_DL_STAT_TABLE ." SET
			t_up_total = t_up_total + $up_add,
			t_down_total = t_down_total + $down_add
		WHERE torrent_id = $torrent_id
			AND user_id = $user_id
		LIMIT 1";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	return;
}

function update_user_up_down_stat ($user_id, $up_add, $bl_add, $down_add)
{
   global $db, $sql;

   $sql = 'UPDATE '. BT_USERS_TABLE ." SET
			u_up_total = u_up_total + $up_add,
			u_bonus_total = u_bonus_total + $bl_add,
			u_down_total = u_down_total + $down_add
		WHERE user_id = $user_id
		LIMIT 1";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	return;
}

function update_tor_complete_count ($torrent_id)
{
	global $db, $sql;

	$sql = 'UPDATE '. BT_TORRENTS_TABLE ." SET
			complete_count = complete_count + 1
		WHERE torrent_id = $torrent_id";

	if (!$db->sql_query($sql))
	{
		error_exit("Couldn't update completed count", __FILE__, __LINE__, 'db');
	}

	return;
}

function update_last_seeder_info ($torrent_id, $user_id)
{
	global $current_time;
	global $db, $sql;

	$sql = 'UPDATE '. BT_TORRENTS_TABLE ." SET
			seeder_last_seen = $current_time,
			last_seeder_uid = $user_id
		WHERE torrent_id = $torrent_id";

	if (!$db->sql_query($sql))
	{
		error_exit("Couldn't update seeders last seen time", __FILE__, __LINE__, 'db');
	}

	return;
}

function insert_empty_up_down_record ($torrent_id, $user_id, $attach_id)
{
	global $db, $sql;

	$columns = 'torrent_id,  user_id,  attach_id, t_up_total, t_down_total';
	$values = "$torrent_id, $user_id, $attach_id, 0,          0";

	$sql = 'INSERT INTO '. BT_TOR_DL_STAT_TABLE ." ($columns) VALUES ($values)";

	if (!$db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	return;
}

function get_user_dl_status ($topic_id, $user_id)
{
	global $db, $sql;

	$sql = 'SELECT user_status, compl_count
		FROM '. BT_USR_DL_STAT_TABLE ."
		WHERE topic_id = $topic_id
			AND user_id = $user_id
		LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		error_exit('DB error', __FILE__, __LINE__, 'db');
	}

	if ($row = $db->sql_fetchrow($result))
	{
		return $row;
	}
	else
	{
		return FALSE;
	}
}

?>