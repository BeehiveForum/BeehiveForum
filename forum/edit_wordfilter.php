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

// Disable caching if on AOL

cache_disable_aol();

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

$word_filter_options = array(WORD_FILTER_TYPE_ALL => $lang['all'],
                             WORD_FILTER_TYPE_WHOLE_WORD => $lang['wholeword'],
                             WORD_FILTER_TYPE_PREG => $lang['preg']);

$word_filter_enabled = array(WORD_FILTER_DISABLED => $lang['no'],
                             WORD_FILTER_ENABLED => $lang['yes']);

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
                    $error_msg_array[] = $lang['failedtoupdatewordfilter'];
                }
            }
        }

        if ($valid) {

            $redirect = "edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, $lang['wordfilterupdated']);
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

    $uid = bh_session_get_value('UID');

    if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        header_redirect("edit_wordfilter.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }

}elseif (isset($_POST['addfilter_submit'])) {

    if (user_get_word_filter_count() > 19) {

        $valid = false;
        $error_msg_array[] = $lang['wordfilterisfull'];

    }else {

        if (isset($_POST['add_new_filter_name']) && strlen(trim(stripslashes_array($_POST['add_new_filter_name']))) > 0) {
           $add_new_filter_name = trim(stripslashes_array($_POST['add_new_filter_name']));
        }else {
           $valid = false;
           $error_msg_array[] = $lang['mustspecifyfiltername'];
        }

        if (isset($_POST['add_new_match_text']) && strlen(trim(stripslashes_array($_POST['add_new_match_text']))) > 0) {
           $add_new_match_text = trim(stripslashes_array($_POST['add_new_match_text']));
        }else {
           $valid = false;
           $error_msg_array[] = $lang['mustspecifymatchedtext'];
        }

        if (isset($_POST['add_new_filter_option']) && is_numeric($_POST['add_new_filter_option'])) {
           $add_new_filter_option = $_POST['add_new_filter_option'];
        }else {
           $valid = false;
           $error_msg_array[] = $lang['mustspecifyfilteroption'];
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
                header_redirect($redirect, $lang['wordfilterupdated']);
                exit;
            }
        }
    }

}elseif (isset($_POST['editfilter_submit'])) {

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {
        $filter_id = $_POST['filter_id'];
    }else {
        $valid = false;
        $error_msg_array[] = $lang['mustspecifyfilterid'];
    }

    if (isset($_POST['filter_name']) && strlen(trim(stripslashes_array($_POST['filter_name']))) > 0) {
        $filter_name = trim(stripslashes_array($_POST['filter_name']));
    }else {
        $valid = false;
        $error_msg_array[] = $lang['mustspecifyfiltername'];
    }

    if (isset($_POST['match_text']) && strlen(trim(stripslashes_array($_POST['match_text']))) > 0) {
        $match_text = trim(stripslashes_array($_POST['match_text']));
    }else {
        $valid = false;
        $error_msg_array[] = $lang['mustspecifymatchedtext'];
    }

    if (isset($_POST['filter_option']) && is_numeric($_POST['filter_option'])) {
        $filter_option = $_POST['filter_option'];
    }else {
        $valid = false;
        $error_msg_array[] = $lang['mustspecifyfilteroption'];
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
            header_redirect($redirect, $lang['wordfilterupdated']);
            exit;

        }else {

            $error_msg_array[] = $lang['failedtoupdatewordfilter'];
        }
    }

}elseif (isset($_POST['addfilter'])) {

    $redirect = "edit_wordfilter.php?webtag=$webtag&addfilter=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfilter']) || isset($_POST['addfilter'])) {

    html_draw_top("title={$lang['mycontrols']} » {$lang['editwordfilter']}", 'class=window_title');

    echo "<h1>{$lang['editwordfilter']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'left');

    }elseif (user_get_word_filter_count() > 19) {

        html_display_error_msg($lang['wordfilterisfull'], '600', 'left');
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
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addnewwordfilter']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['filtername']}:</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_filter_name", (isset($_POST['add_new_filter_name']) ? htmlentities_array(stripslashes_array($_POST['add_new_filter_name'])) : ""), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['matchedtext']}:</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_match_text", (isset($_POST['add_new_match_text']) ? htmlentities_array(stripslashes_array($_POST['add_new_match_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['replacementtext']}:</td>\n";
    echo "                        <td align=\"left\" colspan=\"3\">", form_input_text("add_new_replace_text", (isset($_POST['add_new_replace_text']) ? htmlentities_array(stripslashes_array($_POST['add_new_replace_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">{$lang['filtertype']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("add_new_filter_option", array($lang['all'], $lang['wholeword'], $lang['preg']), (isset($_POST['add_new_filter_option']) ? $_POST['add_new_filter_option'] : 0)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">{$lang['filterenabled']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("add_new_filter_enabled", array(WORD_FILTER_ENABLED => $lang['yes'], WORD_FILTER_DISABLED => $lang['no']), (isset($_POST['add_new_filter_enabled']) ? $_POST['add_new_filter_enabled'] : 1)), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter_submit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(sprintf('%s<p>%s</p>%s', $lang['word_filter_help_1'], $lang['word_filter_help_2'], $lang['word_filter_help_3']), '600', 'left');

    echo "</form>\n";

    html_draw_bottom();

}elseif (isset($_POST['filter_id']) || isset($_GET['filter_id'])) {

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {

        $filter_id = $_POST['filter_id'];

    }elseif (isset($_GET['filter_id']) && is_numeric($_GET['filter_id'])) {

        $filter_id = $_GET['filter_id'];

    }else {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['mustspecifyfilterid'], 'edit_wordfilter.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$word_filter_array = user_get_word_filter($filter_id)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidfilterid'], 'edit_wordfilter.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title={$lang['mycontrols']} » {$lang['editwordfilter']}", 'class=window_title');

    echo "<h1>{$lang['editwordfilter']}</h1>\n";

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
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['editwordfilter']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['filtername']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("filter_name", htmlentities_array($word_filter_array['FILTER_NAME']), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['matchedtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("match_text", htmlentities_array($word_filter_array['MATCH_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">{$lang['replacementtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("replace_text", htmlentities_array($word_filter_array['REPLACE_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">{$lang['filtertype']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("filter_option", array($lang['all'], $lang['wholeword'], $lang['preg']), $word_filter_array['FILTER_TYPE']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" width=\"200\">{$lang['filterenabled']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("filter_enabled", array(WORD_FILTER_ENABLED => $lang['yes'], WORD_FILTER_DISABLED => $lang['no']), $word_filter_array['FILTER_ENABLED']), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("editfilter_submit", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(sprintf('%s<p>%s</p>%s', $lang['word_filter_help_1'], $lang['word_filter_help_2'], $lang['word_filter_help_3']), '600', 'left');

    echo "</form>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['mycontrols']} » {$lang['editwordfilter']}", 'class=window_title');

    $word_filter_array = user_get_word_filter_list($start);

    echo "<h1>{$lang['editwordfilter']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'left');

    }elseif (isset($_GET['updated'])) {

        html_display_success_msg($lang['wordfilterupdated'], '600', 'left');

    }else if (sizeof($word_filter_array['word_filter_array']) < 1) {

        html_display_warning_msg($lang['nowordfilterentriesfound'], '600', 'left');
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
    echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['filtername']}&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['filtertype']}&nbsp;</td>\n";
    echo "                  <td align=\"center\" class=\"subhead\" nowrap=\"nowrap\" width=\"100\">{$lang['filterenabled']}&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($word_filter_array['word_filter_array']) > 0) {

        foreach ($word_filter_array['word_filter_array'] as $filter_id => $word_filter) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\">", form_checkbox("delete_filters[$filter_id]", "Y", false), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"edit_wordfilter.php?webtag=$webtag&amp;filter_id=$filter_id\">{$word_filter['FILTER_NAME']}</a></td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], bh_session_get_value('USE_WORD_FILTER') == 'Y'), "</td>\n";
    echo "                      </tr>\n";

    if (!forum_get_setting('force_word_filter', 'Y')) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("use_admin_filter", "Y", $lang['includeadminfilter'], bh_session_get_value('USE_ADMIN_FILTER') == 'Y'), "</td>\n";
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

    html_draw_bottom();
}

?>