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

$db = db_connect();

if (isset($HTTP_POST_VARS['save'])) {

    $sql = "DELETE FROM ". forum_table("FILTER_LIST");
    $result = db_query($sql, $db);

    $filter_array = array();

    if (isset($HTTP_POST_VARS['wordlist']) && strlen($HTTP_POST_VARS['wordlist']) > 0) {
        $filter_array = explode("\n", $HTTP_POST_VARS['wordlist']);
        for ($i = 0; $i < sizeof($filter_array); $i++) {
           if (substr($filter_array[$i], 0, 1) == '/' && substr($filter_array[$i], -1) == '/') {
               $filter_array[$i] = substr($filter_array[$i], 1, -1);
           }
           $sql = "INSERT INTO ". forum_table("FILTER_LIST"). " (FILTER) ";
           $sql.= "VALUES ('". $filter_array[$i]. "')";
           $result = db_query($sql, $db);
        }
    }

    $status_text = "<p><b>{$lang['wordfilterupdated']}</b></p>";
    admin_addlog(0, 0, 0, 0, 0, 0, 24);

}else{

    $sql = "SELECT FILTER FROM ". forum_table("FILTER_LIST");
    $result = db_query($sql, $db);

    $filter_array = array();

    while($row = db_fetch_array($result)) {
      $filter_array[] = $row['FILTER'];
    }

}

$wordlist = implode("\n", $filter_array);

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
echo "<p>", form_submit('save', $lang['save']), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_reset(), "</p>\n";
echo "</form>\n";

html_draw_bottom();

?>
