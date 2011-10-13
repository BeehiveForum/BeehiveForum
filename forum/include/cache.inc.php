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

/**
* cache.inc.php - cache functions
*
* Contains HTTP cache and PEAR CacheLite related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// Include files we need.
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

/**
* Prevent caching of a page.
*
* Prevents caching of a page by sending headers which indicate that the page
* is always modified.
*
* @return boolean
* @param void
*/

function cache_disable()
{
    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT", true);               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT", true);  // always modified
    header("Content-Type: text/html; charset=UTF-8", true);               // Internet Explorer Bug
    header("Cache-Control: no-store, private, no-cache, must-revalidate", true);   // HTTP/1.1
    header("Cache-Control: proxy-revalidate, post-check=0, pre-check=0", false);
    header("Cache-Control: max-age=0, s-maxage=0", false);
    header("Pragma: no-cache", true);

    return true;
}

/**
* cache_disable_aol
*
* Disable HTTP cache if AOL browser is detected.
*
* @param void
* @return void
*/
function cache_disable_aol()
{
    if (!browser_check(BROWSER_AOL)) return false;

    return cache_disable();
}

/**
* cache_disable_proxy
*
* Disable HTTP caching if a proxy server is detected.
*
* @param void
* @return void
*/
function cache_disable_proxy()
{
    $proxy_headers_array = get_proxy_cache_headers();

    foreach($proxy_headers_array as $proxy_header) {

        if (isset($_SERVER[$proxy_header]) && strlen(trim($_SERVER[$proxy_header])) > 0) {

            return cache_disable();
        }
    }

    return false;
}

/**
* Check cache of thread list
*
* Checks MODIFIED and LAST_READ_AT columns of THREAD and USER_THREAD
* tables to generate last modified HTTP header for caching of the
* thread list.
*
* @return mixed - boolean or no return (exit)
* @param void
*/

