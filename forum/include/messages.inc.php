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

/* $Id: messages.inc.php,v 1.417 2006-10-22 16:24:32 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

function messages_get($tid, $pid = 1, $limit = 1)
{
    $lang = load_language_file();

    if (!$uid = bh_session_get_value('UID')) $uid = 0;

    $db_messages_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql  = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql .= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, UNIX_TIMESTAMP(POST.VIEWED) AS VIEWED, ";
    $sql .= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, POST.EDITED_BY, POST.IPADDRESS, ";
    $sql .= "POST.MOVED_TID, POST.MOVED_PID, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql .= "POST.APPROVED_BY, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql .= "USER_PEER_FROM.RELATIONSHIP AS FROM_RELATIONSHIP, TUSER.LOGON AS TLOGON, ";
    $sql .= "TUSER.NICKNAME AS TNICK, USER_PEER_TO.RELATIONSHIP AS TO_RELATIONSHIP, ";
    $sql .= "USER_PEER_TO.PEER_NICKNAME AS PTNICK, USER_PEER_FROM.PEER_NICKNAME AS PFNICK ";
    $sql .= "FROM {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql .= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_TO ";
    $sql .= "ON (USER_PEER_TO.UID = '$uid' AND USER_PEER_TO.PEER_UID = POST.TO_UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER_FROM ";
    $sql .= "ON (USER_PEER_FROM.UID = '$uid' AND USER_PEER_FROM.PEER_UID = POST.FROM_UID) ";
    $sql .= "WHERE POST.TID = '$tid' ";
    $sql .= "AND POST.PID >= '$pid' ";
    $sql .= "ORDER BY POST.PID ";
    $sql .= "LIMIT 0, $limit";

    $result = db_unbuffered_query($sql, $db_messages_get);

    // Loop through the results and construct an array to return

    if ($limit > 1) {

        $messages = array();

        while($message = db_fetch_array($result)) {

            $message['CONTENT'] = "";

            if (!isset($message['VIEWED'])) $message['VIEWED'] = 0;

            if (!isset($message['APPROVED'])) $message['APPROVED'] = 0;
            if (!isset($message['APPROVED_BY'])) $message['APPROVED_BY'] = 0;

            if (!isset($message['EDITED'])) $message['EDITED'] = 0;
            if (!isset($message['EDITED_BY'])) $message['EDITED_BY'] = 0;

            if (!isset($message['IPADDRESS'])) $message['IPADDRESS'] = "";

            if (!isset($message['FROM_RELATIONSHIP'])) $message['FROM_RELATIONSHIP'] = 0;
            if (!isset($message['TO_RELATIONSHIP'])) $message['TO_RELATIONSHIP'] = 0;

            if (!isset($message['FNICK'])) $message['FNICK'] = "Unknown User";
            if (!isset($message['FLOGON'])) $message['FLOGON'] = "Unknown User";
            if (!isset($message['FROM_UID'])) $message['FROM_UID'] = -1;

            if (!isset($message['TNICK'])) $message['TNICK'] = $lang['allcaps'];
            if (!isset($message['TLOGON'])) $message['TLOGON'] = $lang['allcaps'];

            if (!isset($message['MOVED_TID'])) $message['MOVED_TID'] = 0;
            if (!isset($message['MOVED_PID'])) $message['MOVED_PID'] = 0;

            if (isset($message['PTNICK'])) {
                if (!is_null($message['PTNICK']) && strlen($message['PTNICK']) > 0) {
                    $message['TNICK'] = $message['PTNICK'];
                }
            }

            if (isset($message['PFNICK'])) {
                if (!is_null($message['PFNICK']) && strlen($message['PFNICK']) > 0) {
                    $message['FNICK'] = $message['PFNICK'];
                }
            }

            $messages[] = $message;
        }

        return $messages;

    }else {

        $messages = db_fetch_array($result);

        if (!isset($messages['VIEWED'])) $messages['VIEWED'] = 0;

        if (!isset($messages['APPROVED'])) $messages['APPROVED'] = 0;
        if (!isset($messages['APPROVED_BY'])) $messages['APPROVED_BY'] = 0;

        if (!isset($messages['EDITED'])) $messages['EDITED'] = 0;
        if (!isset($messages['EDITED_BY'])) $messages['EDITED_BY'] = 0;

        if (!isset($messages['IPADDRESS'])) $messages['IPADDRESS'] = "";

        if (!isset($messages['FROM_RELATIONSHIP'])) $messages['FROM_RELATIONSHIP'] = 0;
        if (!isset($messages['TO_RELATIONSHIP'])) $messages['TO_RELATIONSHIP'] = 0;

        if (!isset($messages['FNICK'])) $messages['FNICK'] = "Unknown User";
        if (!isset($messages['FLOGON'])) $messages['FLOGON'] = "Unknown User";
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

    return false;
}

function message_get_content($tid, $pid)
{
    $db_mgc = db_connect();

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT CONTENT FROM {$table_data['PREFIX']}POST_CONTENT WHERE TID = '$tid' AND PID = '$pid'";
    $result = db_query($sql,$db_mgc);

    $fa = db_fetch_array($result);
    return isset($fa['CONTENT']) ? $fa['CONTENT'] : "";
}

/**
* Adds emoticons/wikilinks to posts; ignores signature
*
* Message text is split into the message/sig parts. If the user ignores this sig/all sigs the
* sig is set to an empty string. The message is then split into it's HTML and text parts.
* <nowiki> tags are added around <code>, <spoiler>, <a> tags
* <noemots> tags are added around <code>, <spoiler> tags
* The message is collapsed and re-split by the new <nowiki>/<noemots> tags, and wiki links and
* emoticons are added where appropriate.
*
* @return string
* @param string $content Message HTML
* @param boolean $emoticons Toggle to add emoticons (default true)
* @param boolean $sig Toggle to ignore signature (default false)
*/
function message_split_fiddle($content, $emoticons = true, $ignore_sig = false)
{
    $webtag = get_webtag($webtag_search);

    $message = explode("<div class=\"sig\">", $content);

    if (count($message) > 1 && substr($message[count($message) - 1], -6) == '</div>') {

        $sig = "<div class=\"sig\">";
        $sig.= array_pop($message);

        while(1) {

            if (count(explode('<div', $sig)) == count(explode('</div>', $sig))) break;
            $sig = "<div class=\"sig\">". array_pop($message). $sig;
        }

    }else {

        $sig = "";
    }

    $message = implode("", $message);

    $message_parts = preg_split('/<([^<>]+)>/', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

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

                    if (strpos($message_parts[$i], 'div class="quotetext" id="code-') !== false) {

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

                    }else if (strpos($message_parts[$i], 'div class="quotetext" id="spoiler"') !== false) {

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

                        if (substr($message_parts[$i], 0, 4) == 'div ' || $message_parts[$i] == 'div') {

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

                    if (substr($message_parts[$i], 0, 2) == 'a ' || $message_parts[$i] == 'a') {

                        $nowiki++;
                        $opena++;
                        array_splice($message_parts, $i, 0, array('nowiki', ""));
                        $i += 2;
                    }

                }else {

                    if (substr($message_parts[$i], 0, 2) == 'a ' || $message_parts[$i] == 'a') {

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

                $message_parts = preg_split('/<([^<>]+)>/', $sig, -1, PREG_SPLIT_DELIM_CAPTURE);

            }else {

                $sig = "";
                break;
            }

        }else {

            $sig = "";

            for ($i = 0; $i < sizeof($message_parts); $i++) {

                if ($i % 2) {

                    $sig.= '<'.$message_parts[$i].'>';

                }else {

                    $sig.= $message_parts[$i];
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

        $message_parts = preg_split("/<\/?nowiki>/", $message);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 2)) {

                $html_parts = preg_split('/([<|>])/', $message_parts[$i], -1, PREG_SPLIT_DELIM_CAPTURE);

                for ($j = 0; $j < sizeof($html_parts); $j++) {

                    if (!($j % 4) && (!isset($html_parts[$j - 2]) || !strstr($html_parts[$j - 2], "href"))) {

                        if ($enable_wiki_words) {

                            $html_parts[$j] = preg_replace("/\b(([A-Z][a-z]+){2,})\b/", "<a href=\"$wiki_location\" class=\"wikiword\">\\1</a>", $html_parts[$j]);
                        }

                        if ($enable_wiki_links) {

                            $html_parts[$j] = preg_replace("/\b(msg:([0-9]{1,}\.[0-9]{1,}))\b/i", "<a href=\"messages.php?msg=\\2\" class=\"wikiword\">\\1</a>", $html_parts[$j]);
                            $html_parts[$j] = preg_replace("/\b(user:([a-z0-9_-]{2,15}))\b/i", "<a href=\"javascript:void(0);\" onclick=\"openProfileByLogon('\\2', '$webtag')\" class=\"wikiword\">\\1</a>", $html_parts[$j]);
                        }
                    }
                }

                $message_parts[$i] = implode("", $html_parts);
            }
        }

        $message = implode("", $message_parts);
    }

    if ($emoticons == true) {

        $emots = new Emoticons();

        $message_parts = preg_split("/<\/?noemots>/", $message);
        $sig_parts = preg_split("/<\/?noemots>/", $sig);

        $message_parts = array_merge($message_parts, $sig_parts);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 2)) {

                $message_parts[$i] = $emots->convert($message_parts[$i]);
            }
        }

        $message = implode("", $message_parts);
    }

    return $message;
}

