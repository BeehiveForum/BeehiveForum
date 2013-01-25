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

// Required includes
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'search.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';
// End Required includes

function messages_get($tid, $pid = 1, $limit = 1)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!is_numeric($limit)) return false;

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql.= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, POST.EDITED_BY, POST.IPADDRESS, ";
    $sql.= "POST.MOVED_TID, POST.MOVED_PID, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql.= "POST.APPROVED_BY, USER.LOGON AS FROM_LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS FROM_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP AS RELATIONSHIP, USER_PREFS_GLOBAL.ANON_LOGON, ";
    $sql.= "COALESCE(USER_PREFS_FORUM.AVATAR_URL, USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, ";
    $sql.= "COALESCE(USER_PREFS_FORUM.AVATAR_AID, USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID, ";
    $sql.= "(SELECT MAX(SESSIONS.TIME) FROM SESSIONS WHERE SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND SESSIONS.FID = $forum_fid AND SESSIONS.UID = POST.FROM_UID) AS USER_ACTIVE ";
    $sql.= "FROM `{$table_prefix}POST` POST LEFT JOIN USER ON (POST.FROM_UID = USER.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = '{$_SESSION['UID']}' ";
    $sql.= "AND USER_PEER.PEER_UID = POST.FROM_UID) LEFT JOIN `{$table_prefix}USER_PREFS` ";
    $sql.= "USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = POST.FROM_UID) LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $sql.= "ON (USER_PREFS_GLOBAL.UID = POST.FROM_UID) WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql.= "ORDER BY POST.PID LIMIT 0, $limit";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $messages_array = array();

    while (($message = $result->fetch_assoc()) !== null) {

        $message['CONTENT'] = "";

        $message['ATTACHMENTS'] = array();

        $message['RECIPIENTS'] = array();

        if (!isset($message['VIEWED'])) $message['VIEWED'] = 0;

        if (!isset($message['APPROVED'])) $message['APPROVED'] = 0;
        if (!isset($message['APPROVED_BY'])) $message['APPROVED_BY'] = 0;

        if (!isset($message['EDITED'])) $message['EDITED'] = 0;
        if (!isset($message['EDITED_BY'])) $message['EDITED_BY'] = 0;

        if (!isset($message['IPADDRESS'])) $message['IPADDRESS'] = "";

        if (!isset($message['FROM_RELATIONSHIP'])) $message['FROM_RELATIONSHIP'] = 0;

        if (!isset($message['FROM_NICKNAME'])) $message['FROM_NICKNAME'] = gettext("Unknown user");
        if (!isset($message['FROM_LOGON'])) $message['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($message['FROM_UID'])) $message['FROM_UID'] = -1;

        if (!isset($message['MOVED_TID'])) $message['MOVED_TID'] = 0;
        if (!isset($message['MOVED_PID'])) $message['MOVED_PID'] = 0;

        $messages_array[$message['PID']] = $message;
    }

    messages_get_recipients($tid, $messages_array);

    messages_have_attachments($tid, $messages_array);

    return ($limit > 1) ? $messages_array : array_shift($messages_array);
}

function message_get_content($tid, $pid)
{
    static $message_content = array();

    if (!$db = db::get()) return '';

    if (!is_numeric($tid)) return '';
    if (!is_numeric($pid)) return '';

    if (!($table_prefix = get_table_prefix())) return '';

    if (!isset($message_content["$tid.$pid"])) {

        $sql = "SELECT CONTENT FROM `{$table_prefix}POST_CONTENT` ";
        $sql.= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

        if (!($result = $db->query($sql))) return '';

        if ($result->num_rows < 1) return '';

        list($message_content["$tid.$pid"]) = $result->fetch_row();
    }

    return $message_content["$tid.$pid"];
}

function messages_get_recipients($tid, &$messages_array)
{
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;

    if (sizeof($messages_array) < 1) return false;

    $pid_list = implode("','", array_keys($messages_array));

    $sql = "SELECT POST_RECIPIENT.PID, POST_RECIPIENT.TO_UID, USER_PEER.RELATIONSHIP, ";
    $sql.= "UNIX_TIMESTAMP(POST_RECIPIENT.VIEWED) AS VIEWED, ";
    $sql.= "USER.LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS NICKNAME ";
    $sql.= "FROM `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT LEFT JOIN USER ";
    $sql.= "ON (USER.UID = POST_RECIPIENT.TO_UID) LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.UID = '{$_SESSION['UID']}' AND USER_PEER.PEER_UID = POST_RECIPIENT.TO_UID) ";
    $sql.= "WHERE POST_RECIPIENT.TID = '$tid' AND POST_RECIPIENT.PID IN ('$pid_list')";

    if (!($result = $db->query($sql))) return false;

    while (($recipient_data = $result->fetch_assoc()) !== null) {

        if (!isset($messages_array[$recipient_data['PID']]['RECIPIENTS'])) {
            $messages_array[$recipient_data['PID']]['RECIPIENTS'] = array();
        }

        $messages_array[$recipient_data['PID']]['RECIPIENTS'][] = array(
            'UID' => $recipient_data['TO_UID'],
            'LOGON' => $recipient_data['LOGON'],
            'NICKNAME' => $recipient_data['NICKNAME'],
            'VIEWED' => $recipient_data['VIEWED'],
        );
    }

    return true;
}

function messages_have_attachments($tid, &$messages_array)
{
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;

    if (sizeof($messages_array) < 1) return false;

    $pid_list = implode("','", array_keys($messages_array));

    $sql = "SELECT PAI.PID, PAF.HASH FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "INNER JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.TID = '$tid' ";
    $sql.= "AND PAI.PID IN ('$pid_list')";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {
        $messages_array[$attachment_data['PID']]['ATTACHMENTS'][] = $attachment_data['HASH'];
    }

    return true;
}

function message_get_meta_content($msg, &$meta_keywords, &$meta_description)
{
    if (!validate_msg($msg)) return;

    list($tid, $pid) = explode('.', $msg);

    if (($thread_data = thread_get($tid)) && ($message_content = message_get_content($tid, $pid))) {

        $meta_keywords_array = search_extract_keywords(strip_tags(htmlentities_decode_array($message_content)));

        $meta_description = $thread_data['TITLE'];

        $meta_keywords = htmlentities_array(implode(',', $meta_keywords_array['keywords_array']));
    }
}

