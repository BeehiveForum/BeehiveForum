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

/* $Id: geshi.inc.php,v 1.6 2005-07-23 22:53:32 decoyduck Exp $ */

// GeSHi is a generic syntax highlighter under the General Public License
// http://qbnz.com/highlighter/
// To include GeSHi syntax highlighting with your Beehive install simply
// download the latest version of GeSHi (tested with 1.0.6) and upload it
// to a subdirectory 'geshi' in your main forum folder (if your forum was
// at www.site.com/forum/, upload to www.site.com/forum/geshi/).

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (file_exists("./geshi/geshi.php")) {

    include_once("./geshi/geshi.php");

    $path = "geshi/geshi";

    $code_highlighter = new GeSHi("", "", $path);
    $code_highlighter->set_link_target("_blank");
    $code_highlighter->set_encoding("UTF-8");

    /* To save speed/bandwidth, several highlighting features can be disabled/limited.
    See: http://qbnz.com/highlighter/geshi-doc.html#disabling-lexics

    $code_highlighter->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $code_highlighter->set_line_style('background: #555555;', true);

    $code_highlighter->set_keyword_group_highlighting($group, $flag);
    $code_highlighter->set_comments_highlighting($group, $flag);
    $code_highlighter->set_regexps_highlighting($regexp, $flag);

    $code_highlighter->set_escape_characters_highlighting($flag);
    $code_highlighter->set_symbols_highlighting($flag);
    $code_highlighter->set_strings_highlighting($flag);
    $code_highlighter->set_numbers_highlighting($flag);
    $code_highlighter->set_methods_highlighting($flag);
    */

}else {

    class fake_geshi {

        var $source = '';

        // these don't get used but need to be set because of a bug in GeSHi
        var $error = false;
        var $strict_mode = false;

        function fake_geshi() {
            return;
        }

        function set_source($source) {
            $this->source = $source;
        }

        function set_language($lang) {
            return;
        }

        function parse_code() {
            return _htmlentities($this->source);
        }

        function get_language_name_from_extension() {
            return;
        }
    }

    $code_highlighter = new fake_geshi();
}

?>