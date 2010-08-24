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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function messages_get($tid, $pid = 1, $limit = 1)
{
    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$db_messages_get = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $current_timestamp = time();
    
    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, UNIX_TIMESTAMP(POST.VIEWED) AS VIEWED, ";
    $sql.= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, POST.EDITED_BY, POST.IPADDRESS, ";
    $sql.= "POST.MOVED_TID, POST.MOVED_PID, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql.= "POST.APPROVED_BY, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "USER_PEER_FROM.RELATIONSHIP AS FROM_RELATIONSHIP, TUSER.LOGON AS TLOGON, ";
    $sql.= "TUSER.NICKNAME AS TNICK, USER_PEER_TO.RELATIONSHIP AS TO_RELATIONSHIP, ";
    $sql.= "USER_PEER_TO.PEER_NICKNAME AS PTNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK, ";
    $sql.= "($current_timestamp - UNIX_TIMESTAMP(COALESCE(SESSIONS.TIME, 0))) < $active_sess_cutoff AS USER_ACTIVE, ";
    $sql.= "USER_PREFS_GLOBAL.ANON_LOGON AS ANON_LOGON_GLOBAL, USER_PREFS.ANON_LOGON ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER_TO ";
    $sql.= "ON (USER_PEER_TO.UID = '$uid' AND USER_PEER_TO.PEER_UID = POST.TO_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER_FROM ";
    $sql.= "ON (USER_PEER_FROM.UID = '$uid' AND USER_PEER_FROM.PEER_UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.FID = {$table_data['FID']} AND SESSIONS.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PREFS` USER_PREFS ON (USER_PREFS.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = SESSIONS.UID) ";
    $sql.= "WHERE POST.TID = '$tid' ";
    $sql.= "AND POST.PID >= '$pid' ";
    $sql.= "ORDER BY POST.PID ";
    $sql.= "LIMIT 0, $limit";

    $result = db_unbuffered_query($sql, $db_messages_get);

    // Loop through the results and construct an array to return
    if ($limit > 1) {

        $messages = false;

        while (($message = db_fetch_array($result))) {

            $message['CONTENT'] = "";

            if (!isset($message['VIEWED'])) $message['VIEWED'] = 0;

            if (!isset($message['APPROVED'])) $message['APPROVED'] = 0;
            if (!isset($message['APPROVED_BY'])) $message['APPROVED_BY'] = 0;

            if (!isset($message['EDITED'])) $message['EDITED'] = 0;
            if (!isset($message['EDITED_BY'])) $message['EDITED_BY'] = 0;

            if (!isset($message['IPADDRESS'])) $message['IPADDRESS'] = "";

            if (!isset($message['FROM_RELATIONSHIP'])) $message['FROM_RELATIONSHIP'] = 0;
            if (!isset($message['TO_RELATIONSHIP'])) $message['TO_RELATIONSHIP'] = 0;

            if (isset($message['TLOGON']) && isset($message['PTNICK'])) {
                if (!is_null($message['PTNICK']) && strlen($message['PTNICK']) > 0) {
                    $message['TNICK'] = $message['PTNICK'];
                }
            }

            if (isset($message['FLOGON']) && isset($message['PFNICK'])) {
                if (!is_null($message['PFNICK']) && strlen($message['PFNICK']) > 0) {
                    $message['FNICK'] = $message['PFNICK'];
                }
            }

            if (!isset($message['FNICK'])) $message['FNICK'] = $lang['unknownuser'];
            if (!isset($message['FLOGON'])) $message['FLOGON'] = $lang['unknownuser'];
            if (!isset($message['FROM_UID'])) $message['FROM_UID'] = -1;

            if (!isset($message['TNICK'])) $message['TNICK'] = $lang['allcaps'];
            if (!isset($message['TLOGON'])) $message['TLOGON'] = $lang['allcaps'];

            if (!isset($message['MOVED_TID'])) $message['MOVED_TID'] = 0;
            if (!isset($message['MOVED_PID'])) $message['MOVED_PID'] = 0;

            if (!is_array($messages)) $messages = array();

            $messages[] = $message;
        }

        return $messages;

    }else {

        if (($messages = db_fetch_array($result))) {

            if (!isset($messages['VIEWED'])) $messages['VIEWED'] = 0;

            if (!isset($messages['APPROVED'])) $messages['APPROVED'] = 0;
            if (!isset($messages['APPROVED_BY'])) $messages['APPROVED_BY'] = 0;

            if (!isset($messages['EDITED'])) $messages['EDITED'] = 0;
            if (!isset($messages['EDITED_BY'])) $messages['EDITED_BY'] = 0;

            if (!isset($messages['IPADDRESS'])) $messages['IPADDRESS'] = "";

            if (!isset($messages['FROM_RELATIONSHIP'])) $messages['FROM_RELATIONSHIP'] = 0;
            if (!isset($messages['TO_RELATIONSHIP'])) $messages['TO_RELATIONSHIP'] = 0;

            if (!isset($messages['FNICK'])) $messages['FNICK'] = $lang['unknownuser'];
            if (!isset($messages['FLOGON'])) $messages['FLOGON'] = $lang['unknownuser'];
            if (!isset($messages['FROM_UID'])) $messages['FROM_UID'] = -1;

            if (!isset($messages['TNICK'])) $messages['TNICK'] = $lang['allcaps'];
            if (!isset($messages['TLOGON'])) $messages['TLOGON'] = $lang['allcaps'];

            if (!isset($messages['MOVED_TID'])) $messages['MOVED_TID'] = 0;
            if (!isset($messages['MOVED_PID'])) $messages['MOVED_PID'] = 0;

            if (isset($messages['PTNICK'])) {
                if (!is_null($messages['PTNICK']) && strlen($messages['PTNICK']) > 0) {
                    $messages['TNICK'] = $messages['PTNICK'];
                }
            }

            if (isset($messages['PFNICK'])) {
                if (!is_null($messages['PFNICK']) && strlen($messages['PFNICK']) > 0) {
                    $messages['FNICK'] = $messages['PFNICK'];
                }
            }

            return $messages;
        }
    }

    return false;
}

function message_get_content($tid, $pid)
{
    if (!$db_message_get_content = db_connect()) return false;

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT CONTENT FROM `{$table_data['PREFIX']}POST_CONTENT` ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!$result = db_query($sql, $db_message_get_content)) return false;

    if (db_num_rows($result) > 0) {

        list($message_content) = db_fetch_array($result, DB_RESULT_NUM);

        return $message_content;
    }

    return "";
}

function message_get_meta_content($msg, &$meta_keywords, &$meta_description)
{
    if (!validate_msg($msg)) return;
    
    list($tid, $pid) = explode('.', $msg);
    
    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");
    
    if (($thread_data = thread_get($tid)) && ($message_content = message_get_content($tid, $pid))) {
        
        $meta_keywords_array = search_strip_keywords(strip_tags(htmlentities_decode_array($message_content)));
        
        $meta_description = $thread_data['TITLE'];
        
        $meta_keywords = htmlentities_array(implode(',', $meta_keywords_array['keywords']));
    }
}

