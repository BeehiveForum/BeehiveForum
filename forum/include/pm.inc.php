<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: pm.inc.php,v 1.283 2010-01-03 15:19:33 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

        html_draw_top("title={$lang['pminbox']}");
        html_error_msg($lang['pmshavebeendisabled']);
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

function pm_mark_as_read($mid)
{
    if (!$db_pm_mark_as_read = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    $pm_read = PM_READ;

    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_read', NOTIFIED = 1 ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$uid'";

    if (!db_query($sql, $db_pm_mark_as_read)) return false;

    return true;
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
    html_error_msg($lang['cannoteditpm'], 'pm.php', 'get', array('back' => $lang['back']), array('folder' => PM_FOLDER_OUTBOX));
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
    html_error_msg($lang['cannotviewpm'], 'pm.php', 'get', array('back' => $lang['back']), array('folder' => PM_FOLDER_INBOX));
}

/**
* Get Inbox
*
* Gets the contents of the user's inbox.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_inbox($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = false, $limit = 10)
{
    if (!$db_pm_get_inbox = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'PM.FROM_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) $offset = false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_get_inbox_array = array();
    $mid_array = array();

    $pm_inbox_items = PM_INBOX_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_get_inbox)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_get_inbox)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_get_inbox_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_get_inbox($sort_by, $sort_dir, $offset);
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

function pm_get_outbox($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = false, $limit = 10)
{
    if (!$db_pm_get_outbox = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'PM.TO_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) $offset = false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_get_outbox_array = array();
    $mid_array = array();

    $pm_outbox_items = PM_OUTBOX_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_get_outbox)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_get_outbox)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_get_outbox_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_get_outbox($sort_by, $sort_dir, $offset);
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

function pm_get_sent($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = false, $limit = 10)
{
    if (!$db_pm_get_sent = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'PM.TO_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) $offset = false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_get_sent_array = array();
    $mid_array = array();

    $pm_sent_items = PM_SENT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "AND SMID = 0 ORDER BY $sort_by $sort_dir ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_get_sent)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_get_sent)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_get_sent_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_get_sent($sort_by, $sort_dir, $offset);
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

function pm_get_saved_items($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = false, $limit = 10)
{
    if (!$db_pm_get_saved_items = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'PM.FROM_UID', 'PM.TO_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) $offset = false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_get_saved_items_array = array();
    $mid_array = array();

    $pm_saved_out = PM_SAVED_OUT;
    $pm_saved_in  = PM_SAVED_IN;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE ((PM.TYPE & $pm_saved_out > 0) AND PM.FROM_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') ";
    $sql.= "ORDER BY $sort_by $sort_dir ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_get_saved_items)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_get_saved_items)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_get_saved_items_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_get_saved_items($sort_by, $sort_dir, $offset);
    }

    pms_have_attachments($pm_get_saved_items_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_saved_items_array);
}

/**
* Get Saved Items
*
* Gets the contents of the user's Saved Items.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_get_drafts($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = false, $limit = 10)
{
    if (!$db_pm_get_drafts = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'PM.TO_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) $offset = false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_get_drafts_array = array();
    $mid_array = array();

    $pm_draft_items = PM_DRAFT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir ";

    if (is_numeric($offset)) $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_get_drafts)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_get_drafts)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_get_drafts_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_get_drafts($sort_by, $sort_dir, $offset);
    }

    pms_have_attachments($pm_get_drafts_array, $mid_array);

    return array('message_count' => $message_count,
                 'message_array' => $pm_get_drafts_array);
}

/**
* Search Folders for messages.
*
* Search the user's PMs for messages. Searches subject and content.
*
* @return mixed - false on failure, array on success
* @param integer $offset - Optional offset for viewing pages of messages.
*/

function pm_search_execute($search_string, &$error)
{
    if (!$db_pm_search_execute = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "DELETE QUICK FROM PM_SEARCH_RESULTS WHERE UID = '$uid'";

    if (!db_query($sql, $db_pm_search_execute)) return false;

    if (!check_search_frequency() && !defined('BEEHIVE_INSTALL_NOWARN')) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    $search_keywords_array = search_strip_keywords($search_string);

    $filtered_keyword_count   = $search_keywords_array['filtered_word_count'];
    $unfiltered_keyword_count = $search_keywords_array['unfiltered_word_count'];

    if ($filtered_keyword_count > 0 && $filtered_keyword_count == $unfiltered_keyword_count) {

        $search_string_checked = db_escape_string(implode(' ', $search_keywords_array['keywords']));

        $pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);
        $limit = ($pm_max_user_messages > 1000) ? 1000 : $pm_max_user_messages;

        $pm_inbox_items  = PM_INBOX_ITEMS;
        $pm_sent_items   = PM_SENT_ITEMS;
        $pm_outbox_items = PM_OUTBOX_ITEMS;
        $pm_saved_out    = PM_SAVED_OUT;
        $pm_saved_in     = PM_SAVED_IN;
        $pm_draft_items  = PM_DRAFT_ITEMS;

        $sql = "INSERT INTO PM_SEARCH_RESULTS (UID, MID, TYPE, FROM_UID, TO_UID, ";
        $sql.= "SUBJECT, RECIPIENTS, CREATED) SELECT $uid, PM.MID, PM.TYPE, ";
        $sql.= "PM.FROM_UID, PM.TO_UID, PM.SUBJECT, PM.RECIPIENTS, PM.CREATED ";
        $sql.= "FROM PM LEFT JOIN PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
        $sql.= "WHERE (((PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid') ";
        $sql.= "OR ((PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid' AND PM.SMID = 0) ";
        $sql.= "OR ((PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid') ";
        $sql.= "OR ((PM.TYPE = $pm_saved_out AND PM.FROM_UID = '$uid') OR ";
        $sql.= "((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') OR ";
        $sql.= "((PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid'))) ";
        $sql.= "AND (MATCH(PM_CONTENT.CONTENT) AGAINST('$search_string_checked' IN BOOLEAN MODE) ";
        $sql.= "OR (MATCH(PM.SUBJECT) AGAINST('$search_string_checked' IN BOOLEAN MODE))) ";
        $sql.= "ORDER BY CREATED LIMIT $limit";

        if (!db_query($sql, $db_pm_search_execute)) return false;

        if (db_affected_rows($db_pm_search_execute) > 0) return true;

        $error = SEARCH_NO_MATCHES;

        return false;
    }

    $error = SEARCH_NO_KEYWORDS;
    return false;
}

function pm_fetch_search_results ($sort_by = 'CREATED', $sort_dir = 'DESC', $offset = 0, $limit = 10)
{
    if (!$db_pm_fetch_search_results = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('PM.SUBJECT', 'TYPE', 'PM.FROM_UID', 'PM.TO_UID', 'CREATED');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) return false;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_search_results_array = array();
    $mid_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM_SEARCH_RESULTS.MID, PM_SEARCH_RESULTS.TYPE, ";
    $sql.= "PM_SEARCH_RESULTS.FROM_UID, PM_SEARCH_RESULTS.TO_UID, PM_SEARCH_RESULTS.RECIPIENTS, ";
    $sql.= "PM_SEARCH_RESULTS.SUBJECT, UNIX_TIMESTAMP(PM_SEARCH_RESULTS.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK FROM PM_SEARCH_RESULTS ";
    $sql.= "LEFT JOIN PM ON (PM.MID = PM_SEARCH_RESULTS.MID) ";
    $sql.= "LEFT JOIN USER FUSER ON (PM_SEARCH_RESULTS.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM_SEARCH_RESULTS.TO_UID = TUSER.UID) ";
    $sql.= "WHERE PM_SEARCH_RESULTS.UID = '$uid' AND PM.MID IS NOT NULL ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, $limit";

    if (!$result = db_query($sql, $db_pm_fetch_search_results)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_pm_fetch_search_results)) return false;

    list($message_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($pm_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($pm_data['FLOGON']) && isset($pm_data['PFNICK'])) {
                if (!is_null($pm_data['PFNICK']) && strlen($pm_data['PFNICK']) > 0) {
                    $pm_data['FNICK'] = $pm_data['PFNICK'];
                }
            }

            if (isset($pm_data['TLOGON']) && isset($pm_data['PTNICK'])) {
                if (!is_null($pm_data['PTNICK']) && strlen($pm_data['PTNICK']) > 0) {
                    $pm_data['TNICK'] = $pm_data['PTNICK'];
                }
            }

            if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

            if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = $lang['unknownuser'];
            if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

            $pm_search_results_array[$pm_data['MID']] = $pm_data;
            $mid_array[] = $pm_data['MID'];
        }

        pms_have_attachments($pm_search_results_array, $mid_array);

    }else if ($message_count > 0) {

        $offset = floor(($message_count - 1) / 10) * 10;
        return pm_fetch_search_results($sort_by, $sort_dir, $offset);
    }

    return array('message_count' => $message_count,
                 'message_array' => $pm_search_results_array);
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

