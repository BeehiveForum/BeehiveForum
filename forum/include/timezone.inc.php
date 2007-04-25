<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or
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

/* $Id: timezone.inc.php,v 1.3 2007-04-25 22:05:34 decoyduck Exp $ */

/**
* timezone.inc.php - International Timezones with DST support
*
* Uses code available at :
*
*  http://www.anicon.ca/timezone-script.php
*  By Tom Watts <wattst@uoguelph.ca> or <tomwatts@secondsite.biz>
*
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

function timestamp_is_dst($timezoneid, $gmt_offset)
{
    $gmt_minute = gmdate("i");
    $gmt_hour = gmdate("H");
    $gmt_month = gmdate("m");
    $gmt_day = gmdate("d");
    $gmt_year = gmdate("Y");
    $cur_year = date("Y", mktime($gmt_hour + $gmt_offset, $gmt_minute, 0, $gmt_month, $gmt_day, $gmt_year));

    switch ($timezoneid) {

        case 4:     /*    Alaska */
        case 5:     /*    Pacific Time (US & Canada); Tijuana */
        case 8:     /*    Mountain Time (US & Canada) */
        case 10:    /*    Central Time (US & Canada) */
        case 11:    /*    Guadalajara, Mexico City, Monterrey */
        case 14:    /*    Eastern Time (US & Canada) */
        case 16:    /*    Atlantic Time (Canada) */
        case 19:    /*    Newfoundland */
            if (afterSecondDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
            beforeFirstDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 7:        /*    Chihuahua, La Paz, Mazatlan */
            if (afterFirstDayInMonth($cur_year, $cur_year, 5, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 18:    /*    Santiago, Chile */
            if (afterSecondDayInMonth($cur_year, 10, "Sat", $gmt_offset) &&
            beforeSecondDayInMonth($cur_year + 1, $cur_year, 3, "Sat", $gmt_offset))
                return true;

            else
                return false;
            break;

        case 20:    /*    Brasilia, Brazil */
            if (afterFirstDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset) &&
            beforeThirdDayInMonth($cur_year, $cur_year, 2, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 23:    /*    Mid-Atlantic */
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 22:    /*    Greenland */
        case 24:    /*    Azores */
        case 27:    /*    Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London */
        case 28:    /*    Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna */
        case 29:    /*    Belgrade, Bratislava, Budapest, Ljubljana, Prague */
        case 30:    /*    Brussels, Copenhagen, Madrid, Paris */
        case 31:    /*    Sarajevo, Skopje, Warsaw, Zagreb */
        case 33:    /*    Athens, Istanbul, Minsk */
        case 34:    /*    Bucharest */
        case 37:    /*    Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius */
        case 41:    /*    Moscow, St. Petersburg, Volgograd */
        case 47:    /*    Ekaterinburg */
        case 45:    /*    Baku, Tbilisi, Yerevan */
        case 51:    /*    Almaty, Novosibirsk */
        case 56:    /*    Krasnoyarsk */
        case 58:    /*    Irkutsk, Ulaan Bataar */
        case 64:    /*    Yakutsk, Sibiria */
        case 71:    /*    Vladivostok */
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 35:    /*    Cairo, Egypt */
            if (afterLastDayInMonth($cur_year, $cur_year, 4, "Fri", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year, 9, "Thu", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 39:    /*    Baghdad, Iraq */
            if (afterFirstOfTheMonth($cur_year, $cur_year, 4, $gmt_offset) &&
            beforeFirstOfTheMonth($cur_year, $cur_year, 10, $gmt_offset))
                return true;
            else
                return false;
            break;

        case 43:    /*    Tehran, Iran - Note: This is an approximation to 
                        the actual DST dates since Iran goes by the Persian
                        calendar.  There are tools for converting between
                        Gregorian and Persian calendars at www.farsiweb.info.
                        This may be added at a later date for better accuracy */
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 65:    /*    Adelaide */
        case 68:    /*    Canberra, Melbourne, Sydney */
            if (afterLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 70:    /*    Hobart */
            if (afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
            beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 73:    /*    Auckland, Wellington */
            if (afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
            beforeThirdDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        default:
            break;
    }
    return false;
}

function afterFirstDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    for ($i = 1; $i < 8; $i++) {
        
        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $first_day = $i;
            break;
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $first_day_stamp = mktime(2, 0, 0, $month, $first_day, $year);

    if ($cur_stamp >= $first_day_stamp) return true;

    return false;
}

function beforeLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $days_in_month = getDaysInMonth($month);

    for ($i = $days_in_month; $i > ($days_in_month - 8); $i--) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $last_day = $i;
            break;
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $last_sun_stamp = mktime(2, 0, 0, $month, $last_day, $year);

    if ($cur_stamp < $last_sun_stamp) return true;

    return false;
}

function afterLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $days_in_month = getDaysInMonth($month);

    for ($i = $days_in_month; $i > ($days_in_month - 8); $i--) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $last_day = $i;
            break;
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");

    $curHour = gmdate("H");

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $last_day_stamp = mktime(1, 0, 0, $month, $last_day, $year);

    if ($cur_stamp >= $last_day_stamp) return true;

    return false;
}

function afterFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
{
    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $last_day_stamp = mktime(3, 0, 0, $month, 1, $year);

    if ($cur_stamp >= $last_day_stamp) return true;

    return false;
}

function beforeFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
{
    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $first_day_stamp = mktime(3, 0, 0, $month, 1, $year);

    if ($cur_stamp < $first_day_stamp) return true;

    return false;
}

function beforeThirdDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $count = 0;

    for ($i = 1; $i < 22; $i++) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $count++;

            if ($count == 3) {

                $third_day = $i;
                break;
            }
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $third_day_stamp = mktime(2, 0, 0, $month, $third_day, $year);

    if ($cur_stamp < $third_day_stamp) return true;

    return false;
}

function beforeSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $count = 0;

    for ($i = 1; $i < 15; $i++) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $count++;

            if ($count == 2) {

                $second_day = $i;
                break;
            }
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

    if ($cur_stamp < $second_day_stamp) return true;

    return false;
}

function beforeFirstDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $count = 0;

    for ($i = 1; $i < 7; $i++) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $first_day = $i;
            break;
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $second_day_stamp = mktime(0, 0, 0, $month, $first_day, $year);

    if ($cur_stamp < $second_day_stamp) return true;

    return false;
}

function afterSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
{
    $count = 0;

    for ($i = 1; $i < 15; $i++) {

        if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {

            $count++;

            if ($count == 2) {

                $second_day = $i;
                break;
            }
        }
    }

    $curDay = gmdate("d");
    $curMonth = gmdate("m");
    $curHour = gmdate("H") + $gmt_offset;

    $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

    $second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

    if ($cur_stamp >= $second_day_stamp) return true;

    return false;
}

function getDaysInMonth($month)
{
    switch ($month) {

        case 2:
            return (date("L") ? 29 : 28);
            break;
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
            break;
        default:
            return 30;
            break;
    }
}

?>