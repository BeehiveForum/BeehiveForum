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

/* $Id: forum.inc.php,v 1.19 2004-03-19 11:58:41 decoyduck Exp $ */

include_once("./include/config.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");

function get_webtag()
{
    global $HTTP_GET_VARS, $lang;
    
    $db_get_table_prefix = db_connect();    
    
    if (isset($HTTP_GET_VARS['webtag']) && strlen(trim($HTTP_GET_VARS['webtag'])) > 0) {
        $webtag = (trim($HTTP_GET_VARS['webtag']);
    }else {
        $webtag = "";
    }
    
    $sql = "SELECT FID FROM FORUMS WHERE WEBTAG = '$webtag'"; 
    $result = db_query($sql, $db_get_table_prefix);
        
    // if we found the post table return the webtag
    
    if (db_num_rows($result) > 0) {
        
        $forum_data = db_fetch_array($result);
        
        if (strlen(trim($webtag)) > 0) {
            $forum_data['WEBTAG'] = $webtag;
            $forum_data['PREFIX'] = "{$webtag}_";
        }else {
            $forum_data['WEBTAG'] = "";
            $forum_data['PREFIX'] = "";
        }
            
        return $forum_data;
    }
        
    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<h2>Unknown Forum Tag.</h2>\n";
    form_quick_button("./index.php", $lang['continue'], 0, 0, "_top");
    echo "</div>\n";
    html_draw_bottom();
    exit;
}

function get_forum_settings()
{
    global $forum_settings;
    
    $db_get_forum_settings = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_get_forum_settings);
    
    while ($row = db_fetch_array($result)) {
        
        $forum_settings[$row['SNAME']] = $row['SVALUE'];
    }
    
    return $forum_settings;
}

function save_forum_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;
    
    $db_save_forum_settings = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_save_forum_settings);
    
    foreach ($forum_settings_array as $sname => $svalue) {
    
        $sname = addslashes($sname);
        $svalue = addslashes($svalue);
        
        $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
        $sql.= "VALUES ('{$webtag['FID']}', '$sname', '$svalue')";
        
        $result = db_query($sql, $db_save_forum_settings);
    }
}

function forum_get_setting($setting_name, $value = false, $default = false)
{
    global $forum_settings;
    
    if (isset($forum_settings[$setting_name])) {
        if ($value) {
            if (strtoupper($forum_settings[$setting_name]) == strtoupper($value)) {
                return true;
            }
        }else {
            return _stripslashes($forum_settings[$setting_name]);
        }
    }
    
    return $default;
}    

function draw_start_page()
{
    global $lang;
    
    $db_draw_start_page = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT HTML FROM START_MAIN WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_draw_start_page);
    
    if (db_num_rows($result)) {
    
        $row = db_fetch_array($result);
        
        if (strlen(trim($row['HTML'])) > 0) {
        
            echo $row['HTML'];

        }else {
        
            html_draw_top();
            echo "<h1>{$lang['editstartpage']}</h1>\n";
            html_draw_bottom();
        }

    }else {
    
        html_draw_top();
        echo "<h1>{$lang['editstartpage']}</h1>\n";
        html_draw_bottom();
    }
}

function load_start_page()
{
    $db_load_start_page = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT HTML FROM START_MAIN WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_load_start_page);
    
    if (db_num_rows($result)) {
    
        $row = db_fetch_array($result);
        return $row['HTML'];
    }
    
    return "";
}

function save_start_page($content)
{
    $db_save_start_page = db_connect();
    
    $webtag = get_webtag();
    $content = addslashes($content);
    
    $sql = "DELETE FROM START_MAIN WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_save_start_page);
    
    $sql = "INSERT INTO START_MAIN (FID, HTML) ";
    $sql.= "VALUES('{$webtag['FID']}', '$content')";
    
    return db_query($sql, $db_save_start_page);
}

?>