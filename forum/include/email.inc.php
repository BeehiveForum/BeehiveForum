<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: email.inc.php,v 1.99 2006-09-13 22:47:15 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

function email_sendnotification($tuid, $fuid, $tid, $pid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user_prefs = user_get_prefs($tuid)) {

        $to_user   = user_get($tuid);
        $from_user = user_get($fuid);

        $user_rel  = user_rel_get($to_user, $from_user);
        if ($user_rel & USER_IGNORED_COMPLETELY) return true;

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        if (isset($to_user_prefs['EMAIL_NOTIFY']) && $to_user_prefs['EMAIL_NOTIFY'] == 'Y') {

            if (!$thread = thread_get($tid)) return false;

             // get the right language for the email
            $lang = email_get_language($tuid);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['msgnotification_subject']} $forum_name";

            $message = apply_wordfilter(format_user_name($from_user['LOGON'], $from_user['NICKNAME']));
            $message.= " {$lang['msgnotificationemail_1']} ". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
            $message.= "{$lang['msgnotificationemail_2']} ". _htmlentities_decode($thread['TITLE']). "\n\n";
            $message.= "{$lang['msgnotificationemail_3']}\n";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/?webtag=$webtag&msg=$tid.$pid\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['msgnotificationemail_4']}\n";
            $message.= "{$lang['msgnotificationemail_5']} ";
            $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/\n";
            $message.= "{$lang['msgnotificationemail_6']}\n";
            $message.= "{$lang['msgnotificationemail_7']}";

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion();

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

