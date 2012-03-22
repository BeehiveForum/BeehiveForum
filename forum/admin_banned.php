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
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
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

// Load language file
$lang = load_language_file();

if (!(session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
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
    } elseif ($_GET['sort_by'] == "EXPIRES") {
        $sort_by = "EXPIRES";
    } else {
        $sort_by = "ID";
    }
} else {
    $sort_by = "ID";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "ASC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Form Validation
$valid = true;

// Array to hold error messages
$error_msg_array = array();

// Constant translation of adding and removing bans to log entries and string display for Ban Type column.
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

$ban_types_dropdown_array = array(BAN_TYPE_NONE  => '&nbsp;',
                                  BAN_TYPE_IP    => $lang['ipban'],
                                  BAN_TYPE_LOGON => $lang['logonban'],
                                  BAN_TYPE_NICK  => $lang['nicknameban'],
                                  BAN_TYPE_EMAIL => $lang['emailban'],
                                  BAN_TYPE_REF   => $lang['refererban']);

$ban_types_list_array = array(BAN_TYPE_IP    => $lang['ipban'],
                              BAN_TYPE_LOGON => $lang['logonban'],
                              BAN_TYPE_NICK  => $lang['nicknameban'],
                              BAN_TYPE_EMAIL => $lang['emailban'],
                              BAN_TYPE_REF   => $lang['refererban']);

// Are we returning somewhere?
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_GET['ret']) && strlen(trim(stripslashes_array($_GET['ret']))) > 0) {
    $ret = rawurldecode(trim(stripslashes_array($_GET['ret'])));
}elseif (isset($_POST['ret']) && strlen(trim(stripslashes_array($_POST['ret']))) > 0) {
    $ret = trim(stripslashes_array($_POST['ret']));
}else {
    $ret = "admin_banned.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_pages = array('admin_user.php', 'admin_users.php', 'admin_visitor_log.php', 'messages.php');
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/u", basename($ret)) < 1) {
        $ret = "admin_banned.php?webtag=$webtag";
    }
}

// Cancel button has been pressed.
if (isset($_POST['cancel'])) {

    header_redirect($ret);
    exit;
}

