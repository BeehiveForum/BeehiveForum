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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';
require_once BH_INCLUDE_PATH. 'swift.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_rel.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

function email_address_valid($email)
{
    return preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$/u', $email) > 0;
}

function email_sendnotification($tuid, $fuid, $tid, $pid)
{
    // Validate the function arguments.
    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    // Check the thread is valid
    if (!$thread = thread_get($tid)) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get the forum webtag.
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Get the to user details.
    if (!($to_user = user_get($tuid))) return false;

    // Get the from user details.
    if (!($from_user = user_get($fuid))) return false;

    // Get the to user preferences.
    if (!($to_user_prefs = user_get_prefs($tuid))) return false;

    // Get the relationship between to user and from user.
    $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

    // If the recipient is ignoring the sender bail out.
    if ($user_rel & USER_IGNORED_COMPLETELY) return false;

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Does the recipient want to receive email notifcations?
    if (!isset($to_user_prefs['EMAIL_NOTIFY']) || $to_user_prefs['EMAIL_NOTIFY'] != 'Y') return false;

    // Get the required variables (forum name, subject, recipient, etc.) and
    // pass them all through the recipient's word filter.
    $forum_name     = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject        = word_filter_apply(sprintf(gettext("Message Notification from %s"), $forum_name), $tuid, true);
    $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);
    $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);
    $thread_title   = word_filter_apply($thread['TITLE'], $tuid, true);

    // Generate link to the forum itself
    $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

    // Generate the message link.
    $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\n%s posted a message to you on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of forum messages posted to you, go to: %s click on My Controls then Email and Privacy, unselect the Email Notification checkbox and press Submit."), $recipient, $message_author, $forum_name, $thread_title, $message_link, $forum_link));

    // Set the recipient.
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_thread_subscription($fuid, $tid, $pid, $modified, &$exclude_user_array)
{
    // Validate the function arguments
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($modified)) return false;

    // Check the thread is valid
    if (!$thread = thread_get($tid)) return false;

    // Get the from user details
    if (!$from_user = user_get($fuid)) return false;

    // Get the forum details.
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Database connection.
    if (!$db = db::get()) return false;

    // Make sure $exclude_user_array is an array.
    if (!is_array($exclude_user_array)) $exclude_user_array = array();

    // Add the $fuid to it.
    array_push($exclude_user_array, $fuid);

    // Make sure it only contains numbers and implode it.
    $exclude_user_list = implode(",", array_filter($exclude_user_array, 'is_numeric'));

    // Get the forum webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Only send the email to people who logged after the thread was modified.
    $last_visit_datetime = date(MYSQL_DATETIME, $modified);

    $sql = "SELECT USER_THREAD.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL ";
    $sql.= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_THREAD.UID) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = USER_THREAD.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') WHERE USER_THREAD.TID = '$tid' ";
    $sql.= "AND USER_FORUM.LAST_VISIT > CAST('$last_visit_datetime' AS DATETIME) ";
    $sql.= "AND USER_THREAD.UID NOT IN ($exclude_user_list) ";
    $sql.= "AND USER_THREAD.INTEREST = 2";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows < 1) return false;

    while (($to_user = $result->fetch_assoc()) !== null) {

        // Get the relationship between the to and from user
        $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

        // If the recipient is ignoring the sender don't send them an email.
        if ($user_rel & USER_IGNORED_COMPLETELY) continue;

        // Validate the email address before we continue.
        if (!email_address_valid($to_user['EMAIL'])) continue;

        // Add the uid to exclude array
        array_push($exclude_user_array, $to_user['UID']);

        // Get the required variables (forum name, subject, recipient, etc.) and
        // pass them all through the recipient's word filter.
        $forum_name     = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $to_user['UID'], true);
        $subject        = word_filter_apply(sprintf(gettext("Subscription Notification from %s"), $forum_name), $to_user['UID'], true);
        $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $to_user['UID'], true);
        $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $to_user['UID'], true);
        $thread_title   = word_filter_apply($thread['TITLE'], $to_user['UID'], true);

        // Generate the message link.
        $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

        // Generate the message body.
        $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\n%s posted a message in a thread you have subscribed to on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new messages in this thread, go to: %s and adjust your Interest level at the bottom of the page."), $recipient, $message_author, $forum_name, $thread_title, $message_link, $message_link));

        // Add the recipient
        $message->addTo($to_user['EMAIL'], $recipient);

        // Set the subject
        $message->setSubject($subject);

        // Set the message body
        $message->setBody($message_body);

        // Send the email
        $mailer->send($message);
    }

    return true;
}