function message_mouseover_spoiler($content)
{
    if ($html_parts = preg_split('/(<div[^>]*>)|(<\/div[^>]*>)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE)) {
       
        $div_count = 0;
        $spoiler_count = 0;
        
        foreach($html_parts as $key => $html) {

            if (preg_match("/<div[^>]*>/", $html)) {

                $div_count++;

                if (preg_match("/<div class=\"spoiler\">/", $html)) {

                    $spoiler_count++;

                    if (isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], "Smartphone")) {
                        $html_parts[$key] = "<div class=\"spoiler_light\"><a href=\"Javascript:void(0)\">";
                    }else {
                        $html_parts[$key] = "<div class=\"spoiler\"><a href=\"Javascript:void(0)\">";
                    }
                }
            }

            if (preg_match("/<\/div[^>]*>/", $html) && $div_count > 0) {

                $div_count--;

                if ($div_count == 0 && $spoiler_count > 0) {

                    $spoiler_count--;
                    $html_parts[$key] = "</a></div>";
                }
            }
        }

        return implode("", $html_parts);
    }

    return $content;
}

function messages_top($foldertitle, $threadtitle, $interest_level = 0, $sticky = "N", $closed = false, $locked = false, $deleted = false)
{
    $lang = load_language_file();

    echo "<p><img src=\"", style_image('folder.png'). "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />&nbsp;", add_wordfilter_tags("$foldertitle: $threadtitle");

    if ($closed) echo "&nbsp;<img src=\"", style_image('thread_closed.png'), "\" alt=\"{$lang['closed']}\" title=\"{$lang['closed']}\" />\n";
    if ($interest_level == 1) echo "&nbsp;<img src=\"", style_image('high_interest.png'), "\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" />";
    if ($interest_level == 2) echo "&nbsp;<img src=\"", style_image('subscribe.png'), "\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" />";
    if ($sticky == "Y") echo "&nbsp;<img src=\"", style_image('sticky.png'), "\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" />";
    if ($locked) echo "&nbsp;<img src=\"", style_image('admin_locked.png'), "\" alt=\"{$lang['locked']}\" title=\"{$lang['locked']}\" />\n";
    if ($deleted) echo "&nbsp;<img src=\"", style_image('delete.png'), "\" alt=\"{$lang['deleted']}\" title=\"{$lang['deleted']}\" />\n";

    echo "</p>";
}

