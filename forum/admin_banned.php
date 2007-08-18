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

/* $Id: admin_banned.php,v 1.63 2007-08-18 19:42:00 decoyduck Exp $ */

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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
    $request_uri = rawurlencode(get_request_uri(false));
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

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "BANTYPE") {
        $sort_by = "BANTYPE";
    } elseif ($_GET['sort_by'] == "BANDATA") {
        $sort_by = "BANDATA";
    } else {
        $sort_by = "BANDATA";
    }
} else {
    $sort_by = "BANDATA";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

// Form Validation

$valid = true;

// Array to hold error messages

$error_msg_array = array();

// Constant translation of adding and removing bans to log entries.

$admin_log_add_types = array(BAN_TYPE_IP    => ADD_BANNED_IP,
                             BAN_TYPE_LOGON => ADD_BANNED_LOGON,
                             BAN_TYPE_NICK  => ADD_BANNED_NICKNAME,
                             BAN_TYPE_EMAIL => ADD_BANNED_EMAIL,
                             BAN_TYPE_REF   => ADD_BANNED_REFERER);

$admin_log_rem_types = array(BAN_TYPE_IP    => REMOVE_BANNED_IP,
                             BAN_TYPE_LOGON => REMOVE_BANNED_LOGON,
                             BAN_TYPE_NICK  => REMOVE_BANNED_NICKNAME,
                             BAN_TYPE_EMAIL => REMOVE_BANNED_EMAIL,
                             BAN_TYPE_REF   => REMOVE_BANNED_REFERER);

// Are we returning somewhere?

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = rawurldecode(trim(_stripslashes($_POST['ret'])));
}elseif (isset($_GET['ret']) && strlen(trim(_stripslashes($_GET['ret']))) > 0) {
    $ret = rawurldecode(trim(_stripslashes($_GET['ret'])));
}

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_pages = array('admin_user.php', 'admin_users.php', 'admin_visitor_log.php', 'messages.php');
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/", basename($ret)) < 1) unset($ret);
}

// Return to the page we came from.

if (isset($_POST['back']) && isset($ret)) {
    header_redirect($ret);
}

// Cancel button has been pressed.

if (isset($_POST['cancel'])) {

    header_redirect("admin_banned.php?webtag=$webtag");
    exit;
}

// Delete existing ban entry

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_ban']) && is_array($_POST['delete_ban'])) {

        foreach($_POST['delete_ban'] as $ban_id => $delete_ban) {

            if ($valid == true && $delete_ban == "Y" && $ban_data_array = admin_get_ban($ban_id)) {

                if (remove_ban_data_by_id($ban_id)) {

                    admin_add_log_entry($admin_log_rem_types[$ban_data_array['BANTYPE']], $ban_data_array['BANDATA']);

                }else {

                    $error_msg_array[] = $lang['failedtoremovebans'];
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_banned.php?webtag=$webtag&removed=true");
            exit;
        }
    }
}

// Is there an URL query to process?

if (isset($_GET['ban_ipaddress']) && strlen(trim(_stripslashes($_GET['ban_ipaddress'])))) {

    $add_new_ban_type = BAN_TYPE_IP;
    $add_new_ban_data = trim(_stripslashes($_GET['ban_ipaddress']));

}elseif (isset($_GET['unban_ipaddress']) && strlen(trim(_stripslashes($_GET['unban_ipaddress'])))) {

    $unban_ipaddress = trim(_stripslashes($_GET['unban_ipaddress']));

    if (!$remove_ban_id = check_ban_data(BAN_TYPE_IP, $unban_ipaddress)) {
        unset($remove_ban_id);
    }
}

if (isset($_GET['ban_referer']) && strlen(trim(_stripslashes($_GET['ban_referer'])))) {

    $add_new_ban_type = BAN_TYPE_REF;
    $add_new_ban_data = trim(_stripslashes($_GET['ban_referer']));

}elseif (isset($_GET['unban_referer']) && strlen(trim(_stripslashes($_GET['unban_referer'])))) {

    $unban_referer = trim(_stripslashes($_GET['unban_referer']));

    if ($remove_ban_id = check_ban_data(BAN_TYPE_REF, $unban_referer)) {
        unset($remove_ban_id);
    }
}

