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

/* $Id: edit_wordfilter.php,v 1.2 2004-03-02 23:25:25 decoyduck Exp $ */

// Frameset for thread list and messages

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/lang.inc.php");

html_draw_top();

$uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['save'])) {

    user_clear_word_filter();
    
    if (isset($HTTP_POST_VARS['match']) && is_array($HTTP_POST_VARS['match'])) {
        for ($i = 0; $i < sizeof($HTTP_POST_VARS['match']); $i++) {
            if (isset($HTTP_POST_VARS['match'][$i]) && trim(strlen($HTTP_POST_VARS['match'][$i])) > 0) {
                if (isset($HTTP_POST_VARS['replace'][$i]) && trim(strlen($HTTP_POST_VARS['replace'][$i])) > 0) {
                    user_add_word_filter($HTTP_POST_VARS['match'][$i], $HTTP_POST_VARS['replace'][$i]);
                }else {
                    user_add_word_filter($HTTP_POST_VARS['match'][$i], "");
                }
            }
        }
    }
    
    if (isset($HTTP_POST_VARS['new_match']) && strlen(trim($HTTP_POST_VARS['new_match'])) > 0) {
        if (isset($HTTP_POST_VARS['new_replace']) && strlen(trim($HTTP_POST_VARS['new_replace'])) > 0) {
            user_add_word_filter($HTTP_POST_VARS['new_match'], $HTTP_POST_VARS['new_replace']);
        }else {
            user_add_word_filter($HTTP_POST_VARS['new_match'], "");
        }
    }
    
    if (isset($HTTP_POST_VARS['useadminfilter'])) {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
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
echo "<div class=\"postbody\">\n";
echo "  <form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\">&nbsp;</td>\n";
echo "                    <td class=\"subhead\">&nbsp;Matched Text</td>\n";
echo "                    <td class=\"subhead\">&nbsp;Replacement Text</td>\n";
echo "                    <td class=\"subhead\">&nbsp;</td>\n";
echo "                  </tr>\n";

foreach ($word_filter_array as $word_filter) {

    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    
    if ($word_filter['UID'] == 0) {
        echo "                    <td>", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), "</td>\n";
        echo "                    <td>", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), "</td>\n";
        echo "                    <td><sup>[A]</sup></td>\n";
    }else {
        echo "                    <td>", form_input_text("match[]", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), 30), "</td>\n";
        echo "                    <td>", form_input_text("replace[]", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), 30), "</td>\n";
        echo "                    <td>&nbsp;</td>\n";
    }
    
    echo "                  </tr>\n";
}

echo "                  <tr>\n";
echo "                    <td>{$lang['newcaps']}</td>\n";
echo "                    <td>", form_input_text("new_match", "", 30), "</td>\n";
echo "                    <td>", form_input_text("new_replace", "", 30), "</td>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n"; 
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                    <td colspan=\"3\">", form_checkbox("useadminfilter", "Y", $lang['includeadminfilter'], ($user_prefs['USE_ADMIN_FILTER'] == 'Y')), "</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("save", $lang['save']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";

html_draw_bottom();

?>