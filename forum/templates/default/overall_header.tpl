<!DOCTYPE>
<html dir="{S_CONTENT_DIRECTION}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
    <meta http-equiv="Content-Style-Type" content="text/css">
    {META}
    <title>{PAGE_TITLE} :: {SITENAME}</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{STYLESHEET}" type="text/css">
	<script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/jquery.pack.js"></script>
    <script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/main.js"></script>
    <!-- IF INCL_BBCODE_JS -->
    <script language="JavaScript" type="text/javascript" src="{FT_ROOT}misc/js/bbcode.js"></script>
    <!-- ENDIF -->
    <script type="text/javascript">
        $(function () {
            $('#cse-search-btn, #cse-search-btn-top').click(function () {
                var text_match_input_id = $(this).attr('href');
                var text_match = $('#' + text_match_input_id).val();
                if (text_match == '') {
                    $('#' + text_match_input_id).addClass('hl-err-input').focus();
                    return false;
                }
                $('#cse-text-match').val(text_match);
                $('#cse-submit-btn').click();
                return false;
            });

            $('#quick-search').submit(function () {
                var action = $('#search-action').val();
                var txt = $('#search-text').val();
                if (txt == 'поиск...' || txt == '') {
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
</head>
<body>

<div id="body_container">

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
<div style="position: absolute; top: 3px; right: 12px;">
    <form id="quick-search" action="" method="post">
        <input id="search-text" type="text" name="nm"
        style="width: 150px; color:#666666; font-style:italic;" id="sk" size="50" value="поиск..."
        onfocus="if ((this.style.color=='rgb(102, 102, 102)') || (this.style.color=='#666666')) {this.value=''; this.style.color='#000000'; this.style.fontStyle='normal'}"
        onblur="if (this.value=='' && ((this.style.color=='rgb(0, 0, 0)') || (this.style.color=='#000000'))) {this.style.color='#666666'; this.style.fontStyle='italic'; this.value='поиск...';};"/>
    <select id="search-action">
        <option value="tracker.php" selected="selected"> по трекеру</option>
        <option value="search.php"> по форуму</option>
    </select>
    <input type="submit" class="mainoption" value="&raquo;" style="width: 30px;"/>
    </form>
</div>

<!--logout-->
<div class="topmenu">
    <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <!-- //bt -->
            <!-- BEGIN user_ratio -->
            <span class="mainmenu">Отдано: <span class="seedsmall"><b>{user_ratio.U_UP_TOTAL}</b></span> &#0183; Бонус: 
			<span class="seedsmall"><b>{user_ratio.U_BONUS_TOTAL}</b></span> &#0183; Скачано: 
			<span class="leechsmall"><b>{user_ratio.U_DOWN_TOTAL}</b></span> &#0183; Рейтинг: 
			<span class="small"><b>{user_ratio.U_RATIO}</b></span></span>
			<!-- END user_ratio -->
            <!-- //bt end -->
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
            <input class="post" type="text" name="username" size="10"/>
            {L_PASSWORD}:
            <input class="post" type="password" name="password" size="10" maxlength="32"/>
			<input class="text" type="checkbox" name="autologin"/> Запомнить&nbsp;
			<input type="submit" class="mainoption" name="login" value="{L_LOGIN}"/> &nbsp;&#0183;&nbsp;
			<a href="{U_SEND_PASSWORD}" style="text-decoration:none">{L_FORGOTTEN_PASSWORD}</a>
		</td>
		</form>
        <!-- END switch_user_logged_out -->
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