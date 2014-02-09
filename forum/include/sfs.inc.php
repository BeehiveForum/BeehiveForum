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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'ip.inc.php';
// End Required includes

function sfs_check_banned($user_data, &$cached_response = false)
{
    if (forum_get_setting('sfs_enabled', 'N')) {
        return false;
    }

    $request = array(
        'f' => 'json',
    );

    if (isset($user_data['IPADDRESS']) && strlen(trim($user_data['IPADDRESS'])) > 0) {
        $request['ip'] = ipv6_to_ipv4($user_data['IPADDRESS']);
    }

    if (!isset($user_data['UID']) || ($user_data['UID'] > 0)) {

        if (isset($user_data['LOGON']) && strlen(trim($user_data['LOGON'])) > 0) {
            $request['username'] = $user_data['LOGON'];
        }

        if (isset($user_data['EMAIL']) && strlen(trim($user_data['EMAIL'])) > 0) {
            $request['email'] = $user_data['EMAIL'];
        }
    }

    if (sizeof($request) < 2) {
        return false;
    }

    $ban_type_array = array(
        'ip' => BAN_TYPE_IP,
        'username' => BAN_TYPE_LOGON,
        'email' => BAN_TYPE_EMAIL,
    );

    $sfs_api_url_array = parse_url(forum_get_setting('sfs_api_url', null, 'http://www.stopforumspam.com/api'));

    $sfs_api_url_array['query'] = http_build_query($request, false, '&');

    $sfs_api_url = build_url_str($sfs_api_url_array);

    $sfs_api_url_md5 = md5($sfs_api_url);

    $min_confidence = forum_get_setting('sfs_min_confidence', null, 75);

    $response_confidence = 0;

    $cached_response = false;

    try {

        if (!($response = sfs_cache_get($sfs_api_url_md5, $cached_response))) {

            $curl = curl_init($sfs_api_url);

            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 500);
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            $response = json_decode(curl_exec($curl), true);
        }

        if (!isset($response['success']) || $response['success'] <> 1) {
            return false;
        }

        if (!$cached_response) {
            sfs_cache_put($sfs_api_url_md5, $response);
        }

        foreach (array_keys($ban_type_array) as $key) {

            if (!isset($response[$key]['confidence'])) {
                continue;
            }

            $response_confidence += $response[$key]['confidence'];
        }

        $response_confidence = $response_confidence / (count($request) - 1);

    } catch (Exception $e) {

        return false;
    }

    return $response_confidence > $min_confidence;
}

function sfs_cache_get($request_md5, &$cached_response = false)
{
    $db = db::get();

    $request_md5 = $db->escape($request_md5);

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "SELECT RESPONSE FROM SFS_CACHE WHERE REQUEST_MD5 = '$request_md5' ";
    $sql .= "AND EXPIRES > '$current_datetime'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $cached_response = true;

    list($response) = $result->fetch_row();

    return unserialize($response);
}

function sfs_cache_put($request_md5, $response)
{
    $db = db::get();

    $request_md5 = $db->escape($request_md5);

    $response = $db->escape(serialize($response));

    $current_datetime = date(MYSQL_DATETIME, time());

    $expires_datetime = date(MYSQL_DATETIME, time() + DAY_IN_SECONDS);

    $sql = "REPLACE INTO SFS_CACHE (REQUEST_MD5, RESPONSE, CREATED, EXPIRES) ";
    $sql .= "VALUES('$request_md5', '$response', '$current_datetime', '$expires_datetime')";

    if (!$db->query($sql)) return false;

    return $db->affected_rows > 0;
}