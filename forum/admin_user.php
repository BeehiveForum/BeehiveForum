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

/* $Id: admin_user.php,v 1.112 2004-08-17 10:52:23 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/attachments.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

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

html_draw_top('admin.js');

if (!(perm_has_admin_access())) {
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
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nouserspecified']}</h2>\n";
    html_draw_bottom();
    exit;
}

$user = user_get($uid);
$user_perms = perm_get_user_permissions($uid);

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageuser']} : {$user['LOGON']}</h1>\n";

// Do updates

if (isset($_POST['del'])) {

    if (isset($_POST['hash']) && is_md5($_POST['hash'])) {

        delete_attachment($_POST['hash']);
    }

}elseif (isset($_POST['submit'])) {

    if (isset($_POST['t_confirm_delete_posts'])) {

        if ($user_post_array = get_user_posts($uid)) {

            foreach ($user_post_array as $user_post) {
                post_delete($user_post['TID'], $user_post['PID']);
            }

            admin_addlog($uid, 0, 0, 0, 0, 0, 3);
        }

        echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";

    }elseif (!isset($_POST['t_delete_posts']) || (isset($_POST['t_delete_posts']) && $_POST['t_delete_posts'] != "Y")) {

        $new_user_perms = (double) 0;

        $t_admintools = (double) (isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
        $t_banned     = (double) (isset($_POST['t_banned']))     ? $_POST['t_banned']     : 0;
        $t_wormed     = (double) (isset($_POST['t_wormed']))     ? $_POST['t_wormed']     : 0;
        $t_globalmod  = (double) (isset($_POST['t_globalmod']))  ? $_POST['t_globalmod']  : 0;

        $new_user_perms = (double) ($t_banned | $t_wormed | $t_globalmod);

        if (perm_has_forumtools_access()) {

            $new_user_perms = (double)$new_user_perms | $t_admintools;
            $new_user_perms = (double)$new_user_perms | ($user_perms & USER_PERM_FORUM_TOOLS);

        }else {

            $new_user_perms = (double)$new_user_perms | ($user_perms & USER_PERM_ADMIN_TOOLS);
            $new_user_perms = (double)$new_user_perms | ($user_perms & USER_PERM_FORUM_TOOLS);
        }

        if ($user_gid = perm_get_user_gid($uid)) {
            perm_update_user_permissions($uid, $user_gid, $new_user_perms);
        }else {
            $user_gid = perm_add_user_permissions($uid, $new_user_perms);
        }

        $user_perms = $new_user_perms;

        if (isset($user_gid) && is_numeric($user_gid)) {

            if (isset($_POST['t_update_perms_array']) && is_array($_POST['t_update_perms_array'])) {

                $t_update_perms_array = $_POST['t_update_perms_array'];

                foreach ($t_update_perms_array as $fid) {

                    $t_post_read     = (isset($_POST['t_post_read'][$fid]))     ? $_POST['t_post_read'][$fid]     : 0;
                    $t_post_create   = (isset($_POST['t_post_create'][$fid]))   ? $_POST['t_post_create'][$fid]   : 0;
                    $t_thread_create = (isset($_POST['t_thread_create'][$fid])) ? $_POST['t_thread_create'][$fid] : 0;
                    $t_post_edit     = (isset($_POST['t_post_edit'][$fid]))     ? $_POST['t_post_edit'][$fid]     : 0;
                    $t_post_delete   = (isset($_POST['t_post_delete'][$fid]))   ? $_POST['t_post_delete'][$fid]   : 0;
                    $t_post_attach   = (isset($_POST['t_post_attach'][$fid]))   ? $_POST['t_post_attach'][$fid]   : 0;
                    $t_moderator     = (isset($_POST['t_moderator'][$fid]))     ? $_POST['t_moderator'][$fid]     : 0;
                    $t_post_html     = (isset($_POST['t_post_html'][$fid]))     ? $_POST['t_post_html'][$fid]     : 0;
                    $t_post_sig      = (isset($_POST['t_post_sig'][$fid]))      ? $_POST['t_post_sig'][$fid]      : 0;

                    $new_folder_perms = (double)$t_post_read | $t_post_create | $t_thread_create;
                    $new_folder_perms = (double)$new_folder_perms | $t_post_edit | $t_post_delete;
                    $new_folder_perms = (double)$new_folder_perms | $t_moderator | $t_post_attach;
                    $new_folder_perms = (double)$new_folder_perms | $t_post_html | $t_post_sig;

                    perm_update_user_folder_perms($uid, $user_gid, $fid, $new_folder_perms);
                }
            }

            if (isset($_POST['t_new_perms_array']) && is_array($_POST['t_new_perms_array'])) {

                $t_new_perms_array = $_POST['t_new_perms_array'];

                foreach ($t_new_perms_array as $fid) {

                    $t_post_read     = (isset($_POST['t_post_read'][$fid]))     ? $_POST['t_post_read'][$fid]     : 0;
                    $t_post_create   = (isset($_POST['t_post_create'][$fid]))   ? $_POST['t_post_create'][$fid]   : 0;
                    $t_thread_create = (isset($_POST['t_thread_create'][$fid])) ? $_POST['t_thread_create'][$fid] : 0;
                    $t_post_edit     = (isset($_POST['t_post_edit'][$fid]))     ? $_POST['t_post_edit'][$fid]     : 0;
                    $t_post_delete   = (isset($_POST['t_post_delete'][$fid]))   ? $_POST['t_post_delete'][$fid]   : 0;
                    $t_post_attach   = (isset($_POST['t_post_attach'][$fid]))   ? $_POST['t_post_attach'][$fid]   : 0;
                    $t_moderator     = (isset($_POST['t_moderator'][$fid]))     ? $_POST['t_moderator'][$fid]     : 0;
                    $t_post_html     = (isset($_POST['t_post_html'][$fid]))     ? $_POST['t_post_html'][$fid]     : 0;
                    $t_post_sig      = (isset($_POST['t_post_sig'][$fid]))      ? $_POST['t_post_sig'][$fid]      : 0;

                    $new_folder_perms = (double)$t_post_read | $t_post_create | $t_thread_create;
                    $new_folder_perms = (double)$new_folder_perms | $t_post_edit | $t_post_delete;
                    $new_folder_perms = (double)$new_folder_perms | $t_moderator | $t_post_attach;
                    $new_folder_perms = (double)$new_folder_perms | $t_post_html | $t_post_sig;

                    perm_add_user_folder_perms($uid, $user_gid, $fid, $new_folder_perms);
                }
            }
        }

        // IP Addresses to be banned

        if (isset($_POST['t_ban_ipaddress']) && is_array($_POST['t_ban_ipaddress'])) {
            $t_ban_ipaddress = $_POST['t_ban_ipaddress'];
        }else {
            $t_ban_ipaddress = array();
        }

        // Already banned IPs for the selected user.

        if (isset($_POST['t_ip_banned']) && is_array($_POST['t_ip_banned'])) {
            $t_ip_banned = $_POST['t_ip_banned'];
        }else {
            $t_ip_banned = array();
        }

        // Get the current user's IP. So we don't ban ourselves.

        if ($ipaddress = get_ip_address()) {

            // Unban the unselected IP adddresses first.

            foreach($t_ip_banned as $banned_ip_address) {
                if (!in_array($banned_ip_address, $t_ban_ipaddress)) {
                    unban_ip($banned_ip_address);
                    admin_addlog($uid, 0, 0, 0, 0, 0, 5);
                }
            }

            // Ban the selected IP Addresses

            foreach($t_ban_ipaddress as $ban_ip_address) {
                if (!ip_is_banned($ban_ip_address)) {
                    if (($t_ban_ipaddress != $ipaddress) && !($user['STATUS']&PERM_CHECK_SOLDIER)) {
                        ban_ip($ban_ip_address);
                        admin_addlog($uid, 0, 0, 0, 0, 0, 4);
                    }
                }
            }
        }

        echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";
    }
}

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<form name=\"admin_user_form\" action=\"admin_user.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("uid", $uid), "\n";

if (isset($_POST['t_delete_posts'])) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['userstatus']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td><h2>{$lang['warning_caps']}</h2></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['userdeleteallpostswarning']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>", form_checkbox("t_confirm_delete_posts", "Y", $lang['confirm'], false), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag=$webtag&amp;uid=$uid"), "\n";

}else if (isset($_POST['t_confirm_delete_posts'])) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['userstatus']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['postssuccessfullydeleted']}</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag=$webtag&amp;uid=$uid"), "\n";

}else {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['userstatus']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";

    if (perm_has_forumtools_access()) {

        echo "                      <tr>\n";
        echo "                        <td>", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['usercanaccessadmintools'], $user_perms & USER_PERM_ADMIN_TOOLS), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_banned", USER_PERM_BANNED, $lang['userisbanned'], $user_perms & USER_PERM_BANNED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['useriswormed'], $user_perms & USER_PERM_WORMED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['userisglobalmod'], $user_perms & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>&nbsp;</td>\n";
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

    if ($folder_array = folder_get_all()) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['folderaccess']}:</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"box\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td class=\"posthead\">\n";
        echo "                          <table class=\"posthead\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td class=\"subhead\" width=\"100\">&nbsp;{$lang['folders']}</td>\n";
        echo "                              <td class=\"subhead\">&nbsp;{$lang['permissions']}</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td colspan=\"2\">\n";
        echo "                                <div style=\"width: 500px; height: 120px\" class=\"admin_folder_perms\">\n";

        foreach($folder_array as $fid => $folder) {

            $user_folder_permissions = perm_get_user_folder_perms($uid, $fid);

            if (isset($user_folder_permissions['STATUS'])) {

                echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], $user_folder_permissions['STATUS'] & USER_PERM_POST_READ), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], $user_folder_permissions['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $user_folder_permissions['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], $user_folder_permissions['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], $user_folder_permissions['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $user_folder_permissions['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $user_folder_permissions['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], $user_folder_permissions['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td colspan=\"2\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $user_folder_permissions['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td colspan=\"4\">&nbsp;</td>\n";
                echo "                                    </tr>\n";
                echo "                                  </table>\n";

            }else {

                echo "                                  ", form_input_hidden("t_new_perms_array[]", $folder['FID']), "\n";
                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], true), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], true), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], true), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], true), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], true), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], true), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], true), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], true), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td colspan=\"2\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], false), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td colspan=\"4\">&nbsp;</td>\n";
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
        echo "                        <td>&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>{$lang['usergroupwarning']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>&nbsp;</td>\n";
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
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['usergroups']}:</td>\n";
    echo "                </tr>\n";

    if ($user_groups_array = perm_user_get_groups($uid)) {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td>{$lang['useringroups']}:</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>\n";
        echo "                          <table class=\"box\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td class=\"posthead\">\n";
        echo "                                <table class=\"posthead\" width=\"100%\">\n";
        echo "                                  <tr>\n";
        echo "                                    <td class=\"subhead\">&nbsp;{$lang['groups']}</td>\n";
        echo "                                    <td class=\"subhead\">&nbsp;{$lang['users']}</td>\n";
        echo "                                    <td class=\"subhead\">&nbsp;</td>\n";
        echo "                                  </tr>\n";

        foreach ($user_groups_array as $user_group) {

            echo "                                  <tr>\n";
            echo "                                    <td valign=\"top\"><a href=\"admin_user_groups_edit.php?gid={$user_group['GID']}\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";
            echo "                                    <td valign=\"top\" align=\"center\">{$user_group['USER_COUNT']}</td>\n";
            echo "                                    <td valign=\"top\" align=\"right\">", form_submit("edit_users[{$user_group['GID']}]", $lang['addremoveusers']), "&nbsp;</td>\n";
            echo "                                  </tr>\n";
        }

        echo "                                  <tr>\n";
        echo "                                    <td>&nbsp;</td>\n";
        echo "                                    <td>&nbsp;</td>\n";
        echo "                                    <td>&nbsp;</td>\n";
        echo "                                  </tr>\n";
        echo "                                </table>\n";
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
        echo "                        <td>&nbsp;{$lang['usernotinanygroups']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td>&nbsp;</td>\n";
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
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}:</td>\n";
    echo "                </tr>\n";

    if ($user_alias_array = user_get_aliases($user['UID'])) {

        if (sizeof($user_alias_array) > 0) {

            echo "                <tr>\n";
            echo "                  <td>&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"box\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td>\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td class=\"subhead\">&nbsp;</td>\n";
            echo "                              <td class=\"subhead\" width=\"150\">&nbsp;LOGON</td>\n";
            echo "                              <td class=\"subhead\">&nbsp;IP Address</td>\n";
            echo "                            </tr>\n";

            foreach ($user_alias_array as $user_alias) {
                echo "                            <tr>\n";
                echo "                              <td align=\"left\">", form_checkbox("t_ban_ipaddress[]", $user_alias['IPADDRESS'], "", ip_is_banned($user_alias['IPADDRESS'])), "</td>\n";
                echo "                              <td align=\"left\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid={$user_alias['UID']}\">{$user_alias['LOGON']}</a></td>\n";
                echo "                              <td align=\"left\">&nbsp;{$user_alias['IPADDRESS']}";

                if (ip_is_banned($user_alias['IPADDRESS'])) echo form_input_hidden("t_ip_banned[]", $user_alias['IPADDRESS']);

                echo "</td>\n";
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
            echo "                <tr>\n";
            echo "                  <td class=\"smalltext\" align=\"left\">{$lang['tobananIPaddress']}</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td>{$lang['nomatches']}</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['deleteposts']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_delete_posts", "Y", $lang['deleteallusersposts'], false), "</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['attachments']}:</td>\n";
    echo "                </tr>\n";

    if ($attachments_array = admin_get_users_attachments($uid, true)) {

        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"box\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td>\n";
        echo "                          <table class=\"posthead\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td class=\"subhead\">{$lang['filename']}</td>\n";
        echo "                              <td class=\"subhead\">{$lang['message']}</td>\n";
        echo "                              <td class=\"subhead\" align=\"right\">{$lang['size']}&nbsp;</td>\n";
        echo "                              <td class=\"subhead\" align=\"right\">{$lang['delete']}&nbsp;</td>\n";
        echo "                            </tr>\n";

        foreach($attachments_array as $attachment) {

            echo "                            <tr>\n";
            echo "                              <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";

            if (forum_get_setting('attachment_use_old_method', 'Y', false)) {
                echo "<a href=\"getattachment.php?webtag=$webtag&amp;hash=", $attachment['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachment['hash'], "/", rawurlencode($attachment['filename']), "?webtag=$webtag\" title=\"";
            }

            if (strlen($attachment['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachment['filename']. ", ";
            }

            if (@$imageinfo = getimagesize(forum_get_setting('attachment_dir'). '/'. md5($attachment['aid']. rawurldecode($attachment['filename'])))) {
                echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
            }

            echo "{$lang['size']}: ". format_file_size($attachment['filesize']). ", ";
            echo "{$lang['downloaded']}: ". $attachment['downloads'];

            if ($attachment['downloads'] == 1) {
                echo " {$lang['time']}";
            }else {
                echo " {$lang['times']}";
            }

            echo "\">";

            if (strlen($attachment['filename']) > 16) {
                echo substr($attachment['filename'], 0, 16). "...</a></td>\n";
            }else{
                echo $attachment['filename']. "</a></td>\n";
            }

            if ($messagelink = get_message_link($attachment['aid'])) {
                if (strstr($messagelink, 'messages.php')) {
                    echo "                              <td valign=\"top\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\"><a href=\"", $messagelink, "\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
                }else {
                    echo "                              <td valign=\"top\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
                }
            }else {
                echo "                              <td valign=\"top\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
            }

            echo "                              <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachment['filesize']). "</td>\n";
            echo "                              <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\" valign=\"top\">\n";
            echo "                                ", form_input_hidden('hash', $attachment['hash']), "\n";
            echo "                                ", form_submit('del', $lang['delete']), "\n";
            echo "                              </td>\n";
            echo "                            </tr>\n";
        }

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
        echo "                        <td valign=\"top\" width=\"300\" class=\"postbody\" colspan=\"3\">{$lang['noattachmentsforuser']}</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", $ret), "\n";
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>