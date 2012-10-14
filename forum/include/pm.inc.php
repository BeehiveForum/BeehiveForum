<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'ip.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'search.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

function pm_enabled()
{
    if (!forum_get_setting('show_pms', 'Y', false, true)) {
        html_draw_error(gettext("Personal Messages have been disabled by the forum owner."));
    }
}

function pm_mark_as_read($mid)
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    $pm_read = PM_READ;

    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_read', NOTIFIED = 1 ";
    $sql.= "WHERE MID = '$mid' AND TO_UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_edit_refuse()
{
    html_draw_error(gettext("Cannot edit this PM. It has already been viewed by the recipient or the message does not exist or it is inaccessible by you"), 'pm.php', 'get', array('back' => gettext("Back")), array('folder' => PM_FOLDER_OUTBOX));
}

function pm_error_refuse()
{
    html_error_msg(gettext("Cannot view PM. Message does not exist or it is inaccessible by you"), 'pm.php', 'get', array('back' => gettext("Back")), array('folder' => PM_FOLDER_INBOX));
}

function pm_get_inbox($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'PM.FROM_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $message_array = array();

    $pm_inbox_items = PM_INBOX_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_inbox($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array
    );
}

function pm_get_outbox($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'PM.FROM_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $message_array = array();

    $pm_outbox_items = PM_OUTBOX_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_outbox($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array,
    );
}

function pm_get_sent($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'PM.FROM_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $message_array = array();

    $pm_sent_items = PM_SENT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "AND SMID = 0 ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_sent($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array,
    );
}

function pm_get_saved_items($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'PM.FROM_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $message_array = array();

    $pm_saved_out = PM_SAVED_OUT;
    $pm_saved_in  = PM_SAVED_IN;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE ((PM.TYPE & $pm_saved_out > 0) AND PM.FROM_UID = '$uid') OR ";
    $sql.= "((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_saved_items($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array
    );
}

function pm_get_drafts($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'PM.FROM_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $message_array = array();

    $pm_draft_items = PM_DRAFT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "PM.RECIPIENTS, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, FUSER.LOGON AS FLOGON, ";
    $sql.= "TUSER.LOGON AS TLOGON, FUSER.NICKNAME AS FNICK, TUSER.NICKNAME AS TNICK FROM PM PM ";
    $sql.= "LEFT JOIN USER FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "WHERE (PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid' ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_drafts($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array
    );
}

function pm_search_execute($search_string, &$error)
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $sql = "DELETE QUICK FROM PM_SEARCH_RESULTS WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    if (!check_search_frequency()) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    $search_keywords_array = search_extract_keywords($search_string);

    if ($search_keywords_array['filtered_count'] == 0) {

        $error = SEARCH_NO_MATCHES;
        return false;
    }

    $search_string_checked = $db->escape(implode(' ', $search_keywords_array['keywords_array']));

    $pm_max_user_messages = abs(forum_get_setting('pm_max_user_messages', null, 100));
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

    if (!$db->query($sql)) return false;

    if ($db->affected_rows > 0) return true;

    $error = SEARCH_NO_MATCHES;

    return false;
}

function pm_fetch_search_results ($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'PM.SUBJECT',
        'TYPE',
        'PM.FROM_UID',
        'PM.TO_UID',
        'CREATED'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($limit)) $limit = 10;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $message_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM_SEARCH_RESULTS.MID, PM_SEARCH_RESULTS.TYPE, ";
    $sql.= "PM_SEARCH_RESULTS.FROM_UID, PM_SEARCH_RESULTS.TO_UID, PM_SEARCH_RESULTS.RECIPIENTS, ";
    $sql.= "PM_SEARCH_RESULTS.SUBJECT, UNIX_TIMESTAMP(PM_SEARCH_RESULTS.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK FROM PM_SEARCH_RESULTS ";
    $sql.= "LEFT JOIN PM ON (PM.MID = PM_SEARCH_RESULTS.MID) ";
    $sql.= "LEFT JOIN USER FUSER ON (PM_SEARCH_RESULTS.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (PM_SEARCH_RESULTS.TO_UID = TUSER.UID) ";
    $sql.= "WHERE PM_SEARCH_RESULTS.UID = '$uid' AND PM.MID IS NOT NULL ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!$result = $db->query($sql)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = $db->query($sql)) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_fetch_search_results($sort_by, $sort_dir, $page - 1, $limit);
    }

    while (($pm_data = $result->fetch_assoc())) {

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

        if (!isset($pm_data['FLOGON'])) $pm_data['FLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FNICK'])) $pm_data['FNICK'] = "";

        if (!isset($pm_data['TLOGON'])) $pm_data['TLOGON'] = gettext("Unknown user");
        if (!isset($pm_data['TNICK'])) $pm_data['TNICK'] = "";

        $message_array[$pm_data['MID']] = $pm_data;
    }

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array
    );
}