function email_send_folder_subscription($fuid, $fid, $tid, $pid, $modified, &$exclude_user_array)
{
    // Validate function arguments
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($modified)) return false;

    // Check the thread is valid
    if (!$thread = thread_get($tid)) return false;

    // Get the from user details
    if (!$from_user = user_get($fuid)) return false;

    // Get the forum details.
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Database connection.
    if (!$db = db::get()) return false;

    // Make sure $exclude_user_array is an array.
    if (!is_array($exclude_user_array)) $exclude_user_array = array();

    // Add the $fuid to it.
    array_push($exclude_user_array, $fuid);

    // Make sure it only contains numbers and implode it.
    $exclude_user_list = implode(",", array_filter($exclude_user_array, 'is_numeric'));

    // Get the forum webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Only send the email to people who logged after the thread was modified.
    $last_visit_datetime = date(MYSQL_DATETIME, $modified);

    $sql = "SELECT USER_FOLDER.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL ";
    $sql.= "FROM `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_FOLDER.UID) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = USER_FOLDER.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') WHERE USER_FOLDER.FID = '$fid' ";
    $sql.= "AND USER_FORUM.LAST_VISIT > CAST('$last_visit_datetime' AS DATETIME) ";
    $sql.= "AND USER_FOLDER.INTEREST = 1 AND USER_FOLDER.UID NOT IN ($exclude_user_list)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows < 1) return false;

    while (($to_user = $result->fetch_assoc()) !== null) {

        // Validate the email address before we continue.
        if (!email_address_valid($to_user['EMAIL'])) continue;

        // Add the uid to exclude array
        array_push($exclude_user_array, $to_user['UID']);

        // Get the required variables (forum name, subject, recipient, etc.) and
        // pass them all through the recipient's word filter.
        $forum_name     = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $to_user['UID'], true);
        $subject        = word_filter_apply(sprintf(gettext("Subscription Notification from %s"), $forum_name), $to_user['UID'], true);
        $recipient      = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $to_user['UID'], true);
        $message_author = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $to_user['UID'], true);
        $thread_title   = word_filter_apply($thread['TITLE'], $to_user['UID'], true);

        // Generate link to the forum itself
        $forum_link = html_get_forum_uri("index.php?webtag=$webtag&fid=$fid");

        // Generate the message link.
        $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

        // Generate the message body.
        $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\n%s posted a message in a folder you are subscribed to on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new messages in this thread, go to: %s and adjust your Interest level by clicking on the folder's icon at the top of page."), $recipient, $message_author, $forum_name, $thread_title, $message_link, $forum_link));

        // Add the recipient
        $message->setTo($to_user['EMAIL'], $recipient);

        // Set the subject
        $message->setSubject($subject);

        // Set the message body
        $message->setBody($message_body);

        // Send the email
        $mailer->send($message);
    }

    return true;
}

