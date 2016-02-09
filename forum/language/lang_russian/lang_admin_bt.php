<?php

$lang['return_config'] = '%sВернуться к настройкам%s';
$lang['config_upd'] = 'Конфигурация успешно изменена';
$lang['set_defaults'] = 'Значения по умолчанию';

//
// Tracker config
//
$lang['tracker_cfg_title'] = 'Трекер';
$lang['forum_cfg_title'] = 'Настройки форумов';
$lang['tracker_settings'] = 'Настройки трекера';

$lang['off'] = 'Отключить трекер';
$lang['off_show_reason'] = 'Продолжать отвечать на запросы клиентов';
$lang['off_show_reason_expl'] = 'отправлять клиенту сообщение о причине остановки трекера';
$lang['off_reason'] = 'Причина отключения';
$lang['off_reason_expl'] = 'этот текст будет отправляться клиенту пока трекер отключен';
$lang['bt_debug'] = 'Режим отладки';
$lang['bt_debug_expl'] = 'включать в сообщения об ошибках дополнительную информацию';
$lang['silent_mode'] = 'Не сообщать об ошибках';
$lang['silent_mode_expl'] = 'в случае ошибок завершать работу без отправки клиенту сообщения об ошибках';
$lang['autoclean'] = 'Автоочистка';
$lang['autoclean_expl'] = 'периодически очищать таблицу peer\'s - не отключайте без особой необходимости!';
$lang['autoclean_interval'] = 'Интервал автоочистки';
$lang['compact_mode'] = 'Компактный режим';
$lang['compact_mode_expl'] = '"Да" - трекер будет работать только в компактном режиме<br />"Нет" - будет определяется клиентом<br />в компактном режиме расход трафика наименьший, но могут возникнуть проблемы из-за несовместимости со старыми клиентами';
$lang['browser_redirect_url'] = 'Browser redirect URL';
$lang['browser_redirect_url_expl'] = "переадресация на этот URL при попытке зайти на трекер Web browser'ом<br />* оставьте пустым для отключения";

$lang['do_gzip_head'] = 'GZip';
$lang['do_gzip'] = 'Использовать сжатие GZip';
$lang['do_gzip_expl'] = 'уроверь компрессии можно настроить в "bt/config.php"';
$lang['force_gzip'] = 'Всегда использовать сжатие';
$lang['force_gzip_expl'] = 'отключает проверку поддержки клиентом GZip';
$lang['client_compat_gzip'] = 'Только если клиент поддерживает';
$lang['client_compat_gzip_expl'] = 'выполнять сжатие через ob_gzhandler()';

$lang['ignor_given_ip_head'] = 'IP';
$lang['ignor_given_ip'] = 'Игнорировать указанный клиентом IP';
$lang['ignor_given_ip_expl'] = 'всегда использовать только $_SERVER["REMOTE_ADDR"]';
$lang['allow_host_ip'] = 'Разрешить использовать вместо IP имя хоста';
$lang['allow_host_ip_expl'] = '';

$lang['ignor_numwant_head'] = 'Numwant';
$lang['ignor_numwant'] = 'Игнорировать numwant';
$lang['ignor_numwant_expl'] = 'игнорировать запрашиваемое клиентом количество источников';
$lang['numwant'] = 'Значение numwant';
$lang['numwant_expl'] = 'количество источников (peers) отправляемых клиенту';
$lang['numwant_max'] = 'Максимальное значение numwant';
$lang['numwant_max_expl'] = 'максимальное количество источников (peers) отправляемых клиенту';

$lang['min_ann_intv_head'] = 'Announce';
$lang['min_ann_intv'] = 'Announce интервал';
$lang['min_ann_intv_expl'] = 'пауза между announcements в секундах';
$lang['expire_factor'] = 'Фактор смерти peer\'ов';
$lang['expire_factor_expl'] = "время жизни peer'а расчитывается как announce интервал умноженный на фактор смерти peer'а<br />должен быть не меньше 1";

