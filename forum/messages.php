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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'adsense.inc.php';
require_once BH_INCLUDE_PATH. 'beehive.inc.php';
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'rss_feed.inc.php';
require_once BH_INCLUDE_PATH. 'search.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Message pane caching
cache_check_messages();

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

} else if (($msg = messages_get_most_recent($uid)) !== false) {

    list($tid, $pid) = explode('.', $msg);

} else {

    html_draw_error(gettext("Invalid Message ID or no Message ID specified."));
}

// Poll stuff
if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        if (isset($_POST['pollvote']) && is_array($_POST['pollvote'])) {

            $poll_votes_array = $_POST['pollvote'];

            if (poll_check_tabular_votes($tid, $poll_votes_array)) {

                poll_vote($tid, $poll_votes_array);

            } else {

                html_draw_error(gettext("You must pick and answer for every question"));
            }

        } else {

            html_draw_error(gettext("You must select an answer to vote for"));
        }
    }

} else if (isset($_POST['pollchangevote'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        $pid = 1;

        poll_delete_vote($tid);
    }
}

// Number of posts per page
if (isset($_SESSION['POSTS_PER_PAGE']) && is_numeric($_SESSION['POSTS_PER_PAGE'])) {
    $posts_per_page = max(min($_SESSION['POSTS_PER_PAGE'], 30), 10);
} else {
    $posts_per_page = 20;
}

$high_interest = (isset($_SESSION['MARK_AS_OF_INT']) && $_SESSION['MARK_AS_OF_INT'] == 'Y') ? 'Y' : 'N';

// Check the thread exists.
if (!$thread_data = thread_get($tid, session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

// Check it's in a folder we can view.
if (!$folder_data = folder_get($thread_data['FID'])) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

// Get the messages.
if (!$messages = messages_get($tid, $pid, $posts_per_page)) {
    html_draw_error(gettext("That post does not exist in this thread!"));
}

html_draw_top("title={$thread_data['TITLE']}", "class=window_title", "post.js", "poll.js", "basetarget=_blank");

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = (isset($_SESSION['VIEW_SIGS']) && $_SESSION['VIEW_SIGS'] == 'Y');

$page_prefs = session::get_post_page_prefs();

$msg_count = count($messages);

$highlight_array = array();

if (isset($_GET['highlight'])) {
    $highlight_array = search_get_keywords();
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_data['TITLE'], $thread_data['TITLE'], $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'), true, $highlight_array), "</td>\n";
echo "    <td align=\"right\">", messages_social_links($tid), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {
    if ($_GET['markasread'] > 0) {
        html_display_success_msg(gettext("Thread Read Status Updated Successfully"), '96%', 'center');
    } else {
        html_display_error_msg(gettext("Failed to update thread read status"), '96%', 'center');
    }
}

if (isset($_GET['setinterest'])) {
    if ($_GET['setinterest'] > 0) {
        html_display_success_msg(gettext("Thread Interest Status Updated Successfully"), '96%', 'center');
    } else {
        html_display_error_msg(gettext("Failed to update thread interest"), '96%', 'center');
    }
}

if (isset($_GET['relupdated'])) {

    html_display_success_msg(gettext("Relationships Updated!"), '96%', 'center');

} else if (isset($_GET['setstats'])) {

    html_display_success_msg(gettext("Stats Display Changed"), '96%', 'center');

} else if (isset($_GET['edit_success']) && validate_msg($_GET['edit_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully edited post %s"), $_GET['edit_success']), '96%', 'center');

} else if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully deleted post %s"), $_GET['delete_success']), '96%', 'center');

} else if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully deleted post %s"), $_GET['delete_success']), '96%', 'center');

} else if (isset($_GET['post_approve_success']) && validate_msg($_GET['post_approve_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully approved post %s"), $_GET['post_approve_success']), '96%', 'center');
}

if (isset($_GET['font_resize'])) {

    echo "<div id=\"font_resize_success\">\n";
    html_display_success_msg(sprintf(gettext("Font Size Changed. %s"), gettext("Frames must be reloaded manually to see changes.")), '96%', 'center');
    echo "</div>\n";
}

if (($tracking_data_array = thread_get_tracking_data($tid)) !== false) {

    echo "<table class=\"thread_track_notice\" width=\"96%\">\n";

    foreach ($tracking_data_array as $tracking_data) {

        if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_MERGE) { // Thread merged
            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], gettext("here"));

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf(gettext("<b>Threads Merged:</b> This thread has moved %s"), $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], gettext("here"));

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf(gettext("<b>Threads Merged:</b> This thread was merged from %s"), $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

        } else if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_SPLIT) { // Thread Split

            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], gettext("here"));

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf(gettext("<b>Thread Split:</b> Some posts in this thread have been moved %s"), $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], gettext("here"));

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf(gettext("<b>Thread Split:</b> Some posts in this thread were moved from %s"), $thread_link), "</td>\n";
                echo "  </tr>\n";
            }
        }
    }

    echo "</table>\n";
}

echo "</div>\n";
echo "<form accept-charset=\"utf-8\" name=\"f_quote\" action=\"post.php\" method=\"get\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('quote_list', ''), "\n";
echo "  ", form_input_hidden('replyto', ''), "\n";
echo "</form>\n";

