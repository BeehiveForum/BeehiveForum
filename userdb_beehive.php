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

/* $Id: userdb_beehive.php,v 1.11 2008-08-12 17:13:46 decoyduck Exp $ */

// Constant to define where the Beehive Forum include files are

define("BH_INCLUDE_PATH", "../forum/include/");

// Beehive Forum configuration.

include_once(BH_INCLUDE_PATH. "config.inc.php");

// Put Ewiki in protected mode and default to view / browse only

define("EWIKI_PROTECTED_MODE", 1);
define("EWIKI_AUTH_DEFAULT_RING", 3);

// We need this script from EWiki as well

include("plugins/auth/auth_perm_ring.php");

// Set ourselves up with EWiki.

$ewiki_plugins["auth_query"][] = "ewiki_auth_query_beehive";
$ewiki_plugins["auth_userdb"][] = "ewiki_auth_userdb_beehive";

function ewiki_auth_query_beehive($data, $force_query = false)
{
    global $ewiki_errmsg;

    $t_success = false;

    if (isset($_COOKIE['bh_ewiki_logon']) && strlen(trim($_COOKIE['bh_ewiki_logon'])) > 0) {

        list($t_logon, $t_passwd) = explode(':', base64_decode($_COOKIE["bh_ewiki_logon"]));

    }else {

        if (isset($_POST['logon']) && strlen(trim($_POST['logon'])) > 0) {
            $t_logon = $_POST['logon'];
        }

        if (isset($_POST['passwd']) && strlen(trim($_POST['passwd'])) > 0) {
            $t_passwd = $_POST['passwd'];
        }
    }

    if (isset($t_logon) && isset($t_passwd)) {

        if (($t_success = ewiki_auth_user($t_logon, $t_passwd))) {

            setcookie("bh_ewiki_logon", base64_encode("$t_logon:$t_passwd"), 0);
        }
    }

    if ($force_query && !$t_success || ($force_query >= 2)) {

        $ewiki_errmsg.= "<form action=\"{$_SERVER['REQUEST_URI']}\" method=\"post\">\n";
        $ewiki_errmsg.= "<p>Please enter your forum logon and password below to continue.</p>\n";
        $ewiki_errmsg.= "<table>\n";
        $ewiki_errmsg.= "  <tr>\n";
        $ewiki_errmsg.= "    <td>". ewiki_t("_{Logon}"). ":</td>\n";
        $ewiki_errmsg.= "    <td>". ewiki_t("<input type=\"text\" size=\"20\" name=\"logon\">"). "</td>\n";
        $ewiki_errmsg.= "  </tr>\n";
        $ewiki_errmsg.= "  <tr>\n";
        $ewiki_errmsg.= "    <td>". ewiki_t("_{Password}"). ":</td>\n";
        $ewiki_errmsg.= "    <td>". ewiki_t("<input type=\"password\" size=\"20\" name=\"passwd\">"). "</td>\n";
        $ewiki_errmsg.= "  </tr>\n";
        $ewiki_errmsg.= "  <tr>\n";
        $ewiki_errmsg.= "    <td>&nbsp;</td>\n";
        $ewiki_errmsg.= "    <td>". ewiki_t("<input type=\"submit\" value=\"_{Logon}\">"). "</td>\n";
        $ewiki_errmsg.= "  </tr>\n";
        $ewiki_errmsg.= "</table>\n";

        if (defined("EWIKI_AUTH_QUERY_SAFE")) {

            foreach ($_POST as $key => $value) {

                if ($key == "logon" || $key == "passwd") continue;
                $ewiki_errmsg.= "<input type=\"hidden\" name=\"{$key}\" value=\"". preg_replace('/([^\w\d\260-\377])/eu', '"&#".ord("$1").";"', $value). "\">\n";
            }
        }

        $ewiki_errmsg.= "</form>\n";
    }

    return $t_success;
}

function ewiki_auth_userdb_beehive($username, $password)
{
    // Beehive include files that we need.

    include_once(BH_INCLUDE_PATH. "db.inc.php");
    include_once(BH_INCLUDE_PATH. "logon.inc.php");
    include_once(BH_INCLUDE_PATH. "session.inc.php");

    // Reset the PHP error reporting level and disable
    // Beehive's error handler - Ewiki isn't as well
    // written as Beehive ;)

    restore_error_handler();
    error_reporting(E_ALL ^ E_NOTICE);

    // MD5 hash the password.

    $passhash = md5($password);

    // Attempt user logon

    if (($uid = user_logon($username, $passhash))) {

        if (bh_session_init($uid)) {

            if (bh_session_user_banned()) return false;
            if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS, 0)) return array($password, 0);

            return array($password, 2);
        }
    }

    return array($password, 3);
}

?>