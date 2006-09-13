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

/* $Id: start_left.php,v 1.112 2006-09-13 22:47:15 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top("openprofile.js", "robots=noindex,follow");

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

        if (!isset($thread['LAST_READ'])) {
            echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('unread_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['unreadthread']}\" title=\"{$lang['unreadthread']}\" />&nbsp;</td>\n";
        }else if ($thread['LAST_READ'] == 0 || $thread['LAST_READ'] < $thread['LENGTH']) {
            echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('unread_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['unreadmessages']}\" title=\"{$lang['unreadmessages']}\" />&nbsp;</td>\n";
        }else if ($thread['LAST_READ'] == $thread['LENGTH']) {
            echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('bullet.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['readthread']}\" title=\"{$lang['readthread']}\" />&nbsp;</td>\n";
        }

        echo "          <td><a href=\"discussion.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"main\" ";
        echo "title=\"#$tid Started by ", add_wordfilter_tags(format_user_name($thread['LOGON'], $thread['NICKNAME'])), ". ";
        echo ($thread['VIEWCOUNT'] == 1) ? $lang['threadviewedonetime'] : sprintf($lang['threadviewedtimes'], $thread['VIEWCOUNT']), "\">";
        echo add_wordfilter_tags($thread['TITLE']), "</a>&nbsp;";

        if (isset($thread['INTEREST']) && $thread['INTEREST'] == 1) echo "<img src=\"", style_image('high_interest.png'), "\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" /> ";
        if (isset($thread['INTEREST']) && $thread['INTEREST'] == 2) echo "<img src=\"", style_image('subscribe.png'), "\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" /> ";
        if ($thread['POLL_FLAG'] == 'Y') echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid={$thread['TID']}', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" /></a> ";
        if (isset($thread['STICKY']) && $thread['STICKY'] == "Y") echo "<img src=\"", style_image('sticky.png'), "\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" /> ";
        if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP']&USER_FRIEND) echo "<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /> ";
        if (isset($thread['AID']) && is_md5($thread['AID'])) echo "<img src=\"", style_image('attach.png'), "\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" /> ";

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
echo "    <td class=\"postbody\" colspan=\"2\" align=\"center\">\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "        <tr>\n";
echo "          <td valign=\"top\" nowrap=\"nowrap\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"main\">{$lang['newdiscussion']}</a></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td valign=\"top\" nowrap=\"nowrap\"><img src=\"", style_image('poll.png'), "\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"main\">{$lang['createpoll']}</a></td>\n";
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

$users_array = users_get_recent(0, 10);

if ($users_array['user_count'] > 0) {

    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";

    foreach ($users_array['user_array'] as $recent_user) {

        echo "        <tr>\n";
        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('bullet.png'), "\" alt=\"{$lang['user']}\" title=\"{$lang['user']}\" /></td>\n";

        if (isset($recent_user['SID']) && !is_null($recent_user['SID'])) {

            echo "                   <td><a href=\"{$recent_user['URL']}\" target=\"_blank\">{$recent_user['NAME']}</a></td>\n";

        }elseif ($recent_user['UID'] > 0) {

            echo "                   <td><a href=\"javascript:void(0)\" target=\"_self\" onclick=\"openProfile({$recent_user['UID']}, '$webtag')\">", add_wordfilter_tags(add_wordfilter_tags(format_user_name($recent_user['LOGON'], $recent_user['NICKNAME']))), "</a></td>\n";

        }else {

            echo "                   <td>", add_wordfilter_tags(add_wordfilter_tags(format_user_name($recent_user['LOGON'], $recent_user['NICKNAME']))), "</td>\n";
        }

        if (isset($recent_user['LAST_LOGON']) && $recent_user['LAST_LOGON'] > 0) {
            echo "                   <td align=\"right\" nowrap=\"nowrap\">", format_time($recent_user['LAST_LOGON']), "&nbsp;</td>\n";
        }else {
            echo "                   <td align=\"right\" nowrap=\"nowrap\">{$lang['unknown']}&nbsp;</td>\n";
        }

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
echo "    <td align=\"center\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['showmorevisitors']}\" title=\"{$lang['showmorevisitors']}\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag\" target=\"right\">{$lang['showmorevisitors']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";

if ($birthdays = user_get_forthcoming_birthdays()) {

    echo "  <tr>\n";
    echo "    <td class=\"subhead\" colspan=\"2\">{$lang['forthcomingbirthdays']}</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";

    foreach ($birthdays as $row) {

        echo "        <tr>\n";
        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\"><img src=\"", style_image('bullet.png'), "\" alt=\"{$lang['user']}\" title=\"{$lang['user']}\" /></td>\n";
        echo "          <td><a href=\"javascript:void(0)\" target=\"_self\" onclick=\"openProfile({$row['UID']}, '$webtag')\">", add_wordfilter_tags($row['NICKNAME']), "</a></td>\n";
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
echo "    <td align=\"center\">\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "        <tr>\n";
echo "          <td>\n";
echo "            <form name=\"f_nav\" method=\"get\" action=\"discussion.php\" target=\"main\">\n";
echo "              ", form_input_hidden("webtag", $webtag), "\n";
echo "              ", form_input_text('msg', '1.1', 10), "\n";
echo "              ", form_submit("go",$lang['goexcmark']), "\n";
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