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

/* $Id: constants.inc.php,v 1.50 2005-03-06 23:36:41 decoyduck Exp $ */

// Beehive Version

define("BEEHIVE_VERSION", "0.6-CVS");

// Constants for date / time.

define("YEAR_IN_SECONDS", 31536000);
define("DAY_IN_SECONDS", 86400);
define("HOUR_IN_SECONDS", 3600);

// Constants for database stuff

define("DB_RESULT_ASSOC", 1);
define("DB_RESULT_NUM",   2);
define("DB_RESULT_BOTH",  3);

// Some custom error codes for database connectivity

define("DB_ER_NO_EXTENSION",  1000);
define("DB_ER_NO_SUCH_HOST",  1001);
define("DB_ER_NO_SUCH_DBASE", 1002);
define("DB_ER_NO_SUCH_TABLE", 1003);

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

// OLD VALUES - PRE-BH-0.5

//define("PERM_CHECK_WORKER",USER_PERM_WORKER|USER_PERM_SOLDIER|USER_PERM_QUEEN);
//define("PERM_CHECK_SOLDIER",USER_PERM_SOLDIER|USER_PERM_QUEEN);

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

?>