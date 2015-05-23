<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Include path
define('BH_INCLUDE_PATH', __DIR__ . '/forum/include/');

// Bootstrap
require_once 'forum/boot.php';

function get_git_log_data($date)
{
    $temp_file = tempnam(sys_get_temp_dir(), 'beehive_change_log');

    file_put_contents($temp_file, "<log>\n");

    exec(sprintf(
        'git log --pretty=format:"<entry>%%n<author><![CDATA[%%an]]></author>%%n<date><![CDATA[%%ad]]></date>%%n<msg><![CDATA[%%B]]></msg>%%n</entry>%%n" --since=%s --until=%s >> %s',
        escapeshellarg($date),
        escapeshellarg(date('Y-m-d', time() + 86400)),
        escapeshellarg($temp_file)
    ));

    file_put_contents($temp_file, "</log>\n", FILE_APPEND);

    return $temp_file;
}

function git_mysql_prepare_table($truncate_table = true)
{
    if (!$db = db::get()) return false;

    $sql = "CREATE TABLE IF NOT EXISTS BEEHIVE_GIT_LOG (";
    $sql .= "  LOG_ID MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,";
    $sql .= "  DATE DATE NOT NULL,";
    $sql .= "  AUTHOR VARCHAR( 255 ) NOT NULL,";
    $sql .= "  COMMENTS TEXT NOT NULL";
    $sql .= ") ENGINE=MYISAM";

    if (!$db->query($sql)) return false;

    if ($truncate_table == true) {

        $sql = "TRUNCATE TABLE BEEHIVE_GIT_LOG";
        if (!$db->query($sql)) return false;
    }

    return true;
}

function git_mysql_parse($git_log_temp_file)
{
    if (!$db = db::get()) return false;

    $git_log_xml_data = simplexml_load_file($git_log_temp_file, NULL, LIBXML_NOCDATA);

    foreach ($git_log_xml_data as $git_log_xml) {

        if ((strlen(trim((string)$git_log_xml->msg)) > 0)) {

            $git_log_message = preg_replace("/(\r|\r\n|\n)/", "\n", trim((string)$git_log_xml->msg));

            $sql = sprintf(
                "INSERT INTO BEEHIVE_GIT_LOG (DATE, AUTHOR, COMMENTS)
                 VALUES (DATE(FROM_UNIXTIME('%s')), '%s', '%s')",
                $db->escape(strtotime((string)$git_log_xml->date)),
                $db->escape(trim((string)$git_log_xml->author)),
                $db->escape($git_log_message)
            );

            if (!$result = $db->query($sql)) return false;
        }
    }

    return true;
}

function git_mysql_output_log($log_filename = null)
{
    if (!$db = db::get()) return;

    $sql = "SELECT UNIX_TIMESTAMP(DATE) AS DATE, AUTHOR, COMMENTS ";
    $sql .= "FROM BEEHIVE_GIT_LOG ORDER BY DATE DESC";

    if (!$result = $db->query($sql)) return;

    if ($result->num_rows == 0) {

        echo "Table BEEHIVE_GIT_LOG is empty. No Changelog generated.\n";
        exit;
    }

    $git_log_comments_array = array();

    while (($git_log_entry_array = $result->fetch_assoc()) !== null) {

        if (preg_match_all('/^((Fixed|Changed|Added):)\s*(.+)/im', $git_log_entry_array['COMMENTS'], $git_log_entry_matches_array, PREG_SET_ORDER) > 0) {

            foreach ($git_log_entry_matches_array as $git_log_entry_matches) {

                $git_log_comment = trim(preg_replace("/(\r|\r\n|\n)/", '', $git_log_entry_matches[3]));

                $git_log_comment = str_replace('_', '\_', htmlentities($git_log_comment));

                $git_log_comment_array = explode("\n", wordwrap($git_log_comment, (70 - (strlen($git_log_entry_matches[2]) + 4)), "\n"));

                foreach ($git_log_comment_array as $line => $git_log_comment_line) {

                    if ($line == 0) {

                        $git_log_comments_array[$git_log_entry_array['DATE']][] = sprintf(
                            "- %s: %s",
                            $git_log_entry_matches[2],
                            $git_log_comment_line
                        );

                    } else {

                        $git_log_comments_array[$git_log_entry_array['DATE']][] = sprintf(
                            "%s %s",
                            str_repeat(
                                ' ',
                                strlen($git_log_entry_matches[2]) + 3
                            ),
                            $git_log_comment_line
                        );
                    }
                }
            }
        }
    }

    ob_start();

    printf(
        "# Beehive Forum Change Log (Generated: %s)\n\n",
        gmdate('D, d M Y H:i:s')
    );

    foreach ($git_log_comments_array as $git_log_entry_date => $git_log_comments) {

        printf(
            "## Date: %s\n\n",
            gmdate('D, d M Y', $git_log_entry_date)
        );

        printf(
            "%s\n\n",
            implode("\n", $git_log_comments)
        );
    }

    if (isset($log_filename)) {

        file_put_contents($log_filename, ob_get_clean());
        exit;
    }

    echo ob_get_clean();
}

