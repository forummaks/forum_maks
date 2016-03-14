<?php

$lang['RETURN_CONFIG'] = '%sВернуться к настройкам%s';
$lang['CONFIG_UPD'] = 'Конфигурация успешно изменена';
$lang['SET_DEFAULTS'] = 'Значения по умолчанию';

////
// Tracker config//
////
$lang['TRACKER_CFG_TITLE'] = 'Трекер';
$lang['FORUM_CFG_TITLE'] = 'Настройки форумов';
$lang['TRACKER_SETTINGS'] = 'Настройки трекера';

$lang['OFF'] = 'Отключить трекер';
$lang['OFF_SHOW_REASON'] = 'Продолжать отвечать на запросы клиентов';
$lang['OFF_SHOW_REASON_EXPL'] = 'отправлять клиенту сообщение о причине остановки трекера';
$lang['OFF_REASON'] = 'Причина отключения';
$lang['OFF_REASON_EXPL'] = 'этот текст будет отправляться клиенту пока трекер отключен';
$lang['BT_DEBUG'] = 'Режим отладки';
$lang['BT_DEBUG_EXPL'] = 'включать в сообщения об ошибках дополнительную информацию';
$lang['SILENT_MODE'] = 'Не сообщать об ошибках';
$lang['SILENT_MODE_EXPL'] = 'в случае ошибок завершать работу без отправки клиенту сообщения об ошибках';
$lang['AUTOCLEAN'] = 'Автоочистка';
$lang['AUTOCLEAN_EXPL'] = 'периодически очищать таблицу peer\'s - не отключайте без особой необходимости!';
$lang['AUTOCLEAN_INTERVAL'] = 'Интервал автоочистки';
$lang['COMPACT_MODE'] = 'Компактный режим';
$lang['COMPACT_MODE_EXPL'] = '"Да" - трекер будет работать только в компактном режиме<br />"Нет" - будет определяется клиентом<br />в компактном режиме расход трафика наименьший, но могут возникнуть проблемы из-за несовместимости со старыми клиентами';
$lang['BROWSER_REDIRECT_URL'] = 'Browser redirect URL';
$lang['BROWSER_REDIRECT_URL_EXPL'] = 'переадресация на этот URL при попытке зайти на трекер Web browserом<br />* оставьте пустым для отключения';

$lang['DO_GZIP_HEAD'] = 'GZip';
$lang['DO_GZIP'] = 'Использовать сжатие GZip';
$lang['DO_GZIP_EXPL'] = 'уроверь компрессии можно настроить в "bt/config.php"';
$lang['FORCE_GZIP'] = 'Всегда использовать сжатие';
$lang['FORCE_GZIP_EXPL'] = 'отключает проверку поддержки клиентом GZip';
$lang['CLIENT_COMPAT_GZIP'] = 'Только если клиент поддерживает';
$lang['CLIENT_COMPAT_GZIP_EXPL'] = 'выполнять сжатие через ob_gzhandler()';

$lang['IGNOR_GIVEN_IP_HEAD'] = 'IP';
$lang['IGNOR_GIVEN_IP'] = 'Игнорировать указанный клиентом IP';
$lang['IGNOR_GIVEN_IP_EXPL'] = 'всегда использовать только $_SERVER["REMOTE_ADDR"]';
$lang['ALLOW_HOST_IP'] = 'Разрешить использовать вместо IP имя хоста';
$lang['ALLOW_HOST_IP_EXPL'] = '';

$lang['IGNOR_NUMWANT_HEAD'] = 'Numwant';
$lang['IGNOR_NUMWANT'] = 'Игнорировать numwant';
$lang['IGNOR_NUMWANT_EXPL'] = 'игнорировать запрашиваемое клиентом количество источников';
$lang['NUMWANT'] = 'Значение numwant';
$lang['NUMWANT_EXPL'] = 'количество источников (peers) отправляемых клиенту';
$lang['NUMWANT_MAX'] = 'Максимальное значение numwant';
$lang['NUMWANT_MAX_EXPL'] = 'максимальное количество источников (peers) отправляемых клиенту';

$lang['MIN_ANN_INTV_HEAD'] = 'Announce';
$lang['MIN_ANN_INTV'] = 'Announce интервал';
$lang['MIN_ANN_INTV_EXPL'] = 'пауза между announcements в секундах';
$lang['EXPIRE_FACTOR'] = 'Фактор смерти peer\'ов';
$lang['EXPIRE_FACTOR_EXPL'] = 'время жизни peer\'а расчитывается как announce интервал умноженный на фактор смерти peer\'а<br />должен быть не меньше 1';

