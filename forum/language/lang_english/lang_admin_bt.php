<?php

$lang['return_config'] = '%sReturn to Configuration%s';
$lang['config_upd'] = 'Configuration Updated Successfully';
$lang['set_defaults'] = 'Restore defaults';

//
// Tracker config
//
$lang['tracker_cfg_title'] = 'Tracker';
$lang['forum_cfg_title'] = 'Forum settings';
$lang['tracker_settings'] = 'Tracker settings';

$lang['off'] = 'Disable tracker';
$lang['off_show_reason'] = 'Continue processing client requests';
$lang['off_show_reason_expl'] = 'send a \'stop\' reason to client';
$lang['off_reason'] = 'Disable reason';
$lang['off_reason_expl'] = 'this message will be sent to client when the tracker is disabled';
$lang['bt_debug'] = 'Debug mode';
$lang['bt_debug_expl'] = 'include extended info into error messages';
$lang['silent_mode'] = 'Do not report errors';
$lang['silent_mode_expl'] = 'in case of error - do not send error message to client';
$lang['autoclean'] = 'Autoclean';
$lang['autoclean_expl'] = 'autoclean peers table - do not disable without reason';
$lang['autoclean_interval'] = 'Autocleaning interval';
$lang['compact_mode'] = 'Compact mode';
$lang['compact_mode_expl'] = '"Yes" - tracker will only accept clients working in compact mode<br />"No" - compatible mode (chosen by client)';
$lang['browser_redirect_url'] = 'Browser redirect URL';
$lang['browser_redirect_url_expl'] = 'if user tries to open tracker URL in Web browser<br />* leave blank to disable';

$lang['do_gzip_head'] = 'GZip';
$lang['do_gzip'] = 'Use GZip compression';
$lang['do_gzip_expl'] = 'compression level can be configured in "bt/config.php"';
$lang['force_gzip'] = 'Always use compression';
$lang['force_gzip_expl'] = 'disable client\'s GZip support checking';
$lang['client_compat_gzip'] = 'Only if supported by client ';
$lang['client_compat_gzip_expl'] = 'do compression using ob_gzhandler()';

$lang['ignor_given_ip_head'] = 'IP';
$lang['ignor_given_ip'] = 'Ignore IP reported by client';
$lang['ignor_given_ip_expl'] = 'use $_SERVER["REMOTE_ADDR"] instead';
$lang['allow_host_ip'] = 'Allow using hostname instead of IP';
$lang['allow_host_ip_expl'] = '';

$lang['ignor_numwant_head'] = 'Numwant';
$lang['ignor_numwant'] = 'Ignore numwant';
$lang['ignor_numwant_expl'] = 'ignore the nubmer of peers requested by client';
$lang['numwant'] = 'Numwant value';
$lang['numwant_expl'] = 'number of peers being sent to client';
$lang['numwant_max'] = 'Max numwant value';
$lang['numwant_max_expl'] = 'max number of peers being sent to client';

$lang['min_ann_intv_head'] = 'Announce';
$lang['min_ann_intv'] = 'Default announce interval';
$lang['min_ann_intv_expl'] = 'peers should wait at least this many seconds between announcements';
$lang['expire_factor'] = 'Peer expire factor';
$lang['expire_factor_expl'] = 'Consider a peer dead if it has not announced in a number of seconds equal to this many times the calculated announce interval at the time of its last announcement (must be greater than 1)';

$lang['limit_active_tor_head'] = 'Limits';
$lang['limit_active_tor'] = 'Limit active torrents';
$lang['limit_active_tor_expl'] = 'this will not work for guests';
$lang['limit_seed_count'] = 'Seeding limit';
$lang['limit_seed_count_expl'] = '(0 - no limit)';
$lang['limit_leech_count'] = 'Leeching limit';
$lang['limit_leech_count_expl'] = '(0 - no limit)';
$lang['leech_expire_factor'] = 'Leech expire factor';
$lang['leech_expire_factor_expl'] = 'Treat a peer as active for this number of minutes even if it sent "stopped" event after starting dl<br />0 - take into account "stopped" event';
$lang['limit_concurrent_ips'] = "Limit concurrent IP's";
$lang['limit_concurrent_ips_expl'] = 'per torrent limit';
$lang['limit_seed_ips'] = 'Seeding IP limit';
$lang['limit_seed_ips_expl'] = "allow seeding from no more than <i>xx</i> IP's<br />0 - no limit";
$lang['limit_leech_ips'] = 'Leeching IP limit';
$lang['limit_leech_ips_expl'] = "allow leeching from no more than <i>xx</i> IP's<br />0 - no limit";

$lang['use_auth_key_head'] = 'Authorization';
$lang['use_auth_key'] = 'Passkey';
$lang['use_auth_key_expl'] = 'enable check for passkey<br />(you can enable adding passkey to the torrent-files before downloading in forum settings: TorrentPier - Forum Config)';
$lang['auth_key_name'] = 'Passkey name';
$lang['auth_key_name_expl'] = 'passkey key name in GET request';
$lang['allow_guest_dl'] = 'Allow guest access to tracker';

$lang['update_users_dl_status_head'] = 'Statistics';
$lang['update_users_dl_status'] = 'Autoupdate users dl-status "Download"';
$lang['update_users_dl_status_expl'] = 'autoupdate users download status when user started downloading';
$lang['update_users_compl_status'] = 'Autoupdate users dl-status "Complete"';
$lang['update_users_compl_status_expl'] = 'autoupdate users download status when user finished downloading';
$lang['upd_user_up_down_stat'] = 'Store users up/down statistics';
$lang['user_statistic_upd_interval'] = 'Users up/down statistics update interval';
$lang['seed_last_seen_upd_interval'] = 'Seeder last seen update interval';

