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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

$error_msg_array = array();

if (forum_get_setting('allow_polls', 'N')) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['pollshavebeendisabled']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $edit_msg);

    if (!($fid = thread_get_folder($tid, $pid))) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $edit_msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!($fid = thread_get_folder($tid, $pid))) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

} else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['nomessagespecifiedforedit']);
    html_draw_bottom();
    exit;
}

if (!thread_is_poll($tid) || ($pid != 1)) {

    $uri = "edit.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    }elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
        $uri.= "&msg=". $_POST['msg'];
    }

    header_redirect($uri);
}

if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {

    html_message_type_error();
    exit;
}

if (!($fid = thread_get_folder($tid))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $fid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannoteditpostsinthisfolder']);
    html_draw_bottom();
    exit;
}

if (!($thread_data = thread_get($tid))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

$poll_data = poll_get($tid);

$poll_questions_array = poll_get_votes($tid);

$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

$page_prefs = session_get_post_page_prefs();

$uid = session_get_value('UID');

$valid = true;

if (isset($_POST['post_emots'])) {

    if ($_POST['post_emots'] == "disabled") {
        $emots_enabled = false;
    } else {
        $emots_enabled = true;
    }

} else {

    if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
        $emots_enabled = false;
    } else {
        $emots_enabled = true;
    }
}

if (isset($_POST['post_links'])) {

    if ($_POST['post_links'] == "enabled") {
        $links_enabled = true;
    } else {
        $links_enabled = false;
    }

} else {

    if (($page_prefs & POST_AUTO_LINKS) > 0) {
        $links_enabled = true;
    } else {
        $links_enabled = false;
    }
}

if (isset($_POST['options_html'])) {

    if ($_POST['options_html'] == 'Y') {
        $options_html = 'Y';
    } else {
        $options_html = 'N';
    }

} else {

    $options_html = 'N';

    foreach ($poll_questions_array as $question) {

        foreach ($question['OPTIONS_ARRAY'] as $option) {

            if (strip_tags($option['OPTION_NAME']) != $option['OPTION_NAME']) {
                $options_html = 'Y';
            }
        }
    }
}

if (isset($_POST['thread_title'])) {

    if (strlen(trim(stripslashes_array($_POST['thread_title']))) > 0) {
        $thread_title = trim(stripslashes_array($_POST['thread_title']));
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
                    'QUESTION_ID'   => sizeof($poll_questions_array) + 1,
                    'QUESTION'      => (isset($question['question']) ? $question['question'] : ''),
                    'ALLOW_MULTI'   => (isset($question['allow_multi']) && $question['allow_multi'] == 'Y') ? 'Y' : 'N',
                    'OPTIONS_ARRAY' => array(),
                );

                if (isset($question['options']) && is_array($question['options'])) {

                    foreach ($question['options'] as $option) {

                        if (!is_scalar($option)) continue;

                        $poll_option = array(
                            'OPTION_ID'   => sizeof($poll_question['OPTIONS_ARRAY']) + 1,
                            'OPTION_NAME' => $option,
                        );

                        $poll_question['OPTIONS_ARRAY'][$poll_option['OPTION_ID']] = $poll_option;
                    }
                }

                $poll_questions_array[$poll_question['QUESTION_ID']] = $poll_question;
            }
        }

    } else {

        $poll_questions_array = array(
            1 => array(
                'QUESTION_ID'   => 1,
                'QUESTION'      => '',
                'ALLOW_MULTI'   => false,
                'OPTIONS_ARRAY' => array(
                    1 => array(
                        'OPTION_ID'   => 1,
                        'OPTION_NAME' => '',
                    ),
                ),
            )
        );
    }
}

if (sizeof($poll_questions_array) == 0) {

    $poll_questions_array = array(
        1 => array(
            'QUESTION_ID'   => 1,
            'QUESTION'      => '',
            'ALLOW_MULTI'   => false,
            'OPTIONS_ARRAY' => array(
                1 => array(
                    'OPTION_ID'   => 1,
                    'OPTION_NAME' => '',
                ),
            ),
        )
    );
}

