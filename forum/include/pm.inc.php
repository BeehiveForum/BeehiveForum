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

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

function pm_enabled()
{
    if (!forum_get_setting('show_pms', 'Y', false)) {
        html_draw_error(gettext("Personal Messages have been disabled by the forum owner."));
    }
}

function pm_mark_as_read($mid)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($mid)) return false;

    $pm_read = PM_READ;

    $pm_unread = PM_UNREAD;

    $sql = "UPDATE PM_TYPE SET TYPE = '$pm_read' WHERE MID = '$mid' ";
    $sql .= "AND TYPE = '$pm_unread' AND UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_edit_refuse()
{
    html_draw_error(gettext("Cannot edit this PM. It has already been viewed by the recipient or the message does not exist or it is inaccessible by you"), 'pm.php', 'get', array('back' => gettext("Back")), array('folder' => PM_FOLDER_OUTBOX));
}

function pm_error_refuse()
{
    html_draw_error(gettext("Cannot view PM. Message does not exist or it is inaccessible by you"), 'pm.php', 'get', array('back' => gettext("Back")), array('folder' => PM_FOLDER_INBOX));
}

function pm_get_inbox($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $pm_inbox_items = PM_INBOX_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM_TYPE.TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME FROM PM INNER JOIN PM_RECIPIENT ";
    $sql .= "ON (PM_RECIPIENT.MID = PM.MID AND PM_RECIPIENT.TO_UID = '{$_SESSION['UID']}') ";
    $sql .= "INNER JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = '{$_SESSION['UID']}' ";
    $sql .= "AND PM_TYPE.TYPE & $pm_inbox_items) LEFT JOIN USER ";
    $sql .= "ON (USER.UID = PM.FROM_UID) GROUP BY PM.MID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_inbox($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_outbox($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);;

    $pm_outbox = PM_OUTBOX;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, $pm_outbox AS TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME, COUNT(PM_RECIPIENT.TO_UID) AS RECIPIENT_COUNT, ";
    $sql .= "COALESCE(OUTBOX.COUNT, 0) AS OUTBOX_COUNT FROM PM LEFT JOIN USER ON (USER.UID = PM.FROM_UID) ";
    $sql .= "INNER JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = '{$_SESSION['UID']}') ";
    $sql .= "INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) LEFT JOIN (SELECT PM_TYPE.MID, ";
    $sql .= "COUNT(*) AS COUNT FROM PM_TYPE WHERE (PM_TYPE.TYPE & $pm_outbox) ";
    $sql .= "GROUP BY PM_TYPE.MID) AS OUTBOX ON (OUTBOX.MID = PM.MID) ";
    $sql .= "WHERE PM.FROM_UID = '{$_SESSION['UID']}' ";
    $sql .= "GROUP BY PM.MID HAVING RECIPIENT_COUNT = OUTBOX_COUNT ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_outbox($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_sent($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $pm_outbox_items = PM_OUTBOX_ITEMS;

    $pm_sent_items = PM_SENT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM_TYPE.TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME, COUNT(PM_RECIPIENT.TO_UID) AS RECIPIENT_COUNT, ";
    $sql .= "COALESCE(OUTBOX.COUNT, 0) AS OUTBOX_COUNT FROM PM INNER JOIN PM_RECIPIENT ";
    $sql .= "ON (PM_RECIPIENT.MID = PM.MID) INNER JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID ";
    $sql .= "AND PM_TYPE.UID = PM.FROM_UID) LEFT JOIN (SELECT PM_TYPE.MID, COUNT(*) AS COUNT ";
    $sql .= "FROM PM_TYPE WHERE (PM_TYPE.TYPE & $pm_outbox_items) GROUP BY PM_TYPE.MID) AS OUTBOX ";
    $sql .= "ON (OUTBOX.MID = PM.MID) LEFT JOIN USER ON (USER.UID = PM.FROM_UID) ";
    $sql .= "WHERE (PM_TYPE.TYPE & $pm_sent_items) AND PM.FROM_UID = '{$_SESSION['UID']}' ";
    $sql .= "GROUP BY PM.MID HAVING OUTBOX_COUNT < RECIPIENT_COUNT ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_sent($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_saved_items($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $pm_saved_items = PM_SAVED_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM_TYPE.TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME FROM PM INNER JOIN PM_TYPE ";
    $sql .= "ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = '{$_SESSION['UID']}' ";
    $sql .= "AND PM_TYPE.TYPE & $pm_saved_items) LEFT JOIN USER ";
    $sql .= "ON (USER.UID = PM.FROM_UID) GROUP BY PM.MID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_saved_items($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_drafts($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $limit = abs($limit);

    $offset = calculate_page_offset($page, $limit);

    $pm_draft_items = PM_DRAFT_ITEMS;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM_TYPE.TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME FROM PM INNER JOIN PM_TYPE ";
    $sql .= "ON (PM_TYPE.MID = PM.MID AND PM_TYPE.TYPE & $pm_draft_items) ";
    $sql .= "LEFT JOIN USER ON (USER.UID = PM.FROM_UID) ";
    $sql .= "WHERE PM.FROM_UID = '{$_SESSION['UID']}' GROUP BY PM.MID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_get_drafts($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_recipients(&$message_data)
{
    if (!isset($message_data['MID'])) return false;

    if (!is_numeric($message_data['MID'])) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($db = db::get())) return false;

    $sql = "SELECT PM_RECIPIENT.MID, PM_RECIPIENT.TO_UID, PM_RECIPIENT.NOTIFIED, ";
    $sql .= "USER.LOGON AS TO_LOGON, USER.NICKNAME TO_NICKNAME FROM PM_RECIPIENT ";
    $sql .= "LEFT JOIN USER ON (USER.UID = PM_RECIPIENT.TO_UID) ";
    $sql .= "WHERE PM_RECIPIENT.MID = '{$message_data['MID']}' ";
    $sql .= "ORDER BY PM_RECIPIENT.TO_UID <> '{$_SESSION['UID']}'";

    if (!($result = $db->query($sql))) return false;

    while (($pm_user_data = $result->fetch_assoc()) !== null) {

        if (!isset($pm_user_data['FROM_LOGON'])) $pm_user_data['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($pm_user_data['FROM_NICKNAME'])) $pm_user_data['FROM_NICKNAME'] = "";

        if (!isset($pm_user_data['TO_LOGON'])) $pm_user_data['TO_LOGON'] = gettext("Unknown user");
        if (!isset($pm_user_data['TO_NICKNAME'])) $pm_user_data['TO_NICKNAME'] = "";

        if (!isset($message_data['RECIPIENTS'])) {
            $message_data['RECIPIENTS'] = array();
        }

        $message_data['RECIPIENTS'][] = array(
            'UID' => $pm_user_data['TO_UID'],
            'LOGON' => $pm_user_data['TO_LOGON'],
            'NICKNAME' => $pm_user_data['TO_NICKNAME'],
            'NOTIFIED' => $pm_user_data['NOTIFIED'],
        );
    }

    return true;
}

function pms_get_recipients(&$message_array)
{
    if (!is_array($message_array)) return false;

    $mid_list = implode(',', array_filter(array_keys($message_array), 'is_numeric'));

    if (sizeof($message_array) < 1) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($db = db::get())) return false;

    $sql = "SELECT PM_RECIPIENT.MID, PM_RECIPIENT.TO_UID, PM_RECIPIENT.NOTIFIED, ";
    $sql .= "USER.LOGON AS TO_LOGON, USER.NICKNAME TO_NICKNAME FROM PM_RECIPIENT ";
    $sql .= "LEFT JOIN USER ON (USER.UID = PM_RECIPIENT.TO_UID) ";
    $sql .= "WHERE PM_RECIPIENT.MID IN ($mid_list) ";
    $sql .= "ORDER BY PM_RECIPIENT.TO_UID <> '{$_SESSION['UID']}'";

    if (!($result = $db->query($sql))) return false;

    while (($pm_user_data = $result->fetch_assoc()) !== null) {

        if (!isset($pm_user_data['FROM_LOGON'])) $pm_user_data['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($pm_user_data['FROM_NICKNAME'])) $pm_user_data['FROM_NICKNAME'] = "";

        if (!isset($pm_user_data['TO_LOGON'])) $pm_user_data['TO_LOGON'] = gettext("Unknown user");
        if (!isset($pm_user_data['TO_NICKNAME'])) $pm_user_data['TO_NICKNAME'] = "";

        if (!isset($message_array[$pm_user_data['MID']]['RECIPIENTS'])) {
            $message_array[$pm_user_data['MID']]['RECIPIENTS'] = array();
        }

        $message_array[$pm_user_data['MID']]['RECIPIENTS'][] = array(
            'UID' => $pm_user_data['TO_UID'],
            'LOGON' => $pm_user_data['TO_LOGON'],
            'NICKNAME' => $pm_user_data['TO_NICKNAME'],
            'NOTIFIED' => $pm_user_data['NOTIFIED'],
        );
    }

    return true;
}

function pm_process_result(mysqli_result $result, $message_count)
{
    $message_array = array();

    while (($pm_data = $result->fetch_assoc()) !== null) {

        if (!isset($pm_data['FROM_LOGON'])) $pm_data['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($pm_data['FROM_NICKNAME'])) $pm_data['FROM_NICKNAME'] = "";

        $message_array[$pm_data['MID']] = array(
            'CREATED' => $pm_data['CREATED'],
            'FROM_UID' => $pm_data['FROM_UID'],
            'FROM_LOGON' => $pm_data['FROM_LOGON'],
            'FROM_NICKNAME' => $pm_data['FROM_NICKNAME'],
            'MID' => $pm_data['MID'],
            'RECIPIENTS' => array(),
            'REPLY_TO_MID' => $pm_data['REPLY_TO_MID'],
            'SUBJECT' => $pm_data['SUBJECT'],
            'TYPE' => $pm_data['TYPE'],
        );
    }

    pms_get_recipients($message_array);

    pms_have_attachments($message_array);

    return array(
        'message_count' => $message_count,
        'message_array' => $message_array
    );
}

function pm_search_execute($search_string, &$error)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "DELETE QUICK FROM PM_SEARCH_RESULTS WHERE UID = '{$_SESSION['UID']}'";

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

    $sql = "INSERT INTO PM_SEARCH_RESULTS (UID, MID, RELEVANCE) SELECT '{$_SESSION['UID']}', PM.MID, ";
    $sql .= "MATCH(PM_CONTENT.CONTENT, PM.SUBJECT) AGAINST('$search_string_checked' IN BOOLEAN MODE) AS RELEVANCE ";
    $sql .= "FROM PM INNER JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = {$_SESSION['UID']})";
    $sql .= "LEFT JOIN PM_CONTENT ON (PM_CONTENT.MID = PM.MID) WHERE MATCH(PM_CONTENT.CONTENT, PM.SUBJECT) ";
    $sql .= "AGAINST('$search_string_checked' IN BOOLEAN MODE) GROUP BY PM.MID LIMIT $limit";

    if (!$db->query($sql)) return false;

    if ($db->affected_rows > 0) return true;

    $error = SEARCH_NO_MATCHES;

    return false;
}

function pm_fetch_search_results($sort_by = 'CREATED', $sort_dir = 'DESC', $page = 1, $limit = 10)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'PM.SUBJECT',
        'TYPE',
        'PM.FROM_UID',
        'PM_TYPE.UID',
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM_TYPE.TYPE, ";
    $sql .= "PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, ";
    $sql .= "USER.NICKNAME AS FROM_NICKNAME FROM PM INNER JOIN PM_TYPE ";
    $sql .= "ON (PM_TYPE.MID = PM.MID) INNER JOIN PM_SEARCH_RESULTS ";
    $sql .= "ON (PM_SEARCH_RESULTS.MID = PM.MID) LEFT JOIN USER ON (USER.UID = PM.FROM_UID) ";
    $sql .= "WHERE PM_SEARCH_RESULTS.UID = '{$_SESSION['UID']}' ";
    $sql .= "GROUP BY PM.MID ORDER BY $sort_by $sort_dir LIMIT $offset, $limit";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($message_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($message_count > 0) && ($page > 1)) {
        return pm_fetch_search_results($sort_by, $sort_dir, $page - 1, $limit);
    }

    return pm_process_result($result, $message_count);
}

