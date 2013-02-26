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

// Required includes
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'swift.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';
// End Required includes

function email_address_valid($email)
{
    return preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$/u', $email) > 0;
}

function email_send_notification($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT THREAD.TITLE AS THREAD_TITLE, TO_USER.UID, TO_USER.LOGON, TO_USER.NICKNAME, ";
    $sql.= "TO_USER.EMAIL, FROM_USER.LOGON AS FROM_LOGON, FROM_USER.NICKNAME AS FROM_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP, COALESCE(USER_PREFS_FORUM.EMAIL_NOTIFY, ";
    $sql.= "USER_PREFS.EMAIL_NOTIFY, 'N') AS EMAIL_NOTIFY FROM `{$table_prefix}THREAD` THREAD ";
    $sql.= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql.= "INNER JOIN `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT ON (POST_RECIPIENT.TID = POST.TID ";
    $sql.= "AND POST_RECIPIENT.PID = POST.PID AND POST_RECIPIENT.TO_UID <> POST.FROM_UID) ";
    $sql.= "INNER JOIN USER TO_USER ON (TO_USER.UID = POST_RECIPIENT.TO_UID) ";
    $sql.= "INNER JOIN USER FROM_USER ON (FROM_USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = TO_USER.UID) ";
    $sql.= "LEFT JOIN USER_PREFS  ON (USER_PREFS.UID = TO_USER.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = TO_USER.UID AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "WHERE THREAD.TID = '$tid' AND POST.PID = '$pid' ";
    $sql.= "HAVING EMAIL_NOTIFY = 'Y' AND (RELATIONSHIP IS NULL ";
    $sql.= "OR RELATIONSHIP & $user_ignored_completely = 0)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $count = 0;

    while (($email_data = $result->fetch_assoc()) !== null) {

        if (!email_address_valid($email_data['EMAIL'])) continue;

        $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $email_data['UID'], true);

        $subject = word_filter_apply(sprintf(gettext("Message Notification from %s"), $forum_name), $email_data['UID'], true);

        $recipient = word_filter_apply(format_user_name($email_data['LOGON'], $email_data['NICKNAME']), $email_data['UID'], true);

        $message_author = word_filter_apply(format_user_name($email_data['FROM_LOGON'], $email_data['FROM_NICKNAME']), $email_data['UID'], true);

        $thread_title = word_filter_apply($email_data['THREAD_TITLE'], $email_data['UID'], true);

        $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

        $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

        $message_body = wordwrap(sprintf(
            gettext("Hello %s,\r\n\r\n%s posted a message to you on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of forum messages posted to you, go to: %s click on My Controls then Email and Privacy, unselect the Email Notification checkbox and press Submit."),
            $recipient,
            $message_author,
            $forum_name,
            $thread_title,
            $message_link,
            $forum_link
        ));

        $message = Swift_MessageBeehive::newInstance();

        $message->setTo($email_data['EMAIL'], $recipient);

        $message->setSubject($subject);

        $message->setBody($message_body);

        $count+= $mailer->send($message);
    }

    return $count;
}

