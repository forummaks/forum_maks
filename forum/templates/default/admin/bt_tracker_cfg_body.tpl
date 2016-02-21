<script language="JavaScript">
<!--
function toggle_disabled (id, val) {
	var el = document.getElementById(id);
	if (val == 1) {
		el.disabled = 0;
	}
	if (val == 0) {
		el.disabled = 1;
	}
	return false;
}
//-->
</script>

<h1>{L_CONFIGURATION_TITLE}</h1>
<form action="{S_CONFIG_ACTION}" method="post">
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="99%">
	<tr>
		<th class="thHead" colspan="2">{L_TRACKER_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_OFF}</div><div class="gensmall">{L_OFF_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="off1"><input type="radio" name="off" id="off1" value="1" {OFF_YES} /> {L_OFF_YES}&nbsp;</label><label for="off2">&nbsp;<input type="radio" name="off" id="off2" value="0" {OFF_NO} /> {L_OFF_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_OFF_SHOW_REASON}</div><div class="gensmall">{L_OFF_SHOW_REASON_EXPL}</div></td>
		<td class="row2"><span class="gen"><label for="off_show_reason1"><input type="radio" name="off_show_reason" id="off_show_reason1" value="1" {OFF_SHOW_REASON_YES} /> {L_OFF_SHOW_REASON_YES}&nbsp;</label><label for="off_show_reason2">&nbsp;<input type="radio" name="off_show_reason" id="off_show_reason2" value="0" {OFF_SHOW_REASON_NO} /> {L_OFF_SHOW_REASON_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_OFF_REASON}</div><div class="gensmall">{L_OFF_REASON_EXPL}</div></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="off_reason" value="{OFF_REASON}" /></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_DEBUG}<br /><span class="gensmall">{L_BT_DEBUG_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="bt_debug1"><input type="radio" name="bt_debug" id="bt_debug1" value="1" {BT_DEBUG_YES} /> {L_BT_DEBUG_YES}&nbsp;</label><label for="bt_debug2">&nbsp;<input type="radio" name="bt_debug" id="bt_debug2" value="0" {BT_DEBUG_NO} /> {L_BT_DEBUG_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_SILENT_MODE}<br /><span class="gensmall">{L_SILENT_MODE_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="silent_mode1"><input type="radio" name="silent_mode" id="silent_mode1" value="1" {SILENT_MODE_YES} /> {L_SILENT_MODE_YES}&nbsp;</label><label for="silent_mode2">&nbsp;<input type="radio" name="silent_mode" id="silent_mode2" value="0" {SILENT_MODE_NO} /> {L_SILENT_MODE_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_AUTOCLEAN}<br /><span class="gensmall">{L_AUTOCLEAN_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="autoclean1"><input type="radio" name="autoclean" id="autoclean1" value="1" {AUTOCLEAN_YES} /> {L_AUTOCLEAN_YES}&nbsp;</label><label for="autoclean2">&nbsp;<input type="radio" name="autoclean" id="autoclean2" value="0" {AUTOCLEAN_NO} /> {L_AUTOCLEAN_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_AUTOCLEAN_INTERVAL}<br /><span class="gensmall">{L_AUTOCLEAN_INTERVAL_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="autoclean_interval" value="{AUTOCLEAN_INTERVAL}" /> <span class="genmed">minutes</span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_COMPACT_MODE}<br /><span class="gensmall">{L_COMPACT_MODE_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="compact_mode1"><input type="radio" name="compact_mode" id="compact_mode1" value="1" {COMPACT_MODE_YES} /> {L_COMPACT_MODE_YES}&nbsp;</label><label for="compact_mode2">&nbsp;<input type="radio" name="compact_mode" id="compact_mode2" value="0" {COMPACT_MODE_NO} /> {L_COMPACT_MODE_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BROWSER_REDIRECT_URL}<br /><span class="gensmall">{L_BROWSER_REDIRECT_URL_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="browser_redirect_url" value="{BROWSER_REDIRECT_URL}" /></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_USE_AUTH_KEY_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_USE_AUTH_KEY}<br /><span class="gensmall">{L_USE_AUTH_KEY_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="use_auth_key1"><input type="radio" name="use_auth_key" id="use_auth_key1" value="1" {USE_AUTH_KEY_YES} /> {L_USE_AUTH_KEY_YES}&nbsp;</label><label for="use_auth_key2">&nbsp;<input type="radio" name="use_auth_key" id="use_auth_key2" value="0" {USE_AUTH_KEY_NO} /> {L_USE_AUTH_KEY_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_AUTH_KEY_NAME}<br /><span class="gensmall">{L_AUTH_KEY_NAME_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="14" maxlength="14" name="auth_key_name" value="{AUTH_KEY_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_ALLOW_GUEST_DL}<br /><span class="gensmall">{L_ALLOW_GUEST_DL_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="allow_guest_dl1"><input type="radio" name="allow_guest_dl" id="allow_guest_dl1" value="1" {ALLOW_GUEST_DL_YES} /> {L_ALLOW_GUEST_DL_YES}&nbsp;</label><label for="allow_guest_dl2">&nbsp;<input type="radio" name="allow_guest_dl" id="allow_guest_dl2" value="0" {ALLOW_GUEST_DL_NO} /> {L_ALLOW_GUEST_DL_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_UPDATE_USERS_DL_STATUS_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_UPDATE_USERS_DL_STATUS}<br /><span class="gensmall">{L_UPDATE_USERS_DL_STATUS_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="update_users_dl_status1"><input type="radio" name="update_users_dl_status" id="update_users_dl_status1" value="1" {UPDATE_USERS_DL_STATUS_YES} /> {L_UPDATE_USERS_DL_STATUS_YES}&nbsp;</label><label for="update_users_dl_status2">&nbsp;<input type="radio" name="update_users_dl_status" id="update_users_dl_status2" value="0" {UPDATE_USERS_DL_STATUS_NO} /> {L_UPDATE_USERS_DL_STATUS_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_UPDATE_USERS_COMPL_STATUS}<br /><span class="gensmall">{L_UPDATE_USERS_COMPL_STATUS_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="update_users_compl_status1"><input type="radio" name="update_users_compl_status" id="update_users_compl_status1" value="1" {UPDATE_USERS_COMPL_STATUS_YES} /> {L_UPDATE_USERS_COMPL_STATUS_YES}&nbsp;</label><label for="update_users_compl_status2">&nbsp;<input type="radio" name="update_users_compl_status" id="update_users_compl_status2" value="0" {UPDATE_USERS_COMPL_STATUS_NO} /> {L_UPDATE_USERS_COMPL_STATUS_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_UPD_USER_UP_DOWN_STAT}<br /><span class="gensmall">{L_UPD_USER_UP_DOWN_STAT_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="upd_user_up_down_stat1"><input type="radio" name="upd_user_up_down_stat" id="upd_user_up_down_stat1" value="1" {UPD_USER_UP_DOWN_STAT_YES} /> {L_UPD_USER_UP_DOWN_STAT_YES}&nbsp;</label><label for="upd_user_up_down_stat2">&nbsp;<input type="radio" name="upd_user_up_down_stat" id="upd_user_up_down_stat2" value="0" {UPD_USER_UP_DOWN_STAT_NO} /> {L_UPD_USER_UP_DOWN_STAT_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_USER_STATISTIC_UPD_INTERVAL}<br /><span class="gensmall">{L_USER_STATISTIC_UPD_INTERVAL_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="user_statistic_upd_interval" value="{USER_STATISTIC_UPD_INTERVAL}" /> <span class="genmed">minutes</span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_SEED_LAST_SEEN_UPD_INTERVAL}<br /><span class="gensmall">{L_SEED_LAST_SEEN_UPD_INTERVAL_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="seed_last_seen_upd_interval" value="{SEED_LAST_SEEN_UPD_INTERVAL}" /> <span class="genmed">minutes</span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_DO_GZIP_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_DO_GZIP}<br /><span class="gensmall">{L_DO_GZIP_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="do_gzip1"><input type="radio" name="do_gzip" id="do_gzip1" value="1" {DO_GZIP_YES} /> {L_DO_GZIP_YES}&nbsp;</label><label for="do_gzip2">&nbsp;<input type="radio" name="do_gzip" id="do_gzip2" value="0" {DO_GZIP_NO} /> {L_DO_GZIP_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_FORCE_GZIP}<br /><span class="gensmall">{L_FORCE_GZIP_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="force_gzip1"><input type="radio" name="force_gzip" id="force_gzip1" value="1" {FORCE_GZIP_YES} /> {L_FORCE_GZIP_YES}&nbsp;</label><label for="force_gzip2">&nbsp;<input type="radio" name="force_gzip" id="force_gzip2" value="0" {FORCE_GZIP_NO} /> {L_FORCE_GZIP_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_CLIENT_COMPAT_GZIP}<br /><span class="gensmall">{L_CLIENT_COMPAT_GZIP_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="client_compat_gzip1"><input type="radio" name="client_compat_gzip" id="client_compat_gzip1" value="1" {CLIENT_COMPAT_GZIP_YES} /> {L_CLIENT_COMPAT_GZIP_YES}&nbsp;</label><label for="client_compat_gzip2">&nbsp;<input type="radio" name="client_compat_gzip" id="client_compat_gzip2" value="0" {CLIENT_COMPAT_GZIP_NO} /> {L_CLIENT_COMPAT_GZIP_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_IGNOR_GIVEN_IP_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_IGNOR_GIVEN_IP}<br /><span class="gensmall">{L_IGNOR_GIVEN_IP_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="ignor_given_ip1"><input type="radio" name="ignor_given_ip" id="ignor_given_ip1" value="1" {IGNOR_GIVEN_IP_YES} /> {L_IGNOR_GIVEN_IP_YES}&nbsp;</label><label for="ignor_given_ip2">&nbsp;<input type="radio" name="ignor_given_ip" id="ignor_given_ip2" value="0" {IGNOR_GIVEN_IP_NO} /> {L_IGNOR_GIVEN_IP_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_ALLOW_HOST_IP}<br /><span class="gensmall">{L_ALLOW_HOST_IP_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="allow_host_ip1"><input type="radio" name="allow_host_ip" id="allow_host_ip1" value="1" {ALLOW_HOST_IP_YES} /> {L_ALLOW_HOST_IP_YES}&nbsp;</label><label for="allow_host_ip2">&nbsp;<input type="radio" name="allow_host_ip" id="allow_host_ip2" value="0" {ALLOW_HOST_IP_NO} /> {L_ALLOW_HOST_IP_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_IGNOR_NUMWANT_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_IGNOR_NUMWANT}<br /><span class="gensmall">{L_IGNOR_NUMWANT_EXPL}</span></span></td>
		<td class="row2"><span class="gen"><label for="ignor_numwant1"><input type="radio" name="ignor_numwant" id="ignor_numwant1" value="1" {IGNOR_NUMWANT_YES} /> {L_IGNOR_NUMWANT_YES}&nbsp;</label><label for="ignor_numwant2">&nbsp;<input type="radio" name="ignor_numwant" id="ignor_numwant2" value="0" {IGNOR_NUMWANT_NO} /> {L_IGNOR_NUMWANT_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_NUMWANT}<br /><span class="gensmall">{L_NUMWANT_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="numwant" value="{NUMWANT}" /></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_NUMWANT_MAX}<br /><span class="gensmall">{L_NUMWANT_MAX_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="numwant_max" value="{NUMWANT_MAX}" /></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_LIMIT_ACTIVE_TOR_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_LIMIT_ACTIVE_TOR}<br /><span class="gensmall">{L_LIMIT_ACTIVE_TOR_EXPL}</span></span></td>
		<td class="row2"><label for="limit_active_tor1"><input type="radio" name="limit_active_tor" id="limit_active_tor1" value="1" {LIMIT_ACTIVE_TOR_YES} /> {L_LIMIT_ACTIVE_TOR_YES}&nbsp;</label><label for="limit_active_tor2">&nbsp;<input type="radio" name="limit_active_tor" id="limit_active_tor2" value="0" {LIMIT_ACTIVE_TOR_NO} /> {L_LIMIT_ACTIVE_TOR_NO} &nbsp;</label></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_LIMIT_SEED_COUNT}<br /><span class="gensmall">{L_LIMIT_SEED_COUNT_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="limit_seed_count" value="{LIMIT_SEED_COUNT}" /> <span class="genmed">torrents</span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_LIMIT_LEECH_COUNT}<br /><span class="gensmall">{L_LIMIT_LEECH_COUNT_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="limit_leech_count" value="{LIMIT_LEECH_COUNT}" /> <span class="genmed">torrents</span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_LEECH_EXPIRE_FACTOR}<br /><span class="gensmall">{L_LEECH_EXPIRE_FACTOR_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="leech_expire_factor" value="{LEECH_EXPIRE_FACTOR}" /> <span class="genmed">minutes</span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_LIMIT_CONCURRENT_IPS}<br /><span class="gensmall">{L_LIMIT_CONCURRENT_IPS_EXPL}</span></span></td>
		<td class="row2"><label for="limit_concurrent_ips1"><input type="radio" name="limit_concurrent_ips" id="limit_concurrent_ips1" value="1" {LIMIT_CONCURRENT_IPS_YES} /> {L_LIMIT_CONCURRENT_IPS_YES}&nbsp;</label><label for="limit_concurrent_ips2">&nbsp;<input type="radio" name="limit_concurrent_ips" id="limit_concurrent_ips2" value="0" {LIMIT_CONCURRENT_IPS_NO} /> {L_LIMIT_CONCURRENT_IPS_NO} &nbsp;</label></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_LIMIT_SEED_IPS}<br /><span class="gensmall">{L_LIMIT_SEED_IPS_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="limit_seed_ips" value="{LIMIT_SEED_IPS}" /> <span class="genmed">IP's</span></td>
	</tr>
	<tr>
		<td class="row1" style="padding-left: 20px"><div class="gen">{L_LIMIT_LEECH_IPS}<br /><span class="gensmall">{L_LIMIT_LEECH_IPS_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="limit_leech_ips" value="{LIMIT_LEECH_IPS}" /> <span class="genmed">IP's</span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_MIN_ANN_INTV_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_MIN_ANN_INTV}<br /><span class="gensmall">{L_MIN_ANN_INTV_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="min_ann_intv" value="{MIN_ANN_INTV}" /> <span class="genmed">seconds</span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_EXPIRE_FACTOR}<br /><span class="gensmall">{L_EXPIRE_FACTOR_EXPL}</span></span></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="expire_factor" value="{EXPIRE_FACTOR}" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="catBottom">
		{S_HIDDEN_FIELDS}
			<input type="submit" name="set_defaults" id="def" value="{L_SET_DEFAULTS}" class="liteoption" disabled="disabled" />&nbsp;
			<input type="reset" value="{L_RESET}" class="liteoption" />&nbsp;
			<input type="submit" name="submit" id="send" value="{L_SUBMIT}" class="mainoption" disabled="disabled" />&nbsp;
			<label for="confirm">{L_CONFIRM}&nbsp;<input onclick="toggle_disabled('def', this.checked); toggle_disabled('send', this.checked)" id="confirm" type="checkbox" name="confirm" value="1" /></label>
		</td>
	</tr>
</table>
</form>

<br clear="all" />

<div align="center"><span class="copyright">{TP_VER_INFO}</span></div>