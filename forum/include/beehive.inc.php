<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
// End Required includes

function draw_beehive_bar()
{
    echo "<div align=\"center\">\n";
    echo "<table width=\"98%\">\n";
    echo "  <tr>\n";
    echo "    <td width=\"60%\" align=\"left\">\n";
    echo "      Beehive Forum ", BEEHIVE_VERSION, "&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/faq/\" target=\"_blank\">", gettext("FAQ"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/docs/\" target=\"_blank\">", gettext("Docs"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/support/\" target=\"_blank\">", gettext("Support"), "</a>&nbsp;|&nbsp;\n";
    echo "      <a href=\"http://www.beehiveforum.co.uk/donate/\" target=\"_blank\">", gettext("Donate!"), "</a>\n";
    echo "    </td>\n";
    echo "    <td width=\"40%\" align=\"right\">&copy;2002 - ", strftime("%Y", time()), " <a href=\"http://www.beehiveforum.co.uk/\" target=\"_blank\">Project&nbsp;Beehive&nbsp;Forum</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}