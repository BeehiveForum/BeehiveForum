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

/* $Id: pm.inc.php,v 1.151 2006-08-08 20:45:31 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

/**
* Check that the PM system is enabled.
*
* Checks the FORUM_SETTINGS to make sure the PM system is enabled.
*
* @return bool
* @param void
*/

function pm_enabled()
{
    $lang = load_language_file();

    if (!forum_get_setting('show_pms', 'Y')) {

        html_draw_top();
        echo "<h1>{$lang['pmshavebeendisabled']}</h1>\n";
        html_draw_bottom();
        exit;
    }
}

/**
* Mark message mead
*
* Marks the specified message ID as read.
*
* @return void
* @param integer $mid - Message ID
*/

function pm_markasread($mid)
{
    $db_pm_markasread = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    $sql = "UPDATE PM SET TYPE = ". PM_READ. ", NOTIFIED = 1 ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_markasread);
}

/**
* Display edit refuse eroor
*
* Displays an error messages when the user attempts to edit a message
* that has already received by the recipient.
*
* @return void
* @param void
*/

function pm_edit_refuse()
{
    $lang = load_language_file();

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['cannoteditpm']}</p>";
    echo form_quick_button("./pm.php", $lang['back'], "folder", "2");
    echo "</div>";

}

/**
* Display view refuse error
*
* Displays and error message when the user attempts to view a message
* that doesn't not below to them.
*
* @return void
* @param void
*/

function pm_error_refuse()
{
    $lang = load_language_file();

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['cannotviewpm']}</p>";
    echo form_quick_button("./pm.php", $lang['back'], "folder", "1");
    echo "</div>";
}

/**
* Add Sent Item
*
* Duplicates the specified message and saves it in the user's sent items folder
*
* @return mixed
* @param integer $mid - Message ID of the message to duplicate
*/

function pm_add_sentitem($mid)
{
    $db_pm_add_sentitem = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    // Fetch the message from the database

    $sql = "SELECT PM.MID, PM.FROM_UID, PM.TO_UID, ";
    $sql.= "PM.SUBJECT, PM.CREATED, AT.AID FROM PM PM ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = '$mid' GROUP BY PM.MID LIMIT 0,1";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_row = db_fetch_array($result);

    // Insert it as a new message

    $sql = "INSERT INTO PM (TYPE, FROM_UID, TO_UID, SUBJECT, CREATED, NOTIFIED) ";
    $sql.= "VALUES (". PM_SENT. ", {$db_pm_add_sentitem_row['FROM_UID']}, ";
    $sql.= "{$db_pm_add_sentitem_row['TO_UID']}, '". addslashes($db_pm_add_sentitem_row['SUBJECT']). "', ";
    $sql.= "'{$db_pm_add_sentitem_row['CREATED']}', 1)";

    $result  = db_query($sql, $db_pm_add_sentitem);

    // Get the new message ID

    $new_mid = db_insert_id($db_pm_add_sentitem);

    // Fetch the content from the database

    $sql = "SELECT CONTENT FROM PM_CONTENT ";
    $sql.= "WHERE MID = '$mid'";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_content_row = db_fetch_array($result);

    // Insert the content with the new message ID

    $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
    $sql.= "VALUES ($new_mid, '". addslashes($db_pm_add_sentitem_content_row['CONTENT']). "')";

    $result = db_query($sql, $db_pm_add_sentitem);

    // Check and process any attachments.

    if (isset($db_pm_add_sentitem_row['AID']) && get_num_attachments($db_pm_add_sentitem_row['AID'])) {

        $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
        $sql.= "VALUES ($new_mid, '{$db_pm_add_sentitem_row['AID']}')";

        $result = db_query($sql, $db_pm_add_sentitem);
    }
}

