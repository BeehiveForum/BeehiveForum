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

/* $Id: admin_user.php,v 1.255 2008-09-13 17:45:58 decoyduck Exp $ */

/**
* Displays and handles the Manage Users and Manage User: [User] pages
*
* Generates the forms relating to user management (kicking and permissions, etc), and handles their sumbission.
*/

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
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
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

$webtag = get_webtag();

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

}else if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {

    $uid = $_POST['uid'];

}else {

    html_draw_top();
    html_error_msg($lang['nouserspecified'], 'admin_users.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = trim(_stripslashes($_POST['ret']));
}else {
    $ret = "admin_users.php?webtag=$webtag";
}

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename($ret)) < 1) {
        $ret = "admin_users.php?webtag=$webtag";
    }
}

if (isset($_POST['cancel'])) {
    header_redirect($ret);
}

if (isset($_POST['edit_users']) && is_array($_POST['edit_users'])) {

    list($gid) = array_keys($_POST['edit_users']);

    $redirect_uri = "admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid";
    $redirect_uri.= "&ret=admin_user.php%3Fwebtag%3D$webtag%26uid=$uid%26ret%3D";
    $redirect_uri.= rawurlencode($ret);

    header_redirect($redirect_uri);
}

// Array to hold error messages

$error_msg_array = array();

// Get the user details.

