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

/* $Id: admin_startpage.php,v 1.53 2004-05-15 14:43:41 decoyduck Exp $ */

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
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/htmltools.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
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

if (!(perm_has_admin_access())) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;

}

$allowed_file_exts = array('html', 'htm', 'shtml', 'cgi', 'pl', 'php', 'php3', 'phtml', 'txt');

html_draw_top("htmltools.js");

echo "<h1>{$lang['admin']} : {$lang['editstartpage']}</h1>\n";
echo "<p>{$lang['editstartpageexp']}</p>\n";

if (isset($_POST['submit'])) {

    $content = _stripslashes($_POST['content']);
    save_start_page($content);

    $status_text = "<p><b>{$lang['startpageupdated']}</b> ";
    $status_text.= "<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">";
    $status_text.= "{$lang['viewupdatedstartpage']}</a></p>";

    admin_addlog(0, 0, 0, 0, 0, 0, 16);

}elseif (isset($_POST['upload'])) {

    if (isset($_FILES['userfile']['tmp_name']) && strlen(trim($_FILES['userfile']['tmp_name'])) > 0) {

        $path_parts = pathinfo($_FILES['userfile']['tmp_name']);

        if (in_array($path_parts['extension'], $allowed_file_exts)) {

            if (@move_uploaded_file($_FILES['userfile']['tmp_name'], "forums/$webtag/start_main.php")) {

                $content = load_start_page();

                $status_text = "<p><b>{$lang['startpageupdated']}</b> ";
                $status_text.= "<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">";
                $status_text.= "{$lang['viewupdatedstartpage']}</a></p>";

                admin_addlog(0, 0, 0, 0, 0, 0, 16);

            }else {

                $status_text = "<h2>{$lang['uploadfailed']}: {$_FILES['userfile']['name']}</h2>\n";
            }

        }else {

            $status_text = "<h2>{$lang['uploadfailed']}: {$_FILES['userfile']['name']}</h2>\n";
        }
    }
}


$content = load_start_page();

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
echo "                  <td>", $tools->textarea('content', _htmlentities($content), 20, 80, 'off', 'style="font-family: monospace"'), "</td>\n";
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