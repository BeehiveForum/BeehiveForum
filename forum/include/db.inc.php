<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: db.inc.php,v 1.79 2008-07-27 18:26:15 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

if (isset($db_extension)) {

    if ($db_extension == 'mysql') {

        include_once(BH_INCLUDE_PATH. "db/db_mysql.inc.php");

    }elseif ($db_extension == 'mysqli') {

        include_once(BH_INCLUDE_PATH. "db/db_mysqli.inc.php");

    }else {

        if (@extension_loaded('mysql')) {

            include_once(BH_INCLUDE_PATH. "db/db_mysql.inc.php");

        }elseif (@extension_loaded('mysqli')) {

            include_once(BH_INCLUDE_PATH. "db/db_mysqli.inc.php");
        }
    }

}else {

    if (@extension_loaded('mysql')) {

        include_once(BH_INCLUDE_PATH. "db/db_mysql.inc.php");

    }elseif (@extension_loaded('mysqli')) {

        include_once(BH_INCLUDE_PATH. "db/db_mysqli.inc.php");
    }
}

if (!function_exists('db_connect')) {
    trigger_error("Could not load mysql or mysqli extension.", E_USER_ERROR);
}

?>