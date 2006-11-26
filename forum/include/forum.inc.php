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

/* $Id: forum.inc.php,v 1.195 2006-11-26 00:41:37 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function get_forum_data()
{
    static $forum_data = false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_array($forum_data) || !isset($forum_data['UID']) || $forum_data['UID'] != $uid) {

        $db_get_forum_data = db_connect();

        if (isset($_GET['webtag']) && strlen(trim(_stripslashes($_GET['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_GET['webtag']));
        }elseif (isset($_POST['webtag']) && strlen(trim(_stripslashes($_POST['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_POST['webtag']));
        }elseif (isset($_SERVER['argv'][1]) && strlen(trim(_stripslashes($_SERVER['argv'][1]))) > 0) {
            $webtag = trim(_stripslashes($_SERVER['argv'][1]));
        }

        if (isset($webtag) && preg_match("/^[A-Z0-9_]+$/", $webtag) > 0) {

            // Check #1: See if the webtag specified in GET/POST
            // actually exists.

            $webtag = addslashes($webtag);

            $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, CONCAT(FORUMS.WEBTAG, '', '_') AS PREFIX, ";
            $sql.= "FORUMS.ACCESS_LEVEL, USER_FORUM.ALLOWED, '$uid' AS UID FROM FORUMS FORUMS ";
            $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
            $sql.= "AND USER_FORUM.UID = $uid) WHERE WEBTAG = '$webtag'";

            $result = db_query($sql, $db_get_forum_data);

            if (db_num_rows($result) > 0) {

                $forum_data = db_fetch_array($result);

                if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;
                if (!isset($forum_data['ALLOWED'])) $forum_data['ALLOWED'] = 0;

                return $forum_data;
            }

            return array('WEBTAG_SEARCH' => $webtag);

        }else {

            // Check #2: Try and select a default webtag from
            // the databse

            $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, CONCAT(FORUMS.WEBTAG, '', '_') AS PREFIX, ";
            $sql.= "FORUMS.ACCESS_LEVEL, USER_FORUM.ALLOWED, '$uid' AS UID FROM FORUMS FORUMS ";
            $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
            $sql.= "AND USER_FORUM.UID = $uid) WHERE DEFAULT_FORUM = 1";

            $result = db_query($sql, $db_get_forum_data);

            if (db_num_rows($result) > 0) {

                $forum_data = db_fetch_array($result);
            }
        }
    }

    return $forum_data;
}

function get_webtag(&$webtag_search)
{
    $forum_data = get_forum_data();

    if (is_array($forum_data) && isset($forum_data['WEBTAG'])) {
        return $forum_data['WEBTAG'];
    }

    if (is_array($forum_data) && isset($forum_data['WEBTAG_SEARCH'])) {
        $webtag_search = $forum_data['WEBTAG_SEARCH'];
    }

    return false;
}

function get_table_prefix()
{
    $forum_data = get_forum_data();

    if (is_array($forum_data) && isset($forum_data['WEBTAG'])) {
        return $forum_data;
    }

    return false;
}

function forum_check_access_level()
{
    $db_forum_check_access_level = db_connect();
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if ($forum_data = get_forum_data()) {

        if (isset($forum_data['ACCESS_LEVEL'])) {

            if ($forum_data['ACCESS_LEVEL'] < 0) {

                return forum_closed_message();

            }elseif ($forum_data['ACCESS_LEVEL'] == 1 && $forum_data['ALLOWED'] != 1) {

                return forum_restricted_message();

            }elseif ($forum_data['ACCESS_LEVEL'] == 2 && !bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

                return forum_check_password($forum_data['FID']);
            }
        }

        return true;
    }

    return false;
}

function forum_closed_message()
{
    $lang = load_language_file();

    html_draw_top();

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    echo "<h1>{$lang['closed']}</h1>\n";
    
    if ($closed_message = forum_get_setting('closed_message', false)) {
        echo "<h2>$closed_message</h2>\n";
    }else {
        echo "<h2>$forum_name {$lang['iscurrentlyclosed']}</h2>\n";
    }

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {
        echo "<p>{$lang['adminforumclosedtip']}</p>\n";
    }

    html_draw_bottom();
    exit;
}

function forum_restricted_message()
{
    $lang = load_language_file();

    html_draw_top();

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    echo "<h1>{$lang['restricted']}</h1>\n";
    
    if ($restricted_message = forum_get_setting('closed_message', false)) {
        echo "<h2>{$restricted_message}</h2>\n";
    }else {
        echo "<h2>{$lang['youdonothaveaccessto']} $forum_name.</h2>\n";
        echo "<h2>{$lang['toapplyforaccessplease']}</h2>\n";
    }

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {
        echo "<p>{$lang['adminforumclosedtip']}</p>\n";
    }

    html_draw_bottom();
    exit;
}

function forum_get_password($forum_fid)
{
    $db_forum_get_password = db_connect();

    if (!is_numeric($forum_fid)) return false;

    $sql = "SELECT FORUM_PASSWD FROM FORUMS WHERE FID = '$forum_fid'";
    $result = db_query($sql, $db_forum_get_password);

    if (db_num_rows($result) > 0) {

        list($forum_passwd) = db_fetch_array($result, DB_RESULT_NUM);
        return is_md5($forum_passwd) ? $forum_passwd : false;
    }

    return false;
}

function forum_check_password($forum_fid)
{
    global $frame_top_target;
    
    $db_forum_check_password = db_connect();

    $webtag = get_webtag($webtag_search);

    if (!is_numeric($forum_fid)) return false;

    if ($forum_passwd = forum_get_password($forum_fid)) {

        if (isset($_COOKIE["bh_{$webtag}_password"]) && strlen(trim(_stripslashes($_COOKIE["bh_{$webtag}_password"]))) > 0) {
            $passwd = md5($_COOKIE["bh_{$webtag}_password"]);
        }else {
            $passwd = "";
        }

        if ($passwd == $forum_passwd) return true;

        // If we got this far then the password verification failed or
        // the user hasn't seen the password dialog before.

        $lang = load_language_file();

        html_draw_top();

        echo "<h1>{$lang['passwdprotectedforum']}</h1>\n";

        if ($password_protected_message = forum_get_setting('password_protected_message', false)) {
            echo "<h2>{$password_protected_message}</h2>\n";
        }else {
            echo "<h2>{$lang['passwdprotectedwarning']}</h2>\n";
        }

        if (isset($_COOKIE["bh_{$webtag}_password"]) && strlen(trim(_stripslashes($_COOKIE["bh_{$webtag}_password"]))) > 0) {
            bh_setcookie("bh_{$webtag}_password", "", time() - YEAR_IN_SECONDS);
            echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
            echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";
        }

        echo "<div align=\"center\">\n";

        if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
            echo "<form method=\"post\" action=\"./forum_password.php\" target=\"$frame_top_target\">\n";
        }else {
            echo "<form method=\"post\" action=\"./forum_password.php\" target=\"_top\">\n";
        }

        echo "  ", form_input_hidden('webtag', $webtag), "\n";
        echo "  ", form_input_hidden('ret', get_request_uri()), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"350\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">\n";
        echo "        <table class=\"box\" width=\"90%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\" align=\"center\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['enterpasswd']}</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "              <table class=\"posthead\" width=\"90%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\">{$lang['passwd']}:</td>\n";
        echo "                  <td align=\"left\">", form_input_password('forum_password', '', 32), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">", form_checkbox('remember_password', 'Y', $lang['rememberpassword'], false), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
        echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }

    return true;
}

function forum_get_settings()
{
    $db_forum_get_settings = db_connect();

    static $default_forum_settings = false;
    static $forum_settings = false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!is_array($forum_settings) || !is_array($default_forum_settings)) {

        $default_forum_settings = array();
        $forum_settings = array('fid' => $forum_fid);

        $sql = "SELECT WEBTAG, ACCESS_LEVEL FROM FORUMS WHERE FID = $forum_fid";
        $result = db_query($sql, $db_forum_get_settings);

        list($webtag, $access_level) = db_fetch_array($result, DB_RESULT_NUM);

        $forum_settings['webtag'] = $webtag;
        $forum_settings['access_level'] = $access_level;

        $sql = "SELECT FID, SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID IN (0, $forum_fid)";
        $result = db_query($sql, $db_forum_get_settings);

        while ($row = db_fetch_array($result)) {

            if ($row['FID'] == 0) {
                $default_forum_settings[$row['SNAME']] = $row['SVALUE'];
            }else {
                $forum_settings[$row['SNAME']] = $row['SVALUE'];
            }
        }
    }

    return array_merge($default_forum_settings, $forum_settings);
}

function forum_get_default_settings()
{
    $db_forum_get_default_settings = db_connect();

    static $default_forum_settings = false;

    if (!is_array($default_forum_settings)) {

        $default_forum_settings = array();

        $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = 0";
        $result = db_query($sql, $db_forum_get_default_settings);

        while ($row = db_fetch_array($result)) {
            $default_forum_settings[$row['SNAME']] = $row['SVALUE'];
        }
    }

    return $default_forum_settings;
}

function forum_get_settings_by_fid($fid)
{
    $db_forum_get_settings_by_fid = db_connect();

    if (!is_numeric($fid)) return false;

    $forum_settings_by_fid = array('fid' => $fid);

    $sql = "SELECT WEBTAG, ACCESS_LEVEL FROM FORUMS WHERE FID = $fid";
    $result = db_query($sql, $db_forum_get_settings_by_fid);

    list($webtag, $access_level) = db_fetch_array($result, DB_RESULT_NUM);

    $forum_settings_by_fid['webtag'] = $webtag;
    $forum_settings_by_fid['access_level'] = $access_level;

    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = $fid";
    $result = db_query($sql, $db_forum_get_settings_by_fid);

    while ($row = db_fetch_array($result)) {

        $forum_settings_by_fid[$row['SNAME']] = $row['SVALUE'];
    }

    $default_forum_settings = forum_get_default_settings();
    return array_merge($default_forum_settings, $forum_settings_by_fid);
}

function forum_save_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    $db_forum_save_settings = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = $forum_fid";
    $result = db_query($sql, $db_forum_save_settings);

    foreach ($forum_settings_array as $sname => $svalue) {

        $sname = addslashes($sname);
        $svalue = addslashes($svalue);

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql.= "VALUES ($forum_fid, '$sname', '$svalue')";

        $result = db_query($sql, $db_forum_save_settings);
    }
}

function forum_save_default_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    $db_forum_save_default_settings = db_connect();

    $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = '0'";
    $result = db_query($sql, $db_forum_save_default_settings);

    foreach ($forum_settings_array as $sname => $svalue) {

        $sname = addslashes($sname);
        $svalue = addslashes($svalue);

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql.= "VALUES ('0', '$sname', '$svalue')";

        $result = db_query($sql, $db_forum_save_default_settings);
    }
}

function forum_get_name($fid)
{
    $db_forum_get_name = db_connect();

    if (!is_numeric($fid)) return "A Beehive Forum";

    $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
    $sql.= "WHERE SNAME = 'forum_name' AND FID = '$fid'";

    $result = db_query($sql, $db_forum_get_name);

    if (db_num_rows($result) > 0) {

        list($forum_name) = db_fetch_array($result, DB_RESULT_NUM);
        return $forum_name;
    }

    return "A Beehive Forum";
}

function forum_get_webtag($fid)
{
    $db_forum_get_webtag = db_connect();

    if (!is_numeric($fid)) return false;

    $sql = "SELECT WEBTAG FROM FORUMS WHERE FID = $fid";
    $result = db_query($sql, $db_forum_get_webtag);

    if (db_num_rows($result) > 0) {

        list($forum_webtag) = db_fetch_array($result, DB_RESULT_NUM);
        return $forum_webtag;
    }

    return false;
}

function forum_get_table_prefix($fid)
{
    $db_forum_get_webtag = db_connect();

    if (!is_numeric($fid)) return false;

    $sql = "SELECT FID, WEBTAG, CONCAT(WEBTAG, '', '_') AS PREFIX ";
    $sql.= "FROM FORUMS WHERE FID = $fid";

    $result = db_query($sql, $db_forum_get_webtag);

    if (db_num_rows($result) > 0) {

        $forum_data = db_fetch_array($result);
        return $forum_data;
    }

    return false;
}

function forum_get_setting($setting_name, $value = false, $default = false)
{
    global $forum_settings;

    if (is_array($forum_settings) && isset($forum_settings[$setting_name])) {

        if ($value !== false) {

            if (strtoupper($forum_settings[$setting_name]) == strtoupper($value)) {
                return true;
            }

        }else {

            return $forum_settings[$setting_name];
        }
    }

    return $default;
}

function forum_get_unread_cutoff()
{
    $messages_unread_cutoff = forum_get_setting('messages_unread_cutoff', false, 31536000);

    // If $messages_unread_cutoff lower than 0 then unread
    // functionality is disabled and we return false.

    if ($messages_unread_cutoff < 0) return false;

    // If $messages_unread_cutoff equal 0 then we return 0

    if ($messages_unread_cutoff == 0) return 0;

    // Failing the above we subtract $messages_unread_cutoff
    // from the current server time.

    return time() - $messages_unread_cutoff;
}

function forum_load_start_page()
{
    $webtag = get_webtag($webtag_search);

    if (@file_exists("./forums/$webtag/start_main.php")) {

        $filesize = filesize("./forums/$webtag/start_main.php");

        if ($filesize > 0 && @$fp = fopen("./forums/$webtag/start_main.php", "r")) {

            $content = fread($fp, $filesize);
            fclose($fp);
            return $content;
        }
    }

    return false;
}

function forum_save_start_page($content)
{
    $webtag = get_webtag($webtag_search);

    if (@!is_dir("forums")) {

        @mkdir("forums", 0755);
        @chmod("forums", 0777);
    }

    if (@!is_dir("forums/$webtag")) {

        @mkdir("forums/$webtag", 0755);
        @chmod("forums/$webtag", 0777);
    }

    if (@$fp = fopen("./forums/$webtag/start_main.php", "w")) {

        fwrite($fp, $content);
        fclose($fp);

        return true;
    }

    return false;
}

function forum_create($webtag, $forum_name, $access)
{
    // Ensure the variables we've been given are valid

    $webtag = preg_replace("/[^A-Z0-9_]/", "", strtoupper($webtag));

    if (!is_numeric($access)) $access = 0;

    // Only the queen can create forums!!

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        if (($uid = bh_session_get_value('UID')) === false) return false;

        $db_forum_create = db_connect();

        // Check that the WEBTAG is unique.

        $sql = "SELECT FID FROM FORUMS WHERE WEBTAG = '$webtag'";
        if (!$result = db_query($sql, $db_forum_create)) return false;

        if (db_num_rows($result) > 0) return false;

        // Beehive Table Names

        $table_array = array('ADMIN_LOG',     'BANNED',        'FILTER_LIST', 
                             'FOLDER',        'FORUM_LINKS',   'LINKS', 
                             'LINKS_COMMENT', 'LINKS_FOLDERS', 'LINKS_VOTE',
                             'POLL',          'POLL_VOTES',    'POST',
                             'POST_CONTENT',  'PROFILE_ITEM',  'PROFILE_SECTION',
                             'RSS_FEEDS',     'RSS_HISTORY',   'STATS',
                             'THREAD',        'THREAD_STATS',  'THREAD_TRACK',
                             'USER_FOLDER',   'USER_PEER',     'USER_POLL_VOTES',
                             'USER_PREFS',    'USER_PROFILE',  'USER_SIG', 
                             'USER_THREAD',   'USER_TRACK');

        // Check to see if any of the Beehive tables already exist.
        // If they do then something is wrong and we should error out.

        foreach ($table_array as $table_name) {

            $sql = "SHOW TABLES LIKE '{$webtag}_{$table_name}'";

            if (!$result = db_query($sql, $db_forum_create)) return false;

            if (db_num_rows($result) > 0) return false;
        }

        $sql = "CREATE TABLE {$webtag}_ADMIN_LOG (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CREATED DATETIME DEFAULT NULL,";
        $sql.= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ENTRY TEXT,";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_BANNED (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  BANTYPE TINYINT(4) NOT NULL DEFAULT '0',";
        $sql.= "  BANDATA VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  COMMENT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_FILTER_LIST (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID,UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_FOLDER (";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TITLE VARCHAR(32) DEFAULT NULL,";
        $sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL,";
        $sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(8) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_FORUM_LINKS (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  POS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  URI VARCHAR(255) DEFAULT NULL,";
        $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (LID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_LINKS (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  URI VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  TITLE VARCHAR(64) NOT NULL DEFAULT '',";
        $sql.= "  DESCRIPTION TEXT NOT NULL,";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  CLICKS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (LID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_LINKS_COMMENT (";
        $sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  COMMENT TEXT NOT NULL,";
        $sql.= "  PRIMARY KEY  (CID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_LINKS_FOLDERS (";
        $sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT NULL,";
        $sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_LINKS_VOTE (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (LID,UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_POLL (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  QUESTION VARCHAR(64) DEFAULT NULL,";
        $sql.= "  CLOSES DATETIME DEFAULT NULL,";
        $sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
        $sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_POLL_VOTES (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID,OPTION_ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_POST (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  VIEWED DATETIME DEFAULT NULL,";
        $sql.= "  CREATED DATETIME DEFAULT NULL,";
        $sql.= "  STATUS TINYINT(4) DEFAULT '0',";
        $sql.= "  APPROVED DATETIME DEFAULT NULL,";
        $sql.= "  APPROVED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  EDITED DATETIME DEFAULT NULL,";
        $sql.= "  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
        $sql.= "  MOVED_TID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  MOVED_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  KEY TO_UID (TO_UID),";
        $sql.= "  KEY FROM_UID (FROM_UID),";
        $sql.= "  KEY IPADDRESS (IPADDRESS, FROM_UID),";
        $sql.= "  KEY CREATED (CREATED)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_POST_CONTENT (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_PROFILE_ITEM (";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PIID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_PROFILE_SECTION (";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PSID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_RSS_FEEDS (";
        $sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  NAME VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  URL VARCHAR(255) DEFAULT NULL,";
        $sql.= "  PREFIX VARCHAR(16) DEFAULT NULL,";
        $sql.= "  FREQUENCY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  LAST_RUN DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (RSSID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_RSS_HISTORY (";
        $sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  LINK VARCHAR(255) DEFAULT NULL,";
        $sql.= "  KEY RSSID (RSSID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_STATS (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_THREAD (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
        $sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL,";
        $sql.= "  CREATED DATETIME DEFAULT NULL,";
        $sql.= "  MODIFIED DATETIME DEFAULT NULL,";
        $sql.= "  CLOSED DATETIME DEFAULT NULL,";
        $sql.= "  STICKY CHAR(1) DEFAULT NULL,";
        $sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL,";
        $sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (TID),";
        $sql.= "  KEY BY_UID (BY_UID),";
        $sql.= "  KEY STICKY (STICKY, MODIFIED), ";
        $sql.= "  KEY LENGTH (LENGTH)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_THREAD_STATS (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UNREAD_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  UNREAD_CREATED DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_THREAD_TRACK (";
        $sql.= "  TID MEDIUMINT(8) NOT NULL DEFAULT '0',";
        $sql.= "  NEW_TID MEDIUMINT(8) NOT NULL DEFAULT '0',";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  TRACK_TYPE TINYINT(4) NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID, NEW_TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_FOLDER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (UID,FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_PEER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
        $sql.= "  PEER_NICKNAME VARCHAR(32) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PEER_UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_POLL_VOTES (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  VOTE_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (TID,UID,VOTE_ID,OPTION_ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_PREFS (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  POSTS_PER_PAGE VARCHAR(3) NOT NULL DEFAULT '20',";
        $sql.= "  FONT_SIZE VARCHAR(2) NOT NULL DEFAULT '10',";
        $sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  START_PAGE VARCHAR(3) NOT NULL DEFAULT '0',";
        $sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
        $sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
        $sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  SHOW_THUMBS VARCHAR(2) NOT NULL DEFAULT '2',";
        $sql.= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  USE_MOVER_SPOILER CHAR(1) DEFAULT 'N',";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_PROFILE (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
        $sql.= "  PRIVACY TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (UID,PIID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_SIG (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  HTML CHAR(1) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_THREAD (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
        $sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,TID),";
        $sql.= "  KEY TID (TID),";
        $sql.= "  KEY LAST_READ (LAST_READ)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        $sql = "CREATE TABLE {$webtag}_USER_TRACK (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  DDKEY DATETIME DEFAULT NULL,";
        $sql.= "  LAST_POST DATETIME DEFAULT NULL,";
        $sql.= "  LAST_SEARCH DATETIME DEFAULT NULL,";
        $sql.= "  LAST_SEARCH_KEYWORDS text,";
        $sql.= "  POST_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  USER_TIME_BEST DATETIME DEFAULT NULL,";
        $sql.= "  USER_TIME_TOTAL DATETIME DEFAULT NULL,";
        $sql.= "  USER_TIME_UPDATED DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return;
        }

        // Save Webtag

        $sql = "INSERT INTO FORUMS (WEBTAG, ACCESS_LEVEL) VALUES ('$webtag', $access)";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete_tables($webtag);
            
            if (defined("BEEHIVE_INSTALL_NOWARN")) {
                db_trigger_error($sql, $db_forum_create);
            }

            return false;
        }

        // Get the new FID so we can save the settings

        $forum_fid = db_insert_id($db_forum_create);

        // Create General Folder

        $sql = "INSERT INTO {$webtag}_FOLDER (TITLE, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
        $sql.= "VALUES ('General', NULL, NULL, 0)";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $folder_fid = db_insert_id($db_forum_create);

        // Create folder permissions

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES (0, '$forum_fid', '$folder_fid', 14588);";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        // Add some default forum links

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (1, 'Forum Links:', NULL)";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Project Beehive Home', 'http://www.beehiveforum.net/')";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Teh Forum', 'http://www.tehforum.co.uk/forum/')";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        // Create user permissions (current user)

        $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
        $sql.= "VALUES ('$forum_fid', NULL, NULL, 1);";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $new_gid = db_insert_id($db_forum_create);

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '$forum_fid', 0, 1792);";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $sql = "INSERT INTO GROUP_USERS VALUES ($new_gid, $uid);";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '$forum_fid', 1, 6652);";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        // Create Welcome thread and post.

        $sql = "INSERT INTO {$webtag}_THREAD ";
        $sql.= "(FID, BY_UID, TITLE, LENGTH, POLL_FLAG, CREATED, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
        $sql.= "VALUES (1, 1, 'Welcome', 1, 'N', NOW(), NOW(), NULL, 'N', NULL, NULL)";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return;
        }

        $sql = "INSERT INTO {$webtag}_POST ";
        $sql.= "(TID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, ";
        $sql.= "APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) VALUES (1, 0, 1, 0, NULL, NOW(), ";
        $sql.= "0, NOW(), 1, NULL, 0, '')";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return;
        }

        $sql = "INSERT INTO {$webtag}_POST_CONTENT (TID, PID, CONTENT) ";
        $sql.= "VALUES (1, 1, 'Welcome to your new Beehive Forum')";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return;
        }

        // Create Top Level Links Folder

        $sql = "INSERT INTO {$webtag}_LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y')";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        // Store Forum settings

        $forum_settings = array('wiki_integration_uri'    => 'http://en.wikipedia.org/wiki/[WikiWord]',
                                'enable_wiki_quick_links' => 'Y',
                                'enable_wiki_integration' => 'N',
                                'minimum_post_frequency'  => '0',
                                'maximum_post_length'     => '6226',
                                'post_edit_time'          => '0',
                                'allow_post_editing'      => 'Y',
                                'require_post_approval'   => 'N',
                                'forum_dl_saving'         => 'Y',
                                'forum_timezone'          => '0',
                                'default_language'        => 'en',
                                'default_emoticons'       => 'default',
                                'default_style'           => 'Default',
                                'forum_keywords'          => 'A Beehive Forum, BeehiveForum, Project BeehiveForum',
                                'forum_desc'              => 'A Beehive Forum',
                                'forum_email'             => 'admin@abeehiveforum.net',
                                'forum_name'              => $forum_name,
                                'show_links'              => 'Y',
                                'allow_polls'             => 'Y',
                                'show_stats'              => 'Y',
                                'allow_search_spidering'  => 'Y',
                                'guest_account_enabled'   => 'Y');

        foreach ($forum_settings as $sname => $svalue) {

            $sname = addslashes($sname);
            $svalue = addslashes($svalue);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql.= "VALUES ($forum_fid, '$sname', '$svalue')";

            if (!$result = @db_query($sql, $db_forum_create)) {

                forum_delete($forum_fid);
                return false;
            }
        }

        $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) VALUES('$uid', $forum_fid, 1)";

        if (!$result = @db_query($sql, $db_forum_create)) {

            forum_delete($forum_fid);
            return false;
        }

        return $forum_fid;
    }

    return false;
}

function forum_delete($fid)
{
    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $db_forum_delete = db_connect();

        if (!is_numeric($fid)) return false;

        $sql = "SELECT WEBTAG FROM FORUMS WHERE FID = '$fid'";
        $result = db_query($sql, $db_forum_delete);

        if (db_num_rows($result) > 0) {

            list($webtag) = db_fetch_array($result, DB_RESULT_NUM);

            $sql = "DELETE FROM FORUMS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM GROUP_PERMS WHERE FORUM = '$fid'";
            $result_remove = db_query($sql, $db_forum_delete);

            $sql = "SELECT GID FROM GROUPS WHERE FORUM = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            while($user_perms = db_fetch_array($result)) {

                $sql = "DELETE FROM GROUP_USERS WHERE GID = '{$user_perms['GID']}'";
                $result_remove = db_query($sql, $db_forum_delete);
            }

            $sql = "DELETE FROM GROUPS WHERE FORUM = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM USER_FORUM WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM VISITOR_LOG WHERE FORUM = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM SEARCH_RESULTS WHERE FORUM = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "SELECT AID FROM POST_ATTACHMENT_IDS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            while ($row = db_fetch_array($result)) {
                delete_attachment_by_aid($row['AID']);
            }

            $sql = "DELETE FROM POST_ATTACHMENT_IDS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            forum_delete_tables($webtag);
        }
    }
}

function forum_delete_tables($webtag)
{
    // Only the queen can delete forums!!

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $db_forum_delete_tables = db_connect();

        $table_array = array('ADMIN_LOG',       'BANNED',        'FILTER_LIST',
                             'FOLDER',          'FORUM_LINKS',   'GROUPS',
                             'GROUP_PERMS',     'GROUP_USERS',   'LINKS',
                             'LINKS_COMMENT',   'LINKS_FOLDERS', 'LINKS_VOTE',
                             'POLL',            'POLL_VOTES',    'POST',
                             'POST_CONTENT',    'PROFILE_ITEM',  'PROFILE_SECTION',
                             'RSS_FEEDS',       'RSS_HISTORY',   'STATS',
                             'THREAD',          'THREAD_STATS',  'THREAD_TRACK',
                             'USER_TRACK',      'USER_FOLDER',   'USER_PEER',
                             'USER_POLL_VOTES', 'USER_PREFS',    'USER_PROFILE',
                             'USER_SIG',        'USER_THREAD',   'VISITOR_LOG');

        foreach ($table_array as $table_name) {

            $sql = "DROP TABLE IF EXISTS {$webtag}_{$table_name}";
            $result = db_query($sql, $db_forum_delete_tables);
        }
    }

    return false;
}

function forum_update_access($fid, $access, $passwd = false)
{
    if (!is_numeric($fid)) return false;
    if (!is_numeric($access)) return false;

    // Only the queen can change a forums status!!

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        if (($uid = bh_session_get_value('UID')) === false) return false;

        $db_forum_update_access = db_connect();

        $sql = "SELECT FID FROM FORUMS WHERE FID = '$fid' LIMIT 0, 1";
        $result = db_query($sql, $db_forum_update_access);

        if (db_num_rows($result) > 0) {

            if ($passwd) {

                $passwd = md5($passwd);

                $sql = "UPDATE FORUMS SET ACCESS_LEVEL = '$access', ";
                $sql.= "FORUM_PASSWD = '$passwd' WHERE FID = '$fid'";

            }else {

                $sql = "UPDATE FORUMS SET ACCESS_LEVEL = '$access' ";
                $sql.= "WHERE FID = '$fid'";
            }

            $result = db_query($sql, $db_forum_update_access);

            $sql = "SELECT UID FROM USER_FORUM WHERE FID = '$fid' AND UID = '$uid' LIMIT 0, 1";
            $result = db_query($sql, $db_forum_update_access);

            if (db_num_rows($result) > 0) {

                $sql = "UPDATE USER_FORUM SET ALLOWED = 1 WHERE UID = '$uid' AND FID = '$fid'";
                $result = db_query($sql, $db_forum_update_access);

            }else {

                $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) ";
                $sql.= "VALUES ('$uid', '$fid', '1')";

                $result = db_query($sql, $db_forum_update_access);
            }
        }

        return $result;
    }

    return false;
}

function forum_get($fid)
{
    if (!is_numeric($fid)) return false;

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $db_forum_get = db_connect();

        $sql = "SELECT * FROM FORUMS WHERE FID = $fid";
        $result = db_query($sql, $db_forum_get);

        if (db_num_rows($result) > 0) {

            $forum_get_array = db_fetch_array($result);
            $forum_get_array['FORUM_SETTINGS'] = array();

            $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_get);

            while ($row = db_fetch_array($result)) {
                $forum_get_array['FORUM_SETTINGS'][$row['SNAME']] = $row['SVALUE'];
            }

            return $forum_get_array;
        }
    }

    return false;
}

function forum_get_permissions($fid)
{
    if (!is_numeric($fid)) return false;

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $db_forum_get_permissions = db_connect();

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM USER USER ";
        $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID) ";
        $sql.= "WHERE USER_FORUM.FID = '$fid' AND USER_FORUM.ALLOWED = 1";

        $result = db_query($sql, $db_forum_get_permissions);

        if (db_num_rows($result) > 0) {

            $forum_get_permissions_array = array();

            while($row = db_fetch_array($result)) {
                $forum_get_permissions_array[] = $row;
            }

            return $forum_get_permissions_array;
        }
    }

    return false;
}

function forum_update_default($fid)
{
    if (!is_numeric($fid)) return false;

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $db_forum_get_permissions = db_connect();

        $sql = "UPDATE FORUMS SET DEFAULT_FORUM = 0";
        $result = db_query($sql, $db_forum_get_permissions);

        if ($fid > 0) {

            $sql = "UPDATE FORUMS SET DEFAULT_FORUM = 1 WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_get_permissions);
        }

        return $result;
    }

    return false;
}

function forum_get_post_count($webtag)
{
    $db_forum_get_post_count = db_connect();

    if (!preg_match("/[^a-z|0-9|'_']/", $webtag)) return 0;

    $sql = "SELECT COUNT(PID) AS POST_COUNT FROM {$webtag}_POST POST ";
    $result_post_count = db_query($sql, $db_forum_get_post_count);

    if (db_num_rows($result_post_count) > 0) {

        $row = db_fetch_array($result_post_count);
        return $row['POST_COUNT'];
    }

    return 0;
}

function forum_search($search_string)
{
    $fid_array = array();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $lang = load_language_file();

    if (strlen(trim($search_string)) > 0) {

        $search_string = str_replace("%", "", $search_string);

        $keywords_array = explode(" ", $search_string);

        foreach($keywords_array as $key => $value) {
            $keywords_array[$key] = addslashes($value);
        }

        $search_webtag = implode("%' OR FORUMS.WEBTAG LIKE '%", $keywords_array);
        $search_svalue = implode("%' OR FORUM_SETTINGS.SVALUE LIKE '%", $keywords_array);

        $db_forum_search = db_connect();

        $forum_search_array = array();

        $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL FROM FORUMS ";
        $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID) ";
        $sql.= "WHERE (FORUMS.ACCESS_LEVEL = 0 OR FORUMS.ACCESS_LEVEL = 2  OR (FORUMS.ACCESS_LEVEL = 1 ";
        $sql.= "AND USER_FORUM.ALLOWED = 1)) AND (FORUMS.WEBTAG LIKE '%$search_webtag%' ";
        $sql.= "OR FORUM_SETTINGS.SVALUE LIKE '%$search_svalue%') ";
        $sql.= "GROUP BY FORUMS.FID";

        $result_forums = db_query($sql, $db_forum_search);

        if (db_num_rows($result_forums) > 0) {

            while ($forum_data = db_fetch_array($result_forums)) {

                $forum_fid = $forum_data['FID'];

                $forum_settings = forum_get_settings_by_fid($forum_fid);

                foreach($forum_settings as $key => $value) {
                    if (!isset($forum_data[strtoupper($key)])) {
                        $forum_data[strtoupper($key)] = $value;
                    }
                }

                if (!isset($forum_data['FORUM_NAME'])) {
                    $forum_data['FORUM_NAME'] = "A Beehive Forum";
                }

                if (!isset($forum_data['FORUM_DESC'])) {
                    $forum_data['FORUM_DESC'] = "";
                }

                // Get any unread messages

                $folders = folder_get_available_by_forum($forum_fid);

                $user_ignored = USER_IGNORED;
                $user_ignored_completely = USER_IGNORED_COMPLETELY;

                $sql = "SELECT SUM(THREAD.LENGTH) - SUM(USER_THREAD.LAST_READ) ";
                $sql.= "AS UNREAD_MESSAGES, SUM(THREAD.LENGTH) AS NUM_MESSAGES ";
                $sql.= "FROM {$forum_data['WEBTAG']}_THREAD THREAD ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ";
                $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_FOLDER USER_FOLDER ON ";
                $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_PEER USER_PEER ON ";
                $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
                $sql.= "WHERE THREAD.FID IN ($folders) ";
                $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
                $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
                $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
                $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
                $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
                $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1)";

                $result_post_count = db_query($sql, $db_forum_search);

                $row = db_fetch_array($result_post_count);

                if (!isset($row['NUM_MESSAGES']) || is_null($row['NUM_MESSAGES'])) {
                    $forum_data['NUM_MESSAGES'] = 0;
                }else {
                    $forum_data['NUM_MESSAGES'] = $row['NUM_MESSAGES'];
                }

                if (!isset($row['UNREAD_MESSAGES']) || is_null($row['UNREAD_MESSAGES'])) {
                    $forum_data['UNREAD_MESSAGES'] = 0;
                }else {
                    $forum_data['UNREAD_MESSAGES'] = $row['UNREAD_MESSAGES'];
                }

                // Get unread to me message count

                $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME FROM ";
                $sql.= "{$forum_data['WEBTAG']}_POST POST ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_PEER USER_PEER ON ";
                $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = POST.FROM_UID) ";
                $sql.= "WHERE POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
                $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
                $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
                $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
                $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";

                $result_unread_to_me = db_query($sql, $db_forum_search);

                $row = db_fetch_array($result_unread_to_me);

                if (!isset($row['UNREAD_TO_ME']) || is_null($row['UNREAD_TO_ME'])) {
                    $forum_data['UNREAD_TO_ME'] = 0;
                }else {
                    $forum_data['UNREAD_TO_ME'] = $row['UNREAD_TO_ME'];
                }

                // Get Last Visited

                $sql = "SELECT UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG ";
                $sql.= "WHERE UID = '$uid' AND FORUM = $forum_fid ";
                $sql.= "AND LAST_LOGON IS NOT NULL AND LAST_LOGON > 0";

                $result_last_visit = db_query($sql, $db_forum_search);

                $row = db_fetch_array($result_last_visit);

                if (!isset($row['LAST_LOGON']) || is_null($row['LAST_LOGON'])) {
                    $forum_data['LAST_LOGON'] = 0;
                }else {
                    $forum_data['LAST_LOGON'] = $row['LAST_LOGON'];
                }

                $forum_search_array[$forum_data['FID']] = $forum_data;
            }

            return $forum_search_array;
        }
    }

    return false;
}

function forum_get_all_webtags()
{
    $db_forum_get_all_webtags = db_connect();

    $sql = "SELECT FID, WEBTAG FROM FORUMS";
    $result = db_query($sql, $db_forum_get_all_webtags);

    if (db_num_rows($result) > 0) {

        $webtags = array();

        while ($row = db_fetch_array($result)) {
            $webtags[$row['FID']] = $row['WEBTAG'];
        }

        return $webtags;
    }

    return false;
}

function forum_get_all_fids()
{
    $db_forum_get_all_fids = db_connect();

    $sql = "SELECT FID FROM FORUMS";
    $result = db_query($sql, $db_forum_get_all_fids);

    if (db_num_rows($result) > 0) {

        $fids_array = array();

        while ($row = db_fetch_array($result)) {
            $fids_array[] = $row['FID'];
        }

        return $fids_array;
    }

    return false;
}

?>
