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

/* $Id: install.inc.php,v 1.13 2004-11-21 14:08:09 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once("./include/config.inc.php");
}

include_once("./include/html.inc.php");

function check_install()
{
    if (!defined("BEEHIVE_INSTALLED")) {
        header_redirect("./install.php");
    }

    if ((file_exists('install') || file_exists('install.php')) && !defined("BEEHIVE_INSTALL_NOWARN")) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>BeehiveForum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
        echo "</head>\n";
        echo "<h1>BeehiveForum Installation Error</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"500\">\n";
        echo "                <tr>\n";
        echo "                  <td colspan=\"2\" class=\"subhead\">Installation Incomplete</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>Your BeehiveForum would appear to be already installed, but you have not removed the installation files. You must delete both the 'install' directory and install.php before your Beehive Forum can be used.</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</div>\n";
        echo "</body>\n";
        echo "</html>\n";
        exit;
    }
}

function install_get_webtags()
{
    $db_install_get_webtags = db_connect();

    $sql = "SHOW TABLES LIKE 'FORUMS' ";
    $result = db_query($sql, $db_install);

    if (db_num_rows($result) > 0) {

        $sql = "SELECT WEBTAG FROM FORUMS ";
        $result = db_query($sql, $db_install);

        $forum_webtag_array = array();

        while ($row = db_fetch_array($result)) {
            $forum_webtag_array[] = $row['WEBTAG'];
        }

        return $forum_webtag_array;
    }

    return false;
}

?>