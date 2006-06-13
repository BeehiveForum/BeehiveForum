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

/* $Id: user_profile.php,v 1.94 2006-06-13 21:03:22 decoyduck Exp $ */

/**
* Displays user profiles
*/

/**
*/

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

}elseif (isset($_GET['logon']) && strlen(trim(_stripslashes($_GET['logon']))) > 0) {

    $logon = trim(_stripslashes($_GET['logon']));
    $user_array = user_get_uid($logon);
    $uid = $user_array['UID'];
}

if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {
    $psid = $_GET['psid'];
}

if (!isset($uid)) {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}:</h1>";
    echo "<h2>{$lang['nouserspecified']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$profile_sections = profile_sections_get()) {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<h2>{$lang['profilesnotsetup']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$user_profile = user_get_profile($uid)) {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<h2>{$lang['profilesnotsetup']}</h2>";
    html_draw_bottom();
    exit;
}

$title = format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']);

html_draw_top("title=$title", "openprofile.js", "basetarget=_blank");

// user has chosen to modify their relationship

if (isset($_GET['setrel']) && ($uid != bh_session_get_value('UID')) && bh_session_get_value('UID') > 0) {

    $user_profile['RELATIONSHIP'] = ($user_profile['RELATIONSHIP'] & (~(USER_FRIEND | USER_IGNORED)) | $_GET['setrel']);
    user_rel_update(bh_session_get_value('UID'), $uid, $user_profile['RELATIONSHIP']);
}

echo "<div align=\"center\">\n";
echo "  <table width=\"550\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"550\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\"><h2>&nbsp;", format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']);

if (bh_session_get_value('UID') > 0) {

    if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_FRIEND)) echo "&nbsp;&nbsp;<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";
    if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_IGNORED)) echo "&nbsp;&nbsp;<img src=\"", style_image('enemy.png'), "\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
}

echo "</h2></td>\n";
echo "                  <td align=\"right\" class=\"subhead\"><span class=\"smalltext\">{$lang['lastvisit']}: {$user_profile['LAST_LOGON']}&nbsp;</span></td>\n";
echo "                </tr>\n";

if (isset($user_profile['AGE'])) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">&nbsp;</td>\n";
    echo "                  <td  class=\"subhead\" align=\"right\" class=\"smalltext\">";

    if (isset($user_profile['DOB'])) {

        echo "{$lang['birthday']}: {$user_profile['DOB']} ({$lang['aged']} {$user_profile['AGE']})&nbsp;</td>\n";

    }else {

        echo "{$lang['age']}: {$user_profile['AGE']}&nbsp;</td>\n";
    }

    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"right\" class=\"smalltext\">{$lang['posts']}: {$user_profile['POST_COUNT']}&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table width=\"550\" class=\"subhead\" border=\"0\">\n";
echo "                <tr>\n";

for ($i = 0; $i < sizeof($profile_sections); $i++) {

    if ($i == 0) {

        if (!isset($psid)) {
            $psid = $profile_sections[$i]['PSID'];
        }

    }else if (!($i % 4)) { // Start new row every 4 sections

        echo "                </tr>\n";
        echo "                <tr>\n";
    }

    if ($profile_sections[$i]['PSID'] != $psid) {
        echo "                  <td width=\"25%\" align=\"center\"><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;psid={$profile_sections[$i]['PSID']}\" target=\"_self\">", _stripslashes($profile_sections[$i]['NAME']), "</a></td>\n";
    }else {
        echo "                  <td width=\"25%\" align=\"center\"><b>", _stripslashes($profile_sections[$i]['NAME']), "</b></td>\n";
    }
}

for(;$i % 4; $i++) {
    echo "                  <td width=\"25%\">&nbsp;</td>\n";
}

echo "                </tr>\n";
echo "              </table>\n";

echo "              <table width=\"550\" class=\"posthead\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                <tr>\n";
echo "                  <td width=\"400\" valign=\"top\">\n";
echo "                    <table width=\"400\">\n";

$user_profile_array = user_get_profile_entries($uid, $psid);
$rel = user_rel_get($uid, bh_session_get_value('UID'));

