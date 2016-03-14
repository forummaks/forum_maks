<?php
/***************************************************************************
 *                            lang_admin.php [English]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.35.2.10 2005/02/21 18:38:17 acydburn Exp $
 *
 ****************************************************************************/
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
/* CONTRIBUTORS
	2002-12-15	Philip M. White (pwhite@mailhaven.com)
		Fixed many minor grammatical mistakes
*/
//
// Format is same as lang_main
//
//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['GENERAL'] = 'General Admin';
$lang['USERS'] = 'User Admin';
$lang['GROUPS'] = 'Group Admin';
$lang['FORUMS'] = 'Forum Admin';
$lang['STYLES'] = 'Styles Admin';

$lang['CONFIGURATION'] = 'Configuration';
$lang['PERMISSIONS'] = 'Permissions';
$lang['MANAGE'] = 'Management';
$lang['DISALLOW'] = 'Disallow names';
$lang['PRUNE'] = 'Pruning';
$lang['MASS_EMAIL'] = 'Mass Email';
$lang['RANKS'] = 'Ranks';
$lang['SMILIES'] = 'Smilies';
$lang['BAN_MANAGEMENT'] = 'Ban Control';
$lang['WORD_CENSOR'] = 'Word Censors';
$lang['EXPORT'] = 'Export';
$lang['CREATE_NEW'] = 'Create';
$lang['ADD_NEW'] = 'Add';
$lang['BACKUP_DB'] = 'Backup Database';
$lang['RESTORE_DB'] = 'Restore Database';
// FLAGHACK-start//
$lang['FLAGS'] = 'Flags';
// FLAGHACK-end//

////
// Index//
////
$lang['ADMIN'] = 'Administration';
$lang['NOT_ADMIN'] = 'You are not authorised to administer this board';
$lang['WELCOME_PHPBB'] = 'Welcome to phpBB';
$lang['ADMIN_INTRO'] = 'Thank you for choosing phpBB as your forum solution. This screen will give you a quick overview of all the various statistics of your board. You can get back to this page by clicking on the <u>Admin Index</u> link in the left pane. To return to the index of your board, click the phpBB logo also in the left pane. The other links on the left hand side of this screen will allow you to control every aspect of your forum experience. Each screen will have instructions on how to use the tools.';
$lang['MAIN_INDEX'] = 'Forum Index';
$lang['FORUM_STATS'] = 'Forum Statistics';
$lang['ADMIN_INDEX'] = 'Admin Index';
$lang['PREVIEW_FORUM'] = 'Preview Forum';

$lang['CLICK_RETURN_ADMIN_INDEX'] = 'Click %sHere%s to return to the Admin Index';

$lang['STATISTIC'] = 'Statistic';
$lang['VALUE'] = 'Value';
$lang['NUMBER_POSTS'] = 'Number of posts';
$lang['POSTS_PER_DAY'] = 'Posts per day';
$lang['NUMBER_TOPICS'] = 'Number of topics';
$lang['TOPICS_PER_DAY'] = 'Topics per day';
$lang['NUMBER_USERS'] = 'Number of users';
$lang['USERS_PER_DAY'] = 'Users per day';
$lang['BOARD_STARTED'] = 'Board started';
$lang['AVATAR_DIR_SIZE'] = 'Avatar directory size';
$lang['DATABASE_SIZE'] = 'Database size';
$lang['GZIP_COMPRESSION'] ='Gzip compression';
$lang['NOT_AVAILABLE'] = 'Not available';

$lang['ON'] = 'ON'; // This is for GZip compression
$lang['OFF'] = 'OFF';


////
// DB Utils//
////
$lang['DATABASE_UTILITIES'] = 'Database Utilities';

$lang['RESTORE'] = 'Restore';
$lang['BACKUP'] = 'Backup';
$lang['RESTORE_EXPLAIN'] = 'This will perform a full restore of all phpBB tables from a saved file. If your server supports it, you may upload a gzip-compressed text file and it will automatically be decompressed. <b>WARNING</b>: This will overwrite any existing data. The restore may take a long time to process, so please do not move from this page until it is complete.';
$lang['BACKUP_EXPLAIN'] = 'Here you can back up all your phpBB-related data. If you have any additional custom tables in the same database with phpBB that you would like to back up as well, please enter their names, separated by commas, in the Additional Tables textbox below. If your server supports it you may also gzip-compress the file to reduce its size before download.';

$lang['BACKUP_OPTIONS'] = 'Backup options';
$lang['START_BACKUP'] = 'Start Backup';
$lang['FULL_BACKUP'] = 'Full backup';
$lang['STRUCTURE_BACKUP'] = 'Structure-Only backup';
$lang['DATA_BACKUP'] = 'Data only backup';
$lang['ADDITIONAL_TABLES'] = 'Additional tables';
$lang['GZIP_COMPRESS'] = 'Gzip compress file';
$lang['SELECT_FILE'] = 'Select a file';
$lang['START_RESTORE'] = 'Start Restore';

$lang['RESTORE_SUCCESS'] = 'The Database has been successfully restored.<br /><br />Your board should be back to the state it was when the backup was made.';
$lang['BACKUP_DOWNLOAD'] = 'Your download will start shortly; please wait until it begins.';
$lang['BACKUPS_NOT_SUPPORTED'] = 'Sorry, but database backups are not currently supported for your database system.';

$lang['RESTORE_ERROR_UPLOADING'] = 'Error in uploading the backup file';
$lang['RESTORE_ERROR_FILENAME'] = 'Filename problem; please try an alternative file';
$lang['RESTORE_ERROR_DECOMPRESS'] = 'Cannot decompress a gzip file; please upload a plain text version';
$lang['RESTORE_ERROR_NO_FILE'] = 'No file was uploaded';


////
// Auth pages//
////
$lang['SELECT_A_USER'] = 'Select a User';
$lang['SELECT_A_GROUP'] = 'Select a Group';
$lang['SELECT_A_FORUM'] = 'Select a Forum';
$lang['AUTH_CONTROL_USER'] = 'User Permissions Control';
$lang['AUTH_CONTROL_GROUP'] = 'Group Permissions Control';
$lang['AUTH_CONTROL_FORUM'] = 'Forum Permissions Control';
$lang['LOOK_UP_USER'] = 'Look up User';
$lang['LOOK_UP_GROUP'] = 'Look up Group';
$lang['LOOK_UP_FORUM'] = 'Look up Forum';

