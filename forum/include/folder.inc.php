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

function folder_draw_dropdown($default_fid,$field_name="t_fid",$suffix="")
{
    $html = "<select name=\"${field_name}${suffix}\">";
    $db = db_connect();

    $sql = "select FID, TITLE from " . forum_table("FOLDER");

    $result = db_query($sql,$db);

    $i = 0;
    while($row = db_fetch_array($result)){
        $html .= "<option value=\"" . $row['FID'] . "\"";
        if($row['FID'] == $default_fid){
            $html .= " selected";
        }
        $html .= ">" . $row['TITLE'] . "</option>";
    }

    db_disconnect($db);

    $html .= "</select>";
    return $html;
}

function folder_get_title($fid)
{
   $db = db_connect();
   $sql = "select FOLDER.TITLE from " . forum_table("FOLDER") . " where FID = $fid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $foldertitle = "The Unknown Folder";
   } else {
     $data = db_fetch_array($resource_id);
     $foldertitle = $data['TITLE'];
   }
   db_disconnect($db);
   return $foldertitle;
}

function folder_create($title,$access)
{
    $db = db_connect();
    $sql = "insert into " . forum_table("FOLDER") . " (TITLE, ACCESS_LEVEL) ";
    $sql.= "values (\"$title\",$access)";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function folder_update($fid,$title,$access)
{
    $db = db_connect();
    $sql = "update " . forum_table("FOLDER") . " ";
    $sql.= "set TITLE = \"$title\", ";
    $sql.= "ACCESS_LEVEL = $access ";
    $sql.= "where FID = $fid";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

function folder_move_threads($from,$to)
{
    $db = db_connect();
    $sql = "update " . forum_table("THREAD") . " ";
    $sql.= "set FID = $to ";
    $sql.= "where FID = $from";
    $result = db_query($sql,$db);
    db_disconnect($db);
    return $result;
}

?>