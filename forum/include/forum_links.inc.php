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

/* $Id: forum_links.inc.php,v 1.27 2007-05-02 23:15:41 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");

function forum_links_get_links()
{
    $db_forum_links_get_links = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    
    $lang = load_language_file();

    $sql = "SELECT LID, POS, URI, TITLE FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS ASC, LID ASC";

    $result = db_query($sql, $db_forum_links_get_links);

    if (db_num_rows($result) > 0) {

        $links_array = array();

        while ($row = db_fetch_array($result)) {

            if (!isset($row['URI'])) $row['URI'] = "";
            if (!isset($row['TITLE'])) $row['TITLE'] = "-";

            $links_array[] = $row;
        }

        $forum_links_top_link = forum_get_setting('forum_links_top_link', false, $lang['forumlinks']);
        
        array_unshift($links_array, array('TITLE' => $forum_links_top_link, 'URI' => ''));

        return $links_array;
    }

    return false;
}

function forum_links_get_links_by_page($offset)
{
    $db_forum_links_get_links_by_page = db_connect();

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_links_array = array();

    $sql = "SELECT COUNT(LID) FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $result = db_query($sql, $db_forum_links_get_links_by_page);

    list($forum_links_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT LID, POS, URI, TITLE FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS ASC, LID ASC ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_forum_links_get_links_by_page);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            if (!isset($row['URI'])) $row['URI'] = "";
            if (!isset($row['TITLE'])) $row['TITLE'] = "-";

            $forum_links_array[] = $row;
        }
    
    }else if ($forum_links_count > 0) {

        $offset = floor(($forum_links_count / 10) - 1) * 10;
        return forum_links_get_links_by_page($offset);
    }

    return array('forum_links_array' => $forum_links_array,
                 'forum_links_count' => $forum_links_count);
}

function forum_links_fix_url($uri)
{
    $uri_array = parse_url($uri);

    if (isset($uri_array['query'])) {

        parse_str($uri_array['query'], $uri_query_array);

        $new_uri_query_array = array();

        foreach($uri_query_array as $key => $value) {

            if (strlen($key) > 0 && strlen($value) > 0) {

                $value = rawurlencode($value);
                $new_uri_query_array[] = "{$key}={$value}";
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
    if ($forum_links_array = forum_links_get_links(false)) {

        $html = "<select name=\"forum_links\" onchange=\"openForumLink(this)\" class=\"forumlinks\">\n";

        foreach($forum_links_array as $key => $forum_link) {

            if (isset($forum_link['URI']) && isset($forum_link['TITLE'])) {

                $forum_link_url = forum_links_fix_url($forum_link['URI']);                
                $html.= "  <option value=\"{$forum_link_url}\">{$forum_link['TITLE']}</option>\n";
            }
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

function forum_links_update_link($lid, $title, $uri = "")
{
    $db_forum_links_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($lid)) return false;

    $title = db_escape_string($title);
    $uri = db_escape_string($uri);

    $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET TITLE = '$title', ";
    $sql.= "URI = '$uri' WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_forum_links_update)) return false;

    return true;
}

function forum_links_add_link($title, $uri = "")
{
    $db_forum_links_add = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $title = db_escape_string($title);
    $uri = db_escape_string($uri);

    $sql = "SELECT MAX(POS) + 1 FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    list($new_position) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}FORUM_LINKS (POS, TITLE, URI) ";
    $sql.= "VALUES ('$new_position', '$title', '$uri')";

    if (!$result = db_query($sql, $db_forum_links_add)) return false;

    return db_insert_id($db_forum_links_add);
}

function forum_links_get_link($lid)
{
    $db_forum_links_get_link = db_connect();

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LID, POS, URI, TITLE ";
    $sql.= "FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "WHERE LID = '$lid'";

    $result = db_query($sql, $db_forum_links_get_link);

    if (db_num_rows($result) > 0) {

        $forum_links_array = db_fetch_array($result);
        return $forum_links_array;
    }

    return false;
}

function forum_links_move_up($lid)
{
    $db_forum_links_move_up = db_connect();

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    forum_links_positions_update();

    $sql = "SELECT LID, POS FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS";

    $result = db_query($sql, $db_forum_links_move_up);

    while ($row = db_fetch_array($result)) {

        $forum_links_order[] = $row['LID'];
        $forum_links_position[$row['LID']] = $row['POS'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key--;

        if ($forum_links_order_key < 0) {
            $forum_links_order_key = 0;
        }

        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = '$new_position' ";
        $sql.= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_up)) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = '$new_position' ";
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

    forum_links_positions_update();

    $sql = "SELECT LID, POS FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS";

    $result = db_query($sql, $db_forum_links_move_down);

    while ($row = db_fetch_array($result)) {

        $forum_links_order[] = $row['LID'];
        $forum_links_position[$row['LID']] = $row['POS'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key++;

        if ($forum_links_order_key > sizeof($forum_links_order)) {
            $forum_links_order_key = sizeof($forum_links_order);
        }        
        
        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = '$new_position' ";
        $sql.= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS SET POS = '$new_position' ";
        $sql.= "WHERE LID = '$lid'";

        if (!$result = db_query($sql, $db_forum_links_move_down)) return false;

        return true;
    }

    return false;
}

function forum_links_positions_update()
{
    $new_position = 0;

    $db_forum_links_positions_update = db_connect();

    if (!$table_data = get_table_prefix()) return;

    $sql = "SELECT LID FROM {$table_data['PREFIX']}FORUM_LINKS ";
    $sql.= "ORDER BY POS";

    $result = db_query($sql, $db_forum_links_positions_update);

    while (list($lid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($lid) && is_numeric($lid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS ";
            $sql.= "SET POS = '$new_position' WHERE LID = '$lid'";

            $result_update = db_query($sql, $db_forum_links_positions_update);
        }
    }
}

?>