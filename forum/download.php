<?php
define('IN_FORUM', true);
define('FT_SCRIPT', 'download');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$download_id = get_var('id', 0);
$thumbnail = get_var('thumb', 0);

// Send file to browser
function send_file_to_browser($attachment, $upload_dir)
{
	global $_SERVER, $HTTP_USER_AGENT, $HTTP_SERVER_VARS, $lang,  $attach_config;

	$filename = ($upload_dir == '') ? $attachment['physical_filename'] : $upload_dir . '/' . $attachment['physical_filename'];

	$gotit = FALSE;

	if (!intval($attach_config['allow_ftp_upload']))
	{
		if (@!file_exists(@amod_realpath($filename)))
		{
			message_die(GENERAL_ERROR, $lang['Error_no_attachment'] . "<br /><br /><b>404 File Not Found:</b> The File <i>" . $filename . "</i> does not exist.");
		}
		else
		{
			$gotit = TRUE;
		}
	}

	// Correct the mime type - we force application/octetstream for all files, except images
	// Please do not change this, it is a security precaution
	if (!strstr($attachment['mimetype'], 'image'))
	{
		$attachment['mimetype'] = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
	}

	//bt
	require_once(FT_ROOT .'includes/functions_torrent.php');
	send_torrent_with_passkey($filename);
	//bt end

	// Now the tricky part... let's dance
//	@ob_end_clean();
//	@ini_set('zlib.output_compression', 'Off');
	header('Pragma: public');
//	header('Content-Transfer-Encoding: none');

	// Send out the Headers
	header('Content-Type: ' . $attachment['mimetype'] . '; name="' . clean_filename($attachment['real_filename']) . '"');
	header('Content-Disposition: inline; filename="' . clean_filename($attachment['real_filename']) . '"');

	//
	// Now send the File Contents to the Browser
	//
	if ($gotit)
	{
		$size = @filesize($filename);
		if ($size)
		{
			header("Content-length: $size");
		}
		readfile($filename);
	}
	else if (!$gotit && intval($attach_config['allow_ftp_upload']))
	{
		$conn_id = attach_init_ftp();

		$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

		$tmp_path = ( !@$ini_val('safe_mode') ) ? '/tmp' : $upload_dir . '/tmp';
		$tmp_filename = @tempnam($tmp_path, 't0000');

		@unlink($tmp_filename);

		$mode = FTP_BINARY;
		if ( (preg_match("/text/i", $attachment['mimetype'])) || (preg_match("/html/i", $attachment['mimetype'])) )
		{
			$mode = FTP_ASCII;
		}

		$result = @ftp_get($conn_id, $tmp_filename, $filename, $mode);

		if (!$result)
		{
			message_die(GENERAL_ERROR, $lang['Error_no_attachment'] . "<br /><br /><b>404 File Not Found:</b> The File <i>" . $filename . "</i> does not exist.");
		}

		@ftp_quit($conn_id);

		$size = @filesize($tmp_filename);
		if ($size)
		{
			header("Content-length: $size");
		}
		readfile($tmp_filename);
		@unlink($tmp_filename);
	}
	else
	{
		message_die(GENERAL_ERROR, $lang['Error_no_attachment'] . "<br /><br /><b>404 File Not Found:</b> The File <i>" . $filename . "</i> does not exist.");
	}

	exit;
}
//
// End Functions
//

//
// Start Session Management
//
$user->session_start();

if (!$download_id)
{
	message_die(GENERAL_ERROR, $lang['No_attachment_selected']);
}

if ($attach_config['disable_mod'] && $userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, $lang['Attachment_feature_disabled']);
}

$sql = 'SELECT at.*, btt.topic_check_status
   FROM ' . ATTACHMENTS_DESC_TABLE . ' at
   LEFT JOIN '.BT_TORRENTS_TABLE.' btt on btt.attach_id=at.attach_id
   WHERE at.attach_id = ' . $download_id;