function pm_get_folder_message_counts($include_search = true)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $message_count_array = array(
        PM_FOLDER_INBOX => 0,
        PM_FOLDER_SENT => 0,
        PM_FOLDER_OUTBOX => 0,
        PM_FOLDER_SAVED => 0,
        PM_FOLDER_DRAFTS => 0,
        PM_SEARCH_RESULTS => 0,
    );

    $pm_inbox = PM_INBOX_ITEMS;
    $pm_saved = PM_SAVED_ITEMS;
    $pm_outbox = PM_OUTBOX_ITEMS;
    $pm_sent = PM_SENT_ITEMS;
    $pm_draft = PM_DRAFT_ITEMS;

    $sql = "(SELECT 1 AS FOLDER, COUNT(DISTINCT PM.MID) AS MESSAGE_COUNT FROM PM ";
    $sql .= "INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) INNER JOIN PM_TYPE ";
    $sql .= "ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.TYPE & $pm_inbox AND PM_TYPE.UID = '{$_SESSION['UID']}' ";
    $sql .= ") UNION (SELECT 4 AS FOLDER, COUNT(DISTINCT PM.MID) AS MESSAGE_COUNT FROM ";
    $sql .= "PM INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) INNER JOIN ";
    $sql .= "PM_TYPE ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.TYPE & $pm_saved AND ";
    $sql .= "PM_TYPE.UID = '{$_SESSION['UID']}') UNION (SELECT 5 AS FOLDER, ";
    $sql .= "COUNT(DISTINCT PM.MID) AS MESSAGE_COUNT FROM PM INNER JOIN ";
    $sql .= "PM_RECIPIENT ON ( PM_RECIPIENT.MID = PM.MID) INNER JOIN ";
    $sql .= "PM_TYPE ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.TYPE & $pm_draft ";
    $sql .= "AND PM_TYPE.UID = '{$_SESSION['UID']}') UNION (SELECT 3 AS TYPE, ";
    $sql .= "COUNT(DISTINCT MID) AS COUNT FROM (SELECT PM.MID, ";
    $sql .= "COUNT(DISTINCT PM_TYPE_SENT.UID) AS OUTBOX_COUNT, ";
    $sql .= "COUNT(DISTINCT PM_RECIPIENT.TO_UID) AS RECIPIENT_COUNT FROM ";
    $sql .= "PM INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) LEFT JOIN ";
    $sql .= "PM_TYPE PM_TYPE_SENT ON (PM_TYPE_SENT.MID = PM.MID AND PM_TYPE_SENT.TYPE = $pm_outbox) ";
    $sql .= "WHERE PM.FROM_UID = '{$_SESSION['UID']}' GROUP BY PM.MID HAVING ";
    $sql .= "OUTBOX_COUNT = RECIPIENT_COUNT) AS OUTBOX) UNION (SELECT 2 AS TYPE, ";
    $sql .= "COUNT(DISTINCT MID) AS COUNT FROM (SELECT PM.MID, ";
    $sql .= "COUNT(DISTINCT PM_TYPE_OUTBOX.UID) AS OUTBOX_COUNT, ";
    $sql .= "COUNT(DISTINCT PM_RECIPIENT.TO_UID) AS RECIPIENT_COUNT FROM PM ";
    $sql .= "INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) INNER JOIN ";
    $sql .= "PM_TYPE ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = PM.FROM_UID AND ";
    $sql .= "PM_TYPE.TYPE = $pm_sent) LEFT JOIN PM_TYPE PM_TYPE_OUTBOX ON (PM_TYPE_OUTBOX.MID = PM.MID ";
    $sql .= "AND PM_TYPE_OUTBOX.TYPE = 1) WHERE PM.FROM_UID = '{$_SESSION['UID']}' ";
    $sql .= "GROUP BY PM.MID HAVING OUTBOX_COUNT < RECIPIENT_COUNT) AS SENT) ";

    if (!($result = $db->query($sql))) return false;

    while (($pm_data_array = $result->fetch_assoc()) !== null) {
        $message_count_array[$pm_data_array['FOLDER']] = $pm_data_array['MESSAGE_COUNT'];
    }

    if ($include_search) {

        $sql = "SELECT COUNT(PM_SEARCH_RESULTS.MID) AS RESULT_COUNT ";
        $sql .= "FROM PM_SEARCH_RESULTS INNER JOIN PM ON (PM.MID = PM_SEARCH_RESULTS.MID) ";
        $sql .= "WHERE UID = '{$_SESSION['UID']}' AND PM.MID IS NOT NULL";

        if (!($result = $db->query($sql))) return false;

        list($search_results_count) = $result->fetch_row();

        $message_count_array[PM_SEARCH_RESULTS] = $search_results_count;
    }

    return $message_count_array;
}

