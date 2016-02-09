<?php

$lang['Bt_Reg_YES'] = 'Зарегистрирован';
$lang['Bt_Reg_NO'] = 'Не зарегистрирован';
$lang['Bt_Added'] = 'Добавлен';
$lang['Bt_Completed'] = "Скачан";
$lang['Bt_Reg_on_tracker'] = 'Зарегистрировать на трекере';
$lang['Bt_Reg_fail'] = 'Не удалось зарегистрировать торент на трекере';
$lang['Bt_Reg_fail_same_hash'] = 'Другой торент с таким же info_hash уже зарегистрирован';
$lang['Bt_Unreg_from_tracker'] = 'Удалить с трекера';
$lang['Bt_Deleted'] = 'Торент удален с трекера';
$lang['Bt_Registered'] = 'Торент зарегистрирован на трекере<br /><br />Теперь вам <a href="%s"><b>нужно его скачать</b></a> и поставить на закачку у самого себя в ту же директорию, где лежат оригинальные файлы';
$lang['Invalid_ann_url'] = 'Неправильный Аnnounce URL [%s]<br /><br />должен быть <b>%s</b>';
$lang['Passkey_err_tor_not_reg'] = 'Невозможно добавить passkey<br /><br />Торрент не зарегистрирован на трекере';
$lang['Passkey_err_empty'] = 'Невозможно добавить passkey<br /><br />Вам необходимо <a href="%s" target="_blank"><b>зайти в ваш форумный профиль</b></a> и сгенерировать passkey';
$lang['Bt_Gen_Passkey'] = 'Passkey';
$lang['Bt_Gen_Passkey_Url'] = 'Создать или изменить Passkey';
$lang['Bt_Gen_Passkey_Explain'] = 'Сгенерировать ваш личный id, который будет добавляться в торент-файлы во время скачивания и затем использоваться трекером в качестве вашего аутентификатора.';
$lang['Bt_Gen_Passkey_Explain_2'] = '<b>Внимание!</b> После изменения или создания нового id вам будет необходимо <b>заново скачать все активные торенты!</b> Так же, после создания passkey, перед тем, как релизить, вы должны будете скачать свой .torrent файл и только после этого его релизить. Именно скачанный на форуме .torrent, а не тот, который вы залили. Это важно, потому что иначе трекер вас не авторизует.';
$lang['Bt_Gen_Passkey_OK'] = 'Ваш персональный идентификатор на трекере сгенеририван';
$lang['Bt_No_searchable_forums'] = 'Доступных для поиска форумов не найдено';

$lang['Seeders'] = 'Сидеры';
$lang['Leechers'] = 'Личеры';
$lang['Seeding'] = 'Раздает';
$lang['Leeching'] = 'Качает';
$lang['Tracker'] = 'Трекер';
$lang['Registered'] = 'Зарегистрирован';
$lang['Bt_Topic_Title'] = 'Название темы';
$lang['Bt_Seeder_last_seen'] = 'Последний сидер';
$lang['Bt_Sort_Forum'] = 'Форум';
$lang['Tor_Size'] = 'Размер';
$lang['Piece_length'] = 'Размер блока';
$lang['Completed'] = 'Торрент скачан';
$lang['Tor_Posted'] = 'Добавлен';
$lang['Tor_Delete'] = 'Удалить торент';
$lang['Tor_Del_Move'] = 'Удалить и перенести топик';
$lang['Tor_DL'] = 'Скачать .torrent';
$lang['Bt_Last_post'] = 'Посл. сообщение';
$lang['Post_Download'] = 'Download';

$lang['Bt_Search_in'] = 'Искать в форумах';
$lang['Bt_Posts_from'] = 'Торенты за';
$lang['Bt_Show_only'] = 'Показывать только';
$lang['Bt_Displaying'] = 'Показывать колонку';

$lang['Bt_Only_Active'] = 'Активные';
$lang['Bt_Only_My'] = 'мои';
$lang['Bt_Seed_exist'] = 'есть сидер';
$lang['Bt_Seed_gt'] = 'кол. сидеров &gt; ';
$lang['Bt_Only_New'] = 'Новые с посл. посещения';
$lang['Bt_Show_Cat'] = 'Категория';
$lang['Bt_Show_Forum'] = 'Форум';
$lang['Bt_Show_Author'] = 'Автор';
$lang['Bt_Show_Speed'] = 'Скорость';
$lang['Bt_Seed_not_seen'] = 'Источника не было';
$lang['Bt_Title_match'] = 'Название содержит';
$lang['Bt_User_not_found'] = 'не найден';
$lang['Bt_DL_speed'] = 'Общая скорость скачивания';

