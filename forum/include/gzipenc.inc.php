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

// Compresses the output of the PHP scripts to save bandwidth.
// Due to problems with the gzip library in PHP 4.1.0 and lower,
// we only support gzip compression in PHP version 4.2.0 and higher.

require_once("./include/config.inc.php");

if ($gzip_compress_output && (phpversion() >= '4.2')) {
    if (isset($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING']) && strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) {
        ob_start("ob_gzhandler");
    }else{
        ob_start();
    }
}else {
    ob_start();
}

?>