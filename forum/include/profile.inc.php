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

/* $Id: profile.inc.php,v 1.23 2004-03-13 20:04:36 decoyduck Exp $ */

function profile_section_get_name($psid)
{
   $db_profile_section_get_name = db_connect();

   if (!is_numeric($psid)) return "The Unknown Section";
   
   $webtag = get_webtag();

   $sql = "SELECT PS.NAME FROM {$webtag['PREFIX']}PROFILE_SECTION PS WHERE PS.PSID = $psid";
   $resource_id = db_query($sql, $db_profile_section_get_name);

   if (!db_num_rows($resource_id)) {
     $sectionname = "The Unknown Section";
   } else {
     $data = db_fetch_array($resource_id);
     $sectionname = $data['NAME'];
   }

   return $sectionname;
}

function profile_section_create($name, $position)
{
    $db_profile_section_create = db_connect();

    if (!is_numeric($position)) $position = 0;

    $name = addslashes($name);
    
    $webtag = get_webtag();

    $sql = "INSERT INTO {$webtag['PREFIX']}PROFILE_SECTION (NAME, POSITION) ";
    $sql.= "VALUES ('$name', '$position')";

    $result = db_query($sql, $db_profile_section_create);

    if ($result) {
       $new_psid = db_insert_id($db_profile_section_create);
    }else {
       $new_psid = 0;
    }

    return $new_psid;
}

function profile_section_update($psid, $position, $name)
{
    $db_profile_section_update = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($position)) $position = 0;

    $name = addslashes($name);
    
    $webtag = get_webtag();

    $sql = "UPDATE {$webtag['PREFIX']}PROFILE_SECTION ";
    $sql.= "SET NAME = '$name', POSITION = '$position' ";
    $sql.= "WHERE PSID = '$psid'";

    $result = db_query($sql, $db_profile_section_update);

    return $result;
}

function profile_sections_get()
{
    $db_profile_section_get = db_connect();
    
    $webtag = get_webtag();

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME ";
    $sql.= "FROM {$webtag['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID";

    $result = db_query($sql, $db_profile_section_get);

    if (db_num_rows($result)) {
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
    
    $webtag = get_webtag();

    $sql = "SELECT PROFILE_ITEM.PIID, PROFILE_ITEM.NAME, PROFILE_ITEM.TYPE ";
    $sql.= "FROM {$webtag['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "WHERE PROFILE_ITEM.PSID = $psid ";
    $sql.= "ORDER BY PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    $result = db_query($sql, $db_profile_items_get);

    if (db_num_rows($result)) {
        $profile_items_get = array();
        while($row = db_fetch_array($result)) {
            $profile_items_get[] = $row;
        }
        return $profile_items_get;
    }else {
        return false;
    }
}

function profile_item_create($psid, $name, $position, $type)
{
    $db_profile_item_create = db_connect();

    if (!is_numeric($psid)) return false;
    if (!is_numeric($position)) $position = 0;
    if (!is_numeric($type)) $type = 0;

    $name = addslashes($name);
    
    $webtag = get_webtag();

    $sql = "insert into {$webtag['PREFIX']}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) ";
    $sql.= "values ($psid, '$name', $type, $position)";

    $result = db_query($sql, $db_profile_item_create);

    if ($result) {
       $new_piid = db_insert_id($db_profile_item_create);
    }else {
       $new_piid = 0;
    }

    return $new_piid;

}

function profile_item_update($piid, $psid, $position, $type, $name)
{
    $db_profile_item_update = db_connect();

    if (!is_numeric($piid)) return false;
    if (!is_numeric($psid)) return false;
    if (!is_numeric($position)) $position = 0;
    if (!is_numeric($type)) $type = 0;

    $name = addslashes($name);
    
    $webtag = get_webtag();

    $sql = "UPDATE {$webtag['PREFIX']}PROFILE_ITEM ";
    $sql.= "SET PSID = $psid, POSITION = $position, ";
    $sql.= "TYPE = $type, NAME = '$name' WHERE PIID = $piid";

    $result = db_query($sql, $db_profile_item_update);

    return $result;
}

function profile_section_delete($psid)
{
    $db_profile_section_delete = db_connect();

    if (!is_numeric($psid)) return false;
    
    $webtag = get_webtag();

    $sql = "DELETE FROM {$webtag['PREFIX']}PROFILE_SECTION WHERE PSID = '$psid'";
    return db_query($sql, $db_profile_section_delete);
}

function profile_item_delete($piid)
{
    $db_profile_item_delete = db_connect();

    if (!is_numeric($piid)) return false;
    
    $webtag = get_webtag();

    $sql = "DELETE FROM {$webtag['PREFIX']}PROFILE_ITEM WHERE PIID = '$piid'";
    return db_query($sql, $db_profile_item_delete);
}

function profile_section_dropdown($default_psid, $field_name="t_psid", $suffix="")
{
    $html = "<select name=\"${field_name}${suffix}\">";
    $db_profile_section_dropdown = db_connect();
    
    $webtag = get_webtag();

    $sql = "select PSID, NAME from {$webtag['PREFIX']}PROFILE_SECTION";
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

function profile_get_user_values($uid)
{
    $db_profile_get_user_values = db_connect();

    if (!is_numeric($uid)) return false;
    
    $webtag = get_webtag();

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME, PROFILE_ITEM.TYPE, ";
    $sql.= "USER_PROFILE.PIID AS CHECK_PIID, USER_PROFILE.ENTRY ";
    $sql.= "FROM {$webtag['PREFIX']}PROFILE_SECTION PROFILE_SECTION, ";
    $sql.= "{$webtag['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}USER_PROFILE USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid') ";
    $sql.= "WHERE PROFILE_ITEM.PSID = PROFILE_SECTION.PSID ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID, ";
    $sql.= "PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    $result = db_query($sql, $db_profile_get_user_values);

    if (db_num_rows($result)) {
        $profile_values_array = array();
        while($row = db_fetch_array($result)) {
	  $profile_values_array[] = $row;
	}
	return $profile_values_array;
    }else {
        return false;
    }
}

?>