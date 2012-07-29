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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag
$webtag = get_webtag();

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

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

$word_filter_options = array(WORD_FILTER_TYPE_ALL => gettext("All"),
                             WORD_FILTER_TYPE_WHOLE_WORD => gettext("Whole Word"),
                             WORD_FILTER_TYPE_PREG => gettext("PREG"));

$word_filter_enabled = array(WORD_FILTER_DISABLED => gettext("No"),
                             WORD_FILTER_ENABLED => gettext("Yes"));

$valid = true;

// Array to hold error messages
$error_msg_array = array();

// User click cancel
if (isset($_POST['cancel']) || isset($_POST['delete'])) {

    unset($_POST['addfilter'], $_POST['filter_id'], $_GET['addfilter'], $_GET['filter_id']);
}

// Submit code (Delete, Save, Add, etc.)
if (isset($_POST['delete'])) {

    if (isset($_POST['delete_filters']) && is_array($_POST['delete_filters'])) {

        foreach ($_POST['delete_filters'] as $filter_id => $delete_filter) {

            if (($delete_filter == "Y")) {

                if (!user_delete_word_filter($filter_id)) {

                    $valid = false;
                    $error_msg_array[] = gettext("Failed to update word filter. Check that the filter still exists.");
                }
            }
        }

        if ($valid) {

            $redirect = "edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, gettext("Word Filter updated"));
            exit;
        }
    }

}elseif (isset($_POST['save'])) {

    if (isset($_POST['use_admin_filter']) && $_POST['use_admin_filter'] == "Y") {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }

    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    $uid = session_get_value('UID');

    if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        header_redirect("edit_wordfilter.php?webtag=$webtag&updated=true", gettext("Preferences were successfully updated."));
        exit;

    }else {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

}elseif (isset($_POST['addfilter_submit'])) {

    if (user_get_word_filter_count() > 19) {

        $valid = false;
        $error_msg_array[] = gettext("You cannot add any more word filters. Remove some unused ones or edit the existing ones first.");

    }else {

        if (isset($_POST['add_new_filter_name']) && strlen(trim(stripslashes_array($_POST['add_new_filter_name']))) > 0) {
           $add_new_filter_name = trim(stripslashes_array($_POST['add_new_filter_name']));
        }else {
           $valid = false;
           $error_msg_array[] = gettext("You must specify a filter name");
        }

        if (isset($_POST['add_new_match_text']) && strlen(trim(stripslashes_array($_POST['add_new_match_text']))) > 0) {
           $add_new_match_text = trim(stripslashes_array($_POST['add_new_match_text']));
        }else {
           $valid = false;
           $error_msg_array[] = gettext("You must specify matched text");
        }

        if (isset($_POST['add_new_filter_option']) && is_numeric($_POST['add_new_filter_option'])) {
           $add_new_filter_option = $_POST['add_new_filter_option'];
        }else {
           $valid = false;
           $error_msg_array[] = gettext("You must specify a filter option");
        }

        if (isset($_POST['add_new_filter_enabled']) && is_numeric($_POST['add_new_filter_enabled'])) {
            $add_new_filter_enabled = $_POST['add_new_filter_enabled'];
        }else {
            $add_new_filter_enabled = WORD_FILTER_DISABLED;
        }

        if (isset($_POST['add_new_replace_text']) && strlen(trim(stripslashes_array($_POST['add_new_replace_text']))) > 0) {
           $add_new_replace_text = trim(stripslashes_array($_POST['add_new_replace_text']));
        }else {
           $add_new_replace_text = "";
        }

        if ($valid) {

            if ($add_new_filter_option == WORD_FILTER_TYPE_PREG && preg_match('/e[^\/]*$/Diu', $add_new_match_text)) {
                $add_new_match_text = preg_replace_callback('/\/[^\/]*$/Diu', 'word_filter_apply_limit_preg', $add_new_match_text);
            }

            if (user_add_word_filter($add_new_filter_name, $add_new_match_text, $add_new_replace_text, $add_new_filter_option, $add_new_filter_enabled)) {

                $redirect = "edit_wordfilter.php?webtag=$webtag&updated=true";
                header_redirect($redirect, gettext("Word Filter updated"));
                exit;
            }
        }
    }

}elseif (isset($_POST['editfilter_submit'])) {

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {
        $filter_id = $_POST['filter_id'];
    }else {
        $valid = false;
        $error_msg_array[] = gettext("You must specify a filter ID");
    }

    if (isset($_POST['filter_name']) && strlen(trim(stripslashes_array($_POST['filter_name']))) > 0) {
        $filter_name = trim(stripslashes_array($_POST['filter_name']));
    }else {
        $valid = false;
        $error_msg_array[] = gettext("You must specify a filter name");
    }

    if (isset($_POST['match_text']) && strlen(trim(stripslashes_array($_POST['match_text']))) > 0) {
        $match_text = trim(stripslashes_array($_POST['match_text']));
    }else {
        $valid = false;
        $error_msg_array[] = gettext("You must specify matched text");
    }

    if (isset($_POST['filter_option']) && is_numeric($_POST['filter_option'])) {
        $filter_option = $_POST['filter_option'];
    }else {
        $valid = false;
        $error_msg_array[] = gettext("You must specify a filter option");
    }

    if (isset($_POST['filter_enabled']) && is_numeric($_POST['filter_enabled'])) {
        $filter_enabled = $_POST['filter_enabled'];
    }else {
        $filter_enabled = WORD_FILTER_DISABLED;
    }

    if (isset($_POST['replace_text']) && strlen(trim(stripslashes_array($_POST['replace_text']))) > 0) {
        $replace_text = trim(stripslashes_array($_POST['replace_text']));
    }else {
        $replace_text = "";
    }

    if ($valid) {

        if ($filter_option == WORD_FILTER_TYPE_PREG && preg_match('/e[^\/]*$/Diu', $match_text)) {
            $match_text = preg_replace_callback('/\/[^\/]*$/Diu', 'word_filter_apply_limit_preg', $match_text);
        }

        if (user_update_word_filter($filter_id, $filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)) {

            $redirect = "edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, gettext("Word Filter updated"));
            exit;

        }else {

            $error_msg_array[] = gettext("Failed to update word filter. Check that the filter still exists.");
        }
    }

}elseif (isset($_POST['addfilter'])) {

    $redirect = "edit_wordfilter.php?webtag=$webtag&addfilter=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfilter']) || isset($_POST['addfilter'])) {

    html_draw_top("title=", gettext("My Controls"), " - ", gettext("Edit Word Filter"), "", 'class=window_title');

    echo "<h1>", gettext("Edit Word Filter"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'left');

    }elseif (user_get_word_filter_count() > 19) {

        html_display_error_msg(gettext("You cannot add any more word filters. Remove some unused ones or edit the existing ones first."), '600', 'left');
    }

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addfilter', 'true'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Add New Word Filter"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Filter Name"), ":</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_filter_name", (isset($_POST['add_new_filter_name']) ? htmlentities_array(stripslashes_array($_POST['add_new_filter_name'])) : ""), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Matched Text"), ":</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_match_text", (isset($_POST['add_new_match_text']) ? htmlentities_array(stripslashes_array($_POST['add_new_match_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Replacement Text"), ":</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_replace_text", (isset($_POST['add_new_replace_text']) ? htmlentities_array(stripslashes_array($_POST['add_new_replace_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">", gettext("Filter Type"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("add_new_filter_option", array(gettext("All"), gettext("Whole Word"), gettext("PREG")), (isset($_POST['add_new_filter_option']) ? $_POST['add_new_filter_option'] : 0)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">", gettext("Filter Enabled"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("add_new_filter_enabled", array(WORD_FILTER_ENABLED => gettext("Yes"), WORD_FILTER_DISABLED => gettext("No")), (isset($_POST['add_new_filter_enabled']) ? $_POST['add_new_filter_enabled'] : 1)), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter_submit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(sprintf('%s<p>%s</p>%s', gettext("<b>All</b> matches against the whole text so filtering mom to mum will also change moment to mument."), gettext("<b>Whole Word</b> matches against whole words only so filtering mom to mum will NOT change moment to mument."), gettext("<b>PREG</b> allows you to use Perl Regular Expressions to match text.")), '600', 'left');

    echo "</form>\n";

    html_draw_bottom();

}elseif (isset($_POST['filter_id']) || isset($_GET['filter_id'])) {

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {

        $filter_id = $_POST['filter_id'];

    }elseif (isset($_GET['filter_id']) && is_numeric($_GET['filter_id'])) {

        $filter_id = $_GET['filter_id'];

    }else {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("You must specify a filter ID"), 'edit_wordfilter.php', 'get', array('back' => gettext("Back")));
        html_draw_bottom();
        exit;
    }

    if (!$word_filter_array = user_get_word_filter($filter_id)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("Invalid Filter ID"), 'edit_wordfilter.php', 'get', array('back' => gettext("Back")));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title=", gettext("My Controls"), " - ", gettext("Edit Word Filter"), "", 'class=window_title');

    echo "<h1>", gettext("Edit Word Filter"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '600', 'left');
    }

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('filter_id', htmlentities_array($filter_id)), "\n";
    echo "  ", form_input_hidden("delete_filters[$filter_id]", 'Y'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Edit Word Filter"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Filter Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("filter_name", htmlentities_array($word_filter_array['FILTER_NAME']), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Matched Text"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("match_text", htmlentities_array($word_filter_array['MATCH_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Replacement Text"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("replace_text", htmlentities_array($word_filter_array['REPLACE_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">", gettext("Filter Type"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("filter_option", array(gettext("All"), gettext("Whole Word"), gettext("PREG")), $word_filter_array['FILTER_TYPE']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">", gettext("Filter Enabled"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("filter_enabled", array(WORD_FILTER_ENABLED => gettext("Yes"), WORD_FILTER_DISABLED => gettext("No")), $word_filter_array['FILTER_ENABLED']), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("editfilter_submit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(sprintf('%s<p>%s</p>%s', gettext("<b>All</b> matches against the whole text so filtering mom to mum will also change moment to mument."), gettext("<b>Whole Word</b> matches against whole words only so filtering mom to mum will NOT change moment to mument."), gettext("<b>PREG</b> allows you to use Perl Regular Expressions to match text.")), '600', 'left');

    echo "</form>\n";

    html_draw_bottom();

}else {

    html_draw_top("title=", gettext("My Controls"), " - ", gettext("Edit Word Filter"), "", 'class=window_title');

    $word_filter_array = user_get_word_filter_list($start);

    echo "<h1>", gettext("Edit Word Filter"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'left');

    }elseif (isset($_GET['updated'])) {

        html_display_success_msg(gettext("Word Filter updated"), '600', 'left');

    }else if (sizeof($word_filter_array['word_filter_array']) < 1) {

        html_display_warning_msg(gettext("No existing word filter entries found. To add a filter click the 'Add New' button below."), '600', 'left');
    }

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"edit_wordfilter.php\">\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" style=\"white-space: nowrap\">", gettext("Filter Name"), "&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" style=\"white-space: nowrap\">", gettext("Filter Type"), "&nbsp;</td>\n";
    echo "                  <td align=\"center\" class=\"subhead\" style=\"white-space: nowrap\" width=\"100\">", gettext("Filter Enabled"), "&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($word_filter_array['word_filter_array']) > 0) {

        foreach ($word_filter_array['word_filter_array'] as $filter_id => $word_filter) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\">", form_checkbox("delete_filters[$filter_id]", "Y", false), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"edit_wordfilter.php?webtag=$webtag&amp;filter_id=$filter_id\">", htmlentities_array($word_filter['FILTER_NAME']), "</a></td>\n";
            echo "                  <td align=\"left\">{$word_filter_options[$word_filter['FILTER_TYPE']]}</td>\n";
            echo "                  <td align=\"center\">{$word_filter_enabled[$word_filter['FILTER_ENABLED']]}&nbsp;</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("edit_wordfilter.php?webtag=$webtag", $start, $word_filter_array['word_filter_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Options"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("use_word_filter", "Y", gettext("Enable word filter."), session_get_value('USE_WORD_FILTER') == 'Y'), "</td>\n";
    echo "                      </tr>\n";

    if (!forum_get_setting('force_word_filter', 'Y')) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("use_admin_filter", "Y", gettext("Include admin word filter in my list."), session_get_value('USE_ADMIN_FILTER') == 'Y'), "</td>\n";
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

    html_draw_bottom();
}

?>