<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Correctly set server protocol
set_server_protocol();

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum_links.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

// Check user has access to this script
if (!(session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("You do not have permission to use this section."));
    html_draw_bottom();
    exit;
}

// Get page number and offset for SQL queries.
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Array to hold error messages
$error_msg_array = array();

// Cancel was clicked
if (isset($_POST['cancel'])) {

    header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
    exit;
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $lid => $delete_link) {

            if ($valid && $delete_link == "Y" && $forum_link = forum_links_get_link($lid)) {

                if (forum_links_delete($lid)) {

                    admin_add_log_entry(DELETE_FORUM_LINKS, array($forum_link['TITLE']));

                }else {

                    $error_msg_array[] = sprintf(gettext("Failed to remove forum link '%s'"), $forum_link['TITLE']);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&deleted=true");
            exit;
        }
    }

}elseif (isset($_POST['toplinksubmit'])) {

    $valid = true;

    if (isset($_POST['t_top_link_title']) && strlen(trim(stripslashes_array($_POST['t_top_link_title']))) > 0) {
        $t_top_link_title = trim(stripslashes_array($_POST['t_top_link_title']));
    }else {
        $error_msg_array[] = gettext("No top level link title specified");
        $valid = false;
    }

    if (isset($_POST['t_old_top_link_title']) && strlen(trim(stripslashes_array($_POST['t_old_top_link_title']))) > 0) {
        $t_old_top_link_title = trim(stripslashes_array($_POST['t_old_top_link_title']));
    }else {
        $t_old_top_link_title = "";
    }

    if ($valid) {

        $new_forum_settings = array('forum_links_top_link' => $t_top_link_title);

        if (forum_save_settings($new_forum_settings)) {

            admin_add_log_entry(EDIT_TOP_LINK_CAPTION, array($t_top_link_title, $t_old_top_link_title));
            header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&updated=true");

        }else {

            $error_msg_array[] = gettext("Failed to update forum settings. Please try again later.");
            $valid = false;
        }
    }

}elseif (isset($_POST['addlinksubmit'])) {

    $valid = true;

    if (isset($_POST['t_title']) && strlen(trim(stripslashes_array($_POST['t_title']))) > 0) {
        $t_title = trim(stripslashes_array($_POST['t_title']));
    }else {
        $valid = false;
        $error_msg_array[] = gettext("You must enter a link title");
    }

    if (isset($_POST['t_uri']) && strlen(trim(stripslashes_array($_POST['t_uri']))) > 0) {

        $t_uri = trim(stripslashes_array($_POST['t_uri']));

        if (preg_match('/^[a-z0-9]+:\/\//iu', $t_uri) < 1) {
            $error_msg_array[] = gettext("All link URIs must start with a schema (i.e. http://, ftp://, irc://)");
            $valid = false;
        }

    }else {

        $t_uri = "";
    }

    if ($valid) {

        if (($t_new_lid = forum_links_add_link($t_title, $t_uri))) {

            admin_add_log_entry(ADD_FORUM_LINKS, array($t_new_lid, $t_title));
            header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&added=true");

        }else {

            $error_msg_array[] = sprintf(gettext("Failed to add new forum link '%s'"), $t_title);
            $valid = false;
        }
    }

}elseif (isset($_POST['updatelinksubmit'])) {

    $valid = true;

    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = $_POST['lid'];

        if (isset($_POST['t_title']) && strlen(trim(stripslashes_array($_POST['t_title']))) > 0) {
            $t_title = trim(stripslashes_array($_POST['t_title']));
        }else {
            $valid = false;
            $error_msg_array[] = gettext("You must enter a link title");
        }

        if (isset($_POST['t_uri']) && strlen(trim(stripslashes_array($_POST['t_uri']))) > 0) {

            $t_uri = trim(stripslashes_array($_POST['t_uri']));

            if (preg_match('/^[a-z0-9]+:\/\//iu', $t_uri) < 1) {
                $error_msg_array[] = gettext("All link URIs must start with a schema (i.e. http://, ftp://, irc://)");
                $valid = false;
            }

        }else {

            $t_uri = "";
        }

        if (isset($_POST['t_old_title']) && strlen(trim(stripslashes_array($_POST['t_old_title']))) > 0) {
            $t_old_title = trim(stripslashes_array($_POST['t_old_title']));
        }else {
            $t_old_title = "";
        }

        if (isset($_POST['t_old_uri']) && strlen(trim(stripslashes_array($_POST['t_old_uri']))) > 0) {
            $t_old_uri = trim(stripslashes_array($_POST['t_old_uri']));
        }else {
            $t_old_uri = "";
        }

        if ($valid) {

            if (forum_links_update_link($lid, $t_title, $t_uri)) {

                admin_add_log_entry(EDIT_FORUM_LINKS, array($lid, $t_title));
                header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&edited=true");

            }else {

                $error_msg_array[] = sprintf(gettext("Failed to update forum link '%s'"), $t_title);
                $valid = false;
            }
        }
    }

}elseif (isset($_POST['addlink'])) {

    header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&addlink=true");
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($lid) = array_keys($_POST['move_up']);

    if (forum_links_move_up($lid)) {

        header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
        exit;
    }
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($lid) = array_keys($_POST['move_down']);

    if (forum_links_move_down($lid)) {

        header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
        exit;
    }
}

