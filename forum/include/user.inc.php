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
require_once("./include/forum.inc.php");

function user_exists($logon)
{
    $db_user_exists = db_connect();

    $sql = "SELECT uid FROM " . forum_table("USER") . " WHERE logon = \"$logon\"";

    $result = db_query($sql, $db_user_exists);

    $exists = (db_num_rows($result)>0);

    return $exists;
}

function user_create($logon,$password,$nickname,$email)
{
    $md5pass = md5($password);

    $sql = "INSERT INTO " . forum_table("USER") . " (logon,passwd,nickname,email) ";
    $sql .= "VALUES (\"$logon\",\"$md5pass\",\"$nickname\",\"$email\")";

    $db_user_create = db_connect();
    $result = db_query($sql, $db_user_create);
    if($result){
        $new_uid = db_insert_id($db_user_create);
    } else {
        $new_uid = -1;
    }
    return $new_uid;
}

function user_update($uid,$password,$nickname,$email)
{
    if($password){
        $bit = "PASSWD = \"" . md5($password) . "\", ";
    }

    $sql = "update " . forum_table("USER") . " set " . $bit . "NICKNAME = \"". htmlspecialchars($nickname). "\", EMAIL = \"". htmlspecialchars($email). "\"";
    $sql .= " WHERE UID = $uid";
    
    //echo $sql;

    $db_user_update = db_connect();
    $result = db_query($sql, $db_user_update);

    return $result;
}

function user_update_status($uid,$status)
{
    $sql = "update " . forum_table("USER") . " set STATUS = $status ";
    $sql .= "WHERE UID = $uid";

    //echo $sql;

    $db_user_update_status = db_connect();
    $result = db_query($sql, $db_user_update_status);

    return $result;
}

function user_logon($logon, $password)
{
    $md5pass = md5($password);

    $sql = "SELECT uid FROM ". forum_table("USER"). " WHERE logon = '$logon' AND passwd = '$md5pass'";

    $db_user_logon = db_connect();
    $result = db_query($sql, $db_user_logon);

    if(!db_num_rows($result)){
        $uid = -1;
    } else {
        $fa = db_fetch_array($result);
        $uid = $fa['uid'];
        db_query("update ".forum_table("USER")." set LAST_LOGON = NOW() where UID = $uid", $db_user_logon);
    }

    return $uid;
}

function user_get($uid)
{
    $db_user_get = db_connect();

    $sql = "select * from " . forum_table("USER") . " where uid = $uid";

    $result = db_query($sql, $db_user_get);

    if(!db_num_rows($result)){
        $fa = array();
    } else {
        $fa = db_fetch_array($result);
    }

    return $fa;
}

function user_get_logon($uid)
{
    $db_user_get_logon = db_connect();

    $sql = "select LOGON from " . forum_table("USER") . " where uid = $uid";

    $result = db_query($sql, $db_user_get_logon);

    if(!db_num_rows($result)){
        $logon = "UNKNOWN";
    } else {
        $fa = db_fetch_array($result);
        $logon = $fa['LOGON'];
    }

    return $logon;
}

function user_get_uid($logon)
{

    $db_user_get_uid = db_connect();
    
    $sql = "select UID from ". forum_table("USER"). " where LOGON = '$logon'";
    $result = db_query($sql, $db_user_get_uid);
    
    if (!db_num_rows($result)) {
        return -1;
    }else{
        $fa = db_fetch_array($result);
        return $fa['UID'];
    }
    
}

function user_get_sig($uid, &$content, &$html)
{
    $db_user_get_sig = db_connect();

    $sql = "select content, html from " . forum_table("USER_SIG") . " where uid = $uid";

    $result = db_query($sql, $db_user_get_sig);

    if(!db_num_rows($result)){
        $ret = false;
    } else {
        $fa = db_fetch_array($result);
        $content = stripslashes($fa['content']);
        $html = $fa['html'];
        $ret = true;
    }

    return $ret;
}

function user_get_prefs($uid)
{
    $db_user_get_prefs = db_connect();

    $sql = "select * from " . forum_table("USER_PREFS") . " where uid = $uid";

    $result = db_query($sql, $db_user_get_prefs);

    if(!db_num_rows($result)){
        $fa = array('UID' => '', 'FIRSTNAME' => '', 'LASTNAME' => '', 'HOMEPAGE_URL' => '',
                    'PIC_URL' => '', 'EMAIL_NOTIFY' => '', 'TIMEZONE' => '', 'DL_SAVING' => '',
                    'MARK_AS_OF_INT' => '', 'POST_PER_PAGE' => '', 'FONT_SIZE' => '');
    } else {
        $fa = db_fetch_array($result);
    }

    return $fa;
}

function user_update_prefs($uid,$firstname,$lastname,$homepage_url,$pic_url,
                           $email_notify,$timezone,$dl_saving,$mark_as_of_int,
                           $posts_per_page, $font_size)
{

    $db_user_update_prefs = db_connect();
    
    $sql = "delete from ". forum_table("USER_PREFS"). " where UID = $uid";
    $result = db_query($sql, $db_user_update_prefs);
    
    if (empty($timezone)) $timezone = 0;
    if (empty($posts_per_page)) $posts_per_page = 0;
    if (empty($font_size)) $font_size = 0;

    $sql = "insert into " . forum_table("USER_PREFS") . " (UID, FIRSTNAME, LASTNAME, HOMEPAGE_URL,";
    $sql .= " PIC_URL, EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE)";
    $sql .= " values ($uid, \"". htmlspecialchars($firstname). "\", \"". htmlspecialchars($lastname). "\",";
    $sql .= " \"". htmlspecialchars($homepage_url). "\", \"". htmlspecialchars($pic_url). "\",";
    $sql .= " \"". htmlspecialchars($email_notify). "\", $timezone, \"$dl_saving\", \"$mark_as_of_int\", $posts_per_page, $font_size)";

    $result = db_query($sql, $db_user_update_prefs);

    return $result;
}

function user_update_sig($uid,$content,$html){

    $content = mysql_escape_string($content);
    $db_user_update_sig = db_connect();
    
    $sql = "delete from ". forum_table("USER_SIG"). " where UID = $uid";
    $result = db_query($sql, $db_user_update_sig);

    $sql = "insert into " . forum_table("USER_SIG") . " (UID, CONTENT, HTML)";
    $sql .= " values ($uid, \"$content\", \"$html\")";

    $result = db_query($sql, $db_user_update_sig);

    return $result;
}

?>