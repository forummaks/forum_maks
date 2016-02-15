<?php
/***************************************************************************
 *                             admin_forums.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_forums.php,v 1.40.2.12 2005/05/06 22:58:19 acydburn Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

@define('IN_PHPBB', 1);
$page_title = 'Manage Forums';
$show_index = FALSE;
$s = '';
$sl = ' selected="selected" ';
$ch = ' checked="checked" ';
$ds = ' disabled="disabled" ';

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Manage'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

$forum_auth_ary = array(
	"auth_view" => AUTH_ALL,
	"auth_read" => AUTH_ALL,
	"auth_post" => AUTH_REG,
	"auth_reply" => AUTH_REG,
	"auth_edit" => AUTH_REG,
	"auth_delete" => AUTH_REG,
	"auth_sticky" => AUTH_MOD,
	"auth_announce" => AUTH_MOD,
	"auth_vote" => AUTH_REG,
	"auth_pollcreate" => AUTH_REG
);

$forum_auth_ary['auth_attachments'] = AUTH_REG;
$forum_auth_ary['auth_download'] = AUTH_REG;
//
// Mode setting
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

// ------------------
// Begin function block
//
function get_info($mode, $id)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$namefield = 'cat_title';
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$namefield = 'forum_name';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}
	$sql = "SELECT count(*) as total
		FROM $table";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$count = $count['total'];

	$sql = "SELECT *
		FROM $table
		WHERE $idfield = $id";

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}

	if( $db->sql_numrows($result) != 1 )
	{
		message_die(GENERAL_ERROR, "Forum/Category doesn't exist or multiple forums/categories with ID $id", "", __LINE__, __FILE__);
	}

	$return = $db->sql_fetchrow($result);
	$return['number'] = $count;
	return $return;
}

function get_list($mode, $id, $select)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$namefield = 'cat_title';
			$order = 'cat_order';
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$namefield = 'forum_name';
			$order = 'cat_id, forum_order';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}

	$sql = "SELECT *
		FROM $table";
	if( $select == 0 )
	{
		$sql .= " WHERE $idfield <> $id";
	}
		$sql .= " ORDER BY $order";

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories/Forums", "", __LINE__, __FILE__, $sql);
	}

	$catlist = '';

	while( $row = $db->sql_fetchrow($result) )
	{
		$s = "";
		if ($row[$idfield] == $id)
		{
			$s = " selected=\"selected\"";
		}
		$catlist .= "<option value=\"$row[$idfield]\"$s>&nbsp;" . $row[$namefield] . "</option>\n";
	}

	return($catlist);
}

function renumber_order($mode, $cat = 0)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$orderfield = 'cat_order';
			$cat = 0;
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$orderfield = 'forum_order';
			$catfield = 'cat_id';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}

	$sql = "SELECT * FROM $table";
	if( $cat != 0)
	{
		$sql .= " WHERE $catfield = $cat";
	}
	$sql .= " ORDER BY $orderfield ASC";


	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
	}

	$i = 10;
	$inc = 10;

	while( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE $table
			SET $orderfield = $i
			WHERE $idfield = " . $row[$idfield];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
		}
		$i += 10;
	}

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
	}

}

function get_cat_forums ($cat_id = FALSE)
{
	global $db;

	$forums = array();
	$where_sql = '';

	if ($cat_id = intval($cat_id))
	{
		$where_sql = "AND f.cat_id = $cat_id";
	}

	$sql = 'SELECT c.cat_title, f.*
		FROM '. FORUMS_TABLE .' f, '. CATEGORIES_TABLE ." c
		WHERE f.cat_id = c.cat_id
			$where_sql
		ORDER BY c.cat_order, f.cat_id, f.forum_order";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
	}

	if ($rowset = $db->sql_fetchrowset($result))
	{
		foreach ($rowset as $rid => $row)
		{
			$forums[$row['cat_id']]['cat_title'] = $row['cat_title'];
			$forums[$row['cat_id']]['f'][$row['forum_id']] = $row;
			$forums[$row['cat_id']]['f_ord'][$row['forum_order']] = $row;
		}
	}

	return $forums;
}

function get_sf_count ($forum_id)
{
	global $cat_forums;

	$sf_count = 0;

	foreach ($cat_forums as $cid => $c)
	{
		foreach ($c['f'] as $fid => $f)
		{
			if ($f['forum_parent'] == $forum_id)
			{
				$sf_count++;
			}
		}
	}

	return $sf_count;
}

function get_prev_root_forum_id ($forums, $curr_forum_order)
{
	$i = $curr_forum_order - 10;

	while ($i > 0)
	{
		if (isset($forums[$i]) && !$forums[$i]['forum_parent'])
		{
			return $forums[$i]['forum_id'];
		}
		$i = $i - 10;
	}

  return FALSE;
}

function get_next_root_forum_id ($forums, $curr_forum_order)
{
	$i = $curr_forum_order + 10;
	$limit = (count($forums) * 10) + 10;

	while ($i < $limit)
	{
		if (isset($forums[$i]) && !$forums[$i]['forum_parent'])
		{
			return $forums[$i]['forum_id'];
		}
		$i = $i + 10;
	}

  return FALSE;
}

function get_orphan_sf ()
{
	global $cat_forums;

	$last_root = 0;
	$bad_sf_ary = array();

	foreach ($cat_forums as $cid => $c)
	{
		foreach ($c['f'] as $fid => $f)
		{
			if ($f['forum_parent'])
			{
				if ($f['forum_parent'] != $last_root)
				{
					$bad_sf_ary[] = $f['forum_id'];
				}
			}
			else
			{
				$last_root = $f['forum_id'];
			}
		}
	}

	return implode(',', $bad_sf_ary);
}

function fix_orphan_sf ($orphan_sf_sql = '', $show_mess = FALSE)
{
	global $db, $lang, $phpEx;

	$done_mess = '';

	if (!$orphan_sf_sql)
	{
		$orphan_sf_sql = get_orphan_sf();
	}

	if ($orphan_sf_sql)
	{
		$sql = 'UPDATE '. FORUMS_TABLE ." SET
				forum_parent = 0
			WHERE forum_id IN($orphan_sf_sql)";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Couldn't change subforums data", '', __LINE__, __FILE__, $sql);
		}

		if ($affectedrows = $db->sql_affectedrows())
		{
			$done_mess = "Subforums data corrected. <b>$affectedrows</b> orphan subforum(s) moved to root level.";
		}

		if ($show_mess)
		{
			$message = $done_mess . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
	}

	return $done_mess;
}

function sf_get_list ($mode, $exclude = 0, $select = 0)
{
	global $cat_forums, $forum_parent, $sl, $ds;

	$opt = '';

	if ($mode == 'forum')
	{
		foreach ($cat_forums as $cid => $c)
		{
			$opt .= '<optgroup label="&nbsp;'. $c['cat_title'] .'">';

			foreach ($c['f'] as $fid => $f)
			{
				$selected = ($fid == $select) ? $sl : '';
				$disabled = ($fid == $exclude && !$forum_parent) ? $ds : '';
				$style = ($disabled) ? ' style="color: gray" ' : (($fid == $exclude) ? ' style="color: darkred" ' : '');
				$opt .= '<option value="'. $fid .'" '. $selected . $disabled . $style .'>'. (($f['forum_parent']) ? SF_SEL_SPACER : '') . $f['forum_name'] ."&nbsp;</option>\n";
			}

			$opt .= '</optgroup>';
		}
	}

	return $opt;
}

function get_forum_data ($forum_id)
{
	global $cat_forums;

	foreach ($cat_forums as $cid => $c)
	{
		foreach ($c['f'] as $fid => $f)
		{
			if ($fid == $forum_id)
			{
				return $f;
			}
		}
	}

	return FALSE;
}

function get_max_cat_order ($cat_id)
{
	global $db;

	$sql = 'SELECT MAX(forum_order) AS max_order
		FROM '. FORUMS_TABLE ."
		WHERE cat_id = $cat_id";

	if (!$row = $db->sql_fetchrow($db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, "Couldn't get order number from forums table", "", __LINE__, __FILE__, $sql);
	}

	$max_order = (isset($row['max_order'])) ? $row['max_order'] : 0;

	return $max_order;
}

//
// End function block
// ------------------

//
// Begin program proper
//
$cat_forums = get_cat_forums();

if ($orphan_sf_sql = get_orphan_sf())
{
	fix_orphan_sf($orphan_sf_sql, TRUE);
}
$forum_parent = $cat_id = 0;
$forumname = '';

if (isset($_REQUEST['addforum']) || isset($_REQUEST['addcategory']))
{
	$mode = (isset($_REQUEST['addforum'])) ? "addforum" : "addcat";

	if ($mode == 'addforum' && isset($HTTP_POST_VARS['addforum']) && isset($HTTP_POST_VARS['forumname']) && is_array($HTTP_POST_VARS['addforum']))
	{
		list($cat_id) = each($HTTP_POST_VARS['addforum']);
		$cat_id = intval($cat_id);
		$forumname = stripslashes($HTTP_POST_VARS['forumname'][$cat_id]);
	}
}

if( !empty($mode) )
{
	switch($mode)
	{
		case 'addforum':
		case 'editforum':
			//
			// Show form to create/modify a forum
			//
			if ($mode == 'editforum')
			{
				// $newmode determines if we are going to INSERT or UPDATE after posting?

				$l_title = $lang['Edit_forum'];
				$newmode = 'modforum';
				$buttonvalue = $lang['Update'];

				$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

				$row = get_info('forum', $forum_id);

				$cat_id = $row['cat_id'];
				$forumname = $row['forum_name'];
				$forumdesc = $row['forum_desc'];
				$forumstatus = $row['forum_status'];
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				$forum_display_sort = $row['forum_display_sort'];
				$forum_display_order = $row['forum_display_order'];
//-- fin mod : topic display order -----------------------------------------------------------------
				$forum_parent = $row['forum_parent'];
				$show_on_index = $row['show_on_index'];

				//
				// start forum prune stuff.
				//
				if( $row['prune_enable'] )
				{
					$prune_enabled = "checked=\"checked\"";
					$sql = "SELECT *
						FROM " . PRUNE_TABLE . "
						WHERE forum_id = $forum_id";
					if(!$pr_result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, "Auto-Prune: Couldn't read auto_prune table.", __LINE__, __FILE__);
					}

					$pr_row = $db->sql_fetchrow($pr_result);
				}
				else
				{
					$prune_enabled = '';
				}

				//
				// start move topic 
				//
				if( $row['move_enable'] )
				{
					$move_enabled = "checked=\"checked\"";
					$sql = "SELECT *
	               			FROM ".TOPICS_MOVE_TABLE."
        	       			WHERE forum_id = $forum_id";
					if(!$move_result = $db->sql_query($sql))
					{
						 message_die(GENERAL_ERROR, "Automove: Couldn't read auto_move table.", __LINE__, __FILE__);
        			}

					$move_row = $db->sql_fetchrow($move_result);
				}
				else
				{
					$move_enabled = '';
				}
			      }
			      else
			      {
				$l_title = $lang['Create_forum'];
				$newmode = 'createforum';
				$buttonvalue = $lang['Create_forum'];

				$forumdesc = '';
				$forumstatus = FORUM_UNLOCKED;
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				$forum_display_sort = 0;
				$forum_display_order = 0;
//-- fin mod : topic display order -----------------------------------------------------------------
				$forum_id = '';
				$prune_enabled = '';
				$move_enabled = '';
				$show_on_index = 1;
			}

			if (isset($_REQUEST['forum_parent']))
			{
				$forum_parent = intval($_REQUEST['forum_parent']);

				if ($parent = get_forum_data($forum_parent))
				{
					$cat_id = $parent['cat_id'];
				}
			}

			$catlist = get_list('category', $cat_id, TRUE);
			$forumlocked = $forumunlocked = '';

			$forumstatus == ( FORUM_LOCKED ) ? $forumlocked = "selected=\"selected\"" : $forumunlocked = "selected=\"selected\"";

			// These two options ($lang['Status_unlocked'] and $lang['Status_locked']) seem to be missing from
			// the language files.
			$lang['Status_unlocked'] = isset($lang['Status_unlocked']) ? $lang['Status_unlocked'] : 'Unlocked';
			$lang['Status_locked'] = isset($lang['Status_locked']) ? $lang['Status_locked'] : 'Locked';

			$statuslist = "<option value=\"" . FORUM_UNLOCKED . "\" $forumunlocked>" . $lang['Status_unlocked'] . "</option>\n";
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";

			$template->set_filenames(array(
				"body" => "admin/forum_edit_body.tpl")
			);
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
			$forum_display_sort_list = get_forum_display_sort_option($forum_display_sort, 'list', 'sort');
			$forum_display_order_list = get_forum_display_sort_option($forum_display_order, 'list', 'order');
//-- fin mod : topic display order -----------------------------------------------------------------

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			$s_parent = '<option value="-1">&nbsp;'. $lang['SF_No_parent'] ."</option>\n";
			$sel_forum = ($forum_parent && !isset($_REQUEST['forum_parent'])) ? $forum_id : $forum_parent;
			$s_parent .= sf_get_list('forum', $forum_id, $sel_forum);

			$template->assign_vars(array(
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				'L_FORUM_DISPLAY_SORT'			=> $lang['Sort_by'],
				'S_FORUM_DISPLAY_SORT_LIST'		=> $forum_display_sort_list,
				'S_FORUM_DISPLAY_ORDER_LIST'	=> $forum_display_order_list,
//-- fin mod : topic display order -----------------------------------------------------------------
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_SUBMIT_VALUE' => $buttonvalue,
				'S_CAT_LIST' => $catlist,
				'S_STATUS_LIST' => $statuslist,
				'S_PRUNE_ENABLED' => $prune_enabled,
				'S_MOVE_ENABLED' => $move_enabled,

				'SHOW_ON_INDEX' => $show_on_index,
				'L_SHOW_ON_INDEX' => $lang['SF_Show_on_index'],
				'L_PARENT_FORUM' => $lang['SF_Parent_forum'],
				'S_PARENT_FORUM' => $s_parent,
				'CAT_LIST_CLASS' => ($forum_parent) ? 'hiddenRow' : '',
				'SHOW_ON_INDEX_CLASS' => (!$forum_parent) ? 'hiddenRow' : '',

				'L_FORUM_TITLE' => $l_title,
				'L_FORUM_EXPLAIN' => $lang['Forum_edit_delete_explain'],
				'L_FORUM_SETTINGS' => $lang['Forum_settings'],
				'L_FORUM_NAME' => $lang['Forum_name'],
				'L_CATEGORY' => $lang['Category'],
				'L_FORUM_DESCRIPTION' => $lang['Forum_desc'],
				'L_FORUM_STATUS' => $lang['Forum_status'],
				'L_AUTO_PRUNE' => $lang['Forum_pruning'],
				'L_ENABLED' => $lang['Enabled'],
				'L_PRUNE_DAYS' => $lang['prune_days'],
				'L_PRUNE_FREQ' => $lang['prune_freq'],
				'L_DAYS' => $lang['Days'],

				'PRUNE_DAYS' => ( isset($pr_row['prune_days']) ) ? $pr_row['prune_days'] : 7,
				'PRUNE_FREQ' => ( isset($pr_row['prune_freq']) ) ? $pr_row['prune_freq'] : 1,
                        'WAITS_DAYS' => ( isset($move_row['waits_days']) ) ? $move_row['waits_days'] : 1,
				'CHECK_FREQ' => ( isset($move_row['check_freq']) ) ? $move_row['check_freq'] : 1,
				'MOVE_FID' => ( isset($move_row['move_fid']) ) ? $move_row['move_fid'] : 'id?',

                        'RECYCLE_WAITS_DAYS' => ( isset($move_row['recycle_waits_days']) ) ? $move_row['recycle_waits_days'] : 1,
				'RECYCLE_CHECK_FREQ' => ( isset($move_row['recycle_check_freq']) ) ? $move_row['recycle_check_freq'] : 1,
				'RECYCLE_MOVE_FID' => ( isset($move_row['recycle_move_fid']) ) ? $move_row['recycle_move_fid'] : 'id?',

				'FORUM_NAME' => $forumname,
				'DESCRIPTION' => $forumdesc)
			);
			$template->pparse("body");
			break;

		// Create a forum in the DB
		case 'createforum':

			$cat_id = intval($HTTP_POST_VARS[POST_CAT_URL]);
			$forum_name = str_replace("\'", "''", trim($HTTP_POST_VARS['forumname']));
			$forum_desc = str_replace("\'", "''", trim($HTTP_POST_VARS['forumdesc']));
			$forum_status = intval($HTTP_POST_VARS['forumstatus']);
			$prune_enable = (isset($HTTP_POST_VARS['prune_enable'])) ? 1 : 0;
			$move_enable = (isset($HTTP_POST_VARS['move_enable'])) ? 1 : 0;
			$waits_days = intval($HTTP_POST_VARS['waits_days']);
			$check_freq = intval($HTTP_POST_VARS['check_freq']);
			$move_fid = intval($HTTP_POST_VARS['move_fid']);
			$recycle_waits_days = intval($HTTP_POST_VARS['recycle_waits_days']);
			$recycle_check_freq = intval($HTTP_POST_VARS['recycle_check_freq']);
			$recycle_move_fid = intval($HTTP_POST_VARS['recycle_move_fid']);

			$prune_days = intval($HTTP_POST_VARS['prune_days']);
			$prune_freq = intval($HTTP_POST_VARS['prune_freq']);
			$forum_parent = ($HTTP_POST_VARS['forum_parent'] != -1) ? intval($HTTP_POST_VARS['forum_parent']) : 0;
			$show_on_index = intval($HTTP_POST_VARS['show_on_index']);

			if (!$forum_name)
			{
				message_die(GENERAL_ERROR, "Can't create a forum without a name");
			}

			if ($forum_parent)
			{
				if (!$parent = get_forum_data($forum_parent))
				{
					message_die(GENERAL_ERROR, "Parent forum with <b>id=$forum_parent</b> not found");
				}

				$cat_id = $parent['cat_id'];
				$forum_parent = ($parent['forum_parent']) ? $parent['forum_parent'] : $parent['forum_id'];
				$forum_order = $parent['forum_order'] + 5;
			}
			else
			{
				$max_order = get_max_cat_order($cat_id);
				$forum_order = $max_order + 5;
			}

			$sql = 'SELECT MAX(forum_id) AS max_id
				FROM '. FORUMS_TABLE;

			if (!$row = $db->sql_fetchrow($db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from forums table", "", __LINE__, __FILE__, $sql);
			}

			$max_id = (isset($row['max_id'])) ? $row['max_id'] : 1;
			$forum_id = $max_id + 1;

			// Default permissions of public forum
			$field_sql = $value_sql = '';

			foreach ($forum_auth_ary as $field => $value)
			{
				$field_sql .= ", $field";
				$value_sql .= ", $value";
			}
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
			$field_sql .= ', forum_display_sort';
			$value_sql .= ', ' . intval($HTTP_POST_VARS['forum_display_sort']);
			$field_sql .= ', forum_display_order';
			$value_sql .= ', ' . intval($HTTP_POST_VARS['forum_display_order']);
//-- fin mod : topic display order -----------------------------------------------------------------

			$columns = 'forum_id,  forum_name,  cat_id,  forum_desc,  forum_order,  forum_status,  prune_enable,  move_enable,  forum_parent,  show_on_index'. $field_sql;
			$values = "$forum_id, '$forum_name', $cat_id, '$forum_desc', $forum_order, $forum_status, $prune_enable, $move_enable, $forum_parent, $show_on_index". $value_sql;

			$sql = 'INSERT INTO '. FORUMS_TABLE ." ($columns) VALUES ($values)";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in forums table", '', __LINE__, __FILE__, $sql);
			}

			if ($move_enable)
			{

				if( !$waits_days || !$check_freq || !$move_fid || !$recycle_waits_days || !$recycle_check_freq || !$recycle_move_fid)
				{
					message_die(GENERAL_MESSAGE, 'Заполните все поля');
				}

				$columns = 'forum_id,  waits_days,  check_freq, move_fid, recycle_waits_days, recycle_check_freq, recycle_move_fid';
				$values = "$forum_id,  $waits_days,  $check_freq, $move_fid, $recycle_waits_days, $recycle_check_freq, $recycle_move_fid";

				$sql = "INSERT INTO ".TOPICS_MOVE_TABLE." ($columns) VALUES($values)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't insert row in move table", "", __LINE__, __FILE__, $sql);
				}
			}

			if ($prune_enable)
			{
				if (!$prune_days || !$prune_freq)
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$columns = 'forum_id,  prune_days,  prune_freq';
				$values = "$forum_id, $prune_days, $prune_freq";

				$sql = 'INSERT INTO '. PRUNE_TABLE ." ($columns) VALUES ($values)";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't insert row in prune table", '', __LINE__, __FILE__, $sql);
				}
			}

			renumber_order('forum', $cat_id);

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);

			break;

		// Modify a forum in the DB
		case 'modforum':

			$cat_id = intval($HTTP_POST_VARS[POST_CAT_URL]);
			$forum_id = intval($HTTP_POST_VARS[POST_FORUM_URL]);
			$forum_name = str_replace("\'", "''", trim($HTTP_POST_VARS['forumname']));
			$forum_desc = str_replace("\'", "''", trim($HTTP_POST_VARS['forumdesc']));
			$forum_status = intval($HTTP_POST_VARS['forumstatus']);
			$prune_enable = (isset($HTTP_POST_VARS['prune_enable'])) ? 1 : 0;
			$move_enable = (isset($HTTP_POST_VARS['move_enable'])) ? 1 : 0;
			$waits_days = intval($HTTP_POST_VARS['waits_days']);
			$check_freq = intval($HTTP_POST_VARS['check_freq']);
			$move_fid = intval($HTTP_POST_VARS['move_fid']);
			$recycle_waits_days = intval($HTTP_POST_VARS['recycle_waits_days']);
			$recycle_check_freq = intval($HTTP_POST_VARS['recycle_check_freq']);
			$recycle_move_fid = intval($HTTP_POST_VARS['recycle_move_fid']);
			$prune_days = intval($HTTP_POST_VARS['prune_days']);
			$prune_freq = intval($HTTP_POST_VARS['prune_freq']);
			$forum_parent = ($HTTP_POST_VARS['forum_parent'] != -1) ? intval($HTTP_POST_VARS['forum_parent']) : 0;
			$show_on_index = intval($HTTP_POST_VARS['show_on_index']);
			$forum_display_order = intval($HTTP_POST_VARS['forum_display_order']);
			$forum_display_sort = intval($HTTP_POST_VARS['forum_display_sort']);

			$forum_data = get_forum_data($forum_id);
			$old_cat_id = $forum_data['cat_id'];
			$forum_order = $forum_data['forum_order'];

			if (!$forum_name)
			{
				message_die(GENERAL_ERROR, "Can't modify a forum without a name");
			}

			if ($forum_parent)
			{
				if (!$parent = get_forum_data($forum_parent))
				{
					message_die(GENERAL_ERROR, "Parent forum with <b>id=$forum_parent</b> not found");
				}

				$cat_id = $parent['cat_id'];
				$forum_parent = ($parent['forum_parent']) ? $parent['forum_parent'] : $parent['forum_id'];
				$forum_order = $parent['forum_order'] + 5;

				if ($forum_id == $forum_parent)
				{
					message_die(GENERAL_ERROR, "Ambiguous forum ID's. Please select other parent forum", '', __LINE__, __FILE__);
				}
			}
			else if ($cat_id != $old_cat_id)
			{
				$max_order = get_max_cat_order($cat_id);
				$forum_order = $max_order + 5;
			}

			$sql = 'UPDATE '. FORUMS_TABLE ." SET
					forum_name = '$forum_name',
					cat_id = $cat_id,
					forum_desc = '$forum_desc',
					forum_order = $forum_order,
					forum_status = $forum_status,
					prune_enable = $prune_enable,
					move_enable = $move_enable,
					forum_parent = $forum_parent,
					show_on_index = $show_on_index,
					forum_display_order = $forum_display_order,
					forum_display_sort = $forum_display_sort
				WHERE forum_id = $forum_id";

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", '', __LINE__, __FILE__, $sql);
			}

			if ($move_enable)
			{

				if( !$waits_days || !$check_freq || !$move_fid || !$recycle_waits_days || !$recycle_check_freq || !$recycle_move_fid)
				{
					message_die(GENERAL_MESSAGE, 'Заполните все поля');
				}

				$sql = "SELECT *
					FROM ".TOPICS_MOVE_TABLE."
					WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get forum move Information","",__LINE__, __FILE__, $sql);
				}

				if( $db->sql_numrows($result) > 0 )
				{
					$sql = "UPDATE ".TOPICS_MOVE_TABLE." SET 
							waits_days = $waits_days, 
							check_freq = $check_freq, 
							move_fid = $move_fid, 
							recycle_waits_days = $recycle_waits_days, 
							recycle_check_freq = $recycle_check_freq, 
							recycle_move_fid = $recycle_move_fid
				 		WHERE forum_id = $forum_id";
				}
				else
				{
					$columns = 'forum_id,  waits_days,  check_freq, move_fid, recycle_waits_days, recycle_check_freq, recycle_move_fid';
					$values = "$forum_id,  $waits_days,  $check_freq, $move_fid, $recycle_waits_days, $recycle_check_freq, $recycle_move_fid";
	
					$sql = "INSERT INTO ".TOPICS_MOVE_TABLE." ($columns) VALUES($values)";
				}
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't Update Forum move Information","",__LINE__, __FILE__, $sql);
				}
			}

			if ($prune_enable)
			{
				if (!$prune_days || !$prune_freq)
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$sql = 'SELECT *
					FROM '. PRUNE_TABLE ."
					WHERE forum_id = $forum_id";

				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't get forum Prune Information", '', __LINE__, __FILE__, $sql);
				}

				if ($db->sql_numrows($result) > 0)
				{
					$sql = 'UPDATE '. PRUNE_TABLE ." SET
							prune_days = $prune_days,
							prune_freq = $prune_freq
				 		WHERE forum_id = $forum_id";
				}
				else
				{
					$columns = 'forum_id,  prune_days,  prune_freq';
					$values = "$forum_id, $prune_days, $prune_freq";

					$sql = 'INSERT INTO '. PRUNE_TABLE ." ($columns) VALUES ($values)";
				}

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't Update Forum Prune Information", '', __LINE__, __FILE__, $sql);
				}
			}

			renumber_order('forum', $old_cat_id);

			if ($cat_id != $old_cat_id)
			{
				renumber_order('forum', $cat_id);
			}

			$cat_forums = get_cat_forums();
			$fix = fix_orphan_sf();

			$message = $lang['Forums_updated'] . "<br /><br />";
			$message .= ($fix) ? "$fix<br /><br />" : '';
			$message .= sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'addcat':
			// Create a category in the DB
			if( trim($HTTP_POST_VARS['categoryname']) == '')
			{
				message_die(GENERAL_ERROR, "Can't create a category without a name");
			}

			$sql = "SELECT MAX(cat_order) AS max_order
				FROM " . CATEGORIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from categories table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_order = $row['max_order'];
			$next_order = $max_order + 10;

			//
			// There is no problem having duplicate forum names so we won't check for it.
			//
			$sql = "INSERT INTO " . CATEGORIES_TABLE . " (cat_title, cat_order)
				VALUES ('" . str_replace("\'", "''", $HTTP_POST_VARS['categoryname']) . "', $next_order)";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'editcat':
			//
			// Show form to edit a category
			//
			$newmode = 'modcat';
			$buttonvalue = $lang['Update'];

			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$row = get_info('category', $cat_id);
			$cat_title = $row['cat_title'];

			$template->set_filenames(array(
				"body" => "admin/category_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="' . POST_CAT_URL . '" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'CAT_TITLE' => $cat_title,

				'L_EDIT_CATEGORY' => $lang['Edit_Category'],
				'L_EDIT_CATEGORY_EXPLAIN' => $lang['Edit_Category_explain'],
				'L_CATEGORY' => $lang['Category'],

				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_SUBMIT_VALUE' => $buttonvalue,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"))
			);

			$template->pparse("body");
			break;

		case 'modcat':
			// Modify a category in the DB
			$sql = "UPDATE " . CATEGORIES_TABLE . "
				SET cat_title = '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_title']) . "'
				WHERE cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]);
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'deleteforum':
			// Show form to delete a forum
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$select_to = '<select name="to_id">';
			$select_to .= "<option value=\"-1\"$s>" . $lang['Delete_all_posts'] . "</option>\n";
			$select_to .= sf_get_list('forum', $forum_id, 0);
			$select_to .= '</select>';

			$buttonvalue = $lang['Move_and_Delete'];

			$newmode = 'movedelforum';

			$foruminfo = get_info('forum', $forum_id);
			$name = $foruminfo['forum_name'];

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $forum_id . '" />';

			$template->assign_vars(array(
				'NAME' => $name,

				'L_FORUM_DELETE' => $lang['Forum_delete'],
				'L_FORUM_DELETE_EXPLAIN' => $lang['Forum_delete_explain'],
				'L_MOVE_CONTENTS' => $lang['Move_contents'],
				'L_FORUM_NAME' => $lang['Forum_name'],

				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelforum':
			//
			// Move or delete a forum in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_id = intval($HTTP_POST_VARS['to_id']);
			$delete_old = @intval($HTTP_POST_VARS['delete_old']);

			// Either delete or move all posts in a forum
			if($to_id == -1)
			{
				// Delete polls in this forum
				$sql = "SELECT v.vote_id
					FROM " . VOTE_DESC_TABLE . " v, " . TOPICS_TABLE . " t
					WHERE t.forum_id = $from_id
						AND v.topic_id = t.topic_id";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, "Couldn't obtain list of vote ids", "", __LINE__, __FILE__, $sql);
				}

				if ($row = $db->sql_fetchrow($result))
				{
					$vote_ids = '';
					do
					{
						$vote_ids = (($vote_ids != '') ? ', ' : '') . $row['vote_id'];
					}
					while ($row = $db->sql_fetchrow($result));

					$sql = "DELETE FROM " . VOTE_DESC_TABLE . "
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);

					$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . "
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);

					$sql = "DELETE FROM " . VOTE_USERS_TABLE . "
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);
				}
				$db->sql_freeresult($result);

				include($phpbb_root_path . "includes/prune.$phpEx");
				prune($from_id, 0, true); // Delete everything from forum
			}
			else
			{
				$sql = "SELECT *
					FROM " . FORUMS_TABLE . "
					WHERE forum_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of forums", "", __LINE__, __FILE__, $sql);
				}

				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous forum ID's", "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . TOPICS_TABLE . "
					SET forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move topics to other forum", "", __LINE__, __FILE__, $sql);
				}
				$sql = "UPDATE " . POSTS_TABLE . "
					SET	forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move posts to other forum", "", __LINE__, __FILE__, $sql);
				}
				sync('forum', $to_id);
			}

			// Alter Mod level if appropriate - 2.0.4
			$sql = "SELECT ug.user_id
				FROM " . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug
				WHERE a.forum_id <> $from_id
					AND a.auth_mod = 1
					AND ug.group_id = a.group_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$user_ids = '';
				do
				{
					$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				$sql = "SELECT ug.user_id
					FROM " . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug
					WHERE a.forum_id = $from_id
						AND a.auth_mod = 1
						AND ug.group_id = a.group_id
						AND ug.user_id NOT IN ($user_ids)";
				if( !$result2 = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
				}

				if ($row = $db->sql_fetchrow($result2))
				{
					$user_ids = '';
					do
					{
						$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
					}
					while ($row = $db->sql_fetchrow($result2));

					$sql = "UPDATE " . USERS_TABLE . "
						SET user_level = " . USER . "
						WHERE user_id IN ($user_ids)
							AND user_level <> " . ADMIN;
					$db->sql_query($sql);
				}
				$db->sql_freeresult($result);

			}
			$db->sql_freeresult($result2);

			$sql = "DELETE FROM " . FORUMS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM ".TOPICS_MOVE_TABLE."
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum move information!", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . PRUNE_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum prune information!", "", __LINE__, __FILE__, $sql);
			}

			fix_orphan_sf();

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'deletecat':
			//
			// Show form to delete a category
			//
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$buttonvalue = $lang['Move_and_Delete'];
			$newmode = 'movedelcat';
			$catinfo = get_info('category', $cat_id);
			$name = $catinfo['cat_title'];

			if ($catinfo['number'] == 1)
			{
				$sql = "SELECT count(*) as total
					FROM ". FORUMS_TABLE;
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get Forum count", "", __LINE__, __FILE__, $sql);
				}
				$count = $db->sql_fetchrow($result);
				$count = $count['total'];

				if ($count > 0)
				{
					message_die(GENERAL_ERROR, $lang['Must_delete_forums']);
				}
				else
				{
					$select_to = $lang['Nowhere_to_move'];
				}
			}
			else
			{
				$select_to = '<select name="to_id">';
				$select_to .= get_list('category', $cat_id, 0);
				$select_to .= '</select>';
			}

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'NAME' => $name,

				'L_FORUM_DELETE' => $lang['Forum_delete'],
				'L_FORUM_DELETE_EXPLAIN' => $lang['Forum_delete_explain'],
				'L_MOVE_CONTENTS' => $lang['Move_contents'],
				'L_FORUM_NAME' => $lang['Forum_name'],

				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelcat':
			//
			// Move or delete a category in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_id = intval($HTTP_POST_VARS['to_id']);

			if (!empty($to_id))
			{
				$sql = "SELECT *
					FROM " . CATEGORIES_TABLE . "
					WHERE cat_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of categories", "", __LINE__, __FILE__, $sql);
				}
				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous category ID's", "", __LINE__, __FILE__);
				}

				$order_shear = get_max_cat_order($to_id) + 10;

				$sql = 'UPDATE '. FORUMS_TABLE ." SET
						cat_id = $to_id,
						forum_order = forum_order + $order_shear
					WHERE cat_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move forums to other category", "", __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE FROM " . CATEGORIES_TABLE ."
				WHERE cat_id = $from_id";

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
			}

			renumber_order('forum', $to_id);
			$cat_forums = get_cat_forums();
			$fix = fix_orphan_sf();

			$message = $lang['Forums_updated'] . "<br /><br />";
			$message .= ($fix) ? "$fix<br /><br />" : '';
			$message .= sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'forum_order':
			//
			// Change order of forums in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$forum_info = get_info('forum', $forum_id);
			renumber_order('forum', $forum_info['cat_id']);

			$cat_id = $forum_info['cat_id'];

			$show_index = TRUE;
			$move_down_forum_id = FALSE;
			$forums = $cat_forums[$cat_id]['f_ord'];
			$forum_order = $forum_info['forum_order'];
			$prev_forum = (isset($forums[$forum_order - 10])) ? $forums[$forum_order - 10] : FALSE;
			$next_forum = (isset($forums[$forum_order + 10])) ? $forums[$forum_order + 10] : FALSE;

			// move selected forum ($forum_id) UP
			if ($move < 0 && $prev_forum)
			{
				if ($forum_info['forum_parent'] && $prev_forum['forum_parent'] != $forum_info['forum_parent'])
				{
					break;
				}
				else if ($move_down_forum_id = get_prev_root_forum_id($forums, $forum_order))
				{
					$move_up_forum_id = $forum_id;
					$move_down_ord_val = (get_sf_count($forum_id) + 1) * 10;
					$move_up_ord_val = ((get_sf_count($move_down_forum_id) + 1) * 10) + $move_down_ord_val;
					$move_down_forum_order = $cat_forums[$cat_id]['f'][$move_down_forum_id]['forum_order'];
				}
			}
			// move selected forum ($forum_id) DOWN
			else if ($move > 0 && $next_forum)
			{
				if ($forum_info['forum_parent'] && $next_forum['forum_parent'] != $forum_info['forum_parent'])
				{
					break;
				}
				else if ($move_up_forum_id = get_next_root_forum_id($forums, $forum_order))
				{
					$move_down_forum_id = $forum_id;
					$move_down_forum_order = $forum_order;
					$move_down_ord_val = (get_sf_count($move_up_forum_id) + 1) * 10;
					$move_up_ord_val = ((get_sf_count($move_down_forum_id) + 1) * 10) + $move_down_ord_val;
				}
			}
			else
			{
				break;
			}

			if ($forum_info['forum_parent'])
			{
				$sql = 'UPDATE ' . FORUMS_TABLE . " SET
						forum_order = forum_order + $move
					WHERE forum_id = $forum_id";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't change forum order", '', __LINE__, __FILE__, $sql);
				}
			}
			else if ($move_down_forum_id)
			{
				$sql = 'UPDATE '. FORUMS_TABLE ." SET
						forum_order = forum_order + $move_down_ord_val
					WHERE cat_id = $cat_id
						AND forum_order >= $move_down_forum_order";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't change forum order", '', __LINE__, __FILE__, $sql);
				}

				$sql = 'UPDATE '. FORUMS_TABLE ." SET
						forum_order = forum_order - $move_up_ord_val
					WHERE forum_id = $move_up_forum_id
						 OR forum_parent = $move_up_forum_id";

				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't change forum order", '', __LINE__, __FILE__, $sql);
				}
			}

			renumber_order('forum', $forum_info['cat_id']);

			break;

		case 'cat_order':
			//
			// Change order of categories in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$sql = "UPDATE " . CATEGORIES_TABLE . "
				SET cat_order = cat_order + $move
				WHERE cat_id = $cat_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
			}

			renumber_order('category');
			$show_index = TRUE;

			break;

		case 'forum_sync':
			sync('forum', intval($HTTP_GET_VARS[POST_FORUM_URL]));
			$show_index = TRUE;

			break;

		default:
			message_die(GENERAL_MESSAGE, $lang['No_mode']);
			break;
	}

	if ($show_index != TRUE)
	{
		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}

//
// Start page proper
//
$template->set_filenames(array(
	"body" => "admin/forum_admin_body.tpl")
);

$template->assign_vars(array(
	'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
	'L_FORUM_TITLE' => $lang['Forum_admin'],
	'L_FORUM_EXPLAIN' => $lang['Forum_admin_explain'],
	'L_CREATE_FORUM' => $lang['Create_forum'],
	'L_CREATE_CATEGORY' => $lang['Create_category'],
	'L_EDIT' => $lang['Edit'],
	'L_DELETE' => $lang['Delete'],
	'L_MOVE_UP' => $lang['Move_up'],
	'L_MOVE_DOWN' => $lang['Move_down'],
	'L_RESYNC' => $lang['Resync'])
);

$sql = "SELECT cat_id, cat_title, cat_order
	FROM " . CATEGORIES_TABLE . "
	ORDER BY cat_order";
if( !$q_categories = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
}

if( $total_categories = $db->sql_numrows($q_categories) )
{
	$category_rows = $db->sql_fetchrowset($q_categories);

	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		ORDER BY cat_id, forum_order";
	if(!$q_forums = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query forums information", "", __LINE__, __FILE__, $sql);
	}

	if( $total_forums = $db->sql_numrows($q_forums) )
	{
		$forum_rows = $db->sql_fetchrowset($q_forums);
	}

	//
	// Okay, let's build the index
	//
	$gen_cat = array();

	$bgr_class_1    = 'prow1';
	$bgr_class_2    = 'prow2';
	$bgr_class_over = 'prow3';

	for($i = 0; $i < $total_categories; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];

		$template->assign_block_vars("catrow", array(
			'S_ADD_FORUM_SUBMIT' => "addforum[$cat_id]",
			'S_ADD_FORUM_NAME' => "forumname[$cat_id]",

			'CAT_ID' => $cat_id,
			'CAT_DESC' => $category_rows[$i]['cat_title'],

			'U_CAT_EDIT' => append_sid("admin_forums.$phpEx?mode=editcat&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_DELETE' => append_sid("admin_forums.$phpEx?mode=deletecat&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_MOVE_UP' => append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=-15&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_MOVE_DOWN' => append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=15&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_VIEWCAT' => append_sid($phpbb_root_path."index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
		);

		for($j = 0; $j < $total_forums; $j++)
		{
			$forum_id = $forum_rows[$j]['forum_id'];

			$bgr_class = (!($j % 2)) ? $bgr_class_2 : $bgr_class_1;
			$row_bgr   = " class=\"$bgr_class\" onmouseover=\"this.className='$bgr_class_over';\" onmouseout=\"this.className='$bgr_class';\"";

			if ($forum_rows[$j]['cat_id'] == $cat_id)
			{

				$template->assign_block_vars("catrow.forumrow",	array(
					'FORUM_NAME' => $forum_rows[$j]['forum_name'],
					'FORUM_DESC' => $forum_rows[$j]['forum_desc'],
					'NUM_TOPICS' => $forum_rows[$j]['forum_topics'],
					'NUM_POSTS' => $forum_rows[$j]['forum_posts'],

					'ORDER' => $forum_rows[$j]['forum_order'],
					'FORUM_ID' => $forum_rows[$j]['forum_id'],
					'FORUM_PARENT' => $forum_rows[$j]['forum_parent'],
					'SF_PAD' => ($forum_rows[$j]['forum_parent']) ? ' style="padding-left: 20px;" ' : '',
					'FORUM_NAME_CLASS' => ($forum_rows[$j]['forum_parent']) ? 'genmed' : 'gen',
					'ROW_BGR' => $row_bgr,
					'ADD_SUB_HREF' => append_sid("admin_forums.$phpEx?mode=addforum&amp;forum_parent={$forum_rows[$j]['forum_id']}"),

					'U_VIEWFORUM' => append_sid($phpbb_root_path."viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_EDIT' => append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_DELETE' => append_sid("admin_forums.$phpEx?mode=deleteforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_UP' => append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=-15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_DOWN' => append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_RESYNC' => append_sid("admin_forums.$phpEx?mode=forum_sync&amp;" . POST_FORUM_URL . "=$forum_id"))
				);

			}// if ... forumid == catid

		} // for ... forums

	} // for ... categories

}// if ... total_categories

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>