//
// Forum config
//
$lang['forum_cfg_expl'] = 'Forum config';

$lang['bt_select_forums'] = 'Forum options:';
$lang['bt_select_forums_expl'] = 'hold down <i>Ctrl</i> while selecting multiple forums';

$lang['allow_reg_tracker'] = 'Allowed forums for registering <b>.torrents</b> on tracker';
$lang['allow_dl_topic'] = 'Allow post <b>Download topics</b>';
$lang['dl_type_default'] = 'New topics have <b>Download type</b> by default';
$lang['show_dl_buttons'] = 'Show buttons for manually changing DL-status';
$lang['self_moderated'] = 'Users can <b>move</b> their topics to another forum';

$lang['bt_announce_url_head'] = 'Announce URL';
$lang['bt_announce_url'] = 'Announce url';
$lang['bt_announce_url_expl'] = 'you can define additional allowed urls in "includes/announce_urls.php"';
$lang['bt_check_announce_url'] = 'Verify announce url';
$lang['bt_check_announce_url_expl'] = 'register on tracker only allowed urls';
$lang['bt_replace_ann_url'] = 'Replace announce url';
$lang['bt_replace_ann_url_expl'] = 'replace original announce url with your default in .torrent files';
$lang['bt_del_addit_ann_urls'] = 'Remove all additional announce urls';
$lang['bt_add_comment'] = 'Torrent comments';
$lang['bt_add_comment_expl'] = 'adds the Comments filed to the .torrent files (leave blank to use the topic URL as a comment)';
$lang['bt_add_publisher'] = 'Torrent\'s publisher';
$lang['bt_add_publisher_expl'] = 'adds the Publisher field and topic URL as the Publisher-url to the .torrent files (leave blank to disable)';

$lang['bt_show_peers_head'] = 'Peers-List';
$lang['bt_show_peers'] = 'Show peers (seeders and leechers)';
$lang['bt_show_peers_expl'] = 'this will show seeders/leechers list above the topic with torrent';
$lang['bt_show_peers_mode'] = 'By default, show peers as:';
$lang['bt_show_peers_mode_count'] = 'Count only';
$lang['bt_show_peers_mode_names'] = 'Names only';
$lang['bt_show_peers_mode_full'] = 'Full details';
$lang['bt_allow_spmode_change'] = 'Allow "Full details" mode';
$lang['bt_allow_spmode_change_expl'] = 'if "no", only default peer display mode will be available';
$lang['bt_show_ip_only_moder'] = 'Peers\' <b>IP</b>s are visible to moderators only';
$lang['bt_show_port_only_moder'] = 'Peers\' <b>Port</b>s are visible to moderators only';

$lang['bt_show_dl_list_head'] = 'DL-List';
$lang['bt_show_dl_list'] = 'Show DL-List in Download topics';
$lang['bt_dl_list_only_1st_page'] = 'Show DL-List only on first page in topics';
$lang['bt_dl_list_only_count'] = 'Show only number of users';
$lang['bt_dl_list_expire'] = 'Expire time of <i>Will Download</i> and <i>Downloading</i> status';
$lang['bt_dl_list_expire_expl'] = 'after this time users will be automatically removed from DL-List<br />0 - disable';
$lang['bt_show_dl_list_buttons'] = 'Show buttons for manually changing DL-status';
$lang['bt_show_dl_list_buttons_expl'] = 'global setting';
$lang['bt_show_dl_but_will'] = $lang['dlWill'];
$lang['bt_show_dl_but_down'] = $lang['dlDown'];
$lang['bt_show_dl_but_compl'] = $lang['dlComplete'];
$lang['bt_show_dl_but_cancel'] = $lang['dlCancel'];

$lang['bt_add_auth_key_head'] = 'Passkey';
$lang['bt_add_auth_key'] = 'Enable adding passkey to the torrent-files before downloading';
$lang['bt_force_passkey'] = 'Force passkey';
$lang['bt_force_passkey_expl'] = 'redirect guests to login page if trying to download torrent-files';
$lang['bt_gen_passkey_on_reg'] = 'Automatically generate passkey';
$lang['bt_gen_passkey_on_reg_expl'] = "generate passkey during first downloading attempt if current user's passkey is empty";

$lang['bt_tor_browse_only_reg_head'] = 'Torrent browser (tracker)';
$lang['bt_tor_browse_only_reg'] = 'Torrent browser (tracker.php) accessible only for logged in users';
$lang['bt_search_bool_mode'] = 'Allow boolean full-text searches';
$lang['bt_search_bool_mode_expl'] = 'use *, +, -,.. in searches. Work only in MySQL > 4.0.1';

$lang['bt_show_dl_stat_on_index_head'] = "Miscellaneous";
$lang['bt_show_dl_stat_on_index'] = "Show users UL/DL statistics at the top of the forum's main page";
$lang['bt_newtopic_auto_reg'] = 'Automatically register torrent on tracker for new topics';
$lang['bt_set_dltype_on_tor_reg'] = 'Change topic status to "Download" while registering torrent on tracker';
$lang['bt_set_dltype_on_tor_reg_expl'] = 'will change topic type to "Download" regardless of forum settings';
$lang['bt_unset_dltype_on_tor_unreg'] = 'Change topic status to "Normal" while unregistering torrent from tracker';

?>