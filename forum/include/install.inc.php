<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Required includes
require_once BH_INCLUDE_PATH . 'browser.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
// End Required includes

function install_check()
{
    if (!file_exists(BH_INCLUDE_PATH . "config.inc.php")) {
        header_redirect('./install/index.php');
    }

    install_check_php_version();

    install_check_php_extensions();

    install_check_php_configuration();

    install_check_mysql_version();

    if (@file_exists('./install/index.php') && !defined("BEEHIVE_DEVELOPER_MODE")) {

        install_draw_top();

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

        install_draw_bottom();
        exit;
    }
}

function install_check_mysql_version()
{
    $mysql_version = db::get_version();

    if ($mysql_version === false || version_compare($mysql_version, BEEHIVE_MYSQL_MIN_VERSION, "<")) {

        install_draw_top();

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
        echo "                        <td align=\"left\">MySQL Server Version ", BEEHIVE_MYSQL_MIN_VERSION, " or newer is required to run Beehive Forum. Please upgrade your MySQL installtion.</td>\n";
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

        install_draw_bottom();
        exit;
    }
}

function install_check_php_extensions()
{
    $loaded_extensions = get_loaded_extensions();

    $required_extensions = explode(',', BEEHIVE_PHP_REQUIRED_EXT);

    $missing_extensions = array_diff($required_extensions, $loaded_extensions);

    if (sizeof($missing_extensions) > 0) {

        foreach ($required_extensions as $key => $extension_name) {
            $required_extensions[$key] = sprintf('<a href="http://www.php.net/%1$s">%1$s</a>', $extension_name);
        }

        foreach ($missing_extensions as $key => $extension_name) {
            $missing_extensions[$key] = sprintf('<a href="http://www.php.net/%1$s">%1$s</a>', $extension_name);
        }

        install_draw_top();

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
        echo "                              <td align=\"left\">", implode(', ', $required_extensions), "</td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\"><b>Missing Extensions:</b></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\">\n";
        echo "                          <table class=\"posthead\" width=\"95%\">\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\">", implode(', ', $missing_extensions), "</td>\n";
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

        install_draw_bottom();
        exit;
    }
}

function install_check_php_version()
{
    if (version_compare(phpversion(), BEEHIVE_PHP_MIN_VERSION, "<")) {

        install_draw_top();

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
        echo "                        <td align=\"left\">PHP Version ", BEEHIVE_PHP_MIN_VERSION, " or newer is required to run Beehive Forum. Please upgrade your PHP installation.</td>\n";
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

        install_draw_bottom();
        exit;
    }
}

function install_check_php_configuration()
{
    if (ini_get('magic_quotes_gpc')) {

        install_draw_top();

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"500\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">PHP magic_quotes_gpc detected</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">PHP magic_quotes_gpc is deprecated and should be disabled.</td>\n";
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

        install_draw_bottom();
        exit;
    }
}

function install_get_table_data()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT FID, CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX, ";
    $sql .= "DATABASE_NAME, WEBTAG FROM FORUMS";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $forum_table_data_array = array();

    while (($forum_webtags_data = $result->fetch_assoc()) !== null) {
        $forum_table_data_array[$forum_webtags_data['FID']] = $forum_webtags_data;
    }

    return $forum_table_data_array;
}

function install_format_table_prefix($database_name, $webtag)
{
    return sprintf('%s`.`%s_', $database_name, $webtag);
}

function install_prefix_webtag($table_name, $webtag)
{
    return sprintf('%s_%s', $webtag, $table_name);
}

function install_table_exists($database_name, $table_name)
{
    if (!$db = db::get()) return false;

    $table_name = $db->escape($table_name);

    $sql = "SHOW TABLES FROM `$database_name` LIKE '$table_name'";

    if (!($result = $db->query($sql))) return false;

    return ($result->num_rows > 0);
}

function install_column_exists($database_name, $table_name, $column_name)
{
    if (!$db = db::get()) return false;

    $column_name = $db->escape($column_name);

    $sql = "SHOW COLUMNS FROM `$database_name`.`$table_name` LIKE '$column_name'";

    if (!($result = $db->query($sql))) return false;

    return ($result->num_rows > 0);
}

function install_index_exists($database_name, $table_name, $index_name)
{
    if (!$db = db::get()) return false;

    $sql = "SHOW INDEXES FROM `$database_name`.`$table_name`";

    if (!($result = $db->query($sql))) return false;

    while (($table_data = $result->fetch_assoc()) !== null) {
        if ($table_data['Key_name'] == $index_name) return true;
    }

    return false;
}

