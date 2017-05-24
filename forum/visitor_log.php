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
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'visitor_log.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Arrays to hold success and error messages
$error_msg_array = array();

// Arrays to hold header and dropdown text
$profile_header_array = array();
$profile_dropdown_array = array();

// Get a list of available user_prefs and profile items for the user to browse.
visitor_log_get_profile_items($profile_header_array, $profile_dropdown_array);

// Empty array for columns
$profile_items_selected_array = array();

// Check for any custom columns
if (isset($_POST['profile_selection'])) {

    if (strlen(trim($_POST['profile_selection'])) > 0) {

        $profile_selection = explode(",", $_POST['profile_selection']);

        if (!session::logged_in()) {
            $profile_selection = preg_grep('/^DOB$|^AGE$|^LAST_VISIT$/Du', $profile_selection);
        }

        foreach ($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

} else if (isset($_GET['profile_selection'])) {

    if (strlen(trim($_GET['profile_selection'])) > 0) {

        $profile_selection = explode(",", $_GET['profile_selection']);

        if (!session::logged_in()) {
            $profile_selection = preg_grep('/^DOB$|^AGE$|^LAST_VISIT$/Du', $profile_selection);
        }

        foreach ($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

} else {

    if (sizeof($profile_items_selected_array) < 1) {

        $profile_items_selected_array = array(
            'LAST_VISIT' => $profile_header_array['LAST_VISIT']
        );
    }
}

if (isset($_POST['add'])) {

    if (!session::logged_in()) {

        html_guest_error();
        exit;
    }

    if (isset($_POST['add_column']) && in_array($_POST['add_column'], array_keys($profile_header_array))) {

        $add_column = $_POST['add_column'];

        if (!in_array($add_column, array_keys($profile_items_selected_array))) {

            if (sizeof($profile_items_selected_array) < 3) {

                $profile_items_selected_array[$add_column] = $profile_header_array[$add_column];

            } else {

                $error_msg_array[] = gettext("You can only add 3 columns. To add a new column close an existing one");
            }

        } else {

            $error_msg_array[] = gettext("You have already added this column. If you want to remove it click its close button");
        }
    }

} else if (isset($_POST['remove_column']) && is_array($_POST['remove_column'])) {

    if (!session::logged_in()) {

        html_guest_error();
        exit;
    }

    list($remove_column) = array_keys($_POST['remove_column']);

    if (in_array($remove_column, array_keys($profile_items_selected_array))) {
        unset($profile_items_selected_array[$remove_column]);
    }
}

if (sizeof($profile_items_selected_array) > 0) {

    $profile_items_selected_string = implode(',', array_keys($profile_items_selected_array));
    $profile_items_selected_encoded_string = urlencode($profile_items_selected_string);

} else {

    $profile_items_selected_string = "";
    $profile_items_selected_encoded_string = "";
}

// Permitted columns to sort the results by
$sort_by_array = array_keys($profile_header_array);

array_unshift($sort_by_array, 'LOGON');

// Permitted sort directions.
$sort_dir_array = array(
    'ASC',
    'DESC'
);

// Sort column
if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sort_by_array)) {

    $sort_by = $_GET['sort_by'];

} else if (isset($_POST['sort_by']) && in_array($_POST['sort_by'], $sort_by_array)) {

    $sort_by = $_POST['sort_by'];

} else if (sizeof($profile_items_selected_array) > 0) {

    list($sort_by) = array_keys($profile_items_selected_array);

} else {

    $sort_by = 'LAST_VISIT';
}

if (isset($_POST['hide_empty']) && $_POST['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
} else if (isset($_GET['hide_empty']) && $_GET['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
} else {
    $hide_empty = 'N';
}

if (forum_get_setting('guest_show_recent', 'Y')) {

    if (isset($_POST['hide_guests']) && $_POST['hide_guests'] == 'Y') {
        $hide_guests = 'Y';
    } else if (isset($_GET['hide_guests']) && $_GET['hide_guests'] == 'Y') {
        $hide_guests = 'Y';
    } else {
        $hide_guests = 'N';
    }

} else {

    $hide_guests = 'Y';
}

// Sort direction
if (isset($_GET['sort_dir']) && in_array($_GET['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_GET['sort_dir'];
} else if (isset($_POST['sort_dir']) && in_array($_POST['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_POST['sort_dir'];
} else {
    $sort_dir = 'DESC';
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? intval($_POST['page']) : 1;
} else {
    $page = 1;
}

if (isset($_POST['user_search']) && strlen(trim($_POST['user_search'])) > 0) {
    $user_search = trim($_POST['user_search']);
} else if (isset($_GET['user_search']) && strlen(trim($_GET['user_search'])) > 0) {
    $user_search = trim($_GET['user_search']);
} else {
    $user_search = "";
}

if (isset($_POST['clear_search'])) {
    $user_search = "";
}

html_draw_top(
    array(
        'title' => gettext("Visitor Log"),
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Visitor Log"), "</h1>\n";

$user_profile_array = visitor_log_browse_items($user_search, $profile_items_selected_array, $page, $sort_by, $sort_dir, $hide_empty == 'Y', $hide_guests == 'Y');

if (sizeof($user_profile_array['user_array']) < 1) {

    html_display_error_msg(gettext("Your search did not return any matches. Try simplifying your search parameters and try again."), '85%', 'center');

} else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '85%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_visitor_log\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  ", form_input_hidden('sort_by', htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden('hide_empty', htmlentities_array($hide_empty)), "\n";
echo "  ", form_input_hidden('hide_guests', htmlentities_array($hide_guests)), "\n";
echo "  ", form_input_hidden('profile_selection', htmlentities_array($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\">\n";

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
    echo "                     <a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">", gettext("Member"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
    echo "                     <a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">", gettext("Member"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                     <a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">", gettext("Member"), "</a>\n";
} else {
    echo "                     <a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">", gettext("Member"), "</a>\n";
}

echo "                   </td>\n";
echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\" width=\"20%\">\n";

foreach ($profile_items_selected_array as $key => $profile_item_selected) {

    if ($sort_by == $key && $sort_dir == 'ASC') {
        echo "                     ", form_submit_image('close', "remove_column[$key]", gettext("Close"), sprintf('title="%s"', gettext("Close")), "profile_browse_close button_image"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a>\n";
        echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
    } else if ($sort_by == $key && $sort_dir == 'DESC') {
        echo "                     ", form_submit_image('close', "remove_column[$key]", gettext("Close"), sprintf('title="%s"', gettext("Close")), "profile_browse_close button_image"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a>\n";
        echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
    } else if ($sort_dir == 'ASC') {
        echo "                     ", form_submit_image('close', "remove_column[$key]", gettext("Close"), sprintf('title="%s"', gettext("Close")), "profile_browse_close button_image"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a>\n";
    } else {
        echo "                     ", form_submit_image('close', "remove_column[$key]", gettext("Close"), sprintf('title="%s"', gettext("Close")), "profile_browse_close button_image"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", htmlentities_array($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a>\n";
    }
}

echo "                   </td>\n";
echo "                 </tr>\n";

if (sizeof($user_profile_array['user_array']) > 0) {

    foreach ($user_profile_array['user_array'] as $user_array) {

        echo "                 <tr>\n";

        if (isset($_SESSION['SHOW_AVATARS']) && ($_SESSION['SHOW_AVATARS'] == 'Y')) {

            if (isset($user_array['AVATAR_URL']) && filter_var($user_array['AVATAR_URL'], FILTER_VALIDATE_URL)) {

                echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\">\n";
                echo "                     ", html_style_image('profile_image profile_image_small', format_user_name($user_array['LOGON'], $user_array['NICKNAME']), null, array('background-image' => sprintf("url('%s')", $user_array['AVATAR_URL']))), "\n";
                echo "                   </td>\n";

            } else if (isset($user_array['AVATAR_AID']) && is_numeric($user_array['AVATAR_AID'])) {

                $attachment = attachments_get_by_aid($user_array['AVATAR_AID'], $user_array['UID']);

                if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false)) !== false) {

                    echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\">\n";
                    echo "                     ", html_style_image('profile_image profile_image_small', format_user_name($user_array['LOGON'], $user_array['NICKNAME']), null, array('background-image' => sprintf("url('%s&amp;profile_picture')", $profile_picture_href))), "\n";
                    echo "                   </td>\n";

                } else {

                    echo "                   <td align=\"left\" valign=\"top\" class=\"postbody\">", html_style_image('bullet', gettext("User")), "</td>\n";
                }

            } else {

                echo "                   <td align=\"left\" valign=\"top\" class=\"postbody\">", html_style_image('bullet', gettext("User")), "</td>\n";
            }

        } else {

            echo "                   <td align=\"left\" valign=\"top\" class=\"postbody\">", html_style_image('bullet', gettext("User")), "</td>\n";
        }

        if (isset($user_array['SID']) && !is_null($user_array['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><a href=\"{$user_array['URL']}\" target=\"_blank\">", word_filter_add_ob_tags($user_array['NAME'], true), "</a></td>\n";

        } else if ($user_array['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_array['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($user_array['LOGON'], $user_array['NICKNAME']), true), "</a></td>\n";

        } else {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\">", word_filter_add_ob_tags(format_user_name($user_array['LOGON'], $user_array['NICKNAME']), true), "</td>\n";
        }

        foreach ($profile_items_selected_array as $key => $profile_item_selected) {

            if (is_numeric($key) && isset($user_array["ENTRY_$key"])) {

                if (($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_RADIO) || ($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_DROPDOWN)) {

                    $profile_item_options_array = explode("\n", $user_array["PROFILE_ITEM_OPTIONS_$key"]);

                    if (isset($profile_item_options_array[$user_array["ENTRY_$key"]])) {

                        echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", htmlentities_array($profile_item_options_array[$user_array["ENTRY_$key"]]), "\">", word_filter_add_ob_tags($profile_item_options_array[$user_array["ENTRY_$key"]], true), "&nbsp;</div></td>\n";

                    } else {

                        echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"\">&nbsp;</div></td>\n";
                    }

                } else if ($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_HYPERLINK) {

                    $profile_item_hyper_link = str_replace("[ProfileEntry]", word_filter_add_ob_tags(urlencode($user_array["ENTRY_$key"])), $user_array["PROFILE_ITEM_OPTIONS_$key"]);
                    $profile_item_hyper_link = sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $profile_item_hyper_link, word_filter_add_ob_tags($user_array["ENTRY_$key"], true));

                    echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", word_filter_add_ob_tags($user_array["ENTRY_$key"], true), "\">$profile_item_hyper_link&nbsp;</div></td>\n";

                } else {

                    echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", htmlentities_array($user_array["ENTRY_$key"]), "\">", word_filter_add_ob_tags($user_array["ENTRY_$key"], true), "&nbsp;</div></td>\n";
                }

            } else if (isset($profile_header_array[$key]) && isset($user_array[$key])) {

                echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", htmlentities_array($user_array[$key]), "\">", word_filter_add_ob_tags($user_array[$key], true), "&nbsp;</div></td>\n";

            } else {

                echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"\">&nbsp;</div></td>\n";
            }
        }

        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" width=\"40%\">&nbsp;</td>\n";
echo "            <td align=\"center\" style=\"white-space: nowrap\" width=\"20%\">";

html_page_links("visitor_log.php?webtag=$webtag&page=$page&profile_selection=$profile_items_selected_encoded_string&user_search=$user_search&sort_by=$sort_by&sort_dir=$sort_dir&hide_empty=$hide_empty&hide_guests=$hide_guests", $page, $user_profile_array['user_count'], 10);

echo "            </td>\n";
echo "            <td align=\"right\" style=\"white-space: nowrap\" width=\"40%\">", form_dropdown_array('add_column', $profile_dropdown_array), "&nbsp;", form_submit('add', gettext("Add")), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<form accept-charset=\"utf-8\" name=\"f_options\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  ", form_input_hidden('sort_by', htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden('profile_selection', htmlentities_array($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
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
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("hide_empty", "Y", gettext("Hide rows with empty or null values in selected columns"), $hide_empty == 'Y'), "</td>\n";
echo "                      </tr>\n";

if (forum_get_setting('guest_show_recent', 'Y')) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("hide_guests", "Y", gettext("Show Registered Users only (hide Guests)"), $hide_guests == 'Y'), "</td>\n";
    echo "                      </tr>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<form accept-charset=\"utf-8\" name=\"f_user_search\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  ", form_input_hidden('sort_by', htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden('hide_empty', htmlentities_array($hide_empty)), "\n";
echo "  ", form_input_hidden('hide_guests', htmlentities_array($hide_guests)), "\n";
echo "  ", form_input_hidden('profile_selection', htmlentities_array($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
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
echo "                        <td class=\"posthead\" align=\"left\">", gettext("Username"), ": ", form_input_text('user_search', htmlentities_array($user_search), 30, 64), " ", form_submit('search', gettext("Search")), " ", form_submit('clear_search', gettext("Clear")), "</td>\n";
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