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
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
// End Required includes

class rss_feed_item
{
    public $title;
    public $link;
    public $description;
    public $pubDate;

    function __construct($aa)
    {
        foreach ($aa as $key => $value) {
            $this->$key = $value;
        }
    }
}

function rss_feed_read_stream($filename)
{
    // Try and use PHP's own fopen wrapper to save us
    // having to do our own HTTP connection.
    if (($rss_data = @file($filename)) !== false) {
        if (is_array($rss_data)) return implode(' ', $rss_data);
    }

    $url_array = parse_url($filename);

    // We only do HTTP
    if (!isset($url_array['host'])) return false;
    if (!isset($url_array['scheme']) || $url_array['scheme'] != 'http') return false;

    // We don't do HTTP authentication.
    if (isset($url_array['user'])) return false;
    if (isset($url_array['pass'])) return false;

    // If we don't have a port we'll assume port 80.
    if (!isset($url_array['port']) || empty($url_array['port'])) $url_array['port'] = 80;

    // No URL query we still need to set the array index.
    // If we do have a URL query we need to prefix it with a ?
    if (!isset($url_array['query']) || empty($url_array['query'])) $url_array['query'] = "";
    if (strlen($url_array['query']) > 0) $url_array['query'] = "?{$url_array['query']}";

    // No path, we'll assume we're fetching from the root.
    if (!isset($url_array['path']) || empty($url_array['path'])) $url_array['path'] = "/";

    // We can't do much without socket functions
    $errno = 0;
    $errstr = '';

    if (($fp = @fsockopen($url_array['host'], $url_array['port'], $errno, $errstr, 30)) !== false) {

        @socket_set_timeout($fp, 2, 0);
        @socket_set_blocking($fp, false);

        $header = "GET {$url_array['path']}{$url_array['query']} HTTP/1.0\r\n";
        $header .= "Host: {$url_array['host']}\r\n";
        $header .= "Connection: Close\r\n\r\n";

        $reply_data = "";

        fwrite($fp, $header);

        while (!feof($fp)) {
            $reply_data .= fgets($fp, 128);
        }

        fclose($fp);

        // Split the header from the data (seperated by \r\n\r\n)
        if (($data_array = preg_split("/\r\n\r\n/u", $reply_data, 2)) !== false) {

            return $data_array[1];
        }
    }

    return false;
}

function rss_feed_read_database($filename)
{
    if (!$data = rss_feed_read_stream($filename)) return false;

    $data = html_entity_to_decimal($data);

    $rss_data = array();

    $parser = xml_parser_create();

    $values = array();

    $tags = array();

    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    // loop through the structures
    foreach ($tags as $key => $value) {

        if ($key == 'item') {

            $ranges = $value;

            // each contiguous pair of array entries are the
            // lower and upper range for each molecule definition
            for ($i = 0; $i < count($ranges); $i += 2) {

                if (isset($ranges[$i]) && isset($ranges[$i + 1])) {

                    $offset = $ranges[$i] + 1;
                    $len = $ranges[$i + 1] - $offset;
                    $rss_data[] = rss_feed_parse_item(array_slice($values, $offset, $len));
                }
            }

        } else {

            continue;
        }
    }

    return $rss_data;
}

function rss_feed_parse_item($item_values)
{
    $item = array();

    for ($i = 0; $i < count($item_values); $i++) {

        if (isset($item_values[$i]["value"])) {
            $item[$item_values[$i]["tag"]] = $item_values[$i]["value"];
        } else {
            $item[$item_values[$i]["tag"]] = " ";
        }
    }

    return new rss_feed_item($item);
}

