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

/* $Id: links_add.php,v 1.97 2008-07-27 10:53:32 decoyduck Exp $ */

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

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Intitalise a few variables

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

if (!forum_get_setting('show_links', 'Y')) {

    html_draw_top();
    html_error_msg($lang['maynotaccessthissection']);
    html_draw_bottom();
    exit;
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// User's UID for later.

$uid = bh_session_get_value('UID');

// Array to hold error messages

$error_msg_array = array();

// User pressed cancel

if (isset($_POST['cancel'])) {

    header_redirect("links.php?webtag=$webtag&fid={$_POST['fid']}");
    exit;
}

// Get the Links Folders.

$folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

// Check the mode.

if (isset($_GET['mode'])) {

    if ($_GET['mode'] == LINKS_ADD_LINK) {

        $mode = LINKS_ADD_LINK;

    }elseif ($_GET['mode'] == LINKS_ADD_FOLDER) {

        $mode = LINKS_ADD_FOLDER;

    }else {

        $mode = LINKS_ADD_LINK;
    }

} elseif (isset($_POST['mode'])) {

    if ($_POST['mode'] == LINKS_ADD_LINK) {

        $mode = LINKS_ADD_LINK;

    }elseif ($_POST['mode'] == LINKS_ADD_FOLDER) {

        $mode = LINKS_ADD_FOLDER;

    }else {

        $mode = LINKS_ADD_LINK;
    }

} else {

    $mode = LINKS_ADD_LINK;
}

// Submit code for adding a link.

if (isset($_POST['add']) && $mode == LINKS_ADD_LINK) {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $fid = 1;
    }

    if (isset($_POST['uri']) && preg_match('/\b([a-z]+:\/\/([-\w]{2,}\.)*[-\w]{2,}(:\d+)?(([^\s;,.?"\'[\]() {}<>]|\S[^\s;,.?"\'[\]() {}<>])*)?)/i', trim(_stripslashes($_POST['uri'])))) {

        $uri = trim(_stripslashes($_POST['uri']));

        if (strlen($uri) > 255) {

            $error_msg_array[] = sprintf($lang['linkurltoolong'], 255);
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['notvalidURI'];
        $valid = false;
    }

    if (isset($_POST['name']) && strlen(trim(_stripslashes($_POST['name']))) > 0) {

        $name = trim(_stripslashes($_POST['name']));

        if (strlen($name) > 64) {

            $error_msg_array[] = sprintf($lang['linknametoolong'], 64);
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifyname'];
        $valid = false;
    }

    if (isset($_POST['description']) && strlen(trim(_stripslashes($_POST['description']))) > 0) {
        $description = trim(_stripslashes($_POST['description']));
    }else {
        $description = "";
    }

    if ($valid) {

        if (links_add($uri, $name, $description, $fid, $uid)) {

            header_redirect("links.php?webtag=$webtag&fid=$fid&link_added=$name");
            exit;

        }else {

            $error_msg_array[] = $lang['failedtoaddlink'];
            $valid = false;
        }
    }

}else if (isset($_POST['add']) && $mode == LINKS_ADD_FOLDER) {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $fid = 1;
    }

    if (isset($_POST['name']) && strlen(trim(_stripslashes($_POST['name']))) > 0) {

        $name = trim(_stripslashes($_POST['name']));

        if (strlen($name) > 32) {

            $error_msg_array[] = sprintf($lang['linkfoldernametoolong'], 32);
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifyname'];
        $valid = false;
    }

    if ($valid) {

        if (links_add_folder($fid, $name, true)) {

            header_redirect("links.php?webtag=$webtag&fid=$fid&folder_added=$name");
            exit;

        }else {

            $error_msg_array[] = $lang['failedtoaddfolder'];
            $valid = false;
        }
    }

}else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

    if (($_GET['mode'] == 'link' && !in_array($fid, array_keys($folders)))) {

        html_draw_top();
        html_error_msg($lang['mustspecifyvalidfolder']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg($lang['mustspecifyfolder']);
    html_draw_bottom();
    exit;
}

if ($mode == LINKS_ADD_LINK) {

    html_draw_top();

    echo "<h1>{$lang['links']} &raquo; {$lang['addlink']}</h1>\n";
    echo "<p>{$lang['addinglinkin']}: <b>" . links_display_folder_path($fid, $folders, false) . "</b></p>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'left');
    }

    echo "<form name=\"linkadd\" action=\"links_add.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("fid", _htmlentities($fid)) . "\n";
    echo "  ", form_input_hidden("mode", LINKS_ADD_LINK) . "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addlink']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['addressurluri']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("uri", (isset($uri)) ? _htmlentities($uri) : '', 50, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['name']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("name", (isset($name)) ? _htmlentities($name) : '', 50, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['description']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("description", (isset($description)) ? _htmlentities($description) : '', 50), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    html_draw_bottom();

}elseif ($mode == LINKS_ADD_FOLDER) {

    html_draw_top();

    echo "<h1>{$lang['links']} &raquo; {$lang['addnewfolder']}</h1>\n";
    echo "<p>{$lang['addnewfolderunder']}: <b>". links_display_folder_path($fid, $folders, false) . "</b></p>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'left');
    }

    echo "<form name=\"folderadd\" action=\"links_add.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("fid", _htmlentities($fid)) . "\n";
    echo "  ", form_input_hidden("mode", LINKS_ADD_FOLDER) . "\n";
    echo "  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addnewfolder']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['name']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("name", isset($name) ? _htmlentities($name) : '', 50, 32), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    html_draw_bottom();
}

?>