function pm_get_folder_message_counts()
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $message_count_array = array(
        PM_FOLDER_INBOX => 0,
        PM_FOLDER_SENT => 0,
        PM_FOLDER_OUTBOX => 0,
        PM_FOLDER_SAVED => 0,
        PM_FOLDER_DRAFTS => 0
    );

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

    if (!$result = $db->query($sql)) return false;

    while (($pm_data_array = $result->fetch_assoc())) {

        if ($pm_data_array['TYPE'] & PM_INBOX_ITEMS) {

            $message_count_array[PM_FOLDER_INBOX] = $pm_data_array['MESSAGE_COUNT'];

        } else if ($pm_data_array['TYPE'] & PM_SENT_ITEMS) {

            $message_count_array[PM_FOLDER_SENT] = $pm_data_array['MESSAGE_COUNT'];

        } else if ($pm_data_array['TYPE'] & PM_OUTBOX_ITEMS) {

            $message_count_array[PM_FOLDER_OUTBOX] = $pm_data_array['MESSAGE_COUNT'];

        } else if ($pm_data_array['TYPE'] & PM_SAVED_ITEMS) {

            $message_count_array[PM_FOLDER_SAVED] = $pm_data_array['MESSAGE_COUNT'];

        } else if ($pm_data_array['TYPE'] & PM_DRAFT_ITEMS) {

            $message_count_array[PM_FOLDER_DRAFTS] = $pm_data_array['MESSAGE_COUNT'];
        }
    }

    $sql = "SELECT COUNT(PM_SEARCH_RESULTS.MID) AS RESULT_COUNT ";
    $sql.= "FROM PM_SEARCH_RESULTS LEFT JOIN PM ";
    $sql.= "ON (PM.MID = PM_SEARCH_RESULTS.MID) ";
    $sql.= "WHERE UID = '$uid' AND PM.MID IS NOT NULL";

    if (!$result = $db->query($sql)) return false;

    list($search_results_count) = $result->fetch_row();

    $message_count_array[PM_SEARCH_RESULTS] = $search_results_count;

    return $message_count_array;
}

function pm_get_free_space($uid = false)
{
    if (!$db = db::get()) return false;

    if ($uid === false) {
        if (($uid = session::get_value('UID')) === false) return false;
    }

    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', null, 100);

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

    if (!$result = $db->query($sql)) return false;

    list($pm_user_message_count) = $result->fetch_row();

    if ($pm_user_message_count > $pm_max_user_messages) return 0;

    return ($pm_max_user_messages - $pm_user_message_count);
}

function pm_get_user($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT USER.LOGON FROM PM ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = PM.FROM_UID) ";
    $sql.= "WHERE PM.MID = '$mid' AND USER.UID IS NOT NULL";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($logon) = $result->fetch_row();

    return $logon;
}

function pm_user_get_friends()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $user_rel = USER_FRIEND;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = USER_PEER.PEER_UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND (USER_PEER.RELATIONSHIP & $user_rel > 0) ";
    $sql.= "LIMIT 0, 20";

    if (!$result = $db->query($sql)) return false;

    $user_get_peers_array = array();

    $user_get_peers_array[0] = "&lt;select recipient&gt;";

    if ($result->num_rows == 0) return false;

    while (($user_data = $result->fetch_assoc())) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
            if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

            $user_get_peers_array[$user_data['UID']] = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
        }
    }

    return $user_get_peers_array;
}

function pm_get_subject($mid, $to_uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;
    if (!is_numeric($to_uid)) return false;

    $sql = "SELECT SUBJECT FROM PM WHERE MID = '$mid' AND TO_UID = '$to_uid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($pm_subject) = $result->fetch_row();

    return $pm_subject;
}

function pm_message_get($mid)
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!is_numeric($mid)) return false;

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

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

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    if (!($pm_message_array = $result->fetch_assoc())) return false;

    if (!($folder = pm_message_get_folder($mid, $pm_message_array['TYPE']))) return false;

    if (($pm_message_array['TO_UID'] == $uid) && ($pm_message_array['TYPE'] == PM_UNREAD) && ($folder == PM_FOLDER_INBOX)) {
        pm_mark_as_read($mid);
    }

    if (($aid = pm_has_attachments($mid))) {
        $pm_message_array['AID'] = $aid;
    }

    return $pm_message_array;
}

function pm_get_content($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT CONTENT FROM PM_CONTENT WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($pm_content) = $result->fetch_row();

    return $pm_content;
}

