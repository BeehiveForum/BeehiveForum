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

/* $Id: get_attachment.php,v 1.3 2005-01-30 00:23:31 decoyduck Exp $ */

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once("./include/attachments.inc.php");
include_once("./include/db.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (forum_get_setting('attachments_enabled', 'N', false)) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (forum_get_setting('attachment_use_old_method', 'Y', false)) {

    if (isset($_GET['hash'])) {

        $hash = $_GET['hash'];
    }

}else {

    if (strstr($_SERVER['PHP_SELF'], 'get_attachment.php')) {

        if (preg_match("/\/get_attachment.php\/([A-Fa-f0-9]{32})\/(.*)$/", $_SERVER['PHP_SELF'], $attachment_data)) {
            $hash = $attachment_data[1];
        }

    }else {

        if (preg_match("/\/([A-Fa-f0-9]{32})\/(.*)$/", $_SERVER['PHP_SELF'], $attachment_data)) {
            $hash = $attachment_data[1];
        }
    }
}

if (isset($hash) && is_md5($hash)) {

    // Increment the 'Downloaded x times tooltip text'
    attachment_inc_dload_count($hash);

    if ($attachmentdetails = get_attachment_by_hash($hash)) {

        // Use these quite a few times, so assign them to variables to save some time.

        $filepath = forum_get_setting('attachment_dir'). '/'. $attachmentdetails['HASH'];
        $filename = rawurldecode(basename($attachmentdetails['FILENAME']));

        if (@file_exists($filepath)) {

            // Filesize for Content-Length header.

            $length = filesize($filepath);

            // Are we viewing or downloading the attachment?

            if (isset($_GET['download']) || strstr(@$_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
                header("Content-Type: application/x-ms-download", true);
            }else {
                header("Content-Type: ". $attachmentdetails['MIMETYPE'], true);
            }

            // Only do the cache control if we're not running
            // in PHP CGI Mode. We need to do this check as
            // we need to modify the HTTP Response header
            // which is not permitted under PHP CGI Mode.

            if (!strstr(php_sapi_name(), 'cgi')) {

                // Etag Header for cache control
                $local_etag  = md5(gmdate("D, d M Y H:i:s", filemtime($filepath)). " GMT");

                if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                    $remote_etag = substr(_stripslashes($_SERVER['HTTP_IF_NONE_MATCH']), 1, -1);
                }else {
                    $remote_etag = false;
                }

                // Last Modified Header for cache control
                $local_last_modified  = gmdate("D, d M Y H:i:s", filemtime($filepath)). " GMT";

                if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
                    $remote_last_modified = _stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                }else {
                    $remote_last_modified = false;
                }

                if (strcmp($remote_etag, $local_etag) == "0" || strcmp($remote_last_modified, $local_last_modified) == "0") {
                    header("HTTP/1.1 304 Not Modified");
                    exit;
                }

                header("Last-Modified: $local_last_modified", true);
                header("Etag: \"$local_etag\"", true);
            }

            header("Content-Length: $length", true);
            header("Content-disposition: inline; filename=\"$filename\"", true);
            readfile($filepath);
            exit;
        }
    }
}

html_draw_top();
echo "<h2>{$lang['attachmentproblem']}</h2>\n";
html_draw_bottom();

?>