if (isset($_POST['add']) || isset($_POST['check'])) {

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {

        $new_ban_type = $_POST['newbantype'];

        if ($new_ban_type < 1 || $new_ban_type > 5) {

            $error_msg_array[] = $lang['mustspecifybantype'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifybantype'];
        $valid = false;
    }

    if (isset($_POST['newbandata']) && strlen(trim(_stripslashes($_POST['newbandata']))) > 0) {

        $new_ban_data = trim(_stripslashes($_POST['newbandata']));

        if (preg_match("/^%+$/", $new_ban_data) > 0) {

            $error_msg_array[] = $lang['cannotusewildcardonown'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifybandata'];
        $valid = false;
    }

    if (isset($_POST['newbancomment']) && strlen(trim(_stripslashes($_POST['newbancomment']))) > 0) {
        $comment = trim(_stripslashes($_POST['newbancomment']));
    }else {
        $comment = "";
    }

    if ($valid) {

        if (!check_ban_data($new_ban_type, $new_ban_data)) {

            if (isset($_POST['add'])) {

                if (add_ban_data($new_ban_type, $new_ban_data, $comment)) {

                    admin_add_log_entry($admin_log_add_types[$new_ban_type], array($new_ban_data, $comment));
                    header_redirect("admin_banned.php?webtag=$webtag&added=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtoaddnewban'];
                }
            }

        }else {

            $error_msg_array[] = $lang['duplicatebandataentered'];
            $valid = false;
        }
    }

}elseif (isset($_POST['update'])) {

    if (isset($_POST['ban_id']) && is_numeric($_POST['ban_id'])) {

        $ban_id = $_POST['ban_id'];

        if (isset($_POST['bantype']) && is_numeric($_POST['bantype'])) {

            $ban_type = $_POST['bantype'];

            if ($ban_type < 1 || $ban_type > 5) {

                $error_msg_array[] = $lang['mustspecifybantype'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['mustspecifybantype'];
            $valid = false;
        }

        if (isset($_POST['bandata']) && strlen(trim(_stripslashes($_POST['bandata']))) > 0) {

            $ban_data = trim(_stripslashes($_POST['bandata']));

            if (preg_match("/^%+$/", $ban_data) > 0) {

                $error_msg_array[] = $lang['cannotusewildcardonown'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['mustspecifybandata'];
            $valid = false;
        }

        if (isset($_POST['bancomment']) && strlen(trim(_stripslashes($_POST['bancomment']))) > 0) {
            $comment = trim(_stripslashes($_POST['bancomment']));
        }else {
            $comment = "";
        }

        if (isset($_POST['old_bantype']) && strlen(trim(_stripslashes($_POST['old_bantype']))) > 0) {
            $old_ban_type = trim(_stripslashes($_POST['old_bantype']));
        }else {
            $old_ban_type = "";
        }

        if (isset($_POST['old_bandata']) && strlen(trim(_stripslashes($_POST['old_bandata']))) > 0) {
            $old_ban_data = trim(_stripslashes($_POST['old_bandata']));
        }else {
            $old_ban_data = "";
        }

        if (isset($_POST['old_bancomment']) && strlen(trim(_stripslashes($_POST['old_bancomment']))) > 0) {
            $old_comment = trim(_stripslashes($_POST['old_bancomment']));
        }else {
            $old_comment = "";
        }

        if ($valid) {

            $dup_ban_id = check_ban_data($ban_type, $ban_data);

            if ((!$dup_ban_id) || ($dup_ban_id == $ban_id)) {

                if (update_ban_data($ban_id, $ban_type, $ban_data, $comment)) {

                    if (($ban_type != $old_ban_type) || ($ban_data != $old_ban_data)) {

                        $log_data = array($ban_id, $ban_type, $ban_data, $old_ban_type, $old_ban_data);
                        admin_add_log_entry(UPDATED_BAN, $log_data);
                    }

                    header_redirect("admin_banned.php?webtag=$webtag&edited=true");
                    exit;
                }

            }else {

                $error_msg_array[] = $lang['duplicatebandataentered'];
                $valid = false;
            }
        }
    }

}elseif (isset($_POST['addban'])) {

    $redirect = "./admin_banned.php?webtag=$webtag&addban=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addban']) || isset($_POST['addban']) || (isset($add_new_ban_type) && isset($add_new_ban_data))) {

    html_draw_top('openprofile.js');

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['bancontrols']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '420', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('addban', ''), "\n";
    echo "  ", form_input_hidden("ret", (isset($ret) ? _htmlentities($ret) : '')), "\n";
    echo "  ", form_input_hidden("page", _htmlentities($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['addban']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bantype']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('newbantype', array('&nbsp;', 'IP Address', 'Logon', 'Nickname', 'Email', 'HTTP Referer'), (isset($_POST['newbantype']) ? _htmlentities(_stripslashes($_POST['newbantype'])) : (isset($add_new_ban_type) ? _htmlentities($add_new_ban_type) : ''))), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bandata']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text('newbandata', (isset($_POST['newbandata']) ? _htmlentities(_stripslashes($_POST['newbandata'])) : (isset($add_new_ban_data) ? _htmlentities($add_new_ban_data) : '')), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\" valign=\"top\">{$lang['bancomment']}:</td>\n";
    echo "                        <td align=\"left\">", form_textarea('newbancomment', (isset($_POST['newbancomment']) ? _htmlentities(_stripslashes($_POST['newbancomment'])) : ''), 5, 37), "</td>\n";
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

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {
        $add_new_ban_type = $_POST['newbantype'];
    }

    if (isset($_POST['newbandata']) && strlen(trim(_stripslashes($_POST['newbandata']))) > 0) {
        $add_new_ban_data = $_POST['newbandata'];
    }

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        if ($affected_sessions_array = check_affected_sessions($add_new_ban_type, $add_new_ban_data)) {

            $affected_sessions_text = implode('</li><li>', array_map('admin_prepare_affected_sessions', $affected_sessions_array));
            $affected_sessions_text = sprintf("{$lang['affectsessionwarnadd']}<ul><li>%s</li></ul>", $affected_sessions_text);

            html_display_warning_msg($affected_sessions_text, '420', 'center');

        }else {

            html_display_warning_msg($lang['noaffectsessionwarn'], '420', 'center');
        }
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";

    if (isset($ret)) {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("check", $lang['checkban']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
        echo "    </tr>\n";

    }else {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("check", $lang['checkban']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"postbody\">{$lang['youcanusethepercentwildcard']}</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['ban_id']) || isset($_GET['ban_id']) || isset($remove_ban_id)) {

    if (isset($_POST['ban_id']) && is_numeric($_POST['ban_id'])) {

        $ban_id = $_POST['ban_id'];

    }elseif (isset($_GET['ban_id']) && is_numeric($_GET['ban_id'])) {

        $ban_id = $_GET['ban_id'];

    }elseif (isset($remove_ban_id) && is_numeric($remove_ban_id)) {

        $ban_id = $remove_ban_id;

    }else {

        html_draw_top();
        html_error_msg($lang['invalidbanid'], 'admin_banned.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$ban_data_array = admin_get_ban($ban_id)) {

        html_draw_top();
        html_error_msg($lang['invalidbanid'], 'admin_banned.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['edit_check'])) {

        if (isset($_POST['bantype']) && is_numeric($_POST['bantype'])) {
            $ban_data_array['BANTYPE'] = $_POST['bantype'];
        }

        if (isset($_POST['bandata']) && strlen(trim(_stripslashes($_POST['bandata']))) > 0) {
            $ban_data_array['BANDATA'] = trim(_stripslashes($_POST['bandata']));
        }

        if (isset($_POST['bancomment']) && strlen(trim(_stripslashes($_POST['bancomment']))) > 0) {
            $ban_data_array['COMMENT'] = trim(_stripslashes($_POST['bancomment']));
        }
    }

    html_draw_top('openprofile.js');

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['bancontrols']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('ban_id', _htmlentities($ban_id)), "\n";
    echo "  ", form_input_hidden("delete_ban[$ban_id]", "Y"), "\n";
    echo "  ", form_input_hidden("ret", (isset($ret) ? _htmlentities($ret) : '')), "\n";
    echo "  ", form_input_hidden("page", _htmlentities($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['editban']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bantype']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('bantype', array(1 => 'IP Address', 2 => 'Logon', 3 => 'Nickname', 4 => 'Email', 5 => 'HTTP Referer'), $ban_data_array['BANTYPE']), form_input_hidden('old_bantype', _htmlentities($ban_data_array['BANTYPE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bandata']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text('bandata', _htmlentities($ban_data_array['BANDATA']), 40, 255), form_input_hidden('old_bandata', _htmlentities($ban_data_array['BANDATA'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\" valign=\"top\">{$lang['bancomment']}:</td>\n";
    echo "                        <td align=\"left\">", form_textarea('bancomment', _htmlentities($ban_data_array['COMMENT']), 5, 37), form_input_hidden('old_bancomment', _htmlentities($ban_data_array['COMMENT'])), "</td>\n";
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

    if ($affected_sessions_array = check_affected_sessions($ban_data_array['BANTYPE'], $ban_data_array['BANDATA'])) {

        $affected_sessions_text = implode('</li><li>', array_map('admin_prepare_affected_sessions', $affected_sessions_array));
        $affected_sessions_text = sprintf("{$lang['affectsessionwarnadd']}<ul><li>%s</li></ul>", $affected_sessions_text);

        html_display_warning_msg($affected_sessions_text, '420', 'center');

    }else {

        html_display_warning_msg($lang['noaffectsessionwarn'], '420', 'center');
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";

    if (isset($ret)) {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['save']), "&nbsp;", form_submit("edit_check", $lang['checkban']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
        echo "    </tr>\n";

    }else {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['save']), "&nbsp;", form_submit("edit_check", $lang['checkban']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"postbody\">{$lang['youcanusethepercentwildcard']}</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top('openprofile.js');

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['bancontrols']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    }else if (isset($_GET['added'])) {

        html_display_success_msg($lang['successfullyaddedban'], '600', 'center');

    }else if (isset($_GET['removed'])) {

        html_display_success_msg($lang['successfullyremovedselectedbans'], '600', 'center');

    }else if (isset($_GET['edited'])) {

        html_display_success_msg($lang['successfullyupdatedban'], '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("ret", (isset($ret) ? _htmlentities($ret) : '')), "\n";
    echo "  ", form_input_hidden("page", _htmlentities($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"20\">&nbsp;</td>\n";

    if ($sort_by == 'BANDATA' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">Ban Data</a></td>\n";
    }elseif ($sort_by == 'BANDATA' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">Ban Data</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">Ban Data</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">Ban Data</a></td>\n";
    }

    if ($sort_by == 'BANTYPE' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">Ban Type</a></td>\n";
    }elseif ($sort_by == 'BANTYPE' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">Ban Type</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">Ban Type</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">Ban Type</a></td>\n";
    }

    echo "                 </tr>\n";

    $start = floor($page - 1) * 10;
    if ($start < 0) $start = 0;

    $ban_list_array = admin_get_ban_data($sort_by, $sort_dir, $start);

    $ban_types_array = array('1' => 'IP Address', '2' => 'Logon',
                             '3' => 'Nickname',   '4' => 'Email',
                             '5' => 'HTTP Referer');

    if (sizeof($ban_list_array['ban_array']) > 0) {

        foreach($ban_list_array['ban_array'] as $ban_list_id => $ban_list_entry) {

            echo "                 <tr>\n";
            echo "                   <td align=\"center\">", form_checkbox("delete_ban[$ban_list_id]", "Y", false), "</td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_id=$ban_list_id&amp;page=$page\">{$ban_list_entry['BANDATA']}</a></td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_id=$ban_list_id&amp;page=$page\">", (in_array($ban_list_entry['BANTYPE'], array_keys($ban_types_array)) ? $ban_types_array[$ban_list_entry['BANTYPE']] : $lang['unknown']), "</a></td>\n";
            echo "                 </tr>\n";
        }

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
        echo "                 </tr>\n";
        echo "               </table>\n";
        echo "             </td>\n";
        echo "           </tr>\n";
        echo "         </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(true, false), $start, $ban_list_array['ban_count'], 10), "</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td align=\"left\">&nbsp;</td>\n";
        echo "                   <td align=\"left\" colspan=\"4\">{$lang['noexistingbandata']}</td>\n";
        echo "                 </tr>\n";
        echo "                 <tr>\n";
        echo "                   <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
        echo "                 </tr>\n";
        echo "               </table>\n";
        echo "             </td>\n";
        echo "           </tr>\n";
        echo "         </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";

        if (isset($ret)) {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
            echo "    </tr>\n";

        }else {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
            echo "    </tr>\n";
        }

        echo "  </table>\n";
    }

    echo "  <br />\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>