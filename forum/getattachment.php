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

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/header.inc.php");
require_once("./include/session.inc.php");

/*if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}*/

require_once("./include/html.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/user.inc.php");
require_once("./include/db.inc.php");
require_once("./include/config.inc.php");

if (!$attachments_enabled) {
  header("HTTP/1.0 404 File Not Found");
  exit;
}

header_no_cache();

if (isset($HTTP_GET_VARS['hash'])) {

  $db = db_connect();

  $hash = $HTTP_GET_VARS['hash'];
  $sql = "update low_priority ". forum_table("POST_ATTACHMENT_FILES"). " set DOWNLOADS = DOWNLOADS + 1 where HASH = '$hash'";
  $result = db_query($sql, $db);

  $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where HASH = '$hash' limit 0,1";
  $result = db_query($sql, $db);

  if (db_num_rows($result)) {

    $attachmentdetails = db_fetch_array($result);

    if (file_exists($attachment_dir. '/'. md5($attachmentdetails['AID']. rawurldecode($attachmentdetails['FILENAME'])))) {

      if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE')) {
        $attachment="";
      }else {
        $attachment=" attachment;";
      }

      if (isset($HTTP_GET_VARS['download']) || strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        header("Content-Type: application/x-ms-download");
        header("Content-disposition:$attachment filename=". basename($attachmentdetails['FILENAME']));
        //header("Content-Transfer-Encoding: binary");
        readfile($attachment_dir. '/'. md5($attachmentdetails['AID']. rawurldecode($attachmentdetails['FILENAME'])));
        header("Content-Length: ". ob_get_length());
        exit;

      }else {

        header("Content-Type: ". $attachmentdetails['MIMETYPE']);
        header("Content-disposition: filename=". basename($attachmentdetails['FILENAME']));
        //header("Content-Transfer-Encoding: binary");
        readfile($attachment_dir. '/'. md5($attachmentdetails['AID']. rawurldecode($attachmentdetails['FILENAME'])));
        header("Content-Length: ". ob_get_length());
        exit;

      }

    }

  }

}

html_draw_top();
echo "<h2>There was a problem downloading this attachment. Please try again later.</h2>\n";
html_draw_bottom();

?>