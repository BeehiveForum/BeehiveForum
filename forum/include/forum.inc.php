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

/* $Id: forum.inc.php,v 1.7 2004-03-10 18:43:18 decoyduck Exp $ */

// Forum-handling functions

// Fetches the webtag from the GET/POST var, checks for it in the
// database and returns a value.

function get_table_prefix()
{
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    
    if (isset($HTTP_GET_VARS['webtag']) && strlen(trim($HTTP_GET_VARS['webtag'])) > 0) {
        $webtag = strtoupper(trim($HTTP_GET_VARS['webtag']));
    }elseif (isset($HTTP_POST_VARS['webtag']) && strlen(trim($HTTP_POST_VARS['webtag'])) > 0) {
        $webtag = strtoupper(trim($HTTP_POST_VARS['webtag']));
    }
    
    if (isset($webtag)) {
    
        $db_get_table_prefix = db_connect();
                
        // test to see if the POST table exists with our prefix.
        
        $sql = "SHOW TABLES LIKE '{$webtag}_POST'"; 
        $result = db_query($sql, $db_get_table_prefix);
        
        // if we found the post table with the webtag return the prefix
    
        if (db_num_rows($result) > 0) {
            return "{$webtag}_";
        }
    }
    
    return "";
}

function get_webtag()
{
    global $HTTP_GET_VARS;
    
    if (isset($HTTP_GET_VARS['webtag']) && strlen(trim($HTTP_GET_VARS['webtag'])) > 0) {
        $webtag = strtoupper(trim($HTTP_GET_VARS['webtag']));
        return $webtag;
    }
    
    return "";
}

$webtag = get_webtag();

?>