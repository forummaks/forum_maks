<table width="100%" class="forumline" cellspacing="1" cellpadding="6" border="0">
	<tr>
		<td colspan="2" height="28" class="catHead" align="center" style="letter-spacing: 1px"><span class="gen"><b><a href="{TITLE_HREF}" class="gen">
			<!-- IF SHOW_DL_LIST -->DL-List<!-- ENDIF --><!-- IF SHOW_DL_LIST && SHOW_TOR_ACT --> and <!-- ENDIF --><!-- IF SHOW_TOR_ACT -->Torrent activity<!-- ENDIF -->
		</a></b></span></td>
	</tr>
	<!-- BEGIN dl_users -->
	<!-- BEGIN users_row -->
	<tr>
		<td width="5%" align="center" class="row1" nowrap="nowrap"><span class="genmed" title=" {dl_users.users_row.DL_COUNT} "><b>{dl_users.users_row.DL_OPTION_NAME}</b></span><br /><img src="images/spacer.gif" width="116" height="1" border="0" alt="" /></td>
		<td width="95%" class="row1"><div style="{dl_users.users_row.DL_USERS_DIV_STYLE}"><span class="genmed"><b>{dl_users.users_row.DL_OPTION_USERS}</b></span></div></td>
	</tr>
	<!-- END users_row -->
	<!-- END dl_users -->
      <!-- IF SHOW_DL_LIST && SHOW_TOR_ACT -->
      <!-- IF SHOW_DL_LIST_TOR_INFO -->
      <tr>
         <td class="row1" colspan="2" align="center">
            {L_TORRENT_SIZE}: <b>{TOR_SIZE}</b>&nbsp;&nbsp;|&nbsp;&nbsp;{L_REGISTERED}: <b>{TOR_LONGEVITY}</b>&nbsp;&nbsp;|&nbsp;&nbsp;{L_COMPLETED}: <b>{TOR_COMPLETED}</b>
         </td>
      </tr>
      <!-- ENDIF / SHOW_DL_LIST_TOR_INFO -->
      <!-- ENDIF -->
	<!-- BEGIN dl_counts -->
	<tr>
		<td colspan="2" class="row1" align="center">
			<table cellspacing="0" cellpadding="4" border="0" align="center">
				<!-- BEGIN count_row -->
				<tr>
					<td nowrap="nowrap" align="center"><span class="gen"><b>{dl_counts.count_row.DL_OPTION_NAME}:</b></span></td>
					<td nowrap="nowrap" align="center"><span class="gen">[ <b>{dl_counts.count_row.DL_OPTION_USERS}</b> ]</span></td>
				</tr>
				<!-- END count_row -->
			</table>
		</td>
	</tr>
	<!-- END dl_counts -->
	<!-- BEGIN dl_list_none -->
	<tr>
		<td colspan="2" height="32" class="row1" align="center"><span class="gen"><!-- IF SHOW_DL_LIST && SHOW_TOR_ACT -->DL-List: <!-- ENDIF -->{L_NONE}</span></td>
	</tr>
	<!-- END dl_list_none -->

	<!-- IF SHOW_DL_LIST && SHOW_TOR_ACT -->
	<!--
		<tr>
			<td class="row3" colspan="2" height="1" style="padding: 0px"><img src="images/spacer.gif" alt="" width="1" height="4" /></td>
		</tr>
	-->
	<!-- ENDIF -->

	<!-- IF SHOW_TOR_ACT -->
		<!-- IF S_MODE_COUNT -->
			<!-- IF SEED_EXIST -->
			<tr>
				<td colspan="2" class="row2" align="center">
				<!-- IF SEEDER_LAST_SEEN -->
				<div class="gen" align="center" style="padding: 4px">{SEEDER_LAST_SEEN}</div>
				<!-- ENDIF -->
					<table cellspacing="0" cellpadding="4" border="0" align="center">
                                    <tr>
                                    <td class="row6" colspan="2" align="center"> 
						<!-- IF SEED_COUNT -->
							<span class="seed">Сиды:&nbsp; <b>{SEED_COUNT}</b> &nbsp;[&nbsp; {SEED_SPEED} &nbsp;]</span> &nbsp;
						<!-- ENDIF -->
						<!-- IF LEECH_COUNT -->
							<span class="leech">Личи:&nbsp; <b>{LEECH_COUNT}</b> &nbsp;[&nbsp; {LEECH_SPEED} &nbsp;]</span> &nbsp;
                                    <!-- ENDIF -->
                                    <!-- IF PEERS_FULL_LINK && PEER_EXIST -->
					      <a href="{SPMODE_FULL_HREF}" class="gen">{L_SPMODE_FULL}</a>
					      <!-- ENDIF -->
                                    </td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- ELSE -->
			<tr>
				<td colspan="2" class="row2" height="32" align="center"><span class="gen">{SEEDER_LAST_SEEN}</span></td>
			</tr>
			<!-- IF LEECH_COUNT -->
				<tr>
					<td colspan="2" class="row2" height="32" align="center"><span class="leech"><b>{L_LEECH}:</b> [ <b>{LEECH_COUNT}</b> ]</span></td>
				</tr>
				<!-- ENDIF -->
			<!-- ENDIF -->
		<!-- ELSEIF S_MODE_NAMES -->
			<!-- IF SEED_EXIST -->
				<!-- IF SEED_LIST -->
					<tr>
						<td width="5%"  class="row1" align="center" nowrap="nowrap"><span class="seed"><b>{L_SEED}</b></span><br /><img src="images/spacer.gif" width="116" height="1" border="0" alt="" /></td>
						<td width="95%" class="row1"><div class="seedsmall">{SEED_LIST}</div></td>
					</tr>
				<!-- ENDIF -->
				<!-- IF LEECH_LIST -->
					<tr>
						<td width="5%" align="center" class="row1" nowrap="nowrap"><span class="leech"><b>{L_LEECH}</b></span><br /><img src="images/spacer.gif" width="116" height="1" border="0" alt="" /></td>
						<td width="95%" class="row1"><div class="leechsmall">{LEECH_LIST}</div></td>
					</tr>
				<!-- ENDIF -->
			<!-- ELSE -->
				<tr>
					<td colspan="2" class="row2" height="32" align="center"><span class="gen">{SEEDER_LAST_SEEN}</span></td>
				</tr>
				<!-- IF LEECH_LIST -->
					<tr>
						<td width="5%" align="center" class="row1" nowrap="nowrap"><span class="leech"><b>{L_LEECH}</b></span><br /><img src="images/spacer.gif" width="116" height="1" border="0" alt="" /></td>
						<td width="95%" class="row1"><div class="leechsmall">{LEECH_LIST}</div></td>
					</tr>
				<!-- ENDIF -->
			<!-- ENDIF -->
		<!-- ELSEIF S_MODE_FULL -->
			<tr>
				<td colspan="2" align="center" class="row1" valign="top">
					<a name="torDesc"></a>
					<!-- IF SEEDER_LAST_SEEN -->
						<div align="center" class="gen" style="width: 60%;<!-- IF PEER_EXIST -->padding: 6px; margin-top: 6px; margin-bottom: 6px; border: 1px solid {T_TH_COLOR1};<!-- ELSE -->padding: 4px;<!-- ENDIF -->"><nobr>{SEEDER_LAST_SEEN}</nobr></div>
					<!-- ENDIF -->
					<!-- IF PEERS_OVERFLOW && SEEDER_LAST_SEEN -->
						<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
					<!-- ENDIF -->
					<!-- IF PEER_EXIST -->
					<div class="row1" align="center" style="width: 97%;{PEERS_DIV_STYLE}">
						<!-- BEGIN sfull -->
						<a name="seeders"></a>
						<table width="60%" border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td>
									<form method="POST" action="{sfull.SEED_ORD_ACT}" style="display: inline">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td valign="bottom" style="padding: 0px 0px 6px 0px"><span class="gen"><b>{L_SEED}</b>:</span></td>
												<!-- BEGIN sorder -->
												<td align="right" valign="bottom" nowrap="nowrap" style="padding: 0px 10px 6px 0px" width="100%">
													<span class="genmed">{L_SEED_ORDER_DESC}:</span>
												</td>
												<td valign="bottom" nowrap="nowrap" style="padding: 0px 0px 2px 0px">
													<span class="genmed">{sfull.sorder.SEED_ORDER_SELECT}</span>
												</td>
												<td valign="bottom" nowrap="nowrap" style="padding: 0px 0px 4px 2px">
													<input type="submit" value="&#9660;" class="pOrdSel" name="psortdesc" /><input type="submit" value="&#9650;" class="pOrdSel" name="psortasc" />
												</td>
												<!-- END sorder -->
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellpadding="5" cellspacing="1" class="btTbl">
										<tr>
											<td class="btHead" rowspan="2"><b>Username</b><br /><img src="images/spacer.gif" alt="" width="130" height="1" /></td>
											<td class="btHead" rowspan="2" title="UL/Torrent Size"><b>UL<br />Ratio</b><br /><img src="images/spacer.gif" alt="" width="40" height="1" /></td>
											<td class="btHead" colspan="2" width="30%"><b>Transfers</b><br /><img src="images/spacer.gif" alt="" width="140" height="1" /></td>
											<td class="btHead" colspan="2" width="35%"><b>Speed</b><br /><img src="images/spacer.gif" alt="" width="150" height="1" /></td>
											<!-- BEGIN iphead -->
											<td class="btHead" rowspan="2" width="30%"><b>IP</b><br /><img src="images/spacer.gif" alt="" width="105" height="1" /></td>
											<!-- END iphead -->
											<!-- BEGIN porthead -->
											<td class="btHead" rowspan="2"><b>Port</b><br /><img src="images/spacer.gif" alt="" width="50" height="1" /></td>
											<!-- END porthead -->
										</tr>
										<tr>
											<td class="btHead">up<br /><img src="images/spacer.gif" alt="" width="70" height="1" /></td>
											<td class="btHead">down<br /><img src="images/spacer.gif" alt="" width="70" height="1" /></td>
											<td class="btHead" title="{sfull.SEEDERS_UP_TOT}">up<br /><img src="images/spacer.gif" alt="" width="75" height="1" /></td>
											<td class="btHead">down<br /><img src="images/spacer.gif" alt="" width="75" height="1" /></td>
										</tr>
										<!-- BEGIN srow -->
										<tr{sfull.srow.ROW_BGR}>
											<td class="genmed" title="{sfull.srow.UPD_EXP_TIME}"><b>{sfull.srow.NAME}</b></td>
											<td class="genmed" align="center" nowrap="nowrap" title="{sfull.srow.COMPL_PRC_TTL}">{sfull.srow.COMPL_PRC}</td>
											<td class="genmed" align="center" nowrap="nowrap" title="{sfull.srow.UP_CURR}">{sfull.srow.UP_TOTAL}</td>
											<td class="genmed" align="center" nowrap="nowrap" title="{sfull.srow.DOWN_CURR}">{sfull.srow.DOWN_TOTAL}</td>
											<td class="genmed" align="center" nowrap="nowrap" title=""><span class="seedmed">{sfull.srow.SPEED_UP}</span></td>
											<td class="genmed" align="center" nowrap="nowrap" title=""><span class="leechmed">{sfull.srow.SPEED_DOWN}</span></td>
											<!-- BEGIN ip -->
											<td class="genmed" align="right" nowrap="nowrap">{sfull.srow.ip.IP}</td>
											<!-- END ip -->
											<!-- BEGIN port -->
											<td class="genmed" align="center" nowrap="nowrap">{sfull.srow.port.PORT}</td>
											<!-- END port -->
										</tr>
										<!-- END srow -->
									</table>
								</td>
							</tr>
						</table>
						<!-- END sfull -->
						<!-- BEGIN lfull -->
						<a name="leechers"></a>
						<table width="60%" border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td>
									<form method="POST" action="{lfull.LEECH_ORD_ACT}" style="display: inline">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td valign="bottom" style="padding: <!-- IF SEED_EXIST -->12px<!-- ELSE -->0px<!-- ENDIF --> 0px 6px 0px"><span class="gen"><b>{L_LEECH}</b>:</span></td>
												<!-- BEGIN lorder -->
												<td align="right" valign="bottom" nowrap="nowrap" style="padding: 0px 10px 6px 0px" width="100%">
													<span class="genmed">{L_LEECH_ORDER_DESC}:</span>
												</td>
												<td valign="bottom" nowrap="nowrap" style="padding: 0px 0px 2px 0px">
													<span class="genmed">{lfull.lorder.LEECH_ORDER_SELECT}</span>
												</td>
												<td valign="bottom" nowrap="nowrap" style="padding: 0px 0px 4px 2px">
													<input type="submit" value="&#9660;" class="pOrdSel" name="psortdesc" /><input type="submit" value="&#9650;" class="pOrdSel" name="psortasc" />
												</td>
												<!-- END lorder -->
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellpadding="5" cellspacing="1" class="btTbl">
										<tr>
											<td class="btHead" rowspan="2"><b>Username</b><br /><img src="images/spacer.gif" alt="" width="130" height="1" /></td>
											<td class="btHead" rowspan="2" title="Complete percent"><b>%</b><br /><img src="images/spacer.gif" alt="" width="40" height="1" /></td>
											<td class="btHead" colspan="2" width="30%"><b>Transfers</b><br /><img src="images/spacer.gif" alt="" width="140" height="1" /></td>
											<td class="btHead" colspan="2" width="35%"><b>Speed</b><br /><img src="images/spacer.gif" alt="" width="150" height="1" /></td>
											<!-- BEGIN iphead -->
											<td class="btHead" rowspan="2" width="30%"><b>IP</b><br /><img src="images/spacer.gif" alt="" width="105" height="1" /></td>
											<!-- END iphead -->
											<!-- BEGIN porthead -->
											<td class="btHead" rowspan="2"><b>Port</b><br /><img src="images/spacer.gif" alt="" width="50" height="1" /></td>
											<!-- END porthead -->
										</tr>
										<tr>
											<td class="btHead">up<br /><img src="images/spacer.gif" alt="" width="70" height="1" /></td>
											<td class="btHead">down<br /><img src="images/spacer.gif" alt="" width="70" height="1" /></td>
											<td class="btHead" title="{lfull.LEECHERS_UP_TOT}">up<br /><img src="images/spacer.gif" alt="" width="75" height="1" /></td>
											<td class="btHead" title="{lfull.LEECHERS_DOWN_TOT}">down<br /><img src="images/spacer.gif" alt="" width="75" height="1" /></td>
										</tr>
										<!-- BEGIN lrow -->
										<tr{lfull.lrow.ROW_BGR}>
											<td class="genmed" title="{lfull.lrow.UPD_EXP_TIME}"><b>{lfull.lrow.NAME}</b></td>
											<td class="genmed" align="center" nowrap="nowrap" title="{lfull.lrow.UP_DOWN_RATIO}">{lfull.lrow.COMPL_PRC}</td>
											<td class="genmed" align="center" nowrap="nowrap" title="{lfull.lrow.UP_CURR}">{lfull.lrow.UP_TOTAL}</td>
											<td class="genmed" align="center" nowrap="nowrap" title="{lfull.lrow.DOWN_CURR}">{lfull.lrow.DOWN_TOTAL}</td>
											<td class="genmed" align="center" nowrap="nowrap" title=""><span class="seedmed">{lfull.lrow.SPEED_UP}</span></td>
											<td class="genmed" align="center" nowrap="nowrap" title=""><span class="leechmed">{lfull.lrow.SPEED_DOWN}</span></td>
											<!-- BEGIN ip -->
											<td class="genmed" align="right" nowrap="nowrap">{lfull.lrow.ip.IP}</td>
											<!-- END ip -->
											<!-- BEGIN port -->
											<td class="genmed" align="center" nowrap="nowrap">{lfull.lrow.port.PORT}</td>
											<!-- END port -->
										</tr>
										<!-- END lrow -->
									</table>
								</td>
							</tr>
						</table>
						<!-- END lfull -->
						<!-- IF PEERS_OVERFLOW -->
							<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
						<!-- ENDIF -->
					</div>
					<!-- ENDIF -->
				</td>
			</tr>
		<!-- ENDIF -->
	<!-- ENDIF -->
	<!-- BEGIN dl_list_tip_1 -->
	<tr>
		<td colspan="2" class="row2" align="center" style="padding: 2px"><span class="gensmall" style="color: #666666">{L_DL_LIST_TIP_1}</span></td>
	</tr>
	<!-- END dl_list_tip_1 -->
	<!-- IF DL_BUTTONS -->
		<tr>
			<td colspan="2" align="center" valign="middle" class="row3" style="padding: 0px; height: 28px">
			&nbsp;
			<form method="POST" action="{S_DL_ACTION}" style="display: inline">
				<!-- IF DL_BUT_WILL --><input type="submit" name="dl_set_will" value="{L_DL_WILL}" class="liteoption" />&nbsp;<!-- ENDIF -->
				<!-- IF DL_BUT_DOWN --><input type="submit" name="dl_set_down" value="{L_DL_DOWN}" class="liteoption" />&nbsp;<!-- ENDIF -->
				<!-- IF DL_BUT_COMPL --><input type="submit" name="dl_set_complete" value="{L_DL_COMPLETE}" class="liteoption" />&nbsp;<!-- ENDIF -->
				<!-- IF DL_BUT_CANCEL --><input type="submit" name="dl_set_cancel" value="{L_DL_CANCEL}" class="liteoption" /><!-- ENDIF -->
				{DL_HIDDEN_FIELDS}
			</form>
			&nbsp;
			</td>
		</tr>
	<!-- ELSE -->
		<tr>
			<td class="row3" colspan="2" height="1" style="padding: 0px"><img src="images/spacer.gif" alt="" width="1" height="4" /></td>
		</tr>
	<!-- ENDIF -->
</table>
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>