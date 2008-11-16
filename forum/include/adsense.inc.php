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

/* $Id: adsense.inc.php,v 1.1 2008-11-16 01:54:16 decoyduck Exp $ */

function adsense_client_id()
{
    if (($google_adsense_clientid = forum_get_global_setting('google_adsense_clientid'))) {
        return $google_adsense_clientid;
    }

    return false;
}

function adsense_ad_channel()
{
    if (($google_adsense_adchannel = forum_get_global_setting('google_adsense_adchannel'))) {
        return $google_adsense_adchannel;
    }

    return false;
}

function adsense_ad_type()
{
    $google_adsense_adtype_array = array(ADSENSE_ACCOUNT_DEFAULT => '',
                                         ADSENSE_TEXT_ONLY       => 'text',
                                         ADSENSE_TEXT_AND_IMAGES => 'text_image');

    if (($google_adsense_adtype = forum_get_global_setting('google_adsense_adtype'))) {

        if (in_array($google_adsense_adtype, array_keys($google_adsense_adtype_array))) {

            return $google_adsense_adtype_array[$google_adsense_adtype];
        }
    }

    return '';
}

function google_adsense_display_users()
{
    if (($google_adsense_display = forum_get_global_setting('google_adsense_display'))) {
        return $google_adsense_display;
    }

    return ADSENSE_DISPLAY_NONE;
}

function google_adsense_display_pages()
{
    if (($google_adsense_display_pages = forum_get_global_setting('google_adsense_display_pages'))) {
        return $google_adsense_display_pages;
    }

    return ADSENSE_DISPLAY_TOP_OF_ALL_PAGES;
}

function adsense_border_colour()
{
    if (($google_adsense_border_colour = forum_get_global_setting('google_adsense_border_colour'))) {
        return $google_adsense_border_colour;
    }

    return 'EEEEEE';
}

function adsense_background_colour()
{
    if (($google_adsense_bg_colour = forum_get_global_setting('google_adsense_background_colour'))) {
        return $google_adsense_bg_colour;
    }

    return 'EEEEEE';
}

function adsense_text_colour()
{
    if (($google_adsense_text_colour = forum_get_global_setting('google_adsense_text_colour'))) {
        return $google_adsense_text_colour;
    }

    return '999999';
}

function adsense_url_colour()
{
    if (($google_adsense_url_colour = forum_get_global_setting('google_adsense_url_colour'))) {
        return $google_adsense_url_colour;
    }

    return '009900';
}

function adsense_link_colour()
{
    if (($google_adsense_border_colour = forum_get_global_setting('google_adsense_border_colour'))) {
        return $google_adsense_border_colour;
    }

    return '4490B4';
}

function adsense_check_user()
{
    $adsense_display_users = google_adsense_display_users();

    if ((user_is_guest()) && ($adsense_display_users == ADSENSE_DISPLAY_GUESTS)) return true;
    if ($adsense_display_users == ADSENSE_DISPLAY_ALL_USERS) return true;

    return false;
}

function adsense_check_page($pid = NULL, $posts_per_page = NULL, $thread_length = NULL)
{
    static $random_pid = false;

    $adsense_display_pages = google_adsense_display_pages();

    if (preg_match('/^nav\.php/i', basename($_SERVER['PHP_SELF'])) > 0) return false;

    if (($adsense_display_pages == ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)) return true;

    if ((preg_match('/^messages\.php/i', basename($_SERVER['PHP_SELF'])) > 0)) {

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

function adsense_get_banner_type(&$banner_width, &$banner_height)
{
    $banner_width = 468;
    $banner_height = 60;

    $page_adsense_widths_preg_array = array('admin_menu\.php' => array('234x60_as', 234, 60),
                                            'display_emoticons\.php' => array('468x60_as', 468, 60),
                                            'attachments\.php' => array('468x60_as', 468, 60),
                                            'edit_attachments\.php' => array('468x60_as', 468, 60),
                                            'email\.php' => array('468x60_as', 468, 60),
                                            'folder_options\.php' => array('468x60_as', 468, 60),
                                            'mods_list\.php' => array('468x60_as', 468, 60),
                                            'pm_folders\.php' => array('234x60_as', 234, 60),
                                            'poll_results\.php' => array('468x60_as', 468, 60),
                                            'search_popup\.php' => array('468x60_as', 468, 60),
                                            'search\.php.+show_stop_words=true' => array('468x60_as', 468, 60),
                                            'start_left\.php' => array('234x60_as', 234, 60),
                                            'thread_list\.php' => array('234x60_as', 234, 60),
                                            'user_profile\.php' => array('468x60_as', 468, 60));

    $page_adsense_widths_preg = implode(")|^(", array_keys($page_adsense_widths_preg_array));

    if (preg_match("/^($page_adsense_widths_preg)/u", basename($_SERVER['PHP_SELF']), $adsense_width_match) > 0) {

        $adsense_width_match = (isset($adsense_width_match[0])) ? preg_quote($adsense_width_match[0], '/') : '';

        if (isset($page_adsense_widths_preg_array[$adsense_width_match])) {

            list($banner_format, $banner_width, $banner_height) = $page_adsense_widths_preg_array[$adsense_width_match];
            return $banner_format;
        }
    }

    return '468x60_as';
}

function adsense_output_html()
{
    static $adsense_displayed = false;

    if ($adsense_displayed === false) {

        adsense_get_banner_type($banner_width, $banner_height);

        if (($adsense_client_id = adsense_client_id()) && ($adsense_ad_channel = adsense_ad_channel())) {

            $adsense_bg_colour = adsense_background_colour();
            $adsense_border_colour = adsense_border_colour();
            $adsense_text_colour = adsense_text_colour();

            echo "<div style=\"width: {$banner_width}px; margin: auto; color: #$adsense_text_colour; background-color: #$adsense_bg_colour; border: 1px solid #$adsense_border_colour\">\n";
            echo "  <script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n";

            if (user_is_guest() && forum_get_global_setting('google_adsense_display', ADSENSE_DISPLAY_GUESTS)) {
                echo "  <div class=\"google_adsense_register_note\"><a href=\"index.php?webtag=$webtag&final_uri=register.php%3Fwebtag%3D$webtag\" target=\"", html_get_top_frame_name(), "\">{$lang['registertoremoveadverts']}</a></div>\n";
            }

            echo "</div>\n";

            $adsense_displayed = true;
        }
    }
}

?>