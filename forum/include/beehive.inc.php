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

/* $Id: beehive.inc.php,v 1.27 2004-02-02 23:21:38 decoyduck Exp $ */

require_once("./include/lang.inc.php");

function draw_beehive_bar()
{
    global $lang;

    echo "<div align=\"center\">\n";
    echo "<table width=\"96%\" class=\"posthead\">\n";
    echo "  <tr>\n";
    echo "    <td width=\"60%\" class=\"smalltext\" align=\"left\">\n";
    echo "      Beehive Forum 0.4.1-dev4&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://beehiveforum.net/faq\" target=\"_blank\">{$lang['faq']}</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://sourceforge.net/docman/?group_id=50772\" target=\"_blank\">{$lang['docs']}</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://sourceforge.net/tracker/?group_id=50772&amp;atid=460926\" target=\"_blank\">{$lang['support']}</a>\n";
    echo "    </td>\n";
    echo "    <td width=\"40%\" align=\"right\" class=\"smalltext\">&copy;2003 <a href=\"http://beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

?>