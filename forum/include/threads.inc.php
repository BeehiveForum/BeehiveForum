<?php

/*======================================================================
Copyright Ben Sekulowicz <me@beseku.com> 2002

This file is part of Beehive.

Beehive is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Included functions for displaying threads in the left frameset.

include("db.inc.php");

function threads_get_folders()
{
	$db = db_connect();
	$query = "SELECT DISTINCT FID, TITLE FROM folder ORDER BY FID";
	$result = db_query($query, $db);

	if (!db_num_rows($result)) {
		 $row = 0;
	} else {
		while($query_data = db_fetch_array($result)) {
			$fid = $query_data['FID'];
			$folder_titles[$fid] = $query_data['TITLE'];
		}
	}
	
	return $folder_titles;
	db_disconnect($db);
}

function threads_get_all($fid)
{
	$db = db_connect();
	$query = "SELECT TID, FID, TITLE, LENGTH, POLL_FLAG FROM thread WHERE FID = '$fid'";
	$result = db_query($query, $db);

	if (!db_num_rows($result)) {
		 $row = 0;
	} else {
		 $row = 0;
		while($query_data = db_fetch_array($result)) {
			$tid[$row] = $query_data['TID'];
			$thread_titles[$row] = $query_data['TITLE'];
			$thread_length[$row] = $query_data['LENGTH'];
			$is_poll[$row] = $query_data['POLL_FLAG'];
			$row++;
		}
	}
	
	return array($tid, $thread_titles, $thread_length, $is_poll, $row);
	db_disconnect($db);
	
}

function threads_check_read($user, $check)
{
	$db = db_connect();

	$query = "SELECT DISTINCT UID, TID, LAST_READ FROM user_thread WHERE UID = '$user' AND TID = '$check'";
	$result = db_query($query, $db);

	if (!db_num_rows($result)) {
		$seen = 0;
		$last_read = 0;
	} else {
		$seen = 1;
		while($query_data = db_fetch_array($result)) {
			$last_read = $query_data['LAST_READ'];
		}
	}
	
	return array($seen, $last_read);
	db_disconnect($db);
}
	
?>