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

require_once("./include/attachments.inc.php");
require_once("./include/header.inc.php");
require_once("./include/html.inc.php");

if (isset($HTTP_GET_VARS['owneruid']) && isset($HTTP_GET_VARS['filename'])) {

  $userinfo = user_get($HTTP_GET_VARS['owneruid']);
  $attachments_dir = "http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). '/attachments/'. $userinfo['LOGON'];
  header_redirect($attachments_dir. '/'. $HTTP_GET_VARS['filename']);
  exit;
  
}else {

  if (isset($HTTP_GET_VARS['msg'])) {
  
    header_redirect("messages.php?msg=". $HTTP_GET_VARS['msg']);
    exit;
    
  }
  
}
  
html_draw_top();
echo "<h2>There was a problem downloading the attachment.</h2>";
html_draw_bottom();
exit;

?>