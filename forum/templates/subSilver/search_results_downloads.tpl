<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td valign="bottom"><span class="maintitle">{L_SEARCH_DESC}</span><br /><span class="gen">{L_SEARCH_MATCHES}</span><br /></td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
		<td align="right" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<form method="post" action="{S_DL_TOPICS_ACTION}" style="display: inline;">
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th height="25" class="thCornerL">&nbsp;</th>
		<th class="thTop" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
		<th class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
  <th class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
		<th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN searchresults -->
	<tr>
		<td class="row1" align="center" valign="middle" style="padding: 4px">{searchresults.DL_CHECKBOX}</td>
		<td class="row1" width="20%" align="center"><span class="gen"><a href="{searchresults.U_VIEW_FORUM}" class="gen">{searchresults.FORUM_NAME}</a></span></td>
		<td class="row1" width="80%"><span class="genmed">{searchresults.NEWEST_POST_IMG}<a href="{searchresults.U_VIEW_TOPIC}" class="genmed"><b>{searchresults.TOPIC_TITLE}</b></a></span></td>
		<td class="row1" align="center"><span class="name">{searchresults.TOPIC_AUTHOR}</span></td>
		<td class="row1" align="center" nowrap="nowrap"><span class="postdetails">{searchresults.LAST_POST_TIME}</span></td>
	</tr>
	<!-- END searchresults -->
	<tr>
	 <td class="catBottom" colspan="5" height="28" align="center" valign="middle">
	 <span class="genmed">&nbsp;
		<!-- BEGIN dl_status_controls -->
			<input type="submit" name="dl_set_will" value="{L_DL_WILL}" class="liteoption" />
			<input type="submit" name="dl_set_down" value="{L_DL_DOWN}" class="liteoption" />
			<input type="submit" name="dl_set_complete" value="{L_DL_COMPLETE}" class="liteoption" />
			<input type="submit" name="dl_set_cancel" value="{L_DL_CANCEL}" class="liteoption" />
			<input type="hidden" name="full_url" value="{U_FULL_URL}" />
			<input type="hidden" name="redirect_type" value="search" />
			<input type="hidden" name="mode" value="set_topics_dl_status" />
		<!-- END dl_status_controls -->
		&nbsp;</span>
		</td>
	</tr>
</table>
</form>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
	<tr>
		<td valign="top" align="right">{JUMPBOX}</td>
	</tr>
</table>