function messages_bottom()
{
    echo "<p align=\"right\">BeehiveForum 2002</p>\n";
}

function message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    global $frame_top_target;
    
    $lang = load_language_file();

    $perm_is_moderator = bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);
    $perm_has_admin_access = bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0);

    $webtag = get_webtag($webtag_search);

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$posts_per_page = bh_session_get_value('POST_PER_PAGE')) {
        $posts_per_page = 20;
    }

    if (!isset($message['CONTENT']) || $message['CONTENT'] == "") {

        message_display_deleted($tid, isset($message['PID']) ? $message['PID'] : 0, $message);
        return;
    }

    $from_user_permissions = perm_get_user_permissions($message['FROM_UID']);

    if ($uid != $message['FROM_UID']) {

        if (($from_user_permissions & USER_PERM_WORMED) && !$perm_is_moderator) {

            message_display_deleted($tid, $message['PID'], $message);
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

        message_display_deleted($tid, $message['PID'], $message);
        return;
    }

    // Add emoticons/WikiLinks and ignore signature ----------------------------

    $message['CONTENT'] = message_split_fiddle($message['CONTENT'], true, (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs));

    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {

        $message['CONTENT'] = preg_replace("/<a([^>]*)href=\"([^\"]*)\"([^\>]*)><img[^>]*src=\"([^\"]*)\"[^>]*><\/a>/i", "[img: <a\\1href=\"\\2\"\\3>\\4</a>]", $message['CONTENT']);
        $message['CONTENT'] = preg_replace("/<img[^>]*src=\"([^\"]*)\"[^>]*>/i", "[img: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
        $message['CONTENT'] = preg_replace("/<embed[^>]*src=\"([^\"]*)\"[^>]*>/i", "[object: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
    }

    // Check length of post to see if we should truncate it for display --------

    if ((strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', false, 6226))) && $limit_text) {

        $cut_msg = substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', false, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg, false);
        $message['CONTENT'].= "&hellip;[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    // Check for words that should be filtered ---------------------------------

    if ($is_poll !== true) $message['CONTENT'] = add_wordfilter_tags($message['CONTENT']);

    if ($in_list && isset($message['PID'])){

        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>\n";
    }

    // Check for search words to highlight -------------------------------------

    if (sizeof($highlight_array) > 0) {

        $highlight_pattern = array();
        $highlight_replace = array();

        foreach ($highlight_array as $key => $word) {

            $highlight_word = preg_quote($word, "/");

            $highlight_pattern[$key] = "/($highlight_word)/i";
            $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
        }

        $message_parts = preg_split('/([<|>])/', $message['CONTENT'], -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < sizeof($message_parts); $i++) {

            if (!($i % 4)) {

                $message_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $message_parts[$i], 1);
            }
        }

        $message['CONTENT'] = implode("", $message_parts);
    }

    // Little up/down arrows to the left of each message -----------------------

    $up_arrow = "";
    $down_arrow = "";

    if ($in_list && !$is_preview) {

        if ($message['PID'] != 1) {

            if ($message['PID'] == $first_msg) {

                $up_arrow = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($message['PID'] - 1). "\" target=\"_self\">";
                $up_arrow.= "<img src=\"". style_image("message_up.png"). "\" border=\"0\" alt=\"{$lang['prev']}\" title=\"{$lang['prev']}\" /></a> ";

            }else {

                $up_arrow = "<a href=\"#a{$tid}_". ($message['PID'] - 1). "\" target=\"_self\">";
                $up_arrow.= "<img src=\"". style_image("message_up.png"). "\" border=\"0\" alt=\"{$lang['prev']}\" title=\"{$lang['prev']}\" /></a> ";
            }
        }

        if ($message['PID'] != $msg_count) {

            if ((($first_msg + $posts_per_page) - 1) == $message['PID']) {

                $down_arrow = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($message['PID'] + 1). "\" target=\"_self\">";
                $down_arrow.= "<img src=\"".style_image("message_down.png")."\" border=\"0\" alt=\"{$lang['next']}\" title=\"{$lang['next']}\" /></a>";

            }else {

                $down_arrow = "<a href=\"#a{$tid}_". ($message['PID'] + 1). "\" target=\"_self\">";
                $down_arrow.= "<img src=\"". style_image("message_down.png"). "\" border=\"0\" alt=\"{$lang['next']}\" title=\"{$lang['next']}\" /></a>";
            }
        }
    }

    if (forum_get_setting('require_post_approval', 'Y') && $message['FROM_UID'] != $uid) {

        if (isset($message['APPROVED']) && $message['APPROVED'] == 0 && !$perm_is_moderator) {

            message_display_approval_req($tid, $message['PID']);
            return;
        }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    if (!$is_preview && ($message['MOVED_TID'] > 0) && ($message['MOVED_PID'] > 0)) {

        $moved_msg = "{$message['MOVED_TID']}.{$message['MOVED_PID']}";
        
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<table class=\"thread_track_notice\" width=\"96%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\"><b>Thread Split:</b> This post has been moved <a href=\"messages.php?webtag=$webtag&amp;msg=$moved_msg\" target=\"_self\">here</a>.</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        return;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<table width=\"100%\" cellspacing=\"0\"cellpadding=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" width=\"2%\" valign=\"top\">\n";
    echo "      <table width=\"100%\" cellspacing=\"0\"cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">$up_arrow</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">$down_arrow</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "    <td align=\"left\">\n";
    echo "      <table width=\"98%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "              <tr>\n";
    echo "                <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
    echo "                <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";

    if ($message['FROM_UID'] > -1) {

        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['FROM_UID']}, '$webtag')\" target=\"_self\">";
        echo add_wordfilter_tags(format_user_name($message['FLOGON'], $message['FNICK'])), "</a></span>";

    }else {

        echo add_wordfilter_tags(format_user_name($message['FLOGON'], $message['FNICK'])), "</span>";
    }

    $temp_ignore = false;

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen

    if ($is_poll && isset($message['PID']) && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {

        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if ($message['FROM_RELATIONSHIP'] & USER_FRIEND) {

        echo "&nbsp;&nbsp;<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";

    }else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || $temp_ignore) {

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

        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile({$message['TO_UID']}, '$webtag')\" target=\"_self\">";
        echo add_wordfilter_tags(format_user_name($message['TLOGON'], $message['TNICK'])), "</a></span>";

        if ($message['TO_RELATIONSHIP'] & USER_FRIEND) {

            echo "&nbsp;&nbsp;<img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" />";

        }else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {

            echo "&nbsp;&nbsp;<img src=\"", style_image('enemy.png'), "\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" />";
        }

        if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {

            echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">", format_time($message['VIEWED'], 1), "</span>";

        }else {

            if ($is_preview == false) {

                echo "&nbsp;&nbsp;&nbsp;<span class=\"smalltext\">{$lang['unread']}</span>";
            }
        }

    }else {

        echo "{$lang['all_caps']}</span>";
    }

    echo "</td>\n";
    echo "                <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">";

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text && $in_list && $uid != 0) {

        echo "<a href=\"set_relation.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;rel=0&amp;exists=1&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['stopignoringthisuser']}</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewmessage']}</a>";

    }else if($in_list && $msg_count > 0) {

        if ($is_poll) {

            echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=$tid', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" /></a> {$lang['poll']} ";
        }

        echo "{$message['PID']} {$lang['of']} $msg_count";
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

                if (isset($frame_top_target) && strlen($frame_top_target) > 0) {

                    echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"$frame_top_target\" title=\"$title\">$tid.{$message['PID']}</a>";

                }else {

                    echo "<a href=\"index.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_top\" title=\"$title\">$tid.{$message['PID']}</a>";
                }
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
        echo "                <td class=\"postbody\" align=\"left\">{$message['CONTENT']}</td>\n";
        echo "              </tr>\n";

        if (isset($message['EDITED']) && $message['EDITED'] > 0) {

            $post_edit_grace_period = forum_get_setting('post_edit_grace_period', false, 0);

            if (($post_edit_grace_period == 0) || ($message['EDITED'] - $message['CREATED']) > ($post_edit_grace_period * MINUTE_IN_SECONDS)) {

                $edit_user = user_get_logon($message['EDITED_BY']);
                
                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\"><p class=\"edit_text\">{$lang['edited_caps']}: ", format_time($message['EDITED'], 1), " {$lang['by']} {$edit_user}</p></td>\n";
                echo "              </tr>\n";
            }
        }

        if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] > 0 && $perm_is_moderator) {

            if (isset($message['APPROVED_BY']) && $message['APPROVED_BY'] > 0 && $message['APPROVED_BY'] != $message['FROM_UID']) {

                $approved_user = user_get_logon($message['APPROVED_BY']);
                
                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\"><p class=\"approved_text\">{$lang['approvedcaps']}: ", format_time($message['APPROVED'], 1), " {$lang['by']} {$approved_user}</p></td>\n";
                echo "              </tr>\n";
            }
        }

        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

            $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);

            if (get_attachments($message['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

                echo "              <tr>\n";
                echo "                <td class=\"postbody\" align=\"left\">\n";

                if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                    echo "                  <p><b>{$lang['attachments']}:</b><br />\n";

                    foreach($attachments_array as $attachment) {

                        echo "                  ", attachment_make_link($attachment), "\n";
                    }

                    echo "                  </p>\n";
                }

                if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                    echo "                  <p><b>{$lang['imageattachments']}:</b><br />\n";

                    foreach($image_attachments_array as $key => $attachment) {

                        echo "                  ", attachment_make_link($attachment), "\n";
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
            echo "                <td width=\"25%\">&nbsp;</td>\n";
            echo "                <td width=\"50%\" nowrap=\"nowrap\">";

            if ($msg_count > 0) {
            
                if ((!$closed && bh_session_check_perm(USER_PERM_POST_CREATE, $folder_fid)) || $perm_is_moderator) {

                    echo "<img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />";
                    echo "&nbsp;<a href=\"post.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" target=\"_parent\">{$lang['reply']}</a>";
                }

                if (($uid == $message['FROM_UID'] && bh_session_check_perm(USER_PERM_POST_DELETE, $folder_fid) && !(perm_get_user_permissions($uid) & USER_PERM_PILLORIED)) || $perm_is_moderator) {
                    echo "&nbsp;&nbsp;<img src=\"", style_image('delete.png'), "\" border=\"0\" alt=\"{$lang['delete']}\" title=\"{$lang['delete']}\" />";
                    echo "&nbsp;<a href=\"delete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['delete']}</a>";
                }

                if (((!perm_get_user_permissions($uid) & USER_PERM_PILLORIED) || ($uid != $message['FROM_UID'] && $from_user_permissions & USER_PERM_PILLORIED) || ($uid == $message['FROM_UID'])) && bh_session_check_perm(USER_PERM_POST_EDIT, $folder_fid) && ((time() - $message['CREATED']) < (forum_get_setting('post_edit_time', false, 0) * HOUR_IN_SECONDS) || forum_get_setting('post_edit_time', false, 0) == 0) && (forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

                    if ($is_poll && $message['PID'] == 1) {

                        if (!poll_is_closed($tid) || $perm_is_moderator) {

                            echo "&nbsp;&nbsp;<img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['editpoll']}\" title=\"{$lang['editpoll']}\" />";
                            echo "&nbsp;<a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['editpoll']}</a>";
                        }

                    }else {

                        echo "&nbsp;&nbsp;<img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />";
                        echo "&nbsp;<a href=\"edit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\">{$lang['edit']}</a>";
                    }
                }

            }else {

                echo "&nbsp;";
            }

            echo "</td>\n";
            echo "            <td width=\"25%\" align=\"right\" nowrap=\"nowrap\">";

            echo "<a href=\"pm_write.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"{$lang['pm_reply']}\"><img src=\"", style_image('pmunread.png'), "\" border=\"0\" alt=\"{$lang['pm_reply']}\" title=\"{$lang['pm_reply']}\" /></a>&nbsp;";
            echo "<a href=\"display.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\" title=\"{$lang['print']}\"><img src=\"", style_image('print.png'), "\" border=\"0\" alt=\"{$lang['print']}\" title=\"{$lang['print']}\" /></a>&nbsp;";
            echo "<a href=\"thread_options.php?webtag=$webtag&amp;msg=$tid.$first_msg&amp;markasread=", ($message['PID'] - 1), "\" target=\"_self\" title=\"{$lang['markasunread']}\"><img src=\"", style_image('markasunread.png'), "\" border=\"0\" alt=\"{$lang['markasunread']}\" title=\"{$lang['markasunread']}\" /></a>&nbsp;";

            if ($uid != $message['FROM_UID']) {

                echo "<a href=\"user_rel.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['relationship']}\"><img src=\"", style_image('enemy.png'), "\" border=\"0\" alt=\"{$lang['relationship']}\" title=\"{$lang['relationship']}\" /></a>&nbsp;";
            }

            if ($perm_has_admin_access) {

                echo "<a href=\"admin_user.php?webtag=$webtag&amp;uid={$message['FROM_UID']}&amp;msg=$tid.$first_msg\" target=\"_self\" title=\"{$lang['privileges']}\"><img src=\"", style_image('admintool.png'), "\" border=\"0\" alt=\"{$lang['privileges']}\" title=\"{$lang['privileges']}\" /></a>&nbsp;";
            }

            if ($perm_has_admin_access) {

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

                    if (ip_is_banned($message['IPADDRESS'])) {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> <a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$message['IPADDRESS']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['banned']}</a>&nbsp;</span>";

                    }else {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> <a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$message['IPADDRESS']}&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$message['IPADDRESS']}</a>&nbsp;</span>";
                    }

                }else {

                    echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['notlogged']}&nbsp;</span>";
                }

            }elseif ($perm_is_moderator) {

                if (forum_get_setting('require_post_approval', 'Y') && isset($message['APPROVED']) && $message['APPROVED'] == 0) {

                    echo "<a href=\"admin_post_approve.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_parent\" title=\"{$lang['approvepost']}\"><img src=\"", style_image('approved.png'), "\" border=\"0\" alt=\"{$lang['approvepost']}\" title=\"{$lang['approvepost']}\" /></a>&nbsp;";
                }

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

                    if (ip_is_banned($message['IPADDRESS'])) {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['banned']}&nbsp;</span>";

                    }else {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$message['IPADDRESS']}&nbsp;</span>";
                    }

                }else {

                    echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['notlogged']}&nbsp;</span>";
                }

            }else {

                if (isset($message['IPADDRESS']) && strlen($message['IPADDRESS']) > 0) {

                    if ($uid == $message['FROM_UID']) {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$message['IPADDRESS']}&nbsp;</span>";

                    }else {

                        echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['logged']}&nbsp;</span>";
                    }

                }else {

                    echo "<span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> {$lang['logged']}&nbsp;</span>";
                }
            }

            echo "</td>\n";
            echo "              </tr>";
            echo "            </table>\n";
        }
    }

    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function message_display_deleted($tid, $pid, $message)
{
    $lang = load_language_file();

    if (isset($message['EDITED']) && $message['EDITED'] > 0) {

        $edit_logon = user_get_logon($message['EDITED_BY']);
        
        echo "<br /><div align=\"center\">";
        echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td align=\"left\">\n";
        echo "<table class=\"posthead\" width=\"100%\"><tr><td align=\"left\">\n";
        echo "{$lang['message']} ${tid}.${pid} {$lang['deleted']}: ", format_time($message['EDITED'], 1), " {$lang['by']} {$edit_logon}\n";
        echo "</td></tr></table>\n";
        echo "</td></tr></table></div>\n";

    }else {

        echo "<br /><div align=\"center\">";
        echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td align=\"left\">\n";
        echo "<table class=\"posthead\" width=\"100%\"><tr><td align=\"left\">\n";
        echo "{$lang['message']} ${tid}.${pid} {$lang['wasdeleted']}\n";
        echo "</td></tr></table>\n";
        echo "</td></tr></table></div>\n";
    }
}

