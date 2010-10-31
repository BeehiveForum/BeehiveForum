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

/* $Id$ */

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
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Are we returning somewhere?
if (isset($_GET['ret']) && strlen(trim(stripslashes_array($_GET['ret']))) > 0) {
    $ret = rawurldecode(trim(stripslashes_array($_GET['ret'])));
}elseif (isset($_POST['ret']) && strlen(trim(stripslashes_array($_POST['ret']))) > 0) {
    $ret = trim(stripslashes_array($_POST['ret']));
}else {
    $ret = "admin_user_groups.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_pages = array('admin_user_groups.php', 'admin_user.php');
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/", basename($ret)) < 1) {
        $ret = "admin_user_groups.php?webtag=$webtag";
    }
}

// Cancel button has been pressed.
if (isset($_POST['cancel'])) {

    header_redirect($ret);
    exit;
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {

    $gid = $_GET['gid'];

}elseif (isset($_POST['gid']) && is_numeric($_POST['gid'])) {

    $gid = $_POST['gid'];

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['suppliedgidisnotausergroup'], 'admin_user_groups.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

if (!$group = perm_get_group($gid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['suppliedgidisnotausergroup'], 'admin_user_groups.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Get Group Permissions
$group_permissions = perm_get_group_permissions($gid);

// Do updates
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim(stripslashes_array($_POST['t_name']))) > 0) {

        $t_name = trim(stripslashes_array($_POST['t_name']));

    }else {

        $error_msg_array[] = $lang['mustentergroupname'];
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim(stripslashes_array($_POST['t_description']))) > 0) {
        $t_description = trim(stripslashes_array($_POST['t_description']));
    }else {
        $t_description = "";
    }

    $t_admintools = (double) (isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
    $t_banned     = (double) (isset($_POST['t_banned']))     ? $_POST['t_banned']     : 0;
    $t_wormed     = (double) (isset($_POST['t_wormed']))     ? $_POST['t_wormed']     : 0;
    $t_globalmod  = (double) (isset($_POST['t_globalmod']))  ? $_POST['t_globalmod']  : 0;
    $t_linksmod   = (double) (isset($_POST['t_linksmod']))   ? $_POST['t_linksmod']   : 0;

    $new_group_perms = (double) $t_banned | $t_wormed | $t_globalmod | $t_linksmod;

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        $new_group_perms = (double) $new_group_perms | $t_admintools;

    }else {

        $new_group_perms = (double) $new_group_perms | ($group_permissions & USER_PERM_ADMIN_TOOLS);
    }

    if ($valid) {

        if (perm_update_group($gid, $t_name, $t_description, $new_group_perms)) {

            if (isset($_POST['t_update_perms_array']) && is_array($_POST['t_update_perms_array'])) {

                $t_update_perms_array = $_POST['t_update_perms_array'];

                $folder_array = perm_group_get_folders($gid);

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

                    $new_group_perms = (double) $t_post_read | $t_post_create | $t_thread_create;
                    $new_group_perms = (double) $new_group_perms | $t_post_edit | $t_post_delete;
                    $new_group_perms = (double) $new_group_perms | $t_moderator | $t_post_attach;
                    $new_group_perms = (double) $new_group_perms | $t_post_html | $t_post_sig | $t_post_approval;;

                    if ($new_group_perms <> $folder_array[$fid]['STATUS']) {
                        perm_update_group_folder_perms($gid, $fid, $new_group_perms);
                    }
                }
            }

            admin_add_log_entry(UPDATE_USER_GROUP, $t_name);
            header_redirect("admin_user_groups.php?webtag=$webtag&edited=true");
            exit;
        }
    }

    $group_permissions = perm_get_group_permissions($gid);

}else if (isset($_POST['addusers'])) {

    $redirect_uri = "admin_user_groups_edit_users.php?webtag=$webtag&gid=$gid";
    $redirect_uri.= "&ret=admin_user_groups_edit.php%3Fwebtag%3D$webtag%26gid%3D$gid";
    $redirect_uri.= "%26ret%3D". rawurlencode(rawurlencode(rawurlencode($ret)));

    header_redirect($redirect_uri);
    exit;
}

html_draw_top("title={$lang['admin']} - {$lang['manageusergroups']} - {$group['GROUP_NAME']}", 'class=window_title');

$group_users_array = perm_group_get_users($gid, 0);

echo "<h1>{$lang['admin']}<img src=\"", style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['manageusergroups']}<img src=\"", style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$group['GROUP_NAME']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '550', 'center');

}else if (sizeof($group_users_array['user_array']) < 1) {

    html_display_warning_msg($lang['nousersingroupaddusers'], '550', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user_groups_edit.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("gid", htmlentities_array($gid)), "\n";
echo "  ", form_input_hidden('ret', htmlentities_array($ret)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['nameanddesc']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['name']}:</td>\n";
echo "                        <td align=\"left\">".form_input_text("t_name", (isset($t_name) ? htmlentities_array($t_name) : htmlentities_array($group['GROUP_NAME'])), 30, 64)."</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                        <td align=\"left\">".form_input_text("t_description", (isset($t_description) ? htmlentities_array($t_description) : htmlentities_array($group['GROUP_DESC'])), 30, 64)."</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['groupstatus']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['groupcanaccessadmintools'], $group_permissions & USER_PERM_ADMIN_TOOLS), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['groupcanmoderateallfolders'], $group_permissions & USER_PERM_FOLDER_MODERATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, $lang['groupcanmoderatelinkssection'], $group_permissions & USER_PERM_LINKS_MODERATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_banned", USER_PERM_BANNED, $lang['groupisbanned'], $group_permissions & USER_PERM_BANNED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['groupiswormed'], $group_permissions & USER_PERM_WORMED), "</td>\n";
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
echo "        <br />\n";

if (($folder_array = perm_group_get_folders($gid))) {

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

        if ($folder['STATUS'] > 0) {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", htmlentities_array($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid=$fid\" target=\"_self\">", word_filter_add_ob_tags(htmlentities_array($folder['TITLE'])), "</a></td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_read[$fid]", USER_PERM_POST_READ, $lang['readposts'], $folder['STATUS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_create[$fid]", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_thread_create[$fid]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_edit[$fid]", USER_PERM_POST_EDIT, $lang['editposts'], $folder['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_delete[$fid]", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_attach[$fid]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_html[$fid]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_sig[$fid]", USER_PERM_SIGNATURE, $lang['postasignature'], $folder['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_moderator[$fid]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $folder['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_approval[$fid]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], $folder['STATUS'] & USER_PERM_POST_APPROVAL), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";

        }else {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", htmlentities_array($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags(htmlentities_array($folder['TITLE'])), "</a></td>\n";
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
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
}

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("addusers", $lang['addremoveusers']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>