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

/* $Id: messages.inc.php,v 1.312 2004-12-27 00:20:50 decoyduck Exp $ */

include_once("./include/attachments.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");

function messages_get($tid, $pid = 1, $limit = 1)
{
    $uid = bh_session_get_value('UID');
    if(!$uid) $uid = 0;

    $db_message_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql  = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql .= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, UNIX_TIMESTAMP(POST.VIEWED) AS VIEWED, ";
    $sql .= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, EDIT_USER.LOGON AS EDIT_LOGON, POST.IPADDRESS, ";
    $sql .= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, USER_PEER_FROM.RELATIONSHIP AS FROM_RELATIONSHIP, ";
    $sql .= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, USER_PEER_TO.RELATIONSHIP AS TO_RELATIONSHIP, ";
    $sql .= "THREAD.FID FROM {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql .= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql .= "ON (USER_PEER_TO.UID = '$uid' AND USER_PEER_TO.PEER_UID = POST.TO_UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql .= "ON (USER_PEER_FROM.UID = '$uid' AND USER_PEER_FROM.PEER_UID = POST.FROM_UID) ";
    $sql .= "LEFT JOIN USER EDIT_USER ON (POST.EDITED_BY = EDIT_USER.UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = POST.TID) ";
    $sql .= "WHERE POST.TID = '$tid' ";
    $sql .= "AND POST.PID >= '$pid' ";
    $sql .= "ORDER BY POST.PID ";
    $sql .= "LIMIT 0, $limit";

    $result = db_unbuffered_query($sql, $db_message_get);

    // Loop through the results and construct an array to return

    if ($limit > 1) {

        $messages = array();

        for ($i = 0; $message = db_fetch_array($result); $i++) {

            $messages[$i]['FID'] = $message['FID'];
            $messages[$i]['PID'] = $message['PID'];
            $messages[$i]['REPLY_TO_PID'] = $message['REPLY_TO_PID'];
            $messages[$i]['FROM_UID'] = $message['FROM_UID'];
            $messages[$i]['TO_UID'] = $message['TO_UID'];
            $messages[$i]['CREATED'] = $message['CREATED'];
            $messages[$i]['VIEWED'] = isset($message['VIEWED']) ? $message['VIEWED'] : 0;
            $messages[$i]['EDITED'] = isset($message['EDITED']) ? $message['EDITED'] : 0;
            $messages[$i]['EDIT_LOGON'] = isset($message['EDIT_LOGON']) ? $message['EDIT_LOGON'] : 0;
            $messages[$i]['IPADDRESS'] = isset($message['IPADDRESS']) ? $message['IPADDRESS'] : '';
            $messages[$i]['CONTENT'] = '';
            $messages[$i]['FROM_RELATIONSHIP'] = isset($message['FROM_RELATIONSHIP']) ? $message['FROM_RELATIONSHIP'] : 0;
            $messages[$i]['TO_RELATIONSHIP'] = isset($message['TO_RELATIONSHIP']) ? $message['TO_RELATIONSHIP'] : 0;

            if (isset($message['FNICK'])) {

                $messages[$i]['FNICK'] = $message['FNICK'];
                $messages[$i]['FLOGON'] = $message['FLOGON'];

            }else {

                $messages[$i]['FNICK'] = "Unknown User";
                $messages[$i]['FLOGON'] = "Unknown User";
                $messages[$i]['FROM_UID'] = -1;
            }

            if (isset($message['TNICK'])) {

                $messages[$i]['TNICK'] = $message['TNICK'];
                $messages[$i]['TLOGON'] = $message['TLOGON'];

            }else {

                $messages[$i]['TNICK'] = "ALL";
                $messages[$i]['TLOGON'] = "ALL";
            }
        }

    }else {

        $messages = db_fetch_array($result);

        if (!isset($messages['VIEWED'])) {

            $messages['VIEWED'] = '';
        }

        if (!isset($messages['FROM_RELATIONSHIP'])) {

            $messages['FROM_RELATIONSHIP'] = 0;
        }

        if (!isset($messages['TO_RELATIONSHIP'])){

            $messages['TO_RELATIONSHIP'] = 0;
        }

        if(!isset($messages['TNICK'])){

            $messages['TNICK'] = 'ALL';
            $messages['TLOGON'] = 'ALL';
        }
    }

    return isset($messages) ? $messages : false;
}

function message_get_content($tid, $pid)
{
    $db_mgc = db_connect();

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT CONTENT FROM {$table_data['PREFIX']}POST_CONTENT WHERE TID = '$tid' AND PID = '$pid'";
    $result = db_query($sql,$db_mgc);

    $fa = db_fetch_array($result);
    return isset($fa['CONTENT']) ? $fa['CONTENT'] : "";
}

function messages_top($foldertitle, $threadtitle, $interest_level = 0, $sticky = "N", $closed = false, $locked = false)
{
    $lang = load_language_file();

    echo "<p><img src=\"". style_image('folder.png'). "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />&nbsp;", apply_wordfilter("$foldertitle: $threadtitle");

    if ($closed) echo "&nbsp;<img src=\"". style_image('thread_closed.png'). "\" height=\"15\" alt=\"{$lang['closed']}\" title=\"{$lang['closed']}\" align=\"middle\" />\n";
    if ($interest_level == 1) echo "&nbsp;<img src=\"". style_image('high_interest.png'). "\" height=\"15\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" align=\"middle\" />";
    if ($interest_level == 2) echo "&nbsp;<img src=\"". style_image('subscribe.png'). "\" height=\"15\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" align=\"middle\" />";
    if ($sticky == "Y") echo "&nbsp;<img src=\"". style_image('sticky.png'). "\" height=\"15\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" align=\"middle\" />";
    if ($locked) echo "&nbsp;<img src=\"". style_image('admin_locked.png'). "\" height=\"15\" alt=\"{$lang['locked']}\" title=\"{$lang['locked']}\" align=\"middle\" />\n";

    echo "</p>";
}

function messages_bottom()
{
    echo "<p align=\"right\">BeehiveForum 2002</p>\n";
}

function message_display($tid, $message, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (!isset($message['CONTENT']) || $message['CONTENT'] == "") {
        message_display_deleted($tid, $message['PID']);
        return;
    }

    if (bh_session_get_value('UID') != $message['FROM_UID']) {
      if ((user_get_status($message['FROM_UID']) & USER_PERM_WORMED) && !perm_is_moderator($message['FID'])) {
        message_display_deleted($tid, $message['PID']);
        return;
      }
    }

    if (!isset($message['FROM_RELATIONSHIP'])) {
        $message['FROM_RELATIONSHIP'] = 0;
    }

    if (!isset($message['TO_RELATIONSHIP'])) {
        $message['TO_RELATIONSHIP'] = 0;
    }

    if (($message['TO_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) || ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY))
    {
        message_display_deleted($tid, $message['PID']);
        return;
    }

    // Check for words that should be filtered ---------------------------------

    $message['CONTENT'] = apply_wordfilter($message['CONTENT']);

    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {
        $message['CONTENT'] = preg_replace("/<a([^>]*)href=\"([^\"]*)\"([^\>]*)><img[^>]*src=\"([^\"]*)\"[^>]*><\/a>/i", "[img: <a\\1href=\"\\2\"\\3>\\4</a>]", $message['CONTENT']);
        $message['CONTENT'] = preg_replace("/<img[^>]*src=\"([^\"]*)\"[^>]*>/i", "[img: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
    }

    if ((strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length'))) && $limit_text) {
        $cut_msg = substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length')));
        $cut_msg = preg_replace("/(<[^>]+)?$/", "", $cut_msg);
        $message['CONTENT'] = fix_html($cut_msg, false);
        $message['CONTENT'].= "&hellip;[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"display.php?webtag=$webtag&amp;msg=". $tid. ".". $message['PID']. "\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    if($in_list && isset($message['PID'])){
        echo "<a name=\"a". $tid. "_". $message['PID']. "\"></a>\n";
    }

    // Check for search words to highlight -------------------------------------

    if (sizeof($highlight_array) > 0) {

        $highlight_pattern = array();
        $highlight_replace = array();

        foreach ($highlight_array as $key => $word) {

            $highlight_word = preg_quote($word, "/");

            $highlight_pattern[$key] = "/($highlight_word)/i";
            $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
        }

        $message_parts = preg_split('/([<|>])/', $message['CONTENT'], -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {
            if (!($i % 4)) {
                $message_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $message_parts[$i], 1);
            }
        }

        $message['CONTENT'] = implode('', $message_parts);
    }

    // Little up/down arrows to the left of each message -----------------------

    $up_arrow = "";
    $down_arrow = "";

    if ($in_list && !$is_preview) {
            if ($message['PID'] != 1) {
                    $up_arrow = "<a href=\"";
                    if ($message['PID'] == $first_msg) {
                            $up_arrow.= "messages.php?webtag=$webtag&amp;msg=$tid.". ($message['PID'] - 1);
                    } else {
                            $up_arrow.= "#a" . $tid . "_" . ($message['PID'] - 1);
                    }
                    $up_arrow.= "\" target=\"_self\"><img src=\"".style_image("message_up.png")."\" width=\"10\" border=\"0\" alt=\"{$lang['prev']}\" title=\"{$lang['prev']}\" /></a> ";
            }
            if ($message['PID'] != $msg_count) {
                    $down_arrow = "<a href=\"";
                    if ($first_msg + bh_session_get_value('POSTS_PER_PAGE') - 1 == $message['PID']) {
                            $down_arrow.= "messages.php?webtag=$webtag&amp;msg=$tid.". ($message['PID'] + 1);
                    } else {
                            $down_arrow.= "#a" . $tid . "_" . ($message['PID'] + 1);
                    }
                    $down_arrow.= "\" target=\"_self\"><img src=\"".style_image("message_down.png")."\" width=\"10\" border=\"0\" alt=\"{$lang['next']}\" title=\"{$lang['next']}\" /></a>";
            }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<table width=\"100%\" cellspacing=\"0\"cellpadding=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td width=\"2%\" valign=\"top\">$up_arrow<br />$down_arrow</td>\n";
    echo "    <td>\n";
    echo "      <table width=\"98%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td>\n";
    echo "            <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
    echo "                <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if ($message['FROM_UID'] > -1) {
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['FROM_UID']}, '$webtag')\" target=\"_self\">";
        echo format_user_name($message['FLOGON'], $message['FNICK']) . "</a></span>";
    }else {
        echo format_user_name($message['FLOGON'], $message['FNICK']) . "</span>";
    }

    $temp_ignore = false;

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && isset($message['PID']) && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;&nbsp;<img src=\"".style_image('friend.png')."\" height=\"15\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";
    } else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || $temp_ignore) {
        echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
    }

    echo "</td>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && bh_session_get_value('UID') != 0) {
        echo "<b>{$lang['ignoredmsg']}</b>";
    } else {
        if ($in_list) {
            $user_prefs = user_get_prefs(bh_session_get_value('UID'));
            if ((user_get_status($message['FROM_UID']) & USER_PERM_WORMED)) echo "<b>{$lang['wormeduser']}</b> ";
            if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>{$lang['ignoredsig']}</b> ";
            echo format_time($message['CREATED'], 1);
        }
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
    echo "                <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if (($message['TLOGON'] != "ALL") && $message['TO_UID'] != 0) {

        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['TO_UID']}, '$webtag')\" target=\"_self\">";
        echo format_user_name($message['TLOGON'], $message['TNICK']) . "</a></span>";

        if($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('friend.png')."\" height=\"15\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";
        } else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;&nbsp;<img src=\"".style_image('enemy.png')."\" height=\"15\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
        }

        if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {
            echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">".format_time($message['VIEWED'], 1)."</span>";
        }else {
            if ($is_preview == false) {
                echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">{$lang['unread']}</span>";
            }
        }

    }else {
        echo "{$lang['all_caps']}</span>";
    }

    echo "</td>\n";
    echo "                <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $in_list && bh_session_get_value('UID') != 0) {

        echo "<a href=\"set_relation.php?webtag=$webtag&amp;uid=".$message['FROM_UID']."&amp;rel=0&amp;exists=1&amp;msg=$tid.".$message['PID']."\" target=\"_self\">{$lang['stopignoringthisuser']}</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.". $message['PID']. "\" target=\"_self\">{$lang['viewmessage']}</a>";

    }else if($in_list && $msg_count > 0) {

        if ($is_poll) {

            echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=", $tid, "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"><img src=\"".style_image('poll.png')."\" border=\"0\" height=\"15\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" align=\"middle\" /></a> {$lang['poll']} ";
        }

        echo $message['PID'] . " {$lang['of']} " . $msg_count;
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";

    if(!($message['FROM_RELATIONSHIP'] & USER_IGNORED) || !$limit_text) {

        echo "        <tr>\n";
        echo "          <td>\n";
        echo "            <table width=\"100%\">\n";
        echo "              <tr align=\"right\">\n";
        echo "                <td colspan=\"3\"><span class=\"postnumber\">";

        if($in_list && $msg_count > 0) {

            if ($is_preview) {
                echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". $message['PID']. "\" target=\"_blank\">$tid.". $message['PID']. "</a>";
            }else {
                echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.". $message['PID']. "\" target=\"_top\">$tid.". $message['PID']. "</a>";
            }

            if ($message['REPLY_TO_PID'] > 0) {

                echo " {$lang['inreplyto']} ";

                if (intval($message['REPLY_TO_PID']) >= intval($first_msg)) {
                    echo "<a href=\"#a" . $tid . "_" . $message['REPLY_TO_PID'] . "\" target=\"_self\">";
                    echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                }else {
                    if ($is_preview) {
                        echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid." . $message['REPLY_TO_PID'] . "\" target=\"_blank\">";
                        echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                    }else {
                        echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid." . $message['REPLY_TO_PID'] . "\" target=\"_self\">";
                        echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                    }
                }
            }
        }

        echo "&nbsp;</span></td>\n";
        echo "              </tr>\n";

        if (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs) {

            if (preg_match("/<div class=\"sig\">/", $message['CONTENT'])) {

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
        }

        echo "              <tr>\n";
        echo "                <td class=\"postbody\" align=\"left\">{$message['CONTENT']}</td>\n";
        echo "              </tr>\n";

        if (isset($message['EDITED']) && $message['EDITED'] > 0) {

            echo "              <tr>\n";
            echo "                <td class=\"postbody\" align=\"left\"><p style=\"font-size: 10px\">{$lang['edited_caps']}: ", format_time($message['EDITED'], 1, "d/m/y H:i"), " {$lang['by']} {$message['EDIT_LOGON']}</p></td>\n";
            echo "              </tr>\n";
        }

        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

            $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);
            $attachments_array = get_attachments($message['FROM_UID'], $aid);

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                // Draw the attachment header at the bottom of the post

                echo "              <tr>\n";
                echo "                <td>&nbsp;</td>\n";
                echo "              </tr>\n";
                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\">\n";
                echo "                  <b>{$lang['attachments']}:</b><br />\n";

                foreach($attachments_array as $attachment) {

                    echo "                  <img src=\"", style_image('attach.png'), "\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" />";

                    if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                        echo "<a href=\"get_attachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\"";
                    }else {
                        echo "<a href=\"get_attachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\"";
                    }

                    if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == 'post.php') {
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

                    echo "\">{$attachment['filename']}</a><br />\n";
                }

                echo "                </td>\n";
                echo "              </tr>\n";
            }
        }

        echo "            </table>\n";

        if (($is_preview == false && $limit_text != false) || ($is_poll && $is_preview == false)) {

            echo "            <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
            echo "              <tr>\n";
            echo "                <td width=\"25%\">&nbsp;</td>\n";
            echo "                <td width=\"50%\" nowrap=\"nowrap\">";

            if ((!$closed && perm_check_folder_permissions($message['FID'], USER_PERM_POST_CREATE)) || perm_is_moderator($message['FID'])) {

                echo "<img src=\"", style_image('post.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />";
                echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\">{$lang['reply']}</a>";
            }

            if ((bh_session_get_value('UID') == $message['FROM_UID'] && perm_check_folder_permissions($message['FID'], USER_PERM_POST_DELETE)) || perm_is_moderator($message['FID'])) {

                echo "&nbsp;&nbsp;<img src=\"", style_image('delete.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['delete']}\" title=\"{$lang['delete']}\" />";
                echo "&nbsp;<a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['delete']}</a>";
            }

            if ((bh_session_get_value('UID') == $message['FROM_UID'] && perm_check_folder_permissions($message['FID'], USER_PERM_POST_EDIT) && (((time() - $message['CREATED']) < (forum_get_setting('post_edit_time') * HOUR_IN_SECONDS) || forum_get_setting('post_edit_time') == 0) && (forum_get_setting('allow_post_editing', 'Y', false)))) || perm_is_moderator($message['FID'])) {

                if ($is_poll && $message['PID'] == 1) {

                    if (!poll_is_closed($tid) || perm_is_moderator($message['FID'])) {

                        echo "&nbsp;&nbsp;<img src=\"".style_image('edit.png')."\" height=\"15\" border=\"0\" alt=\"{$lang['editpoll']}\" title=\"{$lang['editpoll']}\" />";
                        echo "&nbsp;<a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.".$message['PID']."\" target=\"_parent\">{$lang['editpoll']}</a>";
                    }

                }else {

                    echo "&nbsp;&nbsp;<img src=\"".style_image('edit.png')."\" height=\"15\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />";
                    echo "&nbsp;<a href=\"edit.php?webtag=$webtag&amp;msg=$tid.".$message['PID']."\" target=\"_parent\">{$lang['edit']}</a>";

                }
            }

            echo "</td>\n";
            echo "            <td width=\"25%\" align=\"right\" nowrap=\"nowrap\">";

            echo "<a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"{$lang['pm_reply']}\"><img src=\"", style_image('pmunread.png'), "\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['pm_reply']}\" title=\"{$lang['pm_reply']}\" /></a>&nbsp;";

            echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.".$message['PID']."\" target=\"_self\" title=\"{$lang['print']}\"><img src=\"".style_image('print.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['print']}\" title=\"{$lang['print']}\" /></a>&nbsp;";

            echo "<a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$first_msg&amp;markasread=".($message['PID']-1)."\" target=\"_self\" title=\"{$lang['markasunread']}\"><img src=\"".style_image('markasunread.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['markasunread']}\" title=\"{$lang['markasunread']}\" /></a>&nbsp;";

            if (bh_session_get_value('UID') != $message['FROM_UID']) {
                echo "<a href=\"user_rel.php?webtag=$webtag&amp;uid=", $message['FROM_UID'], "&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['relationship']}\"><img src=\"".style_image('enemy.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['relationship']}\" title=\"{$lang['relationship']}\" /></a>&nbsp;";
            }

            if (perm_is_moderator($message['FID'])) {

                if (perm_has_admin_access()) {

                    echo "<a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['privileges']}\"><img src=\"".style_image('admintool.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['privileges']}\" title=\"{$lang['privileges']}\" /></a>&nbsp;";
                }

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {
                    echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$message['IPADDRESS']}&nbsp;</span>";
                }else {
                    echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['notlogged']}&nbsp;</span>";
                }

            }else {
                echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['logged']}&nbsp;</span>";
            }

            echo "</td>\n";
            echo "              </tr>";
            echo "            </table>\n";
        }
    }

    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function message_display_deleted($tid,$pid)
{
    $lang = load_language_file();

    echo "<br /><div align=\"center\">";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td>\n";
    echo "<table class=\"posthead\" width=\"100%\"><tr><td>\n";
    echo "{$lang['message']} ${tid}.${pid} {$lang['wasdeleted']}\n";
    echo "</td></tr></table>\n";
    echo "</td></tr></table></div>\n";
}

function messages_start_panel()
{
    echo "<div align=\"center\">\n";
    echo "<table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
}

function messages_end_panel()
{
    echo "</td></tr></table></div>";
}

function messages_nav_strip($tid, $pid, $length, $ppp)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    // Less than 20 messages, no nav needed

    if ($pid < 2 && $length < $ppp){
        return;
    }

    // Something.
    $c = 0;

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if ($spid > 1) {
        if($pid > 1){
            $navbits[0] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">". mess_nav_range(1, $spid-1). "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    } else {
        $i = 0;
    }

    // The middle section(s)
    while($spid + ($ppp - 1) < $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($spid == 0 ? 1 : $spid). "\" target=\"_self\">". mess_nav_range($spid == 0 ? 1 : $spid, $spid + ($ppp - 1)). "</a>";
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
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$spid\" target=\"_self\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }

    $max = $i;

    $html = "{$lang['showmessages']}:";

    if ($length <= $ppp) {
        $html .= " <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">{$lang['all']}</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            // Only display first, last and those within 3 of the current section

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max) {
                $html .= "\n&nbsp;" . $navbits[$i];
            } else if(abs($c - $i) == 4) {
                $html .= "\n&nbsp;&hellip;";
            }

        }

    }

    unset($navbits);

    echo "<p align=\"center\" class=\"messagefoot\">" . $html . "</p>\n";
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
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $interest = thread_get_interest($tid);
    $chk = array("","","","");
    $chk[$interest+1] = " checked";

    echo "<div align=\"center\" class=\"messagefoot\">\n";
    echo "<form name=\"rate_interest\" target=\"_self\" action=\"./thread_options.php?webtag=$webtag&amp;msg=$tid.$pid\" method=\"post\">\n";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo "<p>{$lang['ratemyinterest']}: \n";
    echo form_radio_array("setinterest",array(-1,0,1,2),array("{$lang['ignore']} ","{$lang['normal']} ","{$lang['interested']} ","{$lang['subscribe']} "),$interest);
    echo form_input_hidden("tid",$tid);
    echo form_submit("submit", $lang['apply']);
    echo "</p>\n";
    echo "</form>\n";
    echo "</div>\n";
}

function message_get_user($tid, $pid)
{
    $db_message_get_user = db_connect();

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT FROM_UID FROM {$table_data['PREFIX']}POST WHERE TID = '$tid' AND PID = '$pid'";
    $result = db_query($sql, $db_message_get_user);

    if($result){
        $fa = db_fetch_array($result);
        $uid = $fa['FROM_UID'];
    } else {
        $uid = "";
    }

    return $uid;
}

function messages_update_read($tid, $pid, $uid, $spid = 1)
{
    $db_message_update_read = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($uid)) return false;
    if (!is_numeric($spid)) return false;

    // Check for existing entry in USER_THREAD

    if (!$table_data = get_table_prefix()) return false;

    // Guest users' can't mark as read!

    if ($uid == 0) return false;

    $sql = "SELECT LAST_READ FROM {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    $result = db_query($sql, $db_message_update_read);

    if (db_num_rows($result) > 0) {

        $fa = db_fetch_array($result);

        if (!isset($fa['LAST_READ'])) {
            $fa['LAST_READ'] = 0;
        }

        if ($pid > $fa['LAST_READ']) {

            $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
            $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NOW() ";
            $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

            $result = db_query($sql, $db_message_update_read);
        }

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "(UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "VALUES ($uid, $tid, $pid, NOW(), 0)";

        $result = db_query($sql, $db_message_update_read);
    }

    // Mark posts as Viewed...
    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET VIEWED = NOW() ";
    $sql.= "WHERE TID = '$tid' AND PID BETWEEN '$spid' AND '$pid' ";
    $sql.= "AND TO_UID = '$uid' AND VIEWED IS NULL";

    $result = db_query($sql, $db_message_update_read);
}