$lang['Bt_Disregard'] = 'не учитывать';
$lang['Bt_Never'] = 'никогда';
$lang['Bt_All_Days_for'] = 'за все время';
$lang['Bt_1_Day_for']    = 'за сегодня';
$lang['Bt_3_Day_for']    = 'последние 3 дня';
$lang['Bt_7_Days_for']   = 'посл. неделю';
$lang['Bt_2_Weeks_for']  = 'посл. 2 недели';
$lang['Bt_1_Month_for']  = 'последний месяц';
$lang['Bt_1_Day']    = 'день';
$lang['Bt_3_Days']    = '3 дня';
$lang['Bt_7_Days']   = 'неделю';
$lang['Bt_2_Weeks']  = '2 недели';
$lang['Bt_1_Month']  = 'месяц';

$lang['dlWill'] = 'Буду качать';
$lang['dlDown'] = 'Качаю';
$lang['dlComplete'] = 'Скачал';
$lang['dlCancel'] = 'Отмена';

$lang['dlWill_2'] = 'Будут качать';
$lang['dlDown_2'] = 'Качают';
$lang['dlComplete_2'] = 'Скачали';
$lang['dlCancel_2'] = 'Отмена';

$lang['DL_List_Del'] = 'Очистить DL-List';
$lang['DL_List_Del_Confirm'] = 'Вы уверены, что хотите удалить DL-List для этого топика?';
$lang['Set_DL_Status'] = 'Download';
$lang['Unset_DL_Status'] = 'Not Download';
$lang['Topics_Down_Sets'] = 'Выбранные темы изменили статус на: <b>Download</b>';
$lang['Topics_Down_Unsets'] = 'Выбранные темы перестали быть <b>Download</b>';

$lang['Topic_DL'] = '<span class="tDL">DL: </span>';
$lang['Topic_DL_Down'] = '<span class="tDLDown">DL: </span>';
$lang['Topic_DL_Complete'] = '<span class="tDLCmpl">DL: </span>';

$lang['Search_DL'] = 'Закачки';
$lang['Search_DL_Will'] = 'Будущие';
$lang['Search_DL_Down'] = 'Текущие';
$lang['Search_DL_Complete'] = 'Прошлые';
$lang['Search_DL_Cancel'] = 'Отмененные';

$lang['Allowed_only_1st_post_attach'] = 'Вы можете прикреплять торрент-файлы только к первому сообщению в теме';
$lang['Allowed_only_1st_post_reg'] = 'Вы можете регистрировать торрент-файлы на трекере только из первого сообщения в теме';
$lang['Reg_not_allowed_in_this_forum'] = 'В этом форуме регистрация торрентов на трекере запрещена';
$lang['Already_reg'] = 'Торрент уже зарегистрирован';
$lang['Not_torrent'] = 'Это не торрент-файл';
$lang['Only_1_tor_per_post'] = 'Вы не можете зарегистрировать еще один торрент для этого сообщения';
$lang['Only_1_tor_per_topic'] = 'Вы не можете зарегистрировать еще один торрент для этого топика';
$lang['Viewing_user_bt_profile'] = 'Торрент-профиль пользователя %s'; // %s is username
$lang['Cur_active_dls'] = 'Текущие активные торренты';
$lang['View_torrent_profile'] = 'Торрент-профиль';
$lang['Curr_passkey'] = 'Текущий passkey:';
$lang['spmode_full'] = 'Подробная статистика пиров';

$lang['Viewing_TRACKER'] = 'Трекер';
$lang['Tracker'] = 'Трекер';

$lang['dl_list_tip_1'] = '*Буду качать - если вы планируете начать закачку позже. Потом этот топик можно будет найти на <a href="search.php?search_id=dl&dl_status=0">этой</a> странице.';

$lang['Bt_What_Is_Bonus'] = 'Что это такое?';

$lang['Releasing'] = 'Свои';
$lang['Info'] = 'Раздача';

?>