function message_apply_formatting($message, $ignore_sig = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $message_parts = preg_split('/(<[^>]+>)/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

    $signature_parts = array();

    if (($signature_offset = array_search("<div class=\"sig\">", $message_parts)) !== false) {

        while (sizeof($message_parts) > 0) {

            $signature_parts = array_merge($signature_parts, array_splice($message_parts, $signature_offset, 1));
            if (count(explode('<div', implode('', $signature_parts))) == count(explode('</div>', implode('', $signature_parts)))) break;
        }
    }

    $signature = implode('', $signature_parts);

    $message = implode('', $message_parts);

    $enable_wiki_words = forum_get_setting('enable_wiki_integration', 'Y') && isset($_SESSION['ENABLE_WIKI_WORDS']) && ($_SESSION['ENABLE_WIKI_WORDS'] == 'Y');

    $enable_wiki_links = forum_get_setting('enable_wiki_quick_links', 'Y');

    if (($wiki_location = forum_get_setting('wiki_integration_uri')) !== false) {
        $wiki_location = str_replace("[WikiWord]", "\\1", $wiki_location);
    }

    if ($enable_wiki_words || $enable_wiki_links) {

        $message_parts = preg_split('/([<|>])/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 4) && (!isset($message_parts[$i - 2]) || !strstr($message_parts[$i - 2], "href"))) {

                if ($enable_wiki_words && $wiki_location) {

                    $message_parts[$i] = preg_replace(
                        '/\b(([A-Z][a-z]+){2,})\b/u',
                        "<a href=\"$wiki_location\" class=\"wikiword\">\\1</a>",
                        $message_parts[$i]
                    );
                }

                if ($enable_wiki_links) {

                    if (defined('BEEHIVEMODE_LIGHT')) {

                        $message_parts[$i] = preg_replace(
                            '/\b(msg:([0-9]{1,}\.[0-9]{1,}))\b/iu',
                            "<a href=\"lmessages.php?webtag=$webtag&amp;msg=\\2\" class=\"wikiword\">\\1</a>",
                            $message_parts[$i]
                        );

                    } else {

                        $message_parts[$i] = preg_replace(
                            '/\b(msg:([0-9]{1,}\.[0-9]{1,}))\b/iu',
                            "<a href=\"index.php?webtag=$webtag&amp;msg=\\2\" target=\"_blank\" class=\"wikiword\">\\1</a>",
                            $message_parts[$i]
                        );

                        $message_parts[$i] = preg_replace(
                            '/\b(user:([a-z0-9_-]{2,15}))\b/iu',
                            "<a href=\"user_profile.php?webtag=$webtag&amp;logon=\\2\" target=\"_blank\" class=\"wikiword popup 650x500\">\\1</a>",
                            $message_parts[$i]
                        );
                    }
                }
            }
        }

        $message = implode('', $message_parts);
    }

    $message = emoticons_apply($message);

    if (!$ignore_sig) {
        $message.= emoticons_apply($signature);
    }

    return $message;
}

function messages_top($tid, $pid, $folder_fid, $folder_title, $thread_title, $thread_interest_level = THREAD_NOINTEREST, $folder_interest_level = FOLDER_NOINTEREST, $sticky = "N", $closed = false, $locked = false, $deleted = false, $frame_links = true, $highlight_array = array())
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $frame_top_target = html_get_top_frame_name();

    if (is_array($highlight_array) && sizeof($highlight_array) > 0) {

        $highlight_pattern = array();
        $highlight_replace = array();

        foreach ($highlight_array as $key => $word) {

            $highlight_word = preg_quote($word, "/");

            $highlight_pattern[$key] = "/($highlight_word)/iu";
            $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
        }

        $thread_parts = preg_split('/([<|>])/u', $thread_title, -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($thread_parts); $i++) {

            if (!($i % 4)) {

                $thread_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $thread_parts[$i], 1);
            }
        }

        $thread_title = implode('', $thread_parts);
    }

    if ($folder_interest_level == FOLDER_SUBSCRIBED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".html_style_image('folder_subscribed.png')."\" alt=\"", gettext("Subscribed Folder"), "\" title=\"", gettext("Subscribed Folder"), "\" border=\"0\" /></a>&nbsp;";
    } else if ($folder_interest_level == FOLDER_IGNORED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".html_style_image('folder_ignored.png')."\" alt=\"", gettext("Ignored Folder"), "\" title=\"", gettext("Ignored Folder"), "\" border=\"0\" /></a>&nbsp;";
    } else {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".html_style_image('folder.png')."\" alt=\"", gettext("Folder"), "\" title=\"", gettext("Folder"), "\" border=\"0\" /></a>&nbsp;";
    }

    if ($frame_links) {

        echo "<a href=\"index.php?webtag=$webtag&amp;folder=$folder_fid\" target=\"$frame_top_target\">", word_filter_add_ob_tags($folder_title, true), "</a>";
        echo "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />";
        echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"$frame_top_target\" title=\"", gettext("View in Frameset"), "\">", word_filter_add_ob_tags($thread_title, true), "</a>";

    } else {

        echo word_filter_add_ob_tags($folder_title, true), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" />", word_filter_add_ob_tags($thread_title, true);
    }

    if ($closed) echo "&nbsp;<img src=\"", html_style_image('thread_closed.png'), "\" alt=\"", gettext("Closed"), "\" title=\"", gettext("Closed"), "\" />\n";
    if ($thread_interest_level == THREAD_INTERESTED) echo "&nbsp;<img src=\"", html_style_image('high_interest.png'), "\" alt=\"", gettext("High Interest"), "\" title=\"", gettext("High Interest"), "\" />";
    if ($thread_interest_level == THREAD_SUBSCRIBED) echo "&nbsp;<img src=\"", html_style_image('subscribe.png'), "\" alt=\"", gettext("Subscribed"), "\" title=\"", gettext("Subscribed"), "\" />";
    if ($sticky == "Y") echo "&nbsp;<img src=\"", html_style_image('sticky.png'), "\" alt=\"", gettext("Sticky"), "\" title=\"", gettext("Sticky"), "\" />";
    if ($locked) echo "&nbsp;<img src=\"", html_style_image('admin_locked.png'), "\" alt=\"", gettext("Locked"), "\" title=\"", gettext("Locked"), "\" />\n";
    if ($deleted) echo "&nbsp;<img src=\"", html_style_image('delete.png'), "\" alt=\"", gettext("Deleted"), "\" title=\"", gettext("Deleted"), "\" />\n";

    echo "</p>";
}

function messages_social_links($tid)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (forum_get_setting('show_share_links', 'Y') && isset($_SESSION['SHOW_SHARE_LINKS']) && ($_SESSION['SHOW_SHARE_LINKS'] == 'Y')) {

        echo "      <div style=\"display: inline-block; vertical-align: middle; margin-top: 1px\">\n";
        echo "        <g:plusone size=\"small\" count=\"false\" href=\"",  htmlentities_array(html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.1")), "\"></g:plusone>\n";
        echo "      </div>\n";
        echo "      <div style=\"display: inline-block; width: 47px; vertical-align: middle; margin-top: 2px; overflow: hidden\">\n";
        echo "        <iframe src=\"http://www.facebook.com/plugins/like.php?href=", urlencode(html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.1")), "&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:21px;\" allowTransparency=\"true\"></iframe>\n";
        echo "      </div>\n";
        echo "      <div style=\"display: inline-block; width: 58px; vertical-align: middle; overflow: hidden\">\n";
        echo "        <a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"", htmlentities_array(html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.1")), "\" data-count=\"none\">Tweet</a>\n";
        echo "      </div>\n";

    } else {

        echo "&nbsp;";
    }
}

