<?php

/*======================================================================
Copyright Chris Hodcroft <chris@hodcroft.net>, 
Ben Sekulowicz <me@beseku.com> 2002

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

// THREAD LIST DISPLAY

// NOTE: The way this works at the moment, it's insecure. Anyone could see
// anyone else's unread messages etc. by changing the UID in the query string.

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/threads.inc.php"); // Thread processing functions

// Check that required variables are set
// default to display all discussions if no other mode specified
if (!isset($HTTP_GET_VARS['mode'])) { $mode = 0; } else { $mode = $HTTP_GET_VARS['mode']; }

// default to UID 0 (nobody) if no other UID is specified
if (!isset($HTTP_GET_VARS['user'])) { $user = 0; } else { $user = $HTTP_GET_VARS['user']; }

// Output XHTML header
html_draw_top();

// Drop out of PHP to start the HTML table
?>
<table width="100%" border="0" cellpadding=\0" cellspacing="0">
	<tr>
		<td class="thread_list_mode">
			<?
			// Calls the desired mode, whilst retaining the current UID
			echo "<form method=\"GET\" action=\"".$HTTP_SERVER_VARS['PHP_SELF']."\">";
			echo "<input type=\"hidden\" name=\"user\" value=\"$user\">";
			echo "<select name=\"mode\" class=\"thread_list_form\">\n";
			
			echo "<option ";
			if ($mode == 0) echo "selected ";
			echo "value=\"0\">All discussions</option>\n";
			
			echo "<option ";
			if ($mode == 1) echo "selected ";
			echo "value=\"1\">Unread discussions</option>\n";
			?>
			</select><input type="submit" value="Go!" class="thread_list_form" />
			</form>
		</td>
	</tr>
<?php

// The tricky bit - displaying the right threads for whatever mode is selected

switch ($mode) {
	case 0: // All discussions
		list($threads, $folder_order) = threads_get_all($user); // Get list of discussions & folder order
		break;
	case 1; // Unread discussions
		list($threads, $folder_order) = threads_get_unread($user); // Get list of discussions & folder order
		break;
}

// The actual bit that displaus the threads...
threads_display_list($threads, $folder_order);

?>