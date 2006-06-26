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

/* $Id: admin_user_groups_edit.php,v 1.35 2006-06-26 11:04:38 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable UTF-8 encoding via mb_string functions if supported
include_once(BH_INCLUDE_PATH. "utf8.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (isset($_POST['cancel'])) {
    header_redirect("./admin_user_groups.php?webtag=$webtag");
}

html_draw_top();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {
    $gid = $_GET['gid'];
}elseif (isset($_POST['gid']) && is_numeric($_POST['gid'])) {
    $gid = $_POST['gid'];
}else {
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['invalidop']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (!$group = perm_get_group($gid)) {
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['suppliedgidisnotausergroup']}</h2>\n";
    html_draw_bottom();
    exit;
}

$group_permissions = perm_get_group_permissions($gid);

// Draw the form
echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['manageusergroups']} : {$group['GROUP_NAME']}</h1>\n";

// Do updates

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {
        $t_name = trim(_stripslashes($_POST['t_name']));
    }else {
        $error_html = "<h2>{$lang['mustentergroupname']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim(_stripslashes($_POST['t_description']))) > 0) {
        $t_description = trim(_stripslashes($_POST['t_description']));
    }else {
        $t_description = "";
    }

    $t_admintools = (double) (isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
    $t_banned     = (double) (isset($_POST['t_banned']))     ? $_POST['t_banned']     : 0;
    $t_wormed     = (double) (isset($_POST['t_wormed']))     ? $_POST['t_wormed']     : 0;
    $t_globalmod  = (double) (isset($_POST['t_globalmod']))  ? $_POST['t_globalmod']  : 0;
    $t_linksmod   = (double) (isset($_POST['t_linksmod']))   ? $_POST['t_linksmod']   : 0;

    $new_group_perms = (double) $t_banned | $t_wormed | $t_globalmod | $t_linksmod;

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

        $new_group_perms = (double) $new_group_perms | $t_admintools;
        $new_group_perms = (double) $new_group_perms | ($group_permissions & USER_PERM_FORUM_TOOLS);

    }else {

        $new_group_perms = (double) $new_group_perms | ($group_permissions & USER_PERM_ADMIN_TOOLS);
        $new_group_perms = (double) $new_group_perms | ($group_permissions & USER_PERM_FORUM_TOOLS);
    }

    if ($valid) {

        if (perm_update_group($gid, $t_name, $t_description, $new_group_perms)) {

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

                    $new_group_perms = (double) $t_post_read | $t_post_create | $t_thread_create;
                    $new_group_perms = (double) $new_group_perms | $t_post_edit | $t_post_delete;
                    $new_group_perms = (double) $new_group_perms | $t_moderator | $t_post_attach;
                    $new_group_perms = (double) $new_group_perms | $t_post_html | $t_post_sig | $t_post_approval;;

                    perm_update_group_folder_perms($gid, $fid, $new_group_perms);
                }
            }

            admin_add_log_entry(UPDATE_USER_GROUP, $t_name);
        }
    }

    $group_permissions = perm_get_group_permissions($gid);
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"admin_user_form\" action=\"admin_user_groups_edit.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("gid", $gid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['nameanddesc']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['name']}:</td>\n";
echo "                  <td>".form_input_text("t_name", (isset($t_name) ? $t_name : $group['GROUP_NAME']), 30, 64)."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                  <td>".form_input_text("t_description", (isset($t_description) ? $t_description : $group['GROUP_DESC']), 30, 64)."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['groupstatus']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"90%\">\n";

if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['groupcanaccessadmintools'], $group_permissions & USER_PERM_ADMIN_TOOLS), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['groupcanmoderateallfolders'], $group_permissions & USER_PERM_FOLDER_MODERATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, $lang['groupcanmoderatelinkssection'], $group_permissions & USER_PERM_LINKS_MODERATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_banned", USER_PERM_BANNED, $lang['groupisbanned'], $group_permissions & USER_PERM_BANNED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['groupiswormed'], $group_permissions & USER_PERM_WORMED), "</td>\n";
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
echo "        <br />\n";

if ($folder_array = perm_group_get_folders($gid)) {

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
    echo "                                <div class=\"admin_folder_perms\">\n";

    foreach($folder_array as $fid => $folder) {

        if ($folder['STATUS'] > 0) {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid=$fid\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_read[$fid]", USER_PERM_POST_READ, $lang['readposts'], $folder['STATUS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_create[$fid]", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder['STATUS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_thread_create[$fid]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder['STATUS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_edit[$fid]", USER_PERM_POST_EDIT, $lang['editposts'], $folder['STATUS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_delete[$fid]", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder['STATUS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_attach[$fid]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder['STATUS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_html[$fid]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder['STATUS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_sig[$fid]", USER_PERM_SIGNATURE, $lang['postasignature'], $folder['STATUS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_moderator[$fid]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $folder['STATUS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_approval[$fid]", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], $folder['STATUS'] & USER_PERM_POST_APPROVAL), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";

        }else {

            echo "                                  ", form_input_hidden("t_update_perms_array[]", $folder['FID']), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">{$folder['TITLE']}</a></td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'], false), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], false), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], false), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], false), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], false), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], false), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], false), "</td>\n";
            echo "                                      <td nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], false), "</td>\n";
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
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
}

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>