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
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

if (!session::logged_in()) {
    html_guest_error();
}

pm_enabled();

$page_prefs = session::get_post_page_prefs();

pm_user_prune_folders($_SESSION['UID']);

$reply_mid = null;

$forward_mid = null;

$edit_mid = null;

$reply_all = false;

$subject = null;

$to_logon_array = array();

if (isset($_GET['reply_to']) && is_numeric($_GET['reply_to'])) {

    $reply_mid = $_GET['reply_to'];

} else if (isset($_POST['reply_to']) && is_numeric($_POST['reply_to'])) {

    $reply_mid = $_POST['reply_to'];

} else if (isset($_GET['replyall']) && is_numeric($_GET['replyall'])) {

    $reply_mid = $_GET['replyall'];

    $reply_all = true;

} else if (isset($_POST['replyall']) && is_numeric($_POST['replyall'])) {

    $reply_mid = $_POST['replyall'];

    $reply_all = true;

} else if (isset($_GET['fwdmsg']) && is_numeric($_GET['fwdmsg'])) {

    $forward_mid = $_GET['fwdmsg'];

} else if (isset($_POST['fwdmsg']) && is_numeric($_POST['fwdmsg'])) {

    $forward_mid = $_POST['fwdmsg'];

} else if (isset($_GET['editmsg']) && is_numeric($_GET['editmsg'])) {

    $edit_mid = $_GET['editmsg'];

} else if (isset($_POST['editmsg']) && is_numeric($_POST['editmsg'])) {

    $edit_mid = $_POST['editmsg'];
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (is_numeric($tid) && is_numeric($pid)) {

        if (($thread_data = thread_get($tid)) !== false) {

            $thread_title = trim($thread_data['TITLE']);
            $thread_index = "[$tid.$pid]";

            if (mb_strlen($thread_title) > (55 - mb_strlen($thread_index))) {
                $thread_title = mb_substr($thread_title, 0, (55 - mb_strlen($thread_index))) . '...';
            }

            $subject = "RE:$thread_title $thread_index";
        }
    }
}

if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
    $return_msg = $_POST['return_msg'];
} else if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
    $return_msg = $_GET['return_msg'];
}

$folder = PM_FOLDER_INBOX;

if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    } else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    } else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

} else if (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    } else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    } else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }
}

$valid = true;

$error_msg_array = array();

if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
    $attachments = array_filter($_POST['attachment'], 'is_md5');
} else {
    $attachments = array();
}

