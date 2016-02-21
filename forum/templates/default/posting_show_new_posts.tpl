<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td colspan="2" height="28" class="catHead" align="center"><span class="cattitle">{L_NEW_POSTS_PREVIEW}</span></td>
	</tr>
	<tr>
		<th class="thLeft" height="26">{L_NEW_POSTS_AUTHOR}</th>
		<th class="thRight">{L_NEW_POSTS_MESSAGE}</th>
	</tr>
	<!-- BEGIN new_posts -->
	<tr>
		<td align="left" valign="top" class="{new_posts.ROW_CLASS}"><span class="genmed" title="{L_INS_NAME_TIP}" onmouseout="bbcode && bbcode.refreshSelection(false)" onmouseover="bbcode && bbcode.refreshSelection(true)" onclick="bbcode && bbcode.onclickPoster('{new_posts.POSTER_NAME}'); return false"><a href="#" class="genmed" onclick="return false"><b>{new_posts.POSTER_NAME}</b></a></span><br /><img src="images/spacer.gif" width="122" height="4" border="0" alt="" /></td>
		<td width="100%" class="{new_posts.ROW_CLASS}" height="28" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="100%"><img src="{NEW_POST_MINI_POST_IMG}" width="12" height="9" border="0" /> <span class="postdetails">{L_NEW_POSTS_POSTED}: {new_posts.POST_DATE}</span></td>
				</tr>
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td colspan="2"><span class="postbody">{new_posts.MESSAGE}</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="1" class="spaceRow"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END new_posts -->
</table>

<br clear="all" />