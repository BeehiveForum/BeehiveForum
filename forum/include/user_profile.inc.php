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

function user_profile_create($uid,$piid,$entry)
{
    $db = db_connect();
    $entry = mysql_escape_string($entry);
    $sql = "insert into " . forum_table("USER_PROFILE") . " (UID,PIID,ENTRY) ";
    $sql.= "values ($uid,$piid,\"$entry\")";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function user_profile_update($uid,$piid,$entry)
{
    $db = db_connect();
    $entry = mysql_escape_string($entry);
    $sql = "update " . forum_table("PROFILE_ITEM") . " ";
    $sql.= "set ENTRY = \"$entry\" ";
    $sql.= "where UID = $uid ";
    $sql.= "and PIID = $piid";
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