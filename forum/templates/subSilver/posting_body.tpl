<script src="templates/subSilver/kb.js" language="javascript"></script>
<style type="text/css">
<!--
/*  Mail.ru Keyboard buttons styles */
.b30 { width: 22px; background-color : {T_TD_COLOR1}; }
.b80 { width: 60px; background-color : {T_TD_COLOR1}; }
.b100 { width: 80px; background-color : {T_TD_COLOR1}; }
.b300 { width: 170px; background-color : {T_TD_COLOR1}; }
span.a { color:{T_BODY_LINK};cursor:pointer;text-decoration:underline }
-->
</style>
<!-- BEGIN privmsg_extensions -->
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  <tr>
	<td valign="top" align="center" width="100%">
	  <table height="40" cellspacing="2" cellpadding="2" border="0">
		<tr valign="middle">
		  <td>{INBOX_IMG}</td>
		  <td><span class="cattitle">{INBOX_LINK}&nbsp;&nbsp;</span></td>
		  <td>{SENTBOX_IMG}</td>
		  <td><span class="cattitle">{SENTBOX_LINK}&nbsp;&nbsp;</span></td>
		  <td>{OUTBOX_IMG}</td>
		  <td><span class="cattitle">{OUTBOX_LINK}&nbsp;&nbsp;</span></td>
		  <td>{SAVEBOX_IMG}</td>
		  <td><span class="cattitle">{SAVEBOX_LINK}&nbsp;&nbsp;</span></td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
