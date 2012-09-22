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

// Check to see if the forum owner has allowed the creation of polls
if (forum_get_setting('allow_polls', 'N')) {
    html_draw_error(gettext("Polls have been disabled by the forum owner."));
}

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {
    html_message_type_error();
}

// Array to hold error messages
$error_msg_array = array();

// Check if the user is viewing signatures.
$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Get the user's UID. We need this a couple of times
$uid = session::get_value('UID');

// Assume everything is A-OK!
$valid = true;

if (isset($_POST['post_emots'])) {

    if ($_POST['post_emots'] == "disabled") {
        $emots_enabled = false;
    } else {
        $emots_enabled = true;
    }

} else {

    $emots_enabled = true;
}

if (isset($_POST['post_links'])) {

    if ($_POST['post_links'] == "enabled") {
        $links_enabled = true;
    } else {
        $links_enabled = false;
    }

} else {

    $links_enabled = false;
}

if (isset($_POST['check_spelling'])) {

    if ($_POST['check_spelling'] == "enabled") {
        $spelling_enabled = true;
    } else {
        $spelling_enabled = false;
    }

} else {

    $spelling_enabled = false;
}

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

if (isset($_POST['message_html'])) {

    $message_html = $_POST['message_html'];

    if ($message_html == "enabled_auto") {
        $message_html = POST_HTML_AUTO;
    } else if ($message_html == "enabled") {
        $message_html = POST_HTML_ENABLED;
    } else {
        $message_html = POST_HTML_DISABLED;
    }

} else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $message_html = POST_HTML_AUTO;
    } else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $message_html = POST_HTML_ENABLED;
    } else {
        $message_html = POST_HTML_DISABLED;
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

    if (($page_prefs & POST_CHECK_SPELLING) > 0) {
        $spelling_enabled = true;
    } else {
        $spelling_enabled = false;
    }

    if (($high_interest = session::get_value('MARK_AS_OF_INT')) === false) {
        $high_interest = "N";
    }
}

if (isset($_POST['sig_html'])) {

    $sig_html = $_POST['sig_html'];

    if ($sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

} else {

    $sig_text = '';
    $sig_html = 'N';

    if (!user_get_sig($uid, $sig_text, $sig_html)) {

        $sig_text = '';
        $sig_html = 'N';
    }

    if ($sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $sig_text = tidy_html($sig_text, false);

    $fetched_sig = true;
}

if (isset($_POST['options_html']) && ($_POST['options_html'] == 'Y')) {
    $options_html = 'Y';
} else {
    $options_html = 'N';
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

if (isset($_POST['allow_guests']) && is_numeric($_POST['allow_guests'])) {
    $allow_guests = $_POST['allow_guests'];
} else if (forum_get_setting('poll_allow_guests', 'N')) {
    $allow_guests = POLL_GUEST_DENIED;
}

if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
    $close_poll = $_POST['close_poll'];
}

if (isset($_POST['message_text']) && strlen(trim($_POST['message_text'])) > 0) {
    $message_text = trim($_POST['message_text']);
}

if (isset($_POST['sig_text'])) {
    $sig_text = trim($_POST['sig_text']);
}

$allow_html = true;
$allow_sig = true;

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else{
    $aid = md5(uniqid(mt_rand()));
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

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

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
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

                $poll_option_count+= sizeof($question['OPTIONS_ARRAY']);

                if (sizeof($question['OPTIONS_ARRAY']) < 2) {

                    $error_msg_array[] = gettext("You must provide at least 2 options for each question");
                    $valid = false;

                } else {

                    foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                        if (($allow_html == true) && isset($options_html) && ($options_html == 'Y')) {

                            $poll_option_check_html = new MessageText(POST_HTML_ENABLED, $option['OPTION_NAME']);

                            $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = $poll_option_check_html->getContent();

                            if (strlen(trim($poll_option_check_html->getContent())) == 0) {

                                $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = $poll_option_check_html->getOriginalContent();

                                $error_msg_array[] = gettext("One or more of your Poll Questions contains invalid HTML.");

                                $valid = false;
                            }
                        }

                        if (attachments_embed_check($option['OPTION_NAME']) && ($options_html == 'Y')) {

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

        if (attachments_embed_check($message_text) && ($message_html == 'Y')) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }
    }

    if (isset($sig_text)) {

        if ($sig_html && attachments_embed_check($sig_text)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
            $valid = false;
        }
    }

} else if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x']) || isset($_POST['poll_additional_message_toggle_x']) || isset($_POST['poll_advanced_toggle_x'])) {

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;

    } else if (isset($_POST['poll_additional_message_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POLL_ADDITIONAL_MESSAGE_DISPLAY;

    } else if (isset($_POST['poll_advanced_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POLL_ADVANCED_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );
    
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (isset($fid) && !session::check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($fid) && !session::check_perm(USER_PERM_SIGNATURE, $fid)) {
    $allow_sig = false;
}

if (!isset($message_text)) $message_text = "";

if (!isset($sig_text)) $sig_text = "";

$post = new MessageText($message_html, $message_text, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $sig_text, $emots_enabled, $links_enabled, false);

$message_text = $post->getContent();

$sig_text = $sig->getContent();

if (mb_strlen($message_text) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($message_text)));
    $valid = false;
}

if (mb_strlen($sig_text) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Signature length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($sig_text)));
    $valid = false;
}

if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = $_POST['dedupe'];
} else{
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

            if ($allow_html == false || !isset($message_html) || $message_html == POST_HTML_DISABLED) {

                foreach ($poll_questions_array as $question_id => $question) {

                    foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {
                        $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = htmlentities_array($option['OPTION_NAME']);
                    }
                }
            }

            $tid = post_create_thread($fid, $uid, $thread_title, 'Y', 'N');

            $pid = post_create($fid, $tid, 0, $uid, 0, '');

            poll_create($tid, $poll_questions_array, $poll_closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $allow_guests);

            post_save_attachment_id($tid, $pid, $aid);

            if (strlen($message_text) > 0) {

                if ($allow_sig == true && strlen(trim($sig_text)) > 0) {
                    $message_text.= "<div class=\"sig\">$sig_text</div>";
                }

                post_create($fid, $tid, 1, $uid, $uid, $message_text);
            }

            if ($high_interest == "Y") thread_set_high_interest($tid);
        }

        if (isset($tid) && $tid > 0) {
            $uri = "discussion.php?webtag=$webtag&msg=$tid.1";
        } else {
            $uri = "discussion.php?webtag=$webtag";
        }

        header_redirect($uri);

    } else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', null, 0));
    }
}

