<?php

$lang['return_config'] = '%s��������� � ����������%s';
$lang['config_upd'] = '������������ ������� ��������';
$lang['set_defaults'] = '�������� �� ���������';

//
// Tracker config
//
$lang['tracker_cfg_title'] = '������';
$lang['forum_cfg_title'] = '��������� �������';
$lang['tracker_settings'] = '��������� �������';

$lang['off'] = '��������� ������';
$lang['off_show_reason'] = '���������� �������� �� ������� ��������';
$lang['off_show_reason_expl'] = '���������� ������� ��������� � ������� ��������� �������';
$lang['off_reason'] = '������� ����������';
$lang['off_reason_expl'] = '���� ����� ����� ������������ ������� ���� ������ ��������';
$lang['bt_debug'] = '����� �������';
$lang['bt_debug_expl'] = '�������� � ��������� �� ������� �������������� ����������';
$lang['silent_mode'] = '�� �������� �� �������';
$lang['silent_mode_expl'] = '� ������ ������ ��������� ������ ��� �������� ������� ��������� �� �������';
$lang['autoclean'] = '�����������';
$lang['autoclean_expl'] = '������������ ������� ������� peer\'s - �� ���������� ��� ������ �������������!';
$lang['autoclean_interval'] = '�������� �����������';
$lang['compact_mode'] = '���������� �����';
$lang['compact_mode_expl'] = '"��" - ������ ����� �������� ������ � ���������� ������<br />"���" - ����� ������������ ��������<br />� ���������� ������ ������ ������� ����������, �� ����� ���������� �������� ��-�� ��������������� �� ������� ���������';
$lang['browser_redirect_url'] = 'Browser redirect URL';
$lang['browser_redirect_url_expl'] = "������������� �� ���� URL ��� ������� ����� �� ������ Web browser'��<br />* �������� ������ ��� ����������";

$lang['do_gzip_head'] = 'GZip';
$lang['do_gzip'] = '������������ ������ GZip';
$lang['do_gzip_expl'] = '������� ���������� ����� ��������� � "bt/config.php"';
$lang['force_gzip'] = '������ ������������ ������';
$lang['force_gzip_expl'] = '��������� �������� ��������� �������� GZip';
$lang['client_compat_gzip'] = '������ ���� ������ ������������';
$lang['client_compat_gzip_expl'] = '��������� ������ ����� ob_gzhandler()';

$lang['ignor_given_ip_head'] = 'IP';
$lang['ignor_given_ip'] = '������������ ��������� �������� IP';
$lang['ignor_given_ip_expl'] = '������ ������������ ������ $_SERVER["REMOTE_ADDR"]';
$lang['allow_host_ip'] = '��������� ������������ ������ IP ��� �����';
$lang['allow_host_ip_expl'] = '';

$lang['ignor_numwant_head'] = 'Numwant';
$lang['ignor_numwant'] = '������������ numwant';
$lang['ignor_numwant_expl'] = '������������ ������������� �������� ���������� ����������';
$lang['numwant'] = '�������� numwant';
$lang['numwant_expl'] = '���������� ���������� (peers) ������������ �������';
$lang['numwant_max'] = '������������ �������� numwant';
$lang['numwant_max_expl'] = '������������ ���������� ���������� (peers) ������������ �������';

$lang['min_ann_intv_head'] = 'Announce';
$lang['min_ann_intv'] = 'Announce ��������';
$lang['min_ann_intv_expl'] = '����� ����� announcements � ��������';
$lang['expire_factor'] = '������ ������ peer\'��';
$lang['expire_factor_expl'] = "����� ����� peer'� ������������� ��� announce �������� ���������� �� ������ ������ peer'�<br />������ ���� �� ������ 1";

