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

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

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
if (!($attachment_dir = attachments_check_dir())) {
    html_draw_error(gettext("Attachments have been disabled by the forum owner."));
}

// Total attachment space used
$total_attachment_size = attachments_get_user_used_space($_SESSION['UID']);

// Free space
$attachment_free_user_space = attachments_get_free_user_space($_SESSION['UID']);

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

            header_redirect("edit_attachments.php?webtag=$webtag");
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

            header_redirect("edit_attachments.php?webtag=$webtag");
            exit;
        }
    }

} else if (isset($_POST['delete']) || isset($_POST['delete_thumbs'])) {

    $hash_array = array();

    if (isset($_POST['attachments_delete']) && is_array($_POST['attachments_delete'])) {
        $hash_array = array_keys($_POST['attachments_delete']);
    }

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        if (($attachments_array = attachments_get($_SESSION['UID'], $hash_array)) !== false) {

            if (isset($_POST['delete_thumbs'])) {

                html_draw_top(
                    array(
                        'title' => gettext('Delete Thumbnails'),
                        'pm_popup_disabled' => true,
                        'class' => 'window_title'
                    )
                );

                echo "<h1>", gettext("Delete Thumbnails"), "</h1>\n";

            } else {

                html_draw_top(
                    array(
                        'title' => gettext('Delete Thumbnails'),
                        'pm_popup_disabled' => true,
                        'class' => 'window_title'
                    )
                );

                echo "<h1>", gettext("Delete attachments"), "</h1>\n";
            }

            echo "<br />\n";
            echo "<form accept-charset=\"utf-8\" id=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"edit_attachments.php\">\n";
            echo "  ", form_csrf_token_field(), "\n";
            echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
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

html_draw_top(
    array(
        'title' => gettext('Attachments'),
        'js' => array(
            'js/attachments.js',
            'js/prefs.js',
        ),
        'pm_popup_disabled' => true,
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Attachments"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '700', 'center');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"attachments\" method=\"post\" action=\"edit_attachments.php\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if (($attachments_array = attachments_get_all($_SESSION['UID'])) !== false) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_main", "toggle_main"), "</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments"), "</td>\n";
    echo "                </tr>\n";

    foreach ($attachments_array as $key => $attachment) {

        if (($attachment_link = attachments_make_link($attachment, false, true)) !== false) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\" width=\"1%\">", form_checkbox("attachments_delete[{$attachment['hash']}]", "Y"), "</td>\n";
            echo "                  <td align=\"left\" valign=\"middle\" style=\"white-space: nowrap\" class=\"postbody\">$attachment_link</td>\n";
            echo "                  <td align=\"left\" valign=\"middle\" style=\"white-space: nowrap\" class=\"postbody\">";

            if (($message_link = attachments_get_message_link($attachment['hash'])) !== false) {

                echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";

            } else if (($message_link = attachments_get_pm_link($attachment['hash'])) !== false) {

                echo "<a href=\"$message_link\" target=\"_blank\">", gettext("View Message"), "</a>";

            } else {

                echo '&nbsp;';
            }

            echo "</td>\n";

            if (isset($attachment['filesize']) && ($attachment['filesize'] > 0)) {
                echo "                  <td align=\"right\" valign=\"middle\" style=\"white-space: nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
            } else {
                echo "                  <td align=\"right\" valign=\"middle\" class=\"postbody\">", gettext("Unknown size"), "</td>\n";
            }

            echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
            echo "                </tr>\n";
        }
    }

} else {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"25\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">", gettext("Attachments"), "</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
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
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">", gettext("Free Space"), ":</td>\n";
echo "                  <td align=\"left\" valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                  <td align=\"right\" valign=\"top\" class=\"postbody\">", ($attachment_free_user_space >= 0) ? format_file_size($attachment_free_user_space) : gettext('Unlimited'), "</td>\n";
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
echo "      <td align=\"center\">";
echo "        ", form_submit('delete', gettext("Delete"));
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();