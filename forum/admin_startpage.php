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

/* $Id: admin_startpage.php,v 1.64 2005-03-14 13:27:15 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
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

if (!(perm_has_admin_access())) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;

}

$allowed_file_exts = array('html', 'htm', 'shtml', 'cgi', 'pl', 'php', 'php3', 'phtml', 'txt');

if (isset($_POST['submit'])) {

    if (isset($_POST['content']) && strlen(trim(_stripslashes($_POST['content']))) > 0) {
        $content = trim(_stripslashes($_POST['content']));
    }else {
        $content = "";
    }

    if (forum_save_start_page($content)) {

        $status_text = "<p><b>{$lang['startpageupdated']}</b> ";
        $status_text.= "<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">";
        $status_text.= "{$lang['viewupdatedstartpage']}</a></p>";

        admin_add_log_entry(EDITED_START_PAGE);

    }else {

        $length = strlen($content);

        header("Content-Type: application/x-ms-download", true);
        header("Content-Length: $length", true);
        header("Content-disposition: attachment; filename=\"start_main.php\"", true);
        echo $content;
        exit;
    }

}elseif (isset($_POST['upload'])) {

    if (isset($_FILES['userfile']['tmp_name']) && strlen(trim($_FILES['userfile']['tmp_name'])) > 0) {

        $path_parts = pathinfo($_FILES['userfile']['tmp_name']);

        if (isset($path_parts['extension']) && in_array($path_parts['extension'], $allowed_file_exts)) {

            if (@move_uploaded_file($_FILES['userfile']['tmp_name'], "forums/$webtag/start_main.php")) {

                $content = forum_load_start_page();

                $status_text = "<p><b>{$lang['startpageupdated']}</b> ";
                $status_text.= "<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">";
                $status_text.= "{$lang['viewupdatedstartpage']}</a></p>";

                admin_add_log_entry(EDITED_START_PAGE);

            }else {

                $status_text = "<h2>{$lang['uploadfailed']}: {$_FILES['userfile']['name']}</h2>\n";
            }

        }else {

            $status_text = "<h2>{$lang['uploadfailed']}: {$_FILES['userfile']['name']}</h2>\n";
        }
    }
}

html_draw_top("dictionary.js", "htmltools.js");

echo "<h1>{$lang['admin']} : {$lang['editstartpage']}</h1>\n";
echo "<p>{$lang['editstartpageexp']}</p>\n";

$content = forum_load_start_page();

if (isset($status_text)) echo $status_text;

$tools = new TextAreaHTML("startpage");

echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"admin_startpage.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td>", $tools->toolbar(true, form_submit('submit', $lang['save'])), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", $tools->textarea("content", _htmlentities($content), 20, 80, "off", "", "admin_startpage_textarea"), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_reset(), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['uploadstartpage']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['filename']}: ", form_field("userfile", "", 45, 0, "file"), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("upload", $lang['upload']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

echo "</form>\n";

echo $tools->js();

html_draw_bottom();

?>