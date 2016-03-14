<?php
/***************************************************************************
*                            $RCSfile: lang_admin_topic_shadow.php,v $
*                            -------------------
*   copyright            : (C) 2002-2003 Nivisec.com
*   email                : support@nivisec.com
*
*   $Id: lang_admin_topic_shadow.php,v 1.3 2003/06/26 00:16:32 nivisec Exp $
*
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

/* If you are translating this, please e-mail a copy to me! */
/* admin@nivisec.com is fine to use */

/* General */
$lang['DEL_BEFORE_DATE'] = 'Deleted all Shadow Topics before %s<br />'; // %s = insertion of date
$lang['DELETED_TOPIC'] = 'Deleted Shadow Topic %s<br />'; // %s = topic name
$lang['AFFECTED_ROWS'] = '%d known entries were affected<br />'; // %d = affected rows (not avail with all databases!)
$lang['DELETE_FROM_DATE'] = 'All Shadow Topics that were created before the entered date will be removed.';
$lang['DELETE_BEFORE_DATE_BUTTON'] = 'Delete All Before Date';
$lang['NO_SHADOW_TOPICS'] = 'No Shadow Topics were found.';
$lang['TOPIC_SHADOW'] = 'Topic Shadow';
$lang['TS_DESC'] = 'Allows the removal of shadow topics without the deletion of the actual message.  Shadow topics are created when you move a post to another forum and choose to leave behind a link in the original forum to the new post.';
$lang['MONTH'] = 'Month';
$lang['DAY'] = 'Day';
$lang['YEAR'] = 'Year';
$lang['CLEAR'] = 'Clear';
$lang['RESYNC_RAN_ON'] = 'Resync Ran On %s<br />'; // %s = insertion of forum name
$lang['ALL_FORUMS'] = 'All Forums';
$lang['VERSION'] = 'Version';

$lang['TITLE'] = 'Title';
$lang['MOVED_TO'] = 'Moved To';
$lang['MOVED_FROM'] = 'Moved From';
$lang['DELETE'] = 'Delete';

/* Modes */
$lang['TOPIC_TIME'] = 'Topic Time';
$lang['TOPIC_TITLE'] = 'Topic Title';

/* Errors */
$lang['ERROR_MONTH'] = 'Your input month must be between 1 and 12';
$lang['ERROR_DAY'] = 'Your input day must be between 1 and 31';
$lang['ERROR_YEAR'] = 'Your input year must be between 1970 and 2038';
$lang['ERROR_TOPICS_TABLE'] = 'Error accessing topics table';

//Special Cases, Do not change for another language//SPECIAL
$lang['ASC'] = $lang['Sort_Ascending'];
$lang['DESC'] = $lang['Sort_Descending'];
$lang['NIVISEC_COM'] = 'Nivisec.com';

?>