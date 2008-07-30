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

/* $Id: bh_cvs_log_parse.php,v 1.19 2008-07-30 22:39:22 decoyduck Exp $ */

/**
* bh_cvs_log_parse.php
*
* Automated collection and processing of CVS LOG entries into a human
* readable changelog.txt.
*
* For this to work you need to have correctly set up SSH and CVS and
* have created a ssh key otherwise you will be prompted for your
* password for every call to CVS LOG, in excess of 20 times which
* won't be fun at all.
*
* And no this won't work with TortoiseCVS and Pageant.
*/

/**
*
*/

// Constant to define where the include files are

define("BH_INCLUDE_PATH", "./forum/include/");

// Mimic Lite Mode
define("BEEHIVEMODE_LIGHT", true);

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Database functions.
include_once(BH_INCLUDE_PATH. "db.inc.php");

/**
* Get CVS Log
*
* Fetches the CVS Log data. The main workhorse of this script.
*
* @return mixed - False on failure, CVS LOG as string on success.
* @param mixed $date - Date to limit the CVS LOG command by.
* @param string $file - File to get the CVS LOG data for.
*/

function get_cvs_log_data($date)
{
    if (($log_handle = popen("cvs log -N -d \">$date\" * 2>&1", 'r'))) {

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
* Prepare MySQL table for logging of CVS data.
*
* Prepares a MySQL table for logging data from CVS LOG command.
* If the table doesn't exist it creates a new one, if it already
* exists it is emptied.
*
* @return bool
* @param string $log_file - Path and filename of cvs log output.
*/

function cvs_mysql_prepare_table($truncate_table = true)
{
    if (!$db_cvs_mysql_prepare_table = db_connect()) return false;

    $sql = "CREATE TABLE IF NOT EXISTS BEEHIVE_CVS_LOG (";
    $sql.= "  LOG_ID MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,";
    $sql.= "  DATE DATETIME NOT NULL,";
    $sql.= "  AUTHOR VARCHAR( 255 ) NOT NULL,";
    $sql.= "  COMMENTS TEXT NOT NULL";
    $sql.= ") TYPE = MYISAM";

    if (!db_query($sql, $db_cvs_mysql_prepare_table)) return false;

    if ($truncate_table == true) {

        $sql = "TRUNCATE TABLE BEEHIVE_CVS_LOG";
        if (!db_query($sql, $db_cvs_mysql_prepare_table)) return false;
    }

    return true;
}

/**
* Parse output of cvs log into a MySQL database table.
*
* Parses the output of cvs log command that has been outputted to a file
* into a MySQL database table comprising DATE, AUTHOR, COMMENTS columns.
*
* @return bool
* @param string $log_file - Path and filename of cvs log output.
*/

function cvs_mysql_parse($cvs_log_contents)
{
    if (!$db_cvs_log_parse = db_connect()) return false;

    $cvs_log_array = preg_split("/\n={77}|\n-{22}/", $cvs_log_contents, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($cvs_log_array as $cvs_log_entry) {

        $cvs_log_match_array = array();
    	
    	$description_match = '/date: ([0-9]{4})\/([0-9]{2})\/([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2});  ';
        $description_match.= 'author: ([^;]+);  state: [^;]+;  lines: \+[0-9]+ \-[0-9]+\n';
        $description_match.= '(.+)/s';

        if (preg_match_all($description_match, trim($cvs_log_entry), $cvs_log_match_array, PREG_SET_ORDER) > 0) {

            foreach ($cvs_log_match_array as $cvs_log_match) {

                $cvs_log_entry_date = mktime($cvs_log_match[4], $cvs_log_match[5], $cvs_log_match[6], $cvs_log_match[2], $cvs_log_match[3], $cvs_log_match[1]);
                $cvs_log_entry_author = db_escape_string(trim($cvs_log_match[7]));
                $cvs_log_entry_comment = db_escape_string(trim($cvs_log_match[8]));

                if (strlen($cvs_log_entry_comment) > 0 && $cvs_log_entry_comment != '*** empty log message ***') {

                    $sql = "SELECT LOG_ID FROM BEEHIVE_CVS_LOG WHERE AUTHOR = '$cvs_log_entry_author' ";
                    $sql.= "AND COMMENTS = '$cvs_log_entry_comment'";

                    if (!$result = db_query($sql, $db_cvs_log_parse)) return false;

                    if (db_num_rows($result) < 1) {

                        $sql = "INSERT INTO BEEHIVE_CVS_LOG (DATE, AUTHOR, COMMENTS) ";
                        $sql.= "VALUES(FROM_UNIXTIME('$cvs_log_entry_date'), '$cvs_log_entry_author', ";
                        $sql.= "'$cvs_log_entry_comment')";

                        if (!$result = db_query($sql, $db_cvs_log_parse)) return false;
                    }
                }
            }
        }
    }

    return true;
}

function cvs_mysql_output_log($log_filename)
{
    if (!$db_cvs_mysql_output_log = db_connect()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DATE) AS DATE, AUTHOR, COMMENTS ";
    $sql.= "FROM BEEHIVE_CVS_LOG GROUP BY DATE ORDER BY DATE DESC";

    if (!$result = db_query($sql, $db_cvs_mysql_output_log)) return false;

    if (db_num_rows($result) > 0) {

        $cvs_log_entry_author = '';
        $cvs_log_entry_date = '';

        file_put_contents($log_filename, sprintf("Project Beehive Forum Change Log (Generated: %s)\n\n", gmdate('D, d M Y H:i:s')));

        while (($cvs_log_entry_array = db_fetch_array($result, DB_RESULT_ASSOC))) {

            $cvs_log_entry = '';

            if ($cvs_log_entry_author != $cvs_log_entry_array['AUTHOR']) {
                $cvs_log_entry_author = $cvs_log_entry_array['AUTHOR'];
                $cvs_log_entry.= sprintf("Author: %s\n", $cvs_log_entry_author);
            }

            if ($cvs_log_entry_date != $cvs_log_entry_array['DATE']) {
                $cvs_log_entry_date = $cvs_log_entry_array['DATE'];
                $cvs_log_entry.= sprintf("Date: %s\n-----------------------\n", gmdate('D, d M Y H:i:s', $cvs_log_entry_date));
            }

            $cvs_log_entry.= "{$cvs_log_entry_array['COMMENTS']}\r\n\r\n";

            file_put_contents($log_filename, wordwrap($cvs_log_entry, 75), FILE_APPEND);
        }

    }else {

        echo "Table BEEHIVE_CVS_LOG is empty. No Changelog generated.\n";
    }

    return true;
}

// Stop the script from timing out

@set_time_limit(0);

// Check to see if we have a date on the command line and
// that it is in the valid format YYYY-MM-DD. If we don't
// we use Beehive's birthday.

if (isset($_SERVER['argv'][1]) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_SERVER['argv'][1]) > 0) {

    $modified_date = $_SERVER['argv'][1];

    if (cvs_mysql_prepare_table()) {

        echo "Fetching CVS Log Data...\n";

        if (($cvs_log_contents = get_cvs_log_data($modified_date))) {

            echo "Parsing CVS Log Data...\n";

            if (!cvs_mysql_parse($cvs_log_contents)) {

                echo "Error while fetching or parsing CVS log contents\n";
                exit;
            }

        }else {

            echo "Error while fetching CVS log\n";
            exit;
        }

        if (isset($_SERVER['argv'][2]) && strlen(trim($_SERVER['argv'][2])) > 0) {

            $output_log_filename = trim($_SERVER['argv'][2]);
            echo "Generating Change Log. Saving to $output_log_filename\n";
            cvs_mysql_output_log($output_log_filename);
            exit;
        }

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else if (isset($_SERVER['argv'][1]) && strlen(trim($_SERVER['argv'][1])) > 0) {

    $output_log_filename = trim($_SERVER['argv'][1]);

    if (cvs_mysql_prepare_table(false)) {

        echo "Generating Change Log. Saving to $output_log_filename\n";
        cvs_mysql_output_log($output_log_filename);

    }else {

        echo "Error while preparing MySQL Database table";
        exit;
    }

}else {

    echo "Generate changelog.txt from CVS comments\n\n";
    echo "Usage: php-bin bh_cvs_log_parse.php [YYYY-MM-DD] [FILE]\n\n";
    echo "Examples:\n";
    echo "  php-bin bh_cvs_log_parse.php 2007-01-01\n";
    echo "  php-bin bh_cvs_log_parse.php 2007-01-01 changelog.txt\n";
    echo "  php-bin bh_cvs_log_parse.php changelog.txt\n\n";
    echo "[FILE] specifies the output filename for the changelog.\n\n";
    echo "[YYYY-MM-DD] specifies the date the changelog should start from\n\n";
    echo "Both arguments can be combined or used separatly to achieve\n";
    echo "different results.\n\n";
    echo "Specifying the date on it's own will save the results from the\n";
    echo "CVS comments to a MySQL database named BEEHIVE_CVS_LOG using the\n";
    echo "connection details from your Beehive Forum config.inc.php\n\n";
    echo "Specifying only the output filename will take any saved results\n";
    echo "in the BEEHIVE_CVS_LOG table and generate a changelog from them.\n\n";
    echo "Using them together will both save the results to the BEEHIVE_CVS_LOG\n";
    echo "table and generate the specified changelog.\n\n";
    echo "Subsequent runs using the date argument will truncate the database\n";
    echo "table before generating the changelog.\n";
}

?>