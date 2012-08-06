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
require_once BH_INCLUDE_PATH. 'email.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'htmltools.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check that PM system is enabled
pm_enabled();

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

    html_draw_error(gettext("No message specified for editing"));
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

} else if (!$aid = attachments_get_pm_id($mid)) {

    $aid = md5(uniqid(mt_rand()));
}

pm_save_attachment_id($mid, $aid);

$valid = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

$t_content = "";

if (isset($_POST['t_post_emots'])) {

    if ($_POST['t_post_emots'] == "disabled") {
        $emots_enabled = false;
    } else {
        $emots_enabled = true;
    }

} else {

    $emots_enabled = true;
}

if (isset($_POST['t_post_links'])) {

    if ($_POST['t_post_links'] == "enabled") {
        $links_enabled = true;
    } else {
        $links_enabled = false;
    }

} else {

    $links_enabled = false;
}

if (isset($_POST['t_check_spelling'])) {

    if ($_POST['t_check_spelling'] == "enabled") {
        $spelling_enabled = true;
    } else {
        $spelling_enabled = false;
    }

} else {

    $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);
}

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

        pm_edit_refuse();
    }

} else if ($valid && isset($_POST['apply'])) {

    if (($pm_message_array = pm_message_get($mid))) {

        pm_save_attachment_id($mid, $aid);

        if (pm_edit_message($mid, $t_subject, $t_content)) {

            header_redirect("pm.php?webtag=$webtag&mid=$mid");
            exit;

        } else {

            $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
            $valid = false;
        }

    } else {

        pm_edit_refuse();
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
            pm_edit_refuse();
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

        pm_edit_refuse();
    }
}

html_draw_top(sprintf("title=%s", gettext("Private Messages")), "onUnload=clearFocus()", "resize_width=720", "edit.js", "pm.js", "dictionary.js", "htmltools.js", "emoticons.js", "basetarget=_blank", 'pm_popup_disabled', 'class=window_title');

echo "<h1>", gettext("Private Messages"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Edit Message"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"pm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Message Preview"), "</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />", pm_display($pm_message_array, PM_FOLDER_OUTBOX, true), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table width=\"720\" class=\"posthead\">\n";
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
echo "                        <td align=\"left\">", form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 42, false, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("To"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</a></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Message options"), "</h2>\n";
echo "                          ".form_checkbox("t_post_links", "enabled", gettext("Automatically parse URLs"), $links_enabled)."<br />\n";
echo "                          ".form_checkbox("t_check_spelling", "enabled", gettext("Automatically check spelling"), $spelling_enabled)."<br />\n";
echo "                          ".form_checkbox("t_post_emots", "disabled", gettext("Disable emoticons"), !$emots_enabled)."\n";
echo "                        </td>\n";
echo "                      </tr>\n";

if (($user_emoticon_pack = session::get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'emots_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'emots_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
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
echo "                  <td align=\"left\" width=\"500\" valign=\"top\">\n";
echo "                    <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">";
echo "                         <h2>", gettext("Message"), "</h2>\n";

$tools = new TextAreaHTML("f_post");

$t_content = $post->getTidyContent();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit('apply', gettext("Apply")));

} else {
    $tools->set_tinymce(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, true, 'tabindex="1"', 'post_content'), "\n";

echo "                        </td>\n";
echo "                      </tr>\n";

if ($post->isDiff()) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          ", $tools->compare_original("t_content", $post), "\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

if ($allow_html == true) {

    if (($tools->get_tinymce())) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

        echo "              <h2>", gettext("HTML in message"), "</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", gettext("Disabled"), $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", gettext("Enabled with auto-line-breaks"), $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", gettext("Enabled"), $tph_radio == POST_HTML_ENABLED)." \n";
        echo "              <br />";
    }

} else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "              <br />\n";

echo form_submit('apply', gettext("Apply"), "tabindex=\"2\"");
echo "&nbsp;", form_submit('preview', gettext("Preview"), "tabindex=\"3\"");
echo "&nbsp;<a href=\"pm.php?webtag=$webtag&mid=$mid\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "&nbsp;<a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
    echo form_input_hidden('aid', htmlentities_array($aid));
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

?>