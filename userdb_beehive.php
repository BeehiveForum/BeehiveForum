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

/* $Id: userdb_beehive.php,v 1.5 2007-03-31 21:54:59 decoyduck Exp $ */

// Put Ewiki in protected mode and default to view / browse only

define("EWIKI_PROTECTED_MODE", 1);
define("EWIKI_AUTH_DEFAULT_RING", 3);

// We need this script from EWiki as well

include("plugins/auth/auth_perm_ring.php");

// Set ourselves up with EWiki.

$ewiki_plugins["auth_query"][] = "ewiki_auth_query_beehive";
$ewiki_plugins["auth_userdb"][] = "ewiki_auth_userdb_beehive";

function ewiki_auth_query_beehive(&$data, $force_query = false)
{
    global $ewiki_errmsg, $ewiki_id, $ewiki_action;

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

        if ($t_success = ewiki_auth_user($t_logon, $t_passwd)) {

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

            foreach($_POST as $key => $value) {

                if ($key == "logon" || $key == "passwd") continue;
                $ewiki_errmsg.= "<input type=\"hidden\" name=\"{$key}\" value=\"". preg_replace('/([^\w\d\260-\377])/e', '"&#".ord("$1").";"', $value). "\">\n";
            }
        }

        $ewiki_errmsg.= "</form>\n";
    }

    return $t_success;
}

function ewiki_auth_userdb_beehive($username, $password)
{
    include_once("../forum/include/config.inc.php");
    include_once("../forum/include/constants.inc.php");

    // $forum_fid is the FID from the FORUMS table. If you want
    // to associate the wiki with another forum's user permissions
    // change the $forum_fid value here.

    $forum_fid = 1;

    if (@!$db_ewiki_auth = mysql_connect($db_server, $db_username, $db_password)) return false;
    if (@!mysql_select_db($db_database, $db_ewiki_auth)) return false;

    $username = addslashes($username);
    $password = md5($password);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL, ";
    $sql.= "USER.PASSWD, BIT_OR(GROUP_PERMS.PERM) AS USER_PERM, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT FROM USER USER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "WHERE USER.LOGON = '$username' AND USER.PASSWD = '$password' ";
    $sql.= "GROUP BY USER.UID";

    $result = mysql_query($sql, $db_ewiki_auth) or die(mysql_error());

    if (mysql_num_rows($result) > 0) {

        $user_sess = mysql_fetch_array($result);

        if (isset($user_sess['USER_PERM_COUNT']) && $user_sess['USER_PERM_COUNT'] > 0) {

            if (isset($user_sess['USER_PERM'])) {

                if ($user_sess['USER_PERM'] & USER_PERM_BANNED) {

                    return false;
                }

                if (($user_sess['USER_PERM'] & USER_PERM_ADMIN_TOOLS) || ($user_sess['USER_PERM'] & USER_PERM_FORUM_TOOLS)) {

                    return array($user_sess['PASSWD'], 0);
                }
            }
        }

        return array($user_sess['PASSWD'], 2);
    }

    return array($user_sess['PASSWD'], 3);
}

?>