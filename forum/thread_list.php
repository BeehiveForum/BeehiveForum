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

// THREAD LIST DISPLAY

// NOTE: The way this works at the moment, it's insecure. Anyone could see
// anyone else's unread messages etc. by changing the UID in the query string.

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/threads.inc.php"); // Thread processing functions
require_once("./include/format.inc.php"); // Formatting functions

// Check that required variables are set
// default to display all discussions if no other mode specified
if (!isset($HTTP_GET_VARS['mode'])) { $mode = 0; } else { $mode = $HTTP_GET_VARS['mode']; }

// default to UID 0 (nobody) if no other UID is specified
if (!isset($HTTP_COOKIE_VARS['bh_sess_uid'])) { $user = 0; } else { $user = $HTTP_COOKIE_VARS['bh_sess_uid']; }

// Output XHTML header
html_draw_top();

// Drop out of PHP to start the HTML table
?>

<script language="JavaScript">
// Func to change the little icon next to each discussion title
function change_current_thread (thread_id) {
	if (current_thread > 0){
		document["t" + current_thread].src = "./images/bullet.png";
		document["t" + thread_id].src = "./images/ct.png";
	}
	current_thread = thread_id;
}
// -->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?
			// Calls the desired mode
			echo "<form method=\"GET\" action=\"".$HTTP_SERVER_VARS['PHP_SELF']."\">";
			echo "<select name=\"mode\" class=\"thread_list_mode\" onChange=\"submit();\">\n";
			
			echo "<option ";
			if ($mode == 0) echo "selected ";
			echo "value=\"0\">All discussions</option>\n";
			
			echo "<option ";
			if ($mode == 1) echo "selected ";
			echo "value=\"1\">Unread discussions</option>\n";
			?>
			</select><input type="submit" value="Go!" class="thread_list_mode" />
			</form>
		</td>
	</tr>
<?php

// The tricky bit - displaying the right threads for whatever mode is selected

switch ($mode) {
	case 0: // All discussions
		list($thread_info, $folder_order) = threads_get_all($user); // Get list of discussions & folder order
		break;
	case 1; // Unread discussions
		list($thread_info, $folder_order) = threads_get_unread($user); // Get list of discussions & folder order
		break;
}

// Now, the actual bit that displays the threads...

// Get folder FIDs and titles
$folder_info = threads_get_folders();
if (!$folder_info) die ("Could not retrieve folder information");

// Get total number of messages for each folder
$folder_msgs = threads_get_folder_msgs();

// Check to see if $folder_order is an array, and define it as one if not
if (!is_array($folder_order)) $folder_order = array();

// Work out if any folders have no messages - if so, they still need to be displayed, so add them to $folder_order
while (list($fid, $title) = each($folder_info)) {
	if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
}

