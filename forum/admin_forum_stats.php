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

/* $Id: admin_forum_stats.php,v 1.20 2009-01-04 18:06:41 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// User count is used by a few stats. Get it once here.

$user_count = user_count();

// And off we go ...

html_draw_top('openprofile.js');

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['forumstats']}</h1>\n";

echo "  <br />\n";
echo "  <div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['folderstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($folder_count = stats_get_folder_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberoffolders']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($folder_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_threads = stats_get_folder_with_most_threads()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['folderwithmostthreads']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_threads['FID']}\">", htmlentities_array($folder_most_threads['TITLE']), "</a> (", number_format($folder_most_threads['THREAD_COUNT'], 0, '.', ','), " {$lang['threads']})</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_posts = stats_get_folder_with_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['folderwithmostposts']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_posts['FID']}\">", htmlentities_array($folder_most_posts['TITLE']), "</a> (", number_format($folder_most_posts['POST_COUNT'], 0, '.', ','), " {$lang['posts']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['threadstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($thread_count = stats_get_thread_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofthreads']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($thread_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagethreadcountperfolder']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", (($thread_count > 0) && ($folder_count > 0)) ? number_format($thread_count / $folder_count, 2, ".", ",") : 0, "</td>\n";
    echo "                </tr>\n";
}

if (($longest_thread = stats_get_longest_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['longestthread']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$longest_thread['TID']}.1\">", htmlentities_array(thread_format_prefix($longest_thread['PREFIX'], $longest_thread['TITLE'])), "</a> (", number_format($longest_thread['LENGTH'], 0, '.', ','), " {$lang['posts']})</td>\n";
    echo "                </tr>\n";
}

if (($most_read_thread = stats_get_most_read_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostreadthread']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_read_thread['TID']}.1\">", htmlentities_array(thread_format_prefix($most_read_thread['PREFIX'], $most_read_thread['TITLE'])), "</a> (", number_format($most_read_thread['VIEWCOUNT'], 0, '.', ','), " {$lang['threadviews']})</td>\n";
    echo "                </tr>\n";
}

if (($thread_subscription_count = stats_get_thread_subscription_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofthreadsubscriptions']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($thread_subscription_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_subscribed_thread = stats_get_most_subscribed_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostpopularthreadbysubscription']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_subscribed_thread['TID']}.1\">", htmlentities_array(thread_format_prefix($most_subscribed_thread['PREFIX'], $most_subscribed_thread['TITLE'])), "</a> (", number_format($most_subscribed_thread['SUBSCRIBERS'], 0, '.', ','), " {$lang['subscribers']})</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostpopularthreadbysubscription']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['none']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['poststats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($total_post_count = stats_get_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofposts']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($total_post_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($recent_post_count = stats_get_recent_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofpostsmadeinlastsixtyminutes']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($recent_post_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_posts = stats_get_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostpostsmadeinasinglesixtyminuteperiod']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($most_posts['MOST_POSTS_COUNT'], 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagepostsperuser']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($total_post_count > 0) && ($user_count > 0)) ? number_format($total_post_count / $user_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";

if (($top_poster = stats_get_top_poster()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['topposter']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$top_poster['UID']}\" target=\"_blank\" onclick=\"return openProfile({$top_poster['UID']}, '$webtag')\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($top_poster['LOGON'], $top_poster['NICKNAME']))), "</a> (", number_format($top_poster['POST_COUNT'], 0, '.', ','), " {$lang['posts']}) [<a href=\"admin_post_stats.php?webtag=$webtag\">{$lang['viewtop20']}</a>]</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['pollstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($poll_count = stats_get_poll_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofpolls']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($poll_option_count = stats_get_poll_option_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofpolloptions']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_option_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($poll_vote_count = stats_get_poll_vote_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofpollvotes']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_vote_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagevotesperpoll']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($poll_vote_count > 0) && ($poll_option_count > 0)) ? number_format($poll_vote_count / $poll_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['attachmentsstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($attachment_count = stats_get_attachment_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofattachments']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($attachment_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagenumberofattachmentsperpost']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($attachment_count > 0) && ($total_post_count > 0)) ? number_format($attachment_count / $total_post_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";

if ((($most_downloaded_attachment = stats_get_most_downloaded_attachment()) !== false) && ($attachment_href = attachment_make_link($most_downloaded_attachment, false))) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostdownloadedattachment']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$attachment_href (Msg: <a href=\"index.php?webtag=$webtag&amp;msg={$most_downloaded_attachment['msg']}\">{$most_downloaded_attachment['msg']}</a>)</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostdownloadedattachment']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['none']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userpreferencesstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($most_popular_forum_style = stats_get_most_popular_forum_style()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedforumstyle']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_forum_style['STYLE']} (", number_format($most_popular_forum_style['USER_COUNT'], 0, '.', ','), " {$lang['users']})</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_language = stats_get_most_popular_language()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedlanguuagefile']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_language['LANGUAGE']} (", number_format($most_popular_language['USER_COUNT'], 0, '.', ','), " {$lang['users']})</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_timezone = stats_get_most_popular_timezone()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedtimezone']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", timezone_id_to_string($most_popular_timezone['TIMEZONE']), " (", number_format($most_popular_timezone['USER_COUNT'], 0, '.', ','), " {$lang['users']})</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedtimezone']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['none']}</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_emoticon_pack = stats_get_most_popular_emoticon_pack()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedemoticonpack']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_emoticon_pack['EMOTICONS']} (", number_format($most_popular_emoticon_pack['USER_COUNT'], 0, '.', ','), " {$lang['users']})</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostusedtimezone']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['none']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofusers']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", number_format($user_count, 0, '.', ','), "</td>\n";
echo "                </tr>\n";

if (($contributing_user_count = stats_get_active_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofcontributingusers']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($contributing_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($noncontributing_user_count = stats_get_inactive_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofnoncontributingusers']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($noncontributing_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($newest_user = stats_get_newest_user()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['newestuser']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$newest_user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$newest_user['UID']}, '$webtag')\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($newest_user['LOGON'], $newest_user['NICKNAME']))), "</a></td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

$week_start = 0;
$week_end = 0;

if ((($visitor_count = stats_get_visitor_counts()) !== false) && stats_get_mysql_week($week_start, $week_end)) {

    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['visitorstats']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofvisitorstoday']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($visitor_count['DAY'], 0, '.', ','), "</td>\n";
    echo "                </tr>\n";

    if ($visitor_count['WEEK'] > $visitor_count['DAY']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">", sprintf($lang['numberofvisitorsthisweek'], format_date($week_start), format_date($week_end)), ":&nbsp;</td>\n";
        echo "                  <td align=\"left\">", number_format($visitor_count['WEEK'], 0, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    if ($visitor_count['MONTH'] > $visitor_count['WEEK']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofvisitorsthismonth']}:&nbsp;</td>\n";
        echo "                  <td align=\"left\">", number_format($visitor_count['MONTH'], 0, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    if ($visitor_count['YEAR'] > $visitor_count['MONTH']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofvisitorsthisyear']}:&nbsp;</td>\n";
        echo "                  <td align=\"left\">", number_format($visitor_count['YEAR'], 0, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['sessionstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($active_user_count = stats_get_active_session_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['totalnumberofactiveusers']}&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($active_registered_user_count = stats_get_active_registered_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofactiveregisteredusers']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_registered_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($active_guest_count = stats_get_active_guest_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofactiveguests']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_guest_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_users = stats_get_most_users()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostuserseveronline']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", sprintf($lang['mostuserseveronlinedetail'], number_format($most_users['MOST_USERS_COUNT'], 0, '.', ','), format_time($most_users['MOST_USERS_DATE'], 1)), "</td>\n";
    echo "                </tr>\n";
}

if (($most_active_user = stats_get_most_active_user()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostactiveuser']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$most_active_user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$most_active_user['UID']}, '$webtag')\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($most_active_user['LOGON'], $most_active_user['NICKNAME']))), "</a> (", format_time_display($most_active_user['TOTAL_TIME'], true), ")</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['profilestats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($user_profile_count = stats_get_users_with_profile_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofuserswithprofile']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_profile_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($user_no_profile_count = stats_get_users_without_profile_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofuserswithoutprofile']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_no_profile_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['signaturestats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($user_signature_count = stats_get_users_with_signature_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofuserswithsignature']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_signature_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($user_no_signature_count = stats_get_users_without_signature_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofuserswithoutsignature']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_no_signature_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['ageandbirthdaystats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($average_age = stats_get_average_age()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averageage']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($average_age, 2, '.', ','), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averageage']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['unknown']}</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_birthday = stats_get_most_popular_birthday()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostpopularbirthday']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", format_birthday($most_popular_birthday['DOB']), " (", number_format($most_popular_birthday['DOB_COUNT'], 0, '.', ','), " {$lang['users']})</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['mostpopularbirthday']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['nobirthdaydataavailable']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['relationshipstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($relationship_count = stats_get_relationships_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofuserreleationships']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($relationship_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averageage']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['unknown']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagerelationshipsperuser']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($relationship_count > 0) && ($user_count > 0)) ? number_format($relationship_count / $user_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"675\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['wordfilterstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($users_with_word_filter = stats_get_users_with_word_filter_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofusersusingwordfilter']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($users_with_word_filter, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($users_without_word_filter = stats_get_users_without_word_filter_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['numberofusersnotusingwordfilter']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($users_without_word_filter, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"300\">{$lang['averagewordfilterentriesperuser']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($users_with_word_filter > 0) && ($user_count > 0)) ? number_format($users_with_word_filter / $user_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </div>\n";

html_draw_bottom();

?>