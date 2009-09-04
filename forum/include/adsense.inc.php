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

/* $Id: adsense.inc.php,v 1.12 2009-09-04 22:01:44 decoyduck Exp $ */

/**
* adsense.inc.php - admin functions
*
* Contains Google Adsense related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

function adsense_publisher_id()
{
    if (($adsense_publisher_id = forum_get_global_setting('adsense_publisher_id'))) {
        return $adsense_publisher_id;
    }

    return false;
}

function adsense_medium_ad_id()
{
    if (($adsense_medium_ad_id = forum_get_global_setting('adsense_medium_ad_id'))) {
        return $adsense_medium_ad_id;
    }

    return false;
}

function adsense_small_ad_id()
{
    if (($adsense_small_ad_id = forum_get_global_setting('adsense_small_ad_id'))) {
        return $adsense_small_ad_id;
    }

    return false;
}

function adsense_display_users()
{
    if (($adsense_display_users = forum_get_global_setting('adsense_display_users'))) {
        return $adsense_display_users;
    }

    return ADSENSE_DISPLAY_NONE;
}

function adsense_display_pages()
{
    if (($adsense_display_pages = forum_get_global_setting('adsense_display_pages'))) {
        return $adsense_display_pages;
    }

    return ADSENSE_DISPLAY_TOP_OF_ALL_PAGES;
}

function adsense_check_user()
{
    $adsense_display_users = adsense_display_users();

    if ((user_is_guest()) && ($adsense_display_users == ADSENSE_DISPLAY_GUESTS)) return true;
    if ($adsense_display_users == ADSENSE_DISPLAY_ALL_USERS) return true;

    return false;
}

function adsense_slot_id($ad_type)
{
    $forum_setting_names_array = array('small'  => 'adsense_small_ad_id',
                                       'medium' => 'adsense_medium_ad_id');

    if (!in_array($ad_type, array_keys($forum_setting_names_array))) {
        $ad_type = 'medium';
    }

    if (($adsense_slot_id = forum_get_setting($forum_setting_names_array[$ad_type]))) {
        return $adsense_slot_id;
    }

    return false;
}

function adsense_check_page($pid = NULL, $posts_per_page = NULL, $thread_length = NULL)
{
    static $random_pid = false;
    
    $adsense_display_pages = adsense_display_pages();

    $admin_area_files_array = get_available_admin_files();
    $admin_area_files_preg  = implode("|^", array_map('preg_quote_callback', $admin_area_files_array));

    if (preg_match("/^nav\.php|^logon\.php|^logout\.php|^$admin_area_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) return false;

    if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)) return true;

    if ((preg_match('/^messages\.php|^lmessages\.php/i', basename($_SERVER['PHP_SELF'])) > 0)) {

        if (is_null($pid)) {

            if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_MESSAGES)) return true;

        }else {

            if ($random_pid === false) {
                $random_pid = min(mt_rand(0, $posts_per_page), $thread_length);
            }

            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_FIRST_MSG) && ($pid == 0)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_THIRD_MSG) && ($pid == 2)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_FIFTH_MSG) && ($pid == 4)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_TENTH_MSG) && ($pid == 9)) return true;

            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_RANDOM_MSG) && ($pid == $random_pid)) return true;
        }
    }
    
    return false;
}

function adsense_get_banner_type(&$ad_type, &$ad_width, &$ad_height)
{
    $ad_type = 'medium'; $ad_width = 468; $ad_height = 60;

    if (preg_match("/^pm_folder\.php|^start_left\.php|^thread_list\.php|^user_menu\.php/u", basename($_SERVER['PHP_SELF'])) > 0) {
        $ad_type = 'small'; $ad_width = 234; $ad_height = 60;
    }
}

function adsense_output_html()
{
    static $adsense_displayed = false;

    $webtag = get_webtag();

    $lang = load_language_file();

    if ($adsense_displayed === false) {

        if (adsense_publisher_id()) {

            $adsense_display_users = adsense_display_users();
            
            $ad_type = 'medium'; $ad_width = 468; $ad_height = 60;

            adsense_get_banner_type($ad_type, $ad_width, $ad_height);

            echo "<div class=\"google_adsense_container\" style=\"width: {$ad_width}px; margin: auto\">\n";
            echo "  <script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n";

            if ((user_is_guest()) && ($adsense_display_users == ADSENSE_DISPLAY_GUESTS)) {
                echo "  <div class=\"google_adsense_register_note\"><a href=\"index.php?webtag=$webtag&final_uri=register.php%3Fwebtag%3D$webtag\" target=\"", html_get_top_frame_name(), "\">{$lang['registertoremoveadverts']}</a></div>\n";
            }

            echo "</div>\n";

            $adsense_displayed = true;
        }
    }
}

?>