function rss_feed_fetch()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "SELECT RSS_FEEDS.RSSID, RSS_FEEDS.NAME, RSS_FEEDS.UID, RSS_FEEDS.FID, RSS_FEEDS.URL, ";
    $sql .= "RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY, RSS_FEEDS.LAST_RUN, RSS_FEEDS.MAX_ITEM_COUNT, ";
    $sql .= "COALESCE(DATE_ADD(RSS_FEEDS.LAST_RUN, INTERVAL RSS_FEEDS.FREQUENCY MINUTE), 0) AS NEXT_RUN ";
    $sql .= "FROM `{$table_prefix}RSS_FEEDS` RSS_FEEDS LEFT JOIN USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql .= "WHERE RSS_FEEDS.FREQUENCY > 0 AND USER.UID IS NOT NULL ";
    $sql .= "HAVING CAST('$current_datetime' AS DATETIME) > NEXT_RUN ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $rss_feed = $result->fetch_assoc();

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}RSS_FEEDS` ";
    $sql .= "SET LAST_RUN = CAST('$current_datetime' AS DATETIME) ";
    $sql .= "WHERE RSSID = {$rss_feed['RSSID']}";

    if (!($result = $db->query($sql))) return false;

    if ($db->affected_rows == 0) return false;

    return $rss_feed;
}

function rss_feed_thread_exist($rss_id, $link)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($rss_id)) return false;

    $link = $db->escape($link);

    $sql = "SELECT COUNT(RSSID) AS RSS_THREAD_COUNT ";
    $sql .= "FROM `{$table_prefix}RSS_HISTORY` ";
    $sql .= "WHERE RSSID = '$rss_id' AND LINK = '$link'";

    if (!($result = $db->query($sql))) return false;

    list($rss_thread_count) = $result->fetch_row();

    return ($rss_thread_count > 0);
}

function rss_feed_create_history($rss_id, $link)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($rss_id)) return false;

    $link = $db->escape($link);

    $sql = "INSERT IGNORE INTO `{$table_prefix}RSS_HISTORY` (RSSID, LINK) ";
    $sql .= "VALUES ($rss_id, '$link')";

    if (!$db->query($sql)) return false;

    return true;
}

function rss_feed_check_feeds()
{
    if (($rss_feed = rss_feed_fetch()) !== false) {

        if (($rss_data = rss_feed_read_database($rss_feed['URL'])) !== false) {

            $max_item_count = min(10, $rss_feed['MAX_ITEM_COUNT']);

            foreach ($rss_data as $item_index => $rss_feed_item) {

                if (($item_index + 1) > $max_item_count) return;

                if (!rss_feed_thread_exist($rss_feed['RSSID'], $rss_feed_item->link)) {

                    $rss_title = htmlentities_decode_array($rss_feed_item->title);

                    $rss_title = htmlentities_array(strip_tags($rss_title));

                    $rss_feed_name = htmlentities_array($rss_feed['NAME']);

                    $rss_quote_source = "$rss_feed_name $rss_title";

                    if (isset($rss_feed['PREFIX']) && strlen(trim($rss_feed['PREFIX'])) > 0) {

                        $rss_feed_prefix = htmlentities_array($rss_feed['PREFIX']);
                        $rss_title = "$rss_feed_prefix $rss_title";
                    }

                    if (mb_strlen($rss_title) > 64) {

                        $rss_title = mb_substr($rss_title, 0, 60);

                        if (($pos = mb_strrpos($rss_title, ' ')) !== false) {
                            $rss_title = trim(mb_substr($rss_title, 0, $pos));
                        }

                        $rss_title .= "...";
                    }

                    if (strlen($rss_feed_item->description) > 1) {

                        $rss_feed_item_description = htmlentities_decode_array($rss_feed_item->description);

                        $rss_content = fix_html(sprintf(
                            '<div class="quotetext"><b>%s:</b> <a href="%s">%s</a></div>
                             <div class="quote">%s</div>',
                            gettext('quote'),
                            $rss_feed_item->link,
                            $rss_quote_source,
                            $rss_feed_item_description
                        ));

                    } else {

                        $rss_content = fix_html(sprintf(
                            '<p>%s</p><a href=\"%s\" target=\"_blank\">%s</a>',
                            $rss_quote_source,
                            $rss_feed_item->link,
                            gettext("Click here to read this article")
                        ));
                    }

                    $tid = post_create_thread($rss_feed['FID'], $rss_feed['UID'], $rss_title);

                    post_create($rss_feed['FID'], $tid, 0, $rss_feed['UID'], array(), $rss_content);

                    rss_feed_create_history($rss_feed['RSSID'], $rss_feed_item->link);
                }
            }
        }
    }
}

function rss_feed_get_feeds($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $rss_feed_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS RSS_FEEDS.RSSID, RSS_FEEDS.NAME, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, RSS_FEEDS.FID, RSS_FEEDS.URL, ";
    $sql .= "RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY, RSS_FEEDS.MAX_ITEM_COUNT ";
    $sql .= "FROM `{$table_prefix}RSS_FEEDS` RSS_FEEDS ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = RSS_FEEDS.UID ";
    $sql .= "AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($rss_feed_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($rss_feed_count > 0) && ($page > 1)) {
        return rss_feed_get_feeds($page - 1);
    }

    while (($rss_feed_data = $result->fetch_assoc()) !== null) {

        if (isset($rss_feed_data['LOGON']) && isset($rss_feed_data['PEER_NICKNAME'])) {
            if (!is_null($rss_feed_data['PEER_NICKNAME']) && strlen($rss_feed_data['PEER_NICKNAME']) > 0) {
                $rss_feed_data['NICKNAME'] = $rss_feed_data['PEER_NICKNAME'];
            }
        }

        if (!isset($rss_feed_data['LOGON'])) $rss_feed_data['LOGON'] = gettext("Unknown user");
        if (!isset($rss_feed_data['NICKNAME'])) $rss_feed_data['NICKNAME'] = "";

        $rss_feed_array[] = $rss_feed_data;
    }

    return array(
        'rss_feed_array' => $rss_feed_array,
        'rss_feed_count' => $rss_feed_count
    );
}

function rss_feed_add($name, $uid, $fid, $url, $prefix, $frequency, $max_item_count)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;
    if (!is_numeric($max_item_count)) return false;

    $name = $db->escape($name);
    $url = $db->escape($url);
    $prefix = $db->escape($prefix);

    $last_run_datetime = date(MYSQL_DATETIME, mktime(0, 0, 0, 6, 27, 2002));

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}RSS_FEEDS` (NAME, UID, FID, URL, PREFIX, FREQUENCY, LAST_RUN, MAX_ITEM_COUNT) ";
    $sql .= "VALUES ('$name', $uid, $fid, '$url', '$prefix', $frequency, CAST('$last_run_datetime' AS DATETIME), $max_item_count)";

    if (!$db->query($sql)) return false;

    return true;
}

