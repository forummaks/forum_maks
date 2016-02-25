<?php

// die('d14:failure reason16:tracker disablede');

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);

define('IN_TRACKER',     TRUE);
define('ALLOW_TR_DEBUG', FALSE);

define('PHP_EXT', 'php');

// path
define('TR_PATH', './');          // tracker root
define('BB_PATH', './../forum/'); // phpBB root

define('TR_INC_PATH', TR_PATH .'includes/');

// cache
define('TR_USE_CACHE', TRUE);
define('CACHE_DIR',    BB_PATH .'cache/');
define('CACHE_TR_CFG', CACHE_DIR .'tracker_config.php');

// phpBB includes
define('INC_BB_CFG',   BB_PATH .'config.php');
define('INC_BB_CONST', BB_PATH .'includes/constants_bt.php');

// tracker includes
define('INC_TR_FUNC_MAIN',  TR_INC_PATH .'functions_main.php');
define('INC_TR_FUNC_USER',  TR_INC_PATH .'functions_user.php');
define('INC_TR_FUNC_CACHE', TR_INC_PATH .'functions_cache.php');
define('INC_TR_DB_INIT',    TR_INC_PATH .'tr_db.php');

// misc
define('TR_GZIP_LEVEL', 7);
define('GUEST_UID',    -1);

// rating limits
define('TR_RATING_LIMITS', TRUE);

// Don't change the order of ratios (from 0 to 1)
// rating < 0.3 -- allow only 1 torrent for leeching
// rating < 0.4 -- only 2
// rating < 0.6 -- only 3
// rating > 0.6 -- depend on your tracker config limits (in "ACP - Tracker Config - Limits")
$rating_limits_ary = array(
	'0.3' => 1,
	'0.4' => 2,
	'0.6' => 3
);

// Get cached tracker config
$tr_cfg = array();

if (TR_USE_CACHE)
{
	@include(CACHE_TR_CFG);

	if (@$tr_cfg['off'])
	{
		header('Content-Type: text/plain');
		header('Pragma: no-cache');

		$msg = $tr_cfg['off_reason'];
		echo 'd14:failure reason'. strlen($msg) .':'. $msg .'8:intervali600ee';

		exit;
	}
}

$dbg = (ALLOW_TR_DEBUG && @$_GET['dbg']) ? TRUE : FALSE;
define('DBG_MODE', $dbg);

$tr_root_path = TR_PATH;

require(INC_BB_CFG);
require(INC_BB_CONST);
require(INC_TR_FUNC_MAIN);

?>