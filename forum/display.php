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

/* $Id: display.php,v 1.32 2004-03-14 18:33:41 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/beehive.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    $msg = "1.1";
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

$message = messages_get($tid, $pid, 1);
$threaddata = thread_get($tid);

$foldertitle = folder_get_title($threaddata['FID']);

echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td>\n";
messages_top($foldertitle,_stripslashes($threaddata['TITLE']));
echo "</td></tr></table></div>\n";

if ($message) {

    $first_msg = $message['PID'];
    $message['CONTENT'] = message_get_content($tid, $message['PID']);

    if ($threaddata['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], false, true, $show_sigs, true);
            $last_pid = $message['PID'];

        }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], false, false, $show_sigs, true);
            $last_pid = $message['PID'];

        }

    }else {

        message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], false, false, $show_sigs, true);
        $last_pid = $message['PID'];

    }
}

messages_end_panel();
echo "<table width=\"96%\" border=\"0\"><tr><td align=\"center\">\n";
echo "<form name=\"display\" method=\"get\" action=\"messages.php?webtag={$webtag['WEBTAG']}\" target=\"_self\">\n";
echo form_input_hidden("msg", "$tid.$pid");
echo form_submit("submit", $lang['back']);
echo "&nbsp;";
echo form_button("print", $lang['print'], "onclick=\"window.print()\"");
echo "</form>\n";
echo "</td></tr></table>\n";

html_draw_bottom();

?>