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

/* $Id: bh_cvs_log_parse.php,v 1.1 2006-02-12 17:11:09 decoyduck Exp $ */

//  To use this you need to perform a dump of the CVS log and save it
//  as log.txt. Commands to dump the CVS log is:
//
//  From within /forum:
//
//  > cvs log -N -S -d ">2005-01-01" >log.txt
//
//  You will also need the old log from the release.txt in the docs folder
//  to remove any entries which may have been dated incorrectly in CVS.
//  Copy and paste the lines from release.txt, remove the line wrapping
//  (Regular expression match: [\n +]) and save it as old_log.txt.
//
//  Before running the log dump you should delete the folders you don't
//  want to be included in the log, such as the Geshi and TinyMCE folders.
//  Just make sure you have checked in all your changes before you delete them!


$log_array = file('log.txt');
$old_log_array = file('old_log.txt');

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

$fixed_array = array_unique($fixed_array);
$added_array = array_unique($added_array);
$changed_array = array_unique($changed_array);
$removed_array = array_unique($removed_array);

$log_array = array_merge($fixed_array, $added_array, $changed_array, $removed_array);

foreach($log_array as $log_line => $log_entry) {

    if (!in_array($log_entry, $old_log_array)) {

        if (preg_match("/^([a-z]+: )/i", $log_entry, $matches) > 0) {
            $indent = str_repeat(" ", strlen($matches[1]) + 10);
        }else {
            $indent = str_repeat(" ", 18);
        }

        echo "        - ", wordwrap(trim($log_entry), 75 - strlen($matches[1]), "\n$indent", 0), "\n";
    }
}

?>