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

// Compress the output
require_once("./include/gzipenc.inc.php");

function format_user_name($u_logon,$u_nickname)
{
    if($u_nickname != ""){
        if(strtoupper($u_logon) == strtoupper($u_nickname)){
            $fmt = $u_nickname;
        } else {
            $fmt = $u_nickname . " (" . strtoupper($u_logon) . ")";
        }
    } else {
        $fmt = strtoupper($u_logon);
    }

    return $fmt;
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
	$html = preg_replace("/(\s|[()[\]{}])(\w+:\/\/([^:\s]+:?[^@\s]+@)?([-\w]+\.)*[-\w]+(:\d+)?([\/?#]\S*)?\w+\/?)/i",
		"$1<a href=\"$2\">$2</a>", $html);
	$html = preg_replace("/(\s|[()[\]{}])(www\.([-\w]+\.)*[-\w]+(:\d+)?([\/?#]\S*)?\w+\/?)/i",
		"$1<a href=\"http://$2\">$2</a>", $html);
	// MAIL:
	$html = preg_replace("/(\s|[()[\]{}])(mailto:)?([-\w]+(\.[-\w]+)*@([-\w]+\.)+([a-z]+|:\d+))/i",
		"$1<a href=\"mailto:$3\">$2$3</a>", $html);
	return substr($html, 1);
}


function format_time($time, $verbose = 0)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC


    include_once("./include/constants.inc.php");
    global $HTTP_COOKIE_VARS;


    // Calculate $time in local timezone and current local time (the cookie bh_sess_tz = hours difference from GMT, West = negative)
    $local_time = $time + ($HTTP_COOKIE_VARS['bh_sess_tz'] * HOUR_IN_SECONDS);
    $local_time_now = time() + ($HTTP_COOKIE_VARS['bh_sess_tz'] * HOUR_IN_SECONDS);


    // Amend times for daylight saving if necessary (using critera for British Summer Time)
    if ($HTTP_COOKIE_VARS['bh_sess_dlsav']) $local_time = timestamp_amend_bst($local_time);
    if ($HTTP_COOKIE_VARS['bh_sess_dlsav']) $local_time_now = timestamp_amend_bst($local_time_now);


    if ((gmdate("Y", $local_time) != gmdate("Y", $local_time_now)) || (gmdate("n", $local_time) != gmdate("n", $local_time_now)) || (gmdate("j", $local_time) != gmdate("j", $local_time_now))) {
        // time not today
        if ($verbose) {
            $fmt = gmdate("j M H:i", $local_time); // display day, date, hours, and minutes
        } else {
            $fmt = gmdate("j M", $local_time); // display day and date only
        }
    } else {
        $fmt = gmdate("H:i", $local_time); // time is today, display hours and minutes
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

// Performs the reverse of htmlspecialchars

function htmlspecialchars_reverse($text)
{

    $search = array ("'&(quote|#34);'i", "'&(amp|#38);'i", "'&(lt|#60);'i", "'&(gt|#62);'i",
                     "'&(nbsp|#160);'i", "'&(iexcl|#161);'i", "'&(cent|#162);'i", "'&(pound|#163);'i",
                     "'&(copy|#169);'i");

    $replace = array ("\"", "&", "<", ">", " ", chr(161), chr(162), chr(163), chr(169));
    $retval = preg_replace ($search, $replace, $text);

    return $retval;

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

// Checks for Magic Quotes and perform addslashes if nessecary

function _addslashes($string)
{

  if (get_magic_quotes_gpc() == 1) {
    return $string;
  }else {
    return addslashes($string);
  }

}

?>