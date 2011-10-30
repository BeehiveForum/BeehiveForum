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

/* $Id: json.php 4599 2010-11-16 20:00:49Z DecoyDuck $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Start User Session.
$user_sess = session_check();;

// Get the User's UID
$uid = session_get_value('UID');

// Check this is an ajax request and we have an action.
if (!isset($_GET['ajax']) || !isset($_GET['action'])) {

    header_status(500, 'Internal Server Error');
    exit;
}

// Content buffer
$content = '';

// Switch on the action
switch ($_GET['action']) {

    // User autocomplete.
    case 'user_autocomplete':

        // Check we have a search query.
        if (!isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Clean up the query.
        $query = trim(stripslashes_array($_GET['q']));

        // Get the search results.
        if (!$search_results_array = user_search($query)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        foreach ($search_results_array['results_array'] as $search_result) {
            $content.= json_encode(array_intersect_key($search_result, array_flip(array('LOGON', 'NICKNAME')))). "\n";
        }

        break;

    // Signature input toggle
    case 'sig_toggle':

        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_SIGNATURE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POST_SIGNATURE_DISPLAY);
        }

        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Emoticons box toggle.
    case 'emots_toggle':

        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_EMOTICONS_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POST_EMOTICONS_DISPLAY);
        }

        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Poll Advanced Options toggle
    case 'poll_advanced_toggle':

        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADVANCED_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POLL_ADVANCED_DISPLAY);
        }

        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Poll Additional message toggle
    case 'poll_additional_message_toggle':

        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADDITIONAL_MESSAGE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY);
        }

        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Poll Additional message toggle
    case 'poll_soft_edit_toggle':

        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_EDIT_SOFT_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POLL_EDIT_SOFT_DISPLAY);
        }

        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Forum stats toggle
    case 'forum_stats_toggle':

        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Don't rely on toggling the stats, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {

            $user_prefs = array('SHOW_STATS' => 'Y');
            $user_prefs_global = array('SHOW_STATS' => false);

        } else {

            $user_prefs = array('SHOW_STATS' => 'N');
            $user_prefs_global = array('SHOW_STATS' => false);
        }

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // Left frame resize
    case 'frame_resize':

        // Get the size from the request
        if (!isset($_GET['size']) || !is_numeric($_GET['size'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Set the LEFT_FRAME_WIDTH preference
        $user_prefs = array('LEFT_FRAME_WIDTH' => abs($_GET['size']));

        // Per-forum preference
        $user_prefs_global = array('LEFT_FRAME_WIDTH' => false);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        break;

    // PM Notifications
    case 'pm_check_messages':

        // Get the PM notification data.
        if (($pm_notification_data = pm_check_messages()) !== false) {

            // Send JSON encoded data.
            $content.= json_encode($pm_notification_data);
        }

        break;

    // Forum stats
    case 'get_forum_stats':

        // Get the forum stats HTML
        if (!($forum_stats_html = stats_get_html())) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Send the vanilla HTML
        $content.= $forum_stats_html;

        break;

    case 'reload_captcha':

        // Return empty array by default
        $text_captcha_data = array();

        // Initialise the text captcha
        $text_captcha = new captcha(6, 15, 25, 9, 30);

        // Generate keys and image.
        if (($text_captcha->generate_keys() && $text_captcha->make_image())) {

            // Construct array to send as JSON response.
            $text_captcha_data = array('image' => $text_captcha->get_image_filename(),
                                       'chars' => $text_captcha->get_num_chars(),
                                       'key'   => $text_captcha->get_public_key());

            // Send the JSON encoded array.
            $content.= json_encode($text_captcha_data);
        }

        break;

    case 'font_size_larger':
    case 'font_size_smaller':

        // Get the current message TID.PID
        if (!isset($_GET['msg']) || !validate_msg($_GET['msg'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Spli the msg into separate TID and PID variables.
        list($tid, $pid) = explode('.', $_GET['msg']);

        // Load the user prefs
        $user_prefs = user_get_prefs($uid);

        // Calculate the new font size.
        switch ($_GET['action']) {

            // 'Smaller' link clicked
            case 'font_size_smaller':

                $user_prefs = array('FONT_SIZE' => $user_prefs['FONT_SIZE'] - 1);
                break;

            // 'Larger' link clicked
            case 'font_size_larger':

                $user_prefs = array('FONT_SIZE' => $user_prefs['FONT_SIZE'] + 1);
                break;
        }

        // Check the font size is not lower than 5
        if ($user_prefs['FONT_SIZE'] < 5) $user_prefs['FONT_SIZE'] = 5;

        // Check the font size is not greater than 15
        if ($user_prefs['FONT_SIZE'] > 15) $user_prefs['FONT_SIZE'] = 15;

        // Apply the font size to this forum only.
        $user_prefs_global = array('FONT_SIZE' => false);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        $content.= json_encode(array('success'   => true,
                                     'font_size' => $user_prefs['FONT_SIZE'],
                                     'html'      => messages_fontsize_form($tid, $pid, true, $user_prefs['FONT_SIZE'])));

        break;

    case 'post_options':

        // Get the msg from the request
        if (!isset($_GET['msg']) || !validate_msg($_GET['msg'])) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Get message TID and PID.
        list($tid, $pid) = explode('.', $_GET['msg']);

        // Check we have a valid thread.
        if (!$thread_data = thread_get($tid, session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

            header_status(500, 'Internal Server Error');
            exit;
        }

        // Get the post options HTML
        if (($post_options_html = message_get_post_options_html($tid, $pid, $thread_data['FID']))) {

            // Send the vanilla HTML
            $content.= $post_options_html;
        }

        break;

    case 'poll_add_question':

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

    // Unknown action
    default:

        header_status(500, 'Internal Server Error');
        exit;
}

// Disable caching.
cache_disable();

// Output the content.
echo $content;

?>