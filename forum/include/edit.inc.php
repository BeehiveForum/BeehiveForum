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

// Compress the output
require_once("./include/gzipenc.inc.php");

// Author: Mark Rendle

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/poll.inc.php");

function post_update($tid,$pid,$content)
{
    if(!($tid && $pid)){
        return false;
    }
    $db_post_update = db_connect();

    $content = mysql_escape_string($content);

    $sql = "update " . forum_table("POST_CONTENT") . " set CONTENT = \"$content\" ";
    $sql .= "where TID = $tid and PID = $pid";

    $result = db_query($sql,$db_post_update);

    $return = ($result) ? true : false;

    return $return;
}

function post_delete($tid, $pid)
{
    if(!($tid && $pid)) return false;
    
    $db_post_delete = db_connect();
  
    if (thread_is_poll($tid) && $pid == 1) {
  
      $sql = "update " . forum_table("THREAD") . " set POLL_FLAG = 'N' where TID = $tid";
      $result = db_query($sql, $db_post_delete);

    }
      
    $sql = "update " . forum_table("POST_CONTENT") . " set CONTENT = NULL ";
    $sql .= "where TID = $tid and PID = $pid";
    
    $result = db_query($sql, $db_post_delete);

    $sql = "delete from ". forum_table("THREAD"). " where TID = $tid and LENGTH = 1";
    $result = db_query($sql, $db_post_delete);

    $return = ($result) ? true : false;

    return $return;
}

function edit_refuse($tid, $pid)
{

    echo "<div align=\"center\">";
    echo "<h1>Denied</h1>";
    echo "<p>You are not permitted to edit this message.</p>";
    echo form_quick_button("discussion.php", "Back", "msg", "$tid.$pid");
    echo "</div>";

}

?>