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

/* $Id: start_left.php,v 1.72 2004-04-17 17:39:28 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/threads.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top("openprofile.js");

echo "<table class=\"posthead\" border=\"0\" width=\"200\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">{$lang['recentthreads']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";

if ($thread_array = threads_get_most_recent()) {

    foreach ($thread_array as $thread) {

        $tid = $thread['TID'];

        if (isset($thread['LAST_READ']) && $thread['LAST_READ'] && $thread['LENGTH'] > $thread['LAST_READ']) {
            $pid = $thread['LAST_READ'] + 1;
        } else {
            $pid = 1;
        }

        echo "        <tr>\n";
        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\">";

        if (!isset($thread['LAST_READ'])) {
            echo "<img src=\"".style_image('unread_thread.png')."\" name=\"t".$thread['TID']."\" align=\"middle\" alt=\"{$lang['unreadthread']}\" />";
        }else if ($thread['LAST_READ'] == 0 || $thread['LAST_READ'] < $thread['LENGTH']) {
            echo "<img src=\"".style_image('unread_thread.png')."\" name=\"t".$thread['TID']."\" align=\"middle\" alt=\"{$lang['unreadmessages']}\" />";
        }else if ($thread['LAST_READ'] == $thread['LENGTH']) {
            echo "<img src=\"".style_image('bullet.png')."\" name=\"t".$thread['TID']."\" align=\"middle\" alt=\"{$lang['readthread']}\" />";
        }

        echo "&nbsp;</td>\n";
        echo "          <td><a href=\"discussion.php?webtag=$webtag&msg=$tid.$pid\" target=\"main\" title=\"#$tid Started by " . format_user_name($thread['LOGON'], $thread['NICKNAME']) . "\">";
        echo _stripslashes($thread['TITLE'])."</a>&nbsp;";

        if (isset($thread['INTEREST']) && $thread['INTEREST'] == 1) echo "<img src=\"".style_image('high_interest.png')."\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" align=\"middle\" /> ";
        if (isset($thread['INTEREST']) && $thread['INTEREST'] == 2) echo "<img src=\"".style_image('subscribe.png')."\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" align=\"middle\" /> ";
	if (isset($thread['POLL_FLAG']) && $thread['POLL_FLAG'] == 'Y') echo "<img src=\"".style_image('poll.png')."\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" align=\"middle\" /> ";
        if (isset($thread['STICKY']) && $thread['STICKY'] == "Y") echo "<img src=\"".style_image('sticky.png')."\" alt=\"{$lang['sticky']}\" align=\"middle\" /> ";
	if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP'] & USER_FRIEND) echo "<img src=\"" . style_image('friend.png') . "\" height=\"15\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" align=\"middle\" /> ";
	if (isset($thread['ATTACHMENTS']) && !empty($thread['ATTACHMENTS'])) echo "<img src=\"" . style_image('attach.png') . "\" height=\"15\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" align=\"middle\" /> ";

        echo "          </td>\n";
        echo "        </tr>\n";
    }

}else {

    echo "        <tr>\n";
    echo "          <td align=\"center\"><h2>{$lang['nomessages']}</h2></td>\n";
    echo "        </tr>\n";

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";

// Display "Start Reading" button
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "        <tr>\n";
echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\">", form_quick_button("./discussion.php", "{$lang['startreading']} &gt;&gt;", false, false, "main"), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">{$lang['threadoptions']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"2\">\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "        <tr>\n";
echo "          <td valign=\"top\" nowrap=\"nowrap\"><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"main\">{$lang['newdiscussion']}</a></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td valign=\"top\" nowrap=\"nowrap\"><img src=\"", style_image('poll.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"main\">{$lang['createpoll']}</a></td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">{$lang['recentvisitors']}</td>\n";
echo "  </tr>\n";

// Get recent visitors

$users_array = users_get_recent();

if (sizeof($users_array['user_array']) > 0) {

    echo "  <tr>\n";
    echo "    <td>\n";
    echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";

    foreach ($users_array['user_array'] as $resent_user) {

        echo "        <tr>\n";
        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('bullet.png'), "\" width=\"12\" height=\"16\" alt=\"bullet\" /></td>\n";
        echo "          <td><a href=\"#\" target=\"_self\" onclick=\"openProfile({$resent_user['UID']}, '$webtag')\">", $resent_user['NICKNAME'], "</a></td>\n";
        echo "          <td align=\"right\" nowrap=\"nowrap\">", format_time($resent_user['LAST_LOGON']), "&nbsp;</td>\n";
        echo "        </tr>\n";
    }

    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"center\"><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag\" target=\"right\">{$lang['showmorevisitors']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";

if ($birthdays = user_get_forthcoming_birthdays()) {

    echo "  <tr>\n";
    echo "    <td class=\"subhead\" colspan=\"2\">{$lang['forthcomingbirthdays']}</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>\n";
    echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";

    foreach ($birthdays as $row) {

        echo "        <tr>\n";
        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('bullet.png'), "\" width=\"12\" height=\"16\" alt=\"bullet\" /></td>\n";
        echo "          <td><a href=\"#\" target=\"_self\" onclick=\"openProfile({$row['UID']}, '$webtag')\">", $row['NICKNAME'], "</a></td>\n";
        echo "          <td align=\"right\" nowrap=\"nowrap\">", format_birthday($row['DOB']), "&nbsp;</td>\n";
        echo "        </tr>\n";
    }

    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td class=\"subhead\" colspan=\"2\">{$lang['navigate']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "        <tr>\n";
echo "          <td>\n";
echo "            <form name=\"f_nav\" method=\"get\" action=\"discussion.php\" target=\"main\">\n";
echo "              ", form_input_hidden("webtag", $webtag), "\n";
echo "              ", form_input_text('msg', '1.1', 10). "\n";
echo "              ", form_submit("go",$lang['goexcmark']). "\n";
echo "            </form>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>