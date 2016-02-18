<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

// $topics = topic_id[,topic_id,topic_id ...]
function get_dl_topics ($topics, $real_topics_dl_status)
{
	global $db;

	$dl_topics = array();

	if (!$topics || !$real_topics_dl_status)
	{
		return FALSE;
	}

	if ($real_topics_dl_status == 'active')
	{
		$dl_status = DL_STATUS_WILL .','. DL_STATUS_DOWN;
	}
	else if ($real_topics_dl_status == 'complete')
	{
		$dl_status = DL_STATUS_COMPLETE;
	}
	else
	{
		return FALSE;
	}

	$sql = 'SELECT DISTINCT topic_id
		FROM '. BT_USR_DL_STAT_TABLE ."
		WHERE topic_id IN($topics)
			AND user_status IN($dl_status)
		ORDER BY topic_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain DL topics data', '', __LINE__, __FILE__, $sql);
	}

	if ($rowset = @$db->sql_fetchrowset($result))
	{
		for ($i=0, $cnt=count($rowset); $i < $cnt; $i++)
		{
			$dl_topics[] = $rowset[$i]['topic_id'];
		}
		$dl_topics = implode(',', $dl_topics);
	}
	else
	{
		return FALSE;
	}

	return $dl_topics;
}

// $topics = topic_id[,topic_id,topic_id ...]
function clear_dl_list ($topics)
{
	global $db;

	if (!$topics)
	{
		return;
	}

	$sql = 'DELETE FROM '. BT_USR_DL_STAT_TABLE ."
		WHERE topic_id IN($topics)";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete DL-List data for this topic', '', __LINE__, __FILE__, $sql);
	}

	return;
}

// $topics = topic_id[,topic_id,topic_id ...]
function update_topics_dl_status ($topics, $event)
{
	// disabled in version 0.3.5
	return;

	global $db;

	if (!$topics)
	{
		return;
	}

	$topics_active = $topics_complete = array();

	if ($event == 'down' || $event == 'will')
	{
		$sql = 'UPDATE '. TOPICS_TABLE .' SET
				topic_dl_status = '. TOPIC_DL_ST_DOWN ."
			WHERE topic_id IN($topics)";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		return;
	}

	if ($event == 'DL-List deleted')
	{
		$sql = 'UPDATE '. TOPICS_TABLE .' SET
				topic_dl_status = '. TOPIC_DL_ST_NONE ."
			WHERE topic_id IN($topics)";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		return;
	}

	if ($event == 'complete')
	{
		$topics_active = get_dl_topics($topics, 'active');

		if ($topics != $topics_active)
		{
			$exclude_topics_active = ($topics_active) ? "AND topic_id NOT IN($topics_active)" : '';

			$sql = 'UPDATE '. TOPICS_TABLE .' SET
					topic_dl_status = '. TOPIC_DL_ST_COMPLETE ."
				WHERE topic_id IN($topics)
					$exclude_topics_active";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}
		}

		return;
	}

	if ($event == 'expire' || $event == 'cancel')
	{
		if ($topics_active = get_dl_topics($topics, 'active'))
		{
			$sql = 'UPDATE '. TOPICS_TABLE .' SET
					topic_dl_status = '. TOPIC_DL_ST_DOWN ."
				WHERE topic_id IN($topics_active)";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}

			if ($topics == $topics_active)
			{
				return;
			}
		}

		$exclude_topics_active = ($topics_active) ? "AND topic_id NOT IN($topics_active)" : '';

		if ($topics_complete = get_dl_topics($topics, 'complete'))
		{
			$sql = 'UPDATE '. TOPICS_TABLE .' SET
					topic_dl_status = '. TOPIC_DL_ST_COMPLETE ."
				WHERE topic_id IN($topics_complete)
					$exclude_topics_active";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}

			if ($topics == $topics_complete)
			{
				return;
			}
		}

		$exclude_topics_complete = ($topics_complete) ? "AND topic_id NOT IN($topics_complete)" : '';

		$sql = 'UPDATE '. TOPICS_TABLE .' SET
				topic_dl_status = '. TOPIC_DL_ST_NONE ."
			WHERE topic_id IN($topics)
				$exclude_topics_active
				$exclude_topics_complete";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}
		return;
	}

	return;
}

function synch_dl_topics ($forum_id, $synch_type)
{
	// disabled in version 0.3.5
	return;

	global $db, $ft_cfg;

	if (!$forum_id)
	{
		return;
	}

	$topics_sql = array();

	if ($synch_type == 'expire')
	{
		$dl_topics_limit = 80;
		$dl_expire_time = time() - ($ft_cfg['bt_dl_list_expire'] * 60*60*24);

		$sql = 'SELECT DISTINCT t.topic_id
			FROM '. TOPICS_TABLE .' t, '. BT_USR_DL_STAT_TABLE ." d
			WHERE t.forum_id = $forum_id
				AND t.topic_dl_type = ". TOPIC_DL_TYPE_DL .'
				AND t.topic_status <> '. TOPIC_MOVED .'
				AND t.topic_id = d.topic_id
				AND d.user_status IN('. DL_STATUS_WILL .','. DL_STATUS_DOWN .")
				AND d.update_time < $dl_expire_time
			ORDER BY t.topic_id DESC
			LIMIT $dl_topics_limit";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not synchronize topics DL-status', '', __LINE__, __FILE__, $sql);
		}

		if ($rowset = @$db->sql_fetchrowset($result))
		{
			for ($i=0; $i < count($rowset); $i++)
			{
				$topics_sql[] = $rowset[$i]['topic_id'];
			}

			if ($topics_sql = implode(',', $topics_sql))
			{
				$sql = 'DELETE FROM '. BT_USR_DL_STAT_TABLE ."
					WHERE topic_id IN($topics_sql)
						AND user_status IN(". DL_STATUS_WILL .','. DL_STATUS_DOWN .")
						AND update_time < $dl_expire_time";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not delete expired users from DL-List", '', __LINE__, __FILE__, $sql);
				}

				update_topics_dl_status($topics_sql, 'expire');
			}
		}
	}

	$sql = 'UPDATE '. FORUMS_TABLE .' SET
			last_dl_topics_synch = '. time() ."
		WHERE forum_id = $forum_id";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update last_dl_topics_synch in forums table", '', __LINE__, __FILE__, $sql);
	}

	return;
}