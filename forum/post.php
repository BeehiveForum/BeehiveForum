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
require_once("./include/format.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/email.inc.php");
require_once("./include/form.inc.php");
require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");

if (isset($HTTP_POST_VARS['cancel'])){
    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/discussion.php";
    if(isset($HTTP_POST_VARS['t_rpid'])) $uri.= "?msg=". $HTTP_POST_VARS['t_tid']. ".". $HTTP_POST_VARS['t_rpid'];
    header_redirect($uri);      
}

$valid = true;
$t_post_html = $HTTP_POST_VARS['t_post_html'];

if(substr($HTTP_POST_VARS['t_to_uid'], 0, 2) == "U:"){
	$u_login = substr($HTTP_POST_VARS['t_to_uid'], 2);
	$db = db_connect();
	$sql = "select UID from ". forum_table("USER"). " where LOGON = '" . $u_login. "'";
	$result = db_query($sql,$db);
	if(db_num_rows($result)>0){ 
		 $touser = db_fetch_array($result); 
		 $HTTP_POST_VARS['t_to_uid'] = $touser['UID']; 
		 $t_to_uid = $touser['UID'];
	} else {
		$error_html = "<h2>Invalid username</h2>";
		$valid = false;
	}
	db_disconnect($db);
}


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

    $t_sig = (isset($HTTP_POST_VARS['t_sig'])) ? $HTTP_POST_VARS['t_sig'] : "";
    $t_sig_html = (isset($HTTP_POST_VARS['t_sig_html'])) ? $HTTP_POST_VARS['t_sig_html'] : "";

} else {

    if(isset($HTTP_POST_VARS['t_tid'])){
        if(isset($HTTP_POST_VARS['t_content']) && strlen($HTTP_POST_VARS['t_content']) > 0){
            $t_content = $HTTP_POST_VARS['t_content'];
        } else {
            $error_html = "<h2>You must enter some content for the post</h2>";
            $valid = false;
        }

        $t_sig = (isset($HTTP_POST_VARS['t_sig'])) ? $HTTP_POST_VARS['t_sig'] : "";
        $t_sig_html = (isset($HTTP_POST_VARS['t_sig_html'])) ? $HTTP_POST_VARS['t_sig_html'] : "N";
    } else {
        $valid = false;
    }
}

if($valid){
    if($t_post_html == "Y"){
        $t_content = fix_html($t_content);
    }
	if(isset($t_sig)){
		if($t_sig_html == "Y"){
			$t_sig = fix_html($t_sig);
		}
	}
}

if($valid && isset($HTTP_POST_VARS['submit'])){

    //Dedupe
    $db = db_connect();
    $sql = "select DDKEY from ".forum_table("DEDUPE")." where UID = ".$HTTP_COOKIE_VARS['bh_sess_uid'];
    $result = db_query($sql,$db);
    if(db_num_rows($result)>0){
        db_query($sql,$db);
        list($ddkey) = db_fetch_array($result);
        $sql = "update ".forum_table("DEDUPE")." set DDKEY = \"".$HTTP_POST_VARS['t_dedupe']."\" where UID = ".$HTTP_COOKIE_VARS['bh_sess_uid'];
    } else {
        $sql = "insert into ".forum_table("DEDUPE")." (UID,DDKEY) values (".$HTTP_COOKIE_VARS['bh_sess_uid'].",\"".$HTTP_POST_VARS['t_dedupe']."\")";
    }
    db_query($sql,$db);
    db_disconnect($db);

    if($ddkey != $HTTP_POST_VARS['t_dedupe']){
        if($newthread){
            $t_tid = post_create_thread($t_fid, $t_threadtitle);
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

            $new_pid = post_create($t_tid, $t_rpid, $HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_POST_VARS['t_to_uid'], $t_content);
            
            if ($HTTP_COOKIE_VARS['bh_sess_markread']) thread_set_interest($t_tid, 1, $newthread);
            
            email_sendnotification($HTTP_POST_VARS['t_to_uid'], "$t_tid.$new_pid", $HTTP_COOKIE_VARS['bh_sess_uid']);
            email_sendsubscription($HTTP_POST_VARS['t_to_uid'], "$t_tid.$new_pid", $HTTP_COOKIE_VARS['bh_sess_uid']);
        }
    } else {
        $new_pid = 0;
        if($newthread){
            $t_rpid = 0;
        } else {
            $t_tid = $HTTP_POST_VARS['t_tid'];
            $t_rpid = $HTTP_POST_VARS['t_rpid'];
        }
    }

    if($new_pid > -1){

        html_draw_top();
    
        post_save_attachment_id($t_tid, $new_pid, $aid);
        
        echo "<p>&nbsp;</p>";
        echo "<p>&nbsp;</p>";
        echo "<div align=\"center\"><p>\n";
        echo "Message posted successfully\n";
        
        if ($newthread) {
          echo "<br /><a href=\"discussion.php?msg=$t_tid.1\">Return to messages</a>\n";
        }else{
          echo "<br /><a href=\"discussion.php?msg=$t_tid.$t_rpid\">Return to messages</a>\n";
        }
        
        echo "</p></div>\n";
        html_draw_bottom();


//        $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
//        $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
//        $uri.= "/discussion.php";
//        if($t_rpid) $uri.= "?msg=$t_tid.$t_rpid";
//        header_redirect($uri);

        exit;

    } else {
        $error_html = "<h2>Error creating post</h2>";
    }
}

