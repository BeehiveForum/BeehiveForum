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

/* $Id: edit_signature.php,v 1.70 2006-09-13 22:47:15 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$admin_edit = false;

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    
    if (isset($_GET['siguid'])) {

        if (is_numeric($_GET['siguid'])) {

            $uid = $_GET['siguid'];
            $admin_edit = true;

        } else {

            html_draw_top();
            echo "<h1>{$lang['invalidop']}</h1>\n";
            echo "<h2>{$lang['nouserspecified']}</h2>\n";
            html_draw_bottom();
            exit;
        }

    } elseif (isset($_POST['siguid'])) {

        if (is_numeric($_POST['siguid'])) {

            $uid = $_POST['siguid'];
            $admin_edit = true;

        } else {
            html_draw_top();
            echo "<h1>{$lang['invalidop']}</h1>\n";
            echo "<h2>{$lang['nouserspecified']}</h2>\n";
            html_draw_bottom();
            exit;
        }

    }else {

        $uid = bh_session_get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("./admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

} else {

    if (bh_session_get_value('UID') == 0) {

        html_guest_error();
        exit;
    }

    $uid = bh_session_get_value('UID');
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != bh_session_get_value('UID'))) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$valid = true;

if (isset($_POST['submit']) || isset($_POST['preview'])) {

    if (isset($_POST['sig_content']) && strlen(trim(_stripslashes($_POST['sig_content']))) > 0) {
        $t_sig_content = trim(_stripslashes($_POST['sig_content']));
    }else {
        $t_sig_content = "";
    }

    if (isset($_POST['sig_html']) && $_POST['sig_html'] == "Y") {
        $t_sig_html = "Y";
    }else {
        $t_sig_html = "N";
    }

    if ($t_sig_html == "Y") {
        $t_sig_content = fix_html($t_sig_content);
    }

    if (attachment_embed_check($t_sig_content) && $t_sig_html == "Y") {
        $error_html.= "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
        $valid = false;
    }
}

if (isset($_POST['submit'])) {

    if ($valid) {

        // Update USER_SIG

        user_update_sig($uid, $t_sig_content, $t_sig_html);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init(bh_session_get_value('UID'), false);

        header_redirect("./edit_signature.php?webtag=$webtag&updated=true&siguid=$uid", $lang['signatureupdated']);
    }
}

// Get the User's Signature

user_get_sig($uid, $user_sig['SIG_CONTENT'], $user_sig['SIG_HTML']);

// Start Output Here

html_draw_top("basetarget=_blank", "onUnload=clearFocus()", "dictionary.js", "htmltools.js");

if ($admin_edit === true) {

    $user = user_get($uid);

    echo "<h1>{$lang['admin']} : {$lang['manageuser']} : ", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</h1>\n";

}else {

    echo "<h1>{$lang['editsignature']}</h1>\n";
}

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['signatureupdated']}</h2>\n";
}

if (isset($t_sig_html)) {
    $sig_html = ($t_sig_html == "Y");
} else {
    $sig_html = ($user_sig['SIG_HTML'] == "Y");
}

if (isset($t_sig_content)) {

    if ($sig_html == "Y") {

        $sig_code = _htmlentities(tidy_html($t_sig_content, false, false));

    }else {

        $sig_code = $t_sig_content;
    }

}else {

    if ($sig_html == "Y") {

        $sig_code = _htmlentities(tidy_html($user_sig['SIG_CONTENT'], false, false));

    }else {

        $sig_code = $user_sig['SIG_CONTENT'];
    }
}

$tools = new TextAreaHTML("prefs");

echo "<br />\n";

if ($admin_edit === true) echo "<div align=\"center\">\n";

echo "<form name=\"prefs\" action=\"edit_signature.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";

if ($admin_edit === true) echo "  ", form_input_hidden('siguid', $uid), "\n";

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";

if (isset($_POST['preview'])) {

    if ($valid) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

        $preview_tuser = user_get($uid);

        $preview_message['FLOGON']   = $preview_tuser['LOGON'];
        $preview_message['FNICK']    = $preview_tuser['NICKNAME'];
        $preview_message['FROM_UID'] = $preview_tuser['UID'];

        $preview_message['CONTENT'] = $lang['signaturepreview'];

        if ($t_sig_html == "Y") {
            $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig_content</div>";
        }else {
            $preview_message['CONTENT'].= "<div class=\"sig\">". make_html($t_sig_content). "</div>";
        }

        $preview_message['CREATED'] = mktime();

        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\">{$lang['preview']}</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td>\n";
        echo "                          <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
        echo "                            <tr>\n";
        echo "                              <td>\n";

        message_display(0, $preview_message, 0, 0, 0, true, false, false, false, true, true);
        echo "<br />\n";

        echo "                              </td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
    }
}

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['signature']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"90%\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";

$page_prefs = bh_session_get_post_page_prefs();

$tool_type = 0;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = 1;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = 2;
}

if ($tool_type != 0) {
    echo $tools->toolbar();
}else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("sig_content", $sig_code, 10, 60, "virtual", "tabindex=\"7\"", "signature_content"), "</td>\n";

echo $tools->js();

echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>\n";

if ($tools->getTinyMCE()) {

    echo form_input_hidden("sig_html", "Y");

}else {

    echo form_checkbox("sig_html", "Y", $lang['containsHTML'], $sig_html);
}

echo $tools->assign_checkbox("sig_html");

echo "                        </td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";

if ($admin_edit === true) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("preview", $lang['preview']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("preview", $lang['preview']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";

if ($admin_edit === true) echo "</div>\n";

html_draw_bottom();

?>