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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

function adsense_publisher_id()
{
    if (($adsense_publisher_id = forum_get_global_setting('adsense_publisher_id', 'strlen', false)) !== false) {
        return $adsense_publisher_id;
    }

    return false;
}

function adsense_medium_ad_id()
{
    if (($adsense_medium_ad_id = forum_get_global_setting('adsense_medium_ad_id', 'strlen', false)) !== false) {
        return $adsense_medium_ad_id;
    }

    return false;
}

function adsense_small_ad_id()
{
    if (($adsense_small_ad_id = forum_get_global_setting('adsense_small_ad_id', 'strlen', false)) !== false) {
        return $adsense_small_ad_id;
    }

    return false;
}

function adsense_display_users()
{
    if (($adsense_display_users = forum_get_global_setting('adsense_display_users', 'strlen', false)) !== false) {
        return $adsense_display_users;
    }

    return ADSENSE_DISPLAY_NONE;
}

function adsense_display_pages()
{
    if (($adsense_display_pages = forum_get_global_setting('adsense_display_pages', 'strlen', false)) !== false) {
        return $adsense_display_pages;
    }

    return ADSENSE_DISPLAY_TOP_OF_ALL_PAGES;
}

function adsense_check_user()
{
    $adsense_display_users = adsense_display_users();

    if (!session::logged_in() && ($adsense_display_users == ADSENSE_DISPLAY_GUESTS)) return true;
    if ($adsense_display_users == ADSENSE_DISPLAY_ALL_USERS) return true;

    return false;
}

function adsense_slot_id($ad_type)
{
    $forum_setting_names_array = array(
        'small' => 'adsense_small_ad_id',
        'medium' => 'adsense_medium_ad_id'
    );

    if (!in_array($ad_type, array_keys($forum_setting_names_array))) {
        $ad_type = 'medium';
    }

    if (($adsense_slot_id = forum_get_setting($forum_setting_names_array[$ad_type], 'strlen', false)) !== false) {
        return $adsense_slot_id;
    }

    return false;
}

function adsense_check_page($pid = NULL, $posts_per_page = NULL, $thread_length = NULL)
{
    static $random_pid = false;

    $adsense_display_pages = adsense_display_pages();

    $adsense_message_number = forum_get_setting('adsense_message_number', 1);

    $admin_area_files_preg = implode("|^", array_map('preg_quote_callback', get_available_admin_files()));

    if (preg_match("/^nav\\.php|^$admin_area_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) return false;

    if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)) return true;

    if ((preg_match('/^messages\.php|^lmessages\.php/i', basename($_SERVER['PHP_SELF'])) > 0)) {

        if (is_null($pid)) {

            if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_MESSAGES)) return true;

        } else {

            if (($adsense_display_pages == ADSENSE_DISPLAY_BOTTOM_OF_MESSAGES)) {
                return (($pid + 1) == $thread_length);
            }

            if ($adsense_display_pages == ADSENSE_DISPLAY_ONCE_AFTER_NTH_MSG) {
                return ($adsense_message_number == ($pid + 1));
            }

            if ($adsense_display_pages == ADSENSE_DISPLAY_AFTER_EVERY_NTH_MSG) {
                return (($pid + 1) % $adsense_message_number) == 0;
            }

            if ($random_pid === false) {
                $random_pid = min(mt_rand(0, $posts_per_page), $thread_length);
            }

            if (($adsense_display_pages == ADSENSE_DISPLAY_AFTER_RANDOM_MSG) && ($pid == $random_pid)) return true;
        }
    }

    return false;
}

function adsense_check_page_bottom()
{
    $adsense_display_pages = adsense_display_pages();

    $admin_area_files_preg = implode("|^", array_map('preg_quote_callback', get_available_admin_files()));

    if (preg_match("/^nav\\.php|^$admin_area_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) return false;

    if (($adsense_display_pages == ADSENSE_DISPLAY_BOTTOM_OF_ALL_PAGES)) return true;

    return false;
}

function adsense_get_banner_type(&$ad_type, &$ad_width, &$ad_height)
{
    $ad_type = 'medium';
    $ad_width = 468;
    $ad_height = 60;

    $ad_sense_small_banner_pages_preg = implode("|^", array_map('preg_quote_callback', adsense_small_banner_pages()));

    if (preg_match("/^$ad_sense_small_banner_pages_preg/u", basename($_SERVER['PHP_SELF'])) > 0) {
        $ad_type = 'small';
        $ad_width = 234;
        $ad_height = 60;
    }
}

function adsense_small_banner_pages()
{
    return array(
        'index.php',
        'ldelete.php',
        'ldisplay.php',
        'ledit.php',
        'lforums.php',
        'llogon.php',
        'llogout.php',
        'lmessages.php',
        'lpm.php',
        'lpm_edit.php',
        'lpm_write.php',
        'lpost.php',
        'lthread_list.php',
        'pm_folder.php',
        'thread_list.php',
        'user_menu.php',
    );
}

function adsense_output_html()
{
    static $adsense_displayed = false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if ($adsense_displayed === false) {

        if (adsense_publisher_id()) {

            $adsense_display_users = adsense_display_users();

            $ad_type = 'medium';
            $ad_width = 468;
            $ad_height = 60;

            adsense_get_banner_type($ad_type, $ad_width, $ad_height);

            echo "<div class=\"google_adsense_container\" style=\"width: 100%; text-align: center\">\n";
            echo "  <div style=\"width: {$ad_width}px; margin: auto\">\n";
            echo "    <script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n";

            if (!session::logged_in() && ($adsense_display_users == ADSENSE_DISPLAY_GUESTS)) {
                echo "  <div class=\"google_adsense_register_note\"><a href=\"index.php?webtag=$webtag&amp;final_uri=register.php%3Fwebtag%3D$webtag\" target=\"", html_get_top_frame_name(), "\">", gettext("Register to remove these adverts."), "</a></div>\n";
            }

            echo "  </div>\n";
            echo "</div>\n";

            $adsense_displayed = true;
        }
    }
}