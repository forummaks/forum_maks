<script> 
	function add_field(obj) 
	{ 
	        document.getElementById('choose_status').style.display = (obj.value==5)?'inline':'none';
	}
</script>
<!-- BEGIN attach -->
	<br /><br />

	<!-- BEGIN denyrow -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" class="attachheader" align="center"><b><span class="gen">{postrow.attach.denyrow.L_DENIED}</span></b></td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END denyrow -->
	<!-- BEGIN cat_stream -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" colspan="2" class="attachheader" align="center"><b><span class="gen">{postrow.attach.cat_stream.DOWNLOAD_NAME}</span></b></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_DESCRIPTION}:</span></td>
		<td width="75%" class="attachrow">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			<tr>
				<td class="attachrow"><span class="genmed">{postrow.attach.cat_stream.COMMENT}</span></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILESIZE}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_stream.FILESIZE} {postrow.attach.cat_stream.SIZE_VAR}</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_stream.L_DOWNLOADED_VIEWED}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_stream.L_DOWNLOAD_COUNT}</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br />
		<object id="wmp" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">
		<param name="FileName" value="{postrow.attach.cat_stream.U_DOWNLOAD_LINK}">
        <param name="ShowControls" value="1">
		<param name="ShowDisplay" value="0">
		<param name="ShowStatusBar" value="1">
		<param name="AutoSize" value="1">
		<param name="AutoStart" value="0">
		<param name="Visible" value="1">
		<param name="AnimationStart" value="0">
		<param name="Loop" value="0">
		<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp" src="{postrow.attach.cat_stream.U_DOWNLOAD_LINK}" name=MediaPlayer2 showcontrols=1 showdisplay=0 showstatusbar=1 autosize=1 autostart=0 visible=1 animationatstart=0 loop=0></embed>
		</object> <br /><br />
		</td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END cat_stream -->
	<!-- BEGIN cat_swf -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" colspan="2" class="attachheader" align="center"><b><span class="gen">{postrow.attach.cat_swf.DOWNLOAD_NAME}</span></b></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_DESCRIPTION}:</span></td>
		<td width="75%" class="attachrow">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			<tr>
				<td class="attachrow"><span class="genmed">{postrow.attach.cat_swf.COMMENT}</span></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILESIZE}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_swf.FILESIZE} {postrow.attach.cat_swf.SIZE_VAR}</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_swf.L_DOWNLOADED_VIEWED}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_swf.L_DOWNLOAD_COUNT}</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br />
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="{postrow.attach.cat_swf.WIDTH}" height="{postrow.attach.cat_swf.HEIGHT}">
		<param name=movie value="{postrow.attach.cat_swf.U_DOWNLOAD_LINK}">
		<param name=loop value=1>
		<param name=quality value=high>
		<param name=scale value=noborder>
		<param name=wmode value=transparent>
		<param name=bgcolor value=#000000>
		<embed src="{postrow.attach.cat_swf.U_DOWNLOAD_LINK}" loop=1 quality=high scale=noborder wmode=transparent bgcolor=#000000  width="{postrow.attach.cat_swf.WIDTH}" height="{postrow.attach.cat_swf.HEIGHT}" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
		</object><br /><br />
		</td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END cat_swf -->
	<!-- BEGIN cat_images -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" colspan="2" class="attachheader" align="center"><b><span class="gen">{postrow.attach.cat_images.DOWNLOAD_NAME}</span></b></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_DESCRIPTION}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_images.COMMENT}</span></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILESIZE}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_images.FILESIZE} {postrow.attach.cat_images.SIZE_VAR}</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_images.L_DOWNLOADED_VIEWED}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_images.L_DOWNLOAD_COUNT}</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br /><img src="{postrow.attach.cat_images.IMG_SRC}" alt="{postrow.attach.cat_images.DOWNLOAD_NAME}" border="0" /><br /><br /></td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END cat_images -->
	<!-- BEGIN cat_thumb_images -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" colspan="2" class="attachheader" align="center"><b><span class="gen">{postrow.attach.cat_thumb_images.DOWNLOAD_NAME}</span></b></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_DESCRIPTION}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_thumb_images.COMMENT}</span></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILESIZE}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_thumb_images.FILESIZE} {postrow.attach.cat_thumb_images.SIZE_VAR}</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_thumb_images.L_DOWNLOADED_VIEWED}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.cat_thumb_images.L_DOWNLOAD_COUNT}</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br /><a href="{postrow.attach.cat_thumb_images.IMG_SRC}" target="_blank"><img src="{postrow.attach.cat_thumb_images.IMG_THUMB_SRC}" alt="{postrow.attach.cat_thumb_images.DOWNLOAD_NAME}" border="0" /></a><br /><br /></td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END cat_thumb_images -->
	<!-- BEGIN attachrow -->
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<table width="95%" border="1" cellpadding="2" cellspacing="0" class="attachtable" align="center">
	<tr>
		<td width="100%" colspan="3" class="attachheader" align="center"><b><span class="gen">{postrow.attach.attachrow.DOWNLOAD_NAME}</span></b></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_DESCRIPTION}:</span></td>
		<td width="70%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.attachrow.COMMENT}</span></td>
		<td rowspan="4" align="center" width="15%" class="attachrow" style="padding: 5px">{postrow.attach.attachrow.S_UPLOAD_IMAGE}<br /><a href="{postrow.attach.attachrow.U_DOWNLOAD_LINK}" {postrow.attach.attachrow.TARGET_BLANK} class="genmed"><b>{L_DOWNLOAD}</b></a></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILENAME}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.attachrow.DOWNLOAD_NAME}</span></td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{L_FILESIZE}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.attachrow.FILESIZE} {postrow.attach.attachrow.SIZE_VAR}</td>
	</tr>
	<tr>
		<td width="15%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.attachrow.L_DOWNLOADED_VIEWED}:</span></td>
		<td width="75%" class="attachrow"><span class="genmed">&nbsp;{postrow.attach.attachrow.L_DOWNLOAD_COUNT}</span></td>
	</tr>
	</table>
	<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
	<!-- END attachrow -->

