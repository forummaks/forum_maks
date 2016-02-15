<script language="JavaScript">
<!--
function set_hid_cbox (cb_id, post_id, tr1_id, tr2_id)
{
	document.getElementById('del_split_row').className = 'row1';
	var cb  = document.getElementById(cb_id);
	var tr1 = document.getElementById(tr1_id);
	var tr2 = document.getElementById(tr2_id);
	cb.value	= (cb.value == post_id) ? 0 : post_id;
	if (cb.value == post_id) {
		tr1.className = tr2.className = 'sel';
	}
	else {
		tr1.className = tr2.className = ( !(tr1_id % 2) ) ? 'row1' : 'row2';
	}
	return false;
}

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
<style type="text/css">
<!--
.sel { background-color:#FFEFD5; }
.hiddenRow { display:none; }
-->
</style>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a>
	  <!-- IF PAGINATION --><br /><span class="gensmall" style="line-height: 200%"><b>{PAGINATION}</b><!-- ENDIF -->
	  &nbsp; </span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>
	<!-- IF HAS_PARENT_FORUM --> -> <a class="nav" href="{PARENT_FORUM_HREF}">{PARENT_FORUM_NAME}</a><!-- ENDIF -->
	-> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
  </tr>
</table>

<!-- //bt -->
<!-- IF SHOW_DL_LIST || SHOW_TOR_ACT --><!-- INCLUDE viewtopic_torrent.tpl --><!-- ENDIF -->
<!-- //bt end -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	{POLL_DISPLAY}
	<tr>
		<th class="thLeft" width="12%"  height="26" nowrap="nowrap">{L_AUTHOR}</th>
		<th class="thRight" nowrap="nowrap" width="95%">{L_MESSAGE}</th>
	</tr>


	<!-- BEGIN postrow -->

	<tr <!-- IF postrow.MOD_CHECKBOX -->id="{postrow.ROW_ID_1}"<!-- ENDIF --> class="{postrow.ROW_CLASS}">
		<td valign="top" class="gensmall"<!-- IF postrow.POSTER_BOT --> style="border-bottom: 1px solid #ADBAC6;"<!-- ENDIF -->><a name="{postrow.U_POST_ID}"></a>
		<!-- IF postrow.POSTER_BOT -->
			<!-- IF SHOW_BOT_NICK --><div class="name" style="padding-top: 2px"><b>{postrow.POSTER_NAME}</b></div><!-- ENDIF --><img src="images/spacer.gif" width="122" height="2" border="0" alt="" /><div <!-- IF postrow.MOD_CHECKBOX -->onclick="set_hid_cbox('{postrow.CB_ID}', '{postrow.U_POST_ID}', '{postrow.ROW_ID_1}', '{postrow.ROW_ID_2}')"<!-- ENDIF --> style="margin-bottom: 2px">{postrow.POSTER_AVATAR}</div>
		<!-- ELSE -->
   <!-- IF QUICK_REPLY --><div class="genmed" style="padding-top: 2px" title="{L_INS_NAME_TIP}" onmouseout="bbcode && bbcode.refreshSelection(false)" onmouseover="bbcode && bbcode.refreshSelection(true)" onclick="bbcode && bbcode.onclickPoster('{postrow.POSTER_NAME}'); return false"><a href="#" class="gen" style="font-size: 13px" onclick="return false"><b>{postrow.POSTER_NAME}</b></a></div><!-- ELSE --><div class="name" style="padding-top: 2px"><b>{postrow.POSTER_NAME}</b></div><!-- ENDIF --><!-- IF postrow.POSTER_RANK --><div style="padding-top: 2px">{postrow.POSTER_RANK}</div><!-- ENDIF --><!-- IF postrow.RANK_IMAGE --><div style="padding-top: 2px">{postrow.RANK_IMAGE}</div><!-- ENDIF --><!-- IF postrow.POSTER_AVATAR --><div style="padding-top: 3px">{postrow.POSTER_AVATAR}</div><!-- ENDIF --><!-- IF postrow.POSTER_JOINED --><div style="padding-top: 2px">{postrow.POSTER_JOINED}</div><!-- ENDIF --><!-- IF postrow.POSTER_POSTS --><div style="padding-top: 2px">{postrow.POSTER_POSTS}</div><!-- ENDIF --><!-- IF postrow.POSTER_FROM --><div style="padding-top: 2px">{postrow.POSTER_FROM}</div><!-- ENDIF --><!-- IF postrow.POSTER_FROM_FLAG --><div style="padding-top: 2px">{postrow.POSTER_FROM_FLAG}</div><!-- ENDIF --><div><img src="images/spacer.gif" width="122" height="<!-- IF postrow.POSTER_AVATAR || postrow.POSTER_FROM_FLAG || postrow.RANK_IMAGE -->2<!-- ELSE -->20<!-- ENDIF -->" border="0" alt="" /></div>
		<!-- ENDIF -->
		</td>
		<td height="28" valign="top" style="padding: 0px;<!-- IF postrow.POSTER_BOT --> border-bottom: 1px solid #ADBAC6;<!-- ENDIF -->"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="gensmall" valign="middle" style="padding: 4px"><a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a> <a class="gensmall" href="{postrow.U_MINI_POST}" title="{L_POST_LINK}">{postrow.POST_DATE}</a></td>
				<td align="right" valign="middle" nowrap="nowrap" style="padding: 4px 2px 4px 4px"><span class="txtb"><!-- IF postrow.POSTER_BOT -->{postrow.DELETE}<!-- ELSE -->{postrow.QUOTE} {postrow.EDIT} {postrow.DELETE} {postrow.IP}<!-- ENDIF --></span></td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 6px; border-top: 1px solid #ADBAC6;"><div><span class="postbody">{postrow.MESSAGE}<br clear="all" /></span>{postrow.ATTACHMENTS}</div><div><span class="postbody">{postrow.SIGNATURE}</span><span class="gensmall">{postrow.EDITED_MESSAGE}</span></div></td>
			</tr>
		</table></td>
	</tr>
	<!-- IF postrow.POSTER_BOT -->
	<!-- ELSE -->
	<tr <!-- IF postrow.MOD_CHECKBOX -->id="{postrow.ROW_ID_2}"<!-- ENDIF --> class="{postrow.ROW_CLASS}">
		<!-- IF postrow.MOD_CHECKBOX -->
		<td style="border-bottom:1px solid #ADBAC6; padding:4px; cursor:pointer;" valign="middle" onclick="set_hid_cbox('{postrow.CB_ID}', '{postrow.U_POST_ID}', '{postrow.ROW_ID_1}', '{postrow.ROW_ID_2}');">
			<span class="gensmall">{L_SELECT}</span>
		</td>
		<!-- ELSE -->
		<td style="border-bottom: 1px solid #ADBAC6; padding: 4px" valign="middle">
			<span class="postdetails"><a href="#top" class="genmed">{L_BACK_TO_TOP}</a></span>
		</td>
		<!-- ENDIF -->
		<td style="border-bottom: 1px solid #ADBAC6;" valign="middle" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td valign="middle" class="txtb" nowrap="nowrap"> &nbsp;{postrow.PROFILE} {postrow.PM} {postrow.EMAIL} {postrow.WWW} {postrow.AIM} {postrow.YIM} {postrow.MSN} {postrow.ICQ}</td>
			</tr>
		</table></td>
	</tr>
	<!-- ENDIF -->
	<!-- END postrow -->

	<!-- IF SPLIT_FORM -->
	<tr id="del_split_row" class="hiddenRow">
		<td class="genmed" colspan="2" align="center" style="padding: 2px">
			<form method="post" action="{S_SPLIT_ACTION}" style="display: inline">

			<!-- BEGIN postrow -->
			<input type="hidden" name="post_id_list[]" value="" id="{postrow.CB_ID}" />
			<!-- END postrow -->

			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-width: 0px;">
				<tr>
					<td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_SUBJECT}</span></td>
					<td class="row2"><input class="post" type="text" size="35" style="width: 500px" maxlength="120" name="subject" /></td>
				</tr>
				<tr>
					<td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_FORUM}</span></td>
					<td class="row2">{S_FORUM_SELECT}</td>
				</tr>
				<!-- //bot -->
				<tr>
					<td colspan="2" class="row2" align="center" style="padding: 0px">
						<table cellspacing="2" cellpadding="2" border="0">
							<tr>
								<td class="row2" align="center"><span class="gen"><input type="checkbox" name="after_split_to_old" id="after_split_to_old" checked="checked" /><label for="after_split_to_old"> {L_AFTER_SPLIT_TO_OLD}</label></span></td>
								<td>&nbsp;</td>
								<td class="row2" align="center"><span class="gen"><input type="checkbox" name="after_split_to_new" id="after_split_to_new" checked="checked" /><label for="after_split_to_new"> {L_AFTER_SPLIT_TO_NEW}</label></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- //bot end -->
				<tr>
					<td height="28" colspan="2" align="center" class="row3">
						<input class="liteoption" type="submit" name="delete_posts" id="del" value="{L_DELETE_POSTS}" disabled="disabled" style="width: 140px;" />
						<input class="liteoption" type="submit" name="split_type_all" id="spl_all" value="{L_SPLIT_POSTS}" disabled="disabled" style="width: 210px;" />
						<input class="liteoption" type="submit" name="split_type_beyond" id="spl_b" value="{L_SPLIT_AFTER}" disabled="disabled" style="width: 270px;" />
						<nobr><label for="spl_cnf">{L_CONFIRM}&nbsp;<input onclick="toggle_disabled('del', this.checked); toggle_disabled('spl_all', this.checked); toggle_disabled('spl_b', this.checked)" id="spl_cnf" type="checkbox" name="confirm" value="1" /></label></nobr>

						<input type="hidden" name="sid" value="{SID}" />
						<input type="hidden" name="{POST_FORUM_URL}" value="{FORUM_ID}" />
						<input type="hidden" name="{POST_TOPIC_URL}" value="{TOPIC_ID}" />
						<input type="hidden" name="start" value="{START}" />
						<input type="hidden" name="mode" value="split" />
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<!-- ENDIF -->

	<tr>
		<td class="{PAG_ROW_CLASS}" colspan="2" height="28" style="padding: 0px">
			<table width="100%" border="0" cellpadding="6" cellspacing="0">
   	<tr>
					<td nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
   		<td nowrap="nowrap" align="right"><span class="nav">{PAGINATION}</span></td>
  		</tr>
			</table>
		</td>
	</tr>
	<!-- IF QUICK_REPLY -->
	<tr>
		<th colspan="2" class="thHead" height="25" align="center"><b>Quick Reply</b></th>
	</tr>
	<tr>
		<td colspan="2" class="row2" align="center">
		<form style="display: inline" action="{QR_POST_ACT}" method="post" name="post" onsubmit="return checkForm(this)">
		<input type="hidden" name="sid" value="{QR_SID}" />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<!-- IF QR_GUEST -->
				<tr>
					<td align="center" style="padding: 6px 0px 0px 0px;"><span class="gen"><b>{L_QR_USERNAME}: </b></span><span class="genmed"><input type="text" class="post" name="username" size="20" maxlength="18" value="" /></span></td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td align="center" style="padding: 6px 0px 6px 0px;">
					<span class="genmed">
						<input class="button" title="Bold (Ctrl+B)" style="font-weight: bold; width: 30px" type="button" value=" B " name="codeB" />
						<input class="button" title="Italic (Ctrl+I)" style="width: 30px; font-style: italic" type="button" value=" i " name="codeI" />
						<input class="button" title="Underline (Ctrl+U)" style="width: 30px; text-decoration: underline" type="button" value=" u " name="codeU" />&nbsp;
						<input class="button" title="Quote (Ctrl+Q)" style="width: 50px" type="button" value="Quote" name="codeQuote" />
						<input class="button" title="Image (Ctrl+R)" style="width: 40px" type="button" value="Img" name="codeImg" />
						<input class="button" title="URL (Ctrl+W)" style="width: 40px; text-decoration: underline" type="button" value="URL" name="codeUrl" /><input type="hidden" name="codeUrl2" />&nbsp;
                                    <input class="button" type="button" value="Spoiler" name="codeSpoiler" title="Spoiler (Ctrl+S)" style="width: 60px; text-decoration: underline" />
						<input class="button" title="Code (Ctrl+K)" style="width: 40px" type="button" value="Code" name="codeCode" />
						<input class="button" title="List (Ctrl+L)" style="width: 40px" type="button" value="List" name="codeList" />
						<input class="button" title="List item (Ctrl+0)" style="width: 30px" type="button" value="1." name="codeOpt" />&nbsp;
						<input class="button" title="{L_QUOTE_SEL}" style="width: 100px" type="button" name="quoteselected" value="Quote selected" onmouseout="bbcode && bbcode.refreshSelection(false)" onmouseover="bbcode && bbcode.refreshSelection(true)" onclick="bbcode && bbcode.onclickQuoteSel(); return false" />
						<input class="button" title="Перевести выделение с транслита на русский" style="width: 60px" onclick="dk_translit2win(document.post.message, this)" type="button" value="Translit" />
						<input class="button" title="Показать смайлики" style="width: 30px" onclick="window.open('posting.php?mode=smilies', '_phpbbsmilies', 'HEIGHT=400,WIDTH=500,resizable=yes,scrollbars=yes'); return false" type="button" value="(-;" />
					</span>
					</td>
				</tr>
				<tr>
					<td class="row2" align="center" valign="top"><span class="gen"><textarea id="post_body" name="message" rows="17" cols="78" wrap="virtual" style="width:640px" class="post" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)">{MESSAGE}</textarea></span></td>
				</tr>
				<tr>
					<td class="row2" align="center" valign="middle" style="padding: 6px"><input type="hidden" name="mode" value="reply" /><input type="hidden" name="t" value="{QR_TOPIC_ID}" />
						<input style="width: 140px" title="Alt+Enter" type="submit" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;
						<input style="width: 100px" title="Ctrl+Enter" type="submit" name="post" class="mainoption" value="{L_SUBMIT}" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="translit_opt" class="hiddenRow">
		<td colspan="2" class="row2" align="center">
		<table border="0" cellpadding="0" cellspacing="4">
		<tr>
			<td class="t">А</td><td>-</td><td>a</td>
			<td class="t">Д</td><td>-</td><td>d</td>
			<td class="t">И</td><td>-</td><td>i</td>
			<td class="t">М</td><td>-</td><td>m</td>
			<td class="t">Р</td><td>-</td><td>r</td>
			<td class="t">Ф</td><td>-</td><td>f</td>
			<td class="t">Ш</td><td>-</td><td>sh</td>
			<td class="t">Ы</td><td>-</td><td>y</td>
		</tr>
		<tr>
			<td class="t">Б</td><td>-</td><td>b</td>
			<td class="t">Е</td><td>-</td><td>e</td>
			<td class="t">Й</td><td>-</td><td>j</td>
			<td class="t">Н</td><td>-</td><td>n</td>
			<td class="t">С</td><td>-</td><td>s</td>
			<td class="t">Х</td><td>-</td><td>h</td>
			<td class="t">Щ</td><td>-</td><td>sz</td>
			<td class="t">Э</td><td>-</td><td>eh</td>
		</tr>
		<tr>
			<td class="t">В</td><td>-</td><td>v</td>
			<td class="t">Ж</td><td>-</td><td>zh</td>
			<td class="t">К</td><td>-</td><td>k</td>
			<td class="t">О</td><td>-</td><td>o</td>
			<td class="t">Т</td><td>-</td><td>t</td>
			<td class="t">Ц</td><td>-</td><td>c</td>
			<td class="t">Ь</td><td>-</td><td>'</td>
			<td class="t">Ю</td><td>-</td><td>ju</td>
		</tr>
		<tr>
			<td class="t">Г</td><td>-</td><td>g</td>
			<td class="t">З</td><td>-</td><td>z</td>
			<td class="t">Л</td><td>-</td><td>l</td>
			<td class="t">П</td><td>-</td><td>p</td>
			<td class="t">У</td><td>-</td><td>u</td>
			<td class="t">Ч</td><td>-</td><td>ch</td>
			<td class="t">Ъ</td><td>-</td><td>&quot;</td>
			<td class="t">Я</td><td>-</td><td>ja</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr id="post_opt" class="row2">
		<td colspan="2" class="row2" align="center">
			<table cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td class="genmed">{L_QR_DISABLE}:&nbsp;</td>

					<td class="genmed"><input type="checkbox" name="disable_html" id="disable_html" {QR_DIS_HTML_CH} {QR_DIS_HTML_DS} /></td>
					<td class="genmed"><label for="disable_html">HTML&nbsp;</label></td>

					<td class="genmed"><input type="checkbox" name="disable_bbcode" id="disable_bbcode" {QR_DIS_BBCODE_CH} {QR_DIS_BBCODE_DS} /></td>
					<td class="genmed"><label for="disable_bbcode">BBCode&nbsp;</label></td>

					<td class="genmed"><input type="checkbox" name="disable_smilies" id="disable_smilies" {QR_DIS_SMILIES_CH} {QR_DIS_SMILIES_DS} /></td>
					<td class="genmed"><label for="disable_smilies">Smilies&nbsp;</label>&nbsp;&nbsp;&nbsp;</td>

					<td class="genmed"><input type="checkbox" name="attach_sig" id="attach_sig" {QR_SIGNAT_CH} {QR_SIGNAT_DS} /></td>
					<td class="genmed"><label for="attach_sig">{L_QR_ATTACH_SIG}&nbsp;</label>&nbsp;&nbsp;&nbsp;</td>

					<td class="genmed"><input type="checkbox" name="notify" id="notify" {QR_NOTIFY_CH} {QR_NOTIFY_DS} /></td>
					<td class="genmed"><label for="notify">{L_QR_NOTIFY}&nbsp;</label></td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="row2" align="center" style="padding: 4px"><span class="genmed"><a href="#" onclick="toggle_TR('translit_opt'); return false" class="genmed">{L_TRANSL_RULES}</a></span>
			<script language="JavaScript">
			<!--
			var bbcode = new BBCode(document.post.message);
			var ctrl = "ctrl";
			bbcode.addTag("codeB", "b", null, "B", ctrl);
			bbcode.addTag("codeI", "i", null, "I", ctrl);
			bbcode.addTag("codeU", "u", null, "U", ctrl);

			bbcode.addTag("codeQuote", "quote", null, "Q", ctrl);
			bbcode.addTag("codeImg", "img", null, "R", ctrl);
			bbcode.addTag("codeUrl", "url", "/url", "", ctrl);
			bbcode.addTag("codeUrl2", "url=", "/url", "W", ctrl);

                  bbcode.addTag("codeSpoiler", "spoiler", null, "S", ctrl);
			bbcode.addTag("codeCode", "code", null, "K", ctrl);
			bbcode.addTag("codeList",  "list", null, "L", ctrl);
			bbcode.addTag("codeOpt", "*", "", "0", ctrl);
			//-->
			</script>
		</td>
	</tr>
	<!-- ENDIF -->
	<tr>
		<td class="catBottom" colspan="2" height="28" align="center">
		<form method="post" action="{S_POST_DAYS_ACTION}" style="display: inline">
		<span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span>
		</form>
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
		<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>
	 <!-- IF HAS_PARENT_FORUM --> -> <a class="nav" href="{PARENT_FORUM_HREF}">{PARENT_FORUM_NAME}</a><!-- ENDIF -->
	 -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
		<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr>
	<td width="40%" valign="top" nowrap="nowrap" align="left"><span class="gensmall">{S_WATCH_TOPIC}</span><br />
	  &nbsp;<br />
	  <span class="gensmall">{S_TOPIC_ADMIN}</span>
	  <br /><span class="gensmall">{S_DL_DELETE}</span>
	  </td>
	<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
  </tr>
</table>