if (!$folder_dropdown = folder_draw_dropdown($fid, "fid", "" ,FOLDER_ALLOW_POLL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown")) {
    html_draw_error(gettext("You cannot create new threads."));
}

html_draw_top(sprintf("title=%s", gettext("Create Poll")), "basetarget=_blank", "resize_width=785", "post.js", "poll.js", "attachments.js", "dictionary.js", "emoticons.js", 'class=window_title');

echo "<h1>", gettext("Create Poll"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '785', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_poll\" action=\"create_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('dedupe', htmlentities_array($dedupe)), "\n";
echo "  <table width=\"785\" class=\"max_width\">\n";
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

    $poll_data['TLOGON'] = gettext("ALL");
    $poll_data['TNICK'] = gettext("ALL");

    $preview_tuser = user_get($uid);

    $poll_data['FLOGON']   = $preview_tuser['LOGON'];
    $poll_data['FNICK']    = $preview_tuser['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_tuser['UID'];

    $poll_preview_questions_array = $poll_questions_array;

    if ($allow_html == false || !isset($options_html) || $options_html == 'N') {

        foreach ($poll_preview_questions_array as $question_id => $poll_question) {

            foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = htmlentities_array($option['OPTION_NAME']);
            }
        }
    }

    if (isset($_POST['preview_form'])) {

        $poll_display = poll_voting_form($poll_preview_questions_array, $poll_data);

    } else {

        $poll_display = "<div align=\"center\">\n";
        $poll_display.= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
        $poll_display.= "    <tr>\n";
        $poll_display.= "      <td align=\"center\">\n";
        $poll_display.= "        <table width=\"560\">\n";

        foreach ($poll_preview_questions_array as $question_id => $question) {

            foreach (array_keys($question['OPTIONS_ARRAY']) as $option_id) {
                $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['VOTES_ARRAY'] = array();
            }
        }

        $total_vote_count = 0;

        if (($random_users_array = poll_get_random_users(mt_rand(10, 20)))) {

            while (($random_user = array_pop($random_users_array))) {

                $total_vote_count++;

                foreach ($poll_preview_questions_array as $question_id => $question) {

                    $option = $question['OPTIONS_ARRAY'][array_rand($question['OPTIONS_ARRAY'])];

                    $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option['OPTION_ID']]['VOTES_ARRAY'][] = $random_user;
                }
            }
        }

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\" colspan=\"2\">". poll_table_graph($poll_preview_questions_array, $poll_data, $total_vote_count). "</td>\n";
            $poll_display.= "           </tr>\n";

        } else {

            foreach ($poll_preview_questions_array as $question_id => $poll_question) {

                $poll_display.= "          <tr>\n";
                $poll_display.= "            <td align=\"left\"><h2>". word_filter_add_ob_tags($poll_question['QUESTION'], true). "</h2></td>\n";
                $poll_display.= "          </tr>\n";
                $poll_display.= "          <tr>\n";
                $poll_display.= "            <td align=\"left\">\n";
                $poll_display.= "              <table width=\"100%\">\n";

                if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_vertical_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_vote_count). "</td>\n";
                    $poll_display.= "                </tr>\n";

                } else if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC) {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_vote_count). "</td>\n";
                    $poll_display.= "                 </tr>\n";

                } else {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_vote_count). "</td>\n";
                    $poll_display.= "                 </tr>\n";
                }

                $poll_display.= "              </table>\n";
                $poll_display.= "            </td>\n";
                $poll_display.= "          </tr>\n";
            }
        }

        $poll_display.= "          </table>\n";
        $poll_display.= "        </form>\n";
        $poll_display.= "      </td>\n";
        $poll_display.= "    </tr>\n";
        $poll_display.= "  </table>\n";
        $poll_display.= "</div>\n";
    }

    $poll_display.= "<p class=\"postbody\" align=\"center\">". gettext("Note: Poll votes are randomly generated for preview only."). "</p>\n";

    $poll_data['CONTENT'] = $poll_display;

    $poll_data['AID'] = $aid;

    echo "                <tr>\n";
    echo "                  <td align=\"center\"><br />\n";

    message_display(0, $poll_data, 0, 0, 0, false, false, false, true, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";

    if (strlen($message_text) > 0) {

        $poll_data['CONTENT'] = $message_text;

        if ($allow_sig == true && strlen(trim($sig_text)) > 0) {
            $poll_data['CONTENT'].= "<div class=\"sig\">$sig_text</div>";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"center\"><br />", message_display(0, $poll_data, 0, 0, 0, false, false, false, false, $show_sigs, true), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

$tools = new TextAreaHTML("f_poll");

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Create Poll"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"220\">\n";
echo "                    <table class=\"posthead\" width=\"220\">\n";
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
echo "                        <td align=\"left\">", form_input_text("thread_title", isset($thread_title) ? htmlentities_array($thread_title) : '', 30, 64, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Message options"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_links", "enabled", gettext("Automatically parse URLs"), $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("check_spelling", "enabled", gettext("Automatically check spelling"), $spelling_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_emots", "disabled", gettext("Disable emoticons"), !$emots_enabled), "</td>\n";
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

if (($user_emoticon_pack = session::get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', null, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                    <br />\n";
    echo "                    <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'emots_toggle', 'hide', '', 'button_image toggle_button', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'emots_toggle', 'show', '', 'button_image toggle_button', '', 'button_image toggle_button'), "&nbsp;</td>\n";
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
echo "                  <td align=\"left\" valign=\"top\">\n";
echo "                    <table class=\"posthead\" width=\"530\">\n";
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
    echo "                                  ", form_input_text("poll_questions[{$question_id}][question]", htmlentities_array($question['QUESTION']), 40, 255), "&nbsp;", form_button_html("delete_question[{$question_id}]", 'submit', 'button_image delete_question', sprintf("<img src=\"%s\" alt=\"\" />", html_style_image('delete.png')), sprintf('title="%s"', gettext("Delete question"))), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_question_checkbox\">\n";
    echo "                                  ", form_checkbox("poll_questions[{$question_id}][allow_multi]", "Y", gettext("Allow multiple options to be selected"), (isset($question['ALLOW_MULTI']) && $question['ALLOW_MULTI'] == 'Y')), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_options_list\">\n";
    echo "                                  <ol>\n";

    if (isset($question['OPTIONS_ARRAY']) && is_array($question['OPTIONS_ARRAY'])) {

        foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {
            echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][{$option_id}]", htmlentities_array($option['OPTION_NAME']), 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][{$option_id}]", 'submit', 'button_image delete_option', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), sprintf('title="%s"', gettext("Delete option"))), "</li>\n";
        }

    } else {

        echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][0]", '', 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][0]", 'submit', 'button_image delete_option', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), sprintf('title="%s"', gettext("Delete option"))), "</li>\n";

        if (isset($_POST['add_option'][$question_id])) {
            echo poll_get_option_html($question_id, 1);
        }
    }

    echo "                                  </ol>\n";
    echo "                                </div>\n";
    echo "                              </div>\n";
    echo "                            ", form_button_html("add_option[{$question_id}]", 'submit', 'button_image add_option', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), gettext("Add new option"))), "\n";
    echo "                            </fieldset>\n";
}

