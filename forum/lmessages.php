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


// Message pane caching
cache_check_messages();

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($tid, $pid) = explode('.', $_GET['msg']);

} else if (($msg = messages_get_most_recent($_SESSION['UID'])) !== false) {

    list($tid, $pid) = explode('.', $msg);

} else {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("No Messages"));
    light_html_draw_bottom();
    exit;
}

// Poll stuff
if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        if (isset($_POST['pollvote']) && is_array($_POST['pollvote'])) {

            $poll_votes = $_POST['pollvote'];

            if (poll_check_tabular_votes($tid, $poll_votes)) {

                poll_vote($tid, $poll_votes);

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
    }

} else if (isset($_POST['pollchangevote'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        $pid = 1;

        poll_delete_vote($tid);
    }
}

light_html_draw_top();

light_draw_messages($tid, $pid);

light_html_draw_bottom();

?>