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

/* $Id: user_profile.php,v 1.29 2003-08-24 16:39:43 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/user.inc.php");
require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/user_rel.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/session.inc.php");
require_once("./include/user_profile.inc.php");
require_once("./include/profile.inc.php");

if (isset($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
}

if (isset($HTTP_GET_VARS['psid'])) {
    $psid = $HTTP_GET_VARS['psid'];
}

if (!isset($uid)) {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<p>{$lang['nouserspecified']}</p>";
    html_draw_bottom();
    exit;
}

$user = user_get($uid);
$your_uid = bh_session_get_value('UID');

$title = format_user_name($user['LOGON'], $user['NICKNAME']);

html_draw_top("title=$title");

if (!$profile_sections = profile_sections_get()) {
    echo "<h1>{$lang['error']}:</h1>";
    echo "<p>{$lang['profilesnotsetup']}</p>";
    html_draw_bottom();
    exit;
}

$relationship = 0;

if ($uid != $your_uid) $relationship = user_rel_get($your_uid, $uid);

if (isset($HTTP_GET_VARS['setrel']) && ($uid != $your_uid)) { // user has chosen to modify their relationship
    $relationship = ($relationship & (~ (USER_FRIEND | USER_IGNORED)) | $HTTP_GET_VARS['setrel']);
    user_rel_update($your_uid,$uid,$relationship);
}

echo "<div align=\"center\">\n";
echo "  <table width=\"480\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table width=\"100%\" class=\"subhead\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "          <tr>\n";
echo "            <td><h2><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>" . format_user_name($user['LOGON'], $user['NICKNAME']);

if ($relationship & USER_FRIEND) echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><img src=\"" . style_image('friend.png') . "\" height=\"15\" alt=\"{$lang['friend']}\" />";
if ($relationship & USER_IGNORED) echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><img src=\"" . style_image('enemy.png') . "\" height=\"15\" alt=\"{$lang['ignoreduser']}\" />";

echo "</h2></td>\n";
echo "            <td align=\"right\" class=\"smalltext\">{$lang['lastvisit']}: " . format_time(user_get_last_logon_time($uid), 1) . "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "          </tr>\n";

if ($age = user_get_age($uid)) {
    echo "          <tr>\n";
    echo "            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "            <td align=\"right\" class=\"smalltext\">";

    if ($dob = user_get_dob($uid)) {
        echo "{$lang['birthday']}: " . $dob . " ({$lang['aged']} " . $age . ")<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    } else {
        echo "{$lang['age']}: " . $age . "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    }
    echo "          </tr>\n";
}

echo "          <tr>\n";
echo "            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "            <td align=\"right\" class=\"smalltext\">{$lang['posts']}: " . user_get_post_count($uid). "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "          </tr>\n";
echo "        </table>\n";

echo "        <table width=\"100%\" class=\"subhead\" border=\"0\">\n";
echo "          <tr>\n";

for ($i = 0; $i < sizeof($profile_sections); $i++) {

    if ($i == 0) {

        if (!isset($psid)) {
            $psid = $profile_sections[$i]['PSID'];
        }

    } else if(!($i % 4)){ // Start new row every 4 sections
        echo "          </tr>\n";
        echo "          <tr>\n";
    }

    echo "    <td width=\"25%\" align=\"center\">";

    if ($profile_sections[$i]['PSID'] != $psid) {
        echo "<a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?uid=$uid&psid=" . $profile_sections[$i]['PSID'] . "\">";
        echo _stripslashes($profile_sections[$i]['NAME']) . "</a></td>\n";
    } else {
        echo "<b>" . _stripslashes($profile_sections[$i]['NAME']) . "</b></td>\n";
    }
}

for(;$i % 4; $i++){
    echo "            <td width=\"25%\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
}

echo "          </tr>\n";
echo "        </table>\n";

echo "        <table width=\"100%\" class=\"posthead\">\n";
echo "          <tr>\n";
echo "            <td width=\"75%\" valign=\"top\">\n";
echo "              <table width=\"100%\">\n";

$user_profile_array = user_get_profile_entries($uid, $psid);

foreach ($user_profile_array as $profile_entry) {

    if (($profile_entry['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_entry['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

        list($field_name, $field_values) = explode(':', $profile_entry['NAME']);
        $field_values = explode(';', $field_values);

        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" width=\"33%\" valign=\"top\">", $field_name, "</td>\n";
        echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">", isset($field_values[$profile_entry['ENTRY']]) ? $field_values[$profile_entry['ENTRY']] : "", "</td>\n";
        echo "                </tr>\n";
    }else {
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" width=\"33%\" valign=\"top\">" . $profile_entry['NAME'] . "</td>\n";
        echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">", isset($profile_entry['ENTRY']) ? nl2br(_stripslashes($profile_entry['ENTRY'])) : "", "</td>\n";
        echo "                </tr>\n";
    }
}

echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\">\n";
echo "              <table width=\"100%\" class=\"subhead\">\n";
echo "                <tr>\n";

if ($profile_image = user_get_profile_image($uid)) {
    echo "                  <td align=\"center\"><img src=\"{$profile_image}\" width=\"110\" height=\"110\" /></td>\n";
}else {
    echo "                  <td align=\"center\">&nbsp;</td>\n";
}

echo "                </tr>\n";

if (bh_session_get_value('UID') <> 0) {

    echo "                <tr>\n";
    echo "                  <td><a href=\"email.php?uid=$uid\">{$lang['sendemail']}</a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td><a href=\"#\" onclick=\"opener.top.frames['main'].location.href='pm_write.php?uid=$uid'\">{$lang['sendpm']}</a></td>\n";
    echo "                </tr>\n";
}

if ($uid != $your_uid) {
    if ($relationship & USER_FRIEND) {
        $setrel = 0;
        $text = $lang['removefromfriends'];
    } else {
        $setrel = USER_FRIEND;
        $text = $lang['addtofriends'];
    }

    echo "                <tr>\n";
    echo "                  <td><a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?uid=$uid&setrel=$setrel\">$text</a></td>\n";
    echo "                </tr>\n";

    if ($relationship & USER_IGNORED) {
        $setrel = 0;
        $text = $lang['stopignoringuser'];
    } else {
        $setrel = USER_IGNORED;
        $text = $lang['ignorethisuser'];
    }

    echo "                <tr>\n";
    echo "                  <td><a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?uid=$uid&setrel=$setrel\">$text</a></td>\n";
    echo "                </tr>\n";

}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>