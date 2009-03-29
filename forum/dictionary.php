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

/* $Id: dictionary.php,v 1.60 2009-03-29 12:11:48 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('UTC');

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

$lang = lang::get_instance()->load(__FILE__);

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

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['noformobj']);
    html_draw_bottom();
    exit;
}

// Form content

if (isset($_POST['content']) && strlen(trim(stripslashes_array($_POST['content']))) > 0) {

    $t_content = trim(stripslashes_array($_POST['content']));

}else {

    // Apache has a limit on the length an URL query, so we need to
    // send the content to be checked via POST or Javascript.

    html_draw_top('dictionary.js', "onload=initialiseDictionary('$obj_id')", 'pm_popup_disabled');

    echo "<h1>{$lang['dictionary']}</h1>\n";
    echo "<h2>{$lang['initialisingdotdotdot']}</h2>\n";

    echo "<form accept-charset=\"utf-8\" name=\"dictionary\" action=\"dictionary.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('obj_id', htmlentities_array($obj_id)), "\n";
    echo "  ", form_input_hidden('content', ""), "\n";
    echo "</form>\n";

    html_draw_bottom();
    exit;
}

// Ignored words

if (isset($_POST['ignored_words']) && strlen(trim(stripslashes_array($_POST['ignored_words']))) > 0) {
    $t_ignored_words = trim(stripslashes_array($_POST['ignored_words']));
}else {
    $t_ignored_words = "";
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
    $t_ignored_words = "";
}

// Intialise the dictionary

$dictionary = new dictionary($t_content, $t_ignored_words, $current_word, $obj_id, $offset_match);

if (!$dictionary->is_installed()) {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['dictionarynotinstalled']);
    html_draw_bottom();
    exit;
}

// Close the window

if (isset($_POST['cancel'])) {

    html_draw_top('pm_popup_disabled');

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  if (window.opener.auto_check_spell_started) {\n";
    echo "    window.opener.auto_check_spell_started = false;";
    echo "  }\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

// Send the results back to the form

if (isset($_POST['close'])) {

    html_draw_top('pm_popup_disabled');

    $content = $dictionary->get_js_safe_content();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  if (window.opener.updateContent) {\n";
    echo "    window.opener.updateContent('$obj_id', '", $dictionary->get_js_safe_content(), "');\n";
    echo "  }\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($_POST['ignoreall'])) {

    // User wants to ignore all references of the current word

    if (isset($_POST['word']) && strlen(trim(stripslashes_array($_POST['word']))) > 0) {

        $t_ignored_word = trim(stripslashes_array($_POST['word']));
        $dictionary->add_ignored_word($t_ignored_word);
    }

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

html_draw_top('dictionary.js', 'onload=showCurrentWord()', 'pm_popup_disabled');

echo "<h1>{$lang['dictionary']}</h1>\n";

if (($dictionary->is_check_complete())) {
    html_display_success_msg($lang['spellcheckcomplete'], '400', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"dictionary\" action=\"dictionary.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('obj_id', htmlentities_array($dictionary->get_obj_id())), "\n";
echo "  ", form_input_hidden('ignored_words', htmlentities_array($dictionary->get_ignored_words())), "\n";
echo "  ", form_input_hidden('content', htmlentities_array($dictionary->get_content())), "\n";
echo "  ", form_input_hidden('current_word', htmlentities_array($dictionary->get_current_word_index())), "\n";
echo "  ", form_input_hidden('offset_match', htmlentities_array($dictionary->get_offset_match())), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['bodytext']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table border=\"0\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"spellcheckbodytext\" valign=\"top\"><div id=\"pretty_content\" class=\"dictionary_pretty_content\">", $dictionary->pretty_print_content(), "</div></td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['spellcheck']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">{$lang['notindictionary']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">", form_input_text("word_display", htmlentities_array($dictionary->get_current_word()), 32, false, "disabled=\"disabled\"", "dictionary_word_display"), form_input_hidden("word", htmlentities_array($dictionary->get_current_word())), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['changeto']}:</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"270\">", form_input_text("change_to", htmlentities_array($dictionary->get_best_suggestion()), 32, false, false, "dictionary_change_to"), "</td>\n";
echo "                  <td align=\"left\" rowspan=\"2\" width=\"130\" valign=\"top\">\n";
echo "                    <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"120\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", form_submit("ignore", $lang['ignore'], false, "dictionary_button"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", form_submit("ignoreall", $lang['ignoreall'], false, "dictionary_button"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", form_submit("change", $lang['change'], false, "dictionary_button"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", form_submit("changeall", $lang['changeall'], false, "dictionary_button"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", form_submit("add", $lang['add'], false, "dictionary_button"), "</td>\n";
echo "                      </tr>\n";

if ($dictionary->get_word_suggestion_count() > 9) {

    echo "                      <tr>\n";
    echo "                        <td align=\"right\">", form_submit("suggest", $lang['suggest'],  false, "dictionary_button"), "</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"right\">&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"270\">\n";

if (($suggestions_array = $dictionary->get_suggestions_array())) {

    echo "                    ", form_dropdown_array("suggestion", $suggestions_array, $dictionary->get_best_suggestion(), "size=\"10\" onchange=\"changeWord(this)\"", "dictionary_best_selection"), "\n";

}elseif (($dictionary->is_check_complete())) {

    echo "                    ", form_input_text("change_to", htmlentities_array($dictionary->get_best_suggestion()), 32, false, "disabled=\"disabled\"", "dictionary_best_selection"), "\n";

}else {

    echo "                    ", form_dropdown_array("suggestion", array($lang['nosuggestions']), $dictionary->get_best_suggestion(), "size=\"10\"", "dictionary_best_selection"), "\n";
}

echo "                  </td>\n";
echo "                </tr>\n";
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

if (($dictionary->is_check_complete())) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('restart', $lang['restartspellcheck']), "&nbsp;", form_submit("close", $lang['close']), "&nbsp;", form_submit("cancel", $lang['cancelchanges']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("close", $lang['close']), "&nbsp;", form_submit("cancel", $lang['cancelchanges']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>