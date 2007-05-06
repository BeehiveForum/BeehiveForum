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

/* $Id: profile.inc.php,v 1.67 2007-05-06 20:33:43 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function profile_section_get_name($psid)
{
   $db_profile_section_get_name = db_connect();

   if (!is_numeric($psid)) return false;

   if (!$table_data = get_table_prefix()) return "The Unknown Section";

   $sql = "SELECT PS.NAME FROM {$table_data['PREFIX']}PROFILE_SECTION PS WHERE PS.PSID = '$psid'";

   if (!$result = db_query($sql, $db_profile_section_get_name)) return false;

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

    $name = db_escape_string($name);

    $sql = "SELECT MAX(POSITION) + 1 FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_profile_section_create)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}PROFILE_SECTION (NAME, POSITION) ";
    $sql.= "VALUES ('$name', '$new_position')";

    if ($result = db_query($sql, $db_profile_section_create)) {
        return db_insert_id($db_profile_section_create);
    }
    
    return false;
}

function profile_section_update($psid, $name)
{
    $db_profile_section_update = db_connect();

    if (!is_numeric($psid)) return false;

    $name = db_escape_string($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "SET NAME = '$name' WHERE PSID = '$psid'";

    if (!$result = db_query($sql, $db_profile_section_update)) return false;

    return $result;
}

function profile_sections_get()
{
    $db_profile_section_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID";

    if (!$result = db_query($sql, $db_profile_section_get)) return false;

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

function profile_sections_get_by_page($offset)
{
    $db_profile_sections_get_by_page = db_connect();

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $profile_sections_array = array();

    $sql = "SELECT COUNT(PSID) FROM {$table_data['PREFIX']}PROFILE_SECTION";

    if (!$result = db_query($sql, $db_profile_sections_get_by_page)) return false;

    list($profile_sections_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_profile_sections_get_by_page)) return false;

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            $profile_sections_array[] = $row;
        }

    }else if ($profile_sections_count > 0) {

        $offset = floor(($profile_sections_count / 10) - 1) * 10;
        return profile_sections_get_by_page($offset);
    }

    return array('profile_sections_array' => $profile_sections_array,
                 'profile_sections_count' => $profile_sections_count);
}

function profile_items_get($psid)
{
    $db_profile_items_get = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION, PIID";

    if (!$result = db_query($sql, $db_profile_items_get)) return false;

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

function profile_items_get_by_page($psid, $offset)
{
    $db_profile_items_get_by_page = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $profile_items_array = array();

    $sql = "SELECT COUNT(PIID) FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid'";

    if (!$result = db_query($sql, $db_profile_items_get_by_page)) return false;

    list($profile_items_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION, PIID ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_profile_items_get_by_page)) return false;

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            $profile_items_array[] = $row;
        }

    }else if ($profile_items_count > 0) {

        $offset = floor(($profile_items_count / 10) - 1) * 10;
        return profile_items_get_by_page($psid, $offset);
    }

    return array('profile_items_array' => $profile_items_array,
                 'profile_items_count' => $profile_items_count);
}

function profile_item_get_name($piid)
{
    $db_profile_item_get = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT NAME FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PIID = '$piid'";

    if (!$result = db_query($sql, $db_profile_item_get)) return false;

    if (db_num_rows($result) > 0) {

        $profile_data = db_fetch_array($result);
        return $profile_data['NAME'];
    }

    return false;
}

function profile_item_create($psid, $name, $type)
{
    $db_profile_item_create = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($type)) return false;

    $name = db_escape_string($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MAX(POSITION) + 1 FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_profile_item_create)) return false;

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

    $name = db_escape_string($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET PSID = '$psid', ";
    $sql.= "TYPE = '$type', NAME = '$name' WHERE PIID = '$piid'";

    if (!$result = db_query($sql, $db_profile_item_update)) return false;

    return $result;
}

function profile_section_delete($psid)
{
    $db_profile_section_delete = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}PROFILE_SECTION WHERE PSID = '$psid'";
    
    if (!$result = db_query($sql, $db_profile_section_delete)) return false;

    return true;
}

function profile_item_delete($piid)
{
    $db_profile_item_delete = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}PROFILE_ITEM WHERE PIID = '$piid'";
    
    if (!$result = db_query($sql, $db_profile_item_delete)) return false;

    return true;
}

function profile_section_dropdown($default_psid, $field_name = 't_psid')
{
    $db_profile_section_dropdown = db_connect();

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT PSID, NAME FROM {$table_data['PREFIX']}PROFILE_SECTION";

    if (!$result = db_query($sql, $db_profile_section_dropdown)) return false;

    if (db_num_rows($result) > 0) {

        while ($profile_section_data = db_fetch_array($result)) {
            $profile_sections_array[$profile_section_data['PSID']] = $profile_section_data['NAME'];
        }

        return form_dropdown_array($field_name, $profile_sections_array, $default_psid);
    }

    return "";
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

    if (!$result = db_query($sql, $db_profile_get_user_values)) return false;

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

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_section_move_up)) return false;

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

    profile_sections_positions_update();

    $sql = "SELECT PSID, POSITION FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

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

        if (isset($profile_section_order[$profile_section_order_key])) {

            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
            $sql.= "WHERE PSID = '{$profile_section_order[$profile_section_order_key]}'";

            if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

            $new_position = $profile_section_position[$profile_section_order[$profile_section_order_key]];

            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION SET POSITION = '$new_position' ";
            $sql.= "WHERE PSID = '$psid'";

            if (!$result = db_query($sql, $db_profile_section_move_down)) return false;

            return true;
        }
    }

    return false;
}

function profile_item_move_up($psid, $piid)
{
    $db_profile_item_move_down = db_connect();

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

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
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}' ";
        $sql.= "AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

function profile_item_move_down($psid, $piid)
{
    $db_profile_item_move_down = db_connect();

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    profile_items_positions_update();

    $sql = "SELECT PIID, POSITION FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

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
        $sql.= "WHERE PIID = '{$profile_item_order[$profile_item_order_key]}' ";
        $sql.= "AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        $new_position = $profile_item_position[$profile_item_order[$profile_item_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM SET POSITION = '$new_position' ";
        $sql.= "WHERE PIID = '$piid' AND PSID = '$psid'";

        if (!$result = db_query($sql, $db_profile_item_move_down)) return false;

        return true;
    }

    return false;
}

function profile_sections_positions_update()
{
    $new_position = 0;

    $db_profile_sections_positions_update = db_connect();

    if (!$table_data = get_table_prefix()) return;

    $sql = "SELECT PSID FROM {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_profile_sections_positions_update)) return false;

    while (list($psid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($psid) && is_numeric($psid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION ";
            $sql.= "SET POSITION = '$new_position' WHERE PSID = '$psid'";

            if (!$result_update = db_query($sql, $db_profile_sections_positions_update)) return false;
        }
    }
}

function profile_items_positions_update()
{
    $new_position = 0;
    $current_section = false;

    $db_profile_items_positions_update = db_connect();

    if (!$table_data = get_table_prefix()) return;

    $sql = "SELECT PIID, PSID FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "ORDER BY PSID, POSITION";

    if (!$result = db_query($sql, $db_profile_items_positions_update)) return false;

    while (list($piid, $psid) = db_fetch_array($result, DB_RESULT_NUM)) {
        
        if (($current_section == false) || ($current_section <> $psid)) {
            
            $new_position = 0;
            $current_section = $psid;
        }
        
        if (isset($piid) && is_numeric($piid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM ";
            $sql.= "SET POSITION = '$new_position' WHERE PIID = '$piid'";

            if (!$result_update = db_query($sql, $db_profile_items_positions_update)) return false;
        }
    }
}

function profile_get_section($psid)
{
    $db_profile_get_section = db_connect();

    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return;

    $sql = "SELECT NAME FROM {$table_data['PREFIX']}PROFILE_SECTION ";
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
    $db_profile_get_item = db_connect();

    if (!is_numeric($piid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT NAME, TYPE FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PIID = '$piid'";

    if (!$result = db_query($sql, $db_profile_get_item)) return false;

    if (db_num_rows($result)) {

        $profile_item_data = db_fetch_array($result);
        return $profile_item_data;
    }

    return false;
}

function profile_items_get_list(&$profile_header_array, &$profile_dropdown_array)
{
    $db_profile_items_get_list = db_connect();

    $lang = load_language_file();
    
    if (!$table_data = get_table_prefix()) return false;

    // Pre-defined profile options    
    
    $profile_header_array = array('POST_COUNT'      => $lang['postcount'],
                                  'LAST_VISIT'      => $lang['lastvisit'],
                                  'REGISTERED'      => $lang['registered'],
                                  'USER_TIME_BEST'  => $lang['longesttimeinforum'],
                                  'USER_TIME_TOTAL' => $lang['totaltimeinforum'],
                                  'DOB'             => $lang['birthday'],
                                  'AGE'             => $lang['age']);

    // Add the pre-defined profile options to the top of the list

    $profile_dropdown_array[$lang['userdetails']] = $profile_header_array;

    // Query the database to get the

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "ON (PROFILE_SECTION.PSID = PROFILE_ITEM.PSID) ";
    $sql.= "WHERE PROFILE_SECTION.PSID IS NOT NULL";

    if (!$result = db_query($sql, $db_profile_items_get_list)) return false;

    if (db_num_rows($result) > 0) {

        while ($profile_item = db_fetch_array($result)) {

            $profile_header_array[$profile_item['PIID']] = $profile_item['ITEM_NAME'];
            $profile_dropdown_array[$profile_item['SECTION_NAME']][$profile_item['PIID']] = $profile_item['ITEM_NAME'];
        }
    }

    return true;
}

function profile_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests)
{
    $db_profile_browse_items = db_connect();

    // Check the function parameters are all correct.

    if (!is_numeric($offset)) return false;

    if (!is_array($profile_items_array)) return false;

    // Fetch the table prefix.

    if (!$table_data = get_table_prefix()) return false;

    // Forum FID which we'll need later.

    $forum_fid = $table_data['FID'];

    // Permitted columns to sort the results by

    $sort_by_array  = array_keys($profile_items_array);

    // Permitted sort directions.

    $sort_dir_array = array('ASC', 'DESC'); 

    // Check the specified sort by and sort directions. If they're
    // invalid default to LAST_VISIT DESC.

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'UID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    // Load the language file.

    $lang = load_language_file();

    // Get the current session's UID.

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Constant for the relationship

    $user_friend = USER_FRIEND;

    // Main query.

    $select_sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP, ";
    $select_sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL, ";
    $select_sql.= "USER_TRACK.POST_COUNT AS POST_COUNT, DATE_FORMAT(USER_PREFS_DOB.DOB, '00-%m-%d') AS DOB, ";
    $select_sql.= "DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(USER_PREFS_AGE.DOB, '%Y') - ";
    $select_sql.= "(DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(USER_PREFS_AGE.DOB, '00-%m-%d')) AS AGE, ";
    $select_sql.= "UNIX_TIMESTAMP(VISITOR_LOG_TIME.LAST_LOGON) AS LAST_VISIT, ";
    $select_sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL ";

    // Include the selected numeric (PIID) profile items

    $profile_sql_array = array();

    foreach($profile_items_array as $column => $value) {

        if (is_numeric($column)) {

            $profile_sql = "USER_PROFILE_{$column}.ENTRY AS ENTRY_{$column} ";
            $profile_sql_array[] = $profile_sql;
        }
    }

    // From portion which selects users and guests from the VISITOR_LOG table.
    
    $from_sql = "FROM VISITOR_LOG LEFT JOIN USER ON (USER.UID = VISITOR_LOG.UID) ";

    // Union from portion which flips the from and join so that we get the users
    // who haven't recently logged on to the forum.

    $union_sql = "FROM USER LEFT JOIN VISITOR_LOG ON (VISITOR_LOG.UID = USER.UID) ";

    // Join to get the user's DOB.    
    
    $join_sql = "LEFT JOIN USER_PREFS USER_PREFS_DOB ON (USER_PREFS_DOB.UID = USER.UID ";
    $join_sql.= "AND USER_PREFS_DOB.DOB_DISPLAY > 1 AND USER_PREFS_DOB.DOB > 0) ";

    // Join to check the AGE display.

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_AGE ";
    $join_sql.= "ON (USER_PREFS_AGE.UID = USER.UID AND (USER_PREFS_DOB.DOB_DISPLAY = 1 ";
    $join_sql.= "OR USER_PREFS_DOB.DOB_DISPLAY = 2) AND USER_PREFS_DOB.DOB > 0) ";

    // Joins to check the ANON_LOGON setting.

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
    $join_sql.= "ON (USER_PREFS_FORUM.UID = VISITOR_LOG.UID) ";

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $join_sql.= "ON (USER_PREFS_GLOBAL.UID = VISITOR_LOG.UID) ";

    // Join to fetch the LAST_LOGON using the ANON_LOGON data

    $join_sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG_TIME ON (VISITOR_LOG_TIME.VID = VISITOR_LOG.VID ";
    $join_sql.= "AND ((USER_PREFS_FORUM.ANON_LOGON IS NULL OR USER_PREFS_FORUM.ANON_LOGON = 0) ";
    $join_sql.= "AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL OR USER_PREFS_GLOBAL.ANON_LOGON = 0))) ";

    // Join for the POST_COUNT.

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $join_sql.= "ON (USER_TRACK.UID = USER.UID) ";

    // Join for user relationship

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $join_sql.= "ON (USER_PEER.UID = USER.UID AND USER_PEER.PEER_UID = '$uid') ";

    // Join for the search bot data

    $join_sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";

    // Joins on the selected numeric (PIID) profile items.

    foreach($profile_items_array as $column => $value) {

        if (is_numeric($column)) {

            $join_sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM_{$column} ";
            $join_sql.= "ON (PROFILE_ITEM_{$column}.PIID = '$column') ";
            $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE_{$column} ";
            $join_sql.= "ON (USER_PROFILE_{$column}.PIID = PROFILE_ITEM_{$column}.PIID ";
            $join_sql.= "AND USER_PROFILE_{$column}.UID = USER.UID ";
            $join_sql.= "AND (USER_PROFILE_{$column}.PRIVACY = 0 ";
            $join_sql.= "OR (USER_PROFILE_{$column}.PRIVACY = 1 ";
            $join_sql.= "AND (USER_PEER.RELATIONSHIP & $user_friend > 0)))) ";
        }
    }

    // Are we filtering the results by a LOGON / NICKNAME

    $where_sql_array = array();

    if (($user_search !== false) && strlen(trim($user_search)) > 0) {

        $user_search = db_escape_string(str_replace('%', '', $user_search));
        
        $user_search_sql = "(USER.LOGON LIKE '$user_search%' OR ";
        $user_search_sql.= "USER.NICKNAME LIKE '$user_search%' OR ";
        $user_search_sql.= "SEARCH_ENGINE_BOTS.NAME LIKE '$user_search%') ";
        
        $where_sql_array[] = $user_search_sql;
    }

    if ($hide_guests === true) {

        $where_sql_array[] = "(USER.UID IS NOT NULL AND USER.UID > 0) ";
    }

    if (sizeof($where_sql_array) > 0) {
        $where_sql = "WHERE ". implode(" AND ", $where_sql_array);
    }else {
        $where_sql = "";
    }

    // Null column filtering

    $having_sql_array = array();

    if ($hide_empty === true) {

        foreach($profile_items_array as $column => $value) {
            if (is_numeric($column)) {
                $having_sql_array[] = "(ENTRY_{$column} IS NOT NULL AND LENGTH(ENTRY_{$column}) > 0) ";
            }else {
                $having_sql_array[] = "($column IS NOT NULL AND LENGTH($column) > 0) ";
            }
        }
    }

    if (sizeof($having_sql_array) > 0) {
        $having_sql = "HAVING ". implode(" OR ", $having_sql_array);
    }else {
        $having_sql = "";
    }        

    // Sort direction specified?

    $order_sql = is_numeric($sort_by) ? "ORDER BY ENTRY_{$sort_by} $sort_dir " : "ORDER BY $sort_by $sort_dir ";

    // Limit the display to 10 per page.

    $limit_sql = "LIMIT $offset, 10";

    // Get the number of users in our database.

    // If we're running on MySQL 4.0.16 or better we can perform
    // a UNION and duplicate the main query with the JOIN on VISITOR_LOG
    // and FROM USER parts of the query switched so we include users who are not
    // listed in the visitor log.

    // Officially Beehive's first ever UNION - 23rd April 2007

    if (db_fetch_mysql_version() >= 40116) {

        $sql = implode(",", array_merge(array($select_sql), $profile_sql_array));
        $sql.= "$from_sql $join_sql $where_sql $having_sql UNION ";
        $sql.= implode(",", array_merge(array($select_sql), $profile_sql_array));
        $sql.= "$union_sql $join_sql $where_sql $having_sql $order_sql";

    }else {

        $sql = implode(",", array_merge(array($select_sql), $profile_sql_array));
        $sql.= "$from_sql $join_sql $where_sql $having_sql $order_sql";
    }

    // Execute the query.

    if (!$result = db_query($sql, $db_profile_browse_items)) return false;

    // Array to store our results in.
    
    $user_array = array();

    // Get the number of rows.

    if (($user_count = db_num_rows($result)) > 0) {

        $offset = ($offset > $user_count) ? floor(($user_count / 10) - 1) * 10 : $offset;

        if (db_data_seek($result, $offset)) {
            
            while ($user_data = db_fetch_array($result, DB_RESULT_ASSOC)) {
                
                if (is_null($user_data['UID']) || $user_data['UID'] == 0) {

                    $user_data['UID']      = 0;
                    $user_data['LOGON']    = $lang['guest'];
                    $user_data['NICKNAME'] = $lang['guest'];
                }

                if (isset($user_data['LAST_VISIT']) && !is_null($user_data['LAST_VISIT'])) {
                    $user_data['LAST_VISIT'] = format_time($user_data['LAST_VISIT']);
                }else {
                    $user_data['LAST_VISIT'] = $lang['unknown'];
                }            

                if (isset($user_data['REGISTERED']) && !is_null($user_data['REGISTERED'])) {
                    $user_data['REGISTERED'] = format_date($user_data['REGISTERED']);
                }else {
                    $user_data['REGISTERED'] = $lang['unknown'];
                }

                if (isset($user_data['USER_TIME_BEST']) && !is_null($user_data['USER_TIME_BEST'])) {
                    $user_data['USER_TIME_BEST'] = format_time_display($user_data['USER_TIME_BEST']);
                }else {
                    $user_data['USER_TIME_BEST'] = $lang['unknown'];
                }

                if (isset($user_data['USER_TIME_TOTAL']) && !is_null($user_data['USER_TIME_TOTAL'])) {
                    $user_data['USER_TIME_TOTAL'] = format_time_display($user_data['USER_TIME_TOTAL']);
                }else {
                    $user_data['USER_TIME_TOTAL'] = $lang['unknown'];
                }

                if (isset($user_data['DOB']) && !is_null($user_data['DOB'])) {
                    $user_data['DOB'] = format_dob($user_data['DOB']);
                }else {
                    $user_data['DOB'] = $lang['unknown'];
                }

                if (!isset($user_data['POST_COUNT']) || is_null($user_data['POST_COUNT'])) {
                    $user_data['POST_COUNT'] = 0;
                }

                $user_array[] = $user_data;
                
                if (sizeof($user_array) > 9) break;
            }
        }
    
    }

    return array('user_count' => $user_count,
                 'user_array' => $user_array);

}

?>