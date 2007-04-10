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

/* $Id: admin_rss_feeds.php,v 1.39 2007-04-10 16:02:02 decoyduck Exp $ */

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

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
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

$update_frequencies_array = array(0 => $lang['never'], 30 => $lang['every30mins'], 
                                  60 => $lang['onceanhour'], 360 => $lang['every6hours'], 
                                  720 => $lang['every12hours'], 1440 => $lang['onceaday']);

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

$error_html = "";
$add_success = "";
$del_success = "";
$edit_success = "";

if (isset($_POST['cancel']) || isset($_POST['delete'])) {

    unset($_POST['addfeed'], $_POST['feed_id'], $_GET['feed_id']);
}

if (isset($_POST['delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach($_POST['t_delete'] as $feed_id => $delete_feed) {
    
            if (($delete_feed == "Y") && ($rss_feed = rss_get_feed($feed_id))) {

                if (rss_remove_feed($feed_id)) {

                    admin_add_log_entry(DELETED_RSS_FEED, $rss_feed['NAME']);
                    $del_success = "<h2>{$lang['successfullyremovedselectedfeeds']}</h2>\n";

                }else {
                    
                    $error_html.= "<h2>{$lang['failedtoremovefeeds']}</h2>\n";
                }               
            }
        }
    }

}elseif (isset($_POST['checkfeedsubmit'])) {

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

}elseif (isset($_POST['addfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
        $t_name_new = trim(_stripslashes($_POST['t_name_new']));
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
            $add_success = "<h2>{$lang['successfullyaddedfeed']}</h2>\n";
            unset($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new, $_POST['addfeed']);

        }else {

            $error_html.= "<h2>{$lang['failedtoaddnewrssfeed']}</h2>\n";
        }
    }

}elseif (isset($_POST['updatefeedsubmit'])) {

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

                }else {

                    $error_html.= "<h2>{$lang['failedtoupdaterssfeed']}</h2>\n";
                }

            }else {

                $error_html.= "<h2>{$lang['unknownrssuseraccount']}</h2>\n";
            }
        }
    }

}elseif (isset($_POST['addfeed'])) {

    $redirect = "./admin_rss_feeds.php?webtag=$webtag&page=$page&addfeed=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfeed']) || isset($_POST['addfeed'])) {

    html_draw_top('admin.js');
    
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['rssfeeds']} &raquo; {$lang['addnewfeed']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('addfeed', 'true'), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : ""), 40, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedlocation']}:</td>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_input_text("t_url_new", (isset($_POST['t_url_new']) ? _htmlentities(_stripslashes($_POST['t_url_new'])) : ""), 30, 255), "&nbsp;", form_submit("checkfeedsubmit", 'Test'), "</td>\n";
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
    echo "                        <td align=\"left\"><div class=\"bhinputsearch\">", form_input_text("t_user_new", (isset($_POST['t_user_new']) ? _htmlentities(_stripslashes($_POST['t_user_new'])) : ""), 30, 15, "", "search_logon"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;obj_name=t_user_new\" onclick=\"return openLogonSearch('$webtag', 't_user_new');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['threadtitleprefix']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix_new", (isset($_POST['t_prefix_new']) ? _htmlentities(_stripslashes($_POST['t_prefix_new'])) : ""), 20, 16), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedfoldername']}:</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid_new']) ? _htmlentities(_stripslashes($_POST['t_fid_new'])) : 0), "t_fid_new", "", "", "post_folder_dropdown"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['updatefrequency']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency_new", $update_frequencies_array, (isset($_POST['t_frequency_new']) ? _htmlentities(_stripslashes($_POST['t_frequency_new'])) : 1440)), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addfeedsubmit", $lang['add']), " &nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
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

        html_draw_top();
        html_error_msg($lang['invalidfeedidorfeednotfound'], 'admin_rss_feeds.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$rss_feed = rss_get_feed($feed_id)) {

        html_draw_top();
        html_error_msg($lang['invalidfeedidorfeednotfound'], 'admin_rss_feeds.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top('admin.js');
    
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['rssfeeds']} &raquo; {$lang['editfeed']} &raquo; {$rss_feed['NAME']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('feed_id', _htmlentities($feed_id)), "\n";
    echo "  ", form_input_hidden("t_delete[$feed_id]", "Y"), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? _htmlentities(_stripslashes($_POST['t_name'])) : (isset($rss_feed['NAME']) ? _htmlentities($rss_feed['NAME']) : "")), 40, 32), form_input_hidden("t_name_old", (isset($rss_feed['NAME']) ? _htmlentities($rss_feed['NAME']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedlocation']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_url", (isset($_POST['t_url']) ? _htmlentities(_stripslashes($_POST['t_url'])) : (isset($rss_feed['URL']) ? _htmlentities($rss_feed['URL']) : "")), 30, 255), form_input_hidden("t_url_old", (isset($rss_feed['URL']) ? _htmlentities($rss_feed['URL']) : "")), "&nbsp;", form_submit('checkfeedsubmit', "Test"), "</td>\n";
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
    echo "                        <td align=\"left\"><div class=\"bhinputsearch\">", form_input_text("t_user", (isset($_POST['t_user']) ? _htmlentities(_stripslashes($_POST['t_user'])) : (isset($rss_feed['LOGON']) ? _htmlentities($rss_feed['LOGON']) : "")), 26, 15, "", "search_logon"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;obj_name=t_user\" onclick=\"return openLogonSearch('$webtag', 't_user');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a>", form_input_hidden("t_user_old", (isset($rss_feed['LOGON']) ? _htmlentities($rss_feed['LOGON']) : "")), "</div></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['threadtitleprefix']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix", (isset($_POST['t_prefix']) ? _htmlentities(_stripslashes($_POST['t_prefix'])) : (isset($rss_feed['PREFIX']) ? _htmlentities($rss_feed['PREFIX']) : "")), 29, 16), form_input_hidden("t_prefix_old", (isset($rss_feed['PREFIX']) ? _htmlentities($rss_feed['PREFIX']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['feedfoldername']}:</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid']) ? _htmlentities(_stripslashes($_POST['t_fid'])) : (isset($rss_feed['FID']) ? $rss_feed['FID'] : 0)), "t_fid", "", "", "post_folder_dropdown"), form_input_hidden("t_fid_old", (isset($rss_feed['FID']) ? _htmlentities($rss_feed['FID']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['updatefrequency']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency", $update_frequencies_array, (isset($_POST['t_frequency']) ? _htmlentities(_stripslashes($_POST['t_frequency'])) : (isset($rss_feed['FREQUENCY']) ? $rss_feed['FREQUENCY'] : 1440)), "", "post_folder_dropdown"), form_input_hidden("t_frequency_old", (isset($rss_feed['FREQUENCY']) ? _htmlentities($rss_feed['FREQUENCY']) : "")), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatefeedsubmit", $lang['save']), " &nbsp;", form_submit("delete", $lang['delete']), " &nbsp;",form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top();
    
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
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['rssfeeds']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    $update_labels = array('0'   => $lang['never'],        '30'   => $lang['every30mins'],
                           '60'  => $lang['onceanhour'],   '360'  => $lang['every6hours'], 
                           '720' => $lang['every12hours'], '1440' => $lang['onceaday']);

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"rss\" action=\"admin_rss_feeds.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
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

    $rss_feeds = rss_get_feeds($start);

    if (sizeof($rss_feeds['rss_feed_array']) > 0) {

        foreach ($rss_feeds['rss_feed_array'] as $rss_feed) {
            
            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("t_delete[{$rss_feed['RSSID']}]", "Y", false), "</td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"300\"><a href=\"admin_rss_feeds.php?webtag=$webtag&amp;page=$page&amp;feed_id={$rss_feed['RSSID']}\">{$rss_feed['NAME']}</a></td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"225\">", (in_array($rss_feed['FREQUENCY'], array_keys($update_labels))) ? $update_labels[$rss_feed['FREQUENCY']] : $lang['unknown'], "</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"center\" width=\"25\">&nbsp;</td>\n";
        echo "                  <td valign=\"top\" align=\"left\" colspan=\"3\">{$lang['noexistingfeeds']}</td>\n";
        echo "                </tr>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $rss_feeds['rss_feed_count'], 10), "</td>\n";
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
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"left\">{$lang['rssfeedhelp']}</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>