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

/* $Id: admin_rss_feeds.php,v 1.15 2006-07-30 16:19:27 decoyduck Exp $ */

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

$error_html = "";

if (isset($_POST['addfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {

        if (trim(_stripslashes($_POST['t_name_new'])) != $lang['newitem']) {

            $t_name_new = trim(_stripslashes($_POST['t_name_new']));

        }else {

            $valid = false;
        }

    }else {

        $valid = false;
        $error_html.= "<h2>{$lang['mustspecifyrssfeedname']}</h2>\n";
    }

    if (isset($_POST['t_user_new']) && strlen(trim(_stripslashes($_POST['t_user_new']))) > 0) {

        $t_user_new = trim(_stripslashes($_POST['t_user_new']));

        if ($t_user_array = user_get_uid($t_user_new)) {

            $t_user_uid = $t_user_array['UID'];

        }else {

            $valid = false;
            $error_html.= "<h2>{$lang['unknownrssuseraccount']}</h2>\n";
        }

    }else {

        $valid = false;
        $error_html.= "<h2>{$lang['mustspecifyrssfeeduseraccount']}</h2>\n";
    }

    if (isset($_POST['t_fid_new']) && is_numeric($_POST['t_fid_new'])) {
        $t_fid_new = $_POST['t_fid_new'];
    }else {
        $valid = false;
        $error_html.= "<h2>{$lang['mustspecifyrssfeedfolder']}</h2>\n";
    }

    if (isset($_POST['t_url_new']) && strlen(trim(_stripslashes($_POST['t_url_new']))) > 0) {

        $t_url_new = trim(_stripslashes($_POST['t_url_new']));

        $check_url = parse_url($t_url_new);

        if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {

            $valid = false;
            $error_html.= "<h2>{$lang['rssfeedsupportshttpurlsonly']}</h2>\n";
        }

        if (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1) {

            $valid = false;
            $error_html.= "<h2>{$lang['rssfeedurlformatinvalid']}</h2>\n";
        }

        if (isset($check_url['user']) || isset($check_url['pass'])) {

            $valid = false;
            $error_html.= "<h2>{$lang['rssfeeduserauthentication']}</h2>\n";
        }

    }else {

        $valid = false;
        $error_html.= "<h2>{$lang['mustspecifyrssfeedurl']}</h2>\n";
    }

    if (isset($_POST['t_prefix_new']) && strlen(trim(_stripslashes($_POST['t_prefix_new']))) > 0) {
        $t_prefix_new = trim(_stripslashes($_POST['t_prefix_new']));
    }else {
        $t_prefix_new = "";
    }

    if (isset($_POST['t_frequency_new']) && is_numeric($_POST['t_frequency_new'])) {
        $t_frequency_new = $_POST['t_frequency_new'];
    }else {
        $valid = false;
        $error_html.= "<h2>{$lang['mustspecifyrssfeedupdatefrequency']}</h2>\n";
    }

    if ($valid) {

        if (rss_add_feed($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new)) {

            admin_add_log_entry(ADDED_RSS_FEED, array($t_name_new, $t_url_new));
            unset($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new, $_POST['addfeed']);
            $add_success = "<h2>{$lang['successfullyaddedfeed']}</h2>\n";
        }
    }
}

if (isset($_POST['updatefeedsubmit'])) {

    $valid = true;
    
    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];
        
        if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {
            $t_new_name = trim(_stripslashes($_POST['t_name']));
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['mustspecifyrssfeedname']}</h2>\n";
        }

        if (isset($_POST['t_old_name']) && strlen(trim(_stripslashes($_POST['t_old_name']))) > 0) {
            $t_old_name = trim(_stripslashes($_POST['t_old_name']));
        }else {
            $t_old_name = "";
        }

        if (isset($_POST['t_user']) && strlen(trim(_stripslashes($_POST['t_user']))) > 0) {
            $t_new_user = trim(_stripslashes($_POST['t_user']));
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['mustspecifyrssfeeduseraccount']}</h2>\n";
        }

        if (isset($_POST['t_old_user']) && strlen(trim(_stripslashes($_POST['t_old_user']))) > 0) {
            $t_old_user = trim(_stripslashes($_POST['t_old_user']));
        }else {
            $t_old_user = "";
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
            $t_new_fid = $_POST['t_fid'];
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['mustspecifyrssfeedfolder']}</h2>\n";
        }

        if (isset($_POST['t_old_fid']) && is_numeric($_POST['t_old_fid'])) {
            $t_old_fid = $_POST['t_old_fid'];
        }else {
            $t_old_fid = "";
        }

        if (isset($_POST['t_url']) && strlen(trim(_stripslashes($_POST['t_url']))) > 0) {
            $t_new_url = $_POST['t_url'];
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['mustspecifyrssfeedurl']}</h2>\n";
        }

        if (isset($_POST['t_old_url']) && strlen(trim(_stripslashes($_POST['t_old_url']))) > 0) {
            $t_old_url = $_POST['t_old_url'];
        }else {
            $t_old_url = "";
        }

        if (isset($_POST['t_prefix']) && strlen(trim(_stripslashes($_POST['t_prefix']))) > 0) {
            $t_new_prefix = $_POST['t_prefix'];
        }else {
            $t_new_prefix = "";
        }

        if (isset($_POST['t_old_prefix']) && strlen(trim(_stripslashes($_POST['t_old_prefix']))) > 0) {
            $t_old_prefix = $_POST['t_old_prefix'];
        }else {
            $t_old_prefix = "";
        }

        if (isset($_POST['t_frequency']) && is_numeric($_POST['t_frequency'])) {
            $t_new_frequency = $_POST['t_frequency'];
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['mustspecifyrssfeedupdatefrequency']}</h2>\n";
        }

        if (isset($_POST['t_old_frequency']) && is_numeric($_POST['t_old_frequency'])) {
            $t_old_frequency = $_POST['t_old_frequency'];
        }else {
            $t_old_frequency = "";
        }

        if ($valid && (($t_new_name != $t_old_name) || ($t_new_user != $t_old_user) || ($t_new_fid != $t_old_fid) || ($t_new_url != $t_old_url) || ($t_new_prefix != $t_old_prefix) || ($t_new_frequency != $t_old_frequency))) {

            if ($t_user_array = user_get_uid($t_new_user)) {

                $t_new_uid = $t_user_array['UID'];

                if (rss_feed_update($feed_id, $t_new_name, $t_new_uid, $t_new_fid, $t_new_url, $t_new_prefix, $t_new_frequency)) {

                    admin_add_log_entry(EDITED_RSS_FEED, array($t_new_name, $t_old_name, $t_new_user, $t_old_user, $t_new_fid, $t_old_fid, $t_new_url, $t_old_url, $t_new_prefix, $t_old_prefix, $t_new_frequency, $t_old_frequency));
                    $edit_success = "<h2>{$lang['successfullyeditedfeed']}: $t_new_name</h2>\n";
                    unset($feed_id, $t_new_name, $t_old_name, $t_new_user, $t_old_user, $t_new_fid, $t_old_fid, $t_new_url, $t_old_url, $t_new_prefix, $t_old_prefix, $t_new_frequency, $t_old_frequency, $_POST['feed_id'], $_GET['feed_id']);
                }

            }else {

                $valid = false;
                $error_html.= "<h2>{$lang['unknownrssuseraccount']}</h2>\n";
            }
        }
    }
}

