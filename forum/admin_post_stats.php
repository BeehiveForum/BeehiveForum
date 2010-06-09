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

/* $Id$ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Empty array for the stats

$user_stats_array = array('user_stats' => array());

// Submit code

if (isset($_POST['update'])) {

    $valid = true;

    if (isset($_POST['from_day']) && is_numeric($_POST['from_day'])) {
        $from_day = $_POST['from_day'];
    }else {
        $error_msg_array[] = $lang['mustchooseastartday'];
        $valid = false;
    }

    if (isset($_POST['from_month']) && is_numeric($_POST['from_month'])) {
        $from_month = $_POST['from_month'];
    }else {
        $error_msg_array[] = $lang['mustchooseastartmonth'];
        $valid = false;
    }

    if (isset($_POST['from_year']) && is_numeric($_POST['from_year'])) {
        $from_year = $_POST['from_year'];
    }else {
        $error_msg_array[] = $lang['mustchooseastartyear'];
        $valid = false;
    }

    if (isset($_POST['to_day']) && is_numeric($_POST['to_day'])) {
        $to_day = $_POST['to_day'];
    }else {
        $error_msg_array[] = $lang['mustchooseaendday'];
        $valid = false;
    }

    if (isset($_POST['to_month']) && is_numeric($_POST['to_month'])) {
        $to_month = $_POST['to_month'];
    }else {
        $error_msg_array[] = $lang['mustchooseaendmonth'];
        $valid = false;
    }

    if (isset($_POST['to_year']) && is_numeric($_POST['to_year'])) {
        $to_year = $_POST['to_year'];
    }else {
        $error_msg_array[] = $lang['mustchooseaendyear'];
        $valid = false;
    }

    if ($valid) {

        $stats_start = mktime(0, 0, 0, $from_month, $from_day, $from_year);
        $stats_end = mktime(23, 59, 59, $to_month, $to_day, $to_year);

        if ($stats_start > $stats_end) {

            $error_msg_array[] = $lang['startperiodisaheadofendperiod'];
            $valid = false;

        }else {

            $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;
            $user_stats_array = stats_get_post_tallys($stats_start, $stats_end);
        }
    }

}else {

    $from_day = 1; $from_month = date('n'); $from_year = date('Y');
    $to_day = date('t'); $to_month = date('n'); $to_year = date('Y');

    $stats_start = mktime(0, 0, 0, date('n'), 1, date('Y'));
    $stats_end = mktime(23, 59, 59, date('n'), date('t'), date('Y'));

    $num_days = ((($stats_end - $stats_start) / 60) / 60) / 24;

    $user_stats_array = stats_get_post_tallys($stats_start, $stats_end);
}

html_draw_top("title={$lang['admin']} » ". sprintf($lang['postingstatsforperiod'], date("d/m/Y", $stats_start), date("d/m/Y", $stats_end)), 'class=window_title');

echo "<h1>{$lang['admin']} &raquo; ", sprintf($lang['postingstatsforperiod'], date("d/m/Y", $stats_start), date("d/m/Y", $stats_end)), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'center');

}else if (sizeof($user_stats_array['user_stats']) < 1) {

    html_display_warning_msg($lang['nopostdatarecordedforthisperiod'], '700', 'center');
}

echo "  <br />\n";
echo "  <div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">{$lang['user']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">{$lang['totalposts']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">{$lang['posts']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">{$lang['percent']}</td>\n";
echo "                  <td align=\"center\" class=\"subhead\" width=\"120\">{$lang['average']}</td>\n";
echo "                </tr>\n";

if (sizeof($user_stats_array['user_stats']) > 0) {

    foreach ($user_stats_array['user_stats'] as $user_stats) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']))), "</td>\n";
        echo "                  <td align=\"center\">", user_get_post_count($user_stats['UID']), "</td>\n";
        echo "                  <td align=\"center\">{$user_stats['POST_COUNT']}</td>\n";
        echo "                  <td align=\"center\">", number_format(round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), 2, '.', ','), "%</td>\n";
        echo "                  <td align=\"center\">", number_format(round($user_stats['POST_COUNT'] / ($num_days), 2), 2, '.', ','), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"6\" align=\"center\">{$lang['totalpostsforthisperiod']}: {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";

}else {

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
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"100\">{$lang['postedfrom']}:</td>\n";
echo "                        <td align=\"left\">", form_date_dropdowns($from_year, $from_month, $from_day, "from_", 2002), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"100\">{$lang['postedto']}:</td>\n";
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
echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['update']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "  </div>\n";

html_draw_bottom();

?>