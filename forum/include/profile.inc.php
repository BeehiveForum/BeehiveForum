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

/* $Id: profile.inc.php,v 1.39 2006-10-11 17:47:04 decoyduck Exp $ */

/**
* Functions relating to profiles
*/

/**
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");

function profile_section_get_name($psid)
{
   $db_profile_section_get_name = db_connect();

   if (!is_numeric($psid)) return false;

   if (!$table_data = get_table_prefix()) return "The Unknown Section";

   $sql = "SELECT PS.NAME FROM {$table_data['PREFIX']}PROFILE_SECTION PS WHERE PS.PSID = $psid";
   $result = db_query($sql, $db_profile_section_get_name);

   if (db_num_rows($result) > 0) {

       list($sectionname) = db_fetch_array($result, DB_RESULT_NUM);
       return $sectionname;
   }

   return "The Unknown Section";
}

function profile_section_create($name)
{
    $db_profile_section_create = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $name = addslashes($name);

    $sql = "SELECT MAX(POSITION) + 1 FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_profile_section_create);

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}PROFILE_SECTION (NAME, POSITION) ";
    $sql.= "VALUES ('$name', '$new_position')";

    if ($result = db_query($sql, $db_profile_section_create)) {
        return db_insert_id($db_profile_section_create);
    }
    
    return false;
}

function profile_section_update($psid, $position, $name)
{
    $db_profile_section_update = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($position)) return false;

    $name = addslashes($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "SET NAME = '$name', POSITION = '$position' ";
    $sql.= "WHERE PSID = '$psid'";

    $result = db_query($sql, $db_profile_section_update);

    return $result;
}

function profile_sections_get()
{
    $db_profile_section_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PSID, NAME, POSITION ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION, PSID";

    $result = db_query($sql, $db_profile_section_get);

    if (db_num_rows($result) > 0) {

        $profile_sections_get = array();

        while($row = db_fetch_array($result)) {

            $profile_sections_get[] = $row;
        }

        return $profile_sections_get;

    }else {

        return false;
    }
}

function profile_items_get($psid)
{
    $db_profile_items_get = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = $psid ORDER BY POSITION, PIID";

    $result = db_query($sql, $db_profile_items_get);

    if (db_num_rows($result) > 0) {

        $profile_items_get = array();

        while($row = db_fetch_array($result)) {

            $profile_items_get[] = $row;
        }

        return $profile_items_get;

    }else {

        return false;
    }
}

function profile_item_create($psid, $name, $type)
{
    $db_profile_item_create = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($position)) return false;
    if (!is_numeric($type)) return false;

    $name = addslashes($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MAX(POSITION) + 1 FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_profile_section_create);

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) ";
    $sql.= "VALUES ('$psid', '$name', '$type', '$new_position')";

    if ($result = db_query($sql, $db_profile_item_create)) {
        return db_insert_id($db_profile_item_create);
    }

    return false;
}

function profile_item_update($piid, $psid, $type, $name)
{
    $db_profile_item_update = db_connect();

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = addslashes($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET PSID = '$psid', ";
    $sql.= "TYPE = '$type', NAME = '$name' WHERE PIID = '$piid'";

    $result = db_query($sql, $db_profile_item_update);

    return $result;
}

function profile_section_delete($psid)
{
    $db_profile_section_delete = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}PROFILE_SECTION WHERE PSID = '$psid'";
    return db_query($sql, $db_profile_section_delete);
}

function profile_item_delete($piid)
{
    $db_profile_item_delete = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}PROFILE_ITEM WHERE PIID = '$piid'";
    return db_query($sql, $db_profile_item_delete);
}

function profile_section_dropdown($default_psid, $field_name="t_psid", $suffix="")
{
    $html = "<select name=\"${field_name}${suffix}\">";
    $db_profile_section_dropdown = db_connect();

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT PSID, NAME FROM {$table_data['PREFIX']}PROFILE_SECTION";
    $result = db_query($sql, $db_profile_section_dropdown);

    while ($row = db_fetch_array($result)) {

        $html .= "<option value=\"" . $row['PSID'] . "\"";

        if ($row['PSID'] == $default_psid) {
            $html .= " selected=\"selected\"";
        }

        $html .= ">" . $row['NAME'] . "</option>";
    }

    $html .= "</select>";
    return $html;
}

/**
* Gets profile values stored for a user
*
* Returns an array of the following information:
* - <b>PSID</b>         : <i>[PROFILE_SECTION.PSID]</i> Profile section ID
* - <b>SECTION_NAME</b> : <i>[PROFILE_SECTION.NAME]</i> Name of profile section
* - <b>PIID</b>         : <i>[PROFILE_ITEM.PIID]</i>    Profile item ID
* - <b>ITEM_NAME</b>    : <i>[PROFILE_ITEM.NAME]</i>    Name of the profile item
* - <b>TYPE</b>         : <i>[PROFILE_ITEM.TYPE]</i>    Type of profile item (Eg radio-button, checkbox, text field, multi-line text field)
* - <b>CHECK_PIID</b>   : <i>[USER_PROFILE.PIID]</i>
* - <b>ENTRY</b>        : <i>[USER_PROFILE.ENTRY]</i>   User entered value for profile item
* - <b>PRIVACY</b>      : <i>[USER_PROFILE.PRIVACY]</i> Level of privacy of profile item (Eg 0 for viewable by all, 1 for viewable only by friends)
*
* @param integer $uid Returns the profile of this UID
*/
function profile_get_user_values($uid)
{
    $db_profile_get_user_values = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME, PROFILE_ITEM.TYPE, ";
    $sql.= "USER_PROFILE.PIID AS CHECK_PIID, USER_PROFILE.ENTRY, USER_PROFILE.PRIVACY ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION, ";
    $sql.= "{$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid') ";
    $sql.= "WHERE PROFILE_ITEM.PSID = PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID, ";
    $sql.= "PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    $result = db_query($sql, $db_profile_get_user_values);

    if (db_num_rows($result) > 0) {

        $profile_values_array = array();

        while($row = db_fetch_array($result)) {

            $profile_values_array[] = $row;
        }

        return $profile_values_array;

    }else {

        return false;
    }
}

