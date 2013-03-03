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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
// End Required includes

function profile_section_get_name($psid)
{
   if (!$db = db::get()) return false;

   if (!is_numeric($psid)) return false;

   if (!($table_prefix = get_table_prefix())) return "The Unknown Section";

   $sql = "SELECT PS.NAME FROM `{$table_prefix}PROFILE_SECTION` PS WHERE PS.PSID = '$psid'";

   if (!($result = $db->query($sql))) return false;

   if ($result->num_rows == 0) return gettext('Unknown Section');

   list($sectionname) = $result->fetch_row();

   return $sectionname;
}

function profile_section_create($name)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $name = $db->escape($name);

    $sql = "SELECT COALESCE(MAX(POSITION), 0) + 1 FROM `{$table_prefix}PROFILE_SECTION` ";

    if (!($result = $db->query($sql))) return false;

    list($new_position) = $result->fetch_row();

    $sql = "INSERT INTO `{$table_prefix}PROFILE_SECTION` (NAME, POSITION) ";
    $sql.= "VALUES ('$name', '$new_position')";

    if (!($result = $db->query($sql))) return false;

    $new_psid = $db->insert_id;

    return $new_psid;
}

function profile_section_update($psid, $name)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    $name = $db->escape($name);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "SET NAME = '$name' WHERE PSID = '$psid'";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function profile_sections_get()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $profile_sections_get = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {
        $profile_sections_get[$profile_data['PSID']] = $profile_data;
    }

    return $profile_sections_get;
}

function profile_sections_get_by_page($page = 1)
{
    if (!$db = db::get()) return false;

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

    if (!($result = $db->query($sql))) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($profile_sections_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($profile_sections_count > 0) && ($page > 1)) {
        return profile_sections_get_by_page($page - 1);
    }

    while (($profile_data = $result->fetch_assoc()) !== null) {
        $profile_sections_array[] = $profile_data;
    }

    return array(
        'profile_sections_array' => $profile_sections_array,
        'profile_sections_count' => $profile_sections_count
    );
}

function profile_items_get($psid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION, PIID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $profile_items_get = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {
        $profile_items_get[] = $profile_data;
    }

    return $profile_items_get;
}

function profile_items_get_by_page($psid, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $profile_items_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS PIID, NAME, TYPE, OPTIONS, POSITION ";
    $sql.= "FROM `{$table_prefix}PROFILE_ITEM` WHERE PSID = '$psid' ";
    $sql.= "ORDER BY POSITION, PIID LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($profile_items_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($profile_items_count > 0) && ($page > 1)) {
        return profile_items_get_by_page($psid, $page - 1);
    }

    while (($profile_item = $result->fetch_assoc()) !== null) {
        $profile_items_array[] = $profile_item;
    }

    return array(
        'profile_items_array' => $profile_items_array,
        'profile_items_count' => $profile_items_count
    );
}

function profile_item_get_name($piid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PIID = '$piid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $profile_data = $result->fetch_assoc();

    return $profile_data['NAME'];
}

function profile_item_create($psid, $name, $type, $options)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = $db->escape($name);
    $options = $db->escape($options);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COALESCE(MAX(POSITION), 0) + 1 FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid'";

    if (!($result = $db->query($sql))) return false;

    list($new_position) = $result->fetch_row();

    $sql = "INSERT INTO `{$table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
    $sql.= "VALUES ('$psid', '$name', '$type', '$options', '$new_position')";

    if (!($result = $db->query($sql))) return false;

    return $db->insert_id;
}

function profile_item_update($piid, $psid, $type, $name, $options)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = $db->escape($name);
    $options = $db->escape($options);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET PSID = '$psid', ";
    $sql.= "TYPE = '$type', NAME = '$name', OPTIONS = '$options' WHERE PIID = '$piid'";

    if (!($result = $db->query($sql))) return false;

    return true;
}

function profile_section_delete($psid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_ITEM` WHERE PSID = '$psid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_SECTION` WHERE PSID = '$psid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}USER_PROFILE` ";
    $sql.= "USING `{$table_prefix}USER_PROFILE` LEFT JOIN `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "ON (`{$table_prefix}PROFILE_ITEM`.`PIID` = `{$table_prefix}USER_PROFILE`.`PIID`) ";
    $sql.= "WHERE `{$table_prefix}PROFILE_ITEM`.`PIID` IS NULL";

    if (!$db->query($sql)) return false;

    return true;
}

function profile_item_delete($piid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}USER_PROFILE` WHERE PIID = '$piid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}PROFILE_ITEM` WHERE PIID = '$piid'";

    if (!$db->query($sql)) return false;

    return true;
}

function profile_section_dropdown($default_psid, $field_name = 't_psid')
{
    if (!$db = db::get()) return '';

    if (!($table_prefix = get_table_prefix())) return '';

    $sql = "SELECT PSID, NAME FROM `{$table_prefix}PROFILE_SECTION`";

    if (!($result = $db->query($sql))) return '';

    if ($result->num_rows == 0) return '';

    while (($profile_section_data = $result->fetch_assoc()) !== null) {
        $profile_sections_array[$profile_section_data['PSID']] = htmlentities_array($profile_section_data['NAME']);
    }

    return form_dropdown_array($field_name, $profile_sections_array, $default_psid);
}

function profile_get_user_values($uid)
{
    if (!$db = db::get()) return false;

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

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $profile_values_array = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {
        $profile_values_array[$profile_data['PIID']] = $profile_data;
    }

    return $profile_values_array;
}

function profile_section_move_up($psid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $profile_section_order = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {

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

        if (!($result = $db->query($sql))) return false;

        $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '$psid'";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function profile_section_move_down($psid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $profile_section_order = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {

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

            if (!($result = $db->query($sql))) return false;

            $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` SET POSITION = '$new_position' ";
            $sql.= "WHERE PSID = '$psid'";

            if (!($result = $db->query($sql))) return false;

            return true;
        }
    }

    return false;
}

function profile_item_move_up($psid, $piid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $profile_item_order = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {

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

        if (!($result = $db->query($sql))) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function profile_item_move_down($psid, $piid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $profile_item_order = array();

    while (($profile_data = $result->fetch_assoc()) !== null) {

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

        if (!($result = $db->query($sql))) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function profile_sections_positions_update()
{
    $new_position = 0;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PSID FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($profile_data = $result->fetch_assoc()) !== null) {

        $new_position++;

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_SECTION` ";
        $sql.= "SET POSITION = '$new_position' WHERE PSID = '{$profile_data['PSID']}'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function profile_items_positions_update()
{
    $new_position = 0;
    $current_section = false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT PIID, PSID FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "ORDER BY PSID, POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($profile_data = $result->fetch_assoc()) !== null) {

        if (($current_section == false) || ($current_section <> $profile_data['PSID'])) {

            $new_position = 0;
            $current_section = $profile_data['PSID'];
        }

        $new_position++;

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}PROFILE_ITEM` ";
        $sql.= "SET POSITION = '$new_position' WHERE PIID = '{$profile_data['PIID']}'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function profile_get_section($psid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($psid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME FROM `{$table_prefix}PROFILE_SECTION` ";
    $sql.= "WHERE PSID = '$psid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows) {

        $profile_section_data = $result->fetch_assoc();
        return $profile_section_data;
    }

    return false;
}

function profile_get_item($piid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($piid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT NAME, TYPE, OPTIONS FROM `{$table_prefix}PROFILE_ITEM` ";
    $sql.= "WHERE PIID = '$piid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows) {

        $profile_item_data = $result->fetch_assoc();
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