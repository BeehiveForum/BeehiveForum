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

/* $Id: attachments.php,v 1.99 2004-12-27 22:04:36 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/attachments.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

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

// If no AID we must stop.

if (isset($_GET['aid']) && is_md5($_GET['aid'])) {

    $aid = $_GET['aid'];

}else if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else {

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

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "var upload_field_array = new Array();\n\n";
echo "var upload_field_html = '<input type=\"file\" name=\"userfile[]\" id=\"userfile[]\" class=\"bhinputtext\" value=\"\" size=\"40\" dir=\"ltr\" />';\n\n";
echo "function add_upload_field()\n";
echo "{\n";
echo "    var upload_fields_obj;\n\n";
echo "    if (document.getElementById) {\n";
echo "        upload_fields_obj = eval(\"document.getElementById('upload_fields')\");\n";
echo "    }else if (document.all) {\n";
echo "        upload_fields_obj = eval(\"document.all.upload_fields\");\n";
echo "    }else if (document.layer) {\n";
echo "        upload_fields_obj = eval(\"document.upload_fields\");\n";
echo "    }else {\n";
echo "        return false;\n";
echo "    }\n\n";
echo "    if (upload_field_array.length < 9) {\n\n";
echo "        upload_field_array.push(upload_field_html);\n";
echo "        upload_fields_obj.innerHTML = upload_field_array.join(\"<br />\");\n\n";
echo "    }else {\n\n";
echo "        alert('{$lang['canonlyuploadmaximum']}');\n";
echo "    }\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

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

if (isset($_POST['upload'])) {

    if (isset($_FILES['userfile']) && is_array($_FILES['userfile'])) {

        for ($i = 0; $i < sizeof($_FILES['userfile']['name']); $i++) {

            if (isset($_FILES['userfile']['name'][$i]) && strlen(trim($_FILES['userfile']['name'][$i])) > 0) {

                $filesize = $_FILES['userfile']['size'][$i];
                $tempfile = $_FILES['userfile']['tmp_name'][$i];
                $filetype = $_FILES['userfile']['type'][$i];

                $filename = trim(_stripslashes($_FILES['userfile']['name'][$i]));

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
                    }
                }
            }
        }
    }

}elseif (isset($_POST['delete'])) {

    list($hash) = array_keys($_POST['delete']);
    delete_attachment($hash);

}elseif (isset($_POST['complete'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

echo "<h1>{$lang['attachments']}</h1>\n";
echo "<br />\n";
echo "<form id=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ". form_input_hidden('aid', $aid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\" class=\"subhead\">{$lang['uploadattachment']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"220\" class=\"postbody\" valign=\"top\">{$lang['enterfilenamestoupload']} :</td>\n";
echo "                  <td class=\"postbody\">\n";
echo "                    ", form_field("userfile[]", "", 40, 0, "file"), "\n";
echo "                    <div id=\"upload_fields\"></div>\n";
echo "                  </td>\n";
echo "                  <td class=\"postbody\" valign=\"top\">", form_submit("upload", $lang['upload'], "onclick=\"this.value='{$lang['waitdotdot']}'\""), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"220\">&nbsp;</td>\n";
echo "                  <td colspan=\"2\" class=\"smalltext\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" /><a href=\"javascript:void(0)\" onclick=\"add_upload_field()\">Upload another file</a></td>\n";
echo "                </tr>\n";

if (isset($upload_success) && is_array($upload_success) && sizeof($upload_success) > 0) {

    echo "                <tr>\n";
    echo "                  <td width=\"220\">&nbsp;</td>\n";
    echo "                  <td colspan=\"2\"><h2>{$lang['successfullyuploaded']}:<br />", implode(",<br />", $upload_success), ".</h2></td>\n";
    echo "                </tr>\n";
}

if (isset($upload_failure) && is_array($upload_failure) && sizeof($upload_failure) > 0) {

    echo "                <tr>\n";
    echo "                  <td width=\"220\">&nbsp;</td>\n";
    echo "                  <td colspan=\"2\"><h2>{$lang['failedtoupload']}:<br />", implode(",<br />", $upload_failure), ".</h2></td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\" class=\"subhead\">{$lang['attachmentsforthismessage']}</td>\n";
echo "                </tr>\n";

if ($attachments_array = get_attachments(bh_session_get_value('UID'), $aid)) {

    foreach ($attachments_array as $key => $attachment) {

        if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" />";

            if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                echo "<a href=\"get_attachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\" title=\"";
            }else {
                echo "<a href=\"get_attachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\" title=\"";
            }

            if (strlen($attachment['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachment['filename']. ", ";
            }

            if (@$imageinfo = getimagesize("$attachment_dir/". md5($attachment['aid']. rawurldecode($attachment['filename'])))) {
                echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
            }

            echo "{$lang['size']}: ". format_file_size($attachment['filesize']). ", ";
            echo "{$lang['downloaded']}: ". $attachment['downloads'];

            if ($attachment['downloads'] == 1) {
                echo " {$lang['time']}";
            }else {
                echo " {$lang['times']}";
            }

            echo "\">";

            if (strlen($attachment['filename']) > 16) {
                echo substr($attachment['filename'], 0, 16). "&hellip;</a></td>\n";
            }else{
                echo $attachment['filename']. "</a></td>\n";
            }

            if (!$aid) {
                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {
                    echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
                }else {
                    echo "                  <td>&nbsp;</td>\n";
                }
            }

            echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
            echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
            echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
            echo "                  </td>\n";
            echo "                </tr>\n";

            $total_attachment_size += $attachment['filesize'];
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td valign=\"top\" colspan=\"4\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td colspan=\"4\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\" class=\"subhead\">{$lang['otherattachmentsincludingpm']}</td>\n";
echo "                </tr>\n";

if ($attachments_array = get_all_attachments(bh_session_get_value('UID'), $aid)) {

    foreach ($attachments_array as $key => $attachment) {

        if (@file_exists("$attachment_dir/{$attachment['hash']}")) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" />";

            if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                echo "<a href=\"get_attachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\" title=\"";
            }else {
                echo "<a href=\"get_attachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\" title=\"";
            }

            if (strlen($attachment['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachment['filename']. ", ";
            }

            if (@$imageinfo = getimagesize("$attachment_dir/". md5($attachment['aid']. rawurldecode($attachment['filename'])))) {
                echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
            }

            echo "{$lang['size']}: ". format_file_size($attachment['filesize']). ", ";
            echo "{$lang['downloaded']}: ". $attachment['downloads'];

            if ($attachment['downloads'] == 1) {
                echo " {$lang['time']}";
            }else {
                echo " {$lang['times']}";
            }

            echo "\">";

            if (strlen($attachment['filename']) > 16) {
                echo substr($attachment['filename'], 0, 16). "&hellip;</a></td>\n";
            }else{
                echo $attachment['filename']. "</a></td>\n";
            }

            if (!$aid) {
                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {
                    echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
                }else {
                    echo "                  <td>&nbsp;</td>\n";
                }
            }

            echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
            echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
            echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
            echo "                  </td>\n";
            echo "                </tr>\n";

            $total_attachment_size += $attachment['filesize'];
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td valign=\"top\" colspan=\"4\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td colspan=\"4\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"5\" class=\"subhead\">{$lang['usage']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td valign=\"top\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
echo "                  <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "                  <td class=\"postbody\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td valign=\"top\" class=\"postbody\">{$lang['freespace']}:</td>\n";
echo "                  <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size(get_free_attachment_space($uid)), "</td>\n";
echo "                  <td class=\"postbody\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"5\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" colspan=\"2\" align=\"center\">&nbsp;", form_submit("complete", $lang['complete']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>