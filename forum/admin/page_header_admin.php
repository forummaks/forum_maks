<?php
$page_title = '';

$do_gzip_compress = false;
if ( $ft_cfg['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

$template->set_filenames(array(
	'header' => 'admin/page_header.tpl')
);

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $ft_cfg['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $ft_cfg['board_timezone'])] : $lang[number_format($ft_cfg['board_timezone'])];

//
// The following assigns all _common_ variables that may be used at any point
// in a template. Note that all URL's should be wrapped in append_sid, as
// should all S_x_ACTIONS for forms.
//
$template->assign_vars(array(
	'SITENAME' => $ft_cfg['sitename'],
	'PAGE_TITLE' => $page_title,

	'L_ADMIN' => $lang['Admin'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $ft_cfg['sitename']),
	'L_FAQ' => $lang['FAQ'],

	'U_INDEX' => append_sid('../index.php'),

	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('../login.php'),
	'S_JUMPBOX_ACTION' => append_sid('../viewforum.php'),
	'S_CURRENT_TIME' => sprintf($lang['Current_time'], create_date($ft_cfg['default_dateformat'], time(), $ft_cfg['board_timezone'])),
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
));

$template->pparse('header');