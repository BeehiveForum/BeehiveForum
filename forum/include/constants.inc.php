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

define("MAX_ATTACHMENT_SIZE", 1048576);

// Constats for Search Dialog Errors

define("SEARCH_USER_NOT_FOUND", 1);
define("SEARCH_NO_KEYWORDS", 2);

// Constants for Admin Logging

define("ADMIN_USER_PERMS", 1);
define("ADMIN_USER_BAN", 2);

define("ADMIN_FOLDER_ADD", 4);
define("ADMIN_FOLDER_DEL", 8);
define("ADMIN_FOLDER_ACC", 16);

define("ADMIN_PROFILE_ADD_SECT", 32);
define("ADMIN_PROFILE_REM_SECT", 64);

define("ADMIN_PROFILE_ADD_ITEM", 128);
define("ADMIN_PROFILE_REM_ITEM", 256);

define("ADMIN_START_PAGE", 512);
define("ADMIN_CREATE_STYLE", 1024);

?>