function install_check_column_type($database_name, $table_name, $column_name, $column_type)
{
    if (!$db = db::get()) return false;

    $column_name = $db->escape($column_name);

    $sql = "SHOW COLUMNS FROM `$database_name`.`$table_name` LIKE '$column_name'";

    if (!($result = $db->query($sql))) return false;

    if (!$column_data = $result->fetch_assoc()) return false;

    return ($column_data['Type'] == $column_type);
}

function install_get_table_names(&$global_tables, &$forum_tables)
{
    static $global_tables_store = false;

    static $forum_tables_store = false;

    if (!is_array($global_tables_store)) {

        $global_tables_store = array(
            'FORUMS',
            'FORUM_SETTINGS',
            'GROUPS',
            'GROUP_PERMS',
            'GROUP_USERS',
            'PM',
            'PM_ATTACHMENT_IDS',
            'PM_CONTENT',
            'PM_FOLDERS',
            'PM_SEARCH_RESULTS',
            'POST_ATTACHMENT_FILES',
            'POST_ATTACHMENT_IDS',
            'SEARCH_ENGINE_BOTS',
            'SEARCH_RESULTS',
            'SESSIONS',
            'TIMEZONES',
            'USER',
            'USER_FORUM',
            'USER_HISTORY',
            'USER_PERM',
            'USER_PREFS',
            'VISITOR_LOG'
        );
    }

    if (!is_array($forum_tables_store)) {

        $forum_tables_store = array(
            'ADMIN_LOG',
            'BANNED',
            'FOLDER',
            'FORUM_LINKS',
            'LINKS',
            'LINKS_COMMENT',
            'LINKS_FOLDERS',
            'LINKS_VOTE',
            'POLL',
            'POLL_VOTES',
            'POST',
            'POST_CONTENT',
            'POST_SEARCH_ID',
            'PROFILE_ITEM',
            'PROFILE_SECTION',
            'RSS_FEEDS',
            'RSS_HISTORY',
            'STATS',
            'THREAD',
            'THREAD_STATS',
            'THREAD_TRACK',
            'USER_FOLDER',
            'USER_PEER',
            'USER_POLL_VOTES',
            'USER_PREFS',
            'USER_PROFILE',
            'USER_SIG',
            'USER_THREAD',
            'USER_TRACK',
            'WORD_FILTER'
        );
    }

    $global_tables = $global_tables_store;

    $forum_tables = $forum_tables_store;
}

function install_check_table_conflicts($database_name, $webtag, $check_forum_tables, $check_global_tables, $remove_conflicts)
{
    if (!($db = db::get())) return false;

    $sql = "SHOW TABLES FROM `$database_name`";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows < 1) return false;

    $existing_tables = array();

    while (($table_data = $result->fetch_row()) !== null) {
        $existing_tables[] = $table_data[0];
    }

    install_get_table_names($global_tables, $forum_tables);

    foreach ($forum_tables as $key => $forum_table) {
        $forum_tables[$key] = install_prefix_webtag($forum_table, $webtag);
    }

    $check_tables_array = array_merge($check_global_tables ? $global_tables : array(), $check_forum_tables ? $forum_tables : array());

    $conflicting_tables_array = array_intersect($existing_tables, $check_tables_array);

    if (($remove_conflicts === true) && (sizeof($conflicting_tables_array) > 0)) {

        $sql = sprintf('DROP TABLE IF EXISTS `%s`', implode('`, `', array_map(array($db, 'escape'), $conflicting_tables_array)));
        $db->query($sql);
    }

    return sizeof($conflicting_tables_array) > 0 ? $conflicting_tables_array : false;
}

function install_remove_table($database_name, $table_name)
{
    if (!$db = db::get()) return false;

    $sql = "DROP TABLE IF EXISTS `$database_name`.`$table_name`";

    if (!$db->query($sql)) return false;

    return true;
}

function install_remove_indexes($database_name, $table_name)
{
    if (!$db = db::get()) return false;

    $table_name = $db->escape($table_name);

    $sql = "SHOW INDEX FROM `$database_name`.`$table_name`";

    $index_names_array = array();

    if (!($result = $db->query($sql))) return false;

    while (($index_data = $result->fetch_assoc()) !== null) {
        $index_names_array[] = $index_data['Key_name'];
    }

    $index_names_array = array_unique($index_names_array);

    foreach ($index_names_array as $index_name) {

        if (preg_match('/^PRIMARY$/', mb_strtoupper($index_name)) > 0) continue;

        $sql = "ALTER TABLE `$database_name`.`$table_name` DROP INDEX `$index_name`";

        $db->query($sql);
    }

    return true;
}