/**
* Get Inbox
*
* Gets the contents of the user's inbox.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_inbox($offset = false)
{
    $db_pm_get_inbox = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($offset)) $offset = false;

    $pm_get_inbox_array = array();
    $mid_array = array();

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_INBOX_ITEMS. " AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_get_inbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.PEER_UID = FUSER.UID AND USER_PEER_FROM.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.PEER_UID = TUSER.UID AND USER_PEER_TO.UID = '$uid') ";
    $sql.= "WHERE PM.TYPE = PM.TYPE & ". PM_INBOX_ITEMS. " AND PM.TO_UID = '$uid' ";
    $sql.= "ORDER BY CREATED DESC ";
    
    if (is_numeric($offset)) $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_inbox);

    if (db_num_rows($result) > 0) {

        while ($result_array = db_fetch_array($result, DB_RESULT_ASSOC)) {

            if (isset($result_array['PFNICK'])) {
                if (!is_null($result_array['PFNICK']) && strlen($result_array['PFNICK']) > 0) {
                    $result_array['FNICK'] = $result_array['PFNICK'];
                }
            }

            if (isset($result_array['PTNICK'])) {
                if (!is_null($result_array['PTNICK']) && strlen($result_array['PTNICK']) > 0) {
                    $result_array['TNICK'] = $result_array['PTNICK'];
                }
            }

            $pm_get_inbox_array[$result_array['MID']] = $result_array;
            $mid_array[] = $result_array['MID'];
        }

    }else if ($offset > 0) {

        return pm_get_inbox($offset - 10);
    }

    pms_have_attachments($pm_get_inbox_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_inbox_array);
}

/**
* Get Outbox
*
* Gets the contents of the user's outbox.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_outbox($offset = false)
{
    $db_pm_get_outbox = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($offset)) $offset = false;

    $pm_get_outbox_array = array();
    $mid_array = array();

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_OUTBOX_ITEMS. " AND FROM_UID = '$uid' ";

    $result = db_query($sql, $db_pm_get_outbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.PEER_UID = FUSER.UID AND USER_PEER_FROM.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.PEER_UID = TUSER.UID AND USER_PEER_TO.UID = '$uid') ";
    $sql.= "WHERE PM.TYPE = PM.TYPE & ". PM_OUTBOX_ITEMS. " AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY CREATED DESC ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_outbox);

    if (db_num_rows($result) > 0) {

        while ($result_array = db_fetch_array($result, DB_RESULT_ASSOC)) {

            if (isset($result_array['PFNICK'])) {
                if (!is_null($result_array['PFNICK']) && strlen($result_array['PFNICK']) > 0) {
                    $result_array['FNICK'] = $result_array['PFNICK'];
                }
            }

            if (isset($result_array['PTNICK'])) {
                if (!is_null($result_array['PTNICK']) && strlen($result_array['PTNICK']) > 0) {
                    $result_array['TNICK'] = $result_array['PTNICK'];
                }
            }

            $pm_get_outbox_array[$result_array['MID']] = $result_array;
            $mid_array[] = $result_array['MID'];
        }

    }else if ($offset > 0) {

        return pm_get_outbox($offset - 10);
    }

    pms_have_attachments($pm_get_outbox_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_outbox_array);
}

/**
* Get Sent Items
*
* Gets the contents of the user's sent items.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_sent($offset = false)
{
    $db_pm_get_outbox = db_connect();

    if (!$table_data = get_table_prefix()) return false;
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($offset)) $offset = false;

    $pm_get_sent_array = array();
    $mid_array = array();

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM PM PM ";
    $sql.= "WHERE TYPE = TYPE & ". PM_SENT_ITEMS. " AND FROM_UID = '$uid' ";

    $result = db_query($sql, $db_pm_get_outbox);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.PEER_UID = FUSER.UID AND USER_PEER_FROM.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.PEER_UID = TUSER.UID AND USER_PEER_TO.UID = '$uid') ";
    $sql.= "WHERE PM.TYPE = PM.TYPE & ". PM_SENT_ITEMS. " AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY CREATED DESC ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_outbox);

    if (db_num_rows($result) > 0) {

        while ($result_array = db_fetch_array($result, DB_RESULT_ASSOC)) {

            if (isset($result_array['PFNICK'])) {
                if (!is_null($result_array['PFNICK']) && strlen($result_array['PFNICK']) > 0) {
                    $result_array['FNICK'] = $result_array['PFNICK'];
                }
            }

            if (isset($result_array['PTNICK'])) {
                if (!is_null($result_array['PTNICK']) && strlen($result_array['PTNICK']) > 0) {
                    $result_array['TNICK'] = $result_array['PTNICK'];
                }
            }

            $pm_get_sent_array[$result_array['MID']] = $result_array;
            $mid_array[] = $result_array['MID'];
        }

    }else if ($offset > 0) {

        return pm_get_sent($offset - 10);
    }

    pms_have_attachments($pm_get_sent_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_sent_array);
}

/**
* Get Saved Items
*
* Gets the contents of the user's Saved Items.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_saveditems($offset = false)
{
    $db_pm_get_saveditems = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($offset)) $offset = false;

    $pm_get_saveditems_array = array();
    $mid_array = array();

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT FROM PM PM ";
    $sql.= "WHERE (TYPE = ". PM_SAVED_OUT. " AND FROM_UID = '$uid') OR ";
    $sql.= "(TYPE = ". PM_SAVED_IN. " AND TO_UID = '$uid')";

    $result = db_query($sql, $db_pm_get_saveditems);

    $result_array  = db_fetch_array($result);
    $message_count = $result_array['MESSAGE_COUNT'];

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.PEER_UID = FUSER.UID AND USER_PEER_FROM.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.PEER_UID = TUSER.UID AND USER_PEER_TO.UID = '$uid') ";
    $sql.= "WHERE (PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = '$uid') OR ";
    $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = '$uid')";
    $sql.= "ORDER BY CREATED DESC ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_pm_get_saveditems);

    if (db_num_rows($result) > 0) {

        while ($result_array = db_fetch_array($result, DB_RESULT_ASSOC)) {

            if (isset($result_array['PFNICK'])) {
                if (!is_null($result_array['PFNICK']) && strlen($result_array['PFNICK']) > 0) {
                    $result_array['FNICK'] = $result_array['PFNICK'];
                }
            }

            if (isset($result_array['PTNICK'])) {
                if (!is_null($result_array['PTNICK']) && strlen($result_array['PTNICK']) > 0) {
                    $result_array['TNICK'] = $result_array['PTNICK'];
                }
            }

            $pm_get_saveditems_array[$result_array['MID']] = $result_array;
            $mid_array[] = $result_array['MID'];
        }

    }else if ($offset > 0) {

        return pm_get_saveditems($offset - 10);
    }

    pms_have_attachments($pm_get_saveditems_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_saveditems_array);
}

/**
* Get Messages Free Space
*
* Calculates and returns the free space available to the user to
* store messages.
*
* @return mixed - false on failure, integer on success
* @param integer $uid - Optional user ID for finding space of another user.
*/