function pm_get_folder_message_counts()
{
    if (!$db_pm_get_folder_message_counts = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $message_count_array = array(PM_FOLDER_INBOX  => 0, PM_FOLDER_SENT   => 0,
                                 PM_FOLDER_OUTBOX => 0, PM_FOLDER_SAVED  => 0,
                                 PM_FOLDER_DRAFTS => 0);

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT, TYPE ";
    $sql.= "FROM PM WHERE ((TYPE & $pm_inbox_items > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_sent_items > 0) AND FROM_UID = '$uid' AND SMID = 0) ";
    $sql.= "OR ((TYPE & $pm_outbox_items > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_out > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_in > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_draft_items > 0) AND FROM_UID = '$uid') ";
    $sql.= "GROUP BY TYPE";

    if (!$result = db_query($sql, $db_pm_get_folder_message_counts)) return false;

    while (($pm_data_array = db_fetch_array($result))) {

        if ($pm_data_array['TYPE'] & PM_INBOX_ITEMS) {

            $message_count_array[PM_FOLDER_INBOX] = $pm_data_array['MESSAGE_COUNT'];

        }elseif ($pm_data_array['TYPE'] & PM_SENT_ITEMS) {

            $message_count_array[PM_FOLDER_SENT] = $pm_data_array['MESSAGE_COUNT'];

        }elseif ($pm_data_array['TYPE'] & PM_OUTBOX_ITEMS) {

            $message_count_array[PM_FOLDER_OUTBOX] = $pm_data_array['MESSAGE_COUNT'];

        }elseif ($pm_data_array['TYPE'] & PM_SAVED_ITEMS) {

            $message_count_array[PM_FOLDER_SAVED] = $pm_data_array['MESSAGE_COUNT'];

        }elseif ($pm_data_array['TYPE'] & PM_DRAFT_ITEMS) {

            $message_count_array[PM_FOLDER_DRAFTS] = $pm_data_array['MESSAGE_COUNT'];
        }
    }

    $sql = "SELECT COUNT(PM_SEARCH_RESULTS.MID) AS RESULT_COUNT ";
    $sql.= "FROM PM_SEARCH_RESULTS LEFT JOIN PM ";
    $sql.= "ON (PM.MID = PM_SEARCH_RESULTS.MID) ";
    $sql.= "WHERE UID = '$uid' AND PM.MID IS NOT NULL";

    if (!$result = db_query($sql, $db_pm_get_folder_message_counts)) return false;

    list($search_results_count) = db_fetch_array($result, DB_RESULT_NUM);
    $message_count_array[PM_SEARCH_RESULTS] = $search_results_count;

    return $message_count_array;
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
    if (!$db_pm_get_free_space = db_connect()) return false;

    if ($uid === false) {
        if (($uid = bh_session_get_value('UID')) === false) return false;
    }

    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

    $sql = "SELECT COUNT(MID) AS MESSAGE_COUNT ";
    $sql.= "FROM PM WHERE ((TYPE & $pm_inbox_items > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_sent_items > 0) AND FROM_UID = '$uid' AND SMID = 0) ";
    $sql.= "OR ((TYPE & $pm_outbox_items > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_out > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_in > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_draft_items > 0) AND FROM_UID = '$uid')";

    if (!$result = db_query($sql, $db_pm_get_free_space)) return false;

    list($pm_user_message_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($pm_user_message_count > $pm_max_user_messages) return 0;

    return ($pm_max_user_messages - $pm_user_message_count);
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
    if (!$db_pm_get_user = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT USER.LOGON FROM PM ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = PM.FROM_UID) ";
    $sql.= "WHERE PM.MID = '$mid' AND USER.UID IS NOT NULL";

    if (!$result = db_query($sql, $db_pm_get_user)) return false;

    if (db_num_rows($result) > 0) {

        list($logon) = db_fetch_array($result);
        return $logon;
    }

    return false;
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
    if (!$db_pm_user_get_friends = db_connect()) return false;

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $user_rel = USER_FRIEND;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = USER_PEER.PEER_UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND (USER_PEER.RELATIONSHIP & $user_rel > 0) ";
    $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_pm_user_get_friends)) return false;

    $user_get_peers_array = array();

    $user_get_peers_array[0] = "&lt;select recipient&gt;";

    if (db_num_rows($result) > 0) {

        while (($user_data = db_fetch_array($result))) {

            if (isset($user_data['LOGON'])) {

                if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                    if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                        $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                    }
                }

                if (!isset($user_data['LOGON'])) $user_data['LOGON'] = $lang['unknownuser'];
                if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

                $user_get_peers_array[$user_data['UID']] = word_filter_add_ob_tags(htmlentities_array(format_user_name($user_data['LOGON'], $user_data['NICKNAME'])));
            }
        }

        return $user_get_peers_array;
    }

    return false;
}

/**
* Get Subject
*
* Gets the subject of the specified message ID.
*
* @return mixed - false on failure, message subject as string on success
* @param integer $mid - Message ID.
* @param integer $to_uid - Recepient UID.
*/

function pm_get_subject($mid, $to_uid)
{
    if (!$db_pm_get_subject = db_connect()) return false;

    if (!is_numeric($mid)) return false;
    if (!is_numeric($to_uid)) return false;

    $sql = "SELECT SUBJECT FROM PM WHERE MID = '$mid' AND TO_UID = '$to_uid'";

    if (!$result = db_query($sql, $db_pm_get_subject)) return false;

    if (db_num_rows($result) > 0) {

        list($pm_subject) = db_fetch_array($result);
        return $pm_subject;
    }

    return false;
}

