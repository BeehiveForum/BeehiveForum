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

/* $Id: edit_signature.php,v 1.29 2004-04-26 11:21:08 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/attachments.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/htmltools.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['sig_content']) && trim($_POST['sig_content']) != "") {
        $t_sig_content = _stripslashes(trim($_POST['sig_content']));
    }else {
        $t_sig_content = "";
    }

    if (isset($_POST['sig_html']) && $_POST['sig_html'] == "Y") {
        $t_sig_html = "Y";
    }else {
        $t_sig_html = "N";
    }

	// Check the signature code to see if it needs running through fix_html
	if ($t_sig_html == "Y") {
		$t_sig_content = fix_html($t_sig_content);

	}else {
		$t_sig_content = _stripslashes($t_sig_content);
	}

	// If nothing's changed, don't update
	if (isset($_POST['sig_content_old']) && $t_sig_content == $_POST['sig_content_old'] &&
		isset($_POST['sig_html_old']) && $t_sig_html == $_POST['sig_html_old']) {
		$valid = false;
	}

    if (attachment_embed_check($t_sig_content) && $t_sig_html == "Y") {
        $error_html.= "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update USER_SIG

        user_update_sig($uid, $t_sig_content, $t_sig_html);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./edit_signature.php?webtag=$webtag&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './edit_signature.php?webtag=$webtag&amp;updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['preferencesupdated']}</p>";

            form_quick_button("./edit_signature.php", $lang['continue'], false, false, "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Get the User's Signature

user_get_sig(bh_session_get_value('UID'), $user_sig['SIG_CONTENT'], $user_sig['SIG_HTML']);

// Start Output Here

html_draw_top("htmltools.js");

echo "<h1>{$lang['editsignature']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

$tools = new TextAreaHTML("prefs");

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_signature.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['signature']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>\n";

echo $tools->toolbar();

$sig_code = (isset($t_sig_content) ? _htmlentities(_stripslashes($t_sig_content)) : _htmlentities(_stripslashes($user_sig['SIG_CONTENT'])));

echo $tools->textarea("sig_content", $sig_code, 5, 0, "virtual", "tabindex=\"7\" style=\"width: 480px\"")."</td>\n";

echo form_input_hidden("sig_content_old", $sig_code)."\n";

echo $tools->js();

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"right\">\n";

$sig_html = (isset($t_sig_html) && $t_sig_html == "Y") ? true : ($user_sig['SIG_HTML'] == "Y");
echo form_checkbox("sig_html", "Y", $lang['containsHTML'], $sig_html);

echo form_input_hidden("sig_html_old", ($sig_html == true) ? "Y" : "N")."\n";

echo $tools->assign_checkbox("sig_html");

echo "					</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>