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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
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
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

if (user_is_guest()) {

    light_html_draw_top();
    light_html_guest_error();
    light_html_draw_bottom();
    exit;
}

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
    exit;
}

if (isset($_POST['cancel'])) {

    if (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {
        $uri = "lmessages.php?webtag=$webtag&msg={$_POST['t_tid']}.{$_POST['t_rpid']}";
    }else if (isset($_GET['replyto'])) {
        $uri = "lmessages.php?webtag=$webtag&msg={$_GET['replyto']}";
    } else {
        $uri = "lthread_list.php?webtag=$webtag";
    }

    header_redirect($uri);
}

// Get the user's post page preferences.
$page_prefs = session_get_post_page_prefs();

// Get the user's UID
$uid = session_get_value('UID');

// Assume everything is A-OK!
$valid = true;

$new_thread = false;

if (isset($_POST['t_newthread'])) {

    $new_thread = true;

    if (isset($_POST['t_threadtitle']) && strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {

        $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));

    }else {

        $error_msg_array[] = gettext("You must enter a title for the thread!");
        $valid = false;
    }

    if (isset($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        }else {

            $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
            $valid = false;
        }

    }else {

        $error_msg_array[] = gettext("Please select a folder");
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = stripslashes_array($_POST['t_content']);

    }else {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

}else {

    if (isset($_POST['t_tid'])) {

        if (isset($_POST['t_content']) && strlen($_POST['t_content']) > 0) {

            $t_content = stripslashes_array($_POST['t_content']);

        }else {

            $error_msg_array[] = gettext("You must enter some content for the post!");
            $valid = false;
        }

    }else {

        $valid = false;
    }
}

if (($high_interest = session_get_value('MARK_AS_OF_INT')) === false) {
    $high_interest = "N";
}

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    }else if ($t_post_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && strlen(trim(stripslashes_array($_POST['t_sig']))) > 0) {
        $t_sig = stripslashes_array($_POST['t_sig']);
    }else {
        $t_sig = "";
    }

}else {

    if (!user_get_sig($uid, $t_sig, $t_sig_html)) {

        $t_sig = '';
        $t_sig_html = 'Y';
    }

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
    $emots_enabled = false;
}else {
    $emots_enabled = true;
}

if (($page_prefs & POST_AUTO_LINKS) > 0) {
    $links_enabled = true;
}else {
    $links_enabled = false;
}

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $t_sig, $emots_enabled, $links_enabled, false);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    list($reply_to_tid, $reply_to_pid) = explode(".", $_GET['replyto']);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("The requested thread could not be found or access was denied."));
        html_draw_bottom();
        exit;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_error_msg(gettext("You cannot reply to posts in this folder"));
        html_draw_bottom();
        exit;
    }

    $new_thread = false;

}elseif (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {

    $reply_to_tid = (is_numeric($_POST['t_tid']) ? $_POST['t_tid'] : 0);
    $reply_to_pid = (is_numeric($_POST['t_rpid']) ? $_POST['t_rpid'] : 0);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!session_check_perm(USER_PERM_POST_CREATE | USER_PERM_POST_READ, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("You cannot reply to posts in this folder"));
        light_html_draw_bottom();
        exit;
    }

    $new_thread = false;

}else {

    $new_thread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    }elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
        $t_fid = $_POST['t_fid'];
    }

    if (isset($t_fid) && !folder_is_valid($t_fid)) {

        $error_msg_array[] = gettext("Invalid Folder ID. Check that a folder with this ID exists!");
        $valid = false;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (isset($t_fid) && !session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("You cannot create new threads in this folder"));
        light_html_draw_bottom();
        exit;
    }
}

if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {

    $t_to_uid = $_POST['t_to_uid'];

}else {

    $t_to_uid = 0;

    if (isset($reply_to_tid) && isset($reply_to_pid)) {

        if (!$t_to_uid = message_get_user($reply_to_tid, $reply_to_pid)) {

            $t_to_uid = 0;
        }
    }
}

$allow_html = true;
$allow_sig = true;

if (isset($t_fid) && !session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session_check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    if ($post->getHTML() > 0) {

        $post->setHTML(false);
        $t_content = $post->getContent();
    }

    $sig->setHTML(false, true);
    $t_sig = $sig->getContent();
}

