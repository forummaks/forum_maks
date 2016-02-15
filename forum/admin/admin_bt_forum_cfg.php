<?php

$max_forum_name_len = 25;
$max_forum_rows     = 35;

@define('IN_PHPBB', TRUE);
$page_title = 'Forum Config';

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['TorrentPier']['Forum_Config'] = "$file";
	return;
}

// Load default header
$phpbb_root_path = './../';
require($phpbb_root_path .'extension.inc');
require('./pagestart.'. $phpEx);
include($phpbb_root_path .'includes/functions_admin_torrent.'. $phpEx);

if (file_exists(@phpbb_realpath($phpbb_root_path .'language/lang_'. $board_config['default_lang'] .'/lang_admin_bt.'. $phpEx)))
{
	include($phpbb_root_path .'language/lang_'. $board_config['default_lang'] .'/lang_admin_bt.'. $phpEx);
}
else
{
	include($phpbb_root_path .'language/lang_english/lang_admin_bt.'. $phpEx);
}

$submit  = (isset($_POST['submit'])) ? TRUE : FALSE;
$confirm = (isset($_POST['confirm'])) ? TRUE : FALSE;

$ch  = 'checked="checked"';
$cfg = array();

// All config names with default values
$default_cfg_str = array(
	'bt_announce_url'              => 'http://yourdomain.com/bt/',
	'bt_add_comment'               => '',
	'bt_add_publisher'             => ''
);

$default_cfg_bool = array(
	'bt_show_peers'                => 1,
	'bt_add_auth_key'              => 1,
	'bt_show_dl_list'              => 1,
	'bt_dl_list_only_1st_page'     => 1,
	'bt_dl_list_only_count'        => 1,
	'bt_gen_passkey_on_reg'        => 1,
	'bt_replace_ann_url'           => 1,
	'bt_show_ip_only_moder'        => 1,
	'bt_show_port_only_moder'      => 1,
	'bt_check_announce_url'        => 0,
	'bt_show_dl_list_buttons'      => 1,
	'bt_show_dl_but_will'          => 1,
	'bt_show_dl_but_down'          => 0,
	'bt_show_dl_but_compl'         => 0,
	'bt_show_dl_but_cancel'        => 1,
	'bt_show_dl_stat_on_index'     => 1,
	'bt_newtopic_auto_reg'         => 1,
	'bt_tor_browse_only_reg'       => 1,
	'bt_search_bool_mode'          => 0,
	'bt_allow_spmode_change'       => 1,
	'bt_force_passkey'             => 1,
	'bt_del_addit_ann_urls'        => 1,
	'bt_set_dltype_on_tor_reg'     => 1,
	'bt_unset_dltype_on_tor_unreg' => 0
);

$default_cfg_num = array(
	'bt_dl_list_expire'            => 30,
	'bt_show_peers_mode'           => SHOW_PEERS_COUNT
);

$default_cfg = array_merge($default_cfg_str, $default_cfg_bool, $default_cfg_num);

$db_fields_bool = array(
	'allow_reg_tracker'            => 0,  // Allowed forums for registering torrents on tracker
	'allow_dl_topic'               => 0,  // Allowed forums for dl-topics
	'dl_type_default'              => 0,  // "Download type" as default for new topics
	'show_dl_buttons'              => 0,  // Show "dl-list buttons" for dl-topics
	'self_moderated'               => 0   // Users can move theirs topic to another forum
);

// Get config
$cfg = get_config_ary(CONFIG_TABLE);

