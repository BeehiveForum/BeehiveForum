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
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'lang.inc.php';
// End Required includes

function form_csrf_token_field()
{
    if (!($token_name = forum_get_setting('csrf_token_name'))) {
        forum_save_settings(array('csrf_token_name' => $token_name = md5(uniqid(mt_rand()))));
    }

    return form_input_hidden($token_name, session::get_csrf_token());
}

function form_check_csrf_token()
{
    if (!isset($_SERVER['REQUEST_METHOD']) || mb_strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
        return;
    }

    if (in_array(basename($_SERVER['PHP_SELF']), get_csrf_exempt_files())) {
        return;
    }

    if (!($token_name = forum_get_setting('csrf_token_name'))) {
        html_draw_error(gettext('Sorry, you do not have access to this page.'));
    }

    if (!isset($_POST[$token_name]) || ($_POST[$token_name] != session::get_csrf_token())) {

        unset($_POST[$token_name]);

        session::refresh_csrf_token();

        html_draw_error(gettext('Sorry, you do not have access to this page.'));
    }

    unset($_POST[$token_name]);
}

// Create a form field
function form_field($name, $value = null, $width = null, $maxchars = null, $type = 'text', $custom_html = null, $class = 'bhinputtext', $placeholder = null, $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    $html = "<input type=\"$type\" name=\"$name\" id=\"$id\" class=\"$class\" value=\"$value\"";

    if (isset($custom_html) && is_string($custom_html)) {
        $html .= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($width)) {
        $html .= " size=\"$width\"";
    }

    if (is_numeric($maxchars)) {
        $html .= " maxlength=\"$maxchars\"";
    }

    if (isset($placeholder) && is_string($placeholder)) {
        $html .= " placeholder=\"$placeholder\"";
    }

    return $html . " dir=\"" . gettext("ltr") . "\" />";
}

// Creates a text input field
function form_input_text($name, $value = null, $width = null, $maxchars = null, $custom_html = null, $class = 'bhinputtext', $placeholder = null)
{
    return form_field($name, $value, $width, $maxchars, "text", $custom_html, $class, $placeholder);
}

// Creates a password input field
function form_input_password($name, $value = null, $width = null, $maxchars = null, $custom_html = null, $class = 'bhinputtext', $placeholder = null)
{
    return form_field($name, $value, $width, $maxchars, "password", $custom_html, $class, $placeholder);
}

// Creates a file upload field
function form_input_file($name, $value = null, $width = null, $maxchars = null, $custom_html = null, $class = 'bhinputtext', $placeholder = null)
{
    return form_field($name, $value, $width, $maxchars, "file", $custom_html, $class, $placeholder);
}

// Creates a hidden form field
function form_input_hidden($name, $value = null, $custom_html = null)
{
    return form_field($name, $value, null, null, "hidden", $custom_html);
}

function form_input_text_search($name, $value = null, $width = null, $maxchars = null, $type = SEARCH_LOGON, $allow_multi = false, $custom_html = null, $class = null, $placeholder = null)
{
    $type = ($type == SEARCH_LOGON) ? 'search_logon' : 'search_thread';

    $classes = array(
        $class,
        $type,
        'search_input'
    );

    if ($allow_multi) $classes[] = 'allow_multi';

    return form_input_text($name, $value, $width, $maxchars, $custom_html, implode(' ', $classes), $placeholder);
}

function form_input_hidden_array($array)
{
    if (!is_array($array)) return false;

    $array_keys = array();
    $array_values = array();

    flatten_array($array, $array_keys, $array_values);

    $result_var = '';

    foreach ($array_keys as $key => $key_name) {

        if (($key_name != 'webtag') && isset($array_values[$key])) {

            $result_var .= form_input_hidden(htmlentities_array($key_name), htmlentities_array($array_values[$key]));
        }
    }

    return $result_var;
}

// Create a textarea input field
function form_textarea($name, $value, $rows, $cols, $custom_html = null, $class = 'bhtextarea', $placeholder = null, $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    $html = "<textarea name=\"$name\" id=\"$id\" class=\"$class\"";

    if (isset($custom_html) && is_string($custom_html)) {
        $html .= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($rows)) {
        $html .= " rows=\"$rows\"";
    }

    if (is_numeric($cols)) {
        $html .= " cols=\"$cols\"";
    }

    if (isset($placeholder) && is_string($placeholder)) {
        $html .= " placeholder=\"$placeholder\"";
    }

    return $html . " dir=\"" . gettext("ltr") . "\">$value</textarea>";
}

