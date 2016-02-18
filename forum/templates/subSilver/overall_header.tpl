<!DOCTYPE>
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
<title>{PAGE_TITLE} :: {SITENAME}</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="templates/subSilver/subSilver.css" type="text/css">
<!-- //qr -->
<script language="JavaScript" type="text/javascript" src="misc/js/main.js"></script>
<!-- IF INCL_BBCODE_JS -->
<script language="JavaScript" type="text/javascript" src="misc/js/bbcode.js"></script>
<script language="JavaScript" type="text/javascript" src="misc/js/imgfit.js"></script>
<!-- ENDIF -->
<!-- //qr end -->
<script language="JavaScript" type="text/javascript" src="misc/js/jquery.pack.js"></script>
<script language="JavaScript" type="text/javascript" src="misc/js/jquery.js"></script>
<script type="text/javascript">
<!--
var ExternalLinks_InNewWindow = '1';
jQuery.noConflict();
function initSpoilers(context)
{
	var context = context || 'body';
	jQuery('div.spoiler-body').each( function() {  
		var code = jQuery(this).find('textarea').text(); 
		if(code) jQuery(this).html(code); 
	}); 
	jQuery('div.spoiler-head', jQuery(context)).click(function() {
		var code = jQuery(this).next('div.spoiler-body').find('textarea').text(); 
		if(code) jQuery(this).next('div.spoiler-body').html(code);
		jQuery(this).toggleClass('unfolded');
		jQuery(this).next('div.spoiler-body').slideToggle('fast');
	});
}
function initForums(context)
{
	var context = context || 'body';
	jQuery('div.forum-head', jQuery(context)).click(function() {
		jQuery(this).toggleClass('unforded');
		jQuery(this).next('div.forum-body').slideToggle('fast');
	});
}
function initExternalLinks(context)
{
	var context = context || 'body';
	if (ExternalLinks_InNewWindow) {
		jQuery("a.postLink:not([@href*='"+ window.location.hostname +"/'])", jQuery(context))
			.bind("click", function(){ return !window.open(this.href); })
		;
	}
}
jQuery(document).ready(function(){
	initSpoilers('body');
	initForums('body');
	initExternalLinks();
});

//-->
</script>
<script type="text/javascript">
$(function(){
	$('#cse-search-btn, #cse-search-btn-top').click(function(){
		var text_match_input_id = $(this).attr('href');
		var text_match = $('#'+text_match_input_id).val();
		if (text_match == '') {
			$('#'+text_match_input_id).addClass('hl-err-input').focus();
			return false;
		}
		$('#cse-text-match').val( text_match );
		$('#cse-submit-btn').click();
		return false;
	});

	$('#quick-search').submit(function(){
		var action = $('#search-action').val();
		var txt = $('#search-text').val();
		if (txt=='поиск...' || txt == '') {
			$('#search-text').val('').addClass('hl-err-input').focus();
			return false;
		}
		if (action == 'cse') {
			$('#cse-search-btn-top').click();
			return false;
		}
		else {
			$(this).attr('action', action);
		}
	});
});
</script>
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
<script language="javascript">
<!--
	var myimages=new Array()
	function preloadimages() {
	for (i=0;i<preloadimages.arguments.length;i++) {
		myimages[i]=new Image()
		myimages[i].src=preloadimages.arguments[i]
		}
	}
preloadimages("templates/subSilver/images/cellpic3.gif","templates/subSilver/images/cellpic1.gif");
//--></script>
</head>
<body onload="preloadimages()" style="padding: 0px; margin: 0px; font: 12px Verdana,Arial,Helvetica,sans-serif;">

