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
require_once BH_INCLUDE_PATH . 'banned.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'user_profile.inc.php';
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

$uid = null;

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

} else if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {

    $uid = $_POST['uid'];

} else {

    html_draw_error(gettext("No user specified."), 'admin_users.php', 'get', array('back' => gettext("Back")));
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "messages.php?webtag=$webtag&msg={$_GET['msg']}";
} else if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = trim($_POST['ret']);
} else {
    $ret = "admin_users.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

    if (preg_match("/^$available_files_preg/u", basename($ret)) < 1) {
        $ret = "admin_users.php?webtag=$webtag";
    }
}

if (isset($_POST['cancel'])) {
    header_redirect($ret);
}

// Array to hold error messages
$error_msg_array = array();

// Get the user details.
if (!$user = admin_user_get($uid)) {
    html_draw_error(gettext("Unknown user account"), 'admin_users.php', 'get', array('back' => gettext("Back")));
}

// Get the user's post count.
$user['POST_COUNT'] = user_get_post_count($uid);

// Get the user's permissions.
$user_perms = perm_get_forum_user_permissions($uid);

// Page title
$page_title = gettext("Admin") . " - " . gettext("Manage User") . " - " . format_user_name($user['LOGON'], $user['NICKNAME']);

// Do updates
if (isset($_POST['action_submit'])) {

    if (isset($_POST['action']) && strlen(trim($_POST['action'])) > 0) {

        $post_action = trim($_POST['action']);

        if ($post_action == 'edit_details') {

            header_redirect("edit_prefs.php?webtag=$webtag&profile_uid=$uid");
            exit;

        } else if ($post_action == 'edit_signature') {

            header_redirect("edit_signature.php?webtag=$webtag&sig_uid=$uid");
            exit;

        } else if ($post_action == 'edit_profile') {

            header_redirect("edit_profile.php?webtag=$webtag&profile_uid=$uid");
            exit;

        } else if ($post_action == 'reset_passwd') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=reset_passwd");
            exit;

        } else if ($post_action == 'view_history') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=view_history");
            exit;

        } else if ($post_action == 'user_aliases') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=user_aliases");
            exit;

        } else if ($post_action == 'delete_user') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=delete_user");
            exit;

        } else if ($post_action == 'delete_posts') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=delete_posts");
            exit;

        } else if ($post_action == 'post_count') {

            header_redirect("admin_user.php?webtag=$webtag&uid=$uid&action=post_count");
            exit;

        } else if ($post_action == 'approve_user') {

            if (forum_get_setting('require_user_approval', 'Y')) {

                if (($user_logon = user_get_logon($uid)) !== false) {

                    if (admin_approve_user($uid)) {

                        email_send_user_approved_notification($uid);

                        header_redirect("admin_user.php?webtag=$webtag&uid=$uid&approved=true");
                        exit;

                    } else {

                        $error_msg_array[] = sprintf(gettext("Failed to approve user %s"), $user_logon);
                        $valid = false;
                    }
                }
            }
        }
    }

    header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
    exit;

} else if (isset($_POST['post_count_submit'])) {

    if (isset($_POST['t_reset_post_count']) && $_POST['t_reset_post_count'] == "Y") {

        if (user_reset_post_count($uid)) {

            html_draw_top(
                array(
                    'title' => $page_title,
                    'class' => 'window_title',
                    'main_css' => 'admin.css'
                )
            );

            html_display_msg(gettext("Post Count"), gettext("Successfully Reset Post Count"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
            html_draw_bottom();
            exit;

        } else {

            $error_msg_array[] = gettext("Failed To Reset Post Count");
            $valid = false;
        }

    } else {

        if (isset($_POST['t_post_count']) && is_numeric($_POST['t_post_count'])) {

            $user_post_count = $_POST['t_post_count'];

            if (user_update_post_count($uid, $user_post_count)) {

                html_draw_top(
                    array(
                        'title' => $page_title,
                        'class' => 'window_title',
                        'main_css' => 'admin.css'
                    )
                );

                html_display_msg(gettext("Post Count"), gettext("Successfully Updated Post Count"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
                html_draw_bottom();
                exit;

            } else {

                $error_msg_array[] = gettext("Failed To Change User Post Count");
                $valid = false;
            }
        }
    }

} else if (isset($_POST['user_history_submit'])) {

    if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {
        html_draw_error(gettext("You do not have permission to use this section."), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
    }

    if (isset($_POST['clear_user_history']) && $_POST['clear_user_history'] == "Y") {

        if (admin_clear_user_history($uid)) {

            html_draw_top(
                array(
                    'title' => $page_title,
                    'class' => 'window_title',
                    'main_css' => 'admin.css'
                )
            );

            html_display_msg(gettext("User History"), gettext("Successfully cleared user history"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
            html_draw_bottom();
            exit;

        } else {

            html_draw_error(gettext("Failed to clear user history"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
        }
    }

} else if (isset($_POST['reset_passwd_submit'])) {

    if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {
        html_draw_error(gettext("You do not have permission to use this section."), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
    }

    if (isset($_POST['t_new_password']) && strlen(trim($_POST['t_new_password'])) > 0) {

        $t_new_password = trim($_POST['t_new_password']);

        if (($user_logon = user_get_logon($uid)) !== false) {

            if (admin_reset_user_password($uid, $t_new_password)) {

                email_send_new_pw_notification($uid, $_SESSION['UID'], $t_new_password);

                html_draw_top(
                    array(
                        'title' => $page_title,
                        'class' => 'window_title',
                        'main_css' => 'admin.css'
                    )
                );

                html_display_msg(gettext("Change Password"), gettext("Successfully Changed Password"), 'admin_user.php', 'get', array('back' => gettext("Back")), array(), '_self', 'center');
                html_draw_bottom();
                exit;
            }
        }
        html_draw_error(gettext("Failed To Change Password"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
    }

} else if (isset($_POST['delete_user_confirm'])) {

    if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {
        html_draw_error(gettext("You do not have permission to use this section."), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
    }

    $delete_content = (isset($_POST['delete_content']) && $_POST['delete_content'] == 'Y');

    if (admin_delete_user($uid, $delete_content)) {

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        html_display_msg(gettext("Delete User"), gettext("User Successfully Deleted"), 'admin_users.php', 'get', array('back' => gettext("Back")), array(), '_self', 'center');
        html_draw_bottom();
        exit;

    } else {

        html_draw_error(gettext("Failed To Delete User"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
    }

} else if (isset($_POST['delete_posts_confirm'])) {

    if (($user_logon = user_get_logon($uid)) !== false) {

        if (admin_delete_users_posts($uid)) {

            admin_add_log_entry(DELETE_ALL_USER_POSTS, array($user_logon));

            html_draw_top(
                array(
                    'title' => $page_title,
                    'class' => 'window_title',
                    'main_css' => 'admin.css'
                )
            );

            html_display_msg(gettext("Delete posts"), gettext("Posts were successfully deleted"), 'admin_user.php', 'get', array('back' => gettext("Back")), array(), '_self', 'center');
            html_draw_bottom();
            exit;

        } else {

            html_draw_error(gettext("Failed to delete user's posts"), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid), '_self', 'center');
        }
    }

} else if (isset($_POST['user_perm_submit'])) {

    $valid = true;

    if (forum_check_webtag_available($webtag)) {

        // Local user permissions
        $new_user_perms = (double)0;

        $t_admintools = (double)(isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
        $t_banned = (double)(isset($_POST['t_banned'])) ? $_POST['t_banned'] : 0;
        $t_wormed = (double)(isset($_POST['t_wormed'])) ? $_POST['t_wormed'] : 0;
        $t_pilloried = (double)(isset($_POST['t_pilloried'])) ? $_POST['t_pilloried'] : 0;
        $t_globalmod = (double)(isset($_POST['t_globalmod'])) ? $_POST['t_globalmod'] : 0;
        $t_linksmod = (double)(isset($_POST['t_linksmod'])) ? $_POST['t_linksmod'] : 0;
        $t_ignoreadmin = (double)(isset($_POST['t_ignoreadmin'])) ? $_POST['t_ignoreadmin'] : 0;

        $new_user_perms = (double)$t_admintools | $t_banned | $t_wormed | $t_pilloried | $t_globalmod | $t_linksmod | $t_ignoreadmin;

        if ($user_perms <> $new_user_perms) {

            if (perm_update_user_permissions($uid, $new_user_perms)) {

                admin_add_log_entry(USER_PERMS_CHANGED, array($user['LOGON']));

                $user_perms = perm_get_forum_user_permissions($uid);

            } else {

                $error_msg_array[] = gettext("Failed to update user status");
                $valid = false;
            }
        }
    }

    // Global user permissions
    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        $new_global_user_perms = (double)0;

        $global_user_perm = perm_get_global_user_permissions($uid);

        $admin_tools_perm_count = perm_get_admin_tools_perm_count();
        $forum_tools_perm_count = perm_get_forum_tools_perm_count();

        $t_all_admin_tools = (double)(isset($_POST['t_all_admin_tools'])) ? $_POST['t_all_admin_tools'] : 0;
        $t_all_forum_tools = (double)(isset($_POST['t_all_forum_tools'])) ? $_POST['t_all_forum_tools'] : 0;
        $t_all_folder_mod = (double)(isset($_POST['t_all_folder_mod'])) ? $_POST['t_all_folder_mod'] : 0;
        $t_all_links_mod = (double)(isset($_POST['t_all_links_mod'])) ? $_POST['t_all_links_mod'] : 0;
        $t_all_banned = (double)(isset($_POST['t_all_banned'])) ? $_POST['t_all_banned'] : 0;

        if (isset($_POST['t_confirm_email']) && $_POST['t_confirm_email'] != 'cancel') {
            $t_confirm_email = (double)USER_PERM_EMAIL_CONFIRM;
        } else {
            $t_confirm_email = (double)0;
        }

        $new_global_user_perms = (double)$t_all_admin_tools | $t_all_forum_tools | $t_all_folder_mod | $t_all_links_mod | $t_all_banned | $t_confirm_email;

        if (perm_has_forumtools_access($uid) && $forum_tools_perm_count == 1) {

            if (!($new_global_user_perms & USER_PERM_FORUM_TOOLS)) {

                $error_msg_array[] = gettext("There must be at least 1 user with admin tools and forum tools access on all forums!");
                $valid = false;
            }
        }

        if (perm_has_global_admin_access($uid) && $admin_tools_perm_count == 1) {

            if (!($new_global_user_perms & USER_PERM_ADMIN_TOOLS)) {

                $error_msg_array[] = gettext("There must be at least 1 user with admin tools and forum tools access on all forums!");
                $valid = false;
            }
        }

        if ($valid && ($new_global_user_perms <> $global_user_perm)) {

            if (perm_update_user_global_perms($uid, $new_global_user_perms)) {

                $global_user_perm = perm_get_global_user_permissions($uid);

            } else {

                $error_msg_array[] = gettext("Failed to update global user permissions");
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

                $t_post_read = (double)(isset($_POST['t_post_read'][$fid])) ? $_POST['t_post_read'][$fid] : 0;
                $t_post_create = (double)(isset($_POST['t_post_create'][$fid])) ? $_POST['t_post_create'][$fid] : 0;
                $t_thread_create = (double)(isset($_POST['t_thread_create'][$fid])) ? $_POST['t_thread_create'][$fid] : 0;
                $t_post_edit = (double)(isset($_POST['t_post_edit'][$fid])) ? $_POST['t_post_edit'][$fid] : 0;
                $t_post_delete = (double)(isset($_POST['t_post_delete'][$fid])) ? $_POST['t_post_delete'][$fid] : 0;
                $t_post_attach = (double)(isset($_POST['t_post_attach'][$fid])) ? $_POST['t_post_attach'][$fid] : 0;
                $t_moderator = (double)(isset($_POST['t_moderator'][$fid])) ? $_POST['t_moderator'][$fid] : 0;
                $t_post_html = (double)(isset($_POST['t_post_html'][$fid])) ? $_POST['t_post_html'][$fid] : 0;
                $t_post_sig = (double)(isset($_POST['t_post_sig'][$fid])) ? $_POST['t_post_sig'][$fid] : 0;
                $t_post_approval = (double)(isset($_POST['t_post_approval'][$fid])) ? $_POST['t_post_approval'][$fid] : 0;

                $new_user_perms = (double)$t_post_read | $t_post_create | $t_thread_create;
                $new_user_perms = (double)$new_user_perms | $t_post_edit | $t_post_delete;
                $new_user_perms = (double)$new_user_perms | $t_moderator | $t_post_attach;
                $new_user_perms = (double)$new_user_perms | $t_post_html | $t_post_sig | $t_post_approval;

                if ($new_user_perms <> $folder_array[$fid]['STATUS']) {

                    if (!perm_update_user_folder_perms($uid, $fid, $new_user_perms)) {

                        $error_msg_array[] = gettext("Failed to update folder access settings");
                        $valid = false;
                    }
                }
            }

            if ($valid) {

                admin_add_log_entry(USER_FOLDER_PERMS_CHANGED, array($user['LOGON']));
            }
        }

        // Confirmation email
        if (isset($_POST['t_confirm_email']) && $_POST['t_confirm_email'] == 'resend') {

            if (!email_send_user_confirmation($uid)) {

                $error_msg_array[] = gettext("Failed to resend Email confirmation to user.");
                $valid = false;
            }
        }
    }

    if ($valid) {
        $success_html = gettext("Updates saved successfully");
    }

} else if (isset($_POST['remove_group']) && is_array($_POST['remove_group'])) {

    $group_ids = array_filter(array_keys($_POST['remove_group']), 'is_numeric');

    if (sizeof($group_ids) > 0) {

        foreach ($group_ids as $gid) {
            perm_remove_user_from_group($uid, $gid);
        }

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid&group_removed=true");
        exit;
    }

} else if (isset($_POST['add_group']) && is_numeric($_POST['add_group'])) {

    if (perm_add_user_to_group($uid, $_POST['add_group'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid&group_added=true");
        exit;
    }
}

if (isset($_GET['action']) && strlen(trim($_GET['action'])) > 0) {
    $action = trim($_GET['action']);
} else if (isset($_POST['action']) && strlen(trim($_POST['action'])) > 0) {
    $action = trim($_POST['action']);
}

if (isset($action) && strlen(trim($action)) > 0) {

    if ($action == 'reset_passwd') {

        if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {
            html_draw_error(gettext("You do not have permission to use this section."), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid));
        }

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";

        html_display_warning_msg(gettext("If this user has forgotten their password you can reset it for them here."), '800', 'center');

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">", gettext("Reset Password"), "</td>\n";
        echo "                </tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"200\">", gettext("Reset password to"), ":</td>\n";
        echo "                        <td align=\"left\">", form_input_password("t_new_password", null, 32, null, "autocomplete=\"off\""), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("reset_passwd_submit", gettext("Save")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    } else if ($action == 'view_history') {

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        $user_history_array = admin_get_user_history($user['UID']);

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), html_style_image('separator'), gettext("User History"), "</h1>\n";

        if (is_array($user_history_array) && sizeof($user_history_array) < 1) {
            html_display_warning_msg(gettext("No History Records Saved"), '800', 'center');
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";

        if (is_array($user_history_array) && sizeof($user_history_array) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" width=\"100\">", gettext("Date"), "</td>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", gettext("Changes"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"2\">\n";
            echo "                    <div class=\"admin_folder_perms\">\n";

            foreach ($user_history_array as $history_index => $user_history) {

                echo "                      <table class=\"posthead\" width=\"100%\">\n";
                echo "                        <tr>\n";
                echo "                          <td align=\"left\" valign=\"top\" width=\"100\">", format_date_time($user_history['MODIFIED']), "</td>\n";
                echo "                          <td align=\"left\">{$user_history['DATA']}</td>\n";
                echo "                        </tr>\n";
                echo "                        <tr>\n";
                echo "                          <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                echo "                        </tr>\n";
                echo "                      </table>\n";
            }

            echo "                    </div>\n";
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

            if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"left\">\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td class=\"subhead\" align=\"left\">", gettext("Clear User History"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", gettext("Clear User History"), ":</td>\n";
                echo "                        <td align=\"left\">", form_radio('clear_user_history', 'Y', gettext("Yes")), form_radio('clear_user_history', 'N', gettext("No"), true), "</td>\n";
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
                echo "      <td align=\"center\">", form_submit("user_history_submit", gettext("Update")), "&nbsp;", form_submit("cancel", gettext("Back")), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";
                echo "  <br />\n";

            } else {

                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_submit("cancel", gettext("Back")), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";
            }

        } else {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"center\">", form_submit("cancel", gettext("Back")), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
        }

        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    } else if ($action == 'user_aliases') {

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        $user_alias_view = USER_ALIAS_IPADDRESS;

        $user_alias_array = array();

        $user_alias_view_types_array = array(
            USER_ALIAS_IPADDRESS => gettext("IP Address Matches"),
            USER_ALIAS_EMAIL => gettext("Email Address Matches"),
            USER_ALIAS_PASSWD => gettext("Password Matches"),
            USER_ALIAS_REFERER => gettext("HTTP Referer Matches")
        );

        $user_alias_column_header = array(
            USER_ALIAS_IPADDRESS => gettext("IP"),
            USER_ALIAS_EMAIL => gettext("Email"),
            USER_ALIAS_PASSWD => gettext("Password"),
            USER_ALIAS_REFERER => gettext("Referer")
        );

        if (isset($_POST['user_alias_view']) && in_array($_POST['user_alias_view'], array_keys($user_alias_view_types_array))) {
            $user_alias_view = $_POST['user_alias_view'];
        }

        if ($user_alias_view == USER_ALIAS_IPADDRESS) {

            $user_alias_array = admin_get_user_ip_matches($user['UID']);

        } else if ($user_alias_view == USER_ALIAS_EMAIL) {

            $user_alias_array = admin_get_user_email_matches($user['UID']);

        } else if ($user_alias_view == USER_ALIAS_PASSWD) {

            $user_alias_array = admin_get_user_passwd_matches($user['UID']);

        } else if ($user_alias_view == USER_ALIAS_REFERER) {

            $user_alias_array = admin_get_user_referer_matches($user['UID']);
        }

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), html_style_image('separator'), gettext("Possible Aliases"), "</h1>\n";

        if (is_array($user_alias_array) && sizeof($user_alias_array) < 1) {
            html_display_warning_msg(gettext("Search Returned No Results"), '700', 'center');
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">", gettext("Logon"), "</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">", gettext("Nickname"), "</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$user_alias_column_header[$user_alias_view]}</td>\n";
        echo "                </tr>\n";

        if (is_array($user_alias_array) && sizeof($user_alias_array) > 0) {

            foreach ($user_alias_array as $user_alias) {

                echo "                <tr>\n";
                echo "                  <td align=\"left\" width=\"20\">&nbsp;</td>\n";
                echo "                  <td align=\"left\" width=\"200\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$user_alias['UID']}\">", word_filter_add_ob_tags($user_alias['LOGON'], true), "</a></td>\n";
                echo "                  <td align=\"left\" width=\"200\">", word_filter_add_ob_tags($user_alias['NICKNAME'], true), "</td>\n";

                if ($user_alias_view == USER_ALIAS_IPADDRESS) {

                    if (ip_is_banned($user_alias['IPADDRESS'])) {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user_alias['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['IPADDRESS']}</a>&nbsp;(", gettext("Banned"), ")&nbsp;</td>\n";

                    } else {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user_alias['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['IPADDRESS']}</a>&nbsp;</td>\n";
                    }

                } else if ($user_alias_view == USER_ALIAS_EMAIL) {

                    if (email_is_banned($user_alias['EMAIL'])) {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_email={$user_alias['EMAIL']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\">", html_style_image('link', gettext("External Link")), "</a>&nbsp;(", gettext("Banned"), ")&nbsp;</td>\n";

                    } else {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_email={$user_alias['EMAIL']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\">", html_style_image('link', gettext("External Link")), "</a>&nbsp;</td>\n";
                    }

                } else if ($user_alias_view == USER_ALIAS_PASSWD) {

                    echo "                  <td align=\"left\">", gettext("Yes"), "</td>\n";

                } else if ($user_alias_view == USER_ALIAS_REFERER) {

                    $user_alias['REFERER_FULL'] = $user_alias['REFERER'];

                    if (!$user_alias['REFERER'] = split_url($user_alias['REFERER'])) {

                        if (mb_strlen($user_alias['REFERER_FULL']) > 25) {

                            $user_alias['REFERER'] = mb_substr($user_alias['REFERER_FULL'], 0, 25);
                            $user_alias['REFERER'] .= "&hellip;";
                        }
                    }

                    if (referer_is_banned($user_alias['REFERER'])) {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user_alias['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['REFERER']}</a>&nbsp;<a href=\"{$user_alias['REFERER_FULL']}\">", html_style_image('link', gettext("External Link")), "</a>&nbsp;(", gettext("Banned"), ")&nbsp;</td>\n";

                    } else {

                        echo "                  <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user_alias['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user_alias['REFERER']}</a>&nbsp;<a href=\"{$user_alias['REFERER_FULL']}\">", html_style_image('link', gettext("External Link")), "</a>&nbsp;</td>\n";
                    }
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
        echo "                  <td class=\"subhead\" align=\"left\">", gettext("Options"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"75\">", gettext("View"), ":</td>\n";
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
        echo "      <td align=\"center\">", form_submit("user_alias_submit", gettext("Update")), "&nbsp;", form_submit("cancel", gettext("Back")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    } else if ($action == 'delete_user') {

        if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {
            html_draw_error(gettext("You do not have permission to use this section."), 'admin_user.php', 'get', array('back' => gettext("Back")), array('uid' => $uid));
        }

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
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
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", gettext("Are you sure you want to delete the selected user account? Once the account has been deleted it cannot be retrieved and will be lost forever."), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox('delete_content', 'Y', gettext("Also delete all of the content created by this user")), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("delete_user_confirm", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    } else if ($action == 'delete_posts') {

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
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
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", gettext("Are you sure you want to delete all of the selected user's posts? Once the posts are deleted they cannot be retrieved and will be lost forever."), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("delete_posts_confirm", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;

    } else if ($action == 'post_count') {

        html_draw_top(
            array(
                'title' => $page_title,
                'class' => 'window_title',
                'main_css' => 'admin.css'
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
        echo "  ", form_csrf_token_field(), "\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
        echo "  ", form_input_hidden("action", htmlentities_array($action)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array("admin_user.php?webtag=$webtag&uid=$uid")), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Post Count"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"200\">", gettext("Post Count"), ":</td>\n";
        echo "                        <td align=\"left\">", form_input_text("t_post_count", (isset($_POST['t_post_count'])) ? htmlentities_array($_POST['t_post_count']) : htmlentities_array($user['POST_COUNT']), 10), "&nbsp;", form_checkbox("t_reset_post_count", "Y", gettext("Reset Post Count")), "</td>\n";
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
        echo "      <td align=\"center\">", form_submit("post_count_submit", gettext("Confirm")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }
}

html_draw_top(
    array(
        'title' => $page_title,
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '800', 'center');

} else if (isset($success_html) && strlen(trim($success_html)) > 0) {

    html_display_success_msg($success_html, '800', 'center');

} else if (isset($_GET['profile_updated'])) {

    html_display_success_msg(gettext("Profile updated."), '800', 'center');

} else if (isset($_GET['signature_updated'])) {

    html_display_success_msg(gettext("Signature Updated"), '800', 'center');

} else if (isset($_GET['approved'])) {

    html_display_success_msg(gettext("Successfully approved user"), '800', 'center');

} else if (isset($_GET['group_removed'])) {

    html_display_success_msg(gettext("Successfully removed user from group"), '800', 'center');

} else if (isset($_GET['group_added'])) {

    html_display_success_msg(gettext("Successfully added user to group"), '800', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("User Details"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Username"), ":</td>\n";
    echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" class=\"popup 650x500\">", htmlentities_array($user['LOGON']), "</a></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\">", gettext("Nickname"), ":</td>\n";
    echo "                        <td align=\"left\">", htmlentities_array($user['NICKNAME']), "</td>\n";
    echo "                      </tr>\n";

    if (email_address_valid($user['EMAIL'])) {

        if (email_is_banned($user['EMAIL'])) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"200\">", gettext("Email address"), ":</td>\n";
            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_email=", rawurlencode($user['EMAIL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['EMAIL']}\">{$user['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\">", html_style_image('link', gettext("External Link")), "</a> (", gettext("Banned"), ")</td>\n";
            echo "                      </tr>\n";

        } else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"200\">", gettext("Email address"), ":</td>\n";
            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_email=", rawurlencode($user['EMAIL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['EMAIL']}\">{$user['EMAIL']}</a>&nbsp;<a href=\"mailto:{$user['EMAIL']}\">", html_style_image('link', gettext("External Link")), "</a></td>\n";
            echo "                      </tr>\n";
        }

    } else {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"200\">", gettext("Email address"), ":</td>\n";
        echo "                        <td align=\"left\">{$user['EMAIL']}</td>\n";
        echo "                      </tr>\n";
    }

    if (forum_check_webtag_available($webtag)) {

        if (isset($user['REFERER']) && strlen(trim($user['REFERER'])) > 0) {

            $user['REFERER_FULL'] = $user['REFERER'];

            if (!$user['REFERER'] = split_url($user['REFERER'])) {

                if (mb_strlen($user['REFERER_FULL']) > 25) {

                    $user['REFERER'] = mb_substr($user['REFERER_FULL'], 0, 25);
                    $user['REFERER'] .= "&hellip;";
                }
            }

            if (referer_is_banned($user['REFERER'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"200\">", gettext("Sign-up Referer:"), "</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\" target=\"_blank\">", html_style_image('link', gettext("External Link")), "</a> (", gettext("Banned"), ")</td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"200\">", gettext("Sign-up Referer:"), "</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\" target=\"_blank\">", html_style_image('link', gettext("External Link")), "</a></td>\n";
                echo "                      </tr>\n";
            }

        } else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"200\">", gettext("Sign-up Referer:"), "</td>\n";
            echo "                        <td align=\"left\">", gettext("Unknown"), "</td>\n";
            echo "                      </tr>\n";
        }

        if (isset($user['SESSION_REFERER']) && strlen(trim($user['SESSION_REFERER'])) > 0) {

            $user['SESSION_REFERER_FULL'] = $user['SESSION_REFERER'];

            if (!$user['SESSION_REFERER'] = split_url($user['SESSION_REFERER'])) {

                if (mb_strlen($user['SESSION_REFERER_FULL']) > 25) {

                    $user['SESSION_REFERER'] = mb_substr($user['SESSION_REFERER_FULL'], 0, 25);
                    $user['SESSION_REFERER'] .= "&hellip;";
                }
            }

            if (referer_is_banned($user['SESSION_REFERER'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"200\">", gettext("Session Referer"), "</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user['SESSION_REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['SESSION_REFERER_FULL']}\">{$user['SESSION_REFERER']}</a>&nbsp;<a href=\"{$user['SESSION_REFERER_FULL']}\" target=\"_blank\">", html_style_image('link', gettext("External Link")), "</a> (", gettext("Banned"), ")</td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"200\">", gettext("Session Referer"), "</td>\n";
                echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user['SESSION_REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['SESSION_REFERER_FULL']}\">{$user['SESSION_REFERER']}</a>&nbsp;<a href=\"{$user['SESSION_REFERER_FULL']}\" target=\"_blank\">", html_style_image('link', gettext("External Link")), "</a></td>\n";
                echo "                      </tr>\n";
            }

        } else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"200\">", gettext("Session Referer"), "</td>\n";
            echo "                        <td align=\"left\">", gettext("Unknown"), "</td>\n";
            echo "                      </tr>\n";
        }

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"200\">", gettext("Last IP Address"), ":</td>\n";

        if (ip_is_banned($user['IPADDRESS'])) {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user['IPADDRESS']}</a> (", gettext("Banned"), ")</td>\n";

        } else if (strlen(trim($user['IPADDRESS'])) > 0) {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$user['IPADDRESS']}</a></td>\n";

        } else {

            echo "                        <td align=\"left\">", gettext("Unknown"), "</td>\n";
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

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

        if (forum_check_webtag_available($webtag)) {

            $admin_options_dropdown = array(
                'edit_details' => gettext("Edit User Details"),
                'edit_signature' => gettext("Edit Signature"),
                'edit_profile' => gettext("Edit Profile"),
                'reset_passwd' => gettext("Reset Password"),
                'view_history' => gettext("View User History"),
                'user_aliases' => gettext("View User Aliases"),
                'post_count' => gettext("Change Post Count"),
                'delete_user' => gettext("Delete User"),
                'delete_posts' => gettext("Delete posts")
            );

        } else {

            $admin_options_dropdown = array(
                'reset_passwd' => gettext("Reset Password"),
                'view_history' => gettext("View User History"),
                'user_aliases' => gettext("View User Aliases"),
                'delete_user' => gettext("Delete User")
            );
        }

    } else {

        if (forum_check_webtag_available($webtag)) {

            $admin_options_dropdown = array(
                'edit_details' => gettext("Edit User Details"),
                'edit_signature' => gettext("Edit Signature"),
                'edit_profile' => gettext("Edit Profile"),
                'post_count' => gettext("Change Post Count"),
                'view_history' => gettext("View User History"),
                'user_aliases' => gettext("View User Aliases"),
                'delete_posts' => gettext("Delete posts")
            );

        } else {

            $admin_options_dropdown = array(
                'view_history' => gettext("View User History"),
                'user_aliases' => gettext("View User Aliases"),
                'delete_posts' => gettext("Delete posts")
            );
        }
    }

    if (forum_get_setting('require_user_approval', 'Y') && !admin_user_approved($uid)) {
        $admin_options_dropdown = array_merge(array('approve_user' => gettext("Approve User")), $admin_options_dropdown);
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("More Admin Options"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">", form_dropdown_array('action', $admin_options_dropdown, null, null, 'admin_options_dropdown'), "&nbsp;", form_submit('action_submit', gettext("Go!")), "</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", sprintf(gettext("User Status for %s"), forum_get_setting('forum_name', 'strlen', 'A Beehive Forum')), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, gettext("User has access to forum admin tools"), $user_perms & USER_PERM_ADMIN_TOOLS), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, gettext("User can moderate all folders"), $user_perms & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, gettext("User can moderate Links section"), $user_perms & USER_PERM_LINKS_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_banned", USER_PERM_BANNED, gettext("User is banned"), $user_perms & USER_PERM_BANNED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_wormed", USER_PERM_WORMED, gettext("User is wormed"), $user_perms & USER_PERM_WORMED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_pilloried", USER_PERM_PILLORIED, gettext("User is pilloried"), $user_perms & USER_PERM_PILLORIED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_ignoreadmin", USER_PERM_CAN_IGNORE_ADMIN, gettext("User can ignore administrators"), $user_perms & USER_PERM_CAN_IGNORE_ADMIN), "</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>";

    html_display_warning_msg(gettext("Note: This user may be inheriting additional permissions from any user groups listed below."), '95%', 'center');

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

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

    $global_user_perm = perm_get_global_user_permissions($uid);

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Global user permissions"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_admin_tools", USER_PERM_ADMIN_TOOLS, gettext("User has access to admin tools <b>on all forums</b>"), $global_user_perm & USER_PERM_ADMIN_TOOLS), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_forum_tools", USER_PERM_FORUM_TOOLS, gettext("User can access forum tools and can create, delete and edit forums"), $global_user_perm & USER_PERM_FORUM_TOOLS), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_folder_mod", USER_PERM_FOLDER_MODERATE, gettext("User can moderate <b>all folders</b> on <b>all forums</b>"), $global_user_perm & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_links_mod", USER_PERM_LINKS_MODERATE, gettext("User can moderate links section on <b>all forums</b>"), $global_user_perm & USER_PERM_LINKS_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_all_banned", USER_PERM_BANNED, gettext("User is banned from <b>all forums</b>"), $global_user_perm & USER_PERM_BANNED), "</td>\n";
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

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Email confirmation required"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "cancel", gettext("Cancel email confirmation and allow user to start posting")), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "resend", gettext("Resend confirmation email to user")), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_radio("t_confirm_email", "nothing", gettext("Do nothing"), true), "</td>\n";
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

    if (($folder_array = perm_user_get_folders($uid)) !== false) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">", gettext("Folder Access"), "</td>\n";
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
        echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">", gettext("Folders"), "</td>\n";
        echo "                              <td align=\"left\" class=\"subhead\">", gettext("Permissions"), "</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"2\">\n";
        echo "                                <div class=\"admin_folder_perms\">\n";

        foreach ($folder_array as $fid => $folder) {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", htmlentities_array($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"150\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags($folder['TITLE'], true), "</a></td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, gettext("Read Posts"), $folder['STATUS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, gettext("Reply to threads"), $folder['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, gettext("Create new threads"), $folder['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, gettext("Edit posts"), $folder['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, gettext("Delete posts"), $folder['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, gettext("Upload attachments"), $folder['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, gettext("Post in HTML"), $folder['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, gettext("Post a signature"), $folder['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, gettext("Moderate folder"), $folder['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, gettext("Require Post Approval"), $folder['STATUS'] & USER_PERM_POST_APPROVAL), "</td>\n";
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

        html_display_warning_msg(gettext("Note: This user may be inheriting additional permissions from any user groups listed below."), '95%', 'center');

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

    if (($user_groups_array = perm_user_get_groups($uid)) !== false) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"15\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("User Groups"), "</td>\n";
        echo "                </tr>\n";

        foreach ($user_groups_array as $user_group) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" width=\"15\">&nbsp;</td>\n";
            echo "                  <td align=\"left\" valign=\"top\">&nbsp;<a href=\"admin_user_groups_edit.php?webtag=$webtag&amp;gid={$user_group['GID']}&amp;ret=admin_user.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";
            echo "                  <td valign=\"top\" align=\"right\" width=\"220\">", form_submit("remove_group[{$user_group['GID']}]", gettext("Remove user from group")), "&nbsp;</td>\n";
            echo "                </tr>\n";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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

    if (($groups_array = perm_get_user_group_names()) !== false) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Add User to group"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\">", gettext("Add user to group"), ":&nbsp;", form_dropdown_array('add_group', $groups_array, null, null, 'admin_options_dropdown'), "&nbsp;", form_submit('add_group_submit', gettext("Add")), "</td>\n";
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
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("user_perm_submit", gettext("Save")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();