function message_display_approval_req($tid, $pid)
{
    $lang = load_language_file();

    echo "<br /><div align=\"center\">";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td align=\"left\">\n";
    echo "<table class=\"posthead\" width=\"100%\"><tr><td align=\"left\">\n";
    echo "{$lang['message']} ${tid}.${pid} {$lang['awaitingapprovalbymoderator']}\n";
    echo "</td></tr></table>\n";
    echo "</td></tr></table></div>\n";
}

function messages_start_panel()
{
    echo "<div align=\"center\">\n";
    echo "<table width=\"96%\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\">\n";
}

function messages_end_panel()
{
    echo "</td></tr></table></div>";
}

function messages_nav_strip($tid, $pid, $length, $ppp)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    // Less than 20 messages, no nav needed

    if ($pid < 2 && $length < $ppp){
        return;
    }

    // Something.
    $c = 0;

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if ($spid > 1) {
        if($pid > 1){
            $navbits[0] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">". mess_nav_range(1, $spid-1). "</a>";
        }else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    }else {
        $i = 0;
    }

    // The middle section(s)
    while($spid + ($ppp - 1) < $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        }else {
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.". ($spid == 0 ? 1 : $spid). "\" target=\"_self\">". mess_nav_range($spid == 0 ? 1 : $spid, $spid + ($ppp - 1)). "</a>";
        }
        $spid += $ppp;
        $i++;
    }

    // The final section, x-n
    if($spid <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        }else {
            $navbits[$i] = "<a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$spid\" target=\"_self\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }

    $max = $i;

    $html = "{$lang['showmessages']}:";

    if ($length <= $ppp) {
        $html .= " <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\">{$lang['all']}</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            // Only display first, last and those within 3 of the current section

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max) {
                $html .= "\n&nbsp;" . $navbits[$i];
            }else if(abs($c - $i) == 4) {
                $html .= "\n&nbsp;&hellip;";
            }

        }

    }

    unset($navbits);

    echo "<p align=\"center\" class=\"messagefoot\">$html</p>\n";
}

