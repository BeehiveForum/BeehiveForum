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

/* $Id: pm_messages.php,v 1.1 2007-04-06 13:01:01 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");
include_once(BH_INCLUDE_PATH. "zip_lib.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {
    
    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access PMs

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that PM system is enabled

pm_enabled();

// Various Headers for the PM folders

$pm_header_array = array(PM_FOLDER_INBOX  => $lang['pminbox'],
                         PM_FOLDER_SENT   => $lang['pmsentitems'],
                         PM_FOLDER_OUTBOX => $lang['pmoutbox'],
                         PM_FOLDER_SAVED  => $lang['pmsaveditems']);

// Check to see which page we should be on

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

// Default folder

$folder = PM_FOLDER_INBOX;

// Check to see if we're viewing a message and get the folder it is in.

if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

    if (!$folder = pm_message_get_folder($mid)) {
        $folder = PM_FOLDER_INBOX;
    }

}elseif (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = $_POST['mid'];

    if (!$folder = pm_message_get_folder($mid)) {
        $folder = PM_FOLDER_INBOX;
    }

}elseif (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

}elseif (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }
}

// Delete Messages

if (isset($_POST['deletemessages'])) {
    if (isset($_POST['process']) && is_array($_POST['process']) && sizeof($_POST['process']) > 0) {
        foreach($_POST['process'] as $mid) {
            pm_delete_message($mid);
        }
    }
}

// Archive Messages

if (isset($_POST['savemessages'])) {
    if (isset($_POST['process']) && is_array($_POST['process']) && sizeof($_POST['process']) > 0) {
        foreach($_POST['process'] as $mid) {
            pm_archive_message($mid);
        }
    }
}

// Export Messages

if (isset($_POST['exportfolder'])) {

    pm_export($folder);
    exit;
}

// Prune old messages for the current user

pm_user_prune_folders();

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

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if ($folder == PM_FOLDER_INBOX) {

    $pm_messages_array = pm_get_inbox($start);

}elseif ($folder == PM_FOLDER_SENT) {

    $pm_messages_array = pm_get_sent($start);

}elseif ($folder == PM_FOLDER_OUTBOX) {

    $pm_messages_array = pm_get_outbox($start);

}elseif ($folder == PM_FOLDER_SAVED) {

    $pm_messages_array = pm_get_saveditems($start);
}

echo "<h1>{$pm_header_array[$folder]}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"pm\" action=\"pm_messages.php?page=$page\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('folder', _htmlentities($folder)), "\n";
echo "  <table cellpadding=\"5\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"100%\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\" border=\"0\">\n";
echo "                <tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"10\">", form_checkbox("toggle_all", "toggle_all", "", false, "onclick=\"pm_toggle_all();\""), "</td>\n";
}else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"10\">&nbsp;</td>\n";
}

echo "                  <td align=\"left\" class=\"subhead\" width=\"50%\">{$lang['subject']}</td>\n";

if ($folder == PM_FOLDER_INBOX) {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"30%\">{$lang['from']}</td>\n";
}elseif ($folder == PM_FOLDER_SENT || $folder == PM_FOLDER_OUTBOX) {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"30%\">{$lang['to']}</td>\n";
}elseif  ($folder == PM_FOLDER_SAVED) {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"15%\">{$lang['to']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"15%\">{$lang['from']}</td>\n";
}

echo "                  <td align=\"left\" class=\"subhead\">{$lang['timesent']}</td>\n";
echo "                </tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {

    foreach($pm_messages_array['message_array'] as $message) {

        echo "                <tr>\n";
        echo "                  <td class=\"postbody\" align=\"center\" width=\"10\">", form_checkbox('process[]', $message['MID'], ''), "</td>\n";
        echo "                  <td align=\"left\" class=\"postbody\">";

        if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {
            $mid = $_GET['mid'];
        }else {
            $mid = NULL;
        }

        if ($mid == $message['MID']) {
            echo "            <img src=\"".style_image('current_thread.png')."\" title=\"{$lang['currentmessage']}\" alt=\"{$lang['currentmessage']}\" />";
        }else {
            if (($message['TYPE'] == PM_UNREAD)) {
                echo "            <img src=\"".style_image('pmunread.png')."\" title=\"{$lang['unreadmessage']}\" alt=\"{$lang['unreadmessage']}\" />";
            }else {
                echo "            <img src=\"".style_image('pmread.png')."\" title=\"{$lang['readmessage']}\" alt=\"{$lang['readmessage']}\" />";
            }
        }

        echo "            <a href=\"pm_messages.php?webtag=$webtag&amp;mid={$message['MID']}&amp;page=$page\" target=\"_self\">{$message['SUBJECT']}</a>";
        
        if (pm_has_attachments($message['MID'])) {
            echo "            &nbsp;&nbsp;<img src=\"".style_image('attach.png')."\" border=\"0\" alt=\"{$lang['attachment']} - {$message['AID']}\" title=\"{$lang['attachment']}\" />";
        }

        echo "            </td>\n";

        if ($folder == PM_FOLDER_SENT || $folder == PM_FOLDER_OUTBOX) {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
            echo add_wordfilter_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
            echo "            </td>\n";

        }elseif ($folder == PM_FOLDER_SAVED) {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
            echo add_wordfilter_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
            echo "            </td>\n";

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['FROM_UID']}, '$webtag')\">";
            echo add_wordfilter_tags(format_user_name($message['FLOGON'], $message['FNICK'])) . "</a>";
            echo "            </td>\n";

        }else {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['FROM_UID']}, '$webtag')\">";
            echo add_wordfilter_tags(format_user_name($message['FLOGON'], $message['FNICK'])) . "</a>";
            echo "            </td>\n";

        }

        echo "                  <td align=\"left\" class=\"postbody\">", format_time($message['CREATED']), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td class=\"postbody\">&nbsp;</td><td align=\"left\" class=\"postbody\">{$lang['nomessages']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td class=\"postbody\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"100%\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td width=\"25%\">&nbsp;</td>\n";
echo "            <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $pm_messages_array['message_count'], 10), "</td>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
    echo "            <td align=\"right\" width=\"25%\" nowrap=\"nowrap\">", form_submit("exportfolder", "Export Folder"), "&nbsp;", (($folder <> PM_FOLDER_SAVED) && ($folder <> PM_FOLDER_OUTBOX)) ? form_submit("savemessages", $lang['savemessage']) : "", "&nbsp;", form_submit("deletemessages", $lang['delete']), "</td>\n";
}else {
    echo "            <td width=\"25%\">&nbsp;</td>\n";
}

echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

// View a message

if (isset($mid) && is_numeric($mid)) {

    if ($pm_message_array = pm_message_get($mid)) {

        $pm_message_array['CONTENT'] = pm_get_content($mid);

        echo "  <br />\n";
        echo "  <table cellpadding=\"5\" cellspacing=\"0\" width=\"96%\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\">", pm_display($pm_message_array, $folder), "</td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    
    }else {
    
        html_draw_top();
        html_error_msg($lang['messagehasbeendeleted']);
        html_draw_bottom();
        exit;
    }
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>