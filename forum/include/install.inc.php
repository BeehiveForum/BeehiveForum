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

/* $Id$ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

include_once(BH_INCLUDE_PATH. "browser.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

function dir_exists($dir)
{
    if (@is_dir($dir)) {

        if (filetype($dir) == 'dir') return true;
    }

    return false;
}

function check_install()
{
    if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {

        if ((@dir_exists('install') || @file_exists('./install/install.php')) && !defined("BEEHIVE_INSTALL_NOWARN")) {

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
            echo "                        <td align=\"left\">Your Beehive Forum would appear to be already installed, but you have not removed the installation files. You must delete the 'install' directory before your Beehive Forum can be used.</td>\n";
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
            echo "  <form accept-charset=\"utf-8\" method=\"get\" action=\"index.php\">\n";
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

    header_redirect("./install/install.php");
}

function install_incomplete()
{
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
    echo "  <form accept-charset=\"utf-8\" method=\"get\" action=\"./install/install.php\" target=\"", html_get_top_frame_name(), "\">\n";
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
    if (($mysql_version = db_fetch_mysql_version())) {

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
            echo "                        <td align=\"left\">MySQL Server Version 4.1.16 or newer is required to run Beehive Forum. Please upgrade your MySQL installtion.</td>\n";
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
    if (version_compare(phpversion(), "5.1.0", "<")) {

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
        echo "                        <td align=\"left\">PHP Version 5.1.0 or newer is required to run Beehive Forum. Please upgrade your PHP installation.</td>\n";
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

    $sql = "SELECT FID, CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX, ";
    $sql.= "DATABASE_NAME, WEBTAG FROM FORUMS";

    if (!$result = db_query($sql, $db_install_get_webtags)) return false;

    if (db_num_rows($result) > 0) {

        $forum_webtag_array = array();

        while (($forum_webtags_data = db_fetch_array($result))) {
            $forum_webtag_array[$forum_webtags_data['FID']] = $forum_webtags_data;
        }

        return $forum_webtag_array;
    }

    return false;
}

function install_format_table_prefix($database_name, $webtag)
{
    return sprintf('%s`.`%s_', $database_name, $webtag);
}

function install_table_exists($database_name, $table_name)
{
    if (!$db_install_table_exists = db_connect()) return false;

    $table_name = db_escape_string($table_name);

    $sql = "SHOW TABLES FROM `$database_name` LIKE '$table_name'";

    if (!$result = db_query($sql, $db_install_table_exists)) return false;

    return (db_num_rows($result) > 0);
}

function install_column_exists($database_name, $table_name, $column_name)
{
    if (!$db_install_column_exists = db_connect()) return false;

    $column_name = db_escape_string($column_name);

    $sql = "SHOW COLUMNS FROM `$database_name`.`$table_name` LIKE '$column_name'";

    if (!$result = db_query($sql, $db_install_column_exists)) return false;

    return (db_num_rows($result) > 0);
}

function install_index_exists($database_name, $table_name, $index_name)
{
    if (!$db_install_index_exists = db_connect()) return false;

    $sql = "SHOW INDEXES FROM `$database_name`.`$table_name`";

    if (!$result = db_query($sql, $db_install_index_exists)) return false;

    while (($table_data = db_fetch_array($result))) {
        if (strstr($table_data['Column_name'], $index_name) == 0) return true;
    }

    return false;
}

function install_check_table_conflicts($database_name, $webtag, $forum_tables = false, $global_tables = false, $remove_conflicts = false)
{
    $conflicting_tables_array = array();

    if ((!is_array($forum_tables) || sizeof($forum_tables) < 1) && !is_bool($forum_tables)) {
        $forum_tables = false;
    }

    if ((!is_array($global_tables) || sizeof($global_tables) < 1) && !is_bool($global_tables)) {
        $global_tables = false;
    }

    if ($forum_tables === true) {

        $forum_tables = array('ADMIN_LOG',     'BANNED',          'FOLDER',
                              'FORUM_LINKS',   'LINKS',           'LINKS_COMMENT',
                              'LINKS_FOLDERS', 'LINKS_VOTE',      'POLL',
                              'POLL_VOTES',    'POST',            'POST_CONTENT',
                              'PROFILE_ITEM',  'PROFILE_SECTION', 'RSS_FEEDS',
                              'RSS_HISTORY',   'STATS',           'THREAD',
                              'THREAD_STATS',  'THREAD_TRACK',    'USER_FOLDER',
                              'USER_PEER',     'USER_POLL_VOTES', 'USER_PREFS',
                              'USER_PROFILE',  'USER_SIG',        'USER_THREAD',
                              'USER_TRACK',    'WORD_FILTER');
    }

    if ($global_tables === true) {

        $global_tables = array('DICTIONARY',          'FORUMS',              'FORUM_SETTINGS',
                               'GROUPS',              'GROUP_PERMS',         'GROUP_USERS',
                               'PM',                  'PM_ATTACHMENT_IDS',   'PM_CONTENT',
                               'PM_FOLDERS',          'PM_SEARCH_RESULTS',   'POST_ATTACHMENT_FILES',
                               'POST_ATTACHMENT_IDS', 'SEARCH_ENGINE_BOTS',  'SEARCH_RESULTS',
                               'SESSIONS',            'TIMEZONES',           'USER',
                               'USER_FORUM',          'USER_HISTORY',        'USER_PREFS',
                               'VISITOR_LOG');
    }

    if (is_array($forum_tables) && sizeof($forum_tables) > 0) {

        foreach ($forum_tables as $forum_table) {

            $check_forum_table = "{$webtag}_{$forum_table}";

            if (install_table_exists($database_name, $check_forum_table)) {

                if ($remove_conflicts === false || ($remove_conflicts === true && !install_remove_table($database_name, $check_forum_table))) {

                    $conflicting_tables_array[] = "'$check_forum_table'";
                }
            }
        }
    }

    if (is_array($global_tables) && sizeof($global_tables) > 0) {

        foreach ($global_tables as $check_global_table) {

            if (install_table_exists($database_name, $check_global_table)) {

                if ($remove_conflicts === false || ($remove_conflicts === true && !install_remove_table($database_name, $check_global_table))) {

                    $conflicting_tables_array[] = "'{$check_global_table}'";
                }
            }
        }
    }

    return (sizeof($conflicting_tables_array) > 0) ? $conflicting_tables_array : false;
}

function install_remove_table($database_name, $table_name)
{
    if (!$db_install_remove_table = db_connect()) return false;

    $sql = "DROP TABLE IF EXISTS `$database_name`.`$table_name`";

    if (!db_query($sql, $db_install_remove_table)) return false;

    return true;
}

function install_remove_indexes($database_name, $table_name)
{
    if (!$db_install_remove_indexes = db_connect()) return false;

    $table_name = db_escape_string($table_name);

    $sql = "SHOW INDEX FROM `$database_name`.`$table_name`";

    if (!$result = db_query($sql, $db_install_remove_indexes)) return false;

    while ((list(,,$key_name) = db_fetch_array($result, DB_RESULT_NUM))) {

        if (preg_match("/^PRIMARY$/", mb_strtoupper($key_name)) < 1) {

            $sql = "ALTER IGNORE TABLE `$database_name`.`$table_name` DROP INDEX `$key_name`";
            @db_query($sql, $db_install_remove_indexes);
        }
    }

    return true;
}

function install_msie_buffer_fix()
{
    if (browser_check(BROWSER_MSIE)) {
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