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

/* $Id: email.php,v 1.60 2005-03-13 20:15:28 decoyduck Exp $ */

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
$forum_settings = forum_get_settings();

include_once("./include/email.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['cancel'])) {
    $uri = "./user_profile.php?webtag=$webtag&uid=". $_POST['t_to_uid'];
    header_redirect($uri);
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $to_uid = $_GET['uid'];
}else if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
    $to_uid = $_POST['t_to_uid'];
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nouserspecifiedforemail']}</h2>";
    html_draw_bottom();
    exit;
}

$to_user = user_get($to_uid);
$from_user = user_get(bh_session_get_value('UID'));

if (isset($_POST['submit'])) {

    $valid = true;

    $message = _stripslashes($_POST['t_message']);

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {
        $subject = trim(_stripslashes($_POST['t_subject']));
    }else {
        $error = "<h2>{$lang['entersubjectformessage']}:</h2>";
        $valid = false;
    }

    if (isset($_POST['t_message']) && strlen(trim(_stripslashes($_POST['t_message']))) > 0) {
        $message = trim(_stripslashes($_POST['t_message']));
    }else {
        $error = "<h2>{$lang['entercontentformessage']}:</h2>";
        $valid = false;
    }

    if (!user_allow_email($to_user['UID'])) {
        $error = "<h2>{$lang['user']} {$to_user['LOGON']} {$lang['hasoptedoutofemail']}</h2>\n";
        $valid = false;
    }

    if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) {
        $error = "<h2>{$lang['user']} {$to_user['LOGON']} {$lang['hasinvalidemailaddress']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        $email_lang = email_get_language($to_user['UID']);

        $message = wordwrap($message . "\n\n{$lang['msgsentfrombeehiveforumby']} ".$from_user['LOGON']);

        $header = "From: \"{$from_user['NICKNAME']}\" <{$from_user['EMAIL']}>\n";
        $header.= "Reply-To: \"{$from_user['NICKNAME']}\" <{$from_user['EMAIL']}>\n";
        $header.= "Content-type: text/plain; charset={$email_lang['_charset']}\n";
        $header.= "X-Mailer: PHP/". phpversion();

        html_draw_top("title={$lang['emailresult']}");

        echo "<p>&nbsp;</p>\n";
        echo "<div align=\"center\">\n";

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) {
            echo "<p>{$lang['msgsent']}.</p>";
        }else {
            echo "<p>{$lang['msgfail']}</p>";
        }

        form_quick_button("./user_profile.php", $lang['continue'], "uid", $to_uid);
        html_draw_bottom();
        exit;
    }
}

html_draw_top("{$lang['email']} ".$to_user['LOGON']);

if (isset($error)) echo $error;

if (!isset($subject)) $subject = "";
if (!isset($message)) $message = "";

echo "<div align=\"center\">\n";
echo "  <form name=\"f_email\" action=\"email.php\" method=\"post\">\n";
echo "    ", form_input_hidden('webtag', $webtag), "\n";
echo "    ", form_input_hidden("t_to_uid", $to_uid), "\n";
echo "    <table width=\"480\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table width=\"100%\" class=\"subhead\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "            <tr>\n";
echo "              <td><h2>&nbsp;{$lang['email']}&nbsp;{$to_user['NICKNAME']}</h2></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table width=\"100%\" class=\"posthead\" border=\"0\">\n";
echo "            <tr>\n";
echo "              <td>\n";
echo "                <table width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" width=\"25%\">{$lang['from']}:</td>\n";
echo "                    <td class=\"posthead\">{$from_user['NICKNAME']} ({$from_user['EMAIL']})</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\">{$lang['subject']}:</td>\n";
echo "                    <td class=\"posthead\">", form_field("t_subject", $subject, 54, 128), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" valign=\"top\">{$lang['message']}:</td>\n";
echo "                    <td class=\"posthead\">", form_textarea("t_message", $message, 12, 51), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                    <td class=\"posthead\" align=\"right\">", form_submit("submit", $lang['send']), "&nbsp;", form_submit("cancel", $lang['cancel']), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>