$lang['GROUP_AUTH_EXPLAIN'] = 'Here you can alter the permissions and moderator status assigned to each user group. Do not forget when changing group permissions that individual user permissions may still allow the user entry to forums, etc. You will be warned if this is the case.';
$lang['USER_AUTH_EXPLAIN'] = 'Here you can alter the permissions and moderator status assigned to each individual user. Do not forget when changing user permissions that group permissions may still allow the user entry to forums, etc. You will be warned if this is the case.';
$lang['FORUM_AUTH_EXPLAIN'] = 'Here you can alter the authorisation levels of each forum. You will have both a simple and advanced method for doing this, where advanced offers greater control of each forum operation. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';

$lang['SIMPLE_MODE'] = 'Simple Mode';
$lang['ADVANCED_MODE'] = 'Advanced Mode';
$lang['MODERATOR_STATUS'] = 'Moderator status';

$lang['ALLOWED_ACCESS'] = 'Allowed Access';
$lang['DISALLOWED_ACCESS'] = 'Disallowed Access';
$lang['IS_MODERATOR'] = 'Is Moderator';
$lang['NOT_MODERATOR'] = 'Not Moderator';

$lang['CONFLICT_WARNING'] = 'Authorisation Conflict Warning';
$lang['CONFLICT_ACCESS_USERAUTH'] = 'This user still has access rights to this forum via group membership. You may want to alter the group permissions or remove this user the group to fully prevent them having access rights. The groups granting rights (and the forums involved) are noted below.';
$lang['CONFLICT_MOD_USERAUTH'] = 'This user still has moderator rights to this forum via group membership. You may want to alter the group permissions or remove this user the group to fully prevent them having moderator rights. The groups granting rights (and the forums involved) are noted below.';

$lang['CONFLICT_ACCESS_GROUPAUTH'] = 'The following user (or users) still have access rights to this forum via their user permission settings. You may want to alter the user permissions to fully prevent them having access rights. The users granted rights (and the forums involved) are noted below.';
$lang['CONFLICT_MOD_GROUPAUTH'] = 'The following user (or users) still have moderator rights to this forum via their user permissions settings. You may want to alter the user permissions to fully prevent them having moderator rights. The users granted rights (and the forums involved) are noted below.';

$lang['PUBLIC'] = 'Public';
$lang['PRIVATE'] = 'Private';
$lang['REGISTERED'] = 'Registered';
$lang['ADMINISTRATORS'] = 'Administrators';
$lang['HIDDEN'] = 'Hidden';

// These are displayed in the drop down boxes for advanced//
// mode forum auth, try and keep them short!//
$lang['FORUM_ALL'] = 'ALL';
$lang['FORUM_REG'] = 'REG';
$lang['FORUM_PRIVATE'] = 'PRIVATE';
$lang['FORUM_MOD'] = 'MOD';
$lang['FORUM_ADMIN'] = 'ADMIN';

$lang['VIEW'] = 'View';
$lang['READ'] = 'Read';
$lang['POST'] = 'Post';
$lang['REPLY'] = 'Reply';
$lang['EDIT'] = 'Edit';
$lang['DELETE'] = 'Delete';
$lang['STICKY'] = 'Sticky';
$lang['ANNOUNCE'] = 'Announce';
$lang['VOTE'] = 'Vote';
$lang['POLLCREATE'] = 'Poll create';

$lang['PERMISSIONS'] = 'Permissions';
$lang['SIMPLE_PERMISSION'] = 'Simple Permissions';

$lang['USER_LEVEL'] = 'User Level';
$lang['AUTH_USER'] = 'User';
$lang['AUTH_ADMIN'] = 'Administrator';
$lang['GROUP_MEMBERSHIPS'] = 'Usergroup memberships';
$lang['USERGROUP_MEMBERS'] = 'This group has the following members';

$lang['FORUM_AUTH_UPDATED'] = 'Forum permissions updated';
$lang['USER_AUTH_UPDATED'] = 'User permissions updated';
$lang['GROUP_AUTH_UPDATED'] = 'Group permissions updated';

$lang['AUTH_UPDATED'] = 'Permissions have been updated';
$lang['CLICK_RETURN_USERAUTH'] = 'Click %sHere%s to return to User Permissions';
$lang['CLICK_RETURN_GROUPAUTH'] = 'Click %sHere%s to return to Group Permissions';
$lang['CLICK_RETURN_FORUMAUTH'] = 'Click %sHere%s to return to Forum Permissions';


////
// Banning//
////
$lang['BAN_CONTROL'] = 'Ban Control';
$lang['BAN_EXPLAIN'] = 'Here you can control the banning of users. You can achieve this by banning either or both of a specific user or an individual or range of IP addresses or hostnames. These methods prevent a user from even reaching the index page of your board. To prevent a user from registering under a different username you can also specify a banned email address. Please note that banning an email address alone will not prevent that user from being able to log on or post to your board. You should use one of the first two methods to achieve this.';
$lang['BAN_EXPLAIN_WARN'] = 'Please note that entering a range of IP addresses results in all the addresses between the start and end being added to the banlist. Attempts will be made to minimise the number of addresses added to the database by introducing wildcards automatically where appropriate. If you really must enter a range, try to keep it small or better yet state specific addresses.';

$lang['SELECT_USERNAME'] = 'Select a Username';
$lang['SELECT_IP'] = 'Select an IP address';
$lang['SELECT_EMAIL'] = 'Select an Email address';

$lang['BAN_USERNAME'] = 'Ban one or more specific users';
$lang['BAN_USERNAME_EXPLAIN'] = 'You can ban multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser';

$lang['BAN_IP'] = 'Ban one or more IP addresses or hostnames';
$lang['IP_HOSTNAME'] = 'IP addresses or hostnames';
$lang['BAN_IP_EXPLAIN'] = 'To specify several different IP addresses or hostnames separate them with commas. To specify a range of IP addresses, separate the start and end with a hyphen (-); to specify a wildcard, use an asterisk (*).';

$lang['BAN_EMAIL'] = 'Ban one or more email addresses';
$lang['BAN_EMAIL_EXPLAIN'] = 'To specify more than one email address, separate them with commas. To specify a wildcard username, use * like *@hotmail.com';

$lang['UNBAN_USERNAME'] = 'Un-ban one more specific users';
$lang['UNBAN_USERNAME_EXPLAIN'] = 'You can unban multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser';

$lang['UNBAN_IP'] = 'Un-ban one or more IP addresses';
$lang['UNBAN_IP_EXPLAIN'] = 'You can unban multiple IP addresses in one go using the appropriate combination of mouse and keyboard for your computer and browser';

