<?php

$dbms = 'mysql';

$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpasswd = '';

$table_prefix = 'phpbb_';

define('PHPBB_INSTALLED', true);

$bb_cfg['show_tor_info'] = true; // show bt torrent info

// News
$bb_cfg['show_latest_news'] = true; // show News
$bb_cfg['latest_news_count'] = 5;
$bb_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...

?>