// Delete existing ban entry
if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_ban']) && is_array($_POST['delete_ban'])) {

        foreach ($_POST['delete_ban'] as $ban_id => $delete_ban) {

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
if (isset($_GET['ban_ipaddress']) && strlen(trim(stripslashes_array($_GET['ban_ipaddress']))) > 0) {

    $add_new_ban_type = BAN_TYPE_IP;
    $add_new_ban_data = trim(stripslashes_array($_GET['ban_ipaddress']));

}elseif (isset($_GET['unban_ipaddress']) && strlen(trim(stripslashes_array($_GET['unban_ipaddress']))) > 0) {

    $unban_ipaddress = trim(stripslashes_array($_GET['unban_ipaddress']));

    if (!$remove_ban_id = check_ban_data(BAN_TYPE_IP, $unban_ipaddress)) {
        unset($remove_ban_id);
    }
}

if (isset($_GET['ban_email']) && strlen(trim(stripslashes_array($_GET['ban_email']))) > 0) {

    $add_new_ban_type = BAN_TYPE_EMAIL;
    $add_new_ban_data = trim(stripslashes_array($_GET['ban_email']));

}elseif (isset($_GET['unban_email']) && strlen(trim(stripslashes_array($_GET['unban_email']))) > 0) {

    $unban_email = trim(stripslashes_array($_GET['unban_email']));

    if (!$remove_ban_id = check_ban_data(BAN_TYPE_EMAIL, $unban_email)) {
        unset($remove_ban_id);
    }
}

if (isset($_GET['ban_referer']) && strlen(trim(stripslashes_array($_GET['ban_referer']))) > 0) {

    $add_new_ban_type = BAN_TYPE_REF;
    $add_new_ban_data = trim(stripslashes_array($_GET['ban_referer']));

}elseif (isset($_GET['unban_referer']) && strlen(trim(stripslashes_array($_GET['unban_referer']))) > 0) {

    $unban_referer = trim(stripslashes_array($_GET['unban_referer']));

    if (($remove_ban_id = check_ban_data(BAN_TYPE_REF, $unban_referer))) {
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

    if (isset($_POST['newbandata']) && strlen(trim(stripslashes_array($_POST['newbandata']))) > 0) {

        $new_ban_data = trim(stripslashes_array($_POST['newbandata']));

        if (preg_match("/^%+$/Du", $new_ban_data) > 0) {

            $error_msg_array[] = $lang['cannotusewildcardonown'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifybandata'];
        $valid = false;
    }

    if (isset($_POST['newbancomment']) && strlen(trim(stripslashes_array($_POST['newbancomment']))) > 0) {
        $new_ban_comment = trim(stripslashes_array($_POST['newbancomment']));
    }else {
        $new_ban_comment = "";
    }

    if (isset($_POST['newbanexpiresyear']) && isset($_POST['newbanexpiresmonth']) && isset($_POST['newbanexpiresday'])) {

        $newbanexpiresday   = trim(stripslashes_array($_POST['newbanexpiresday']));
        $newbanexpiresmonth = trim(stripslashes_array($_POST['newbanexpiresmonth']));
        $newbanexpiresyear  = trim(stripslashes_array($_POST['newbanexpiresyear']));

        if ((is_numeric($newbanexpiresmonth) && $newbanexpiresmonth > 0) || (is_numeric($newbanexpiresday) && $newbanexpiresday > 0) || (is_numeric($newbanexpiresyear) && $newbanexpiresyear > 0)) {

            if (@checkdate($newbanexpiresmonth, $newbanexpiresday, $newbanexpiresyear)) {

                $new_ban_expires = mktime(0, 0, 0, $newbanexpiresmonth, $newbanexpiresday, $newbanexpiresyear);

            }else {

                $error_msg_array[] = $lang['expirydateisinvalid'];
                $valid = false;
            }

        }else {

            $new_ban_expires = 0;
        }

    }else {

        $new_ban_expires = 0;
    }

    if ($valid) {

        if (!check_ban_data($new_ban_type, $new_ban_data, $new_ban_expires)) {

            if (isset($_POST['add'])) {

                if (add_ban_data($new_ban_type, $new_ban_data, $new_ban_comment, $new_ban_expires)) {

                    admin_add_log_entry($admin_log_add_types[$new_ban_type], array($new_ban_data, $new_ban_comment, $new_ban_expires));
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

        if (isset($_POST['bandata']) && strlen(trim(stripslashes_array($_POST['bandata']))) > 0) {

            $ban_data = trim(stripslashes_array($_POST['bandata']));

            if (preg_match("/^%+$/Du", $ban_data) > 0) {

                $error_msg_array[] = $lang['cannotusewildcardonown'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['mustspecifybandata'];
            $valid = false;
        }

        if (isset($_POST['banexpiresyear']) && isset($_POST['banexpiresmonth']) && isset($_POST['banexpiresday'])) {

            $banexpiresday   = trim(stripslashes_array($_POST['banexpiresday']));
            $banexpiresmonth = trim(stripslashes_array($_POST['banexpiresmonth']));
            $banexpiresyear  = trim(stripslashes_array($_POST['banexpiresyear']));

            if ((is_numeric($banexpiresmonth) && $banexpiresmonth > 0) || (is_numeric($banexpiresday) && $banexpiresday > 0) || (is_numeric($banexpiresyear) && $banexpiresyear > 0)) {

                if (@checkdate($banexpiresmonth, $banexpiresday, $banexpiresyear)) {

                    $ban_expires = mktime(0, 0, 0, $banexpiresmonth, $banexpiresday, $banexpiresyear);

                }else {

                    $error_msg_array[] = $lang['expirydateisinvalid'];
                    $valid = false;
                }

            }else {

                $ban_expires = 0;
            }

        }else {

            $ban_expires = 0;
        }

        if (isset($_POST['bancomment']) && strlen(trim(stripslashes_array($_POST['bancomment']))) > 0) {
            $ban_comment = trim(stripslashes_array($_POST['bancomment']));
        }else {
            $ban_comment = "";
        }

        if (isset($_POST['old_bantype']) && strlen(trim(stripslashes_array($_POST['old_bantype']))) > 0) {
            $old_ban_type = trim(stripslashes_array($_POST['old_bantype']));
        }else {
            $old_ban_type = "";
        }

        if (isset($_POST['old_bandata']) && strlen(trim(stripslashes_array($_POST['old_bandata']))) > 0) {
            $old_ban_data = trim(stripslashes_array($_POST['old_bandata']));
        }else {
            $old_ban_data = "";
        }

        if (isset($_POST['old_banexpires']) && strlen(trim(stripslashes_array($_POST['old_banexpires']))) > 0) {
            $old_ban_expires = trim(stripslashes_array($_POST['old_banexpires']));
        }else {
            $old_ban_expires = 0;
        }

        if ($valid) {

            $dup_ban_id = check_ban_data($ban_type, $ban_data);

            if ((!$dup_ban_id) || ($dup_ban_id == $ban_id)) {

                if (update_ban_data($ban_id, $ban_type, $ban_data, $ban_comment, $ban_expires)) {

                    if (($ban_type != $old_ban_type) || ($ban_data != $old_ban_data) || ($ban_expires != $old_ban_expires)) {

                        $log_data = array($ban_id, $ban_type, $ban_data, $old_ban_type, $old_ban_data, $old_ban_expires);
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

    $redirect = "admin_banned.php?webtag=$webtag&addban=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addban']) || isset($_POST['addban']) || (isset($add_new_ban_type) && isset($add_new_ban_data))) {

    $valid = true;

    html_draw_top("title={$lang['error']}");

    echo "<h1>{$lang['admin']}<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['bancontrols']}</h1>\n";

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {
        $add_new_ban_type = $_POST['newbantype'];
    }

    if (isset($_POST['newbandata']) && strlen(trim(stripslashes_array($_POST['newbandata']))) > 0) {
        $add_new_ban_data = $_POST['newbandata'];
    }

    if (isset($_POST['newbancomment']) && strlen(trim(stripslashes_array($_POST['newbancomment']))) > 0) {
        $add_new_ban_comment = trim(stripslashes_array($_POST['newbancomment']));
    }

    if (isset($_POST['newbanexpiresyear']) && isset($_POST['newbanexpiresmonth']) && isset($_POST['newbanexpiresday'])) {

        $add_new_ban_expires_year  = trim(stripslashes_array($_POST['newbanexpiresyear']));
        $add_new_ban_expires_month = trim(stripslashes_array($_POST['newbanexpiresmonth']));
        $add_new_ban_expires_day   = trim(stripslashes_array($_POST['newbanexpiresday']));

        if ((is_numeric($add_new_ban_expires_month) && $add_new_ban_expires_month > 0) || (is_numeric($add_new_ban_expires_day) && $add_new_ban_expires_day > 0) || (is_numeric($add_new_ban_expires_year) && $add_new_ban_expires_year > 0)) {

            if (@checkdate($add_new_ban_expires_month, $add_new_ban_expires_day, $add_new_ban_expires_year)) {

                $add_new_ban_expires = mktime(0, 0, 0, $add_new_ban_expires_month, $add_new_ban_expires_day, $add_new_ban_expires_year);

            }else {

                html_display_error_msg($lang['expirydateisinvalid'], '420', 'center');
                $valid = false;
            }

        }else {

            $add_new_ban_expires = 0;
        }

    }else {

        $add_new_ban_expires_year  = 0;
        $add_new_ban_expires_month = 0;
        $add_new_ban_expires_day   = 0;
        $add_new_ban_expires       = 0;
    }

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        if ($valid) {

            if (($add_new_ban_expires > 0) && ($add_new_ban_expires < time())) {

                html_display_warning_msg($lang['selecteddateisinthepast'], '420', 'center');

            }else {

                if (($affected_sessions_array = check_affected_sessions($add_new_ban_type, $add_new_ban_data, $add_new_ban_expires))) {

                    $affected_sessions_text = implode('</li><li>', array_map('admin_prepare_affected_sessions', $affected_sessions_array));
                    $affected_sessions_text = sprintf("{$lang['affectsessionwarnadd']}<ul><li>%s</li></ul>", $affected_sessions_text);

                    html_display_warning_msg($affected_sessions_text, '420', 'center');

                }else {

                    html_display_warning_msg($lang['noaffectsessionwarn'], '420', 'center');
                }
            }
        }

    }else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '420', 'center');

    }else {

        html_display_warning_msg($lang['youcanusethepercentwildcard'], '420', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addban', ''), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
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
    echo "                        <td align=\"left\">", form_dropdown_array('newbantype', $ban_types_dropdown_array, (isset($add_new_ban_type) && in_array($add_new_ban_type, array_keys($ban_types_dropdown_array)) ? htmlentities_array(stripslashes_array($add_new_ban_type)) : BAN_TYPE_NONE)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bandata']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text('newbandata', (isset($add_new_ban_data) ? htmlentities_array(stripslashes_array($add_new_ban_data)) : ''), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\" valign=\"top\">{$lang['bancomment']}:</td>\n";
    echo "                        <td align=\"left\">", form_textarea('newbancomment', (isset($add_new_ban_comment) ? htmlentities_array(stripslashes_array($add_new_ban_comment)) : ''), 5, 37), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['banexpires']}:</td>\n";
    echo "                        <td align=\"left\">", form_date_dropdowns($add_new_ban_expires_year, $add_new_ban_expires_month, $add_new_ban_expires_day, "newbanexpires", date('Y')), "&nbsp;<span class=\"small_optional_text\">{$lang['optionalbrackets']}</span></td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("check", $lang['checkban']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['ban_id']) || isset($_GET['ban_id']) || isset($remove_ban_id)) {

    $valid = true;

    if (isset($_POST['ban_id']) && is_numeric($_POST['ban_id'])) {

        $ban_id = $_POST['ban_id'];

    }elseif (isset($_GET['ban_id']) && is_numeric($_GET['ban_id'])) {

        $ban_id = $_GET['ban_id'];

    }elseif (isset($remove_ban_id) && is_numeric($remove_ban_id)) {

        $ban_id = $remove_ban_id;

    }else {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidbanid'], 'admin_banned.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$ban_data_array = admin_get_ban($ban_id)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidbanid'], 'admin_banned.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title={$lang['admin']} - {$lang['bancontrols']}", 'class=window_title');

    echo "<h1>{$lang['admin']}<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['bancontrols']}</h1>\n";

    if (isset($_POST['edit_check'])) {

        if (isset($_POST['bantype']) && is_numeric($_POST['bantype'])) {
            $ban_data_array['BANTYPE'] = $_POST['bantype'];
        }

        if (isset($_POST['bandata']) && strlen(trim(stripslashes_array($_POST['bandata']))) > 0) {
            $ban_data_array['BANDATA'] = trim(stripslashes_array($_POST['bandata']));
        }

        if (isset($_POST['bancomment']) && strlen(trim(stripslashes_array($_POST['bancomment']))) > 0) {
            $ban_data_array['COMMENT'] = trim(stripslashes_array($_POST['bancomment']));
        }

        if (isset($_POST['banexpiresyear']) && isset($_POST['banexpiresmonth']) && isset($_POST['banexpiresday'])) {

            $ban_data_array['EXPIRESYEAR']  = trim(stripslashes_array($_POST['banexpiresyear']));
            $ban_data_array['EXPIRESMONTH'] = trim(stripslashes_array($_POST['banexpiresmonth']));
            $ban_data_array['EXPIRESDAY']   = trim(stripslashes_array($_POST['banexpiresday']));

            if ((is_numeric($ban_data_array['EXPIRESMONTH']) && $ban_data_array['EXPIRESMONTH'] > 0) || (is_numeric($ban_data_array['EXPIRESDAY']) && $ban_data_array['EXPIRESDAY'] > 0) | (is_numeric($ban_data_array['EXPIRESYEAR']) && $ban_data_array['EXPIRESYEAR'] > 0)) {

                if (@checkdate($ban_data_array['EXPIRESMONTH'], $ban_data_array['EXPIRESDAY'], $ban_data_array['EXPIRESYEAR'])) {

                    $ban_data_array['EXPIRES'] = mktime(0, 0, 0, $ban_data_array['EXPIRESMONTH'], $ban_data_array['EXPIRESDAY'], $ban_data_array['EXPIRESYEAR']);

                }else {

                    html_display_error_msg($lang['expirydateisinvalid'], '420', 'center');
                    $valid = false;
                }

            }else {

                $ban_data_array['EXPIRES'] = 0;
            }

        }else {

            $ban_data_array['EXPIRESYEAR']  = 0;
            $ban_data_array['EXPIRESMONTH'] = 0;
            $ban_data_array['EXPIRESDAY']   = 0;
            $ban_data_array['EXPIRES']      = 0;
        }

        if ($valid) {

            if (($ban_data_array['EXPIRES'] > 0) && ($ban_data_array['EXPIRES'] < time())) {

                html_display_warning_msg($lang['selecteddateisinthepast'], '420', 'center');

            }else {

                if (($affected_sessions_array = check_affected_sessions($ban_data_array['BANTYPE'], $ban_data_array['BANDATA'], $ban_data_array['EXPIRES']))) {

                    $affected_sessions_text = implode('</li><li>', array_map('admin_prepare_affected_sessions', $affected_sessions_array));
                    $affected_sessions_text = sprintf("{$lang['affectsessionwarnadd']}<ul><li>%s</li></ul>", $affected_sessions_text);

                    html_display_warning_msg($affected_sessions_text, '420', 'center');

                }else {

                    html_display_warning_msg($lang['noaffectsessionwarn'], '420', 'center');
                }
            }
        }

    }else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '420', 'center');

    }else {

        html_display_warning_msg($lang['youcanusethepercentwildcard'], '420', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('ban_id', htmlentities_array($ban_id)), "\n";
    echo "  ", form_input_hidden("delete_ban[$ban_id]", "Y"), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
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
    echo "                        <td align=\"left\">", form_dropdown_array('bantype', $ban_types_list_array, $ban_data_array['BANTYPE']), form_input_hidden('old_bantype', htmlentities_array($ban_data_array['BANTYPE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['bandata']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text('bandata', htmlentities_array($ban_data_array['BANDATA']), 40, 255), form_input_hidden('old_bandata', htmlentities_array($ban_data_array['BANDATA'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\" valign=\"top\">{$lang['bancomment']}:</td>\n";
    echo "                        <td align=\"left\">", form_textarea('bancomment', htmlentities_array($ban_data_array['COMMENT']), 5, 37), form_input_hidden('old_bancomment', htmlentities_array($ban_data_array['COMMENT'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\" class=\"posthead\">{$lang['banexpires']}:</td>\n";
    echo "                        <td align=\"left\">", form_date_dropdowns($ban_data_array['EXPIRESYEAR'], $ban_data_array['EXPIRESMONTH'], $ban_data_array['EXPIRESDAY'], "banexpires", 2002), form_input_hidden('old_banexpires', htmlentities_array($ban_data_array['EXPIRES'])), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['save']), "&nbsp;", form_submit("edit_check", $lang['checkban']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['admin']} - {$lang['bancontrols']}", 'class=window_title');

    $ban_list_array = admin_get_ban_data($sort_by, $sort_dir, $start);

    echo "<h1>{$lang['admin']}<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['bancontrols']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    }else if (isset($_GET['added'])) {

        html_display_success_msg($lang['successfullyaddedban'], '600', 'center');

    }else if (isset($_GET['removed'])) {

        html_display_success_msg($lang['successfullyremovedselectedbans'], '600', 'center');

    }else if (isset($_GET['edited'])) {

        html_display_success_msg($lang['successfullyupdatedban'], '600', 'center');

    }else if (sizeof($ban_list_array['ban_array']) < 1) {

        html_display_warning_msg($lang['noexistingbandata'], '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
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
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">{$lang['bandata']}</a></td>\n";
    }elseif ($sort_by == 'BANDATA' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">{$lang['bandata']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">{$lang['bandata']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">{$lang['bandata']}</a></td>\n";
    }

    if ($sort_by == 'BANTYPE' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">{$lang['bantype']}</a></td>\n";
    }elseif ($sort_by == 'BANTYPE' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">{$lang['bantype']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">{$lang['bantype']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">{$lang['bantype']}</a></td>\n";
    }

    if ($sort_by == 'EXPIRES' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=EXPIRES&amp;sort_dir=DESC&amp;page=$page\">{$lang['banexpires']}</a></td>\n";
    }elseif ($sort_by == 'EXPIRES' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=EXPIRES&amp;sort_dir=ASC&amp;page=$page\">{$lang['banexpires']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=EXPIRES&amp;sort_dir=ASC&amp;page=$page\">{$lang['banexpires']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"150\"><a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=EXPIRES&amp;sort_dir=DESC&amp;page=$page\">{$lang['banexpires']}</a></td>\n";
    }

    echo "                 </tr>\n";

    if (sizeof($ban_list_array['ban_array']) > 0) {

        foreach ($ban_list_array['ban_array'] as $ban_list_id => $ban_list_entry) {

            echo "                 <tr>\n";
            echo "                   <td align=\"center\">", form_checkbox("delete_ban[$ban_list_id]", "Y", false), "</td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_id=$ban_list_id&amp;page=$page\">{$ban_list_entry['BANDATA']}</a></td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_id=$ban_list_id&amp;page=$page\">", (in_array($ban_list_entry['BANTYPE'], array_keys($ban_types_list_array)) ? $ban_types_list_array[$ban_list_entry['BANTYPE']] : $lang['unknown']), "</a></td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_id=$ban_list_id&amp;page=$page\">", (($ban_list_entry['EXPIRES'] > 0 && $ban_list_entry['EXPIRES'] > time()) ? format_date($ban_list_entry['EXPIRES']) : $lang['never']), "</a></td>\n";
            echo "                 </tr>\n";
        }
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_banned.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir&ret=$ret", $start, $ban_list_array['ban_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>
