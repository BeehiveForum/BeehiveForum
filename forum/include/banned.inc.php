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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'sfs.inc.php';
// End Required includes

function ban_check($user_data, $send_error = true)
{
    if (!$db = db::get()) return false;

    if (!is_array($user_data)) return false;

    $user_data_keys = array(
        'UID',
        'IPADDRESS',
        'REFERER',
        'LOGON',
        'NICKNAME',
        'EMAIL'
    );

    $user_data = array_intersect_key(
        $user_data,
        array_flip($user_data_keys)
    );

    if (!($table_prefix = get_table_prefix())) return false;

    $admin_log_types_array = array(
        BAN_TYPE_IP => BAN_HIT_TYPE_IP,
        BAN_TYPE_LOGON => BAN_HIT_TYPE_LOGON,
        BAN_TYPE_NICK => BAN_HIT_TYPE_NICK,
        BAN_TYPE_EMAIL => BAN_HIT_TYPE_EMAIL,
        BAN_TYPE_REF => BAN_HIT_TYPE_REF
    );

    $ban_check_select_array = array();
    $ban_check_where_array = array();

    $user_banned = false;

    if (isset($user_data['IPADDRESS']) && strlen(trim($user_data['IPADDRESS'])) > 0) {

        $ban_check_select_array[] = sprintf("'%s' AS IPADDRESS", $db->escape($user_data['IPADDRESS']));
        $ban_check_where_array[] = sprintf("('%s' LIKE BANDATA AND BANTYPE = %d)", $db->escape($user_data['IPADDRESS']), BAN_TYPE_IP);
    }

    if (isset($user_data['REFERER']) && strlen(trim($user_data['REFERER'])) > 0) {

        $ban_check_select_array[] = sprintf("'%s' AS REFERER", $db->escape($user_data['REFERER']));
        $ban_check_where_array[] = sprintf("('%s' LIKE BANDATA AND BANTYPE = %d)", $db->escape($user_data['REFERER']), BAN_TYPE_REF);
    }

    if (!isset($user_data['UID']) || ($user_data['UID'] > 0)) {

        if (isset($user_data['LOGON']) && strlen(trim($user_data['LOGON'])) > 0) {

            $ban_check_select_array[] = sprintf("'%s' AS LOGON", $db->escape($user_data['LOGON']));
            $ban_check_where_array[] = sprintf("('%s' LIKE BANDATA AND BANTYPE = %d)", $db->escape($user_data['LOGON']), BAN_TYPE_LOGON);
        }

        if (isset($user_data['NICKNAME']) && strlen(trim($user_data['NICKNAME'])) > 0) {

            $ban_check_select_array[] = sprintf("'%s' AS NICKNAME", $db->escape($user_data['NICKNAME']));
            $ban_check_where_array[] = sprintf("('%s' LIKE BANDATA AND BANTYPE = %d)", $db->escape($user_data['NICKNAME']), BAN_TYPE_NICK);
        }

        if (isset($user_data['EMAIL']) && strlen(trim($user_data['EMAIL'])) > 0) {

            $ban_check_select_array[] = sprintf("'%s' AS EMAIL", $db->escape($user_data['EMAIL']));
            $ban_check_where_array[] = sprintf("('%s' LIKE BANDATA AND BANTYPE = %d)", $db->escape($user_data['EMAIL']), BAN_TYPE_EMAIL);
        }
    }

    $ban_check_select_list = implode(", ", $ban_check_select_array);
    $ban_check_where_query = implode(" OR ", $ban_check_where_array);

    if (strlen(trim($ban_check_where_query)) > 0 && strlen(trim($ban_check_select_list)) > 0) {

        $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

        $sql = "SELECT ID, BANTYPE, BANDATA, $ban_check_select_list ";
        $sql .= "FROM `{$table_prefix}BANNED` WHERE ($ban_check_where_query) ";
        $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {

            $user_banned = true;

            while (($ban_check_result_array = $result->fetch_assoc()) !== null) {

                if (isset($ban_check_result_array['BANTYPE']) && is_numeric($ban_check_result_array['BANTYPE'])) {

                    $ban_check_type = $ban_check_result_array['BANTYPE'];

                    if (($ban_check_data = ban_check_process_data($ban_check_result_array)) !== false) {

                        if (isset($user_data['UID']) && ($user_data['UID'] > 0)) {
                            array_push($ban_check_data, $user_data['UID'], $user_data['LOGON']);
                        }

                        admin_add_log_entry($admin_log_types_array[$ban_check_type], $ban_check_data);
                    }
                }
            }
        }
    }

    if ($user_banned !== true) {

        $cached_response = false;

        if (($user_banned = sfs_check_banned($user_data, $cached_response)) !== false) {

            if ($cached_response === false) {

                $log_data = array(
                    $user_data['IPADDRESS'],
                    $user_data['LOGON'],
                    $user_data['EMAIL'],
                );

                if (isset($user_data['UID'])) {
                    $log_data[] = $user_data['UID'];
                }

                admin_add_log_entry(BAN_HIT_TYPE_SFS, $log_data);
            }
        }
    }

    if (($user_banned === true) && ($send_error === true)) {

        header_status(500, 'Internal Server Error');
        exit;
    }

    return $user_banned;
}

