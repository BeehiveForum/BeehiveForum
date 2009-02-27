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

/* $Id: admin_startpage.php,v 1.117 2009-02-27 13:35:11 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

$lang = lang::get_instance()->load(__FILE__);

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Path to the Forum folder for saving start page.

$forum_path = dirname($_SERVER['PHP_SELF']);
$forum_path.= "/forums/$webtag/";

// Make sure the directory structure exists

mkdir_recursive("forums/$webtag", 0755);

// Check to see if we're submitting new page or retrieving the old one.

if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {
    $t_content = trim(stripslashes_array($_POST['t_content']));
}else {
    $t_content = forum_load_start_page();
}

// Create a new instance of the Beehive editor.

$start_page = new MessageText(POST_HTML_ENABLED, $t_content, true, true);

// Get the clean content.

$t_content = $start_page->getContent();

// Submit code.

if (isset($_POST['save'])) {

    if (forum_save_start_page($t_content)) {

        admin_add_log_entry(EDITED_START_PAGE);
        header_redirect("admin_startpage.php?webtag=$webtag&updated=true");
        exit;

    }else {

        html_draw_top();
        html_error_msg(sprintf($lang['startpageerror'], $forum_path), 'admin_startpage.php', 'post', array('download' => $lang['download'], 'back' => $lang['back']), array('t_content' => $t_content), false, 'center');
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['upload'])) {

    if (isset($_FILES['cssfile']['tmp_name']) && strlen(trim($_FILES['cssfile']['tmp_name'])) > 0) {

        if (isset($_FILES['cssfile']['error']) && $_FILES['cssfile']['error'] > 0) {

            html_draw_top();
            html_error_msg(sprintf($lang['uploadcssfilefailed'], $forum_path), 'admin_startpage.php', 'post', array('back' => $lang['back']), false, false, 'center');
            html_draw_bottom();
            exit;

        }else if (isset($_FILES['cssfile']['type']) && trim(stripslashes_array($_FILES['cssfile']['type'])) == 'text/css') {

            $path_parts = pathinfo($_FILES['cssfile']['name']);

            if ((isset($path_parts['extension']) && $path_parts['extension'] == 'css')) {

                if (@move_uploaded_file($_FILES['cssfile']['tmp_name'], "forums/$webtag/start_main_additional.css")) {

                    admin_add_log_entry(EDITED_START_PAGE);
                    header_redirect("admin_startpage.php?webtag=$webtag&uploaded=true");
                    exit;

                }else {

                    html_draw_top();
                    html_error_msg(sprintf($lang['uploadcssfilefailed'], $forum_path), 'admin_startpage.php', 'post', array('back' => $lang['back']), false, false, 'center');
                    html_draw_bottom();
                    exit;
                }
            }
        }

        $error_msg_array[] = $lang['invalidfiletypeerror'];
    }

}else if (isset($_POST['download'])) {

    $content_length = mb_strlen($t_content);

    header("Content-Type: application/x-ms-download", true);
    header("Content-Length: $content_length", true);
    header("Content-disposition: attachment; filename=\"start_main.php\"", true);
    echo $t_content;
    exit;
}

html_draw_top("onunload=clearFocus()", "dictionary.js", "htmltools.js");

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['editstartpage']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}elseif (isset($_GET['updated'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", $lang['viewupdatedstartpage']);
    html_display_success_msg(sprintf($lang['startpageupdated'], $start_page_link), '600', 'center');

}elseif (isset($_GET['uploaded'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", $lang['viewupdatedstartpage']);
    html_display_success_msg(sprintf($lang['cssfileuploaded'], $start_page_link), '600', 'center');
}

$tools = new TextAreaHTML("startpage");
echo $tools->preload();

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"startpage\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin_startpage.php\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['startpage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $tools->toolbar(true, form_submit('save', $lang['save'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $tools->textarea("t_content", $t_content, 20, 85, "", "admin_startpage_textarea"), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("download", $lang['download']), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">{$lang['uploadcssfile']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['filename']}: ", form_input_file("cssfile", "", 45, 0), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("upload", $lang['upload']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo $tools->js(false);
echo "</div>\n";

html_draw_bottom();

?>