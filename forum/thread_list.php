<?php

//Thread List - Written by Benjamin Sekulowicz
//Intended for use within Project Beehive free forum project.

//IMPORTANT - As I have no idea how the login will work, $user (The user integer ID field MUST be passed to this document so that the mark as read malarkey works.

include "includes/inc_connect.php";
include "includes/inc_draw.php";
include "includes/inc_gets.php";

//Draw top of HTML Document - XHTML 1 Header
draw_top();
//Call function to connect to MySQL Database.
connect();

get_folders();
$num_folders = sizeof($folder_titles);

echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
?>

<tr>
	<td class="thread_list_thread">
		<h1>Show discussions...</h1>
	</td>
</tr>
<tr>
	<td class="thread_list_aim">
		<?
		//Calls the desired aim, whilst retaining the current user id.
		echo "<form method=\"post\" action=\"thread_list.php?user=$user\">\n";
		echo "<select name=\"aim\" class=\"thread_list_form\">\n";
		echo "<option value=\"0\">All discussions</option>\n";
		// ensures the current method remains in the drop down box-me-do.
		echo "<option ";
		if ($aim == 1) echo " selected ";
		echo "value=\"1\">Unread discussions</option>\n";
		?>
			</select><input type="submit" value="Go!" class="thread_list_form"/>
		</form>
	</td>
</tr>

<?

// Aim = 0 - Set the page to display all discussions present.
if ($aim == 0) {
	for ($x = 1; $x <= $num_folders; $x++) {
		//Display the folders from the Array collected earlier.
		echo "<tr>";
		echo "<td class=\"thread_list_folder\">";
		echo "<h1>";
		echo "<img src=\"elements/folder.gif\" alt=\"folder\" /> ";
		echo $folder_titles[$x];

		//Get the thread details form the MySQL Database
		get_threads_all($x);
		echo " - [";
		echo $row;
		echo "]";
		echo "</h1>";
		echo "</td>";
		echo "</tr>\n";

		for  ($i =0; $i < $row; $i++) {
			echo "<tr><td class=\"thread_list_thread\">";
			echo "<h2>";
			echo "<img src=\"elements/bullet.gif\" alt=\"bullet\"/> ";
			echo $thread_titles[$i];
			echo " ";
			//Check if the thread is a poll.
			if ($is_poll[$i] == 1) echo " [P] ";
			//Display the total length of the thread.
			echo " [";
			echo $thread_length[$i];
			echo " msgs]";
			echo "</h2>";
			echo "</td></tr>\n";
		}
		echo "<tr><td><h2>&nbsp;</h2></td></tr>\n";
	}


// Aim = 1 - Set the page to display all discussions unread by user.
} else if ($aim == 1) {

	for ($x = 1; $x <= $num_folders; $x++) {
		//Display the folders from the Array collected earlier.
		echo "<tr>";
		echo "<td class=\"thread_list_folder\">";
		echo "<h1>";
		echo "<img src=\"elements/folder.gif\" alt=\"folder\" /> ";
		echo $folder_titles[$x];

		//Get the thread details form the MySQL Database
		get_threads_all($x);
		echo " - [";
		echo $row;
		echo "]";
		echo "</h1>";
		echo "</td>";
		echo "</tr>\n";

		for  ($i =0; $i < $row; $i++) {
			// Checks the User_Thread table for the current Thread ID - When a thread has been partially viewed:
			//If method of validation changes, a way of passing the User integer ID field to this function MUST be created.
			get_threads_check($user, $tid[$i]);

			//Variable seen relates to number of rows returned from Query. Last read is the prgress made in the thread.
			if (($seen == 1) && ($last_read < $thread_length[$i])) {
				echo "<tr><td class=\"thread_list_thread\">";
				echo "<h2>";
				echo "<img src=\"elements/bullet.gif\" alt=\"bullet\"/> ";
				echo $thread_titles[$i];
				echo " ";
				//Check if the thread is a poll.
				if ($is_poll[$i] == 1) echo " [P] ";
				//Display the number of unread messages by minusing the number read from the thread length:
				$new_messages = $thread_length[$i] - $last_read;
				echo " [";
				echo $new_messages;
				echo " new of ";
				echo $thread_length[$i];
				echo "]";
				echo "</h2>";
				echo "</td></tr>\n";

			// Checks the User_Thread table for the current Thread ID - When a Thread has not yet been viewed:
			} else if ($seen == 0) {
				echo "<tr><td class=\"thread_list_thread\">";
				echo "<h2>";
				echo "<img src=\"elements/bullet.gif\" alt=\"bullet\"/> ";
				echo $thread_titles[$i];
				echo " ";
				//Check if the thread is a poll.
				if ($is_poll[$i] == 1) echo " [P] ";
				//Display the total length of the thread.
				echo " [";
				echo $thread_length[$i];
				echo " new]";
				echo "</h2>";
				echo "</td></tr>\n";
			}
		}
		echo "<tr><td><h2>&nbsp;</h2></td></tr>\n";
	}
	echo "<tr><td class=\"thread_list_folder\"><h2>Unread discussions for user $user.</h2></td></tr>\n";
}

echo "</table/>\n";

//Draw bottom of HTML Document - XHTML 1 Header
draw_bottom();

?>