echo "<div id=\"quick_reply_container\" class=\"quick_reply_container_closed\">\n";
echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"quick_reply_form\" action=\"post.php\" method=\"post\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('t_tid', htmlentities_array($tid)), "\n";
echo "  ", form_input_hidden('t_rpid', '0'), "\n";
echo "  ", form_input_hidden('t_post_interest', $high_interest), "\n";
echo "  ", form_input_hidden('attachment[]', ""), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        ", html_display_warning_msg(gettext("Press Ctrl+Enter to quickly submit your post"), '100%', 'center');
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table cellspacing=\"0\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"subhead\">", gettext("Quick Reply"), "</td>\n";
echo "                        <td align=\"right\" class=\"subhead\"><span id=\"quick_reply_header\"></span>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">", form_textarea("t_content", "", 7, 75, false, 'editor mobile focus quick_reply'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("post", gettext("Post")), "&nbsp;", form_submit("more", gettext("More")), "&nbsp;", form_button("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

if ($msg_count > 0) {

    foreach ($messages as $message_number => $message) {

        if (isset($message['RELATIONSHIP'])) {

            if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                $message['CONTENT'] = message_get_content($tid, $message['PID']);
            } else {
                $message['CONTENT'] = gettext("Ignored"); // must be set to something or will show as deleted
            }

        } else {

            $message['CONTENT'] = message_get_content($tid, $message['PID']);
        }

        if ($thread_data['POLL_FLAG'] == 'Y') {

            if ($message['PID'] == 1) {

                poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], true, $thread_data['CLOSED'], false, $show_sigs, false, $highlight_array);
                $last_pid = $message['PID'];

            } else {

                message_display($tid, $message, $thread_data['LENGTH'], $pid, $thread_data['FID'], true, $thread_data['CLOSED'], true, true, $show_sigs, false, $highlight_array);
                $last_pid = $message['PID'];
            }

        } else {

            message_display($tid, $message, $thread_data['LENGTH'], $pid, $thread_data['FID'], true, $thread_data['CLOSED'], true, false, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];
        }

        if (adsense_check_user() && adsense_check_page($message_number, $posts_per_page, $thread_data['LENGTH'])) {

            adsense_output_html();
            echo "<br />\n";
        }
    }
}

if ($msg_count > 0 && session::logged_in() && !isset($_GET['markasread'])) {
    messages_update_read($tid, $last_pid, $thread_data['LAST_READ'], $thread_data['LENGTH'], $thread_data['MODIFIED']);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";

if (($thread_data['CLOSED'] == 0 && session::check_perm(USER_PERM_POST_CREATE, $thread_data['FID'])) || session::check_perm(USER_PERM_FOLDER_MODERATE, $thread_data['FID'])) {

    echo "    <td width=\"33%\" align=\"left\" style=\"white-space: nowrap\" class=\"postbody\">";
    echo "      <img src=\"". html_style_image('reply_all.png') ."\" alt=\"", gettext("Reply to All"), "\" title=\"", gettext("Reply to All"), "\" border=\"0\" /> ";
    echo "      <a href=\"post.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\" id=\"reply_0\"><b>", gettext("Reply to All"), "</b></a>\n";
    echo "    </td>\n";

} else {

    echo "    <td width=\"33%\" align=\"left\" class=\"postbody\">&nbsp;</td>\n";
}

if (session::logged_in()) {

    if ($thread_data['LENGTH'] > 0) {

        echo "    <td width=\"33%\" align=\"center\" style=\"white-space: nowrap\" class=\"postbody\"><img src=\"". html_style_image('thread_options.png') ."\" alt=\"", gettext("Edit Thread Options"), "\" title=\"", gettext("Edit Thread Options"), "\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>", gettext("Edit Thread Options"), "</b></a></td>\n";

    } else {

        echo "    <td width=\"33%\" align=\"center\" style=\"white-space: nowrap\" class=\"postbody\"><img src=\"". html_style_image('thread_options.png') ."\" alt=\"", gettext("Undelete Thread"), "\" title=\"", gettext("Undelete Thread"), "\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>", gettext("Undelete Thread"), "</b></a></td>\n";
    }

} else {

    echo "    <td width=\"33%\" align=\"center\" class=\"postbody\">&nbsp;</td>\n";
}

if ($last_pid < $thread_data['LENGTH']) {

    $next_pid = $last_pid + 1;

    echo "    <td width=\"33%\" align=\"right\" style=\"white-space: nowrap\" class=\"postbody\">", form_quick_button("messages.php", gettext("Keep reading&hellip;"), array('msg' => "$tid.$next_pid")), "</td>\n";

} else {

    echo "    <td width=\"33%\" align=\"center\" class=\"postbody\">&nbsp;</td>\n";
}

echo "  </tr>\n";

if (session::logged_in()) {

    echo "  <tr>\n";
    echo "    <td colspan=\"3\" align=\"center\" class=\"postbody\"><img src=\"". html_style_image('quickreplyall.png') ."\" alt=\"", gettext("Quick Reply to All"), "\" title=\"", gettext("Quick Reply to All"), "\" border=\"0\" /> <a href=\"javascript:void(0)\" target=\"_self\" data-msg=\"$tid.0\" class=\"quick_reply_link\"><b>", gettext("Quick Reply to All"), "</b></a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td colspan=\"3\">\n";
    echo "      <div align=\"center\">\n";
    echo "        <div id=\"quick_reply_0\"></div>\n";
    echo "      </div>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

messages_start_panel();

messages_nav_strip($tid, $pid, $thread_data['LENGTH'], $posts_per_page);

if ($thread_data['POLL_FLAG'] == 'Y') {

    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"center\">\n";
    echo "                  <a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" class=\"popup 800x600\">", gettext("View Results"), "</a>\n";
    echo "                </td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
}

messages_interest_form($tid, $pid, $thread_data['INTEREST']);

messages_fontsize_form($tid, $pid);

draw_beehive_bar();

messages_end_panel();

messages_forum_stats($tid, $pid);

html_draw_bottom();

?>