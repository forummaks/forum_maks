<a name="torrent"></a>
<br />
<table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">

	<tr>
		<th colspan="5" height="28" class="thHead">{L_VIEW_TOR_PROF}</th>
	</tr>

	<tr>
		<td colspan="5" class="row2" align="center">
			<table cellspacing="2" cellpadding="2" border="0">
                        <tr>
					<td align="right"><span class="gen" style="color: #993300"><b>Рейтинг:</b></span></td>
					<td><span class="gen"><b>{UP_DOWN_RATIO}</b></span> &nbsp;[ <a href="{U_SEARCH_RELEASES}" class="genmed">{L_SEARCH_USER_RELEASES}</a> ]</td>
				</tr>
				<tr>
					<td align="right"><span class="gen"><b>Отдано:</b></span></td>
					<td><span class="seed"><b>{TOTAL_UPLOADED}</b></span></td>
				</tr>
                        <tr>
                              <td align="right"><span class="gen"><b>Бонус:</b></span></td>
                              <td><span class="seed"><b>{TOTAL_BONUS}</b></span> &nbsp;[ {WHAT_IS_BONUS} ]</td>
                        </tr>
				<tr>
					<td align="right"><span class="gen"><b>Скачано:</b></span></td>
					<td><span class="leech"><b>{TOTAL_DOWNLOADED}</b></span></td>
				</tr>
				<!-- BEGIN switch_auth_key -->
				<tr>
					<td align="right"><span class="gen">Passkey:</span></td>
					<td><span class="gen">{AUTH_KEY}</span></td>
				</tr>
				<!-- END switch_auth_key -->
			</table>
		</td>
	</tr>

	<tr>
		<th colspan="5" height="28" class="thHead"><b>{L_CUR_ACTIVE_DLS}</b></th>
	</tr>
    
    	<td {RELEASE_ROWSPAN} height="28" class="row1" align="center"><span class="gen"><span class="dlComplete"><span style="line-height:150%;">{L_RELEASING}</span></span></span>
        </td>
		<!-- BEGIN switch_release_none -->
            <td colspan="4" class="row1" width="100%" align="center"><span class="gen">{L_NONE}</span></td>
		<!-- END switch_release_none -->
		<!-- BEGIN release -->
            <td class="row3" align="center"><span class="gen">{L_FORUM}</span></td>
            <td colspan="2" class="row3" align="center"><span class="gen">{L_TOPICS}</span></td>
            <td class="row3 gen" align="center">{L_INFO}</td>
	</tr>
	<!-- BEGIN releaserow -->
	<tr>
		<td class="row1" align="center"><span class="gen"><a class="gen" href="{release.releaserow.U_VIEW_FORUM}">{release.releaserow.FORUM_NAME}</a></span></td>
		<td colspan="2" class="row1"><span class="genmed"><a class="genmed" href="{release.releaserow.U_VIEW_TOPIC}"><b>{release.releaserow.TOPIC_TITLE}</b></a></span></td>
        <td align="center" class="row1" ><span class="seedmed bold">{release.releaserow.F_SEED_COUNT}</span> | <span class="leechmed bold">{release.releaserow.F_LEECH_COUNT}</span> <br /> <span class="seedmed">{release.releaserow.F_SPEED_UP}</span></td>
	</tr>
	<!-- END releaserow -->
	<!-- END release -->  
    
	<tr>
		<td colspan="5" class="row2" style="padding: 0px"><img src="images/spacer.gif" width="1" height="4" alt="."></td>
	</tr>

		<td {SEED_ROWSPAN} height="28" class="row1" align="center"><span class="gen"><span class="dlComplete"><span style="line-height:150%;">{L_SEEDING}</span></span></span>
        </td>
		<!-- BEGIN switch_seeding_none -->
            <td colspan="4" class="row1" width="100%" align="center"><span class="gen">{L_NONE}</span></td>
		<!-- END switch_seeding_none -->
		<!-- BEGIN seed -->
            <td class="row3" align="center"><span class="gen">{L_FORUM}</span></td>
            <td colspan="2" class="row3" align="center"><span class="gen">{L_TOPICS}</span></td>
            <td class="row3 gen" align="center">{L_INFO}</td>
	</tr>
	<!-- BEGIN seedrow -->
	<tr>
		<td class="row1" align="center"><span class="gen"><a class="gen" href="{seed.seedrow.U_VIEW_FORUM}">{seed.seedrow.FORUM_NAME}</a></span></td>
		<td colspan="2" class="row1"><span class="genmed"><a class="genmed" href="{seed.seedrow.U_VIEW_TOPIC}"><b>{seed.seedrow.TOPIC_TITLE}</b></a></span></td>
        <td align="center" class="row1"><span class="seedmed bold">{seed.seedrow.F_SEED_COUNT}</span> | <span class="leechmed bold">{seed.seedrow.F_LEECH_COUNT}</span> <br /> <span class="seedmed">{seed.seedrow.F_SPEED_UP}</span></td>
	</tr>
	<!-- END seedrow -->
	<!-- END seed -->
    
	<tr>
		<td colspan="5" class="row2" style="padding: 0px"><img src="images/spacer.gif" width="1" height="4" alt="."></td>
	</tr>    

	<tr>
		<td {LEECH_ROWSPAN} height="28" class="row1" align="center"><span class="gen"><span class="dlDown"><span style="line-height:150%;">{L_LEECHING}</span></span></span></td>
		<!-- BEGIN switch_leeching_none -->
		<td colspan="4" class="row1" width="100%" align="center"><span class="gen">{L_NONE}</span></td>
		<!-- END switch_leeching_none -->
		<!-- BEGIN leech -->
		<td class="row3" align="center"><span class="gen">{L_FORUM}</span></td>
		<td colspan="2" class="row3" align="center"><span class="gen">{L_TOPICS}</span></td>
        <td class="row3 gen" align="center">{L_INFO}</td>
	</tr>
	<!-- BEGIN leechrow -->
	<tr>
		<td class="row1" align="center"><span class="gen"><a class="gen" href="{leech.leechrow.U_VIEW_FORUM}">{leech.leechrow.FORUM_NAME}</a></span></td>
		<td colspan="2" class="row1"><span class="genmed"><a class="genmed" href="{leech.leechrow.U_VIEW_TOPIC}"><b>{leech.leechrow.TOPIC_TITLE}</b></a></span></td>
        <td align="center" class="row1"><span class="seedmed bold">{leech.leechrow.F_SEED_COUNT}</span> | <span class="leechmed bold">{leech.leechrow.F_LEECH_COUNT}</span> <br /> <span class="leechmed">{leech.leechrow.F_SPEED_DOWN}</span></td>        
	</tr>
	<!-- END leechrow -->
	<!-- END leech -->

	<tr>
		<td colspan="5" class="row2" align="center" style="padding: 6px">
			<span class="gen">
				<a href="{U_SEARCH_DL_WILL}" class="gen">{L_SEARCH_DL_WILL} {L_SEARCH_DL}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_DOWN}" class="gen">{L_SEARCH_DL_DOWN}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_COMPLETE}" class="gen">{L_SEARCH_DL_COMPLETE}</a>&nbsp;::&nbsp;<a href="{U_SEARCH_DL_CANCEL}" class="gen">{L_SEARCH_DL_CANCEL}</a>
			</span>
		</td>
	</tr>

</table>