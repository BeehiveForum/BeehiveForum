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

/* $Id: user.inc.php,v 1.163 2004-04-22 16:55:08 decoyduck Exp $ */

function user_count()
{
   $db_user_count = db_connect();

   if (!$table_data = get_table_prefix()) return 0;

   $sql = "SELECT COUNT(UID) AS COUNT FROM USER ";
   $sql.= "WHERE USER.LOGON <> 'GUEST' AND USER.PASSWD <> MD5('GUEST')";

   $result = db_query($sql, $db_user_count);

   $user_count = db_fetch_array($result);
   return $user_count['COUNT'];
}

function user_exists($logon)
{
    $db_user_exists = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $logon = addslashes($logon);

    $sql = "SELECT uid FROM USER WHERE logon = '$logon'";
    $result = db_query($sql, $db_user_exists);

    return (db_num_rows($result) > 0);
}

function user_create($logon, $password, $nickname, $email)
{
    $logon = addslashes($logon);
    $nickname = addslashes($nickname);
    $email = addslashes($email);
    $md5pass = md5($password);

    if (!$ipaddress = get_ip_address()) {
        $ipaddress = "";
    }

    $sql = "INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL) ";
    $sql.= "VALUES ('$logon', '$md5pass', '$nickname', '$email')";

    $db_user_create = db_connect();
    $result = db_query($sql, $db_user_create);

    if ($result) {
        $new_uid = db_insert_id($db_user_create);
    }else {
        $new_uid = -1;
    }

    return $new_uid;
}

function user_update($uid, $nickname, $email)
{
    $db_user_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $nickname = addslashes(_htmlentities($nickname));
    $email = addslashes(_htmlentities($email));

    $sql = "UPDATE USER SET NICKNAME = '$nickname', ";
    $sql.= "EMAIL = '$email' WHERE UID = $uid";

    return db_query($sql, $db_user_update);
}

function user_change_pw($uid, $password, $hash = false)
{
    $db_user_change_pw = db_connect();

    $password = md5($password);

    if (!$table_data = get_table_prefix()) return false;

    if ($hash) {

        $sql = "UPDATE USER SET PASSWD = '$password' ";
        $sql.= "WHERE UID = '$uid' AND PASSWD = '$hash'";

    }elseif (bh_session_get_value('STATUS') & USER_PERM_SOLDIER) {

        $sql = "UPDATE USER SET PASSWD = '$password' ";
        $sql.= "WHERE UID = '$uid'";
    }

    return db_query($sql, $db_user_change_pw);
}

function user_get_status($uid)
{
    if (!is_numeric($uid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT STATUS FROM USER_STATUS WHERE UID = $uid ";
    $sql.= "AND FID = '{$table_data['FID']}'";

    $db_user_get_status = db_connect();

    $result = db_query($sql, $db_user_get_status);
    list($status) = db_fetch_array($result);

    return $status;
}

function user_update_status($uid, $status)
{
    $db_user_update_status = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($status)) return false;

    $sql = "SELECT UID FROM USER_STATUS ";
    $sql.= "WHERE UID = '$uid' AND FID = '{$table_data['FID']}'";

    $result = db_query($sql, $db_user_update_status);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE USER_STATUS SET STATUS = '$status' ";
        $sql.= "WHERE UID = '$uid' AND FID = '{$table_data['FID']}'";

    }else {

        $sql = "INSERT INTO USER_STATUS (UID, FID, STATUS) ";
        $sql.= "VALUES ('$uid', '{$table_data['FID']}', '$status')";
    }

    return db_query($sql, $db_user_update_status);
}

