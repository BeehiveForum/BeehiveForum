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

// Included functions for displaying messages in the main frameset.

require_once("./include/db.inc.php"); // Database functions
require_once("./include/thread.inc.php"); // Thread processing functions
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/perm.inc.php"); // Permissions functions
require_once("./include/forum.inc.php"); // Forum functions
require_once("./include/form.inc.php"); // Form functions
require_once("./include/user.inc.php"); // User functions
require_once("./include/folder.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/config.inc.php");

function messages_get($tid, $pid = 1, $limit = 1) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    if(!$uid) $uid = 0;

    $db_message_get = db_connect();

    $tbl_post = forum_table("POST");

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql  = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql .= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, UNIX_TIMESTAMP(POST.VIEWED) as VIEWED, ";
    $sql .= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, USER_PEER_FROM.RELATIONSHIP as FROM_RELATIONSHIP, ";
    $sql .= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER_TO.RELATIONSHIP as TO_RELATIONSHIP ";
    $sql .= "from " . forum_table("POST") . " POST ";
    $sql .= "left join " . forum_table("USER") . " FUSER on (POST.from_uid = FUSER.uid) ";
    $sql .= "left join " . forum_table("USER") . " TUSER on (POST.to_uid = TUSER.uid) ";
    $sql .= "left join " . forum_table("USER_PEER") . " USER_PEER_TO ";
    $sql .= "on (USER_PEER_TO.uid = '$uid' and USER_PEER_TO.PEER_UID = POST.TO_UID) ";
    $sql .= "left join " . forum_table("USER_PEER") . " USER_PEER_FROM ";
    $sql .= "on (USER_PEER_FROM.uid = '$uid' and USER_PEER_FROM.PEER_UID = POST.FROM_UID) ";
    $sql .= "where POST.TID = '$tid' ";
    $sql .= "and POST.PID >= '$pid' ";
    $sql .= "order by POST.PID ";
    $sql .= "limit 0, " . $limit;

    /* OLD SQL - the CONTENT has been removed from the main select for memory efficiency
                 and to improve the MySQL performance by keeping the TEXT field separate
                 =======================================================================
    $sql  = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql .= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, POST_CONTENT.CONTENT, ";
    $sql .= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
    $sql .= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP ";
    $sql .= "from " . forum_table("POST") . " POST, " . forum_table("POST_CONTENT") . " POST_CONTENT ";
    $sql .= "left join " . forum_table("USER") . " FUSER on (POST.from_uid = FUSER.uid) ";
    $sql .= "left join " . forum_table("USER") . " TUSER on (POST.to_uid = TUSER.uid) ";
    $sql .= "left join " . forum_table("USER_PEER") . " USER_PEER ";
    $sql .= "on (USER_PEER.uid = '$uid' and USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql .= "where POST.TID = '$tid' ";
    $sql .= "and POST.PID >= '$pid' ";
    $sql .= "and POST_CONTENT.TID = POST.TID and POST_CONTENT.PID = POST.PID ";
    $sql .= "order by POST.PID ";
    $sql .= "limit 0, " . $limit;
    */

    $resource_id = db_unbuffered_query($sql, $db_message_get);

    // Loop through the results and construct an array to return

    if($limit > 1) {

        for ($i = 0; $message = db_fetch_array($resource_id); $i++) {

            $messages[$i]['PID'] = $message['PID'];
            $messages[$i]['REPLY_TO_PID'] = $message['REPLY_TO_PID'];
            $messages[$i]['FROM_UID'] = $message['FROM_UID'];
            $messages[$i]['TO_UID'] = $message['TO_UID'];
            $messages[$i]['CREATED'] = $message['CREATED'];
            $messages[$i]['VIEWED'] = @$message['VIEWED'];
            $messages[$i]['CONTENT'] = '';
            $messages[$i]['FROM_RELATIONSHIP'] = isset($message['FROM_RELATIONSHIP']) ? $message['FROM_RELATIONSHIP'] : 0;
            $messages[$i]['TO_RELATIONSHIP'] = isset($message['TO_RELATIONSHIP']) ? $message['TO_RELATIONSHIP'] : 0;
            $messages[$i]['FNICK'] = $message['FNICK'];
            $messages[$i]['FLOGON'] = $message['FLOGON'];

            if(isset($message['TNICK'])){
                $messages[$i]['TNICK'] = $message['TNICK'];
                $messages[$i]['TLOGON'] = $message['TLOGON'];
            } else {
                $messages[$i]['TNICK'] = "ALL";
                $messages[$i]['TLOGON'] = "ALL";
            }
        }
    } else {

        $messages = db_fetch_array($resource_id);

        if(!isset($messages['VIEWED'])){
            $messages['VIEWED'] = '';
        }

        if(!isset($messages['FROM_RELATIONSHIP'])){
            $messages['FROM_RELATIONSHIP'] = 0;
        }
        if(!isset($messages['TO_RELATIONSHIP'])){
            $messages['TO_RELATIONSHIP'] = 0;
        }

        if(!isset($messages['TNICK'])){
            $messages['TNICK'] = 'ALL';
            $messages['TLOGON'] = 'ALL';
        }
    }

    return $messages;
}