/**
* Apply message formatting such as emoticons, wikilinks to posts; ignores signatures
*
* Message text is split into the message/sig parts. If the user ignores this sig/all sigs the
* sig is set to an empty string. The message is then split into it's HTML and text parts.
* <nowiki> tags are added around <code>, <spoiler>, <a> tags
* <noemots> tags are added around <code>, <spoiler> tags
* The message is collapsed and re-split by the new <nowiki>/<noemots> tags, and wiki links and
* emoticons are added where appropriate.
*
* @return string
* @param string $message Message HTML
* @param boolean $emoticons Toggle to add emoticons (default true)
* @param boolean $ignore_sig Toggle to ignore signature (default false)
*/
function message_apply_formatting($message, $emoticons = true, $ignore_sig = false)
{
    $webtag = get_webtag();

    $message_parts = preg_split('/(<[^<>]+>)/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

    $signature_parts = array();

    if (($signature_offset = array_search("<div class=\"sig\">", $message_parts)) !== false) {

        while (sizeof($message_parts) > 0) {

            $signature_parts = array_merge($signature_parts, array_splice($message_parts, $signature_offset, 1));
            if (count(explode('<div', implode('', $signature_parts))) == count(explode('</div>', implode('', $signature_parts)))) break;
        }
    }

    $signature = implode('', $signature_parts);

    $message = implode('', $message_parts);

    $message_parts = preg_split('/<([^<>]+)>/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

    for ($j = 0; $j < 1; $j++) {

        $noemots = 0;
        $nowiki = 0;

        $fakenoemots = "";
        $fakenowiki = "";

        $opendivs = 0;
        $opena = 0;

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if ($i % 2) {

                if ($message_parts[$i] == 'noemots') {
                    $noemots++;
                }else if ($message_parts[$i] == '/noemots') {
                    $noemots--;
                }

                if ($noemots == 0 || $nowiki == 0) {

                    if (mb_strpos($message_parts[$i], 'div class="quotetext" id="code-') !== false) {

                        if ($noemots == 0) {

                            $fakenoemots = 'pre';
                            $noemots++;
                            array_splice($message_parts, $i, 0, array('noemots', ""));
                            $i += 2;
                        }

                        if ($nowiki == 0) {

                            $fakenowiki = 'pre';
                            $nowiki++;
                            array_splice($message_parts, $i, 0, array('nowiki', ""));
                            $i += 2;
                        }

                    }else if (mb_strpos($message_parts[$i], 'div class="quotetext" id="spoiler"') !== false) {

                        $opendivs = -1;

                        if ($noemots == 0) {

                            $fakenoemots = 'div';
                            $noemots++;
                            array_splice($message_parts, $i, 0, array('noemots', ""));
                            $i += 2;
                        }

                        if ($nowiki == 0) {

                            $fakenowiki = 'div';
                            $nowiki++;
                            array_splice($message_parts, $i, 0, array('nowiki', ""));
                            $i += 2;
                        }
                    }
                }

                if ($noemots != 0 || $nowiki != 0) {

                    if ($fakenoemots == 'pre' || $fakenowiki == 'pre') {

                        if ($message_parts[$i] == '/pre') {

                            if ($fakenowiki == 'pre') {

                                $fakenowiki = "";
                                $nowiki--;
                                array_splice($message_parts, $i+1, 0, array("", '/nowiki'));
                                $i += 2;
                            }

                            if ($fakenoemots == 'pre') {

                                $fakenoemots = "";
                                $noemots--;
                                array_splice($message_parts, $i+1, 0, array("", '/noemots'));
                                $i += 2;
                            }
                        }

                    }else if ($fakenoemots == 'div' || $fakenowiki == 'div') {

                        if (mb_substr($message_parts[$i], 0, 4) == 'div ' || $message_parts[$i] == 'div') {

                            if ($opendivs != -1) {

                                $opendivs++;
                            }

                        }else if ($message_parts[$i] == '/div') {

                            if ($opendivs != -1) {

                                $opendivs--;

                                if ($opendivs == 0) {

                                    if ($fakenowiki == 'div') {

                                        $fakenowiki = "";
                                        $nowiki--;
                                        array_splice($message_parts, $i+1, 0, array("", '/nowiki'));
                                        $i += 2;
                                    }

                                    if ($fakenoemots == 'div') {

                                        $fakenoemots = "";
                                        $noemots--;
                                        array_splice($message_parts, $i+1, 0, array("", '/noemots'));
                                        $i += 2;
                                    }
                                }

                            }else {

                                $opendivs = 0;
                            }
                        }
                    }
                }

                if ($nowiki == 0) {

                    if (mb_substr($message_parts[$i], 0, 2) == 'a ' || $message_parts[$i] == 'a') {

                        $nowiki++;
                        $opena++;
                        array_splice($message_parts, $i, 0, array('nowiki', ""));
                        $i += 2;
                    }

                }else {

                    if (mb_substr($message_parts[$i], 0, 2) == 'a ' || $message_parts[$i] == 'a') {

                        $opena++;

                    }else if ($message_parts[$i] == '/a') {

                        $opena--;

                        if ($opena == 0) {

                            $nowiki--;
                            array_splice($message_parts, $i+1, 0, array("", '/nowiki'));
                            $i += 2;
                        }
                    }
                }
            }
        }

        if ($j == 0) {

            $message = "";

            for ($i = 0; $i < sizeof($message_parts); $i++) {

                if ($i % 2) {

                    $message.= '<'.$message_parts[$i].'>';

                }else {

                    $message.= $message_parts[$i];
                }
            }

            if ($ignore_sig == false) {

                $message_parts = preg_split('/<([^<>]+)>/u', $signature, -1, PREG_SPLIT_DELIM_CAPTURE);

            }else {

                $signature = "";
                break;
            }

        }else {

            $signature = "";

            for ($i = 0; $i < sizeof($message_parts); $i++) {

                if ($i % 2) {

                    $signature.= '<'.$message_parts[$i].'>';

                }else {

                    $signature.= $message_parts[$i];
                }
            }
        }
    }

    $enable_wiki_words = forum_get_setting('enable_wiki_integration', 'Y') && bh_session_get_value('ENABLE_WIKI_WORDS') == 'Y';
    $enable_wiki_links = forum_get_setting('enable_wiki_quick_links', 'Y');

    if ($enable_wiki_words || $enable_wiki_links) {

        if ($enable_wiki_words) {

            $wiki_location = forum_get_setting('wiki_integration_uri', false, "");
            if (strlen($wiki_location) > 0) $wiki_location = str_replace("[WikiWord]", "\\1", $wiki_location);
        }

        $message_parts = preg_split('/<\/?nowiki>/u', $message);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 2)) {

                $html_parts = preg_split('/([<|>])/u', $message_parts[$i], -1, PREG_SPLIT_DELIM_CAPTURE);

                for ($j = 0; $j < sizeof($html_parts); $j++) {

                    if (!($j % 4) && (!isset($html_parts[$j - 2]) || !strstr($html_parts[$j - 2], "href"))) {

                        if ($enable_wiki_words) {

                            $html_parts[$j] = preg_replace('/\b(([A-Z][a-z]+){2,})\b/u', "<a href=\"$wiki_location\" class=\"wikiword\">\\1</a>", $html_parts[$j]);
                        }

                        if ($enable_wiki_links) {

                            if (defined('BEEHIVEMODE_LIGHT')) {

                                $html_parts[$j] = preg_replace('/\b(msg:([0-9]{1,}\.[0-9]{1,}))\b/iu', "<a href=\"lmessages.php?webtag=$webtag&amp;msg=\\2\" class=\"wikiword\">\\1</a>", $html_parts[$j]);

                            }else {

                                $html_parts[$j] = preg_replace('/\b(msg:([0-9]{1,}\.[0-9]{1,}))\b/iu', "<a href=\"index.php?webtag=$webtag&amp;msg=\\2\" target=\"_blank\" class=\"wikiword\">\\1</a>", $html_parts[$j]);
                                $html_parts[$j] = preg_replace('/\b(user:([a-z0-9_-]{2,15}))\b/iu', "<a href=\"user_profile.php?webtag=$webtag&amp;logon=\\2\" target=\"_blank\" class=\"wikiword popup 650x500\">\\1</a>", $html_parts[$j]);
                            }
                        }
                    }
                }

                $message_parts[$i] = implode("", $html_parts);
            }
        }

        $message = implode("", $message_parts);
    }

    if ($emoticons == true) {

        $message_parts = preg_split('/<\/?noemots>/u', $message);
        $signature_parts = preg_split('/<\/?noemots>/u', $signature);

        $message_parts = array_merge($message_parts, $signature_parts);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 2)) {

                $message_parts[$i] = emoticons_apply($message_parts[$i]);
            }
        }

        $message = implode("", $message_parts);
    }

    return preg_replace('/<\/?noemots>|<\/?nowiki>/u', '', $message);
}