if (isset($_POST['delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        $del_success = "<h2>{$lang['successfullyremovedselectedfeeds']}</h2>\n";

        foreach($_POST['t_delete'] as $feed_id => $delete_feed) {
    
            if ($delete_feed == "Y") {

                if (!rss_remove_feed($feed_id)) {

                    $del_success = "<h2>{$lang['couldnotremovefeedwithid']}: $feed_id</h2>\n";
                }               
            }
        }
    }
}

if (isset($_POST['cancel']) || isset($_POST['delete'])) {

    unset($_POST['addfeed'], $_POST['feed_id'], $_GET['feed_id']);
}

html_draw_top();

if (isset($_POST['testfeedurl'])) {

    $valid = true;
    
    if (isset($_POST['t_url']) && strlen(trim(_stripslashes($_POST['t_url']))) > 0) {
    
        $t_url = trim(_stripslashes($_POST['t_url']));

    }elseif (isset($_POST['t_url_new']) && strlen(trim(_stripslashes($_POST['t_url_new']))) > 0) {

        $t_url = trim(_stripslashes($_POST['t_url_new']));

    }else {

        $error_html.= "<h2>{$lang['mustspecifyrssfeedurl']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        if ($rss_items = rss_read_database($t_url)) {

            if (is_array($rss_items) && sizeof($rss_items) > 0) {

                $error_html.= "<h2>{$lang['rssstreamworkingcorrectly']}</h2>\n";

            }else {

                $error_html.= "<h2>{$lang['rssstreamnotworkingcorrectly']}</h2>\n";
            }

        }else {

            $error_html.= "<h2>{$lang['rssstreamnotworkingcorrectly']}</h2>\n";
        }
    }

    unset($t_url);
}

