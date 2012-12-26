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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'browser.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';

function emoticons_initialise()
{
    static $emoticons_array = false;

    if (!is_array($emoticons_array) || sizeof($emoticons_array) < 1) {

        // Get the user's emoticon set from their sesion.
        // Fall back to using the forum default or Beehive default.
        if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {
            $user_emoticon_pack = $_SESSION['EMOTICONS'];
        } else {
            $user_emoticon_pack = forum_get_setting('default_emoticons', 'strlen', 'default');
        }

        // Initialize the array incase it's not been done in
        // the definitions.php file by the emoticon authors.
        $emoticon = array();

        // If the user has emoticons set to none (hides them completely)
        // we need to load *all* the emoticon definition files so we can
        // strip them out.
        //
        // If the user has a set specified we load only that set.
        if ($user_emoticon_pack == 'none') {

            if (($dir = @opendir('emoticons')) !== false) {

                while (($file = @readdir($dir)) !== false) {

                    if (($file != '.' && $file != '..' && @is_dir("emoticons/$file"))) {

                        if (@file_exists("emoticons/$file/definitions.php")) {

                            include("emoticons/$file/definitions.php");
                        }
                    }
                }
            }

        } else {

            if (@file_exists("emoticons/$user_emoticon_pack/definitions.php")) {
                include ("emoticons/$user_emoticon_pack/definitions.php");
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

function emoticons_apply($content)
{
    // Try and initialise the emoticons.
    if (!$emoticons_array = emoticons_initialise()) return $content;

    // PREG match for emoticons.
    $emoticon_preg_match = '/(?<=\s|^|>)%s(?=\s|$|<)/Uu';

    // HTML code for emoticons.
    $emoticon_html_code = "<span class=\"emoticon e_%1\$s\" title=\"%2\$s\"><span class=\"e__\">%2\$s</span></span>";

    // Generate the HTML required for each emoticon.
    foreach ($emoticons_array as $key => $emoticon) {

        $key_encoded = htmlentities_array($key);

        if ($key != $key_encoded) {

            $pattern_array[] = sprintf($emoticon_preg_match, preg_quote($key_encoded, "/"));
            $replace_array[] = sprintf($emoticon_html_code, $emoticon, $key_encoded);
        }

        $pattern_array[] = sprintf($emoticon_preg_match, preg_quote($key, "/"));
        $replace_array[] = sprintf($emoticon_html_code, $emoticon, $key_encoded);
    }

    $content = preg_replace($pattern_array, $replace_array, $content);

    // Return the content.
    return $content;
}

function emoticons_strip($content)
{
    return preg_replace(
        '/<span class="emoticon e_[^"]+" title="([^"]+)"><span class="e__">\1<\/span><\/span>/Uu',
        '$1',
        $content
    );
}

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

function sort_by_length_callback($a, $b)
{
    if ($a == $b) return 0;
    return (mb_strlen($a) > mb_strlen($b) ? -1 : 1);
}

function emoticons_set_exists($emoticon_set)
{
    $emoticon_set = basename($emoticon_set);
    return (@file_exists("emoticons/$emoticon_set/style.css") || $emoticon_set == "text" || $emoticon_set == "none");
}

function emoticons_preview($emoticon_set, $width = 190, $height = 100)
{
    $webtag = get_webtag();

    // Make sure the emoticon set has no path info.
    $emoticon_set = basename($emoticon_set);

    // Check the emoticon set exists.
    if (!emoticons_set_exists($emoticon_set)) {
        $emoticon_set = basename(forum_get_setting('default_emoticons', null, 'default'));
    }

    // No previews for text / no emoticons
    if (($emoticon_set == 'text') || ($emoticon_set == 'none')) return false;

    // Array to hold text to emoticon lookups.
    $emoticon = array();

    // Include the emoticon pack.
    if (@file_exists("emoticons/$emoticon_set/definitions.php")) {
        include("emoticons/$emoticon_set/definitions.php");
    }

    // Check it has some emoticons in it!
    if (sizeof($emoticon) == 0) return false;

    // Remove duplicate matches
    $emoticon = array_unique($emoticon);

    // HTML container
    $html = "<div style=\"width: {$width}px; height: {$height}px\" class=\"emoticon_preview\">";

    // Array to hold emoticon preview images
    $emoticon_preview = array();

    // Iterate over the emoticons and generate HTML
    foreach ($emoticon as $emot_text => $emot_class) {
        $emoticon_preview[] = sprintf('<span class="emoticon e_%1$s" title="%2$s"><span class="e__">%2$s</span></span>', $emot_class, $emot_text);
    }

    // Add the emoticons to the HTML.
    $html.= implode(' ', $emoticon_preview);

    // Close the container.
    $html.= "</div>";

    // Return the HTML.
    return $html;
}

?>