// Creates a dropdown with values from array(s)
function form_dropdown_array($name, $options_array, $default = null, $custom_html = null, $class = 'bhselect', $group_class = 'bhselectoptgroup', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    $html = "<select name=\"$name\" id=\"$id\" class=\"$class\"";

    if (isset($custom_html) && is_string($custom_html)) {
        $html .= sprintf(" %s", trim($custom_html));
    }

    $html .= ">";

    if (is_array($options_array)) {

        foreach ($options_array as $option_key => $option_text) {

            if (is_array($option_text) && isset($option_text['subitems']) && sizeof($option_text['subitems']) > 0) {

                $html .= form_dropdown_objgroup_array($option_key, $option_text['subitems'], $default, $group_class);

            } else if (is_array($option_text) && isset($option_text['name']) && is_string($option_text['name'])) {

                $option_text_name = trim($option_text['name']);

                if (isset($option_text['class']) && is_string($option_text['class'])) {
                    $option_text_class = trim($option_text['class']);
                } else {
                    $option_text_class = '';
                }

                $selected = (mb_strtolower($option_key) == mb_strtolower($default)) ? " selected=\"selected\"" : "";
                $html .= "  <option value=\"{$option_key}\" class=\"$option_text_class\"$selected>$option_text_name</option>";

            } else if (!is_array($option_text)) {

                $selected = (mb_strtolower($option_key) == mb_strtolower($default)) ? " selected=\"selected\"" : "";
                $html .= "  <option value=\"{$option_key}\"$selected>$option_text</option>";
            }
        }
    }

    return $html . "</select>";
}

// Creates a optgroup to be used in a dropdown.
function form_dropdown_objgroup_array($name, $options_array, $default = null, $class = 'bhselectoptgroup')
{
    if (!is_array($options_array)) {
        return null;
    }

    $html = "<optgroup label=\"$name\" class=\"$class\">";

    foreach ($options_array as $option_key => $option_text) {

        if (is_array($option_text) && isset($option_text['subitems']) && sizeof($option_text['subitems']) > 0) {

            $html .= form_dropdown_objgroup_array($option_key, $option_text['subitems'], $default, $class);

        } else if (is_array($option_text) && isset($option_text['name']) && is_string($option_text['name'])) {

            $option_text_name = trim($option_text['name']);

            if (isset($option_text['class']) && is_string($option_text['class'])) {
                $option_text_class = trim($option_text['class']);
            } else {
                $option_text_class = '';
            }

            $selected = (mb_strtolower($option_key) == mb_strtolower($default)) ? " selected=\"selected\"" : "";
            $html .= "  <option value=\"{$option_key}\" class=\"$option_text_class\"$selected>$option_text_name</option>";

        } else if (!is_array($option_text)) {

            $selected = (mb_strtolower($option_key) == mb_strtolower($default)) ? " selected=\"selected\"" : "";
            $html .= "  <option value=\"{$option_key}\"$selected>$option_text</option>";
        }
    }

    return $html;
}

function form_unique_id($name)
{
    static $form_name_array = array();

    $name = preg_replace('/[^a-z0-9_]+/iu', '', $name);

    if (isset($form_name_array[$name])) {

        $form_name_array[$name]++;
        return $name . $form_name_array[$name];
    }

    $form_name_array[$name] = 0;

    return $name;
}

// Creates a checkbox field
function form_checkbox($name, $value, $text = null, $checked = false, $custom_html = null, $class = 'bhinputcheckbox', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    $html = "<span class=\"$class\">";
    $html .= "<input type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) {
        $html .= " checked=\"checked\"";
    }

    if (isset($custom_html) && is_string($custom_html)) {
        $html .= sprintf(" %s", trim($custom_html));
    }

    $html .= " />";

    if (is_array($text) && sizeof($text) > 0) {

        $html .= "<label for=\"$id\">";

        foreach ($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html .= $text_part;

            } else {

                $html .= "</label>$text_part<label for=\"$id\">";
            }
        }

        $html .= "</label>";

    } else if (isset($text) && is_string($text)) {

        $html .= "<label for=\"$id\">$text</label>";
    }

    return $html . "</span>";
}

// Create a radio field
function form_radio($name, $value, $text = null, $checked = false, $custom_html = null, $class = 'bhinputradio', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    $html = "<span class=\"$class\">";
    $html .= "<input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) {
        $html .= " checked=\"checked\"";
    }

    if (isset($custom_html) && is_string($custom_html)) {
        $html .= sprintf(" %s", trim($custom_html));
    }

    $html .= " />";

    if (is_array($text) && sizeof($text) > 0) {

        $html .= "<label for=\"$id\">";

        foreach ($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html .= $text_part;

            } else {

                $html .= "</label>$text_part<label for=\"$id\">";
            }
        }

        $html .= "</label>";

    } else if (isset($text) && is_string($text)) {

        $html .= "<label for=\"$id\">$text</label>";
    }

    return $html . "</span>";
}

// Create an array of radio fields.
function form_radio_array($name, $options_array, $checked = false, $custom_html = null)
{
    $html = '';

    foreach ($options_array as $option_key => $option_text) {

        if (!is_array($option_text)) {

            $html .= form_radio($name, $option_key, $option_text, ($checked == $option_key), $custom_html);
        }
    }

    return $html;
}

