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
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    
    header_redirect($uri);
}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");

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
                        $HTTP_POST_VARS['posts_per_page'], $HTTP_POST_VARS['font_size']);
        } else {
            user_insert_prefs($HTTP_COOKIE_VARS['bh_sess_uid'],
                        $HTTP_POST_VARS['firstname'], $HTTP_POST_VARS['lastname'],
                        $HTTP_POST_VARS['homepage_url'], $HTTP_POST_VARS['pic_url'],
                        $HTTP_POST_VARS['email_notify'], $HTTP_POST_VARS['timezone'],
                        $HTTP_POST_VARS['dl_saving'], $HTTP_POST_VARS['mark_as_of_int'],
                        $HTTP_POST_VARS['posts_per_page'], $HTTP_POST_VARS['font_size']);
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
echo "<table class=\"posthead\">";
echo "<tr><td class=\"subhead\" colspan=\"2\">User Details</td></tr>";
echo "<tr><td>New Password:</td>";
echo "<td>".form_field("pw","",0,0,"password")."</td></tr>";
echo "<tr><td>Confirm Password:</td>";
echo "<td>".form_field("cpw","",0,0,"password")."</td></tr>";
echo "<tr><td>Nickname:</td>";
echo "<td>".form_field("nickname",$user['NICKNAME'],32,32)."</td></tr>";
echo "<tr><td>Email Address:</td>";
echo "<td>".form_field("email",$user['EMAIL'],60,80)."</td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>First name:</td>";
echo "<td>".form_field("firstname",$user_prefs['FIRSTNAME'],32,32)."</td></tr>";
echo "<tr><td>Last name:</td>";
echo "<td>".form_field("lastname",$user_prefs['LASTNAME'],32,32)."</td></tr>";
echo "<tr><td>Homepage URL:</td>";
echo "<td>".form_field("homepage_url",$user_prefs['HOMEPAGE_URL'],60,255)."</td></tr>";
echo "<tr><td>Picture URL:</td>";
echo "<td>".form_field("pic_url",$user_prefs['PIC_URL'],60,255)."</td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td class=\"subhead\" colspan=\"2\">Forum Options</td></tr>";
echo "<tr><td>&nbsp;</td>";
echo "<td>".form_checkbox("email_notify","Y","Notify by email of posts<br />to me",($user_prefs['EMAIL_NOTIFY'] == "Y"))."</td></tr>";
echo "<tr><td>Timezone (from GMT)</td>";
echo "<td>".form_dropdown_array("timezone",range(-11,11),range(-11,11),$user_prefs['TIMEZONE'])."</td></tr>";
echo "<tr><td>&nbsp;</td>";
echo "<td>".form_checkbox("dl_saving","Y","Adjust for<br />daylight saving",($user_prefs['DL_SAVING'] == "Y"))."</td></tr>";
echo "<tr><td>&nbsp;</td>";
echo "<td>".form_checkbox("mark_as_of_int","Y","Automatically mark threads<br />I post in as High Interest",($user_prefs['MARK_AS_OF_INT'] == "Y"))."</td></tr>";
echo "<tr><td>Posts per page:</td>";
echo "<td>".form_dropdown_array("posts_per_page",array(5,10,20),array(5,10,20),$user_prefs['POSTS_PER_PAGE'])."</td></tr>";
echo "<tr><td>Font size:</td>";
echo "<td>".form_dropdown_array("font_size",range(1,15),range(1,15),$user_prefs['FONT_SIZE'])."</td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td class=\"subhead\" colspan=\"2\">Signature</td></tr>";
echo "<tr><td colspan=\"2\">".form_textarea("sig_content",$user_sig['CONTENT'],4,60);
echo "<tr><td>&nbsp;</td><td align=\"right\">";
echo form_checkbox("sig_html","Y","Contains HTML",($user_sig['HTML'] == "Y"));
echo "</td></tr></table>";
if($user_prefs_exist){
    echo form_field("prefs_exist","Y",0,0,"hidden");
}
if($user_sig_exists){
    echo form_field("sig_exists","Y",0,0,"hidden");
}
echo form_submit("submit","Submit");
echo "</form>";
html_draw_bottom();
?>