function user_update_folders($uid, $folders_array)
{
    $db_user_update_folders = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_array($folders_array)) return false;

    foreach ($folders_array as $folder) {

        if (is_numeric($folder['allowed']) && is_numeric($folder['fid'])) {

            $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_FOLDER ";
	    $sql.= "WHERE UID = '$uid' AND FID = '{$folder['fid']}'";

	    $result = db_query($sql, $db_user_update_folders);

	    if (db_num_rows($result) > 0) {

                $sql = "UPDATE {$table_data['PREFIX']}USER_FOLDER SET ALLOWED = '{$folder['allowed']}' ";
                $sql.= "WHERE UID = '$uid' AND FID = '{$folder['fid']}'";

	    }else {

                $sql = "INSERT INTO {$table_data['PREFIX']}USER_FOLDER (UID, FID, ALLOWED) ";
                $sql.= "VALUES ('$uid', '{$folder['fid']}', '{$folder['allowed']}')";
	    }

    	    $result = db_query($sql, $db_user_update_folders);
    	}
    }
}

function user_update_forums($uid, $forums_array)
{
    $db_user_update_forums = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_array($forums_array)) return false;

    foreach ($forums_array as $forum) {

        if (is_numeric($forum['allowed']) && is_numeric($forum['fid'])) {

            $sql = "SELECT UID FROM USER_FORUM ";
	    $sql.= "WHERE UID = '$uid' AND FID = '{$forum['fid']}'";

	    $result = db_query($sql, $db_user_update_forums);

	    if (db_num_rows($result) > 0) {

                $sql = "UPDATE USER_FORUM SET ALLOWED = '{$forum['allowed']}' ";
	        $sql.= "WHERE UID = '$uid' AND FID = '{$forum['fid']}'";

	    }else {

	        $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) ";
		$sql.= "VALUES ('$uid', '{$forum['fid']}', '{$forum['allowed']}')";
	    }

            $result = db_query($sql, $db_user_update_forums);
	}
    }
}

function user_logon($logon, $password, $md5hash = false)
{
    if ($md5hash) {
      $md5pass = addslashes($password);
    }else {
      $md5pass = md5($password);
    }

    $logon = addslashes($logon);

    $table_data = get_table_prefix();

    $sql = "SELECT USER.UID, USER_STATUS.STATUS FROM USER ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON ";
    $sql.= "(USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
    $sql.= "WHERE LOGON = '$logon' AND PASSWD = '$md5pass'";

    $db_user_logon = db_connect();
    $result = db_query($sql, $db_user_logon);

    if (!db_num_rows($result)) {
        $uid = -1;
    }else {

        $fa = db_fetch_array($result);
        $uid = $fa['UID'];

        if (isset($fa['STATUS']) && $fa['STATUS'] & USER_PERM_SPLAT) { // User is banned
            $uid = -2;
        }

        if (!$ipaddress = get_ip_address()) {
            $ipaddress = "";
        }
    }

    return $uid;
}

function user_get($uid, $hash = false)
{
    $db_user_get = db_connect();

    if (!is_numeric($uid)) return false;

    $table_data = get_table_prefix();

    $sql = "SELECT USER.*, USER_STATUS.STATUS FROM USER USER ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID) ";
    $sql.= "WHERE USER.UID = $uid ";

    if ($hash) {
        $hash = addslashes($hash);
        $sql.= "AND PASSWD = '$hash'";
    }

    $result = db_query($sql, $db_user_get);

    if (db_num_rows($result)) {
        $user_get = db_fetch_array($result);
        return $user_get;
    }

    return false;
}

function user_get_logon($uid)
{
    $db_user_get_logon = db_connect();

    if (!is_numeric($uid)) return false;

    $table_data = get_table_prefix();

    $sql = "SELECT LOGON FROM USER WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_logon);

    if(!db_num_rows($result)){
        $logon = "UNKNOWN";
    } else {
        $fa = db_fetch_array($result);
        $logon = $fa['LOGON'];
    }

    return $logon;
}

function user_get_uid($logon)
{
    $db_user_get_uid = db_connect();

    $logon = addslashes($logon);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID, LOGON, NICKNAME FROM USER WHERE LOGON = '$logon'";
    $result = db_query($sql, $db_user_get_uid);

    if (!db_num_rows($result)) {
        return false;
    }else{
        return db_fetch_array($result);
    }

}

