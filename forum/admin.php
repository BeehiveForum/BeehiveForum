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

/* $Id: admin.php,v 1.29 2004-03-10 18:43:16 decoyduck Exp $ */

//Multiple forum support
require_once("./include/forum.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");

require_once("./include/header.inc.php");
require_once("./include/messages.inc.php");

if (!bh_session_check()) {

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/config.inc.php");

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)){
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (!isset($default_style)) $default_style = "default";
$stylesheet = "./styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style). "/style.css";

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
echo "</head>\n";
echo "<frameset cols=\"150,*\" border=\"1\">\n";
echo "  <frame src=\"./admin_menu.php?webtag=$webtag\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
echo "  <frame src=\"./admin_main.php?webtag=$webtag\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
echo "</frameset>\n";
echo "</html>\n";

?>