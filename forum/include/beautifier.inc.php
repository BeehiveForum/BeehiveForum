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

include_once("./beautifier/language_definitions.inc.php");
include_once("./beautifier/Beautifier/Init.php");
global $BEAUT_PATH;
include_once("$BEAUT_PATH/Output/Output_HTML.php");

$beaut_highlighter = array();
$_beaut_out = new Output_HTML();
$_beaut_done = array();
if (!isset($beaut_langs)) $beaut_langs = array();
foreach($beaut_langs as $_beaut_k => $_beaut_v) {
	if (!isset($_beaut_done[$_beaut_v])) {
		$_beaut_done[$_beaut_v] = $_beaut_k;
		include_once("$BEAUT_PATH/HFile/$_beaut_v.php");
		$beaut_highlighter[$_beaut_k] = new Core(new $_beaut_v(), $_beaut_out);
	} else {
		$beaut_highlighter[$_beaut_k] = $beaut_highlighter[$_beaut_done[$_beaut_v]];
	}
}

unset($_beaut_k);
unset($_beaut_v);
unset($_beaut_out);
unset($_beaut_done);
unset($beaut_langs);

?>