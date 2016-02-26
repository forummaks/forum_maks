<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));

/**
 * Adds commas between every group of thousands
 *
 * @param $number
 *
 * @return string
 */
function commify ($number) 
{
	return number_format($number);
}

//bt
// output (string) [forum_id,forum_id,...]
function user_not_auth_forums ($auth_type)
{
	global $userdata;

	if ($userdata['user_level'] != ADMIN)
	{
		$auth_field_match = array(
			AUTH_VIEW       => 'auth_view',
			AUTH_READ       => 'auth_read',
			AUTH_POST       => 'auth_post',
			AUTH_REPLY      => 'auth_reply',
			AUTH_EDIT       => 'auth_edit',
			AUTH_DELETE     => 'auth_delete',
			AUTH_STICKY     => 'auth_sticky',
			AUTH_ANNOUNCE   => 'auth_announce',
			AUTH_VOTE       => 'auth_vote',
			AUTH_POLLCREATE => 'auth_pollcreate',
			AUTH_ATTACH     => 'auth_attachments',
			AUTH_DOWNLOAD   => 'auth_download'
		);

		$ignore_forum_sql = array();
		$auth_field = $auth_field_match[$auth_type];
		$is_auth_ary = auth($auth_type, AUTH_LIST_ALL, $userdata);

		foreach ($is_auth_ary as $forum_id => $is_auth)
		{
			if (!$is_auth[$auth_field])
			{
				$ignore_forum_sql[] = $forum_id;
			}
		}

		return implode(',', $ignore_forum_sql);
	}
	else
	{
		return '';
	}
}

// Returns a size formatted in a more human-friendly format, rounded to the nearest GB, MB, KB..

function humn_size ($size, $rounder = '', $min = '', $space = '&nbsp;')
{
	$sizes   = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$rounders = array(0,   0,    0,    2,    2,    3,    3,    3,    3);
	$ext = $sizes[0];
	$rnd = $rounders[0];

	if ($min == 'KB' && $size < 1024)
	{
		$size = $size / 1024;
		$ext = 'KB';
		$rounder = 1;
	}
	else
	{
		for ($i=1, $cnt=count($sizes); ($i < $cnt && $size >= 1024); $i++)
		{
			$size = $size / 1024;
			$ext  = $sizes[$i];
			$rnd  = $rounders[$i];
		}
	}

	if (!$rounder)
	{
		$rounder = $rnd;
	}

	return round($size, $rounder) . $space . $ext;
}

function bt_show_ip ($ip, $port = '')
{
	global $is_auth, $ft_cfg;

	if (!$is_auth['auth_mod'])
	{
		if ($ft_cfg['bt_show_ip_only_moder'])
		{
			return '';
		}
		else
		{
			return decode_ip_xx($ip);
		}
	}
	else
	{
		$ip = decode_ip($ip);
		$ip .= ($port) ? ":$port" : '';
		return $ip;
	}
}

function bt_show_port ($port)
{
	global $is_auth, $ft_cfg;

	if (!$is_auth['auth_mod'] && $ft_cfg['bt_show_port_only_moder'])
	{
		return NULL;
	}
	else
	{
		return $port;
	}
}

function decode_ip_xx($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.xx';
}

function checkbox_get_val (&$key, &$val, $default = 1, $on = 1, $off = 0)
{
	global $prev_set, $guest, $search_id;

	if (!$prev_set && !$guest)
	{
		$val = $default;
	}
	else if (isset($_REQUEST[$key]))
	{
		$val = (intval($_REQUEST[$key]) == $on) ? $on : $off;
	}
	else if (!isset($_REQUEST[$key]) && isset($_REQUEST['prev_'. $key]))
	{
		$val = $off;
	}
	else if (!$guest || $search_id)
	{
		$val = ($prev_set[$key]) ? $on : $off;
	}
	else
	{
		$val = $default;
	}
	return;
}

function select_get_val ($key, &$val, $options_ary, $default, $num = TRUE)
{
	global $prev_set;

	if (isset($_REQUEST[$key]))
	{
		if (isset($options_ary[$_REQUEST[$key]]))
		{
			$val = ($num) ? intval($_REQUEST[$key]) : $_REQUEST[$key];
		}
	}
	else if (isset($prev_set[$key]))
	{
		$val = $prev_set[$key];
	}
	else
	{
		$val = $default;
	}
	return;
}

