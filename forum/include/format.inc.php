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

/* $Id: format.inc.php,v 1.132 2007-04-15 17:07:57 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function format_user_name($u_logon, $u_nickname)
{
    if (strlen($u_nickname) > 0) {

        if (strtoupper($u_logon) == strtoupper($u_nickname)) {

            $fmt = $u_nickname;

        }else {

            $fmt = $u_nickname. " (". strtoupper($u_logon). ")";
        }

    }else {

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

/**
* Format time display
*
* Formats time display from a UNIX timestamp to one of:
*
* j M Y, M Y, j M Y H:i, j M H:i, j M, or H:i
*
* Output depends on current server time but can be overideen using $verbose function argument.
*
* @return string
* @param integer $timestamp - UNIX timestamp
* @param boolean $verbose - Force display of year / month even if the same as current server time.
*/

function format_time($time, $verbose = false)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC

    $lang = load_language_file();

    if (!$timezone_id = bh_session_get_value('TIMEZONE')) {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (!$gmt_offset = bh_session_get_value('GMT_OFFSET')) {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (!$dst_offset = bh_session_get_value('DST_OFFSET')) {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (!$dl_saving = bh_session_get_value('DL_SAVING')) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    // Calculate $time in local timezone and current local time

    $local_time = $time + ($gmt_offset * HOUR_IN_SECONDS);
    $local_time_now = time() + ($gmt_offset * HOUR_IN_SECONDS);

    // Amend times for daylight saving if necessary

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {

        $local_time = $local_time + ($dst_offset * HOUR_IN_SECONDS);
        $local_time_now = $local_time_now + ($dst_offset * HOUR_IN_SECONDS);
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

        if ($verbose) {
            $fmt = sprintf($lang['daymonth'], $day, $month_str); // H:i
        }else {
            $fmt = sprintf($lang['hourminute'], $hour, $min); // H:i
        }
    }

    return $fmt;
}

/**
* Format date display
*
* Formats date display from a UNIX timestamp to either d/m or d/m/y if not current year.
*
* @return string
* @param integer $timestamp - UNIX timestamp
*/

function format_date($time)
{
    $lang = load_language_file();

    if (!$timezone_id = bh_session_get_value('TIMEZONE')) {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (!$gmt_offset = bh_session_get_value('GMT_OFFSET')) {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (!$dst_offset = bh_session_get_value('DST_OFFSET')) {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (!$dl_saving = bh_session_get_value('DL_SAVING')) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    // Calculate $time in local timezone and current local time

    $local_time = $time + ($gmt_offset * HOUR_IN_SECONDS);
    $local_time_now = time() + ($gmt_offset * HOUR_IN_SECONDS);

    // Amend times for daylight saving if necessary

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {

        $local_time = $local_time + ($dst_offset * HOUR_IN_SECONDS);
        $local_time_now = $local_time_now + ($dst_offset * HOUR_IN_SECONDS);
    }

    // Get the numerical for the dates to convert

    $date_string = gmdate("s i G j n Y", $local_time);
    list($sec, $min, $hour, $day, $month, $year) = explode(" ", $date_string);

    // We only ever use the month as a string

    $month_str = $lang['month_short'][$month];

    if ($year != gmdate("Y", $local_time_now)) {

        $fmt = sprintf($lang['daymonthyear'], $day, $month_str, $year); // j M Y

    }else {

        $fmt = sprintf($lang['daymonth'], $day, $month_str); // j M
    }

    return $fmt;
}

function format_time_display($seconds, $abbrv_units = true)
{        
    $lang = load_language_file();
    
    $periods_array = array ('year'   => 31556926, 'month'  => 2629743,
                            'week'   => 604800,   'day'    => 86400,
                            'hour'   => 3600,     'minute' => 60,
                            'second' => 1);
  
    $seconds = (float) $seconds;

    foreach ($periods_array as $period => $value) {

        if (($count = floor($seconds / $value)) > 0) {

            if ($abbrv_units === true) {

                $values_array[] = sprintf($lang['date_periods_short'][$period], $count);

            }elseif ($count <> 1) {

                $values_array[] = sprintf($lang['date_periods_plural'][$period], $count);

            }else {
               
                $values_array[] = sprintf($lang['date_periods'][$period], $count);
            }
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

    $trans_tbl['&lsquo;'] = "'"; 
    $trans_tbl['&rsquo;'] = "'";
    $trans_tbl['&ldquo;'] = '"';
    $trans_tbl['&rdquo;'] = '"';
    $trans_tbl['&mdash;'] = '-';

    unset($trans_tbl['&#39;']);

    $ret = strtr($text, $trans_tbl);
    $ret = html_entity_to_decimal($ret, true);

    $ret = preg_replace('/&#(\d+);/me', "chr(\\1)", $ret);
    return preg_replace('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $ret);
}

// Translate &nbsp; to &#160; etc. If translation of entity fails
// (i.e. no change is noticed after pass through _htmlentities_decode()
// function the unaltered entity is returned.

function xml_literal_to_numeric($literal)
{
    if (preg_match("/^&#[0-9]+;$/", $literal) > 0) return $literal;

    $html_entity  = _htmlentities_decode($literal);
    if ($literal == $html_entity) return $html_entity;

    $numeric = ord($html_entity);

    return "&#$numeric;";
}

// The definitive HTML entity to XML decimal function (maybe)

function html_entity_to_decimal($string)
{
    $entity_to_decimal = array('&nbsp;'     => '&#160;',  '&iexcl;'   => '&#161;', 
                               '&cent;'     => '&#162;',  '&pound;'   => '&#163;', 
                               '&curren;'   => '&#164;',  '&yen;'     => '&#165;', 
                               '&brvbar;'   => '&#166;',  '&sect;'    => '&#167;', 
                               '&uml;'      => '&#168;',  '&copy;'    => '&#169;', 
                               '&ordf;'     => '&#170;',  '&laquo;'   => '&#171;', 
                               '&not;'      => '&#172;',  '&shy;'     => '&#173;', 
                               '&reg;'      => '&#174;',  '&macr;'    => '&#175;', 
                               '&deg;'      => '&#176;',  '&plusmn;'  => '&#177;', 
                               '&sup2;'     => '&#178;',  '&sup3;'    => '&#179;', 
                               '&acute;'    => '&#180;',  '&micro;'   => '&#181;', 
                               '&para;'     => '&#182;',  '&middot;'  => '&#183;', 
                               '&cedil;'    => '&#184;',  '&sup1;'    => '&#185;', 
                               '&ordm;'     => '&#186;',  '&raquo;'   => '&#187;', 
                               '&frac14;'   => '&#188;',  '&frac12;'  => '&#189;', 
                               '&frac34;'   => '&#190;',  '&iquest;'  => '&#191;', 
                               '&Agrave;'   => '&#192;',  '&Aacute;'  => '&#193;', 
                               '&Acirc;'    => '&#194;',  '&Atilde;'  => '&#195;', 
                               '&Auml;'     => '&#196;',  '&Aring;'   => '&#197;', 
                               '&AElig;'    => '&#198;',  '&Ccedil;'  => '&#199;', 
                               '&Egrave;'   => '&#200;',  '&Eacute;'  => '&#201;', 
                               '&Ecirc;'    => '&#202;',  '&Euml;'    => '&#203;', 
                               '&Igrave;'   => '&#204;',  '&Iacute;'  => '&#205;', 
                               '&Icirc;'    => '&#206;',  '&Iuml;'    => '&#207;', 
                               '&ETH;'      => '&#208;',  '&Ntilde;'  => '&#209;', 
                               '&Ograve;'   => '&#210;',  '&Oacute;'  => '&#211;', 
                               '&Ocirc;'    => '&#212;',  '&Otilde;'  => '&#213;', 
                               '&Ouml;'     => '&#214;',  '&times;'   => '&#215;', 
                               '&Oslash;'   => '&#216;',  '&Ugrave;'  => '&#217;', 
                               '&Uacute;'   => '&#218;',  '&Ucirc;'   => '&#219;', 
                               '&Uuml;'     => '&#220;',  '&Yacute;'  => '&#221;', 
                               '&THORN;'    => '&#222;',  '&szlig;'   => '&#223;', 
                               '&agrave;'   => '&#224;',  '&aacute;'  => '&#225;', 
                               '&acirc;'    => '&#226;',  '&atilde;'  => '&#227;', 
                               '&auml;'     => '&#228;',  '&aring;'   => '&#229;', 
                               '&aelig;'    => '&#230;',  '&ccedil;'  => '&#231;', 
                               '&egrave;'   => '&#232;',  '&eacute;'  => '&#233;', 
                               '&ecirc;'    => '&#234;',  '&euml;'    => '&#235;', 
                               '&igrave;'   => '&#236;',  '&iacute;'  => '&#237;', 
                               '&icirc;'    => '&#238;',  '&iuml;'    => '&#239;', 
                               '&eth;'      => '&#240;',  '&ntilde;'  => '&#241;', 
                               '&ograve;'   => '&#242;',  '&oacute;'  => '&#243;', 
                               '&ocirc;'    => '&#244;',  '&otilde;'  => '&#245;', 
                               '&ouml;'     => '&#246;',  '&divide;'  => '&#247;', 
                               '&oslash;'   => '&#248;',  '&ugrave;'  => '&#249;', 
                               '&uacute;'   => '&#250;',  '&ucirc;'   => '&#251;', 
                               '&uuml;'     => '&#252;',  '&yacute;'  => '&#253;', 
                               '&thorn;'    => '&#254;',  '&yuml;'    => '&#255;', 
                               '&fnof;'     => '&#402;',  '&Alpha;'   => '&#913;', 
                               '&Beta;'     => '&#914;',  '&Gamma;'   => '&#915;', 
                               '&Delta;'    => '&#916;',  '&Epsilon;' => '&#917;', 
                               '&Zeta;'     => '&#918;',  '&Eta;'     => '&#919;', 
                               '&Theta;'    => '&#920;',  '&Iota;'    => '&#921;', 
                               '&Kappa;'    => '&#922;',  '&Lambda;'  => '&#923;', 
                               '&Mu;'       => '&#924;',  '&Nu;'      => '&#925;', 
                               '&Xi;'       => '&#926;',  '&Omicron;' => '&#927;', 
                               '&Pi;'       => '&#928;',  '&Rho;'     => '&#929;', 
                               '&Sigma;'    => '&#931;',  '&Tau;'     => '&#932;', 
                               '&Upsilon;'  => '&#933;',  '&Phi;'     => '&#934;', 
                               '&Chi;'      => '&#935;',  '&Psi;'     => '&#936;', 
                               '&Omega;'    => '&#937;',  '&alpha;'   => '&#945;', 
                               '&beta;'     => '&#946;',  '&gamma;'   => '&#947;', 
                               '&delta;'    => '&#948;',  '&epsilon;' => '&#949;', 
                               '&zeta;'     => '&#950;',  '&eta;'     => '&#951;', 
                               '&theta;'    => '&#952;',  '&iota;'    => '&#953;', 
                               '&kappa;'    => '&#954;',  '&lambda;'  => '&#955;', 
                               '&mu;'       => '&#956;',  '&nu;'      => '&#957;', 
                               '&xi;'       => '&#958;',  '&omicron;' => '&#959;', 
                               '&pi;'       => '&#960;',  '&rho;'     => '&#961;', 
                               '&sigmaf;'   => '&#962;',  '&sigma;'   => '&#963;', 
                               '&tau;'      => '&#964;',  '&upsilon;' => '&#965;', 
                               '&phi;'      => '&#966;',  '&chi;'     => '&#967;', 
                               '&psi;'      => '&#968;',  '&omega;'   => '&#969;', 
                               '&thetasym;' => '&#977;',  '&upsih;'   => '&#978;', 
                               '&piv;'      => '&#982;',  '&bull;'    => '&#8226;', 
                               '&hellip;'   => '&#8230;', '&prime;'   => '&#8242;', 
                               '&Prime;'    => '&#8243;', '&oline;'   => '&#8254;', 
                               '&frasl;'    => '&#8260;', '&weierp;'  => '&#8472;', 
                               '&image;'    => '&#8465;', '&real;'    => '&#8476;', 
                               '&trade;'    => '&#8482;', '&alefsym;' => '&#8501;', 
                               '&larr;'     => '&#8592;', '&uarr;'    => '&#8593;', 
                               '&rarr;'     => '&#8594;', '&darr;'    => '&#8595;', 
                               '&harr;'     => '&#8596;', '&crarr;'   => '&#8629;', 
                               '&lArr;'     => '&#8656;', '&uArr;'    => '&#8657;', 
                               '&rArr;'     => '&#8658;', '&dArr;'    => '&#8659;', 
                               '&hArr;'     => '&#8660;', '&forall;'  => '&#8704;', 
                               '&part;'     => '&#8706;', '&exist;'   => '&#8707;', 
                               '&empty;'    => '&#8709;', '&nabla;'   => '&#8711;', 
                               '&isin;'     => '&#8712;', '&notin;'   => '&#8713;', 
                               '&ni;'       => '&#8715;', '&prod;'    => '&#8719;', 
                               '&sum;'      => '&#8721;', '&minus;'   => '&#8722;', 
                               '&lowast;'   => '&#8727;', '&radic;'   => '&#8730;', 
                               '&prop;'     => '&#8733;', '&infin;'   => '&#8734;', 
                               '&ang;'      => '&#8736;', '&and;'     => '&#8743;', 
                               '&or;'       => '&#8744;', '&cap;'     => '&#8745;', 
                               '&cup;'      => '&#8746;', '&int;'     => '&#8747;', 
                               '&there4;'   => '&#8756;', '&sim;'     => '&#8764;', 
                               '&cong;'     => '&#8773;', '&asymp;'   => '&#8776;', 
                               '&ne;'       => '&#8800;', '&equiv;'   => '&#8801;', 
                               '&le;'       => '&#8804;', '&ge;'      => '&#8805;', 
                               '&sub;'      => '&#8834;', '&sup;'     => '&#8835;', 
                               '&nsub;'     => '&#8836;', '&sube;'    => '&#8838;', 
                               '&supe;'     => '&#8839;', '&oplus;'   => '&#8853;', 
                               '&otimes;'   => '&#8855;', '&perp;'    => '&#8869;', 
                               '&sdot;'     => '&#8901;', '&lceil;'   => '&#8968;', 
                               '&rceil;'    => '&#8969;', '&lfloor;'  => '&#8970;', 
                               '&rfloor;'   => '&#8971;', '&lang;'    => '&#9001;', 
                               '&rang;'     => '&#9002;', '&loz;'     => '&#9674;', 
                               '&spades;'   => '&#9824;', '&clubs;'   => '&#9827;', 
                               '&hearts;'   => '&#9829;', '&diams;'   => '&#9830;', 
                               '&quot;'     => '&#34;',   '&amp;'     => '&#38;', 
                               '&lt;'       => '&#60;',   '&gt;'      => '&#62;', 
                               '&OElig;'    => '&#338;',  '&oelig;'   => '&#339;', 
                               '&Scaron;'   => '&#352;',  '&scaron;'  => '&#353;', 
                               '&Yuml;'     => '&#376;',  '&circ;'    => '&#710;', 
                               '&tilde;'    => '&#732;',  '&ensp;'    => '&#8194;', 
                               '&emsp;'     => '&#8195;', '&thinsp;'  => '&#8201;', 
                               '&zwnj;'     => '&#8204;', '&zwj;'     => '&#8205;', 
                               '&lrm;'      => '&#8206;', '&rlm;'     => '&#8207;', 
                               '&ndash;'    => '&#8211;', '&mdash;'   => '&#8212;', 
                               '&lsquo;'    => '&#8216;', '&rsquo;'   => '&#8217;', 
                               '&sbquo;'    => '&#8218;', '&ldquo;'   => '&#8220;', 
                               '&rdquo;'    => '&#8221;', '&bdquo;'   => '&#8222;', 
                               '&dagger;'   => '&#8224;', '&Dagger;'  => '&#8225;', 
                               '&permil;'   => '&#8240;', '&lsaquo;'  => '&#8249;', 
                               '&rsaquo;'   => '&#8250;', '&euro;'    => '&#8364;');

    return preg_replace("/&[A-Za-z]+;/", " ", strtr($string,$entity_to_decimal));    
}

// Checks for Magic Quotes and perform stripslashes if nessecary
// Works on multi-dimensional arrays and strings(!)

function _stripslashes($var)
{
   if (is_array($var)) {

       array_map('_stripslashes', $var);
   
   }elseif (get_magic_quotes_gpc() == 1) {

       return stripslashes($var);
   }

   return $var;
}

// Case insensitive replacement for array_search.

function _array_search($needle, $haystack)
{
    foreach ($haystack as $key => $value) {

        if (!is_array($value)) {

            if (strtolower($needle) == strtolower($value)) {

                return $key;
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
    if (preg_match("/^[A-Fa-f0-9]{32}$/", $hash) > 0) {
        return true;
    }

    return false;
}

function get_local_time()
{
    if (!$timezone_id = bh_session_get_value('TIMEZONE')) {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (!$gmt_offset = bh_session_get_value('GMT_OFFSET')) {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (!$dst_offset = bh_session_get_value('DST_OFFSET')) {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (!$dl_saving = bh_session_get_value('DL_SAVING')) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS) + ($dst_offset * HOUR_IN_SECONDS);
    }else {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS);
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

function format_dob($dob) // $dob is a MySQL-type DATE field (YYYY-MM-DD)
{
    $lang = load_language_file();

    list($year, $month, $day) = explode("-", $dob);

    $month = floor($month); $day = floor($day);

    return "$day {$lang['month_short'][$month]}";
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

function flatten_array($array, &$result_keys, &$result_values, $key_str = "")
{
    foreach($array as $key => $value) {
        
        if (is_array($value)) {

            if (strlen($key_str) > 0) {

                flatten_array($value, $result_keys, $result_values, "{$key_str}[{$key}]");

            }else {

                flatten_array($value, $result_keys, $result_values, $key);
            }

        }else {

            if (strlen($key_str) > 0) {

                $result_keys[] = "{$key_str}[{$key}]";
                $result_values[] = $value;

            }else {

                $result_keys[] = $key;
                $result_values[] = $value;
            }
        }
    }
}

function preg_quote_callback($str)
{
    return preg_quote($str, "/");
}

?>