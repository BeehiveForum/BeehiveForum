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

/* $Id: forums.php,v 1.113 2010/01/29 20:54:27 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

$webtag = get_webtag();

// Load Language File

$lang = load_language_file();

// Array to hold error messages

$error_msg_array = array();

// Top Frame name

$frame_top_target = html_get_top_frame_name();

// Top of the page.

html_draw_top("title={$lang['myforums']}", "basetarget=$frame_top_target");

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

// Page numbers

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = $_POST['page'];
}else {
    $page = 1;
}

// Webtag search

if (isset($_POST['webtag_search']) && strlen(trim(stripslashes_array($_POST['webtag_search']))) > 0) {
    $webtag_search = trim(stripslashes_array($_POST['webtag_search']));
}elseif (isset($_GET['webtag_search']) && strlen(trim(stripslashes_array($_GET['webtag_search']))) > 0) {
    $webtag_search = trim(stripslashes_array($_GET['webtag_search']));
}else {
    $webtag_search = "";
}

// Query offset

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Clear the search

if (isset($_POST['clear_search'])) {
    $webtag_search = "";
}

// Column sorting stuff

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "FORUM_NAME") {
        $sort_by = "FORUM_NAME";
    } elseif ($_GET['sort_by'] == "FORUM_DESC") {
        $sort_by = "FORUM_DESC";
    } elseif ($_GET['sort_by'] == "LAST_VISIT") {
        $sort_by = "LAST_VISIT";
    } else {
        $sort_by = "LAST_VISIT";
    }

}else if (isset($_POST['sort_by'])) {

    if ($_POST['sort_by'] == "FORUM_NAME") {
        $sort_by = "FORUM_NAME";
    } elseif ($_POST['sort_by'] == "FORUM_DESC") {
        $sort_by = "FORUM_DESC";
    } elseif ($_POST['sort_by'] == "LAST_VISIT") {
        $sort_by = "LAST_VISIT";
    } else {
        $sort_by = "LAST_VISIT";
    }

}else {

    $sort_by = "LAST_VISIT";
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

}else if (isset($_POST['sort_dir'])) {

    if ($_POST['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

}else {

    $sort_dir = "DESC";
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

            $view_type = $_GET['view_type'];

            if (!in_array($view_type, $available_forum_views)) {

                $view_type = FORUMS_SHOW_FAVS;
            }
        }
    }
}

// Are we being redirected somewhere?

$final_uri = "";

if (isset($_GET['final_uri']) && strlen(trim(stripslashes_array($_GET['final_uri']))) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename(trim(stripslashes_array($_GET['final_uri'])))) > 0) {

        $final_uri = basename(trim(stripslashes_array($_GET['final_uri'])));
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
        header_redirect("forums.php?webtag=$webtag&final_uri=$final_uri&view_type=$view_type&page=$page&added=true");
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
        header_redirect("forums.php?webtag=$webtag&final_uri=$final_uri&view_type=$view_type&page=$page&removed=true");
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
        header_redirect("forums.php?webtag=$webtag&final_uri=$final_uri&view_type=$view_type&page=$page&ignored=true");
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
        header_redirect("forums.php?webtag=$webtag&final_uri=$final_uri&view_type=$view_type&page=$page&unignored=true");
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateforuminterestlevel'];
        $valid = false;
    }
}

if (!user_is_guest()) {

    if (isset($webtag_search) && strlen($webtag_search) > 0) {

        echo "<h1>{$lang['myforums']} &raquo; {$lang['searchresults']}</h1>\n";

        $forums_array = forum_search($webtag_search, $start, $sort_by, $sort_dir);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) < 1) {
            html_display_error_msg($lang['foundzeromatches'], '70%', 'center');
        }else {
            echo "<br />\n";
        }

        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
        echo "  ", form_input_hidden("webtag_search", htmlentities_array($webtag_search)), "\n";
        echo "  ", form_input_hidden("view_type", htmlentities_array($view_type)), "\n";
        echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
        echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";

        if ($sort_by == 'FORUM_NAME' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }elseif ($sort_by == 'FORUM_NAME' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }

        if ($sort_by == 'FORUM_DESC' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }elseif ($sort_by == 'FORUM_DESC' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }

        echo "                   <td class=\"subhead\" align=\"left\">{$lang['unreadmessages']}</td>\n";

        if ($sort_by == 'LAST_VISIT' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }elseif ($sort_by == 'LAST_VISIT' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }

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

                    $forum_desc_short = (mb_strlen(trim($forum['FORUM_DESC'])) > 50) ? mb_substr($forum['FORUM_DESC'], 0, 47). "&hellip;" : $forum['FORUM_DESC'];

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

                if (isset($forum['INTEREST'])) {

                    if ($forum['INTEREST'] == FORUM_IGNORED) {

                        echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_show.png', "unignore_forum[{$forum['FID']}]", "{$lang['unignoreforum']}", "title=\"{$lang['unignoreforum']}\""), "</td>\n";

                    }else {

                        echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";
                    }

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";
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
        echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&page=$page&webtag_search=$webtag_search&sort_by=$sort_by&sort_dir=$sort_dir", $start, $forums_array['forums_count'], 10, 'page'), "</td>\n";
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

        $forums_array = get_my_forums($view_type, $start, $sort_by, $sort_dir);

        echo "<h1>{$lang['myforums']} &raquo; {$forum_header_array[$view_type]}</h1>\n";

        if (isset($_GET['webtag_error'])) {

            html_display_error_msg($lang['invalidforumidorforumnotfound'], '70%', 'center');

        }else if (isset($_GET['added'])) {

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
        echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
        echo "  ", form_input_hidden("webtag_search", htmlentities_array($webtag_search)), "\n";
        echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
        echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"70%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";

        if ($sort_by == 'FORUM_NAME' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }elseif ($sort_by == 'FORUM_NAME' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_NAME&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumname']}</a></td>\n";
        }

        if ($sort_by == 'FORUM_DESC' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }elseif ($sort_by == 'FORUM_DESC' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=FORUM_DESC&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['forumdesc']}</a></td>\n";
        }

        echo "                   <td class=\"subhead\" align=\"left\">{$lang['unreadmessages']}</td>\n";

        if ($sort_by == 'LAST_VISIT' && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }elseif ($sort_by == 'LAST_VISIT' && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=ASC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\"><a href=\"forums.php?webtag=$webtag&amp;view_type=$view_type&amp;sort_by=LAST_VISIT&amp;sort_dir=DESC&amp;webtag_search=", htmlentities_array($webtag_search), "&amp;page=$page\" target=\"_self\">{$lang['lastvisited']}</a></td>\n";
        }

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

                    $forum_desc_short = (mb_strlen(trim($forum['FORUM_DESC'])) > 50) ? mb_substr($forum['FORUM_DESC'], 0, 47). "&hellip;" : $forum['FORUM_DESC'];

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

                if (isset($forum['INTEREST'])) {

                    if ($forum['INTEREST'] == FORUM_IGNORED) {

                        echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_show.png', "unignore_forum[{$forum['FID']}]", "{$lang['unignoreforum']}", "title=\"{$lang['unignoreforum']}\""), "</td>\n";

                    }else {

                        echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";
                    }

                }else {

                    echo "                  <td align=\"center\" valign=\"top\" width=\"1%\">", form_submit_image('forum_hide.png', "ignore_forum[{$forum['FID']}]", "{$lang['ignoreforum']}", "title=\"{$lang['ignoreforum']}\""), "</td>\n";
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
        echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&page=$page&webtag_search=$webtag_search&sort_by=$sort_by&sort_dir=$sort_dir", $start, $forums_array['forums_count'], 10, 'page'), "</td>\n";
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
    echo "<form accept-charset=\"utf-8\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
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
    echo "                        <td class=\"posthead\" align=\"left\">{$lang['forumname']}: ", form_input_text("webtag_search", (isset($webtag_search) ? htmlentities_array($webtag_search) : ""), 30, 64), " ", form_submit('search', $lang['search']), " ", form_submit('clear_search', $lang['clear']), "</td>\n";
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

    $forums_array = get_forum_list($start);

    echo "<h1>{$lang['myforums']}</h1>\n";

    if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) < 1) {
        html_display_warning_msg($lang['noforumsofselectedtype'], '70%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
    echo "  ", form_input_hidden("webtag_search", htmlentities_array($webtag_search)), "\n";
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
    echo "            <td class=\"postbody\" align=\"center\" width=\"33%\" nowrap=\"nowrap\">", page_links("forums.php?webtag=$webtag&view_type=$view_type&page=$page", $start, $forums_array['forums_count'], 10, 'page'), "</td>\n";
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