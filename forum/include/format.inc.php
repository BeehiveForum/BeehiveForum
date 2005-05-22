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

/* $Id: format.inc.php,v 1.95 2005-05-22 08:21:42 decoyduck Exp $ */

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

function format_time($time, $verbose = false, $custom_format = false)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC

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

    if (gmdate("Y", $local_time) != gmdate("Y", $local_time_now)) {

        if ($verbose) {
            $fmt = gmdate("j M Y", $local_time);
        } else {
            $fmt = gmdate("M Y", $local_time);
        }

    }elseif ((gmdate("n", $local_time) != gmdate("n", $local_time_now)) || (gmdate("j", $local_time) != gmdate("j", $local_time_now))) {

        if ($verbose) {

            if (gmdate("Y", $local_time) != gmdate("Y", $local_time_now)) {
                $fmt = gmdate("j M Y H:i", $local_time);
            }else {
                $fmt = gmdate("j M H:i", $local_time);
            }

        }else {

            $fmt = gmdate("j M", $local_time);
        }

    }else {

        $fmt = gmdate("H:i", $local_time);
    }

    if ($custom_format) {

        $fmt = gmdate($custom_format, $local_time);
    }

    return $fmt;
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
    $year = date("Y", gmmktime());

    $ldmarw = date("w", gmmktime(2, 0, 0, 4,  0, $year));
    $ldoctw = date("w", gmmktime(2, 0, 0, 11, 0, $year));
    $ldmard = date("d", gmmktime(2, 0, 0, 4,  0, $year));
    $ldoctd = date("d", gmmktime(2, 0, 0, 11, 0, $year));

    if ($ldmarw > 0) $ldmard = $ldmard - $ldmarw;
    if ($ldoctw > 0) $ldoctd = $ldoctd - $ldoctw;

    $startofbst = gmmktime(2, 0, 0, 3,  $ldmard, $year);
    $endofbst   = gmmktime(2, 0, 0, 10, $ldoctd, $year);

    if (($timestamp > $startofbst) && ($timestamp < $endofbst)) {
        return $timestamp + 3600;  // return adjusted timestamp
    }else{
        return $timestamp; // return unadjusted timestamp
    }
}

// Used by _htmlentities_decode() to convert &#1242; style HTML
// entities into utf-8 characters.

function html_numerals_to_utf8($ord)
{
    if (preg_match('/^x([0-9a-f]+)$/i', $ord, $match)) {
        $ord = hexdec($match[1]);
    }else {
        $ord = intval($ord);
    }

    $no_bytes = 0;
    $byte = array();

    if ($ord < 128) {
       return chr($ord);
    }elseif ($ord < 2048) {
       $no_bytes = 2;
    }elseif ($ord < 65536) {
       $no_bytes = 3;
    }elseif ($ord < 1114112) {
       $no_bytes = 4;
    }else {
       return;
    }

    switch($no_bytes) {
        case 2:
            $prefix = array(31, 192);
            break;
        case 3:
            $prefix = array(15, 224);
            break;
        case 4:
            $prefix = array(7, 240);
    }

    for ($i = 0; $i < $no_bytes; $i++) {
       $byte[$no_bytes - $i - 1] = (($ord & (63 * pow(2, 6 * $i))) / pow(2, 6 * $i)) & 63 | 128;
    }

    $byte[0] = ($byte[0] & $prefix[0]) | $prefix[1];

    $ret = '';

    for ($i = 0; $i < $no_bytes; $i++) {
       $ret.= chr($byte[$i]);
    }

    return $ret;
}

// Lazy htmlentities function which ensures the use of
// unicode for all character code sets.

function _htmlentities($text)
{
    return htmlentities($text, ENT_QUOTES, 'UTF-8');
}

// Lazy / replacement for htmlentities_decode(). Should be
// UTF-8 compliant but probably isn't.

function _htmlentities_decode($text)
{
    $trans_tbl = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
    $trans_tbl = array_flip($trans_tbl);

    $trans_tbl['&apos;'] = '\'';

    $ret = strtr($text, $trans_tbl);
    return preg_replace('/&#([0-9a-fx]+);/me', "html_numerals_to_utf8(\\1)", $ret);
}

// Translate &nbsp; to &#160; etc. Pass the literal without the
// leading &# and trailing ;, i.e. nbsp, gt, lt.

function xml_literal_to_numeric($literal)
{
    if (preg_match("/&#[0-9]+;/", $literal)) return $literal;

    $entity  = _htmlentities_decode($literal);
    $numeric = ord($entity);

    return "&#$numeric;";
}

// Converts MS Word quotes to HTML/XML friendly entities

function ms_word_to_html($string)
{
    $char_array = array(128 => '&euro;',   130 => '&sbquo;',
                        131 => '&fnof;',   132 => '&bdquo;',
                        133 => '&hellip;', 134 => '&dagger;',
                        135 => '&Dagger;', 136 => '&circ;',
                        137 => '&permil;', 138 => '&Scaron;',
                        139 => '&lsaquo;', 140 => '&OElig;',
                        145 => '&lsquo;',  146 => '&rsquo;',
                        147 => '&ldquo;',  148 => '&rdquo;',
                        149 => '&bull;',   150 => '&ndash;',
                        151 => '&mdash;',  152 => '&tilde;',
                        153 => '&trade;',  154 => '&scaron;',
                        155 => '&rsaquo;', 156 => '&oelig;',
                        159 => '&Yuml;');

   return str_replace(array_map('chr', array_keys($char_array)), $char_array, $string);
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

// Case insensitive / multi-dimensional replacement for in_array.

function _in_array($needle, $haystack)
{
    if (!is_array($haystack)) return false;

    foreach ($haystack as $key => $value) {
        if (is_array($value)) {
            return _in_array($needle, $value);
        }else {
            if (strtolower($needle) == strtolower($value)) {
                return true;
            }
        }
    }
    return false;
}

// is_md5 validates an md5 hash to make sure it is correctly
// formed (i.e. letters A to F and numbers only and a length
// of 32 chars).

function is_md5($hash)
{
    if (preg_match("/^[A-Fa-f0-9]{32}$/", $hash)) {
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

?>