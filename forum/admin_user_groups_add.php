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

/* $Id: admin_user_groups_add.php,v 1.50 2007-09-17 19:47:41 decoyduck Exp $ */

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

// Array to hold error messages

$error_msg_array = array();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Cancel button clicked.

if (isset($_POST['cancel'])) {

    header_redirect("./admin_user_groups.php?webtag=$webtag");
    exit;
}

// Do updates

if (isset($_POST['add_group']) || isset($_POST['add_users'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {

        $t_name = trim(_stripslashes($_POST['t_name']));

    }else {

        $error_msg_array[] = $lang['mustentergroupname'];
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

    if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0)) {

        $new_group_perms = (double)$new_group_perms | $t_admintools;
    }

    if ($valid) {

        if ($new_gid = perm_add_group($t_name, $t_description, $new_group_perms)) {

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

                    $new_group_perms = (double) $t_post_read | $t_post_create | $t_thread_create;
                    $new_group_perms = (double) $new_group_perms | $t_post_edit | $t_post_delete;
                    $new_group_perms = (double) $new_group_perms | $t_moderator | $t_post_attach;
                    $new_group_perms = (double) $new_group_perms | $t_post_html | $t_post_sig | $t_post_approval;

                    perm_update_group_folder_perms($new_gid, $fid, $new_group_perms);
                }
            }

            admin_add_log_entry(CREATE_USER_GROUP, $t_name);

            if (isset($_POST['add_users'])) {

                header_redirect("./admin_user_groups_edit_users.php?webtag=$webtag&gid=$new_gid&added=true");
                exit;

            }else {

                header_redirect("./admin_user_groups.php?webtag=$webtag&added=true");
                exit;
            }
        }
    }
}

html_draw_top();

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageusergroups']} &raquo; {$lang['addusergroup']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '550', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"admin_user_form\" action=\"admin_user_groups_add.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
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
echo "                        <td align=\"left\">".form_input_text("t_name", (isset($t_name) ? _htmlentities($t_name) : ""), 30, 64)."</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                        <td align=\"left\">".form_input_text("t_description", (isset($t_description) ? _htmlentities($t_description) : ""), 30, 64)."</td>\n";
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

if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, $lang['groupcanaccessadmintools'], false), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, $lang['groupcanmoderateallfolders'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, $lang['groupcanmoderatelinkssection'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_banned", USER_PERM_BANNED, $lang['groupisbanned'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_wormed", USER_PERM_WORMED, $lang['groupiswormed'], false), "</td>\n";
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

if ($folder_array = folder_get_all()) {

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

    foreach($folder_array as $folder) {

        if ($folder['FOLDER_PERM_COUNT'] > 0) {

            echo "                                  ", form_input_hidden("t_new_perms_array[]", _htmlentities($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags(_htmlentities($folder['TITLE'])), "</a></td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'] , $folder['FOLDER_PERMS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder['FOLDER_PERMS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder['FOLDER_PERMS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], $folder['FOLDER_PERMS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder['FOLDER_PERMS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder['FOLDER_PERMS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder['FOLDER_PERMS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], $folder['FOLDER_PERMS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"2\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], $folder['FOLDER_PERMS'] & USER_PERM_FOLDER_MODERATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";

        }else {

            echo "                                  ", form_input_hidden("t_new_perms_array[]", _htmlentities($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags(_htmlentities($folder['TITLE'])), "</a></td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, $lang['readposts'] , true), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, $lang['replytothreads'], true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], true), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, $lang['editposts'], true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, $lang['deleteposts'], true), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, $lang['postinhtml'], true), "</td>\n";
            echo "                                      <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, $lang['postasignature'], true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"2\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, $lang['moderatefolder'], false), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("add_group", $lang['addemptygroup']), "&nbsp;", form_submit("add_users", $lang['adduserstogroup']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>