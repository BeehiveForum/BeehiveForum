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
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'myforums.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_FORUM_TOOLS, 0, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold error messages
$error_msg_array = array();

$forum_delete_array = null;
$t_webtag = null;
$t_name = null;
$t_owner_uid = null;
$t_database = null;
$t_access = null;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? intval($_POST['page']) : 1;
} else {
    $page = 1;
}

// Array of valid forum states
$forum_access_level_array = array(
    FORUM_DISABLED => gettext("Disabled"),
    FORUM_CLOSED => gettext("Closed"),
    FORUM_UNRESTRICTED => gettext("Open"),
    FORUM_RESTRICTED => gettext("Restricted"),
    FORUM_PASSWD_PROTECTED => gettext("Password Protected")
);

// Array of available databases
$available_databases = forums_get_available_dbs();

// Cancel button clicked.
if (isset($_POST['cancel'])) {

    header_redirect("admin_forums.php?webtag=$webtag&page=$page");
    exit;
}

// Confirm forum deletion.
if (isset($_POST['delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $forum_fid => $delete_forum) {

            if (($delete_forum == "Y") && ($forum_name = forum_get_name($forum_fid))) {

                $forum_delete_array[$forum_fid] = "{$forum_name}";
            }
        }

        html_draw_top(
            array(
                'title' => gettext('Admin - Manage Forums'),
                'class' => 'window_title',
                'js' => array(
                    'js/admin.js'
                ),
                'main_css' => 'admin.css'
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Forums"), "</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";

        foreach ($forum_delete_array as $forum_fid => $forum_name) {

            echo "  ", form_input_hidden("t_delete[$forum_fid]", "Y"), "\n";
        }

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">", gettext("WARNING"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">", gettext("Are you sure you want to delete all of the selected forums?"), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\"><ul><li><b>", implode("</b></li><li><b>", $forum_delete_array), "</b></li></ul></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">", gettext("Please note that you cannot recover deleted forums. Once deleted a forum and all of the associated data is permanently removed from the database. If you do not wish to delete the selected forums please click cancel."), "</td>\n";
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
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("t_confirm_delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }

} else if (isset($_POST['t_confirm_delete'])) {

    $valid = true;

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $forum_fid => $delete_forum) {

            if ($valid && $delete_forum == "Y" && $forum_name = forum_get_name($forum_fid)) {

                if (!forum_delete($forum_fid)) {

                    $error_msg_array[] = sprintf(gettext("Failed to deleted forum: '%s'"), $forum_name);
                }
            }
        }

        if ($valid) {

            header_redirect("admin_forums.php?webtag=$webtag&page=$page&deleted=true");
            exit;
        }
    }

} else if (isset($_GET['default']) && is_numeric($_GET['default'])) {

    $fid = intval($_GET['default']);
    forum_update_default($fid);

} else if (isset($_POST['addforumsubmit'])) {

    $valid = true;

    if (isset($_POST['t_webtag']) && strlen(trim($_POST['t_webtag'])) > 0) {

        $t_webtag = mb_strtoupper(trim($_POST['t_webtag']));

        if (!preg_match("/^[A-Z0-9_]+$/Du", $t_webtag)) {

            $error_msg_array[] = gettext("Webtag can only contain uppercase A-Z, 0-9 and underscore characters");
            $valid = false;
        }

        if (strlen(trim($t_webtag)) > 32) {

            $error_msg_array[] = gettext("Webtag must no longer 32 characters in length");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must supply a forum webtag");
        $valid = false;
    }

    if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {
        $t_name = trim($_POST['t_name']);
    } else {
        $error_msg_array[] = gettext("You must supply a forum name");
        $valid = false;
    }

    if (isset($_POST['t_owner']) && strlen(trim($_POST['t_owner'])) > 0) {

        $t_owner = trim($_POST['t_owner']);

        if (($t_user_array = user_get_by_logon($t_owner)) !== false) {

            $t_owner_uid = $t_user_array['UID'];

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Unknown user");
        }

    } else {

        $t_owner = "";
        $t_owner_uid = 0;
    }

    if (isset($_POST['t_database'])) {

        $t_database = $_POST['t_database'];

        if (!in_array($t_database, $available_databases)) {

            $error_msg_array[] = gettext("You must supply a forum database name");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must supply a forum database name");
        $valid = false;
    }

    if (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) {
        $t_access = intval($_POST['t_access']);
    } else {
        $error_msg_array[] = gettext("You must supply a forum access level");
        $valid = false;
    }

    if (isset($_POST['t_default']) && $_POST['t_default'] == 'Y') {
        $t_default = 1;
    } else {
        $t_default = 0;
    }

    if ($valid) {

        $error_str = null;

        if (($new_fid = forum_create($t_webtag, $t_name, $t_owner_uid, $t_database, $t_access, true, $error_str)) !== false) {

            if ($t_default == 1) forum_update_default($new_fid);
            header_redirect("admin_forums.php?webtag=$webtag&page=$page&added=true");

        } else {

            $error_msg_array[] = $error_str;
            $valid = false;
        }
    }

} else if (isset($_POST['updateforumsubmit'])) {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = intval($_POST['fid']);
    } else {
        $error_msg_array[] = gettext("Invalid forum or forum is not available");
        $valid = false;
    }

    if (($valid && $forum_data = forum_get($fid))) {

        if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {
            $t_name = trim($_POST['t_name']);
        } else {
            $error_msg_array[] = gettext("You must supply a forum name");
            $valid = false;
        }

        if (isset($_POST['t_owner']) && strlen(trim($_POST['t_owner'])) > 0) {

            $t_owner = trim($_POST['t_owner']);

            if (($t_user_array = user_get_by_logon($t_owner)) !== false) {

                $t_owner_uid = $t_user_array['UID'];

            } else {

                $valid = false;
                $error_msg_array[] = gettext("Unknown user");
            }

        } else {

            $t_owner = "";
            $t_owner_uid = 0;
        }

        if (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) {
            $t_access = intval($_POST['t_access']);
        } else {
            $error_msg_array[] = gettext("You must supply a forum access level");
            $valid = false;
        }

        if (isset($_POST['t_default']) && $_POST['t_default'] == 'Y') {
            $t_default = 1;
        } else {
            $t_default = 0;
        }

        if ($valid) {

            if (forum_update($fid, $t_name, $t_owner_uid, $t_access)) {

                if ($forum_data['DEFAULT_FORUM'] == 1 && $t_default == 0) {
                    forum_update_default(0);
                } else if ($t_default == 1) {
                    forum_update_default($fid);
                }

                header_redirect("admin_forums.php?webtag=$webtag&fid=$fid&page=$page&edited=true");
                exit;

            } else {

                $error_msg_array[] = sprintf(gettext("Failed to update forum: '%s'"), $forum_data['WEBTAG']);
                $valid = false;
            }
        }

    } else {

        $error_msg_array[] = gettext("Invalid forum or forum is not available");
        $valid = false;
    }

} else if (isset($_POST['addforum'])) {

    header_redirect("admin_forums.php?webtag=$webtag&page=$page&addforum=true");
    exit;

} else if (isset($_POST['changepermissions']) && is_array($_POST['changepermissions'])) {

    list($forum_webtag) = array_keys($_POST['changepermissions']);

    $redirect_uri = "admin_forum_access.php?webtag=$forum_webtag&";

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $redirect_uri .= "ret=" . rawurlencode(sprintf("admin_forums.php?webtag=%s&fid=%d", $webtag, intval($_POST['fid'])));
    } else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $redirect_uri .= "ret=" . rawurlencode(sprintf("admin_forums.php?webtag=%s&fid=%d", $webtag, intval($_GET['fid'])));
    }

    header_redirect($redirect_uri);
    exit;

} else if (isset($_POST['changepassword']) && is_array($_POST['changepassword'])) {

    list($forum_webtag) = array_keys($_POST['changepassword']);

    $redirect_uri = "admin_forum_set_passwd.php?webtag=$forum_webtag&";

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $redirect_uri .= "ret=" . rawurlencode(sprintf("admin_forums.php?webtag=%s&fid=%d", $webtag, intval($_POST['fid'])));
    } else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $redirect_uri .= "ret=" . rawurlencode(sprintf("admin_forums.php?webtag=%s&fid=%d", $webtag, intval($_GET['fid'])));
    }

    header_redirect($redirect_uri);
    exit;
}

