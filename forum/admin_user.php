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

/* $Id: admin_user.php,v 1.175 2006-11-19 00:13:21 decoyduck Exp $ */

/**
* Displays and handles the Manage Users and Manage User: [User] pages
*
* Generates the forms relating to user management (kicking and permissions, etc), and handles their sumbission.
*/

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
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
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

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "./messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_POST['ret'])) {
    $ret = $_POST['ret'];
}else {
    $ret = "./admin_users.php?webtag=$webtag";
}

if (isset($_POST['cancel'])) {
    header_redirect($ret);
}

if (isset($_POST['edit_users']) && is_array($_POST['edit_users'])) {

    list($gid) = array_keys($_POST['edit_users']);
    header_redirect("./admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid");
}

html_draw_top('admin.js', 'attachments.js');

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
}else if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
    $uid = $_POST['uid'];
}else {
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['nouserspecified']}</h2>\n";
    html_draw_bottom();
    exit;
}

$user = user_get($uid);
$user['POST_COUNT'] = user_get_post_count($uid);

$user_perms = perm_get_forum_user_permissions($uid);

// Do updates

if (isset($_POST['delete_confirm'])) {
    
    if (isset($_POST['delete_attachment_confirm']) && is_array($_POST['delete_attachment_confirm'])) {
        
        foreach($_POST['delete_attachment_confirm'] as $hash => $del_attachment) {

            if ($del_attachment == "Y") {
    
                delete_attachment($hash);
            }
        }
    }

}elseif (isset($_POST['delete'])) {

    if (isset($_POST['delete_attachment']) && is_array($_POST['delete_attachment'])) {

        $hash_array = array_keys($_POST['delete_attachment']);

        if (admin_get_users_attachments($uid, $attachments_array, $image_attachments_array, $hash_array)) {
            
            html_draw_top();
            echo "<h1>{$lang['admin']} &raquo; ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " &raquo; {$lang['manageusers']} &raquo; ", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), " &raquo; {$lang['deleteattachments']}</h1>\n";

            echo "<br />\n";
            echo "<div align=\"center\">\n";
            echo "<form id=\"attachments\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin_user.php?uid=$uid\">\n";
            echo "  ", form_input_hidden('webtag', $webtag), "\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['deleteattachments']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">{$lang['deleteattachmentsconfirm']}</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"center\">\n";
            echo "                          <table class=\"posthead\" width=\"95%\">\n";
            echo "                            <tr>\n";
            echo "                              <td><br />\n";

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {
                
                foreach($attachments_array as $attachment) {

                    echo "                                ", attachment_make_link($attachment, false, false), "\n";
                    echo "                                ", form_input_hidden("delete_attachment_confirm[{$attachment['hash']}]", "Y"), "\n";
                }
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                foreach($image_attachments_array as $key => $attachment) {

                    echo "                                ", attachment_make_link($attachment, false, false), "\n";
                    echo "                                ", form_input_hidden("delete_attachment_confirm[{$attachment['hash']}]", "Y"), "\n";
                }
            }

            echo "                              </td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
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
            echo "      <td align=\"center\">", form_submit("delete_confirm", $lang['confirm']), "&nbsp;", form_submit("cancel_delete", $lang['cancel']), "</td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "</form>\n";
            echo "</div>\n";

            html_draw_bottom();
            exit;
        }
    }
}

echo "<h1>{$lang['admin']} &raquo; ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " &raquo; {$lang['manageusers']} &raquo; ", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</h1>\n";

if (isset($_POST['t_confirm_delete_posts'])) {

    if ($user_post_array = get_user_posts($uid)) {

        foreach ($user_post_array as $user_post) {
            post_delete($user_post['TID'], $user_post['PID']);
        }

        $user_logon = user_get_logon($uid);
        admin_add_log_entry(DELETE_ALL_USER_POSTS, $user_logon);
    }
}

