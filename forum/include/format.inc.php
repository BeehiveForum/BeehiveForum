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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function format_user_name($logon, $nickname)
{
    if (strlen(trim($nickname)) > 0) {

        if (mb_strtoupper(strip_tags($logon)) == mb_strtoupper(strip_tags($nickname))) {

            return strip_tags($nickname);

        } else {

            return sprintf("%s (%s)", strip_tags($nickname), mb_strtoupper(strip_tags($logon)));
        }

    }

    return mb_strtoupper(strip_tags($logon));
}

function format_file_name($filename)
{
    if (strlen($filename) > 33) {
        return substr($filename, 0, 19) . '...' . substr($filename, -13);
    }

    return $filename;
}

function format_file_size($size)
{
    $b = -1;

    $units = array(
        "kB",
        "MB",
        "GB",
        "TB",
        "PB",
        "EB"
    );

    do {

        $size = $size / 1024;
        $b++;

    } while ($size > 99);

    return format_number(floor($size * 100) / 100, 2) . $units[$b];
}

function convert_shorthand_filesize($size)
{
    $unit = substr($size, -1);

    $result = substr($size, 0, -1);

    switch (strtoupper($unit)) {

        /** @noinspection PhpMissingBreakStatementInspection */
        case 'P':
            $result *= 1024;

        /** @noinspection PhpMissingBreakStatementInspection */
        case 'T':
            $result *= 1024;

        /** @noinspection PhpMissingBreakStatementInspection */
        case 'G':
            $result *= 1024;

        /** @noinspection PhpMissingBreakStatementInspection */
        case 'M':
            $result *= 1024;

        case 'K':
            $result *= 1024;
    }

    return $result;
}

function format_version_number($version, $glue = '.')
{
    $version_array = array();

    while (($version % 100) > 0) {

        array_unshift($version_array, $version % 100);
        $version = floor($version / 100);
    }

    return implode($glue, $version_array);
}

function format_date_time($time, $date_only = false)
{
    if (isset($_SESSION['TIMEZONE']) && is_numeric($_SESSION['TIMEZONE'])) {
        $timezone_id = intval($_SESSION['TIMEZONE']);
    } else {
        $timezone_id = forum_get_setting('forum_timezone', 'is_numeric', 27);
    }

    if (isset($_SESSION['GMT_OFFSET']) && is_numeric($_SESSION['GMT_OFFSET'])) {
        $gmt_offset = intval($_SESSION['GMT_OFFSET']);
    } else {
        $gmt_offset = forum_get_setting('forum_gmt_offset', 'is_numeric', 0);
    }

    if (isset($_SESSION['DST_OFFSET']) && is_numeric($_SESSION['DST_OFFSET'])) {
        $dst_offset = intval($_SESSION['DST_OFFSET']);
    } else {
        $dst_offset = forum_get_setting('forum_dst_offset', 'is_numeric', 0);
    }

    if (isset($_SESSION['DL_SAVING']) && in_array($_SESSION['DL_SAVING'], array('Y', 'N'))) {
        $dl_saving = $_SESSION['DL_SAVING'];
    } else {
        $dl_saving = forum_get_setting('forum_dl_saving', 'strlen', 'N');
    }

    // Calculate $time in user's timezone.
    $time = $time + ($gmt_offset * HOUR_IN_SECONDS);

    // Calculate the current time in user's timezone.
    $current_time = time() + ($gmt_offset * HOUR_IN_SECONDS);

    // Check for DST changes
    if (($dl_saving == 'Y') && timestamp_is_dst($timezone_id, $gmt_offset)) {

        // Amend the $time to include DST
        $time = $time + ($dst_offset * HOUR_IN_SECONDS);

        // Amend the current time to include DST
        $current_time = $current_time + ($dst_offset * HOUR_IN_SECONDS);
    }

    // Get the numerical parts for $time
    list($time_day, $time_month, $time_year) = explode(" ", gmdate("j M Y", $time));

    // Get the numerical parts for the current month and year
    list($current_day, $current_month, $current_year) = explode(' ', gmdate('j M Y', $current_time));

    // Decide on which format to display.
    if ($time_year == $current_year && $time_month == $current_month && $time_day == $current_day) {

        // Year, month and day are the same - show time only.
        $format = '%H:%M';

    } else if ($time_year == $current_year) {

        // Year is the same, show day, month and optional time.
        if ($date_only) {
            $format = '%e %b';
        } else {
            $format = '%e %b %H:%M';
        }

    } else {

        // Show full date and optional time.
        if ($date_only) {
            $format = '%e %b %Y';
        } else {
            $format = '%e %b %Y %H:%M';
        }
    }

    // Replace %e with %#d on Windows.
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        $format = str_replace('%e', '%#d', $format);
    }

    return strftime($format, $time);
}