<br clear="all" />
<!-- END privmsg_extensions -->
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)" {S_FORM_ENCTYPE}>
<!-- //snp -->
{SHOW_NEW_POSTS_BOX}
<!-- //snp end-->
{POST_PREVIEW_BOX}
{ERROR_BOX}
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td><span  class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>
		<!-- BEGIN switch_not_privmsg -->
		» <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a>
		{U_VIEW_TOPIC}
		</span></td>
		<!-- END switch_not_privmsg -->
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th class="thHead" colspan="2" height="25"><b>{L_POST_A}</b></th>
	</tr>
	<!-- BEGIN switch_username_select -->
	<tr>
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" /></span></td>
	</tr>
	<!-- END switch_username_select -->
	<!-- BEGIN switch_privmsg -->
	<tr>
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" />&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></span></td>
	</tr>
	<!-- END switch_privmsg -->
	<!-- BEGIN switch_show_subject -->
	<tr>
	  <td class="row1"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="100%"> <span class="gen">
		<input type="text" name="subject" size="45" maxlength="120" style="width: 100%" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>
	<!-- END switch_show_subject -->
	<tr>
	 <td class="row1" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		 <tr>
				<td><span class="gen"><b>{L_MESSAGE_BODY}</b></span></td>
		 </tr>
		 <tr>
				<td valign="top" align="center" style="padding: 20px"> <br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
						<!-- BEGIN smilies_row -->
						<tr align="center" valign="middle">
					  <!-- BEGIN smilies_col -->
					  <td><a href="#" onclick="bbcode && bbcode.emoticon('{smilies_row.smilies_col.SMILEY_CODE}'); return false"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
					  <!-- END smilies_col -->
						</tr>
						<!-- END smilies_row -->
						<!-- BEGIN switch_smilies_extra -->
						<tr align="center">
					  <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=450,resizable=yes,scrollbars=yes,WIDTH=450');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
						</tr>
						<!-- END switch_smilies_extra -->
			  </table>
				</td>
		 </tr>
		</table>
	  </td>
	  <td class="row2" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td valign="middle" style="padding-left:2px;"><span class="genmed"><select name="fontFace" onchange="bbcode.insert(this.name, this)">
						<option style="font-family: Verdana" value=-1 selected="selected">{L_FONT_SEL}:</option>
						<option style="font-family: Courier" value="Courier">&nbsp;Courier</option>
						<option style="font-family: 'Courier New'" value="'Courier New'">&nbsp;Courier New</option>
						<option style="font-family: monospace" value="monospace">&nbsp;monospace</option>
						<option style="font-family: Fixedsys" value="Fixedsys">&nbsp;Fixedsys</option>
						<option style="font-family: Arial" value="Arial">&nbsp;Arial</option>
						<option style="font-family: 'Comic Sans MS'" value="'Comic Sans MS'">&nbsp;Comic Sans</option>
						<option style="font-family: Georgia" value="Georgia">&nbsp;Georgia</option>
						<option style="font-family: Tahoma" value="Tahoma">&nbsp;Tahoma</option>
						<option style="font-family: Times New Roman" value="'Times New Roman'">&nbsp;Times</option>
						<option style="font-family: serif" value="serif">&nbsp;serif</option>
						<option style="font-family: sans-serif" value="sans-serif">&nbsp;sans-serif</option>
						<option style="font-family: cursive" value="cursive">&nbsp;cursive</option>
						<option style="font-family: fantasy" value="fantasy">&nbsp;fantasy</option>
					</select>&nbsp;&nbsp;</span>

					<span class="genmed"><select name="codeColor" onchange="bbcode.insert(this.name, this)">
						<option style="color: black" value="black" selected="selected">{L_FONT_COLOR_SEL}:</option>
						<option style="color: darkred; background-color: #ECECEC" value="darkred">&nbsp;{L_COLOR_DARK_RED}</option>
						<option style="color: brown; background-color: #ECECEC" value="brown">&nbsp;{L_COLOR_BROWN}</option>
						<option style="color: #996600; background-color: #ECECEC" value="#996600">&nbsp;{L_COLOR_ORANGE}</option>
						<option style="color: red; background-color: #ECECEC" value="red">&nbsp;{L_COLOR_RED}</option>
						<option style="color: #993399; background-color: #ECECEC" value="#993399">&nbsp;{L_COLOR_VIOLET}</option>
						<option style="color: green; background-color: #ECECEC" value="green">&nbsp;{L_COLOR_GREEN}</option>
						<option style="color: darkgreen; background-color: #ECECEC" value="darkgreen">&nbsp;{L_COLOR_DARK_GREEN}</option>
						<option style="color: gray; background-color: #ECECEC" value="gray">&nbsp;{L_COLOR_GRAY}</option>
						<option style="color: olive; background-color: #ECECEC" value="olive">&nbsp;{L_COLOR_OLIVE}</option>
						<option style="color: blue; background-color: #ECECEC" value="blue">&nbsp;{L_COLOR_BLUE}</option>
						<option style="color: darkblue; background-color: #ECECEC" value="darkblue">&nbsp;{L_COLOR_DARK_BLUE}</option>
						<option style="color: indigo; background-color: #ECECEC" value="indigo">&nbsp;{L_COLOR_INDIGO}</option>
						<option style="color: #006699; background-color: #ECECEC" value="#006699">&nbsp;{L_STEEL_BLUE}</option>
					</select>&nbsp;&nbsp;</span>

					<span class="genmed"><select name="codeSize" onchange="bbcode.insert(this.name, this)">
						<option value="12" selected="selected">{L_FONT_SIZE_SEL}:</option>
						<option style="font-weight: bold; background-color: #ECECEC" value="9">{L_FONT_SMALL}</option>
						<option value="10">&nbsp;size=10</option>
						<option value="11">&nbsp;size=11</option>
						<option value="12" disabled="disabled" style="font-weight: bold; background-color: #ECECEC">{L_FONT_NORMAL}</option>
						<option value="14">&nbsp;size=14</option>
						<option value="16">&nbsp;size=16</option>
						<option style="font-weight: bold; background-color: #ECECEC" value="18">{L_FONT_LARGE}</option>
						<option value="20">&nbsp;size=20</option>
						<option value="22">&nbsp;size=22</option>
						<option style="font-weight: bold; background-color: #ECECEC" value="24">{L_FONT_HUGE}</option>
					</select>&nbsp;&nbsp;</span>
                              <select name="codeAlign" class="text_size">
                                    <option value="left" selected="selected">Align:</option>
                                    <option value="left">&nbsp;Left</option>
                                    <option value="right">&nbsp;Right</option>
                                    <option value="center">&nbsp;Center</option>
                                    <option value="justify">&nbsp;Justify</option>
                              </select>&nbsp;&nbsp;
					<span class="genmed">
                                    <input class="button" type="button" value="IMG Left" name="ImgLeft" title="IMG Left" style="width: 60px" />
                                    <input class="button" type="button" value="IMG Right" name="ImgRight" title="IMG Right" style="width: 70px" />
					</span>
					</td>
				</tr>
				<tr>
					<td>
					<span class=genmed>
						<input class="button" type="button" value=" B " name="codeB" title="Bold (Ctrl+B)" style="font-weight: bold; width: 30px" />
						<input class="button" type="button" value=" i " name="codeI" title="Italic (Ctrl+I)" style="width: 30px; font-style: italic" />
						<input class="button" type="button" value=" u " name="codeU" title="Underline (Ctrl+U)" style="width: 30px; text-decoration: underline" />&nbsp;
						<input class="button" type="button" value="Quote" name="codeQuote" title="Quote (Ctrl+Q)" style="width: 50px" />
						<input class="button" type="button" value="Img" name="codeImg" title="Image (Ctrl+R)" style="width: 40px" />
						<input class="button" type="button" value="URL" name="codeUrl" title="URL (Ctrl+W)" style="width: 40px; text-decoration: underline" /><input type="hidden" name="codeUrl2" />&nbsp;
                                    <input class="button" type="button" value="Spoiler" name="codeSpoiler" title="Spoiler (Ctrl+S)" style="width: 60px; text-decoration: underline" />
						<input class="button" type="button" value="Code" name="codeCode" title="Code (Ctrl+K)" style="width: 46px" />
						<input class="button" type="button" value="List" name="codeList" title="List (Ctrl+L)" style="width: 46px" />
						<input class="button" type="button" value="1." name="codeOpt" title="List item (Ctrl+0)" style="width: 30px" />&nbsp;
						<input class="button" type="button" value="&#8212;" name="codeHR" title="Horizontal line (Ctrl+8)" style="font-weight: bold; width: 26px" />
						<input class="button" type="button" value="&para;" name="codeBR" title="New line" style="width: 26px;" />&nbsp;
						<input class="button" type="button" value="QS" name="quoteselected" title="{L_QUOTE_SEL}" style="width: 30px" onmouseout="bbcode && bbcode.refreshSelection(false)" onmouseover="bbcode && bbcode.refreshSelection(true)" onclick="bbcode && bbcode.onclickQuoteSel(); return false" />&nbsp;
						<input class="button" type="button" value="Translit" name="Translit" title="Перевести выделение из транслита на русский" style="width: 60px" onclick="javascript:translit();" />
					</span>
					</td>
				</tr>
				<tr>
					<td><span class="gen"><textarea tabindex="3" name="message" rows="18" wrap="virtual" style="word-wrap:break-word; width:100%;" class="post" onKeyPress="if(use_kb) return decode(event);" onFocus="storeCaret(this);" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)">{MESSAGE}</textarea></span></td>
				</tr>
				<tr>
					<td align="center" height="28">{S_HIDDEN_FORM_FIELDS}<input title="Alt+Enter" type="submit" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;&nbsp;&nbsp;<input title="Ctrl+Enter" type="submit" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
				</tr>
			</table>
