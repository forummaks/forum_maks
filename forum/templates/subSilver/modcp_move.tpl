
<form action="{S_MODCP_ACTION}" method="post">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
	  <td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
  </table>
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
	  <th height="25" class="thHead"><b>{MESSAGE_TITLE}</b></th>
	</tr>
	<tr>
	  <td class="row1">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
					<td align="center"><span class="gen">{L_MOVE_TO_FORUM} &nbsp; {S_FORUM_SELECT}<br />
						<!-- //bt -->
						<table border="0" cellspacing="0" cellpadding="12"><tr><td>
						<!-- BEGIN switch_show_leaveshadow -->
						<div><input type="checkbox" name="move_leave_shadow" id="move_leave_shadow" /><label for="move_leave_shadow">{L_LEAVESHADOW}</label></div>
						<!-- END switch_show_leaveshadow -->
						<!-- //bt end -->
						<!-- //bot -->
						<!-- BEGIN switch_show_leave_msg -->
						<div><input type="checkbox" name="insert_msg" id="insert_msg" checked="checked" /><label for="insert_msg">{L_LEAVE_MSG}</label></div>
						<!-- END switch_show_leave_msg -->
						<!-- //bot end -->
						</td></tr></table>
			  {MESSAGE_TEXT}</span><br />
			  <br />
			  {S_HIDDEN_FIELDS}
			  <input class="mainoption" type="submit" name="confirm" value="{L_YES}" />
			  &nbsp;&nbsp;
			  <input class="liteoption" type="submit" name="cancel" value="{L_NO}" />
			</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</form>