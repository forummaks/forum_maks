<?php

if (!defined('FT_ROOT')) die(basename(__FILE__));
if (PHP_VERSION < '5.3') die('ForumTorrent requires PHP version 5.3+. Your PHP version '. PHP_VERSION);
if (!defined('FT_SCRIPT')) define('FT_SCRIPT', 'undefined');
if (!defined('FT_CFG_LOADED')) trigger_error('File config.php not loaded', E_USER_ERROR);

// Define some basic configuration arrays
unset($stopwords, $synonyms_match, $synonyms_replace);
$userdata = $theme = $images = $lang = $nav_links = array();
$gen_simple_header = false;

// Obtain and encode user IP
$client_ip = (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
$user_ip = encode_ip($client_ip);
define('CLIENT_IP', $client_ip);
define('USER_IP',   $user_ip);

function send_page ($contents)
{
	return compress_output($contents);
}

define('UA_GZIP_SUPPORTED', (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false));

function compress_output ($contents)
{
	global $ft_cfg;

	if ($ft_cfg['gzip_compress'] && GZIP_OUTPUT_ALLOWED && !defined('NO_GZIP'))
	{
		if (UA_GZIP_SUPPORTED && strlen($contents) > 2000)
		{
			header('Content-Encoding: gzip');
			$contents = gzencode($contents, 1);
		}
	}

	return $contents;
}

// Cookie params
$c = $ft_cfg['cookie_prefix'];
define('COOKIE_DATA',  $c .'data');
define('COOKIE_FORUM', $c .'f');
define('COOKIE_MARK',  $c .'mark_read');
define('COOKIE_TOPIC', $c .'t');
define('COOKIE_PM',    $c .'pm');
unset($c);

define('COOKIE_SESSION', 0);
define('COOKIE_EXPIRED', TIMENOW - 31536000);
define('COOKIE_PERSIST', TIMENOW + 31536000);

define('COOKIE_MAX_TRACKS', 90);

function ft_setcookie ($name, $val, $lifetime = COOKIE_PERSIST, $httponly = false)
{
	global $ft_cfg;
	return setcookie($name, $val, $lifetime, $ft_cfg['script_path'], $ft_cfg['cookie_domain'], $ft_cfg['cookie_secure'], $httponly);
}

// Debug options
if (DBG_USER)
{
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',  1);
}
else
{
	unset($_COOKIE['explain']);
}

define('DELETED', -1);

// User Levels
define('USER', 0);
define('ADMIN', 1);
define('MOD', 2);
define('EXCLUDED_USERS', implode(',', array(GUEST_UID, BOT_UID)));

// User related
define('USER_ACTIVATION_NONE', 0);
define('USER_ACTIVATION_SELF', 1);
define('USER_ACTIVATION_ADMIN', 2);

define('USER_AVATAR_NONE', 0);
define('USER_AVATAR_UPLOAD', 1);
define('USER_AVATAR_REMOTE', 2);
define('USER_AVATAR_GALLERY', 3);

// Group settings
define('GROUP_OPEN', 0);
define('GROUP_CLOSED', 1);
define('GROUP_HIDDEN', 2);

// Forum state
define('FORUM_UNLOCKED', 0);
define('FORUM_LOCKED', 1);

// Topic status
define('TOPIC_UNLOCKED', 0);
define('TOPIC_LOCKED', 1);
define('TOPIC_MOVED', 2);
define('TOPIC_WATCH_NOTIFIED', 1);
define('TOPIC_WATCH_UN_NOTIFIED', 0);

// Topic types
define('POST_NORMAL', 0);
define('POST_STICKY', 1);
define('POST_ANNOUNCE', 2);
define('POST_GLOBAL_ANNOUNCE', 3);

// SQL codes
define('BEGIN_TRANSACTION', 1);
define('END_TRANSACTION', 2);

// Error codes
define('GENERAL_MESSAGE', 200);
define('GENERAL_ERROR', 202);
define('CRITICAL_MESSAGE', 203);
define('CRITICAL_ERROR', 204);

// Private messaging
define('PRIVMSGS_READ_MAIL', 0);
define('PRIVMSGS_NEW_MAIL', 1);
define('PRIVMSGS_SENT_MAIL', 2);
define('PRIVMSGS_SAVED_IN_MAIL', 3);
define('PRIVMSGS_SAVED_OUT_MAIL', 4);
define('PRIVMSGS_UNREAD_MAIL', 5);

// URL PARAMETERS
define('POST_TOPIC_URL', 	't');
define('POST_CAT_URL', 		'c');
define('POST_FORUM_URL', 	'f');
define('POST_USERS_URL', 	'u');
define('POST_POST_URL', 	'p');
define('POST_GROUPS_URL', 	'g');

// Session parameters
define('SESSION_METHOD_COOKIE', 100);
define('SESSION_METHOD_GET', 101);

// Auth settings
define('AUTH_LIST_ALL', 0);
define('AUTH_ALL', 0);

define('AUTH_REG', 1);
define('AUTH_ACL', 2);
define('AUTH_MOD', 3);
define('AUTH_ADMIN', 5);

define('AUTH_VIEW', 1);
define('AUTH_READ', 2);
define('AUTH_POST', 3);
define('AUTH_REPLY', 4);
define('AUTH_EDIT', 5);
define('AUTH_DELETE', 6);
define('AUTH_ANNOUNCE', 7);
define('AUTH_STICKY', 8);
define('AUTH_POLLCREATE', 9);
define('AUTH_VOTE', 10);
define('AUTH_ATTACH', 11);

// Table names
define('ATTACH_CONFIG_TABLE', 			'ft_attachments_config');
define('ATTACHMENTS_DESC_TABLE', 		'ft_attachments_desc');
define('ATTACHMENTS_TABLE', 			'ft_attachments');
define('QUOTA_TABLE',  					'ft_attach_quota');
define('QUOTA_LIMITS_TABLE',  			'ft_quota_limits');
define('TOPICS_MOVE_TABLE', 			'ft_topics_move');
define('AUTH_ACCESS_TABLE', 			'ft_auth_access');
define('BANLIST_TABLE',					'ft_banlist');
define('CATEGORIES_TABLE', 				'ft_categories');
define('CONFIG_TABLE', 					'ft_config');
define('DISALLOW_TABLE', 				'ft_disallow');
define('FORUMS_TABLE', 					'ft_forums');
define('GROUPS_TABLE', 					'ft_groups');
define('POSTS_TABLE',					'ft_posts');
define('POSTS_TEXT_TABLE', 				'ft_posts_text');
define('PRIVMSGS_TABLE', 				'ft_privmsgs');
define('PRIVMSGS_TEXT_TABLE', 			'ft_privmsgs_text');
define('PRIVMSGS_IGNORE_TABLE',			'ft_privmsgs_ignore');
define('PRUNE_TABLE', 					'ft_forum_prune');
define('RANKS_TABLE', 					'ft_ranks');
define('SEARCH_TABLE', 					'ft_search_results');
define('SEARCH_WORD_TABLE', 			'ft_search_wordlist');
define('SEARCH_MATCH_TABLE', 			'ft_search_wordmatch');
define('SESSIONS_TABLE', 				'ft_sessions');
define('SMILIES_TABLE', 				'ft_smilies');
define('TOPICS_TABLE', 					'ft_topics');
define('TOPICS_WATCH_TABLE', 			'ft_topics_watch');
define('USER_GROUP_TABLE', 				'ft_user_group');
define('USERS_TABLE', 					'ft_users');
define('WORDS_TABLE', 					'ft_words');
define('VOTE_DESC_TABLE',				'ft_vote_desc');
define('VOTE_RESULTS_TABLE', 			'ft_vote_results');
define('VOTE_USERS_TABLE', 				'ft_vote_voters');

define('TORRENT_EXT', 'torrent');
define('PAGE_TRACKER', -1180);

define('TOPIC_DL_TYPE_NORMAL', 0);
define('TOPIC_DL_TYPE_DL',     1);

define('TOPIC_DL_ST_NONE',     0);
define('TOPIC_DL_ST_DOWN',     1);
define('TOPIC_DL_ST_COMPLETE', 2);

define('SHOW_PEERS_COUNT',     1);
define('SHOW_PEERS_NAMES',     2);
define('SHOW_PEERS_FULL',      3);
//bt end

define('PAGE_HEADER', INC_DIR .'page_header.php');
define('PAGE_FOOTER', INC_DIR .'page_tail.php');

define('CAT_URL',      'index.php?c=');
define('DOWNLOAD_URL', 'download.php?t=');
define('FORUM_URL',    'viewforum.php?f=');
define('GROUP_URL',    'groupcp.php?g=');
define('LOGIN_URL',    $ft_cfg['login_url']);
define('MODCP_URL',    'modcp.php?f=');
define('PM_URL',       $ft_cfg['pm_url']);
define('POST_URL',     'viewtopic.php?p=');
define('POSTING_URL',  $ft_cfg['posting_url']);
define('PROFILE_URL',  'profile.php?mode=viewprofile&amp;u=');
define('TOPIC_URL',    'viewtopic.php?t=');

//upt
define('UPD_LAST_POST_HOUR_ACTIVE', 3600*3);
//upt end

//qr
// To disable - change to "FALSE"
define('SHOW_QUICK_REPLY', TRUE);
//qr end

//flt
define('SHOW_FORUM_LAST_TOPIC', TRUE);
define('LAST_POST_DATE_FORMAT', 'Y-m-d H:i');
//flt end

//sf
define('SHOW_SUBFORUMS_ON_INDEX', TRUE);
define('SF_SEL_SPACER', '&nbsp;|-&nbsp;');
//sf end

// Attachment Debug Mode
define('ATTACH_DEBUG', 0);		// Attachment Mod Debugging off

// Auth
define('AUTH_DOWNLOAD', 20);

// Download Modes
define('INLINE_LINK', 1);
define('PHYSICAL_LINK', 2);

// Categories
define('NONE_CAT', 0);
define('IMAGE_CAT', 1);
define('STREAM_CAT', 2);
define('SWF_CAT', 3);

// Pages
define('PAGE_UACP', -32);
define('PAGE_RULES', -33);

// Misc
define('MEGABYTE', 1024);
define('ADMIN_MAX_ATTACHMENTS', 50); // Maximum Attachments in Posts or PM's for Admin Users
define('THUMB_DIR', 'thumbs');
define('MODE_THUMBNAIL', 1);

// Forum Extension Group Permissions
define('GPERM_ALL', 0); // ALL FORUMS

// Quota Types
define('QUOTA_UPLOAD_LIMIT', 1);
define('QUOTA_PM_LIMIT', 2);

define('ATTACH_VERSION', '2.3.14');

define('USER_AGENT', strtolower($_SERVER['HTTP_USER_AGENT']));

define('HTML_SELECT_MAX_LENGTH', 60);
define('HTML_WBR_LENGTH',        12);

define('HTML_CHECKED',  ' checked="checked" ');
define('HTML_DISABLED', ' disabled="disabled" ');
define('HTML_READONLY', ' readonly="readonly" ');
define('HTML_SELECTED', ' selected="selected" ');

define('HTML_SF_SPACER', '&nbsp;|-&nbsp;');

if (!empty($banned_user_agents))
{
	foreach ($banned_user_agents as $agent)
	{
		if (strstr(USER_AGENT, $agent))
		{
			$filename = 'Download files by using browser';
			$output = '@';
			header('Content-Type: text/plain');
			header('Content-Disposition: attachment; filename="'. $filename .'"');
			die($output);
		}
	}
}

// Functions
function send_no_cache_headers ()
{
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: '. gmdate('D, d M Y H:i:s'). ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');
}

