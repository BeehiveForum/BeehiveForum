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

/* $Id: admin_viewlog.php,v 1.57 2004-04-29 14:02:51 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag();

            html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    html_draw_top();
    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

if (!(bh_session_get_value('STATUS')&USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "LOG_TIME") {
        $sort_by = "ADMIN_LOG.LOG_TIME";
    } elseif ($_GET['sort_by'] == "ADMIN_UID") {
        $sort_by = "ADMIN_LOG.ADMIN_UID";
    } elseif ($_GET['sort_by'] == "ACTION") {
        $sort_by = "ADMIN_LOG.ACTION";
    } else {
        $sort_by = "ADMIN_LOG.LOG_TIME";
    }
} else {
    $sort_by = "ADMIN_LOG.LOG_TIME";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $start = floor($_GET['page'] - 1) * 20;
}else {
    $start = 0;
}

// Clear the admin log.

if (isset($_POST['clear'])) {
    admin_clearlog();
}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['adminaccesslog']}</h1>\n";
echo "<p>{$lang['adminlogexp']}</p>\n";
echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";

if ($sort_by == 'ADMIN_LOG.LOG_TIME' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=LOG_TIME&amp;sort_dir=DESC\">{$lang['datetime']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=LOG_TIME&amp;sort_dir=ASC\">{$lang['datetime']}</a></td>\n";
}

if ($sort_by == 'ADMIN_LOG.ADMIN_UID' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ADMIN_UID&amp;sort_dir=DESC\">{$lang['logon']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ADMIN_UID&amp;sort_dir=ASC\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'ADMIN_LOG.ACTION' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=DESC\">{$lang['action']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=ASC\">{$lang['action']}</a></td>\n";
}

echo "                  </tr>\n";

$admin_log_array = admin_get_log_entries($start, $sort_by, $sort_dir);

if (sizeof($admin_log_array['admin_log_array']) > 0) {

    foreach ($admin_log_array['admin_log_array'] as $admin_log_entry) {

        echo "                  <tr>\n";
        echo "                    <td class=\"posthead\" align=\"left\">", format_time($admin_log_entry['LOG_TIME']), "</td>\n";
        echo "                    <td class=\"posthead\" align=\"left\"><a href=\"admin_user.php?webtag=$webtag&amp;uid=", $admin_log_entry['ADMIN_UID'], "\">", format_user_name($admin_log_entry['ALOGON'], $admin_log_entry['ANICKNAME']), "</a></td>\n";

        if (!empty($admin_log_entry['LOGON']) && !empty($admin_log_entry['NICKNAME'])) {
            $user = "<a href=\"admin_user.php?webtag=$webtag&amp;uid=". $admin_log_entry['UID']. "\">";
            $user.= format_user_name($admin_log_entry['LOGON'], $admin_log_entry['NICKNAME']). "</a>";
        }else {
            $user = "{$lang['unknownuser']} (UID: {$admin_log_entry['UID']})";
        }

        if (isset($admin_log_entry['FID']) && $admin_log_entry['FID'] > 0) {
            $title = $admin_log_entry['FID'];
        }else {
            $title = "{$lang['unknownfolder']}";
        }

        if (isset($admin_log_entry['TID']) && $admin_log_entry['TID'] > 0) {
            $tid = $admin_log_entry['TID'];
        }

        if (isset($admin_log_entry['PID']) && $admin_log_entry['PID'] > 0) {
            $pid = $admin_log_entry['PID'];
        }

        if (isset($admin_log_entry['FOLDER_TITLE']) && !empty($admin_log_entry['FOLDER_TITLE'])) {
            $folder_title = _stripslashes($admin_log_entry['FOLDER_TITLE']);
        }else {
            $folder_title = "{$lang['unknown']} (FID: {$admin_log_entry['FID']})";
        }

        if (isset($admin_log_entry['THREAD_TITLE']) && !empty($admin_log_entry['THREAD_TITLE'])) {
            $thread_title = _stripslashes($admin_log_entry['THREAD_TITLE']);
        }else {
            $thread_title = "{$lang['unknown']} (TID: {$admin_log_entry['TID']})";
        }

        if (isset($admin_log_entry['PS_NAME']) && !empty($admin_log_entry['PS_NAME'])) {
            $ps_name = _stripslashes($admin_log_entry['PS_NAME']);
        }else {
            $ps_name = "{$lang['unknown']} (PSID: {$admin_log_entry['PSID']})";
        }

        if (isset($admin_log_entry['PI_NAME']) && !empty($admin_log_entry['PI_NAME'])) {
            $pi_name = _stripslashes($admin_log_entry['PI_NAME']);
        }else {
            $pi_name = "{$lang['unknown']} (PIID: {$admin_log_entry['PIID']})";
        }

        switch ($admin_log_entry['ACTION']) {
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
            case 25:
                $action_text = "{$lang['madethreadsticky']}: '$thread_title'";
                break;
            case 26:
                $action_text = "{$lang['madethreadnonsticky']}: '$thread_title'";
                break;
            case 27:
                $action_text = "{$lang['endedsessionforuser']}: '$user'";
                break;
            case 28:
                $action_text = "{$lang['editedwordfilter']}";
                break;
            case 29:
                $action_text = "{$lang['editedforumsettings']}";
                break;
            case 30:
                $action_text = "{$lang['lockedthreadtitlefolder']}: '$thread_title'";
                break;
            case 31:
                $action_text = "{$lang['unlockedthreadtitlefolder']}: '$thread_title'";
                break;
            case 32:
                $action_text = "{$lang['userspostsdeletedinthread']}: '$thread_title'";
                break;
            case 33:
                $action_text = "{$lang['threaddeleted']}: '$thread_title'";
                break;
            case 34:
                $action_text = "{$lang['deleteduserattachmentfrompost']}: $tid.$pid";
                break;
            default:
                $action_text = "{$lang['unknown']}";
                break;

        }

        unset($user, $title, $tid, $pid, $title, $ps_name, $pi_name);

        echo "                    <td class=\"posthead\" align=\"left\">", $action_text, "</td>\n";
        echo "                  </tr>\n";

    }

}else {

    echo "                  <tr>\n";
    echo "                    <td class=\"posthead\" colspan=\"3\" align=\"left\">{$lang['adminlogempty']}</td>\n";
    echo "                  </tr>\n";

}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" align=\"center\">{$lang['pages']}: ", page_links(get_request_uri(), $start, $admin_log_array['admin_log_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if (bh_session_get_value('STATUS')&USER_PERM_QUEEN && $admin_log_array) {
    echo "    <tr>\n";
    echo "      <td align=\"center\">\n";
    echo "        <form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
    echo "          ", form_submit('clear',$lang['clearlog']), "\n";
    echo "        </form>\n";
    echo "      </td>";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>