function pm_display($pm_message_array, $folder, $preview = false, $export_html = false)
{
    $webtag = get_webtag();

    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\" cellpadding=\"0\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">\n";
    echo "              <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";
    echo "                    <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "                      <tr>\n";

    if ($folder == PM_FOLDER_INBOX) {

        if ($export_html === true) {

            echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("From"), ":&nbsp;</span></td>\n";
            echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(format_user_name($pm_message_array['FLOGON'], $pm_message_array['FNICK']), true), "</span></td>\n";

        } else {

            echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("From"), ":&nbsp;</span></td>\n";
            echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($pm_message_array['FLOGON'], $pm_message_array['FNICK']), true), "</a></span></td>\n";
        }

    } else {

        if (isset($pm_message_array['RECIPIENTS']) && strlen(trim($pm_message_array['RECIPIENTS'])) > 0) {

            $recipient_array = preg_split("/[;|,]/u", trim($pm_message_array['RECIPIENTS']));

            if ($pm_message_array['TO_UID'] > 0) {
                $recipient_array = array_unique(array_merge($recipient_array, array($pm_message_array['TLOGON'])));
            }

            if ($export_html === false) $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

            echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
            echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span></td>\n";

        } else if (is_array($pm_message_array['TLOGON'])) {

            $recipient_array = array_unique($pm_message_array['TLOGON']);

            if ($export_html === false) $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

            echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
            echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span></td>\n";

        } else if (isset($pm_message_array['TO_UID']) && is_numeric($pm_message_array['TO_UID'])) {

            if ($export_html === true) {

                echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
                echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofromlabel\">", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</span></td>\n";

            } else {

                echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
                echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofromlabel\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</a></span></td>\n";
            }

        } else {

            echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
            echo "                        <td align=\"left\" class=\"postbody\"><i>", gettext("No Recipients"), "</i></td>\n";
        }
    }

    // Add emoticons/wikilinks and word filter tags
    $pm_message_array['CONTENT'] = message_apply_formatting($pm_message_array['CONTENT']);
    $pm_message_array['CONTENT'] = word_filter_add_ob_tags($pm_message_array['CONTENT']);

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("Subject"), ":&nbsp;</span></td>\n";

    if (strlen(trim($pm_message_array['SUBJECT'])) > 0) {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags($pm_message_array['SUBJECT'], true), "</span></td>\n";

    } else {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><i>", gettext("No Subject"), "</i></span></td>\n";
    }

    if (isset($pm_message_array['TYPE']) && ($pm_message_array['TYPE'] & PM_SAVED_DRAFT) > 0) {

        echo "                        <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\"><i>", gettext("Not Sent"), "</i>&nbsp;</span></td>\n";

    } else {

        echo "                        <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">", format_time($pm_message_array['CREATED']), "&nbsp;</span></td>\n";
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

        if (attachments_get($pm_message_array['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            // Draw the attachment header at the bottom of the post
            echo "                      <tr>\n";
            echo "                        <td class=\"postbody\" align=\"left\">\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                echo "                              <p><b>", gettext("Attachments"), ":</b><br />\n";

                foreach ($attachments_array as $attachment) {

                    echo "                              ", attachments_make_link($attachment, true, false, $export_html), "<br />\n";
                }

                echo "                              </p>\n";
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                echo "                              <p><b>", gettext("Image Attachments"), ":</b><br />\n";

                foreach ($image_attachments_array as $attachment) {

                    echo "                              ", attachments_make_link($attachment, true, false, $export_html), "\n";
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

            echo "                        <td align=\"center\"><img src=\"", html_style_image('post.png'), "\" border=\"0\" alt=\"", gettext("Reply"), "\" title=\"", gettext("Reply"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;replyto={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Reply"), "</a>&nbsp;&nbsp;<img src=\"", html_style_image('forward.png'), "\" border=\"0\" alt=\"", gettext("Forward"), "\" title=\"", gettext("Forward"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Forward"), "</a></td>\n";

        } else if ($folder == PM_FOLDER_OUTBOX) {

            echo "                        <td align=\"center\"><img src=\"", html_style_image('post.png'), "\" border=\"0\" alt=\"", gettext("Edit"), "\" title=\"", gettext("Edit"), "\" />&nbsp;<a href=\"pm_edit.php?webtag=$webtag&amp;mid={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Edit"), "</a>&nbsp;&nbsp;<img src=\"", html_style_image('forward.png'), "\" border=\"0\" alt=\"", gettext("Forward"), "\" title=\"", gettext("Forward"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Forward"), "</a></td>\n";

        } else if ($folder == PM_FOLDER_DRAFTS) {

            echo "                        <td align=\"center\"><img src=\"", html_style_image('edit.png'), "\" border=\"0\" alt=\"", gettext("Edit"), "\" title=\"", gettext("Edit"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;editmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Edit"), "</a></td>\n";

        } else {

            echo "                        <td align=\"center\"><img src=\"", html_style_image('forward.png'), "\" border=\"0\" alt=\"", gettext("Forward"), "\" title=\"", gettext("Forward"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Forward"), "</a></td>\n";
        }

    } else {

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

    return word_filter_remove_ob_tags($pm_message_html);
}

function pm_message_get_folder($mid, $type = 0)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $pm_message_type_array = array(
        1 => PM_FOLDER_OUTBOX,
        2 => PM_FOLDER_INBOX,
        4 => PM_FOLDER_INBOX,
        8 => PM_FOLDER_SENT,
        16 => PM_FOLDER_SAVED,
        32 => PM_FOLDER_SAVED,
        64 => PM_FOLDER_DRAFTS
    );

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

    if (!$result = $db->query($sql)) return false;

    list($pm_message_type) = $result->fetch_row();

    if (in_array($pm_message_type, array_keys($pm_message_type_array))) {
        return $pm_message_type_array[$pm_message_type];
    }

    return false;
}

function pm_save_attachment_id($mid, $aid)
{
    if (!is_numeric($mid)) return false;
    if (!is_md5($aid)) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows < 1) {

        $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
        $sql.= "VALUES ('$mid', '$aid')";

        if (!$result = $db->query($sql)) return false;

    } else {

        $sql = "UPDATE LOW_PRIORITY PM_ATTACHMENT_IDS SET AID = '$aid' ";
        $sql.= "WHERE MID = '$mid'";

        if (!$result = $db->query($sql)) return false;
    }

    return true;
}

function pm_send_message($to_uid, $from_uid, $subject, $content, $aid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($to_uid)) return false;
    if (!is_numeric($from_uid)) return false;

    if (!is_md5($aid)) return false;

    // Escape the subject and content for insertion into database.
    $subject_escaped = $db->escape($subject);
    $content_escaped = $db->escape($content);

    // PM_OUTBOX constant.
    $pm_outbox = PM_OUTBOX;

    $current_datetime = date(MYSQL_DATETIME, time());

    // Insert the main PM Data into the database
    $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED) VALUES ('$pm_outbox', '$to_uid', '$from_uid', ";
    $sql.= "'$subject_escaped', '', CAST('$current_datetime' AS DATETIME), 0)";

    if ($db->query($sql)) {

        $new_mid = $db->insert_id;

        // Insert the PM Content into the database
        $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
        $sql.= "VALUES ('$new_mid', '$content_escaped')";

        if (!$db->query($sql)) return false;

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

function pm_add_sent_item($sent_item_mid, $to_uid, $from_uid, $subject, $content, $aid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($sent_item_mid)) return false;
    if (!is_numeric($to_uid)) return false;
    if (!is_numeric($from_uid)) return false;

    if (!is_md5($aid)) return false;

    // Escape the subject and content for insertion into database.
    $subject_escaped = $db->escape($subject);
    $content_escaped = $db->escape($content);

    // PM_SENT constant.
    $pm_sent = PM_SENT;

    // Current datetime
    $current_datetime = date(MYSQL_DATETIME, time());

    // Insert the main PM Data into the database
    $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED, SMID) VALUES ('$pm_sent', '$to_uid', '$from_uid', ";
    $sql.= "'$subject_escaped', '', CAST('$current_datetime' AS DATETIME), ";
    $sql.= "1, '$sent_item_mid')";

    if ($db->query($sql)) {

        $new_mid = $db->insert_id;

        // Insert the PM Content into the database
        $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
        $sql.= "VALUES ('$new_mid', '$content_escaped')";

        if (!$db->query($sql)) return false;

        // Save the attachment ID.
        pm_save_attachment_id($new_mid, $aid);

        return  $new_mid;
    }

    return false;
}

function pm_save_message($subject, $content, $to_uid, $recipient_list)
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!is_numeric($to_uid)) return false;

    $subject = $db->escape($subject);
    $recipient_list = $db->escape($recipient_list);
    $content = $db->escape($content);

    $pm_saved_draft = PM_SAVED_DRAFT;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (pm_get_free_space($uid) > 0) {

        // Insert the main PM Data into the database
        $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
        $sql.= "CREATED, NOTIFIED) VALUES ('$pm_saved_draft', '$to_uid', '$uid', '$subject', ";
        $sql.= "'$recipient_list', CAST('$current_datetime' AS DATETIME), 0)";

        if ($db->query($sql)) {

            $new_mid = $db->insert_id;

            // Insert the PM Content into the database
            $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
            $sql.= "VALUES ('$new_mid', '$content')";

            if (!$db->query($sql)) return false;

            return  $new_mid;
        }
    }

    return false;
}

function pm_update_saved_message($mid, $subject, $content, $to_uid, $recipient_list)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;
    if (!is_numeric($to_uid)) return false;

    $subject = $db->escape($subject);
    $content = $db->escape($content);

    $recipient_list = $db->escape($recipient_list);

    // Update the subject text
    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject', TO_UID = '$to_uid', ";
    $sql.= "RECIPIENTS = '$recipient_list' WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    // Update the content
    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";
    if (!$db->query($sql)) return false;

    return true;
}

function pm_edit_message($mid, $subject, $content)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $subject_escaped = $db->escape($subject);
    $content_escaped = $db->escape($content);

    // Update the subject text
    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject_escaped' WHERE MID = '$mid'";
    if (!$db->query($sql)) return false;

    // Update the content
    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content_escaped' WHERE MID = '$mid'";
    if (!$db->query($sql)) return false;

    return pm_update_sent_item($mid, $subject, $content);
}

function pm_update_sent_item($mid, $subject, $content)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $subject = $db->escape($subject);
    $content = $db->escape($content);

    // Query the database for the sent item's MID
    $sql = "SELECT MID FROM PM WHERE SMID = '$mid'";
    if (!$result = $db->query($sql)) return false;

    // Fetch the SMID.
    list($sent_item_mid) = $result->fetch_row();

    // Update the sent items subject text
    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject' WHERE MID = '$sent_item_mid'";
    if (!$db->query($sql)) return false;

    // Update the sent item content
    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$sent_item_mid'";
    if (!$db->query($sql)) return false;

    return true;
}

function pm_delete_message($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_sent_items = PM_SENT_ITEMS;
    $pm_saved_out = PM_SAVED_OUT;
    $pm_saved_in  = PM_SAVED_IN;
    $pm_draft_items = PM_DRAFT_ITEMS;

    if (($uid = session::get_value('UID')) === false) return false;

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
    $sql.= "AND PM.MID = '$mid' GROUP BY PM.MID LIMIT 1";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $result_row = $result->fetch_assoc();

    if ($result_row['TYPE'] == PM_SENT && isset($result_row['AID'])) {
        attachments_delete_by_aid($result_row['AID']);
    }

    $sql = "DELETE QUICK FROM PM WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    $sql = "DELETE QUICK FROM PM_CONTENT WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    return true;
}

function pm_delete_messages($messages_array)
{
    if (!is_array($messages_array)) return false;

    $messages_array = array_filter($messages_array, 'is_numeric');

    if (sizeof($messages_array) < 1) return false;

    foreach ($messages_array as $mid) {
        if (!pm_delete_message($mid)) return false;
    }

    return true;
}

function pm_archive_message($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $pm_saved_in  = PM_SAVED_IN;
    $pm_saved_out = PM_SAVED_OUT;

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_sent_items  = PM_SENT_ITEMS;

    // Archive any PM that are in the User's Inbox
    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_saved_in' ";
    $sql.= "WHERE MID = '$mid' AND (TYPE & $pm_inbox_items > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!$db->query($sql)) return false;

    // Archive any PM that are in the User's Sent Items
    $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_saved_out' ";
    $sql.= "WHERE MID = '$mid' AND (TYPE & $pm_sent_items > 0) ";
    $sql.= "AND SMID = 0 AND FROM_UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_archive_messages($messages_array)
{
    if (!is_array($messages_array)) return false;

    $messages_array = array_filter($messages_array, 'is_numeric');

    if (sizeof($messages_array) < 1) return false;

    foreach ($messages_array as $mid) {
        if (!pm_archive_message($mid)) return false;
    }

    return true;
}

function pm_get_new_messages($limit)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($limit)) return false;

    $limit = abs($limit);

    if (($uid = session::get_value('UID')) === false) return false;

    $pm_outbox = PM_OUTBOX;

    $sql = "SELECT MID, TYPE, TO_UID, FROM_UID, SUBJECT, RECIPIENTS, ";
    $sql.= "CREATED, NOTIFIED, SMID FROM PM WHERE TYPE = '$pm_outbox' ";
    $sql.= "AND TO_UID = '$uid' ORDER BY CREATED ASC ";
    $sql.= "LIMIT $limit";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $pm_new_message_array = array();

    while (($pm_data = $result->fetch_assoc())) {
        $pm_new_message_array[$pm_data['MID']] = $pm_data;
    }

    return $pm_new_message_array;
}

