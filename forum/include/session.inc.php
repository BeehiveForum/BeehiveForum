<?php

define("BH_SESS_HASH","change this string if you like");

function bh_session_check()
{

    global $HTTP_COOKIE_VARS;

    if(!isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
        return false;
    }

    $check = $HTTP_COOKIE_VARS['bh_sess_uid'];
    $check .= " " . $HTTP_COOKIE_VARS['bh_sess_ustatus'];
    $check .= " " . $HTTP_COOKIE_VARS['bh_sess_ppp'];
    $check .= " " . BH_SESS_HASH;

    if(md5($check) != $HTTP_COOKIE_VARS['bh_sess_check']){
        return false;
    }

    return true;

}

function bh_session_init($uid)
{
    $sql = "select USER.STATUS, USER_PREFS.POSTS_PER_PAGE ";
    $sql .= "from USER left join USER_PREFS on (USER.UID = USER_PREFS.UID) ";
    $sql .= "where USER.UID = $uid";

    $db = db_connect();
    $result = db_query($sql,$db);

    if(!db_num_rows($result)){
        $user_status = 0;
        $user_ppp = 20;
    } else {
        $fa = db_fetch_array($result);
        if($fa['STATUS']){
            $user_status = $fa['STATUS'];
        } else {
            $user_status = 0;
        }
        if($fa['POSTS_PER_PAGE']){
            $user_ppp = $fa['POSTS_PER_PAGE'];
        } else {
            $user_ppp = 20;
        }
    }

    db_disconnect($db);

    $check = $uid;
    $check .= " " . $user_status;
    $check .= " " . $user_ppp;
    $check .= " " . BH_SESS_HASH;
    
    setcookie("bh_sess_uid",$uid);
    setcookie("bh_sess_ustatus",$user_status);
    setcookie("bh_sess_ppp",$user_ppp);
    setcookie("bh_sess_check",md5($check));
}

?>
