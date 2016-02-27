<!DOCTYPE html>
<html>
<head>
	<title><!-- IF PAGE_TITLE -->{PAGE_TITLE} :: {SITENAME}<!-- ELSE -->{SITENAME}<!-- ENDIF --></title>
    <meta http-equiv="Content-Type" content="text/html; charset={CONTENT_ENCODING}" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    {META}
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{STYLESHEET}" type="text/css">
	<script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/jquery.pack.js"></script>
    <script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/main.js"></script>
    <!-- IF INCL_BBCODE_JS -->
    <script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/bbcode.js"></script>
    <!-- ENDIF -->
	<script type="text/javascript">
	var FT_ROOT      = "{#FT_ROOT}";
	var cookieDomain = "{$ft_cfg['cookie_domain']}";
	var cookiePath   = "{$ft_cfg['script_path']}";
	var cookiePrefix = "{$ft_cfg['cookie_prefix']}";
	var cookieSecure = {$ft_cfg['cookie_secure']};
	var LOGGED_IN    = {LOGGED_IN};
	var IWP          = 'HEIGHT=510,WIDTH=780,resizable=yes';
	var IWP_US       = 'HEIGHT=250,WIDTH=400,resizable=yes';
	var IWP_SM       = 'HEIGHT=420,WIDTH=470,resizable=yes,scrollbars=yes';
	
	var user = {
		opt_js: {USER_OPTIONS_JS},
		set: function (opt, val, days, reload) {
			this.opt_js[opt] = val;
			setCookie('opt_js', $.toJSON(this.opt_js), days);
			if (reload) {
				window.location.reload();
			}
		}
	};
	
	function getElText (e)
	{
		var t = '';
		if (e.textContent !== undefined) { t = e.textContent; } else if (e.innerText !== undefined) { t = e.innerText; } else { t = jQuery(e).text(); }
		return t;
	}
	function escHTML (txt)
	{
		return txt.replace(/</g, '&lt;');
	}
	<!-- IF USE_TABLESORTER -->
	$(document).ready(function() {
		$('.tablesorter').tablesorter();
	});
	<!-- ENDIF -->
	
	function cfm (txt)
	{
		return window.confirm(txt);
	}
	function post2url (url, params) {
		params = params || {};
		var f = document.createElement('form');
		f.setAttribute('method', 'post');
		f.setAttribute('action', url);
		params['form_token'] = '{FORM_TOKEN}';
		for (var k in params) {
			var h = document.createElement('input');
			h.setAttribute('type', 'hidden');
			h.setAttribute('name', k);
			h.setAttribute('value', params[k]);
			f.appendChild(h);
		}
		document.body.appendChild(f);
		f.submit();
		return false;
	}
	</script>
	<!--[if gte IE 7]><style type="text/css">
	input[type="checkbox"] { margin-bottom: -1px; }
	</style><![endif]-->

	<!--[if IE]><style type="text/css">
	.post-hr { margin: 2px auto; }
	.fieldsets div > p { margin-bottom: 0; }
	</style><![endif]-->
</head>
<body>

<div id="body_container">

<!--******************-->
<!-- IF SIMPLE_HEADER -->
<!--==================-->

