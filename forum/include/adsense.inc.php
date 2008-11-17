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

/* $Id: adsense.inc.php,v 1.2 2008-11-17 21:16:24 decoyduck Exp $ */

function adsense_publisher_id()
{
    if (($adsense_publisher_id = forum_get_global_setting('adsense_publisher_id'))) {
        return $adsense_publisher_id;
    }

    return false;
}

function adsense_large_ad_id()
{
    if (($adsense_large_ad_id = forum_get_global_setting('adsense_large_ad_id'))) {
        return $adsense_large_ad_id;
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
                                       'medium' => 'adsense_medium_ad_id',
                                       'large'  => 'adsense_large_ad_id');

    if (!in_array($ad_type, array_keys($forum_setting_names_array))) {
        $ad_type = 'adsense_large_ad_id';
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

    if (preg_match("/^nav\.php|^$admin_area_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) return false;

    if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)) return true;

    if ((preg_match('/^messages\.php/i', basename($_SERVER['PHP_SELF'])) > 0)) {

        if (is_null($pid)) {

            if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_MESSAGES)) return true;

        }else {

            if ($random_pid === false) {
                $random_pid = min(mt_rand(0, $posts_per_page), $thread_length);
            }

            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_FIRST_MSG) && ($pid == 1)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_THIRD_MSG) && ($pid == 3)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_FIFTH_MSG) && ($pid == 4)) return true;
            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_TENTH_MSG) && ($pid == 10)) return true;

            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_RANDOM_MSG) && ($pid == $random_pid)) return true;
        }
    }

    return false;
}

function adsense_get_banner_type(&$ad_type, &$ad_width, &$ad_height)
{
    $ad_type = 'large';
    $ad_width = 728;
    $ad_height = 90;

    $adsense_settings_preg_array = array('admin_menu\.php' => array('small', 234, 60),
                                         'display_emoticons\.php' => array('medium', 468, 60),
                                         'attachments\.php' => array('medium', 468, 60),
                                         'edit_attachments\.php' => array('medium', 468, 60),
                                         'email\.php' => array('medium', 468, 60),
                                         'folder_options\.php' => array('medium', 468, 60),
                                         'mods_list\.php' => array('medium', 468, 60),
                                         'pm_folders\.php' => array('small', 234, 60),
                                         'poll_results\.php' => array('medium', 468, 60),
                                         'search_popup\.php' => array('medium', 468, 60),
                                         'search\.php.+show_stop_words=true' => array('medium', 468, 60),
                                         'start_left\.php' => array('small', 234, 60),
                                         'thread_list\.php' => array('small', 234, 60),
                                         'user_menu\.php' => array('small', 234, 60),
                                         'user_profile\.php' => array('medium', 468, 60));

    $adsense_page_names_preg = implode(")|^(", array_keys($adsense_settings_preg_array));

    if (preg_match("/^($adsense_page_names_preg)/u", basename($_SERVER['PHP_SELF']), $adsense_settings_match) > 0) {

        $adsense_settings_match = (isset($adsense_settings_match[0])) ? preg_quote($adsense_settings_match[0], '/') : '';

        if (isset($adsense_settings_preg_array[$adsense_settings_match])) {

            list($ad_type, $ad_width, $ad_height) = $adsense_settings_preg_array[$adsense_settings_match];
        }
    }

    return true;
}

function adsense_output_html()
{
    static $adsense_displayed = false;

    if ($adsense_displayed === false) {

        if (($adsense_publisher_id = adsense_publisher_id())) {

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