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

/* $Id: email.php,v 1.40 2004-03-27 21:56:18 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/email.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
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

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($HTTP_POST_VARS['cancel'])) {
    $uri = "./user_profile.php?webtag={$webtag['WEBTAG']}&uid=". $HTTP_POST_VARS['t_to_uid'];
    header_redirect($uri);
}

if (isset($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid'])) {
    $to_uid = $HTTP_GET_VARS['uid'];
}else if (isset($HTTP_POST_VARS['t_to_uid']) && is_numeric($HTTP_POST_VARS['t_to_uid'])) {
    $to_uid = $HTTP_POST_VARS['t_to_uid'];
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nouserspecifiedforemail']}</h2>";
    html_draw_bottom();
    exit;
}

$to_user = user_get($to_uid);
$from_user = user_get(bh_session_get_value('UID'));

if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;
    
    $message = _stripslashes($HTTP_POST_VARS['t_message']);

    if (isset($HTTP_POST_VARS['t_subject']) && strlen(trim(_stripslashes($HTTP_POST_VARS['t_subject']))) > 0) {
        $subject = trim(_stripslashes($HTTP_POST_VARS['t_subject']));
    }else {
        $error = "<p>{$lang['entersubjectformessage']}:</p>";
        $valid = false;
    }
    
    if (isset($HTTP_POST_VARS['t_message']) && strlen(trim(_stripslashes($HTTP_POST_VARS['t_message']))) > 0) {
        $message = trim(_stripslashes($HTTP_POST_VARS['t_message']));
    }else {
        $error = "<p>{$lang['entercontentformessage']}:</p>";
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
echo "  <form name=\"f_email\" action=\"email.php?webtag={$webtag['WEBTAG']}\" method=\"POST\">\n";
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