function pm_get_free_space($uid = false)
{
    $db_pm_get_free_space = db_connect();

    if ($uid === false) {
        if (($uid = bh_session_get_value('UID')) === false) return false;
    }

    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);

    $sql = "SELECT COUNT(MID) AS PM_USER_MESSAGES_COUNT ";
    $sql.= "FROM PM ";
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

/**
* Get User
*
* Gets the logon of the user who sent the message
*
* @return string - Logon of the sender
* @param integer $mid - Message ID of the received message.
*/

function pm_get_user($mid)
{
    $db_pm_get_user = db_connect();

    if (!is_numeric($mid)) return false;

    $sql = "SELECT USER.LOGON FROM PM PM ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = PM.FROM_UID) ";
    $sql.= "WHERE PM.MID = $mid";

    $result = db_query($sql, $db_pm_get_user);

    if ($result) {
        $fa = db_fetch_array($result);
        $logon = $fa['LOGON'];
    } else {
        $logon = "";
    }

    return $logon;
}

/**
* Get's Friends
*
* Get's the users friends from their relationships
*
* @return mixed - false on failure, array of UIDs and Logons on success
*/

function pm_user_get_friends()
{
    $db_pm_user_get_friends = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $user_rel = USER_FRIEND;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = USER_PEER.PEER_UID) ";
    $sql.= "WHERE USER_PEER.UID = $uid AND (USER_PEER.RELATIONSHIP & $user_rel > 0) ";
    $sql.= "LIMIT 0, 20";

    $result = db_query($sql, $db_pm_user_get_friends);

    $user_get_peers_array = array();

    $user_get_peers_array['uid_array'][] = 0;
    $user_get_peers_array['logon_array'][] = "&lt;select recipient&gt;";

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            if (isset($row['PEER_NICKNAME'])) {
                if (!is_null($row['PEER_NICKNAME']) && strlen($row['PEER_NICKNAME']) > 0) {
                    $row['NICKNAME'] = $row['PEER_NICKNAME'];
                }
            }

            $user_get_peers_array['uid_array'][] = $row['UID'];
            $user_get_peers_array['logon_array'][] = format_user_name($row['LOGON'], $row['NICKNAME']);
        }

        return $user_get_peers_array;

    }else {

        return false;
    }
}

/**
* Get Subject
*
* Gets the subject of the specified message ID.
*
* @return mixed - false on failure, message subject as string on success
* @param integer $mid - Message ID.
* @param integer $tuid - Recepient UID.
*/

function pm_get_subject($mid, $tuid)
{
    $db_pm_get_subject = db_connect();

    if (!is_numeric($mid)) return false;
    if (!is_numeric($tuid)) return false;

    $sql = "SELECT PM.SUBJECT FROM PM PM ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$tuid'";

    $result = db_query($sql, $db_pm_get_subject);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row['SUBJECT'];
    }

    return false;
}

/**
* Get a single PM
*
* Gets a single PM from the database
*
* @return mixed - false on failure, array on success
* @param integer $mid - Message ID to fetch
* @param integer $folder - Folder that the message resides in
*/

function pm_single_get($mid, $folder)
{
    $db_pm_list_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;
    if (!is_numeric($folder)) return false;

    // Fetch the single message as specified by the MID

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.PEER_UID = FUSER.UID AND USER_PEER_FROM.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.PEER_UID = TUSER.UID AND USER_PEER_TO.UID = '$uid') ";
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

    $sql.= "LIMIT 0,1";

    $result = db_query($sql, $db_pm_list_get);

    if (db_num_rows($result) > 0) {

        $db_pm_list_get_row = db_fetch_array($result, DB_RESULT_ASSOC);

        if (isset($db_pm_list_get_row['PFNICK'])) {
            if (!is_null($db_pm_list_get_row['PFNICK']) && strlen($db_pm_list_get_row['PFNICK']) > 0) {
                $db_pm_list_get_row['FNICK'] = $db_pm_list_get_row['PFNICK'];
            }
        }

        if (isset($db_pm_list_get_row['PTNICK'])) {
            if (!is_null($db_pm_list_get_row['PTNICK']) && strlen($db_pm_list_get_row['PTNICK']) > 0) {
                $db_pm_list_get_row['TNICK'] = $db_pm_list_get_row['PTNICK'];
            }
        }

        // Check to see if we should add a sent item before delete

        if (($db_pm_list_get_row['TO_UID'] == $uid) && ($db_pm_list_get_row['TYPE'] == PM_UNREAD) && ($folder == PM_FOLDER_INBOX)) {

            pm_markasread($db_pm_list_get_row['MID']);

            $user_prefs = user_get_prefs($db_pm_list_get_row['FROM_UID']);

            if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
                pm_add_sentitem($db_pm_list_get_row['MID']);
            }
        }

        if ($aid = pm_has_attachments($mid)) {
            $db_pm_list_get_row['AID'] = $aid;
        }

        return $db_pm_list_get_row;

    }else {
        return false;
    }
}

