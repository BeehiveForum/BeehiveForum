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
require_once("./include/edit.inc.php");

$valid = true;

if(isset($HTTP_GET_VARS['msg'])){
    $edit_msg = $HTTP_GET_VARS['msg'];
    $msg_bits = explode(".",$edit_msg);
} else if(isset($HTTP_POST_VARS['t_msg'])){
    $edit_msg = $HTTP_POST_VARS['t_msg'];
    $msg_bits = explode(".",$edit_msg);
} else {
    $valid = false;
    $error_html = "<h2>No message specified for editing</h2>";
}

if($msg_bits){
    $ema = messages_get($msg_bits[0],$msg_bits[1],1);
    if(count($ema) > 0){
        $edit_message = $ema[0];
        if(!isset($HTTP_POST_VARS['edithtml'])){
            $edit_message['CONTENT'] = strip_tags($edit_message['CONTENT']);
        }
    } else {
        $valid = false;
        $error_html = "<h2>Message " . $HTTP_GET_VARS['msg'] . " was not found</h2>";
    }
    unset($ema);
} else if(isset($HTTP_POST_VARS['submit']) || isset($HTTP_POST_VARS['preview'])){
    if(isset($HTTP_POST_VARS['t_content'])){
        $t_content = $HTTP_POST_VARS['t_content'];
    } else {
        $error_html = "<h2>You must enter some content for the post</h2>";
        $valid = false;
    }
} else {
    $valid = false;
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
    if(isset($HTTP_POST_VARS['submit'])){
        if($t_post_html != "Y"){
            $t_content = make_html($t_content);
        }
        $t_content .= "<p><font size=\"1\">EDITED: " . date("d/m/y H:i");
        $t_content .= " by " . user_get_logon($HTTP_COOKIE_VARS['bh_sess_uid']);
        $updated = post_update($t_tid,$t_pid,$t_content);
        if($updated){
            echo "<p>&nbsp;</p>";
            echo "<p>&nbsp;</p>";
            echo "<div align=\"center\">";
            echo "<p>Post updated successfully</p>";
            echo "<p><a href=\"discussion.php?msg=" . $msg_bits[0]. "." .$msg_bits[1];
            echo "\">Return to messages</a></p>";
            echo "</div>";
            html_draw_bottom();
            exit;
        } else {
            $error_html = "<h2>Error creating post</h2>";
        }
    }

    echo "<h2>Message Preview:</h2>";
    if($edit_message['TO_UID'] == 0){
        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";
    } else {
        $preview_tuser = user_get($edit_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
    }
    $preview_tuser = user_get($edit_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    if($t_post_html != "Y"){
        $preview_message['CONTENT'] = make_html($t_content);
    } else {
        $preview_message['CONTENT'] = $t_content;
    }
    message_display(0,$preview_message,0,0,false);
}

echo "<h2>Edit message</h2>";

if(isset($error_html)){
    echo $error_html;
}
echo "<form name=\"f_edit\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">";
echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>";
echo "<input type=\"hidden\" name=\"t_msg\" value=\"$edit_msg\">";
echo "<table><tr><td>";
echo "<textarea name=\"t_content\" cols=\"60\" rows=\"10\" wrap=\"VIRTUAL\">";
if(isset($t_content)){
    if($t_post_html == "Y"){
        echo stripslashes(htmlentities($t_content));
    } else {
        echo $t_content;
    }
}
echo "</textarea></td></tr></table>";
echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
echo "&nbsp;&nbsp;<input name=\"preview\" type=\"submit\" value=\"Preview\">";
if(isset($HTTP_POST_VARS['b_edit_html'])){
    echo "&nbsp;&nbsp;<input name=\"b_edit_text\" type=\"submit\" value=\"Edit text\">";
    echo "<input type=\"hidden\" name=\"t_post_html\" value=\"Y\">";
} else {
    echo "&nbsp;&nbsp;<input name=\"b_edit_html\" type=\"submit\" value=\"Edit XHTML\">";
    echo "<input type=\"hidden\" name=\"t_post_html\" value=\"N\">";
}
echo "</form>";
echo "<p>&nbsp;&nbsp;</p>";
html_draw_bottom();
?>

