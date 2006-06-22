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

/* $Id: install.inc.php,v 1.43 2006-06-22 20:04:04 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");

function dir_exists($dir)
{
    if (@is_dir($dir)) {

        if (filetype($dir) == 'dir') return true;
    }

    return false;
}

function check_install()
{
    if (isset($_POST['install_remove_files']) && $_POST['install_remove_files'] == 'Y') {

        install_remove_files();
    header_redirect('index.php');
    }

    if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {

        if ((@dir_exists('install') || @file_exists('install.php')) && !defined("BEEHIVE_INSTALL_NOWARN")) {

            echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
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
            echo "  <form method=\"get\" action=\"./index.php\">\n";
            echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
            echo "      <tr>\n";
            echo "        <td width=\"500\">&nbsp;</td>\n";
            echo "      </tr>\n";
            echo "      <tr>\n";
            echo "        <td align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Retry\" class=\"button\" /></td>\n";
            echo "      </tr>\n";
            echo "    </table>\n";
            echo "  </form>\n";
            echo "</div>\n";
            echo "</body>\n";
            echo "</html>\n";
            exit;
        }

        return;
    }

    header_redirect("./install.php");
}

function install_remove_files()
{
    if (defined("BEEHIVE_INSTALL_NOWARN")) return;

    rmdir_recursive('install');

    if (@file_exists('install.php')) return @unlink('install.php');
}

function rmdir_recursive($path)
{
   if (@$dir = opendir($path)) {

       while(($file = readdir($dir)) !== false) {

           if (is_file("$path/$file") && !is_link("$path/$file")) {

               unlink("$path/$file");

           }elseif (is_dir("$path/$file") && $file != '.' && $file != '..') {

               rmdir_recursive("$path/$file");
           }
       }

       closedir($dir);
   }

   @rmdir($path);
}

function install_incomplete()
{
    global $frame_top_target;
    
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
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
    echo "                  <td>Your BeehiveForum is not installed correctly. Click the install button below to start the installation.</td>\n";
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

    if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
        echo "  <form method=\"get\" action=\"./install.php\" target=\"$frame_top_target\">\n";
    }else {
        echo "  <form method=\"get\" action=\"./install.php\" target=\"_top\">\n";
    }

    echo "    <input type=\"hidden\" name=\"force_install\" value=\"yes\" />\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "      <tr>\n";
    echo "        <td width=\"500\">&nbsp;</td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Install\" class=\"button\" /></td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "  </form>\n";
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
    exit;
}

function install_get_webtags()
{
    $db_install_get_webtags = db_connect();

    $sql = "SELECT FID, WEBTAG FROM FORUMS ";
    $result = db_query($sql, $db_install_get_webtags);

    if (db_num_rows($result) > 0) {

        $forum_webtag_array = array();

        while ($row = db_fetch_array($result)) {
            $forum_webtag_array[$row['FID']] = $row['WEBTAG'];
        }

        return $forum_webtag_array;
    }

    return false;
}

function install_table_exists($table_name)
{
    $db_install_table_exists = db_connect();

    $table_name = addslashes($table_name);

    $sql = "SHOW TABLES LIKE '$table_name' ";
    $result = db_query($sql, $db_install_table_exists);

    return db_num_rows($result) > 0;
}

function install_check_tables($webtag = false, $forum_tables = false, $global_tables = false)
{
    $db_install_check_tables = db_connect();

    if (!is_array($forum_tables) && $forum_tables !== true) $forum_tables = false;
    if (!is_array($global_tables) && $global_tables !== true) $global_tables = false;

    if ($forum_tables === false) {

        $forum_tables = array('ADMIN_LOG',     'BANNED',          'FILTER_LIST',
                              'FOLDER',        'FORUM_LINKS',     'LINKS',
                              'LINKS_COMMENT', 'LINKS_FOLDERS',   'LINKS_VOTE',
                              'POLL',          'POLL_VOTES',      'POST',
                              'POST_CONTENT',  'PROFILE_ITEM',    'PROFILE_SECTION',
                              'STATS',         'THREAD',          'USER_FOLDER',
                              'USER_PEER',     'USER_POLL_VOTES', 'USER_PREFS',
                              'USER_PROFILE',  'USER_SIG',        'USER_THREAD');
    }

    if ($global_tables === false) {

        $global_tables = array('DICTIONARY',   'FORUMS',              'FORUM_SETTINGS',
                               'GROUPS',       'GROUP_PERMS',         'GROUP_USERS',
                               'PM',           'PM_ATTACHMENT_IDS',   'POST_ATTACHMENT_FILES',
                               'PM_CONTENT',   'POST_ATTACHMENT_IDS', 'SESSIONS',
                               'USER',         'USER_FORUM',          'USER_PREFS',
                               'USER_TRACK',   'VISITOR_LOG');
    }

    if (($webtag !== false) && preg_match("/^[A-Z0-9_]+$/", $webtag) > 0) {

        if (is_array($forum_tables) && sizeof($forum_tables) > 0) {
        
            foreach ($forum_tables as $forum_table) {

                $forum_table = addslashes($forum_table);
                
                $sql = "SHOW TABLES LIKE '{$webtag}_{$forum_table}' ";
                $result = db_query($sql, $db_install_check_tables);

                if (db_num_rows($result) > 0) return false;
            }
        }
    }

    if (is_array($forum_tables) && sizeof($forum_tables) > 0) {

        foreach ($global_tables as $global_table) {

            $global_table = addslashes($global_table);

            $sql = "SHOW TABLES LIKE '$global_table' ";
            $result = db_query($sql, $db_install_check_tables);

            if (db_num_rows($result) > 0) return false;
        }
    }

    return true;
}

function install_cli_show_help()
{
    $beehive_version = BEEHIVE_VERSION;

    echo "BeehiveForum $beehive_version CLI installer\n";
    echo "Copyright Project BeehiveForum 2002\n";
    echo "Usage: php [-Cq] new-install.php [OPTIONS]\n";
    echo "  --help      Display this help and exit\n";
    echo "  -h          MySQL hostname to connect to\n";
    echo "  -u          Username to use when connecting to MySQL server\n";
    echo "  -p          Password to use when connecting to MySQL server\n";
    echo "  -D          Database to use\n";
    echo "  -w          Webtag to use for forum\n";
    echo "  -U          Admin user account to create [Default: ADMIN]\n";
    echo "  -P          Password to use for Admin account [Default: honey]\n";
    echo "  -E          Email address to use [Default: admin@abeehiveforum.net]\n";
    echo "  -Cq         Required when using PHP CGI binary to install.\n";
}

function install_cli_show_upgrade_help()
{
    $beehive_version = BEEHIVE_VERSION;

    echo "BeehiveForum $beehive_version CLI upgrader\n";
    echo "Copyright Project BeehiveForum 2002 - ", date("Y", mktime()), "\n";
    echo "Usage: php [-Cq] new-install.php [OPTIONS]\n";
    echo "  --help      Display this help and exit\n";
    echo "  -h          MySQL hostname to connect to\n";
    echo "  -u          Username to use when connecting to MySQL server\n";
    echo "  -p          Password to use when connecting to MySQL server\n";
    echo "  -D          Database to use\n\n";
    echo "  -w          Webtag to use for forum\n";
    echo "  -U          Admin user account to create [Default: ADMIN]\n";
    echo "  -P          Password to use for Admin account [Default: honey]\n";
    echo "  -E          Email address to use [Default: admin@abeehiveforum.net]\n";
    echo "  -Cq         Required when using PHP CGI binary to install.\n\n";
    echo "Depending on the version of Beehive you're upgrading to you may not\n";
    echo "need to specify all of these options. Any options not required by\n";
    echo "this script will be ignored.\n";
}

function install_msie_buffer_fix()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        echo str_repeat("<!-- bh_install_buffer //-->\n", 20);
    }
}

function install_flush_buffer()
{
    echo "<!-- bh_install_buffer //-->\n";

    if (function_exists('ob_flush')) {
         if (ob_get_contents()) ob_flush();
    }

    flush();
}

?>