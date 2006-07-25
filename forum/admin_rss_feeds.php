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

/* $Id: admin_rss_feeds.php,v 1.13 2006-07-25 21:43:50 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "rss_feed.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

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

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_rssid']) && is_array($_POST['t_rssid'])) {

        foreach($_POST['t_rssid'] as $rssid => $value) {

            if (isset($_POST['t_delete'][$rssid]) && $_POST['t_delete'][$rssid] == "Y") {

                rss_remove_feed($rssid);

            }else {

                if (isset($_POST['t_name'][$rssid]) && strlen(trim(_stripslashes($_POST['t_name'][$rssid]))) > 0) {
                    $t_new_name = trim(_stripslashes($_POST['t_name'][$rssid]));
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeedname']}</h2>\n";
                }

                if (isset($_POST['t_old_name'][$rssid]) && strlen(trim(_stripslashes($_POST['t_old_name'][$rssid]))) > 0) {
                    $t_old_name = trim(_stripslashes($_POST['t_old_name'][$rssid]));
                }else {
                    $t_old_name = "";
                }

                if (isset($_POST['t_user'][$rssid]) && strlen(trim(_stripslashes($_POST['t_user'][$rssid]))) > 0) {
                    $t_new_user = trim(_stripslashes($_POST['t_user'][$rssid]));
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeeduseraccount']}</h2>\n";
                }

                if (isset($_POST['t_old_user'][$rssid]) && strlen(trim(_stripslashes($_POST['t_old_user'][$rssid]))) > 0) {
                    $t_old_user = trim(_stripslashes($_POST['t_old_user'][$rssid]));
                }else {
                    $t_old_user = "";
                }

                if (isset($_POST['t_fid'][$rssid]) && is_numeric($_POST['t_fid'][$rssid])) {
                    $t_new_fid = $_POST['t_fid'][$rssid];
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeedfolder']}</h2>\n";
                }

                if (isset($_POST['t_old_fid'][$rssid]) && is_numeric($_POST['t_old_fid'][$rssid])) {
                    $t_old_fid = $_POST['t_old_fid'][$rssid];
                }else {
                    $t_old_fid = "";
                }

                if (isset($_POST['t_url'][$rssid]) && strlen(trim(_stripslashes($_POST['t_url'][$rssid]))) > 0) {
                    $t_new_url = $_POST['t_url'][$rssid];
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeedurl']}</h2>\n";
                }

                if (isset($_POST['t_old_url'][$rssid]) && strlen(trim(_stripslashes($_POST['t_old_url'][$rssid]))) > 0) {
                    $t_old_url = $_POST['t_old_url'][$rssid];
                }else {
                    $t_old_url = "";
                }

                if (isset($_POST['t_prefix'][$rssid]) && strlen(trim(_stripslashes($_POST['t_prefix'][$rssid]))) > 0) {
                    $t_new_prefix = $_POST['t_prefix'][$rssid];
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeedprefix']}</h2>\n";
                }

                if (isset($_POST['t_old_prefix'][$rssid]) && strlen(trim(_stripslashes($_POST['t_old_prefix'][$rssid]))) > 0) {
                    $t_old_prefix = $_POST['t_old_prefix'][$rssid];
                }else {
                    $t_old_prefix = "";
                }

                if (isset($_POST['t_frequency'][$rssid]) && is_numeric($_POST['t_frequency'][$rssid])) {
                    $t_new_frequency = $_POST['t_frequency'][$rssid];
                }else {
                    $valid = false;
                    $error_html = "<h2>{$lang['mustspecifyrssfeedupdatefrequency']}</h2>\n";
                }

                if (isset($_POST['t_old_frequency'][$rssid]) && is_numeric($_POST['t_old_frequency'][$rssid])) {
                    $t_old_frequency = $_POST['t_old_frequency'][$rssid];
                }else {
                    $t_old_frequency = "";
                }

                if ($valid && (($t_new_name != $t_old_name) || ($t_new_user != $t_old_user) || ($t_new_fid != $t_old_fid) || ($t_new_url != $t_old_url) || ($t_new_prefix != $t_old_prefix) || ($t_new_frequency != $t_old_frequency))) {

                    if ($t_user_array = user_get_uid($t_new_user)) {

                        $t_new_uid = $t_user_array['UID'];

                        if (rss_feed_update($rssid, $t_new_name, $t_new_uid, $t_new_fid, $t_new_url, $t_new_prefix, $t_new_frequency)) {

                            admin_add_log_entry(EDITED_RSS_FEED, array($t_new_name, $t_old_name, $t_new_user, $t_old_user, $t_new_fid, $t_old_fid, $t_new_url, $t_old_url, $t_new_prefix, $t_old_prefix, $t_new_frequency, $t_old_frequency));
                        }

                    }else {

                        $valid = false;
                        $error_html = "<h2>{$lang['unknownrssuseraccount']}</h2>\n";
                    }
                }
            }
        }
    }

    if ($valid) {

        if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {

            if (trim(_stripslashes($_POST['t_name_new'])) != $lang['newitem']) {

                $t_name_new = trim(_stripslashes($_POST['t_name_new']));

            }else {

                $valid = false;
            }

        }else {

            $valid = false;
            $error_html = "<h2>{$lang['mustspecifyrssfeedname']}</h2>\n";
        }

        if ($valid) {


            if (isset($_POST['t_user_new']) && strlen(trim(_stripslashes($_POST['t_user_new']))) > 0) {

                $t_user_new = trim(_stripslashes($_POST['t_user_new']));

                if ($t_user_array = user_get_uid($t_user_new)) {

                    $t_user_uid = $t_user_array['UID'];

                }else {

                    $valid = false;
                    $error_html = "<h2>{$lang['unknownrssuseraccount']}</h2>\n";
                }

            }else {

                $valid = false;
                $error_html = "<h2>{$lang['mustspecifyrssfeeduseraccount']}</h2>\n";
            }

            if (isset($_POST['t_fid_new']) && is_numeric($_POST['t_fid_new'])) {
                $t_fid_new = $_POST['t_fid_new'];
            }else {
                $valid = false;
                $error_html = "<h2>{$lang['mustspecifyrssfeedfolder']}</h2>\n";
            }

            if (isset($_POST['t_url_new']) && strlen(trim(_stripslashes($_POST['t_url_new']))) > 0) {

                $t_url_new = trim(_stripslashes($_POST['t_url_new']));

                $check_url = parse_url($t_url_new);

                if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {
                    $valid = false;
                    $error_html = "<h2>{$lang['rssfeedsupportshttpurlsonly']}</h2>\n";
                }

                if (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1) {
                    $valid = false;
                    $error_html = "<h2>{$lang['rssfeedurlformatinvalid']}</h2>\n";
                }

                if (isset($check_url['user']) || isset($check_url['pass'])) {
                    $valid = false;
                    $error_html = "<h2>{$lang['rssfeeduserauthentication']}</h2>\n";
                }

            }else {
                $valid = false;
                $error_html = "<h2>{$lang['mustspecifyrssfeedurl']}</h2>\n";
            }

            if (isset($_POST['t_prefix_new']) && strlen(trim(_stripslashes($_POST['t_prefix_new']))) > 0) {
                $t_prefix_new = trim(_stripslashes($_POST['t_prefix_new']));
            }else {
                $valid = false;
                $error_html = "<h2>{$lang['mustspecifyrssfeedprefix']}</h2>\n";
            }

            if (isset($_POST['t_frequency_new']) && is_numeric($_POST['t_frequency_new'])) {
                $t_frequency_new = $_POST['t_frequency_new'];
            }else {
                $valid = false;
                $error_html = "<h2>{$lang['mustspecifyrssfeedupdatefrequency']}</h2>\n";
            }

            if ($valid) {

                if (rss_add_feed($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new)) {

                    admin_add_log_entry(ADDED_RSS_FEED, array($t_name_new, $t_url_new));
                    unset($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new);
                }
            }
        }
    }
}

html_draw_top();

// Draw the form
echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['rssfeeds']}</h1>\n";

if (isset($error_html)) echo $error_html;

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_rss_feeds.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"95%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['name']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['user']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['folder']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['feedlocation']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['prefix']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['update']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['delete']}&nbsp;</td>\n";
echo "                </tr>\n";

if ($rss_feeds = rss_get_feeds()) {

    foreach ($rss_feeds as $rss_feed) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_input_hidden("t_rssid[{$rss_feed['RSSID']}]", $rss_feed['RSSID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$rss_feed['RSSID']}]", $rss_feed['NAME'], 20, 255), form_input_hidden("t_old_name[{$rss_feed['RSSID']}]", $rss_feed['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_user[{$rss_feed['RSSID']}]", $rss_feed['LOGON'], 12, 15), form_input_hidden("t_old_user[{$rss_feed['RSSID']}]", $rss_feed['LOGON']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", folder_draw_dropdown_all($rss_feed['FID'], "t_fid[{$rss_feed['RSSID']}]", "", "", "post_folder_dropdown"), form_input_hidden("t_old_fid[{$rss_feed['RSSID']}]", $rss_feed['FID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_url[{$rss_feed['RSSID']}]", $rss_feed['URL'], 45, 255), form_input_hidden("t_old_url[{$rss_feed['RSSID']}]", $rss_feed['URL']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_prefix[{$rss_feed['RSSID']}]", $rss_feed['PREFIX'], 5, 16), form_input_hidden("t_old_prefix[{$rss_feed['RSSID']}]", $rss_feed['PREFIX']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_frequency[{$rss_feed['RSSID']}]", array(0, 30, 60, 360, 720, 1440), array($lang['never'], $lang['every30mins'], $lang['onceanhour'], $lang['every6hours'], $lang['every12hours'], $lang['onceaday']), $rss_feed['FREQUENCY']), form_input_hidden("t_old_frequency[{$rss_feed['RSSID']}]", $rss_feed['FREQUENCY']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"center\">", form_checkbox("t_delete[{$rss_feed['RSSID']}]", "Y", false), "</td>\n";
        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created

echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['new_caps']}</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", (isset($t_name_new) ? $t_name_new : $lang['newitem']), 20, 64), "</td>";
echo "                  <td align=\"left\">", form_field("t_user_new", (isset($t_user_new) ? $t_user_new : bh_session_get_value('LOGON')), 12, 64), "</td>";
echo "                  <td align=\"left\">", folder_draw_dropdown_all((isset($t_fid_new) ? $t_fid_new : 0), "t_fid_new", "", "", "post_folder_dropdown"), "</td>\n";
echo "                  <td align=\"left\">", form_field("t_url_new", (isset($t_url_new) ? $t_url_new : ""), 45, 255), "</td>";
echo "                  <td align=\"left\">", form_field("t_prefix_new", (isset($t_prefix_new) ? $t_prefix_new : ""), 5, 16), "</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("t_frequency_new", array(0, 30, 60, 360, 720, 1440), array($lang['never'], $lang['every30mins'], $lang['onceanhour'], $lang['every6hours'], $lang['every12hours'], $lang['onceaday']), (isset($t_frequency_new) ? $t_frequency_new : 1440)), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>{$lang['rssfeedhelp_1']}</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>