/**
* Get Content
*
* Gets the content of the specified message
*
* @return mixed - false on failure, string containing message content on success
* @param integer $mid - Message ID to fetch.
*/

function pm_get_content($mid)
{
    $db_pm_get_content = db_connect();

    if (!is_numeric($mid)) return false;

    // Fetch the message content as specified by the MID

    $sql = "SELECT CONTENT FROM PM_CONTENT ";
    $sql.= "WHERE MID = '$mid'";

    $result = db_query($sql, $db_pm_get_content);
    $pm_content = db_fetch_array($result);

    return isset($pm_content['CONTENT']) ? $pm_content['CONTENT'] : "";
}

/**
* Display or return PM HTML.
*
* Displays or returns the PM HTML formatted for display in the browser
*
* @return mixed - string or bool depending on $pm_export_html setting.
* @param bool $pm_export_html - Optional settings allows return of HTML as string instead of sending to STDOUT.
*/

function pm_display($pm_elements_array, $pm_export_html = false)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $html = "<div align=\"center\">\n";
    $html.= "  <table width=\"96%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    $html.= "    <tr>\n";
    $html.= "      <td>\n";
    $html.= "        <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    $html.= "          <tr>\n";

    if (isset($pm_elements_array['FOLDER']) && $pm_elements_array['FOLDER'] == PM_FOLDER_INBOX) {

        $html.= "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
        $html.= "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

        if ($pm_export_html === true) {

            $html.= format_user_name($pm_elements_array['FLOGON'], $pm_elements_array['FNICK']);

        }else {

            $html.= "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['FROM_UID']}, '$webtag')\" target=\"_self\">";
            $html.= format_user_name($pm_elements_array['FLOGON'], $pm_elements_array['FNICK']). "</a>";
            $html.= "</span></td>\n";
        }

    }else {

        $html.= "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
        $html.= "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

        if (is_array($pm_elements_array['TO_UID'])) {

            for ($i = 0; $i < sizeof($pm_elements_array['TO_UID']); $i++) {

                if ($pm_export_html === true) {

                    $html.= format_user_name($pm_elements_array['TLOGON'][$i], $pm_elements_array['TNICK'][$i]);

                }else {
                
                    $html.= "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID'][$i]}, '$webtag')\" target=\"_self\">";
                    $html.= format_user_name($pm_elements_array['TLOGON'][$i], $pm_elements_array['TNICK'][$i]). "</a>&nbsp;";
                }
            }

        }else {

            if ($pm_export_html === true) {

                $html.= format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK']);
            
            }else {

                $html.= "<a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID']}, '$webtag')\" target=\"_self\">";
                $html.= format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK']). "</a>";
            }
        }

        $html.= "</span></td>\n";
    }

    // Check for words that should be filtered

    $pm_export_wordfilter = bh_session_get_value('PM_EXPORT_WORDFILTER');

    if ($pm_export_wordfilter == 'Y' || $pm_export_html === false) {

        $pm_elements_array['CONTENT'] = apply_wordfilter($pm_elements_array['CONTENT']);
        $pm_elements_array['SUBJECT'] = apply_wordfilter($pm_elements_array['SUBJECT']);
    }

    // Add emoticons/wikilinks

    $pm_elements_array['CONTENT'] = message_split_fiddle($pm_elements_array['CONTENT']);


    $html.= "          </tr>\n";
    $html.= "          <tr>\n";
    $html.= "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['subject']}:&nbsp;</span></td>\n";
    $html.= "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">{$pm_elements_array['SUBJECT']}</span></td>\n";

    if ($pm_export_html === true) {
        $html.= "            <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">". format_time($pm_elements_array['CREATED'], true). "&nbsp;</span></td>\n";
    }else {
        $html.= "            <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">". format_time($pm_elements_array['CREATED']). "&nbsp;</span></td>\n";
    }

    $html.= "          </tr>\n";
    $html.= "        </table>\n";
    $html.= "      </td>\n";
    $html.= "    </tr>\n";
    $html.= "    <tr>\n";
    $html.= "      <td>\n";
    $html.= "        <table width=\"100%\">\n";
    $html.= "          <tr align=\"right\">\n";
    $html.= "            <td colspan=\"3\">&nbsp;</td>\n";
    $html.= "          </tr>\n";
    $html.= "          <tr>\n";
    $html.= "            <td class=\"postbody\" align=\"left\">{$pm_elements_array['CONTENT']}</td>\n";
    $html.= "          </tr>\n";

    if (isset($pm_elements_array['AID'])) {

        $aid = $pm_elements_array['AID'];

        if (get_attachments($pm_elements_array['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            // Draw the attachment header at the bottom of the post

            $html.= "          <tr>\n";
            $html.= "            <td class=\"postbody\" align=\"left\">\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                $html.= "                  <p><b>{$lang['attachments']}:</b><br />\n";

                foreach($attachments_array as $attachment) {

                    $html.= "                  ". attachment_make_link($attachment, true, false, $pm_export_html). "\n";
                }

                $html.= "                  </p>\n";
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                $html.= "                  <p><b>{$lang['imageattachments']}:</b><br />\n";

                foreach($image_attachments_array as $key => $attachment) {

                    $html.= "                  ". attachment_make_link($attachment, true, false, $pm_export_html). "\n";
                }

                $html.= "                  </p>\n";
            }

            $html.= "            </td>\n";
            $html.= "          </tr>\n";
        }
    }

    $html.= "        </table>\n";
    $html.= "        <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
    $html.= "          <tr>\n";

    if (isset($pm_elements_array['FOLDER']) && (isset($pm_elements_array['MID'])) && $pm_export_html === false) {

        if ($pm_elements_array['FOLDER'] == PM_FOLDER_INBOX) {

            $html.= "            <td align=\"center\"><img src=\"". style_image('post.png'). "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;replyto={$pm_elements_array['MID']}\" target=\"_self\">{$lang['reply']}</a></td>\n";

        }else {

            $html.= "            <td align=\"center\">&nbsp;</td>\n";
        }

    }else {

        $html.= "            <td align=\"center\">&nbsp;</td>\n";
    }

    $html.= "          </tr>\n";
    $html.= "        </table>\n";
    $html.= "      </td>\n";
    $html.= "    </tr>\n";
    $html.= "  </table>\n";
    $html.= "</div>\n";

    if ($pm_export_html) return $html;

    echo $html;
}

