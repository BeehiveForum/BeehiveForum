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

/* $Id: form.inc.php,v 1.24 2003-07-27 12:42:04 hodcroftcj Exp $ */

// form.inc.php : form item functions

require_once("./include/db.inc.php");
require_once("./include/lang.inc.php");

// create a <input type="text"> field
function form_field($name, $value = "", $width = 0, $maxchars = 0, $type = "text")
{

    global $lang;

    $html = "<input type=\"$type\" name=\"$name\" class=\"bhinputtext\"";
    $html.= " value=\"$value\"";

    if($width) $html.= " size=\"$width\"";
    if($maxchars) $html.= " maxlength=\"$maxchars\"";

    $html.= " dir=\"". $lang['_textdir']. "\"";

    return $html. " />";
}

function form_input_text($name, $value = "", $width = 0, $maxchars = 0)
{
    return form_field($name,$value,$width,$maxchars,"text");
}

function form_input_password($name, $value = "", $width = 0, $maxchars = 0)
{
    return form_field($name,$value,$width,$maxchars,"password");
}

// create a <input type="hidden"> field
function form_input_hidden($name, $value = "")
{
    return form_field($name,$value,0,0,"hidden");
}

// create a <textarea> field
function form_textarea($name, $value = "", $rows = 0, $cols = 0, $wrap = "virtual", $custom_html = "")
{

    global $lang;

    //wrap attribute removed for XHTML 1.0 compliance.
    //$html = "<textarea name=\"$name\" class=\"bhtextarea\" wrap=\"$wrap\" $custom_html";

    $html = trim("<textarea name=\"$name\" class=\"bhtextarea\" $custom_html");

    if($rows) $html.= " rows=\"$rows\"";
    if($cols) $html.= " cols=\"$cols\"";

    $html.= " dir=\"". $lang['_textdir']. "\"";
    $html.= ">$value</textarea>";

    return $html;
}

// create a <select> dropdown with values from database
function form_dropdown_sql($name, $sql, $default)
{
    global $lang;

    $html = "<select name=\"$name\" class=\"bhselect\" dir=\"". $lang['_textdir']. "\">";

    $db_form_dropdown_sql = db_connect();

    $result = db_query($sql, $db_form_dropdown_sql);

    while($row = db_fetch_array($result)){
        $sel = ($row[0] == $default) ? " selected=\"selected\"" : "";
        if($row[1]){
            $html.= "<option value=\"".$row[0]."\"$sel>".$row[1]."</option>";
        } else {
            $html.= "<option$sel>".$row[0]."</option>";
        }
    }

    return $html."</select>";
}

// create a <select> dropdown with values from array(s)
function form_dropdown_array($name, $value, $label, $default = "", $custom_html = "")
{
    global $lang;

    $html = "<select name=\"$name\" class=\"bhselect\" $custom_html dir=\"". $lang['_textdir']. "\">";

    for ($i = 0; $i < count($value); $i++) {
        $sel = ($value[$i] == $default) ? " selected=\"selected\"" : "";
        if (isset($label[$i])) {
            $html.= "<option value=\"".$value[$i]."\"$sel>".$label[$i]."</option>";
        }else {
            $html.= "<option$sel>".$value[$i]."</option>";
        }
    }
    return $html."</select>";
}

// create a <input type="checkbox">
function form_checkbox($name, $value, $text, $checked = false)
{
    $html = "<span class=\"bhinputcheckbox\"><input type=\"checkbox\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked=\"checked\"";
    return $html . " />$text</span>";
}

// create a <input type="radio">
function form_radio($name, $value, $text, $checked = false)
{
    $html = "<span class=\"bhinputradio\"><input type=\"radio\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked=\"checked\"";
    return $html . " />$text</span>";
}

// create a <input type="radio"> set with values from array(s)
function form_radio_array($name, $value, $text, $checked = -1)
{
    for($i=0;$i<count($value);$i++){
        if(isset($html)) {
          $html .= form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]));
        } else {
          $html = form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]));
        }
    }
    return $html;
}

// create a <input type="submit"> button
function form_submit($name = "submit", $value = "Submit", $customhtml = "", $class = "button")
{
    return "<input type=\"submit\" name=\"$name\" value=\"$value\" class=\"$class\" $customhtml />";
}

// create a form reset button
function form_reset($name = "reset", $value = "Reset", $customhtml = "", $class = "button")
{
    return "<input type=\"reset\" name=\"$name\" value=\"$value\" class=\"$class\" $customhtml />";
}

// create a button with custom HTML, for onclick methods, etc.
function form_button($name, $value, $customhtml, $class="button")
{
    return "<input type=\"button\" name=\"$name\" value=\"$value\" class=\"$class\" $customhtml />";
}

// create a form just to be a link button
function form_quick_button($href,$label,$var = 0,$value = 0,$target = "_self")
{
    echo "<form name=\"f_quickbutton\" method=\"get\" action=\"$href\" target=\"$target\">";

    if($var){
        if(is_array($var)){
            for($i=0;$i<count($var);$i++){
                echo form_input_hidden($var[$i],$value[$i]);
            }
        } else {
            echo form_input_hidden($var,$value);
        }
    }

    echo form_submit("submit",$label)."</form>";
}

function form_dob_dropdowns($dob_year, $dob_month, $dob_day, $show_blank = true)
{
    global $lang;

    $birthday_days   = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31');
    $birthday_months = array($lang['jan'], $lang['feb'], $lang['mar'], $lang['apr'], $lang['may'], $lang['jun'], $lang['jul'], $lang['aug'], $lang['sep'], $lang['oct'], $lang['nov'], $lang['dec']);
    $birthday_years = range(1900, date('Y', mktime()));
    
    if ($show_blank) {
        $birthday_days_values = range(0, 31);
        $birthday_days = array_merge(' ', $birthday_days);
        $birthday_months_values = range(0, 12);
        $birthday_months = array_merge(' ', $birthday_months);
        $birthday_years_values = array_merge(0, $birthday_years);
        $birthday_years = array_merge(' ', $birthday_years);
    } else {
        $birthday_days_values = range(1, 31);
        $birthday_months_values = range(1, 12);
        $birthday_years_values = $birthday_years;
    }

    $output  = form_dropdown_array("dob_day", $birthday_days_values, $birthday_days, $dob_day);
    $output .= "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    $output .= form_dropdown_array("dob_month", $birthday_months_values, $birthday_months, $dob_month);
    $output .= "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    $output .= form_dropdown_array("dob_year", $birthday_years_values, $birthday_years, $dob_year);

    return $output;
}
?>
