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

/* $Id: get_attachment.php,v 1.17 2006-11-19 00:13:22 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

//Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check to see if attachments are actually enabled

if (forum_get_setting('attachments_enabled', 'N')) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further

if (!$attachment_dir = attachments_check_dir()) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

// Check to see which method we are using to fetch the attachment.
// The old method is to simply refer to the hash in the URL query
// i.e. get_attachment.php?hash=[MD5Hash] which although fine
// in it's own right creates complications with some browsers
// (mostly Netscape based ones) which prompt the user to download
// get_attachment.php rather than the filename specified in the
// HTTP headers. The newer and default method gets around this
// by fooling the browser into thinking it is downloading the
// file directly however this doesn't work with all webservers
// hence the option to disable it.

if (isset($_GET['hash']) && is_md5($_GET['hash'])) {

    $hash = $_GET['hash'];

}else {

    if (strstr($_SERVER['PHP_SELF'], 'get_attachment.php')) {

        if (preg_match("/\/get_attachment.php\/([A-Fa-f0-9]{32})\/(.*)$/", $_SERVER['PHP_SELF'], $attachment_data) > 0) {
            $hash = $attachment_data[1];
        }

    }else {

        if (preg_match("/\/([A-Fa-f0-9]{32})\/(.*)$/", $_SERVER['PHP_SELF'], $attachment_data) > 0) {
            $hash = $attachment_data[1];
        }
    }
}

if (isset($hash) && is_md5($hash)) {

    if ($attachment_details = get_attachment_by_hash($hash)) {

        // If we're requesting the thumbnail then we need to append
        //.thumb to the filepath. If we're getting the full image we
        // increase the view count by one.

        if (isset($_GET['thumb']) && $_GET['thumb'] == 1) {

            $filepath = "{$attachment_dir}/{$attachment_details['HASH']}.thumb";

        }else {

            attachment_inc_dload_count($hash);
            $filepath = "{$attachment_dir}/{$attachment_details['HASH']}";
        }

        // Use the filename quite a few times, so assign it to a variable to save some time.

        $filename = rawurldecode(basename($attachment_details['FILENAME']));

        if (@file_exists($filepath)) {

            // Filesize for Content-Length header.

            $length = filesize($filepath);

            // Are we viewing or downloading the attachment?

            if (isset($_GET['download']) || (isset($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS'))) {
                header("Content-Type: application/x-ms-download", true);
            }else {
                header("Content-Type: ". $attachment_details['MIMETYPE'], true);
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
                $local_last_modified  = gmdate("D, d M Y H:i:s", filemtime($filepath)). "GMT";

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