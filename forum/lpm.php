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
require_once 'lboot.php';


// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Check that PM system is enabled
light_pm_enabled();

// Prune old messages for the current user
pm_user_prune_folders($_SESSION['UID']);

light_html_draw_top();

light_draw_pm_inbox();

light_html_draw_bottom();

?>