function messages_top($tid, $pid, $folder_fid, $folder_title, $thread_title, $thread_interest_level = THREAD_NOINTEREST, $folder_interest_level = FOLDER_NOINTEREST, $sticky = "N", $closed = false, $locked = false, $deleted = false, $frame_links = true, $highlight_array = array())
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $frame_top_target = html_get_top_frame_name();

    $thread_title = htmlentities_array($thread_title);

    $folder_title = htmlentities_array($folder_title);

    if (is_array($highlight_array) && sizeof($highlight_array) > 0) {

        $highlight_pattern = array();
        $highlight_replace = array();

        foreach ($highlight_array as $key => $word) {

            $highlight_word = preg_quote($word, "/");

            $highlight_pattern[$key] = "/($highlight_word)/iu";
            $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
        }

        $thread_parts = preg_split('/([<|>])/u', htmlentities_array($thread_title), -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($thread_parts); $i++) {

            if (!($i % 4)) {

                $thread_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $thread_parts[$i], 1);
            }
        }

        $thread_title = implode('', $thread_parts);
    }

    if ($folder_interest_level == FOLDER_SUBSCRIBED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".style_image('folder_subscribed.png')."\" alt=\"{$lang['subscribedfolder']}\" title=\"{$lang['subscribedfolder']}\" border=\"0\" /></a>&nbsp;";
    }else if ($folder_interest_level == FOLDER_IGNORED) {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".style_image('folder_ignored.png')."\" alt=\"{$lang['ignoredfolder']}\" title=\"{$lang['ignoredfolder']}\" border=\"0\" /></a>&nbsp;";
    }else {
        echo "<p><a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_fid\" target=\"_blank\" class=\"popup 550x400\"><img src=\"".style_image('folder.png')."\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" border=\"0\" /></a>&nbsp;";
    }

    if ($frame_links) {

        echo "<a href=\"index.php?webtag=$webtag&amp;folder=$folder_fid\" target=\"$frame_top_target\">", word_filter_add_ob_tags($folder_title), "</a>";
        echo "<img src=", style_image('separator.png'), " alt=\"\" border=\"0\" />";
        echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"$frame_top_target\" title=\"{$lang['viewinframeset']}\">", word_filter_add_ob_tags($thread_title), "</a>";

    }else {

        echo word_filter_add_ob_tags($folder_title), "<img src=", style_image('separator.png'), " alt=\"\" />", word_filter_add_ob_tags($thread_title);
    }

    if ($closed) echo "&nbsp;<img src=\"", style_image('thread_closed.png'), "\" alt=\"{$lang['closed']}\" title=\"{$lang['closed']}\" />\n";
    if ($thread_interest_level == THREAD_INTERESTED) echo "&nbsp;<img src=\"", style_image('high_interest.png'), "\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" />";
    if ($thread_interest_level == THREAD_SUBSCRIBED) echo "&nbsp;<img src=\"", style_image('subscribe.png'), "\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" />";
    if ($sticky == "Y") echo "&nbsp;<img src=\"", style_image('sticky.png'), "\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" />";
    if ($locked) echo "&nbsp;<img src=\"", style_image('admin_locked.png'), "\" alt=\"{$lang['locked']}\" title=\"{$lang['locked']}\" />\n";
    if ($deleted) echo "&nbsp;<img src=\"", style_image('delete.png'), "\" alt=\"{$lang['deleted']}\" title=\"{$lang['deleted']}\" />\n";

    echo "</p>";
}

function messages_bottom()
{
    echo "<p align=\"right\">Beehive Forum 2002</p>\n";
}