function pm_get_message_count(&$pm_new_count, &$pm_outbox_count, &$pm_unread_count)
{
    // Default the variables to return 0 even on error.
    $pm_new_count = 0;
    $pm_outbox_count = 0;
    $pm_unread_count = 0;

    // Connect to the database.
    if (!$db = db::get()) return false;

    // Check the user UID.
    if (($uid = session::get_value('UID')) === false) return false;

    // PM folder types we'll be using.
    $pm_unread = PM_UNREAD;
    $pm_outbox = PM_OUTBOX;
    $pm_sent_item = PM_SENT;

    // Get the user's free space.
    $pm_free_space = pm_get_free_space($uid);

    // Get a list of messages we have received.
    if (($messages_array = pm_get_new_messages($pm_free_space))) {

        // Convert the array keys into a comma separated list.
        $mid_list = implode(',', array_filter(array_keys($messages_array), 'is_numeric'));

        // Mark the selected messages as unread / received and make the
        // sent items visible to the sender.
        $sql = "UPDATE LOW_PRIORITY PM SET TYPE = '$pm_unread' WHERE MID in ($mid_list) ";
        $sql.= "AND TO_UID = '$uid'";

        if (!$result = $db->query($sql)) return false;

        $sql = "UPDATE LOW_PRIORITY PM SET SMID = 0 WHERE SMID IN ($mid_list) ";
        $sql.= "AND TYPE = '$pm_sent_item' AND TO_UID = '$uid'";

        if (!$result = $db->query($sql)) return false;

        // Number of new messages we've received for popup.
        $pm_new_count = sizeof($messages_array);
    }

    // Unread message count.
    $sql = "SELECT COUNT(MID) FROM PM WHERE (TYPE & $pm_unread > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    list($pm_unread_count) = $result->fetch_row();

    // Check for any undelivered messages waiting for the user.
    $sql = "SELECT COUNT(MID) AS OUTBOX_COUNT FROM PM ";
    $sql.= "WHERE TYPE = '$pm_outbox' AND TO_UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    list($pm_outbox_count) = $result->fetch_row();

    return true;
}

