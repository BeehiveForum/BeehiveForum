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

/* $Id: email.php,v 1.20 2003-08-26 18:31:03 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/html.inc.php");
require_once("./include/format.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if(bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if(isset($HTTP_POST_VARS['cancel'])){
    $uri = "./user_profile.php?uid=". $HTTP_POST_VARS['t_to_uid'];
    header_redirect($uri);
}

require_once("./include/user.inc.php");
require_once("./include/form.inc.php");
require_once("./include/format.inc.php");
require_once("./include/lang.inc.php");

if (isset($HTTP_GET_VARS['uid'])) {
    $to_uid = $HTTP_GET_VARS['uid'];
}else if(isset($HTTP_POST_VARS['t_to_uid'])){
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
    $subject = _stripslashes($HTTP_POST_VARS['t_subject']);
    $message = _stripslashes($HTTP_POST_VARS['t_message']);

    if (!$subject) {
        $error = "<p>{$lang['entersubjectformessage']}:</p>";
        $valid = false;
    }

    if ($valid && !$message) {
        $error = "<p>{$lang['entercontentformessage']}:</p>";
        $valid = false;
    }

    if ($valid) {

        $message = wordwrap($message . "\n\n{$lang['msgsentfrombeehiveforumby']} ".$from_user['LOGON']);
        $from = "From: ".$from_user['EMAIL'];

        html_draw_top("title={$lang['emailresult']}");

        echo "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";
        echo "<div align=\"center\">\n";

        if (@mail($to_user['EMAIL'],$subject,$message,$from)) {
            echo "<p>{$lang['msgsent']}.</p>";
        }else {
            echo "<p>{$lang['msgfail']}</p>";
        }

        echo "<a href=\"./user_profile.php?uid=", $HTTP_POST_VARS['t_to_uid'], "\">{$lang['continue']}</a>";
        html_draw_bottom();
        exit;

    }
}

html_draw_top("{$lang['email']} ".$to_user['LOGON']);

if (isset($error)) echo $error;

if (!isset($subject)) $subject = "";
if (!isset($message)) $message = "";

echo "<div align=\"center\">\n";
echo "  <form name=\"f_email\" action=\"./email.php\" method=\"POST\">\n";
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