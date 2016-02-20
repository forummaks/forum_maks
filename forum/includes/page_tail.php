<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

global $ft_cfg, $userdata, $template, $lang;

if (!empty($template))
{
	$admin_link = ( @$userdata['user_level'] == ADMIN ) ? '<a href="admin/index.php?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';
	
	$template->assign_vars(array(
		'SIMPLE_FOOTER'    	=> !empty($gen_simple_header),
		'TP_INFO' 			=> TP_LINK,
		'MODIFIED_BY' 		=> $lang['Mod_Mavrick'],
		'TRANSLATION_INFO' 	=> ( isset($lang['TRANSLATION_INFO']) ) ? $lang['TRANSLATION_INFO'] : '',
		'ADMIN_LINK' 		=> $admin_link
	));
	
	$template->set_filenames(array('overall_footer' => 'overall_footer.tpl'));
	$template->pparse('overall_footer');
}

//$db->sql_close();

if(!$ft_cfg['gzip_compress'])
{
	flush();
}

// generation time
if (@$userdata['session_logged_in'] && $userdata['user_level'] > USER)
{
	$gen_time = utime() - TIMESTART;
	$gen_time_txt = sprintf('%.3f', $gen_time);
	$gzip_text = ($ft_cfg['gzip_compress']) ? 'GZIP enabled' : 'GZIP disabled';
	$debug_text = (DEBUG == 1) ? 'Debug on' : 'Debug off';

	echo '<div class="copyright" style="margin: 6px; color: 000" align="center">[ &nbsp;Execution time: '. $gen_time_txt .' sec &nbsp;|&nbsp; MySQL: '. $db->num_queries .' queries used &nbsp;|&nbsp; '. $gzip_text .' &nbsp;]</div>';
}

if (defined('REQUESTED_PAGE') && !defined('DISABLE_CACHING_OUTPUT'))
{
	if (ANONYMOUS === true)
	{
		caching_output(true, 'store', REQUESTED_PAGE .'_guest_'. $ft_cfg['default_lang']);
	}
}

ft_exit();