function install_msie_buffer_fix()
{
    if (browser_check(BROWSER_MSIE)) {
        echo str_repeat("<!-- bh_install_buffer //-->\n", 20);
    }
}

function install_set_default_forum_settings()
{
    if (!$db = db::get()) return false;

    $global_settings = array(
        'forum_keywords' => 'A Beehive Forum, Beehive Forum, Project Beehive Forum',
        'forum_desc' => 'A Beehive Forum',
        'forum_email' => 'admin@beehiveforum.co.uk',
        'forum_noreply_email' => 'noreply@beehiveforum.co.uk',
        'forum_name' => 'A Beehive Forum',
        'allow_search_spidering' => 'Y',
        'pm_allow_attachments' => 'Y',
        'pm_auto_prune' => '-60',
        'pm_max_user_messages' => '100',
        'show_pms' => 'Y',
        'new_user_mark_as_of_int' => 'Y',
        'showpopuponnewpm' => 'Y',
        'new_user_pm_notify_email' => 'Y',
        'new_user_email_notify' => 'Y',
        'text_captcha_key' => md5(uniqid(mt_rand())),
        'text_captcha_dir' => 'text_captcha',
        'text_captcha_enabled' => 'N',
        'require_email_confirmation' => 'N',
        'require_unique_email' => 'N',
        'allow_new_registrations' => 'Y',
        'search_min_frequency' => '30',
        'guest_account_enabled' => 'Y',
        'guest_auto_logon' => 'Y',
        'attachments_enabled' => 'N',
        'attachment_dir' => 'attachments',
        'attachments_max_user_space' => '1048576',
        'attachments_max_post_space' => '1048576',
        'attachments_allow_embed' => 'N',
        'message_cache_enabled' => 'N'
    );

    foreach ($global_settings as $sname => $svalue) {

        $sname = $db->escape($sname);
        $svalue = $db->escape($svalue);

        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql .= "VALUES (0, '$sname', '$svalue')";

        $db->query($sql);
    }

    return true;
}

function install_set_search_bots()
{
    if (!$db = db::get()) return false;

    $bots_array = array(
        array(
            'NAME' => 'Alexa',
            'URL' => 'http://www.alexa.com/',
            'AGENT' => 'ia_archiver',
        ),
        array(
            'NAME' => 'Ahrefs',
            'URL' => 'https://ahrefs.com/',
            'AGENT' => 'AhrefsBot',
        ),
        array(
            'NAME' => 'Ask.com',
            'URL' => 'http://www.ask.com/',
            'AGENT' => 'Ask Jeeves/Teoma',
        ),
        array(
            'NAME' => 'Baidu',
            'URL' => 'http://www.baidu.com/',
            'AGENT' => 'Baiduspider',
        ),
        array(
            'NAME' => 'Bing',
            'URL' => 'http://www.bing.com/',
            'AGENT' => 'bingbot',
        ),
        array(
            'NAME' => 'GameSpy',
            'URL' => 'http://www.gamespy.com/',
            'AGENT' => 'GameSpyHTTP',
        ),
        array(
            'NAME' => 'Gigablast',
            'URL' => 'http://www.gigablast.com/',
            'AGENT' => 'Gigabot',
        ),
        array(
            'NAME' => 'Google',
            'URL' => 'http://www.google.com/',
            'AGENT' => 'Googlebot',
        ),
        array(
            'NAME' => 'Google Images',
            'URL' => 'http://images.google.com/',
            'AGENT' => 'Googlebot-Image',
        ),
        array(
            'NAME' => 'Google Adsense',
            'URL' => 'http://www.google.co.uk/adsense',
            'AGENT' => 'Mediapartners-Google',
        ),
        array(
            'NAME' => 'Majestic-12',
            'URL' => 'http://www.majestic12.co.uk/',
            'AGENT' => 'MJ12bot',
        ),
        array(
            'NAME' => 'Bing',
            'URL' => 'http://www.bing.com/',
            'AGENT' => 'msnbot',
        ),
        array(
            'NAME' => 'Altavista',
            'URL' => 'http://www.altavista.com/',
            'AGENT' => 'Scooter',
        ),
        array(
            'NAME' => 'Inktomi',
            'URL' => 'http://searchmarketing.yahoo.com/',
            'AGENT' => 'Slurp/si',
        ),
        array(
            'NAME' => 'Yahoo!',
            'URL' => 'http://www.yahoo.com/',
            'AGENT' => 'Yahoo! Slurp',
        ),
        array(
            'NAME' => 'Yahoo! Images',
            'URL' => 'http://www.yahoo.com/',
            'AGENT' => 'Yahoo-MMCrawler',
        ),
        array(
            'NAME' => 'Yandex',
            'URL' => 'http://www.yahoo.com/',
            'AGENT' => 'YandexBot',
        ),
        array(
            'NAME' => 'Yandex Images',
            'URL' => 'http://www.yahoo.com/',
            'AGENT' => 'YandexImages',
        ),
    );

    foreach ($bots_array as $details) {

        $name = $db->escape($details['NAME']);
        $url = $db->escape($details['URL']);
        $agent = $db->escape($details['AGENT']);

        $sql = "INSERT INTO SEARCH_ENGINE_BOTS (NAME, URL, AGENT_MATCH) ";
        $sql .= "VALUES ('$name', '$url', '%$agent%')";

        $db->query($sql);
    }

    return true;
}

