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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

if (forum_get_setting('allow_polls', 'N')) {
    html_draw_error(gettext("Polls have been disabled by the forum owner."));
}

if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {
    html_message_type_error();
}

$error_msg_array = array();

$show_sigs = session::show_sigs();

$page_prefs = session::get_post_page_prefs();

$message_text = null;
$thread_title = null;
$poll_closes = null;

$valid = true;

$high_interest = (isset($_SESSION['MARK_AS_OF_INT']) && $_SESSION['MARK_AS_OF_INT'] == 'Y') ? 'Y' : 'N';

if (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['post'])) {

    if (isset($_POST['post_interest'])) {

        if ($_POST['post_interest'] == "Y") {
            $high_interest = "Y";
        } else {
            $high_interest = "N";
        }

    } else {

        $high_interest = "N";
    }

    if (isset($_POST['sticky'])) {

        if ($_POST['sticky'] == 'Y') {
            $sticky = 'Y';
        } else {
            $sticky = 'N';
        }
    }

    if (isset($_POST['closed'])) {

        if ($_POST['closed'] == 'Y') {
            $closed = 'Y';
        } else {
            $closed = 'N';
        }
    }
}

if (($sig_text = user_get_sig($_SESSION['UID'])) !== false) {
    $sig_text = fix_html($sig_text);
}

if (isset($_POST['sig_text'])) {
    $sig_text = fix_html(emoticons_strip($_POST['sig_text']));
}

if (isset($_POST['thread_title']) && strlen(trim($_POST['thread_title'])) > 0) {
    $thread_title = trim($_POST['thread_title']);
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $fid = $_POST['fid'];
} else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $fid = $_GET['fid'];
} else {
    $fid = 1;
}

$poll_questions_array = array();

if (isset($_POST['poll_questions'])) {

    if (is_array($_POST['poll_questions'])) {

        foreach ($_POST['poll_questions'] as $question) {

            if (isset($question['question']) || isset($question['options'])) {

                $poll_question = array(
                    'QUESTION_ID' => sizeof($poll_questions_array) + 1,
                    'QUESTION' => (isset($question['question']) ? $question['question'] : ''),
                    'ALLOW_MULTI' => (isset($question['allow_multi']) && $question['allow_multi'] == 'Y') ? 'Y' : 'N',
                    'OPTIONS_ARRAY' => array(),
                );

                if (isset($question['options']) && is_array($question['options'])) {

                    foreach ($question['options'] as $option) {

                        if (!is_scalar($option)) continue;

                        $poll_option = array(
                            'OPTION_ID' => sizeof($poll_question['OPTIONS_ARRAY']) + 1,
                            'OPTION_NAME' => $option,
                        );

                        $poll_question['OPTIONS_ARRAY'][$poll_option['OPTION_ID']] = $poll_option;
                    }
                }

                $poll_questions_array[$poll_question['QUESTION_ID']] = $poll_question;
            }
        }

    } else {

        $poll_questions_array = poll_get_default_questions_array();
    }
}

if (sizeof($poll_questions_array) == 0) {
    $poll_questions_array = poll_get_default_questions_array();
}

if (isset($_POST['add_option']) && is_array($_POST['add_option'])) {

    list($question_id) = array_keys($_POST['add_option']);

    if (isset($poll_questions_array[$question_id])) {

        $option_id = sizeof($poll_questions_array[$question_id]['OPTIONS_ARRAY']) + 1;

        $poll_questions_array[$question_id]['OPTIONS_ARRAY'][] = poll_get_option_array($option_id);
    }
}

if (isset($_POST['add_question'])) {

    $question_id = sizeof($poll_questions_array) + 1;

    $poll_questions_array[] = poll_get_question_array($question_id);
}

if (isset($_POST['delete_option']) && is_array($_POST['delete_option'])) {

    foreach ($_POST['delete_option'] as $question_id => $option_id_array) {

        if (!is_array($option_id_array)) continue;

        if (sizeof($poll_questions_array[$question_id]['OPTIONS_ARRAY']) > 1) {

            foreach (array_keys($option_id_array) as $option_id) {
                unset($poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]);
            }
        }
    }
}

if (isset($_POST['delete_question']) && is_array($_POST['delete_question'])) {

    list($question_id) = array_keys($_POST['delete_question']);

    if (sizeof($poll_questions_array) > 1) {
        unset($poll_questions_array[$question_id]);
    }
}

