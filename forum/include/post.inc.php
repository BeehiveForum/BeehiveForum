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

/* $Id: post.inc.php,v 1.42 2003-08-20 02:20:45 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");

function post_create($tid, $reply_pid, $fuid, $tuid, $content)
{
    $db_post_create = db_connect();
    $content = _addslashes($content);

    $sql = "insert into " . forum_table("POST");
    $sql.= " (TID,REPLY_TO_PID,FROM_UID,TO_UID,CREATED) ";
    $sql.= "values ($tid,$reply_pid,$fuid,$tuid,NOW())";

    $result = db_query($sql,$db_post_create);

    if ($result) {

        $new_pid = db_insert_id($db_post_create);

        $sql = "insert into  " . forum_table("POST_CONTENT");
        $sql.= " (TID,PID,CONTENT) ";
        $sql.= "values ($tid, $new_pid, '$content')";

        $result = db_query($sql, $db_post_create);

        if ($result) {

            $sql = "update " . forum_table("THREAD") . " set length = $new_pid, modified = NOW() ";
            $sql.= "where tid = $tid";
            $result = db_query($sql, $db_post_create);

        }else {

            // Not sure about removing the post.

            //$sql = "delete " . forum_table("POST") . " where tid = $tid and pid = $new_pid";
            //$result = db_query($sql, $db_post_create);

            $new_pid = -1;

        }

    }else {
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

function post_create_thread($fid, $title, $poll = 'N', $sticky = 'N', $closed = false)
{
    $title = _addslashes(_htmlentities($title));
    $closed = $closed ? "NOW()" : "NULL";

    $db_post_create_thread = db_connect();

    $sql = "insert into " . forum_table("THREAD");
    $sql .= " (FID,TITLE,LENGTH,POLL_FLAG,STICKY,MODIFIED,CLOSED) ";
    $sql .= "values ($fid, '$title', 0, '$poll', '$sticky', NOW(), $closed)";

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
    $html = _stripslashes($text);
    $html = _htmlentities($html);
    $html = format_url2link($html);
    $html = nl2br($html);

    return $html;
}

function post_draw_to_dropdown($default_uid, $show_all = true)
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

    if ($show_all) {
        $html .= "<option value=\"0\">ALL</option>\n";
    }

    $sql = "SELECT U.UID, U.LOGON, U.NICKNAME, UNIX_TIMESTAMP(U.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM ".forum_table("USER")." U where (U.LOGON <> 'GUEST' AND U.PASSWD <> MD5('GUEST')) ";
    $sql.= "ORDER by U.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    $result = db_query($sql, $db_post_draw_to_dropdown);

    while ($row = db_fetch_array($result)) {

        if (isset($row['LOGON'])) {
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
    }

    $html .= "</select>";
    return $html;
}

function get_user_posts($uid)
{
    $db_get_user_posts = db_connect();

    $sql = "SELECT TID, PID FROM ". forum_table("POST"). " WHERE FROM_UID = '$uid'";
    $result = db_query($sql, $db_get_user_posts);

    if (db_num_rows($result)) {
        $user_post_array = array();
	while ($row = db_fetch_array($result)) {
	    $user_post_array[] = $row;
	}
	return $user_post_array;
    }else {
        return false;
    }
}

function check_ddkey($ddkey)
{
    $db_check_ddkey = db_connect();
    $uid = bh_session_get_value('UID');

    $sql = "SELECT DDKEY FROM ". forum_table("DEDUPE"). " WHERE UID = $uid";
    $result = db_query($sql, $db_check_ddkey);

    if (db_num_rows($result)) {

        list($ddkey_check) = db_fetch_array($result);
        $sql = "UPDATE ". forum_table("DEDUPE"). " SET DDKEY = '$ddkey' WHERE UID = $uid";
        $result = db_query($sql, $db_check_ddkey);

    }else{

        $ddkey_check = "";

        $sql = "INSERT INTO ". forum_table("DEDUPE"). " (UID, DDKEY) ";
        $sql.= "VALUES ($uid, '$ddkey')";
        $result = db_query($sql, $db_check_ddkey);
    }

    return !($ddkey == $ddkey_check);
}

?>