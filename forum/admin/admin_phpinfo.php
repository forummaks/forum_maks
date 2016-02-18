<?php
if (!empty($setmodules))
{
	$module['General']['PHP Info'] = basename(__FILE__);
	return;
}

require('./pagestart.php');

phpinfo();

include('./page_footer_admin.php');