function user_get_sig($uid, &$content, &$html)
{
    $db_user_get_sig = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CONTENT, HTML FROM {$table_data['PREFIX']}USER_SIG WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_sig);

    if(!db_num_rows($result)){
        $ret = false;
    } else {
        $fa = db_fetch_array($result);
        $content = $fa['CONTENT'];
        $html = $fa['HTML'];
        $ret = true;
    }

    return $ret;
}

function user_get_prefs($uid)
{
    $db_user_get_prefs = db_connect();

    if (!is_numeric($uid)) return false;

    $prefs_array = array('UID' => '', 'FIRSTNAME' => '', 'LASTNAME' => '', 'DOB' => '', 'HOMEPAGE_URL' => '',
                         'PIC_URL' => '', 'EMAIL_NOTIFY' => '', 'TIMEZONE' => '', 'DL_SAVING' => '',
                         'MARK_AS_OF_INT' => '', 'POSTS_PER_PAGE' => '', 'FONT_SIZE' => '',
                         'STYLE' => '', 'VIEW_SIGS' => '', 'START_PAGE' => '', 'LANGUAGE' => '',
                         'PM_NOTIFY' => '', 'PM_NOTIFY_EMAIL' => '', 'DOB_DISPLAY' => '', 'ANON_LOGON' => '',
                         'SHOW_STATS' => '',  'IMAGES_TO_LINKS' => '', 'USE_WORD_FILTER' => '',
                         'USE_ADMIN_FILTER' => '', 'EMOTICONS' => '', 'ALLOW_EMAIL' => '', 'ALLOW_PM' => '');

    if (!$table_data = get_table_prefix()) return $prefs_array;

    $sql = "SELECT * FROM {$table_data['PREFIX']}USER_PREFS WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_prefs);

    if (db_num_rows($result) > 0) {
        $prefs_array = array_merge($prefs_array, db_fetch_array($result, MYSQL_ASSOC));
    }

    return $prefs_array;
}

function user_update_prefs($uid, $prefs_array)
{
    if (!is_numeric($uid)) return false;
    if (!is_array($prefs_array)) return false;

    $db_user_update_prefs = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    // Get the current prefs and merge them with the new ones.

    $prefs_array = array_merge(user_get_prefs($uid), $prefs_array);

    // Now delete the old preferences

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_PREFS WHERE UID = $uid";
    $result = db_query($sql, $db_user_update_prefs);

    if (empty($prefs_array['TIMEZONE']))       $prefs_array['TIMEZONE']       = 0;
    if (empty($prefs_array['POSTS_PER_PAGE'])) $prefs_array['POSTS_PER_PAGE'] = 5;
    if (empty($prefs_array['FONT_SIZE']))      $prefs_array['FONT_SIZE']      = 10;

    if (!ereg("([[:alnum:]]+)", $prefs_array['STYLE'])) $prefs_array['STYLE'] = forum_get_setting('default_style');
    if (!ereg("([[:alnum:]]+)", $prefs_array['EMOTICONS'])) $prefs_array['EMOTICONS'] = forum_get_setting('default_emoticons');

    $sql = "INSERT INTO {$table_data['PREFIX']}USER_PREFS (UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, ";
    $sql.= "PIC_URL, EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, STYLE, ";
    $sql.= "VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY, ANON_LOGON, SHOW_STATS, ";
    $sql.= "IMAGES_TO_LINKS, USE_WORD_FILTER, USE_ADMIN_FILTER, EMOTICONS, ALLOW_EMAIL, ALLOW_PM) ";
    $sql.= "VALUES ($uid, '{$prefs_array['FIRSTNAME']}', '{$prefs_array['LASTNAME']}', '{$prefs_array['DOB']}', ";
    $sql.= "'{$prefs_array['HOMEPAGE_URL']}', '{$prefs_array['PIC_URL']}', '{$prefs_array['EMAIL_NOTIFY']}', ";
    $sql.= "'{$prefs_array['TIMEZONE']}', '{$prefs_array['DL_SAVING']}', '{$prefs_array['MARK_AS_OF_INT']}', ";
    $sql.= "'{$prefs_array['POSTS_PER_PAGE']}', '{$prefs_array['FONT_SIZE']}', '{$prefs_array['STYLE']}', ";
    $sql.= "'{$prefs_array['VIEW_SIGS']}', '{$prefs_array['START_PAGE']}', '{$prefs_array['LANGUAGE']}', ";
    $sql.= "'{$prefs_array['PM_NOTIFY']}', '{$prefs_array['PM_NOTIFY_EMAIL']}', '{$prefs_array['DOB_DISPLAY']}', ";
    $sql.= "'{$prefs_array['ANON_LOGON']}', '{$prefs_array['SHOW_STATS']}', '{$prefs_array['IMAGES_TO_LINKS']}', ";
    $sql.= "'{$prefs_array['USE_WORD_FILTER']}', '{$prefs_array['USE_ADMIN_FILTER']}', '{$prefs_array['EMOTICONS']}', ";
    $sql.= "'{$prefs_array['ALLOW_EMAIL']}', '{$prefs_array['ALLOW_PM']}')";

    $result = db_query($sql, $db_user_update_prefs);

    return $result;
}