/**
 * set_var
 *
 * Set variable, used by {@link request_var the request_var function}
 *
 * @access private
 *
 * @param      $result
 * @param      $var
 * @param      $type
 * @param bool $multibyte
 * @param bool $strip
 */
 
function set_var (&$result, $var, $type, $multibyte = false, $strip = true)
{
	settype($var, $type);
	$result = $var;
	
	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r"), array("\n", "\n"), $result)));
		if (!empty($result))
		{
			// Make sure multibyte characters are wellformed
			if ($multibyte)
			{
				if (!preg_match('/^./u', $result))
				{
					$result = '';
				}
			}
		}
		
		$result = ($strip) ? stripslashes($result) : $result;
	}
}

/**
 * request_var
 *
 * Used to get passed variable
 *
 * @param      $var_name
 * @param      $default
 * @param bool $multibyte
 * @param bool $cookie
 *
 * @return array
 */
 
function request_var ($var_name, $default, $multibyte = false, $cookie = false)
{
	if (!$cookie && isset($_COOKIE[$var_name]))
	{
		if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
		{
			return (is_array($default)) ? array() : $default;
		}
		$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
	}
	
	if (!isset($_REQUEST[$var_name]) || (is_array($_REQUEST[$var_name]) && !is_array($default)) || (is_array($default) && !is_array($_REQUEST[$var_name])))
	{
		return (is_array($default)) ? array() : $default;
	}
	
	$var = $_REQUEST[$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
		if ($type == 'array')
		{
			reset($default);
			$default = current($default);
			list($sub_key_type, $sub_type) = each($default);
			$sub_type = gettype($sub_type);
			$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
			$sub_key_type = gettype($sub_key_type);
		}
	}
	
	if (is_array($var))
	{
		$_var = $var;
		$var = array();
		
		foreach ($_var as $k => $v)
		{
			set_var($k, $k, $key_type);
			if ($type == 'array' && is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					if (is_array($_v))
					{
						$_v = null;
					}
					set_var($_k, $_k, $sub_key_type);
					set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
				}
			}
			else
			{
				if ($type == 'array' || is_array($v))
				{
					$v = null;
				}
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}
	
	return $var;
}

function get_username ($user_id)
{
	global  $sql;

	$user_id = intval($user_id);

	$sql = 'SELECT username
		FROM '. USERS_TABLE ."
		WHERE user_id = $user_id
		LIMIT 1";

	$row = DB()->sql_fetchrow(DB()->sql_query($sql));

	return $row['username'];
}

function get_user_id ($username)
{
	global  $sql;

	$sql = 'SELECT user_id
		FROM '. USERS_TABLE ."
		WHERE username = '$username'
		LIMIT 1";

	$row = DB()->sql_fetchrow(DB()->sql_query($sql));

	return $row['user_id'];
}

function ft_get_config ($table, $from_db = false, $update_cache = true)
{
	if ($from_db OR !$cfg = CACHE('ft_config')->get("config_{$table}"))
	{
		$cfg = array();
		foreach (DB()->fetch_rowset("SELECT * FROM $table") as $row)
		{
			$cfg[$row['config_name']] = $row['config_value'];
		}
		if ($update_cache)
		{
			CACHE('ft_config')->set("config_{$table}", $cfg);
		}
	}
	return $cfg;
}

function ft_update_config ($params, $table = CONFIG_TABLE)
{
	$updates = array();
	foreach ($params as $name => $val)
	{
		$updates[] = array(
			'config_name'  => $name,
			'config_value' => $val,
		);
	}
	$updates = DB()->build_array('MULTI_INSERT', $updates);

	DB()->query("REPLACE INTO $table $updates");

	// Update cache
	ft_get_config($table, true, true);
}

function unesc ($x)
{
	if (get_magic_quotes_gpc())
	{
		return stripslashes($x);
	}
	return $x;
}

function str_short ($text, $max_length, $space = ' ')
{
	if ($max_length && mb_strlen($text, 'UTF-8') > $max_length)
	{
		$text = mb_substr($text, 0, $max_length, 'UTF-8');

		if ($last_space_pos = $max_length - intval(strpos(strrev($text), $space)))
		{
			if ($last_space_pos > round($max_length * 3/4))
			{
				$last_space_pos--;
				$text = mb_substr($text, 0, $last_space_pos, 'UTF-8');
			}
		}
		$text .= '...';
		$text = preg_replace('!&#?(\w+)?;?(\w{1,5})?\.\.\.$!', '...', $text);
	}

	return $text;
}

function wbr ($text, $max_word_length = HTML_WBR_LENGTH)
{
	return preg_replace("/([\w\->;:.,~!?(){}@#$%^*\/\\\\]{". $max_word_length ."})/ui", '$1<wbr>', $text);
}

function bt_sql_esc ($x)
{
	return mysql_real_escape_string($x); // Временное решение проблеммы
}
//bt end

function get_db_stat($mode)
{
	

	switch( $mode )
	{
		case 'usercount':
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . GUEST_UID;
			break;

		case 'newestuser':
			$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . GUEST_UID . "
				ORDER BY user_id DESC
				LIMIT 1";
			break;

		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;
	}

	if ( !($result = DB()->sql_query($sql)) )
	{
		return false;
	}

	$row = DB()->sql_fetchrow($result);

	switch ( $mode )
	{
		case 'usercount':
			return $row['total'];
			break;
		case 'newestuser':
			return $row;
			break;
		case 'postcount':
			return $row['post_total'];
			break;
		case 'topiccount':
			return $row['topic_total'];
			break;
	}

	return false;
}

function clean_username ($username)
{
	$username = mb_substr(htmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25, 'UTF-8');
	$username = ft_rtrim($username, "\\");
	$username = str_replace("'", "\'", $username);

	return $username;
}

function ft_ltrim ($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}

	$str = ltrim($str, $charlist);

	return $str;
}

