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

/* $Id: admin_user_groups_edit_users.php,v 1.35 2006-12-12 21:42:26 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (isset($_POST['back'])) {
    header_redirect("./admin_user_groups.php?webtag=$webtag");
}

html_draw_top("openprofile.js");

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {
    $gid = $_GET['gid'];
}elseif (isset($_POST['gid']) && is_numeric($_POST['gid'])) {
    $gid = $_POST['gid'];
}else {
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['error']}</h2>\n";
    html_draw_bottom();
    exit;
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

if (isset($_GET['usersearch']) && strlen(trim(_stripslashes($_GET['usersearch']))) > 0) {
    $usersearch = trim(_stripslashes($_GET['usersearch']));
}else if (isset($_POST['usersearch']) && strlen(trim(_stripslashes($_POST['usersearch']))) > 0) {
    $usersearch = trim(_stripslashes($_POST['usersearch']));
}else {
    $usersearch = "";
}

if (isset($_POST['add'])) {

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach($_POST['add_user'] as $uid) {

            if (!perm_user_in_group($uid, $gid)) {

                perm_add_user_to_group($uid, $gid);

                $group_name = perm_get_group_name($gid);
                $user_logon = user_get_logon($uid);

                admin_add_log_entry(ADD_USER_TO_GROUP, array($user_logon, $group_name));
            }
        }
    }
}

if (isset($_POST['remove'])) {

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        foreach($_POST['remove_user'] as $uid) {

            if (perm_user_in_group($uid, $gid)) {

                perm_remove_user_from_group($uid, $gid);

                $group_name = perm_get_group_name($gid);
                $user_logon = user_get_logon($uid);

                admin_add_log_entry(REMOVE_USER_FROM_GROUP, array($user_logon, $group_name));
            }
        }
    }
}

$group = perm_get_group($gid);

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageusergroups']} &raquo; {$group['GROUP_NAME']} &raquo; {$lang['addremoveusers']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_user_groups_edit_users.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('gid', $gid), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['users']}</td>\n";
echo "                </tr>\n";

$group_users_array = perm_group_get_users($gid, $start_main);

if (sizeof($group_users_array['user_array']) > 0) {

    foreach($group_users_array['user_array'] as $user) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" width=\"20\">", form_checkbox("remove_user[]", $user['UID'], "", false), "</td>\n";
        echo "                  <td align=\"left\">", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['nousersingroup']}</td>\n";
    echo "                </tr>\n";
}

echo "                 <tr>\n";
echo "                   <td align=\"left\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (sizeof($group_users_array['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&search_page=$search_page", $start_main, $group_users_array['user_count'], 20, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", $lang['removeselectedusers']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($usersearch) && strlen(trim($usersearch)) > 0) {

    echo "<form method=\"post\" action=\"admin_user_groups_edit_users.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('gid', $gid), "\n";
    echo "  ", form_input_hidden("usersearch", $usersearch), "\n";
    echo "  ", form_input_hidden("main_page", $main_page), "\n";
    echo "  ", form_input_hidden("search_page", $search_page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['searchresults']}</td>\n";
    echo "                </tr>\n";

    $user_search_array = admin_user_search($usersearch, 'USER.LOGON', 'ASC', 0, $start_search);

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" width=\"20\">", form_checkbox("add_user[]", $user['UID'], "", false), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user['UID']}, '$webtag')\" target=\"_self\">", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</a></td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">{$lang['nomatches']}</td>\n";
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

    if (sizeof($user_search_array['user_array']) > 0) {

        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&main_page=$main_page", $start_search, $user_search_array['user_count'], 20, "search_page"), "</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("add", $lang['addselectedusers']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

echo "<form method=\"post\" action=\"admin_user_groups_edit_users.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('gid', $gid), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['search']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">\n";
echo "                          {$lang['username']}: ", form_input_text("usersearch", isset($usersearch) ? $usersearch : "", 30, 64), " ", form_submit('submit', $lang['search']), "\n";
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
echo "</div>\n";

html_draw_bottom();


?>