<?php

global $ft_cfg, $page_cfg, $template, $images, $lang;

$width = $height = array();
$template_name = basename(dirname(__FILE__));

$_img  = FT_ROOT . 'images/';
$_main = FT_ROOT . basename(TEMPLATES_DIR) . '/'. $template_name .'/images/';
$_lang = $_main . 'lang_' . basename($ft_cfg['default_lang']) .'/';

$images['icon_quote'] = $_lang . "icon_quote.gif";
$images['icon_edit'] = $_lang . "icon_edit.gif";
$images['icon_search'] = $_lang . "icon_search.gif";
$images['icon_profile'] = $_lang . "icon_profile.gif";
$images['icon_pm'] = $_lang . "icon_pm.gif";
$images['icon_email'] = $_lang . "icon_email.gif";
$images['icon_delpost'] = $_main . "icon_delete.gif";
$images['icon_ip'] = $_lang . "icon_ip.gif";
$images['icon_www'] = $_lang . "icon_www.gif";
$images['icon_icq'] = $_lang . "icon_icq_add.gif";
$images['icon_minipost'] = $_main . "icon_minipost.gif";
$images['icon_gotopost'] = $_main . "icon_minipost.gif";
$images['icon_minipost_new'] = $_main . "icon_minipost_new.gif";
$images['icon_latest_reply'] = $_main . "icon_latest_reply.gif";
$images['icon_newest_reply'] = $_main . "icon_newest_reply.gif";

$images['forum'] = $_main . "folder_big.gif";
$images['forum_new'] = $_main . "folder_new_big.gif";
$images['forum_locked'] = $_main . "folder_locked_big.gif";
//sf
$images['forums'] = $_main . "folders_big.gif";
$images['forums_new'] = $_main . "folders_new_big.gif";
//sf end

$images['folder'] = $_main . "folder.gif";
$images['folder_new'] = $_main . "folder_new.gif";
$images['folder_hot'] = $_main . "folder_hot.gif";
$images['folder_hot_new'] = $_main . "folder_new_hot.gif";
$images['folder_locked'] = $_main . "folder_lock.gif";
$images['folder_locked_new'] = $_main . "folder_lock_new.gif";
$images['folder_sticky'] = $_main . "folder_sticky.gif";
$images['folder_sticky_new'] = $_main . "folder_sticky_new.gif";
$images['folder_announce'] = $_main . "folder_announce.gif";
$images['folder_announce_new'] = $_main . "folder_announce_new.gif";

$images['post_new'] = $_lang . "post.gif";
$images['post_locked'] = $_lang . "reply-locked.gif";
$images['reply_new'] = $_lang . "reply.gif";
$images['reply_locked'] = $_lang . "reply-locked.gif";

$images['pm_inbox'] = $_main . "msg_inbox.gif";
$images['pm_outbox'] = $_main . "msg_outbox.gif";
$images['pm_savebox'] = $_main . "msg_savebox.gif";
$images['pm_sentbox'] = $_main . "msg_sentbox.gif";
$images['pm_readmsg'] = $_main . "folder.gif";
$images['pm_unreadmsg'] = $_main . "folder_new.gif";
$images['pm_replymsg'] = $_main . "reply.gif";
$images['pm_postmsg'] = $_lang . "msg_newpost.gif";
$images['pm_quotemsg'] = $_lang . "icon_quote.gif";
$images['pm_editmsg'] = $_lang . "icon_edit.gif";
$images['pm_new_msg'] = "";
$images['pm_no_new_msg'] = "";

$images['topic_watch'] = "";
$images['topic_un_watch'] = "";
$images['topic_mod_lock'] = $_main . "topic_lock.gif";
$images['topic_mod_unlock'] = $_main . "topic_unlock.gif";
$images['topic_mod_split'] = $_main . "topic_split.gif";
$images['topic_mod_move'] = $_main . "topic_move.gif";
$images['topic_mod_delete'] = $_main . "topic_delete.gif";

$images['voting_graphic'][0] = $_main . "voting_bar.gif";
$images['voting_graphic'][1] = $_main . "voting_bar.gif";
$images['voting_graphic'][2] = $_main . "voting_bar.gif";
$images['voting_graphic'][3] = $_main . "voting_bar.gif";
$images['voting_graphic'][4] = $_main . "voting_bar.gif";

//
// Vote graphic length defines the maximum length of a vote result
// graphic, ie. 100% = this length
//
$ft_cfg['vote_graphic_length'] = 205;
$ft_cfg['privmsg_graphic_length'] = 175;

//bt
$images['folder_dl'] = $_main . "folder_dl.gif";
$images['folder_dl_new'] = $_main . "folder_dl_new.gif";
$images['folder_dl_hot'] = $_main . "folder_dl_hot.gif";
$images['folder_dl_hot_new'] = $_main . "folder_dl_new_hot.gif";
$images['topic_normal'] = $_main . "topic_normal.gif";
$images['topic_dl'] = $_main . "topic_dl.gif";
//bt end