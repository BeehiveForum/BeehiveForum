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

/* $Id: db.inc.php,v 1.65 2005-03-10 21:17:51 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once("./include/config.inc.php");
}

include_once("./include/constants.inc.php");
include_once("./include/server.inc.php");

if (isset($db_extension)) {

    if ($db_extension == 'mysql') {

        include_once("./include/db/db_mysql.inc.php");

    }elseif ($db_extension == 'mysqli') {

        include_once("./include/db/db_mysqli.inc.php");

    }else {

        if (@extension_loaded('mysql')) {

            include_once("./include/db/db_mysql.inc.php");

        }elseif (@extension_loaded('mysqli')) {

            include_once("./include/db/db_mysqli.inc.php");
        }
    }

}else {

    if (@extension_loaded('mysql')) {

        include_once("./include/db/db_mysql.inc.php");

    }elseif (@extension_loaded('mysqli')) {

        include_once("./include/db/db_mysqli.inc.php");
    }
}

?>