$lang['limit_active_tor_head'] = '�����������';
$lang['limit_active_tor'] = '���������� ���������� ������������� �������';
$lang['limit_active_tor_expl'] = '�������� ������ ��� ������� passkey! ��� ������ - ���������';
$lang['limit_seed_count'] = 'Seeding �����������';
$lang['limit_seed_count_expl'] = '����������� �� ���������� ������������� ������<br />0 - ��� �����������';
$lang['limit_leech_count'] = 'Leeching �����������';
$lang['limit_leech_count_expl'] = '����������� �� ���������� ������������� �������<br />0 - ��� �����������';
$lang['leech_expire_factor'] = 'Leech expire factor';
$lang['leech_expire_factor_expl'] = '������� ����� ������� ������� ������� ��������, ���������� �� ����, ��������� �� �� ����<br />0 - ��������� ���������';
$lang['limit_concurrent_ips'] = '���������� ���������� ����������� � ������ IP';
$lang['limit_concurrent_ips_expl'] = '����������� �������� ��� ������� ��������';
$lang['limit_seed_ips'] = 'Seeding IP �����������';
$lang['limit_seed_ips_expl'] = "�������� ����� �� ����� ��� � <i>��</i> IP's<br />(0 - ��� �����������)";
$lang['limit_leech_ips'] = 'Leeching IP �����������';
$lang['limit_leech_ips_expl'] = "��������� ����� �� ����� ��� � <i>��</i> IP's<br />(0 - ��� �����������)";

$lang['use_auth_key_head'] = '�����������';
$lang['use_auth_key'] = 'Passkey';
$lang['use_auth_key_expl'] = '�������� ����������� �� passkey<br />(a������������� passkey � ������-������ ����� �� ����������� ����� �������� � ���������� ������: TorrentPier - Forum Config)';
$lang['auth_key_name'] = '��� ����� passkey';
$lang['auth_key_name_expl'] = '��� �����, ������� ����� ����������� � GET ������� � announce url ��� ������������� �����';
$lang['allow_guest_dl'] = '��������� "������" (���������������� ������) ������ � �������';

$lang['update_users_dl_status_head'] = '����������';
$lang['update_users_dl_status'] = '��������� ������ ������� "�����"';
$lang['update_users_dl_status_expl'] = '������������� �������� ������ ������� ����� �� "�����" ���� ���� ����� �������';
$lang['update_users_compl_status'] = '��������� ������ ������� "������"';
$lang['update_users_compl_status_expl'] = '������������� �������� ������ ������� ����� �� "������" �� ���������� �������';
$lang['upd_user_up_down_stat'] = '����� ���� ����������/��������� ������';
$lang['user_statistic_upd_interval'] = '�������� ���������� ���������� ����������/��������� ������';
$lang['seed_last_seen_upd_interval'] = "�������� ���������� ������ � ��������� seeder'e";

//
// Forum config
//
$lang['forum_cfg_expl'] = '��������� ������';

$lang['bt_select_forums'] = '������, � �������:';
$lang['bt_select_forums_expl'] = '��� ��������� ���������� �������, ��������� �� � ������� �������� <i>Ctrl</i>';

$lang['allow_reg_tracker'] = '��������� ����������� �������� �� �������';
$lang['allow_dl_topic'] = '��������� ��������� Download ������';
$lang['dl_type_default'] = '����� ������ ����� ������ Download �� ���������';
$lang['show_dl_buttons'] = '���������� ������ ��� ��������� DL-�������';
$lang['self_moderated'] = '����� ������ ����� ��������� ��� � ������ �����';

$lang['bt_announce_url_head'] = 'Announce URL';
$lang['bt_announce_url'] = 'Announce url';
$lang['bt_announce_url_expl'] = '�������������� ����������� ������ ����� ������ � "includes/announce_urls.php"';
$lang['bt_check_announce_url'] = '��������� announce url';
$lang['bt_check_announce_url_expl'] = '��������� ����������� �� ������� ������ ���� announce url ������ � ������ �����������';
$lang['bt_replace_ann_url'] = '�������� announce url';
$lang['bt_replace_ann_url_expl'] = '�������� ������������ announce url � .torrent ������ �� ���';
$lang['bt_del_addit_ann_urls'] = '������� ��� �������������� announce urls';
$lang['bt_del_addit_ann_urls_expl'] = '���� ������ �������� ������ ������ ��������, ��� ����� �������';
$lang['bt_add_comment'] = '��������� � ������ �����������';
$lang['bt_add_comment_expl'] = '�������� ������ ��� ���������� ������ ������ � �������� �����������';
$lang['bt_add_publisher'] = '��������� ����� ������ ��� publisher-url � ��� ��� � �������� ����� publisher';
$lang['bt_add_publisher_expl'] = '��� ���������� - �������� ������';

