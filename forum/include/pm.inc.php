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

/* $Id: pm.inc.php,v 1.85 2004-09-02 21:16:46 decoyduck Exp $ */

include_once("./include/attachments.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/user.inc.php");

function pm_markasread($mid)
{
    $db_pm_markasread = db_connect();
    $uid = bh_session_get_value('UID');

    if (!is_numeric($mid)) return false;

    // ------------------------------------------------------------
    // Update the row so it appears as read to the receipient
    // ------------------------------------------------------------

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PM SET TYPE = ". PM_READ. ", NOTIFIED = 1 ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_markasread);
}

function pm_edit_refuse()
{
    $lang = load_language_file();

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['cannoteditpm']}</p>";
    form_quick_button("./pm.php", $lang['back'], "folder", "2");
    echo "</div>";

}

function pm_error_refuse()
{
    $lang = load_language_file();

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['cannotviewpm']}</p>";
    form_quick_button("./pm.php", $lang['back'], "folder", "1");
    echo "</div>";
}

function pm_add_sentitem($mid)
{
    $db_pm_add_sentitem = db_connect();
    $uid = bh_session_get_value('UID');

    if (!is_numeric($mid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Insert the original PM data as a new row to appear in the
    // sender's sent items
    // ------------------------------------------------------------

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM.TO_UID, ";
    $sql.= "PM.SUBJECT, PM.CREATED, AT.AID FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_CONTENT PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = '$mid' GROUP BY PM.MID LIMIT 0,1";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_row = db_fetch_array($result);

    $sql = "INSERT INTO {$table_data['PREFIX']}PM (REPLY_TO_MID, TYPE, FROM_UID, TO_UID, SUBJECT, CREATED, NOTIFIED) ";
    $sql.= "VALUES ({$db_pm_add_sentitem_row['REPLY_TO_MID']}, ". PM_SENT. ", {$db_pm_add_sentitem_row['FROM_UID']}, ";
    $sql.= "{$db_pm_add_sentitem_row['TO_UID']}, '". addslashes($db_pm_add_sentitem_row['SUBJECT']). "', ";
    $sql.= "'{$db_pm_add_sentitem_row['CREATED']}', 1)";

    $result  = db_query($sql, $db_pm_add_sentitem);
    $new_mid = db_insert_id($db_pm_add_sentitem);

    // ------------------------------------------------------------
    // Insert the original PM content as a new row to appear in
    // the sender's sent items
    // ------------------------------------------------------------

    $sql = "SELECT CONTENT FROM {$table_data['PREFIX']}PM_CONTENT ";
    $sql.= "WHERE MID = '$mid'";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_content_row = db_fetch_array($result);

    $sql = "INSERT INTO {$table_data['PREFIX']}PM_CONTENT (MID, CONTENT) ";
    $sql.= "VALUES ($new_mid, '". addslashes($db_pm_add_sentitem_content_row['CONTENT']). "')";

    $result = db_query($sql, $db_pm_add_sentitem);

    // ------------------------------------------------------------
    // Insert a duplicate attachment ID so that it appears in
    // the sender's Sent Items
    // ------------------------------------------------------------

    if (isset($db_pm_add_sentitem_row['AID']) && get_num_attachments($db_pm_add_sentitem_row['AID'])) {

        $sql = "INSERT INTO {$table_data['PREFIX']}PM_ATTACHMENT_IDS (MID, AID) ";
        $sql.= "VALUES ($new_mid, '{$db_pm_add_sentitem_row['AID']}')";

        $result = db_query($sql, $db_pm_add_sentitem);
    }
}

function pm_get_inbox($offset)
{
    if (!is_numeric($offset)) $offset = 0;

    $db_pm_get_inbox = db_connect();

    $uid = bh_session_get_value('UID');

    $pm_get_inbox_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_INBOX_ITEMS. " AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_get_inbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, AT.AID ";
    $sql.= "FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) WHERE ";
    $sql.= "PM.TYPE = PM.TYPE & ". PM_INBOX_ITEMS. " AND PM.TO_UID = '$uid' ";
    $sql.= "GROUP BY PM.MID ORDER BY CREATED DESC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_inbox);

    if (db_num_rows($result)) {

        while ($result_array = db_fetch_array($result)) {
            $pm_get_inbox_array[] = $result_array;
        }
    }

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_inbox_array);
}

function pm_get_outbox($offset)
{
    if (!is_numeric($offset)) $offset = 0;

    $db_pm_get_outbox = db_connect();

    $uid = bh_session_get_value('UID');

    $pm_get_outbox_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_OUTBOX_ITEMS. " AND FROM_UID = '$uid' ";

    $result = db_query($sql, $db_pm_get_outbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, AT.AID ";
    $sql.= "FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) WHERE ";
    $sql.= "PM.TYPE = PM.TYPE & ". PM_OUTBOX_ITEMS. " AND PM.FROM_UID = '$uid' ";
    $sql.= "GROUP BY PM.MID ORDER BY CREATED DESC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_outbox);

    if (db_num_rows($result)) {

        while ($result_array = db_fetch_array($result)) {
            $pm_get_outbox_array[] = $result_array;
        }
    }

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_outbox_array);
}

function pm_get_sent($offset)
{
    if (!is_numeric($offset)) $offset = 0;

    $db_pm_get_outbox = db_connect();

    $uid = bh_session_get_value('UID');

    $pm_get_outbox_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_SENT_ITEMS. " AND FROM_UID = '$uid' ";

    $result = db_query($sql, $db_pm_get_outbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, AT.AID ";
    $sql.= "FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) WHERE ";
    $sql.= "PM.TYPE = PM.TYPE & ". PM_SENT_ITEMS. " AND PM.FROM_UID = '$uid' ";
    $sql.= "GROUP BY PM.MID ORDER BY CREATED DESC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_outbox);

    if (db_num_rows($result)) {

        while ($result_array = db_fetch_array($result)) {
            $pm_get_outbox_array[] = $result_array;
        }
    }

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_outbox_array);
}

function pm_get_saveditems($offset)
{
    if (!is_numeric($offset)) $offset = 0;

    $db_pm_get_saveditems = db_connect();

    $uid = bh_session_get_value('UID');

    $pm_get_saveditems_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "WHERE (TYPE = ". PM_SAVED_OUT. " AND FROM_UID = '$uid') OR ";
    $sql.= "(TYPE = ". PM_SAVED_IN. " AND TO_UID = '$uid')";

    $result = db_query($sql, $db_pm_get_saveditems);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, AT.AID ";
    $sql.= "FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) WHERE ";
    $sql.= "(PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = '$uid') OR ";
    $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = '$uid')";
    $sql.= "GROUP BY PM.MID ORDER BY CREATED DESC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_saveditems);

    if (db_num_rows($result)) {

        while ($result_array = db_fetch_array($result)) {
            $pm_get_saveditems_array[] = $result_array;
        }
    }

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_saveditems_array);
}

