<?php

function get_config_ary ($config_table)
{
	global $db;

	$cfg = array();

	$sql = "SELECT *
		FROM $config_table";

	if (!$rowset = @$db->sql_fetchrowset($db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query config information', '', __LINE__, __FILE__, $sql);
	}

	foreach ($rowset as $rid => $row)
	{
		$cfg[$row['config_name']] = $row['config_value'];
	}

	return $cfg;
}

function update_table_bool ($table_name, $key, $field_name, $field_def_val)
{
	global $db;

	// Clear current status
	$sql = "UPDATE $table_name
		SET $field_name = $field_def_val
		WHERE 1";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update $table_name", '', __LINE__, __FILE__, $sql);
	}

	if (isset($_POST[$field_name]))
	{
		// Get new status
		$in_sql = array();

		foreach ($_POST[$field_name] as $i => $val)
		{
			$in_sql[] = intval($val);
		}

		// Update status
		if ($in_sql = implode(',', $in_sql))
		{
			$sql = "UPDATE $table_name
				SET $field_name = 1
				WHERE $key IN($in_sql)";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not update $table_name", '', __LINE__, __FILE__, $sql);
			}
		}
	}
	return;
}

function set_tpl_vars ($default_cfg, $cfg)
{
	global $template;

	foreach ($default_cfg as $config_name => $config_value)
	{
		$template->assign_vars(array(strtoupper($config_name) => htmlspecialchars($cfg[$config_name])));
	}
	return;
}

function set_tpl_vars_bool ($default_cfg, $cfg)
{
	global $template, $lang;

	$ch = 'checked="checked"';

	foreach ($default_cfg as $config_name => $config_value)
	{
		// YES/NO 'checked="checked"'
		$template->assign_vars(array(
			strtoupper($config_name) .'_YES' => ($cfg[$config_name]) ? $ch : '',
			strtoupper($config_name) .'_NO' => (!$cfg[$config_name]) ? $ch : ''));
		// YES/NO lang vars
		$template->assign_vars(array(
			'L_'. strtoupper($config_name) .'_YES' => ($cfg[$config_name]) ? "<u>$lang[Yes]</u>" : $lang['Yes'],
			'L_'. strtoupper($config_name) .'_NO' => (!$cfg[$config_name]) ? "<u>$lang[No]</u>" : $lang['No']));
	}
	return;
}

function set_tpl_vars_lang ($default_cfg)
{
	global $template, $lang;

	foreach ($default_cfg as $config_name => $config_value)
	{
		if (isset($lang[$config_name]))
		{
			$template->assign_vars(array('L_'. strtoupper($config_name) => $lang[$config_name]));
		}

		if (isset($lang[$config_name .'_expl']))
		{
			$template->assign_vars(array('L_'. strtoupper($config_name) .'_EXPL' => $lang[$config_name .'_expl']));
		}

		if (isset($lang[$config_name .'_head']))
		{
			$template->assign_vars(array('L_'. strtoupper($config_name) .'_HEAD' => $lang[$config_name .'_head']));
		}
	}
	return;
}

function update_config_table ($table_name, $default_cfg, $cfg, $type)
{
	global $db;

	foreach ($default_cfg as $config_name => $config_value)
	{
		if (isset($_POST[$config_name]) && $_POST[$config_name] != $cfg[$config_name])
		{
			if ($type == 'str')
			{
				$config_value = "'". bt_sql_esc(unesc($_POST[$config_name])) ."'";
			}
			else if ($type == 'bool')
			{
				$config_value = ($_POST[$config_name]) ? 1 : 0;
			}
			else if ($type == 'num')
			{
				$config_value = round(abs(intval($_POST[$config_name])));
			}
			else
			{
				return;
			}

			$sql = "UPDATE $table_name SET
				config_value = $config_value
				WHERE config_name = '$config_name'";

			if(!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Failed to update configuration for $config_name", '', __LINE__, __FILE__, $sql);
			}
		}
	}
	return;
}

?>