<?php
if (!defined('FT_ROOT')) die(basename(__FILE__));

include(FT_ROOT . 'attach_mod/includes/functions_includes.php');
include(FT_ROOT . 'attach_mod/includes/functions_attach.php');
include(FT_ROOT . 'attach_mod/includes/functions_delete.php');
include(FT_ROOT . 'attach_mod/includes/functions_thumbs.php');
include(FT_ROOT . 'attach_mod/includes/functions_filetypes.php');

if (defined('ATTACH_INSTALL'))
{
	return;
}

function include_attach_lang()
{
	global $lang, $board_config, $attach_config;

	//
	// Include Language
	//
	$language = $board_config['default_lang'];

	if (!file_exists(FT_ROOT . 'language/lang_' . $language . '/lang_main_attach.php'))
	{
		$language = $attach_config['board_lang'];
	}

	include(FT_ROOT . 'language/lang_' . $language . '/lang_main_attach.php');

	if (defined('IN_ADMIN'))
	{
		if (!file_exists(FT_ROOT . 'language/lang_' . $language . '/lang_admin_attach.php'))
		{
			$language = $attach_config['board_lang'];
		}

		include(FT_ROOT . 'language/lang_' . $language . '/lang_admin_attach.php');
	}

}

function get_config()
{
	global $db, $board_config;

	$attach_config = array();

	$sql = 'SELECT *
		FROM ' . ATTACH_CONFIG_TABLE;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query attachment information', '', __LINE__, __FILE__, $sql);
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$attach_config[$row['config_name']] = trim($row['config_value']);
	}

	$attach_config['board_lang'] = trim($board_config['default_lang']);

	return $attach_config;
}

//
// Get Attachment Config
//
$cache_dir = FT_ROOT . '/cache';
$cache_file = $cache_dir . '/attach_config.php';
$attach_config = array();

if (file_exists($cache_dir) && is_dir($cache_dir) && is_writable($cache_dir))
{
	if (file_exists($cache_file))
	{
		include($cache_file);
	}
	else
	{
		$attach_config = get_config();
		$fp = @fopen($cache_file, 'wt+');
		if ($fp)
		{
			@reset($attach_config);
			fwrite($fp, "<?php\n");
			while (list($key, $value) = @each($attach_config) )
			{
				fwrite($fp, '$attach_config[\'' . $key . '\'] = \'' . trim($value) . '\';' . "\n");
			}
			fwrite($fp, '?>');
			fclose($fp);
		}
	}
}
else
{
	$attach_config = get_config();
}

// Please do not change the include-order, it is valuable for proper execution.
// Functions for displaying Attachment Things
include(FT_ROOT . 'attach_mod/displaying.php');
// Posting Attachments Class (HAVE TO BE BEFORE PM)
include(FT_ROOT . 'attach_mod/posting_attachments.php');
// PM Attachments Class
include(FT_ROOT . 'attach_mod/pm_attachments.php');

if (!intval($attach_config['allow_ftp_upload']))
{
	$upload_dir = $attach_config['upload_dir'];
}
else
{
	$upload_dir = $attach_config['download_path'];
}

?>