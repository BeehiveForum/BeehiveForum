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

/* $Id: forum.inc.php,v 1.78 2004-08-15 16:23:07 hodcroftcj Exp $ */

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

        if (isset($_GET['webtag'])) {
            $webtag = trim($_GET['webtag']);
        }else if (isset($_POST['webtag'])) {
            $webtag = trim($_POST['webtag']);
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

        if (isset($_GET['webtag']) && strlen(trim($_GET['webtag'])) > 0) {
            $webtag = trim($_GET['webtag']);
        }else if (isset($_POST['webtag']) && strlen(trim($_POST['webtag'])) > 0) {
            $webtag = trim($_POST['webtag']);
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

    $table_data = get_table_prefix();

    $sql = "SELECT F.FID, F.WEBTAG, CONCAT(F.WEBTAG, '', '_') AS PREFIX, F.ACCESS_LEVEL FROM FORUMS F ";
    $sql.= "LEFT JOIN USER_FORUM UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
    $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR F.ACCESS_LEVEL = 2 ";
    $sql.= "OR (F.ACCESS_LEVEL = 1 AND UF.ALLOWED = 1))";
    $sql.= "AND F.WEBTAG = '{$table_data['WEBTAG']}'";

    $result = db_query($sql, $db_forum_check_access_level);

    return (db_num_rows($result) > 0);
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
    global $default_settings;

    static $get_forum_settings = false;

    $forum_settings = array();

    if (!$get_forum_settings) {

        $db_get_forum_settings = db_connect();

        if (!$table_data = get_table_prefix()) $table_data['FID'] = 0;

        $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '{$table_data['FID']}'";
        $result = db_query($sql, $db_get_forum_settings);

        while ($row = db_fetch_array($result)) {
            $forum_settings[$row['SNAME']] = $row['SVALUE'];
            $get_forum_settings = true;
        }
    }

    return array_merge($default_settings, $forum_settings);
}

function save_forum_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    $db_save_forum_settings = db_connect();

    if (!$table_data = get_table_prefix()) $table_data['FID'] = 0;

    foreach ($forum_settings_array as $sname => $svalue) {

        $sname = addslashes($sname);
        $svalue = addslashes($svalue);

        $sql = "SELECT FID FROM FORUM_SETTINGS WHERE ";
        $sql.= "SNAME = '$sname' AND FID = '{$table_data['FID']}'";

        $result = db_query($sql, $db_save_forum_settings);

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE FORUM_SETTINGS SET SVALUE = '$svalue' ";
            $sql.= "WHERE SNAME = '$sname' AND FID = '{$table_data['FID']}'";

        }else {

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql.= "VALUES ('{$table_data['FID']}', '$sname', '$svalue')";
        }

        $result = db_query($sql, $db_save_forum_settings);
    }
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
            return _stripslashes($forum_settings[$setting_name]);
        }
    }

    return $default;
}

function load_start_page()
{
    $webtag = get_webtag($webtag_search);

    if (@file_exists("forums/$webtag/start_main.php")) {

        $content = implode("\n", file("forums/$webtag/start_main.php"));
        return $content;
    }

    return false;
}

