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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

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

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check if we're allowed multiple-select.
if (isset($_POST['multi']) && $_POST['multi'] == 'Y') {
    $multi = 'Y';
}elseif (isset($_GET['multi']) && $_GET['multi'] == 'Y') {
    $multi = 'Y';
}else {
    $multi = 'N';
}

// Search type
if (isset($_GET['type']) && in_array($_GET['type'], array(SEARCH_LOGON, SEARCH_THREAD))) {

    $type = $_GET['type'];

}else if (isset($_POST['type']) && in_array($_POST['type'], array(SEARCH_LOGON, SEARCH_THREAD))) {

    $type = $_POST['type'];

}else {

    html_draw_top("title={$lang['error']}", 'pm_popup_disabled');
    html_error_msg($lang['mustspecifytypeofsearch'], 'search_popup.php', 'post', array('close_popup' => $lang['close']));
    html_draw_bottom();
    exit;
}

// Check the multi selection with the type
if ($type == SEARCH_THREAD) $multi = 'N';

// Form Object ID
if (isset($_POST['obj_id']) && strlen(trim(stripslashes_array($_POST['obj_id']))) > 0) {

    $obj_id = trim(stripslashes_array($_POST['obj_id']));

}elseif (isset($_GET['obj_id']) && strlen(trim(stripslashes_array($_GET['obj_id']))) > 0) {

    $obj_id = trim(stripslashes_array($_GET['obj_id']));

}else {

    html_draw_top("title={$lang['error']}", 'pm_popup_disabled');
    html_error_msg($lang['noformobj'], 'search_popup.php', 'post', array('close_popup' => $lang['close']));
    html_draw_bottom();
    exit;
}

// Current selection
if (isset($_POST['selected']) && is_array($_POST['selected'])) {
    $selected_array = array_unique($_POST['selected']);
}else if (isset($_GET['selected']) && strlen(trim(stripslashes_array($_GET['selected']))) > 0) {
    $selected_array = array_unique(preg_split("/[;|,]/u", trim(stripslashes_array($_GET['selected']))));
}else {
    $selected_array = array();
}

// Make sure the selected_array is not greater than maxmium
if (($type == SEARCH_LOGON) && $multi === 'Y') {
    $selected_array = array_splice($selected_array, 0, 10);
} else {
    $selected_array = array_splice($selected_array, 0, 1);
}

// Check for search query
if (isset($_GET['search_query']) && strlen(trim($_GET['search_query']))) {

    $search_query = trim(stripslashes_array($_GET['search_query']));

} else if (isset($_POST['search_query']) && strlen(trim($_POST['search_query']))) {

    $search_query = trim(stripslashes_array($_POST['search_query']));

} else if (($type == SEARCH_LOGON) && (sizeof($selected_array) > 0)) {

    $search_query = implode(';', $selected_array);

} else if (($type == SEARCH_THREAD) && (sizeof($selected_array) > 0)) {

    list($selected_tid) = $selected_array;

    if (($thread_data = thread_get($selected_tid))) {
        $search_query = $thread_data['TITLE'];
    }
}

// Array to hold any error messages
$error_msg_array = array();

// Selection for page links
if (is_array($selected_array) && sizeof($selected_array) > 0) {
    $selected = implode(';', $selected_array);
}else {
    $selected = "";
}

// Empty array for storing the results of our search
$search_results_array = array();

// If everything is OK we can perform the search.
if (isset($search_query) && strlen(trim($search_query)) > 0) {

    if ($type == SEARCH_LOGON) {

        $search_results_array = user_search($search_query, $selected_array);

    }else if ($type == SEARCH_THREAD) {

        $search_results_array = thread_search($search_query, $selected_array);
    }
}

html_draw_top("title={$lang['search']}", 'pm_popup_disabled', 'search_popup.js', 'class=window_title');

