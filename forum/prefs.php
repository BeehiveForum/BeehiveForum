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

//Check logged in status
require_once("./include/session.inc.php");
if(!bh_session_check()){
    $go = "Location: http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $go .= "/".dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $go .= "/logon.php?final_uri=";
    $go .= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    header($go);
}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");

$error_html = "";

if(isset($HTTP_POST_VARS['submit'])){
    $valid = true;
    if(isset($HTTP_POST_VARS['pw'])){
        if($HTTP_POST_VARS['pw'] != $HTTP_POST_VARS['cpw']){
            $error_html = "<h2>Passwords do not match</h2>";
            $valid = false;
        }
    }

    if(empty($HTTP_POST_VARS['nickname'])){
        $error_html .= "<h2>Nickname is required</h2>";
        $valid = false;
    }

    if(empty($HTTP_POST_VARS['email'])){
        $error_html .= "<h2>Email address is required</h2>";
        $valid = false;
    }

    if($valid){
        if($HTTP_POST_VARS['sig_html'] == "Y"){
            $HTTP_POST_VARS['sig_content'] = fix_html($HTTP_POST_VARS['sig_content']);
        }
    }

    if($valid){
        // Update basic settings in USER table
        user_update($HTTP_COOKIE_VARS['bh_sess_uid'],
                    $HTTP_POST_VARS['pw'], $HTTP_POST_VARS['nickname'],
                    $HTTP_POST_VARS['email']);

        // Update or insert USER_PREFS
        if($HTTP_POST_VARS['prefs_exist'] == "Y"){
            user_update_prefs($HTTP_COOKIE_VARS['bh_sess_uid'],
                        $HTTP_POST_VARS['firstname'], $HTTP_POST_VARS['lastname'],
                        $HTTP_POST_VARS['homepage_url'], $HTTP_POST_VARS['pic_url'],
                        $HTTP_POST_VARS['email_notify'], $HTTP_POST_VARS['timezone'],
                        $HTTP_POST_VARS['dl_saving'], $HTTP_POST_VARS['mark_as_of_int'],
                        $HTTP_POST_VARS['posts_per_page']);
        } else {
            user_insert_prefs($HTTP_COOKIE_VARS['bh_sess_uid'],
                        $HTTP_POST_VARS['firstname'], $HTTP_POST_VARS['lastname'],
                        $HTTP_POST_VARS['homepage_url'], $HTTP_POST_VARS['pic_url'],
                        $HTTP_POST_VARS['email_notify'], $HTTP_POST_VARS['timezone'],
                        $HTTP_POST_VARS['dl_saving'], $HTTP_POST_VARS['mark_as_of_int'],
                        $HTTP_POST_VARS['posts_per_page']);
        }

        // Update or insert USER_SIG
        if($HTTP_POST_VARS['sig_exists'] == "Y"){
            user_update_sig($HTTP_COOKIE_VARS['bh_sess_uid'],
                        $HTTP_POST_VARS['sig_content'], $HTTP_POST_VARS['sig_html']);
        } else {
            user_insert_sig($HTTP_COOKIE_VARS['bh_sess_uid'],
                        $HTTP_POST_VARS['sig_content'], $HTTP_POST_VARS['sig_html']);
        }
        $user = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);
        $user_prefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
        $user_prefs_exist = (count($user_prefs) > 0);
        user_get_sig($HTTP_COOKIE_VARS['bh_sess_uid'],$user_sig['CONTENT'],$user_sig['HTML']);
        $user_sig_exist = (count($user_sig) > 0);
    }
/*    $user['NICKNAME'] = $HTTP_POST_VARS['nickname'];
    $user['EMAIL'] = $HTTP_POST_VARS['email'];
    $user_prefs['FIRSTNAME'] = $HTTP_POST_VARS['firstname'];
    $user_prefs['LASTNAME'] = $HTTP_POST_VARS['lastname'];
    $user_prefs['HOMEPAGE_URL'] = $HTTP_POST_VARS['homepage_url'];
    $user_prefs['PIC_URL'] = $HTTP_POST_VARS['pic_url'];
    $user_prefs['EMAIL_NOTIFY'] = $HTTP_POST_VARS['email_notify'];
    $user_prefs['TIMEZONE'] = $HTTP_POST_VARS['timezone'];
    $user_prefs['DL_SAVING'] = $HTTP_POST_VARS['dl_saving'];
    $user_prefs['MARK_AS_OF_INT'] = $HTTP_POST_VARS['mark_as_of_int'];
    $user_prefs['POSTS_PER_PAGE'] = $HTTP_POST_VARS['posts_per_page'];
    $user_sig['CONTENT'] = $HTTP_POST_VARS['content'];
    $user_sig['HTML'] = $HTTP_POST_VARS['html'];*/
} else {

// Get preferences
    if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
        $user = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);
        $user_prefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
        $user_prefs_exist = (count($user_prefs) > 0);
        user_get_sig($HTTP_COOKIE_VARS['bh_sess_uid'],$user_sig['CONTENT'],$user_sig['HTML']);
        $user_sig_exists = (count($user_prefs) > 0);
    }
}

