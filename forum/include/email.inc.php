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

/* $Id: email.inc.php,v 1.137 2008-07-25 14:52:42 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function email_address_valid($email)
{
    return ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $email);
}

function email_sendnotification($tuid, $fuid, $tid, $pid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid)) && ($from_user = user_get($fuid))) {

        if (($to_user_prefs = user_get_prefs($tuid))) {

            $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

            // If the recipient is ignoring the sender bail out.

            if ($user_rel & USER_IGNORED_COMPLETELY) return false;

            // Validate the email address before we continue.

            if (!email_address_valid($to_user['EMAIL'])) return false;

            // Does the recipient want to receive email notifcations?

            if (isset($to_user_prefs['EMAIL_NOTIFY']) && $to_user_prefs['EMAIL_NOTIFY'] == 'Y') {

                if (!$thread = thread_get($tid)) return false;

                // Get the right language for the email

                $lang = email_get_language($tuid);

                // Get the forum reply-to email address

                $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

                // Get the required variables (forum name, subject, recipient, etc.) and
                // pass them all through the recipient's word filter.

                $forum_name     = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
                $subject        = word_filter_apply(sprintf($lang['msgnotification_subject'], $forum_name), $tuid);
                $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
                $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);
                $thread_title   = word_filter_apply(thread_format_prefix($thread['PREFIX'], $thread['TITLE']), $tuid);

                // Generate link to the forum itself

                $forum_link = html_get_forum_uri();

                // Generate the message link.

                $message_link = html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.$pid");

                // Generate the message body.

                $message = wordwrap(sprintf($lang['msgnotificationemail'], $recipient, $message_author, $forum_name, $thread_title, $message_link, $forum_link));

                // Email Headers (inc. PHP version and Beehive version)

                $header = "Return-path: $forum_email\n";
                $header.= "From: \"$forum_name\" <$forum_email>\n";
                $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
                $header.= "Content-type: text/plain; charset=UTF-8\n";
                $header.= "X-Mailer: PHP/". phpversion(). "\n";
                $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

                // SF.net Bug #1040563:
                // -------------------
                // RFC2822 compliancy requires that the RCPT TO portion of the
                // email headers only contain the email address in < >
                // i.e. <someuser@abeehiveforum.net>

                if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
            }
        }
    }

    return false;
}

function email_send_thread_subscription($tuid, $fuid, $tid, $pid, $modified, &$exclude_user_array)
{
    if (!$db_email_send_thread_subscription = db_connect()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    if (!is_numeric($modified)) return false;

    if (!is_array($exclude_user_array)) $exclude_user_array = array();

    if (!check_mail_variables()) return false;

    if (!$from_user = user_get($fuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $webtag = get_webtag($webtag_search);

    $exclude_user_list = implode(",", preg_grep("/^[0-9]+$/", $exclude_user_array));

    $sql = "SELECT USER_THREAD.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL ";
    $sql.= "FROM {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_THREAD.UID) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = USER_THREAD.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') WHERE USER_THREAD.TID = '$tid' ";
    $sql.= "AND UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) > $modified ";
    $sql.= "AND USER_THREAD.UID NOT IN ($tuid, $fuid, $exclude_user_list) ";
    $sql.= "AND USER_THREAD.INTEREST = 2";

    if (!$result = db_query($sql, $db_email_send_thread_subscription)) return false;

    if (db_num_rows($result) > 0) {

        while ($to_user = db_fetch_array($result)) {

            $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

            if ($user_rel & USER_IGNORED_COMPLETELY) return false;

            // Validate the email address before we continue.

            if (!email_address_valid($to_user['EMAIL'])) return false;

            if (!$thread = thread_get($tid)) return false;

            // Get the right language for the email

            $lang = email_get_language($tuid);

            // Get the forum reply-to email address

            $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

            // Get the required variables (forum name, subject, recipient, etc.) and
            // pass them all through the recipient's word filter.

            $forum_name     = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
            $subject        = word_filter_apply(sprintf($lang['threadsubnotification_subject'], $forum_name), $tuid);
            $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
            $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);
            $thread_title   = word_filter_apply(thread_format_prefix($thread['PREFIX'], $thread['TITLE']), $tuid);

            // Generate link to the forum itself

            $forum_link = html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.$pid");

            // Generate the message link.

            $message_link = html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.$pid");

            // Generate the message body.

            $message = wordwrap(sprintf($lang['threadsubnotification'], $recipient, $message_author, $forum_name, $thread_title, $message_link, $forum_link));

            // Email Headers (inc. PHP version and Beehive version)

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";
            $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

            // SF.net Bug #1040563:
            // -------------------
            // RFC2822 compliancy requires that the RCPT TO portion of the
            // email headers only contain the email address in < >
            // i.e. <someuser@abeehiveforum.net>

            if (!@mail($to_user['EMAIL'], $subject, $message, $header)) return false;
        }
    }

    return true;
}

function email_send_folder_subscription($tuid, $fuid, $fid, $tid, $pid, $modified, &$exclude_user_array)
{
    if (!$db_email_send_folder_subscription = db_connect()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!is_numeric($modified)) return false;

    if (!is_array($exclude_user_array)) $exclude_user_array = array();

    if (!check_mail_variables()) return false;

    if (!$from_user = user_get($fuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $webtag = get_webtag($webtag_search);

    $exclude_user_list = implode(",", preg_grep("/^[0-9]+$/", $exclude_user_array));

    $sql = "SELECT USER_FOLDER.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL ";
    $sql.= "FROM {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_FOLDER.UID) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = USER_FOLDER.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') WHERE USER_FOLDER.FID = '$fid' ";
    $sql.= "AND UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) > $modified ";
    $sql.= "AND USER_FOLDER.INTEREST = 1 AND USER_FOLDER.UID NOT IN ($exclude_user_list)";

    if (!$result = db_query($sql, $db_email_send_folder_subscription)) return false;

    if (db_num_rows($result) > 0) {

        while ($to_user = db_fetch_array($result)) {

            // Validate the email address before we continue.

            if (!email_address_valid($to_user['EMAIL'])) return false;

            if (!$thread = thread_get($tid)) return false;

            // Get the right language for the email

            $lang = email_get_language($tuid);

            // Get the forum reply-to email address

            $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

            // Get the required variables (forum name, subject, recipient, etc.) and
            // pass them all through the recipient's word filter.

            $forum_name     = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
            $subject        = word_filter_apply(sprintf($lang['foldersubnotification_subject'], $forum_name), $tuid);
            $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
            $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);
            $thread_title   = word_filter_apply(thread_format_prefix($thread['PREFIX'], $thread['TITLE']), $tuid);

            // Generate link to the forum itself

            $forum_link = html_get_forum_uri("/index.php?webtag=$webtag&fid=$fid");

            // Generate the message link.

            $message_link = html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.$pid");

            // Generate the message body.

            $message = wordwrap(sprintf($lang['foldersubnotification'], $recipient, $message_author, $forum_name, $thread_title, $message_link, $forum_link));

            // Email Headers (inc. PHP version and Beehive version)

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";
            $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

            // SF.net Bug #1040563:
            // -------------------
            // RFC2822 compliancy requires that the RCPT TO portion of the
            // email headers only contain the email address in < >
            // i.e. <someuser@abeehiveforum.net>

            if (!@mail($to_user['EMAIL'], $subject, $message, $header)) return false;

            // Add the recipient's UID to the exclude user list so they
            // don't also receive a thread subscription notification.

            if (!in_array($to_user['UID'], $exclude_user_array)) $exclude_user_array[] = $to_user['UID'];
        }
    }

    return true;
}

function email_send_pm_notification($tuid, $mid, $fuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($mid)) return false;
    if (!is_numeric($fuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid)) && ($from_user = user_get($fuid))) {

        if (($to_user_prefs = user_get_prefs($tuid))) {

            $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

            // If the recipient is ignoring the sender bail out.

            if ($user_rel & USER_IGNORED_COMPLETELY) return false;

            // Validate the email address before we continue.

            if (!email_address_valid($to_user['EMAIL'])) return false;

            // Does the recipient want to receive email notifcations?

            if (isset($to_user_prefs['PM_NOTIFY_EMAIL']) && $to_user_prefs['PM_NOTIFY_EMAIL'] == 'Y') {

                if (!$pm_subject = pm_get_subject($mid, $tuid)) return false;

                // Get the right language for the email

                $lang = email_get_language($tuid);

                // Get the forum reply-to email address

                $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

                // Get the forum name, subject, recipient, author, thread title and generate
                // the messages link. Pass all of them through the recipient's word filter.

                $forum_name      = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
                $subject         = word_filter_apply(sprintf($lang['pmnotification_subject'], $forum_name), $tuid);
                $recipient       = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
                $message_author  = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);
                $message_subject = word_filter_apply(_htmlentities_decode($pm_subject), $tuid);

                // Generate link to the forum itself

                $forum_link = html_get_forum_uri();

                // Generate the message link.

                $message_link = html_get_forum_uri("/index.php?webtag=$webtag&pmid=$mid");

                // Generate the message body.

                $message = wordwrap(sprintf($lang['pmnotification'], $recipient, $message_author, $forum_name, $message_subject, $message_link, $forum_link));

                // Email Headers (inc. PHP version and Beehive version)

                $header = "Return-path: $forum_email\n";
                $header.= "From: \"$forum_name\" <$forum_email>\n";
                $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
                $header.= "Content-type: text/plain; charset=UTF-8\n";
                $header.= "X-Mailer: PHP/". phpversion(). "\n";
                $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

                // SF.net Bug #1040563:
                // -------------------
                // RFC2822 compliancy requires that the RCPT TO portion of the
                // email headers only contain the email address in < >
                // i.e. <someuser@abeehiveforum.net>

                if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
            }
        }
    }

    return false;
}

// Sends a password reminder email. Returns true on success, false on fail.

function email_send_pw_reminder($logon)
{
    if (!check_mail_variables()) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get_uid($logon))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        if (isset($to_user['UID']) && isset($to_user['EMAIL']) && isset($to_user['PASSWD'])) {

            // Get the right language for the email

            $lang = email_get_language($to_user['UID']);

            // Get the forum reply-to email address

            $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

            // Get the forum name, subject, recipient, author, thread title and generate
            // the messages link. Pass all of them through the recipient's word filter.

            $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $to_user['UID']);
            $subject    = word_filter_apply(sprintf($lang['passwdresetrequest'], $forum_name), $to_user['UID']);
            $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $to_user['UID']);

            // Generate the change password link.

            $change_pw_link = rawurlencode("/change_pw.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
            $change_pw_link = html_get_forum_uri("/index.php?webtag=$webtag&final_uri=$change_pw_link");

            // Generate the message body.

            $message = wordwrap(sprintf($lang['forgotpwemail'], $recipient, $forum_name, $change_pw_link));

            // Email Headers (inc. PHP version and Beehive version)

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";
            $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

            // SF.net Bug #1040563:
            // -------------------
            // RFC2822 compliancy requires that the RCPT TO portion of the
            // email headers only contain the email address in < >
            // i.e. <someuser@abeehiveforum.net>

            if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
        }
    }

    return false;
}

function email_send_new_pw_notification($tuid, $fuid, $new_password)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid)) && ($from_user = user_get($fuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

        // Get the forum name, subject, recipient, author, thread title and generate
        // the messages link. Pass all of them through the recipient's word filter.

        $forum_name        = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject           = word_filter_apply(sprintf($lang['passwdchangenotification'], $forum_name), $tuid);
        $recipient         = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
        $passwd_changed_by = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);

        // Generate the message body.

        $message = wordwrap(sprintf($lang['pwchangeemail'], $recipient, $forum_name, $new_password, $passwd_changed_by, $forum_name));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_user_confirmation($tuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');
        $forum_no_reply_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

        // Get the forum name, subject, recipient, author, thread title and generate
        // the messages link. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['emailconfirmationrequiredsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
        $confirm_link = html_get_forum_uri("/index.php?webtag=$webtag&final_uri=$confirm_link");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['confirmemail'], $recipient, $forum_name, $confirm_link, $forum_name, $forum_email));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_no_reply_email\n";
        $header.= "From: \"$forum_name\" <$forum_no_reply_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_no_reply_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_changed_email_confirmation($tuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');
        $forum_noreply_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

        // Get the forum name, subject, recipient, author, thread title and generate
        // the messages link. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['emailconfirmationrequiredsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
        $confirm_link = html_get_forum_uri("/index.php?webtag=$webtag&final_uri=$confirm_link");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['confirmchangedemail'], $recipient, $forum_name, $confirm_link, $forum_name, $forum_email));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_noreply_email\n";
        $header.= "From: \"$forum_name\" <$forum_noreply_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_noreply_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_user_approval_notification($tuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['newuserapprovalsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $admin_users_link = rawurlencode("/admin_users.php?webtag=$webtag&filter=4");
        $admin_users_link = html_get_forum_uri("/index.php?webtag=DEFAULT&final_uri=$admin_users_link");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['newuserapprovalemail'], $recipient, $forum_name, $admin_users_link));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_new_user_notification($tuid, $new_user_uid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($new_user_uid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['newuserregistrationsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $admin_user_link = rawurlencode("/admin_user.php?webtag=$webtag&uid=$new_user_uid");
        $admin_user_link = html_get_forum_uri("/index.php?webtag=DEFAULT&final_uri=$admin_user_link");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['newuserregistrationemail'], $recipient, $forum_name, $admin_user_link));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_user_approved_notification($tuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');
        $forum_noreply_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

        // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['useraccountapprovedsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $forum_link = html_get_forum_uri("/index.php?webtag=$webtag");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['useraccountapprovedemail'], $recipient, $forum_name, $forum_link, $forum_name, $forum_email));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_noreply_email\n";
        $header.= "From: \"$forum_name\" <$forum_noreply_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_noreply_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_post_approval_notification($tuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $subject    = word_filter_apply(sprintf($lang['newpostapprovalsubject'], $forum_name), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);

        // Generate the confirmation link.

        $admin_post_approval_link = rawurlencode("/admin_post_approve.php?webtag=$webtag");
        $admin_post_approval_link = html_get_forum_uri("/index.php?webtag=DEFAULT&final_uri=$admin_post_approval_link");

        // Generate the message body.

        $message = wordwrap(sprintf($lang['newpostapprovalemail'], $recipient, $forum_name, $admin_post_approval_link));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

function email_send_message_to_user($tuid, $fuid, $subject, $message)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    $webtag = get_webtag($webtag_search);

    if (($to_user = user_get($tuid)) && ($from_user = user_get($fuid))) {

        // Validate the email address before we continue.

        if (!email_address_valid($to_user['EMAIL'])) return false;

        // Get the right language for the email

        $lang = email_get_language($to_user['UID']);

        // Get the forum reply-to email address

        $forum_email = forum_get_setting('forum_noreply_email', false, 'noreply@abeehiveforum.net');

        // Get the forum name, subject, recipient, author, thread title and generate
        // the messages link. Pass all of them through the recipient's word filter.

        $forum_name = word_filter_apply(forum_get_setting('forum_name', false, 'A Beehive Forum'), $tuid);
        $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid);
        $sent_from  = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid);

        // Word filter the message to be sent.

        $message = word_filter_apply($message, $tuid);

        // Add the Sent By footer to the message.

        $message.= wordwrap(sprintf("\n\n{$lang['msgsentfromby']}", $recipient, $sent_from, $forum_name));

        // Email Headers (inc. PHP version and Beehive version)

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";
        $header.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        // SF.net Bug #1040563:
        // -------------------
        // RFC2822 compliancy requires that the RCPT TO portion of the
        // email headers only contain the email address in < >
        // i.e. <someuser@abeehiveforum.net>

        if (@mail($to_user['EMAIL'], $subject, $message, $header)) return true;
    }

    return false;
}

// fetches the correct language file for the UID ($to_uid) who the email is being sent to

function email_get_language($to_uid)
{
    // Start out by including the English language file. This will allow
    // us to still use Beehive even if our language file isn't up to date
    // correctly.

    // The English language file must exist even if we're not going to be
    // using it in our forum. If we can't find it we'll bail out here.

    if (!file_exists(BH_INCLUDE_PATH. "languages/en.inc.php")) {
        trigger_error("<p>Could not load English language file (en.inc.php)</p>", E_USER_ERROR);
    }

    include(BH_INCLUDE_PATH. "languages/en.inc.php");

    $default_language = forum_get_setting('default_language', false, 'en');

     // if the user has expressed a preference for language, use it
     // if available otherwise use the default language.

    if (($user_prefs = user_get_prefs($to_uid))) {

        if (isset($user_prefs['LANGUAGE']) && @file_exists("include/languages/{$user_prefs['LANGUAGE']}.inc.php")) {

             require("include/languages/{$user_prefs['LANGUAGE']}.inc.php");
             return $lang;
        }
    }

    require("include/languages/{$default_language}.inc.php");
    return $lang;
}

function email_is_unique($email_address, $user_uid = 0)
{
    if (!$db_email_is_unique = db_connect()) return false;

    $email_address = db_escape_string($email_address);

    if (!is_numeric($user_uid) || $user_uid == 0) {

        $sql = "SELECT COUNT(UID) FROM USER WHERE EMAIL = '$email_address'";

    }else {

        $sql = "SELECT COUNT(UID) FROM USER WHERE UID <> '$user_uid' ";
        $sql.= "AND EMAIL = '$email_address' ";
    }

    if (!$result = db_query($sql, $db_email_is_unique)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_count < 1);
}

function check_mail_variables()
{
    if (server_os_mswin()) {

        if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP')) return false;

    }else {

        if (!(bool)@ini_get('sendmail_path')) return false;
    }

    return true;
}

?>