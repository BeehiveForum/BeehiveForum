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
include_once("./include/lang.inc.php");

/* Example of usage:

$tools = new TextAreaHTML("myFormName");

echo '<form name="myFormName">';
echo $tools->toolbar();
echo $tools->textarea("textarea_name", "content for textarea", 20, 0);
echo $tools->textarea("textarea_2_name", "content for textarea 2", 20, 0);
echo $tools->js();
echo '</form>'; */

class TextAreaHTML {

	var $form;					// name of the form the textareas will belong to
	var $tas = array();			// array of all the html-enabled textarea's names
	var $tbs = 0;				// count of all the generated toolbars

	function TextAreaHTML ($form) {
		$this->form = $form;
	}

	// ----------------------------------------------------
	// Returns the HTML for the toolbar
	// ----------------------------------------------------
	function toolbar ($custom_html = "") {
		global $lang;
		global $webtag;

		$this->tbs++;

		$str = "<div id=\"_tb".$this->tbs."\" class=\"tools\">\n";

		$str.= $this->_tb_img($lang['bold'], "add_tag('b');", "bold_button.png");
		$str.= $this->_tb_img($lang['italic'], "add_tag('i');", "italic_button.png");
		$str.= $this->_tb_img($lang['underline'], "add_tag('u');", "underline_button.png");
		$str.= $this->_tb_img($lang['strikethrough'], "add_tag('s');", "strikethrough_button.png");
		$str.= $this->_tb_img($lang['superscript'], "add_tag('sup');", "superscript_button.png");
		$str.= $this->_tb_img($lang['subscript'], "add_tag('sub');", "subscript_button.png");
		$str.= $this->_tb_img($lang['leftalign'], "add_tag('div', 'align', 'left');", "align_left_button.png");
		$str.= $this->_tb_img($lang['center'], "add_tag('div', 'align', 'center');", "align_center_button.png");
		$str.= $this->_tb_img($lang['rightalign'], "add_tag('div', 'align', 'right');", "align_right_button.png");
		$str.= $this->_tb_img($lang['numberedlist'], "add_tag('list', true, null, true);", "numbered_list_button.png");
		$str.= $this->_tb_img($lang['list'], "add_tag('list', null, null, true);", "list_button.png");
		$str.= $this->_tb_img($lang['indenttext'], "add_tag('blockquote', null, null, true);", "block_quote_button.png");
		$str.= $this->_tb_img($lang['code'], "add_tag('code', null, null, true);", "code_button.png");
		$str.= $this->_tb_img($lang['quote'], "add_tag('quote', 'source', '', true);", "quote_button.png");
		$str.= $this->_tb_img($lang['horizontalrule'], "add_tag('hr', null, null, true);", "horizontal_rule_button.png");
		$str.= $this->_tb_img($lang['image'], "add_image();", "image_button.png");
		$str.= $this->_tb_img($lang['hyperlink'], "add_link();", "link_button.png");
		$str.= $this->_tb_img($lang['emoticons'], "openEmoticons('user','{$webtag['WEBTAG']}');", "emoticons_button.png");
		$str.= "	<br /><br />\n";
		$str.= "	<select class=\"bhselect\" onChange=\"add_tag('font', 'face', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_face\">\n";
		$str.= "		<option value=\"\" selected>".$lang['fontface']."</option>\n";
		$str.= "		<option value=\"Arial\">Arial</option>\n";
		$str.= "		<option value=\"Times New Roman\">Times New Roman</option>\n";
		$str.= "		<option value=\"Verdana\">Verdana</option>\n";
		$str.= "		<option value=\"Tahoma\">Tahoma</option>\n";
		$str.= "		<option value=\"Courier New\">Courier New</option>\n";
		$str.= "		<option value=\"Trebuchet MS\">Trebuchet MS</option>\n";
		$str.= "		<option value=\"Microsoft Sans Serif\">Microsoft Sans Serif</option>\n";
		$str.= "	</select>\n";
		$str.= "	<select class=\"bhselect\" onChange=\"add_tag('font', 'size', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_size\">\n";
		$str.= "		<option value=\"\" selected>".$lang['size']."</option>\n";
		$str.= "		<option value=\"1\">1</option>\n";
		$str.= "		<option value=\"2\">2</option>\n";
		$str.= "		<option value=\"3\">3</option>\n";
		$str.= "		<option value=\"4\">4</option>\n";
		$str.= "		<option value=\"5\">5</option>\n";
		$str.= "		<option value=\"6\">6</option>\n";
		$str.= "		<option value=\"7\">7</option>\n";
		$str.= "	</select>\n";
		$str.= "	<select class=\"bhselect\" onChange=\"add_tag('font', 'color', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_colour\">\n";
		$str.= "		<option value=\"\" selected>".$lang['colour']."</option>\n";
		$str.= "		<option value=\"#FF0000\" style=\"color: #FF0000;\">".$lang['red']."</option>\n";
		$str.= "		<option value=\"#FFA500\" style=\"color: #FFA500;\">".$lang['orange']."</option>\n";
		$str.= "		<option value=\"#FFFF00\" style=\"color: #FFFF00;\">".$lang['yellow']."</option>\n";
		$str.= "		<option value=\"#008000\" style=\"color: #008000;\">".$lang['green']."</option>\n";
		$str.= "		<option value=\"#0000FF\" style=\"color: #0000FF;\">".$lang['blue']."</option>\n";
		$str.= "		<option value=\"#4B0082\" style=\"color: #4B0082;\">".$lang['indigo']."</option>\n";
		$str.= "		<option value=\"#EE82EE\" style=\"color: #EE82EE;\">".$lang['violet']."</option>\n";
		$str.= "		<option value=\"#FFFFFF\" style=\"color: #FFFFFF; background-color: #000000;\">".$lang['white']."</option>\n";
		$str.= "	</select>\n";

		$str.= "	$custom_html\n";
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

		$custom_html.= " onKeyPress=\"active_text(this);\" onKeyDown=\"active_text(this);\" onKeyUp=\"active_text(this);\" onClick=\"active_text(this);\" onChange=\"active_text(this);\" onSelect=\"active_text(this);\"";

		$str = "<div style=\"display: none\">&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;</div>";
		$str.= form_textarea($name, $value, $rows, $cols, $wrap, $custom_html);

		return $str;
	}
	// ----------------------------------------------------


