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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'forum_links.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'links.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold error messages
$error_msg_array = array();

$t_top_link_title = null;
$t_title = null;
$t_title = null;

// Get page number and offset for SQL queries.
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? intval($_POST['page']) : 1;
} else {
    $page = 1;
}

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

                } else {

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

} else if (isset($_POST['toplinksubmit'])) {

    $valid = true;

    if (isset($_POST['t_top_link_title']) && strlen(trim($_POST['t_top_link_title'])) > 0) {
        $t_top_link_title = trim($_POST['t_top_link_title']);
    } else {
        $error_msg_array[] = gettext("No top level link title specified");
        $valid = false;
    }

    if (isset($_POST['t_old_top_link_title']) && strlen(trim($_POST['t_old_top_link_title'])) > 0) {
        $t_old_top_link_title = trim($_POST['t_old_top_link_title']);
    } else {
        $t_old_top_link_title = "";
    }

    if ($valid) {

        $new_forum_settings = array(
            'forum_links_top_link' => $t_top_link_title
        );

        if (forum_save_settings($new_forum_settings)) {

            admin_add_log_entry(EDIT_TOP_LINK_CAPTION, array($t_top_link_title, $t_old_top_link_title));
            header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&updated=true");

        } else {

            $error_msg_array[] = gettext("Failed to update forum settings. Please try again later.");
            $valid = false;
        }
    }

} else if (isset($_POST['addlinksubmit'])) {

    $valid = true;

    if (isset($_POST['t_title']) && strlen(trim($_POST['t_title'])) > 0) {
        $t_title = trim($_POST['t_title']);
    } else {
        $valid = false;
        $error_msg_array[] = gettext("You must enter a link title");
    }

    if (isset($_POST['t_uri']) && strlen(trim($_POST['t_uri'])) > 0) {

        $t_uri = trim($_POST['t_uri']);

        if (preg_match('/^[a-z0-9]+:\/\//iu', $t_uri) < 1) {
            $error_msg_array[] = gettext("All link URIs must start with a schema (i.e. http://, ftp://, irc://)");
            $valid = false;
        }

    } else {

        $t_uri = "";
    }

    if ($valid) {

        if (($t_new_lid = forum_links_add_link($t_title, $t_uri)) !== false) {

            admin_add_log_entry(ADD_FORUM_LINKS, array($t_new_lid, $t_title));
            header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&added=true");

        } else {

            $error_msg_array[] = sprintf(gettext("Failed to add new forum link '%s'"), $t_title);
            $valid = false;
        }
    }

} else if (isset($_POST['updatelinksubmit'])) {

    $valid = true;

    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = intval($_POST['lid']);

        if (isset($_POST['t_title']) && strlen(trim($_POST['t_title'])) > 0) {
            $t_title = trim($_POST['t_title']);
        } else {
            $valid = false;
            $error_msg_array[] = gettext("You must enter a link title");
        }

        if (isset($_POST['t_uri']) && strlen(trim($_POST['t_uri'])) > 0) {

            $t_uri = trim($_POST['t_uri']);

            if (preg_match('/^[a-z0-9]+:\/\//iu', $t_uri) < 1) {
                $error_msg_array[] = gettext("All link URIs must start with a schema (i.e. http://, ftp://, irc://)");
                $valid = false;
            }

        } else {

            $t_uri = "";
        }

        if (isset($_POST['t_old_title']) && strlen(trim($_POST['t_old_title'])) > 0) {
            $t_old_title = trim($_POST['t_old_title']);
        } else {
            $t_old_title = "";
        }

        if (isset($_POST['t_old_uri']) && strlen(trim($_POST['t_old_uri'])) > 0) {
            $t_old_uri = trim($_POST['t_old_uri']);
        } else {
            $t_old_uri = "";
        }

        if ($valid) {

            if (forum_links_update_link($lid, $t_title, $t_uri)) {

                admin_add_log_entry(EDIT_FORUM_LINKS, array($lid, $t_title));
                header_redirect("admin_forum_links.php?webtag=$webtag&page=$page&edited=true");

            } else {

                $error_msg_array[] = sprintf(gettext("Failed to update forum link '%s'"), $t_title);
                $valid = false;
            }
        }
    }

} else if (isset($_POST['addlink'])) {

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

    html_draw_top(
        array(
            'title' => gettext('Admin - Forum Links - Add New Forum Link'),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Forum Links"), html_style_image('separator'), gettext("Add New Forum Link"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addlink', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? htmlentities_array($_POST['t_title']) : ""), 52, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Location"), ":</td>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? htmlentities_array($_POST['t_uri']) : ""), 52, 255), "</td>\n";
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

} else if (isset($_POST['lid']) || isset($_GET['lid'])) {

    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = intval($_POST['lid']);

    } else if (isset($_GET['lid']) && is_numeric($_GET['lid'])) {

        $lid = intval($_GET['lid']);

    } else {

        html_draw_error(gettext("Invalid link id or link not found"), 'admin_forum_links.php', 'get', array('back' => gettext("Back")));
    }

    if (!$forum_link = forum_links_get_link($lid)) {
        html_draw_error(gettext("Invalid link id or link not found"), 'admin_forum_links.php', 'get', array('back' => gettext("Back")));
    }

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Forum Links - Edit Link - %s'),
                $forum_link['TITLE']
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Forum Links"), html_style_image('separator'), gettext("Edit Link"), html_style_image('separator'), word_filter_add_ob_tags($forum_link['TITLE'], true), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('lid', htmlentities_array($lid)), "\n";
    echo "  ", form_input_hidden("t_delete[$lid]", "Y"), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? htmlentities_array($_POST['t_title']) : (isset($forum_link['TITLE']) ? htmlentities_array($forum_link['TITLE']) : "")), 52, 64), form_input_hidden('t_old_title', htmlentities_array($forum_link['TITLE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Forum Link Location"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? htmlentities_array($_POST['t_uri']) : (isset($forum_link['URI']) ? htmlentities_array($forum_link['URI']) : "")), 52, 255), form_input_hidden('t_old_uri', htmlentities_array($forum_link['URI'])), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatelinksubmit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_top(
        array(
            'title' => gettext('Admin - Edit Forum Links'),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    $forum_links_array = forum_links_get_links_by_page($page);

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Edit Forum Links"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '86%', 'center');

    } else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully added new forum link"), '86%', 'center');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully edited forum link"), '86%', 'center');

    } else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully removed selected links"), '86%', 'center');

    } else if (isset($_GET['updated'])) {

        html_display_success_msg(gettext("Preferences were successfully updated."), '86%', 'center');

    } else if (sizeof($forum_links_array['forum_links_array']) < 1) {

        html_display_warning_msg(gettext("Links added here appear in a drop down in the top right of the frame set. To add a link click the 'Add New' button below."), '86%', 'center');

    } else {

        html_display_warning_msg(gettext("Links added here appear in a drop down in the top right of the frame set."), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_forum_links.php\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Name"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Forum Link Location"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($forum_links_array['forum_links_array']) > 0) {

        foreach ($forum_links_array['forum_links_array'] as $key => $forum_link) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$forum_link['LID']}]", "Y"), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">", word_filter_add_ob_tags($forum_link['TITLE'], true), "</a></td>\n";
            echo "                  <td align=\"left\">", $forum_link['URI'], "</a></td>\n";
            echo "                  <td align=\"center\" width=\"50\" style=\"white-space: nowrap\">", form_submit_image('move_up', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">";

    html_page_links("admin_forum_links.php?webtag=$webtag", $page, $forum_links_array['forum_links_count'], 10);

    echo "      </td>\n";
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
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_top_link_title", (isset($_POST['t_top_link_title']) ? htmlentities_array($_POST['t_top_link_title']) : htmlentities_array(forum_get_setting('forum_links_top_link', 'strlen', gettext("Forum Links")))), 52, 64), form_input_hidden('t_old_top_link_title', htmlentities_array(forum_get_setting('forum_links_top_link', 'strlen', gettext("Forum Links")))), "</td>\n";
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