function pm_check_messages()
{
    // Get the number of messages.
    pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

    // Disabled for Guests
    if (!session::logged_in()) return false;

    // Check if the user wants Javascript notifcation.
    if (session::get_value('PM_NOTIFY') == 'Y') {

        // Format the message sent to the client.
        if ($pm_new_count == 1 && $pm_outbox_count == 0) {

            $pm_notification = gettext("You have 1 new message. Would you like to go to your Inbox now?");

        } else if ($pm_new_count == 1 && $pm_outbox_count == 1) {

            $pm_notification = gettext("You have 1 new message.\r\n\r\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?");

        } else if ($pm_new_count == 0 && $pm_outbox_count == 1) {

            $pm_notification = gettext("You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?");

        } else if ($pm_new_count > 1 && $pm_outbox_count == 0) {

            $pm_notification = sprintf(gettext("You have %d new messages. Would you like to go to your Inbox now?"), $pm_new_count);

        } else if ($pm_new_count > 1 && $pm_outbox_count == 1) {

            $pm_notification = sprintf(gettext("You have %d new messages.\r\n\r\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?"), $pm_new_count);

        } else if ($pm_new_count > 1 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have %d new messages.\r\n\r\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?"), $pm_new_count, $pm_outbox_count);

        } else if ($pm_new_count == 1 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have 1 new message.\r\n\r\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?"), $pm_outbox_count);

        } else if ($pm_new_count == 0 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\r\n\r\nWould you like to go to your Inbox now?"), $pm_outbox_count);
        }
    }

    $pm_notification_data = array();

    if ($pm_new_count > 0) {
        $pm_notification_data['text'] = sprintf('[%d %s]', $pm_new_count, gettext("New"));
    } else if ($pm_unread_count > 0) {
        $pm_notification_data['text'] = sprintf('[%d %s]', $pm_unread_count, gettext("Unread"));
    }

    if (isset($pm_notification) && strlen(trim($pm_notification)) > 0) {
        $pm_notification_data['notification'] = wordwrap($pm_notification, 65, "\n");
    }

    return $pm_notification_data;
}

