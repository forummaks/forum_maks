<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

function get_torrent_info ($attach_id)
{
	global $db;

	$attach_id = intval($attach_id);

	$sql = 'SELECT a.post_id, a.privmsgs_id, d.physical_filename, d.extension, d.tracker_status, t.topic_first_post_id, p.poster_id, p.topic_id, p.forum_id, f.allow_reg_tracker
		FROM '. ATTACHMENTS_TABLE .' a, '. ATTACHMENTS_DESC_TABLE .' d, '. POSTS_TABLE .' p, '. TOPICS_TABLE .' t, '. FORUMS_TABLE ." f
		WHERE a.attach_id = $attach_id
			AND d.attach_id = $attach_id
			AND p.post_id = a.post_id
			AND t.topic_id = p.topic_id
			AND f.forum_id = p.forum_id
		LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query torrent information', '', __LINE__, __FILE__, $sql);
	}

	if (!$torrent = $db->sql_fetchrow($result))
	{
		message_die(GENERAL_ERROR, 'Invalid attach_id');
	}

	$db->sql_freeresult($result);

	return $torrent;
}

function torrent_auth_check ($forum_id, $poster_id)
{
	global $userdata, $lang, $attach_config;

	if ($userdata['user_level'] == ADMIN)
	{
		return TRUE;
	}
	else
	{
		$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

		if ($poster_id != $userdata['user_id'] && !$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}
		else if (!$is_auth['auth_view'] || !$is_auth['auth_attachments'] || $attach_config['disable_mod'])
		{
			$message = sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);
			message_die(GENERAL_MESSAGE, $message);
		}

		return $is_auth;
	}
}

function tracker_unregister ($attach_id, $mode = '')
{
	global $db, $lang, $ft_cfg;

	$attach_id = intval($attach_id);
	$torrent = array();
	$post_id = $topic_id = $forum_id = '';


	if ($torrent = get_torrent_info($attach_id))
	{
		$post_id  = $torrent['post_id'];
		$topic_id = $torrent['topic_id'];
		$forum_id = $torrent['forum_id'];
	}

	if ($mode == 'request')
	{
		if (!$torrent)
		{
			message_die(GENERAL_ERROR, 'Torrent not found');
		}

		if (!$torrent['tracker_status'])
		{
			message_die(GENERAL_ERROR, 'Torrent already unregistered');
		}

		torrent_auth_check($forum_id, $torrent['poster_id']);
	}

	// Unset DL-Type for topic
	if ($ft_cfg['bt_unset_dltype_on_tor_unreg'])
	{
		if (!$topic_id)
		{
			$sql = 'SELECT topic_id
				FROM '. BT_TORRENTS_TABLE ."
				WHERE attach_id = $attach_id";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not query torrent information', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$topic_id = $row['topic_id'];
			}
		}

		if ($topic_id)
		{
			$sql = 'UPDATE '. TOPICS_TABLE .' SET
					topic_dl_type = '. TOPIC_DL_TYPE_NORMAL ."
				WHERE topic_id = $topic_id
				LIMIT 1";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	$sql = 'DELETE FROM '. BT_TORRENTS_TABLE ."
		WHERE attach_id = $attach_id";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete torrent from torrents table', '', __LINE__, __FILE__, $sql);
	}

	$sql = 'DELETE FROM '. BT_TOR_DL_STAT_TABLE ."
		WHERE attach_id = $attach_id";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete torrent dl-stat', '', __LINE__, __FILE__, $sql);
	}

	$sql = 'UPDATE '. ATTACHMENTS_DESC_TABLE ." SET
			tracker_status = 0
		WHERE attach_id = $attach_id";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update torrent status', '', __LINE__, __FILE__, $sql);
	}

	if ($mode == 'request')
	{
		exit_redirect($lang['Bt_Deleted'], $post_id, $forum_id);
	}
}

function delete_torrent ($attach_id, $mode = '')
{
	global $lang, $userdata;
	global $reg_mode, $topic_id;

	$attach_id = intval($attach_id);
	$reg_mode = $mode;

	if (!$torrent = get_torrent_info($attach_id))
	{
		message_die(GENERAL_ERROR, 'Torrent not found');
	}

	$post_id   = $torrent['post_id'];
	$topic_id  = $torrent['topic_id'];
	$forum_id  = $torrent['forum_id'];
	$poster_id = $torrent['poster_id'];

	if ($torrent['extension'] !== TORRENT_EXT)
	{
		message_die(GENERAL_ERROR, $lang['Not_torrent']);
	}

	torrent_auth_check($forum_id, $torrent['poster_id']);
	tracker_unregister($attach_id);
	delete_attachment(0, $attach_id);

	return;
}

