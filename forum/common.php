<?php

if (isset($_REQUEST['GLOBALS'])) die();

ignore_user_abort(true);
define('TIMESTART', utime());
define('TIMENOW',   time());
$starttime = array_sum(explode(' ', microtime()));

if (empty($_SERVER['REMOTE_ADDR']))     $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
if (empty($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT'] = '';
if (empty($_SERVER['HTTP_REFERER']))    $_SERVER['HTTP_REFERER'] = '';
if (empty($_SERVER['SERVER_NAME']))     $_SERVER['SERVER_NAME'] = '';

if (!defined('FT_ROOT')) define('FT_ROOT', './');
if (!defined('IN_FORUM') && !defined('IN_TRACKER')) define('IN_FORUM', true);

header('X-Frame-Options: SAMEORIGIN');

// Cloudflare
if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
{
	$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

// Get initial config
require(FT_ROOT . 'config.php');

$server_protocol = ($ft_cfg['cookie_secure']) ? 'https://' : 'http://';
$server_port = (in_array($ft_cfg['server_port'], array(80, 443))) ? '' : ':' . $ft_cfg['server_port'];
define('FORUM_PATH', $ft_cfg['script_path']);
define('FULL_URL', $server_protocol . $ft_cfg['server_name'] . $server_port . $ft_cfg['script_path']);
unset($server_protocol, $server_port);

/*
*  Функии временного использования со старой версии php4
*  Начало старых функций
*
**/

// PHP5 with register_long_arrays off?
if (!isset($HTTP_POST_VARS) && isset($_POST))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

if (@phpversion() < '4.0.0')
{
	// PHP3 path; in PHP3, globals are _always_ registered

	// We 'flip' the array of variables to test like this so that
	// we can validate later with isset($test[$var]) (no in_array())
	$test = array('HTTP_GET_VARS' => NULL, 'HTTP_POST_VARS' => NULL, 'HTTP_COOKIE_VARS' => NULL, 'HTTP_SERVER_VARS' => NULL, 'HTTP_ENV_VARS' => NULL, 'HTTP_POST_FILES' => NULL, 'phpEx' => NULL, 'phpbb_root_path' => NULL);

	// Loop through each input array
	@reset($test);
	while (list($input,) = @each($test))
	{
		while (list($var,) = @each($$input))
		{
			// Validate the variable to be unset
			if (!isset($test[$var]) && $var != 'test' && $var != 'input')
			{
				unset($$var);
			}
		}
	}
}
else if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on')
{
	// PHP4+ path
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	$input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (!in_array($var, $not_unset))
		{
			unset($$var);
		}
	}

	unset($input);
}

if(!get_magic_quotes_gpc())
{
	if( is_array($HTTP_GET_VARS) )
	{
		while( list($k, $v) = each($HTTP_GET_VARS) )
		{
			if( is_array($HTTP_GET_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
				{
					$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_GET_VARS[$k]);
			}
			else
			{
				$HTTP_GET_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_GET_VARS);
	}

	if( is_array($HTTP_POST_VARS) )
	{
		while( list($k, $v) = each($HTTP_POST_VARS) )
		{
			if( is_array($HTTP_POST_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
				{
					$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}

	if( is_array($HTTP_COOKIE_VARS) )
	{
		while( list($k, $v) = each($HTTP_COOKIE_VARS) )
		{
			if( is_array($HTTP_COOKIE_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
				{
					$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_COOKIE_VARS[$k]);
			}
			else
			{
				$HTTP_COOKIE_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_COOKIE_VARS);
	}
}

/*
*  Функии временного использования со старой версии php4
*  Конец старых функций
*
**/

// Debug options
define('DBG_USER', (isset($_COOKIE[COOKIE_DBG])));

// Board/Tracker shared constants and functions
define('BT_CONFIG_TABLE',      			'phpbb_bt_config');          // phpbb_bt_config
define('BT_SEARCH_TABLE',      			'phpbb_bt_search_results');  // phpbb_bt_search_results
define('BT_TOR_DL_STAT_TABLE', 			'phpbb_bt_tor_dl_stat');     // phpbb_bt_tor_dl_stat
define('BT_TORRENTS_TABLE',    			'phpbb_bt_torrents');        // phpbb_bt_torrents
define('BT_TRACKER_TABLE',     			'phpbb_bt_tracker');         // phpbb_bt_tracker
define('BT_USERS_TABLE',       			'phpbb_bt_users');           // phpbb_bt_users
define('BT_USR_DL_STAT_TABLE', 			'phpbb_bt_users_dl_status'); // phpbb_bt_users_dl_status

define('BT_AUTH_KEY_LENGTH',   10);

define('DL_STATUS_WILL',       0);
define('DL_STATUS_DOWN',       1);
define('DL_STATUS_COMPLETE',   2);
define('DL_STATUS_CANCEL',     3);

define('ANONYMOUS', -1);
define('BOT_UID', -746);

// Board init
if (!defined('IN_TRACKER'))
{
	require(FT_ROOT . 'includes/init_ft.php');
}

/**
 * Database
 */
// Core DB class
require(FT_ROOT . 'db/dbs.php');
$DBS = new DBS($ft_cfg);

$db = $DBS->get_db_obj($database_alias = 'database1');

/*function DB ($db_alias = 'database1')
{
	global $DBS;
	return $DBS->get_db_obj($db_alias);
}*/

function sql_dbg_enabled ()
{
	return (SQL_DEBUG && DBG_USER && !empty($_COOKIE['sql_log']));
}

// Functions
function utime ()
{
	return array_sum(explode(' ', microtime()));
}

function ft_log ($msg, $file_name)
{
	if (is_array($msg))
	{
		$msg = join(LOG_LF, $msg);
	}
	$file_name .= (LOG_EXT) ? '.'. LOG_EXT : '';
	return file_write($msg, LOG_DIR . $file_name);
}

function file_write ($str, $file, $max_size = LOG_MAX_SIZE, $lock = true, $replace_content = false)
{
	$bytes_written = false;
	
	if ($max_size && @filesize($file) >= $max_size)
	{
		$old_name = $file; $ext = '';
		if (preg_match('#^(.+)(\.[^\\/]+)$#', $file, $matches))
		{
			$old_name = $matches[1]; $ext = $matches[2];
		}
		$new_name = $old_name .'_[old]_'. date('Y-m-d_H-i-s_') . getmypid() . $ext;
		clearstatcache();
		if (@file_exists($file) && @filesize($file) >= $max_size && !@file_exists($new_name))
		{
			@rename($file, $new_name);
		}
	}
	
	if (!$fp = @fopen($file, 'ab'))
	{
		if ($dir_created = ft_mkdir(dirname($file)))
		{
			$fp = @fopen($file, 'ab');
		}
	}
	if ($fp)
	{
		if ($lock)
		{
			@flock($fp, LOCK_EX);
		}
		if ($replace_content)
		{
			@ftruncate($fp, 0);
			@fseek($fp, 0, SEEK_SET);
		}
		$bytes_written = @fwrite($fp, $str);
		@fclose($fp);
	}
	
	return $bytes_written;
}

function ft_mkdir ($path, $mode = 0777)
{
	$old_um = umask(0);
	$dir = mkdir_rec($path, $mode);
	umask($old_um);
	return $dir;
}

function mkdir_rec ($path, $mode)
{
	if (is_dir($path))
	{
		return ($path !== '.' && $path !== '..') ? is_writable($path) : false;
	}
	else
	{
		return (mkdir_rec(dirname($path), $mode)) ? @mkdir($path, $mode) : false;
	}
}

function verify_id ($id, $length)
{
	return (is_string($id) && preg_match('#^[a-zA-Z0-9]{'. $length .'}$#', $id));
}

function clean_filename ($fname)
{
	static $s = array('\\', '/', ':', '*', '?', '"', '<', '>', '|', ' ');
	return str_replace($s, '_', str_compact($fname));
}

function encode_ip ($ip)
{
	$d = explode('.', $ip);
	return @sprintf('%02x%02x%02x%02x', $d[0], $d[1], $d[2], $d[3]); // '@' - это временное решение познее будет испраленно
}

function decode_ip ($ip)
{
	return long2ip("0x{$ip}");
}

function ip2int ($ip)
{
	return (float) sprintf('%u', ip2long($ip));  // для совместимости с 32 битными системами
}

// long2ip( mask_ip_int(ip2int('1.2.3.4'), 24) ) = '1.2.3.255'
function mask_ip_int ($ip, $mask)
{
	$ip_int = is_numeric($ip) ? $ip : ip2int($ip);
	$ip_masked = $ip_int | ((1 << (32 - $mask)) - 1);
	return (float) sprintf('%u', $ip_masked);
}

function ft_crc32 ($str)
{
	return (float) sprintf('%u', crc32($str));
}

function hexhex ($value)
{
	return dechex(hexdec($value));
}

function verify_ip ($ip)
{
	return preg_match('#^(\d{1,3}\.){3}\d{1,3}$#', $ip);
}

function str_compact ($str)
{
	return preg_replace('#\s+#u', ' ', trim($str));
}

function make_rand_str ($len = 10)
{
	$str = '';
	while (strlen($str) < $len)
	{
		$str .= str_shuffle(preg_replace('#[^0-9a-zA-Z]#', '', password_hash(uniqid(mt_rand(), true), PASSWORD_BCRYPT)));
	}
	return substr($str, 0, $len);
}

function array_deep (&$var, $fn, $one_dimensional = false, $array_only = false)
{
	if (is_array($var))
	{
		foreach ($var as $k => $v)
		{
			if (is_array($v))
			{
				if ($one_dimensional)
				{
					unset($var[$k]);
				}
				else if ($array_only)
				{
					$var[$k] = $fn($v);
				}
				else
				{
					array_deep($var[$k], $fn);
				}
			}
			else if (!$array_only)
			{
				$var[$k] = $fn($v);
			}
		}
	}
	else if (!$array_only)
	{
		$var = $fn($var);
	}
}

function hide_ft_path ($path)
{
	return ltrim(str_replace(FT_PATH, '', $path), '/\\');
}

function ver_compare ($version1, $operator, $version2)
{
	return version_compare($version1, $version2, $operator);
}

/*function dbg_log ($str, $file)
{
	$dir = LOG_DIR . (defined('IN_TRACKER') ? 'dbg_tr/' : 'dbg_bb/') . date('m-d_H') .'/';
	return file_write($str, $dir . $file, false, false);
}

function log_get ($file = '', $prepend_str = false)
{
	log_request($file, $prepend_str, false);
}

function log_post ($file = '', $prepend_str = false)
{
	log_request($file, $prepend_str, true);
}*/

//
// Setup forum wide options, if this fails
// then we output a CRITICAL_ERROR since
// basic forum information is not available
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$ft_cfg[$row['config_name']] = $row['config_value'];
}

require(FT_ROOT . 'attach_mod/attachment_mod.php');
//
// Show 'Board is disabled' message if needed.
//
if( $ft_cfg['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}