<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: attachments.php,v 1.152 2008-03-31 21:06:24 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
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
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// If attachments are disabled then no need to go any further.

if (forum_get_setting('attachments_enabled', 'N')) {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['attachmentshavebeendisabled']);
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further

if (!$attachment_dir = attachments_check_dir()) {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['attachmentshavebeendisabled']);
    html_draw_bottom();
    exit;
}

// If no AID we must stop.

if (isset($_GET['aid']) && is_md5($_GET['aid'])) {

    $aid = $_GET['aid'];

}else if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['aidnotspecified']);
    html_draw_bottom();
    exit;
}

// Guests can't do attachments.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// User's UID

$uid = bh_session_get_value('UID');

// Get user's free attachment space.

$users_free_space = get_free_attachment_space($uid);
$total_attachment_size = 0;

// Check that $attachment_dir does not have a slash on the end of it.

if (substr($attachment_dir, -1) == '/') {
    $attachment_dir = substr($attachment_dir, 0, -1);
}

// Arrays to hold the success and error messages

$upload_success = array();
$upload_failure = array();

// Start Stuff

if (isset($_POST['upload'])) {

    if (isset($_FILES['userfile']) && is_array($_FILES['userfile'])) {

        for ($i = 0; $i < sizeof($_FILES['userfile']['name']); $i++) {

            if (isset($_FILES['userfile']['name'][$i]) && strlen(trim($_FILES['userfile']['name'][$i])) > 0) {

                $filename = trim(_stripslashes($_FILES['userfile']['name'][$i]));

                if (isset($_FILES['userfile']['error'][$i]) && $_FILES['userfile']['error'][$i] > 0) {

                    $upload_failure[] = $filename;

                }else {

                    $filesize = $_FILES['userfile']['size'][$i];
                    $tempfile = $_FILES['userfile']['tmp_name'][$i];
                    $filetype = $_FILES['userfile']['type'][$i];

                    if ($users_free_space < $filesize) {

                        $upload_failure[] = $filename;

                        if (@file_exists($tempfile)) {

                            unlink($tempfile);
                        }

                    }else {

                        $uniqfileid = md5(uniqid(mt_rand()));

                        $filehash = md5("{$aid}{$uniqfileid}{$filename}");
                        $filepath = "$attachment_dir/$filehash";

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
    }

}elseif (isset($_POST['delete_confirm'])) {

    if (isset($_POST['delete_attachment_confirm']) && is_array($_POST['delete_attachment_confirm'])) {

        foreach($_POST['delete_attachment_confirm'] as $hash => $del_attachment) {

            if ($del_attachment == "Y") {

                delete_attachment($hash);
            }
        }
    }

}elseif (isset($_POST['delete'])) {

    $hash_array = array();

    if (isset($_POST['delete_attachment']) && is_array($_POST['delete_attachment'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['delete_attachment']));
    }

    if (isset($_POST['delete_other_attachment']) && is_array($_POST['delete_other_attachment'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['delete_other_attachment']));
    }

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        if (get_attachments($uid, $aid, $attachments_array, $image_attachments_array, $hash_array)) {

            html_draw_top('pm_popup_disabled');

            echo "<h1>{$lang['deleteattachments']}</h1>\n";
            echo "<br />\n";
            echo "<form name=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php\">\n";
            echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
            echo "  ". form_input_hidden('aid', _htmlentities($aid)), "\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['deleteattachments']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">{$lang['deleteattachmentsconfirm']}</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"center\">\n";
            echo "                          <table class=\"posthead\" width=\"95%\">\n";
            echo "                            <tr>\n";
            echo "                              <td><br />\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                foreach($attachments_array as $attachment) {

                    echo "                                ", attachment_make_link($attachment, false, false), "\n";
                    echo "                                ", form_input_hidden("delete_attachment_confirm[{$attachment['hash']}]", "Y"), "\n";
                }
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                foreach($image_attachments_array as $key => $attachment) {

                    echo "                                ", attachment_make_link($attachment, false, false), "\n";
                    echo "                                ", form_input_hidden("delete_attachment_confirm[{$attachment['hash']}]", "Y"), "\n";
                }
            }

            echo "                              </td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\">&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "      </td>\n";
            echo "    </tr>\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">&nbsp;</td>\n";
            echo "    </tr>\n";
            echo "    <tr>\n";
            echo "      <td align=\"center\">", form_submit("delete_confirm", $lang['confirm']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['complete'])) {

    html_draw_top('pm_popup_disabled');

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "    try {\n";
    echo "        if (/edit_attachments.php|edit_prefs.php/.test(window.opener.location) == true) {\n";
    echo "            window.opener.location.reload();\n";
    echo "        }\n";
    echo "    }catch(e) {\n\n";
    echo "    }\n";
    echo "    window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}


html_draw_top('attachments.js', 'onload=add_upload_field_link()', 'pm_popup_disabled');

$javascript_upload_link = "<img src=\"%1\$s\" border=\"0\" alt=\"%2\$s\" title=\"%2\$s\" />";
$javascript_upload_link.= "<a href=\"javascript:void(0)\" onclick=\"add_upload_field()\">%3\$s</a>";

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "var upload_field_array = new Array();\n\n";
echo "var upload_field_html = '", form_input_file("userfile[]", "", 30, 0),"';\n";
echo "var upload_field_link_html = '", html_js_safe_str(sprintf($javascript_upload_link, style_image('attach.png'), $lang['attachment'], 'Upload another file')), "';\n\n";
echo "function add_upload_field_link()\n";
echo "{\n";
echo "    var upload_field_link_obj;\n\n";
echo "    if (document.getElementById) {\n\n";
echo "        upload_field_link_obj = document.getElementById('upload_fields_link');\n";
echo "        upload_field_link_obj.innerHTML = upload_field_link_html;\n";
echo "    }\n";
echo "}\n\n";
echo "function add_upload_field()\n";
echo "{\n";
echo "    var upload_fields_obj;\n\n";
echo "    if (document.getElementById) {\n\n";
echo "        upload_field_obj = document.getElementById('upload_fields');\n\n";
echo "        upload_field_child_objs = upload_field_obj.getElementsByTagName('div');\n\n";
echo "        if (upload_field_child_objs.length < 9) {\n\n";
echo "            new_upload_div = document.createElement('div');\n";
echo "            upload_field_obj.appendChild(new_upload_div);\n";
echo "            new_upload_div.innerHTML =  upload_field_html;\n\n";
echo "        }else {\n\n";
echo "            alert('", html_js_safe_str($lang['canonlyuploadmaximum']), "');\n";
echo "        }\n";
echo "    }\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

echo "<h1>{$lang['attachments']}</h1>\n";

if (isset($upload_success) && is_array($upload_success) && sizeof($upload_success) > 0) {
    html_display_success_msg(sprintf($lang['successfullyuploaded'], _htmlentities(implode(", ", $upload_success))), '600', 'left');
}

if (isset($upload_failure) && is_array($upload_failure) && sizeof($upload_failure) > 0) {
    html_display_error_msg(sprintf($lang['failedtoupload'], _htmlentities(implode(", ", $upload_failure))), '600', 'left');
}

echo "<br />\n";
echo "<form name=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ". form_input_hidden('aid', _htmlentities($aid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">{$lang['uploadattachment']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\" class=\"postbody\" valign=\"top\">{$lang['enterfilenamestoupload']} :</td>\n";
echo "                        <td align=\"left\" class=\"postbody\">\n";
echo "                          ", form_input_file("userfile[]", "", 30, 0), "\n";
echo "                          <div id=\"upload_fields\"></div>\n";
echo "                        </td>\n";
echo "                        <td align=\"left\" class=\"postbody\" valign=\"top\">", form_submit("upload", $lang['upload'], "onclick=\"this.value='{$lang['waitdotdot']}'\""), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\" class=\"smalltext\"><div id=\"upload_fields_link\"></div></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if (get_attachments($uid, $aid, $attachments_array, $image_attachments_array)) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_main", "toggle_main", "", false, "onclick=\"attachmentToggleMain();\""), "</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['attachmentsforthismessage']}</td>\n";
    echo "                </tr>\n";

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_attachment[{$attachment['hash']}]", "Y", ""), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_attachment[{$attachment['hash']}]", "Y", ""), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td width=\"25\" class=\"subhead_checkbox\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['attachmentsforthismessage']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" colspan=\"5\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if (get_all_attachments($uid, $aid, $attachments_array, $image_attachments_array)) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_other", "toggle_other", "", false, "onclick=\"attachmentToggleOther();\""), "</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['otherattachmentsincludingpm']}</td>\n";
    echo "                </tr>\n";

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_other_attachment[{$attachment['hash']}]", "Y", ""), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false)) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_other_attachment[{$attachment['hash']}]", "Y", ""), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td width=\"25\" class=\"subhead\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['otherattachmentsincludingpm']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" colspan=\"4\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"5\" class=\"subhead\">{$lang['usage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">{$lang['freespace']}:</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size(get_free_attachment_space($uid)), "</td>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" colspan=\"2\" align=\"center\">", form_submit("complete", $lang['complete']), "&nbsp;", form_submit("delete", $lang['delete']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>