<?php
//
// Show the overall footer.
//
$template->set_filenames(array(
	'page_footer' => 'admin/page_footer.tpl')
);

$template->assign_vars(array(
	'PHPBB_VERSION' => ($userdata['user_level'] == ADMIN && $userdata['user_id'] != GUEST_UID) ? '2' . $ft_cfg['version'] : '',
	'TRANSLATION_INFO' => @$lang['TRANSLATION_INFO'])
);

$template->pparse('page_footer');

//
// Close our DB connection.
//
//DB()->sql_close();

//
// Compress buffered output if required
// and send to browser
//
if( @$do_gzip_compress )
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