function messages_bottom()
{
    echo "<p align=\"right\">Beehive Forum 2002</p>\n";
}

function message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $perm_is_moderator = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    $post_edit_grace_period = forum_get_setting('post_edit_grace_period', null, 0);

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($_SESSION['POSTS_PER_PAGE']) && is_numeric($_SESSION['POSTS_PER_PAGE'])) {
        $posts_per_page = max(min($_SESSION['POSTS_PER_PAGE'], 30), 10);
    } else {
        $posts_per_page = 20;
    }

    if (isset($_SESSION['REPLY_QUICK']) && ($_SESSION['REPLY_QUICK'] == 'Y')) {
        $quick_reply = 'Y';
    } else {
        $quick_reply = 'N';
    }

    if ((!isset($message['CONTENT']) || $message['CONTENT'] == "") && !$is_preview) {

        message_display_deleted($tid, isset($message['PID']) ? $message['PID'] : 0, $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    $from_user_permissions = perm_get_user_permissions($message['FROM_UID']);

    if ($_SESSION['UID'] != $message['FROM_UID']) {

        if (($from_user_permissions & USER_PERM_WORMED) && !$perm_is_moderator) {

            message_display_deleted($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
            return;
        }
    }

    if (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

        message_display_deleted($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) == 1) {

        $recipient = array_slice(array_values($message['RECIPIENTS']), 0, 1);

        if (isset($recipient['RELATIONSHIP']) && ($recipient['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

            message_display_deleted($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
            return;
        }
    }

    // Add emoticons/WikiLinks and ignore signature ----------------------------
    if (isset($_SESSION['IMAGES_TO_LINKS']) && ($_SESSION['IMAGES_TO_LINKS'] == 'Y')) {

        $message['CONTENT'] = preg_replace('/<a([^>]*)href="([^"]*)"([^\>]*)><img[^>]*src="([^"]*)"[^>]*><\/a>/iu', '[href: <a\1href="\2"\3>\2</a>][img: <a\1href="\4"\3>\4</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<img[^>]*src="([^"]*)"[^>]*>/iu', '[img: <a href="\1">\1</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<embed[^>]*src="([^"]*)"[^>]*>/iu', '[object: <a href="\1">\1</a>]', $message['CONTENT']);
    }

    if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = message_apply_formatting($message['CONTENT'], (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG)) || !$show_sigs);
    }

    // Check length of post to see if we should truncate it for display --------
    if ((mb_strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', null, 6226))) && $limit_text) {

        $cut_msg = mb_substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', null, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/Du", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg);
        $message['CONTENT'].= "&hellip;[". gettext("Message Truncated"). "]\n<p align=\"center\"><a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">". gettext("View full message"). "</a>";
    }

    // Check for words that should be filtered ---------------------------------
    if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT'], false);
    }

    if ($in_list && isset($message['PID'])) {
        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>\n";
    }

    // Check for search words to highlight -------------------------------------
    if (is_array($highlight_array) && sizeof($highlight_array) > 0) {

        $highlight_pattern = array();
        $highlight_replace = array();

        foreach ($highlight_array as $key => $word) {

            $highlight_word = preg_quote($word, "/");

            $highlight_pattern[$key] = "/($highlight_word)/iu";
            $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
        }

        $message_parts = preg_split('/([<|>])/u', $message['CONTENT'], -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 4)) {

                $message_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $message_parts[$i], 1);
            }
        }

        $message['CONTENT'] = implode("", $message_parts);
    }

    // Little up/down arrows to the left of each message -----------------------
    if (forum_get_setting('require_post_approval', 'Y') && $message['FROM_UID'] != $_SESSION['UID']) {

        if (isset($message['APPROVED']) && $message['APPROVED'] == 0 && !$perm_is_moderator) {

            message_display_approval_req($tid, $message['PID'], $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
            return;
        }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------
    if (!$is_preview && ($message['MOVED_TID'] > 0) && ($message['MOVED_PID'] > 0)) {

        $post_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_self\">%s</a>";
        $post_link = sprintf($post_link, $message['MOVED_TID'], $message['MOVED_PID'], gettext("here"));

        echo "<div align=\"center\">\n";
        echo "<table class=\"thread_track_notice\" width=\"96%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\">", sprintf(gettext("<b>Thread Split:</b> This post has been moved %s"), $post_link), "</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        echo  ($in_list) ? "<br />\n" : '';
        return;
    }

    echo "<div align=\"center\">\n";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $message['PID'], $first_msg, $msg_count, $posts_per_page);

    echo "    <td align=\"center\">\n";
    echo "      <table width=\"100%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("From"), ":&nbsp;</span></td>\n";
    echo "                <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if ($message['FROM_UID'] > -1) {

        echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "</a></span>";

    } else {

        echo word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "</span>";
    }

    if (isset($_SESSION['SHOW_AVATARS']) && ($_SESSION['SHOW_AVATARS'] == 'Y')) {

        if (isset($message['AVATAR_URL']) && strlen($message['AVATAR_URL']) > 0) {

            echo "&nbsp;<img src=\"{$message['AVATAR_URL']}\" alt=\"\" title=\"", word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "\" border=\"0\" width=\"16\" height=\"16\" />";

        } else if (isset($message['AVATAR_AID']) && is_numeric($message['AVATAR_AID'])) {

            $attachment = attachments_get_by_aid($message['AVATAR_AID']);

            if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false)) !== false) {

                echo "&nbsp;<img src=\"$profile_picture_href&amp;avatar_picture\" alt=\"\" title=\"", word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "\" border=\"0\" width=\"16\" height=\"16\" />\n";
            }
        }
    }

    $temp_ignore = false;

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && isset($message['PID']) && $message['PID'] == 1 && (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED))) {

        $message['FROM_RELATIONSHIP']-= USER_IGNORED;
        $temp_ignore = true;
    }

    if (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_FRIEND)) {

        echo "&nbsp;<img src=\"", html_style_image('friend.png'), "\" alt=\"", gettext("Friend"), "\" title=\"", gettext("Friend"), "\" />";

    } else if ((isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) || $temp_ignore) {

        echo "&nbsp;<img src=\"", html_style_image('enemy.png'), "\" alt=\"", gettext("Ignored user"), "\" title=\"", gettext("Ignored user"), "\" />";
    }

    echo "</td>\n";
    echo "                <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">";

    if (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $_SESSION['UID'] > 0) {

        echo "<b>", gettext("Ignored message"), "</b>";

    } else {

        if ($in_list) {

            if ($from_user_permissions & USER_PERM_WORMED) echo "<b>", gettext("Wormed user"), "</b> ";
            if (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG)) echo "<b>", gettext("Ignored signature"), "</b> ";
            if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] == 0) echo "<b>", gettext("Approval Required"), "</b> ";

            echo format_time($message['CREATED']);
        }
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
    echo "                <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) > 0) {

        foreach ($message['RECIPIENTS'] as $recipient) {

            if (isset($recipient['RELATIONSHIP']) && ($recipient['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {
                continue;
            }

            echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$recipient['UID']}\" target=\"_blank\" class=\"popup 650x500\">";
            echo word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</a>\n";

            if (isset($recipient['VIEWED']) && $recipient['VIEWED'] > 0) {

                echo "<span class=\"smalltext\"><img src=\"", html_style_image('post_read.png'), "\" alt=\"\" title=\"", sprintf(gettext("Read: %s"), format_time($recipient['VIEWED'])), "\" /></span>\n";

            } else {

                if ($is_preview == false) {

                    echo "<span class=\"smalltext\"><img src=\"", html_style_image('post_unread.png'), "\" alt=\"\" title=\"", gettext("Unread Message"), "\" /></span>\n";
                }
            }
        }

    } else {

        echo gettext('ALL');
    }

    echo "</span></td>\n";
    echo "                <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">";

    if (isset($message['FROM_RELATIONSHIP']) && ($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $in_list && $_SESSION['UID'] > 0) {

        echo "<a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">", gettext("Stop ignoring this user"), "</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">", gettext("View Message"), "</a>";

    } else if ($in_list && $msg_count > 0) {

        if ($is_poll) {

            echo "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" class=\"popup 800x600\"><img src=\"", html_style_image('poll.png'), "\" border=\"0\" alt=\"", gettext("This is a poll. Click to view results."), "\" title=\"", gettext("This is a poll. Click to view results."), "\" /></a> ", gettext("Poll"), " ";
        }

        echo sprintf(gettext("%s of %s"), $message['PID'], $msg_count);
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";

    if ((isset($message['FROM_RELATIONSHIP']) && !($message['FROM_RELATIONSHIP'] & USER_IGNORED)) || !$limit_text) {

        echo "        <tr>\n";
        echo "          <td align=\"left\">\n";
        echo "            <table width=\"100%\">\n";
        echo "              <tr>\n";
        echo "                <td colspan=\"3\" align=\"right\"><span class=\"postnumber\">";

        if ($in_list && $msg_count > 0) {

            $title = ($message['PID'] ==1) ? "". gettext("Permanent link to this thread"). " ($tid.1)" : "". gettext("Link to this post");

            if ($is_preview) {

                echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_blank\" title=\"$title\">$tid.{$message['PID']}</a>";

            } else {

                echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"", html_get_top_frame_name(), "\" title=\"$title\">$tid.{$message['PID']}</a>";
            }

            if ($message['REPLY_TO_PID'] > 0) {

                $title = "". gettext("Link to post"). " #{$message['REPLY_TO_PID']}";

                echo " ", gettext("In reply to"), " ";

                if (intval($message['REPLY_TO_PID']) >= intval($first_msg)) {

                    echo "<a href=\"#a{$tid}_{$message['REPLY_TO_PID']}\" target=\"_self\" title=\"$title\">";
                    echo "{$tid}.{$message['REPLY_TO_PID']}</a>";

                } else {

                    if ($is_preview) {

                        echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$message['REPLY_TO_PID']}\" target=\"_blank\" title=\"$title\">";
                        echo "{$tid}.{$message['REPLY_TO_PID']}</a>";

                    } else {

                        echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$message['REPLY_TO_PID']}\" target=\"_self\" title=\"$title\">";
                        echo "{$tid}.{$message['REPLY_TO_PID']}</a>";
                    }
                }
            }
        }

        echo "&nbsp;</span></td>\n";
        echo "              </tr>\n";
        echo "              <tr>\n";
        echo "                <td class=\"postbody postcontent\" align=\"left\">{$message['CONTENT']}</td>\n";
        echo "              </tr>\n";

        if (isset($message['EDITED']) && $message['EDITED'] > 0) {

            if (($post_edit_grace_period == 0) || ($message['EDITED'] - $message['CREATED']) > ($post_edit_grace_period * MINUTE_IN_SECONDS)) {

                if (($edit_user = user_get_logon($message['EDITED_BY'])) !== false) {

                    echo "              <tr>\n";
                    echo "                <td class=\"postbody\" align=\"left\"><p class=\"edit_text\">", sprintf(gettext("EDITED: %s by %s"), format_time($message['EDITED']), $edit_user), "</p></td>\n";
                    echo "              </tr>\n";
                }
            }
        }

        if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] > 0 && $perm_is_moderator) {

            if (isset($message['APPROVED_BY']) && $message['APPROVED_BY'] > 0 && $message['APPROVED_BY'] != $message['FROM_UID']) {

                if (($approved_user = user_get_logon($message['APPROVED_BY'])) !== false) {

                    echo "              <tr>\n";
                    echo "                <td class=\"postbody\" align=\"left\"><p class=\"approved_text\">", sprintf(gettext("APPROVED: %s by %s"), format_time($message['APPROVED']), $approved_user), "</p></td>\n";
                    echo "              </tr>\n";
                }
            }
        }

        if (isset($message['ATTACHMENTS']) && sizeof($message['ATTACHMENTS']) > 0) {

            if (($attachments_array = attachments_get($message['FROM_UID'], ATTACHMENT_FILTER_BOTH, $message['ATTACHMENTS'])) !== false) {

                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\">\n";
                echo "                  <p><b>", gettext("Attachments"), ":</b><br />\n";

                foreach ($attachments_array as $attachment) {
                    echo attachments_make_link($attachment), ($attachment['thumbnail'] == 'N') ? "<br />\n" : "\n";
                }

                echo "                  </p>\n";
                echo "                </td>\n";
                echo "              </tr>\n";
            }
        }

        echo "            </table>\n";

        if (!$is_preview) {

            echo "            <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
            echo "              <tr>\n";

            if ((isset($message['ANON_LOGON']) && $message['ANON_LOGON'] > USER_ANON_DISABLED) || !isset($message['USER_ACTIVE']) || is_null($message['USER_ACTIVE'])) {

                echo "                <td width=\"25%\" align=\"left\">";
                echo "                  <img src=\"", html_style_image('status_offline.png'), "\" alt=\"\" title=\"", gettext("Inactive / Offline"), "\" />";
                echo "                </td>\n";

            } else {

                echo "                <td width=\"25%\" align=\"left\">";
                echo "                  <img src=\"", html_style_image('status_online.png'), "\" alt=\"\" title=\"", gettext("Online"), "\" />";
                echo "                </td>\n";
            }

            echo "                <td width=\"50%\" style=\"white-space: nowrap\">";

            if ($msg_count > 0) {

                if ((!$closed && session::check_perm(USER_PERM_POST_CREATE, $folder_fid)) || $perm_is_moderator) {

                    if ($quick_reply =='Y') {

                        echo "<img src=\"", html_style_image('quickreply.png'), "\" border=\"0\" alt=\"", gettext("Quick Reply"), "\" title=\"", gettext("Quick Reply"), "\" />\n";
                        echo "<a href=\"Javascript:void(0)\" data-msg=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">", gettext("Quick Reply"), "</a>\n";

                    } else {

                        echo "<img src=\"", html_style_image('post.png'), "\" border=\"0\" alt=\"", gettext("Reply"), "\" title=\"", gettext("Reply"), "\" />";
                        echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\" id=\"reply_{$message['PID']}\">", gettext("Reply"), "</a>";
                    }

                    echo "&nbsp;&nbsp;<img src=\"", html_style_image('quote_disabled.png'), "\" border=\"0\" alt=\"", gettext("Quote"), "\" title=\"", gettext("Quote"), "\" id=\"quote_img_{$message['PID']}\" />";
                    echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}&amp;quote_list={$message['PID']}\" target=\"_parent\" title=\"", gettext("Quote"), "\" id=\"quote_{$message['PID']}\" data-pid=\"{$message['PID']}\">", gettext("Quote"), "</a>";

                    if ((!(session::check_perm(USER_PERM_PILLORIED, 0)) && ((($_SESSION['UID'] != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($_SESSION['UID'] == $message['FROM_UID'])) && session::check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

                        if ($is_poll && $message['PID'] == 1) {

                            if (!poll_is_closed($tid) || $perm_is_moderator) {

                                echo "&nbsp;&nbsp;<img src=\"", html_style_image('edit.png'), "\" border=\"0\" alt=\"", gettext("Edit Poll"), "\" title=\"", gettext("Edit Poll"), "\" />";
                                echo "&nbsp;<a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">", gettext("Edit Poll"), "</a>\n";
                            }

                        } else {

                            echo "&nbsp;&nbsp;<img src=\"", html_style_image('edit.png'), "\" border=\"0\" alt=\"", gettext("Edit"), "\" title=\"", gettext("Edit"), "\" />";
                            echo "&nbsp;<a href=\"edit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">", gettext("Edit"), "</a>";
                        }
                    }
                }

            } else {

                echo "&nbsp;";
            }

            echo "</td>\n";
            echo "                <td width=\"25%\" align=\"right\" style=\"white-space: nowrap\">\n";
            echo "                  <span class=\"post_options\" id=\"post_options_$tid.{$message['PID']}\"></span>\n";
            echo "                </td>\n";
            echo "              </tr>";
            echo "            </table>\n";

        } else {

            echo "            <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
            echo "              <tr>\n";
            echo "                <td>&nbsp;</td>\n";
            echo "              </tr>\n";
            echo "            </table>\n";
        }
    }

    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $message['PID'], $first_msg, $msg_count, $posts_per_page);

    echo "    </tr>\n";
    echo "  </table>\n";

    if ($in_list && isset($message['PID'])) {
        echo "  <div id=\"quick_reply_{$message['PID']}\"></div>\n";
    }

    echo "</div>\n";
    echo  ($in_list) ? "<br />\n" : '';
}