<!-- //bt -->
<!-- BEGIN tor_not_reged -->
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<table width="95%" border="0" cellpadding="2" cellspacing="1" class="btTbl" align="center">
	<tr class="row3">
		<td class="gen" colspan="3" align="center" style="padding: 3px"><b>&nbsp;{postrow.attach.tor_not_reged.DOWNLOAD_NAME}&nbsp;</b></td>
	</tr>
	<tr class="row1">
		<td width="15%" class="genmed">&nbsp;{L_TRACKER}:&nbsp;</td>
		<td width="70%" class="genmed">&nbsp;{postrow.attach.tor_not_reged.TRACKER_LINK}</td>
		<td width="15%" class="genmed" rowspan="3" align="center" style="padding: 5px">{postrow.attach.tor_not_reged.S_UPLOAD_IMAGE}<br /><a href="{postrow.attach.tor_not_reged.U_DOWNLOAD_LINK}" class="genmed"><b>{L_DOWNLOAD}</b></a><br /><span class="gensmall">{postrow.attach.tor_not_reged.FILESIZE}</span></td>
	</tr>
	<tr class="row1">
		<td class="genmed">&nbsp;{L_POSTED}:&nbsp;</td>
		<td class="genmed">&nbsp;{postrow.attach.tor_not_reged.POSTED_TIME}</td>
	</tr>
	<tr class="row1">
		<td class="genmed">&nbsp;{postrow.attach.tor_not_reged.L_DOWNLOADED_VIEWED}:&nbsp;</td>
		<td class="genmed">&nbsp;{postrow.attach.tor_not_reged.L_DOWNLOAD_COUNT}</td>
	</tr>
	<!-- BEGIN comment -->
	<tr class="row1">
		<td class="gen" valign="middle" align="center" colspan="3">{postrow.attach.tor_not_reged.comment.COMMENT}</td>
	</tr>
	<!-- END comment -->
	<tr class="row3">
		<td class="genmed" colspan="3">&nbsp;</td>
	</tr>
</table>
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<!-- END tor_not_reged -->
<!-- BEGIN tor_reged -->
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<table width="95%" border="0" cellpadding="2" cellspacing="1" class="btTbl" align="center">
	<tr class="row3">
		<td colspan="3" class="gen" align="center" style="padding: 3px"><b>&nbsp;{postrow.attach.tor_reged.DOWNLOAD_NAME}&nbsp;</b></td>
	</tr>
	<tr class="row1">
		<td width="15%" class="genmed">&nbsp;{L_TRACKER}:&nbsp;</td>
		<td width="70%" class="genmed">&nbsp;{postrow.attach.tor_reged.TRACKER_LINK}</td>
            <td width="15%" class="gensmall" rowspan="5" align="center" style="padding: 5px">{postrow.attach.tor_reged.S_UPLOAD_IMAGE}<br />{postrow.attach.tor_reged.U_DOWNLOAD_URL}<br />{postrow.attach.tor_reged.FILESIZE}<br /><hr><input type="button" style="border: solid 1px;background-color:#FAFAFA;" value="Список файлов" onclick="$('#submit-buttons').slideToggle();"></td>
	</tr>
      <tr class="row1">
		<td class="genmed">&nbsp;Статус:</td>
		<td class="genmed">&nbsp;{postrow.attach.tor_reged.TOPIC_CHECK_STATUS} 