if (isset($_POST['move_up_disabled']) || isset($_POST['move_down_disabled'])) {

    header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
    exit;
}

if (isset($_GET['addlink']) || isset($_POST['addlink'])) {

    html_draw_top("title=", gettext("Admin"), " - ", gettext("Forum Links"), " - ", gettext("Add New Forum Link"), "", 'class=window_title');

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Forum Links"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Add New Forum Link"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addlink', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Add New Forum Link"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Title"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? htmlentities_array(stripslashes_array($_POST['t_title'])) : ""), 40, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Location"), ":</td>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? htmlentities_array(stripslashes_array($_POST['t_uri'])) : ""), 40, 255), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addlinksubmit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['lid']) || isset($_GET['lid'])) {

    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = $_POST['lid'];

    }elseif (isset($_GET['lid']) && is_numeric($_GET['lid'])) {

        $lid = $_GET['lid'];

    }else {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("Invalid link id or link not found"), 'admin_forum_links.php', 'get', array('back' => gettext("Back")));
        html_draw_bottom();
        exit;
    }

    if (!$forum_link = forum_links_get_link($lid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("Invalid link id or link not found"), 'admin_forum_links.php', 'get', array('back' => gettext("Back")));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title=", gettext("Admin"), " - ", gettext("Forum Links"), " - ", gettext("Edit Link"), " - {$forum_link['TITLE']}", 'class=window_title');

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" /> ", gettext("Forum Links"), " <img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" /> ", gettext("Edit Link"), " <img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" /> ", word_filter_add_ob_tags($forum_link['TITLE'], true), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('lid', htmlentities_array($lid)), "\n";
    echo "  ", form_input_hidden("t_delete[$lid]", "Y"), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Edit Link"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Title"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? htmlentities_array(stripslashes_array($_POST['t_title'])) : (isset($forum_link['TITLE']) ? htmlentities_array($forum_link['TITLE']) : "")), 40, 64), form_input_hidden('t_old_title', htmlentities_array($forum_link['TITLE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Location"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? htmlentities_array(stripslashes_array($_POST['t_uri'])) : (isset($forum_link['URI']) ? htmlentities_array($forum_link['URI']) : "")), 40, 255), form_input_hidden('t_old_uri', htmlentities_array($forum_link['URI'])), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatelinksubmit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;",form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title=", gettext("Admin"), " - ", gettext("Edit Forum Links"), "", 'class=window_title');

    $forum_links_array = forum_links_get_links_by_page($start);

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" /> ", gettext("Edit Forum Links"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');

    }else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully added new forum link"), '500', 'center');

    }else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully edited forum link"), '500', 'center');

    }else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully removed selected links"), '500', 'center');

    }else if (isset($_GET['updated'])) {

        html_display_success_msg(gettext("Preferences were successfully updated."), '500', 'center');

    }else if (sizeof($forum_links_array['forum_links_array']) < 1) {

        html_display_warning_msg(gettext("Links added here appear in a drop down in the top right of the frame set. To add a link click the 'Add New' button below."), '500', 'center');

    }else {

        html_display_warning_msg(gettext("Links added here appear in a drop down in the top right of the frame set."), '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_links.php\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Name"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($forum_links_array['forum_links_array']) > 0) {

        $link_index = $start;

        foreach ($forum_links_array['forum_links_array'] as $key => $forum_link) {

            $link_index++;

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$forum_link['LID']}]", "Y", false), "</td>\n";

            if ($forum_links_array['forum_links_count'] == 1) {

                echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">", word_filter_add_ob_tags($forum_link['TITLE'], true), "</a></td>\n";
                echo "                  <td align=\"right\">&nbsp;</td>\n";

            }elseif ($link_index == $forum_links_array['forum_links_count']) {

                echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">", word_filter_add_ob_tags($forum_link['TITLE'], true), "</a></td>\n";
                echo "                  <td align=\"right\" width=\"40\" style=\"white-space: nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\"", "move_down_ctrl_disabled"), "</td>\n";

            }elseif ($link_index > 1) {

                echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">", word_filter_add_ob_tags($forum_link['TITLE'], true), "</a></td>\n";
                echo "                  <td align=\"right\" width=\"40\" style=\"white-space: nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

            }else {

                echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">", word_filter_add_ob_tags($forum_link['TITLE'], true), "</a></td>\n";
                echo "                  <td align=\"right\" width=\"40\" style=\"white-space: nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
            }

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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_forum_links.php?webtag=$webtag", $start, $forum_links_array['forum_links_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addlink", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_links.php\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Top link caption"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Top link caption"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_top_link_title", (isset($_POST['t_top_link_title']) ? htmlentities_array(stripslashes_array($_POST['t_top_link_title'])) : htmlentities_array(forum_get_setting('forum_links_top_link', false, gettext("Forum Links")))), 40, 64), form_input_hidden('t_old_top_link_title', htmlentities_array(forum_get_setting('forum_links_top_link', false, gettext("Forum Links")))), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("toplinksubmit", gettext("Save")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>