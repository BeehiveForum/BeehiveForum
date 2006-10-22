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

/* $Id: admin_wordfilter.php,v 1.78 2006-10-22 16:24:32 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['submit'])) {

    $new_forum_settings = forum_get_settings();

    if (isset($_POST['match']) && is_array($_POST['match'])) {

        foreach ($_POST['match'] as $key => $match_text) {

            $match_text = trim(_stripslashes($match_text));

            $replace_text  = (isset($_POST['replace'][$key])) ? trim(_stripslashes($_POST['replace'][$key])) : "";
            $filter_option = (isset($_POST['filter_option'][$key])) ? $_POST['filter_option'][$key] : 0;

            if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $match_text)) {

                $match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $match_text);
            }

            admin_update_word_filter($key, $match_text, $replace_text, $filter_option);
        }
    }

    if (isset($_POST['new_match']) && strlen(trim(_stripslashes($_POST['new_match'])))) {

        $match_text = trim(_stripslashes($_POST['new_match']));

        $replace_text  = (isset($_POST['new_replace'])) ? _stripslashes($_POST['new_replace']) : "";
        $filter_option = (isset($_POST['new_filter_option'])) ? $_POST['new_filter_option'] : 0;

        if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $match_text)) {

            $match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $match_text);
        }

        admin_add_word_filter($match_text, $replace_text, $filter_option);
    }

    if (isset($_POST['admin_force_word_filter']) && $_POST['admin_force_word_filter'] == "Y") {
        $new_forum_settings['admin_force_word_filter'] = "Y";
    }else {
        $new_forum_settings['admin_force_word_filter'] = "N";
    }

    forum_save_settings($new_forum_settings);

    $uid = bh_session_get_value('UID');
    admin_add_log_entry(EDIT_WORD_FILTER);

    header_redirect("./admin_wordfilter.php?webtag=$webtag&updated=true", $lang['wordfilterupdated']);

}elseif (isset($_POST['delete'])) {

    list($id) = array_keys($_POST['delete']);
    admin_delete_word_filter($id);
}

$word_filter_array = admin_get_word_filter();

echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['editwordfilter']}</h1>\n";

if (isset($_GET['updated'])) {
    echo "<h2>{$lang['wordfilterupdated']}</h2>\n";
}

echo "<div align=\"center\">\n";
echo "<form name=\"startpage\" method=\"post\" action=\"admin_wordfilter.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <p>{$lang['wordfilterexp_1']}</p>\n";
echo "        <p>{$lang['wordfilterexp_2']}</p>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['matchedtext']}&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['replacementtext']}&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['all']}&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['wholeword']}&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['preg']}&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"75\">&nbsp;</td>\n";
echo "                </tr>\n";

foreach ($word_filter_array as $key => $word_filter) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("match[$key]", _htmlentities($word_filter['MATCH_TEXT']), 30), "</td>\n";
    echo "                  <td align=\"left\">", form_input_text("replace[$key]", _htmlentities($word_filter['REPLACE_TEXT']), 30), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "0", "", $word_filter['FILTER_OPTION'] == 0), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "1", "", $word_filter['FILTER_OPTION'] == 1), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "2", "", $word_filter['FILTER_OPTION'] == 2), "</td>\n";
    echo "                  <td align=\"center\">", form_submit("delete[$key]", $lang['delete']), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['newcaps']}</td>\n";
echo "                  <td align=\"left\">", form_input_text("new_match", "", 30), "</td>\n";
echo "                  <td align=\"left\">", form_input_text("new_replace", "", 30), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "0", "", true), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "1", "", false), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "2", "", false), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">", form_checkbox("admin_force_word_filter", "Y", $lang['forceadminwordfilter'], forum_get_setting("admin_force_word_filter", "Y")), "</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <p>{$lang['word_filter_help_1']}</p>\n";
echo "        <p>{$lang['word_filter_help_2']}</p>\n";
echo "        <p>{$lang['word_filter_help_3']}</p>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>