function format_time_display($seconds, $abbrv_units = true)
{
    $periods_array = array(
        31556926 => array(
            '%s year',
            '%s years',
            '%sy'
        ),
        2629743 => array(
            '%s month',
            '%s months',
            '%sm'
        ),
        604800 => array(
            '%s week',
            '%s weeks',
            '%sw'
        ),
        86400 => array(
            '%s day',
            '%s days',
            '%sd'
        ),
        3600 => array(
            '%s hour',
            '%s hours',
            '%shr'
        ),
        60 => array(
            '%s minute',
            '%s minutes',
            '%smin'
        ),
        1 => array(
            '%s second',
            '%s seconds',
            '%ssec'
        ),
    );

    $seconds = (float)$seconds;

    $values_array = array();

    foreach ($periods_array as $value => $periods) {

        if (($count = floor($seconds / $value)) > 0) {

            if ($abbrv_units === true) {

                $value_text = gettext($periods[2]);

            } else {

                $value_text = ngettext($periods[0], $periods[1], $count);
            }

            $values_array[] = sprintf($value_text, $count);
        }

        $seconds = $seconds % $value;
    }

    if (sizeof($values_array) > 0) {

        return implode(' ', $values_array);

    } else if ($abbrv_units === true) {

        return sprintf(gettext($periods_array[1][2]), $seconds);
    }

    return sprintf(ngettext($periods_array[1][0], $periods_array[1][1], $seconds), $seconds);
}

function format_number($number, $decimals = 0)
{
    $locale = localeconv();
    return number_format($number, $decimals, $locale['decimal_point'], $locale['thousands_sep']);
}

function htmlentities_array($var)
{
    $var = smart_quotes_clean_up($var);

    if (is_array($var)) {
        return array_map('htmlentities_array', $var);
    }

    // Strip invalid characters from the string.
    $var = @iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $var);

    // Pass it through htmlentities.
    return htmlentities($var, ENT_QUOTES, 'UTF-8');
}

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

function smart_quotes_clean_up($var)
{
    $smart_quotes_array = array(
        "\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
        "\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
        "\xc2\x83" => "\xc6\x92", /* LATIN SMALL LETTER F WITH HOOK */
        "\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
        "\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
        "\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
        "\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
        "\xc2\x88" => "\xcb\x86", /* MODIFIER LETTER CIRCUMFLEX ACCENT */
        "\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
        "\xc2\x8a" => "\xc5\xa0", /* LATIN CAPITAL LETTER S WITH CARON */
        "\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
        "\xc2\x8c" => "\xc5\x92", /* LATIN CAPITAL LIGATURE OE */
        "\xc2\x8e" => "\xc5\xbd", /* LATIN CAPITAL LETTER Z WITH CARON */
        "\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
        "\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
        "\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
        "\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
        "\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
        "\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
        "\xc2\x97" => "\xe2\x80\x94", /* EM DASH */
        "\xc2\x98" => "\xcb\x9c", /* SMALL TILDE */
        "\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
        "\xc2\x9a" => "\xc5\xa1", /* LATIN SMALL LETTER S WITH CARON */
        "\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
        "\xc2\x9c" => "\xc5\x93", /* LATIN SMALL LIGATURE OE */
        "\xc2\x9e" => "\xc5\xbe", /* LATIN SMALL LETTER Z WITH CARON */
        "\xc2\x9f" => "\xc5\xb8", /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
    );

    if (is_array($var)) {
        return array_map('smart_quotes_clean_up', $var);
    }

    return strtr($var, $smart_quotes_array);
}

