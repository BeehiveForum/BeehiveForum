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

/* $Id: form.inc.php,v 1.71 2005-03-15 21:29:46 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

// Create a form field

function form_field($name, $value = false, $width = false, $maxchars = false, $type = "text", $custom_html = false, $class = "bhinputtext")
{
    $lang = load_language_file();

    $html = "<input type=\"$type\" name=\"$name\" id=\"$name\" class=\"$class\" value=\"$value\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    if ($width) {
        $width = (int)trim($width);
        $html.= "size=\"$width\" ";
    }

    if ($maxchars) {
        $maxchars = (int)trim($maxchars);
        $html.= "maxlength=\"$maxchars\" ";
    }

    $html.= "dir=\"{$lang['_textdir']}\" />";
    return $html;
}

// Generate unique form id

function form_unique_id()
{
    return preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
}

// Creates a text input field

function form_input_text($name, $value = false, $width = false, $maxchars = false, $custom_html = false, $class = "bhinputtext")
{
    return form_field($name, $value, $width, $maxchars, "text", $custom_html, $class);
}

// Creates a password input field

function form_input_password($name, $value = false, $width = false, $maxchars = false, $custom_html = false, $class = "bhinputtext")
{
    return form_field($name, $value, $width, $maxchars, "password", $custom_html, $class);
}

// Creates a hidden form field

function form_input_hidden($name, $value = false, $custom_html = false)
{
    return form_field($name, $value, 0, 0, "hidden", $custom_html);
}

// Create a textarea input field

function form_textarea($name, $value, $rows, $cols, $wrap = "virtual", $custom_html = false, $class = "bhtextarea")
{
    $lang = load_language_file();

    $html = "<textarea name=\"$name\" id=\"$name\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    if ($rows) {
        $rows = (int)trim($rows);
        $html.= "rows=\"$rows\" ";
    }

    if ($cols) {
        $cols = (int)trim($cols);
        $html.= "cols=\"$cols\" ";
    }

    $html.= "dir=\"{$lang['_textdir']}\">$value</textarea>";
    return $html;
}

// Creates a dropdown with values from array(s)

function form_dropdown_array($name, $value, $label, $default = false, $custom_html = false, $class = "bhselect")
{
    $lang = load_language_file();

    $html = "<select name=\"$name\" id=\"$name\" class=\"$class\" ";

    if ($custom_html) {

        $custom_html = trim($custom_html);
        $html.= " $custom_html";
    }

    $html.= ">";

    if (is_array($value)) {

        foreach ($value as $key => $value_text) {

            $sel = (strtolower($value_text) == strtolower($default)) ? " selected=\"selected\"" : "";

            if (isset($label[$key])) {

                $html.= "<option value=\"{$value_text}\"$sel>{$label[$key]}</option>";

            }else {

                $html.= "<option$sel>{$value_text}</option>";
            }
        }
    }

    $html.= "</select>";
    return $html;
}

// Creates a checkbox field

function form_checkbox($name, $value, $text, $checked = false, $custom_html = false, $class = "bhinputcheckbox")
{
    $id = form_unique_id();

    $html = "<span class=\"$class\">";
    $html.= "<input type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) $html.= " checked=\"checked\"";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= " $custom_html ";
    }

    $html.= "/><label for=\"$id\">";

    if (is_array($text)) {

        foreach($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html.= $text_part;

            }else {

                $html.= "</label>$text_part<label for=\"$id\">";
            }
        }

    }else {

        $html.= $text;
    }

    $html.= "</label></span>";

    return $html;
}

// Create a radio field

function form_radio($name, $value, $text, $checked = false, $custom_html = false, $class = "bhinputradio")
{
    $id = form_unique_id();

    $html = "<span class=\"$class\">";
    $html.= "<input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) $html.= " checked=\"checked\"";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= " $custom_html ";
    }

    $html.= "/><label for=\"$id\">";

    if (is_array($text)) {

        foreach($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html.= $text_part;

            }else {

                $html.= "</label>$text_part<label for=\"$id\">";
            }
        }

    }else {

        $html.= $text;
    }

    $html.= "</label></span>";
    return $html;
}

// Create an array of radio fields.

function form_radio_array($name, $value, $text, $checked = false, $custom_html = false)
{
    for ($i = 0; $i < count($value); $i++) {
        if (isset($html)) {
            $html.= form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]), $custom_html);
        }else {
            $html = form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]), $custom_html);
        }
    }

    return $html;
}

// Creates a form submit button

function form_submit($name = "submit", $value = "Submit", $custom_html = false, $class = "button")
{
    $html = "<input type=\"submit\" name=\"$name\" id=\"$name\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a form submit button using an image

function form_submit_image($image, $name = "submit", $value = "Submit", $custom_html = false)
{
    $html = "<input name=\"$name\" value=\"$value\" id=\"$name\"";
    $html.= "type=\"image\" src=\"". style_image($image). "\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a form reset button

function form_reset($name = "reset", $value = "Reset", $custom_html = false, $class = "button")
{
    $html = "<input type=\"reset\" name=\"$name\" id=\"$name\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a button with custom HTML, for onclick methods, etc.

function form_button($name, $value, $custom_html, $class="button")
{
    $html = "<input type=\"button\" name=\"$name\" id=\"$name\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// create a form just to be a link button
// $var and $value can optionally be single-dimensional arrays
// containing names and values to be used for hidden form
// fields. Multi-dimensional arrays will be ignored.

function form_quick_button($href, $label, $var = false, $value = false, $target = "_self")
{
    $webtag = get_webtag($webtag_search);

    echo "<form name=\"f_quickbutton\" method=\"get\" action=\"$href\" ";
    echo "target=\"$target\">";
    echo "  ", form_input_hidden("webtag", $webtag), "\n";

    if ($var) {
        if (is_array($var)) {
            for ($i = 0; $i < count($var); $i++) {
                if (!is_array($var[$i])) {
                    echo form_input_hidden($var[$i], $value[$i]);
                }
            }
        }else {
            echo form_input_hidden($var, $value);
        }
    }

    echo form_submit(md5(uniqid(rand())), $label);
    echo "</form>";
}

// create the date of birth dropdowns for prefs. $show_blank controls whether to show
// a blank option in each box for backwards compatibility with 0.3 and below,
// where the DOB was not required information

function form_dob_dropdowns($dob_year, $dob_month, $dob_day, $show_blank = true)
{
    $lang = load_language_file();

    $birthday_days = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
                           '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
                           '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
                           '31');

    $birthday_months = array($lang['jan'], $lang['feb'], $lang['mar'], $lang['apr'],
                             $lang['may'], $lang['jun'], $lang['jul'], $lang['aug'],
                             $lang['sep'], $lang['oct'], $lang['nov'], $lang['dec']);

    $birthday_years = range(1900, date('Y', mktime()));

    if ($show_blank) {

        $birthday_days_values = range(0, 31);
        array_unshift($birthday_days, '&nbsp;');

        $birthday_months_values = range(0, 12);
        array_unshift($birthday_months, '&nbsp;');

        $birthday_years_values = $birthday_years;
        array_unshift($birthday_years_values, 0);
        array_unshift($birthday_years, '&nbsp;');

    }else {

        $birthday_days_values = range(1, 31);
        $birthday_months_values = range(1, 12);
        $birthday_years_values = $birthday_years;
    }

    $output = form_dropdown_array("dob_day", $birthday_days_values, $birthday_days, $dob_day);
    $output.= "&nbsp;";
    $output.= form_dropdown_array("dob_month", $birthday_months_values, $birthday_months, $dob_month);
    $output.= "&nbsp;";
    $output.= form_dropdown_array("dob_year", $birthday_years_values, $birthday_years, $dob_year);

    return $output;
}

// Creates an array of hidden form fields.
// Is multi-dimensional array safe.

function form_input_hidden_array($name, $value)
{
    if (is_array($value)) {

        foreach ($value as $array_key => $array_value) {

            if (isset($return)) {

                $return.= form_input_hidden_array("{$name}[{$array_key}]", $array_value);

            }else {

                $return = form_input_hidden_array("{$name}[{$array_key}]", $array_value);
            }
        }

    }else {

        if (isset($return)) {

            $return.= form_input_hidden($name, _stripslashes($value));

        }else {

            $return = form_input_hidden($name, _stripslashes($value));
        }
    }

    return $return;
}

// Creates a dropdown selectors for dates
// including seperate fields for day, month and year.

function form_date_dropdowns($year = 0, $month = 0, $day = 0, $prefix = false, $start_year = 0)
{
    $lang = load_language_file();

    $days = range(1,31);
    array_unshift($days, " ");

    $months = array(" ", $lang['jan'], $lang['feb'], $lang['mar'], $lang['apr'],
                    $lang['may'], $lang['jun'], $lang['jul'], $lang['aug'],
                    $lang['sep'], $lang['oct'], $lang['nov'], $lang['dec']);

    // the end of 2037 is more or less the maximum time that
    // can be represented as a UNIX timestamp currently

    if (is_numeric($start_year) && $start_year > 0 && $start_year < 2037) {

        $years = range($start_year, 2037);
        array_unshift($years, " ");

        $years_values = range($start_year, 2037);
        array_unshift($years_values, " ");

    }else {

        $years = range(date('Y'), 2037);
        array_unshift($years, " ");

        $years_values = range(date('Y'), 2037);
        array_unshift($years_values, " ");
    }

    $output = form_dropdown_array("{$prefix}day", range(0,31), $days, $day);
    $output.= "&nbsp;";
    $output.= form_dropdown_array("{$prefix}month", range(0, 12), $months, $month);
    $output.= "&nbsp;";
    $output.= form_dropdown_array("{$prefix}year", $years_values, $years, $year);

    return $output;
}

?>