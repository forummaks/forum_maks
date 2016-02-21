<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="bottom"><a class="maintitle" href="{U_VIEW_FORUM}">{FORUM_NAME}</a><br /><span class="gensmall">{L_MODERATOR}: <b>{MODERATORS}</b><br /><br />{LOGGED_IN_USER_LIST}</span></td>
		<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b>{PAGINATION}</b></span></td>
	</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
		<td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a><!-- IF HAS_PARENT_FORUM --> -> <a class="nav" href="{PARENT_FORUM_HREF}">{PARENT_FORUM_NAME}</a><!-- ENDIF --> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
		<td align="right" valign="bottom" class="nav" nowrap="nowrap"><span class="gensmall"><a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a></span></td>
	</tr>
</table>

<!-- IF DISPLAY_SUBFORUMS -->
<table width="100%" cellpadding="1" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thCornerL" colspan="2" height="28" align="center">&nbsp;{L_FORUM}&nbsp;</th>
	<th class="thTop" align="center">&nbsp;{L_TOPICS}&nbsp;</th>
	<th class="thTop" align="center">&nbsp;{L_POSTS}&nbsp;</th>
	<th class="thCornerR" align="center">&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- BEGIN forumrow -->
<tr>
	<td class="row1" align="center" valign="middle" height="30" style="padding: 4px 0px 4px 0px;"><img src="{forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{forumrow.L_FORUM_FOLDER_ALT}" title="{forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" width="100%" valign="middle" style="padding: 4px">{forumrow.TOPIC_TYPE}
		<div class="forumlink"><a href="{forumrow.U_VIEWFORUM}" class="forumlink">{forumrow.FORUM_NAME}</a></div>
		<!-- IF forumrow.FORUM_DESC --><div class="genmed" style="margin-top: 2px">{forumrow.FORUM_DESC}</div><!-- ENDIF -->
		<!-- IF forumrow.MODERATORS --><div class="gensmall" style="margin-top: 1px">{forumrow.L_MODERATOR}: {forumrow.MODERATORS}</div><!-- ENDIF -->
	</td>
	<td class="row2" align="center" valign="middle"><span class="gensmall">{forumrow.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle"><span class="gensmall">{forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" nowrap="nowrap" style="padding: 4px 8px 4px 8px">
		<!-- BEGIN last -->
			<!-- IF forumrow.last.FORUM_LAST_POST -->

				<!-- IF forumrow.last.SHOW_LAST_TOPIC -->
				<div class="genmed"><a title="{forumrow.last.LAST_TOPIC_TIP}" href="{forumrow.last.LAST_TOPIC_HREF}">{forumrow.last.LAST_TOPIC_TITLE}</a> <a href="{forumrow.last.LAST_POST_HREF}"><img src="{TEMPLATE}images/icon_latest_reply.gif" border="0" width="18" height="9" alt="" title="" /></a></div>
				<div class="gensmall" style="margin-top:4px;">by
					<!-- IF forumrow.last.LAST_POST_USER_HREF -->
					<a href="{forumrow.last.LAST_POST_USER_HREF}">{forumrow.last.LAST_POST_USER_NAME}</a>
					<!-- ELSE -->
					{forumrow.last.LAST_POST_USER_NAME}
					<!-- ENDIF -->
				&nbsp;{forumrow.last.LAST_POST_TIME}
				</div>

				<!-- ELSE -->

				<div class="gensmall">{forumrow.last.LAST_POST_TIME}</div>
				<div class="gensmall" style="margin-top:3px;">
				<!-- IF forumrow.last.LAST_POST_USER_HREF -->
					<a href="{forumrow.last.LAST_POST_USER_HREF}">{forumrow.last.LAST_POST_USER_NAME}</a>
				<!-- ELSE -->
					{forumrow.last.LAST_POST_USER_NAME}
				<!-- ENDIF -->
				<a href="{forumrow.last.LAST_POST_HREF}"><img src="{TEMPLATE}images/icon_latest_reply.gif" border="0" width="18" height="9" alt="" title="" /></a>
				</div>

				<!-- ENDIF -->
			<!-- ELSE -->
			<span class="genmed">{L_NO_POSTS}</span>
			<!-- ENDIF -->
		<!-- END last -->
	</td>
</tr>
<!-- END forumrow -->
<!-- <tr>
	<td class="catBottom" align="center" valign="middle" colspan="5" height="25">&nbsp;</td>
</tr> -->
<tr>
	<td class="spaceRow" colspan="5" style="padding: 0px"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="5" /></td>
</tr>
</table>
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<!-- ENDIF -->

<form method="post" action="{S_POST_DAYS_ACTION}" style="display:inline">
<!-- IF TORRENT_TOPICS -->
<!-- INCLUDE viewforum_torrent.tpl -->
<!-- ELSE -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
	  <th class="thCornerL" colspan="2" align="center" height="28" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	  <th class="thTop" align="center" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	  <th class="thTop" align="center" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	  <th class="thTop" align="center" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	  <th class="thCornerR" align="center" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN topicrow -->
	<!-- IF topicrow.TOPICS_SEPARATOR -->
	<tr>
		<td class="row3" colspan="6" style="padding: 0px 0px 0px 12px; height: 23px"><span class="topicSep">{topicrow.TOPICS_SEPARATOR}</span></td>
	</tr>
	<!--	<tr>
		<td class="spaceRow" colspan="6" style="padding: 0px"><img src="templates/default/images/spacer.gif" alt="" width="1" height="5" /></td>
	</tr> -->
	<!-- ENDIF -->
	<tr>
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_ATTACHMENT_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row3" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
	  <td class="row3" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr>
	  <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
	<tr>
		<td class="catBottom" align="center" valign="middle" colspan="6" height="28">
			<span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;{S_DISPLAY_ORDER}
			<input type="submit" class="liteoption" value="{L_GO}" name="submit" /></span>
		</td>
	</tr>
</table>
<!-- ENDIF -->
</form>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
		<td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a><!-- IF HAS_PARENT_FORUM --> -> <a class="nav" href="{PARENT_FORUM_HREF}">{PARENT_FORUM_NAME}</a><!-- ENDIF --> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	 <td align="right" valign="middle" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span>
		</td>
	</tr>
</table>
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2" style="margin-top: 8px">
	<tr>
	  <td nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
	  <td align="right" nowrap="nowrap">{JUMPBOX}</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td class="gensmall">{S_AUTH_LIST}</td>
		<td align="center" valign="top"><table cellspacing="3" cellpadding="0" border="0">
			<tr>
				<td width="20" align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="19" height="18" /></td>
				<td class="gensmall">{L_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="19" height="18" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" width="19" height="18" /></td>
				<td class="gensmall">{L_ANNOUNCEMENT}</td>
			</tr>
			<tr>
				<td width="20" align="center"><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" width="19" height="18" /></td>
				<td class="gensmall">{L_NEW_POSTS_HOT}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" width="19" height="18" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" width="19" height="18" /></td>
				<td class="gensmall">{L_STICKY}</td>
			</tr>
			<tr>
				<td class="gensmall"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_LOCKED}" width="19" height="18" /></td>
				<td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
				<td>&nbsp;&nbsp;</td>
				<td class="gensmall"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_LOCKED}" width="19" height="18" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_DOWNLOAD_IMG}" alt="{L_DOWNLOAD}" width="19" height="18" /></td>
				<td class="gensmall">{L_DOWNLOAD}</td>
			</tr>
		</table></td>
	</tr>
</table>