$lang['UNBAN_EMAIL'] = 'Un-ban one or more email addresses';
$lang['UNBAN_EMAIL_EXPLAIN'] = 'You can unban multiple email addresses in one go using the appropriate combination of mouse and keyboard for your computer and browser';

$lang['NO_BANNED_USERS'] = 'No banned usernames';
$lang['NO_BANNED_IP'] = 'No banned IP addresses';
$lang['NO_BANNED_EMAIL'] = 'No banned email addresses';

$lang['BAN_UPDATE_SUCESSFUL'] = 'The banlist has been updated successfully';
$lang['CLICK_RETURN_BANADMIN'] = 'Click %sHere%s to return to Ban Control';


////
// Configuration//
////
$lang['GENERAL_CONFIG'] = 'General Configuration';
$lang['CONFIG_EXPLAIN'] = 'The form below will allow you to customize all the general board options. For User and Forum configurations use the related links on the left hand side.';

$lang['CLICK_RETURN_CONFIG'] = 'Click %sHere%s to return to General Configuration';

$lang['GENERAL_SETTINGS'] = 'General Board Settings';
$lang['SERVER_NAME'] = 'Domain Name';
$lang['SERVER_NAME_EXPLAIN'] = 'The domain name from which this board runs';
$lang['SCRIPT_PATH'] = 'Script path';
$lang['SCRIPT_PATH_EXPLAIN'] = 'The path where phpBB2 is located relative to the domain name';
$lang['SERVER_PORT'] = 'Server Port';
$lang['SERVER_PORT_EXPLAIN'] = 'The port your server is running on, usually 80. Only change if different';
$lang['SITE_NAME'] = 'Site name';
$lang['SITE_DESC'] = 'Site description';
$lang['BOARD_DISABLE'] = 'Disable board';
$lang['BOARD_DISABLE_EXPLAIN'] = 'This will make the board unavailable to users. Administrators are able to access the Administration Panel while the board is disabled.';
$lang['ACCT_ACTIVATION'] = 'Enable account activation';
$lang['ACC_NONE'] = 'None'; // These three entries are the type of activation
$lang['ACC_USER'] = 'User';
$lang['ACC_ADMIN'] = 'Admin';

$lang['ABILITIES_SETTINGS'] = 'User and Forum Basic Settings';
$lang['MAX_POLL_OPTIONS'] = 'Max number of poll options';
$lang['FLOOD_INTERVAL'] = 'Flood Interval';
$lang['FLOOD_INTERVAL_EXPLAIN'] = 'Number of seconds a user must wait between posts';
$lang['BOARD_EMAIL_FORM'] = 'User email via board';
$lang['BOARD_EMAIL_FORM_EXPLAIN'] = 'Users send email to each other via this board';
$lang['TOPICS_PER_PAGE'] = 'Topics Per Page';
$lang['POSTS_PER_PAGE'] = 'Posts Per Page';
$lang['HOT_THRESHOLD'] = 'Posts for Popular Threshold';
$lang['DEFAULT_STYLE'] = 'Default Style';
$lang['OVERRIDE_STYLE'] = 'Override user style';
$lang['OVERRIDE_STYLE_EXPLAIN'] = 'Replaces users style with the default';
$lang['DEFAULT_LANGUAGE'] = 'Default Language';
$lang['DATE_FORMAT'] = 'Date Format';
$lang['SYSTEM_TIMEZONE'] = 'System Timezone';
$lang['ENABLE_GZIP'] = 'Enable GZip Compression';
$lang['ENABLE_PRUNE'] = 'Enable Forum Pruning';
$lang['ALLOW_HTML'] = 'Allow HTML';
$lang['ALLOW_BBCODE'] = 'Allow BBCode';
$lang['ALLOWED_TAGS'] = 'Allowed HTML tags';
$lang['ALLOWED_TAGS_EXPLAIN'] = 'Separate tags with commas';
$lang['ALLOW_SMILIES'] = 'Allow Smilies';
$lang['SMILIES_PATH'] = 'Smilies Storage Path';
$lang['SMILIES_PATH_EXPLAIN'] = 'Path under your phpBB root dir, e.g. images/smiles';
$lang['ALLOW_SIG'] = 'Allow Signatures';
$lang['MAX_SIG_LENGTH'] = 'Maximum signature length';
$lang['MAX_SIG_LENGTH_EXPLAIN'] = 'Maximum number of characters in user signatures';
$lang['ALLOW_NAME_CHANGE'] = 'Allow Username changes';

$lang['AVATAR_SETTINGS'] = 'Avatar Settings';
$lang['ALLOW_LOCAL'] = 'Enable gallery avatars';
$lang['ALLOW_REMOTE'] = 'Enable remote avatars';
$lang['ALLOW_REMOTE_EXPLAIN'] = 'Avatars linked to from another website';
$lang['ALLOW_UPLOAD'] = 'Enable avatar uploading';
$lang['MAX_FILESIZE'] = 'Maximum Avatar File Size';
$lang['MAX_FILESIZE_EXPLAIN'] = 'For uploaded avatar files';
$lang['MAX_AVATAR_SIZE'] = 'Maximum Avatar Dimensions';
$lang['MAX_AVATAR_SIZE_EXPLAIN'] = '(Height x Width in pixels)';
$lang['AVATAR_STORAGE_PATH'] = 'Avatar Storage Path';
$lang['AVATAR_STORAGE_PATH_EXPLAIN'] = 'Path under your phpBB root dir, e.g. images/avatars';
$lang['AVATAR_GALLERY_PATH'] = 'Avatar Gallery Path';
$lang['AVATAR_GALLERY_PATH_EXPLAIN'] = 'Path under your phpBB root dir for pre-loaded images, e.g. images/avatars/gallery';

$lang['COPPA_SETTINGS'] = 'COPPA Settings';
$lang['COPPA_FAX'] = 'COPPA Fax Number';
$lang['COPPA_MAIL'] = 'COPPA Mailing Address';
$lang['COPPA_MAIL_EXPLAIN'] = 'This is the mailing address to which parents will send COPPA registration forms';

