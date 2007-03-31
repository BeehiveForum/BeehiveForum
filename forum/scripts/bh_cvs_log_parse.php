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

/* $Id: bh_cvs_log_parse.php,v 1.1 2007-03-31 21:37:42 decoyduck Exp $ */

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

/**
* Get CVS Log
*
* Fetches the CVS Log data. The main workhorse of this script.
*
* @return mixed - False on failure, CVS LOG as string on success.
* @param string $dir - Directory path to run the CVS LOG command in.
* @param mixed $date - Date to limit the CVS LOG command by.
*/

function get_cvs_log_data($dir, $date)
{
    $cwd = getcwd();

    if (is_dir($dir)) {
       
        chdir($dir);
        
        if (@$log_handle = popen("cvs log -l -N -d \">$date\" 2>&1", 'r')) {

            $log_contents = "";
            
            while(!feof($log_handle)) {
                $log_contents.= fgets($log_handle);
            }

            pclose($log_handle);
            chdir($cwd);
            return $log_contents;
        }
    }

    chdir($cwd);
    return false;
}

/**
* Get Directory listing that we want CVS log data from.
*
* Fetches a list of directories that we want to fetch CVS LOG data
* from. Recurses through the child directories ignoring CVS folders.
* Is influenced by the array $exclude_dirs which contains an array
* of paths to ignore.
*
* @return void
* @param string $path - Directory to start in.
* @param array $date - By Reference array which the paths are returned in.
*/

function get_cvs_dirs($path, &$cvs_dir_array)
{
    global $exclude_dirs;
    
    if (!is_array($cvs_dir_array)) {
        $cvs_dir_array = array();
    }
    
    if ($dir = opendir($path)) {

        while (($file = readdir($dir)) !== false) {

            if ($file != "." && $file != ".." && $file != "CVS") {
            
                $grep_match = preg_quote("$path/$file", "/");
                
                if (is_dir("$path/$file")) {

                    if (!preg_grep("/^$grep_match$/", $exclude_dirs)) {
                        $cvs_dir_array[] = "$path/$file";
                    }

                    get_cvs_dirs("$path/$file", $cvs_dir_array);
                }
            }
        }

        closedir($dir);
    }
}

// Stop us timing out...

set_time_limit(0);

// Fetch our exclude list. This allows us to ignore some
// BH addons which are included in CVS (Geshi and TinyMCE)

$exclude_dirs = array();

if (file_exists('bh_cvs_log_parse_exclude.php')) {
    include('bh_cvs_log_parse_exclude.php');
}

// Check to see if we have a date on the command line and
// that it is in the valid format YYYY-MM-DD. If we don't
// then we need to bail out.

if (isset($_SERVER['argv'][1]) && preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_SERVER['argv'][1]) > 0) {
    
    $date_from = $_SERVER['argv'][1];

    // Get a list of directories to use

    get_cvs_dirs('.', $cvs_log_folders);

    // What we're actually going to be doing :)

    echo "Please wait getting log entries.";

    // Fetch the CVS log for each folder. At the moment this is done
    // by looping through the array above as there doesn't appear to
    // be a way log the entire repository while ignoring specific
    // folders like the TinyMCE and Geshi folders.

    if ($fp = fopen('changelog.txt.tmp', 'w')) {

        foreach ($cvs_log_folders as $cvs_log_folder) {

            fwrite($fp, get_cvs_log_data($cvs_log_folder, $date_from));
            echo ".";
        }

        fclose($fp);        
    }

    // Got the log data, split it into an array by lines.

    $log_array = explode("\n", file_get_contents('changelog.txt.tmp'));

    // Optionally load the old log otherwise create an
    // empty array.

    if (!@$old_log_array = file('old_log.txt')) {
        $old_log_array = array();
    }

    // Create the arrays. Prevents errors later if the
    // log only contains added entries for example.

    $fixed_array = array();
    $added_array = array();
    $changed_array = array();
    $removed_array = array();

    // Process the log entries by their prefix.

    foreach($log_array as $log_entry) {

        if (preg_match("/^fixed:/i", $log_entry) > 0) {
            $fixed_array[] = $log_entry;
        }

        if (preg_match("/^added:/i", $log_entry) > 0) {
            $added_array[] = $log_entry;
        }

        if (preg_match("/^changed:/i", $log_entry) > 0) {
            $changed_array[] = $log_entry;
        }

        if (preg_match("/^removed:/i", $log_entry) > 0) {
            $removed_array[] = $log_entry;
        }
    }

    // Remove duplicate entries which are caused by
    // checking in multiple files at a time.

    $fixed_array = array_unique($fixed_array);
    $added_array = array_unique($added_array);
    $changed_array = array_unique($changed_array);
    $removed_array = array_unique($removed_array);

    // Merge the log data together into one array

    $log_array = array_merge($fixed_array, $added_array, $changed_array, $removed_array);

    // Loop through the array and indent the line correctly.
    // If the log entry exists in the old log then we ignore it.

    ob_start();

    foreach($log_array as $log_line => $log_entry) {

        if (!in_array($log_entry, $old_log_array)) {

            if (preg_match("/^([a-z]+: )/i", $log_entry, $matches) > 0) {
                $indent = str_repeat(" ", strlen($matches[1]) + 10);
            }else {
                $indent = str_repeat(" ", 18);
            }

            echo "        - ", wordwrap(trim($log_entry), 75 - strlen($indent), "\n$indent", 0), "\n";
        }
    }

    $log_data  = ob_get_contents();
    ob_end_clean();

    if (@$fp = fopen('changelog.txt', 'w')) {

         fwrite($fp, $log_data);
         fclose($fp);
    }

    exit;
}

// If we get to here then something was wrong.

echo "You must specify a date in the format YYYY-MM-DD.\n";

?>