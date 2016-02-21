<script language="JavaScript">
<!--
function toggle_cbox (cb_id, tr_id)
{
	var cb = document.getElementById(cb_id);
	var tr = document.getElementById(tr_id);
	cb.checked	= (cb.checked) ? 0 : 1;
	if (cb.checked) {
		tr.className = 'sel';
	}
	else {
		tr.className = ( !(tr_id % 2) ) ? 'row1' : 'row2';
	}
	return false;
}
//-->
</script>
<style type="text/css">
<!--
.sel { background-color:#FFEFD5; }
-->
</style>

<form method="post" action="{S_SPLIT_ACTION}" style="display: inline">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
  <td style="padding-left: 0px;" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a><span class="nav">
		» <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
	</tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
  <th height="25" class="thHead" colspan="2" nowrap="nowrap">{L_SPLIT_TOPIC}</th>
	</tr>
	<tr>
  <td class="row2" colspan="2" align="center"><span class="gensmall">{L_SPLIT_TOPIC_EXPLAIN}</span></td>
	</tr>
	<tr>
	 <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_SUBJECT}</span></td>
	 <td class="row2"><input class="post" type="text" size="35" style="width: 500px" maxlength="120" name="subject" /></td>
	</tr>
	<tr>
	 <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_FORUM}</span></td>
	 <td class="row2">{S_FORUM_SELECT}</td>
	</tr>
	<!-- //bot -->
	<tr>
		<td colspan="2" class="row2" align="center" style="padding: 0px">
	 	<table cellspacing="2" cellpadding="2" border="0">
	 		<tr>
				 <td class="row2" align="center"><span class="gen"><input type="checkbox" name="after_split_to_old" id="after_split_to_old" checked="checked" /><label for="after_split_to_old"> {L_AFTER_SPLIT_TO_OLD}</label></span></td>
				 <td>&nbsp;</td>
				 <td class="row2" align="center"><span class="gen"><input type="checkbox" name="after_split_to_new" id="after_split_to_new" checked="checked" /><label for="after_split_to_new"> {L_AFTER_SPLIT_TO_NEW}</label></span></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- //bot end -->
	<tr>
	 <td height="28" colspan="2" align="center" class="catBottom">
			<input class="liteoption" type="submit" name="delete_posts" value="{L_DELETE_POSTS}" style="width: 140px;" />
			<input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" style="width: 210px;" />
			<input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" style="width: 270px;" />
	 </td>
	</tr>
</table>
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
	 <th class="thCornerL" nowrap="nowrap">#</th>
	 <th class="thTop" nowrap="nowrap">{L_AUTHOR}</th>
	 <th class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
	</tr>
	<!-- BEGIN postrow -->
	<tr <!-- IF postrow.CHECKBOX -->id="{postrow.ROW_ID}" onclick="toggle_cbox('{postrow.CB_ID}', '{postrow.ROW_ID}');"<!-- ENDIF --> class="{postrow.ROW_CLASS}">
	 <td align="center"><!-- IF postrow.CHECKBOX --><input type="checkbox" name="post_id_list[]" value="{postrow.POST_ID}" id="{postrow.CB_ID}" onclick="toggle_cbox('{postrow.CB_ID}', '{postrow.ROW_ID}');" /><!-- ENDIF --></td>
	 <td valign="top"><span class="name"><a name="{postrow.POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span></td>
	 <td width="100%" valign="top">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
		  <tr>
					<td valign="top"><span class="postdetails">{postrow.POST_DATE}&nbsp;&nbsp;{postrow.POST_SUBJECT}</span><br /><hr /></td>
		  </tr>
		  <tr>
					<td valign="top">
			  <span class="postbody">{postrow.MESSAGE}</span></td>
		  </tr>
			</table>
	 </td>
	</tr>
	<!-- END postrow -->
	<tr>
		<td class="catBottom" align="center" colspan="3" height="28">
			<input type="hidden" name="confirm" value="1" />
			<input class="liteoption" type="submit" name="delete_posts" value="{L_DELETE_POSTS}" style="width: 140px;" />
			<input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" style="width: 210px;" />
			<input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" style="width: 270px;" />
		{S_HIDDEN_FIELDS}
		</td>
	</tr>
</table>
</form>