$lang['EMAIL_SETTINGS'] = 'Email Settings';
$lang['ADMIN_EMAIL'] = 'Admin Email Address';
$lang['EMAIL_SIG'] = 'Email Signature';
$lang['EMAIL_SIG_EXPLAIN'] = 'This text will be attached to all emails the board sends';
$lang['USE_SMTP'] = 'Use SMTP Server for email';
$lang['USE_SMTP_EXPLAIN'] = 'Say yes if you want or have to send email via a named server instead of the local mail function';
$lang['SMTP_SERVER'] = 'SMTP Server Address';
$lang['SMTP_USERNAME'] = 'SMTP Username';
$lang['SMTP_USERNAME_EXPLAIN'] = 'Only enter a username if your SMTP server requires it';
$lang['SMTP_PASSWORD'] = 'SMTP Password';
$lang['SMTP_PASSWORD_EXPLAIN'] = 'Only enter a password if your SMTP server requires it';

$lang['DISABLE_PRIVMSG'] = 'Private Messaging';
$lang['INBOX_LIMITS'] = 'Max posts in Inbox';
$lang['SENTBOX_LIMITS'] = 'Max posts in Sentbox';
$lang['SAVEBOX_LIMITS'] = 'Max posts in Savebox';

$lang['COOKIE_SETTINGS'] = 'Cookie settings';
$lang['COOKIE_SETTINGS_EXPLAIN'] = 'These details define how cookies are sent to your users\' browsers. In most cases the default values for the cookie settings should be sufficient, but if you need to change them do so with care -- incorrect settings can prevent users from logging in';
$lang['COOKIE_DOMAIN'] = 'Cookie domain';
$lang['COOKIE_NAME'] = 'Cookie name';
$lang['COOKIE_PATH'] = 'Cookie path';
$lang['COOKIE_SECURE'] = 'Cookie secure';
$lang['COOKIE_SECURE_EXPLAIN'] = 'If your server is running via SSL, set this to enabled, else leave as disabled';
$lang['SESSION_LENGTH'] = 'Session length [ seconds ]';

// Visual Confirmation//
$lang['VISUAL_CONFIRM'] = 'Enable Visual Confirmation';
$lang['VISUAL_CONFIRM_EXPLAIN'] = 'Requires users enter a code defined by an image when registering.';

////
// Forum Management//
////
$lang['FORUM_ADMIN'] = 'Forum Administration';
$lang['FORUM_ADMIN_EXPLAIN'] = 'From this panel you can add, delete, edit, re-order and re-synchronise categories and forums';
$lang['EDIT_FORUM'] = 'Edit forum';
$lang['CREATE_FORUM'] = 'Create new forum';
$lang['CREATE_CATEGORY'] = 'Create new category';
$lang['REMOVE'] = 'Remove';
$lang['ACTION'] = 'Action';
$lang['UPDATE_ORDER'] = 'Update Order';
$lang['CONFIG_UPDATED'] = 'Forum Configuration Updated Successfully';
$lang['EDIT'] = 'Edit';
$lang['DELETE'] = 'Delete';
$lang['MOVE_UP'] = 'Move up';
$lang['MOVE_DOWN'] = 'Move down';
$lang['RESYNC'] = 'Resync';
$lang['NO_MODE'] = 'No mode was set';
$lang['FORUM_EDIT_DELETE_EXPLAIN'] = 'The form below will allow you to customize all the general board options. For User and Forum configurations use the related links on the left hand side';

$lang['MOVE_CONTENTS'] = 'Move all contents';
$lang['FORUM_DELETE'] = 'Delete Forum';
$lang['FORUM_DELETE_EXPLAIN'] = 'The form below will allow you to delete a forum (or category) and decide where you want to put all topics (or forums) it contained.';

$lang['STATUS_LOCKED'] = 'Locked';
$lang['STATUS_UNLOCKED'] = 'Unlocked';
$lang['FORUM_SETTINGS'] = 'General Forum Settings';
$lang['FORUM_NAME'] = 'Forum name';
$lang['FORUM_DESC'] = 'Description';
$lang['FORUM_STATUS'] = 'Forum status';
$lang['FORUM_PRUNING'] = 'Auto-pruning';

$lang['PRUNE_FREQ'] = 'Check for topic age every';
$lang['PRUNE_DAYS'] = 'Remove topics that have not been posted to in';
$lang['SET_PRUNE_DATA'] = 'You have turned on auto-prune for this forum but did not set a frequency or number of days to prune. Please go back and do so.';

$lang['MOVE_AND_DELETE'] = 'Move and Delete';

$lang['DELETE_ALL_POSTS'] = 'Delete all posts';
$lang['NOWHERE_TO_MOVE'] = 'Nowhere to move to';

$lang['EDIT_CATEGORY'] = 'Edit Category';
$lang['EDIT_CATEGORY_EXPLAIN'] = 'Use this form to modify a category\'s name.';

$lang['FORUMS_UPDATED'] = 'Forum and Category information updated successfully';

$lang['MUST_DELETE_FORUMS'] = 'You need to delete all forums before you can delete this category';

$lang['CLICK_RETURN_FORUMADMIN'] = 'Click %sHere%s to return to Forum Administration';


////
// Smiley Management//
////
$lang['SMILEY_TITLE'] = 'Smiles Editing Utility';
$lang['SMILE_DESC'] = 'From this page you can add, remove and edit the emoticons or smileys that your users can use in their posts and private messages.';

$lang['SMILEY_CONFIG'] = 'Smiley Configuration';
$lang['SMILEY_CODE'] = 'Smiley Code';
$lang['SMILEY_URL'] = 'Smiley Image File';
$lang['SMILEY_EMOT'] = 'Smiley Emotion';
$lang['SMILE_ADD'] = 'Add a new Smiley';
$lang['SMILE'] = 'Smile';
$lang['EMOTION'] = 'Emotion';

$lang['SELECT_PAK'] = 'Select Pack (.pak) File';
$lang['REPLACE_EXISTING'] = 'Replace Existing Smiley';
$lang['KEEP_EXISTING'] = 'Keep Existing Smiley';
$lang['SMILEY_IMPORT_INST'] = 'You should unzip the smiley package and upload all files to the appropriate Smiley directory for your installation. Then select the correct information in this form to import the smiley pack.';
$lang['SMILEY_IMPORT'] = 'Smiley Pack Import';
$lang['CHOOSE_SMILE_PAK'] = 'Choose a Smile Pack .pak file';
$lang['IMPORT'] = 'Import Smileys';
$lang['SMILE_CONFLICTS'] = 'What should be done in case of conflicts';
$lang['DEL_EXISTING_SMILEYS'] = 'Delete existing smileys before import';
$lang['IMPORT_SMILE_PACK'] = 'Import Smiley Pack';
$lang['EXPORT_SMILE_PACK'] = 'Create Smiley Pack';
$lang['EXPORT_SMILES'] = 'To create a smiley pack from your currently installed smileys, click %sHere%s to download the smiles.pak file. Name this file appropriately making sure to keep the .pak file extension.  Then create a zip file containing all of your smiley images plus this .pak configuration file.';

