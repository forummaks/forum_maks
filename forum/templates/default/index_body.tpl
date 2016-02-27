
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="margin-top:3px">
  <tr>
	<td align="left" valign="bottom" class="mainmenu">
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_SEARCH_NEW}" class="mainmenu">{L_SEARCH_NEW}</a> &#0183; <a href="{U_SEARCH_SELF}" class="mainmenu">{L_SEARCH_SELF}</a> &#0183;
		<!-- END switch_user_logged_in -->
		<a href="{U_SEARCH_UNANSWERED}" class="mainmenu">{L_SEARCH_UNANSWERED}</a></td>
  </tr>
</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<!-- BEGIN catrow -->
<tr>
	<td class="cat" colspan="3" style="padding-left: 16px; height: 26px"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
</tr>
<!-- BEGIN forumrow -->
<tr>
	<td class="row1" align="center" valign="middle" height="30" style="padding: 7px 0px 7px 0px;"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" width="100%" valign="middle" style="padding: 4px 4px 5px 4px">
		<div class="forumlink"><a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a></div>
		<!-- IF catrow.forumrow.FORUM_DESC --><div class="genmed" style="margin-top: 1px">{catrow.forumrow.FORUM_DESC}</div><!-- ENDIF -->
		<!-- BEGIN sf -->
		<!-- IF catrow.forumrow.sf.SF_NUM == 1 -->
		<span class="genmed">{L_SUBFORUMS}:</span>
		<!-- ENDIF -->
		<img style="margin-right: 1px" src="{catrow.forumrow.sf.SF_IMG_SRC}" width="12" height="9" title="{catrow.forumrow.sf.SF_IMG_TITLE}"><a class="gensmall" href="{catrow.forumrow.sf.SF_HREF}" title="{catrow.forumrow.sf.SF_DESC}"><b>{catrow.forumrow.sf.SF_NAME}</b></a><!-- IF catrow.forumrow.sf.SF_LAST_SUBF --> <!-- ELSE -->, <!-- ENDIF -->
		<!-- END sf -->
		<!-- IF catrow.forumrow.MODERATORS --><div class="gensmall" style="margin-top: 2px">{catrow.forumrow.L_MODERATOR}: {catrow.forumrow.MODERATORS}</div><!-- ENDIF -->
	</td>
		<td class="row2" align="center" valign="middle" nowrap="nowrap" style="padding: 4px 12px 4px 12px;">
		<!-- BEGIN last -->
			<!-- IF catrow.forumrow.last.FORUM_LAST_POST && catrow.forumrow.last.LAST_POST_USER_NAME -->

				<!-- IF catrow.forumrow.last.SHOW_LAST_TOPIC -->
				<div class="genmed"><a class="genmed" title="{catrow.forumrow.last.LAST_TOPIC_TIP}" href="{catrow.forumrow.last.LAST_POST_HREF}">{catrow.forumrow.last.LAST_TOPIC_TITLE}</a></div>
				<div class="gensmall" style="margin-top:4px;">by
					<!-- IF catrow.forumrow.last.LAST_POST_USER_HREF -->
					<a class="gensmall" href="{catrow.forumrow.last.LAST_POST_USER_HREF}">{catrow.forumrow.last.LAST_POST_USER_NAME}</a>
					<!-- ELSE -->
					{catrow.forumrow.last.LAST_POST_USER_NAME}
					<!-- ENDIF -->
				&nbsp;{catrow.forumrow.last.LAST_POST_TIME}
				</div>

				<!-- ELSE -->
				<div class="gensmall">{catrow.forumrow.last.LAST_POST_TIME}</div>
				<div class="gensmall" style="margin-top:3px;">
				<!-- IF catrow.forumrow.last.LAST_POST_USER_HREF -->
					<a href="{catrow.forumrow.last.LAST_POST_USER_HREF}">{catrow.forumrow.last.LAST_POST_USER_NAME}</a>
				<!-- ELSE -->
					{catrow.forumrow.last.LAST_POST_USER_NAME}
				<!-- ENDIF -->
				<a href="{catrow.forumrow.last.LAST_POST_HREF}"><img src="{TEMPLATE}images/icon_latest_reply.gif" border="0" width="18" height="9" alt="" title="" /></a>
				</div>
				<!-- ENDIF -->

			<!-- ELSE -->
			<span class="genmed">{L_NO_POSTS}</span>
			<!-- ENDIF -->

		<!-- END last -->
	</td>
