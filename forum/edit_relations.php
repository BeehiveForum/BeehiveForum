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

/* $Id: edit_relations.php,v 1.1 2004-02-23 21:31:27 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");

// Start output here

html_draw_top();

echo "<h1>{$lang['userrelationships']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

$uid = bh_session_get_value('UID');

// Define the options for the drop downs

$update_options = array("Friend", "Ignored", "Ignored Signature");

if ($user_peers = user_get_friends($uid)) {

    echo "<br />\n";
    echo "<div class=\"postbody\">\n";
    echo "  <form name=\"prefs\" action=\"edit_relations.php\" method=\"post\" target=\"_self\">\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"box\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"400\">\n";
    echo "                  <tr>\n";
    echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['friends']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    
    foreach ($user_peers as $user_peer) {
        echo "                    <td>&nbsp;<a href=\"user_rel.php?uid={$user_peer['UID']}&edit_rel=1\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";
    }
    
    reset ($user_peers);

    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "    <br />\n";
}

if ($user_peers = user_get_ignored($uid)) {
    
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"box\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"300\">\n";
    echo "                  <tr>\n";
    echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['ignored']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    
    foreach ($user_peers as $user_peer) {
        echo "                    <td>&nbsp;<a href=\"user_rel.php?uid={$user_peer['UID']}&edit_rel=1\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";
    }

    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "    <br />\n";    
}

if ($user_peers = user_get_ignored_signatures($uid)) {
    
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"box\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"300\">\n";
    echo "                  <tr>\n";
    echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['ignored']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    
    foreach ($user_peers as $user_peer) {
        echo "                    <td>&nbsp;<a href=\"user_rel.php?uid={$user_peer['UID']}&edit_rel=1\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";
    }

    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "    <br />\n";    
}

html_draw_bottom();

?>