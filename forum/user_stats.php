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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    if (isset($_GET['forum_stats_toggle']) && $_GET['forum_stats_toggle'] == "show") {
        $user_prefs['SHOW_STATS'] = "Y";
    } else {
        $user_prefs['SHOW_STATS'] = "N";
    }

    if (user_update_prefs($_SESSION['UID'], $user_prefs)) {

        header_redirect("messages.php?webtag=$webtag&msg=$msg&setstats=1");
        exit;

    } else {

        html_draw_error(gettext("Some or all of your user account details could not be updated. Please try again later."));
    }

} else {

    html_draw_error(gettext("Invalid Message ID or no Message ID specified."));
}