	// ----------------------------------------------------
	// Returns the Javascript needed by the toolbars
	// CALL THIS FUNCTION **AFTER** YOU HAVE CREATED ALL
	// YOUR TEXTAREAS/TOOLBARS
	// ----------------------------------------------------
	function js () {
		$str = "<script language=\"Javascript\">\n";
		$str.= "  <!--\n";

		$str.= "    function clearFocus() {\n";
		for ($i=0; $i<count($this->tas); $i++) {
			$str.= "    	document.".$this->form.".".$this->tas[$i].".caretPos = \"\";\n";
		}
		$str.= "    }\n";

		$str.= "    function activate_tools() {\n";
		$str.= "      for (var i=1; i<=".$this->tbs."; i++) {\n";
		$str.= "	      show_hide('_tb' + i, 'block');\n";
		$str.= "      }\n";
		$str.= "      document.".$this->form.".".$this->tas[0].".focus();\n";
		$str.= "	    active_text(document.".$this->form.".".$this->tas[0].");\n";
		$str.= "    }\n";

		$str.= "    activate_tools();\n";

		$str.= "  //-->\n";
		$str.= "</script>\n";

		return $str;
	}
	// ----------------------------------------------------


	// ----------------------------------------------------
	// Generate the "see what fixhtml changed" radio buttons
	//		$ta = name of textarea
	//		$text = 'original' code submitted to fixhtml
	// ----------------------------------------------------
	function compare_original ($ta, $text) {
		global $lang;

		$str = form_radio("co_".$ta."_rb", "correct", $lang['correctedcode'], true, "onClick=\"co_".$ta."_show('correct');\"")."\n";
		$str.= form_radio("co_".$ta."_rb", "submit", $lang['submittedcode'], false, "onClick=\"co_".$ta."_show('submit');\"")."\n";
		$str.= "&nbsp;[<a href=\"#\" target=\"_self\" onclick=\"alert('".$lang['fixhtmlexplanation']."');\">?</a>]\n";

		$str.= form_input_hidden("co_".$ta."_old", htmlentities($text))."\n";
		$str.= form_input_hidden("co_".$ta."_current", "correct")."\n";;

		$str.= "<script language=\"Javascript\">\n";
		$str.= "  <!--\n";
		$str.= "    function co_".$ta."_show (type) {\n";
		$str.= "      if (type == \"correct\" && document.".$this->form.".co_".$ta."_current.value != \"correct\") {\n";
		$str.= "        var temp = document.".$this->form.".".$ta.".value;\n";
		$str.= "        document.".$this->form.".".$ta.".value = document.".$this->form.".co_".$ta."_old.value;\n";
		$str.= "        document.".$this->form.".co_".$ta."_old.value = temp;\n";
		$str.= "        document.".$this->form.".co_".$ta."_current.value = \"correct\";\n";
		$str.= "      } else if (type == \"submit\" && document.".$this->form.".co_".$ta."_current.value != \"submit\") {\n";
		$str.= "        var temp = document.".$this->form.".".$ta.".value;\n";
		$str.= "        document.".$this->form.".".$ta.".value = document.".$this->form.".co_".$ta."_old.value;\n";
		$str.= "        document.".$this->form.".co_".$ta."_old.value = temp;\n";
		$str.= "        document.".$this->form.".co_".$ta."_current.value = \"submit\";\n";
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
	//		$a - checkbox/radio button to enable
	//		$b - optional comparison checkbox/radio button
	// ----------------------------------------------------
	function assign_checkbox($a, $b = "") {
		$str = "<script language=\"Javascript\">\n";
		$str.= "  <!--\n";
		$str.= "    function tools_feedback () {\n";
		if ($b != "") {
			$str.= "      if(document.".$this->form.".".$b.".checked == true) {\n";
		} else {
			$str.= "      if(document.".$this->form.".".$a.".checked != true) {\n";
		}
		$str.= "        document.".$this->form.".".$a.".checked = true;\n";
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
	function _tb_img ($title, $on_click, $image_name) {
		return "	<img src=\"".style_image($image_name)."\" onClick=\"".$on_click."\" title=\"".$title."\" width=\"18\" height=\"18\" class=\"tools_up\" onMouseOver=\"m_ov(this);\" onMouseOut=\"m_ou(this);\" onMouseDown=\"m_d(this);\" onMouseUp=\"m_u(this);\">\n";
	}
	// ----------------------------------------------------

}

?>