<a name="editprofile"></a>
<!-- IF EDIT_PROF -->
<form method="post" action="{EDIT_PROF_HREF}" style="display:inline;">
<div align="center" class="gen" style="margin: 10px">
	<input type="submit" value="{L_EDIT_PROF}" class="button" style="font-size:12px; font-weight:bold;" />
</div>
</form>
<!-- ELSE -->
<br />
<!-- ENDIF -->

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr>
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
	<th class="thHead" colspan="2" height="25" nowrap="nowrap">{L_VIEWING_PROFILE}</th>
 </tr>
 <tr>
		<td class="catHead" width="40%" height="28" colspan="2" align="center"><b><span class="gen">{L_ABOUT_USER}</span></b></td>
 </tr>
 <tr>
		<td class="row1" valign="top" style="padding: 0px" width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td class="row1" valign="top" align="center" colspan="2">{AVATAR_IMG}<!-- IF RANK_IMAGE --><div style="padding-top: 8px">{RANK_IMAGE}</div><!-- ENDIF --><!-- IF POSTER_RANK --><div class="genmed" style="padding-top: 8px">{L_RANG}: <b>{POSTER_RANK}</b></div><!-- ENDIF --></td>
	</tr>
 <tr>
		<td class="cat forumline" style="border-width: 1px 0px 1px 0px;" align="center" height="28" colspan="2"><b><span class="gen">{L_CONTACT} {USERNAME} </span></b></td>
 </tr>
 <!-- IF EMAIL_IMG -->
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
		<td class="row1" valign="middle"><b><span class="gen">{EMAIL_IMG}</span></b></td>
	</tr>
	<!-- ENDIF -->
	<!-- IF PM_IMG -->
	<tr>
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
		  <td class="row1" valign="middle"><b><span class="gen">{PM_IMG}</span></b></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF MSN -->
		<tr>
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{MSN}</span></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF YIM_IMG -->
		<tr>
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{YIM_IMG}</span></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF AIM_IMG -->
		<tr>
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{AIM_IMG}</span></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF ICQ_IMG -->
		<tr>
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ICQ_NUMBER}:</span></td>
		  <td class="row1"><script language="JavaScript" type="text/javascript"><!--

		if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
			document.write(' {ICQ_IMG}');
		else
			document.write('<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{ICQ_STATUS_IMG}</div></div></td></tr></table>');

		  //--></script><noscript>{ICQ_IMG}</noscript></td>
		</tr>
		<!-- ENDIF -->
	  </table>
	</td>

		<td class="row1" rowspan="3" valign="top" width="70%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_JOINED}:&nbsp;</span></td>
		  <td width="100%"><b><span class="gen">{JOINED}</span></b></td>
		</tr>
		<tr>
			<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_LAST_VISITED}:&nbsp;</span></td>
			<td><b><span class="gen">{LAST_VISIT_TIME}</span></b></td>
		</tr>
		<tr>
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:&nbsp;</span></td>
		  <td valign="top"><b><span class="gen">{POSTS}</span></b>&nbsp; <span class="genmed">[{POST_DAY_STATS}]</span>&nbsp; <span class="genmed">[ <a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a> ]</span></td>
		</tr>
		<!-- IF LOCATION -->
		<tr>
		  <td valign="bottom" align="right" nowrap="nowrap"><span class="gen">{L_LOCATION}:&nbsp;</span></td>
		  <td valign="bottom"><b><span class="gen">{LOCATION}</span></b></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF WWW -->
		<tr>
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_WEBSITE}:&nbsp;</span></td>
		  <td><span class="gen"><b>{WWW}</b></span></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF OCCUPATION -->
		<tr>
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:&nbsp;</span></td>
		  <td><b><span class="gen">{OCCUPATION}</span></b></td>
		</tr>
		<!-- ENDIF -->
		<!-- IF INTERESTS -->
		<tr>
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>
		<!-- ENDIF -->
<!-- BEGIN switch_upload_limits -->
		<tr>
			<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_UPLOAD_QUOTA}:</span></td>
			<td>
				<table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
					<tr>
						<td colspan="3" width="100%" class="row2">
							<table cellspacing="0" cellpadding="1" border="0">
								<tr>
									<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{UPLOAD_LIMIT_IMG_WIDTH}" height="8" alt="{UPLOAD_LIMIT_PERCENT}" /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="33%" class="row1"><span class="gensmall">0%</span></td>
						<td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
						<td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
					</tr>
				</table>
				<b><span class="genmed">[{UPLOADED} / {QUOTA} / {PERCENT_FULL}]</span> </b><br />
				<span class="genmed"><a href="{U_UACP}" class="genmed">{L_UACP}</a></span>
			</td>
		</tr>
<!-- END switch_upload_limits -->
	</table>
</td>
</tr>
</table>

<!-- //bt -->
<!-- INCLUDE profile_view_torrent.tpl -->
<!-- //bt end -->

<!-- IF EDIT_PROF -->
<form method="post" action="{EDIT_PROF_HREF}" style="display:inline;">
<div align="center" class="gen" style="margin: 10px">
	<input type="submit" value="{L_EDIT_PROF}" class="button" style="font-size:12px; font-weight:bold;" />
</div>
</form>
<!-- ELSE -->
<br />
<!-- ENDIF -->

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td align="right"><span class="nav"><br />{JUMPBOX}</span></td>
  </tr>
</table>
