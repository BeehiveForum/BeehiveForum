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

/* $Id: admin_user.php,v 1.136 2005-03-20 17:53:31 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

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

if (isset($_POST['delete'])) {

    if (isset($_POST['hash']) && is_md5($_POST['hash'])) {

        delete_attachment($_POST['hash']);
    }

}

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

    $new_user_perms = (double) 0;

    $t_admintools = (double) (isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
    $t_banned     = (double) (isset($_POST['t_banned']))     ? $_POST['t_banned']     : 0;
    $t_wormed     = (double) (isset($_POST['t_wormed']))     ? $_POST['t_wormed']     : 0;
    $t_globalmod  = (double) (isset($_POST['t_globalmod']))  ? $_POST['t_globalmod']  : 0;
    $t_linksmod   = (double) (isset($_POST['t_linksmod']))   ? $_POST['t_linksmod']   : 0;

    $new_user_perms = (double) $t_banned | $t_wormed | $t_globalmod | $t_linksmod;

    if (perm_has_forumtools_access()) {

        $new_user_perms = (double) $new_user_perms | $t_admintools;
        $new_user_perms = (double) $new_user_perms | ($user_perms & USER_PERM_FORUM_TOOLS);

    }else {

        $new_user_perms = (double) $new_user_perms | ($user_perms & USER_PERM_ADMIN_TOOLS);
        $new_user_perms = (double) $new_user_perms | ($user_perms & USER_PERM_FORUM_TOOLS);
    }

    $user_gid = perm_update_user_permissions($uid, $new_user_perms);

    $user_perms = perm_get_user_permissions($uid);

    if (isset($user_gid) && is_numeric($user_gid)) {

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

                perm_update_user_folder_perms($uid, $user_gid, $fid, $new_folder_perms);
            }
        }

        if (isset($_POST['t_new_perms_array']) && is_array($_POST['t_new_perms_array'])) {

            $t_new_perms_array = $_POST['t_new_perms_array'];

            foreach ($t_new_perms_array as $fid) {

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

                perm_add_user_folder_perms($uid, $user_gid, $fid, $new_folder_perms);
            }
        }
    }

    // Password reset

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

    echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";

    if ($t_reset_password === true && strlen($t_new_password) > 0) {

        $fuid = bh_session_get_value('UID');

        user_change_pass($uid, $t_new_password, false);

        email_send_new_pw_notification($uid, $fuid, $t_new_password);

        $user_logon = user_get_logon($uid);
        admin_add_log_entry(CHANGE_USER_PASSWD, $user_logon);

    }else {

        $user_logon = user_get_logon($uid);
        admin_add_log_entry(CHANGE_USER_STATUS, $user_logon);
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
    echo "                  <td class=\"subhead\">{$lang['warning_caps']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td>{$lang['userdeleteallpostswarning']}</td>\n";
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
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("t_confirm_delete_posts", $lang['confirm']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
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
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td>{$lang['postssuccessfullydeleted']}</td>\n";
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
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
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
    echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['userstatus']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";

    if (perm_has_admin_access()) {

        echo "                      <tr>\n";
        echo "                        <td>", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['usercanaccessadmintools'], $user_perms & USER_PERM_ADMIN_TOOLS), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['usercanmoderateallfolders'], $user_perms & USER_PERM_FOLDER_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, $lang['usercanmoderatelinkssection'], $user_perms & USER_PERM_LINKS_MODERATE), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_banned", USER_PERM_BANNED, $lang['userisbanned'], $user_perms & USER_PERM_BANNED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['useriswormed'], $user_perms & USER_PERM_WORMED), "</td>\n";
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

    if ($folder_array = perm_user_get_folders($uid)) {

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['folderaccess']}</td>\n";
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
        echo "                                <div class=\"admin_folder_perms\">\n";

        foreach($folder_array as $fid => $folder) {

            if ($folder['STATUS'] > 0) {

                echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
                echo "                                  <table class=\"posthead\" width=\"100%\">\n";
                echo "                                    <tr>\n";
                echo "                                      <td rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], $folder['STATUS'] & USER_PERM_POST_READ), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], $folder['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], $folder['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
                echo "                                    </tr>\n";
                echo "                                    <tr>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $folder['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], $folder['STATUS'] & USER_PERM_POST_APPROVAL), "</td>\n";
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
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], false), "</td>\n";
                echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], false), "</td>\n";
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
    echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['usergroups']}</td>\n";
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
        echo "                      <tr>\n";
        echo "                        <td>&nbsp;</td>\n";
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
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}</td>\n";
    echo "                </tr>\n";

    if ($user_alias_array = user_get_aliases($user['UID'])) {

        if (sizeof($user_alias_array) > 0) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table width=\"90%\" class=\"posthead\">\n";
            echo "                      <tr>\n";
            echo "                        <td>&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td>{$lang['aliasdesc']}</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td>&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"box\" width=\"90%\">\n";
            echo "                      <tr>\n";
            echo "                        <td>\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td class=\"subhead\" width=\"150\">&nbsp;{$lang['logon']}</td>\n";
            echo "                              <td class=\"subhead\" width=\"150\">&nbsp;{$lang['nickname']}</td>\n";
            echo "                            </tr>\n";

            foreach ($user_alias_array as $user_alias) {

                echo "                            <tr>\n";
                echo "                              <td align=\"left\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid={$user_alias['UID']}\">{$user_alias['LOGON']}</a></td>\n";
                echo "                              <td align=\"left\">&nbsp;{$user_alias['NICKNAME']}</td>\n";
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
        echo "                        <td>{$lang['aliasdesc']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td>&nbsp;</td>\n";
        echo "                      </tr>\n";
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
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['deleteposts']}</td>\n";
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
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['resetpassword']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"90%\" class=\"posthead\">\n";
    echo "                      <tr>\n";
    echo "                        <td>{$lang['forgottenpassworddesc']}</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"150\">{$lang['resetpassword']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_reset_password", "Y", $lang['yes'], false), "&nbsp;", form_radio("t_reset_password", "N", $lang['no'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"150\">{$lang['resetpasswordto']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("t_new_password", "", 32), "</td>\n";
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
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['attachments']}</td>\n";
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

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                            <tr>\n";
                echo "                              <td valign=\"top\" width=\"300\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'], false)) {

                    echo "                              <td valign=\"top\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\"><a href=\"", $message_link, "\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

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
