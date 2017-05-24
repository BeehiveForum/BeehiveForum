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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
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

$tid = null;
$pid = null;
$edit_msg = null;

$error_msg_array = array();

if (forum_get_setting('allow_polls', 'N')) {
    html_draw_error(gettext("Polls have been disabled by the forum owner."));
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $edit_msg);

    if (!($fid = thread_get_folder_fid($tid))) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $edit_msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!($fid = thread_get_folder_fid($tid))) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    html_draw_error(gettext("No message specified for editing"));
}

if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
    $return_msg = $_POST['return_msg'];
} else if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
    $return_msg = $_GET['return_msg'];
} else {
    $return_msg = $msg;
}

if (!thread_is_poll($tid) || ($pid != 1)) {

    header_redirect("edit.php?webtag=$webtag&msg=$msg&return_msg=$return_msg");
    exit;
}

if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {

    html_message_type_error();
    exit;
}

if (!($fid = thread_get_folder_fid($tid))) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $fid)) {
    html_draw_error(gettext("You cannot edit posts in this folder"));
}

if (!($thread_data = thread_get($tid))) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (!$edit_message = messages_get($tid, 1, 1)) {

    html_draw_top(
        array(
            'title' => gettext("Error")
        )
    );

    html_display_error_msg(gettext("That post does not exist in this thread!"));
    html_draw_bottom();
    exit;
}

$post_edit_time = forum_get_setting('post_edit_time', 'is_numeric', 0);

$show_sigs = session::show_sigs();

$page_prefs = session::get_post_page_prefs();

