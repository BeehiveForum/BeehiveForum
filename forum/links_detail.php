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

/* $Id: links_detail.php,v 1.56 2004-05-09 00:57:48 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/links.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

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
    echo "<h2>{$lang['maynotaccessthissection']}</h2>\n";
    html_draw_bottom();
    exit;
}

$error = false;
if (isset($_POST['submit']) && bh_session_get_value('UID') != 0) {
    if ($_POST['type'] == "vote") {
        if (isset($_POST['vote'])) {
            links_vote($_POST['lid'], $_POST['vote'], bh_session_get_value('UID'));
        } else {
            $error = "<b>{$lang['mustchooserating']}</b>";
        }
        $lid = $_POST['lid'];
    } elseif ($_POST['type'] == "comment") {
        if ($_POST['comment'] != "") {
            $comment = addslashes(_htmlentities($_POST['comment']));
            links_add_comment($_POST['lid'], bh_session_get_value('UID'), $comment);
            $error = "<b>{$lang['commentadded']}</b>";
        } else {
            $error = "<b>{$lang['musttypecomment']}</b>";
        }
        $lid = $_POST['lid'];
    } elseif ($_POST['type'] == "moderation") {
        $creator = links_get_creator_uid($_POST['lid']);
        if (perm_is_moderator() || $creator['UID'] == bh_session_get_value('UID')) {
            if (isset($_POST['delete']) && $_POST['delete'] == "confirm") {
                links_delete($_POST['lid']);
                header_redirect("./links.php?webtag=$webtag");
                exit;
            } else {
                links_update($_POST['lid'], $_POST['fid'], addslashes(_htmlentities($_POST['title'])), $_POST['uri'], addslashes(_htmlentities($_POST['description'])));
                $lid = $_POST['lid'];
            }
            if (isset($_POST['hide']) && $_POST['hide'] == "confirm") {
                links_change_visibility($_POST['lid'], false);
            }elseif (!isset($_POST['hide']) || (isset($_POST['hide']) && $_POST['hide'] != "confirm")) {
                links_change_visibility($_POST['lid'], true);
            }
        }
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "delete_comment") {
        $creator = links_get_comment_uid($_GET['cid']);
        if (perm_is_moderator() || $creator['UID'] == bh_session_get_value('UID')) links_delete_comment($_GET['cid']);
    }
}

if (!isset($_GET['lid']) && !isset($lid)) {
    html_draw_top();
    echo "<h2>{$lang['mustprovidelinkID']}</h2>\n";
    html_draw_bottom();
    exit;
} elseif (!isset($lid)) {
    $lid = $_GET['lid'];
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

echo "<h1>{$lang['links']}: ", links_display_folder_path($link['FID'], $folders, true, true, "./links.php?webtag=$webtag"), "&nbsp;:&nbsp;<a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">{$link['TITLE']}</a></h1>\n";

if (isset($_POST['type']) && $_POST['type'] == "vote" && bh_session_get_value('UID') != 0 && isset($_POST['vote'])) echo "<h2>Your vote has been recorded.</h2>\n";

$error = $error ? $error : "&nbsp;";

echo "<p>$error</p>\n";

echo "<div align=\"center\">\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td class=\"subhead\" colspan=\"2\">{$lang['linkdetails']}</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>{$lang['address']}:</td>\n";
echo "                <td><a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">{$link['URI']}</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>{$lang['submittedby']}:</td>\n";
echo "                <td>", (isset($link['LOGON']) ? format_user_name($link['LOGON'], $link['NICKNAME']) : "Unknown User"), "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>{$lang['description']}:</td>\n";
echo "                <td>" . _stripslashes($link['DESCRIPTION']) . "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>{$lang['date']}:</td>\n";
echo "                <td>" . format_time($link['CREATED']) . "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>{$lang['clicks']}:</td>\n";
echo "                <td>{$link['CLICKS']}</td>\n";
echo "              </tr>\n";

if (isset($link['RATING']) && is_numeric($link['RATING'])) {

    if ($link['VOTES'] == 1) {

        echo "              <tr>\n";
        echo "                <td>{$lang['rating']}:</td>\n";
        echo "                <td>(1 {$lang['vote']})</td>\n";
        echo "              </tr>\n";

    }else {

        echo "              <tr>\n";
        echo "                <td>{$lang['rating']}:</td>\n";
        echo "                <td>({$link['VOTES']} {$lang['votes']})</td>\n";
        echo "              </tr>\n";
    }

}else {

    echo "              <tr>\n";
    echo "                <td>{$lang['rating']}:</td>\n";
    echo "                <td>{$lang['notratedyet']}</td>\n";
    echo "              </tr>\n";
}

echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

if (bh_session_get_value('UID') != 0) {

    $vote = links_get_vote($lid, bh_session_get_value('UID'));
    $vote = $vote ? $vote : -1;

    echo "<form name=\"link_vote\" action=\"links_detail.php\" method=\"POST\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("type", "vote"), "\n";
    echo "  ", form_input_hidden("lid", $lid), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['rate']} {$link['TITLE']}: </td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td><b>{$lang['bad']} (0)</b>&nbsp;</td>\n";
    echo "                  <td>" . form_radio_array("vote", range(0, 10), array(0 => "&nbsp;", 1 => "&nbsp;", 2 => "&nbsp;", 3 => "&nbsp;", 4 => "&nbsp;", 5 => "&nbsp;", 6 => "&nbsp;", 7 => "&nbsp;", 8 => "&nbsp;", 9 => "&nbsp;", 10 => "&nbsp;"), $vote) . "&nbsp;</td>\n";
    echo "                  <td><b>(10) {$lang['good']}</b>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"3\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['voteexcmark']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($comments_array = links_get_comments($lid)) {

    foreach($comments_array as $comment_id => $comment) {

        echo "                <tr>\n";

        if (isset($comment['LOGON']) && isset($comment['NICKNAME'])) {
            if (perm_is_moderator() || $comment['UID'] == bh_session_get_value('UID')) {
                echo "                  <td class=\"subhead\">{$lang['commentby']} ", format_user_name($comment['LOGON'], $comment['NICKNAME']), " <a href=\"links_detail.php?webtag=$webtag&amp;action=delete_comment&amp;cid={$comment['CID']}&amp;lid=$lid\" class=\"threadtime\">[{$lang['delete']}]</a></td>\n";
            }else {
                echo "                  <td class=\"subhead\">{$lang['commentby']} ", format_user_name($comment['LOGON'], $comment['NICKNAME']), "</td>\n";
            }
        }else {
            if (perm_is_moderator()) {
                echo "                  <td class=\"subhead\">{$lang['commentby']} {$lang['unknownuser']} <a href=\"links_detail.php?webtag=$webtag&amp;action=delete_comment&amp;cid={$comment['CID']}&amp;lid=$lid\" class=\"threadtime\">[{$lang['delete']}]</a></td>\n";
            }else {
                echo "                  <td class=\"subhead\">{$lang['commentby']} {$lang['unknownuser']}</td>\n";
            }
        }

        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>" . _stripslashes($comment['COMMENT']) . "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td>{$lang['nocommentsposted']}</td>\n";
    echo "                </tr>\n";
}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";

if (bh_session_get_value('UID') != 0) {

    echo "<form name=\"link_comment\" action=\"links_detail.php\" method=\"POST\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("type", "comment"), "\n";
    echo "  ", form_input_hidden("lid", $lid), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['addacommentabout']} {$link['TITLE']}: </td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>", form_textarea("comment", "", 4, 67), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['addcomment']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

if (perm_is_moderator() || $link['UID'] == bh_session_get_value('UID')) {

    echo "<form name=\"link_moderation\" action=\"links_detail.php\" method=\"POST\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("type", "moderation") . "\n";
    echo "  ", form_input_hidden("lid", $lid) . "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['modtools']}</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['moveto']}:</td>\n";
    echo "                  <td>", links_folder_dropdown($link['FID'], $folders), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['editname']}:</td>\n";
    echo "                  <td>", form_input_text("title", $link['TITLE'], 45, 64), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['editaddress']}:</td>\n";
    echo "                  <td>", form_input_text("uri", $link['URI'], 45, 255), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['editdescription']}:</td>\n";
    echo "                  <td>", form_input_text("description", _stripslashes($link['DESCRIPTION']), 45), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['delete']}:</td>\n";
    echo "                  <td>", form_checkbox("delete", "confirm", ""), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['hide']}</td>\n";
    echo "                  <td>", form_checkbox("hide", "confirm", "", (isset($link['VISIBLE']) && $link['VISIBLE'] == 'N')), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

html_draw_bottom();

?>