<!-- BEGIN mod -->
			<form method="POST" action="{postrow.attach.tor_reged.mod.ACT}">
			<select name="topic_check_status" onchange='add_field(this)'>
			<option value="-1">>>Сменить статус<<
			<option value="1">Проверяется
			<option value="2">Oформлено
			<!-- IF postrow.attach.tor_reged.mod.IN_NATIVE_F --><option value="3">Недооформлено<!-- ENDIF -->
			<option value="4">Неоформлено
			<option value="5">Повтор</select>
			<input id="choose_status" type="text" name="duble_tid" value="0" size="3" class="post" style="display:none;" />
			<input type="hidden" name="id" value="{postrow.attach.tor_reged.mod.ATTACH_ID}" /><input type="hidden" name="sid" value="{postrow.attach.tor_reged.mod.SID}" />
			<input type="submit" value="Да">
			</form>
<!-- END mod --> 
<!-- BEGIN auther -->
			<form method="POST" action="{postrow.attach.tor_reged.auther.ACT}">
			<input type="hidden" name="id" value="{postrow.attach.tor_reged.auther.ATTACH_ID}" />
			<input type="hidden" name="sid" value="{postrow.attach.tor_reged.auther.SID}" />
			<input type="checkbox" name="i_edited" value="1" />
			<input type="submit" value="Я исправил">
			</form>

<!-- END auther -->
		</td>
	</tr> 
	<tr class="row1">
		<td class="genmed">&nbsp;{L_REGED}:&nbsp;</td>
		<td class="genmed">&nbsp;{postrow.attach.tor_reged.REGED_TIME}</td>
	</tr>
	<tr class="row1">
		<td class="genmed">&nbsp;{L_COMPLETED}:&nbsp;</td>
		<td class="genmed"><span title="{postrow.attach.tor_reged.L_DOWNLOADED_VIEWED}: {postrow.attach.tor_reged.L_DOWNLOAD_COUNT}">&nbsp;{postrow.attach.tor_reged.COMPLETED}</span></td>
	</tr>
	<tr class="row1">
		<td class="genmed">&nbsp;{L_TORRENT_SIZE}:&nbsp;</td>
		<td class="genmed"><span title="{L_PIECE_LENGTH}: {postrow.attach.tor_reged.PIECE_LENGTH}">&nbsp;{postrow.attach.tor_reged.TORRENT_SIZE}&nbsp;</span></td>
	</tr>
	<!-- BEGIN comment -->
	<tr class="row1">
		<td class="genmed" align="center" colspan="3">&nbsp;{postrow.attach.tor_reged.comment.COMMENT}</td>
	</tr>
	<!-- END comment -->
	<tr class="row3">
		<td class="genmed" valign="middle" align="center" colspan="3" style="padding: 2px">&nbsp;
	<!-- BEGIN controls -->
			<form method="POST" action="{postrow.attach.tor_reged.controls.ACTION}" style="display: inline">
					<input type="hidden" name="id" value="{postrow.attach.tor_reged.controls.ATTACH_ID}" />
					<input type="hidden" name="sid" value="{postrow.attach.tor_reged.controls.SID}" />
					<input type="submit" name="del_torrent" value="{L_DEL_TORRENT}" class="liteoption" style="width: 120px" />&nbsp;&nbsp;
					<!-- IF AUTH_MOVE -->
					<input type="submit" name="del_torrent_move_topic" value="{L_DEL_MOVE_TORRENT}" class="liteoption" style="width: 190px" />&nbsp;
					<!-- ENDIF -->
					<label for="confirm"><input id="confirm" type="checkbox" name="confirm" value="1" />&nbsp;{L_YES}</label>
			</form>
	<!-- END controls -->
		&nbsp;</td>
	</tr>
</table>
<div><img src="images/spacer.gif" alt="" width="1" height="6" /></div>
<!-- END tor_reged -->
<!-- //bt end -->

<!-- END attach -->

<!-- Таблица отображения списка файлов -->
   <style type="text/css">
   #submit-buttons { display: none; }
   #infobox-wrap { width: 95%; }
   #infobox-body { background: #FFFFFF; color: #000000; padding: 1em;
                   height: 300px; overflow: auto; border: 1px inset #000000;
                 }
   </style>
   <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
          <td colspan="3">
          <div id="submit-buttons">
    {INSIDE}
       </div>
       </td>
    </tr>
    </table>
   </div>
<!-- Таблица отображения списка файлов -->
