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

/* $Id: edit.inc.php,v 1.88 2009-06-14 16:39:51 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function post_update($fid, $tid, $pid, $content)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db_post_update = db_connect()) return false;

    $content = db_escape_string($content);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST_CONTENT` SET CONTENT = '$content' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

    if (!db_query($sql, $db_post_update)) return false;

    if (bh_session_check_perm(USER_PERM_POST_APPROVAL, $fid) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST` SET APPROVED = 0, APPROVED_BY = 0 ";
        $sql.= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

        if (!db_query($sql, $db_post_update)) return false;
    }

    cache_lite_remove("$tid.$pid");

    return true;
}

function post_add_edit_text($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db_post_add_edit_text = db_connect()) return false;

    if (($edit_uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST` ";
    $sql.= "SET EDITED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "EDITED_BY = '$edit_uid' WHERE TID = '$tid' AND PID = '$pid'";

    if (!db_query($sql, $db_post_add_edit_text)) return false;

    return true;
}

function post_delete($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_post_delete = db_connect()) return false;

    if (($approve_uid = bh_session_get_value('UID')) === false) return false;
    
    $current_datetime = date(MYSQL_DATETIME, time());

    if (thread_is_poll($tid) && $pid == 1) {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` SET POLL_FLAG = 'N', ";
        $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid'";

        if (!db_query($sql, $db_post_delete)) return false;
    }

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` SET DELETED = 'Y', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid' AND LENGTH = 1";

    if (!db_query($sql, $db_post_delete)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST_CONTENT` SET CONTENT = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!db_query($sql, $db_post_delete)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POST` ";
    $sql.= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "APPROVED_BY = '$approve_uid' WHERE TID = '$tid' ";
    $sql.= "AND PID = '$pid'";

    if (!db_query($sql, $db_post_delete)) return false;

    cache_lite_remove("$tid.$pid");

    return true;
}

function edit_refuse($tid, $pid)
{
    $lang = lang::get_instance()->load(__FILE__);
    html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => "$tid.$pid"));
}

?>