function tracker_register ($attach_id, $mode = '')
{
	global $db, $template, $attach_config, $ft_cfg, $lang, $return_message;
	global $reg_mode;

	$template->assign_vars(array('META' => ''));
	$attach_id = intval($attach_id);
	$reg_mode = $mode;

	if (!$torrent = get_torrent_info($attach_id))
	{
		message_die(GENERAL_ERROR, 'Torrent not found');
	}

	$post_id   = $torrent['post_id'];
	$topic_id  = $torrent['topic_id'];
	$forum_id  = $torrent['forum_id'];
	$poster_id = $torrent['poster_id'];

	if ($torrent['extension'] !== TORRENT_EXT)
	{
		torrent_error_exit($lang['Not_torrent']);
	}

	if ($torrent['privmsgs_id'])
	{
		torrent_error_exit('Not allowed in PM');
	}

	if (!$torrent['allow_reg_tracker'])
	{
		torrent_error_exit($lang['Reg_not_allowed_in_this_forum']);
	}

	if ($post_id != $torrent['topic_first_post_id'])
	{
		torrent_error_exit($lang['Allowed_only_1st_post_reg']);
	}

	if ($torrent['tracker_status'])
	{
		torrent_error_exit($lang['Already_reg']);
	}

	if ($this_topic_torrents = get_registered_torrents($topic_id, 'topic'))
	{
		torrent_error_exit($lang['Only_1_tor_per_topic']);
	}

	torrent_auth_check($forum_id, $torrent['poster_id']);

	$filename = FT_ROOT . $attach_config['upload_dir'] .'/'. $torrent['physical_filename'];

	if (!is_file($filename))
	{
		torrent_error_exit('File name error');
	}

	if (!file_exists($filename))
	{
		torrent_error_exit('File not exists');
	}

	if (!$tor = bdecode_file($filename))
	{
		torrent_error_exit('This is not a bencoded file');
	}

	if ($ft_cfg['bt_check_announce_url'])
	{
		require_once(FT_ROOT .'includes/torrent_announce_urls.php');

		$ann = (@$tor['announce']) ? $tor['announce'] : '';
		$announce_urls['main_url'] = $ft_cfg['bt_announce_url'];

		if (!$ann || !in_array($ann, $announce_urls))
		{
			$mess = sprintf($lang['Invalid_ann_url'], htmlspecialchars($ann), $announce_urls['main_url']);
			torrent_error_exit($mess);
		}
	}

	$info = (@$tor['info']) ? $tor['info'] : array();

	if (!@$info['name'] || !@$info['piece length'] || !@$info['pieces'] || strlen($info['pieces']) % 20 != 0)
	{
		torrent_error_exit('Invalid torrent file');
	}

	$totallen = floatval(0);

	if (@$info['length'])
	{
		$totallen += $info['length'];
	}
	else if (@$info['files'] && is_array($info['files']))
	{
		foreach ($info['files'] as $fn => $f)
		{
			$totallen += $f['length'];
		}
	}
	else
	{
		torrent_error_exit('Invalid torrent file');
	}

	$size = sprintf('%.0f', $totallen);
	$piece_length = sprintf('%.0f', floatval($info['piece length']));

	$reg_time = time();

	$info_hash     = pack("H*", sha1(bencode($info)));
	$info_hash_md5 = strtolower(md5($info_hash));
	$info_hash_sql = rtrim(bt_sql_esc($info_hash), ' ');

	$columns = ' info_hash,       post_id,  poster_id,  topic_id,  attach_id,   size,    piece_length,   reg_time';
	$values = "'$info_hash_sql', $post_id, $poster_id, $topic_id, $attach_id, '$size', '$piece_length', $reg_time";

	$sql = 'INSERT INTO '. BT_TORRENTS_TABLE ." ($columns) VALUES ($values)";

	if (!$db->sql_query($sql))
	{
		$sql_error = $db->sql_error();

		if ($sql_error['code'] == 1062) // Duplicate entry
		{
			torrent_error_exit($lang['Bt_Reg_fail_same_hash']);
		}

		message_die(GENERAL_ERROR, 'Could not register torrent on tracker', '', __LINE__, __FILE__, $sql);
	}

/*
	// Insert empty up/down "statistic record" for guests
	$torrent_id = $db->sql_nextid();
	$guest_uid  = GUEST_UID;

	$columns = 'torrent_id,  user_id,    attach_id, t_up_total, t_down_total';
	$values = "$torrent_id, $guest_uid, $attach_id, 0,          0";

	$sql = 'INSERT INTO '. BT_TOR_DL_STAT_TABLE ." ($columns) VALUES ($values)";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not insert empty statistic record for guests', '', __LINE__, __FILE__, $sql);
	}
*/

	// update tracker status for this attachment
	$sql = 'UPDATE '. ATTACHMENTS_DESC_TABLE ." SET
			tracker_status = 1
		WHERE attach_id = $attach_id
		LIMIT 1";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update torrent status', '', __LINE__, __FILE__, $sql);
	}

	// set DL-Type for topic
	if ($ft_cfg['bt_set_dltype_on_tor_reg'])
	{
		$sql = 'UPDATE '. TOPICS_TABLE .' SET
				topic_dl_type = '. TOPIC_DL_TYPE_DL ."
			WHERE topic_id = $topic_id
			LIMIT 1";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}
	}

	if ($reg_mode == 'request' || $reg_mode == 'newtopic')
	{
		$mess = sprintf($lang['Bt_Registered'], append_sid("download.php?id=$attach_id"));
		exit_redirect($mess, $post_id, $forum_id);
	}

	return;
}