if (isset($_POST['poll_type']) && is_numeric($_POST['poll_type'])) {
    $poll_type = $_POST['poll_type'];
}

if (isset($_POST['show_results']) && is_numeric($_POST['show_results'])) {
    $show_results = $_POST['show_results'];
}

if (isset($_POST['poll_vote_type']) && is_numeric($_POST['poll_vote_type'])) {
    $poll_vote_type = $_POST['poll_vote_type'];
}

if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
    $option_type = $_POST['option_type'];
}

if (isset($_POST['change_vote']) && is_numeric($_POST['change_vote'])) {
    $change_vote = $_POST['change_vote'];
}

if (forum_get_setting('poll_allow_guests', 'Y')) {

    if (isset($_POST['allow_guests']) && $_POST['allow_guests'] == POLL_GUEST_ALLOWED) {
        $allow_guests = POLL_GUEST_ALLOWED;
    } else {
        $allow_guests = POLL_GUEST_DENIED;
    }

} else {

    $allow_guests = POLL_GUEST_DENIED;
}

if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
    $close_poll = $_POST['close_poll'];
}

if (isset($_POST['message_text']) && strlen(trim($_POST['message_text'])) > 0) {
    $message_text = fix_html(emoticons_strip($_POST['message_text']));
}

$allow_html = true;

$allow_sig = true;

