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
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'user_rel.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Start output here
html_draw_top(
    array(
        'title' => gettext('My Controls - User Relationships'),
        'base_target' => '_blank',
        'class' => 'window_title',
        'js' => array(
            'js/prefs.js',
        )
    )
);

echo "<h1>", gettext("User Relationships"), "</h1>\n";

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 1;
}

if (isset($_POST['search_keyword']) && strlen(trim($_POST['search_keyword'])) > 0) {

    $page = 1;

    $search_keyword = trim($_POST['search_keyword']);

} else if (isset($_GET['search_keyword']) && strlen(trim($_GET['search_keyword'])) > 0) {

    $search_keyword = trim($_GET['search_keyword']);

} else {

    $search_keyword = '';
}

if (isset($_POST['clear_search'])) {
    $search_keyword = '';
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_relationships']) && is_array($_POST['delete_relationships'])) {

        foreach ($_POST['delete_relationships'] as $peer_uid => $delete_relationship) {

            if (($delete_relationship == "Y")) {

                if (!user_rel_update($_SESSION['UID'], $peer_uid, 0)) {

                    $valid = false;
                    $error_msg_array[] = gettext("Failed to remove selected relationship");
                }
            }
        }

        if ($valid) {

            $redirect = "edit_relations.php?webtag=$webtag&relupdated=true";
            header_redirect($redirect, gettext("Relationships Updated!"));
            exit;
        }
    }
}

// Check if we're searching for a user or simply listing the existing relationships.
if (isset($search_keyword) && strlen(trim($search_keyword)) > 0) {
    $user_peers_array = user_search_relationships($search_keyword, $page, $_SESSION['UID']);
} else {
    $user_peers_array = user_get_relationships($_SESSION['UID'], $page);
}

// Output any messages.
if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'left');

} else if (isset($_GET['relupdated'])) {

    html_display_success_msg(gettext("Relationships Updated!"), '700', 'left');

} else if (sizeof($user_peers_array['user_array']) < 1) {

    if (isset($search_keyword) && strlen(trim($search_keyword)) > 0) {

        html_display_warning_msg(gettext("Search Returned No Results"), '700', 'left');

    } else {

        html_display_warning_msg(gettext("You have no user relationships set up. Add a new user by searching below."), '700', 'left');
    }
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_relations.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
echo "  ", form_input_hidden("search_keyword", htmlentities_array($search_keyword)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"200\">", gettext("User"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">", gettext("Relationship"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">", gettext("Signature"), "</td>\n";
echo "                  <td align=\"center\" class=\"subhead\">", gettext("Personal Messages"), "</td>\n";
echo "                </tr>\n";

if (sizeof($user_peers_array['user_array']) > 0) {

    foreach ($user_peers_array['user_array'] as $user_peer) {

        echo "                <tr>\n";
        echo "                  <td align=\"center\">", form_checkbox("delete_relationships[{$user_peer['UID']}]", "Y"), "</td>\n";
        echo "                  <td align=\"left\">&nbsp;<a href=\"user_rel.php?webtag=$webtag&amp;uid={$user_peer['UID']}&amp;ret=edit_relations.php%3Fwebtag%3D$webtag\" target=\"_self\">", word_filter_add_ob_tags(format_user_name($user_peer['LOGON'], $user_peer['PEER_NICKNAME']), true), "</a></td>\n";

        if ($user_peer['RELATIONSHIP'] & USER_FRIEND) {

            echo "                  <td align=\"center\">", html_style_image('friend', gettext("Friend")), "</td>\n";

        } else if ($user_peer['RELATIONSHIP'] & USER_IGNORED) {

            echo "                  <td align=\"center\">", html_style_image('enemy', gettext("Ignored")), "</td>\n";

        } else if ($user_peer['RELATIONSHIP'] & USER_IGNORED_COMPLETELY) {

            echo "                  <td align=\"center\">", html_style_image('enemy', gettext("Ignored Completely")), "", html_style_image('enemy', gettext("Ignored Completely")), "</td>\n";

        } else {

            echo "                  <td align=\"center\">", gettext("Normal"), "</td>\n";
        }

        if ($user_peer['RELATIONSHIP'] & USER_IGNORED_SIG) {

            echo "                  <td align=\"center\">", html_style_image('enemy', gettext("Ignored")), "</td>\n";

        } else {

            echo "                  <td align=\"center\">", html_style_image('friend', gettext("Display")), "</td>\n";
        }

        if ($user_peer['RELATIONSHIP'] & USER_BLOCK_PM) {

            echo "                  <td align=\"center\">", html_style_image('enemy', gettext("Block")), "</td>\n";

        } else {

            echo "                  <td align=\"center\">", html_style_image('friend', gettext("Allow")), "</td>\n";
        }

        echo "                </tr>\n";
    }
}

echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (sizeof($user_peers_array['user_array']) > 0) {

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">";

    html_page_links("edit_relations.php?webtag=$webtag&search_keyword=$search_keyword", $page, $user_peers_array['user_count'], 10, "page");

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("delete", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";
echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">", gettext("Search"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">", gettext("Username"), ": ", form_input_text('search_keyword', htmlentities_array($search_keyword), 30, 64), " ", form_submit('search', gettext("Search")), " ", form_submit('clear_search', gettext("Clear")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();