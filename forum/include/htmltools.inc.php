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

// htmltools.inc.php : wysiwyg toolbar functions

include_once("./include/form.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");

// WARNING: Remember to declare onUnload="clearFocus()" in your <body> tag

/* Example of usage:

html_draw_top("onUnload=clearFocus()", "htmltools.js");

$tools = new TextAreaHTML("myFormName");

echo '<form name="myFormName">';
echo $tools->toolbar();
echo $tools->textarea("textarea_name", "content for textarea", 20, 0);
echo $tools->textarea("textarea_2_name", "content for textarea 2", 20, 0);
echo $tools->js();
echo '</form>'; */

class TextAreaHTML {

    // Note: PHP/5.0 introduces new public, private and protected
    // modifiers whilst removing the var modifier. However it only
    // causes problems if PHP/5.0's new STRICT error reporting
    // is also enabled, hence we're (for the mean while) going to
    // stick with PHP/4.x's old var modifiers, because for now
    // it is going to be more compatible with our 'audience'

    var $form;                    // name of the form the textareas will belong to
    var $tas = array();            // array of all the html-enabled textarea's names
    var $tbs = 0;                // count of all the generated toolbars

    function TextAreaHTML ($form) {
        $this->form = $form;
    }

    // ----------------------------------------------------
    // Returns the HTML for the toolbar
    // ----------------------------------------------------
    function toolbar ($emoticons = true, $custom_html = "") {

        $lang = load_language_file();

        $forum_settings = get_forum_settings();
        $webtag = get_webtag($webtag_search);

        $this->tbs++;

        $str = "<div id=\"_tb{$this->tbs}\" class=\"tools\">\n";

        $str.= $this->_tb_img($lang['bold'], "add_tag('b');");
        $str.= $this->_tb_img($lang['italic'], "add_tag('i');");
        $str.= $this->_tb_img($lang['underline'], "add_tag('u');");
        $str.= $this->_tb_img($lang['strikethrough'], "add_tag('s');");
        $str.= $this->_tb_img($lang['superscript'], "add_tag('sup');");
        $str.= $this->_tb_img($lang['subscript'], "add_tag('sub');");
        $str.= $this->_tb_img($lang['leftalign'], "add_tag('div', 'align', 'left');");
        $str.= $this->_tb_img($lang['center'], "add_tag('div', 'align', 'center');");
        $str.= $this->_tb_img($lang['rightalign'], "add_tag('div', 'align', 'right');");
        $str.= $this->_tb_img($lang['numberedlist'], "add_tag('list', true, null, true);");
        $str.= $this->_tb_img($lang['list'], "add_tag('list', null, null, true);");
        $str.= $this->_tb_img($lang['indenttext'], "add_tag('blockquote', null, null, true);");
        $str.= $this->_tb_img($lang['code'], "add_tag('code', 'language', '', true);");
        $str.= $this->_tb_img($lang['quote'], "add_tag('quote', 'source', '', true);");
        $str.= $this->_tb_img($lang['spoiler'], "add_tag('spoiler', null, null, true);");
        $str.= $this->_tb_img($lang['horizontalrule'], "add_tag('hr', null, null, true);");
        $str.= $this->_tb_img($lang['image'], "add_image();");
        $str.= $this->_tb_img($lang['hyperlink'], "add_link();");
        $str.= $this->_tb_img($lang['noemoticons'], "add_tag('noemots', null, null, true);");

        if ($emoticons == true) {
            $str.= $this->_tb_img($lang['emoticons'], "openEmoticons('user','$webtag');", "emoticons_button.png");
        }

        $str.= "    <br />\n";
        $str.= "    <select class=\"bhselect\" onChange=\"add_tag('font', 'face', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_face\">\n";
        $str.= "        <option value=\"\" selected>{$lang['fontface']}</option>\n";
        $str.= "        <option value=\"Arial\">Arial</option>\n";
        $str.= "        <option value=\"Times New Roman\">Times New Roman</option>\n";
        $str.= "        <option value=\"Verdana\">Verdana</option>\n";
        $str.= "        <option value=\"Tahoma\">Tahoma</option>\n";
        $str.= "        <option value=\"Courier New\">Courier New</option>\n";
        $str.= "        <option value=\"Trebuchet MS\">Trebuchet MS</option>\n";
        $str.= "        <option value=\"Microsoft Sans Serif\">Microsoft Sans Serif</option>\n";
        $str.= "    </select>\n";
        $str.= "    <select class=\"bhselect\" onChange=\"add_tag('font', 'size', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_size\">\n";
        $str.= "        <option value=\"\" selected>{$lang['size']}</option>\n";
        $str.= "        <option value=\"1\">1</option>\n";
        $str.= "        <option value=\"2\">2</option>\n";
        $str.= "        <option value=\"3\">3</option>\n";
        $str.= "        <option value=\"4\">4</option>\n";
        $str.= "        <option value=\"5\">5</option>\n";
        $str.= "        <option value=\"6\">6</option>\n";
        $str.= "        <option value=\"7\">7</option>\n";
        $str.= "    </select>\n";
        $str.= "    <select class=\"bhselect\" onChange=\"add_tag('font', 'color', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_colour\">\n";
        $str.= "        <option value=\"\" selected>{$lang['colour']}</option>\n";
        $str.= "        <option value=\"#FF0000\" style=\"color: #FF0000;\">{$lang['red']}</option>\n";
        $str.= "        <option value=\"#FFA500\" style=\"color: #FFA500;\">{$lang['orange']}</option>\n";
        $str.= "        <option value=\"#FFFF00\" style=\"color: #FFFF00;\">{$lang['yellow']}</option>\n";
        $str.= "        <option value=\"#008000\" style=\"color: #008000;\">{$lang['green']}</option>\n";
        $str.= "        <option value=\"#0000FF\" style=\"color: #0000FF;\">{$lang['blue']}</option>\n";
        $str.= "        <option value=\"#4B0082\" style=\"color: #4B0082;\">{$lang['indigo']}</option>\n";
        $str.= "        <option value=\"#EE82EE\" style=\"color: #EE82EE;\">{$lang['violet']}</option>\n";
        $str.= "        <option value=\"#000000\" style=\"color: #000000;\">{$lang['black']}</option>\n";
        $str.= "        <option value=\"#808080\" style=\"color: #808080;\">{$lang['grey']}</option>\n";
        $str.= "        <option value=\"#FFFFFF\" style=\"color: #FFFFFF; background-color: #000000;\">{$lang['white']}</option>\n";
        $str.= "        <option value=\"#FFA8CF\" style=\"color: #FFA8CF;\">{$lang['pink']}</option>\n";
        $str.= "        <option value=\"#80FF80\" style=\"color: #80FF80;\">{$lang['lightgreen']}</option>\n";
        $str.= "        <option value=\"#00FFFF\" style=\"color: #00FFFF;\">{$lang['lightblue']}</option>\n";
        $str.= "    </select>\n";
        $str.= "    $custom_html\n";
        $str.= "</div>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Returns a HTML toolbar-enabled textarea
    // Takes the same arguments as form_textarea in form.inc.php
    // ----------------------------------------------------

    function textarea ($name, $value = false, $rows = false, $cols = false, $wrap = "virtual", $custom_html = "") {

        $this->tas[] = $name;

        $custom_html.= " onKeyPress=\"active_text(this);\" onKeyDown=\"active_text(this);\" onKeyUp=\"active_text(this);\" onClick=\"active_text(this);\" onChange=\"active_text(this);\" onSelect=\"active_text(this);\" onDblClick=\"active_text(this, true);\"";

        $str = "<div style=\"display: none\">&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;</div>";
        $str.= form_textarea($name, $value, $rows, $cols, $wrap, $custom_html);

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Preloads the images needed by the toolbars
        // CALL THIS FUNCTION TOWARDS THE BEGINNING OF THE PAGE
        // ----------------------------------------------------

    function preload () {

        $str = "<script language=\"Javascript\">\n";
        $str.= "  <!--\n";
                $str.= "    _tb_image_main = new Image();\n";
                $str.= "    _tb_image_main.src = \"./images/html_toolbar.png\";\n";
                $str.= "    _tb_image_blank = new Image();\n";
                $str.= "    _tb_image_blank.src = \"./images/blank.png\";\n";
        $str.= "  //-->\n";
        $str.= "</script>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Returns the Javascript needed by the toolbars
    // CALL THIS FUNCTION **AFTER** YOU HAVE CREATED ALL
    // YOUR TEXTAREAS/TOOLBARS
    // ----------------------------------------------------

    function js ($focus = true) {

        $str = "<script language=\"Javascript\">\n";
        $str.= "  <!--\n";

        $str.= "    function clearFocus() {\n";

        for ($i=0; $i<count($this->tas); $i++) {
            $str.= "        document.{$this->form}.{$this->tas[$i]}.caretPos = \"\";\n";
        }

        $str.= "    }\n";
        $str.= "    function activate_tools() {\n";
        $str.= "      for (var i=1; i<={$this->tbs}; i++) {\n";
        $str.= "          show_hide('_tb' + i, 'block');\n";
        $str.= "      }\n";

        if ($focus != false) {
            $str.= "      document.{$this->form}.". ($focus == true ? $this->tas[0] : $focus). ".focus();\n";
        }

        $str.= "        active_text(document.{$this->form}.{$this->tas[0]});\n";
        $str.= "    }\n";
        $str.= "    activate_tools();\n";
        $str.= "  //-->\n";
        $str.= "</script>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Generate the "see what fixhtml changed" radio buttons
    //        $ta = name of textarea
    //        $text = 'original' code submitted to fixhtml
    // ----------------------------------------------------

    function compare_original ($ta, $text) {

        $lang = load_language_file();

        $str = form_radio("co_{$ta}_rb", "correct", $lang['correctedcode'], true, "onClick=\"co_{$ta}_show('correct');\"")."\n";
        $str.= form_radio("co_{$ta}_rb", "submit", $lang['submittedcode'], false, "onClick=\"co_{$ta}_show('submit');\"")."\n";
        $str.= "&nbsp;[<a href=\"#\" target=\"_self\" onclick=\"alert('{$lang['fixhtmlexplanation']}');\">?</a>]\n";

        $str.= form_input_hidden("co_{$ta}_old", _htmlentities($text))."\n";
        $str.= form_input_hidden("co_{$ta}_current", "correct")."\n";;

        $str.= "<script language=\"Javascript\">\n";
        $str.= "  <!--\n";
        $str.= "    function co_{$ta}_show (type) {\n";
        $str.= "      if (type == \"correct\" && document.{$this->form}.co_{$ta}_current.value != \"correct\") {\n";
        $str.= "        var temp = document.{$this->form}.{$ta}.value;\n";
        $str.= "        document.{$this->form}.{$ta}.value = document.{$this->form}.co_{$ta}_old.value;\n";
        $str.= "        document.{$this->form}.co_{$ta}_old.value = temp;\n";
        $str.= "        document.{$this->form}.co_{$ta}_current.value = \"correct\";\n";
        $str.= "      } else if (type == \"submit\" && document.{$this->form}.co_{$ta}_current.value != \"submit\") {\n";
        $str.= "        var temp = document.{$this->form}.{$ta}.value;\n";
        $str.= "        document.{$this->form}.{$ta}.value = document.{$this->form}.co_{$ta}_old.value;\n";
        $str.= "        document.{$this->form}.co_{$ta}_old.value = temp;\n";
        $str.= "        document.{$this->form}.co_{$ta}_current.value = \"submit\";\n";
        $str.= "      }\n";
        $str.= "    }\n";
        $str.= "  //-->\n";
        $str.= "</script>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Ticks an "Enable HTML" checkbox when toolbar is used
    // Can only assign one checkbox per page, regardless of
    // number of toolbars.
    //        $a - checkbox/radio button to enable
    //        $b - optional comparison checkbox/radio button
    // ----------------------------------------------------

    function assign_checkbox($a, $b = "") {

        $str = "<script language=\"Javascript\">\n";
        $str.= "  <!--\n";
        $str.= "    function tools_feedback () {\n";

        if ($b != "") {
            $str.= "      if(document.{$this->form}.{$b}.checked == true) {\n";
        }else {
            $str.= "      if(document.{$this->form}.{$a}.checked != true) {\n";
        }

        $str.= "        document.{$this->form}.{$a}.checked = true;\n";
        $str.= "      }\n";
        $str.= "    }\n";
        $str.= "  //-->\n";
        $str.= "</script>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Internal function - returns HTML for toolbar image
    // ----------------------------------------------------

    function _tb_img ($title, $on_click, $image_name = "blank.png") {
        return "<img src=\"". style_image($image_name). "\" onClick=\"{$on_click}\" title=\"{$title}\" class=\"tools_up\" onMouseOver=\"m_ov(this);\" onMouseOut=\"m_ou(this);\" onMouseDown=\"m_d(this);\" onMouseUp=\"m_u(this);\" />";
    }

    // ----------------------------------------------------

}

?>
