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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// Include files we need.
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';

function cache_disable()
{
    if (headers_sent()) return false;
    
    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT", true);               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT", true);  // always modified
    header("Content-Type: text/html; charset=UTF-8", true);               // Internet Explorer Bug
    header("Cache-Control: no-store, private, no-cache, must-revalidate", true);   // HTTP/1.1
    header("Cache-Control: proxy-revalidate, post-check=0, pre-check=0", false);
    header("Cache-Control: max-age=0, s-maxage=0", false);
    header("Pragma: no-cache", true);

    return true;
}

function cache_disable_aol()
{
    if (!browser_check(BROWSER_AOL)) return false;

    return cache_disable();
}

function cache_disable_proxy()
{
    $proxy_headers_array = get_proxy_cache_headers();

    foreach ($proxy_headers_array as $proxy_header) {

        if (isset($_SERVER[$proxy_header]) && strlen(trim($_SERVER[$proxy_header])) > 0) {

            return cache_disable();
        }
    }

    return false;
}

function cache_check_thread_list()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;
    
    if (headers_sent()) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        cache_disable();
        return false;
    }

    if (($uid = session::get_value('UID')) === false) return false;

    // If we're looking at a specific folder add it's ID to the query.
    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        $folder = $db->escape($_GET['folder']);

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql.= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql.= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
        $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql.= "FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql.= "WHERE FOLDER.FID = '$folder') AS FOLDER_DATA";

    } else {

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql.= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql.= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
        $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
        $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql.= "FROM `{$table_prefix}FOLDER` FOLDER) AS FOLDER_DATA";
    }

    if (!$result = $db->query($sql)) return false;

    // Can't send cache headers without any rows.
    if ($result->num_rows == 0) return true;

    // Get the modified dates from the query
    list($created, $modified, $last_read, $folder_created, $folder_modified) = $result->fetch_row();

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $modified, $last_read, $folder_created, $folder_modified);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = $_SERVER['HTTP_IF_MODIFIED_SINCE'];

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

function cache_check_start_page()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;
    
    if (headers_sent()) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        cache_disable();
        return false;
    }

    if (($uid = session::get_value('UID')) === false) return false;

    // Get the thread, folder and user read last modified dates
    $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
    $sql.= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
    $sql.= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
    $sql.= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
    $sql.= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql.= "WHERE USER_THREAD.UID = '$uid') AS USER_THREAD_DATA, ";
    $sql.= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
    $sql.= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER) AS FOLDER_DATA";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return true;

    // Get the modified dates from the query
    list($created, $modified, $last_read, $folder_created, $folder_modified) = $result->fetch_row();

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $modified, $last_read, $folder_created, $folder_modified);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = $_SERVER['HTTP_IF_MODIFIED_SINCE'];

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

function cache_check_messages()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;
    
    if (headers_sent()) return false;

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
        $sql.= "UNIX_TIMESTAMP(MAX(POST.EDITED)) AS EDITED FROM `{$table_prefix}POST` POST ";
        $sql.= "WHERE POST.TID = '$tid') AS POST_DATA, (SELECT UNIX_TIMESTAMP(MAX(USER_POLL_VOTES.VOTED)) ";
        $sql.= "AS POLL_VOTE FROM `{$table_prefix}USER_POLL_VOTES` USER_POLL_VOTES ";
        $sql.= "WHERE USER_POLL_VOTES.TID = '$tid') AS POLL_DATA";

    } else {

        $sql = "SELECT UNIX_TIMESTAMP(MAX(CREATED)) AS CREATED, ";
        $sql.= "0 AS VIEWED, 0 AS APPROVED, 0 AS EDITED, 0 AS POLL_VOTE ";
        $sql.= "FROM `{$table_prefix}POST`";
    }

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return true;

    // Get the two modified dates from the query
    list($created, $viewed, $approved, $edited, $voted) = $result->fetch_row();

    // Work out which one is newer (higher).
    $local_cache_date = max($created, $viewed, $approved, $edited, $voted);

    // Last Modified Header for cache control
    $local_last_modified = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", $local_cache_date). " GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = $_SERVER['HTTP_IF_MODIFIED_SINCE'];

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

function cache_check_enabled()
{
    if (defined('BEEHIVE_DEVELOPER_MODE')) return false;
    
    $config = server_get_config();
    
    if (isset($config['http_cache_enabled']) && $config['http_cache_enabled'] === false) {
        return false;
    }

    return true;
}

function cache_check_last_modified($last_modified)
{
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') return false;

    if (browser_check(BROWSER_AOL)) return false;
    
    if (headers_sent()) return false;

    $local_last_modified = gmdate("D, d M Y H:i:s", $last_modified). "GMT";

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {

        $remote_last_modified = $_SERVER['HTTP_IF_MODIFIED_SINCE'];

        if (strtotime($remote_last_modified) >= $last_modified) {

            header("Expires: $local_last_modified", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header_status(304, 'Not Modified');
            exit;
        }
    }

    header("Expires: $local_last_modified", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

function cache_check_etag($local_etag)
{
    if (browser_check(BROWSER_AOL)) return false;
    
    if (headers_sent()) return false;

    $local_last_modified = gmdate("D, d M Y H:i:s", time()). "GMT";

    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && strlen(trim($_SERVER['HTTP_IF_NONE_MATCH'])) > 0) {
        $remote_etag = mb_substr($_SERVER['HTTP_IF_NONE_MATCH'], 1, -1);
    } else {
        $remote_etag = false;
    }

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {
        $remote_last_modified = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    } else {
        $remote_last_modified = false;
    }

    $local_last_modified  = gmdate("D, d M Y H:i:s", time()). "GMT";

    if (strcmp($remote_etag, $local_etag) == 0) {

        header("Etag: \"$remote_etag\"", true);
        header("Expires: $local_last_modified", true);
        header("Last-Modified: $remote_last_modified", true);
        header('Cache-Control: private, must-revalidate', true);

        header_status(304, 'Not Modified');
        exit;
    }

    header("Etag: \"$local_etag\"", true);
    header("Expires: $local_last_modified", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}

?>