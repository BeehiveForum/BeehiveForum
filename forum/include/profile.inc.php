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

/* $Id: profile.inc.php,v 1.54 2007-04-10 16:02:04 decoyduck Exp $ */

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

function profile_section_update($psid, $name)
{
    $db_profile_section_update = db_connect();

    if (!is_numeric($psid)) return false;

    $name = addslashes($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION ";
    $sql.= "SET NAME = '$name' WHERE PSID = '$psid'";

    $result = db_query($sql, $db_profile_section_update);

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

function profile_sections_get_by_page($start)
{
    $db_profile_sections_get_by_page = db_connect();

    if (!is_numeric($start)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $profile_sections_array = array();

    $sql = "SELECT COUNT(PSID) FROM {$table_data['PREFIX']}PROFILE_SECTION";
    $result = db_query($sql, $db_profile_sections_get_by_page);

    list($profile_sections_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME, ";
    $sql.= "PROFILE_SECTION.POSITION, COUNT(PROFILE_ITEM.PIID) AS ITEM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "GROUP BY PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID ";
    $sql.= "LIMIT $start, 10";

    $result = db_query($sql, $db_profile_sections_get_by_page);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            $profile_sections_array[] = $row;
        }

    }else if ($profile_sections_count > 0) {

        $start = ($start - 10) > 0 ? $start - 10 : 0;
        return profile_sections_get_by_page($start);
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

function profile_items_get_by_page($psid, $start)
{
    $db_profile_items_get_by_page = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($start)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $profile_items_array = array();

    $sql = "SELECT COUNT(PIID) FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid'";

    $result = db_query($sql, $db_profile_items_get_by_page);

    list($profile_items_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT PIID, NAME, TYPE, POSITION ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' ORDER BY POSITION, PIID ";
    $sql.= "LIMIT $start, 10";

    $result = db_query($sql, $db_profile_items_get_by_page);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            $profile_items_array[] = $row;
        }

    }else if ($profile_items_count > 0) {

        $start = ($start - 10) > 0 ? $start - 10 : 0;
        return profile_items_get_by_page($psid, $start);
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

    $result = db_query($sql, $db_profile_item_get);

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

    $name = addslashes($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MAX(POSITION) + 1 FROM {$table_data['PREFIX']}PROFILE_ITEM ";
    $sql.= "WHERE PSID = '$psid' LIMIT 0, 1";

    $result = db_query($sql, $db_profile_item_create);

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

    profile_sections_positions_update();

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

    profile_sections_positions_update();

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

    $result = db_query($sql, $db_profile_sections_positions_update);

    while (list($psid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($psid) && is_numeric($psid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_SECTION ";
            $sql.= "SET POSITION = '$new_position' WHERE PSID = '$psid'";

            $result_update = db_query($sql, $db_profile_sections_positions_update);
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

    $result = db_query($sql, $db_profile_items_positions_update);

    while (list($piid, $psid) = db_fetch_array($result, DB_RESULT_NUM)) {
        
        if (($current_section == false) || ($current_section <> $psid)) {
            
            $new_position = 0;
            $current_section = $psid;
        }
        
        if (isset($piid) && is_numeric($piid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}PROFILE_ITEM ";
            $sql.= "SET POSITION = '$new_position' WHERE PIID = '$piid'";

            $result_update = db_query($sql, $db_profile_items_positions_update);
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

    $result = db_query($sql, $db_profile_get_section);

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

    $result = db_query($sql, $db_profile_get_item);

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

    $result = db_query($sql, $db_profile_items_get_list);

    if (db_num_rows($result) > 0) {

        while ($profile_item = db_fetch_array($result)) {

            $profile_header_array[$profile_item['PIID']] = $profile_item['ITEM_NAME'];
            $profile_dropdown_array[$profile_item['SECTION_NAME']][$profile_item['PIID']] = $profile_item['ITEM_NAME'];
        }
    }

    return true;
}

function profile_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty)
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
    $select_sql.= "USER_TRACK.POST_COUNT AS POST_COUNT, DATE_FORMAT(USER_PREFS_DOB.DOB, '00-%m-%d') AS DOB, ";
    $select_sql.= "DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(USER_PREFS_AGE.DOB, '%Y') - ";
    $select_sql.= "(DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(USER_PREFS_AGE.DOB, '00-%m-%d')) AS AGE, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT, ";
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

    // Join to check the DOB display.
    
    $from_sql = "FROM USER USER LEFT JOIN USER_PREFS USER_PREFS_DOB ";
    $from_sql.= "ON (USER_PREFS_DOB.UID = USER.UID AND USER_PREFS_DOB.DOB_DISPLAY > 1 ";
    $from_sql.= "AND USER_PREFS_DOB.DOB > 0) ";

    // Join to check the AGE display.

    $from_sql.= "LEFT JOIN USER_PREFS USER_PREFS_AGE ";
    $from_sql.= "ON (USER_PREFS_AGE.UID = USER.UID AND (USER_PREFS_DOB.DOB_DISPLAY = 1 ";
    $from_sql.= "OR USER_PREFS_DOB.DOB_DISPLAY = 2) AND USER_PREFS_DOB.DOB > 0) ";

    // Joins to check the ANON_LOGON setting.

    $from_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
    $from_sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";

    $from_sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $from_sql.= "ON (USER_PREFS_GLOBAL.UID = USER.UID) ";

    $from_sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID ";
    $from_sql.= "AND USER_FORUM.FID = '$forum_fid' AND ((USER_PREFS_FORUM.ANON_LOGON IS NULL ";
    $from_sql.= "OR USER_PREFS_FORUM.ANON_LOGON = 0) AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL ";
    $from_sql.= "OR USER_PREFS_GLOBAL.ANON_LOGON = 0))) ";

    // Join for the POST_COUNT.

    $from_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $from_sql.= "ON (USER_TRACK.UID = USER.UID) ";

    // Join for user relationship

    $from_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $from_sql.= "ON (USER_PEER.UID = USER.UID AND USER_PEER.PEER_UID = '$uid') ";

    // Joins on the selected numeric (PIID) profile items.

    foreach($profile_items_array as $column => $value) {

        if (is_numeric($column)) {

            $from_sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM_{$column} ";
            $from_sql.= "ON (PROFILE_ITEM_{$column}.PIID = '$column') ";
            $from_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE_{$column} ";
            $from_sql.= "ON (USER_PROFILE_{$column}.PIID = PROFILE_ITEM_{$column}.PIID ";
            $from_sql.= "AND USER_PROFILE_{$column}.UID = USER.UID ";
            $from_sql.= "AND (USER_PROFILE_{$column}.PRIVACY = 0 ";
            $from_sql.= "OR (USER_PROFILE_{$column}.PRIVACY = 1 ";
            $from_sql.= "AND (USER_PEER.RELATIONSHIP & $user_friend > 0)))) ";
        }
    }

    // Are we filtering the results by a LOGON / NICKNAME

    $where_sql_array = array();

    if (($user_search !== false) && strlen(trim($user_search)) > 0) {

        $user_search = addslashes(str_replace('%', '', $user_search));
        $where_sql_array[] = "(USER.LOGON LIKE '$user_search%' OR USER.NICKNAME LIKE '$user_search%') ";
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

    $sql = implode(",", array_merge(array($select_sql), $profile_sql_array));
    $sql.= "$from_sql $where_sql $having_sql $order_sql";

    $result_user_count = db_query($sql, $db_profile_browse_items);
    $user_count = db_num_rows($result_user_count);

    // Query again to get the matching rows for the selected page.

    $sql = implode(",", array_merge(array($select_sql), $profile_sql_array));
    $sql.= "$from_sql $where_sql $having_sql $order_sql $limit_sql";

    $result_user_data = db_query($sql, $db_profile_browse_items);

    $user_array = array();

    if (db_num_rows($result_user_data) > 0) {

        while ($user_data = db_fetch_array($result_user_data, DB_RESULT_ASSOC)) {
            
            if (isset($user_data['LAST_VISIT']) && $user_data['LAST_VISIT'] > 0) {
                $user_data['LAST_VISIT'] = format_time($user_data['LAST_VISIT']);
            }else {
                $user_data['LAST_VISIT'] = $lang['unknown'];
            }            
            
            if (isset($user_data['REGISTERED']) && $user_data['REGISTERED'] > 0) {
                $user_data['REGISTERED'] = format_date($user_data['REGISTERED']);
            }else {
                $user_data['REGISTERED'] = $lang['unknown'];
            }

            if (isset($user_data['USER_TIME_BEST']) && $user_data['USER_TIME_BEST'] > 0) {
                $user_data['USER_TIME_BEST'] = format_time_display($user_data['USER_TIME_BEST']);
            }else {
                $user_data['USER_TIME_BEST'] = $lang['unknown'];
            }

            if (isset($user_data['USER_TIME_TOTAL']) && $user_data['USER_TIME_TOTAL'] > 0) {
                $user_data['USER_TIME_TOTAL'] = format_time_display($user_data['USER_TIME_TOTAL']);
            }else {
                $user_data['USER_TIME_TOTAL'] = $lang['unknown'];
            }

            if (isset($user_data['DOB']) && $user_data['DOB'] > 0) {
                $user_data['DOB'] = format_dob($user_data['DOB']);
            }else {
                $user_data['DOB'] = $lang['unknown'];
            }

            if (!isset($user_data['POST_COUNT']) || is_null($user_data['POST_COUNT'])) {
                $user_data['POST_COUNT'] = 0;
            }
            
            $user_array[$user_data['UID']] = $user_data;
        }
    
    }elseif ($user_count > 0) {

        $offset = ($offset - 20) > 0 ? $offset - 20 : 0;
        return profile_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty);
    }

    return array('user_count' => $user_count,
                 'user_array' => $user_array);
}

?>