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

/* $Id: mods_list.php,v 1.2 2005-04-07 11:03:57 rowan_hill Exp $ */

/**
* Displays list of moderators for a folder
*/

/**
*/
// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();


include_once(BH_INCLUDE_PATH. "mods_list.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$valid = true;
$error_html = "";

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

} else {

    $valid = false;
    $error_html .= "<h2>{$lang['cantdisplaymods']}</h2>\n";
    $error_html .= "{$lang['mustprovidefolderid']}\n";
    
}

if ($valid) {

    $folder_info = threads_get_folders();
    $folder = $folder_info[$fid];
   
    html_draw_top("title={$lang['moderatorlist']} {$folder['TITLE']}", "openprofile.js");
    
    echo "<div align =\"center\">\n";
   
    if ($mods_forum = mods_list_get_mods(0) | $mods_folder = mods_list_get_mods($fid)) {
    	
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['modsforfolder']} '{$folder['TITLE']}'</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"90%\" class=\"posthead\">\n";
        echo "                      <tr>\n";
        echo "                        <td>\n";
        
        if (is_array($mods_forum)) {
            echo "<h2>{$lang['forumlevelmods']}</h2>\n";
            echo "<ul>\n";
            print_r($mods_forum);
            foreach ($mods_forum as $uid) {
                $user = user_get($uid);
                echo "<li><a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";
                echo format_user_name($user['LOGON'], $user['NICKNAME']), "</a></li>\n";
            }
            echo "</ul>\n";
        } elseif ($mods_forum != false) {
            echo "<h2>{$lang['forumlevelmods']}</h2>\n";
            echo "<ul>\n";
            $user = user_get($mods_forum);
            echo "<li><a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($user['LOGON'], $user['NICKNAME']), "</a></li>\n";
            echo "</ul>\n";
        }
        
        if ($mods_folder) {
            echo "<h2>{$lang['folderlevelmods']}</h2>";
            echo "<ul>\n";
            foreach ($mods_folder as $uid) {
                $user = user_get($uid);
                echo "<li><a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";
                echo format_user_name($user['LOGON'], $user['NICKNAME']), "</a></li>\n";
            }
            echo "</ul>\n";
        } elseif ($mods_folder != false) {
            echo "<h2>{$lang['folderlevelmods']}</h2>\n";
            echo "<ul>\n";
            $user = user_get($mods_folder);
            echo "<li><a href=\"javascript:void(0);\" onclick=\"openProfile({$user['UID']}, '$webtag')\" target=\"_self\">";
            echo format_user_name($user['LOGON'], $user['NICKNAME']), "</a></li>\n";
            echo "</ul>\n";
        }
        
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    
    } else {
    
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['modsforfolder']}' {$folder['TITLE']}'</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>{$lang['nomodsfound']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";    
    
    }
    	
    	
    echo "</div>\n";    
    
    html_draw_bottom();
    exit;
    
   

} else {

    echo $error_html;
    html_draw_bottom();
    exit;
    
}


?>


















