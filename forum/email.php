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

if (isset($HTTP_GET_VARS['uid'])) {
    $to_uid = $HTTP_GET_VARS['uid'];
}else if(isset($HTTP_POST_VARS['t_to_uid'])){
    $to_uid = $HTTP_POST_VARS['t_to_uid'];
}else {
  html_draw_top();
  echo "<h1>Invalid Operation</h1>\n";
  echo "<h2>No user specified for emailing.</h2>";
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
        $error = "<p>Enter a subject for the message:</p>";
        $valid = false;
    }

    if ($valid && !$message) {
        $error = "<p>Enter some content for the message:</p>";
        $valid = false;
    }

    if ($valid) {

        $message = wordwrap($message . "\n\nThis message was sent from a Beehive Forum by ".$from_user['LOGON']);
        $from = "From: ".$from_user['EMAIL'];

        html_draw_top("Email result");

        echo "<p>&nbsp;</p>\n";
        echo "<div align=\"center\">\n";

        if (@mail($to_user['EMAIL'],$subject,$message,$from)) {
            echo "<p>Message sent.</p>";
        }else {
            echo "<p>Mail system failure. Message not sent</p>";
        }

        echo "<a href=\"./user_profile.php?uid=", $HTTP_POST_VARS['t_to_uid'], "\">Continue</a>";
        html_draw_bottom();
        exit;

    }
}

html_draw_top("Email ".$to_user['LOGON']);

echo "<h1>Email ".$to_user['LOGON']."</h1>\n";

if (isset($error)) echo $error;

if (!isset($subject)) $subject = "";
if (!isset($message)) $message = "";

echo "<div align=\"center\">";
echo "<form name=\"f_email\" action=\"".$HTTP_SERVER_VARS['PHP_SELF']."\" method=\"POST\">\n";
echo "<table border=\"0\" width=\"96%\">\n";
echo "<tr><td class=\"subhead\">From:</td>\n";
echo "<td class=\"posthead\">".$from_user['EMAIL']."</td></tr>\n";
echo "<tr><td class=\"subhead\">Subject:</td>\n";
echo "<td class=\"posthead\">".form_field("t_subject",$subject,32,128)."</td></tr>\n";
echo "<tr><td class=\"subhead\" valign=\"top\">Message:</td>\n";
echo "<td class=\"posthead\">".form_textarea("t_message",$message,8,32)."</td></tr>\n";
echo "<tr><td class=\"subhead\">&nbsp;</td>\n";
echo "<td class=\"posthead\" align=\"right\">\n";
echo form_field("t_to_uid",$to_uid,0,0,"hidden");
echo form_submit("submit","Send")."\n";
echo form_submit("cancel","Cancel")."\n";
echo "</tr></table>\n";
echo "</form>";
echo "</div>\n";

html_draw_bottom();

?>