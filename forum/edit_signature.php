<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

$admin_edit = false;

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['siguid'])) {

        if (is_numeric($_GET['siguid'])) {

            $uid = $_GET['siguid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }

    } else if (isset($_POST['siguid'])) {

        if (is_numeric($_POST['siguid'])) {

            $uid = $_POST['siguid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }

    } else {

        $uid = session::get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

} else {

    $uid = session::get_value('UID');
}

if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != session::get_value('UID'))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

$valid = true;

$error_msg_array = array();

if (isset($_POST['save']) || isset($_POST['preview'])) {

    if (isset($_POST['sig_content']) && strlen(trim($_POST['sig_content'])) > 0) {
        $t_sig_content = trim($_POST['sig_content']);
    } else {
        $t_sig_content = "";
    }

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == "Y") {
        $t_t_post_html = "Y";
    } else {
        $t_t_post_html = "N";
    }

    if (isset($_POST['sig_global']) && $_POST['sig_global'] == 'Y') {
        $t_sig_global = 'Y';
    } else {
        $t_sig_global = 'N';
    }

    if ($t_t_post_html == "Y") $t_sig_content = fix_html($t_sig_content);

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0) && $admin_edit === true) $t_sig_global = 'N';

    if (attachments_embed_check($t_sig_content) && $t_t_post_html == "Y") {

        $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
        $valid = false;
    }
}

if (isset($_POST['save'])) {

    if ($valid) {

        // Update USER_SIG
        if (user_update_sig($uid, $t_sig_content, $t_t_post_html, ($t_sig_global == 'Y'))) {

            if ($admin_edit === true) {

                $redirect_uri = "admin_user.php?webtag=$webtag&signature_updated=true&uid=$uid";
                header_redirect($redirect_uri, gettext("Signature Updated"));

            } else {

                if ($t_sig_global == 'Y' && forums_get_available_count() > 1) {

                    $redirect_uri = "edit_signature.php?webtag=$webtag&updated_global=true";
                    header_redirect($redirect_uri, gettext("Signature Updated For All Forums"));

                } else {

                    $redirect_uri = "edit_signature.php?webtag=$webtag&updated=true";
                    header_redirect($redirect_uri, gettext("Signature Updated"));
                }
            }
        }
    }
}

// Initialise the $user_sig array
$user_sig = array(
    'SIG_CONTENT' => '', 
    't_post_html' => 'N'
);

// Get the User's Signature
if (!user_get_sig($uid, $user_sig['SIG_CONTENT'], $user_sig['t_post_html'])) {

    $user_sig['SIG_CONTENT'] = '';
    $user_sig['t_post_html'] = 'Y';
}

// Start Output Here
if ($admin_edit === true) {

    $user = user_get($uid);

    html_draw_top(sprintf('title=%s', sprintf(gettext("Admin - Manage User - %s "), format_user_name($user['LOGON'], $user['NICKNAME']))), "basetarget=_blank", "resize_width=600", "dictionary.js", "post.js", 'class=window_title');

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Manage User"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", format_user_name($user['LOGON'], $user['NICKNAME']), "</h1>\n";

} else {

    html_draw_top(sprintf('title=%s', gettext("My Controls - Edit Signature")), "basetarget=_blank", "resize_width=600", "dictionary.js", "post.js", 'class=window_title');

    echo "<h1>", gettext("Edit Signature"), "</h1>\n";
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Signature Updated"), '600', 'left');

} else if (isset($_GET['updated_global'])) {

    html_display_success_msg(gettext("Signature Updated For All Forums"), '600', 'left');
}

if (isset($t_t_post_html)) {
    $t_post_html = ($t_t_post_html == "Y");
} else {
    $t_post_html = ($user_sig['t_post_html'] == "Y");
}

if (isset($t_sig_content)) {

    if ($t_post_html == "Y") {

        $sig_code = htmlentities_array(tidy_html($t_sig_content, false, false));

    } else {

        $sig_code = $t_sig_content;
    }

} else {

    if ($t_post_html == "Y") {

        $sig_code = htmlentities_array(tidy_html($user_sig['SIG_CONTENT'], false, false));

    } else {

        $sig_code = $user_sig['SIG_CONTENT'];
    }
}

$tools = new TextAreaHTML("prefs");

echo "<br />\n";

if ($admin_edit === true) echo "<div align=\"center\">\n";

// Check to see if we should show the set for all forums checkboxes
if ((session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == session::get_value('UID')) && $admin_edit === false)) {
    $show_set_all = (forums_get_available_count() > 1);
} else {
    $show_set_all = false;
}

echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_signature.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

if ($admin_edit === true) {
    echo "  ", form_input_hidden('siguid', htmlentities_array($uid)), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if (isset($_POST['preview'])) {

    if ($valid) {

        $preview_message['TLOGON'] = gettext("ALL");
        $preview_message['TNICK'] = gettext("ALL");

        $preview_tuser = user_get($uid);

        $preview_message['FLOGON']   = $preview_tuser['LOGON'];
        $preview_message['FNICK']    = $preview_tuser['NICKNAME'];
        $preview_message['FROM_UID'] = $preview_tuser['UID'];

        $preview_message['CONTENT'] = gettext("Signature Preview");

        if ($t_t_post_html == "Y") {
            $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig_content</div>";
        } else {
            $preview_message['CONTENT'].= "<div class=\"sig\">". make_html($t_sig_content). "</div>";
        }

        $preview_message['CREATED'] = time();

        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">", gettext("Preview"), "</td>\n";
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
        echo "                              <td align=\"left\"><br />", message_display(0, $preview_message, 0, 0, 0, false, false, false, false, true, true), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Signature"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

$page_prefs = session::get_post_page_prefs();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar();
} else {
    $tools->set_tinymce(false);
}

echo $tools->textarea("sig_content", $sig_code, 12, 85, true, 'tabindex="7"', 'edit_signature_content');
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
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("preview", gettext("Preview")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";

} else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("preview", gettext("Preview")), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Options"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";

if ((!$tools->get_tinymce())) {

    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_post_html", "Y", gettext("Signature contains HTML code"), $t_post_html), "</td>\n";
    echo "                      </tr>\n";

} else {

    echo "                    ", form_input_hidden("t_post_html", "Y");
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
}

if ($show_set_all) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("sig_global", "Y", gettext("Save signature for use on all forums"), (isset($t_sig_global) && $t_sig_global == 'Y')), "</td>\n";
    echo "                      </tr>\n";

} else {

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