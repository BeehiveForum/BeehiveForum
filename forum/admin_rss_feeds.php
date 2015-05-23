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
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'rss_feed.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold error messages
$error_msg_array = array();

$t_name_new = null;
$t_new_name = null;
$t_user_uid = null;
$t_fid_new = null;
$t_new_fid = null;
$t_url_new = null;
$t_new_url = null;
$t_user_new = null;
$t_new_user = null;
$t_frequency_new = null;
$t_new_frequency = null;
$t_max_item_count_new = null;
$t_max_item_count = null;
$t_url = null;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
} else {
    $page = 1;
}

$update_frequencies_array = array(
    RSS_FEED_UPDATE_NEVER => gettext("Never"),
    RSS_FEED_UPDATE_THIRTY_MINS => gettext("Every 30 minutes"),
    RSS_FEED_UPDATE_ONE_HOUR => gettext("Once an hour"),
    RSS_FEED_UPDATE_SIX_HOURS => gettext("Every 6 hours"),
    RSS_FEED_UPDATE_TWELVE_HOURS => gettext("Every 12 hours"),
    RSS_FEED_UPDATE_ONCE_A_DAY => gettext("Once a day"),
    RSS_FEED_UPDATE_ONCE_A_WEEK => gettext("Once a Week")
);

// Cancel clicked.
if (isset($_POST['cancel'])) {

    header_redirect("admin_rss_feeds.php?webtag=$webtag");
    exit;
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $feed_id => $delete_feed) {

            if ($valid && $delete_feed == "Y" && $rss_feed = rss_feed_get($feed_id)) {

                if (rss_feed_remove($feed_id)) {

                    admin_add_log_entry(DELETED_RSS_FEED, array($rss_feed['NAME']));

                } else {

                    $error_msg_array[] = gettext("Failed to remove some or all of the selected feeds");
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_rss_feeds.php?webtag=$webtag&deleted=true");
            exit;
        }
    }

} else if (isset($_POST['checkfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_url']) && strlen(trim($_POST['t_url'])) > 0) {

        $t_url = trim($_POST['t_url']);

    } else if (isset($_POST['t_url_new']) && strlen(trim($_POST['t_url_new'])) > 0) {

        $t_url = trim($_POST['t_url_new']);

    } else {

        $error_msg_array[] = gettext("Must specify RSS Feed URL");
        $valid = false;
    }

    if ($valid) {

        if (($rss_feed_items = rss_feed_read_database($t_url)) !== false) {

            if (is_array($rss_feed_items) && sizeof($rss_feed_items) > 0) {

                $rss_stream_success = gettext("RSS stream appears to be working correctly");

            } else {

                $error_msg_array[] = gettext("RSS stream was empty or could not be found");
            }

        } else {

            $error_msg_array[] = gettext("RSS stream was empty or could not be found");
        }
    }

    unset($t_url);

} else if (isset($_POST['addfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {
        $t_name_new = trim($_POST['t_name_new']);
    } else {
        $valid = false;
        $error_msg_array[] = gettext("Must specify RSS Feed Name");
    }

    if (isset($_POST['t_user_new']) && strlen(trim($_POST['t_user_new'])) > 0) {

        $t_user_new = trim($_POST['t_user_new']);

        if (($t_user_array = user_get_by_logon($t_user_new)) !== false) {

            $t_user_uid = $t_user_array['UID'];

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Unknown RSS User Account");
        }

    } else {

        $valid = false;
        $error_msg_array[] = gettext("Must specify RSS Feed User Account");
    }

    if (isset($_POST['t_fid_new']) && is_numeric($_POST['t_fid_new'])) {

        $t_fid_new = $_POST['t_fid_new'];

    } else {

        $valid = false;
        $error_msg_array[] = gettext("Must specify RSS Feed Folder");
    }

    if (isset($_POST['t_url_new']) && strlen(trim($_POST['t_url_new'])) > 0) {

        $t_url_new = trim($_POST['t_url_new']);

        $check_url = parse_url($t_url_new);

        if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {

            $valid = false;
            $error_msg_array[] = gettext("RSS Feed supports HTTP URLs only. Secure feeds (https://) are not supported.");
        }

        if (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1) {

            $valid = false;
            $error_msg_array[] = gettext("RSS Feed URL format is invalid. URL must include scheme (e.g. http://) and a hostname (e.g. www.hostname.com).");
        }

        if (isset($check_url['user']) || isset($check_url['pass'])) {

            $valid = false;
            $error_msg_array[] = gettext("RSS Feed does not support HTTP user authentication");
        }

    } else {

        $valid = false;
        $error_msg_array[] = gettext("Must specify RSS Feed URL");
    }

    if (isset($_POST['t_prefix_new']) && strlen(trim($_POST['t_prefix_new'])) > 0) {
        $t_prefix_new = trim($_POST['t_prefix_new']);
    } else {
        $t_prefix_new = "";
    }

    if (isset($_POST['t_frequency_new']) && is_numeric($_POST['t_frequency_new'])) {

        $t_frequency_new = $_POST['t_frequency_new'];

    } else {

        $valid = false;
        $error_msg_array[] = gettext("Must specify RSS Feed Update Frequency");
    }

    if (isset($_POST['t_max_item_count_new']) && in_array($_POST['t_max_item_count_new'], range(1, 10))) {

        $t_max_item_count_new = $_POST['t_max_item_count_new'];

    } else {

        $valid = false;
        $error_msg_array[] = gettext("Max Item Count must be between 1 and 10");
    }

    if ($valid) {

        if (rss_feed_add($t_name_new, $t_user_uid, $t_fid_new, $t_url_new, $t_prefix_new, $t_frequency_new, $t_max_item_count_new)) {

            admin_add_log_entry(ADDED_RSS_FEED, array($t_name_new, $t_url_new));
            header_redirect("admin_rss_feeds.php?webtag=$webtag&added=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Failed to add new RSS Feed");
        }
    }

} else if (isset($_POST['updatefeedsubmit'])) {

    $valid = true;

    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];

        if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {

            $t_new_name = trim($_POST['t_name']);

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Must specify RSS Feed Name");
        }

        if (isset($_POST['t_old_name']) && strlen(trim($_POST['t_old_name'])) > 0) {
            $t_old_name = trim($_POST['t_old_name']);
        } else {
            $t_old_name = "";
        }

        if (isset($_POST['t_user']) && strlen(trim($_POST['t_user'])) > 0) {

            $t_new_user = trim($_POST['t_user']);

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Must specify RSS Feed User Account");
        }

        if (isset($_POST['t_old_user']) && strlen(trim($_POST['t_old_user'])) > 0) {
            $t_old_user = trim($_POST['t_old_user']);
        } else {
            $t_old_user = "";
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            $t_new_fid = $_POST['t_fid'];

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Must specify RSS Feed Folder");
        }

        if (isset($_POST['t_old_fid']) && is_numeric($_POST['t_old_fid'])) {
            $t_old_fid = $_POST['t_old_fid'];
        } else {
            $t_old_fid = "";
        }

        if (isset($_POST['t_url']) && strlen(trim($_POST['t_url'])) > 0) {
            $t_new_url = $_POST['t_url'];
        } else {
            $valid = false;
            $error_msg_array[] = gettext("Must specify RSS Feed URL");
        }

        if (isset($_POST['t_old_url']) && strlen(trim($_POST['t_old_url'])) > 0) {
            $t_old_url = $_POST['t_old_url'];
        } else {
            $t_old_url = "";
        }

        if (isset($_POST['t_prefix']) && strlen(trim($_POST['t_prefix'])) > 0) {
            $t_new_prefix = $_POST['t_prefix'];
        } else {
            $t_new_prefix = "";
        }

        if (isset($_POST['t_old_prefix']) && strlen(trim($_POST['t_old_prefix'])) > 0) {
            $t_old_prefix = $_POST['t_old_prefix'];
        } else {
            $t_old_prefix = "";
        }

        if (isset($_POST['t_frequency']) && is_numeric($_POST['t_frequency'])) {

            $t_new_frequency = $_POST['t_frequency'];

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Must specify RSS Feed Update Frequency");
        }

        if (isset($_POST['t_old_frequency']) && is_numeric($_POST['t_old_frequency'])) {
            $t_old_frequency = $_POST['t_old_frequency'];
        } else {
            $t_old_frequency = "";
        }

        if (isset($_POST['t_max_item_count']) && in_array($_POST['t_max_item_count'], range(1, 10))) {

            $t_max_item_count = $_POST['t_max_item_count'];

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Max Item Count must be between 1 and 10");
        }

        if (isset($_POST['t_old_max_item_count']) && is_numeric($_POST['t_old_max_item_count'])) {
            $t_old_max_item_count = $_POST['t_old_max_item_count'];
        } else {
            $t_old_max_item_count = 0;
        }

        if ($valid && (($t_new_name != $t_old_name) || ($t_new_user != $t_old_user) || ($t_new_fid != $t_old_fid) || ($t_new_url != $t_old_url) || ($t_new_prefix != $t_old_prefix) || ($t_new_frequency != $t_old_frequency) || ($t_max_item_count != $t_old_max_item_count))) {

            if (($t_user_array = user_get_by_logon($t_new_user)) !== false) {

                $t_new_uid = $t_user_array['UID'];

                if (rss_feed_update($feed_id, $t_new_name, $t_new_uid, $t_new_fid, $t_new_url, $t_new_prefix, $t_new_frequency, $t_max_item_count)) {

                    $log_data = array(
                        $t_new_name,
                        $t_old_name,
                        $t_new_user,
                        $t_old_user,
                        $t_new_fid,
                        $t_old_fid,
                        $t_new_url,
                        $t_old_url,
                        $t_new_prefix,
                        $t_old_prefix,
                        $t_new_frequency,
                        $t_old_frequency
                    );

                    admin_add_log_entry(EDITED_RSS_FEED, $log_data);
                    header_redirect("admin_rss_feeds.php?webtag=$webtag&edited=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to update RSS Feed");
                }

            } else {

                $error_msg_array[] = gettext("Unknown RSS User Account");
            }
        }
    }

} else if (isset($_POST['addfeed'])) {

    $redirect = "admin_rss_feeds.php?webtag=$webtag&page=$page&addfeed=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfeed']) || isset($_POST['addfeed'])) {

    html_draw_top(
        array(
            'title' => gettext('Admin - RSS Feeds - Add New Feed'),
            'class' => 'window_title',
            'js' => array(
                'js/search_popup.js'
            ),
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("RSS Feeds"), html_style_image('separator'), gettext("Add New Feed"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '700', 'center');

    } else if (isset($rss_stream_success)) {

        html_display_success_msg($rss_stream_success, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addfeed', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Feed Name and Location"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array($_POST['t_name_new']) : ""), 40, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Location"), ":</td>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text("t_url_new", (isset($_POST['t_url_new']) ? htmlentities_array($_POST['t_url_new']) : ""), 30, 255), "&nbsp;", form_submit("checkfeedsubmit", 'Test'), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Feed Settings"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed User Account"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_user_new", (isset($_POST['t_user_new']) ? htmlentities_array($_POST['t_user_new']) : ""), 30, 15), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Thread Title Prefix"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix_new", (isset($_POST['t_prefix_new']) ? htmlentities_array($_POST['t_prefix_new']) : ""), 20, 16), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Folder Name"), ":</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid_new']) ? htmlentities_array($_POST['t_fid_new']) : 0), "t_fid_new", "", "", "post_folder_dropdown"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Update Frequency"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency_new", $update_frequencies_array, (isset($_POST['t_frequency_new']) ? htmlentities_array($_POST['t_frequency_new']) : 1440)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Max Item Count"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_max_item_count_new", (isset($_POST['t_max_item_count_new']) ? htmlentities_array($_POST['t_max_item_count_new']) : 10), 6, 4), "&nbsp;<span>", gettext("Min: 1, Max: 10"), "</span></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addfeedsubmit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else if (isset($_POST['feed_id']) || isset($_GET['feed_id'])) {

    if (isset($_POST['feed_id']) && is_numeric($_POST['feed_id'])) {

        $feed_id = $_POST['feed_id'];

    } else if (isset($_GET['feed_id']) && is_numeric($_GET['feed_id'])) {

        $feed_id = $_GET['feed_id'];

    } else {

        html_draw_error(gettext("Invalid feed id or feed not found"), 'admin_rss_feeds.php', 'get', array('back' => gettext("Back")));
    }

    if (!$rss_feed = rss_feed_get($feed_id)) {
        html_draw_error(gettext("Invalid feed id or feed not found"), 'admin_rss_feeds.php', 'get', array('back' => gettext("Back")));
    }

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - RSS Feeds - Edit Feed - %s'),
                $rss_feed['NAME']
            ),
            'js' => array(
                'js/search_popup.js'
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("RSS Feeds"), html_style_image('separator'), gettext("Edit Feed"), html_style_image('separator'), word_filter_add_ob_tags($rss_feed['NAME'], true), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '700', 'center');

    } else if (isset($rss_stream_success)) {

        html_display_success_msg($rss_stream_success, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_rss_feeds.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('feed_id', htmlentities_array($feed_id)), "\n";
    echo "  ", form_input_hidden("t_delete[$feed_id]", "Y"), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Feed Name and Location"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? htmlentities_array($_POST['t_name']) : (isset($rss_feed['NAME']) ? htmlentities_array($rss_feed['NAME']) : "")), 40, 32), form_input_hidden("t_name_old", (isset($rss_feed['NAME']) ? htmlentities_array($rss_feed['NAME']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Location"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_url", (isset($_POST['t_url']) ? htmlentities_array($_POST['t_url']) : (isset($rss_feed['URL']) ? htmlentities_array($rss_feed['URL']) : "")), 30, 255), form_input_hidden("t_url_old", (isset($rss_feed['URL']) ? htmlentities_array($rss_feed['URL']) : "")), "&nbsp;", form_submit('checkfeedsubmit', "Test"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Feed Settings"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed User Account"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text_search("t_user", (isset($_POST['t_user']) ? htmlentities_array($_POST['t_user']) : (isset($rss_feed['LOGON']) ? htmlentities_array($rss_feed['LOGON']) : "")), 26, 15), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Thread Title Prefix"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_prefix", (isset($_POST['t_prefix']) ? htmlentities_array($_POST['t_prefix']) : (isset($rss_feed['PREFIX']) ? htmlentities_array($rss_feed['PREFIX']) : "")), 29, 16), form_input_hidden("t_prefix_old", (isset($rss_feed['PREFIX']) ? htmlentities_array($rss_feed['PREFIX']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Feed Folder Name"), ":</td>\n";
    echo "                        <td align=\"left\">", folder_draw_dropdown_all((isset($_POST['t_fid']) ? htmlentities_array($_POST['t_fid']) : (isset($rss_feed['FID']) ? $rss_feed['FID'] : 0)), "t_fid", "", "", "post_folder_dropdown"), form_input_hidden("t_fid_old", (isset($rss_feed['FID']) ? htmlentities_array($rss_feed['FID']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Update Frequency"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_frequency", $update_frequencies_array, (isset($_POST['t_frequency']) ? htmlentities_array($_POST['t_frequency']) : (isset($rss_feed['FREQUENCY']) ? $rss_feed['FREQUENCY'] : 1440)), null, "post_folder_dropdown"), form_input_hidden("t_frequency_old", (isset($rss_feed['FREQUENCY']) ? htmlentities_array($rss_feed['FREQUENCY']) : "")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Max Item Count"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_max_item_count", (isset($_POST['t_max_item_count']) ? htmlentities_array($_POST['t_max_item_count']) : (isset($rss_feed['MAX_ITEM_COUNT']) ? $rss_feed['MAX_ITEM_COUNT'] : 10)), 6, 4), form_input_hidden("t_max_item_count_old", (isset($rss_feed['MAX_ITEM_COUNT']) ? htmlentities_array($rss_feed['MAX_ITEM_COUNT']) : 10)), "&nbsp;<span>", gettext("Min: 1, Max: 10"), "</span></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatefeedsubmit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_top(
        array(
            'title' => gettext('Admin - RSS Feeds'),
            'js' => array(
                'js/search.js'
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    $rss_feeds = rss_feed_get_feeds($page);

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("RSS Feeds"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '86%', 'center');

    } else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully added new feed"), '86%', 'center');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully edited feed"), '86%', 'center');

    } else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully removed selected feeds"), '86%', 'center');

    } else if (sizeof($rss_feeds['rss_feed_array']) < 1) {

        html_display_warning_msg(gettext("No existing RSS Feeds found. To add a feed click the 'Add New' button below"), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"rss\" action=\"admin_rss_feeds.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Name"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Feed Location"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"20%\">", gettext("Update Frequency"), "&nbsp;</td>\n";
    echo "                </tr>\n";

    if (sizeof($rss_feeds['rss_feed_array']) > 0) {

        foreach ($rss_feeds['rss_feed_array'] as $rss_feed) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$rss_feed['RSSID']}]", "Y"), "</td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"35%\"><a href=\"admin_rss_feeds.php?webtag=$webtag&amp;page=$page&amp;feed_id={$rss_feed['RSSID']}\">", word_filter_add_ob_tags($rss_feed['NAME'], true), "</a></td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"45%\">{$rss_feed['URL']}</td>\n";
            echo "                  <td valign=\"top\" align=\"left\" width=\"20%\">", (in_array($rss_feed['FREQUENCY'], array_keys($update_frequencies_array))) ? $update_frequencies_array[$rss_feed['FREQUENCY']] : gettext("Unknown"), "</td>\n";
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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">";

    html_page_links("admin_rss_feeds.php?webtag=$webtag", $page, $rss_feeds['rss_feed_count'], 10);

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addfeed", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_display_warning_msg(gettext("Here you can setup some RSS feeds for automatic propagation into your forum. The items from the RSS feeds you add will be created as threads which users can reply to as if they were normal posts. The RSS feed must be accessible via HTTP or it will not work."), '86%', 'center');

    html_draw_bottom();
}