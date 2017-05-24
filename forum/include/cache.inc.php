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
require_once BH_INCLUDE_PATH . 'browser.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
// End Required includes

function cache_disable()
{
    if (headers_sent()) return false;

    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Content-Type: text/html; charset=UTF-8");
    header("Cache-Control: no-store, private, no-cache, must-revalidate");
    header("Cache-Control: proxy-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: max-age=0, s-maxage=0");
    header("Pragma: no-cache");

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

function cache_check_enabled()
{
    $config = server_get_config();

    if (isset($config['http_cache_enabled']) && $config['http_cache_enabled'] === false) {
        return false;
    }

    return true;
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        $folder = $db->escape(intval($_GET['folder']));

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql .= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql .= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
        $sql .= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql .= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
        $sql .= "WHERE USER_THREAD.UID = '{$_SESSION['UID']}') AS USER_THREAD_DATA, ";
        $sql .= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql .= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "WHERE FOLDER.FID = '$folder') AS FOLDER_DATA";

    } else {

        $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
        $sql .= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
        $sql .= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
        $sql .= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
        $sql .= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
        $sql .= "WHERE USER_THREAD.UID = '{$_SESSION['UID']}') AS USER_THREAD_DATA, ";
        $sql .= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
        $sql .= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
        $sql .= "FROM `{$table_prefix}FOLDER` FOLDER) AS FOLDER_DATA";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return true;

    list($created, $modified, $last_read, $folder_created, $folder_modified) = $result->fetch_row();

    $last_modified = max($created, $modified, $last_read, $folder_created, $folder_modified);

    $etag = md5($_SESSION['UID'] . $_SESSION['LOGON']);

    return cache_check_last_modified($last_modified, $etag);
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

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT * FROM (SELECT UNIX_TIMESTAMP(MAX(THREAD.CREATED)) AS CREATED, ";
    $sql .= "UNIX_TIMESTAMP(MAX(THREAD.MODIFIED)) AS MODIFIED ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD) AS THREAD_DATA, ";
    $sql .= "(SELECT UNIX_TIMESTAMP(MAX(USER_THREAD.LAST_READ_AT)) AS LAST_READ ";
    $sql .= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "WHERE USER_THREAD.UID = '{$_SESSION['UID']}') AS USER_THREAD_DATA, ";
    $sql .= "(SELECT UNIX_TIMESTAMP(MAX(FOLDER.CREATED)) AS FOLDER_CREATED, ";
    $sql .= "UNIX_TIMESTAMP(MAX(FOLDER.MODIFIED)) AS FOLDER_MODIFIED ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER) AS FOLDER_DATA";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return true;

    list($created, $modified, $last_read, $folder_created, $folder_modified) = $result->fetch_row();

    $last_modified = max($created, $modified, $last_read, $folder_created, $folder_modified);

    $etag = md5($_SESSION['UID'] . $_SESSION['LOGON']);

    return cache_check_last_modified($last_modified, $etag);
}

function cache_check_messages()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!cache_check_enabled()) return false;

    if (browser_check(BROWSER_AOL)) return false;

    if (headers_sent()) return false;

    if (isset($_GET['post_success'])) return false;
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
        $sql .= "UNIX_TIMESTAMP(MAX(POST_RECIPIENT.VIEWED)) AS VIEWED, UNIX_TIMESTAMP(MAX(POST.APPROVED)) AS APPROVED, ";
        $sql .= "UNIX_TIMESTAMP(MAX(POST.EDITED)) AS EDITED FROM `{$table_prefix}POST` POST ";
        $sql .= "LEFT JOIN `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT ";
        $sql .= "ON (POST_RECIPIENT.TID = POST.TID AND POST_RECIPIENT.PID = POST.PID) ";
        $sql .= "WHERE POST.TID = '$tid') AS POST_DATA, (SELECT UNIX_TIMESTAMP(MAX(USER_POLL_VOTES.VOTED)) ";
        $sql .= "AS POLL_VOTE FROM `{$table_prefix}USER_POLL_VOTES` USER_POLL_VOTES ";
        $sql .= "WHERE USER_POLL_VOTES.TID = '$tid') AS POLL_DATA";

    } else {

        $sql = "SELECT UNIX_TIMESTAMP(MAX(CREATED)) AS CREATED, ";
        $sql .= "0 AS VIEWED, 0 AS APPROVED, 0 AS EDITED, 0 AS POLL_VOTE ";
        $sql .= "FROM `{$table_prefix}POST`";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return true;

    list($created, $viewed, $approved, $edited, $voted) = $result->fetch_row();

    $last_modified = max($created, $viewed, $approved, $edited, $voted);

    $etag = md5($_SESSION['UID'] . $_SESSION['LOGON']);

    return cache_check_last_modified($last_modified, $etag);
}

function cache_check_request_throttle($amount)
{
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') return false;

    if (browser_check(BROWSER_AOL)) return false;

    if (headers_sent()) return false;

    $request = get_request_uri();

    if (isset($_SESSION['THROTTLE'][$request]) && ($_SESSION['THROTTLE'][$request] > time())) {
        $throttle_timestamp = $_SESSION['THROTTLE'][$request];
    } else {
        $throttle_timestamp = time() + $amount;
    }

    $_SESSION['THROTTLE'][$request] = $throttle_timestamp;

    $etag = md5($_SESSION['UID'] . $_SESSION['LOGON']);

    return cache_check_last_modified($throttle_timestamp, $etag, time() + $amount);
}

function cache_check_last_modified($last_modified, $etag, $expires = null)
{
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') return false;

    if (browser_check(BROWSER_AOL)) return false;

    if (headers_sent()) return false;

    $cache_expires = gmdate("D, d M Y H:i:s", is_numeric($expires) ? $expires : $last_modified) . " GMT";

    $last_modified = gmdate("D, d M Y H:i:s", $last_modified) . " GMT";

    $remote_last_modified = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : null;

    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && preg_match('/^W\/"([^"]+)"/', $_SERVER['HTTP_IF_NONE_MATCH'], $matches_array)) {
        $remote_etag = isset($matches_array[1]) ? $matches_array[1] : false;
    } else {
        $remote_etag = false;
    }

    if (($remote_etag == $etag) && ($remote_last_modified == $last_modified)) {

        header("Etag: W/\"$remote_etag\"", true);
        header("Expires: $cache_expires", true);
        header("Last-Modified: $remote_last_modified", true);
        header('Cache-Control: private, must-revalidate', true);

        header_status(304, 'Not Modified');
        exit;
    }

    header("Etag: W/\"$etag\"", true);
    header("Expires: $cache_expires", true);
    header("Last-Modified: $last_modified", true);
    header('Cache-Control: private, must-revalidate', true);

    return true;
}