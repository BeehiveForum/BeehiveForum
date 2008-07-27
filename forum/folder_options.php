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

/* $Id: folder_options.php,v 1.6 2008-07-27 18:26:09 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

//$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Guests can't use this

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that required variables are set

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

}elseif (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

    $fid = $_POST['fid'];

}else {

    html_draw_top();
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Get the folder ID for the current message

if (!$folder_data = folder_get($fid)) {

    html_draw_top();
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

// UID of the current user.

$uid = bh_session_get_value('UID');

// Get the existing thread data.

if (!folder_is_accessible($fid)) {

    html_draw_top();
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Close button clicked.

if (isset($_POST['close'])) {

    html_draw_top('pm_popup_disabled');

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

// Code for handling functionality from messages.php

if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    if (in_range($_GET['markasread'], 0, $thread_data['LENGTH'])) {

        $mark_as_read = $_GET['markasread'];

        if (messages_set_read($tid, $mark_as_read, $uid, $thread_data['MODIFIED'])) {

            header_redirect("messages.php?webtag=$webtag&msg=$msg&markasread=1");
            exit;
        }
    }

    header_redirect("messages.php?webtag=$webtag&msg=$msg&markasread=0");
    exit;

}elseif (isset($_POST['setinterest']) && is_numeric($_POST['setinterest'])) {

    $thread_interest = $_POST['setinterest'];

    if (thread_set_interest($tid, $thread_interest)) {

        header_redirect("messages.php?webtag=$webtag&msg=$msg&setinterest=1");
        exit;
    }

    header_redirect("messages.php?webtag=$webtag&msg=$msg&setinterest=0");
    exit;
}

// Submit Code

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['markasread']) && is_numeric($_POST['markasread'])) {

        if (in_range($_POST['markasread'], 0, $thread_data['LENGTH'])) {

            $thread_data['LAST_READ'] = $_POST['markasread'];

            if (!messages_set_read($tid, $thread_data['LAST_READ'], $uid, $thread_data['MODIFIED'])) {

                $error_msg_array[] = $lang['failedtoupdatethreadreadstatus'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['failedtoupdatethreadreadstatus'];
            $valid = false;
        }
    }

    if (isset($_POST['interest']) && is_numeric($_POST['interest'])) {

        $folder_data['INTEREST'] = $_POST['interest'];

        if (!user_set_folder_interest($fid, $folder_data['INTEREST'])) {

            $error_msg_array[] = $lang['failedtoupdatefolderinterest'];
            $valid = false;
        }
    }

    if ($valid) {

        header_redirect("folder_options.php?webtag=$webtag&fid=$fid&updated=true");
        exit;
    }
}

html_draw_top("basetarget=_blank", "folder_options.js");

echo "<h1>{$lang['folderoptions']} &raquo; ", word_filter_add_ob_tags(_htmlentities($folder_data['TITLE'])), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '500', 'center');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['updatessavedsuccessfully'], '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"folder_options\" action=\"folder_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("fid", _htmlentities($fid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['interest']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">{$lang['interest']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_IGNORED, $lang['ignore'], $folder_data['INTEREST'] == FOLDER_IGNORED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_NOINTEREST, $lang['normal'], $folder_data['INTEREST'] == FOLDER_NOINTEREST), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_SUBSCRIBED, $lang['subscribe'], $folder_data['INTEREST'] == FOLDER_SUBSCRIBED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("close", $lang['close']). "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>