<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Required includes
// End Required includes

function user_rel_update($uid, $peer_uid, $relationship, $nickname = "")
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($peer_uid)) return false;
    if (!is_numeric($relationship)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}USER_PEER` (UID, PEER_UID, RELATIONSHIP, PEER_NICKNAME) ";
    $sql.= "VALUES ('$uid', '$peer_uid', '$relationship', NULL) ON DUPLICATE KEY UPDATE ";
    $sql.= "RELATIONSHIP = VALUES(RELATIONSHIP), PEER_NICKNAME = NULL";

    if (!$db->query($sql)) return false;

    $user_nickname = user_get_nickname($peer_uid);

    if (($nickname != $user_nickname)) {

        $nickname = $db->escape($nickname);

        $sql = "INSERT INTO `{$table_prefix}USER_PEER` (UID, PEER_UID, PEER_NICKNAME) ";
        $sql.= "VALUES ('$uid', '$peer_uid', '$nickname') ON DUPLICATE KEY UPDATE ";
        $sql.= "PEER_NICKNAME = VALUES(PEER_NICKNAME)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function user_get_relationship($uid, $peer_uid)
{
    if (!$db = db::get()) return 0;

    if (!is_numeric($uid)) return 0;
    if (!is_numeric($peer_uid)) return 0;

    if (!($table_prefix = get_table_prefix())) return 0;

    $sql = "SELECT RELATIONSHIP FROM `{$table_prefix}USER_PEER` ";
    $sql.= "WHERE UID = '$uid' AND PEER_UID = '$peer_uid'";

    if (!($result = $db->query($sql))) return 0;

    if ($result->num_rows == 0 ) return 0;

    list($peer_relationship) = $result->fetch_row();

    return $peer_relationship;
}

?>