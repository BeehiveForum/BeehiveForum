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

/* $Id: set_relation.php,v 1.48 2004-04-29 16:53:55 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user_rel.inc.php");

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
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_GET['uid']) && isset($_GET['rel']) && is_numeric($_GET['uid']) && is_numeric($_GET['rel'])) {

    $uid  = bh_session_get_value('UID');
    $puid = $_GET['uid'];
    $rel  = $_GET['rel'];

    $relationship = user_rel_get($uid, $puid);

    if ($rel == -1) {
        $relationship = ($relationship&USER_IGNORED_SIG) ? USER_IGNORED_SIG + USER_IGNORED : USER_IGNORED;
    }else {
        $relationship = ($relationship&USER_IGNORED_SIG) ? USER_IGNORED_SIG : 0;
    }

    user_rel_update($uid, $puid, $relationship);

}else {

    html_draw_top();
    echo "<h1>Invalid Operation</h1>\n";
    echo "<h2>required information not found</h2>";
    html_draw_bottom();
    exit;

}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
    header_redirect("./messages.php?webtag=$webtag&msg=$msg");
}else {
    header_redirect("./messages.php?webtag=$webtag");
}

?>