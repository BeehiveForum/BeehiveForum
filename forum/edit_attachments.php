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

/* $Id: edit_attachments.php,v 1.24 2003-11-27 19:36:06 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/config.inc.php");
require_once("./include/html.inc.php");

// If attachments are disabled then no need to go any further.

if (isset($attachments_enabled) && !$attachments_enabled) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/form.inc.php");
require_once("./include/user.inc.php");
require_once("./include/attachments.inc.php");
require_once("./include/format.inc.php");
require_once("./include/lang.inc.php");

html_draw_top();

// Get any UID from the GET or POST request
// or default to the current user if not specified.

if (isset($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
}elseif (isset($HTTP_POST_VARS['uid']) && is_numeric($HTTP_POST_VARS['uid'])) {
    $uid = $HTTP_POST_VARS['uid'];
}else {
    $uid = bh_session_get_value('UID');
}

// Get any AID from the GET or POST request

if (isset($HTTP_GET_VARS['aid']) && is_md5($HTTP_GET_VARS['aid'])) {
    $aid = $HTTP_GET_VARS['aid'];
}elseif (isset($HTTP_POST_VARS['aid']) && is_md5($HTTP_POST_VARS['aid'])) {
    $aid = $HTTP_POST_VARS['aid'];
}

// Check that the UID we have belongs to the current user
// or that it is an admin if we're viewing another user's
// attachments.

if (($uid != bh_session_get_value('UID')) && !(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
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

if (isset($HTTP_POST_VARS['delete']) && isset($HTTP_POST_VARS['f_aid']) && isset($HTTP_POST_VARS['userfile'])) {

    delete_attachment($uid, $HTTP_POST_VARS['f_aid'], rawurlencode(_stripslashes($HTTP_POST_VARS['userfile'])));

}elseif (isset($HTTP_POST_VARS['close'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

?>
<h1><?php echo $lang['attachments']; ?></h1>
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td width="300" class="postbody">&nbsp;</td>
    <td width="200" class="postbody">&nbsp;</td>
    <td width="100" class="postbody">&nbsp;</td>
  </tr>
<?php

  if (isset($aid)) {
      $attachments = get_attachments($uid, $aid);
  }else {
      $attachments = get_users_attachments($uid);
  }

  if (is_array($attachments)) {

    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php/", $attachments[$i]['hash'], "/", $attachments[$i]['filename'], "?download=true\" title=\"";

      if (strlen($attachments[$i]['filename']) > 16) {
        echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
      }

      if (@$imageinfo = getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
        echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
      }

      echo "{$lang['size']}: ". format_file_size($attachments[$i]['filesize']). ", ";
      echo "{$lang['downloaded']}: ". $attachments[$i]['downloads'];

      if ($attachments[$i]['downloads'] == 1) {
        echo " {$lang['time']}";
      }else {
        echo " {$lang['times']}";
      }

      echo "\">";

      if (strlen($attachments[$i]['filename']) > 16) {
          echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
          echo $attachments[$i]['filename']. "</a></td>\n";
      }

      if (!isset($aid)) {
          echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"", get_message_link($attachments[$i]['aid']), "\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
      }

      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
      echo "      <form method=\"post\" action=\"edit_attachments.php\">\n";
      echo "        ". form_input_hidden('userfile', $attachments[$i]['filename']), "\n";
      echo "        ". form_input_hidden('f_aid', $attachments[$i]['aid']), "\n";
      echo "        ". form_input_hidden('uid', $uid), "\n";
      echo "        ". form_submit('delete', $lang['delete']). "\n";

      if (isset($aid)) echo "        ". form_input_hidden('aid', $aid), "\n";

      echo "      </form>\n";
      echo "    </td>\n";
      echo "  </tr>\n";

      $total_attachment_size += $attachments[$i]['filesize'];

    }

  }else {

    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";

  }

  echo "  <tr>\n";
  echo "    <td width=\"500\" colspan=\"3\"><hr width=\"500\"/></td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
  echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
  echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['freespace']}:</td>\n";
  echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">", format_file_size(get_free_attachment_space($uid)), "</td>\n";
  echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td width=\"500\" colspan=\"3\"><hr width=\"500\"/></td>\n";
  echo "  </tr>\n";
  echo "</table>\n";
  echo "<form method=\"post\" action=\"edit_attachments.php\">\n";

  if (isset($aid)) echo form_input_hidden('aid', $aid), "\n";

  echo form_input_hidden('uid', $uid), "\n";
  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
  echo "  <tr>\n";
  echo "    <td class=\"postbody\" align=\"center\">", form_submit('close', $lang['close']), "</td>\n";
  echo "  </tr>\n";
  echo "</table>\n";
  echo "</form>\n";

  html_draw_bottom();

?>