function cache_check_thread_list()
{
    if (!$db_thread_list_check_cache_header = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!cache_check_logon_hash()) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        cache_disable();
        return false;
    }

    if (($uid = session_get_value('UID')) === false) return false;

    // If we're looking at a specific folder add it's ID to the query.
    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        $folder = db_escape_string($_GET['folder']);

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD) AS THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql.= "FROM `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "WHERE FOLDER.FID = '$folder') AS FOLDER_DATA";

    } else {

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD) AS THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql.= "FROM `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER) AS FOLDER_DATA";
    }

    if (!$result = db_query($sql, $db_thread_list_check_cache_header)) return false;

    // Can't send cache headers without any rows.
    if (db_num_rows($result) == 0) return true;

    // Get the modified dates from the query
    list($created, $modified, $last_read, $folder_created, $folder_modified) = db_fetch_array($result, DB_RESULT_NUM);

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $modified, $last_read, $folder_created, $folder_modified);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);

        if (strtotime($remote_last_modified) >= $local_cache_date) {

            header("Expires: $local_cache_expires", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header_status(304, 'Not Modified');
            exit;
        }
    }

    header("Expires: $local_cache_expires", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

/**
* Check cache of start left pane
*
* Checks MODIFIED and LAST_LOGON columns of THREAD and VISITOR_LOG
* tables to generate last modified HTTP header for caching of
* start_left.php
*
* @return mixed - boolean or no return (exit)
* @param void
*/

function cache_check_start_page()
{
    if (!$db_forum_startpage_check_cache_header = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!cache_check_logon_hash()) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        cache_disable();
        return false;
    }

    if (($uid = session_get_value('UID')) === false) return false;

    // Get the thread, folder and user read last modified dates
    $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
    $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD) AS THREAD_DATA, ";
    $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
    $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
    $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
    $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER) AS FOLDER_DATA";

    if (!$result = db_query($sql, $db_forum_startpage_check_cache_header)) return false;

    if (db_num_rows($result) == 0) return true;

    // Get the modified dates from the query
    list($created, $modified, $last_read, $folder_created, $folder_modified) = db_fetch_array($result, DB_RESULT_NUM);

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $modified, $last_read, $folder_created, $folder_modified);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);

        if (strtotime($remote_last_modified) >= $local_cache_date) {

            header("Expires: $local_cache_expires", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header_status(304, 'Not Modified');
            exit;
        }
    }

    header("Expires: $local_cache_expires", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

/**
* Check cache of messages pane
*
* Checks CREATED and VOTED columns of POST and USER_POLL_VOTES
* tables to generate last modified HTTP header for caching of
* messages.php
*
* @return mixed - boolean or no return (exit)
* @param void
*/

function cache_check_messages()
{
    if (!$db_messages_check_cache_header = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!cache_check_logon_hash()) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;

    // Disable cache on these URL queries.
    if (isset($_GET['delete_success'])) return false;
    if (isset($_GET['edit_success'])) return false;
    if (isset($_GET['font_resize'])) return false;
    if (isset($_GET['markasread'])) return false;
    if (isset($_GET['post_approve_success'])) return false;
    if (isset($_GET['relupdated'])) return false;
    if (isset($_GET['setinterest'])) return false;
    if (isset($_GET['setstats'])) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        cache_disable();
        return false;
    }

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid) = explode('.', $_GET['msg']);

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(POST.CREATED)) AS CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(POST.VIEWED)) AS VIEWED, UNIX_TIMESTAMP(MAX(POST.APPROVED)) AS APPROVED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(POST.EDITED)) AS EDITED FROM `{$table_data['PREFIX']}POST` POST ";
        $sql.= "WHERE POST.TID = '$tid') AS POST_DATA, (SELECT UNIX_TIMESTAMP(MAX(USER_POLL_VOTES.VOTED)) ";
        $sql.= "AS POLL_VOTE FROM `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ";
        $sql.= "WHERE USER_POLL_VOTES.TID = '$tid') AS POLL_DATA";

    }else {

        $sql = "SELECT UNIX_TIMESTAMP(MAX(CREATED)) AS CREATED, ";
        $sql.= "0 AS VIEWED, 0 AS APPROVED, 0 AS EDITED, 0 AS POLL_VOTE ";
        $sql.= "FROM `{$table_data['PREFIX']}POST`";
    }

    if (!$result = db_query($sql, $db_messages_check_cache_header)) return false;

    if (db_num_rows($result) == 0) return true;

    // Get the two modified dates from the query
    list($created, $viewed, $approved, $edited, $voted) = db_fetch_array($result, DB_RESULT_NUM);

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $viewed, $approved, $edited, $voted);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);

        if (strtotime($remote_last_modified) >= $local_cache_date) {

            header("Expires: $local_cache_expires", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header_status(304, 'Not Modified');
            exit;
        }
    }

    header("Expires: $local_cache_expires", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

/**
* Check cache cookie
*
* Checks cache cookie (hash of the LOGON) so we can cache pages
* on a per-user account basis.
*
* @return mixed - boolean or no return (exit)
* @param void
*/

function cache_check_logon_hash()
{
    $logon_hash_check = md5(session_get_value('LOGON'));

    if (($logon_hash = html_get_cookie('cache_hash', 'strlen', ''))) {
        if ($logon_hash === $logon_hash_check) return true;
    }

    html_set_cookie('cache_hash', $logon_hash_check);
    return false;
}

/**
* Check cache config var
*
* Checks the cache config var in config.inc.php to see if the cache
* has been forcefully disabled.
*
* @return mixed
* @param void
*/

function cache_check_enabled()
{
    $http_cache_enabled = (isset($GLOBALS['http_cache_enabled'])) ? $GLOBALS['http_cache_enabled'] : false;

    if (isset($http_cache_enabled) && $http_cache_enabled === false) {
        return false;
    }

    return true;
}

/**
* Check cache header.
*
* Checks appropriate HTTP headers for cache hits. Prevents client
* from hitting pages already in cache. Default cache is 5 minutes.
*
* @return mixed - void or no return (exit)
* @param string $seconds - Interval to check for cache (default: 5 minutes)
*/

function cache_check_last_modified($seconds = 300)
{
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') return false;

    if (!is_numeric($seconds)) return false;

    if (browser_check(BROWSER_AOL)) return false;

    // Generate our last-modified and expires date stamps
    $local_last_modified = gmdate("D, d M Y H:i:s", time()). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", time()). " GMT";

    // Check to see if the cache header exists.
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);

        // Check to see if the cache is older than 5 minutes.
        if ((time() - strtotime($remote_last_modified)) < $seconds) {

            header("Expires: $local_cache_expires", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header_status(304, 'Not Modified');
            exit;
        }
    }

    header("Expires: $local_cache_expires", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

/**
* Check cache etag header.
*
* Checks appropriate HTTP etag header for cache hits.
*
* @return mixed - void or no return (exit)
* @param string $local_etag - ETag for comparison
*/

function cache_check_etag($local_etag)
{
    if (browser_check(BROWSER_AOL)) return false;

    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && strlen(trim($_SERVER['HTTP_IF_NONE_MATCH'])) > 0) {
        $remote_etag = mb_substr(stripslashes_array($_SERVER['HTTP_IF_NONE_MATCH']), 1, -1);
    }else {
        $remote_etag = false;
    }

    if (strcmp($remote_etag, $local_etag) == "0") {

        header_status(304, 'Not Modified');
        header("Etag: \"$local_etag\"");
        exit;
    }

    header("Etag: \"$local_etag\"", true);
    return true;
}

?>