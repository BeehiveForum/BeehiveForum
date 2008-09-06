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

/* $Id: emoticons.inc.php,v 1.82 2008-09-06 20:13:56 decoyduck Exp $ */

/**
* emoticons.inc.php - emoticon functions
*
* Contains emoticon related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

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

            if (($dir = @opendir("forums/$webtag/emoticons"))) {

                while (($file = @readdir($dir)) !== false) {

                    if (($file != '.' && $file != '..' && @is_dir("emoticons/$file"))) {

                        if (@file_exists("forums/$webtag/emoticons/$file/definitions.php")) {

                            include("forums/$webtag/emoticons/$file/definitions.php");
                        }
                    }
                }
            }

        }else {

            if (@is_dir("emoticons/$user_emots") && file_exists("emoticons/$user_emots/definitions.php")) {
                include ("emoticons/$user_emots/definitions.php");
            }

            if (@is_dir("forums/$webtag/emoticons/$user_emots") && file_exists("forums/$webtag/emoticons/$user_emots/definitions.php")) {
                include ("forums/$webtag/emoticons/$user_emots/definitions.php");
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
* Get Browser fix for emoticons.
*
* Different browsers require different "fixes" to display the emoticons correctly.
* This function checks the User Agent string of the browser to check which is
* being used by the user.
*
* @return string
* @param void
*/

function emoticons_get_browser_fix()
{
    $emoticons_browser_fix = "</span>";

    if (isset($_SERVER['HTTP_USER_AGENT'])) {

        if (preg_match("/konqueror|safari|msie 7/iu", $_SERVER['HTTP_USER_AGENT']) > 0) {

            $emoticons_browser_fix = "&nbsp;</span>";

        }else if (preg_match("/gecko/iu", $_SERVER['HTTP_USER_AGENT']) > 0) {

            $emoticons_browser_fix = "</span>&nbsp;";
        }
    }

    return $emoticons_browser_fix;
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

    // Get the required browser fix for the client browser.

    $emoticon_browser_fix = emoticons_get_browser_fix();

    // PREG match for emoticons.

    $emoticon_preg_match = '(?<=\s|^|>)%s(?=\s|$|<)';

    // HTML code for emoticons.

    $emoticon_html_code = "<span class=\"e_%1\$s\" title=\"%2\$s\"><span class=\"e__\">%2\$s</span>%3\$s";

    // Generate the HTML required for each emoticon.

    foreach ($emoticons_array as $key => $emoticon) {

        $key_encoded = _htmlentities($key);

        if ($key != $key_encoded) {

            $pattern_string = sprintf($emoticon_preg_match, preg_quote($key_encoded, "/"));
            $replace_string = sprintf($emoticon_html_code, $emoticon, $key_encoded, $emoticon_browser_fix);

            $pattern_array[] = $pattern_string;
            $replace_array[$replace_string] = $key_encoded;
        }

        $pattern_string = sprintf($emoticon_preg_match, preg_quote($key, "/"));
        $replace_string = sprintf($emoticon_html_code, $emoticon, $key, $emoticon_browser_fix);

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

            if (($file != '.' && $file != '..' && @is_dir("emoticons/$file"))) {

                 if (preg_match("/^none$|^text$/Diu", $file) > 0) {

                     if ($include_text_none === true) {

                         if (@file_exists("emoticons/$file/desc.txt")) {

                             $pack_name = implode("", file("emoticons/$file/desc.txt"));
                             $emoticon_sets_txtnon[$file] = _htmlentities($pack_name);

                         }else {

                             $emoticon_sets_txtnon[$file] = _htmlentities($file);
                         }
                     }

                 }else if (@file_exists("emoticons/$file/style.css")) {

                     if (@file_exists("emoticons/$file/desc.txt")) {

                         $pack_name = implode("", file("emoticons/$file/desc.txt"));
                         $emoticon_sets_normal[$file] = _htmlentities($pack_name);

                     }else {

                         $emoticon_sets_normal[$file] = _htmlentities($file);
                     }
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
    return (strlen($a) > strlen($b) ? -1 : 1);
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
* @param string $num - Number of emoticons to show in preview.
*/

function emoticons_preview($emoticon_set, $width = 190, $height = 100, $num = 35)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $html = '';

    $emoticons_array = array();

    $emoticon_set = basename($emoticon_set);

    if (!emoticons_set_exists($emoticon_set)) {
        $emoticon_set = basename(forum_get_setting('default_emoticons', false, 'default'));
    }

    if ($emoticon_set != 'text' && $emoticon_set != 'none') {

        $emoticon = array();
        $emoticon_text = array();

        if (@file_exists("emoticons/$emoticon_set/definitions.php")) {
            include("emoticons/$emoticon_set/definitions.php");
        }

        if (count($emoticon) > 0) {

            krsort($emoticon);
            reset($emoticon);

            $emoticon_text = array();

            foreach ($emoticon as $k => $v) {

                $emoticon_text[$v][] = $k;
            }
        }

        if (($style_contents = @file_get_contents("emoticons/$emoticon_set/style.css"))) {

            $style_matches = array();

            preg_match_all('/\.e_([\w_]+) \{[^\}]*background-image\s*:\s*url\s*\(["\']\.?\/?([^"\']*)["\']\)[^\}]*\}/iu', $style_contents, $style_matches);

            for ($i = 0; $i < count($style_matches[1]); $i++) {

                if (isset($emoticon_text[$style_matches[1][$i]])) {

                    $string_matches = array();

                    for ($j = 0; $j < count($emoticon_text[$style_matches[1][$i]]); $j++) {
                        $string_matches[] = $emoticon_text[$style_matches[1][$i]][$j];
                    }

                    $emoticons_array[] = array('matches' => $string_matches,
                                               'text'    => $style_matches[1][$i],
                                               'img'     => $style_matches[2][$i]);
                }
            }
        }

        array_multisort($emoticons_array, SORT_DESC);

        $html.= "<div style=\"width: {$width}px; height: {$height}px\" class=\"emoticon_preview\">";

        for ($i = 0; $i < min(count($emoticons_array), $num); $i++) {

            $emot_tooltip_matches = array();

            foreach ($emoticons_array[$i]['matches'] as $emot_match) {
                $emot_tooltip_matches[] = _htmlentities($emot_match);
            }

            $emot_tiptext = trim(implode(" ", $emot_tooltip_matches));

            $html.= "<img src=\"emoticons/$emoticon_set/{$emoticons_array[$i]['img']}\" alt=\"{$emot_tiptext}\" title=\"{$emot_tiptext}\" onclick=\"add_text(' ". html_js_safe_str($emoticons_array[$i]['matches'][0]) ." ');\" /> ";
        }

        if ($num < count($emoticons_array)) {

            $html.= " <b><a href=\"display_emoticons.php?webtag=$webtag&amp;pack=user\" target=\"_blank\" onclick=\"return openEmoticons('user','$webtag');\">{$lang['more']}</a></b>";
        }

        $html.= "</div>";
    }

    return $html;
}

?>