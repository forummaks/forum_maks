<script language="JavaScript">
<!--
function toggle_cat_list (val)
{
	if (val == -1) {
		document.getElementById('cat_list').className = '';
		document.getElementById('show_on_index').className = 'hiddenRow';
	}
	else {
		document.getElementById('cat_list').className = 'hiddenRow';
		document.getElementById('show_on_index').className = '';
	}
	return false;
}
//-->
</script>

<style type="text/css">
<!--
.hiddenRow { display:none; }
-->
</style>

<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>

<form name="frm" action="{S_FORUM_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="2">{L_FORUM_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_FORUM_NAME}</td>
		<td class="row2"><input type="text" size="25" name="forumname" value="{FORUM_NAME}" class="post" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FORUM_DESCRIPTION}</td>
		<td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="forumdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_PARENT_FORUM}</td>
		<td class="row2"><select onchange="toggle_cat_list(this.value)" name="forum_parent">{S_PARENT_FORUM}</select></td>
	</tr>
	<tr id="cat_list" class="{CAT_LIST_CLASS}">
		<td class="row1">{L_CATEGORY}</td>
		<td class="row2"><select name="c">{S_CAT_LIST}</select></td>
	</tr>
	<tr id="show_on_index" class="{SHOW_ON_INDEX_CLASS}">
		<td class="row1">{L_SHOW_ON_INDEX}</td>
		<td class="row2"><label for="show_on_index1"><input type="radio" name="show_on_index" id="show_on_index1" value="1" <!-- IF SHOW_ON_INDEX == 1 -->checked="checked"<!-- ENDIF -->  /> Yes&nbsp;</label><label for="show_on_index2">&nbsp;<input type="radio" name="show_on_index" id="show_on_index2" value="0" <!-- IF SHOW_ON_INDEX == 0 -->checked="checked"<!-- ENDIF --> /> No &nbsp;</label></td>
	</tr>
	<tr>
		<td class="row1">{L_FORUM_STATUS}</td>
		<td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
	<tr>
		<td class="row1">{L_AUTO_PRUNE}</td>
		<td class="row2"><table cellspacing="0" cellpadding="1" border="0">
			<tr>
			<td align="right" valign="middle">{L_ENABLED}</td>
			<td align="left" valign="middle"><input type="checkbox" name="prune_enable" value="1" {S_PRUNE_ENABLED} /></td>
			</tr>
			<tr>
			<td align="right" valign="middle">{L_PRUNE_DAYS}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_days" value="{PRUNE_DAYS}" size="5" class="post" />&nbsp;{L_DAYS}</td>
			</tr>
			<tr>
			<td align="right" valign="middle">{L_PRUNE_FREQ}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_freq" value="{PRUNE_FREQ}" size="5" class="post" />&nbsp;{L_DAYS}</td>
			</tr>
		</table></td>
	</tr>
	<tr> 
	  <td class="row1">Автоперенос тем.</td>
	  <td class="row2">
		Включено <input type="checkbox" name="move_enable" value="1" {S_MOVE_ENABLED} /><br>
		<fieldset class="fieldset" style="margin: 2px;">
			<legend>Автоперенос недооформленных тем.</legend>
			<div style="padding: 4px">
				<div class="gen" style="padding-bottom: 2px">
					Перенести недооформленные темы, если они не были исправлены в течении:<input type="text" name="waits_days" value="{WAITS_DAYS}" size="5" class="post" />&nbsp;{L_DAYS}<br> 
					Проверять срок исправления недооформленных тем каждыe: <input type="text" name="check_freq" value="{CHECK_FREQ}" size="5" class="post" />&nbsp;{L_DAYS}<br>
					Айди форума для неоформленных тем: <input type="text" name="move_fid" value="{MOVE_FID}" size="3" class="post" />&nbsp;id
				</div>
			</div>
		</fieldset>
		<fieldset class="fieldset" style="margin: 2px;">
			<legend>Автоперенос тем-повторов в "корзину".</legend>
			<div style="padding: 4px">
				<div class="gen" style="padding-bottom: 2px">
					Переносить темы-повторы, которым: <input type="text" name="recycle_waits_days" value="{RECYCLE_WAITS_DAYS}" size="5" class="post" />&nbsp;{L_DAYS}<br> 
					Проверять возраст тем-повторов каждыe: <input type="text" name="recycle_check_freq" value="{RECYCLE_CHECK_FREQ}" size="5" class="post" />&nbsp;{L_DAYS}<br>
					Айди форума для тем-повторов: <input type="text" name="recycle_move_fid" value="{RECYCLE_MOVE_FID}" size="3" class="post" />&nbsp;id
				</div>
			</div>
		</fieldset>

	</td>
	</tr>
	<tr>
		<td class="row1">{L_FORUM_DISPLAY_SORT}</td>
		<td class="row2">
			<select name="forum_display_sort">{S_FORUM_DISPLAY_SORT_LIST}</select>&nbsp;
			<select name="forum_display_order">{S_FORUM_DISPLAY_ORDER_LIST}</select>&nbsp;
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>

<br clear="all" />