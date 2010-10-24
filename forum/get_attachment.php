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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings
$forum_settings = forum_get_settings();

// Fetch Global Forum Settings
$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag
$webtag = get_webtag();

// Get the real path to the forum
$forum_path = preg_replace('/\/get_attachment\.php\/[A-Fa-f0-9]{32}/iu', "", html_get_forum_uri());

// Default to no redirect
$redirect = false;

// Get the attachment hash
$hash = attachments_get_url_query_hash($redirect);

// Check we're logged in correctly
if (!$user_sess = bh_session_check()) {
    $request_uri = "get_attachment.php%3Fwebtag%3D$webtag%26hash%3D$hash";
    header_redirect("$forum_path/logon.php?webtag=$webtag&final_uri=$request_uri");
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
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Check to see if attachments are actually enabled
if (forum_get_setting('attachments_enabled', 'N')) {

    html_draw_top();
    html_error_msg($lang['attachmentshavebeendisabled']);
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further
if (!$attachment_dir = attachments_check_dir()) {

    html_draw_top();
    html_error_msg($lang['attachmentshavebeendisabled']);
    html_draw_bottom();
    exit;
}

// Get the array of allowed attachment mime-types
$attachment_mime_types = attachments_get_mime_types();

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
if (isset($hash) && is_md5($hash)) {

    // Get the attachment details.
    if (($attachment_details = attachments_get_by_hash($hash))) {

        // If we're requesting an image attachment thumbnail then
        // we need to append .thumb to the filepath. If we're getting
        // the full image we increase the view count by one.
        if (isset($_GET['thumb']) && forum_get_setting('attachment_thumbnails', 'Y')) {

            $filepath = "{$attachment_dir}/{$attachment_details['hash']}.thumb";

        }else {

            if (!user_is_guest() || forum_get_setting('attachment_allow_guests', 'Y')) {

                // Construct the attachment filepath.
                $filepath = "{$attachment_dir}/{$attachment_details['hash']}";

                // Increment the view count only if the attachment
                // isn't being used as an avatar or profile picture.
                if (!isset($_GET['profile_picture']) && !isset($_GET['avatar_picture'])) {
                    attachments_inc_download_count($hash);
                }
            }
        }

        // Check the mimetype is allowed.
        if (sizeof($attachment_mime_types) == 0 || in_array($attachment_details['mimetype'], $attachment_mime_types)) {

            // Use the filename quite a few times, so assign it to a variable to save some time.
            $filename = rawurldecode(basename($attachment_details['filename']));

            // Check the filepath is set and exists.
            if (isset($filepath) && @file_exists($filepath)) {

                // Filesize for Content-Length header.
                $length = filesize($filepath);

                // Are we viewing or downloading the attachment?
                if (isset($_GET['download']) || (isset($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS'))) {
                    header("Content-Type: application/x-ms-download", true);
                }else {
                    header("Content-Type: ". $attachment_details['mimetype'], true);
                }

                // Only do the cache control if we're not running
                // in PHP CGI Mode. We need to do this check as
                // we need to modify the HTTP Response header
                // which is not permitted under PHP CGI Mode.
                if (preg_match('/cgi/u', php_sapi_name()) < 1) {

                    // Etag Header for cache control
                    $local_etag  = md5(gmdate("D, d M Y H:i:s", filemtime($filepath)). " GMT");

                    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && strlen(trim($_SERVER['HTTP_IF_NONE_MATCH'])) > 0) {
                        $remote_etag = mb_substr(stripslashes_array($_SERVER['HTTP_IF_NONE_MATCH']), 1, -1);
                    }else {
                        $remote_etag = false;
                    }

                    // Last Modified Header for cache control
                    $local_last_modified  = gmdate("D, d M Y H:i:s", filemtime($filepath)). "GMT";

                    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strlen(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) > 0) {
                        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                    }else {
                        $remote_last_modified = false;
                    }

                    if ((strcmp($remote_etag, $local_etag) == 0) && (strcmp($remote_last_modified, $local_last_modified) == 0)) {
                        header("Status: 304 Not Modified");
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
}

if ($redirect) {

    header_redirect("$forum_path/get_attachment.php?webtag=$webtag&hash=$hash");
    exit;

} else if (user_is_guest() && !forum_get_setting('attachment_allow_guests', 'Y')) {

    html_guest_error();
    exit;

} else {

    html_draw_top();
    html_error_msg($lang['attachmentproblem']);
    html_draw_bottom();
}

?>