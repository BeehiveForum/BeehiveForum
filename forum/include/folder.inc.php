<?php

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

?>