function send_torrent_with_passkey ($filename)
{
	global $attachment, $auth_pages, $db, $userdata, $ft_cfg, $lang;

	if (!$ft_cfg['bt_add_auth_key'] || $attachment['extension'] !== TORRENT_EXT || !$size = @filesize($filename))
	{
		return;
	}

	$post_id   = '';
	$user_id   = $userdata['user_id'];
	$attach_id = $attachment['attach_id'];

	// Get tracker config
	$sql = 'SELECT *
		FROM '. BT_CONFIG_TABLE ."
		WHERE config_name = 'auth_key_name'
			OR  config_name = 'allow_guest_dl'";

	if (!$rowset = @$db->sql_fetchrowset($db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query tracker config', '', __LINE__, __FILE__, $sql);
	}

	foreach ($rowset as $rid => $row)
	{
		$tr_cfg[$row['config_name']] = $row['config_value'];
	}

	if (!$auth_key_name = $tr_cfg['auth_key_name'])
	{
		message_die(GENERAL_ERROR, 'Could not add passkey (wrong config auth_key_name)');
	}

	// Get post_id
	foreach ($auth_pages as $rid => $row)
	{
		if ($row['attach_id'] == $attach_id)
		{
			$post_id = $row['post_id'];
			break;
		}
	}

	// Redirect guests to login page
	if (!$userdata['session_logged_in'] && (!$tr_cfg['allow_guest_dl'] || $ft_cfg['bt_force_passkey']))
	{
		if ($post_id)
		{
			redirect(append_sid("login.php?redirect=viewtopic.php&". POST_POST_URL ."=$post_id", TRUE));
		}
		else
		{
			redirect(append_sid("login.php?redirect=index.php", TRUE));
		}
	}

	// Get torrent tracker status
	$sql = 'SELECT d.tracker_status, u.user_allow_passkey
		FROM '. ATTACHMENTS_DESC_TABLE .' d, '. USERS_TABLE ." u
		WHERE d.attach_id = $attach_id
			AND u.user_id = $user_id
		LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query information for this torrent', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);

	if (!$row['tracker_status'])
	{
		message_die(GENERAL_ERROR, $lang['Passkey_err_tor_not_reg']);
	}

	if (!$row['user_allow_passkey'])
	{
		message_die(GENERAL_ERROR, 'Could not add passkey<br /><br />You are not authorized to use passkey');
	}

	$auth_key = get_user_passkey($user_id);

	if (!$auth_key && $userdata['session_logged_in'])
	{
		if ($ft_cfg['bt_gen_passkey_on_reg'])
		{
			$auth_key = generate_passkey($user_id, TRUE);

			if (!defined('AUTH_KEY_INSERT_OK'))
			{
				message_die(GENERAL_ERROR, 'Could not insert passkey', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$mess = sprintf($lang['Passkey_err_empty'], append_sid("profile.php?mode=editprofile#bittorrent"));
			message_die(GENERAL_ERROR, $mess);
		}
	}

	$ann_url = $ft_cfg['bt_announce_url'];

	if (!$tor = bdecode_file($filename))
	{
		message_die(GENERAL_ERROR, 'This is not a bencoded file');
	}

	$passkey = (!$userdata['session_logged_in'] || isset($_GET['no_passkey'])) ? '' : "?$auth_key_name=$auth_key&";

	// replace original announce url with tracker default
	if ($ft_cfg['bt_replace_ann_url'] || !@$tor['announce'])
	{
		$tor['announce'] = strval($ann_url . $passkey);
	}

	// delete all additional urls
	if ($ft_cfg['bt_del_addit_ann_urls'])
	{
  	unset($tor['announce-list']);
	}

	// add publisher & topic url
	$publisher = $ft_cfg['bt_add_publisher'];
	$publisher_url = ($post_id) ? make_url("viewtopic.php?". POST_POST_URL ."=$post_id") : '';

	if ($publisher)
	{
		$tor['publisher'] = strval($publisher);
		unset($tor['publisher.utf-8']);

		if ($publisher_url)
		{
			$tor['publisher-url'] = strval($publisher_url);
			unset($tor['publisher-url.utf-8']);
		}
	}

	// add comment
	$comment = '';

	$orig_com = (@$tor['comment']) ? $tor['comment'] : '';

	if ($ft_cfg['bt_add_comment'])
	{
		$comment = $ft_cfg['bt_add_comment'];
	}
	else
	{
		$comment = ($publisher_url) ? $publisher_url : '';
	}

	if ($comment = trim($comment))
	{
		$tor['comment'] = strval($comment);
		unset($tor['comment.utf-8']);
	}

	// DHT
	$ft_cfg['bt_disable_dht'] = 1;

	if ($ft_cfg['bt_disable_dht'])
	{
		$tor['private'] = intval(1);
		unset($tor['nodes']);

		$tor['azureus_properties'] = array('dht_backup_enable' => intval(0));
	}

	// Send torrent
	$output = bencode($tor);
	$output_size = strlen($output);

	header("Content-length: $output_size");
	header('Content-Type: application/x-bittorrent');
	header('Content-Disposition: attachment; filename="'. clean_filename($attachment['real_filename']) .'"');

	echo $output;

	exit;
}

function get_user_passkey ($user_id)
{
	global $db;

	$user_id = intval($user_id);

	$sql = 'SELECT auth_key
		FROM '. BT_USERS_TABLE ."
		WHERE user_id = $user_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query user's auth_key", '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);

	return $row['auth_key'];
}

function generate_passkey ($user_id, $new_user)
{
	global $db, $lang, $sql;

	$user_id = intval($user_id);

	if ($new_user)
	{
		$u_up_total = $u_down_total = $u_bonus_total = 0;
	}
	else
	{
		$sql = 'SELECT *
			FROM '. BT_USERS_TABLE ."
			WHERE user_id = $user_id";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query userdata for passkey', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		$u_up_total   = ($row['u_up_total']) ? $row['u_up_total'] : 0;
		$u_down_total = ($row['u_down_total']) ? $row['u_down_total'] : 0;
		$u_bonus_total = ($row['u_bonus_total']) ? $row['u_bonus_total'] : 0;
	}

	if (!$new_user)
	{
		$sql = 'SELECT user_allow_passkey
			FROM '. USERS_TABLE ."
			WHERE user_id = $user_id";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query userdata for passkey', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		if (!$row['user_allow_passkey'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
		}
	}

	$sql = 'DELETE FROM '. BT_USERS_TABLE ."
		WHERE user_id = $user_id
		LIMIT 1";

	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete current passkey', '', __LINE__, __FILE__, $sql);
	}

	for ($i=0; $i < 20; $i++)
	{
		$auth_key = make_rand_str(BT_AUTH_KEY_LENGTH);

		$columns = 'user_id,   auth_key,   u_up_total,  u_down_total,  u_bonus_total';
		$values = "$user_id, '$auth_key', $u_up_total, $u_down_total,  $u_bonus_total";

		$sql = 'INSERT INTO '. BT_USERS_TABLE ." ($columns) VALUES ($values)";

		if ($db->sql_query($sql))
		{
			define ('AUTH_KEY_INSERT_OK', 1);
			break;
		}
	}

	return $auth_key;
}