function pm_get_unread_count()
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    // Guests don't do PMs.
    if (!session::logged_in()) return false;

    $pm_unread = PM_UNREAD;

    // Check to see if the user has any new PMs
    $sql = "SELECT COUNT(MID) FROM PM WHERE (TYPE & $pm_unread > 0) ";
    $sql.= "AND TO_UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    list($pm_unread_count) = $result->fetch_row();

    return $pm_unread_count;
}

function pm_user_prune_folders($uid = false)
{
    if (!$db = db::get()) return false;

    if ($uid === false) {
        if (($uid = session::get_value('UID')) === false) return false;
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

        if (!$db->query($sql)) return false;
    }

    return true;
}

function pm_system_prune_folders()
{
    if (!$db = db::get()) return false;

    if (($pm_prune_length = intval(forum_get_setting('pm_auto_prune', null, 0))) > 0) {

        $pm_read = PM_READ;
        $pm_sent_items = PM_SENT_ITEMS;

        $pm_prune_length_seconds = ($pm_prune_length * DAY_IN_SECONDS);
        $pm_prune_length_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - $pm_prune_length_seconds);

        $sql = "DELETE LOW_PRIORITY FROM PM WHERE ((TYPE & $pm_read > 0) OR (TYPE & $pm_sent_items > 0)) ";
        $sql.= "AND CREATED < CAST('$pm_prune_length_datetime' AS DATETIME)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function pm_auto_prune_enabled()
{
    if (($uid = session::get_value('UID')) === false) return false;

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) return true;

    $pm_prune_length = intval(forum_get_setting('pm_auto_prune', null, 0));

    return ($pm_prune_length > 0);
}

function pms_have_attachments(&$message_array)
{
    if (!is_array($message_array)) return false;

    if (sizeof($message_array) < 1) return false;

    $mid_list = implode(',', array_filter(array_keys($message_array), 'is_numeric'));

    if (!$db = db::get()) return false;

    $sql = "SELECT PMI.MID, PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN PM_ATTACHMENT_IDS PMI ON (PMI.AID = PAF.AID) ";
    $sql.= "WHERE PMI.MID IN ($mid_list) ";

    if (!$result = $db->query($sql)) return false;

    while (($pm_attachment_data = $result->fetch_assoc())) {
        $message_array[$pm_attachment_data['MID']]['AID'] = $pm_attachment_data['AID'];
    }

    return true;
}

function pm_has_attachments($mid)
{
    if (!is_numeric($mid)) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($aid) = $result->fetch_row();

    return $aid;
}

function pm_export_folders($pm_folders_array, $options_array)
{
    if (!is_array($pm_folders_array)) return false;
    if (!is_array($options_array)) return false;

    $messages_array = array();

    foreach ($pm_folders_array as $folder) {

        $folder_messages_array = array();

        switch ($folder) {

            case PM_FOLDER_INBOX:

                $folder_messages_array = pm_get_inbox();
                break;

            case PM_FOLDER_SENT:

                $folder_messages_array = pm_get_sent();
                break;

            case PM_FOLDER_OUTBOX:

                $folder_messages_array = pm_get_outbox();
                break;

            case PM_FOLDER_SAVED:

                $folder_messages_array = pm_get_saved_items();
                break;

            case PM_FOLDER_DRAFTS:

                $folder_messages_array = pm_get_drafts();
                break;
        }

        if (sizeof($folder_messages_array) > 0) {
            $messages_array = array_merge($messages_array, array_keys($folder_messages_array['message_array']));
        }
    }

    if (!pm_export_messages($messages_array, $options_array)) return false;

    return true;
}

function pm_export_html_top($message = null)
{
    $html = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    $html.= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"". gettext("en-gb"). "\" lang=\"". gettext("en-gb"). "\" dir=\"". gettext("ltr"). "\">\n";
    $html.= "<head>\n";

    if (isset($message['SUBJECT']) && isset($message['MID'])) {
        $html.= sprintf("<title>%s - %s</title>\n", gettext("Message"), htmlentities_array($message['SUBJECT']));
    } else {
        $html.= "<title>". gettext("Messages"). "</title>\n";
    }

    if (@file_exists("styles/style.css")) {
        $html.= "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
    }

    $html.= "</head>\n";
    $html.= "<body>\n";

    return $html;
}

function pm_export_html_bottom()
{
    $html = "</body>\n";
    $html.= "</html>\n";

    return $html;
}

function pm_export_messages($messages_array, $options_array = array())
{
    if (!is_array($messages_array)) return false;

    $messages_array = array_filter($messages_array, 'is_numeric');

    if (sizeof($messages_array) < 1) return false;

    if (!is_array($options_array)) $options_array = array();

    $logon = mb_strtolower(session::get_value('LOGON'));

    if (!isset($options_array['PM_EXPORT_TYPE'])) {
        $options_array['PM_EXPORT_TYPE'] = session::get_value('PM_EXPORT_TYPE');
    }

    if (!isset($options_array['PM_EXPORT_STYLE'])) {
        $options_array['PM_EXPORT_STYLE'] = session::get_value('PM_EXPORT_STYLE');
    }

    $zip_file = new zip_file();

    if (($options_array['PM_EXPORT_STYLE'] == "Y") && (@file_exists("styles/style.css"))) {
        $zip_file->add_file(file_get_contents("styles/style.css"), "styles/style.css");
    }

    switch ($options_array['PM_EXPORT_TYPE']) {

        case PM_EXPORT_HTML:

            if (!pm_export_html($messages_array, $zip_file, $options_array)) return false;
            break;

        case PM_EXPORT_XML:

            if (!pm_export_xml($messages_array, $zip_file, $options_array)) return false;
            break;

        case PM_EXPORT_CSV:

            if (!pm_export_csv($messages_array, $zip_file, $options_array)) return false;
            break;
    }

    header("Content-Type: application/zip");
    header("Expires: ". gmdate('D, d M Y H:i:s'). " GMT");
    header("Content-Disposition: attachment; filename=\"pm_backup_{$logon}.zip\"");
    header("Pragma: no-cache");

    echo $zip_file->output_zip();

    exit;
}