if (isset($_POST['add_option']) && is_array($_POST['add_option'])) {

    list($question_id) = array_keys($_POST['add_option']);

    if (isset($poll_questions_array[$question_id])) {

        $poll_questions_array[$question_id]['OPTIONS_ARRAY'][] = array(
            'OPTION_ID'   => sizeof($poll_questions_array[$question_id]['OPTIONS_ARRAY']) + 1,
            'OPTION_NAME' => '',
        );
    }
}

if (isset($_POST['add_question'])) {

    $poll_questions_array[] = array(
        'QUESTION_ID'   => sizeof($poll_questions_array) + 1,
        'QUESTION'      => '',
        'ALLOW_MULTI'   => false,
        'OPTIONS_ARRAY' => array(
            1 => array(
                'OPTION_ID'   => 1,
                'OPTION_NAME' => '',
            ),
        ),
    );
}

if (isset($_POST['delete_option']) && is_array($_POST['delete_option'])) {

    foreach ($_POST['delete_option'] as $question_id => $option_id_array) {

        if (!is_array($option_id_array)) continue;

        if (sizeof($poll_questions_array[$question_id]['OPTIONS_ARRAY']) > 1) {

            foreach(array_keys($option_id_array) as $option_id) {
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
        $poll_type = $_POST['poll_type'];
    } else {
        $poll_type = POLL_HORIZONTAL_GRAPH;
    }

} else {

    $poll_type = $poll_data['POLLTYPE'];
}

if (isset($_POST['show_results'])) {

    if (is_numeric($_POST['show_results'])) {
        $show_results = $_POST['show_results'];
    } else {
        $show_results = POLL_SHOW_RESULTS;
    }

} else {

    $show_results = $poll_data['SHOWRESULTS'];
}

if (isset($_POST['poll_vote_type'])) {

    if (is_numeric($_POST['poll_vote_type'])) {
        $poll_vote_type = $_POST['poll_vote_type'];
    } else {
        $poll_vote_type = POLL_VOTE_ANON;
    }

} else {

    $poll_vote_type = $poll_data['VOTETYPE'];
}

if (isset($_POST['option_type'])) {

    if (is_numeric($_POST['option_type'])) {
        $option_type = $_POST['option_type'];
    } else {
        $option_type = POLL_OPTIONS_RADIOS;
    }

} else {

    $option_type = $poll_data['OPTIONTYPE'];
}

if (isset($_POST['change_vote'])) {

    if (is_numeric($_POST['change_vote'])) {
        $change_vote = $_POST['change_vote'];
    } else {
        $change_vote = POLL_VOTE_CAN_CHANGE;
    }

} else {

    $change_vote = $poll_data['CHANGEVOTE'];
}

if (isset($_POST['allow_guests'])) {

    if (is_numeric($_POST['allow_guests'])) {
        $allow_guests = $_POST['allow_guests'];
    } else {
        $allow_guests = POLL_GUEST_DENIED;
    }

} else {

    if (!forum_get_setting('poll_allow_guests', false)) {

        $allow_guests = POLL_GUEST_DENIED;

    } else {

        $allow_guests = $poll_data['ALLOWGUESTS'];
    }
}

if (isset($_POST['close_poll'])) {

    if (is_numeric($_POST['close_poll'])) {
        $close_poll = $_POST['close_poll'];
    } else {
        $close_poll = POLL_CLOSE_NO_CHANGE;
    }

} else {

    $close_poll = POLL_CLOSE_NO_CHANGE;
}

$allow_html = true;

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else if (!$aid = attachments_get_id($tid, $pid)) {
    $aid = md5(uniqid(mt_rand()));
}

if (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['apply'])) {

    $valid = true;

    if (!isset($thread_title) || strlen(trim($thread_title)) == 0) {

        $error_msg_array[] = $lang['mustenterthreadtitle'];
        $valid = false;
    }

    if (!isset($fid) || !folder_is_valid($fid)) {

        $error_msg_array[] = $lang['unknownfolder'];
        $valid = false;
    }

    if (!session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = $lang['cannotcreatethreadinfolder'];
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
    }

    if (!folder_thread_type_allowed($fid, FOLDER_ALLOW_POLL_THREAD)) {

        $error_msg_array[] = $lang['cannotpostthisthreadtypeinfolder'];
        $valid = false;
    }

    $poll_option_count = 0;

    if (isset($poll_questions_array) && sizeof($poll_questions_array) > 0) {

        foreach ($poll_questions_array as $question_id => $question) {

            if (!isset($question['ALLOW_MULTI']) || ($question['ALLOW_MULTI'] != 'Y')) {
                $poll_questions_array[$question_id]['ALLOW_MULTI'] = 'N';
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

                        $error_msg_array[] = $lang['youmustprovideaquestionforalloptions'];
                        $valid = false;
                    }
                }

            } else if (!isset($question['OPTIONS_ARRAY']) || !is_array($question['OPTIONS_ARRAY'])) {

                $error_msg_array[] = $lang['youmustprovideratleast1optionforeachquestion'];
                $valid = false;

            } else {

                foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                    if (!isset($option['OPTION_NAME']) || strlen(trim($option['OPTION_NAME'])) == 0) {
                        unset($question['OPTIONS_ARRAY'][$option_id]);
                    }
                }

                $poll_option_count+= sizeof($question['OPTIONS_ARRAY']);

                if (sizeof($question['OPTIONS_ARRAY']) < 1) {

                    $error_msg_array[] = $lang['youmustprovideratleast1optionforeachquestion'];
                    $valid = false;

                } else {

                    foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

                        if (($allow_html == true) && isset($options_html) && ($options_html == 'Y')) {

                            $poll_option_check_html = new MessageText(POST_HTML_ENABLED, $option['OPTION_NAME']);

                            $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = $poll_option_check_html->getContent();

                            if (strlen(trim($poll_option_check_html->getContent())) == 0) {

                                $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = $poll_option_check_html->getOriginalContent();

                                $error_msg_array[] = $lang['pollquestioncontainsinvalidhtml'];

                                $valid = false;
                            }
                        }

                        if (attachments_embed_check($option['OPTION_NAME']) && ($options_html == 'Y')) {

                            $error_msg_array[] = $lang['notallowedembedattachmentpost'];
                            $valid = false;
                        }
                    }
                }
            }
        }
    }

    if (sizeof($poll_questions_array) < 1) {

        $error_msg_array[] = $lang['youmustprovideratleast1question'];
        $valid = false;

        $poll_questions_array = array(
            array(
                'QUESTION_ID' => 0,
                'QUESTION' => '',
                'ALLOW_MULTI' => false,
                'OPTIONS_ARRAY' => array(
                    array(
                        'OPTION_ID' => 0,
                        'OPTION_NAME' => '',
                    ),
                ),
            )
        );
    }

    if ($valid && ($poll_option_count > 20)) {

        $error_msg_array[] = $lang['youcanhaveamaximumof20optionsperpoll'];
        $valid = false;
    }

    if ($valid && (!isset($poll_type) || !is_numeric($poll_type))) {

        $error_msg_array[] = $lang['mustprovidepolltype'];
        $valid = false;
    }

    if ($valid && (!isset($show_results) || !is_numeric($show_results))) {

        $error_msg_array[] = $lang['mustprovidepollresultsdisplaytype'];
        $valid = false;
    }

    if ($valid && (!isset($poll_vote_type) || !is_numeric($poll_vote_type))) {

        $error_msg_array[] = $lang['mustprovidepollvotetype'];
        $valid = false;
    }

    if ($valid && (!isset($option_type) || !is_numeric($option_type))) {

        $error_msg_array[] = $lang['mustprovidepolloptiontype'];
        $valid = false;
    }

    if ($valid && (!isset($change_vote) || !is_numeric($change_vote))) {

        $error_msg_array[] = $lang['mustprovidepollvotetype'];
        $valid = false;
    }

    if ($valid && (!isset($allow_guests) || !is_numeric($allow_guests))) {

        $error_msg_array[] = $lang['mustprovidepollguestvotetype'];
        $valid = false;
    }

    if (!isset($close_poll) || !is_numeric($close_poll)) {
        $close_poll = false;
    }

    if ($valid && ($poll_type == POLL_TABLE_GRAPH) && sizeof($poll_questions_array) <> 2) {

        $error_msg_array[] = $lang['tablepollmusthave2groups'];
        $valid = false;
    }

    if ($valid && ($poll_type == POLL_TABLE_GRAPH) && ($change_vote == POLL_VOTE_MULTI)) {

        $error_msg_array[] = $lang['nomultivotetabulars'];
        $valid = false;
    }

    if ($valid && ($poll_vote_type == POLL_VOTE_PUBLIC) && ($change_vote == POLL_VOTE_MULTI)) {

        $error_msg_array[] = $lang['nomultivotepublic'];
        $valid = false;
    }

    if ($valid && ($poll_vote_type == POLL_VOTE_PUBLIC) && ($poll_type != POLL_HORIZONTAL_GRAPH)) {

        $error_msg_array[] = $lang['publicballothorizontalgraphonly'];
        $valid = false;
    }

    if (isset($message_text) && strlen(trim(stripslashes_array($message_text))) > 0) {

        if (attachments_embed_check($message_text) && ($message_html == 'Y')) {

            $error_msg_array[] = $lang['notallowedembedattachmentpost'];
            $valid = false;
        }
    }

    if (isset($sig_text)) {

        if ($sig_html && attachments_embed_check($sig_text)) {

            $error_msg_array[] = $lang['notallowedembedattachmentsignature'];
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

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

if (isset($fid) && !session_check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = $_POST['dedupe'];
}else{
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

        if ($allow_html == false || !isset($t_post_html) || $t_post_html == 'N') {

            foreach ($poll_questions_array as $question_id => $question) {

                foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {
                    $poll_questions_array[$question_id]['OPTIONS_ARRAY'][$option_id]['OPTION_NAME'] = htmlentities_array($option['OPTION_NAME']);
                }
            }
        }

        $poll_delete_votes = poll_edit_check_questions($tid, $poll_questions_array) || ($poll_data['POLLTYPE'] != $poll_type) || ($poll_data['VOTETYPE'] != $poll_vote_type);

        poll_edit($tid, $poll_questions_array, $poll_closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $allow_guests, $poll_delete_votes);

        thread_change_title($tid, $thread_title);

        post_add_edit_text($tid, 1);

        post_save_attachment_id($tid, $pid, $aid);
    }

    header_redirect("discussion.php?webtag=$webtag&msg=$tid.1&edit_success=$tid.1");
}

if (!$folder_dropdown = folder_draw_dropdown($fid, "fid", "", FOLDER_ALLOW_POLL_THREAD, USER_PERM_POST_EDIT, "", "post_folder_dropdown")) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannotcreatenewthreads']);
    html_draw_bottom();
    exit;
}

