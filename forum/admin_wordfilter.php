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

/* $Id: admin_wordfilter.php,v 1.49 2004-05-04 17:10:16 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

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

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

if (!(bh_session_get_value('STATUS')&USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['submit'])) {

    admin_clear_word_filter();

    if (isset($_POST['match']) && is_array($_POST['match'])) {
        foreach ($_POST['match'] as $key => $value) {
            $filter_option = (isset($_POST['filter_option'][$key])) ? $_POST['filter_option'][$key] : 0;
            if (isset($_POST['replace'][$key]) && trim(strlen($_POST['replace'][$key])) > 0) {
                admin_add_word_filter($_POST['match'][$key], $_POST['replace'][$key], $filter_option);
            }else {
                admin_add_word_filter($_POST['match'][$key], "", $filter_option);
            }
        }
    }

    if (isset($_POST['new_match']) && strlen(trim($_POST['new_match'])) > 0) {
        $new_filter_option = (isset($_POST['new_filter_option'][$key])) ? $_POST['new_filter_option'][$key] : 0;
        if (isset($_POST['new_replace']) && strlen(trim($_POST['new_replace'])) > 0) {
            admin_add_word_filter($_POST['new_match'], $_POST['new_replace'], $new_filter_option);
        }else {
            admin_add_word_filter($_POST['new_match'], "", $new_filter_option);
        }
    }

    if (isset($_POST['admin_force_word_filter']) && $_POST['admin_force_word_filter'] == "Y") {
        $new_forum_settings['admin_force_word_filter'] = "Y";
    }else {
        $new_forum_settings['admin_force_word_filter'] = "N";
    }

    save_forum_settings($new_forum_settings);

    $uid = bh_session_get_value('UID');
    admin_addlog($uid, 0, 0, 0, 0, 0, 28);

    if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        header_redirect("./admin_wordfilter.php?webtag=$webtag&updated=true");

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = './admin_wordfilter.php?webtag=$webtag&amp;updated=true';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['forumsettingsupdated']}</p>";

        form_quick_button("./admin_wordfilter.php", $lang['continue'], false, false, "_top");

        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['delete'])) {

    list($id) = array_keys($_POST['delete']);
    admin_delete_word_filter($id);
}

$word_filter_array = admin_get_word_filter();

echo "<h1>{$lang['admin']} : {$lang['editwordfilter']}</h1>\n";

if (isset($_GET['updated'])) {
    echo "<h2>{$lang['wordfilterupdated']}</h2>\n";
}

echo "<p>{$lang['wordfilterexp_1']}</p>\n";
echo "<p>{$lang['wordfilterexp_2']}</p>\n";
echo "<form name=\"startpage\" method=\"post\" action=\"admin_wordfilter.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['matchedtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['replacementtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['all']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['wholeword']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['preg']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" width=\"75\">&nbsp;</td>\n";
echo "                </tr>\n";

foreach ($word_filter_array as $key => $word_filter) {
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>", form_input_text("match[$key]", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), 30), "</td>\n";
    echo "                  <td>", form_input_text("replace[$key]", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), 30), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "0", "", $word_filter['FILTER_OPTION'] == 0), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "1", "", $word_filter['FILTER_OPTION'] == 1), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "2", "", $word_filter['FILTER_OPTION'] == 2), "</td>\n";
    echo "                  <td align=\"center\">", form_submit("delete[$key]", $lang['delete']), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td>{$lang['newcaps']}</td>\n";
echo "                  <td>", form_input_text("new_match", "", 30), "</td>\n";
echo "                  <td>", form_input_text("new_replace", "", 30), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "0", "", true), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "1", "", false), "</td>\n";
echo "                  <td align=\"center\">", form_radio("new_filter_option", "2", "", false), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("admin_force_word_filter", "Y", $lang['forceadminwordfilter'], forum_get_setting("admin_force_word_filter", "Y", false)), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <p>{$lang['word_filter_help_1']}</p>\n";
echo "  <p>{$lang['word_filter_help_2']}</p>\n";
echo "  <p>{$lang['word_filter_help_3']}</p>\n";
echo "</form>\n";

html_draw_bottom();

?>