// Creates a form submit button
function form_submit($name = "submit", $value = 'Submit', $custom_html = null, $class = 'button', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    if (isset($custom_html) && is_string($custom_html)) {
        $custom_html = sprintf(" %s", trim($custom_html));
    }

    $html = '<input type="submit" name="%s" id="%s" class="%s"%s value="%s" />';

    return sprintf($html, $name, $id, $class, $custom_html, $value);
}

// Creates a form submit button using an image
function form_submit_image($image, $name = "submit", $value = 'Submit', $custom_html = null, $class = 'button_image', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    if (isset($custom_html) && is_string($custom_html)) {
        $custom_html = sprintf(" %s", trim($custom_html));
    }

    $html = '<input type="image" name="%s" id="%s" class="image %s %s"%s value="%s" />';

    return sprintf($html, $name, $id, $class, $image, $custom_html, $value);
}

// Creates a button with custom HTML, for onclick methods, etc.
function form_button($name, $value, $custom_html = null, $class = 'button', $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    if (isset($custom_html) && is_string($custom_html)) {
        $custom_html = sprintf(" %s", trim($custom_html));
    }

    $html = '<input type="button" name="%s" id="%s" class="%s"%s value="%s" />';

    return sprintf($html, $name, $id, $class, $custom_html, $value);
}

// Creates a HTML <button> with custom innerHTML
function form_button_html($name, $type, $class, $inner_html, $custom_html = null, $id = null)
{
    $id = $id ? $id : form_unique_id($name);

    if (isset($custom_html) && is_string($custom_html)) {
        $custom_html = sprintf(" %s", trim($custom_html));
    }

    return sprintf('<button type="%s" name="%s" id="%s" class="%s"%s>%s</button>', $type, $name, $id, $class, $custom_html, $inner_html);
}

// create a form just to be a link button
// $var_array is an array (key, value pairs) containing names
// and values to be used for hidden form fields. Multi-dimensional
// arrays will be ignored.
function form_quick_button($href, $button_label, $var_array = null, $target = '_self', $button_custom_html = null, $button_class = 'button', $button_id = null)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $html = "<form accept-charset=\"utf-8\" method=\"get\" action=\"$href\" target=\"$target\">";
    $html .= form_input_hidden("webtag", htmlentities_array($webtag));

    if (is_array($var_array)) {

        foreach ($var_array as $var_name => $var_value) {

            if (!is_array($var_value)) {

                $html .= form_input_hidden($var_name, htmlentities_array($var_value));
            }
        }
    }

    $html .= form_submit(form_unique_id('submit'), $button_label, $button_custom_html, $button_class, $button_id);

    return $html . "</form>";
}

// create the date of birth dropdowns for prefs. $show_blank controls whether to show
// a blank option in each box for backwards compatibility with 0.3 and below,
// where the DOB was not required information
function form_dob_dropdowns($dob_year, $dob_month, $dob_day, $show_blank = true, $custom_html = null, $class = 'bhselect')
{
    if ($show_blank) {

        $birthday_days = array_merge(array('&nbsp;'), range(1, 31));
        $birthday_months = array_merge(array('&nbsp;'), lang_get_month_names());

        $birthday_years = array(
                '&nbsp;'
            ) + range_keys(1900, date('Y', time()));

    } else {

        $birthday_days = range_keys(1, 31);
        $birthday_months = lang_get_month_names();
        $birthday_years = range_keys(1900, date('Y', time()));
    }

    $output = form_dropdown_array("dob_day", $birthday_days, $dob_day, $custom_html, $class) . "&nbsp;";
    $output .= form_dropdown_array("dob_month", $birthday_months, $dob_month, $custom_html, $class) . "&nbsp;";
    $output .= form_dropdown_array("dob_year", $birthday_years, $dob_year, $custom_html, $class) . "&nbsp;";

    return $output;
}

// Creates a dropdown selectors for dates
// including seperate fields for day, month and year.
function form_date_dropdowns($year = null, $month = null, $day = null, $prefix = null, $start_year = null)
{
    // the end of 2037 is more or less the maximum time that
    // can be represented as a UNIX timestamp currently
    if (is_numeric($start_year)) {

        $years = array(
                '&nbsp;'
            ) + range_keys($start_year, 2037);

    } else {

        $years = array(
                '&nbsp;'
            ) + range_keys(date('Y', time()), 2037);
    }

    $days = array_merge(array('&nbsp;'), range(1, 31));
    $months = array_merge(array('&nbsp;'), lang_get_month_names());

    $output = form_dropdown_array("{$prefix}day", $days, $day) . "&nbsp;";
    $output .= form_dropdown_array("{$prefix}month", $months, $month) . "&nbsp;";
    $output .= form_dropdown_array("{$prefix}year", $years, $year) . "&nbsp;";

    return $output;
}