if (isset($fid) && !session::check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($fid) && !session::check_perm(USER_PERM_SIGNATURE, $fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    $message_text = htmlentities_array($message_text);
    $sig_text = htmlentities_array($sig_text);
}

if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
    $attachments = array_filter($_POST['attachment'], 'is_md5');
} else {
    $attachments = array();
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['post'])) {

    $valid = true;

    if (!isset($thread_title) || strlen(trim($thread_title)) == 0) {

        $error_msg_array[] = gettext("You must enter a title for the thread!");
        $valid = false;
    }

    if (!isset($fid) || !folder_is_valid($fid)) {

        $error_msg_array[] = gettext("Unknown folder");
        $valid = false;
    }

    if (!session::check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = gettext("You cannot create new threads in this folder");
        $valid = false;
    }

    if (isset($fid) && sizeof($attachments) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if (sizeof($attachments) > 0 && !attachments_check_post_space($_SESSION['UID'], $attachments)) {

        $max_post_attachment_space = forum_get_setting('attachments_max_post_space', 'is_numeric', 1048576);
        $error_msg_array[] = gettext(sprintf("You have too many files attached to this post. Maximum attachment space per post is %s", format_file_size($max_post_attachment_space)));
        $valid = false;
    }

    if (!folder_thread_type_allowed($fid, FOLDER_ALLOW_POLL_THREAD)) {

        $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
        $valid = false;
    }

    if ($valid && (!isset($poll_type) || !is_numeric($poll_type))) {

        $error_msg_array[] = gettext("You must provide a poll type");
        $valid = false;
    }

    if ($valid && (!isset($show_results) || !is_numeric($show_results))) {

        $error_msg_array[] = gettext("You must provide results display type");
        $valid = false;
    }

    if ($valid && (!isset($poll_vote_type) || !is_numeric($poll_vote_type))) {

        $error_msg_array[] = gettext("You must provide a poll vote type");
        $valid = false;
    }

    if ($valid && (!isset($option_type) || !is_numeric($option_type))) {

        $error_msg_array[] = gettext("You must provide a poll option type");
        $valid = false;
    }

    if ($valid && (!isset($change_vote) || !is_numeric($change_vote))) {

        $error_msg_array[] = gettext("You must provide a poll vote type");
        $valid = false;
    }

    if ($valid && (!isset($allow_guests) || !is_numeric($allow_guests))) {

        $error_msg_array[] = gettext("You must specify if guests should be allowed to vote");
        $valid = false;
    }

    if (!isset($close_poll) || !is_numeric($close_poll)) {
        $close_poll = false;
    }

    $poll_option_count = 0;

    if (isset($poll_questions_array) && sizeof($poll_questions_array) > 0) {

        foreach ($poll_questions_array as $question_id => $question) {

            if (!isset($question['ALLOW_MULTI']) || ($question['ALLOW_MULTI'] != 'Y')) {
                $poll_questions_array[$question_id]['ALLOW_MULTI'] = 'N';
            }

            if (($option_type == POLL_OPTIONS_DROPDOWN) && ($question['ALLOW_MULTI'] == 'Y')) {

                $error_msg_array[] = gettext("Allow multiple option selection is not available with drop-down list options display");
                $valid = false;
            }

            if (!isset($question['QUESTION']) || strlen(trim($question['QUESTION'])) == 0) {

                if (!isset($question['OPTIONS_ARRAY']) || !is_array($question['OPTIONS_ARRAY'])) {

                    unset($poll_questions_array[$question_id]);

                } else {

                    foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                        if (!isset($option['OPTION_NAME']) || strlen(trim($option['OPTION_NAME'])) == 0) {
                            unset($question['OPTIONS_ARRAY'][$option_id]);
                        }
                    }

                    if (sizeof($question['OPTIONS_ARRAY']) == 0) {

                        unset($poll_questions_array[$question_id]);

                    } else if (sizeof($question['OPTIONS_ARRAY']) > 0) {

                        $error_msg_array[] = gettext("You must provide a question for all options");
                        $valid = false;
                    }
                }

            } else if (!isset($question['OPTIONS_ARRAY']) || !is_array($question['OPTIONS_ARRAY'])) {

                $error_msg_array[] = gettext("You must provide at least 2 options for each question");
                $valid = false;

            } else {

                foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                    if (!isset($option['OPTION_NAME']) || strlen(trim($option['OPTION_NAME'])) == 0) {
                        unset($question['OPTIONS_ARRAY'][$option_id]);
                    }
                }

                if ($allow_html == true) {
                    $question['QUESTION'] = fix_html(emoticons_strip($question['QUESTION']));
                } else {
                    $question['QUESTION'] = htmlentities_array($question['QUESTION']);
                }

                $poll_option_count += sizeof($question['OPTIONS_ARRAY']);

                if (sizeof($question['OPTIONS_ARRAY']) < 2) {

                    $error_msg_array[] = gettext("You must provide at least 2 options for each question");
                    $valid = false;

                } else {

                    foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                        if ($allow_html == true) {
                            $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = fix_html($option['OPTION_NAME']);
                        } else {
                            $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = htmlentities_array($option['OPTION_NAME']);
                        }

                        if (attachments_embed_check($option['OPTION_NAME']) && ($allow_html == true)) {

                            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
                            $valid = false;
                        }
                    }
                }
            }
        }
    }

    if (sizeof($poll_questions_array) < 1) {

        $poll_questions_array = poll_get_default_questions_array();

        $error_msg_array[] = gettext("You must provide at least one question");

        $valid = false;
    }

    if ($valid && ($poll_option_count > 20)) {

        $error_msg_array[] = gettext("You can have a maximum of 20 options per poll");
        $valid = false;
    }

    if ($valid && ($poll_type == POLL_TABLE_GRAPH) && sizeof($poll_questions_array) <> 2) {

        $error_msg_array[] = gettext("Tabular format polls must have precisely two questions");
        $valid = false;
    }

    if ($valid && ($poll_type == POLL_TABLE_GRAPH) && ($change_vote == POLL_VOTE_MULTI)) {

        $error_msg_array[] = gettext("Tabular format polls cannot be multi-vote");
        $valid = false;
    }

    if ($valid && ($poll_vote_type == POLL_VOTE_PUBLIC) && ($change_vote == POLL_VOTE_MULTI)) {

        $error_msg_array[] = gettext("Public ballots cannot be multi-vote");
        $valid = false;
    }

    if ($valid && ($poll_vote_type == POLL_VOTE_PUBLIC) && ($poll_type != POLL_HORIZONTAL_GRAPH)) {

        $error_msg_array[] = gettext("Public ballots can only be created using horizontal graphs");
        $valid = false;
    }

    if (isset($message_text) && strlen(trim($message_text)) > 0) {

        if (attachments_embed_check($message_text)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }
    }

    if (isset($sig_text) && attachments_embed_check($sig_text)) {

        $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
        $valid = false;
    }

} else if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x']) || isset($_POST['poll_additional_message_toggle_x']) || isset($_POST['poll_advanced_toggle_x'])) {

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double)$page_prefs ^ POST_SIGNATURE_DISPLAY;

    } else if (isset($_POST['poll_additional_message_toggle_x'])) {

        $page_prefs = (double)$page_prefs ^ POLL_ADDITIONAL_MESSAGE_DISPLAY;

    } else if (isset($_POST['poll_advanced_toggle_x'])) {

        $page_prefs = (double)$page_prefs ^ POLL_ADVANCED_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (!isset($message_text)) $message_text = "";

if (!isset($sig_text)) $sig_text = "";

if ((mb_strlen($message_text) + mb_strlen($sig_text)) >= 65535) {

    $error_msg_array[] = sprintf(
        gettext("Combined Message and signature length must be less than 65,535 characters (currently: %s)"),
        format_number(mb_strlen($message_text) + mb_strlen($sig_text))
    );

    $valid = false;
}

if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = $_POST['dedupe'];
} else {
    $dedupe = time();
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($dedupe)) {

            if ($close_poll == POLL_CLOSE_ONE_DAY) {

                $poll_closes = time() + DAY_IN_SECONDS;

            } else if ($close_poll == POLL_CLOSE_THREE_DAYS) {

                $poll_closes = time() + (DAY_IN_SECONDS * 3);

            } else if ($close_poll == POLL_CLOSE_SEVEN_DAYS) {

                $poll_closes = time() + (DAY_IN_SECONDS * 7);

            } else if ($close_poll == POLL_CLOSE_THIRTY_DAYS) {

                $poll_closes = time() + (DAY_IN_SECONDS * 30);

            } else if ($close_poll == POLL_CLOSE_NEVER) {

                $poll_closes = false;
            }

            if (($tid = post_create_thread($fid, $_SESSION['UID'], $thread_title, 'Y', 'N'))) {

                if (($new_pid = post_create($fid, $tid, 0, $_SESSION['UID'], array(), ''))) {

                    poll_create($tid, $poll_questions_array, $poll_closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $allow_guests);

                    email_send_notification($tid, $new_pid);

                    email_send_thread_subscription($tid, $new_pid);

                    email_send_folder_subscription($fid, $tid, $new_pid);

                    if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $_SESSION['UID']) && !perm_is_moderator($_SESSION['UID'], $fid)) {
                        admin_send_post_approval_notification($fid);
                    }

                    if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], $attachments)) !== false) {

                        foreach ($attachments_array as $attachment) {

                            post_add_attachment($tid, $new_pid, $attachment['aid']);
                        }
                    }

                    if (strlen($message_text) > 0) {

                        if ($allow_sig == true && strlen(trim($sig_text)) > 0) {
                            $message_text .= "<div class=\"sig\">$sig_text</div>";
                        }

                        post_create($fid, $tid, 1, $_SESSION['UID'], array(), $message_text);
                    }

                    if ($high_interest == "Y") {
                        thread_set_high_interest($tid);
                    }
                }
            }
        }

        if (isset($tid) && $tid > 0) {
            $uri = "discussion.php?webtag=$webtag&msg=$tid.1";
        } else {
            $uri = "discussion.php?webtag=$webtag";
        }

        header_redirect($uri);

    } else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', 'is_numeric', 0));
    }
}