function messages_set_read($tid, $pid, $uid)
{
    $db_message_set_read = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($uid)) return false;

    // Check for existing entry in USER_THREAD

    if (!$table_data = get_table_prefix()) return false;

    // Guest can't mark as read

    if ($uid == 0) return false;

    $sql = "SELECT LAST_READ FROM {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    $result = db_query($sql, $db_message_set_read);

    if (db_num_rows($result) > 0) {

        $fa = db_fetch_array($result);

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NOW() ";
        $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

        $result = db_query($sql, $db_message_set_read);

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "(UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "VALUES ($uid, $tid, $pid, NOW(), 0)";

        $result = db_query($sql, $db_message_set_read);
    }

    // Mark posts as Viewed...

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET VIEWED = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID >= '$pid' AND TO_UID = '$uid'";

    $result = db_query($sql, $db_message_set_read);
}

function messages_get_most_recent($uid, $fid = false)
{
    $db_messages_get_most_recent = db_connect();

    if (is_numeric($fid)) {
        $fidlist = $fid;
    }else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return "1.1";

    $sql = "SELECT THREAD.TID, THREAD.MODIFIED, THREAD.LENGTH, USER_THREAD.LAST_READ, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. " = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP & ". USER_IGNORED. " = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_messages_get_most_recent);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (isset($row['LAST_READ'])) {

            if ($row['LAST_READ'] < $row['LENGTH']) {
                $row['LAST_READ']++;
            }

            return "{$row['TID']}.{$row['LAST_READ']}";

        }else {

            return "{$row['TID']}.1";
        }
    }

    return "1.1";
}

