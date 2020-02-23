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
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
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

    $sql = "SELECT FOLDER.FID, POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql .= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, POST.EDITED_BY, POST.IPADDRESS, POST.MOVED_TID, POST.MOVED_PID, ";
    $sql .= "UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, POST.APPROVED_BY, USER.LOGON AS FROM_LOGON, ";
    $sql .= "COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS FROM_NICKNAME, USER_PEER.RELATIONSHIP AS RELATIONSHIP, ";
    $sql .= "USER_PREFS_GLOBAL.ANON_LOGON, COALESCE(USER_PREFS_FORUM.AVATAR_URL, USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, ";
    $sql .= "THREAD.BY_UID AS THREAD_BY_UID, COALESCE(USER_PREFS_FORUM.AVATAR_AID, USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID, ";
    $sql .= "(SELECT MAX(SESSIONS.TIME) FROM SESSIONS WHERE SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND SESSIONS.FID = $forum_fid AND SESSIONS.UID = POST.FROM_UID) AS USER_ACTIVE ";
    $sql .= "FROM `{$table_prefix}POST` POST LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) LEFT JOIN USER ON (POST.FROM_UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = '{$_SESSION['UID']}' ";
    $sql .= "AND USER_PEER.PEER_UID = POST.FROM_UID) LEFT JOIN `{$table_prefix}USER_PREFS` ";
    $sql .= "USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = POST.FROM_UID) LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $sql .= "ON (USER_PREFS_GLOBAL.UID = POST.FROM_UID) WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql .= "ORDER BY POST.PID LIMIT 0, $limit";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $messages_array = array();

    while (($message = $result->fetch_assoc()) !== null) {

        $message['CONTENT'] = '';
        $message['ATTACHMENTS'] = array();
        $message['RECIPIENTS'] = array();

        if (!isset($message['FROM_NICKNAME'])) $message['FROM_NICKNAME'] = gettext("Unknown user");
        if (!isset($message['FROM_LOGON'])) $message['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($message['FROM_UID'])) $message['FROM_UID'] = null;

        $messages_array[$message['PID']] = $message;
    }

    messages_get_recipients($tid, $messages_array);

    messages_have_attachments($tid, $messages_array);

    messages_get_ratings($tid, $messages_array);

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
        $sql .= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

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

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $sql = "SELECT POST_RECIPIENT.PID, POST_RECIPIENT.TO_UID, USER_PEER.RELATIONSHIP, ";
    $sql .= "UNIX_TIMESTAMP(POST_RECIPIENT.VIEWED) AS VIEWED, USER_PREFS_GLOBAL.ANON_LOGON, ";
    $sql .= "USER.LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS NICKNAME, ";
    $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_URL, USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, ";
    $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_AID, USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID, ";
    $sql .= "(SELECT MAX(SESSIONS.TIME) FROM SESSIONS WHERE SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND SESSIONS.FID = $forum_fid AND SESSIONS.UID = POST_RECIPIENT.TO_UID) AS USER_ACTIVE ";
    $sql .= "FROM `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT LEFT JOIN USER ";
    $sql .= "ON (USER.UID = POST_RECIPIENT.TO_UID) LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.UID = '{$_SESSION['UID']}' AND USER_PEER.PEER_UID = POST_RECIPIENT.TO_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = POST_RECIPIENT.TO_UID) ";
    $sql .= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = POST_RECIPIENT.TO_UID) ";
    $sql .= "WHERE POST_RECIPIENT.TID = '$tid' AND POST_RECIPIENT.PID IN ('$pid_list')";

    if (!($result = $db->query($sql))) return false;

    while (($recipient_data = $result->fetch_assoc()) !== null) {

        if (!isset($messages_array[$recipient_data['PID']]['RECIPIENTS'])) {
            $messages_array[$recipient_data['PID']]['RECIPIENTS'] = array();
        }

        if (!filter_var($recipient_data['AVATAR_URL'], FILTER_VALIDATE_URL)) {
            $recipient_data['AVATAR_URL'] = null;
        }

        $messages_array[$recipient_data['PID']]['RECIPIENTS'][] = array(
            'UID' => $recipient_data['TO_UID'],
            'LOGON' => $recipient_data['LOGON'],
            'NICKNAME' => $recipient_data['NICKNAME'],
            'RELATIONSHIP' => $recipient_data['RELATIONSHIP'],
            'VIEWED' => $recipient_data['VIEWED'],
            'ANON_LOGON' => $recipient_data['ANON_LOGON'],
            'USER_ACTIVE' => $recipient_data['USER_ACTIVE'],
            'AVATAR_AID' => $recipient_data['AVATAR_AID'],
            'AVATAR_URL' => $recipient_data['AVATAR_URL'],
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
    $sql .= "INNER JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql .= "WHERE PAI.FID = '$forum_fid' AND PAI.TID = '$tid' ";
    $sql .= "AND PAI.PID IN ('$pid_list')";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {
        $messages_array[$attachment_data['PID']]['ATTACHMENTS'][] = $attachment_data['HASH'];
    }

    return true;
}

function messages_get_ratings($tid, &$messages_array)
{
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;

    if (sizeof($messages_array) < 1) return false;

    $pid_list = implode("','", array_keys($messages_array));

    $sql = "SELECT PID, SUM(RATING) AS RATING, COUNT(RATING) AS RATING_COUNT ";
    $sql .= "FROM `{$table_prefix}POST_RATING` WHERE TID = $tid ";
    $sql .= "AND RATING IN (-1, 1) AND PID IN ('$pid_list') GROUP BY PID";

    if (($result = $db->query($sql))) {

        while (($rating_data = $result->fetch_assoc()) !== null) {

            $messages_array[$rating_data['PID']]['POST_RATING'] = $rating_data['RATING'];
            $messages_array[$rating_data['PID']]['POST_RATING_COUNT'] = $rating_data['RATING_COUNT'];
        }
    }

    $sql = "SELECT PID, RATING FROM `{$table_prefix}POST_RATING` WHERE TID = $tid ";
    $sql .= "AND PID IN ('$pid_list') AND UID = {$_SESSION['UID']}";

    if (($result = $db->query($sql))) {

        while (($rating_data = $result->fetch_assoc()) !== null) {
            $messages_array[$rating_data['PID']]['USER_POST_RATING'] = $rating_data['RATING'];
        }
    }

    return true;
}

function message_get_meta_content($msg, &$meta_keywords, &$meta_description)
{
    if (!validate_msg($msg)) return;

    list($tid) = explode('.', $msg);

    if (($thread_data = thread_get($tid)) && ($message_content = message_get_content($tid, 1))) {

        $meta_keywords_array = search_extract_keywords(strip_tags(htmlentities_decode_array($message_content)));

        list($meta_description) = explode("\n", wordwrap($message_content, 150));

        $meta_keywords = htmlentities_array(implode(',', array_map('message_clean_meta_keyword', $meta_keywords_array['keywords_array'])));
    }
}

function message_clean_meta_keyword($keyword)
{
    return ucfirst(trim($keyword, '.,'));
}

function message_apply_formatting($message, $ignore_sig = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $message_parts = preg_split('/(<[^>]+>)/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

    $signature_parts = array();

    if (($signature_offset = array_search("<div class=\"sig\">", $message_parts)) !== false) {
        $signature_parts = array_splice($message_parts, $signature_offset);
    }

    $signature = implode('', $signature_parts);

    $message = implode('', $message_parts);

    $enable_wiki_words = forum_get_setting('enable_wiki_integration', 'Y') && isset($_SESSION['ENABLE_WIKI_WORDS']) && ($_SESSION['ENABLE_WIKI_WORDS'] == 'Y');

    $enable_wiki_links = forum_get_setting('enable_wiki_quick_links', 'Y') && isset($_SESSION['ENABLE_WIKI_QUICK_LINKS']) && ($_SESSION['ENABLE_WIKI_QUICK_LINKS'] == 'Y');

    $enable_tags = forum_get_setting('enable_tags', 'Y') && isset($_SESSION['ENABLE_TAGS']) && ($_SESSION['ENABLE_TAGS'] == 'Y');

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

    if ($enable_tags) {

        $message_parts = preg_split('/([<|>])/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 4) && (!isset($message_parts[$i - 2]) || !strstr($message_parts[$i - 2], "href"))) {

                $message_parts[$i] = preg_replace(
                    '/(^|\s)#([A-Z0-9]{1,255})/iu',
                    "$1<a href=\"search.php?webtag=$webtag&amp;tag=$2\" class=\"tag\" target=\"" . html_get_frame_name('right') . "\">#$2</a>",
                    $message_parts[$i]
                );
            }
        }

        $message = implode('', $message_parts);
    }

    $message = emoticons_apply($message);

    if (!$ignore_sig) {
        $message .= emoticons_apply($signature);
    }

    return $message;
}

function messages_top($tid, $pid, $folder_fid, $folder_title, $thread_title, $thread_interest_level = THREAD_NOINTEREST, $folder_interest_level = FOLDER_NOINTEREST, $sticky = "N", $closed = false, $locked = false, $deleted = false, $frame_links = true, $highlight_array = array())
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $frame_top_target = html_get_top_frame_name();

    $thread_title = strip_tags($thread_title);

    if (is_array($highlight_array) && sizeof($highlight_array) > 0) {

        $highlight_pattern = sprintf('/(%s)/i', implode('|', array_map('preg_quote_callback', $highlight_array)));
        $thread_title = preg_replace_callback($highlight_pattern, 'search_highlight_callback', $thread_title);
    }

    if ($folder_interest_level == FOLDER_SUBSCRIBED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder_subscribed', gettext("Subscribed Folder")), "</a>&nbsp;";
    } else if ($folder_interest_level == FOLDER_IGNORED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder_ignored', gettext("Ignored Folder")), "</a>&nbsp;";
    } else {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder', gettext("Folder")), "</a>&nbsp;";
    }

    if ($frame_links) {

        echo "<a href=\"index.php?webtag=$webtag&amp;folder=$folder_fid\" target=\"$frame_top_target\">", word_filter_add_ob_tags($folder_title, true), "</a>";
        echo html_style_image('separator');
        echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"$frame_top_target\" title=\"", gettext("View in Frameset"), "\">", word_filter_add_ob_tags($thread_title), "</a>";

    } else {

        echo word_filter_add_ob_tags($folder_title, true), html_style_image('separator'), word_filter_add_ob_tags($thread_title);
    }

    if ($closed) echo "&nbsp;", html_style_image('thread_closed', gettext("Closed")), "\n";
    if ($thread_interest_level == THREAD_INTERESTED) echo "&nbsp;", html_style_image('high_interest', gettext("High Interest")), "";
    if ($thread_interest_level == THREAD_SUBSCRIBED) echo "&nbsp;", html_style_image('subscribe', gettext("Subscribed")), "";
    if ($sticky == "Y") echo "&nbsp;", html_style_image('sticky', gettext("Sticky")), "";
    if ($locked) echo "&nbsp;", html_style_image('admin_locked', gettext("Locked")), "\n";
    if ($deleted) echo "&nbsp;", html_style_image('delete', gettext("Deleted")), "\n";

    echo "</p>";
}

