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

/* $Id: edit_wordfilter.php,v 1.41 2004-08-12 23:54:24 tribalonline Exp $ */

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

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

$uid = bh_session_get_value('UID');

if (isset($_POST['submit'])) {

	// the /../e preg modifier allows PHP code to be used in the replacement - bad!
	function filter_limit_preg ($matches) {
		return preg_replace("/e/i", "", $matches[0]);
	}

    user_clear_word_filter();

    $filter_count = 0;

    if (isset($_POST['match']) && is_array($_POST['match'])) {
        foreach ($_POST['match'] as $key => $value) {
            if ($filter_count < 20) {
                $filter_option = (isset($_POST['filter_option'][$key])) ? $_POST['filter_option'][$key] : 0;
				if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $_POST['match'][$key])) {
					$_POST['match'][$key] = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $_POST['match'][$key]);
				}
                if (isset($_POST['replace'][$key]) && trim(strlen($_POST['replace'][$key])) > 0) {
                    user_add_word_filter($_POST['match'][$key], $_POST['replace'][$key], $filter_option);
                }else {
                    user_add_word_filter($_POST['match'][$key], "", $filter_option);
                }
            }
            $filter_count++;
        }
    }

    if (isset($_POST['new_match']) && strlen(trim($_POST['new_match'])) > 0 && $filter_count < 20) {
        $filter_option = (isset($_POST['new_filter_option'])) ? $_POST['new_filter_option'] : 0;
		if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $_POST['new_match'])) {
			$_POST['new_match'] = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $_POST['new_match']);
		}
        if (isset($_POST['new_replace']) && strlen(trim($_POST['new_replace'])) > 0) {
            user_add_word_filter($_POST['new_match'], $_POST['new_replace'], $filter_option);
        }else {
            user_add_word_filter($_POST['new_match'], "", $filter_option);
        }
    }

    if (isset($_POST['use_admin_filter']) && $_POST['use_admin_filter'] == "Y") {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
    }

    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
    }

    user_update_prefs($uid, $user_prefs);
    if (!isset($status_text)) $status_text = "<p><b>{$lang['wordfilterupdated']}</b></p>";

}elseif (isset($_POST['delete'])) {

    list($id) = array_keys($_POST['delete']);
    user_delete_word_filter($id);
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

if (!isset($user_prefs['USE_ADMIN_FILTER'])) $user_prefs['USE_ADMIN_FILTER'] = 'N';

// Get Word Filter

$word_filter_array = user_get_word_filter();

echo "<h1>{$lang['editwordfilter']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['wordfilterexp_3']}</p>\n";
echo "<p>{$lang['wordfilterexp_2']}</p>\n";

echo "<form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['matchedtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['replacementtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['all']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['wholeword']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['preg']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" width=\"75\">&nbsp;</td>\n";
echo "                </tr>\n";

foreach ($word_filter_array as $key => $word_filter) {

    echo "                <tr>\n";

    if ($word_filter['UID'] == 0) {

        if (!forum_get_setting('admin_force_word_filter', 'Y', false)) {

            echo "                  <td align=\"center\"><sup>[A]</sup></td>\n";
            echo "                  <td>", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), "</td>\n";
            echo "                  <td>", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), "</td>\n";
            echo "                  <td>&nbsp;</td>\n";
        }

    }else {

        echo "                  <td>&nbsp;</td>\n";
        echo "                  <td>", form_input_text("match[$key]", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), 30), "</td>\n";
        echo "                  <td>", form_input_text("replace[$key]", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), 30), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "0", "", $word_filter['FILTER_OPTION'] == 0), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "1", "", $word_filter['FILTER_OPTION'] == 1), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "2", "", $word_filter['FILTER_OPTION'] == 2), "</td>\n";
        echo "                  <td align=\"center\">", form_submit("delete[$key]", $lang['delete']), "</td>\n";
    }

    echo "                </tr>\n";
}

if (sizeof($word_filter_array) < 20) {

    echo "                <tr>\n";
    echo "                  <td>{$lang['newcaps']}</td>\n";
    echo "                  <td>", form_input_text("new_match", "", 30), "</td>\n";
    echo "                  <td>", form_input_text("new_replace", "", 30), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "0", "", true), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "1", "", false), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "2", "", false), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td valign=\"top\">&nbsp;</td>\n";
    echo "                  <td colspan=\"6\">{$lang['wordfilterisfull']}</td>\n";
    echo "                </tr>\n";
}

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
echo "                  <td>", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "</td>\n";
echo "                </tr>\n";

if (!forum_get_setting('admin_force_word_filter', 'Y', false)) {

    echo "                <tr>\n";
    echo "                  <td>", form_checkbox("use_admin_filter", "Y", $lang['includeadminfilter'], (isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y')), "</td>\n";
    echo "                </tr>\n";
}

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