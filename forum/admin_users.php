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
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
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

// Array to hold error messages
$error_msg_array = array();

// Friendly display names for column sorting
$sort_by_array = array(
    'LOGON' => gettext("Logon"),
    'LAST_VISIT' => gettext("Last Logon"),
    'REGISTERED' => gettext("Registered"),
    'ACTIVE' => gettext("Active")
);

// Column sorting stuff
if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } else if ($_GET['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_VISIT";
    } else if ($_GET['sort_by'] == "REGISTERED") {
        $sort_by = "REGISTERED";
    } else if ($_GET['sort_by'] == "ACTIVE") {
        $sort_by = "ACTIVE";
    } else {
        $sort_by = "LAST_VISIT";
    }

} else if (isset($_POST['sort_by'])) {

    if ($_POST['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } else if ($_POST['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_VISIT";
    } else if ($_POST['sort_by'] == "REGISTERED") {
        $sort_by = "REGISTERED";
    } else if ($_POST['sort_by'] == "ACTIVE") {
        $sort_by = "ACTIVE";
    } else {
        $sort_by = "LAST_VISIT";
    }

} else {

    $sort_by = "LAST_VISIT";
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

} else if (isset($_POST['sort_dir'])) {

    if ($_POST['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

} else {

    $sort_dir = "DESC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else {
    $page = 1;
}

if (isset($_GET['user_search']) && strlen(trim($_GET['user_search'])) > 0) {
    $user_search = trim($_GET['user_search']);
} else if (isset($_POST['user_search']) && strlen(trim($_POST['user_search'])) > 0) {
    $user_search = trim($_POST['user_search']);
} else {
    $user_search = "";
}

if (isset($_GET['reset']) || isset($_POST['reset'])) {
    $user_search = "";
}

if (isset($_GET['filter']) && is_numeric($_GET['filter'])) {
    $filter = $_GET['filter'];
} else if (isset($_POST['filter']) && is_numeric($_POST['filter'])) {
    $filter = $_POST['filter'];
} else {
    $filter = ADMIN_USER_FILTER_NONE;
}

html_draw_top(
    array(
        'title' => gettext('Admin - Manage Users'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Users"), "</h1>\n";

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

    if (isset($_POST['select_action'])) {

        if (isset($_POST['action']) && is_numeric($_POST['action'])) {

            if ($_POST['action'] == ADMIN_USER_OPTION_END_SESSION) {

                $valid = true;

                if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

                    $kick_users = array_filter(array_keys($_POST['user_update']), 'is_numeric');

                    $kick_user_success_array = array();

                    foreach ($kick_users as $user_uid) {

                        if (($valid && $user_logon = user_get_logon($user_uid))) {

                            if (!admin_session_end($user_uid)) {

                                $error_msg_array[] = sprintf(gettext("Failed to end session for user %s"), $user_logon);
                                $valid = false;
                            }
                        }
                    }

                    if ($valid) {

                        $redirect_uri = "admin_users.php?webtag=$webtag&page=$page";
                        $redirect_uri .= "&sort_by=$sort_by&sort_dir=$sort_dir&filter=$filter";
                        $redirect_uri .= "&user_search=%s&kicked=true";

                        header_redirect(sprintf($redirect_uri, htmlentities_array($user_search)));
                        exit;
                    }
                }
            }

        } else if ($_POST['action'] == ADMIN_USER_OPTION_APPROVE) {

            if (forum_get_setting('require_user_approval', 'Y')) {

                $valid = true;

                if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

                    $approve_users = array_filter(array_keys($_POST['user_update']), 'is_numeric');

                    $approved_user_success_array = array();

                    foreach ($approve_users as $user_uid) {

                        if (($valid && $user_logon = user_get_logon($user_uid))) {

                            if (admin_approve_user($user_uid)) {

                                email_send_user_approved_notification($user_uid);

                            } else {

                                $error_msg_array[] = sprintf(gettext("Failed to approve user %s"), $user_logon);
                                $valid = false;
                            }
                        }
                    }

                    if ($valid) {

                        $redirect_uri = "admin_users.php?webtag=$webtag&page=$page";
                        $redirect_uri .= "&sort_by=$sort_by&sort_dir=$sort_dir&filter=$filter";
                        $redirect_uri .= "&user_search=%s&approved=true";

                        header_redirect(sprintf($redirect_uri, htmlentities_array($user_search)));
                        exit;
                    }
                }
            }
        }
    }
}

if (isset($user_search) && strlen($user_search) > 0) {
    $admin_user_array = admin_user_search($user_search, $sort_by, $sort_dir, $filter, $page);
} else {
    $admin_user_array = admin_user_get_all($sort_by, $sort_dir, $filter, $page);
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (isset($_GET['kicked'])) {

    html_display_success_msg(gettext("Successfully ended sessions for selected users"), '86%', 'center');

} else if (isset($_GET['approved'])) {

    html_display_success_msg(gettext("Successfully approved selected users"), '86%', 'center');

} else if (sizeof($admin_user_array['user_array']) < 1) {

    if (isset($user_search) && strlen($user_search) > 0) {

        html_display_error_msg(gettext("Your search did not return any matches. Try simplifying your search parameters and try again."), '86%', 'center');

    } else {

        html_display_error_msg(gettext("No user accounts matching filter"), '86%', 'center');
    }

} else {

    html_display_warning_msg(sprintf(gettext("This list shows a selection of users who have logged on to your forum, sorted by %s. To alter a user's permissions click their name."), htmlentities_array($sort_by_array[$sort_by])), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" action=\"admin_users.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('user_search', htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" colspan=\"3\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" width=\"20\">&nbsp;</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">\n";

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("User"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("User"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("User"), "</a>\n";
} else {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("User"), "</a>\n";
}

echo "                   </td>\n";
echo "                   <td class=\"subhead\" align=\"left\">\n";

if ($sort_by == 'LAST_VISIT' && $sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Last Logon"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'LAST_VISIT' && $sort_dir == 'DESC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Last Logon"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Last Logon"), "</a>\n";
} else {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Last Logon"), "</a>\n";
}

echo "                   </td>\n";
echo "                   <td class=\"subhead\" align=\"left\">\n";

if ($sort_by == 'REGISTERED' && $sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Registered"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'REGISTERED' && $sort_dir == 'DESC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Registered"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Registered"), "</a>\n";
} else {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Registered"), "</a>\n";
}

echo "                   </td>\n";
echo "                   <td class=\"subhead\" align=\"left\">\n";

if ($sort_by == 'ACTIVE' && $sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Active"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'ACTIVE' && $sort_dir == 'DESC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Active"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Active"), "</a>\n";
} else {
    echo "                     <a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">", gettext("Active"), "</a>\n";
}

echo "                   </td>\n";
echo "                 </tr>\n";

if (sizeof($admin_user_array['user_array']) > 0) {

    foreach ($admin_user_array['user_array'] as $user) {

        echo "                 <tr>\n";
        echo "                   <td align=\"center\">", form_checkbox("user_update[{$user['UID']}]", "Y"), "</td>\n";
        echo "                   <td class=\"posthead\" align=\"left\" width=\"35%\" style=\"white-space: nowrap\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid=", $user['UID'], "\">", word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</a></td>\n";

        if (isset($user['LAST_VISIT']) && $user['LAST_VISIT'] > 0) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_date_time($user['LAST_VISIT']), "</td>\n";
        } else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", gettext("Unknown"), "</td>\n";
        }

        if (isset($user['REGISTERED']) && $user['REGISTERED'] > 0) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_date_time($user['REGISTERED']), "</td>\n";
        } else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", gettext("Unknown"), "</td>\n";
        }

        if (isset($user['ID'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>", gettext("Yes"), "</b></td>\n";
        } else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", gettext("No"), "</td>\n";
        }

        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"50%\">";

html_page_links("admin_users.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir&user_search=$user_search&filter=$filter", $page, $admin_user_array['user_count'], 10);

echo "      </td>\n";

if (forum_get_setting('require_user_approval', 'Y') && (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0))) {

    echo "      <td class=\"postbody\" align=\"right\" width=\"25%\" style=\"white-space: nowrap\">", gettext("User filter"), ":&nbsp;", form_dropdown_array("filter", array(ADMIN_USER_FILTER_NONE => gettext("All"), ADMIN_USER_FILTER_ONLINE => gettext("Online users"), ADMIN_USER_FILTER_OFFLINE => gettext("Offline users"), ADMIN_USER_FILTER_BANNED => gettext("Banned users"), ADMIN_USER_FILTER_APPROVAL => gettext("Users awaiting approval")), $filter), "&nbsp;", form_submit("change_filter", gettext("Go")), "</td>\n";

} else {

    echo "      <td class=\"postbody\" align=\"right\" width=\"25%\" style=\"white-space: nowrap\">", gettext("User filter"), ":&nbsp;", form_dropdown_array("filter", array(ADMIN_USER_FILTER_NONE => gettext("All"), ADMIN_USER_FILTER_ONLINE => gettext("Online users"), ADMIN_USER_FILTER_OFFLINE => gettext("Offline users"), ADMIN_USER_FILTER_BANNED => gettext("Banned users")), $filter), "&nbsp;", form_submit("change_filter", gettext("Go")), "</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && sizeof($admin_user_array['user_array']) > 0) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Options"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";

    if (forum_get_setting('require_user_approval', 'Y')) {

        echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\">", gettext("With selected"), ":&nbsp;</td>\n";
        echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" width=\"100%\">", form_dropdown_array("action", array(-1 => '&nbsp;', ADMIN_USER_OPTION_END_SESSION => gettext("End Session (Kick)"), ADMIN_USER_OPTION_APPROVE => gettext("Approve")), null, null, 'bhlogondropdown'), "&nbsp;", form_submit("select_action", gettext("Go")), "</td>\n";

    } else {

        echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\">", gettext("With selected"), ":&nbsp;</td>\n";
        echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" width=\"100%\">", form_dropdown_array("action", array(-1 => '&nbsp;', ADMIN_USER_OPTION_END_SESSION => gettext("End Session (Kick)")), null, null, 'bhlogondropdown'), "&nbsp;", form_submit("select_action", gettext("Go")), "</td>\n";
    }

    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "  <br />\n";
echo "</form>\n";
echo "<form accept-charset=\"utf-8\" action=\"admin_users.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden("filter", htmlentities_array($filter)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">", gettext("Search for a user not in list"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">", gettext("Username"), ": ", form_input_text('user_search', htmlentities_array($user_search), 25, 64), " ", form_submit('search', gettext("Search")), " ", form_submit('reset', gettext("Clear")), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
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