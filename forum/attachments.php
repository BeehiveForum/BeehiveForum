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

/* $Id: attachments.php,v 1.73 2004-04-04 21:03:39 decoyduck Exp $ */

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
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
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

// If not AID we must stop.

if (!isset($HTTP_GET_VARS['aid']) || !is_md5($HTTP_GET_VARS['aid'])) {
  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<h2>{$lang['aidnotspecified']}</h2>\n";
  html_draw_bottom();
  exit;
}

// Guests can't do attachments.

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

html_draw_top();

$users_free_space = get_free_attachment_space(bh_session_get_value('UID'));
$total_attachment_size = 0;

// Check that $attachment_dir does not have a slash on the end of it.

if (substr($attachment_dir, -1) == '/') {
    $attachment_dir = substr($attachment_dir, 0, -1);
}

// Make sure the attachments directory exists

if (!(@is_dir($attachment_dir))) {
    mkdir($attachment_dir, 0755);
    chmod($attachment_dir, 0777);
}

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

            if (isset($HTTP_POST_FILES['userfile']['name'][$i]) && strlen(trim($HTTP_POST_FILES['userfile']['name'][$i])) > 0) {

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
                    $filepath = $attachment_dir. "/$filehash";

                    if (@move_uploaded_file($tempfile, $filepath)) {

                        add_attachment($uid, $aid, $uniqfileid, $filename, $filetype);
                        $users_free_space -= $filesize;
                        $upload_success[]  = $filename;

                    }else {

                        if (@file_exists($tempfile)) {
                            unlink($tempfile);
                        }

                        $upload_failure[] = $filename;
                        echo "\"$filename\"<br />";
                    }
                }
            }
        }
    }

}elseif (isset($HTTP_POST_VARS['del'])) {

    if (isset($HTTP_POST_VARS['hash']) && is_md5($HTTP_POST_VARS['hash'])) {

        delete_attachment(bh_session_get_value('UID'), $HTTP_POST_VARS['hash']);
    }

}elseif (isset($HTTP_POST_VARS['complete'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($HTTP_POST_VARS['filecount']) && is_numeric($HTTP_POST_VARS['filecount'])) {
    $filecount = $HTTP_POST_VARS['filecount'];
}else {
    $filecount = 1;
}

if (isset($upload_success) && is_array($upload_success) && sizeof($upload_success) > 0) {
    echo "<h2>{$lang['successfullyuploaded']}: ", implode(",", $upload_success), "</h2>\n";
}

if (isset($upload_failure) && is_array($upload_failure) && sizeof($upload_failure) > 0) {
    echo "<h2>{$lang['uploadfailed']}: ", implode(",", $upload_failure), "</h2>\n";
}

echo "<h1>{$lang['uploadattachment']}</h1>\n";
echo "<form name=\"f_attach\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php?webtag=$webtag&aid={$HTTP_GET_VARS['aid']}\">\n";
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

        if (@file_exists("{$attachment_dir}/{$attachments[$i]['hash']}")) {

            echo "  <tr>\n";
            echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";

            if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                echo "<a href=\"getattachment.php?webtag=$webtag&hash=", $attachments[$i]['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "?webtag=$webtag\" title=\"";
            }

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

            echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "    <td align=\"right\" width=\"100\" class=\"postbody\">\n";
            echo "      <form method=\"post\" action=\"attachments.php?webtag=$webtag&aid=". $HTTP_GET_VARS['aid']. "\">\n";
            echo "        ", form_input_hidden('filecount', $filecount), "\n";
            echo "        ", form_input_hidden('hash', $attachments[$i]['hash']), "\n";
            echo "        ", form_submit('del', $lang['del']), "\n";
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

        if (@file_exists("{$attachment_dir}/{$attachments[$i]['hash']}")) {

            echo "  <tr>\n";
            echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";

            if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                echo "<a href=\"getattachment.php?webtag=$webtag&hash=", $attachments[$i]['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "?webtag=$webtag\" title=\"";
            }

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

            if ($message_link = get_message_link($attachments[$i]['aid'])) {
                echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
            }else {
                echo "    <td>&nbsp;</td>\n";
            }

            echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "    <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\">\n";
            echo "      <form method=\"post\" action=\"attachments.php?webtag=$webtag&aid=". $HTTP_GET_VARS['aid']. "\">\n";
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