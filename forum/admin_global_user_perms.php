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

/* $Id: admin_global_user_perms.php,v 1.5 2005-03-21 10:43:17 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

html_draw_top("openprofile.js");

if (!(perm_has_admin_access())) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
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

if (isset($_POST['update'])) {

    if (isset($_POST['t_admin_tools']) && is_array($_POST['t_admin_tools'])) {

        $valid = true;

        $forum_tools_perm_count = perm_get_admin_tools_perm_count();
        $admin_tools_perm_count = perm_get_forum_tools_perm_count();

        foreach($_POST['t_admin_tools'] as $uid => $t_admin_tools) {

            $t_forum_tools = (isset($_POST['t_forum_tools'][$uid])) ? $_POST['t_forum_tools'][$uid] : 0;
            $new_user_perms = ((double) $t_admin_tools | (double) $t_forum_tools);

            if (($new_user_perms ^ USER_PERM_ADMIN_TOOLS) && $admin_tools_perm_count < 2) {

                $valid = false;
                $error_html = "<h2>There must be at least 1 user with Admin and Forum tools access!</h2>\n";
            }

            if (($new_user_perms ^ USER_PERM_FORUM_TOOLS) && $forum_tools_perm_count < 2) {

                $valid = false;
                $error_html = "<h2>There must be at least 1 user with Admin and Forum tools access!</h2>\n";
            }

            if ($valid) {

                echo "perm_update_global_perms($uid, $new_user_perms)<br />\n";
            }
        }
    }
}

if (isset($_POST['remove'])) {

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        $global_perm_count = perm_get_global_permissions_count();
        $global_perm_count-= sizeof($_POST['remove_user']);

        if ($global_perm_count > 0) {

            foreach($_POST['remove_user'] as $uid) {
                perm_remove_global_perms($uid);
            }

        }else {

            $error_html = "<h2>There must be at least 1 user with Admin and Forum tools access!</h2>\n";
        }
    }
}

if (isset($_POST['add'])) {

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach($_POST['add_user'] as $uid) {

            $t_admin_tools = (isset($_POST['t_admin_tools'][$uid])) ? $_POST['t_admin_tools'][$uid] : 0;
            $t_forum_tools = (isset($_POST['t_forum_tools'][$uid])) ? $_POST['t_forum_tools'][$uid] : 0;

            $new_user_perms = ((double) $t_admin_tools | (double) $t_forum_tools);

            perm_add_global_perms($uid, $new_user_perms);
        }
    }
}

echo "<h1>{$lang['admin']} : {$lang['globaluserpermissions']}</h1>\n";

if (isset($error_html)) echo $error_html;

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_global_user_perms.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
echo "    <tr>\n";
echo "      <td>{$lang['globalusershelptext']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"650\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['admintools']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['forumtools']}</td>\n";
echo "                </tr>\n";

$group_users_array = perm_get_global_permissions();

if (sizeof($group_users_array['user_array']) > 0) {

    foreach($group_users_array['user_array'] as $user) {

        echo "                <tr>\n";
        echo "                  <td width=\"50%\">&nbsp;". form_checkbox("remove_user[]", $user['UID'], "", false), "<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
        echo "                  <td>", form_radio("t_admin_tools[{$user['UID']}]", USER_PERM_ADMIN_TOOLS, $lang['yes'], $user['PERM'] & USER_PERM_ADMIN_TOOLS), "&nbsp;", form_radio("t_admin_tools[{$user['UID']}]", 0, $lang['no'], !$user['PERM'] & USER_PERM_ADMIN_TOOLS), "</td>\n";
        echo "                  <td>", form_radio("t_forum_tools[{$user['UID']}]", USER_PERM_FORUM_TOOLS, $lang['yes'], $user['PERM'] & USER_PERM_FORUM_TOOLS), "&nbsp;", form_radio("t_forum_tools[{$user['UID']}]", 0, $lang['no'], !$user['PERM'] & USER_PERM_FORUM_TOOLS), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td>{$lang['nousers']}</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_global_user_perms.php?webtag=$webtag&usersearch=$usersearch&search_page=$search_page", $start_main, $group_users_array['user_count'], 20, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", $lang['remove']), "&nbsp;", form_submit("update", $lang['update']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($usersearch) && strlen(trim($usersearch)) > 0) {

    echo "<form method=\"post\" action=\"admin_global_user_perms.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
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
    echo "                  <td class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">&nbsp;{$lang['admintools']}</td>\n";
    echo "                  <td class=\"subhead\">&nbsp;{$lang['forumtools']}</td>\n";
    echo "                </tr>\n";

    $user_search_array = admin_user_search($usersearch, 'USER.LOGON', 'ASC', $start_search);

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user) {

            echo "                <tr>\n";
            echo "                  <td width=\"50%\">&nbsp;", form_checkbox("add_user[]", $user['UID'], "", false), "<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
            echo "                  <td>", form_radio("t_admin_tools[{$user['UID']}]", USER_PERM_ADMIN_TOOLS, $lang['yes'], false), "&nbsp;", form_radio("t_admin_tools[{$user['UID']}]", 0, $lang['no'], false), "</td>\n";
            echo "                  <td>", form_radio("t_forum_tools[{$user['UID']}]", USER_PERM_FORUM_TOOLS, $lang['yes'], false), "&nbsp;", form_radio("t_forum_tools[{$user['UID']}]", 0, $lang['no'], false), "</td>\n";
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
        echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_global_user_perms.php?webtag=$webtag&usersearch=$usersearch&main_page=$main_page", $start_search, $user_search_array['user_count'], 20, "search_page"), "</td>\n";
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

echo "<form method=\"post\" action=\"admin_global_user_perms.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
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