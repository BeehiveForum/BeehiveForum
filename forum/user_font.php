<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check for message ID
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '1.1';
}

// Load the user prefs
$user_prefs = user_get_prefs($_SESSION['UID']);

// Get the fontsize parameter
$fontsize = isset($_GET['fontsize']) ? $_GET['fontsize'] : null;

// Calculate the new font size.
switch ($fontsize) {

    case 'smaller':

        $user_prefs = array(
            'FONT_SIZE' => $user_prefs['FONT_SIZE'] - 1
        );

        break;

    case 'larger':

        $user_prefs = array(
            'FONT_SIZE' => $user_prefs['FONT_SIZE'] + 1
        );

        break;

    default:

        $user_prefs = array(
            'FONT_SIZE' => $user_prefs['FONT_SIZE']
        );

        break;
}

// Check the font size is not lower than 5
if ($user_prefs['FONT_SIZE'] < 5) $user_prefs['FONT_SIZE'] = 5;

// Check the font size is not greater than 15
if ($user_prefs['FONT_SIZE'] > 15) $user_prefs['FONT_SIZE'] = 15;

// Update the user prefs.
if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {
    html_draw_error(gettext("Your user preferences could not be updated. Please try again later."));
}

// Redirect back to the messages.
header_redirect("messages.php?webtag=$webtag&msg=$msg&font_resize=1");

?>