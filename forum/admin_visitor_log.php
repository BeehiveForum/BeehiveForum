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
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'banned.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else {
    $page = 1;
}

$error_msg_array = array();

if (isset($_POST['prune_log'])) {

    $valid = true;

    if (isset($_POST['remove_days']) && is_numeric($_POST['remove_days'])) {
        $remove_days = $_POST['remove_days'];
    } else {
        $remove_days = 0;
    }

    if ($valid) {

        if (admin_prune_visitor_log($remove_days)) {

            header_redirect("admin_visitor_log.php?webtag=$webtag&pruned=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Failed To Prune Visitor Log");
            $valid = false;
        }
    }
}

html_draw_top("title=", gettext("Admin"), " - ", gettext("Visitor Log"), "", 'class=window_title');

$admin_visitor_log_array = admin_get_visitor_log($page);

echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Visitor Log"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '90%', 'center');

} else if (isset($_GET['pruned'])) {

    html_display_success_msg(gettext("Successfully Pruned Visitor Log"), '90%', 'center');

} else if (sizeof($admin_visitor_log_array['user_array']) < 1) {

    html_display_warning_msg(gettext("No Visitors Logged"), '90%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Member"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Last Visit"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Last IP Address"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Referer"), "</td>\n";
echo "                 </tr>\n";

if (sizeof($admin_visitor_log_array['user_array']) > 0) {

    foreach ($admin_visitor_log_array['user_array'] as $visitor) {

        echo "                 <tr>\n";

        if (isset($visitor['SID']) && !is_null($visitor['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\"><a href=\"{$visitor['URL']}\" target=\"_blank\">", word_filter_add_ob_tags($visitor['NAME'], true), "</a></td>\n";

        } else if ($visitor['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$visitor['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($visitor['LOGON'], $visitor['NICKNAME']), true), "</a></td>\n";

        } else {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\">", word_filter_add_ob_tags(format_user_name($visitor['LOGON'], $visitor['NICKNAME']), true), "</td>\n";
        }

        if (isset($visitor['LAST_LOGON']) && $visitor['LAST_LOGON'] > 0) {
            echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">", format_time($visitor['LAST_LOGON']), "</td>\n";
        } else {
            echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">", gettext("Unknown"), "</td>\n";
        }

        if (isset($visitor['IPADDRESS']) && strlen($visitor['IPADDRESS']) > 0) {

            if (ip_is_banned($visitor['IPADDRESS'])) {

                echo "                   <td class=\"postbody\" align=\"left\" width=\"200\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$visitor['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$visitor['IPADDRESS']}</a>&nbsp;(", gettext("Banned"), ")&nbsp;</td>\n";

            } else {

                echo "                   <td class=\"postbody\" align=\"left\" width=\"200\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$visitor['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$visitor['IPADDRESS']}</a>&nbsp;</td>\n";
            }

        } else {

            echo "                   <td class=\"postbody\" align=\"left\" width=\"200\">", gettext("Unknown"), "</td>\n";
        }

        if (isset($visitor['REFERER']) && strlen(trim($visitor['REFERER'])) > 0) {

            $visitor['REFERER_FULL'] = $visitor['REFERER'];

            if (!$visitor['REFERER'] = split_url($visitor['REFERER'])) {
                if (mb_strlen($visitor['REFERER_FULL']) > 25) {
                    $visitor['REFERER'] = mb_substr($visitor['REFERER_FULL'], 0, 25);
                    $visitor['REFERER'].= "&hellip;";
                }
            }

            if (referer_is_banned($visitor['REFERER'])) {
                echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a>&nbsp;<a href=\"{$visitor['REFERER_FULL']}\" target=\"_blank\"><img src=\"", html_style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"", gettext("External Link"), "\" title=\"", gettext("External Link"), "\" /></a>&nbsp;(", gettext("Banned"), ")</td>\n";
            } else {
                echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a>&nbsp;<a href=\"{$visitor['REFERER_FULL']}\" target=\"_blank\"><img src=\"", html_style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"", gettext("External Link"), "\" title=\"", gettext("External Link"), "\" /></a></td>\n";
            }

        } else {

            echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;", gettext("Unknown"), "</td>\n";
        }

        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", html_page_links("admin_visitor_log.php?webtag=$webtag", $page, $admin_visitor_log_array['user_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <form accept-charset=\"utf-8\" action=\"admin_visitor_log.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"90%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">", gettext("Remove Entries Older Than (Days)"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text('remove_days', '30', 15, 4), "</td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td colspan=\"2\" align=\"center\">", form_submit("prune_log", gettext("Prune Log")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>