<?php
define('IN_ADMIN', true);
define('FT_ROOT', './../');
require(FT_ROOT . 'common.php');

$user->session_start();

if (IS_GUEST)
{
	redirect(LOGIN_URL . "?redirect=admin/index.php");
}

if (!IS_ADMIN)
{
	die($lang['NOT_ADMIN']);
}

if (!$userdata['session_admin'])
{
	$redirect = url_arg($_SERVER['REQUEST_URI'], 'admin', 1);
	redirect("login.php?redirect=$redirect");
}

if (empty($no_page_header))
{
	require('./page_header_admin.php');
}