function email_send_thread_subscription($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $thread_subscribed = THREAD_SUBSCRIBED;

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT THREAD.TITLE AS THREAD_TITLE, TO_USER.UID, TO_USER.LOGON, TO_USER.NICKNAME, ";
    $sql.= "TO_USER.EMAIL, FROM_USER.LOGON AS FROM_LOGON, FROM_USER.NICKNAME AS FROM_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP, POST_PREVIOUS.CREATED, USER_FORUM.LAST_VISIT FROM `{$table_prefix}THREAD` THREAD ";
    $sql.= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql.= "INNER JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.INTEREST = $thread_subscribed) ";
    $sql.= "INNER JOIN USER TO_USER ON (TO_USER.UID = USER_THREAD.UID) ";
    $sql.= "INNER JOIN USER FROM_USER ON (FROM_USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = TO_USER.UID AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}POST` POST_PREVIOUS ON (POST_PREVIOUS.TID = POST.TID AND POST_PREVIOUS.PID = POST.PID - 1) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = TO_USER.UID AND USER_FORUM.FID = $forum_fid) ";
    $sql.= "WHERE USER_THREAD.UID NOT IN (SELECT FROM_UID FROM `{$table_prefix}POST` WHERE TID = POST.TID AND PID = POST.PID) ";
    $sql.= "AND USER_THREAD.UID NOT IN (SELECT TO_UID FROM `{$table_prefix}POST_RECIPIENT` WHERE TID = POST.TID AND PID = POST.PID) ";
    $sql.= "AND THREAD.TID = $tid AND POST.PID = $pid ";
    $sql.= "HAVING (RELATIONSHIP IS NULL OR RELATIONSHIP & 8 = $user_ignored_completely) ";
    $sql.= "AND (LAST_VISIT > CREATED OR CREATED IS NULL)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $count = 0;

    while (($email_data = $result->fetch_assoc()) !== null) {

        if (!email_address_valid($email_data['EMAIL'])) continue;

        $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $email_data['UID'], true);

        $subject = word_filter_apply(sprintf(gettext("Thread Subscription Notification from %s"), $forum_name), $email_data['UID'], true);

        $recipient = word_filter_apply(format_user_name($email_data['LOGON'], $email_data['NICKNAME']), $email_data['UID'], true);

        $message_author = word_filter_apply(format_user_name($email_data['FROM_LOGON'], $email_data['FROM_NICKNAME']), $email_data['UID'], true);

        $thread_title = word_filter_apply($email_data['THREAD_TITLE'], $email_data['UID'], true);

        $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

        $message_body = wordwrap(sprintf(
            gettext("Hello %s,\r\n\r\n%s posted a message in a thread you have subscribed to on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new messages in this thread, go to: %s and adjust your Interest level at the bottom of the page."),
            $recipient,
            $message_author,
            $forum_name,
            $thread_title,
            $message_link,
            $message_link
        ));

        $message = Swift_MessageBeehive::newInstance();

        $message->addTo($email_data['EMAIL'], $recipient);

        $message->setSubject($subject);

        $message->setBody($message_body);

        $count+= $mailer->send($message);
    }

    return $count;
}