if (!$folder_dropdown = folder_draw_dropdown($fid, "fid", "", FOLDER_ALLOW_POLL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown")) {
    html_draw_error(gettext("You cannot create new threads."));
}

html_draw_top(
    array(
        'title' => gettext('Create Poll'),
        'base_target' => '_blank',
        'js' => array(
            'js/post.js',
            'js/poll.js',
            'js/attachments.js',
            'js/emoticons.js',
            'ckeditor/ckeditor.js',
            'js/fineuploader.min.js'
        ),
        'class' => 'window_title max_width'
    )
);

echo "<h1>", gettext("Create Poll"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '960', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_poll\" action=\"create_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('dedupe', htmlentities_array($dedupe)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"960\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && (isset($_POST['preview_poll']) || isset($_POST['preview_form']))) {

    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Preview"), "</td>\n";
    echo "                </tr>";

    $poll_data['POLLTYPE'] = $poll_type;
    $poll_data['VOTETYPE'] = $poll_vote_type;
    $poll_data['OPTIONTYPE'] = $option_type;

    $poll_data['RECIPIENTS'] = array();

    $preview_from_user = user_get($_SESSION['UID']);

    $poll_data['FROM_LOGON'] = $preview_from_user['LOGON'];
    $poll_data['FROM_NICKNAME'] = $preview_from_user['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_from_user['UID'];

    $poll_preview_questions_array = $poll_questions_array;

    if (isset($_POST['preview_form'])) {

        $poll_display = poll_voting_form($poll_preview_questions_array, $poll_data);

    } else {

        $poll_display = "<div align=\"center\">\n";
        $poll_display .= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        $poll_display .= "    <tr>\n";
        $poll_display .= "      <td align=\"center\">\n";
        $poll_display .= "        <table width=\"100%\">\n";

        foreach ($poll_preview_questions_array as $question_id => $question) {

            foreach (array_keys($question['OPTIONS_ARRAY']) as $option_id) {
                $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['VOTES_ARRAY'] = array();
            }
        }

        $total_vote_count = 0;

        if (($random_users_array = poll_get_random_users(mt_rand(10, 20))) !== false) {

            while (($random_user = array_pop($random_users_array)) !== null) {

                $total_vote_count++;

                foreach ($poll_preview_questions_array as $question_id => $question) {

                    $option = $question['OPTIONS_ARRAY'][array_rand($question['OPTIONS_ARRAY'])];

                    $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option['OPTION_ID']]['VOTES_ARRAY'][] = $random_user;
                }
            }
        }

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            $poll_display .= "          <tr>\n";
            $poll_display .= "            <td align=\"left\" colspan=\"2\">" . poll_table_graph($poll_preview_questions_array, $poll_data, $total_vote_count) . "</td>\n";
            $poll_display .= "           </tr>\n";

        } else {

            foreach ($poll_preview_questions_array as $question_id => $poll_question) {

                $poll_display .= "          <tr>\n";
                $poll_display .= "            <td align=\"left\"><h2>" . word_filter_add_ob_tags($poll_question['QUESTION'], true) . "</h2></td>\n";
                $poll_display .= "          </tr>\n";
                $poll_display .= "          <tr>\n";
                $poll_display .= "            <td align=\"left\">\n";
                $poll_display .= "              <table width=\"100%\">\n";

                if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $poll_display .= "                <tr>\n";
                    $poll_display .= "                  <td align=\"left\" colspan=\"2\">" . poll_vertical_graph($poll_question['OPTIONS_ARRAY'], $total_vote_count) . "</td>\n";
                    $poll_display .= "                </tr>\n";

                } else if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC) {

                    $poll_display .= "                <tr>\n";
                    $poll_display .= "                  <td align=\"left\" colspan=\"2\">" . poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_vote_count) . "</td>\n";
                    $poll_display .= "                 </tr>\n";

                } else {

                    $poll_display .= "                <tr>\n";
                    $poll_display .= "                  <td align=\"left\" colspan=\"2\">" . poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_vote_count) . "</td>\n";
                    $poll_display .= "                 </tr>\n";
                }

                $poll_display .= "              </table>\n";
                $poll_display .= "            </td>\n";
                $poll_display .= "          </tr>\n";
            }
        }

        $poll_display .= "          </table>\n";
        $poll_display .= "        </form>\n";
        $poll_display .= "      </td>\n";
        $poll_display .= "    </tr>\n";
        $poll_display .= "  </table>\n";
        $poll_display .= "</div>\n";
    }

    $poll_display .= "<p class=\"postbody\" align=\"center\">" . gettext("Note: Poll votes are randomly generated for preview only.") . "</p>\n";

    $poll_data['CONTENT'] = $poll_display;
    $poll_data['ATTACHMENTS'] = $attachments;

    echo "                <tr>\n";
    echo "                  <td align=\"center\"><br />\n";

    message_display(0, $poll_data, 0, 0, 0, false, false, true, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";

    if (strlen($message_text) > 0) {

        $poll_data['CONTENT'] = $message_text;

        if ($allow_sig == true && strlen(trim($sig_text)) > 0) {
            $poll_data['CONTENT'] .= "<div class=\"sig\">$sig_text</div>";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"center\"><br />";

        message_display(0, $poll_data, 0, 0, 0, false, false, false, $show_sigs, true);

        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Create Poll"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Folder"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">$folder_dropdown</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Thread title"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("thread_title", isset($thread_title) ? htmlentities_array($thread_title) : null, 30, 64, null, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Thread options"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_interest", "Y", gettext("Set thread to high interest"), $high_interest == "Y"), "</td>\n";
echo "                      </tr>\n";

if (session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Admin"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("closed", "Y", gettext("Close for posting"), (isset($closed) ? $closed == 'Y' : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("sticky", "Y", gettext("Make sticky"), (isset($sticky) ? $sticky == 'Y' : false)), "</td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";

if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {
    $user_emoticon_pack = $_SESSION['EMOTICONS'];
} else {
    $user_emoticon_pack = forum_get_setting('default_emoticons', 'strlen', 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack)) !== false) {

    echo "                    <br />\n";
    echo "                    <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'emots_toggle', 'hide', null, 'button_image toggle_button', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'emots_toggle', 'show', null, 'button_image toggle_button', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                          <div class=\"emots_toggle\">{$emoticon_preview_html}</div>\n";
    } else {
        echo "                          <div class=\"emots_toggle\" style=\"display: none\">{$emoticon_preview_html}</div>\n";
    }

    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
}

echo "                  </td>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"740\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>", gettext("Poll"), "</h2>\n";
echo "                          <p>", gettext("Enter some questions and the options for your poll. If your poll is a &quot;yes/no&quot; question, simply enter &quot;Yes&quot; and &quot;No&quot; as two separate options."), "</p>\n";
echo "                          <div class=\"poll_questions_container\">\n";

foreach ($poll_questions_array as $question_id => $question) {

    echo "                            <fieldset class=\"poll_question\">\n";
    echo "                              <div>\n";
    echo "                                <h2>", gettext("Poll Question"), "</h2>\n";
    echo "                                <div class=\"poll_question_input\">\n";
    echo "                                  ", form_input_text("poll_questions[{$question_id}][question]", htmlentities_array($question['QUESTION']), 40, 255), "&nbsp;", form_button_html("delete_question[{$question_id}]", 'submit', 'button_image delete_question', html_style_image('delete'), sprintf('title="%s"', gettext("Delete question"))), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_question_checkbox\">\n";
    echo "                                  ", form_checkbox("poll_questions[{$question_id}][allow_multi]", "Y", gettext("Allow multiple options to be selected"), (isset($question['ALLOW_MULTI']) && $question['ALLOW_MULTI'] == 'Y')), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_options_list\">\n";
    echo "                                  <ol>\n";

    if (isset($question['OPTIONS_ARRAY']) && is_array($question['OPTIONS_ARRAY'])) {

        foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {
            echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][{$option_id}]", htmlentities_array($option['OPTION_NAME']), 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][{$option_id}]", 'submit', 'button_image delete_option', html_style_image('delete'), sprintf('title="%s"', gettext("Delete option"))), "</li>\n";
        }

    } else {

        echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][0]", null, 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][0]", 'submit', 'button_image delete_option', html_style_image('delete'), sprintf('title="%s"', gettext("Delete option"))), "</li>\n";

        if (isset($_POST['add_option'][$question_id])) {
            echo poll_get_option_html($question_id, 1);
        }
    }

    echo "                                  </ol>\n";
    echo "                                </div>\n";
    echo "                              </div>\n";
    echo "                            ", form_button_html("add_option[{$question_id}]", 'submit', 'button_image add_option', html_style_image('add', gettext("Add new option")) . '&nbsp;' . gettext("Add new option")), "\n";
    echo "                            </fieldset>\n";
}