function pm_get_free_space($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', null, 100);

    $pm_user_message_count = array_sum(pm_get_folder_message_counts(false));

    if ($pm_user_message_count > $pm_max_user_messages) return 0;

    return ($pm_max_user_messages - $pm_user_message_count);
}

function pm_message_get($mid)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($mid)) return false;

    $pm_outbox = PM_OUTBOX;

    $sql = "SELECT SQL_CALC_FOUND_ROWS PM.MID, PM.REPLY_TO_MID, PM.FROM_UID, PM.SUBJECT, ";
    $sql .= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, USER.LOGON AS FROM_LOGON, USER.NICKNAME AS FROM_NICKNAME, ";
    $sql .= "PM_TYPE.TYPE, COUNT(PM_RECIPIENT.TO_UID) = COALESCE(OUTBOX.COUNT, 0) AS EDITABLE ";
    $sql .= "FROM PM INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) ";
    $sql .= "INNER JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID AND PM_TYPE.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN USER ON (USER.UID = PM.FROM_UID) LEFT JOIN (SELECT PM_TYPE.MID, COUNT(*) AS COUNT ";
    $sql .= "FROM PM_TYPE WHERE (PM_TYPE.TYPE & $pm_outbox) GROUP BY PM_TYPE.MID) AS OUTBOX ";
    $sql .= "ON (OUTBOX.MID = PM.MID) WHERE PM.MID = '$mid' GROUP BY PM.MID ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    if (!($message_data = $result->fetch_assoc())) return false;

    pm_get_recipients($message_data);

    pm_has_attachments($message_data);

    return $message_data;
}

function pm_get_content($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT CONTENT FROM PM_CONTENT WHERE MID = '$mid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($pm_content) = $result->fetch_row();

    return $pm_content;
}

function pm_get_folder_type($folder)
{
    $folder_type_map = array(
        PM_FOLDER_INBOX => PM_INBOX_ITEMS,
        PM_FOLDER_SENT => PM_SENT_ITEMS,
        PM_FOLDER_OUTBOX => PM_OUTBOX_ITEMS,
        PM_FOLDER_SAVED => PM_SAVED_ITEMS,
        PM_FOLDER_DRAFTS => PM_DRAFT_ITEMS,
        PM_SEARCH_RESULTS => PM_ALL_ITEMS,
    );

    if (!isset($folder_type_map[$folder])) {
        return false;
    }

    return $folder_type_map[$folder];
}

function pm_get_type_folder($type)
{
    $type_folder_map = array(
        PM_INBOX_ITEMS => PM_FOLDER_INBOX,
        PM_SENT_ITEMS => PM_FOLDER_SENT,
        PM_OUTBOX_ITEMS => PM_FOLDER_OUTBOX,
        PM_SAVED_ITEMS => PM_FOLDER_SAVED,
        PM_DRAFT_ITEMS => PM_FOLDER_DRAFTS,
        PM_ALL_ITEMS => PM_SEARCH_RESULTS,
    );

    if (!isset($type_folder_map[$type])) {
        return false;
    }

    return $type_folder_map[$type];
}

