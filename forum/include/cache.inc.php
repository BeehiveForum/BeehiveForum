<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: cache.inc.php,v 1.6 2008-07-25 14:52:44 decoyduck Exp $ */

/**
* cache.inc.php - cache functions
*
* Contains cache related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// Include files we need.

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

/**
* Check for PEAR Cache_Lite Package
*
* Check that PEAR Cache_Lite package is available. Uses a work around for file_exists
* which doesn't allow for an optional argument to check include_path ini setting.
*
* @return boolean
*/

function cache_enabled()
{
    $include_path_array = explode(PATH_SEPARATOR, ini_get('include_path'));

    if (forum_get_setting('message_cache_enabled', 'N')) return false;

    foreach ($include_path_array as $include_path_dir) {

        $include_path_dir = rtrim($include_path_dir, '/');
        if (file_exists("$include_path_dir/Cache/Lite.php")) return true;
    }

    return false;
}

/**
* Check for cache.
*
* Check if a cache is available and return it.
*
* @return mixed - returns data from the cache or false if no cache available.
* @param integer $cache_id - Cache ID
*/

function cache_check($cache_id)
{
    if (!$webtag = get_webtag($webtag_search)) return false;

    if (cache_enabled()) {

        include_once('Cache/Lite.php');

        if (class_exists('Cache_Lite')) {

            $cache_options = array('cacheDir' => forum_get_setting('cache_dir', false, system_get_temp_dir()));

            $message_cache = new Cache_Lite($cache_options);

            if (method_exists($message_cache, 'setLifeTime')) {

                $message_cache->setLifeTime(HOUR_IN_SECONDS);
                $message_cache->clean(false, 'old');
            }

            if (method_exists($message_cache, 'get')) {

                if (($message_cache_data = $message_cache->get($cache_id, $webtag))) {

                    return $message_cache_data;
                }
            }
        }
    }

    return false;
}

/**
* Save data to cache.
*
* Saved specified data to the cache.
*
* @return boolean.
* @param integer $cache_id - Cache ID
*/

function cache_save($cache_id, $content)
{
    if (!$webtag = get_webtag($webtag_search)) return false;

    if (cache_enabled()) {

        include_once('Cache/Lite.php');

        if (class_exists('Cache_Lite')) {

            $cache_options = array('cacheDir' => forum_get_setting('cache_dir', false, system_get_temp_dir()));

            $message_cache = new Cache_Lite($cache_options);

            if (method_exists($message_cache, 'setLifeTime')) {

                $message_cache->setLifeTime(WEEK_IN_SECONDS);
                $message_cache->clean(false, 'old');
            }

            if (method_exists($message_cache, 'save')) {

                return $message_cache->save($content, $cache_id, $webtag);
            }
        }
    }

    return false;
}

/**
* Remove data from cache.
*
* Remove specified cache_id from cache.
*
* @return boolean.
* @param integer $cache_id - Cache ID
*/

function cache_remove($cache_id)
{
    if (!$webtag = get_webtag($webtag_search)) return false;

    if (cache_enabled()) {

        include_once('Cache/Lite.php');

        if (class_exists('Cache_Lite')) {

            $cache_options = array('cacheDir' => forum_get_setting('cache_dir', false, system_get_temp_dir()));

            $message_cache = new Cache_Lite($cache_options);

            if (method_exists($message_cache, 'remove')) {

                return $message_cache->remove($cache_id, $webtag);
            }
        }
    }

    return false;
}

?>