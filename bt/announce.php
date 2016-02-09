<?php

$starttime = array_sum(explode(' ', microtime()));

/*
$working_second = 2;

$ignore_request = ($working_second && (time() % $working_second)) ? 1 : 0;

if ($ignore_request && (@$_GET['uploaded'] || @$_GET['downloaded']))
{
	if (!isset($_GET['event']) || $_GET['event'] == 'started')
	{
		header('Content-Type: text/plain');
		header('Pragma: no-cache');
		echo 'd8:intervali461e5:peers6:'. pack('Nn', ip2long('10.254.254.247'), 64765) .'e';
		exit;
	}
}
*/

define('IN_PHPBB', TRUE);

require('config.php');
include('includes/tr_announcer.'. PHP_EXT);

exit;

?>