</td>
	</tr>
	<!-- INCLUDE kb.tpl -->
	<tr>
	  <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
		<td class="row2" width="100%">
			<table cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td valign="top">
						<table cellspacing="0" cellpadding="1" border="0">
							<!-- BEGIN switch_html_checkbox -->
							<tr>
								<td><input type="checkbox" name="disable_html" id="disable_html" {S_HTML_CHECKED} /></td>
								<td><span class="gen"><label for="disable_html">{L_DISABLE_HTML}</label></span></td>
							</tr>
							<!-- END switch_html_checkbox -->
							<!-- BEGIN switch_bbcode_checkbox -->
							<tr>
								<td><input type="checkbox" name="disable_bbcode" id="disable_bbcode" {S_BBCODE_CHECKED} /></td>
								<td><span class="gen"><label for="disable_bbcode">{L_DISABLE_BBCODE}</label></span></td>
							</tr>
							<!-- END switch_bbcode_checkbox -->
							<!-- BEGIN switch_smilies_checkbox -->
							<tr>
								<td><input type="checkbox" name="disable_smilies" id="disable_smilies" {S_SMILIES_CHECKED} /></td>
								<td><span class="gen"><label for="disable_smilies">{L_DISABLE_SMILIES}</label></span></td>
							</tr>
							<!-- END switch_smilies_checkbox -->
						</table>
					</td>
					<td valign="top" style="padding-left:16px;">
						<table cellspacing="0" cellpadding="1" border="0">
							<!-- //upt -->
							<!-- BEGIN switch_update_post_time -->
							<tr>
								<td><input type="checkbox" name="update_post_time" id="update_post_time" {S_UPDATE_POST_TIME} /></td>
								<td><span class="gen"><label for="update_post_time">{L_UPDATE_POST_TIME}</label></span></td>
							</tr>
							<!-- END switch_update_post_time -->
							<!-- //upt end -->
							<!-- BEGIN switch_signature_checkbox -->
							<tr>
								<td><input type="checkbox" name="attach_sig" id="attach_sig" {S_SIGNATURE_CHECKED} /></td>
								<td><span class="gen"><label for="attach_sig">{L_ATTACH_SIGNATURE}</label></span></td>
							</tr>
							<!-- END switch_signature_checkbox -->
							<!-- BEGIN switch_notify_checkbox -->
							<tr>
								<td><input type="checkbox" name="notify" id="notify" {S_NOTIFY_CHECKED} /></td>
								<td><span class="gen"><label for="notify">{L_NOTIFY_ON_REPLY}</label></span></td>
							</tr>
							<!-- END switch_notify_checkbox -->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- BEGIN switch_type_toggle -->
	<tr>
		<td class="row2" colspan="2" align="center" height="28"><span class="gen">&nbsp;&nbsp;{S_TYPE_TOGGLE}</span></td>
	</tr>
	<!-- END switch_type_toggle -->
	{ATTACHBOX}
	{POLLBOX}
	<tr>
	  <td class="catBottom" colspan="2" align="center" height="28"> </td>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
	  <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>

<script language=JavaScript>
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

bbcode.addTag("codeHR", "hr", "", "8", ctrl);
bbcode.addTag("codeBR", "br", "", "", ctrl);

bbcode.addTag("ImgLeft", "img=left", "/img", "", ctrl);
bbcode.addTag("ImgRight", "img=right", "/img", "", ctrl);

bbcode.addTag("fontFace", function(e) { var v=e.value; e.selectedIndex=0; return "font=\""+v+"\"" }, "/font");
bbcode.addTag("codeColor", function(e) { var v=e.value; e.selectedIndex=0; return "color="+v }, "/color");
bbcode.addTag("codeSize", function(e) { var v=e.value; e.selectedIndex=0; return "size="+v }, "/size");
bbcode.addTag("codeAlign", function(e) { var v=e.value; e.selectedIndex=0; return "align="+v }, "/align");
//bbcode.addTag("codeLang", function(e) { var v=e.value; e.selectedIndex=0; return "lang=\""+v+"\"" }, "/lang");
//-->
</script>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr>
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
{TOPIC_REVIEW_BOX}
