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

/* $Id: bh_svn_log_parse.php 4368 2010-01-30 20:43:23Z decoyduck $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./forum/include/");

// Mimic Lite Mode
define("BEEHIVEMODE_LIGHT", true);

// Database functions.
include_once(BH_INCLUDE_PATH. "db.inc.php");

/**
* get_svn_log_data
*
* Fetches the SVN Log data. The main workhorse of this script.
*
* @return mixed - False on failure, SVN LOG as string on success.
* @param mixed $date - Date to limit the SVN LOG command by.
* @param string $file - File to get the SVN LOG data for.
*/
function get_svn_log_data($date)
{
    $svn_log_cmd = sprintf("svn log --xml -r {%s}:{%s}", $date, date('Y-m-d'));
    
    if (($log_handle = popen($svn_log_cmd, 'r'))) {

        $log_contents = '';

        while (!feof($log_handle)) {
            $log_contents.= fgets($log_handle);
        }

        pclose($log_handle);
        return $log_contents;
    }

    return false;
}

/**
* svn_mysql_prepare_table
*
* Prepares a MySQL table for logging data from SVN LOG command.
* If the table doesn't exist it creates a new one, if it already
* exists it is emptied.
*
* @return bool
* @param string $log_file - Path and filename of svn log output.
*/
function svn_mysql_prepare_table($truncate_table = true)
{
    if (!$db_svn_mysql_prepare_table = db_connect()) return false;

    $sql = "CREATE TABLE IF NOT EXISTS BEEHIVE_SVN_LOG (";
    $sql.= "  LOG_ID MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,";
    $sql.= "  DATE DATETIME NOT NULL,";
    $sql.= "  AUTHOR VARCHAR( 255 ) NOT NULL,";
    $sql.= "  COMMENTS TEXT NOT NULL";
    $sql.= ") TYPE = MYISAM";

    if (!db_query($sql, $db_svn_mysql_prepare_table)) return false;

    if ($truncate_table == true) {

        $sql = "TRUNCATE TABLE BEEHIVE_SVN_LOG";
        if (!db_query($sql, $db_svn_mysql_prepare_table)) return false;
    }

    return true;
}

/**
* svn_mysql_parse
*
* Parses the output of svn log command that has been outputted to a file
* into a MySQL database table comprising DATE, AUTHOR, COMMENTS columns.
*
* @return bool
* @param string $log_file - Path and filename of svn log output.
*/
function svn_mysql_parse($svn_log_contents)
{
    if (!$db_svn_log_parse = db_connect()) return false;

    $svn_xml_data = new SimpleXMLElement($svn_log_contents);
    
    foreach ($svn_xml_data as $svn_log_xml) {
        
        $svn_log_entry_author = trim((string)$svn_log_xml->author);
        
        $svn_log_entry_date = strtotime((string)$svn_log_xml->date);
        
        $svn_log_entry_comment = trim((string)$svn_log_xml->msg);
        
        if ((strlen($svn_log_entry_comment) > 0) && ($svn_log_entry_comment != '*** empty log message ***')) {

            $sql = sprintf("SELECT LOG_ID FROM BEEHIVE_SVN_LOG WHERE AUTHOR = '%s' AND COMMENTS = '%s'", db_escape_string($svn_log_entry_author), 
                                                                                                         db_escape_string($svn_log_entry_comment));

            if (!$result = db_query($sql, $db_svn_log_parse)) return false;

            if (db_num_rows($result) < 1) {

                $sql = sprintf("INSERT INTO BEEHIVE_SVN_LOG (DATE, AUTHOR, COMMENTS)
                                     VALUES(FROM_UNIXTIME('%s'), '%s', '%s')", db_escape_string($svn_log_entry_date),
                                                                               db_escape_string($svn_log_entry_author),
                                                                               db_escape_string($svn_log_entry_comment));

                if (!$result = db_query($sql, $db_svn_log_parse)) return false;
            }
        }
    }
}