function message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $lang = load_language_file();

    $perm_is_moderator = bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);
    $perm_has_admin_access = bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0);

    $post_edit_time = forum_get_setting('post_edit_time', false, 0);
    $post_edit_grace_period = forum_get_setting('post_edit_grace_period', false, 0);

    $webtag = get_webtag();

    if (($uid = bh_session_get_value('UID')) === false) return;

    if (($posts_per_page = bh_session_get_value('POST_PER_PAGE')) === false) {
        $posts_per_page = 20;
    }

    if (($quick_reply = bh_session_get_value('REPLY_QUICK')) === false) {
        $quick_reply = 'N';
    }

    if (!isset($message['CONTENT']) || $message['CONTENT'] == "") {

        message_display_deleted($tid, isset($message['PID']) ? $message['PID'] : 0, $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    $from_user_permissions = perm_get_user_permissions($message['FROM_UID']);

    if ($uid != $message['FROM_UID']) {

        if (($from_user_permissions & USER_PERM_WORMED) && !$perm_is_moderator) {

            message_display_deleted($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
            return;
        }
    }

    if (!isset($message['FROM_RELATIONSHIP'])) {

        $message['FROM_RELATIONSHIP'] = 0;
    }

    if (!isset($message['TO_RELATIONSHIP'])) {

        $message['TO_RELATIONSHIP'] = 0;
    }

    if (($message['TO_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) || ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

        message_display_deleted($tid, $message['PID'], $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
        return;
    }

    // Add emoticons/WikiLinks and ignore signature ----------------------------
    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {

        $message['CONTENT'] = preg_replace('/<a([^>]*)href="([^"]*)"([^\>]*)><img[^>]*src="([^"]*)"[^>]*><\/a>/iu', '[href: <a\1href="\2"\3>\2</a>][img: <a\1href="\4"\3>\4</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<img[^>]*src="([^"]*)"[^>]*>/iu', '[img: <a href="\1">\1</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<embed[^>]*src="([^"]*)"[^>]*>/iu', '[object: <a href="\1">\1</a>]', $message['CONTENT']);
    }

    if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = message_apply_formatting($message['CONTENT'], true, (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs));
    }

    // Check length of post to see if we should truncate it for display --------
    if ((mb_strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', false, 6226))) && $limit_text) {

        $cut_msg = mb_substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', false, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/Du", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg, false);
        $message['CONTENT'].= "&hellip;[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    // Check for words that should be filtered ---------------------------------
    if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT']);
    }

    if ($in_list && isset($message['PID'])){
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
    if (forum_get_setting('require_post_approval', 'Y') && $message['FROM_UID'] != $uid) {

        if (isset($message['APPROVED']) && $message['APPROVED'] == 0 && !$perm_is_moderator) {

            message_display_approval_req($tid, $message['PID'], $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page);
            return;
        }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------
    if (!$is_preview && ($message['MOVED_TID'] > 0) && ($message['MOVED_PID'] > 0)) {

        $post_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_self\">%s</a>";
        $post_link = sprintf($post_link, $message['MOVED_TID'], $message['MOVED_PID'], $lang['threadmovedhere']);

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<table class=\"thread_track_notice\" width=\"96%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\">", sprintf($lang['thisposthasbeenmoved'], $post_link), "</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        return;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";
    
    if ($in_list && !$is_preview) message_display_navigation($tid, $message['PID'], $first_msg, $msg_count, $posts_per_page);

    echo "    <td align=\"left\">\n";
    echo "      <table width=\"98%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
    echo "                <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if ($message['FROM_UID'] > -1) {

        echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(htmlentities_array(format_user_name($message['FLOGON'], $message['FNICK']))), "</a></span>";

    }else {

        echo word_filter_add_ob_tags(htmlentities_array(format_user_name($message['FLOGON'], $message['FNICK']))), "</span>";
    }

    $temp_ignore = false;

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && isset($message['PID']) && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {

        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if ($message['FROM_RELATIONSHIP'] & USER_FRIEND) {

        echo "&nbsp;&nbsp;<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";

    }else if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) || $temp_ignore) {

        echo "&nbsp;&nbsp;<img src=\"", style_image('enemy.png'), "\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
    }

    echo "</td>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $uid != 0) {

        echo "<b>{$lang['ignoredmsg']}</b>";

    }else {

        if ($in_list) {

            if ($from_user_permissions & USER_PERM_WORMED) echo "<b>{$lang['wormeduser']}</b> ";
            if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>{$lang['ignoredsig']}</b> ";
            if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] == 0) echo "<b>{$lang['approvalrequired']}</b> ";

            echo format_time($message['CREATED'], 1);
        }
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
    echo "                <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if (($message['TLOGON'] != $lang['allcaps']) && $message['TO_UID'] != 0) {

        echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(htmlentities_array(format_user_name($message['TLOGON'], $message['TNICK']))), "</a></span>";

        if ($message['TO_RELATIONSHIP'] & USER_FRIEND) {

            echo "&nbsp;<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";

        }else if ($message['TO_RELATIONSHIP'] & USER_IGNORED) {

            echo "&nbsp;<img src=\"", style_image('enemy.png'), "\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
        }

        if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {

            echo "&nbsp;<span class=\"smalltext\"><img src=\"", style_image('post_read.png'), "\" alt=\"\" title=\"", sprintf($lang['readtime'], format_time($message['VIEWED'], 1)), "\" /></span>";

        }else {

            if ($is_preview == false) {

                echo "&nbsp;<span class=\"smalltext\"><img src=\"", style_image('post_unread.png'), "\" alt=\"\" title=\"{$lang['unreadmessage']}\" /></span>";
            }
        }

    }else {

        echo "{$lang['all_caps']}</span>";
    }

    echo "</td>\n";
    echo "                <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $in_list && $uid != 0) {

        echo "<a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['stopignoringthisuser']}</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewmessage']}</a>";

    }else if ($in_list && $msg_count > 0) {

        if ($is_poll) {

            echo "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" class=\"popup 640x480\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" /></a> {$lang['poll']} ";
        }

        echo sprintf($lang['messagecountdisplay'], $message['PID'], $msg_count);
    }

    echo "&nbsp;</span></td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";

    if (!($message['FROM_RELATIONSHIP'] & USER_IGNORED) || !$limit_text) {

        echo "        <tr>\n";
        echo "          <td align=\"left\">\n";
        echo "            <table width=\"100%\">\n";
        echo "              <tr>\n";
        echo "                <td colspan=\"3\" align=\"right\"><span class=\"postnumber\">";

        if ($in_list && $msg_count > 0) {

            $title = ($message['PID'] ==1) ? "{$lang['linktothread']} ($tid.1)" : "{$lang['linktothispost']}";

            if ($is_preview) {

                echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_blank\" title=\"$title\">$tid.{$message['PID']}</a>";

            }else {

                echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"", html_get_top_frame_name(), "\" title=\"$title\">$tid.{$message['PID']}</a>";
            }

            if ($message['REPLY_TO_PID'] > 0) {

                $title = "{$lang['linktopost']} #{$message['REPLY_TO_PID']}";

                echo " {$lang['inreplyto']} ";

                if (intval($message['REPLY_TO_PID']) >= intval($first_msg)) {

                    echo "<a href=\"#a{$tid}_{$message['REPLY_TO_PID']}\" target=\"_self\" title=\"$title\">";
                    echo "{$tid}.{$message['REPLY_TO_PID']}</a>";

                }else {

                    if ($is_preview) {

                        echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.{$message['REPLY_TO_PID']}\" target=\"_blank\" title=\"$title\">";
                        echo "{$tid}.{$message['REPLY_TO_PID']}</a>";

                    }else {

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

                if (($edit_user = user_get_logon($message['EDITED_BY']))) {

                    echo "              <tr>\n";
                    echo "                <td class=\"postbody\" align=\"left\"><p class=\"edit_text\">", sprintf($lang['editedbyuser'], format_time($message['EDITED'], 1), $edit_user), "</p></td>\n";
                    echo "              </tr>\n";
                }
            }
        }

        if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] > 0 && $perm_is_moderator) {

            if (isset($message['APPROVED_BY']) && $message['APPROVED_BY'] > 0 && $message['APPROVED_BY'] != $message['FROM_UID']) {

                if (($approved_user = user_get_logon($message['APPROVED_BY']))) {

                    echo "              <tr>\n";
                    echo "                <td class=\"postbody\" align=\"left\"><p class=\"approved_text\">", sprintf($lang['approvedbyuser'], format_time($message['APPROVED'], 1), $approved_user), "</p></td>\n";
                    echo "              </tr>\n";
                }
            }
        }

        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

            $aid = isset($message['AID']) ? $message['AID'] : attachments_get_id($tid, $message['PID']);

            $attachments_array = array();
            $image_attachments_array = array();

            if (attachments_get($message['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\">\n";

                if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                    echo "                  <p><b>{$lang['attachments']}:</b><br />\n";

                    foreach ($attachments_array as $attachment) {

                        echo "                  ", attachments_make_link($attachment), "<br />\n";
                    }

                    echo "                  </p>\n";
                }

                if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                    echo "                  <p><b>{$lang['imageattachments']}:</b><br />\n";

                    foreach ($image_attachments_array as $key => $attachment) {

                        echo "                  ", attachments_make_link($attachment), "\n";
                    }

                    echo "                  </p>\n";
                }

                echo "                </td>\n";
                echo "              </tr>\n";
            }
        }

        echo "            </table>\n";

        if (!$is_preview) {

            echo "            <table width=\"100%\" class=\"postresponse\" cellspacing=\"1\" cellpadding=\"0\">\n";
            echo "              <tr>\n";
            
            if (isset($message['ANON_LOGON']) && $message['ANON_LOGON'] > USER_ANON_DISABLED) {
                
                echo "                <td width=\"25%\" align=\"left\">&nbsp;</td>";
                
            }else if (isset($message['ANON_LOGON_GLOBAL']) && $message['ANON_LOGON_GLOBAL'] > USER_ANON_DISABLED) {
                
                echo "                <td width=\"25%\" align=\"left\">&nbsp;</td>";
                
            }else if (isset($message['USER_ACTIVE'])) {
            
                if ($message['USER_ACTIVE'] == 1) {
                    
                    echo "                <td width=\"25%\" align=\"left\">";
                    echo "                  <img src=\"", style_image('status_online.png'), "\" alt=\"\" title=\"{$lang['useractive']}\" />";
                    echo "                </td>\n";
                    
                } else {
                    
                    echo "                <td width=\"25%\" align=\"left\">";
                    echo "                  <img src=\"", style_image('status_offline.png'), "\" alt=\"\" title=\"{$lang['userinactive']}\" />";
                    echo "                </td>\n";
                }
            }
            
            echo "                <td width=\"50%\" nowrap=\"nowrap\">";

            if ($msg_count > 0) {

                if ((!$closed && bh_session_check_perm(USER_PERM_POST_CREATE, $folder_fid)) || $perm_is_moderator) {

                    if ($quick_reply =='Y') {

                        echo "<img src=\"", style_image('quickreply.png'), "\" border=\"0\" alt=\"{$lang['quickreply']}\" title=\"{$lang['quickreply']}\" />\n";
                        echo "<a href=\"Javascript:void(0)\" rel=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">{$lang['quickreply']}</a>\n";

                    }else {

                        echo "<img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />";
                        echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\" id=\"reply_{$message['PID']}\">{$lang['reply']}</a>";
                    }

                    echo "&nbsp;&nbsp;<img src=\"", style_image('quote_disabled.png'), "\" border=\"0\" alt=\"{$lang['quote']}\" title=\"{$lang['quote']}\" id=\"quote_img_{$message['PID']}\" />";
                    echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}&amp;quote_list={$message['PID']}\" target=\"_parent\" title=\"{$lang['quote']}\" id=\"quote_{$message['PID']}\" rel=\"{$message['PID']}\">{$lang['quote']}</a>";

                    if ((!(bh_session_check_perm(USER_PERM_PILLORIED, 0)) && ((($uid != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($uid == $message['FROM_UID'])) && bh_session_check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

                        if ($is_poll && $message['PID'] == 1) {

                            if (!poll_is_closed($tid) || $perm_is_moderator) {

                                echo "&nbsp;&nbsp;<img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['editpoll']}\" title=\"{$lang['editpoll']}\" />";
                                echo "&nbsp;<a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['editpoll']}</a>\n";
                            }

                        }else {

                            echo "&nbsp;&nbsp;<img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />";
                            echo "&nbsp;<a href=\"edit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['edit']}</a>";
                        }
                    }
                }

            }else {

                echo "&nbsp;";
            }

            echo "</td>\n";
            echo "                <td width=\"25%\" align=\"right\" nowrap=\"nowrap\">\n";
            echo "                  <a href=\"javascript:void(0)\" target=\"_self\" class=\"post_options_link\">{$lang['more']}&nbsp;<img src=\"", style_image('post_options.png'), "\" class=\"post_options\" alt=\"{$lang['options']}\" title=\"{$lang['options']}\" id=\"post_options_{$message['PID']}\" border=\"0\" /></a>\n";
            echo "                  <div class=\"post_options_container\">\n";
            echo "                    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" colspan=\"3\">\n";
            echo "                          <table class=\"box\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" class=\"posthead\">\n";
            echo "                                <table class=\"posthead\" width=\"100%\">\n";
            echo "                                  <tr>\n";
            echo "                                    <td class=\"subhead\" colspan=\"2\">{$lang['postoptions']}</td>\n";
            echo "                                  </tr>\n";
            echo "                                  <tr>\n";
            echo "                                    <td align=\"center\">\n";
            echo "                                      <table width=\"95%\" class=\"post_options_menu\">\n";
            echo "                                        <tr>\n";

            if ($quick_reply=='N') {

                echo "                                          <td align=\"left\"><a href=\"Javascript:void(0)\" rel=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\"><img src=\"", style_image('quickreply.png'), "\" border=\"0\" alt=\"{$lang['quickreply']}\" title=\"{$lang['quickreply']}\" /></a></td>\n";
                echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"Javascript:void(0)\" rel=\"$tid.{$message['PID']}\" target=\"_self\" class=\"quick_reply_link\">{$lang['quickreply']}</a></td>\n";

            }else {

                echo "                                          <td align=\"left\"><img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" /></td>\n";
                echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\" id=\"reply_{$message['PID']}\">{$lang['reply']}</a></td>\n";
            }

            echo "                                        </tr>\n";

            if (($uid == $message['FROM_UID'] && bh_session_check_perm(USER_PERM_POST_DELETE, $folder_fid) && !bh_session_check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

                echo "                                        <tr>\n";
                echo "                                          <td align=\"left\"><a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\"><img src=\"", style_image('delete.png'), "\" border=\"0\" alt=\"{$lang['delete']}\" title=\"{$lang['delete']}\" /></a></td>\n";
                echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['delete']}</a></td>\n";
                echo "                                        </tr>\n";
            }

            echo "                                        <tr>\n";
            echo "                                          <td align=\"left\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"{$lang['pm_reply']}\"><img src=\"", style_image('pmunread.png'), "\" border=\"0\" alt=\"{$lang['pm_reply']}\" title=\"{$lang['pm_reply']}\" /></a></td>\n";
            echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"{$lang['pm_reply']}\">{$lang['pm_reply']}</a></td>\n";
            echo "                                        </tr>\n";
            echo "                                        <tr>\n";
            echo "                                          <td align=\"left\"><a href=\"display.php?webtag=$webtag&amp;print_msg=$tid.{$message['PID']}\" target=\"_self\" title=\"{$lang['print']}\"><img src=\"", style_image('print.png'), "\" border=\"0\" alt=\"{$lang['print']}\" title=\"{$lang['print']}\" /></a></td>\n";
            echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"display.php?webtag=$webtag&amp;print_msg=$tid.{$message['PID']}\" target=\"_self\" title=\"{$lang['print']}\">{$lang['print']}</a></td>\n";
            echo "                                        </tr>\n";
            echo "                                        <tr>\n";
            echo "                                          <td align=\"left\"><a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$first_msg&amp;markasread=", ($message['PID'] - 1), "\" target=\"_self\" title=\"{$lang['markasunread']}\"><img src=\"", style_image('markasunread.png'), "\" border=\"0\" alt=\"{$lang['markasunread']}\" title=\"{$lang['markasunread']}\" /></a></td>\n";
            echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$first_msg&amp;markasread=", ($message['PID'] - 1), "\" target=\"_self\" title=\"{$lang['markasunread']}\">{$lang['markasunread']}</a></td>\n";
            echo "                                        </tr>\n";

            if ($uid != $message['FROM_UID']) {

                echo "                                        <tr>\n";
                echo "                                          <td align=\"left\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['relationship']}\"><img src=\"", style_image('enemy.png'), "\" border=\"0\" alt=\"{$lang['relationship']}\" title=\"{$lang['relationship']}\" /></a></td>\n";
                echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['relationship']}\">{$lang['relationship']}</a></td>\n";
                echo "                                        </tr>\n";
            }

            if ($perm_has_admin_access) {

                echo "                                        <tr>\n";
                echo "                                          <td align=\"left\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['privileges']}\"><img src=\"", style_image('admintool.png'), "\" border=\"0\" alt=\"{$lang['privileges']}\" title=\"{$lang['privileges']}\" /></a></td>\n";
                echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['privileges']}\">{$lang['privileges']}</a></td>\n";
                echo "                                        </tr>\n";
            }

            if ($perm_is_moderator || $perm_has_admin_access) {

                if ($perm_is_moderator) {

                    if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] == 0) {

                        echo "                                        <tr>\n";
                        echo "                                          <td align=\"left\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D$tid.{$message['PID']}\" target=\"_self\" title=\"{$lang['approvepost']}\"><img src=\"", style_image('approved.png'), "\" border=\"0\" alt=\"{$lang['approvepost']}\" title=\"{$lang['approvepost']}\" /></a></td>\n";
                        echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}&ret=messages.php%3Fwebtag%3D$webtag%26msg%3D$tid.{$message['PID']}\" target=\"_self\" title=\"{$lang['approvepost']}\">{$lang['approvepost']}</a></td>\n";
                        echo "                                        </tr>\n";
                    }
                }

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

                    echo "                                        <tr>\n";
                    echo "                                          <td align=\"left\"><span class=\"adminipdisplay\"><b>{$lang['ip']}</b></span></td>\n";
                    echo "                                          <td align=\"left\" nowrap=\"nowrap\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$message['IPADDRESS']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$message['IPADDRESS']}</a></td>\n";
                    echo "                                        </tr>";

                }else {

                    echo "                                        <tr>\n";
                    echo "                                          <td align=\"left\"><span class=\"adminipdisplay\"><b>{$lang['ip']}</b></span></td>\n";
                    echo "                                          <td align=\"left\" nowrap=\"nowrap\">{$lang['notlogged']}</td>\n";
                    echo "                                        </tr>";
                }

            }else {

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

                    if ($uid == $message['FROM_UID']) {

                        echo "                                        <tr>\n";
                        echo "                                          <td align=\"left\"><span class=\"adminipdisplay\"><b>{$lang['ip']}</b></span></td>\n";
                        echo "                                          <td align=\"left\" nowrap=\"nowrap\">{$message['IPADDRESS']}</td>\n";
                        echo "                                        </tr>";

                    }else {

                        echo "                                        <tr>\n";
                        echo "                                          <td align=\"left\"><span class=\"adminipdisplay\"><b>{$lang['ip']}</b></span></td>\n";
                        echo "                                          <td align=\"left\" nowrap=\"nowrap\">{$lang['logged']}</td>\n";
                        echo "                                        </tr>";
                    }

                }else {

                    echo "                                        <tr>\n";
                    echo "                                          <td align=\"left\"><span class=\"adminipdisplay\"><b>{$lang['ip']}</b></span></td>\n";
                    echo "                                          <td align=\"left\" nowrap=\"nowrap\">{$lang['logged']}</td>\n";
                    echo "                                        </tr>";
                }
            }

            echo "                                      </table>\n";
            echo "                                    </td>\n";
            echo "                                  </tr>\n";
            echo "                                </table>\n";
            echo "                              </td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </div>\n";
            echo "                </td>\n";
            echo "              </tr>";
            echo "            </table>\n";

        }else {

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
    echo "    </tr>\n";
    echo "  </table>\n";

    if ($in_list && isset($message['PID'])) {
        echo "  <div id=\"quick_reply_{$message['PID']}\"></div>\n";
    }

    echo "</div>\n";
}

