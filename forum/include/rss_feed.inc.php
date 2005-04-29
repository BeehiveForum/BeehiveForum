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

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");

class rss_item
{
    var $title;
    var $link;
    var $description;
    var $pubDate;

    function rss_item($aa)
    {
        foreach ($aa as $key => $value) {
            $this->$key = $value;
        }
    }
}

function rss_read_stream($filename)
{
    $url_array = parse_url($filename);

    // We only do HTTP

    if (!isset($url_array['host'])) return false;
    if (!isset($url_array['scheme']) || $url_array['scheme'] != 'http') return false;

    // We don't do HTTP authentication.

    if (isset($url_array['user'])) return false;
    if (isset($url_array['pass'])) return false;

    // If we don't have a port we'll assume port 80

    if (!isset($url_array['port'])) $url_array['port'] = 80;
    if (!isset($url_array['query'])) $url_array['query'] = "";

    if (strlen($url_array['query']) > 0) {
        $url_array['query'] = "?{$url_array['query']}";
    }

    // We can't do much without socket functions

    if ($fp = @fsockopen($url_array['host'], $url_array['port'], $errno, $errstr, 30)) {

        $http_headers = "GET {$url_array['path']}{$url_array['query']} HTTP/1.1\r\n";
        $http_headers.= "Host: {$url_array['host']}\r\n";
        $http_headers.= "Accept-Charset: UTF-8\r\n";
        $http_headers.= "Connection: Close\r\n\r\n";

        $http_data = "";

        fwrite($fp, $http_headers);

        while (!feof($fp)) {
            $http_data.= fgets($fp, 1024);
        }

        fclose($fp);

        if ($http_data_array = preg_split("/\<\?xml/", $http_data)) {

            if (isset($http_data_array[1])) {

                return "<?xml{$http_data_array[1]}";
            }
        }
    }

    return false;
}

function rss_read_database($filename)
{
   if (!$data = rss_read_stream($filename)) return false;

   $data = preg_replace("/(&[^;]+;)/me", "xml_literal_to_numeric('\\1')", $data);

   $rss_data = array();

   $parser = xml_parser_create();

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

       $item[$ivalues[$i]["tag"]] = $ivalues[$i]["value"];
   }

   return new rss_item($item);
}

function rss_fetch_feed()
{
    $db_fetch_rss_feed = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT RSSID, NAME, UID, FID, URL, PREFIX, FREQUENCY, LAST_RUN ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_FEEDS RSS_FEEDS ";
    $sql.= "WHERE NOW() >= DATE_ADD(RSS_FEEDS.LAST_RUN, INTERVAL ";
    $sql.= "RSS_FEEDS.FREQUENCY MINUTE) LIMIT 0, 1";

    $result = db_query($sql, $db_fetch_rss_feed);

    if (db_num_rows($result) > 0) {

        $rss_feed = db_fetch_array($result, DB_RESULT_ASSOC);

        $sql = "UPDATE {$table_data['PREFIX']}RSS_FEEDS SET LAST_RUN = NOW() ";
        $sql.= "WHERE RSSID = {$rss_feed['RSSID']} AND LAST_RUN = '{$rss_feed['LAST_RUN']}'";

        $result = db_query($sql, $db_fetch_rss_feed);

        if (db_affected_rows($db_fetch_rss_feed) > 0) {

            return $rss_feed;
        }
    }

    return false;
}

function rss_thread_exist($rss_id, $link)
{
    $db_rss_thread_exist = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($rss_id)) return false;

    $link = addslashes($link);

    $sql = "SELECT * FROM {$table_data['PREFIX']}RSS_HISTORY ";
    $sql.= "WHERE RSSID = $rss_id AND LINK = '$link'";

    $result = db_query($sql, $db_rss_thread_exist);

    return (db_num_rows($result) > 0);
}

