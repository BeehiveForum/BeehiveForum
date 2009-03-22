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

/* $Id: geshi.inc.php,v 1.19 2009-03-22 18:48:14 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function geshi_error_handler ()
{
    return;
}

if (@file_exists("geshi/geshi.php")) {

    include_once("geshi/geshi.php");

}else {

    class GeSHi {

        private $source;
        private $target;

        private $encoding;
        private $lang;

        private $error = false;
        private $strict_mode = false;

        function GeSHi()
        {
            $this->source = '';
            $this->target = '';
        }

        function set_encoding($encoding)
        {
            $this->encoding = $encoding;
        }

        function set_link_target()
        {
            return;
        }

        function set_source($source)
        {
            $this->source = $source;
        }

        function set_language($lang)
        {
            $this->$lang = $lang;
        }

        function parse_code()
        {
            return htmlentities_array($this->source);
        }

        function get_language_name_from_extension()
        {
            return;
        }
    }
}

?>