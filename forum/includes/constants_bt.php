<?php

if (!defined('IN_PHPBB'))
{
	exit();
}

define('BT_CONFIG_TABLE',      $table_prefix.'bt_config');          // phpbb_bt_config
define('BT_SEARCH_TABLE',      $table_prefix.'bt_search_results');  // phpbb_bt_search_results
define('BT_TOR_DL_STAT_TABLE', $table_prefix.'bt_tor_dl_stat');     // phpbb_bt_tor_dl_stat
define('BT_TORRENTS_TABLE',    $table_prefix.'bt_torrents');        // phpbb_bt_torrents
define('BT_TRACKER_TABLE',     $table_prefix.'bt_tracker');         // phpbb_bt_tracker
define('BT_USERS_TABLE',       $table_prefix.'bt_users');           // phpbb_bt_users
define('BT_USR_DL_STAT_TABLE', $table_prefix.'bt_users_dl_status'); // phpbb_bt_users_dl_status

define('BT_AUTH_KEY_LENGTH',   10);

define('DL_STATUS_WILL',       0);
define('DL_STATUS_DOWN',       1);
define('DL_STATUS_COMPLETE',   2);
define('DL_STATUS_CANCEL',     3);

?>