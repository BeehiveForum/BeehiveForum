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

/* $Id: admin_forum_links.php,v 1.28 2006-12-11 21:58:17 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "forum_links.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
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

    $status_array = array();

    if (isset($_POST['l_top_title']) && strlen(trim(_stripslashes($_POST['l_top_title']))) > 0) {
        $l_top_title = trim(_stripslashes($_POST['l_top_title']));
    }else {
        $status_array[] = "<h2>{$lang['notoplevellinktitlespecified']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        forum_links_update_top_link($l_top_title);

        if (isset($_POST['l_title']) && is_array($_POST['l_title'])) {

            foreach($_POST['l_title'] as $lid => $l_title) {

                $l_title = trim(_stripslashes($l_title));

                if (isset($_POST['l_uri'][$lid]) && strlen(trim(_stripslashes($_POST['l_uri'][$lid]))) > 0) {

                    $l_uri = trim(_stripslashes($_POST['l_uri'][$lid]));

                    if (preg_match("/^[a-z0-9]+:\/\//i", $l_uri) < 1) {

                        $status_array[] = "<h2>{$lang['alllinkurismuststartwithaschema']}</h2>\n";
                        $valid = false;
                    }

                }else {

                    $l_uri = "";
                }

                if ($valid) {

                    forum_links_update($lid, $l_title, $l_uri);
                    admin_add_log_entry(EDIT_FORUM_LINKS);
                }
            }
        }

        if (isset($_POST['l_title_new']) && strlen(trim(_stripslashes($_POST['l_title_new']))) > 0) {
            $l_title_new = trim(_stripslashes($_POST['l_title_new']));
        }else {
            $valid = false;
        }

        if (isset($_POST['l_uri_new']) && strlen(trim(_stripslashes($_POST['l_uri_new']))) > 0) {

            $l_uri_new = trim(_stripslashes($_POST['l_uri_new']));

            if (preg_match("/^[a-z0-9]+:\/\//i", $l_uri_new) < 1) {

                $status_array[] = "<h2>{$lang['alllinkurismuststartwithaschema']}</h2>\n";
                $valid = false;
            }

        }else {

            $l_uri_new = "";
        }

        if ($valid) {

            forum_links_add($l_title_new, $l_uri_new);
            admin_add_log_entry(EDIT_FORUM_LINKS);
        }
    }
}

if (isset($_POST['l_delete']) && is_array($_POST['l_delete'])) {

    list($lid) = array_keys($_POST['l_delete']);
    forum_links_delete($lid);
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($lid) = array_keys($_POST['move_up']);

    if (forum_links_move_up($lid)) {
        header_redirect("admin_forum_links.php?webtag=$webtag");
    }
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($lid) = array_keys($_POST['move_down']);
    
    if (forum_links_move_down($lid)) {
        header_redirect("admin_forum_links.php?webtag=$webtag");
    }
}

if (isset($_POST['move_up_disabled']) || isset($_POST['move_down_disabled'])) {
    header_redirect("admin_forum_links.php?webtag=$webtag");
}

html_draw_top();

echo "<h1>{$lang['admin']} &raquo; ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " &raquo; {$lang['editforumlinks']}</h1>\n";
echo "<br />\n";

if (isset($status_array) && is_array($status_array)) {

    foreach($status_array as $status_text) {

        echo $status_text;
    }
}

echo "<div align=\"center\">\n";
echo "<form method=\"post\" action=\"admin_forum_links.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">{$lang['editforumlinks_exp']}</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['name']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['address']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['delete']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";

if ($forum_links_array = forum_links_get_links(true)) {

    $forum_top_link = array_shift($forum_links_array);

    if (is_array($forum_top_link)) {

        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">", form_field("l_top_title", $forum_top_link['TITLE'], 32, 64), "</td>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">", form_field("l_top_title", $lang['forumlinks'], 32, 64), "</td>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                </tr>\n";
    }

    $link_index = 0;
    
    foreach($forum_links_array as $key => $forum_link) {

        $link_index++;

        echo "                <tr>\n";

        if (sizeof($forum_links_array) == 1) {

            echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" target=\"_blank\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" target=\"_blank\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

        }elseif ($link_index == sizeof($forum_links_array)) {

            echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" target=\"_blank\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

        }elseif ($link_index > 1) {

            echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

        }else {

            echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" target=\"_blank\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
        }

        echo "                  <td align=\"left\">", form_field("l_title[{$forum_link['LID']}]", $forum_link['TITLE'], 32, 64), "</td>\n";
        echo "                  <td align=\"left\">", form_field("l_uri[{$forum_link['LID']}]", $forum_link['URI'], 32, 255), "</td>\n";
        echo "                  <td align=\"left\">", form_submit("l_delete[{$forum_link['LID']}]", $lang['delete']), "</td>\n";
        echo "                </tr>\n";
    }

}else {

    forum_links_add_top_link($lang['forumlinks']);
    
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_field("l_top_title", $lang['forumlinks'], 32, 64), "</td>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['newcaps']}</td>\n";
echo "                  <td align=\"left\">", form_field("l_title_new", "", 32, 64), "</td>\n";
echo "                  <td align=\"left\">", form_field("l_uri_new", "", 32, 255), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_reset("reset", $lang['reset']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>