$lang['SMILEY_ADD_SUCCESS'] = 'The Smiley was successfully added';
$lang['SMILEY_EDIT_SUCCESS'] = 'The Smiley was successfully updated';
$lang['SMILEY_IMPORT_SUCCESS'] = 'The Smiley Pack was imported successfully!';
$lang['SMILEY_DEL_SUCCESS'] = 'The Smiley was successfully removed';
$lang['CLICK_RETURN_SMILEADMIN'] = 'Click %sHere%s to return to Smiley Administration';


////
// User Management//
////
$lang['USER_ADMIN'] = 'User Administration';
$lang['USER_ADMIN_EXPLAIN'] = 'Here you can change your users\' information and certain options. To modify the users\' permissions, please use the user and group permissions system.';

$lang['LOOK_UP_USER'] = 'Look up user';

$lang['ADMIN_USER_FAIL'] = 'Couldn\'t update the user\'s profile.';
$lang['ADMIN_USER_UPDATED'] = 'The user\'s profile was successfully updated.';
$lang['CLICK_RETURN_USERADMIN'] = 'Click %sHere%s to return to User Administration';

$lang['USER_DELETE'] = 'Delete this user';
$lang['USER_DELETE_EXPLAIN'] = 'Click here to delete this user; this cannot be undone.';
$lang['USER_DELETED'] = 'User was successfully deleted.';

$lang['USER_STATUS'] = 'User is active';
$lang['USER_ALLOWPM'] = 'Can send Private Messages';
$lang['USER_ALLOWAVATAR'] = 'Can display avatar';

$lang['ADMIN_AVATAR_EXPLAIN'] = 'Here you can see and delete the user\'s current avatar.';

$lang['USER_SPECIAL'] = 'Special admin-only fields';
$lang['USER_SPECIAL_EXPLAIN'] = 'These fields are not able to be modified by the users.  Here you can set their status and other options that are not given to users.';


////
// Group Management//
////
$lang['GROUP_ADMINISTRATION'] = 'Group Administration';
$lang['GROUP_ADMIN_EXPLAIN'] = 'From this panel you can administer all your usergroups. You can delete, create and edit existing groups. You may choose moderators, toggle open/closed group status and set the group name and description';
$lang['ERROR_UPDATING_GROUPS'] = 'There was an error while updating the groups';
$lang['UPDATED_GROUP'] = 'The group was successfully updated';
$lang['ADDED_NEW_GROUP'] = 'The new group was successfully created';
$lang['DELETED_GROUP'] = 'The group was successfully deleted';
$lang['NEW_GROUP'] = 'Create new group';
$lang['EDIT_GROUP'] = 'Edit group';
$lang['GROUP_NAME'] = 'Group name';
$lang['GROUP_DESCRIPTION'] = 'Group description';
$lang['GROUP_MODERATOR'] = 'Group moderator';
$lang['GROUP_STATUS'] = 'Group status';
$lang['GROUP_OPEN'] = 'Open group';
$lang['GROUP_CLOSED'] = 'Closed group';
$lang['GROUP_HIDDEN'] = 'Hidden group';
$lang['GROUP_DELETE'] = 'Delete group';
$lang['GROUP_DELETE_CHECK'] = 'Delete this group';
$lang['SUBMIT_GROUP_CHANGES'] = 'Submit Changes';
$lang['RESET_GROUP_CHANGES'] = 'Reset Changes';
$lang['NO_GROUP_NAME'] = 'You must specify a name for this group';
$lang['NO_GROUP_MODERATOR'] = 'You must specify a moderator for this group';
$lang['NO_GROUP_MODE'] = 'You must specify a mode for this group, open or closed';
$lang['NO_GROUP_ACTION'] = 'No action was specified';
$lang['DELETE_GROUP_MODERATOR'] = 'Delete the old group moderator?';
$lang['DELETE_MODERATOR_EXPLAIN'] = 'If you\'re changing the group moderator, check this box to remove the old moderator from the group.  Otherwise, do not check it, and the user will become a regular member of the group.';
$lang['CLICK_RETURN_GROUPSADMIN'] = 'Click %sHere%s to return to Group Administration.';
$lang['SELECT_GROUP'] = 'Select a group';
$lang['LOOK_UP_GROUP'] = 'Look up group';


////
// Prune Administration//
////
$lang['FORUM_PRUNE'] = 'Forum Prune';
$lang['FORUM_PRUNE_EXPLAIN'] = 'This will delete any topic which has not been posted to within the number of days you select. If you do not enter a number then all topics will be deleted. It will not remove topics in which polls are still running nor will it remove announcements. You will need to remove those topics manually.';
$lang['DO_PRUNE'] = 'Do Prune';
$lang['ALL_FORUMS'] = 'All Forums';
$lang['PRUNE_TOPICS_NOT_POSTED'] = 'Prune topics with no replies in this many days';
$lang['TOPICS_PRUNED'] = 'Topics pruned';
$lang['POSTS_PRUNED'] = 'Posts pruned';
$lang['PRUNE_SUCCESS'] = 'Pruning of forums was successful';


////
// Word censor//
////
$lang['WORDS_TITLE'] = 'Word Censoring';
$lang['WORDS_EXPLAIN'] = 'From this control panel you can add, edit, and remove words that will be automatically censored on your forums. In addition people will not be allowed to register with usernames containing these words. Wildcards (*) are accepted in the word field. For example, *test* will match detestable, test* would match testing, *test would match detest.';
$lang['WORD'] = 'Word';
$lang['EDIT_WORD_CENSOR'] = 'Edit word censor';
$lang['REPLACEMENT'] = 'Replacement';
$lang['ADD_NEW_WORD'] = 'Add new word';
$lang['UPDATE_WORD'] = 'Update word censor';

$lang['MUST_ENTER_WORD'] = 'You must enter a word and its replacement';
$lang['NO_WORD_SELECTED'] = 'No word selected for editing';

$lang['WORD_UPDATED'] = 'The selected word censor has been successfully updated';
$lang['WORD_ADDED'] = 'The word censor has been successfully added';
$lang['WORD_REMOVED'] = 'The selected word censor has been successfully removed';