function email_send_folder_subscription($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    if (!$db = db::get()) return false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $folder_subscribed = FOLDER_SUBSCRIBED;

    $thread_subscribed = THREAD_SUBSCRIBED;

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT THREAD.TITLE AS THREAD_TITLE, THREAD.FID AS FOLDER_FID, TO_USER.UID, TO_USER.LOGON, ";
    $sql.= "TO_USER.NICKNAME, TO_USER.EMAIL, FROM_USER.LOGON AS FROM_LOGON, FROM_USER.NICKNAME AS FROM_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP, POST_PREVIOUS.CREATED, USER_FORUM.LAST_VISIT FROM `{$table_prefix}THREAD` THREAD ";
    $sql.= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql.= "INNER JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.INTEREST = $folder_subscribed) ";
    $sql.= "INNER JOIN USER TO_USER ON (TO_USER.UID = USER_FOLDER.UID) ";
    $sql.= "INNER JOIN USER FROM_USER ON (FROM_USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = TO_USER.UID AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}POST` POST_PREVIOUS ON (POST_PREVIOUS.TID = POST.TID AND POST_PREVIOUS.PID = POST.PID - 1) ";
    $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.UID = TO_USER.UID AND USER_FORUM.FID = $forum_fid) ";
    $sql.= "WHERE USER_FOLDER.UID NOT IN (SELECT UID FROM `{$table_prefix}USER_THREAD` WHERE TID = THREAD.TID AND INTEREST = $thread_subscribed) ";
    $sql.= "AND USER_FOLDER.UID NOT IN (SELECT FROM_UID FROM `{$table_prefix}POST` WHERE TID = POST.TID AND PID = POST.PID) ";
    $sql.= "AND USER_FOLDER.UID NOT IN (SELECT TO_UID FROM `{$table_prefix}POST_RECIPIENT` WHERE TID = POST.TID AND PID = POST.PID) ";
    $sql.= "AND THREAD.TID = $tid AND POST.PID = $pid ";
    $sql.= "HAVING (RELATIONSHIP IS NULL OR RELATIONSHIP & $user_ignored_completely = 0) ";
    $sql.= "AND (LAST_VISIT > CREATED OR CREATED IS NULL) ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $count = 0;

    while (($email_data = $result->fetch_assoc()) !== null) {

        if (!email_address_valid($email_data['EMAIL'])) continue;

        $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $email_data['UID'], true);

        $subject = word_filter_apply(sprintf(gettext("Folder Subscription Notification from %s"), $forum_name), $email_data['UID'], true);

        $recipient = word_filter_apply(format_user_name($email_data['LOGON'], $email_data['NICKNAME']), $email_data['UID'], true);

        $message_author = word_filter_apply(format_user_name($email_data['FROM_LOGON'], $email_data['FROM_NICKNAME']), $email_data['UID'], true);

        $thread_title = word_filter_apply($email_data['THREAD_TITLE'], $email_data['UID'], true);

        $forum_link = html_get_forum_uri("index.php?webtag=$webtag&fid={$email_data['FOLDER_FID']}");

        $message_link = html_get_forum_uri("index.php?webtag=$webtag&msg=$tid.$pid");

        $message_body = wordwrap(sprintf(gettext(
            "Hello %s,\r\n\r\n%s posted a message in a folder you are subscribed to on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read that message and others in the same discussion, go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new messages in this thread, go to: %s and adjust your Interest level by clicking on the folder's icon at the top of page."),
            $recipient,
            $message_author,
            $forum_name,
            $thread_title,
            $message_link,
            $forum_link
        ));

        $message = Swift_MessageBeehive::newInstance();

        $message->setTo($email_data['EMAIL'], $recipient);

        $message->setSubject($subject);

        $message->setBody($message_body);

        $count+= $mailer->send($message);
    }

    return $count;
}

function email_send_pm_notification($mid)
{
    if (!is_numeric($mid)) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    if (!$db = db::get()) return false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT PM.SUBJECT, TO_USER.LOGON, TO_USER.NICKNAME, TO_USER.EMAIL, ";
    $sql.= "FROM_USER.LOGON AS FROM_LOGON, FROM_USER.NICKNAME AS FROM_NICKNAME, ";
    $sql.= "COALESCE(USER_PREFS.PM_NOTIFY_EMAIL, 'N') AS PM_NOTIFY_EMAIL FROM PM ";
    $sql.= "INNER JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID AND PM_RECIPIENT.TO_UID <> PM.FROM_UID) ";
    $sql.= "INNER JOIN USER TO_USER ON (TO_USER.UID = PM_RECIPIENT.TO_UID) ";
    $sql.= "INNER JOIN USER FROM_USER ON (FROM_USER.UID = PM.FROM_UID) ";
    $sql.= "LEFT JOIN USER_PREFS ON (USER_PREFS.UID = TO_USER.UID) ";
    $sql.= "WHERE PM.MID = $mid HAVING PM_NOTIFY_EMAIL = 'Y'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $count = 0;

    while (($email_data = $result->fetch_assoc()) !== null) {

        if (!email_address_valid($email_data['EMAIL'])) continue;

        $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

        $subject = sprintf(gettext("PM Notification from %s"), $forum_name);

        $message_author = format_user_name($email_data['FROM_LOGON'], $email_data['FROM_NICKNAME']);

        $message_subject = $email_data['SUBJECT'];

        $recipient = format_user_name($email_data['LOGON'], $email_data['NICKNAME']);

        $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

        $message_link = html_get_forum_uri("index.php?webtag=$webtag&pmid=$mid");

        $message_body = wordwrap(
            sprintf(
                gettext("Hello %s,\r\n\r\n%s posted a PM to you on %s.\r\n\r\nThe subject is: %s.\r\n\r\nTo read the message go to:\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: If you do not wish to receive email notifications of new PM messages posted to you, go to: %s click My Controls then Email and Privacy, unselect the PM Notification checkbox and press Submit."),
                $recipient,
                $message_author,
                $forum_name,
                $message_subject,
                $message_link,
                $forum_link
            )
        );

        $message = Swift_MessageBeehive::newInstance();

        $message->setTo($email_data['EMAIL'], $recipient);

        $message->setSubject($subject);

        $message->setBody($message_body);

        $count+= $mailer->send($message);
    }

    return $count;
}

