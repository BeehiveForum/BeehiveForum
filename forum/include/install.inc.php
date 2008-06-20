<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: install.inc.php,v 1.68 2008-06-20 13:45:45 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "header.inc.php");
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
    install_check_php_version();

    install_check_mysql_version();

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
            echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
            echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
            echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
            echo "</head>\n";
            echo "<h1>Beehive Forum Installation Error</h1>\n";
            echo "<br />\n";
            echo "<div align=\"center\">\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"500\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">Installation Incomplete</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">Your Beehive Forum would appear to be already installed, but you have not removed the installation files. You must delete both the 'install' directory and install.php before your Beehive Forum can be used.</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\">&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "      </td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "  <form method=\"get\" action=\"index.php\">\n";
            echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
            echo "      <tr>\n";
            echo "        <td align=\"left\" width=\"500\">&nbsp;</td>\n";
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

    header_redirect("install.php");
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
    $frame_top_target = html_get_top_frame_name();

    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
    echo "</head>\n";
    echo "<h1>Beehive Forum Installation Error</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"500\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">Installation Incomplete</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">Your Beehive Forum is not installed correctly. Click the install button below to start the installation.</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <form method=\"get\" action=\"install.php\" target=\"", html_get_top_frame_name(), "\">\n";
    echo "    <input type=\"hidden\" name=\"force_install\" value=\"yes\" />\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\" width=\"500\">&nbsp;</td>\n";
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

function install_missing_files()
{
    $frame_top_target = html_get_top_frame_name();

    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
    echo "</head>\n";
    echo "<h1>Beehive Forum Installation Error</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"500\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">Installation Incomplete</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">Your Beehive Forum is not installed correctly. Some required files could not be found. Please check that all the required files have been correctly uploaded. If in doubt please consult readme.txt.</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
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

function install_check_mysql_version()
{
    if (db_fetch_mysql_version($mysql_version)) {

        if ($mysql_version < 40116) {

            echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
            echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
            echo "<head>\n";
            echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
            echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
            echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
            echo "</head>\n";
            echo "<h1>Beehive Forum Minimum Requirements Error</h1>\n";
            echo "<br />\n";
            echo "<div align=\"center\">\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"500\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">Minimum Requirements not met</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">MySQL Server Version 4.1.16 or newer is required to run Beehive Forum. Please upgrade.</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
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
}

function install_check_php_version()
{
    if (version_compare(phpversion(), "4.3.2", "<")) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
        echo "</head>\n";
        echo "<h1>Beehive Forum Minimum Requirements Error</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"500\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">Minimum Requirements not met</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">PHP Version 4.3.2 or newer is required to run Beehive Forum. Please upgrade.</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
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
    if (!$db_install_get_webtags = db_connect()) return false;

    $sql = "SELECT FID, WEBTAG FROM FORUMS ";

    if (!$result = db_query($sql, $db_install_get_webtags)) return false;

    if (db_num_rows($result) > 0) {

        $forum_webtag_array = array();

        while ($forum_webtags_data = db_fetch_array($result)) {
            $forum_webtag_array[$forum_webtags_data['FID']] = $forum_webtags_data['WEBTAG'];
        }

        return $forum_webtag_array;
    }

    return false;
}

function install_table_exists($table_name)
{
    if (!$db_install_table_exists = db_connect()) return false;

    $table_name = db_escape_string($table_name);

    $sql = "SHOW TABLES LIKE '$table_name' ";

    if (!$result = db_query($sql, $db_install_table_exists)) return false;

    return (db_num_rows($result) > 0);
}

function install_get_table_conflicts($webtag = false, $forum_tables = false, $global_tables = false)
{
    if (!$db_install_get_table_conflicts = db_connect()) return false;

    $conflicting_tables_array = array();

    if (is_array($forum_tables) && sizeof($forum_tables) < 1) $forum_tables = false;
    if (is_array($global_tables) && sizeof($global_tables) < 1) $global_tables = false;

    if ($forum_tables === true) {

        $forum_tables = array('ADMIN_LOG',     'BANNED',          'FOLDER',
                              'FORUM_LINKS',   'LINKS',           'LINKS_COMMENT',
                              'LINKS_FOLDERS', 'LINKS_VOTE',      'POLL',
                              'POLL_VOTES',    'POST',            'POST_CONTENT',
                              'PROFILE_ITEM',  'PROFILE_SECTION', 'RSS_FEEDS',
                              'RSS_HISTORY',   'STATS',           'THREAD',
                              'THREAD_TRACK',  'THREAD_STATS',    'USER_FOLDER',
                              'USER_PEER',     'USER_POLL_VOTES', 'USER_PREFS',
                              'USER_PROFILE',  'USER_SIG',        'USER_THREAD',
                              'USER_TRACK',    'WORD_FILTER');
    }

    if ($global_tables === true) {

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

                $forum_table = db_escape_string($forum_table);

                $sql = "SHOW TABLES LIKE '{$webtag}_{$forum_table}' ";

                if (!$result = db_query($sql, $db_install_get_table_conflicts)) return false;

                if (db_num_rows($result) > 0) {
                    $conflicting_tables_array[] = "'{$webtag}_{$forum_table}'";
                }
            }
        }
    }

    if (is_array($global_tables) && sizeof($global_tables) > 0) {

        foreach ($global_tables as $global_table) {

            $global_table = db_escape_string($global_table);

            $sql = "SHOW TABLES LIKE '$global_table' ";

            if (!$result = db_query($sql, $db_install_get_table_conflicts)) return false;

            if (db_num_rows($result) > 0) {
                $conflicting_tables_array[] = "'{$global_table}'";
            }
        }
    }

    if (sizeof($conflicting_tables_array) > 0) {
        return $conflicting_tables_array;
    }

    return false;
}

function install_remove_table_keys($table_name)
{
    if (!$db_install_remove_table_keys = db_connect()) return false;

    if ($table_name !== db_escape_string($table_name)) return false;

    $table_index = array();

    $sql = "SHOW INDEX FROM $table_name";

    if (!$result = db_query($sql, $db_install_remove_table_keys)) return false;

    while ($table_index_data = db_fetch_array($result)) {

        if (preg_match("/^PRIMARY$/", strtoupper($table_index_data['Key_name'])) < 1) {

            $table_index[$table_index_data['Key_name']] = $table_index_data['Column_name'];
        }
    }

    foreach ($table_index as $key_name => $column_name) {

        $sql = "ALTER TABLE $table_name DROP INDEX $key_name";

        if (!$result = @db_query($sql, $db_install_remove_table_keys)) return false;
    }

    return true;
}

function install_msie_buffer_fix()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        echo str_repeat("<!-- bh_install_buffer //-->\n", 20);
    }
}

function install_prevent_client_timeout()
{
    static $buffer_line_count = 0;

    if ($buffer_line_count < 1000) {

        $buffer_line_count++;

    }else {

        echo "<!-- bh_install_buffer //-->\n";

        $buffer_line_count = 0;

        if (function_exists('ob_flush')) {
            if (ob_get_contents()) ob_flush();
        }

        flush();
    }
}

?>