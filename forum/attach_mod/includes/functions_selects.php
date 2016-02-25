<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

function size_select($select_name, $size_compare)
{
	global $lang;

	$size_types_text = array($lang['Bytes'], $lang['KB'], $lang['MB']);
	$size_types = array('b', 'kb', 'mb');

	$select_field = '<select name="' . $select_name . '">';

	for ($i = 0; $i < sizeof($size_types_text); $i++)
	{
		$selected = ($size_compare == $size_types[$i]) ? ' selected="selected"' : '';
		$select_field .= '<option value="' . $size_types[$i] . '"' . $selected . '>' . $size_types_text[$i] . '</option>';
	}

	$select_field .= '</select>';

	return $select_field;
}

function quota_limit_select($select_name, $default_quota = 0)
{
	global  $lang;

	$sql = 'SELECT quota_limit_id, quota_desc
		FROM ' . QUOTA_LIMITS_TABLE . '
		ORDER BY quota_limit ASC';

	if ( !($result = DB()->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query Quota Limits Table", "", __LINE__, __FILE__, $sql);
	}

	$quota_select = '<select name="' . $select_name . '">';
	$quota_name[0]['quota_limit_id'] = 0;
	$quota_name[0]['quota_desc'] = $lang['Not_assigned'];

	while ($row = DB()->sql_fetchrow($result))
	{
		$quota_name[] = $row;
	}
	DB()->sql_freeresult($result);

	for ($i = 0; $i < sizeof($quota_name); $i++)
	{
		$selected = ($quota_name[$i]['quota_limit_id'] == $default_quota) ? ' selected="selected"' : '';
		$quota_select .= '<option value="' . $quota_name[$i]['quota_limit_id'] . '"' . $selected . '>' . $quota_name[$i]['quota_desc'] . '</option>';
	}
	$quota_select .= '</select>';

	return $quota_select;
}

function default_quota_limit_select($select_name, $default_quota = 0)
{
	global  $lang;

	$sql = 'SELECT quota_limit_id, quota_desc
		FROM ' . QUOTA_LIMITS_TABLE . '
		ORDER BY quota_limit ASC';

	if ( !($result = DB()->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query Quota Limits Table", "", __LINE__, __FILE__, $sql);
	}

	$quota_select = '<select name="' . $select_name . '">';
	$quota_name[0]['quota_limit_id'] = 0;
	$quota_name[0]['quota_desc'] = $lang['No_quota_limit'];

	while ($row = DB()->sql_fetchrow($result))
	{
		$quota_name[] = $row;
	}
	DB()->sql_freeresult($result);

	for ($i = 0; $i < sizeof($quota_name); $i++)
	{
		$selected = ( $quota_name[$i]['quota_limit_id'] == $default_quota ) ? ' selected="selected"' : '';
		$quota_select .= '<option value="' . $quota_name[$i]['quota_limit_id'] . '"' . $selected . '>' . $quota_name[$i]['quota_desc'] . '</option>';
	}
	$quota_select .= '</select>';

	return $quota_select;
}