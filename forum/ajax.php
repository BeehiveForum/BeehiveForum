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
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'stats.inc.php';
require_once BH_INCLUDE_PATH . 'text_captcha.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

if (!isset($_GET['ajax']) || !isset($_GET['action'])) {

    header_status(500, 'Internal Server Error');
    exit;
}

$content = '';

switch ($_GET['action']) {

    case 'user_autocomplete':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['term']) || strlen(trim($_GET['term'])) == 0) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        $term = trim($_GET['term']);

        if (!($search_results_array = user_search($term))) {

            $content = '';
            break;
        }

        header('Content-type: application/json; charset=UTF-8');

        $content = json_encode($search_results_array);

        break;

    case 'sig_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_SIGNATURE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POST_SIGNATURE_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'attachment_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_ATTACHMENT_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POST_ATTACHMENT_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'emots_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_EMOTICONS_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POST_EMOTICONS_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'poll_advanced_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADVANCED_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POLL_ADVANCED_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'poll_additional_message_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADDITIONAL_MESSAGE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POLL_ADDITIONAL_MESSAGE_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'poll_soft_edit_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        $page_prefs = session::get_post_page_prefs();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_EDIT_SOFT_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs & ~POLL_EDIT_SOFT_DISPLAY;
        }

        $user_prefs = array(
            'POST_PAGE' => $page_prefs
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'forum_stats_toggle':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if ($_GET['display'] === 'true') {

            $user_prefs = array(
                'SHOW_STATS' => 'Y'
            );

        } else {

            $user_prefs = array(
                'SHOW_STATS' => 'N'
            );
        }

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'frame_resize':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['size']) || !is_numeric($_GET['size'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        $left_frame_width = max(100, abs($_GET['size']));

        $user_prefs = array(
            'LEFT_FRAME_WIDTH' => $left_frame_width,
        );

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'pm_check_messages':

        if (!session::logged_in()) break;

        cache_disable();

        if (($pm_notification_data = pm_check_messages()) === false) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        header('Content-type: application/json; charset=UTF-8');

        $content = json_encode($pm_notification_data);

        break;

    case 'get_forum_stats':

        cache_check_request_throttle(300);

        if (!($content = stats_get_html())) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'reload_captcha':

        $text_captcha = new captcha(6, 15, 25, 9, 30);

        if (!$text_captcha->generate_keys()) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($text_captcha_image = $text_captcha->make_image())) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        cache_disable();

        header('Content-type: application/json; charset=UTF-8');

        $content = json_encode(array(
            'image' => sprintf(
                "data:image/jpeg;base64,%s",
                base64_encode(file_get_contents($text_captcha_image))
            ),
            'chars' => $text_captcha->get_num_chars(),
            'key' => $text_captcha->get_public_key()
        ));

        break;

    case 'font_size_larger':
    case 'font_size_smaller':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['msg']) || !validate_msg($_GET['msg'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        list($tid, $pid) = explode('.', $_GET['msg']);

        $user_prefs = user_get_prefs($_SESSION['UID']);

        switch ($_GET['action']) {

            case 'font_size_smaller':

                $user_prefs = array(
                    'FONT_SIZE' => $user_prefs['FONT_SIZE'] - 1
                );

                break;

            case 'font_size_larger':

                $user_prefs = array(
                    'FONT_SIZE' => $user_prefs['FONT_SIZE'] + 1
                );

                break;
        }

        if ($user_prefs['FONT_SIZE'] < 5) $user_prefs['FONT_SIZE'] = 5;

        if ($user_prefs['FONT_SIZE'] > 15) $user_prefs['FONT_SIZE'] = 15;

        if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        header('Content-type: application/json; charset=UTF-8');

        $content = json_encode(array(
            'success' => true,
            'font_size' => $user_prefs['FONT_SIZE'],
            'html' => messages_fontsize_form($tid, $pid, true, $user_prefs['FONT_SIZE'])
        ));

        break;

    case 'post_options':

        cache_disable();

        if (!isset($_GET['msg']) || !validate_msg($_GET['msg'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($message = messages_get($tid, $_GET['pid'], 1))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($content = message_get_post_options_html($tid, $pid, $message))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'post_vote':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['msg']) || !validate_msg($_GET['msg'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (!isset($_GET['post_rating']) || !in_array($_GET['post_rating'], array(-1, 1))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        $post_rating = $_GET['post_rating'];

        if (!post_set_user_rating($tid, $pid, $_SESSION['UID'], $post_rating)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($message = messages_get($tid, $pid, 1))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (isset($_GET['mobile']) && ($_GET['mobile'] == 'Y')) {

            if (!($content = light_message_get_vote_form_html($message))) {

                header_status(500, 'Internal Server Error');
                exit;
            }

        } else {

            if (!($content = message_get_vote_form_html($message))) {

                header_status(500, 'Internal Server Error');
                exit;
            }
        }

        break;

    case 'poll_add_question':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['question_number']) || !is_numeric($_GET['question_number'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($content = poll_get_question_html($_GET['question_number']))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'poll_add_option':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['question_number']) || !is_numeric($_GET['question_number'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!isset($_GET['option_number']) || !is_numeric($_GET['option_number'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        if (!($content = poll_get_option_html($_GET['question_number'], $_GET['option_number']))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    case 'pref_attachment':

        if (!session::logged_in()) break;

        cache_disable();

        if (!isset($_GET['type']) || !in_array($_GET['type'], array('pic_aid', 'avatar_aid'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        $attachments_array = attachments_get_all($_SESSION['UID']);

        header('Content-type: application/json; charset=UTF-8');

        switch ($_GET['type']) {

            case 'pic_aid':

                $content = json_encode(user_prefs_filter_attachments($attachments_array, 95, 95));
                break;

            case 'avatar_aid':

                $content = json_encode(user_prefs_filter_attachments($attachments_array, 16, 16));
                break;
        }

        break;

    default:

        header_status(500, 'Internal Server Error');
        exit;
}

echo $content;