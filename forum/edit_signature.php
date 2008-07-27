<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: edit_signature.php,v 1.110 2008-07-27 18:26:09 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

$admin_edit = false;

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['siguid'])) {

        if (is_numeric($_GET['siguid'])) {

            $uid = $_GET['siguid'];
            $admin_edit = true;

        }else {

            html_draw_top();
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }elseif (isset($_POST['siguid'])) {

        if (is_numeric($_POST['siguid'])) {

            $uid = $_POST['siguid'];
            $admin_edit = true;

        }else {

            html_draw_top();
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }else {

        $uid = bh_session_get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

}else {

    $uid = bh_session_get_value('UID');
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != bh_session_get_value('UID'))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

$valid = true;

$error_msg_array = array();

if (isset($_POST['save']) || isset($_POST['preview'])) {

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

    if (isset($_POST['sig_global']) && $_POST['sig_global'] == 'Y') {
        $t_sig_global = 'Y';
    }else {
        $t_sig_global = 'N';
    }

    if ($t_sig_html == "Y") $t_sig_content = fix_html($t_sig_content);

    if ($admin_edit === true) $t_sig_global = 'N';

    if (attachment_embed_check($t_sig_content) && $t_sig_html == "Y") {

        $error_msg_array[] = $lang['notallowedembedattachmentsignature'];
        $valid = false;
    }
}

if (isset($_POST['save'])) {

    if ($valid) {

        // Update USER_SIG

        if (user_update_sig($uid, $t_sig_content, $t_sig_html, ($t_sig_global == 'Y'))) {

            if ($admin_edit === true) {

                $redirect_uri = "admin_user.php?webtag=$webtag&signature_updated=true&uid=$uid";
                header_redirect($redirect_uri, $lang['signatureupdated']);

            }else {

                if ($t_sig_global == 'Y') {

                    $redirect_uri = "edit_signature.php?webtag=$webtag&updated_global=true";
                    header_redirect($redirect_uri, $lang['signatureupdatedforallforums']);

                }else {

                    $redirect_uri = "edit_signature.php?webtag=$webtag&updated=true";
                    header_redirect($redirect_uri, $lang['signatureupdated']);
                }
            }
        }
    }
}

// Get the User's Signature

if (!user_get_sig($uid, $user_sig['SIG_CONTENT'], $user_sig['SIG_HTML'])) {

    $user_sig['SIG_CONTENT'] = '';
    $user_sig['SIG_HTML'] = 'Y';
}

// Start Output Here

html_draw_top("basetarget=_blank", "onUnload=clearFocus()", "resize_width=600", "dictionary.js", "htmltools.js", "post.js", "poll.js");

if ($admin_edit === true) {

    $user = user_get($uid);

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";

}else {

    echo "<h1>{$lang['editsignature']}</h1>\n";
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['signatureupdated'], '600', 'left');

}else if (isset($_GET['updated_global'])) {

    html_display_success_msg($lang['signatureupdatedforallforums'], '600', 'left');
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
echo $tools->preload();

echo "<br />\n";

if ($admin_edit === true) echo "<div align=\"center\">\n";

$show_set_all = (forums_get_available_count() > 1) ? true : false;

echo "<form name=\"prefs\" action=\"edit_signature.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";

if ($admin_edit === true) {
    echo "  ", form_input_hidden('siguid', _htmlentities($uid)), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

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
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"100%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">\n";
        echo "                          <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\">\n";

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
echo "                  <td align=\"left\" class=\"subhead\">{$lang['signature']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

$page_prefs = bh_session_get_post_page_prefs();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar();
}else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("sig_content", $sig_code, 12, 85, "virtual", "tabindex=\"7\"", "edit_signature_content");
echo $tools->js();

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";

if ($admin_edit === true) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("preview", $lang['preview']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("preview", $lang['preview']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if ($tools->getTinyMCE()) {

    echo form_input_hidden("sig_html", "Y");

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("sig_html", "Y", $lang['signaturecontainshtmlcode'], $sig_html), "</td>\n";
    echo "                      </tr>\n";
}

echo $tools->assign_checkbox("sig_html");

if ($show_set_all && $admin_edit === false) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("sig_global", "Y", $lang['savesignatureforuseonallforums'], (isset($t_sig_global) && $t_sig_global == 'Y')), "</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_input_hidden("sig_global", 'Y'), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "  </table>\n";
echo "</form>\n";

if ($admin_edit === true) echo "</div>\n";

html_draw_bottom();

?>