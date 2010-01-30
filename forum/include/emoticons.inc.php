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

/**
* emoticons.inc.php - emoticon functions
*
* Contains emoticon related functions.
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

include_once(BH_INCLUDE_PATH. "browser.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

/**
* Initialise emoticons.
*
* Initislises the user's emoticon pack by pre-loading the definitions into a static array.
* If the user doesn't have an emoticon pack the forum default pack is used instead.
*
* @return mixed - Boolean false on failure, array on success.
* @param void
*/

function emoticons_initialise()
{
    static $emoticons_array = false;

    $webtag = get_webtag();

    if (!is_array($emoticons_array) || sizeof($emoticons_array) < 1) {

        // Get the user's emoticon set from their sesion.
        // Fall back to using the forum default or Beehive default.

        if (($user_emots = bh_session_get_value('EMOTICONS')) === false) {
            $user_emots = forum_get_setting('default_emoticons', false, 'default');
        }

        // Initialize the array incase it's not been done in
        // the definitions.php file by the emoticon authors.

        $emoticon = array();

        // If the user has emoticons set to none (hides them completely)
        // we need to load *all* the emoticon definition files so we can
        // strip them out.
        //
        // If the user has a set specified we load only that set.

        if ($user_emots == 'none') {

            if (($dir = @opendir('emoticons'))) {

                while (($file = @readdir($dir)) !== false) {

                    if (($file != '.' && $file != '..' && @is_dir("emoticons/$file"))) {

                        if (@file_exists("emoticons/$file/definitions.php")) {

                            include("emoticons/$file/definitions.php");
                        }
                    }
                }
            }

            if (forum_check_webtag_available($webtag)) {

                if (($dir = @opendir("forums/$webtag/emoticons"))) {

                    while (($file = @readdir($dir)) !== false) {

                        if (($file != '.' && $file != '..' && @is_dir("emoticons/$file"))) {

                            if (@file_exists("forums/$webtag/emoticons/$file/definitions.php")) {

                                include("forums/$webtag/emoticons/$file/definitions.php");
                            }
                        }
                    }
                }
            }

        }else {

            if (@is_dir("emoticons/$user_emots") && file_exists("emoticons/$user_emots/definitions.php")) {
                include ("emoticons/$user_emots/definitions.php");
            }

            if (forum_check_webtag_available($webtag)) {

                if (@is_dir("forums/$webtag/emoticons/$user_emots") && file_exists("forums/$webtag/emoticons/$user_emots/definitions.php")) {
                    include ("forums/$webtag/emoticons/$user_emots/definitions.php");
                }
            }
        }

        // Check that we have successfully loaded the emoticons.
        // If we have we need to process them a bit, otherwise
        // we bail out.

        if (sizeof($emoticon) > 0) {

            // Reverse the order of the keys and reset the
            // internal pointer.

            krsort($emoticon);
            reset($emoticon);

            // Set up our emoticon text array for display
            // of the selection box on post.php etc.

            $emoticon_text = array();

            // Group similar named emoticons together

            foreach ($emoticon as $key => $value) {
                $emoticon_text[$value][] = $key;
            }

            // Sort our array by key length so we don't have
            // the match text for emoticons inadvertantly matching
            // the wrong emoticon.

            uksort($emoticon, 'sort_by_length_callback');

            // Set our vars for the convert function

            $emoticons_array = $emoticon;
        }
    }

    return $emoticons_array;
}

/**
* Apply emoticons to content
*
* Applies the emoticons to the specified string. Automatically initialises the emoticons
* if not already done by the script.
*
* @return string
* @param string $content - string to convert
*/

function emoticons_apply($content)
{
    // Try and initialise the emoticons.

    if (!$emoticons_array = emoticons_initialise()) return $content;

    // PREG match for emoticons.

    $emoticon_preg_match = '(?<=\s|^|>)%s(?=\s|$|<)';

    // HTML code for emoticons.

    $emoticon_html_code = "<span class=\"e_%1\$s\" title=\"%2\$s\"><span class=\"e__\">%2\$s</span></span>";

    // Generate the HTML required for each emoticon.

    foreach ($emoticons_array as $key => $emoticon) {

        $key_encoded = htmlentities_array($key);

        if ($key != $key_encoded) {

            $pattern_string = sprintf($emoticon_preg_match, preg_quote($key_encoded, "/"));
            $replace_string = sprintf($emoticon_html_code, $emoticon, $key_encoded);

            $pattern_array[] = $pattern_string;
            $replace_array[$replace_string] = $key_encoded;
        }

        $pattern_string = sprintf($emoticon_preg_match, preg_quote($key, "/"));
        $replace_string = sprintf($emoticon_html_code, $emoticon, $key);

        $pattern_array[] = $pattern_string;
        $replace_array[$replace_string] = $key;
    }

    // Apply the emoticons to the content.

    $pattern_match = implode("|", $pattern_array);

    if (($content_array = preg_split("/($pattern_match)/u", $content, 100, PREG_SPLIT_DELIM_CAPTURE))) {

        foreach ($content_array as $key => $value) {

            if (($replace_string = array_search($value, $replace_array)) !== false) {

                $content_array[$key] = $replace_string;
            }
        }

        $content = implode('', $content_array);
    }

    // Return the content.

    return $content;
}

/**
* Get available emoticons.
*
* Retrieve a list of available emoticons on the Beehive installation.
* Optionally choose to include or exclude the text only and 'none'
* emoticon packs.
*
* @return array
* @param boolean $include_text_none - Set to false to exclude the text only / none packs.
*/

