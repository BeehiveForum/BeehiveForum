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

/* $Id: upgrade-08x-to-084.php,v 1.3 2008-07-27 18:26:19 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == 'upgrade-08x-to-083.php') {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

@set_time_limit(0);

$forum_webtag_array = array();

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

$sql = "SHOW TABLES LIKE 'FORUMS'";

if (!$result = @db_query($sql, $db_install)) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "SELECT FID, WEBTAG FROM FORUMS";

    if ($result = @db_query($sql, $db_install)) {

        while ($forum_data = @db_fetch_array($result)) {

            $forum_webtag_array[$forum_data['FID']] = $forum_data['WEBTAG'];
        }

    }else {

        $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // Removed unused entries from Admin Log.

    $sql = "DELETE FROM {$forum_webtag}_ADMIN_LOG WHERE ACTION IN (6, 61, 68, 69)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Better support for deleted threads.

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD DELETED CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Update existing deleted threads

    $sql = "UPDATE {$forum_webtag}_THREAD SET DELETED = 'Y' WHERE LENGTH = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Reset the lengths on the deleted threads.

    $sql = "INSERT INTO {$forum_webtag}_THREAD (TID, LENGTH) ";
    $sql.= "SELECT THREAD.TID, MAX(POST.PID) FROM {$forum_webtag}_THREAD THREAD ";
    $sql.= "LEFT JOIN {$forum_webtag}_POST POST ON (POST.TID = THREAD.TID) ";
    $sql.= "WHERE THREAD.LENGTH = 0 GROUP BY THREAD.TID ";
    $sql.= "ON DUPLICATE KEY UPDATE LENGTH = VALUES(LENGTH)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Delete any remaining 0 length threads from the THREADS table so they
    // don't appear in the thread list.

    $sql = "DELETE FROM {$forum_webtag}_THREAD WHERE LENGTH = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Add field for reply_quick

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Sort out the THREAD MODIFIED columns being wrong due to a bug in 0.8 and 0.8.1.

    $sql = "INSERT INTO {$forum_webtag}_THREAD (TID, FID, BY_UID, TITLE, LENGTH, ";
    $sql.= "POLL_FLAG, CREATED, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
    $sql.= "SELECT THREAD.TID, THREAD.FID, THREAD.BY_UID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, THREAD.CREATED, MAX(POST.CREATED), THREAD.CLOSED, THREAD.STICKY, ";
    $sql.= "THREAD.STICKY_UNTIL, THREAD.ADMIN_LOCK FROM {$forum_webtag}_THREAD THREAD ";
    $sql.= "LEFT JOIN {$forum_webtag}_POST POST ON (POST.TID = THREAD.TID) GROUP BY THREAD.TID ";
    $sql.= "ON DUPLICATE KEY UPDATE MODIFIED = VALUES(MODIFIED)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Check for and fix a bug involving forum owner where Guests
// can be granted access to admin section of a forum.

$sql = "DELETE FROM GROUP_USERS WHERE UID = 0";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// We got this far, that means we can now update the global forum tables.

// Add field for reply_quick

$sql = "ALTER TABLE USER_PREFS ADD REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Remove the index on SVALUE before we convert it to TEXT

$sql = "ALTER TABLE FORUM_SETTINGS DROP INDEX SVALUE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Convert the SVALUE column to TEXT. This allows it to become big enough
// to hold things like the forum rules message.

$sql = "ALTER TABLE FORUM_SETTINGS CHANGE SVALUE SVALUE TEXT NOT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

?>