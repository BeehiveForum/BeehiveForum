<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: htmltools.inc.php,v 1.99 2010-01-03 15:19:33 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "dictionary.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function TinyMCE($tinymce_auto_focus)
{
    $str = "<!-- tinyMCE -->\n";
    $str.= "<script language=\"javascript\" type=\"text/javascript\" src=\"tiny_mce/tiny_mce.js\"></script>\n";
    $str.= "<script type=\"text/javascript\">\n";
    $str.= "<!--\n";
    $str.= "    tinyMCE.init({\n";
    $str.= "        // General options\n";
    $str.= "        mode : \"textareas\",\n";
    $str.= "        editor_selector : /(post_content|edit_signature_content|admin_startpage_textarea)/,\n";
    $str.= "        theme : \"advanced\",\n";
    $str.= "        force_br_newlines : true,\n";
    $str.= "        forced_root_block : '',\n";
    $str.= "        inline_styles : false,\n";
    $str.= "        auto_focus : '$tinymce_auto_focus',\n";
    $str.= "        plugins : \"safari,table,inlinepopups,paste,beehive\",\n\n";
    $str.= "        // Theme options\n";
    $str.= "        theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,formatselect,fontselect,fontsizeselect\",\n";
    $str.= "        theme_advanced_buttons2 : \"undo,redo,|,cleanup,code,removeformat,|,visualaid,|,tablecontrols\",\n";
    $str.= "        theme_advanced_buttons3 : \"forecolor,backcolor,|,sub,sup,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,image,|,bhquote,bhcode,bhspoiler,bhnoemots,bhspellcheck\",\n";
    $str.= "        extended_valid_elements : \"b,marquee,span[class|align|title],div[class|align|id],font[face|size|color|style]\",\n";
    $str.= "        invalid_elements : \"!doctype|applet|body|base|button|fieldset|form|frame|frameset|head|html|iframe|input|label|legend|link|meta|noframes|noscript|object|optgroup|option|param|plaintext|script|select|style|textarea|title|xmp\",\n";
    $str.= "        theme_advanced_toolbar_location : \"top\",\n";
    $str.= "        theme_advanced_toolbar_align : \"left\",\n";
    $str.= "        content_css : \"tiny_mce/plugins/beehive/tiny_mce_style.css\"\n";
    $str.= "    });\n\n";
    $str.= "    function clear_focus() { return; };\n\n";
    $str.= "    function auto_spell_check()\n";
    $str.= "    {\n";
    $str.= "        if (tinyMCE.activeEditor.getContent().length == 0) return true;\n\n";
    $str.= "        if (\$('#t_check_spelling').is(':checked') && !auto_spell_check_started) {\n";
    $str.= "            auto_spell_check_started = true;\n";
    $str.= "            open_spell_check(tinyMCE.activeEditor.id);\n";
    $str.= "            return false;\n";
    $str.= "        }\n";
    $str.= "    }\n\n";
    $str.= "    function read_content(obj_id) {\n";
    $str.= "        return tinyMCE.activeEditor.getContent();\n";
    $str.= "    }\n\n";
    $str.= "    function update_content(obj_id, content) {\n";
    $str.= "        tinyMCE.activeEditor.setContent(content);\n";
    $str.= "    }\n\n";
    $str.= "    function add_text(text)\n";
    $str.= "    {\n";
    $str.= "        if (tinyMCE.activeEditor.getContent().length < 1) {\n\n";
    $str.= "            tinyMCE.activeEditor.setContent('');\n";
    $str.= "        }\n\n";
    $str.= "        tinyMCE.execCommand('mceInsertContent', false, text);\n";
    $str.= "    }\n";
    $str.= "//-->\n";
    $str.= "</script>\n";
    $str.= "<!-- /tinyMCE -->\n";

    return $str;
}

/* Example of usage:

html_draw_top("htmltools.js");

$tools = new TextAreaHTML("myFormName");

echo '<form accept-charset=\"utf-8\" name="myFormName">';
echo $tools->toolbar();
echo $tools->textarea("textarea_name", "content for textarea", 20, 0);
echo $tools->textarea("textarea_2_name", "content for textarea 2", 20, 0);
echo $tools->js();
echo '</form>'; */

class TextAreaHTML {

