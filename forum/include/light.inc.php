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

/* $Id: light.inc.php,v 1.57 2004-10-27 16:43:17 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/word_filter.inc.php");

function light_html_draw_top ($title = false)
{
    $lang = load_language_file();

    if (!isset($title) || !$title) {
        $title = forum_get_setting('forum_name');
    }

    echo "<?xml version=\"1.0\" encoding=\"{$lang['_charset']}\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={lang['_charset']}\"/>\n";

    $stylesheet = html_get_style_sheet();
    echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" />\n";

    echo "</head>\n";
    echo "<body>\n";
}

function light_html_draw_bottom ()
{
    echo "</body>\n";
    echo "</html>\n";
}

// create a <select> dropdown with values from array(s)
function light_form_dropdown_array($name, $value, $label, $default = "")
{
    $html = "<select name=\"$name\">";

    for($i=0;$i<count($value);$i++){
        $sel = ($value[$i] == $default) ? " selected" : "";
        if($label[$i]){
            $html.= "<option value=\"".$value[$i]."\"$sel>".$label[$i]."</option>";
        } else {
            $html.= "<option$sel>".$value[$i]."</option>";
        }
    }
    return $html."</select>";
}

// create a <input type="submit"> button
function light_form_submit($name = "submit", $value = "Submit")
{
    return "<input type=\"submit\" name=\"$name\" value=\"$value\" />";
}

function light_poll_confirm_close($tid)
{
    $lang = load_language_file();

    if (!is_numeric($tid)) return;

    if (!$t_fid = thread_get_folder($tid, 1)) {
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        return;
    }

    if(bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator($t_fid)) {
        edit_refuse($tid, 1);
        return;
    }

    $preview_message = messages_get($tid, 1, 1);

    if($preview_message['TO_UID'] == 0) {

        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";

    }else {

        $preview_tuser = user_get($preview_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];

    }

    $preview_fuser = user_get($preview_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_fuser['LOGON'];
    $preview_message['FNICK'] = $preview_fuser['NICKNAME'];

    echo "<h2>{$lang['pollconfirmclose']}</h2>\n";

    light_poll_display($tid, $preview_message, 0, 0, false);

    echo "<p><form name=\"f_delete\" action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo light_form_submit("pollclose", $lang['endpoll']);
    echo "&nbsp;".light_form_submit("cancel", $lang['cancel']);
    echo "</form>\n";

}

function light_messages_top($foldertitle, $threadtitle, $interest_level = 0, $sticky = "N", $closed = false, $locked = false)
{
    $lang = load_language_file();

    echo "<h2>$foldertitle: $threadtitle";

    if ($closed) echo "&nbsp;<font color=\"#FF0000\">({$lang['closed']})</font>\n";
    if ($interest_level == 1) echo "&nbsp;<font color=\"#FF0000\">({$lang['highinterest']})</font>";
    if ($interest_level == 2) echo "&nbsp;<font color=\"#FF0000\">({$lang['subscribed']})</font>";
    if ($sticky == "Y") echo "&nbsp;({$lang['sticky']})";
    if ($locked) echo "&nbsp;<font color=\"#FF0000\">({$lang['locked']})</font>";

    echo "</h2>";
}

function light_form_radio($name, $value, $text, $checked = false)
{
    $html = "<input type=\"radio\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text</span>";
}

function light_poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{
    $webtag = get_webtag($webtag_search);

    $lang = load_language_file();

    $uid = bh_session_get_value('UID');

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes       = 0;
    $poll_group_count = 1;

    $polldata['CONTENT'] = "<form method=\"post\" action=\"". $_SERVER['PHP_SELF']. "\" target=\"_self\">\n";
    $polldata['CONTENT'].= form_input_hidden('webtag', $webtag). "\n";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "<h2>". thread_get_title($tid). "</h2>\n";

    if ($in_list) {

      if ((!is_array($userpolldata) && bh_session_get_value('UID') > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > gmmktime())) {

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

          if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

          if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldata['CONTENT'].= "<hr />\n";
                $poll_group_count++;
            }

            $polldata['CONTENT'].= light_form_radio("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "&nbsp;". $pollresults['OPTION_NAME'][$i]. "<br />\n";
            $poll_previous_group = $pollresults['GROUP_ID'][$i];

          }

        }

      }else {

        if ($polldata['SHOWRESULTS'] == 1) {

          for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

              if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                  $polldata['CONTENT'].= "<hr />\n";
                  $poll_group_count++;
              }

              $polldata['CONTENT'] .= $pollresults['OPTION_NAME'][$i] . ": " . $pollresults['VOTES'][$i] . " votes <br />\n";
              $poll_previous_group = $pollresults['GROUP_ID'][$i];
            }

          }

        }else {

          for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

              if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                  $polldata['CONTENT'].= "<hr />\n";
                  $poll_group_count++;
              }

              $polldata['CONTENT'].= $pollresults['OPTION_NAME'][$i]. "<br />\n";
              $poll_previous_group = $pollresults['GROUP_ID'][$i];
            }

          }

        }

      }

    }else {

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (!empty($pollresults['OPTION_NAME'][$i])) {

          if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
              $polldata['CONTENT'].= "<hr />\n";
              $poll_group_count++;
          }

          $polldata['CONTENT'].= $pollresults['OPTION_NAME'][$i]. "<br />\n";
          $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

      }

    }

    if ($in_list) {

      $group_array = array();

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!in_array($pollresults['GROUP_ID'][$i], $group_array)) {
            $group_array[] = $pollresults['GROUP_ID'][$i];
        }
      }

      $poll_group_count = sizeof($group_array);
      $totalvotes = poll_get_total_votes($tid);

      $polldata['CONTENT'] .= "<p>";

      if ($totalvotes == 0 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyvoted']}</b>";

      }elseif ($totalvotes == 0 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyhasvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personhasvoted']}</b>";

      }else {

        if ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) {

          $polldata['CONTENT'].= "<b>". $totalvotes. " {$lang['peoplevoted']}</b>";

        }else {

          $polldata['CONTENT'].= "<b>". $totalvotes. " {$lang['peoplehavevoted']}</b>";

        }

      }

      $polldata['CONTENT'].= "</p>\n";

      if (($polldata['CLOSES'] <= gmmktime()) && $polldata['CLOSES'] != 0) {

        $polldata['CONTENT'].= "<p>{$lang['pollhasended']}</p>\n";

        if (is_array($userpolldata)) {

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "<p>{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].= " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). "</p>\n";

        }

      }else {

        if (is_array($userpolldata)) {

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "<p>{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].= " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). "</p>\n";

        }elseif (bh_session_get_value('UID') > 0) {

          $polldata['CONTENT'].= "<p>". light_form_submit('pollsubmit', $lang['vote']). "</p>\n";

        }

      }

    }

    // Work out what relationship the user has to the user who posted the poll
    $polldata['FROM_RELATIONSHIP'] = user_rel_get(bh_session_get_value('UID'), $polldata['FROM_UID']);

    light_message_display($tid, $polldata, $msg_count, $first_msg, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);

}

function light_message_display($tid, $message, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if(!isset($message['CONTENT']) || $message['CONTENT'] == "") {
        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    if (bh_session_get_value('UID') != $message['FROM_UID']) {
      if ((user_get_status($message['FROM_UID']) & USER_PERM_WORMED) && !perm_is_moderator($message['FID'])) {
        light_message_display_deleted($tid, $message['PID']);
        return;
      }
    }

    if(!isset($message['FROM_RELATIONSHIP'])) {
        $message['FROM_RELATIONSHIP'] = 0;
    }

    if(!isset($message['TO_RELATIONSHIP'])) {
        $message['TO_RELATIONSHIP'] = 0;
    }

    if (($message['TO_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) || ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY))
    {
        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    // Check for words that should be filtered ---------------------------------

    $message['CONTENT'] = apply_wordfilter($message['CONTENT']);

    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {
        $message['CONTENT'] = preg_replace("/<img[^>]*src=\"([^\"]*)\"[^>]*>/i", "[img: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
    }

    if((strlen($message['CONTENT']) > intval(forum_get_setting('maximum_post_length'))) && $limit_text && !$is_poll) {
        $message['CONTENT'] = fix_html(substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length'))));
        $message['CONTENT'].= "...[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"display.php?webtag=$webtag&amp;msg=". $tid. ".". $message['PID']. "\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    if($in_list){
        echo "<a name=\"a". $tid. "_". $message['PID']. "\"></a>";
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    if (isset($message['PID'])) {

        echo "<p><b>{$lang['from']}: ", format_user_name($message['FLOGON'], $message['FNICK']), "</b> [#{$message['PID']}]<br />";

    }else {

        echo "<p><b>{$lang['from']}: ", format_user_name($message['FLOGON'], $message['FNICK']), "<br />";;
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;({$lang['friend']}) ";
    } else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || isset($temp_ignore)) {
        echo "&nbsp;({$lang['ignoreduser']}) ";
    }

    if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {
        echo "<b>{$lang['ignoredmsg']}</b>";
    } else {
        if($in_list) {
            $user_prefs = user_get_prefs(bh_session_get_value('UID'));
            if ((user_get_status($message['FROM_UID']) & USER_PERM_WORMED)) echo "<b>{$lang['wormeduser']}</b> ";

            //This is commented out because as far as I know, all sigs are ignored in Light. Correct me if I'm wrong. - Rowan
            //if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>{$lang['ignoredsig']}</b> ";

            echo "&nbsp;".format_time($message['CREATED'], 1)."<br />";
        }
    }

    if (($message['TLOGON'] != "ALL") && $message['TO_UID'] != 0) {

        echo "<b>{$lang['to']}: " . format_user_name($message['TLOGON'], $message['TNICK'])."</b>";

        if (isset($message['REPLY_TO_PID']) && $message['REPLY_TO_PID'] > 0) echo " [#{$message['REPLY_TO_PID']}]";

        if($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;({$lang['friend']})";
        } else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;({$lang['ignoreduser']})";
        }

        if (!$is_preview) {

            if(isset($message['VIEWED']) && $message['VIEWED'] > 0) {
                echo "&nbsp;".format_time($message['VIEWED'], 1);
            } else {
                echo "&nbsp;{$lang['unread']}";
            }
        }

    }else {
        echo "<b>{$lang['to']}: {$lang['all_caps']}</b>";
    }

    echo "</p>\n";

    if (!$in_list && isset($message['PID'])) echo "<p><i>{$lang['message']} ".$message['PID'] . " {$lang['of']} " . $msg_count."</i></p>\n";

        if (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs) {

            if (preg_match("/<div class=\"sig\">/", $message['CONTENT'])) {

                $msg_split = preg_split("/<div class=\"sig\">/", $message['CONTENT']);

                $tmp_sig = preg_split('/<\/div>/', $msg_split[count($msg_split) - 1]);

                $msg_split[count($msg_split)-1] = $tmp_sig[count($tmp_sig)-1];

                $message['CONTENT'] = "";

                for ($i = 0; $i < count($msg_split); $i++) {

                    if ($i > 0) $message['CONTENT'] .= "<div class=\"sig\">";
                    $message['CONTENT'].= $msg_split[$i];
                }

                $message['CONTENT'].= "</div>";
            }
        }

        echo "<p>". $message['CONTENT']. "</p>\n";

        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

            $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);
            $attachments_array = get_attachments($message['FROM_UID'], $aid);

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                // Draw the attachment header at the bottom of the post

                echo "<p><b>{$lang['attachments']}:</b><br />\n";

                foreach($attachments_array as $attachment) {

                    if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                        echo "<a href=\"getattachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\"";
                    }else {
                        echo "<a href=\"getattachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\"";
                    }

                    if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == 'lpost.php') {
                        echo " target=\"_blank\"";
                    }else {
                        echo " target=\"_self\"";
                    }

                    echo " title=\"";

                    if ($imageinfo = @getimagesize(forum_get_setting('attachment_dir'). '/'. md5($attachment['aid']. rawurldecode($attachment['filename'])))) {
                        echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
                    }

                    echo "{$lang['size']}: ". format_file_size($attachment['filesize']). ", ";
                    echo "{$lang['downloaded']}: ". $attachment['downloads'];

                    if ($attachment['downloads'] == 1) {
                        echo " {$lang['time']}";
                    }else {
                        echo " {$lang['times']}";
                    }

                    echo "\">{$attachment['filename']}</a><br />";
                }

                echo "</p>\n";
            }
        }

        echo "<p>\n";

        if ($in_list && $limit_text != false) {

            if (!$closed && perm_check_folder_permissions($message['FID'], USER_PERM_POST_CREATE)) {

                echo "<a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\">{$lang['reply']}</a>";
            }
        }

        echo "</p>\n";
        echo "<hr />";
}

function light_message_display_deleted($tid,$pid)
{
    $lang = load_language_file();

    echo "<p>{$lang['message']} ${tid}.${pid} {$lang['wasdeleted']}</p>\n";
    echo "<hr />";
}

function light_messages_nav_strip($tid,$pid,$length,$ppp)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < $ppp){
        return;
    }

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">" . mess_nav_range(1,$spid-1) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    } else {
        $i = 0;
    }

    // The middle section(s)
    while($spid + ($ppp - 1) <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid==0 ? 1 : $spid,$spid+($ppp - 1)) . "</a>";
        }
        $spid += $ppp;
        $i++;
    }

    // The final section, x-n
    if($spid <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "{$lang['showmessages']}:";

    if($length <= $ppp){
        $html .= " <a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">{$lang['all']}</a>\n";
    }

    for($i=0;$i<=$max;$i++) {

        if (isset($navbits[$i])) {

            if((abs($c - $i) < 4) || $i == 0 || $i == $max){
                $html .= "\n&nbsp;" . $navbits[$i];
            } else if(abs($c - $i) == 4){
                $html .= "\n&nbsp;...";
            }

        }
    }

    unset($navbits);

    echo "<p align=\"center\">" . $html . "</p>\n";
}

function light_html_guest_error ()
{
     $lang = load_language_file();

     $webtag = get_webtag($webtag_search);

     $final_uri = rawurlencode(get_request_uri(true));

     light_html_draw_top();

     echo "<h1>{$lang['guesterror_1']} <a href=\"llogout.php?webtag=$webtag";
     echo "&amp;final_uri=$final_uri\" target=\"_top\">{$lang['guesterror_2']}</a></h1>";

     light_html_draw_bottom();
}

function light_folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="")
{
    $db_light_folder_draw_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!is_numeric($default_fid));

    if (!$table_data = get_table_prefix()) return "";

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $allowed_types = FOLDER_ALLOW_NORMAL_THREAD;
    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.FID = FOLDER.FID AND GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS FOLDER_PERMS ";
    $sql.= "ON (FOLDER_PERMS.FID = FOLDER.FID AND FOLDER_PERMS.GID = 0) ";
    $sql.= "WHERE (FOLDER.ALLOWED_TYPES & $allowed_types > 0 OR FOLDER.ALLOWED_TYPES IS NULL) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.FID";

    $result = db_query($sql, $db_light_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result, MYSQL_ASSOC)) {

            if ($row['USER_PERM_COUNT'] > 0 && (($row['USER_STATUS'] & $access_allowed) == $access_allowed)) {

                $folders['FIDS'][] = $row['FID'];
                $folders['TITLES'][] = $row['TITLE'];

            }elseif (($row['USER_PERM_COUNT'] == 0 && $row['FOLDER_PERM_COUNT'] > 0 && ($row['FOLDER_PERMS'] & $access_allowed) == $access_allowed)) {

                $folders['FIDS'][] = $row['FID'];
                $folders['TITLES'][] = $row['TITLE'];

            }elseif ($row['FOLDER_PERM_COUNT'] == 0 && $row['USER_PERM_COUNT'] == 0) {

                $folders['FIDS'][] = $row['FID'];
                $folders['TITLES'][] = $row['TITLE'];
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            return light_form_dropdown_array($field_name.$suffix, $folders['FIDS'], $folders['TITLES'], $default_fid);
        }
    }
}

function light_form_textarea($name, $value = "", $rows = 0, $cols = 0)
{
    $html = "<textarea name=\"$name\" ";

    if($rows) $html.= " rows=\"$rows\"";
    if($cols) $html.= " cols=\"$cols\"";

    $html .= ">$value</textarea>";

    return $html;
}

function light_form_checkbox($name, $value, $text, $checked = false)
{
    $html = "<input type=\"checkbox\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text";
}

function light_form_field($name, $value = "", $width = 0, $maxchars = 0, $type = "text")
{
    $html = "<input type=\"$type\" name=\"$name\"";
    $html.= " value=\"$value\"";

    if($width) $html.= " size=\"$width\"";
    if($maxchars) $html.= " maxchars=\"$maxchars\"";

    return $html.">";
}

function light_form_input_text($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"text");
}

function light_form_input_password($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"password");
}

function light_html_message_type_error()
{
    $lang = load_language_file();

    light_html_draw_top();
    echo "<h1>{$lang['cannotpostthisthreadtype']}</h1>";
    light_html_draw_bottom();
}

?>