foreach ($user_profile_array as $profile_entry) {

    if (($profile_entry['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_entry['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

        list($field_name, $field_values) = explode(':', $profile_entry['NAME']);

        $field_values = explode(';', $field_values);

        echo "                      <tr>\n";
        echo "                        <td class=\"subhead\" width=\"33%\" valign=\"top\">", $field_name, "</td>\n";

        if (isset($profile_entry['ENTRY']) && isset($field_values[$profile_entry['ENTRY']])) {

            echo "                        <td width=\"67%\" class=\"posthead\" valign=\"top\">{$field_values[$profile_entry['ENTRY']]}</td>\n";

        }else {

            echo "                        <td width=\"67%\" class=\"posthead\" valign=\"top\">&nbsp;</td>\n";
        }

        echo "                      </tr>\n";

    }else {

        echo "                      <tr>\n";
        echo "                        <td class=\"subhead\" width=\"33%\" valign=\"top\">{$profile_entry['NAME']}</td>\n";

        if (($uid != bh_session_get_value('UID')) && ($rel != USER_FRIEND) && ($profile_entry['PRIVACY'] == 1)) {
            echo "                        <td width=\"67%\" class=\"posthead\" valign=\"top\"></td>\n";
        }else {
            echo "                        <td width=\"67%\" class=\"posthead\" valign=\"top\">", isset($profile_entry['ENTRY']) ? nl2br(make_links(_stripslashes($profile_entry['ENTRY']))) : "", "</td>\n";
        }

        echo "                      </tr>\n";
    }
}

echo "                      <tr>\n";
echo "                        <td width=\"33%\">&nbsp;</td>\n";
echo "                        <td width=\"67%\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td width=\"150\" valign=\"top\">\n";
echo "                    <table width=\"150\" class=\"subhead\" cellspacing=\"5\" cellpadding=\"0\">\n";

if (isset($user_profile['PIC_URL'])) {

    echo "                      <tr>\n";
    echo "                        <td align=\"center\"><img src=\"{$user_profile['PIC_URL']}\" width=\"110\" height=\"110\" alt=\"$title\" title=\"$title\" /></td>\n";
    echo "                      </tr>\n";
}

if ($uid == bh_session_get_value('UID')) {

    echo "                      <tr>\n";
    echo "                        <td><a href=\"javascript:void(0)\" onclick=\"launchAttachProfileWin('$webtag');\" target=\"_self\">{$lang['editmyattachments']}</a></td>\n";
    echo "                      </tr>\n";
}

if (bh_session_get_value('UID') != 0) {

    echo "                      <tr>\n";
    echo "                        <td><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_self\">{$lang['sendemail']}</a></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td><a href=\"index.php?webtag=$webtag&amp;final_uri=", rawurlencode("./pm_write.php?webtag=$webtag&amp;uid=$uid"), "\" target=\"_blank\">{$lang['sendpm']}</a></td>\n";
    echo "                      </tr>\n";

    if ($uid != bh_session_get_value('UID')) {

        if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_FRIEND)) {

            $setrel = 0;
            $text = $lang['removefromfriends'];

        }else {

            $setrel = USER_FRIEND;
            $text = $lang['addtofriends'];
        }

        echo "                      <tr>\n";
        echo "                        <td><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;setrel=$setrel\" target=\"_self\">$text</a></td>\n";
        echo "                      </tr>\n";

        if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_IGNORED)) {

            $setrel = 0;
            $text = $lang['stopignoringuser'];

        }else {

            $setrel = USER_IGNORED;
            $text = $lang['ignorethisuser'];
        }

        echo "                      <tr>\n";
        echo "                        <td><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;setrel=$setrel\" target=\"_self\">$text</a></td>\n";
        echo "                      </tr>\n";
    }
}

echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\" align=\"right\">{$lang['longesttimeinforum']}: {$user_profile['USER_TIME_BEST']}&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\" align=\"right\">{$lang['totaltimeinforum']}: {$user_profile['USER_TIME_TOTAL']}&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;</td>\n";
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
echo "  </table>\n";
echo "</div>\n";



html_draw_bottom();

?>