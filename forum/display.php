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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// User UID for fetching recent message
$uid = session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

}else if (isset($_GET['print_msg']) && validate_msg($_GET['print_msg'])) {

    $msg = $_GET['print_msg'];
    list($tid, $pid) = explode('.', $msg);

}else {

    html_draw_top("title={$lang['error']}", "robots=noindex,nofollow", 'class=window_title');
    html_error_msg($lang['invalidmsgidornomessageidspecified']);
    html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid, session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!$folder_data = folder_get($thread_data['FID'])) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!$message = messages_get($tid, $pid, 1)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

$thread_title = thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']);

html_draw_top("title=$thread_title", "post.js", "basetarget=_blank", 'class=window_title');

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_data['TITLE'], $thread_title, $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'), true), "</td>\n";
echo "    <td align=\"right\">\n";

if ((forum_get_setting('show_share_links', 'Y')) && (session_get_value('SHOW_SHARE_LINKS') == 'Y')) {

    echo "      <div style=\"display: inline-block; vertical-align: middle; margin-top: 1px\">\n";
    echo "        <g:plusone size=\"small\" count=\"false\" href=\"",  htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "\"></g:plusone>\n";
    echo "      </div>\n";
    echo "      <div style=\"display: inline-block; width: 47px; vertical-align: middle; margin-top: 2px; overflow: hidden\">\n";
    echo "        <iframe src=\"http://www.facebook.com/plugins/like.php?href=", urlencode(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:21px;\" allowTransparency=\"true\"></iframe>\n";
    echo "      </div>\n";
    echo "      <div style=\"display: inline-block; width: 55px; vertical-align: middle; overflow: hidden\">\n";
    echo "        <a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"", htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "\" data-count=\"none\">Tweet</a>\n";
    echo "      </div>\n";

} else {

    echo "&nbsp;";
}

echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

if ($message) {

    $first_msg = $message['PID'];

    $message['CONTENT'] = message_get_content($tid, $message['PID']);

    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" width=\"2%\" valign=\"top\">&nbsp;</td>\n";
    echo "    <td align=\"center\">\n";

    if ($thread_data['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, $show_sigs, true);

        }else {

            message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, true, $show_sigs, true);
        }

    }else {

        message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, false, $show_sigs, true);
    }

    echo "    </td>\n";
    echo "    <td width=\"2%\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    if (adsense_check_user() && adsense_check_page($message['PID'], 1, $thread_data['LENGTH'])) {

        adsense_output_html();
        echo "<br />\n";
    }
}

echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"_self\" class=\"button\"><span>{$lang['back']}</span></a>\n";
echo "      ", form_button("print", $lang['print']), "\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>