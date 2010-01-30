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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
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

if (!forum_check_webtag_available($webtag)) {
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

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['maynotaccessthissection']);
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

if (user_is_guest()) {

    html_guest_error();
    exit;
}

$uid = bh_session_get_value('UID');

$error_msg_array = array();

if (isset($_POST['cancel'])) {

    header_redirect("links.php?webtag=$webtag&fid={$_POST['fid']}");
    exit;
}

if (isset($_POST['update'])) {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $fid = 1;
    }

    if (isset($_POST['name']) && strlen(trim(stripslashes_array($_POST['name']))) > 0) {

        $name = trim(stripslashes_array($_POST['name']));

        if (mb_strlen($name) > 32) {

            $error_msg_array[] = sprintf($lang['linkfoldernametoolong'], 32);
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifyname'];
        $valid = false;
    }

    if ($valid) {

        links_update_folder($fid, $name);
        header_redirect("links.php?webtag=$webtag&fid=$fid");
    }

}else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

    if (!in_array($fid, array_keys($folders))) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['mustspecifyvalidfolder']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['mustspecifyfolder']);
    html_draw_bottom();
    exit;
}

html_draw_top("title={$lang['links']} » {$lang['editfolder']}");

echo "<h1>{$lang['links']} &raquo; {$lang['editfolder']}</h1>\n";
echo "<p>{$lang['editingfolder']}: <b>". links_display_folder_path($fid, $folders, false) . "</b></p>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '500', 'left');
}

echo "<form accept-charset=\"utf-8\" name=\"folderadd\" action=\"links_folder_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("fid", htmlentities_array($fid)) . "\n";
echo "  ", form_input_hidden("mode", LINKS_ADD_FOLDER) . "\n";
echo "  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['foldername']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['name']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text('name', isset($name) ? htmlentities_array($name) : htmlentities_array($folders[$fid]['NAME']), 50, 32), "</td>\n";
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
echo "      <td align=\"center\">", form_submit('update', $lang['update']), "&nbsp;", form_submit('cancel', $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>