    private $form;                      // name of the form the textareas will belong to
    private $tas = array();             // array of all the html-enabled textarea's names
    private $tbs = 0;                   // count of all the generated toolbars
    private $tinymce = false;           // marker if the TinyMCE editor is being used
    private $allowed_toolbars = 1;      // number of allowed TinyMCE toolbars, default 1

    function TextAreaHTML ($form)
    {
        $this->form = $form;

        if (@file_exists("tiny_mce/tiny_mce.js")) {

            $page_prefs = bh_session_get_post_page_prefs();

            if (($page_prefs & POST_TINYMCE_DISPLAY) && !defined('BEEHIVEMODE_LIGHT')) {
                $this->tinymce = true;
            }
        }
    }

    // ----------------------------------------------------
    // Returns true if the TinyMCE editor is being used
    // ----------------------------------------------------

    function getTinyMCE ()
    {
        return $this->tinymce;
    }

    // ----------------------------------------------------
    // Enables/disables the TinyMCE toolbar
    // ----------------------------------------------------

    function setTinyMCE ($bool)
    {
        $this->tinymce = ($bool == true) ? true : false;
    }

    // ----------------------------------------------------
    // Sets the number of allowed HTML toolbars per page
    // ----------------------------------------------------

    function setAllowedToolbars ($num)
    {
        if (is_numeric($num)) {
            $this->allowed_toolbars = $num > 0 ? $num : 0;
        }
    }

