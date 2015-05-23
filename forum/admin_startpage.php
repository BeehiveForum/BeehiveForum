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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Array to hold error messages
$error_msg_array = array();

// Check to see if we're submitting new page or retrieving the old one.
if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
    $t_content = fix_html(emoticons_strip($_POST['t_content']), true);
} else {
    $t_content = forum_get_setting('start_page', 'strlen', '');
}

// Submit code.
if (isset($_POST['save'])) {

    // New array of forum settings.
    $new_forum_settings = array(
        'start_page' => $t_content
    );

    // Save the settings.
    if (forum_save_settings($new_forum_settings)) {

        // Update the admin log.
        admin_add_log_entry(EDITED_START_PAGE);

        // Redirect back to self.
        header_redirect("admin_startpage.php?webtag=$webtag&updated=true");
        exit;
    }

    // Save failed. Show error message.
    $error_msg_array[] = gettext("Start page could not be saved. Please try again.");

} else if (isset($_POST['upload'])) {

    // Check the temp file is set.
    if (isset($_FILES['cssfile']['tmp_name']) && strlen(trim($_FILES['cssfile']['tmp_name'])) > 0) {

        // Check for upload error.
        if (isset($_FILES['cssfile']['error']) && $_FILES['cssfile']['error'] != UPLOAD_ERR_OK) {

            // Upload failed. Don't bother going into detail.
            $error_msg_array[] = gettext("CSS style sheet could not be uploaded. Please try again.");

        } else if (isset($_FILES['cssfile']['type']) && trim($_FILES['cssfile']['type']) == 'text/css') {

            // Get path info for uploaded file.
            $path_parts = pathinfo($_FILES['cssfile']['name']);

            // Check the extension. This isn't fool proof, could be a renamed jpeg. Not sure
            // how to validate the content as CSS. Maybe try and parse it?
            if ((isset($path_parts['extension']) && $path_parts['extension'] == 'css')) {

                // Read the contents of the file.
                if (($start_page_css = @file_get_contents($_FILES['cssfile']['tmp_name'])) !== false) {

                    // New array of forum settings.
                    $new_forum_settings = array(
                        'start_page_css' => $start_page_css
                    );

                    // Save the settings.
                    if (forum_save_settings($new_forum_settings)) {

                        // Update admin log.
                        admin_add_log_entry(EDITED_START_PAGE);

                        // Redirect back to self.
                        header_redirect("admin_startpage.php?webtag=$webtag&uploaded=true");
                        exit;
                    }
                }
            }

            // Something went wrong above. Show Error message.
            $error_msg_array[] = gettext("CSS style sheet could not be uploaded. Please try again.");

        } else {

            // File does not look like text/css
            $error_msg_array[] = gettext("Invalid file type, you can only upload CSS style sheet files");
        }
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Edit Start Page'),
        'js' => array(
            'ckeditor/ckeditor.js'
        ),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Edit Start Page"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'center');

} else if (isset($_GET['updated'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", gettext("View updated Start Page"));
    html_display_success_msg(sprintf(gettext("Start Page updated. %s"), $start_page_link), '700', 'center');

} else if (isset($_GET['uploaded'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", gettext("View updated Start Page"));
    html_display_success_msg(sprintf(gettext("CSS style sheet uploaded. %s"), $start_page_link), '700', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"startpage\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin_startpage.php\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Start page"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("t_content", htmlentities_array($t_content), 20, 80, null, 'admin_tools_textarea_large editor'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Upload CSS style sheet"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Filename"), ": ", form_input_file("cssfile", null, 45), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("upload", gettext("Upload")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();