/**
* Get a PM message
*
* Gets a PM message from the database
*
* @return mixed - false on failure, array on success
* @param integer $mid - Message ID to fetch
* @param integer $folder - Folder that the message resides in
*/

function pm_message_get($mid)
{
    if (!$db_pm_message_get = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

    // Fetch the single message as specified by the MID

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (((PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid') ";
    $sql.= "OR ((PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid' AND PM.SMID = 0) ";
    $sql.= "OR ((PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid') ";
    $sql.= "OR ((PM.TYPE & $pm_saved_out > 0) AND PM.FROM_UID = '$uid') ";
    $sql.= "OR ((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') ";
    $sql.= "OR ((PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid')) ";
    $sql.= "AND PM.MID = '$mid' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_pm_message_get)) return false;

    if (db_num_rows($result) > 0) {

        if (($pm_message_array = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (($folder = pm_message_get_folder($mid, $pm_message_array['TYPE']))) {

                if (($pm_message_array['TO_UID'] == $uid) && ($pm_message_array['TYPE'] == PM_UNREAD) && ($folder == PM_FOLDER_INBOX)) {
                    pm_mark_as_read($mid);
                }

                if (($aid = pm_has_attachments($mid))) {
                    $pm_message_array['AID'] = $aid;
                }

                return $pm_message_array;
            }
        }
    }

    return false;
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
    if (!$db_pm_get_content = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    // Fetch the message content as specified by the MID

    $sql = "SELECT CONTENT FROM PM_CONTENT WHERE MID = '$mid'";

    if (!$result = db_query($sql, $db_pm_get_content)) return false;

    if (db_num_rows($result) > 0) {

        list($pm_content) = db_fetch_array($result, DB_RESULT_NUM);
        return $pm_content;
    }

    return $sql;
}

/**
* Display or return PM HTML.
*
* Displays or returns the PM HTML formatted for display in the browser
*
* @return mixed - string or void depending on $pm_export_html setting.
* @param integer $folder - Current folder view selected by user
* @param boolean $preview - Preview mode hides the Reply and Forward links.
* @param boolean $pm_export_html - Optional settings allows return of HTML as string instead of sending to STDOUT.
*/

function pm_display($pm_message_array, $folder, $preview = false, $export_html = false)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">\n";
    echo "              <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";
    echo "                    <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "                      <tr>\n";

    if ($folder == PM_FOLDER_INBOX) {

        if ($export_html === true) {

            echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
            echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($pm_message_array['FLOGON'], $pm_message_array['FNICK']))), "</span></td>\n";

        }else {

            echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
            echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($pm_message_array['FLOGON'], $pm_message_array['FNICK']))), "</a></span></td>\n";
        }

    }else {

        if (isset($pm_message_array['RECIPIENTS']) && strlen(trim($pm_message_array['RECIPIENTS'])) > 0) {

            $recipient_array = preg_split("/[;|,]/u", trim($pm_message_array['RECIPIENTS']));

            if ($pm_message_array['TO_UID'] > 0) {
                $recipient_array = array_unique(array_merge($recipient_array, array($pm_message_array['TLOGON'])));
            }

            if ($export_html === false) $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

            echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
            echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span></td>\n";

        }elseif (is_array($pm_message_array['TLOGON'])) {

            $recipient_array = array_unique($pm_message_array['TLOGON']);

            if ($export_html === false) $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

            echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
            echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span></td>\n";

        }else if (isset($pm_message_array['TO_UID']) && is_numeric($pm_message_array['TO_UID'])) {

            if ($export_html === true) {

                echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
                echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofromlabel\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']))), "</span></td>\n";

            }else {

                echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
                echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofromlabel\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']))), "</a></span></td>\n";
            }

        }else {

            echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
            echo "                        <td align=\"left\" class=\"postbody\"><i>{$lang['norecipients']}</i></td>\n";
        }
    }

    // Add emoticons/wikilinks and word filter tags

    $pm_message_array['CONTENT'] = message_apply_formatting($pm_message_array['CONTENT']);
    $pm_message_array['CONTENT'] = word_filter_add_ob_tags($pm_message_array['CONTENT']);

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['subject']}:&nbsp;</span></td>\n";

    if (strlen(trim($pm_message_array['SUBJECT'])) > 0) {

        echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(htmlentities_array($pm_message_array['SUBJECT'])), "</span></td>\n";

    }else {

        echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><i>{$lang['nosubject']}</i></span></td>\n";
    }

    if (isset($pm_message_array['TYPE']) && ($pm_message_array['TYPE'] & PM_SAVED_DRAFT) > 0) {

        echo "                        <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><i>{$lang['notsent']}</i>&nbsp;</span></td>\n";

    }else {

        echo "                        <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">", format_time($pm_message_array['CREATED']), "&nbsp;</span></td>\n";
    }

    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";
    echo "                    <table width=\"100%\">\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=\"3\" align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td class=\"postbody\" align=\"left\">{$pm_message_array['CONTENT']}</td>\n";
    echo "                      </tr>\n";

    if (isset($pm_message_array['AID'])) {

        $aid = $pm_message_array['AID'];

        $attachments_array = array();
        $image_attachments_array = array();

        if (get_attachments($pm_message_array['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            // Draw the attachment header at the bottom of the post

            echo "                      <tr>\n";
            echo "                        <td class=\"postbody\" align=\"left\">\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                echo "                              <p><b>{$lang['attachments']}:</b><br />\n";

                foreach ($attachments_array as $attachment) {

                    echo "                              ", attachment_make_link($attachment, true, false, $export_html), "<br />\n";
                }

                echo "                              </p>\n";
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                echo "                              <p><b>{$lang['imageattachments']}:</b><br />\n";

                foreach ($image_attachments_array as $attachment) {

                    echo "                              ", attachment_make_link($attachment, true, false, $export_html), "\n";
                }

                echo "                              </p>\n";
            }

            echo "                        </td>\n";
            echo "                      </tr>\n";
        }
    }

    echo "                    </table>\n";
    echo "                    <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "                      <tr>\n";

    if ($preview === false) {

        if ($folder == PM_FOLDER_INBOX) {

            echo "                        <td align=\"center\"><img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;replyto={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['reply']}</a>&nbsp;&nbsp;<img src=\"", style_image('forward.png'), "\" border=\"0\" alt=\"{$lang['forward']}\" title=\"{$lang['forward']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['forward']}</a></td>\n";

        }elseif ($folder == PM_FOLDER_OUTBOX) {

            echo "                        <td align=\"center\"><img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />&nbsp;<a href=\"pm_edit.php?webtag=$webtag&amp;mid={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['edit']}</a>&nbsp;&nbsp;<img src=\"", style_image('forward.png'), "\" border=\"0\" alt=\"{$lang['forward']}\" title=\"{$lang['forward']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['forward']}</a></td>\n";

        }elseif ($folder == PM_FOLDER_DRAFTS) {

            echo "                        <td align=\"center\"><img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;editmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['edit']}</a></td>\n";

        }else {

            echo "                        <td align=\"center\"><img src=\"", style_image('forward.png'), "\" border=\"0\" alt=\"{$lang['forward']}\" title=\"{$lang['forward']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">{$lang['forward']}</a></td>\n";
        }

    }else {

        echo "                        <td align=\"center\">&nbsp;</td>\n";
    }

    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function pm_display_html_export($pm_message_array, $folder)
{
    ob_start();

    pm_display($pm_message_array, $folder, true, true);

    $pm_message_html = ob_get_contents();

    ob_end_clean();

    return word_filter_rem_ob_tags($pm_message_html);
}

function pm_message_get_folder($mid, $type = 0)
{
    if (!$db_pm_message_get_folder = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_message_type_array = array(1  => PM_FOLDER_OUTBOX,
                                   2  => PM_FOLDER_INBOX,
                                   4  => PM_FOLDER_INBOX,
                                   8  => PM_FOLDER_SENT,
                                   16 => PM_FOLDER_SAVED,
                                   32 => PM_FOLDER_SAVED,
                                   64 => PM_FOLDER_DRAFTS);

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

    // Check the passed type before doing a query.

    if (in_array($type, array_keys($pm_message_type_array), true)) {
        return $pm_message_type_array[$type];
    }

    // Fetch the message type as specified by the MID

    $sql = "SELECT TYPE FROM PM WHERE MID = '$mid' ";
    $sql.= "AND (((TYPE & $pm_inbox_items > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_sent_items > 0) AND FROM_UID = '$uid' AND SMID = 0) ";
    $sql.= "OR ((TYPE & $pm_outbox_items > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_out > 0) AND FROM_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_saved_in > 0) AND TO_UID = '$uid') ";
    $sql.= "OR ((TYPE & $pm_draft_items > 0) AND FROM_UID = '$uid')) ";

    if (!$result = db_query($sql, $db_pm_message_get_folder)) return false;

    list($pm_message_type) = db_fetch_array($result, DB_RESULT_NUM);

    if (in_array($pm_message_type, array_keys($pm_message_type_array))) {
        return $pm_message_type_array[$pm_message_type];
    }

    return false;
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

    if (!$db_pm_save_attachment_id = db_connect()) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = db_query($sql, $db_pm_save_attachment_id)) return false;

    if (db_num_rows($result) < 1) {

        $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
        $sql.= "VALUES ('$mid', '$aid')";

        if (!$result = db_query($sql, $db_pm_save_attachment_id)) return false;

    }else {

        $sql = "UPDATE LOW_PRIORITY PM_ATTACHMENT_IDS SET AID = '$aid' ";
        $sql.= "WHERE MID = '$mid'";

        if (!$result = db_query($sql, $db_pm_save_attachment_id)) return false;
    }

    return true;
}

/**
* Send Message
*
* Sends a message with specified sender, recipient, subject and content
*
* @return mixed - false on failure, integer Message ID on success
* @param integer $to_uid - Sender UID
* @param integer $from_uid - Recipient UID
* @param string $subject - Subject string
* @param string $content - Content string
* @param string $aid - Attachment Unique ID (MD5 hash)
*/

function pm_send_message($to_uid, $from_uid, $subject, $content, $aid)
{
    if (!$db_pm_send_message = db_connect()) return false;

    if (!is_numeric($to_uid)) return false;
    if (!is_numeric($from_uid)) return false;

    if (!is_md5($aid)) return false;

    // Escape the subject and content for insertion into database.

    $subject_escaped = db_escape_string($subject);
    $content_escaped = db_escape_string($content);

    // PM_OUTBOX constant.

    $pm_outbox = PM_OUTBOX;

    $current_datetime = date(MYSQL_DATETIME, time());

    // Insert the main PM Data into the database

    $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED) VALUES ('$pm_outbox', '$to_uid', '$from_uid', ";
    $sql.= "'$subject_escaped', '', CAST('$current_datetime' AS DATETIME), 0)";

    if (db_query($sql, $db_pm_send_message)) {

        $new_mid = db_insert_id($db_pm_send_message);

        // Insert the PM Content into the database

        $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
        $sql.= "VALUES ('$new_mid', '$content_escaped')";

        if (!db_query($sql, $db_pm_send_message)) return false;

        // Check to see if we should be adding a 'Sent Item'

        $user_prefs = user_get_prefs($from_uid);

        if (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {

            if (!pm_add_sent_item($new_mid, $to_uid, $from_uid, $subject, $content, $aid)) return false;
        }

        // Save the attachment ID.

        pm_save_attachment_id($new_mid, $aid);

        return $new_mid;
    }

    return false;
}

/**
* Add Sent Item
*
* Adds a PM Sent Item to the database PM tables.
* Called by pm_send_message() function if the sender has sent items enabled.
*
* @return mixed - false on failure, integer Message ID on success
* @param integer $to_uid - Sender UID
* @param integer $from_uid - Recipient UID
* @param string $subject - Subject string
* @param string $content - Content string
* @param string $aid - Attachment Unique ID (MD5 hash)
*/

function pm_add_sent_item($sent_item_mid, $to_uid, $from_uid, $subject, $content, $aid)
{
    if (!$db_pm_add_sent_item = db_connect()) return false;

    if (!is_numeric($sent_item_mid)) return false;
    if (!is_numeric($to_uid)) return false;
    if (!is_numeric($from_uid)) return false;

    if (!is_md5($aid)) return false;

    // Escape the subject and content for insertion into database.

    $subject_escaped = db_escape_string($subject);
    $content_escaped = db_escape_string($content);

    // PM_SENT constant.

    $pm_sent = PM_SENT;

    // Current datetime

    $current_datetime = date(MYSQL_DATETIME, time());

    // Insert the main PM Data into the database

    $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED, SMID) VALUES ('$pm_sent', '$to_uid', '$from_uid', ";
    $sql.= "'$subject_escaped', '', CAST('$current_datetime' AS DATETIME), ";
    $sql.= "1, '$sent_item_mid')";

    if (db_query($sql, $db_pm_add_sent_item)) {

        $new_mid = db_insert_id($db_pm_add_sent_item);

        // Insert the PM Content into the database

        $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
        $sql.= "VALUES ('$new_mid', '$content_escaped')";

        if (!db_query($sql, $db_pm_add_sent_item)) return false;

        // Save the attachment ID.

        pm_save_attachment_id($new_mid, $aid);

        return  $new_mid;
    }

    return false;
}

/**
* Save PM.
*
* Save a PM to Saved items folder.
*
* @return bool - true on success, false on failure.
* @param integer $mid - Message ID to edit
* @param string $subject - New subject for message
* @param string $content - New content for message
* @param integer $to_uid - Recipient UID
* @param string - $recipient_list - List of recipient logons.
*/

function pm_save_message($subject, $content, $to_uid, $recipient_list)
{
    if (!$db_pm_save_message = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($to_uid)) return false;

    $subject = db_escape_string($subject);
    $recipient_list = db_escape_string($recipient_list);
    $content = db_escape_string($content);

    $pm_saved_draft = PM_SAVED_DRAFT;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (pm_get_free_space($uid) > 0) {

        // Insert the main PM Data into the database

        $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
        $sql.= "CREATED, NOTIFIED) VALUES ('$pm_saved_draft', '$to_uid', '$uid', '$subject', ";
        $sql.= "'$recipient_list', CAST('$current_datetime' AS DATETIME), 0)";

        if (db_query($sql, $db_pm_save_message)) {

            $new_mid = db_insert_id($db_pm_save_message);

            // Insert the PM Content into the database

            $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
            $sql.= "VALUES ('$new_mid', '$content')";

            if (!db_query($sql, $db_pm_save_message)) return false;

            return  $new_mid;
        }
    }

    return false;
}

/**
* Update Saved PM
*
* Update a saved messages
*
* @return bool - true on success, false on failure.
* @param integer $mid - Message ID to edit
* @param string $subject - New subject for message
* @param string $content - New content for message
* @param integer $to_uid - Recipient UID
* @param string - $recipient_list - List of recipient logons.
*/

function pm_update_saved_message($mid, $subject, $content, $to_uid, $recipient_list)
{
    if (!$db_pm_edit_messages = db_connect()) return false;

    if (!is_numeric($mid)) return false;
    if (!is_numeric($to_uid)) return false;

    $subject = db_escape_string($subject);
    $content = db_escape_string($content);

    $recipient_list = db_escape_string($recipient_list);

    // Update the subject text

    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject', TO_UID = '$to_uid', ";
    $sql.= "RECIPIENTS = '$recipient_list' WHERE MID = '$mid'";

    if (!db_query($sql, $db_pm_edit_messages)) return false;

    // Update the content

    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";
    if (!db_query($sql, $db_pm_edit_messages)) return false;

    return true;
}

/**
* Edit PM
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
    if (!$db_pm_edit_messages = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    $subject_escaped = db_escape_string($subject);
    $content_escaped = db_escape_string($content);

    // Update the subject text

    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject_escaped' WHERE MID = '$mid'";
    if (!db_query($sql, $db_pm_edit_messages)) return false;

    // Update the content

    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content_escaped' WHERE MID = '$mid'";
    if (!db_query($sql, $db_pm_edit_messages)) return false;

    return pm_update_sent_item($mid, $subject, $content);
}

/**
* Update Sent Item
*
* Updates a sent item with the content from pm_edit()
*
* @return bool - true on success, false on failure.
* @param integer $mid - Message ID to edit
* @param string $subject - New subject for message
* @param string $content - New content for message
*/

function pm_update_sent_item($mid, $subject, $content)
{
    if (!$db_pm_edit_messages = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    $subject = db_escape_string($subject);
    $content = db_escape_string($content);

    // Query the database for the sent item's MID

    $sql = "SELECT MID FROM PM WHERE SMID = '$mid'";
    if (!$result = db_query($sql, $db_pm_edit_messages)) return false;

    // Fetch the SMID.

    list($sent_item_mid) = db_fetch_array($result, DB_RESULT_NUM);

    // Update the sent items subject text

    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject' WHERE MID = '$sent_item_mid'";
    if (!db_query($sql, $db_pm_edit_messages)) return false;

    // Update the sent item content

    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$sent_item_mid'";
    if (!db_query($sql, $db_pm_edit_messages)) return false;

    return true;
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
    if (!$db_delete_pm = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    // Constants required.

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_sent_items = PM_SENT_ITEMS;
    $pm_saved_out = PM_SAVED_OUT;
    $pm_saved_in  = PM_SAVED_IN;
    $pm_draft_items = PM_DRAFT_ITEMS;

    // User UID

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Verify the PM is 'owned' by the current user.

    $sql = "SELECT PM.TYPE, PM.TO_UID, PM.FROM_UID, ";
    $sql.= "PAF.FILENAME, AT.AID FROM PM PM ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS AT ON (AT.MID = PM.MID) ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = AT.AID) ";
    $sql.= "WHERE (((PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_saved_out > 0) AND PM.FROM_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid')) ";
    $sql.= "AND PM.MID = '$mid' GROUP BY PM.MID LIMIT 0, 1";

    if (!$result = db_query($sql, $db_delete_pm)) return false;

    if (db_num_rows($result) > 0) {

        $db_delete_pm_row = db_fetch_array($result);

        // If it is the author deleting his Sent Item then
        // delete the attachment as well.

        if ($db_delete_pm_row['TYPE'] == PM_SENT && isset($db_delete_pm_row['AID'])) {
            delete_attachment_by_aid($db_delete_pm_row['AID']);
        }

        $sql = "DELETE QUICK FROM PM WHERE MID = '$mid'";

        if (!$result = db_query($sql, $db_delete_pm)) return false;

        $sql = "DELETE QUICK FROM PM_CONTENT WHERE MID = '$mid'";

        if (!$result = db_query($sql, $db_delete_pm)) return false;

        return true;
    }

    return false;
}

/**
* Delete messages
*
* Deletes the specified array of messages
*
* @return bool - True on success, False on failure.
* @param array $mid_array - Array of message IDs to delete
*/

function pm_delete_messages($mid_array)
{
    if (!is_array($mid_array)) return false;

    $mid_array = array_filter($mid_array, 'is_numeric');

    if (sizeof($mid_array) < 1) return false;

    foreach ($mid_array as $mid) {
        if (!pm_delete_message($mid)) return false;
    }

    return true;
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
    if (!$db_pm_archive_message = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_saved_in  = PM_SAVED_IN;
    $pm_saved_out = PM_SAVED_OUT;

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_sent_items  = PM_SENT_ITEMS;

    // Archive any PM that are in the User's Inbox

    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_saved_in' ";
    $sql.= "WHERE MID = '$mid' AND (TYPE & $pm_inbox_items > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!db_query($sql, $db_pm_archive_message)) return false;

    // Archive any PM that are in the User's Sent Items

    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_saved_out' ";
    $sql.= "WHERE MID = '$mid' AND (TYPE & $pm_sent_items > 0) ";
    $sql.= "AND SMID = 0 AND FROM_UID = '$uid'";

    if (!db_query($sql, $db_pm_archive_message)) return false;

    return true;
}

/* Archive messages
*
* Archive the specified array of messages
*
* @return bool - True on success, False on failure.
* @param array $mid_array - Array of message IDs to delete
*/

function pm_archive_messages($mid_array)
{
    if (!is_array($mid_array)) return false;

    $mid_array = array_filter($mid_array, 'is_numeric');

    if (sizeof($mid_array) < 1) return false;

    foreach ($mid_array as $mid) {
        if (!pm_archive_message($mid)) return false;
    }

    return true;
}

/**
* Get a list of new messages
*
* Check's to see if the current user (uses BH Session data) has any new messages
* and returns them as an array.
*
* @return mixed - array of messages or false if no messages.
* @param void
*/

function pm_get_new_messages($limit)
{
    if (!$db_pm_get_new_messages = db_connect()) return false;

    if (!is_numeric($limit)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $pm_outbox = PM_OUTBOX;

    $sql = "SELECT MID, TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED, SMID FROM PM WHERE TYPE = '$pm_outbox' ";
    $sql.= "AND TO_UID = '$uid' ORDER BY CREATED ASC ";
    $sql.= "LIMIT $limit";

    if (!$result = db_query($sql, $db_pm_get_new_messages)) return false;

    if (db_num_rows($result) > 0) {

        $pm_new_message_array = array();

        while (($pm_data = db_fetch_array($result))) {

            $pm_new_message_array[$pm_data['MID']] = $pm_data;
        }

        return $pm_new_message_array;
    }

    return false;
}

/**
* Check for new messages
*
* Check's to see if the current user (uses BH Session data) has any new messages.
*
* @return integer - number of new messages.
* @param integer &$pm_new_count - Number of messages we managed to deliver.
* @param integer &$outbox_count - Number of undeliverable messages waiting for the user.
*/

function pm_get_message_count(&$pm_new_count, &$pm_outbox_count, &$pm_unread_count)
{
    // Default the variables to return 0 even on error.

    $pm_new_count = 0;
    $pm_outbox_count = 0;
    $pm_unread_count = 0;

    // Connect to the database.

    if (!$db_pm_get_message_count = db_connect()) return false;

    // Check the user UID.

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // PM folder types we'll be using.

    $pm_unread = PM_UNREAD;
    $pm_outbox = PM_OUTBOX;
    $pm_sent_item = PM_SENT;

    // Get the user's free space.

    $pm_free_space = pm_get_free_space($uid);

    // Get a list of messages we have received.

    if (($pm_messages_array = pm_get_new_messages($pm_free_space))) {

        // Convert the array keys into a comma separated list.

        $mid_list = implode(',', array_filter(array_keys($pm_messages_array), 'is_numeric'));

        // Mark the selected messages as unread / received and make the
        // sent items visible to the sender.

        $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_unread' WHERE MID in ($mid_list) ";
        $sql.= "AND TO_UID = '$uid'";

        if (!$result = db_query($sql, $db_pm_get_message_count)) return false;

        $sql = "UPDATE LOW_PRIORITY PM SET SMID = 0 WHERE SMID IN ($mid_list) ";
        $sql.= "AND TYPE = '$pm_sent_item' AND TO_UID = '$uid'";

        if (!$result = db_query($sql, $db_pm_get_message_count)) return false;

        // Number of new messages we've received for popup.

        $pm_new_count = sizeof($pm_messages_array);
    }

    // Unread message count.

    $sql = "SELECT COUNT(MID) FROM PM WHERE (TYPE & $pm_unread > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!$result = db_query($sql, $db_pm_get_message_count)) return false;

    list($pm_unread_count) = db_fetch_array($result, DB_RESULT_NUM);

    // Check for any undelivered messages waiting for the user.

    $sql = "SELECT COUNT(MID) AS OUTBOX_COUNT FROM PM ";
    $sql.= "WHERE TYPE = '$pm_outbox' AND TO_UID = '$uid'";

    if (!$result = db_query($sql, $db_pm_get_message_count)) return false;

    list($pm_outbox_count) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

/**
* Check number of PM Messages unread and in outbox.
*
* Gets the number of unread messages in inbox and those awaiting
* delivery in another user's outbox. Output is XML for use in
* XML HTTP functionality.
*
* @return integer - number of unread messages.
* @param void
*/

function pm_check_messages()
{
    // Outputting JSON

    header('Content-type: application/json; charset=UTF-8', true);

    // Load the Language file

    $lang = load_language_file();

    // Get the number of messages.

    pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

    // Format the message sent to the client.

    if ($pm_new_count == 1 && $pm_outbox_count == 0) {

        $pm_notification = $lang['youhave1newpm'];

    }elseif ($pm_new_count == 1 && $pm_outbox_count == 1) {

        $pm_notification = $lang['youhave1newpmand1waiting'];

    }elseif ($pm_new_count == 0 && $pm_outbox_count == 1) {

        $pm_notification = $lang['youhave1pmwaiting'];

    }elseif ($pm_new_count > 1 && $pm_outbox_count == 0) {

        $pm_notification = sprintf($lang['youhavexnewpm'], $pm_new_count);

    }elseif ($pm_new_count > 1 && $pm_outbox_count == 1) {

        $pm_notification = sprintf($lang['youhavexnewpmand1waiting'], $pm_new_count);

    }elseif ($pm_new_count > 1 && $pm_outbox_count > 1) {

        $pm_notification = sprintf($lang['youhavexnewpmandxwaiting'], $pm_new_count, $pm_outbox_count);

    }elseif ($pm_new_count == 1 && $pm_outbox_count > 1) {

        $pm_notification = sprintf($lang['youhave1newpmandxwaiting'], $pm_outbox_count);

    }elseif ($pm_new_count == 0 && $pm_outbox_count > 1) {

        $pm_notification = sprintf($lang['youhavexpmwaiting'], $pm_outbox_count);
    }

    $pm_notification_data = array();

    if ($pm_new_count > 0) {
        $pm_notification_data['text'] = sprintf('[%d %s]', $pm_new_count, $lang['new']);
    } else if ($pm_unread_count > 0) {
        $pm_notification_data['text'] = sprintf('[%d %s]', $pm_unread_count, $lang['unread']);
    }

    if (isset($pm_notification) && strlen(trim($pm_notification)) > 0) {
        $pm_notification_data['notification'] = wordwrap($pm_notification, 65, "\n");
    }

    echo json_encode($pm_notification_data);
    exit;
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
    if (!$db_pm_get_unread_count = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Guests don't do PMs.

    if (user_is_guest()) return false;

    $pm_unread = PM_UNREAD;

    // Check to see if the user has any new PMs

    $sql = "SELECT COUNT(MID) FROM PM WHERE (TYPE & $pm_unread > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!$result = db_query($sql, $db_pm_get_unread_count)) return false;

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
    if (!$db_pm_prune_folders = db_connect()) return false;

    if ($uid === false) {
        if (($uid = bh_session_get_value('UID')) === false) return false;
    }

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) {

        $pm_read = PM_READ;
        $pm_sent_items = PM_SENT_ITEMS;

        $pm_prune_length_seconds = (intval($user_prefs['PM_AUTO_PRUNE']) * DAY_IN_SECONDS);
        $pm_prune_length_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - $pm_prune_length_seconds);

        $sql = "DELETE LOW_PRIORITY FROM PM WHERE (((TYPE & $pm_read > 0) AND TO_UID = '$uid') ";
        $sql.= "OR ((TYPE & $pm_sent_items > 0) AND FROM_UID = '$uid')) ";
        $sql.= "AND CREATED < CAST('$pm_prune_length_datetime' AS DATETIME)";

        if (!db_query($sql, $db_pm_prune_folders)) return false;
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
    if (!$db_pm_prune_folders = db_connect()) return false;

    $pm_prune_length = intval(forum_get_setting('pm_auto_prune', false, 0));

    if ($pm_prune_length > 0) {

        $pm_read = PM_READ;
        $pm_sent_items = PM_SENT_ITEMS;

        $pm_prune_length_seconds = ($pm_prune_length * DAY_IN_SECONDS);
        $pm_prune_length_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - $pm_prune_length_seconds);

        $sql = "DELETE LOW_PRIORITY FROM PM WHERE ((TYPE & $pm_read > 0) OR (TYPE & $pm_sent_items > 0)) ";
        $sql.= "AND CREATED < CAST('$pm_prune_length_datetime' AS DATETIME)";

        if (!db_query($sql, $db_pm_prune_folders)) return false;

        return true;
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

    $mid_list = implode(",", array_filter($mid_array, 'is_numeric'));

    if (!$db_thread_has_attachments = db_connect()) return false;

    $sql = "SELECT PMI.MID, PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS PMI ON (PMI.AID = PAF.AID) ";
    $sql.= "WHERE PMI.MID IN ($mid_list) ";

    if (!$result = db_query($sql, $db_thread_has_attachments)) return false;

    while (($pm_attachment_data = db_fetch_array($result))) {
        $pm_array[$pm_attachment_data['MID']]['AID'] = $pm_attachment_data['AID'];
    }

    return true;
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

    if (!$db_thread_has_attachments = db_connect()) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = db_query($sql, $db_thread_has_attachments)) return false;

    if (db_num_rows($result) > 0) {

        list($aid) = db_fetch_array($result, DB_RESULT_NUM);
        return $aid;
    }

    return false;
}

/**
* Export folder
*
* Fetches the messages in the specified folder for export.
*
* @return bool
* @param integer $folder - Folder to export.
*/

function pm_export_folder($folder)
{
    if ($folder == PM_FOLDER_INBOX) {

        $mid_array = pm_get_inbox();

    }elseif ($folder == PM_FOLDER_SENT) {

        $mid_array = pm_get_sent();

    }elseif ($folder == PM_FOLDER_OUTBOX) {

        $mid_array = pm_get_outbox();

    }elseif ($folder == PM_FOLDER_SAVED) {

        $mid_array = pm_get_saved_items();

    }elseif ($folder == PM_FOLDER_DRAFTS) {

        $mid_array = pm_get_drafts();
    }

    if (!pm_export_messages($mid_array, $folder)) return false;

    return true;
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
        $html.= sprintf("<title>{$lang['pmmessagenumber']}</title>\n", $mid);
    }

    if (@file_exists("styles/style.css")) {
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
    $html = "</body>\n";
    $html.= "</html>\n";

    return $html;
}

function pm_export_messages($mid_array, $folder = PM_FOLDER_NONE)
{
    $logon = mb_strtolower(bh_session_get_value('LOGON'));

    switch ($folder) {

        case PM_FOLDER_INBOX:

            $archive_name = "pm_backup_{$logon}_inbox.zip";
            break;

        case PM_FOLDER_SENT:

            $archive_name = "pm_backup_{$logon}_sent_items.zip";
            break;

        case PM_FOLDER_OUTBOX:

            $archive_name = "pm_backup_{$logon}_outbox.zip";
            break;

        case PM_FOLDER_SAVED:

            $archive_name = "pm_backup_{$logon}_saved_items.zip";
            break;

        case PM_FOLDER_DRAFTS:

            $archive_name = "pm_backup_{$logon}_drafts.zip";
            break;

        default:

            $archive_name = "pm_backup_{$logon}.zip";
            break;
    }

    $pm_export_type = bh_session_get_value('PM_EXPORT_TYPE');
    $pm_export_style = bh_session_get_value('PM_EXPORT_STYLE');

    $zip_file = new zip_file();

    if ($pm_export_style == "Y") {

        if (@file_exists("styles/style.css")) {

            $stylesheet_content = implode("", file("styles/style.css"));
            $zip_file->add_file($stylesheet_content, "styles/style.css");
        }
    }

    switch ($pm_export_type) {

        case PM_EXPORT_HTML:

            if (!pm_export_html($mid_array, $zip_file)) return false;
            break;

        case PM_EXPORT_XML:

            if (!pm_export_xml($mid_array, $zip_file)) return false;
            break;

        case PM_EXPORT_PLAINTEXT:

            if (!pm_export_plaintext($mid_array, $zip_file)) return false;
            break;
    }

    header("Content-Type: application/zip");
    header("Expires: ". gmdate('D, d M Y H:i:s'). " GMT");
    header("Content-Disposition: attachment; filename=\"$archive_name\"");
    header("Pragma: no-cache");
    echo $zip_file->output_zip();
    exit;
}

/**
* Export messages to HTML
*
* Exports messages to HTML and add them to zip file.
*
* @return bool
* @param integer $folder - Folder ID to export
* @param object $zip_file - By Reference zip file object from zip.inc.php class.
*/

function pm_export_html($mid_array, &$zip_file)
{
    if (!is_array($mid_array)) return false;
    if (!is_object($zip_file)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');
    $pm_export_wordfilter = bh_session_get_value('PM_EXPORT_WORDFILTER');

    $pm_display = pm_export_html_top(false);

    if (is_array($mid_array) && sizeof($mid_array) > 0) {

        foreach ($mid_array as $mid) {

            if (($pm_message_array = pm_message_get($mid))) {

                $pm_message_array['FOLDER'] = pm_message_get_folder($mid);
                $pm_message_array['CONTENT'] = pm_get_content($mid);

                if ($pm_export_wordfilter == 'Y') {
                    $pm_message_array = array_map('pm_export_word_filter_apply', $pm_message_array);
                }

                $pm_display.= pm_display_html_export($pm_message_array, $pm_message_array['FOLDER']);

                if ($pm_export_file == PM_EXPORT_SINGLE) {
                    $pm_display.= "<br />\n";
                }

                if ($pm_export_file == PM_EXPORT_MANY) {

                    $pm_display.= pm_export_html_bottom();

                    $filename = sprintf("message_%s.html", $mid);

                    $zip_file->add_file($pm_display, $filename);
                    $pm_display = pm_export_html_top(false);
                }

                if (isset($pm_message_array['AID']) && $pm_export_attachments == 'Y') {
                    pm_export_attachments($pm_message_array['AID'], $pm_message_array['FROM_UID'], $zip_file);
                }
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $pm_display.= pm_export_html_bottom();

            $filename = "messages.html";
            $zip_file->add_file($pm_display, $filename);
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
* @param object $zip_file - By Reference zip file object from zip.inc.php class.
*/

function pm_export_xml($mid_array, &$zip_file)
{
    if (!is_array($mid_array)) return false;
    if (!is_object($zip_file)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');
    $pm_export_wordfilter = bh_session_get_value('PM_EXPORT_WORDFILTER');

    $beehive_version = BEEHIVE_VERSION;

    $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $pm_display.= "  <beehiveforum>\n";
    $pm_display.= "    <version>$beehive_version</version>\n";
    $pm_display.= "    <messages>\n";

    if (is_array($mid_array) && sizeof($mid_array) > 0) {

        foreach ($mid_array as $mid) {

            if (($pm_message_array = pm_message_get($mid))) {

                $pm_message_array['FOLDER'] = pm_message_get_folder($mid);
                $pm_message_array['CONTENT'] = pm_get_content($mid);

                if ($pm_export_wordfilter == 'Y') {
                    $pm_message_array = array_map('pm_export_word_filter_apply', $pm_message_array);
                }

                $pm_display.= "      <message>\n";

                foreach ($pm_message_array as $key => $value) {

                    if (!in_array($key, array('CONTENT', 'AID'))) {

                        $key = mb_strtolower($key);
                        $pm_display.= "        <$key>$value</$key>\n";
                    }
                }

                $pm_display.= "        <content><![CDATA[{$pm_message_array['CONTENT']}]]></content>\n";
                $pm_display.= "      </message>\n";

                if ($pm_export_file == PM_EXPORT_MANY) {

                    $pm_display.= "    </messages>\n";
                    $pm_display.= "  </beehiveforum>\n";

                    $filename = sprintf("message_%s.xml", $mid);

                    $zip_file->add_file($pm_display, $filename);

                    $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
                    $pm_display.= "  <beehiveforum>\n";
                    $pm_display.= "    <messages>\n";
                }

                if (isset($pm_message_array['AID']) && $pm_export_attachments == 'Y') {
                    pm_export_attachments($pm_message_array['AID'], $pm_message_array['FROM_UID'], $zip_file);
                }
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $pm_display.= "    </messages>\n";
            $pm_display.= "  </beehiveforum>\n";

            $filename = "messages.xml";
            $zip_file->add_file($pm_display, $filename);
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
* @param object $zip_file - By Reference zip file object from zip.inc.php class.
*/

function pm_export_plaintext($mid_array, &$zip_file)
{
    if (!is_array($mid_array)) return false;
    if (!is_object($zip_file)) return false;

    $pm_export_file = bh_session_get_value('PM_EXPORT_FILE');
    $pm_export_attachments = bh_session_get_value('PM_EXPORT_ATTACHMENTS');
    $pm_export_wordfilter = bh_session_get_value('PM_EXPORT_WORDFILTER');

    $pm_display = "";

    if (is_array($mid_array) && sizeof($mid_array) > 0) {

        foreach ($mid_array as $mid) {

            if (($pm_message_array = pm_message_get($mid))) {

                $pm_message_array['FOLDER'] = pm_message_get_folder($mid);
                $pm_message_array['CONTENT'] = pm_get_content($mid);

                if ($pm_export_wordfilter == 'Y') {
                    $pm_message_array = array_map('pm_export_word_filter_apply', $pm_message_array);
                }

                foreach ($pm_message_array as $key => $value) {

                    if (!in_array($key, array('CONTENT', 'AID'))) {

                        $key = mb_strtolower($key);
                        $pm_display.= "$key:$value\n";
                    }
                }

                $pm_display.= "content:\r\n\r\n{$pm_message_array['CONTENT']}\r\n\r\n\r\n\r\n";

                if ($pm_export_file == PM_EXPORT_MANY) {

                    $filename = sprintf("message_%s.txt", $mid);

                    $zip_file->add_file($pm_display, $filename);

                    $pm_display = "";
                }

                if (isset($pm_message_array['AID']) && $pm_export_attachments == 'Y') {
                    pm_export_attachments($pm_message_array['AID'], $pm_message_array['FROM_UID'], $zip_file);
                }
            }
        }

        if ($pm_export_file == PM_EXPORT_SINGLE) {

            $filename = "messages.txt";
            $zip_file->add_file($pm_display, $filename);
        }

        return true;
    }

    return false;
}

/**
* Call back function for PM export
*
* Call back function for PM export using word filter. Used to apply word filter
* to an array of elements retrieved from pm_message_get() function.
*
* @return string
* @param string $content - Content to be passed through word filter
*/

function pm_export_word_filter_apply($content)
{
    if (($uid = bh_session_get_value('UID')) === false) return $content;
    return word_filter_apply($content, $uid);
}

/**
* Export attachments
*
* Exports attachments and add them to zip file.
*
* @return bool
* @param md5 $aid - Attachment ID
* @param integer $from_uid - Sender UID to check owner of attachmennt.
* @param object $zip_file - By Reference zip file object from zip.inc.php class.
*/

function pm_export_attachments($aid, $from_uid, &$zip_file)
{
    if (!md5($aid)) return false;
    if (!is_numeric($from_uid)) return false;
    if (!is_object($zip_file)) return false;

    $attachments_added_success = false;

    if (($attachment_dir = attachments_check_dir())) {

        $attachments_array = array();
        $image_attachments_array = array();

        if (get_attachments($from_uid, $aid, $attachments_array, $image_attachments_array)) {

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                foreach ($attachments_array as $attachment) {

                    if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

                        $attachments_added_success = true;
                        $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}"));
                        $zip_file->add_file($attachment_content, "attachments/{$attachment['filename']}");
                    }
                }
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                foreach ($image_attachments_array as $attachment) {

                    if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

                        $attachments_added_success = true;
                        $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}"));
                        $zip_file->add_file($attachment_content, "attachments/{$attachment['filename']}");

                        if (@file_exists("$attachment_dir/{$attachment['hash']}.thumb")) {

                            $attachment_content = implode("", file("$attachment_dir/{$attachment['hash']}.thumb"));
                            $zip_file->add_file($attachment_content, "attachments/{$attachment['filename']}.thumb");
                        }
                    }
                }
            }

            if ($attachments_added_success == true && $attach_img = style_image('attach.png', true)) {

                $attach_img_contents = implode("", file($attach_img));
                $zip_file->add_file($attach_img_contents, $attach_img);
            }
        }
    }

    return true;
}

function pm_get_folder_names()
{
    if (!$db_pm_get_folder_names = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $lang = load_language_file();

    if (defined('BEEHIVEMODE_LIGHT')) {

        $pm_folder_names_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                                       PM_FOLDER_SENT    => $lang['pmsentitems'],
                                       PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                                       PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                                       PM_FOLDER_DRAFTS  => $lang['pmdrafts']);
    }else {

        $pm_folder_names_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                                       PM_FOLDER_SENT    => $lang['pmsentitems'],
                                       PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                                       PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                                       PM_FOLDER_DRAFTS  => $lang['pmdrafts'],
                                       PM_SEARCH_RESULTS => $lang['searchresults']);
    }

    $sql = "SELECT FID, TITLE FROM PM_FOLDERS WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_pm_get_folder_names)) return false;

    if (db_num_rows($result) > 0) {

        while (($folder_name_data = db_fetch_array($result))) {

            if (strlen(trim($folder_name_data['TITLE'])) > 0) {

                $pm_folder_names_array[$folder_name_data['FID']] = $folder_name_data['TITLE'];
            }
        }
    }

    return $pm_folder_names_array;
}

function pm_update_folder_name($folder, $folder_name)
{
    if (!$db_pm_update_folder_name = db_connect()) return false;

    if (!is_numeric($folder)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $folder_name = db_escape_string($folder_name);

    $sql = "INSERT INTO PM_FOLDERS (UID, FID, TITLE) VALUES('$uid', '$folder', '$folder_name') ";
    $sql.= "ON DUPLICATE KEY UPDATE TITLE = VALUES(TITLE)";

    if (!db_query($sql, $db_pm_update_folder_name)) return false;

    return true;
}

function pm_reset_folder_name($folder)
{
    if (!$db_pm_reset_folder_name = db_connect()) return false;

    if (!is_numeric($folder)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "DELETE FROM PM_FOLDERS WHERE UID = '$uid' AND FID = '$folder'";

    if (!db_query($sql, $db_pm_reset_folder_name)) return false;

    return db_affected_rows($db_pm_reset_folder_name) > 0;
}

?>