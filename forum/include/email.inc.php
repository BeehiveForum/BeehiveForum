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

/* $Id: email.inc.php,v 1.34 2003-09-02 10:32:30 decoyduck Exp $ */

require_once("./include/db.inc.php"); // Database functions
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/config.inc.php"); // Formatting functions
require_once("./include/constants.inc.php");
require_once("./include/user.inc.php");

function email_sendnotification($tuid, $msg, $fuid)
{
    if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP') || !(bool)ini_get('sendmail_path')) return false;

    global $HTTP_SERVER_VARS, $forum_name, $forum_email;

    $db_email_sendnotification = db_connect();

    $sql = "SELECT PREFS.EMAIL_NOTIFY, PROFILE.NICKNAME, PROFILE.EMAIL FROM ";
    $sql.= forum_table("USER_PREFS") . " PREFS, ";
    $sql.= forum_table("USER") . " PROFILE ";
    $sql.= "WHERE PROFILE.UID = $tuid ";
    $sql.= "AND PROFILE.UID = PREFS.UID";

    $result = db_query($sql, $db_email_sendnotification);

    if (db_num_rows($result)) {

        $mailto = db_fetch_array($result);

        if ($mailto['EMAIL_NOTIFY'] == 'Y' && $mailto['EMAIL'] != '') {

            $sql = "SELECT LOGON, NICKNAME FROM ". forum_table("USER") . " WHERE UID = $fuid";
            $resultfrom = db_query($sql, $db_email_sendnotification);
            $mailfrom = db_fetch_array($resultfrom);

            list($tid, $pid) = explode('.', $msg);
            $thread = thread_get($tid);

             // get the right language for the email
            $lang = email_get_language($tuid);

            $message = format_user_name($mailfrom['LOGON'], $mailfrom['NICKNAME']);
            $message.= " {$lang['msgnotificationemail_1']} $forum_name\n\n";
            $message.= "{$lang['msgnotificationemail_2']}:  ". _htmlentities_decode(_stripslashes($thread['TITLE'])). "\n\n";
            $message.= "{$lang['msgnotificationemail_3']}:\n";
            $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

            if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
              $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
            }

            $message.= "/?msg=$msg\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['msgnotificationemail_4']}\n";
            $message.= "{$lang['msgnotificationemail_5']} http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/, {$lang['msgnotificationemail_6']}\n";
            $message.= "{$lang['msgnotificationemail_7']}\n";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";

            if (isset($mailto['NICKNAME']) && trim($mailto['NICKNAME']) != "") {
                $recipient = "\"{$mailto['NICKNAME']}\" <{$mailto['EMAIL']}>";
            }else {
                $recipient = $mailto['EMAIL'];
            }

            mail($recipient, "{$lang['msgnotification_subject']} $forum_name", $message, $header);

        }
    }

    return true;

}

function email_sendsubscription($tuid, $msg, $fuid)
{
    if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP') || !(bool)ini_get('sendmail_path')) return false;

    global $HTTP_SERVER_VARS, $forum_name, $forum_email;

    $db_email_sendsubscription = db_connect();

    list($tid, $pid) = explode('.', $msg);

    $sql = "SELECT USER.UID, USER.NICKNAME, USER.EMAIL FROM ";
    $sql.= forum_table("USER_THREAD") . " USER_THREAD, ";
    $sql.= forum_table("USER") . " USER ";
    $sql.= "WHERE USER_THREAD.TID = $tid ";
    $sql.= "AND USER_THREAD.INTEREST = 2 ";
    $sql.= "AND USER.UID = USER_THREAD.UID ";
    $sql.= "AND USER.UID <> $fuid AND USER.UID <> $tuid";

    $result = db_query($sql, $db_email_sendsubscription);
    $numRows = db_num_rows($result);

    for($i = 0; $i < $numRows; $i++) {

        $mailto = db_fetch_array($result);

        $sql = "SELECT LOGON, NICKNAME FROM ". forum_table("USER") . " WHERE UID = $fuid";
        $resultfrom = db_query($sql, $db_email_sendsubscription);
        $mailfrom = db_fetch_array($resultfrom);
        $thread = thread_get($tid);

        // get the right language for the email
        $lang = email_get_language($tuid);

        $message = format_user_name($mailfrom['LOGON'], $mailfrom['NICKNAME']);
        $message.= " {$lang['subnotification_1']}\n";
        $message.= "{$lang['subnotification_2']} $forum_name\n\n";
        $message.= "{$lang['subnotification_3']}:  ". _htmlentities_decode(_stripslashes($thread['TITLE'])). "\n\n";
        $message.= "{$lang['subnotification_4']}:\n";
        $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

        if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
          $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
        }

        $message.= "/?msg=$msg\n\n";
        $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
        $message.= "{$lang['subnotification_5']}\n";
        $message.= "{$lang['subnotification_6']} http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/?msg=$msg,\n";
        $message.= "{$lang['subnotification_7']}\n";

        $header = "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";

        if (isset($mailto['NICKNAME']) && trim($mailto['NICKNAME']) != "") {
            $recipient = "\"{$mailto['NICKNAME']}\" <{$mailto['EMAIL']}>";
        }else {
            $recipient = $mailto['EMAIL'];
        }

        mail($recipient, "{$lang['subnotification_subject']} $forum_name", $message, $header);

    }

    return true;

}

