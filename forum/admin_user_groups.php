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

/* $Id: admin_user_groups.php,v 1.62 2008-10-26 16:46:24 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
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

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (isset($_POST['addnew'])) {
    header_redirect("admin_user_groups_add.php?webtag=$webtag");
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
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
    } elseif ($_GET['sort_by'] == "GROUP_PERMS") {
        $sort_by = "GROUP_PERMS";
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

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_group']) && is_array($_POST['delete_group'])) {

        foreach ($_POST['delete_group'] as $gid) {

            if (($group_name = perm_get_group_name($gid))) {

                if (perm_remove_group($gid)) {

                    admin_add_log_entry(DELETE_USER_GROUP, $group_name);

                }else {

                    $error_msg_array[] = sprintf($lang['failedtodeletegroupname'], $group_name);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_user_groups.php?webtag=$webtag&deleted=true");
            exit;
        }
    }
}

html_draw_top('admin.js');

$user_groups_array = perm_get_user_groups($start, $sort_by, $sort_dir);

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['usergroups']}</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg($lang['successfullyaddedgroup'], '600', 'center');

}else if (isset($_GET['edited'])) {

    html_display_success_msg($lang['successfullyeditedgroup'], '600', 'center');

}else if (isset($_GET['deleted'])) {

    html_display_success_msg($lang['successfullydeletedselectedgroups'], '600', 'center');

}else if (sizeof($user_groups_array['user_groups_array']) < 1) {

    html_display_warning_msg($lang['nousergroups'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_folders\" action=\"admin_user_groups.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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

if ($sort_by == 'GROUP_PERMS' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"center\" class=\"header_sort_asc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=DESC&amp;page=$page\">{$lang['groupstatus']}</a></td>\n";
}elseif ($sort_by == 'GROUP_PERMS' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"center\" class=\"header_sort_desc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=ASC&amp;page=$page\">{$lang['groupstatus']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=ASC&amp;page=$page\">{$lang['groupstatus']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=DESC&amp;page=$page\">{$lang['groupstatus']}</a></td>\n";
}

if ($sort_by == 'USER_COUNT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"center\" class=\"header_sort_asc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">{$lang['users']}</a></td>\n";
}elseif ($sort_by == 'USER_COUNT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"center\" class=\"header_sort_desc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">{$lang['users']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">{$lang['users']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">{$lang['users']}</a></td>\n";
}

echo "                </tr>\n";

if (sizeof($user_groups_array['user_groups_array']) > 0) {

    foreach ($user_groups_array['user_groups_array'] as $user_group) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" valign=\"top\">", form_checkbox("delete_group[]", $user_group['GID'], "", false), "</td>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" valign=\"top\"><a href=\"admin_user_groups_edit.php?webtag=$webtag&amp;gid={$user_group['GID']}\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";

        if (isset($user_group['GROUP_DESC']) && strlen(trim($user_group['GROUP_DESC'])) > 0) {

            $group_desc_short = (strlen(trim($user_group['GROUP_DESC'])) > 25) ? substr($user_group['GROUP_DESC'], 0, 22). "&hellip;" : $user_group['GROUP_DESC'];

            echo "                  <td align=\"left\" valign=\"top\" width=\"30%\" nowrap=\"nowrap\"><div title=\"", word_filter_add_ob_tags($user_group['GROUP_DESC']), "\">", word_filter_add_ob_tags($group_desc_short), "</div></td>\n";

        }else {

            echo "                  <td align=\"left\" valign=\"top\" width=\"30%\">&nbsp;</td>\n";
        }

        if (isset($user_group['GROUP_PERMS']) && $user_group['GROUP_PERMS'] > 0) {
            echo "                  <td align=\"center\" valign=\"top\" width=\"120\">", perm_display_list($user_group['GROUP_PERMS']), "</td>\n";
        }else {
            echo "                  <td align=\"center\" valign=\"top\" width=\"120\">{$lang['none']}</td>\n";
        }

        echo "                  <td align=\"center\" width=\"75\" valign=\"top\"><a href=\"admin_user_groups_edit_users.php?webtag=$webtag&amp;gid={$user_group['GID']}\">{$user_group['USER_COUNT']}</a></td>\n";
        echo "                </tr>\n";
    }
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
echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_user_groups.php?webtag=$webtag&sort_dir=$sort_dir&sort_by=$sort_by", $start, $user_groups_array['user_groups_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("addnew", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td colspan=\"4\" class=\"subhead\" align=\"left\" nowrap=\"nowrap\">Permissions Key</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table width=\"95%\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>AT</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">{$lang['groupcanaccessadmintools']}</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>LM</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">{$lang['groupcanmoderatelinkssection']}</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>UW</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">{$lang['groupiswormed']}</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>FM</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">{$lang['groupcanmoderateallfolders']}</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>UB</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">{$lang['groupisbanned']}</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" colspan=\"8\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>