html_draw_top("title={$lang['editpoll']}", "basetarget=_blank", "onUnload=clearFocus()", "resize_width=785", "post.js", "poll.js", "attachments.js", "dictionary.js", "htmltools.js", "emoticons.js", 'class=window_title');

echo "<h1>{$lang['editpoll']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array(array_unique($error_msg_array), '785', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_poll\" action=\"edit_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("msg", htmlentities_array($edit_msg)), "\n";
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
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
    echo "                </tr>";

    $poll_data['POLLTYPE'] = $poll_type;
    $poll_data['VOTETYPE'] = $poll_vote_type;
    $poll_data['OPTIONTYPE'] = $option_type;

    $poll_data['TLOGON'] = $lang['allcaps'];
    $poll_data['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get($uid);

    $poll_data['FLOGON']   = $preview_tuser['LOGON'];
    $poll_data['FNICK']    = $preview_tuser['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_tuser['UID'];

    $poll_preview_questions_array = $poll_questions_array;

    if ($allow_html == false || !isset($options_html) || $options_html == 'N') {

        foreach ($poll_preview_questions_array as $question_id => $question) {

            foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {

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

        if (($random_users_array = poll_get_random_users(mt_rand(10, 20)))) {

            while (($random_user = array_pop($random_users_array))) {

                foreach ($poll_preview_questions_array as $question_id => $question) {

                    $option = $question['OPTIONS_ARRAY'][array_rand($question['OPTIONS_ARRAY'])];

                    $poll_preview_questions_array[$question_id]['OPTIONS_ARRAY'][$option['OPTION_ID']]['VOTES_ARRAY'][] = $random_user;
                }
            }
        }

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\" colspan=\"2\">". poll_table_graph($poll_preview_questions_array, $poll_data). "</td>\n";
            $poll_display.= "           </tr>\n";

        } else {

            foreach ($poll_preview_questions_array as $question_id => $poll_question) {

                $poll_display.= "          <tr>\n";
                $poll_display.= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['QUESTION'])). "</h2></td>\n";
                $poll_display.= "          </tr>\n";
                $poll_display.= "          <tr>\n";
                $poll_display.= "            <td align=\"left\">\n";
                $poll_display.= "              <table width=\"100%\">\n";

                if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_vertical_graph($poll_question['OPTIONS_ARRAY'], $poll_data). "</td>\n";
                    $poll_display.= "                </tr>\n";

                } else if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && (isset($public_ballot_votes_array[$question_id]))) {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $public_ballot_votes_array[$question_id]). "</td>\n";
                    $poll_display.= "                 </tr>\n";

                } else {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" colspan=\"2\">". poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data). "</td>\n";
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

    $poll_display.= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

    $poll_data['CONTENT'] = $poll_display;

    $poll_data['AID'] = $aid;

    echo "                <tr>\n";
    echo "                  <td align=\"center\"><br />\n";

    message_display(0, $poll_data, 0, 0, 0, false, false, false, true, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

$tools = new TextAreaHTML("f_poll");

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['editpoll']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"220\">\n";
echo "                    <table class=\"posthead\" width=\"220\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['folder']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">$folder_dropdown</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['threadtitle']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("thread_title", htmlentities_array($thread_title), 30, 64, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['messageoptions']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";

if (($user_emoticon_pack = session_get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                    <br />\n";
    echo "                    <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

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
echo "                          <h2>{$lang['poll']}</h2>\n";
echo "                          <p>{$lang['editpollwarning']}</p>\n";
echo "                          <p>{$lang['enterpollquestionexp']}</p>\n";
echo "                          <div class=\"poll_questions_container\">\n";

foreach ($poll_questions_array as $question_id => $question) {

    echo "                            <fieldset class=\"poll_question\">\n";
    echo "                              <div>\n";
    echo "                                <h2>{$lang['pollquestion']}</h2>\n";
    echo "                                <div class=\"poll_question_input\">\n";
    echo "                                  ", form_input_text("poll_questions[{$question_id}][question]", htmlentities_array($question['QUESTION']), 40, 255), "&nbsp;", form_button_html("delete_question[{$question_id}]", 'submit', 'button_image delete_question', sprintf("<img src=\"%s\" alt=\"\" />", html_style_image('delete.png')), "title=\"{$lang['deletequestion']}\""), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_question_checkbox\">\n";
    echo "                                  ", form_checkbox("poll_questions[{$question_id}][allow_multi]", "Y", $lang['allowmultipleoptions'], (isset($question['ALLOW_MULTI']) && $question['ALLOW_MULTI'] == 'Y')), "\n";
    echo "                                </div>\n";
    echo "                                <div class=\"poll_options_list\">\n";
    echo "                                  <ol>\n";

    if (isset($question['OPTIONS_ARRAY']) && is_array($question['OPTIONS_ARRAY'])) {

        foreach ($question['OPTIONS_ARRAY'] as $option_id => $option) {
            echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][{$option_id}]", htmlentities_array($option['OPTION_NAME']), 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][{$option_id}]", 'submit', 'button_image delete_option', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), "title=\"{$lang['deleteoption']}\""), "</li>\n";
        }

    } else {

        echo "                                    <li>", form_input_text("poll_questions[{$question_id}][options][0]", '', 45, 255), "&nbsp;", form_button_html("delete_option[{$question_id}][0]", 'submit', 'button_image delete_option', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), "title=\"{$lang['deleteoption']}\""), "</li>\n";

        if (isset($_POST['add_option'][$question_id])) {
            echo poll_get_option_html($question_id, 1);
        }
    }

    echo "                                  </ol>\n";
    echo "                                </div>\n";
    echo "                              </div>\n";
    echo "                            ", form_button_html("add_option[{$question_id}]", 'submit', 'button_image add_option', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), $lang['addnewoption'])), "\n";
    echo "                            </fieldset>\n";
}

