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

$users_free_space = get_free_attachment_space($HTTP_COOKIE_VARS['bh_sess_uid']);
$total_attachment_size = 0;

// Make sure the attachments directory exists
if (!is_dir('attachments')) {
  mkdir('attachments', 0755);
  chmod('attachments', 0777);
}

if (isset($HTTP_POST_VARS['submit'])) {

  if ($HTTP_POST_VARS['submit'] == 'Del') {

    unlink($attachment_dir. '/'. md5($HTTP_POST_VARS['aid']. stripslashes($HTTP_POST_VARS['userfile'])));
    delete_attachment($HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_POST_VARS['aid'], rawurlencode(stripslashes($HTTP_POST_VARS['userfile'])));
    
  }elseif ($HTTP_POST_VARS['submit'] == 'Upload') {

    if ($HTTP_POST_FILES['userfile']['size'] > 0) {
    
      if ($users_free_space < $HTTP_POST_FILES['userfile']['size']) {

        echo "<p>Sorry, you do not have enough free attachment space. Please free some space and try again.</p>";
        unlink($HTTP_POST_FILES['userfile']['tmp_name']);
    
      }else {
    
        if(move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $attachment_dir. '/'. md5($HTTP_GET_VARS['aid']. stripslashes($HTTP_POST_FILES['userfile']['name'])))) {
      
          add_attachment($HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_GET_VARS['aid'], rawurlencode(stripslashes($HTTP_POST_FILES['userfile']['name'])), $HTTP_POST_FILES['userfile']['type']);
          echo "<p>Successfully Uploaded: ". stripslashes($HTTP_POST_FILES['userfile']['name']). "</p>\n";
          
        }else {
      
          unlink($HTTP_POST_FILES['userfile']['tmp_name']);
          echo "<p>Upload Failed.</p>";
          
        }
      }

    }else {

      echo "<p>Error: Filesize must be greater than 0 bytes.</p>";
      
    }

  }elseif ($HTTP_POST_VARS['submit'] == 'Complete') {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";
  
    html_draw_bottom();
    exit;
  
  }
}

?>
<h1>Upload a file for attachment to the message</h1>
<form enctype="multipart/form-data" method="post" action="attachments.php?aid=<?php echo $HTTP_GET_VARS['aid']; ?>">
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td width="300" class="postbody" valign="top">1. Enter filename to upload :</td>
    <td class="postbody"><?php echo form_field('userfile', '', '', 0, 'file'); ?></td>
  </tr>
  <tr>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>
  </tr>
  <tr>
    <td class="postbody">2. Now press <?php echo form_submit('submit', 'Upload'); ?></td>
    <td class="postbody">&nbsp;</td>
  </tr>
  <tr>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>
  </tr>  
  <tr>
    <td class="postbody" colspan="2">3. If you are done attaching file(s), press <?php echo form_submit('submit', 'Complete'); ?></td>
  </tr>  
</table>
</form>
<h1>Attachments for this message</h1>
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody">&nbsp;</td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
<?php

  $attachments = get_attachments($HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_GET_VARS['aid']);
  
  if (is_array($attachments)) {
  
    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      //echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"./images/attach.png\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['aid']. $attachments[$i]['hash']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['hash']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";      
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }
      
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
      echo "      <form method=\"post\" action=\"attachments.php?aid=". $HTTP_GET_VARS['aid']. "\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']);
      echo "        ". form_input_hidden('aid', $attachments[$i]['aid']);      
      echo "        ". form_submit('submit', 'Del'). "\n";
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
    
  }
    
  
?>
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody"><hr /></td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
  <tr>
    <td valign="top" width="300" class="postbody">&nbsp;</td>
    <td align="right" valign="top" width="200" class="postbody"><?php echo format_file_size($total_attachment_size); ?></td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody">&nbsp;</td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>  
</table>
<h1>All Attachments (excluding current)</h1>
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody">&nbsp;</td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
<?php

  $attachments = get_all_attachments($HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_GET_VARS['aid']);
  
  if (is_array($attachments)) {
  
    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      //echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"./images/attach.png\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['aid']. $attachments[$i]['hash']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['hash']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }
      
      echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"messages.php?msg=". get_message_tidpid($attachments[$i]['aid']). "\" target=\"_blank\">View Message</a></td>\n";
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\">\n";
      echo "      <form method=\"post\" action=\"attachments.php?aid=". $HTTP_GET_VARS['aid']. "\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']);
      echo "        ". form_input_hidden('aid', $attachments[$i]['aid']);
      echo "        ". form_submit('submit', 'Del'). "\n";
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
    echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
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
    <td align="right" valign="top" width="200" class="postbody"><?php echo format_file_size(get_free_attachment_space($HTTP_COOKIE_VARS['bh_sess_uid'])); ?></td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>  
</table>
<?php

  html_draw_bottom(); 
  
?>