function ft_exit ($output = '')
{
	if ($output)
	{
		echo $output;
	}
	exit;
}

function prn_r ($var, $title = '', $print = true)
{
	$r = '<pre>'. (($title) ? "<b>$title</b>\n\n" : '') . htmlspecialchars(print_r($var, true)) .'</pre>';
	if ($print) echo $r;
	return $r;
}

function pre ($var, $title = '', $print = true)
{
	prn_r($var, $title, $print);
}

function prn ()
{
	if (!DBG_USER) return;
	foreach (func_get_args() as $var) prn_r($var);
}

function vdump ($var, $title = '')
{
	echo '<pre>'. (($title) ? "<b>$title</b>\n\n" : '');
	var_dump($var);
	echo '</pre>';
}

function htmlCHR ($txt, $double_encode = false, $quote_style = ENT_QUOTES, $charset = 'UTF-8')
{
	return (string) htmlspecialchars($txt, $quote_style, $charset, $double_encode);
}

function html_ent_decode ($txt, $quote_style = ENT_QUOTES, $charset = 'UTF-8')
{
	return (string) html_entity_decode($txt, $quote_style, $charset);
}

function make_url ($path = '')
{
	return FULL_URL . preg_replace('#^\/?(.*?)\/?$#', '\1', $path);
}

require(INC_DIR . 'functions.php');
require(INC_DIR . 'sessions.php');
require(INC_DIR . 'auth.php');
require(INC_DIR . 'template.php');
require(FT_ROOT . 'db/mysql.php');

define('SQL_LAYER', 'mysql');

$ft_cfg = array_merge(ft_get_config(CONFIG_TABLE), $ft_cfg);

if( $ft_cfg['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}