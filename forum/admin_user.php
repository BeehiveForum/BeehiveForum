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

// Frameset for thread list and messages

//Check logged in status
require_once("./include/session.inc.php");
if(!bh_session_check()){
    $go = "Location: http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $go .= "/".dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $go .= "/logon.php?final_uri=";
    $go .= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    header($go);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!$HTTP_COOKIE_VARS[bh_sess_ustatus] & USER_PERM_SOLDIER){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

if(isset($HTTP_GET_VARS['uid'])){
    $uid = $HTTP_GET_VARS['uid'];
} else if(isset($HTTP_POST_VARS['t_uid'])){
    $uid = $HTTP_POST_VARS['t_uid'];
} else {
    echo "<h1>Invalid Operation</h1>\n";
    echo "<p>No user specified for editing.</p>\n";
    html_draw_bottom();
    exit;
}

$db = db_connect();

$sql = "select LOGON, NICKNAME, STATUS ";
$sql.= "from " . forum_table("USER");
$sql.= " where UID = $uid";

$result = db_query($sql,$db);

$user = db_fetch_array($result);

db_disconnect($db);

// Do updates
if(isset($HTTP_POST_VARS['submit'])){
    $new_status = $HTTP_POST_VARS['t_worker'] | $HTTP_POST_VARS['t_worm'] | $HTTP_POST_VARS['t_wasp'] | $HTTP_POST_VARS['t_splat'];
    if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN){
        echo "This";
        $new_status = $new_status | $HTTP_POST_VARS['t_soldier'];
    } else {
        $new_status = $new_status | ($user['STATUS'] & USER_PERM_SOLDIER);
        echo "That";
    }
    user_update_status($uid,$new_status);
    $user['STATUS'] = $new_status;
}

// Draw the form
echo "<h1>Manage User</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";

echo "<form name=\"f_folders\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table width=\"50%\"><tr><td class=\"box\">";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\">User: ".$user['LOGON']."</td></tr>\n";

if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN){
    echo "<tr><td><input type=\"checkbox\" name=\"t_soldier\" value=\"". USER_PERM_SOLDIER . "\"";
    if($user['STATUS'] & USER_PERM_SOLDIER){
        echo " checked";
    }
    echo "> Soldier</td></tr>\n";
}

echo "<tr><td><input type=\"checkbox\" name=\"t_worker\" value=\"". USER_PERM_WORKER . "\"";
if($user['STATUS'] & USER_PERM_WORKER){
    echo " checked";
}
echo "> Worker</td></tr>\n";

echo "<tr><td><input type=\"checkbox\" name=\"t_worm\" value=\"". USER_PERM_WORM . "\"";
if($user['STATUS'] & USER_PERM_WORM){
    echo " checked";
}
echo "> Worm</td></tr>\n";

echo "<tr><td><input type=\"checkbox\" name=\"t_wasp\" value=\"". USER_PERM_WASP . "\"";
if($user['STATUS'] & USER_PERM_WASP){
    echo " checked";
}
echo "> Wasp</td></tr>\n";

echo "<tr><td><input type=\"checkbox\" name=\"t_splat\" value=\"". USER_PERM_SPLAT . "\"";
if($user['STATUS'] & USER_PERM_SPLAT){
    echo " checked";
}
echo "> Splat</td></tr>\n";


echo "</table>\n";
echo "<input type=\"hidden\" name=\"t_uid\" value=\"$uid\">\n";
echo "</td></tr></table>\n";
echo "<input type=\"submit\" class=\"button\" name=\"submit\" value=\"Submit\">\n";
echo "</form>\n";
echo "<p>&nbsp;</p>";
echo "<table border=\"0\"><tr><td>";
echo "<p><b>Soldiers</b> can access all moderation tools, but cannot create or remove other Soldiers.</p>\n";
echo "<p><b>Workers</b> can edit or delete any post.</p>\n";
echo "<p><b>Worms</b> can read messages and post as normal, but their messages will appear deleted to all other users.</p>\n";
echo "<p><b>Wasps</b> can read messages, but cannot reply or post new messages.</p>";
echo "<p><b>Splats</b> cannot access the forum. Use this to ban persistent idiots.</p>";
echo "</td></tr></table>\n";

echo "</div>\n";

html_draw_bottom();

?>
