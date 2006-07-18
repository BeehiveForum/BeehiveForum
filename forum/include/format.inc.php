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

/* $Id: format.inc.php,v 1.113 2006-07-18 20:16:43 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function format_user_name($u_logon, $u_nickname)
{
    if ($u_nickname != "") {

        if (strtoupper($u_logon) == strtoupper($u_nickname)) {

            $fmt = $u_nickname;

        }else {

            $fmt = $u_nickname. " (". strtoupper($u_logon). ")";
        }

    }else {

        $fmt = strtoupper($u_logon);
    }

    return apply_wordfilter($fmt);
}

function format_file_size($size)
{
    $megabyte = 1024 * 1024;

    if ($size >= $megabyte) {
        $resized = round($size / $megabyte, 1). " MB";
    }else if ($size >= 1024) {
        $resized = round($size / 1024, 1). " KB";
    }else{
        $resized = $size. " bytes";
    }

    return $resized;
}

function format_time($time, $verbose = false)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC

    $lang = load_language_file();

    if (!$timezone = bh_session_get_value('TIMEZONE')) {
        $timezone = forum_get_setting('forum_timezone', false, 0);
    }

    if (!$dl_saving = bh_session_get_value('DL_SAVING')) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    // Calculate $time in local timezone and current local time

    $local_time = $time + ($timezone * HOUR_IN_SECONDS);
    $local_time_now = time() + ($timezone * HOUR_IN_SECONDS);

    // Amend times for daylight saving if necessary (using critera for British Summer Time)

    if ($dl_saving == "Y") {

        $local_time = timestamp_amend_bst($local_time);
        $local_time_now = timestamp_amend_bst($local_time_now);
    }

    // Get the numerical for the dates to convert

    $date_string = gmdate("s i G j n Y", $local_time);
    list($sec, $min, $hour, $day, $month, $year) = explode(" ", $date_string);

    // We only ever use the month as a string

    $month_str = $lang['month_short'][$month];

    if ($year != gmdate("Y", $local_time_now)) {

        if ($verbose) {
            $fmt = sprintf($lang['daymonthyear'], $day, $month_str, $year); // j M Y
        }else {
            $fmt = sprintf($lang['monthyear'], $month_str, $year); // M Y
        }

    }elseif (($month != gmdate("n", $local_time_now)) || ($day != gmdate("j", $local_time_now))) {

        if ($verbose) {

            if ($year != gmdate("Y", $local_time_now)) {
                $fmt = sprintf($lang['daymonthyearhourminute'], $day, $month_str, $year, $hour, $min); // j M Y H:i
            }else {
                $fmt = sprintf($lang['daymonthhourminute'], $day, $month_str, $hour, $min); // j M H:i
            }

        }else {

            $fmt = sprintf($lang['daymonth'], $day, $month_str); // j M
        }

    }else {

        $fmt = sprintf($lang['hourminute'], $hour, $min); // H:i
    }

    return $fmt;
}

function format_time_display($seconds)
{        
    $periods_array = array ('y' => 31556926, 'm' => 2629743,
                            'w' => 604800,   'd' => 86400,
                            'hr' => 3600,    'min' => 60,
                            'sec' => 1);
  
    $seconds = (float) $seconds;

    foreach ($periods_array as $period => $value) {

        if (($count = floor($seconds / $value)) > 0) {

            $values_array[] = "{$count}{$period}";
        }

        $seconds = $seconds % $value;
    }
  
    return implode(" ", $values_array);
}

function timestamp_to_date($timestamp)
{
    $year=substr($timestamp,0,4);
    $month=substr($timestamp,4,2);
    $day=substr($timestamp,6,2);
    $hour=substr($timestamp,8,2);
    $minute=substr($timestamp,10,2);
    $second=substr($timestamp,12,2);
    $newdate=mktime($hour,$minute,$second,$month,$day,$year);
    return ($newdate);
}


function timestamp_amend_bst($timestamp)
{
    $year = date("Y", mktime());

    $ldmarw = date("w", mktime(2, 0, 0, 4,  0, $year));
    $ldoctw = date("w", mktime(2, 0, 0, 11, 0, $year));
    $ldmard = date("d", mktime(2, 0, 0, 4,  0, $year));
    $ldoctd = date("d", mktime(2, 0, 0, 11, 0, $year));

    if ($ldmarw > 0) $ldmard = $ldmard - $ldmarw;
    if ($ldoctw > 0) $ldoctd = $ldoctd - $ldoctw;

    $startofbst = mktime(2, 0, 0, 3,  $ldmard, $year);
    $endofbst   = mktime(2, 0, 0, 10, $ldoctd, $year);

    if (($timestamp > $startofbst) && ($timestamp < $endofbst)) {
        return $timestamp + 3600;  // return adjusted timestamp
    }else{
        return $timestamp; // return unadjusted timestamp
    }
}

// Lazy htmlentities function which ensures the use of
// unicode for all character code sets.

function _htmlentities($text)
{
    return htmlentities($text, ENT_COMPAT, 'UTF-8');
}

// Lazy / replacement for htmlentities_decode(). Should be
// UTF-8 compliant but probably isn't.

function _htmlentities_decode($text)
{
    $trans_tbl = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
    $trans_tbl = array_flip($trans_tbl);

    $trans_tbl['&apos;'] = '\'';
    $trans_tbl['&#039;'] = '\'';

    unset($trans_tbl['&#39;']);

    $ret = strtr($text, $trans_tbl);
    $ret = preg_replace('/&#(\d+);/me', "chr(\\1)", $ret);
    return preg_replace('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $ret);
}

// Translate &nbsp; to &#160; etc. If translation of entity fails
// (i.e. no change is noticed after pass through _htmlentities_decode()
// function the unaltered entity is returned.

function xml_literal_to_numeric($literal)
{
    if (preg_match("/&#[0-9]+;/", $literal) > 0) return $literal;

    $html_entity  = _htmlentities_decode($literal);
    if ($literal == $html_entity) return $html_entity;

    $numeric = ord($html_entity);

    return "&#$numeric;";
}

// Checks for Magic Quotes and perform stripslashes if nessecary

function _stripslashes($string)
{
    if (get_magic_quotes_gpc() == 1) {
        return stripslashes($string);
    }else {
        return $string;
    }
}

// Case insensitive / multi-dimensional replacement for array_search.

function _array_search($needle, $haystack)
{
    foreach ($haystack as $key => $value) {
        if (is_array($value)) {
            return _array_search($needle, $value);
        }else {
            if (strtolower($needle) == strtolower($value)) {
                return $key;
            }
        }
    }
    return false;
}

// Split an array into a multi-dimensional array.
// PHP 4 >= 4.2.0, PHP 5 already include this function.

function _array_chunk($input_array, $size = 1, $preserve_keys = false) {

   if (!is_array($input_array)) return false;
   if (!is_numeric($size) || $size < 1) return false;
   if (!is_bool($preserve_keys)) $preserve_keys = false;

   reset($input_array);

   $i = 0;

   $chunks_array = array();

   foreach($input_array as $key => $value) {

       if (!isset($chunks_array[$i])) $chunks_array[$i] = array();
       if (sizeof($chunks_array[$i]) >= $size) $i++;

       if ($preserve_keys) {

           $chunks_array[$i][$key] = $value;

       }else {

           $chunks_array[$i][] = $value;
       }
   }

   return $chunks_array;
}

// is_md5 validates an md5 hash to make sure it is correctly
// formed (i.e. letters A to F and numbers only and a length
// of 32 chars).

function is_md5($hash)
{
    if (preg_match("/^[A-Fa-f0-9]{32}$/", $hash) > 0) {
        return true;
    }

    return false;
}

function get_local_time()
{
    if (!$timezone = bh_session_get_value('TIMEZONE')) {
        $timezone = forum_get_setting('forum_timezone', false, 0);
    }

    if (!$dl_saving = bh_session_get_value('DL_SAVING')) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    if ($dl_saving == "Y") {
        $local_time = timestamp_amend_bst(time() + ($timezone * HOUR_IN_SECONDS));
    }else {
        $local_time = time() + ($timezone * HOUR_IN_SECONDS);
    }

    return $local_time;
}

function format_age($dob) // $dob is a MySQL-type DATE field (YYYY-MM-DD)
{
    $local_time = get_local_time();

    $todays_date = date("j", $local_time);
    $todays_month = date("n", $local_time);
    $todays_year = date("Y", $local_time);

    $birthday = explode("-", $dob);

    $age = $todays_year - $birthday[0];
    if (($todays_month < $birthday[1]) || (($todays_month == $birthday[1]) && ($todays_date < $birthday[2])) ) $age -= 1;

    return $age;
}

function format_birthday($date) // $date is a MySQL-type DATE field (YYYY-MM-DD)
{
    $date_bits = explode("-", $date);
    $local_time = get_local_time();
    $todays_date = date("j", $local_time);
    $todays_month = date("n", $local_time);
    if (($todays_month < $date_bits[1]) && ($todays_date < $date_bits[2])) {
        $year = date("Y", $local_time);
    } else {
        $year = date("Y", $local_time) + 1;
    }

    return date("j M", mktime(0, 0, 0, $date_bits[1], $date_bits[2], $year));
}

function split_url($url, $inc_path = false, $inc_query = false, $inc_fragment = false)
{
    if ($url_parts = @parse_url($url)) {
        
        if (!isset($url_parts['scheme'])) return false;
        if (!isset($url_parts['host'])) return false;

        $url_split = "{$url_parts['scheme']}://{$url_parts['host']}/";

        if ($inc_path === true) $url_split.= "{$url_parts['path']}";
        if ($inc_query === true) $url_split.= "{$url_parts['query']}";
        if ($inc_fragment === true) $url_split.= "{$url_parts['fragment']}";

        return $url_split;
    }

    return false;
}

?>