function install_set_timezones()
{
    if (!$db = db::get()) return false;

    $timezones_array = array(
        1 => array(-12, 0),
        2 => array(-11, 0),
        3 => array(-10, 0),
        4 => array(-9, 1),
        5 => array(-8, 1),
        6 => array(-7, 0),
        7 => array(-7, 1),
        8 => array(-7, 1),
        9 => array(-6, 0),
        10 => array(-6, 1),
        11 => array(-6, 1),
        12 => array(-6, 0),
        13 => array(-5, 0),
        14 => array(-5, 1),
        15 => array(-5, 0),
        16 => array(-4, 1),
        17 => array(-4, 0),
        18 => array(-4, 1),
        19 => array(-3.5, 1),
        20 => array(-3, 1),
        21 => array(-3, 0),
        22 => array(-3, 1),
        23 => array(-2, 1),
        24 => array(-1, 1),
        25 => array(-1, 0),
        26 => array(0, 0),
        27 => array(0, 1),
        28 => array(1, 1),
        29 => array(1, 1),
        30 => array(1, 1),
        31 => array(1, 1),
        32 => array(1, 0),
        33 => array(2, 1),
        34 => array(2, 1),
        35 => array(2, 1),
        36 => array(2, 0),
        37 => array(2, 1),
        38 => array(2, 0),
        39 => array(3, 1),
        40 => array(3, 0),
        41 => array(3, 1),
        42 => array(3, 0),
        43 => array(3.5, 1),
        44 => array(4, 0),
        45 => array(4, 1),
        46 => array(4.5, 0),
        47 => array(5, 1),
        48 => array(5, 0),
        49 => array(5.5, 0),
        50 => array(5.75, 0),
        51 => array(6, 1),
        52 => array(6, 0),
        53 => array(6, 0),
        54 => array(6.5, 0),
        55 => array(7, 0),
        56 => array(7, 1),
        57 => array(8, 0),
        58 => array(8, 1),
        59 => array(8, 0),
        60 => array(8, 0),
        61 => array(8, 0),
        62 => array(9, 0),
        63 => array(9, 0),
        64 => array(9, 1),
        65 => array(9.5, 1),
        66 => array(9.5, 0),
        67 => array(10, 0),
        68 => array(10, 1),
        69 => array(10, 0),
        70 => array(10, 1),
        71 => array(10, 1),
        72 => array(11, 0),
        73 => array(12, 1),
        74 => array(12, 0),
        75 => array(13, 0),
    );

    foreach ($timezones_array as $tzid => $tz_data) {

        if (!is_numeric($tzid)) return false;

        if (!isset($tz_data[0]) || !is_numeric($tz_data[0])) return false;
        if (!isset($tz_data[1]) || !is_numeric($tz_data[1])) return false;

        $sql = "INSERT INTO TIMEZONES (TZID, GMT_OFFSET, DST_OFFSET) ";
        $sql .= "VALUES ('$tzid', '{$tz_data[0]}', '{$tz_data[1]}')";

        $db->query($sql);
    }

    return true;
}

function install_draw_top()
{
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-gb\" lang=\"en-gb\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum ", BEEHIVE_VERSION, " Installation</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"../styles/default/images/favicon.ico\" type=\"image/ico\" />\n";
    echo "<link rel=\"stylesheet\" href=\"../styles/default/style.css\" type=\"text/css\" />\n";

    $arg_array = func_get_args();

    foreach ($arg_array as $script_file_path) {
        echo "<script type=\"text/javascript\" src=\"", $script_file_path, "\"></script>\n";
    }

    echo "</head>\n";
    echo "<body>\n";
    echo "<h1>Beehive Forum ", BEEHIVE_VERSION, " Installation</h1>\n";
    echo "<div align=\"center\">\n";
    echo "<br />\n";
}

function install_draw_bottom()
{
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
}
