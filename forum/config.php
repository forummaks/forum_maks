<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$ft_cfg = $page_cfg = array();

// Primary domain name
$domain_name = 'ft.org'; // enter here your primary domain name of your site
$domain_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $domain_name;

// Database
$charset  = 'utf8';
$pconnect = false;

// Ќастройка баз данных ['db']['srv_name'] => (array) srv_cfg;
// пор€док параметров srv_cfg (хост, название базы, пользователь, пароль, charset, pconnect);
$ft_cfg['database'] = array(
	'database1' => array('localhost', 'baza', 'root', '123456', $charset, $pconnect),
	//'database2' => array('localhost2', 'dbase2', 'user2', 'pass2', $charset, $pconnect),
	//'database3' => array('localhost3', 'dbase3', 'user2', 'pass3', $charset, $pconnect),
);

$ft_cfg['database_alias'] = array(
//	'alias'  => 'srv_name'
#	db1
	'log'    => 'database1', // BB_LOG
	'search' => 'database1', // BB_TOPIC_SEARCH
	'sres'   => 'database1', // BB_BT_USER_SETTINGS, BB_SEARCH_RESULTS
	'u_ses'  => 'database1', // BB_USER_SES, BB_USER_LASTVISIT
#	db2
	'dls'    => 'database1', // BB_BT_DLS_*
	'ip'     => 'database1', // BB_POSTS_IP
	'ut'     => 'database1', // BB_TOPICS_USER_POSTED
#	db3
	'pm'     => 'database1', // BB_PRIVMSGS, BB_PRIVMSGS_TEXT
	'pt'     => 'database1', // BB_POSTS_TEXT
);

// Server
$ft_cfg['server_name'] = $domain_name;                                                     // The domain name from which this board runs
$ft_cfg['server_port'] = (!empty($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : 80; // The port your server is running on
$ft_cfg['script_path'] = '/forum/';                                                              // The path where FORUM is located relative to the domain name

// Cloudflare
if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
{
	$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

// Path (trailing slash '/' at the end: XX_PATH - without, XX_DIR - with)
define('FT_PATH',       realpath(FT_ROOT)                    );
define('ADMIN_DIR',     FT_PATH .'/admin/'                   );
define('CACHE_DIR',     FT_PATH .'/cache/'     				 );
define('INC_DIR',       FT_PATH .'/includes/'        		 );
define('PROFILE_DIR',   FT_PATH .'/includes/profile/'        );
define('LANG_ROOT_DIR', FT_PATH .'/language/'        		 );
define('IMAGES_DIR',    FT_PATH .'/images/'           		 );
define('TEMPLATES_DIR', FT_PATH .'/templates/'        		 );

// Templates
define('ADMIN_TPL_DIR', TEMPLATES_DIR .'/admin/');

define('GZIP_OUTPUT_ALLOWED', (extension_loaded('zlib') && !ini_get('zlib.output_compression')));

// Cookie
$ft_cfg['cookie_domain'] = in_array($domain_name, array(getenv('SERVER_ADDR'), 'localhost')) ? '' : ".$domain_name";
$ft_cfg['cookie_secure'] = (!empty($_SERVER['HTTPS']) ? 1 : 0);
$ft_cfg['cookie_prefix'] = 'ft_'; // 'ft_'

// Debug
define('DBG_LOG',              false);    // enable forum debug (off on production)
define('DBG_TRACKER',          false);    // enable tracker debug (off on production)
define('COOKIE_DBG',           'ft_dbg'); // debug cookie name
define('SQL_DEBUG',            true);     // enable forum sql & cache debug
define('SQL_LOG_ERRORS',       true);     // all SQL_xxx options enabled only if SQL_DEBUG == TRUE
define('SQL_CALC_QUERY_TIME',  true);     // for stats
define('SQL_LOG_SLOW_QUERIES', true);     // log sql slow queries
define('SQL_SLOW_QUERY_TIME',  10);       // slow query in seconds
define('SQL_PREPEND_SRC_COMM', false);    // prepend source file comment to sql query


$ft_cfg['show_tor_info'] = true; // show bt torrent info

// News
$ft_cfg['show_latest_news'] = true; // show News
$ft_cfg['latest_news_count'] = 5;
$ft_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...

define('FT_CFG_LOADED', true);