if (isset($_POST['addfeed'])) {

    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['rssfeeds']} : {$lang['addnewfeed']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('addfeed', ''), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['feednameandlocation']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedname']}:</td>\n";
    echo "                  <td>", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : ""), 40, 32), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedlocation']}:</td>\n";
    echo "                  <td>", form_input_text("t_url_new", (isset($_POST['t_url_new']) ? _htmlentities(_stripslashes($_POST['t_url_new'])) : ""), 32, 255), "&nbsp;", form_submit('testfeedurl', "Test"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['feedsettings']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feeduseraccount']}:</td>\n";
    echo "                  <td>", form_input_text("t_user_new", (isset($_POST['t_user_new']) ? _htmlentities(_stripslashes($_POST['t_user_new'])) : ""), 20, 64), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['threadtitleprefix']}:</td>\n";
    echo "                  <td>", form_input_text("t_prefix_new", (isset($_POST['t_prefix_new']) ? _htmlentities(_stripslashes($_POST['t_prefix_new'])) : ""), 20, 16), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedfoldername']}:</td>\n";
    echo "                  <td>", folder_draw_dropdown_all((isset($_POST['t_fid_new']) ? _htmlentities(_stripslashes($_POST['t_fid_new'])) : 0), "t_fid_new", "", "", "post_folder_dropdown"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['updatefrequency']}:</td>\n";
    echo "                  <td>", form_dropdown_array("t_frequency_new", array('', 0, 30, 60, 360, 720, 1440), array('', $lang['never'], $lang['every30mins'], $lang['onceanhour'], $lang['every6hours'], $lang['every12hours'], $lang['onceaday']), (isset($_POST['t_frequency_new']) ? _htmlentities(_stripslashes($_POST['t_frequency_new'])) : 1440)), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addfeedsubmit", $lang['add']), " &nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}elseif (isset($_POST['feed_id']) || isset($_GET['feed_id'])) {

    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];

    }elseif (isset($_GET['feed_id']) && is_numeric($_GET['feed_id'])) {

        $feed_id = $_GET['feed_id'];

    }else {

        echo "<h2>{$lang['invalidfeedidorfeednotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (!$rss_feed = rss_get_feed($feed_id)) {

        echo "<h2>{$lang['invalidfeedidorfeednotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }
    
    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['rssfeeds']} : {$lang['editfeed']} : {$rss_feed['NAME']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('feed_id', $feed_id), "\n";
    echo "  ", form_input_hidden("t_delete[$feed_id]", "Y"), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['feednameandlocation']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedname']}:</td>\n";
    echo "                  <td>", form_input_text("t_name", (isset($_POST['t_name']) ? _htmlentities(_stripslashes($_POST['t_name'])) : (isset($rss_feed['NAME']) ? _htmlentities($rss_feed['NAME']) : "")), 40, 32), form_input_hidden("t_name_old", (isset($rss_feed['NAME']) ? $rss_feed['NAME'] : "")), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedlocation']}:</td>\n";
    echo "                  <td>", form_input_text("t_url", (isset($_POST['t_url']) ? _htmlentities(_stripslashes($_POST['t_url'])) : (isset($rss_feed['URL']) ? _htmlentities($rss_feed['URL']) : "")), 32, 255), form_input_hidden("t_url_old", (isset($rss_feed['URL']) ? $rss_feed['URL'] : "")), "&nbsp;", form_submit('testfeedurl', "Test"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['feedsettings']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feeduseraccount']}:</td>\n";
    echo "                  <td>", form_input_text("t_user", (isset($_POST['t_user']) ? _htmlentities(_stripslashes($_POST['t_user'])) : (isset($rss_feed['LOGON']) ? _htmlentities($rss_feed['LOGON']) : "")), 20, 64), form_input_hidden("t_user_old", (isset($rss_feed['LOGON']) ? $rss_feed['LOGON'] : "")), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['threadtitleprefix']}:</td>\n";
    echo "                  <td>", form_input_text("t_prefix", (isset($_POST['t_prefix']) ? _htmlentities(_stripslashes($_POST['t_prefix'])) : (isset($rss_feed['PREFIX']) ? _htmlentities($rss_feed['PREFIX']) : "")), 20, 16), form_input_hidden("t_prefix_old", (isset($rss_feed['PREFIX']) ? $rss_feed['PREFIX'] : "")), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['feedfoldername']}:</td>\n";
    echo "                  <td>", folder_draw_dropdown_all((isset($_POST['t_fid']) ? _htmlentities(_stripslashes($_POST['t_fid'])) : (isset($rss_feed['FID']) ? $rss_feed['FID'] : 0)), "t_fid", "", "", "post_folder_dropdown"), form_input_hidden("t_fid_old", (isset($rss_feed['FID']) ? $rss_feed['FID'] : "")), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">&nbsp;{$lang['updatefrequency']}:</td>\n";
    echo "                  <td>", form_dropdown_array("t_frequency", array(0, 30, 60, 360, 720, 1440), array($lang['never'], $lang['every30mins'], $lang['onceanhour'], $lang['every6hours'], $lang['every12hours'], $lang['onceaday']), (isset($_POST['t_frequency']) ? _htmlentities(_stripslashes($_POST['t_frequency'])) : (isset($rss_feed['FREQUENCY']) ? $rss_feed['FREQUENCY'] : 1440))), form_input_hidden("t_frequency_old", (isset($rss_feed['FREQUENCY']) ? $rss_feed['FREQUENCY'] : "")), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatefeedsubmit", $lang['save']), " &nbsp;", form_submit("delete", $lang['delete']), " &nbsp;",form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}else {

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function rss_toggle_all() {\n";
    echo "    for (var i = 0; i < document.rss.elements.length; i++) {\n";
    echo "        if (document.rss.elements[i].type == 'checkbox') {\n";
    echo "            if (document.rss.toggle_all.checked == true) {\n";
    echo "                document.rss.elements[i].checked = true;\n";
    echo "            }else {\n";
    echo "                document.rss.elements[i].checked = false;\n";
    echo "            }\n";
    echo "        }\n";
    echo "    }\n";
    echo "}\n";
    echo "//-->\n";
    echo "</script>\n";

    // Draw the form
    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['rssfeeds']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success)) echo $add_success;
    if (isset($del_success)) echo $del_success;
    if (isset($edit_success)) echo $edit_success;

    $update_labels = array('0'   => $lang['never'],        '30'   => $lang['every30mins'],
                           '60'  => $lang['onceanhour'],   '360'  => $lang['every6hours'], 
                           '720' => $lang['every12hours'], '1440' => $lang['onceaday']);

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"rss\" action=\"admin_rss_feeds.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"300\">&nbsp;{$lang['name']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"225\">&nbsp;{$lang['updatefrequency']}&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"25\">&nbsp;</td>\n";
    echo "                </tr>\n";

    if ($rss_feeds = rss_get_feeds()) {

        foreach ($rss_feeds as $rss_feed) {
            
            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"300\">&nbsp;<a href=\"admin_rss_feeds.php?feed_id={$rss_feed['RSSID']}\">{$rss_feed['NAME']}</a></td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"225\">", (in_array($rss_feed['FREQUENCY'], array_keys($update_labels))) ? $update_labels[$rss_feed['FREQUENCY']] : $lang['unknown'], "</td>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("t_delete[{$rss_feed['RSSID']}]", "Y", false), "</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\" colspan=\"4\">&nbsp;{$lang['noexistingfeeds']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addfeed", $lang['addnewfeed']), "&nbsp;", form_submit("delete", $lang['deleteselectedfeeds']), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>{$lang['rssfeedhelp']}</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>