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

/* $Id: edit_wordfilter.php,v 1.10 2004-03-13 00:00:21 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top();

$uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['submit'])) {

    user_clear_word_filter();
    
    if (isset($HTTP_POST_VARS['match']) && is_array($HTTP_POST_VARS['match'])) {
        for ($i = 0; $i < sizeof($HTTP_POST_VARS['match']); $i++) {
            if (isset($HTTP_POST_VARS['match'][$i]) && trim(strlen($HTTP_POST_VARS['match'][$i])) > 0) {
                $preg_expr = (isset($HTTP_POST_VARS['preg_expr'][$i]) && $HTTP_POST_VARS['preg_expr'][$i] == "Y") ? 1 : 0;
                if (isset($HTTP_POST_VARS['replace'][$i]) && trim(strlen($HTTP_POST_VARS['replace'][$i])) > 0) {
                    user_add_word_filter($HTTP_POST_VARS['match'][$i], $HTTP_POST_VARS['replace'][$i], $preg_expr);
                }else {
                    user_add_word_filter($HTTP_POST_VARS['match'][$i], "", $preg_expr);
                }
            }
        }
    }
    
    if (isset($HTTP_POST_VARS['new_match']) && strlen(trim($HTTP_POST_VARS['new_match'])) > 0) {
        $preg_expr = (isset($HTTP_POST_VARS['new_preg_expr']) && $HTTP_POST_VARS['new_preg_expr'] == "Y") ? 1 : 0;
        if (isset($HTTP_POST_VARS['new_replace']) && strlen(trim($HTTP_POST_VARS['new_replace'])) > 0) {
            user_add_word_filter($HTTP_POST_VARS['new_match'], $HTTP_POST_VARS['new_replace'], $preg_expr);
        }else {
            user_add_word_filter($HTTP_POST_VARS['new_match'], "", $preg_expr);
        }
    }
    
    if (isset($HTTP_POST_VARS['use_admin_filter'])) {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['use_word_filter'])) {
        $user_prefs['USE_WORD_FILTER'] = "Y";
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
    }    
    
    user_update_prefs($uid, $user_prefs);
    if (!isset($status_text)) $status_text = "<p><b>{$lang['wordfilterupdated']}</b></p>";
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

if (!isset($user_prefs['USE_ADMIN_FILTER'])) $user_prefs['USE_ADMIN_FILTER'] = 'N';

// Get Word Filter

$word_filter_array = user_get_word_filter(($user_prefs['USE_ADMIN_FILTER'] == 'Y'));

echo "<h1>{$lang['editwordfilter']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['wordfilterexp_3']}</p>\n";
echo "<p>{$lang['wordfilterexp_2']}</p>\n";


echo "<form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php?webtag=$webtag\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\">&nbsp;Matched Text</td>\n";
echo "                  <td class=\"subhead\">&nbsp;Replacement Text</td>\n";
echo "                  <td class=\"subhead\">&nbsp;PREG Expr.</td>\n";
echo "                </tr>\n";

foreach ($word_filter_array as $key => $word_filter) {

    echo "                <tr>\n";
    
    if ($word_filter['UID'] == 0) {
        echo "                  <td align=\"center\"><sup>[A]</sup></td>\n";    
        echo "                  <td>", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), "</td>\n";
        echo "                  <td>", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), "</td>\n";
        echo "                  <td>&nbsp;</td>\n";
    }else {
        echo "                  <td>&nbsp;</td>\n";    
        echo "                  <td>", form_input_text("match[$key]", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), 30), "</td>\n";
        echo "                  <td>", form_input_text("replace[$key]", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), 30), "</td>\n";
        echo "                  <td align=\"center\">", form_checkbox("preg_expr[$key]", "Y", "", $word_filter['PREG_EXPR']), "</td>\n";
    }
    
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td>{$lang['newcaps']}</td>\n";
echo "                  <td>", form_input_text("new_match", "", 30), "</td>\n";
echo "                  <td>", form_input_text("new_replace", "", 30), "</td>\n";
echo "                  <td align=\"center\">", form_checkbox("new_preg_expr", "Y", "", false), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "                <tr>\n";
echo "                  <td>", form_checkbox("use_admin_filter", "Y", $lang['includeadminfilter'], (isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y')), "</td>\n";
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
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>