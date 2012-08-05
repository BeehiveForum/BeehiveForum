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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';

function profile_section_get_name($psid)
{
   if (!$db_profile_section_get_name = db_connect()) return false;

   if (!is_numeric($psid)) return false;

   if (!($table_prefix = get_table_prefix())) return "The Unknown Section";

   $sql = "SELECT PS.NAME FROM `{$table_prefix}PROFILE_SECTION` PS WHERE PS.PSID = '$psid'";

   if (!$result = db_query($sql, $db_profile_section_get_name)) return false;

   if (db_num_rows($result) == 0) return gettext('Unknown Section');

   list($sectionname) = db_fetch_array($result, DB_RESULT_NUM);

   return $sectionname;
}

function profile_section_create($name)
{
    if (!$db_profile_section_create = db_connect()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $name = db_escape_string($name);

    $sql = "SELECT COALESCE(MAX(POSITION), 0) + 1 FROM `{$table_prefix}PROFILE_SECTION` ";

    if (!$result = db_query($sql, $db_profile_section_create)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO `{$table_prefix}PROFILE_SECTION` (NAME, POSITION) ";
    $sql.= "VALUES ('$name', '$new_position')";

    if (($result = db_query($sql, $db_profile_section_create))) {

        $new_psid = db_insert_id($db_profile_section_create);
        return $new_psid;
    }

    return false;
}

function profile_section_update($psid, $name)
{
    if (!$db_profile_section_update = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    $name = db_escape_string($name);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "SET NAME = '$name' WHERE PSID = '$psid'";

    if (!$result = db_query($sql, $db_profile_section_update)) return false;

    return $result;
}

function profile_sections_get()
{
    if (!$db_profile_section_get = db_connect()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID";

    if (!$result = db_query($sql, $db_profile_section_get)) return false;

    if (db_num_rows($result) == 0) return false;

    $profile_sections_get = array();

    while (($profile_data = db_fetch_array($result))) {
        $profile_sections_get[$profile_data['PSID']] = $profile_data;
    }

    return $profile_sections_get;
}

function profile_sections_get_by_page($page = 1)
{
    if (!$db_profile_sections_get_by_page = db_connect()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $profile_sections_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_profile_sections_get_by_page)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_profile_sections_get_by_page)) return false;

    list($profile_sections_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if ((db_num_rows($result) == 0) && ($profile_sections_count > 0) && ($page > 1)) {
        return profile_sections_get_by_page($page - 1);
    }
        
    while (($profile_data = db_fetch_array($result))) {
        $profile_sections_array[] = $profile_data;
    }

    return array(
        'profile_sections_array' => $profile_sections_array,
        'profile_sections_count' => $profile_sections_count
    );
}

function profile_items_get($psid)
{
    if (!$db_profile_items_get = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION, PIID";

    if (!$result = db_query($sql, $db_profile_items_get)) return false;

    if (db_num_rows($result) == 0) return false;

    $profile_items_get = array();

    while (($profile_data = db_fetch_array($result))) {
        $profile_items_get[] = $profile_data;
    }

    return $profile_items_get;
}

function profile_items_get_by_page($psid, $page = 1)
{
    if (!$db_profile_items_get_by_page = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $profile_items_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS PIID, NAME, TYPE, OPTIONS, POSITION ";
    $sql.= "FROM `{$table_prefix}PROFILE_ITEM` WHERE PSID = '$psid' ";
    $sql.= "ORDER BY POSITION, PIID LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_profile_items_get_by_page)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_profile_items_get_by_page)) return false;

    list($profile_items_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if ((db_num_rows($result) == 0) && ($profile_items_count > 0) && ($page > 1)) {
        return profile_items_get_by_page($psid, $page - 1);
    }
    
    while (($profile_item = db_fetch_array($result))) {
        $profile_items_array[] = $profile_item;
    }

    return array(
        'profile_items_array' => $profile_items_array,
        'profile_items_count' => $profile_items_count
    );
}

function profile_item_get_name($piid)
{
    if (!$db_profile_item_get = db_connect()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PIID = '$piid'";

    if (!$result = db_query($sql, $db_profile_item_get)) return false;

    if (db_num_rows($result) == 0) return false;

    $profile_data = db_fetch_array($result);

    return $profile_data['NAME'];
}

function profile_item_create($psid, $name, $type, $options)
{
    if (!$db_profile_item_create = db_connect()) return false;

    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = db_escape_string($name);
    $options = db_escape_string($options);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COALESCE(MAX(POSITION), 0) + 1 FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid'";

    if (!$result = db_query($sql, $db_profile_item_create)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO `{$table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
    $sql.= "VALUES ('$psid', '$name', '$type', '$options', '$new_position')";

    if (!($result = db_query($sql, $db_profile_item_create))) return false;

    return db_insert_id($db_profile_item_create);
}

function profile_item_update($piid, $psid, $type, $name, $options)
{
    if (!$db_profile_item_update = db_connect()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = db_escape_string($name);
    $options = db_escape_string($options);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET PSID = '$psid', ";
    $sql.= "TYPE = '$type', NAME = '$name', OPTIONS = '$options' WHERE PIID = '$piid'";

    if (!($result = db_query($sql, $db_profile_item_update))) return false;

    return true;
}

function profile_section_delete($psid)
{
    if (!$db_profile_section_delete = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_ITEM` WHERE PSID = '$psid'";

    if (!db_query($sql, $db_profile_section_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_SECTION` WHERE PSID = '$psid'";

    if (!db_query($sql, $db_profile_section_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}USER_PROFILE` ";
    $sql.= "USING `{$table_prefix}USER_PROFILE` LEFT JOIN `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "ON (`{$table_prefix}PROFILE_ITEM`.`PIID` = `{$table_prefix}USER_PROFILE`.`PIID`) ";
    $sql.= "WHERE `{$table_prefix}PROFILE_ITEM`.`PIID` IS NULL";

    if (!db_query($sql, $db_profile_section_delete)) return false;

    return true;
}

function profile_item_delete($piid)
{
    if (!$db_profile_item_delete = db_connect()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}USER_PROFILE` WHERE PIID = '$piid'";

    if (!db_query($sql, $db_profile_item_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_ITEM` WHERE PIID = '$piid'";

    if (!db_query($sql, $db_profile_item_delete)) return false;

    return true;
}

function profile_section_dropdown($default_psid, $field_name = 't_psid')
{
    if (!$db_profile_section_dropdown = db_connect()) return '';

    if (!($table_prefix = get_table_prefix())) return '';

    $sql = "SELECT PSID, NAME FROM `{$table_prefix}PROFILE_SECTION`";

    if (!$result = db_query($sql, $db_profile_section_dropdown)) return '';

    if (db_num_rows($result) == 0) return '';

    while (($profile_section_data = db_fetch_array($result))) {
        $profile_sections_array[$profile_section_data['PSID']] = htmlentities_array($profile_section_data['NAME']);
    }

    return form_dropdown_array($field_name, $profile_sections_array, $default_psid);
}

function profile_get_user_values($uid)
{
    if (!$db_profile_get_user_values = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME, PROFILE_ITEM.TYPE, ";
    $sql.= "PROFILE_ITEM.OPTIONS, USER_PROFILE.PIID AS CHECK_PIID, ";
    $sql.= "USER_PROFILE.ENTRY, USER_PROFILE.PRIVACY ";
    $sql.= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PROFILE` USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid') ";
    $sql.= "WHERE PROFILE_ITEM.PIID IS NOT NULL ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID, ";
    $sql.= "PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID ";

    if (!$result = db_query($sql, $db_profile_get_user_values)) return false;

    if (db_num_rows($result) == 0) return false;

    $profile_values_array = array();

    while (($profile_data = db_fetch_array($result))) {
        $profile_values_array[$profile_data['PIID']] = $profile_data;
    }

    return $profile_values_array;
}

function profile_section_move_up($psid)
{
    if (!$db_profile_section_move_up = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

    $profile_section_order = array();

    while (($profile_data = db_fetch_array($result))) {

        $profile_section_order[] = $profile_data['PSID'];
        $profile_section_position[$profile_data['PSID']] = $profile_data['POSITION'];
    }

    if (($profile_section_order_key = array_search($psid, $profile_section_order)) !== false) {

        $profile_section_order_key--;

        if ($profile_section_order_key < 0) {
            $profile_section_order_key = 0;
        }

        $new_position = $profile_section_position[$psid];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '{$profile_section_order[$profile_section_order_key]}'";

        if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

        $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

        return true;
    }

    return false;
}

function profile_section_move_down($psid)
{
    if (!$db_profile_section_move_down = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

    $profile_section_order = array();

    while (($profile_data = db_fetch_array($result))) {

        $profile_section_order[] = $profile_data['PSID'];
        $profile_section_position[$profile_data['PSID']] = $profile_data['POSITION'];
    }

    if (($profile_section_order_key = array_search($psid, $profile_section_order)) !== false) {

        $profile_section_order_key++;

        if ($profile_section_order_key > sizeof($profile_section_order)) {
            $profile_section_order = sizeof($profile_section_order);
        }

        $new_position = $profile_section_position[$psid];

        if (isset($profile_section_order[$profile_section_order_key])) {

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
            $sql.= "WHERE PSID = '{$profile_section_order[$profile_section_order_key]}'";

            if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

            $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
            $sql.= "WHERE PSID = '$psid'";

            if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

            return true;
        }
    }

    return false;
}

function profile_item_move_up($psid, $piid)
{
    if (!$db_profile_item_move_down = db_connect()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

    $profile_item_order = array();

    while (($profile_data = db_fetch_array($result))) {

        $profile_item_order[] = $profile_data['PIID'];
        $profile_item_position[$profile_data['PIID']] = $profile_data['POSITION'];
    }

    if (($profile_item_order_key = array_search($piid, $profile_item_order)) !== false) {

        $profile_item_order_key--;

        if ($profile_item_order_key < 0) {
            $profile_item_order_key = 0;
        }

        $new_position = $profile_item_position[$piid];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}' ";
        $sql.= "AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

function profile_item_move_down($psid, $piid)
{
    if (!$db_profile_item_move_down = db_connect()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

    $profile_item_order = array();

    while (($profile_data = db_fetch_array($result))) {

        $profile_item_order[] = $profile_data['PIID'];
        $profile_item_position[$profile_data['PIID']] = $profile_data['POSITION'];
    }

    if (($profile_item_order_key = array_search($piid, $profile_item_order)) !== false) {

        $profile_item_order_key++;

        if ($profile_item_order_key > sizeof($profile_item_order)) {
            $profile_item_order_key = sizeof($profile_item_order);
        }

        $new_position = $profile_item_position[$piid];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}' ";
        $sql.= "AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

function profile_sections_positions_update()
{
    $new_position = 0;

    if (!$db_profile_sections_positions_update = db_connect()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PSID FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_sections_positions_update)) return false;

    while (list($psid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($psid) && is_numeric($psid)) {

            $new_position++;

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` ";
            $sql.= "SET POSITION = '$new_position' WHERE PSID = '$psid'";

            if (!db_query($sql, $db_profile_sections_positions_update)) return false;
        }
    }

    return true;
}

function profile_items_positions_update()
{
    $new_position = 0;
    $current_section = false;

    if (!$db_profile_items_positions_update = db_connect()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PIID, PSID FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "ORDER BY PSID, POSITION";

    if (!$result = db_query($sql, $db_profile_items_positions_update)) return false;

    while (list($piid, $psid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (($current_section == false) || ($current_section <> $psid)) {

            $new_position = 0;
            $current_section = $psid;
        }

        if (isset($piid) && is_numeric($piid)) {

            $new_position++;

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` ";
            $sql.= "SET POSITION = '$new_position' WHERE PIID = '$piid'";

            if (!db_query($sql, $db_profile_items_positions_update)) return false;
        }
    }

    return true;
}

function profile_get_section($psid)
{
    if (!$db_profile_get_section = db_connect()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "WHERE PSID = '$psid'";

    if (!$result = db_query($sql, $db_profile_get_section)) return false;

    if (db_num_rows($result)) {

        $profile_section_data = db_fetch_array($result);
        return $profile_section_data;
    }

    return false;
}

function profile_get_item($piid)
{
    if (!$db_profile_get_item = db_connect()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME, TYPE, OPTIONS FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PIID = '$piid'";

    if (!$result = db_query($sql, $db_profile_get_item)) return false;

    if (db_num_rows($result)) {

        $profile_item_data = db_fetch_array($result);
        return $profile_item_data;
    }

    return false;
}

function profile_item_add_clear_entry(&$profile_item_options_array, $type)
{
    $valid_item_types_aray = array(
        PROFILE_ITEM_RADIO, 
        PROFILE_ITEM_DROPDOWN
    );

    if (!is_array($profile_item_options_array)) return false;
    if (!in_array($type, $valid_item_types_aray)) return false;

    $profile_item_options_array_keys = array_keys($profile_item_options_array);

    array_unshift($profile_item_options_array_keys, '-1');

    if ($type == PROFILE_ITEM_RADIO) {

        array_unshift($profile_item_options_array, "<i>[", gettext("Clear"), "]</i>");
        $profile_item_options_array = array_combine($profile_item_options_array_keys, $profile_item_options_array);

    } else {

        array_unshift($profile_item_options_array, "&nbsp;");
        $profile_item_options_array = array_combine($profile_item_options_array_keys, $profile_item_options_array);
    }

    return true;
}

?>