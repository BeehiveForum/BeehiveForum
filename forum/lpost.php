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

/* $Id: lpost.php,v 1.25 2004-03-07 18:05:46 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status

require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check() || bh_session_get_value('UID') == 0){

    $uri = "./llogon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
        light_html_guest_error();
        exit;
}

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
require_once("./include/config.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/light.inc.php");
require_once("./include/lang.inc.php");

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
    exit;
}

if (isset($HTTP_POST_VARS['cancel'])) {

    $uri = "./lthread_list.php";
    
    if (isset($HTTP_POST_VARS['t_tid']) && isset($HTTP_POST_VARS['t_rpid'])) {
        $uri.= "?msg={$HTTP_POST_VARS['t_tid']}.{$HTTP_POST_VARS['t_rpid']}";
    }elseif (isset($HTTP_GET_VARS['replyto'])) {
        $uri.= "?msg={$HTTP_GET_VARS['replyto']}";
    }
    
    header_redirect($uri);

}

$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

$newthread = false;

if (isset($HTTP_POST_VARS['t_post_html'])) {
    $t_post_html = $HTTP_POST_VARS['t_post_html'];
}

if (isset($HTTP_POST_VARS['t_to_uid']) && substr($HTTP_POST_VARS['t_to_uid'], 0, 2) == "U:") {

  $u_login = substr($HTTP_POST_VARS['t_to_uid'], 2);

  if ($touser = user_get($u_login)) {

    $HTTP_POST_VARS['t_to_uid'] = $touser['UID'];
    $t_to_uid = $touser['UID'];

  }else {

    $error_html = "<h2>{$lang['invalidusername']}</h2>";
    $valid = false;

  }

}

if (isset($HTTP_POST_VARS['t_newthread'])) {

    $newthread = true;

    if (isset($HTTP_POST_VARS['t_threadtitle']) && trim($HTTP_POST_VARS['t_threadtitle']) != "") {
        $t_threadtitle = trim($HTTP_POST_VARS['t_threadtitle']);
    }else {
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['t_fid'])) {
        if (folder_thread_type_allowed($HTTP_POST_VARS['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {
            $t_fid = $HTTP_POST_VARS['t_fid'];
        } else {
            $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
            $valid = false;
        }
    } else if ($valid) {
        $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['t_content'])) {
        $t_content = $HTTP_POST_VARS['t_content'];
    }else {
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

    $t_sig = (isset($HTTP_POST_VARS['t_sig'])) ? $HTTP_POST_VARS['t_sig'] : "";
    $t_sig_html = (isset($HTTP_POST_VARS['t_sig_html'])) ? $HTTP_POST_VARS['t_sig_html'] : "";

}else {

    if (isset($HTTP_POST_VARS['t_tid'])) {

        if (isset($HTTP_POST_VARS['t_content']) && strlen($HTTP_POST_VARS['t_content']) > 0) {
            $t_content = $HTTP_POST_VARS['t_content'];
        }else {
            $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
            $valid = false;
        }

        $t_sig = (isset($HTTP_POST_VARS['t_sig'])) ? $HTTP_POST_VARS['t_sig'] : "";
        $t_sig_html = (isset($HTTP_POST_VARS['t_sig_html'])) ? $HTTP_POST_VARS['t_sig_html'] : "N";

    }else {

        $valid = false;

    }
}

if ($valid) {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = fix_html($t_content);
    }

    if (isset($t_sig)) {
        if ($t_sig_html == "Y") {
          $t_sig = fix_html($t_sig);
        }
    }

}else {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = _stripslashes($t_content);
    }

    if (isset($t_sig)) {
        if ($t_sig_html == "Y") {
            $t_sig = _stripslashes($t_sig);
        }
    }
}

if ($valid && isset($HTTP_POST_VARS['submit'])) {

    if (check_ddkey($HTTP_POST_VARS['t_dedupe'])) {

        if ($newthread) {

            $t_tid = post_create_thread($t_fid, $t_threadtitle);
            $t_rpid = 0;

        }else {

            $t_tid = $HTTP_POST_VARS['t_tid'];
            $t_rpid = $HTTP_POST_VARS['t_rpid'];

        }

        if ($t_tid > 0) {

            if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
                $t_content = make_html($t_content);
            }

            if ($t_sig) {

                if ($t_sig_html != "Y") $t_sig = make_html($t_sig);
                $t_content = _stripslashes($t_content. "\n<div class=\"sig\">". $t_sig. "</div>");

            }

            $new_pid = post_create($t_tid, $t_rpid, bh_session_get_value('UID'), $HTTP_POST_VARS['t_to_uid'], $t_content);

            if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_interest($t_tid, 1, $newthread);

            email_sendnotification($HTTP_POST_VARS['t_to_uid'], "$t_tid.$new_pid", bh_session_get_value('UID'));
            email_sendsubscription($HTTP_POST_VARS['t_to_uid'], "$t_tid.$new_pid", bh_session_get_value('UID'));
        }

    }else {

        $new_pid = 0;

        if ($newthread) {

            $t_tid = 0;
            $t_rpid = 0;

        }else {

            $t_tid = $HTTP_POST_VARS['t_tid'];
            $t_rpid = $HTTP_POST_VARS['t_rpid'];

        }
    }

    if ($new_pid > -1) {

        if ($t_tid > 0 && $t_rpid > 0) {

          $uri = "./lmessages.php?msg=$t_tid.$t_rpid";

        }else {

          $uri = "./lmessages.php";

        }

        header_redirect($uri);
        exit;

    }else {

        $error_html = "<h2>{$lang['errorcreatingpost']}</h2>";

    }

}

light_html_draw_top();

if (!isset($HTTP_POST_VARS['aid'])) {
  $aid = md5(uniqid(rand()));
}else {
  $aid = $HTTP_POST_VARS['aid'];
}

if ($valid && isset($HTTP_POST_VARS['preview'])) {

    echo "<h2>{$lang['messagepreview']}:</h2>";

    if ($HTTP_POST_VARS['t_to_uid'] == 0) {

      $preview_message['TLOGON'] = "ALL";
      $preview_message['TNICK'] = "ALL";

    }else {

      $preview_tuser = user_get($HTTP_POST_VARS['t_to_uid']);
      $preview_message['TLOGON'] = $preview_tuser['LOGON'];
      $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
      $preview_message['TO_UID'] = $preview_tuser['UID'];

    }

    $preview_tuser = user_get(bh_session_get_value('UID'));
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {

      $preview_message['CONTENT'] = make_html($t_content);

    }else {

      $preview_message['CONTENT'] = $t_content;

    }

    if ($t_sig) {

      if ($t_sig_html != "Y") {

        $preview_sig = make_html($t_sig);

      }else {

        $preview_sig = $t_sig;

      }

      $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $preview_sig. "</div>";

    }else {

      $t_sig = " ";

    }

    light_message_display(0, $preview_message, 0, 0, false, false, false);
    echo "<br />\n";

}

if ($valid && isset($HTTP_POST_VARS['convert_html'])) {

   $t_content = nl2br(_htmlentities(_stripslashes($t_content)));
   $t_post_html = "Y";

}

if (isset($HTTP_GET_VARS['replyto']) && validate_msg($HTTP_GET_VARS['replyto'])) {

    $replyto = $HTTP_GET_VARS['replyto'];
    list($reply_to_tid, $reply_to_pid) = explode(".", $replyto);
    $newthread = false;

}elseif (isset($HTTP_POST_VARS['t_tid'])) {

    $reply_to_tid = $HTTP_POST_VARS['t_tid'];
    $reply_to_pid = $HTTP_POST_VARS['t_rpid'];
    $newthread = false;

}else {

    $newthread = true;

    if (isset($HTTP_GET_VARS['fid']) && is_numeric($HTTP_GET_VARS['fid'])) {

        $t_fid = $HTTP_GET_VARS['fid'];

    }elseif (isset($HTTP_POST_VARS['t_fid']) && is_numeric($HTTP_POST_VARS['t_fid'])) {

        $t_fid = $HTTP_POST_VARS['t_fid'];

    }else {

        $t_fid = 1;
    }
}

if (!$newthread) {

    if (!isset($HTTP_POST_VARS['t_to_uid'])) {
        $t_to_uid = message_get_user($reply_to_tid,$reply_to_pid);
    }

}

if (!isset($t_sig) || !$t_sig) {
    $has_sig = user_get_sig(bh_session_get_value('UID'),$t_sig,$t_sig_html);
}else {
    $has_sig = true;
}

if ($newthread) {
    echo "<h1>{$lang['createnewthread']}</h1>\n";
}else {
    echo "<h1>{$lang['postreply']}</h1>\n";
}
if (isset($error_html)) {
    echo $error_html . "\n";
}

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"POST\">\n";

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

if ($newthread) {

    echo "<p>{$lang['selectfolder']}: ";
    echo folder_draw_dropdown($t_fid,"t_fid","",FOLDER_ALLOW_NORMAL_THREAD) . "</p>\n";
    echo "<p>{$lang['threadtitle']}: ";
    echo light_form_input_text("t_threadtitle", _htmlentities(_stripslashes($t_threadtitle)), 30, 64);
    echo "</p>\n";
    echo form_input_hidden("t_newthread","Y");

}else {

    $reply_message = messages_get($reply_to_tid, $reply_to_pid);
    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);
    $threaddata = thread_get($reply_to_tid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $threaddata['POLL_FLAG'] != 'Y') {

      echo "<h2>{$lang['messagehasbeendeleted']}</h2>\n";
      html_draw_bottom();
      exit;

    }else {

      echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>\n";
      echo form_input_hidden("t_tid",$reply_to_tid);
      echo form_input_hidden("t_rpid",$reply_to_pid)."</td></tr>\n";

    }

}

if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
    $t_content = isset($t_content) ? _stripslashes($t_content) : "";
}

if (!isset($t_to_uid)) $t_to_uid = -1;

echo "<p>{$lang['to']}: ". post_draw_to_dropdown($t_to_uid) . form_submit("submit",$lang['post']) ."</p>\n";
echo "<p>".light_form_textarea("t_content", isset($t_content) ? _htmlentities($t_content) : "", 15, 85). "</p>\n";

echo "<p>{$lang['signature']}:<br />".light_form_textarea("t_sig", _htmlentities($t_sig), 5, 85). form_input_hidden("t_sig_html", $t_sig_html)."</p>\n";
echo "<p>".light_form_checkbox("t_post_html", "Y", "{$lang['messagecontainsHTML']} {$lang['notincludingsignature']}", (isset($t_post_html) && $t_post_html == "Y"))."</p>\n";
echo "<p>".light_form_submit("submit",$lang['post']);
echo "&nbsp;".light_form_submit("preview",$lang['preview']);
echo "&nbsp;".light_form_submit("cancel", $lang['cancel']);
echo "</p>";

echo "&nbsp;".light_form_submit("convert_html", $lang['converttoHTML']);

if (isset($HTTP_POST_VARS['t_dedupe'])) {
    echo form_input_hidden("t_dedupe",$HTTP_POST_VARS['t_dedupe']);
}else {
    echo form_input_hidden("t_dedupe",date("YmdHis"));
}

echo "</form>\n";

if (!$newthread) {

    echo "<p>{$lang['inreplyto']}:</p>\n";

    if (($threaddata['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

      light_poll_display($reply_to_tid, $threaddata['LENGTH'], $reply_to_pid, false, false, false, true, $show_sigs, true);

    }else {

      light_message_display($reply_to_tid, $reply_message, $threaddata['LENGTH'], $reply_to_pid, true, false, false, false, $show_sigs, true);

    }

}

light_html_draw_bottom();

?>