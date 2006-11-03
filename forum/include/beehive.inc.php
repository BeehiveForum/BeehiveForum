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

/* $Id: beehive.inc.php,v 1.49 2006-11-03 23:00:10 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function draw_beehive_bar()
{
    $lang = load_language_file();

    echo "<div align=\"center\">\n";
    echo "<table width=\"98%\">\n";
    echo "  <tr>\n";
    echo "    <td width=\"60%\" class=\"smalltext\" align=\"left\">\n";
    echo "      Beehive Forum ", BEEHIVE_VERSION, "&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.net/faq/\" target=\"_blank\">{$lang['faq']}</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://sourceforge.net/docman/?group_id=50772\" target=\"_blank\">{$lang['docs']}</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://sourceforge.net/tracker/?group_id=50772&amp;atid=460926\" target=\"_blank\">{$lang['support']}</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://sourceforge.net/donate/?group_id=50772\" target=\"_blank\">{$lang['donateexcmark']}</a>\n";
    echo "    </td>\n";
    echo "    <td width=\"40%\" align=\"right\" class=\"smalltext\">&copy;2002 - ", date("Y", mktime()), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

?>