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

function email_sendnotification($tuid, $msg, $fuid)
{

    // This function sends the email notification.
    // There is no return value, like.

    $db = db_connect();

    // Lets fetch the Receipient's notification status, nickname and email address

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

    	    // Retrieve the Sender's LOGON details. (Can this be done another way, session details perhaps?)

    	    $sql = "select LOGON from ". forum_table("USER") . " where UID = $fuid";
                $resultfrom = db_query($sql, $db);

    	    if(db_num_rows($resultfrom)){

    	        $mailfrom = db_fetch_array($resultfrom);

        		// Construct the notification body. Half-inched from Delphi's own notifications.
        		// Will need amendments later on to use the Forum's name rather than 'Beehiveforum'.

        		$message = $mailfrom['LOGON'] . ' posted a message to you on Beehive Forum\n\n';
        		$message.= 'To read that message and others in the same discussion, go to:\n';
        		$message.= 'http://beehive.sourceforge.net/forum/messages.php?msg=' . $msg;

        		// Send teh email, with a few additional headers for From, Reply-To and X-Mailer headers

        		mail('"'. $mailto['NICKNAME']. '" <' . $mailto['EMAIL'] . '>', 'Message Notification from Beehive Forum', $message, 'From: "Beehive Forums" <webmaster@beehiveforums.com>\nReply-To: "Beehive Forums" <webmaster@beehiveforums.com>\nX-Mailer: PHP/' . phpversion()) or die ('could not send mail notification');
    	    }
    	}
    }
}

?>
