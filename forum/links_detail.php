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

// Compress the output
require_once("./include/gzipenc.inc.php");
require_once("./include/html.inc.php");
require_once("./include/links.inc.php");
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/format.inc.php");
require_once("./include/form.inc.php");
require_once("./include/perm.inc.php");
require_once("./include/config.inc.php");

if(!bh_session_check()){
    $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (!$show_links) {
    html_draw_top();
    echo "<h2>You may not access this section.</h2>\n";
    html_draw_bottom();
    exit;
}

$error = false;
if (isset($HTTP_POST_VARS['submit']) && $HTTP_COOKIE_VARS['bh_sess_uid'] != 0) {
    if ($HTTP_POST_VARS['type'] == "vote") {
        if (isset($HTTP_POST_VARS['vote'])) {
            links_vote($HTTP_POST_VARS['lid'], $HTTP_POST_VARS['vote'], $HTTP_COOKIE_VARS['bh_sess_uid']);
        } else {
            $error = "<b>You must choose a rating!</b>";
        }
        $lid = $HTTP_POST_VARS['lid'];
    } elseif ($HTTP_POST_VARS['type'] == "comment") {
        if ($HTTP_POST_VARS['comment'] != "") {
            $comment = addslashes(htmlentities($HTTP_POST_VARS['comment']));
            links_add_comment($HTTP_POST_VARS['lid'], $HTTP_COOKIE_VARS['bh_sess_uid'], $comment);
            $error = "<b>Your comment was added.</b>";
        } else {
            $error = "<b>You must type a comment!</b>";
        }
        $lid = $HTTP_POST_VARS['lid'];
    } elseif ($HTTP_POST_VARS['type'] == "moderation") {
        $creator = links_get_creator_uid($HTTP_POST_VARS['lid']);
        if (perm_is_moderator() || $creator['UID'] == $HTTP_COOKIE_VARS['bh_sess_uid']) {
            if ($HTTP_POST_VARS['delete'] == "confirm") {
                links_delete($HTTP_POST_VARS['lid']);
                header_redirect("links.php");
                exit;
            } else {
                links_update($HTTP_POST_VARS['lid'], $HTTP_POST_VARS['fid'], addslashes(htmlentities($HTTP_POST_VARS['title'])), $HTTP_POST_VARS['uri'], addslashes(htmlentities($HTTP_POST_VARS['description'])));
                $lid = $HTTP_POST_VARS['lid'];
            }
        }
    }
}

if (isset($HTTP_GET_VARS['action'])) {
    if ($HTTP_GET_VARS['action'] == "delete_comment") {
        $creator = links_get_comment_uid($HTTP_GET_VARS['cid']);
        if (perm_is_moderator() || $creator['UID'] == $HTTP_COOKIE_VARS['bh_sess_uid']) links_delete_comment($HTTP_GET_VARS['cid']);
    }
}

if (!isset($HTTP_GET_VARS['lid']) && !isset($lid)) {
    html_draw_top();
    echo "<h2>You must provide a link ID!</h2>\n";
    html_draw_bottom();
    exit;
} elseif (!isset($lid)) {
    $lid = $HTTP_GET_VARS['lid'];
}

$link = links_get_single($lid);
if (!$link) {
    html_draw_top();
    echo "<h2>Invalid link ID!</h2>\n";
    html_draw_bottom();
    exit;
}
$link['TITLE'] = _stripslashes($link['TITLE']);
$folders = links_folders_get(perm_is_moderator());

html_draw_top();
echo "<h1>Links: " . links_display_folder_path($link['FID'], $folders, true, true, "links.php") . "&nbsp;:&nbsp;<a href=\"links.php?lid=$lid&action=go\" target=\"_blank\">{$link['TITLE']}</a></h1>\n";
if (isset($HTTP_POST_VARS['type']) && $HTTP_POST_VARS['type'] == "vote" && $HTTP_COOKIE_VARS['bh_sess_uid'] != 0 && isset($HTTP_POST_VARS['vote'])) echo "<h2>Your vote has been recorded.</h2>\n";
$error = $error ? $error : "&nbsp;";
echo "<p>$error</p>\n";
echo "<table class=\"box\" cellpadding=\"5\" cellspacing=\"2\" align=\"center\">\n";
echo "<tr><td class=\"subhead\" align=\"right\">Address:</td><td class=\"posthead\"><a href=\"links.php?lid=$lid&action=go\" target=\"_blank\">{$link['URI']}</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">Submitted by:</td><td class=\"posthead\">" . format_user_name($link['LOGON'], $link['NICKNAME']) . "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">Description:</td><td class=\"posthead\">" . _stripslashes($link['DESCRIPTION']) . "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">Date:</td><td class=\"posthead\">" . format_time($link['CREATED']) . "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">Clicks:</td><td class=\"posthead\">{$link['CLICKS']}</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">Rating:</td><td class=\"posthead\">";
if ($link['RATING'] != "") {
    echo round($link['RATING'], 1);
    if ($link['VOTES'] == 1) {
        echo " (1 vote)";
    } else {
        echo " ({$link['VOTES']} votes)";
    }
} else {
    echo "Not rated by anyone yet";
}
echo "</td></tr>\n";
echo "</table>\n";

if ($HTTP_COOKIE_VARS['bh_sess_uid'] != 0) {
    $vote = links_get_vote($lid, $HTTP_COOKIE_VARS['bh_sess_uid']);
    $vote = $vote ? $vote : -1;
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_vote\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo form_input_hidden("type", "vote") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"box\" cellspacing=\"1\" align=\"center\"><tr><td>\n";
    echo "<table cellspacing=\"0\">\n";
    echo "<tr class=\"posthead\">\n";
    echo "<td>Rate {$link['TITLE']}: </td>";
    echo "<td><b>Bad (0)</b>&nbsp;</td>\n";
    echo "<td>" . form_radio_array("vote", range(0, 10), array(0 => "&nbsp;", 1 => "&nbsp;", 2 => "&nbsp;", 3 => "&nbsp;", 4 => "&nbsp;", 5 => "&nbsp;", 6 => "&nbsp;", 7 => "&nbsp;", 8 => "&nbsp;", 9 => "&nbsp;", 10 => "&nbsp;"), $vote) . "&nbsp;</td>\n";
    echo "<td><b>(10) Good</b>&nbsp;</td>\n";
    echo "<td>" . form_submit("submit", "Vote!") . "</td>\n";
    echo "</tr>";
    echo "</table>";
    echo "</td></tr></table>\n";
    echo "</form>\n";
}

echo "<p>&nbsp;</p>\n";
$comments = links_get_comments($lid);
if ($comments) {
    echo "<table width=\"90%\" align=\"center\">\n";
    while (list($key, $val) = each($comments)) {
        echo "<tr class=\"subhead\"><td>Comment by " . format_user_name($val['LOGON'], $val['NICKNAME']) . " [" . format_time($val['CREATED'], true) . "]";
        if (perm_is_moderator() || $val['UID'] == $HTTP_COOKIE_VARS['bh_sess_uid']) echo " <a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?action=delete_comment&cid={$val['CID']}&lid=$lid\" class=\"threadtime\">[delete]</a>";
        echo "</td></tr>\n";
        echo "<tr class=\"posthead\"><td>" . _stripslashes($val['COMMENT']) . "</td></tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p align=\"center\">No comments have yet been posted.</p>";
}

if ($HTTP_COOKIE_VARS['bh_sess_uid'] != 0) {
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_comment\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo form_input_hidden("type", "comment") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"box\" align=\"center\"><tr class=\"subhead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td class=\"subhead\">Add a comment about {$link['TITLE']}:</td></tr>\n";
    echo "<tr><td>" . form_textarea("comment", "", 4, 60) . "</td></tr>\n";
    echo "<tr><td>" . form_submit() . "</td></tr>\n";
    echo "</table>\n";
    echo "</tr></td></table>\n";
    echo "</form>\n";
}

if (perm_is_moderator() || $link['UID'] == $HTTP_COOKIE_VARS['bh_sess_uid']) {
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_moderation\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo "<table align=\"center\" class=\"box\"><tr><td>\n";
    echo form_input_hidden("type", "moderation") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr class=\"subhead\"><td colspan=\"2\">Moderation Tools</td></tr>\n";
    echo "<tr><td align=\"right\">Move to:</td><td>" . links_folder_dropdown($link['FID'], $folders) . "</td></tr>\n";
    echo "<tr><td align=\"right\">Edit name:</td><td>" . form_input_text("title", $link['TITLE'], 60, 64) . "</td></tr>\n";
    echo "<tr><td align=\"right\">Edit address:</td><td>" . form_input_text("uri", $link['URI'], 60, 255) . "</td></tr>\n";
    echo "<tr><td align=\"right\">Edit description:</td><td>" . form_input_text("description", _stripslashes($link['DESCRIPTION']), 60) . "</td></tr>\n";
    echo "<tr><td align=\"right\">Delete:</td><td>" . form_checkbox("delete", "confirm", "") . "</td></tr>\n";
    echo "<tr><td>&nbsp;</td><td>" . form_submit() . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table\n";
    echo "</form>\n";
}
html_draw_bottom();

?>
