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

require_once("./include/db.inc.php"); // Database functions
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/config.inc.php"); // Formatting functions

function email_sendnotification($tuid, $msg, $fuid)
{

    if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP') || !(bool)ini_get('sendmail_path')) return false;

    global $HTTP_SERVER_VARS, $forum_name, $forum_email;

    $db_email_sendnotification = db_connect();

    $sql = "select PREFS.EMAIL_NOTIFY, PROFILE.NICKNAME, PROFILE.EMAIL from ";
    $sql.= forum_table("USER_PREFS") . " PREFS, ";
    $sql.= forum_table("USER") . " PROFILE ";
    $sql.= "where PROFILE.UID = $tuid ";
    $sql.= "and PROFILE.UID = PREFS.UID";

    $result = db_query($sql, $db_email_sendnotification);

    if (db_num_rows($result)) {

        $mailto = db_fetch_array($result);

        if ($mailto['EMAIL_NOTIFY'] == 'Y' && $mailto['EMAIL'] != '') {

            $sql = "select LOGON from ". forum_table("USER") . " where UID = $fuid";
            $resultfrom = db_query($sql, $db_email_sendnotification);
            $mailfrom = db_fetch_array($resultfrom);

            list($tid, $pid) = explode('.', $msg);
            $thread = thread_get($tid);

            $message = strtoupper($mailfrom['LOGON']). " posted a message to you on $forum_name\n\n";
            $message.= "The subject is:  ". _htmlspecialchars_reverse(_stripslashes($thread['TITLE'])). "\n\n";
            $message.= "To read that message and others in the same discussion, go to:\n";
            $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

            if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
              $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
            }

            $message.= "/?msg=$msg\n\n";
            $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
            $message.= "Note: If you do not wish to receive email notifications of Forum messages\n";
            $message.= "posted to you, go to http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/, click\n";
            $message.= "on Preferences, unselect the Email Notification checkbox and press Submit.\n";

            $header = "From: \"$forum_name\" <$forum_email>\n";
            $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
            $header.= "X-Mailer: PHP/". phpversion(). "\n";

            mail($mailto['EMAIL'], "Message Notification from $forum_name", $message, $header);

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

    $sql = "select USER.UID, USER.NICKNAME, USER.EMAIL from ";
    $sql.= forum_table("USER_THREAD") . " USER_THREAD, ";
    $sql.= forum_table("USER") . " USER ";
    $sql.= "where USER_THREAD.TID = $tid ";
    $sql.= "and USER_THREAD.INTEREST = 2 ";
    $sql.= "and USER.UID = USER_THREAD.UID ";
    $sql.= "and USER.UID <> $fuid and USER.UID <> $tuid";

    $result = db_query($sql, $db_email_sendsubscription);
    $numRows = db_num_rows($result);

    for($i = 0; $i < $numRows; $i++) {

        $mailto = db_fetch_array($result);

        $sql = "select LOGON from ". forum_table("USER") . " where UID = $fuid";
        $resultfrom = db_query($sql, $db_email_sendsubscription);
        $mailfrom = db_fetch_array($resultfrom);

        $thread = thread_get($tid);

        $message = strtoupper($mailfrom['LOGON']). " posted a message in a thread you\n";
        $message.= "have subscribed to on $forum_name\n\n";
        $message.= "The subject is:  ". _htmlspecialchars_reverse(_stripslashes($thread['TITLE'])). "\n\n";
        $message.= "To read that message and others in the same discussion, go to:\n";
        $message.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

        if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
          $message.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
        }

        $message.= "/?msg=$msg\n\n";
        $message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
        $message.= "Note: If you do not wish to receive email notifications of new messages\n";
        $message.= "in this thread, go to http://". $HTTP_SERVER_VARS['HTTP_HOST']. dirname($HTTP_SERVER_VARS['PHP_SELF']). "/?msg=$msg,\n";
        $message.= "and adjust your Interest level at the end of the page.\n";

        $header = "From: \"$forum_name\" <$forum_email>\n";
        $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
        $header.= "X-Mailer: PHP/". phpversion(). "\n";

        mail($mailto['EMAIL'], "Subscription Notification from $forum_name", $message, $header);

    }

    return true;

}

?>