function message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page)
{
    $webtag = get_webtag();
    
    $lang = load_language_file();
    
    echo "    <td align=\"left\" width=\"2%\" valign=\"top\">\n";
    echo "      <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"center\">\n";    

    if ($pid > 1) {

        if ($pid == $first_msg) {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.", $pid - 1, "\" target=\"_self\">";
            echo "<img src=\"", style_image("message_up.png"), "\" border=\"0\" alt=\"{$lang['prev']}\" title=\"{$lang['prev']}\" /></a>";

        }else {

            echo "<a href=\"#a{$tid}_", $pid - 1, "\" target=\"_self\">";
            echo "<img src=\"", style_image("message_up.png"), "\" border=\"0\" alt=\"{$lang['prev']}\" title=\"{$lang['prev']}\" /></a>";
        }
    }
    
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"center\">\n";
    
    if ($pid <> $msg_count) {

        if ((($first_msg + $posts_per_page) - 1) == $pid) {

            echo "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.", $pid + 1, "\" target=\"_self\">";
            echo "<img src=\"", style_image("message_down.png"), "\" border=\"0\" alt=\"{$lang['next']}\" title=\"{$lang['next']}\" /></a>";

        }else {

            echo "<a href=\"#a{$tid}_", $pid + 1, "\" target=\"_self\">";
            echo "<img src=\"", style_image("message_down.png"), "\" border=\"0\" alt=\"{$lang['next']}\" title=\"{$lang['next']}\" /></a>";
        }
    }
    
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
}