function messages_social_links($tid)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (forum_get_setting('show_share_links', 'Y') && isset($_SESSION['SHOW_SHARE_LINKS']) && ($_SESSION['SHOW_SHARE_LINKS'] == 'Y')) {

        echo "      <div style=\"display: inline-block; vertical-align: middle; margin-top: 1px\">\n";
        echo "        <g:plusone size=\"small\" count=\"false\" href=\"", htmlentities_array(html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.1")), "\"></g:plusone>\n";
        echo "      </div>\n";
        echo "      <div style=\"display: inline-block; width: 47px; vertical-align: middle; margin-top: 2px; overflow: hidden\">\n";
        echo "        <iframe src=\"http://www.facebook.com/plugins/like.php?href=", rawurlencode(html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.1")), "&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:21px;\" allowTransparency=\"true\"></iframe>\n";
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

function message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $is_poll = false, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $perm_is_moderator = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    $post_edit_grace_period = forum_get_setting('post_edit_grace_period', null, 0);

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return;

    if (isset($_SESSION['POSTS_PER_PAGE']) && is_numeric($_SESSION['POSTS_PER_PAGE'])) {
        $posts_per_page = max(min(intval($_SESSION['POSTS_PER_PAGE']), 30), 10);
    } else {
        $posts_per_page = 20;
    }

    if (isset($_SESSION['REPLY_QUICK']) && ($_SESSION['REPLY_QUICK'] == 'Y')) {
        $quick_reply = 'Y';
    } else {
        $quick_reply = 'N';
    }

    if ((!isset($message['CONTENT']) || $message['CONTENT'] == '') && !$is_preview) {

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

    if (!$is_preview && !isset($message['APPROVED'])) {

        message_display_approval_req($tid, $message['PID'], $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

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

    if (!$is_preview && isset($message['MOVED_TID']) && isset($message['MOVED_PID'])) {

        message_display_moved($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    // Add emoticons/WikiLinks and ignore signature ----------------------------
    if (isset($_SESSION['IMAGES_TO_LINKS']) && ($_SESSION['IMAGES_TO_LINKS'] == 'Y')) {
        $message['CONTENT'] = message_images_to_links($message['CONTENT']);
    }

    if (!$is_poll || (isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = message_apply_formatting($message['CONTENT'], ((isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED_SIG) > 0)) || !$show_sigs);
    }

    // Check for words that should be filtered ---------------------------------
    if (!$is_poll || (isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT'], false);
    }

    if ($in_list && isset($message['PID'])) {
        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>\n";
    }

    // Check for search words to highlight -------------------------------------
    if (is_array($highlight_array) && sizeof($highlight_array) > 0) {

        $highlight_pattern = sprintf('/(%s)/i', implode('|', array_map('preg_quote_callback', $highlight_array)));

        $message_parts = preg_split('/([<|>])/u', $message['CONTENT'], -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 4)) {

                $message_parts[$i] = preg_replace_callback($highlight_pattern, 'search_highlight_callback', $message_parts[$i]);
            }
        }

        $message['CONTENT'] = implode("", $message_parts);
    }

    if ($in_list && isset($message['PID'])) {
        echo "<div align=\"center\" class=\"message\" id=\"message_{$tid}_{$message['PID']}\">\n";
    } else {
        echo "<div align=\"center\" class=\"message\">\n";
    }

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

    if (isset($message['FROM_UID'])) {

        echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "</a>&nbsp;</span>";

    } else {

        echo word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "&nbsp;</span>";
    }

    if (isset($_SESSION['SHOW_AVATARS']) && ($_SESSION['SHOW_AVATARS'] == 'Y')) {

        if (isset($message['AVATAR_URL']) && filter_var($message['AVATAR_URL'], FILTER_VALIDATE_URL)) {

            echo html_style_image('profile_image profile_image_small', format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), null, array('background-image' => sprintf("url('%s')", $message['AVATAR_URL'])));

        } else if (isset($message['AVATAR_AID']) && is_numeric($message['AVATAR_AID'])) {

            $attachment = attachments_get_by_aid($message['AVATAR_AID']);

            if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false)) !== false) {

                echo html_style_image('profile_image profile_image_small', format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), null, array('background-image' => sprintf("url('%s&amp;profile_picture')", $profile_picture_href)));
            }
        }
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && isset($message['PID']) && $message['PID'] == 1 && (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED))) {
        $message['RELATIONSHIP'] -= USER_IGNORED;
    }

    if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_FRIEND)) {

        echo "", html_style_image('friend', gettext("Friend")), "&nbsp;";

    } else if ((isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED))) {

        echo "", html_style_image('enemy', gettext("Ignored user")), "&nbsp;";
    }

    if ((isset($message['ANON_LOGON']) && $message['ANON_LOGON'] > USER_ANON_DISABLED) || !isset($message['USER_ACTIVE']) || is_null($message['USER_ACTIVE'])) {

        echo html_style_image('status_offline', gettext("Inactive / Offline")), "&nbsp;";

    } else {

        echo html_style_image('status_online', gettext("Online")), "&nbsp;";
    }

    if (isset($message['FROM_UID']) && isset($message['THREAD_BY_UID']) && $message['FROM_UID'] == $message['THREAD_BY_UID'] && $first_msg > 1) {
        echo html_style_image('thread_starter', gettext("Thread Starter")), "&nbsp;";
    }

    echo "</td>\n";
    echo "                <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">";

    if (!$is_preview && $_SESSION['UID'] > 0 && isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED)) {

        echo "<b>", gettext("Ignored message"), "</b>";

    } else {

        if ($in_list) {

            if ($from_user_permissions & USER_PERM_WORMED) echo "<b>", gettext("Wormed user"), "</b> ";
            if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED_SIG)) echo "<b>", gettext("Ignored signature"), "</b> ";
            echo format_date_time($message['CREATED']);
        }
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" style=\"white-space: nowrap\"><span class=\"posttofromlabel\">&nbsp;", gettext("To"), ":&nbsp;</span></td>\n";
    echo "                <td style=\"white-space: nowrap\" width=\"98%\" align=\"left\">";

    if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) > 0) {

        foreach ($message['RECIPIENTS'] as $recipient) {

            if (isset($recipient['RELATIONSHIP']) && ($recipient['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {
                continue;
            }

            echo "<span class=\"posttofrom\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$recipient['UID']}\" target=\"_blank\" class=\"popup 650x500\">";
            echo word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</a>&nbsp;</span>\n";

            if (isset($_SESSION['SHOW_AVATARS']) && ($_SESSION['SHOW_AVATARS'] == 'Y')) {

                if (isset($recipient['AVATAR_URL']) && filter_var($recipient['AVATAR_URL'], FILTER_VALIDATE_URL)) {

                    echo html_style_image('profile_image profile_image_small', format_user_name($recipient['LOGON'], $recipient['NICKNAME']), null, array('background-image' => sprintf("url('%s')", $recipient['AVATAR_URL'])));

                } else if (isset($recipient['AVATAR_AID']) && is_numeric($recipient['AVATAR_AID'])) {

                    $attachment = attachments_get_by_aid($recipient['AVATAR_AID']);

                    if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false)) !== false) {

                        echo html_style_image('profile_image profile_image_small', format_user_name($recipient['LOGON'], $recipient['NICKNAME']), null, array('background-image' => sprintf("url('%s&amp;profile_picture')", $profile_picture_href)));
                    }
                }
            }

            if ((isset($recipient['ANON_LOGON']) && $recipient['ANON_LOGON'] > USER_ANON_DISABLED) || !isset($recipient['USER_ACTIVE']) || is_null($recipient['USER_ACTIVE'])) {

                echo html_style_image('status_offline', gettext("Inactive / Offline")), "&nbsp;";

            } else {

                echo html_style_image('status_online', gettext("Online")), "&nbsp;";
            }

            if (isset($recipient['UID']) && isset($message['THREAD_BY_UID']) && $recipient['UID'] == $message['THREAD_BY_UID'] && $first_msg > 1) {
                echo html_style_image('thread_starter', gettext("Thread Starter")), "&nbsp;";
            }

            if (isset($recipient['VIEWED']) && $recipient['VIEWED'] > 0) {

                echo html_style_image('post_read', sprintf(gettext("Read: %s"), format_date_time($recipient['VIEWED']))), "&nbsp;&nbsp;";

            } else {

                if ($is_preview == false) {
                    echo html_style_image('post_unread', gettext("Unread Message")), "&nbsp;&nbsp;";
                } else {
                    echo "&nbsp;&nbsp;";
                }
            }
        }

    } else {

        echo gettext('ALL');
    }

    echo "</span></td>\n";
    echo "                <td align=\"right\" style=\"white-space: nowrap\"><span class=\"postinfo\">";

    if (!$is_preview && $_SESSION['UID'] > 0 && isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED)) {

        echo "<a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">", gettext("Stop ignoring this user"), "</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&amp;return_msg=$tid.$first_msg\" target=\"_self\">", gettext("View Message"), "</a>";

    } else if ($in_list && $msg_count > 0) {

        if ($is_poll) {
            echo "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" class=\"popup 800x600\">", html_style_image('poll', "This is a poll. Click to view results."), "</a> ", gettext("Poll"), " ";
        }

        echo sprintf(gettext("%s of %s"), $message['PID'], $msg_count);
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";

    if ($is_preview || !isset($message['RELATIONSHIP']) || !($message['RELATIONSHIP'] & USER_IGNORED)) {

        echo "        <tr>\n";
        echo "          <td align=\"left\">\n";
        echo "            <table width=\"100%\">\n";
        echo "              <tr>\n";
        echo "                <td colspan=\"3\" align=\"right\"><span class=\"postnumber\">";

        if ($in_list && $msg_count > 0) {

            $title = ($message['PID'] == 1) ? "" . gettext("Permanent link to this thread") . " ($tid.1)" : "" . gettext("Link to this post");

            if ($is_preview) {

                echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_blank\" title=\"$title\">$tid.{$message['PID']}</a>";

            } else {

                echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"", html_get_top_frame_name(), "\" title=\"$title\">$tid.{$message['PID']}</a>";
            }

            if ($message['REPLY_TO_PID'] > 0) {

                $title = "" . gettext("Link to post") . " #{$message['REPLY_TO_PID']}";

                echo " ", gettext("In reply to"), " ";

                if (intval($message['REPLY_TO_PID']) >= intval($first_msg)) {

                    echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$first_msg}#a{$tid}_{$message['REPLY_TO_PID']}\" target=\"_self\" title=\"$title\">";
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
        echo "                <td class=\"postbody overflow_content\" align=\"left\">{$message['CONTENT']}</td>\n";
        echo "              </tr>\n";

        if (!$is_preview && isset($message['EDITED']) && $post_edit_grace_period > 0) {

            if (($post_edit_grace_period == 0) || ($message['EDITED'] - $message['CREATED']) > ($post_edit_grace_period * MINUTE_IN_SECONDS)) {

                if (($edit_user = user_get_logon($message['EDITED_BY'])) !== false) {

                    echo "              <tr>\n";
                    echo "                <td class=\"postbody\" align=\"left\"><p class=\"edit_text\">", sprintf(gettext("EDITED: %s by %s"), format_date_time($message['EDITED']), $edit_user), "</p></td>\n";
                    echo "              </tr>\n";
                }
            }
        }

        if (!$is_preview && isset($message['APPROVED']) && isset($message['APPROVED_BY'])) {

            if (($message['APPROVED_BY'] != $message['FROM_UID']) && ($approved_user = user_get_logon($message['APPROVED_BY'])) !== false) {

                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\"><p class=\"approved_text\">", sprintf(gettext("APPROVED: %s by %s"), format_date_time($message['APPROVED']), $approved_user), "</p></td>\n";
                echo "              </tr>\n";
            }
        }

        if (isset($message['ATTACHMENTS']) && sizeof($message['ATTACHMENTS']) > 0) {

            if (($attachments_array = attachments_get($message['FROM_UID'], $message['ATTACHMENTS'])) !== false) {

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
            echo "                <td align=\"left\" width=\"25%\">";
            echo "                  <div class=\"message_vote_form\" data-msg=\"$tid.{$message['PID']}\">\n";
            echo "                    ", message_get_vote_form_html($message), "\n";
            echo "                  </div>\n";
            echo "                </td>\n";
            echo "                <td width=\"50%\" style=\"white-space: nowrap\">";

            if ($msg_count > 0) {

                if ((!$closed && session::check_perm(USER_PERM_POST_CREATE, $folder_fid)) || $perm_is_moderator) {

                    if ($quick_reply == 'Y') {

                        echo "", html_style_image('quick_reply', "Quick Reply"), "\n";
                        echo "<a href=\"Javascript:void(0)\" data-msg=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">", gettext("Quick Reply"), "</a>\n";

                    } else {

                        echo "", html_style_image('post', "Reply"), "";
                        echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;reply_to=$tid.{$message['PID']}&amp;return_msg=$tid.$first_msg\" target=\"_parent\" id=\"reply_{$message['PID']}\">", gettext("Reply"), "</a>";
                    }

                    echo "&nbsp;&nbsp;", html_style_image('quote_disabled', gettext("Quote"), "quote_img_{$message['PID']}");
                    echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;reply_to=$tid.{$message['PID']}&amp;quote_list={$message['PID']}&amp;return_msg=$tid.$first_msg\" target=\"_parent\" title=\"", gettext("Quote"), "\" id=\"quote_{$message['PID']}\" data-pid=\"{$message['PID']}\">", gettext("Quote"), "</a>";

                    if ((!(session::check_perm(USER_PERM_PILLORIED, 0)) && ((($_SESSION['UID'] != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($_SESSION['UID'] == $message['FROM_UID'])) && session::check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

                        if ($is_poll && $message['PID'] == 1) {

                            if (!poll_is_closed($tid) || $perm_is_moderator) {

                                echo "&nbsp;&nbsp;", html_style_image('edit', "Edit Poll"), "";
                                echo "&nbsp;<a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&amp;return_msg=$tid.$first_msg\" target=\"_parent\">", gettext("Edit Poll"), "</a>\n";
                            }

                        } else {

                            echo "&nbsp;&nbsp;", html_style_image('edit', "Edit"), "";
                            echo "&nbsp;<a href=\"edit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&amp;return_msg=$tid.$first_msg\" target=\"_parent\">", gettext("Edit"), "</a>";
                        }
                    }
                }

            } else {

                echo "&nbsp;";
            }

            echo "</td>\n";
            echo "                <td align=\"right\" style=\"white-space: nowrap\">\n";
            echo "                  <span class=\"post_options\" id=\"post_options_{$tid}_{$first_msg}_{$message['PID']}\">\n";
            echo "                    ", gettext("More"), "&nbsp;", html_style_image('post_options', gettext("More"), 'post_options'), "\n";
            echo "                  </span>\n";
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
    echo ($in_list) ? "<br />\n" : '';
}

function message_images_to_links($content)
{
    $content = preg_replace('/<a([^>]*)href="([^"]*)"([^\>]*)><img[^>]*src="([^"]*)"[^>]*><\/a>/iu', '[href: <a\1href="\2"\3>\2</a>][img: <a\1href="\4"\3>\4</a>]', $content);
    $content = preg_replace('/<img[^>]*src="([^"]*)"[^>]*>/iu', '[img: <a href="\1">\1</a>]', $content);
    return preg_replace('/<embed[^>]*src="([^"]*)"[^>]*>/iu', '[object: <a href="\1">\1</a>]', $content);
}

function message_get_post_options_html($tid, $pid, $message)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $perm_is_moderator = session::check_perm(USER_PERM_FOLDER_MODERATE, $message['FID']);
    $perm_has_admin_access = session::check_perm(USER_PERM_ADMIN_TOOLS, 0);

    if (isset($_SESSION['REPLY_QUICK']) && ($_SESSION['REPLY_QUICK'] == 'Y')) {
        $quick_reply = 'Y';
    } else {
        $quick_reply = 'N';
    }

    $html = "<div class=\"post_options_container\">\n";
    $html .= "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    $html .= "    <tr>\n";
    $html .= "      <td align=\"left\" colspan=\"3\">\n";
    $html .= "        <table class=\"box\" width=\"100%\">\n";
    $html .= "          <tr>\n";
    $html .= "            <td align=\"left\" class=\"posthead\">\n";
    $html .= "              <table class=\"posthead\" width=\"100%\">\n";
    $html .= "                <tr>\n";
    $html .= "                  <td class=\"subhead\" colspan=\"2\">" . gettext("Post Options") . "</td>\n";
    $html .= "                </tr>\n";
    $html .= "                <tr>\n";
    $html .= "                  <td align=\"center\">\n";
    $html .= "                    <table width=\"95%\" class=\"post_options_menu\">\n";
    $html .= "                      <tr>\n";

    if ($quick_reply == 'N') {

        $html .= "                        <td align=\"left\"><a href=\"Javascript:void(0)\" data-msg=\"{$message['TID']}.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">" . html_style_image('quick_reply', gettext("Quick Reply")) . "</a></td>\n";
        $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"Javascript:void(0)\" data-msg=\"{$message['TID']}.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">" . gettext("Quick Reply") . "</a></td>\n";

    } else {

        $html .= "                        <td align=\"left\">" . html_style_image('post', gettext("Reply")) . "</td>\n";
        $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"post.php?webtag=$webtag&amp;reply_to={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_parent\" id=\"reply_{$message['PID']}\">" . gettext("Reply") . "</a></td>\n";
    }

    $html .= "                      </tr>\n";

    if (($_SESSION['UID'] == $message['FROM_UID'] && session::check_perm(USER_PERM_POST_DELETE, $message['FID']) && !session::check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

        $html .= "                      <tr>\n";
        $html .= "                        <td align=\"left\"><a href=\"delete.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_parent\">" . html_style_image('delete', gettext("Delete")) . "</a></td>\n";
        $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"delete.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_parent\">" . gettext("Delete") . "</a></td>\n";
        $html .= "                      </tr>\n";
    }

    $html .= "                      <tr>\n";
    $html .= "                        <td align=\"left\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_parent\" title=\"" . gettext("Reply as PM") . "\">" . html_style_image('pm_unread', gettext("Reply as PM")) . "</a></td>\n";
    $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_parent\" title=\"" . gettext("Reply as PM") . "\">" . gettext("Reply as PM") . "</a></td>\n";
    $html .= "                      </tr>\n";
    $html .= "                      <tr>\n";
    $html .= "                        <td align=\"left\"><a href=\"display.php?webtag=$webtag&amp;print_msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_self\" title=\"" . gettext("Print") . "\">" . html_style_image('print', gettext("Print")) . "</a></td>\n";
    $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"display.php?webtag=$webtag&amp;print_msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_self\" title=\"" . gettext("Print") . "\">" . gettext("Print") . "</a></td>\n";
    $html .= "                      </tr>\n";
    $html .= "                      <tr>\n";
    $html .= "                        <td align=\"left\"><a href=\"thread_options.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&amp;markasread=" . ($message['PID'] - 1) . "&amp;return_msg=$tid.$pid\" target=\"_self\" title=\"" . gettext("Mark as unread") . "\">" . html_style_image('mark_as_unread', gettext("Mark as unread")) . "</a></td>\n";
    $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"thread_options.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&amp;markasread=" . ($message['PID'] - 1) . "&amp;return_msg=$tid.$pid\" target=\"_self\" title=\"" . gettext("Mark as unread") . "\">" . gettext("Mark as unread") . "</a></td>\n";
    $html .= "                      </tr>\n";

    if ($_SESSION['UID'] != $message['FROM_UID']) {

        $html .= "                      <tr>\n";
        $html .= "                        <td align=\"left\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}&amp;return_msg=$tid.$pid\" target=\"_self\" title=\"" . gettext("Relationship") . "\">" . html_style_image('enemy', gettext("Relationship")) . "</a></td>\n";
        $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}\" target=\"_self\" title=\"" . gettext("Relationship") . "\">" . gettext("Relationship") . "</a></td>\n";
        $html .= "                      </tr>\n";
    }

    if ($perm_has_admin_access) {

        $html .= "                      <tr>\n";
        $html .= "                        <td align=\"left\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}\" target=\"_self\" title=\"" . gettext("Privileges") . "\">" . html_style_image('admin_tool', gettext("Privileges")) . "</a></td>\n";
        $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg={$message['TID']}.{$message['PID']}\" target=\"_self\" title=\"" . gettext("Privileges") . "\">" . gettext("Privileges") . "</a></td>\n";
        $html .= "                      </tr>\n";
    }

    if ($perm_is_moderator || $perm_has_admin_access) {

        if (!isset($message['APPROVED']) && $perm_is_moderator) {

            $html .= "                      <tr>\n";
            $html .= "                        <td align=\"left\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D{$message['TID']}.{$message['PID']}\" target=\"_self\" title=\"" . gettext("Approve Post") . "\">" . html_style_image('approved', gettext("Approve Post")) . "</a></td>\n";
            $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg={$message['TID']}.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D{$message['TID']}.{$message['PID']}\" target=\"_self\" title=\"" . gettext("Approve Post") . "\">" . gettext("Approve Post") . "</a></td>\n";
            $html .= "                      </tr>\n";
        }

        if (isset($message['IPADDRESS'])) {

            $html .= "                      <tr>\n";
            $html .= "                        <td align=\"left\"><span class=\"adminipdisplay\"><b>" . gettext("IP") . "</b></span></td>\n";
            $html .= "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$message['IPADDRESS']}&amp;msg={$message['TID']}.{$message['PID']}\" target=\"_self\">" . gettext("Ban IP Address") . "</a></td>\n";
            $html .= "                      </tr>";

        } else {

            $html .= "                      <tr>\n";
            $html .= "                        <td align=\"left\"><span class=\"adminipdisplay\"><b>" . gettext("IP") . "</b></span></td>\n";
            $html .= "                        <td align=\"left\" style=\"white-space: nowrap\">" . gettext("Not Logged") . "</td>\n";
            $html .= "                      </tr>";
        }
    }

    $html .= "                    </table>\n";
    $html .= "                  </td>\n";
    $html .= "                </tr>\n";
    $html .= "              </table>\n";
    $html .= "            </td>\n";
    $html .= "          </tr>\n";
    $html .= "        </table>\n";
    $html .= "      </td>\n";
    $html .= "    </tr>\n";
    $html .= "  </table>\n";
    $html .= "</div>\n";

    return $html;
}

function message_get_vote_form_html($message)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (isset($message['POST_RATING'])) {
        $html = "  <span class=\"smallertext\">" . ($message['POST_RATING'] > 0 ? '+' : '') . $message['POST_RATING'] . "/" . $message['POST_RATING_COUNT'] . "</span>";
    } else {
        $html = "  <span class=\"smallertext\">0/0</span>";
    }

    if (isset($message['USER_POST_RATING']) && in_array($message['USER_POST_RATING'], array(-1, 1))) {

        if ($message['USER_POST_RATING'] > 0) {

            $html .= "  " . html_style_image('vote vote_down vote_down_off', 'Vote Down') . "\n";
            $html .= "  " . html_style_image('vote vote_up vote_up_on', 'Clear Vote') . "\n";

        } else {

            $html .= "  " . html_style_image('vote vote_down vote_down_on', 'Clear Vote') . "\n";
            $html .= "  " . html_style_image('vote vote_up vote_up_off', 'Vote Up') . "\n";
        }

    } else {

        $html .= "  " . html_style_image('vote vote_down vote_down_off', 'Vote Down') . "\n";
        $html .= "  " . html_style_image('vote vote_up vote_up_off', 'Vote Up') . "\n";
    }

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
            echo html_style_image('message_up', gettext("Previous")), "</a>";

        } else {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$first_msg}#a{$tid}_", $pid - 1, "\" target=\"_self\">";
            echo html_style_image('message_up', gettext("Previous")), "</a>";
        }
    }

    echo "          </td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"center\">\n";

    if ($pid < $msg_count) {

        if (($pid + 1) > (($first_msg + $posts_per_page) - 1)) {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.", $pid + 1, "\" target=\"_self\">";
            echo html_style_image('message_down', gettext("Next")), "</a>";

        } else {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$first_msg}#a{$tid}_", $pid + 1, "\" target=\"_self\">";
            echo html_style_image('message_down', gettext("Next")), "</a>";
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

    if (isset($message['EDITED'])) {

        if (($edit_user = user_get_logon($message['EDITED_BY'])) !== false) {

            $message_delete_time = format_date_time($message['EDITED']);
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
    echo ($in_list) ? "<br />\n" : '';
}

function message_display_moved($tid, $pid, $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $post_link = sprintf(
        '<a href="messages.php?webtag=%s&amp;msg=%s.%s" target="_self">%s</a>',
        $webtag,
        $message['MOVED_TID'],
        $message['MOVED_PID'],
        gettext('here')
    );

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
    echo "                <td align=\"left\">", sprintf(gettext("This message has been moved %s"), $post_link), "</td>\n";
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
    echo ($in_list) ? "<br />\n" : '';
}

function message_display_approval_req($tid, $pid, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

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
    echo "                <td align=\"right\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.$pid&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D$tid.$pid\" target=\"_self\" title=\"", gettext("Approve Post"), "\">", gettext("Approve Post"), "</a></td>\n";
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
    echo ($in_list) ? "<br />\n" : '';
}

function message_display_success_msg($tid, $pid, $first_msg, $message, $posts_per_page)
{
    $webtag = get_webtag();

    if (($pid + 1) > (($first_msg + $posts_per_page) - 1)) {

        html_display_success_msg(
            sprintf(
                $message,
                "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$pid}\" target=\"_self\">{$tid}.{$pid}</a>"
            ),
            '96%',
            'center'
        );

    } else {

        html_display_success_msg(
            sprintf(
                $message,
                "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$first_msg}#a{$tid}_{$pid}\" target=\"_self\">{$tid}.{$pid}</a>"
            ),
            '96%',
            'center'
        );
    }
}

function messages_nav_strip($tid, $pid, $length, $posts_per_page)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $current = floor($pid / $posts_per_page);

    $ranges = array_chunk(range(1, $length), $posts_per_page);

    $navigation = array();

    $separator = false;

    foreach ($ranges as $key => $range) {

        if ($key == 0 || $key == count($ranges) - 1 || ($key > $current - 3 && $key < $current + 2)) {

            $separator = true;

            if (min($range) == max($range)) {

                $navigation[$key] = sprintf(
                    '<a href="messages.php?webtag=%s&amp;msg=%s.%s" target="_self">%s</a>',
                    urlencode($webtag),
                    urlencode($tid),
                    urlencode(min($range)),
                    htmlentities(min($range))
                );

            } else {

                $navigation[$key] = sprintf(
                    '<a href="messages.php?webtag=%s&amp;msg=%s.%s" target="_self">%s&ndash;%s</a>',
                    urlencode($webtag),
                    urlencode($tid),
                    urlencode(min($range)),
                    htmlentities(min($range)),
                    htmlentities(max($range))
                );
            }

        } else if ($separator) {

            $separator = false;
            $navigation[$key] = '&hellip;';
        }
    };

    echo "<table class=\"messages_nav_strip\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">" . implode('&nbsp;&nbsp;', $navigation) . "</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
}

function messages_poll_results_link($thread_data)
{
    if ($thread_data['POLL_FLAG'] != 'Y') {
        return null;
    }

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "<table class=\"messages_poll_results_link\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <a href=\"poll_results.php?webtag=$webtag&amp;tid={$thread_data['TID']}\" target=\"_blank\" class=\"popup 800x600\">". gettext("View Results"). "</a>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
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

    echo "<table class=\"messages_interest_form\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"rate_interest\" target=\"_self\" action=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$pid\" method=\"post\">\n";
    echo "        ", form_csrf_token_field(), "\n";
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

function message_get_author($tid, $pid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT USER.UID, USER.LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS NICKNAME ";
    $sql .= "FROM `{$table_prefix}POST` POST LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.PEER_UID = POST.FROM_UID ";
    $sql .= "AND USER_PEER.UID = '{$_SESSION['UID']}') WHERE POST.TID = '$tid' AND POST.PID = '$pid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
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

        if (($unread_cutoff_timestamp !== false) && ($modified >= $unread_cutoff_timestamp)) {

            $unread_cutoff_datetime = forum_get_unread_cutoff_datetime();

            // Get the last PID within the unread-cut-off.
            $sql = "SELECT COALESCE(MAX(POST.PID), 0) AS UNREAD_PID ";
            $sql .= "FROM `{$table_prefix}POST` POST ";
            $sql .= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
            $sql .= "AND POST.TID = '$tid'";

            if (!($result = $db->query($sql))) return false;

            list($unread_pid) = $result->fetch_row();

            // If the specified PID is lower than the cut-off set it to the cut-off.
            $pid = ($pid < $unread_pid) ? $unread_pid : $pid;

            // Update the unread data.
            $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT) ";
            $sql .= "VALUES ('{$_SESSION['UID']}', '$tid', '$pid', CAST('$current_datetime' AS DATETIME)) ON DUPLICATE KEY UPDATE ";
            $sql .= "LAST_READ = VALUES(LAST_READ), LAST_READ_AT = CAST('$current_datetime' AS DATETIME)";

            if (!($result = $db->query($sql))) return false;
        }
    }

    // Mark posts as Viewed
    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_RECIPIENT` SET VIEWED = CAST('$current_datetime' AS DATETIME) ";
    $sql .= "WHERE TID = '$tid' AND PID BETWEEN 1 AND '$pid' AND TO_UID = '{$_SESSION['UID']}' AND VIEWED IS NULL";

    if (!($result = $db->query($sql))) return false;

    // Update thread viewed counter
    $sql = "INSERT INTO `{$table_prefix}THREAD_STATS` ";
    $sql .= "(TID, VIEWCOUNT) VALUES ('$tid', 1) ON DUPLICATE KEY ";
    $sql .= "UPDATE VIEWCOUNT = VIEWCOUNT + 1";

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

        if (($unread_cutoff_timestamp !== false) && ($modified >= $unread_cutoff_timestamp)) {

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_THREAD` ";
            $sql .= "SET LAST_READ = '$pid', LAST_READ_AT = NULL ";
            $sql .= "WHERE UID = '{$_SESSION['UID']}' AND TID = '$tid'";

            if (!$db->query($sql)) return false;

            if ($db->affected_rows < 1) {

                $sql = "INSERT IGNORE INTO `{$table_prefix}USER_THREAD` ";
                $sql .= "(UID, TID, LAST_READ, LAST_READ_AT) ";
                $sql .= "VALUES ({$_SESSION['UID']}, $tid, $pid, NULL)";

                if (!$db->query($sql)) return false;
            }
        }
    }

    // Mark posts as unread
    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_RECIPIENT` SET VIEWED = NULL ";
    $sql .= "WHERE TID = '$tid' AND PID >= '$pid' AND TO_UID = '{$_SESSION['UID']}'";

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

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, THREAD.LENGTH, ";
    $sql .= "USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, THREAD.UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 AND (THREAD.APPROVED IS NOT NULL ";
    $sql .= "OR THREAD.BY_UID = '$uid') AND (USER_PEER.RELATIONSHIP IS NULL OR (USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 1";

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

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, THREAD.LENGTH, ";
    $sql .= "USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, THREAD.UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 AND (THREAD.APPROVED IS NOT NULL ";
    $sql .= "OR THREAD.BY_UID = '$uid') AND (USER_PEER.RELATIONSHIP IS NULL OR (USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND THREAD.MODIFIED > CAST('$unread_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 1";

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
            $font_size = max(min(intval($_SESSION['FONT_SIZE']), 15), 5);
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
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=smaller\" target=\"_self\" class=\"font_size_smaller\" data-msg=\"$tid.$pid\">" . gettext("Smaller") . "</a>";
    }

    // Add the current font size.
    $font_size_html[] = $font_size;

    // Check the font size is lower than 16
    if ($font_size < 15) {
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=larger\" target=\"_self\" class=\"font_size_larger\" data-msg=\"$tid.$pid\">" . gettext("Larger") . "</a>\n";
    }

    // Check if we should return just the inner HTML
    if ($return === true) return implode(' ', $font_size_html);

    // Construct rest of HTML.
    $html = "<table class=\"messages_fontsize_form\" width=\"100%\">\n";
    $html .= "  <tr>\n";
    $html .= "    <td align=\"center\">" . implode(' ', $font_size_html) . "</td>\n";
    $html .= "  </tr>\n";
    $html .= "</table>\n";
    $html .= "<br />\n";

    echo $html;

    return true;
}

function messages_beehive_bar()
{
    echo "<div align=\"center\" class=\"beehive_bar\">\n";
    echo "<table width=\"98%\">\n";
    echo "  <tr>\n";
    echo "    <td width=\"60%\" align=\"left\">\n";
    echo "      Beehive Forum ", BEEHIVE_VERSION, "&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/faq/\" target=\"_blank\">", gettext("FAQ"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/docs/\" target=\"_blank\">", gettext("Docs"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/support/\" target=\"_blank\">", gettext("Support"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/donate/\" target=\"_blank\">", gettext("Donate!"), "</a>\n";
    echo "    </td>\n";
    echo "    <td width=\"40%\" align=\"right\">&copy;2002 - ", strftime("%Y", time()), " <a href=\"http://www.beehiveforum.co.uk/\" target=\"_blank\">Project&nbsp;Beehive&nbsp;Forum</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
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
        echo "<div align=\"center\" class=\"messages_forum_stats\">\n";
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

            echo "                            ", form_submit_image('hide', 'forum_stats_toggle', 'hide', null, 'button_image toggle_button'), "\n";

        } else {

            echo "                            ", form_submit_image('show', 'forum_stats_toggle', 'show', null, 'button_image toggle_button'), "\n";
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
        echo "                            <td rowspan=\"19\" width=\"35\">&nbsp;</td>\n";
        echo "                            <td>&nbsp;</td>\n";
        echo "                            <td rowspan=\"19\" width=\"35\">&nbsp;</td>\n";
        echo "                          </tr>\n";

        for ($i = 0; $i < 18; $i++) {

            echo "                          <tr>\n";
            echo "                            <td>&nbsp;</td>\n";
            echo "                          </tr>\n";
        }

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