function user_update_sig($uid, $content, $html)
{
    if (!is_numeric($uid)) return false;

    $content = addslashes($content);
    $db_user_update_sig = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_SIG ";
    $sql.= "WHERE UID = '$uid'";

    $result = db_query($sql, $db_user_update_sig);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE {$table_data['PREFIX']}USER_SIG SET CONTENT = '$content', ";
        $sql.= "HTML = '$html' WHERE UID = '$uid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_SIG (UID, CONTENT, HTML) ";
        $sql.= "VALUES ('$uid', '$content', '$html')";
    }

    return db_query($sql, $db_user_update_sig);
}

function user_update_global_sig($uid, $value)
{
    if (!is_numeric($uid)) return false;

    $db_user_update_global_sig = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "update {$table_data['PREFIX']}USER_PREFS set ";
    $sql .= "VIEW_SIGS = '$value' where UID = $uid";

    $result = db_query($sql, $db_user_update_global_sig);

    return $result;
}

function user_get_global_sig($uid)
{
    if (!is_numeric($uid)) return false;

    $db_user_update_global_sig = db_connect();

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT VIEW_SIGS FROM {$table_data['PREFIX']}USER_PREFS WHERE UID = $uid";
    $result = db_query($sql, $db_user_update_global_sig);

    if (db_num_rows($result)) {
        $fa = db_fetch_array($result);
        return $fa['VIEW_SIGS'];
    }

    return "";
}

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return 0;

    $db_user_get_count = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(POST.FROM_UID) AS COUNT FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST_CONTENT POST_CONTENT ";
    $sql.= "ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";
    $sql.= "WHERE POST.FROM_UID = '$uid' AND POST_CONTENT.CONTENT IS NOT NULL";

    $result = db_query($sql, $db_user_get_count);

    $post_count = db_fetch_array($result);

    return $post_count['COUNT'];
}

function user_get_last_logon_time($uid, $verbose = true)
{
    global $lang;

    if (!is_numeric($uid)) return false;

    $db_user_get_last_logon_time = db_connect();

    if (!$table_data = get_table_prefix()) return $lang['unknown'];

    $sql = "SELECT USER_PREFS.ANON_LOGON, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "WHERE USER.UID = $uid AND VISITOR_LOG.LAST_LOGON IS NOT NULL";

    $result = db_query($sql, $db_user_get_last_logon_time);

    $last_logon = db_fetch_array($result);

    if (isset($last_logon['ANON_LOGON']) && $last_logon['ANON_LOGON'] <> 0) {

        return $lang['unknown'];

    }else {

        return format_time($last_logon['LAST_LOGON'], $verbose);
    }
}