function email_send_pw_reminder($logon)
{
    if (!is_string($logon)) return false;

    if (!($to_user = user_get_by_logon($logon))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $to_user['UID'], true);

    $subject = word_filter_apply(sprintf(gettext("Your password reset request from %s"), $forum_name), $to_user['UID'], true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $to_user['UID'], true);

    $change_pw_link = rawurlencode("/change_pw.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");

    $change_pw_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$change_pw_link");

    $message_body = wordwrap(sprintf(
        gettext("Hello %s,\r\n\r\nYou requested this e-mail from %s because you have forgotten your password.\r\n\r\nClick the link below (or copy and paste it into your browser) to reset your password:\r\n\r\n%s"),
        $recipient,
        $forum_name,
        $change_pw_link
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_new_pw_notification($tuid, $fuid, $new_password)
{
    if (!is_numeric($tuid)) return false;

    if (!is_numeric($fuid)) return false;

    if (!is_string($new_password)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($from_user = user_get($fuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("Password change notification from %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $passwd_changed_by = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);

    $message_body = wordwrap(sprintf(
        gettext("Hello %s,\r\n\r\nThis a notification email to inform you that your password on %s has been changed.\r\n\r\nIt has been changed to: %s and was changed by: %s.\r\n\r\nIf you have received this email in error or were not expecting a change to your password please contact the forum owner or a moderator on %s immediately to correct it."),
        $recipient,
        $forum_name,
        $new_password,
        $passwd_changed_by,
        $forum_name
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_user_confirmation($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("Email confirmation required for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");

    $confirm_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$confirm_link");

    $message_body = wordwrap(sprintf(
        gettext("Hello %s,\r\n\r\nYou recently created a new user account on %s.\r\n\r\nBefore you can start posting we need to confirm your email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\r\n\r\n%s\r\n\r\nOnce confirmation is complete you may login and start posting immediately.\r\n\r\nIf you did not create a user account on %s please accept our apologies and forward this email to %s so that the source of it may be investigated."),
        $recipient,
        $forum_name,
        $confirm_link,
        $forum_name,
        $forum_email
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_changed_email_confirmation($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("Email confirmation required for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $confirm_link = rawurlencode("/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}");

    $confirm_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$confirm_link");

    $message_body = wordwrap(sprintf(
        gettext("Hello %s,\r\n\r\nYou recently changed your email on %s.\r\n\r\nBefore you can start posting again we need to confirm your new email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\r\n\r\n%s\r\n\r\nOnce confirmation is complete you may continue to use the forum as normal.\r\n\r\nIf you were not expecting this email from %s please accept our apologies and forward this email to %s so that the source of it may be investigated."),
        $recipient,
        $forum_name,
        $confirm_link,
        $forum_name,
        $forum_email
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_user_approval_notification($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("New User Approval Notification for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $admin_users_link = rawurlencode("/admin_users.php?webtag=$webtag&filter=4");

    $admin_users_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_users_link");

    $message_body = wordwrap(sprintf(gettext(
        "Hello %s,\r\n\r\nA new user account has been created on %s.\r\n\r\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\r\n\r\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\" or click the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."),
        $recipient,
        $forum_name,
        $admin_users_link
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_new_user_notification($tuid, $new_user_uid)
{
    if (!is_numeric($tuid)) return false;

    if (!is_numeric($new_user_uid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("New User Account Notification for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $admin_user_link = rawurlencode("/admin_user.php?webtag=$webtag&uid=$new_user_uid");

    $admin_user_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_user_link");

    $message_body = wordwrap(sprintf(gettext(
        "Hello %s,\r\n\r\nA new user account has been created on %s.\r\n\r\nTo view this user account please visit the Admin Users section and click on the new user or click the link below:\r\n\r\n%s"),
        $recipient,
        $forum_name,
        $admin_user_link
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_user_approved_notification($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_email = forum_get_setting('forum_email', null, 'admin@beehiveforum.co.uk');

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("User approval notification for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $forum_link = html_get_forum_uri("index.php?webtag=$webtag");

    $message_body = wordwrap(sprintf(gettext(
        "Hello %s,\r\n\r\nYour user account at %s has been approved. You can login and start posting immediately by clicking the link below:\r\n\r\n%s\r\n\r\nIf you were not expecting this email from %s please accept our apologies and forward this email to %s so that the source of it may be investigated."),
        $recipient,
        $forum_name,
        $forum_link,
        $forum_name,
        $forum_email
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_post_approval_notification($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("Post Approval Notification for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $admin_post_approval_link = rawurlencode("/admin_post_approve.php?webtag=$webtag");

    $admin_post_approval_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_post_approval_link");

    $message_body = wordwrap(sprintf(
        gettext("Hello %s,\r\n\r\nA new post has been created on %s.\r\n\r\nAs you are a Moderator on this forum you are required to approve this post before it can be read by other users.\r\n\r\nYou can approve this post and any others pending approval by visiting the Admin Post Approval section of your forum or by clicking the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."),
        $recipient,
        $forum_name,
        $admin_post_approval_link
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_link_approval_notification($tuid)
{
    if (!is_numeric($tuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $subject = word_filter_apply(sprintf(gettext("Link Approval Notification for %s"), $forum_name), $tuid, true);

    $recipient = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $admin_post_approval_link = rawurlencode("/admin_link_approve.php?webtag=$webtag");

    $admin_post_approval_link = html_get_forum_uri("index.php?webtag=$webtag&final_uri=$admin_post_approval_link");

    $message_body = wordwrap(sprintf(gettext(
        "Hello %s,\r\n\r\nA new link has been created on %s.\r\n\r\nAs you are a Link Moderator on this forum you are required to approve this link before it can be read by other users.\r\n\r\nYou can approve this link and any others pending approval by visiting the Admin Link Approval section of your forum or by clicking the link below:\r\n\r\n%s\r\n\r\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n\r\nNote: Other Administrators on this forum will also receive this notification and may have already acted upon this request."),
        $recipient,
        $forum_name,
        $admin_post_approval_link
    ));

    $message->setTo($to_user['EMAIL'], $recipient);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
}

function email_send_message_to_user($tuid, $fuid, $subject, $message_body, $use_email_addr)
{
    if (!is_numeric($tuid)) return false;

    if (!is_numeric($fuid)) return false;

    if (!($to_user = user_get($tuid))) return false;

    if (!($from_user = user_get($fuid))) return false;

    if (!($transport = Swift_TransportFactory::get())) return false;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_MessageBeehive::newInstance();

    if (!email_address_valid($to_user['EMAIL'])) return false;

    $forum_name = word_filter_apply(forum_get_setting('forum_name', null, 'A Beehive Forum'), $tuid, true);

    $recipient  = word_filter_apply(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), $tuid, true);

    $sent_from  = word_filter_apply(format_user_name($from_user['LOGON'], $from_user['NICKNAME']), $tuid, true);

    $message_body = word_filter_apply($message_body, $tuid, true);

    $message_body.= "\r\n\r\n". wordwrap(sprintf(gettext("This message was sent from %s by %s"), $forum_name, $sent_from));

    $message->setTo($to_user['EMAIL'], $recipient);

    if ($use_email_addr) $message->setFrom($from_user['EMAIL'], $sent_from);

    $message->setSubject($subject);

    $message->setBody($message_body);

    return $mailer->send($message);
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

    return ($user_count == 0);
}

?>