if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['subject']) && strlen(trim($_POST['subject'])) > 0) {
        $subject = trim($_POST['subject']);
    }

    if (isset($_POST['content']) && strlen(trim($_POST['content'])) > 0) {
        $content = fix_html(emoticons_strip($_POST['content']));
    }

    if (isset($_POST['to_logon']) && strlen(trim($_POST['to_logon'])) > 0) {
        $to_logon = trim($_POST['to_logon'], ', ');
    } else {
        $to_logon = '';
    }

    $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (isset($_POST['send']) || isset($_POST['preview']) || isset($_POST['save'])) {

    if (isset($_POST['subject']) && strlen(trim($_POST['subject'])) > 0) {

        $subject = trim($_POST['subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['content']) && strlen(trim($_POST['content'])) > 0) {

        $content = fix_html(emoticons_strip($_POST['content']));

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }

    if (isset($reply_mid) && is_numeric($reply_mid) && $reply_mid > 0) {

        if (($pm_data = pm_message_get($reply_mid)) !== false) {

            $pm_data['CONTENT'] = pm_get_content($reply_mid);

        } else {

            html_draw_top(
                array(
                    'title' => gettext("Error")
                )
            );

            pm_error_refuse();
            html_draw_bottom();
            exit;
        }
    }

    if (isset($_POST['to_logon']) && strlen(trim($_POST['to_logon'])) > 0) {

        $to_logon_array = preg_split('/,\s*/u', trim($_POST['to_logon'], ', '));

        $to_logon_array = array_filter(array_map('trim', $to_logon_array), 'strlen');

        foreach ($to_logon_array as $key => $recipient) {

            $to_logon = trim($recipient);

            unset($to_logon_array[$key]);

            if (($to_user = user_get_by_logon($to_logon)) !== false) {

                $peer_relationship = user_get_peer_relationship($to_user['UID'], $_SESSION['UID']);

                $to_logon_array[$to_user['UID']] = array(
                    'UID' => $to_user['UID'],
                    'LOGON' => $to_user['LOGON'],
                    'NICKNAME' => $to_user['NICKNAME']
                );

                if (((($peer_relationship & USER_BLOCK_PM) == 0) && user_allow_pm($to_user['UID'])) || session::check_perm(USER_PERM_FOLDER_MODERATE, 0)) {

                    pm_user_prune_folders($_SESSION['UID']);

                    if (pm_get_free_space($_SESSION['UID']) < sizeof($to_logon_array)) {

                        $error_msg_array[] = gettext("You do not have enough free space to send this message.");
                        $valid = false;
                    }

                } else {

                    $error_msg_array[] = sprintf(gettext("%s has opted out of receiving personal messages"), $to_logon);
                    $valid = false;
                }

            } else {

                $error_msg_array[] = sprintf(gettext("User %s not found"), htmlentities_array($to_logon));
                $valid = false;
            }
        }

        $to_logon = implode(', ', array_map('user_get_logon_callback', $to_logon_array));

        if ($valid && sizeof($to_logon_array) > 10) {

            $error_msg_array[] = gettext("There is a limit of 10 recipients per message. Please amend your recipient list.");
            $valid = false;
        }

        if ($valid && sizeof($to_logon_array) < 1) {

            $error_msg_array[] = gettext("You must specify at least one recipient.");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must specify at least one recipient.");
        $valid = false;
    }

} else if (isset($reply_mid) && is_numeric($reply_mid) && $reply_mid > 0) {

    if (($pm_data = pm_message_get($reply_mid)) !== false) {

        $pm_data['CONTENT'] = pm_get_content($reply_mid);

        $subject = preg_replace('/^(RE:)?/iu', 'RE:', $pm_data['SUBJECT']);

        $to_logon_array[$pm_data['FROM_UID']] = array(
            'UID' => $pm_data['FROM_UID'],
            'LOGON' => $pm_data['FROM_LOGON'],
            'NICKNAME' => $pm_data['FROM_NICKNAME']
        );

        if ($reply_all && isset($pm_data['RECIPIENTS']) && sizeof($pm_data['RECIPIENTS']) > 0) {

            foreach ($pm_data['RECIPIENTS'] as $recipient) {
                $to_logon_array[$recipient['UID']] = $recipient;
            }
        }

        $to_logon = implode(', ', array_map('user_get_logon_callback', $to_logon_array));

        if (isset($_SESSION['PM_INCLUDE_REPLY']) && ($_SESSION['PM_INCLUDE_REPLY'] == 'Y')) {

            $message_author = htmlentities_array(format_user_name($pm_data['FROM_LOGON'], $pm_data['FROM_NICKNAME']));

            $content = sprintf(
                '<div class="quotetext"><b>%s:</b> %s</div>
                 <div class="quote">%s</div><p>&nbsp;</p>',
                gettext('quote'),
                $message_author,
                fix_html($pm_data['CONTENT'])
            );
        }

    } else {

        html_draw_top(
            array(
                'title' => gettext("Error")
            )
        );

        pm_error_refuse();
        html_draw_bottom();
        exit;
    }

} else if (isset($forward_mid)) {

    if (($pm_data = pm_message_get($forward_mid)) !== false) {

        $pm_data['CONTENT'] = pm_get_content($forward_mid);

        $subject = preg_replace('/^(FWD:)?/iu', 'FWD:', $pm_data['SUBJECT']);

        $message_author = htmlentities_array(format_user_name($pm_data['FROM_LOGON'], $pm_data['FROM_NICKNAME']));

        $content = sprintf(
            '<div class="quotetext"><b>%s:</b> %s</div>
             <div class="quote">%s</div><p>&nbsp;</p>',
            gettext('quote'),
            $message_author,
            fix_html($pm_data['CONTENT'])
        );

        $attachments = $pm_data['ATTACHMENTS'];

    } else {

        html_draw_top(
            array(
                'title' => gettext("Error")
            )
        );

        pm_error_refuse();
        html_draw_bottom();
        exit;
    }

} else if (isset($edit_mid)) {

    if (($pm_data = pm_message_get($edit_mid)) !== false) {

        $pm_data['CONTENT'] = pm_get_content($edit_mid);

        $subject = $pm_data['SUBJECT'];

        $parsed_message = new MessageTextParse($pm_data['CONTENT']);

        $content = $parsed_message->getMessage();

        $subject = $pm_data['SUBJECT'];

        $reply_mid = $pm_data['REPLY_TO_MID'];

        $to_logon = implode(', ', array_map('user_get_logon_callback', $pm_data['RECIPIENTS']));

        $attachments = $pm_data['ATTACHMENTS'];

    } else {

        html_draw_top(
            array(
                'title' => gettext("Error")
            )
        );

        pm_error_refuse();
        html_draw_bottom();
        exit;
    }
}

if (!isset($content)) $content = "";

if (mb_strlen($content) >= 65535) {

    $error_msg_array[] = sprintf(
        gettext("Message length must be under 65,535 characters (currently: %s)"),
        format_number(mb_strlen($content))
    );

    $valid = false;
}

if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = $_POST['dedupe'];
} else {
    $dedupe = time();
}

if ($valid && isset($_POST['send'])) {

    if (post_check_ddkey($dedupe)) {

        if (isset($edit_mid)) {

            $new_mid = pm_send_saved_message($edit_mid, $_SESSION['UID'], $to_logon_array, $subject, $content, $reply_mid);

        } else {

            $new_mid = pm_send_message($_SESSION['UID'], $to_logon_array, $subject, $content, $reply_mid);
        }

        if ($new_mid !== false) {

            email_send_pm_notification($new_mid);

            if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], $attachments))) {

                foreach ($attachments_array as $attachment) {

                    pm_add_attachment($new_mid, $attachment['aid']);
                }
            }

        } else {

            $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
            $valid = false;
        }
    }

    if ($valid) {

        if (isset($return_msg)) {

            header_redirect("discussion.php?webtag=$webtag&msg=$return_msg&message_sent=true");
            exit;

        } else {

            header_redirect("pm.php?webtag=$webtag&message_sent=true");
            exit;
        }
    }

} else if ($valid && isset($_POST['save'])) {

    if (isset($edit_mid)) {

        if (pm_update_saved_message($edit_mid, $_SESSION['UID'], $to_logon_array, $subject, $content, $reply_mid)) {

            if (isset($return_msg)) {

                header_redirect("discussion.php?webtag=$webtag&msg=$return_msg&message_saved=true");
                exit;

            } else {

                header_redirect("pm.php?webtag=$webtag&mid=$edit_mid&message_saved=true");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Could not save message. Make sure you have enough available free space.");
            $valid = false;
        }

    } else {

        if (($saved_mid = pm_save_message($_SESSION['UID'], $to_logon_array, $subject, $content, $reply_mid)) !== false) {

            if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], $attachments)) !== false) {

                foreach ($attachments_array as $attachment) {

                    pm_add_attachment($saved_mid, $attachment['aid']);
                }
            }

            if (isset($return_msg)) {

                header_redirect("discussion.php?webtag=$webtag&msg=$return_msg&message_saved=true");
                exit;

            } else {

                header_redirect("pm.php?webtag=$webtag&mid=$saved_mid&message_saved=true");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Could not save message. Make sure you have enough available free space.");
            $valid = false;
        }
    }
}