function email_send_pm_notification($tuid, $mid, $fuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;
    if (!is_numeric($mid)) return false;
    if (!is_numeric($fuid)) return false;

    // Check the PM exists.
    if (!$pm_subject = pm_get_subject($mid, $tuid)) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the from user details
    if (!($from_user = user_get($fuid))) return false;

    // Get the to user preferences
    if (!($to_user_prefs = user_get_prefs($tuid))) return false;

    // Get the relationship between the to and from user
    $user_rel = user_get_relationship($to_user['UID'], $from_user['UID']);

    // If the recipient is ignoring the sender bail out.
    if ($user_rel & USER_IGNORED_COMPLETELY) return false;

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Does the recipient want to receive email notifcations?
    if (!isset($to_user_prefs['PM_NOTIFY_EMAIL']) | $to_user_prefs['PM_NOTIFY_EMAIL'] != 'Y') return false;

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name      = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject         = word_filter_apply(sprintf(gettext("PM Notification from %s"), $forum_name), $tuid, true);
    $recipient       = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);
    $message_author  = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);
    $message_subject = word_filter_apply($pm_subject, $tuid, true);

    // Generate link to the forum itself
    $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

    // Generate the message link.
    $message_link = html_get_forum_uri("index.php?webtag=$webtag&pmid=$mid");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\n%s posted a PM to you on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read the message go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new PM messages posted to you, go to: %s click My Controls then Email and Privacy, unselect the PM Notification checkbox and press Submit."), $recipient, $message_author, $forum_name, $message_subject, $message_link, $forum_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

