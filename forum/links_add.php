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

/* $Id: links_add.php,v 1.53 2004-04-29 21:01:27 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/links.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

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
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (forum_get_setting('show_links', 'N', false)) {
    html_draw_top();
    echo "<h2>{$lang['maynotaccessthissection']}.</h2>\n";
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(perm_is_moderator());

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

$error = false;

if (isset($_POST['submit']) && $_POST['mode'] == "link") {
    // validate input
    $fid = $_POST['fid'];
    $uri = $_POST['uri'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    if (!preg_match("/\b([a-z]+:\/\/([-\w]{2,}\.)*[-\w]{2,}(:\d+)?(([^\s;,.?\"'[\]() {}<>]|\S[^\s;,.?\"'[\]() {}<>])*)?)/i", $_POST['uri'])) {
        $error = $lang['notvalidURI'];
    }
    if ($name == "") $error = $lang['mustspecifyname'];
    if (!$error) {
        $name = addslashes(_htmlentities($name));
        $description = addslashes(_htmlentities($description));
        links_add($uri, $name, $description, $fid, $uid);
        header_redirect("./links.php?webtag=$webtag&fid=$fid");
        exit;
    }
} elseif (isset($_POST['submit']) && $_POST['mode'] == "folder") {
    $fid = $_POST['fid'];
    $name = $_POST['name'];
    if ($name == "") $error = $lang['mustspecifyname'];
    if (!$error) {
        $name = addslashes(_htmlentities($name));
        links_add_folder($fid, $name, true);
        header_redirect("./links.php?webtag=$webtag&fid=$fid");
        exit;
    }
} elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $fid = $_GET['fid'];
    if ($_GET['mode'] == 'link' && !in_array($fid, array_keys($folders))) { // this did use array_key_exists(), but that's only supported in PHP/4.1.0+
        html_draw_top();
        echo "<h2>{$lang['mustspecifyvalidfolder']}</h2>";
        html_draw_bottom();
        exit;
    }
} else {
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
    if ($error) echo "<h2>$error</h2>\n";
    echo "<form name=\"linkadd\" action=\"links_add.php\" method=\"POST\" target=\"_self\">\n";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo form_input_hidden("fid", $fid) . "\n";
    echo form_input_hidden("mode", "link") . "\n";
    echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr class=\"posthead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td align=\"right\">{$lang['addressurluri']}:</td><td>" . form_input_text("uri", $uri, 60, 255) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['name']}:</td><td>" . form_input_text("name", $name, 60, 64) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['description']}:</td><td>" . form_input_text("description", $description, 60) . "</td></tr>\n";
    echo "<tr><td>&nbsp;</td><td>" . form_submit() . "&nbsp;" . form_submit("cancel", $lang['cancel']) . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table>\n";
    echo "</form>\n";
    html_draw_bottom();
    exit;
}

if ($mode == "folder") {
    html_draw_top();

    echo "<h1>{$lang['links']}: {$lang['addnewfolder']}</h1>\n";
    echo "<p>{$lang['addnewfolderunder']}: <b>". links_display_folder_path($fid, $folders, false) . "</b></p>\n";
    if ($error) echo "<h2>$error</h2>\n";
    echo "<form name=\"folderadd\" action=\"links_add.php\" method=\"POST\" target=\"_self\">\n";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo form_input_hidden("fid", $fid) . "\n";
    echo form_input_hidden("mode", "folder") . "\n";
    echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr class=\"posthead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td align=\"right\">{$lang['name']}:</td><td>" . form_input_text("name", isset($name) ? $name : '', 60, 64) . "</td></tr>\n";
    echo "<tr><td>&nbsp;</td><td>" . form_submit() . "&nbsp;" . form_submit("cancel", $lang['cancel']) . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table>\n";
    echo "</form>\n";
    html_draw_bottom();
    exit;
}

?>