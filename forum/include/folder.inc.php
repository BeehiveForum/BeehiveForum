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

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/form.inc.php");
require_once("./include/constants.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="")
{
    global $HTTP_COOKIE_VARS;

    $ustatus = $HTTP_COOKIE_VARS['bh_sess_ustatus'];
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & PERM_CHECK_WORKER){
        $sql = "select FID, TITLE from ".forum_table("FOLDER");
    } else {
        $sql = "select DISTINCT F.FID, F.TITLE from ".forum_table("FOLDER")." F left join ";
        $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = '$uid') ";
        $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";
    }

    return form_dropdown_sql($field_name.$suffix, $sql, $default_fid);
}

function folder_get_title($fid)
{
   $db_folder_get_title = db_connect();
   $sql = "select FOLDER.TITLE from " . forum_table("FOLDER") . " FOLDER where FID = $fid";
   $resource_id = db_query($sql,$db_folder_get_title);
   if(!db_num_rows($resource_id)){
     $foldertitle = "The Unknown Folder";
   } else {
     $data = db_fetch_array($resource_id);
     $foldertitle = $data['TITLE'];
   }
   return $foldertitle;
}

function folder_create($title,$access)
{
    $db_folder_create = db_connect();
    $sql = "insert into " . forum_table("FOLDER") . " (TITLE, ACCESS_LEVEL) ";
    $sql.= "values (\"$title\",$access)";
    $result = db_query($sql, $db_folder_create);
    return $result;
}

function folder_update($fid,$title,$access)
{
    $db_folder_update = db_connect();
    $sql = "update low_priority " . forum_table("FOLDER") . " ";
    $sql.= "set TITLE = \"$title\", ";
    $sql.= "ACCESS_LEVEL = $access ";
    $sql.= "where FID = $fid";
    $result = db_query($sql, $db_folder_update);
    return $result;
}

function folder_move_threads($from,$to)
{
    $db_folder_move_threads = db_connect();
    $sql = "update " . forum_table("THREAD") . " ";
    $sql.= "set FID = $to ";
    $sql.= "where FID = $from";
    $result = db_query($sql, $db_folder_move_threads);
    return $result;
}

function folder_get_available()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    $db_folder_get_available = db_connect();

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql, $db_folder_get_available);
    $count = db_num_rows($result);

    if($count==0){
        $return = "0";
    } else {
        $row = db_fetch_array($result);
        $return = $row['FID'];

        while($row = db_fetch_array($result)){
            $return .= ",".$row['FID'];
        }
    }

    return $return;
}

function folder_get_all()
{

    $return = array();

    $db_folder_get_all = db_connect();

    $sql = "select FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, count(*) as THREAD_COUNT ";
    $sql.= "from " . forum_table("FOLDER") . " FOLDER LEFT JOIN " . forum_table("THREAD") . " THREAD ";
    $sql.= " on (THREAD.FID = FOLDER.FID) ";
    $sql.= "group by FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL";

    $result = db_query($sql, $db_folder_get_all);

    while ($row = db_fetch_array($result)) {
      $return[] = $row;
    }

    return $return;

}

function user_set_folder_interest($fid, $interest)
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db_user_set_folder_interest = db_connect();

    $sql = "delete from ". forum_table("USER_FOLDER"). " where UID = '$uid' and FID = '$fid'";
    $result = db_query($sql, $db_user_set_folder_interest);

    if ($interest == -1) {
        $sql = "insert into ". forum_table("USER_FOLDER"). " (UID, FID, INTEREST) ";
        $sql.= "values ($uid, $fid, $interest)";
        $result = db_query($sql, $db_user_set_folder_interest);
    }

}

?>