function xml_strip_invalid_chars($string)
{
    return preg_replace('/([^\x9\xA\xD\x20-\xD7FF\xE000-\xFFFD])+/mu', '', $string);
}

function html_entity_to_decimal($string)
{
    $entity_to_decimal = array(
        '&nbsp;' => '&#160;',
        '&iexcl;' => '&#161;',
        '&cent;' => '&#162;',
        '&pound;' => '&#163;',
        '&curren;' => '&#164;',
        '&yen;' => '&#165;',
        '&brvbar;' => '&#166;',
        '&sect;' => '&#167;',
        '&uml;' => '&#168;',
        '&copy;' => '&#169;',
        '&ordf;' => '&#170;',
        '&laquo;' => '&#171;',
        '&not;' => '&#172;',
        '&shy;' => '&#173;',
        '&reg;' => '&#174;',
        '&macr;' => '&#175;',
        '&deg;' => '&#176;',
        '&plusmn;' => '&#177;',
        '&sup2;' => '&#178;',
        '&sup3;' => '&#179;',
        '&acute;' => '&#180;',
        '&micro;' => '&#181;',
        '&para;' => '&#182;',
        '&middot;' => '&#183;',
        '&cedil;' => '&#184;',
        '&sup1;' => '&#185;',
        '&ordm;' => '&#186;',
        '&raquo;' => '&#187;',
        '&frac14;' => '&#188;',
        '&frac12;' => '&#189;',
        '&frac34;' => '&#190;',
        '&iquest;' => '&#191;',
        '&Agrave;' => '&#192;',
        '&Aacute;' => '&#193;',
        '&Acirc;' => '&#194;',
        '&Atilde;' => '&#195;',
        '&Auml;' => '&#196;',
        '&Aring;' => '&#197;',
        '&AElig;' => '&#198;',
        '&Ccedil;' => '&#199;',
        '&Egrave;' => '&#200;',
        '&Eacute;' => '&#201;',
        '&Ecirc;' => '&#202;',
        '&Euml;' => '&#203;',
        '&Igrave;' => '&#204;',
        '&Iacute;' => '&#205;',
        '&Icirc;' => '&#206;',
        '&Iuml;' => '&#207;',
        '&ETH;' => '&#208;',
        '&Ntilde;' => '&#209;',
        '&Ograve;' => '&#210;',
        '&Oacute;' => '&#211;',
        '&Ocirc;' => '&#212;',
        '&Otilde;' => '&#213;',
        '&Ouml;' => '&#214;',
        '&times;' => '&#215;',
        '&Oslash;' => '&#216;',
        '&Ugrave;' => '&#217;',
        '&Uacute;' => '&#218;',
        '&Ucirc;' => '&#219;',
        '&Uuml;' => '&#220;',
        '&Yacute;' => '&#221;',
        '&THORN;' => '&#222;',
        '&szlig;' => '&#223;',
        '&agrave;' => '&#224;',
        '&aacute;' => '&#225;',
        '&acirc;' => '&#226;',
        '&atilde;' => '&#227;',
        '&auml;' => '&#228;',
        '&aring;' => '&#229;',
        '&aelig;' => '&#230;',
        '&ccedil;' => '&#231;',
        '&egrave;' => '&#232;',
        '&eacute;' => '&#233;',
        '&ecirc;' => '&#234;',
        '&euml;' => '&#235;',
        '&igrave;' => '&#236;',
        '&iacute;' => '&#237;',
        '&icirc;' => '&#238;',
        '&iuml;' => '&#239;',
        '&eth;' => '&#240;',
        '&ntilde;' => '&#241;',
        '&ograve;' => '&#242;',
        '&oacute;' => '&#243;',
        '&ocirc;' => '&#244;',
        '&otilde;' => '&#245;',
        '&ouml;' => '&#246;',
        '&divide;' => '&#247;',
        '&oslash;' => '&#248;',
        '&ugrave;' => '&#249;',
        '&uacute;' => '&#250;',
        '&ucirc;' => '&#251;',
        '&uuml;' => '&#252;',
        '&yacute;' => '&#253;',
        '&thorn;' => '&#254;',
        '&yuml;' => '&#255;',
        '&fnof;' => '&#402;',
        '&Alpha;' => '&#913;',
        '&Beta;' => '&#914;',
        '&Gamma;' => '&#915;',
        '&Delta;' => '&#916;',
        '&Epsilon;' => '&#917;',
        '&Zeta;' => '&#918;',
        '&Eta;' => '&#919;',
        '&Theta;' => '&#920;',
        '&Iota;' => '&#921;',
        '&Kappa;' => '&#922;',
        '&Lambda;' => '&#923;',
        '&Mu;' => '&#924;',
        '&Nu;' => '&#925;',
        '&Xi;' => '&#926;',
        '&Omicron;' => '&#927;',
        '&Pi;' => '&#928;',
        '&Rho;' => '&#929;',
        '&Sigma;' => '&#931;',
        '&Tau;' => '&#932;',
        '&Upsilon;' => '&#933;',
        '&Phi;' => '&#934;',
        '&Chi;' => '&#935;',
        '&Psi;' => '&#936;',
        '&Omega;' => '&#937;',
        '&alpha;' => '&#945;',
        '&beta;' => '&#946;',
        '&gamma;' => '&#947;',
        '&delta;' => '&#948;',
        '&epsilon;' => '&#949;',
        '&zeta;' => '&#950;',
        '&eta;' => '&#951;',
        '&theta;' => '&#952;',
        '&iota;' => '&#953;',
        '&kappa;' => '&#954;',
        '&lambda;' => '&#955;',
        '&mu;' => '&#956;',
        '&nu;' => '&#957;',
        '&xi;' => '&#958;',
        '&omicron;' => '&#959;',
        '&pi;' => '&#960;',
        '&rho;' => '&#961;',
        '&sigmaf;' => '&#962;',
        '&sigma;' => '&#963;',
        '&tau;' => '&#964;',
        '&upsilon;' => '&#965;',
        '&phi;' => '&#966;',
        '&chi;' => '&#967;',
        '&psi;' => '&#968;',
        '&omega;' => '&#969;',
        '&thetasym;' => '&#977;',
        '&upsih;' => '&#978;',
        '&piv;' => '&#982;',
        '&bull;' => '&#8226;',
        '&hellip;' => '&#8230;',
        '&prime;' => '&#8242;',
        '&Prime;' => '&#8243;',
        '&oline;' => '&#8254;',
        '&frasl;' => '&#8260;',
        '&weierp;' => '&#8472;',
        '&image;' => '&#8465;',
        '&real;' => '&#8476;',
        '&trade;' => '&#8482;',
        '&alefsym;' => '&#8501;',
        '&larr;' => '&#8592;',
        '&uarr;' => '&#8593;',
        '&rarr;' => '&#8594;',
        '&darr;' => '&#8595;',
        '&harr;' => '&#8596;',
        '&crarr;' => '&#8629;',
        '&lArr;' => '&#8656;',
        '&uArr;' => '&#8657;',
        '&rArr;' => '&#8658;',
        '&dArr;' => '&#8659;',
        '&hArr;' => '&#8660;',
        '&forall;' => '&#8704;',
        '&part;' => '&#8706;',
        '&exist;' => '&#8707;',
        '&empty;' => '&#8709;',
        '&nabla;' => '&#8711;',
        '&isin;' => '&#8712;',
        '&notin;' => '&#8713;',
        '&ni;' => '&#8715;',
        '&prod;' => '&#8719;',
        '&sum;' => '&#8721;',
        '&minus;' => '&#8722;',
        '&lowast;' => '&#8727;',
        '&radic;' => '&#8730;',
        '&prop;' => '&#8733;',
        '&infin;' => '&#8734;',
        '&ang;' => '&#8736;',
        '&and;' => '&#8743;',
        '&or;' => '&#8744;',
        '&cap;' => '&#8745;',
        '&cup;' => '&#8746;',
        '&int;' => '&#8747;',
        '&there4;' => '&#8756;',
        '&sim;' => '&#8764;',
        '&cong;' => '&#8773;',
        '&asymp;' => '&#8776;',
        '&ne;' => '&#8800;',
        '&equiv;' => '&#8801;',
        '&le;' => '&#8804;',
        '&ge;' => '&#8805;',
        '&sub;' => '&#8834;',
        '&sup;' => '&#8835;',
        '&nsub;' => '&#8836;',
        '&sube;' => '&#8838;',
        '&supe;' => '&#8839;',
        '&oplus;' => '&#8853;',
        '&otimes;' => '&#8855;',
        '&perp;' => '&#8869;',
        '&sdot;' => '&#8901;',
        '&lceil;' => '&#8968;',
        '&rceil;' => '&#8969;',
        '&lfloor;' => '&#8970;',
        '&rfloor;' => '&#8971;',
        '&lang;' => '&#9001;',
        '&rang;' => '&#9002;',
        '&loz;' => '&#9674;',
        '&spades;' => '&#9824;',
        '&clubs;' => '&#9827;',
        '&hearts;' => '&#9829;',
        '&diams;' => '&#9830;',
        '&quot;' => '&#34;',
        '&amp;' => '&#38;',
        '&lt;' => '&#60;',
        '&gt;' => '&#62;',
        '&OElig;' => '&#338;',
        '&oelig;' => '&#339;',
        '&Scaron;' => '&#352;',
        '&scaron;' => '&#353;',
        '&Yuml;' => '&#376;',
        '&circ;' => '&#710;',
        '&tilde;' => '&#732;',
        '&ensp;' => '&#8194;',
        '&emsp;' => '&#8195;',
        '&thinsp;' => '&#8201;',
        '&zwnj;' => '&#8204;',
        '&zwj;' => '&#8205;',
        '&lrm;' => '&#8206;',
        '&rlm;' => '&#8207;',
        '&ndash;' => '&#8211;',
        '&mdash;' => '&#8212;',
        '&lsquo;' => '&#8216;',
        '&rsquo;' => '&#8217;',
        '&sbquo;' => '&#8218;',
        '&ldquo;' => '&#8220;',
        '&rdquo;' => '&#8221;',
        '&bdquo;' => '&#8222;',
        '&dagger;' => '&#8224;',
        '&Dagger;' => '&#8225;',
        '&permil;' => '&#8240;',
        '&lsaquo;' => '&#8249;',
        '&rsaquo;' => '&#8250;',
        '&euro;' => '&#8364;',
    );

    return preg_replace("/(&[a-z0-9]+;?)/iu", " ", strtr($string, $entity_to_decimal));
}

