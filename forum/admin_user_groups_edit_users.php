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

/* $Id: admin_user_groups_edit_users.php,v 1.12 2005-01-19 21:49:26 decoyduck Exp $ */

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

include_once("./include/admin.inc.php");
include_once("./include/attachments.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_POST['cancel'])) {
    header_redirect("./admin_user_groups.php?webtag=$webtag");
}

html_draw_top("openprofile.js");

if (!(perm_has_admin_access())) {
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
    echo "<h2>{$lang['invalidop']}</h2>\n";
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

$user_perms = perm_get_user_permissions(bh_session_get_value('UID'));
$group_permissions = perm_get_group_permissions($gid);

if (!perm_user_in_group(bh_session_get_value('UID'), $gid) && $user_perms < $group_permissions) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['add'])) {

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach($_POST['add_user'] as $uid) {

            if (!perm_user_in_group($uid, $gid)) {
                perm_add_user_to_group($uid, $gid);
            }
        }
    }
}

if (isset($_POST['remove'])) {

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        foreach($_POST['remove_user'] as $uid) {

            if (perm_user_in_group($uid, $gid)) {
                perm_remove_user_from_group($uid, $gid);
            }
        }
    }
}

$group = perm_get_group($gid);

echo "<h1>{$lang['admin']} : {$lang['manageusergroups']} : {$group['GROUP_NAME']} : {$lang['addremoveusers']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_user_groups_edit_users.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('gid', $gid), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['users']}</td>\n";
echo "                </tr>\n";

$group_users_array = perm_group_get_users($gid);

if (sizeof($group_users_array['user_array']) > 0) {

    foreach($group_users_array['user_array'] as $user) {

        echo "                <tr>\n";
        echo "                  <td>", form_checkbox("remove_user[]", $user['UID'], "", false), "&nbsp;", format_user_name($user['LOGON'], $user['NICKNAME']), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td>{$lang['nousersingroup']}</td>\n";
    echo "                </tr>\n";
}

echo "                 <tr>\n";
echo "                   <td>&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (sizeof($group_users_array['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&search_page=$search_page", $start_main, $group_users_array['user_count'], 20, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", $lang['remove']), "</td>\n";
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
    echo "      <td class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td width=\"50%\" class=\"subhead\">&nbsp;{$lang['searchresults']}</td>\n";
    echo "                </tr>\n";

    $user_search_array = admin_user_search($usersearch, 'USER.LOGON', 'ASC', $start_search);

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user) {

            echo "                <tr>\n";
            echo "                  <td>&nbsp;", form_checkbox("add_user[]", $user['UID'], "", false), "<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td class=\"posthead\" align=\"left\">&nbsp;{$lang['nomatches']}</td>\n";
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
        echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&main_page=$main_page", $start_search, $user_search_array['user_count'], 20, "search_page"), "</td>\n";
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

echo "<form method=\"post\" action=\"admin_user_groups_edit_users.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('gid', $gid), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
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
echo "</div>\n";

html_draw_bottom();


?>