function pm_export_html($messages_array, &$zip_file, $options_array = array())
{
    if (!is_array($messages_array)) return false;

    if (!is_object($zip_file)) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_FILE'])) {
        $options_array['PM_EXPORT_FILE'] = session::get_value('PM_EXPORT_FILE');
    }

    if (!isset($options_array['PM_EXPORT_ATTACHMENTS'])) {
        $options_array['PM_EXPORT_ATTACHMENTS'] = session::get_value('PM_EXPORT_ATTACHMENTS');
    }

    if (!isset($options_array['PM_EXPORT_WORDFILTER'])) {
        $options_array['PM_EXPORT_WORDFILTER'] = session::get_value('PM_EXPORT_WORDFILTER');
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {
        $pm_display = pm_export_html_top();
    }

    if (sizeof($messages_array) == 0) return false;

    foreach ($messages_array as $mid) {

        if (!($message = pm_message_get($mid))) return false;

        if (isset($message['AID']) && ($options_array['PM_EXPORT_ATTACHMENTS'] == 'Y')) {
            pm_export_attachments($message['AID'], $message['FROM_UID'], $zip_file);
        }

        $message['FOLDER'] = pm_message_get_folder($message['MID']);
        $message['CONTENT'] = pm_get_content($message['MID']);

        if ($options_array['PM_EXPORT_WORDFILTER'] == 'Y') {
            $message = array_map('pm_export_word_filter_apply', $message);
        }

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {
            $pm_display = pm_export_html_top($message);
        }

        $pm_display.= pm_display_html_export($message, $message['FOLDER']);

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {
            $pm_display.= "<br />\n";
        }

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {

            $pm_display.= pm_export_html_bottom();

            $zip_file->add_file($pm_display, sprintf("message_%s.html", $message['MID']));
        }
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {

        $pm_display.= pm_export_html_bottom();

        $zip_file->add_file($pm_display, "messages.html");
    }

    return true;
}

function pm_export_xml($messages_array, &$zip_file, $options_array = array())
{
    if (!is_array($messages_array)) return false;

    if (!is_object($zip_file)) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_FILE'])) {
        $options_array['PM_EXPORT_FILE'] = session::get_value('PM_EXPORT_FILE');
    }

    if (!isset($options_array['PM_EXPORT_ATTACHMENTS'])) {
        $options_array['PM_EXPORT_ATTACHMENTS'] = session::get_value('PM_EXPORT_ATTACHMENTS');
    }

    if (!isset($options_array['PM_EXPORT_WORDFILTER'])) {
        $options_array['PM_EXPORT_WORDFILTER'] = session::get_value('PM_EXPORT_WORDFILTER');
    }

    if (sizeof($messages_array) == 0) return false;

    $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $pm_display.= "  <beehiveforum>\n";
    $pm_display.= "    <messages>\n";

    foreach ($messages_array as $mid) {

        if (!($message = pm_message_get($mid))) return false;

        if (isset($message['AID']) && ($options_array['PM_EXPORT_ATTACHMENTS'] == 'Y')) {
            pm_export_attachments($message['AID'], $message['FROM_UID'], $zip_file);
        }

        $message['FOLDER'] = pm_message_get_folder($message['MID']);
        $message['CONTENT'] = pm_get_content($message['MID']);

        if ($options_array['PM_EXPORT_WORDFILTER'] == 'Y') {
            $message = array_map('pm_export_word_filter_apply', $message);
        }

        unset($message['AID']);

        $pm_display.= "      <message>\n";

        foreach ($message as $key => $value) {
            $pm_display.= sprintf('        <%1$s><![CDATA[%2$s]]></%1$s>', $key, $value);
        }

        $pm_display.= "      </message>\n";

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {

            $pm_display.= "    </messages>\n";
            $pm_display.= "  </beehiveforum>\n";

            $zip_file->add_file($pm_display, sprintf("message_%s.xml", $message['MID']));

            $pm_display = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $pm_display.= "  <beehiveforum>\n";
            $pm_display.= "    <messages>\n";
        }
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {

        $pm_display.= "    </messages>\n";
        $pm_display.= "  </beehiveforum>\n";

        $zip_file->add_file($pm_display, "messages.xml");
    }

    return true;
}

function pm_export_csv($messages_array, &$zip_file, $options_array = array())
{
    if (!is_array($messages_array)) return false;

    if (!is_object($zip_file)) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_FILE'])) {
        $options_array['PM_EXPORT_FILE'] = session::get_value('PM_EXPORT_FILE');
    }

    if (!isset($options_array['PM_EXPORT_ATTACHMENTS'])) {
        $options_array['PM_EXPORT_ATTACHMENTS'] = session::get_value('PM_EXPORT_ATTACHMENTS');
    }

    if (!isset($options_array['PM_EXPORT_WORDFILTER'])) {
        $options_array['PM_EXPORT_WORDFILTER'] = session::get_value('PM_EXPORT_WORDFILTER');
    }

    if (sizeof($messages_array) == 0) return false;

    $pm_csv_export = fopen('php://temp', 'w');

    $pm_csv_header = array(
        'MID',
        'TYPE',
        'FROM_UID',
        'TO_UID',
        'SUBJECT',
        'RECIPIENTS',
        'CREATED',
        'FLOGON',
        'TLOGON',
        'FNICK',
        'TNICK',
        'FOLDER',
        'CONTENT'
    );

    if (!fputcsv($pm_csv_export, $pm_csv_header)) return false;

    foreach ($messages_array as $mid) {

        if (!($message = pm_message_get($mid))) return false;

        if (isset($message['AID']) && ($options_array['PM_EXPORT_ATTACHMENTS'] == 'Y')) {
            pm_export_attachments($message['AID'], $message['FROM_UID'], $zip_file);
        }

        $message['FOLDER'] = pm_message_get_folder($message['MID']);

        $message['CONTENT'] = preg_replace("[\r\n|\r|\n]", '\n', pm_get_content($message['MID']));

        $message['CREATED'] = date('Y-m-d H:i:s', $message['CREATED']);

        if ($options_array['PM_EXPORT_WORDFILTER'] == 'Y') {
            $message = array_map('pm_export_word_filter_apply', $message);
        }

        unset($message['AID']);

        if (!fputcsv($pm_csv_export, $message)) return false;

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {

            rewind($pm_csv_export);

            $pm_csv_contents = '';

            while (!feof($pm_csv_export)) {
                $pm_csv_contents.= fgets($pm_csv_export);
            }

            $zip_file->add_file($pm_csv_contents, sprintf("message_%s.csv", $message['MID']));

            fclose($pm_csv_export);

            $pm_csv_export = fopen('php://temp', 'r+');

            if (!fputcsv($pm_csv_export, $pm_csv_header)) return false;
        }
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {

        rewind($pm_csv_export);

        $pm_csv_contents = '';

        while (!feof($pm_csv_export)) {
            $pm_csv_contents.= fgets($pm_csv_export);
        }

        $zip_file->add_file($pm_csv_contents, 'messages.csv');
    }

    fclose($pm_csv_export);

    return true;
}

function pm_export_word_filter_apply($content)
{
    if (($uid = session::get_value('UID')) === false) return $content;
    return word_filter_apply($content, $uid);
}

function pm_export_attachments($aid, $from_uid, &$zip_file)
{
    if (!md5($aid)) return false;
    if (!is_numeric($from_uid)) return false;
    if (!is_object($zip_file)) return false;

    $attachments_added_success = false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $attachments_array = array();

    $image_attachments_array = array();

    if (!attachments_get($from_uid, $aid, $attachments_array, $image_attachments_array)) return false;

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

    if ($attachments_added_success == true && $attach_img = html_style_image('attach.png', true)) {

        $attach_img_contents = implode("", file($attach_img));
        $zip_file->add_file($attach_img_contents, $attach_img);
    }

    return true;
}

function pm_get_folder_names($include_search_results = true)
{
    if (defined('BEEHIVEMODE_LIGHT')) {

        $pm_folder_names_array = array(
            PM_FOLDER_INBOX => gettext("Inbox"),
            PM_FOLDER_SENT => gettext("Sent Items"),
            PM_FOLDER_OUTBOX => gettext("Outbox"),
            PM_FOLDER_SAVED => gettext("Saved Items"),
            PM_FOLDER_DRAFTS => gettext("Drafts")
        );

    } else {

        $pm_folder_names_array = array(
            PM_FOLDER_INBOX => gettext("Inbox"),
            PM_FOLDER_SENT => gettext("Sent Items"),
            PM_FOLDER_OUTBOX => gettext("Outbox"),
            PM_FOLDER_SAVED => gettext("Saved Items"),
            PM_FOLDER_DRAFTS => gettext("Drafts")
        );

        if ($include_search_results === true) {
            $pm_folder_names_array[PM_SEARCH_RESULTS] = gettext("Search Results");
        }
    }

    if (!$db = db::get()) return $pm_folder_names_array;

    if (($uid = session::get_value('UID')) === false) return $pm_folder_names_array;

    $sql = "SELECT FID, TITLE FROM PM_FOLDERS WHERE UID = '$uid'";

    if (!$result = $db->query($sql)) return $pm_folder_names_array;

    if ($result->num_rows == 0) return $pm_folder_names_array;

    while (($folder_name_data = $result->fetch_assoc())) {

        if (strlen(trim($folder_name_data['TITLE'])) == 0) continue;
        $pm_folder_names_array[$folder_name_data['FID']] = $folder_name_data['TITLE'];
    }

    return $pm_folder_names_array;
}

function pm_update_folder_name($folder, $folder_name)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($folder)) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $folder_name = $db->escape($folder_name);

    $sql = "INSERT INTO PM_FOLDERS (UID, FID, TITLE) VALUES('$uid', '$folder', '$folder_name') ";
    $sql.= "ON DUPLICATE KEY UPDATE TITLE = VALUES(TITLE)";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_reset_folder_name($folder)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($folder)) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $sql = "DELETE FROM PM_FOLDERS WHERE UID = '$uid' AND FID = '$folder'";

    if (!$db->query($sql)) return false;

    return $db->affected_rows > 0;
}

?>