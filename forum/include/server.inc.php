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

/* $Id: server.inc.php,v 1.1 2005-01-06 20:01:13 decoyduck Exp $ */

// Contains functions for server functions, like load average,
// detection of server OS, etc.

function server_os_mswin()
{
    if (defined('PHP_OS')) {

        if (stristr(PHP_OS, 'WIN') && !stristr(PHP_OS, 'DARWIN')) {

            return true;
        }
    }

    return false;
}

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

        if (file_exists('/proc/loadavg')) {

            $loadavg_data = implode('', file('/proc/loadavg'));
            list($cpu_load) = explode(' ', $loadavg_data);

            return $cpu_load;
        }
    }

    return false;
}

?>