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

/* $Id: forum_links.inc.php,v 1.2 2004-08-17 20:13:49 tribalonline Exp $ */

include_once("./include/lang.inc.php");

function forum_links_get_links()
{
	$table_data = get_table_prefix();

	$db_forum_draw_friends_dropdown = db_connect();

	$sql = "SELECT * FROM {$table_data['PREFIX']}FORUM_LINKS ORDER BY POS ASC, LID ASC";

	$result = db_query($sql, $db_forum_draw_friends_dropdown);

	if (db_num_rows($result) > 0) {
		while ($row = db_fetch_array($result)) {
			$links[] = array("URI" => $row['URI'], "TITLE" => $row['TITLE'], "LID" => $row['LID']);
		}
		return $links;
	}
	return false;
}

function forum_links_draw_dropdown()
{
	$html = "";
	$links = forum_links_get_links();
	if (count($links) > 1) {
		$html = "<select name=\"forum_links\" onChange=\"openForumLink(this)\">\n";
		for ($i=0; $i<count($links); $i++) {
			$html .= "<option value=\"".$links[$i]['URI']."\">".$links[$i]['TITLE']."</option>\n";
		}
		$html.= "</select>\n";
	}
	return $html; 
}

function forum_links_delete($lid)
{
	$table_data = get_table_prefix();

	$db_forum_links_delete = db_connect();

	$sql = "DELETE from {$table_data['PREFIX']}FORUM_LINKS WHERE LID = '$lid'";

	return db_query($sql, $db_forum_links_delete);
}

function forum_links_update($lid, $pos, $title, $uri = "")
{
	$table_data = get_table_prefix();

	$db_forum_links_update = db_connect();

	$sql = "UPDATE {$table_data['PREFIX']}FORUM_LINKS ";
	$sql.= "SET POS = '$pos', TITLE = '$title', URI = '$uri' ";
	$sql.= "WHERE LID = '$lid'";

	return db_query($sql, $db_forum_links_update);
}

function forum_links_add($pos, $title, $uri = "")
{
	$table_data = get_table_prefix();

	$db_forum_links_add = db_connect();

	$sql = "INSERT INTO {$table_data['PREFIX']}FORUM_LINKS ";
	$sql.= "(pos, title, uri) VALUES ('$pos', '$title', '$uri')";

	return db_query($sql, $db_forum_links_add);
}

?>