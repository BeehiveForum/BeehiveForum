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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
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
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "visitor_log.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

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

// Start left caching
cache_check_start_page();

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Number of posts per page
if (($posts_per_page = session_get_value('POSTS_PER_PAGE'))) {

    if ($posts_per_page < 10) $posts_per_page = 10;
    if ($posts_per_page > 30) $posts_per_page = 30;

}else {

    $posts_per_page = 20;
}

html_draw_top();

echo "  <h1>", gettext("Start"), "</h1>\n";
echo "  <br />\n";

$folder_info = threads_get_folders();

if (is_array($folder_info) && sizeof($folder_info) > 0) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"subhead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", gettext("Recent threads"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";

    if (($thread_array = threads_get_most_recent())) {

        foreach ($thread_array as $thread) {

            $tid = $thread['TID'];

            echo "                    <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
            echo "                      <tr>\n";

            if ($thread['LAST_READ'] == 0 || $thread['LAST_READ'] < $thread['LENGTH']) {
                echo "                        <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\"><img src=\"", html_style_image('unread_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"", gettext("Unread Messages"), "\" title=\"", gettext("Unread Messages"), "\" /></td>\n";
            }else {
                echo "                        <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\"><img src=\"", html_style_image('bullet.png'), "\" name=\"t{$thread['TID']}\" alt=\"", gettext("Read Thread"), "\" title=\"", gettext("Read Thread"), "\" /></td>\n";
            }

            if ($thread['LAST_READ'] == 0) {

                if ($thread['LENGTH'] > 1) {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= sprintf(gettext("%d new"), $thread['LENGTH']);
                    $number.= "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.". thread_get_last_page_pid($thread['LENGTH'], $posts_per_page). "\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";

                }else {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= sprintf(gettext("%d new"), $thread['LENGTH']);
                    $number.= "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.". thread_get_last_page_pid($thread['LENGTH'], $posts_per_page). "\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";
                }

                $latest_post = 1;

            }elseif ($thread['LAST_READ'] < $thread['LENGTH']) {

                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];

                if ($new_posts > 1) {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= sprintf(gettext("%d new of %d"), $new_posts, $thread['LENGTH']);
                    $number.= "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.". thread_get_last_page_pid($thread['LENGTH'], $posts_per_page). "\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";

                }else {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= sprintf(gettext("%d new of %d"), $new_posts, $thread['LENGTH']);
                    $number.= "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.". thread_get_last_page_pid($thread['LENGTH'], $posts_per_page). "\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";
                }

                $latest_post = $thread['LAST_READ'] + 1;

            }else {

                if ($thread['LENGTH'] > 1) {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= "{$thread['LENGTH']}<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";

                }else {

                    $number = "<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to first post in thread"). "\">[</a>";
                    $number.= "1<a href=\"discussion.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('main'). "\" title=\"". gettext("Go to last post in thread"). "\">]</a>";
                }

                $latest_post = 1;
            }

            $thread_time = format_time($thread['MODIFIED']);

            echo "                        <td align=\"left\" valign=\"top\"><a href=\"discussion.php?webtag=$webtag&amp;msg=$tid.$latest_post\" target=\"", html_get_frame_name('main'), "\" ";
            echo "title=\"", sprintf(gettext("Thread #%s Started by %s. Viewed %s"), $thread['TID'], word_filter_add_ob_tags(format_user_name($thread['LOGON'], $thread['NICKNAME']), true), ($thread['VIEWCOUNT'] == 1) ? gettext("1 time") : sprintf(gettext("%d times"), $thread['VIEWCOUNT'])), "\">";
            echo word_filter_add_ob_tags($thread['TITLE'], true), "</a> ";

            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_INTERESTED) echo "<img src=\"", html_style_image('high_interest.png'), "\" alt=\"", gettext("High Interest"), "\" title=\"", gettext("High Interest"), "\" /> ";
            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_SUBSCRIBED) echo "<img src=\"", html_style_image('subscribe.png'), "\" alt=\"", gettext("Subscribed"), "\" title=\"", gettext("Subscribed"), "\" /> ";
            if (isset($thread['POLL_FLAG']) && $thread['POLL_FLAG'] == 'Y') echo "<a href=\"poll_results.php?webtag=$webtag&amp;tid={$thread['TID']}\" target=\"_blank\" class=\"popup 800x600\"><img src=\"", html_style_image('poll.png'), "\" border=\"0\" alt=\"", gettext("This is a poll. Click to view results."), "\" title=\"", gettext("This is a poll. Click to view results."), "\" /></a> ";
            if (isset($thread['STICKY']) && $thread['STICKY'] == "Y") echo "<img src=\"", html_style_image('sticky.png'), "\" alt=\"", gettext("Sticky"), "\" title=\"", gettext("Sticky"), "\" /> ";
            if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP'] & USER_FRIEND) echo "<img src=\"", html_style_image('friend.png'), "\" alt=\"", gettext("Friend"), "\" title=\"", gettext("Friend"), "\" /> ";
            if (isset($thread['AID']) && is_md5($thread['AID'])) echo "<img src=\"", html_style_image('attach.png'), "\" alt=\"", gettext("Attachment"), "\" title=\"", gettext("Attachment"), "\" /> ";

            echo "<span class=\"threadxnewofy\">{$number}</span></td>\n";
            echo "                        <td valign=\"top\" style=\"white-space: nowrap\" align=\"right\"><span class=\"threadtime\">{$thread_time}&nbsp;</span></td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
        }

    } else {

        echo "                    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\">", gettext("No Messages"), "</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
    }

    // Display "Start Reading" button
    echo "                    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\" colspan=\"2\">", form_quick_button("discussion.php", gettext("Start Reading"), false, html_get_frame_name('main')), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"subhead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", gettext("Thread Options"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";
    echo "                      <tr>\n";
    echo "                        <td class=\"postbody\" colspan=\"2\" align=\"center\">\n";
    echo "                          <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\">&nbsp;</td>\n";
    echo "                              <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\"><img src=\"", html_style_image('post.png'), "\" alt=\"", gettext("New Discussion"), "\" title=\"", gettext("New Discussion"), "\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">", gettext("New Discussion"), "</a></td>\n";
    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\">&nbsp;</td>\n";
    echo "                              <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\"><img src=\"", html_style_image('poll.png'), "\" alt=\"", gettext("Create Poll"), "\" title=\"", gettext("Create Poll"), "\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">", gettext("Create Poll"), "</a></td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"subhead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">", gettext("Recent Visitors"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";

// Get recent visitors
if (($recent_visitors_array = visitor_log_get_recent())) {

    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";
    echo "                          <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">\n";

    foreach ($recent_visitors_array as $recent_visitor) {

        if (isset($recent_visitor['LAST_LOGON']) && $recent_visitor['LAST_LOGON'] > 0) {
        
            echo "                            <tr>\n";

            if (session_get_value('SHOW_AVATARS') == 'Y') {

                if (isset($recent_visitor['AVATAR_URL']) && strlen($recent_visitor['AVATAR_URL']) > 0) {

                    echo "                   <td valign=\"top\"  class=\"postbody\" align=\"left\" width=\"25\"><img src=\"{$recent_visitor['AVATAR_URL']}\" alt=\"\" title=\"", word_filter_add_ob_tags(htmlentities_array(format_user_name($recent_visitor['LOGON'], $recent_visitor['NICKNAME']))), "\" border=\"0\" width=\"16\" height=\"16\" /></td>\n";

                }else if (isset($recent_visitor['AVATAR_AID']) && is_md5($recent_visitor['AVATAR_AID'])) {

                    $attachment = attachments_get_by_hash($recent_visitor['AVATAR_AID']);

                    if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false))) {

                        echo "                   <td valign=\"top\"  class=\"postbody\" align=\"left\" width=\"25\"><img src=\"$profile_picture_href&amp;avatar_picture\" alt=\"\" title=\"", word_filter_add_ob_tags(htmlentities_array(format_user_name($recent_visitor['LOGON'], $recent_visitor['NICKNAME']))), "\" border=\"0\" width=\"16\" height=\"16\" /></td>\n";

                    }else {

                        echo "                   <td valign=\"top\"  align=\"left\" class=\"postbody\" width=\"25\"><img src=\"", html_style_image('bullet.png'), "\" alt=\"", gettext('User'), "\" title=\"", gettext('User'), "\" /></td>\n";
                    }

                }else {

                    echo "                   <td valign=\"top\"  align=\"left\" class=\"postbody\" width=\"25\"><img src=\"", html_style_image('bullet.png'), "\" alt=\"", gettext('User'), "\" title=\"", gettext('User'), "\" /></td>\n";
                }

            }else {

                echo "                   <td valign=\"top\"  align=\"left\" class=\"postbody\" width=\"25\"><img src=\"", html_style_image('bullet.png'), "\" alt=\"", gettext('User'), "\" title=\"", gettext('User'), "\" /></td>\n";
            }

            if (isset($recent_visitor['SID']) && !is_null($recent_visitor['SID']) && forum_get_setting('searchbots_show_recent', 'Y')) {

                echo "                              <td valign=\"top\"  align=\"left\"><a href=\"{$recent_visitor['URL']}\" target=\"_blank\">", word_filter_add_ob_tags(htmlentities_array($recent_visitor['NAME'])), "</a></td>\n";

            }elseif ($recent_visitor['UID'] > 0) {

                echo "                              <td valign=\"top\"  align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$recent_visitor['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($recent_visitor['LOGON'], $recent_visitor['NICKNAME']))), "</a></td>\n";

            }else {

                echo "                              <td valign=\"top\"  align=\"left\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($recent_visitor['LOGON'], $recent_visitor['NICKNAME']))), "</td>\n";
            }

            echo "                              <td valign=\"top\"  align=\"right\" style=\"white-space: nowrap\"><span class=\"threadtime\">", format_time($recent_visitor['LAST_LOGON']), "&nbsp;</span></td>\n";
        }

        echo "                            </tr>\n";
    }

    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", gettext('No Visitors Logged'), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\" colspan=\"2\">", form_quick_button("visitor_log.php", gettext("More Visitors"), array('profile_selection' => 'LAST_VISIT', 'hide_empty' => 'Y'), html_get_frame_name('right')), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";

