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

/* $Id: pm_edit.php,v 1.18 2004-03-11 22:34:36 decoyduck Exp $ */

//Multiple forum support
include_once("./include/forum.inc.php");

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Check logged in status
include_once("./include/session.inc.php");
include_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

include_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

include_once("./include/user.inc.php");
include_once("./include/post.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/email.inc.php");
include_once("./include/attachments.inc.php");

// Get the Message ID (MID)

if (isset($HTTP_GET_VARS['mid']) && is_numeric($HTTP_GET_VARS['mid'])) {
    $mid = $HTTP_GET_VARS['mid'];
}elseif (isset($HTTP_POST_VARS['mid']) && is_numeric($HTTP_POST_VARS['mid'])) {
    $mid = $HTTP_POST_VARS['mid'];
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>";
    html_draw_bottom();
    exit;
}

// User clicked cancel

if (isset($HTTP_POST_VARS['cancel'])) {
    header_redirect("./pm.php?webtag=$webtag&folder=2");
}

$valid = true;

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

// Update the PM

if ($valid && isset($HTTP_POST_VARS['preview'])) {

    $edit_html = ($HTTP_POST_VARS['t_post_html'] == "Y");

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {

        if ($HTTP_POST_VARS['t_post_html'] == "Y") {
            $t_content = fix_html($t_content);
            $pm_elements_array['CONTENT'] = $t_content;
            $t_content = str_replace("&", "&amp;", $t_content);
        }else{
            $t_content = make_html($t_content);
            $pm_elements_array['CONTENT'] = $t_content;
            $t_content = strip_tags($t_content);
        }

        $pm_elements_array['SUBJECT'] = _htmlentities($t_subject);
        $pm_elements_array['FOLDER'] = PM_FOLDER_OUTBOX;

    }else {
        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

}else if ($valid && isset($HTTP_POST_VARS['submit'])) {

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {

        $t_subject = _htmlentities($t_subject);

        if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
            $t_content = make_html($t_content);
        }
                
        if (isset($HTTP_POST_VARS['aid']) && isset($attachments_enabled) && $attachments_enabled) {
            if (get_num_attachments($HTTP_POST_VARS['aid']) > 0) pm_save_attachment_id($mid, $HTTP_POST_VARS['aid']);
        }         

        if (pm_edit_message($mid, $t_subject, $t_content)) {
            header_redirect("pm.php?webtag=$webtag&folder=2");
        }else {
            $error_html = "<h2>{$lang['errorcreatingpm']}</h2>";
            $valid = false;
        }

    }else {
        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

}else {

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {

        if ($pm_elements_array['TYPE'] <> PM_NEW) {
            html_draw_top();
            pm_edit_refuse();
            html_draw_bottom();
            exit;
        }

        $edit_html = isset($HTTP_POST_VARS['b_edit_html']);
        $t_content = $pm_elements_array['CONTENT'];
        $t_subject = $pm_elements_array['SUBJECT'];

        if (!isset($HTTP_POST_VARS['b_edit_html'])) {
            $t_content = str_replace("\n", "", $t_content);
            $t_content = str_replace("\r", "", $t_content);
            $t_content = str_replace("<p>", "\n<p>", $t_content);
            $t_content = str_replace("</p>", "</p>\n", $t_content);
            $t_content = ereg_replace("^\n\n<p>", "<p>", $t_content);
            $t_content = ereg_replace("<br[[:space:]*]/>", "\n", $t_content);
            $t_content = strip_tags($t_content);
        }else{
            $t_content = _htmlentities($t_content);
        }

    }else {
        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }
}

html_draw_top("openprofile.js", "edit.js", "basetarget=_blank");
draw_header_pm();

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\" height=\"20\">\n";
echo "  <tr>\n";
echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['editpm']}</b></td>\n";
echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>&nbsp;</p>\n";

if ($valid == false) {
    echo $error_html;
}

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('mid', $mid), "\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
echo "          <td>", form_field("t_subject", isset($t_subject) ? _htmlentities(_stripslashes($t_subject)) : "", 32), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>".form_textarea("t_content", isset($t_content) ? $t_content : "", 15, 85). "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', $lang['apply']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
echo form_submit('cancel', $lang['cancel']);

if ($edit_html) {
    echo "&nbsp;".form_submit("b_edit_text", $lang['edittext']);
    echo form_input_hidden("t_post_html", "Y");

} else {
    echo "&nbsp;".form_submit("b_edit_html", $lang['editHTML']);
    echo form_input_hidden("t_post_html", "N");
}

if ($aid = get_pm_attachment_id($mid)) {
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid');\"");
    echo form_input_hidden('aid', $aid);
}else {
    $aid = md5(uniqid(rand()));
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid');\"");
    echo form_input_hidden('aid', $aid);
}

echo "</form>\n";

if ($valid) {
    echo "<h2>{$lang['messagepreview']}:</h2><br />\n";
    $pm_elements_array['FOLDER'] = PM_FOLDER_OUTBOX;
    draw_pm_message($pm_elements_array);
}

html_draw_bottom();

?>