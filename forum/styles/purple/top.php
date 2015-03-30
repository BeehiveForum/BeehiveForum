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

// Beehive Forum bootstrap if Beehive root is located in public_html folder;  /home/yoursite/public_html/Beehive/
require_once __DIR__ . '/../../boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'browser.inc.php';
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'styles.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Get forum WEBTAG
$webtag = get_webtag();

$forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

// Don't cache this page - fixes problems with Opera.
cache_disable();

html_draw_top(
    array(
        'class' => 'top_banner',
    )
);
echo "    <link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\"/>\n";
echo "    <link rel=\"stylesheet\" href=\"images.css\" type=\"text/css\"/>\n";
echo "  <div  align=\"center\" width=\"100%\"  class=\"top_banner\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" colspan=\"3\" rowspan=\"1\" width=\"100%\" height=\"60px\" border=\"0\" class=\"forum_title\"><tbody><tr>\n";
echo "      <td colspan=\"1\" rowspan=\"1\" border=\"0\" class=\"image beehive-logo\"><a href="http://www.beehiveforum.co.uk/" target="_blank">Project Beehive Forum</a></td>\n";
echo "      <td align=\"center\" valign=\"middle\" colspan=\"1\" rowspan=\"1\" wrap=\"nowrap\">$forum_name</td>\n";
echo "      <td colspan=\"1\" rowspan=\"1\" border=\"0\" class=\"sourceforge-logo\"><a href="http://sourceforge.net" target="_blank">Sourceforge.net</a></td>\n";
echo "  </tr></tbody></table>\n";
echo" </div>\n";
html_draw_bottom();
