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

// Alter user's interest in a thread
// DOES NOT DISPLAY ANYTHING

require_once("./include/db.inc.php");
require_once("./include/header.inc.php");

if(isset($HTTP_GET_VARS['uid']) && isset($HTTP_GET_VARS['rel'])){
    $uid = $HTTP_GET_VARS['uid'];
    $rel = $HTTP_GET_VARS['rel'];
    $exists = $HTTP_GET_VARS['exists'];
    $myuid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db = db_connect();

    if(!$exists){
        $sql = "insert into USER_PEER(UID,PEER_UID,RELATIONSHIP) ";
        $sql.= "values ($myuid,$uid,$rel)";
    } else {
        $sql = "update USER_PEER set RELATIONSHIP = $rel where UID = $myuid and PEER_UID = $uid";
    }

    db_query($sql,$db);

    db_disconnect($db);
}

if(isset($HTTP_GET_VARS['ret'])){

    header_redirect("http://".$HTTP_SERVER_VARS['HTTP_HOST'].$ret);
    
}else{

    header_redirect("http://".$HTTP_SERVER_VARS['HTTP_HOST'].dirname($HTTP_SERVER_VARS['PHP_SELF'])."/user_profile.php?uid=$uid");
    
}

?>