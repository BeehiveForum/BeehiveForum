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

/* $Id: admin_viewlog.php,v 1.16 2003-07-27 12:42:03 hodcroftcj Exp $ */

// Frameset for thread list and messages

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");

html_draw_top();

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)){
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Column sorting stuff

if (isset($HTTP_GET_VARS['sort_by'])) {
    if ($HTTP_GET_VARS['sort_by'] == "LOG_ID") {
        $sort_by = "ADMIN_LOG.LOG_ID";
    } elseif ($HTTP_GET_VARS['sort_by'] == "ADMIN_UID") {
        $sort_by = "ADMIN_LOG.ADMIN_UID";
    } elseif ($HTTP_GET_VARS['sort_by'] == "ACTION") {
        $sort_by = "ADMIN_LOG.ACTION";
    } else {
        $sort_by = "ADMIN_LOG.LOG_TIME";
    }
} else {
    $sort_by = "ADMIN_LOG.LOG_TIME";
}

if (isset($HTTP_GET_VARS['sort_dir'])) {
    if ($HTTP_GET_VARS['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($HTTP_GET_VARS['page'])) {
    $start = $HTTP_GET_VARS['page'] * 20;
}else {
    $start = 0;
}

$db = db_connect();

if (isset($HTTP_POST_VARS['clear']) && (bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {

    $sql = "DELETE FROM ". forum_table("ADMIN_LOG");
    $result = db_query($sql, $db);

}

$sql = "SELECT ADMIN_LOG.LOG_ID, UNIX_TIMESTAMP(ADMIN_LOG.LOG_TIME) AS LOG_TIME, ADMIN_LOG.ADMIN_UID, ";
$sql.= "ADMIN_LOG.UID, AUSER.LOGON AS ALOGON, AUSER.NICKNAME AS ANICKNAME, USER.LOGON, USER.NICKNAME, ";
$sql.= "ADMIN_LOG.FID, ADMIN_LOG.TID, ADMIN_LOG.PID, FOLDER.TITLE AS FOLDER_TITLE, THREAD.TITLE AS THREAD_TITLE, ";
$sql.= "ADMIN_LOG.PSID, ADMIN_LOG.PIID, PS.NAME AS PS_NAME, PI.NAME AS PI_NAME, ADMIN_LOG.ACTION ";
$sql.= "FROM ". forum_table("ADMIN_LOG"). " ADMIN_LOG ";
$sql.= "LEFT JOIN ". forum_table("USER"). " AUSER ON (AUSER.UID = ADMIN_LOG.ADMIN_UID) ";
$sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = ADMIN_LOG.UID) ";
$sql.= "LEFT JOIN ". forum_table("PROFILE_SECTION"). " PS ON (PS.PSID = ADMIN_LOG.PSID) ";
$sql.= "LEFT JOIN ". forum_table("PROFILE_ITEM"). " PI ON (PI.PIID = ADMIN_LOG.PIID) ";
$sql.= "LEFT JOIN ". forum_table("FOLDER"). " FOLDER ON (FOLDER.FID = ADMIN_LOG.FID) ";
$sql.= "LEFT JOIN ". forum_table("THREAD"). " THREAD ON (THREAD.TID = ADMIN_LOG.TID) ";
$sql.= "ORDER BY $sort_by $sort_dir LIMIT $start, 20";

$result = db_query($sql, $db);

// Draw the form
echo "<h1>{$lang['adminaccesslog']}</h1>\n";
echo "<p>{$lang['adminlogexp']}</p>\n";

if ($start > 0) {
  echo "<p>{$lang['showingactions']} ", $start + 1, " to ";
  if ($start + 20 > db_num_rows($result)) {
    echo $start + db_num_rows($result);
  }else {
    echo $start + 20;
  }
  echo " {$lang['inclusive']}.</p>\n";
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";

if ($sort_by == 'UID' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOG_TIME&amp;sort_dir=DESC\">{$lang['datetime']}</a></td>\n";
}else {
  echo "          <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOG_TIME&amp;sort_dir=ASC\">{$lang['datetime']}</a></td>\n";
}

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=ADMIN_UID&amp;sort_dir=DESC\">{$lang['logon']}</a></td>\n";
}else {
  echo "          <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=ADMIN_UID&amp;sort_dir=ASC\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'STATUS' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=ACTION&amp;sort_dir=DESC\">{$lang['action']}</a></td>\n";
}else {
  echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=ACTION&amp;sort_dir=ASC\">{$lang['action']}</a></td>\n";
}

echo "        </tr>\n";

if (db_num_rows($result)) {

    while ($row = db_fetch_array($result)) {

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" align=\"left\">", format_time($row['LOG_TIME']), "</td>\n";
        echo "          <td class=\"posthead\" align=\"left\"><a href=\"./admin_user.php?uid=", $row['ADMIN_UID'], "\">", format_user_name($row['ALOGON'], $row['ANICKNAME']), "</a></td>\n";

        if (!empty($row['LOGON']) && !empty($row['NICKNAME'])) {
            $user = "<a href=\"./admin_user.php?uid=". $row['UID']. "\">";
            $user.= format_user_name($row['LOGON'], $row['NICKNAME']). "</a>";
        }else {
            $user = "{$lang['unknownuser']} (UID: ". $row['UID']. ")";
        }

        if (isset($row['FID']) && $row['FID'] > 0) {
            $title = $row['FID'];
        }else {
            $title = "{$lang['unknownfolder']}";
        }

        if (isset($row['TID']) && $row['TID'] > 0) {
            $tid = $row['TID'];
        }

        if (isset($row['PID']) && $row['PID'] > 0) {
            $pid = $row['PID'];
        }

        if (isset($row['FOLDER_TITLE']) && !empty($row['FOLDER_TITLE'])) {
            $folder_title = _stripslashes($row['FOLDER_TITLE']);
        }else {
            $folder_title = "{$lang['unknown']} (FID: ". $row['FID']. ")";
        }

        if (isset($row['THREAD_TITLE']) && !empty($row['THREAD_TITLE'])) {
            $thread_title = _stripslashes($row['THREAD_TITLE']);
        }else {
            $thread_title = "{$lang['unknown']} (TID: ". $row['TID']. ")";
        }

        if (isset($row['PS_NAME']) && !empty($row['PS_NAME'])) {
            $ps_name = _stripslashes($row['PS_NAME']);
        }else {
            $ps_name = "{$lang['unknown']} (PSID: ". $row['PSID']. ")";
        }

        if (isset($row['PI_NAME']) && !empty($row['PI_NAME'])) {
            $pi_name = _stripslashes($row['PI_NAME']);
        }else {
            $pi_name = "{$lang['unknown']} (PIID: ". $row['PIID']. ")";
        }

        switch ($row['ACTION']) {
            case 1:
                $action_text = "{$lang['changeduserstatus']}: $user";
                break;
            case 2:
                $action_text = "{$lang['changedfolderaccess']}: $user";
                break;
            case 3:
                $action_text = "{$lang['deletedallusersposts']}: $user";
                break;
            case 4:
                $action_text = "{$lang['banneduser']} $user's {$lang['ipaddress']}";
                break;
            case 5:
                $action_text = "{$lang['unbanneduser']} $user's {$lang['ipaddress']}";
                break;
            case 6:
                $action_text = "{$lang['deleteduser']} $user's {$lang['attachment']}";
                break;
            case 7:
                $action_text = "{$lang['changedtitleaccessfolder']}: '$folder_title'";
                break;
            case 8:
                $action_text = "{$lang['movedthreads']}: '$folder_title'";
                break;
            case 9:
                $action_text = "{$lang['creatednewfolder']}: '$folder_title'";
                break;
            case 10:
                $action_text = "{$lang['changedprofilesectiontitle']}: $ps_name";
                break;
            case 11:
                $action_text = "{$lang['addednewprofilesection']}: $ps_name";
                break;
            case 12:
                $action_text = "{$lang['deletedprofilesection']}: $ps_name";
                break;
            case 13:
                $action_text = "{$lang['changedprofileitemtitle']}: $pi_name";
                break;
            case 14:
                $action_text = "{$lang['addednewprofileitem']}: $pi_name";
                break;
            case 15:
                $action_text = "{$lang['deletedprofileitem']}: $pi_name";
                break;
            case 16:
                $action_text = "{$lang['editedstartpage']}";
                break;
            case 17:
                $action_text = "{$lang['savednewstyle']}";
                break;
            case 18:
                $action_text = "{$lang['movedthread']}: '$thread_title'";
                break;
            case 19:
                $action_text = "{$lang['closedthread']}: '$thread_title'";
                break;
            case 20:
                $action_text = "{$lang['openedthread']}: '$thread_title'";
                break;
            case 21:
                $action_text = "{$lang['renamedthread']}: '$thread_title'";
                break;
            case 22:
                $action_text = "{$lang['deletedpost']}: $tid.$pid";
                break;
            case 23:
                $action_text = "{$lang['editedpost']}: $tid.$pid";
                break;
            case 24:
                $action_text = "{$lang['editedwordfilter']}";
                break;
            default:
                $action_text = "{$lang['unknown']}";
                break;

        }

        unset($user, $title, $tid, $pid, $title, $ps_name, $pi_name);

        echo "          <td class=\"posthead\" align=\"left\">", $action_text, "</td>\n";
        echo "        </tr>\n";

    }

}else {

    echo "        <tr>\n";
    echo "          <td class=\"posthead\" colspan=\"3\" align=\"left\">{$lang['adminlogempty']}</td>\n";
    echo "        </tr>\n";

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (db_num_rows($result) == 20) {
  if ($start < 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php?page=", ($start / 20) + 1, "\" target=\"_self\">{$lang['more']}</a></p>\n";
  }elseif ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php\" target=\"_self\">{$lang['recentvisitors']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php?page=", ($start / 20) - 1, "\" target=\"_self\">{$lang['back']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php?page=", ($start / 20) + 1, "\" target=\"_self\">{$lang['more']}</a></p>\n";
  }
}else {
  if ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php\" target=\"_self\">{$lang['recentvisitors']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"admin_viewlog.php?page=", ($start / 20) - 1, "\" target=\"_self\">{$lang['back']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
  }
}

echo "</div>\n";
echo "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";

if (bh_session_get_value('STATUS') & USER_PERM_QUEEN && db_num_rows($result)) {
    echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
    echo form_submit('clear',$lang['clearlog']);
    echo "</form>\n";
}

html_draw_bottom();

?>