if (!$user = admin_user_get($uid)) {

    html_draw_top();
    html_error_msg($lang['unknownuseraccount'], 'admin_users.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

// Get the user's post count.

$user['POST_COUNT'] = user_get_post_count($uid);

// Get the user's permissions.

$user_perms = perm_get_forum_user_permissions($uid);

// Do updates

if (isset($_POST['action_submit'])) {

    if (isset($_POST['action']) && strlen(trim(_stripslashes($_POST['action']))) > 0) {

        $post_action = trim(_stripslashes($_POST['action']));

        if ($post_action == 'edit_details') {

            header_redirect("edit_prefs.php?webtag=$webtag&profileuid=$uid");
            exit;

        }elseif ($post_action == 'edit_signature') {

            header_redirect("edit_signature.php?webtag=$webtag&siguid=$uid");
            exit;

        }elseif ($post_action == 'edit_profile') {

            header_redirect("edit_profile.php?webtag=$webtag&profileuid=$uid");
            exit;

        }elseif ($post_action == 'reset_passwd') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=reset_passwd");
            exit;

        }elseif ($post_action == 'view_history') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=view_history");
            exit;

        }elseif ($post_action == 'user_aliases') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=user_aliases");
            exit;

        }elseif ($post_action == 'delete_user') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=delete_user");
            exit;

        }elseif ($post_action == 'delete_posts') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=delete_posts");
            exit;

        }elseif ($post_action == 'approve_user') {

            if (forum_get_setting('require_user_approval', 'Y')) {

                if (($user_logon = user_get_logon($uid))) {

                    if (admin_approve_user($uid)) {

                        email_send_user_approved_notification($uid);

                        header_redirect("admin_user.php?webtag=$webtag&uid=$uid&approved=true");
                        exit;

                    }else {

                        $error_msg_array[] = sprintf($lang['failedtoapproveuser'], $user_logon);
                        $valid = false;
                    }
                }
            }
        }
    }

    header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
    exit;

}else if (isset($_POST['user_history_submit'])) {

    if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        html_draw_top();
        html_error_msg($lang['accessdeniedexp'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['clear_user_history']) && $_POST['clear_user_history'] == "Y") {

        if (admin_clear_user_history($uid)) {

            html_draw_top();
            html_display_msg($lang['userhistory'], $lang['successfullycleareduserhistory'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
            html_draw_bottom();
            exit;

        }else {

            html_draw_top();
            html_error_msg($lang['failedtoclearuserhistory'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['reset_passwd_submit'])) {

    if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        html_draw_top();
        html_error_msg($lang['accessdeniedexp'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_new_password']) && strlen(trim(_stripslashes($_POST['t_new_password']))) > 0) {

        $t_new_password = trim(_stripslashes($_POST['t_new_password']));

        if (($user_logon = user_get_logon($uid) && $fuid = bh_session_get_value('UID'))) {

            if (user_change_password($uid, $t_new_password)) {

                email_send_new_pw_notification($uid, $fuid, $t_new_password);

                html_draw_top();
                html_display_msg($lang['changepassword'], $lang['successfullychangedpassword'], 'admin_user.php', 'get', array('back' => $lang['back']), false, '_self', 'center');
                html_draw_bottom();
                exit;
            }
        }

        html_draw_top();
        html_error_msg($lang['failedtochangepasswd'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['delete_user_confirm'])) {

    if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        html_draw_top();
        html_error_msg($lang['accessdeniedexp'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
        html_draw_bottom();
        exit;
    }

    $delete_content = (isset($_POST['delete_content']) && $_POST['delete_content'] == 'Y');

    if (admin_delete_user($uid, $delete_content)) {

        html_draw_top();
        html_display_msg($lang['deleteuser'], $lang['usersuccessfullydeleted'], 'admin_users.php', 'get', array('back' => $lang['back']), false, '_self', 'center');
        html_draw_bottom();
        exit;

    }else {

        html_draw_top();
        html_error_msg($lang['failedtodeleteuser'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
        html_draw_bottom();
        exit;
    }

}else if (isset($_POST['delete_posts_confirm'])) {

    if (($user_logon = user_get_logon($uid))) {

        if (admin_delete_users_posts($uid)) {

            admin_add_log_entry(DELETE_ALL_USER_POSTS, $user_logon);

            html_draw_top();
            html_display_msg($lang['deleteposts'], $lang['postssuccessfullydeleted'], 'admin_user.php', 'get', array('back' => $lang['back']), false, '_self', 'center');
            html_draw_bottom();
            exit;

        }else {

            html_draw_top();
            html_error_msg($lang['failedtodeleteusersposts'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid), '_self', 'center');
            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['user_perm_submit'])) {

    $valid = true;

    if (forum_check_webtag_available($webtag)) {

        // Check post count is being changed or reset.

        if (isset($_POST['t_reset_post_count']) && $_POST['t_reset_post_count'] == "Y") {

            if (user_reset_post_count($uid)) {

                $user['POST_COUNT'] = user_get_post_count($uid);

            }else {

                $error_msg_array[] = $lang['failedtoresetuserpostcount'];
                $valid = false;
            }

        }else {

            if (isset($_POST['t_post_count']) && is_numeric($_POST['t_post_count'])) {

                $user_post_count = $_POST['t_post_count'];

                if ($user_post_count <> $user['POST_COUNT']) {

                    if (user_update_post_count($uid, $user_post_count)) {

                        $user['POST_COUNT'] = $user_post_count;

                    }else {

                        $error_msg_array[] = $lang['failedtochangeuserpostcount'];
                        $valid = false;
                    }
                }
            }
        }

        // Local user permissions

        $new_user_perms = (double) 0;

        $t_admintools  = (double) (isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
        $t_banned      = (double) (isset($_POST['t_banned']))     ? $_POST['t_banned']     : 0;
        $t_wormed      = (double) (isset($_POST['t_wormed']))     ? $_POST['t_wormed']     : 0;
        $t_pilloried   = (double) (isset($_POST['t_pilloried']))  ? $_POST['t_pilloried']  : 0;
        $t_globalmod   = (double) (isset($_POST['t_globalmod']))  ? $_POST['t_globalmod']  : 0;
        $t_linksmod    = (double) (isset($_POST['t_linksmod']))   ? $_POST['t_linksmod']   : 0;
        $t_ignoreadmin = (double) (isset($_POST['t_ignoreadmin']))? $_POST['t_ignoreadmin']: 0;

        $new_user_perms = (double) $t_admintools | $t_banned | $t_wormed | $t_pilloried | $t_globalmod | $t_linksmod | $t_ignoreadmin;

        if ($user_perms <> $new_user_perms) {

            if (perm_update_user_permissions($uid, $new_user_perms)) {

                admin_add_log_entry(USER_PERMS_CHANGED, $user['LOGON']);

                $user_perms = perm_get_forum_user_permissions($uid);

            }else {

                $error_msg_array[] = $lang['failedtoupdateuserstatus'];
                $valid = false;
            }
        }
    }

    // Global user permissions

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        $new_global_user_perms = (double) 0;

        $global_user_perm = perm_get_global_user_permissions($uid);

        $admin_tools_perm_count = perm_get_admin_tools_perm_count();
        $forum_tools_perm_count = perm_get_forum_tools_perm_count();

        $t_all_admin_tools = (double) (isset($_POST['t_all_admin_tools'])) ? $_POST['t_all_admin_tools'] : 0;
        $t_all_forum_tools = (double) (isset($_POST['t_all_forum_tools'])) ? $_POST['t_all_forum_tools'] : 0;
        $t_all_folder_mod  = (double) (isset($_POST['t_all_folder_mod']))  ? $_POST['t_all_folder_mod']  : 0;
        $t_all_links_mod   = (double) (isset($_POST['t_all_links_mod']))   ? $_POST['t_all_links_mod']   : 0;
        $t_all_banned      = (double) (isset($_POST['t_all_banned']))      ? $_POST['t_all_banned']      : 0;

        if (isset($_POST['t_confirm_email']) && $_POST['t_confirm_email'] != 'cancel') {
            $t_confirm_email = (double) USER_PERM_EMAIL_CONFIRM;
        }else {
            $t_confirm_email = (double) 0;
        }

        $new_global_user_perms = (double) $t_all_admin_tools | $t_all_forum_tools | $t_all_folder_mod | $t_all_links_mod | $t_all_banned | $t_confirm_email;

        if (perm_has_forumtools_access($uid) && $forum_tools_perm_count == 1) {

            if (!($new_global_user_perms & USER_PERM_FORUM_TOOLS)) {

                 $error_msg_array[] = $lang['adminforumtoolsusercounterror'];
                 $valid = false;
            }
        }

        if (perm_has_global_admin_access($uid) && $admin_tools_perm_count == 1) {

            if (!($new_global_user_perms & USER_PERM_ADMIN_TOOLS)) {

                $error_msg_array[] = $lang['adminforumtoolsusercounterror'];
                $valid = false;
            }
        }

        if ($valid && ($new_global_user_perms <> $global_user_perm)) {

            if (perm_update_global_perms($uid, $new_global_user_perms)) {

                $global_user_perm = perm_get_global_user_permissions($uid);

            }else {

                $error_msg_array[] = $lang['failedtoupdateglobaluserpermissions'];
                $valid = false;
            }
        }
    }

    // Local folder permissions

    if (forum_check_webtag_available($webtag)) {

        if (isset($_POST['t_update_perms_array']) && is_array($_POST['t_update_perms_array'])) {

            $t_update_perms_array = $_POST['t_update_perms_array'];

            $folder_array = perm_user_get_folders($uid);

            foreach ($t_update_perms_array as $fid) {

                $t_post_read     = (double) (isset($_POST['t_post_read'][$fid]))     ? $_POST['t_post_read'][$fid]     : 0;
                $t_post_create   = (double) (isset($_POST['t_post_create'][$fid]))   ? $_POST['t_post_create'][$fid]   : 0;
                $t_thread_create = (double) (isset($_POST['t_thread_create'][$fid])) ? $_POST['t_thread_create'][$fid] : 0;
                $t_post_edit     = (double) (isset($_POST['t_post_edit'][$fid]))     ? $_POST['t_post_edit'][$fid]     : 0;
                $t_post_delete   = (double) (isset($_POST['t_post_delete'][$fid]))   ? $_POST['t_post_delete'][$fid]   : 0;
                $t_post_attach   = (double) (isset($_POST['t_post_attach'][$fid]))   ? $_POST['t_post_attach'][$fid]   : 0;
                $t_moderator     = (double) (isset($_POST['t_moderator'][$fid]))     ? $_POST['t_moderator'][$fid]     : 0;
                $t_post_html     = (double) (isset($_POST['t_post_html'][$fid]))     ? $_POST['t_post_html'][$fid]     : 0;
                $t_post_sig      = (double) (isset($_POST['t_post_sig'][$fid]))      ? $_POST['t_post_sig'][$fid]      : 0;
                $t_post_approval = (double) (isset($_POST['t_post_approval'][$fid])) ? $_POST['t_post_approval'][$fid] : 0;

                $new_user_perms = (double) $t_post_read | $t_post_create | $t_thread_create;
                $new_user_perms = (double) $new_user_perms | $t_post_edit | $t_post_delete;
                $new_user_perms = (double) $new_user_perms | $t_moderator | $t_post_attach;
                $new_user_perms = (double) $new_user_perms | $t_post_html | $t_post_sig | $t_post_approval;

                if ($new_user_perms <> $folder_array[$fid]['STATUS']) {

                    if (!perm_update_user_folder_perms($uid, $fid, $new_user_perms)) {

                        $error_msg_array[] = $lang['failedtoupdatefolderaccesssettings'];
                        $valid = false;
                    }
                }
            }

            if ($valid) {

                admin_add_log_entry(USER_FOLDER_PERMS_CHANGED, $user['LOGON']);
            }
        }

        // Confirmation email

        if (isset($_POST['t_confirm_email']) && $_POST['t_confirm_email'] == 'resend') {

            if (!email_send_user_confirmation($uid)) {

                $error_msg_array[] = $lang['failedtosresendemailconfirmation'];
                $valid = false;
            }
        }
    }

    if ($valid) {
        $success_html = $lang['updatessavedsuccessfully'];
    }
}

if (isset($_GET['action']) && strlen(trim(_stripslashes($_GET['action']))) > 0) {
    $action = trim(_stripslashes($_GET['action']));
}elseif (isset($_POST['action']) && strlen(trim(_stripslashes($_POST['action']))) > 0) {
    $action = trim(_stripslashes($_POST['action']));
}

if (isset($action) && strlen(trim($action)) > 0) {

    if ($action == 'reset_passwd') {

        if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

            html_draw_top();
            html_error_msg($lang['accessdeniedexp'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid));
            html_draw_bottom();
            exit;
        }

        html_draw_top('admin.js');

        if (forum_check_webtag_available($webtag)) {
            echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }else {
            echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }

        html_display_warning_msg($lang['forgottenpassworddesc'], '600', 'center');

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
        echo "  ", form_input_hidden("action", _htmlentities($action)), "\n";
        echo "  ", form_input_hidden("ret", _htmlentities("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['resetpassword']}</td>\n";
        echo "                </tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['resetpasswordto']}:</td>\n";
        echo "                        <td align=\"left\">", form_input_password("t_new_password", "", 32, false, "autocomplete=\"off\""), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("reset_passwd_submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    }else if ($action == 'view_history') {

        html_draw_top('admin.js');

        $user_history_array = admin_get_user_history($user['UID']);

        if (forum_check_webtag_available($webtag)) {
            echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }else {
            echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }

        if (is_array($user_history_array) && sizeof($user_history_array) < 1) {
            html_display_warning_msg($lang['nohistory'], '600', 'center');
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
        echo "  ", form_input_hidden("action", _htmlentities($action)), "\n";
        echo "  ", form_input_hidden("ret", _htmlentities("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['userhistory']}</td>\n";
        echo "                </tr>\n";

        if (sizeof($user_history_array) > 0) {

            echo "                <tr>\n";
            echo "                  <td>&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"box\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"100\">{$lang['date']}</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\">{$lang['userhistorychanges']}</td>\n";
            echo "                            </tr>\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" colspan=\"2\">\n";
            echo "                                <div class=\"admin_folder_perms\">\n";

            foreach ($user_history_array as $history_index => $user_history) {

                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" valign=\"top\" width=\"100\">", format_date($user_history['MODIFIED']), "</td>\n";
                echo "                                      <td align=\"left\">{$user_history['DATA']}</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                echo "                                    </tr>\n";
                echo "                                  </table>\n";
            }

            echo "                                </div>\n";
            echo "                              </td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";

            if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

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
                echo "  <br />\n";
                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"left\">\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td class=\"subhead\" align=\"left\">{$lang['userhistory']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">{$lang['clearuserhistory']}:</td>\n";
                echo "                        <td align=\"left\">", form_radio('clear_user_history', 'Y', $lang['yes']), form_radio('clear_user_history', 'N', $lang['no'], true), "</td>\n";
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
                echo "      <td align=\"center\">", form_submit("user_history_submit", $lang['update']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";
            }

        }else {

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
            echo "      <td align=\"center\">", form_submit("cancel", $lang['back']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
        }

        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    }else if ($action == 'user_aliases') {

        html_draw_top('admin.js');

        $user_alias_view = USER_ALIAS_IPADDRESS;

        $user_alias_array = array();

        $user_alias_view_types_array = array(USER_ALIAS_IPADDRESS => $lang['ipaddressmatches'],
                                             USER_ALIAS_EMAIL     => $lang['emailaddressmatches'],
                                             USER_ALIAS_PASSWD    => $lang['passwdmatches'],
                                             USER_ALIAS_REFERER   => $lang['httpreferermatches']);

        $user_alias_column_header = array(USER_ALIAS_IPADDRESS => $lang['ip'],
                                          USER_ALIAS_EMAIL     => $lang['email'],
                                          USER_ALIAS_PASSWD    => $lang['passwd'],
                                          USER_ALIAS_REFERER   => $lang['referer']);

        if (isset($_POST['user_alias_view']) && in_array($_POST['user_alias_view'], array_keys($user_alias_view_types_array))) {
            $user_alias_view = $_POST['user_alias_view'];
        }

        if ($user_alias_view == USER_ALIAS_IPADDRESS) {

            $user_alias_array = admin_get_user_ip_matches($user['UID']);

        }else if ($user_alias_view == USER_ALIAS_EMAIL) {

            $user_alias_array = admin_get_user_email_matches($user['UID']);

        }else if ($user_alias_view == USER_ALIAS_PASSWD) {

            $user_alias_array = admin_get_user_passwd_matches($user['UID']);

        }else if ($user_alias_view == USER_ALIAS_REFERER) {

            $user_alias_array = admin_get_user_referer_matches($user['UID']);
        }

        if (forum_check_webtag_available($webtag)) {
            echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }else {
            echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }

        if (is_array($user_alias_array) && sizeof($user_alias_array) < 1) {
            html_display_warning_msg($lang['searchreturnednoresults'], '700', 'center');
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
        echo "  ", form_input_hidden("action", _htmlentities($action)), "\n";
        echo "  ", form_input_hidden("ret", _htmlentities("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}</td>\n";
        echo "                </tr>\n";

        if (is_array($user_alias_array) && sizeof($user_alias_array) > 0) {

            echo "                <tr>\n";
            echo "                  <td>&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"box\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">{$lang['logon']}</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">{$lang['nickname']}</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\">{$user_alias_column_header[$user_alias_view]}</td>\n";
            echo "                            </tr>\n";

            foreach ($user_alias_array as $user_alias) {

                echo "                            <tr>\n";
                echo "                              <td align=\"left\" width=\"20\">&nbsp;</td>\n";
                echo "                              <td align=\"left\" width=\"150\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$user_alias['UID']}\">", word_filter_add_ob_tags(_htmlentities($user_alias['LOGON'])), "</a></td>\n";
                echo "                              <td align=\"left\" width=\"150\">", word_filter_add_ob_tags(_htmlentities($user_alias['NICKNAME'])), "</td>\n";

                if ($user_alias_view == USER_ALIAS_IPADDRESS) {

                    if ((check_ip_address($user_alias['IPADDRESS'])) && ($hostname = gethostbyaddr($user_alias['IPADDRESS']))) {

                        $ip_address_display = sprintf("<span title=\"%s: %s\">%s</span>", $lang['hostname'], $hostname, $user_alias['IPADDRESS']);

                    }else {

                        $ip_address_display = sprintf("<span title=\"%s\">%s</span>", $lang['unknownhostname'], $user_alias['IPADDRESS']);
                    }

                    if (ip_is_banned($user_alias['IPADDRESS'])) {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user_alias['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">$ip_address_display</a>&nbsp;({$lang['banned']})&nbsp;</td>\n";

                    }else {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user_alias['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">$ip_address_display</a>&nbsp;</td>\n";
                    }

                }else if ($user_alias_view == USER_ALIAS_EMAIL) {

                    if (email_is_banned($user_alias['EMAIL'])) {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_email={$user_alias['EMAIL']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a>&nbsp;({$lang['banned']})&nbsp;</td>\n";

                    }else {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_email={$user_alias['EMAIL']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a>&nbsp;</td>\n";
                    }

                }else if ($user_alias_view == USER_ALIAS_PASSWD) {

                    echo "                              <td align=\"left\">{$lang['yes']}</td>\n";

                }else if ($user_alias_view == USER_ALIAS_REFERER) {

                    $user_alias['REFERER_FULL'] = $user_alias['REFERER'];

                    if (!$user_alias['REFERER'] = split_url($user_alias['REFERER'])) {
                        if (strlen($user_alias['REFERER_FULL']) > 25) {
                            $user_alias['REFERER'] = substr($user_alias['REFERER_FULL'], 0, 25);
                            $user_alias['REFERER'].= "&hellip;";
                        }
                    }

                    if (referer_is_banned($user_alias['REFERER'])) {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user_alias['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['REFERER']}</a>&nbsp;<a href=\"{$user_alias['REFERER_FULL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a>&nbsp;({$lang['banned']})&nbsp;</td>\n";

                    }else {

                        echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user_alias['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['REFERER']}</a>&nbsp;<a href=\"{$user_alias['REFERER_FULL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a>&nbsp;</td>\n";
                    }
                }

                echo "                            </tr>\n";
            }

            echo "                            <tr>\n";
            echo "                              <td align=\"left\">&nbsp;</td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
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
        echo "  </table>\n";
        echo "  <br />\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['options']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"75\">{$lang['view']}:</td>\n";
        echo "                        <td align=\"left\">", form_dropdown_array("user_alias_view", $user_alias_view_types_array, $user_alias_view), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("user_alias_submit", $lang['update']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    }else if ($action == 'delete_user') {

        if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

            html_draw_top();
            html_error_msg($lang['accessdeniedexp'], 'admin_user.php', 'get', array('back' => $lang['back']), array('uid' => $uid));
            html_draw_bottom();
            exit;
        }

        html_draw_top('admin.js');

        if (forum_check_webtag_available($webtag)) {
            echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }else {
            echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
        echo "  ", form_input_hidden("action", _htmlentities($action)), "\n";
        echo "  ", form_input_hidden("ret", _htmlentities("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['warning_caps']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['userdeletewarning']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox('delete_content', 'Y', $lang['alsodeleteusercontent'], false), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("delete_user_confirm", $lang['confirm']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    }else if ($action == 'delete_posts') {

        html_draw_top('admin.js');

        if (forum_check_webtag_available($webtag)) {
            echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }else {
            echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
        echo "  ", form_input_hidden("action", _htmlentities($action)), "\n";
        echo "  ", form_input_hidden("ret", _htmlentities("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['warning_caps']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['userdeleteallpostswarning']}</td>\n";
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
        echo "      <td align=\"center\">", form_submit("delete_posts_confirm", $lang['confirm']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }
}

html_draw_top('admin.js', 'openprofile.js');

if (forum_check_webtag_available($webtag)) {
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
}else {
    echo "<h1>{$lang['admin']} &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}else if (isset($success_html) && strlen(trim($success_html)) > 0) {

    html_display_success_msg($success_html, '600', 'center');

}else if (isset($_GET['profile_updated'])) {

    html_display_success_msg($lang['profileupdated'], '600', 'center');

}else if (isset($_GET['signature_updated'])) {

    html_display_success_msg($lang['signatureupdated'], '600', 'center');

}elseif (isset($_GET['approved'])) {

    html_display_success_msg($lang['successfullyapproveduser'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("uid", _htmlentities($uid)), "\n";
echo "  ", form_input_hidden("ret", _htmlentities($ret)), "\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['userdetails']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['username']}:</td>\n";
    echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" onclick=\"return openProfile($uid, '$webtag')\">", _htmlentities($user['LOGON']), "</a></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['nickname']}:</td>\n";
    echo "                        <td align=\"left\">", _htmlentities($user['NICKNAME']), "</td>\n";
    echo "                      </tr>\n";

    if (email_address_valid($user['EMAIL'])) {

        if (email_is_banned($user['EMAIL'])) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"150\">{$lang['emailaddress']}:</td>\n";
            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_email=", rawurlencode($user['EMAIL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['EMAIL']}\">{$user['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a> ({$lang['banned']})</td>\n";
            echo "                      </tr>\n";

        }else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"150\">{$lang['emailaddress']}:</td>\n";
            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_email=", rawurlencode($user['EMAIL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['EMAIL']}\">{$user['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a></td>\n";
            echo "                      </tr>\n";
        }

    }else {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['emailaddress']}:</td>\n";
        echo "                        <td align=\"left\">{$user['EMAIL']}</td>\n";
        echo "                      </tr>\n";
    }

    if (forum_check_webtag_available($webtag)) {

        if (isset($user['REFERER']) && strlen(trim($user['REFERER'])) > 0) {

            $user['REFERER_FULL'] = $user['REFERER'];

            if (!$user['REFERER'] = split_url($user['REFERER'])) {
                if (strlen($user['REFERER_FULL']) > 25) {
                    $user['REFERER'] = substr($user['REFERER_FULL'], 0, 25);
                    $user['REFERER'].= "&hellip;";
                }
            }

            if (referer_is_banned($user['REFERER'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"150\">{$lang['signupreferer']}</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\" target=\"_blank\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a> ({$lang['banned']})</td>\n";
                echo "                      </tr>\n";

            }else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"150\">{$lang['signupreferer']}</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\" target=\"_blank\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a></td>\n";
                echo "                      </tr>\n";
            }

        }else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"150\">{$lang['signupreferer']}</td>\n";
            echo "                        <td align=\"left\">{$lang['unknown']}</td>\n";
            echo "                      </tr>\n";
        }

        if (isset($user['SESSION_REFERER']) && strlen(trim($user['SESSION_REFERER'])) > 0) {

            $user['SESSION_REFERER_FULL'] = $user['SESSION_REFERER'];

            if (!$user['SESSION_REFERER'] = split_url($user['SESSION_REFERER'])) {
                if (strlen($user['SESSION_REFERER_FULL']) > 25) {
                    $user['SESSION_REFERER'] = substr($user['SESSION_REFERER_FULL'], 0, 25);
                    $user['SESSION_REFERER'].= "&hellip;";
                }
            }

            if (referer_is_banned($user['SESSION_REFERER'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"150\">{$lang['sessionreferer']}</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user['SESSION_REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['SESSION_REFERER_FULL']}\">{$user['SESSION_REFERER']}</a>&nbsp;<a href=\"{$user['SESSION_REFERER_FULL']}\" target=\"_blank\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a> ({$lang['banned']})</td>\n";
                echo "                      </tr>\n";

            }else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"150\">{$lang['sessionreferer']}</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user['SESSION_REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['SESSION_REFERER_FULL']}\">{$user['SESSION_REFERER']}</a>&nbsp;<a href=\"{$user['SESSION_REFERER_FULL']}\" target=\"_blank\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a></td>\n";
                echo "                      </tr>\n";
            }

        }else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"150\">{$lang['sessionreferer']}</td>\n";
            echo "                        <td align=\"left\">{$lang['unknown']}</td>\n";
            echo "                      </tr>\n";
        }

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['lastipaddress']}:</td>\n";

        if ((check_ip_address($user['IPADDRESS'])) && ($hostname = gethostbyaddr($user['IPADDRESS']))) {

            $ip_address_display = sprintf("<span title=\"%s: %s\">%s</span>", $lang['hostname'], $hostname, $user['IPADDRESS']);

        }else {

            $ip_address_display = sprintf("<span title=\"%s\">%s</span>", $lang['unknownhostname'], $lang['unknown']);
        }

        if (ip_is_banned($user['IPADDRESS'])) {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">$ip_address_display</a> ({$lang['banned']})</td>\n";

        }else if (strlen(trim($user['IPADDRESS'])) > 0) {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">$ip_address_display</a></td>\n";

        }else {

            echo "                        <td align=\"left\">{$lang['unknown']}</td>\n";
        }

        echo "                      </tr>\n";
    }

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
    echo "  <br />\n";

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        if (forum_check_webtag_available($webtag)) {

            $admin_options_dropdown = array('edit_details'   => $lang['edituserdetails'],
                                            'edit_signature' => $lang['editsignature'],
                                            'edit_profile'   => $lang['editprofile'],
                                            'reset_passwd'   => $lang['resetpassword'],
                                            'view_history'   => $lang['viewuserhistory'],
                                            'user_aliases'   => $lang['viewuseraliases'],
                                            'delete_user'    => $lang['deleteuser'],
                                            'delete_posts'   => $lang['deleteposts']);

        }else {

            $admin_options_dropdown = array('reset_passwd'   => $lang['resetpassword'],
                                            'view_history'   => $lang['viewuserhistory'],
                                            'user_aliases'   => $lang['viewuseraliases'],
                                            'delete_user'    => $lang['deleteuser']);
        }

    }else {

        $admin_options_dropdown = array('view_history'   => $lang['viewuserhistory'],
                                        'user_aliases'   => $lang['viewuseraliases'],
                                        'delete_posts'   => $lang['deleteposts']);
    }

    if (forum_get_setting('require_user_approval', 'Y') && !admin_user_approved($uid)) {
        $admin_options_dropdown = array_merge(array('approve_user' => $lang['approveuser']), $admin_options_dropdown);
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['moreadminoptions']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">", form_dropdown_array('action', $admin_options_dropdown, false, false, 'admin_options_dropdown'), "&nbsp;", form_submit('action_submit', $lang['goexcmark']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
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
    echo "  </table>\n";
    echo "  <br />\n";
}

if (forum_check_webtag_available($webtag)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['postcount']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['postcount']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_post_count", (isset($_POST['t_post_count'])) ? _htmlentities($_POST['t_post_count']) : _htmlentities($user['POST_COUNT']), 10), "&nbsp;", form_checkbox("t_reset_post_count", "Y", $lang['resetpostcount'], false), "</td>\n";
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
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", sprintf($lang['userstatusforforum'], forum_get_setting('forum_name', false, 'A Beehive Forum')), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['usercanaccessadmintools'], $user_perms & USER_PERM_ADMIN_TOOLS), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['usercanmoderateallfolders'], $user_perms & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, $lang['usercanmoderatelinkssection'], $user_perms & USER_PERM_LINKS_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_banned", USER_PERM_BANNED, $lang['userisbanned'], $user_perms & USER_PERM_BANNED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['useriswormed'], $user_perms & USER_PERM_WORMED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_pilloried", USER_PERM_PILLORIED, $lang['userispilloried'], $user_perms & USER_PERM_PILLORIED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_ignoreadmin", USER_PERM_CAN_IGNORE_ADMIN, $lang['usercanignoreadmin'], $user_perms & USER_PERM_CAN_IGNORE_ADMIN), "</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>";

    html_display_warning_msg($lang['usergroupwarning'], '95%', 'center');

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

    $global_user_perm = perm_get_global_user_permissions($uid);

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['globaluserpermissions']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_admin_tools", USER_PERM_ADMIN_TOOLS, $lang['usercanaccessadmintoolsonallforums'], $global_user_perm & USER_PERM_ADMIN_TOOLS), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_forum_tools", USER_PERM_FORUM_TOOLS, $lang['usercanaccessforumtools'], $global_user_perm & USER_PERM_FORUM_TOOLS), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_folder_mod", USER_PERM_FOLDER_MODERATE, $lang['usercanmodallfoldersonallforums'], $global_user_perm & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_links_mod", USER_PERM_LINKS_MODERATE, $lang['usercanmodlinkssectiononallforums'], $global_user_perm & USER_PERM_LINKS_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_banned", USER_PERM_BANNED, $lang['userisbannedfromallforums'], $global_user_perm & USER_PERM_BANNED), "</td>\n";
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
    echo "  <br />\n";

    if ($global_user_perm & USER_PERM_EMAIL_CONFIRM) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['emailconfirmationrequired']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "cancel", $lang['cancelemailconfirmation'], false), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "resend", $lang['resendconfirmationemail'], false), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "nothing", $lang['donothing'], true), "</td>\n";
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
        echo "  <br />\n";
    }
}

if (forum_check_webtag_available($webtag)) {

    if (($folder_array = perm_user_get_folders($uid))) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['folderaccess']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"box\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"posthead\">\n";
        echo "                          <table class=\"posthead\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" class=\"subhead\" width=\"100\">{$lang['folders']}</td>\n";
        echo "                              <td align=\"left\" class=\"subhead\">{$lang['permissions']}</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"2\">\n";
        echo "                                <div class=\"admin_folder_perms\">\n";

        foreach ($folder_array as $fid => $folder) {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", _htmlentities($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags(_htmlentities($folder['TITLE'])), "</a></td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], $folder['STATUS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], $folder['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], $folder['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $folder['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], $folder['STATUS'] & USER_PERM_POST_APPROVAL), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";
        }

        echo "                                </div>\n";
        echo "                              </td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>\n";

        html_display_warning_msg($lang['usergroupwarning'], '95%', 'center');

        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  <br />\n";
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['usergroups']}</td>\n";
    echo "                </tr>\n";

    if (($user_groups_array = perm_user_get_groups($uid))) {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['useringroups']}:</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                    <table class=\"box\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"posthead\">\n";
        echo "                          <table class=\"posthead\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" class=\"subhead\" width=\"200\">{$lang['groups']}</td>\n";
        echo "                              <td align=\"left\" class=\"subhead\" width=\"50\">{$lang['users']}</td>\n";
        echo "                              <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"3\">\n";
        echo "                                <div class=\"admin_folder_perms\">\n";

        foreach ($user_groups_array as $user_group) {

            echo "                                <table class=\"posthead\" width=\"100%\">\n";
            echo "                                  <tr>\n";
            echo "                                    <td align=\"left\" valign=\"top\" width=\"200\">&nbsp;<a href=\"admin_user_groups_edit.php?webtag=$webtag&amp;gid={$user_group['GID']}&ret=admin_user.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";
            echo "                                    <td valign=\"top\" align=\"center\" width=\"50\">{$user_group['USER_COUNT']}</td>\n";
            echo "                                    <td valign=\"top\" align=\"right\">", form_submit("edit_users[{$user_group['GID']}]", $lang['addremoveusers']), "&nbsp;</td>\n";
            echo "                                  </tr>\n";
            echo "                                </table>\n";
        }

        echo "                                </div>\n";
        echo "                              </td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";


    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['usernotinanygroups']}</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
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
    echo "  </table>\n";
    echo "  <br />\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("user_perm_submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>