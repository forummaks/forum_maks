SET SQL_MODE = "";

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_attachments`
--

CREATE TABLE IF NOT EXISTS `phpbb_attachments` (
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id_1` mediumint(8) NOT NULL DEFAULT '0',
  `user_id_2` mediumint(8) NOT NULL DEFAULT '0',
  KEY `attach_id_post_id` (`attach_id`,`post_id`),
  KEY `attach_id_privmsgs_id` (`attach_id`,`privmsgs_id`),
  KEY `post_id` (`post_id`),
  KEY `privmsgs_id` (`privmsgs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_attachments`
--

INSERT INTO `phpbb_attachments` (`attach_id`, `post_id`, `privmsgs_id`, `user_id_1`, `user_id_2`) VALUES
(1, 4, 0, 4, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_attachments_config`
--

CREATE TABLE IF NOT EXISTS `phpbb_attachments_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_attachments_config`
--

INSERT INTO `phpbb_attachments_config` (`config_name`, `config_value`) VALUES
('upload_dir', 'files'),
('upload_img', 'images/dl_tor_icon.gif'),
('topic_icon', 'images/icon_clip.gif'),
('display_order', '0'),
('max_filesize', '262144'),
('attachment_quota', '52428800'),
('max_filesize_pm', '262144'),
('max_attachments', '1'),
('max_attachments_pm', '1'),
('disable_mod', '0'),
('allow_pm_attach', '1'),
('attachment_topic_review', '0'),
('allow_ftp_upload', '0'),
('show_apcp', '0'),
('attach_version', '2.3.14'),
('default_upload_quota', '0'),
('default_pm_quota', '0'),
('ftp_server', ''),
('ftp_path', ''),
('download_path', ''),
('ftp_user', ''),
('ftp_pass', ''),
('ftp_pasv_mode', '1'),
('img_display_inlined', '1'),
('img_max_width', '200'),
('img_max_height', '200'),
('img_link_width', '0'),
('img_link_height', '0'),
('img_create_thumbnail', '1'),
('img_min_thumb_filesize', '12000'),
('img_imagick', '/usr/bin/convert'),
('use_gd2', '1'),
('wma_autoplay', '0'),
('flash_autoplay', '0');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_attachments_desc`
--

CREATE TABLE IF NOT EXISTS `phpbb_attachments_desc` (
  `attach_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `physical_filename` varchar(255) NOT NULL DEFAULT '',
  `real_filename` varchar(255) NOT NULL DEFAULT '',
  `download_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `mimetype` varchar(100) DEFAULT NULL,
  `filesize` int(20) NOT NULL DEFAULT '0',
  `filetime` int(11) NOT NULL DEFAULT '0',
  `thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  `tracker_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attach_id`),
  KEY `filetime` (`filetime`),
  KEY `physical_filename` (`physical_filename`(10)),
  KEY `filesize` (`filesize`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_attachments_desc`
--

INSERT INTO `phpbb_attachments_desc` (`attach_id`, `physical_filename`, `real_filename`, `download_count`, `comment`, `extension`, `mimetype`, `filesize`, `filetime`, `thumbnail`, `tracker_status`) VALUES
(1, 'test_167.torrent', 'test.torrent', 1, 'File Comment', 'torrent', 'application/x-bittorrent', 251, 1117378177, 0, 1);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_attach_quota`
--

CREATE TABLE IF NOT EXISTS `phpbb_attach_quota` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `quota_type` smallint(2) NOT NULL DEFAULT '0',
  `quota_limit_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `quota_type` (`quota_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_auth_access`
--

CREATE TABLE IF NOT EXISTS `phpbb_auth_access` (
  `group_id` mediumint(8) NOT NULL DEFAULT '0',
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `auth_view` tinyint(1) NOT NULL DEFAULT '0',
  `auth_read` tinyint(1) NOT NULL DEFAULT '0',
  `auth_post` tinyint(1) NOT NULL DEFAULT '0',
  `auth_reply` tinyint(1) NOT NULL DEFAULT '0',
  `auth_edit` tinyint(1) NOT NULL DEFAULT '0',
  `auth_delete` tinyint(1) NOT NULL DEFAULT '0',
  `auth_sticky` tinyint(1) NOT NULL DEFAULT '0',
  `auth_announce` tinyint(1) NOT NULL DEFAULT '0',
  `auth_vote` tinyint(1) NOT NULL DEFAULT '0',
  `auth_pollcreate` tinyint(1) NOT NULL DEFAULT '0',
  `auth_attachments` tinyint(1) NOT NULL DEFAULT '0',
  `auth_mod` tinyint(1) NOT NULL DEFAULT '0',
  `auth_download` tinyint(1) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_banlist`
--

CREATE TABLE IF NOT EXISTS `phpbb_banlist` (
  `ban_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ban_userid` mediumint(8) NOT NULL DEFAULT '0',
  `ban_ip` varchar(8) NOT NULL DEFAULT '',
  `ban_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ban_id`),
  KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_config`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_bt_config`
--

INSERT INTO `phpbb_bt_config` (`config_name`, `config_value`) VALUES
('last_clean_time', '0'),
('autoclean', '1'),
('off', '0'),
('off_show_reason', '1'),
('off_reason', 'Tracker is disabled'),
('bt_debug', '0'),
('silent_mode', '0'),
('do_gzip', '0'),
('force_gzip', '0'),
('client_compat_gzip', '1'),
('ignor_given_ip', '1'),
('allow_host_ip', '0'),
('ignor_numwant', '1'),
('numwant', '50'),
('numwant_max', '100'),
('autoclean_interval', '120'),
('min_ann_intv', '1200'),
('expire_factor', '3'),
('compact_mode', '0'),
('use_auth_key', '1'),
('auth_key_name', 'uk'),
('update_users_dl_status', '1'),
('update_users_compl_status', '1'),
('allow_guest_dl', '0'),
('upd_user_up_down_stat', '1'),
('seed_last_seen_upd_interval', '300'),
('user_statistic_upd_interval', '25'),
('browser_redirect_url', 'http://yourdomain.com/'),
('limit_active_tor', '0'),
('limit_seed_count', '20'),
('limit_leech_count', '4'),
('leech_expire_factor', '60'),
('limit_concurrent_ips', '0'),
('limit_seed_ips', '0'),
('limit_leech_ips', '2');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_search_results`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_search_results` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `search_id` int(10) unsigned NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `search_array` text NOT NULL,
  `search_settings` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_torrents`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_torrents` (
  `torrent_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `info_hash` binary(20) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poster_id` mediumint(9) NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `piece_length` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reg_time` int(11) NOT NULL DEFAULT '0',
  `complete_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `seeder_last_seen` int(11) NOT NULL DEFAULT '0',
  `last_seeder_uid` mediumint(9) NOT NULL DEFAULT '0',
  `topic_check_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topic_check_uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_check_date` int(11) NOT NULL DEFAULT '0',
  `topic_check_first_fid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_check_duble_tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`torrent_id`),
  UNIQUE KEY `info_hash` (`info_hash`),
  UNIQUE KEY `post_id` (`post_id`),
  UNIQUE KEY `topic_id` (`topic_id`),
  UNIQUE KEY `attach_id` (`attach_id`),
  KEY `reg_time` (`reg_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_bt_torrents`
--

INSERT INTO `phpbb_bt_torrents` (`torrent_id`, `info_hash`, `post_id`, `poster_id`, `topic_id`, `attach_id`, `size`, `piece_length`, `reg_time`, `complete_count`, `seeder_last_seen`, `last_seeder_uid`, `topic_check_status`, `topic_check_uid`, `topic_check_date`, `topic_check_first_fid`, `topic_check_duble_tid`) VALUES
(1, 'х\Zm“шФuэЃoF? ЕsOЁ', 4, 4, 3, 1, 16748964, 4194304, 1117378225, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_tor_dl_stat`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_tor_dl_stat` (
  `torrent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `t_up_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `t_down_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`torrent_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_tracker`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_tracker` (
  `torrent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `peer_id` char(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `ip` char(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `complete_percent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` tinyint(1) NOT NULL DEFAULT '0',
  `releaser` tinyint(1) NOT NULL DEFAULT '0',
  `last_stored_up` bigint(20) unsigned NOT NULL DEFAULT '0',
  `last_stored_down` bigint(20) unsigned NOT NULL DEFAULT '0',
  `stat_last_updated` int(11) NOT NULL DEFAULT '0',
  `speed_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `speed_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `expire_time` int(11) NOT NULL DEFAULT '0',
  KEY `torrent_id` (`torrent_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_users`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_users` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `auth_key` binary(10) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0',
  `u_up_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `u_bonus_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `u_down_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `auth_key` (`auth_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_bt_users`
--

INSERT INTO `phpbb_bt_users` (`user_id`, `auth_key`, `u_up_total`, `u_bonus_total`, `u_down_total`) VALUES
(-1, '\0\0\0\0\0\0\0\0\0\0', 0, 0, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_bt_users_dl_status`
--

CREATE TABLE IF NOT EXISTS `phpbb_bt_users_dl_status` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `compl_count` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_categories`
--

CREATE TABLE IF NOT EXISTS `phpbb_categories` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(100) DEFAULT NULL,
  `cat_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_categories`
--

INSERT INTO `phpbb_categories` (`cat_id`, `cat_title`, `cat_order`) VALUES
(1, 'Test category 1', 10);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_config`
--

CREATE TABLE IF NOT EXISTS `phpbb_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_config`
--

INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES
('config_id', '1'),
('board_disable', '0'),
('sitename', 'yourdomain.com'),
('site_desc', 'A _little_ text to describe your forum'),
('cookie_name', 'phpbb2mysql'),
('cookie_path', '/'),
('cookie_domain', ''),
('cookie_secure', '0'),
('session_length', '3600'),
('allow_html', '0'),
('allow_html_tags', 'b,i,u,pre'),
('allow_bbcode', '1'),
('allow_smilies', '1'),
('allow_sig', '1'),
('allow_namechange', '0'),
('allow_theme_create', '0'),
('allow_avatar_local', '0'),
('allow_avatar_remote', '0'),
('allow_avatar_upload', '1'),
('enable_confirm', '1'),
('override_user_style', '0'),
('posts_per_page', '15'),
('topics_per_page', '50'),
('hot_threshold', '300'),
('max_poll_options', '6'),
('max_sig_chars', '255'),
('max_inbox_privmsgs', '200'),
('max_sentbox_privmsgs', '25'),
('max_savebox_privmsgs', '50'),
('board_email_sig', 'Thanks, The Management'),
('board_email', 'admin@admin.com'),
('smtp_delivery', '0'),
('smtp_host', ''),
('smtp_username', ''),
('smtp_password', ''),
('sendmail_fix', '0'),
('require_activation', '0'),
('flood_interval', '15'),
('board_email_form', '0'),
('avatar_filesize', '6144'),
('avatar_max_width', '80'),
('avatar_max_height', '80'),
('avatar_path', 'images/avatars'),
('avatar_gallery_path', 'images/avatars/gallery'),
('smilies_path', 'images/smiles'),
('default_style', '1'),
('default_dateformat', 'Y-m-d H:i'),
('board_timezone', '0'),
('prune_enable', '1'),
('privmsg_disable', '0'),
('gzip_compress', '0'),
('coppa_fax', ''),
('coppa_mail', ''),
('record_online_users', '1'),
('record_online_date', '0'),
('server_name', 'localhost'),
('server_port', '80'),
('script_path', '/forum/'),
('version', '.0.17'),
('bt_show_peers', '1'),
('bt_show_peers_mode', '1'),
('bt_allow_spmode_change', '1'),
('bt_add_auth_key', '1'),
('bt_show_dl_list', '1'),
('bt_dl_list_only_1st_page', '1'),
('bt_dl_list_only_count', '1'),
('bt_dl_list_expire', '30'),
('bt_announce_url', 'http://yourdomain.com/bt/announce.php'),
('bt_gen_passkey_on_reg', '1'),
('bt_replace_ann_url', '1'),
('bt_show_ip_only_moder', '1'),
('bt_show_port_only_moder', '1'),
('bt_check_announce_url', '0'),
('bt_show_dl_list_buttons', '1'),
('bt_show_dl_but_will', '1'),
('bt_show_dl_but_down', '0'),
('bt_show_dl_but_compl', '0'),
('bt_show_dl_but_cancel', '1'),
('bt_show_dl_stat_on_index', '1'),
('bt_newtopic_auto_reg', '1'),
('bt_tor_browse_only_reg', '0'),
('bt_search_tbl_last_clean', '0'),
('bt_search_bool_mode', '0'),
('bt_force_passkey', '1'),
('bt_del_addit_ann_urls', '1'),
('bt_set_dltype_on_tor_reg', '1'),
('bt_unset_dltype_on_tor_unreg', '0'),
('bt_add_comment', ''),
('bt_add_publisher', 'YourSiteName'),
('dbmtnc_rebuild_end', '0'),
('dbmtnc_rebuild_pos', '-1'),
('dbmtnc_rebuildcfg_maxmemory', '500'),
('dbmtnc_rebuildcfg_minposts', '3'),
('dbmtnc_rebuildcfg_php3only', '0'),
('dbmtnc_rebuildcfg_php3pps', '1'),
('dbmtnc_rebuildcfg_php4pps', '8'),
('dbmtnc_rebuildcfg_timelimit', '240'),
('dbmtnc_rebuildcfg_timeoverwrite', '0'),
('dbmtnc_disallow_postcounter', '0'),
('dbmtnc_disallow_rebuild', '0'),
('board_startdate', '1455565573'),
('default_lang', 'russian'),
('xs_auto_compile', '1'),
('xs_auto_recompile', '1'),
('xs_use_cache', '1'),
('xs_php', 'php'),
('xs_def_template', 'subSilver'),
('xs_check_switches', '0'),
('xs_warn_includes', '0'),
('xs_add_comments', '0'),
('xs_ftp_host', ''),
('xs_ftp_login', ''),
('xs_ftp_path', ''),
('xs_downloads_count', '0'),
('xs_downloads_default', '0'),
('xs_shownav', '17'),
('xs_template_time', '0'),
('xs_version', '7');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_confirm`
--

CREATE TABLE IF NOT EXISTS `phpbb_confirm` (
  `confirm_id` char(32) NOT NULL DEFAULT '',
  `session_id` char(32) NOT NULL DEFAULT '',
  `code` char(6) NOT NULL DEFAULT '',
  PRIMARY KEY (`session_id`,`confirm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_disallow`
--

CREATE TABLE IF NOT EXISTS `phpbb_disallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `disallow_username` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`disallow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_extensions`
--

CREATE TABLE IF NOT EXISTS `phpbb_extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extension` varchar(100) NOT NULL DEFAULT '',
  `comment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ext_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_extensions`
--

INSERT INTO `phpbb_extensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES
(1, 1, 'gif', ''),
(2, 1, 'png', ''),
(3, 1, 'jpeg', ''),
(4, 1, 'jpg', ''),
(5, 1, 'tif', ''),
(6, 1, 'tga', ''),
(7, 2, 'gtar', ''),
(8, 2, 'gz', ''),
(9, 2, 'tar', ''),
(10, 2, 'zip', ''),
(11, 2, 'rar', ''),
(12, 2, 'ace', ''),
(13, 3, 'txt', ''),
(14, 3, 'c', ''),
(15, 3, 'h', ''),
(16, 3, 'cpp', ''),
(17, 3, 'hpp', ''),
(18, 3, 'diz', ''),
(19, 4, 'xls', ''),
(20, 4, 'doc', ''),
(21, 4, 'dot', ''),
(22, 4, 'pdf', ''),
(23, 4, 'ai', ''),
(24, 4, 'ps', ''),
(25, 4, 'ppt', ''),
(26, 5, 'rm', ''),
(27, 6, 'wma', ''),
(28, 7, 'swf', ''),
(29, 8, 'torrent', '');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_extension_groups`
--

CREATE TABLE IF NOT EXISTS `phpbb_extension_groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL DEFAULT '',
  `cat_id` tinyint(2) NOT NULL DEFAULT '0',
  `allow_group` tinyint(1) NOT NULL DEFAULT '0',
  `download_mode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `upload_icon` varchar(100) DEFAULT '',
  `max_filesize` int(20) NOT NULL DEFAULT '0',
  `forum_permissions` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_extension_groups`
--

INSERT INTO `phpbb_extension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES
(1, 'Images', 1, 1, 1, '', 262144, ''),
(2, 'Archives', 0, 1, 1, '', 262144, ''),
(3, 'Plain Text', 0, 0, 1, '', 262144, ''),
(4, 'Documents', 0, 0, 1, '', 262144, ''),
(5, 'Real Media', 0, 0, 2, '', 262144, ''),
(6, 'Streams', 2, 0, 1, '', 262144, ''),
(7, 'Flash Files', 3, 0, 1, '', 262144, ''),
(8, 'Torrent', 0, 1, 1, '', 122880, '');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_flags`
--

CREATE TABLE IF NOT EXISTS `phpbb_flags` (
  `flag_id` int(10) NOT NULL AUTO_INCREMENT,
  `flag_name` varchar(25) DEFAULT '',
  `flag_image` varchar(25) DEFAULT '',
  PRIMARY KEY (`flag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=193 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_flags`
--

INSERT INTO `phpbb_flags` (`flag_id`, `flag_name`, `flag_image`) VALUES
(1, 'usa', 'usa.gif'),
(2, 'afghanistan', 'afghanistan.gif'),
(3, 'albania', 'albania.gif'),
(4, 'algeria', 'algeria.gif'),
(5, 'andorra', 'andorra.gif'),
(6, 'angola', 'angola.gif'),
(7, 'antigua and barbuda', 'antiguabarbuda.gif'),
(8, 'argentina', 'argentina.gif'),
(9, 'armenia', 'armenia.gif'),
(10, 'australia', 'australia.gif'),
(11, 'austria', 'austria.gif'),
(12, 'azerbaijan', 'azerbaijan.gif'),
(13, 'bahamas', 'bahamas.gif'),
(14, 'bahrain', 'bahrain.gif'),
(15, 'bangladesh', 'bangladesh.gif'),
(16, 'barbados', 'barbados.gif'),
(17, 'belarus', 'belarus.gif'),
(18, 'belgium', 'belgium.gif'),
(19, 'belize', 'belize.gif'),
(20, 'benin', 'benin.gif'),
(21, 'bhutan', 'bhutan.gif'),
(22, 'bolivia', 'bolivia.gif'),
(23, 'bosnia herzegovina', 'bosnia_herzegovina.gif'),
(24, 'botswana', 'botswana.gif'),
(25, 'brazil', 'brazil.gif'),
(26, 'brunei', 'brunei.gif'),
(27, 'bulgaria', 'bulgaria.gif'),
(28, 'burkinafaso', 'burkinafaso.gif'),
(29, 'burma', 'burma.gif'),
(30, 'burundi', 'burundi.gif'),
(31, 'cambodia', 'cambodia.gif'),
(32, 'cameroon', 'cameroon.gif'),
(33, 'canada', 'canada.gif'),
(34, 'central african rep', 'centralafricanrep.gif'),
(35, 'chad', 'chad.gif'),
(36, 'chile', 'chile.gif'),
(37, 'china', 'china.gif'),
(38, 'columbia', 'columbia.gif'),
(39, 'comoros', 'comoros.gif'),
(40, 'congo', 'congo.gif'),
(41, 'costarica', 'costarica.gif'),
(42, 'croatia', 'croatia.gif'),
(43, 'cuba', 'cuba.gif'),
(44, 'cyprus', 'cyprus.gif'),
(45, 'czech republic', 'czechrepublic.gif'),
(46, 'demrepcongo', 'demrepcongo.gif'),
(47, 'denmark', 'denmark.gif'),
(48, 'djibouti', 'djibouti.gif'),
(49, 'dominica', 'dominica.gif'),
(50, 'dominican rep', 'dominicanrep.gif'),
(51, 'ecuador', 'ecuador.gif'),
(52, 'egypt', 'egypt.gif'),
(53, 'elsalvador', 'elsalvador.gif'),
(54, 'eq guinea', 'eq_guinea.gif'),
(55, 'eritrea', 'eritrea.gif'),
(56, 'estonia', 'estonia.gif'),
(57, 'ethiopia', 'ethiopia.gif'),
(58, 'fiji', 'fiji.gif'),
(59, 'finland', 'finland.gif'),
(60, 'france', 'france.gif'),
(61, 'gabon', 'gabon.gif'),
(62, 'gambia', 'gambia.gif'),
(63, 'georgia', 'georgia.gif'),
(64, 'germany', 'germany.gif'),
(65, 'ghana', 'ghana.gif'),
(66, 'greece', 'greece.gif'),
(67, 'grenada', 'grenada.gif'),
(68, 'grenadines', 'grenadines.gif'),
(69, 'guatemala', 'guatemala.gif'),
(70, 'guinea', 'guinea.gif'),
(71, 'guineabissau', 'guineabissau.gif'),
(72, 'guyana', 'guyana.gif'),
(73, 'haiti', 'haiti.gif'),
(74, 'honduras', 'honduras.gif'),
(75, 'hong kong', 'hong_kong.gif'),
(76, 'hungary', 'hungary.gif'),
(77, 'iceland', 'iceland.gif'),
(78, 'india', 'india.gif'),
(79, 'indonesia', 'indonesia.gif'),
(80, 'iran', 'iran.gif'),
(81, 'iraq', 'iraq.gif'),
(82, 'ireland', 'ireland.gif'),
(83, 'israel', 'israel.gif'),
(84, 'italy', 'italy.gif'),
(85, 'ivory coast', 'ivorycoast.gif'),
(86, 'jamaica', 'jamaica.gif'),
(87, 'japan', 'japan.gif'),
(88, 'jordan', 'jordan.gif'),
(89, 'kazakhstan', 'kazakhstan.gif'),
(90, 'kenya', 'kenya.gif'),
(91, 'kiribati', 'kiribati.gif'),
(92, 'kuwait', 'kuwait.gif'),
(93, 'kyrgyzstan', 'kyrgyzstan.gif'),
(94, 'laos', 'laos.gif'),
(95, 'latvia', 'latvia.gif'),
(96, 'lebanon', 'lebanon.gif'),
(97, 'liberia', 'liberia.gif'),
(98, 'libya', 'libya.gif'),
(99, 'liechtenstein', 'liechtenstein.gif'),
(100, 'lithuania', 'lithuania.gif'),
(101, 'luxembourg', 'luxembourg.gif'),
(102, 'macadonia', 'macadonia.gif'),
(103, 'macau', 'macau.gif'),
(104, 'madagascar', 'madagascar.gif'),
(105, 'malawi', 'malawi.gif'),
(106, 'malaysia', 'malaysia.gif'),
(107, 'maldives', 'maldives.gif'),
(108, 'mali', 'mali.gif'),
(109, 'malta', 'malta.gif'),
(110, 'mauritania', 'mauritania.gif'),
(111, 'mauritius', 'mauritius.gif'),
(112, 'mexico', 'mexico.gif'),
(113, 'micronesia', 'micronesia.gif'),
(114, 'moldova', 'moldova.gif'),
(115, 'monaco', 'monaco.gif'),
(116, 'mongolia', 'mongolia.gif'),
(117, 'morocco', 'morocco.gif'),
(118, 'mozambique', 'mozambique.gif'),
(119, 'namibia', 'namibia.gif'),
(120, 'nauru', 'nauru.gif'),
(121, 'nepal', 'nepal.gif'),
(122, 'neth antilles', 'neth_antilles.gif'),
(123, 'netherlands', 'netherlands.gif'),
(124, 'new zealand', 'newzealand.gif'),
(125, 'nicaragua', 'nicaragua.gif'),
(126, 'niger', 'niger.gif'),
(127, 'nigeria', 'nigeria.gif'),
(128, 'north korea', 'north_korea.gif'),
(129, 'norway', 'norway.gif'),
(130, 'oman', 'oman.gif'),
(131, 'pakistan', 'pakistan.gif'),
(132, 'panama', 'panama.gif'),
(133, 'papua newguinea', 'papuanewguinea.gif'),
(134, 'paraguay', 'paraguay.gif'),
(135, 'peru', 'peru.gif'),
(136, 'philippines', 'philippines.gif'),
(137, 'poland', 'poland.gif'),
(138, 'portugal', 'portugal.gif'),
(139, 'puertorico', 'puertorico.gif'),
(140, 'qatar', 'qatar.gif'),
(141, 'rawanda', 'rawanda.gif'),
(142, 'romania', 'romania.gif'),
(143, 'russia', 'russia.gif'),
(144, 'sao tome', 'sao_tome.gif'),
(145, 'saudiarabia', 'saudiarabia.gif'),
(146, 'senegal', 'senegal.gif'),
(147, 'serbia', 'serbia.gif'),
(148, 'seychelles', 'seychelles.gif'),
(149, 'sierraleone', 'sierraleone.gif'),
(150, 'singapore', 'singapore.gif'),
(151, 'slovakia', 'slovakia.gif'),
(152, 'slovenia', 'slovenia.gif'),
(153, 'solomon islands', 'solomon_islands.gif'),
(154, 'somalia', 'somalia.gif'),
(155, 'south_korea', 'south_korea.gif'),
(156, 'south africa', 'southafrica.gif'),
(157, 'spain', 'spain.gif'),
(158, 'srilanka', 'srilanka.gif'),
(159, 'stkitts nevis', 'stkitts_nevis.gif'),
(160, 'stlucia', 'stlucia.gif'),
(161, 'sudan', 'sudan.gif'),
(162, 'suriname', 'suriname.gif'),
(163, 'sweden', 'sweden.gif'),
(164, 'switzerland', 'switzerland.gif'),
(165, 'syria', 'syria.gif'),
(166, 'taiwan', 'taiwan.gif'),
(167, 'tajikistan', 'tajikistan.gif'),
(168, 'tanzania', 'tanzania.gif'),
(169, 'thailand', 'thailand.gif'),
(170, 'togo', 'togo.gif'),
(171, 'tonga', 'tonga.gif'),
(172, 'trinidad and tobago', 'trinidadandtobago.gif'),
(173, 'tunisia', 'tunisia.gif'),
(174, 'turkey', 'turkey.gif'),
(175, 'turkmenistan', 'turkmenistan.gif'),
(176, 'tuvala', 'tuvala.gif'),
(177, 'uae', 'uae.gif'),
(178, 'uganda', 'uganda.gif'),
(179, 'uk', 'uk.gif'),
(180, 'ukraine', 'ukraine.gif'),
(181, 'uruguay', 'uruguay.gif'),
(182, 'ussr', 'ussr.gif'),
(183, 'uzbekistan', 'uzbekistan.gif'),
(184, 'vanuatu', 'vanuatu.gif'),
(185, 'venezuela', 'venezuela.gif'),
(186, 'vietnam', 'vietnam.gif'),
(187, 'western samoa', 'western_samoa.gif'),
(188, 'yemen', 'yemen.gif'),
(189, 'yugoslavia', 'yugoslavia.gif'),
(190, 'zaire', 'zaire.gif'),
(191, 'zambia', 'zambia.gif'),
(192, 'zimbabwe', 'zimbabwe.gif');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_forbidden_extensions`
--

CREATE TABLE IF NOT EXISTS `phpbb_forbidden_extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `extension` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ext_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_forbidden_extensions`
--

INSERT INTO `phpbb_forbidden_extensions` (`ext_id`, `extension`) VALUES
(1, 'php'),
(2, 'php3'),
(3, 'php4'),
(4, 'phtml'),
(5, 'pl'),
(6, 'asp'),
(7, 'cgi');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_forums`
--

CREATE TABLE IF NOT EXISTS `phpbb_forums` (
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_name` varchar(150) DEFAULT NULL,
  `forum_desc` text,
  `forum_status` tinyint(4) NOT NULL DEFAULT '0',
  `forum_order` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `forum_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `prune_next` int(11) DEFAULT NULL,
  `prune_enable` tinyint(1) NOT NULL DEFAULT '0',
  `auth_view` tinyint(2) NOT NULL DEFAULT '0',
  `auth_read` tinyint(2) NOT NULL DEFAULT '0',
  `auth_post` tinyint(2) NOT NULL DEFAULT '0',
  `auth_reply` tinyint(2) NOT NULL DEFAULT '0',
  `auth_edit` tinyint(2) NOT NULL DEFAULT '0',
  `auth_delete` tinyint(2) NOT NULL DEFAULT '0',
  `auth_sticky` tinyint(2) NOT NULL DEFAULT '0',
  `auth_announce` tinyint(2) NOT NULL DEFAULT '0',
  `auth_vote` tinyint(2) NOT NULL DEFAULT '0',
  `auth_pollcreate` tinyint(2) NOT NULL DEFAULT '0',
  `auth_attachments` tinyint(2) NOT NULL DEFAULT '0',
  `auth_download` tinyint(2) NOT NULL DEFAULT '0',
  `allow_reg_tracker` tinyint(1) NOT NULL DEFAULT '0',
  `allow_dl_topic` tinyint(1) NOT NULL DEFAULT '0',
  `dl_type_default` tinyint(1) NOT NULL DEFAULT '0',
  `self_moderated` tinyint(1) NOT NULL DEFAULT '0',
  `last_dl_topics_synch` int(11) NOT NULL DEFAULT '0',
  `show_dl_buttons` tinyint(1) NOT NULL DEFAULT '0',
  `forum_parent` mediumint(9) NOT NULL DEFAULT '0',
  `show_on_index` tinyint(1) NOT NULL DEFAULT '1',
  `forum_display_sort` tinyint(1) NOT NULL DEFAULT '0',
  `forum_display_order` tinyint(1) NOT NULL DEFAULT '0',
  `move_next` int(11) unsigned NOT NULL DEFAULT '0',
  `recycle_move_next` int(11) unsigned NOT NULL DEFAULT '0',
  `move_enable` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_forums`
--

INSERT INTO `phpbb_forums` (`forum_id`, `cat_id`, `forum_name`, `forum_desc`, `forum_status`, `forum_order`, `forum_posts`, `forum_topics`, `forum_last_post_id`, `prune_next`, `prune_enable`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_delete`, `auth_sticky`, `auth_announce`, `auth_vote`, `auth_pollcreate`, `auth_attachments`, `auth_download`, `allow_reg_tracker`, `allow_dl_topic`, `dl_type_default`, `self_moderated`, `last_dl_topics_synch`, `show_dl_buttons`, `forum_parent`, `show_on_index`, `forum_display_sort`, `forum_display_order`, `move_next`, `recycle_move_next`, `move_enable`) VALUES
(1, 1, 'Test Forum 1', 'This is just a test forum.', 0, 10, 1, 1, 1, NULL, 0, 0, 0, 0, 0, 1, 1, 3, 3, 1, 1, 3, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0),
(2, 1, 'subforum 1', 'subforum 1 description', 0, 20, 2, 1, 3, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 1, 1, 0, 1, 0, 1, 1117359869, 1, 1, 1, 0, 0, 0, 0, 0),
(3, 1, 'Download Forum 1', '', 0, 30, 1, 1, 4, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_forum_prune`
--

CREATE TABLE IF NOT EXISTS `phpbb_forum_prune` (
  `prune_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prune_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_groups`
--

CREATE TABLE IF NOT EXISTS `phpbb_groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_type` tinyint(4) NOT NULL DEFAULT '1',
  `group_name` varchar(40) NOT NULL DEFAULT '',
  `group_description` varchar(255) NOT NULL DEFAULT '',
  `group_moderator` mediumint(8) NOT NULL DEFAULT '0',
  `group_single_user` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`),
  KEY `group_single_user` (`group_single_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_groups`
--

INSERT INTO `phpbb_groups` (`group_id`, `group_type`, `group_name`, `group_description`, `group_moderator`, `group_single_user`) VALUES
(1, 1, 'Anonymous', '', 0, 1),
(2, 1, 'Admin', '', 0, 1),
(3, 1, '', '', 0, 1),
(4, 1, '', '', 0, 1),
(5, 1, '', '', 0, 1);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_posts`
--

CREATE TABLE IF NOT EXISTS `phpbb_posts` (
  `post_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `poster_id` mediumint(8) NOT NULL DEFAULT '0',
  `post_time` int(11) NOT NULL DEFAULT '0',
  `poster_ip` varchar(8) NOT NULL DEFAULT '',
  `post_username` varchar(25) DEFAULT NULL,
  `enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `enable_sig` tinyint(1) NOT NULL DEFAULT '1',
  `post_edit_time` int(11) DEFAULT NULL,
  `post_edit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `post_attachment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_posts`
--

INSERT INTO `phpbb_posts` (`post_id`, `topic_id`, `forum_id`, `poster_id`, `post_time`, `poster_ip`, `post_username`, `enable_bbcode`, `enable_html`, `enable_smilies`, `enable_sig`, `post_edit_time`, `post_edit_count`, `post_attachment`) VALUES
(1, 1, 1, 2, 972086460, '7F000001', NULL, 1, 0, 1, 1, NULL, 0, 0),
(2, 2, 2, 2, 1117115113, '7f000001', '', 1, 0, 1, 0, NULL, 0, 0),
(3, 2, 2, -746, 1117115440, '7f000001', '', 0, 1, 0, 1, NULL, 0, 0),
(4, 3, 3, 4, 1117362875, '7f000001', '', 1, 0, 1, 0, NULL, 0, 1);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_posts_text`
--

CREATE TABLE IF NOT EXISTS `phpbb_posts_text` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` varchar(10) NOT NULL DEFAULT '',
  `post_subject` varchar(120) DEFAULT NULL,
  `post_text` text,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_posts_text`
--

INSERT INTO `phpbb_posts_text` (`post_id`, `bbcode_uid`, `post_subject`, `post_text`) VALUES
(1, '', NULL, 'This is an example post in your phpBB 2 installation. You may delete this post, this topic and even this forum if you like since everything seems to be working!'),
(2, '48df346ad5', 'Bot test 1', 'test'),
(3, '', '', 'Topic has been moved from forum <b><a class="postLink" href="viewforum.php?f=1">Test Forum 1</a></b> to forum <b><a class="postLink" href="viewforum.php?f=2">subforum 1</a></b></b>.\n\nAdmin.'),
(4, '833b835389', 'Download Topic 1', 'test');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_privmsgs`
--

CREATE TABLE IF NOT EXISTS `phpbb_privmsgs` (
  `privmsgs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `privmsgs_type` tinyint(4) NOT NULL DEFAULT '0',
  `privmsgs_subject` varchar(255) NOT NULL DEFAULT '0',
  `privmsgs_from_userid` mediumint(8) NOT NULL DEFAULT '0',
  `privmsgs_to_userid` mediumint(8) NOT NULL DEFAULT '0',
  `privmsgs_date` int(11) NOT NULL DEFAULT '0',
  `privmsgs_ip` varchar(8) NOT NULL DEFAULT '',
  `privmsgs_enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `privmsgs_enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attach_sig` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attachment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privmsgs_id`),
  KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  KEY `privmsgs_to_userid` (`privmsgs_to_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_privmsgs_text`
--

CREATE TABLE IF NOT EXISTS `phpbb_privmsgs_text` (
  `privmsgs_text_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_bbcode_uid` varchar(10) NOT NULL DEFAULT '0',
  `privmsgs_text` text,
  PRIMARY KEY (`privmsgs_text_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_quota_limits`
--

CREATE TABLE IF NOT EXISTS `phpbb_quota_limits` (
  `quota_limit_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `quota_desc` varchar(20) NOT NULL DEFAULT '',
  `quota_limit` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`quota_limit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_quota_limits`
--

INSERT INTO `phpbb_quota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES
(1, 'Low', 262144),
(2, 'Medium', 10485760),
(3, 'High', 15728640);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_ranks`
--

CREATE TABLE IF NOT EXISTS `phpbb_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(50) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) DEFAULT '0',
  `rank_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_ranks`
--

INSERT INTO `phpbb_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES
(1, 'Site Admin', -1, 1, NULL);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_search_results`
--

CREATE TABLE IF NOT EXISTS `phpbb_search_results` (
  `search_id` int(11) unsigned NOT NULL DEFAULT '0',
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `search_array` text NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_search_wordlist`
--

CREATE TABLE IF NOT EXISTS `phpbb_search_wordlist` (
  `word_text` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word_common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`word_text`),
  KEY `word_id` (`word_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_search_wordmatch`
--

CREATE TABLE IF NOT EXISTS `phpbb_search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title_match` tinyint(1) NOT NULL DEFAULT '0',
  KEY `post_id` (`post_id`),
  KEY `word_id` (`word_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_sessions`
--

CREATE TABLE IF NOT EXISTS `phpbb_sessions` (
  `session_id` char(32) NOT NULL DEFAULT '',
  `session_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `session_start` int(11) NOT NULL DEFAULT '0',
  `session_time` int(11) NOT NULL DEFAULT '0',
  `session_ip` char(8) NOT NULL DEFAULT '0',
  `session_page` int(11) NOT NULL DEFAULT '0',
  `session_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `session_admin` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_sessions`
--

INSERT INTO `phpbb_sessions` (`session_id`, `session_user_id`, `session_start`, `session_time`, `session_ip`, `session_page`, `session_logged_in`, `session_admin`) VALUES
('7a32ebd46bc05c394fdfdad51eaa606e', 2, 1455567848, 1455568328, '7f000001', 0, 1, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_smilies`
--

CREATE TABLE IF NOT EXISTS `phpbb_smilies` (
  `smilies_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `smile_url` varchar(100) DEFAULT NULL,
  `emoticon` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`smilies_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_smilies`
--

INSERT INTO `phpbb_smilies` (`smilies_id`, `code`, `smile_url`, `emoticon`) VALUES
(1, 'O:-)', 'aa.gif', ''),
(2, '=)', 'ab.gif', ''),
(3, ':(', 'ac.gif', ''),
(4, ';-)', 'ad.gif', ''),
(5, ':-P', 'ae.gif', ''),
(6, '8-)', 'af.gif', ''),
(7, ':-D', 'ag.gif', ''),
(8, ':-[', 'ah.gif', ''),
(9, '=-O', 'ai.gif', ''),
(10, ':-*', 'aj.gif', ''),
(11, ':''(', 'ak.gif', ''),
(12, ':-X', 'al.gif', ''),
(13, '&gt;:o', 'am.gif', ''),
(14, ':-|', 'an.gif', ''),
(15, ':-\\', 'ao.gif', ''),
(16, '*JOKINGLY*', 'ap.gif', ''),
(17, ']:-&gt;', 'aq.gif', ''),
(18, '[:-}', 'ar.gif', ''),
(19, '*KISSED*', 'as.gif', ''),
(20, ':-!', 'at.gif', ''),
(21, '*TIRED*', 'au.gif', ''),
(22, '*STOP*', 'av.gif', ''),
(23, '*KISSING*', 'aw.gif', ''),
(24, '@}-&gt;--', 'ax.gif', ''),
(25, '*THUMBS UP*', 'ay.gif', ''),
(26, '*DRINK*', 'az.gif', ''),
(27, '*IN LOVE*', 'ba.gif', ''),
(28, '@=', 'bb.gif', ''),
(29, '*HELP*', 'bc.gif', ''),
(30, '\\m/', 'bd.gif', ''),
(31, '%)', 'be.gif', ''),
(32, '*OK*', 'bf.gif', ''),
(33, '*WASSUP*', 'bg.gif', ''),
(34, '*SORRY*', 'bh.gif', ''),
(35, '*BRAVO*', 'bi.gif', ''),
(36, '*ROFL*', 'bj.gif', ''),
(37, '*PARDON*', 'bk.gif', ''),
(38, '*NO*', 'bl.gif', ''),
(39, '*CRAZY*', 'bm.gif', ''),
(40, '*DONT_KNOW*', 'bn.gif', ''),
(41, '*DANCE*', 'bo.gif', ''),
(42, '*YAHOO*', 'bp.gif', ''),
(43, '*HI*', 'bq.gif', ''),
(44, '*BYE*', 'br.gif', ''),
(45, '*YES*', 'bs.gif', ''),
(46, ';D', 'bt.gif', ''),
(47, '*WALL*', 'bu.gif', ''),
(48, '*WRITE*', 'bv.gif', ''),
(49, '*SCRATCH*', 'bw.gif', '');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_themes`
--

CREATE TABLE IF NOT EXISTS `phpbb_themes` (
  `themes_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(30) NOT NULL DEFAULT '',
  `style_name` varchar(30) NOT NULL DEFAULT '',
  `head_stylesheet` varchar(100) DEFAULT NULL,
  `body_background` varchar(100) DEFAULT NULL,
  `body_bgcolor` varchar(6) DEFAULT NULL,
  `body_text` varchar(6) DEFAULT NULL,
  `body_link` varchar(6) DEFAULT NULL,
  `body_vlink` varchar(6) DEFAULT NULL,
  `body_alink` varchar(6) DEFAULT NULL,
  `body_hlink` varchar(6) DEFAULT NULL,
  `tr_color1` varchar(6) DEFAULT NULL,
  `tr_color2` varchar(6) DEFAULT NULL,
  `tr_color3` varchar(6) DEFAULT NULL,
  `tr_class1` varchar(25) DEFAULT NULL,
  `tr_class2` varchar(25) DEFAULT NULL,
  `tr_class3` varchar(25) DEFAULT NULL,
  `th_color1` varchar(6) DEFAULT NULL,
  `th_color2` varchar(6) DEFAULT NULL,
  `th_color3` varchar(6) DEFAULT NULL,
  `th_class1` varchar(25) DEFAULT NULL,
  `th_class2` varchar(25) DEFAULT NULL,
  `th_class3` varchar(25) DEFAULT NULL,
  `td_color1` varchar(6) DEFAULT NULL,
  `td_color2` varchar(6) DEFAULT NULL,
  `td_color3` varchar(6) DEFAULT NULL,
  `td_class1` varchar(25) DEFAULT NULL,
  `td_class2` varchar(25) DEFAULT NULL,
  `td_class3` varchar(25) DEFAULT NULL,
  `fontface1` varchar(50) DEFAULT NULL,
  `fontface2` varchar(50) DEFAULT NULL,
  `fontface3` varchar(50) DEFAULT NULL,
  `fontsize1` tinyint(4) DEFAULT NULL,
  `fontsize2` tinyint(4) DEFAULT NULL,
  `fontsize3` tinyint(4) DEFAULT NULL,
  `fontcolor1` varchar(6) DEFAULT NULL,
  `fontcolor2` varchar(6) DEFAULT NULL,
  `fontcolor3` varchar(6) DEFAULT NULL,
  `span_class1` varchar(25) DEFAULT NULL,
  `span_class2` varchar(25) DEFAULT NULL,
  `span_class3` varchar(25) DEFAULT NULL,
  `img_size_poll` smallint(5) unsigned DEFAULT NULL,
  `img_size_privmsg` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_themes`
--

INSERT INTO `phpbb_themes` (`themes_id`, `template_name`, `style_name`, `head_stylesheet`, `body_background`, `body_bgcolor`, `body_text`, `body_link`, `body_vlink`, `body_alink`, `body_hlink`, `tr_color1`, `tr_color2`, `tr_color3`, `tr_class1`, `tr_class2`, `tr_class3`, `th_color1`, `th_color2`, `th_color3`, `th_class1`, `th_class2`, `th_class3`, `td_color1`, `td_color2`, `td_color3`, `td_class1`, `td_class2`, `td_class3`, `fontface1`, `fontface2`, `fontface3`, `fontsize1`, `fontsize2`, `fontsize3`, `fontcolor1`, `fontcolor2`, `fontcolor3`, `span_class1`, `span_class2`, `span_class3`, `img_size_poll`, `img_size_privmsg`) VALUES
(1, 'subSilver', 'subSilver', 'subSilver.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, ''Courier New'', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_themes_name`
--

CREATE TABLE IF NOT EXISTS `phpbb_themes_name` (
  `themes_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tr_color1_name` char(50) DEFAULT NULL,
  `tr_color2_name` char(50) DEFAULT NULL,
  `tr_color3_name` char(50) DEFAULT NULL,
  `tr_class1_name` char(50) DEFAULT NULL,
  `tr_class2_name` char(50) DEFAULT NULL,
  `tr_class3_name` char(50) DEFAULT NULL,
  `th_color1_name` char(50) DEFAULT NULL,
  `th_color2_name` char(50) DEFAULT NULL,
  `th_color3_name` char(50) DEFAULT NULL,
  `th_class1_name` char(50) DEFAULT NULL,
  `th_class2_name` char(50) DEFAULT NULL,
  `th_class3_name` char(50) DEFAULT NULL,
  `td_color1_name` char(50) DEFAULT NULL,
  `td_color2_name` char(50) DEFAULT NULL,
  `td_color3_name` char(50) DEFAULT NULL,
  `td_class1_name` char(50) DEFAULT NULL,
  `td_class2_name` char(50) DEFAULT NULL,
  `td_class3_name` char(50) DEFAULT NULL,
  `fontface1_name` char(50) DEFAULT NULL,
  `fontface2_name` char(50) DEFAULT NULL,
  `fontface3_name` char(50) DEFAULT NULL,
  `fontsize1_name` char(50) DEFAULT NULL,
  `fontsize2_name` char(50) DEFAULT NULL,
  `fontsize3_name` char(50) DEFAULT NULL,
  `fontcolor1_name` char(50) DEFAULT NULL,
  `fontcolor2_name` char(50) DEFAULT NULL,
  `fontcolor3_name` char(50) DEFAULT NULL,
  `span_class1_name` char(50) DEFAULT NULL,
  `span_class2_name` char(50) DEFAULT NULL,
  `span_class3_name` char(50) DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_themes_name`
--

INSERT INTO `phpbb_themes_name` (`themes_id`, `tr_color1_name`, `tr_color2_name`, `tr_color3_name`, `tr_class1_name`, `tr_class2_name`, `tr_class3_name`, `th_color1_name`, `th_color2_name`, `th_color3_name`, `th_class1_name`, `th_class2_name`, `th_class3_name`, `td_color1_name`, `td_color2_name`, `td_color3_name`, `td_class1_name`, `td_class2_name`, `td_class3_name`, `fontface1_name`, `fontface2_name`, `fontface3_name`, `fontsize1_name`, `fontsize2_name`, `fontsize3_name`, `fontcolor1_name`, `fontcolor2_name`, `fontcolor3_name`, `span_class1_name`, `span_class2_name`, `span_class3_name`) VALUES
(1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_topics`
--

CREATE TABLE IF NOT EXISTS `phpbb_topics` (
  `topic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(8) unsigned NOT NULL DEFAULT '0',
  `topic_title` char(120) NOT NULL DEFAULT '',
  `topic_poster` mediumint(8) NOT NULL DEFAULT '0',
  `topic_time` int(11) NOT NULL DEFAULT '0',
  `topic_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_status` tinyint(3) NOT NULL DEFAULT '0',
  `topic_vote` tinyint(1) NOT NULL DEFAULT '0',
  `topic_type` tinyint(3) NOT NULL DEFAULT '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `topic_dl_type` tinyint(1) NOT NULL DEFAULT '0',
  `topic_dl_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`),
  FULLTEXT KEY `topic_title` (`topic_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_topics`
--

INSERT INTO `phpbb_topics` (`topic_id`, `forum_id`, `topic_title`, `topic_poster`, `topic_time`, `topic_views`, `topic_replies`, `topic_status`, `topic_vote`, `topic_type`, `topic_first_post_id`, `topic_last_post_id`, `topic_moved_id`, `topic_attachment`, `topic_dl_type`, `topic_dl_status`) VALUES
(1, 1, 'Welcome to phpBB 2', 2, 972086460, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0),
(2, 2, 'Bot test 1', 2, 1117115113, 12, 1, 0, 0, 0, 2, 3, 0, 0, 0, 0),
(3, 3, 'Download Topic 1', 4, 1117362875, 22, 0, 0, 0, 0, 4, 4, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_topics_move`
--

CREATE TABLE IF NOT EXISTS `phpbb_topics_move` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `waits_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `check_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  `move_fid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_waits_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_check_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_move_fid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_topics_watch`
--

CREATE TABLE IF NOT EXISTS `phpbb_topics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_status` (`notify_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_users`
--

CREATE TABLE IF NOT EXISTS `phpbb_users` (
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_active` tinyint(1) DEFAULT '1',
  `username` varchar(25) NOT NULL DEFAULT '',
  `user_password` varchar(32) NOT NULL DEFAULT '',
  `user_session_time` int(11) NOT NULL DEFAULT '0',
  `user_session_page` smallint(5) NOT NULL DEFAULT '0',
  `user_lastvisit` int(11) NOT NULL DEFAULT '0',
  `user_regdate` int(11) NOT NULL DEFAULT '0',
  `user_level` tinyint(4) DEFAULT '0',
  `user_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_timezone` decimal(5,2) NOT NULL DEFAULT '0.00',
  `user_style` tinyint(4) DEFAULT NULL,
  `user_lang` varchar(255) DEFAULT NULL,
  `user_dateformat` varchar(14) NOT NULL DEFAULT 'd M Y H:i',
  `user_new_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_last_privmsg` int(11) NOT NULL DEFAULT '0',
  `user_emailtime` int(11) DEFAULT NULL,
  `user_viewemail` tinyint(1) DEFAULT NULL,
  `user_attachsig` tinyint(1) DEFAULT NULL,
  `user_allowhtml` tinyint(1) DEFAULT '1',
  `user_allowbbcode` tinyint(1) DEFAULT '1',
  `user_allowsmile` tinyint(1) DEFAULT '1',
  `user_allowavatar` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_viewonline` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_popup_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_rank` int(11) DEFAULT '0',
  `user_avatar` varchar(100) DEFAULT NULL,
  `user_avatar_type` tinyint(4) NOT NULL DEFAULT '0',
  `user_email` varchar(255) DEFAULT NULL,
  `user_icq` varchar(15) DEFAULT NULL,
  `user_website` varchar(100) DEFAULT NULL,
  `user_from` varchar(100) DEFAULT NULL,
  `user_sig` text,
  `user_sig_bbcode_uid` varchar(10) DEFAULT NULL,
  `user_aim` varchar(255) DEFAULT NULL,
  `user_yim` varchar(255) DEFAULT NULL,
  `user_msnm` varchar(255) DEFAULT NULL,
  `user_occ` varchar(100) DEFAULT NULL,
  `user_interests` varchar(255) DEFAULT NULL,
  `user_actkey` varchar(32) DEFAULT NULL,
  `user_newpasswd` varchar(32) DEFAULT NULL,
  `user_allow_passkey` tinyint(1) NOT NULL DEFAULT '1',
  `bt_tor_browse_set` text,
  `user_from_flag` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_users`
--

INSERT INTO `phpbb_users` (`user_id`, `user_active`, `username`, `user_password`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_regdate`, `user_level`, `user_posts`, `user_timezone`, `user_style`, `user_lang`, `user_dateformat`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_viewemail`, `user_attachsig`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_rank`, `user_avatar`, `user_avatar_type`, `user_email`, `user_icq`, `user_website`, `user_from`, `user_sig`, `user_sig_bbcode_uid`, `user_aim`, `user_yim`, `user_msnm`, `user_occ`, `user_interests`, `user_actkey`, `user_newpasswd`, `user_allow_passkey`, `bt_tor_browse_set`, `user_from_flag`) VALUES
(-1, 0, 'Anonymous', '', 0, 0, 0, 1455565573, 0, 0, '0.00', NULL, '', '', 0, 0, 0, NULL, 0, 0, 1, 1, 1, 1, 0, 1, 0, 1, 0, NULL, '', 0, '', '', '', '', '', NULL, '', '', '', '', '', '', '', 1, '', NULL),
(2, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1455568328, 0, 1117435921, 1455565573, 1, 2, '0.00', 1, 'russian', 'Y-m-d H:i', 0, 0, 1455567848, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1, '', 0, 'admin@admin.com', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'a:15:{s:3:"sid";s:32:"7a32ebd46bc05c394fdfdad51eaa606e";s:1:"n";i:0;s:2:"sd";i:0;s:1:"a";i:1;s:2:"my";i:0;s:1:"f";i:-1;s:3:"pid";i:0;s:2:"pn";s:0:"";s:3:"sns";i:-1;s:1:"o";i:1;s:1:"s";i:2;s:2:"tm";i:30;s:3:"shf";i:1;s:3:"sha";i:1;s:3:"shs";i:0;}', 'blank.gif'),
(-746, 0, 'bot', '', 1117115716, 2, 1117115634, 1455565573, 0, 1, '0.00', 1, 'english', 'Y-m-d H:i', 0, 0, 0, NULL, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 'bot.gif', 1, 'bot@bot.bot', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '', 'blank.gif'),
(4, 1, 'user1', 'c4ca4238a0b923820dcc509a6f75849b', 1117378293, -1, 1117362875, 1455565573, 0, 1, '0.00', 1, 'english', 'Y-m-d H:i', 0, 0, 0, NULL, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, '', 0, '1@11.com', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '', 'blank.gif'),
(5, 1, 'user2', 'c4ca4238a0b923820dcc509a6f75849b', 1117378592, 3, 1117378303, 1455565573, 0, 0, '0.00', 1, 'english', 'Y-m-d H:i', 0, 0, 0, NULL, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, '', 0, '2@2.com', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '', 'blank.gif');

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_user_group`
--

CREATE TABLE IF NOT EXISTS `phpbb_user_group` (
  `group_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_pending` tinyint(1) DEFAULT NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Р”Р°РјРї РґР°РЅРЅС‹С… С‚Р°Р±Р»РёС†С‹ `phpbb_user_group`
--

INSERT INTO `phpbb_user_group` (`group_id`, `user_id`, `user_pending`) VALUES
(1, -1, 0),
(2, 2, 0),
(3, -746, 0),
(4, 4, 0),
(5, 5, 0);

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_vote_desc`
--

CREATE TABLE IF NOT EXISTS `phpbb_vote_desc` (
  `vote_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_text` text NOT NULL,
  `vote_start` int(11) NOT NULL DEFAULT '0',
  `vote_length` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vote_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_vote_results`
--

CREATE TABLE IF NOT EXISTS `phpbb_vote_results` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_option_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `vote_option_text` varchar(255) NOT NULL DEFAULT '',
  `vote_result` int(11) NOT NULL DEFAULT '0',
  KEY `vote_option_id` (`vote_option_id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_vote_voters`
--

CREATE TABLE IF NOT EXISTS `phpbb_vote_voters` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `vote_user_ip` char(8) NOT NULL DEFAULT '',
  KEY `vote_id` (`vote_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- РЎС‚СЂСѓРєС‚СѓСЂР° С‚Р°Р±Р»РёС†С‹ `phpbb_words`
--

CREATE TABLE IF NOT EXISTS `phpbb_words` (
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word` char(100) NOT NULL DEFAULT '',
  `replacement` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`word_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
