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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check that required variables are set
if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

} else if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

    $fid = $_POST['fid'];

} else {

    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

// Get the folder ID for the current message
if (!$folder_data = folder_get($fid)) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

// Get the existing thread data.
if (!folder_is_accessible($fid)) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

// Array to hold error messages
$error_msg_array = array();

// Submit Code
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['interest']) && is_numeric($_POST['interest'])) {

        $folder_data['INTEREST'] = $_POST['interest'];

        if (!user_set_folder_interest($fid, $folder_data['INTEREST'])) {

            $error_msg_array[] = gettext("Failed to update folder interest");
            $valid = false;
        }
    }

    if ($valid) {

        header_redirect("folder_options.php?webtag=$webtag&fid=$fid&updated=true");
        exit;
    }
}

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Folder Options - %s'),
            $folder_data['TITLE']
        ),
        'base_target' => '_blank',
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Folder Options"), html_style_image('separator'), word_filter_add_ob_tags($folder_data['TITLE'], true), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '500', 'center');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Updates saved successfully"), '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"folder_options\" action=\"folder_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("fid", htmlentities_array($fid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Interest"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">", gettext("Interest"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_IGNORED, gettext("Ignore"), $folder_data['INTEREST'] == FOLDER_IGNORED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_NOINTEREST, gettext("Normal"), $folder_data['INTEREST'] == FOLDER_NOINTEREST), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("interest", FOLDER_SUBSCRIBED, gettext("Subscribe"), $folder_data['INTEREST'] == FOLDER_SUBSCRIBED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_button("close_popup", gettext("Close")) . "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();