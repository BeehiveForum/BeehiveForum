<?php
require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/format.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/messages.inc.php");

if(!isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
    html_draw_top();
    echo "You must be logged in to post.";
    echo "<a href=\"logon.php\" target=\"_self\">Log on...</a>";
    html_draw_bottom();
    exit;
} else {
    $sess_uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
}

$valid = true;

if(isset($HTTP_POST_VARS['t_newthread'])){
    $newthread = true;
    if(isset($HTTP_POST_VARS['t_threadtitle'])){
        $t_threadtitle = $HTTP_POST_VARS['t_threadtitle'];
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

html_draw_top();

echo "<table border=\"1\">";
foreach ($HTTP_POST_VARS as $var => $value) {
    echo "<tr><td>$var</td><td>$value</td></tr>";
}
echo "</table>";

if($valid){
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
                $t_sig = make_html($t_content);
            }
            $t_content .= $t_sig;
        }
        $new_pid = post_create($t_tid,$t_rpid,$sess_uid,$HTTP_POST_VARS['t_to_uid'],$t_content);
        if($new_pid > -1){
            echo "<p>Post created successfully</p>";
            echo "<p><a href=\"messages.php?msg=$t_tid.$t_rpid\">Return to messages</a></p>";
            html_draw_bottom();
            exit;
        } else {
            $error_html = "<h2>Error creating post</h2>";
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
$has_sig = user_get_sig($sess_uid,$sig_content,$sig_html);
if($newthread){
    echo "<h1>Create new thread</h1>";
} else {
    echo "<h1>Post reply</h1>";
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
    echo "<tr><td><input type=\"text\" name=\"t_threadtitle\" maxchars=\"64\" width=\"64\">";
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
echo "<tr><td><textarea name=\"t_content\" cols=\"40\" rows=\"10\" wrap=\"VIRTUAL\"></textarea></td></tr>";
echo "<tr><td><textarea name=\"t_sig\" cols=\"40\" rows=\"4\" wrap=\"VIRTUAL\">$sig_content</textarea>";
echo "<input type=\"hidden\" name=\"t_sig_html\" value=\"$sig_html\"></td></tr>";
echo "<tr><td><input type=\"checkbox\" name=\"t_post_html\" value=\"Y\">&nbsp;Contains HTML</td></tr></table>";
echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
echo "</form>";

html_draw_bottom();
?>

