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

/* $Id: compat.inc.php,v 1.5 2008-12-15 21:18:09 decoyduck Exp $ */

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
* Wrapper function for mb_send_mail.
*
* Send mail.
*
* @return boolean
* @param string $to - Receiver, or receivers of the mail
* @param string $subject - Subject of the email to be sent.
* @param string $message - Message to be sent.
* @param string $additional_headers - String to be inserted at the end of the email header.
* @param string $additional_parameters - Additional parameter to send to the program configured to use when sending mail.
*/

if (!function_exists('mb_send_mail')) {

    function mb_send_mail($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
    {
        return mail($to, $subject, $message, $additional_headers, $additional_parameters);
    }
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

/**
* Wrapper function for mb_ereg.
*
* Regular expression match
*
* @return array
* @param string $pattern - Case sensitive regular expression.
* @param string $str - The input string
* @param integer $regs - Optional - matches found for parenthesized substrings of pattern (by-ref)
*/

if (!function_exists('mb_ereg')) {

    function mb_ereg($pattern, $str, &$regs = array())
    {
        return ereg($pattern, $str, $regs);
    }
}

/**
* Wrapper function for mb_eregi.
*
* Regular expression match
*
* @return array
* @param string $pattern - Case insensitive regular expression.
* @param string $str - The input string
* @param integer $regs - Optional - matches found for parenthesized substrings of pattern (by-ref)
*/

if (!function_exists('mb_eregi')) {

    function mb_eregi($pattern, $str, &$regs = array())
    {
        return eregi($pattern, $str, $regs);
    }
}

/**
* Wrapper function for mb_ereg_replace.
*
* Replace regular expression case sensitive
*
* @return array
* @param string $pattern - A POSIX extended regular expression.
* @param string $replacement - Replacements for parenthesized substring matches in pattern
* @param integer $string - The input string.
*/

if (!function_exists('mb_ereg_replace')) {

    function mb_ereg_replace($pattern, $replacement, $string)
    {
        return ereg_replace($pattern, $replacement, $string);
    }
}

/**
* Wrapper function for mb_eregi_replace.
*
* Replace regular expression case insensitive
*
* @return array
* @param string $pattern - A POSIX extended regular expression.
* @param string $replacement - Replacements for parenthesized substring matches in pattern
* @param integer $string - The input string.
*/

if (!function_exists('mb_eregi_replace')) {

    function mb_eregi_replace($pattern, $replacement, $string)
    {
        return eregi_replace($pattern, $replacement, $string);
    }
}

/**
* Wrapper function for sys_get_temp_dir.
*
* Returns the path of the directory PHP stores temporary files in by default.
*
* @return string - The path of the temporary directory
* @param void
*/

if (!function_exists('sys_get_temp_dir')) {

    function sys_get_temp_dir()
    {
        if (!empty($_ENV['TMP'])) return realpath($_ENV['TMP']);
        if (!empty($_ENV['TMPDIR'])) return realpath( $_ENV['TMPDIR']);
        if (!empty($_ENV['TEMP'])) return realpath( $_ENV['TEMP']);
     
        $temp_file = tempnam(uniqid(rand(), true), '');
      
        if (file_exists($temp_file)) {
      
            unlink($temp_file);
            return realpath(dirname($temp_file));
        }
    }
}

/**
* Wrapper function for file_put_contents.
*
* Write a string to a file
*
* @return mixed - The number of bytes written of false on failure
* @param string $file - Path to the file where to write the data. 
* @param string $data - The data to write
* @param integer $flags - Set flags to FILE_APPEND to append the content to the file.

*/

if (!function_exists('file_put_contents')) {

    if (!defined('FILE_APPEND')) define('FILE_APPEND', 1);

    function file_put_contents($file, $data, $flags = false)
    {
        $mode = ($flags == FILE_APPEND || strtoupper($flags) == 'FILE_APPEND') ? 'a' : 'w';

        if (($fp = @fopen($file, $mode)) !== false) {

            if (is_array($data)) $data = implode($data);

            $bytes = fwrite($fp, $data);

            fclose($fp);

            return $bytes;
        }

        return false;
    }
}

/**
* Wrapper function for array_combine.
*
* Creates an array by using one array for keys and another for its values
*
* @return mixed - Returns the combined array, FALSE if the number of elements for each array isn't equal or if the arrays are empty. 
* @param array $input_array_1 - Array of keys to be used.
* @param array $input_array_2 - Array of values to be used.
* @param integer $flags - Set flags to FILE_APPEND to append the content to the file.

*/

if (!function_exists('array_combine')) {

    function array_combine($input_array_1, $input_array_2) 
    {
        $output_array = array();
   
        $input_array_1 = array_values($input_array_1);
        $input_array_2 = array_values($input_array_2);
        
        if (sizeof($input_array_1) < 1) return false;
        if (sizeof($input_array_2) < 1) return false;
        
        if (sizeof($input_array_1) == sizeof($input_array_2)) {
   
            foreach($input_array_1 as $key => $value) {
                $output_array[(string)$value] = $input_array_2[$key];
            }

            return $output_array;
        }
    }
}

?>