// Submit new config
if ($submit && $confirm)
{
	foreach ($db_fields_bool as $field_name => $field_def_val)
	{
		update_table_bool(FORUMS_TABLE, 'forum_id', $field_name, $field_def_val);
	}

	update_config_table(CONFIG_TABLE, $default_cfg_str,  $cfg, 'str');
	update_config_table(CONFIG_TABLE, $default_cfg_bool, $cfg, 'bool');
	update_config_table(CONFIG_TABLE, $default_cfg_num,  $cfg, 'num');

	$message = $lang['config_upd'] .'<br /><br />'. sprintf($lang['return_config'], '<a href="'. append_sid("admin_bt_forum_cfg.$phpEx") .'">', '</a>') .'<br /><br />'. sprintf($lang['Click_return_admin_index'], '<a href="'. append_sid("index.$phpEx?pane=right") .'">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

// Set template vars
set_tpl_vars      ($default_cfg_str, $cfg);
set_tpl_vars_lang ($default_cfg_str);

set_tpl_vars_bool ($default_cfg_bool, $cfg);
set_tpl_vars_lang ($default_cfg_bool);

set_tpl_vars      ($default_cfg_num, $cfg);
set_tpl_vars_lang ($default_cfg_num);

set_tpl_vars_lang ($db_fields_bool);

// Get Forums list
$sql = 'SELECT f.*
	FROM '. CATEGORIES_TABLE .' c, '. FORUMS_TABLE .' f
	WHERE f.cat_id = c.cat_id
	ORDER BY c.cat_order, c.cat_id, f.forum_order';

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not obtain forum names', '', __LINE__, __FILE__, $sql);
}

$rowset = @$db->sql_fetchrowset($result);
$forum_rows = min($max_forum_rows, count($rowset));

foreach ($db_fields_bool as $field_name => $field_def_val)
{
	$$field_name = '';
}

foreach ($rowset as $rid => $forum)
{
	foreach ($db_fields_bool as $field_name => $field_def_val)
	{
		$forum_name = $forum['forum_name'];
		$selected   = ($forum[$field_name]) ? ' selected="selected"' : '';

		if (strlen($forum_name) > $max_forum_name_len)
		{
			$forum_name = substr($forum_name, 0, $max_forum_name_len) . '..';
		}

		$$field_name .= '<option value="'. $forum['forum_id'] .'" '. $selected .'>&nbsp;' . (($forum['forum_parent']) ? SF_SEL_SPACER : '') . $forum_name .'</option>';
	}
}

foreach ($db_fields_bool as $field_name => $field_def_val)
{
	$$field_name = '<select name="'. $field_name ."[]\" multiple=\"multiple\" size=\"$forum_rows\">". $$field_name .'</select>';
	$template->assign_vars(array('S_'. strtoupper($field_name) => $$field_name));
}

$template->set_filenames(array('body' => 'admin/bt_forum_cfg_body.tpl'));

$template->assign_vars(array(
	'L_CONFIGURATION_TITLE'   => $lang['forum_cfg_title'],
	'L_GENERAL_SETTINGS'      => $lang['General_settings'],
	'L_BT_SELECT_FORUMS'      => $lang['bt_select_forums'],
	'L_BT_SELECT_FORUMS_EXPL' => $lang['bt_select_forums_expl'],

	'L_BT_SHOW_PEERS_MODE_COUNT'   => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_COUNT) ? '<u>'. $lang['bt_show_peers_mode_count'] .'</u>' : $lang['bt_show_peers_mode_count'],
	'L_BT_SHOW_PEERS_MODE_NAMES'   => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_NAMES) ? '<u>'. $lang['bt_show_peers_mode_names'] .'</u>' : $lang['bt_show_peers_mode_names'],
	'L_BT_SHOW_PEERS_MODE_FULL'    => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_FULL) ? '<u>'. $lang['bt_show_peers_mode_full'] .'</u>' : $lang['bt_show_peers_mode_full'],

	'BT_SHOW_PEERS_MODE_COUNT_VAL' => SHOW_PEERS_COUNT,
	'BT_SHOW_PEERS_MODE_NAMES_VAL' => SHOW_PEERS_NAMES,
	'BT_SHOW_PEERS_MODE_FULL_VAL'  => SHOW_PEERS_FULL,

	'BT_SHOW_PEERS_MODE_COUNT_SEL' => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_COUNT) ? $ch : '',
	'BT_SHOW_PEERS_MODE_NAMES_SEL' => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_NAMES) ? $ch : '',
	'BT_SHOW_PEERS_MODE_FULL_SEL'  => ($cfg['bt_show_peers_mode'] == SHOW_PEERS_FULL) ? $ch : '',

	'S_HIDDEN_FIELDS' => '',
	'S_CONFIG_ACTION' => append_sid("admin_bt_forum_cfg.$phpEx"),

	'L_CONFIRM'   => $lang['Confirm'],
	'L_SUBMIT'    => $lang['Submit'],
	'L_RESET'     => $lang['Reset'],
	'TP_VER_INFO' => TP_LINK_VER
));

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>