function message_get_content($tid,$pid)
{
    $db_mgc = db_connect();
    $sql = "select CONTENT from " . forum_table('POST_CONTENT') . " where TID = '$tid' and PID = '$pid'";
    $result = db_query($sql,$db_mgc);
    $fa = db_fetch_array($result);
    return isset($fa['CONTENT']) ? $fa['CONTENT'] : "";
}

function messages_top($foldertitle, $threadtitle, $interest_level = 0)
{
    echo "<p><img src=\"". style_image('folder.png'). "\" alt=\"folder\" />&nbsp;$foldertitle: $threadtitle";
    if ($interest_level == 1) echo "&nbsp;<img src=\"". style_image('high_interest.png'). "\" height=\"15\" alt=\"High Interest\" align=\"middle\">";
    if ($interest_level == 2) echo "&nbsp;<img src=\"". style_image('subscribe.png'). "\" height=\"15\" alt=\"Subscribed\" align=\"middle\">";
    echo "</p>";
    // To be expanded later

}

function messages_bottom()
{
    echo "<p align=\"right\">BeehiveForum 2002</p>";
}

function message_display($tid, $message, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false)
{

    global $HTTP_SERVER_VARS, $HTTP_COOKIE_VARS, $maximum_post_length, $attachment_dir;

    if(!isset($message['CONTENT']) || $message['CONTENT'] == "") {
        message_display_deleted($tid, $message['PID']);
        return;
    }

    if ($HTTP_COOKIE_VARS['bh_sess_uid'] != $message['FROM_UID']) {
      if ((user_get_status($message['FROM_UID']) & USER_PERM_WORM) && !perm_is_moderator()) {
        message_display_deleted($tid, $message['PID']);
	return;
      }
    }

    if(!isset($message['FROM_RELATIONSHIP'])) {
        $message['FROM_RELATIONSHIP'] = 0;
    }
    if(!isset($message['TO_RELATIONSHIP'])) {
        $message['TO_RELATIONSHIP'] = 0;
    }

    if((strlen($message['CONTENT']) > $maximum_post_length) && $limit_text && !$is_poll) {
        $message['CONTENT'] = fix_html(substr($message['CONTENT'], 0, $maximum_post_length));
        $message['CONTENT'].= "...[Message Truncated]\n<p align=\"center\"><a href=\"./display.php?msg=". $tid. ".". $message['PID']. "\" target=\"_self\">View full message.</a>";
    }

    if($in_list && isset($message['PID'])){
        echo "<a name=\"a". $tid. "_". $message['PID']. "\"></a>";
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    echo "<br /><div align=\"center\">\n";
    echo "<table width=\"96%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>\n";
    echo "<table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\"><tr>\n";
    echo "<td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;From:&nbsp;</span></td>\n";
    echo "<td nowrap=\"nowrap\" width=\"98%\"><span class=\"posttofrom\">";

    echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $message['FROM_UID'] . ")\" target=\"_self\">";
    echo format_user_name($message['FLOGON'], $message['FNICK']) . "</a></span>";

    $temp_ignore = false;

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;&nbsp;<img src=\"".style_image('friend.png')."\" height=\"15\" alt=\"Friend\" />";
    } else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || $temp_ignore) {
        echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" alt=\"Ignored user\" />";
    }

    echo "</td><td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {
        echo "<b>Ignored message</b>";
    } else {
        if($in_list) {
            $user_prefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
	    if ((user_get_status($message['FROM_UID']) & USER_PERM_WORM)) echo "<b>Wormed User</b> ";
	    if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>Ignored signature</b> ";
            echo format_time($message['CREATED'], 1);
        }
    }

    echo "&nbsp;</span></td>\n";
    echo "</tr><tr>\n";
    echo "<td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;To:&nbsp;</span></td>\n";
    echo "<td nowrap=\"nowrap\" width=\"98%\"><span class=\"posttofrom\">";

    if(($message['TLOGON'] != "ALL") && $message['TO_UID'] != 0) {
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(". $message['TO_UID']. ")\" target=\"_self\">";
        echo format_user_name($message['TLOGON'], $message['TNICK']) . "</a></span>";

        if($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('friend.png')."\" height=\"15\" alt=\"Friend\" />";
        } else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" alt=\"Ignored user\" />";
        }

        if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {
            echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">".format_time($message['VIEWED'], 1)."</span";
        }else {
	    if (!$is_preview) {
                echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">unread</span>";
	    }
        }

    }else {
        echo "ALL</span>";
    }

    echo "</td>\n";
    echo "<td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $in_list) {
        echo "<a href=\"set_relation.php?uid=".$message['FROM_UID']."&rel=0&exists=1&ret=". urlencode($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$tid.".$message['PID']."\" target=\"_self\">Stop ignoring this user</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"./display.php?msg=$tid.". $message['PID']. "\" target=\"_self\">View message</a>";
    }else if($in_list && $msg_count > 0) {
        if ($is_poll) {
          echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('pollresults.php?tid=", $tid, "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"><img src=\"".style_image('poll.png')."\" border=\"0\" height=\"15\" alt=\"This is a poll. Click to view results.\" align=\"middle\"></a> Poll ";
        }
        echo $message['PID'] . " of " . $msg_count;
    }

    echo "&nbsp;</span></td></tr>\n";
    echo "</table></td></tr>\n";

    if(!($message['FROM_RELATIONSHIP'] & USER_IGNORED) || !$limit_text) {
        echo "<tr><td><table width=\"100%\"><tr align=\"right\"><td colspan=\"3\"><span class=\"postnumber\">";
        if($in_list && $msg_count > 0) {

	    if ($is_preview) {
	        echo "<a href=\"http://", $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']), "/?msg=$tid.". $message['PID']. "\" target=\"_blank\">$tid.". $message['PID']. "</a>";
	    }else {
	        echo "<a href=\"http://", $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']), "/?msg=$tid.". $message['PID']. "\" target=\"_top\">$tid.". $message['PID']. "</a>";
	    }

            if($message['PID'] > 1) {

                echo " in reply to ";

                if(intval($message['REPLY_TO_PID']) >= intval($first_msg)) {
                    echo "<a href=\"#a" . $tid . "_" . $message['REPLY_TO_PID'] . "\" target=\"_self\">";
                    echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                }else {
		    if ($is_preview) {
                        echo "<a href=\"http://", $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/?msg=$tid." . $message['REPLY_TO_PID'] . "\" target=\"_blank\">";
                        echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
		    }else {
                        echo "<a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?msg=$tid." . $message['REPLY_TO_PID'] . "\" target=\"_self\">";
                        echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
		    }
                }
            }
        }
        echo "&nbsp;</span></td></tr>\n";

        if (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs) {
            $msg_split = preg_split("/<div class=\"sig\">/", $message['CONTENT']);
            $tmp_sig = preg_split('/<\/div>/', $msg_split[count($msg_split)-1]);
            $msg_split[count($msg_split)-1] = $tmp_sig[count($tmp_sig)-1];
            $message['CONTENT'] = "";
            for ($i=0; $i<count($msg_split); $i++) {
                if ($i > 0) $message['CONTENT'] .= "<div class=\"sig\">";
                $message['CONTENT'] .= $msg_split[$i];
            }
            $message['CONTENT'] .= "</div>";
	}

        echo "<tr><td class=\"postbody\">". $message['CONTENT'];
        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {
	      $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);
              $attachments = get_attachments($message['FROM_UID'], $aid);
              if (is_array($attachments)) {
                  echo "<p><b>Attachments:</b><br>\n";
                  for ($i = 0; $i < sizeof($attachments); $i++) {

                      echo "<img src=\"".style_image('attach.png')."\" height=\"15\" border=\"0\" align=\"absmiddle\">";
                      echo "<a href=\"getattachment.php?hash=". $attachments[$i]['hash']. "\"";

                      if (basename($HTTP_SERVER_VARS['PHP_SELF']) == 'post.php') {
                        echo " target=\"_blank\"";
                      }else {
                        echo " target=\"_self\"";
                      }

                      echo " title=\"";

                      if (@$imageinfo = getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
                        echo "Dimensions: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
                      }

                      echo "Size: ". format_file_size($attachments[$i]['filesize']). ", ";
                      echo "Downloaded: ". $attachments[$i]['downloads'];

                      if ($attachments[$i]['downloads'] == 1) {
                        echo " time";
                      }else {
                        echo " times";
                      }

                      echo "\">". $attachments[$i]['filename']. "</a><br />";

                  }
                  echo "</p>\n";
              }
        }

        echo "</td></tr>\n";

        if($in_list && $limit_text != false){
            echo "<tr><td align=\"center\"><span class=\"postresponse\">";
            if(!($closed || ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_WASP))) {

                echo "<img src=\"".style_image('post.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"post.php?replyto=$tid.".$message['PID']."\" target=\"_parent\">Reply</a>";

            }
            if($HTTP_COOKIE_VARS['bh_sess_uid'] == $message['FROM_UID'] || perm_is_moderator()){
                echo "&nbsp;&nbsp;<img src=\"".style_image('delete.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"delete.php?msg=$tid.".$message['PID']."&back=$tid.$first_msg\" target=\"_parent\">Delete</a>";

                if ($is_poll && $message['PID'] == 1) {

                  echo "&nbsp;&nbsp;<img src=\"".style_image('edit.png')."\" height=\"15\" border=\"0\" />";
                  echo "&nbsp;<a href=\"edit_poll.php?msg=$tid.".$message['PID']."\" target=\"_parent\">Edit Poll</a>";

                }else {

                  echo "&nbsp;&nbsp;<img src=\"".style_image('edit.png')."\" height=\"15\" border=\"0\" />";
                  echo "&nbsp;<a href=\"edit.php?msg=$tid.".$message['PID']."\" target=\"_parent\">Edit</a>";

                }

            }

            if($HTTP_COOKIE_VARS['bh_sess_uid'] != $message['FROM_UID']) {
                echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"user_rel.php?uid=".$message['FROM_UID']."&ret=". urlencode($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$tid.".$message['PID']."\" target=\"_self\">Relationship</a>";
            }

/*			if($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG){
                echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"set_relation.php?uid=".$message['FROM_UID']."&rel=1&ret=". urlencode($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$tid.".$message['PID']."&sig=1\" target=\"_self\">Stop Ignoring Signature</a>";
			} else {
                echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"set_relation.php?uid=".$message['FROM_UID']."&rel=-1&ret=". urlencode($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$tid.".$message['PID']."&sig=1\" target=\"_self\">Ignore Signature</a>";
			}*/

            if(perm_is_soldier()){
                echo "&nbsp;&nbsp;<img src=\"".style_image('admintool.png')."\" height=\"15\" border=\"0\" />";
                echo "&nbsp;<a href=\"admin_user.php?uid=".$message['FROM_UID']."&ret=". urlencode($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$tid.", $message['PID']. "\" target=\"_self\">Privileges</a>";
            }

            echo "</span></td></tr>";
        }
        echo "</table>\n";
    }

    echo "</td></tr></table></div>\n";
}

function message_display_deleted($tid,$pid)
{
    echo "<br /><div align=\"center\">";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td>\n";
    echo "<table class=\"posthead\" width=\"100%\"><tr><td>\n";
    echo "Message ${tid}.${pid} was deleted\n";
    echo "</td></tr></table>\n";
    echo "</td></tr></table></div>\n";
}

function messages_start_panel()
{
    //echo "<p>&nbsp;</p>\n";
    echo "<p align=\"center\"><table width=\"96%\" class=\"messagefoot\"><tr><td align=\"center\">";
}

function messages_end_panel()
{
    echo "</td></tr></table></p>";
}

function messages_nav_strip($tid,$pid,$length,$ppp)
{

    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < $ppp){
        return;
    }

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"messages.php?msg=$tid.1\" target=\"_self\">" . mess_nav_range(1,$spid-1) . "</a>";
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
            $navbits[$i] = "<a href=\"messages.php?msg=$tid.$spid\" target=\"_self\">" . mess_nav_range($spid==0 ? 1 : $spid,$spid+($ppp - 1)) . "</a>";
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
            $navbits[$i] = "<a href=\"messages.php?msg=$tid.$spid\" target=\"_self\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "Show messages:";

    if($length <= $ppp){
        $html .= " <a href=\"messages.php?msg=$tid.1\" target=\"_self\">All</a>\n";
    }

    for($i=0;$i<=$max;$i++){
        // Only display first, last and those within 3 of the current section
        //echo "$i : $max\n";
        if((abs($c - $i) < 4) || $i == 0 || $i == $max){
            $html .= "\n&nbsp;" . $navbits[$i];
        } else if(abs($c - $i) == 4){
            $html .= "\n&nbsp;...";
        }
    }

    unset($navbits);

    echo "<p align=\"center\" class=\"smalltext\">" . $html . "</p>\n";
}

function mess_nav_range($from,$to)
{
    if($from == $to){
        $range = sprintf("%d", $from);
    } else {
        $range = sprintf("%d-%d", $from, $to);
    }
    return $range;
}

function messages_interest_form($tid,$pid)
{
    $interest = thread_get_interest($tid);
    $chk = array("","","","");
    $chk[$interest+1] = " checked";
    global $HTTP_SERVER_VARS;

    echo "<p align=\"center\">\n";
    echo "<form name=\"rate_interest\" target=\"_self\" action=\"./interest.php?ret=";
    echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?msg=$tid.$pid";
    echo "\" method=\"POST\">\n";
    echo "Rate my interest: \n";
    echo form_radio_array("interest",array(-1,0,1,2),array("Ignore ","Normal ","Interested ","Subscribe "),$interest);
    echo form_input_hidden("tid",$tid);
    echo form_submit("submit","Apply","smallbutton");
    echo "</form>\n";
    echo "</p>\n";
}

function messages_admin_form($tid,$pid,$title,$closed = false)
{
    global $HTTP_SERVER_VARS;
    echo "<p align=\"center\">\n";
    echo "<form name=\"thread_admin\" target=\"_self\" action=\"./thread_admin.php?ret=";
    echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?msg=$tid.$pid";
    echo "\" method=\"POST\">\n";
    echo "Rename thread:".form_input_text("t_name",_stripslashes($title),30,64)."&nbsp;";
    echo form_submit("rename","Apply");
    echo "<br />Move thread:" . folder_draw_dropdown(0,"t_move");
    echo "&nbsp;".form_submit("move","Move");
    if($closed){
        echo "&nbsp;&nbsp;".form_submit("reopen","Reopen for posting");
    } else {
        echo "&nbsp;&nbsp;".form_submit("close","Close for posting");
    }
    echo form_input_hidden("t_tid",$tid);
    echo form_input_hidden("t_pid",$pid);
    echo "</form>\n";
    echo "</p>\n";
}

function message_get_user($tid,$pid)
{
    $db_message_get_user = db_connect();

    $sql = "select from_uid from " . forum_table("POST") . " where tid = $tid and pid = $pid";

    $result = db_query($sql, $db_message_get_user);

    if($result){
        $fa = db_fetch_array($result);
        $uid = $fa['from_uid'];
    } else {
        $uid = "";
    }

    return $uid;
}

function messages_update_read($tid,$pid,$uid,$spid = 1)
{
    $db_message_update_read = db_connect();

    // Check for existing entry in USER_THREAD
    $sql = "select LAST_READ from " . forum_table("USER_THREAD") . " where UID = $uid and TID = $tid";

    $result = db_query($sql, $db_message_update_read);

    if(db_num_rows($result)){
        // Update if already existing
        $fa = db_fetch_array($result);
        if($pid > $fa['LAST_READ']){

            $sql = "update low_priority " . forum_table("USER_THREAD");
            $sql.= " set LAST_READ = $pid, LAST_READ_AT = NOW()";
            $sql.= "where UID = $uid and TID = $tid";

            db_query($sql, $db_message_update_read);
        }
    } else {
        // Create new USER_THREAD entry
        $sql = "insert into " . forum_table("USER_THREAD") . " (UID,TID,LAST_READ,LAST_READ_AT,INTEREST) ";
        $sql .= "values ($uid, $tid, $pid, NOW(), 0)";
        db_query($sql, $db_message_update_read);
    }

    // Mark posts as Viewed...
    $sql = "update low_priority ". forum_table("POST"). " set VIEWED = NOW() where TID = $tid and PID between $spid and $pid and TO_UID = $uid and VIEWED is null";
    db_query($sql, $db_message_update_read);

}

function messages_get_most_recent($uid)
{
    $return = "1.1";

    $fidlist = folder_get_available();

    $db_messages_get_most_recent = db_connect();

    $sql = "select THREAD.TID, THREAD.MODIFIED, THREAD.LENGTH, USER_THREAD.LAST_READ ";
    $sql .= "from " . forum_table("THREAD") . " THREAD ";
    $sql .= "left join " . forum_table("USER_THREAD") . " USER_THREAD on (USER_THREAD.TID = THREAD.TID and USER_THREAD.UID = $uid) ";
    $sql .= "left join " . forum_table("USER_FOLDER") . " USER_FOLDER on (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "where THREAD.FID in ($fidlist) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "and (USER_THREAD.INTEREST >= 0 or USER_THREAD.INTEREST is null) ";
    $sql .= "order by THREAD.MODIFIED DESC LIMIT 0,1";

    $result = db_query($sql, $db_messages_get_most_recent);

    if(db_num_rows($result)) {

        $fa = db_fetch_array($result);

        if (isset($fa['LAST_READ'])) {

	    if ($fa['LAST_READ'] < $fa['LENGTH']) {
	      $return = $fa['TID'] . ".". ($fa['LAST_READ'] + 1);
	    }else {
              $return = $fa['TID'] . "." . $fa['LAST_READ'];
	    }

        } else {
            $return = $fa['TID'] . ".1";
        }
    }

    return $return;
}

function messages_fontsize_form($tid, $pid)
{

    global $HTTP_COOKIE_VARS;

    $fontstrip = "Adjust text size: ";

    if (($HTTP_COOKIE_VARS['bh_sess_fontsize'] > 1) && ($HTTP_COOKIE_VARS['bh_sess_fontsize'] < 15)) {

      $fontsmaller = $HTTP_COOKIE_VARS['bh_sess_fontsize'] - 1;
      $fontlarger = $HTTP_COOKIE_VARS['bh_sess_fontsize'] + 1;

      if ($fontsmaller < 1) $fontsmaller = 1;
      if ($fontlarger > 15) $fontlarger = 15;

      $fontstrip.= "<a href=\"messages.php?msg=$tid.$pid&fontsize=$fontsmaller\" target=\"_self\">Smaller</a> ";
      $fontstrip.= $HTTP_COOKIE_VARS['bh_sess_fontsize']. " <a href=\"messages.php?msg=$tid.$pid&fontsize=$fontlarger\" target=\"_self\">Larger</a>";

    }elseif ($HTTP_COOKIE_VARS['bh_sess_fontsize'] == 1) {

      $fontstrip.= $HTTP_COOKIE_VARS['bh_sess_fontsize']. "<a href=\"messages.php?msg=$tid.$pid&fontsize=2\" target=\"_self\">Larger</a>";

    }elseif ($HTTP_COOKIE_VARS['bh_sess_fontsize'] == 15) {

      $fontstrip.= "<a href=\"messages.php?msg=$tid.$pid&fontsize=14\" target=\"_self\">Smaller</a> ". $HTTP_COOKIE_VARS['bh_sess_fontsize'];

    }

    echo $fontstrip;
}

?>
