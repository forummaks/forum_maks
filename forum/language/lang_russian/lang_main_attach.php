<?php

// Auth Related Entries
$lang['RULES_ATTACH_CAN'] = 'Вы <b>можете</b> прикреплять файлы к сообщениям';
$lang['RULES_ATTACH_CANNOT'] = 'Вы <b>не можете</b> прикреплять файлы к сообщениям';
$lang['RULES_DOWNLOAD_CAN'] = ' Вы <b>можете</b> скачивать файлы';
$lang['RULES_DOWNLOAD_CANNOT'] = 'Вы <b>не можете</b> скачивать файлы';
$lang['SORRY_AUTH_VIEW_ATTACH'] = 'Sorry but you are not authorized to view or download this Attachment';

// Viewtopic -> Display of Attachments//
$lang['DESCRIPTION'] = 'Описание'; // used in Administration Panel too...
$lang['DOWNLOADED'] = 'Скачан';
$lang['DOWNLOAD'] = 'Скачать'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['FILESIZE'] = 'Размер';
$lang['VIEWED'] = 'Viewed';
$lang['DOWNLOAD_NUMBER'] = '%d раз(а)'; // replace %d with count
$lang['EXTENSION_DISABLED_AFTER_POSTING'] = 'The Extension \'%s\' was deactivated by an board admin, therefore this Attachment is not displayed.'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display//
$lang['ATTACH_POSTING_CP'] = 'Attachment Posting Control Panel';
$lang['ATTACH_POSTING_CP_EXPLAIN'] = 'If you click on Add an Attachment, you will see the box for adding Attachments.<br />If you click on Posted Attachments, you will see a list of already attached Files and you are able to edit them.<br />If you want to Replace (Upload new Version) an Attachment, you have to click both links. Add the Attachment as you normally would do, thereafter don\'t click on Add Attachment, rather click on Upload New Version at the Attachment Entry you intend to update.';

// Posting/PM -> Posting Attachments//
$lang['ADD_ATTACHMENT'] = 'Прикрепить';
$lang['ADD_ATTACHMENT_TITLE'] = 'Прикрепить файл';
$lang['ADD_ATTACHMENT_EXPLAIN'] = 'Если вы не хотите прикреплять файл, оставьте поля пустыми';
$lang['FILE_NAME'] = 'Имя файла';
$lang['FILE_COMMENT'] = 'Комментарии';

// Posting/PM -> Posted Attachments//
$lang['POSTED_ATTACHMENTS'] = 'Posted Attachments';
$lang['OPTIONS'] = 'Настройки';
$lang['UPDATE_COMMENT'] = 'Обновить комментарий';
$lang['DELETE_ATTACHMENTS'] = 'Удалить вложения';
$lang['DELETE_ATTACHMENT'] = 'Удалить вложение';
$lang['DELETE_THUMBNAIL'] = 'Delete Thumbnail';
$lang['UPLOAD_NEW_VERSION'] = 'Upload New Version';

// Errors -> Posting Attachments//
$lang['INVALID_FILENAME'] = '%s is an invalid filename'; // replace %s with given filename
$lang['ATTACHMENT_PHP_SIZE_NA'] = 'The Attachment is too big.<br />Couldn\'t get the maximum Size defined in PHP.<br />The Attachment Mod is unable to determine the maximum Upload Size defined in the php.ini.';
$lang['ATTACHMENT_PHP_SIZE_OVERRUN'] = 'The Attachment is too big.<br />Maximum Upload Size: <b>%d</b> MB.<br />Please note that this Size is defined in php.ini, this means it\'s set by PHP and the Attachment Mod can not override this value.'; // replace %d with ini_get('upload_max_filesize')
$lang['DISALLOWED_EXTENSION'] = 'The Extension <b>%s</b> is not allowed'; // replace %s with extension (e.g. .php)
$lang['DISALLOWED_EXTENSION_WITHIN_FORUM'] = 'You are not allowed to post Files with the Extension <b>%s</b> within this Forum'; // replace %s with the Extension
$lang['ATTACHMENT_TOO_BIG'] = 'The Attachment is too big.<br />Max Size: %d %s'; // replace %d with maximum file size, %s with size var
$lang['ATTACH_QUOTA_REACHED'] = 'Sorry, but the maximum filesize for all Attachments is reached. Please contact the Board Administrator if you have questions.';
$lang['TOO_MANY_ATTACHMENTS'] = 'Attachment cannot be added, since the max. number of %d Attachments in this post was achieved'; // replace %d with maximum number of attachments
$lang['ERROR_IMAGESIZE'] = 'The Attachment/Image must be less than %d pixels wide and %d pixels high';
$lang['GENERAL_UPLOAD_ERROR'] = 'Upload Error: Could not upload Attachment to %s.'; // replace %s with local path

$lang['ERROR_EMPTY_ADD_ATTACHBOX'] = 'You have to enter values in the \'Add an Attachment\' Box';
$lang['ERROR_MISSING_OLD_ENTRY'] = 'Unable to Update Attachment, could not find old Attachment Entry';

