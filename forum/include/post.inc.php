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

/* $Id: post.inc.php,v 1.157 2007-05-12 10:04:15 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function post_create($fid, $tid, $reply_pid, $by_uid, $fuid, $tuid, $content, $hide_ipaddress = false)
{
    $db_post_create = db_connect();

    $post_content = db_escape_string($content);

    // IP Address can be hidden by calling this function with $hide_ipaddress
    // set to true. Useful for automated functionality like the RSS Feeder.

    if ($hide_ipaddress === false) {
        if (!$ipaddress = get_ip_address()) $ipaddress = "";
    }else {
        $ipaddress = "";
    }

    if (!is_numeric($tid)) return -1;
    if (!is_numeric($reply_pid)) return -1;
    if (!is_numeric($fuid)) return -1;
    if (!is_numeric($tuid)) return -1;

    if (!$table_data = get_table_prefix()) return -1;

    // Make sure the user's post count is up to date.

    user_get_post_count($fuid);

    // Check that the post needs approval. If the user is a moderator
    // their posts are self-approved.

    if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $fuid) && !perm_is_moderator($fid, $fuid)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}POST ";
        $sql.= "(TID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, APPROVED, IPADDRESS) ";
        $sql.= "VALUES ($tid, $reply_pid, $fuid, $tuid, NOW(), 0, '$ipaddress')";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}POST ";
        $sql.= "(TID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, APPROVED, APPROVED_BY, IPADDRESS) ";
        $sql.= "VALUES ($tid, $reply_pid, $fuid, $tuid, NOW(), NOW(), $fuid, '$ipaddress')";
    }

    if (!$result = db_query($sql, $db_post_create)) return false;

    if ($result) {

        $new_pid = db_insert_id($db_post_create);

        // Insert the post content. This query can take some time
        // because of the FULLTEXT indexing used for seatching

        $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
        $sql.= "VALUES ('$tid', '$new_pid', '$post_content')";

        if (!$result = db_query($sql, $db_post_create)) return false;

        if ($result) {

            // Update the thread length so it matches the number of posts

            $sql = "UPDATE {$table_data['PREFIX']}THREAD SET LENGTH = '$new_pid', MODIFIED = NOW() ";
            $sql.= "WHERE TID = '$tid'";

            if (!$result = db_query($sql, $db_post_create)) return false;

            // Update the user's post count.

            $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK SET LAST_POST = NOW(), ";
            $sql.= "POST_COUNT = POST_COUNT + 1 WHERE UID = '$fuid'";

            if (!$result = db_query($sql, $db_post_create)) return false;

        }else {

            $new_pid = -1;
        }

    }else {

        $new_pid = -1;
    }

    return $new_pid;
}

function post_approve($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    $db_post_approve = db_connect();

    $approve_uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}POST SET APPROVED = NOW(), APPROVED_BY = '$approve_uid' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!$result = db_query($sql, $db_post_approve)) return false;

    return true;
}

function post_save_attachment_id($tid, $pid, $aid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_md5($aid)) return false;

    $db_post_save_attachment_id = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT TID FROM POST_ATTACHMENT_IDS WHERE ";
    $sql.= "FID = '$forum_fid' AND TID = '$tid' AND PID = '$pid'";

    if (!$result = db_query($sql, $db_post_save_attachment_id)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE POST_ATTACHMENT_IDS SET AID = '$aid' ";
        $sql.= "WHERE FID = '$forum_fid' AND TID = '$tid' AND PID = '$pid'";

    }else {

        $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
        $sql.= "VALUES ($forum_fid, $tid, $pid, '$aid')";
    }

    if (!$result = db_query($sql, $db_post_save_attachment_id)) return false;

    return true;
}

function post_create_thread($fid, $uid, $title, $poll = 'N', $sticky = 'N', $closed = false)
{
    if (!is_numeric($fid)) return -1;
    if (!is_numeric($uid)) return -1;

    $title = db_escape_string(_htmlentities($title));

    $poll = ($poll == 'Y') ? 'Y' : 'N';
    $sticky = ($sticky == 'Y') ? 'Y' : 'N';
    $closed = $closed ? "NOW()" : "NULL";

    $db_post_create_thread = db_connect();

    if (!$table_data = get_table_prefix()) return -1;

    $sql = "INSERT INTO {$table_data['PREFIX']}THREAD " ;
    $sql.= "(FID, BY_UID, TITLE, LENGTH, POLL_FLAG, STICKY, CREATED, MODIFIED, CLOSED) ";
    $sql.= "VALUES ('$fid', '$uid', '$title', 0, '$poll', '$sticky', NOW(), NOW(), $closed)";

    if (!$result = db_query($sql, $db_post_create_thread)) return false;

    if ($result) {
        $new_tid = db_insert_id($db_post_create_thread);
    }else {
        $new_tid = -1;
    }

    return $new_tid;
}

function post_draw_to_dropdown($default_uid, $show_all = true)
{
    $lang = load_language_file();

    $html = "<select name=\"t_to_uid\">\n";
    $db_post_draw_to_dropdown = db_connect();

    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $uid = bh_session_get_value('UID');

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

        if (db_num_rows($result) > 0) {

            if ($top_user = db_fetch_array($result)) {
                
                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }
            
                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']));
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>\n";
            }
        }
    }

    if ($show_all) {
        $html .= "<option value=\"0\">{$lang['allcaps']}</option>\n";
    }

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql.= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

    while ($row = db_fetch_array($result)) {

        if (isset($row['LOGON']) && isset($row['NICKNAME'])) {

            if (isset($row['PEER_NICKNAME'])) {
                if (!is_null($row['PEER_NICKNAME']) && strlen($row['PEER_NICKNAME']) > 0) {
                    $row['NICKNAME'] = $row['PEER_NICKNAME'];
                }
            }
        
            $fmt_username = word_filter_add_ob_tags(format_user_name($row['LOGON'], $row['NICKNAME']));
            $html .= "<option value=\"{$row['UID']}\">$fmt_username</option>\n";
        }
    }

    $html.= "</select>";
    return $html;
}

function post_draw_to_dropdown_recent($default_uid, $show_all = true)
{
    $lang = load_language_file();

    $html = "<select name=\"t_to_uid_recent\" class=\"recent_user_dropdown\" onclick=\"checkToRadio(". ($default_uid == 0 ? 1 : 0).")\">\n";
    $db_post_draw_to_dropdown = db_connect();

    if (!$table_data = get_table_prefix()) return false;
    if (!is_numeric($default_uid)) $default_uid = 0;

    $forum_fid = $table_data['FID'];

    $uid = bh_session_get_value('UID');

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

        if (db_num_rows($result) > 0) {

            if ($top_user = db_fetch_array($result)) {
                
                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }
            
                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']));
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>\n";
            }
        }
    }

    if ($show_all) {
        $html .= "<option value=\"0\">{$lang['allcaps']}</option>\n";
    }

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql.= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

    while ($row = db_fetch_array($result)) {
        
        if (isset($row['LOGON']) && isset($row['NICKNAME'])) {

            if (isset($row['PEER_NICKNAME'])) {
                if (!is_null($row['PEER_NICKNAME']) && strlen($row['PEER_NICKNAME']) > 0) {
                    $row['NICKNAME'] = $row['PEER_NICKNAME'];
                }
            }
        
            $fmt_username = word_filter_add_ob_tags(format_user_name($row['LOGON'], $row['NICKNAME']));
            $html .= "<option value=\"{$row['UID']}\">$fmt_username</option>\n";
        }
    }

    $html.= "</select>";
    return $html;
}

function post_draw_to_dropdown_in_thread($tid, $default_uid, $show_all = true, $inc_blank = false, $custom_html = "")
{
    $lang = load_language_file();

    $html = "<select name=\"t_to_uid_in_thread\" class=\"user_in_thread_dropdown\" ".$custom_html.">\n";
    $db_post_draw_to_dropdown = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!$table_data = get_table_prefix()) return "";

    $uid = bh_session_get_value('UID');

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

        if (db_num_rows($result) > 0) {

            if ($top_user = db_fetch_array($result)) {
                
                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }
            
                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']));
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>\n";
            }
        }
    }

    if ($show_all) {

        $html.= "<option value=\"0\">{$lang['allcaps']}</option>\n";

    }else if ($inc_blank) {

        if (isset($default_uid) && $default_uid != 0) {
            $html.= "<option value=\"0\">&nbsp;</option>\n";
        }else {
            $html.= "<option value=\"0\" selected=\"selected\">&nbsp;</option>\n";
        }
    }

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.FROM_UID <> '$default_uid' ";
    $sql.= "GROUP BY POST.FROM_UID LIMIT 0, 20";

    if (!$result = db_query($sql, $db_post_draw_to_dropdown)) return false;

    while ($row = db_fetch_array($result)) {

        if (isset($row['LOGON']) && isset($row['NICKNAME'])) {

            if (isset($row['PEER_NICKNAME'])) {
                if (!is_null($row['PEER_NICKNAME']) && strlen($row['PEER_NICKNAME']) > 0) {
                    $row['NICKNAME'] = $row['PEER_NICKNAME'];
                }
            }
        
            $fmt_username = word_filter_add_ob_tags(format_user_name($row['LOGON'], $row['NICKNAME']));
            $html .= "<option value=\"{$row['UID']}\">$fmt_username</option>\n";
        }
    }

    $html .= "</select>";
    return $html;
}

function get_user_posts($uid)
{
    $db_get_user_posts = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT TID, PID FROM {$table_data['PREFIX']}POST WHERE FROM_UID = '$uid'";

    if (!$result = db_query($sql, $db_get_user_posts)) return false;

    if (db_num_rows($result)) {
        $user_post_array = array();
        while ($row = db_fetch_array($result)) {
            $user_post_array[] = $row;
        }
        return $user_post_array;
    }else {
        return false;
    }
}

function check_ddkey($ddkey)
{
    $db_check_ddkey = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DDKEY) FROM ";
    $sql.= "{$table_data['PREFIX']}USER_TRACK WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_check_ddkey)) return false;

    if (db_num_rows($result)) {

        list($ddkey_check) = db_fetch_array($result);

        $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
        $sql.= "SET DDKEY = FROM_UNIXTIME($ddkey) WHERE UID = '$uid'";

        if (!$result = db_query($sql, $db_check_ddkey)) return false;

    }else{

        $ddkey_check = "";

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_TRACK (UID, DDKEY) ";
        $sql.= "VALUES ('$uid', FROM_UNIXTIME($ddkey))";

        if (!$result = db_query($sql, $db_check_ddkey)) return false;
    }

    return !($ddkey == $ddkey_check);
}

function check_post_frequency()
{
    $db_check_post_frequency = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $minimum_post_frequency = intval(forum_get_setting('minimum_post_frequency', false, 0));

    if ($minimum_post_frequency == 0) return true;

    $sql = "SELECT UNIX_TIMESTAMP(LAST_POST) + $minimum_post_frequency, ";
    $sql.= "UNIX_TIMESTAMP(NOW()) FROM {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_check_post_frequency)) return false;

    if (db_num_rows($result) > 0) {

        list($last_post_stamp, $current_timestamp) = db_fetch_array($result);

        if (!is_numeric($last_post_stamp) || $last_post_stamp < $current_timestamp) {

            $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
            $sql.= "SET LAST_POST = NOW() WHERE UID = '$uid'";

            if (!$result = db_query($sql, $db_check_post_frequency)) return false;

            return true;
        }

    }else{

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_TRACK ";
        $sql.= "(UID, LAST_POST) VALUES ('$uid', NOW())";

        if (!$result = db_query($sql, $db_check_post_frequency)) return false;

        return true;
    }

    return false;
}

class MessageText {

    // Note: PHP/5.0 introduces new public, private and protected
    // modifiers whilst removing the var modifier. However it only
    // causes problems if PHP/5.0's new STRICT error reporting
    // is also enabled, hence we're (for the mean while) going to
    // stick with PHP/4.x's old var modifiers, because for now
    // it is going to be more compatible with our 'audience'

    var $html = "";
    var $text = "";
    var $original_text = "";
    var $diff = false;
    var $emoticons = true;
    var $links = true;
    var $tinymce = false;

    function MessageText ($html = 0, $content = "", $emoticons = true, $links = true)
    {
        $post_prefs = bh_session_get_post_page_prefs();
        if ($post_prefs & POST_TINYMCE_DISPLAY) {
            $this->tinymce = true;
        }
        $this->diff = false;
        $this->original_text = "";
        $this->links = $links;
        $this->setEmoticons($emoticons);
        $this->setHTML($html);
        $this->setContent($content);
    }

    function setHTML ($html, $strip_tags = false)
    {        
        if ($html == false || $html == "N") {
            $this->html = 0;
        } else if ($html == 1 || $html == "A") {
            $this->html = 1;
        } else {
            $this->html = 2;
        }

        if ($this->html == 0 && $strip_tags === true) {
            $this->setContent(strip_tags($this->getOriginalContent()));
        }else {
            $this->setContent($this->getOriginalContent());
        }
    }

    function getHTML () {
        return $this->html;
    }

    function setEmoticons ($bool) {
        $this->emoticons = ($bool == true) ? true : false;
        $this->setContent($this->getOriginalContent());
    }

    function getEmoticons () {
        return $this->emoticons;
    }

    function getLinks () {
        return $this->links;
    }

    function setLinks ($bool) {
        $this->links = ($bool == true) ? true : false;
        $this->setContent($this->getOriginalContent());
    }

    function setContent ($text) {

        $this->original_text = $text;

        if ($this->html == 0) {
            $text = make_html($text, false, $this->emoticons, $this->links);
        } else if ($this->html > 0) {
            if ($this->tinymce) $text = tidy_tinymce($text);
            $o = $text;
            $text = fix_html($text, $this->emoticons, $this->links);

            // <code></code> blocks are removed as the code highlighter often trips up this comparison
            if (trim(preg_replace("/<code[^>]*>.*<\/code>/s", '', $o)) != trim(preg_replace("/<code[^>]*>.*<\/code>/s", '', tidy_html($text, ($this->html == 1) ? true : false)))) {
                $this->diff = true;
            }

            if ($this->html == 1) {
                $text = add_paragraphs($text);
            }
        }

        $this->text = $text;
    }

    function getContent () {
        return $this->text;
    }

    function getTidyContent () {
        if ($this->html == 0) {
            return strip_tags($this->text);
        } else if ($this->html > 0) {
            if ($this->tinymce) return _htmlentities(tidy_html($this->text, false, $this->links, true));
            return _htmlentities(tidy_html($this->text, ($this->html == 1) ? true : false, $this->links));
        }
    }

    function getOriginalContent ($htmlentities = false) {
        if ($htmlentities === true) {
            return _htmlentities($this->original_text);
        }
        return $this->original_text;         
    }

    function isDiff () {
        return $this->diff;
    }
}

class MessageTextParse {

    var $html = "";
    var $links = "";
    var $message = "";
    var $sig = "";
    var $original = "";

    function MessageTextParse ($message, $emots_default = true, $links_enabled = true) {

        $this->original = $message;

        $message = explode('<div class="sig">', trim($message));

        if (count($message) > 1 && substr($message[count($message)-1], -6) == '</div>') {

            $sig = '<div class="sig">' . array_pop($message);

            do {
                if (count(explode('<div', $sig)) == count(explode('</div>', $sig))) break;
                $sig = '<div class="sig">' . array_pop($message) . $sig;
            } while (0);

            $sig = preg_replace("/^<div class=\"sig\">(.*)<\/div>$/s", '$1', $sig);

        } else {

            $sig = "";
        }

        $message = implode('<div class="sig">', $message);

        $emoticons = $emots_default;

        if (preg_match("/^<noemots>.*<\/noemots>$/s", $message) > 0) {
            $emoticons = false;
        }

        $html = 0;

        $message_temp = preg_replace("/<a href=\"(http:\/\/)?([^\"]*)\">((http:\/\/)?\\2)<\/a>/", "\\3", $message);

        if ($message_temp != $message) {
            $links = true;
        } else {
            $links = $links_enabled;
        }

        $message = $message_temp;

        if (strip_tags($message, '<p><br>') != $message_temp) {

            $html = 2;

            if (add_paragraphs($message) == $message) {
                $html = 1;
            }

        } else {

            $message = _htmlentities_decode(strip_tags($message));
        }

        $this->message = $message;
        $this->sig = $sig;
        $this->emoticons = $emoticons;
        $this->html = $html;
        $this->links = $links;
    }

    function getMessage () {
        return $this->message;
    }

    function getSig () {
        return $this->sig;
    }

    function getMessageHTML () {
        return $this->html;
    }

    function getEmoticons () {
        return $this->emoticons;
    }

    function getLinks () {
        return $this->links;
    }

    function getOriginal () {
        return $this->original;
    }
}

?>