if (isset($_POST['submit']) && (!isset($_POST['t_delete_posts']) || $_POST['t_delete_posts'] != "Y")) {

    $valid = true;

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        if (isset($_POST['t_nickname']) && strlen(trim(_stripslashes($_POST['t_nickname']))) > 0) {

            $user_details['NICKNAME'] = trim(_stripslashes($_POST['t_nickname']));

            if (nickname_is_banned($user_details['NICKNAME'])) {

                $error_html.= "<h2>{$lang['nicknamenotpermitted']}</h2>\n";
                $valid = false;

            } else {

                user_update_nickname($uid, $user_details['NICKNAME']);

            }

        }else {

            $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
            $valid = false;
        }

        if (isset($_POST['t_post_count']) && is_numeric($_POST['t_post_count'])) {

            $user_details['POST_COUNT'] = $_POST['t_post_count'] > 0 ? $_POST['t_post_count'] : 0;

            if ($user_details['POST_COUNT'] != $user['POST_COUNT']) {

                user_update_post_count($uid, $user_details['POST_COUNT']);
            }
        }

        if (isset($_POST['t_reset_post_count']) && $_POST['t_reset_post_count'] == "Y") {

            user_reset_post_count($uid);
            $user['POST_COUNT'] = user_get_post_count($uid);
            if (isset($_POST['t_post_count'])) unset($_POST['t_post_count']);
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

    perm_update_user_permissions($uid, $new_user_perms);

    $user_perms = perm_get_forum_user_permissions($uid);

    // Global user permissions

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $new_global_user_perms = (double) 0;

        $forum_tools_perm_count = perm_get_admin_tools_perm_count();
        $admin_tools_perm_count = perm_get_forum_tools_perm_count();

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

                 $valid = false;
                 echo "<h2>{$lang['adminforumtoolsusercounterror']}</h2>\n";
            }
        }

        if ($valid && perm_has_global_admin_access($uid) && $admin_tools_perm_count == 1) {

            if (!($new_global_user_perms & USER_PERM_ADMIN_TOOLS)) {

                $valid = false;
                echo "<h2>{$lang['adminforumtoolsusercounterror']}</h2>\n";
            }
        }

        if ($valid) {
            perm_update_global_perms($uid, $new_global_user_perms);
        }
    }

    // Local folder permissions

    if (isset($_POST['t_update_perms_array']) && is_array($_POST['t_update_perms_array'])) {

        $t_update_perms_array = $_POST['t_update_perms_array'];

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

            $new_folder_perms = (double) $t_post_read | $t_post_create | $t_thread_create;
            $new_folder_perms = (double) $new_folder_perms | $t_post_edit | $t_post_delete;
            $new_folder_perms = (double) $new_folder_perms | $t_moderator | $t_post_attach;
            $new_folder_perms = (double) $new_folder_perms | $t_post_html | $t_post_sig | $t_post_approval;

            perm_update_user_folder_perms($uid, $fid, $new_folder_perms);
        }
    }

    // Confirmation email

    if (isset($_POST['t_confirm_email']) && $_POST['t_confirm_email'] == 'resend') {
        email_send_user_confirmation($uid);
    }

    // Password reset

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        if (isset($_POST['t_reset_password']) && $_POST['t_reset_password'] == 'Y') {
            $t_reset_password = true;
        }else {
            $t_reset_password = false;
        }

        if (isset($_POST['t_new_password']) && strlen(trim(_stripslashes($_POST['t_new_password']))) > 0) {
            $t_new_password = trim(_stripslashes($_POST['t_new_password']));
        }else {
            $t_new_password = false;
        }

        if ($t_reset_password === true && strlen($t_new_password) > 0) {

            $fuid = bh_session_get_value('UID');

            user_change_password($uid, $t_new_password, false);

            email_send_new_pw_notification($uid, $fuid, $t_new_password);

            $user_logon = user_get_logon($uid);
            admin_add_log_entry(CHANGE_USER_PASSWD, $user_logon);

        }else {

            $user_logon = user_get_logon($uid);
            admin_add_log_entry(CHANGE_USER_STATUS, $user_logon);
        }
    }

    if ($valid) {
        echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";
    }
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("uid", $uid), "\n";

