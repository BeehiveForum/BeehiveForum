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

// style.php : handles site styles with user preferences

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");

header_no_cache();
header("Content-Type: text/css");

if (empty($HTTP_GET_VARS['fontsize'])) {
    $fontsize = "10pt";
}else{
    $fontsize = $HTTP_GET_VARS['fontsize']."pt";
}

if(isset($default_style)){
    $user_style = empty($HTTP_COOKIE_VARS['bh_sess_style']) ? $default_style : $HTTP_COOKIE_VARS['bh_sess_style'];
    $stylesheet = file("styles/$user_style/style.css");
} else {
    $stylesheet = file('styles/style.css');
}

while(list($linenum, $line) = each($stylesheet)) {
    echo str_replace("\$FONTSIZE", $fontsize, $line);
}

?>
