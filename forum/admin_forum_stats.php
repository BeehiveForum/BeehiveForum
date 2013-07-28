<?php

/*======================================================================

Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'stats.inc.php';
require_once BH_INCLUDE_PATH. 'timezone.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Cache page for 5 minutes
cache_check_request_throttle(300);

// User count is used by a few stats. Get it once here.
$user_count = user_count();

// And off we go ...
html_draw_top(sprintf('title=%s', gettext("Admin - Forum Stats")), 'class=window_title');

echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Forum Stats"), "</h1>\n";

echo "  <br />\n";
echo "  <div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Folder Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($folder_count = stats_get_folder_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of folders"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($folder_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_threads = stats_get_folder_with_most_threads()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Folder with most threads"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_threads['FID']}\">", word_filter_add_ob_tags($folder_most_threads['TITLE'], true), "</a> (", number_format($folder_most_threads['THREAD_COUNT'], 0, '.', ','), " ", gettext("threads"), ")</td>\n";
    echo "                </tr>\n";
}

if (($folder_most_posts = stats_get_folder_with_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Folder with most posts"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder={$folder_most_posts['FID']}\">", word_filter_add_ob_tags($folder_most_posts['TITLE'], true), "</a> (", number_format($folder_most_posts['POST_COUNT'], 0, '.', ','), " ", gettext("Posts"), ")</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Thread Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($thread_count = stats_get_thread_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of threads"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($thread_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average thread count per folder"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", (($thread_count > 0) && ($folder_count > 0)) ? number_format($thread_count / $folder_count, 2, ".", ",") : 0, "</td>\n";
    echo "                </tr>\n";
}

if (($longest_thread = stats_get_longest_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Longest thread"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$longest_thread['TID']}.1\">", word_filter_add_ob_tags($longest_thread['TITLE'], true), "</a> (", number_format($longest_thread['LENGTH'], 0, '.', ','), " ", gettext("Posts"), ")</td>\n";
    echo "                </tr>\n";
}

if (($most_read_thread = stats_get_most_read_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most read thread"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_read_thread['TID']}.1\">", word_filter_add_ob_tags($most_read_thread['TITLE'], true), "</a> (", number_format($most_read_thread['VIEWCOUNT'], 0, '.', ','), " ", gettext("Views"), ")</td>\n";
    echo "                </tr>\n";
}

if (($thread_subscription_count = stats_get_thread_subscription_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of thread subscriptions"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($thread_subscription_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_subscribed_thread = stats_get_most_subscribed_thread()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most popular thread by subscription"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg={$most_subscribed_thread['TID']}.1\">", word_filter_add_ob_tags($most_subscribed_thread['TITLE'], true), "</a> (", number_format($most_subscribed_thread['SUBSCRIBERS'], 0, '.', ','), " ", gettext("Subscribers"), ")</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most popular thread by subscription"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("none"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Post Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($total_post_count = stats_get_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of posts"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($total_post_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($recent_post_count = stats_get_recent_post_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of posts made in last 60 minutes"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($recent_post_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_posts = stats_get_most_posts()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most posts made in one 60 minute period"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($most_posts['MOST_POSTS_COUNT'], 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average posts per user"), ":&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($total_post_count > 0) && ($user_count > 0)) ? number_format($total_post_count / $user_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";

if (($top_poster = stats_get_top_poster()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Top poster"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$top_poster['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($top_poster['LOGON'], $top_poster['NICKNAME']), true), "</a> (", number_format($top_poster['POST_COUNT'], 0, '.', ','), " ", gettext("Posts"), ") [<a href=\"admin_post_stats.php?webtag=$webtag\">", gettext("View Top 20"), "</a>]</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Poll Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($poll_count = stats_get_poll_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of polls"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($poll_option_count = stats_get_poll_option_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of poll options"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_option_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($poll_vote_count = stats_get_poll_vote_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of poll votes"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($poll_vote_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average votes per poll"), ":&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Attachments Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($attachment_count = stats_get_attachment_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of attachments"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($attachment_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average attachment count per post"), ":&nbsp;</td>\n";
echo "                  <td align=\"left\">", (($attachment_count > 0) && ($total_post_count > 0)) ? number_format($attachment_count / $total_post_count, 2, ".", ",") : 0, "</td>\n";
echo "                </tr>\n";

if ((($most_downloaded_attachment = stats_get_most_downloaded_attachment()) !== false) && ($attachment_href = attachments_make_link($most_downloaded_attachment, false))) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most downloaded attachment"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">$attachment_href <a href=\"index.php?webtag=$webtag&amp;msg={$most_downloaded_attachment['msg']}\" target=\"_blank\">", gettext('View Message'), "</a></td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most downloaded attachment"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("none"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("User Preferences Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"32\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($most_popular_forum_style = stats_get_most_popular_forum_style()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used forum style"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_forum_style['STYLE']} (", number_format($most_popular_forum_style['USER_COUNT'], 0, '.', ','), " ", gettext("Users"), ")</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_language = stats_get_most_popular_language()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used language file"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_language['LANGUAGE']} (", number_format($most_popular_language['USER_COUNT'], 0, '.', ','), " ", gettext("Users"), ")</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_timezone = stats_get_most_popular_timezone()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used Time zone"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", timezone_id_to_string($most_popular_timezone['TIMEZONE']), " (", number_format($most_popular_timezone['USER_COUNT'], 0, '.', ','), " ", gettext("Users"), ")</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used Time zone"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("none"), "</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_emoticon_pack = stats_get_most_popular_emoticon_pack()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used Emoticon pack"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$most_popular_emoticon_pack['EMOTICONS']} (", number_format($most_popular_emoticon_pack['USER_COUNT'], 0, '.', ','), " ", gettext("Users"), ")</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most used Time zone"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("none"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("User Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users"), ":&nbsp;</td>\n";
echo "                  <td align=\"left\">", number_format($user_count, 0, '.', ','), "</td>\n";
echo "                </tr>\n";

if (($contributing_user_count = stats_get_active_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of contributing users"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($contributing_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($noncontributing_user_count = stats_get_inactive_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of non-contributing users"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($noncontributing_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($newest_user = stats_get_newest_user()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Newest User"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$newest_user['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($newest_user['LOGON'], $newest_user['NICKNAME']), true), "</a></td>\n";
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
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Visitor Stats"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of visitors today"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($visitor_count['DAY'], 0, '.', ','), "</td>\n";
    echo "                </tr>\n";

    if ($visitor_count['WEEK'] > $visitor_count['DAY']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", sprintf(gettext("Number of visitors this week"), format_date($week_start), format_date($week_end)), ":&nbsp;</td>\n";
        echo "                  <td align=\"left\">", number_format($visitor_count['WEEK'], 0, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    if ($visitor_count['MONTH'] > $visitor_count['WEEK']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of visitors this month"), ":&nbsp;</td>\n";
        echo "                  <td align=\"left\">", number_format($visitor_count['MONTH'], 0, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    if ($visitor_count['YEAR'] > $visitor_count['MONTH']) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of visitors this year"), ":&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Session Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($active_user_count = stats_get_active_session_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Total number of active users"), "&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($active_registered_user_count = stats_get_active_registered_user_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of active registered users"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_registered_user_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($active_guest_count = stats_get_active_guest_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of active guests"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($active_guest_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($most_users = stats_get_most_users()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most users ever online"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", sprintf(gettext("%s on %s"), number_format($most_users['MOST_USERS_COUNT'], 0, '.', ','), format_time($most_users['MOST_USERS_DATE'])), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Profile Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($user_profile_count = stats_get_users_with_profile_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users with profile"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_profile_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($user_no_profile_count = stats_get_users_without_profile_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users without profile"), ":&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Signature Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($user_signature_count = stats_get_users_with_signature_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users with signature"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($user_signature_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($user_no_signature_count = stats_get_users_without_signature_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users without signature"), ":&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Age and Birthday Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($average_age = stats_get_average_age()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average age"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($average_age, 2, '.', ','), "</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average age"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("Unknown"), "</td>\n";
    echo "                </tr>\n";
}

if (($most_popular_birthday = stats_get_most_popular_birthday()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most popular birthday"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", format_birthday($most_popular_birthday['DOB']), " (", number_format($most_popular_birthday['DOB_COUNT'], 0, '.', ','), " ", gettext("Users"), ")</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Most popular birthday"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("No Birthday Data Available"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Relationship Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($relationship_count = stats_get_relationships_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of user relationships"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($relationship_count, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average age"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", gettext("Unknown"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average relationships per user"), ":&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Word Filter Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"19\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($users_with_word_filter = stats_get_users_with_word_filter_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users using word filter"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($users_with_word_filter, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

if (($users_without_word_filter = stats_get_users_without_word_filter_count()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Number of users not using word filter"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", number_format($users_without_word_filter, 0, '.', ','), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"40%\">", gettext("Average word filter entries per user"), ":&nbsp;</td>\n";
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