function ft_rtrim ($str, $charlist = false)
{
	if ($charlist === false)
	{
		return rtrim($str);
	}

	$str = rtrim($str, $charlist);

	return $str;
}

//
// Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
//
function get_userdata($user, $force_str = false)
{
	

	if (!is_numeric($user) || $force_str)
	{
		$user = clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  $user . "'" ) . " AND user_id <> " . GUEST_UID;
	if ( !($result = DB()->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	return ( $row = DB()->sql_fetchrow($result) ) ? $row : false;
}

//sf - add [, $return_forums_ary = FALSE]
function make_jumpbox($action, $match_forum_id = 0, $return_forums_ary = FALSE)
{
	global $template, $userdata, $lang,  $nav_links, $SID;

//	$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

	$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
		FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
		WHERE f.cat_id = c.cat_id
		GROUP BY c.cat_id, c.cat_title, c.cat_order
		ORDER BY c.cat_order";
	if ( !($result = DB()->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
	}

	$category_rows = array();
	while ( $row = DB()->sql_fetchrow($result) )
	{
		$category_rows[] = $row;
	}

	if ( $total_categories = count($category_rows) )
	{
		$sql = "SELECT *
			FROM " . FORUMS_TABLE . "
			ORDER BY cat_id, forum_order";
		if ( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
		}

		$boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';

		$forum_rows = array();
		while ( $row = DB()->sql_fetchrow($result) )
		{
			$forum_rows[] = $row;
		}

		if ( $total_forums = count($forum_rows) )
		{
			for($i = 0; $i < $total_categories; $i++)
			{
				$boxstring_forums = '';
				for($j = 0; $j < $total_forums; $j++)
				{
					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $forum_rows[$j]['auth_view'] <= AUTH_REG )
					{

//					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $is_auth[$forum_rows[$j]['forum_id']]['auth_view'] )
//					{
						$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
						//sf
						$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . (($forum_rows[$j]['forum_parent']) ? SF_SEL_SPACER : '') . $forum_rows[$j]['forum_name'] . '</option>';

						//
						// Add an array to $nav_links for the Mozilla navigation bar.
						// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
						//
						$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
							'url' => append_sid("viewforum.php?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
							//sf
							'title' => (($forum_rows[$j]['forum_parent']) ? SF_SEL_SPACER : '') . $forum_rows[$j]['forum_name']
						);

					}
				}

				if ( $boxstring_forums != '' )
				{
					$boxstring .= '<option value="-1">&nbsp;</option>';
					$boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
					$boxstring .= '<option value="-1">----------------</option>';
					$boxstring .= $boxstring_forums;
				}
			}
		}

		$boxstring .= '</select>';
	}
	else
	{
		$boxstring .= '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>';
	}

	// Let the jumpbox work again in sites having additional session id checks.
//	if ( !empty($SID) )
//	{
		$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
//	}

	$template->set_filenames(array(
		'jumpbox' => 'jumpbox.tpl')
	);
	$template->assign_vars(array(
		'L_GO' => $lang['Go'],
		'L_JUMP_TO' => $lang['Jump_to'],
		'L_SELECT_FORUM' => $lang['Select_forum'],

		'S_JUMPBOX_SELECT' => $boxstring,
		'S_JUMPBOX_ACTION' => append_sid($action))
	);
	$template->assign_var_from_handle('JUMPBOX', 'jumpbox');

	//sf
	if ($return_forums_ary)
	{
		$forums_ary = array();

		foreach ($forum_rows as $rid => $frow)
		{
			$forums_ary[$frow['forum_id']] = $frow;
		}

		foreach ($forum_rows as $rid => $frow)
		{
			if ($frow['forum_parent'])
			{
				$forums_ary[$frow['forum_parent']]['subforums'][] = $frow['forum_id'];
			}
		}

		return $forums_ary;
	}
	//sf end

	return;
}

//
// Initialise user settings on page load
function init_userprefs($userdata)
{
	global $ft_cfg, $theme, $images;
	global $template, $lang;
	global $nav_links;

	if ( $userdata['user_id'] != GUEST_UID )
	{
		if ( !empty($userdata['user_lang']))
		{
			$ft_cfg['default_lang'] = $userdata['user_lang'];
		}

		if ( !empty($userdata['user_dateformat']) )
		{
			$ft_cfg['default_dateformat'] = $userdata['user_dateformat'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$ft_cfg['board_timezone'] = $userdata['user_timezone'];
		}
	}

	if ( !file_exists(@phpbb_realpath(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/lang_main.php')) )
	{
		$ft_cfg['default_lang'] = 'english';
	}

	require(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/lang_main.php');

	if ( defined('IN_ADMIN') )
	{
		if( !file_exists(@phpbb_realpath(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/lang_admin.php')) )
		{
			$ft_cfg['default_lang'] = 'english';
		}

		require(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/lang_admin.php');
	}

	include_attach_lang();
	//
	// Set up style
	//
	if ( !$ft_cfg['override_user_style'] )
	{
		if ( $userdata['user_id'] != GUEST_UID && $userdata['user_style'] > 0 )
		{
			if ( $theme = setup_style($userdata['user_style']) )
			{
				return;
			}
		}
	}

	$theme = setup_style();

	//
	// Mozilla navigation bar
	// Default items that should be valid on all pages.
	// Defined here to correctly assign the Language Variables
	// and be able to change the variables within code.
	//
	$nav_links['top'] = array (
		'url' => append_sid(FT_ROOT . 'index.php'),
		'title' => sprintf($lang['Forum_Index'], $ft_cfg['sitename'])
	);
	$nav_links['search'] = array (
		'url' => append_sid(FT_ROOT . 'search.php'),
		'title' => $lang['Search']
	);
	$nav_links['help'] = array (
		'url' => append_sid(FT_ROOT . 'faq.php'),
		'title' => $lang['FAQ']
	);
	$nav_links['author'] = array (
		'url' => append_sid(FT_ROOT . 'memberlist.php'),
		'title' => $lang['Memberlist']
	);

	return;
}

function setup_style()
{
	global $ft_cfg, $template, $userdata;

	// AdminCP works only with default template
	$tpl_dir_name = defined('IN_ADMIN') ? 'default'   : basename($ft_cfg['tpl_name']);
	$stylesheet   = defined('IN_ADMIN') ? 'main.css'  : basename($ft_cfg['link_css']);

	if (!GUEST_UID && !empty($userdata['tpl_name']))
	{
		foreach ($ft_cfg['templates'] as $folder => $name)
		{
			if ($userdata['tpl_name'] == $folder) $tpl_dir_name = basename($userdata['tpl_name']);
		}
	}

	$template = new Template(TEMPLATES_DIR . $tpl_dir_name);
	$css_dir = basename(TEMPLATES_DIR) . '/' . $tpl_dir_name . '/css/';

	$template->assign_vars(array(
		'FT_ROOT'          => FT_ROOT,
		'SPACER'           => make_url('styles/images/spacer.gif'),
		'STYLESHEET'       => make_url($css_dir . $stylesheet),
		'EXT_LINK_NEW_WIN' => $ft_cfg['ext_link_new_win'],
		'TPL_DIR'          => make_url($css_dir),
		'SITE_URL'         => make_url('/'),
	));

	require(TEMPLATES_DIR . $tpl_dir_name .'/tpl_config.php');

	$theme = array('template_name' => $tpl_dir_name);

	return $theme;
}

//
// Create date/time from format and timezone
//
function create_date($format, $gmepoch, $tz)
{
	global $ft_cfg, $lang;
	static $translate;

	if ( empty($translate) && $ft_cfg['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}

//
// Pagination routine, generates
// page number sequence
//
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{
	global $lang;

//
// BEGIN Pagination Mod
//
	$begin_end = 3;
	$from_middle = 1;
/*
	By default, $begin_end is 3, and $from_middle is 1, so on page 6 in a 12 page view, it will look like this:

	a, d = $begin_end = 3
	b, c = $from_middle = 1

 "begin"        "middle"           "end"
    |              |                 |
    |     a     b  |  c     d        |
    |     |     |  |  |     |        |
    v     v     v  v  v     v        v
    1, 2, 3 ... 5, 6, 7 ... 10, 11, 12

	Change $begin_end and $from_middle to suit your needs appropriately
*/
//
// END Pagination Mod
//

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > ((2*($begin_end + $from_middle)) + 2) )
	{
		$init_page_max = ( $total_pages > $begin_end ) ? $begin_end : $total_pages;
		for($i = 1; $i < $init_page_max + 1; $i++)
		{
		$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
			$page_string .= ", ";
			}
		}
		if ( $total_pages > $begin_end )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
			$page_string .= ( $on_page > ($begin_end + $from_middle + 1) ) ? ' ... ' : ', ';

				$init_page_min = ( $on_page > ($begin_end + $from_middle) ) ? $on_page : ($begin_end + $from_middle + 1);

				$init_page_max = ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? $on_page : $total_pages - ($begin_end + $from_middle);

				for($i = $init_page_min - $from_middle; $i < $init_page_max + ($from_middle + 1); $i++)
				{
				$page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
					if ( $i <  $init_page_max + $from_middle )
					{
					$page_string .= ', ';
					}
				}
			$page_string .= ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? ' ... ' : ', ';
			}
			else
			{
				$page_string .= '&nbsp;...&nbsp;';
			}
			for($i = $total_pages - ($begin_end - 1); $i < $total_pages + 1; $i++)
			{
			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if( $i <  $total_pages )
				{
				$page_string .= ", ";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
		$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $total_pages )
			{
			$page_string .= ', ';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a href="' . append_sid($base_url . "&amp;start=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $lang['Previous'] . '</a>&nbsp;&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . append_sid($base_url . "&amp;start=" . ( $on_page * $per_page ) ) . '">' . $lang['Next'] . '</a>';
		}

	}

//	$page_string = $lang['Goto_page'] . ' ' . $page_string;
	$page_string = $lang['Goto_page'] . ':&nbsp;&nbsp;' . $page_string;

	return $page_string;
}

//
// This does exactly what preg_quote() does in PHP 4-ish
// If you just need the 1-parameter preg_quote call, then don't bother using this.
//
function phpbb_preg_quote($str, $delimiter)
{
	$text = preg_quote($str);
	$text = str_replace($delimiter, '\\' . $delimiter, $text);

	return $text;
}

//
// Obtain list of naughty words and build preg style replacement arrays for use by the
// calling script, note that the vars are passed as references this just makes it easier
// to return both sets of arrays
//
function obtain_word_list(&$orig_word, &$replacement_word)
{
	

	//
	// Define censored word matches
	//
	$sql = "SELECT word, replacement
		FROM  " . WORDS_TABLE;
	if( !($result = DB()->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get censored words from database', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = DB()->sql_fetchrow($result) )
	{
		do
		{
			$orig_word[] = '#\b(' . str_replace('\*', '\w*?', phpbb_preg_quote($row['word'], '#')) . ')\b#i';
			$replacement_word[] = $row['replacement'];
		}
		while ( $row = DB()->sql_fetchrow($result) );
	}

	return true;
}

function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global  $template, $ft_cfg, $theme, $lang, $nav_links, $gen_simple_header, $images;
	global $userdata, $user_ip, $session_length;
	global $starttime;

	if(defined('HAS_DIED'))
	{
		die("message_die() was called multiple times. This isn't supposed to happen. Was message_die() used in page_tail.php?");
	}

	define('HAS_DIED', 1);


	$sql_store = $sql;

	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent
	// subsequent queries from overwriting the status of sql_error()
	//
	if (( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		$sql_error = DB()->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( $err_line != '' && $err_file != '' )
		{
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . basename($err_file);
		}
	}

	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )
	{
		$userdata = session_pagestart($user_ip);
		init_userprefs($userdata);
	}

	//
	// If the header hasn't been output then do it
	//
	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )
	{
		if ( empty($lang) )
		{
			if ( !empty($ft_cfg['default_lang']) )
			{
				require(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/lang_main.php');
			}
			else
			{
				require(FT_ROOT . 'language/lang_english/lang_main.php');
			}
		}

		if ( empty($template) )
		{
			$template = new Template(FT_ROOT . 'templates/' . $ft_cfg['board_template']);
		}
		if ( empty($theme) )
		{
			$theme = setup_style($ft_cfg['default_style']);
		}

		//
		// Load the Page Header
		//
		if ( !defined('IN_ADMIN') )
		{
			require(FT_ROOT . 'includes/page_header.php');
		}
		else
		{
			require(FT_ROOT . 'admin/page_header_admin.php');
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Information'];
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Critical_Information'];
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )
			{
				$msg_text = $lang['An_error_occured'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = $lang['General_Error'];
			}
			break;

		case CRITICAL_ERROR:
			//
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			//
			require(FT_ROOT . 'language/lang_english/lang_main.php');

			if ( $msg_text == '' )
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = 'phpBB : <b>' . $lang['Critical_Error'] . '</b>';
			}
			break;
	}

	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if (( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}

		if ( !defined('IN_ADMIN') )
		{
			$template->set_filenames(array(
				'message_body' => 'message_body.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'message_body' => 'admin/admin_message_body.tpl')
			);
		}

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $msg_title,
			'MESSAGE_TEXT' => $msg_text)
		);
		$template->pparse('message_body');

		if ( !defined('IN_ADMIN') )
		{
			require(FT_ROOT . 'includes/page_tail.php');
		}
		else
		{
			require(FT_ROOT . 'admin/page_footer_admin.php');
		}
	}
	else
	{
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}

	exit;
}

function phpbb_realpath($path)
{
	return (!@function_exists('realpath') || !@realpath(FT_ROOT . 'includes/functions.php')) ? $path : @realpath($path);
}

function redirect($url)
{
	global $ft_cfg;

	if (headers_sent($filename, $linenum))
	{
		trigger_error("Headers already sent in $filename($linenum)", E_USER_ERROR);
	}

	if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r") || strstr(urldecode($url), ';url'))
	{
		message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url');
	}

	$url = trim($url);
	$server_protocol = ($ft_cfg['cookie_secure']) ? 'https://' : 'http://';

	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($ft_cfg['server_name']));
	$server_port = ($ft_cfg['server_port'] <> 80) ? ':' . trim($ft_cfg['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($ft_cfg['script_path']));

	if ($script_name)
	{
		$script_name = "/$script_name";
		$url = preg_replace("#^$script_name#", '', $url);
	}

	$redirect_url = $server_protocol . $server_name . $server_port . $script_name . preg_replace('#^\/?(.*?)\/?$#', '/\1', $url);

	// Behave as per HTTP/1.1 spec for others
	header('Location: '. $redirect_url);
	exit;
}

//-- mod : topic display order ---------------------------------------------------------------------
//-- add
// build a list of the sortable fields or return field name
function get_forum_display_sort_option($selected_row=0, $action='list', $list='sort')
{
	global $lang;

	$forum_display_sort = array(
		'lang_key'	=> array('Last_Post', 'Sort_Topic_Title', 'Sort_Time', 'Sort_Author'),
		'fields'	=> array('t.topic_last_post_id', 't.topic_title', 't.topic_time', 'u.username'),
	);
	$forum_display_order = array(
		'lang_key'	=> array('Sort_Descending', 'Sort_Ascending'),
		'fields'	=> array('DESC', 'ASC'),
	);

	// get the good list
	$list_name = 'forum_display_' . $list;
	$listrow = $$list_name;

	// init the result
	$res = '';
	if ( $selected_row > count($listrow['lang_key']) )
	{
		$selected_row = 0;
	}

	// build list
	if ($action == 'list')
	{
		for ($i=0; $i < count($listrow['lang_key']); $i++)
		{
			$selected = ($i==$selected_row) ? ' selected="selected"' : '';
			$l_value = (isset($lang[$listrow['lang_key'][$i]])) ? $lang[$listrow['lang_key'][$i]] : $listrow['lang_key'][$i];
			$res .= '<option value="' . $i . '"' . $selected . '>' . $l_value . '</option>';
		}
	}
	else
	{
		// field
		$res = $listrow['fields'][$selected_row];
	}
	return $res;
}
//-- fin mod : topic display order -----------------------------------------------------------------
