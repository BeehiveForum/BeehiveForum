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

/* $Id: admin_startpage.php,v 1.30 2004-03-15 21:33:28 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {

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

    if (substr($content, 0, 51) != "<?php include_once(\"./include/gzipenc.inc.php\"); ?>") {
      $content = "<?php include_once(\"./include/gzipenc.inc.php\"); ?>\n". $content;
    }

    $fp = fopen('./start_main.php', 'w');
    fwrite($fp, $content);
    fclose($fp);

    $status_text = "<p><b>{$lang['startpageupdated']}</b> <a href=\"start_main.php?webtag={$webtag['WEBTAG']}\" target=\"_blank\">{$lang['viewupdatedstartpage']}</a></p>";

    admin_addlog(0, 0, 0, 0, 0, 0, 16);

}else{

    if (file_exists('./start_main.php')) {

        $content = implode('', file('./start_main.php'));
        $content = str_replace(chr(13), '', $content);

    }else {

        $content = "";

    }

}

echo "<h1>{$lang['admin']} : {$lang['editstartpage']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['editstartpageexp']}</p>\n";
echo "<form name=\"startpage\" method=\"post\" action=\"admin_startpage.php?webtag={$webtag['WEBTAG']}\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td>", form_textarea('content', _htmlentities($content), 20, 90, 'off', 'style="font-family: monospace"'), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_reset(), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>