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

require_once("./include/session.inc.php");
require_once("./include/user.inc.php");

if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){

  $userprefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
  $userprefs['FONT_SIZE'] .= 'pt';
  
}else {

  $userprefs['FONT_SIZE'] = '10pt';
  
}

if ($userprefs['FONT_SIZE'] == 'pt') $userprefs['FONT_SIZE'] = '10pt';

$stylesheet = file('styles/style.css');

while(list($linenum, $line) = each($stylesheet)) {
  
  echo str_replace("\$FONTSIZE", $userprefs['FONT_SIZE'], $line);
  
}


?>