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

/* $Id: word_filter.inc.php,v 1.6 2004-03-13 00:00:22 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/session.inc.php");

// Loads the user's word filter into an array.
// Saves having to query the database every time
// the apply_wordfilter() function is called.

function load_wordfilter()
{
    if (bh_session_get_value('USE_WORD_FILTER') != "Y") return array();
    
    $db_load_wordfilter = db_connect();
    
    $uid = bh_session_get_value('UID');
    
    $table_prefix = get_webtag(true);    

    $sql = "SELECT * FROM {$table_prefix}FILTER_LIST WHERE UID = '$uid'";
    $result = db_query($sql, $db_load_wordfilter);

    $pattern_array = array();
    $replace_array = array();

    while($row = db_fetch_array($result)) {
    
        if ($row['PREG_EXPR'] == 1) {
            if (!preg_match("/^\/(.*)[^\\]\/[imsxeADSUXu]*$/i", $row['MATCH_TEXT'])) {
                $row['MATCH_TEXT'] = "/{$row['MATCH_TEXT']}/i";
            }
            $pattern_array[] = _stripslashes($row['MATCH_TEXT']);
        }else {
            $pattern_array[] = "/". preg_quote(_stripslashes($row['MATCH_TEXT']), "/"). "/i";
        }
            
        if (strlen(trim($row['REPLACE_TEXT'])) > 0) {
            $replace_array[] = _stripslashes($row['REPLACE_TEXT']);
        }else {
            if ($row['PREG_EXPR'] == 1) {
                $replace_array[] = "****";
            }else {
                 $replace_array[] = str_repeat("*", strlen(_stripslashes($row['MATCH_TEXT'])));
            }
        }
    }
    
    return array("pattern_array" => $pattern_array,
                 "replace_array" => $replace_array);
}

// Applys the loaded word filter to the given content

function apply_wordfilter($content)
{
    global $user_wordfilter;

    if (!is_array($user_wordfilter)) return $content;
    if (!isset($user_wordfilter['pattern_array'])) return $content;
    if (!isset($user_wordfilter['replace_array'])) return $content;
    
    $pattern_array = $user_wordfilter['pattern_array'];
    $replace_array = $user_wordfilter['replace_array'];
    
    if (@$new_content = preg_replace($pattern_array, $replace_array, $content)) {
        return $new_content;
    }
        
    return $content;
}

?>