<!-- IF SVISTOK -->
<style type="text/css">
<!--
a.svistok:link, a.svistok:visited, a.svistok:hover, a.svistok:active {
	color: #000000; font-size: 13px; font-weight: bold; text-decoration: none; }
-->
</style>

<div style="position: absolute; top: 28px; right: 4px;">
<table cellpadding="0" cellspacing="1" border="0" bgcolor="#DEAA73">
	<tr>
		<td bgcolor="#FFFFFF">
			<table width="100%" cellpadding="0" cellspacing="2" border="0">
				<tr>
					<td align="center" bgcolor="#DEAA73" style="padding: 16px 20px 16px 20px"><a href="{U_PRIVATEMSGS}" class="svistok">{PRIVATE_MESSAGE_INFO}</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
<!-- ENDIF -->

<a name="top"></a>

<!--main_nav-->
<div id="main_nav" style="height: 17px;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="nowrap">
			<a href="{U_INDEX}"><b>{L_Index}</b></a>&#0183;
			<a href="{TRACKER_HREF}"><b>{L_TRACKER}</b></a>&#0183;
			<a href="{U_SEARCH}"><b>{L_SEARCH}</b></a>&#0183;
			<a href="viewtopic.php?t=1045"><b>{L_TERMS}</b></a>&#0183;
			<a href="{U_FAQ}"><b style="color: #993300;">{L_FAQ}</b></a>&#0183;
			<a href="{U_PRIVATEMSGS}"><b>{L_PM}</b></a>&#0183;
            <a href="{U_GROUP_CP}"><b>{L_USERGROUPS}</b></a>&#0183;
			<a href="{U_MEMBERLIST}"><b>{L_MEMBERLIST}</b></a>&#0183;
            <a href="{U_TOP-10}"><b>{L_TOP-10}</b></a> 
		</td>
	</tr>
	</table>
</div>
<!--/main_nav-->

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center">
<tr>
     <td class="bodyline"><table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
		  <td><a href="{U_INDEX}"><img src="templates/subSilver/images/logo.gif" border="0" alt="{L_INDEX}" vspace="1" /></a></td>
	  </tr>
     </table>

<!-- IF LOGGED_IN -->
<div style="position: absolute; top: 3px; right: 12px;">
<form id="quick-search" action="" method="post">
	<input id="search-text" type="text" name="nm" style="width: 150px; color:#666666; font-style:italic;" id="sk" size="50" value="поиск..." onfocus="if ((this.style.color=='rgb(102, 102, 102)') || (this.style.color=='#666666')) {this.value=''; this.style.color='#000000'; this.style.fontStyle='normal'}" onblur="if (this.value=='' && ((this.style.color=='rgb(0, 0, 0)') || (this.style.color=='#000000'))) {this.style.color='#666666'; this.style.fontStyle='italic'; this.value='поиск...';};"/>
		<select id="search-action">
			<option value="tracker.php" selected="selected"> по трекеру </option>
			<option value="search.php"> по форуму </option>
		</select>
		<input type="submit" class="mainoption" value="&raquo;" style="width: 30px;" />
</form>		
</div>
<!-- ENDIF -->

<!-- IF LOGGED_IN -->
<!--logout-->
<div class="topmenu">
   <table width="100%" cellpadding="0" cellspacing="0">
   <tr>
      <td align="left">
      <!-- //bt -->
	<!-- BEGIN user_ratio -->
      <span class="mainmenu">Отдано: <span class="seedsmall"><b>{user_ratio.U_UP_TOTAL}</b></span> &#0183; Бонус: <span class="seedsmall"><b>{user_ratio.U_BONUS_TOTAL}</b></span> &#0183; Скачано: <span class="leechsmall"><b>{user_ratio.U_DOWN_TOTAL}</b></span> &#0183; Рейтинг: <span class="small"><b>{user_ratio.U_RATIO}</b></span></span>
      <!-- END user_ratio -->
	<!-- //bt end --> 
      </td>
      <td align="center">
      <!-- IF PM_FLASH -->
	<a href="{U_PRIVATEMSGS}" class="mainmenu" id="flashlink0" flashtype="0" flashcolor="crimson"><b><!-- IF PRIVATE_MESSAGE_INFO_UNREAD -->{PRIVATE_MESSAGE_INFO_UNREAD}<!-- ELSE -->{PRIVATE_MESSAGE_INFO}<!-- ENDIF --></b></a>&nbsp;<!-- ELSE -->&nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><!-- IF PRIVATE_MESSAGE_INFO_UNREAD -->{PRIVATE_MESSAGE_INFO_UNREAD}<!-- ELSE -->{PRIVATE_MESSAGE_INFO}<!-- ENDIF --></a>
	<!-- ENDIF -->
      </td>
      <td align="right">
      <a href="{U_EDIT_PROFILE}" class="mainmenu">Настройки</a> &#0183;
      <a href="{U_PROFILE}" class="mainmenu">Торрент-профиль</a> &#0183;
      <a href="{U_LOGIN_LOGOUT}" class="mainmenu" onclick="return confirm('Выйти?');">{L_LOGIN_LOGOUT}</a>
      </td>
         </tr>
   </table>
</div>
<!--/logout-->
<!-- ELSE -->

<!--login form-->
<div class="topmenu">
<table width="100%" cellpadding="0" cellspacing="0">
<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
<td align="center" style="font-size: 11">
<a href="{U_REGISTER}" style="text-decoration:none"><b>{L_REGISTER}</b></a> &#0183;  
{L_USERNAME}:
<input class="post" type="text" name="username" size="10" />
{L_PASSWORD}:
<input class="post" type="password" name="password" size="10" maxlength="32" />
<input class="text" type="checkbox" name="autologin" /> Запомнить&nbsp; 
<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" /> &nbsp;&#0183;&nbsp;
<a href="{U_SEND_PASSWORD}" style="text-decoration:none">{L_FORGOTTEN_PASSWORD}</a> 
</td>
</tr>
</form>
<!-- END switch_user_logged_out -->   
</table>
</div>
<!--/login form-->
<!-- ENDIF -->

<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
