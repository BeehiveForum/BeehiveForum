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

/* $Id: get_attachment.php,v 1.47 2009-04-23 19:02:34 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('UTC');

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

//Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

$lang = lang::get_instance()->load(__FILE__);

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

$redirect_error_message = false;

if (isset($_GET['hash']) && is_md5($_GET['hash'])) {

    $hash = $_GET['hash'];

    if (user_is_guest() && !forum_get_setting('attachment_allow_guests', 'Y')) {

        html_guest_error();
        exit;
    }

}else {

    if (strstr($_SERVER['PHP_SELF'], 'get_attachment.php')) {

        $attachment_data = array();

        if (preg_match('/\/get_attachment\.php\/([A-Fa-f0-9]{32})\/(.*)$/Du', $_SERVER['PHP_SELF'], $attachment_data) > 0) {

            if (isset($attachment_data[1]) && is_md5($attachment_data[1])) {

                $hash = $attachment_data[1];
                $redirect_error_message = true;
            }
        }

    }else {

        $attachment_data = array();

        if (preg_match('/\/([A-Fa-f0-9]{32})\/(.*)$/Du', $_SERVER['PHP_SELF'], $attachment_data) > 0) {

            if (isset($attachment_data[1]) && is_md5($attachment_data[1])) {

                $hash = $attachment_data[1];
                $redirect_error_message = true;
            }
        }
    }
}

if (isset($hash) && is_md5($hash)) {

    if (!user_is_guest() || forum_get_setting('attachment_allow_guests', 'Y')) {

        if (($attachment_details = get_attachment_by_hash($hash))) {

            // If we're requesting the thumbnail then we need to append
            //.thumb to the filepath. If we're getting the full image we
            // increase the view count by one.

            if (isset($_GET['thumb']) && $_GET['thumb'] == 1) {

                $filepath = "{$attachment_dir}/{$attachment_details['hash']}.thumb";

            }elseif (!isset($_GET['profile_picture']) && !isset($_GET['avatar_picture'])) {

                attachment_inc_dload_count($hash);
                $filepath = "{$attachment_dir}/{$attachment_details['hash']}";
            }

            // Use the filename quite a few times, so assign it to a variable to save some time.

            $filename = rawurldecode(basename($attachment_details['filename']));

            if (@file_exists($filepath)) {

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

                    if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                        $remote_etag = mb_substr(stripslashes_array($_SERVER['HTTP_IF_NONE_MATCH']), 1, -1);
                    }else {
                        $remote_etag = false;
                    }

                    // Last Modified Header for cache control
                    $local_last_modified  = gmdate("D, d M Y H:i:s", filemtime($filepath)). "GMT";

                    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
                        $remote_last_modified = stripslashes_array($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                    }else {
                        $remote_last_modified = false;
                    }

                    if ((strcmp($remote_etag, $local_etag) == 0) && (strcmp($remote_last_modified, $local_last_modified) == 0)) {
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
}

if ($redirect_error_message) {

    $forum_path = preg_replace('/\/get_attachment\.php\/[A-Fa-f0-9]{32}/iu', "", html_get_forum_uri());
    $redirect_uri = "$forum_path/get_attachment.php?webtag=$webtag&hash=$hash";
    header_redirect($redirect_uri);

}else {

    html_draw_top();
    html_error_msg($lang['attachmentproblem']);
    html_draw_bottom();
}

?>