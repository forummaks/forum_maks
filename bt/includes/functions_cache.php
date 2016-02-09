<?php

function get_config_ary ($config_table)
{
	global $db, $sql;

	$cfg = array();

	$sql = "SELECT *
		FROM $config_table";

	if (!$rowset = @$db->sql_fetchrowset($db->sql_query($sql)))
	{
		error_exit('Could not query config', __FILE__, __LINE__, 'db');
	}

	foreach ($rowset as $rid => $row)
	{
		$cfg[$row['config_name']] = $row['config_value'];
	}

	return $cfg;
}

function check_cache_dir ($cache_dir)
{
	$old_um = umask(0);
	$status = TRUE;

	if (file_exists($cache_dir) && is_dir($cache_dir))
	{
		if (!is_writeable($cache_dir))
		{
			$status = chmod($cache_dir, 0777);
		}
	}
	else
	{
		$status = mkdir($cache_dir, 0777);
	}

	umask($old_um);
	return $status;
}

function write_cfg_to_cache ($cache_file, $ary, $ary_name)
{
	if ($fp = @fopen($cache_file, 'w+'))
	{
		@flock($fp, LOCK_EX);
		fwrite($fp, "<?php\n $ary_name = unserialize('". str_replace("'", "\\'", str_replace('\\', '\\\\', serialize($ary))) ."');\n?>");
		@flock($fp, LOCK_UN);
		fclose($fp);

		return TRUE;
	}

	return FALSE;
}

?>