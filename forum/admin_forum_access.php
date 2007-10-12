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

/* $Id: admin_forum_access.php,v 1.60 2007-10-12 23:28:11 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
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

if (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = trim(_stripslashes($_POST['ret']));
}elseif (isset($_GET['ret']) && strlen(trim(_stripslashes($_GET['ret']))) > 0) {
    $ret = trim(_stripslashes($_GET['ret']));
}else {
    $ret = "admin_forums.php?webtag=$webtag";
}

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/", basename($ret)) < 1) {
        $ret = "./admin_forums.php?webtag=$webtag";
    }
}

if (isset($_POST['back'])) {
    header_redirect($ret);
}

if (!forum_get_setting('access_level', 1, false)) {

    html_draw_top();
    html_error_msg($lang['forumisnotrestricted'], 'admin_forum_access.php', 'post', array('back' => $lang['back']), array('ret' => $ret));
    html_draw_bottom();
    exit;
}

if (!$fid = forum_get_setting('fid')) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['user_search']) && strlen(trim(_stripslashes($_POST['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_POST['user_search']));
}else if (isset($_GET['user_search']) && strlen(trim(_stripslashes($_GET['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_GET['user_search']));
}else {
    $user_search = '';
}

if (isset($_POST['clear'])) {
    $user_search = '';
}

if (isset($_POST['add_searched_user'])) {

    $valid = true;

    if (isset($_POST['user_add']) && is_array($_POST['user_add'])) {

        foreach ($_POST['user_add'] as $user_add_uid) {

            if ($user_logon = user_get_logon($user_add_uid)) {

                $user_update_array = array($fid => 1);

                if (user_update_forums($user_add_uid, $user_update_array)) {

                    $forum_name = forum_get_name($fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                }else {

                    $error_msg_array[] = sprintf($lang['failedtoaddpermissionsforuser'], $user_logon);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            $ret = rawurlencode($ret);
            $user_search = rawurlencode($user_search);

            header_redirect("admin_forum_access.php?webtag=$webtag&user_search=$user_search&ret=$ret&added=true");
            exit;
        }
    }

}elseif (isset($_POST['remove_user'])) {

    $valid = true;

    if (isset($_POST['user_remove']) && is_array($_POST['user_remove'])) {

        foreach ($_POST['user_remove'] as $user_remove_uid) {

            if ($user_logon = user_get_logon($user_remove_uid)) {

                $user_update_array = array($fid => 0);

                if (user_update_forums($user_remove_uid, $user_update_array)) {

                    $forum_name = forum_get_name($fid);
                    admin_add_log_entry(CHANGE_FORUM_ACCESS, array($forum_name, $user_logon));

                }else {

                    $error_msg_array[] = sprintf($lang['failedtoremovepermissionsfromuser'], $user_logon);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            $ret = rawurlencode($ret);
            $user_search = rawurlencode($user_search);

            header_redirect("admin_forum_access.php?webtag=$webtag&user_search=$user_search&ret=$ret&removed=true");
            exit;
        }
    }
}

html_draw_top();

$user_permissions_array = forum_get_permissions($fid);

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageforumpermissions']}</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg($lang['successfullyaddedpermissionsforselectedusers'], '500', 'center');

}else if (isset($_GET['removed'])) {

    html_display_success_msg($lang['successfullyremovedpermissionsfromselectedusers'], '500', 'center');

}else if (sizeof($user_permissions_array) < 1) {

    html_display_warning_msg($lang['nousershavebeengrantedpermission'], '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_user\" action=\"admin_forum_access.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('ret', _htmlentities($ret)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['existingpermissions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (sizeof($user_permissions_array) > 0) {

    foreach ($user_permissions_array as $user_permission) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("user_remove[]", $user_permission['UID'], ''), "&nbsp;", word_filter_add_ob_tags(_htmlentities(format_user_name($user_permission['LOGON'], $user_permission['NICKNAME']))), "</td>\n";
        echo "                      </tr>\n";
    }

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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('remove_user', $lang['removeselectedusers']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";

}else {

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

if (strlen($user_search) > 0) {

    $user_search_array = admin_user_search($user_search);

    if (sizeof($user_search_array['user_array']) < 1) {
        html_display_warning_msg($lang['searchreturnednoresults'], '500', 'center');
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchresults']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";

    if (sizeof($user_search_array['user_array']) > 0) {

        foreach ($user_search_array['user_array'] as $user_search_result) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">", form_checkbox("user_add[]", $user_search_result['UID'], ''), "&nbsp;", word_filter_add_ob_tags(_htmlentities(format_user_name($user_search_result['LOGON'], $user_search_result['NICKNAME']))), "</td>\n";
            echo "                      </tr>\n";
        }

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
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit('add_searched_user', $lang['addselectedusers']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  <br />\n";

    }else {

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
        echo "      </tr>\n";
        echo "    </td>\n";
        echo "  </table>\n";
        echo "  <br />\n";
    }
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforuser']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['search']}: ", form_input_text('user_search', _htmlentities($user_search), 32, 15), "&nbsp;", form_submit('search', $lang['search']), "&nbsp;", form_submit('clear', $lang['clear']), "</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>