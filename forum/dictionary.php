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
include_once(BH_INCLUDE_PATH. "dictionary.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

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

// Form Object ID
if (isset($_POST['obj_id']) && strlen(trim(stripslashes_array($_POST['obj_id']))) > 0) {

    $obj_id = trim(stripslashes_array($_POST['obj_id']));

}elseif (isset($_GET['obj_id']) && strlen(trim(stripslashes_array($_GET['obj_id']))) > 0) {

    $obj_id = trim(stripslashes_array($_GET['obj_id']));

}else {

    html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
    html_error_msg(gettext("No form object specified for return text"));
    html_draw_bottom();
    exit;
}

// Form content
if (isset($_POST['content']) && strlen(trim(stripslashes_array($_POST['content']))) > 0) {

    $t_content = trim(stripslashes_array($_POST['content']));

}else {

    // Apache has a limit on the length an URL query, so we need to
    // send the content to be checked via POST or Javascript.
    html_draw_top("title=", gettext("Dictionary"), "", 'dictionary.js', 'pm_popup_disabled', 'class=window_title');

    echo "<form accept-charset=\"utf-8\" id=\"dictionary_init\" action=\"dictionary.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('obj_id', htmlentities_array($obj_id)), "\n";
    echo "  ", form_input_hidden('content', ""), "\n";
    echo "</form>\n";

    html_draw_bottom();
    exit;
}

// Ignored words
if (isset($_POST['ignored_words']) && is_array($_POST['ignored_words'])) {
    $t_ignored_words = stripslashes_array($_POST['ignored_words']);
}else {
    $t_ignored_words = array();
}

// Fetch the current word
if (isset($_POST['current_word']) && is_numeric($_POST['current_word'])) {
    $current_word = $_POST['current_word'];
}else {
    $current_word = -1;
}

if (isset($_POST['offset_match']) && is_numeric($_POST['offset_match'])) {
    $offset_match = $_POST['offset_match'];
}else {
    $offset_match = 0;
}

// Restart the spell check
if (isset($_POST['restart'])) {

    $current_word = -1;
    $offset_match = 0;
    $t_ignored_words = array();
}

// New instance of the dictionary
$dictionary = new dictionary();

// Check it's installed
if (!$dictionary->is_installed()) {

    html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
    html_error_msg(gettext("No dictionary has been installed. Please contact the forum owner to remedy this."));
    html_draw_bottom();
    exit;
}

// Initialise it
$dictionary->initialise($t_content, $t_ignored_words, $current_word, $obj_id, $offset_match);

// Check for submit
if (isset($_POST['ignoreall'])) {

    // User wants to ignore all references to the current word
    $dictionary->add_ignored_word($dictionary->get_current_word());
    $dictionary->find_next_word();

}else if (isset($_POST['add'])) {

    // User wants to add the current word to his dictionary
    if (isset($_POST['word']) && strlen(trim(stripslashes_array($_POST['word']))) > 0) {

        $t_custom_word = trim(stripslashes_array($_POST['word']));
        $dictionary->add_custom_word($t_custom_word);
    }

    $dictionary->find_next_word();

}else if (isset($_POST['change'])) {

    // User has selected to change the current word
    if (isset($_POST['change_to']) && strlen(trim(stripslashes_array($_POST['change_to']))) > 0) {

         $t_change_to = trim(stripslashes_array($_POST['change_to']));
         $dictionary->correct_current_word($t_change_to);
    }

    $dictionary->find_next_word();

}else if (isset($_POST['changeall'])) {

    // User has selected to change the current word
    if (isset($_POST['change_to']) && strlen(trim(stripslashes_array($_POST['change_to']))) > 0) {

         $t_change_to = trim(stripslashes_array($_POST['change_to']));
         $dictionary->correct_all_word_matches($t_change_to);
    }

    $dictionary->find_next_word();

}elseif (isset($_POST['suggest'])) {

    // Get more suggestions for the current word
    $dictionary->get_more_suggestions();

}else {

    // We're moving to the next word;
    $dictionary->find_next_word();
}

html_draw_top("title=", gettext("Dictionary"), "", 'dictionary.js', 'onload=showCurrentWord()', 'pm_popup_disabled', 'class=window_title');

echo "<h1>", gettext("Dictionary"), "</h1>\n";

if (($dictionary->is_check_complete())) {
    html_display_success_msg(gettext("Spell check is complete. To restart spell check click restart button below."), '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"dictionary\" action=\"dictionary.php\" method=\"post\" target=\"_self\">\n";
echo "    ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "    ", form_input_hidden('obj_id', htmlentities_array($dictionary->get_obj_id())), "\n";

if (($ignored_words_array = $dictionary->get_ignored_words())) {

    foreach ($ignored_words_array as $ignored_word) {
        echo "    ", form_input_hidden('ignored_words[]', htmlentities_array($ignored_word)), "\n";
    }
}

echo "    ", form_input_hidden('content', htmlentities_array($dictionary->get_content())), "\n";
echo "    ", form_input_hidden('current_word', htmlentities_array($dictionary->get_current_word_index())), "\n";
echo "    ", form_input_hidden('offset_match', htmlentities_array($dictionary->get_offset_match())), "\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td align=\"left\">\n";
echo "          <table class=\"box\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"left\" class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" align=\"left\">", gettext("Spell check"), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"center\">\n";
echo "                      <table width=\"95%\" class=\"posthead\">\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\" colspan=\"2\">", gettext("Not in dictionary"), ":</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\" valign=\"top\" width=\"334\">\n";
echo "                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"left\" class=\"spellcheckbodytext\" valign=\"top\" width=\"330\">\n";
echo "                                  <div id=\"pretty_content\" class=\"dictionary_pretty_content\">", $dictionary->pretty_print_content(), "</div>\n";
echo "                                </td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </td>\n";
echo "                          <td align=\"right\" valign=\"top\">\n";
echo "                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("ignore", gettext("Ignore"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("ignoreall", gettext("Ignore All"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("add", gettext("Add"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                      <table width=\"95%\" class=\"posthead\">\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\" colspan=\"2\">", gettext("Change to"), ":</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\" valign=\"top\" width=\"330\">\n";
echo "                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"left\" valign=\"top\" width=\"330\">", form_input_text("change_to", htmlentities_array($dictionary->get_best_suggestion()), 32, false, false, "dictionary_change_to"), "</td>\n";
echo "                                </td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </td>\n";
echo "                          <td align=\"right\" valign=\"top\" rowspan=\"2\">\n";
echo "                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("change", gettext("Change"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("changeall", gettext("Change All"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td align=\"right\">", form_submit("suggest", gettext("Suggest"), false, "dictionary_button"), "</td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\" valign=\"top\" width=\"330\">\n";
echo "                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"left\" valign=\"top\" width=\"330\">\n";

if (($suggestions_array = $dictionary->get_suggestions_array())) {

    echo "                                  ", form_dropdown_array("suggestions", $suggestions_array, $dictionary->get_best_suggestion(), "size=\"5\"", "dictionary_best_selection"), "\n";

}else {

    echo "                                  ", form_dropdown_array("no_suggestions", array(gettext("(no suggestions)")), $dictionary->get_best_suggestion(), "size=\"5\"", "dictionary_best_selection"), "\n";
}

echo "                                </td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"left\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"left\">&nbsp;</td>\n";
echo "      </tr>\n";

if (($dictionary->is_check_complete())) {

    echo "      <tr>\n";
    echo "        <td align=\"center\">", form_submit('restart', gettext("Restart")), "&nbsp;", form_button("close", gettext("Close")), "&nbsp;", form_button("cancel", gettext("Cancel Changes")), "</td>\n";
    echo "      </tr>\n";

}else {

    echo "      <tr>\n";
    echo "        <td align=\"center\">", form_button("close", gettext("Close")), "&nbsp;", form_button("cancel", gettext("Cancel Changes")), "</td>\n";
    echo "      </tr>\n";
}

echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>