function ban_check_process_data($ban_result)
{
    if (!is_array($ban_result)) return false;

    if (!isset($ban_result['BANTYPE'])) return false;
    if (!isset($ban_result['BANDATA'])) return false;

    if (!is_numeric($ban_result['BANTYPE'])) return false;

    switch ($ban_result['BANTYPE']) {

        case BAN_TYPE_IP:

            return (isset($ban_result['IPADDRESS'])) ? array($ban_result['ID'], $ban_result['IPADDRESS'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_LOGON:

            return (isset($ban_result['LOGON'])) ? array($ban_result['ID'], $ban_result['LOGON'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_NICK:

            return (isset($ban_result['NICKNAME'])) ? array($ban_result['ID'], $ban_result['NICKNAME'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_EMAIL:

            return (isset($ban_result['EMAIL'])) ? array($ban_result['ID'], $ban_result['EMAIL'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_REF:

            return (isset($ban_result['REFERER'])) ? array($ban_result['ID'], $ban_result['REFERER'], $ban_result['BANDATA']) : false;
            break;

        default:

            return false;
            break;
    }
}

function ip_is_banned($ipaddress)
{
    if (!$db = db::get()) return false;

    $ipaddress = $db->escape($ipaddress);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_type_ip = BAN_TYPE_IP;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$ipaddress' LIKE BANDATA  AND BANTYPE = '$ban_type_ip' ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return ($ban_count > 0);
}

function logon_is_banned($logon)
{
    if (!$db = db::get()) return false;

    $logon = $db->escape($logon);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_type_logon = BAN_TYPE_LOGON;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$logon' LIKE BANDATA AND BANTYPE = '$ban_type_logon' ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return ($ban_count > 0);
}

function nickname_is_banned($nickname)
{
    if (!$db = db::get()) return false;

    $nickname = $db->escape($nickname);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_type_nick = BAN_TYPE_NICK;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$nickname' LIKE BANDATA AND BANTYPE = '$ban_type_nick' ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return ($ban_count > 0);
}

function email_is_banned($email)
{
    if (!$db = db::get()) return false;

    $email = $db->escape($email);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_type_email = BAN_TYPE_EMAIL;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$email' LIKE BANDATA AND BANTYPE = '$ban_type_email' ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return ($ban_count > 0);
}

function referer_is_banned($referer)
{
    if (!$db = db::get()) return false;

    $referer = $db->escape($referer);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_type_ref = BAN_TYPE_REF;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$referer' LIKE BANDATA AND BANTYPE = '$ban_type_ref' ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return ($ban_count > 0);
}

function add_ban_data($type, $data, $comment, $expires)
{
    if (!$db = db::get()) return false;

    $data_types_array = array(
        BAN_TYPE_IP,
        BAN_TYPE_LOGON,
        BAN_TYPE_NICK,
        BAN_TYPE_EMAIL,
        BAN_TYPE_REF
    );

    if (!in_array($type, $data_types_array)) return false;

    $data = $db->escape($data);
    $comment = $db->escape($comment);

    if (!($table_prefix = get_table_prefix())) return false;

    if (is_numeric($expires) && $expires > 0) {

        $expires_datetime = date(MYSQL_DATETIME_MIDNIGHT, $expires);

        $sql = "INSERT INTO `{$table_prefix}BANNED` (BANTYPE, BANDATA, COMMENT, EXPIRES) ";
        $sql .= "VALUES ('$type', '$data', '$comment', CAST('$expires_datetime' AS DATETIME))";

    } else {

        $sql = "INSERT INTO `{$table_prefix}BANNED` (BANTYPE, BANDATA, COMMENT, EXPIRES) ";
        $sql .= "VALUES ('$type', '$data', '$comment', 0)";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function remove_ban_data_by_id($ban_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ban_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE ID = '$ban_id'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function update_ban_data($ban_id, $type, $data, $comment, $expires)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ban_id)) return false;

    $data_types_array = array(
        BAN_TYPE_IP,
        BAN_TYPE_LOGON,
        BAN_TYPE_NICK,
        BAN_TYPE_EMAIL,
        BAN_TYPE_REF
    );

    if (!in_array($type, $data_types_array)) return false;

    $data = $db->escape($data);
    $comment = $db->escape($comment);

    if (!($table_prefix = get_table_prefix())) return false;

    if (is_numeric($expires) && $expires > 0) {

        $expires_datetime = date(MYSQL_DATETIME_MIDNIGHT, $expires);

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}BANNED` ";
        $sql .= "SET BANTYPE = '$type', BANDATA = '$data', COMMENT = '$comment', ";
        $sql .= "EXPIRES = CAST('$expires_datetime' AS DATETIME) ";
        $sql .= "WHERE ID = '$ban_id'";

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}BANNED` ";
        $sql .= "SET BANTYPE = '$type', BANDATA = '$data', COMMENT = '$comment', ";
        $sql .= "EXPIRES = 0 WHERE ID = '$ban_id'";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function check_ban_data($ban_type, $ban_data, $ban_expires = 0)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($ban_expires)) return false;

    $ban_data = $db->escape($ban_data);

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = time();

    $sql = "SELECT ID FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE '$ban_data' LIKE BANDATA AND BANTYPE = '$ban_type' ";
    $sql .= "AND ($ban_expires > $current_datetime OR $ban_expires = 0) ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($ban_id) = $result->fetch_row();

    return $ban_id;
}

function check_affected_sessions($ban_type, $ban_data, $ban_expires)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($ban_expires)) return false;

    $ban_data = $db->escape($ban_data);

    $affected_sessions = array();

    $ban_type_ip = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref = BAN_TYPE_REF;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $current_datetime = time();

    $sql = "SELECT SESSIONS.UID, USER.LOGON, USER_PEER.PEER_NICKNAME, USER.NICKNAME, ";
    $sql .= "COUNT(*) AS SESSION_COUNT FROM SESSIONS LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.PEER_UID = SESSIONS.UID ";
    $sql .= "AND USER_PEER.UID = '{$_SESSION['UID']}') WHERE ($ban_expires > $current_datetime ";
    $sql .= "OR $ban_expires = 0) AND (((SESSIONS.IPADDRESS LIKE '$ban_data' ";
    $sql .= "OR USER.IPADDRESS LIKE '$ban_data') AND '$ban_type' = '$ban_type_ip') ";
    $sql .= "OR ((SESSIONS.REFERER LIKE '$ban_data' OR USER.REFERER LIKE '$ban_data') ";
    $sql .= "AND '$ban_type' = '$ban_type_ref') OR (USER.LOGON LIKE '$ban_data' ";
    $sql .= "AND '$ban_type' = '$ban_type_logon') OR (USER.NICKNAME LIKE '$ban_data' ";
    $sql .= "AND '$ban_type' = '$ban_type_nick') OR (USER.EMAIL LIKE '$ban_data' ";
    $sql .= "AND '$ban_type' = '$ban_type_email') OR USER.UID IS NULL) ";
    $sql .= "GROUP BY SESSIONS.UID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        while (($ban_result = $result->fetch_assoc()) !== null) {

            if ($ban_result['UID'] == 0) {

                $ban_result['LOGON'] = gettext("Guest");
                $ban_result['NICKNAME'] = gettext("Guest");

            } else {

                if (isset($ban_result['LOGON']) && isset($ban_result['PEER_NICKNAME'])) {
                    if (!is_null($ban_result['PEER_NICKNAME']) && strlen($ban_result['PEER_NICKNAME']) > 0) {
                        $ban_result['NICKNAME'] = $ban_result['PEER_NICKNAME'];
                    }
                }

                if (!isset($ban_result['LOGON'])) $ban_result['LOGON'] = gettext("Unknown user");
                if (!isset($ban_result['NICKNAME'])) $ban_result['NICKNAME'] = "";
            }

            $affected_sessions[$ban_result['UID']] = $ban_result;
        }
    }

    return (sizeof($affected_sessions) > 0) ? $affected_sessions : false;
}

function user_is_banned($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $ban_type_ip = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref = BAN_TYPE_REF;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(BANNED.ID) AS BAN_COUNT FROM `{$table_prefix}BANNED` BANNED, ";
    $sql .= "USER USER LEFT JOIN SESSIONS SESSIONS ON (USER.UID = SESSIONS.UID) ";
    $sql .= "WHERE ((SESSIONS.IPADDRESS LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ip') ";
    $sql .= "OR (SESSIONS.REFERER LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ref') ";
    $sql .= "OR (USER.IPADDRESS LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ip') ";
    $sql .= "OR (USER.LOGON LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_logon') ";
    $sql .= "OR (USER.NICKNAME LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_nick') ";
    $sql .= "OR (USER.EMAIL LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_email') ";
    $sql .= "OR (USER.REFERER LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ref')) ";
    $sql .= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0) ";
    $sql .= "AND USER.UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    list($ban_count) = $result->fetch_row();

    return $ban_count > 0;
}