echo "                          </div>\n";
echo "                          <table width=\"530\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_button_html('add_question', 'submit', 'button_image add_question', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), gettext("Add new question"))), "</td>\n";

if ($allow_html == true) {
    echo "                              <td align=\"right\">", form_checkbox('options_html', 'Y', gettext("Options Contain HTML"), (isset($options_html) && $options_html == 'Y')), "</td>\n";
} else {
    echo "                              <td align=\"right\">", form_input_hidden('options_html', 'N'), "</td>\n";
}

echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                          <table width=\"530\">\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">", gettext("Advanced Options"), "</td>\n";

if (($page_prefs & POLL_ADVANCED_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'poll_advanced_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'poll_advanced_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
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
echo "                                        <table border=\"0\" class=\"posthead\" width=\"510\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"27\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\"><h2>", gettext("Options display type"), "</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", gettext("How should the options be presented?"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_RADIOS, gettext("As a series of radio buttons"), isset($option_type) ? $option_type == POLL_OPTIONS_RADIOS : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, gettext("As drop-down list(s)"), isset($option_type) ? $option_type == POLL_OPTIONS_DROPDOWN : false), "</td>\n";
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
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, gettext("Yes"), isset($change_vote) ? $change_vote == POLL_VOTE_CAN_CHANGE : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, gettext("No"), isset($change_vote) ? $change_vote == POLL_VOTE_CANNOT_CHANGE : false), "</td>\n";
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
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, gettext("Yes"), isset($allow_guests) ? $allow_guests == POLL_GUEST_ALLOWED : false), "</td>\n";
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_DENIED, gettext("No"), isset($allow_guests) ? $allow_guests == POLL_GUEST_DENIED : true), "</td>\n";
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
echo "                                                  <td align=\"left\" width=\"25%\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, gettext("Horizontal graph"), isset($poll_type) ? $poll_type == POLL_HORIZONTAL_GRAPH : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"25%\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, gettext("Vertical graph"), isset($poll_type) ? $poll_type == POLL_VERTICAL_GRAPH : false), "</td>\n";
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
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'poll_additional_message_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'poll_additional_message_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY) > 0) {
    echo "                                <div class=\"poll_additional_message_toggle\">\n";
} else {
    echo "                                <div class=\"poll_additional_message_toggle\" style=\"display: none\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"510\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\">", gettext("Do you want to include an additional post after the poll?"), "</td>\n";
echo "                                          </tr>\n";

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {

    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">", $tools->toolbar(false), "</td>\n";
    echo "                                          </tr>\n";

} else {

    $tools->set_tinymce(false);
}

$message_text = $post->getTidyContent();

$sig_text = $sig->getTidyContent();

echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", $tools->textarea('message_text', $message_text, 20, 75, false, 'tabindex="1"', 'post_content'), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";

if ($post->isDiff()) {
    echo $tools->compare_original("message_text", $post);
}

if ($allow_html == true) {

    if (($tools->get_tinymce())) {

        echo form_input_hidden("message_html", "enabled");

    } else {

        echo "                                              <h2>", gettext("HTML in message"), "</h2>\n";

        echo form_radio("message_html", "disabled", gettext("Disabled"), $post->getHTML() == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("message_html", "enabled_auto", gettext("Enabled with auto-line-breaks"), $post->getHTML() == POST_HTML_AUTO)." \n";
        echo form_radio("message_html", "enabled", gettext("Enabled"), $post->getHTML() == POST_HTML_ENABLED)." \n";
    }

} else {

    echo form_input_hidden("message_html", "disabled");
}

echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";

if ($allow_sig == true) {

    echo "                                              <table class=\"messagefoot\" width=\"486\" cellspacing=\"0\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" class=\"subhead\">", gettext("Signature"), "</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'sig_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'sig_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" colspan=\"2\">\n";
    echo "                                                    <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";

    $sig_text = $sig->getTidyContent();

    echo $tools->textarea("sig_text", $sig_text, 5, 75, false, 'tabindex="7"', 'signature_content');

    if ($sig->isDiff()) {
        echo $tools->compare_original("sig_text", $sig);
    }

    echo "                                                    </div>\n";
    echo "                                                  </td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                              ", form_input_hidden("sig_html", $sig->getHTML() ? "Y" : "N"), "\n";
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

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "&nbsp;<a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
    echo "                                        ", form_input_hidden("aid", htmlentities_array($aid)), "\n";
}

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

?>