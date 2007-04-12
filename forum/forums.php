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

/* $Id: forums.php,v 1.68 2007-04-12 13:23:10 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

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

// Load the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load Language File

$lang = load_language_file();

html_draw_top("basetarget=_top");

if (isset($_POST['submit'])) {

    if (isset($_POST['add_fav']) && is_array($_POST['add_fav'])) {

        if (bh_session_get_value('UID') == 0) {
            html_guest_error();
            exit;
        }

        foreach ($_POST['add_fav'] as $fid => $value) {
            user_set_forum_interest($fid, 1);
        }
    }

    if (isset($_POST['rem_fav']) && is_array($_POST['rem_fav'])) {
        foreach ($_POST['rem_fav'] as $fid => $value) {
            user_set_forum_interest($fid, 0);
        }
    }
}

if (isset($_GET['webtag_search']) && strlen(trim(_stripslashes($_GET['webtag_search']))) > 0) {
    $webtag_search = trim(_stripslashes($_GET['webtag_search']));
}

if (isset($_GET['reset'])) {
    $webtag_search = "";
}

// Are we being redirected somewhere?

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {
    
    $final_uri = rawurldecode(trim(_stripslashes($_GET['final_uri'])));

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/", basename($final_uri)) < 1) unset($final_uri);
}

if (bh_session_get_value('UID') != 0) {

    // Check to see if the user has been approved.

    if (!bh_session_user_approved()) {

        html_user_require_approval();
        exit;
    }

    if ($forums_array = get_my_forums()) {

        echo "<h1>{$lang['myforums']}</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";

        if (sizeof($forums_array['FAV_FORUMS']) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['favouriteforums']}:</td>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['FAV_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" width=\"20\" valign=\"top\">", form_checkbox("rem_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";

                if (isset($final_uri) && strlen($final_uri) > 0) {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "\">{$forum['FORUM_NAME']}</a></td>\n";
                }else {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                }

                echo "                  <td align=\"left\" width=\"30%\" valign=\"top\">{$forum['FORUM_DESC']}</td>\n";

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']} (", number_format($forum['UNREAD_TO_ME'], 0, ",", ","), " {$lang['unreadtome']})</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_TO_ME'], 0, ".", ","), " {$lang['unreadtome']}</a></td>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['NUM_MESSAGES'], 0, ".", ","), " {$lang['messages']}</a></td>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">{$lang['never']}</td>\n";
                }

                echo "                </tr>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['removefromfavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "  <br />\n";
        }

        if (sizeof($forums_array['RECENT_FORUMS']) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['recentlyvisitedforums']}:</td>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['RECENT_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" width=\"20\" valign=\"top\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";

                if (isset($final_uri) && strlen($final_uri) > 0) {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "\">{$forum['FORUM_NAME']}</a></td>\n";
                }else {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                }

                echo "                  <td align=\"left\" width=\"30%\" valign=\"top\">{$forum['FORUM_DESC']}</td>\n";

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']} (", number_format($forum['UNREAD_TO_ME'], 0, ",", ","), " {$lang['unreadtome']})</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_TO_ME'], 0, ".", ","), " {$lang['unreadtome']}</a></td>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['NUM_MESSAGES'], 0, ".", ","), " {$lang['messages']}</a></td>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">{$lang['never']}</td>\n";
                }

                echo "                </tr>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "  <br />\n";
        }

        if (sizeof($forums_array['OTHER_FORUMS']) > 0 && !isset($webtag_search)) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['availableforums']}:</td>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['OTHER_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" width=\"20\" valign=\"top\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";

                if (isset($final_uri) && strlen($final_uri) > 0) {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "\">{$forum['FORUM_NAME']}</a></td>\n";
                }else {
                    echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
                }

                echo "                  <td align=\"left\" width=\"30%\" valign=\"top\">{$forum['FORUM_DESC']}</td>\n";

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']} (", number_format($forum['UNREAD_TO_ME'], 0, ",", ","), " {$lang['unreadtome']})</a></td>\n";

                    }else {

                        echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_TO_ME'], 0, ".", ","), " {$lang['unreadtome']}</a></td>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES'])) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']}</a></td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['NUM_MESSAGES'], 0, ".", ","), " {$lang['messages']}</a></td>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";

                }else {

                    echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">{$lang['never']}</td>\n";
                }

                echo "                </tr>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "  <br />\n";
        }

        echo "</form>\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['myforums']}</h1>\n";
        echo "<br />\n";
        echo "<h2>{$lang['noforumsavailable']}</h2>\n";
        echo "<br />\n";
    }

}else {

    if ($forums_array = get_forum_list()) {

        echo "<h1>{$lang['availableforums']}</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['availableforums']}:</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
        echo "                </tr>\n";

        foreach ($forums_array as $forum) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" width=\"20\" valign=\"top\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
            echo "                  <td align=\"left\" width=\"25%\" valign=\"top\">\n";

            if (isset($final_uri) && strlen($final_uri) > 0) {
                echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "\">{$forum['FORUM_NAME']}</a>\n";
            }else {
                echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
            }

            echo "                  </td>\n";
            echo "                  <td align=\"left\" width=\"30%\" valign=\"top\">{$forum['FORUM_DESC']}</td>\n";
            echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['MESSAGES'], 0, ".", ","), " {$lang['messages']}</a></td>\n";
            echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">&nbsp;</td>\n";
            echo "                </tr>\n";
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
        echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  <br />\n";
        echo "</form>\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['availableforums']}</h1>\n";
        echo "<br />\n";
        echo "<h2>{$lang['noforumsavailablelogin']}</h2>\n";
        echo "<br />\n";
    }
}

if (isset($webtag_search) && strlen($webtag_search) > 0) {

    echo "<div align=\"center\">\n";
    echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"4\" class=\"subhead\">{$lang['searchresults']}:</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['lastvisited']}</td>\n";
    echo "                </tr>\n";

    if ($forum_array = forum_search($webtag_search)) {

        foreach ($forum_array as $forum) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" width=\"20\" valign=\"top\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";

            if (isset($final_uri) && strlen($final_uri) > 0) {
                echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($final_uri), "\">{$forum['FORUM_NAME']}</a></td>\n";
            }else {
                echo "                  <td align=\"left\" width=\"25%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></td>\n";
            }

            echo "                  <td align=\"left\" width=\"30%\" valign=\"top\">{$forum['FORUM_DESC']}</td>\n";

            if ($forum['UNREAD_TO_ME'] > 0) {
                echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']} (", number_format($forum['UNREAD_TO_ME'], 0, ",", ","), " {$lang['unreadtome']})</a></td>\n";
            }elseif($forum['UNREAD_MESSAGES'] > 0) {
                echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['UNREAD_MESSAGES'], 0, ".", ","), " {$lang['unreadmessages']}</a></td>\n";
            }else {
                echo "                  <td align=\"left\" width=\"20%\" valign=\"top\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">", number_format($forum['NUM_MESSAGES'], 0, ".", ","), " {$lang['messages']}</a></td>\n";
            }

            if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {
                echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">", format_time($forum['LAST_VISIT']), "</td>\n";
            }else {
                echo "                  <td align=\"left\" width=\"20%\" valign=\"top\">{$lang['never']}</td>\n";
            }

            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"3\">{$lang['foundzeromatches']}:</td>\n";
        echo "                </tr>\n";
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

    if ($forum_array) {

        echo "    <tr>\n";
        echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "<form action=\"forums.php\" method=\"get\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">Search Forums:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['search']}: ", form_input_text('webtag_search', (isset($webtag_search) ? _htmlentities($webtag_search) : ''), 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
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

html_draw_bottom();

?>