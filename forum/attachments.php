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

/* $Id: attachments.php,v 1.65 2004-03-15 21:33:29 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

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

if (!isset($forum_settings['attachment_dir'])) $forum_settings['attachment_dir'] = "attachments";

// If attachments are disabled then no need to go any further.

if (strtoupper($forum_settings['attachments_enabled']) == "N") {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (!isset($HTTP_GET_VARS['aid']) || !is_md5($HTTP_GET_VARS['aid'])) {
  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<h2>{$lang['aidnotspecified']}</h2>\n";
  html_draw_bottom();
  exit;
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

include_once("./include/form.inc.php");
include_once("./include/user.inc.php");
include_once("./include/attachments.inc.php");
include_once("./include/format.inc.php");

html_draw_top();

$users_free_space = get_free_attachment_space(bh_session_get_value('UID'));
$total_attachment_size = 0;

// Check that $forum_settings['attachment_dir'] does not have a slash on the end of it.

if (substr($forum_settings['attachment_dir'], -1) == '/') $forum_settings['attachment_dir'] = substr($forum_settings['attachment_dir'], 0, -1);

// Make sure the attachments directory exists

if (!is_dir($forum_settings['attachment_dir'])) {
    mkdir($forum_settings['attachment_dir'], 0755);
    chmod($forum_settings['attachment_dir'], 0777);
}

// Default File Input Box count

$filecount = 1;

// User's UID

$uid = bh_session_get_value('UID');

// Arrays to hold the success and error messages

$upload_success = array();
$upload_failure = array();

// Start Stuff

if (isset($HTTP_POST_VARS['upload'])) {

    $aid = $HTTP_GET_VARS['aid'];

    if (isset($HTTP_POST_FILES['userfile']) && is_array($HTTP_POST_FILES['userfile'])) {
    
        for ($i = 0; $i < sizeof($HTTP_POST_FILES['userfile']); $i++) {
        
            if (isset($HTTP_POST_FILES['userfile']['tmp_name'][$i]) && strlen(trim($HTTP_POST_FILES['userfile']['tmp_name'][$i])) > 0) {
            
                $filesize = $HTTP_POST_FILES['userfile']['size'][$i];
                $tempfile = $HTTP_POST_FILES['userfile']['tmp_name'][$i];
                $filetype = $HTTP_POST_FILES['userfile']['type'][$i];
                
                $filename = _stripslashes(trim($HTTP_POST_FILES['userfile']['name'][$i]));
                
                if ($users_free_space < $filesize) {

                    $upload_failure[] = $filename;

                    if (@file_exists($tempfile)) {
                        unlink($tempfile);
                    }

                }else {
                    
                    $uniqfileid = md5(uniqid(rand()));
                    
                    $filehash = md5("{$aid}{$uniqfileid}{$filename}");
                    $filepath = "{$forum_settings['attachment_dir']}/$filehash";

                    if (@move_uploaded_file($tempfile, $filepath)) {

                        add_attachment($uid, $aid, $uniqfileid, $filename, $filetype);
                        $users_free_space -= $filesize;
                        $upload_success[]  = $filename;

                    }else {

                        if (@file_exists($tempfile)) {
                            unlink($tempfile);
                        }
                        
                        $upload_failure[] = $filename;
                    }
                }
            }
        }
    }
  
}elseif (isset($HTTP_POST_VARS['del'])) {

    if (isset($HTTP_POST_VARS['hash']) && is_md5($HTTP_POST_VARS['hash'])) {

        delete_attachment(bh_session_get_value('UID'), $HTTP_POST_VARS['hash']);
    }

}elseif (isset($HTTP_POST_VARS['change'])) {

    if (isset($HTTP_POST_VARS['filecount']) && is_numeric($HTTP_POST_VARS['filecount'])) {
    
        $filecount = $HTTP_POST_VARS['filecount'];
    }

}elseif (isset($HTTP_POST_VARS['complete'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($upload_success) && is_array($upload_success) && sizeof($upload_success) > 0) {
    echo "<h2>{$lang['successfullyuploaded']}: ", implode(",", $upload_success), "</h2>\n";
}

if (isset($upload_failure) && is_array($upload_failure) && sizeof($upload_failure) > 0) {
    echo "<h2>{$lang['uploadfailed']}: ", implode(",", $upload_failure), "</h2>\n";
}

echo "<h1>{$lang['uploadattachment']}</h1>\n";
echo "<form name=\"f_attach\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php?webtag={$webtag['WEBTAG']}&aid={$HTTP_GET_VARS['aid']}\">\n";
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"620\">\n";
echo "  <tr>\n";
echo "    <td width=\"220\" class=\"postbody\" valign=\"top\">1. {$lang['enterfilenamestoupload']} :</td>\n";
echo "    <td class=\"postbody\">", form_field("userfile[]", "", 45, 0, "file"), "</td>\n";
echo "  </tr>\n";

for ($i = 1; $i < $filecount; $i++) {

    echo "  <tr>\n";
    echo "    <td width=\"220\" class=\"postbody\" valign=\"top\">&nbsp;</td>\n";
    echo "    <td class=\"postbody\">", form_field("userfile[]", "", 45, 0, "file"), "</td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td class=\"postbody\">&nbsp;</td>\n";
echo "    <td class=\"postbody\">Number of files to upload: ", form_dropdown_array("filecount", array(1, 5, 10), array("1", "5", "10"), $filecount), "&nbsp", form_submit("change", "Change"), "</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\">2. {$lang['nowpress']}&nbsp;", form_submit("upload", $lang['upload'], "onclick=\"this.value='{$lang['waitdotdot']}'\""), "</td>\n";
echo "    <td class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\">&nbsp;</td>\n";
echo "    <td class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"2\">3. {$lang['ifdoneattachingfiles']}&nbsp;", form_submit("complete", $lang['complete']), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "<h1>{$lang['attachmentsforthismessage']}</h1>\n";
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "  <tr>\n";
echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";

if ($attachments = get_attachments(bh_session_get_value('UID'), $HTTP_GET_VARS['aid'])) {

    for ($i = 0; $i < sizeof($attachments); $i++) {

        if (@file_exists("{$forum_settings['attachment_dir']}/{$attachments[$i]['hash']}")) {

            echo "  <tr>\n";
            echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";

            if ($attachment_use_old_method) {
                echo "<a href=\"getattachment.php?webtag={$webtag['WEBTAG']}&hash=", $attachments[$i]['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "\" title=\"";
            }            

            if (strlen($attachments[$i]['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
            }

            if (@$imageinfo = getimagesize($forum_settings['attachment_dir']. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
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

            echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
            echo "      <form method=\"post\" action=\"attachments.php?webtag={$webtag['WEBTAG']}&aid=". $HTTP_GET_VARS['aid']. "\">\n";
            echo "        ". form_input_hidden('hash', $attachments[$i]['hash']);
            echo "        ". form_submit('del', $lang['del']). "\n";
            echo "      </form>\n";
            echo "    </td>\n";
            echo "  </tr>\n";

            $total_attachment_size += $attachments[$i]['filesize'];
        }
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
echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"200\" class=\"postbody\"><hr /></td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<h1>{$lang['otherattachmentsincludingpm']}</h1>\n";
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "  <tr>\n";
echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";

if ($attachments = get_all_attachments(bh_session_get_value('UID'), $HTTP_GET_VARS['aid'])) {

    for ($i = 0; $i < sizeof($attachments); $i++) {
    
        if (@file_exists("{$forum_settings['attachment_dir']}/{$attachments[$i]['hash']}")) {    

            echo "  <tr>\n";
            echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";
            
            if ($attachment_use_old_method) {
                echo "<a href=\"getattachment.php?webtag={$webtag['WEBTAG']}&hash=", $attachments[$i]['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "\" title=\"";
            }            

            if (strlen($attachments[$i]['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
            }

            if (@$imageinfo = getimagesize($forum_settings['attachment_dir']. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
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

            if ($message_link = get_message_link($attachments[$i]['aid'])) {
                echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
            }else {
                echo "    <td>&nbsp;</td>\n";
            }
        
            echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "    <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\">\n";
            echo "      <form method=\"post\" action=\"attachments.php?webtag={$webtag['WEBTAG']}&aid=". $HTTP_GET_VARS['aid']. "\">\n";
            echo "        ". form_input_hidden('hash', $attachments[$i]['hash']);
            echo "        ". form_submit('del', $lang['del']). "\n";
            echo "      </form>\n";
            echo "    </td>\n";
            echo "  </tr>\n";

           $total_attachment_size += $attachments[$i]['filesize'];
        }
    }

}else {

    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";

}

echo "  <tr>\n";
echo "    <td width=\"500\" colspan=\"3\"><hr width=\"500\" align=\"left\" /></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['freespace']}:</td>\n";
echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">", format_file_size(get_free_attachment_space(bh_session_get_value('UID'))), "</td>\n";
echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>