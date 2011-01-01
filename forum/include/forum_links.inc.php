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

/* $Id$ */

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");

function forum_links_get_links()
{
    if (!$db_forum_links_get_links = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $lang = load_language_file();

    $forum_links_top_link = forum_get_setting('forum_links_top_link', false, $lang['forumlinks']);

    $sql = "SELECT LID, TITLE, URI FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "ORDER BY POS ASC";

    if (!$result = db_query($sql, $db_forum_links_get_links)) return false;

    if (db_num_rows($result) > 0) {

        $links_array = array($forum_links_top_link);

        while (($forum_links_data = db_fetch_array($result))) {

            if (!isset($forum_links_data['TITLE']) || strlen(trim($forum_links_data['TITLE'])) < 1) {
                $forum_links_data['TITLE'] = '-';
            }

            if (!isset($forum_links_data['URI']) || strlen(trim($forum_links_data['URI'])) < 1) {

                $links_array[$forum_links_data['LID']] = $forum_links_data['TITLE'];

            }else {

                $forum_links_data['URI'] = href_cleanup_query_keys($forum_links_data['URI']);
                $links_array[$forum_links_data['URI']] = $forum_links_data['TITLE'];
            }
        }

        return $links_array;
    }

    return false;
}

function forum_links_get_links_by_page($offset)
{
    if (!$db_forum_links_get_links_by_page = db_connect()) return false;

    if (!is_numeric($offset)) return false;

    $offset = abs($offset);

    if (!$table_data = get_table_prefix()) return false;

    $forum_links_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS LID, POS, URI, TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "ORDER BY POS ASC LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_forum_links_get_links_by_page)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_forum_links_get_links_by_page)) return false;

    list($forum_links_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($forum_links_data = db_fetch_array($result))) {

            if (!isset($forum_links_data['URI'])) $forum_links_data['URI'] = "";
            if (!isset($forum_links_data['TITLE'])) $forum_links_data['TITLE'] = "-";

            $forum_links_array[] = $forum_links_data;
        }

    }else if ($forum_links_count > 0) {

        $offset = floor(($forum_links_count - 1) / 10) * 10;
        return forum_links_get_links_by_page($offset);
    }

    return array('forum_links_array' => $forum_links_array,
                 'forum_links_count' => $forum_links_count);
}

function forum_links_fix_url($uri)
{
    $uri_array = parse_url($uri);

    if (isset($uri_array['query'])) {

        $uri_query_array = array();

        parse_str($uri_array['query'], $uri_query_array);

        $new_uri_query_array = array();

        foreach ($uri_query_array as $key => $value) {

            if (strlen($key) > 0) {

                if (strlen($value) > 0) {

                    $new_uri_query_array[] = sprintf('%s=%s', urlencode($key), urlencode($value));

                } else {

                    $new_uri_query_array[] = urlencode($key);
                }
            }
        }

        $uri_array['query'] = implode("&amp;", $new_uri_query_array);

        $uri = (isset($uri_array['scheme']))   ? "{$uri_array['scheme']}://" : '';
        $uri.= (isset($uri_array['host']))     ? "{$uri_array['host']}"      : '';
        $uri.= (isset($uri_array['port']))     ? ":{$uri_array['port']}"     : '';
        $uri.= (isset($uri_array['path']))     ? "{$uri_array['path']}"      : '';
        $uri.= (isset($uri_array['query']))    ? "?{$uri_array['query']}"    : '';
        $uri.= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';
    }

    return $uri;

}

function forum_links_draw_dropdown()
{
    if (($forum_links_array = forum_links_get_links(false))) {

        $html = form_dropdown_array('forum_links', $forum_links_array, false, false, "forumlinks");
        return $html;
    }

    return "";
}

function forum_links_delete($lid)
{
    if (!$db_forum_links_delete = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}FORUM_LINKS` WHERE LID = '$lid'";

    if (!db_query($sql, $db_forum_links_delete)) return false;

    return true;
}

function forum_links_update_link($lid, $title, $uri = "")
{
    if (!$db_forum_links_update = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;

    $title = db_escape_string($title);
    $uri = db_escape_string($uri);

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` SET TITLE = '$title', ";
    $sql.= "URI = '$uri' WHERE LID = '$lid'";

    if (!db_query($sql, $db_forum_links_update)) return false;

    return true;
}

function forum_links_add_link($title, $uri = "")
{
    if (!$db_forum_links_add = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $title = db_escape_string($title);
    $uri = db_escape_string($uri);

    $sql = "SELECT MAX(POS) + 1 FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO `{$table_data['PREFIX']}FORUM_LINKS` (POS, TITLE, URI) ";
    $sql.= "VALUES ('$new_position', '$title', '$uri')";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    $new_lid = db_insert_id($db_forum_links_add);

    return $new_lid;
}

function forum_links_get_link($lid)
{
    if (!$db_forum_links_get_link = db_connect()) return false;

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID, POS, URI, TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_forum_links_get_link)) return false;

    if (db_num_rows($result) > 0) {

        $forum_links_array = db_fetch_array($result);
        return $forum_links_array;
    }

    return false;
}

function forum_links_move_up($lid)
{
    if (!$db_forum_links_move_up = db_connect()) return false;

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    forum_links_positions_update();

    $sql = "SELECT LID, POS FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "ORDER BY POS";

    if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

    while (($forum_links_data = db_fetch_array($result))) {

        $forum_links_order[] = $forum_links_data['LID'];
        $forum_links_position[$forum_links_data['LID']] = $forum_links_data['POS'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key--;

        if ($forum_links_order_key < 0) {
            $forum_links_order_key = 0;
        }

        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` SET POS = '$new_position' ";
        $sql.= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` SET POS = '$new_position' ";
        $sql.= "WHERE LID = '$lid'";

        if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

        return true;
    }

    return false;
}

function forum_links_move_down($lid)
{
    if (!$db_forum_links_move_down = db_connect()) return false;

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    forum_links_positions_update();

    $sql = "SELECT LID, POS FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "ORDER BY POS";

    if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

    while (($forum_links_data = db_fetch_array($result))) {

        $forum_links_order[] = $forum_links_data['LID'];
        $forum_links_position[$forum_links_data['LID']] = $forum_links_data['POS'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key++;

        if ($forum_links_order_key > sizeof($forum_links_order)) {
            $forum_links_order_key = sizeof($forum_links_order);
        }

        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` SET POS = '$new_position' ";
        $sql.= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` SET POS = '$new_position' ";
        $sql.= "WHERE LID = '$lid'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        return true;
    }

    return false;
}

function forum_links_positions_update()
{
    $new_position = 0;

    if (!$db_forum_links_positions_update = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID FROM `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql.= "ORDER BY POS";

    if (!$result = db_query($sql, $db_forum_links_positions_update)) return false;

    while (list($lid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($lid) && is_numeric($lid)) {

            $new_position++;

            $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}FORUM_LINKS` ";
            $sql.= "SET POS = '$new_position' WHERE LID = '$lid'";

            if (!db_query($sql, $db_forum_links_positions_update)) return false;
        }
    }

    return true;
}

?>