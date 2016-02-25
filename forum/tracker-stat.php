<?php

define('FT_SCRIPT', 'stats');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

echo '<br /><br /><br /><table border="1" cellspacing="0" cellpadding="6" align="center">';

$current_time = time();
$p_all = $p_active = $tor = 'unknown';
$p_last = array();

$times = array(30, 10, 3, 1);

foreach ($times as $t)
{
	$p_last[$t] = 'unknown';
}

// All peers
$sql = 'SELECT COUNT(*) AS p_all
	FROM '. BT_TRACKER_TABLE;

if ($row = DB()->sql_fetchrow(DB()->sql_query($sql)))
{
	$p_all = $row['p_all'];
}

// All torrents
$sql = 'SELECT COUNT(DISTINCT torrent_id) AS torrents
	FROM '. BT_TRACKER_TABLE;

if ($row = DB()->sql_fetchrow(DB()->sql_query($sql)))
{
	$tor = $row['torrents'];
}

// Active
$sql = 'SELECT COUNT(*) AS p_active
		FROM '. BT_TRACKER_TABLE ."
		WHERE expire_time > $current_time";

if ($row = DB()->sql_fetchrow(DB()->sql_query($sql)))
{
	$p_active = $row['p_active'];
}

// Last xx minutes
foreach ($times as $t)
{
	$where_time = $current_time - (60*$t);

	$sql = 'SELECT COUNT(*) AS peers
		FROM '. BT_TRACKER_TABLE ."
		WHERE update_time > $where_time";

	if ($row = DB()->sql_fetchrow(DB()->sql_query($sql)))
	{
		$p_last[$t] = $row['peers'];
	}
}

echo "<tr><td> Peers count </td><td align=center> <b>$p_all</b> </td></tr>";
echo "<tr><td> active </td><td align=center> <b>$p_active</b> </td></tr>";

foreach ($times as $t)
{
	echo "<tr><td> in last $t min. </td><td align=center> <b>$p_last[$t]</b> </td></tr>";
}

echo "<tr><td align=center> active torrents </td><td align=center> <b>$tor</b> </td></tr>";

echo '</table>';

DB()->sql_close();

exit;