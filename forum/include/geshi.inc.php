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

/* $Id: geshi.inc.php,v 1.13 2008-07-27 18:26:15 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function geshi_error_handler () {
    return;
}

if (file_exists("geshi/geshi.php")) {

    include_once("geshi/geshi.php");

}else {

    class GeSHi {

        var $source;
        var $target;

        // these don't get used but need to be set because of a bug in GeSHi
        var $error = false;
        var $strict_mode = false;

        function GeSHi() {
            $this->source = '';
            $this->target = '';
        }

        function set_encoding($encoding) {
            return;
        }

        function set_link_target() {
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
}

?>