function message_display_deleted($tid, $pid, $message, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    $lang = load_language_file();

    echo "<br /><div align=\"center\">";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";
    
    if ($in_list && !$is_preview) message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page);
    
    echo "    <td align=\"left\">\n";
    echo "      <table width=\"98%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";

    if (isset($message['EDITED']) && $message['EDITED'] > 0) {

        if (($edit_user = user_get_logon($message['EDITED_BY']))) {

            $message_delete_time = format_time($message['EDITED'], 1);
            echo "                <td align=\"left\">", sprintf($lang['messagedeletedbyuser'], $tid, $pid, $message_delete_time, $edit_user), "</td>\n";

        }else {

            echo "                <td align=\"left\">", sprintf($lang['messagedeleted'], $tid, $pid), "</td>\n";
        }

    }else {

        echo "                <td align=\"left\">", sprintf($lang['messagedeleted'], $tid, $pid), "</td>\n";
    }

    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

function message_display_approval_req($tid, $pid, $in_list, $is_preview, $first_msg, $msg_count, $posts_per_page)
{
    $lang = load_language_file();

    echo "<br /><div align=\"center\">";
    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";
    
    if ($in_list && !$is_preview) message_display_navigation($tid, $pid, $first_msg, $msg_count, $posts_per_page);
    
    echo "    <td align=\"left\">\n";
    echo "      <table width=\"98%\" class=\"box\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"left\">", sprintf($lang['messageawaitingapprovalbymoderator'], $tid, $pid), "</td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
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
    $lang = load_language_file();

    $webtag = get_webtag();

    if ($pid < 2 && $length < $ppp) {
        return;
    }else if ($pid < 1) {
        $pid = 1;
    }

    $c = 0;

    $spid = $pid % $ppp;

    if ($spid > 1) {
        
        if ($pid > 1) {
            
            $navbits[0] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">". mess_nav_range(1, $spid - 1). "</a>";
            
        }else {
            
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1);
        }
        
        $i = 1;
        
    }else {
        
        $i = 0;
    }

    while ($spid + ($ppp - 1) < $length) {
        
        if ($spid == $pid) {
            
            $c = $i;
            $navbits[$i] = mess_nav_range($spid, $spid + ($ppp - 1));
            
        }else {
            
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($spid == 0 ? 1 : $spid). "\" target=\"_self\">". mess_nav_range($spid == 0 ? 1 : $spid, $spid + ($ppp - 1)). "</a>";
        }
        
        $spid += $ppp;
        
        $i++;
    }

    if ($spid <= $length) {
        
        if ($spid == $pid) {
            
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length);
            
        }else {
            
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$spid\" target=\"_self\">". mess_nav_range($spid,$length). "</a>";
        }
    }

    $max = $i;

    $html = "{$lang['showmessages']}:";

    if ($length <= $ppp) {
        $html.= " <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">{$lang['all']}</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max) {
                
                $html.= "\n&nbsp;". $navbits[$i];
                
            }else if (abs($c - $i) == 4) {
                
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
    }else {
        $range = sprintf("%d-%d", $from, $to);
    }
    return $range;
}

