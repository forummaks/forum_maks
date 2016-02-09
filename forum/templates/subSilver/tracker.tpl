<form method="POST" action="{TOR_SEARCH_ACTION}" style="display: inline">

<input type="hidden" name="prev_{SEED_EXIST_NAME}" value="{SEED_EXIST_VAL}" />
<input type="hidden" name="prev_{ONLY_ACTIVE_NAME}" value="{ONLY_ACTIVE_VAL}" />
<input type="hidden" name="prev_{ONLY_MY_NAME}" value="{ONLY_MY_VAL}" />
<input type="hidden" name="prev_{ONLY_NEW_NAME}" value="{ONLY_NEW_VAL}" />
<input type="hidden" name="prev_{SHOW_FORUM_NAME}" value="{SHOW_FORUM_VAL}" />
<input type="hidden" name="prev_{SHOW_AUTHOR_NAME}" value="{SHOW_AUTHOR_VAL}" />
<input type="hidden" name="prev_{SHOW_SPEED_NAME}" value="{SHOW_SPEED_VAL}" />

<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<td valign="bottom"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
		<td valign="bottom" align="right"><span class="nav" title="{TP_VER}">{L_MATCHES} {L_SERACH_MAX}</span></td>
	</tr>
</table>

<div><img src="images/spacer.gif" alt="" width="1" height="4" /></div>