function mess_nav_range($from,$to)
{
    if($from == $to){
        $range = sprintf("%d", $from);
    }else {
        $range = sprintf("%d-%d", $from, $to);
    }
    return $range;
}

function messages_interest_form($tid,$pid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $interest = thread_get_interest($tid);
    $chk = array("","","","");
    $chk[$interest+1] = " checked";

    echo "<div align=\"center\" class=\"messagefoot\">\n";
    echo "<form name=\"rate_interest\" target=\"_self\" action=\"./thread_options.php?webtag=$webtag&amp;msg=$tid.$pid\" method=\"post\">\n";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo "<p>{$lang['ratemyinterest']}: \n";
    echo form_radio_array("setinterest",array(-1,0,1,2),array("{$lang['ignore']} ","{$lang['normal']} ","{$lang['interested']} ","{$lang['subscribe']} "),$interest);
    echo form_input_hidden("tid",$tid);
    echo form_submit("submit", $lang['apply']);
    echo "</p>\n";
    echo "</form>\n";
    echo "</div>\n";
}

function message_get_user($tid, $pid)
{
    $db_message_get_user = db_connect();

    if (!is_numeric($tid)) return "";
    if (!is_numeric($pid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT FROM_UID FROM {$table_data['PREFIX']}POST WHERE TID = '$tid' AND PID = '$pid'";
    $result = db_query($sql, $db_message_get_user);

    if($result){
        $fa = db_fetch_array($result);
        $uid = $fa['FROM_UID'];
    }else {
        $uid = "";
    }

    return $uid;
}

/**
* Update last read post in a thread and increments thread view count
*
* Updates LAST_READ column in USER_THREAD to last displayed post.
* Increments VIEWCOUNT column in THREAD_STATS.
*
* @return bool
* @param integer $tid  - Thread ID
* @param integer $pid  - Post ID
* @param integer $uid  - User UID
* @param integer $modified - Unix Timestamp thread modified date for mark as read cutoff.
*/

function messages_update_read($tid, $pid, $uid, $modified)
{
    $db_message_update_read = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($uid)) return false;
    if (!is_numeric($modified)) return false;

    // Check for existing entry in USER_THREAD

    if (!$table_data = get_table_prefix()) return false;

    // Mark as read cut off

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    // Guest users' can't mark as read!

    if ($uid > 0) {

        if ($unread_cutoff_stamp !== false && ($modified > $unread_cutoff_stamp)) {

            $sql = "UPDATE {$table_data['PREFIX']}USER_THREAD ";
            $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NOW() ";
            $sql.= "WHERE UID = '$uid' AND TID = '$tid' ";
            $sql.= "AND (LAST_READ < '$pid' OR LAST_READ IS NULL)";

            $result = db_query($sql, $db_message_update_read);

            if (db_affected_rows($db_message_update_read) < 1) {

                $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_THREAD ";
                $sql.= "(UID, TID, LAST_READ, LAST_READ_AT) ";
                $sql.= "VALUES ($uid, $tid, $pid, NOW())";

                if (!$result = db_query($sql, $db_message_update_read)) return false;
            }
        }

        // Mark posts as Viewed

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET VIEWED = NOW() ";
        $sql.= "WHERE TID = '$tid' AND PID BETWEEN 1 AND '$pid' ";
        $sql.= "AND TO_UID = '$uid' AND VIEWED IS NULL";

        if (!$result = db_query($sql, $db_message_update_read)) return false;
    }

    // Update thread viewed counter

    $sql = "UPDATE {$table_data['PREFIX']}THREAD_STATS ";
    $sql.= "SET VIEWCOUNT = VIEWCOUNT + 1 WHERE TID = '$tid'";

    $result = db_query($sql, $db_message_update_read);

    if (db_affected_rows($db_message_update_read) < 1) {

        $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}THREAD_STATS ";
        $sql.= "(TID, VIEWCOUNT) VALUES ('$tid', 1)";

        $result = db_query($sql, $db_message_update_read);
    }

    return true;
}

