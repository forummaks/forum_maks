<?php
define('FT_SCRIPT', 'login');
define('IN_LOGIN', true);
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

array_deep($_POST, 'trim');

$user->session_start();

// Logout
if (!empty($_GET['logout']))
{
	if (!IS_GUEST)
	{
		$user->session_end();
	}
	redirect("index.php");
}

$redirect_url = "index.php";
$login_errors = array();

// Requested redirect
if (preg_match('/^redirect=([a-z0-9\.#\/\?&=\+\-_]+)/si', $_SERVER['QUERY_STRING'], $matches))
{
	$redirect_url = $matches[1];
	if (!strstr($redirect_url, '?') && $first_amp = strpos($redirect_url, '&'))
	{
		$redirect_url[$first_amp] = '?';
	}
}
elseif (!empty($_POST['redirect']))
{
	$redirect_url = str_replace('&amp;', '&', htmlspecialchars($_POST['redirect']));
}
elseif (!empty($_SERVER['HTTP_REFERER']) && ($parts = @parse_url($_SERVER['HTTP_REFERER'])))
{
	$redirect_url = (isset($parts['path']) ? $parts['path'] : "index.php") . (isset($parts['query']) ? '?'. $parts['query'] : '');
}

$redirect_url = str_replace('&admin=1', '', $redirect_url);
$redirect_url = str_replace('?admin=1', '', $redirect_url);

if (!$redirect_url || strstr(urldecode($redirect_url), "\n") || strstr(urldecode($redirect_url), "\r") || strstr(urldecode($redirect_url), ';url'))
{
	$redirect_url = "index.php";
}

$redirect_url = str_replace("&sid={$user->data['session_id']}", '', $redirect_url);

if (isset($_REQUEST['admin']) && !IS_AM) die($lang['NOT_ADMIN']);

$mod_admin_login = (IS_AM && !$user->data['session_admin']);

// login username & password
$login_username = ($mod_admin_login) ? $userdata['username'] : (isset($_POST['login_username']) ? $_POST['login_username'] : '');
$login_password = isset($_POST['login_password']) ? $_POST['login_password'] : '';

// Проверка на неверную комбинацию логин/пароль
$need_captcha = false;
if (!$mod_admin_login)
{
	$need_captcha = CACHE('ft_login_err')->get('l_err_'. USER_IP);
	if ($need_captcha < $ft_cfg['invalid_logins']) $need_captcha = false;
}

// login
if (isset($_POST['login']))
{
	if (!$mod_admin_login)
	{
		if (!IS_GUEST)
		{
			redirect('index.php');
		}
		if ($login_username == '' || $login_password == '')
		{
			$login_errors[] = $lang['ENTER_PASSWORD'];
		}
	}
	
	if (!$login_errors)
	{
		if ($user->login($_POST, $mod_admin_login))
		{
			$redirect_url = (defined('FIRST_LOGON')) ? $ft_cfg['first_logon_redirect_url'] : $redirect_url;
			// Обнуление при введении правильно комбинации логин/пароль
			CACHE('ft_login_err')->set('l_err_'. USER_IP, 0, 3600);
			
			if ($redirect_url == '/' . LOGIN_URL || $redirect_url == LOGIN_URL) $redirect_url = 'index.php';
			redirect($redirect_url);
		}
		
		$login_errors[] = $lang['ERROR_LOGIN'];
		
		if (!$mod_admin_login)
		{
			$login_err = CACHE('ft_login_err')->get('l_err_'. USER_IP);
			if ($login_err > $ft_cfg['invalid_logins']) $need_captcha = true;
			if ($login_err > 50)
			{
				// блокировка IP
			}
			CACHE('ft_login_err')->set('l_err_'. USER_IP, ($login_err + 1), 3600);
		}
		else $need_captcha = false;
	}
}

// Login page
if (IS_GUEST || $mod_admin_login)
{
	$template->assign_vars(array(
		'LOGIN_USERNAME'  => htmlCHR($login_username),
		'LOGIN_PASSWORD'  => htmlCHR($login_password),
		'ERROR_MESSAGE'   => join('<br />', $login_errors),
		'ADMIN_LOGIN'     => $mod_admin_login,
		'REDIRECT_URL'    => htmlCHR($redirect_url),
		'PAGE_TITLE'      => $lang['LOGIN'],
		'S_LOGIN_ACTION'  => LOGIN_URL,
	));
	
}
redirect($redirect_url);