$lang['CLICK_RETURN_WORDADMIN'] = 'Click %sHere%s to return to Word Censor Administration';


////
// Mass Email//
////
$lang['MASS_EMAIL_EXPLAIN'] = 'Here you can email a message to either all of your users or all users of a specific group.  To do this, an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. If you are emailing a large group of people please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time and you will be notified when the script has completed';
$lang['COMPOSE'] = 'Compose';

$lang['RECIPIENTS'] = 'Recipients';
$lang['ALL_USERS'] = 'All Users';

$lang['EMAIL_SUCCESSFULL'] = 'Your message has been sent';
$lang['CLICK_RETURN_MASSEMAIL'] = 'Click %sHere%s to return to the Mass Email form';


////
// Ranks admin//
////
$lang['RANKS_TITLE'] = 'Rank Administration';
$lang['RANKS_EXPLAIN'] = 'Using this form you can add, edit, view and delete ranks. You can also create custom ranks which can be applied to a user via the user management facility';

$lang['ADD_NEW_RANK'] = 'Add new rank';

$lang['RANK_TITLE'] = 'Rank Title';
$lang['RANK_SPECIAL'] = 'Set as Special Rank';
$lang['RANK_MINIMUM'] = 'Minimum Posts';
$lang['RANK_MAXIMUM'] = 'Maximum Posts';
$lang['RANK_IMAGE'] = 'Rank Image (Relative to phpBB2 root path)';
$lang['RANK_IMAGE_EXPLAIN'] = 'Use this to define a small image associated with the rank';

$lang['MUST_SELECT_RANK'] = 'You must select a rank';
$lang['NO_ASSIGNED_RANK'] = 'No special rank assigned';

$lang['RANK_UPDATED'] = 'The rank was successfully updated';
$lang['RANK_ADDED'] = 'The rank was successfully added';
$lang['RANK_REMOVED'] = 'The rank was successfully deleted';
$lang['NO_UPDATE_RANKS'] = 'The rank was successfully deleted. However, user accounts using this rank were not updated.  You will need to manually reset the rank on these accounts';

$lang['CLICK_RETURN_RANKADMIN'] = 'Click %sHere%s to return to Rank Administration';
// FLAGHACK-start//
////
// Flags admin//
////
$lang['FLAGS_TITLE'] = 'Flag Administration';
$lang['FLAGS_EXPLAIN'] = 'Using this form you can add, edit, view and delete flags. You can also create custom flags which can be applied to a user via the user management facility';

$lang['ADD_NEW_FLAG'] = 'Add new flag';

$lang['FLAG_NAME'] = 'Flag Name';
$lang['FLAG_PIC'] = 'Image';
$lang['FLAG_IMAGE'] = 'Flag Image (in the images/flags/ directory)';
$lang['FLAG_IMAGE_EXPLAIN'] = 'Use this to define a small image associated with the flag';

$lang['MUST_SELECT_FLAG'] = 'You must select a flag';
$lang['FLAG_UPDATED'] = 'The flag was successfully updated';
$lang['FLAG_ADDED'] = 'The flag was successfully added';
$lang['FLAG_REMOVED'] = 'The flag was successfully deleted';
$lang['NO_UPDATE_FLAGS'] = 'The flag was successfully deleted. However, user accounts using this flag were not updated.  You will need to manually reset the flag on these accounts';

$lang['FLAG_CONFIRM'] = 'Delete Flag' ;
$lang['CONFIRM_DELETE_FLAG'] = 'Are you sure you want to remove the selected flag?' ;

$lang['CLICK_RETURN_FLAGADMIN'] = 'Click %sHere%s to return to Flag Administration';
// FLAGHACK-end//


////
// Disallow Username Admin//
////
$lang['DISALLOW_CONTROL'] = 'Username Disallow Control';
$lang['DISALLOW_EXPLAIN'] = 'Here you can control usernames which will not be allowed to be used.  Disallowed usernames are allowed to contain a wildcard character of *.  Please note that you will not be allowed to specify any username that has already been registered. You must first delete that name then disallow it.';

$lang['DELETE_DISALLOW'] = 'Delete';
$lang['DELETE_DISALLOW_TITLE'] = 'Remove a Disallowed Username';
$lang['DELETE_DISALLOW_EXPLAIN'] = 'You can remove a disallowed username by selecting the username from this list and clicking submit';

$lang['ADD_DISALLOW'] = 'Add';
$lang['ADD_DISALLOW_TITLE'] = 'Add a disallowed username';
$lang['ADD_DISALLOW_EXPLAIN'] = 'You can disallow a username using the wildcard character * to match any character';

$lang['NO_DISALLOWED'] = 'No Disallowed Usernames';

$lang['DISALLOWED_DELETED'] = 'The disallowed username has been successfully removed';
$lang['DISALLOW_SUCCESSFUL'] = 'The disallowed username has been successfully added';
$lang['DISALLOWED_ALREADY'] = 'The name you entered could not be disallowed. It either already exists in the list, exists in the word censor list, or a matching username is present.';

$lang['CLICK_RETURN_DISALLOWADMIN'] = 'Click %sHere%s to return to Disallow Username Administration';


////
// Styles Admin//
////
$lang['STYLES_ADMIN'] = 'Styles Administration';
$lang['STYLES_EXPLAIN'] = 'Using this facility you can add, remove and manage styles (templates and themes) available to your users';
$lang['STYLES_ADDNEW_EXPLAIN'] = 'The following list contains all the themes that are available for the templates you currently have. The items on this list have not yet been installed into the phpBB database. To install a theme, simply click the install link beside an entry.';

$lang['SELECT_TEMPLATE'] = 'Select a Template';

$lang['STYLE'] = 'Style';
$lang['TEMPLATE'] = 'Template';
$lang['INSTALL'] = 'Install';
$lang['DOWNLOAD'] = 'Download';

$lang['EDIT_THEME'] = 'Edit Theme';
$lang['EDIT_THEME_EXPLAIN'] = 'In the form below you can edit the settings for the selected theme';

$lang['CREATE_THEME'] = 'Create Theme';
$lang['CREATE_THEME_EXPLAIN'] = 'Use the form below to create a new theme for a selected template. When entering colours (for which you should use hexadecimal notation) you must not include the initial #, i.e.. CCCCCC is valid, #CCCCCC is not';

