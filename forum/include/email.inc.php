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

function email_sendnotification($tuid, $msg, $fuid, $tid = 0)
{

    // This function sends the email notification.
    // There is no return value, like.

    $db = db_connect();

    $sql = "select LOGON from ". forum_table("USER") . " where UID = $fuid";
    $resultfrom = db_query($sql, $db);
    if(db_num_rows($resultfrom)){
        $mailfrom = db_fetch_array($resultfrom);
    } else {
        $mailfrom['LOGON'] = "Someone";
    }

    // E-mail the person replied to if they've specified that in their preferences
    // Fetch the Receipient's notification status, nickname and email address

    $sql = "select PREFS.EMAIL_NOTIFY, PROFILE.NICKNAME, PROFILE.EMAIL from ";
    $sql.= forum_table("USER_PREFS") . " PREFS, ";
    $sql.= forum_table("USER") . " PROFILE ";
    $sql.= "where PROFILE.UID = $tuid ";
    $sql.= "and PROFILE.UID = PREFS.UID";

    $result = db_query($sql, $db);

    if(db_num_rows($result)){

        $mailto = db_fetch_array($result);

    	// Check the Receipient's notification status and email address.

    	if ($mailto['EMAIL_NOTIFY'] == 'Y' && $mailto['EMAIL'] != ''){

            // Hold recipients UID to exclude from Subscriber mailing later
            $xuid = $tuid;

        	// Construct the notification body and headers. These are half-inched from Delphi's
       		// own notifications. Will need amendments later on to use the Forum's name rather
       		// than 'Beehiveforum'.

       		$message = strtoupper($mailfrom['LOGON']). " posted a message to you on Beehive Forum\n\n";
       		$message.= "To read that message and others in the same discussion, go to:\n";
       		$message.= "http://beehiveforum.sourceforge.net/forum/?msg=$msg\n\n";
       		$message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
       		$message.= "Note: If you do not wish to receive email notifications of Forum messages\n";
       		$message.= "posted to you, go to http://beehiveforum.sourceforge.net/forum/, click\n";
       		$message.= "on Preferences, unselect the Email Notification checkbox and press Submit.\n";

       		$header = "From: \"Beehive Forums\" <webmaster@beehiveforums.com>\n";
       		$header.= "Reply-To: \"Beehive Forums\" <webmaster@beehiveforums.com>\n";
       		$header.= "X-Mailer: PHP/". phpversion();

       		// Construct a well formatted Recepient (doesn't work on PHP Win32)

       		$recepient = $mailto['NICKNAME']. ' <'. $mailto['EMAIL']. '>';

       		// Send the email

       		@mail($mailto['EMAIL'], "Message Notification from Beehive Forums", $message, $header);
    	}
    }

    // Email people who've subscribed to the thread

    $tid = strtok($msg,".");

    $sql = "select USER.UID, USER.NICKNAME, USER.EMAIL from ";
    $sql.= forum_table("USER_THREAD") . " USER_THREAD, ";
    $sql.= forum_table("USER") . " USER ";
    $sql.= "where USER_THREAD.TID = $tid ";
    $sql.= "and USER_THREAD.INTEREST = 2 ";
    $sql.= "and USER.UID = USER_THREAD.UID";

    $result = db_query($sql, $db);

    for($i=0;$i<db_num_rows($result);$i++){

        $mailto = db_fetch_array($result);

        // Don't send to person who posted message, or person already mailed.
        if($mailto['UID'] != $fuid && $mailto['UID'] != $xuid){
        	// Construct the notification body and headers. These are half-inched from Delphi's
       		// own notifications. Will need amendments later on to use the Forum's name rather
       		// than 'Beehiveforum'.

       		$message = strtoupper($mailfrom['LOGON']). " posted a message in\n";
       		$message.= "a thread you have subscribed to on Beehive Forum\n\n";
       		$message.= "To read that message and others in the same discussion, go to:\n";
       		$message.= "http://beehiveforum.sourceforge.net/forum/?msg=$msg\n\n";
       		$message.= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
       		$message.= "Note: If you do not wish to receive email notifications of new messages\n";
       		$message.= "in this thread, go to http://beehiveforum.sourceforge.net/forum/?msg=$msg,\n";
       		$message.= "and adjust your Interest level at the end of the page.\n";

       		$header = "From: \"Beehive Forums\" <webmaster@beehiveforums.com>\n";
       		$header.= "Reply-To: \"Beehive Forums\" <webmaster@beehiveforums.com>\n";
       		$header.= "X-Mailer: PHP/". phpversion();

       		// Construct a well formatted Recepient (doesn't work on PHP Win32)

       		$recepient = $mailto['NICKNAME']. ' <'. $mailto['EMAIL']. '>';

       		// Send the email

       		@mail($mailto['EMAIL'], "Message Notification from Beehive Forums", $message, $header);
        }
    }

    db_disconnect($db);
}

?>