if (($user_birthdays_array = user_get_forthcoming_birthdays())) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"subhead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", gettext("Forthcoming Birthdays"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";
    echo "                          <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">\n";

    foreach ($user_birthdays_array as $user_birthday) {

        echo "                            <tr>\n";
        echo "                              <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\"><img src=\"", html_style_image('bullet.png'), "\" alt=\"", gettext("User"), "\" title=\"", gettext("User"), "\" /></td>\n";
        echo "                              <td align=\"left\" valign=\"top\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_birthday['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($user_birthday['LOGON'], $user_birthday['NICKNAME']), true), "</a></td>\n";
        echo "                              <td align=\"right\" style=\"white-space: nowrap\" valign=\"top\"><span class=\"threadtime\">", format_birthday($user_birthday['DOB']), "&nbsp;</span></td>\n";
        echo "                            </tr>\n";
    }

    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\" colspan=\"2\">", form_quick_button("visitor_log.php", gettext("More"), array('profile_selection' => 'DOB,AGE', 'sort_by' => 'DOB', 'sort_dir' => 'ASC', 'hide_empty' => 'Y', 'hide_guests' => 'Y'), html_get_frame_name('right')), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

if (is_array($folder_info) && sizeof($folder_info) > 0) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"subhead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", gettext("Navigate"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";
    echo "                          <table class=\"posthead\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td valign=\"top\" align=\"center\" style=\"white-space: nowrap\" width=\"25\">&nbsp;</td>\n";
    echo "                              <td align=\"left\">\n";
    echo "                                <form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"discussion.php\" target=\"", html_get_frame_name('main'), "\">\n";
    echo "                                  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "                                  ", form_input_text('msg', '1.1', 10), "\n";
    echo "                                  ", form_submit("go",gettext("Go!")), "\n";
    echo "                                </form>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

html_draw_bottom();

?>