function profile_section_move_up($psid)
{
    $db_profile_section_move_up = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PSID, POSITION FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_profile_section_move_up);

    $profile_section_order = array();

    while ($row = db_fetch_array($result)) {

        $profile_section_order[] = $row['PSID'];
        $profile_section_position[$row['PSID']] = $row['POSITION'];
    }

    if (($profile_section_order_key = array_search($psid, $profile_section_order)) !== false) {

        $profile_section_order_key--;

        if ($profile_section_order_key < 0) {
            $profile_section_order_key = 0;
        }

        $new_position = $profile_section_position[$psid];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '{$profile_section_order[$profile_section_order_key]}'";

        if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

        $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

        return true;
    }

    return false;
}

function profile_section_move_down($psid)
{
    $db_profile_section_move_down = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PSID, POSITION FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_profile_section_move_down);

    $profile_section_order = array();

    while ($row = db_fetch_array($result)) {

        $profile_section_order[] = $row['PSID'];
        $profile_section_position[$row['PSID']] = $row['POSITION'];
    }

    if (($profile_section_order_key = array_search($psid, $profile_section_order)) !== false) {

        $profile_section_order_key++;

        if ($profile_section_order_key > sizeof($profile_section_order)) {
            $profile_section_order = sizeof($profile_section_order);
        }

        $new_position = $profile_section_position[$psid];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '{$profile_section_order[$profile_section_order_key]}'";

        if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

        $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
        $sql.= "WHERE PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

        return true;
    }

    return false;
}

function profile_item_move_up($piid)
{
    $db_profile_item_move_down = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIID, POSITION FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_profile_item_move_down);

    $profile_item_order = array();

    while ($row = db_fetch_array($result)) {
        
        $profile_item_order[] = $row['PIID'];
        $profile_item_position[$row['PIID']] = $row['POSITION'];
    }

    if (($profile_item_order_key = array_search($piid, $profile_item_order)) !== false) {

        $profile_item_order_key--;

        if ($profile_item_order_key < 0) {
            $profile_item_order_key = 0;
        }

        $new_position = $profile_item_position[$piid];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

function profile_item_move_down($piid)
{
    $db_profile_item_move_down = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIID, POSITION FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_profile_item_move_down);

    $profile_item_order = array();

    while ($row = db_fetch_array($result)) {
        
        $profile_item_order[] = $row['PIID'];
        $profile_item_position[$row['PIID']] = $row['POSITION'];
    }

    if (($profile_item_order_key = array_search($piid, $profile_item_order)) !== false) {

        $profile_item_order_key++;

        if ($profile_item_order_key > sizeof($profile_item_order)) {
            $profile_item_order_key = sizeof($profile_item_order);
        }

        $new_position = $profile_item_position[$piid];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

?>