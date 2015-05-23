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
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) || (forum_get_setting('access_level', FORUM_DISABLED))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

$forum_fid = forum_get_setting('fid');

if (isset($_GET['ret']) && strlen(trim($_GET['ret'])) > 0) {
    $ret = rawurldecode(trim($_GET['ret']));
} else if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = trim($_POST['ret']);
} else {
    $ret = "admin_forums.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

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

if (!forum_get_setting('access_level', FORUM_RESTRICTED)) {
    html_draw_error(gettext("Forum is not set to Restricted Mode. Do you want to enable it now?"), 'admin_forum_access.php', 'post', array(
        'enable' => gettext("Enable"),
        'back' => gettext("Back")
    ), array('ret' => $ret), '_self', 'center');
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $main_page = $_GET['main_page'];
} else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = $_POST['main_page'];
} else {
    $main_page = 1;
}

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
} else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = $_POST['search_page'];
} else {
    $search_page = 1;
}

if (isset($_POST['user_search']) && strlen(trim($_POST['user_search'])) > 0) {
    $user_search = trim($_POST['user_search']);
} else if (isset($_GET['user_search']) && strlen(trim($_GET['user_search'])) > 0) {
    $user_search = trim($_GET['user_search']);
} else {
    $user_search = '';
}

if (isset($_POST['clear'])) {
    $user_search = '';
}

if (isset($_POST['add'])) {

    $valid = true;

    if (isset($_POST['add_user']) && is_array($_POST['add_user'])) {

        foreach ($_POST['add_user'] as $add_user_uid) {

            if (($user_logon = user_get_logon($add_user_uid)) !== false) {

                if (user_update_forums($add_user_uid, $forum_fid, FORUM_USER_ALLOWED)) {

                    $forum_name = forum_get_name($forum_fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                } else {

                    $error_msg_array[] = sprintf(gettext("Failed to add permissions for user '%s'"), $user_logon);
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

} else if (isset($_POST['remove'])) {

    $valid = true;

    if (isset($_POST['remove_user']) && is_array($_POST['remove_user'])) {

        foreach ($_POST['remove_user'] as $remove_user_uid) {

            if (($user_logon = user_get_logon($remove_user_uid)) !== false) {

                if (user_update_forums($remove_user_uid, $forum_fid, FORUM_USER_DISALLOWED)) {

                    $forum_name = forum_get_name($forum_fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                } else {

                    $error_msg_array[] = sprintf(gettext("Failed to remove permissions from user '%s'"), $user_logon);
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

html_draw_top(
    array(
        'title' => gettext('Admin - Manage Forum Permissions'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$user_permissions_array = forum_get_permissions($forum_fid, $main_page);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Forum Permissions"), "</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg(gettext("Successfully added permissions for selected users"), '500', 'center');

} else if (isset($_GET['removed'])) {

    html_display_success_msg(gettext("Successfully removed permissions from selected users"), '500', 'center');

} else if (sizeof($user_permissions_array['user_array']) < 1) {

    html_display_warning_msg(gettext("No existing users permissions found. To grant permission to users search for them below."), '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_user\" action=\"admin_forum_access.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Existing Permissions"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (sizeof($user_permissions_array['user_array']) > 0) {

    foreach ($user_permissions_array['user_array'] as $user_permission_result) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("remove_user[]", $user_permission_result['UID'], null), "&nbsp;", word_filter_add_ob_tags(format_user_name($user_permission_result['LOGON'], $user_permission_result['NICKNAME']), true), "</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">";

    html_page_links("admin_forum_access.php?webtag=$webtag&user_search=$user_search&search_page=$search_page", $main_page, $user_permissions_array['user_count'], 10, "main_page");

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("remove", gettext("Remove Selected Users")), "</td>\n";
    echo "    </tr>\n";

} else {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("back", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";

if (isset($user_search) && strlen(trim($user_search)) > 0) {

    $user_search_array = admin_user_search($user_search, 'LOGON', 'ASC', 0, $search_page);

    if (sizeof($user_search_array['user_array']) < 1) {
        html_display_warning_msg(gettext("Search Returned No Results"), '500', 'center');
    }

    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_access.php\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Search Results"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user_search_result) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", form_checkbox("add_user[]", $user_search_result['UID'], null), "&nbsp;", word_filter_add_ob_tags(format_user_name($user_search_result['LOGON'], $user_search_result['NICKNAME']), true), "</td>\n";
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

        html_page_links("admin_forum_access.php?webtag=$webtag&user_search=$user_search&main_page=$main_page", $search_page, $user_search_array['user_count'], 10, "search_page");

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

echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_access.php\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
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
echo "                  <td class=\"subhead\" align=\"left\">", gettext("Search For User"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Search"), ": ", form_input_text('user_search', htmlentities_array($user_search), 32, 15), "&nbsp;", form_submit('search', gettext("Search")), "&nbsp;", form_submit('clear', gettext("Clear")), "</td>\n";
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