function messages_set_read($tid, $pid, $uid, $modified)
{
    $db_message_set_read = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($uid)) return false;

    // Check for existing entry in USER_THREAD

    if (!$table_data = get_table_prefix()) return false;

    // Mark as read cut off

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    // Guest can't mark as read

    if ($uid > 0) {

        if ($unread_cutoff_stamp !== false && ($modified > $unread_cutoff_stamp)) {

            $sql = "UPDATE {$table_data['PREFIX']}USER_THREAD ";
            $sql.= "SET LAST_READ = '$pid', LAST_READ_AT = NULL ";
            $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

            $result = db_query($sql, $db_message_set_read);

            if (db_affected_rows($db_message_set_read) < 1) {

                $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_THREAD ";
                $sql.= "(UID, TID, LAST_READ, LAST_READ_AT) ";
                $sql.= "VALUES ($uid, $tid, $pid, NOW())";

                if (!$result = db_query($sql, $db_message_set_read)) return false;
            }
        }
    }

    // Mark posts as Viewed...

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET VIEWED = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID >= '$pid' AND TO_UID = '$uid'";

    if (!$result = db_query($sql, $db_message_set_read)) return false;
}

function messages_get_most_recent($uid, $fid = false)
{
    $db_messages_get_most_recent = db_connect();

    if (is_numeric($fid)) {
        $fidlist = $fid;
    }else {
        $fidlist = folder_get_available();
    }

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return "1.1";

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    $sql = "SELECT THREAD.TID, THREAD.MODIFIED, THREAD.LENGTH, USER_THREAD.LAST_READ, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";

    if ($unread_cutoff_stamp !== false) {

        $sql.= "AND ((THREAD.LENGTH > USER_THREAD.LAST_READ ";
        $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp')) ";
        $sql.= "OR USER_THREAD.LAST_READ IS NULL ";
        $sql.= "OR USER_THREAD.LAST_READ = THREAD.LENGTH) ";
    }

    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_messages_get_most_recent);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (isset($row['LAST_READ'])) {

            if ($row['LAST_READ'] < $row['LENGTH']) {
                $row['LAST_READ']++;
            }

            return "{$row['TID']}.{$row['LAST_READ']}";

        }else {

            return "{$row['TID']}.1";
        }
    }

    return "1.1";
}

