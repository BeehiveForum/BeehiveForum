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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Alter user's interest in a thread
// DOES NOT DISPLAY ANYTHING

require_once("./include/html.inc.php");
require_once("./include/user_rel.inc.php");
require_once("./include/constants.inc.php");

if($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
        html_guest_error();
        exit;
}

require_once("./include/db.inc.php");
require_once("./include/header.inc.php");
require_once("./include/forum.inc.php");

if(isset($HTTP_GET_VARS['uid']) && isset($HTTP_GET_VARS['rel'])) {

    $uid = $HTTP_GET_VARS['uid'];
    $rel = $HTTP_GET_VARS['rel'];
    $myuid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db = db_connect();

        $sql = "select RELATIONSHIP from ". forum_table("USER_PEER"). " where UID = '" . $myuid . "' and PEER_UID = '" . $uid . "'";
        $result = db_query($sql,$db);
        $rel2 = 0;
        if(db_num_rows($result)>0){
                $rel2 = db_fetch_array($result);
                $rel2 = $rel2['RELATIONSHIP'];
        }

        if ($rel == -1) {
                $rel2 = ($rel2 & USER_IGNORED_SIG) ? USER_IGNORED_SIG + USER_IGNORED : USER_IGNORED;
        } else {
                $rel2 = ($rel2 & USER_IGNORED_SIG) ? USER_IGNORED_SIG : 0;
        }

        user_rel_update($myuid, $uid, $rel2);

}

if(isset($HTTP_GET_VARS['ret'])){

    header_redirect($HTTP_GET_VARS['ret']);

}else{

    header_redirect("./user_profile.php?uid=$uid");

}

?>