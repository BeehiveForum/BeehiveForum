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

/* $Id: edit_relations.php,v 1.76 2007-08-16 15:38:12 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Start output here

html_draw_top("openprofile.js", "basetarget=_blank");

echo "<h1>{$lang['userrelationships']}</h1>\n";

$uid = bh_session_get_value('UID');

if (isset($_GET['main_page']) && is_numeric($_GET['main_page'])) {
    $main_page = $_GET['main_page'];
    $start_main = floor($main_page - 1) * 10;
}else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = $_POST['main_page'];
    $start_main = floor($main_page - 1) * 10;
}else {
    $main_page = 1;
    $start_main = 0;
}

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
    $start_search = floor($search_page - 1) * 10;
}else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = $_POST['search_page'];
    $start_search = floor($search_page - 1) * 10;
}else {
    $search_page = 1;
    $start_search = 0;
}

if (isset($_GET['usersearch']) && strlen(trim(_stripslashes($_GET['usersearch']))) > 0) {
    $usersearch = trim(_stripslashes($_GET['usersearch']));
}else if (isset($_POST['usersearch']) && strlen(trim(_stripslashes($_POST['usersearch']))) > 0) {
    $usersearch = trim(_stripslashes($_POST['usersearch']));
}else {
    $usersearch = "";
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_relationships']) && is_array($_POST['delete_relationships'])) {

        foreach($_POST['delete_relationships'] as $peer_uid => $delete_relationship) {

            if (($delete_relationship == "Y")) {

                if (!user_rel_update($uid, $peer_uid, 0)) {

                    $valid = false;
                    $error_msg_array[] = $lang['failedtoremoveselectedrelationships'];
                }
            }
        }

        if ($valid) {

            $redirect = "./edit_relations.php?webtag=$webtag&relupdated=true";
            header_redirect($redirect, $lang['relationshipsupdated']);
            exit;
        }
    }
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['relupdated'])) {

    html_display_success_msg($lang['relationshipsupdated'], '600', 'left');
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_relations.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
echo "  ", form_input_hidden("usersearch", _htmlentities($usersearch)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">{$lang['user']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">{$lang['relationship']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">{$lang['signature']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">{$lang['personalmessages']}</td>\n";
echo "                </tr>\n";

$user_peers = user_get_relationships($uid, $start_main);

if (sizeof($user_peers['user_array']) > 0) {

    foreach ($user_peers['user_array'] as $user_peer) {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">", form_checkbox("delete_relationships[{$user_peer['UID']}]", "Y", false), "</td>\n";
        echo "                  <td align=\"left\">&nbsp;<a href=\"user_rel.php?webtag=$webtag&amp;uid={$user_peer['UID']}&ret=edit_relations.php%3Fwebtag%3D$webtag\" target=\"_self\">", format_user_name($user_peer['LOGON'], $user_peer['PEER_NICKNAME']), "</a></td>\n";

        if ($user_peer['RELATIONSHIP'] & USER_FRIEND) {

            echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /></td>\n";

        }elseif ($user_peer['RELATIONSHIP'] & USER_IGNORED) {

            echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" /></td>\n";

        }elseif ($user_peer['RELATIONSHIP'] & USER_IGNORED_COMPLETELY) {

            echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /></td>\n";

        }else {

            echo "                  <td align=\"center\">{$lang['normal']}</td>\n";
        }

        if ($user_peer['RELATIONSHIP'] & USER_IGNORED_SIG) {

            echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" /></td>\n";

        }else {

            echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['display']}\" title=\"{$lang['display']}\" /></td>\n";
        }

        if ($user_peer['RELATIONSHIP'] & USER_BLOCK_PM) {

            echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['block']}\" title=\"{$lang['block']}\" /></td>\n";

        }else {

            echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['allow']}\" title=\"{$lang['allow']}\" /></td>\n";
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"3\">{$lang['norelationships']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (sizeof($user_peers['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links("edit_relations.php?webtag=$webtag&usersearch=$usersearch&search_page=$search_page", $start_main, $user_peers['user_count'], 10, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($usersearch) && strlen(trim($usersearch)) > 0) {

    echo "<form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("usersearch", _htmlentities($usersearch)), "\n";
    echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
    echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">{$lang['user']}</td>\n";
    echo "                  <td align=\"center\" class=\"subhead\">{$lang['relationship']}</td>\n";
    echo "                  <td align=\"center\" class=\"subhead\">{$lang['signature']}</td>\n";
    echo "                  <td align=\"center\" class=\"subhead\">{$lang['personalmessages']}</td>\n";
    echo "                </tr>\n";

    $user_search_array = user_search($usersearch, $start_search, $uid);

    if (sizeof($user_search_array['results_array']) > 0) {

        foreach ($user_search_array['results_array'] as $user_peer) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" width=\"20\">&nbsp;</td>\n";
            echo "                  <td align=\"left\">&nbsp;<a href=\"user_rel.php?webtag=$webtag&amp;uid={$user_peer['UID']}&ret=edit_relations.php%3Fwebtag%3D$webtag\" target=\"_self\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";

            if ($user_peer['RELATIONSHIP'] & USER_FRIEND) {

                echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /></td>\n";

            }elseif ($user_peer['RELATIONSHIP'] & USER_IGNORED) {

                echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" /></td>\n";

            }elseif ($user_peer['RELATIONSHIP'] & USER_IGNORED_COMPLETELY) {

                echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignoredcompletely']}\" title=\"{$lang['ignoredcompletely']}\" /></td>\n";

            }else {

                echo "                  <td align=\"center\">{$lang['normal']}</td>\n";
            }

            if ($user_peer['RELATIONSHIP'] & USER_IGNORED_SIG) {

                echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['ignored']}\" title=\"{$lang['ignored']}\" /></td>\n";

            }else {

                echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['display']}\" title=\"{$lang['display']}\" /></td>\n";
            }

            if ($user_peer['RELATIONSHIP'] & USER_BLOCK_PM) {

                echo "                  <td align=\"center\"><img src=\"", style_image("enemy.png"), "\" alt=\"{$lang['block']}\" title=\"{$lang['block']}\" /></td>\n";

            }else {

                echo "                  <td align=\"center\"><img src=\"", style_image("friend.png"), "\" alt=\"{$lang['allow']}\" title=\"{$lang['allow']}\" /></td>\n";
            }
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" width=\"20\">&nbsp;</td>\n";
        echo "                  <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";

    if (sizeof($user_search_array['results_array']) > 0) {

        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links("edit_relations.php?webtag=$webtag&usersearch=$usersearch&main_page=$main_page", $start_search, $user_search_array['results_count'], 10, "search_page"), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

echo "<form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">\n";
echo "                          {$lang['username']}: ", form_input_text("usersearch", isset($usersearch) ? _htmlentities($usersearch) : "", 30, 64), " ", form_submit('submit', $lang['search']), "\n";
echo "                        </td>\n";
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
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>
