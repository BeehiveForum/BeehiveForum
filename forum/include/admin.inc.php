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

function admin_addlog($uid, $fid, $tid, $pid, $psid, $piid, $action)
{

  global $HTTP_COOKIE_VARS;

  $admin_uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
  $db_admin_addlog = db_connect();

  $sql = "INSERT INTO ". forum_table("ADMIN_LOG"). " (LOG_TIME, ADMIN_UID, UID, FID, TID, PID, PSID, PIID, ACTION) ";
  $sql.= "VALUES (NOW(), '$admin_uid', '$uid', '$fid', '$tid', '$pid', '$psid', '$piid', '$action')";

  $result = db_query($sql, $db_admin_addlog);

  return $result;

}