echo "<h1>{$lang['search']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '450', 'center');

}elseif (isset($search_results_array['results_array']) && sizeof($search_results_array['results_array']) < 1 && sizeof($selected_array) < 1) {

    html_display_warning_msg($lang['searchreturnednoresults'], '450', 'center');

}else {

    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" action=\"search_popup.php\" method=\"post\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("obj_id", htmlentities_array($obj_id)), "\n";
echo "  ", form_input_hidden("type", htmlentities_array($type)), "\n";
echo "  ", form_input_hidden("multi", htmlentities_array($multi)), "\n";

if (sizeof($selected_array) > 0 || (isset($search_results_array['results_array']) && sizeof($search_results_array['results_array']) > 0)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchresults']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <div class=\"search_popup_results\">\n";
    echo "                      <table width=\"95%\">\n";
}

if (sizeof($selected_array) > 0) {

    foreach($selected_array as $selected_option) {

        if (($type == SEARCH_LOGON) && ($user_data = user_get_by_logon($selected_option))) {

            if ($multi === 'Y') {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", form_checkbox("selected[]", htmlentities_array($user_data['LOGON']), '', true), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_data['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_data['LOGON'], $user_data['NICKNAME']))), "</a></td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", form_radio("selected", htmlentities_array($user_data['LOGON']), '', true), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_data['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_data['LOGON'], $user_data['NICKNAME']))), "</a></td>\n";
                echo "                      </tr>\n";
            }

        } else if (($thread_data = thread_get($selected_option))) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", form_radio("selected", $thread_data['TID'], '', true), "&nbsp;<a href=\"messages.php?webtag=$webtag&amp;msg={$thread_data['TID']}.1\" target=\"_blank\">", word_filter_add_ob_tags(htmlentities_array($thread_data['TITLE'])), "</a></td>\n";
            echo "                      </tr>\n";
        }
    }

    if (isset($search_results_array['results_array']) && sizeof($search_results_array['results_array']) > 0) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\"><hr /></td>\n";
        echo "                      </tr>\n";
    }
}

if (isset($search_results_array['results_array']) && sizeof($search_results_array['results_array']) > 0) {

    foreach ($search_results_array['results_array'] as $search_result) {

        if (($type == SEARCH_LOGON) && !in_array($search_result['LOGON'], $selected_array)) {

            if ($multi === 'Y') {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", form_checkbox("selected[]", htmlentities_array($search_result['LOGON']), '', false), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$search_result['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($search_result['LOGON'], $search_result['NICKNAME']))), "</a></td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", form_radio("selected", htmlentities_array($search_result['LOGON']), '', false), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$search_result['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($search_result['LOGON'], $search_result['NICKNAME']))), "</a></td>\n";
                echo "                      </tr>\n";
            }

        } else if (($type == SEARCH_THREAD) && !in_array($search_result['TID'], $selected_array)) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", form_radio("selected", $search_result['TID'], '', false), "&nbsp;<a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.1\" target=\"_blank\">", word_filter_add_ob_tags(htmlentities_array($search_result['TITLE'])), "</a></td>\n";
            echo "                      </tr>\n";
        }
    }
}

if (sizeof($selected_array) > 0 || (isset($search_results_array['results_array']) && sizeof($search_results_array['results_array']) > 0)) {

    echo "                        <tr>\n";
    echo "                          <td class=\"postbody\">&nbsp;</td>\n";
    echo "                        </tr>\n";
    echo "                      </table>\n";
    echo "                    </div>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($type == SEARCH_LOGON) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforuser']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\">{$lang['username']}:</td>\n";

}elseif ($type == SEARCH_THREAD) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforthread']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\">{$lang['threadtitle']}:</td>\n";
}

echo "                        <td class=\"posthead\" align=\"left\">", form_input_text('search_query', (isset($search_query) ? htmlentities_array($search_query) : ''), 40, 64), form_submit('search', $lang['search'], 'style="display: none"'), "</td>\n";
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
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_button('select', $lang['select']), "&nbsp;", form_submit('search', $lang['search']), "&nbsp;", form_submit('close_popup', $lang['close']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>
