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

// form.inc.php : form item functions

require_once("./include/db.inc.php");

// create a <input type="text"> field
function form_field($name, $value = "", $width = 0, $maxchars = 0, $type = "text")
{
    $html = "<input type=\"$type\" name=\"$name\" class=\"bhinputtext\"";

    if($value) $html.= " value=\"$value\"";
    if($width) $html.= " width=\"$width\"";
    if($maxchars) $html.= " maxchars=\"$maxchars\"";

    return $html.">\n";
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
function form_textarea($name, $value = "", $rows = 0, $cols = 0)
{
    $html = "<textarea name=\"$name\" class=\"bhtextarea\" wrap=\"VIRTUAL\"";

    if($rows) $html.= " rows=\"$rows\"";
    if($cols) $html.= " cols=\"$cols\"";

    $html .= ">$value</textarea>\n";

    return $html;
}

// create a <select> dropdown with values from database
function form_dropdown_sql($name, $sql, $default)
{
    $html = "<select name=\"$name\" class=\"bhselect\">\n";

    $db_form_dropdown_sql = db_connect();

    $result = db_query($sql, $db_form_dropdown_sql);

    while($row = db_fetch_array($result)){
        $sel = ($row[0] == $default) ? " selected" : "";
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
    $html = "<select name=\"$name\" class=\"bhselect\" $custom_html>\n";

    for($i=0;$i<count($value);$i++){
        $sel = ($value[$i] == $default) ? " selected" : "";
        if($label[$i]){
            $html.= "<option value=\"".$value[$i]."\"$sel>".$label[$i]."</option>\n";
        } else {
            $html.= "<option$sel>".$value[$i]."</option>\n";
        }
    }
    return $html."</select>\n";
}

// create a <input type="checkbox">
function form_checkbox($name, $value, $text, $checked = false)
{
    $html = "<span class=\"bhinputcheckbox\"><input type=\"checkbox\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text</span>\n";
}

// create a <input type="radio">
function form_radio($name, $value, $text, $checked = false)
{
    $html = "<span class=\"bhinputradio\"><input type=\"radio\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text</span>\n";
}

// create a <input type="radio"> set with values from array(s)
function form_radio_array($name, $value, $text, $checked = -1)
{
    for($i=0;$i<count($value);$i++){
        $html .= form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]));
    }
    return $html;
}

// create a <input type="submit"> button
function form_submit($name = "submit", $value = "Submit", $class = "button")
{
    return "<input type=\"submit\" name=\"$name\" value=\"$value\" class=\"$class\" />";
}

// create a form just to be a link button
function form_quick_button($href,$label,$var = 0,$value = 0,$target = "_self")
{
    echo "<form name=\"f_quickbutton\" method=\"get\" action=\"$href\" target=\"$target\">\n";

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

?>