if ((forum_get_setting('allow_post_editing', 'N') || (($_SESSION['UID'] != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {
    html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $return_msg));
}

$poll_data = poll_get($tid);

$poll_questions_array = poll_get_votes($tid);

$valid = true;

if (isset($_POST['thread_title'])) {

    if (strlen(trim($_POST['thread_title'])) > 0) {
        $thread_title = trim($_POST['thread_title']);
    } else {
        $thread_title = '';
    }

} else {

    $thread_title = $thread_data['TITLE'];
}

if (isset($_POST['fid'])) {

    if (is_numeric($_POST['fid']) && ($_POST['fid'] > 0)) {
        $fid = $_POST['fid'];
    } else {
        $fid = 1;
    }
}

if (isset($_POST['poll_questions'])) {

    if (is_array($_POST['poll_questions'])) {

        $poll_questions_array = array();

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

if (isset($_POST['poll_type'])) {

    if (is_numeric($_POST['poll_type'])) {
        $poll_type = intval($_POST['poll_type']);
    } else {
        $poll_type = POLL_HORIZONTAL_GRAPH;
    }

} else {

    $poll_type = $poll_data['POLLTYPE'];
}

if (isset($_POST['show_results'])) {

    if (is_numeric($_POST['show_results'])) {
        $show_results = intval($_POST['show_results']);
    } else {
        $show_results = POLL_SHOW_RESULTS;
    }

} else {

    $show_results = $poll_data['SHOWRESULTS'];
}

if (isset($_POST['poll_vote_type'])) {

    if (is_numeric($_POST['poll_vote_type'])) {
        $poll_vote_type = intval($_POST['poll_vote_type']);
    } else {
        $poll_vote_type = POLL_VOTE_ANON;
    }

} else {

    $poll_vote_type = $poll_data['VOTETYPE'];
}

if (isset($_POST['option_type'])) {

    if (is_numeric($_POST['option_type'])) {
        $option_type = intval($_POST['option_type']);
    } else {
        $option_type = POLL_OPTIONS_RADIOS;
    }

} else {

    $option_type = $poll_data['OPTIONTYPE'];
}

if (isset($_POST['change_vote'])) {

    if (is_numeric($_POST['change_vote'])) {
        $change_vote = intval($_POST['change_vote']);
    } else {
        $change_vote = POLL_VOTE_CAN_CHANGE;
    }

} else {

    $change_vote = $poll_data['CHANGEVOTE'];
}

if (isset($_POST['allow_guests'])) {

    if (is_numeric($_POST['allow_guests'])) {
        $allow_guests = intval($_POST['allow_guests']);
    } else {
        $allow_guests = POLL_GUEST_DENIED;
    }

} else {

    if (forum_get_setting('poll_allow_guests', 'N')) {
        $allow_guests = POLL_GUEST_DENIED;
    } else {
        $allow_guests = $poll_data['ALLOWGUESTS'];
    }
}

if (isset($_POST['close_poll'])) {

    if (is_numeric($_POST['close_poll'])) {
        $close_poll = intval($_POST['close_poll']);
    } else {
        $close_poll = POLL_CLOSE_NO_CHANGE;
    }

} else {

    $close_poll = POLL_CLOSE_NO_CHANGE;
}

$allow_html = true;

if (isset($fid) && !session::check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['apply'])) {

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

if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = intval($_POST['dedupe']);
} else {
    $dedupe = time();
}

if ($valid && isset($_POST['apply'])) {

    if (post_check_ddkey($dedupe)) {

        if ($close_poll == POLL_CLOSE_ONE_DAY) {

            $poll_closes = time() + DAY_IN_SECONDS;

        } else if ($close_poll == POLL_CLOSE_THREE_DAYS) {

            $poll_closes = time() + (DAY_IN_SECONDS * 3);

        } else if ($close_poll == POLL_CLOSE_SEVEN_DAYS) {

            $poll_closes = time() + (DAY_IN_SECONDS * 7);

        } else if ($close_poll == POLL_CLOSE_THIRTY_DAYS) {

            $poll_closes = time() + (DAY_IN_SECONDS * 30);

        } else {

            $poll_closes = false;
        }

        $poll_delete_votes = poll_edit_check_questions($tid, $poll_questions_array) || ($poll_data['POLLTYPE'] != $poll_type) || ($poll_data['VOTETYPE'] != $poll_vote_type);

        poll_edit($tid, $poll_questions_array, $poll_closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $allow_guests, $poll_delete_votes);

        thread_change_title($tid, $thread_title);

        post_add_edit_text($tid, 1);
    }

    header_redirect("discussion.php?webtag=$webtag&msg=$return_msg&edit_success=$tid.1");
}

if (!$folder_dropdown = folder_draw_dropdown($fid, "fid", "", FOLDER_ALLOW_POLL_THREAD, USER_PERM_POST_EDIT, "", "post_folder_dropdown")) {
    html_draw_error(gettext("You cannot create new threads."));
}

html_draw_top(
    array(
        'title' => gettext('Edit Poll'),
        'base_target' => '_blank',
        'js' => array(
            'js/post.js',
            'js/poll.js',
            'js/emoticons.js'
        ),
        'class' => 'window_title max_width'
    )
);

echo "<h1>", gettext("Edit Poll"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array(array_unique($error_msg_array), '960', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_poll\" action=\"edit_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("msg", htmlentities_array($edit_msg)), "\n";
echo "  ", form_input_hidden('return_msg', htmlentities_array($return_msg)), "\n";
echo "  ", form_input_hidden('dedupe', htmlentities_array($dedupe)), "\n";
echo "  <table width=\"960\" class=\"max_width\">\n";
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

    $preview_message['RECIPIENTS'] = array();

    $preview_from_user = user_get($_SESSION['UID']);

    $poll_data['FROM_LOGON'] = $preview_from_user['LOGON'];
    $poll_data['FROM_NICKNAME'] = $preview_from_user['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_from_user['UID'];

    $poll_preview_questions_array = $poll_questions_array;

    if (isset($_POST['preview_form'])) {

        $poll_display = poll_voting_form($poll_preview_questions_array, $poll_data);

    } else {

        $poll_display = "<div align=\"center\">\n";
        $poll_display .= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
        $poll_display .= "    <tr>\n";
        $poll_display .= "      <td align=\"center\">\n";
        $poll_display .= "        <table width=\"560\">\n";

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
            $poll_display .= "            <td align=\"left\" colspan=\"2\">" . poll_table_graph($poll_preview_questions_array, $poll_data) . "</td>\n";
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

    echo "                <tr>\n";
    echo "                  <td align=\"center\"><br />\n";

    message_display(0, $poll_data, 0, 0, 0, false, false, true, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Edit Poll"), "</td>\n";
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
echo "                        <td align=\"left\">", form_input_text("thread_title", htmlentities_array($thread_title), 30, 64, null, "thread_title"), "</td>\n";
echo "                      </tr>\n";
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
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'emots_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'emots_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
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
echo "                          <p>", gettext("<b>Note</b>: Editing certain aspects of a poll will void all the current votes and allow people to vote again."), "</p>\n";
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
echo "                              <td align=\"left\"><h2>", gettext("Poll Results"), "</h2></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">", gettext("How would you like to display the results of your poll?"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, gettext("Horizontal graph"), ($poll_type == POLL_HORIZONTAL_GRAPH)), "</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, gettext("Vertical graph"), ($poll_type == POLL_VERTICAL_GRAPH)), "</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" style=\"white-space: nowrap\">", form_radio('poll_type', POLL_TABLE_GRAPH, gettext("Tabular format"), ($poll_type == POLL_TABLE_GRAPH)), "</td>\n";
echo "                                  </tr>\n";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\"><h2>", gettext("Poll Voting Type"), "</h2></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">", gettext("How should the poll be conducted?"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">", form_radio('poll_vote_type', POLL_VOTE_ANON, gettext("Anonymously"), ($poll_vote_type == POLL_VOTE_ANON)), "</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, gettext("Public ballot"), ($poll_vote_type == POLL_VOTE_PUBLIC)), "</td>\n";
echo "                                  </tr>\n";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">", gettext("Soft Edit Options"), "</td>\n";

if (($page_prefs & POLL_EDIT_SOFT_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide', 'poll_soft_edit_toggle', 'hide', null, 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show', 'poll_soft_edit_toggle', 'show', null, 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_EDIT_SOFT_DISPLAY) > 0) {
    echo "                                <div class=\"poll_soft_edit_toggle\">\n";
} else {
    echo "                                <div class=\"poll_soft_edit_toggle\" style=\"display: none\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"28\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\"><p>", gettext("You may change the options in this section without affecting the current poll votes"), "</p></td>\n";
echo "                                          </tr>\n";
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
echo "                                                  <td align=\"left\">", form_radio('option_type', POLL_OPTIONS_RADIOS, gettext("As a series of radio buttons"), ($option_type == POLL_OPTIONS_RADIOS)), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, gettext("As drop-down list(s)"), ($option_type == POLL_OPTIONS_DROPDOWN)), "</td>\n";
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
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, gettext("Yes"), ($change_vote == POLL_VOTE_CAN_CHANGE)), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, gettext("No"), ($change_vote == POLL_VOTE_CANNOT_CHANGE)), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, gettext("Allow Multiple Votes"), ($change_vote == POLL_VOTE_MULTI)), "</td>\n";
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
    echo "                                                  <td align=\"left\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, gettext("Yes"), ($allow_guests == POLL_GUEST_ALLOWED)), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\">", form_radio('allow_guests', POLL_GUEST_DENIED, gettext("No"), ($allow_guests == POLL_GUEST_DENIED)), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                            </td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">&nbsp;</td>\n";
    echo "                                          </tr>\n";
}

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
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, gettext("Yes"), ($show_results == POLL_SHOW_RESULTS)), "</td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, gettext("No"), ($show_results == POLL_HIDE_RESULTS)), "</td>\n";
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
echo "                                            <td align=\"left\">", form_dropdown_array('close_poll', array(gettext("One day"), gettext("Three days"), gettext("Seven days"), gettext("Thirty days"), gettext("Never"), gettext("No change")), $close_poll), "</td>\n";
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
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                ", form_submit("apply", gettext("Apply")), "&nbsp;", form_submit("preview_poll", gettext("Preview")), "&nbsp;", form_submit("preview_form", gettext("Preview Voting Form"));

echo "&nbsp;<a href=\"discussion.php?webtag=$webtag&msg=$return_msg\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";

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