function user_guest_enabled()
{
    if (forum_get_setting('guest_account_enabled', 'N', false)) {
        return false;
    }

    $db_user_guest_account = db_connect();

    $table_data = get_table_prefix();

    $forum_settings = get_forum_settings();

    $sql = "SELECT USER.UID, USER_STATUS.STATUS FROM USER ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON ";
    $sql.= "(USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
    $sql.= "WHERE USER.LOGON = 'GUEST' AND (USER.PASSWD = MD5('guest') OR USER.PASSWD = MD5('GUEST'))";

    $result = db_query($sql, $db_user_guest_account);

    if (db_num_rows($result)) {
        $fa = db_fetch_array($result);
        if (isset($fa['STATUS']) && $fa['STATUS'] & USER_PERM_SPLAT) {
            return false;
        }else {
            return true;
        }
    }

    return false;
}

function user_get_dob($uid)
{
    if (!is_numeric($uid)) return false;

    $prefs = user_get_prefs($uid);

    if (isset($prefs['DOB_DISPLAY']) && $prefs['DOB_DISPLAY'] == 2 && !empty($prefs['DOB']) && $prefs['DOB'] != "0000-00-00") {
        return format_birthday($prefs['DOB']);
    } else {
        return false;
    }
}

function user_get_age($uid)
{
    if (!is_numeric($uid)) return false;

    $prefs = user_get_prefs($uid);

    if (isset($prefs['DOB_DISPLAY']) && $prefs['DOB_DISPLAY'] > 0 && !empty($prefs['DOB']) && $prefs['DOB'] != "0000-00-00") {
        return format_age($prefs['DOB']);
    }else {
        return false;
    }
}

function user_get_forthcoming_birthdays()
{
    $db_user_get_forthcoming_birthdays = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql  = "SELECT U.UID, U.LOGON, U.NICKNAME, UP.DOB, MOD(DAYOFYEAR(UP.DOB) - DAYOFYEAR(NOW()) ";
    $sql .= "+ 365, 365) AS DAYS_TO_BIRTHDAY ";
    $sql .= "FROM USER U, {$table_data['PREFIX']}USER_PREFS UP ";
    $sql .= "WHERE U.UID = UP.UID AND UP.DOB > 0 AND UP.DOB_DISPLAY = 2 ";
    $sql .= "AND MOD(DAYOFYEAR(UP.DOB) - DAYOFYEAR(NOW())+ 365, 365) > 0 ";
    $sql .= "ORDER BY DAYS_TO_BIRTHDAY ASC ";
    $sql .= "LIMIT 0, 5";

    $result = db_query($sql, $db_user_get_forthcoming_birthdays);

    if (db_num_rows($result)) {
        $birthdays = array();
        while ($row = db_fetch_array($result)) {
            $birthdays[] = $row;
        }
	return $birthdays;
    }else {
        return false;
    }
}

function user_search($usersearch, $sort_by = "VISITOR_LOG.LAST_LOGON", $sort_dir = "DESC", $offset = 0)
{
    $db_user_search = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER_STATUS.STATUS', 'VISITOR_LOG.LAST_LOGON');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'USER.UID';

    $usersearch = addslashes($usersearch);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER_STATUS.STATUS FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
    $sql.= "AND VISITOR_LOG.LAST_LOGON IS NOT NULL ";
    $sql.= "AND NOT (USER_PREFS.ANON_LOGON <=> 1) ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_user_search);

    if (db_num_rows($result)) {
        $user_search_array = array();
	while ($row = db_fetch_array($result)) {
	    $user_search_array[] = $row;
	}
	return $user_search_array;
    }else {
        return false;
    }
}

function user_get_all($sort_by = "VISITOR_LOG.LAST_LOGON", $sort_dir = "ASC", $offset = 0)
{
    $db_user_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $user_get_all_array = array();

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER_STATUS.STATUS', 'VISITOR_LOG.LAST_LOGON');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'VISITOR_LOG.LAST_LOGON';

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER_STATUS.STATUS FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "WHERE NOT (USER_PREFS.ANON_LOGON <=> 1) AND VISITOR_LOG.LAST_LOGON IS NOT NULL ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_user_get_all);

    while($row = db_fetch_array($result)) {
       $user_get_all_array[] = $row;
    }

    return $user_get_all_array;
}

