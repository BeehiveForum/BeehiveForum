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

/* $Id: display.php,v 1.18 2003-09-03 18:00:17 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

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
require_once("./include/session.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/poll.inc.php");

if (!bh_session_check()) {

    if (isset($HTTP_GET_VARS['msg'])) {
      $uri = "./index.php?msg=". $HTTP_GET_VARS['msg'];
    }else {
      $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    }

    header_redirect($uri);

}

// Check that required variables are set
if(!isset($HTTP_GET_VARS['msg'])){
        $msg = "1.1";
} else {
        $msg = $HTTP_GET_VARS['msg'];
}

list($tid, $pid) = explode('.', $msg);
if (!is_numeric($pid)) $pid = 1;
if (!is_numeric($tid)) $tid = 1;

if (!thread_can_view($tid, bh_session_get_value('UID'))) {
    html_draw_top();
    echo "<h2>You are not authorised to view this thread!</h2>\n";
    html_draw_bottom();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

// Output XHTML header
html_draw_top("basetarget=_blank", "openprofile.js");

$message = messages_get($tid,$pid,1);
$threaddata = thread_get($tid);

$closed = isset($threaddata['CLOSED']);
$foldertitle = folder_get_title($threaddata['FID']);

if($closed) $foldertitle .= " (closed)";

echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td>\n";
messages_top($foldertitle,_stripslashes($threaddata['TITLE']));
echo "</td></tr></table></div>\n";

if ($message) {

    $first_msg = $message['PID'];

    if($threaddata['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $closed, false, true, $show_sigs, true);
            $last_pid = $message['PID'];

        }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, false, false, $show_sigs, true);
            $last_pid = $message['PID'];

        }

    }else {

        message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, false, false, $show_sigs, true);
        $last_pid = $message['PID'];

    }
}

messages_end_panel();
echo "<table width=\"96%\" border=\"0\"><tr><td align=\"center\">\n";
echo "<form name=\"display\" method=\"get\" action=\"./messages.php\" target=\"_self\">\n";
echo form_input_hidden("msg", "$tid.$pid");
echo form_submit("submit", $lang['back']);
echo "&nbsp;";
echo form_button("print", $lang['print'], "onclick=\"window.print()\"");
echo "</form>\n";
echo "</td></tr></table>\n";

html_draw_bottom();

?>