function pm_display($message_data, $preview = false, $export_html = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

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

    if ($export_html === true) {

        echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("From"), ":&nbsp;</span></td>\n";
        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags(format_user_name($message_data['FROM_LOGON'], $message_data['FROM_NICKNAME']), true), "</span></td>\n";

    } else {

        echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("From"), ":&nbsp;</span></td>\n";
        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$message_data['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message_data['FROM_LOGON'], $message_data['FROM_NICKNAME']), true), "</a></span></td>\n";
    }

    if (isset($message_data['TYPE']) && ($message_data['TYPE'] & PM_SAVED_DRAFT)) {

        echo "                        <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\"><i>", gettext("Not Sent"), "</i>&nbsp;</span></td>\n";

    } else {

        echo "                        <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">", format_date_time($message_data['CREATED']), "&nbsp;</span></td>\n";
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("Subject"), ":&nbsp;</span></td>\n";

    if (strlen(trim($message_data['SUBJECT'])) > 0) {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", word_filter_add_ob_tags($message_data['SUBJECT'], true), "</span></td>\n";

    } else {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><i>", gettext("No Subject"), "</i></span></td>\n";
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";

    if (isset($message_data['RECIPIENTS']) && sizeof($message_data['RECIPIENTS']) > 0) {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

        foreach ($message_data['RECIPIENTS'] as $recipient) {
            echo "                          <a href=\"user_profile.php?webtag=$webtag&amp;uid={$recipient['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</a>";
        }

        echo "                  </td>\n";

    } else {

        echo "                        <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", gettext('Unknown User'), "</td>\n";
    }

    $message_data['CONTENT'] = message_apply_formatting($message_data['CONTENT']);
    $message_data['CONTENT'] = word_filter_add_ob_tags($message_data['CONTENT']);

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
    echo "                        <td class=\"postbody overflow_content\" align=\"left\">{$message_data['CONTENT']}</td>\n";
    echo "                      </tr>\n";

    if (isset($message_data['ATTACHMENTS']) && sizeof($message_data['ATTACHMENTS']) > 0) {

        if (($attachments_array = attachments_get($message_data['FROM_UID'], $message_data['ATTACHMENTS'])) !== false) {

            echo "              <tr>\n";
            echo "                <td class=\"postbody\" align=\"left\">\n";
            echo "                  <p><b>", gettext("Attachments"), ":</b><br />\n";

            foreach ($attachments_array as $attachment) {
                echo attachments_make_link($attachment), ($attachment['thumbnail'] == 'N') ? "<br />\n" : "\n";
            }

            echo "                  </p>\n";
            echo "                </td>\n";
            echo "              </tr>\n";
        }
    }

    echo "                    </table>\n";
    echo "                    <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";

    if ($preview === false) {

        if (($message_data['TYPE'] & PM_INBOX_ITEMS)) {

            echo "", html_style_image('post', "Reply"), "&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;reply_to={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Reply"), "</a>&nbsp;\n";

            if (isset($message_data['RECIPIENTS']) && sizeof($message_data['RECIPIENTS']) > 1) {
                echo "", html_style_image('reply_all', "Reply All"), "&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;replyall={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Reply All"), "</a>&nbsp;\n";
            }

            echo "", html_style_image('forward', "Forward"), "&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Forward"), "</a>&nbsp;\n";

        } else if (($message_data['TYPE'] & PM_DRAFT_ITEMS)) {

            echo "", html_style_image('edit', "Edit"), "&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;editmsg={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Edit"), "</a>&nbsp;\n";

        } else {

            if ($message_data['EDITABLE'] == 1) {
                echo "", html_style_image('post', "Edit"), "&nbsp;<a href=\"pm_edit.php?webtag=$webtag&amp;mid={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Edit"), "</a>&nbsp;\n";
            }

            echo "", html_style_image('forward', "Forward"), "&nbsp;<a href=\"pm_write.php?webtag=$webtag&amp;fwdmsg={$message_data['MID']}\" target=\"", html_get_frame_name('main'), "\">", gettext("Forward"), "</a>&nbsp;\n";
        }
    }

    echo "                        </td>\n";
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

function pm_display_html_export($message_data)
{
    ob_start();

    pm_display($message_data, true, true);

    $pm_message_html = ob_get_contents();

    ob_end_clean();

    return word_filter_remove_ob_tags($pm_message_html);
}

function pm_add_attachment($mid, $aid)
{
    if (!is_numeric($mid)) return false;
    if (!is_numeric($aid)) return false;

    if (!$db = db::get()) return false;

    $sql = "INSERT IGNORE INTO PM_ATTACHMENT_IDS (MID, AID) ";
    $sql .= "VALUES ($mid, $aid)";

    if (!($result = $db->query($sql))) return false;

    return true;
}

function pm_send_message($from_uid, $to_user_array, $subject, $content, $reply_mid = null)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($from_uid)) return false;

    if (!is_array($to_user_array)) return false;

    if (!is_numeric($reply_mid) && !is_null($reply_mid)) return false;

    foreach ($to_user_array as $to_user) {

        if (!isset($to_user['UID']) || !is_numeric($to_user['UID'])) {
            return false;
        }
    }

    $subject = $db->escape($subject);

    $content = $db->escape($content);

    $reply_mid = is_numeric($reply_mid) ? $reply_mid : 'NULL';

    $pm_outbox = PM_OUTBOX;

    $pm_sent = PM_SENT;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "INSERT INTO PM (SUBJECT, REPLY_TO_MID, FROM_UID, CREATED) ";
    $sql .= "VALUES ('$subject', $reply_mid, '$from_uid', CAST('$current_datetime' AS DATETIME))";

    if (!$db->query($sql)) return false;

    $new_mid = $db->insert_id;

    $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) VALUES ('$new_mid', '$content')";

    if (!$db->query($sql)) return false;

    foreach ($to_user_array as $to_user) {

        $sql = "INSERT INTO PM_RECIPIENT (MID, TO_UID, NOTIFIED) ";
        $sql .= "VALUES ('$new_mid', '{$to_user['UID']}', 'N')";

        if (!$db->query($sql)) return false;

        $sql = "INSERT INTO PM_TYPE (MID, UID, TYPE) ";
        $sql .= "VALUES ('$new_mid', '{$to_user['UID']}', '$pm_outbox')";

        if (!$db->query($sql)) return false;
    }

    $user_prefs = user_get_prefs($from_uid);

    if (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {

        $sql = "INSERT INTO PM_TYPE (MID, UID, TYPE) ";
        $sql .= "VALUES ('$new_mid', '$from_uid', '$pm_sent')";

        if (!$db->query($sql)) return false;
    }

    return $new_mid;
}