function strip_paragraphs($string)
{
    $replacement = array(
        '/<p[^>]*>(\r\n|\n|\r)?/iUu' => '',
        '/<\/p[^>]*>(\r\n|\n|\r)?/iUu' => '',
        '/<br\s*\/?>(\r\n|\n|\r)?/iu' => "\r\n"
    );

    $string = preg_replace(
        array_keys($replacement),
        array_values($replacement),
        $string
    );

    return implode(
        "\n",
        array_map('trim', explode("\n", $string))
    );
}

function range_keys($low, $high)
{
    return array_combine(range($low, $high), range($low, $high));
}

function in_range($var, $low, $high)
{
    return in_array($var, range($low, $high));
}

function array_isearch($needle, $haystack)
{
    foreach ($haystack as $key => $value) {
        if (strcasecmp($needle, $value) == 0) return $key;
    }

    return false;
}

function array_keys_exist()
{
    $keys = func_get_args();

    $array = array_shift($keys);

    if (!is_array($array)) return false;

    return array_intersect($keys, array_keys($array)) === $keys;
}

function is_md5($hash)
{
    if (preg_match("/^[A-Fa-f0-9]{32}$/Du", $hash) > 0) {
        return true;
    }

    return false;
}

function format_age($dob)
{
    $matches_array = array();

    if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/u', $dob, $matches_array)) {

        list(, $birth_year, $birth_month, $birth_day) = $matches_array;

        list($today_day, $today_month, $today_year) = explode('-', date('j-n-Y', user_get_local_time()));

        $age = ($today_year - $birth_year);

        if (($today_month < $birth_month) || (($today_month == $birth_month) && ($today_day < $birth_day))) $age -= 1;

        return $age;
    }

    return false;
}

