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

/* $Id: pm_write.php,v 1.18 2003-08-26 18:40:22 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Get the Message ID (MID)

if (isset($HTTP_GET_VARS['replyto'])) {
    $mid = $HTTP_GET_VARS['replyto'];
}elseif (isset($HTTP_POST_VARS['replyto'])) {
    $mid = $HTTP_POST_VARS['replyto'];
}

if (isset($mid) && !($pm_elements_array = pm_single_get($mid, PM_FOLDER_INBOX, bh_session_get_value('UID')))) {
    html_draw_top();
    pm_error_refuse();
    html_draw_bottom();
    exit;
}

require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");
require_once("./include/email.inc.php");
require_once("./include/attachments.inc.php");

// User clicked cancel

if (isset($HTTP_POST_VARS['cancel'])) {
    if (isset($mid)) {
        $uri = "./pm.php?mid=$mid";
    }else {
        $uri = "./pm.php";
    }
    header_redirect($uri);
}

// Assume everything is correct (form input, etc)

$valid = true;

// Check to see if the PM is a reply and modify the subject line

if (isset($mid)) {

    if ($pm_data = pm_single_get($mid, PM_FOLDER_INBOX)) {
        if (!isset($HTTP_POST_VARS['t_subject']) || trim($HTTP_POST_VARS['t_subject']) == "") {
            $t_subject = $pm_data['SUBJECT'];
            if (strtoupper(substr($t_subject, 0, 3)) != "RE:") {
                $t_subject = "RE:". $t_subject;
            }
        }
    }
}

// HTML tickbox

if (isset($HTTP_POST_VARS['t_post_html'])) {
    $t_post_html = "Y";
}

// Fetch the TO_UID value

if (isset($HTTP_POST_VARS['t_to_uid'])) {
    $t_to_uid = $HTTP_POST_VARS['t_to_uid'];
}elseif (isset($HTTP_GET_VARS['uid'])) {
    $t_to_uid = $HTTP_GET_VARS['uid'];
}elseif (isset($mid)) {
    $t_to_uid = pm_get_user($mid);
}else {
    $t_to_uid = 0;
}

// 'Other' Button was used to specify a username

if (substr($t_to_uid, 0, 2) == "U:") {

    $u_login = substr($HTTP_POST_VARS['t_to_uid'], 2);

    if ($touser = user_get($u_login)) {

        $HTTP_POST_VARS['t_to_uid'] = $touser['UID'];
        $t_to_uid = $touser['UID'];

    }else{

        $error_html = "<h2>{$lang['invalidusername']}</h2>";
        $valid = false;

    }
}

// User clicked the submit button - check the data that was submitted

if (isset($HTTP_POST_VARS['submit']) || isset($HTTP_POST_VARS['preview'])) {

    if (isset($HTTP_POST_VARS['t_subject']) && trim($HTTP_POST_VARS['t_subject']) != "") {
        $t_subject = trim($HTTP_POST_VARS['t_subject']);
    }else {
        $error_html = "<h2>{$lang['entersubjectformessage']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['t_content']) && trim($HTTP_POST_VARS['t_content']) != "") {
        $t_content = $HTTP_POST_VARS['t_content'];
    }else {
        $error_html = "<h2>{$lang['entercontentformessage']}</h2>";
        $valid = false;
    }
}

// Required variables - make sure they are initialised

$t_content = isset($t_content) ? _stripslashes($t_content) : "";
$t_subject = isset($t_subject) ? _stripslashes($t_subject) : "";
$t_post_html = isset($t_post_html) ? $t_post_html : "";

// Process the data based on what we know.

if ($valid) {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = fix_html($t_content);
    }

}else {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = _stripslashes($t_content);
    }
}


// Send the PM

if ($valid && isset($HTTP_POST_VARS['submit'])) {

    if (check_ddkey($HTTP_POST_VARS['t_dedupe'])) {

        $t_subject = _htmlentities($t_subject);

        if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
            $t_content = make_html($t_content);
        }

        if ($new_mid = pm_send_message($t_to_uid, $t_subject, $t_content)) {
            if (isset($HTTP_POST_VARS['aid']) && get_num_attachments($HTTP_POST_VARS['aid']) > 0) {
                pm_save_attachment_id($new_mid, $HTTP_POST_VARS['aid']);
            }
            email_send_pm_notification($t_to_uid, $new_mid, bh_session_get_value('UID'));
        }else {
            $error_html = "<h2>{$lang['errorcreatingpm']}</h2>";
            $valid = false;
        }
    }
    if (isset($mid)){
        $uri = "./pm.php?mid=$mid";
    }else {
        $uri = "./pm.php";
    }
    header_redirect($uri);
}

html_draw_top("openprofile.js");
draw_header_pm();

// Attachment Unique ID

if (!isset($HTTP_POST_VARS['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $HTTP_POST_VARS['aid'];
}

// User clicked the Convert button.

if ($valid && isset($HTTP_POST_VARS['convert_html'])) {

   $t_content = nl2br(_htmlentities(_stripslashes($t_content)));
   $t_post_html = "Y";

}

// preview message

if ($valid && isset($HTTP_POST_VARS['preview'])) {

    echo "<h1>{$lang['privatemessages']}: {$lang['messagepreview']}</h1>\n";
    echo "<br />\n";

    if ($t_to_uid == 0) {

        $pm_preview_array['TLOGON'] = "ALL";
        $pm_preview_array['TNICK']  = "ALL";
        $pm_preview_array['TO_UID'] = 0;

    }else{

        $preview_tuser = user_get($t_to_uid);

        $pm_preview_array['TLOGON'] = $preview_tuser['LOGON'];
        $pm_preview_array['TNICK']  = $preview_tuser['NICKNAME'];
        $pm_preview_array['TO_UID'] = $preview_tuser['UID'];

    }

    $preview_fuser = user_get(bh_session_get_value('UID'));

    $pm_preview_array['FLOGON'] = $preview_fuser['LOGON'];
    $pm_preview_array['FNICK']  = $preview_fuser['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_fuser['UID'];

    $pm_preview_array['SUBJECT'] = _htmlentities($t_subject);
    $pm_preview_array['CREATED'] = mktime();
    $pm_preview_array['AID'] = $aid;

    $pm_preview_array['FOLDER'] = PM_FOLDER_OUTBOX;

    if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
        $pm_preview_array['CONTENT'] = make_html($t_content);
    }else {
        $pm_preview_array['CONTENT'] = $t_content;
    }

    draw_pm_message($pm_preview_array);
    echo "<br />\n";

}

echo "<h1>{$lang['privatemessages']}: {$lang['writepm']}</h1>\n";
echo "<div align=\"right\"><a href=\"pm.php\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a></div><br />\n";

if ($valid == false) {
    echo $error_html;
}

if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
    $t_content = isset($t_content) ? _stripslashes($t_content) : "";
}

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo "<table width=\"480\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
echo "          <td>", form_field("t_subject", isset($t_subject) ? _htmlentities(_stripslashes($t_subject)) : "", 32), "&nbsp;", form_submit("submit", $lang['post']), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td align=\"right\">{$lang['to']}: </td>\n";
echo "          <td>", pm_draw_to_dropdown($t_to_uid), "&nbsp;", form_button("others", $lang['others'], "onclick=\"javascript:launchOthers()\""), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>".form_textarea("t_content", isset($t_content) ? _htmlentities($t_content) : "", 15, 72). "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><span class=\"bhinputcheckbox\">", form_checkbox('t_post_html', 'Y', $lang['messagecontainsHTML'], ($t_post_html == 'Y')), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', $lang['post']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
echo form_submit('cancel', $lang['cancel']);

if ($attachments_enabled && $pm_allow_attachments) {
    echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>".form_button("attachments", $lang['attachments'], "onclick=\"attachwin = window.open('attachments.php?aid=". $aid. "', 'attachments', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
    echo form_input_hidden("aid", $aid);
}

echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>".form_submit("convert_html", $lang['converttoHTML']);

if (isset($HTTP_POST_VARS['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $HTTP_POST_VARS['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

echo "</form>\n";

if (isset($mid)) {
    echo "<p>in reply to:</p>";
    draw_pm_message($pm_elements_array);
}

html_draw_bottom ();

?>