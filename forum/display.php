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

// Compress the output
require_once("./include/gzipenc.inc.php");

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/thread.inc.php"); // Thread processing functions
require_once("./include/messages.inc.php"); // Message processing functions
require_once("./include/folder.inc.php"); // Folder processing functions
require_once("./include/beehive.inc.php"); // Beehive stuff
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");

// Check that required variables are set
if(!isset($HTTP_GET_VARS['msg'])){
	$msg = "1.1";
} else {
	$msg = $HTTP_GET_VARS['msg'];
}

list($tid, $pid) = explode('.', $msg);
if (!is_numeric($pid)) $pid = 1;
if (!is_numeric($tid)) $tid = 1;

// Output XHTML header
html_draw_top_script();

$message = messages_get($tid,$pid,1);
$threaddata = thread_get($tid);
$closed = isset($threaddata['CLOSED']);
$foldertitle = folder_get_title($threaddata['FID']);
if($closed) $foldertitle .= " (closed)";

echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td>\n";
messages_top($foldertitle,_stripslashes($threaddata['TITLE']));
echo "</td></tr></table></div>\n";

if($message){
	$first_msg = $message['PID'];
	$message['CONTENT'] = message_get_content($tid, $message['PID']);
	message_display($tid,$message,$threaddata['LENGTH'],$first_msg,true,$closed,false);
	$last_pid = $message['PID'];
}

echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td align=\"center\">\n";
echo form_quick_button("./messages.php", "Back", "msg", "$tid.$pid");
echo "</td></tr></table>\n";

messages_end_panel();

draw_beehive_bar();
html_draw_bottom();

?>