function message_get_post_options_html($tid, $pid, $folder_fid)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (($message = messages_get($tid, $pid, 1)) === false) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $perm_is_moderator = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);
    $perm_has_admin_access = session::check_perm(USER_PERM_ADMIN_TOOLS, 0);

    if (isset($_SESSION['REPLY_QUICK']) && ($_SESSION['REPLY_QUICK'] == 'Y')) {
        $quick_reply = 'Y';
    } else {
        $quick_reply = 'N';
    }

    $html = "<div class=\"post_options_container\">\n";
    $html.= "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    $html.= "    <tr>\n";
    $html.= "      <td align=\"left\" colspan=\"3\">\n";
    $html.= "        <table class=\"box\" width=\"100%\">\n";
    $html.= "          <tr>\n";
    $html.= "            <td align=\"left\" class=\"posthead\">\n";
    $html.= "              <table class=\"posthead\" width=\"100%\">\n";
    $html.= "                <tr>\n";
    $html.= "                  <td class=\"subhead\" colspan=\"2\">". gettext("Post Options"). "</td>\n";
    $html.= "                </tr>\n";
    $html.= "                <tr>\n";
    $html.= "                  <td align=\"center\">\n";
    $html.= "                    <table width=\"95%\" class=\"post_options_menu\">\n";
    $html.= "                      <tr>\n";

    if ($quick_reply=='N') {

        $html.= "                        <td align=\"left\"><a href=\"Javascript:void(0)\" data-msg=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\"><img src=\"". html_style_image('quickreply.png'). "\" border=\"0\" alt=\"". gettext("Quick Reply"). "\" title=\"". gettext("Quick Reply"). "\" /></a></td>\n";
        $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"Javascript:void(0)\" data-msg=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">". gettext("Quick Reply"). "</a></td>\n";

    } else {

        $html.= "                        <td align=\"left\"><img src=\"". html_style_image('post.png'). "\" border=\"0\" alt=\"". gettext("Reply"). "\" title=\"". gettext("Reply"). "\" /></td>\n";
        $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\" id=\"reply_{$message['PID']}\">". gettext("Reply"). "</a></td>\n";
    }

    $html.= "                      </tr>\n";

    if (($_SESSION['UID'] == $message['FROM_UID'] && session::check_perm(USER_PERM_POST_DELETE, $folder_fid) && !session::check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

        $html.= "                      <tr>\n";
        $html.= "                        <td align=\"left\"><a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\"><img src=\"". html_style_image('delete.png'). "\" border=\"0\" alt=\"". gettext("Delete"). "\" title=\"". gettext("Delete"). "\" /></a></td>\n";
        $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">". gettext("Delete"). "</a></td>\n";
        $html.= "                      </tr>\n";
    }

    $html.= "                      <tr>\n";
    $html.= "                        <td align=\"left\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"". gettext("Reply as PM"). "\"><img src=\"". html_style_image('pmunread.png'). "\" border=\"0\" alt=\"". gettext("Reply as PM"). "\" title=\"". gettext("Reply as PM"). "\" /></a></td>\n";
    $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"". gettext("Reply as PM"). "\">". gettext("Reply as PM"). "</a></td>\n";
    $html.= "                      </tr>\n";
    $html.= "                      <tr>\n";
    $html.= "                        <td align=\"left\"><a href=\"display.php?webtag=$webtag&amp;print_msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Print"). "\"><img src=\"". html_style_image('print.png'). "\" border=\"0\" alt=\"". gettext("Print"). "\" title=\"". gettext("Print"). "\" /></a></td>\n";
    $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"display.php?webtag=$webtag&amp;print_msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Print"). "\">". gettext("Print"). "</a></td>\n";
    $html.= "                      </tr>\n";
    $html.= "                      <tr>\n";
    $html.= "                        <td align=\"left\"><a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&amp;markasread=". ($message['PID'] - 1). "\" target=\"_self\" title=\"". gettext("Mark as unread"). "\"><img src=\"". html_style_image('markasunread.png'). "\" border=\"0\" alt=\"". gettext("Mark as unread"). "\" title=\"". gettext("Mark as unread"). "\" /></a></td>\n";
    $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&amp;markasread=". ($message['PID'] - 1). "\" target=\"_self\" title=\"". gettext("Mark as unread"). "\">". gettext("Mark as unread"). "</a></td>\n";
    $html.= "                      </tr>\n";

    if ($_SESSION['UID'] != $message['FROM_UID']) {

        $html.= "                      <tr>\n";
        $html.= "                        <td align=\"left\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Relationship"). "\"><img src=\"". html_style_image('enemy.png'). "\" border=\"0\" alt=\"". gettext("Relationship"). "\" title=\"". gettext("Relationship"). "\" /></a></td>\n";
        $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Relationship"). "\">". gettext("Relationship"). "</a></td>\n";
        $html.= "                      </tr>\n";
    }

    if ($perm_has_admin_access) {

        $html.= "                      <tr>\n";
        $html.= "                        <td align=\"left\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Privileges"). "\"><img src=\"". html_style_image('admintool.png'). "\" border=\"0\" alt=\"". gettext("Privileges"). "\" title=\"". gettext("Privileges"). "\" /></a></td>\n";
        $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Privileges"). "\">". gettext("Privileges"). "</a></td>\n";
        $html.= "                      </tr>\n";
    }

    if ($perm_is_moderator || $perm_has_admin_access) {

        if ($perm_is_moderator) {

            if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] == 0) {

                $html.= "                      <tr>\n";
                $html.= "                        <td align=\"left\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Approve Post"). "\"><img src=\"". html_style_image('approved.png'). "\" border=\"0\" alt=\"". gettext("Approve Post"). "\" title=\"". gettext("Approve Post"). "\" /></a></td>\n";
                $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D$tid.{$message['PID']}\" target=\"_self\" title=\"". gettext("Approve Post"). "\">". gettext("Approve Post"). "</a></td>\n";
                $html.= "                      </tr>\n";
            }
        }

        if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

            $html.= "                      <tr>\n";
            $html.= "                        <td align=\"left\"><span class=\"adminipdisplay\"><b>". gettext("IP"). "</b></span></td>\n";
            $html.= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$message['IPADDRESS']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">". gettext("Ban IP Address"). "</a></td>\n";
            $html.= "                      </tr>";

        } else {

            $html.= "                      <tr>\n";
            $html.= "                        <td align=\"left\"><span class=\"adminipdisplay\"><b>". gettext("IP"). "</b></span></td>\n";
            $html.= "                        <td align=\"left\" style=\"white-space: nowrap\">". gettext("Not Logged"). "</td>\n";
            $html.= "                      </tr>";
        }
    }

    $html.= "                    </table>\n";
    $html.= "                  </td>\n";
    $html.= "                </tr>\n";
    $html.= "              </table>\n";
    $html.= "            </td>\n";
    $html.= "          </tr>\n";
    $html.= "        </table>\n";
    $html.= "      </td>\n";
    $html.= "    </tr>\n";
    $html.= "  </table>\n";
    $html.= "</div>\n";

    return $html;
}

