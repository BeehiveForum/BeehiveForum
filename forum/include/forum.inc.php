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

/* $Id: forum.inc.php,v 1.115 2005-03-06 23:36:41 decoyduck Exp $ */

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");

function get_table_prefix()
{
    static $forum_data = false;

    if (!$forum_data) {

        $db_get_table_prefix = db_connect();

        if (!$uid = bh_session_get_value('UID')) $uid = 0;

        if (isset($_GET['webtag']) && strlen(trim(_stripslashes($_GET['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_GET['webtag']));
        }else if (isset($_POST['webtag']) && strlen(trim(_stripslashes($_POST['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_POST['webtag']));
        }else {
            $webtag = false;
        }

        if (!is_bool($webtag)) {

            // Check #1: See if the webtag specified in GET/POST
            // actually exists.

            $sql = "SELECT FID, WEBTAG, CONCAT(WEBTAG, '', '_') AS PREFIX, ACCESS_LEVEL FROM FORUMS ";
            $sql.= "WHERE WEBTAG = '$webtag'";

            $result = db_query($sql, $db_get_table_prefix);

            if (db_num_rows($result) > 0) {
                $forum_data = db_fetch_array($result);
                forum_check_password($forum_data);
                return $forum_data;
            }
        }

        if (is_bool($webtag)) {

            // Check #2: Try and select a default webtag from
            // the databse

            $sql = "SELECT FID, WEBTAG, CONCAT(WEBTAG, '', '_') AS PREFIX, ACCESS_LEVEL FROM FORUMS ";
            $sql.= "WHERE DEFAULT_FORUM = 1";

            $result = db_query($sql, $db_get_table_prefix);

            if (db_num_rows($result) > 0) {
                $forum_data = db_fetch_array($result);
                forum_check_password($forum_data);
                return $forum_data;
            }
        }

        return false;
    }

    return $forum_data;
}

function get_webtag(&$webtag_search)
{
    static $webtag_data = false;

    if (!$webtag_data) {

        $db_get_webtag = db_connect();

        if (!$uid = bh_session_get_value('UID')) $uid = 0;

        if (isset($_GET['webtag']) && strlen(trim(_stripslashes($_GET['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_GET['webtag']));
        }else if (isset($_POST['webtag']) && strlen(trim(_stripslashes($_POST['webtag']))) > 0) {
            $webtag = trim(_stripslashes($_POST['webtag']));
        }else {
            $webtag = false;
        }

        if (!is_bool($webtag)) {

            // Check #1: See if the webtag specified in GET/POST
            // actually exists.

            $sql = "SELECT FID, WEBTAG, CONCAT(WEBTAG, '', '_') AS PREFIX, ACCESS_LEVEL FROM FORUMS ";
            $sql.= "WHERE WEBTAG = '$webtag'";

            $result = db_query($sql, $db_get_webtag);

            if (db_num_rows($result) > 0) {

                $webtag_data = db_fetch_array($result);
                forum_check_password($webtag_data);
                return $webtag_data['WEBTAG'];
            }
        }

        if (is_bool($webtag)) {

            // Check #2: Try and select a default webtag from
            // the databse

            $sql = "SELECT FID, WEBTAG, CONCAT(WEBTAG, '', '_') AS PREFIX, ACCESS_LEVEL FROM FORUMS ";
            $sql.= "WHERE DEFAULT_FORUM = 1";

            $result = db_query($sql, $db_get_webtag);

            if (db_num_rows($result) > 0) {

                $webtag_data = db_fetch_array($result);
                forum_check_password($webtag_data);
                return $webtag_data['WEBTAG'];
            }
        }

        $webtag_search = $webtag;
        return false;
    }

    return $webtag_data['WEBTAG'];
}

function forum_check_access_level()
{
    $db_forum_check_access_level = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(FORUMS.FID) AS FID_COUNT FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID) ";
    $sql.= "WHERE (FORUMS.ACCESS_LEVEL IN (0, 2) ";
    $sql.= "OR (FORUMS.ACCESS_LEVEL = 1 AND USER_FORUM.ALLOWED = 1 ";
    $sql.= "AND USER_FORUM.UID = $uid)) AND FORUMS.FID = '{$table_data['FID']}'";

    $result = db_query($sql, $db_forum_check_access_level);
    list($fid_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($fid_count > 0);
}

function forum_check_password($forum_data)
{
    $db_forum_check_password = db_connect();

    $page_array = array('forums.php', 'index.php', 'logon.php', 'nav.php', 'register.php');

    if (isset($forum_data['ACCESS_LEVEL']) && $forum_data['ACCESS_LEVEL'] == 2) {

        if (isset($_COOKIE["bh_{$forum_data['WEBTAG']}_password"])) {

            $passwd = md5($_COOKIE["bh_{$forum_data['WEBTAG']}_password"]);

            $sql = "SELECT * FROM FORUMS WHERE FID = '{$forum_data['FID']}' ";
            $sql.= "AND ACCESS_LEVEL = 2 AND FORUM_PASSWD = '$passwd'";

            $result = db_query($sql, $db_forum_check_password);

            if (db_num_rows($result) > 0) return true;
        }

        if (in_array(basename($_SERVER['PHP_SELF']), $page_array)) return true;
        if (preg_match("/^admin[a-z_]*\.php$/", basename($_SERVER['PHP_SELF']))) return true;

        $lang = load_language_file();

        html_draw_top();

        echo "<h1>{$lang['passwdprotectedforum']}</h1>\n";
        echo "<p>{$lang['passwdprotectedwarning']}</p>\n";
        echo "<div align=\"center\">\n";
        echo "<form method=\"post\" action=\"./forum_password.php\" target=\"_top\">\n";
        echo "  ", form_input_hidden('webtag', $forum_data['WEBTAG']), "\n";
        echo "  ", form_input_hidden('ret', get_request_uri()), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['enterpasswd']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>{$lang['passwd']}</td>\n";
        echo "                  <td>", form_input_password('forum_password', '', 32), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                  <td>", form_checkbox('remember_password', 'Y', $lang['rememberpassword'], false), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td colspan=\"2\">&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }

    return true;
}

function get_forum_settings()
{
    static $get_forum_settings = false;

    $forum_settings = array();
    $default_forum_settings = array();

    if (!$get_forum_settings) {

        $db_get_forum_settings = db_connect();

        $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '0'";
        $result = db_query($sql, $db_get_forum_settings);

        while ($row = db_fetch_array($result)) {
            $default_forum_settings[$row['SNAME']] = $row['SVALUE'];
            $get_forum_settings = true;
        }

        if ($table_data = get_table_prefix()) {

            $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '{$table_data['FID']}'";
            $result = db_query($sql, $db_get_forum_settings);

            while ($row = db_fetch_array($result)) {
                $forum_settings[$row['SNAME']] = $row['SVALUE'];
                $get_forum_settings = true;
            }
        }
    }

    return array_merge($default_forum_settings, $forum_settings);
}

function get_default_forum_settings()
{
    $db_get_forum_settings = db_connect();

    $default_forum_settings = array();

    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '0'";
    $result = db_query($sql, $db_get_forum_settings);

    while ($row = db_fetch_array($result)) {
        $default_forum_settings[$row['SNAME']] = $row['SVALUE'];
        $get_forum_settings = true;
    }

    return $default_forum_settings;
}

function save_forum_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    $db_save_forum_settings = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = '{$table_data['FID']}'";
    $result = db_query($sql, $db_save_forum_settings);

    foreach ($forum_settings_array as $sname => $svalue) {

        $sname = addslashes($sname);
        $svalue = addslashes($svalue);

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql.= "VALUES ('{$table_data['FID']}', '$sname', '$svalue')";

        $result = db_query($sql, $db_save_forum_settings);
    }
}

function save_default_forum_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    $db_save_forum_settings = db_connect();

    $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = 0";
    $result = db_query($sql, $db_save_forum_settings);

    foreach ($forum_settings_array as $sname => $svalue) {

        $sname = addslashes($sname);
        $svalue = addslashes($svalue);

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql.= "VALUES ('0', '$sname', '$svalue')";

        $result = db_query($sql, $db_save_forum_settings);
    }
}

function forum_get_name($fid)
{
    $db_forum_get_name = db_connect();

    if (!is_numeric($fid)) return "Unknown Forum";

    $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
    $sql.= "WHERE SNAME = 'forum_name' AND FID = '$fid'";

    $result = db_query($sql, $db_forum_get_name);

    if (db_num_rows($result) > 0) {

        list($forum_name) = db_fetch_array($result, DB_RESULT_NUM);
        return $forum_name;
    }

    return "Unknown Forum";
}

function forum_get_setting($setting_name, $value = false, $default = false)
{
    global $forum_settings;

    if (isset($forum_settings[$setting_name])) {
        if ($value) {
            if (strtoupper($forum_settings[$setting_name]) == strtoupper($value)) {
                return true;
            }
        }else {
            return $forum_settings[$setting_name];
        }
    }

    return $default;
}

function load_start_page()
{
    $webtag = get_webtag($webtag_search);

    if (@file_exists("./forums/$webtag/start_main.php")) {

        if (@$fp = fopen("./forums/$webtag/start_main.php", "r")) {

            $content = fread($fp, filesize("./forums/$webtag/start_main.php"));
            fclose($fp);
            return $content;
        }
    }

    return false;
}

function save_start_page($content)
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

    $webtag = preg_replace("/[^A-Z0-9-_]/", "", strtoupper($webtag));
    $forum_name = addslashes($forum_name);

    if (!is_numeric($access)) $access = 0;

    // Only the queen can create forums!!

    if (perm_has_forumtools_access()) {

        $uid = bh_session_get_value('UID');

        $db_forum_create = db_connect();

        $sql = "SELECT FID FROM FORUMS WHERE WEBTAG = '$webtag'";
        if (!$result = db_query($sql, $db_forum_create)) return false;

        if (db_num_rows($result) > 0) {
            return false;
        }

        // Beehive Table Names

        $table_array = array('ADMIN_LOG', 'BANNED', 'FILTER_LIST',
                             'FOLDER', 'FORUM_LINKS', 'LINKS',
                             'LINKS_COMMENT', 'LINKS_FOLDERS', 'LINKS_VOTE',
                             'POLL', 'POLL_VOTES', 'POST',
                             'POST_CONTENT', 'PROFILE_ITEM', 'PROFILE_SECTION',
                             'STATS', 'THREAD', 'USER_FOLDER',
                             'USER_PEER', 'USER_POLL_VOTES', 'USER_PREFS',
                             'USER_PROFILE', 'USER_SIG', 'USER_THREAD');

        // Check to see if any of the Beehive tables already exist.
        // If they do then something is wrong and we should error out.

        foreach ($table_array as $table_name) {

            $sql = "SHOW TABLES LIKE '{$webtag}_{$table_name}'";

            if (!$result = db_query($sql, $db_forum_create)) return false;

            if (db_num_rows($result) > 0) return false;
        }

        // Create ADMIN_LOG table

        $sql = "CREATE TABLE {$webtag}_ADMIN_LOG (";
        $sql.= "  LOG_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  LOG_TIME DATETIME DEFAULT NULL,";
        $sql.= "  ADMIN_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (LOG_ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create BANNED table

        $sql = "CREATE TABLE {$webtag}_BANNED (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  IPADDRESS CHAR(15) NOT NULL DEFAULT '',";
        $sql.= "  LOGON VARCHAR(32) DEFAULT NULL,";
        $sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL,";
        $sql.= "  EMAIL VARCHAR(80) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create FILTER_LIST table

        $sql = "CREATE TABLE {$webtag}_FILTER_LIST (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY (ID, UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create FOLDER table

        $sql = "CREATE TABLE {$webtag}_FOLDER (";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TITLE VARCHAR(32) DEFAULT NULL,";
        $sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL,";
        $sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create FORUM_LINKS table

        $sql = "CREATE TABLE {$webtag}_FORUM_LINKS (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  POS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  URI VARCHAR(255) DEFAULT NULL,";
        $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (LID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create LINKS table

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
        $sql.= "  PRIMARY KEY  (LID),";
        $sql.= "  KEY FID (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create LINKS_COMMENT table

        $sql = "CREATE TABLE {$webtag}_LINKS_COMMENT (";
        $sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  COMMENT TEXT NOT NULL,";
        $sql.= "  PRIMARY KEY  (CID),";
        $sql.= "  KEY LID (LID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create LINKS_FOLDERS table

        $sql = "CREATE TABLE {$webtag}_LINKS_FOLDERS (";
        $sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1',";
        $sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create LINKS_VOTE table

        $sql = "CREATE TABLE {$webtag}_LINKS_VOTE (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (LID,UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create POLL table

        $sql = "CREATE TABLE {$webtag}_POLL (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CLOSES DATETIME DEFAULT NULL,";
        $sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
        $sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create POLL_VOTES table

        $sql = "CREATE TABLE {$webtag}_POLL_VOTES (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID, OPTION_ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create POST table

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
        $sql.= "  PRIMARY KEY  (TID, PID),";
        $sql.= "  KEY TO_UID (TO_UID),";
        $sql.= "  KEY IPADDRESS (IPADDRESS)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create POST_CONTENT table

        $sql = "CREATE TABLE {$webtag}_POST_CONTENT (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create PROFILE_ITEM table

        $sql = "CREATE TABLE {$webtag}_PROFILE_ITEM (";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PIID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create PROFILE_SECTION table

        $sql = "CREATE TABLE {$webtag}_PROFILE_SECTION (";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PSID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create STATS table

        $sql = "CREATE TABLE {$webtag}_STATS (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create THREAD table

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
        $sql.= "  PRIMARY KEY (TID),";
        $sql.= "  KEY FID (FID),";
        $sql.= "  KEY BY_UID (BY_UID),";
        $sql.= "  FULLTEXT KEY TITLE (TITLE)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_FOLDER table

        $sql = "CREATE TABLE {$webtag}_USER_FOLDER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (UID,FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_PEER table

        $sql = "CREATE TABLE {$webtag}_USER_PEER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PEER_UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_POLL_VOTES table

        $sql = "CREATE TABLE {$webtag}_USER_POLL_VOTES (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_PREFS table

        $sql = "CREATE TABLE {$webtag}_USER_PREFS (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  POSTS_PER_PAGE CHAR(3) NOT NULL DEFAULT '20',";
        $sql.= "  FONT_SIZE CHAR(2) NOT NULL DEFAULT '10',";
        $sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  START_PAGE CHAR(1) NOT NULL DEFAULT '0',";
        $sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
        $sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  SHOW_THUMBS CHAR(2) NOT NULL DEFAULT '2',";
        $sql.= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_PROFILE table

        $sql = "CREATE TABLE {$webtag}_USER_PROFILE (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PIID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_SIG table

        $sql = "CREATE TABLE {$webtag}_USER_SIG (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  HTML CHAR(1) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create USER_THREAD table

        $sql = "CREATE TABLE {$webtag}_USER_THREAD (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
        $sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create VISITOR_LOG table

        $sql = "CREATE TABLE {$webtag}_VISITOR_LOG (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Save Webtag

        $sql = "INSERT INTO FORUMS (WEBTAG, ACCESS_LEVEL) VALUES ('$webtag', $access)";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Get the new FID so we can save the settings

        $forum_fid = db_insert_id($db_forum_create);

        // Create General Folder

        $sql = "INSERT INTO {$webtag}_FOLDER (TITLE, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
        $sql.= "VALUES ('General', NULL, NULL, 0)";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Add some default forum links

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (1, 'Forum Links:', NULL)";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Project Beehive Home', 'http://www.beehiveforum.net/')";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $sql = "INSERT INTO {$webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Teh Forum', 'http://www.tehforum.net/forum/')";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create folder permissions

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES (0, '$forum_fid', 0, 14588);";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create user permissions (current user)

        $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
        $sql.= "VALUES ('$forum_fid', NULL, NULL, 1);";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $new_gid = db_insert_id($db_forum_create);

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '$forum_fid', 0, 1792);";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $sql = "INSERT INTO GROUP_USERS VALUES ($new_gid, $uid);";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '$forum_fid', 1, 6652);";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Create Top Level Links Folder

        $sql = "INSERT INTO {$webtag}_LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y')";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        // Store Forum Name

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES ('$forum_fid', 'forum_name', '$forum_name')";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) VALUES('$uid', '$forum_fid', 1)";

        if (!$result = db_query($sql, $db_forum_create)) return false;

        return $forum_fid;
    }

    return false;
}

function forum_delete($fid)
{
    // Only the queen can delete forums!!

    if (perm_has_forumtools_access()) {

        $db_forum_delete = db_connect();

        if (!is_numeric($fid)) return false;

        $sql = "SELECT WEBTAG FROM FORUMS WHERE FID = '$fid'";
        $result = db_query($sql, $db_forum_delete);

        if (db_num_rows($result) > 0) {

            $forum_data = db_fetch_array($result);

            $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "DELETE FROM FORUMS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            $sql = "SELECT AID FROM POST_ATTACHMENT_IDS WHERE FID = '$fid'";
            $result = db_query($sql, $db_forum_delete);

            while ($row = db_fetch_array($result)) {

                delete_attachment_by_aid($row['AID']);
            }

            $table_array = array('ADMIN_LOG', 'BANNED', 'FILTER_LIST',
                                 'FOLDER', 'FORUM_LINKS', 'GROUPS',
                                 'GROUP_PERMS', 'GROUP_USERS', 'LINKS',
                                 'LINKS_COMMENT', 'LINKS_FOLDERS', 'LINKS_VOTE',
                                 'POLL', 'POLL_VOTES', 'POST',
                                 'POST_CONTENT', 'PROFILE_ITEM', 'PROFILE_SECTION',
                                 'STATS', 'THREAD', 'USER_FOLDER',
                                 'USER_PEER', 'USER_POLL_VOTES', 'USER_PREFS',
                                 'USER_PROFILE', 'USER_SIG', 'USER_THREAD',
                                 'VISITOR_LOG');

            foreach ($table_array as $table_name) {

                $sql = "DROP TABLE IF EXISTS {$forum_data['WEBTAG']}_{$table_name}";
                $result = db_query($sql, $db_forum_delete);
            }
        }
    }

    return false;
}

function forum_update_access($fid, $access, $passwd = false)
{
    if (!is_numeric($fid)) return false;
    if (!is_numeric($access)) return false;

    // Only the queen can change a forums status!!

    if (perm_has_forumtools_access()) {

        $uid = bh_session_get_value('UID');

        $db_forum_update_access = db_connect();

        $sql = "SELECT COUNT(*) FROM FORUMS WHERE FID = '$fid'";
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

            $sql = "SELECT * FROM USER_FORUM WHERE FID = '$fid' AND UID = '$uid'";
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

    if (perm_has_forumtools_access()) {

        $db_forum_get = db_connect();

        $sql = "SELECT * FROM FORUMS WHERE FID = '$fid'";
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

    if (perm_has_forumtools_access()) {

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

    if (perm_has_forumtools_access()) {

        $db_forum_get_permissions = db_connect();

        $sql = "UPDATE FORUMS SET DEFAULT_FORUM = 0 WHERE DEFAULT_FORUM = 1";
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

    $sql = "SELECT COUNT(*) AS POST_COUNT FROM {$webtag}_POST POST ";
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

    $uid = bh_session_get_value('UID');

    $lang = load_language_file();

    if (strlen(trim($search_string)) > 0) {

        $keywords_array = explode(" ", $search_string);

        foreach($keywords_array as $key => $value) {
            $keywords_array[$key] = addslashes($value);
        }

        $db_forum_search = db_connect();
        $forum_search_array = array();

        $sql = "SELECT FORUMS.* FROM FORUMS ";
        $sql.= "LEFT JOIN USER_FORUM USER_FORUM ";
        $sql.= "ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ";
        $sql.= "ON (FORUM_SETTINGS.FID = FORUMS.FID) ";
        $sql.= "WHERE (FORUMS.ACCESS_LEVEL = 0 OR FORUMS.ACCESS_LEVEL = 2 ";
        $sql.= "OR (FORUMS.ACCESS_LEVEL = 1 AND USER_FORUM.ALLOWED = 1)) ";
        $sql.= "AND (FORUMS.WEBTAG LIKE '%";
        $sql.= implode("%' OR FORUMS.WEBTAG LIKE '%", $keywords_array);
        $sql.= "%' OR FORUM_SETTINGS.SVALUE LIKE '%";
        $sql.= implode("%' OR FORUM_SETTINGS.SVALUE LIKE '%", $keywords_array);
        $sql.= "%')";

        $result = db_query($sql, $db_forum_search);

        if (db_num_rows($result) > 0) {

            while ($forum_data = db_fetch_array($result)) {

                $forum_data['FORUM_NAME'] = $lang['unnamedforum'];
                $forum_data['DESCRIPTION'] = "";

                $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS ";
                $sql.= "WHERE FID = '{$forum_data['FID']}' ";
                $sql.= "AND (SNAME = 'forum_name' OR ";
                $sql.= "SNAME = 'forum_desc')";

                $result_forum_settings = db_query($sql, $db_forum_search);

                if (db_num_rows($result_forum_settings) > 0) {

                    while ($row = db_fetch_array($result_forum_settings)) {

                        if ($row['SNAME'] == 'forum_name') {

                            $forum_data['FORUM_NAME'] = $row['SVALUE'];

                        }elseif ($row['SNAME'] == 'forum_desc') {

                            $forum_data['DESCRIPTION'] = $row['SVALUE'];
                        }
                    }
                }

                // Make sure the Forum Interest Level is set.

                if (!isset($forum_data['INTEREST'])) {
                    $forum_data['INTEREST'] = 0;
                }

                // Get any unread messages

                $folders = folder_get_available();

                $sql = "SELECT SUM(THREAD.LENGTH - USER_THREAD.LAST_READ) AS UNREAD_MESSAGES FROM ";
                $sql.= "{$forum_data['WEBTAG']}_THREAD THREAD ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ";
                $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
                $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_FOLDER USER_FOLDER ON ";
                $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
                $sql.= "WHERE THREAD.FID IN ($folders) ";
                $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
                $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
                $sql.= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";

                $result_post_count = db_query($sql, $db_forum_search);

                $row = db_fetch_array($result_post_count);
                $forum_data['UNREAD_MESSAGES'] = is_null($row['UNREAD_MESSAGES']) ? 0 : $row['UNREAD_MESSAGES'];

                // Get unread to me message count

                $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME FROM ";
                $sql.= "{$forum_data['WEBTAG']}_POST POST ";
                $sql.= "WHERE POST.TO_UID = '$uid' AND POST.VIEWED IS NULL";

                $result_unread_to_me = db_query($sql, $db_forum_search);

                $row = db_fetch_array($result_unread_to_me);
                $forum_data['UNREAD_TO_ME'] = $row['UNREAD_TO_ME'];

                // Get Last Visited

                $sql = "SELECT UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
                $sql.= "FROM {$forum_data['WEBTAG']}_VISITOR_LOG ";
                $sql.= "WHERE UID = '$uid' AND LAST_LOGON IS NOT NULL ";
                $sql.= "AND LAST_LOGON > 0";

                $result_last_visit = db_query($sql, $db_forum_search);

                if (db_num_rows($result_last_visit) > 0) {

                    $row = db_fetch_array($result_last_visit);
                    $forum_data['LAST_LOGON'] = $row['LAST_LOGON'];

                }else{

                    $forum_data['LAST_LOGON'] = 0;
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

?>
