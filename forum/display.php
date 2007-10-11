<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: display.php,v 1.86 2007-10-11 13:01:13 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    list($tid, $pid) = explode('.', $_GET['msg']);
}elseif (isset($_GET['print_msg']) && validate_msg($_GET['print_msg'])) {
    list($tid, $pid) = explode('.', $_GET['print_msg']);
}else {
    $tid = 1; $pid = 1;
}

if (!$message = messages_get($tid, $pid, 1)) {

    html_draw_top();
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

$forum_name   = forum_get_setting('forum_name', false, 'A Beehive Forum');
$thread_title = _htmlentities(thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']));

html_draw_top("title=$forum_name > $thread_title", "openprofile.js", "post.js", "poll.js", "basetarget=_blank", "robots=index,follow");

if (isset($threaddata['STICKY']) && isset($threaddata['STICKY_UNTIL'])) {

    if ($threaddata['STICKY'] == "Y" && $threaddata['STICKY_UNTIL'] != 0 && time() > $threaddata['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $threaddata['STICKY'] == "N";
    }
}

$foldertitle = folder_get_title($threaddata['FID']);

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($foldertitle, $threaddata['PREFIX'], $threaddata['TITLE'], $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']), "</td>\n";

if ($threaddata['POLL_FLAG'] == 'Y' && $message['PID'] != 1) {

    if ($userpollvote = poll_get_user_vote($tid)) {

        if ($userpollvote ^ POLL_MULTIVOTE) {

            for ($i = 0; $i < sizeof($userpollvote); $i++) {

                $userpollvotes_array[] = $userpollvote[$i]['OPTION_ID'];
            }

            if (sizeof($userpollvotes_array) > 1) {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoptions']}: ", implode(", ", $userpollvotes_array), "</td>\n";

            }else {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoption']} #", implode(", ", $userpollvotes_array), "</td>\n";
            }
        }

    }else {

        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktovote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youhavenotvoted']}</td>\n";
    }
}

echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

if ($message) {

    $first_msg = $message['PID'];
    $message['CONTENT'] = message_get_content($tid, $message['PID']);

    if ($threaddata['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, true, $show_sigs, true);

        }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, false, $show_sigs, true);
        }

    }else {

        message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, false, $show_sigs, true);
    }
}

echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <form name=\"display\" method=\"get\" action=\"messages.php\" target=\"_self\">\n";
echo "        ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
echo "        ", form_input_hidden("msg", _htmlentities("$tid.$pid")), "\n";

if (isset($_GET['print_msg']) && is_numeric($_GET['print_msg'])) {
    echo "        ", form_submit("submit", $lang['back']), "&nbsp;", form_button("print", $lang['print'], "onclick=\"self.print()\""), "\n";
}else {
    echo "        ", form_submit("submit", $lang['back']), "\n";
}

echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>