</tr>
<!-- END forumrow -->
<!-- END catrow -->
</table>

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr>
	<td align="left"><span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span></td>
		<!-- BEGIN switch_user_logged_in -->
		<!-- //bt -->
	<td align="right"><span class="gensmall"><a href="{U_SEARCH_DL_WILL}" class="gensmall">{L_SEARCH_DL_WILL} {L_SEARCH_DL}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_DOWN}" class="gensmall">{L_SEARCH_DL_DOWN}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_COMPLETE}" class="gensmall">{L_SEARCH_DL_COMPLETE}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_CANCEL}" class="gensmall">{L_SEARCH_DL_CANCEL}</a></span></td>
		<!-- //bt end -->
		<!-- END switch_user_logged_in -->
  </tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" style="padding-bottom: 4px;">
<tr>
	<td class="catHead" colspan="2" style="padding-left: 16px; height: 26px"><span class="cattitle">{L_STATS}</span></td>
</tr>
<tr>
	<td class="row1" align="center" valign="middle" rowspan="2"><img src="templates/default/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<td class="row1" align="left" width="100%">
	<div class="genmed" style="line-height: 16px;">{TOTAL_USERS}<br />{RECORD_USERS}<br />{NEWEST_USER}<br />{TOTAL_POSTS}<br />{L_TORRENTS}: <b style="color: blue;">{T_TORRENTS}</b>&nbsp; {L_ACT_TORRENTS}: <b>{T_ACT_TORRENTS}</b>&nbsp; {L_TORRENTS_SIZE}: <b>{T_TORRENTS_SIZE}</b><br />{L_PEER}: <b>{P_PEER}</b>&nbsp; {L_SEED}: <b class="seedmed">{P_SEED}</b>&nbsp; {L_LEECH}: <b class="leechmed">{P_LEECH}</b><br />{L_TRANSFER}: <b>{TR_TRANSFER}</b>&nbsp; {L_UP}: <b class="seedmed">{TR_UP}</b>&nbsp; {L_DOWN}: <b class="leechmed">{TR_DOWN}</b></div></td>
</tr>
</table>

<!-- BEGIN switch_user_logged_in -->
<table width="100%" cellpadding="3" cellspacing="1" border="0">
<tr>
	<td class="catHead" colspan="2" style="padding-left: 16px; height: 26px"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
</tr>
<tr>
	<td class="row1" align="center" valign="middle" rowspan="3"><img src="templates/default/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<td class="row1" align="left" width="100%"><div class="genmed" style="line-height: 16px;">
			<p>{TOTAL_USERS_ONLINE}</p>
			<p>{RECORD_USERS}</p>
			<!-- IF SHOW_ONLINE_LIST -->
			<a name="online"></a>
			<div id="online_userlist" style="margin-top: 4px;">{LOGGED_IN_USER_LIST}</div>

			<div class="hr1" style="margin: 5px 0 4px;"></div>
			<p id="online_time">{L_ONLINE_EXPLAIN}</p>
			<!-- ENDIF -->
		</div>
	</td>
</tr>
<tr>
    <td class="row1" align="right" width="100%">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td valign="top" align="right"><span class="gensmall">[ <b>{L_WHOSONLINE_ADMIN}</b> ] &nbsp; [ <b>{L_WHOSONLINE_MOD}</b> ]</span></td>
</tr>
</table>
</td>
</tr>
</table>
<!-- END switch_user_logged_in -->

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="right"><span class="gensmall">{CURRENT_TIME}<br />
      <!-- BEGIN switch_user_logged_in -->
	{LAST_VISIT_DATE}<br />
	<!-- END switch_user_logged_in -->
	{S_TIMEZONE}</span></td>
</tr>
</table>

<br clear="all" />

<table cellspacing="3" border="0" align="center" cellpadding="0" style="margin-left: 160px">
  <tr>
	<td width="20" align="center"><img src="templates/default/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/default/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/default/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>