<?php

require_once("./include/db.inc.php");

function user_exists($logon)
{
    $db = db_connect();

    $sql = "SELECT uid FROM USER WHERE logon = \"$logon\"";

    $result = db_query($sql,$db);

    $exists = (db_num_rows($result)>0);

    db_disconnect($db);

    return $exists;
}

function user_create($logon,$password,$nickname,$email)
{
    $md5pass = md5($password);

    $sql = "INSERT INTO USER (logon,passwd,nickname,email) ";
    $sql .= "VALUES (\"$logon\",\"$md5pass\",\"$nickname\",\"$email\")";

    $db = db_connect();
    $result = db_query($sql,$db);
    if($result){
        $new_uid = db_insert_id($db);
    } else {
        $new_uid = -1;
    }
    db_disconnect($db);

    return $new_uid;
}

function user_update($uid,$password,$nickname,$email)
{
    if($password){
        $bit = "PASSWORD = \"" . md5($password) . "\", ";
    }
    
    $sql = "update USER set " . $bit . "NICKNAME = \"$nickname\", EMAIL = \"$email\"";
    $sql .= " WHERE UID = $uid";

    $db = db_connect();
    $result = db_query($sql,$db);

    db_disconnect($db);

    return $result;
}

function user_logon($logon,$password)
{
    $md5pass = md5($password);

    $sql = "SELECT uid FROM USER ";
    $sql .= "WHERE logon = \"$logon\" ";
    $sql .= "AND passwd = \"$md5pass\"";

    $db = db_connect();
    $result = db_query($sql,$db);

    if(!db_num_rows($result)){
        $uid = -1;
    } else {
        $fa = db_fetch_array($result);
        $uid = $fa['uid'];
    }

    db_disconnect($db);

    return $uid;
}

function user_get($uid)
{
    $db = db_connect();

    $sql = "select * from USER where uid = $uid";

    $result = db_query($sql,$db);

    if(!db_num_rows($result)){
        $fa = array();
    } else {
        $fa = db_fetch_array($result);
    }

    db_disconnect($db);

    return $fa;
}

function user_get_sig($uid,&$content,&$html)
{
    $db = db_connect();

    $sql = "select content, html from USER_SIG where uid = $uid";

    $result = db_query($sql,$db);

    if(!db_num_rows($result)){
        $ret = false;
    } else {
        $fa = db_fetch_array($result);
        $content = stripslashes($fa['content']);
        $html = $fa['html'];
        $ret = true;
    }

    db_disconnect($db);

    return $ret;
}

function user_get_prefs($uid)
{
    $db = db_connect();

    $sql = "select * from USER_PREFS where uid = $uid";

    $result = db_query($sql,$db);

    if(!db_num_rows($result)){
        $fa = array();
    } else {
        $fa = db_fetch_array($result);
    }

    db_disconnect($db);

    return $fa;
}

function user_insert_prefs($uid,$firstname,$lastname,$homepage_url,$pic_url,
                        $email_notify,$timezone,$dl_saving,$mark_as_of_int,$posts_per_page)
{

    $db = db_connect();

    $sql = "insert into USER_PREFS (UID, FIRSTNAME, LASTNAME, HOMEPAGE_URL,";
    $sql .= " PIC_URL, EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE)";
    $sql .= " values ($uid, \"$firstname\", \"$lastname\", \"$homepage_url\", \"$pic_url\",";
    $sql .= " \"$email_notify\", $timezone, \"$dl_saving\", \"$mark_as_of_int\", $posts_per_page)";

    $result = db_query($sql,$db);

    db_disconnect($db);

    return $result;
}

function user_update_prefs($uid,$firstname,$lastname,$homepage_url,$pic_url,
                        $email_notify,$timezone,$dl_saving,$mark_as_of_int,$posts_per_page)
{

    $db = db_connect();

    $sql = "update USER_PREFS set";
    $sql .= " FIRSTNAME = \"$firstname\", LASTNAME = \"$lastname\",";
    $sql .= " HOMEPAGE_URL = \"$homepage_url\", PIC_URL = \"$pic_url\",";
    $sql .= " EMAIL_NOTIFY = \"$email_notify\", TIMEZONE = $timezone, DL_SAVING = \"$dl_saving\",";
    $sql .= " MARK_AS_OF_INT = \"$mark_as_of_int\", POSTS_PER_PAGE = $posts_per_page";
    $sql .= " where UID = $uid";

    $result = db_query($sql,$db);

    db_disconnect($db);

    return $result;
}

function user_insert_sig($uid,$content,$html){

    $content = mysql_escape_string($content);
    $db = db_connect();

    $sql = "insert into USER_SIG (UID, CONTENT, HTML)";
    $sql .= " values ($uid, \"$content\", \"$html\")";

    $result = db_query($sql,$db);

    db_disconnect($db);

    return $result;
}

function user_update_sig($uid,$content,$html){

    $content = mysql_escape_string($content);
    $db = db_connect();

    $sql = "update USER_SIG set";
    $sql .= " CONTENT = \"$content\", HTML = \"$html\"";
    $sql .= " where UID = $uid";

    $result = db_query($sql,$db);

    db_disconnect($db);

    return $result;
}

?>