if (isset($_GET['addforum']) || isset($_POST['addforum'])) {

    html_draw_top(
        array(
            'title' => gettext('Admin - Manage Forums - Add Forum'),
            'class' => 'window_title',
            'js' => array(
                'js/admin.js',
                'js/search_popup.js'
            ),
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Forums"), html_style_image('separator'), gettext("Add Forum"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  ", form_input_hidden('addforum', 'true'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Add Forum"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Forum Webtag"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_webtag", (isset($_POST['t_webtag']) ? htmlentities_array($_POST['t_webtag']) : ""), 30, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Forum Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? htmlentities_array($_POST['t_name']) : ""), 30, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Forum Leader"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_owner", (isset($_POST['t_owner']) ? htmlentities_array($_POST['t_owner']) : ""), 35, 15), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Access level"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_access", array('' => '&nbsp;', FORUM_DISABLED => gettext("Disabled"), FORUM_CLOSED => gettext("Closed"), FORUM_UNRESTRICTED => gettext("Open"), FORUM_RESTRICTED => gettext("Restricted"), FORUM_PASSWD_PROTECTED => gettext("Password Protected")), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $_POST['t_access'] : ''), "</td>\n";
    echo "                      </tr>\n";

    if (is_array($available_databases)) {

        $available_databases = array_merge(array('&nbsp;'), $available_databases);

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Use Database"), ":</td>\n";
        echo "                        <td align=\"left\">", form_dropdown_array("t_database", $available_databases, (isset($_POST['t_database']) ? $_POST['t_database'] : "")), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Default Forum"), ":</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'Y', gettext("Yes")), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'N', gettext("No"), true), "&nbsp;", "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addforumsubmit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

    html_display_warning_msg(gettext("When setting Restricted or Password Protected mode you will need to save your changes before you can change the user access privileges or password."), '700', 'center');
    html_display_warning_msg(gettext("Please ensure you select the correct database when creating a new forum. Once created a new forum cannot be moved between available databases."), '700', 'center');

    echo "</div>\n";

    html_draw_bottom();

} else if (isset($_POST['fid']) || isset($_GET['fid'])) {

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

        $fid = intval($_POST['fid']);

    } else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

        $fid = intval($_GET['fid']);

    } else {

        html_draw_error(gettext("Invalid forum or forum is not available"), 'admin_forums.php', 'get', array('back' => gettext("Back")));
    }

    if (!$forum_data = forum_get($fid)) {
        html_draw_error(gettext("Invalid forum or forum is not available"), 'admin_forums.php', 'get', array('back' => gettext("Back")));
    }

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Manage Forums - Edit Forum - %s'),
                $forum_data['WEBTAG']
            ),
            'class' => 'window_title',
            'js' => array(
                'js/admin.js',
                'js/search_popup.js'
            ),
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Forums"), html_style_image('separator'), gettext("Edit Forum"), html_style_image('separator'), "{$forum_data['WEBTAG']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '700', 'center');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully updated forum"), '700', 'center', 'forum_updated');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('fid', htmlentities_array($fid)), "\n";
    echo "  ", form_input_hidden("t_delete[$fid]", "Y"), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Edit Forum"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Forum Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? htmlentities_array($_POST['t_name']) : (isset($forum_data['FORUM_SETTINGS']['forum_name']) ? htmlentities_array($forum_data['FORUM_SETTINGS']['forum_name']) : "")), 52, 255), form_input_hidden("t_name_old", (isset($forum_data['FORUM_SETTINGS']['forum_name']) ? htmlentities_array($forum_data['FORUM_SETTINGS']['forum_name']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Forum Leader"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_owner", (isset($_POST['t_owner']) ? htmlentities_array($_POST['t_owner']) : (isset($forum_data['FORUM_SETTINGS']['forum_leader']) ? htmlentities_array($forum_data['FORUM_SETTINGS']['forum_leader']) : "")), 35, 15), form_input_hidden("t_owner_old", (isset($forum_data['FORUM_SETTINGS']['forum_leader']) ? htmlentities_array($forum_data['FORUM_SETTINGS']['forum_leader']) : "")), "</td>\n";
    echo "                      </tr>\n";

    if ($forum_data['ACCESS_LEVEL'] == FORUM_RESTRICTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Access level"), ":</td>\n";
        echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_dropdown_array("t_access", array(FORUM_DISABLED => gettext("Disabled"), FORUM_CLOSED => gettext("Closed"), FORUM_UNRESTRICTED => gettext("Open"), FORUM_RESTRICTED => gettext("Restricted"), FORUM_PASSWD_PROTECTED => gettext("Password Protected")), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "&nbsp;", form_submit("changepermissions[{$forum_data['WEBTAG']}]", gettext("Change")), "</td>\n";
        echo "                      </tr>\n";

    } else if ($forum_data['ACCESS_LEVEL'] == FORUM_PASSWD_PROTECTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Access level"), ":</td>\n";
        echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_dropdown_array("t_access", array(FORUM_DISABLED => gettext("Disabled"), FORUM_CLOSED => gettext("Closed"), FORUM_UNRESTRICTED => gettext("Open"), FORUM_RESTRICTED => gettext("Restricted"), FORUM_PASSWD_PROTECTED => gettext("Password Protected")), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "&nbsp;", form_submit("changepassword[{$forum_data['WEBTAG']}]", gettext("Change")), "</td>\n";
        echo "                      </tr>\n";

    } else {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Access level"), ":</td>\n";
        echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_dropdown_array("t_access", array(FORUM_DISABLED => gettext("Disabled"), FORUM_CLOSED => gettext("Closed"), FORUM_UNRESTRICTED => gettext("Open"), FORUM_RESTRICTED => gettext("Restricted"), FORUM_PASSWD_PROTECTED => gettext("Password Protected")), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Default Forum"), ":</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'Y', gettext("Yes"), (isset($_POST['t_default']) && is_numeric($_POST['t_default']) && $_POST['t_default'] == 1) ? true : (isset($forum_data['DEFAULT_FORUM']) && is_numeric($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 1) ? true : false), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'N', gettext("No"), (isset($_POST['t_default']) && is_numeric($_POST['t_default']) && $_POST['t_default'] == 0) ? true : (isset($forum_data['DEFAULT_FORUM']) && is_numeric($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 0) ? true : false), "&nbsp;", "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updateforumsubmit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(gettext("When setting Restricted or Password Protected mode you will need to save your changes before you can change the user access privileges or password."), '700', 'center');

    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_top(
        array(
            'title' => gettext('Admin - Manage Forums'),
            'class' => 'window_title',
            'js' => array(
                'js/admin.js'
            ),
            'main_css' => 'admin.css'
        )
    );

    $forums_array = admin_get_forum_list($page);

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Forums"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '86%', 'center');

    } else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully created new forum"), '86%', 'center', 'forum_created');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully updated forum"), '86%', 'center', 'forum_updated');

    } else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully deleted selected forums"), '86%', 'center', 'forum_removed');

    } else if (sizeof($forums_array['forums_array']) < 1) {

        html_display_warning_msg(gettext("No existing forums found. To create a new forum click the 'Add New' button below."), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"forums\" action=\"admin_forums.php\" method=\"post\">\n";
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
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\" width=\"150\">", gettext("Webtag"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Name"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Messages"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Access level"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($forums_array['forums_array']) > 0) {

        foreach ($forums_array['forums_array'] as $forum_data) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$forum_data['FID']}]", "Y"), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"admin_forums.php?webtag=$webtag&amp;fid={$forum_data['FID']}&amp;page=$page\" title=\"", gettext("Edit Forum"), "\">{$forum_data['WEBTAG']}</a></td>\n";
            echo "                  <td align=\"left\"><a href=\"index.php?webtag={$forum_data['WEBTAG']}\" title=\"", sprintf(gettext("Visit Forum: %s"), $forum_data['FORUM_NAME']), "\" target=\"_blank\">{$forum_data['FORUM_NAME']}</a></td>\n";

            if (isset($forum_data['MESSAGES'])) {
                echo "                  <td align=\"left\">", format_number($forum_data['MESSAGES']), " ", ($forum_data['MESSAGES'] > 1) ? gettext("Messages") : gettext("Message"), "</td>\n";
            } else {
                echo "                  <td align=\"left\">", gettext("Unknown"), "</td>\n";
            }

            if (isset($forum_data['ACCESS_LEVEL']) && in_array($forum_data['ACCESS_LEVEL'], array_keys($forum_access_level_array))) {
                echo "                  <td align=\"left\">{$forum_access_level_array[$forum_data['ACCESS_LEVEL']]}</td>\n";
            } else {
                echo "                  <td align=\"left\">", gettext("Unknown"), "</td>\n";
            }

            echo "                        <td align=\"left\" style=\"white-space: nowrap\"><a href=\"index.php?webtag={$forum_data['WEBTAG']}&amp;final_uri=admin_forum_settings.php%3Fwebtag%3D{$forum_data['WEBTAG']}\" target=\"", html_get_top_frame_name(), "\">", html_style_image('edit', gettext("Forum Settings")), "</a>&nbsp;";

            if (isset($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 1) {
                echo "<a href=\"admin_forums.php?webtag=$webtag&amp;page=$page&amp;default=0\">", html_style_image('default_forum', gettext("Unset Default")), "</a>\n";
            } else {
                echo "<a href=\"admin_forums.php?webtag=$webtag&amp;page=$page&amp;default={$forum_data['FID']}\">", html_style_image('set_default_forum', gettext("Make Default")), "</a>\n";
            }

            echo "                  </td>\n";
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

    html_page_links("admin_forums.php?webtag=$webtag", $page, $forums_array['forums_count'], 10);

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addforum", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}