function pm_get_free_space($uid = false)
{
    $db_pm_get_free_space = db_connect();

    if (!$uid) $uid = bh_session_get_value('UID');

    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(MID) AS PM_USER_MESSAGES_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}PM ";
    $sql.= "WHERE ((TYPE & ". PM_INBOX_ITEMS. " > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & ". PM_OUTBOX_ITEMS. " > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & ". PM_SENT_ITEMS. " > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR (TYPE = ". PM_SAVED_OUT. " AND FROM_UID = '$uid') ";
    $sql.= "OR (TYPE = ". PM_SAVED_IN. " AND TO_UID = '$uid')";

    $result = db_query($sql, $db_pm_get_free_space);

    $row = db_fetch_array($result);

    if (isset($row['PM_USER_MESSAGES_COUNT'])) {

        if ($row['PM_USER_MESSAGES_COUNT'] > $pm_max_user_messages) return 0;
        return ($pm_max_user_messages - $row['PM_USER_MESSAGES_COUNT']);
    }

    return $pm_max_user_messages;
}

function pm_get_user($mid)
{
    $db_pm_get_user = db_connect();

    if (!is_numeric($mid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LOGON FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM PM ON (PM.FROM_UID = USER.UID) ";
    $sql.= "WHERE PM.MID = '$mid'";

    $result = db_query($sql, $db_pm_get_user);

    if ($result) {
        $fa = db_fetch_array($result);
        $logon = $fa['LOGON'];
    } else {
        $logon = "";
    }

    return $logon;
}

function pm_user_get_friends()
{
    $db_user_get_relationships = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $relationship = USER_FRIEND;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.RELATIONSHIP & $relationship = $relationship ";
    $sql.= "ORDER BY USER.LOGON ASC LIMIT 0, 20";

    $result = db_query($sql, $db_user_get_relationships);

    $user_get_peers_array = array();

    $user_get_peers_array['uid_array'][] = 0;
    $user_get_peers_array['logon_array'][] = "&lt;select recipient&gt;";

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {
            $user_get_peers_array['uid_array'][] = $row['UID'];
            $user_get_peers_array['logon_array'][] = format_user_name($row['LOGON'], $row['NICKNAME']);
        }

        return $user_get_peers_array;

    }else {

        return false;
    }
}

function pm_get_subject($mid, $tuid)
{
    $db_pm_get_subject = db_connect();

    if (!is_numeric($mid)) return false;
    if (!is_numeric($tuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PM.SUBJECT FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$tuid'";

    $result = db_query($sql, $db_pm_get_subject);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row['SUBJECT'];
    }

    return false;
}

function pm_single_get($mid, $folder)
{
    $db_pm_list_get = db_connect();

    $uid = bh_session_get_value('UID');

    if (!is_numeric($mid)) return false;
    if (!is_numeric($folder)) return false;

    // ------------------------------------------------------------
    // Fetch the single message as specified by the MID
    // ------------------------------------------------------------

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PM.MID, PM.REPLY_TO_MID, PM.TYPE, PM.TO_UID, PM.FROM_UID, ";
    $sql.= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "AT.AID FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN USER TUSER ON (TUSER.UID = PM.TO_UID) ";
    $sql.= "LEFT JOIN USER FUSER ON (FUSER.UID = PM.FROM_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ";
    $sql.= "ON (AT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = '$mid' ";

    if ($folder == PM_FOLDER_INBOX) {
        $sql.= "AND PM.TYPE = PM.TYPE & ". PM_INBOX_ITEMS. " AND PM.TO_UID = '$uid' ";
    }elseif ($folder == PM_FOLDER_SENT) {
        $sql.= "AND PM.TYPE = PM.TYPE & ". PM_SENT_ITEMS. " AND PM.FROM_UID = '$uid' ";
    }elseif ($folder == PM_FOLDER_OUTBOX) {
        $sql.= "AND PM.TYPE = PM.TYPE & ". PM_OUTBOX_ITEMS. " AND PM.FROM_UID = '$uid' ";
    }elseif ($folder == PM_FOLDER_SAVED) {
        $sql.= " AND ((PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = '$uid') OR ";
        $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = '$uid')) ";
    }

    $sql.= "GROUP BY PM.MID LIMIT 0,1";
    $result = db_query($sql, $db_pm_list_get);

    if (db_num_rows($result) > 0) {

        $db_pm_list_get_row = db_fetch_array($result);

        // ------------------------------------------------------------
        // Check to see if we should add a sent item before delete
        // ------------------------------------------------------------

        if (($db_pm_list_get_row['TO_UID'] == $uid) && ($db_pm_list_get_row['TYPE'] == PM_UNREAD)) {

            pm_markasread($db_pm_list_get_row['MID']);

            $user_prefs = user_get_prefs($db_pm_list_get_row['FROM_UID']);

            if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
                pm_add_sentitem($db_pm_list_get_row['MID']);
            }
        }

        return $db_pm_list_get_row;

    }else {
        return false;
    }
}