function get_registered_torrents ($id, $mode)
{
	global $db;

	$field = ($mode == 'topic') ? 'topic_id' : 'post_id';

	$sql = 'SELECT torrent_id
		FROM '. BT_TORRENTS_TABLE ."
		WHERE $field = $id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query torrent id', '', __LINE__, __FILE__, $sql);
	}

	if ($rowset = @$db->sql_fetchrowset($result))
	{
		return $rowset;
	}
	else
	{
		return FALSE;
	}
}

function exit_redirect ($message, $post_id, $forum_id)
{
	global $template, $lang;

	$exit_meta = '<meta http-equiv="refresh" content="300;url='. append_sid("viewtopic.php?". POST_POST_URL ."=". $post_id) .'#'. $post_id .'">';
	$exit_message = $message .'<br /><br />'. sprintf($lang['Click_return_topic'], '<a href="'. append_sid("viewtopic.php?". POST_POST_URL ."=". $post_id) .'#'. $post_id .'">', '</a>') .'<br /><br />'. sprintf($lang['Click_return_forum'], '<a href="'. append_sid("viewforum.php?". POST_FORUM_URL ."=$forum_id") .'">', '</a>');
	$template->assign_vars(array('META' => $exit_meta));
	message_die(GENERAL_MESSAGE, $exit_message);
}

