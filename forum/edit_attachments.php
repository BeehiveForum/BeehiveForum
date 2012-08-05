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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Arrays to hold our attachments
$attachments_array = array();
$image_attachments_array = array();

// If attachments are disabled then no need to go any further.
if (forum_get_setting('attachments_enabled', 'N')) {
    html_draw_error(gettext("Attachments have been disabled by the forum owner."));
}

// If the attachments directory is undefined we can't go any further
if (!$attachment_dir = attachments_check_dir()) {
    html_draw_error(gettext("Attachments have been disabled by the forum owner."));
}

// Get any UID from the GET or POST request
// or default to the current user if not specified.
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

} else if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {

    $uid = $_POST['uid'];

} else {

    $uid = session::get_value('UID');
}

if (isset($_GET['popup']) && is_numeric($_GET['popup'])) {

    $popup = $_GET['popup'];

} else if (isset($_POST['popup']) && is_numeric($_POST['popup'])) {

    $popup = $_POST['popup'];

} else {

    $popup = 0;
}

// Get any AID from the GET or POST request
if (isset($_GET['aid']) && is_md5($_GET['aid'])) {

    $aid = $_GET['aid'];

    if (!$t_fid = attachments_get_folder_fid($aid)) {
        html_draw_error(gettext("AID not specified."));
    }

} else if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

    if (!$t_fid = attachments_get_folder_fid($aid)) {
        html_draw_error(gettext("AID not specified."));
    }

} else {

    $aid = false;
    $t_fid = 0;
}