function emoticons_get_available($include_text_none = true)
{
    $emoticon_sets_normal = array();
    $emoticon_sets_txtnon = array();

    if ((@$dir = opendir('emoticons'))) {

        while ((@$file = readdir($dir)) !== false) {

            if ($file != '.' && $file != '..' && @is_dir("emoticons/$file")) {
                
                if ((@file_exists("emoticons/$file/style.css") && filesize("emoticons/$file/style.css") > 0) || (preg_match("/^none$|^text$/Diu", $file) > 0 && ($include_text_none === true))) { 
                
                    if (@file_exists("emoticons/$file/desc.txt")) {
                        $pack_name = implode('', file("emoticons/$file/desc.txt"));
                    }
                         
                    $pack_name = (isset($pack_name) && strlen(trim($pack_name)) > 0) ? $pack_name : $file;
                    $emoticon_sets_txtnon[$file] = htmlentities_array($pack_name);
                 }
             }
        }

        closedir($dir);
    }

    asort($emoticon_sets_normal);
    reset($emoticon_sets_normal);

    $available_sets = array_merge($emoticon_sets_txtnon, $emoticon_sets_normal);

    return $available_sets;
}

/**
* Emoticon Sort call back
*
* Call back function used to sort the emoticons into length. Prevents similar named
* but shorter emoticons from converting the longer match text of other emoticons.
* Used by uksort in emoticons_initialise function.
*
* @return boolean
* @param string $a - String to compare
* @param string $b - String to compare
*/

function sort_by_length_callback($a, $b)
{
    if ($a == $b) return 0;
    return (mb_strlen($a) > mb_strlen($b) ? -1 : 1);
}

/**
* Check emoticon set exists.
*
* Checks that the emoticon set's style.css actually exists on disk
*
* @return boolean
* @param string $emoticon_set - Emoticon set to check
*/

function emoticons_set_exists($emoticon_set)
{
    $emoticon_set = basename($emoticon_set);
    return (@file_exists("emoticons/$emoticon_set/style.css") || $emoticon_set == "text" || $emoticon_set == "none");
}

/**
* Preview emoticon pack
*
* Generates HTML for empoticon pack preview with clickable icons to add emoticon to form field.
*
* @return string
* @param string $emoticon_set - Emoticon set to preview
* @param string $width - Width in pixels of preview box
* @param string $height - Height in pixels of the preview box
* @param string $display_limit - Number of emoticons to show in preview.
*/

function emoticons_preview($emoticon_set, $width = 190, $height = 100, $display_limit = 35)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $emoticons_array = array();

    $emoticon_set = basename($emoticon_set);

    if (!emoticons_set_exists($emoticon_set)) {
        $emoticon_set = basename(forum_get_setting('default_emoticons', false, 'default'));
    }

    if ($emoticon_set != 'text' && $emoticon_set != 'none') {

        $emoticon = array();
        $emoticon_text = array();

        if (forum_check_webtag_available($webtag)) {

            if (@file_exists("forums/$webtag/emoticons/$emoticon_set/definitions.php")) {
                include ("forums/$webtag/emoticons/$emoticon_set/definitions.php");
            }elseif (@file_exists("emoticons/$emoticon_set/definitions.php")) {
                include("emoticons/$emoticon_set/definitions.php");
            }

        }else {

            if (@file_exists("emoticons/$emoticon_set/definitions.php")) {
                include("emoticons/$emoticon_set/definitions.php");
            }
        }

        if (sizeof($emoticon) > 0) {

            krsort($emoticon);
            reset($emoticon);

            $emoticon_text = array();

            foreach ($emoticon as $k => $v) {

                $emoticon_text[$v][] = $k;
            }
        }

        if (($style_contents = @file_get_contents("emoticons/$emoticon_set/style.css"))) {

            $style_matches = array();

            preg_match_all('/\.e_([\p{L}_]+) \{[^\}]*background-image\s*:\s*url\s*\(["\']\.?\/?([^"\']*)["\']\)[^\}]*\}/iu', $style_contents, $style_matches);

            for ($i = 0; $i < sizeof($style_matches[1]); $i++) {

                if (isset($emoticon_text[$style_matches[1][$i]])) {

                    $string_matches = array();

                    for ($j = 0; $j < sizeof($emoticon_text[$style_matches[1][$i]]); $j++) {
                        $string_matches[] = $emoticon_text[$style_matches[1][$i]][$j];
                    }

                    $emoticons_array[] = array('matches' => $string_matches,
                                               'text'    => $style_matches[1][$i],
                                               'img'     => $style_matches[2][$i]);
                }
            }
        }

        if (sizeof($emoticons_array) > 0) {

            array_multisort($emoticons_array, SORT_DESC);

            $html = "<div style=\"width: {$width}px; height: {$height}px\" class=\"emoticon_preview\">";

            for ($i = 0; $i < min(sizeof($emoticons_array), $display_limit); $i++) {

                $emot_tooltip_matches = array();

                foreach ($emoticons_array[$i]['matches'] as $emot_match) {
                    $emot_tooltip_matches[] = htmlentities_array($emot_match);
                }

                $emot_tip_text = trim(implode(" ", $emot_tooltip_matches));

                $emot_match = $emoticons_array[$i]['matches'][0];

                $emot_image = $emoticons_array[$i]['img'];

                $html.= sprintf('<img src="emoticons/%s/%s" alt="%s" title="%s" class="emoticon_preview_img" />', $emoticon_set, $emot_image, htmlentities_array($emot_match), $emot_tip_text);
            }

            if ($display_limit < sizeof($emoticons_array)) {

                $html.= "<div><b><a href=\"display_emoticons.php?webtag=$webtag&amp;pack=user\" target=\"_blank\" class=\"view_more\">{$lang['more']}</a></b></div>";
            }

            $html.= "</div>";

            return $html;
        }
    }

    return false;
}

?>