/**
* svn_mysql_output_log
* 
* Output the SVN log data saved in the MySQL database
* to the specified filename.
* 
* @param mixed $log_filename
* @return mixed
*/
function svn_mysql_output_log($log_filename)
{
    if (!$db_svn_mysql_output_log = db_connect()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DATE) AS DATE, AUTHOR, COMMENTS ";
    $sql.= "FROM BEEHIVE_SVN_LOG GROUP BY DATE ORDER BY DATE DESC";

    if (!$result = db_query($sql, $db_svn_mysql_output_log)) return false;

    if (db_num_rows($result) > 0) {

        $svn_log_entry_author = '';
        $svn_log_entry_date = '';

        file_put_contents($log_filename, sprintf("Project Beehive Forum Change Log (Generated: %s)\n\n", gmdate('D, d M Y H:i:s')));

        while (($svn_log_entry_array = db_fetch_array($result, DB_RESULT_ASSOC))) {

            $svn_log_entry = '';

            if ($svn_log_entry_author != $svn_log_entry_array['AUTHOR']) {
                $svn_log_entry_author = $svn_log_entry_array['AUTHOR'];
                $svn_log_entry.= sprintf("Author: %s\n", $svn_log_entry_author);
            }

            if ($svn_log_entry_date != $svn_log_entry_array['DATE']) {
                $svn_log_entry_date = $svn_log_entry_array['DATE'];
                $svn_log_entry.= sprintf("Date: %s\n-----------------------\n", gmdate('D, d M Y H:i:s', $svn_log_entry_date));
            }

            $svn_log_entry.= "{$svn_log_entry_array['COMMENTS']}\r\n\r\n";

            file_put_contents($log_filename, wordwrap($svn_log_entry, 75), FILE_APPEND);
        }

    }else {

        echo "Table BEEHIVE_SVN_LOG is empty. No Changelog generated.\n";
    }

    return true;
}

// Stop the script from timing out

@set_time_limit(0);

// Check to see if we have a date on the command line and
// that it is in the valid format YYYY-MM-DD. If we don't
// we use Beehive's birthday.

if (isset($_SERVER['argv'][1]) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u', $_SERVER['argv'][1]) > 0) {

    $modified_date = $_SERVER['argv'][1];

    if (svn_mysql_prepare_table()) {

        echo "Fetching SVN Log Data...\n";

        if (($svn_log_contents = get_svn_log_data($modified_date))) {

            echo "Parsing SVN Log Data...\n";

            if (!svn_mysql_parse($svn_log_contents)) {

                echo "Error while fetching or parsing SVN log contents\n";
                exit;
            }

        }else {

            echo "Error while fetching SVN log\n";
            exit;
        }

        if (isset($_SERVER['argv'][2]) && strlen(trim($_SERVER['argv'][2])) > 0) {

            $output_log_filename = trim($_SERVER['argv'][2]);
            echo "Generating Change Log. Saving to $output_log_filename\n";
            svn_mysql_output_log($output_log_filename);
            exit;
        }

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else if (isset($_SERVER['argv'][1]) && strlen(trim($_SERVER['argv'][1])) > 0) {

    $output_log_filename = trim($_SERVER['argv'][1]);

    if (svn_mysql_prepare_table(false)) {

        echo "Generating Change Log. Saving to $output_log_filename\n";
        svn_mysql_output_log($output_log_filename);

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else {

    echo "Generate changelog.txt from SVN comments\n\n";
    echo "Usage: php-bin bh_svn_log_parse.php [YYYY-MM-DD] [FILE]\n\n";
    echo "Examples:\n";
    echo "  php-bin bh_svn_log_parse.php 2007-01-01\n";
    echo "  php-bin bh_svn_log_parse.php 2007-01-01 changelog.txt\n";
    echo "  php-bin bh_svn_log_parse.php changelog.txt\n\n";
    echo "[FILE] specifies the output filename for the changelog.\n\n";
    echo "[YYYY-MM-DD] specifies the date the changelog should start from\n\n";
    echo "Both arguments can be combined or used separatly to achieve\n";
    echo "different results.\n\n";
    echo "Specifying the date on it's own will save the results from the\n";
    echo "SVN comments to a MySQL database named BEEHIVE_SVN_LOG using the\n";
    echo "connection details from your Beehive Forum config.inc.php\n\n";
    echo "Specifying only the output filename will take any saved results\n";
    echo "in the BEEHIVE_SVN_LOG table and generate a changelog from them.\n\n";
    echo "Using them together will both save the results to the BEEHIVE_SVN_LOG\n";
    echo "table and generate the specified changelog.\n\n";
    echo "Subsequent runs using the date argument will truncate the database\n";
    echo "table before generating the changelog.\n";
}

?>