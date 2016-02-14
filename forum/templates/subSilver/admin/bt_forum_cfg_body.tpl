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
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="10%">
	<tr>
		<th class="thHead" colspan="5" align="center">{L_BT_SELECT_FORUMS}</th>
	</tr>
	<tr class="row1">
		<td class="gen" align="center">{L_ALLOW_REG_TRACKER}</td>
		<td class="gen" align="center">{L_ALLOW_DL_TOPIC}</td>
		<td class="gen" align="center">{L_DL_TYPE_DEFAULT}</td>
		<td class="gen" align="center">{L_SHOW_DL_BUTTONS}</td>
		<td class="gen" align="center">{L_SELF_MODERATED}</td>
	</tr>
	<tr class="row2">
		<td align="center">{S_ALLOW_REG_TRACKER}</td>
		<td align="center">{S_ALLOW_DL_TOPIC}</td>
		<td align="center">{S_DL_TYPE_DEFAULT}</td>
		<td align="center">{S_SHOW_DL_BUTTONS}</td>
		<td align="center">{S_SELF_MODERATED}</td>
	</tr>
	<tr class="row1">
		<td class="gensmall" colspan="5" align="center">{L_BT_SELECT_FORUMS_EXPL}</td>
	</tr>
</table>
<br />
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="99%">
	<tr>
		<th class="thHead" colspan="2">{L_BT_ANNOUNCE_URL_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_ANNOUNCE_URL}</div><div class="gensmall">{L_BT_ANNOUNCE_URL_EXPL}</div></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="bt_announce_url" value="{BT_ANNOUNCE_URL}" /></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_CHECK_ANNOUNCE_URL}</div><div class="gensmall">{L_BT_CHECK_ANNOUNCE_URL_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_check_announce_url1"><input type="radio" name="bt_check_announce_url" id="bt_check_announce_url1" value="1" {BT_CHECK_ANNOUNCE_URL_YES} /> {L_BT_CHECK_ANNOUNCE_URL_YES}&nbsp;</label><label for="bt_check_announce_url2">&nbsp;<input type="radio" name="bt_check_announce_url" id="bt_check_announce_url2" value="0" {BT_CHECK_ANNOUNCE_URL_NO} /> {L_BT_CHECK_ANNOUNCE_URL_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_REPLACE_ANN_URL}</div><div class="gensmall">{L_BT_REPLACE_ANN_URL_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_replace_ann_url1"><input type="radio" name="bt_replace_ann_url" id="bt_replace_ann_url1" value="1" {BT_REPLACE_ANN_URL_YES} /> {L_BT_REPLACE_ANN_URL_YES}&nbsp;</label><label for="bt_replace_ann_url2">&nbsp;<input type="radio" name="bt_replace_ann_url" id="bt_replace_ann_url2" value="0" {BT_REPLACE_ANN_URL_NO} /> {L_BT_REPLACE_ANN_URL_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_DEL_ADDIT_ANN_URLS}</div><div class="gensmall">{L_BT_DEL_ADDIT_ANN_URLS_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_del_addit_ann_urls1"><input type="radio" name="bt_del_addit_ann_urls" id="bt_del_addit_ann_urls1" value="1" {BT_DEL_ADDIT_ANN_URLS_YES} /> {L_BT_DEL_ADDIT_ANN_URLS_YES}&nbsp;</label><label for="bt_del_addit_ann_urls2">&nbsp;<input type="radio" name="bt_del_addit_ann_urls" id="bt_del_addit_ann_urls2" value="0" {BT_DEL_ADDIT_ANN_URLS_NO} /> {L_BT_DEL_ADDIT_ANN_URLS_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_ADD_COMMENT}</div><div class="gensmall">{L_BT_ADD_COMMENT_EXPL}</div></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="bt_add_comment" value="{BT_ADD_COMMENT}" /></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_ADD_PUBLISHER}</div><div class="gensmall">{L_BT_ADD_PUBLISHER_EXPL}</div></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="bt_add_publisher" value="{BT_ADD_PUBLISHER}" /></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_BT_SHOW_PEERS_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_PEERS}</div><div class="gensmall">{L_BT_SHOW_PEERS_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_peers1"><input type="radio" name="bt_show_peers" id="bt_show_peers1" value="1" {BT_SHOW_PEERS_YES} /> {L_BT_SHOW_PEERS_YES}&nbsp;</label><label for="bt_show_peers2">&nbsp;<input type="radio" name="bt_show_peers" id="bt_show_peers2" value="0" {BT_SHOW_PEERS_NO} /> {L_BT_SHOW_PEERS_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_PEERS_MODE}</div><div class="gensmall">{L_BT_SHOW_PEERS_MODE_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><div class="gen"><label for="bt_show_peers_mode_count"><input type="radio" name="bt_show_peers_mode" id="bt_show_peers_mode_count" value="{BT_SHOW_PEERS_MODE_COUNT_VAL}" {BT_SHOW_PEERS_MODE_COUNT_SEL} /> {L_BT_SHOW_PEERS_MODE_COUNT}&nbsp;</label></div>
		<div class="gen"><label for="bt_show_peers_mode_names"><input type="radio" name="bt_show_peers_mode" id="bt_show_peers_mode_names" value="{BT_SHOW_PEERS_MODE_NAMES_VAL}" {BT_SHOW_PEERS_MODE_NAMES_SEL} /> {L_BT_SHOW_PEERS_MODE_NAMES}&nbsp;</label></div>
		<div class="gen"><label for="bt_show_peers_mode_full"><input type="radio" name="bt_show_peers_mode" id="bt_show_peers_mode_full" value="{BT_SHOW_PEERS_MODE_FULL_VAL}" {BT_SHOW_PEERS_MODE_FULL_SEL} /> {L_BT_SHOW_PEERS_MODE_FULL}&nbsp;</label></div>
		</td>
	<tr>
		<td class="row1"><div class="gen">{L_BT_ALLOW_SPMODE_CHANGE}</div><div class="gensmall">{L_BT_ALLOW_SPMODE_CHANGE_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_allow_spmode_change1"><input type="radio" name="bt_allow_spmode_change" id="bt_allow_spmode_change1" value="1" {BT_ALLOW_SPMODE_CHANGE_YES} /> {L_BT_ALLOW_SPMODE_CHANGE_YES}&nbsp;</label><label for="bt_allow_spmode_change2">&nbsp;<input type="radio" name="bt_allow_spmode_change" id="bt_allow_spmode_change2" value="0" {BT_ALLOW_SPMODE_CHANGE_NO} /> {L_BT_ALLOW_SPMODE_CHANGE_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_IP_ONLY_MODER}</div><div class="gensmall">{L_BT_SHOW_IP_ONLY_MODER_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_ip_only_moder1"><input type="radio" name="bt_show_ip_only_moder" id="bt_show_ip_only_moder1" value="1" {BT_SHOW_IP_ONLY_MODER_YES} /> {L_BT_SHOW_IP_ONLY_MODER_YES}&nbsp;</label><label for="bt_show_ip_only_moder2">&nbsp;<input type="radio" name="bt_show_ip_only_moder" id="bt_show_ip_only_moder2" value="0" {BT_SHOW_IP_ONLY_MODER_NO} /> {L_BT_SHOW_IP_ONLY_MODER_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_PORT_ONLY_MODER}</div><div class="gensmall">{L_BT_SHOW_PORT_ONLY_MODER_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_port_only_moder1"><input type="radio" name="bt_show_port_only_moder" id="bt_show_port_only_moder1" value="1" {BT_SHOW_PORT_ONLY_MODER_YES} /> {L_BT_SHOW_PORT_ONLY_MODER_YES}&nbsp;</label><label for="bt_show_port_only_moder2">&nbsp;<input type="radio" name="bt_show_port_only_moder" id="bt_show_port_only_moder2" value="0" {BT_SHOW_PORT_ONLY_MODER_NO} /> {L_BT_SHOW_PORT_ONLY_MODER_NO} &nbsp;</label></span></td>
	</tr>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_BT_SHOW_DL_LIST_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_DL_LIST}</div><div class="gensmall">{L_BT_SHOW_DL_LIST_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_dl_list1"><input type="radio" name="bt_show_dl_list" id="bt_show_dl_list1" value="1" {BT_SHOW_DL_LIST_YES} /> {L_BT_SHOW_DL_LIST_YES}&nbsp;</label><label for="bt_show_dl_list2">&nbsp;<input type="radio" name="bt_show_dl_list" id="bt_show_dl_list2" value="0" {BT_SHOW_DL_LIST_NO} /> {L_BT_SHOW_DL_LIST_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_DL_LIST_ONLY_1ST_PAGE}</div><div class="gensmall">{L_BT_DL_LIST_ONLY_1ST_PAGE_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_dl_list_only_1st_page1"><input type="radio" name="bt_dl_list_only_1st_page" id="bt_dl_list_only_1st_page1" value="1" {BT_DL_LIST_ONLY_1ST_PAGE_YES} /> {L_BT_DL_LIST_ONLY_1ST_PAGE_YES}&nbsp;</label><label for="bt_dl_list_only_1st_page2">&nbsp;<input type="radio" name="bt_dl_list_only_1st_page" id="bt_dl_list_only_1st_page2" value="0" {BT_DL_LIST_ONLY_1ST_PAGE_NO} /> {L_BT_DL_LIST_ONLY_1ST_PAGE_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_DL_LIST_ONLY_COUNT}</div><div class="gensmall">{L_BT_DL_LIST_ONLY_COUNT_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_dl_list_only_count1"><input type="radio" name="bt_dl_list_only_count" id="bt_dl_list_only_count1" value="1" {BT_DL_LIST_ONLY_COUNT_YES} /> {L_BT_DL_LIST_ONLY_COUNT_YES}&nbsp;</label><label for="bt_dl_list_only_count2">&nbsp;<input type="radio" name="bt_dl_list_only_count" id="bt_dl_list_only_count2" value="0" {BT_DL_LIST_ONLY_COUNT_NO} /> {L_BT_DL_LIST_ONLY_COUNT_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_DL_LIST_EXPIRE}</div><div class="gensmall">{L_BT_DL_LIST_EXPIRE_EXPL}</div></td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="bt_dl_list_expire" value="{BT_DL_LIST_EXPIRE}" /> <span class="genmed">days</span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_DL_LIST_BUTTONS}</div><div class="gensmall">{L_BT_SHOW_DL_LIST_BUTTONS_EXPL}</div>
			<table class="forumline" cellspacing="1" cellpadding="2" border="0" style="margin: 4px 4px 1px 4px; border-width: 1px">
				<tr>
					<td class="row1" nowrap="nowrap" align="center"><span class="genmed"><b>&nbsp;{L_BT_SHOW_DL_BUT_WILL}:&nbsp;</b></span></td>
					<td class="row1" nowrap="nowrap"><span class="genmed"><label for="bt_show_dl_but_will1"><input type="radio" name="bt_show_dl_but_will" id="bt_show_dl_but_will1" value="1" {BT_SHOW_DL_BUT_WILL_YES} /> {L_BT_SHOW_DL_BUT_WILL_YES}&nbsp;</label><label for="bt_show_dl_but_will2">&nbsp;<input type="radio" name="bt_show_dl_but_will" id="bt_show_dl_but_will2" value="0" {BT_SHOW_DL_BUT_WILL_NO} /> {L_BT_SHOW_DL_BUT_WILL_NO} &nbsp;</label></span>
				</tr>
				<tr>
					<td class="row1" nowrap="nowrap" align="center"><span class="genmed"><b>&nbsp;{L_BT_SHOW_DL_BUT_DOWN}:&nbsp;</b></span></td>
					<td class="row1" nowrap="nowrap"><span class="genmed"><label for="bt_show_dl_but_down1"><input type="radio" name="bt_show_dl_but_down" id="bt_show_dl_but_down1" value="1" {BT_SHOW_DL_BUT_DOWN_YES} /> {L_BT_SHOW_DL_BUT_DOWN_YES}&nbsp;</label><label for="bt_show_dl_but_down2">&nbsp;<input type="radio" name="bt_show_dl_but_down" id="bt_show_dl_but_down2" value="0" {BT_SHOW_DL_BUT_DOWN_NO} /> {L_BT_SHOW_DL_BUT_DOWN_NO} &nbsp;</label></span>
				</tr>
				<tr>
					<td class="row1" nowrap="nowrap" align="center"><span class="genmed"><b>&nbsp;{L_BT_SHOW_DL_BUT_COMPL}:&nbsp;</b></span></td>
					<td class="row1" nowrap="nowrap"><span class="genmed"><label for="bt_show_dl_but_compl1"><input type="radio" name="bt_show_dl_but_compl" id="bt_show_dl_but_compl1" value="1" {BT_SHOW_DL_BUT_COMPL_YES} /> {L_BT_SHOW_DL_BUT_COMPL_YES}&nbsp;</label><label for="bt_show_dl_but_compl2">&nbsp;<input type="radio" name="bt_show_dl_but_compl" id="bt_show_dl_but_compl2" value="0" {BT_SHOW_DL_BUT_COMPL_NO} /> {L_BT_SHOW_DL_BUT_COMPL_NO} &nbsp;</label></span>
				</tr>
				<tr>
					<td class="row1" nowrap="nowrap" align="center"><span class="genmed"><b>&nbsp;{L_BT_SHOW_DL_BUT_CANCEL}:&nbsp;</b></span></td>
					<td class="row1" nowrap="nowrap"><span class="genmed"><label for="bt_show_dl_but_cancel1"><input type="radio" name="bt_show_dl_but_cancel" id="bt_show_dl_but_cancel1" value="1" {BT_SHOW_DL_BUT_CANCEL_YES} /> {L_BT_SHOW_DL_BUT_CANCEL_YES}&nbsp;</label><label for="bt_show_dl_but_cancel2">&nbsp;<input type="radio" name="bt_show_dl_but_cancel" id="bt_show_dl_but_cancel2" value="0" {BT_SHOW_DL_BUT_CANCEL_NO} /> {L_BT_SHOW_DL_BUT_CANCEL_NO} &nbsp;</label></span>
				</tr>
			</table>
		</td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_dl_list_buttons1"><input type="radio" name="bt_show_dl_list_buttons" id="bt_show_dl_list_buttons1" value="1" {BT_SHOW_DL_LIST_BUTTONS_YES} /> {L_BT_SHOW_DL_LIST_BUTTONS_YES}&nbsp;</label><label for="bt_show_dl_list_buttons2">&nbsp;<input type="radio" name="bt_show_dl_list_buttons" id="bt_show_dl_list_buttons2" value="0" {BT_SHOW_DL_LIST_BUTTONS_NO} /> {L_BT_SHOW_DL_LIST_BUTTONS_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SET_DLTYPE_ON_TOR_REG}</div><div class="gensmall">{L_BT_SET_DLTYPE_ON_TOR_REG_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_set_dltype_on_tor_reg1"><input type="radio" name="bt_set_dltype_on_tor_reg" id="bt_set_dltype_on_tor_reg1" value="1" {BT_SET_DLTYPE_ON_TOR_REG_YES} /> {L_BT_SET_DLTYPE_ON_TOR_REG_YES}&nbsp;</label><label for="bt_set_dltype_on_tor_reg2">&nbsp;<input type="radio" name="bt_set_dltype_on_tor_reg" id="bt_set_dltype_on_tor_reg2" value="0" {BT_SET_DLTYPE_ON_TOR_REG_NO} /> {L_BT_SET_DLTYPE_ON_TOR_REG_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_UNSET_DLTYPE_ON_TOR_UNREG}</div><div class="gensmall">{L_BT_UNSET_DLTYPE_ON_TOR_UNREG_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_unset_dltype_on_tor_unreg1"><input type="radio" name="bt_unset_dltype_on_tor_unreg" id="bt_unset_dltype_on_tor_unreg1" value="1" {BT_UNSET_DLTYPE_ON_TOR_UNREG_YES} /> {L_BT_UNSET_DLTYPE_ON_TOR_UNREG_YES}&nbsp;</label><label for="bt_unset_dltype_on_tor_unreg2">&nbsp;<input type="radio" name="bt_unset_dltype_on_tor_unreg" id="bt_unset_dltype_on_tor_unreg2" value="0" {BT_UNSET_DLTYPE_ON_TOR_UNREG_NO} /> {L_BT_UNSET_DLTYPE_ON_TOR_UNREG_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_BT_ADD_AUTH_KEY_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_ADD_AUTH_KEY}</div><div class="gensmall">{L_BT_ADD_AUTH_KEY_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_add_auth_key1"><input type="radio" name="bt_add_auth_key" id="bt_add_auth_key1" value="1" {BT_ADD_AUTH_KEY_YES} /> {L_BT_ADD_AUTH_KEY_YES}&nbsp;</label><label for="bt_add_auth_key2">&nbsp;<input type="radio" name="bt_add_auth_key" id="bt_add_auth_key2" value="0" {BT_ADD_AUTH_KEY_NO} /> {L_BT_ADD_AUTH_KEY_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_FORCE_PASSKEY}</div><div class="gensmall">{L_BT_FORCE_PASSKEY_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_force_passkey1"><input type="radio" name="bt_force_passkey" id="bt_force_passkey1" value="1" {BT_FORCE_PASSKEY_YES} /> {L_BT_FORCE_PASSKEY_YES}&nbsp;</label><label for="bt_force_passkey2">&nbsp;<input type="radio" name="bt_force_passkey" id="bt_force_passkey2" value="0" {BT_FORCE_PASSKEY_NO} /> {L_BT_FORCE_PASSKEY_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_GEN_PASSKEY_ON_REG}</div><div class="gensmall">{L_BT_GEN_PASSKEY_ON_REG_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_gen_passkey_on_reg1"><input type="radio" name="bt_gen_passkey_on_reg" id="bt_gen_passkey_on_reg1" value="1" {BT_GEN_PASSKEY_ON_REG_YES} /> {L_BT_GEN_PASSKEY_ON_REG_YES}&nbsp;</label><label for="bt_gen_passkey_on_reg2">&nbsp;<input type="radio" name="bt_gen_passkey_on_reg" id="bt_gen_passkey_on_reg2" value="0" {BT_GEN_PASSKEY_ON_REG_NO} /> {L_BT_GEN_PASSKEY_ON_REG_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_BT_TOR_BROWSE_ONLY_REG_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_TOR_BROWSE_ONLY_REG}</div><div class="gensmall">{L_BT_TOR_BROWSE_ONLY_REG_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_tor_browse_only_reg1"><input type="radio" name="bt_tor_browse_only_reg" id="bt_tor_browse_only_reg1" value="1" {BT_TOR_BROWSE_ONLY_REG_YES} /> {L_BT_TOR_BROWSE_ONLY_REG_YES}&nbsp;</label><label for="bt_tor_browse_only_reg2">&nbsp;<input type="radio" name="bt_tor_browse_only_reg" id="bt_tor_browse_only_reg2" value="0" {BT_TOR_BROWSE_ONLY_REG_NO} /> {L_BT_TOR_BROWSE_ONLY_REG_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SEARCH_BOOL_MODE}</div><div class="gensmall">{L_BT_SEARCH_BOOL_MODE_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_search_bool_mode1"><input type="radio" name="bt_search_bool_mode" id="bt_search_bool_mode1" value="1" {BT_SEARCH_BOOL_MODE_YES} /> {L_BT_SEARCH_BOOL_MODE_YES}&nbsp;</label><label for="bt_search_bool_mode2">&nbsp;<input type="radio" name="bt_search_bool_mode" id="bt_search_bool_mode2" value="0" {BT_SEARCH_BOOL_MODE_NO} /> {L_BT_SEARCH_BOOL_MODE_NO} &nbsp;</label></span></td>
	</tr>

	<tr>
		<th class="thHead" colspan="2">{L_BT_SHOW_DL_STAT_ON_INDEX_HEAD}</th>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_SHOW_DL_STAT_ON_INDEX}</div><div class="gensmall">{L_BT_SHOW_DL_STAT_ON_INDEX_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_show_dl_stat_on_index1"><input type="radio" name="bt_show_dl_stat_on_index" id="bt_show_dl_stat_on_index1" value="1" {BT_SHOW_DL_STAT_ON_INDEX_YES} /> {L_BT_SHOW_DL_STAT_ON_INDEX_YES}&nbsp;</label><label for="bt_show_dl_stat_on_index2">&nbsp;<input type="radio" name="bt_show_dl_stat_on_index" id="bt_show_dl_stat_on_index2" value="0" {BT_SHOW_DL_STAT_ON_INDEX_NO} /> {L_BT_SHOW_DL_STAT_ON_INDEX_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td class="row1"><div class="gen">{L_BT_NEWTOPIC_AUTO_REG}</div><div class="gensmall">{L_BT_NEWTOPIC_AUTO_REG_EXPL}</div></td>
		<td class="row2" nowrap="nowrap"><span class="gen"><label for="bt_newtopic_auto_reg1"><input type="radio" name="bt_newtopic_auto_reg" id="bt_newtopic_auto_reg1" value="1" {BT_NEWTOPIC_AUTO_REG_YES} /> {L_BT_NEWTOPIC_AUTO_REG_YES}&nbsp;</label><label for="bt_newtopic_auto_reg2">&nbsp;<input type="radio" name="bt_newtopic_auto_reg" id="bt_newtopic_auto_reg2" value="0" {BT_NEWTOPIC_AUTO_REG_NO} /> {L_BT_NEWTOPIC_AUTO_REG_NO} &nbsp;</label></span></td>
	</tr>
	<tr>
		<td colspan="2" class="catBottom" align="center" height="28">
			{S_HIDDEN_FIELDS}
			<input type="reset" value="{L_RESET}" class="liteoption" />&nbsp;&nbsp;
			<input type="submit" name="submit" id="send" value="{L_SUBMIT}" class="mainoption" disabled="disabled" />&nbsp;&nbsp;
			<label for="confirm">{L_CONFIRM}&nbsp;<input onclick="toggle_disabled('send', this.checked)" id="confirm" type="checkbox" name="confirm" value="1" /></label>
		</td>
	</tr>
</table>
</form>

<br clear="all" />

<div align="center"><span class="copyright">{TP_VER_INFO}</span></div>