function message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "    <td align=\"left\" width=\"2%\" valign=\"top\">\n";
    echo "      <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"center\">\n";

    if ($pid > 1) {

        if (($pid - 1) < $first_msg) {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.", $pid - 1, "\" target=\"_self\">";
            echo "<img src=\"", html_style_image("message_up.png"), "\" border=\"0\" alt=\"", gettext("Previous"), "\" title=\"", gettext("Previous"), "\" /></a>";

        } else {

            echo "<a href=\"#a{$tid}_", $pid - 1, "\" target=\"_self\">";
            echo "<img src=\"", html_style_image("message_up.png"), "\" border=\"0\" alt=\"", gettext("Previous"), "\" title=\"", gettext("Previous"), "\" /></a>";
        }
    }

    echo "          </td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"center\">\n";

    if ($pid < $msg_count) {

        if (($pid + 1) > (($first_msg + $posts_per_page) - 1)) {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.", $pid + 1, "\" target=\"_self\">";
            echo "<img src=\"", html_style_image("message_down.png"), "\" border=\"0\" alt=\"", gettext("Next"), "\" title=\"", gettext("Next"), "\" /></a>";

        } else {

            echo "<a href=\"#a{$tid}_", $pid + 1, "\" target=\"_self\">";
            echo "<img src=\"", html_style_image("message_down.png"), "\" border=\"0\" alt=\"", gettext("Next"), "\" title=\"", gettext("Next"), "\" /></a>";
        }
    }

    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
}

