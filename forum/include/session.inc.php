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

define("BH_SESS_HASH","change this string if you like");

function bh_session_check()
{

    global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;

    if(!isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
        return false;
    }

    $check = $HTTP_COOKIE_VARS['bh_sess_uid'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_ustatus'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_ppp'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_tz'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_dlsav'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_markread'];
    $check.= " " . @$HTTP_COOKIE_VARS['bh_sess_fontsize'];
    if(isset($HTTP_SERVER_VARS['SERVER_SIGNATURE'])){
        $check.= " " . $HTTP_SERVER_VARS['SERVER_SIGNATURE'];
    }
    $check.= " " . BH_SESS_HASH;

    if(md5($check) != @$HTTP_COOKIE_VARS['bh_sess_check']){
        return false;
    }

    return true;

}

function bh_session_init($uid)
{
    global $HTTP_SERVER_VARS;

    $sql = "select USER.STATUS, USER_PREFS.POSTS_PER_PAGE, USER_PREFS.TIMEZONE, USER_PREFS.DL_SAVING, USER_PREFS.MARK_AS_OF_INT, USER_PREFS.FONT_SIZE ";
    $sql.= "from " . forum_table("USER") . " USER ";
    $sql.= "left join " . forum_table("USER_PREFS") . " USER_PREFS on (USER.UID = USER_PREFS.UID) ";
    $sql.= "where USER.UID = $uid";

    $db_bh_session_init = db_connect();
    $result = db_query($sql, $db_bh_session_init);

    if(!db_num_rows($result)) {

        $user_status = 0;
        $user_ppp = 20;
        $user_tz = 0;
        $user_dlsav = 0;
        $user_markread = 0;

    } else {

        $fa = db_fetch_array($result);

        if(isset($fa['STATUS'])){
            $user_status = $fa['STATUS'];
        } else {
            $user_status = 0;
        }
        if(isset($fa['POSTS_PER_PAGE'])){
            $user_ppp = $fa['POSTS_PER_PAGE'];
        } else {
            $user_ppp = 20;
        }
        if (isset($fa['TIMEZONE'])){
            $user_tz = $fa['TIMEZONE'];
        } else {
            $user_tz = 0;
        }
        if (@$fa['DL_SAVING'] == "Y") {
            $user_dlsav = 1;
        } else {
            $user_dlsav = 0;
        }
        if (@$fa['MARK_AS_OF_INT'] == "Y") {
            $user_markread = 1;
        } else {
            $user_markread = 0;
        }
        if (isset($fa['FONT_SIZE'])) {
            $user_fontsize = $fa['FONT_SIZE'];
        } else {
            $user_fontsize = 10;
        }
    }

    $check = $uid;
    $check.= " " . $user_status;
    $check.= " " . $user_ppp;
    $check.= " " . $user_tz;
    $check.= " " . $user_dlsav;
    $check.= " " . $user_markread;
    $check.= " " . $user_fontsize;
    if(isset($HTTP_SERVER_VARS['SERVER_SIGNATURE'])){
        $check.= " " . $HTTP_SERVER_VARS['SERVER_SIGNATURE'];
    }
    $check.= " " . BH_SESS_HASH;

    setcookie("bh_sess_uid",$uid);
    setcookie("bh_sess_ustatus",$user_status);
    setcookie("bh_sess_ppp",$user_ppp);
    setcookie("bh_sess_tz", $user_tz);
    setcookie("bh_sess_dlsav", $user_dlsav);
    setcookie("bh_sess_markread", $user_markread);
    setcookie("bh_sess_fontsize", $user_fontsize);
    setcookie("bh_sess_check",md5($check));

}

function bh_session_end()
{
    setcookie("bh_sess_uid","",-3600);
    setcookie("bh_sess_ustatus","",-3600);
    setcookie("bh_sess_ppp","",-3600);
    setcookie("bh_sess_tz","",-3600);
    setcookie("bh_sess_dlsav","",-3600);
    setcookie("bh_sess_markread","",-3600);
    setcookie("bh_sess_fontsize","",-3600);
    setcookie("bh_sess_check","",-3600);
}

// IIS does not support the REQUEST_URI server var, so we will make one for it
function get_request_uri()
{
    global $HTTP_SERVER_VARS;

    if(isset($HTTP_SERVER_VARS['REQUEST_URI'])){
        $return = $HTTP_SERVER_VARS['REQUEST_URI'];
    } else {
        global $HTTP_GET_VARS;
        $return = $HTTP_SERVER_VARS['PHP_SELF']."?";
        foreach($HTTP_GET_VARS as $key => $value){
            $return .= "$key=".rawurlencode($value)."&";
        }
    }
    
    return substr($return,0,-1);
}

?>