function email_sendsubscription($tuid, $fuid, $tid, $pid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    $db_email_sendsubscription = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    $sql = "SELECT USER_THREAD.UID, USER.NICKNAME, USER.EMAIL ";
    $sql.= "FROM {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = USER_THREAD.UID) ";
    $sql.= "WHERE USER_THREAD.TID = $tid AND USER_THREAD.INTEREST = 2 ";
    $sql.= "AND USER_THREAD.UID NOT IN ($fuid, $tuid)";

    $result = db_query($sql, $db_email_sendsubscription);

    if (db_num_rows($result) > 0) {

        while ($to_user = db_fetch_array($result)) {

            $from_user = user_get($fuid);

            $user_rel  = user_rel_get($to_user, $from_user);
            if ($user_rel & USER_IGNORED_COMPLETELY) return true;

            // Validate the email address before we continue.

            if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

            if (!$thread = thread_get($tid)) return false;

            // get the right language for the email
            $lang = email_get_language($tuid);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['subnotification_subject']} $forum_name";

            $message = apply_wordfilter(format_user_name($from_user['LOGON'], $from_user['NICKNAME']));
            $message.= " {$lang['subnotification_1']} ". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
            $message.= "{$lang['subnotification_2']} ". _htmlentities_decode($thread['TITLE']). "\n\n";
            $message.= "{$lang['subnotification_3']}\n";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/?webtag=$webtag&msg=$tid.$pid\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['subnotification_4']}\n";
            $message.= "{$lang['subnotification_5']} ";
            $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/?msg=$tid.$pid,\n";
            $message.= "{$lang['subnotification_6']}";

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion();

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

function email_send_pm_notification($tuid, $mid, $fuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($mid)) return false;
    if (!is_numeric($fuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user_prefs = user_get_prefs($tuid)) {

        $to_user   = user_get($tuid);
        $from_user = user_get($fuid);

        $user_rel  = user_rel_get($to_user, $from_user);
        if ($user_rel & USER_IGNORED_COMPLETELY) return true;

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        if (isset($to_user_prefs['EMAIL_NOTIFY']) && $to_user_prefs['PM_NOTIFY_EMAIL'] == 'Y') {

            if (!$pm_subject = pm_get_subject($mid, $tuid)) return false;

             // get the right language for the email
            $lang = email_get_language($tuid);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['pmnotification_subject']} $forum_name";

            $message = apply_wordfilter(format_user_name($from_user['LOGON'], $from_user['NICKNAME']));
            $message.= " {$lang['pmnotification_1']} ". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
            $message.= "{$lang['pmnotification_2']} ". _htmlentities_decode($pm_subject). "\n\n";
            $message.= "{$lang['pmnotification_3']}\n";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/?webtag=$webtag&pmid=$mid\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['pmnotification_4']}\n";
            $message.= "{$lang['pmnotification_5']} ";
            $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/\n";
            $message.= "{$lang['pmnotification_6']}\n";
            $message.= "{$lang['pmnotification_7']}";

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion();

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

// Sends a password reminder email. Returns true on success, false on fail.

function email_send_pw_reminder($logon)
{
    if (!check_mail_variables()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user = user_get_uid($logon)) {

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        if (isset($to_user['UID']) && isset($to_user['EMAIL']) && isset($to_user['PASSWD'])) {

            // get the right language for the email
            $lang = email_get_language($to_user['UID']);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['passwdresetrequest']} - $forum_name";

            $message = "{$lang['forgotpwemail_1']} $forum_name {$lang['forgotpwemail_2']}\n\n";
            $message.= "{$lang['forgotpwemail_3']}:\n\n";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/change_pw.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}";

            $header = "Return-path: $forum_email\n";
            $header.= "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset=UTF-8\n";
            $header.= "X-Mailer: PHP/". phpversion();

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

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user = user_get($tuid)) {

        $from_user = user_get($fuid);

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        // get the right language for the email
        $lang = email_get_language($to_user['UID']);

        $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        $subject = "{$lang['passwdchangenotification']} $forum_name";

        $message = "{$lang['pwchangeemail_1']} $forum_name {$lang['pwchangeemail_2']}\n\n";
        $message.= "{$lang['pwchangeemail_3']} $new_password {$lang['pwchangeemail_4']} {$from_user['LOGON']}\n\n";
        $message.= "{$lang['pwchangeemail_5']}\n";
        $message.= "{$lang['pwchangeemail_6']} $forum_name\n";
        $message.= "{$lang['pwchangeemail_7']}";

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion();

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

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user = user_get($tuid)) {

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        // get the right language for the email
        $lang = email_get_language($to_user['UID']);

        $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        $subject = "{$lang['emailconfirmationrequired']} $forum_name";

        $message = "{$lang['confirmemail_1']} {$to_user['NICKNAME']},\n\n";
        $message.= "{$lang['confirmemail_2']} $forum_name.\n";
        $message.= "{$lang['confirmemail_3']}\n";
        $message.= "{$lang['confirmemail_4']}\n";
        $message.= "{$lang['confirmemail_5']}\n\n";

        $message.= "http://{$_SERVER['HTTP_HOST']}";

        if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
            $message.= dirname($_SERVER['PHP_SELF']);
        }

        $message.= "/confirm_email.php?webtag=$webtag&u={$to_user['UID']}&h={$to_user['PASSWD']}\n\n";
        $message.= "{$lang['confirmemail_6']}\n\n";
        $message.= "{$lang['confirmemail_7']} $forum_name\n";
        $message.= "{$lang['confirmemail_8']} $forum_email\n";
        $message.= "{$lang['confirmemail_9']}";

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion();

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

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = forum_get_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user = user_get($tuid)) {

        $from_user = user_get($fuid);

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        // get the right language for the email
        $lang = email_get_language($to_user['UID']);

        $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        $sent_from = apply_wordfilter(format_user_name($from_user['LOGON'], $from_user['NICKNAME']));
        $message.= sprintf("\n\n{$lang['msgsentfromby']}", $forum_name, $sent_from);

        $header = "Return-path: $forum_email\n";
        $header.= "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset=UTF-8\n";
        $header.= "X-Mailer: PHP/". phpversion();

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
    $forum_settings = forum_get_settings();

     // if the user has expressed a preference for language, use it
     // if available otherwise use the default language.

    if ($user_prefs = user_get_prefs($to_uid)) {

        if (isset($user_prefs['LANGUAGE']) && @file_exists("./include/languages/{$user_prefs['LANGUAGE']}.inc.php")) {

             require("./include/languages/{$user_prefs['LANGUAGE']}.inc.php");
             return $lang;
        }
    }

    $default_language = forum_get_setting('default_language', false, 'en');

    require("./include/languages/{$default_language}.inc.php");
    return $lang;
}

function email_is_unique($email_address)
{
    $db_email_is_unique = db_connect();

    $email_address = addslashes($email_address);

    $sql = "SELECT UID FROM USER WHERE EMAIL = '$email_address' LIMIT 0, 1";
    $result = db_query($sql, $db_email_is_unique);

    return (db_num_rows($result) < 1);
}

function check_mail_variables()
{
    if (server_os_mswin()) {

        if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP')) return false;

    }else {

        if (!(bool)ini_get('sendmail_path')) return false;
    }

    return true;
}

?>