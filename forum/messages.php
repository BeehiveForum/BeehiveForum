<?php

/*======================================================================
Copyright Chris Hodcroft <chris@hodcroft.net>, 
Ben Sekulowicz <me@beseku.com> 2002

This file is part of Beehive.

Beehive is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
USA
======================================================================*/

// THREAD LIST DISPLAY

// NOTE: The way this works at the moment, it's insecure. Anyone could see
// anyone else's unread messages etc. by changing the UID in the query string.

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/threads.inc.php"); // Thread processing functions
require_once("./include/messages.inc.php"); // Message processing functions

// Check that required variables are set
// default to display all discussions if no other mode specified
if (!isset($HTTP_GET_VARS['msg'])) {
   $msg = '1.1';
   $tid = 1;
   $pid = 1;
} else {
   $msg = $HTTP_GET_VARS['msg'];
   $tidpid = explode('.',$msg);
   $tid = $tidpid[0];
   $pid = $tidpid[1];
}

// Output XHTML header
html_draw_top();

$messages = messages_get($tid,$pid,20);
$threaddata = thread_get($tid);
if(!$threaddata){
    echo "<h1>Fuck up</h1>";
} else {
    foreach ($threaddata as $var => $value) {
        echo "<p>$var : $value</p>";
    }
}


messages_top($threaddata['TITLE']);

foreach($messages as $message) {
    message_display($tid,$message);
}

messages_nav_strip($tid,$pid,$threaddata['LENGTH']);
messages_bottom();
html_draw_bottom();

?>
