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

/* $Id: forums.php,v 1.22 2004-04-29 14:12:46 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/myforums.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag();

            html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    html_draw_top();
    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load Language File

$lang = load_language_file();

html_draw_top("basetarget=_top");

if (isset($_POST['submit'])) {

    if (isset($_POST['add_fav']) && is_array($_POST['add_fav'])) {
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

if (isset($_GET['webtag_search']) && strlen(trim($_GET['webtag_search'])) > 0) {
    $webtag_search = trim($_GET['webtag_search']);
}

if (isset($_GET['reset'])) {
    $webtag_search = "";
}

if ($user_sess && bh_session_get_value('UID') <> 0) {

    if ($forums_array = get_my_forums()) {

        echo "<h1>{$lang['myforums']}</h1>\n";
        echo "<br>\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";

        if (sizeof($forums_array['FAV_FORUMS']) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td>\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td colspan=\"4\" class=\"subhead\">&nbsp;{$lang['favouriteforums']}:</td>\n";
            echo "                  <td class=\"subhead\">&nbsp;{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['FAV_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td width=\"20\">", form_checkbox("rem_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
                echo "                  <td width=\"25%\">\n";

                if (isset($_GET['final_uri'])) {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($_GET['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
                }else {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
                }

                echo "                  </td>\n";
                echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";

	        if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</a></td>\n";
	        }else {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</a></td>\n";
                }

		if ($forum['LAST_LOGON'] > 0) {
                    echo "                  <td width=\"20%\">", format_time($forum['LAST_LOGON']), "</td>\n";
		}else {
                    echo "                  <td width=\"20%\">{$lang['never']}</td>\n";
		}

                echo "                </tr>\n";
	    }

            echo "                <tr>\n";
            echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['removefromfavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "  <br />\n";
        }

        if (sizeof($forums_array['RECENT_FORUMS']) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td>\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td colspan=\"4\" class=\"subhead\">&nbsp;{$lang['recentlyvisitedforums']}:</td>\n";
            echo "                  <td class=\"subhead\">&nbsp;{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['RECENT_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td width=\"20\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
                echo "                  <td width=\"25%\">\n";

                if (isset($_GET['final_uri'])) {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($_GET['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
                }else {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
                }

                echo "                  </td>\n";
                echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";

                if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</a></td>\n";
                }else {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</a></td>\n";
                }

		if ($forum['LAST_LOGON'] > 0) {
                    echo "                  <td width=\"20%\">", format_time($forum['LAST_LOGON']), "</td>\n";
		}else {
                    echo "                  <td width=\"20%\">{$lang['never']}</td>\n";
		}

                echo "                </tr>\n";
            }

            echo "                <tr>\n";
            echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
	    echo "  <br />\n";
        }

        if (sizeof($forums_array['OTHER_FORUMS']) > 0 && !isset($webtag_search)) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
            echo "    <tr>\n";
            echo "      <td>\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td colspan=\"4\" class=\"subhead\">&nbsp;{$lang['availableforums']}:</td>\n";
            echo "                  <td class=\"subhead\">&nbsp;{$lang['lastvisited']}</td>\n";
            echo "                </tr>\n";

            foreach ($forums_array['OTHER_FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td width=\"20\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
                echo "                  <td width=\"25%\">\n";

                if (isset($_GET['final_uri'])) {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($_GET['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
                }else {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
                }

                echo "                  </td>\n";
                echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";

                if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</a></td>\n";
                }else {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</a></td>\n";
                }

		if ($forum['LAST_LOGON'] > 0) {
                    echo "                  <td width=\"20%\">", format_time($forum['LAST_LOGON']), "</td>\n";
		}else {
                    echo "                  <td width=\"20%\">{$lang['never']}</td>\n";
		}

                echo "                </tr>\n";
            }

            echo "                <tr>\n";
            echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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
            echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
        }

        echo "</form>\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['myforums']}</h1>\n";
        echo "<br>\n";
        echo "<h2>{$lang['noforumsavailable']}.</h2>\n";
    }

}else {

    if ($forums_array = get_forum_list()) {

        echo "<h1>{$lang['availableforums']}</h1>\n";
        echo "<br>\n";
        echo "<div align=\"center\">\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td colspan=\"3\" class=\"subhead\">&nbsp;{$lang['availableforums']}:</td>\n";
        echo "                  <td class=\"subhead\">&nbsp;</td>\n";
        echo "                </tr>\n";

        foreach ($forums_array as $forum) {

            echo "                <tr>\n";
            echo "                  <td width=\"25%\">\n";

            if (isset($_GET['final_uri'])) {
                echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($_GET['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
            }else {
                echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
            }

            echo "                  </td>\n";
            echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";
            echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['MESSAGES']} {$lang['messages']}</a></td>\n";
            echo "                  <td width=\"20%\">&nbsp;</td>\n";
            echo "                </tr>\n";
        }

        echo "                <tr>\n";
        echo "                  <td colspan=\"5\">&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  <br />\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['availableforums']}</h1>\n";
        echo "<br>\n";
        echo "<h2>{$lang['noforumsavailablelogin']}</h2>\n";
    }
}

if (isset($webtag_search) && strlen($webtag_search) > 0) {

    echo "<div align=\"center\">\n";
    echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" class=\"subhead\">&nbsp;{$lang['searchresults']}:</td>\n";
    echo "                  <td class=\"subhead\">&nbsp;{$lang['lastvisited']}</td>\n";
    echo "                </tr>\n";

    if ($forum_array = forum_search($webtag_search)) {

        foreach ($forum_array as $forum) {

            echo "                <tr>\n";
            echo "                  <td width=\"20\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
            echo "                  <td width=\"25%\">\n";

            if (isset($_GET['final_uri'])) {
                echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=", rawurlencode($_GET['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
            }else {
                echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
            }

            echo "                </td>\n";
            echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";
            echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['MESSAGES']} {$lang['messages']}</a></td>\n";
            echo "                  <td width=\"20%\">&nbsp;</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td colspan=\"3\">{$lang['foundzeromatches']}:</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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

    if ($forum_array) {

        echo "    <tr>\n";
        echo "      <td align=\"right\">", form_submit("submit", $lang['addtofavourites']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

echo "<div align=\"center\">\n";
echo "<form action=\"forums.php\" method=\"get\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">Search Forums:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['search']}: ", form_input_text('webtag_search', (isset($webtag_search) ? $webtag_search : ''), 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"6\">&nbsp;</td>\n";
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