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

/* $Id: edit_attachments.php,v 1.46 2004-03-18 23:22:51 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/attachments.inc.php");
include_once("./include/config.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

// If attachments are disabled then no need to go any further.

if (forum_get_setting('attachments_enabled', 'N', false)) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further

if (!$attachment_dir = forum_get_setting('attachment_dir')) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

html_draw_top("post.js");

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

if (isset($HTTP_POST_VARS['del'])) {

    if (isset($HTTP_POST_VARS['hash']) && is_md5($HTTP_POST_VARS['hash'])) {

        delete_attachment(bh_session_get_value('UID'), $HTTP_POST_VARS['hash']);
    }

}elseif (isset($HTTP_POST_VARS['close'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

  
if (isset($HTTP_GET_VARS['popup']) || isset($HTTP_POST_VARS['popup'])) {
    $popup = true;
}else {
    $popup = false;
}

?>
<h1><?php echo $lang['attachments']; ?></h1>
<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>
    <td class="postbody">&nbsp;</td>    
  </tr>
<?php

  if (isset($aid)) {
      $attachments = get_attachments($uid, $aid);
  }else {
      $attachments = get_users_attachments($uid);
  }

  if (is_array($attachments)) {

    for ($i = 0; $i < sizeof($attachments); $i++) {
    
      if (@file_exists("$attachment_dir/{$attachments[$i]['hash']}")) {

        echo "  <tr>\n";
        echo "    <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";
        
        if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
            echo "<a href=\"getattachment.php?webtag={$webtag['WEBTAG']}&hash=", $attachments[$i]['hash'], "\" title=\"";
        }else {
            echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "\" title=\"";
        }         

        if (strlen($attachments[$i]['filename']) > 16) {
          echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
        }

        if (@$imageinfo = getimagesize("$attachment_dir/". md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
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
            if (is_md5($attachments[$i]['aid']) && $message_link = get_message_link($attachments[$i]['aid'])) {
                echo "    <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
            }else {
                echo "    <td>&nbsp;</td>\n";
            }
        }

        echo "    <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachments[$i]['filesize']), "</td>\n";
        echo "    <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
        echo "      <form method=\"post\" action=\"edit_attachments.php?webtag={$webtag['WEBTAG']}\">\n";
        echo "        ", form_input_hidden('hash', $attachments[$i]['hash']), "\n";
        echo "        ", form_submit('del', $lang['del']), "\n";
        echo "        ", form_input_hidden('popup', $popup), "\n";

        if (isset($aid)) echo "        ". form_input_hidden('aid', $aid), "\n";
 
        echo "      </form>\n";
        echo "    </td>\n";
        echo "  </tr>\n";

        $total_attachment_size += $attachments[$i]['filesize'];
      }
    }

  }else {

    echo "  <tr>\n";
    echo "    <td valign=\"top\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "    <td align=\"right\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";

  }

  echo "  <tr>\n";
  echo "    <td colspan=\"5\"><hr width=\"600\" /></td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td valign=\"top\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
  echo "    <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";  
  echo "    <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
  echo "    <td class=\"postbody\">&nbsp;</td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td valign=\"top\" class=\"postbody\">{$lang['freespace']}:</td>\n";
  echo "    <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";    
  echo "    <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size(get_free_attachment_space($uid)), "</td>\n";
  echo "    <td class=\"postbody\">&nbsp;</td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "    <td colspan=\"5\"><hr width=\"600\" /></td>\n";
  echo "  </tr>\n";
  echo "</table>\n";
  
  if (forum_get_setting('attachments_enabled', 'Y', false)) {

      if (isset($HTTP_GET_VARS['aid']) && is_md5($HTTP_GET_VARS['aid'])) {
          $aid = $HTTP_GET_VARS['aid'];
      }elseif (isset($HTTP_POST_VARS['aid']) && is_md5($HTTP_POST_VARS['aid'])) {
          $aid = $HTTP_POST_VARS['aid'];
      }else {
          $aid = md5(uniqid(rand()));
      }
      
      echo "<form method=\"post\" action=\"edit_attachments.php?webtag={$webtag['WEBTAG']}\">\n";
      echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
      echo "  <tr>\n";
      echo "    <td><p align=\"center\">", form_button("attachments", $lang['uploadnewattachment'], "tabindex=\"5\" onclick=\"launchAttachWin('{$aid}')\""), "</p></td>\n";
      echo "  </tr>\n";
      echo "</table>\n";
      echo "</form>\n";    
  }
  
  if ($popup) {
  
      echo "<form method=\"post\" action=\"edit_attachments.php?webtag={$webtag['WEBTAG']}\">\n";

      if (isset($aid)) echo form_input_hidden('aid', $aid), "\n";

      echo form_input_hidden('uid', $uid), "\n";
      echo form_input_hidden('popup', '1'), "\n";
      echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
      echo "  <tr>\n";
      echo "    <td class=\"postbody\" align=\"center\">", form_submit('close', $lang['close']), "</td>\n";
      echo "  </tr>\n";
      echo "</table>\n";
      echo "</form>\n";
  }

  html_draw_bottom();

?>