$lang['EXPORT_THEMES'] = 'Export Themes';
$lang['EXPORT_EXPLAIN'] = 'In this panel you will be able to export the theme data for a selected template. Select the template from the list below and the script will create the theme configuration file and attempt to save it to the selected template directory. If it cannot save the file itself it will give you the option to download it. In order for the script to save the file you must give write access to the webserver for the selected template dir. For more information on this see the phpBB 2 users guide.';

$lang['THEME_INSTALLED'] = 'The selected theme has been installed successfully';
$lang['STYLE_REMOVED'] = 'The selected style has been removed from the database. To fully remove this style from your system you must delete the appropriate style from your templates directory.';
$lang['THEME_INFO_SAVED'] = 'The theme information for the selected template has been saved. You should now return the permissions on the theme_info.cfg (and if applicable the selected template directory) to read-only';
$lang['THEME_UPDATED'] = 'The selected theme has been updated. You should now export the new theme settings';
$lang['THEME_CREATED'] = 'Theme created. You should now export the theme to the theme configuration file for safe keeping or use elsewhere';

$lang['CONFIRM_DELETE_STYLE'] = 'Are you sure you want to delete this style?';

$lang['DOWNLOAD_THEME_CFG'] = 'The exporter could not write the theme information file. Click the button below to download this file with your browser. Once you have downloaded it you can transfer it to the directory containing the template files. You can then package the files for distribution or use elsewhere if you desire';
$lang['NO_THEMES'] = 'The template you selected has no themes attached to it. To create a new theme click the Create New link on the left hand panel';
$lang['NO_TEMPLATE_DIR'] = 'Could not open the template directory. It may be unreadable by the webserver or may not exist';
$lang['CANNOT_REMOVE_STYLE'] = 'You cannot remove the style selected since it is currently the forum default. Please change the default style and try again.';
$lang['STYLE_EXISTS'] = 'The style name to selected already exists, please go back and choose a different name.';

$lang['CLICK_RETURN_STYLEADMIN'] = 'Click %sHere%s to return to Style Administration';

$lang['THEME_SETTINGS'] = 'Theme Settings';
$lang['THEME_ELEMENT'] = 'Theme Element';
$lang['SIMPLE_NAME'] = 'Simple Name';
$lang['VALUE'] = 'Value';
$lang['SAVE_SETTINGS'] = 'Save Settings';

$lang['STYLESHEET'] = 'CSS Stylesheet';
$lang['BACKGROUND_IMAGE'] = 'Background Image';
$lang['BACKGROUND_COLOR'] = 'Background Colour';
$lang['THEME_NAME'] = 'Theme Name';
$lang['LINK_COLOR'] = 'Link Colour';
$lang['TEXT_COLOR'] = 'Text Colour';
$lang['VLINK_COLOR'] = 'Visited Link Colour';
$lang['ALINK_COLOR'] = 'Active Link Colour';
$lang['HLINK_COLOR'] = 'Hover Link Colour';
$lang['TR_COLOR1'] = 'Table Row Colour 1';
$lang['TR_COLOR2'] = 'Table Row Colour 2';
$lang['TR_COLOR3'] = 'Table Row Colour 3';
$lang['TR_CLASS1'] = 'Table Row Class 1';
$lang['TR_CLASS2'] = 'Table Row Class 2';
$lang['TR_CLASS3'] = 'Table Row Class 3';
$lang['TH_COLOR1'] = 'Table Header Colour 1';
$lang['TH_COLOR2'] = 'Table Header Colour 2';
$lang['TH_COLOR3'] = 'Table Header Colour 3';
$lang['TH_CLASS1'] = 'Table Header Class 1';
$lang['TH_CLASS2'] = 'Table Header Class 2';
$lang['TH_CLASS3'] = 'Table Header Class 3';
$lang['TD_COLOR1'] = 'Table Cell Colour 1';
$lang['TD_COLOR2'] = 'Table Cell Colour 2';
$lang['TD_COLOR3'] = 'Table Cell Colour 3';
$lang['TD_CLASS1'] = 'Table Cell Class 1';
$lang['TD_CLASS2'] = 'Table Cell Class 2';
$lang['TD_CLASS3'] = 'Table Cell Class 3';
$lang['FONTFACE1'] = 'Font Face 1';
$lang['FONTFACE2'] = 'Font Face 2';
$lang['FONTFACE3'] = 'Font Face 3';
$lang['FONTSIZE1'] = 'Font Size 1';
$lang['FONTSIZE2'] = 'Font Size 2';
$lang['FONTSIZE3'] = 'Font Size 3';
$lang['FONTCOLOR1'] = 'Font Colour 1';
$lang['FONTCOLOR2'] = 'Font Colour 2';
$lang['FONTCOLOR3'] = 'Font Colour 3';
$lang['SPAN_CLASS1'] = 'Span Class 1';
$lang['SPAN_CLASS2'] = 'Span Class 2';
$lang['SPAN_CLASS3'] = 'Span Class 3';
$lang['IMG_POLL_SIZE'] = 'Polling Image Size [px]';
$lang['IMG_PM_SIZE'] = 'Private Message Status size [px]';


////
// Install Process//
////
$lang['WELCOME_INSTALL'] = 'Welcome to phpBB 2 Installation';
$lang['INITIAL_CONFIG'] = 'Basic Configuration';
$lang['DB_CONFIG'] = 'Database Configuration';
$lang['ADMIN_CONFIG'] = 'Admin Configuration';
$lang['CONTINUE_UPGRADE'] = 'Once you have downloaded your config file to your local machine you may\'Continue Upgrade\' button below to move forward with the upgrade process.  Please wait to upload the config file until the upgrade process is complete.';
$lang['UPGRADE_SUBMIT'] = 'Continue Upgrade';

$lang['INSTALLER_ERROR'] = 'An error has occurred during installation';
$lang['PREVIOUS_INSTALL'] = 'A previous installation has been detected';
$lang['INSTALL_DB_ERROR'] = 'An error occurred trying to update the database';

$lang['RE_INSTALL'] = 'Your previous installation is still active.<br /><br />If you would like to re-install phpBB 2 you should click the Yes button below. Please be aware that doing so will destroy all existing data and no backups will be made! The administrator username and password you have used to login in to the board will be re-created after the re-installation and no other settings will be retained.<br /><br />Think carefully before pressing Yes!';

$lang['INST_STEP_0'] = 'Thank you for choosing phpBB 2. In order to complete this install please fill out the details requested below. Please note that the database you install into should already exist. If you are installing to a database that uses ODBC, e.g. MS Access you should first create a DSN for it before proceeding.';

