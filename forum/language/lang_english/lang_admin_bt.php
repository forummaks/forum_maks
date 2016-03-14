<?php

$lang['RETURN_CONFIG'] = '%sReturn to Configuration%s';
$lang['CONFIG_UPD'] = 'Configuration Updated Successfully';
$lang['SET_DEFAULTS'] = 'Restore defaults';

////
// Tracker config// TRACKER CONFIG
////
$lang['TRACKER_CFG_TITLE'] = 'Tracker';
$lang['FORUM_CFG_TITLE'] = 'Forum settings';
$lang['TRACKER_SETTINGS'] = 'Tracker settings';

$lang['OFF'] = 'Disable tracker';
$lang['OFF_SHOW_REASON'] = 'Continue processing client requests';
$lang['OFF_SHOW_REASON_EXPL'] = 'send a \'stop\' reason to client';
$lang['OFF_REASON'] = 'Disable reason';
$lang['OFF_REASON_EXPL'] = 'this message will be sent to client when the tracker is disabled';
$lang['BT_DEBUG'] = 'Debug mode';
$lang['BT_DEBUG_EXPL'] = 'include extended info into error messages';
$lang['SILENT_MODE'] = 'Do not report errors';
$lang['SILENT_MODE_EXPL'] = 'in case of error - do not send error message to client';
$lang['AUTOCLEAN'] = 'Autoclean';
$lang['AUTOCLEAN_EXPL'] = 'autoclean peers table - do not disable without reason';
$lang['AUTOCLEAN_INTERVAL'] = 'Autocleaning interval';
$lang['COMPACT_MODE'] = 'Compact mode';
$lang['COMPACT_MODE_EXPL'] = '"Yes" - tracker will only accept clients working in compact mode<br />"No" - compatible mode (chosen by client)';
$lang['BROWSER_REDIRECT_URL'] = 'Browser redirect URL';
$lang['BROWSER_REDIRECT_URL_EXPL'] = 'if user tries to open tracker URL in Web browser<br />* leave blank to disable';

$lang['DO_GZIP_HEAD'] = 'GZip';
$lang['DO_GZIP'] = 'Use GZip compression';
$lang['DO_GZIP_EXPL'] = 'compression level can be configured in "bt/config.php"';
$lang['FORCE_GZIP'] = 'Always use compression';
$lang['FORCE_GZIP_EXPL'] = 'disable client\'s GZip support checking';
$lang['CLIENT_COMPAT_GZIP'] = 'Only if supported by client ';
$lang['CLIENT_COMPAT_GZIP_EXPL'] = 'do compression using ob_gzhandler()';

$lang['IGNOR_GIVEN_IP_HEAD'] = 'IP';
$lang['IGNOR_GIVEN_IP'] = 'Ignore IP reported by client';
$lang['IGNOR_GIVEN_IP_EXPL'] = 'use $_SERVER["REMOTE_ADDR"] instead';
$lang['ALLOW_HOST_IP'] = 'Allow using hostname instead of IP';
$lang['ALLOW_HOST_IP_EXPL'] = '';

$lang['IGNOR_NUMWANT_HEAD'] = 'Numwant';
$lang['IGNOR_NUMWANT'] = 'Ignore numwant';
$lang['IGNOR_NUMWANT_EXPL'] = 'ignore the nubmer of peers requested by client';
$lang['NUMWANT'] = 'Numwant value';
$lang['NUMWANT_EXPL'] = 'number of peers being sent to client';
$lang['NUMWANT_MAX'] = 'Max numwant value';
$lang['NUMWANT_MAX_EXPL'] = 'max number of peers being sent to client';

$lang['MIN_ANN_INTV_HEAD'] = 'Announce';
$lang['MIN_ANN_INTV'] = 'Default announce interval';
$lang['MIN_ANN_INTV_EXPL'] = 'peers should wait at least this many seconds between announcements';
$lang['EXPIRE_FACTOR'] = 'Peer expire factor';
$lang['EXPIRE_FACTOR_EXPL'] = 'Consider a peer dead if it has not announced in a number of seconds equal to this many times the calculated announce interval at the time of its last announcement (must be greater than 1)';

