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

html_draw_top(format_user_name($user['LOGON'],$user['NICKNAME']));

$db = db_connect();

$sql = "select distinct PS.PSID, PS.NAME from ";
$sql.= forum_table("PROFILE_SECTION") . " PS, ";
$sql.= forum_table("PROFILE_ITEM") . " PI ";
$sql.= " where PS.PSID = PI.PSID";
$sql.= " order by PS.PSID";

$result = db_query($sql,$db);

$row_count = db_num_rows($result);

if($row_count == 0){
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
echo "          <tr>\n";
echo "            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "            <td align=\"right\" class=\"smalltext\">{$lang['posts']}: " . user_get_post_count($uid). "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "          </tr>\n";
echo "        </table>\n";

echo "        <table width=\"100%\" class=\"subhead\" border=\"0\">\n";
echo "          <tr>\n";

for ($i = 0; $i < $row_count; $i++) {

    $row = db_fetch_array($result);

    if ($i == 0) {

        if (!isset($psid)) {
            $psid = $row['PSID'];
        }

    } else if(!($i % 4)){ // Start new row every 4 sections
        echo "          </tr>\n";
        echo "          <tr>\n";
    }

    echo "    <td width=\"25%\" align=\"center\">";

    if($row['PSID'] != $psid){
        echo "<a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?uid=$uid&psid=" . $row['PSID'] . "\">";
        echo _stripslashes($row['NAME']) . "</a></td>\n";
    } else {
        echo "<b>" . _stripslashes($row['NAME']) . "</b></td>\n";
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

$sql = "select PI.NAME, UP.ENTRY from " . forum_table("PROFILE_ITEM") . " PI ";
$sql.= "left join " . forum_table("USER_PROFILE") . " UP on (UP.PIID = PI.PIID and UP.UID = $uid) ";
$sql.= "where PI.PSID = $psid order by PI.PIID";

$result = db_query($sql,$db);

while($row = db_fetch_array($result)){
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" width=\"33%\" valign=\"top\">" . $row['NAME'] . "</td>\n";
    echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">", isset($row['ENTRY']) ? _stripslashes($row['ENTRY']) : "", "</td>\n";
    echo "                </tr>\n";
}

$sql = "select PIC_URL from ". forum_table("USER_PREFS"). " where UID = $uid";
$result = db_query($sql, $db);
$row = db_fetch_array($result);

echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\">\n";
echo "              <table width=\"100%\" class=\"subhead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">", (isset($row['PIC_URL']) && strlen($row['PIC_URL']) > 0) ? "<img src=\"". $row['PIC_URL']. "\" width=\"110\" height=\"110\" />" : "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><a href=\"email.php?uid=$uid\">{$lang['sendemail']}</a></td>\n";
echo "                </tr>\n";

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