function message_display_deleted($tid, $pid, $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    echo "<div align=\"center\">";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page);

    echo "    <td align=\"left\">\n";
    echo "      <table width=\"100%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";

    if (isset($message['EDITED']) && $message['EDITED'] > 0) {

        if (($edit_user = user_get_logon($message['EDITED_BY'])) !== false) {

            $message_delete_time = format_time($message['EDITED']);
            echo "                <td align=\"left\">", sprintf(gettext("Message %s.%s deleted %s by %s"), $tid, $pid, $message_delete_time, $edit_user), "</td>\n";

        } else {

            echo "                <td align=\"left\">", sprintf(gettext("Message %s.%s was deleted"), $tid, $pid), "</td>\n";
        }

    } else {

        echo "                <td align=\"left\">", sprintf(gettext("Message %s.%s was deleted"), $tid, $pid), "</td>\n";
    }

    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $message['PID'], $first_msg, $msg_count, $posts_per_page);

    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
    echo  ($in_list) ? "<br />\n" : '';
}

function message_display_approval_req($tid, $pid, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    echo "<div align=\"center\">";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page);

    echo "    <td align=\"left\">\n";
    echo "      <table width=\"100%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"left\">", sprintf(gettext("Message %s.%s is awaiting approval by a moderator"), $tid, $pid), "</td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";

    if ($in_list && !$is_preview) message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page);

    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
    echo  ($in_list) ? "<br />\n" : '';
}

function messages_start_panel()
{
    echo "<div align=\"center\">\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <table class=\"box\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"posthead\">\n";
    echo "            <br />\n";
}

