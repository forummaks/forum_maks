<?php

@define('IN_PHPBB', 1);

if (!empty($setmodules))
{
	$filename = basename(__FILE__);
	$module['General']['PHP Info'] = $filename;
	return;
}

// Load default header
$phpbb_root_path = '../';
require($phpbb_root_path .'extension.inc');
require('pagestart.'. $phpEx);

phpinfo();

include('./page_footer_admin.'. $phpEx);

?>