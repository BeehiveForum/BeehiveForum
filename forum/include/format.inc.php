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

/* $Id: format.inc.php,v 1.67 2004-03-26 14:15:39 tribalonline Exp $ */

include_once("./include/word_filter.inc.php");

function format_user_name($u_logon, $u_nickname)
{
    if ($u_nickname != "") {
        if (strtoupper($u_logon) == strtoupper($u_nickname)) {
            $fmt = $u_nickname;
        } else {
            $fmt = _stripslashes($u_nickname) . " (" . _stripslashes(strtoupper($u_logon)) . ")";
        }
    }else {
        $fmt = strtoupper(_stripslashes($u_logon));
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


function format_url2link($html)
{
    $html = " ".$html;

    // URL:
    $html = preg_replace("/(\s|[()[\]{}])(\w+:\/\/([^:\s]+:?[^@\s]+@)?([-\w]+\.?)*(:\d+)?([\/?#]\S*)?\/?)/i", "$1<a href=\"$2\">$2</a>", $html);
    $html = preg_replace("/(\s|[()[\]{}])(www\.([-\w]+\.?)*(:\d+)?([\/?#]\S*)?\/?)/i", "$1<a href=\"http://$2\">$2</a>", $html);

    // MAIL:
    $html = preg_replace("/(\s|[()[\]{}])(mailto:)?([-\w]+(\.[-\w]+)*@([-\w]+\.)+([a-z]+|:\d+))/i", "$1<a href=\"mailto:$3\">$2$3</a>", $html);
       
    return substr($html, 1);
}

function format_time($time, $verbose = false, $custom_format = false)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC

    // Calculate $time in local timezone and current local time (the cookie bh_sess_tz = hours difference from GMT, West = negative)
    $local_time = $time + (bh_session_get_value('TIMEZONE') * HOUR_IN_SECONDS);
    $local_time_now = time() + (bh_session_get_value('TIMEZONE') * HOUR_IN_SECONDS);


    // Amend times for daylight saving if necessary (using critera for British Summer Time)
    if (bh_session_get_value('DL_SAVING')) {
        $local_time = timestamp_amend_bst($local_time);
        $local_time_now = timestamp_amend_bst($local_time_now);
    }

    if (gmdate("Y", $local_time) != gmdate("Y", $local_time_now)) {
        // time not this year
        if ($verbose) {
            $fmt = gmdate("j M Y", $local_time); // display day, month, and year
        } else {
            $fmt = gmdate("M Y", $local_time); // display month and year
        }
    } elseif ((gmdate("n", $local_time) != gmdate("n", $local_time_now)) || (gmdate("j", $local_time) != gmdate("j", $local_time_now))) {
        // time this year, but not today
        if ($verbose) {
            if (gmdate("Y", $local_time) != gmdate("Y", $local_time_now)) {
                $fmt = gmdate("j M Y H:i", $local_time); // display day, date, year, hours, and minutes
            }else {
                $fmt = gmdate("j M H:i", $local_time); // display day, date, hours, and minutes
            }
        } else {
            $fmt = gmdate("j M", $local_time); // display day and date only
        }
    } else {
        // time is today
        $fmt = gmdate("H:i", $local_time); // display hours and minutes
    }

    // Apply the custom format if any.

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
//
// NOTE: Requires PHP/4.1.0 or higher to support unicode

function _htmlentities($text)
{
    global $lang;

    return htmlspecialchars($text);

    // This bit below doesn't appear to work with
    // all PHP versions (?) and causes strangeness
    // with some character sets and non-alphanumeric
    // characters including the euro and pound (£)
    // sign.

    /*if (phpversion() >= "4.1.0") {
        return htmlentities($text, ENT_COMPAT, strtoupper($lang['_charset']));
    }else {
        return htmlentities($text, ENT_COMPAT);
    }*/
}

// Lazy reversal of _htmlentities
// (borrowed from: http://uk.php.net/manual/en/function.html-entity-decode.php)

function _htmlentities_decode($text)
{
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	$ret = strtr ($text, $trans_tbl);
	return preg_replace('/&#(\d+);/me', "chr('\\1')",$ret);
}

// Checks for Magic Quotes and perform stripslashes if nessecary

function _stripslashes($string)
{
    if (get_magic_quotes_gpc()) {
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
    if (bh_session_get_value('DL_SAVING')) {
        $local_time = timestamp_amend_bst(time() + (bh_session_get_value('TIMEZONE') * HOUR_IN_SECONDS));
    } else {
        $local_time = time() + (bh_session_get_value('TIMEZONE') * HOUR_IN_SECONDS);
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