function user_get_aliases($uid)
{
    $db_user_get_aliases = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    if (!is_numeric($uid)) return false;

    // Initialise arrays

    $user_ip_address_array = array();
    $user_get_aliases_array = array();

    // Fetch the last 20 IP addresses from the POST table

    $sql = "SELECT DISTINCT IPADDRESS FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = '$uid' ORDER BY TID DESC LIMIT 0, 20";

    $result = db_query($sql, $db_user_get_aliases);

    if (db_num_rows($result)) {
        while($user_get_aliases_row = db_fetch_array($result)) {
            if (!in_array($user_get_aliases_row['IPADDRESS'], $user_ip_address_array) && strlen($user_get_aliases_row['IPADDRESS']) > 0) {
                $user_ip_address_array[] = $user_get_aliases_row['IPADDRESS'];
            }
        }
    }

    // Search the POST table for any matches - limit 10 matches

    $user_ip_address_list = implode("' OR IPADDRESS = '", $user_ip_address_array);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, POST.IPADDRESS FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER USER ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE (POST.IPADDRESS = '$user_ip_address_list') AND POST.FROM_UID <> '$uid' ";
    $sql.= "ORDER BY POST.TID DESC LIMIT 0, 10";

    $result = db_query($sql, $db_user_get_aliases);

    if (db_num_rows($result)) {
        while($user_get_aliases_row = db_fetch_array($result)) {
            $user_get_aliases_array[$user_get_aliases_row['UID']] = $user_get_aliases_row;
        }
    }

    return $user_get_aliases_array;
}

function users_get_recent()
{
    $db_users_get_recent = db_connect();

    $users_get_recent_array = array();

    if ($table_data = get_table_prefix()) {

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON ";
        $sql.= "FROM USER USER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FID = '{$table_data['FID']}') ";
        $sql.= "WHERE NOT (USER_PREFS.ANON_LOGON <=> 1) AND VISITOR_LOG.LAST_LOGON IS NOT NULL ";
        $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
        $sql.= "LIMIT 0, 10";

        $result = db_query($sql, $db_users_get_recent);

        if (db_num_rows($result)) {
	    while ($row = db_fetch_array($result)) {
	        if (!isset($users_get_recent_array[$row['UID']])) {
	            $users_get_recent_array[$row['UID']] = $row;
    	        }
	    }
        }
    }

    return array('user_count' => sizeof($users_get_recent_array),
                 'user_array' => $users_get_recent_array);

}

function users_search_recent($usersearch, $offset)
{
    if (!is_numeric($offset)) $offset = 0;
    $usersearch = addslashes($usersearch);

    $user_search_array = array();

    $db_users_search_recent = db_connect();

    if (!$table_data = get_table_prefix()) return array('user_count' => 0,
                                                        'user_array' => array());

    $sql = "SELECT USER.UID FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FID = '{$table_data['FID']}') ";
    $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
    $sql.= "AND NOT (USER_PREFS.ANON_LOGON <=> 1) AND VISITOR_LOG.LAST_LOGON IS NOT NULL ";

    $result = db_query($sql, $db_users_search_recent);
    $user_search_count = db_num_rows($result);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FID = '{$table_data['FID']}') ";
    $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
    $sql.= "AND NOT (USER_PREFS.ANON_LOGON <=> 1) AND VISITOR_LOG.LAST_LOGON IS NOT NULL ";
    $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_users_search_recent);

    if (db_num_rows($result)) {
	while ($row = db_fetch_array($result)) {
	    if (!isset($user_search_array[$row['UID']])) {
	        $user_search_array[$row['UID']] = $row;
	    }
	}
    }

    return array('user_count' => $user_search_count,
                 'user_array' => $user_search_array);
}