$lang['limit_active_tor_head'] = 'Ограничения';
$lang['limit_active_tor'] = 'Ограничить количество одновременных закачек';
$lang['limit_active_tor_expl'] = 'работает только при наличии passkey! для гостей - неактивно';
$lang['limit_seed_count'] = 'Seeding ограничение';
$lang['limit_seed_count_expl'] = 'ограничение на количество одновременных раздач<br />0 - нет ограничений';
$lang['limit_leech_count'] = 'Leeching ограничение';
$lang['limit_leech_count_expl'] = 'ограничение на количество одновременных закачек<br />0 - нет ограничений';
$lang['leech_expire_factor'] = 'Leech expire factor';
$lang['leech_expire_factor_expl'] = 'сколько минут считать начатую закачку активной, независимо от того, остановил ли ее юзер<br />0 - учитывать остановку';
$lang['limit_concurrent_ips'] = 'Ограничить количество подключений с разных IP';
$lang['limit_concurrent_ips_expl'] = 'учитывается отдельно для каждого торрента';
$lang['limit_seed_ips'] = 'Seeding IP ограничение';
$lang['limit_seed_ips_expl'] = "раздаваь можно не более чем с <i>хх</i> IP's<br />(0 - нет ограничений)";
$lang['limit_leech_ips'] = 'Leeching IP ограничение';
$lang['limit_leech_ips_expl'] = "скачивать можно не более чем с <i>хх</i> IP's<br />(0 - нет ограничений)";

$lang['use_auth_key_head'] = 'Авторизация';
$lang['use_auth_key'] = 'Passkey';
$lang['use_auth_key_expl'] = 'включить авторизацию по passkey<br />(aвтодобавление passkey к торент-файлам перед их скачиванием можно включить в настройках форума: TorrentPier - Forum Config)';
$lang['auth_key_name'] = 'Имя ключа passkey';
$lang['auth_key_name_expl'] = 'имя ключа, который будет добавляться в GET запросе к announce url для идентификации юзера';
$lang['allow_guest_dl'] = 'Разрешить "гостям" (неавторизованным юзерам) доступ к трекеру';

$lang['update_users_dl_status_head'] = 'Статистика';
$lang['update_users_dl_status'] = 'Обновлять статус закачки "Качаю"';
$lang['update_users_dl_status_expl'] = 'автоматически изменять статус закачки юзера на "Качаю" если юзер начал закачку';
$lang['update_users_compl_status'] = 'Обновлять статус закачки "Скачал"';
$lang['update_users_compl_status_expl'] = 'автоматически изменять статус закачки юзера на "Скачал" по завершению закачки';
$lang['upd_user_up_down_stat'] = 'Вести учет скачанного/отданного юзером';
$lang['user_statistic_upd_interval'] = 'Интервал обновления статистики скачанного/отданного юзером';
$lang['seed_last_seen_upd_interval'] = "Интервал обновления записи о последнем seeder'e";

//
// Forum config
//
$lang['forum_cfg_expl'] = 'Настройки форума';

$lang['bt_select_forums'] = 'Форумы, в которых:';
$lang['bt_select_forums_expl'] = 'для выделения нескольких форумов, отмечайте их с нажатой клавишей <i>Ctrl</i>';

$lang['allow_reg_tracker'] = 'Разрешена регистрация торентов на трекере';
$lang['allow_dl_topic'] = 'Разрешено создавать Download топики';
$lang['dl_type_default'] = 'Новые топики имеют статус Download по умолчанию';
$lang['show_dl_buttons'] = 'Показывать кнопки для изменения DL-статуса';
$lang['self_moderated'] = 'Автор топика может перенести его в другой форум';

$lang['bt_announce_url_head'] = 'Announce URL';
$lang['bt_announce_url'] = 'Announce url';
$lang['bt_announce_url_expl'] = 'дополнительные разрешенные адреса можно задать в "includes/announce_urls.php"';
$lang['bt_check_announce_url'] = 'Проверять announce url';
$lang['bt_check_announce_url_expl'] = 'разрешить регистрацию на трекере только если announce url входит в список разрешенных';
$lang['bt_replace_ann_url'] = 'Заменять announce url';
$lang['bt_replace_ann_url_expl'] = 'заменять оригинальный announce url в .torrent файлах на ваш';
$lang['bt_del_addit_ann_urls'] = 'Удалять все дополнительные announce urls';
$lang['bt_del_addit_ann_urls_expl'] = 'если торент содержит адреса других трекеров, они будут удалены';
$lang['bt_add_comment'] = 'Добавлять в торент комментарий';
$lang['bt_add_comment_expl'] = 'оставьте пустым для добавления адреса топика к качестве комментария';
$lang['bt_add_publisher'] = 'Добавлять адрес топика как publisher-url и это имя в качестве имени publisher';
$lang['bt_add_publisher_expl'] = 'для отключения - оставьте пустым';

