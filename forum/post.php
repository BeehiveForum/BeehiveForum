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
require_once("./include/format.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/email.inc.php");

$valid = true;

if(isset($HTTP_POST_VARS['t_newthread'])){
    $newthread = true;
    if(isset($HTTP_POST_VARS['t_threadtitle']) && trim($HTTP_POST_VARS['t_threadtitle']) != ""){
        $t_threadtitle = trim($HTTP_POST_VARS['t_threadtitle']);
    } else {
        $error_html = "<h2>You must enter a title for the thread</h2>";
        $valid = false;
    }
    if(isset($HTTP_POST_VARS['t_fid'])){
        $t_fid = $HTTP_POST_VARS['t_fid'];
    } else if($valid){
        $error_html = "<h2>Please select a folder</h2>";
        $valid = false;
    }
    if(isset($HTTP_POST_VARS['t_content'])){
        $t_content = $HTTP_POST_VARS['t_content'];
    } else {
        $error_html = "<h2>You must enter some content for the post</h2>";
        $valid = false;
    }    
} else {
    if(isset($HTTP_POST_VARS['t_tid'])){
        if(isset($HTTP_POST_VARS['t_content'])){
            $t_content = $HTTP_POST_VARS['t_content'];
        } else {
            $error_html = "<h2>You must enter some content for the post</h2>";
            $valid = false;
        }
    } else {
        $valid = false;
    }
}

if($valid){
    if($t_post_html == "Y"){
        $t_content = fix_html($t_content);
    }
}

html_draw_top();

/* echo "<table border=\"1\">";
foreach ($HTTP_POST_VARS as $var => $value) {
    echo "<tr><td>$var</td><td>$value</td></tr>";
}
echo "</table>"; */

if($valid){
    if(isset($HTTP_POST_VARS['preview'])){
        echo "<h2>Message Preview:</h2>";
        if($HTTP_POST_VARS['t_to_uid'] == 0){
            $preview_message['TLOGON'] = "ALL";
            $preview_message['TNICK'] = "ALL";
        } else {
            $preview_tuser = user_get($HTTP_POST_VARS['t_to_uid']);
            $preview_message['TLOGON'] = $preview_tuser['LOGON'];
            $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        }
        $preview_tuser = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);
        $preview_message['FLOGON'] = $preview_tuser['LOGON'];
        $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
        if($t_post_html != "Y"){
            $preview_message['CONTENT'] = make_html($t_content);
        } else {
            $preview_message['CONTENT'] = $t_content;
        }
        if($t_sig){
            if($t_sig_html != "Y"){
                $t_sig = make_html($t_sig);
            } else {
                $t_sig = stripslashes($t_sig);
            }
            $preview_message['CONTENT'] = $preview_message['CONTENT'] . "<span class=\"sig\">$t_sig</span>";
        }
        message_display(0,$preview_message,0,0,false);
    } else if(isset($HTTP_POST_VARS['submit'])){
        if($newthread){
            $t_tid = post_create_thread($t_fid,$t_threadtitle);
            $t_rpid = 0;
        } else {
            $t_tid = $HTTP_POST_VARS['t_tid'];
            $t_rpid = $HTTP_POST_VARS['t_rpid'];
        }
        if($t_tid > 0){
            if($t_post_html != "Y"){
                $t_content = make_html($t_content);
            }
            if($t_sig){
                if($t_sig_html != "Y"){
                    $t_sig = make_html($t_sig);
                }
                $t_content .= "\n<div class=\"sig\">$t_sig</div>";
            }
            $new_pid = post_create($t_tid,$t_rpid,$HTTP_COOKIE_VARS['bh_sess_uid'],$HTTP_POST_VARS['t_to_uid'],$t_content);
            if($new_pid > -1){
                echo "<p>&nbsp;</p>";
                echo "<p>&nbsp;</p>";
                echo "<div align=\"center\">";
                echo "<p>Post created successfully</p>";
                echo "<p><a href=\"discussion.php?msg=$t_tid.$t_rpid\">Return to messages</a></p>";
                echo "</div>";
                html_draw_bottom();
                if(!$newthread){
                    email_sendnotification($HTTP_POST_VARS['t_to_uid'], "$t_tid.$new_pid", $HTTP_COOKIE_VARS['bh_sess_uid']);
                }
                exit;
            } else {
                $error_html = "<h2>Error creating post</h2>";
            }
        }
    }
}