function messages_end_panel()
{
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

function messages_nav_strip($tid, $pid, $length, $ppp)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if ($pid < 2 && $length < $ppp) {
        return;
    } else if ($pid < 1) {
        $pid = 1;
    }

    $c = 0;

    $spid = $pid % $ppp;

    if ($spid > 1) {

        if ($pid > 1) {

            $navbits[0] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">". mess_nav_range(1, $spid - 1). "</a>";

        } else {

            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1);
        }

        $i = 1;

    } else {

        $i = 0;
    }

    while ($spid + ($ppp - 1) < $length) {

        if ($spid == $pid) {

            $c = $i;
            $navbits[$i] = mess_nav_range($spid, $spid + ($ppp - 1));

        } else {

            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($spid == 0 ? 1 : $spid). "\" target=\"_self\">". mess_nav_range($spid == 0 ? 1 : $spid, $spid + ($ppp - 1)). "</a>";
        }

        $spid += $ppp;

        $i++;
    }

    if ($spid <= $length) {

        if ($spid == $pid) {

            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length);

        } else {

            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$spid\" target=\"_self\">". mess_nav_range($spid,$length). "</a>";
        }
    }

    $max = $i;

    $html = gettext("Show messages:");

    if ($length <= $ppp) {
        $html.= " <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">". gettext("All"). "</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max) {

                $html.= "\n&nbsp;". $navbits[$i];

            } else if (abs($c - $i) == 4) {

                $html.= "\n&nbsp;&hellip;";
            }
        }
    }

    unset($navbits);

    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"center\">$html</td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
}

function mess_nav_range($from,$to)
{
    if ($from == $to) {
        $range = sprintf("%d", $from);
    } else {
        $range = sprintf("%d-%d", $from, $to);
    }
    return $range;
}

function messages_interest_form($tid, $pid, $interest)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $interest_levels_array = array(
        THREAD_IGNORED => gettext("Ignore"),
        THREAD_NOINTEREST => gettext("Normal"),
        THREAD_INTERESTED => gettext("Interested"),
        THREAD_SUBSCRIBED => gettext("Subscribed")
    );

    echo "<table class=\"posthead\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"rate_interest\" target=\"_self\" action=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$pid\" method=\"post\">\n";
    echo "        ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "        ", gettext("Rate my interest"), ": ", form_radio_array("setinterest", $interest_levels_array, htmlentities_array($interest));
    echo "        ", form_input_hidden("tid", htmlentities_array($tid));
    echo "        ", form_submit("apply", gettext("Apply")), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
}

function message_get_recipients($tid, $pid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT USER.UID, USER.LOGON FROM USER ";
    $sql.= "INNER JOIN `{$table_prefix}POST` POST ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = '$pid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_array = array();

    while (($user_data = $result->fetch_assoc()) !== null) {
        $user_array[$user_data['UID']] = $user_data['LOGON'];
    }

    return $user_array;
}

