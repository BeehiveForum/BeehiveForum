<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or
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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'lang.inc.php';

function get_available_timezones()
{
    return array(1 => "(GMT-12:00) International Date Line West",
                 2 => "(GMT-11:00) Midway Island Samoa",
                 3 => "(GMT-10:00) Hawaii",
                 4 => "(GMT-09:00) Alaska",
                 5 => "(GMT-08:00) Pacific Time (US & Canada); Tijuana",
                 6 => "(GMT-07:00) Arizona",
                 7 => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
                 8 => "(GMT-07:00) Mountain Time (US & Canada)",
                 9 => "(GMT-06:00) Central America",
                 10 => "(GMT-06:00) Central Time (US & Canada)",
                 11 => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
                 12 => "(GMT-06:00) Saskatchewan",
                 13 => "(GMT-05:00) Bogota, Lime, Quito",
                 14 => "(GMT-05:00) Eastern Time (US & Canada)",
                 15 => "(GMT-05:00) Indiana (East)",
                 16 => "(GMT-04:00) Atlantic Time (Canada)",
                 17 => "(GMT-04:00) Caracas, La Paz",
                 18 => "(GMT-04:00) Santiago",
                 19 => "(GMT-03:30) Newfoundland",
                 20 => "(GMT-03:00) Brasilia",
                 21 => "(GMT-03:00) Buenos Aires, Georgetown",
                 22 => "(GMT-03:00) Greenland",
                 23 => "(GMT-02:00) Mid-Atlantic",
                 24 => "(GMT-01:00) Azores",
                 25 => "(GMT-01:00) Cape Verde Is.",
                 26 => "(GMT) Casablanca, Monrovia",
                 27 => "(GMT) Dublin, Edinburgh, Lisbon, London",
                 28 => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
                 29 => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
                 30 => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
                 31 => "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
                 32 => "(GMT+01:00) West Central Africa",
                 33 => "(GMT+02:00) Athens, Istanbul, Minsk",
                 34 => "(GMT+02:00) Bucharest",
                 35 => "(GMT+02:00) Cairo",
                 36 => "(GMT+02:00) Harare, Pretoria",
                 37 => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
                 38 => "(GMT+02:00) Jerusalem",
                 39 => "(GMT+03:00) Baghdad",
                 40 => "(GMT+03:00) Kuwait, Riyadh",
                 41 => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
                 42 => "(GMT+03:00) Nairobi",
                 43 => "(GMT+03:30) Tehran",
                 44 => "(GMT+04:00) Abu Dhabi, Muscat",
                 45 => "(GMT+04:00) Baku, Tbilisi, Yerevan",
                 46 => "(GMT+04:30) Kabul",
                 47 => "(GMT+05:00) Ekaterinburg",
                 48 => "(GMT+05:00) Islamabad, Karachi, Tashkent",
                 49 => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
                 50 => "(GMT+05.75) Kathmandu",
                 51 => "(GMT+06:00) Almaty, Novosibirsk",
                 52 => "(GMT+06:00) Astana, Dhaka",
                 53 => "(GMT+06:00) Sri Jayawardenepura",
                 54 => "(GMT+06:30) Rangoon",
                 55 => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
                 56 => "(GMT+07:00) Krasnoyarsk",
                 57 => "(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi",
                 58 => "(GMT+08:00) Irkutsk, Ulaan Bataar",
                 59 => "(GMT+08:00) Kuala Lumpur, Singapore",
                 60 => "(GMT+08:00) Perth",
                 61 => "(GMT+08:00) Taipei",
                 62 => "(GMT+09:00) Osaka, Sapporo, Tokyo",
                 63 => "(GMT+09:00) Seoul",
                 64 => "(GMT+09:00) Yakutsk",
                 65 => "(GMT+09:30) Adelaide",
                 66 => "(GMT+09:30) Darwin",
                 67 => "(GMT+10:00) Brisbane",
                 68 => "(GMT+10:00) Canberra, Melbourne, Sydney",
                 69 => "(GMT+10:00) Guam, Port Moresby",
                 70 => "(GMT+10:00) Hobart",
                 71 => "(GMT+10:00) Vladivostok",
                 72 => "(GMT+11:00) Magadan, Solomon Is., New Caledonia",
                 73 => "(GMT+12:00) Auckland, Wellington",
                 74 => "(GMT+12:00) Figi, Kamchatka, Marshall Is.",
                 75 => "(GMT+13:00) Nuku'alofa");
}

function timezone_id_to_string($timezone_id)
{
    $timezones_array = get_available_timezones();

    if (isset($timezones_array[$timezone_id])) return $timezones_array[$timezone_id];

    return gettext("Unknown");
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
            if (afterSecondDayInMonth($cur_year, $cur_year, 10, "Sat", $gmt_offset) &&
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
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun") &&
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
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun") &&
            beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 35:    /*    Cairo, Egypt */
            if (afterLastDayInMonth($cur_year, $cur_year, 4, "Fri") &&
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
            if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun") &&
            beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 65:    /*    Adelaide */
        case 68:    /*    Canberra, Melbourne, Sydney */
            if (beforeFirstDayInMonth($cur_year, $cur_year, 4, "Sun", $gmt_offset) ||
            afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 70:    /*    Hobart */
            if (beforeFirstDayInMonth($cur_year, $cur_year, 4, "Sun", $gmt_offset) ||
            afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
                return true;
            else
                return false;
            break;

        case 73:    /*    Auckland, Wellington */
            if (beforeFirstDayInMonth($cur_year, $cur_year, 4, "Sun", $gmt_offset) ||
            afterLastDayInMonth($cur_year, $cur_year, 9, "Sun"))
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

function afterLastDayInMonth($curYear, $year, $month, $day)
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