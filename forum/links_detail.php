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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'links.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check links section is enabled.
if (!forum_get_setting('show_links', 'Y')) {
    html_draw_error(gettext("You may not access this section."));
}

$error_msg_array = array();

$success_msg = null;

$title = null;

if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

    $lid = $_POST['lid'];

} else if (isset($_GET['lid']) && is_numeric($_GET['lid'])) {

    $lid = $_GET['lid'];

} else {

    html_draw_error(gettext("You must provide a link ID!"));
}

if (isset($_POST['parent_fid']) && is_numeric($_POST['parent_fid'])) {

    $parent_fid = $_POST['parent_fid'];

} else if (isset($_GET['parent_fid']) && is_numeric($_GET['parent_fid'])) {

    $parent_fid = $_GET['parent_fid'];

} else {

    $parent_fid = 1;
}

$creator_uid = links_get_creator_uid($lid);

$user_perm_links_moderate = session::check_perm(USER_PERM_LINKS_MODERATE, 0);

if (!$link = links_get_single($lid, !$user_perm_links_moderate)) {
    html_draw_error(gettext("Invalid link ID!"));
}

if (isset($_POST['cancel'])) {

    header_redirect("links.php?webtag=$webtag");
    exit;
}

if (session::logged_in()) {

    $valid = true;

    if (isset($_POST['addvote'])) {

        if (isset($_POST['vote']) && is_numeric($_POST['vote'])) {

            links_vote($lid, $_POST['vote'], $_SESSION['UID']);
            $success_msg = gettext("Your vote has been recorded");

        } else {

            $error_msg_array[] = gettext("You must choose a rating!");
            $valid = false;
        }

    } else if (isset($_POST['clearvote'])) {

        links_clear_vote($lid, $_SESSION['UID']);
        $success_msg = gettext("Your vote has been cleared");
    }

    if (isset($_POST['addcomment'])) {

        if (isset($_POST['comment']) && strlen(trim($_POST['comment'])) > 0) {

            $comment = trim($_POST['comment']);

            links_add_comment($lid, $_SESSION['UID'], $comment);
            $success_msg = gettext("Your comment was added.");

        } else {

            $error_msg_array[] = gettext("You must type a comment!");
            $valid = false;
        }
    }

    if (isset($_POST['update']) && ($user_perm_links_moderate || $creator_uid == $_SESSION['UID'])) {

        if (isset($_POST['delete']) && $_POST['delete'] == "confirm") {

            links_delete($lid);

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, 0) && ($link['UID'] != $_SESSION['UID'])) {
                admin_add_log_entry(DELETE_LINK, array($link['LID'], $link['TITLE'], $link['URI']));
            }

            header_redirect("links.php?webtag=$webtag&fid=$parent_fid");
            exit;

        } else {

            if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

                $fid = $_POST['fid'];

            } else {

                $error_msg_array[] = gettext("No Folder ID specified");
                $valid = false;
            }

            if (isset($_POST['uri']) && preg_match('/\b([a-z]+:\/\/([-\p{L}]{2,}\.)*[-\p{L}]{2,}(:\d+)?(([^\s;,.?"\'[\]() {}<>]|\S[^\s;,.?"\'[\]() {}<>])*)?)/iu', $_POST['uri'])) {

                $uri = $_POST['uri'];

            } else {

                $error_msg_array[] = gettext("That is not a valid URI!");
                $valid = false;
            }

            if (isset($_POST['title']) && strlen(trim($_POST['title'])) > 0) {

                $title = trim($_POST['title']);

            } else {

                $error_msg_array[] = gettext("You must specify a name!");
                $valid = false;
            }

            if (isset($_POST['description']) && strlen(trim($_POST['description'])) > 0) {
                $description = trim($_POST['description']);
            } else {
                $description = "";
            }

            if ($valid) {

                links_update($lid, $fid, $_SESSION['UID'], $title, $uri, $description);

                if (session::check_perm(USER_PERM_FOLDER_MODERATE, 0) && ($link['UID'] != $_SESSION['UID'])) {
                    admin_add_log_entry(DELETE_LINK, array($lid));
                }

                header_redirect("links_detail.php?webtag=$webtag&lid=$lid&fid=$fid");
            }
        }

        if ($user_perm_links_moderate || $link['UID'] == $_SESSION['UID']) {

            if (isset($_POST['hide']) && $_POST['hide'] == "confirm") {

                links_change_visibility($lid, false);

            } else if (!isset($_POST['hide']) || (isset($_POST['hide']) && $_POST['hide'] != "confirm")) {

                links_change_visibility($lid, true);
            }

            header_redirect("links_detail.php?webtag=$webtag&lid=$lid&fid=$fid");
        }
    }
}

if (isset($_GET['delete_comment']) && is_numeric($_GET['delete_comment'])) {

    $comment_id = $_GET['delete_comment'];
    $comment_uid = links_get_comment_uid($comment_id);

    if ($user_perm_links_moderate || $comment_uid == $_SESSION['UID']) {

        if (links_delete_comment($comment_id)) {

            $success_msg = gettext("Comment was deleted.");

        } else {

            $error_msg_array[] = gettext("Comment could not be deleted.");
            $valid = false;
        }
    }
}

$folders = links_folders_get(!$user_perm_links_moderate);

$page_title = links_get_folder_page_title($link['FID'], $folders, $link['TITLE']);

html_draw_top(
    array(
        'title' => $page_title,
        'class' => 'window_title'
    )
);