    // ----------------------------------------------------
    // Returns the HTML for the toolbar
    // ----------------------------------------------------
    function toolbar ($emoticons = true, $custom_html = "")
    {
        if ($this->tinymce || $this->tbs >= $this->allowed_toolbars) return "";

        $lang = load_language_file();

        $webtag = get_webtag();

        $this->tbs = $this->tbs + 1;

        $dictionary = new dictionary();

        if ($dictionary->is_installed()) {
            $str = "<div id=\"bh_tb{$this->tbs}\" class=\"tools\" style=\"background-image: url('images/html_toolbar.png');\">\n";
        }else {
            $str = "<div id=\"bh_tb{$this->tbs}\" class=\"tools\" style=\"background-image: url('images/html_toolbar_no_dict.png');\">\n";
        }

        $str.= $this->bh_tb_img($lang['bold'], 'bold'); //, "add_tag('b');");
        $str.= $this->bh_tb_img($lang['italic'], 'italic'); //, "add_tag('i');");
        $str.= $this->bh_tb_img($lang['underline'], 'underline'); //, "add_tag('u');");
        $str.= $this->bh_tb_img($lang['strikethrough'], 'strikethrough'); //, "add_tag('s');");
        $str.= $this->bh_tb_img($lang['superscript'], 'superscript'); //, "add_tag('sup');");
        $str.= $this->bh_tb_img($lang['subscript'], 'subscript'); //, "add_tag('sub');");
        $str.= $this->bh_tb_img($lang['leftalign'], 'leftalign'); //, "add_tag('div', 'align', 'left');");
        $str.= $this->bh_tb_img($lang['center'], 'center'); //, "add_tag('div', 'align', 'center');");
        $str.= $this->bh_tb_img($lang['rightalign'], 'rightalign'); //, "add_tag('div', 'align', 'right');");
        $str.= $this->bh_tb_img($lang['numberedlist'], 'numberedlist'); //, "add_tag('list', true, null, true);");
        $str.= $this->bh_tb_img($lang['list'], 'list'); //, "add_tag('list', null, null, true);");
        $str.= $this->bh_tb_img($lang['indenttext'], 'indenttext'); //, "add_tag('blockquote', null, null, true);");
        $str.= $this->bh_tb_img($lang['code'], 'code'); //, "add_tag('code', 'language', '', true);");
        $str.= $this->bh_tb_img($lang['quote'], 'quote'); //, "add_tag('quote', 'source', '', true);");
        $str.= $this->bh_tb_img($lang['spoiler'], 'spoiler'); //, "add_tag('spoiler', null, null, true);");
        $str.= $this->bh_tb_img($lang['horizontalrule'], 'horizontalrule'); //, "add_tag('hr', null, null, true);");
        $str.= $this->bh_tb_img($lang['image'], 'image'); //, "add_image();");
        $str.= $this->bh_tb_img($lang['hyperlink'], 'hyperlink'); //, "add_link();");

        if ($dictionary->is_installed()) {
            $str.= $this->bh_tb_img($lang['spellcheck'], 'spellcheck'); //, "openSpellCheck('$webtag');");
        }

        $str.= $this->bh_tb_img($lang['noemoticons'], 'noemoticons'); //, "add_tag('noemots', null, null, true);");

        if ($emoticons == true) {
            $str.= $this->bh_tb_img($lang['emoticons'], 'emoticons');
        }

        $str.= "    <br />\n";
        $str.= "    <select class=\"bhselect\" name=\"font_face\">\n";
        $str.= "        <option value=\"\" selected=\"selected\">{$lang['fontface']}</option>\n";
        $str.= "        <option value=\"Arial\">Arial</option>\n";
        $str.= "        <option value=\"Times New Roman\">Times New Roman</option>\n";
        $str.= "        <option value=\"Verdana\">Verdana</option>\n";
        $str.= "        <option value=\"Tahoma\">Tahoma</option>\n";
        $str.= "        <option value=\"Courier New\">Courier New</option>\n";
        $str.= "        <option value=\"Trebuchet MS\">Trebuchet MS</option>\n";
        $str.= "        <option value=\"Microsoft Sans Serif\">Microsoft Sans Serif</option>\n";
        $str.= "    </select>\n";
        $str.= "    <select class=\"bhselect\" name=\"font_size\">\n";
        $str.= "        <option value=\"\" selected=\"selected\">{$lang['size']}</option>\n";
        $str.= "        <option value=\"1\">1</option>\n";
        $str.= "        <option value=\"2\">2</option>\n";
        $str.= "        <option value=\"3\">3</option>\n";
        $str.= "        <option value=\"4\">4</option>\n";
        $str.= "        <option value=\"5\">5</option>\n";
        $str.= "        <option value=\"6\">6</option>\n";
        $str.= "        <option value=\"7\">7</option>\n";
        $str.= "    </select>\n";
        $str.= "    <select class=\"bhselect\" name=\"font_colour\">\n";
        $str.= "        <option value=\"\" selected=\"selected\">{$lang['colour']}</option>\n";
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

    // --------------------------------------------------------------------------
    // Returns the HTML for the reduced functionality toolbar used in Quick Reply
    // --------------------------------------------------------------------------

    function toolbar_reduced ($emoticons = true)
    {
        if ($this->tinymce || $this->tbs >= $this->allowed_toolbars) return "";

        $lang = load_language_file();

        $webtag = get_webtag();

        $this->tbs = $this->tbs + 1;

        $str = "<div id=\"bh_tb{$this->tbs}\" class=\"tools\" style=\"background-image: url('images/html_toolbar_reduced.png');\">\n";
        $str.= $this->bh_tb_img($lang['bold'], 'bold'); //, "add_tag('b');");
        $str.= $this->bh_tb_img($lang['italic'], 'italic'); //, "add_tag('i');");
        $str.= $this->bh_tb_img($lang['underline'], 'underline'); //, "add_tag('u');");

        if ($emoticons == true) {
            $str.= $this->bh_tb_img($lang['emoticons'], 'emoticons');
        }

        $str.= "</div>\n";

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Returns a HTML toolbar-enabled textarea
    // Takes the same arguments as form_textarea in form.inc.php
    // ----------------------------------------------------

    function textarea ($name, $value = false, $rows = false, $cols = false, $custom_html = "", $class = "bhinputtext", $allow_tiny_mce = true)
    {
        $this->tas[] = $name;

        $str = '';

        $class.= ' htmltools';

        if ($this->tinymce) {

            if ($this->tbs < $this->allowed_toolbars) {

                $this->tbs = $this->tbs + 1;

                if ($rows < 7) {
                    $rows = 7;
                }

                $rows += 5;

                if ($allow_tiny_mce === true) {

                    $custom_html.= ' mce_editable="true"';
                }
            }

        }else {

            $str = "<div style=\"display: none\">&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;&#9999;</div>";
        }

        $str.= form_textarea($name, $value, $rows, $cols, $custom_html, $class);

        return $str;
    }

    // ----------------------------------------------------


    // ----------------------------------------------------
    // Preloads the images needed by the toolbars
    // CALL THIS FUNCTION TOWARDS THE BEGINNING OF THE PAGE
    // ----------------------------------------------------

    function preload ()
    {
        if ($this->tinymce) return "";

        $str = "<script language=\"javascript\" type=\"text/javascript\">\n";
        $str.= "  <!--\n";
        $str.= "    bh_tb_image_main = new Image();\n";
        $str.= "    bh_tb_image_main.src = \"". style_image('html_toolbar.png'). "\";\n";
        $str.= "    bh_tb_image_blank = new Image();\n";
        $str.= "    bh_tb_image_blank.src = \"". style_image('blank.png'). "\";\n";
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

        $str = "<script language=\"javascript\" type=\"text/javascript\">\n";
        $str.= "  <!--\n";

        if (!$this->tinymce) {

            $str.= "    function clear_focus()\n";
            $str.= "    {\n";

            foreach ($this->tas as $tas) {
                $str.= "        \$('#$tas').attr('caretPos', '');\n";
            }

            $str.= "    }\n\n";

            $str.= "    function activate_tools()\n";
            $str.= "    {\n";

            for ($i = 1; $i <= $this->tbs; $i++) {
                $str.= "        show_hide('#bh_tb$i', 'block');\n";
            }

            if ($focus !== false) {
                $str.= "        \$('#{$this->tas[0]}').focus();\n";
            }

            $str.= "        active_text(\$('#{$this->tas[0]}').get(0));\n";
            $str.= "    }\n\n";

            $str.= "    activate_tools();\n";
        }

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

    function compare_original ($ta, $text)
    {

        $lang = load_language_file();

        $str = form_radio("co_{$ta}_rb", "correct", $lang['correctedcode'], true, "onclick=\"co_{$ta}_show('correct');\"")."\n";
        $str.= form_radio("co_{$ta}_rb", "submit", $lang['submittedcode'], false, "onclick=\"co_{$ta}_show('submit');\"")."\n";
        $str.= "&nbsp;[<a href=\"javascript:void(0)\" target=\"_self\" onclick=\"alert('{$lang['fixhtmlexplanation']}');\">?</a>]\n";

        $str.= form_input_hidden("co_{$ta}_old", htmlentities_array($text))."\n";
        $str.= form_input_hidden("co_{$ta}_current", "correct")."\n";;

        $str.= "<script language=\"Javascript\" type=\"text/javascript\">\n";
        $str.= "  <!--\n";
        $str.= "    function co_{$ta}_show (type)\n";
        $str.= "    {\n";
        $str.= "      if (type == \"correct\" && document.{$this->form}.co_{$ta}_current.value != \"correct\") {\n";
        if ($this->tinymce) {
            $str.= "        var temp = tinyMCE.activeEditor.getContent();\n";
            $str.= "        tinyMCE.activeEditor.setContent(document.{$this->form}.co_{$ta}_old.value);\n";
        } else {
            $str.= "        var temp = document.{$this->form}.{$ta}.value;\n";
            $str.= "        document.{$this->form}.{$ta}.value = document.{$this->form}.co_{$ta}_old.value;\n";
        }
        $str.= "        document.{$this->form}.co_{$ta}_old.value = temp;\n";
        $str.= "        document.{$this->form}.co_{$ta}_current.value = \"correct\";\n";
        $str.= "      } else if (type == \"submit\" && document.{$this->form}.co_{$ta}_current.value != \"submit\") {\n";
        if ($this->tinymce) {
            $str.= "        var temp = tinyMCE.activeEditor.getContent();\n";
            $str.= "        tinyMCE.activeEditor.setContent(document.{$this->form}.co_{$ta}_old.value);\n";
        } else {
            $str.= "        var temp = document.{$this->form}.{$ta}.value;\n";
            $str.= "        document.{$this->form}.{$ta}.value = document.{$this->form}.co_{$ta}_old.value;\n";
        }
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

    function assign_checkbox($a, $b = "")
    {
        if ($this->tinymce) return "";

        $str = "<script language=\"Javascript\" type=\"text/javascript\">\n";
        $str.= "  <!--\n";
        $str.= "    function tools_feedback ()\n";
        $str.= "    {\n";

        if (strlen($b) > 0) {
            $str.= "      if (document.{$this->form}.{$b}.checked == true) {\n";
        }else {
            $str.= "      if (document.{$this->form}.{$a}.checked != true) {\n";
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

    function bh_tb_img($title, $action, $image_name = "blank.png")
    {
        return "<a rel=\"$action\"><img src=\"". style_image($image_name). "\" alt=\"{$title}\" title=\"{$title}\" class=\"tools_up\" /></a>";
    }

    // ----------------------------------------------------

}

?>