/*
// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

if( isset($HTTP_POST_VARS['login']) || isset($HTTP_GET_VARS['login']) || isset($HTTP_POST_VARS['logout']) || isset($HTTP_GET_VARS['logout']) )
{
	if( ( isset($HTTP_POST_VARS['login']) || isset($HTTP_GET_VARS['login']) ) && (!$userdata['session_logged_in'] || isset($HTTP_POST_VARS['admin'])) )
	{
		$username = isset($HTTP_POST_VARS['username']) ? clean_username($HTTP_POST_VARS['username']) : '';
		$password = isset($HTTP_POST_VARS['password']) ? $HTTP_POST_VARS['password'] : '';

		$sql = "SELECT user_id, username, user_password, user_active, user_level
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\\'", "''", $username) . "'";
		if ( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}

		if( $row = DB()->sql_fetchrow($result) )
		{
			if( $row['user_level'] != ADMIN && $ft_cfg['board_disable'] )
			{
				redirect(append_sid("index.php", true));
			}
			else
			{
				if( md5($password) == $row['user_password'] && $row['user_active'] )
				{
					$autologin = ( isset($HTTP_POST_VARS['autologin']) ) ? TRUE : 0;

					$admin = (isset($HTTP_POST_VARS['admin'])) ? 1 : 0;
					$session_id = session_begin($row['user_id'], $user_ip, FALSE, $autologin, $admin);

					if( $session_id )
					{
						$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.php";
						redirect(append_sid($url, true));
					}
					else
					{
						message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
					}
				}
				else
				{
					$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : '';
					$redirect = str_replace('?', '&', $redirect);
					if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
					{
						message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
					}

					$template->assign_vars(array(
						'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.php?redirect=$redirect\">")
					);

					$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.php?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.php") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
			}
		}
		else
		{
			$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "";
			$redirect = str_replace("?", "&", $redirect);
			if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
			{
				message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
			}

			$template->assign_vars(array(
				'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.php?redirect=$redirect\">")
			);

			$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.php?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.php") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else if( ( isset($HTTP_GET_VARS['logout']) || isset($HTTP_POST_VARS['logout']) ) && $userdata['session_logged_in'] )
	{
		if( $userdata['session_logged_in'] )
		{
			session_end($userdata['session_id'], $userdata['user_id']);
		}

		if (!empty($HTTP_POST_VARS['redirect']) || !empty($HTTP_GET_VARS['redirect']))
		{
			$url = (!empty($HTTP_POST_VARS['redirect'])) ? htmlspecialchars($HTTP_POST_VARS['redirect']) : htmlspecialchars($HTTP_GET_VARS['redirect']);
			$url = str_replace('&amp;', '&', $url);
			redirect(append_sid($url, true));
		}
		else
		{
			redirect(append_sid("index.php", true));
		}
	}
	else
	{
		$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.php";
		redirect(append_sid($url, true));
	}
}
else
{
	//
	// Do a full login page dohickey if
	// user not already logged in
	//
	$forward_page = '';

	if( !$userdata['session_logged_in'] || (isset($HTTP_GET_VARS['admin']) && $userdata['session_logged_in'] && $userdata['user_level'] == ADMIN))
	{
		$page_title = $lang['Login'];
		require(FT_ROOT . 'includes/page_header.php');

		$template->set_filenames(array(
			'body' => 'login_body.tpl')
		);

		if( isset($HTTP_POST_VARS['redirect']) || isset($HTTP_GET_VARS['redirect']) )
		{
			$forward_to = $HTTP_SERVER_VARS['QUERY_STRING'];

			if( preg_match("/^redirect=([a-z0-9\.#\/\?&=\+\-_]+)/si", $forward_to, $forward_matches) )
			{
				$forward_to = ( !empty($forward_matches[3]) ) ? $forward_matches[3] : $forward_matches[1];
				$forward_match = explode('&', $forward_to);

				if(count($forward_match) > 1)
				{
					$forward_page = '';

					for($i = 1; $i < count($forward_match); $i++)
					{
						if( !preg_match("sid=", $forward_match[$i]) )
						{
							if( $forward_page != '' )
							{
								$forward_page .= '&';
							}
							$forward_page .= $forward_match[$i];
						}
					}
					$forward_page = $forward_match[0] . '?' . $forward_page;
				}
				else
				{
					$forward_page = $forward_match[0];
				}
			}
		}
		else
		{
			$forward_page = '';
		}

		$username = ( $userdata['user_id'] != GUEST_UID ) ? $userdata['username'] : '';

		$s_hidden_fields = '<input type="hidden" name="redirect" value="' . $forward_page . '" />';
		$s_hidden_fields .= (isset($HTTP_GET_VARS['admin'])) ? '<input type="hidden" name="admin" value="1" />' : '';

		$template->assign_vars(array(
			'USERNAME' => $username,

			'L_ENTER_PASSWORD' => (isset($HTTP_GET_VARS['admin'])) ? $lang['Admin_reauthenticate'] : $lang['Enter_password'],
			'L_SEND_PASSWORD' => $lang['FORGOTTEN_PASSWORD'],

			'U_SEND_PASSWORD' => append_sid("profile.php?mode=sendpassword"),

			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);

		$template->pparse('body');

		require(FT_ROOT . 'includes/page_tail.php');
	}
	else
	{
		redirect(append_sid("index.php", true));
	}

}*/