html_draw_top(
    array(
        'title' => gettext('Private Messages - Send New PM'),
        'base_target' => '_blank',
        'js' => array(
            'js/pm.js',
            'js/attachments.js',
            'js/emoticons.js',
            'js/search.js',
            'js/search_popup.js',
            'ckeditor/ckeditor.js',
            'js/fineuploader.min.js'
        ),
        'class' => 'window_title max_width'
    )
);

echo "<h1>", gettext("Private Messages"), html_style_image('separator'), gettext("Send New PM"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '960', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"pm_write.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('folder', htmlentities_array($folder)), "\n";
echo "  ", form_input_hidden("dedupe", htmlentities_array($dedupe));

if (isset($return_msg)) {
    echo "  ", form_input_hidden('return_msg', htmlentities_array($return_msg)), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"960\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Message Preview"), "</td>\n";
    echo "                </tr>\n";

    $pm_preview_array['RECIPIENTS'] = $to_logon_array;

    $preview_from_user = user_get($_SESSION['UID']);

    $pm_preview_array['FROM_LOGON'] = $preview_from_user['LOGON'];
    $pm_preview_array['FROM_NICKNAME'] = $preview_from_user['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_from_user['UID'];

    $pm_preview_array['SUBJECT'] = $subject;
    $pm_preview_array['CREATED'] = time();

    $pm_preview_array['CONTENT'] = $content;
    $pm_preview_array['ATTACHMENTS'] = $attachments;

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"100%\"><br />";

    pm_display($pm_preview_array, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table width=\"100%\" class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Write Message"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"100%\" cellpadding=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Subject"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("subject", isset($subject) ? htmlentities_array($subject) : "", 42, null, null, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("To"), "</h2></td>\n";
echo "                      </tr>\n";

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    if (($to_user = user_get($_GET['uid'])) !== false) {
        $to_logon = $to_user['LOGON'];
    }
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search("to_logon", isset($to_logon) ? htmlentities_array($to_logon) : null, null, null, SEARCH_LOGON, true, sprintf('title="%s"', gettext("Separate recipients by a comma")), "post_to_others multiple"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";

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
echo "                  <td align=\"left\" valign=\"top\" width=\"740\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">";
echo "                         <h2>", gettext("Message"), "</h2>\n";
echo "                          ", form_textarea("content", htmlentities_array(emoticons_apply($content)), 22, 100, 'tabindex="1"', 'post_content editor focus'), "\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

echo form_submit('send', gettext("Send"), "tabindex=\"2\""), "&nbsp;";

echo form_submit('save', gettext("Save"), "tabindex=\"3\""), "&nbsp;";

echo form_submit('preview', gettext("Preview"), "tabindex=\"4\""), "&nbsp;";

if (isset($return_msg)) {
    echo "<a href=\"discussion.php?webtag=$webtag&amp;msg=$return_msg\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
} else if (isset($edit_mid)) {
    echo "<a href=\"pm.php?webtag=$webtag&mid=$edit_mid\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
} else if (isset($forward_mid)) {
    echo "<a href=\"pm.php?webtag=$webtag&mid=$forward_mid\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
} else {
    echo "<a href=\"pm.php?webtag=$webtag\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
}

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

if (isset($reply_mid) && is_numeric($reply_mid) && $reply_mid > 0) {
    echo form_input_hidden("reply_to", htmlentities_array($reply_mid)), "\n";
}

if (isset($forward_mid) && is_numeric($forward_mid) && $forward_mid > 0) {
    echo form_input_hidden("fwdmsg", htmlentities_array($forward_mid)), "\n";
}

if (isset($edit_mid) && is_numeric($edit_mid) && $edit_mid > 0) {
    echo form_input_hidden("editmsg", htmlentities_array($edit_mid)), "\n";
}

if (isset($pm_data) && is_array($pm_data) && isset($reply_mid) && is_numeric($reply_mid) && $reply_mid > 0) {

    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("In reply to"), "</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"100%\"><br />";

    pm_display($pm_data, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();