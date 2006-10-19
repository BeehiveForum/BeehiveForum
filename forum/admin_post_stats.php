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

/* $Id: admin_post_stats.php,v 1.24 2006-10-19 19:34:43 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    html_draw_top();
    echo "<h2>{$lang['accessdenied']}</h2>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top("robots=noindex,nofollow");

echo "  <h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['postingstats']}</h1>\n";
echo "  <br />\n";

if (isset($_POST['update'])) {

    $valid = true;
    $error_html = "";

    if (isset($_POST['from_day']) && is_numeric($_POST['from_day'])) {
        $from_day = $_POST['from_day'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseastartday']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['from_month']) && is_numeric($_POST['from_month'])) {
        $from_month = $_POST['from_month'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseastartmonth']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['from_year']) && is_numeric($_POST['from_year'])) {
        $from_year = $_POST['from_year'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseastartyear']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['to_day']) && is_numeric($_POST['to_day'])) {
        $to_day = $_POST['to_day'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseaendday']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['to_month']) && is_numeric($_POST['to_month'])) {
        $to_month = $_POST['to_month'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseaendmonth']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['to_year']) && is_numeric($_POST['to_year'])) {
        $to_year = $_POST['to_year'];
    }else {
        $error_html.= "<h2>{$lang['mustchooseaendyear']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        $stats_start = mktime(0, 0, 0, $from_month, $from_day, $from_year);
        $stats_end = mktime(23, 59, 59, $to_month, $to_day, $to_year);

        if ($stats_start > $stats_end) {

            $error_html.= "<h2>{$lang['startperiodisaheadofendperiod']}</h2>\n";
            $valid = false;

        }else {

            $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;
            $user_stats_array = get_post_tallys($stats_start, $stats_end);
        }
    }
}

if (!isset($user_stats_array) || !is_array($user_stats_array)) {

    // Default to showing the stats for this month only

    $from_day = 1;
    $from_month = date('n');
    $from_year = date('Y');

    $to_day = date('t');
    $to_month = date('n');
    $to_year = date('Y');

    $stats_start = mktime(0, 0, 0, $from_month, $from_day, $from_year);
    $stats_end = mktime(23, 59, 59, $to_month, $to_day, $to_year);

    $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;

    $user_stats_array = get_post_tallys($stats_start, $stats_end);
}

if (isset($error_html) && strlen($error_html) > 0) {
    echo $error_html;
    echo "<br />\n";
}

echo "  <div align=\"center\">\n";
echo "  <h2>", sprintf($lang['top20postersforperiod'], date("d/m/Y", $stats_start), date("d/m/Y", $stats_end)), "</h2>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['user']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['totalposts']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['posts']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['percent']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['average']}</td>\n";
echo "                </tr>\n";

if (sizeof($user_stats_array['user_stats']) > 0) {

    foreach ($user_stats_array['user_stats'] as $user_stats) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">", add_wordfilter_tags(format_user_name($user_stats['LOGON'], $user_stats['NICKNAME'])), "</td>\n";
        echo "                  <td align=\"left\">", user_get_post_count($user_stats['UID']), "</td>\n";
        echo "                  <td align=\"left\">{$user_stats['POST_COUNT']}</td>\n";
        echo "                  <td align=\"left\">", number_format(round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), 2, '.', ','), "%</td>\n";
        echo "                  <td align=\"left\">", number_format(round($user_stats['POST_COUNT'] / ($num_days), 2), 2, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"5\">{$lang['nodata']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"5\" align=\"center\">{$lang['totalpostsforthisperiod']}: {$user_stats_array['post_count']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form action=\"admin_post_stats.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"center\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"350\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">Date from:</td>\n";
echo "            <td align=\"left\">", form_date_dropdowns($from_year, $from_month, $from_day, "from_", 2002), "</td>\n";
echo "          </tr>\n";
echo "            <td align=\"left\">Date to:</td>\n";
echo "            <td align=\"left\">", form_date_dropdowns($to_year, $to_month, $to_day, "to_", 2002), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"left\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['update']), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "  </div>\n";

html_draw_bottom();

?>