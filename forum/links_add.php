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

/* $Id: links_add.php,v 1.21 2003-09-15 19:04:30 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/html.inc.php");
require_once("./include/links.inc.php");
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/form.inc.php");
require_once("./include/perm.inc.php");
require_once("./include/config.inc.php");
require_once("./include/lang.inc.php");

if(!bh_session_check()){
    $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
    exit;
}

if (!$show_links) {
    html_draw_top();
    echo "<h2>{$lang['maynotaccessthissection']}.</h2>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

$folders = links_folders_get(perm_is_moderator());

if(bh_session_get_value('UID') == 0) {
    html_guest_error();
        exit;
}

$uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['cancel'])) header_redirect("./links.php?fid={$HTTP_POST_VARS['fid']}");

if (isset($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
} elseif (isset($HTTP_POST_VARS['mode'])) {
    $mode = $HTTP_POST_VARS['mode'];
} else {
    $mode = "link";
}

$error = false;

if (isset($HTTP_POST_VARS['submit']) && $HTTP_POST_VARS['mode'] == "link") {
    // validate input
    $fid = $HTTP_POST_VARS['fid'];
    $uri = $HTTP_POST_VARS['uri'];
    $name = $HTTP_POST_VARS['name'];
    $description = $HTTP_POST_VARS['description'];
    if (!preg_match("/\b([a-z]+:\/\/([-\w]{2,}\.)*[-\w]{2,}(:\d+)?(([^\s;,.?\"'[\](){}<>]|\S[^\s;,.?\"'[\](){}<>])*)?)/i", $HTTP_POST_VARS['uri'])) {
        $error = $lang['notvalidURI'];
    }
    if ($name == "") $error = $lang['mustspecifyname'];
    if (!$error) {
        $name = addslashes(_htmlentities($name));
        $description = addslashes(_htmlentities($description));
        links_add($uri, $name, $description, $fid, $uid);
        header_redirect("./links.php?fid=$fid");
        exit;
    }
} elseif (isset($HTTP_POST_VARS['submit']) && $HTTP_POST_VARS['mode'] == "folder") {
    $fid = $HTTP_POST_VARS['fid'];
    $name = $HTTP_POST_VARS['name'];
    if ($name == "") $error = $lang['mustspecifyname'];
    if (!$error) {
        $name = addslashes(_htmlentities($name));
        links_add_folder($fid, $name, true);
        header_redirect("./links.php?fid=$fid");
        exit;
    }
} elseif (isset($HTTP_GET_VARS['fid'])) {
    $fid = $HTTP_GET_VARS['fid'];
    if ($HTTP_GET_VARS['mode'] == 'link' && !in_array($fid, array_keys($folders))) { // this did use array_key_exists(), but that's only supported in PHP/4.1.0+
        html_draw_top();
        echo "<h2>{$lang['mustspecifyvalidfolder']}</h2>";
        // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
        exit;
    }
} else {
    html_draw_top();
    echo "<h2>{$lang['mustspecifyfolder']}</h2>";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
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
    echo "<form name=\"linkadd\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">\n";
    echo form_input_hidden("fid", $fid) . "\n";
    echo form_input_hidden("mode", "link") . "\n";
    echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr class=\"posthead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td align=\"right\">{$lang['addressurluri']}:</td><td>" . form_input_text("uri", $uri, 60, 255) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['name']}:</td><td>" . form_input_text("name", $name, 60, 64) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['description']}:</td><td>" . form_input_text("description", $description, 60) . "</td></tr>\n";
    echo "<tr><td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td><td>" . form_submit() . "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>" . form_submit("cancel", $lang['cancel']) . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table>\n";
    echo "</form>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

if ($mode == "folder") {
    html_draw_top();

    echo "<h1>{$lang['links']}: {$lang['addnewfolder']}</h1>\n";
    echo "<p>{$lang['addnewfolderunder']}: <b>". links_display_folder_path($fid, $folders, false) . "</b></p>\n";
    if ($error) echo "<h2>$error</h2>\n";
    echo "<form name=\"folderadd\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">\n";
    echo form_input_hidden("fid", $fid) . "\n";
    echo form_input_hidden("mode", "folder") . "\n";
    echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr class=\"posthead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td align=\"right\">{$lang['name']}:</td><td>" . form_input_text("name", isset($name) ? $name : '', 60, 64) . "</td></tr>\n";
    echo "<tr><td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td><td>" . form_submit() . "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>" . form_submit("cancel", $lang['cancel']) . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table>\n";
    echo "</form>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

?>