function messages_fontsize_form($tid, $pid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $fontstrip = "<p>{$lang['adjtextsize']}: ";

    if ((bh_session_get_value('FONT_SIZE') > 5) && (bh_session_get_value('FONT_SIZE') < 15)) {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;

        if ($fontsmaller < 5) $fontsmaller = 5;
        if ($fontlarger > 15) $fontlarger = 15;

        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=$fontsmaller\" target=\"_self\">{$lang['smaller']}</a> ";
        $fontstrip.= bh_session_get_value('FONT_SIZE'). " <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=$fontlarger\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }elseif (bh_session_get_value('FONT_SIZE') == 5) {

        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;
        $fontstrip.= "{$lang['smaller']} ". bh_session_get_value('FONT_SIZE'). " <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=6\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }elseif (bh_session_get_value('FONT_SIZE') == 15) {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=14\" target=\"_self\">{$lang['smaller']}</a> ". bh_session_get_value('FONT_SIZE'). " {$lang['larger']}</p>\n";

    }else {

        $fontsmaller = bh_session_get_value('FONT_SIZE') - 1;
        $fontlarger = bh_session_get_value('FONT_SIZE') + 1;

        $fontstrip.= "<a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=9\" target=\"_self\">{$lang['smaller']}</a> ";
        $fontstrip.= "10 <a href=\"user_font.php?webtag=$webtag&amp;msg=$tid.$pid&amp;fontsize=11\" target=\"_self\">{$lang['larger']}</a></p>\n";

    }

    echo $fontstrip;
}

function validate_msg($msg)
{
    return preg_match("/^\d{1,}\.\d{1,}$/", rawurldecode($msg));
}

