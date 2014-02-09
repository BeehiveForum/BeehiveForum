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
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
// End Required includes

// Message pane caching
cache_check_messages();

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

} else if (($msg = messages_get_most_recent($_SESSION['UID'])) === false) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("No Messages"));
    light_html_draw_bottom();
    exit;
}

list($tid, $pid) = explode('.', $msg);

if (isset($_POST['poll_submit'])) {

    if (isset($_POST['poll_vote']) && is_array($_POST['poll_vote'])) {

        $poll_votes = $_POST['poll_vote'];

        if (poll_check_tabular_votes($tid, $poll_votes)) {

            poll_vote($tid, $poll_votes);

            header_redirect("lmessages.php?webtag=$webtag&msg=$msg");

        } else {

            light_html_draw_top(sprintf("title=%s", gettext("Error")));
            light_html_display_error_msg(gettext("You must vote in every group."));
            light_html_draw_bottom();
            exit;
        }

    } else {

        light_html_draw_top(sprintf("title=%s", gettext("Error")));
        light_html_display_error_msg(gettext("You must select an option to vote for!"));
        light_html_draw_bottom();
        exit;
    }

} else if (isset($_POST['poll_change_vote'])) {

    poll_delete_vote($tid);

    header_redirect("lmessages.php?webtag=$webtag&msg=$msg");
}

light_html_draw_top("js/messages.js");

light_draw_messages($tid, $pid);

light_html_draw_bottom();