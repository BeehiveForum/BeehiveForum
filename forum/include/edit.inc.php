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

/* $Id: edit.inc.php,v 1.29 2003-11-27 12:00:31 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/lang.inc.php");

function post_update($tid, $pid, $content)
{
    if (!is_numeric($tid) || !is_numeric($pid)) return false;

    $db_post_update = db_connect();

    $content  = addslashes($content);
    $edit_uid = bh_session_get_value('UID');

    $sql = "UPDATE ". forum_table("POST_CONTENT") . " SET CONTENT = '$content' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_update);

    $sql = "UPDATE ". forum_table("POST"). " SET EDITED = NOW(), EDITED_BY = '$edit_uid' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_update);

    return (db_affected_rows($db_post_update) > 0);
}

function post_delete($tid, $pid)
{
    if (!is_numeric($tid) || !is_numeric($pid)) return false;

    $db_post_delete = db_connect();

    if (thread_is_poll($tid) && $pid == 1) {
        $sql = "UPDATE ". forum_table("THREAD"). " SET POLL_FLAG = 'N' WHERE TID = '$tid'";
        $result = db_query($sql, $db_post_delete);
    }

    $sql = "DELETE FROM ". forum_table("THREAD"). " WHERE TID = '$tid' AND LENGTH = 1";
    $result = db_query($sql, $db_post_delete);

    $sql = "UPDATE ". forum_table("POST_CONTENT"). " SET CONTENT = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_delete);

    return (db_affected_rows($db_post_delete) > 0);
}

function edit_refuse($tid, $pid)
{
    global $lang;

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['nopermissiontoedit']}</p>";
    echo form_quick_button("discussion.php", $lang['back'], "msg", "$tid.$pid");
    echo "</div>";
}

?>