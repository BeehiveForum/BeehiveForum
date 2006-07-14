<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: constants.inc.php,v 1.80 2006-07-14 21:46:13 decoyduck Exp $ */

/**
* Constants used throughout Beehive.
*
* It may well be easier to view the actual file - the layout's better.
*/

/**
*/

// Beehive Version

define("BEEHIVE_VERSION", "0.6-CVS");

// Constants for date / time.

define("YEAR_IN_SECONDS", 31536000);
define("DAY_IN_SECONDS", 86400);
define("HOUR_IN_SECONDS", 3600);
define("MINUTE_IN_SECONDS", 60);

// Constants for database stuff

define("DB_RESULT_ASSOC", 1);
define("DB_RESULT_NUM",   2);
define("DB_RESULT_BOTH",  3);

// Constants for user permissions

define("USER_PERM_BANNED", 1);
define("USER_PERM_WORMED", 2);
define("USER_PERM_POST_READ", 4);
define("USER_PERM_POST_CREATE", 8);
define("USER_PERM_THREAD_CREATE", 16);
define("USER_PERM_POST_EDIT", 32);
define("USER_PERM_POST_DELETE", 64);
define("USER_PERM_POST_ATTACHMENTS", 128);
define("USER_PERM_FOLDER_MODERATE", 256);
define("USER_PERM_ADMIN_TOOLS", 512);
define("USER_PERM_FORUM_TOOLS", 1024);
define("USER_PERM_HTML_POSTING", 2048);
define("USER_PERM_SIGNATURE", 4096);
define("USER_PERM_GUEST_ACCESS", 8192);
define("USER_PERM_POST_APPROVAL", 16384);
define("USER_PERM_LINKS_MODERATE", 32768);
define("USER_PERM_EMAIL_CONFIRM", 65536);
define("USER_PERM_CAN_IGNORE_ADMIN", 131072);
define("USER_PERM_PILLORIED", 262144);

// OLD VALUES - PRE-BH-0.5 - DO NOT USE!

define("USER_PERM_SPLAT",1);
define("USER_PERM_WASP",2);
define("USER_PERM_WORM",4);
define("USER_PERM_WORKER",8);
define("USER_PERM_SOLDIER",16);
define("USER_PERM_QUEEN",32);

define("PERM_CHECK_WORKER", USER_PERM_WORKER|USER_PERM_SOLDIER|USER_PERM_QUEEN);
define("PERM_CHECK_SOLDIER", USER_PERM_SOLDIER|USER_PERM_QUEEN);

// MySQL error codes

define("ER_NO_SUCH_TABLE", 1146);
define("ER_WRONG_COLUMN_NAME", 1166);

// Constants for relationship system

define("USER_FRIEND", 1);
define("USER_IGNORED", 2);
define("USER_IGNORED_SIG", 4);
define("USER_IGNORED_COMPLETELY", 8);

// Constants for error handler

define("BH_DB_CONNECT_ERROR", 32767);

// Constants for Search Dialog Errors

define("SEARCH_USER_NOT_FOUND", 1);
define("SEARCH_NO_KEYWORDS", 2);
define("SEARCH_NO_MATCHES", 3);
define("SEARCH_FREQUENCY_TOO_GREAT", 4);

// Constants for style creation

define("STYLE_ALREADY_EXISTS", 1);
define("STYLE_WRITE_ERROR", 2);

// Constants for post page preferences

define("POST_TOOLBAR_DISPLAY", 1);
define("POST_EMOTICONS_DISPLAY", 2);
define("POST_TEXT_DEFAULT", 4);
define("POST_AUTOHTML_DEFAULT", 8);
define("POST_HTML_DEFAULT", 16);
define("POST_EMOTICONS_DISABLED", 32);
define("POST_AUTO_LINKS", 64);
define("POST_SIGNATURE_DISPLAY", 128);
define("POST_CHECK_SPELLING", 256);
define("POST_TINYMCE_DISPLAY", 512);

// Poll Constants

define("POLL_MULTIVOTE", 2);

// PM Constants

define("PM_UNREAD", 2);     // Unread PM
define("PM_READ", 4);       // Read PM
define("PM_SENT", 8);       // Sent PM
define("PM_SAVED_IN", 16);  // Saved Received PM
define("PM_SAVED_OUT", 32); // Saved Sent PM
define("PM_PREVIEW", 64);   // Previewed Message (pm_write.php)

// PM Folders - defines each folder type

define("PM_FOLDER_INBOX",  1);
define("PM_FOLDER_SENT",   2);
define("PM_FOLDER_OUTBOX", 3);
define("PM_FOLDER_SAVED",  4);

// PM Item types - defines different types of messages