function email_send_pm_notification($tuid, $mid, $fuid)
{
    if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP') || !(bool)ini_get('sendmail_path')) return false;

    global $HTTP_SERVER_VARS, $forum_name, $forum_email, $lang;

    $db_email_sendnotification = db_connect();

    $sql = "SELECT PREFS.PM_NOTIFY_EMAIL, PROFILE.NICKNAME, PROFILE.EMAIL FROM ";
    $sql.= forum_table("USER_PREFS") . " PREFS, ". forum_table("USER") . " PROFILE ";
    $sql.= "WHERE PROFILE.UID = $tuid AND PROFILE.UID = PREFS.UID";

    $result = db_query($sql, $db_email_sendnotification);

    if (db_num_rows($result)) {

        $mailto = db_fetch_array($result);

        if ($mailto['PM_NOTIFY_EMAIL'] == 'Y' && $mailto['EMAIL'] != '') {

            $sql = "SELECT LOGON, NICKNAME FROM ". forum_table("USER") . " WHERE UID = $fuid";
            $resultfrom = db_query($sql, $db_email_sendnotification);
            $mailfrom = db_fetch_array($resultfrom);

            $pm_message = pm_single_get($mid, PM_FOLDER_INBOX, $tuid);

             // get the right language for the email
            $lang = email_get_language($tuid);

            $message = format_user_name($mailfrom['LOGON'], $mailfrom['NICKNAME']);
            $message.= " {$lang['pmnotification_1']} $forum_name\n\n";
            $message.= "{$lang['pmnotification_2']}:  ". _htmlentities_decode(_stripslashes($pm_message['SUBJECT'])). "\n\n";
            $message.= "{$lang['pmnotification_3']}:\n";
            $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

            if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
              $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
            }

            $message.= "/?pmid=$mid\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "{$lang['pmnotification_4']}\n";
            $message.= "{$lang['pmnotification_5']} http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/, {$lang['pmnotification_6']}\n";
            $message.= "{$lang['pmnotification_7']}\n";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";

            if (isset($mailto['NICKNAME']) && trim($mailto['NICKNAME']) != "") {
                $recipient = "\"{$mailto['NICKNAME']}\" <{$mailto['EMAIL']}>";
            }else {
                $recipient = $mailto['EMAIL'];
            }

            mail($recipient, "{$lang['pmnotification_subject']} $forum_name", $message, $header);

        }
    }

    return true;

}

// Sends a password reminder email. Returns true on success, false on fail.

function email_send_pw_reminder($logon)
{
    if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP') || !(bool)ini_get('sendmail_path')) return false;

    global $HTTP_SERVER_VARS, $forum_name, $forum_email;

    $db_email_send_pw_reminder = db_connect();
    $logon = addslashes($logon);

    $sql = "SELECT UID, PASSWD, EMAIL FROM ". forum_table("USER") ." WHERE LOGON '$logon'";
    $result = db_query($sql, $db_email_send_pw_reminder);

    if (db_num_rows($result)) {

        $mailto = db_fetch_array($result);

	if (isset($mailto['UID']) && isset($mailto['EMAIL']) && isset($mailto['PASSWD'])) {

            // get the right language for the email
            $lang = email_get_language($tuid);

	    $message = "{$lang['forgotpwemail_1']} $forum_name {$lang['forgotpwemail_2']}\n\n";
            $message.= "{$lang['forgotpwemail_3']}:\n\n";
            $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

            if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
                $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
            }

            $message.= "/change_pw.php?u={$mailto['UID']}&h={$mailto['PASSWD']}";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "Content-type: text/plain; charset={$lang['_charset']}\n";
            $header.= "X-Mailer: PHP/". phpversion();

            if (isset($mailto['NICKNAME']) && trim($mailto['NICKNAME']) != "") {
                $recipient = "\"{$mailto['NICKNAME']}\" <{$mailto['EMAIL']}>";
            }else {
                $recipient = $mailto['EMAIL'];
            }

            if (mail($recipient, "{$lang['passwdresetrequest']} - $forum_name", $msg, $header)) return true;
	}
    }

    return false;
}

// fetches the correct language file for the UID ($to_uid) who the email is being sent to

function email_get_language($to_uid)
{
    global $default_language;

    $prefs = user_get_prefs($to_uid);

     // if the user has expressed a preference for language, use it
     // if available otherwise use the default language.

    if (isset($prefs['LANGUAGE']) && trim($prefs['LANGUAGE']) != "") {
        if (file_exists("./include/languages/{$prefs['LANGUAGE']}.inc.php")) {
             require("./include/languages/{$prefs['LANGUAGE']}.inc.php");
             return $lang;
        }else {
             require("./include/languages/{$default_language}.inc.php");
             return $lang;
        }
    }else {
         require("./include/languages/{$default_language}.inc.php");
         return $lang;
    }
}

?>