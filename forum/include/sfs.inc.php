<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';

function sfs_check_banned($user_data, &$cached_response = false)
{
    if (forum_get_setting('sfs_enabled', 'N')) {
        return false;
    }
    
    $request = array(
        'f' => 'json',
    );
    
    if (isset($user_data['IPADDRESS']) && strlen(trim($user_data['IPADDRESS'])) > 0) {
        $request['ip'] = $user_data['IPADDRESS'];
    }
    
    if (isset($user_data['LOGON']) && strlen(trim($user_data['LOGON'])) > 0) {
        $request['username'] = $user_data['LOGON'];
    }
    
    if (isset($user_data['EMAIL']) && strlen(trim($user_data['EMAIL'])) > 0) {
        $request['email'] = $user_data['EMAIL'];
    }
    
    if (sizeof($request) < 2) {
        return false;
    }
    
    $ban_type_array = array(
        'ip' => BAN_TYPE_IP,
        'username' => BAN_TYPE_LOGON,
        'email' => BAN_TYPE_EMAIL,
    );
    
    $sfs_api_url_array = parse_url(forum_get_setting('sfs_api_url', false, 'http://www.stopforumspam.com/api'));
    
    $sfs_api_url_array['query'] = http_build_query($request, false, '&');
    
    $sfs_api_url = build_url_str($sfs_api_url_array);
    
    $sfs_api_url_md5 = md5($sfs_api_url);
    
    $min_confidence = forum_get_setting('sfs_min_confidence', false, 75);
    
    $response_confidence = 0;
    
    try {
        
        if (!($response = sfs_cache_get($sfs_api_url_md5, $cached_response))) {
            $response = json_decode(file_get_contents($sfs_api_url), true);
        }
        
        sfs_cache_put($sfs_api_url_md5, $response);
        
        if (!isset($response['success']) || $response['success'] <> 1) {
            return false;
        }
        
        foreach (array_keys($ban_type_array) as $key) {
            
            if (!isset($response[$key]['confidence'])) {
                continue;
            }
            
            $response_confidence+= $response[$key]['confidence'];
        }
        
        $response_confidence = $response_confidence / (count($request) - 1);
        
    } catch (Exception $e) {
        
        return false;
    }
    
    return $response_confidence > $min_confidence;
}

function sfs_cache_get($request_md5, &$cached_response = false)
{
    $db_sfs_cache_get = db_connect();
    
    $request_md5 = db_escape_string($request_md5);
    
    $current_datetime = date(MYSQL_DATETIME, time());
    
    $sql = "SELECT RESPONSE FROM SFS_CACHE WHERE REQUEST_MD5 = '$request_md5' ";
    $sql.= "AND EXPIRES > '$current_datetime'";
    
    if (!($result = db_query($sql, $db_sfs_cache_get))) return false;
    
    if (db_num_rows($result) == 0) return false;
    
    $cached_response = true;
        
    list($response) = db_fetch_array($result, DB_RESULT_NUM);
    
    return unserialize(base64_decode($response));
}

function sfs_cache_put($request_md5, $response)
{
    $db_sfs_cache_put = db_connect();
    
    $request_md5 = db_escape_string($request_md5);
    
    $response = base64_encode(serialize($response));
    
    $current_datetime = date(MYSQL_DATETIME, time());
    
    $expires_datetime = date(MYSQL_DATETIME, time() + DAY_IN_SECONDS);
    
    $sql = "REPLACE INTO SFS_CACHE (REQUEST_MD5, RESPONSE, CREATED, EXPIRES) ";
    $sql.= "VALUES('$request_md5', '$response', '$current_datetime', '$expires_datetime')";
    
    if (!db_query($sql, $db_sfs_cache_put)) return false;
    
    return db_affected_rows($db_sfs_cache_put) > 0;
}
  
?>