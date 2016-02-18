<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$ft_cfg = $page_cfg = array();

$dbms = 'mysql';

$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpasswd = '';

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
define('TEMPLATES_DIR', FT_PATH .'/templates/'        		 );

$ft_cfg['show_tor_info'] = true; // show bt torrent info

// News
$ft_cfg['show_latest_news'] = true; // show News
$ft_cfg['latest_news_count'] = 5;
$ft_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...