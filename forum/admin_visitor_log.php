<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings
$forum_settings = forum_get_settings();

// Fetch Global Forum Settings
$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

if (!session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Array to hold our error messages
$error_msg_array = array();

if (isset($_POST['prune_log'])) {

    $valid = true;

    if (isset($_POST['remove_days']) && is_numeric($_POST['remove_days'])) {
        $remove_days = $_POST['remove_days'];
    }else {
        $remove_days = 0;
    }

    if ($valid) {

        if (admin_prune_visitor_log($remove_days)) {

            header_redirect("admin_visitor_log.php?webtag=$webtag&pruned=true");
            exit;

        }else {

            $error_msg_array[] = $lang['failedtoprunevisitorlog'];
            $valid = false;
        }
    }
}

html_draw_top("title={$lang['admin']} - {$lang['visitorlog']}", 'class=window_title');

$admin_visitor_log_array = admin_get_visitor_log($start, 10);

echo "<h1>{$lang['admin']}<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['visitorlog']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '90%', 'center');

}else if (isset($_GET['pruned'])) {

    html_display_success_msg($lang['successfullyprunedvisitorlog'], '90%', 'center');

}else if (sizeof($admin_visitor_log_array['user_array']) < 1) {

    html_display_warning_msg($lang['novisitorslogged'], '90%', 'center');
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
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">{$lang['member']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">{$lang['lastvisit']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">{$lang['lastipaddress']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">{$lang['referer']}</td>\n";
echo "                 </tr>\n";

if (sizeof($admin_visitor_log_array['user_array']) > 0) {

    foreach ($admin_visitor_log_array['user_array'] as $visitor) {

        echo "                 <tr>\n";

        if (isset($visitor['SID']) && !is_null($visitor['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\"><a href=\"{$visitor['URL']}\" target=\"_blank\">", word_filter_add_ob_tags(htmlentities_array($visitor['NAME'])), "</a></td>\n";

        }elseif ($visitor['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$visitor['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($visitor['LOGON'], $visitor['NICKNAME']))), "</a></td>\n";

        }else {

            echo "                   <td class=\"postbody\" align=\"left\" style=\"white-space: nowrap\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($visitor['LOGON'], $visitor['NICKNAME']))), "</td>\n";
        }

        if (isset($visitor['LAST_LOGON']) && $visitor['LAST_LOGON'] > 0) {
            echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">", format_time($visitor['LAST_LOGON']), "</td>\n";
        }else {
            echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">{$lang['unknown']}</td>\n";
        }

        if (isset($visitor['IPADDRESS']) && strlen($visitor['IPADDRESS']) > 0) {

            if (ip_is_banned($visitor['IPADDRESS'])) {

                echo "                   <td class=\"postbody\" align=\"left\" width=\"200\"><a href=\"admin_banned.php?webtag=$webtag&amp;unban_ipaddress={$visitor['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$visitor['IPADDRESS']}</a>&nbsp;({$lang['banned']})&nbsp;</td>\n";

            }else {

                echo "                   <td class=\"postbody\" align=\"left\" width=\"200\"><a href=\"admin_banned.php?webtag=$webtag&amp;ban_ipaddress={$visitor['IPADDRESS']}&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" target=\"_self\">{$visitor['IPADDRESS']}</a>&nbsp;</td>\n";
            }

        }else {

            echo "                   <td class=\"postbody\" align=\"left\" width=\"200\">{$lang['unknown']}</td>\n";
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
                echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a>&nbsp;<a href=\"{$visitor['REFERER_FULL']}\" target=\"_blank\"><img src=\"", html_style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a>&nbsp;({$lang['banned']})</td>\n";
            }else {
                echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a>&nbsp;<a href=\"{$visitor['REFERER_FULL']}\" target=\"_blank\"><img src=\"", html_style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a></td>\n";
            }

        }else {

            echo "                   <td class=\"posthead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;{$lang['unknown']}</td>\n";
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
echo "      <td align=\"center\">", page_links("admin_visitor_log.php?webtag=$webtag", $start, $admin_visitor_log_array['user_count'], 10), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">{$lang['removeentriesolderthandays']}:</td>\n";
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
echo "      <td colspan=\"2\" align=\"center\">", form_submit("prune_log", $lang['prunelog']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>