function pm_save_message($from_uid, $to_user_array, $subject, $content, $reply_mid = null)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($from_uid)) return false;

    if (!is_array($to_user_array)) return false;

    if (!is_numeric($reply_mid) && !is_null($reply_mid)) return false;

    foreach ($to_user_array as $to_user) {

        if (!isset($to_user['UID']) || !is_numeric($to_user['UID'])) {
            return false;
        }
    }

    $subject = $db->escape($subject);

    $content = $db->escape($content);

    $reply_mid = is_numeric($reply_mid) ? $reply_mid : 'NULL';

    $pm_saved_draft = PM_SAVED_DRAFT;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "INSERT INTO PM (SUBJECT, REPLY_TO_MID, FROM_UID, CREATED) ";
    $sql .= "VALUES ('$subject', $reply_mid, '$from_uid', CAST('$current_datetime' AS DATETIME))";

    if (!$db->query($sql)) return false;

    $new_mid = $db->insert_id;

    $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) VALUES ('$new_mid', '$content')";

    if (!$db->query($sql)) return false;

    foreach ($to_user_array as $to_user) {

        $sql = "INSERT INTO PM_RECIPIENT (MID, TO_UID, NOTIFIED) ";
        $sql .= "VALUES ('$new_mid', '{$to_user['UID']}', 'N')";

        if (!$db->query($sql)) return false;
    }

    $sql = "INSERT INTO PM_TYPE (MID, UID, TYPE) ";
    $sql .= "VALUES ('$new_mid', '$from_uid', '$pm_saved_draft')";

    if (!$db->query($sql)) return false;

    return $new_mid;
}

function pm_send_saved_message($mid, $from_uid, $to_user_array, $subject, $content, $reply_mid = null)
{
    if (!$db = db::get()) return false;

    if (!pm_update_saved_message($mid, $from_uid, $to_user_array, $subject, $content, $reply_mid)) return false;

    $sql = "DELETE FROM PM_TYPE WHERE PM_TYPE.MID = '$mid'";

    if (!$db->query($sql)) return false;

    $pm_sent = PM_SENT;
    $pm_outbox = PM_OUTBOX;

    foreach ($to_user_array as $to_user) {

        $sql = "INSERT INTO PM_TYPE (MID, UID, TYPE) ";
        $sql .= "VALUES ('$mid', '{$to_user['UID']}', '$pm_outbox')";

        if (!$db->query($sql)) return false;
    }

    $user_prefs = user_get_prefs($from_uid);

    if (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {

        $sql = "INSERT INTO PM_TYPE (MID, UID, TYPE) ";
        $sql .= "VALUES ('$mid', '$from_uid', '$pm_sent')";

        if (!$db->query($sql)) return false;
    }

    return $mid;
}

function pm_update_saved_message($mid, $from_uid, $to_user_array, $subject, $content, $reply_mid = null)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($from_uid)) return false;

    if (!is_array($to_user_array)) return false;

    if (!is_numeric($reply_mid) && !is_null($reply_mid)) return false;

    foreach ($to_user_array as $to_user) {

        if (!isset($to_user['UID']) || !is_numeric($to_user['UID'])) {
            return false;
        }
    }

    $subject = $db->escape($subject);

    $content = $db->escape($content);

    $reply_mid = is_numeric($reply_mid) ? $reply_mid : 'NULL';

    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject', ";
    $sql .= "REPLY_TO_MID = $reply_mid, FROM_UID = '$from_uid' ";
    $sql .= "WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE FROM PM_RECIPIENT WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    foreach ($to_user_array as $to_user) {

        $sql = "INSERT INTO PM_RECIPIENT (MID, TO_UID, NOTIFIED) ";
        $sql .= "VALUES ('$mid', '{$to_user['UID']}', 'N')";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function pm_edit_message($mid, $subject, $content)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $subject = $db->escape($subject);
    $content = $db->escape($content);

    $sql = "UPDATE LOW_PRIORITY PM SET SUBJECT = '$subject' WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY PM_CONTENT SET CONTENT = '$content' WHERE MID = '$mid'";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_delete_message($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_outbox = PM_OUTBOX;
    $pm_sent_items = PM_SENT_ITEMS;
    $pm_saved_out = PM_SAVED_OUT;
    $pm_saved_in = PM_SAVED_IN;
    $pm_draft_items = PM_DRAFT_ITEMS;

    $sql = "DELETE FROM PM_TYPE USING PM_TYPE INNER JOIN PM ON (PM.MID = PM_TYPE.MID) ";
    $sql .= "WHERE (((PM_TYPE.TYPE & $pm_inbox_items) AND PM_TYPE.UID = '{$_SESSION['UID']}') OR ";
    $sql .= "((PM_TYPE.TYPE & $pm_outbox) AND PM.FROM_UID = '{$_SESSION['UID']}') OR ";
    $sql .= "((PM_TYPE.TYPE & $pm_sent_items) AND PM_TYPE.UID = '{$_SESSION['UID']}') OR ";
    $sql .= "((PM_TYPE.TYPE & $pm_saved_out) AND PM_TYPE.UID = '{$_SESSION['UID']}') OR ";
    $sql .= "((PM_TYPE.TYPE & $pm_saved_in) AND PM_TYPE.UID = '{$_SESSION['UID']}') OR ";
    $sql .= "((PM_TYPE.TYPE & $pm_draft_items) AND PM.FROM_UID = '{$_SESSION['UID']}')) ";
    $sql .= "AND PM_TYPE.MID = '$mid'";

    if (!($result = $db->query($sql))) return false;

    $sql = "DELETE FROM PM, PM_CONTENT, PM_RECIPIENT USING PM ";
    $sql .= "LEFT JOIN PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
    $sql .= "LEFT JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) ";
    $sql .= "LEFT JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID) ";
    $sql .= "WHERE PM_TYPE.MID IS NULL AND PM.MID = '$mid'";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT PAF.HASH FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "INNER JOIN PM_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "LEFT JOIN PM ON (PM.MID = PAI.MID) WHERE PM.MID IS NULL ";
    $sql .= "AND PAI.MID = '$mid'";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {
        attachments_delete($attachment_data['HASH']);
    }

    return true;
}

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

function pm_archive_message($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $pm_saved_in = PM_SAVED_IN;
    $pm_saved_out = PM_SAVED_OUT;

    $pm_inbox_items = PM_INBOX_ITEMS;
    $pm_sent_items = PM_SENT_ITEMS;

    // Archive any PM that are in the User's Inbox
    $sql = "UPDATE LOW_PRIORITY PM_TYPE SET TYPE = '$pm_saved_in' ";
    $sql .= "WHERE MID = '$mid' AND (TYPE & $pm_inbox_items) ";
    $sql .= "AND UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    // Archive any PM that are in the User's Sent Items
    $sql = "UPDATE LOW_PRIORITY PM_TYPE SET TYPE = '$pm_saved_out' ";
    $sql .= "WHERE MID = '$mid' AND (TYPE & $pm_sent_items) ";
    $sql .= "AND UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    return true;
}

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