echo "<h1>", links_get_folder_path_links($link['FID'], $folders, true, true), html_style_image('separator'), "<a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">", word_filter_add_ob_tags($link['TITLE'], true), "</a></h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

} else if (isset($success_msg) && strlen($success_msg) > 0) {

    html_display_success_msg($success_msg, '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Link Details"), "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table class=\"posthead\" width=\"95%\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\" width=\"120\">", gettext("Address"), ":</td>\n";
echo "                      <td align=\"left\"><a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">", mb_strlen($link['URI']) > 35 ? htmlentities_array(mb_substr($link['URI'], 0, 35)) . '&hellip;' : htmlentities_array($link['URI']), "</a></td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Submitted by"), ":</td>\n";
echo "                      <td align=\"left\">", (isset($link['LOGON']) ? word_filter_add_ob_tags(format_user_name($link['LOGON'], $link['NICKNAME']), true) : gettext("Unknown user")), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Description"), ":</td>\n";
echo "                      <td align=\"left\">", word_filter_add_ob_tags($link['DESCRIPTION'], true), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Date"), ":</td>\n";
echo "                      <td align=\"left\">", format_date_time($link['CREATED']), "</td>\n";
echo "                    </tr>\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Clicks"), ":</td>\n";
echo "                      <td align=\"left\">{$link['CLICKS']}</td>\n";
echo "                    </tr>\n";

if (isset($link['RATING']) && is_numeric($link['RATING'])) {

    if ($link['VOTES'] == 1) {

        echo "                    <tr>\n";
        echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Rating"), ":</td>\n";
        echo "                      <td align=\"left\">", format_number($link['RATING'], 1), " (1 ", gettext("Vote"), ")</td>\n";
        echo "                    </tr>\n";

    } else {

        echo "                    <tr>\n";
        echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Rating"), ":</td>\n";
        echo "                      <td align=\"left\">", format_number($link['RATING'], 1), " ({$link['VOTES']} ", gettext("Votes"), ")</td>\n";
        echo "                    </tr>\n";
    }

} else {

    echo "                    <tr>\n";
    echo "                      <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Rating"), ":</td>\n";
    echo "                      <td align=\"left\">", gettext("Not rated by anyone yet"), "</td>\n";
    echo "                    </tr>\n";
}

echo "                    <tr>\n";
echo "                      <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

if (session::logged_in()) {

    $vote = links_get_vote($lid, $_SESSION['UID']);
    $vote = $vote ? $vote : -1;

    echo "<form accept-charset=\"utf-8\" name=\"link_vote\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("type", "vote"), "\n";
    echo "  ", form_input_hidden("lid", htmlentities_array($lid)), "\n";
    echo "  ", form_input_hidden("parent_fid", htmlentities_array($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Rate"), " ", word_filter_add_ob_tags($link['TITLE'], true), "</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", gettext("Bad"), "&nbsp;</td>\n";
    echo "                        <td align=\"center\" style=\"white-space: nowrap\">", form_radio_array("vote", range(0, 10), $vote), "&nbsp;</td>\n";
    echo "                        <td align=\"left\">", gettext("Good"), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('addvote', gettext("Vote!")), "&nbsp;", form_submit('clearvote', gettext("Clear Vote")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

if (($comments_array = links_get_comments($lid)) !== false) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    foreach ($comments_array as $comment_id => $comment) {

        $profile_link = "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$comment['UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        $profile_link .= word_filter_add_ob_tags(format_user_name($comment['LOGON'], $comment['NICKNAME']), true) . "</a>";

        if ($user_perm_links_moderate || $comment['UID'] == $_SESSION['UID']) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", sprintf(gettext("Comment by %s"), $profile_link), " <a href=\"links_detail.php?webtag=$webtag&amp;delete_comment={$comment['CID']}&amp;lid=$lid\" class=\"threadtime\">[", gettext("Delete"), "]</a></td>\n";
            echo "                </tr>\n";

        } else {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">", sprintf(gettext("Comment by %s"), $profile_link), "</td>\n";
            echo "                </tr>\n";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", word_filter_add_ob_tags($comment['COMMENT'], true), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
    }

    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

if (session::logged_in()) {

    echo "<form accept-charset=\"utf-8\" name=\"link_comment\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("type", "comment"), "\n";
    echo "  ", form_input_hidden("lid", htmlentities_array($lid)), "\n";
    echo "  ", form_input_hidden("parent_fid", htmlentities_array($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Add a comment about"), " ", word_filter_add_ob_tags($link['TITLE'], true), "</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_textarea("comment", null, 6, 74), "</td>\n";
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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('addcomment', gettext("Add Comment")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

if ($user_perm_links_moderate || $link['UID'] == $_SESSION['UID']) {

    echo "<form accept-charset=\"utf-8\" name=\"link_moderation\" action=\"links_detail.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("type", "moderation") . "\n";
    echo "  ", form_input_hidden("lid", htmlentities_array($lid)) . "\n";
    echo "  ", form_input_hidden("parent_fid", htmlentities_array($parent_fid)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Moderation Tools"), "</td>";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Move to"), ":</td>\n";
    echo "                        <td align=\"left\">", links_folder_dropdown($link['FID'], $folders), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Edit name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("title", htmlentities_array($link['TITLE']), 40, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Edit address"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("uri", htmlentities_array($link['URI']), 45, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Edit description"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("description", htmlentities_array($link['DESCRIPTION']), 60), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_checkbox("delete", "confirm", gettext("Delete")), "&nbsp;", form_checkbox("hide", "confirm", gettext("hide"), (isset($link['VISIBLE']) && $link['VISIBLE'] == 'N')), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('update', gettext("Save")), "&nbsp;", form_submit("cancel", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
}

echo "</div>\n";

html_draw_bottom();