function messages_update_read($tid, $pid, $last_read, $length, $modified)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($last_read)) return false;
    if (!is_numeric($length)) return false;
    if (!is_numeric($modified)) return false;

    // Check for existing entry in USER_THREAD
    if (!($table_prefix = get_table_prefix())) return false;

    // User UID
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    // Mark as read cut off
    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    // Guest users' can't mark as read!
    if (session::logged_in() && ($pid > $last_read)) {

        if (($unread_cutoff_timestamp !== false) && ($modified > $unread_cutoff_timestamp)) {

            $unread_cutoff_datetime = forum_get_unread_cutoff_datetime();

            // Get the last PID within the unread-cut-off.
            $sql = "SELECT COALESCE(MAX(POST.PID), 0) AS UNREAD_PID ";
            $sql.= "FROM `{$table_prefix}POST` POST ";
            $sql.= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
            $sql.= "AND POST.TID = '$tid'";

            if (!($result = $db->query($sql))) return false;

            list($unread_pid) = $result->fetch_row();

            // If the specified PID is lower than the cut-off set it to the cut-off.
            $pid = ($pid < $unread_pid) ? $unread_pid : $pid;

            // Update the unread data.
            $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT) ";
            $sql.= "VALUES ('{$_SESSION['UID']}', '$tid', '$pid', CAST('$current_datetime' AS DATETIME)) ON DUPLICATE KEY UPDATE ";
            $sql.= "LAST_READ = VALUES(LAST_READ), LAST_READ_AT = CAST('$current_datetime' AS DATETIME)";

            if (!($result = $db->query($sql))) return false;
        }
    }

    // Mark posts as Viewed
    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_RECIPIENT` SET VIEWED = CAST('$current_datetime' AS DATETIME) ";
    $sql.= "WHERE TID = '$tid' AND PID BETWEEN 1 AND '$pid' AND TO_UID = '{$_SESSION['UID']}' AND VIEWED IS NULL";

    if (!($result = $db->query($sql))) return false;

    // Update thread viewed counter
    $sql = "INSERT INTO `{$table_prefix}THREAD_STATS` ";
    $sql.= "(TID, VIEWCOUNT) VALUES ('$tid', 1) ON DUPLICATE KEY ";
    $sql.= "UPDATE VIEWCOUNT = VIEWCOUNT + 1";

    if (!($result = $db->query($sql))) return false;

    return true;
}

function messages_set_read($tid, $pid, $modified)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($modified)) return false;

    // Check for existing entry in USER_THREAD
    if (!($table_prefix = get_table_prefix())) return false;

    // User UID
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Mark as read cut off
    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    // Guest users' can't mark as read!
    if (session::logged_in()) {

        if (($unread_cutoff_timestamp !== false) && ($modified > $unread_cutoff_timestamp)) {

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_THREAD` ";
            $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NULL ";
            $sql.= "WHERE UID = '{$_SESSION['UID']}' AND TID = '$tid'";

            if (!$db->query($sql)) return false;

            if ($db->affected_rows < 1) {

                $sql = "INSERT IGNORE INTO `{$table_prefix}USER_THREAD` ";
                $sql.= "(UID, TID, LAST_READ, LAST_READ_AT) ";
                $sql.= "VALUES ({$_SESSION['UID']}, $tid, $pid, NULL)";

                if (!$db->query($sql)) return false;
            }
        }
    }

    // Mark posts as unread
    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_RECIPIENT` SET VIEWED = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID >= '$pid' AND TO_UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    return true;
}

function messages_get_most_recent($uid, $fid = false)
{
    if (!$db = db::get()) return false;

    if (is_numeric($fid)) {
        $fidlist = $fid;
    } else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_message = messages_get_most_recent_unread($uid, $fid)) !== false) {
        return $unread_message;
    }

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    $user_ignored = USER_IGNORED;

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "THREAD.LENGTH, USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD.UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' ";
    $sql.= "AND THREAD.LENGTH > 0 AND (USER_PEER.RELATIONSHIP IS NULL ";
    $sql.= "OR (USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $message_data = $result->fetch_assoc();

    if (!session::logged_in()) {

       return "{$message_data['TID']}.1";

    } else if (!isset($message_data['LAST_READ']) || !is_numeric($message_data['LAST_READ'])) {

        $message_data['LAST_READ'] = 1;

        if (isset($message_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $message_data['MODIFIED'] < $unread_cutoff_timestamp) {
            $message_data['LAST_READ'] = $message_data['LENGTH'];
        } else if (isset($message_data['UNREAD_PID']) && is_numeric($message_data['UNREAD_PID']) && $message_data['UNREAD_PID'] > 0) {
            $message_data['LAST_READ'] = $message_data['UNREAD_PID'];
        }

        return "{$message_data['TID']}.{$message_data['LAST_READ']}";

    } else {

        if ($message_data['LAST_READ'] < $message_data['LENGTH']) {
            $message_data['LAST_READ']++;
        }

        return "{$message_data['TID']}.{$message_data['LAST_READ']}";
    }
}

function messages_get_most_recent_unread($uid, $fid = false)
{
    if (!$db = db::get()) return false;

    if (is_numeric($fid)) {
        $fidlist = $fid;
    } else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    $user_ignored = USER_IGNORED;

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "THREAD.LENGTH, USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD.UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' ";
    $sql.= "AND THREAD.LENGTH > 0 AND (USER_PEER.RELATIONSHIP IS NULL ";
    $sql.= "OR (USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > CAST('$unread_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $message_data = $result->fetch_assoc();

    if (!session::logged_in()) {

       return "{$message_data['TID']}.1";

    } else if (!isset($message_data['LAST_READ']) || !is_numeric($message_data['LAST_READ'])) {

        $message_data['LAST_READ'] = 1;

        if (isset($message_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $message_data['MODIFIED'] < $unread_cutoff_timestamp) {
            $message_data['LAST_READ'] = $message_data['LENGTH'];
        } else if (isset($message_data['UNREAD_PID']) && is_numeric($message_data['UNREAD_PID'])) {
            $message_data['LAST_READ'] = $message_data['UNREAD_PID'];
        }

        return "{$message_data['TID']}.{$message_data['LAST_READ']}";

    } else {

        if ($message_data['LAST_READ'] < $message_data['LENGTH']) {
            $message_data['LAST_READ']++;
        }

        return "{$message_data['TID']}.{$message_data['LAST_READ']}";
    }
}

function messages_fontsize_form($tid, $pid, $return = false, $font_size = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Valid TID and PID.
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    // Check to see if we've been passed a font size
    if (!is_numeric($font_size)) {

        if (isset($_SESSION['FONT_SIZE']) && is_numeric($_SESSION['FONT_SIZE'])) {
            $font_size = max(min($_SESSION['FONT_SIZE'], 15), 5);
        } else {
            $font_size = 10;
        }
    }

    // Start of HTML.
    $font_size_html = array(
        "",
        gettext("Adjust text size"),
        ":"
    );

    // Check font size is greater than 4
    if ($font_size > 5) {
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=smaller\" target=\"_self\" class=\"font_size_smaller\" data-msg=\"$tid.$pid\">". gettext("Smaller"). "</a>";
    }

    // Add the current font size.
    $font_size_html[] = $font_size;

    // Check the font size is lower than 16
    if ($font_size < 15) {
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=larger\" target=\"_self\" class=\"font_size_larger\" data-msg=\"$tid.$pid\">". gettext("Larger"). "</a>\n";
    }

    // Check if we should return just the inner HTML
    if ($return === true) return implode(' ', $font_size_html);

    // Construct rest of HTML.
    $html = "<table class=\"posthead\" width=\"100%\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td align=\"center\">". implode(' ', $font_size_html). "</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";
    $html.= "<br />\n";

    echo $html;

    return true;
}

function validate_msg($msg)
{
    return preg_match('/^\d{1,}\.\d{1,}$/Du', rawurldecode($msg));
}

function messages_forum_stats($tid, $pid)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (forum_get_setting('show_stats', 'Y')) {

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "  <form action=\"user_stats.php\" method=\"get\" target=\"_self\">\n";
        echo "    ", form_input_hidden('webtag', $webtag), "\n";
        echo "    ", form_input_hidden('msg', "$tid.$pid"), "\n";
        echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
        echo "      <tr>\n";
        echo "        <td align=\"center\">\n";
        echo "          <table class=\"box\" width=\"100%\">\n";
        echo "            <tr>\n";
        echo "              <td align=\"left\" class=\"posthead\">\n";
        echo "                <table class=\"posthead\" width=\"100%\" cellspacing=\"0\">\n";
        echo "                  <tr>\n";
        echo "                    <td>\n";
        echo "                      <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "                        <tr>\n";
        echo "                          <td align=\"left\" class=\"subhead\">", gettext("Forum Stats"), "</td>\n";
        echo "                          <td align=\"right\" class=\"subhead\">\n";

        if (!session::logged_in()) {

            echo "                            &nbsp;";

        } else if (isset($_SESSION['SHOW_STATS']) && ($_SESSION['SHOW_STATS'] == 'Y')) {

            echo "                            ", form_submit_image('hide.png', 'forum_stats_toggle', 'hide', '', 'button_image toggle_button'), "\n";

        } else {

            echo "                            ", form_submit_image('show.png', 'forum_stats_toggle', 'show', '', 'button_image toggle_button'), "\n";
        }

        echo "                          </td>\n";
        echo "                        </tr>";
        echo "                      </table>\n";
        echo "                    </td>\n";
        echo "                  </tr>\n";
        echo "                  <tr>\n";
        echo "                    <td>\n";

        if (!session::logged_in() || (isset($_SESSION['SHOW_STATS']) && ($_SESSION['SHOW_STATS'] == 'Y'))) {
            echo "                      <div id=\"forum_stats\" class=\"forum_stats_toggle\">\n";
        } else {
            echo "                      <div id=\"forum_stats\" class=\"forum_stats_toggle\" style=\"display: none\">\n";
        }

        echo "                        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" id=\"active_user_counts\"></td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" class=\"activeusers\" id=\"active_user_list\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" id=\"thread_stats\">&nbsp;<br />&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" id=\"post_stats\">&nbsp;<br />&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" id=\"user_stats\">&nbsp;<br />&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td align=\"left\">&nbsp;</td>\n";
        echo "                            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                        </table>\n";
        echo "                      </div>\n";
        echo "                    </td>\n";
        echo "                  </tr>\n";
        echo "                </table>\n";
        echo "              </td>\n";
        echo "            </tr>\n";
        echo "          </table>\n";
        echo "        </td>\n";
        echo "      </tr>\n";
        echo "    </table>\n";
        echo "  </form>\n";
        echo "</div>\n";
    }
}

?>