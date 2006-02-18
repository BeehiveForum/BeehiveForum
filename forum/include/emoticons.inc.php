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

/* $Id: emoticons.inc.php,v 1.55 2006-02-18 18:49:23 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// Emoticon filter file

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

class Emoticons
{
    var $emoticons;
    var $emoticons_text;
    var $pattern_array;
    var $replace_array;
    var $user_emots;

    function Emoticons ()
    {
        if (!isset($this->emoticons) || !is_array($this->emoticons) || sizeof($this->emoticons) == 0) {

            if (($user_emots = bh_session_get_value('EMOTICONS')) !== false) {
                $this->user_emots = $user_emots;
            }else {
                $this->user_emots = forum_get_setting('default_emoticons', false, 'default');
            }

            $emoticon = array();

            if ($this->user_emots == 'none') {

                if (@$dir = opendir('emoticons')) {

                    while (($file = @readdir($dir)) !== false) {

                        if ($file != '.' && $file != '..' && @is_dir("emoticons/$file")) {

                            if (@file_exists("./emoticons/$file/definitions.php")) {

                                include ("./emoticons/$file/definitions.php");
                            }
                        }
                    }
                }

            }else {

                if (@file_exists("./emoticons/{$this->user_emots}/definitions.php")) {
                    include ("./emoticons/{$this->user_emots}/definitions.php");
                }
            }

            if (sizeof($emoticon) > 0) {

                krsort($emoticon);
                reset($emoticon);

                $emoticon_text = array();

                foreach ($emoticon as $k => $v) {

                    $emoticon_text[$v][] = $k;
                }

                $pattern_array = array();
                $replace_array = array();

                $e_keys = array_keys($emoticon);

                for ($i = 0; $i < count($e_keys); $i++) {

                    for ($j = 0; $j < count($e_keys); $j++) {

                        if ($i != $j) {

                            if (($pos = strpos(strtolower($e_keys[$j]), strtolower($e_keys[$i]))) !== false) {

                                $a = $e_keys[$j];
                                $b = $e_keys[$i];
                                $v = $emoticon[$a];
                                $a2 = urlencode($a);

                                $a_f = preg_quote(substr($a, 0, $pos), "/");
                                $a_m = preg_quote(urlencode(substr($a, $pos, strlen($b))), "/");
                                $a_e = preg_quote(substr($a, $pos +strlen($b)), "/");

                                $pattern_array[] = "/". $a_f."<span class=[^>]+><span[^>]*>".$a_m."<\/span><\/span>".$a_e ."/";
                                $replace_array[] = "<span class=\"e_$v\" title=\"$a2\"><span class=\"e__\">$a2</span></span>";
                            }
                        }
                    }
                }

                $this->emoticons      = $emoticon;
                $this->emoticons_text = $emoticon_text;
                $this->pattern_array  = $pattern_array;
                $this->replace_array  = $replace_array;

            }else {

                // marker to show that there are no defined emoticons
                $this->emoticons = false;
            }
        }
    }

    function convert ($content)
    {
        if (!isset($this->emoticons) || !is_array($this->emoticons) || sizeof($this->emoticons) == 0) return $content;

        // Check for emoticon problems in Safari/Konqueror and Gecko based browsers like FireFox and Mozilla Suite

        $browser_fix = "</span>";

        if (isset($_SERVER['HTTP_USER_AGENT'])) {

            if (stristr($_SERVER['HTTP_USER_AGENT'], "konqueror") || stristr($_SERVER['HTTP_USER_AGENT'], "safari") || stristr($_SERVER['HTTP_USER_AGENT'], "MSIE 7")) {

                $browser_fix = "&nbsp;</span>";

            }else if (stristr($_SERVER['HTTP_USER_AGENT'], "gecko")) {

                $browser_fix = "</span> ";
            }
        }

        $front = "(?<=\s|^|>)";
        $end = "(?=\s|$|<)";

        foreach ($this->emoticons as $key => $emoticon) {

            $key_encoded = _htmlentities($key);

            if ($key != $key_encoded) {

                $pattern_string = "$front". preg_quote($key_encoded, "/"). "$end";
                $replace_string = "<span class=\"e_$emoticon\" title=\"$key_encoded\"><span class=\"e__\">$key_encoded</span>$browser_fix";

                $pattern_array[] = $pattern_string;
                $replace_array[$replace_string] = $key_encoded;
            }

            $pattern_string = "$front". preg_quote($key, "/"). "$end";
            $replace_string = "<span class=\"e_$emoticon\" title=\"$key\"><span class=\"e__\">$key</span>$browser_fix";

            $pattern_array[] = $pattern_string;
            $replace_array[$replace_string] = $key;
        }

        $pattern_match = implode("|", $pattern_array);

        if ($content_array = preg_split("/($pattern_match)/", $content, 100, PREG_SPLIT_DELIM_CAPTURE)) {

            foreach($content_array as $key => $value) {

                if (($replace_string = array_search($value, $replace_array)) !== false) {

                    $content_array[$key] = $replace_string;
                }
            }

            $content = implode('', $content_array);
        }

        return $content;
    }
}

function emoticons_get_available($include_text_none = true)
{
    $sets_normal = array();
    $sets_txtnon = array();

    if (@$dir = opendir('emoticons')) {

        while ((@$file = readdir($dir)) !== false) {

            if ($file != '.' && $file != '..' && @is_dir("emoticons/$file")) {

                 if (preg_match("/^none$|^text$/i", $file) > 0) {

                     if ($include_text_none === true) {

                         if (@file_exists("./emoticons/$file/desc.txt")) {

                             $pack_name = implode("", file("./emoticons/$file/desc.txt"));
                             $sets_txtnon[$file] = _htmlentities($pack_name);

                         }else {

                             $sets_txtnon[$file] = _htmlentities($file);
                         }
                     }

                 }else if (@file_exists("./emoticons/$file/style.css")) {

                     if (@file_exists("./emoticons/$file/desc.txt")) {

                         $pack_name = implode("", file("./emoticons/$file/desc.txt"));
                         $sets_normal[$file] = _htmlentities($pack_name);

                     }else {

                         $sets_normal[$file] = _htmlentities($file);
                     }
                 }
             }
        }

        closedir($dir);
    }

    asort($sets_normal);
    reset($sets_normal);

    $available_sets = array_merge($sets_txtnon, $sets_normal);

    return $available_sets;
}

function emoticons_set_exists($set)
{
    return (@file_exists("./emoticons/$set/style.css") || $set == "text" || $set == "none");
}

function emoticons_preview($set, $width=190, $height=100, $num = 35)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $emots_array = array();

    $str = "";

    if (!emoticons_set_exists($set)) {
        $set = forum_get_setting('default_emoticons', false, 'default');
    }

    if ($set != 'text' && $set != 'none') {

        $path = "./emoticons/$set";

        $emoticon = $emoticon_text = array();

        if (@file_exists("$path/definitions.php")) {
            include("$path/definitions.php");
        }

        if (count($emoticon) > 0) {

            krsort($emoticon);
            reset($emoticon);

            $emoticon_text = array();

            foreach ($emoticon as $k => $v) {

                $emoticon_text[$v][] = $k;
            }
        }

        if (@$fp = fopen("$path/style.css", "r")) {

            $style = fread($fp, filesize("$path/style.css"));

            preg_match_all("/\.e_([\w_]+) \{[^\}]*background-image\s*:\s*url\s*\([\"\']\.?\/?([^\"\']*)[\"\']\)[^\}]*\}/i", $style, $matches);

            for ($i = 0; $i < count($matches[1]); $i++) {

                if (isset($emoticon_text[$matches[1][$i]])) {

                    $string_matches = array();

                    for ($j = 0; $j < count($emoticon_text[$matches[1][$i]]); $j++) {

                        $string_matches[] = $emoticon_text[$matches[1][$i]][$j];
                    }

                    $emots_array[] = array('matches' => $string_matches,
                                           'text'    => $matches[1][$i],
                                           'img'     => $matches[2][$i]);
                }
            }
        }

        array_multisort($emots_array, SORT_DESC);

        $str.= "<div style=\"width: {$width}px; height: {$height}px\" class=\"emoticon_preview\">\n";

        for ($i = 0; $i < min(count($emots_array), $num); $i++) {

            $emot_tooltip_matches = array();

            foreach ($emots_array[$i]['matches'] as $key => $emot_match) {

                $emot_tooltip_matches[] = _htmlentities($emot_match);
            }

            $emot_tiptext = trim(implode(" ", $emot_tooltip_matches));

            $str.= "<img src=\"$path/{$emots_array[$i]['img']}\" alt=\"{$emot_tiptext}\" title=\"{$emot_tiptext}\" onclick=\"add_text(' ". rawurlencode($emots_array[$i]['matches'][0]) ." ');\" /> ";
        }

        if ($num < count($emots_array)) {
                $str.= " <b><a href=\"javascript:void(0)\" target=\"_self\" onclick=\"openEmoticons('user','$webtag');\">{$lang['more']}</a></b>";
        }

        $str.= "</div>";
    }

    return $str;
}

?>