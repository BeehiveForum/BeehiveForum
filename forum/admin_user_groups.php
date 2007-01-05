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

/* $Id: admin_user_groups.php,v 1.37 2007-01-05 22:17:06 decoyduck Exp $ */

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

if (isset($_POST['addnew'])) {
    header_redirect("./admin_user_groups_add.php?webtag=$webtag");
}

if (isset($_POST['edit_users']) && is_array($_POST['edit_users'])) {

    list($gid) = array_keys($_POST['edit_users']);
    header_redirect("./admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid");
}

html_draw_top('admin.js');

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "GROUP_NAME") {
        $sort_by = "GROUPS.GROUP_NAME";
    } elseif ($_GET['sort_by'] == "GROUP_DESC") {
        $sort_by = "GROUPS.GROUP_DESC";
    } elseif ($_GET['sort_by'] == "USER_COUNT") {
        $sort_by = "USER_COUNT";
    } else {
        $sort_by = "GROUPS.GROUP_NAME";
    }
} else {
    $sort_by = "GROUPS.GROUP_NAME";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "ASC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

if (isset($_POST['delete'])) {

    if (isset($_POST['delete_group']) && is_array($_POST['delete_group'])) {

        foreach($_POST['delete_group'] as $gid) {

            $group_name = perm_get_group_name($gid);

            perm_remove_group($gid);

            admin_add_log_entry(DELETE_USER_GROUP, $group_name);
        }
    }
}

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['usergroups']}</h1>\n";

if (isset($_GET['add_success']) && strlen(trim(_stripslashes($_GET['add_success']))) > 0) {
    echo "<h2>{$lang['successfullyaddedgroup']}: ", _stripslashes($_GET['add_success']), "</h2>\n";
}

if (isset($_GET['del_success']) && strlen(trim(_stripslashes($_GET['del_success']))) > 0) {
    echo "<h2>{$lang['successfullydeletedgroup']}: ", _stripslashes($_GET['del_success']), "</h2>\n";
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_user_groups.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";

if ($sort_by == 'GROUPS.GROUP_NAME' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=DESC&amp;page=$page\">{$lang['groups']}</a></td>\n";
}elseif ($sort_by == 'GROUPS.GROUP_NAME' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=ASC&amp;page=$page\">{$lang['groups']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=ASC&amp;page=$page\">{$lang['groups']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=DESC&amp;page=$page\">{$lang['groups']}</a></td>\n";
}

if ($sort_by == 'GROUPS.GROUP_DESC' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=DESC&amp;page=$page\">{$lang['description']}</a></td>\n";
}elseif ($sort_by == 'GROUPS.GROUP_DESC' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=ASC&amp;page=$page\">{$lang['description']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=ASC&amp;page=$page\">{$lang['description']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=DESC&amp;page=$page\">{$lang['description']}</a></td>\n";
}

if ($sort_by == 'USER_COUNT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" class=\"header_sort_asc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">{$lang['users']}</a></td>\n";
}elseif ($sort_by == 'USER_COUNT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" class=\"header_sort_desc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">{$lang['users']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">{$lang['users']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">{$lang['users']}</a></td>\n";
}

echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
echo "                </tr>\n";

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

$user_groups_array = perm_get_user_groups($start, $sort_by, $sort_dir);

if (sizeof($user_groups_array['user_groups_array']) > 0) {

    foreach ($user_groups_array['user_groups_array'] as $user_group) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("delete_group[]", $user_group['GID'], "", false), "</td>\n";
        echo "                  <td align=\"left\"><a href=\"admin_user_groups_edit.php?webtag=$webtag&amp;gid={$user_group['GID']}\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\">{$user_group['GROUP_DESC']}</td>\n";
        echo "                  <td align=\"left\" width=\"100\">{$user_group['USER_COUNT']}</td>\n";
        echo "                  <td width=\"180\" align=\"center\">", form_submit("edit_users[{$user_group['GID']}]", $lang['addremoveusers']), "&nbsp;</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\">{$lang['nousergroups']}</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $user_groups_array['user_groups_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("addnew", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>