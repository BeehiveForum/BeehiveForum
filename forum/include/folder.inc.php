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

function folder_draw_dropdown($default_fid)
{
    $html = "<select name=\"t_fid\">";
    $db = db_connect();

    if($default_fid){
        $sql = "select fid, title FROM FOLDER where fid = $default_fid";

       $result = db_query($sql,$db);

       if($row = db_fetch_array($result)){
            $html .= "<option value=\"" . $row['fid'] . "\">" . $row['title'] . "</option>";
        }
    }

    $sql = "select fid, title FROM FOLDER";

    $result = db_query($sql,$db);

    $i = 0;
    while($row = db_fetch_array($result)){
        if($row['fid'] != $default_fid){
            $html .= "<option value=\"" . $row['fid'] . "\">" . $row['title'] . "</option>";
        }
    }

    db_disconnect($db);

    $html .= "</select>";
    return $html;
}

function folder_get_title($fid)
{
   $db = db_connect();
   $sql = "SELECT FOLDER.TITLE FROM FOLDER WHERE fid = $fid";
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

?>
