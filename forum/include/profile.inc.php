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

require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");

function profile_section_get_name($psid)
{
   $db = db_connect();
   $sql = "select PROFILE_SECTION.NAME from " . forum_table("PROFILE_SECTION") . " where PSID = $psid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $sectionname = "The Unknown Section";
   } else {
     $data = db_fetch_array($resource_id);
     $sectionname = $data['NAME'];
   }
   db_disconnect($db);
   return $sectionname;
}

function profile_section_create($name)
{
    $db = db_connect();
    $sql = "insert into " . forum_table("PROFILE_SECTION") . " (NAME) ";
    $sql.= "values (\"$name\")";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function profile_section_update($psid,$name)
{
    $db = db_connect();
    $sql = "update " . forum_table("PROFILE_SECTION") . " ";
    $sql.= "set NAME = \"$name\" ";
    $sql.= "where PSID = $psid";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function profile_item_create($psid,$name)
{
    $db = db_connect();
    $sql = "insert into " . forum_table("PROFILE_ITEM") . " (PSID,NAME) ";
    $sql.= "values ($psid,\"$name\")";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function profile_item_update($piid,$psid,$name)
{
    $db = db_connect();
    $sql = "update " . forum_table("PROFILE_ITEM") . " ";
    $sql.= "set PSID = $psid, ";
    $sql.= "NAME = \"$name\" ";
    $sql.= "where PIID = $piid";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function profile_section_dropdown($default_psid,$field_name="t_psid",$suffix="")
{
    $html = "<select name=\"${field_name}${suffix}\">";
    $db = db_connect();

    $sql = "select PSID, NAME from " . forum_table("PROFILE_SECTION");

    $result = db_query($sql,$db);

    $i = 0;
    while($row = db_fetch_array($result)){
        $html .= "<option value=\"" . $row['PSID'] . "\"";
        if($row['PSID'] == $default_psid){
            $html .= " selected";
        }
        $html .= ">" . $row['NAME'] . "</option>";
    }

    db_disconnect($db);

    $html .= "</select>";
    return $html;
}

?>