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

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
    html_guest_error();
    exit;
}

require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/format.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/edit.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/attachments.inc.php");

if (isset($HTTP_GET_VARS['msg'])) {

  $edit_msg = $HTTP_GET_VARS['msg'];
  list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

}elseif (isset($HTTP_POST_VARS['t_msg'])) {

  $edit_msg = $HTTP_POST_VARS['t_msg'];
  list($tid, $pid) = explode('.', $HTTP_POST_VARS['t_msg']);

}else {

  $valid = false;
  $error_html = "<h2>No message specified for editing</h2>";

}

if (thread_is_poll($tid) && $pid == 1) {
    html_poll_edit_error();
    exit;
}

if (isset($HTTP_POST_VARS['cancel'])) {

    $uri = "./discussion.php";

    if (isset($HTTP_GET_VARS['msg'])) {
        $uri.= "?msg=". $HTTP_GET_VARS['msg'];
    }elseif (isset($HTTP_POST_VARS['t_msg'])) {
        $uri.= "?msg=". $HTTP_POST_VARS['t_msg'];
    }

    header_redirect($uri);
}

$valid = true;

html_draw_top_script();

if (isset($HTTP_POST_VARS['preview'])) {

    $to_uid = $HTTP_POST_VARS['t_to_uid'];
    $from_uid = $HTTP_POST_VARS['t_from_uid'];

    $edit_msg = $HTTP_POST_VARS['t_msg'];
    $edit_html = ($HTTP_POST_VARS['t_post_html'] == "Y");

    $preview_message = messages_get($tid, $pid, 1);

    if (isset($HTTP_POST_VARS['t_content']) && strlen($HTTP_POST_VARS['t_content']) > 0) {

        $t_content = $HTTP_POST_VARS['t_content'];

        if ($HTTP_POST_VARS['t_post_html'] == "Y") {
            $t_content = fix_html($t_content);
            $preview_message['CONTENT'] = $t_content;
            $t_content = str_replace("&", "&amp;", $t_content);
        }else{
            $t_content = make_html($t_content);
            $preview_message['CONTENT'] = $t_content;
            $t_content = strip_tags($t_content);
            $t_content = ereg_replace("\n+", "\n", $t_content);
        }

        $t_sig = fix_html($HTTP_POST_VARS['t_sig']);

        $preview_message['CONTENT'] .= "<div class=\"sig\">".$t_sig."</div>";

        if ($to_uid == 0) {

            $preview_message['TLOGON'] = "ALL";
            $preview_message['TNICK'] = "ALL";

        }else{

            $preview_tuser = user_get($HTTP_POST_VARS['t_to_uid']);
            $preview_message['TLOGON'] = $preview_tuser['LOGON'];
            $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
            $preview_message['TO_UID'] = $preview_tuser['UID'];

        }

        $preview_tuser = user_get($from_uid);
        $preview_message['FLOGON'] = $preview_tuser['LOGON'];
        $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['FROM_UID'] = $from_uid;

    }else{
        $error_html = "<h2>You must enter some content for the post</h2>";
        $valid = false;
    }

} elseif (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['t_content']) && strlen($HTTP_POST_VARS['t_content']) > 0) {

        $t_content = $HTTP_POST_VARS['t_content'];

        if ($HTTP_POST_VARS['t_post_html'] == "Y") {
            $t_content = fix_html($t_content);
        }else{
            $t_content = make_html($t_content);
        }

        $t_content.= "<div class=\"sig\">".fix_html($HTTP_POST_VARS['t_sig'])."</div>";

        $t_content.= "<p><font size=\"1\">EDITED: ". date("d/m/y H:i T");
        $t_content.= " by ". user_get_logon($HTTP_COOKIE_VARS['bh_sess_uid']);
        $t_content.= "</font></p>";

        $updated = post_update($tid, $pid, $t_content);

        if ($updated) {
            echo "<div align=\"center\">";
            echo "<p>Edit Applied to Message $tid.$pid</p>";
            echo form_quick_button("discussion.php", "Continue", "msg", "$tid.$pid");
            echo "</div>";

            html_draw_bottom();
            exit;

        }else{
            $error_html = "<h2>Error updating post</h2>";
        }
    }else{
        $error_html = "<h2>You must enter some content for the post</h2>";
        $valid = false;
    }

}else{

    if ($tid && $pid) {

        $editmessage = messages_get($tid, $pid, 1);

        if (count($editmessage) > 0) {

            $editmessage['CONTENT'] = message_get_content($tid, $pid);

            if ($HTTP_COOKIE_VARS['bh_sess_uid'] != $editmessage['FROM_UID'] && !perm_is_moderator()) {
                edit_refuse($tid, $pid);
                exit;
            }

            $preview_message = $editmessage;

            $to_uid = $editmessage['TO_UID'];
            $from_uid = $editmessage['FROM_UID'];

            $t_content_temp = $editmessage['CONTENT'];
            $t_content_temp = preg_split("/<div class=\"sig\">/", $t_content_temp);

            if(count($t_content_temp)>1){
                $t_sig_temp = array_pop($t_content_temp);
                $t_sig_temp = preg_split("/<\/div>/", $t_sig_temp);

                $t_sig = "";
                for($i=0;$i<count($t_sig_temp)-1;$i++){
                    $t_sig .= $t_sig_temp[$i];
                    if($i<count($t_sig_temp)-2){
                        $t_sig .= "</div>";
                    }
                }

            } else {
                $t_sig = "";
            }
            $t_content = "";

            for($i=0;$i<count($t_content_temp);$i++){
                $t_content .= $t_content_temp[$i];
                if($i<count($t_content_temp)-1){
                    $t_content .= "<div class=\"sig\">";
                }
            }

            $preview_message['CONTENT'] = $t_content."<div class=\"sig\">".$t_sig."</div>";

            if (!isset($HTTP_POST_VARS['b_edit_html'])) {
                $t_content = str_replace("\n", "", $t_content);
                $t_content = str_replace("\r", "", $t_content);
                $t_content = str_replace("<p>", "\n\n<p>", $t_content);
                $t_content = str_replace("</p>", "</p>\n", $t_content);
                $t_content = ereg_replace("^\n\n<p>", "<p>", $t_content);
                $t_content = ereg_replace("<br[[:space:]*]/>", "\n", $t_content);
                $t_content = strip_tags($t_content);
            }else{
                $t_content = htmlentities($t_content);
            }

        }else{
            $valid = false;
            $error_html = "<h2>Message ". $HTTP_GET_VARS['msg']. " was not found</h2>";
        }
        unset($editmessage);
    }

    $edit_html = isset($HTTP_POST_VARS['b_edit_html']);
}

