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

/* $Id: attachments.php,v 1.109 2005-03-19 21:50:00 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

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

    @mkdir($attachment_dir, 0755);
    @chmod($attachment_dir, 0777);
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

                        attachment_create_thumb($filepath);

                        $users_free_space -= $filesize;

                        if (strlen($filename) > 32) {

                            $upload_success[] = substr($filename, 0, 32). "&hellip;";

                        }else {

                            $upload_success[] = $filename;
                        }

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

if (get_attachments(bh_session_get_value('UID'), $aid, $attachments_array, $image_attachments_array)) {

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                <tr>\n";
                echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                  </td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                <tr>\n";
                echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                  </td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
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

if (get_all_attachments(bh_session_get_value('UID'), $aid, $attachments_array, $image_attachments_array)) {

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                  <td>&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                  </td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                  <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                  <td>&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                    ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                  </td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
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