<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: dictionary.php,v 1.2 2004-11-18 00:14:21 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/dictionary.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Ignored words array

$t_ignored_words_array = array();

// Close the dialog?

if (isset($_POST['body_text']) && strlen(trim(_stripslashes($_POST['body_text']))) > 0) {

    $t_body_text = trim(_stripslashes($_POST['body_text']));
    preg_match_all("/([abcdefghijklmnopqrstuvwxyz']+)|(.)/i", $t_body_text, $t_body_text_array);
    $t_body_text_array = $t_body_text_array[0];

}else if (isset($_GET['body_text']) && strlen(trim(_stripslashes($_GET['body_text']))) > 0) {

    $t_body_text = trim(_stripslashes($_GET['body_text']));
    preg_match_all("/([abcdefghijklmnopqrstuvwxyz']+)|(.)/i", $t_body_text, $t_body_text_array);
    $t_body_text_array = $t_body_text_array[0];

}else {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>No body text specified to spell check</h2>\n";

    html_draw_bottom();
    exit;
}

// Close the window

if (isset($_POST['cancel'])) {

    html_draw_top();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

// Boolean to check if the last word has been checked.

$check_complete = false;

// Fetch the current word

if (isset($_POST['current_word']) && is_numeric($_POST['current_word'])) {
    $current_word = $_POST['current_word'];
}else {
    $current_word = -1;
}

if (isset($_POST['ignoreall'])) {

    // User wants to ignore all references of the current word

    if (isset($_POST['ignored_words']) && strlen(trim(_stripslashes($_POST['ignored_words']))) > 0) {
        $t_ignored_words = trim(_stripslashes($_POST['ignored_words']));
    }else {
        $t_ignored_words = "";
    }

    if (isset($_POST['word']) && strlen(trim(_stripslashes($_POST['word']))) > 0) {

        $t_ignore_word = trim(_stripslashes($_POST['word']));
        $t_ignored_words_array = explode(" ", $t_ignored_words);
        $t_ignored_words_array[] = $t_ignored_word;
    }

}else if (isset($_POST['add'])) {

    // User wants to add the current word to his dictionary

    if (isset($_POST['word']) && strlen(trim(_stripslashes($_POST['word']))) > 0) {

        $t_custom_word = trim(_stripslashes($_POST['word']));
        dictionary_add_custom_word($t_custom_word);

        $t_suggestions_array = dictionary_get_suggestions($t_custom_word);
    }

}else if (isset($_POST['submit'])) {

    // User wants more / different suggestions

    if (isset($_POST['word']) && strlen(trim(_stripslashes($_POST['word']))) > 0) {

        $t_suggest_word = trim(_stripslashes($_POST['word']));
        $t_suggestions_array = dictionary_get_suggestions($t_suggest_word);
    }

}else if (isset($_POST['change'])) {

    // User has selected to change the current word

    if (isset($_POST['changeto']) && strlen(trim(_stripslashes($_POST['changeto']))) > 0) {

         $changeto = trim(_stripslashes($_POST['changeto']));
         $t_body_text_array[$current_word] = $changeto;
    }

    $current_word++;

    if ($current_word < sizeof($t_body_text_array)) {

        $t_suggestions_array = dictionary_get_suggestions($t_body_text_array[$current_word]);

        while(!$t_suggestions_array && $current_word < sizeof($t_body_text_array)) {

            $current_word++;

            if ($current_word > (sizeof($t_body_text_array) - 1)) {
                $check_complete = true;
                break;
            }

            $t_suggestions_array = dictionary_get_suggestions($t_body_text_array[$current_word]);
        }
    }

}else {

    // Move to the next word

    $current_word++;

    if ($current_word < sizeof($t_body_text_array)) {

        $t_suggestions_array = dictionary_get_suggestions($t_body_text_array[$current_word]);

        while(!$t_suggestions_array && $current_word < sizeof($t_body_text_array)) {

            $current_word++;

            if ($current_word > (sizeof($t_body_text_array) - 1)) {
                $check_complete = true;
                break;
            }

            $t_suggestions_array = dictionary_get_suggestions($t_body_text_array[$current_word]);
        }
    }
}

if ($check_complete) {

    html_draw_top('dictionary.js', 'onload=check_complete()');

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function check_complete() {\n\n";
    echo "    if (window.confirm('Spell check is complete. Do you wish to start again from the beginning?')) {\n";
    echo "        document.dictionary.current_word.value = 0;\n";
    echo "        document.dictionary.submit();\n";
    echo "    }\n";
    echo "}\n\n";
    echo "//-->\n";
    echo "</script>\n";

}else {

    html_draw_top('dictionary.js');
}

echo "<form name=\"dictionary\" action=\"dictionary.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('ignored_words', implode(" ", $t_ignored_words_array)), "\n";
echo "  ", form_input_hidden('body_text', implode("", $t_body_text_array)), "\n";
echo "  ", form_input_hidden('current_word', $current_word), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"350\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"350\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">Body Text</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>\n";
echo "                    <table border=\"0\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"spellcheckbodytext\" valign=\"top\">";

foreach($t_body_text_array as $key => $word) {
    if ($key == $current_word) {
        echo "<span class=\"highlight\">$word</span>";
    }else {
        echo "$word";
    }
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"350\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"350\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">Spell Check</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">Not in dictionary</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_input_text("word", isset($t_body_text_array[$current_word]) ? $t_body_text_array[$current_word] : "", 32, false, "style=\"width: 95%\""), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>Change to:</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"175\">", form_input_text("changeto", isset($t_suggestions_array[0]) ? $t_suggestions_array[0] : "" , 32, false, "style=\"width: 95%\""), "</td>\n";
echo "                  <td rowspan=\"2\" width=\"175\" valign=\"top\">\n";
echo "                    <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_submit("ignore", "Ignore", "style=\"width: 80px\""), "</td>\n";
echo "                        <td>", form_submit("ignoreall", "Ignore All", "style=\"width: 80px\""), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_submit("change", "Change", "style=\"width: 80px\""), "</td>\n";
echo "                        <td>", form_submit("autocorrect", "Auto-correct", "style=\"width: 100px\""), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_submit("add", "Add", "style=\"width: 80px\""), "</td>\n";
echo "                        <td>", form_submit("suggest", "Suggest", "style=\"width: 80px\""), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>\n";
echo "                    ", form_dropdown_array("suggestion", isset($t_suggestions_array) && is_array($t_suggestions_array) ? $t_suggestions_array : array(), false, false, "size=\"10\" style=\"width: 100%; height: 90px\" onchange=\"changeword()\""), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("ok", "OK"), "&nbsp;", form_submit("cancel", "Cancel"), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>