echo "                          </div>\n";
echo "                          <table width=\"530\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_button_html('add_question', 'submit', 'button_image add_question', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), $lang['addnewquestion'])), "</td>\n";

if ($allow_html == true) {
    echo "                              <td align=\"right\">", form_checkbox('options_html', 'Y', $lang['optionscontainHTML'], ($options_html == 'Y')), "</td>\n";
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
echo "                              <td align=\"left\"><h2>{$lang['pollresults']}</h2></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">{$lang['pollresultsexp']}</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, $lang['horizgraph'], ($poll_type == POLL_HORIZONTAL_GRAPH)), "</td>\n";
echo "                                    <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, $lang['vertgraph'], ($poll_type == POLL_VERTICAL_GRAPH)), "</td>\n";
echo "                                    <td align=\"left\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_TABLE_GRAPH, $lang['tablegraph'], ($poll_type == POLL_TABLE_GRAPH)), "</td>\n";
echo "                                  </tr>\n";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\"><h2>{$lang['pollvotetype']}</h2></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">{$lang['pollvotesexp']}</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_ANON, $lang['pollvoteanon'], ($poll_vote_type == POLL_VOTE_ANON)), "</td>\n";
echo "                                    <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, $lang['pollvotepub'], ($poll_vote_type == POLL_VOTE_PUBLIC)), "</td>\n";
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
echo "                                    <td align=\"left\" class=\"subhead\">{$lang['softedit']}</td>\n";

