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

/* $Id: rss_feed.inc.php,v 1.66 2008-11-03 21:26:38 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

class rss_item
{
    private $title;
    private $link;
    private $description;
    private $pubDate;

    function rss_item($aa)
    {
        foreach ($aa as $key => $value) {
            $this->$key = $value;
        }
    }
}

function rss_read_stream($filename)
{
    // Try and use PHP's own fopen wrapper to save us
    // having to do our own HTTP connection.

    if (($rss_data = @file($filename))) {
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

    if (($fp = @fsockopen($url_array['host'], $url_array['port'], $errno, $errstr, 30))) {

        @socket_set_timeout($fp, 2);
        @socket_set_blocking($fp, false);

        $header = "GET {$url_array['path']}{$url_array['query']} HTTP/1.0\r\n";
        $header.= "Host: {$url_array['host']}\r\n";
        $header.= "Connection: Close\r\n\r\n";

        $reply_data = "";

        fwrite($fp, $header);

        while (!feof($fp)) {
            $reply_data.= fgets($fp, 128);
        }

        fclose($fp);

        // Split the header from the data (seperated by \r\n\r\n)

        if (($data_array = preg_split("/\r\n\r\n/u", $reply_data, 2))) {

            return $data_array[1];
        }
    }

    return false;
}

function rss_read_database($filename)
{
   if (!$data = rss_read_stream($filename)) return false;

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

           for ($i = 0; $i < count($ranges); $i+=2) {

               if (isset($ranges[$i]) && isset($ranges[$i + 1])) {

                   $offset = $ranges[$i] + 1;
                   $len = $ranges[$i + 1] - $offset;
                   $rss_data[] = rss_parse_item(array_slice($values, $offset, $len));
               }
           }

       }else {

           continue;
       }
   }

   return $rss_data;
}

function rss_parse_item($ivalues)
{
   for ($i = 0; $i < count($ivalues); $i++) {

       if (isset($ivalues[$i]["value"])) {
           $item[$ivalues[$i]["tag"]] = $ivalues[$i]["value"];
       }else {
           $item[$ivalues[$i]["tag"]] = " ";
       }
   }

   return new rss_item($item);
}

function rss_fetch_feed()
{
    if (!$db_fetch_rss_feed = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT RSS_FEEDS.RSSID, RSS_FEEDS.NAME, RSS_FEEDS.UID, RSS_FEEDS.FID, ";
    $sql.= "RSS_FEEDS.URL, RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY, RSS_FEEDS.LAST_RUN ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_FEEDS RSS_FEEDS ";
    $sql.= "LEFT JOIN USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql.= "WHERE NOW() >= DATE_ADD(RSS_FEEDS.LAST_RUN, INTERVAL ";
    $sql.= "RSS_FEEDS.FREQUENCY MINUTE) AND RSS_FEEDS.FREQUENCY > 0 ";
    $sql.= "AND USER.UID IS NOT NULL LIMIT 0, 1";

    if (!$result = db_query($sql, $db_fetch_rss_feed)) return false;

    if (db_num_rows($result) > 0) {

        $rss_feed = db_fetch_array($result, DB_RESULT_ASSOC);

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}RSS_FEEDS SET LAST_RUN = NOW() ";
        $sql.= "WHERE RSSID = {$rss_feed['RSSID']} AND LAST_RUN = '{$rss_feed['LAST_RUN']}'";

        if (!$result = db_query($sql, $db_fetch_rss_feed)) return false;

        if (db_affected_rows($db_fetch_rss_feed) > 0) {

            return $rss_feed;
        }
    }

    return false;
}

function rss_thread_exist($rss_id, $link)
{
    if (!$db_rss_thread_exist = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($rss_id)) return false;

    $link = db_escape_string($link);

    $sql = "SELECT COUNT(RSSID) AS RSS_THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_HISTORY ";
    $sql.= "WHERE RSSID = '$rss_id' AND LINK = '$link'";

    if (!$result = db_query($sql, $db_rss_thread_exist)) return false;

    list($rss_thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($rss_thread_count > 0);
}

function rss_create_history($rss_id, $link)
{
    if (!$db_rss_create_history = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($rss_id)) return false;

    $link = db_escape_string($link);

    $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}RSS_HISTORY (RSSID, LINK) ";
    $sql.= "VALUES ($rss_id, '$link')";

    if (!db_query($sql, $db_rss_create_history)) return false;

    return true;
}

function rss_check_feeds()
{
    $lang = load_language_file();

    $item_count = 0;

    if (($rss_feed = rss_fetch_feed())) {

        if (($rss_data = rss_read_database($rss_feed['URL']))) {

            foreach ($rss_data as $rss_item) {

                if (!rss_thread_exist($rss_feed['RSSID'], $rss_item->link)) {

                    $rss_title = htmlentities_array(strip_tags($rss_item->title));

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

                        $rss_title.= " ...";
                    }

                    if (strlen($rss_item->description) > 1) {

                        $rss_item_description = htmlentities_array_decode($rss_item->description);

                        $rss_item_post = new MessageText(true, $rss_item_description);
                        $rss_item_post->setHTML(POST_HTML_AUTO);

                        $rss_content = $rss_item_post->getContent();

                        $rss_content = fix_html("<quote source=\"$rss_quote_source\" url=\"{$rss_item->link}\">$rss_content</quote>");

                    }else {

                        $rss_content = fix_html("<p>$rss_quote_source</p>\n<p><a href=\"{$rss_item->link}\" target=\"_blank\">{$lang['rssclicktoreadarticle']}</a></p>");
                    }

                    $tid = post_create_thread($rss_feed['FID'], $rss_feed['UID'], $rss_title);

                    post_create($rss_feed['FID'], $tid, 0, $rss_feed['UID'], 0, $rss_content, true);

                    rss_create_history($rss_feed['RSSID'], $rss_item->link);
                }

                $item_count++;
                if ($item_count == 10) break;
            }
        }
    }
}

function rss_get_feeds($offset)
{
    if (!$db_rss_get_feeds = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $rss_feed_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS RSS_FEEDS.RSSID, RSS_FEEDS.NAME, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, RSS_FEEDS.FID, ";
    $sql.= "RSS_FEEDS.URL, RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_FEEDS RSS_FEEDS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = RSS_FEEDS.UID ";
    $sql.= "AND USER_PEER.UID = '$uid') ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_rss_get_feeds)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_rss_get_feeds)) return false;

    list($rss_feed_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($rss_feed_data = db_fetch_array($result))) {

            if (isset($rss_feed_data['LOGON']) && isset($rss_feed_data['PEER_NICKNAME'])) {
                if (!is_null($rss_feed_data['PEER_NICKNAME']) && strlen($rss_feed_data['PEER_NICKNAME']) > 0) {
                    $rss_feed_data['NICKNAME'] = $rss_feed_data['PEER_NICKNAME'];
                }
            }

            if (!isset($rss_feed_data['LOGON'])) $rss_feed_data['LOGON'] = $lang['unknownuser'];
            if (!isset($rss_feed_data['NICKNAME'])) $rss_feed_data['NICKNAME'] = "";

            $rss_feed_array[] = $rss_feed_data;
        }

    }else if ($rss_feed_count > 0) {

        $offset = floor(($rss_feed_count - 1) / 10) * 10;
        return rss_get_feeds($offset);
    }

    return array('rss_feed_array' => $rss_feed_array,
                 'rss_feed_count' => $rss_feed_count);
}

function rss_add_feed($name, $uid, $fid, $url, $prefix, $frequency)
{
    if (!$db_rss_add_feed = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;

    $name = db_escape_string($name);
    $url = db_escape_string($url);
    $prefix = db_escape_string($prefix);

    $last_run = mktime(0, 0, 0, 6, 27, 2002);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}RSS_FEEDS (NAME, UID, FID, URL, PREFIX, FREQUENCY, LAST_RUN) ";
    $sql.= "VALUES ('$name', $uid, $fid, '$url', '$prefix', $frequency, FROM_UNIXTIME($last_run))";

    if (!db_query($sql, $db_rss_add_feed)) return false;

    return true;
}

function rss_feed_update($rssid, $name, $uid, $fid, $url, $prefix, $frequency)
{
    if (!$db_rss_feed_update = db_connect()) return false;

    if (!is_numeric($rssid)) return false;
    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;

    $name = db_escape_string($name);
    $url = db_escape_string($url);
    $prefix = db_escape_string($prefix);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}RSS_FEEDS SET NAME = '$name', UID = '$uid', ";
    $sql.= "FID = '$fid', URL = '$url', PREFIX = '$prefix', FREQUENCY = '$frequency' ";
    $sql.= "WHERE RSSID = '$rssid'";

    if (!db_query($sql, $db_rss_feed_update)) return false;

    return true;
}

function rss_get_feed($feed_id)
{
    if (!$db_rss_get_feeds = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($feed_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT RSS_FEEDS.RSSID, RSS_FEEDS.NAME, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, RSS_FEEDS.FID, ";
    $sql.= "RSS_FEEDS.URL, RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_FEEDS RSS_FEEDS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = RSS_FEEDS.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = RSS_FEEDS.UID ";
    $sql.= "AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE RSS_FEEDS.RSSID = '$feed_id'";

    if (!$result = db_query($sql, $db_rss_get_feeds)) return false;

    if (db_num_rows($result) > 0) {

        $rss_feed_array = db_fetch_array($result);

        if (isset($rss_feed_array['LOGON']) && isset($rss_feed_array['PEER_NICKNAME'])) {
            if (!is_null($rss_feed_array['PEER_NICKNAME']) && strlen($rss_feed_array['PEER_NICKNAME']) > 0) {
                $rss_feed_array['NICKNAME'] = $rss_feed_array['PEER_NICKNAME'];
            }
        }

        if (!isset($rss_feed_array['LOGON'])) $rss_feed_array['LOGON'] = $lang['unknownuser'];
        if (!isset($rss_feed_array['NICKNAME'])) $rss_feed_array['NICKNAME'] = "";

        return $rss_feed_array;
    }

    return false;
}

function rss_remove_feed($rssid)
{
    if (!$db_rss_remove_feed = db_connect()) return false;

    if (!is_numeric($rssid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM {$table_data['PREFIX']}RSS_FEEDS WHERE RSSID = '$rssid'";

    if (!db_query($sql, $db_rss_remove_feed)) return false;

    return (db_affected_rows($db_rss_remove_feed) > 0);
}

?>