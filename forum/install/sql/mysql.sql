SET SQL_MODE = "";

-- --------------------------------------------------------

--
-- Структура таблицы `ft_attachments`
--

CREATE TABLE IF NOT EXISTS `ft_attachments` (
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id_1` mediumint(8) NOT NULL DEFAULT '0',
  `user_id_2` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_attachments`
--

INSERT INTO `ft_attachments` (`attach_id`, `post_id`, `privmsgs_id`, `user_id_1`, `user_id_2`) VALUES
(1, 4, 0, 4, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_attachments_config`
--

CREATE TABLE IF NOT EXISTS `ft_attachments_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_attachments_config`
--

INSERT INTO `ft_attachments_config` (`config_name`, `config_value`) VALUES
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
-- Структура таблицы `ft_attachments_desc`
--

CREATE TABLE IF NOT EXISTS `ft_attachments_desc` (
  `attach_id` mediumint(8) unsigned NOT NULL,
  `physical_filename` varchar(255) NOT NULL DEFAULT '',
  `real_filename` varchar(255) NOT NULL DEFAULT '',
  `download_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `mimetype` varchar(100) DEFAULT NULL,
  `filesize` int(20) NOT NULL DEFAULT '0',
  `filetime` int(11) NOT NULL DEFAULT '0',
  `thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  `tracker_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_attachments_desc`
--

INSERT INTO `ft_attachments_desc` (`attach_id`, `physical_filename`, `real_filename`, `download_count`, `comment`, `extension`, `mimetype`, `filesize`, `filetime`, `thumbnail`, `tracker_status`) VALUES
(1, 'test_167.torrent', 'test.torrent', 8, 'File Comment', 'torrent', 'application/x-bittorrent', 251, 1117378177, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_attach_quota`
--

CREATE TABLE IF NOT EXISTS `ft_attach_quota` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `quota_type` smallint(2) NOT NULL DEFAULT '0',
  `quota_limit_id` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_auth_access`
--

CREATE TABLE IF NOT EXISTS `ft_auth_access` (
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
  `auth_download` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_banlist`
--

CREATE TABLE IF NOT EXISTS `ft_banlist` (
  `ban_id` mediumint(8) unsigned NOT NULL,
  `ban_userid` mediumint(8) NOT NULL DEFAULT '0',
  `ban_ip` varchar(8) NOT NULL DEFAULT '',
  `ban_email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_config`
--

CREATE TABLE IF NOT EXISTS `ft_bt_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_bt_config`
--

INSERT INTO `ft_bt_config` (`config_name`, `config_value`) VALUES
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
-- Структура таблицы `ft_bt_search_results`
--

CREATE TABLE IF NOT EXISTS `ft_bt_search_results` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `search_id` int(10) unsigned NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `search_array` text NOT NULL,
  `search_settings` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_torrents`
--

CREATE TABLE IF NOT EXISTS `ft_bt_torrents` (
  `torrent_id` mediumint(8) unsigned NOT NULL,
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
  `topic_check_duble_tid` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_bt_torrents`
--

INSERT INTO `ft_bt_torrents` (`torrent_id`, `info_hash`, `post_id`, `poster_id`, `topic_id`, `attach_id`, `size`, `piece_length`, `reg_time`, `complete_count`, `seeder_last_seen`, `last_seeder_uid`, `topic_check_status`, `topic_check_uid`, `topic_check_date`, `topic_check_first_fid`, `topic_check_duble_tid`) VALUES
(1, 0xf51a6d93f8d475fd7f816f463f20c5734f15a87f, 4, 4, 3, 1, 16748964, 4194304, 1117378225, 0, 0, 0, 2, 2, 1455969875, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_tor_dl_stat`
--

CREATE TABLE IF NOT EXISTS `ft_bt_tor_dl_stat` (
  `torrent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `t_up_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `t_down_total` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_tracker`
--

CREATE TABLE IF NOT EXISTS `ft_bt_tracker` (
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
  `expire_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_users`
--

CREATE TABLE IF NOT EXISTS `ft_bt_users` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `auth_key` binary(10) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0',
  `u_up_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `u_bonus_total` bigint(20) unsigned NOT NULL DEFAULT '0',
  `u_down_total` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_bt_users`
--

INSERT INTO `ft_bt_users` (`user_id`, `auth_key`, `u_up_total`, `u_bonus_total`, `u_down_total`) VALUES
(-1, 0x00000000000000000000, 0, 0, 0),
(2, 0x5531546f43774a4b426c, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_bt_users_dl_status`
--

CREATE TABLE IF NOT EXISTS `ft_bt_users_dl_status` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `compl_count` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_categories`
--

CREATE TABLE IF NOT EXISTS `ft_categories` (
  `cat_id` mediumint(8) unsigned NOT NULL,
  `cat_title` varchar(100) DEFAULT NULL,
  `cat_order` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_categories`
--

INSERT INTO `ft_categories` (`cat_id`, `cat_title`, `cat_order`) VALUES
(1, 'Test category 1', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_config`
--

CREATE TABLE IF NOT EXISTS `ft_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_config`
--

INSERT INTO `ft_config` (`config_name`, `config_value`) VALUES
('config_id', '1'),
('board_disable', '0'),
('sitename', 'yourdomain.com'),
('site_desc', 'A _little_ text to describe your forum'),
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
('xs_template_time', '1455741544'),
('xs_version', '');

-- --------------------------------------------------------

--
-- Структура таблицы `ft_disallow`
--

CREATE TABLE IF NOT EXISTS `ft_disallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL,
  `disallow_username` varchar(25) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_extensions`
--

CREATE TABLE IF NOT EXISTS `ft_extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extension` varchar(100) NOT NULL DEFAULT '',
  `comment` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_extensions`
--

INSERT INTO `ft_extensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES
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
-- Структура таблицы `ft_extension_groups`
--

CREATE TABLE IF NOT EXISTS `ft_extension_groups` (
  `group_id` mediumint(8) NOT NULL,
  `group_name` varchar(20) NOT NULL DEFAULT '',
  `cat_id` tinyint(2) NOT NULL DEFAULT '0',
  `allow_group` tinyint(1) NOT NULL DEFAULT '0',
  `download_mode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `upload_icon` varchar(100) DEFAULT '',
  `max_filesize` int(20) NOT NULL DEFAULT '0',
  `forum_permissions` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_extension_groups`
--

INSERT INTO `ft_extension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES
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
-- Структура таблицы `ft_forbidden_extensions`
--

CREATE TABLE IF NOT EXISTS `ft_forbidden_extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL,
  `extension` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_forbidden_extensions`
--

INSERT INTO `ft_forbidden_extensions` (`ext_id`, `extension`) VALUES
(1, 'php'),
(2, 'php3'),
(3, 'php4'),
(4, 'phtml'),
(5, 'pl'),
(6, 'asp'),
(7, 'cgi');

-- --------------------------------------------------------

--
-- Структура таблицы `ft_forums`
--

CREATE TABLE IF NOT EXISTS `ft_forums` (
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
  `move_enable` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_forums`
--

INSERT INTO `ft_forums` (`forum_id`, `cat_id`, `forum_name`, `forum_desc`, `forum_status`, `forum_order`, `forum_posts`, `forum_topics`, `forum_last_post_id`, `prune_next`, `prune_enable`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_delete`, `auth_sticky`, `auth_announce`, `auth_vote`, `auth_pollcreate`, `auth_attachments`, `auth_download`, `allow_reg_tracker`, `allow_dl_topic`, `dl_type_default`, `self_moderated`, `last_dl_topics_synch`, `show_dl_buttons`, `forum_parent`, `show_on_index`, `forum_display_sort`, `forum_display_order`, `move_next`, `recycle_move_next`, `move_enable`) VALUES
(1, 1, 'Test Forum 1', 'This is just a test forum.', 0, 10, 1, 1, 1, NULL, 0, 0, 0, 0, 0, 1, 1, 3, 3, 1, 1, 3, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0),
(2, 1, 'subforum 1', 'subforum 1 description', 0, 20, 0, 0, 0, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 1, 1, 0, 1, 0, 1, 1117359869, 1, 1, 1, 0, 0, 0, 0, 0),
(3, 1, 'Download Forum 1', '', 0, 30, 1, 1, 4, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_forum_prune`
--

CREATE TABLE IF NOT EXISTS `ft_forum_prune` (
  `prune_id` mediumint(8) unsigned NOT NULL,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_freq` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_groups`
--

CREATE TABLE IF NOT EXISTS `ft_groups` (
  `group_id` mediumint(8) NOT NULL,
  `group_type` tinyint(4) NOT NULL DEFAULT '1',
  `group_name` varchar(40) NOT NULL DEFAULT '',
  `group_description` varchar(255) NOT NULL DEFAULT '',
  `group_moderator` mediumint(8) NOT NULL DEFAULT '0',
  `group_single_user` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_groups`
--

INSERT INTO `ft_groups` (`group_id`, `group_type`, `group_name`, `group_description`, `group_moderator`, `group_single_user`) VALUES
(1, 1, 'Anonymous', '', 0, 1),
(2, 1, 'Admin', '', 0, 1),
(3, 1, '', '', 0, 1),
(4, 1, '', '', 0, 1),
(5, 1, '', '', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_posts`
--

CREATE TABLE IF NOT EXISTS `ft_posts` (
  `post_id` mediumint(8) unsigned NOT NULL,
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
  `post_attachment` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_posts`
--

INSERT INTO `ft_posts` (`post_id`, `topic_id`, `forum_id`, `poster_id`, `post_time`, `poster_ip`, `post_username`, `enable_bbcode`, `enable_html`, `enable_smilies`, `enable_sig`, `post_edit_time`, `post_edit_count`, `post_attachment`) VALUES
(1, 1, 1, 2, 972086460, '7F000001', NULL, 1, 0, 1, 1, NULL, 0, 0),
(4, 3, 3, 4, 1117362875, '7f000001', '', 1, 0, 1, 0, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_posts_text`
--

CREATE TABLE IF NOT EXISTS `ft_posts_text` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` varchar(10) NOT NULL DEFAULT '',
  `post_subject` varchar(120) DEFAULT NULL,
  `post_text` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_posts_text`
--

INSERT INTO `ft_posts_text` (`post_id`, `bbcode_uid`, `post_subject`, `post_text`) VALUES
(1, '', NULL, 'This is an example post in your phpBB 2 installation. You may delete this post, this topic and even this forum if you like since everything seems to be working!'),
(4, '833b835389', 'Download Topic 1', 'test');

-- --------------------------------------------------------

--
-- Структура таблицы `ft_privmsgs`
--

CREATE TABLE IF NOT EXISTS `ft_privmsgs` (
  `privmsgs_id` mediumint(8) unsigned NOT NULL,
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
  `privmsgs_attachment` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_privmsgs_text`
--

CREATE TABLE IF NOT EXISTS `ft_privmsgs_text` (
  `privmsgs_text_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_bbcode_uid` varchar(10) NOT NULL DEFAULT '0',
  `privmsgs_text` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_quota_limits`
--

CREATE TABLE IF NOT EXISTS `ft_quota_limits` (
  `quota_limit_id` mediumint(8) unsigned NOT NULL,
  `quota_desc` varchar(20) NOT NULL DEFAULT '',
  `quota_limit` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_quota_limits`
--

INSERT INTO `ft_quota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES
(1, 'Low', 262144),
(2, 'Medium', 10485760),
(3, 'High', 15728640);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_ranks`
--

CREATE TABLE IF NOT EXISTS `ft_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL,
  `rank_title` varchar(50) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) DEFAULT '0',
  `rank_image` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_ranks`
--

INSERT INTO `ft_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES
(1, 'Site Admin', -1, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_search_results`
--

CREATE TABLE IF NOT EXISTS `ft_search_results` (
  `search_id` int(11) unsigned NOT NULL DEFAULT '0',
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `search_array` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_search_wordlist`
--

CREATE TABLE IF NOT EXISTS `ft_search_wordlist` (
  `word_text` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `word_id` mediumint(8) unsigned NOT NULL,
  `word_common` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_search_wordmatch`
--

CREATE TABLE IF NOT EXISTS `ft_search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title_match` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_sessions`
--

CREATE TABLE IF NOT EXISTS `ft_sessions` (
  `session_id` char(32) NOT NULL DEFAULT '',
  `session_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `session_start` int(11) NOT NULL DEFAULT '0',
  `session_time` int(11) NOT NULL DEFAULT '0',
  `session_ip` char(8) NOT NULL DEFAULT '0',
  `session_page` int(11) NOT NULL DEFAULT '0',
  `session_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `session_admin` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_sessions`
--

INSERT INTO `ft_sessions` (`session_id`, `session_user_id`, `session_start`, `session_time`, `session_ip`, `session_page`, `session_logged_in`, `session_admin`) VALUES
('96971e5d41b170677b0c1a50a5c6ae00', 2, 1456079565, 1456081315, '7f000001', 0, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_smilies`
--

CREATE TABLE IF NOT EXISTS `ft_smilies` (
  `smilies_id` smallint(5) unsigned NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `smile_url` varchar(100) DEFAULT NULL,
  `emoticon` varchar(75) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_smilies`
--

INSERT INTO `ft_smilies` (`smilies_id`, `code`, `smile_url`, `emoticon`) VALUES
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
-- Структура таблицы `ft_topics`
--

CREATE TABLE IF NOT EXISTS `ft_topics` (
  `topic_id` mediumint(8) unsigned NOT NULL,
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
  `topic_dl_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_topics`
--

INSERT INTO `ft_topics` (`topic_id`, `forum_id`, `topic_title`, `topic_poster`, `topic_time`, `topic_views`, `topic_replies`, `topic_status`, `topic_vote`, `topic_type`, `topic_first_post_id`, `topic_last_post_id`, `topic_moved_id`, `topic_attachment`, `topic_dl_type`, `topic_dl_status`) VALUES
(1, 1, 'Welcome to phpBB 2', 2, 972086460, 23, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0),
(3, 3, 'Download Topic 1', 4, 1117362875, 156, 0, 0, 0, 0, 4, 4, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_topics_move`
--

CREATE TABLE IF NOT EXISTS `ft_topics_move` (
  `id` mediumint(8) unsigned NOT NULL,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `waits_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `check_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  `move_fid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_waits_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_check_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recycle_move_fid` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_topics_watch`
--

CREATE TABLE IF NOT EXISTS `ft_topics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_users`
--

CREATE TABLE IF NOT EXISTS `ft_users` (
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
  `user_occ` varchar(100) DEFAULT NULL,
  `user_interests` varchar(255) DEFAULT NULL,
  `user_actkey` varchar(32) DEFAULT NULL,
  `user_newpasswd` varchar(32) DEFAULT NULL,
  `user_allow_passkey` tinyint(1) NOT NULL DEFAULT '1',
  `bt_tor_browse_set` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_users`
--

INSERT INTO `ft_users` (`user_id`, `user_active`, `username`, `user_password`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_regdate`, `user_level`, `user_posts`, `user_timezone`, `user_style`, `user_lang`, `user_dateformat`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_viewemail`, `user_attachsig`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_rank`, `user_avatar`, `user_avatar_type`, `user_email`, `user_icq`, `user_website`, `user_from`, `user_sig`, `user_sig_bbcode_uid`, `user_occ`, `user_interests`, `user_actkey`, `user_newpasswd`, `user_allow_passkey`, `bt_tor_browse_set`) VALUES
(-1, 0, 'Anonymous', '', 0, 0, 0, 1455565573, 0, 0, 0.00, NULL, '', '', 0, 0, 0, NULL, 0, 0, 1, 1, 1, 1, 0, 1, 0, 1, 0, NULL, '', 0, '', '', '', '', '', NULL, '', '', '', '', 1, ''),
(2, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1456081315, 0, 1456076587, 1455565573, 1, 1, 0.00, 1, 'russian', 'Y-m-d H:i', 0, 0, 1456079565, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1, '', 0, 'admin@admin.com', '', '', '', '', '', '', '', '', '', 1, 'a:15:{s:3:"sid";s:32:"96971e5d41b170677b0c1a50a5c6ae00";s:1:"n";i:0;s:2:"sd";i:0;s:1:"a";i:0;s:2:"my";i:0;s:1:"f";s:1:"3";s:3:"pid";i:0;s:2:"pn";s:0:"";s:3:"sns";i:-2;s:1:"o";i:1;s:1:"s";i:2;s:2:"tm";i:30;s:3:"shf";i:1;s:3:"sha";i:1;s:3:"shs";i:0;}'),
(-746, 0, 'bot', '', 1117115716, 2, 1117115634, 1455565573, 0, 0, 0.00, 1, 'english', 'Y-m-d H:i', 0, 0, 0, NULL, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 'bot.gif', 1, 'bot@bot.bot', '', '', '', '', '', '', '', '', NULL, 1, ''),
(4, 1, 'user1', 'c4ca4238a0b923820dcc509a6f75849b', 1117378293, -1, 1117362875, 1455565573, 0, 1, 0.00, 1, 'english', 'Y-m-d H:i', 0, 0, 1455662105, NULL, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, '', 0, '1@11.com', '', '', '', '', '', '', '', '', NULL, 1, ''),
(5, 1, 'user2', 'c4ca4238a0b923820dcc509a6f75849b', 1117378592, 3, 1117378303, 1455565573, 0, 0, 0.00, 1, 'english', 'Y-m-d H:i', 0, 0, 0, NULL, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, '', 0, '2@2.com', '', '', '', '', '', '', '', '', NULL, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `ft_user_group`
--

CREATE TABLE IF NOT EXISTS `ft_user_group` (
  `group_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_pending` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ft_user_group`
--

INSERT INTO `ft_user_group` (`group_id`, `user_id`, `user_pending`) VALUES
(1, -1, 0),
(2, 2, 0),
(3, -746, 0),
(4, 4, 0),
(5, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_vote_desc`
--

CREATE TABLE IF NOT EXISTS `ft_vote_desc` (
  `vote_id` mediumint(8) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_text` text NOT NULL,
  `vote_start` int(11) NOT NULL DEFAULT '0',
  `vote_length` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_vote_results`
--

CREATE TABLE IF NOT EXISTS `ft_vote_results` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_option_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `vote_option_text` varchar(255) NOT NULL DEFAULT '',
  `vote_result` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_vote_voters`
--

CREATE TABLE IF NOT EXISTS `ft_vote_voters` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `vote_user_ip` char(8) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_words`
--

CREATE TABLE IF NOT EXISTS `ft_words` (
  `word_id` mediumint(8) unsigned NOT NULL,
  `word` char(100) NOT NULL DEFAULT '',
  `replacement` char(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ft_attachments`
--
ALTER TABLE `ft_attachments`
  ADD KEY `attach_id_post_id` (`attach_id`,`post_id`),
  ADD KEY `attach_id_privmsgs_id` (`attach_id`,`privmsgs_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `privmsgs_id` (`privmsgs_id`);

--
-- Индексы таблицы `ft_attachments_config`
--
ALTER TABLE `ft_attachments_config`
  ADD PRIMARY KEY (`config_name`);

--
-- Индексы таблицы `ft_attachments_desc`
--
ALTER TABLE `ft_attachments_desc`
  ADD PRIMARY KEY (`attach_id`),
  ADD KEY `filetime` (`filetime`),
  ADD KEY `physical_filename` (`physical_filename`(10)),
  ADD KEY `filesize` (`filesize`);

--
-- Индексы таблицы `ft_attach_quota`
--
ALTER TABLE `ft_attach_quota`
  ADD KEY `quota_type` (`quota_type`);

--
-- Индексы таблицы `ft_auth_access`
--
ALTER TABLE `ft_auth_access`
  ADD KEY `group_id` (`group_id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Индексы таблицы `ft_banlist`
--
ALTER TABLE `ft_banlist`
  ADD PRIMARY KEY (`ban_id`),
  ADD KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`);

--
-- Индексы таблицы `ft_bt_config`
--
ALTER TABLE `ft_bt_config`
  ADD PRIMARY KEY (`config_name`);

--
-- Индексы таблицы `ft_bt_search_results`
--
ALTER TABLE `ft_bt_search_results`
  ADD PRIMARY KEY (`session_id`);

--
-- Индексы таблицы `ft_bt_torrents`
--
ALTER TABLE `ft_bt_torrents`
  ADD PRIMARY KEY (`torrent_id`),
  ADD UNIQUE KEY `info_hash` (`info_hash`),
  ADD UNIQUE KEY `post_id` (`post_id`),
  ADD UNIQUE KEY `topic_id` (`topic_id`),
  ADD UNIQUE KEY `attach_id` (`attach_id`),
  ADD KEY `reg_time` (`reg_time`);

--
-- Индексы таблицы `ft_bt_tor_dl_stat`
--
ALTER TABLE `ft_bt_tor_dl_stat`
  ADD PRIMARY KEY (`torrent_id`,`user_id`);

--
-- Индексы таблицы `ft_bt_tracker`
--
ALTER TABLE `ft_bt_tracker`
  ADD KEY `torrent_id` (`torrent_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `ft_bt_users`
--
ALTER TABLE `ft_bt_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `auth_key` (`auth_key`);

--
-- Индексы таблицы `ft_bt_users_dl_status`
--
ALTER TABLE `ft_bt_users_dl_status`
  ADD PRIMARY KEY (`topic_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `ft_categories`
--
ALTER TABLE `ft_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_order` (`cat_order`);

--
-- Индексы таблицы `ft_config`
--
ALTER TABLE `ft_config`
  ADD PRIMARY KEY (`config_name`);

--
-- Индексы таблицы `ft_disallow`
--
ALTER TABLE `ft_disallow`
  ADD PRIMARY KEY (`disallow_id`);

--
-- Индексы таблицы `ft_extensions`
--
ALTER TABLE `ft_extensions`
  ADD PRIMARY KEY (`ext_id`);

--
-- Индексы таблицы `ft_extension_groups`
--
ALTER TABLE `ft_extension_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Индексы таблицы `ft_forbidden_extensions`
--
ALTER TABLE `ft_forbidden_extensions`
  ADD PRIMARY KEY (`ext_id`);

--
-- Индексы таблицы `ft_forums`
--
ALTER TABLE `ft_forums`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `forums_order` (`forum_order`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `forum_last_post_id` (`forum_last_post_id`);

--
-- Индексы таблицы `ft_forum_prune`
--
ALTER TABLE `ft_forum_prune`
  ADD PRIMARY KEY (`prune_id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Индексы таблицы `ft_groups`
--
ALTER TABLE `ft_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_single_user` (`group_single_user`);

--
-- Индексы таблицы `ft_posts`
--
ALTER TABLE `ft_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `poster_id` (`poster_id`),
  ADD KEY `post_time` (`post_time`);

--
-- Индексы таблицы `ft_posts_text`
--
ALTER TABLE `ft_posts_text`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `ft_privmsgs`
--
ALTER TABLE `ft_privmsgs`
  ADD PRIMARY KEY (`privmsgs_id`),
  ADD KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  ADD KEY `privmsgs_to_userid` (`privmsgs_to_userid`);

--
-- Индексы таблицы `ft_privmsgs_text`
--
ALTER TABLE `ft_privmsgs_text`
  ADD PRIMARY KEY (`privmsgs_text_id`);

--
-- Индексы таблицы `ft_quota_limits`
--
ALTER TABLE `ft_quota_limits`
  ADD PRIMARY KEY (`quota_limit_id`);

--
-- Индексы таблицы `ft_ranks`
--
ALTER TABLE `ft_ranks`
  ADD PRIMARY KEY (`rank_id`);

--
-- Индексы таблицы `ft_search_results`
--
ALTER TABLE `ft_search_results`
  ADD PRIMARY KEY (`search_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Индексы таблицы `ft_search_wordlist`
--
ALTER TABLE `ft_search_wordlist`
  ADD PRIMARY KEY (`word_text`),
  ADD KEY `word_id` (`word_id`);

--
-- Индексы таблицы `ft_search_wordmatch`
--
ALTER TABLE `ft_search_wordmatch`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Индексы таблицы `ft_sessions`
--
ALTER TABLE `ft_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `session_user_id` (`session_user_id`),
  ADD KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`);

--
-- Индексы таблицы `ft_smilies`
--
ALTER TABLE `ft_smilies`
  ADD PRIMARY KEY (`smilies_id`);

--
-- Индексы таблицы `ft_topics`
--
ALTER TABLE `ft_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `topic_moved_id` (`topic_moved_id`),
  ADD KEY `topic_status` (`topic_status`),
  ADD KEY `topic_type` (`topic_type`),
  ADD FULLTEXT KEY `topic_title` (`topic_title`);

--
-- Индексы таблицы `ft_topics_move`
--
ALTER TABLE `ft_topics_move`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Индексы таблицы `ft_topics_watch`
--
ALTER TABLE `ft_topics_watch`
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `notify_status` (`notify_status`);

--
-- Индексы таблицы `ft_users`
--
ALTER TABLE `ft_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_session_time` (`user_session_time`);

--
-- Индексы таблицы `ft_user_group`
--
ALTER TABLE `ft_user_group`
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `ft_vote_desc`
--
ALTER TABLE `ft_vote_desc`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Индексы таблицы `ft_vote_results`
--
ALTER TABLE `ft_vote_results`
  ADD KEY `vote_option_id` (`vote_option_id`),
  ADD KEY `vote_id` (`vote_id`);

--
-- Индексы таблицы `ft_vote_voters`
--
ALTER TABLE `ft_vote_voters`
  ADD KEY `vote_id` (`vote_id`),
  ADD KEY `vote_user_id` (`vote_user_id`),
  ADD KEY `vote_user_ip` (`vote_user_ip`);

--
-- Индексы таблицы `ft_words`
--
ALTER TABLE `ft_words`
  ADD PRIMARY KEY (`word_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ft_attachments_desc`
--
ALTER TABLE `ft_attachments_desc`
  MODIFY `attach_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `ft_banlist`
--
ALTER TABLE `ft_banlist`
  MODIFY `ban_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_bt_torrents`
--
ALTER TABLE `ft_bt_torrents`
  MODIFY `torrent_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `ft_categories`
--
ALTER TABLE `ft_categories`
  MODIFY `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `ft_disallow`
--
ALTER TABLE `ft_disallow`
  MODIFY `disallow_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_extensions`
--
ALTER TABLE `ft_extensions`
  MODIFY `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `ft_extension_groups`
--
ALTER TABLE `ft_extension_groups`
  MODIFY `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `ft_forbidden_extensions`
--
ALTER TABLE `ft_forbidden_extensions`
  MODIFY `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `ft_forum_prune`
--
ALTER TABLE `ft_forum_prune`
  MODIFY `prune_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_groups`
--
ALTER TABLE `ft_groups`
  MODIFY `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `ft_posts`
--
ALTER TABLE `ft_posts`
  MODIFY `post_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `ft_privmsgs`
--
ALTER TABLE `ft_privmsgs`
  MODIFY `privmsgs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `ft_quota_limits`
--
ALTER TABLE `ft_quota_limits`
  MODIFY `quota_limit_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `ft_ranks`
--
ALTER TABLE `ft_ranks`
  MODIFY `rank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `ft_search_wordlist`
--
ALTER TABLE `ft_search_wordlist`
  MODIFY `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_smilies`
--
ALTER TABLE `ft_smilies`
  MODIFY `smilies_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `ft_topics`
--
ALTER TABLE `ft_topics`
  MODIFY `topic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `ft_topics_move`
--
ALTER TABLE `ft_topics_move`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_vote_desc`
--
ALTER TABLE `ft_vote_desc`
  MODIFY `vote_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ft_words`
--
ALTER TABLE `ft_words`
  MODIFY `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
