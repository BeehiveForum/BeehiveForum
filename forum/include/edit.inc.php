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

// Author: Mark Rendle

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");

function post_update($tid,$pid,$content)
{
    if(!($tid && $pid)){
        return false;
    }
    $db = db_connect();

    $content = mysql_escape_string($content);

    $sql = "update " . forum_table("POST_CONTENT") . " set CONTENT = \"$content\" ";
    $sql .= "where TID = $tid and PID = $pid";

    $result = db_query($sql,$db);

    $return = ($result) ? true : false;

    db_disconnect($db);

    return $return;
}

function post_delete($tid,$pid)
{
    if(!($tid && $pid)){
        return false;
    }
    $db = db_connect();

    $content = mysql_escape_string($content);

    $sql = "update " . forum_table("POST_CONTENT") . " set CONTENT = NULL ";
    $sql .= "where TID = $tid and PID = $pid";
    
    echo $sql;

    $result = db_query($sql,$db);

    $return = ($result) ? true : false;

    db_disconnect($db);

    return $return;
}

function edit_refuse()
{
    html_draw_top();
    echo "<div align=\"center\">";
    echo "<h1>Denied</h1>";
    echo "<p>You are not permitted to edit this message, naughty person!</p>";
    echo "<p><a href=\"discussion.php?msg=" . $msg_bits[0]. "." .$msg_bits[1];
    echo "\">Return to messages</a></p>";
    echo "</div>";


?>
