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

/* $Id: email.inc.php,v 1.72 2004-10-20 12:51:09 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");

function email_sendnotification($tuid, $msg, $fuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!validate_msg($msg)) return false;
    if (!is_numeric($fuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user_prefs = user_get_prefs($tuid)) {

        $to_user   = user_get($tuid);
        $from_user = user_get($fuid);

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        if ($to_user_prefs['EMAIL_NOTIFY'] == 'Y') {

            list($tid, $pid) = explode('.', $msg);

            $thread = thread_get($tid);

             // get the right language for the email
            $lang = email_get_language($tuid);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['msgnotification_subject']} $forum_name";

            $message = format_user_name($from_user['LOGON'], $from_user['NICKNAME']);
            $message.= " {$lang['msgnotificationemail_1']}". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
            $message.= "{$lang['msgnotificationemail_2']}". _htmlentities_decode(_stripslashes($thread['TITLE'])). "\n\n";
            $message.= "{$lang['msgnotificationemail_3']}";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/?webtag=$webtag&msg=$msg\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['msgnotificationemail_4']}";
            $message.= "{$lang['msgnotificationemail_5']}";
            $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/\n";
            $message.= "{$lang['msgnotificationemail_6']}";
            $message.= "{$lang['msgnotificationemail_7']}";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion();

            if (isset($to_user['NICKNAME']) && strlen(trim($to_user['NICKNAME'])) > 0 && !server_os_mswin()) {
                $recipient = "\"{$to_user['NICKNAME']}\" <{$to_user['EMAIL']}>";
            }else {
                $recipient = $to_user['EMAIL'];
            }

            mail($recipient, $subject, $message, $header);
        }
    }

    return true;
}

function email_sendsubscription($tuid, $msg, $fuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!validate_msg($msg)) return false;
    if (!is_numeric($fuid)) return false;

    $db_email_sendsubscription = db_connect();

    list($tid, $pid) = explode('.', $msg);

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();
    $webtag = get_webtag($webtag_search);

    $sql = "SELECT USER.UID, USER.NICKNAME, USER.EMAIL FROM USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.UID = USER.UID) WHERE USER_THREAD.TID = $tid ";
    $sql.= "AND USER_THREAD.INTEREST = 2 AND USER.UID NOT IN ($fuid, $tuid)";

    $result = db_query($sql, $db_email_sendsubscription);

    while ($to_user = db_fetch_array($result)) {

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        $from_user = user_get($fuid);
        $thread = thread_get($tid);

        // get the right language for the email
        $lang = email_get_language($tuid);

        $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
        $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

        $subject = "{$lang['subnotification_subject']} $forum_name";

        $message = format_user_name($from_user['LOGON'], $from_user['NICKNAME']);
        $message.= " {$lang['subnotification_1']}". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
        $message.= "{$lang['subnotification_2']}". _htmlentities_decode(_stripslashes($thread['TITLE'])). "\n\n";
        $message.= "{$lang['subnotification_3']}";
        $message.= "http://{$_SERVER['HTTP_HOST']}";

        if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
            $message.= dirname($_SERVER['PHP_SELF']);
        }

        $message.= "/?webtag=$webtag&msg=$msg\n\n";
        $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
        $message.= "{$lang['subnotification_4']}";
        $message.= "{$lang['subnotification_5']}";
        $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/?msg=$msg,\n";
        $message.= "{$lang['subnotification_6']}";

        $header = "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
        $header.= "X-Mailer: PHP/". phpversion();

        if (isset($to_user['NICKNAME']) && strlen(trim($to_user['NICKNAME'])) > 0 && !server_os_mswin()) {
            $recipient = "\"{$to_user['NICKNAME']}\" <{$to_user['EMAIL']}>";
        }else {
            $recipient = $to_user['EMAIL'];
        }

        mail($recipient, $subject, $message, $header);
    }

    return true;
}

function email_send_pm_notification($tuid, $mid, $fuid)
{
    if (!check_mail_variables()) return false;

    if (!is_numeric($tuid)) return false;
    if (!is_numeric($mid)) return false;
    if (!is_numeric($fuid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();
    $webtag = get_webtag($webtag_search);

    if ($to_user_prefs = user_get_prefs($tuid)) {

        $to_user   = user_get($tuid);
        $from_user = user_get($fuid);

        // Validate the email address before we continue.

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $to_user['EMAIL'])) return false;

        if ($to_user_prefs['PM_NOTIFY_EMAIL'] == 'Y') {

            if (!$pm_subject = pm_get_subject($mid, $tuid)) return false;

             // get the right language for the email
            $lang = email_get_language($tuid);

            $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
            $forum_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');

            $subject = "{$lang['pmnotification_subject']} $forum_name";

            $message = format_user_name($from_user['LOGON'], $from_user['NICKNAME']);
            $message.= " {$lang['pmnotification_1']}". forum_get_setting('forum_name', false, 'A Beehive Forum'). "\n\n";
            $message.= "{$lang['pmnotification_2']}". _htmlentities_decode(_stripslashes($pm_subject)). "\n\n";
            $message.= "{$lang['pmnotification_3']}";
            $message.= "http://{$_SERVER['HTTP_HOST']}";

            if (isset($_SERVER['PHP_SELF']) && dirname($_SERVER['PHP_SELF']) != '/') {
                $message.= dirname($_SERVER['PHP_SELF']);
            }

            $message.= "/?webtag=$webtag&pmid=$mid\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['pmnotification_4']}";
            $message.= "{$lang['pmnotification_5']}";
            $message.= "http://{$_SERVER['HTTP_HOST']}". dirname($_SERVER['PHP_SELF']). "/\n";
            $message.= "{$lang['pmnotification_6']}";
            $message.= "{$lang['pmnotification_7']}";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion();

            if (isset($to_user['NICKNAME']) && strlen(trim($to_user['NICKNAME'])) > 0 && !server_os_mswin()) {
                $recipient = "\"{$to_user['NICKNAME']}\" <{$to_user['EMAIL']}>";
            }else {
                $recipient = $to_user['EMAIL'];
            }

            mail($recipient, $subject, $message, $header);
        }
    }

    return true;
}

// Sends a password reminder email. Returns true on success, false on fail.

function email_send_pw_reminder($logon)
{
    if (!check_mail_variables()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();
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

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion();

            if (isset($to_user['NICKNAME']) && strlen(trim($to_user['NICKNAME'])) > 0 && !server_os_mswin()) {
                $recipient = "\"{$to_user['NICKNAME']}\" <{$to_user['EMAIL']}>";
            }else {
                $recipient = $to_user['EMAIL'];
            }

            return mail($recipient, $subject, $message);
        }
    }

    return false;
}

// fetches the correct language file for the UID ($to_uid) who the email is being sent to

function email_get_language($to_uid)
{
    $forum_settings = get_forum_settings();

     // if the user has expressed a preference for language, use it
     // if available otherwise use the default language.

    if ($user_prefs = user_get_prefs($to_uid)) {

        if (file_exists("./include/languages/{$user_prefs['LANGUAGE']}.inc.php")) {
             require("./include/languages/{$user_prefs['LANGUAGE']}.inc.php");
             return $lang;
        }
    }

    $default_language = forum_get_setting('default_language', false, 'en');

    require("./include/languages/{$default_language}.inc.php");
    return $lang;
}

function server_os_mswin()
{
    if (defined('PHP_OS')) {
        if (stristr(PHP_OS, 'WIN') && !stristr(PHP_OS, 'DARWIN')) {
            return true;
        }
    }

    return false;
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