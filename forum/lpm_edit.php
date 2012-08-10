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
require_once 'lboot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'email.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'htmltools.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Check that PM system is enabled
light_pm_enabled();

// Get the user's UID
$uid = session::get_value('UID');

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Prune old messages for the current user
pm_user_prune_folders();

// Get the Message ID (MID)
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

} else if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = $_POST['mid'];

} else {

    light_html_draw_top(sprintf('title=%s', gettext("Error")), 'pm_popup_disabled');
    light_html_display_error_msg(gettext("No message specified for editing"));
    light_html_draw_bottom();
    exit;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

} else if (!$aid = attachments_get_pm_id($mid)) {

    $aid = md5(uniqid(mt_rand()));
}

pm_save_attachment_id($mid, $aid);

// User clicked cancel
if (isset($_POST['cancel'])) {
    header_redirect("lpm.php?webtag=$webtag&mid=$mid");
}

$valid = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

$t_content = "";

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    } else if ($t_post_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    } else {
        $post_html = POST_HTML_DISABLED;
    }

} else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    } else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    } else {
        $post_html = POST_HTML_DISABLED;
    }
}

if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
    $emots_enabled = false;
} else {
    $emots_enabled = true;
}

if (($page_prefs & POST_AUTO_LINKS) > 0) {
    $links_enabled = true;
} else {
    $links_enabled = false;
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $t_subject = trim($_POST['t_subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = trim($_POST['t_content']);

        $post->setContent($t_content);
        $t_content = $post->getContent();

        if (mb_strlen($t_content) >= 65535) {

            $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_content)));
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }
}

// Update the PM
if ($valid && isset($_POST['preview'])) {

    $edit_html = ($_POST['t_post_html'] == "Y");

    if (($pm_message_array = pm_message_get($mid))) {

        $pm_message_array['CONTENT'] = $t_content;

        $pm_message_array['SUBJECT'] = $t_subject;
        $pm_message_array['FOLDER'] = PM_FOLDER_OUTBOX;

    } else {

        light_pm_edit_refuse();
    }

} else if ($valid && isset($_POST['apply'])) {

    if (($pm_message_array = pm_message_get($mid))) {

        pm_save_attachment_id($mid, $aid);

        if (pm_edit_message($mid, $t_subject, $t_content)) {

            header_redirect("lpm.php?webtag=$webtag&mid=$mid");
            exit;

        } else {

            $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
            $valid = false;
        }

    } else {

        light_pm_edit_refuse();
    }

} else if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {
        $t_subject = trim($_POST['t_subject']);
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = trim($_POST['t_content']);

        $post->setContent($t_content);

        $t_content = $post->getContent();
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

    $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );
    
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    if (($pm_message_array = pm_message_get($mid))) {

        if ($pm_message_array['TYPE'] != PM_OUTBOX) {
            light_pm_edit_refuse();
        }

        $parsed_message = new MessageTextParse(pm_get_content($mid), $emots_enabled, $links_enabled);

        $emots_enabled = $parsed_message->getEmoticons();
        $links_enabled = $parsed_message->getLinks();
        $t_content = $parsed_message->getMessage();
        $post_html = $parsed_message->getMessageHTML();
        
        $post->setHTML($allow_html ? $post_html : POST_HTML_DISABLED);

        $post->setContent($t_content);
        $post->setEmoticons($emots_enabled);
        $post->setLinks($links_enabled);        

        $post->diff = false;

        $t_content = $post->getContent();

        $t_subject = $pm_message_array['SUBJECT'];

    } else {

        light_pm_edit_refuse();
    }
}

light_html_draw_top(sprintf("title=%s", gettext("Edit Message")));

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>\n";
    light_pm_display($pm_message_array, PM_FOLDER_OUTBOX, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";

echo "<div class=\"post\">\n";
echo "<h3>", gettext("Edit Message"), "</h3>\n";
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array, '720', 'left');
}

echo "<div class=\"post_thread_title\">", gettext("Subject"), ":", light_form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 30, 64), "</div>\n";
echo "<div class=\"post_to\">", gettext("To"), ":", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</div>\n";
echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("t_content", $post->getTidyContent(), 10, 50), "</div>\n";

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<div class=\"post_html\"><span>", gettext("HTML in message"), ":</span>\n";
    echo light_form_radio("t_post_html", "disabled", gettext("Disabled"), $tph_radio == POST_HTML_DISABLED);
    echo light_form_radio("t_post_html", "enabled_auto", gettext("Enabled with auto-line-breaks"), $tph_radio == POST_HTML_AUTO);
    echo light_form_radio("t_post_html", "enabled", gettext("Enabled"), $tph_radio == POST_HTML_ENABLED);
    echo "</div>";

} else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

echo "</div>";
echo "</div>";
echo "</form>\n";

light_html_draw_bottom();

?>