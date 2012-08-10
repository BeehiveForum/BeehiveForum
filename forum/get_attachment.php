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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly, or have access to attachments.
if (!session::logged_in() && !forum_get_setting('attachment_allow_guests', 'Y')) {
    html_guest_error();
}

// Check to see if attachments are actually enabled
if (forum_get_setting('attachments_enabled', 'N')) {
    html_draw_error(gettext("Attachments have been disabled by the forum owner."));
}

// If the attachments directory is undefined we can't go any further
if (!($attachment_dir = attachments_check_dir())) {
    html_draw_error(gettext("Attachments have been disabled by the forum owner."));
}

// Check we have a valid attachment hash.
if (!isset($_GET['hash']) || !is_md5($_GET['hash'])) {
    html_draw_error(gettext('Missing or invalid attachment hash'));
}

// Get the hash from the URL query.
$hash = $_GET['hash'];

// Get the array of allowed attachment mime-types
$attachment_mime_types = attachments_get_mime_types();

// Get the attachment details.
if (!($attachment_details = attachments_get_by_hash($hash))) {
    html_draw_error(gettext('Missing or invalid attachment hash'));
}

// If we're requesting an image attachment thumbnail then
// we need to append .thumb to the filepath. If we're getting
// the full image we increase the view count by one.
if (isset($_GET['thumb'])) {
    
    // Check the forum has attachment thumbnails enabled.
    // If it doesn't simply send a 404 error and stop here.
    if (!forum_get_setting('attachment_thumbnails', 'Y')) {
        
        header_status('404', 'File Not Found');
        exit;
    }
    
    $file_path = "{$attachment_dir}/{$attachment_details['hash']}.thumb";

} else {

    // Construct the attachment filepath.
    $file_path = "{$attachment_dir}/{$attachment_details['hash']}";

    // Increment the view count only if the attachment
    // isn't being used as an avatar or profile picture.
    if (!isset($_GET['profile_picture']) && !isset($_GET['avatar_picture'])) {
        attachments_inc_download_count($hash);
    }
}

// Check the mimetype is allowed. If it's not, send a 404 error.
if (sizeof($attachment_mime_types) > 0 && !in_array($attachment_details['mimetype'], $attachment_mime_types)) {
    html_draw_error(gettext('Attachment type is not permitted.'));
}

// Use the filename quite a few times, so assign it to a variable to save some time.
$file_name = rawurldecode(basename($attachment_details['filename']));

// Check the filepath is set and exists.
if (!isset($file_path) || !@file_exists($file_path)) {

    header_status('404', 'File Not Found');
    exit;    
}

// Check we open the file.
if (!($file_handle = @fopen($file_path, 'rb'))) {
    
    header_status('404', 'File Not Found');
    exit;
}    

// Filesize for Content-Length header.
$file_size = filesize($file_path);

// Chunk size to use when reading the file. This is to 
// work around servers that have problems loading large 
// attachments into memory.
$chunk_size = 1 * (1024 * 1024);

// Last Modified Header for cache control
cache_check_last_modified(filemtime($file_path));

// Send remaining headers for length and filename.
header("Content-Length: $file_size");
header("Content-Type: {$attachment_details['mimetype']}");
header("Content-disposition: inline; filename=\"$file_name\"");

// Loop over the file, reading chunks of it
// and send them to the client.
while (!feof($file_handle)) {

    echo fread($file_handle, $chunk_size);

    ob_flush();

    flush();
}

fclose($file_handle);

?>