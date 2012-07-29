<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// If attachments are disabled then no need to go any further.
if (forum_get_setting('attachments_enabled', 'N')) {

    html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
    html_error_msg(gettext("Attachments have been disabled by the forum owner."));
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further
if (!$attachment_dir = attachments_check_dir()) {

    html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
    html_error_msg(gettext("Attachments have been disabled by the forum owner."));
    html_draw_bottom();
    exit;
}

// If no AID we must stop.
if (isset($_GET['aid']) && is_md5($_GET['aid'])) {

    $aid = $_GET['aid'];

}else if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else {

    html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
    html_error_msg(gettext("AID not specified."));
    html_draw_bottom();
    exit;
}

// Guests can't do attachments.
if (user_is_guest()) {

    html_guest_error();
    exit;
}

// User's UID
$uid = session_get_value('UID');

// Maximum attachment space
$max_attachment_space = attachments_get_max_space();

// Get user's free attachment space.
$users_free_space = attachments_get_free_space($uid, $aid);

// Get the array of allowed attachment mime-types
$attachment_mime_types = attachments_get_mime_types();

// Accumlative attachment file size.
$total_attachment_size = 0;

// Check that $attachment_dir does not have a slash on the end of it.
if (mb_substr($attachment_dir, -1) == '/') {
    $attachment_dir = mb_substr($attachment_dir, 0, -1);
}

// Arrays to hold successfully / failed / not allowed filenames
$upload_success = array();
$upload_failure = array();
$upload_not_allowed = array();

// Array to hold error messages
$error_msg_array = array();

// Start Stuff
if (isset($_POST['upload'])) {

    if (isset($_FILES['userfile']) && is_array($_FILES['userfile'])) {

        for ($i = 0; $i < sizeof($_FILES['userfile']['name']); $i++) {

            if (isset($_FILES['userfile']['name'][$i]) && strlen(trim($_FILES['userfile']['name'][$i])) > 0) {

                $filename = trim(stripslashes_array($_FILES['userfile']['name'][$i]));

                if (isset($_FILES['userfile']['error'][$i]) && $_FILES['userfile']['error'][$i] != UPLOAD_ERR_OK) {

                    $upload_failure[] = $filename;

                }else {

                    $file_size = $_FILES['userfile']['size'][$i];
                    $temp_file = $_FILES['userfile']['tmp_name'][$i];
                    $file_type = $_FILES['userfile']['type'][$i];
                    
                    if (function_exists('mime_content_type') && ($magic_mime_type = mime_content_type($temp_file))) {
                        $file_type = $magic_mime_type;
                    }

                    if (sizeof($attachment_mime_types) > 0 && !in_array($file_type, $attachment_mime_types)) {

                        $upload_not_allowed[] = $filename;

                        if (@file_exists($temp_file)) {

                            unlink($temp_file);
                        }

                    }else if (($max_attachment_space > 0) && ($users_free_space < $file_size)) {

                        $upload_failure[] = $filename;

                        if (@file_exists($temp_file)) {

                            unlink($temp_file);
                        }

                    }else {

                        $unique_file_id = md5(uniqid(mt_rand()));

                        $file_hash = md5("{$aid}{$unique_file_id}{$filename}");
                        $file_path = "$attachment_dir/$file_hash";

                        if (@move_uploaded_file($temp_file, $file_path)) {

                            attachments_add($uid, $aid, $unique_file_id, $filename, $file_type);

                            attachments_create_thumb($file_hash);

                            if (($users_free_space > 0)) {
                                $users_free_space -= $file_size;
                            }

                            $upload_success[] = $filename;

                        }else {

                            if (@file_exists($temp_file)) {
                                unlink($temp_file);
                            }

                            $upload_failure[] = $filename;
                        }
                    }
                }
            }
        }
    }

}elseif (isset($_POST['delete_confirm'])) {

    $valid = true;

    if (isset($_POST['attachments_delete_confirm']) && is_array($_POST['attachments_delete_confirm'])) {

        foreach ($_POST['attachments_delete_confirm'] as $hash => $del_attachment) {

            if ($del_attachment == "Y" && attachments_get_by_hash($hash)) {

                if (!attachments_delete($hash)) {

                    $valid = false;
                    $error_msg_array[] = gettext("Failed to delete all of the selected attachments");
                }
            }
        }

        if ($valid) {

            header_redirect("attachments.php?webtag=$webtag&aid=$aid");
            exit;
        }
    }

}elseif (isset($_POST['delete'])) {

    $hash_array = array();

    if (isset($_POST['attachments_delete']) && is_array($_POST['attachments_delete'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['attachments_delete']));
    }

    if (isset($_POST['delete_other_attachment']) && is_array($_POST['delete_other_attachment'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['delete_other_attachment']));
    }

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        $attachments_array = array();
        $image_attachments_array = array();

        if (attachments_get($uid, $aid, $attachments_array, $image_attachments_array, $hash_array)) {

            html_draw_top("title=", gettext("Delete attachments"), "", 'pm_popup_disabled', 'class=window_title');

            echo "<h1>", gettext("Delete attachments"), "</h1>\n";
            echo "<br />\n";
            echo "<form accept-charset=\"utf-8\" name=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php\">\n";
            echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
            echo "  ". form_input_hidden('aid', htmlentities_array($aid)), "\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", gettext("Delete attachments"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", gettext("Are you sure you want to delete the selected attachments?"), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"center\">\n";
            echo "                          <table class=\"posthead\" width=\"95%\">\n";
            echo "                            <tr>\n";
            echo "                              <td><br />\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                foreach ($attachments_array as $attachment) {

                    echo "                                ", attachments_make_link($attachment, false, false), "<br />\n";
                    echo "                                ", form_input_hidden("attachments_delete_confirm[{$attachment['hash']}]", "Y"), "\n";
                }
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                foreach ($image_attachments_array as $key => $attachment) {

                    echo "                                ", attachments_make_link($attachment, false, false), "<br />\n";
                    echo "                                ", form_input_hidden("attachments_delete_confirm[{$attachment['hash']}]", "Y"), "\n";
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
            echo "      <td align=\"center\">", form_submit("delete_confirm", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }
}

html_draw_top("title=", gettext("Attachments"), "", 'attachments.js', 'onload=add_upload_field_link()', 'pm_popup_disabled', 'class=window_title');

echo "<h1>", gettext("Attachments"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}else {

    if (isset($upload_success) && is_array($upload_success) && sizeof($upload_success) > 0) {
        html_display_success_msg(sprintf(gettext("Successfully Uploaded: %s"), htmlentities_array(implode(", ", $upload_success))), '600', 'left');
    }

    if (isset($upload_failure) && is_array($upload_failure) && sizeof($upload_failure) > 0) {
        html_display_error_msg(sprintf(gettext("Failed to upload: %s. Check free attachment space!"), htmlentities_array(implode(", ", $upload_failure))), '600', 'left');
    }

    if (isset($upload_not_allowed) && is_array($upload_not_allowed) && sizeof($upload_not_allowed) > 0) {
        html_display_error_msg(sprintf(gettext("Failed to upload: %s. File type is not allowed!"), htmlentities_array(implode(", ", $upload_not_allowed))), '600', 'left');
    }
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"attachments.php\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ". form_input_hidden('aid', htmlentities_array($aid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">", gettext("Upload a file for attachment to the message"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\" class=\"postbody\" valign=\"top\">", gettext("Enter filename(s) to upload"), " :</td>\n";
echo "                        <td align=\"left\" class=\"postbody\">\n";
echo "                          ", form_input_file("userfile[]", "", 30, 0), "\n";
echo "                          <div class=\"upload_fields\">\n";
echo "                            <img src=\"", html_style_image('attach.png'), "\" border=\"0\" alt=\"", gettext("Attachment"), "\" title=\"", gettext("Attachment"), "\" />";
echo "                            <a class=\"add_upload_field\">", gettext("Upload another attachment"), "</a>\n";
echo "                          </div>\n";
echo "                        </td>\n";
echo "                        <td align=\"left\" class=\"postbody\" valign=\"top\">", form_submit("upload", gettext("Upload")), "</td>\n";
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

if (attachments_get($uid, $aid, $attachments_array, $image_attachments_array)) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_main", "toggle_main"), "</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments for this message"), "</td>\n";
    echo "                </tr>\n";

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if (($attachment_link = attachments_make_link($attachment, false))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("attachments_delete[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if (($attachment_link = attachments_make_link($attachment, false))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("attachments_delete[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";
                echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td width=\"25\" class=\"subhead_checkbox\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments for this message"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" colspan=\"5\" class=\"postbody\">(", gettext("none"), ")</td>\n";
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

if (attachments_get_all($uid, $aid, $attachments_array, $image_attachments_array)) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_other", "toggle_other"), "</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Other Attachments (including PM Messages and other forums)"), "</td>\n";
    echo "                </tr>\n";

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if (($attachment_link = attachments_make_link($attachment, false))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_other_attachment[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = attachments_get_message_link($attachment['aid'])) {

                    echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a></td>\n";

                }else {

                    echo "                  <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if (($attachment_link = attachments_make_link($attachment, false))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_other_attachment[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = attachments_get_message_link($attachment['aid'])) {

                    echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a></td>\n";

                }else {

                    echo "                  <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

}else {

    echo "                <tr>\n";
    echo "                  <td width=\"25\" class=\"subhead\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Other Attachments (including PM Messages and other forums)"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" colspan=\"4\" class=\"postbody\">(", gettext("none"), ")</td>\n";
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
echo "                  <td align=\"left\" colspan=\"5\" class=\"subhead\">", gettext("Usage"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">", gettext("Total Size"), ":</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                </tr>\n";

if (($max_attachment_space > 0)) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">", gettext("Free Space"), ":</td>\n";
    echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
    echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($users_free_space), "</td>\n";
    echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
    echo "                </tr>\n";
}

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
echo "      <td class=\"postbody\" colspan=\"2\" align=\"center\">", form_button("complete", gettext("Complete")), "&nbsp;", form_submit("delete", gettext("Delete")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>
