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

/* $Id: forum_links.inc.php,v 1.14 2005-07-23 22:53:32 decoyduck Exp $ */

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

    $forum_fid = $table_data['FID'];

    $sql = "SELECT LID, POS, URI, TITLE FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS ASC, LID ASC";

    $result = db_query($sql, $db_forum_links_get_links);

    $num_links = ($include_top_link) ? 0 : 1;

    if (db_num_rows($result) > $num_links) {

        $links = array();

        while ($row = db_fetch_array($result)) {

            if (!isset($row['URI'])) $row['URI'] = "";
            if (!isset($row['TITLE'])) $row['TITLE'] = "-";

            $links[] = array("LID" => $row['LID'], "POS" => $row['POS'], "URI" => $row['URI'], "TITLE" => $row['TITLE']);
        }

        return $links;
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

    $sql = "DELETE FROM {$table_data['PREFIX']}FORUM_LINKS WHERE LID = '$lid'";
    return db_query($sql, $db_forum_links_delete);
}

function forum_links_update($lid, $pos, $title, $uri = "")
{
    $db_forum_links_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($pos)) return false;

    $title = addslashes($title);
    $uri = addslashes($uri);

    $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = '$pos', ";
    $sql.= "TITLE = '$title', URI = '$uri' WHERE LID = '$lid'";

    return db_query($sql, $db_forum_links_update);
}

function forum_links_add($pos, $title, $uri = "")
{
    $table_data = get_table_prefix();

    $db_forum_links_add = db_connect();

    if (!is_numeric($pos)) return false;

    $title = addslashes($title);
    $uri = addslashes($uri);

    $sql = "INSERT INTO {$table_data['PREFIX']}FORUM_LINKS (POS, TITLE, URI) ";
    $sql.= "VALUES ('$pos', '$title', '$uri')";

    return db_query($sql, $db_forum_links_add);
}

?>