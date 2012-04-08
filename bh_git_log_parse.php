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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./forum/include/");

// Mimic Lite Mode
define("BEEHIVEMODE_LIGHT", true);

// Beehive Config
include_once(BH_INCLUDE_PATH. "config.inc.php");

// Development configuration
if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

// Constants
include_once(BH_INCLUDE_PATH. "constants.inc.php");

// Database functions.
include_once(BH_INCLUDE_PATH. "db.inc.php");

/**
* get_git_log_data
*
* Fetches the GIT Log data. The main workhorse of this script.
*
* @return mixed - False on failure, GIT LOG as string on success.
* @param mixed $date - Date to limit the GIT LOG command by.
*/
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

/**
* git_mysql_prepare_table
*
* Prepares a MySQL table for logging data from GIT LOG command.
* If the table doesn't exist it creates a new one, if it already
* exists it is emptied.
*
* @return bool
* @param string $log_file - Path and filename of git log output.
*/
function git_mysql_prepare_table($truncate_table = true)
{
    if (!$db_git_mysql_prepare_table = db_connect()) return false;

    $sql = "CREATE TABLE IF NOT EXISTS BEEHIVE_GIT_LOG (";
    $sql.= "  LOG_ID MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,";
    $sql.= "  DATE DATETIME NOT NULL,";
    $sql.= "  AUTHOR VARCHAR( 255 ) NOT NULL,";
    $sql.= "  COMMENTS TEXT NOT NULL";
    $sql.= ") ENGINE=MYISAM";

    if (!db_query($sql, $db_git_mysql_prepare_table)) return false;

    if ($truncate_table == true) {

        $sql = "TRUNCATE TABLE BEEHIVE_GIT_LOG";
        if (!db_query($sql, $db_git_mysql_prepare_table)) return false;
    }

    return true;
}

/**
* git_mysql_parse
*
* Parses the output of git log command that has been outputted to a file
* into a MySQL database table comprising DATE, AUTHOR, COMMENTS columns.
*
* @return bool
* @param string $log_file - Path and filename of git log output.
*/
function git_mysql_parse($git_log_temp_file)
{
    if (!$db_git_log_parse = db_connect()) return false;

    $git_log_xml_data = simplexml_load_file($git_log_temp_file, NULL, LIBXML_NOCDATA);
    
    foreach ($git_log_xml_data as $git_log_xml) {
        
        if ((strlen(trim((string)$git_log_xml->msg)) > 0)) {
            
            $git_log_message = preg_replace("/(\r|\r\n|\n)/", "\r\n", trim((string)$git_log_xml->msg));

            $sql = sprintf(
                "INSERT INTO BEEHIVE_GIT_LOG (DATE, AUTHOR, COMMENTS)
                 VALUES (FROM_UNIXTIME('%s'), '%s', '%s')", 
                db_escape_string(strtotime((string)$git_log_xml->date)),
                db_escape_string(trim((string)$git_log_xml->author)),
                db_escape_string($git_log_message)
            );

            if (!$result = db_query($sql, $db_git_log_parse)) return false;
        }
    }

    return true;
}

/**
* git_mysql_output_log
*
* Output the GIT log data saved in the MySQL database
* to the specified filename.
*
* @param mixed $log_filename
* @return mixed
*/
function git_mysql_output_log($log_filename = null)
{
    if (!$db_git_mysql_output_log = db_connect()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DATE) AS DATE, AUTHOR, COMMENTS ";
    $sql.= "FROM BEEHIVE_GIT_LOG GROUP BY DATE ORDER BY DATE DESC";

    if (!$result = db_query($sql, $db_git_mysql_output_log)) return false;

    if (db_num_rows($result) > 0) {

        $git_log_entry_author = '';
        $git_log_entry_date = '';

        ob_start();

        printf("Project Beehive Forum Change Log (Generated: %s)\r\n\r\n", gmdate('D, d M Y H:i:s'));
        
        while (($git_log_entry_array = db_fetch_array($result, DB_RESULT_ASSOC))) {
            
            if ($git_log_entry_author != $git_log_entry_array['AUTHOR']) {

                $git_log_entry_author = $git_log_entry_array['AUTHOR'];
                printf("Author: %s\r\n", $git_log_entry_author);

                if ($git_log_entry_date != $git_log_entry_array['DATE']) {

                    $git_log_entry_date = $git_log_entry_array['DATE'];
                    printf("Date: %s\r\n", gmdate('D, d M Y H:i:s', $git_log_entry_date));
                }

                echo "-----------------------\r\n";

            } else if ($git_log_entry_date != $git_log_entry_array['DATE']) {

                $git_log_entry_date = $git_log_entry_array['DATE'];
                printf("Date: %s\r\n-----------------------\r\n", gmdate('D, d M Y H:i:s', $git_log_entry_date));
            }
            
            if (preg_match_all('/^(Fixed:|Changed:|Added:)\s*(.+)/im', $git_log_entry_array['COMMENTS'], $git_log_entry_matches_array, PREG_SET_ORDER) > 0) {

                foreach ($git_log_entry_matches_array as $git_log_entry_matches) {
                
                    $git_log_comment = trim(preg_replace("/(\r|\r\n|\n)/", '', $git_log_entry_matches[2]));

                    $git_log_comment_array = explode("\r\n", wordwrap($git_log_comment, 91, "\r\n"));

                    foreach ($git_log_comment_array as $line => $git_log_comment_line) {

                        echo $line == 0 ? str_pad($git_log_entry_matches[1], 9, ' ', STR_PAD_RIGHT) : str_repeat(' ', 9);
                        echo $git_log_comment_line, "\r\n";
                    }
                }

                echo "\r\n";
            }
        }

        if (isset($log_filename)) {
            file_put_contents($log_filename, ob_get_clean());
        }

    }else {

        echo "Table BEEHIVE_GIT_LOG is empty. No Changelog generated.\r\n";
    }

    return true;
}