if (isset($_POST['t_delete_posts']) && $_POST['t_delete_posts'] == "Y") {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
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
    echo "      <td align=\"center\">", form_submit("t_confirm_delete_posts", $lang['confirm']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag=$webtag&amp;uid=$uid"), "\n";

}else if (isset($_POST['t_confirm_delete_posts'])) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['deleteposts']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['postssuccessfullydeleted']}</td>\n";
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
    echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag=$webtag&amp;uid=$uid"), "\n";

}else {

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
        echo "                        <td align=\"left\" width=\"150\">{$lang['nicknameheader']}</td>\n";
        echo "                        <td align=\"left\">", form_input_text("t_nickname", (isset($_POST['t_nickname'])) ? $_POST['t_nickname'] : $user['NICKNAME'], 32), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['postcount']}</td>\n";
        echo "                        <td align=\"left\">", form_input_text("t_post_count", (isset($_POST['t_post_count'])) ? $_POST['t_post_count'] : $user['POST_COUNT'], 10), "&nbsp;", form_checkbox("t_reset_post_count", "Y", $lang['resetpostcount'], false), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['signupreferer']}</td>\n";
        echo "                        <td align=\"left\">", (isset($user['REFERER']) && strlen($user['REFERER']) > 0) ? $user['REFERER'] : $lang['unknown'], "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['lastipaddress']}:</td>\n";

        if (ip_is_banned($user['IPADDRESS'])) {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user['IPADDRESS']}&amp;ret=admin_user.php%3Fuid%3D$uid\" target=\"_self\">{$user['IPADDRESS']} ({$lang['banned']})</a></td>\n";

        }else {

            echo "                        <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user['IPADDRESS']}&amp;ret=admin_user.php%3Fuid%3D$uid\" target=\"_self\">{$user['IPADDRESS']}</a></td>\n";
        }

        echo "                        \n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">", form_button("editsignature", $lang['editsignature'], "onclick=\"document.location.href='edit_signature.php?webtag=$webtag&amp;siguid=$uid'\""), "&nbsp;", form_button("editprofile", $lang['editprofile'], "onclick=\"document.location.href='edit_profile.php?webtag=$webtag&amp;profileuid=$uid'\""), "</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['userstatus']}</td>\n";
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

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $global_user_perm = perm_get_global_user_permissions($uid);

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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

    if ($folder_array = perm_user_get_folders($uid)) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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

        foreach($folder_array as $fid => $folder) {

            if ($folder['STATUS'] > 0) {

                echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
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

            }else {

                echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], false), "</td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], false), "</td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], false), "</td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], false), "</td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], false), "</td>\n";
                echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
                echo "                                    </tr>\n";
                echo "                                  </table>\n";
            }
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
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"95%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['usergroupwarning']}</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['usergroups']}</td>\n";
    echo "                </tr>\n";

    if ($user_groups_array = perm_user_get_groups($uid)) {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['useringroups']}:</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">\n";
        echo "                          <table class=\"box\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" class=\"posthead\">\n";
        echo "                                <table class=\"posthead\" width=\"100%\">\n";
        echo "                                  <tr>\n";
        echo "                                    <td align=\"left\" class=\"subhead\">{$lang['groups']}</td>\n";
        echo "                                    <td align=\"left\" class=\"subhead\">{$lang['users']}</td>\n";
        echo "                                    <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
        echo "                                  </tr>\n";

        foreach ($user_groups_array as $user_group) {

            echo "                                  <tr>\n";
            echo "                                    <td align=\"left\" valign=\"top\"><a href=\"admin_user_groups_edit.php?gid={$user_group['GID']}\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";
            echo "                                    <td valign=\"top\" align=\"center\">{$user_group['USER_COUNT']}</td>\n";
            echo "                                    <td valign=\"top\" align=\"right\">", form_submit("edit_users[{$user_group['GID']}]", $lang['addremoveusers']), "&nbsp;</td>\n";
            echo "                                  </tr>\n";
        }

        echo "                                  <tr>\n";
        echo "                                    <td align=\"left\">&nbsp;</td>\n";
        echo "                                    <td align=\"left\">&nbsp;</td>\n";
        echo "                                    <td align=\"left\">&nbsp;</td>\n";
        echo "                                  </tr>\n";
        echo "                                </table>\n";
        echo "                              </td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
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
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}</td>\n";
    echo "                </tr>\n";

    if ($user_alias_array = user_get_aliases($user['UID'])) {

        if (sizeof($user_alias_array) > 0) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table width=\"90%\" class=\"posthead\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">{$lang['aliasdesc']}</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"box\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">{$lang['logon']}</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">{$lang['nickname']}</td>\n";
            echo "                              <td align=\"left\" class=\"subhead\" width=\"150\">{$lang['ip']}</td>\n";
            echo "                            </tr>\n";

            foreach ($user_alias_array as $user_alias) {

                echo "                            <tr>\n";
                echo "                              <td align=\"left\"><a href=\"admin_user.php?webtag=$webtag&amp;uid={$user_alias['UID']}\">{$user_alias['LOGON']}</a></td>\n";
                echo "                              <td align=\"left\">{$user_alias['NICKNAME']}</td>\n";

                if (ip_is_banned($user_alias['IPADDRESS'])) {
                    echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$user_alias['IPADDRESS']}\" target=\"_self\">{$lang['banned']}</a>&nbsp;</td>";
                }else {
                    echo "                              <td align=\"left\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$user_alias['IPADDRESS']}\" target=\"_self\">{$user_alias['IPADDRESS']}</a>&nbsp;</td>";
                }

                echo "                            </tr>\n";
            }

            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\">&nbsp;</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['nomatches']}</td>\n";
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
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['deleteposts']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"250\">{$lang['deleteallusersposts']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_delete_posts", "Y", $lang['yes'], false), "&nbsp;", form_radio("t_delete_posts", "N", $lang['no'], true), "</td>\n";
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

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['resetpassword']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['forgottenpassworddesc']}</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['resetpassword']}:</td>\n";
        echo "                        <td align=\"left\">", form_radio("t_reset_password", "Y", $lang['yes'], false), "&nbsp;", form_radio("t_reset_password", "N", $lang['no'], true), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\">{$lang['resetpasswordto']}:</td>\n";
        echo "                        <td align=\"left\">", form_input_password("t_new_password", "", 32), "</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['attachments']}</td>\n";
    echo "                </tr>\n";

    if (admin_get_users_attachments($uid, $attachments_array, $image_attachments_array)) {

        $attachments_array = array_merge($attachments_array, $image_attachments_array);
        
        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"box\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">\n";
        echo "                          <table class=\"posthead\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" class=\"subhead\">{$lang['filename']}</td>\n";
        echo "                              <td align=\"left\" class=\"subhead\">{$lang['message']}</td>\n";
        echo "                              <td class=\"subhead\" align=\"right\">{$lang['size']}&nbsp;</td>\n";
        echo "                              <td class=\"subhead\" align=\"right\">", form_checkbox("toggle_all", "toggle_all", "", false, "onclick=\"attachment_toggle_all();\""), "&nbsp;</td>\n";
        echo "                            </tr>\n";

        foreach($attachments_array as $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                            <tr>\n";
                echo "                              <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                              <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                              <td align=\"left\">&nbsp;</td>\n";
                }

                echo "                              <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                              <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("delete_attachment[{$attachment['hash']}]", "Y", ""), "&nbsp;</td>\n";
                echo "                            </tr>\n";
            }
        }

        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td class=\"postbody\" colspan=\"2\" align=\"center\">", form_submit("delete", $lang['delete']), "</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" valign=\"top\" width=\"300\" class=\"postbody\" colspan=\"3\">{$lang['noattachmentsforuser']}</td>\n";
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
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", $ret), "\n";
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>