function messages_interest_form($tid, $pid, $interest)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $interest_levels_array = array(THREAD_IGNORED => $lang['ignore'],
                                   THREAD_NOINTEREST => $lang['normal'],
                                   THREAD_INTERESTED => $lang['interested'],
                                   THREAD_SUBSCRIBED => $lang['subscribed']);

    echo "<table class=\"posthead\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"rate_interest\" target=\"_self\" action=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$pid\" method=\"post\">\n";
    echo "        ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "        {$lang['ratemyinterest']}: ", form_radio_array("setinterest", $interest_levels_array, htmlentities_array($interest));
    echo "        ", form_input_hidden("tid", htmlentities_array($tid));
    echo "        ", form_submit("apply", $lang['apply']), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
}

function message_get_user($tid, $pid)
{
    if (!$db_message_get_user = db_connect()) return false;

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT FROM_UID FROM `{$table_data['PREFIX']}POST` ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!$result = db_query($sql, $db_message_get_user)) return false;

    if (db_num_rows($result) > 0) {

        list($from_uid) = db_fetch_array($result, DB_RESULT_NUM);
        return $from_uid;
    }

    return "";
}

function message_get_user_array($tid, $pid)
{
    if (!$db_message_get_user = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = '$pid'";

    if (!$result = db_query($sql, $db_message_get_user)) return false;

    if (db_num_rows($result) > 0) {

        $user_array = db_fetch_array($result);

        if (isset($user_array['LOGON']) && isset($user_array['PEER_NICKNAME'])) {
            if (!is_null($user_array['PEER_NICKNAME']) && strlen($user_array['PEER_NICKNAME']) > 0) {
                $user_array['NICKNAME'] = $user_array['PEER_NICKNAME'];
            }
        }

        if (!isset($user_array['LOGON'])) $user_array['LOGON'] = $lang['unknownuser'];
        if (!isset($user_array['NICKNAME'])) $user_array['NICKNAME'] = "";

        return $user_array;
    }

    return false;
}

/**
* Update last read post in a thread and increments thread view count
*
* Updates LAST_READ column in USER_THREAD to last displayed post.
* Increments VIEWCOUNT column in THREAD_STATS.
*
* @return bool
* @param integer $tid - Thread ID
* @param integer $pid - Post ID
* @param integer $last_read - User's last read post
* @param integer $length - Length of the thread.
* @param integer $modified - Unix Timestamp thread modified date for mark as read cutoff.
*/

function messages_update_read($tid, $pid, $last_read, $length, $modified)
{
    if (!$db_message_update_read = db_connect()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($last_read)) return false;
    if (!is_numeric($length)) return false;
    if (!is_numeric($modified)) return false;

    // Check for existing entry in USER_THREAD
    if (!$table_data = get_table_prefix()) return false;

    // User UID
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    // Mark as read cut off
    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    // Guest users' can't mark as read!
    if (!user_is_guest() && ($pid > $last_read)) {

        if (($unread_cutoff_timestamp !== false) && ($modified > $unread_cutoff_timestamp)) {

            $unread_cutoff_datetime = forum_get_unread_cutoff_datetime();

            // Get the last PID within the unread-cut-off.
            $sql = "SELECT COALESCE(MAX(POST.PID), 0) AS UNREAD_PID ";
            $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
            $sql.= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
            $sql.= "AND POST.TID = '$tid'";

            if (!$result = db_query($sql, $db_message_update_read)) return false;

            list($unread_pid) = db_fetch_array($result, DB_RESULT_NUM);

            // If the specified PID is lower than the cut-off set it to the cut-off.
            $pid = ($pid < $unread_pid) ? $unread_pid : $pid;

            // Update the unread data.
            $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT) ";
            $sql.= "VALUES ('$uid', '$tid', '$pid', CAST('$current_datetime' AS DATETIME)) ON DUPLICATE KEY UPDATE ";
            $sql.= "LAST_READ = VALUES(LAST_READ), LAST_READ_AT = CAST('$current_datetime' AS DATETIME)";

            if (!$result = db_query($sql, $db_message_update_read)) return false;
        }
    }

    // Mark posts as Viewed
    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST` SET VIEWED = CAST('$current_datetime' AS DATETIME) ";
    $sql.= "WHERE TID = '$tid' AND PID BETWEEN 1 AND '$pid' AND TO_UID = '$uid' AND VIEWED IS NULL";

    if (!$result = db_query($sql, $db_message_update_read)) return false;

    // Update thread viewed counter
    $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD_STATS` ";
    $sql.= "(TID, VIEWCOUNT) VALUES ('$tid', 1) ON DUPLICATE KEY ";
    $sql.= "UPDATE VIEWCOUNT = VIEWCOUNT + 1";

    if (!$result = db_query($sql, $db_message_update_read)) return false;

    return true;
}

