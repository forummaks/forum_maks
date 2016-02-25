<?php
if (!empty($setmodules))
{
	$module['TorrentPier']['Tracker_Config'] = basename(__FILE__);
	return;
}

// Load default header & language
require('./pagestart.php');
require(FT_ROOT .'includes/functions_admin_torrent.php');

$cache_dir = FT_ROOT .'cache/';
$tr_cfg_cache_file = $cache_dir .'tracker_config.php';

if (file_exists(@phpbb_realpath(FT_ROOT .'language/lang_'. $ft_cfg['default_lang'] .'/lang_admin_bt.php')))
{
	require(FT_ROOT .'language/lang_'. $ft_cfg['default_lang'] .'/lang_admin_bt.php');
}
else
{
	require(FT_ROOT .'language/lang_english/lang_admin_bt.php');
}

$cfg = array();

$submit       = (isset($_POST['submit'])) ? TRUE : FALSE;
$confirm      = (isset($_POST['confirm'])) ? TRUE : FALSE;
$set_defaults = (isset($_POST['set_defaults'])) ? TRUE : FALSE;

// All config names with default values
$default_cfg_str = array(
	'off_reason'                   => 'Tracker is disabled',
	'auth_key_name'                => 'uk',
	'browser_redirect_url'         => 'http://yourdomain.com/'
);

$default_cfg_bool = array(
	'autoclean'                    => 1,
	'off'                          => 0,
	'off_show_reason'              => 1,
	'bt_debug'                     => 0,
	'silent_mode'                  => 0,
	'do_gzip'                      => 0,
	'force_gzip'                   => 0,
	'client_compat_gzip'           => 1,
	'ignor_given_ip'               => 1,
	'allow_host_ip'                => 0,
	'ignor_numwant'                => 1,
	'compact_mode'                 => 0,
	'use_auth_key'                 => 1,
	'update_users_dl_status'       => 1,
	'update_users_compl_status'    => 1,
	'allow_guest_dl'               => 0,
	'upd_user_up_down_stat'        => 1,
	'limit_active_tor'             => 0,
	'limit_concurrent_ips'         => 0
);

$default_cfg_num = array(
	'last_clean_time'              => 0,
	'numwant'                      => 50,
	'numwant_max'                  => 100,
	'autoclean_interval'           => 120,
	'min_ann_intv'                 => 1200,
	'expire_factor'                => 3,
	'seed_last_seen_upd_interval'  => 300,
	'user_statistic_upd_interval'  => 25,
	'limit_seed_count'             => 20,
	'limit_leech_count'            => 4,
	'leech_expire_factor'          => 60,
	'limit_seed_ips'               => 0,
	'limit_leech_ips'              => 2
);

$default_cfg = array_merge($default_cfg_str, $default_cfg_bool, $default_cfg_num);

// Set defaults
if ($set_defaults && $confirm)
{
	foreach ($default_cfg as $config_name => $config_value)
	{
		$sql = 'UPDATE '. BT_CONFIG_TABLE ." SET
			config_value = '$config_value'
			WHERE config_name = '$config_name'";

		if(!DB()->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Failed to update configuration for $config_name", '', __LINE__, __FILE__, $sql);
		}
	}

	$message = $lang['config_upd'] .'<br /><br />'. sprintf($lang['return_config'], '<a href="'. append_sid("admin_bt_tracker_cfg.php") .'">', '</a>') .'<br /><br />'. sprintf($lang['Click_return_admin_index'], '<a href="'. append_sid("index.php?pane=right") .'">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

// Get config
$cfg = get_config_ary(BT_CONFIG_TABLE);

// Update config if submit
if ($submit && $confirm)
{
	update_config_table (BT_CONFIG_TABLE, $default_cfg_str,  $cfg, 'str');
	update_config_table (BT_CONFIG_TABLE, $default_cfg_bool, $cfg, 'bool');
	update_config_table (BT_CONFIG_TABLE, $default_cfg_num,  $cfg, 'num');

	$message = $lang['config_upd'];

	if (file_exists($tr_cfg_cache_file))
	{
		$message .= '<br /><br />';
		$message .= (@unlink($tr_cfg_cache_file)) ? 'Config cache deleted successfully' : "Can't delete cache file <b>$tr_cfg_cache_file</b>";
	}

	$message .= '<br /><br />'. sprintf($lang['return_config'], '<a href="'. append_sid("admin_bt_tracker_cfg.php") .'">', '</a>') .'<br /><br />'. sprintf($lang['Click_return_admin_index'], '<a href="'. append_sid("index.php?pane=right") .'">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

// Set template vars
set_tpl_vars      ($default_cfg_str, $cfg);
set_tpl_vars_lang ($default_cfg_str);

set_tpl_vars_bool ($default_cfg_bool, $cfg);
set_tpl_vars_lang ($default_cfg_bool);

set_tpl_vars      ($default_cfg_num, $cfg);
set_tpl_vars_lang ($default_cfg_num);

$template->assign_vars(array(
	'L_CONFIGURATION_TITLE' => $lang['tracker_cfg_title'],
	'L_TRACKER_SETTINGS'    => $lang['tracker_settings'],
	'L_SET_DEFAULTS'        => $lang['set_defaults'],

	'S_HIDDEN_FIELDS' => '',
	'S_CONFIG_ACTION' => append_sid("admin_bt_tracker_cfg.php"),

	'L_CONFIRM'   => $lang['Confirm'],
	'L_SUBMIT'    => $lang['Submit'],
	'L_RESET'     => $lang['Reset'],
	'TP_VER_INFO' => TP_LINK_VER
	)
);

$template->set_filenames(array('body' => 'admin/bt_tracker_cfg_body.tpl'));

$template->pparse("body");

require('./page_footer_admin.php');