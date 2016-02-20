<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$ft_cfg = $page_cfg = array();

// Primary domain name
$domain_name = 'ft.org'; // enter here your primary domain name of your site
$domain_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $domain_name;

$dbms = 'mysql';

$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpasswd = '';

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
$ft_cfg['cookie_prefix'] = 'ft_'; // 'bb_'

// Debug
define('DBG_LOG',              false);    // enable forum debug (off on production)
define('DBG_TRACKER',          false);    // enable tracker debug (off on production)
define('COOKIE_DBG',           'ft_dbg'); // debug cookie name

$ft_cfg['show_tor_info'] = true; // show bt torrent info

// News
$ft_cfg['show_latest_news'] = true; // show News
$ft_cfg['latest_news_count'] = 5;
$ft_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...
