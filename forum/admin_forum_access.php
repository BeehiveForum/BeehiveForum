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

/* $Id: admin_forum_access.php,v 1.83 2009-07-15 11:37:24 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
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

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) || (forum_get_setting('access_level', false, 0) == FORUM_DISABLED)) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (!$forum_fid = forum_get_setting('fid')) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['ret']) && strlen(trim(stripslashes_array($_GET['ret']))) > 0) {
    $ret = rawurldecode(trim(stripslashes_array($_GET['ret'])));
}elseif (isset($_POST['ret']) && strlen(trim(stripslashes_array($_POST['ret']))) > 0) {
    $ret = trim(stripslashes_array($_POST['ret']));
}else {
    $ret = "admin_forums.php?webtag=$webtag";
}

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename($ret)) < 1) {
        $ret = "admin_forums.php?webtag=$webtag";
    }
}

if (isset($_POST['back'])) {
    header_redirect($ret);
}

if (isset($_POST['enable'])) {

    if (forum_update_access($forum_fid, FORUM_RESTRICTED)) {

        header_redirect("admin_forum_access.php?webtag=$webtag");
        exit;
    }
}

if (!forum_get_setting('access_level', 1, false)) {

    html_draw_top();
    html_error_msg($lang['forumisnotsettorestrictedmode'], 'admin_forum_access.php', 'post', array('enable' => $lang['enable'], 'back' => $lang['back']), array('ret' => $ret), false, 'center');
    html_draw_bottom();
    exit;
}

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

if (isset($_POST['user_search']) && strlen(trim(stripslashes_array($_POST['user_search']))) > 0) {
    $user_search = trim(stripslashes_array($_POST['user_search']));
}else if (isset($_GET['user_search']) && strlen(trim(stripslashes_array($_GET['user_search']))) > 0) {
    $user_search = trim(stripslashes_array($_GET['user_search']));
}else {
    $user_search = '';
}

if (isset($_POST['clear'])) {
    $user_search = '';
}

if (isset($_POST['add'])) {

    $valid = true;

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach ($_POST['add_user'] as $add_user_uid) {

            if (($user_logon = user_get_logon($add_user_uid))) {

                if (user_update_forums($add_user_uid, $forum_fid, FORUM_USER_ALLOWED)) {

                    $forum_name = forum_get_name($forum_fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                }else {

                    $error_msg_array[] = sprintf($lang['failedtoaddpermissionsforuser'], $user_logon);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            $ret = rawurlencode($ret);
            $user_search = rawurlencode($user_search);

            header_redirect("admin_forum_access.php?webtag=$webtag&user_search=$user_search&ret=$ret&added=true");
            exit;
        }
    }

}elseif (isset($_POST['remove'])) {

    $valid = true;

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        foreach ($_POST['remove_user'] as $remove_user_uid) {

            if (($user_logon = user_get_logon($remove_user_uid))) {

                if (user_update_forums($remove_user_uid, $forum_fid, FORUM_USER_DISALLOWED)) {

                    $forum_name = forum_get_name($forum_fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                }else {

                    $error_msg_array[] = sprintf($lang['failedtoremovepermissionsfromuser'], $user_logon);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            $ret = rawurlencode($ret);
            $user_search = rawurlencode($user_search);

            header_redirect("admin_forum_access.php?webtag=$webtag&user_search=$user_search&ret=$ret&removed=true");
            exit;
        }
    }
}

html_draw_top();

$user_permissions_array = forum_get_permissions($forum_fid, $start_main);

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageforumpermissions']}</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg($lang['successfullyaddedpermissionsforselectedusers'], '500', 'center');

}else if (isset($_GET['removed'])) {

    html_display_success_msg($lang['successfullyremovedpermissionsfromselectedusers'], '500', 'center');

}else if (sizeof($user_permissions_array['user_array']) < 1) {

    html_display_warning_msg($lang['nousershavebeengrantedpermission'], '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_user\" action=\"admin_forum_access.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('ret', htmlentities_array($ret)), "\n";
echo "  ", form_input_hidden("user_search", htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden("search_page", htmlentities_array($main_page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['existingpermissions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (sizeof($user_permissions_array['user_array']) > 0) {

    foreach ($user_permissions_array['user_array'] as $user_permission_result) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("remove_user[]", $user_permission_result['UID'], ''), "&nbsp;", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_permission_result['LOGON'], $user_permission_result['NICKNAME']))), "</td>\n";
        echo "                      </tr>\n";
    }
}

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

if (sizeof($user_permissions_array['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_forum_access.php?webtag=$webtag&user_search=$user_search&search_page=$search_page", $start_main, $user_permissions_array['user_count'], 10, "main_page"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", $lang['removeselectedusers']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($user_search) && strlen(trim($user_search)) > 0) {

    $user_search_array = admin_user_search($user_search, 'LOGON', 'ASC', 0, $start_search);

    if (sizeof($user_search_array['user_array']) < 1) {
        html_display_warning_msg($lang['searchreturnednoresults'], '500', 'center');
    }

    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_access.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('ret', htmlentities_array($ret)), "\n";
    echo "  ", form_input_hidden("user_search", htmlentities_array($user_search)), "\n";
    echo "  ", form_input_hidden("main_page", htmlentities_array($main_page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['searchresults']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user_search_result) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", form_checkbox("add_user[]", $user_search_result['UID'], ''), "&nbsp;", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_search_result['LOGON'], $user_search_result['NICKNAME']))), "</td>\n";
            echo "                      </tr>\n";
        }
    }

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

    if (sizeof($user_search_array['user_array']) > 0) {

        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_forum_access.php?webtag=$webtag&user_search=$user_search&main_page=$main_page", $start_search, $user_search_array['user_count'], 10, "search_page"), "</td>\n";
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

echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_access.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('ret', htmlentities_array($ret)), "\n";
echo "  ", form_input_hidden("user_search", htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden("main_page", htmlentities_array($main_page)), "\n";
echo "  ", form_input_hidden("search_page", htmlentities_array($search_page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforuser']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['search']}: ", form_input_text('user_search', htmlentities_array($user_search), 32, 15), "&nbsp;", form_submit('search', $lang['search']), "&nbsp;", form_submit('clear', $lang['clear']), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>