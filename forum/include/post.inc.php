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

require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");

function post_create($tid, $reply_pid, $fuid, $tuid, $content)
{

    $db_post_create = db_connect();
    $content = addslashes($content);
    
    $sql = "insert into " . forum_table("POST");
    $sql .= " (TID,REPLY_TO_PID,FROM_UID,TO_UID,CREATED) ";
    $sql .= "values ($tid,$reply_pid,$fuid,$tuid,NOW())";

    $result = db_query($sql,$db_post_create);

    if($result) {
    
        $new_pid = db_insert_id($db_post_create);
        $sql = "insert into  " . forum_table("POST_CONTENT");
        $sql .= " (TID,PID,CONTENT) ";
        $sql .= "values ($tid, $new_pid, '$content')";
        $result = db_query($sql, $db_post_create);
        
        $sql = "update low_priority " . forum_table("THREAD") . " set length = length + 1, modified = NOW() ";
        $sql .= "where tid = $tid";
        $result = db_query($sql, $db_post_create);
        
    } else {
        $new_pid = -1;
    }

    return $new_pid;
}

function post_save_attachment_id($tid, $pid, $aid)
{

    $db_post_save_attachment_id = db_connect();
    $sql = "insert into ". forum_table("POST_ATTACHMENT_IDS"). " (TID, PID, AID) values ($tid, $pid, '$aid')";
    
    $result = db_query($sql, $db_post_save_attachment_id);
    return $result;
}

function post_create_thread($fid, $title, $poll = 'N')
{
    $title = mysql_escape_string(htmlentities($title));

    $db_post_create_thread = db_connect();

    $sql = "insert into " . forum_table("THREAD");
    $sql .= " (FID,TITLE,LENGTH,POLL_FLAG,MODIFIED) ";
    $sql .= "values ($fid, '$title', 0, '$poll', NOW())";

    $result = db_query($sql, $db_post_create_thread);

    if($result){
        $new_tid = db_insert_id($db_post_create_thread);
    } else {
        $new_tid = -1;
    }

    return $new_tid;
}

function make_html($text)
{
    $html = stripslashes($text);
    $html = htmlentities($html, ENT_NOQUOTES);
    $html = format_url2link($html);
    $html = nl2br($html);

    return $html;
}

function post_draw_to_dropdown($default_uid)
{
    $html = "<select name=\"t_to_uid\">\n";
    $db_post_draw_to_dropdown = db_connect();

	if(isset($default_uid) && $default_uid != 0){
	    $top_sql = "select LOGON, NICKNAME from ". forum_table("USER"). " where UID = '" . $default_uid . "'";
		$result = db_query($top_sql,$db_post_draw_to_dropdown);
		if(db_num_rows($result)>0){
			$top_user = db_fetch_array($result);
			$fmt_username = format_user_name($top_user['LOGON'],$top_user['NICKNAME']);
			$html .= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>\n";
		}
	}

    $html .= "<option value=\"0\">ALL</option>\n";

    $sql = "select U.UID, U.LOGON, U.NICKNAME, UNIX_TIMESTAMP(U.LAST_LOGON) as LAST_LOGON ";
    $sql.= "from ".forum_table("USER")." U where U.UID > 0 ";
    $sql.= "order by U.LAST_LOGON desc ";
    $sql.= "limit 0, 20";

    $result = db_query($sql, $db_post_draw_to_dropdown);

    while($row = db_fetch_array($result)){
        if(isset($row['LOGON'])){
           $logon = $row['LOGON'];
        } else {
         $logon = "";
        }
        if(isset($row['NICKNAME'])){
            $nickname = $row['NICKNAME'];
        } else {
            $nickname = "";
        }

        $fmt_uid = $row['UID'];
        $fmt_username = format_user_name($logon,$nickname);

        if($fmt_uid != $default_uid && $fmt_uid != 0){
            $html .= "<option value=\"$fmt_uid\">$fmt_username</option>\n";
        }
        //$html .= ">$fmt_username</option>";
    }

    $html .= "</select>";
    return $html;
}

/* function is_valid_html($html)
{
    $html_parts = split('<[[:space:]]*|[[:space:]]*>', $html);

    $opentags = array();

    $valid = true;

    for($i=1; $i<count($html_parts); $i++){
        if($i%2){
            if(substr($html_parts[$i],0,1) == "/"){ // closing tag
                $tag = strtolower(substr($html_parts[$i],1));
                if(isset($opentags[$tag]) && $opentags[$tag] > 0){
                    $opentags[$tag]--;
                } else {
                    //echo "<p>Tag $tag closed without being opened</p>";
                    $valid = false;
                    break;
                }
            } else {
                if(substr($html_parts[$i],-1) != "/"){ // check for XHTML single tag
                    $bits = explode(" ", $html_parts[$i]);
                    $tag = strtolower($bits[0]);
                    if(!isset($opentags[$tag])){
                        $opentags[$tag] = 1;
                    } else {
                        $opentags[$tag]++;
                    }
                }
            }
        }
    }

    if($valid){
        $single_tags = array("br","img","hr","p");
        foreach($opentags as $tag => $n){
            if(!in_array($tag, $single_tags) && $n > 0){
                $valid = false;
            }
        }
    }
    return $valid;
} */

?>