function rss_create_history($rss_id, $link)
{
    $db_rss_create_history = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($rss_id)) return false;

    $link = addslashes($link);

    $sql = "INSERT INTO {$table_data['PREFIX']}RSS_HISTORY (RSSID, LINK) ";
    $sql.= "VALUES ($rss_id, '$link')";

    return db_query($sql, $db_rss_create_history);
}

function rss_check_feeds()
{
    $lang = load_language_file();

    if ($rss_feed = rss_fetch_feed()) {

        if ($rss_data = rss_read_database($rss_feed['URL'])) {

            foreach($rss_data as $rss_item) {

                if (!rss_thread_exist($rss_feed['RSSID'], $rss_item->link)) {

                    $rss_title   = ms_word_to_html(trim(_htmlentities_decode($rss_item->title)));
                    $rss_content = ms_word_to_html(trim(_htmlentities_decode($rss_item->description)));

                    if (strlen($rss_content) > 1) {
                        $content = fix_html("<quote source=\"{$rss_feed['NAME']}\" url=\"{$rss_item->link}\">$rss_content</quote>");
                    }else {
                        $content = fix_html("<p>$rss_title</p>\n<p><a href=\"{$rss_item->link}\" target=\"_blank\">{$lang['rssclicktoreadarticle']}</a></p>");
                    }

                    $tid = post_create_thread($rss_feed['FID'], $rss_feed['UID'], "[{$rss_feed['PREFIX']}] {$rss_title}");

                    post_create($rss_feed['FID'], $tid, 0, $rss_feed['UID'], $rss_feed['UID'], 0, $content);

                    rss_create_history($rss_feed['RSSID'], $rss_item->link);
                }
            }
        }
    }
}

function rss_get_feeds()
{
    $db_rss_get_feeds = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT RSS_FEEDS.RSSID, RSS_FEEDS.NAME, USER.LOGON, ";
    $sql.= "RSS_FEEDS.FID, RSS_FEEDS.URL, RSS_FEEDS.PREFIX, RSS_FEEDS.FREQUENCY ";
    $sql.= "FROM {$table_data['PREFIX']}RSS_FEEDS RSS_FEEDS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = RSS_FEEDS.UID)";

    $result = db_query($sql, $db_rss_get_feeds);

    if (db_num_rows($result) > 0) {

        $rss_feed_array = array();

        while($row = db_fetch_array($result)) {
            $rss_feed_array[] = $row;
        }

        return $rss_feed_array;
    }

    return false;
}

function rss_add_feed($name, $uid, $fid, $url, $prefix, $frequency)
{
    $db_rss_add_feed = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;

    $name = addslashes($name);
    $url = addslashes($url);
    $prefix = addslashes($prefix);

    $last_run = mktime() - (60 * ($frequency + 1));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}RSS_FEEDS (NAME, UID, FID, URL, PREFIX, FREQUENCY, LAST_RUN) ";
    $sql.= "VALUES ('$name', $uid, $fid, '$url', '$prefix', $frequency, FROM_UNIXTIME($last_run))";

    return db_query($sql, $db_rss_add_feed);
}

function rss_feed_update($rssid, $name, $uid, $fid, $url, $prefix, $frequency)
{
    $db_rss_feed_update = db_connect();

    if (!is_numeric($rssid)) return false;
    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($frequency)) return false;

    $name = addslashes($name);
    $url = addslashes($url);
    $prefix = addslashes($prefix);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}RSS_FEEDS SET NAME = '$name', UID = $uid, ";
    $sql.= "FID = $fid, URL = '$url', PREFIX = '$prefix', FREQUENCY = $frequency ";
    $sql.= "WHERE RSSID = $rssid";

    return db_query($sql, $db_rss_feed_update);
}

function rss_remove_feed($rssid)
{
    $db_rss_remove_feed = db_connect();

    if (!is_numeric($rssid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}RSS_FEEDS WHERE RSSID = $rssid";
    return db_query($sql, $db_rss_remove_feed);
}

?>