function pm_get_new_messages($limit)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($limit)) return false;

    $limit = abs($limit);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $pm_outbox = PM_OUTBOX;

    $sql = "SELECT PM.MID, PM_TYPE.TYPE, PM.FROM_UID, PM_TYPE.UID, PM.SUBJECT, ";
    $sql .= "PM.CREATED, PM_RECIPIENT.NOTIFIED FROM PM INNER JOIN PM_RECIPIENT ";
    $sql .= "ON (PM_RECIPIENT.MID = PM.MID) INNER JOIN PM_TYPE ";
    $sql .= "ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.TYPE = '$pm_outbox' ";
    $sql .= "AND PM_TYPE.UID = '{$_SESSION['UID']}' AND PM_RECIPIENT.NOTIFIED = 'N' ";
    $sql .= "ORDER BY PM.CREATED ASC LIMIT $limit";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $pm_new_message_array = array();

    while (($pm_data = $result->fetch_assoc()) !== null) {
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
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // PM folder types we'll be using.
    $pm_unread = PM_UNREAD;
    $pm_outbox = PM_OUTBOX;

    // Get the user's free space.
    $pm_free_space = pm_get_free_space($_SESSION['UID']);

    // Get a list of messages we have received.
    if (($message_array = pm_get_new_messages($pm_free_space)) !== false) {

        // Convert the array keys into a comma separated list.
        $mid_list = implode(',', array_filter(array_keys($message_array), 'is_numeric'));

        // Mark the selected messages as unread and notified.
        $sql = "UPDATE LOW_PRIORITY PM_TYPE INNER JOIN PM_RECIPIENT ";
        $sql .= "ON (PM_TYPE.MID = PM_RECIPIENT.MID AND PM_TYPE.UID = PM_RECIPIENT.TO_UID) ";
        $sql .= "SET PM_TYPE.TYPE = '$pm_unread', PM_RECIPIENT.NOTIFIED = 'Y' ";
        $sql .= "WHERE PM_TYPE.MID in ($mid_list) AND PM_TYPE.UID = '{$_SESSION['UID']}' ";
        $sql .= "AND (PM_TYPE.TYPE & $pm_outbox) ";

        if (!($result = $db->query($sql))) return false;

        // Number of new messages we've received for popup.
        $pm_new_count = sizeof($message_array);
    }

    // Unread message count.
    $sql = "SELECT COUNT(MID) FROM PM_TYPE WHERE (TYPE & $pm_unread) ";
    $sql .= "AND UID = '{$_SESSION['UID']}'";

    if (!($result = $db->query($sql))) return false;

    list($pm_unread_count) = $result->fetch_row();

    // Check for any undelivered messages waiting for the user.
    $sql = "SELECT COUNT(MID) AS OUTBOX_COUNT FROM PM_TYPE ";
    $sql .= "WHERE (TYPE & $pm_outbox) AND UID = '{$_SESSION['UID']}' ";

    if (!($result = $db->query($sql))) return false;

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
    if (isset($_SESSION['PM_NOTIFY']) && ($_SESSION['PM_NOTIFY'] == 'Y')) {

        // Format the message sent to the client.
        if ($pm_new_count == 1 && $pm_outbox_count == 0) {

            $pm_notification = gettext("You have 1 new message. Would you like to go to your Inbox now?");

        } else if ($pm_new_count == 1 && $pm_outbox_count == 1) {

            $pm_notification = gettext("You have 1 new message.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?");

        } else if ($pm_new_count == 0 && $pm_outbox_count == 1) {

            $pm_notification = gettext("You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?");

        } else if ($pm_new_count > 1 && $pm_outbox_count == 0) {

            $pm_notification = sprintf(gettext("You have %d new messages. Would you like to go to your Inbox now?"), $pm_new_count);

        } else if ($pm_new_count > 1 && $pm_outbox_count == 1) {

            $pm_notification = sprintf(gettext("You have %d new messages.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $pm_new_count);

        } else if ($pm_new_count > 1 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have %d new messages.\n\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $pm_new_count, $pm_outbox_count);

        } else if ($pm_new_count == 1 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have 1 new message.\n\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $pm_outbox_count);

        } else if ($pm_new_count == 0 && $pm_outbox_count > 1) {

            $pm_notification = sprintf(gettext("You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $pm_outbox_count);
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Guests don't do PMs.
    if (!session::logged_in()) return false;

    $pm_unread = PM_UNREAD;

    // Check to see if the user has any new PMs
    $sql = "SELECT COUNT(MID) FROM PM_TYPE WHERE (TYPE & $pm_unread) ";
    $sql .= "AND UID = '{$_SESSION['UID']}' ";

    if (!($result = $db->query($sql))) return false;

    list($pm_unread_count) = $result->fetch_row();

    return $pm_unread_count;
}

function pm_user_prune_folders($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) {

        $pm_read = PM_READ;
        $pm_sent_items = PM_SENT_ITEMS;

        $pm_prune_length_seconds = (intval($user_prefs['PM_AUTO_PRUNE']) * DAY_IN_SECONDS);
        $pm_prune_length_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - $pm_prune_length_seconds);

        $sql = "DELETE LOW_PRIORITY FROM PM_TYPE USING PM_TYPE INNER JOIN PM ON (PM.MID = PM_TYPE.MID) ";
        $sql .= "WHERE (((PM_TYPE.TYPE & $pm_read) AND PM_TYPE.UID = '$uid') ";
        $sql .= "OR ((PM_TYPE.TYPE & $pm_sent_items) AND PM_TYPE.UID = '$uid')) ";
        $sql .= "AND PM.CREATED < CAST('$pm_prune_length_datetime' AS DATETIME)";

        if (!$db->query($sql)) return false;

        $sql = "DELETE FROM PM USING PM LEFT JOIN PM_TYPE ";
        $sql .= "ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.MID IS NULL";

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

        $sql = "DELETE LOW_PRIORITY FROM PM_TYPE USING PM_TYPE INNER JOIN PM ON (PM.MID = PM_TYPE.MID) ";
        $sql .= "WHERE ((PM_TYPE.TYPE & $pm_read) OR (PM_TYPE.TYPE & $pm_sent_items)) ";
        $sql .= "AND PM.CREATED < CAST('$pm_prune_length_datetime' AS DATETIME)";

        if (!$db->query($sql)) return false;

        $sql = "DELETE FROM PM USING PM LEFT JOIN PM_TYPE ";
        $sql .= "ON (PM_TYPE.MID = PM.MID) WHERE PM_TYPE.MID IS NULL";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function pm_auto_prune_enabled()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $user_prefs = user_get_prefs($_SESSION['UID']);

    if (isset($user_prefs['PM_AUTO_PRUNE']) && intval($user_prefs['PM_AUTO_PRUNE']) > 0) return true;

    $pm_prune_length = intval(forum_get_setting('pm_auto_prune', null, 0));

    return ($pm_prune_length > 0);
}

function pms_have_attachments(&$message_array)
{
    if (!is_array($message_array)) return false;

    $mid_list = implode(',', array_filter(array_keys($message_array), 'is_numeric'));

    if (sizeof($message_array) < 1) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT PMI.MID, COUNT(PAF.HASH) AS ATTACHMENT_COUNT ";
    $sql .= "FROM POST_ATTACHMENT_FILES PAF INNER JOIN PM_ATTACHMENT_IDS PMI ";
    $sql .= "ON (PMI.AID = PAF.AID) WHERE PMI.MID IN ($mid_list) ";
    $sql .= "GROUP BY PMI.MID";

    if (!($result = $db->query($sql))) return false;

    while (($pm_attachment_data = $result->fetch_assoc()) !== null) {
        $message_array[$pm_attachment_data['MID']]['ATTACHMENT_COUNT'] = $pm_attachment_data['ATTACHMENT_COUNT'];
    }

    return true;
}

function pm_has_attachments(&$message_data)
{
    if (!isset($message_data['MID'])) return false;

    if (!is_numeric($message_data['MID'])) return false;

    $message_data['ATTACHMENTS'] = array();

    if (!$db = db::get()) return false;

    $sql = "SELECT PAF.HASH FROM PM_ATTACHMENT_IDS PAI ";
    $sql .= "INNER JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql .= "WHERE PAI.MID = '{$message_data['MID']}'";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {
        $message_data['ATTACHMENTS'][] = $attachment_data['HASH'];
    }

    return true;
}

function pm_export_folders($pm_folders_array, $options_array)
{
    if (!is_array($pm_folders_array)) return false;

    if (!is_array($options_array)) return false;

    $zip = new ZipArchive();

    $zip_filename = tempnam(sys_get_temp_dir(), 'bhpe');

    if (!($zip->open($zip_filename, ZipArchive::CREATE))) {
        return false;
    }

    $messages_array = array();

    $pm_message_count_array = pm_get_folder_message_counts(false);

    foreach ($pm_folders_array as $folder) {

        $folder_messages_array = array();

        switch ($folder) {

            case PM_FOLDER_INBOX:

                $folder_messages_array = pm_get_inbox('CREATED', 'ASC', 1, $pm_message_count_array[PM_FOLDER_INBOX]);
                break;

            case PM_FOLDER_SENT:

                $folder_messages_array = pm_get_sent('CREATED', 'ASC', 1, $pm_message_count_array[PM_FOLDER_SENT]);
                break;

            case PM_FOLDER_OUTBOX:

                $folder_messages_array = pm_get_outbox('CREATED', 'ASC', 1, $pm_message_count_array[PM_FOLDER_OUTBOX]);
                break;

            case PM_FOLDER_SAVED:

                $folder_messages_array = pm_get_saved_items('CREATED', 'ASC', 1, $pm_message_count_array[PM_FOLDER_SAVED]);
                break;

            case PM_FOLDER_DRAFTS:

                $folder_messages_array = pm_get_drafts('CREATED', 'ASC', 1, $pm_message_count_array[PM_FOLDER_DRAFTS]);
                break;
        }

        if (sizeof($folder_messages_array) > 0) {
            $messages_array = array_merge($messages_array, $folder_messages_array['message_array']);
        }
    }

    pm_export_messages($messages_array, $zip, $options_array);

    $zip->close();

    $file_size = filesize($zip_filename);

    while (@ob_end_clean()) ;

    header("Content-Length: $file_size");
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=\"pm_backup_{$_SESSION['LOGON']}.zip\"");

    readfile($zip_filename);
    exit;
}

function pm_export_html_top($message = null)
{
    $html = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $html .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    $html .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"" . gettext('en-gb') . "\" lang=\"" . gettext('en-gb') . "\" dir=\"" . gettext('ltr') . "\">\n";
    $html .= "<head>\n";

    if (isset($message['SUBJECT']) && isset($message['MID'])) {
        $html .= sprintf("<title>%s - %s</title>\n", gettext("Message"), htmlentities_array($message['SUBJECT']));
    } else {
        $html .= "<title>" . gettext("Messages") . "</title>\n";
    }

    if (($user_style = html_get_style_file('style.css'))) {
        $html .= "<link rel=\"stylesheet\" href=\"" . html_get_forum_domain() . $user_style . "\" type=\"text/css\" media=\"screen\" />";
    }

    $html .= "</head>\n";
    $html .= "<body>\n";

    return $html;
}

function pm_export_html_bottom()
{
    $html = "</body>\n";
    $html .= "</html>\n";

    return $html;
}

function pm_export_messages($message_array, ZipArchive $zip, $options_array = array())
{
    if (!is_array($message_array)) return false;

    if (sizeof($message_array) < 1) return false;

    if (!isset($_SESSION['LOGON']) || strlen(trim($_SESSION['LOGON'])) == 0) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_TYPE'])) {

        if (isset($_SESSION['PM_EXPORT_TYPE']) && in_array($_SESSION['PM_EXPORT_TYPE'], array(PM_EXPORT_HTML, PM_EXPORT_XML))) {
            $options_array['PM_EXPORT_TYPE'] = $_SESSION['PM_EXPORT_TYPE'];
        } else {
            $options_array['PM_EXPORT_TYPE'] = PM_EXPORT_HTML;
        }
    }

    if (!isset($options_array['PM_EXPORT_ATTACHMENTS'])) {

        if (isset($_SESSION['PM_EXPORT_ATTACHMENTS']) && in_array($_SESSION['PM_EXPORT_ATTACHMENTS'], array('Y', 'N'))) {
            $options_array['PM_EXPORT_ATTACHMENTS'] = $_SESSION['PM_EXPORT_ATTACHMENTS'];
        } else {
            $options_array['PM_EXPORT_ATTACHMENTS'] = 'Y';
        }
    }

    switch ($options_array['PM_EXPORT_TYPE']) {

        case PM_EXPORT_HTML:

            if (!pm_export_html($message_array, $zip, $options_array)) return false;
            break;

        case PM_EXPORT_XML:

            if (!pm_export_xml($message_array, $zip, $options_array)) return false;
            break;
    }

    if ($options_array['PM_EXPORT_ATTACHMENTS'] == "Y") {
        pm_export_attachments($message_array, $zip);
    }

    return true;
}

