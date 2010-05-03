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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "rss_feed.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
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

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$update_frequencies_array = array(RSS_FEED_UPDATE_NEVER        => $lang['never'],
                                  RSS_FEED_UPDATE_THIRTY_MINS  => $lang['every30mins'],
                                  RSS_FEED_UPDATE_ONE_HOUR     => $lang['onceanhour'],
                                  RSS_FEED_UPDATE_SIX_HOURS    => $lang['every6hours'],
                                  RSS_FEED_UPDATE_TWELVE_HOURS => $lang['every12hours'],
                                  RSS_FEED_UPDATE_ONCE_A_DAY   => $lang['onceaday'],
                                  RSS_FEED_UPDATE_ONCE_A_WEEK  => $lang['onceaweek']);

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Array to hold error messages

$error_msg_array = array();

// Cancel clicked.

if (isset($_POST['cancel'])) {

    header_redirect("admin_rss_feeds.php?webtag=$webtag");
    exit;
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $feed_id => $delete_feed) {

            if ($valid && $delete_feed == "Y" && $rss_feed = rss_get_feed($feed_id)) {

                if (rss_remove_feed($feed_id)) {

                    admin_add_log_entry(DELETED_RSS_FEED, $rss_feed['NAME']);

                }else {

                    $error_msg_array[] = $lang['failedtoremovefeeds'];
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_rss_feeds.php?webtag=$webtag&deleted=true");
            exit;
        }
    }

}elseif (isset($_POST['checkfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_url']) && strlen(trim(stripslashes_array($_POST['t_url']))) > 0) {

        $t_url = trim(stripslashes_array($_POST['t_url']));

    }elseif (isset($_POST['t_url_new']) && strlen(trim(stripslashes_array($_POST['t_url_new']))) > 0) {

        $t_url = trim(stripslashes_array($_POST['t_url_new']));

    }else {

        $error_msg_array[] = $lang['mustspecifyrssfeedurl'];
        $valid = false;
    }

    if ($valid) {

        if (($rss_items = rss_read_database($t_url))) {

            if (is_array($rss_items) && sizeof($rss_items) > 0) {

                $rss_stream_success = $lang['rssstreamworkingcorrectly'];

            }else {

                $error_msg_array[] = $lang['rssstreamnotworkingcorrectly'];
            }

        }else {

            $error_msg_array[] = $lang['rssstreamnotworkingcorrectly'];
        }
    }

    unset($t_url);

}elseif (isset($_POST['addfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim(stripslashes_array($_POST['t_name_new']))) > 0) {
        $t_name_new = trim(stripslashes_array($_POST['t_name_new']));
    }else {
        $valid = false;
        $error_msg_array[] = $lang['mustspecifyrssfeedname'];
    }

    if (isset($_POST['t_user_new']) && strlen(trim(stripslashes_array($_POST['t_user_new']))) > 0) {

        $t_user_new = trim(stripslashes_array($_POST['t_user_new']));

        if (($t_user_array = user_get_by_logon($t_user_new))) {

            $t_user_uid = $t_user_array['UID'];

        }else {

            $valid = false;
            $error_msg_array[] = $lang['unknownrssuseraccount'];
        }

    }else {

        $valid = false;
        $error_msg_array[] = $lang['mustspecifyrssfeeduseraccount'];
    }

    if (isset($_POST['t_fid_new']) && is_numeric($_POST['t_fid_new'])) {

        $t_fid_new = $_POST['t_fid_new'];

    }else {

        $valid = false;
        $error_msg_array[] = $lang['mustspecifyrssfeedfolder'];
    }

    if (isset($_POST['t_url_new']) && strlen(trim(stripslashes_array($_POST['t_url_new']))) > 0) {

        $t_url_new = trim(stripslashes_array($_POST['t_url_new']));

        $check_url = parse_url($t_url_new);

        if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {

            $valid = false;
            $error_msg_array[] = $lang['rssfeedsupportshttpurlsonly'];
        }

        if (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1) {

            $valid = false;
            $error_msg_array[] = $lang['rssfeedurlformatinvalid'];
        }

        if (isset($check_url['user']) || isset($check_url['pass'])) {

            $valid = false;
            $error_msg_array[] = $lang['rssfeeduserauthentication'];
        }

    }else {

        $valid = false;
        $error_msg_array[] = $lang['mustspecifyrssfeedurl'];
    }

    if (isset($_POST['t_prefix_new']) && strlen(trim(stripslashes_array($_POST['t_prefix_new']))) > 0) {
        $t_prefix_new = trim(stripslashes_array($_POST['t_prefix_new']));
    }else {
        $t_prefix_new = "";
    }

    if (isset($_POST['t_frequency_new']) && is_numeric($_POST['t_frequency_new'])) {

        $t_frequency_new = $_POST['t_frequency_new'];

    }else {

        $valid = false;
        $error_msg_array[] = $lang['mustspecifyrssfeedupdatefrequency'];
    }
    
    if (isset($_POST['t_max_item_count_new']) && in_array($_POST['t_max_item_count_new'], range(1, 10))) {
        
        $t_max_item_count_new = $_POST['t_max_item_count_new'];
        
    } else {

        $valid = false;
        $error_msg_array[] = $lang['maxitemcountmustbebetween1and10'];
    }

    if ($valid) {

        if (rss_add_feed($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new, $t_max_item_count_new)) {

            admin_add_log_entry(ADDED_RSS_FEED, array($t_name_new, $t_url_new));
            header_redirect("admin_rss_feeds.php?webtag=$webtag&added=true");
            exit;

        }else {

            $error_msg_array[] = $lang['failedtoaddnewrssfeed'];
        }
    }

}elseif (isset($_POST['updatefeedsubmit'])) {

    $valid = true;

    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];

        if (isset($_POST['t_name']) && strlen(trim(stripslashes_array($_POST['t_name']))) > 0) {

            $t_new_name = trim(stripslashes_array($_POST['t_name']));

        }else {

            $valid = false;
            $error_msg_array[] = $lang['mustspecifyrssfeedname'];
        }

        if (isset($_POST['t_old_name']) && strlen(trim(stripslashes_array($_POST['t_old_name']))) > 0) {
            $t_old_name = trim(stripslashes_array($_POST['t_old_name']));
        }else {
            $t_old_name = "";
        }

        if (isset($_POST['t_user']) && strlen(trim(stripslashes_array($_POST['t_user']))) > 0) {

            $t_new_user = trim(stripslashes_array($_POST['t_user']));

        }else {

            $valid = false;
            $error_msg_array[] = $lang['mustspecifyrssfeeduseraccount'];
        }

        if (isset($_POST['t_old_user']) && strlen(trim(stripslashes_array($_POST['t_old_user']))) > 0) {
            $t_old_user = trim(stripslashes_array($_POST['t_old_user']));
        }else {
            $t_old_user = "";
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            $t_new_fid = $_POST['t_fid'];

        }else {

            $valid = false;
            $error_msg_array[] = $lang['mustspecifyrssfeedfolder'];
        }

        if (isset($_POST['t_old_fid']) && is_numeric($_POST['t_old_fid'])) {
            $t_old_fid = $_POST['t_old_fid'];
        }else {
            $t_old_fid = "";
        }

        if (isset($_POST['t_url']) && strlen(trim(stripslashes_array($_POST['t_url']))) > 0) {
            $t_new_url = $_POST['t_url'];
        }else {
            $valid = false;
            $error_msg_array[] = $lang['mustspecifyrssfeedurl'];
        }

        if (isset($_POST['t_old_url']) && strlen(trim(stripslashes_array($_POST['t_old_url']))) > 0) {
            $t_old_url = $_POST['t_old_url'];
        }else {
            $t_old_url = "";
        }

        if (isset($_POST['t_prefix']) && strlen(trim(stripslashes_array($_POST['t_prefix']))) > 0) {
            $t_new_prefix = $_POST['t_prefix'];
        }else {
            $t_new_prefix = "";
        }

        if (isset($_POST['t_old_prefix']) && strlen(trim(stripslashes_array($_POST['t_old_prefix']))) > 0) {
            $t_old_prefix = $_POST['t_old_prefix'];
        }else {
            $t_old_prefix = "";
        }

        if (isset($_POST['t_frequency']) && is_numeric($_POST['t_frequency'])) {

            $t_new_frequency = $_POST['t_frequency'];

        }else {

            $valid = false;
            $error_msg_array[] = $lang['mustspecifyrssfeedupdatefrequency'];
        }

        if (isset($_POST['t_old_frequency']) && is_numeric($_POST['t_old_frequency'])) {
            $t_old_frequency = $_POST['t_old_frequency'];
        }else {
            $t_old_frequency = "";
        }
        
        if (isset($_POST['t_max_item_count']) && in_array($_POST['t_max_item_count'], range(1, 10))) {
            
            $t_max_item_count = $_POST['t_max_item_count'];
            
        } else {

            $valid = false;
            $error_msg_array[] = $lang['maxitemcountmustbebetween1and10'];
        }

        if (isset($_POST['t_old_max_item_count']) && is_numeric($_POST['t_old_max_item_count'])) {
            $t_old_max_item_count = $_POST['t_old_max_item_count'];
        } else {
            $t_old_max_item_count = 0;
        }        

        if ($valid && (($t_new_name != $t_old_name) || ($t_new_user != $t_old_user) || ($t_new_fid != $t_old_fid) || ($t_new_url != $t_old_url) || ($t_new_prefix != $t_old_prefix) || ($t_new_frequency != $t_old_frequency) || ($t_max_item_count != $t_old_max_item_count))) {

            if (($t_user_array = user_get_by_logon($t_new_user))) {

                $t_new_uid = $t_user_array['UID'];
                
                if (rss_feed_update($feed_id, $t_new_name, $t_new_uid, $t_new_fid, $t_new_url, $t_new_prefix, $t_new_frequency, $t_max_item_count)) {

                    $log_data = array($t_new_name, $t_old_name, $t_new_user, $t_old_user, $t_new_fid, $t_old_fid, $t_new_url, $t_old_url, $t_new_prefix, $t_old_prefix, $t_new_frequency, $t_old_frequency);

                    admin_add_log_entry(EDITED_RSS_FEED, $log_data);
                    header_redirect("admin_rss_feeds.php?webtag=$webtag&edited=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtoupdaterssfeed'];
                }

            }else {

                $error_msg_array[] = $lang['unknownrssuseraccount'];
            }
        }
    }

}elseif (isset($_POST['addfeed'])) {

    $redirect = "admin_rss_feeds.php?webtag=$webtag&page=$page&addfeed=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfeed']) || isset($_POST['addfeed'])) {

    html_draw_top("title={$lang['admin']} » {$lang['rssfeeds']} » {$lang['addnewfeed']}", 'class=window_title');

    echo "<h1>{$lang['admin']} &raquo; {$lang['rssfeeds']} &raquo; {$lang['addnewfeed']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');

    }else if (isset($rss_stream_success)) {

        html_display_success_msg($rss_stream_success, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addfeed', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['feednameandlocation']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array(stripslashes_array($_POST['t_name_new'])) : ""), 40, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedlocation']}:</td>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_input_text("t_url_new", (isset($_POST['t_url_new']) ? htmlentities_array(stripslashes_array($_POST['t_url_new'])) : ""), 30, 255), "&nbsp;", form_submit("checkfeedsubmit", 'Test'), "</td>\n";
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
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['feedsettings']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feeduseraccount']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_user_new", (isset($_POST['t_user_new']) ? htmlentities_array(stripslashes_array($_POST['t_user_new'])) : ""), 30, 15, SEARCH_LOGON, false), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['threadtitleprefix']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix_new", (isset($_POST['t_prefix_new']) ? htmlentities_array(stripslashes_array($_POST['t_prefix_new'])) : ""), 20, 16), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedfoldername']}:</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid_new']) ? htmlentities_array(stripslashes_array($_POST['t_fid_new'])) : 0), "t_fid_new", "", "", "post_folder_dropdown"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['updatefrequency']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency_new", $update_frequencies_array, (isset($_POST['t_frequency_new']) ? htmlentities_array(stripslashes_array($_POST['t_frequency_new'])) : 1440)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['maxitemcount']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_max_item_count_new", (isset($_POST['t_max_item_count_new']) ? htmlentities_array(stripslashes_array($_POST['t_max_item_count_new'])) : 10), 6, 4), "&nbsp;<span class=\"smalltext\">{$lang['maxitemcounthint']}</span></td>\n";
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
    echo "      <td align=\"center\">", form_submit("addfeedsubmit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['feed_id']) || isset($_GET['feed_id'])) {

    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];

    }elseif (isset($_GET['feed_id']) && is_numeric($_GET['feed_id'])) {

        $feed_id = $_GET['feed_id'];

    }else {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidfeedidorfeednotfound'], 'admin_rss_feeds.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$rss_feed = rss_get_feed($feed_id)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidfeedidorfeednotfound'], 'admin_rss_feeds.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title={$lang['admin']} » {$lang['rssfeeds']} » {$lang['editfeed']} » {$rss_feed['NAME']}", 'search_popup.js', 'class=window_title');

    echo "<h1>{$lang['admin']} &raquo; {$lang['rssfeeds']} &raquo; {$lang['editfeed']} &raquo; ", word_filter_add_ob_tags(htmlentities_array($rss_feed['NAME'])), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');

    }else if (isset($rss_stream_success)) {

        html_display_success_msg($rss_stream_success, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('feed_id', htmlentities_array($feed_id)), "\n";
    echo "  ", form_input_hidden("t_delete[$feed_id]", "Y"), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['feednameandlocation']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? htmlentities_array(stripslashes_array($_POST['t_name'])) : (isset($rss_feed['NAME']) ? htmlentities_array($rss_feed['NAME']) : "")), 40, 32), form_input_hidden("t_name_old", (isset($rss_feed['NAME']) ? htmlentities_array($rss_feed['NAME']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedlocation']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_url", (isset($_POST['t_url']) ? htmlentities_array(stripslashes_array($_POST['t_url'])) : (isset($rss_feed['URL']) ? htmlentities_array($rss_feed['URL']) : "")), 30, 255), form_input_hidden("t_url_old", (isset($rss_feed['URL']) ? htmlentities_array($rss_feed['URL']) : "")), "&nbsp;", form_submit('checkfeedsubmit', "Test"), "</td>\n";
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
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['feedsettings']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feeduseraccount']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_user", (isset($_POST['t_user']) ? htmlentities_array(stripslashes_array($_POST['t_user'])) : (isset($rss_feed['LOGON']) ? htmlentities_array($rss_feed['LOGON']) : "")), 26, 15, SEARCH_LOGON, false), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['threadtitleprefix']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix", (isset($_POST['t_prefix']) ? htmlentities_array(stripslashes_array($_POST['t_prefix'])) : (isset($rss_feed['PREFIX']) ? htmlentities_array($rss_feed['PREFIX']) : "")), 29, 16), form_input_hidden("t_prefix_old", (isset($rss_feed['PREFIX']) ? htmlentities_array($rss_feed['PREFIX']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedfoldername']}:</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid']) ? htmlentities_array(stripslashes_array($_POST['t_fid'])) : (isset($rss_feed['FID']) ? $rss_feed['FID'] : 0)), "t_fid", "", "", "post_folder_dropdown"), form_input_hidden("t_fid_old", (isset($rss_feed['FID']) ? htmlentities_array($rss_feed['FID']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['updatefrequency']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency", $update_frequencies_array, (isset($_POST['t_frequency']) ? htmlentities_array(stripslashes_array($_POST['t_frequency'])) : (isset($rss_feed['FREQUENCY']) ? $rss_feed['FREQUENCY'] : 1440)), "", "post_folder_dropdown"), form_input_hidden("t_frequency_old", (isset($rss_feed['FREQUENCY']) ? htmlentities_array($rss_feed['FREQUENCY']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['maxitemcount']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_max_item_count", (isset($_POST['t_max_item_count']) ? htmlentities_array(stripslashes_array($_POST['t_max_item_count'])) : (isset($rss_feed['MAX_ITEM_COUNT']) ? $rss_feed['MAX_ITEM_COUNT'] : 10)), 6, 4), form_input_hidden("t_max_item_count_old", (isset($rss_feed['MAX_ITEM_COUNT']) ? htmlentities_array($rss_feed['MAX_ITEM_COUNT']) : 10)), "&nbsp;<span class=\"smalltext\">{$lang['maxitemcounthint']}</span></td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatefeedsubmit", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;",form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['admin']} » {$lang['rssfeeds']}", 'search.js', 'class=window_title');

    $rss_feeds = rss_get_feeds($start);

    echo "<h1>{$lang['admin']} &raquo; {$lang['rssfeeds']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '550', 'center');

    }else if (isset($_GET['added'])) {

        html_display_success_msg($lang['successfullyaddedfeed'], '550', 'center');

    }else if (isset($_GET['edited'])) {

        html_display_success_msg($lang['successfullyeditedfeed'], '550', 'center');

    }else if (isset($_GET['deleted'])) {

        html_display_success_msg($lang['successfullyremovedselectedfeeds'], '550', 'center');

    }else if (sizeof($rss_feeds['rss_feed_array']) < 1) {

        html_display_warning_msg($lang['noexistingfeeds'], '550', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"rss\" action=\"admin_rss_feeds.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"300\">{$lang['name']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"225\">{$lang['updatefrequency']}&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($rss_feeds['rss_feed_array']) > 0) {

        foreach ($rss_feeds['rss_feed_array'] as $rss_feed) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$rss_feed['RSSID']}]", "Y", false), "</td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"300\"><a href=\"admin_rss_feeds.php?webtag=$webtag&amp;page=$page&amp;feed_id={$rss_feed['RSSID']}\">", word_filter_add_ob_tags(htmlentities_array($rss_feed['NAME'])), "</a></td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"225\">", (in_array($rss_feed['FREQUENCY'], array_keys($update_frequencies_array))) ? $update_frequencies_array[$rss_feed['FREQUENCY']] : $lang['unknown'], "</td>\n";
            echo "                </tr>\n";
        }
    }

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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_rss_feeds.php?webtag=$webtag", $start, $rss_feeds['rss_feed_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addfeed", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_display_warning_msg($lang['rssfeedhelp'], '550', 'center');

    html_draw_bottom();
}

?>
