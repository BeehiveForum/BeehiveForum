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

// Required includes
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'logon.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Don't cache this page
cache_disable();

// Error messages string
$error_msg_array = array();

// Check for logon post data
if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

    if (logon_perform()) {

        header_redirect("lthread_list.php?webtag=$webtag", gettext("You logged in successfully."));

    } else {

        $error_msg_array[] = gettext("The username or password you supplied is not valid.");
    }
}

light_html_draw_top();

light_draw_logon_form($error_msg_array);

light_html_draw_bottom();