<!-- IF SHOW_SEARCH_OPT -->
<table width="100%" class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th class="catHead" align="center" style="letter-spacing: 1px; height: 26px">
		<span class="genmed" style="color: #FFFFFF"><b>Поиск по раздачам</b></span></th>
	</tr>
	<tr>
		<td class="row1" align="center">
			<table cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td valign="top" class="row1" nowrap="nowrap">
						<fieldset class="fieldset" style="margin: 2px;">
							<legend>{L_SEARCH_IN}</legend>
							<div style="padding: 4px">
								{CAT_FORUM_SELECT}
							</div>
						</fieldset>
					</td>
					<td valign="top" class="row1" style="padding: 2px 8px 2px 8px">
						<div>
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_SORT_BY}</legend>
								<div style="padding: 4px">
									<div class="gen" style="padding-bottom: 2px">
										&nbsp;<select class="post" name="{ORDER_NAME}">{ORDER_OPTIONS}</select>&nbsp;
									</div>
									<div class="genmed"><nobr><label for="sort_asc">&nbsp;<input id="sort_asc" type="radio" name="{SORT_NAME}" value="{SORT_ASC}" {SORT_ASC_CHECKED} /> {L_SORT_ASC}&nbsp;</label></nobr></div>
									<div class="genmed"><nobr><label for="sort_desc">&nbsp;<input id="sort_desc" type="radio" name="{SORT_NAME}" value="{SORT_DESC}" {SORT_DESC_CHECKED} /> {L_SORT_DESC}&nbsp;</label></nobr></div>
								</div>
							</fieldset>
						</div>
						<div style="padding-top: 4px">
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_POSTS_FROM}</legend>
								<div class="gen" style="padding: 4px 4px 5px 4px">
									&nbsp;<select class="post" name="{TIME_NAME}">{TIME_OPTIONS}</select>&nbsp;
								</div>
							</fieldset>
						</div>
					</td>
					<td valign="top" class="row1">
						<div>
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_SHOW_ONLY}</legend>
								<div style="padding: 4px">
									<div class="gen"><nobr>
										<label for="only_active"><input id="only_active" type="checkbox" name="{ONLY_ACTIVE_NAME}" value="1" {ONLY_ACTIVE_CHECKED} />{L_ONLY_ACTIVE}&nbsp;</label>
										<label for="only_my"><input id="only_my" type="checkbox" name="{ONLY_MY_NAME}" value="1" {ONLY_MY_CHECKED} {ONLY_MY_DISABLED} />{L_ONLY_MY}&nbsp;</label>
										<label for="seed_exist"><input id="seed_exist" type="checkbox" name="{SEED_EXIST_NAME}" value="1" {SEED_EXIST_CHECKED} />{L_SEED_EXIST}&nbsp;</label>
									</nobr></div>
									<div class="gen"><nobr><label for="only_new"><input id="only_new" type="checkbox" name="{ONLY_NEW_NAME}" value="1" {ONLY_NEW_CHECKED} {ONLY_NEW_DISABLED} />{L_ONLY_NEW}&nbsp;</label>[<img src="{L_ONLY_NEW_IMG}" width="12" height="9">]&nbsp;</nobr></div>                              
								</div>
							</fieldset>
						</div>
						<div style="padding-top: 5px">
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_DISPLAYING}</legend>
								<table cellspacing="4" cellpadding="0" border="0">
									<tr>
										<td>
											<div class="gen"><nobr><label for="show_forum"><input id="show_forum" type="checkbox" name="{SHOW_FORUM_NAME}" value="1" {SHOW_FORUM_CHECKED} />{L_SHOW_FORUM}&nbsp;</label>
											<label for="show_author"><input id="show_author" type="checkbox" name="{SHOW_AUTHOR_NAME}" value="1" {SHOW_AUTHOR_CHECKED} />{L_SHOW_AUTHOR}&nbsp;</label>
											<label for="show_speed"><input id="show_speed" type="checkbox" name="{SHOW_SPEED_NAME}" value="1" {SHOW_SPEED_CHECKED} />{L_SHOW_SPEED}</label></nobr></div>
										</td>
									</tr>
								</table>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>
			<hr />
			<table cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td valign="top" class="row1" nowrap="nowrap">
						<fieldset class="fieldset" style="margin: 2px;">
							<legend>{L_SEED_NOT_SEEN}</legend>
							<div style="padding: 4px">
								&nbsp;<select class="post" name="{S_NOT_SEEN_NAME}">{S_NOT_SEEN_OPTIONS}</select>&nbsp;
							</div>
						</fieldset>
					</td>
					<td valign="top" class="row1">
						<div>
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_TITLE_MATCH}</legend>
								<div style="padding: 4px">
									&nbsp;<input class="post" type="text" size="40" maxlength="{TITLE_MATCH_MAX}" name="{TITLE_MATCH_NAME}" value="{TITLE_MATCH_VAL}" />&nbsp;
								</div>
							</fieldset>
						</div>
					</td>
					<td valign="top" class="row1">
						<div>
							<fieldset class="fieldset" style="margin: 2px;">
								<legend>{L_AUTHOR}</legend>
								<div style="padding: 4px">
									&nbsp;<input <!-- IF POSTER_ERROR -->style="color: red"<!-- ELSE --> class="post"<!-- ENDIF --> type="text" size="16" maxlength="{POSTER_NAME_MAX}" name="{POSTER_NAME_NAME}" value="{POSTER_NAME_VAL}" />&nbsp;
								</div>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="catBottom" align="center" style="padding: 0px; height: 26px">
			<span class="genmed"><input type="submit" class="liteoption" value="{L_SEARCH}" name="submit" /></span>
		</td>
	</tr>
</table>

<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<!-- ENDIF -->

<style type="text/css">
#tor-tbl u { display: none; }
</style>
<script type="text/javascript" src="misc/js/tablesorter.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#tor-tbl').tablesorter();
});
</script>