if (!$new_thread) {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    if (!$thread_data = thread_get($reply_to_tid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {

        $error_msg_array[] = gettext("Message not found. Check that it hasn't been deleted.");
        $valid = false;
    }
}

// De-dupe key
if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
}else{
    $t_dedupe = time();
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($t_dedupe)) {

            if ($new_thread) {

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle);
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }

            if ($t_tid > 0) {

                if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
                    $t_content.= "<div class=\"sig\">$t_sig</div>";
                }

                $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $t_to_uid, $t_content);

                if ($new_pid > -1) {

                    $user_rel = user_get_relationship($t_to_uid, $uid);

                    if ($high_interest == "Y") thread_set_high_interest($t_tid);

                    if (!session_check_perm(USER_PERM_WORMED, 0) && !($user_rel & USER_IGNORED_COMPLETELY)) {

                        $exclude_user_array = array($t_to_uid, $uid);

                        $thread_modified = (isset($thread_data['MODIFIED']) && is_numeric($thread_data['MODIFIED'])) ? $thread_data['MODIFIED'] : 0;

                        email_sendnotification($t_to_uid, $uid, $t_tid, $new_pid);

                        email_send_folder_subscription($uid, $t_fid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);

                        email_send_thread_subscription($uid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);
                    }
                }
            }

        }else {

            $new_pid = 0;

            if ($new_thread) {

                $t_tid = 0;
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }
        }

        if ($new_pid > -1) {

            if ($t_tid > 0 && $t_rpid > 0) {
                $uri = "lmessages.php?webtag=$webtag&msg=$t_tid.$t_rpid";
            }else {
                $uri = "lmessages.php?webtag=$webtag";
            }

            header_redirect($uri);
            exit;

        }else {

            $error_msg_array[] = gettext("Error creating post! Please try again in a few minutes.");
        }

    }else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', false, 0));
    }
}

light_html_draw_top(sprintf("title=%s", gettext("Post message")), "robots=noindex,nofollow");

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(mt_rand()));
}

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    if ($t_to_uid == 0) {

        $preview_message['TLOGON'] = gettext("ALL");
        $preview_message['TNICK'] = gettext("ALL");

    }else {

        $preview_tuser = user_get($t_to_uid);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];
    }

    $preview_tuser = user_get(session_get_value('UID'));
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $t_content;

    light_message_display(0, $preview_message, 0, 0, 0, false, false, false, false, true);
}

if (!$new_thread) {

    if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0) {

        if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            echo "<h3>", gettext("Warning: this thread is closed for posting to normal users."), "</h3>\n";

        }else {

            echo "<h3>", gettext("This thread is closed, you cannot post in it!"), "</h3>\n";
            light_html_draw_bottom();
            exit;
        }
    }
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpost.php\" method=\"post\">\n";
echo form_input_hidden('webtag', htmlentities_array($webtag));
echo form_input_hidden('t_dedupe', htmlentities_array($t_dedupe));

echo "<div class=\"post\">\n";

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if ($new_thread) {

    echo form_input_hidden("t_newthread", "Y");

    echo "<h3>", gettext("Create new thread"), "</h3>\n";
    echo "<div class=\"post_inner\">\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        light_html_display_error_array($error_msg_array);
    }

    echo "<div class=\"post_folder\">", gettext("Select folder"), ":", light_folder_draw_dropdown($t_fid, "t_fid"), "</div>";
    echo "<div class=\"post_thread_title\">", gettext("Thread title"), ":", light_form_input_text("t_threadtitle", htmlentities_array($t_threadtitle), 30, 64), "</div>";

}else {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {

        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

        light_html_display_error_msg(gettext("Message not found. Check that it hasn't been deleted."));
        light_html_draw_bottom();
        exit;

    }else {

        echo "<h3>", gettext("Post Reply"), ": ", word_filter_add_ob_tags(thread_get_title($reply_to_tid), true), "</h3>\n";
        echo "<div class=\"post_inner\">\n";

        if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
            light_html_display_error_array($error_msg_array);
        }

        echo form_input_hidden("t_tid", htmlentities_array($reply_to_tid));
        echo form_input_hidden("t_rpid", htmlentities_array($reply_to_pid))."\n";
    }
}

echo "<div class=\"post_to\">", gettext("To"), ":", post_draw_to_dropdown($t_to_uid), "</div>";
echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("t_content", $post->getTidyContent(), 10, 50), "</div>";

if ($allow_sig == true) {

    echo form_input_hidden("t_sig", $sig->getTidyContent());
    echo form_input_hidden("t_sig_html", htmlentities_array($t_sig_html));
}

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<div class=\"post_html\"><span>", gettext("HTML in message"), ":</span>\n";
    echo light_form_radio("t_post_html", "disabled", gettext("Disabled"), $tph_radio == POST_HTML_DISABLED);
    echo light_form_radio("t_post_html", "enabled_auto", gettext("Auto"), $tph_radio == POST_HTML_AUTO);
    echo light_form_radio("t_post_html", "enabled", gettext("Enabled"), $tph_radio == POST_HTML_ENABLED);
    echo "</div>";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("post", gettext("Post"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

echo "</div>";
echo "</div>";
echo "</form>\n";

if (!$new_thread && $reply_to_pid > 0) {

    echo "<h3>", gettext("In reply to"), ":</h3>\n";

    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($reply_to_tid, $thread_data['LENGTH'], $thread_data['FID'], $thread_data['CLOSED'], false, true);

    }else {

        light_message_display($reply_to_tid, $reply_message, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, false, true);
    }
}

light_html_draw_bottom();

?>
