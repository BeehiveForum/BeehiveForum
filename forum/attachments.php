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

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);

    header_redirect($uri);
}

require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/user.inc.php");
require_once("./include/attachments.inc.php");

$userinfo = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);
$total_attachment_size = 0;
$aid = $HTTP_GET_VARS['aid'];

if (isset($HTTP_GET_VARS['filename']) && isset($HTTP_GET_VARS['owneruid'])) {

  download_attachment($HTTP_GET_VARS['owneruid'], $HTTP_GET_VARS['filename']);
  exit;
  
}

html_draw_top();

if (!is_dir(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments')) mkdir(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments', 0777);
if (!is_dir(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $aid)) mkdir(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $aid, 0777);

if ($HTTP_POST_VARS['submit'] == 'Del') {

  if (isset($HTTP_POST_VARS['old_aid'])) {

    unlink(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $HTTP_POST_VARS['old_aid']. '/'. md5($HTTP_POST_VARS['old_aid']. $HTTP_POST_VARS['userfile']));
    
  }else{
  
    unlink(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $aid. '/'. md5($aid. $HTTP_POST_VARS['userfile']));
    
  }
  
  delete_attachment($HTTP_COOKIE_VARS['bh_sess_uid'], $HTTP_POST_VARS['userfile']); 
  
}elseif ($HTTP_POST_VARS['submit'] == 'Upload') {

  if (get_free_attachment_space($HTTP_COOKIE_VARS['bh_sess_uid']) < filesize($HTTP_POST_FILES['userfile']['tmp_name'])) {

    echo "<p>Sorry, you do not have enough free attachment space. Please free some space and try again.</p>";
    unlink($HTTP_POST_FILES['userfile']['tmp_name']);
    
  }else {
    
    move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $aid. '/'. md5($aid. $HTTP_POST_FILES['userfile']['name']));
    add_attachment($HTTP_COOKIE_VARS['bh_sess_uid'], $aid, $HTTP_POST_FILES['userfile']['name'], $HTTP_POST_FILES['userfile']['type']);
    echo "<p>Successfully Uploaded: ". $HTTP_POST_FILES['userfile']['name']. "</p>\n";    
  
  }
  
}elseif ($HTTP_POST_VARS['submit'] == 'Move') {

  move_attachment($HTTP_COOKIE_VARS['bh_sess_uid'], $aid, $HTTP_POST_VARS['old_aid'], $HTTP_POST_VARS['userfile']);
  
}elseif ($HTTP_POST_VARS['submit'] == 'Complete') {

  echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
  echo "  window.close();\n";
  echo "</script>\n";
  
  html_draw_bottom();
  
  exit;
  
}

?>
<h1>Upload a file for attachment to the message</h1>
<form enctype="multipart/form-data" method="post" action="attachments.php?aid=<?php echo $aid; ?>">
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

  $attachments = get_attachments($HTTP_COOKIE_VARS['bh_sess_uid'], $aid);
  
  if (is_array($attachments)) {
  
    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"./images/attach.png\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?uid=". $HTTP_COOKIE_VARS['bh_sess_uid']. "&hash=". $attachments[$i]['aid']. "&filename=". $attachments[$i]['filename']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }
      
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". number_format($attachments[$i]['filesize'], 2, '.', ','). " bytes</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
      echo "      <form method=\"post\" action=\"attachments.php?aid=". $aid. "\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']);
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
    <td align="right" valign="top" width="200" class="postbody"><?php echo number_format($total_attachment_size, 2, '.', ','); ?> bytes</td>
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

  $attachments = get_all_attachments($HTTP_COOKIE_VARS['bh_sess_uid'], $aid);
  
  if (is_array($attachments)) {
  
    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"./images/attach.png\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?uid=". $HTTP_COOKIE_VARS['bh_sess_uid']. "&hash=". $attachments[$i]['aid']. "&filename=". $attachments[$i]['filename']. "&download=1\" title=\"". $attachments[$i]['filename']. "\">";
      
      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }
      
      echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"messages.php?msg=". get_message_tidpid($attachments[$i]['aid']). "\" target=\"_blank\">View Message</a></td>\n";
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". number_format($attachments[$i]['filesize'], 2, '.', ','). " bytes</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\">\n";
      echo "      <form method=\"post\" action=\"attachments.php?aid=". $aid. "\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']);
      echo "        ". form_input_hidden('old_aid', $attachments[$i]['aid']);
      echo "        ". form_submit('submit', 'Del'). "\n";
      echo "        ". form_submit('submit', 'Move'). "\n";
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
    <td width="500" colspan="3"><hr /></td>
    <td width="100" class="postbody">&nbsp;</td>    
  </tr>
  <tr>
    <td valign="top" width="200" class="postbody">Total Size:</td>
    <td valign="top" width="100" class="postbody">&nbsp;</td>
    <td align="right" valign="top" width="200" class="postbody"><?php echo number_format($total_attachment_size, 2, '.', ','); ?> bytes</td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" width="300" class="postbody">Free space:</td>
    <td valign="top" width="100" class="postbody">&nbsp;</td>    
    <td align="right" valign="top" width="200" class="postbody"><?php echo number_format(get_free_attachment_space($HTTP_COOKIE_VARS['bh_sess_uid']), 2, '.', ','); ?> bytes</td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>  
</table>
<?php

  html_draw_bottom(); 
  
?>