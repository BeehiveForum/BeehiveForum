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



// Frameset for thread list and messages



//Check logged in status

require_once("./include/session.inc.php");

require_once("./include/header.inc.php");



if(!bh_session_check()){



    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];

    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);

    $uri.= "/logon.php?final_uri=";

    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);

    

    header_redirect($uri);

}



require_once("./include/perm.inc.php");

require_once("./include/html.inc.php");

require_once("./include/constants.inc.php");



if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){

    html_draw_top();

    echo "<h1>Access Denied</h1>\n";

    echo "<p>You do not have permission to use this section.</p>";

    html_draw_bottom();

    exit;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-frameset.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

		<link rel="stylesheet" href="styles.php?<?php echo md5(uniqid(rand())); ?>" type="text/css">

	</head>

	<body>

        <h1>Forum Admin</h1>

        <p>Use the menu on the left to manage things in your forum</p>

        <p><b>Users</b> allows you to set user permissions, including appointing Editors and gagging people</p>

        <p>Use <b>Folders</b> to add new folders or change the names of existing ones</p>

    </body>

</html>

