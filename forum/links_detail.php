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

/* $Id: links_detail.php,v 1.110 2008-08-21 20:46:15 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

if (!forum_check_webtag_available()) {
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

if (isset($_POST['lid'])) {

    $lid = $_POST['lid'];

}else if (isset($_GET['lid'])) {

    $lid = $_GET['lid'];

}else {

    html_draw_top();
    html_error_msg($lang['mustprovidelinkID']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['parent_fid'])) {
    $parent_fid = $_POST['parent_fid'];
}else if (isset($_GET['parent_fid'])) {
    $parent_fid = $_GET['parent_fid'];
}else {
    $parent_fid = 1;
}

$uid = bh_session_get_value('UID');

$creator_uid = links_get_creator_uid($lid);

$error_msg_array = array();
$success_msg = "";

if (isset($_POST['cancel'])) {

    header_redirect("links.php?webtag=$webtag");
    exit;
}

if (!user_is_guest()) {

    $valid = true;

    if (isset($_POST['addvote'])) {

        if (isset($_POST['vote']) && is_numeric($_POST['vote'])) {

            links_vote($lid, $_POST['vote'], $uid);
            $success_msg = $lang['voterecorded'];

        }else {

            $error_msg_array[] = $lang['mustchooserating'];
            $valid = false;
        }

    }else if (isset($_POST['clearvote'])) {

        links_clear_vote($lid, $uid);
        $success_msg = $lang['votecleared'];
    }

    if (isset($_POST['addcomment'])) {

        if (isset($_POST['comment']) && strlen(trim(_stripslashes($_POST['comment']))) > 0) {

            $comment = trim(_stripslashes($_POST['comment']));

            links_add_comment($lid, $uid, $comment);
            $success_msg = $lang['commentadded'];

        }else {

            $error_msg_array[] = $lang['musttypecomment'];
            $valid = false;
        }
    }

    if (isset($_POST['update']) && (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) || $creator_uid == $uid)) {

        if (isset($_POST['delete']) && $_POST['delete'] == "confirm") {

            links_delete($lid);
            header_redirect("links.php?webtag=$webtag&fid=$parent_fid");
            exit;

        }else {

            if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

                $fid = $_POST['fid'];

            }else {

                $error_msg_array[] = $lang['nofolderidspecified'];
                $valid = false;
            }

            if (isset($_POST['uri']) && preg_match('/\b([a-z]+:\/\/([-\w]{2,}\.)*[-\w]{2,}(:\d+)?(([^\s;,.?"\'[\]() {}<>]|\S[^\s;,.?"\'[\]() {}<>])*)?)/iu', $_POST['uri'])) {

                $uri = $_POST['uri'];

            }else {

                $error_msg_array[] = $lang['notvalidURI'];
                $valid = false;
            }

            if (isset($_POST['title']) && strlen(trim(_stripslashes($_POST['title']))) > 0) {

                $title = trim(_stripslashes($_POST['title']));

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

                links_update($lid, $fid, $title, $uri, $description);
            }
        }

        if (isset($_POST['hide']) && $_POST['hide'] == "confirm") {

            links_change_visibility($lid, false);

        }elseif (!isset($_POST['hide']) || (isset($_POST['hide']) && $_POST['hide'] != "confirm")) {

            links_change_visibility($lid, true);
        }
    }
}

if (isset($_GET['delete_comment']) && is_numeric($_GET['delete_comment'])) {

    $comment_id = $_GET['delete_comment'];
    $comment_uid = links_get_comment_uid($comment_id);

    if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) || $comment_uid == $uid) {

        if (links_delete_comment($comment_id)) {

            $success_msg = $lang['commentdeleted'];

        }else {

            $error_msg_array[] = $lang['commentcouldnotbedeleted'];
            $valid = false;
        }
    }
}

if (!$link = links_get_single($lid)) {

    html_draw_top();
    html_error_msg($lang['invalidlinkID']);
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

html_draw_top('openprofile.js');

echo "<h1>{$lang['links']} &raquo; ", links_display_folder_path($link['FID'], $folders, true, true, "links.php?webtag=$webtag"), "&nbsp;&raquo;&nbsp;<a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">", word_filter_add_ob_tags(_htmlentities($link['TITLE'])), "</a></h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '500', 'center');

}else if (isset($success_msg) && strlen($success_msg) > 0) {

    html_display_success_msg($success_msg, '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['linkdetails']}</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table class=\"posthead\" width=\"95%\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\" width=\"120\">{$lang['address']}:</td>\n";
echo "                      <td align=\"left\"><a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">", strlen($link['URI']) > 35 ? _htmlentities(substr($link['URI'], 0, 35)) . '&hellip;' : _htmlentities($link['URI']), "</a></td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['submittedby']}:</td>\n";
echo "                      <td align=\"left\">", (isset($link['LOGON']) ? word_filter_add_ob_tags(_htmlentities(format_user_name($link['LOGON'], $link['NICKNAME']))) : $lang['unknownuser']), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['description']}:</td>\n";
echo "                      <td align=\"left\">", word_filter_add_ob_tags(_htmlentities($link['DESCRIPTION'])), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['date']}:</td>\n";
echo "                      <td align=\"left\">", format_time($link['CREATED']), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['clicks']}:</td>\n";
echo "                      <td align=\"left\">{$link['CLICKS']}</td>\n";
echo "                    </tr>\n";

if (isset($link['RATING']) && is_numeric($link['RATING'])) {

    if ($link['VOTES'] == 1) {

        echo "                    <tr>\n";
        echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['rating']}:</td>\n";
        echo "                      <td align=\"left\">", number_format($link['RATING'], 1, ".", ","), " (1 {$lang['vote']})</td>\n";
        echo "                    </tr>\n";

    }else {

        echo "                    <tr>\n";
        echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['rating']}:</td>\n";
        echo "                      <td align=\"left\">", number_format($link['RATING'], 1, ".", ","), " ({$link['VOTES']} {$lang['votes']})</td>\n";
        echo "                    </tr>\n";
    }

}else {

    echo "                    <tr>\n";
    echo "                      <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">{$lang['rating']}:</td>\n";
    echo "                      <td align=\"left\">{$lang['notratedyet']}</td>\n";
    echo "                    </tr>\n";
}

echo "                    <tr>\n";
echo "                      <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

if (!user_is_guest()) {

    $vote = links_get_vote($lid, $uid);
    $vote = $vote ? $vote : -1;

    echo "<form accept-charset=\"utf-8\" name=\"link_vote\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("type", "vote"), "\n";
    echo "  ", form_input_hidden("lid", _htmlentities($lid)), "\n";
    echo "  ", form_input_hidden("parent_fid", _htmlentities($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['rate']} ", word_filter_add_ob_tags(_htmlentities($link['TITLE'])), "</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['bad']}&nbsp;</td>\n";
    echo "                        <td align=\"center\" nowrap=\"nowrap\">", form_radio_array("vote", range(0, 10), $vote), "&nbsp;</td>\n";
    echo "                        <td align=\"left\">{$lang['good']}&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit('addvote', $lang['voteexcmark']), "&nbsp;", form_submit('clearvote', $lang['clearvote']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

if (($comments_array = links_get_comments($lid))) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    foreach ($comments_array as $comment_id => $comment) {

        $profile_link = "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$comment['UID']}\" target=\"_blank\" onclick=\"return openProfile({$comment['UID']}, '$webtag')\">";
        $profile_link.= word_filter_add_ob_tags(_htmlentities(format_user_name($comment['LOGON'], $comment['NICKNAME']))). "</a>";

        if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) || $comment['UID'] == $uid) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", sprintf($lang['commentby'], $profile_link), " <a href=\"links_detail.php?webtag=$webtag&amp;delete_comment={$comment['CID']}&amp;lid=$lid\" class=\"threadtime\">[{$lang['delete']}]</a></td>\n";
            echo "                </tr>\n";

        }else {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", sprintf($lang['commentby'], $profile_link), "</td>\n";
            echo "                </tr>\n";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", word_filter_add_ob_tags(_htmlentities($comment['COMMENT'])), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
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
}

if (!user_is_guest()) {

    echo "<form accept-charset=\"utf-8\" name=\"link_comment\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("type", "comment"), "\n";
    echo "  ", form_input_hidden("lid", _htmlentities($lid)), "\n";
    echo "  ", form_input_hidden("parent_fid", _htmlentities($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addacommentabout']} ", word_filter_add_ob_tags(_htmlentities($link['TITLE'])), "</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_textarea("comment", "", 6, 70), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
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
    echo "      <td align=\"center\">", form_submit('addcomment', $lang['addcomment']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) || $link['UID'] == $uid) {

    echo "<form accept-charset=\"utf-8\" name=\"link_moderation\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("type", "moderation") . "\n";
    echo "  ", form_input_hidden("lid", _htmlentities($lid)) . "\n";
    echo "  ", form_input_hidden("parent_fid", _htmlentities($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['modtools']}</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['moveto']}:</td>\n";
    echo "                        <td align=\"left\">", links_folder_dropdown($link['FID'], $folders), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['editname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("title", _htmlentities($link['TITLE']), 45, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['editaddress']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("uri", _htmlentities($link['URI']), 45, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['editdescription']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("description", _htmlentities($link['DESCRIPTION']), 45), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_checkbox("delete", "confirm", $lang['delete']), "&nbsp;", form_checkbox("hide", "confirm", $lang['hide'], (isset($link['VISIBLE']) && $link['VISIBLE'] == 'N')), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit('update', $lang['save']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

echo "</div>\n";

html_draw_bottom();

?>