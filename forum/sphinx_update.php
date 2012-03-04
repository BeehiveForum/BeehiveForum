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

// Check we're running from php-cli
if (!defined('STDIN')) {

    header("Request-URI: index.php");
    header("Content-Location: index.php");
    header("Location: index.php");
    exit;
}

// Set the default timezone
date_default_timezone_set('UTC');

// Prevent script from timing out.
set_time_limit(0);

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings
$forum_settings = forum_get_settings();

// Fetch Global Forum Settings
$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "sphinx.inc.php");

$table_data_array = get_all_table_prefixes();

$script_version_text = sprintf("Beehive Forum %s Sphinx Search Integration", BEEHIVE_VERSION);

echo "\r\n", $script_version_text, "\r\n", str_repeat('=', strlen($script_version_text)), "\r\n\r\n";

if (!($sphinx_connection = sphinx_search_connect()) || !($sphinx_search_index = sphinx_search_index())) {

    echo "ERROR: Could not connect to Sphinx Search server. Please check the\r\n";
    echo "       Sphinx Search server settings in your Beehive Forum's Default\r\n";
    echo "       Forum Settings are correct.\r\n\r\n";
    exit(1);
}

try {

    db_query("SELECT * FROM $sphinx_search_index", $sphinx_connection);

} catch (Exception $e) {

    echo "ERROR: Could not query sphinx index with name: '", $sphinx_search_index, "'\r\n";
    echo "       Please check the Sphinx Search server settings in your\r\n";
    echo "       Beehive Forum's Default Forum Settings are correct.\r\n\r\n";
    exit(1);
}

if (!($db_sphinx_index = db_connect())) {

    echo "ERROR: Could not connect to MySQL server. Check your Beehive Forum\r\n";
    echo "       configuration. If you haven't yet installed Beehive Forum please\r\n";
    echo "       use the installer before running this script.\r\n\r\n";
    exit(1);
}

foreach ($table_data_array as $table_data) {

    echo "Please wait, fetching posts for forum '", $table_data['WEBTAG'], "' ...\r\n";

    try {

        $sql = "SELECT POST.SEARCH_ID, COALESCE(THREAD.TITLE, '') AS TITLE, ";
        $sql.= "COALESCE(POST_CONTENT.CONTENT, '') AS CONTENT, COALESCE(THREAD.FID, 0) AS FID, ";
        $sql.= "COALESCE(THREAD.TID, 0) AS TID, COALESCE(POST.PID, 0) AS PID, ";
        $sql.= "COALESCE(THREAD.BY_UID, 0) AS BY_UID, COALESCE(POST.FROM_UID, 0) AS FROM_UID, ";
        $sql.= "COALESCE(POST.TO_UID, 0) AS TO_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED ";
        $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POST_CONTENT` POST_CONTENT ";
        $sql.= "ON (POST_CONTENT.TID = POST.TID AND POST_CONTENT.PID = POST.PID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
        $sql.= "WHERE POST.SEARCH_ID IS NOT NULL";

        $result = db_query($sql, $db_sphinx_index);

    } catch (Exception $e) {

        echo "ERROR: Could not execute SQL query to fetch post data for your\r\n";
        echo "       Beehive Forum using the webtag: '", $table_data['WEBTAG'], "'\r\n";
        echo "       Please check that your Beehive Forum is installed correctly.\r\n\r\n";
        exit(1);
    }

    if (($total_post_count = db_num_rows($result)) == 0) continue;

    echo "Indexing ", number_format($total_post_count, 0, '.', ','), " posts on forum '", $table_data['WEBTAG'], "' ...\r\n";

    $post_count = 0;

    while (($search_index_data = db_fetch_array($result))) {

        try {

            $title = db_escape_string($search_index_data['TITLE']);

            $content = db_escape_string($search_index_data['CONTENT']);

            $sql = "REPLACE INTO $sphinx_search_index (id, title, content, forum, fid, tid, pid, by_uid, from_uid, to_uid, created) ";
            $sql.= "VALUES ({$search_index_data['SEARCH_ID']}, '$title', '$content', {$table_data['FID']}, {$search_index_data['FID']}, ";
            $sql.= "{$search_index_data['TID']}, {$search_index_data['PID']}, {$search_index_data['BY_UID']}, ";
            $sql.= "{$search_index_data['FROM_UID']}, {$search_index_data['TO_UID']}, {$search_index_data['CREATED']})";

            db_query($sql, $sphinx_connection);

        } catch (Exception $e) {

            echo "ERROR: Could not execute SQL query to insert post data into Sphinx\r\n";
            echo "       server. Please check both your Beehive Forum and Sphinx Search\r\n";
            echo "       server are installed correctly.\r\n\r\n";
            exit(1);
        }
    }

    db_ping($sphinx_connection);

    db_ping($db_sphinx_index);
}

echo "Done.\r\n\r\n";

exit(0);

?>