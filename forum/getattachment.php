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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/header.inc.php");
require_once("./include/session.inc.php");

if(!bh_session_check()){
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/html.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/user.inc.php");
require_once("./include/db.inc.php");
require_once("./include/config.inc.php");

if (!$attachments_enabled) {
    header("HTTP/1.0 404 File Not Found");
    exit;
}

preg_match("/\/getattachment.php\/(.*)\/(.*)$/", $HTTP_SERVER_VARS['PHP_SELF'], $attachment_data);

if (isset($attachment_data[1])) {

    $hash = $attachment_data[1];

    $db = db_connect();

    $sql  = "update low_priority ". forum_table("POST_ATTACHMENT_FILES"). " set DOWNLOADS = DOWNLOADS + 1 where HASH = '$hash'";
    $result = db_query($sql, $db);

    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where HASH = '$hash' limit 0,1";
    $result = db_query($sql, $db);

    if (db_num_rows($result)) {

        $attachmentdetails = db_fetch_array($result);

        if (file_exists($attachment_dir. '/'. md5($attachmentdetails['AID']. rawurldecode($attachmentdetails['FILENAME'])))) {

            // Use these quite a few times, so assign them to variables to make it easier
            $filepath = $attachment_dir. '/'. md5($attachmentdetails['AID']. rawurldecode($attachmentdetails['FILENAME']));
            $filename = basename($attachmentdetails['FILENAME']);

            // Etag Header for cache control
            $local_etag  = md5(gmdate("D, d M Y H:i:s", filemtime($filepath)). " GMT");

            if (isset($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH'])) {
                $remote_etag = substr(stripslashes($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH']), 1, -1);
            }else {
                $remote_etag = false;
            }

            // Last Modified Header for cache control
            $local_last_modified  = gmdate("D, d M Y H:i:s", filemtime($filepath)). " GMT";

            if (isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE'])) {
                $remote_last_modified = stripslashes($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']);
            }else {
                $remote_last_modified = false;
            }

            if (strcmp($remote_etag, $local_etag) == "0" || strcmp($remote_last_modified, $local_last_modified) == "0") {
                header("HTTP/1.1 304 Not Modified");
                exit;
            }else {
                if (isset($HTTP_GET_VARS['download']) || strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
                    header("Content-Type: application/x-ms-download", true);
                }else {
                    header("Content-Type: ". $attachmentdetails['MIMETYPE'], true);
                }
                header("Last-Modified: $local_last_modified", true);
                header("Etag: \"$local_etag\"", true);
                header("Content-disposition: inline; filename=$filename", true);
                readfile($filepath);
                exit;
            }
        }
    }
}

require_once("./include/lang.inc.php");
html_draw_top();
echo "<h2>{$lang['attachmentproblem']}</h2>\n";
html_draw_bottom();

?>
