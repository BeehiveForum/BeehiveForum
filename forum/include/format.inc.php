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

/* $Id$ */

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

/**
* Format user nickname.
*
* Formats users nickname into one of:
*
* LOGON - Where no nickname is set
* Nickname - Where logon is the same as nickname (case-insensitive)
* Nickname (LOGON) - Where logon and nickname differ.
*
* @return string
* @param string $logon - User Logon
* @param string $nickname - User Nickname
*/

function format_user_name($logon, $nickname)
{
    if (strlen(trim($nickname)) > 0) {

        if (mb_strtoupper(strip_tags($logon)) == mb_strtoupper(strip_tags($nickname))) {

            return strip_tags($nickname);

        }else {

            return sprintf("%s (%s)", strip_tags($nickname), mb_strtoupper(strip_tags($logon)));
        }

    }

    return mb_strtoupper(strip_tags($logon));
}

/**
* Format file size.
*
* Formats file size of bytes into megabytes (MiB), kilobytes (KiB) or Bytes.
*
* @return string
* @param integer $size - Filesize in bytes.
*/

function format_file_size($size)
{
    if ($size >= 1000000) {
        $resized = round($size / 1048576, 2). " MiB";
    } else if ($size >= 1000) {
        $resized = round($size / 1024, 2). " KiB";
    } else{
        $resized = $size. " bytes";
    }

    return $resized;
}

