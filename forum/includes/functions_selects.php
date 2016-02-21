<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

//
// Languages
//
function language_select($default, $select_name = "language", $dirname="language")
{
	$dir = opendir(FT_ROOT . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath(FT_ROOT . $dirname . '/' . $file)) && !is_link(@phpbb_realpath(FT_ROOT . $dirname . '/' . $file)))
		{
			$filename = trim(str_replace("lang_", "", $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang);
	@reset($lang);

	$lang_select = '<select name="' . $select_name . '">';
	while ( list($displayname, $filename) = @each($lang) )
	{
		$selected = ( strtolower($default) == strtolower($filename) ) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
	}
	$lang_select .= '</select>';

	return $lang_select;
}

//
// Pick a timezone
//
function tz_select($default, $select_name = 'timezone')
{
	global $sys_timezone, $lang;

	if ( !isset($default) )
	{
		$default == $sys_timezone;
	}
	$tz_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['tz']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$tz_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$tz_select .= '</select>';

	return $tz_select;
}

//
// Pick a template/theme combo,
//
function style_select($default_style, $select_name = 'tpl_name')
{
	global $ft_cfg;

	$templates_select = '<select name="'. $select_name .'">';
	$x = 0;
	foreach ($ft_cfg['templates'] as $folder => $name)
	{
		$selected = '';
		if ($folder == $default_style) $selected = ' selected="selected"';
		$templates_select .= '<option value="'. $folder .'"'. $selected .'>'. $name .'</option>';
		$x++;
	}
	$templates_select .= '</select>';
	return ($x > 1) ? $templates_select : reset($ft_cfg['templates']);
}