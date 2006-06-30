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

/* $Id: links_add.php,v 1.72 2006-06-30 18:07:33 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (!forum_get_setting('show_links', 'Y')) {

    html_draw_top();
    echo "<h1>{$lang['maynotaccessthissection']}</h1>\n";
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
        exit;
}

$uid = bh_session_get_value('UID');

if (isset($_POST['cancel'])) header_redirect("./links.php?webtag=$webtag&fid={$_POST['fid']}");

if (isset($_GET['mode'])) {

    if ($_GET['mode'] == 'link') {

        $mode = 'link';

    }elseif ($_GET['mode'] = 'folder') {

        $mode = 'folder';

    }else {

        $mode = 'link';
    }

} elseif (isset($_POST['mode'])) {

    if ($_POST['mode'] == 'link') {

        $mode = 'link';

    }elseif ($_POST['mode'] = 'folder') {

        $mode = 'folder';

    }else {

        $mode = 'link';
    }

} else {

    $mode = "link";
}

if (isset($_POST['submit']) && $mode == "link") {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $fid = 1;
    }

    if (isset($_POST['uri']) && preg_match("/\b([a-z]+:\/\/([-\w]{2,}\.)*[-\w]{2,}(:\d+)?(([^\s;,.?\"'[\]() {}<>]|\S[^\s;,.?\"'[\]() {}<>])*)?)/i", $_POST['uri'])) {
        $uri = $_POST['uri'];
    }else {
        $error_html = $lang['notvalidURI'];
        $valid = false;
    }

    if (isset($_POST['name']) && strlen(trim(_stripslashes($_POST['name']))) > 0) {
        $name = trim(_stripslashes($_POST['name']));
    }else {
        $error_html = $lang['mustspecifyname'];
        $valid = false;
    }

    if (isset($_POST['description']) && strlen(trim(_stripslashes($_POST['description']))) > 0) {
        $description = trim(_stripslashes($_POST['description']));
    }else {
        $description = "";
    }

    if ($valid) {

        links_add($uri, $name, $description, $fid, $uid);
        header_redirect("./links.php?webtag=$webtag&fid=$fid");
    }

}else if (isset($_POST['submit']) && $mode == "folder") {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $fid = 1;
    }

    if (isset($_POST['name']) && strlen(trim(_stripslashes($_POST['name']))) > 0) {
        $name = trim(_stripslashes($_POST['name']));
    }else {
        $error_html = $lang['mustspecifyname'];
        $valid = false;
    }

    if ($valid) {

        links_add_folder($fid, $name, true);
        header_redirect("./links.php?webtag=$webtag&fid=$fid");
    }

}else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

    if ($_GET['mode'] == 'link' && !in_array($fid, array_keys($folders))) {

        html_draw_top();
        echo "<h2>{$lang['mustspecifyvalidfolder']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    echo "<h2>{$lang['mustspecifyfolder']}</h2>";
    html_draw_bottom();
    exit;
}

if ($mode == "link") {

    html_draw_top();

    if (!isset($uri)) $uri = "http://";
    if (!isset($name)) $name = "";
    if (!isset($description)) $description = "";

    echo "<h1>{$lang['links']}: {$lang['addlink']}</h1>\n";
    echo "<p>{$lang['addinglinkin']}: <b>" . links_display_folder_path($fid, $folders, false) . "</b></p>\n";

    if (isset($error)) echo "<h2>$error</h2>\n";

    echo "<form name=\"linkadd\" action=\"links_add.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("fid", $fid) . "\n";
    echo "  ", form_input_hidden("mode", "link") . "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['addlink']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"right\">{$lang['addressurluri']}:</td>\n";
    echo "                  <td>" . form_input_text("uri", $uri, 60, 255) . "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"right\">{$lang['name']}:</td>\n";
    echo "                  <td>" . form_input_text("name", $name, 60, 64) . "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"right\">{$lang['description']}:</td>\n";
    echo "                  <td>" . form_input_text("description", $description, 60) . "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    html_draw_bottom();

}elseif ($mode == "folder") {

    html_draw_top();

    echo "<h1>{$lang['links']}: {$lang['addnewfolder']}</h1>\n";
    echo "<p>{$lang['addnewfolderunder']}: <b>". links_display_folder_path($fid, $folders, false) . "</b></p>\n";

    if (isset($error_html) && strlen(trim($error_html))) {
        echo "<h2>$error_html</h2>\n";
    }

    echo "<form name=\"folderadd\" action=\"links_add.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("fid", $fid) . "\n";
    echo "  ", form_input_hidden("mode", "folder") . "\n";
    echo "  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['addnewfolder']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"right\">{$lang['name']}:</td>\n";
    echo "                  <td>", form_input_text("name", isset($name) ? $name : '', 60, 64), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    html_draw_bottom();
}

?>