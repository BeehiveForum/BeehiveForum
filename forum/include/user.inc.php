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