function format_birthday($date)
{
    $matches_array = array();

    if (preg_match('/[0-9]{4}-([0-9]{2})-([0-9]{2})/u', $date, $matches_array)) {

        list(, $month, $day) = $matches_array;

        $month = floor($month);
        $day = floor($day);

        $timestamp = mktime(0, 0, 0, $month, $day, date('Y'));

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {

            return strftime('%#d %b', $timestamp);

        } else {

            return strftime('%e %b', $timestamp);
        }
    }

    return false;
}

function split_url($url, $inc_path = false, $inc_query = false, $inc_fragment = false)
{
    if (($url_parts = @parse_url($url)) !== false) {

        if (!isset($url_parts['scheme'])) return false;
        if (!isset($url_parts['host'])) return false;

        $url_split = "{$url_parts['scheme']}://{$url_parts['host']}/";
        if ($inc_path === true) $url_split .= "{$url_parts['path']}";
        if ($inc_query === true) $url_split .= "{$url_parts['query']}";
        if ($inc_fragment === true) $url_split .= "{$url_parts['fragment']}";

        return $url_split;
    }

    return $url;
}

function flatten_array($array, &$result_keys, &$result_values, $key_str = "")
{
    foreach ($array as $key => $value) {

        if (is_array($value)) {

            if (strlen($key_str) > 0) {

                flatten_array($value, $result_keys, $result_values, "{$key_str}[{$key}]");

            } else {

                flatten_array($value, $result_keys, $result_values, $key);
            }

        } else {

            if (strlen($key_str) > 0) {

                $result_keys[] = "{$key_str}[{$key}]";
                $result_values[] = $value;

            } else {

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

function implode_assoc($array, $separator = ': ', $glue = ', ')
{
    if (!is_array($array)) return false;
    if (!is_string($separator)) return false;
    if (!is_string($glue)) return false;

    $result_array = array();

    foreach ($array as $key => $value) {
        $result_array[] = $key . $separator . $value;
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

    $uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $uri .= (isset($uri_array['host'])) ? "{$uri_array['host']}" : '';
    $uri .= (isset($uri_array['port'])) ? ":{$uri_array['port']}" : '';
    $uri .= (isset($uri_array['path'])) ? "{$uri_array['path']}" : '';
    $uri .= (isset($uri_array['query'])) ? "?{$uri_array['query']}" : '';
    $uri .= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';

    return $uri;
}

function get_request_uri($include_webtag = true, $encode_uri_query = true)
{
    if (!is_bool($include_webtag)) $include_webtag = true;
    if (!is_bool($encode_uri_query)) $encode_uri_query = true;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $request_uri = basename($_SERVER['PHP_SELF']);

    $query_string_array = $_GET;

    unset($query_string_array['webtag']);

    if ($include_webtag && $webtag) {
        $query_string_array['webtag'] = $webtag;
    }

    $query_string = http_build_query($query_string_array, null, (($encode_uri_query) ? '&amp;' : '&'));

    return (strlen($query_string) > 0) ? sprintf('%s?%s', $request_uri, $query_string) : $request_uri;
}

function calculate_page_offset($page, $limit)
{
    return intval((abs($page) * abs($limit)) - abs($limit));
}

function print_r_pre($expression, $return = false)
{
    $result = sprintf('<pre style="text-align: left">%s</pre>', print_r($expression, true));

    if (!$return) {
        echo $result;
        return true;
    }

    return $result;
}

function var_dump_pre()
{
    echo '<pre style="text-align: left">';
    call_user_func_array('var_dump', func_get_args());
    echo '</pre>';
}

function wordwrap_html($content, $width = 75, $break = '<br />', $cut = false)
{
    $content_parts = preg_split('/([<|>])/u', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($content_parts as $key => $content_part) {

        if (($key % 4)) {
            continue;
        }

        $content_parts[$key] = wordwrap($content_part, $width, $break, $cut);
    }

    return implode('', $content_parts);
}