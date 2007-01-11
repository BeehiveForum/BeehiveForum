<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: admin_visitor_log.php,v 1.7 2007-01-11 19:24:07 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
    $start = floor($_GET['page'] - 1) * 10;
}else {
    $start = 0;
}

if (isset($_POST['clear'])) {
    admin_clear_visitor_log();
}

html_draw_top('openprofile.js');

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['visitorlog']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" align=\"left\">{$lang['member']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"100\">{$lang['lastvisit']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"150\">{$lang['lastipaddress']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"400\">{$lang['referer']}</td>\n";
echo "                 </tr>\n";

if ($admin_visitor_log_array = admin_get_visitor_log($start, 10)) {

    if (sizeof($admin_visitor_log_array['user_array']) > 0) {

        foreach ($admin_visitor_log_array['user_array'] as $visitor) {

            echo "                 <tr>\n";

            if (isset($visitor['SID']) && !is_null($visitor['SID'])) {

                echo "                   <td class=\"postbody\" align=\"left\"><a href=\"{$visitor['URL']}\" target=\"_blank\">{$visitor['NAME']}</a></td>\n";

            }elseif ($visitor['UID'] > 0) {

                echo "                   <td class=\"postbody\" align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$visitor['UID']}\" target=\"_blank\" onclick=\"return openProfile({$visitor['UID']}, '$webtag')\">", add_wordfilter_tags(add_wordfilter_tags(format_user_name($visitor['LOGON'], $visitor['NICKNAME']))), "</a></td>\n";

            }else {

                echo "                   <td class=\"postbody\" align=\"left\">", add_wordfilter_tags(add_wordfilter_tags(format_user_name($visitor['LOGON'], $visitor['NICKNAME']))), "</td>\n";
            }

            if (isset($visitor['LAST_LOGON']) && $visitor['LAST_LOGON'] > 0) {
                echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">", format_time($visitor['LAST_LOGON']), "</td>\n";
            }else {
                echo "                   <td class=\"postbody\" align=\"left\" width=\"100\">{$lang['unknown']}</td>\n";
            }

            if (isset($visitor['IPADDRESS']) && $visitor['IPADDRESS'] > 0) {
                echo "                   <td class=\"postbody\" align=\"left\" width=\"150\">{$visitor['IPADDRESS']}</td>\n";
            }else {
                echo "                   <td class=\"postbody\" align=\"left\" width=\"150\">{$lang['unknown']}</td>\n";
            }

            if (isset($visitor['REFERER']) && strlen(trim($visitor['REFERER'])) > 0) {

                $visitor['REFERER_FULL'] = $visitor['REFERER'];

                if (!$visitor['REFERER'] = split_url($visitor['REFERER'])) {
                    if (strlen($visitor['REFERER_FULL']) > 25) {
                        $visitor['REFERER'] = substr($visitor['REFERER_FULL'], 0, 25);
                        $visitor['REFERER'].= "&hellip;";
                    }
                }

                if (referer_is_banned($visitor['REFERER'])) {
                    echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?unban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=admin_users.php\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a> ({$lang['banned']})</td>\n";
                }else {
                    echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?ban_referer=", rawurlencode($visitor['REFERER_FULL']), "&amp;ret=admin_users.php\" title=\"{$visitor['REFERER_FULL']}\">{$visitor['REFERER']}</a></td>\n";
                }

            }else {

                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
            }

            echo "                 </tr>\n";
        }

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "                 </tr>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" class=\"postbody\">{$lang['novisitorslogged']}</td>\n";
        echo "                 </tr>\n";
        echo "                 <tr>\n";
        echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "                 </tr>\n";
    }

}else {

    echo "                 <tr>\n";
    echo "                   <td class=\"postbody\" align=\"left\">{$lang['novisitorslogged']}</td>\n";
    echo "                 </tr>\n";
    echo "                 <tr>\n";
    echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";
}

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
echo "      <td align=\"center\">", page_links(get_request_uri(false), $start, $admin_visitor_log_array['user_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">\n";
echo "        <form name=\"f_post\" action=\"admin_visitor_log.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
echo "          ", form_submit('clear', $lang['clearlog']), "\n";
echo "        </form>\n";
echo "      </td>";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>