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

// Compress the output
require_once("./include/gzipenc.inc.php");

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

    $content = _stripslashes($HTTP_POST_VARS['content']);
    $content = str_replace(chr(13), '', $content);

    if (substr($content, 0, 51) != "<?php require_once(\"./include/gzipenc.inc.php\"); ?>") {
      $content = "<?php require_once(\"./include/gzipenc.inc.php\"); ?>\n". $content;
    }

    $fp = fopen('./start_main.php', 'w');
    fwrite($fp, $content);
    fclose($fp);

    $status_text = "<p><b>{$lang['startpageupdated']}</b> <a href=\"./start_main.php\" target=\"_blank\">{$lang['viewupdatedstartpage']}</a></p>";

    admin_addlog(0, 0, 0, 0, 0, 0, 16);

}else{

    if (file_exists('./start_main.php')) {

        $content = implode('', file('./start_main.php'));
        $content = str_replace(chr(13), '', $content);

    }else {

        $content = "";

    }

}

echo "<form name=\"startpage\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\">\n";
echo "<h1>{$lang['editstartpage']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['editstartpageexp']}</p>\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>", form_textarea('content', _htmlentities($content), 20, 90, 'off', 'style="font-family: monospace"'), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>", form_submit('save', $lang['save']), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_reset(), "</p>\n";
echo "</form>\n";

html_draw_bottom();

?>
