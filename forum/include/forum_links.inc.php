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

/* $Id: forum_links.inc.php,v 1.15 2006-10-08 17:22:47 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");

function forum_links_get_links($include_top_link)
{
    $db_forum_links_get_links = db_connect();

    if (!is_bool($include_top_link)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID, POS, URI, TITLE FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS ASC, LID ASC";

    $result = db_query($sql, $db_forum_links_get_links);

    $num_links = ($include_top_link) ? 0 : 1;

    if (db_num_rows($result) > $num_links) {

        $links_array = array();

        while ($row = db_fetch_array($result)) {

            if (!isset($row['URI'])) $row['URI'] = "";
            if (!isset($row['TITLE'])) $row['TITLE'] = "-";

            $links_array[] = $row;
        }

        return $links_array;
    }

    return false;
}

function forum_links_draw_dropdown()
{
    if ($forum_links_array = forum_links_get_links(false)) {

        $html = "<select name=\"forum_links\" onchange=\"openForumLink(this)\" class=\"forumlinks\">\n";

        foreach($forum_links_array as $key => $forum_link) {

            $html.= "<option value=\"{$forum_link['URI']}\">{$forum_link['TITLE']}</option>\n";
        }

        $html.= "</select>\n";
        return $html;
    }

    return "";
}

function forum_links_delete($lid)
{
    $db_forum_links_delete = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS LIMIT 0, 1";

    $result = db_query($sql, $db_forum_links_delete);

    if (db_num_rows($result) > 0) {

        list($top_lid) = db_fetch_array($result, DB_RESULT_NUM);

        if ($top_lid != $lid) {

            $sql = "DELETE FROM {$table_data['PREFIX']}FORUM_LINKS WHERE LID = '$lid'";
            if (!$result = db_query($sql, $db_forum_links_delete)) return false;

            return true;
        }
    }

    return false;
}

function forum_links_update($lid, $title, $uri = "")
{
    $db_forum_links_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;

    $title = addslashes($title);
    $uri = addslashes($uri);

    $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET TITLE = '$title', ";
    $sql.= "URI = '$uri' WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_forum_links_update)) return false;

    return true;
}

function forum_links_add($title, $uri = "")
{
    $db_forum_links_add = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $title = addslashes($title);
    $uri = addslashes($uri);

    $sql = "SELECT MAX(POS) + 1 FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}FORUM_LINKS (POS, TITLE, URI) ";
    $sql.= "VALUES ('$new_position', '$title', '$uri')";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    return true;
}

function forum_links_update_top_link($title)
{
    $db_forum_links_add = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $title = addslashes($title);

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS LIMIT 0, 1";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    list($top_link_lid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "SET TITLE = '$title' WHERE LID = '$top_link_lid'";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    return true;
}

function forum_links_add_top_link($title)
{
    $db_forum_links_add = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $title = addslashes($title);

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS";
    $result = db_query($sql, $db_forum_links_add);

    if (db_num_rows($result) < 1) {

        $sql = "INSERT INTO {$table_data['PREFIX']}FORUM_LINKS (POS, TITLE) ";
        $sql.= "VALUES (0, '$title')";

        if (!$result = db_query($sql, $db_forum_links_add)) return false;

        return true;
    }

    return false;
}

function forum_links_move_up($lid)
{
    $db_forum_links_move_up = db_connect();

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS";

    $result = db_query($sql, $db_forum_links_move_up);

    while ($row = db_fetch_array($result)) {
        $forum_links_data[] = $row['LID'];
    }

    if (($forum_links_position_key = array_search($lid, $forum_links_data)) !== false) {

        $forum_links_position_key--;

        if ($forum_links_position_key < 0) {
            $forum_links_position_key = 0;
        }

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = POS + 1 ";
        $sql.= "WHERE LID = '{$forum_links_data[$forum_links_position_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = POS - 1 ";
        $sql.= "WHERE LID = '$lid'";

        if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

        return true;
    }

    return false;
}

function forum_links_move_down($lid)
{
    $db_forum_links_move_down = db_connect();

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS";

    $result = db_query($sql, $db_forum_links_move_down);

    while ($row = db_fetch_array($result)) {
        $forum_links_data[] = $row['LID'];
    }

    if (($forum_links_position_key = array_search($lid, $forum_links_data)) !== false) {

        $forum_links_position_key++;

        if ($forum_links_position_key > sizeof($forum_links_data)) {
            $forum_links_position_key = sizeof($forum_links_data);
        }        
        
        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = POS - 1 ";
        $sql.= "WHERE LID = '{$forum_links_data[$forum_links_position_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = POS + 1 ";
        $sql.= "WHERE LID = '$lid'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        return true;
    }

    return false;
}

?>