$lang['bt_show_peers_head'] = 'Peers-List';
$lang['bt_show_peers'] = 'Показывать список источников (seeders/leechers)';
$lang['bt_show_peers_expl'] = 'будет выводиться над топиком с торентом';
$lang['bt_show_peers_mode'] = 'По умолчанию показывать источники как:';
$lang['bt_show_peers_mode_count'] = 'Только количество';
$lang['bt_show_peers_mode_names'] = 'Только имена';
$lang['bt_show_peers_mode_full'] = 'Подробно';
$lang['bt_allow_spmode_change'] = 'Разрешить подробный показ источников';
$lang['bt_allow_spmode_change_expl'] = 'если выбрано "нет" - будет доступен только режим по умолчанию';
$lang['bt_show_ip_only_moder'] = '<b>IP</b> могут видеть только модераторы';
$lang['bt_show_port_only_moder'] = '<b>Port</b> могут видеть только модераторы';

$lang['bt_show_dl_list_head'] = 'DL-List';
$lang['bt_show_dl_list'] = 'Выводить DL-List при просмотре топика';
$lang['bt_dl_list_only_1st_page'] = 'Выводить DL-List только на первой странице топика';
$lang['bt_dl_list_only_count'] = 'Выводить только количество';
$lang['bt_dl_list_expire'] = 'Срок действия статуса <i>Буду качать</i> и <i>Качаю</i>';
$lang['bt_dl_list_expire_expl'] = 'по истечении этого срока отметившиеся юзеры будут автоматически удаляться из списка<br />0 - отключить эту опцию';
$lang['bt_show_dl_list_buttons'] = 'Показывать кнопки для изменения DL-статуса';
$lang['bt_show_dl_list_buttons_expl'] = 'глобальная настройка';
$lang['bt_show_dl_but_will'] = $lang['dlWill'];
$lang['bt_show_dl_but_down'] = $lang['dlDown'];
$lang['bt_show_dl_but_compl'] = $lang['dlComplete'];
$lang['bt_show_dl_but_cancel'] = $lang['dlCancel'];

$lang['bt_add_auth_key_head'] = 'Passkey';
$lang['bt_add_auth_key'] = 'Aвтодобавление passkey к торент-файлам перед их скачиванием';
$lang['bt_force_passkey'] = 'Обязательное добавление passkey';
$lang['bt_force_passkey_expl'] = 'перенаправлять гостей на страницу логина при попытке скачать торент-файл';
$lang['bt_gen_passkey_on_reg'] = 'Автоматически генерировать passkey';
$lang['bt_gen_passkey_on_reg_expl'] = 'если passkey не найден, генерировать его при первом скачивании торента';

$lang['bt_tor_browse_only_reg_head'] = 'Torrent browser (трекер)';
$lang['bt_tor_browse_only_reg'] = 'Torrent browser (tracker.php) не доступен для гостей';
$lang['bt_search_bool_mode'] = 'Разрешить полнотекстовый поиск в логическом режиме';
$lang['bt_search_bool_mode_expl'] = 'использовать *, +, - и т.д. при поиске. Работает только если MySQL > 4.0.1';

$lang['bt_show_dl_stat_on_index_head'] = "Разное";
$lang['bt_show_dl_stat_on_index'] = 'Показывать UL/DL статистику юзера на главной странице форума';
$lang['bt_newtopic_auto_reg'] = 'Регистрировать торенты на трекере для новых топиков';
$lang['bt_set_dltype_on_tor_reg'] = 'Изменять статус топка на "Download" во время регистрации торента на трекере';
$lang['bt_set_dltype_on_tor_reg_expl'] = 'не зависит от того, разрешено ли в этом форуме создавать Download-топики (в настройках форумов)';
$lang['bt_unset_dltype_on_tor_unreg'] = 'Изменять статус топка на "Normal" во время удаления торента с трекера';

?>