function user_get_friends($uid)
{
    $db_user_get_peers = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.RELATIONSHIP = 1";

    $result = db_query($sql, $db_user_get_peers);

    if (db_num_rows($result)) {
        $user_get_peers_array = array();
        while ($row = db_fetch_array($result)) {
            $user_get_peers_array[] = $row;
        }
        return $user_get_peers_array;
    }else {
        return false;
    }
}

function user_get_ignored($uid)
{
    $db_user_get_peers = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.RELATIONSHIP = 2";

    $result = db_query($sql, $db_user_get_peers);

    if (db_num_rows($result)) {
        $user_get_peers_array = array();
        while ($row = db_fetch_array($result)) {
            $user_get_peers_array[] = $row;
        }
        return $user_get_peers_array;
    }else {
        return false;
    }
}

function user_get_ignored_signatures($uid)
{
    $db_user_get_peers = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.RELATIONSHIP = 3";

    $result = db_query($sql, $db_user_get_peers);

    if (db_num_rows($result)) {
        $user_get_peers_array = array();
        while ($row = db_fetch_array($result)) {
            $user_get_peers_array[] = $row;
        }
        return $user_get_peers_array;
    }else {
        return false;
    }
}

function user_get_relationships($uid, $offset = 0)
{
    $db_user_get_relationships = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($offset)) $offset = 0;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID) ";
    $sql.= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.RELATIONSHIP <> 0 ORDER BY USER.LOGON ASC ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_user_get_relationships);

    if (db_num_rows($result)) {
        $user_get_peers_array = array();
        while ($row = db_fetch_array($result)) {
            $user_get_peers_array[] = $row;
        }
        return $user_get_peers_array;
    }else {
        return false;
    }
}

function user_get_word_filter($incadminfilter = false)
{
    $db_user_get_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT * FROM {$table_data['PREFIX']}FILTER_LIST WHERE UID = '$uid' ";
    if ($incadminfilter) $sql.= "OR UID = 0 ";
    $sql.= "ORDER BY ID";

    $result = db_query($sql, $db_user_get_word_filter);

    $filter_array = array();

    while($row = db_fetch_array($result)) {
        $filter_array[$row['ID']] = $row;
    }

    return $filter_array;
}

function user_clear_word_filter()
{
    $db_user_clear_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST WHERE UID = '$uid'";
    return db_query($sql, $db_user_clear_word_filter);
}

function user_add_word_filter($match, $replace, $filter_option)
{
    $match = addslashes($match);
    $replace = addslashes($replace);

    $db_user_save_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "INSERT INTO {$table_data['PREFIX']}FILTER_LIST (UID, MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
    $sql.= "VALUES ('$uid', '$match', '$replace', '$filter_option')";

    $result = db_query($sql, $db_user_save_word_filter);
}

function user_delete_word_filter($id)
{
    if (!is_numeric($id)) return false;

    $db_user_delete_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST ";
    $sql.= "WHERE ID = '$id' AND UID = '$uid'";

    $result = db_query($sql, $db_user_delete_word_filter);
}

function user_is_active($uid)
{
    if (!is_numeric($uid)) return false;

    $db_user_is_active = db_connect();

    $sql = "SELECT SESSID FROM SESSIONS WHERE UID = '$uid'";
    $result = db_query($sql, $db_user_is_active);

    return (db_num_rows($result) > 0);
}

function user_allow_pm($uid)
{
    $db_pm_user_allow = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_PREFS ";
    $sql.= "WHERE UID = '$uid' AND ALLOW_PM = 'Y'";

    $result = db_query($sql, $db_pm_user_allow);

    return (db_num_rows($result) > 0);
}

function user_allow_email($uid)
{
    $db_pm_user_allow = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_PREFS ";
    $sql.= "WHERE UID = '$uid' AND ALLOW_EMAIL = 'Y'";

    $result = db_query($sql, $db_pm_user_allow);

    return (db_num_rows($result) > 0);
}

?>