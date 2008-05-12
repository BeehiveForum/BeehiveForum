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

/* $Id: forums.php,v 1.91 2008-05-12 19:41:00 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "myforums.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Load the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load Language File

$lang = load_language_file();

// Array to hold error messages

$error_msg_array = array();

// Top of the page.

html_draw_top("basetarget=_top");

// Types of available forums.

$available_forum_views = array(FORUMS_SHOW_ALL, FORUMS_SHOW_FAVS, FORUMS_SHOW_IGNORED);

// Header and dropdown options for the view type

$forum_header_array = array(FORUMS_SHOW_ALL => $lang['allavailableforums'],
                            FORUMS_SHOW_FAVS => $lang['favouriteforums'],
                            FORUMS_SHOW_IGNORED => $lang['ignoredforums']);

$forum_search_header_array = array(FORUMS_SHOW_SEARCH => $lang['searchresults'],
                                   FORUMS_SHOW_ALL => $lang['allavailableforums'],
                                   FORUMS_SHOW_FAVS => $lang['favouriteforums'],
                                   FORUMS_SHOW_IGNORED => $lang['ignoredforums']);


// Set the default view type.

if (!forums_any_favourites() || user_is_guest()) {
    $view_type = FORUMS_SHOW_ALL;
}else {
    $view_type = FORUMS_SHOW_FAVS;
}

// Webtag search

if (isset($_POST['webtag_search']) && strlen(trim(_stripslashes($_POST['webtag_search']))) > 0) {

    $webtag_search = trim(_stripslashes($_POST['webtag_search']));
    $search_page = 1; $start_search = 0;

}elseif (isset($_GET['webtag_search']) && strlen(trim(_stripslashes($_GET['webtag_search']))) > 0) {

    $webtag_search = trim(_stripslashes($_GET['webtag_search']));
}

if (isset($_POST['clear_search'])) {
    $webtag_search = "";
}

// Handle changing the view type. If a Guest tries to change
// the view type we show them the Guest Error messages.

if (isset($_POST['change_view'])) {

    if (isset($_POST['view_type']) && is_numeric($_POST['view_type'])) {

        $webtag_search = "";

        $view_type = $_POST['view_type'];

        if (user_is_guest() && $view_type != FORUMS_SHOW_ALL) {

            html_guest_error();
            exit;
        }

        if (!in_array($view_type, $available_forum_views)) {

            $view_type = FORUMS_SHOW_FAVS;
        }
    }

}elseif (!isset($_POST['search'])) {

    if (isset($_POST['view_type']) && is_numeric($_POST['view_type'])) {

        if (!user_is_guest()) {

            $webtag_search = "";

            $view_type = $_POST['view_type'];

            if (!in_array($view_type, $available_forum_views)) {

                $view_type = FORUMS_SHOW_FAVS;
            }
        }

    }elseif (isset($_GET['view_type']) && is_numeric($_GET['view_type'])) {

        if (!user_is_guest()) {

            $webtag_search = "";

            $view_type = $_GET['view_type'];

            if (!in_array($view_type, $available_forum_views)) {

                $view_type = FORUMS_SHOW_FAVS;
            }
        }
    }
}

// Page numbers

if (isset($_GET['main_page']) && is_numeric($_GET['main_page'])) {
    $main_page = $_GET['main_page'];
    $start_main = floor($main_page - 1) * 10;
}else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = $_POST['main_page'];
    $start_main = floor($main_page - 1) * 10;
}else {
    $main_page = 1;
    $start_main = 0;
}

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
    $start_search = floor($search_page - 1) * 10;
}else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = $_POST['search_page'];
    $start_search = floor($search_page - 1) * 10;
}else {
    $search_page = 1;
    $start_search = 0;
}

// Are we being redirected somewhere?

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/", basename(trim(_stripslashes($_GET['final_uri'])))) > 0) {

        $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));
        $final_uri = href_cleanup_query_keys($final_uri, 'webtag');
    }
}

// Handle adding and removing of favourites

if (isset($_POST['add_fav']) && is_array($_POST['add_fav'])) {

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    list($forum_fid_add_fav) = array_keys($_POST['add_fav']);

    if (user_set_forum_interest($forum_fid_add_fav, FORUM_FAVOURITE)) {

        $webtag_search = rawurlencode($webtag_search);
        header_redirect("forums.php?view_type=$view_type&main_page=$main_page&search_page=$search_page&webtag_search=$webtag_search&added=true");
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateforuminterestlevel'];
        $valid = false;
    }

}elseif (isset($_POST['rem_fav']) && is_array($_POST['rem_fav'])) {

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    list($forum_fid_rev_fav) = array_keys($_POST['rem_fav']);

    if (user_set_forum_interest($forum_fid_rev_fav, FORUM_NOINTEREST)) {

        $webtag_search = rawurlencode($webtag_search);
        header_redirect("forums.php?view_type=$view_type&main_page=$main_page&search_page=$search_page&webtag_search=$webtag_search&removed=true");
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateforuminterestlevel'];
        $valid = false;
    }

}elseif (isset($_POST['ignore_forum']) && is_array($_POST['ignore_forum'])) {

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    list($forum_fid_ignore) = array_keys($_POST['ignore_forum']);

    if (user_set_forum_interest($forum_fid_ignore, FORUM_IGNORED)) {

        $webtag_search = rawurlencode($webtag_search);
        header_redirect("forums.php?view_type=$view_type&main_page=$main_page&search_page=$search_page&webtag_search=$webtag_search&ignored=true");
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateforuminterestlevel'];
        $valid = false;
    }

}elseif (isset($_POST['unignore_forum']) && is_array($_POST['unignore_forum'])) {

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    list($forum_fid_unignore) = array_keys($_POST['unignore_forum']);

    if (user_set_forum_interest($forum_fid_unignore, FORUM_NOINTEREST)) {

        $webtag_search = rawurlencode($webtag_search);
        header_redirect("forums.php?view_type=$view_type&main_page=$main_page&search_page=$search_page&webtag_search=$webtag_search&unignored=true");
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateforuminterestlevel'];
        $valid = false;
    }
}

if (!user_is_guest()) {

    if (isset($webtag_search) && strlen($webtag_search) > 0) {

        echo "<h1>{$lang['myforums']} &raquo; {$lang['searchresults']}</h1>\n";

        $forums_array = forum_search($webtag_search, $start_search);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) < 1) {
            html_display_error_msg($lang['foundzeromatches'], '70%', 'center');
        }else {
            echo "<br />\n";
        }

        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
        echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
        echo "  ", form_input_hidden("webtag_search", _htmlentities($webtag_search)), "\n";
        echo "  ", form_input_hidden("view_type", _htmlentities($view_type)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumname']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumdesc']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['unreadmessages']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

            foreach ($forums_array['forums_array'] as $forum) {

                echo "                <tr>\n";

                if ((isset($forum['INTEREST']) && $forum['INTEREST'] == FORUM_FAVOURITE) || user_is_guest()) {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_rem_fav.png', "rem_fav[{$forum['FID']}]", "{$lang['removefromfavourites']}", "title=\"{$lang['removefromfavourites']}\""), "</td>\n";

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_add_fav.png', "add_fav[{$forum['FID']}]", "{$lang['addtofavourites']}", "title=\"{$lang['addtofavourites']}\""), "</td>\n";
                }

                if (isset($final_uri) && strlen($final_uri) > 0) {

                    if (strstr($final_uri, '?')) {

                        echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%26webtag%3D{$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%3Fwebtag%3D{$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                    }

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                }

                if (isset($forum['FORUM_DESC']) && strlen(trim($forum['FORUM_DESC'])) > 0) {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"30%\">{$forum['FORUM_DESC']}</td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"30%\">&nbsp;</td>\n";
                }

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                        echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), " (", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ",", ",")), ")</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ".", ",")), "</a></td>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), "</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">{$lang['forumnounreadmessages']}</a></td>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {
                    echo "                  <td align=\"left\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";
                }else {
                    echo "                  <td align=\"left\" valign=\"top\">{$lang['never']}</td>\n";
                }

                if (isset($forum['INTEREST']) && $forum['INTEREST'] > -1) {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_show.png', "unignore_forum[{$forum['FID']}]", "{$lang['unignoreforum']}", "title=\"{$lang['unignoreforum']}\""), "</td>\n";
                }

                echo "                </tr>\n";
            }
        }

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
        echo "      <td align=\"left\">\n";
        echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" width=\"33%\">&nbsp;</td>\n";
        echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&webtag_search=$webtag_search&main_page=$main_page&search_page=$search_page", $start_search, $forums_array['forums_count'], 10, 'search_page'), "</td>\n";
        echo "            <td align=\"right\" width=\"33%\" nowrap=\"nowrap\">{$lang['view']}:&nbsp;", form_dropdown_array('view_type', $forum_search_header_array, FORUMS_SHOW_SEARCH, "onchange=\"submit()\""), "&nbsp;", form_submit('change_view', $lang['go']), "</td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";
        echo "<br />\n";

    }else {

        $forums_array = get_my_forums($view_type, $start_main);

        echo "<h1>{$lang['myforums']} &raquo; {$forum_header_array[$view_type]}</h1>\n";

        if (isset($_GET['added'])) {

            html_display_success_msg($lang['successfullyaddedforumtofavourites'], '70%', 'center');

        }else if (isset($_GET['removed'])) {

            html_display_success_msg($lang['successfullyremovedforumfromfavourites'], '70%', 'center');

        }else if (isset($_GET['ignored'])) {

            html_display_success_msg($lang['successfullyignoredforum'], '70%', 'center');

        }else if (isset($_GET['unignored'])) {

            html_display_success_msg($lang['successfullyunignoredforum'], '70%', 'center');

        }else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

            html_display_error_array($error_msg_array, '70%', 'center');

        }else if (sizeof($forums_array['forums_array']) < 1) {

            html_display_warning_msg($lang['noforumsofselectedtype'], '70%', 'center');

        }else {

            echo "<br />\n";
        }

        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
        echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
        echo "  ", form_input_hidden("webtag_search", _htmlentities($webtag_search)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumname']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumdesc']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['unreadmessages']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

        if (sizeof($forums_array['forums_array']) > 0) {

            foreach ($forums_array['forums_array'] as $forum) {

                echo "                <tr>\n";

                if (isset($forum['INTEREST']) && $forum['INTEREST'] == FORUM_FAVOURITE) {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_rem_fav.png', "rem_fav[{$forum['FID']}]", "{$lang['removefromfavourites']}", "title=\"{$lang['removefromfavourites']}\""), "</td>\n";

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_add_fav.png', "add_fav[{$forum['FID']}]", "{$lang['addtofavourites']}", "title=\"{$lang['addtofavourites']}\""), "</td>\n";
                }

                if (isset($final_uri) && strlen($final_uri) > 0) {

                    if (strstr($final_uri, '?')) {

                        echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%26webtag%3D{$forum['WEBTAG']}\">", word_filter_add_ob_tags($forum['FORUM_NAME']), "</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%3Fwebtag%3D{$forum['WEBTAG']}\">", word_filter_add_ob_tags($forum['FORUM_NAME']), "</a></td>\n";
                    }

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"250\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">", word_filter_add_ob_tags($forum['FORUM_NAME']), "</a></td>\n";
                }

                if (isset($forum['FORUM_DESC']) && strlen(trim($forum['FORUM_DESC'])) > 0) {

                    $forum_desc_short = (strlen(trim($forum['FORUM_DESC'])) > 50) ? substr($forum['FORUM_DESC'], 0, 47). "&hellip;" : $forum['FORUM_DESC'];

                    echo "                  <td align=\"left\" valign=\"top\" width=\"30%\" nowrap=\"nowrap\"><div title=\"", word_filter_add_ob_tags($forum['FORUM_DESC']), "\">", word_filter_add_ob_tags($forum_desc_short), "</div></td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"30%\">&nbsp;</td>\n";
                }

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                        echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), " (", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ",", ",")), ")</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ".", ",")), "</a></td>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), "</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">{$lang['forumnounreadmessages']}</a></td>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {

                    echo "                  <td align=\"left\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\">{$lang['never']}</td>\n";
                }

                if (isset($forum['INTEREST']) && $forum['INTEREST'] > -1) {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_show.png', "unignore_forum[{$forum['FID']}]", "{$lang['unignoreforum']}", "title=\"{$lang['unignoreforum']}\""), "</td>\n";
                }

                echo "                </tr>\n";
            }
        }

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
        echo "      <td align=\"left\">\n";
        echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"postbody\">&nbsp;</td>\n";
        echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&webtag_search=$webtag_search&main_page=$main_page&search_page=$search_page", $start_main, $forums_array['forums_count'], 10, 'main_page'), "</td>\n";
        echo "            <td align=\"right\" width=\"33%\" nowrap=\"nowrap\">{$lang['view']}:&nbsp;", form_dropdown_array('view_type', $forum_header_array, $view_type, "onchange=\"submit()\""), "&nbsp;", form_submit('change_view', $lang['go']), "</td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  <br />\n";
        echo "</form>\n";
        echo "</div>\n";
    }

    echo "<div align=\"center\">\n";
    echo "<form action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
    echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
    echo "  ", form_input_hidden("view_type", _htmlentities($view_type)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td class=\"posthead\" align=\"left\">{$lang['forumname']}: ", form_input_text("webtag_search", (isset($webtag_search) ? _htmlentities($webtag_search) : ""), 30, 64), " ", form_submit('search', $lang['search']), " ", form_submit('clear_search', $lang['clear']), "</td>\n";
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
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

}else {

    $forums_array = get_forum_list($start_main);

    if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) < 1) {
        html_display_warning_msg($lang['noforumsofselectedtype'], '70%', 'center');
    }

    echo "<h1>{$lang['myforums']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("main_page", _htmlentities($main_page)), "\n";
    echo "  ", form_input_hidden("search_page", _htmlentities($search_page)), "\n";
    echo "  ", form_input_hidden("webtag_search", _htmlentities($webtag_search)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['availableforums']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['messages']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

    if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

        foreach ($forums_array['forums_array'] as $forum) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\" width=\"1%\">", form_submit_image('forum_add_fav.png', "add_fav[{$forum['FID']}]", "{$lang['addtofavourites']}", "title=\"{$lang['addtofavourites']}\""), "</td>\n";

            if (isset($final_uri) && strlen($final_uri) > 0) {

                if (strstr($final_uri, '?')) {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"45%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%26webtag%3D{$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" valign=\"top\" width=\"45%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "%3Fwebtag%3D{$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                }

            }else {

                echo "                  <td align=\"left\" valign=\"top\" width=\"45%\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
            }

            echo "                  <td align=\"left\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=discussion.php%3Fwebtag%3D{$forum['WEBTAG']}\">", sprintf($lang['forummessages'], number_format($forum['MESSAGES'], 0, ".", ",")), "</a></td>\n";
            echo "                  <td align=\"center\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";
            echo "                </tr>\n";
        }
    }

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
    echo "      <td align=\"left\">\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"postbody\">&nbsp;</td>\n";
    echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&webtag_search=$webtag_search&main_page=$main_page&search_page=$search_page", $start_main, $forums_array['forums_count'], 10, 'main_page'), "</td>\n";
    echo "            <td align=\"right\" width=\"33%\" nowrap=\"nowrap\">{$lang['view']}:&nbsp;", form_dropdown_array('view_type', $forum_header_array, $view_type), "&nbsp;", form_submit('change_view', $lang['go']), "</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>