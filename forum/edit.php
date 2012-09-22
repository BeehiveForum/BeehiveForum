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
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    html_draw_error(gettext("No message specified for editing"), 'discussion.php', 'get', array('back' => gettext("Back")));
}

if (!($edit_message = messages_get($tid, $pid, 1))) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_display_error_msg(gettext("That post does not exist in this thread!"));
    html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    header_redirect("edit_poll.php?webtag=$webtag&msg=$msg");
    exit;
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
    html_draw_error(gettext("You cannot edit posts in this folder"));
}

if (!$thread_data = thread_get($tid)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

$error_msg_array = array();

$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

$uid = session::get_value('UID');

$page_prefs = session::get_post_page_prefs();

$valid = true;

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

if (($page_prefs & POST_CHECK_SPELLING) > 0) {
    $spelling_enabled = true;
} else {
    $spelling_enabled = false;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else{
    $aid = md5(uniqid(mt_rand()));
}

post_save_attachment_id($tid, $pid, $aid);

$allow_html = true;

$allow_sig = true;

if (isset($t_fid) && !session::check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session::check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    $t_content = htmlentities_array($t_content);
    $t_sig = htmlentities_array($t_sig);
}

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_post_emots'])) {

        if ($_POST['t_post_emots'] == "disabled") {
            $emots_enabled = false;
        } else {
            $emots_enabled = true;
        }

    } else {

        $emots_enabled = false;
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

        $spelling_enabled = false;
    }
}

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = fix_html($_POST['t_content'], $emots_enabled, $links_enabled);

        if (attachments_embed_check($t_content)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = fix_html($_POST['t_sig'], false, true);

        if (attachments_embed_check($t_sig)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
            $valid = false;
        }
    }
}

if (!isset($t_content)) $t_content = "";

if (!isset($t_sig)) $t_sig = "";

if ($valid && isset($_POST['preview'])) {

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if ($valid) {

        $edit_message['CONTENT'] = $t_content;

        if ($allow_sig == true && isset($t_sig)) {
            $edit_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";
        }

        if ($edit_message['TO_UID'] == 0) {

            $edit_message['TLOGON'] = gettext("ALL");
            $edit_message['TNICK'] = gettext("ALL");
        }

        $edit_message['AID'] = $aid;
    }

} else if ($valid && isset($_POST['apply'])) {

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
    }

    if ($valid) {

        $t_content_new = $t_content;

        if ($allow_sig == true && isset($t_sig)) {
            $t_content_new.= "<div class=\"sig\">$t_sig</div>";
        }

        if (post_update($t_fid, $tid, $pid, $t_content_new)) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && ($edit_message['FROM_UID'] != $uid)) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            header_redirect("discussion.php?webtag=$webtag&msg=$msg&edit_success=$msg");
            exit;

        } else {

            $error_msg_array[] = gettext("Error updating post");
        }
    }

} else if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    if (count($edit_message) > 0) {

        if (($edit_message['CONTENT'] = message_get_content($tid, $pid))) {

            if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
                html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
            }

            if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
                html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
            }

            $to_uid = $edit_message['TO_UID'];

            $from_uid = $edit_message['FROM_UID'];

            $parsed_message = new MessageTextParse($edit_message['CONTENT'], $emots_enabled, $links_enabled);

            $emots_enabled = $parsed_message->getEmoticons();

            $links_enabled = $parsed_message->getLinks();

            $t_content = $parsed_message->getMessage();

            $t_sig = $parsed_message->getSig();

        } else {

            html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
        }

    } else{
        html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
    }
}

$page_title = sprintf(gettext("Edit message %s"), $msg);

html_draw_top("title=$page_title", "resize_width=720", "basetarget=_blank", "attachments.js", "dictionary.js", "emoticons.js", "post.js", 'class=window_title');

echo "<h1>$page_title</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br /><form accept-charset=\"utf-8\" name=\"f_post\" action=\"edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Message Preview"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />", message_display($tid, $edit_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, false, $show_sigs, true), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table class=\"posthead\" width=\"720\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", sprintf(gettext("Edit message %s"), $msg), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\" cellpadding=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Folder"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", word_filter_add_ob_tags($thread_data['FOLDER_TITLE'], true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Thread title"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", word_filter_add_ob_tags($thread_data['TITLE'], true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("To"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">";

if ($edit_message['TO_UID'] > 0) {

    echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid=$to_uid\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($edit_message['TLOGON'], $edit_message['TNICK']), true), "</a>\n";

} else {

    echo word_filter_add_ob_tags(format_user_name($edit_message['TLOGON'], $edit_message['TNICK']), true);
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Message options"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_links", "enabled", gettext("Automatically parse URLs"), $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_check_spelling", "enabled", gettext("Automatically check spelling"), $spelling_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_emots", "disabled", gettext("Disable emoticons"), !$emots_enabled), "</td>\n";
echo "                      </tr>\n";

if (($user_emoticon_pack = session::get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', null, 'default');
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
echo "                  <td align=\"left\" valign=\"top\" width=\"500\">\n";
echo "                    <table class=\"posthead\" width=\"500\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>", gettext("Message"), "</h2>\n";
echo "                          ", form_textarea("t_content", htmlentities_array($t_content), 20, 75, 'tabindex="1"', 'post_content editor'), "\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

echo form_submit('apply',gettext("Apply"), "tabindex=\"2\""), "\n";

echo form_submit("preview", gettext("Preview"), "tabindex=\"3\""), "\n";

echo "<a href=\"discussion.php?webtag=$webtag&amp;msg=$msg\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";

if (forum_get_setting('attachments_enabled', 'Y') && (session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid) || $new_thread)) {

    echo "<a href=\"attachments.php?aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
    echo form_input_hidden("aid", htmlentities_array($aid));
}

if ($allow_sig == true) {

    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table class=\"messagefoot\" width=\"486\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Signature"), "</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'sig_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'sig_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";
    echo "                                <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";
    echo "                                  ", form_textarea("t_sig", htmlentities_array($t_sig), 5, 75, 'tabindex="7"', 'signature_content editor');
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
echo "</form>";

html_draw_bottom();

?>