function pm_get_content($mid)
{
    $db_pm_get_content = db_connect();

    if (!is_numeric($mid)) return false;

    // ------------------------------------------------------------
    // Fetch the message content as specified by the MID
    // ------------------------------------------------------------

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CONTENT FROM {$table_data['PREFIX']}PM_CONTENT ";
    $sql.= "WHERE MID = '$mid'";

    $result = db_query($sql, $db_pm_get_content);
    $pm_content = db_fetch_array($result);

    return isset($pm_content['CONTENT']) ? $pm_content['CONTENT'] : "";
}

function draw_pm_message($pm_elements_array)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $uid = bh_session_get_value('UID');

    echo "<div align=\"center\">\n";
    echo "  <table width=\"96%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "          <tr>\n";

    if (isset($pm_elements_array['FOLDER']) && $pm_elements_array['FOLDER'] == PM_FOLDER_INBOX) {

        echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
        echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['FROM_UID']}, '$webtag')\" target=\"_self\">";
        echo format_user_name($pm_elements_array['FLOGON'], $pm_elements_array['FNICK']), "</a>";
        echo "</span></td>\n";

    }else {

        echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
        echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

        if (is_array($pm_elements_array['TO_UID'])) {

            for ($i = 0; $i < sizeof($pm_elements_array['TO_UID']); $i++) {
                echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID'][$i]}, '$webtag')\" target=\"_self\">";
                echo format_user_name($pm_elements_array['TLOGON'][$i], $pm_elements_array['TNICK'][$i]), "</a>&nbsp;";
            }

        }else {

            echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK']), "</a>";
        }

        echo "</span></td>\n";
    }

    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['subject']}:&nbsp;</span></td>\n";
    echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", apply_wordfilter($pm_elements_array['SUBJECT']), "</span></td>\n";
    echo "            <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">", format_time($pm_elements_array['CREATED']), "&nbsp;</span></td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\">\n";

    if (isset($pm_elements_array['REPLY_TO_MID']) && $pm_elements_array['REPLY_TO_MID'] > 0) {

        echo "          <tr align=\"right\">\n";
        echo "            <td colspan=\"3\"><span class=\"postnumber\">{$lang['inreplyto']} <a href=\"pm.php?webtag=$webtag&amp;mid={$pm_elements_array['REPLY_TO_MID']}\" target=\"_self\">#{$pm_elements_array['REPLY_TO_MID']}</a></span>&nbsp;</td>\n";
        echo "          </tr>\n";

    }else {

        echo "          <tr align=\"right\">\n";
        echo "            <td colspan=\"3\">&nbsp;</td>\n";
        echo "          </tr>\n";
    }

    echo "          <tr>\n";
    echo "            <td class=\"postbody\" align=\"left\">", apply_wordfilter($pm_elements_array['CONTENT']), "</td>\n";
    echo "          </tr>\n";

    if (isset($pm_elements_array['AID'])) {

        $aid = $pm_elements_array['AID'];
        $attachments_array = get_attachments($pm_elements_array['FROM_UID'], $aid);

        if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

            // Draw the attachment header at the bottom of the post

            echo "<tr><td>&nbsp;</td></tr>\n";
            echo "<tr><td class=\"postbody\" align=\"left\">\n";
            echo "<b>{$lang['attachments']}:</b><br />\n";

            foreach($attachments_array as $attachment) {

                echo "<img src=\"", style_image('attach.png'), "\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['attachment']}\" />";

                if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                    echo "<a href=\"getattachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\"";
                }else {
                    echo "<a href=\"getattachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\"";
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

                echo "\">{$attachment['filename']}</a><br />";
            }
            echo "</td></tr>\n";
        }
    }

    echo "          </table>\n";
    echo "          <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "            <tr>\n";
    echo "              <td align=\"center\">\n";

    if (isset($pm_elements_array['FOLDER']) && (isset($pm_elements_array['MID']))) {

        if ($pm_elements_array['FOLDER'] == PM_FOLDER_INBOX) {

            echo "<img src=\"./images/post.png\" height=\"15\" border=\"0\" alt=\"{$lang['reply']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;replyto={$pm_elements_array['MID']}\" target=\"_self\">{$lang['reply']}</a>&nbsp;\n";

        }else {

            echo "&nbsp;";
        }

    }else {

        echo "&nbsp;";
    }

    echo "              </td>\n";
    echo "            </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function draw_header_pm()
{
    $lang = load_language_file();

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function addRecipient() {\n\n";
    echo "    newUser = prompt(\"{$lang['pleaseentermembername']}\", \"\");\n";
    echo "    if (newUser != null && newUser.length > 0) {\n";
    echo "        if (document.f_post.t_recipient_list.value.length == 0) {\n";
    echo "            document.f_post.t_recipient_list.value = newUser;\n";
    echo "        }else {\n";
    echo "            document.f_post.t_recipient_list.value+= '; ' + newUser;\n";
    echo "        }\n";
    echo "    }\n";
    echo "}\n";
    echo "//-->\n";
    echo "</script>\n";
}

function pm_save_attachment_id($mid, $aid)
{

    // ------------------------------------------------------------
    // Save the attachment ID for the PM
    // ------------------------------------------------------------

    if (!is_numeric($mid)) return false;
    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_pm_save_attachment_id = db_connect();
    $sql = "INSERT INTO {$table_data['PREFIX']}PM_ATTACHMENT_IDS (MID, AID) values ('$mid', '$aid')";

    $result = db_query($sql, $db_pm_save_attachment_id);
    return $result;
}

function pm_send_message($tuid, $trmid, $subject, $content)
{
    $db_pm_send_message = db_connect();

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($trmid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $subject = addslashes($subject);
    $content = addslashes($content);

    $fuid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Insert the main PM Data into the database
    // ------------------------------------------------------------

    $sql = "INSERT INTO {$table_data['PREFIX']}PM (TYPE, REPLY_TO_MID, TO_UID, FROM_UID, SUBJECT, CREATED, NOTIFIED) ";
    $sql.= "VALUES (". PM_UNREAD. ", '$trmid', '$tuid', '$fuid', '$subject', NOW(), 0)";

    $result = db_query($sql, $db_pm_send_message);

    if ($result) {

      $new_mid = db_insert_id($db_pm_send_message);

      // ------------------------------------------------------------
      // Insert the PM Content into the database
      // ------------------------------------------------------------

      $sql = "INSERT INTO {$table_data['PREFIX']}PM_CONTENT (MID, CONTENT) ";
      $sql.= "VALUES ('$new_mid', '$content')";

      if (db_query($sql, $db_pm_send_message)) {
          return  $new_mid;
      }

    }

    return false;
}

function pm_edit_message($mid, $subject, $content)
{
    $db_pm_edit_messages = db_connect();

    if (!is_numeric($mid)) return false;

    $subject = addslashes($subject);
    $content = addslashes($content);

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Update the subject text
    // ------------------------------------------------------------

    $sql = "UPDATE {$table_data['PREFIX']}PM SET SUBJECT = '$subject' WHERE MID = '$mid'";
    $result_subject = db_query($sql, $db_pm_edit_messages);

    // ------------------------------------------------------------
    // Update the content
    // ------------------------------------------------------------

    $sql = "UPDATE {$table_data['PREFIX']}PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";
    $result_content = db_query($sql, $db_pm_edit_messages);

    return ($result_subject && $result_content);

}

function pm_delete_message($mid)
{
    $db_delete_pm = db_connect();

    if (!is_numeric($mid)) return false;

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Get the PM data incase the sendee hasn't got a copy of it
    // in his Sent Items folder.
    // ------------------------------------------------------------

    $sql = "SELECT PM.TYPE, PM.TO_UID, PM.FROM_UID, PAF.FILENAME, AT.AID ";
    $sql.= "FROM {$table_data['PREFIX']}PM PM ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_FILES PAF ON (PAF.AID = AT.AID) ";
    $sql.= "WHERE PM.MID = '$mid' GROUP BY PM.MID LIMIT 0,1";

    $result = db_query($sql, $db_delete_pm);
    $db_delete_pm_row = db_fetch_array($result);

    // ------------------------------------------------------------
    // Add the Sent Item
    // ------------------------------------------------------------

    if (($db_delete_pm_row['TO_UID'] == $uid) && ($db_delete_pm_row['TYPE'] == PM_UNREAD)) {

        pm_markasread($mid);

        $user_prefs = user_get_prefs($db_pm_list_get_row['FROM_UID']);

        if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
            pm_add_sentitem($mid);
        }
    }

    // ------------------------------------------------------------
    // If it is the author deleting his Sent Item then
    // delete the attachment as well.
    // ------------------------------------------------------------

    if ($db_delete_pm_row['TYPE'] == PM_SENT && isset($db_delete_pm_row['AID']) && get_num_attachments($db_delete_pm_row['AID']) > 0) {
        delete_attachment_by_aid($db_delete_pm_row['AID']);
    }

    $sql = "DELETE FROM {$table_data['PREFIX']}PM WHERE MID = '$mid'";
    $result = db_query($sql, $db_delete_pm);

    $sql = "DELETE FROM {$table_data['PREFIX']}PM_CONTENT WHERE MID = '$mid'";
    return db_query($sql, $db_delete_pm);

}

function pm_archive_message($mid)
{
    $db_pm_archive_message = db_connect();

    if (!is_numeric($mid)) return false;

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Check to see if the the sender need an item in
    // his Sent Items folder.
    // ------------------------------------------------------------

    $sql = "SELECT * FROM {$table_data['PREFIX']}PM WHERE MID = '$mid'";

    $result = db_query($sql, $db_pm_archive_message);

    $db_pm_archive_message_row = db_fetch_array($result);

    if (($db_pm_archive_message_row['TO_UID'] == $uid) && ($db_pm_archive_message_row['TYPE'] == PM_UNREAD)) {

        pm_markasread($mid);

        $user_prefs = user_get_prefs($db_pm_list_get_row['FROM_UID']);

        if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
            pm_add_sentitem($mid);
        }
    }

    // ------------------------------------------------------------
    // Archive any PM that are in the User's Inbox
    // ------------------------------------------------------------

    $sql = "UPDATE {$table_data['PREFIX']}PM SET TYPE = ". PM_SAVED_IN. " ";
    $sql.= "WHERE MID = '$mid' AND (TYPE = ". PM_READ. " OR TYPE = ". PM_UNREAD. ") ";
    $sql.= "AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_archive_message);

    // ------------------------------------------------------------
    // Archive any PM that are in the User's Sent Items
    // ------------------------------------------------------------

    $sql = "UPDATE {$table_data['PREFIX']}PM SET TYPE = ". PM_SAVED_OUT. " ";
    $sql.= "WHERE MID = '$mid' AND TYPE = ". PM_SENT. " AND FROM_UID = '$uid'";

    $result = db_query($sql, $db_pm_archive_message);
}

function pm_new_check()
{
    $db_pm_new_check = db_connect();
    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Check to see if the user has any new PMs
    // ------------------------------------------------------------

    $sql = "SELECT MID FROM {$table_data['PREFIX']}PM ";
    $sql.= "WHERE NOTIFIED = 0 AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_new_check);

    $num_rows = db_num_rows($result);

    // ------------------------------------------------------------
    // We only want to notify the user once per every new
    // messages that arrives and NOT every time they reload
    // the page, so set all NEW messages to UNREAD.
    // ------------------------------------------------------------

    $sql = "UPDATE {$table_data['PREFIX']}PM SET NOTIFIED = 1 ";
    $sql.= "WHERE NOTIFIED = 0 AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_new_check);

    return ($num_rows > 0);
}

function pm_get_unread_count()
{
    $db_pm_get_unread_count = db_connect();
    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    // ------------------------------------------------------------
    // Check to see if the user has any new PMs
    // ------------------------------------------------------------

    $sql = "SELECT MID FROM {$table_data['PREFIX']}PM ";
    $sql.= "WHERE TYPE = ". PM_UNREAD. " AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_get_unread_count);
    return db_num_rows($result);
}

?>