function save_start_page($content)
{
    $webtag = get_webtag($webtag_search);

    if (!is_dir("forums")) mkdir("forums", 0755);
    if (!is_dir("forums/$webtag")) mkdir("forums/$webtag", 0755);

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
        $result = db_query($sql, $db_forum_create);

        if (db_num_rows($result) > 0) {
            return false;
        }

        // Beehive Table Names

        $table_array = array('ADMIN_LOG', 'BANNED_IP', 'DEDUPE',
                             'FILTER_LIST', 'FOLDER', 'LINKS',
                             'LINKS_COMMENT', 'LINKS_FOLDERS', 'LINKS_VOTE',
                             'PM', 'PM_ATTACHMENT_IDS', 'PM_CONTENT',
                             'POLL', 'POLL_VOTES', 'POST',
                             'POST_ATTACHMENT_FILES', 'POST_ATTACHMENT_IDS',
                             'POST_CONTENT', 'PROFILE_ITEM', 'PROFILE_SECTION',
                             'STATS', 'THREAD', 'USER_FOLDER',
                             'USER_PEER', 'USER_POLL_VOTES', 'USER_PREFS',
                             'USER_PROFILE', 'USER_SIG', 'USER_THREAD');

        // Check to see if any of the Beehive tables already exist.
        // If they do then something is wrong and we should error out.

        foreach ($table_array as $table_name) {

            $sql = "SHOW TABLES LIKE '{$webtag}_{$table_name}'";
            $result = db_query($sql, $db_forum_create);

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
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create BANNED_IP table

        $sql = "CREATE TABLE {$webtag}_BANNED_IP (";
        $sql.= "  IP CHAR(15) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (IP)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create DEDUPE table

        $sql = "CREATE TABLE {$webtag}_DEDUPE (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  DDKEY CHAR(32) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create FILTER_LIST table

        $sql = "CREATE TABLE {$webtag}_FILTER_LIST (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create FOLDER table

        $sql = "CREATE TABLE {$webtag}_FOLDER (";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TITLE VARCHAR(32) DEFAULT NULL,";
        $sql.= "  ACCESS_LEVEL TINYINT(4) DEFAULT '0',";
        $sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL,";
        $sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

                // Create GROUP_PERMS table

                $sql = "CREATE TABLE {$webtag}_GROUP_PERMS (";
                $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
                $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
                $sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
                $sql.= "  PRIMARY KEY  (GID,FID)";
                $sql.= ")";

                $result = db_query($sql, $db_forum_create);

                // Create GROUP_USERS table

                $sql = "CREATE TABLE {$webtag}_GROUP_USERS (";
                $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
                $sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
                $sql.= "  PRIMARY KEY  (GID,UID)";
                $sql.= ")";

                $result = db_query($sql, $db_forum_create);

                // Create GROUPS table

                $sql = "CREATE TABLE {$webtag}_GROUPS (";
                $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
                $sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
                $sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
                $sql.= "  AUTO_GROUP TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
                $sql.= "  PRIMARY KEY  (GID)";
                $sql.= ")";

                $result = db_query($sql, $db_forum_create);

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
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create LINKS_COMMENT table

        $sql = "CREATE TABLE {$webtag}_LINKS_COMMENT (";
        $sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  COMMENT TEXT NOT NULL,";
        $sql.= "  PRIMARY KEY  (CID),";
        $sql.= "  KEY LID (LID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create LINKS_FOLDERS table

        $sql = "CREATE TABLE {$webtag}_LINKS_FOLDERS (";
        $sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1',";
        $sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (FID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create LINKS_VOTE table

        $sql = "CREATE TABLE {$webtag}_LINKS_VOTE (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (LID,UID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create PM table

        $sql = "CREATE TABLE {$webtag}_PM (";
        $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',";
        $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (MID),";
        $sql.= "  KEY TO_UID (TO_UID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create PM_ATTACHMENT_IDS table

        $sql = "CREATE TABLE {$webtag}_PM_ATTACHMENT_IDS (";
        $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (MID),";
        $sql.= "  KEY AID (AID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create PM_CONTENT table

        $sql = "CREATE TABLE {$webtag}_PM_CONTENT (";
        $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  PRIMARY KEY  (MID),";
        $sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create POLL table

        $sql = "CREATE TABLE {$webtag}_POLL (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CLOSES DATETIME DEFAULT NULL,";
        $sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
        $sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
        $sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create POLL_VOTES table

        $sql = "CREATE TABLE {$webtag}_POLL_VOTES (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (TID,OPTION_ID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

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
        $sql.= "  EDITED DATETIME DEFAULT NULL,";
        $sql.= "  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  KEY TO_UID (TO_UID),";
        $sql.= "  KEY IPADDRESS (IPADDRESS)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create POST_ATTACHMENT_FILES table

        $sql = "CREATE TABLE {$webtag}_POST_ATTACHMENT_FILES (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID),";
        $sql.= "  KEY AID (AID),";
        $sql.= "  KEY HASH (HASH)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create POST_ATTACHMENT_IDS table

        $sql = "CREATE TABLE {$webtag}_POST_ATTACHMENT_IDS (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  KEY AID (AID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create POST_CONTENT table

        $sql = "CREATE TABLE {$webtag}_POST_CONTENT (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create PROFILE_ITEM table

        $sql = "CREATE TABLE {$webtag}_PROFILE_ITEM (";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PIID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create PROFILE_SECTION table

        $sql = "CREATE TABLE {$webtag}_PROFILE_SECTION (";
        $sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
        $sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (PSID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create STATS table

        $sql = "CREATE TABLE {$webtag}_STATS (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create THREAD table

        $sql = "CREATE TABLE {$webtag}_THREAD (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
        $sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL,";
        $sql.= "  MODIFIED DATETIME DEFAULT NULL,";
        $sql.= "  CLOSED DATETIME DEFAULT NULL,";
        $sql.= "  STICKY CHAR(1) DEFAULT NULL,";
        $sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL,";
        $sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (TID),";
        $sql.= "  KEY FID (FID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create USER_FOLDER table

        $sql = "CREATE TABLE {$webtag}_USER_FOLDER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
        $sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (UID,FID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create USER_PEER table

        $sql = "CREATE TABLE {$webtag}_USER_PEER (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PEER_UID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create USER_POLL_VOTES table

        $sql = "CREATE TABLE {$webtag}_USER_POLL_VOTES (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PTUID VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY  (ID,TID,PTUID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

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
		$sql.= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
		$sql.= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
		$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
		$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
		$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT '1',";
		$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
		$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
		$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
		$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
		$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
		$sql.= "  PRIMARY KEY  (UID)";
		$sql.= ")";


        $result = db_query($sql, $db_forum_create);

        // Create USER_PROFILE table

        $sql = "CREATE TABLE {$webtag}_USER_PROFILE (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PIID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create USER_SIG table

        $sql = "CREATE TABLE {$webtag}_USER_SIG (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  HTML CHAR(1) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create USER_THREAD table

        $sql = "CREATE TABLE {$webtag}_USER_THREAD (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
        $sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,TID)";
        $sql.= ") TYPE=MYISAM;";

        $result = db_query($sql, $db_forum_create);

        // Create General Folder

        $sql = "INSERT INTO {$webtag}_FOLDER (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
        $sql.= "VALUES ('General', 0, NULL, NULL, 0)";

        $result = db_query($sql, $db_forum_create);

                // Create default group

                $sql = "INSERT INTO {$webtag}_GROUPS (GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
                $sql.= "VALUES ('Queen', NULL, 0);";
                $result = db_query($sql, $db_forum_create);

        // Create default group permissions

        $sql = "INSERT INTO {$webtag}_GROUP_PERMS VALUES (1, 0, 1536);";
        $result = db_query($sql, $db_forum_create);

                $sql = "INSERT INTO {$webtag}_GROUP_PERMS VALUES (1, 1, 508);";
                $result = db_query($sql, $db_forum_create);

                $sql = "INSERT INTO {$webtag}_GROUP_PERMS VALUES (0, 1, 252);";
                $result = db_query($sql, $db_forum_create);

                // Create default user permissions

                $sql = "INSERT INTO {$webtag}_GROUP_USERS VALUES (1, 1);";
                $result = db_query($sql, $db_forum_create);

                // Create Top Level Links Folder

        $sql = "INSERT INTO {$webtag}_LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y')";
        $result = db_query($sql, $db_forum_create);

        // Save Webtag

        $sql = "INSERT INTO FORUMS (WEBTAG) VALUES ('$webtag')";
        $result = db_query($sql, $db_forum_create);

        // Get the new FID so we can save the settings

        $new_fid = db_insert_id($db_forum_create);

        // Store Forum Name

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES ('$new_fid', 'forum_name', '$forum_name')";
        $result = db_query($sql, $db_forum_create);

        return $new_fid;
    }

    return false;
}

function forum_delete($fid)
{
    // Only the queen can create forums!!

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

            $table_array = array('ADMIN_LOG', 'BANNED_IP', 'DEDUPE',
                                 'FILTER_LIST', 'FOLDER', 'LINKS',
                                 'LINKS_COMMENT', 'LINKS_FOLDERS', 'LINKS_VOTE',
                                 'PM', 'PM_ATTACHMENT_IDS', 'PM_CONTENT',
                                 'POLL', 'POLL_VOTES', 'POST',
                                 'POST_ATTACHMENT_FILES', 'POST_ATTACHMENT_IDS',
                                 'POST_CONTENT', 'PROFILE_ITEM', 'PROFILE_SECTION',
                                 'STATS', 'THREAD', 'USER_FOLDER',
                                 'USER_PEER', 'USER_POLL_VOTES', 'USER_PREFS',
                                 'USER_PROFILE', 'USER_SIG', 'USER_THREAD',
                                 'GROUP_PERMS', 'GROUP_USERS', 'GROUPS');

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

        if (db_num_rows($result)) {

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

function forum_search($search_string)
{
    $uid = bh_session_get_value('UID');

    if (strlen(trim($search_string)) > 0) {

        $keywords_array = explode(" ", $search_string);

        foreach($keywords_array as $key => $value) {
            $keywords_array[$key] = addslashes($value);
        }

        $db_forum_search = db_connect();
        $forum_search_array = array();

        $forum_webtag_sql = "FORUMS.WEBTAG LIKE '%";
        $forum_webtag_sql.= implode("%' OR FORUMS.WEBTAG LIKE '%", $keywords_array);
        $forum_webtag_sql.= "%'";

        $forum_settings_sql = "FORUM_SETTINGS.SVALUE LIKE '%";
        $forum_settings_sql.= implode("%' OR FORUM_SETTINGS.SVALUE LIKE '%", $keywords_array);
        $forum_settings_sql.= "%'";

        $sql = "SELECT DISTINCT FORUMS.FID, FORUMS.WEBTAG FROM FORUM_SETTINGS ";
        $sql.= "LEFT JOIN FORUMS ON (FORUMS.FID = FORUM_SETTINGS.FID) ";
        $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON ";
        $sql.= "(USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "WHERE (FORUMS.ACCESS_LEVEL = 0 OR FORUMS.ACCESS_LEVEL = 2 ";
        $sql.= "OR (FORUMS.ACCESS_LEVEL = 1 AND USER_FORUM.ALLOWED = 1)) ";
        $sql.= "AND $forum_webtag_sql OR (FORUM_SETTINGS.SNAME = 'forum_keywords' ";
        $sql.= "AND ($forum_settings_sql)) OR (FORUM_SETTINGS.SNAME = 'forum_desc' ";
        $sql.= "AND ($forum_settings_sql)) OR (FORUM_SETTINGS.SNAME = 'forum_name' ";
        $sql.= "AND ($forum_settings_sql))";

        $result = db_query($sql, $db_forum_search);

        if (db_num_rows($result) > 0) {

            while ($forum_data = db_fetch_array($result)) {

                if (isset($forum_data['FID']) && isset($forum_data['WEBTAG'])) {

                    $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
                    $sql.= "WHERE SNAME = 'forum_name' AND FID = '{$forum_data['FID']}'";

                    $result_forum_name = db_query($sql, $db_forum_search);

                    if (db_num_rows($result_forum_name)) {

                        $row = db_fetch_array($result_forum_name);
                        $forum_data['FORUM_NAME'] = $row['FORUM_NAME'];

                    }else {

                        $forum_data['FORUM_NAME'] = $lang['unnamedforum'];
                    }

                    $sql = "SELECT COUNT(*) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
                    $result_post_count = db_query($sql, $db_forum_search);

                    if (db_num_rows($result_post_count)) {

                        $row = db_fetch_array($result_post_count);
                        $forum_data['MESSAGES'] = $row['POST_COUNT'];

                    }else {

                        $forum_data['MESSAGES'] = 0;
                    }

                    $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
                    $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
                    $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

                    $result_description = db_query($sql, $db_forum_search);

                    if (db_num_rows($result_description)) {

                        $row = db_fetch_array($result_description);
                        $forum_data['DESCRIPTION'] = $row['SVALUE'];

                    }else{

                       $forum_data['DESCRIPTION'] = "";
                    }

                    $forum_search_array[$forum_data['FID']] = $forum_data;
                }
            }
        }

        return $forum_search_array;
    }

    return false;
}

function forum_get_all_webtags()
{

	$db_forum_get_all_webtags = db_connect();
	$sql = "SELECT FID, WEBTAG FROM FORUMS";
	$result = db_query($sql, $db_forum_get_all_webtags);
	if (db_num_rows($result) > 0) {
	    while ($row = db_fetch_array($result)) {
	        $webtags[$row['FID']] = $row['WEBTAG'];
	    }
	    return $webtags;
    }
    return false;
}

?>