function pm_export_html($message_array, ZipArchive $zip, $options_array = array())
{
    if (!is_array($message_array)) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_FILE'])) {

        if (isset($_SESSION['PM_EXPORT_FILE']) && in_array($_SESSION['PM_EXPORT_FILE'], array(PM_EXPORT_SINGLE, PM_EXPORT_MANY))) {
            $options_array['PM_EXPORT_FILE'] = $_SESSION['PM_EXPORT_FILE'];
        } else {
            $options_array['PM_EXPORT_FILE'] = PM_EXPORT_HTML;
        }
    }

    if (!isset($options_array['PM_EXPORT_WORDFILTER'])) {

        if (isset($_SESSION['PM_EXPORT_WORDFILTER']) && in_array($_SESSION['PM_EXPORT_WORDFILTER'], array('Y', 'N'))) {
            $options_array['PM_EXPORT_WORDFILTER'] = $_SESSION['PM_EXPORT_WORDFILTER'];
        } else {
            $options_array['PM_EXPORT_WORDFILTER'] = 'Y';
        }
    }

    $pm_display = '';

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {
        $pm_display = pm_export_html_top();
    }

    if (sizeof($message_array) == 0) return false;

    foreach ($message_array as $message) {

        $message['CONTENT'] = pm_get_content($message['MID']);

        if ($options_array['PM_EXPORT_WORDFILTER'] == 'Y') {
            $message = array_map('pm_export_word_filter_apply', $message);
        }

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {
            $pm_display = pm_export_html_top($message);
        }

        $pm_display .= pm_display_html_export($message);

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {
            $pm_display .= "<br />\n";
        }

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {

            $pm_display .= pm_export_html_bottom();

            $zip->addFromString(sprintf("message_%s.html", $message['MID']), $pm_display);
        }
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {

        $pm_display .= pm_export_html_bottom();

        $zip->addFromString("messages.html", $pm_display);
    }

    return true;
}

