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

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if(bh_session_get_value('UID') == 0) {
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
require_once("./include/config.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/lang.inc.php");

if (isset($HTTP_GET_VARS['msg'])) {

  $edit_msg = $HTTP_GET_VARS['msg'];
  list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

}elseif (isset($HTTP_POST_VARS['t_msg'])) {

  $edit_msg = $HTTP_POST_VARS['t_msg'];
  list($tid, $pid) = explode('.', $HTTP_POST_VARS['t_msg']);

}else {

  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>";
  html_draw_bottom();
  exit;

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

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

html_draw_top_script();

if (isset($HTTP_POST_VARS['preview'])) {

    $to_uid    = $HTTP_POST_VARS['t_to_uid'];
    $from_uid  = $HTTP_POST_VARS['t_from_uid'];

    $edit_msg  = $HTTP_POST_VARS['t_msg'];
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

        $preview_message['CONTENT'].= "<div class=\"sig\">".$t_sig."</div>";

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
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

} elseif (isset($HTTP_POST_VARS['submit']) && is_numeric($tid) && is_numeric($pid)) {
    
    $editmessage = messages_get($tid, $pid, 1);
    if ((!$allow_post_editing || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS)) && $post_edit_time != 0)) && !perm_is_moderator()) {
        edit_refuse($tid, $pid);
        exit;
    }

    if (isset($HTTP_POST_VARS['t_content']) && strlen($HTTP_POST_VARS['t_content']) > 0) {

        $t_content = $HTTP_POST_VARS['t_content'];

        if ($HTTP_POST_VARS['t_post_html'] == "Y") {
            $t_content = fix_html($t_content);
        }else{
            $t_content = make_html($t_content);
        }

        $t_content.= "<div class=\"sig\">".fix_html($HTTP_POST_VARS['t_sig'])."</div>";

        $t_content.= "<p style=\"font-size: 10px\">{$lang['edited_caps']}: ". date("d/m/y H:i T");
        $t_content.= " {$lang['by']} ". user_get_logon(bh_session_get_value('UID'));
        $t_content.= "</p>";

        $updated = post_update($tid, $pid, $t_content);

        if ($updated) {

            if (perm_is_moderator() && ($HTTP_POST_VARS['t_from_uid'] != bh_session_get_value('UID'))) {
                admin_addlog(0, 0, $tid, $pid, 0, 0, 23);
	    }

            echo "<div align=\"center\">";
            echo "<p>{$lang['editappliedtomessage']} $tid.$pid</p>";
            echo form_quick_button("discussion.php", $lang['continue'], "msg", "$tid.$pid");
            echo "</div>";

            html_draw_bottom();
            exit;

        }else{
            $error_html = "<h2>{$lang['errorupdatingpost']}</h2>";
        }
    }else{
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

}else{

    if ($tid && $pid) {

        $editmessage = messages_get($tid, $pid, 1);

        if (count($editmessage) > 0) {

            $editmessage['CONTENT'] = message_get_content($tid, $pid);

            if ((!$allow_post_editing || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS)) && $post_edit_time != 0)) && !perm_is_moderator()) {
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
                $t_content = _htmlentities($t_content);
            }

        }else{
            $valid = false;
            $error_html = "<h2>{$lang['message']} ". $HTTP_GET_VARS['msg']. " {$lang['wasnotfound']}</h2>";
        }
        unset($editmessage);
    }

    $edit_html = isset($HTTP_POST_VARS['b_edit_html']);
}

echo "<h1>{$lang['editmessage']} $tid.$pid</h1>";

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" method=\"post\" target=\"_self\">\n";
echo "<h2>{$lang['subject']}: ". thread_get_title($tid). "</h2>\n";
echo form_input_hidden("t_msg", $edit_msg);
echo form_input_hidden("t_to_uid", $to_uid);
echo form_input_hidden("t_from_uid", $from_uid);
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table width=\"100%\" border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>{$lang['editmessage']}</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>". form_textarea("t_content", $t_content, 15, 85). "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td>{$lang['signature']}:<br />". form_textarea("t_sig", _htmlentities($t_sig), 5, 85). "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', $lang['apply'], 'onclick="if (typeof attachwin == \'object\' && !attachwin.closed) attachwin.close();"');
echo "&nbsp;". form_submit("preview", $lang['preview']);
echo "&nbsp;". form_submit("cancel",  $lang['cancel']);

if ($edit_html) {
    echo "&nbsp;".form_submit("b_edit_text", $lang['edittext']);
    echo form_input_hidden("t_post_html", "Y");

} else {
    echo "&nbsp;".form_submit("b_edit_html", $lang['editHTML']);
    echo form_input_hidden("t_post_html", "N");
}

if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;".form_button("attachments", $lang['attachments'], "onclick=\"attachwin = window.open('edit_attachments.php?aid=". $aid. "&uid=". $from_uid. "', 'edit_attachments', 'width=640, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
}

echo "</form>";

$threaddata = thread_get($tid);

if ($valid) {
    echo "<h2>{$lang['messagepreview']}:</h2>";
    message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);
}

html_draw_bottom();

?>
