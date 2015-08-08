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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'links.inc.php';
// End Required includes

function forum_links_get_links()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $forum_links_top_link = forum_get_setting('forum_links_top_link', null, gettext("Forum Links"));

    $sql = "SELECT LID, TITLE, URI FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "ORDER BY POSITION ASC";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $links_array = array($forum_links_top_link);

    while (($forum_links_data = $result->fetch_assoc()) !== null) {

        if (!isset($forum_links_data['TITLE']) || strlen(trim($forum_links_data['TITLE'])) < 1) {
            $forum_links_data['TITLE'] = '-';
        }

        if (!isset($forum_links_data['URI']) || strlen(trim($forum_links_data['URI'])) < 1) {

            $links_array[$forum_links_data['LID']] = $forum_links_data['TITLE'];

        } else {

            $forum_links_data['URI'] = href_cleanup_query_keys($forum_links_data['URI']);
            $links_array[$forum_links_data['URI']] = $forum_links_data['TITLE'];
        }
    }

    return $links_array;
}

function forum_links_get_links_by_page($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $forum_links_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS LID, POSITION, URI, TITLE ";
    $sql .= "FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "ORDER BY POSITION ASC LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($forum_links_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($forum_links_count > 0) && ($page > 1)) {
        return forum_links_get_links_by_page($page - 1);
    }

    while (($forum_links_data = $result->fetch_assoc()) !== null) {

        if (!isset($forum_links_data['URI'])) $forum_links_data['URI'] = "";
        if (!isset($forum_links_data['TITLE'])) $forum_links_data['TITLE'] = "-";

        $forum_links_array[] = $forum_links_data;
    }

    return array(
        'forum_links_array' => $forum_links_array,
        'forum_links_count' => $forum_links_count
    );
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

        $uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
        $uri .= (isset($uri_array['host'])) ? "{$uri_array['host']}" : '';
        $uri .= (isset($uri_array['port'])) ? ":{$uri_array['port']}" : '';
        $uri .= (isset($uri_array['path'])) ? "{$uri_array['path']}" : '';
        $uri .= (isset($uri_array['query'])) ? "?{$uri_array['query']}" : '';
        $uri .= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';
    }

    return $uri;

}

function forum_links_draw_dropdown()
{
    if (($forum_links_array = forum_links_get_links()) !== false) {

        $html = form_dropdown_array('forum_links', $forum_links_array, null, null, "forumlinks");
        return $html;
    }

    return "";
}

function forum_links_delete($lid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($lid)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}FORUM_LINKS` WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_links_update_link($lid, $title, $uri = "")
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($lid)) return false;

    $title = $db->escape($title);
    $uri = $db->escape($uri);

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` SET TITLE = '$title', ";
    $sql .= "URI = '$uri' WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_links_add_link($title, $uri = "")
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $title = $db->escape($title);
    $uri = $db->escape($uri);

    $sql = "SELECT MAX(POSITION) + 1 FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    list($new_position) = $result->fetch_row();

    $sql = "INSERT INTO `{$table_prefix}FORUM_LINKS` (POSITION, TITLE, URI) ";
    $sql .= "VALUES ('$new_position', '$title', '$uri')";

    if (!($result = $db->query($sql))) return false;

    $new_lid = $db->insert_id;

    return $new_lid;
}

function forum_links_get_link($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT LID, POSITION, URI, TITLE ";
    $sql .= "FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "WHERE LID = '$lid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $forum_links_array = $result->fetch_assoc();

    return $forum_links_array;
}

function forum_links_move_up($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    forum_links_positions_update();

    $forum_links_order = array();
    $forum_links_position = array();

    $sql = "SELECT LID, POSITION FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($forum_links_data = $result->fetch_assoc()) !== null) {

        $forum_links_order[] = $forum_links_data['LID'];
        $forum_links_position[$forum_links_data['LID']] = $forum_links_data['POSITION'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key--;

        if ($forum_links_order_key < 0) {
            $forum_links_order_key = 0;
        }

        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` SET POSITION = '$new_position' ";
        $sql .= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!($result = $db->query($sql))) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` SET POSITION = '$new_position' ";
        $sql .= "WHERE LID = '$lid'";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function forum_links_move_down($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    forum_links_positions_update();

    $forum_links_order = array();
    $forum_links_position = array();

    $sql = "SELECT LID, POSITION FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($forum_links_data = $result->fetch_assoc()) !== null) {

        $forum_links_order[] = $forum_links_data['LID'];
        $forum_links_position[$forum_links_data['LID']] = $forum_links_data['POSITION'];
    }

    if (($forum_links_order_key = array_search($lid, $forum_links_order)) !== false) {

        $forum_links_order_key++;

        if ($forum_links_order_key > sizeof($forum_links_order)) {
            $forum_links_order_key = sizeof($forum_links_order);
        }

        $new_position = $forum_links_position[$lid];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` SET POSITION = '$new_position' ";
        $sql .= "WHERE LID = '{$forum_links_order[$forum_links_order_key]}'";

        if (!($result = $db->query($sql))) return false;

        $new_position = $forum_links_position[$forum_links_order[$forum_links_order_key]];

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` SET POSITION = '$new_position' ";
        $sql .= "WHERE LID = '$lid'";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function forum_links_positions_update()
{
    $new_position = 0;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT LID FROM `{$table_prefix}FORUM_LINKS` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($link_data = $result->fetch_assoc()) !== null) {

        $new_position++;

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FORUM_LINKS` ";
        $sql .= "SET POSITION = '$new_position' WHERE LID = '{$link_data['LID']}'";

        if (!$db->query($sql)) return false;
    }

    return true;
}