// Check that the UID we have belongs to the current user
// or that it is an admin if we're viewing another user's
// attachments.
if (($uid != session::get_value('UID')) && !(session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Total attachment space used
$total_attachment_size = 0;

// Free space
if (is_md5($aid)) {

    $users_free_space = attachments_get_free_post_space($aid);

} else {

    $users_free_space = attachments_get_free_user_space($uid);
}

// Check for attachment deletion.
if (isset($_POST['delete_confirm'])) {

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

            header_redirect("edit_attachments.php?webtag=$webtag&aid=$aid&popup=$popup");
            exit;
        }
    }

} else if (isset($_POST['delete_thumbs_confirm'])) {

    $valid = true;

    if (isset($_POST['attachments_delete_confirm']) && is_array($_POST['attachments_delete_confirm'])) {

        foreach ($_POST['attachments_delete_confirm'] as $hash => $del_attachment) {

            if ($del_attachment == "Y" && attachments_get_by_hash($hash)) {

                if (!attachments_delete_thumbnail($hash)) {

                    $valid = false;
                    $error_msg_array[] = gettext("Failed to delete all of the selected attachment thumbnails");
                }
            }
        }

        if ($valid) {

            header_redirect("edit_attachments.php?webtag=$webtag&aid=$aid&popup=$popup");
            exit;
        }
    }

} else if (isset($_POST['delete']) || isset($_POST['delete_thumbs'])) {

    $hash_array = array();

    if (isset($_POST['attachments_delete']) && is_array($_POST['attachments_delete'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['attachments_delete']));
    }

    if (isset($_POST['delete_other_attachment']) && is_array($_POST['delete_other_attachment'])) {
        $hash_array = array_merge($hash_array, array_keys($_POST['delete_other_attachment']));
    }

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        if (attachments_get_users($uid, $attachments_array, $image_attachments_array, $hash_array)) {

            if (isset($_POST['delete_thumbs'])) {

                html_draw_top("title=", gettext("Delete Thumbnails"), "", 'pm_popup_disabled', 'class=window_title');
                echo "<h1>", gettext("Delete Thumbnails"), "</h1>\n";

            } else {

                html_draw_top("title=", gettext("Delete attachments"), "", 'pm_popup_disabled', 'class=window_title');
                echo "<h1>", gettext("Delete attachments"), "</h1>\n";
            }

            echo "<br />\n";
            echo "<form accept-charset=\"utf-8\" id=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"edit_attachments.php\">\n";
            echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
            echo "  ", form_input_hidden('popup', htmlentities_array($popup)), "\n";
            echo "  ". form_input_hidden('aid', htmlentities_array($aid)), "\n";
            echo "  ". form_input_hidden('uid', htmlentities_array($uid)), "\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";

            if (isset($_POST['delete_thumbs'])) {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\">", gettext("Delete Thumbnails"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"90%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", gettext("Are you sure you want to delete the selected attachments thumbnails?"), "</td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\">", gettext("Delete attachments"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"90%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">", gettext("Are you sure you want to delete the selected attachments?"), "</td>\n";
                echo "                      </tr>\n";
            }

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

            if (isset($_POST['delete_thumbs'])) {

                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_submit("delete_thumbs_confirm", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
                echo "    </tr>\n";

            } else {

                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_submit("delete_confirm", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
                echo "    </tr>\n";
            }

            echo "  </table>\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }
}

html_draw_top("title=", gettext("Attachments"), "", 'attachments.js', 'post.js', 'pm_popup_disabled', 'class=window_title');

echo "<h1>", gettext("Attachments"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '600', 'center');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"attachments\" method=\"post\" action=\"edit_attachments.php\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('popup', htmlentities_array($popup)), "\n";
echo "  ". form_input_hidden('aid', htmlentities_array($aid)), "\n";
echo "  ". form_input_hidden('uid', htmlentities_array($uid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if (is_md5($aid)) {

    $attachment_result = attachments_get($uid, $aid, $attachments_array, $image_attachments_array);

} else {

    $attachment_result = attachments_get_users($uid, $attachments_array, $image_attachments_array);
}

if ($attachment_result) {

    if (is_md5($aid)) {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_main", "toggle_main"), "</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments for this message"), "</td>\n";
        echo "                </tr>\n";

    } else {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_main", "toggle_main"), "</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments"), "</td>\n";
        echo "                </tr>\n";
    }

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if (($attachment_link = attachments_make_link($attachment, false, true))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("attachments_delete[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (!is_md5($aid) && is_md5($attachment['aid'])) {
                    
                    echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">";
                    
                    if (($message_link = attachments_get_message_link($attachment['aid']))) {
                        
                        echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                    
                    } else if (($message_link = attachments_get_pm_link($attachment['aid']))) {
                        
                        echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                    
                    } else {
                        
                        echo '&nbsp;';
                    }
                    
                    echo "</td>\n";

                } else {

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

            if (($attachment_link = attachments_make_link($attachment, false, true))) {

                echo "                <tr>\n";
                echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("attachments_delete[{$attachment['hash']}]", "Y"), "</td>\n";
                echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (!is_md5($aid) && is_md5($attachment['aid'])) {
                    
                    echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">";
                    
                    if (($message_link = attachments_get_message_link($attachment['aid']))) {
                        
                        echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                    
                    } else if (($message_link = attachments_get_pm_link($attachment['aid']))) {
                        
                        echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                    
                    } else {
                        
                        echo '&nbsp;';
                    }
                    
                    echo "</td>\n";

                } else {

                    echo "                  <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                echo "                </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

} else {

    if (is_md5($aid)) {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"25\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments for this message"), "</td>\n";
        echo "                </tr>\n";

    } else {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"25\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments"), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"center\" width=\"25\">&nbsp;</td>\n";
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

if ($uid == session::get_value('UID') && is_md5($aid)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    if (attachments_get_all(session::get_value('UID'), $aid, $attachments_array, $image_attachments_array)) {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" width=\"1%\">", form_checkbox("toggle_other", "toggle_other"), "</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Other Attachments (including PM Messages and other forums)"), "</td>\n";
        echo "                </tr>\n";

        if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

            foreach ($attachments_array as $key => $attachment) {

                if (($attachment_link = attachments_make_link($attachment, false))) {

                    echo "                <tr>\n";
                    echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("delete_other_attachment[{$attachment['hash']}]", "Y"), "</td>\n";
                    echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";

                    if (!is_md5($aid) && is_md5($attachment['aid'])) {
                        
                        echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">";
                        
                        if (($message_link = attachments_get_message_link($attachment['aid']))) {
                            
                            echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                        
                        } else if (($message_link = attachments_get_pm_link($attachment['aid']))) {
                            
                            echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                        
                        } else {
                            
                            echo '&nbsp;';
                        }
                        
                        echo "</td>\n";

                    } else {

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

                    if (!is_md5($aid) && is_md5($attachment['aid'])) {
                        
                        echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">";
                        
                        if (($message_link = attachments_get_message_link($attachment['aid']))) {
                            
                            echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                        
                        } else if (($message_link = attachments_get_pm_link($attachment['aid']))) {
                            
                            echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";
                        
                        } else {
                            
                            echo '&nbsp;';
                        }
                        
                        echo "</td>\n";

                    } else {

                        echo "                  <td align=\"left\">&nbsp;</td>\n";
                    }

                    echo "                  <td align=\"right\" valign=\"top\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                    echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
                    echo "                </tr>\n";

                    $total_attachment_size += $attachment['filesize'];
                }
            }
        }

    } else {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead_checkbox\" width=\"20\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Other Attachments (including PM Messages and other forums)"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\" width=\"25\">&nbsp;</td>\n";
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
}

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

if (is_md5($aid)) {

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

if ($uid == session::get_value('UID')) {

    if (!is_md5($aid)) $aid = md5(uniqid(mt_rand()));

    if ($popup == 1) {

        echo "    <tr>\n";
        echo "      <td align=\"center\">";
        echo "        <a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
        echo "        &nbsp;", form_submit('delete', gettext("Delete")), "&nbsp;", form_submit('close', gettext("Close"));
        echo "      </td>\n";
        echo "    </tr>\n";

    } else {

        echo "    <tr>\n";
        echo "      <td align=\"center\">";
        echo "        <a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
        echo "        &nbsp;", form_submit('delete', gettext("Delete"));
        echo "      </td>\n";
        echo "    </tr>\n";
    }

} else if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    if ($popup == 1) {

        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit('delete', gettext("Delete")), "&nbsp;", form_submit('delete_thumbs', gettext("Delete Thumbnails")), "&nbsp;", form_submit('close', gettext("Close")), "</td>\n";
        echo "    </tr>\n";

    } else {

        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit('delete', gettext("Delete")), "&nbsp;", form_button('complete', gettext("Close")), "</td>\n";
        echo "    </tr>\n";
    }
}

echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>