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

/* $Id: forum.inc.php,v 1.12 2004-03-15 19:25:16 decoyduck Exp $ */

include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/lang.inc.php");

function get_webtag()
{
    global $HTTP_GET_VARS, $lang;
    
    $db_get_table_prefix = db_connect();    
    
    if (isset($HTTP_GET_VARS['webtag']) && strlen(trim($HTTP_GET_VARS['webtag'])) > 0) {
        
        $webtag = strtolower(trim($HTTP_GET_VARS['webtag']));
    
        // test to see if the POST table exists with our prefix.
        
        $sql = "SELECT * FROM FORUMS WHERE WEBTAG = '$webtag'"; 
        $result = db_query($sql, $db_get_table_prefix);
        
        // if we found the post table return the webtag
    
        if (db_num_rows($result) > 0) {
            $row = db_fetch_array($result);
            $row['PREFIX'] = "{$row['WEBTAG']}_";
            return $row;
        }
        
        html_draw_top();
        echo "<div align=\"center\">\n";
        echo "<h2>Unknown Forum Tag.</h2>\n";
        form_quick_button("./index.php", $lang['continue'], 0, 0, "_top");
        echo "</div>\n";
        html_draw_bottom();
        exit;
    }
}

function get_forum_settings()
{
    global $default_settings;
    
    $db_get_forum_settings = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT * FROM FORUM_SETTINGS WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_get_forum_settings);
    
    $forum_settings_array = $default_settings;
    
    while ($row = db_fetch_array($result)) {
        
        $forum_settings_array[$row['SETTING_NAME']] = $row['SETTING_VALUE'];
    }
    
    return $forum_settings_array;
}

function draw_start_page()
{
    global $default_start_main;
    
    $db_draw_start_page = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT HTML FROM START_MAIN WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_draw_start_page);
    
    if (db_num_rows($result)) {
    
        $row = db_fetch_array($result);
        echo $row['HTML'];

    }else {
    
        echo $default_start_main;
    }
}

?>