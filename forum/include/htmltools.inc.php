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

function tools_button ($title, $on_click, $image_name) {
	return "<img src=\"".style_image($image_name)."\" onClick=\"".$on_click."\" title=\"".$title."\" width=\"18\" height=\"18\" class=\"tools_up\" onMouseOver=\"m_ov(this);\" onMouseOut=\"m_ou(this);\" onMouseDown=\"m_d(this);\" onMouseUp=\"m_u(this);\">";
}

function tools_html() {
	global $lang;
	echo "<div id=\"toolbar\" class=\"tools\">\n";
	echo tools_button($lang['bold'], "add_tag('b');", "bold_button.png");
	echo tools_button($lang['italic'], "add_tag('i');", "italic_button.png");
	echo tools_button($lang['underline'], "add_tag('u');", "underline_button.png");
	echo tools_button($lang['leftalign'], "add_tag('div', 'align', 'left');", "align_left_button.png");
	echo tools_button($lang['center'], "add_tag('div', 'align', 'center');", "align_center_button.png");
	echo tools_button($lang['rightalign'], "add_tag('div', 'align', 'right');", "align_right_button.png");
	echo tools_button($lang['list'], "add_tag('list', null, null, true);", "list_button.png");
	echo tools_button($lang['indenttext'], "add_tag('blockquote', null, null, true);", "block_quote_button.png");
	echo tools_button($lang['code'], "add_tag('code', null, null, true);", "code_button.png");
	echo tools_button($lang['quote'], "add_tag('quote', 'source', '', true);", "quote_button.png");
	echo tools_button($lang['horizontalrule'], "add_tag('hr', null, null, true);", "horizontal_rule_button.png");
	echo tools_button($lang['image'], "add_image();", "image_button.png");
	echo tools_button($lang['hyperlink'], "add_link();", "link_button.png");
	echo "<br /><span class=\"bhinputcheckbox\"> &nbsp;\n";
	echo "<select class=\"bhselect\" onChange=\"add_tag('font', 'face', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_face\">\n";
		echo "<option value=\"\" selected>".$lang['fontface']."</option>\n";
		echo "<option value=\"Arial\">Arial</option>\n";
		echo "<option value=\"Times New Roman\">Times New Roman</option>\n";
		echo "<option value=\"Verdana\">Verdana</option>\n";
		echo "<option value=\"Tahoma\">Tahoma</option>\n";
		echo "<option value=\"Courier New\">Courier New</option>\n";
		echo "<option value=\"Trebuchet MS\">Trebuchet MS</option>\n";
		echo "<option value=\"Microsoft Sans Serif\">Microsoft Sans Serif</option>\n";
	echo "</select>\n";
	echo "<select class=\"bhselect\" onChange=\"add_tag('font', 'size', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_size\">\n";
		echo "<option value=\"\" selected>".$lang['size']."</option>\n";
		echo "<option value=\"1\">1</option>\n";
		echo "<option value=\"2\">2</option>\n";
		echo "<option value=\"3\">3</option>\n";
		echo "<option value=\"4\">4</option>\n";
		echo "<option value=\"5\">5</option>\n";
		echo "<option value=\"6\">6</option>\n";
		echo "<option value=\"7\">7</option>\n";
	echo "</select>\n";
	echo "<select class=\"bhselect\" onChange=\"add_tag('font', 'color', this.options[this.selectedIndex].value); this.selectedIndex = 0;\" name=\"font_colour\">\n";
		echo "<option value=\"\" selected>".$lang['colour']."</option>\n";
		echo "<option value=\"#FF0000\" style=\"color: #FF0000;\">".$lang['red']."</option>\n";
		echo "<option value=\"#FFA500\" style=\"color: #FFA500;\">".$lang['orange']."</option>\n";
		echo "<option value=\"#FFFF00\" style=\"color: #FFFF00;\">".$lang['yellow']."</option>\n";
		echo "<option value=\"#008000\" style=\"color: #008000;\">".$lang['green']."</option>\n";
		echo "<option value=\"#0000FF\" style=\"color: #0000FF;\">".$lang['blue']."</option>\n";
		echo "<option value=\"#4B0082\" style=\"color: #4B0082;\">".$lang['indigo']."</option>\n";
		echo "<option value=\"#EE82EE\" style=\"color: #EE82EE;\">".$lang['violet']."</option>\n";
		echo "<option value=\"#FFFFFF\" style=\"color: #FFFFFF; background-color: #000000;\">".$lang['white']."</option>\n";
	echo "</select></span></div>\n";
}

function tools_junk() {
	echo "<div style=\"display: none\">&#8706;&#8706;&#8706;&#8706;&#8706;&#8706;&#8706;&#8706;&#8706;&#8706;</div>";
}
function tools_textfield_js() {
	return "onKeyPress=\"active_text(this);\" onKeyDown=\"active_text(this);\" onKeyUp=\"active_text(this);\" onClick=\"active_text(this);\" onChange=\"active_text(this);\" onSelect=\"active_text(this);\"";
}
function tools_activate() {
	echo "<script language=\"Javascript\">\n";
	echo "  <!--\n";
	echo "    function activate_tools() {\n";
	echo "      show_hide('toolbar', 'block');\n";
	echo "      document.f_post.t_content.focus();\n";
	echo "	    active_text(document.f_post.t_content);\n";
	echo "    }\n";
	echo "    activate_tools();\n";
	echo "  //-->\n";
	echo "</script>\n";
}
?>