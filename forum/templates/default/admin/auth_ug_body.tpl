
<h1>{L_AUTH_TITLE}</h1>

<h2>{L_USER_OR_GROUPNAME}: {USERNAME}</h2>

<form method="post" action="{S_AUTH_ACTION}">

<!-- BEGIN switch_user_auth -->
<p>{USER_LEVEL}</p>
<p>{USER_GROUP_MEMBERSHIPS}</p>
<!-- END switch_user_auth -->

<!-- BEGIN switch_group_auth -->
<p>{GROUP_MEMBERSHIP}</p>
<!-- END switch_group_auth -->

<h2>{L_PERMISSIONS}</h2>

<p>{L_AUTH_EXPLAIN}</p>

  <table cellspacing="1" cellpadding="2" border="0" align="center" class="forumline">
	<tr>
	  <th>{L_FORUM}</th>
	  <th>{L_MODERATOR_STATUS}</th>
	  <!-- BEGIN acltype -->
	  <th>{acltype.L_UG_ACL_TYPE}</th>
	  <!-- END acltype -->
	</tr>
	<!-- BEGIN forums -->
	<tr{forums.ROW_CLASS}>
	  <td class="gen" style="padding: 2px 6px 2px 6px">{forums.FORUM_NAME}</td>
	  <td class="gen" align="center">{forums.S_MOD_SELECT}</td>
	  <!-- BEGIN aclvalues -->
	  <td class="gen" align="center">{forums.aclvalues.S_ACL_SELECT}</td>
	  <!-- END aclvalues -->
	</tr>
	<!-- END forums -->
	<tr>
	  <th>{L_FORUM}</th>
	  <th>{L_MODERATOR_STATUS}</th>
	  <!-- BEGIN acltype -->
	  <th>{acltype.L_UG_ACL_TYPE}</th>
	  <!-- END acltype -->
	</tr>
	<tr>
	  <td colspan="{S_COLUMN_SPAN}" class="row1" align="center"> <span class="gensmall">{U_SWITCH_MODE}</span></td>
	</tr>
	<tr>
	  <td colspan="{S_COLUMN_SPAN}" class="catBottom" align="center">{S_HIDDEN_FIELDS}
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp;
		<input type="reset" value="{L_RESET}" class="liteoption" name="reset" />
	  </td>
	</tr>
  </table>
</form>