$lang['LIMIT_ACTIVE_TOR_HEAD'] = 'Limits';
$lang['LIMIT_ACTIVE_TOR'] = 'Limit active torrents';
$lang['LIMIT_ACTIVE_TOR_EXPL'] = 'this will not work for guests';
$lang['LIMIT_SEED_COUNT'] = 'Seeding limit';
$lang['LIMIT_SEED_COUNT_EXPL'] = '(0 - no limit)';
$lang['LIMIT_LEECH_COUNT'] = 'Leeching limit';
$lang['LIMIT_LEECH_COUNT_EXPL'] = '(0 - no limit)';
$lang['LEECH_EXPIRE_FACTOR'] = 'Leech expire factor';
$lang['LEECH_EXPIRE_FACTOR_EXPL'] = 'Treat a peer as active for this number of minutes even if it sent "stopped" event after starting dl<br />0 - take into account "stopped" event';
$lang['LIMIT_CONCURRENT_IPS'] = 'Limit concurrent IP\'s';
$lang['LIMIT_CONCURRENT_IPS_EXPL'] = 'per torrent limit';
$lang['LIMIT_SEED_IPS'] = 'Seeding IP limit';
$lang['LIMIT_SEED_IPS_EXPL'] = 'allow seeding from no more than <i>xx</i> IP\'s<br />0 - no limit';
$lang['LIMIT_LEECH_IPS'] = 'Leeching IP limit';
$lang['LIMIT_LEECH_IPS_EXPL'] = 'allow leeching from no more than <i>xx</i> IP\'s<br />0 - no limit';

$lang['USE_AUTH_KEY_HEAD'] = 'Authorization';
$lang['USE_AUTH_KEY'] = 'Passkey';
$lang['USE_AUTH_KEY_EXPL'] = 'enable check for passkey<br />(you can enable adding passkey to the torrent-files before downloading in forum settings: TorrentPier - Forum Config)';
$lang['AUTH_KEY_NAME'] = 'Passkey name';
$lang['AUTH_KEY_NAME_EXPL'] = 'passkey key name in GET request';
$lang['ALLOW_GUEST_DL'] = 'Allow guest access to tracker';

$lang['UPDATE_USERS_DL_STATUS_HEAD'] = 'Statistics';
$lang['UPDATE_USERS_DL_STATUS'] = 'Autoupdate users dl-status "Download"';
$lang['UPDATE_USERS_DL_STATUS_EXPL'] = 'autoupdate users download status when user started downloading';
$lang['UPDATE_USERS_COMPL_STATUS'] = 'Autoupdate users dl-status "Complete"';
$lang['UPDATE_USERS_COMPL_STATUS_EXPL'] = 'autoupdate users download status when user finished downloading';
$lang['UPD_USER_UP_DOWN_STAT'] = 'Store users up/down statistics';
$lang['USER_STATISTIC_UPD_INTERVAL'] = 'Users up/down statistics update interval';
$lang['SEED_LAST_SEEN_UPD_INTERVAL'] = 'Seeder last seen update interval';

////
// Forum config// FORUM CONFIG
////
$lang['FORUM_CFG_EXPL'] = 'Forum config';

$lang['BT_SELECT_FORUMS'] = 'Forum options:';
$lang['BT_SELECT_FORUMS_EXPL'] = 'hold down <i>Ctrl</i> while selecting multiple forums';

$lang['ALLOW_REG_TRACKER'] = 'Allowed forums for registering <b>.torrents</b> on tracker';
$lang['ALLOW_DL_TOPIC'] = 'Allow post <b>Download topics</b>';
$lang['DL_TYPE_DEFAULT'] = 'New topics have <b>Download type</b> by default';
$lang['SHOW_DL_BUTTONS'] = 'Show buttons for manually changing DL-status';
$lang['SELF_MODERATED'] = 'Users can <b>move</b> their topics to another forum';

$lang['BT_ANNOUNCE_URL_HEAD'] = 'Announce URL';
$lang['BT_ANNOUNCE_URL'] = 'Announce url';
$lang['BT_ANNOUNCE_URL_EXPL'] = 'you can define additional allowed urls in "includes/announce_urls.php"';
$lang['BT_CHECK_ANNOUNCE_URL'] = 'Verify announce url';
$lang['BT_CHECK_ANNOUNCE_URL_EXPL'] = 'register on tracker only allowed urls';
$lang['BT_REPLACE_ANN_URL'] = 'Replace announce url';
$lang['BT_REPLACE_ANN_URL_EXPL'] = 'replace original announce url with your default in .torrent files';
$lang['BT_DEL_ADDIT_ANN_URLS'] = 'Remove all additional announce urls';
$lang['BT_ADD_COMMENT'] = 'Torrent comments';
$lang['BT_ADD_COMMENT_EXPL'] = 'adds the Comments filed to the .torrent files (leave blank to use the topic URL as a comment)';
$lang['BT_ADD_PUBLISHER'] = 'Torrent\'s publisher';
$lang['BT_ADD_PUBLISHER_EXPL'] = 'adds the Publisher field and topic URL as the Publisher-url to the .torrent files (leave blank to disable)';