html_draw_top();

echo "<h1>User Preferences</h1>";
if(!empty($error_html)){
    echo $error_html;
}
echo "<div class=\"postbody\">";
echo "<form name=\"prefs\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">";
echo "<table>";
echo "<tr><td><h1>User Details</h1></td><td></td></tr>";
echo "<tr><td>New Password:</td>";
echo "<td><input type=\"password\" name=\"pw\"></td></tr>";
echo "<tr><td>Confirm Password:</td>";
echo "<td><input type=\"password\" name=\"cpw\"></td></tr>";
echo "<tr><td>Nickname:</td>";
echo "<td><input type=\"text\" name=\"nickname\" maxchars=\"32\" width=\"32\" value=\"" . $user['NICKNAME'] . "\"></td></tr>";
echo "<tr><td>Email Address:</td>";
echo "<td><input type=\"text\" name=\"email\"  maxchars=\"80\" width=\"60\" value=\"" . $user['EMAIL'] . "\"></td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>Forum Options</td><td></td></tr>";
echo "<tr><td>First name:</td>";
echo "<td><input type=\"text\" name=\"firstname\"  maxchars=\"32\" width=\"32\" value=\"" . $user_prefs['FIRSTNAME'] . "\"></td></tr>";
echo "<tr><td>Last name:</td>";
echo "<td><input type=\"text\" name=\"lastname\" maxchars=\"32\" width=\"32\"  value=\"" . $user_prefs['LASTNAME'] . "\"></td></tr>";
echo "<tr><td>Homepage URL:</td>";
echo "<td><input type=\"text\" name=\"homepage_url\" maxchars=\"255\" width=\"60\"  value=\"" . $user_prefs['HOMEPAGE_URL'] . "\"></td></tr>";
echo "<tr><td>Picture URL:</td>";
echo "<td><input type=\"text\" name=\"pic_url\" maxchars=\"255\" width=\"60\"  value=\"" . $user_prefs['PIC_URL'] . "\"></td></tr>";
echo "<tr><td colspan=\"2\">Notify by email of posts to me&nbsp;";
echo "<input type=\"checkbox\" name=\"email_notify\" value=\"Y\"";
if($user_prefs['EMAIL_NOTIFY'] == "Y"){
    echo " checked";
}
echo "></td></tr>";
echo "<tr><td>Timezone (from GMT)</td>";
echo "<td><select name=\"timezone\"";
echo "<option value=\"" . $user_prefs['TIMEZONE'] . "\">" . $user_prefs['TIMEZONE'] . "</option>";
for($tz = -11; $tz < 12; $tz++){
    if($tz == $user_prefs['TIMEZONE']){
        echo "<option selected value=\"$tz\">$tz</option>";
    } else {
        echo "<option value=\"$tz\">$tz</option>";
    }
}
echo "</select></td></tr>";
echo "<tr><td colspan=\"2\">Adjust for daylight saving&nbsp;";
echo "<input type=\"checkbox\" name=\"dl_saving\" value=\"Y\"";
if($user_prefs['DL_SAVING'] == "Y"){
    echo " checked";
}
echo "></td></tr>";
echo "<tr><td colspan=\"2\">Automatically mark threads I post in as High Interest&nbsp;";
echo "<input type=\"checkbox\" name=\"mark_as_of_int\" value=\"Y\"";
if($user_prefs['MARK_AS_OF_INT'] == "Y"){
    echo " checked";
}
echo "></td></tr>";
echo "<tr><td>Posts per page:</td>";
echo "<td><select name=\"posts_per_page\"";
for($ppp = 5; $ppp < 25; $ppp+=5){
    if($ppp == $user_prefs['POSTS_PER_PAGE']){
        echo "<option selected value=\"$ppp\">$ppp</option>";
    } else {
        echo "<option value=\"$ppp\">$ppp</option>";
    }
}
echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td colspan=\"2\"><h2>Signature:</h2></td></tr>";
echo "<tr><td colspan=\"2\"><textarea name=\"sig_content\" cols=\"60\" rows=\"4\" wrap=\"VIRTUAL\">". $user_sig['CONTENT'] . "</textarea>";
echo "<tr><td colspan=\"2\"><input type=\"checkbox\" name=\"sig_html\" value=\"Y\"";
if($user_sig['HTML'] == "Y"){
    echo " checked";
}
echo ">&nbsp;Contains HTML</td></tr></table>";
if($user_prefs_exist){
    echo "<input type=\"hidden\" name=\"prefs_exist\" value=\"Y\">";
}
if($user_sig_exists){
    echo "<input type=\"hidden\" name=\"sig_exists\" value=\"Y\">";
}
echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";

html_draw_bottom();
?>