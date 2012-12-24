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

// Get the start page
if (($start_page = forum_get_setting('start_page', 'strlen', false)) !== false) {

    // Get the start page CSS
    if (($start_page_css = forum_get_setting('start_page_css', 'strlen', false)) !== false) {

        // Check for cached page.
        cache_check_etag(md5($start_page. $start_page_css));

        html_draw_top("inline_css=$start_page_css");
        echo message_apply_formatting($start_page);
        html_draw_bottom();

    } else {

        // Check for cached page.
        cache_check_etag(md5($start_page));

        html_draw_top();
        echo message_apply_formatting($start_page);
        html_draw_bottom();
    }

} else {

    html_draw_top();
    echo "<h1>", gettext("You can edit this page from the admin interface"), "</h1>\n";
    html_draw_bottom();
}

?>