<table class="forumline tablesorter" id="tor-tbl" width="100%" cellspacing="1" cellpadding="5" border="0">
<thead>
	<tr>
		<th class="{sorter: false}">&nbsp;</th>
		<th class="{sorter: false}">&nbsp;</th>
		<!-- IF SHOW_FORUM -->
		<th class="{sorter: 'text'} header" title="{L_FORUM}" width="25%"><b class="tbs-text">Форум</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<!-- ENDIF -->
		<th class="{sorter: 'text'} header" title="{L_TOPIC}" width="75%"><b class="tbs-text">Тема</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<!-- IF SHOW_AUTHOR -->
		<th class="{sorter: 'text'} header" title="{L_AUTHOR}"><b class="tbs-text">Автор</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<!-- ENDIF -->
		<th class="{sorter: 'digit'} header" title="{L_SIZE}"><b class="tbs-text">Размер</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<th class="{sorter: 'digit'} header" title="{L_SEEDERS}"><b class="tbs-text">S</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<th class="{sorter: 'digit'} header" title="{L_LEECHERS}"><b class="tbs-text">L</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
        <th class="{sorter: 'digit'} header" title="{L_COMPL}"><b class="tbs-text">C</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
		<!-- IF SHOW_SPEED -->
		<th class="{sorter: false}" title="{L_DL_SPEED}"> SP </th>
		<!-- ENDIF -->
		<th class="{sorter: 'digit'} header" title="{L_POSTED}"><b class="tbs-text">Добавлен</b><span class="tbs-icon">&nbsp;&nbsp;</span></th>
	</tr>
</thead>
<tbody>	
<!-- BEGIN tor -->
	<tr class="tCenter">
		<td class="row1"><!-- IF tor.USER_AUTHOR --><p style="padding-bottom: 3px"><b>&reg;</b>&nbsp;</p><!-- ELSE -->{tor.POST_IMG}<!-- ENDIF --></td>
		<td class="row1" title="{tor.TCS_TITLE}"><b>{tor.TCS_ID}</b></td>
		<!-- IF SHOW_FORUM -->
		<td class="row1"><a class="gen" href="{tor.FORUM_HREF}">{tor.FORUM_NAME}</a></td>
		<!-- ENDIF -->
		<td class="row4 med" title="{tor.TITLE_AUTHOR}" style="text-align: left"><a class="{tor.DL_CLASS}" href="{tor.TOPIC_HREF}"><b>{tor.TOPIC_TITLE}</b></a></td>
		<!-- IF SHOW_AUTHOR -->
		<td class="row1"><a class="genmed" href="{tor.POSTER_HREF}">{tor.USERNAME}</a></td>
		<!-- ENDIF -->
		<td class="row4 gensmall nowrap" style="cursor: pointer" onClick="window.location.href='{tor.DL_TOR_HREF}'"><u>{tor.TOR_SIZE_RAW}</u><a class="gensmall" href="{tor.DL_TOR_HREF}"><b>{tor.TOR_SIZE}</b></a></td>
		<td class="row4 seedmed" title="{tor.SEEDERS}"><b>{tor.SEEDS}</b></td>
		<td class="row4 leechmed" title="{L_LEECHERS}"><b>{tor.LEECHS}</b></td>
        <td class="row4 gensmall" title="{L_COMPL}">{tor.COMPLETED}</td>
		<!-- IF SHOW_SPEED -->
		<td class="row4 nowrap">
		<p class="seedmed">{tor.UL_SPEED}</p>
		<p class="leechmed">{tor.DL_SPEED}</p>
		</td>
		<!-- ENDIF -->
		<td class="row4 gensmall nowrap" style="padding: 1px 3px 2px;" title="{L_POSTED}"><u>{tor.ADDED_RAW}</u>{tor.ADDED_TIME}<br />{tor.ADDED_DATE}</td>
	</tr>
<!-- END tor -->
<!-- BEGIN tor_not_found -->
<tr>
	 <td class="row1" align="center" valign="middle" colspan="{TOR_COLSPAN}" height="32"><span class="gen">{tor_not_found.L_NO_MATCH}</span></td>
</tr>
<!-- END tor_not_found -->
</tbody>
<tfoot>
<tr>
	 <td class="catBottom" align="center" valign="middle" colspan="{TOR_COLSPAN}" height="28">&nbsp;</td>
</tr>
</tfoot>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td valign="top" style="padding-left: 2px"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

</form>