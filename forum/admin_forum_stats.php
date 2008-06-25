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

/* $Id: admin_forum_stats.php,v 1.1 2008-06-25 19:48:39 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['forumstats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"31\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($folder_count = stats_get_folder_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['numberoffolders']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$folder_count</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_threads = stats_get_folder_with_most_threads()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['folderwithmostthreads']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_threads['FID']}\">", _htmlentities($folder_most_threads['TITLE']), "</a> ({$folder_most_threads['THREAD_COUNT']} {$lang['threads']}) [{$lang['viewfulllist']}]</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_posts = stats_get_folder_with_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['folderwithmostposts']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_posts['FID']}\">", _htmlentities($folder_most_posts['TITLE']), "</a> ({$folder_most_posts['POST_COUNT']} {$lang['posts']}) [{$lang['viewfulllist']}]</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($thread_count = stats_get_thread_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofthreads']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$thread_count</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['averagethreadcountperfolder']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($thread_count / $folder_count, 0, ",", ","), "</td>\n";
    echo "                </tr>\n";
}

if (($longest_thread = stats_get_longest_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['longestthread']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$longest_thread['TID']}.1\">", _htmlentities(thread_format_prefix($longest_thread['PREFIX'], $longest_thread['TITLE'])), "</a> ({$longest_thread['LENGTH']} {$lang['posts']})</td>\n";
    echo "                </tr>\n";
}

if (($most_read_thread = stats_get_most_read_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['mostreadthread']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_read_thread['TID']}.1\">", _htmlentities(thread_format_prefix($most_read_thread['PREFIX'], $most_read_thread['TITLE'])), "</a> ({$most_read_thread['VIEWCOUNT']} {$lang['threadviews']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($thread_subscription_count = stats_get_thread_subscription_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofthreadsubscriptions']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$thread_subscription_count</td>\n";
    echo "                </tr>\n";
}

if (($most_subscribed_thread = stats_get_most_subscribed_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['mostpopularthreadbysubscription']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_subscribed_thread['TID']}.1\">", _htmlentities(thread_format_prefix($most_subscribed_thread['PREFIX'], $most_subscribed_thread['TITLE'])), "</a> ({$most_subscribed_thread['SUBSCRIBERS']} {$lang['subscribers']})</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['mostpopularthreadbysubscription']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$lang['none']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($total_post_count = stats_get_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofposts']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$total_post_count</td>\n";
    echo "                </tr>\n";
}

if (($recent_post_count = stats_get_recent_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['numberofpostsmadeinlastsixtyminutes']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$recent_post_count</td>\n";
    echo "                </tr>\n";
}

if (($most_posts_count = stats_get_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['mostpostsmadeinasinglesixtyminuteperiod']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$recent_post_count</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['averagepostsperuser']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", number_format($total_post_count / $user_count, 0, ",", ","), "</td>\n";
echo "                </tr>\n";

if (($top_poster = stats_get_top_poster()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['topposter']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$top_poster['UID']}\" target=\"_blank\" onclick=\"return openProfile({$top_poster['UID']}, '$webtag')\">", word_filter_add_ob_tags(_htmlentities(format_user_name($top_poster['LOGON'], $top_poster['NICKNAME']))), "</a> ({$top_poster['POST_COUNT']} {$lang['posts']}) [{$lang['viewfulllist']}]</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($poll_count = stats_get_poll_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofpolls']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$poll_count</td>\n";
    echo "                </tr>\n";
}

if (($poll_option_count = stats_get_poll_option_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofpolloptions']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$poll_count</td>\n";
    echo "                </tr>\n";
}

if (($poll_vote_count = stats_get_poll_vote_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['totalnumberofpollvotes']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">$poll_vote_count</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['averagevotesperpoll']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($poll_vote_count > 0) && ($poll_option_count > 0)) ? number_format($poll_vote_count / $poll_count, 0, ",", ",") : 0, "</td>\n";
echo "                </tr>\n";

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? _htmlentities($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
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
echo "                  <td align=\"left\" rowspan=\"13\" width=\"1%\">&nbsp;</td>\n";
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