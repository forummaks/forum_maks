
<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>

<form method="post" action="{S_FORUM_ACTION}"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="7">{L_FORUM_TITLE}</th>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<td class="catLeft" align="center" valign="middle"><a class="gen" title="{L_MOVE_UP}" href="{catrow.U_CAT_MOVE_UP}"><b>&nbsp;&#8593;&nbsp;</b></a><a class="gen" title="{L_MOVE_DOWN}" href="{catrow.U_CAT_MOVE_DOWN}"><b>&nbsp;&#8595;&nbsp;</b></a></td>
		<td class="cat" colspan="3" valign="middle"><span class="cattitle"><b><a class="cattitle" href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></b></span></td>
		<td class="cat" align="center" valign="middle"><a class="gen" href="{catrow.U_CAT_EDIT}">{L_EDIT}</a></td>
		<td class="cat" align="center" valign="middle"><a class="gen" href="{catrow.U_CAT_DELETE}">{L_DELETE}</a></td>
		<td class="catRight" align="center" valign="middle"><span class="gen">&nbsp</span></td>
	</tr>
	<!-- BEGIN forumrow -->
	<tr{catrow.forumrow.ROW_BGR}>
		<td class="gen" align="center" valign="middle"><a class="gen" title="{L_MOVE_UP}" href="{catrow.forumrow.U_FORUM_MOVE_UP}"><b>&nbsp;&#8593;&nbsp;</b></a><a class="gen" title="{L_MOVE_DOWN}" href="{catrow.forumrow.U_FORUM_MOVE_DOWN}"><b>&nbsp;&#8595;&nbsp;</b></a></td>
		<td{catrow.forumrow.SF_PAD}><a title="{catrow.forumrow.FORUM_DESC}" class="{catrow.forumrow.FORUM_NAME_CLASS}" href="{catrow.forumrow.U_VIEWFORUM}" target="_new">{catrow.forumrow.FORUM_NAME}</a></td>
		<td class="gensmall" align="center" valign="middle" nowrap="nowrap"><a class="gensmall" href="{catrow.forumrow.ADD_SUB_HREF}" title="Add subforum">+sub</a><!-- <span title="Order index">{catrow.forumrow.ORDER} [{catrow.forumrow.FORUM_ID}-{catrow.forumrow.FORUM_PARENT}]</span> --></td>
		<td class="gensmall" align="center" valign="middle" nowrap="nowrap"><span title="Topics">{catrow.forumrow.NUM_TOPICS}</span> | <span title="Posts">{catrow.forumrow.NUM_POSTS}</span></td>
		<td class="genmed" align="center" valign="middle"><a class="genmed" href="{catrow.forumrow.U_FORUM_EDIT}">{L_EDIT}</a></td>
		<td class="genmed" align="center" valign="middle"><a class="genmed" href="{catrow.forumrow.U_FORUM_DELETE}">{L_DELETE}</a></td>
		<td class="genmed" align="center" valign="middle"><a class="genmed" href="{catrow.forumrow.U_FORUM_RESYNC}">{L_RESYNC}</a></td>
	</tr>
	<!-- END forumrow -->
	<tr>
		<td colspan="7" class="row2"><input class="post" type="text" name="{catrow.S_ADD_FORUM_NAME}" /> <input type="submit" class="liteoption"  name="{catrow.S_ADD_FORUM_SUBMIT}" value="{L_CREATE_FORUM}" /></td>
	</tr>
	<!-- END catrow -->
	<tr>
		<td colspan="7" class="catBottom"><input class="post" type="text" name="categoryname" /> <input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
	</tr>
</table></form>