if(isset($HTTP_GET_VARS['replyto'])){
    $replyto = $HTTP_GET_VARS['replyto'];
    $ma = explode(".",$replyto);
    $reply_to_tid = $ma[0];
    $reply_to_pid = $ma[1];
    $newthread = false;
} else if(isset($HTTP_POST_VARS['t_tid'])){
    $reply_to_tid = $HTTP_POST_VARS['t_tid'];
    $reply_to_pid = $HTTP_POST_VARS['t_rpid'];
    $newthread = false;
} else {
    $newthread = true;
    if(isset($HTTP_GET_VARS['fid'])){
        $t_fid = $HTTP_GET_VARS['fid'];
    } else if(isset($HTTP_POST_VARS['t_fid'])){
        $t_fid = $HTTP_POST_VARS['t_fid'];
    }
}

if(!$newthread){
    if(isset($HTTP_POST_VARS['t_to_uid'])){
        $t_to_uid = $HTTP_POST_VARS['t_to_uid'];
    } else {
        $t_to_uid = message_get_user($reply_to_tid,$reply_to_pid);
    }
}

$sig_content = "";
$sig_html = "N";
$has_sig = user_get_sig($HTTP_COOKIE_VARS['bh_sess_uid'],$sig_content,$sig_html);
if($newthread){
    echo "<h2>Create new thread</h2>";
} else {
    echo "<h2>Post reply</h2>";
}
if(isset($error_html)){
    echo $error_html;
}
echo "<form name=\"f_post\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">";
if($newthread){
    echo "<table>";
    echo "<tr><td>Select folder:</td></tr>";
    echo "<tr><td>" . folder_draw_dropdown($t_fid) . "</td></tr>";
    echo "<tr><td>Thread title:</td></tr>";
    echo "<tr><td><input type=\"text\" name=\"t_threadtitle\" maxchars=\"64\" width=\"64\" value=\"";
    if (isset($t_threadtitle)) echo stripslashes(htmlentities($t_threadtitle));
    echo "\">";
    echo "<input type=\"hidden\" name=\"t_newthread\" value=\"Y\"></td></tr>";
    echo "</table>";
} else {
    echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>";
    echo "<input type=\"hidden\" name=\"t_tid\" value=\"$reply_to_tid\">";
    echo "<input type=\"hidden\" name=\"t_rpid\" value=\"$reply_to_pid\">";
}
echo "<table><tr><td>";
echo "<table><tr>";
echo "<td align=\"right\">To:</td>";
echo "<td>";
echo post_draw_to_dropdown($t_to_uid);
echo "</td></tr></table>";
echo "<tr><td><textarea name=\"t_content\" cols=\"60\" rows=\"10\" wrap=\"VIRTUAL\">";
if(isset($t_content)){
    if($t_post_html == "Y"){
        echo stripslashes(htmlentities($t_content));
    } else {
        echo stripslashes($t_content);
    }
}
echo "</textarea></td></tr>";
echo "<tr><td><textarea name=\"t_sig\" cols=\"60\" rows=\"4\" wrap=\"VIRTUAL\">$sig_content</textarea>";
echo "<input type=\"hidden\" name=\"t_sig_html\" value=\"$sig_html\"></td></tr>";
echo "<tr><td><input type=\"checkbox\" name=\"t_post_html\" value=\"Y\"";
if($t_post_html == "Y"){
    echo " checked";
}
echo ">&nbsp;Contains HTML</td></tr></table>";
echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
echo "&nbsp;&nbsp;<input name=\"preview\" type=\"submit\" value=\"Preview\">";
echo "</form>";
echo "<p>&nbsp;&nbsp;</p>";
if(!$newthread){
    echo "<p>In reply to:</p>";
    $reply_message = messages_get($reply_to_tid,$reply_to_pid);
    message_display(0,$reply_message[0],0,0,false);
    echo "<p>&nbsp;&nbsp;</p>";
}
html_draw_bottom();
?>