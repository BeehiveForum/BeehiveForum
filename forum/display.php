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
require_once BH_INCLUDE_PATH. 'adsense.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
// End Required includes

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

} else if (isset($_GET['print_msg']) && validate_msg($_GET['print_msg'])) {

    $msg = $_GET['print_msg'];
    list($tid, $pid) = explode('.', $msg);

} else {

    html_draw_error(gettext("Invalid Message ID or no Message ID specified."));
}

if (!$folder_data = thread_get_folder($tid)) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

$perm_folder_moderate = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID']);

if (!$thread_data = thread_get($tid, $perm_folder_moderate, false, $perm_folder_moderate)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (!$message = messages_get($tid, $pid, 1)) {
    html_draw_error(gettext("That post does not exist in this thread!"));
}

html_draw_top("title={$thread_data['TITLE']}", "js/post.js", "basetarget=_blank", 'class=window_title');

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = session::show_sigs();

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_data['TITLE'], $thread_data['TITLE'], $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'), true), "</td>\n";
echo "    <td align=\"right\">", messages_social_links($tid), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

if ($message) {

    $first_msg = $message['PID'];

    $message['CONTENT'] = message_get_content($tid, $message['PID']);

    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" width=\"2%\" valign=\"top\">&nbsp;</td>\n";
    echo "    <td align=\"center\">\n";

    if ($thread_data['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, $show_sigs, true);

        } else {

            message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, true, $show_sigs, true);
        }

    } else {

        message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, false, $show_sigs, true);
    }

    echo "    </td>\n";
    echo "    <td width=\"2%\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    if (adsense_check_user() && adsense_check_page($message['PID'], 1, $thread_data['LENGTH'])) {

        adsense_output_html();
        echo "<br />\n";
    }
}

echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <a href=\"messages.php?webtag=$webtag&amp;msg=$tid.$pid\" target=\"_self\" class=\"button\"><span>", gettext("Back"), "</span></a>\n";
echo "      ", form_button("print", gettext("Print")), "\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>