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

if (isset($HTTP_GET_VARS['owneruid']) && isset($HTTP_GET_VARS['filename'])) {

  $userinfo = user_get($HTTP_GET_VARS['owneruid']);
  
  if (isset($userinfo['LOGON'])) {
  
    $attachments_dir = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $userinfo['LOGON'];
  
    if (file_exists($attachments_dir. '/'. $HTTP_GET_VARS['filename'])) {
    
      $db = db_connect();
      
      $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES");
      $sql.= " where UID = ". $HTTP_GET_VARS['owneruid']. " and";
      $sql.= " FILENAME = '". $HTTP_GET_VARS['filename']. "'";
      
      $result = db_query($sql, $db);
      
      if (db_num_rows($result)) {
      
        $attachmentdetails = db_fetch_array($result);
        
        if(isset($HTTP_GET_VARS['download'])) {
  
          header("Content-Type: application/x-ms-download");
          header("Content-Length: ". filesize($attachments_dir. '/'. $HTTP_GET_VARS['filename']));
          header("Content-disposition: filename=". $filename);
          header("Content-Transfer-Encoding: binary");
          header("Pragma: no-cache");
          header("Expires: 0");
 
          readfile($attachments_dir. '/'. $HTTP_GET_VARS['filename']);
          exit;
      
        }else {
        
          if (empty($attachmentdetails['MIMETYPE'])) {
          
            header("Content-Type: application/octet-stream");
            
          }else{
      
            header("Content-Type: ". $attachmentdetails['MIMETYPE']);
            
          }
          
          header("Content-disposition: filename=". $HTTP_GET_VARS['filename']);
          header("Pragma: no-cache");
          header("Expires: 0");
          
          readfile($attachments_dir. '/'. $HTTP_GET_VARS['filename']);
          exit;          
  
        }
        
      }
    
    }
    
  }
  
}

html_draw_top();
echo "<h2>There was a problem downloading this attachment. Please try again later.</h2>\n";
html_draw_bottom();

?>