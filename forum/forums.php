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

/* $Id: forums.php,v 1.10 2004-04-10 21:45:32 decoyduck Exp $ */

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

// Load the user session. We don't need to check if
// the user should be logged in as we want all visitors
// to be able to see this page.

$user_sess = bh_session_check();

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top("basetarget=_top");

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['add_fav']) && is_array($HTTP_POST_VARS['add_fav'])) {
        foreach ($HTTP_POST_VARS['add_fav'] as $fid => $value) {
	    user_set_forum_interest($fid, 1);
	}
    }

    if (isset($HTTP_POST_VARS['rem_fav']) && is_array($HTTP_POST_VARS['rem_fav'])) {
        foreach ($HTTP_POST_VARS['rem_fav'] as $fid => $value) {
	    user_set_forum_interest($fid, 0);
	}
    }
}

if ($user_sess && bh_session_get_value('UID') <> 0) {

    if ($forums_array = get_my_forums()) {

        echo "<h1>{$lang['myforums']}</h1>\n";
        echo "<br>\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"prefs\" action=\"forums.php\" method=\"post\" target=\"_self\">\n";

        if (sizeof($forums_array['FAVOURITES']) > 0) {

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

            foreach ($forums_array['FAVOURITES'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td width=\"20\">", form_checkbox("rem_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
                echo "                  <td width=\"25%\">\n";

                if (isset($HTTP_GET_VARS['final_uri'])) {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
                }else {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
                }

                echo "                  </td>\n";
                echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";

	        if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=.%2Fdiscussion.php\">{$forum['NEW_MESSAGES']} {$lang['newmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</a></td>\n";
	        }else {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=.%2Fdiscussion.php\">{$forum['NEW_MESSAGES']} {$lang['newmessages']}</a></td>\n";
                }
  
                echo "                  <td width=\"20%\">", format_time($forum['LAST_LOGON']), "</td>\n";
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

        if (sizeof($forums_array['FORUMS']) > 0) {

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

            foreach ($forums_array['FORUMS'] as $forum) {

                echo "                <tr>\n";
                echo "                  <td width=\"20\">", form_checkbox("add_fav[{$forum['FID']}]", "Y", "", false), "</td>\n";
                echo "                  <td width=\"25%\">\n";

                if (isset($HTTP_GET_VARS['final_uri'])) {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
                }else {
                    echo "                    <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
                }

                echo "                  </td>\n";
                echo "                  <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";

                if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=.%2Fdiscussion.php\">{$forum['NEW_MESSAGES']} {$lang['newmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</a></td>\n";
                }else {
                    echo "                  <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=.%2Fdiscussion.php\">{$forum['NEW_MESSAGES']} {$lang['newmessages']}</a></td>\n";
                }
  
                echo "                  <td width=\"20%\">", format_time($forum['LAST_LOGON']), "</td>\n";
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
        echo "<table width=\"90%\" border=\"1\" class=\"box\">\n";
        echo "  <tr>\n";
        echo "    <td class=\"posthead\">\n";
        echo "      <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"posthead\">\n";
        echo "        <tr class=\"subhead\">\n";
        echo "          <td colspan=\"3\">{$lang['availableforums']}:</td>\n";
        echo "          <td>&nbsp;</td>\n";
        echo "        </tr>\n";

        foreach ($forums_array as $forum) {
    
            echo "        <tr>\n";
            echo "          <td width=\"25%\">\n";
            echo "            <a href=\"#\">[?]</a>&nbsp;";

            if (isset($HTTP_GET_VARS['final_uri'])) {
                echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
            }else {
                echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
            }

            echo "          </td>\n";
            echo "          <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";
            echo "          <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['MESSAGES']} {$lang['messages']}</a></td>\n";
            echo "          <td width=\"20%\">&nbsp;</td>\n";
            echo "        </tr>\n";
        }

        echo "      </table>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['availableforums']}</h1>\n";
        echo "<br>\n";
        echo "<h2>{$lang['noforumsavailablelogin']}</h2>\n";
    }
}

html_draw_bottom();

?>