html_draw_top_script();

if (!isset($HTTP_POST_VARS['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $HTTP_POST_VARS['aid'];
}

$t_sig = stripslashes($t_sig);

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
                $preview_sig = make_html($t_sig);
            } else {
				$preview_sig = $t_sig;
			}
            $preview_message['CONTENT'] = $preview_message['CONTENT'] . "<div class=\"sig\">$preview_sig</div>";
        } else {
			$t_sig = " ";
		}
		$preview_message['CONTENT'] = stripslashes($preview_message['CONTENT']);
        message_display(0,$preview_message,0,0,false,false,false);
        echo "<br />\n";
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
    if(!isset($HTTP_POST_VARS['t_to_uid'])){
        $t_to_uid = message_get_user($reply_to_tid,$reply_to_pid);
    }
}

if(!$t_sig){
    $has_sig = user_get_sig($HTTP_COOKIE_VARS['bh_sess_uid'],$t_sig,$t_sig_html);
} else {
    $has_sig = true;
}

if($newthread){
    echo "<h1>Create new thread</h1>\n";
} else {
    echo "<h1>Post reply</h1>\n";
}
if(isset($error_html)){
    echo $error_html . "\n";
}

echo "<script language=\"Javascript\">\n";
echo "function launchOthers() {\n";
echo "newUser = prompt(\"Please enter a MemberName.\",document.f_post.t_to_uid.options[document.f_post.t_to_uid.selectedIndex].text);\n";
echo "if (newUser != null) {\n";
echo "if (newUser != document.f_post.t_to_uid.options[document.f_post.t_to_uid.selectedIndex].text) {\n";
echo "document.f_post.t_to_uid.options[document.f_post.t_to_uid.selectedIndex].value = \"U:\" + newUser;\n";
echo "document.f_post.t_to_uid.options[document.f_post.t_to_uid.selectedIndex].text = newUser;\n";
echo "}\n}\n}\n";
echo "</script>\n";

echo "<form name=\"f_post\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">\n";
if($newthread){
    echo "<table>\n";
    echo "<tr><td>Select folder:</td></tr>\n";
    echo "<tr><td>" . folder_draw_dropdown($t_fid) . "</td></tr>\n";
    echo "<tr><td>Thread title:</td></tr>\n";
    echo "<tr><td>".form_input_text("t_threadtitle",stripslashes(htmlentities($t_threadtitle)),30,64);
    echo "\n";
    echo form_input_hidden("t_newthread","Y")."</td></tr>\n";
    echo "</table>\n";
} else {
    echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>\n";
    echo form_input_hidden("t_tid",$reply_to_tid);
    echo form_input_hidden("t_rpid",$reply_to_pid)."</td></tr>\n";
}
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>";
echo "<table class=\"posthead\" border=\"0\" width=\"100%\"><tr>\n";
echo "<td>To: \n";

echo post_draw_to_dropdown($t_to_uid). "&nbsp;";
//echo form_quick_button("javascript:t_tlogin = prompt('Please enter a membername:', '');", "Others");
echo  "<input class=\"button\" id=\"t_others\" onClick=\"javascript:launchOthers()\" type=\"button\" value=\"Others\" name=\"others\">\n";

echo "</td></tr></table>\n";
echo "<table border=\"0\" class=\"posthead\">\n";
if(isset($t_content)){
    if($t_post_html == "Y"){
        $t_content = stripslashes(htmlentities($t_content));
    } else {
        $t_content = stripslashes(htmlspecialchars($t_content));
    }
}
echo "<tr><td>".form_textarea("t_content",$t_content,12,80)."</tr></td>";
echo "<tr><td>Signature:<br />".form_textarea("t_sig",htmlspecialchars($t_sig),4,80);
echo form_input_hidden("t_sig_html",$t_sig_html)."</td></tr>\n";
echo "<tr><td>".form_checkbox("t_post_html","Y","Contains HTML (not including signature)",($t_post_html == "Y"))."</td></tr>\n";
echo "</table>\n";
echo "</td></tr></table>\n";
echo form_submit("submit","Submit");
echo "&nbsp;".form_submit("preview","Preview");
echo "&nbsp;".form_submit("cancel", "Cancel");
echo "&nbsp;".form_button("attachments", "Attachments", "onclick=\"window.open('attachments.php?aid=". $aid. "', 'attachments', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
echo form_input_hidden("aid", $aid);
if(isset($HTTP_POST_VARS['t_dedupe'])){
    echo form_input_hidden("t_dedupe",$HTTP_POST_VARS['t_dedupe']);
} else {
    echo form_input_hidden("t_dedupe",date("YmdHis"));
}
echo "</form>\n";
if(!$newthread){
    echo "<p>In reply to:</p>\n";
    $reply_message = messages_get($reply_to_tid,$reply_to_pid);
    message_display(0,$reply_message[0],0,0,false,false,false);
    echo "<p>&nbsp;&nbsp;</p>\n";
}
html_draw_bottom();
?>