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

/* $Id: edit_relations.php,v 1.37 2004-11-06 20:26:25 decoyduck Exp $ */

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

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_rel.inc.php");

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

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Start output here

html_draw_top("openprofile.js", "basetarget=_blank");

echo "<h1>{$lang['userrelationships']}</h1>\n";

$uid = bh_session_get_value('UID');

// Array to store the update texts in

$update_array = array();

if (isset($_POST['submit'])) {
    if (isset($_POST['relationship']) && is_array($_POST['relationship'])) {
        foreach ($_POST['relationship'] as $peer_uid => $peer_rel) {
            if (isset($_POST['signature'][$peer_uid])) {
                $peer_rel = $peer_rel | $_POST['signature'][$peer_uid];
            }
            if ($peer_uid != $uid) {
                if (user_rel_update($uid, $peer_uid, $peer_rel)) {
                    if (!in_array($lang['relationshipsupdated'], $update_array)) {
                        $update_array[] = $lang['relationshipsupdated'];
                    }
                }else {
                    $update_array[] = $lang['relationshipupdatefailed'];
                }
            }
        }
    }
}

if (isset($_POST['add'])) {
    if (isset($_POST['add_relationship']) && is_array($_POST['add_relationship'])) {
        foreach ($_POST['add_relationship'] as $peer_uid => $peer_rel) {
            if (isset($_POST['add_signature'][$peer_uid])) {
                $peer_rel = $peer_rel | $_POST['add_signature'][$peer_uid];
            }
            if ($peer_uid != $uid) {
                if (user_rel_update($uid, $peer_uid, $peer_rel)) {
                    if (!in_array($lang['relationshipsupdated'], $update_array)) {
                        $update_array[] = $lang['relationshipsupdated'];
                    }
                }else {
                    $update_array[] = $lang['relationshipupdatefailed'];
                }
            }
        }
    }
}

if (isset($_GET['main_page']) && is_numeric($_GET['main_page'])) {
    $main_page = $_GET['main_page'];
    $start_main = floor($main_page - 1) * 20;
}else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = $_POST['main_page'];
    $start_main = floor($main_page - 1) * 20;
}else {
    $main_page = 1;
    $start_main = 0;
}

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
    $start_search = floor($search_page - 1) * 20;
}else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = $_POST['search_page'];
    $start_search = floor($search_page - 1) * 20;
}else {
    $search_page = 1;
    $start_search = 0;
}

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($update_array) && is_array($update_array) && sizeof($update_array) > 0) {
    foreach($update_array as $update_text) {
        echo "<h2>$update_text</h2>\n";
    }
}

echo "<br />\n";

echo "<form name=\"prefs\" action=\"edit_relations.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";

if (isset($_POST['usersearch']) && strlen(trim($_POST['usersearch'])) > 0) {
    echo "  ", form_input_hidden("usersearch", trim($_POST['usersearch'])), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td width=\"50%\" class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['relationship']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['signature']}</td>\n";
echo "                </tr>\n";

$user_peers = user_get_relationships($uid, $start_main);

if (sizeof($user_peers['user_array']) > 0) {

    foreach ($user_peers['user_array'] as $user_peer) {
        echo "                <tr>\n";
        echo "                  <td>&nbsp;<a href=\"javascript:void(0);\" onclick=\"openProfile({$user_peer['UID']}, '$webtag')\" target=\"_self\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";
        echo "                  <td nowrap=\"nowrap\">\n";
        echo "                    &nbsp;", form_radio("relationship[{$user_peer['UID']}]", USER_FRIEND, "", ($user_peer['RELATIONSHIP']&USER_FRIEND)), "<img src=\"", style_image("friend.png"), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />\n";
        echo "                    &nbsp;", form_radio("relationship[{$user_peer['UID']}]", 0, "", !($user_peer['RELATIONSHIP']&USER_FRIEND) && !($user_peer['RELATIONSHIP']&USER_IGNORED)), "{$lang['normal']}\n";
        echo "                    &nbsp;", form_radio("relationship[{$user_peer['UID']}]", USER_IGNORED, "", ($user_peer['RELATIONSHIP']&USER_IGNORED)), "<img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" />\n";
        echo "                    &nbsp;", form_radio("relationship[{$user_peer['UID']}]", USER_IGNORED_COMPLETELY, "", ($user_peer['RELATIONSHIP']&USER_IGNORED_COMPLETELY)), "<img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" />\n";
        echo "                  </td>\n";
        echo "                  <td nowrap=\"nowrap\">\n";
        echo "                    &nbsp;", form_radio("signature[{$user_peer['UID']}]", 0, "", !($user_peer['RELATIONSHIP']&USER_IGNORED_SIG)), "{$lang['display']}\n";
        echo "                    &nbsp;", form_radio("signature[{$user_peer['UID']}]", USER_IGNORED_SIG, "", ($user_peer['RELATIONSHIP']&USER_IGNORED_SIG)), "{$lang['ignore']}\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td colspan=\"3\">&nbsp;{$lang['norelationships']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (sizeof($user_peers['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(), $start_main, $user_peers['user_count'], 20, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($_POST['usersearch']) && strlen(trim($_POST['usersearch'])) > 0) {

    $usersearch = trim($_POST['usersearch']);

    echo "<form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("usersearch", $usersearch), "\n";
    echo "  ", form_input_hidden("main_page", $main_page), "\n";
    echo "  ", form_input_hidden("search_page", $search_page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
    echo "    <tr>\n";
    echo "      <td class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td width=\"50%\" class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">&nbsp;{$lang['relationship']}</td>\n";
    echo "                  <td class=\"subhead\">&nbsp;{$lang['signature']}</td>\n";
    echo "                </tr>\n";

    $user_search_array = user_search($usersearch, $start_search);

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user) {

            if ($user['UID'] != $uid) {

                echo "                <tr>\n";
                echo "                  <td>&nbsp;<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
                echo "                  <td>\n";
                echo "                    &nbsp;", form_radio("add_relationship[{$user['UID']}]", USER_FRIEND, "", false), "<img src=\"", style_image("friend.png"), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />\n";
                echo "                    &nbsp;", form_radio("add_relationship[{$user['UID']}]", 0, "", true), "{$lang['normal']}\n";
                echo "                    &nbsp;", form_radio("add_relationship[{$user['UID']}]", USER_IGNORED, "", false), "<img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" />\n";
                echo "                    &nbsp;", form_radio("add_relationship[{$user['UID']}]", USER_IGNORED_COMPLETELY, "", false), "<img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" />\n";
                echo "                  </td>\n";
                echo "                  <td>\n";
                echo "                    &nbsp;", form_radio("add_signature[{$user['UID']}]", 0, "", true), "{$lang['display']}\n";
                echo "                    &nbsp;", form_radio("add_signature[{$user['UID']}]", USER_IGNORED_SIG, "", false), "{$lang['ignore']}\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
            }
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td class=\"posthead\" colspan=\"7\" align=\"left\">&nbsp;{$lang['nomatches']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";

    if (sizeof($user_search_array['user_array']) > 0) {

        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(), $start_search, $user_search_array['user_count'], 20, "search_page"), "</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("add", $lang['add']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

echo "<form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
echo "    <tr>\n";
echo "      <td class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['search']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['username']}: ", form_input_text("usersearch", isset($usersearch) ? $usersearch : "", 30, 64), " ", form_submit('submit', $lang['search']), "\n";
echo "                  </td>\n";
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
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>