$lang['LIMIT_ACTIVE_TOR_HEAD'] = 'Ограничения';
$lang['LIMIT_ACTIVE_TOR'] = 'Ограничить количество одновременных закачек';
$lang['LIMIT_ACTIVE_TOR_EXPL'] = 'работает только при наличии passkey! для гостей - неактивно';
$lang['LIMIT_SEED_COUNT'] = 'Seeding ограничение';
$lang['LIMIT_SEED_COUNT_EXPL'] = 'ограничение на количество одновременных раздач<br />0 - нет ограничений';
$lang['LIMIT_LEECH_COUNT'] = 'Leeching ограничение';
$lang['LIMIT_LEECH_COUNT_EXPL'] = 'ограничение на количество одновременных закачек<br />0 - нет ограничений';
$lang['LEECH_EXPIRE_FACTOR'] = 'Leech expire factor';
$lang['LEECH_EXPIRE_FACTOR_EXPL'] = 'сколько минут считать начатую закачку активной, независимо от того, остановил ли ее юзер<br />0 - учитывать остановку';
$lang['LIMIT_CONCURRENT_IPS'] = 'Ограничить количество подключений с разных IP';
$lang['LIMIT_CONCURRENT_IPS_EXPL'] = 'учитывается отдельно для каждого торрента';
$lang['LIMIT_SEED_IPS'] = 'Seeding IP ограничение';
$lang['LIMIT_SEED_IPS_EXPL'] = 'раздаваь можно не более чем с <i>хх</i> IP\'s<br />(0 - нет ограничений)';
$lang['LIMIT_LEECH_IPS'] = 'Leeching IP ограничение';
$lang['LIMIT_LEECH_IPS_EXPL'] = 'скачивать можно не более чем с <i>хх</i> IP\'s<br />(0 - нет ограничений)';

$lang['USE_AUTH_KEY_HEAD'] = 'Авторизация';
$lang['USE_AUTH_KEY'] = 'Passkey';
$lang['USE_AUTH_KEY_EXPL'] = 'включить авторизацию по passkey<br />(aвтодобавление passkey к торент-файлам перед их скачиванием можно включить в настройках форума: TorrentPier - Forum Config)';
$lang['AUTH_KEY_NAME'] = 'Имя ключа passkey';
$lang['AUTH_KEY_NAME_EXPL'] = 'имя ключа, который будет добавляться в GET запросе к announce url для идентификации юзера';
$lang['ALLOW_GUEST_DL'] = 'Разрешить "гостям" (неавторизованным юзерам) доступ к трекеру';

$lang['UPDATE_USERS_DL_STATUS_HEAD'] = 'Статистика';
$lang['UPDATE_USERS_DL_STATUS'] = 'Обновлять статус закачки "Качаю"';
$lang['UPDATE_USERS_DL_STATUS_EXPL'] = 'автоматически изменять статус закачки юзера на "Качаю" если юзер начал закачку';
$lang['UPDATE_USERS_COMPL_STATUS'] = 'Обновлять статус закачки "Скачал"';
$lang['UPDATE_USERS_COMPL_STATUS_EXPL'] = 'автоматически изменять статус закачки юзера на "Скачал" по завершению закачки';
$lang['UPD_USER_UP_DOWN_STAT'] = 'Вести учет скачанного/отданного юзером';
$lang['USER_STATISTIC_UPD_INTERVAL'] = 'Интервал обновления статистики скачанного/отданного юзером';
$lang['SEED_LAST_SEEN_UPD_INTERVAL'] = 'Интервал обновления записи о последнем seeder\'e';

////
// Forum config//
////
$lang['FORUM_CFG_EXPL'] = 'Настройки форума';

$lang['BT_SELECT_FORUMS'] = 'Форумы, в которых:';
$lang['BT_SELECT_FORUMS_EXPL'] = 'для выделения нескольких форумов, отмечайте их с нажатой клавишей <i>Ctrl</i>';

$lang['ALLOW_REG_TRACKER'] = 'Разрешена регистрация торентов на трекере';
$lang['ALLOW_DL_TOPIC'] = 'Разрешено создавать Download топики';
$lang['DL_TYPE_DEFAULT'] = 'Новые топики имеют статус Download по умолчанию';
$lang['SHOW_DL_BUTTONS'] = 'Показывать кнопки для изменения DL-статуса';
$lang['SELF_MODERATED'] = 'Автор топика может перенести его в другой форум';

$lang['BT_ANNOUNCE_URL_HEAD'] = 'Announce URL';
$lang['BT_ANNOUNCE_URL'] = 'Announce url';
$lang['BT_ANNOUNCE_URL_EXPL'] = 'дополнительные разрешенные адреса можно задать в "includes/announce_urls.php"';
$lang['BT_CHECK_ANNOUNCE_URL'] = 'Проверять announce url';
$lang['BT_CHECK_ANNOUNCE_URL_EXPL'] = 'разрешить регистрацию на трекере только если announce url входит в список разрешенных';
$lang['BT_REPLACE_ANN_URL'] = 'Заменять announce url';
$lang['BT_REPLACE_ANN_URL_EXPL'] = 'заменять оригинальный announce url в .torrent файлах на ваш';
$lang['BT_DEL_ADDIT_ANN_URLS'] = 'Удалять все дополнительные announce urls';
$lang['BT_DEL_ADDIT_ANN_URLS_EXPL'] = 'если торент содержит адреса других трекеров, они будут удалены';
$lang['BT_ADD_COMMENT'] = 'Добавлять в торент комментарий';
$lang['BT_ADD_COMMENT_EXPL'] = 'оставьте пустым для добавления адреса топика к качестве комментария';
$lang['BT_ADD_PUBLISHER'] = 'Добавлять адрес топика как publisher-url и это имя в качестве имени publisher';
$lang['BT_ADD_PUBLISHER_EXPL'] = 'для отключения - оставьте пустым';

