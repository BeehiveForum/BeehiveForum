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
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode(get_request_uri());
    
    header_redirect($uri);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

if(isset($HTTP_GET_VARS['uid'])){
    $uid = $HTTP_GET_VARS['uid'];
} else if(isset($HTTP_POST_VARS['uid'])){
    $uid = $HTTP_POST_VARS['uid'];
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

// Do updates
if(isset($HTTP_POST_VARS['submit'])){
    $new_status = $HTTP_POST_VARS['t_worker'] | $HTTP_POST_VARS['t_worm'] | $HTTP_POST_VARS['t_wasp'] | $HTTP_POST_VARS['t_splat'];
    if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN){
        $new_status = $new_status | $HTTP_POST_VARS['t_soldier'];
    } else {
        $new_status = $new_status | ($user['STATUS'] & USER_PERM_SOLDIER);
        $new_status = $new_status | ($user['STATUS'] & USER_PERM_QUEEN);
    }
    
    // Add lower ranks automatically
    if($new_status & USER_PERM_QUEEN) $new_status |= USER_PERM_SOLDIER;
    if($new_status & USER_PERM_SOLDIER) $new_status |= USER_PERM_WORKER;
    user_update_status($uid,$new_status);
    $user['STATUS'] = $new_status;
    
    // Private folder permissions
    for($i=0; $i<$HTTP_POST_VARS['t_fcount']; $i++){
        $uf[$i]['fid'] = $HTTP_POST_VARS['t_fid_'.$i];
        $uf[$i]['allowed'] = $HTTP_POST_VARS['t_fallow_'.$i];
    }
    user_update_folders($uid,$uf);
}

// Draw the form
echo "<h1>Manage User</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";

echo "<form name=\"f_user\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table width=\"50%\"><tr><td class=\"box\">";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\">User Status: ".$user['LOGON']."</td></tr>\n";

if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN){
    echo "<tr><td>".form_checkbox("t_soldier",USER_PERM_SOLDIER,"Soldier",($user['STATUS'] & USER_PERM_SOLDIER))."</td></tr>\n";
}

echo "<tr><td>".form_checkbox("t_worker",USER_PERM_WORKER,"Worker",($user['STATUS'] & USER_PERM_WORKER))."</td></tr>\n";
echo "<tr><td>".form_checkbox("t_worm",USER_PERM_WORM,"Worm",($user['STATUS'] & USER_PERM_WORM))."</td></tr>\n";
echo "<tr><td>".form_checkbox("t_wasp",USER_PERM_WASP,"Wasp",($user['STATUS'] & USER_PERM_WASP))."</td></tr>\n";
echo "<tr><td>".form_checkbox("t_splat",USER_PERM_SPLAT,"Splat",($user['STATUS'] & USER_PERM_SPLAT))."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";

echo "<tr><td class=\"subhead\">Folder Access:</td></tr>\n";

$sql = "select F.FID, F.TITLE, UF.ALLOWED from ".forum_table("FOLDER")." F ";
$sql.= "left join ".forum_table("USER_FOLDER")." UF on (UF.UID = $uid and UF.FID = F.FID) ";
$sql.= "where F.ACCESS_LEVEL = 1"; // Restricted folders

$db = db_connect();
$result = db_query($sql,$db);

for($i=0;$row = db_fetch_array($result);$i++){
    echo "<tr><td>".form_checkbox("t_fallow_$i",1,$row['TITLE'],($row['ALLOWED'] > 0));
    echo form_input_hidden("t_fid_$i",$row['FID'])."</td></tr>\n";
}

if($i==0){
    echo "<tr><td>No restricted folders</td></tr>\n";
}

echo "</table>\n";
echo form_input_hidden("t_fcount",$i);
echo form_input_hidden("uid", $uid);
echo "</td></tr></table>\n";
echo form_submit();
echo "</form>\n";
echo "<p>&nbsp;</p>";
echo "<table width=\"50%\" border=\"0\"><tr><td>";
echo "<p><b>Soldiers</b> can access all moderation tools, but cannot create or remove other Soldiers.</p>\n";
echo "<p><b>Workers</b> can edit or delete any post.</p>\n";
echo "<p><b>Worms</b> can read messages and post as normal, but their messages will appear deleted to all other users.</p>\n";
echo "<p><b>Wasps</b> can read messages, but cannot reply or post new messages.</p>";
echo "<p><b>Splats</b> cannot access the forum. Use this to ban persistent idiots.</p>";
echo "</td></tr></table>\n";

echo "</div>\n";

html_draw_bottom();

?>
