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

require_once("./include/header.inc.php");
require_once("./include/session.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    
    header_redirect($uri);
}

require_once("./include/html.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/user.inc.php");
require_once("./include/db.inc.php");
require_once("./include/config.inc.php");

if (isset($HTTP_GET_VARS['hash'])) {
  
  $aid  = substr($HTTP_GET_VARS['hash'], 0, 32);
  $hash = substr($HTTP_GET_VARS['hash'], 32);
  
  $db = db_connect();
  $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where HASH = '$hash' and AID = '$aid'";
  
  $result = db_query($sql, $db);
  
  if (db_num_rows($result)) {
      
    $attachmentdetails = db_fetch_array($result);
    
    if (file_exists($attachment_dir. '/'. $attachmentdetails['HASH'])) {    
        
      if(isset($HTTP_GET_VARS['download'])) {
  
        header("Content-Type: application/x-ms-download");
        header("Content-Length: ". filesize($attachment_dir. '/'. $attachmentdetails['HASH']));
        header("Content-disposition: filename=". $attachmentdetails['FILENAME']);
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
 
        readfile($attachment_dir. '/'. $attachmentdetails['HASH']);
        exit;
      
      }else {
    
        header("Content-Type: ". $attachmentdetails['MIMETYPE']);
        header("Content-Length: ". filesize($attachment_dir. '/'. $attachmentdetails['HASH']));
        header("Content-disposition: filename=". $attachmentdetails['FILENAME']);        
        
        if($attachmentdetails['MIMETYPE'] == 'application/octet-stream') {

          header("Content-Transfer-Encoding: binary");
          
        }
        
        header("Pragma: no-cache");
        header("Expires: 0");
          
        readfile($attachment_dir. '/'. $attachmentdetails['HASH']);
        exit;          
  
      }
        
    }
   
  }
  
}

html_draw_top();
echo "<h2>There was a problem downloading this attachment. Please try again later.</h2>\n";
html_draw_bottom();

?>