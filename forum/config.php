<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$ft_cfg = $page_cfg = array();

// Increase number after changing js or css
$ft_cfg['js_ver'] = $ft_cfg['css_ver'] = 1;

// Primary domain name
$domain_name = 'ft.org'; // enter here your primary domain name of your site
$domain_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $domain_name;

// Database
$charset  = 'utf8';
$pconnect = false;

// Настройка баз данных ['db']['srv_name'] => (array) srv_cfg;
// порядок параметров srv_cfg (хост, название базы, пользователь, пароль, charset, pconnect);
$ft_cfg['database'] = array(
	'database1' => array('localhost', '', '', '', $charset, $pconnect),
	//'database2' => array('localhost2', 'dbase2', 'user2', 'pass2', $charset, $pconnect),
	//'database3' => array('localhost3', 'dbase3', 'user2', 'pass3', $charset, $pconnect),
);

$ft_cfg['database_alias'] = array(
//	'alias'  => 'srv_name'
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
define('LOG_DIR',       FT_PATH .'/log/'       				 );
define('INC_DIR',       FT_PATH .'/includes/'        		 );
define('PROFILE_DIR',   FT_PATH .'/includes/profile/'        );
define('LANG_ROOT_DIR', FT_PATH .'/language/'        		 );
define('IMAGES_DIR',    FT_PATH .'/images/'           		 );
define('TEMPLATES_DIR', FT_PATH .'/templates/'        		 );

// URL's
$ft_cfg['login_url']   = 'login.php';    #  "http://{$domain_name}/login.php"
$ft_cfg['posting_url'] = 'posting.php';  #  "http://{$domain_name}/posting.php"
$ft_cfg['pm_url']      = 'privmsg.php';  #  "http://{$domain_name}/privmsg.php"

// Templates
define('ADMIN_TPL_DIR', TEMPLATES_DIR .'/admin/');

// Templates
$ft_cfg['templates'] = array(
//	'folder'  => 'Name',
	'default' => 'Стандартный',
);

$ft_cfg['tpl_name'] = 'default';
$ft_cfg['link_css'] = 'main.css';

$ft_cfg['show_sidebar1_on_every_page'] = false;
$ft_cfg['show_sidebar2_on_every_page'] = false;

$page_cfg['show_sidebar1'] = array(
#	FT_SCRIPT => true
	'index'   => true,
);
$page_cfg['show_sidebar2'] = array(
#	FT_SCRIPT => true
	'index'   => true,
);

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

// Log options
define('LOG_EXT',      'log');
define('LOG_SEPR',     ' | ');
define('LOG_LF',       "\n");
define('LOG_MAX_SIZE', 1048576); // bytes

// Error reporting
ini_set('error_reporting', E_ALL);
ini_set('display_errors',  0);
ini_set('log_errors',      1);
ini_set('error_log',       LOG_DIR .'php_err.log');

// Check some variable
// Magic quotes
if (get_magic_quotes_gpc()) die('Set magic_quotes off');
// JSON
if (!function_exists('json_encode')) die('Json_encode not installed');

// Misc
define('MEM_USAGE', function_exists('memory_get_usage'));

$ft_cfg['mem_on_start'] = (MEM_USAGE) ? memory_get_usage() : 0;

define('GZIP_OUTPUT_ALLOWED', (extension_loaded('zlib') && !ini_get('zlib.output_compression')));

// Topics
$ft_cfg['ext_link_new_win']       = true;          // open external links in new window

$ft_cfg['show_tor_info'] = true; // show bt torrent info

// News
$ft_cfg['show_latest_news'] = true; // show News
$ft_cfg['latest_news_count'] = 5;
$ft_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...

define('FT_CFG_LOADED', true);
