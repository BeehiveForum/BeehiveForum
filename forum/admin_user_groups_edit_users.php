<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Are we returning somewhere?
if (isset($_GET['ret']) && strlen(trim($_GET['ret'])) > 0) {
    $ret = rawurldecode(trim($_GET['ret']));
} else if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = trim($_POST['ret']);
} else {
    $ret = "admin_user_groups.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_pages = array(
        'admin_user_groups_edit.php',
        'admin_users_groups.php',
        'admin_user.php'
    );

    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/u", basename($ret)) < 1) {
        $ret = "admin_user_groups.php?webtag=$webtag";
    }
}

// Return to the page we came from.
if (isset($_POST['back'])) {
    header_redirect($ret);
}

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {

    $gid = intval($_GET['gid']);

} else if (isset($_POST['gid']) && is_numeric($_POST['gid'])) {

    $gid = intval($_POST['gid']);

} else {

    html_draw_error(gettext("Supplied GID is not a user group"), 'admin_user_groups.php', 'get', array('back' => gettext("Back")));
}

if (isset($_GET['main_page']) && is_numeric($_GET['main_page'])) {
    $main_page = intval($_GET['main_page']);
    $start_main = floor($main_page - 1) * 20;
} else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = intval($_POST['main_page']);
    $start_main = floor($main_page - 1) * 20;
} else {
    $main_page = 1;
    $start_main = 0;
}

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = intval($_GET['search_page']);
    $start_search = floor($search_page - 1) * 20;
} else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = intval($_POST['search_page']);
    $start_search = floor($search_page - 1) * 20;
} else {
    $search_page = 1;
    $start_search = 0;
}

if (isset($_GET['usersearch']) && strlen(trim($_GET['usersearch'])) > 0) {
    $usersearch = trim($_GET['usersearch']);
} else if (isset($_POST['usersearch']) && strlen(trim($_POST['usersearch'])) > 0) {
    $usersearch = trim($_POST['usersearch']);
} else {
    $usersearch = "";
}

if (isset($_POST['add'])) {

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach ($_POST['add_user'] as $uid) {

            if (!perm_user_in_group($uid, $gid)) {

                perm_add_user_to_group($uid, $gid);

                if (($user_logon = user_get_logon($uid)) && ($group_name = perm_get_group_name($gid))) {

                    admin_add_log_entry(ADD_USER_TO_GROUP, array($user_logon, $group_name));
                }
            }
        }
    }
}

if (isset($_POST['remove'])) {

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        foreach ($_POST['remove_user'] as $uid) {

            if (perm_user_in_group($uid, $gid)) {

                perm_remove_user_from_group($uid, $gid);

                if (($user_logon = user_get_logon($uid)) && ($group_name = perm_get_group_name($gid))) {

                    admin_add_log_entry(REMOVE_USER_FROM_GROUP, array($user_logon, $group_name));
                }
            }
        }
    }
}

if (!$group = perm_get_group($gid)) {
    html_draw_error(gettext("Supplied GID is not a user group"), 'admin_user_groups.php', 'get', array('back' => gettext("Back")));
}

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Admin - Manage User Groups - %s - Add/Remove Users'),
            $group['GROUP_NAME']
        ),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$group_users_array = perm_group_get_users($gid, $start_main);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User Groups"), html_style_image('separator'), "{$group['GROUP_NAME']}", html_style_image('separator'), "", gettext("Add/Remove Users"), "</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg(gettext("Successfully added group. Add users to this group by searching for them below."), '800', 'center');

} else if (sizeof($group_users_array['user_array']) < 1) {

    html_display_warning_msg(gettext("There are no users in this group. Add users to this group by searching for them below."), '800', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_folders\" action=\"admin_user_groups_edit_users.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('gid', htmlentities_array($gid)), "\n";
echo "  ", form_input_hidden("main_page", htmlentities_array($main_page)), "\n";
echo "  ", form_input_hidden("search_page", htmlentities_array($search_page)), "\n";
echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Users"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (sizeof($group_users_array['user_array']) > 0) {

    foreach ($group_users_array['user_array'] as $user) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"1%\">", form_checkbox("remove_user[]", $user['UID']), "</td>\n";
        echo "                        <td align=\"left\">", word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</td>\n";
        echo "                      </tr>\n";
    }
}

echo "                       <tr>\n";
echo "                         <td align=\"left\">&nbsp;</td>\n";
echo "                       </tr>\n";
echo "                     </table>\n";
echo "                   </td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">";

    html_page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&search_page=$search_page", $start_main, $group_users_array['user_count'], 20, "main_page");

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", gettext("Remove Selected Users")), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($usersearch) && strlen(trim($usersearch)) > 0) {

    $user_search_array = admin_user_search($usersearch, 'LOGON', 'ASC', 0, $start_search);

    if (sizeof($user_search_array['user_array']) < 1) {
        html_display_warning_msg(gettext("Search Returned No Results"), '800', 'center');
    }

    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_user_groups_edit_users.php\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('gid', htmlentities_array($gid)), "\n";
    echo "  ", form_input_hidden("usersearch", htmlentities_array($usersearch)), "\n";
    echo "  ", form_input_hidden("main_page", htmlentities_array($main_page)), "\n";
    echo "  ", form_input_hidden("search_page", htmlentities_array($search_page)), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"posthead\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Search Results"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"1%\">", form_checkbox("add_user[]", $user['UID']), "</td>\n";
            echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</a></td>\n";
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
        echo "      <td class=\"postbody\" align=\"center\">";

        html_page_links("admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid&usersearch=$usersearch&main_page=$main_page", $start_search, $user_search_array['user_count'], 20, "search_page");

        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("add", gettext("Add Selected Users")), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_user_groups_edit_users.php\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('gid', htmlentities_array($gid)), "\n";
echo "  ", form_input_hidden("main_page", htmlentities_array($main_page)), "\n";
echo "  ", form_input_hidden("search_page", htmlentities_array($search_page)), "\n";
echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">", gettext("Search"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">\n";
echo "                          ", gettext("Username"), ": ", form_input_text("usersearch", isset($usersearch) ? htmlentities_array($usersearch) : "", 30, 64), " ", form_submit('search', gettext("Search")), "\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("back", gettext("Back")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();