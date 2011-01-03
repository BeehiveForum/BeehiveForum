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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

/**
* check_install
*
* Check that the config file exists and the installer
* files have been removed correctly.
*
* @param void
* @return void
*/
function check_install()
{
    // Check the config file exists.
    if (!file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
        header_redirect('./install/index.php');
    }

    // Check if the installer files still exist. Ignore them
    // if the BEEHIVE_INSTALL_NOWARN constant has been defined.
    if (@file_exists('./install/index.php') && !defined("BEEHIVE_INSTALL_NOWARN")) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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
}

/**
* install_incomplete
*
* Show error message about incomplete install.
* Called by the exception handler when it encounters
* a missing table or column or other SQL error.
*
* @param void
* @return void
*/
function install_incomplete()
{
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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
    echo "  <form accept-charset=\"utf-8\" method=\"get\" action=\"./install/index.php\" target=\"", html_get_top_frame_name(), "\">\n";
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

/**
* install_missing_files
*
* Show error message when the Exception handler
* encounters a missing file that has been tried
* to be included by the main script.
*
* @param void
* @return void
*/
function install_missing_files()
{
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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

/**
* install_check_mysql_version
*
* Check the MySQL Version matches or betters
* the version required by Beehive Forum to
* run correctly.
*
* @param void
* @return mixed
*/
function install_check_mysql_version()
{
    // Get the MySQL version.
    $mysql_version = db_fetch_mysql_version();

    // If the version isn't available or is below what we need show an error
    if (!is_numeric($mysql_version) || ($mysql_version < 50141)) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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

/**
* install_check_php_extensions
*
* Check the installed PHP extensions that Beehive
* requires to function correctly.
*
* @param void
* @return void
*/
function install_check_php_extensions()
{
    // Static variable to store our required extensions.
    static $required_extensions = false;

    // Initialise the variable store.
    if (!is_array($required_extensions)) {
        $required_extensions = array('date', 'mbstring', 'gd', 'json', 'mysqli', 'pcre', 'xml');
    }

    // Get an array of extensions currently loaded by PHP
    $loaded_extensions = get_loaded_extensions();

    // Compare them to the ones we require.
    if (array_diff($required_extensions, $loaded_extensions)) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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
        echo "                        <td align=\"left\">Some PHP extensions required to run Beehive Forum are not installed. Please check your PHP installation.</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\"><b>Required Extensions:</b></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\">\n";
        echo "                          <table class=\"posthead\" width=\"95%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\">";

        // Display a list of PHP extensions we use.
        foreach ($required_extensions as $extension_name) {
            echo "                                <a href=\"http://www.php.net/", $extension_name, "\">", $extension_name, "</a><br />\n";
        }

        echo "                              </td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
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

/**
* install_check_php_version
*
* Check the current PHP version matches our minimum
* requirements.
*
* @param void
* @return void.
*/
function install_check_php_version()
{
    // Get and compare the PHP version.
    if (version_compare(phpversion(), "5.2.0", "<")) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
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
        echo "                        <td align=\"left\">PHP Version 5.2.1 or newer is required to run Beehive Forum. Please upgrade your PHP installation.</td>\n";
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

/**
* install_get_webtags
*
* Get an array of webtags from the FORUMS
* table of the current Beehive installation.
*
* @param void
* @return mixed
*/
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

/**
* install_format_table_prefix
*
* Format the database name and webtag into a table prefix.
*
* @param mixed $database_name
* @param mixed $webtag
* @return string
*/
function install_format_table_prefix($database_name, $webtag)
{
    return sprintf('%s`.`%s_', $database_name, $webtag);
}

/**
* install_prefix_webtag
*
* Prefix the specified table name with the webtag provided.
* Used by array_walk as a callback in install_check_table_conflicts.
*
* Note: $table_name is passed by-reference and is modified directly.
*
* @param string $table_name
* @param mixed $key
* @param mixed $webtag
* @return voud.
*/
function install_prefix_webtag(&$table_name, $key, $webtag)
{
    $table_name = sprintf('%s_%s', $webtag, $table_name);
}

/**
* install_table_exists
*
* Check that the specified table exists.
*
* @param mixed $database_name
* @param string $table_name
* @return bool
*/
function install_table_exists($database_name, $table_name)
{
    if (!$db_install_table_exists = db_connect()) return false;

    $table_name = db_escape_string($table_name);

    $sql = "SHOW TABLES FROM `$database_name` LIKE '$table_name'";

    if (!$result = db_query($sql, $db_install_table_exists)) return false;

    return (db_num_rows($result) > 0);
}

/**
* install_column_exists
*
* Check that the specified column exists.
*
* @param mixed $database_name
* @param mixed $table_name
* @param string $column_name
* @return bool
*/
function install_column_exists($database_name, $table_name, $column_name)
{
    if (!$db_install_column_exists = db_connect()) return false;

    $column_name = db_escape_string($column_name);

    $sql = "SHOW COLUMNS FROM `$database_name`.`$table_name` LIKE '$column_name'";

    if (!$result = db_query($sql, $db_install_column_exists)) return false;

    return (db_num_rows($result) > 0);
}

/**
* install_index_exists
*
* Check that an index of the specified name exists.
* Note that this is the name of the index not the name
* of the column(s) it is attached to.
*
* @param mixed $database_name
* @param mixed $table_name
* @param mixed $column_name
*/
function install_index_exists($database_name, $table_name, $index_name)
{
    if (!$db_install_index_exists = db_connect()) return false;

    $sql = "SHOW INDEXES FROM `$database_name`.`$table_name`";

    if (!$result = db_query($sql, $db_install_index_exists)) return false;

    while (($table_data = db_fetch_array($result))) {
        if ($table_data['Key_name'] == $index_name) return true;
    }

    return false;
}

/**
* install_get_table_names
*
* Get array of table names used globally by
* Beehive and per-forum installation (without
* webtag prefix!)
*
* @param mixed &$global_tables
* @param mixed &$forum_tables
* @return void
*/
function install_get_table_names(&$global_tables, &$forum_tables)
{
    // Static store of global BH table names
    static $global_tables_store = false;

    // Static store of per-forum BH table names.
    static $forum_tables_store = false;

    // Check the global store has been initialised.
    if (!is_array($global_tables_store)) {

        // Initislise the global store.
        $global_tables_store = array('DICTIONARY',          'FORUMS',              'FORUM_SETTINGS',
                                     'GROUPS',              'GROUP_PERMS',         'GROUP_USERS',
                                     'PM',                  'PM_ATTACHMENT_IDS',   'PM_CONTENT',
                                     'PM_FOLDERS',          'PM_SEARCH_RESULTS',   'POST_ATTACHMENT_FILES',
                                     'POST_ATTACHMENT_IDS', 'SEARCH_ENGINE_BOTS',  'SEARCH_RESULTS',
                                     'SESSIONS',            'TIMEZONES',           'USER',
                                     'USER_FORUM',          'USER_HISTORY',        'USER_PREFS',
                                     'VISITOR_LOG');
    }

    // Check the per-forum store has been initialised.
    if (!is_array($forum_tables_store)) {

        // Initialise the store.
        $forum_tables_store = array('ADMIN_LOG',     'BANNED',          'FOLDER',
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

    // Set the by-ref var to the global tables store.
    $global_tables = $global_tables_store;

    // Set the by-ref variable to the per-forum tables store.
    $forum_tables = $forum_tables_store;
}

/**
* install_check_table_conflicts
*
* Check the specified database for conflicting
* table names used by Beehive that might stop
* the installer from completing successfully.
*
* @param mixed $database_name
* @param mixed $webtag
* @param mixed $check_forum_tables
* @param mixed $check_global_tables
* @param mixed $remove_conflicts
* @return mixed
*/
function install_check_table_conflicts($database_name, $webtag, $check_forum_tables, $check_global_tables, $remove_conflicts)
{
    // Database connection.
    if (!($db_install_check_table_conflicts = db_connect())) return false;

    // SQL to get a list of existing tables in the database.
    $sql = "SHOW TABLES FROM `$database_name`";

    // Execute query.
    if (!$result = db_query($sql, $db_install_check_table_conflicts)) return false;

    // Check there are some existing tables in the database.
    if (db_num_rows($result) < 1) return false;

    // Get the existing tables as an array.
    while (($table_data = db_fetch_array($result, DB_RESULT_NUM))) {
        $existing_tables[] = $table_data[0];
    }

    // Get arrays of global and forum tables.
    install_get_table_names($global_tables, $forum_tables);

    // Prefix the forum tables with the webtag
    array_walk($forum_tables, 'install_prefix_webtag', $webtag);

    // Construct the final array we'll use to check.
    $check_tables_array = array_merge($check_global_tables ? $global_tables : array(), $check_forum_tables ? $forum_tables : array());

    // array_intersect can find our duplicates.
    $conflicting_tables_array = array_intersect($existing_tables, $check_tables_array);

    // Check if we should remove conflicts automatically.
    if (($remove_conflicts === true) && (sizeof($conflicting_tables_array) > 0)) {

        $sql = sprintf('DROP TABLE IF EXISTS `%s`', implode('`, `', array_map('db_escape_string', $conflicting_tables_array)));
        db_query($sql, $db_install_check_table_conflicts);
    }

    // Return either the conflicting table names or false.
    return sizeof($conflicting_tables_array) > 0 ? $conflicting_tables_array : false;
}

/**
* install_remove_table
*
* Remove a table from the specified database if
* it exists.
*
* @param mixed $database_name
* @param mixed $table_name
* @return bool
*/
function install_remove_table($database_name, $table_name)
{
    if (!$db_install_remove_table = db_connect()) return false;

    $sql = "DROP TABLE IF EXISTS `$database_name`.`$table_name`";

    if (!db_query($sql, $db_install_remove_table)) return false;

    return true;
}

/**
* install_remove_indexes
*
* Remove all the defined indexes on the specified table.
* Use with caution, this can take a considerable time
* to execute.
*
* @param mixed $database_name
* @param string $table_name
* @return bool
*/
function install_remove_indexes($database_name, $table_name)
{
    if (!$db_install_remove_indexes = db_connect()) return false;

    $table_name = db_escape_string($table_name);

    $sql = "SHOW INDEX FROM `$database_name`.`$table_name`";

    $index_names_array = array();

    if (!($result = db_query($sql, $db_install_remove_indexes))) return false;

    while (($index_data = db_fetch_array($result))) {
        $index_names_array[] = $index_data['Key_name'];
    }

    $index_names_array = array_unique($index_names_array);

    foreach ($index_names_array as $index_name) {

        if (preg_match('/^PRIMARY$/', mb_strtoupper($index_name)) > 0) continue;

        $sql = "ALTER TABLE `$database_name`.`$table_name` DROP INDEX `$index_name`";

        db_query($sql, $db_install_remove_indexes);
    }

    return true;
}

/**
* install_msie_buffer_fix
*
* Output something to the output buffer to
* prevent MSIE from timing out the connection
*
* @param void
* @return void
*/
function install_msie_buffer_fix()
{
    if (browser_check(BROWSER_MSIE)) {
        echo str_repeat("<!-- bh_install_buffer //-->\n", 20);
    }
}

?>