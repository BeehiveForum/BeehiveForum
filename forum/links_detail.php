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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

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
require_once("./include/lang.inc.php");

if(!bh_session_check()){
    $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (!$show_links) {
    html_draw_top();
    echo "<h2>{$lang['maynotaccessthissection']}</h2>\n";
    html_draw_bottom();
    exit;
}

$error = false;
if (isset($HTTP_POST_VARS['submit']) && bh_session_get_value('UID') != 0) {
    if ($HTTP_POST_VARS['type'] == "vote") {
        if (isset($HTTP_POST_VARS['vote'])) {
            links_vote($HTTP_POST_VARS['lid'], $HTTP_POST_VARS['vote'], bh_session_get_value('UID'));
        } else {
            $error = "<b>{$lang['mustchooserating']}</b>";
        }
        $lid = $HTTP_POST_VARS['lid'];
    } elseif ($HTTP_POST_VARS['type'] == "comment") {
        if ($HTTP_POST_VARS['comment'] != "") {
            $comment = addslashes(_htmlentities($HTTP_POST_VARS['comment']));
            links_add_comment($HTTP_POST_VARS['lid'], bh_session_get_value('UID'), $comment);
            $error = "<b>{$lang['commentadded']}</b>";
        } else {
            $error = "<b>{$lang['musttypecomment']}</b>";
        }
        $lid = $HTTP_POST_VARS['lid'];
    } elseif ($HTTP_POST_VARS['type'] == "moderation") {
        $creator = links_get_creator_uid($HTTP_POST_VARS['lid']);
        if (perm_is_moderator() || $creator['UID'] == bh_session_get_value('UID')) {
            if (isset($HTTP_POST_VARS['delete']) && $HTTP_POST_VARS['delete'] == "confirm") {
                links_delete($HTTP_POST_VARS['lid']);
                header_redirect("./links.php");
                exit;
            } else {
                links_update($HTTP_POST_VARS['lid'], $HTTP_POST_VARS['fid'], addslashes(_htmlentities($HTTP_POST_VARS['title'])), $HTTP_POST_VARS['uri'], addslashes(_htmlentities($HTTP_POST_VARS['description'])));
                $lid = $HTTP_POST_VARS['lid'];
            }
	    if (isset($HTTP_POST_VARS['hide']) && $HTTP_POST_VARS['hide'] == "confirm") {
	        links_change_visibility($HTTP_POST_VARS['lid'], false);
	    }elseif (!isset($HTTP_POST_VARS['hide']) || (isset($HTTP_POST_VARS['hide']) && $HTTP_POST_VARS['hide'] != "confirm")) {
	        links_change_visibility($HTTP_POST_VARS['lid'], true);
	    }
        }
    }
}

if (isset($HTTP_GET_VARS['action'])) {
    if ($HTTP_GET_VARS['action'] == "delete_comment") {
        $creator = links_get_comment_uid($HTTP_GET_VARS['cid']);
        if (perm_is_moderator() || $creator['UID'] == bh_session_get_value('UID')) links_delete_comment($HTTP_GET_VARS['cid']);
    }
}

if (!isset($HTTP_GET_VARS['lid']) && !isset($lid)) {
    html_draw_top();
    echo "<h2>{$lang['mustprovidelinkID']}</h2>\n";
    html_draw_bottom();
    exit;
} elseif (!isset($lid)) {
    $lid = $HTTP_GET_VARS['lid'];
}

$link = links_get_single($lid);
if (!$link) {
    html_draw_top();
    echo "<h2>{$lang['invalidlinkID']}</h2>\n";
    html_draw_bottom();
    exit;
}
$link['TITLE'] = _stripslashes($link['TITLE']);
$folders = links_folders_get(perm_is_moderator());

html_draw_top();
echo "<h1>{$lang['links']}: " . links_display_folder_path($link['FID'], $folders, true, true, "links.php") . "&nbsp;:&nbsp;<a href=\"links.php?lid=$lid&action=go\" target=\"_blank\">{$link['TITLE']}</a></h1>\n";
if (isset($HTTP_POST_VARS['type']) && $HTTP_POST_VARS['type'] == "vote" && bh_session_get_value('UID') != 0 && isset($HTTP_POST_VARS['vote'])) echo "<h2>Your vote has been recorded.</h2>\n";
$error = $error ? $error : "&nbsp;";
echo "<p>$error</p>\n";
echo "<table class=\"box\" cellpadding=\"5\" cellspacing=\"2\" align=\"center\">\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['address']}:</td><td class=\"posthead\"><a href=\"links.php?lid=$lid&action=go\" target=\"_blank\">{$link['URI']}</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['submittedby']}:</td><td class=\"posthead\">", (isset($link['LOGON']) ? format_user_name($link['LOGON'], $link['NICKNAME']) : "Unknown User"), "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['description']}:</td><td class=\"posthead\">" . _stripslashes($link['DESCRIPTION']) . "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['date']}:</td><td class=\"posthead\">" . format_time($link['CREATED']) . "</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['clicks']}:</td><td class=\"posthead\">{$link['CLICKS']}</td></tr>\n";
echo "<tr><td class=\"subhead\" align=\"right\">{$lang['rating']}:</td><td class=\"posthead\">";
if (isset($link['RATING']) && $link['RATING'] != "") {
    echo round($link['RATING'], 1);
    if ($link['VOTES'] == 1) {
        echo " (1 {$lang['vote']})";
    } else {
        echo " ({$link['VOTES']} {$lang['votes']})";
    }
} else {
    echo "{$lang['notratedyet']}";
}
echo "</td></tr>\n";
echo "</table>\n";

if (bh_session_get_value('UID') != 0) {
    $vote = links_get_vote($lid, bh_session_get_value('UID'));
    $vote = $vote ? $vote : -1;
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_vote\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo form_input_hidden("type", "vote") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"box\" cellspacing=\"1\" align=\"center\"><tr><td>\n";
    echo "<table cellspacing=\"0\">\n";
    echo "<tr class=\"posthead\">\n";
    echo "<td>{$lang['rate']} {$link['TITLE']}: </td>";
    echo "<td><b>{$lang['bad']} (0)</b>&nbsp;</td>\n";
    echo "<td>" . form_radio_array("vote", range(0, 10), array(0 => "&nbsp;", 1 => "&nbsp;", 2 => "&nbsp;", 3 => "&nbsp;", 4 => "&nbsp;", 5 => "&nbsp;", 6 => "&nbsp;", 7 => "&nbsp;", 8 => "&nbsp;", 9 => "&nbsp;", 10 => "&nbsp;"), $vote) . "&nbsp;</td>\n";
    echo "<td><b>(10) {$lang['good']}</b>&nbsp;</td>\n";
    echo "<td>" . form_submit("submit", $lang['voteexcmark']) . "</td>\n";
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
        echo "<tr class=\"subhead\"><td>{$lang['commentby']} ", (isset($val['LOGON']) ? format_user_name($val['LOGON'], $val['NICKNAME']) : $lang['unknownuser']), " [" . format_time($val['CREATED'], true) . "]";
        if (perm_is_moderator() || $val['UID'] == bh_session_get_value('UID')) echo " <a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?action=delete_comment&cid={$val['CID']}&lid=$lid\" class=\"threadtime\">[{$lang['delete']}]</a>";
        echo "</td></tr>\n";
        echo "<tr class=\"posthead\"><td>" . _stripslashes($val['COMMENT']) . "</td></tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p align=\"center\">{$lang['nocommentsposted']}</p>";
}

if (bh_session_get_value('UID') != 0) {
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_comment\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo form_input_hidden("type", "comment") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"box\" align=\"center\"><tr class=\"subhead\"><td>\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr><td class=\"subhead\">{$lang['addacommentabout']} {$link['TITLE']}:</td></tr>\n";
    echo "<tr><td>" . form_textarea("comment", "", 4, 60) . "</td></tr>\n";
    echo "<tr><td>" . form_submit() . "</td></tr>\n";
    echo "</table>\n";
    echo "</tr></td></table>\n";
    echo "</form>\n";
}

if (perm_is_moderator() || $link['UID'] == bh_session_get_value('UID')) {
    echo "<p>&nbsp;</p>\n";
    echo "<form name=\"link_moderation\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
    echo "<table align=\"center\" class=\"box\"><tr><td>\n";
    echo form_input_hidden("type", "moderation") . "\n";
    echo form_input_hidden("lid", $lid) . "\n";
    echo "<table class=\"posthead\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "<tr class=\"subhead\"><td colspan=\"2\">{$lang['modtools']}</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['moveto']}:</td><td>" . links_folder_dropdown($link['FID'], $folders) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['editname']}:</td><td>" . form_input_text("title", $link['TITLE'], 60, 64) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['editaddress']}:</td><td>" . form_input_text("uri", $link['URI'], 60, 255) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['editdescription']}:</td><td>" . form_input_text("description", _stripslashes($link['DESCRIPTION']), 60) . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['delete']}:</td><td>" . form_checkbox("delete", "confirm", "") . "</td></tr>\n";
    echo "<tr><td align=\"right\">{$lang['hide']}:</td><td>" . form_checkbox("hide", "confirm", "", (isset($link['VISIBLE']) && $link['VISIBLE'] == 'N')) . "</td></tr>\n";
    echo "<tr><td>&nbsp;</td><td>" . form_submit() . "</td></tr>\n";
    echo "</table>\n";
    echo "</td></tr></table\n";
    echo "</form>\n";
}
html_draw_bottom();

?>
