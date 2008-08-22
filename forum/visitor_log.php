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

/* $Id: visitor_log.php,v 1.132 2008-08-22 19:07:24 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "visitor_log.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get the webtag

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

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

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

    if (strlen(trim(_stripslashes($_POST['profile_selection']))) > 0) {

        $profile_selection = explode(",", $_POST['profile_selection']);

        if (user_is_guest()) {
            $profile_selection = preg_grep('/^DOB$|^AGE$|^LAST_VISIT$/u', $profile_selection);
        }

        foreach ($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

}else if (isset($_GET['profile_selection'])) {

    if (strlen(trim(_stripslashes($_GET['profile_selection']))) > 0) {

        $profile_selection = explode(",", $_GET['profile_selection']);

        if (user_is_guest()) {
            $profile_selection = preg_grep('/^DOB$|^AGE$|^LAST_VISIT$/u', $profile_selection);
        }

        foreach ($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

}else {

    if (sizeof($profile_items_selected_array) < 1) {

        $profile_items_selected_array = array('LAST_VISIT' => $profile_header_array['LAST_VISIT']);
    }
}

if (isset($_POST['add'])) {

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    if (isset($_POST['add_column']) && in_array($_POST['add_column'], array_keys($profile_header_array))) {

        $add_column = $_POST['add_column'];

        if (!in_array($add_column, array_keys($profile_items_selected_array))) {

            if (sizeof($profile_items_selected_array) < 3) {

                $profile_items_selected_array[$add_column] = $profile_header_array[$add_column];

            }else {

                $error_msg_array[] = $lang['youcanonlyaddthreecolumns'];
            }

        }else {

            $error_msg_array[] = $lang['columnalreadyadded'];
        }
    }

}elseif (isset($_POST['remove_column']) && is_array($_POST['remove_column'])) {

    if (user_is_guest()) {

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

}else {

    $profile_items_selected_string = "";
    $profile_items_selected_encoded_string = "";
}

// Permitted columns to sort the results by

$sort_by_array = array_keys($profile_header_array);

array_unshift($sort_by_array, 'LOGON');

// Permitted sort directions.

$sort_dir_array = array('ASC', 'DESC');

// Sort column

if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sort_by_array)) {

    $sort_by = $_GET['sort_by'];

}elseif (isset($_POST['sort_by']) && in_array($_POST['sort_by'], $sort_by_array)) {

    $sort_by = $_POST['sort_by'];

}elseif (sizeof($profile_items_selected_array) > 0) {

    list($sort_by) = array_keys($profile_items_selected_array);

}else {

    $sort_by = 'LAST_VISIT';
}

if (isset($_POST['hide_empty']) && $_POST['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
}elseif (isset($_GET['hide_empty']) && $_GET['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
}else {
    $hide_empty = 'N';
}

if (forum_get_setting('guest_show_recent', 'Y')) {

    if (isset($_POST['hide_guests']) && $_POST['hide_guests'] == 'Y') {
        $hide_guests = 'Y';
    }elseif (isset($_GET['hide_guests']) && $_GET['hide_guests'] == 'Y') {
        $hide_guests = 'Y';
    }else {
        $hide_guests = 'N';
    }

}else {

    $hide_guests = 'Y';
}

// Sort direction

if (isset($_GET['sort_dir']) && in_array($_GET['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_GET['sort_dir'];
}elseif (isset($_POST['sort_dir']) && in_array($_POST['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_POST['sort_dir'];
}else {
    $sort_dir = 'DESC';
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if (isset($_POST['user_search']) && strlen(trim(_stripslashes($_POST['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_POST['user_search']));
}elseif (isset($_GET['user_search']) && strlen(trim(_stripslashes($_GET['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_GET['user_search']));
}else {
    $user_search = "";
}

if (isset($_POST['clear_search'])) {
    $user_search = "";
}

html_draw_top("openprofile.js");

echo "<h1>{$lang['userprofile']}</h1>\n";

$user_profile_array = visitor_log_browse_items($user_search, $profile_items_selected_array, $start, $sort_by, $sort_dir, $hide_empty == 'Y', $hide_guests == 'Y');

if (sizeof($user_profile_array['user_array']) < 1) {

    html_display_error_msg($lang['yoursearchdidnotreturnanymatches'], '85%', 'center');

}else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '85%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_visitor_log\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
echo "  ", form_input_hidden('sort_by', _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', _htmlentities($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', _htmlentities($user_search)), "\n";
echo "  ", form_input_hidden('hide_empty', _htmlentities($hide_empty)), "\n";
echo "  ", form_input_hidden('hide_guests', _htmlentities($hide_guests)), "\n";
echo "  ", form_input_hidden('profile_selection', _htmlentities($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" valign=\"top\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$lang['member']}</a></td>\n";
}elseif ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" valign=\"top\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$lang['member']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$lang['member']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$lang['member']}</a></td>\n";
}

foreach ($profile_items_selected_array as $key => $profile_item_selected) {

    if ($sort_by == $key && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" valign=\"top\" width=\"20%\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a></td>\n";
    }elseif ($sort_by == $key && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" valign=\"top\" width=\"20%\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\" width=\"20%\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" valign=\"top\" width=\"20%\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;user_search=", _htmlentities($user_search), "&amp;hide_empty=$hide_empty&amp;hide_guests=$hide_guests\">{$profile_item_selected}</a></td>\n";
    }
}

echo "                 </tr>\n";

if (sizeof($user_profile_array['user_array']) > 0) {

    foreach ($user_profile_array['user_array'] as $user_array) {

        echo "                 <tr>\n";

        if (isset($user_array['AVATAR_URL']) && strlen($user_array['AVATAR_URL']) > 0) {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><img src=\"{$user_array['AVATAR_URL']}\" alt=\"", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "\" title=\"", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "\" border=\"0\" height=\"15\" width=\"15\" /></td>\n";

        }elseif (isset($user_array['AVATAR_AID']) && is_md5($user_array['AVATAR_AID'])) {

            $attachment = get_attachment_by_hash($user_array['AVATAR_AID']);

            if (($profile_picture_href = attachment_make_link($attachment, false, false, false, false))) {

                echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><img src=\"$profile_picture_href\" alt=\"", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "\" title=\"", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "\" border=\"0\" width=\"15\" height=\"15\" /></td>\n";

            }else {

                echo "                   <td align=\"left\" valign=\"top\" class=\"postbody\"><img src=\"", style_image('bullet.png'), "\" alt=\"{$lang['user']}\" title=\"{$lang['user']}\" /></td>\n";
            }

        }else {

            echo "                   <td align=\"left\" valign=\"top\" class=\"postbody\"><img src=\"", style_image('bullet.png'), "\" alt=\"{$lang['user']}\" title=\"{$lang['user']}\" /></td>\n";
        }

        if (isset($user_array['SID']) && !is_null($user_array['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><a href=\"{$user_array['URL']}\" target=\"_blank\">", word_filter_add_ob_tags(_htmlentities($user_array['NAME'])), "</a></td>\n";

        }elseif ($user_array['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_array['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user_array['UID']}, '$webtag')\">", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "</a></td>\n";

        }else {

            echo "                   <td class=\"postbody\" align=\"left\" valign=\"top\">", word_filter_add_ob_tags(_htmlentities(format_user_name($user_array['LOGON'], $user_array['NICKNAME']))), "</td>\n";
        }

        foreach ($profile_items_selected_array as $key => $profile_item_selected) {

            if (is_numeric($key) && isset($user_array["ENTRY_$key"])) {

                if (($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_RADIO) || ($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_DROPDOWN)) {

                    $profile_item_options_array = explode("\n", $user_array["PROFILE_ITEM_OPTIONS_$key"]);

                    if (isset($profile_item_options_array[$user_array["PROFILE_ITEM_OPTIONS_$key"]])) {

                        echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", _htmlentities($profile_item_options_array[$user_array["ENTRY_$key"]]), "\">", word_filter_add_ob_tags(_htmlentities($profile_item_options_array[$user_array["ENTRY_$key"]])), "&nbsp;</div></td>\n";

                    }else {

                        echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"\">&nbsp;</div></td>\n";
                    }

                }else if ($user_array["PROFILE_ITEM_TYPE_$key"] == PROFILE_ITEM_HYPERLINK) {

                    $profile_item_hyper_link = str_replace("[ProfileEntry]", word_filter_add_ob_tags(urlencode($user_array["ENTRY_$key"])), $user_array["PROFILE_ITEM_OPTIONS_$key"]);
                    $profile_item_hyper_link = sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $profile_item_hyper_link, word_filter_add_ob_tags(_htmlentities($user_array["ENTRY_$key"])));

                    echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", word_filter_add_ob_tags(_htmlentities($user_array["ENTRY_$key"])), "\">$profile_item_hyper_link&nbsp;</div></td>\n";

                }else {

                    echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", _htmlentities($user_array["ENTRY_$key"]), "\">", word_filter_add_ob_tags(_htmlentities($user_array["ENTRY_$key"])), "&nbsp;</div></td>\n";
                }

            }elseif (isset($profile_header_array[$key]) && isset($user_array[$key])) {

                echo "                   <td class=\"postbody\" align=\"right\" valign=\"top\" width=\"20%\"><div class=\"profile_item_overflow\" title=\"", _htmlentities($user_array[$key]), "\">", word_filter_add_ob_tags(_htmlentities($user_array[$key])), "&nbsp;</div></td>\n";

            }else {

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
echo "            <td align=\"center\" nowrap=\"nowrap\" width=\"20%\">", page_links("visitor_log.php?webtag=$webtag&page=$page&profile_selection=$profile_items_selected_encoded_string&user_search=$user_search&sort_by=$sort_by&sort_dir=$sort_dir&hide_empty=$hide_empty&hide_guests=$hide_guests", $start, $user_profile_array['user_count'], 10), "</td>\n";
echo "            <td align=\"right\" nowrap=\"nowrap\" width=\"40%\">", form_dropdown_array('add_column', $profile_dropdown_array), "&nbsp;", form_submit('add', $lang['add']), "</td>\n";
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
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
echo "  ", form_input_hidden('sort_by', _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', _htmlentities($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', _htmlentities($user_search)), "\n";
echo "  ", form_input_hidden('profile_selection', _htmlentities($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("hide_empty", "Y", $lang['hiderowswithemptyornullvalues'], $hide_empty == 'Y'), "</td>\n";
echo "                      </tr>\n";

if (forum_get_setting('guest_show_recent', 'Y')) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("hide_guests", "Y", $lang['showregisteredusersonly'], $hide_guests == 'Y'), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<form accept-charset=\"utf-8\" name=\"f_user_search\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
echo "  ", form_input_hidden('sort_by', _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', _htmlentities($sort_dir)), "\n";
echo "  ", form_input_hidden('user_search', _htmlentities($user_search)), "\n";
echo "  ", form_input_hidden('hide_empty', _htmlentities($hide_empty)), "\n";
echo "  ", form_input_hidden('hide_guests', _htmlentities($hide_guests)), "\n";
echo "  ", form_input_hidden('profile_selection', _htmlentities($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">{$lang['username']}: ", form_input_text('user_search', _htmlentities($user_search), 30, 64), " ", form_submit('search', $lang['search']), " ", form_submit('clear_search', $lang['clear']), "</td>\n";
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

?>