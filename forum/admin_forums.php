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

/* $Id: admin_forums.php,v 1.46 2006-06-30 18:07:32 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "myforums.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

html_draw_top();

if (!bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['changepermissions']) && is_array($_POST['changepermissions'])) {

    list($fid) = array_keys($_POST['changepermissions']);
    header_redirect("admin_forum_access.php?webtag=$webtag&fid=$fid");
    exit;

}elseif (isset($_POST['changepassword']) && is_array($_POST['changepassword'])) {

    list($fid) = array_keys($_POST['changepassword']);
    header_redirect("admin_forum_set_passwd.php?webtag=$webtag&fid=$fid");
    exit;

}elseif (isset($_POST['submit'])) {

    $valid = true;
    $message_html = "";

    if (isset($_POST['t_access']) && is_array($_POST['t_access'])) {

        foreach($_POST['t_access'] as $fid => $new_access) {

            forum_update_access($fid, $new_access);
        }
    }

    if (isset($_POST['t_webtag_new']) && strlen(trim(_stripslashes($_POST['t_webtag_new']))) > 0) {

        $new_webtag = strtoupper(trim(_stripslashes($_POST['t_webtag_new'])));

        if (!preg_match("/^[A-Z0-9_]+$/", $new_webtag)) {
            $message_html.= "<h2>{$lang['webtaginvalidchars']}</h2>\n";
            $valid = false;
        }

        if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
            $new_name = trim(_stripslashes($_POST['t_name_new']));
        }else {
            $new_name = "";
        }

        if (isset($_POST['t_access_new']) && is_numeric($_POST['t_access_new'])) {
            $new_access = $_POST['t_access_new'];
        }else {
            $new_access = 0;
        }

        if ($valid) {

            if ($new_fid = forum_create($new_webtag, $new_name, $new_access)) {
                $message_html = "<h2>{$lang['successfullycreatedforum']} '$new_webtag'</h2>\n";
            }else {
                $message_html = "<h2>{$lang['failedtocreateforum_1']} '$new_webtag'. {$lang['failedtocreateforum_2']}</h2>\n";
            }
        }
    }

}elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {

    $fid = $_GET['delete'];

    echo "<h1>{$lang['admin']} : {$lang['manageforums']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
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
    echo "                        <td>{$lang['forumdeletewarning']}</td>\n";
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
    echo "      <td align=\"center\">", form_submit("t_confirm_delete[$fid]", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;

}elseif (isset($_POST['t_confirm_delete'])) {

    list($fid) = array_keys($_POST['t_confirm_delete']);
    forum_delete($fid);

}elseif (isset($_GET['default']) && is_numeric($_GET['default'])) {

    $fid = $_GET['default'];
    forum_update_default($fid);
}

echo "<h1>{$lang['admin']} : {$lang['manageforums']}</h1>\n";
echo "<br />\n";

if (isset($message_html) && strlen($message_html) > 0) {
    echo $message_html;
    echo "<br />\n";
}

$forums_array = admin_get_forum_list();

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td>\n";

if (sizeof($forums_array) > 0) {

    echo "        <form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
    echo "        ", form_input_hidden('webtag', $webtag), "\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td>\n";
    echo "              <table class=\"box\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"posthead\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";
    echo "                      <tr>\n";
    echo "                        <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\" width=\"150\">&nbsp;{$lang['webtag']}</td>\n";
    echo "                        <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['name']}</td>\n";
    echo "                        <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['messages']}</td>\n";
    echo "                        <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['access']}</td>\n";
    echo "                        <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;</td>\n";
    echo "                      </tr>\n";

    foreach ($forums_array as $forum) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;<a href=\"index.php?webtag={$forum['WEBTAG']}\" target=\"_blank\">{$forum['WEBTAG']}</a></td>\n";
        echo "                        <td align=\"left\">&nbsp;{$forum['FORUM_NAME']}</td>\n";
        echo "                        <td align=\"left\">&nbsp;{$forum['MESSAGES']} Messages</td>\n";
        echo "                        <td align=\"left\">&nbsp;", form_dropdown_array("t_access[{$forum['FID']}]", array(-2, -1, 0, 1, 2), array($lang['disabled'], $lang['closed'], $lang['open'], $lang['restricted'], $lang['passwordprotected']), $forum['ACCESS_LEVEL']);

        if ($forum['ACCESS_LEVEL'] == 1) {

            echo "      &nbsp;", form_submit("changepermissions[{$forum['FID']}]", $lang['changepermissions']);

        }elseif ($forum['ACCESS_LEVEL'] == 2) {

            echo "      &nbsp;", form_submit("changepassword[{$forum['FID']}]", $lang['changepassword']);
        }

        echo "      </td>\n";

        if (isset($forum['DEFAULT_FORUM']) && $forum['DEFAULT_FORUM'] == 1) {
            echo "                        <td align=\"left\">&nbsp;<a href=\"admin_forum_settings.php?webtag={$forum['WEBTAG']}\" target=\"_self\"><img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['forumsettings']}\" title=\"{$lang['forumsettings']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&delete={$forum['FID']}\"><img src=\"", style_image('delete.png'), "\" border=\"0\" alt=\"{$lang['deleteforum']}\" title=\"{$lang['deleteforum']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&amp;default=0\"><img src=\"", style_image('default_forum.png'), "\" border=\"0\" alt=\"{$lang['unsetdefault']}\" title=\"{$lang['unsetdefault']}\" /></td>\n";
        }else {
            echo "                        <td align=\"left\">&nbsp;<a href=\"admin_forum_settings.php?webtag={$forum['WEBTAG']}\" target=\"_self\"><img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['forumsettings']}\" title=\"{$lang['forumsettings']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&delete={$forum['FID']}\"><img src=\"", style_image('delete.png'), "\" border=\"0\" alt=\"{$lang['deleteforum']}\" title=\"{$lang['deleteforum']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&amp;default={$forum['FID']}\"><img src=\"", style_image('set_default_forum.png'), "\" border=\"0\" alt=\"{$lang['makedefault']}\" title=\"{$lang['makedefault']}\" /></td>\n";
        }

        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td colspan=\"5\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td>&nbsp;</td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"center\">", form_submit("submit", $lang['savechanges']), "</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        </form>\n";
    echo "        <br />\n";
}

echo "        <form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
echo "        ", form_input_hidden('webtag', $webtag), "\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table class=\"box\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"subhead\">&nbsp;</td>\n";
echo "                        <td class=\"subhead\">&nbsp;{$lang['webtag']}</td>\n";
echo "                        <td class=\"subhead\">&nbsp;{$lang['name']}</td>\n";
echo "                        <td class=\"subhead\">&nbsp;{$lang['allow']}</td>\n";
echo "                        <td class=\"subhead\" width=\"50%\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>{$lang['newcaps']}</td>\n";
echo "                        <td>", form_input_text("t_webtag_new", "", 20, 32), "</td>\n";
echo "                        <td>", form_input_text("t_name_new", "", 45, 255), "</td>\n";
echo "                        <td>", form_dropdown_array("t_access_new", array(-1, 0, 1), array($lang['closed'], $lang['open'], $lang['restricted']), 0), "</td>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"5\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"center\">", form_submit("submit", $lang['add']), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";;
echo "</div>\n";

html_draw_bottom();

?>