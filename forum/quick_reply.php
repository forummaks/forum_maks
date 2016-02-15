<?php

if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

if ($is_auth['auth_reply'] && !(($forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED) && !$is_auth['auth_mod']))
{
	$guest = (!$userdata['session_logged_in']) ? TRUE : FALSE;

	$sl = ' selected="selected" ';
	$ch = ' checked="checked" ';
	$ds = ' disabled="disabled" ';
	$cfg_allow_html = $board_config['allow_html'];
	$cfg_allow_bbcode = $board_config['allow_bbcode'];
	$cfg_allow_smilies = $board_config['allow_smilies'];

	if (!$guest)
	{
		// HTML
		if ($cfg_allow_html)
		{
			$template->assign_vars(array('QR_DIS_HTML_CH' => (!$userdata['user_allowhtml']) ? $ch : ''));
		}
		else
		{
			$template->assign_vars(array(
				'QR_DIS_HTML_CH' => $ch,
				'QR_DIS_HTML_DS' => $ds
			));
		}

		// BBCode
		if ($cfg_allow_bbcode)
		{
			$template->assign_vars(array('QR_DIS_BBCODE_CH' => (!$userdata['user_allowbbcode']) ? $ch : ''));
		}
		else
		{
			$template->assign_vars(array(
				'QR_DIS_BBCODE_CH' => $ch,
				'QR_DIS_BBCODE_DS' => $ds
			));
		}

		// Smilies
		if ($cfg_allow_smilies)
		{
			$template->assign_vars(array('QR_DIS_SMILIES_CH' => (!$userdata['user_allowsmile']) ? $ch : ''));
		}
		else
		{
			$template->assign_vars(array(
				'QR_DIS_SMILIES_CH' => $ch,
				'QR_DIS_SMILIES_DS' => $ds
			));
		}

		// Signature
		if ($userdata['user_sig'] && $board_config['allow_sig'])
		{
			$template->assign_vars(array('QR_SIGNAT_CH' => ($userdata['user_attachsig']) ? $ch : ''));
		}
		else
		{
			$template->assign_vars(array('QR_SIGNAT_DS' => $ds));
		}

		// Notify
		$template->assign_vars(array('QR_NOTIFY_CH' => ($userdata['user_notify'] || $is_watching_topic) ? $ch : ''));
	}
	else
	{
		$template->assign_vars(array(
			'QR_DIS_HTML_CH'    => (!$cfg_allow_html) ? $ch : '',
			'QR_DIS_HTML_DS'    => (!$cfg_allow_html) ? $ds : '',
			'QR_DIS_BBCODE_CH'  => (!$cfg_allow_bbcode) ? $ch : '',
			'QR_DIS_BBCODE_DS'  => (!$cfg_allow_bbcode) ? $ds : '',
			'QR_DIS_SMILIES_CH' => (!$cfg_allow_smilies) ? $ch : '',
			'QR_DIS_SMILIES_DS' => (!$cfg_allow_smilies) ? $ds : '',
			'QR_SIGNAT_DS'      => $ds,
			'QR_NOTIFY_DS'      => $ds
		));
	}

	$template->assign_vars(array(
		'L_QR_ATTACH_SIG' => $lang['QR_Attach_sig'],
		'L_QR_USERNAME'   => $lang['QR_Username'],
		'L_QR_DISABLE'    => $lang['QR_Disbl'],
		'L_QR_NOTIFY'     => $lang['QR_Notify'],
		'L_INS_NAME_TIP'  => $lang['QR_Ins_name'],
		'L_QUICK_REPLY'   => $lang['Quick_Reply'],
		'L_QUOTE_SEL'     => $lang['QuoteSel'],
		'L_QR_OPTIONS'    => $lang['QR_Options'],
		'L_TRANSL_RULES'  => $lang['Transl_Rules'],

		'L_PREVIEW'       => $lang['Preview'],
		'L_SUBMIT'        => $lang['Submit'],
		'L_CANCEL'        => $lang['Cancel'],

		'QUICK_REPLY'     => TRUE,
		'QR_POST_ACT'     => append_sid("posting.$phpEx"),
		'QR_TOPIC_ID'     => $topic_id,
		'QR_GUEST'        => $guest,
		'QR_SID'          => $userdata['session_id']
	));
}

?>