/**
* Draw header
*
* Draw Javascript header at top of PM send page
*
* @return void
* @param void
*/

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

/**
* Save Attachment ID
*
* Save the assigned attachment ID to the PM
*
* @return bool
* @param integer $mid - Message ID
* @param md5 $aid - Message attachment ID
*/

function pm_save_attachment_id($mid, $aid)
{
    if (!is_numeric($mid)) return false;
    if (!is_md5($aid)) return false;

    $db_pm_save_attachment_id = db_connect();

    $sql = "UPDATE PM_ATTACHMENT_IDS SET AID = '$aid' ";
    $sql.= "WHERE MID = $mid";

    if (!db_query($sql, $db_pm_save_attachment_id)) return false;

    if (db_affected_rows($db_pm_save_attachment_id) < 1) {
    
        $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
        $sql.= "VALUES ($mid, '$aid')";

        if (!db_query($sql, $db_pm_save_attachment_id)) return false;
    }

    return true;
}

/**
* Send Message
*
* Sends a message with specified sender, recipient, subject and content
*
* @return mixed - false on failure, integer Message ID on success
* @param integer $tuid - Sender UID
* @param integer $fuid - Recipient UID
* @param string $subject - Subject string
* @param string $content - Content string
*/

function pm_send_message($tuid, $fuid, $subject, $content)
{
    $db_pm_send_message = db_connect();

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    $subject = addslashes($subject);
    $content = addslashes($content);

    // Insert the main PM Data into the database

    $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, CREATED, NOTIFIED) ";
    $sql.= "VALUES (". PM_UNREAD. ", '$tuid', '$fuid', '$subject', NOW(), 0)";

    $result = db_query($sql, $db_pm_send_message);

    if ($result) {

        $new_mid = db_insert_id($db_pm_send_message);

        // Insert the PM Content into the database

        $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
        $sql.= "VALUES ('$new_mid', '$content')";

        if (db_query($sql, $db_pm_send_message)) {
            return  $new_mid;
        }
    }

    return false;
}

/**
* Edit Message
*
* Edit a message content and subject
*
* @return bool - true on success, false on failure.
* @param integer $mid - Message ID to edit
* @param string $subject - New subject for message
* @param string $content - New content for message
*/

function pm_edit_message($mid, $subject, $content)
{
    $db_pm_edit_messages = db_connect();

    if (!is_numeric($mid)) return false;

    $subject = addslashes($subject);
    $content = addslashes($content);

    // Update the subject text

    $sql = "UPDATE PM SET SUBJECT = '$subject' WHERE MID = '$mid'";
    $result_subject = db_query($sql, $db_pm_edit_messages);

    // Update the content

    $sql = "UPDATE PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";
    $result_content = db_query($sql, $db_pm_edit_messages);

    return ($result_subject && $result_content);
}

/**
* Delete a message
*
* Deletes the specified message
*
* @return bool - True on success, False on failure.
* @param integer $mid - Message ID to delete
*/