function rss_feed_update($rssid, $name, $uid, $fid, $url, $prefix, $frequency, $max_item_count)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($rssid)) return false;
    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;
    if (!is_numeric($max_item_count)) return false;

    $name = $db->escape($name);
    $url = $db->escape($url);
    $prefix = $db->escape($prefix);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}RSS_FEEDS` SET NAME = '$name', ";
    $sql .= "UID = '$uid', FID = '$fid', URL = '$url', PREFIX = '$prefix', ";
    $sql .= "FREQUENCY = '$frequency', MAX_ITEM_COUNT = '$max_item_count' ";
    $sql .= "WHERE RSSID = '$rssid'";

    if (!$db->query($sql)) return false;

    return true;
}

function rss_feed_get($feed_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($feed_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT RSS_FEEDS.RSSID, RSS_FEEDS.NAME, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, RSS_FEEDS.FID, RSS_FEEDS.URL, ";
    $sql .= "RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY, RSS_FEEDS.MAX_ITEM_COUNT ";
    $sql .= "FROM `{$table_prefix}RSS_FEEDS` RSS_FEEDS ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = RSS_FEEDS.UID ";
    $sql .= "AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE RSS_FEEDS.RSSID = '$feed_id'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $rss_feed_array = $result->fetch_assoc();

    if (isset($rss_feed_array['LOGON']) && isset($rss_feed_array['PEER_NICKNAME'])) {
        if (!is_null($rss_feed_array['PEER_NICKNAME']) && strlen($rss_feed_array['PEER_NICKNAME']) > 0) {
            $rss_feed_array['NICKNAME'] = $rss_feed_array['PEER_NICKNAME'];
        }
    }

    if (!isset($rss_feed_array['LOGON'])) $rss_feed_array['LOGON'] = gettext("Unknown user");
    if (!isset($rss_feed_array['NICKNAME'])) $rss_feed_array['NICKNAME'] = "";

    return $rss_feed_array;
}

function rss_feed_remove($rssid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($rssid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}RSS_FEEDS` WHERE RSSID = '$rssid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}