function messages_set_read($tid, $pid, $uid, $modified)
{
    if (!$db_message_set_read = db_connect()) return 1;

    if (!is_numeric($tid)) return 2;
    if (!is_numeric($pid)) return 3;
    if (!is_numeric($uid)) return 4;

    // Check for existing entry in USER_THREAD
    if (!$table_data = get_table_prefix()) return 5;

    // Mark as read cut off
    $unread_cutoff_stamp = forum_get_unread_cutoff();

    // Guest can't mark as read
    if ($uid > 0) {

        if (($unread_cutoff_stamp !== false) && ($modified > $unread_cutoff_stamp)) {

            $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}USER_THREAD` ";
            $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NULL ";
            $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

            if (!db_query($sql, $db_message_set_read)) return 6;

            if (db_affected_rows($db_message_set_read) < 1) {

                $sql = "INSERT IGNORE INTO `{$table_data['PREFIX']}USER_THREAD` ";
                $sql.= "(UID, TID, LAST_READ, LAST_READ_AT) ";
                $sql.= "VALUES ($uid, $tid, $pid, NULL)";

                if (!db_query($sql, $db_message_set_read)) return 7;
            }
        }
    }

    // Mark posts as Viewed...
    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST` SET VIEWED = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID >= '$pid' AND TO_UID = '$uid'";

    if (!db_query($sql, $db_message_set_read)) return 8;

    return 9;
}

function messages_get_most_recent($uid, $fid = false)
{
    if (!$db_messages_get_most_recent = db_connect()) return false;

    if (is_numeric($fid)) {
        $fidlist = $fid;
    }else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_message = messages_get_most_recent_unread($uid, $fid))) {
        return $unread_message;
    }

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    $user_ignored = USER_IGNORED;

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "THREAD.LENGTH, USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD.UNREAD_PID FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' ";
    $sql.= "AND THREAD.LENGTH > 0 AND (USER_PEER.RELATIONSHIP IS NULL ";
    $sql.= "OR (USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_messages_get_most_recent)) return false;

    if (db_num_rows($result) > 0) {

        $message_data = db_fetch_array($result);

        if (user_is_guest()) {

           return "{$message_data['TID']}.1";

        }else if (!isset($message_data['LAST_READ']) || !is_numeric($message_data['LAST_READ'])) {

            $message_data['LAST_READ'] = 1;

            if (isset($message_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $message_data['MODIFIED'] < $unread_cutoff_timestamp) {
                $message_data['LAST_READ'] = $message_data['LENGTH'];
            }else if (isset($message_data['UNREAD_PID']) && is_numeric($message_data['UNREAD_PID']) && $message_data['UNREAD_PID'] > 0) {
                $message_data['LAST_READ'] = $message_data['UNREAD_PID'];
            }

            return "{$message_data['TID']}.{$message_data['LAST_READ']}";

        }else {

            if ($message_data['LAST_READ'] < $message_data['LENGTH']) {
                $message_data['LAST_READ']++;
            }

            return "{$message_data['TID']}.{$message_data['LAST_READ']}";
        }
    }

    return false;
}

function messages_get_most_recent_unread($uid, $fid = false)
{
    if (!$db_messages_get_most_recent = db_connect()) return false;

    if (is_numeric($fid)) {
        $fidlist = $fid;
    }else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    $user_ignored = USER_IGNORED;

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "THREAD.LENGTH, USER_THREAD.LAST_READ, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD.UNREAD_PID FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ";
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

    if (!$result = db_query($sql, $db_messages_get_most_recent)) return false;

    if (db_num_rows($result) > 0) {

        $message_data = db_fetch_array($result);

        if (user_is_guest()) {

           return "{$message_data['TID']}.1";

        }else if (!isset($message_data['LAST_READ']) || !is_numeric($message_data['LAST_READ'])) {

            $message_data['LAST_READ'] = 1;

            if (isset($message_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $message_data['MODIFIED'] < $unread_cutoff_timestamp) {
                $message_data['LAST_READ'] = $message_data['LENGTH'];
            }else if (isset($message_data['UNREAD_PID']) && is_numeric($message_data['UNREAD_PID'])) {
                $message_data['LAST_READ'] = $message_data['UNREAD_PID'];
            }

            return "{$message_data['TID']}.{$message_data['LAST_READ']}";

        }else {

            if ($message_data['LAST_READ'] < $message_data['LENGTH']) {
                $message_data['LAST_READ']++;
            }

            return "{$message_data['TID']}.{$message_data['LAST_READ']}";
        }
    }

    return false;
}

function messages_fontsize_form($tid, $pid, $return = false, $font_size = false)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    // Valid TID and PID.
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    // Check to see if we've been passed a font size
    if (!is_numeric($font_size)) {

        if (($font_size = bh_session_get_value('FONT_SIZE')) === false) {
            $font_size = 10;
        }
    }

    // Start of HTML.
    $font_size_html = array("{$lang['adjtextsize']}:");

    // Check font size is greater than 4
    if ($font_size > 5) {
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=smaller\" target=\"_self\" class=\"font_size\">{$lang['smaller']}</a>";
    }

    // Add the current font size.
    $font_size_html[] = $font_size;

    // Check the font size is lower than 16
    if ($font_size < 15) {
        $font_size_html[] = "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=larger\" target=\"_self\" class=\"font_size\">{$lang['larger']}</a>\n";
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
    $lang = load_language_file();

    $webtag = get_webtag();

    if (forum_get_setting('show_stats', 'Y')) {

        echo "<div align=\"center\">\n";
        echo "  <br />\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\" cellspacing=\"0\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['forumstats']}</td>\n";

        if (bh_session_get_value("SHOW_STATS") == "Y" || user_is_guest()) {

            if (!user_is_guest()) {
                echo "                  <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=N&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_hide.png'), "\" border=\"0\" alt=\"{$lang['hide_stats']}\" title=\"{$lang['hide_stats']}\" /></a></td>\n";
            }else {
                echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
            }

            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td colspan=\"2\" align=\"left\" id=\"forum_stats\">\n";
            echo "                    <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" id=\"active_user_counts\"></td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"activeusers\" id=\"active_user_list\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" id=\"thread_stats\">&nbsp;<br />&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" id=\"post_stats\">&nbsp;<br />&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" id=\"user_stats\">&nbsp;<br />&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";

        }else {

            echo "                  <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=Y&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_show.png'), "\" border=\"0\" alt=\"{$lang['show_stats']}\" title=\"{$lang['show_stats']}\" /></a></td>\n";
        }

        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</div>\n";
    }
}

?>
