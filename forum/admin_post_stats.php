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
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'stats.inc.php';
require_once BH_INCLUDE_PATH . 'user_profile.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
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

// Array to hold error messages
$error_msg_array = array();

// Empty array for the stats
$user_stats_array = array(
    'user_stats' => array()
);

$stats_start = null;
$stats_end = null;
$from_day = null;
$from_month = null;
$from_year = null;
$to_day = null;
$to_month = null;
$to_year = null;

// Submit code
if (isset($_POST['update'])) {

    $valid = true;

    if (isset($_POST['from_day']) && is_numeric($_POST['from_day'])) {
        $from_day = $_POST['from_day'];
    } else {
        $error_msg_array[] = gettext("Must choose a start day");
        $valid = false;
    }

    if (isset($_POST['from_month']) && is_numeric($_POST['from_month'])) {
        $from_month = $_POST['from_month'];
    } else {
        $error_msg_array[] = gettext("Must choose a start month");
        $valid = false;
    }

    if (isset($_POST['from_year']) && is_numeric($_POST['from_year'])) {
        $from_year = $_POST['from_year'];
    } else {
        $error_msg_array[] = gettext("Must choose a start year");
        $valid = false;
    }

    if (isset($_POST['to_day']) && is_numeric($_POST['to_day'])) {
        $to_day = $_POST['to_day'];
    } else {
        $error_msg_array[] = gettext("Must choose an end day");
        $valid = false;
    }

    if (isset($_POST['to_month']) && is_numeric($_POST['to_month'])) {
        $to_month = $_POST['to_month'];
    } else {
        $error_msg_array[] = gettext("Must choose an end month");
        $valid = false;
    }

    if (isset($_POST['to_year']) && is_numeric($_POST['to_year'])) {
        $to_year = $_POST['to_year'];
    } else {
        $error_msg_array[] = gettext("Must choose an end year");
        $valid = false;
    }

    if ($valid) {

        $stats_start = mktime(0, 0, 0, $from_month, $from_day, $from_year);
        $stats_end = mktime(23, 59, 59, $to_month, $to_day, $to_year);

        if ($stats_start > $stats_end) {

            $error_msg_array[] = gettext("Start period is ahead of end period");
            $valid = false;

        } else {

            $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;
            $user_stats_array = stats_get_post_tallys($stats_start, $stats_end);
        }
    }

} else {

    $from_day = 1;
    $from_month = date('n');
    $from_year = date('Y');
    $to_day = date('t');
    $to_month = date('n');
    $to_year = date('Y');

    $stats_start = mktime(0, 0, 0, date('n'), 1, date('Y'));
    $stats_end = mktime(23, 59, 59, date('n'), date('t'), date('Y'));

    $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;

    $user_stats_array = stats_get_post_tallys($stats_start, $stats_end);
}

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Admin - Posting Stats For Period %s to %s'),
            format_date_time($stats_start),
            format_date_time($stats_end)
        ),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), sprintf(gettext("Posting Stats For Period %s to %s"), format_date_time($stats_start), format_date_time($stats_end)), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (sizeof($user_stats_array['user_stats']) < 1) {

    html_display_warning_msg(gettext("No post data recorded for this period."), '86%', 'center');
}

echo "  <br />\n";
echo "  <div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">", gettext("User"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">", gettext("Total posts"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">", gettext("Posts"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">", gettext("Percent"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">", gettext("Average"), "</td>\n";
echo "                </tr>\n";

if (sizeof($user_stats_array['user_stats']) > 0) {

    foreach ($user_stats_array['user_stats'] as $user_stats) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">", word_filter_add_ob_tags(format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']), true), "</td>\n";
        echo "                  <td align=\"center\">", user_get_post_count($user_stats['UID']), "</td>\n";
        echo "                  <td align=\"center\">{$user_stats['POST_COUNT']}</td>\n";
        echo "                  <td align=\"center\">", format_number(round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), 2), "%</td>\n";
        echo "                  <td align=\"center\">", format_number(round($user_stats['POST_COUNT'] / ($num_days), 2), 2), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"6\" align=\"center\">", gettext("Total posts for this period"), ": {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form accept-charset=\"utf-8\" action=\"admin_post_stats.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"100\">", gettext("Posted from"), ":</td>\n";
echo "                        <td align=\"left\">", form_date_dropdowns($from_year, $from_month, $from_day, "from_", 2002), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"100\">", gettext("Posted to"), ":</td>\n";
echo "                        <td align=\"left\">", form_date_dropdowns($to_year, $to_month, $to_day, "to_", 2002), "</td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", gettext("Update")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "  </div>\n";

html_draw_bottom();