function pm_export_xml($message_array, ZipArchive $zip, $options_array = array())
{
    if (!is_array($message_array)) return false;

    if (!is_array($options_array)) $options_array = array();

    if (!isset($options_array['PM_EXPORT_FILE'])) {

        if (isset($_SESSION['PM_EXPORT_FILE']) && in_array($_SESSION['PM_EXPORT_FILE'], array(PM_EXPORT_SINGLE, PM_EXPORT_MANY))) {
            $options_array['PM_EXPORT_FILE'] = $_SESSION['PM_EXPORT_FILE'];
        } else {
            $options_array['PM_EXPORT_FILE'] = PM_EXPORT_HTML;
        }
    }

    if (!isset($options_array['PM_EXPORT_WORDFILTER'])) {

        if (isset($_SESSION['PM_EXPORT_WORDFILTER']) && in_array($_SESSION['PM_EXPORT_WORDFILTER'], array('Y', 'N'))) {
            $options_array['PM_EXPORT_WORDFILTER'] = $_SESSION['PM_EXPORT_WORDFILTER'];
        } else {
            $options_array['PM_EXPORT_WORDFILTER'] = 'Y';
        }
    }

    if (sizeof($message_array) == 0) return false;

    $root_xml = new SimpleXMLElement('<beehiveforum>');
    $messages_xml = $root_xml->addChild('messages');

    foreach ($message_array as $message) {

        $message['CONTENT'] = pm_get_content($message['MID']);

        if ($options_array['PM_EXPORT_WORDFILTER'] == 'Y') {
            $message = array_map('pm_export_word_filter_apply', $message);
        }

        $message_xml = $messages_xml->addChild('message');

        $message_xml->addChild('mid', $message['CREATED']);
        $message_xml->addChild('reply_to_mid', $message['REPLY_TO_MID']);
        $message_xml->addChild('subject', $message['SUBJECT']);
        $message_xml->addChild('created', $message['CREATED']);

        $content_xml = dom_import_simplexml($message_xml);
        $content_xml->appendChild($content_xml->ownerDocument->createCDATASection($message['CONTENT']));

        $from_xml = $message_xml->addChild('from');

        $from_xml->addChild('uid', $message['FROM_UID']);
        $from_xml->addChild('logon', $message['FROM_LOGON']);

        $recipients_xml = $message_xml->addChild('recipients');

        if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) > 0) {

            foreach ($message['RECIPIENTS'] as $recipient) {

                $recipient_xml = $recipients_xml->addChild('recipient');

                $recipient_xml->addChild('uid', $recipient['UID']);
                $recipient_xml->addChild('logon', $recipient['LOGON']);
            }
        }

        if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_MANY) {

            $zip->addFromString(sprintf("message_%s.xml", $message['MID']), $root_xml->asXML());

            $root_xml = new SimpleXMLElement('<beehiveforum>');
            $messages_xml = $root_xml->addChild('messages');
        }
    }

    if ($options_array['PM_EXPORT_FILE'] == PM_EXPORT_SINGLE) {
        $zip->addFromString("messages.xml", $root_xml->asXML());
    }

    return true;
}

function pm_export_word_filter_apply($content)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return $content;
    return word_filter_apply($content, $_SESSION['UID']);
}

function pm_export_attachments($message_array, ZipArchive $zip)
{
    if (!is_array($message_array)) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $attachments_added_success = false;

    $zip->addEmptyDir("attachments");

    foreach ($message_array as $message) {

        if (($attachments_array = attachments_get($message['FROM_UID'], $message['ATTACHMENTS'])) !== false) {

            foreach ($attachments_array as $attachment) {

                if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

                    $attachments_added_success = true;

                    $zip->addFile("$attachment_dir/{$attachment['hash']}", "attachments/{$attachment['filename']}");
                }
            }
        }
    }

    if ($attachments_added_success == true && $attach_img = html_style_image('attach', true)) {
        $zip->addFile($attach_img, $attach_img);
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT FID, TITLE FROM PM_FOLDERS WHERE UID = '{$_SESSION['UID']}'";

    if (!($result = $db->query($sql))) return $pm_folder_names_array;

    if ($result->num_rows == 0) return $pm_folder_names_array;

    while (($folder_name_data = $result->fetch_assoc()) !== null) {

        if (strlen(trim($folder_name_data['TITLE'])) == 0) continue;
        $pm_folder_names_array[$folder_name_data['FID']] = $folder_name_data['TITLE'];
    }

    return $pm_folder_names_array;
}

function pm_update_folder_name($folder, $folder_name)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($folder)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $folder_name = $db->escape($folder_name);

    $sql = "INSERT INTO PM_FOLDERS (UID, FID, TITLE) VALUES('{$_SESSION['UID']}', '$folder', '$folder_name') ";
    $sql .= "ON DUPLICATE KEY UPDATE TITLE = VALUES(TITLE)";

    if (!$db->query($sql)) return false;

    return true;
}

function pm_reset_folder_name($folder)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($folder)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "DELETE FROM PM_FOLDERS WHERE UID = '{$_SESSION['UID']}' AND FID = '$folder'";

    if (!$db->query($sql)) return false;

    return $db->affected_rows > 0;
}