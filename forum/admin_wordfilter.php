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

/* $Id: admin_wordfilter.php,v 1.13 2003-09-21 12:57:58 decoyduck Exp $ */

// Frameset for thread list and messages

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/lang.inc.php");

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)){

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;

}

html_draw_top();

if (isset($HTTP_POST_VARS['save'])) {

    if (isset($HTTP_POST_VARS['wordlist']) && strlen($HTTP_POST_VARS['wordlist']) > 0) {
        admin_save_word_filter($HTTP_POST_VARS['wordlist']);
    }else {
        admin_clear_word_filter();
    }

    $status_text = "<p><b>{$lang['wordfilterupdated']}</b></p>";
    admin_addlog(0, 0, 0, 0, 0, 0, 24);
}

$word_filter_array = admin_get_word_filter();
$wordlist = implode("\n", $word_filter_array);

echo "<form name=\"startpage\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\">\n";
echo "<h1>{$lang['editwordfilter']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['wordfilterexp_1']}</p>\n";
echo "<p>{$lang['wordfilterexp_2']}</p>\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>", form_textarea('wordlist', _htmlentities($wordlist), 20, 90, 'off', 'style="font-family: monospace"'), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>", form_submit('save', $lang['save']), "&nbsp;", form_reset(), "</p>\n";
echo "</form>\n";

html_draw_bottom();

?>