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

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/threads.inc.php"); // Thread processing functions
require_once("./include/messages.inc.php"); // Message processing functions
require_once("./include/folder.inc.php"); // Folder processing functions

// Check that required variables are set
// default to display most recent discussion for user
if (!isset($HTTP_GET_VARS['msg'])) {
    if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
        $msg = messages_get_most_recent($HTTP_COOKIE_VARS['bh_sess_uid']);
    } else {
        $msg = "1.1";
    }
} else {
    $msg = $HTTP_GET_VARS['msg'];
}

$tidpid = explode('.',$msg);
$tid = $tidpid[0];
$pid = $tidpid[1];

// Output XHTML header
html_draw_top_script();

if(isset($HTTP_COOKIE_VARS['bh_sess_ppp'])){
    $ppp = $HTTP_COOKIE_VARS['bh_sess_ppp'];
} else {
    $ppp = 20;
}

$messages = messages_get($tid,$pid,$ppp);
$threaddata = thread_get($tid);
$foldertitle = folder_get_title($threaddata['FID']);

$msg_count = count($messages);

messages_top($foldertitle,stripslashes($threaddata['TITLE']));

if($msg_count>0){
    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {
        message_display($tid,$message,$threaddata['LENGTH'],$first_msg);
        $last_pid = $message['PID'];
    }
}

messages_nav_strip($tid,$pid,$threaddata['LENGTH'],$ppp);
messages_bottom();
html_draw_bottom();

if($msg_count > 0 && isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
    messages_update_read($tid,$last_pid,$HTTP_COOKIE_VARS['bh_sess_uid']);
}

?>
