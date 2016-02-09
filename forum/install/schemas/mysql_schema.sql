# --------------------------------------------------------
#
# Table structure for table `phpbb_attach_quota`
#

CREATE TABLE phpbb_attach_quota (
  user_id mediumint(8) unsigned NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '0',
  quota_type smallint(2) NOT NULL default '0',
  quota_limit_id mediumint(8) unsigned NOT NULL default '0',
  KEY quota_type (quota_type)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_attachments`
#

CREATE TABLE phpbb_attachments (
  attach_id mediumint(8) unsigned NOT NULL default '0',
  post_id mediumint(8) unsigned NOT NULL default '0',
  privmsgs_id mediumint(8) unsigned NOT NULL default '0',
  user_id_1 mediumint(8) NOT NULL default '0',
  user_id_2 mediumint(8) NOT NULL default '0',
  KEY attach_id_post_id (attach_id,post_id),
  KEY attach_id_privmsgs_id (attach_id,privmsgs_id),
  KEY post_id (post_id),
  KEY privmsgs_id (privmsgs_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_attachments_config`
#

CREATE TABLE phpbb_attachments_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_attachments_desc`
#

CREATE TABLE phpbb_attachments_desc (
  attach_id mediumint(8) unsigned NOT NULL auto_increment,
  physical_filename varchar(255) NOT NULL default '',
  real_filename varchar(255) NOT NULL default '',
  download_count mediumint(8) unsigned NOT NULL default '0',
  `comment` varchar(255) default NULL,
  extension varchar(100) default NULL,
  mimetype varchar(100) default NULL,
  filesize int(20) NOT NULL default '0',
  filetime int(11) NOT NULL default '0',
  thumbnail tinyint(1) NOT NULL default '0',
  tracker_status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (attach_id),
  KEY filetime (filetime),
  KEY physical_filename (physical_filename(10)),
  KEY filesize (filesize)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_auth_access`
#

CREATE TABLE phpbb_auth_access (
  group_id mediumint(8) NOT NULL default '0',
  forum_id smallint(5) unsigned NOT NULL default '0',
  auth_view tinyint(1) NOT NULL default '0',
  auth_read tinyint(1) NOT NULL default '0',
  auth_post tinyint(1) NOT NULL default '0',
  auth_reply tinyint(1) NOT NULL default '0',
  auth_edit tinyint(1) NOT NULL default '0',
  auth_delete tinyint(1) NOT NULL default '0',
  auth_sticky tinyint(1) NOT NULL default '0',
  auth_announce tinyint(1) NOT NULL default '0',
  auth_vote tinyint(1) NOT NULL default '0',
  auth_pollcreate tinyint(1) NOT NULL default '0',
  auth_attachments tinyint(1) NOT NULL default '0',
  auth_mod tinyint(1) NOT NULL default '0',
  auth_download tinyint(1) NOT NULL default '0',
  KEY group_id (group_id),
  KEY forum_id (forum_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_banlist`
#

CREATE TABLE phpbb_banlist (
  ban_id mediumint(8) unsigned NOT NULL auto_increment,
  ban_userid mediumint(8) NOT NULL default '0',
  ban_ip varchar(8) NOT NULL default '',
  ban_email varchar(255) default NULL,
  PRIMARY KEY  (ban_id),
  KEY ban_ip_user_id (ban_ip,ban_userid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_bt_config`
#

CREATE TABLE phpbb_bt_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_bt_search_results`
#

CREATE TABLE phpbb_bt_search_results (
  session_id varchar(32) NOT NULL default '',
  search_id int(10) unsigned NOT NULL default '0',
  added int(11) NOT NULL default '0',
  search_array text NOT NULL,
  search_settings text NOT NULL,
  PRIMARY KEY  (session_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
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
  topic_check_status tinyint(3) unsigned NOT NULL default '0',
  topic_check_uid mediumint(8) unsigned NOT NULL default '0',
  topic_check_date int(11) NOT NULL default '0',   
  topic_check_first_fid mediumint(8) unsigned NOT NULL default '0',
  topic_check_duble_tid mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (torrent_id),
  UNIQUE KEY info_hash (info_hash),
  UNIQUE KEY post_id (post_id),
  UNIQUE KEY topic_id (topic_id),
  UNIQUE KEY attach_id (attach_id),
  KEY reg_time (reg_time)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
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
  releaser tinyint(1) NOT NULL default '0', 
  last_stored_up bigint(20) unsigned NOT NULL default '0',
  last_stored_down bigint(20) unsigned NOT NULL default '0',
  stat_last_updated int(11) NOT NULL default '0',
  speed_up mediumint(8) unsigned NOT NULL default '0',
  speed_down mediumint(8) unsigned NOT NULL default '0',
  update_time int(11) NOT NULL default '0',
  expire_time int(11) NOT NULL default '0',
  KEY torrent_id (torrent_id),
  KEY user_id (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_bt_users`
#

CREATE TABLE phpbb_bt_users (
  user_id mediumint(9) NOT NULL default '0',
  auth_key binary(10) NOT NULL default '',
  u_up_total bigint(20) unsigned NOT NULL default '0',
  u_bonus_total bigint(20) unsigned NOT NULL default '0',
  u_down_total bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (user_id),
  UNIQUE KEY auth_key (auth_key)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_bt_users_dl_status`
#

CREATE TABLE phpbb_bt_users_dl_status (
  topic_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(9) NOT NULL default '0',
  user_status tinyint(1) NOT NULL default '0',
  compl_count tinyint(1) unsigned NOT NULL default '0',
  update_time int(11) NOT NULL default '0',
  PRIMARY KEY  (topic_id,user_id),
  KEY user_id (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_categories`
#

CREATE TABLE phpbb_categories (
  cat_id mediumint(8) unsigned NOT NULL auto_increment,
  cat_title varchar(100) default NULL,
  cat_order mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (cat_id),
  KEY cat_order (cat_order)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_config`
#

CREATE TABLE phpbb_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_confirm`
#

CREATE TABLE phpbb_confirm (
  confirm_id char(32) NOT NULL default '',
  session_id char(32) NOT NULL default '',
  code char(6) NOT NULL default '',
  PRIMARY KEY  (session_id,confirm_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_disallow`
#

CREATE TABLE phpbb_disallow (
  disallow_id mediumint(8) unsigned NOT NULL auto_increment,
  disallow_username varchar(25) NOT NULL default '',
  PRIMARY KEY  (disallow_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_extension_groups`
#

CREATE TABLE phpbb_extension_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name varchar(20) NOT NULL default '',
  cat_id tinyint(2) NOT NULL default '0',
  allow_group tinyint(1) NOT NULL default '0',
  download_mode tinyint(1) unsigned NOT NULL default '1',
  upload_icon varchar(100) default '',
  max_filesize int(20) NOT NULL default '0',
  forum_permissions varchar(255) NOT NULL default '',
  PRIMARY KEY  (group_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_extensions`
#

CREATE TABLE phpbb_extensions (
  ext_id mediumint(8) unsigned NOT NULL auto_increment,
  group_id mediumint(8) unsigned NOT NULL default '0',
  extension varchar(100) NOT NULL default '',
  `comment` varchar(100) default NULL,
  PRIMARY KEY  (ext_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_flags`
#

CREATE TABLE phpbb_flags (
  flag_id int(10) NOT NULL auto_increment,
  flag_name varchar(25) default '',
  flag_image varchar(25) default '',
  PRIMARY KEY  (flag_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_forbidden_extensions`
#

CREATE TABLE phpbb_forbidden_extensions (
  ext_id mediumint(8) unsigned NOT NULL auto_increment,
  extension varchar(100) NOT NULL default '',
  PRIMARY KEY  (ext_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_forum_prune`
#

CREATE TABLE phpbb_forum_prune (
  prune_id mediumint(8) unsigned NOT NULL auto_increment,
  forum_id smallint(5) unsigned NOT NULL default '0',
  prune_days smallint(5) unsigned NOT NULL default '0',
  prune_freq smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (prune_id),
  KEY forum_id (forum_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_forums`
#

CREATE TABLE phpbb_forums (
  forum_id smallint(5) unsigned NOT NULL default '0',
  cat_id mediumint(8) unsigned NOT NULL default '0',
  forum_name varchar(150) default NULL,
  forum_desc text,
  forum_status tinyint(4) NOT NULL default '0',
  forum_order mediumint(8) unsigned NOT NULL default '1',
  forum_posts mediumint(8) unsigned NOT NULL default '0',
  forum_topics mediumint(8) unsigned NOT NULL default '0',
  forum_last_post_id mediumint(8) unsigned NOT NULL default '0',
  prune_next int(11) default NULL,
  prune_enable tinyint(1) NOT NULL default '0',
  auth_view tinyint(2) NOT NULL default '0',
  auth_read tinyint(2) NOT NULL default '0',
  auth_post tinyint(2) NOT NULL default '0',
  auth_reply tinyint(2) NOT NULL default '0',
  auth_edit tinyint(2) NOT NULL default '0',
  auth_delete tinyint(2) NOT NULL default '0',
  auth_sticky tinyint(2) NOT NULL default '0',
  auth_announce tinyint(2) NOT NULL default '0',
  auth_vote tinyint(2) NOT NULL default '0',
  auth_pollcreate tinyint(2) NOT NULL default '0',
  auth_attachments tinyint(2) NOT NULL default '0',
  auth_download tinyint(2) NOT NULL default '0',
  allow_reg_tracker tinyint(1) NOT NULL default '0',
  allow_dl_topic tinyint(1) NOT NULL default '0',
  dl_type_default tinyint(1) NOT NULL default '0',
  self_moderated tinyint(1) NOT NULL default '0',
  last_dl_topics_synch int(11) NOT NULL default '0',
  show_dl_buttons tinyint(1) NOT NULL default '0',
  forum_parent mediumint(9) NOT NULL default '0',
  show_on_index tinyint(1) NOT NULL default '1',
  forum_display_sort tinyint(1) NOT NULL default '0',
  forum_display_order tinyint(1) NOT NULL default '0',
  move_next int(11) unsigned NOT NULL default '0',
  recycle_move_next int(11) unsigned NOT NULL default '0',
  move_enable tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (forum_id),
  KEY forums_order (forum_order),
  KEY cat_id (cat_id),
  KEY forum_last_post_id (forum_last_post_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_groups`
#

CREATE TABLE phpbb_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_type tinyint(4) NOT NULL default '1',
  group_name varchar(40) NOT NULL default '',
  group_description varchar(255) NOT NULL default '',
  group_moderator mediumint(8) NOT NULL default '0',
  group_single_user tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (group_id),
  KEY group_single_user (group_single_user)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_posts`
#

CREATE TABLE phpbb_posts (
  post_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_id mediumint(8) unsigned NOT NULL default '0',
  forum_id smallint(5) unsigned NOT NULL default '0',
  poster_id mediumint(8) NOT NULL default '0',
  post_time int(11) NOT NULL default '0',
  poster_ip varchar(8) NOT NULL default '',
  post_username varchar(25) default NULL,
  enable_bbcode tinyint(1) NOT NULL default '1',
  enable_html tinyint(1) NOT NULL default '0',
  enable_smilies tinyint(1) NOT NULL default '1',
  enable_sig tinyint(1) NOT NULL default '1',
  post_edit_time int(11) default NULL,
  post_edit_count smallint(5) unsigned NOT NULL default '0',
  post_attachment tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (post_id),
  KEY forum_id (forum_id),
  KEY topic_id (topic_id),
  KEY poster_id (poster_id),
  KEY post_time (post_time)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_posts_text`
#

CREATE TABLE phpbb_posts_text (
  post_id mediumint(8) unsigned NOT NULL default '0',
  bbcode_uid varchar(10) NOT NULL default '',
  post_subject varchar(120) default NULL,
  post_text text,
  PRIMARY KEY  (post_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_privmsgs`
#

CREATE TABLE phpbb_privmsgs (
  privmsgs_id mediumint(8) unsigned NOT NULL auto_increment,
  privmsgs_type tinyint(4) NOT NULL default '0',
  privmsgs_subject varchar(255) NOT NULL default '0',
  privmsgs_from_userid mediumint(8) NOT NULL default '0',
  privmsgs_to_userid mediumint(8) NOT NULL default '0',
  privmsgs_date int(11) NOT NULL default '0',
  privmsgs_ip varchar(8) NOT NULL default '',
  privmsgs_enable_bbcode tinyint(1) NOT NULL default '1',
  privmsgs_enable_html tinyint(1) NOT NULL default '0',
  privmsgs_enable_smilies tinyint(1) NOT NULL default '1',
  privmsgs_attach_sig tinyint(1) NOT NULL default '1',
  privmsgs_attachment tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (privmsgs_id),
  KEY privmsgs_from_userid (privmsgs_from_userid),
  KEY privmsgs_to_userid (privmsgs_to_userid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_privmsgs_text`
#

CREATE TABLE phpbb_privmsgs_text (
  privmsgs_text_id mediumint(8) unsigned NOT NULL default '0',
  privmsgs_bbcode_uid varchar(10) NOT NULL default '0',
  privmsgs_text text,
  PRIMARY KEY  (privmsgs_text_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_quota_limits`
#

CREATE TABLE phpbb_quota_limits (
  quota_limit_id mediumint(8) unsigned NOT NULL auto_increment,
  quota_desc varchar(20) NOT NULL default '',
  quota_limit bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (quota_limit_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_ranks`
#

CREATE TABLE phpbb_ranks (
  rank_id smallint(5) unsigned NOT NULL auto_increment,
  rank_title varchar(50) NOT NULL default '',
  rank_min mediumint(8) NOT NULL default '0',
  rank_special tinyint(1) default '0',
  rank_image varchar(255) default NULL,
  PRIMARY KEY  (rank_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_search_results`
#

CREATE TABLE phpbb_search_results (
  search_id int(11) unsigned NOT NULL default '0',
  session_id varchar(32) NOT NULL default '',
  search_array text NOT NULL,
  PRIMARY KEY  (search_id),
  KEY session_id (session_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_search_wordlist`
#

CREATE TABLE phpbb_search_wordlist (
  word_text varchar(50) binary NOT NULL default '',
  word_id mediumint(8) unsigned NOT NULL auto_increment,
  word_common tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (word_text),
  KEY word_id (word_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_search_wordmatch`
#

CREATE TABLE phpbb_search_wordmatch (
  post_id mediumint(8) unsigned NOT NULL default '0',
  word_id mediumint(8) unsigned NOT NULL default '0',
  title_match tinyint(1) NOT NULL default '0',
  KEY post_id (post_id),
  KEY word_id (word_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_sessions`
#

CREATE TABLE phpbb_sessions (
  session_id char(32) NOT NULL default '',
  session_user_id mediumint(8) NOT NULL default '0',
  session_start int(11) NOT NULL default '0',
  session_time int(11) NOT NULL default '0',
  session_ip char(8) NOT NULL default '0',
  session_page int(11) NOT NULL default '0',
  session_logged_in tinyint(1) NOT NULL default '0',
  session_admin tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (session_id),
  KEY session_user_id (session_user_id),
  KEY session_id_ip_user_id (session_id,session_ip,session_user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_smilies`
#

CREATE TABLE phpbb_smilies (
  smilies_id smallint(5) unsigned NOT NULL auto_increment,
  code varchar(50) default NULL,
  smile_url varchar(100) default NULL,
  emoticon varchar(75) default NULL,
  PRIMARY KEY  (smilies_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_themes`
#

CREATE TABLE phpbb_themes (
  themes_id mediumint(8) unsigned NOT NULL auto_increment,
  template_name varchar(30) NOT NULL default '',
  style_name varchar(30) NOT NULL default '',
  head_stylesheet varchar(100) default NULL,
  body_background varchar(100) default NULL,
  body_bgcolor varchar(6) default NULL,
  body_text varchar(6) default NULL,
  body_link varchar(6) default NULL,
  body_vlink varchar(6) default NULL,
  body_alink varchar(6) default NULL,
  body_hlink varchar(6) default NULL,
  tr_color1 varchar(6) default NULL,
  tr_color2 varchar(6) default NULL,
  tr_color3 varchar(6) default NULL,
  tr_class1 varchar(25) default NULL,
  tr_class2 varchar(25) default NULL,
  tr_class3 varchar(25) default NULL,
  th_color1 varchar(6) default NULL,
  th_color2 varchar(6) default NULL,
  th_color3 varchar(6) default NULL,
  th_class1 varchar(25) default NULL,
  th_class2 varchar(25) default NULL,
  th_class3 varchar(25) default NULL,
  td_color1 varchar(6) default NULL,
  td_color2 varchar(6) default NULL,
  td_color3 varchar(6) default NULL,
  td_class1 varchar(25) default NULL,
  td_class2 varchar(25) default NULL,
  td_class3 varchar(25) default NULL,
  fontface1 varchar(50) default NULL,
  fontface2 varchar(50) default NULL,
  fontface3 varchar(50) default NULL,
  fontsize1 tinyint(4) default NULL,
  fontsize2 tinyint(4) default NULL,
  fontsize3 tinyint(4) default NULL,
  fontcolor1 varchar(6) default NULL,
  fontcolor2 varchar(6) default NULL,
  fontcolor3 varchar(6) default NULL,
  span_class1 varchar(25) default NULL,
  span_class2 varchar(25) default NULL,
  span_class3 varchar(25) default NULL,
  img_size_poll smallint(5) unsigned default NULL,
  img_size_privmsg smallint(5) unsigned default NULL,
  PRIMARY KEY  (themes_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_themes_name`
#

CREATE TABLE phpbb_themes_name (
  themes_id smallint(5) unsigned NOT NULL default '0',
  tr_color1_name char(50) default NULL,
  tr_color2_name char(50) default NULL,
  tr_color3_name char(50) default NULL,
  tr_class1_name char(50) default NULL,
  tr_class2_name char(50) default NULL,
  tr_class3_name char(50) default NULL,
  th_color1_name char(50) default NULL,
  th_color2_name char(50) default NULL,
  th_color3_name char(50) default NULL,
  th_class1_name char(50) default NULL,
  th_class2_name char(50) default NULL,
  th_class3_name char(50) default NULL,
  td_color1_name char(50) default NULL,
  td_color2_name char(50) default NULL,
  td_color3_name char(50) default NULL,
  td_class1_name char(50) default NULL,
  td_class2_name char(50) default NULL,
  td_class3_name char(50) default NULL,
  fontface1_name char(50) default NULL,
  fontface2_name char(50) default NULL,
  fontface3_name char(50) default NULL,
  fontsize1_name char(50) default NULL,
  fontsize2_name char(50) default NULL,
  fontsize3_name char(50) default NULL,
  fontcolor1_name char(50) default NULL,
  fontcolor2_name char(50) default NULL,
  fontcolor3_name char(50) default NULL,
  span_class1_name char(50) default NULL,
  span_class2_name char(50) default NULL,
  span_class3_name char(50) default NULL,
  PRIMARY KEY  (themes_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_topics`
#

CREATE TABLE phpbb_topics (
  topic_id mediumint(8) unsigned NOT NULL auto_increment,
  forum_id smallint(8) unsigned NOT NULL default '0',
  topic_title char(120) NOT NULL default '',
  topic_poster mediumint(8) NOT NULL default '0',
  topic_time int(11) NOT NULL default '0',
  topic_views mediumint(8) unsigned NOT NULL default '0',
  topic_replies mediumint(8) unsigned NOT NULL default '0',
  topic_status tinyint(3) NOT NULL default '0',
  topic_vote tinyint(1) NOT NULL default '0',
  topic_type tinyint(3) NOT NULL default '0',
  topic_first_post_id mediumint(8) unsigned NOT NULL default '0',
  topic_last_post_id mediumint(8) unsigned NOT NULL default '0',
  topic_moved_id mediumint(8) unsigned NOT NULL default '0',
  topic_attachment tinyint(1) NOT NULL default '0',
  topic_dl_type tinyint(1) NOT NULL default '0',
  topic_dl_status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (topic_id),
  KEY forum_id (forum_id),
  KEY topic_moved_id (topic_moved_id),
  KEY topic_status (topic_status),
  KEY topic_type (topic_type),
  FULLTEXT KEY topic_title (topic_title)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_topics_move`
#

CREATE TABLE phpbb_topics_move (
  id mediumint(8) unsigned NOT NULL auto_increment,
  forum_id smallint(5) unsigned NOT NULL default '0',
  waits_days smallint(5) unsigned NOT NULL default '0',
  check_freq smallint(5) unsigned NOT NULL default '0',
  move_fid smallint(5) unsigned NOT NULL default '0',
  recycle_waits_days smallint(5) unsigned NOT NULL default '0',
  recycle_check_freq smallint(5) unsigned NOT NULL default '0',
  recycle_move_fid smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY forum_id (forum_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_topics_watch`
#

CREATE TABLE phpbb_topics_watch (
  topic_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  notify_status tinyint(1) NOT NULL default '0',
  KEY topic_id (topic_id),
  KEY user_id (user_id),
  KEY notify_status (notify_status)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_user_group`
#

CREATE TABLE phpbb_user_group (
  group_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  user_pending tinyint(1) default NULL,
  KEY group_id (group_id),
  KEY user_id (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_users`
#

CREATE TABLE phpbb_users (
  user_id mediumint(8) NOT NULL default '0',
  user_active tinyint(1) default '1',
  username varchar(25) NOT NULL default '',
  user_password varchar(32) NOT NULL default '',
  user_session_time int(11) NOT NULL default '0',
  user_session_page smallint(5) NOT NULL default '0',
  user_lastvisit int(11) NOT NULL default '0',
  user_regdate int(11) NOT NULL default '0',
  user_level tinyint(4) default '0',
  user_posts mediumint(8) unsigned NOT NULL default '0',
  user_timezone decimal(5,2) NOT NULL default '0.00',
  user_style tinyint(4) default NULL,
  user_lang varchar(255) default NULL,
  user_dateformat varchar(14) NOT NULL default 'd M Y H:i',
  user_new_privmsg smallint(5) unsigned NOT NULL default '0',
  user_unread_privmsg smallint(5) unsigned NOT NULL default '0',
  user_last_privmsg int(11) NOT NULL default '0',
  user_emailtime int(11) default NULL,
  user_viewemail tinyint(1) default NULL,
  user_attachsig tinyint(1) default NULL,
  user_allowhtml tinyint(1) default '1',
  user_allowbbcode tinyint(1) default '1',
  user_allowsmile tinyint(1) default '1',
  user_allowavatar tinyint(1) NOT NULL default '1',
  user_allow_pm tinyint(1) NOT NULL default '1',
  user_allow_viewonline tinyint(1) NOT NULL default '1',
  user_notify tinyint(1) NOT NULL default '1',
  user_notify_pm tinyint(1) NOT NULL default '0',
  user_popup_pm tinyint(1) NOT NULL default '0',
  user_rank int(11) default '0',
  user_avatar varchar(100) default NULL,
  user_avatar_type tinyint(4) NOT NULL default '0',
  user_email varchar(255) default NULL,
  user_icq varchar(15) default NULL,
  user_website varchar(100) default NULL,
  user_from varchar(100) default NULL,
  user_sig text,
  user_sig_bbcode_uid varchar(10) default NULL,
  user_aim varchar(255) default NULL,
  user_yim varchar(255) default NULL,
  user_msnm varchar(255) default NULL,
  user_occ varchar(100) default NULL,
  user_interests varchar(255) default NULL,
  user_actkey varchar(32) default NULL,
  user_newpasswd varchar(32) default NULL,
  user_allow_passkey tinyint(1) NOT NULL default '1',
  bt_tor_browse_set text default NULL,
  user_from_flag varchar(25) default NULL,
  PRIMARY KEY  (user_id),
  KEY user_session_time (user_session_time)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_vote_desc`
#

CREATE TABLE phpbb_vote_desc (
  vote_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_id mediumint(8) unsigned NOT NULL default '0',
  vote_text text NOT NULL,
  vote_start int(11) NOT NULL default '0',
  vote_length int(11) NOT NULL default '0',
  PRIMARY KEY  (vote_id),
  KEY topic_id (topic_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_vote_results`
#

CREATE TABLE phpbb_vote_results (
  vote_id mediumint(8) unsigned NOT NULL default '0',
  vote_option_id tinyint(4) unsigned NOT NULL default '0',
  vote_option_text varchar(255) NOT NULL default '',
  vote_result int(11) NOT NULL default '0',
  KEY vote_option_id (vote_option_id),
  KEY vote_id (vote_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_vote_voters`
#

CREATE TABLE phpbb_vote_voters (
  vote_id mediumint(8) unsigned NOT NULL default '0',
  vote_user_id mediumint(8) NOT NULL default '0',
  vote_user_ip char(8) NOT NULL default '',
  KEY vote_id (vote_id),
  KEY vote_user_id (vote_user_id),
  KEY vote_user_ip (vote_user_ip)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#
# Table structure for table `phpbb_words`
#

CREATE TABLE phpbb_words (
  word_id mediumint(8) unsigned NOT NULL auto_increment,
  word char(100) NOT NULL default '',
  replacement char(100) NOT NULL default '',
  PRIMARY KEY  (word_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------
#

ALTER TABLE phpbb_bt_tracker ENGINE=MyISAM DEFAULT CHARSET=utf8;