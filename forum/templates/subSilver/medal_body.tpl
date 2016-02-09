<div align="center"><table width="700px">

<tr><td>

<form method="post" action="{S_MODE_ACTION}">

  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">

	<tr> 

	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span><br /><br />

        <span class="gensmall">Рейтинг считается с учетом бонуса, т.е. по формуле (отдано + бонус)/скачано</span></td>

	</tr>

  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">

	<tr> 

	  <td align="center" valign="top"><b><font color="#000000">Топ-10 по Upload</font></b></td>

	</tr>

  </table>

  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">

	<tr> 

	  <th height="25" class="thCornerL" nowrap="nowrap">Место</th>

	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>

	  <th class="thTop" nowrap="nowrap">{L_JOINED}</th>

	  <th class="thTop" nowrap="nowrap">Отдано</th>

        <th class="thTop" nowrap="nowrap">Бонус</th> 
 
	  <th class="thTop" nowrap="nowrap">Скачано</th>

	  <th class="thTop" nowrap="nowrap">Рейтинг</th>

	</tr>

	<!-- BEGIN memberrow1 -->

	<tr> 

	  <td class="{memberrow1.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow1.ROW_NUMBER}&nbsp;</span></td>

	  <td class="{memberrow1.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow1.U_VIEWPROFILE}" class="gen">{memberrow1.USERNAME}</a></span></td>
	  <td class="{memberrow1.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow1.JOINED}</span></td>

	  <td class="{memberrow1.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow1.UP}</span></b></td>
	
	  <td class="{memberrow1.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow1.BONUS}</span></b></td>
  
	  <td class="{memberrow1.ROW_CLASS}" align="center" valign="middle"><b><span class="leech">{memberrow1.DOWN}</span></b></td>

	  <td class="{memberrow1.ROW_CLASS}" align="center"><span class="gen"><b>{memberrow1.UP_DOWN_RATIO}</b></span></td>

	</tr>

	<!-- END memberrow1 -->

	<tr> 

	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>

	</tr>

  </table>
 
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">

	<tr> 

	  <td align="center" valign="top"><b><font color="#000000">Топ-10 по Download</font></b></td>

	</tr>

  </table>

  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">

	<tr> 

	  <th height="25" class="thCornerL" nowrap="nowrap">Место</th>

	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>

	  <th class="thTop" nowrap="nowrap">{L_JOINED}</th>

        <th class="thTop" nowrap="nowrap">Скачано</th>

	  <th class="thTop" nowrap="nowrap">Отдано</th>

        <th class="thTop" nowrap="nowrap">Бонус</th> 

	  <th class="thTop" nowrap="nowrap">Рейтинг</th>

	</tr>

	<!-- BEGIN memberrow2 -->

	<tr> 

	  <td class="{memberrow2.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow2.ROW_NUMBER}&nbsp;</span></td>

	  <td class="{memberrow2.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow2.U_VIEWPROFILE}" class="gen">{memberrow2.USERNAME}</a></span></td>
	  <td class="{memberrow2.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow2.JOINED}</span></td>

        <td class="{memberrow2.ROW_CLASS}" align="center" valign="middle"><b><span class="leech">{memberrow2.DOWN}</span></b></td> 

	  <td class="{memberrow2.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow2.UP}</span></b></td>

        <td class="{memberrow2.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow2.BONUS}</span></b></td>

	  <td class="{memberrow2.ROW_CLASS}" align="center"><span class="gen"><b>{memberrow2.UP_DOWN_RATIO}</b></span></td>

	</tr>

	<!-- END memberrow2 -->

	<tr> 

	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>

	</tr>

  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">

	<tr> 

	  <td align="center" valign="top"><b><font color="#000000">Топ-10 по Ratio</font></b></td>

	</tr>

  </table>

  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">

	<tr> 

	  <th height="25" class="thCornerL" nowrap="nowrap">Место</th>

	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>

	  <th class="thTop" nowrap="nowrap">{L_JOINED}</th>

        <th class="thTop" nowrap="nowrap">Рейтинг</th>

	  <th class="thTop" nowrap="nowrap">Отдано</th>

        <th class="thTop" nowrap="nowrap">Бонус</th>
 
	  <th class="thTop" nowrap="nowrap">Скачано</th>

	</tr>

	<!-- BEGIN memberrow3 -->

	<tr> 

	  <td class="{memberrow3.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow3.ROW_NUMBER}&nbsp;</span></td>

	  <td class="{memberrow3.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow3.U_VIEWPROFILE}" class="gen">{memberrow3.USERNAME}</a></span></td>
	  <td class="{memberrow3.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow3.JOINED}</span></td>
 
        <td class="{memberrow3.ROW_CLASS}" align="center"><span class="gen"><b>{memberrow3.UP_DOWN_RATIO}</b></span></td>

	  <td class="{memberrow3.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow3.UP}</span></b></td>
	  
        <td class="{memberrow3.ROW_CLASS}" align="center" valign="middle"><b><span class="seed">{memberrow3.BONUS}</span></b></td>

	  <td class="{memberrow3.ROW_CLASS}" align="center" valign="middle"><b><span class="leech">{memberrow3.DOWN}</span></b></td>

	</tr>

	<!-- END memberrow3 -->

	<tr> 

	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>

	</tr>

  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">

	<tr> 

  <td align="center" valign="top"><b><font color="#000000">Топ-10 лучших раздач</font></b></td>

	</tr>

  </table>
 

  <table width="100%" cellpadding="10" cellspacing="1" border="0" class="forumline">

	<tr>

	  <th height="25" class="thCornerL" nowrap>Место</th>

	  <th class="thTop" nowrap>{L_USERNAME}</th>
		  
	  <th class="thTop" nowrap>Тема</th>
	  
	  <th class="thTop" nowrap>Форум</th>
	
	  <th class="thTop" nowrap>Скачано</th>

	  <th class="thTop" nowrap>Зарегистрирован</th>

	</tr>

	<!-- BEGIN torrentsrow -->

	<tr>

	  <td class="{torrentsrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{torrentsrow.ROW_NUMBER}&nbsp;</span></td>

	  <td class="{torrentsrow.ROW_CLASS}" align="center"><span class="gen"><a href="{torrentsrow.U_VIEWPROFILE}" class="gen">{torrentsrow.USERNAME}</a></span></td>

        <td class="{torrentsrow.ROW_CLASS}" align="center" valign="middle"><span class="genmed"><a href="{torrentsrow.TOPIC_HREF}" class="genmed">{torrentsrow.TOPIC_TITLE}</a></span></td>

	  <td class="{torrentsrow.ROW_CLASS}" align="center" valign="middle"><span class="genmed"><a href="{torrentsrow.FORUM_HREF}" class="genmed">{torrentsrow.FORUM_NAME}</a></span></td>

	  <td class="{torrentsrow.ROW_CLASS}" align="center" valign="middle"><b>{torrentsrow.COMPLETE_COUNT}</b></td>

        <td class="{torrentsrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{torrentsrow.REG_TIME}</td>

	</tr>

	<!-- END torrentsrow -->

      <tr> 

	  <td class="catBottom" colspan="7" height="28">&nbsp;</td>

	</tr>

  </table>

</form>

<table width="100%" cellspacing="0" cellpadding="0" border="0">

  <tr> 

	<td></td>

	<td align="right"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span></td>

  </tr>

</table>

<br />

<table width="100%" cellspacing="2" border="0" align="center">

  <tr> 

	<td valign="top" align="right">{JUMPBOX}</td>

  </tr>
  
</table>

</td></tr></table>

</div>