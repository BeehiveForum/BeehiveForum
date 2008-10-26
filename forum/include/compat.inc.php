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

/* $Id: compat.inc.php,v 1.3 2008-10-26 16:46:27 decoyduck Exp $ */

/**
* compat.inc.php - Compatibility functions
*
* Contains functions for compatibility with older versions of PHP.
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

/**
* Wrapper function for mb_strlen.
*
* Gets the length of a string.
*
* @return integer - Number of characters in a string.
* @param string $str - The string being checked for length
*/

if (!function_exists('mb_strlen')) {

    function mb_strlen($str)
    {
        return strlen($str);
    }
}

/**
* Wrapper function for mb_strpos.
*
* Find position of first occurrence of string in a string.
*
* @return integer - the numeric position of the first occurrence of needle in haystack or FALSE if not found.
* @param string $haystack - The string being checked.
* @param string $needle - The string to find in haystack.
* @param integer $offset = The search offset. If it is not specified, 0 is used.
*/

if (!function_exists('mb_strpos')) {

    function mb_strpos($haystack, $needle, $offset = 0)
    {
        return strpos($haystack, $needle, $offset);
    }
}

/**
* Wrapper function for mb_strrpos.
*
* Find position of last occurrence of string in a string.
*
* @return integer - the numeric position of the last occurrence of needle in haystack or FALSE if not found.
* @param string $haystack - The string being checked.
* @param string $needle - The string to find in haystack.
* @param integer $offset = The search offset. If it is not specified, 0 is used.
*/

if (!function_exists('mb_strrpos')) {

    function mb_strrpos($haystack, $needle, $offset = 0)
    {
        return strrpos($haystack, $needle, $offset);
    }
}

/**
* Wrapper function for mb_stripos.
*
* Find position of first occurrence of string in a string, case insensitive.
*
* @return integer - the numeric position of the first occurrence of needle in haystack or FALSE if not found.
* @param string $haystack - The string being checked.
* @param string $needle - The string to find in haystack.
* @param integer $offset = The search offset. If it is not specified, 0 is used.
*/

if (!function_exists('mb_stripos')) {

    function mb_stripos($haystack, $needle, $offset = 0)
    {
        return stripos($haystack, $needle, $offset);
    }
}

/**
* Wrapper function for mb_substr.
*
* Get part of string
*
* @return string - the portion of str specified by the start and length parameters.
* @param string $str - The string being checked.
* @param string $start - The first position used in str.
* @param integer $length = The maximum length of the returned string.
*/

if (!function_exists('mb_substr')) {

    function mb_substr($str, $start, $length = null)
    {
        return is_null($length) ? substr($str, $start) : substr($str, $start, $length);
    }
}

/**
* Wrapper function for mb_strtolower.
*
* Make a string lowercase
*
* @return string - $str with all alphabetic characters converted to lowercase
* @param string $str - The string being lowercased.
*/

if (!function_exists('mb_strtolower')) {

    function mb_strtolower($str)
    {
        return strtolower($str);
    }
}

/**
* Wrapper function for mb_strtoupper.
*
* Make a string lowercase
*
* @return string - $str with all alphabetic characters converted to uppercase
* @param string $str - The string being uppercased.
*/

if (!function_exists('mb_strtoupper')) {

    function mb_strtoupper($str)
    {
        return strtoupper($str);
    }
}

/**
* Wrapper function for mb_substr_count.
*
* Count the number of substring occurrences
*
* @return integer - number of times $needle occurs in $haystack
* @param string $haystack - The string being checked.
* @param string $needle - The string to find in haystack.
*/

if (!function_exists('mb_substr_count')) {

    function mb_substr_count($haystack, $needle)
    {
        return substr_count($haystack, $needle);
    }
}

/**
* Wrapper function for mb_split.
*
* Split string using regular expression
*
* @return array
* @param string $pattern - Case sensitive regular expression.
* @param string $str - The input string
* @param integer $needle - If limit is set, the returned array will contain this maximum elements.
*/

if (!function_exists('mb_split')) {

    function mb_split($pattern, $str, $limit = null)
    {
        return is_null($limit) ? split($pattern, $str) : split($pattern, $str, $limit);
    }
}

?>