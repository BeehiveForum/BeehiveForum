<?php
// Beehive Constants

define("YEAR_IN_SECONDS",31536000);

define("USER_PERM_SPLAT",1);
define("USER_PERM_WASP",2);
define("USER_PERM_WORM",4);
define("USER_PERM_WORKER",8);
define("USER_PERM_SOLDIER",USER_PERM_WORKER|16);
define("USER_PERM_QUEEN",USER_PERM_SOLDIER|32);

?>