// Sends a password reminder email. Returns true on success, false on fail.
function email_send_pw_reminder($logon)
{
    // Validate function arguments
    if (!is_string($logon)) return false;

    // Check the User Logon is valid.
    if (!($to_user = user_get_by_logon($logon))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $to_user['UID'], true);
    $subject    = word_filter_apply(sprintf(gettext("Your password reset request from %s"), $forum_name), $to_user['UID'], true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $to_user['UID'], true);

    // Generate the change password link.
    $change_pw_link = rawurlencode("/change_pw.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
    $change_pw_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$change_pw_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nYou requested this e-mail from %s because you have forgotten your password.\r\n\r\nClick the link below (or copy and paste it into your browser) to reset your password:\r\n\r\n%s"), $recipient, $forum_name, $change_pw_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_new_pw_notification($tuid, $fuid, $new_password)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_string($new_password)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the from user details
    if (!($from_user = user_get($fuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name        = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject           = word_filter_apply(sprintf(gettext("Password change notification from %s"), $forum_name), $tuid, true);
    $recipient         = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);
    $passwd_changed_by = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nThis a notification email to inform you that your password on %s has been changed.\r\n\r\nIt has been changed to: %s and was changed by: %s.\r\n\r\nIf you have received this email in error or were not expecting a change to your password please contact the forum owner or a moderator on %s immediately to correct it."), $recipient, $forum_name, $new_password, $passwd_changed_by, $forum_name));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_user_confirmation($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum reply-to email address
    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("Email confirmation required for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
    $confirm_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$confirm_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nYou recently created a new user account on %s.\r\n\r\nBefore you can start posting we need to confirm your email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\r\n\r\n%s\r\n\r\nOnce confirmation is complete you may login and start posting immediately.\r\n\r\nIf you did not create a user account on %s please accept our apologies and forward this email to %s so that the source of it may be investigated."), $recipient, $forum_name, $confirm_link, $forum_name, $forum_email));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_changed_email_confirmation($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum reply-to email address
    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("Email confirmation required for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");
    $confirm_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$confirm_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nYou recently changed your email on %s.\r\n\r\nBefore you can start posting again we need to confirm your new email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\r\n\r\n%s\r\n\r\nOnce confirmation is complete you may continue to use the forum as normal.\r\n\r\nIf you were not expecting this email from %s please accept our apologies and forward this email to %s so that the source of it may be investigated."), $recipient, $forum_name, $confirm_link, $forum_name, $forum_email));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_user_approval_notification($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("New User Approval Notification for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $admin_users_link = rawurlencode("/admin_users.php?webtag=$webtag&filter=4");
    $admin_users_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_users_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nA new user account has been created on %s.\r\n\r\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\r\n\r\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\" or click the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."), $recipient, $forum_name, $admin_users_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_new_user_notification($tuid, $new_user_uid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;
    if (!is_numeric($new_user_uid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("New User Account Notification for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $admin_user_link = rawurlencode("/admin_user.php?webtag=$webtag&uid=$new_user_uid");
    $admin_user_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_user_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nA new user account has been created on %s.\r\n\r\nTo view this user account please visit the Admin Users section and click on the new user or click the link below:\r\n\r\n%s"), $recipient, $forum_name, $admin_user_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_user_approved_notification($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum reply-to email address
    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("User approval notification for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nYour user account at %s has been approved. You can login and start posting immediately by clicking the link below:\r\n\r\n%s\r\n\r\nIf you were not expecting this email from %s please accept our apologies and forward this email to %s so that the source of it may be investigated."), $recipient, $forum_name, $forum_link, $forum_name, $forum_email));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_post_approval_notification($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("Post Approval Notification for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $admin_post_approval_link = rawurlencode("/admin_post_approve.php?webtag=$webtag");
    $admin_post_approval_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_post_approval_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nA new post has been created on %s.\r\n\r\nAs you are a Moderator on this forum you are required to approve this post before it can be read by other users.\r\n\r\nYou can approve this post and any others pending approval by visiting the Admin Post Approval section of your forum or by clicking the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."), $recipient, $forum_name, $admin_post_approval_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_link_approval_notification($tuid)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Get Forum Webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $subject    = word_filter_apply(sprintf(gettext("Link Approval Notification for %s"), $forum_name), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    // Generate the confirmation link.
    $admin_post_approval_link = rawurlencode("/admin_link_approve.php?webtag=$webtag");
    $admin_post_approval_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_post_approval_link");

    // Generate the message body.
    $message_body = wordwrap(sprintf(gettext("Hello %s,\r\n\r\nA new link has been created on %s.\r\n\r\nAs you are a Link Moderator on this forum you are required to approve this link before it can be read by other users.\r\n\r\nYou can approve this link and any others pending approval by visiting the Admin Link Approval section of your forum or by clicking the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."), $recipient, $forum_name, $admin_post_approval_link));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_send_message_to_user($tuid, $fuid, $subject, $message_body, $use_email_addr)
{
    // Validate function arguments
    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;

    // Get the to user details
    if (!($to_user = user_get($tuid))) return false;

    // Get the to user details
    if (!($from_user = user_get($fuid))) return false;

    // Get the Swift Mailer Transport
    if (!($transport = Swift_TransportFactory::get())) return false;

    //Create the Mailer using the returned Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a new message
    $message = Swift_MessageBeehive::newInstance();

    // Validate the email address before we continue.
    if (!email_address_valid($to_user['EMAIL'])) return false;

    // Get the forum name, subject, recipient, author, thread title and generate
    // the messages link. Pass all of them through the recipient's word filter.
    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);
    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);
    $sent_from  = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);

    // Word filter the message to be sent.
    $message_body = word_filter_apply($message_body, $tuid, true);

    // Add the Sent By footer to the message.
    $message_body.= "\r\n\r\n". wordwrap(sprintf(gettext("This message was sent from %s by %s"), $forum_name, $sent_from));

    // Add the recipient
    $message->setTo($to_user['EMAIL'], $recipient);

    // Set the from recipient
    if ($use_email_addr) $message->setFrom($from_user['EMAIL'], $sent_from);

    // Set the subject
    $message->setSubject($subject);

    // Set the message body
    $message->setBody($message_body);

    // Send the email
    return $mailer->send($message) > 0;
}

function email_is_unique($email_address, $user_uid = 0)
{
    if (!$db = db::get()) return false;

    $email_address = $db->escape($email_address);

    if (!is_numeric($user_uid) || $user_uid == 0) {

        $sql = "SELECT COUNT(UID) FROM USER WHERE EMAIL = '$email_address'";

    } else {

        $sql = "SELECT COUNT(UID) FROM USER WHERE UID <> '$user_uid' ";
        $sql.= "AND EMAIL = '$email_address' ";
    }

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return ($user_count < 1);
}

?>