define("PM_INBOX_ITEMS",  PM_UNREAD|PM_READ); // Inbox
define("PM_SENT_ITEMS",   PM_SENT); // Sent Items
define("PM_OUTBOX_ITEMS", PM_UNREAD); // Outbox
define("PM_SAVED_ITEMS",  PM_SAVED_IN|PM_SAVED_OUT); // Saved Items

// Allowed thread types in folders

define("FOLDER_ALLOW_NORMAL_THREAD", 1);
define("FOLDER_ALLOW_POLL_THREAD", 2);
define("FOLDER_ALLOW_ALL_THREAD", FOLDER_ALLOW_NORMAL_THREAD | FOLDER_ALLOW_POLL_THREAD);

// Profile Item Types

define("PROFILE_ITEM_LARGE_TEXT", 0);
define("PROFILE_ITEM_MEDIUM_TEXT", 1);
define("PROFILE_ITEM_SMALL_TEXT", 2);
define("PROFILE_ITEM_MULTI_TEXT", 3);
define("PROFILE_ITEM_RADIO", 4);
define("PROFILE_ITEM_DROPDOWN", 5);

// Admin log ACTIONs

define("CHANGE_USER_STATUS", 1);
define("CHANGE_FORUM_ACCESS", 2);
define("DELETE_ALL_USER_POSTS", 3);
define("BANNED_IPADDRESS", 4);
define("UNBANNED_IPADDRESS", 5);
define("EDIT_THREAD_OPTIONS", 7);
define("MOVED_THREADS", 8);
define("CREATE_FOLDER", 9);
define("DELETE_FOLDER", 10);
define("CHANGE_PROFILE_SECT", 11);
define("ADDED_PROFILE_SECT", 12);
define("DELETE_PROFILE_SECT", 13);
define("CHANGE_PROFILE_ITEM", 14);
define("ADDED_PROFILE_ITEM", 15);
define("DELETE_PROFILE_ITEM", 16);
define("EDITED_START_PAGE", 17);
define("CREATED_NEW_STYLE", 18);
define("MOVED_THREAD", 19);
define("CLOSED_THREAD", 20);
define("OPENED_THREAD", 21);
define("RENAME_THREAD", 22);
define("DELETE_POST", 23);
define("EDIT_POST", 24);
define("EDIT_WORD_FILTER", 25);
define("CREATE_THREAD_STICKY", 26);
define("REMOVE_THREAD_STICKY", 27);
define("END_USER_SESSION", 28);
define("EDIT_GLOBAL_FORUM_SETTINGS", 29);
define("EDIT_FORUM_SETTINGS", 30);
define("LOCKED_THREAD", 31);
define("UNLOCKED_THREAD", 32);
define("DELETE_USER_THREAD_POSTS", 33);
define("DELETE_THREAD", 34);
define("DELETE_ATTACHMENT", 35);
define("EDIT_FORUM_LINKS", 36);
define("APPROVED_POST", 37);
define("CREATE_USER_GROUP", 38);
define("DELETE_USER_GROUP", 39);
define("ADD_USER_TO_GROUP", 40);
define("REMOVE_USER_FROM_GROUP", 41);
define("CHANGE_USER_PASSWD", 42);
define("UPDATE_USER_GROUP", 43);
define("ADD_BANNED_IP", 44);
define("REMOVE_BANNED_IP", 45);
define("ADD_BANNED_LOGON", 46);
define("REMOVE_BANNED_LOGON", 47);
define("ADD_BANNED_NICKNAME", 48);
define("REMOVE_BANNED_NICKNAME", 49);
define("ADD_BANNED_EMAIL", 50);
define("REMOVE_BANNED_EMAIL", 51);
define("ADDED_RSS_FEED", 52);
define("EDITED_RSS_FEED", 53);
define("UNDELETE_THREAD", 54);
define("ADD_BANNED_REFERER", 55);
define("REMOVE_BANNED_REFERER", 56);

// Error codes for Text Captcha

define("TEXT_CAPTCHA_NO_FONTS", 1);
define("TEXT_CAPTCHA_KEY_ERROR", 2);
define("TEXT_CAPTCHA_DIR_ERROR", 3);
define("TEXT_CAPTCHA_GD_ERROR", 4);

// Return codes for Dictionary

define('DICTIONARY_EXACT', 1);
define('DICTIONARY_NOMATCH', 2);
define('DICTIONARY_SUGGEST', 3);

// PM Export constants

define('PM_EXPORT_HTML', 0);
define('PM_EXPORT_XML', 1);
define('PM_EXPORT_PLAINTEXT', 2);
define('PM_EXPORT_SINGLE', 0);
define('PM_EXPORT_MANY', 1);

// Thread Merge and Split constants

define('THREAD_MERGE_START', 0);
define('THREAD_MERGE_END', 1);
define('THREAD_MERGE_BY_CREATED', 2);

define('THREAD_SPLIT_REPLIES', 0);
define('THREAD_SPLIT_FOLLOWING', 1);

?>