if (($page_prefs & POLL_EDIT_SOFT_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'poll_soft_edit_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'poll_soft_edit_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
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
echo "                                        <table border=\"0\" class=\"posthead\" width=\"510\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"27\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\"><h2>{$lang['optionsdisplay']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['optionsdisplayexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_RADIOS, $lang['radios'], ($option_type == POLL_OPTIONS_RADIOS)), "</td>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, $lang['dropdown'], ($option_type == POLL_OPTIONS_DROPDOWN)), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['votechanging']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['votechangingexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, $lang['yes'], ($change_vote == POLL_VOTE_CAN_CHANGE)), "</td>\n";
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, $lang['no'], ($change_vote == POLL_VOTE_CANNOT_CHANGE)), "</td>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, $lang['allowmultiplevotes'], ($change_vote == POLL_VOTE_MULTI)), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";

if (forum_get_setting('poll_allow_guests', false)) {

    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\"><h2>{$lang['guestvoting']}</h2></td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">{$lang['guestvotingexp']}</td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">\n";
    echo "                                              <table border=\"0\" width=\"100%\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, $lang['yes'], ($allow_guests == POLL_GUEST_ALLOWED)), "</td>\n";
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_DENIED, $lang['no'], ($allow_guests == POLL_GUEST_DENIED)), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                            </td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">&nbsp;</td>\n";
    echo "                                          </tr>\n";
}

echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['expiration']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['showresultswhileopen']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, $lang['yes'], ($show_results == POLL_SHOW_RESULTS)), "</td>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, $lang['no'], ($show_results == POLL_HIDE_RESULTS)), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['whenlikepollclose']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", form_dropdown_array('close_poll', array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), $close_poll), "</td>\n";
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
echo "                                ", form_submit("apply", $lang['apply']), "&nbsp;", form_submit("preview_poll", $lang['preview']), "&nbsp;", form_submit("preview_form", $lang['previewvotingform']);

echo "&nbsp;<a href=\"discussion.php?webtag=$webtag&msg=$tid.1\" class=\"button\" target=\"_self\"><span>{$lang['cancel']}</span></a>";

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "&nbsp;<a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>{$lang['attachments']}</span></a>\n";
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