<?php

//Included functions for displaying threads in the left frameset.
//Written by Ben Sekulowicz-Barclay for Project beehive.

function get_folders()
{
	global $folder_titles;

	$query = "SELECT DISTINCT FID, TITLE FROM folder ORDER BY FID";
	$result = mysql_query($query);

	if (!mysql_num_rows($result)) {
		 $row = 0;
	} else {
		while($query_data = mysql_fetch_row($result)) {
			$fid = $query_data[0];
			$folder_titles[$fid] = $query_data[1];
		}
	}
}

function get_threads_all($fid)
{
	global $tid, $thread_titles, $thread_length, $is_poll, $row;

	$query = "SELECT TID, FID, TITLE, LENGTH, POLL_FLAG FROM thread WHERE FID = '$fid' ";
	$result = mysql_query($query);

	if (!mysql_num_rows($result)) {
		 $row = 0;
	} else {
		 $row = 0;
		while($query_data = mysql_fetch_row($result)) {
			$tid[$row] = $query_data[0];
			$thread_titles[$row] = $query_data[2];
			$thread_length[$row] = $query_data[3];
			$is_poll[$row] = $query_data[4];
			$row++;
		}
	}
}

function get_threads_check($user, $check)
{
	global $seen, $last_read;

	$query = "SELECT DISTINCT UID, TID, LAST_READ FROM user_thread WHERE UID = '$user' AND TID = '$check' ";
	$result = mysql_query($query);

	if (!mysql_num_rows($result)) {
		 $seen = 0;
		 $last_read = 0;
	} else {
		 $seen = 1;
		while($query_data = mysql_fetch_row($result)) {
			$last_read = $query_data[2];
		}
	}
}
?>

