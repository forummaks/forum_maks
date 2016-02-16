<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

$ft_cfg = array();

$dbms = 'mysql';

$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpasswd = '';

$ft_cfg['show_tor_info'] = true; // show bt torrent info

// News
$ft_cfg['show_latest_news'] = true; // show News
$ft_cfg['latest_news_count'] = 5;
$ft_cfg['latest_news_forum_id'] = '1'; // (string) 1,2,3...