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

/* $Id: forum.inc.php,v 1.15 2004-03-17 14:14:28 decoyduck Exp $ */

include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");

function get_webtag()
{
    global $HTTP_GET_VARS, $lang;
    
    $db_get_table_prefix = db_connect();    
    
    if (isset($HTTP_GET_VARS['webtag']) && strlen(trim($HTTP_GET_VARS['webtag'])) > 0) {
        $webtag = strtolower(trim($HTTP_GET_VARS['webtag']));
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
    $default_settings = array('forum_name'                => "A Beehive Forum",
                              'forum_email'               => "admin@abeehiveforum.net",
                              'default_style'             => "default",
                              'default_language'          => "en",
                              'show_friendly_errors'      => 'Y',
                              'cookie_domain'             => "",
                              'show_stats'                => "Y",
                              'show_links'                => "Y",
                              'auto_logon'                => "Y",
                              'show_pms'                  => "Y",
                              'pm_allow_attachments'      => "Y",
                              'maximum_post_length'       => 6226,
                              'allow_post_editing'        => "Y",
                              'post_edit_time'            => 0,
                              'allow_polls'               => "Y",
                              'search_min_word_length'    => 3,
                              'attachments_enabled'       => "Y",
                              'attachment_dir'            => "attachments",
                              'attachments_show_deleted'  => "N",
                              'attachment_allow_embed'    => "N",
                              'attachment_use_old_method' => "N",
                              'guest_account_enabled'     => "Y",
                              'session_cutoff'            => 86400,
                              'active_sess_cutoff'        => 900,
                              'gzip_compress_output'      => "Y",
                              'gzip_compress_level'       => 1);
    
    $db_get_forum_settings = db_connect();
    
    $webtag = get_webtag();
    
    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_get_forum_settings);
    
    $forum_settings_array = $default_settings;
    
    while ($row = db_fetch_array($result)) {
        
        $forum_settings_array[$row['SNAME']] = $row['SVALUE'];
    }
    
    return $forum_settings_array;
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