echo "                          </div>\n";
echo "                          <table width=\"100%\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_button_html('add_question', 'submit', 'button_image add_question', html_style_image('add', gettext("Add new question")) . '&nbsp;' . gettext("Add new question")), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                          <table width=\"100%\">\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">", gettext("Advanced Options"), "</td>\n";

if (($page_prefs & POLL_ADVANCED_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'poll_advanced_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'poll_advanced_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_ADVANCED_DISPLAY) > 0) {
    echo "                                <div class=\"poll_advanced_toggle\">\n";
} else {
    echo "                                <div class=\"poll_advanced_toggle\" style=\"display: none\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Options display type"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("How should the options be presented?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('option_type', POLL_OPTIONS_RADIOS, gettext("As a series of radio buttons"), isset($option_type) ? $option_type == POLL_OPTIONS_RADIOS : true), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, gettext("As drop-down list(s)"), isset($option_type) ? $option_type == POLL_OPTIONS_DROPDOWN : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Vote Changing"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("Can a person change his or her vote?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, gettext("Yes"), isset($change_vote) ? $change_vote == POLL_VOTE_CAN_CHANGE : true), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, gettext("No"), isset($change_vote) ? $change_vote == POLL_VOTE_CANNOT_CHANGE : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, gettext("Allow Multiple Votes"), isset($change_vote) ? $change_vote == POLL_VOTE_MULTI : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";

if (forum_get_setting('poll_allow_guests', 'Y')) {

    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\"><h2>", gettext("Guest Voting"), "</h2></td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">", gettext("Can guests vote in this poll?"), "</td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">\n";
    echo "                                              <table border=\"0\" width=\"100%\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, gettext("Yes"), isset($allow_guests) ? $allow_guests == POLL_GUEST_ALLOWED : false), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\">", form_radio('allow_guests', POLL_GUEST_DENIED, gettext("No"), isset($allow_guests) ? $allow_guests == POLL_GUEST_DENIED : true), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                            </td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">&nbsp;</td>\n";
    echo "                                          </tr>\n";
}

echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Poll Results"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("How would you like to display the results of your poll?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, gettext("Horizontal graph"), isset($poll_type) ? $poll_type == POLL_HORIZONTAL_GRAPH : true), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, gettext("Vertical graph"), isset($poll_type) ? $poll_type == POLL_VERTICAL_GRAPH : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_TABLE_GRAPH, gettext("Tabular format"), isset($poll_type) ? $poll_type == POLL_TABLE_GRAPH : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Poll Voting Type"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("How should the poll be conducted?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_ANON, gettext("Anonymously"), isset($poll_vote_type) ? $poll_vote_type == POLL_VOTE_ANON : true), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, gettext("Public ballot"), isset($poll_vote_type) ? $poll_vote_type == POLL_VOTE_PUBLIC : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Expiration"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("Do you want to show results while the poll is open?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, gettext("Yes"), isset($show_results) ? $show_results == POLL_SHOW_RESULTS : true), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, gettext("No"), isset($show_results) ? $show_results == POLL_HIDE_RESULTS : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("When would you like your poll to automatically close?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", form_dropdown_array('close_poll', array(gettext("One day"), gettext("Three days"), gettext("Seven days"), gettext("Thirty days"), gettext("Never")), isset($close_poll) ? $close_poll : 4), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                        </table>\n";
echo "                                      </td>\n";
echo "                                    </tr>\n";
echo "                                  </table>\n";
echo "                                </div>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">", gettext("Additional Message"), "</td>\n";

if (($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'poll_additional_message_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'poll_additional_message_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY) > 0) {
    echo "                                <div class=\"poll_additional_message_toggle\" style=\"width: 540px\">\n";
} else {
    echo "                                <div class=\"poll_additional_message_toggle\" style=\"display: none; width: 540px\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"100%\" cellpadding=\"0\">\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("Do you want to include an additional post after the poll?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", form_textarea('message_text', htmlentities_array(emoticons_apply($message_text)), 22, 100, 'tabindex="1"', 'create_poll post_content editor'), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";

if (attachments_check_dir() && (session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid))) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table class=\"messagefoot\" width=\"100%\" cellspacing=\"0\">\n";
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

if ($allow_sig == true) {

    echo "                                            </td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">&nbsp;</td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">\n";
    echo "                                              <table class=\"messagefoot\" width=\"100%\" cellspacing=\"0\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" class=\"subhead\">", gettext("Signature"), "</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'sig_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'sig_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" colspan=\"2\">\n";
    echo "                                                    <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";
    echo "                                                      ", form_textarea("sig_text", htmlentities_array(emoticons_apply($sig_text)), 7, 100, 'tabindex="7"', 'create_poll signature_content editor');
    echo "                                                    </div>\n";
    echo "                                                  </td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
}

echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                        </table>\n";
echo "                                      </td>\n";
echo "                                    </tr>\n";
echo "                                  </table>\n";
echo "                                </div>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                ", form_submit("post", gettext("Post")), "&nbsp;", form_submit("preview_poll", gettext("Preview")), "&nbsp;", form_submit("preview_form", gettext("Preview Voting Form"));
echo "&nbsp;<a href=\"discussion.php?webtag=$webtag\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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