<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forumline">
	<tr>
		<th class="thCornerL" align="center" colspan="2" nowrap="nowrap"> Темы </th>

  <th class="thTop" align="center" nowrap="nowrap" title="{L_SEEDERS} | {L_LEECHERS}"> Торрент </th>
  <th class="thTop" align="center" nowrap="nowrap" title="{L_AUTHOR}"> Автор </th>

  <th class="thTop" align="center" nowrap="nowrap" title="{L_REPLIES} | {L_VIEWS}"> Отв. </th>
		<th class="thCornerR" align="center" nowrap="nowrap"> Посл. сообщение </th>
	</tr>
	<!-- BEGIN topicrow -->
	<!-- IF topicrow.TOPICS_SEPARATOR -->
	<tr>
		<td class="row3" colspan="6" style="padding: 0px 0px 0px 12px; height: 23px"><span class="topicSep">{topicrow.TOPICS_SEPARATOR}</span></td>
	</tr>
	<!--	<tr>
		<td class="spaceRow" colspan="6" style="padding: 0px"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="5" /></td>
	</tr> -->
	<!-- ENDIF -->
	<tr>
	 <td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
		<td class="row1" width="100%"><span class="topictitle">{topicrow.TOPIC_CHECK_STATUS}{topicrow.NEWEST_POST_IMG}<!-- {topicrow.TOPIC_ATTACHMENT_IMG} -->{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><br /><span class="gensmall" style="line-height: 160%">{topicrow.GOTO_PAGE}</span></td>

		<td class="row2" align="center" nowrap="nowrap" title="{L_DL}"><!-- BEGIN tor --><div class="gensmall" style="cursor: pointer" onClick="window.location.href='{topicrow.tor.DL_TORRENT_HREF}'"><div><span class="seedmed" title="{topicrow.tor.SEEDERS_TITLE}"><b>{topicrow.tor.SEEDERS}</b></span><span class="genmed"> | </span><span class="leechmed" title="Leechers"><b>{topicrow.tor.LEECHERS}</b></span></div><div class="gensmall" style="margin-top: 2px"><a href="{topicrow.tor.DL_TORRENT_HREF}" class="gensmall" style="text-decoration: none">{topicrow.tor.TORRENT_SIZE}</a></div></div><!-- END tor --></td>
		<td class="row3" align="center"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>

		<td class="row2" align="center" nowrap="nowrap"<!-- BEGIN compl --> title="{L_COMPLETED}: {topicrow.compl.COMPLETED}"<!-- END compl -->><span class="genmed" title="{L_REPLIES}">{topicrow.REPLIES}</span><span class="genmed"> | </span><span class="genmed" title="{L_VIEWS}">{topicrow.VIEWS}</span></td>
		<td class="row3" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr>
		<td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
	<tr>
		<td class="catBottom" align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;{S_DISPLAY_ORDER}
		<input type="submit" class="liteoption" value="{L_GO}" name="submit" />
		</span></td>
	</tr>
</table>