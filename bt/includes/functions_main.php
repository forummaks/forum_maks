<?php

// Replacement for phpBB message_die
function message_die ($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	error_exit($msg_text, $err_file, $err_line, '', "SQL: $sql");
}

function unesc ($x)
{
	if (get_magic_quotes_gpc())
	{
		return stripslashes($x);
	}
	return $x;
}

function sqlesc ($x)
{
	return mysql_escape_string($x);
}

function encode_ip ($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip ($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]) .'.'. hexdec($hexipbang[1]) .'.'. hexdec($hexipbang[2]) .'.'. hexdec($hexipbang[3]);
}

function verify_ip ($ip)
{
	return (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/', $ip)) ? TRUE : FALSE;
}

function init_output ()
{
	global $tr_cfg;

	if ($tr_cfg['do_gzip'])
	{
		if ($tr_cfg['force_gzip'])
		{
			define ('FORCE_GZIP_OUT', TRUE);
			ob_start();
			ob_implicit_flush(0);
		}
		else
		{
			ob_start('ob_gzhandler');
		}
	}
	else
	{
		ob_start();
	}

	define ('OUTPUT_MODE_SET', TRUE);
	return;
}

function send_headers ()
{
	header('Content-Type: text/plain');
	header('Pragma: no-cache');
	header('Connection: close');

	if (defined('FORCE_GZIP_OUT'))
	{
		header('Content-Encoding: gzip');
	}
}

function send_data_to_client ()
{
	send_headers();

	if (defined('FORCE_GZIP_OUT'))
	{
		$gzip_contents = ob_get_contents();
		ob_end_clean();

		$gzip_size = strlen($gzip_contents);
		$gzip_crc = crc32($gzip_contents);

		$gzip_contents = gzcompress($gzip_contents, TR_GZIP_LEVEL);
		$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

		echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		echo $gzip_contents;
		echo pack('V', $gzip_crc);
		echo pack('V', $gzip_size);
	}

	tracker_exit();
}

function tracker_exit ()
{
	global $db, $starttime;

	if ($db)
	{
		$db->sql_close();
	}

	if (DBG_MODE && !defined('FORCE_GZIP_OUT'))
	{
		echo '<hr /><pre>';
		echo '   time : <b>'. sprintf('%.6f', (array_sum(explode(' ', microtime())) - $starttime)) ."</b> sec\n";
		echo 'queries : <b>'. $db->num_queries ."</b>\n";
		echo '</pre>';
	}

	exit;
}

function silent_exit ()
{
	ob_end_clean();
	tracker_exit();
}

function error_exit ($reason = '', $file = '', $line = '', $fail_type = '', $other = '')
{
	global $tr_cfg, $db, $sql;

	if (!defined('OUTPUT_MODE_SET'))
	{
		ob_start();
	}

	$reason .= ($file) ? ' :: '. basename($file) : '';
	$reason .= ($line) ? " ($line) ::" : '';

	if ($fail_type == 'off')
	{
		if (!$tr_cfg['off_show_reason'])
		{
			silent_exit();
		}
		else
		{
			$announce_interval = 600;

			$output['interval'] = intval($announce_interval);
			$output['failure reason'] = strval($reason);

			echo bencode($output);
			send_data_to_client();
		}
	}

	if ($tr_cfg['silent_mode'] && !$tr_cfg['bt_debug'])
	{
		silent_exit();
	}

	if ($tr_cfg['bt_debug'] || $fail_type == 'db')
	{
		$sql_error = $db->sql_error();
		$err_mess  = $sql_error['message'];
		$err_code  = $sql_error['code'];

		if ($fail_type == 'db')
		{
			$sql = preg_replace("#\s+#", ' ', $sql);
			$debug_info  = " [SQL:$err_code] $sql :: $err_mess";
			$debug_info .= ($other) ? " :: $other" : '';
			echo bencode(array('failure reason' => $reason . $debug_info));
		}
		else
		{
			$other .= ($err_mess) ? " :: $err_code :: $err_mess" : '';
			$other  = preg_replace("#\s+#", ' ', $other);
			echo bencode(array('failure reason' => $reason . $other));
		}
	}
	else
	{
		echo bencode(array('failure reason' => $reason));
	}

	send_data_to_client();
}

function browser_redirect ()
{
	global $tr_cfg;

	if (DBG_MODE)
	{
		return;
	}

	$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

	$browser_types = array(
		'amaya',
		'crawler',
		'dillo',
		'elinks',
		'gecko',
		'googlebot',
		'ibrowse',
		'icab',
		'konqueror',
		'lynx',
		'mozilla',
		'msie',
		'msnbot',
		'netpositive',
		'omniweb',
		'opera',
		'safari',
		'slurp',
		'w3m',
		'wget',
	);

	foreach ($browser_types as $browser)
	{
		if (strstr($user_agent, $browser))
		{
			header('Location: '. $tr_cfg['browser_redirect_url']);
			tracker_exit();
		}
	}

	return;
}

// bencode (based on functions from OpenTracker - http://whitsoftdev.com/opentracker/)
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

?>