echo "<h1>Edit message $tid.$pid</h1>";

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" method=\"POST\" target=\"_self\">\n";
echo "<h2>Subject: ". thread_get_title($tid). "</h2>\n";
echo form_input_hidden("t_msg", $edit_msg);
echo form_input_hidden("t_to_uid", $to_uid);
echo form_input_hidden("t_from_uid", $from_uid);
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table width=\"100%\" border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>Edit message</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>". form_textarea("t_content", $t_content, 15, 85). "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td>Signature:<br />". form_textarea("t_sig", htmlspecialchars($t_sig), 5, 85). "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', 'Apply', 'onclick="if (typeof attachwin == \'object\' && !attachwin.closed) attachwin.close();"');
echo "&nbsp;". form_submit("preview", "Preview");
echo "&nbsp;". form_submit("cancel",  "Cancel");

if ($edit_html) {
    echo "&nbsp;".form_submit("b_edit_text", "Edit text");
    echo form_input_hidden("t_post_html", "Y");

} else {
    echo "&nbsp;".form_submit("b_edit_html", "Edit HTML");
    echo form_input_hidden("t_post_html", "N");
}

if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;".form_button("attachments", "Attachments", "onclick=\"attachwin = window.open('edit_attachments.php?aid=". $aid. "&uid=". $from_uid. "', 'edit_attachments', 'width=640, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
}

echo "</form>";

$threaddata = thread_get($tid);

if ($valid) {
    echo "<h2>Message Preview:</h2>";
    message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, true, false, false, false, true, true);
}

html_draw_bottom();

?>