$lang['START_INSTALL'] = 'Start Install';
$lang['FINISH_INSTALL'] = 'Finish Installation';

$lang['DEFAULT_LANG'] = 'Default board language';
$lang['DB_HOST'] = 'Database Server Hostname / DSN';
$lang['DB_NAME'] = 'Your Database Name';
$lang['DB_USERNAME'] = 'Database Username';
$lang['DB_PASSWORD'] = 'Database Password';
$lang['DATABASE'] = 'Your Database';
$lang['INSTALL_LANG'] = 'Choose Language for Installation';
$lang['DBMS'] = 'Database Type';
$lang['TABLE_PREFIX'] = 'Prefix for tables in database';
$lang['ADMIN_USERNAME'] = 'Administrator Username';
$lang['ADMIN_PASSWORD'] = 'Administrator Password';
$lang['ADMIN_PASSWORD_CONFIRM'] = 'Administrator Password [ Confirm ]';

$lang['INST_STEP_2'] = 'Your admin username has been created.  At this point your basic installation is complete. You will now be taken to a screen which will allow you to administer your new installation. Please be sure to check the General Configuration details and make any required changes. Thank you for choosing phpBB 2.';

$lang['UNWRITEABLE_CONFIG'] = 'Your config file is un-writeable at present. A copy of the config file will be downloaded to your computer when you click the button below. You should upload this file to the same directory as phpBB 2. Once this is done you should log in using the administrator name and password you provided on the previous form and visit the admin control center (a link will appear at the bottom of each screen once logged in) to check the general configuration. Thank you for choosing phpBB 2.';
$lang['DOWNLOAD_CONFIG'] = 'Download Config';

$lang['FTP_CHOOSE'] = 'Choose Download Method';
$lang['FTP_OPTION'] = '<br />Since FTP extensions are enabled in this version of PHP you may also be given the option of first trying to automatically FTP the config file into place.';
$lang['FTP_INSTRUCTS'] = 'You have chosen to FTP the file to the account containing phpBB 2 automatically.  Please enter the information below to facilitate this process. Note that the FTP path should be the exact path via FTP to your phpBB2 installation as if you were FTPing to it using any normal client.';
$lang['FTP_INFO'] = 'Enter Your FTP Information';
$lang['ATTEMPT_FTP'] = 'Attempt to FTP config file into place';
$lang['SEND_FILE'] = 'Just send the file to me and I\'ll FTP it manually';
$lang['FTP_PATH'] = 'FTP path to phpBB 2';
$lang['FTP_USERNAME'] = 'Your FTP Username';
$lang['FTP_PASSWORD'] = 'Your FTP Password';
$lang['TRANSFER_CONFIG'] = 'Start Transfer';
$lang['NOFTP_CONFIG'] = 'The attempt to FTP the config file into place failed.  Please download the config file and FTP it into place manually.';

$lang['INSTALL'] = 'Install';
$lang['UPGRADE'] = 'Upgrade';


$lang['INSTALL_METHOD'] = 'Choose your installation method';

$lang['INSTALL_NO_EXT'] = 'The PHP configuration on your server doesn\'t support the database type that you chose';

$lang['INSTALL_NO_PCRE'] = 'phpBB2 Requires the Perl-Compatible Regular Expressions Module for PHP which your PHP configuration doesn\'t appear to support!';

////
// Version Check//
////
$lang['VERSION_UP_TO_DATE'] = 'Your installation is up to date, no updates are available for your version of phpBB.';
$lang['VERSION_NOT_UP_TO_DATE'] = 'Your installation does <b>not</b> seem to be up to date. Updates are available for your version of phpBB, please visit <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> to obtain the latest version.';
$lang['LATEST_VERSION_INFO'] = 'The latest available version is <b>phpBB %s</b>.';
$lang['CURRENT_VERSION_INFO'] = 'You are running <b>phpBB %s</b>.';
$lang['CONNECT_SOCKET_ERROR'] = 'Unable to open connection to phpBB Server, reported error is:<br />%s';
$lang['SOCKET_FUNCTIONS_DISABLED'] = 'Unable to use socket functions.';
$lang['MAILING_LIST_SUBSCRIBE_REMINDER'] = 'For the latest information on updates to phpBB, why not <a href="http://www.phpbb.com/support/" target="_new">subscribe to our mailing list</a>.';
$lang['VERSION_INFORMATION'] = 'Version Information';

////
// That's all Folks!//
// -------------------------------------------------//

//sf//SF
$lang['SF_SHOW_ON_INDEX'] = 'Show on main page';
$lang['SF_PARENT_FORUM'] = 'Parent forum';
$lang['SF_NO_PARENT'] = 'No parent forum';
//sf end//SF

// Added by Permissions List MOD//
$lang['PERMISSIONS_LIST'] = 'Permissions List';
$lang['AUTH_CONTROL_CATEGORY'] = 'Category Permissions Control';
$lang['FORUM_AUTH_LIST_EXPLAIN'] = 'This provides a summary of the authorisation levels of each forum. You can edit these permissions, using either a simple or advanced method by clicking on the forum name. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';
$lang['CAT_AUTH_LIST_EXPLAIN'] = 'This provides a summary of the authorisation levels of each forum within this category. You can edit the permissions of individual forums, using either a simple or advanced method by clicking on the forum name. Alternatively, you can set the permissions for all the forums in this category by using the drop-down menus at the bottom of the page. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';
$lang['FORUM_AUTH_LIST_EXPLAIN_ALL'] = 'All users';
$lang['FORUM_AUTH_LIST_EXPLAIN_REG'] = 'All registered users';
$lang['FORUM_AUTH_LIST_EXPLAIN_PRIVATE'] = 'Only users granted special permission';
$lang['FORUM_AUTH_LIST_EXPLAIN_MOD'] = 'Only moderators of this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_ADMIN'] = 'Only administrators';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_VIEW'] = '%s can view this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_READ'] = '%s can read posts in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_POST'] = '%s can post in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_REPLY'] = '%s can reply to posts this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_EDIT'] = '%s can edit posts in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_DELETE'] = '%s can delete posts in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_STICKY'] = '%s can post sticky topics in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_ANNOUNCE'] = '%s can post announcements in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_VOTE'] = '%s can vote in polls in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_POLLCREATE'] = '%s can create polls in this forum';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_ATTACHMENTS'] = '%s can post attachments';
$lang['FORUM_AUTH_LIST_EXPLAIN_AUTH_DOWNLOAD'] = '%s can download attachments';
// End addition by Permissions List MOD

?>