/**
* Format version number
*
* Formats an integer version number into major.minor.build
* e.g. 12345 becomes 1.23.45
*
* @param mixed $version
* @return string
*/
function format_version_number($version, $glue = '.')
{
    $version_array = array();

    while (($version % 100) > 0) {

        array_unshift($version_array, $version % 100);
        $version = floor($version / 100);
    }

    return implode($glue, $version_array);
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

function format_time($time)
{
    // $time is a UNIX timestamp, which by definition is in GMT/UTC
    $lang = load_language_file();

    if (($timezone_id = session_get_value('TIMEZONE')) === false) {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (($gmt_offset = session_get_value('GMT_OFFSET')) === false) {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (($dst_offset = session_get_value('DST_OFFSET')) === false) {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (($dl_saving = session_get_value('DL_SAVING')) === false) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    // Calculate $time in user's timezone.
    $time = $time + ($gmt_offset * HOUR_IN_SECONDS);

    // Calculate the current time in user's timezone.
    $current_time = time() + ($gmt_offset * HOUR_IN_SECONDS);

    // Check for DST changes
    if (($dl_saving == 'Y') && timestamp_is_dst($timezone_id, $gmt_offset)) {

        // Ammend the $time to include DST
        $time = $time + ($dst_offset * HOUR_IN_SECONDS);

        // Ammend the current time to include DST
        $current_time = $current_time + ($dst_offset * HOUR_IN_SECONDS);
    }

    // Get the numerical parts for $time
    list($time_min, $time_hour, $time_day, $time_month, $time_year) = explode(" ", gmdate("i G j n Y", $time));

    // Get the numerical parts for the current month and year
    list($current_day, $current_month, $current_year) = explode(' ', gmdate('j n Y', $current_time));

    // Get the month string for $time
    $time_month = $lang['month_short'][$time_month];

    // Get the month string for current time.
    $current_month = $lang['month_short'][$current_month];

    // Decide on the date format.
    if (($time_year != $current_year)) {

        // If the year is different, show everything.
        $format = sprintf($lang['daymonthyearhourminute'], $time_day, $time_month, $time_year, $time_hour, $time_min); // j M Y H:i

    } else if (($time_month != $current_month) || ($time_day != $current_day)) {

        // If the month or day are different, show them with the time.
        $format = sprintf($lang['daymonthhourminute'], $time_day, $time_month, $time_hour, $time_min); // j M H:i

    } else {

        // Show only the time.
        $format = sprintf($lang['hourminute'], $time_hour, $time_min); // H:i
    }

    return $format;
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

    if (($timezone_id = session_get_value('TIMEZONE')) === false) {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (($gmt_offset = session_get_value('GMT_OFFSET')) === false) {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (($dst_offset = session_get_value('DST_OFFSET')) === false) {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (($dl_saving = session_get_value('DL_SAVING')) === false) {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    // Calculate $time in user's timezone.
    $time = $time + ($gmt_offset * HOUR_IN_SECONDS);

    // Calculate the current time in user's timezone.
    $current_time = time() + ($gmt_offset * HOUR_IN_SECONDS);

    // Check for DST changes
    if (($dl_saving == 'Y') && timestamp_is_dst($timezone_id, $gmt_offset)) {

        // Ammend the $time to include DST
        $time = $time + ($dst_offset * HOUR_IN_SECONDS);

        // Ammend the current time to include DST
        $current_time = $current_time + ($dst_offset * HOUR_IN_SECONDS);
    }

    // Get the numerical parts for $time
    list($time_day, $time_month, $time_year) = explode(" ", gmdate("j n Y", $time));

    // Get the numerical parts for the current time
    $current_year = gmdate('Y', $current_time);

    // Get the month string for $time
    $time_month = $lang['month_short'][$time_month];

    // Decide on the date format.
    if (($time_year != $current_year)) {

        // If the year is different, show everything.
        $format = sprintf($lang['daymonthyear'], $time_day, $time_month, $time_year); // j M Y

    } else {

        // Show only the day and month.
        $format = sprintf($lang['daymonth'], $time_day, $time_month); // j M
    }

    return $format;
}

/**
* Format time display
*
* Formats Unix timestamp into units of years, months, weeks, days, hours, minutes and seconds.
*
* @return string
* @param integer $seconds - Unix timestamp
* @param boolean $abbrv_units - Specify use of abbreviated units (hr vs. hour, min vs. minute, etc.)
*/

function format_time_display($seconds, $abbrv_units = true)
{
    $lang = load_language_file();

    $periods_array = array ('year'   => 31556926, 'month'  => 2629743,
                            'week'   => 604800,   'day'    => 86400,
                            'hour'   => 3600,     'minute' => 60,
                            'second' => 1);

    $seconds = (float) $seconds;

    $values_array = array();

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

    if (sizeof($values_array) > 0) {

        return implode(" ", $values_array);

    }elseif ($abbrv_units === true) {

        sprintf($lang['date_periods_short']['second'], 0);
    }

    return sprintf($lang['date_periods_plural']['second'], 0);
}

/**
* UTF-8 and ENT_COMPAT enforced htmlentities
*
* Ensures use of UTF-8 and ENT_COMPAT settings for htmlentities.
* Passes variable through ms_word_to_html to remove irregularities caused
* by copying and pasting content from MS Word.
*
* @return mixed
* @param mixed $var - variable to encode - supports array of strings.
*/

function htmlentities_array($var)
{
    $var = smart_quotes_clean_up($var);

    if (is_array($var)) {
        return array_map('htmlentities_array', $var);
    }

    // Strip invalid characters from the string.
    $var = @iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $var);

    // Pass it through htmlentities.
    return htmlentities($var, ENT_COMPAT, 'UTF-8');
}

/**
* UTF-8 and ENT_COMPAT enforced html_entity_decode
*
* Ensures use of UTF-8 and ENT_COMPAT settings for html_entity_decode.
*
* @return mixed
* @param mixed $var - variable to encode - supports array of strings.
*/

function htmlentities_decode_array($var)
{
    if (is_array($var)) {
        return array_map('htmlentities_decode_array', $var);
    }

    // Strip invalid characters from the string.
    $var = @iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $var);

    // Pass it through html_entity_decode
    return html_entity_decode($var, ENT_COMPAT, 'UTF-8');
}

/**
* Clean up smart quotes
*
* Cleans smart quotes inserted by MS Word and other word processors.
*
* @return mixed
* @param mixed $var - variable to encode - supports array of strings.
*/

function smart_quotes_clean_up($var)
{
   $smart_quotes_array = array("\xc2\x80" => "\xe2\x82\xac",  /* EURO SIGN */
                               "\xc2\x82" => "\xe2\x80\x9a",  /* SINGLE LOW-9 QUOTATION MARK */
                               "\xc2\x83" => "\xc6\x92",      /* LATIN SMALL LETTER F WITH HOOK */
                               "\xc2\x84" => "\xe2\x80\x9e",  /* DOUBLE LOW-9 QUOTATION MARK */
                               "\xc2\x85" => "\xe2\x80\xa6",  /* HORIZONTAL ELLIPSIS */
                               "\xc2\x86" => "\xe2\x80\xa0",  /* DAGGER */
                               "\xc2\x87" => "\xe2\x80\xa1",  /* DOUBLE DAGGER */
                               "\xc2\x88" => "\xcb\x86",      /* MODIFIER LETTER CIRCUMFLEX ACCENT */
                               "\xc2\x89" => "\xe2\x80\xb0",  /* PER MILLE SIGN */
                               "\xc2\x8a" => "\xc5\xa0",      /* LATIN CAPITAL LETTER S WITH CARON */
                               "\xc2\x8b" => "\xe2\x80\xb9",  /* SINGLE LEFT-POINTING ANGLE QUOTATION */
                               "\xc2\x8c" => "\xc5\x92",      /* LATIN CAPITAL LIGATURE OE */
                               "\xc2\x8e" => "\xc5\xbd",      /* LATIN CAPITAL LETTER Z WITH CARON */
                               "\xc2\x91" => "\xe2\x80\x98",  /* LEFT SINGLE QUOTATION MARK */
                               "\xc2\x92" => "\xe2\x80\x99",  /* RIGHT SINGLE QUOTATION MARK */
                               "\xc2\x93" => "\xe2\x80\x9c",  /* LEFT DOUBLE QUOTATION MARK */
                               "\xc2\x94" => "\xe2\x80\x9d",  /* RIGHT DOUBLE QUOTATION MARK */
                               "\xc2\x95" => "\xe2\x80\xa2",  /* BULLET */
                               "\xc2\x96" => "\xe2\x80\x93",  /* EN DASH */
                               "\xc2\x97" => "\xe2\x80\x94",  /* EM DASH */
                               "\xc2\x98" => "\xcb\x9c",      /* SMALL TILDE */
                               "\xc2\x99" => "\xe2\x84\xa2",  /* TRADE MARK SIGN */
                               "\xc2\x9a" => "\xc5\xa1",      /* LATIN SMALL LETTER S WITH CARON */
                               "\xc2\x9b" => "\xe2\x80\xba",  /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
                               "\xc2\x9c" => "\xc5\x93",      /* LATIN SMALL LIGATURE OE */
                               "\xc2\x9e" => "\xc5\xbe",      /* LATIN SMALL LETTER Z WITH CARON */
                               "\xc2\x9f" => "\xc5\xb8");     /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/

    if (is_array($var)) {
        return array_map('smart_quotes_clean_up', $var);
    }

    return strtr($var, $smart_quotes_array);
}

/**
* Strip invalid XML chars from string.
*
* Removes all invalid charaters from a string in preperation for inclusion
* in XML output. Only supports UTF-8, not UTF-16.
*
* @return string
* @param string $string - String to check.
*/

function xml_strip_invalid_chars($string)
{
    return preg_replace('/([^\x9\xA\xD\x20-\xD7FF\xE000-\xFFFD])+/mu', '', $string);
}

/**
* HTML literal to XML numeric
*
* Converts HTML literal entities into XML numerical entities.
*
* @return string
* @param string $string - String to convert.
*/

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

    return preg_replace("/(&[a-z0-9]+;?)/iu", " ", strtr($string, $entity_to_decimal));
}

/**
* Strip HTML paragraphs and line breaks
*
* Replaces <p> </p> and <br /> with new-line chars.
*
* @return string
* @param string $string - string to convert.
*/

function strip_paragraphs($string)
{
    return preg_replace(array('/<p[^>]*>/iUu', '/<\/p[^>]*>\n/iUu', '/<\/p[^>]*>/iUu', '/<br\s*?\/?>/iu'), array('', chr(10)), $string);
}

/**
* Array aware magic-quotes safe stripslashes.
*
* Processes array or string through stripslashes while testing for magic-quotes.
*
* @return mixed
* @param mixed  $var - Variable to convert (array or string)
*/

function stripslashes_array($var)
{
   if (is_array($var)) {

       return array_map('stripslashes_array', $var);

   }elseif (get_magic_quotes_gpc() == 1) {

       return stripslashes($var);
   }

   return $var;
}

/**
* Create array with matching keys and values.
*
* Same as range, but keys are set equal to values.
*
* @return array
* @param mixed $low - Low number
* @param mixed $high - High number
*/

function range_keys($low, $high)
{
    $array_range = array_flip(range($low, $high));
    array_walk($array_range, create_function('&$item, $key', '$item = $key;'));
    return $array_range;
}

/**
* Check variable is within range
*
* Check that passed variable is within range of $low and $high.
*
* @return Boolean
* @param mixed $var - Variable to test
* @param mixed $low - Low number
* @param mixed $high - High number
*/

function in_range($var, $low, $high)
{
   return in_array($var, range($low, $high));
}

/**
* Search an array
*
* Searches the array for a given value and returns the corresponding key if successful.
* This version is case-insensitive.
*
* @return mixed
* @param mixed  $var - Variable to convert (array or string)
*/

function array_isearch($needle, $haystack)
{
    foreach($haystack as $key => $value) {
        if(strcasecmp($needle, $value) == 0) return $key;
    }

    return false;
}

/**
* array_keys_exists
*
* Search an array for all the keys
*
* @param array $array
* @param mixed $key, [$key, [...]]
*/
function array_keys_exist()
{
    $keys = func_get_args();

    $array = array_shift($keys);

    if (!is_array($array)) return false;

    return array_intersect($keys, array_keys($array)) === $keys;
}

/**
* Validate MD5 hash.
*
* Checks that MD5 hash contains valid caharacters and is required length.
* Does not validate the md5 hash is correct.
*
* @return boolean
* @param string $hash - MD5 hash to test.
*/

function is_md5($hash)
{
    if (preg_match("/^[A-Fa-f0-9]{32}$/Du", $hash) > 0) {
        return true;
    }

    return false;
}

/**
* Calulate Age from DOB
*
* Calculates age from MySQL DATE field (YYYY-MM-DD)
*
* @return integer
* @param integer $dob - MySQL DATE field.
*/

function format_age($dob)
{
    $matches_array = array();

    if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/u', $dob, $matches_array)) {

        list(, $birth_year, $birth_month, $birth_day) = $matches_array;

        list($today_day, $today_month, $today_year) = explode('-', date('j-n-Y', user_get_local_time()));

        $age = ($today_year - $birth_year);

        if (($today_month < $birth_month) || (($today_month == $birth_month) && ($today_day < $birth_day)) ) $age -= 1;

        return $age;
    }

    return false;
}

/**
* Format Birthday as a string.
*
* Formats a MySQL DATE field (YYYY-MM-DD) as human readable date (1st Jan, etc.)
*
* @return mixed - False on failure.
* @param integer $dob - MySQL DATE field.
*/

function format_birthday($date)
{
    $lang = load_language_file();

    $matches_array = array();

    if (preg_match('/[0-9]{4}-([0-9]{2})-([0-9]{2})/u', $date, $matches_array)) {

        list(, $month, $day) = $matches_array;

        $month = floor($month); $day = floor($day);

        return "$day {$lang['month_short'][$month]}";
    }

    return false;
}

/**
* Removes specified parts of a URL.
*
* Optionally removes path, query and fragment (#pagemark) from an URL
*
* @return string
* @param string $url - URL to process
* @param boolean $inc_path - Optional - Keep the path on the URL.
* @param boolean $inc_query - Optional - Keep the URL query on the URL.
* @param boolean $inc_fragment - Optional - Keep the fragment on the URL.
*/

function split_url($url, $inc_path = false, $inc_query = false, $inc_fragment = false)
{
    if (($url_parts = @parse_url($url))) {

        if (!isset($url_parts['scheme'])) return false;
        if (!isset($url_parts['host'])) return false;

        $url_split = "{$url_parts['scheme']}://{$url_parts['host']}/";
        if ($inc_path === true) $url_split.= "{$url_parts['path']}";
        if ($inc_query === true) $url_split.= "{$url_parts['query']}";
        if ($inc_fragment === true) $url_split.= "{$url_parts['fragment']}";

        return $url_split;
    }

    return $url;
}

/**
* Flattern an array
*
* Flatterns a multi-dimensional array into two arrays of keys and values.
*
* @return void
* @param array $array - Array to process.
* @param array $result_keys - By Reference array of keys retrieved from array
* @param array $result_keys - By Reference array of values retrieved from array
* @param string $key_str - Optional string to specify key prefix.
*/

function flatten_array($array, &$result_keys, &$result_values, $key_str = "")
{
    foreach ($array as $key => $value) {

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

/**
* Preg Quote string call back
*
* Use with array_map to process all array elements through preg_quote using / as delimiter.
*
* @return string
* @param string $str -
*/

function preg_quote_callback($str)
{
    return preg_quote($str, "/");
}

/**
* Array of random numbers
*
* Generate an array of random numbers.
*
* @return array
* @param integer $start_index - The first index of the returned array
* @param integer $num - Number of elements to insert into array
* @param integer $range_min - Starting range for random numbers
* @param integer $range_max - Ending range for random numbers
*/

function rand_array($start_index, $num, $range_min, $range_max)
{
    $mt_rand_call = sprintf('$item = mt_rand(%d, %d);', $range_min, $range_max);

    $array_rand = array_fill($start_index, $num, 1);

    array_walk($array_rand, create_function('&$item', $mt_rand_call));

    return $array_rand;
}

/**
* Implode array keys and values
*
* Implode an associative array with separator between key and value
* and glue between each array entry.
*
* @return string
* @param array $array
* @param string $separator - The key value separator. Default is ': '
* @param string $glue - The array entry separator. Default is ', '
*/

function implode_assoc($array, $separator = ': ', $glue = ', ')
{
    if (!is_array($array)) return false;
    if (!is_string($separator)) return false;
    if (!is_string($glue)) return false;

    $result_array = array();

    foreach ($array as $key => $value) {
        $result_array[] = $key. $separator. $value;
    }

    return implode($glue, $result_array);
}

function path_info_query($path)
{
    if (!($path_parts = @pathinfo($path))) return false;

    if (($url_parts = @parse_url($path)) && isset($url_parts['query'])) {

        $path_parts['query'] = $url_parts['query'];
        $path_parts['extension'] = str_replace("?{$path_parts['query']}", '', $path_parts['extension']);
        $path_parts['basename'] = str_replace("?{$path_parts['query']}", '', $path_parts['basename']);
    }

    return $path_parts;
}

function build_url_str($uri_array)
{
    if (!is_array($uri_array)) {
        throw new Exception('$uri_array needs to be an array');
    }
    
    $uri = (isset($uri_array['scheme']))   ? "{$uri_array['scheme']}://" : '';
    $uri.= (isset($uri_array['host']))     ? "{$uri_array['host']}"      : '';
    $uri.= (isset($uri_array['port']))     ? ":{$uri_array['port']}"     : '';
    $uri.= (isset($uri_array['path']))     ? "{$uri_array['path']}"      : '';
    $uri.= (isset($uri_array['query']))    ? "?{$uri_array['query']}"    : '';
    $uri.= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';    
    
    return $uri;
}

/**
* Return request URI
*
* IIS doesn't support the REQUEST_URI server var
* so we use this function to generate our own.
*
* @param bool $include_webtag
* @param bool $encoded_uri_query
* @return string
*/
function get_request_uri($include_webtag = true, $encode_uri_query = true)
{
    if (!is_bool($include_webtag)) $include_webtag = true;
    if (!is_bool($encode_uri_query)) $encode_uri_query = true;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);
    
    $request_uri = html_get_forum_uri(basename($_SERVER['PHP_SELF']));
    
    $query_string_array = array();
    
    unset($_GET['webtag']);
    
    if ($include_webtag) {
        $query_string_array['webtag'] = $webtag;
    }
    
    $query_string_array+= array_diff($_GET, $query_string_array);
    
    $query_string = http_build_query($query_string_array, null, (($encode_uri_query) ? '&amp;' : '&'));
    
    return sprintf('%s?%s', $request_uri, $query_string);
}

function print_r_pre($expression, $return = false)
{
    $result = sprintf('<pre>%s</pre>', print_r($expression, true));

    if (!$return) {
        echo $result;
        return true;
    }

    return $result;
}

?>