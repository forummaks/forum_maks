<?php
if(!empty($setmodules))
{
	$module['Users']['Disallow'] = basename(__FILE__);
	return;
}
require('./pagestart.php');

if( isset($HTTP_POST_VARS['add_name']) )
{
	require(FT_ROOT . 'includes/functions_validate.php');

	$disallowed_user = ( isset($HTTP_POST_VARS['disallowed_user']) ) ? trim($HTTP_POST_VARS['disallowed_user']) : trim($HTTP_GET_VARS['disallowed_user']);

	if ($disallowed_user == '')
	{
		message_die(MESSAGE, $lang['Fields_empty']);
	}
	if( !validate_username($disallowed_user) )
	{
		$message = $lang['Disallowed_already'];
	}
	else
	{
		$sql = "INSERT INTO " . DISALLOW_TABLE . " (disallow_username)
			VALUES('" . str_replace("\'", "''", $disallowed_user) . "')";
		$result = DB()->sql_query( $sql );
		if ( !$result )
		{
			message_die(GENERAL_ERROR, "Could not add disallowed user.", "",__LINE__, __FILE__, $sql);
		}
		$message = $lang['Disallow_successful'];
	}

	$message .= "<br /><br />" . sprintf($lang['Click_return_disallowadmin'], "<a href=\"" . append_sid("admin_disallow.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}
else if( isset($HTTP_POST_VARS['delete_name']) )
{
	$disallowed_id = ( isset($HTTP_POST_VARS['disallowed_id']) ) ? intval( $HTTP_POST_VARS['disallowed_id'] ) : intval( $HTTP_GET_VARS['disallowed_id'] );

	$sql = "DELETE FROM " . DISALLOW_TABLE . "
		WHERE disallow_id = $disallowed_id";
	$result = DB()->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't removed disallowed user.", "",__LINE__, __FILE__, $sql);
	}

	$message .= $lang['Disallowed_deleted'] . "<br /><br />" . sprintf($lang['Click_return_disallowadmin'], "<a href=\"" . append_sid("admin_disallow.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);

}

//
// Grab the current list of disallowed usernames...
//
$sql = "SELECT *
	FROM " . DISALLOW_TABLE;
$result = DB()->sql_query($sql);
if( !$result )
{
	message_die(GENERAL_ERROR, "Couldn't get disallowed users.", "", __LINE__, __FILE__, $sql );
}

$disallowed = DB()->sql_fetchrowset($result);

//
// Ok now generate the info for the template, which will be put out no matter
// what mode we are in.
//
$disallow_select = '<select name="disallowed_id">';

if( @trim($disallowed) == "" )
{
	$disallow_select .= '<option value="">' . $lang['No'] . '</option>';
}
else
{
	$user = array();
	for( $i = 0; $i < count($disallowed); $i++ )
	{
		$disallow_select .= '<option value="' . $disallowed[$i]['disallow_id'] . '">' . $disallowed[$i]['disallow_username'] . '</option>';
	}
}

$disallow_select .= '</select>';

$template->set_filenames(array(
	"body" => "admin/disallow_body.tpl")
);

$template->assign_vars(array(
	"S_DISALLOW_SELECT" => $disallow_select,
	"S_FORM_ACTION" => append_sid("admin_disallow.php"),

//"L_INFO" => $output_info,
	"L_DISALLOW_TITLE" => $lang['Disallow_control'],
	"L_DISALLOW_EXPLAIN" => $lang['Disallow_explain'],
	"L_DELETE" => $lang['Delete_disallow'],
	"L_DELETE_DISALLOW" => $lang['Delete_disallow_title'],
	"L_DELETE_EXPLAIN" => $lang['Delete_disallow_explain'],
	"L_ADD" => $lang['Add_disallow'],
	"L_ADD_DISALLOW" => $lang['Add_disallow_title'],
	"L_ADD_EXPLAIN" => $lang['Add_disallow_explain'],
	"L_USERNAME" => $lang['Username'])
);

$template->pparse("body");

require('./page_footer_admin.php');