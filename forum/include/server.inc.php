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

/* $Id: server.inc.php,v 1.6 2007-03-18 23:10:09 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

/**
* Detects server OS
*
* Checks to see if the server is running MS Windows.
*
* @return boolean
* @param void
*/

function server_os_mswin()
{
    if (defined('PHP_OS')) {

        if (stristr(PHP_OS, 'WIN') && !stristr(PHP_OS, 'DARWIN')) {

            return true;
        }
    }

    return false;
}

/**
* Fetch the current CPU load
*
* Fetches the current server CPU load. Returns a percentage on Win32 and the
* result of /proc/loadavg on *nix.
*
* @return mixed
* @param void
*/

function server_get_cpu_load()
{
    $cpu_load  = 0;
    $cpu_count = 0;

    if (server_os_mswin()) {

        if (class_exists('COM')) {

            $wmi = new COM('WinMgmts:\\\\.');
            $cpu_array = $wmi->InstancesOf('Win32_Processor');

            while ($cpu = $cpu_array->Next()) {

                $cpu_load += $cpu->LoadPercentage;
                $cpu_count++;
            }

            $cpu_load = round($cpu_load / $cpu_count, 2);

            return "$cpuload%";
        }

    }else {

        if (@file_exists('/proc/loadavg')) {

            $loadavg_data = implode('', file('/proc/loadavg'));
            list($cpu_load) = explode(' ', $loadavg_data);

            return $cpu_load;
        }
    }

    return false;
}

/**
* Fetch the current timestamp
*
* Fetches the current timestamp as a float.
*
* @return float
* @param void
*/

function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

/**
* Fetch a list of available forum files
*
* Returns an array of Beehive Forum PHP files (forum path only)
*
* @return float
* @param void
*/

function get_available_files()
{
    $available_files_array = array();
    
    if ($dir = @opendir('emoticons')) {

        while (($file = @readdir($dir)) !== false) {

            $file_parts = pathinfo($file);
            
            if (isset($file_parts['extension']) && $file_parts['extension'] == 'php') {

                $available_files_array[] = $file;
            }            
        }
    }

    return $available_files_array;
}

// Executed by every script that includes server.inc.php.
// This crudely disables PHP's register_globals functionality.

if (ini_get('register_globals')) {

    foreach ($_GET as $get_key => $get_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $get_key)) {
            eval("unset(\${$get_key});");
        }
    }

    foreach ($_POST as $post_key => $post_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $post_key)) {
            eval("unset(\${$post_key});");
        }
    }

    foreach ($_REQUEST as $request_key => $request_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $request_key)) {
            eval("unset(\${$request_key});");
        }
    }
}

?>