function messages_get_most_recent_unread($uid, $fid = false)
{
    $db_messages_get_most_recent = db_connect();

    if (is_numeric($fid)) {
        $fidlist = $fid;
    }else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return "1.1";

    $sql = "SELECT THREAD.TID, THREAD.MODIFIED, THREAD.LENGTH, USER_THREAD.LAST_READ, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_messages_get_most_recent);

    if (db_num_rows($result)) {

        $row = db_fetch_array($result);

        if (isset($row['LAST_READ'])) {

            if ($row['LAST_READ'] < $row['LENGTH']) {
                $row['LAST_READ']++;
            }

            return "{$row['TID']}.{$row['LAST_READ']}";

        }else {

            return "{$row['TID']}.1";
        }
    }

    return false;
}

function messages_fontsize_form($tid, $pid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $fontstrip = "<p>{$lang['adjtextsize']}: ";

    if ((bh_session_get_value('FONT_SIZE') > 5) && (bh_session_get_value('FONT_SIZE') < 15)) {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;

        if ($fontsmaller < 5) $fontsmaller = 5;
        if ($fontlarger > 15) $fontlarger = 15;

        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=$fontsmaller\" target=\"_self\">{$lang['smaller']}</a> ";
        $fontstrip.= bh_session_get_value('FONT_SIZE'). " <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=$fontlarger\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }elseif (bh_session_get_value('FONT_SIZE') == 5) {

        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;
        $fontstrip.= "{$lang['smaller']} ". bh_session_get_value('FONT_SIZE'). " <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=6\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }elseif (bh_session_get_value('FONT_SIZE') == 15) {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=14\" target=\"_self\">{$lang['smaller']}</a> ". bh_session_get_value('FONT_SIZE'). " {$lang['larger']}</p>\n";

    }else {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;

        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=9\" target=\"_self\">{$lang['smaller']}</a> ";
        $fontstrip.= "10 <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=11\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }

    echo $fontstrip;
}

function validate_msg($msg)
{
    return preg_match("/^\d{1,}\.\d{1,}$/", rawurldecode($msg));
}

function messages_forum_stats($tid, $pid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $uid = bh_session_get_value("UID");
    $user_show_stats = bh_session_get_value("SHOW_STATS");

    if (forum_get_setting('show_stats', 'Y', false)) {

        echo "<div align=\"center\">\n";
        echo "  <br />\n";
        echo "  <table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "    <tr>\n";
        echo "      <td class=\"subhead\">&nbsp;{$lang['forumstats']}:</td>\n";

        if ($user_show_stats == 1 || $uid == 0) {

            if ($uid != 0) {
                echo "      <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=0&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_hide.png'), "\" border=\"0\" alt=\"{$lang['hide_stats']}\" title=\"{$lang['hide_stats']}\" /></a></td>\n";
            }else {
                echo "      <td class=\"subhead\">&nbsp;</td>\n";
            }

            echo "    </tr>\n";
            echo "    <tr>\n";
            echo "      <td colspan=\"2\">\n";

            if ($user_stats = get_active_users()) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>&nbsp;</td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "          <tr>\n";
                echo "            <td>&nbsp;</td>\n";
                echo "            <td>\n";
                echo "              <b>{$user_stats['GUESTS']}</b> {$lang['guests']}\n";
                echo "              <b>{$user_stats['NUSERS']}</b> {$lang['members']}\n";
                echo "              <b>{$user_stats['AUSERS']}</b> {$lang['anonymousmembers']}\n";
                echo "              [ <a href=\"start.php?webtag=$webtag&amp;show=visitors\" target=\"main\">{$lang['viewcompletelist']}</a> ]\n";
                echo "            </td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";

                if (sizeof($user_stats['USERS']) > 0) {

                    $active_users_array = array();

                    foreach ($user_stats['USERS'] as $user) {

                        $active_user = "<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";
                        $active_user.= str_replace(" ", "&nbsp;", format_user_name($user['LOGON'], $user['NICKNAME'])). "</a>";

                        $active_users_array[] = $active_user;
                    }

                    echo "          <tr>\n";
                    echo "            <td width=\"35\">&nbsp;</td>\n";
                    echo "            <td>&nbsp;</td>\n";
                    echo "            <td width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                    echo "          <tr>";
                    echo "            <td>&nbsp;</td>\n";
                    echo "            <td class=\"activeusers\">\n";
                    echo "              ", implode(", ", $active_users_array), "\n";
                    echo "            </td>\n";
                    echo "            <td width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                }

                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "            <td>{$lang['ourmembershavemadeatotalof']} <b>", number_format(get_thread_count(), 0, ".", ","), "</b> {$lang['threadsand']} <b>", number_format(get_post_count(), 0, ".", ","), "</b> {$lang['postslowercase']}</td>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if ($longest_thread = get_longest_thread()) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>{$lang['longestthreadis']} '<a href=\"?msg={$longest_thread['TID']}.1\">{$longest_thread['TITLE']}</a>' {$lang['with']} <b>", number_format($longest_thread['LENGTH'], 0, ".", ","), "</b> {$lang['postslowercase']}.</td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            if ($recent_posts = get_recent_post_count()) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>&nbsp;</td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>{$lang['therehavebeen']} <b>$recent_posts</b> {$lang['postsmadeinthelastsixtyminutes']}</td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";

                if ($most_posts = get_most_posts()) {

                    if ($most_posts['MOST_POSTS_COUNT'] > 0 && $most_posts['MOST_POSTS_DATE'] > 0) {

                        echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                        echo "          <tr>\n";
                        echo "            <td width=\"35\">&nbsp;</td>\n";
                        echo "            <td>{$lang['mostpostsevermadeinasinglesixtyminuteperiodwas']} <b>", number_format($most_posts['MOST_POSTS_COUNT'], 0, ".", ","), "</b> {$lang['on']} ", format_time($most_posts['MOST_POSTS_DATE'], 1, "M jS Y, g:i A"), "</td>\n";
                        echo "            <td width=\"35\">&nbsp;</td>\n";
                        echo "          </tr>\n";
                        echo "        </table>\n";
                    }
                }
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "            <td>&nbsp;</td>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "          <tr>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "            <td>\n";
            echo "              {$lang['wehave']} <b>", user_count(), "</b> {$lang['registeredmembers']}\n";

            if ($newest_member = get_newest_user()) {

                echo "              {$lang['thenewestmemberis']} <a href=\"javascript:void(0);\" onclick=\"openProfile({$newest_member['UID']}, '$webtag')\" target=\"_self\">", format_user_name($newest_member['LOGON'], $newest_member['NICKNAME']), "</a>.\n";
            }

            echo "            </td>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if ($most_users = get_most_users()) {

                if ($most_users['MOST_USERS_COUNT'] > 0 && $most_users['MOST_USERS_DATE'] > 0) {

                    echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                    echo "          <tr>\n";
                    echo "            <td width=\"35\">&nbsp;</td>\n";
                    echo "            <td>{$lang['mostuserseveronlinewas']} <b>", number_format($most_users['MOST_USERS_COUNT'], 0, ".", ","), "</b> {$lang['on']} ", format_time($most_users['MOST_USERS_DATE'], 1, "M jS Y, g:i A"), "</td>\n";
                    echo "            <td width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                    echo "        </table>\n";
                }
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "            <td>&nbsp;</td>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if (isset($GLOBALS['queries']) && is_array($GLOBALS['queries'])) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "            <td>\n";

                foreach ($GLOBALS['queries'] as $sql => $querytime) {

                    echo "              <p>$sql => $querytime</p>\n";
                }

                echo "            </td>\n";
                echo "            <td width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "            <td>&nbsp;</td>\n";
            echo "            <td width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            echo "      </td>\n";

        }else {

            echo "      <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=1&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_show.png'), "\" border=\"0\" alt=\"{$lang['show_stats']}\" title=\"{$lang['show_stats']}\" /></a></td>\n";
        }

        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</div>\n";
    }
}

?>