function torrent_error_exit ($message)
{
	global $reg_mode, $return_message, $lang;

	$err_code = GENERAL_ERROR;
	$msg = '';

	if (isset($reg_mode) && ($reg_mode == 'request' || $reg_mode == 'newtopic'))
	{
		if (isset($return_message))
		{
			$msg .= $return_message .'<br /><br /><hr /><br />';
		}
		$msg .= '<b>'. $lang['Bt_Reg_fail'] .'</b><br /><br />';

		$err_code = GENERAL_MESSAGE;
	}

	$msg .= $message;
	message_die($err_code, $msg);
}

// bdecode/bencode (based on functions from OpenTracker - http://whitsoftdev.com/opentracker/)
function bdecode_file ($filename)
{
	if (!$fp = fopen($filename, 'rb'))
	{
		return NULL;
	}
	$fc = fread($fp, @filesize($filename));
	fclose($fp);

	return bdecode($fc);
}

function bdecode($str)
{
	$pos = 0;
	return bdecode_r($str, $pos);
}

function bdecode_r($str, &$pos)
{
	$strlen = strlen($str);

	if (($pos < 0) || ($pos >= $strlen))
	{
		return NULL;
	}
	else if ($str{$pos} == 'i')
	{
		$pos++;
		$numlen = strspn($str, '-0123456789', $pos);
		$spos = $pos;
		$pos += $numlen;

		if (($pos >= $strlen) || ($str{$pos} != 'e'))
		{
			return NULL;
		}
		else
		{
			$pos++;
			return floatval(substr($str, $spos, $numlen));
		}
	}
	else if ($str{$pos} == 'd')
	{
		$pos++;
		$ret = array();

		while ($pos < $strlen)
		{
			if ($str{$pos} == 'e')
			{
				$pos++;
				return $ret;
			}
			else
			{
				$key = bdecode_r($str, $pos);

				if ($key === NULL)
				{
					return NULL;
				}
				else
				{
					$val = bdecode_r($str, $pos);

					if ($val === NULL)
					{
						return NULL;
					}
					else if (!is_array($key))
					{
						$ret[$key] = $val;
					}
				}
			}
		}
		return NULL;
	}
	else if ($str{$pos} == 'l')
	{
		$pos++;
		$ret = array();

		while ($pos < $strlen)
		{
			if ($str{$pos} == 'e')
			{
				$pos++;
				return $ret;
			}
			else
			{
				$val = bdecode_r($str, $pos);

				if ($val === NULL)
				{
					return NULL;
				}
				else
				{
					$ret[] = $val;
				}
			}
		}
		return NULL;
	}
	else
	{
		$numlen = strspn($str, '0123456789', $pos);
		$spos = $pos;
		$pos += $numlen;

		if (($pos >= $strlen) || ($str{$pos} != ':'))
		{
			return NULL;
		}
		else
		{
			$vallen = intval(substr($str, $spos, $numlen));
			$pos++;
			$val = substr($str, $pos, $vallen);

			if (strlen($val) != $vallen)
			{
				return NULL;
			}
			else
			{
				$pos += $vallen;
				return $val;
			}
		}
	}
}

function bencode($var)
{
	if (is_int($var))
	{
		return 'i'. $var .'e';
	}
	else if (is_float($var))
	{
		return 'i'. sprintf('%.0f', $var) .'e';
	}
	else if (is_array($var))
	{
		if (count($var) == 0)
		{
			return 'de';
		}
		else
		{
			$assoc = false;

			foreach ($var as $key => $val)
			{
				if (!is_int($key) && !is_float($var))
				{
					$assoc = true;
					break;
				}
			}

			if ($assoc)
			{
				ksort($var, SORT_REGULAR);
				$ret = 'd';

				foreach ($var as $key => $val)
				{
					$ret .= bencode($key) . bencode($val);
				}
				return $ret .'e';
			}
			else
			{
				$ret = 'l';

				foreach ($var as $val)
				{
					$ret .= bencode($val);
				}
				return $ret .'e';
			}
		}
	}
	else
	{
		return strlen($var) .':'. $var;
	}
}