// Iterate through the information we've just got and display it in the right order
while (list($key1, $folder) = each($folder_order)) {
	echo "<tr>\n";
	echo "<td class=\"foldername\">\n";
	echo "<img src=\"./images/folder.png\" alt=\"folder\" />\n";
	echo "<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&folder=".$folder."\">".$folder_info[$folder]."</a>";
	echo "</td>\n";
	echo "</tr>\n";
	if (is_array($thread_info)) {	
		echo "<tr>\n";
		echo "<td class=\"threads\" style=\"border-bottom: 0;\">\n";
		echo "<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&folder=".$folder."\" class=\"folderinfo\">".$folder_msgs[$folder]." msgs</a>\n";
		echo "<a href=\"post.php?fid=".$folder."\" target=\"main\" class=\"folderpostnew\">Post New</a>\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"threads\" style=\"border-top: 0;\">";
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		while (list($key2, $thread) = each($thread_info)) {
			if ($thread['fid'] == $folder) {
				// work out the number of new posts and format something in square brackets accordingly
				/*if ($thread['length'] == $thread['last_read']) {
					$number = "[".$thread['length']."]";
					$latest_post = 1;
				} elseif ($thread['last_read'] == 0) {
					$number = "[".$thread['length']." new]";
					$latest_post = 1;
				} else {
					$new_posts = $thread['length'] - $thread['last_read'];
					$number = "[".$new_posts." new of ".$thread['length']."]";
					$latest_post = $thread['last_read'] + 1;
				}*/

				echo "<tr><td valign=\"top\" align=\"middle\" nowrap=\"nowrap\">";

				if ($thread['last_read'] < $thread['length']) {
					$new_posts = $thread['length'] - $thread['last_read'];
					$number = "[".$new_posts." new of ".$thread['length']."]";
					$latest_post = $thread['last_read'] + 1;

					if(!isset($first_thread)){
						$first_thread = $thread['tid'];
						echo "<img src=\"./images/ct.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\" />";
					} else {
						echo "<img src=\"./images/star.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\" />";
					}

				} else if ($thread['last_read'] == 0) {
					$number = "[".$thread['length']." new]";
					$latest_post = 1;

					if(!isset($first_thread)){
						$first_thread = $thread['tid'];
						echo "<img src=\"./images/ct.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\"  />";
					} else {
						echo "<img src=\"./images/star.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\" />";
					}

				} else {
					$number = "[".$thread['length']."]";
					$latest_post = 1;

					if(!isset($first_thread)){
						$first_thread = $thread['tid'];
						echo "<img src=\"./images/ct.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\" />";
					} else {
						echo "<img src=\"./images/bullet.png\" name=\"t".$thread['tid']."\" align=\"absmiddle\" />";
					}
				}
				// work out how long ago the thread was posted and format the time to display - this is going to need modification to account for differing timezones
				if (date("j", $thread['modified']) == date("j") && date("n", $thread['modified']) == date("n") && date("Y", $thread['modified']) == date("Y")) {
					$thread_time = date("H:i", $thread['modified']);
				} else {
					$thread_time = date("j M", $thread['modified']);
				}

				echo "&nbsp;</td><td valign\"top\">";
				echo "<a href=\"messages.php?msg=".$thread['tid'].".".$latest_post."\" target=\"right\" class=\"threadname\" onClick=\"change_current_thread('".$thread['tid']."');\" onmouseOver=\"status='#".$thread['tid']." Started by ".format_user_name($thread['authorlogon'], $thread['authornick'])."';return true\" onmouseOut=\"window.status='';return true\">".$thread['title']."</a> <span class=\"threadxnewofy\">".$number."</span>";
				echo "</td><td valign=\"top\" nowrap=\"nowrap\">";
				echo "<span class=\"threadtime\">".$thread_time."&nbsp;</span>";
				echo "</td></tr>\n";


				/*echo "<p>\n";
				echo "<a href=\"messages.php?msg=".$thread['tid'].".".$latest_post."\" target=\"right\" class=\"threadname\">".$thread['title']."</a><br />";
				echo "<span class=\"threadtime\">".$thread_time."</span><span class=\"threadxnewofy\">$number</span>\n";
				echo "</p>\n";*/
			}
		}
		echo "</table>\n";
		
	}else{
		echo "<tr>\n";
		echo "<td class=\"threads\">\n";
		echo "<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&folder=".$folder."\" class=\"folderinfo\">".$folder_msgs[$folder]." msgs</a>\n";
		echo "<a href=\"post.php?fid=".$folder."\" target=\"main\" class=\"folderpostnew\">Post New</a>\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"threads\" style=\"border-top: 0;\">";
	}
	echo "</td></tr>\n";
	if (is_array($thread_info)) reset($thread_info);
}

echo "</table>\n";
echo "<script language=\"JavaScript\">\n";
echo "<!--\n";
if(isset($first_thread)){
	echo "current_thread = ".$first_thread.";\n";
} else {
	echo "current_thread = 0;\n";
}
echo "// -->";
echo "</script>\n";

html_draw_bottom();

?>





