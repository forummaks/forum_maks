<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_tail.php,v 1.27.2.3 2004/12/22 02:04:00 psotfx Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//
// Show the overall footer.
//
$admin_link = ( @$userdata['user_level'] == ADMIN ) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);

$template->assign_vars(array(
	//bt
	'TP_INFO' => TP_LINK,
	//bt end
	'MODIFIED_BY' => $lang['Mod_Mavrick'],
	'TRANSLATION_INFO' => ( isset($lang['TRANSLATION_INFO']) ) ? $lang['TRANSLATION_INFO'] : '',
	'ADMIN_LINK' => $admin_link)
);

$template->pparse('overall_footer');

//
// Close our DB connection.
//
$db->sql_close();

// generation time
if (@$userdata['session_logged_in'] && $userdata['user_level'] > USER)
{
	$gen_time = sprintf('%.2f', (array_sum(explode(' ', microtime())) - $starttime));
	$gzip_text = ($board_config['gzip_compress']) ? 'GZIP enabled' : 'GZIP disabled';
	$debug_text = (DEBUG == 1) ? 'Debug on' : 'Debug off';

	echo '<div class="copyright" style="margin: 6px; color: 000" align="center">[ &nbsp;Execution time: '. $gen_time .' sec &nbsp;|&nbsp; MySQL: '. $db->num_queries .' queries used &nbsp;|&nbsp; '. $gzip_text .' &nbsp;]</div>';
}

//
// Compress buffered output if required and send to browser
//
if ( @$do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

exit;

?>