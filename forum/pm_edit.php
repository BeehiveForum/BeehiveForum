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

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check that PM system is enabled
pm_enabled();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Prune old messages for the current user
pm_user_prune_folders($_SESSION['UID']);

$t_subject = null;
$t_content = null;

// Get the Message ID (MID)
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

} else if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = $_POST['mid'];

} else {

    html_draw_error(gettext("No message specified for editing"));
}

// Get the message.
if (!($message_data = pm_message_get($mid))) {
    pm_edit_refuse();
}

if (isset($message_data['ATTACHMENTS'])) {
    $attachments = $message_data['ATTACHMENTS'];
} else {
    $attachments = array();
}

$valid = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $t_subject = trim($_POST['t_subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = fix_html(emoticons_strip($_POST['t_content']));

        if (mb_strlen($t_content) >= 65535) {

            $error_msg_array[] = sprintf(
                gettext("Message length must be under 65,535 characters (currently: %s)"),
                format_number(mb_strlen($t_content))
            );

            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }

    if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
        $attachments = array_filter($_POST['attachment'], 'is_md5');
    } else {
        $attachments = array();
    }
}

if ($valid && isset($_POST['preview'])) {

    $message_data['CONTENT'] = $t_content;

    $message_data['SUBJECT'] = $t_subject;

    $message_data['FOLDER'] = PM_FOLDER_OUTBOX;

    $message_data['ATTACHMENTS'] = $attachments;

} else if ($valid && isset($_POST['apply'])) {

    if (pm_edit_message($mid, $t_subject, $t_content)) {

        if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], $attachments))) {

            foreach ($attachments_array as $attachment) {

                pm_add_attachment($mid, $attachment['aid']);
            }
        }

        header_redirect("pm.php?webtag=$webtag&mid=$mid");
        exit;

    } else {

        $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
        $valid = false;
    }

} else if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {
        $t_subject = trim($_POST['t_subject']);
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
        $t_content = fix_html(emoticons_strip($_POST['t_content']));
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    } else {
        $to_radio = 1;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    } else {
        $t_to_uid = 0;
    }

    $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    if (!isset($message_data['EDITABLE']) || ($message_data['EDITABLE'] == 0)) {
        pm_edit_refuse();
    }

    $parsed_message = new MessageTextParse(pm_get_content($mid));

    $t_content = $parsed_message->getMessage();

    $t_subject = $message_data['SUBJECT'];
}

html_draw_top(
    array(
        'title' => gettext("Private Messages"),
        'js' => array(
            'js/attachments.js',
            'js/edit.js',
            'js/pm.js',
            'js/emoticons.js',
            'ckeditor/ckeditor.js',
            'js/fineuploader.min.js'
        ),
        'base_target' => '_blank',
        'pm_popup_disabled' => true,
        'class' => 'window_title max_width'
    )
);

echo "<h1>", gettext("Private Messages"), html_style_image('separator'), gettext("Edit Message"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '960', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"pm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"960\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Message Preview"), "</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />";

    pm_display($message_data, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table width=\"100%\" class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Edit Message"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Subject"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 42, null, null, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("To"), "</h2></td>\n";
echo "                      </tr>\n";

foreach ($message_data['RECIPIENTS'] as $recipient) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$recipient['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</a></td>\n";
    echo "                      </tr>\n";
}

if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {
    $user_emoticon_pack = $_SESSION['EMOTICONS'];
} else {
    $user_emoticon_pack = forum_get_setting('default_emoticons', 'strlen', 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack)) !== false) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'emots_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'emots_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                                <div class=\"emots_toggle\">{$emoticon_preview_html}</div>\n";
    } else {
        echo "                                <div class=\"emots_toggle\" style=\"display: none\">{$emoticon_preview_html}</div>\n";
    }

    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" width=\"740\" valign=\"top\">\n";
echo "                    <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"subhead\">", gettext("Message"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"background-color: #F8F8FF;\">\n";
echo "                         ", form_textarea("t_content", htmlentities_array(emoticons_apply($t_content)), 22, 100, 'tabindex="1"', 'post_content editor focus'), "\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

echo form_submit('apply', gettext("Apply"), "tabindex=\"2\""), "\n";

echo form_submit('preview', gettext("Preview"), "tabindex=\"3\""), "\n";

echo "<a href=\"pm.php?webtag=$webtag&mid=$mid\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";

if (attachments_check_dir()) {

    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table class=\"messagefoot\" width=\"722\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Attachments"), "</td>\n";

    if (($page_prefs & POST_ATTACHMENT_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'attachment_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'attachment_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";
    echo "                                <div class=\"attachments attachment_toggle\" style=\"display: ", (($page_prefs & POST_ATTACHMENT_DISPLAY) > 0) ? "block" : "none", "\">\n";
    echo "                                  <ul>\n";
    echo "                                  ", attachments_form($_SESSION['UID'], $attachments), "\n";
    echo "                                </div>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();
