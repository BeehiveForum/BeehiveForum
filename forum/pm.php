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

/* $Id: pm.php,v 1.23 2003-11-27 13:29:06 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");
require_once("./include/constants.inc.php");

// Delete Messages

if (isset($HTTP_POST_VARS['deletemessages'])) {
    if (isset($HTTP_POST_VARS['process']) && is_array($HTTP_POST_VARS['process'])) {
        for ($i = 0; $i < sizeof($HTTP_POST_VARS['process']); $i++) {
            pm_delete_message($HTTP_POST_VARS['process'][$i]);
        }
    }
}

// Archive Messages

if (isset($HTTP_POST_VARS['savemessages'])) {
    if (isset($HTTP_POST_VARS['process']) && is_array($HTTP_POST_VARS['process'])) {
        for ($i = 0; $i < sizeof($HTTP_POST_VARS['process']); $i++) {
            pm_archive_message($HTTP_POST_VARS['process'][$i]);
        }
    }
}

// Default Folder

$folder_bitwise = PM_FOLDER_INBOX;
$folder = 0;

// Which folder are we in?

if (isset($HTTP_POST_VARS['folder'])) {
    if ($HTTP_POST_VARS['folder'] == 1) {
        $folder_bitwise = PM_FOLDER_SENT;
        $folder = 1;
    }elseif ($HTTP_POST_VARS['folder'] == 2) {
        $folder_bitwise = PM_FOLDER_OUTBOX;
        $folder = 2;
    }elseif ($HTTP_POST_VARS['folder'] == 3) {
        $folder_bitwise = PM_FOLDER_SAVED;
        $folder = 3;
    }else {
        $folder_bitwise = PM_FOLDER_INBOX;
        $folder = 0;
    }
}

if (isset($HTTP_GET_VARS['folder'])) {
    if ($HTTP_GET_VARS['folder'] == 1) {
        $folder_bitwise = PM_FOLDER_SENT;
        $folder = 1;
    }elseif ($HTTP_GET_VARS['folder'] == 2) {
        $folder_bitwise = PM_FOLDER_OUTBOX;
        $folder = 2;
    }elseif ($HTTP_GET_VARS['folder'] == 3) {
        $folder_bitwise = PM_FOLDER_SAVED;
        $folder = 3;
    }else {
        $folder_bitwise = PM_FOLDER_INBOX;
        $folder = 0;
    }
}

html_draw_top("basetarget=_blank", "openprofile.js");

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n";
echo "function pm_toggle_all() {\n";
echo "    for (var i = 0; i < document.pm.elements.length; i++) {\n";
echo "        if (document.pm.elements[i].type == 'checkbox') {\n";
echo "            if (document.pm.toggle_all.checked == true) {\n";
echo "                document.pm.elements[i].checked = true;\n";
echo "            }else {\n";
echo "                document.pm.elements[i].checked = false;\n";
echo "            }\n";
echo "        }\n";
echo "    }\n";
echo "}\n";
echo "//-->\n";
echo "</script>\n";

$pm_folders = array(0 => $lang['pminbox'],
                    1 => $lang['pmsentitems'],
                    2 => $lang['pmoutbox'],
                    3 => $lang['pmsaveditems']);

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\" height=\"20\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">&nbsp;<b>{$lang['privatemessages']}: {$pm_folders[$folder]}</b></td>\n";
echo "    <td class=\"posthead\" align=\"right\"><a href=\"pm_write.php\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>&nbsp;</p>\n";

if (isset($HTTP_GET_VARS['mid']) && is_numeric($HTTP_GET_VARS['mid'])) {

    $pm_elements_array = array();

    if ($pm_elements_array = pm_single_get($HTTP_GET_VARS['mid'], $folder_bitwise)) {
        $pm_elements_array['FOLDER'] = $folder_bitwise;
        draw_pm_message($pm_elements_array);
        echo "<p>&nbsp;</p>\n";
    }else {
        echo "<p>{$lang['messagehasbeendeleted']}</p>\n";
    }
}

// get message list
$listmessages_array = pm_list_get($folder_bitwise);

echo "<form name=\"pm\" action=\"pm.php\" method=\"POST\" target=\"_self\">\n";
echo "  ", form_input_hidden('folder', $folder), "\n";
echo "  <table width=\"95%\" align=\"center\" border=\"0\">\n";
echo "    <tr>\n";
echo "      <td width=\"20\" align=\"center\">&nbsp;</td>\n";
echo "      <td class=\"posthead\" width=\"50%\">&nbsp;{$lang['subject']}</td>\n";

if ($folder == 1 || $folder == 2) {
    echo "      <td class=\"posthead\">&nbsp;{$lang['to']}</td>\n";
}elseif  ($folder == 3) {
    echo "      <td class=\"posthead\">&nbsp;{$lang['to']}</td>\n";
    echo "      <td class=\"posthead\">&nbsp;{$lang['from']}</td>\n";
}else {
    echo "      <td class=\"posthead\">&nbsp;{$lang['from']}</td>\n";
}

echo "      <td class=\"posthead\">&nbsp;{$lang['timesent']}</td>\n";

if (sizeof($listmessages_array) == 0) {

    echo "      <td class=\"posthead\" width=\"20\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\"></td><td class=\"postbody\">{$lang['nomessages']}</td>\n";
    echo "    </tr>\n";

}else {

    echo "      <td class=\"posthead\" width=\"25\" align=\"center\">", form_checkbox("toggle_all", "toggle_all", "", false, "onclick=\"pm_toggle_all();\""), "</td>\n";
    echo "    </tr>\n";

    for ($i = 0; $i < sizeof($listmessages_array); $i++) {

        echo "    <tr>\n";
        echo "      <td class=\"postbody\">";

        if (isset($HTTP_GET_VARS['mid']) && is_numeric($HTTP_GET_VARS['mid'])){
            $mid = $HTTP_GET_VARS['mid'];
        }else {
            $mid = NULL;
        }

        if ($mid == $listmessages_array[$i]['MID']) {
            echo "<img src=\"".style_image('current_thread.png')."\" align=\"middle\" height=\"15\" title=\"Current Message\" alt=\"\"/>";
        }else {
            if (($listmessages_array[$i]['TYPE'] == PM_UNREAD) || ($listmessages_array[$i]['TYPE'] == PM_NEW)) {
                echo "<img src=\"".style_image('unread_thread.png')."\" align=\"middle\" height=\"15\" title=\"Unread Message\" alt=\"\" />";
            }else {
                echo "<img src=\"".style_image('bullet.png')."\" align=\"middle\" height=\"15\" title=\"Read Message\" alt=\"\" />";
            }
        }

        echo "</td>\n";

        echo "      <td class=\"postbody\">";
        echo "<a href=\"pm.php?folder=$folder&amp;mid=".$listmessages_array[$i]['MID']."\" target=\"_self\">", _stripslashes($listmessages_array[$i]['SUBJECT']), "</a>";

        if (isset($listmessages_array[$i]['AID'])) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('attach.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['attachment']}\" />";
        }

        if (($folder_bitwise == PM_FOLDER_OUTBOX) && (($listmessages_array[$i]['TYPE'] == PM_NEW) || ($listmessages_array[$i]['TYPE'] == PM_UNREAD))) {
            echo "&nbsp;&nbsp;<span class=\"threadxnewofy\">[<a target=\"_self\" href=\"pm_edit.php?mid={$listmessages_array[$i]['MID']}\">Edit</a>]</span>";
        }

        echo "</td>\n";

        if ($folder == 1 || $folder == 2) {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $listmessages_array[$i]['TO_UID'] . ")\" target=\"_self\">";
            echo format_user_name($listmessages_array[$i]['TLOGON'], $listmessages_array[$i]['TNICK']) . "</a>";
            echo "</td>\n";

        }elseif ($folder == 3) {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $listmessages_array[$i]['TO_UID'] . ")\" target=\"_self\">";
            echo format_user_name($listmessages_array[$i]['TLOGON'], $listmessages_array[$i]['TNICK']) . "</a>";
            echo "</td>\n";

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $listmessages_array[$i]['FROM_UID'] . ")\" target=\"_self\">";
            echo format_user_name($listmessages_array[$i]['FLOGON'], $listmessages_array[$i]['FNICK']) . "</a>";
            echo "</td>\n";

        }else {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $listmessages_array[$i]['FROM_UID'] . ")\" target=\"_self\">";
            echo format_user_name($listmessages_array[$i]['FLOGON'], $listmessages_array[$i]['FNICK']) . "</a>";
            echo "</td>\n";

        }

        echo "      <td class=\"postbody\">", format_time($listmessages_array[$i]['CREATED']), "</td>\n";
        echo "      <td class=\"postbody\" align=\"center\">", form_checkbox('process[]', $listmessages_array[$i]['MID'], ''), "</td>\n";
        echo "    </tr>\n";
    }

    echo "    <tr>\n";
    echo "      <td class=\"postbody\" colspan=\"5\" align=\"right\">", (($folder_bitwise <> PM_FOLDER_SAVED) && ($folder_bitwise <> PM_FOLDER_OUTBOX)) ? form_submit("savemessages", $lang['savemessage']) : "", "&nbsp;", form_submit("deletemessages", $lang['delete']), "</td>\n";
    echo "    </tr>\n";

}

echo "    <tr>\n";
echo "      <td class=\"postbody\" colspan=\"5\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>