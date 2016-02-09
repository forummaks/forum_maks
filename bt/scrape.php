<?php

$starttime = array_sum(explode(' ', microtime()));

define('IN_PHPBB', TRUE);

require('config.php');
include('includes/tr_scraper.'. PHP_EXT);

exit;

?>