$lang['BT_SHOW_PEERS_HEAD'] = 'Peers-List';
$lang['BT_SHOW_PEERS'] = 'Show peers (seeders and leechers)';
$lang['BT_SHOW_PEERS_EXPL'] = 'this will show seeders/leechers list above the topic with torrent';
$lang['BT_SHOW_PEERS_MODE'] = 'By default, show peers as:';
$lang['BT_SHOW_PEERS_MODE_COUNT'] = 'Count only';
$lang['BT_SHOW_PEERS_MODE_NAMES'] = 'Names only';
$lang['BT_SHOW_PEERS_MODE_FULL'] = 'Full details';
$lang['BT_ALLOW_SPMODE_CHANGE'] = 'Allow "Full details" mode';
$lang['BT_ALLOW_SPMODE_CHANGE_EXPL'] = 'if "no", only default peer display mode will be available';
$lang['BT_SHOW_IP_ONLY_MODER'] = 'Peers\' <b>IP</b>s are visible to moderators only';
$lang['BT_SHOW_PORT_ONLY_MODER'] = 'Peers\' <b>Port</b>s are visible to moderators only';

$lang['BT_SHOW_DL_LIST_HEAD'] = 'DL-List';
$lang['BT_SHOW_DL_LIST'] = 'Show DL-List in Download topics';
$lang['BT_DL_LIST_ONLY_1ST_PAGE'] = 'Show DL-List only on first page in topics';
$lang['BT_DL_LIST_ONLY_COUNT'] = 'Show only number of users';
$lang['BT_DL_LIST_EXPIRE'] = 'Expire time of <i>Will Download</i> and <i>Downloading</i> status';
$lang['BT_DL_LIST_EXPIRE_EXPL'] = 'after this time users will be automatically removed from DL-List<br />0 - disable';
$lang['BT_SHOW_DL_LIST_BUTTONS'] = 'Show buttons for manually changing DL-status';
$lang['BT_SHOW_DL_LIST_BUTTONS_EXPL'] = 'global setting';
$lang['BT_SHOW_DL_BUT_WILL'] = $lang['DLWILL'];
$lang['BT_SHOW_DL_BUT_DOWN'] = $lang['DLDOWN'];
$lang['BT_SHOW_DL_BUT_COMPL'] = $lang['DLCOMPLETE'];
$lang['BT_SHOW_DL_BUT_CANCEL'] = $lang['DLCANCEL'];

$lang['BT_ADD_AUTH_KEY_HEAD'] = 'Passkey';
$lang['BT_ADD_AUTH_KEY'] = 'Enable adding passkey to the torrent-files before downloading';
$lang['BT_FORCE_PASSKEY'] = 'Force passkey';
$lang['BT_FORCE_PASSKEY_EXPL'] = 'redirect guests to login page if trying to download torrent-files';
$lang['BT_GEN_PASSKEY_ON_REG'] = 'Automatically generate passkey';
$lang['BT_GEN_PASSKEY_ON_REG_EXPL'] = 'generate passkey during first downloading attempt if current user\'s passkey is empty';

$lang['BT_TOR_BROWSE_ONLY_REG_HEAD'] = 'Torrent browser (tracker)';
$lang['BT_TOR_BROWSE_ONLY_REG'] = 'Torrent browser (tracker.php) accessible only for logged in users';
$lang['BT_SEARCH_BOOL_MODE'] = 'Allow boolean full-text searches';
$lang['BT_SEARCH_BOOL_MODE_EXPL'] = 'use *, +, -,.. in searches. Work only in MySQL > 4.0.1';

$lang['BT_SHOW_DL_STAT_ON_INDEX_HEAD'] = 'Miscellaneous';
$lang['BT_SHOW_DL_STAT_ON_INDEX'] = 'Show users UL/DL statistics at the top of the forum\'s main page';
$lang['BT_NEWTOPIC_AUTO_REG'] = 'Automatically register torrent on tracker for new topics';
$lang['BT_SET_DLTYPE_ON_TOR_REG'] = 'Change topic status to "Download" while registering torrent on tracker';
$lang['BT_SET_DLTYPE_ON_TOR_REG_EXPL'] = 'will change topic type to "Download" regardless of forum settings';
$lang['BT_UNSET_DLTYPE_ON_TOR_UNREG'] = 'Change topic status to "Normal" while unregistering torrent from tracker';


?>