// Prevent time out
set_time_limit(0);

// Output the content as text.
header('Content-Type: text/plain');

// Check to see if we have a date on the command line and
// that it is in the valid format YYYY-MM-DD.
if (isset($_SERVER['argv'][1]) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u', $_SERVER['argv'][1]) > 0) {
    $modified_date = $_SERVER['argv'][1];
} else if (isset($_GET['date']) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u', $_GET['date']) > 0) {
    $modified_date = $_GET['date'];
}

if (isset($modified_date)) {

    if (git_mysql_prepare_table()) {

        if (!isset($_GET['output'])) echo "Fetching GIT Log Data...\r\n";

        if (($git_log_temp_file = get_git_log_data($modified_date))) {

            if (!isset($_GET['output'])) echo "Parsing GIT Log Data...\r\n";

            if (!git_mysql_parse($git_log_temp_file)) {

                echo "Error while fetching or parsing GIT log contents\r\n";
                exit;
            }

        }else {

            echo "Error while fetching GIT log\r\n";
            exit;
        }

        if (isset($_SERVER['argv'][2]) && strlen(trim($_SERVER['argv'][2])) > 0) {

            $output_log_filename = trim($_SERVER['argv'][2]);
            echo "Generating Change Log. Saving to $output_log_filename\r\n";
            git_mysql_output_log($output_log_filename);

        } else if (isset($_GET['output'])) {

            git_mysql_output_log();
        }

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else if (isset($_SERVER['argv'][1]) && strlen(trim($_SERVER['argv'][1])) > 0) {

    $output_log_filename = trim($_SERVER['argv'][1]);

    if (git_mysql_prepare_table(false)) {

        echo "Generating Change Log. Saving to $output_log_filename\r\n";
        git_mysql_output_log($output_log_filename);

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else if (isset($_GET['output'])) {

    if (git_mysql_prepare_table(false)) {

        git_mysql_output_log();

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else {

    echo "Generate changelog.txt from GIT comments\r\n\r\n";
    echo "Usage: php-bin bh_git_log_parse.php [YYYY-MM-DD] [FILE]\r\n";
    echo "   OR: bh_git_log_parse.php?date=YYYY-MM-DD[&output]\r\n\r\n";
    echo "Examples:\r\n";
    echo "  php-bin bh_git_log_parse.php 2007-01-01\r\n";
    echo "  php-bin bh_git_log_parse.php 2007-01-01 changelog.txt\r\n";
    echo "  php-bin bh_git_log_parse.php changelog.txt\r\n\r\n";
    echo "[FILE] specifies the output filename for the changelog.\r\n";
    echo "       Only available when run from a shell.\r\n\r\n";
    echo "[YYYY-MM-DD] specifies the date the changelog should start from\r\n\r\n";
    echo "Both arguments can be combined or used separatly to achieve\r\n";
    echo "different results.\r\n\r\n";
    echo "Specifying the date on it's own will save the results from the\r\n";
    echo "GIT comments to a MySQL database named BEEHIVE_GIT_LOG using the\r\n";
    echo "connection details from your Beehive Forum config.inc.php\r\n\r\n";
    echo "Specifying only the output filename will take any saved results\r\n";
    echo "in the BEEHIVE_GIT_LOG table and generate a changelog from them.\r\n\r\n";
    echo "Using them together will both save the results to the BEEHIVE_GIT_LOG\r\n";
    echo "table and generate the specified changelog.\r\n\r\n";
    echo "Subsequent runs using the date argument will truncate the database\r\n";
    echo "table before generating the changelog.\r\n";
}

?>