function pm_delete_message($mid)
{
    $db_delete_pm = db_connect();

    if (!is_numeric($mid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Get the PM data incase the sendee hasn't got a copy of it
    // in his Sent Items folder.

    $sql = "SELECT PM.TYPE, PM.TO_UID, PM.FROM_UID, PAF.FILENAME, AT.AID ";
    $sql.= "FROM PM PM ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = AT.AID) ";
    $sql.= "WHERE PM.MID = '$mid' GROUP BY PM.MID LIMIT 0,1";

    $result = db_query($sql, $db_delete_pm);
    $db_delete_pm_row = db_fetch_array($result);

    // Add the Sent Item

    if (($db_delete_pm_row['TO_UID'] == $uid) && ($db_delete_pm_row['TYPE'] == PM_UNREAD)) {

        pm_markasread($mid);

        $user_prefs = user_get_prefs($db_delete_pm_row['FROM_UID']);

        if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
            pm_add_sentitem($mid);
        }
    }

    // If it is the author deleting his Sent Item then
    // delete the attachment as well.

    if ($db_delete_pm_row['TYPE'] == PM_SENT && isset($db_delete_pm_row['AID']) && get_num_attachments($db_delete_pm_row['AID']) > 0) {
        delete_attachment_by_aid($db_delete_pm_row['AID']);
    }

    $sql = "DELETE FROM PM WHERE MID = '$mid'";
    $result = db_query($sql, $db_delete_pm);

    $sql = "DELETE FROM PM_CONTENT WHERE MID = '$mid'";
    return db_query($sql, $db_delete_pm);

}

/**
* Archive a messages
*
* Archives the specified message to the user's Saved Items folder
*
* @return bool - True on success, False on failure.
* @param integer $mid - Message ID to delete
*/

function pm_archive_message($mid)
{
    $db_pm_archive_message = db_connect();

    if (!is_numeric($mid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Check to see if the the sender need an item in
    // his Sent Items folder.

    $sql = "SELECT * FROM PM WHERE MID = '$mid'";
    $result = db_query($sql, $db_pm_archive_message);

    $db_pm_archive_message_row = db_fetch_array($result);

    if (($db_pm_archive_message_row['TO_UID'] == $uid) && ($db_pm_archive_message_row['TYPE'] == PM_UNREAD)) {

        pm_markasread($mid);

        $user_prefs = user_get_prefs($db_pm_list_get_row['FROM_UID']);

        if (!isset($user_prefs['PM_SAVE_SENT_ITEM']) || $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {
            pm_add_sentitem($mid);
        }
    }

    // Archive any PM that are in the User's Inbox

    $sql = "UPDATE PM SET TYPE = ". PM_SAVED_IN. " ";
    $sql.= "WHERE MID = '$mid' AND (TYPE = ". PM_READ. " OR TYPE = ". PM_UNREAD. ") ";
    $sql.= "AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_archive_message);

    // Archive any PM that are in the User's Sent Items

    $sql = "UPDATE PM SET TYPE = ". PM_SAVED_OUT. " ";
    $sql.= "WHERE MID = '$mid' AND TYPE = ". PM_SENT. " AND FROM_UID = '$uid'";

    $result = db_query($sql, $db_pm_archive_message);
}

/**
* Check for new messages
*
* Check's to see if the current user (uses BH Session data) has any new messages.
*
* @return integer - number of new messages.
* @param void.
*/

function pm_new_check()
{
    $db_pm_new_check = db_connect();
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    // We only want to notify the user once even if they've
    // received more than 1 message so we do an UPDATE and
    // check the affected rows.

    $sql = "UPDATE PM SET NOTIFIED = 1 WHERE NOTIFIED = 0 AND TO_UID = '$uid'";
    $result = db_query($sql, $db_pm_new_check);

    $pm_new_count = db_affected_rows($db_pm_new_check);

    return ($pm_new_count > 0) ? $pm_new_count : false;
}

/**
* Get unread message count
*
* Gets the number of messages the user has yet to read / view.
*
* @return integer - number of unread messages.
* @param void
*/

function pm_get_unread_count()
{
    $db_pm_get_unread_count = db_connect();
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Guests don't do PMs.

    if ($uid == 0) return false;

    // Check to see if the user has any new PMs

    $sql = "SELECT COUNT(MID) FROM PM ";
    $sql.= "WHERE TYPE = ". PM_UNREAD. " AND TO_UID = '$uid'";

    $result = db_query($sql, $db_pm_get_unread_count);
    list($pm_unread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $pm_unread_count;
}

/**
* Prune user folders
*
* Function to prune the current user's PM Folders Takes an optional UID parameter.
* If not specified it uses the current user's UID.
*
* @return bool - True on success, False on failure.
* @param integer $uid - Optional UID of user who's folder we want to clear.
*/

function pm_user_prune_folders($uid = false)
{
    $db_pm_prune_folders = db_connect();

    if ($uid === false) {
        if (($uid = bh_session_get_value('UID')) === false) return false;
    }

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) {

        $pm_prune_length = intval($user_prefs['PM_AUTO_PRUNE']);
        $pm_prune_length = time() - ($pm_prune_length * DAY_IN_SECONDS);

        $sql = "DELETE LOW_PRIORITY FROM PM WHERE ";
        $sql.= "((TYPE = TYPE & ". PM_READ. " AND TO_UID = '$uid') ";
        $sql.= "OR (TYPE = TYPE & ". PM_SENT_ITEMS. " AND FROM_UID = '$uid')) ";
        $sql.= "AND CREATED < FROM_UNIXTIME($pm_prune_length)";

        if (!$result = db_query($sql, $db_pm_prune_folders)) return false;
    }

    return true;
}

/**
* Prune all user's folders
*
* Function to prune all user's PM Folders based on the FORUM_SETTINGS setting.
*
* @return bool - True on success, False on failure.
* @param void
*/

function pm_system_prune_folders()
{
    $db_pm_prune_folders = db_connect();

    $pm_prune_prob = intval(forum_get_setting('forum_self_clean_prob', false, 20));

    if ($pm_prune_prob < 1) $pm_prune_prob = 1;
    if ($pm_prune_prob > 100) $pm_prune_prob = 100;

    if (($mt_result = mt_rand(1, $pm_prune_prob)) == 1) {

        $pm_prune_length = intval(forum_get_setting('pm_auto_prune', false, 0));

        if ($pm_prune_length > 0) {

            $pm_prune_length = time() - ($pm_prune_length * DAY_IN_SECONDS);

            $sql = "DELETE LOW_PRIORITY FROM PM WHERE ";
            $sql.= "((TYPE = TYPE & ". PM_READ. ") ";
            $sql.= "OR (TYPE = TYPE & ". PM_SENT_ITEMS. ")) ";
            $sql.= "AND CREATED < FROM_UNIXTIME($pm_prune_length)";

            if (!$result = db_query($sql, $db_pm_prune_folders)) return false;

            return true;
        }
    }

    return false;
}

/**
* Check auto-prune option
*
* Checks to see if the auto-prune option is enabled either at the user
* level or by the admin globally.
*
* @return bool - True on success, False on failure.
* @param void.
*/

function pm_auto_prune_enabled()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) return true;

    $pm_prune_length = intval(forum_get_setting('pm_auto_prune', false, 0));

    return ($pm_prune_length > 0);
}

/**
* Check for attachments to messages
*
* Check to see if any of the messages have attachments and adds 
* the attachment ID (AID) if applicable.
*
* @return void
* @param array $pm_array - By Reference array of messages.
* @param array $mid_array - Array of messages IDs to check.
*/

function pms_have_attachments(&$pm_array, $mid_array)
{
    if (!is_array($mid_array)) return false;
    if (sizeof($mid_array) < 1) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $forum_fid = $table_data['FID'];

    $mid_list = implode(",", preg_grep("/^[0-9]+$/", $mid_array));

    $db_thread_has_attachments = db_connect();

    $sql = "SELECT PMI.MID, PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS PMI ON (PMI.AID = PAF.AID) ";
    $sql.= "WHERE PMI.MID IN ($mid_list) ";

    $result = db_query($sql, $db_thread_has_attachments);

    while ($row = db_fetch_array($result)) {

        $pm_array[$row['MID']]['AID'] = $row['AID'];
    }
}

/**
* Check for attachments to a message
*
* Check to see if a message has any attachments and applies 
* the attachment ID (AID) if applicable.
*
* @return mixed - False on error, attachment ID on success
* @param integer $mid - Message ID to check for attachments.
*/

function pm_has_attachments($mid)
{
    if (!is_numeric($mid)) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $forum_fid = $table_data['FID'];

    $db_thread_has_attachments = db_connect();

    $sql = "SELECT PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS PMI ON (PMI.AID = PAF.AID) ";
    $sql.= "WHERE PMI.MID = '$mid' ";

    $result = db_query($sql, $db_thread_has_attachments);

    if (db_num_rows($result) > 0) {

        list($aid) = db_fetch_array($result, DB_RESULT_NUM);
        return $aid;
    }

    return false;
}

/**
* Export messages
*
* Fetches the correct folder for export.
*
* @return mixed - False on error, array of messages on success.
* @param integer $folder - Folder to export.
*/

function pm_export_get_messages($folder)
{
    if ($folder == PM_FOLDER_INBOX) {

        return pm_get_inbox();

    }elseif ($folder == PM_FOLDER_SENT) {

        return pm_get_sent();

    }elseif ($folder == PM_FOLDER_OUTBOX) {

        return pm_get_outbox();

    }elseif ($folder == PM_FOLDER_SAVED) {

        return pm_get_saveditems();
    }

    return false;
}

/**
* Generate HTML header for export
*
* Generates the HTML header for export of messages.
*
* @return string - HTML header
* @param integer $mid - Message ID
*/

function pm_export_html_top($mid)
{
    $lang = load_language_file();
    
    $html = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    $html.= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    $html.= "<head>\n";

    if (is_bool($mid)) {    
        $html.= "<title>{$lang['messages']}</title>\n";
    }else {
        $html.= "<title>{$lang['message']} $mid</title>\n";
    }

    if (@file_exists("./styles/style.css")) {
        $html.= "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
    }

    $html.= "</head>\n";
    $html.= "<body>\n";

    return $html;
}

/**
* Generate HTML footer for export
*
* Generates the HTML footer for export of messages.
*
* @return void
* @param void
*/

function pm_export_html_bottom()
{
    $lang = load_language_file();
    
    $html = "</body>\n";
    $html.= "</html>\n";

    return $html;
}

/**
* Export messages to HTML
*
* Exports messages to HTML and add them to zip file.
*
* @return bool
* @param integer $folder - Folder ID to export
* @param object $zipfile - By Reference zip file object from zip.inc.php class.
*/

function pm_export_html($folder, &$zipfile)
{
    if (!is_numeric($folder)) return false;
    if (!is_object($zipfile)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');

    if ($pm_messages_array = pm_export_get_messages($folder)) {

        $pm_display = pm_export_html_top(false);

        foreach($pm_messages_array['message_array'] as $pm_message) {

            $pm_message['FOLDER'] = $folder;
            $pm_message['CONTENT'] = pm_get_content($pm_message['MID']);

            $pm_display.= pm_display($pm_message, true);

            if ($pm_export_file == PM_EXPORT_SINGLE) {
                $pm_display.= "<br />\n";                
            }

            if ($pm_export_file == PM_EXPORT_MANY) {

                $pm_display.= pm_export_html_bottom();
                $filename = "message_{$pm_message['MID']}.html";
                $zipfile->addFile($pm_display, $filename);
                $pm_display = pm_export_html_top(false);
            }

            if (isset($pm_message['AID'])) {
                pm_export_attachments($pm_message['AID'], $pm_message['FROM_UID'], $zipfile);
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $pm_display.= pm_export_html_bottom();
            $filename = "messages.html";
            $zipfile->addFile($pm_display, $filename);
        }

        return true;
    }

    return false;
}

/**
* Export messages to XML
*
* Exports messages to XML and add them to zip file.
*
* @return bool
* @param integer $folder - Folder ID to export
* @param object $zipfile - By Reference zip file object from zip.inc.php class.
*/

function pm_export_xml($folder, &$zipfile)
{
    if (!is_numeric($folder)) return false;
    if (!is_object($zipfile)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');

    if ($pm_messages_array = pm_export_get_messages($folder)) {

        $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
        $pm_display.= "  <beehiveforum>\n";
        $pm_display.= "    <messages>\n";

        foreach($pm_messages_array['message_array'] as $pm_message) {

            $pm_display.= "      <message>\n";

            foreach($pm_message as $key => $value) {

                $key = strtolower($key);                
                $pm_display.= "        <$key>$value</$key>\n";
            }

            $pm_content = pm_get_content($pm_message['MID']);
            $pm_display.= "        <content><![CDATA[{$pm_content}]]></content>\n";
            $pm_display.= "      </message>\n";

            if ($pm_export_file == PM_EXPORT_MANY) {

                $pm_display.= "    </messages>\n";
                $pm_display.= "  </beehiveforum>\n";

                $filename = "message_{$pm_message['MID']}.xml";
                $zipfile->addFile($pm_display, $filename);

                $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
                $pm_display.= "  <beehiveforum>\n";
                $pm_display.= "    <messages>\n";
            }

            if (isset($pm_message['AID'])) {
                pm_export_attachments($pm_message['AID'], $pm_message['FROM_UID'], $zipfile);
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $pm_display.= "    </messages>\n";
            $pm_display.= "  </beehiveforum>\n";

            $filename = "messages.xml";
            $zipfile->addFile($pm_display, $filename);
        }

        return true;
    }

    return false;
}

/**
* Export messages to plaintext
*
* Exports messages to plaintext and add them to zip file.
*
* @return bool
* @param integer $folder - Folder ID to export
* @param object $zipfile - By Reference zip file object from zip.inc.php class.
*/

function pm_export_plaintext($folder, &$zipfile)
{
    if (!is_numeric($folder)) return false;
    if (!is_object($zipfile)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');

    if ($mid_array = pm_export_get_messages($folder)) {

        $pm_display = "";

        foreach($pm_messages_array['message_array'] as $pm_message) {

            foreach($pm_message as $key => $value) {

                $pm_display.= "$key: $value\r\n";
            }

            $pm_content = pm_get_content($pm_message['MID']);
            $pm_display.= "content:\r\n\r\n$pm_content\r\n\r\n\r\n\r\n";

            if ($pm_export_file == PM_EXPORT_MANY) {

                $filename = "message_{$pm_message['MID']}.txt";
                $zipfile->addFile($pm_display, $filename);
                $pm_display = "";
            }

            if (isset($pm_message['AID'])) {
                pm_export_attachments($pm_message['AID'], $pm_message['FROM_UID'], $zipfile);
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $filename = "messages.txt";
            $zipfile->addFile($pm_display, $filename);
        }

        return true;
    }

    return false;
}

/**
* Export attachments
*
* Exports attachments and add them to zip file.
*
* @return bool
* @param integer $aid - Attachment ID
* @param integer $from_uid - Sender UID to check owner of attachmennt.
* @param object $zipfile - By Reference zip file object from zip.inc.php class.
*/

function pm_export_attachments($aid, $from_uid, &$zipfile)
{
    if (!md5($aid)) return false;
    if (!is_numeric($from_uid)) return false;
    if (!is_object($zipfile)) return false;

    if ($attachment_dir = attachments_check_dir()) {
        
        if (get_attachments($from_uid, $aid, $attachments_array, $image_attachments_array)) {

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                foreach($attachments_array as $attachment) {

                    if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

                        $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}"));
                        $zipfile->addFile($attachment_content, "attachments/{$attachment['filename']}");
                    }
                }
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                foreach($image_attachments_array as $key => $attachment) {

                    if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

                        $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}"));
                        $zipfile->addFile($attachment_content, "attachments/{$attachment['filename']}");
                    }

                    if (@file_exists("$attachment_dir/{$attachment['hash']}.thumb")) {

                        $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}.thumb"));
                        $zipfile->addFile($attachment_content, "attachments/{$attachment['filename']}.thumb");
                    }
                }
            }
        }
    }

    return true;
}

?>