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

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
    
}

require_once("./include/config.inc.php");
require_once("./include/html.inc.php");

// If attachments are disabled, generate a 404 error and stop.

if (!$attachments_enabled) {
  header("HTTP/1.0 404 File Not Found");
  exit;   
}

if($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
	html_guest_error();
	exit;
}

require_once("./include/form.inc.php");
require_once("./include/user.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/format.inc.php");

html_draw_top();

if(isset($HTTP_GET_VARS['uid'])){
    $uid = $HTTP_GET_VARS['uid'];
} else if(isset($HTTP_POST_VARS['uid'])){
    $uid = $HTTP_POST_VARS['uid'];
} else {
    echo "<h1>Invalid Operation</h1>\n";
    echo "<p>No user specified for editing.</p>\n";
    html_draw_bottom();
    exit;
}

$users_free_space = get_free_attachment_space($uid);
$total_attachment_size = 0;

// Make sure the attachments directory exists
if (!is_dir('attachments')) {
  mkdir('attachments', 0755);
  chmod('attachments', 0777);
}

if (isset($HTTP_POST_VARS['submit'])) {

  if ($HTTP_POST_VARS['submit'] == 'Delete') {

    unlink($attachment_dir. '/'. md5($HTTP_POST_VARS['aid']. _stripslashes($HTTP_POST_VARS['userfile'])));
    delete_attachment($uid, $HTTP_POST_VARS['aid'], rawurlencode(_stripslashes($HTTP_POST_VARS['userfile'])));

  }elseif ($HTTP_POST_VARS['submit'] == 'Close') {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";
  
    html_draw_bottom();
    exit;
  
  }
}

?>
<h1>Attachments</h1>
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody">&nbsp;</td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
<?php

  $attachments = get_attachments($uid, $HTTP_GET_VARS['aid']);
  
  if (is_array($attachments)) {
  
    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['hash']. "&download=1\" title=\"";
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo "Filename: ". $attachments[$i]['filename']. ", ";
      }      
      
      if (@$imageinfo = getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
        echo "Dimensions: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
      }
                        
      echo "Size: ". format_file_size($attachments[$i]['filesize']). ", ";
      echo "Downloaded: ". $attachments[$i]['downloads'];
                        
      if ($attachments[$i]['downloads'] == 1) {
        echo " time";
      }else {
        echo " times";
      }
      
      echo "\">";
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }
      
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
      echo "      <form method=\"post\" action=\"edit_attachments.php?aid=". $HTTP_GET_VARS['aid']. "\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']);
      echo "        ". form_input_hidden('aid', $attachments[$i]['aid']);
      echo "        ". form_input_hidden('uid', $uid);
      echo "        ". form_submit('submit', 'Delete'). "\n";
      echo "      </form>\n";
      echo "    </td>\n";
      echo "  </tr>\n";
    
      $total_attachment_size += $attachments[$i]['filesize'];
      
    }
    
  }else {
  
    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">(none)</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";    
    
  }
    
  
?>
  <tr>
    <td width="500" colspan="3"><hr width="500"/></td>
  </tr>
  <tr>
    <td valign="top" width="300" class="postbody">Total Size:</td>
    <td align="right" valign="top" width="200" class="postbody"><?php echo format_file_size($total_attachment_size); ?></td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" width="300" class="postbody">Free space:</td>
    <td align="right" valign="top" width="200" class="postbody"><?php echo format_file_size(get_free_attachment_space($uid)); ?></td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>
  <tr>
    <td width="500" colspan="3"><hr width="500"/></td>
  </tr>
</table>
<form method="post" action="edit_attachments.php?aid=<?php echo $HTTP_GET_VARS['aid']; ?>&uid=<?php echo $uid; ?>">
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td class="postbody" align="center"><?php echo form_submit('submit', 'Close'); ?></td>
  </tr>  
</table>
</form>
<?php

  html_draw_bottom(); 
  
?>