// Errors -> PM Related//
$lang['ATTACH_QUOTA_SENDER_PM_REACHED'] = 'Sorry, but the maximum filesize for all Attachments in your Private Message Folder has been reached. Please delete some of your received/sent Attachments.';
$lang['ATTACH_QUOTA_RECEIVER_PM_REACHED'] = 'Sorry, but the maximum filesize for all Attachments in the Private Message Folder of \'%s\' has been reached. Please let him know, or wait until he/she has deleted some of his/her Attachments.';

// Errors -> Download//
$lang['NO_ATTACHMENT_SELECTED'] = 'You haven\'t selected an attachment to download or view.';
$lang['ERROR_NO_ATTACHMENT'] = 'The selected Attachment does not exist anymore';

// Delete Attachments//
$lang['CONFIRM_DELETE_ATTACHMENTS'] = 'Are you sure you want to delete the selected Attachments?';
$lang['DELETED_ATTACHMENTS'] = 'The selected Attachments have been deleted.';
$lang['ERROR_DELETED_ATTACHMENTS'] = 'Could not delete Attachments.';
$lang['CONFIRM_DELETE_PM_ATTACHMENTS'] = 'Are you sure you want to delete all Attachments posted in this PM?';

// General Error Messages//
$lang['ATTACHMENT_FEATURE_DISABLED'] = 'The Attachment Feature is disabled.';

$lang['DIRECTORY_DOES_NOT_EXIST'] = 'The Directory \'%s\' does not exist or couldn\'t be found.'; // replace %s with directory
$lang['DIRECTORY_IS_NOT_A_DIR'] = 'Please check if \'%s\' is a directory.'; // replace %s with directory
$lang['DIRECTORY_NOT_WRITEABLE'] = 'Directory \'%s\' is not writeable. You\'ll have to create the upload path and chmod it to 777 (or change the owner to you httpd-servers owner) to upload files.<br />If you have only plain ftp-access change the \'Attribute\' of the directory to rwxrwxrwx.'; // replace %s with directory

$lang['FTP_ERROR_CONNECT'] = 'Could not connect to FTP Server: \'%s\'. Please check your FTP-Settings.';
$lang['FTP_ERROR_LOGIN'] = 'Could not login to FTP Server. The Username \'%s\' or the Password is wrong. Please check your FTP-Settings.';
$lang['FTP_ERROR_PATH'] = 'Could not access ftp directory: \'%s\'. Please check your FTP Settings.';
$lang['FTP_ERROR_UPLOAD'] = 'Could not upload files to ftp directory: \'%s\'. Please check your FTP Settings.';
$lang['FTP_ERROR_DELETE'] = 'Could not delete files in ftp directory: \'%s\'. Please check your FTP Settings.<br />Another reason for this error could be the non-existence of the Attachment, please check this first in Shadow Attachments.';
$lang['FTP_ERROR_PASV_MODE'] = 'Unable to enable/disable FTP Passive Mode';

// Attach Rules Window//
$lang['RULES_PAGE'] = 'Attachment Rules';
$lang['ATTACH_RULES_TITLE'] = 'Allowed Extension Groups and their Sizes';
$lang['GROUP_RULE_HEADER'] = '%s -> Maximum Upload Size: %s'; // Replace first %s with Extension Group, second one with the Size STRING
$lang['ALLOWED_EXTENSIONS_AND_SIZES'] = 'Allowed Extensions and Sizes';
$lang['NOTE_USER_EMPTY_GROUP_PERMISSIONS'] = 'NOTE:<br />You are normally allowed to attach files within this Forum, <br />but since no Extension Group is allowed to be attached here, <br />you are unable to attach anything. If you try, <br />you will receive an Error Message.<br />';

// Quota Variables//
$lang['UPLOAD_QUOTA'] = 'Квота';
$lang['PM_QUOTA'] = 'PM Quota';
$lang['USER_UPLOAD_QUOTA_REACHED'] = 'Sorry, you have reached your maximum Upload Quota Limit of %d %s'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel//
$lang['USER_ACP_TITLE'] = 'User ACP';
$lang['UACP'] = 'Панель управления вложениями пользователя';
$lang['USER_UPLOADED_PROFILE'] = 'Закачано: %s';
$lang['USER_QUOTA_PROFILE'] = 'Квота: %s';
$lang['UPLOAD_PERCENT_PROFILE'] = '%d%% от общего';

// Common Variables//
$lang['BYTES'] = 'Байт';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';
$lang['ATTACH_SEARCH_QUERY'] = 'Поиск вложений';
$lang['TEST_SETTINGS'] = 'Test Settings';
$lang['NOT_ASSIGNED'] = 'Not Assigned';
$lang['NO_FILE_COMMENT_AVAILABLE'] = 'No File Comment available';
$lang['ATTACHBOX_LIMIT'] = 'Ваш &laquo;Attachments box&raquo; заполнен на %d%%';
$lang['NO_QUOTA_LIMIT'] = 'No Quota Limit';
$lang['UNLIMITED'] = 'Без ограничений';

?>