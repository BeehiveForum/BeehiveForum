<?php
// Beehive Constants

define("YEAR_IN_SECONDS",31536000);
define("DAY_IN_SECONDS", 86400);
define("HOUR_IN_SECONDS", 3600);

define("USER_PERM_SPLAT",1);
define("USER_PERM_WASP",2);
define("USER_PERM_WORM",4);
define("USER_PERM_WORKER",8);
define("USER_PERM_SOLDIER",16);
define("USER_PERM_QUEEN",32);

define("USER_FRIEND",1);
define("USER_IGNORED",2);
define("USER_IGNORED_SIG",4);

define("PERM_CHECK_WORKER",USER_PERM_WORKER|USER_PERM_SOLDIER|USER_PERM_QUEEN);
define("PERM_CHECK_SOLDIER",USER_PERM_SOLDIER|USER_PERM_QUEEN);

define("MAX_ATTACHMENT_SIZE", 5242880);

// Constants for Search Dialog Errors

define("SEARCH_USER_NOT_FOUND", 1);
define("SEARCH_NO_KEYWORDS", 2);

// Poll Constants

define("POLL_MULTIVOTE", 2);

// PM Constants

define('PM_NEW', 1);        // New PM
define('PM_UNREAD', 2);     // Unread PM
define('PM_READ', 4);       // Read PM
define('PM_SENT', 8);       // Sent PM
define('PM_SAVED_IN', 16);  // Saved Received PM
define('PM_SAVED_OUT', 32); // Saved Sent PM
define('PM_PREVIEW', 64);   // Previewed Message (pm_write.php)

// PM Folders - defines what can be stored in each folder

define('PM_FOLDER_INBOX',  PM_NEW|PM_UNREAD|PM_READ); // Inbox
define('PM_FOLDER_SENT',   PM_SENT); // Sent Items
define('PM_FOLDER_OUTBOX', PM_NEW|PM_UNREAD); // Outbox
define('PM_FOLDER_SAVED',  PM_SAVED_IN|PM_SAVED_OUT); // Saved Items

// Allowed thread types in folders

define('FOLDER_ALLOW_NORMAL_THREAD', 1);
define('FOLDER_ALLOW_POLL_THREAD', 2);
define('FOLDER_ALLOW_ALL_THREAD', FOLDER_ALLOW_NORMAL_THREAD | FOLDER_ALLOW_POLL_THREAD);
?>