function messages_forum_stats($tid, $pid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $uid = bh_session_get_value("UID");
    $user_show_stats = bh_session_get_value("SHOW_STATS");

    if (forum_get_setting('show_stats', 'Y')) {

        echo "<div align=\"center\">\n";
        echo "  <br />\n";
        echo "  <table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "    <tr>\n";
        echo "      <td class=\"subhead\" align=\"left\">{$lang['forumstats']}:</td>\n";

        if ($user_show_stats == "Y" || $uid == 0) {

            if ($uid != 0) {
                echo "      <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=N&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_hide.png'), "\" border=\"0\" alt=\"{$lang['hide_stats']}\" title=\"{$lang['hide_stats']}\" /></a></td>\n";
            }else {
                echo "      <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
            }

            echo "    </tr>\n";
            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"left\">\n";

            if ($user_stats = get_active_users()) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "            <td align=\"left\">&nbsp;</td>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\">&nbsp;</td>\n";
                echo "            <td align=\"left\">\n";
                echo "              <b>{$user_stats['GUESTS']}</b> {$lang['guests']}\n";
                echo "              <b>{$user_stats['NUSERS']}</b> {$lang['members']}\n";
                echo "              <b>{$user_stats['AUSERS']}</b> {$lang['anonymousmembers']}\n";
                echo "              [ <a href=\"start.php?webtag=$webtag&amp;show=visitors\" target=\"main\">{$lang['viewcompletelist']}</a> ]\n";
                echo "            </td>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";

                if (sizeof($user_stats['USERS']) > 0) {

                    $active_users_array = array();

                    foreach ($user_stats['USERS'] as $user) {

                        $active_user = "<a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";

                        if ($user['UID'] == $uid) {

                            if (isset($user['ANON_LOGON']) && $user['ANON_LOGON'] > 0) {

                                $active_user.= "<span class=\"user_stats_curuser\" title=\"{$lang['youinvisible']}\">";

                            }else {

                                $active_user.= "<span class=\"user_stats_curuser\" title=\"{$lang['younormal']}\">";
                            }

                        }elseif (($user['RELATIONSHIP'] & USER_FRIEND) > 0) {

                            $active_user.= "<span class=\"user_stats_friend\" title=\"Friend\">";

                        }else {

                            $active_user.= "<span class=\"user_stats_normal\">";
                        }

                        $active_user.= str_replace(" ", "&nbsp;", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])));
                        $active_user.= "</span></a>";

                        $active_users_array[] = $active_user;
                    }

                    echo "          <tr>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "            <td align=\"left\">&nbsp;</td>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                    echo "          <tr>";
                    echo "            <td align=\"left\">&nbsp;</td>\n";
                    echo "            <td align=\"left\" class=\"activeusers\">\n";
                    echo "              ", implode(", ", $active_users_array), "\n";
                    echo "            </td>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                }

                echo "          <tr>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "            <td align=\"left\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">{$lang['ourmembershavemadeatotalof']} <b>", number_format(get_thread_count(), 0, ".", ","), "</b> {$lang['threadsand']} <b>", number_format(get_post_count(), 0, ",", ","), "</b> {$lang['postslowercase']}</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if ($longest_thread = get_longest_thread()) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "            <td align=\"left\">{$lang['longestthreadis']} '<a href=\"./index.php?webtag=$webtag&amp;msg={$longest_thread['TID']}.1\">{$longest_thread['TITLE']}</a>' {$lang['with']} <b>", number_format($longest_thread['LENGTH'], 0, ",", ","), "</b> {$lang['postslowercase']}.</td>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            $recent_posts = get_recent_post_count();

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">&nbsp;</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">{$lang['therehavebeen']} <b>$recent_posts</b> {$lang['postsmadeinthelastsixtyminutes']}</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if ($most_posts = get_most_posts()) {

                if ($most_posts['MOST_POSTS_COUNT'] > 0 && $most_posts['MOST_POSTS_DATE'] > 0) {

                    echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                    echo "          <tr>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "            <td align=\"left\">{$lang['mostpostsevermadeinasinglesixtyminuteperiodwas']} <b>", number_format($most_posts['MOST_POSTS_COUNT'], 0, ",", ","), "</b> {$lang['on']} ", format_time($most_posts['MOST_POSTS_DATE'], 1), "</td>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                    echo "        </table>\n";
                }
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">&nbsp;</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">\n";
            echo "              {$lang['wehave']} <b>", user_count(), "</b> {$lang['registeredmembers']}\n";

            if ($newest_member = get_newest_user()) {

                echo "              {$lang['thenewestmemberis']} <a href=\"javascript:void(0);\" onclick=\"openProfile({$newest_member['UID']}, '$webtag')\" target=\"_self\">", add_wordfilter_tags(format_user_name($newest_member['LOGON'], $newest_member['NICKNAME'])), "</a>.\n";
            }

            echo "            </td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if ($most_users = get_most_users()) {

                if ($most_users['MOST_USERS_COUNT'] > 0 && $most_users['MOST_USERS_DATE'] > 0) {

                    echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                    echo "          <tr>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "            <td align=\"left\">{$lang['mostuserseveronlinewas']} <b>", number_format($most_users['MOST_USERS_COUNT'], 0, ",", ","), "</b> {$lang['on']} ", format_time($most_users['MOST_USERS_DATE'], 1), "</td>\n";
                    echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                    echo "          </tr>\n";
                    echo "        </table>\n";
                }
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">&nbsp;</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            if (isset($GLOBALS['queries']) && is_array($GLOBALS['queries'])) {

                echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "            <td align=\"left\">\n";

                foreach ($GLOBALS['queries'] as $sql => $querytime) {

                    echo "              <p>$sql => $querytime</p>\n";
                }

                echo "            </td>\n";
                echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "            <td align=\"left\">&nbsp;</td>\n";
            echo "            <td align=\"left\" width=\"35\">&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";

            echo "      </td>\n";

        }else {

            echo "      <td class=\"subhead\" width=\"1%\" align=\"right\"><a href=\"user_stats.php?webtag=$webtag&amp;show_stats=Y&amp;msg=$tid.$pid\" target=\"_self\"><img src=\"", style_image('stats_show.png'), "\" border=\"0\" alt=\"{$lang['show_stats']}\" title=\"{$lang['show_stats']}\" /></a></td>\n";
        }

        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</div>\n";
    }
}

?>