<style type="text/css">body { background: #E3E3E3; min-width: 10px; }</style>

<!--=================-->
<!-- ELSEIF IN_ADMIN -->
<!--=================-->

<!--======-->
<!-- ELSE -->
<!--======-->

<!--page_container-->
<div id="page_container">

<!--page_header-->
<div id="page_header">

<!--main_nav-->
<div id="main-nav" style="height: 17px;">
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

<!--logo-->
<div id="logo">
	<!--<h1>{SITENAME}</h1>
	<h6>{SITE_DESCRIPTION}</h6> -->
	<a href="{U_INDEX}"><img src="templates/default/images/logo.gif" border="0" alt="{L_INDEX}" vspace="1"/></a>
</div>
<!--/logo-->

<!-- IF LOGGED_IN -->
<!--logout-->
<div class="topmenu">
    <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
			{L_USER_WELCOME}&nbsp;<b class="med">{THIS_USER}</b>&nbsp;[ <a href="{U_LOGIN_LOGOUT}" onclick="return confirm('{L_CONFIRM_LOGOUT}');">{L_LOGOUT}</a> ]
        </td>
        <td align="center">
			<!-- IF PM_FLASH -->
            <a href="{U_PRIVATEMSGS}" class="mainmenu" id="flashlink0" flashtype="0"
            flashcolor="crimson"><b><!-- IF PRIVATE_MESSAGE_INFO_UNREAD -->
            {PRIVATE_MESSAGE_INFO_UNREAD}<!-- ELSE -->
            {PRIVATE_MESSAGE_INFO}<!-- ENDIF --></b></a>&nbsp;<!-- ELSE -->&nbsp;<a
            href="{U_PRIVATEMSGS}" class="mainmenu"><!-- IF PRIVATE_MESSAGE_INFO_UNREAD -->
            {PRIVATE_MESSAGE_INFO_UNREAD}<!-- ELSE -->{PRIVATE_MESSAGE_INFO}<!-- ENDIF --></a>
            <!-- ENDIF -->
        </td>
        <td align="right">
			<a href="{U_EDIT_PROFILE}" class="mainmenu">Настройки</a> &#0183;
            <a href="{U_PROFILE}" class="mainmenu">Торрент-профиль</a>
        </td>
    </tr>
	</table>
</div>
<!--/logout-->
<!-- ELSE -->

<!--login form-->
<div class="topmenu">
    <table width="100%" cellpadding="0" cellspacing="0">
       <tr>
			<td class="tCenter pad_2">
				<a href="{U_REGISTER}" id="register_link"><b>{L_REGISTER}</b></a> &#0183;
					<form action="{S_LOGIN_ACTION}" method="post">
						{L_USERNAME}: <input type="text" name="login_username" size="12" tabindex="1" accesskey="l" />
						{L_PASSWORD}: <input type="password" name="login_password" size="12" tabindex="2" />
						<label title="{L_AUTO_LOGIN}"><input type="checkbox" name="autologin" value="1" tabindex="3" checked="checked" />{L_REMEMBER}</label>&nbsp;
						<input type="submit" name="login" value="{L_LOGIN}" tabindex="4" />
					</form> &#0183;
				<a href="{U_SEND_PASSWORD}">{L_FORGOTTEN_PASSWORD}</a>
			</td>
		</tr>
	</table>
</div>
<!--/login form-->
<!-- ENDIF -->

</div>
<!--/page_header-->

<!--page_content-->
<div id="page_content">
<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
    <tr><!-- IF SHOW_SIDEBAR1 -->
		<!--sidebar1-->
		<td id="sidebar1">
			<div id="sidebar1-wrap">
				<img src="images/left-banner.gif" style="border: 1px solid #000000; width: 200px; height: 400px;">
			</div>
		</td>
		<!--/sidebar1-->
<!-- ENDIF -->

<!--main_content-->
<td id="main_content">
	<div id="main_content_wrap">
		<div id="latest_news">
			<!-- IF SHOW_LATEST_NEWS -->
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="100%" style="padding-left: 1px">
					<div style="font-size: 13px; font-weight: bold; letter-spacing: 1px; padding: 6px 0 3px 0; color: #333333;">Новости трекера</div>
					<table cellpadding="0">
					  <!-- BEGIN news -->
					<tr>
					<td><div class="news_date">{news.NEWS_TIME}</div></td>
					<td width="100%"><div class="news_title<!-- IF news.NEWS_IS_NEW --> new<!-- ENDIF -->"><a href=./viewtopic.php?t={news.NEWS_TOPIC_ID}>{news.NEWS_TOPIC_NAME}</a></div></td>
					  </tr>
					<!-- END news -->
					</table>
					</td>
				</tr>
			</table>
			<!-- ENDIF / SHOW_LATEST_NEWS -->
		</div>
		
<!--=======================-->
<!-- ENDIF / COMMON_HEADER -->
<!--***********************-->

<!-- page_header.tpl END -->
<!-- module_xx.tpl START -->