$lang['bt_show_peers_head'] = 'Peers-List';
$lang['bt_show_peers'] = '���������� ������ ���������� (seeders/leechers)';
$lang['bt_show_peers_expl'] = '����� ���������� ��� ������� � ��������';
$lang['bt_show_peers_mode'] = '�� ��������� ���������� ��������� ���:';
$lang['bt_show_peers_mode_count'] = '������ ����������';
$lang['bt_show_peers_mode_names'] = '������ �����';
$lang['bt_show_peers_mode_full'] = '��������';
$lang['bt_allow_spmode_change'] = '��������� ��������� ����� ����������';
$lang['bt_allow_spmode_change_expl'] = '���� ������� "���" - ����� �������� ������ ����� �� ���������';
$lang['bt_show_ip_only_moder'] = '<b>IP</b> ����� ������ ������ ����������';
$lang['bt_show_port_only_moder'] = '<b>Port</b> ����� ������ ������ ����������';

$lang['bt_show_dl_list_head'] = 'DL-List';
$lang['bt_show_dl_list'] = '�������� DL-List ��� ��������� ������';
$lang['bt_dl_list_only_1st_page'] = '�������� DL-List ������ �� ������ �������� ������';
$lang['bt_dl_list_only_count'] = '�������� ������ ����������';
$lang['bt_dl_list_expire'] = '���� �������� ������� <i>���� ������</i> � <i>�����</i>';
$lang['bt_dl_list_expire_expl'] = '�� ��������� ����� ����� ������������ ����� ����� ������������� ��������� �� ������<br />0 - ��������� ��� �����';
$lang['bt_show_dl_list_buttons'] = '���������� ������ ��� ��������� DL-�������';
$lang['bt_show_dl_list_buttons_expl'] = '���������� ���������';
$lang['bt_show_dl_but_will'] = $lang['dlWill'];
$lang['bt_show_dl_but_down'] = $lang['dlDown'];
$lang['bt_show_dl_but_compl'] = $lang['dlComplete'];
$lang['bt_show_dl_but_cancel'] = $lang['dlCancel'];

$lang['bt_add_auth_key_head'] = 'Passkey';
$lang['bt_add_auth_key'] = 'A������������� passkey � ������-������ ����� �� �����������';
$lang['bt_force_passkey'] = '������������ ���������� passkey';
$lang['bt_force_passkey_expl'] = '�������������� ������ �� �������� ������ ��� ������� ������� ������-����';
$lang['bt_gen_passkey_on_reg'] = '������������� ������������ passkey';
$lang['bt_gen_passkey_on_reg_expl'] = '���� passkey �� ������, ������������ ��� ��� ������ ���������� �������';

$lang['bt_tor_browse_only_reg_head'] = 'Torrent browser (������)';
$lang['bt_tor_browse_only_reg'] = 'Torrent browser (tracker.php) �� �������� ��� ������';
$lang['bt_search_bool_mode'] = '��������� �������������� ����� � ���������� ������';
$lang['bt_search_bool_mode_expl'] = '������������ *, +, - � �.�. ��� ������. �������� ������ ���� MySQL > 4.0.1';

$lang['bt_show_dl_stat_on_index_head'] = "������";
$lang['bt_show_dl_stat_on_index'] = '���������� UL/DL ���������� ����� �� ������� �������� ������';
$lang['bt_newtopic_auto_reg'] = '�������������� ������� �� ������� ��� ����� �������';
$lang['bt_set_dltype_on_tor_reg'] = '�������� ������ ����� �� "Download" �� ����� ����������� ������� �� �������';
$lang['bt_set_dltype_on_tor_reg_expl'] = '�� ������� �� ����, ��������� �� � ���� ������ ��������� Download-������ (� ���������� �������)';
$lang['bt_unset_dltype_on_tor_unreg'] = '�������� ������ ����� �� "Normal" �� ����� �������� ������� � �������';

?>