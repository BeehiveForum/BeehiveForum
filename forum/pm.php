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

/* $Id: pm.php,v 1.44 2004-04-11 21:13:14 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

include_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

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

if (isset($HTTP_GET_VARS['page']) && is_numeric($HTTP_GET_VARS['page'])) {
    $start = floor($HTTP_GET_VARS['page'] - 1) * 10;
}else {
    $start = 0;
}

// Default Folder

$folder = PM_FOLDER_INBOX;

if (isset($HTTP_GET_VARS['folder'])) {
        
    if ($HTTP_GET_VARS['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($HTTP_GET_VARS['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($HTTP_GET_VARS['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

}elseif (isset($HTTP_POST_VARS['folder'])) {

    if ($HTTP_POST_VARS['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($HTTP_POST_VARS['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($HTTP_POST_VARS['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
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

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\" height=\"20\">\n";
echo "  <tr>\n";

if ($folder == PM_FOLDER_INBOX) {

    $pm_messages_array = pm_get_inbox($start);
    echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['pminbox']}</b></td>\n";

}elseif ($folder == PM_FOLDER_SENT) {

    $pm_messages_array = pm_get_sent($start);
    echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['pmsentitems']}</b></td>\n";

}elseif ($folder == PM_FOLDER_OUTBOX) {

    $pm_messages_array = pm_get_outbox($start);
    echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['pmoutbox']}</b></td>\n";

}elseif ($folder == PM_FOLDER_SAVED) {

    $pm_messages_array = pm_get_saveditems($start);
    echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['pmsaveditems']}</b></td>\n";
}

echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag&folder=1\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=2\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&folder=3\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=4\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>&nbsp;</p>\n";

if (isset($HTTP_GET_VARS['mid']) && is_numeric($HTTP_GET_VARS['mid'])) {

    $pm_elements_array = array();

    if ($pm_elements_array = pm_single_get($HTTP_GET_VARS['mid'], $folder)) {
        $pm_elements_array['FOLDER'] = $folder;
        draw_pm_message($pm_elements_array);
        echo "<p>&nbsp;</p>\n";
    }else {
        echo "<p>{$lang['messagehasbeendeleted']}</p>\n";
    }
}

echo "<form name=\"pm\" action=\"pm.php?webtag=$webtag\" method=\"POST\" target=\"_self\">\n";
echo "  ", form_input_hidden('folder', $folder), "\n";
echo "  <table width=\"95%\" align=\"center\" border=\"0\">\n";
echo "    <tr>\n";
echo "      <td width=\"20\" align=\"center\">&nbsp;</td>\n";
echo "      <td class=\"posthead\" width=\"50%\">&nbsp;{$lang['subject']}</td>\n";

if ($folder == PM_FOLDER_INBOX) {
    echo "      <td class=\"posthead\">&nbsp;{$lang['from']}</td>\n";
}elseif ($folder == PM_FOLDER_SENT || $folder == PM_FOLDER_OUTBOX) {
    echo "      <td class=\"posthead\">&nbsp;{$lang['to']}</td>\n";
}elseif  ($folder == PM_FOLDER_SAVED) {
    echo "      <td class=\"posthead\">&nbsp;{$lang['to']}</td>\n";
    echo "      <td class=\"posthead\">&nbsp;{$lang['from']}</td>\n";
}

echo "      <td class=\"posthead\">&nbsp;{$lang['timesent']}</td>\n";

if (is_array($pm_messages_array) && sizeof($pm_messages_array) > 0) {

    echo "      <td class=\"posthead\" width=\"25\" align=\"center\">", form_checkbox("toggle_all", "toggle_all", "", false, "onclick=\"pm_toggle_all();\""), "</td>\n";
    echo "    </tr>\n";

    foreach($pm_messages_array['message_array'] as $message) {
        
        echo "    <tr>\n";
        echo "      <td class=\"postbody\">";

        if (isset($HTTP_GET_VARS['mid']) && is_numeric($HTTP_GET_VARS['mid'])) {
            $mid = $HTTP_GET_VARS['mid'];
        }else {
            $mid = NULL;
        }

        if ($mid == $message['MID']) {
            echo "<img src=\"".style_image('current_thread.png')."\" align=\"middle\" height=\"15\" title=\"Current Message\" alt=\"\"/>";
        }else {
            if (($message['TYPE'] == PM_UNREAD) || ($message['TYPE'] == PM_NEW)) {
                echo "<img src=\"".style_image('pmunread.png')."\" align=\"middle\" height=\"15\" title=\"Unread Message\" alt=\"\" />";
            }else {
                echo "<img src=\"".style_image('pmread.png')."\" align=\"middle\" height=\"15\" title=\"Read Message\" alt=\"\" />";
            }
        }

        echo "</td>\n";

        echo "      <td class=\"postbody\">";
        echo "<a href=\"pm.php?webtag=$webtag&folder=$folder&amp;mid=".$message['MID']."\" target=\"_self\">", _stripslashes($message['SUBJECT']), "</a>";

        if (isset($message['AID'])) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('attach.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['attachment']}\" />";
        }

        if (($folder == PM_FOLDER_OUTBOX) && (($message['TYPE'] == PM_NEW) || ($message['TYPE'] == PM_UNREAD))) {
            echo "&nbsp;&nbsp;<span class=\"threadxnewofy\">[<a target=\"_self\" href=\"pm_edit.php?webtag=$webtag&mid={$message['MID']}\">Edit</a>]</span>";
        }

        echo "</td>\n";

        if ($folder == PM_FOLDER_SENT || $folder == PM_FOLDER_OUTBOX) {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['TO_UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($message['TLOGON'], $message['TNICK']) . "</a>";
            echo "</td>\n";

        }elseif ($folder == PM_FOLDER_SAVED) {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['TO_UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($message['TLOGON'], $message['TNICK']) . "</a>";
            echo "</td>\n";

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['FROM_UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($message['FLOGON'], $message['FNICK']) . "</a>";
            echo "</td>\n";

        }else {

            echo "      <td class=\"postbody\">";
            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['FROM_UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($message['FLOGON'], $message['FNICK']) . "</a>";
            echo "</td>\n";

        }

        echo "      <td class=\"postbody\">", format_time($message['CREATED']), "</td>\n";
        echo "      <td class=\"postbody\" align=\"center\">", form_checkbox('process[]', $message['MID'], ''), "</td>\n";
        echo "    </tr>\n";
    }

    echo "    <tr>\n";
    echo "      <td class=\"postbody\" colspan=\"5\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" colspan=\"5\">\n";
    echo "        <table width=\"100%\" align=\"center\" border=\"0\">\n";
    echo "          <tr>\n";
    echo "            <td colspan=\"2\" width=\"25%\">&nbsp;</td>";
    echo "            <td align=\"center\">Pages: ";

    $page_count = ceil($pm_messages_array['message_count'] / 10);
    
    if ($page_count > 1) {

        for ($page = 1; $page <= $page_count; $page++) {
            echo "<a href=\"pm.php?webtag=$webtag&folder=$folder&page=$page\" target=\"_self\">$page</a> ";
        }

    }else {

        echo "<a href=\"pm.php?webtag=$webtag&folder=$folder&page=1\" target=\"_self\">1</a> ";
    }

    echo "            <td colspan=\"2\" align=\"right\" width=\"25%\" nowrap=\"nowrap\">", (($folder <> PM_FOLDER_SAVED) && ($folder <> PM_FOLDER_OUTBOX)) ? form_submit("savemessages", $lang['savemessage']) : "", "&nbsp;", form_submit("deletemessages", $lang['delete']), "</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";

}else {

    echo "      <td class=\"posthead\" width=\"20\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\"></td><td class=\"postbody\">{$lang['nomessages']}</td>\n";
    echo "    </tr>\n";
}

echo "    <tr>\n";
echo "      <td class=\"postbody\" colspan=\"5\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>