$lang['BT_SHOW_PEERS_HEAD'] = 'Peers-List';
$lang['BT_SHOW_PEERS'] = 'Показывать список источников (seeders/leechers)';
$lang['BT_SHOW_PEERS_EXPL'] = 'будет выводиться над топиком с торентом';
$lang['BT_SHOW_PEERS_MODE'] = 'По умолчанию показывать источники как:';
$lang['BT_SHOW_PEERS_MODE_COUNT'] = 'Только количество';
$lang['BT_SHOW_PEERS_MODE_NAMES'] = 'Только имена';
$lang['BT_SHOW_PEERS_MODE_FULL'] = 'Подробно';
$lang['BT_ALLOW_SPMODE_CHANGE'] = 'Разрешить подробный показ источников';
$lang['BT_ALLOW_SPMODE_CHANGE_EXPL'] = 'если выбрано "нет" - будет доступен только режим по умолчанию';
$lang['BT_SHOW_IP_ONLY_MODER'] = '<b>IP</b> могут видеть только модераторы';
$lang['BT_SHOW_PORT_ONLY_MODER'] = '<b>Port</b> могут видеть только модераторы';

$lang['BT_SHOW_DL_LIST_HEAD'] = 'DL-List';
$lang['BT_SHOW_DL_LIST'] = 'Выводить DL-List при просмотре топика';
$lang['BT_DL_LIST_ONLY_1ST_PAGE'] = 'Выводить DL-List только на первой странице топика';
$lang['BT_DL_LIST_ONLY_COUNT'] = 'Выводить только количество';
$lang['BT_DL_LIST_EXPIRE'] = 'Срок действия статуса <i>Буду качать</i> и <i>Качаю</i>';
$lang['BT_DL_LIST_EXPIRE_EXPL'] = 'по истечении этого срока отметившиеся юзеры будут автоматически удаляться из списка<br />0 - отключить эту опцию';
$lang['BT_SHOW_DL_LIST_BUTTONS'] = 'Показывать кнопки для изменения DL-статуса';
$lang['BT_SHOW_DL_LIST_BUTTONS_EXPL'] = 'глобальная настройка';
$lang['BT_SHOW_DL_BUT_WILL'] = $lang['DLWILL'];
$lang['BT_SHOW_DL_BUT_DOWN'] = $lang['DLDOWN'];
$lang['BT_SHOW_DL_BUT_COMPL'] = $lang['DLCOMPLETE'];
$lang['BT_SHOW_DL_BUT_CANCEL'] = $lang['DLCANCEL'];

$lang['BT_ADD_AUTH_KEY_HEAD'] = 'Passkey';
$lang['BT_ADD_AUTH_KEY'] = 'Aвтодобавление passkey к торент-файлам перед их скачиванием';
$lang['BT_FORCE_PASSKEY'] = 'Обязательное добавление passkey';
$lang['BT_FORCE_PASSKEY_EXPL'] = 'перенаправлять гостей на страницу логина при попытке скачать торент-файл';
$lang['BT_GEN_PASSKEY_ON_REG'] = 'Автоматически генерировать passkey';
$lang['BT_GEN_PASSKEY_ON_REG_EXPL'] = 'если passkey не найден, генерировать его при первом скачивании торента';

$lang['BT_TOR_BROWSE_ONLY_REG_HEAD'] = 'Torrent browser (трекер)';
$lang['BT_TOR_BROWSE_ONLY_REG'] = 'Torrent browser (tracker.php) не доступен для гостей';
$lang['BT_SEARCH_BOOL_MODE'] = 'Разрешить полнотекстовый поиск в логическом режиме';
$lang['BT_SEARCH_BOOL_MODE_EXPL'] = 'использовать *, +, - и т.д. при поиске. Работает только если MySQL > 4.0.1';

$lang['BT_SHOW_DL_STAT_ON_INDEX_HEAD'] = 'Разное';
$lang['BT_SHOW_DL_STAT_ON_INDEX'] = 'Показывать UL/DL статистику юзера на главной странице форума';
$lang['BT_NEWTOPIC_AUTO_REG'] = 'Регистрировать торенты на трекере для новых топиков';
$lang['BT_SET_DLTYPE_ON_TOR_REG'] = 'Изменять статус топка на "Download" во время регистрации торента на трекере';
$lang['BT_SET_DLTYPE_ON_TOR_REG_EXPL'] = 'не зависит от того, разрешено ли в этом форуме создавать Download-топики (в настройках форумов)';
$lang['BT_UNSET_DLTYPE_ON_TOR_UNREG'] = 'Изменять статус топка на "Normal" во время удаления торента с трекера';

?>