if (!($result = DB()->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query attachment informations', '', __LINE__, __FILE__, $sql);
}

if (!($attachment = DB()->sql_fetchrow($result)))
{
	message_die(GENERAL_MESSAGE, $lang['Error_no_attachment']);
}

$attachment['physical_filename'] = basename($attachment['physical_filename']);

DB()->sql_freeresult($result);

// get forum_id for attachment authorization or private message authorization
$authorised = false;

$sql = 'SELECT *
	FROM ' . ATTACHMENTS_TABLE . '
	WHERE attach_id = ' . $attachment['attach_id'];

if (!($result = DB()->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query attachment informations', '', __LINE__, __FILE__, $sql);
}

$auth_pages = DB()->sql_fetchrowset($result);
$num_auth_pages = DB()->num_rows($result);

for ($i = 0; $i < $num_auth_pages && $authorised == false; $i++)
{
	if (intval($auth_pages[$i]['post_id']) != 0)
	{
		$sql = 'SELECT forum_id
			FROM ' . POSTS_TABLE . '
			WHERE post_id = ' . $auth_pages[$i]['post_id'];

		if ( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query post information', '', __LINE__, __FILE__, $sql);
		}

		$row = DB()->sql_fetchrow($result);

		$forum_id = $row['forum_id'];

		$is_auth = array();
		$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

		if ($is_auth['auth_download'])
		{
			$authorised = TRUE;
		}
	}
	else
	{
		if ( (intval($attach_config['allow_pm_attach'])) && ( ($userdata['user_id'] == $auth_pages[$i]['user_id_2']) || ($userdata['user_id'] == $auth_pages[$i]['user_id_1']) ) || ($userdata['user_level'] == ADMIN) )
		{
			$authorised = TRUE;
		}
	}
}


if (!$authorised)
{
	message_die(GENERAL_MESSAGE, $lang['Sorry_auth_view_attach']);
}

if ($thumbnail)
{
	$attachment['physical_filename'] = THUMB_DIR . '/t_' . $attachment['physical_filename'];
}

//
// Update download count
//
if (!$thumbnail)
{
	$sql = 'UPDATE ' . ATTACHMENTS_DESC_TABLE . '
	SET download_count = download_count + 1
	WHERE attach_id = ' . $attachment['attach_id'];

	if (!DB()->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update attachment download count', '', __LINE__, __FILE__, $sql);
	}
}

//
// Determine the 'presenting'-method
//
if ($download_mode == PHYSICAL_LINK)
{
	$server_protocol = ($ft_cfg['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($ft_cfg['server_name']));
	$server_port = ($ft_cfg['server_port'] <> 80) ? ':' . trim($ft_cfg['server_port']) : '';
	$script_name = preg_replace('/^\/?(.*?)\/?$/', '/\1', trim($ft_cfg['script_path']));

	if ($script_name[strlen($script_name)] != '/')
	{
		$script_name .= '/';
	}

	if (intval($attach_config['allow_ftp_upload']))
	{
		if (trim($attach_config['download_path']) == '')
		{
			message_die(GENERAL_ERROR, 'Physical Download not possible with the current Attachment Setting');
		}

		$url = trim($attach_config['download_path']) . '/' . $attachment['physical_filename'];
		$redirect_path = $url;
	}
	else
	{
		$url = $upload_dir . '/' . $attachment['physical_filename'];
//		$url = preg_replace('/^\/?(.*?\/)?$/', '\1', trim($url));
		$redirect_path = $server_protocol . $server_name . $server_port . $script_name . $url;
	}

	// Redirect via an HTML form for PITA webservers
	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')))
	{
		header('Refresh: 0; URL=' . $redirect_path);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $redirect_path . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $redirect_path . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $redirect_path);
	exit;
}
else
{
	if (intval($attach_config['allow_ftp_upload']))
	{
		// We do not need a download path, we are not downloading physically
		send_file_to_browser($attachment, '');
		exit;
	}
	else
	{
		if (in_array($attachment['topic_check_status'], array(4, 5)))
		{
			message_die(GENERAL_ERROR, "<br /><b>������ torrent ��������� �� ���������.</b>");
		}else{
			send_file_to_browser($attachment, $upload_dir);
		}
		exit;
	}
}