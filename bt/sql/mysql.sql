#
# TorrentPier - MySQL schema
#

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_config`
#

CREATE TABLE phpbb_bt_config (
  config_name varchar(255) NOT NULL DEFAULT '',
  config_value varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (config_name)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_search_results`
#

CREATE TABLE phpbb_bt_search_results (
  session_id varchar(32) NOT NULL default '',
  search_id int(10) unsigned NOT NULL default '0',
  added int(11) NOT NULL default '0',
  search_array text NOT NULL,
  search_settings text NOT NULL,
  PRIMARY KEY (session_id)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_tor_dl_stat`
#

CREATE TABLE phpbb_bt_tor_dl_stat (
  torrent_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(9) NOT NULL default '0',
  attach_id mediumint(8) unsigned NOT NULL default '0',
  t_up_total bigint(20) unsigned NOT NULL default '0',
  t_down_total bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (torrent_id,user_id)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_torrents`
#

CREATE TABLE phpbb_bt_torrents (
  torrent_id mediumint(8) unsigned NOT NULL auto_increment,
  info_hash binary(20) NOT NULL default '',
  post_id mediumint(8) unsigned NOT NULL default '0',
  poster_id mediumint(9) NOT NULL default '0',
  topic_id mediumint(8) unsigned NOT NULL default '0',
  attach_id mediumint(8) unsigned NOT NULL default '0',
  size bigint(20) unsigned NOT NULL default '0',
  piece_length mediumint(8) unsigned NOT NULL default '0',
  reg_time int(11) NOT NULL default '0',
  complete_count mediumint(8) unsigned NOT NULL default '0',
  seeder_last_seen int(11) NOT NULL default '0',
  last_seeder_uid mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (torrent_id),
  UNIQUE KEY info_hash (info_hash),
  UNIQUE KEY post_id (post_id),
  UNIQUE KEY topic_id (topic_id),
  UNIQUE KEY attach_id (attach_id),
  KEY reg_time (reg_time)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_tracker`
#

CREATE TABLE phpbb_bt_tracker (
  torrent_id mediumint(8) unsigned NOT NULL default '0',
  peer_id char(20) binary NOT NULL default '',
  user_id mediumint(9) NOT NULL default '0',
  ip char(8) binary NOT NULL default '0',
  port smallint(5) unsigned NOT NULL default '0',
  uploaded bigint(20) unsigned NOT NULL default '0',
  downloaded bigint(20) unsigned NOT NULL default '0',
  complete_percent bigint(20) unsigned NOT NULL default '0',
  seeder tinyint(1) NOT NULL default '0',
  last_stored_up bigint(20) unsigned NOT NULL default '0',
  last_stored_down bigint(20) unsigned NOT NULL default '0',
  stat_last_updated int(11) NOT NULL default '0',
  speed_up mediumint(8) unsigned NOT NULL default '0',
  speed_down mediumint(8) unsigned NOT NULL default '0',
  update_time int(11) NOT NULL default '0',
  expire_time int(11) NOT NULL default '0',
  KEY torrent_id (torrent_id),
  KEY user_id (user_id)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_users`
#

CREATE TABLE phpbb_bt_users (
  user_id mediumint(9) NOT NULL default '0',
  auth_key binary(10) NOT NULL default '',
  u_up_total bigint(20) unsigned NOT NULL default '0',
  u_down_total bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (user_id),
  UNIQUE KEY auth_key (auth_key)
) TYPE=MyISAM;

#-- --------------------------------------------------------
#
# Table structure for table `phpbb_bt_users_dl_status`
#

CREATE TABLE phpbb_bt_users_dl_status (
  topic_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(9) NOT NULL default '0',
  user_status tinyint(1) NOT NULL default '0',
  update_time int(11) NOT NULL default '0',
  PRIMARY KEY  (topic_id,user_id),
  KEY user_id (user_id)
) TYPE=MyISAM;


#-- --------------------------------------------------------

ALTER TABLE phpbb_posts_text CHANGE post_subject post_subject varchar(120) DEFAULT NULL;

ALTER TABLE phpbb_topics CHANGE topic_title topic_title char(120) NOT NULL;
ALTER TABLE phpbb_topics ADD FULLTEXT (topic_title);

ALTER TABLE phpbb_attachments_desc ADD tracker_status tinyint(1) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_forums ADD allow_reg_tracker tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD allow_dl_topic tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD dl_type_default tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD show_dl_buttons tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD self_moderated tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD last_dl_topics_synch int(11) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_topics ADD topic_dl_type tinyint(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_dl_status tinyint(1) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_users ADD user_allow_passkey tinyint(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD bt_tor_browse_set text DEFAULT '' NOT NULL;

#-- --------------------------------------------------------

#
# Basic DB data for TorrentPier
#

# -- default tracker config
INSERT INTO phpbb_bt_config VALUES ('last_clean_time', '0');
INSERT INTO phpbb_bt_config VALUES ('autoclean', '1');
INSERT INTO phpbb_bt_config VALUES ('off', '0');
INSERT INTO phpbb_bt_config VALUES ('off_show_reason', '1');
INSERT INTO phpbb_bt_config VALUES ('off_reason', 'Tracker is disabled');
INSERT INTO phpbb_bt_config VALUES ('bt_debug', '0');
INSERT INTO phpbb_bt_config VALUES ('silent_mode', '0');
INSERT INTO phpbb_bt_config VALUES ('do_gzip', '0');
INSERT INTO phpbb_bt_config VALUES ('force_gzip', '0');
INSERT INTO phpbb_bt_config VALUES ('client_compat_gzip', '1');
INSERT INTO phpbb_bt_config VALUES ('ignor_given_ip', '1');
INSERT INTO phpbb_bt_config VALUES ('allow_host_ip', '0');
INSERT INTO phpbb_bt_config VALUES ('ignor_numwant', '1');
INSERT INTO phpbb_bt_config VALUES ('numwant', '50');
INSERT INTO phpbb_bt_config VALUES ('numwant_max', '100');
INSERT INTO phpbb_bt_config VALUES ('autoclean_interval', '120');
INSERT INTO phpbb_bt_config VALUES ('min_ann_intv', '1200');
INSERT INTO phpbb_bt_config VALUES ('expire_factor', '3');
INSERT INTO phpbb_bt_config VALUES ('compact_mode', '0');
INSERT INTO phpbb_bt_config VALUES ('use_auth_key', '1');
INSERT INTO phpbb_bt_config VALUES ('auth_key_name', 'uk');
INSERT INTO phpbb_bt_config VALUES ('update_users_dl_status', '1');
INSERT INTO phpbb_bt_config VALUES ('update_users_compl_status', '1');
INSERT INTO phpbb_bt_config VALUES ('allow_guest_dl', '0');
INSERT INTO phpbb_bt_config VALUES ('upd_user_up_down_stat', '1');
INSERT INTO phpbb_bt_config VALUES ('seed_last_seen_upd_interval', '300');
INSERT INTO phpbb_bt_config VALUES ('user_statistic_upd_interval', '25');
INSERT INTO phpbb_bt_config VALUES ('browser_redirect_url', 'http://yourdomain.com/');
INSERT INTO phpbb_bt_config VALUES ('limit_active_tor', '0');
INSERT INTO phpbb_bt_config VALUES ('limit_seed_count', '20');
INSERT INTO phpbb_bt_config VALUES ('limit_leech_count', '4');
INSERT INTO phpbb_bt_config VALUES ('leech_expire_factor', '60');
INSERT INTO phpbb_bt_config VALUES ('limit_concurrent_ips', '0');
INSERT INTO phpbb_bt_config VALUES ('limit_seed_ips', '0');
INSERT INTO phpbb_bt_config VALUES ('limit_leech_ips', '2');

# -- GUEST_UID tracker user
INSERT INTO phpbb_bt_users (user_id, auth_key, u_up_total, u_down_total) VALUES ('-1', '', '0', '0');

# -- forum config
INSERT INTO phpbb_config VALUES ('bt_show_peers', '1');
INSERT INTO phpbb_config VALUES ('bt_show_peers_mode', '1');
INSERT INTO phpbb_config VALUES ('bt_allow_spmode_change', '1');
INSERT INTO phpbb_config VALUES ('bt_add_auth_key', '1');
INSERT INTO phpbb_config VALUES ('bt_show_dl_list', '1');
INSERT INTO phpbb_config VALUES ('bt_dl_list_only_1st_page', '1');
INSERT INTO phpbb_config VALUES ('bt_dl_list_only_count', '1');
INSERT INTO phpbb_config VALUES ('bt_dl_list_expire', '30');
INSERT INTO phpbb_config VALUES ('bt_announce_url', 'http://yourdomain.com/bt/announce.php');
INSERT INTO phpbb_config VALUES ('bt_gen_passkey_on_reg', '1');
INSERT INTO phpbb_config VALUES ('bt_replace_ann_url', '1');
INSERT INTO phpbb_config VALUES ('bt_show_ip_only_moder', '1');
INSERT INTO phpbb_config VALUES ('bt_show_port_only_moder', '1');
INSERT INTO phpbb_config VALUES ('bt_check_announce_url', '0');
INSERT INTO phpbb_config VALUES ('bt_show_dl_list_buttons', '1');
INSERT INTO phpbb_config VALUES ('bt_show_dl_but_will', '1');
INSERT INTO phpbb_config VALUES ('bt_show_dl_but_down', '0');
INSERT INTO phpbb_config VALUES ('bt_show_dl_but_compl', '0');
INSERT INTO phpbb_config VALUES ('bt_show_dl_but_cancel', '1');
INSERT INTO phpbb_config VALUES ('bt_show_dl_stat_on_index', '1');
INSERT INTO phpbb_config VALUES ('bt_newtopic_auto_reg', '1');
INSERT INTO phpbb_config VALUES ('bt_tor_browse_only_reg', '0');
INSERT INTO phpbb_config VALUES ('bt_search_tbl_last_clean', '0');
INSERT INTO phpbb_config VALUES ('bt_search_bool_mode', '0');
INSERT INTO phpbb_config VALUES ('bt_force_passkey', '1');
INSERT INTO phpbb_config VALUES ('bt_del_addit_ann_urls', '0');
INSERT INTO phpbb_config VALUES ('bt_set_dltype_on_tor_reg', '1');
INSERT INTO phpbb_config VALUES ('bt_unset_dltype_on_tor_unreg', '0');
INSERT INTO phpbb_config VALUES ('bt_add_comment', '');
INSERT INTO phpbb_config VALUES ('bt_add_publisher', '');

#-- --------------------------------------------------------

ALTER TABLE phpbb_bt_tracker TYPE = HEAP;