set_time_limit(0);

header('Content-Type: text/plain');

if (isset($_SERVER['argv'][1]) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u', $_SERVER['argv'][1]) > 0) {
    $modified_date = $_SERVER['argv'][1];
} else if (isset($_GET['date']) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u', $_GET['date']) > 0) {
    $modified_date = $_GET['date'];
}

if (isset($modified_date)) {

    if (git_mysql_prepare_table()) {

        if (!isset($_GET['output'])) echo "Fetching GIT Log Data...\n";

        if (($git_log_temp_file = get_git_log_data($modified_date)) !== false) {

            if (!isset($_GET['output'])) echo "Parsing GIT Log Data...\n";

            if (!git_mysql_parse($git_log_temp_file)) {

                echo "Error while fetching or parsing GIT log contents\n";
                exit;
            }

        } else {

            echo "Error while fetching GIT log\n";
            exit;
        }

        if (isset($_SERVER['argv'][2]) && strlen(trim($_SERVER['argv'][2])) > 0) {

            $output_log_filename = trim($_SERVER['argv'][2]);
            echo "Generating Change Log. Saving to $output_log_filename\n";
            git_mysql_output_log($output_log_filename);

        } else if (isset($_GET['output'])) {

            git_mysql_output_log();
        }

    } else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

} else if (isset($_SERVER['argv'][1]) && strlen(trim($_SERVER['argv'][1])) > 0) {

    $output_log_filename = trim($_SERVER['argv'][1]);

    if (git_mysql_prepare_table(false)) {

        echo "Generating Change Log. Saving to $output_log_filename\n";
        git_mysql_output_log($output_log_filename);

    } else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

} else if (isset($_GET['output'])) {

    if (git_mysql_prepare_table(false)) {

        git_mysql_output_log();

    } else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

} else {

    echo "Generate changelog.md Markdown from GIT comments\n\n";
    echo "Usage: php-bin bh_git_log_parse.php [YYYY-MM-DD] [FILE]\n";
    echo "   OR: bh_git_log_parse.php?date=YYYY-MM-DD[&output]\n\n";
    echo "Examples:\n";
    echo "  php-bin bh_git_log_parse.php 2007-01-01\n";
    echo "  php-bin bh_git_log_parse.php 2007-01-01 changelog.md\n";
    echo "  php-bin bh_git_log_parse.php changelog.md\n\n";
    echo "[FILE] specifies the output filename for the changelog.md\n";
    echo "       Only available when run from a shell.\n\n";
    echo "[YYYY-MM-DD] specifies the date the changelog should start from\n\n";
    echo "Both arguments can be combined or used separatly to achieve\n";
    echo "different results.\n\n";
    echo "Specifying the date on it's own will save the results from the\n";
    echo "GIT comments to a MySQL database named BEEHIVE_GIT_LOG using the\n";
    echo "connection details from your Beehive Forum config.inc.php\n\n";
    echo "Specifying only the output filename will take any saved results\n";
    echo "in the BEEHIVE_GIT_LOG table and generate a changelog from them.\n\n";
    echo "Using them together will both save the results to the BEEHIVE_GIT_LOG\n";
    echo "table and generate the specified changelog.\n\n";
    echo "Subsequent runs using the date argument will truncate the database\n";
    echo "table before generating the changelog.\n";
}