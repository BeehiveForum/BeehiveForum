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

/* $Id: sitemap.inc.php,v 1.3 2008-02-27 19:09:19 decoyduck Exp $ */

/**
* sitemap.inc.php - sitemap functions
*
* Contains sitemap related functions.
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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");

/**
* Get Available Forums
*
* Gets available forums for use in sitemap. Password protected and restricted forums are excluded.
*
* @return mixed
* @param void
*/

function sitemap_get_available_forums()
{
    if (!$db_sitemap_get_available_forums = db_connect()) return false;

    // Array to hold the results.

    $forum_fids_array = array();

    // Query the database to get list of available forums.

    $sql = "SELECT FID, WEBTAG FROM FORUMS WHERE ACCESS_LEVEL = '0'";

    if (!$result = db_query($sql, $db_sitemap_get_available_forums)) return false;

    if (db_num_rows($result) > 0) {

        while ($forum_data = db_fetch_array($result)) {
            $forum_fids_array[$forum_data['FID']] = $forum_data['WEBTAG'];
        }

        return $forum_fids_array;
    }

    return false;
}

/**
* Get Forum Threads
*
* Gets all threads accessible to Guests.
*
* @return mixed
* @param string $webtag - Forum Webtag to fetch the threads for.
*/

function sitemap_forum_get_threads($forum_fid)
{
    if (!$db_sitemap_forum_get_threads = db_connect()) return false;

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($forum_fid)) return false;

    // Array to hold the results.

    $threads_array = array();

    // Get the folders the user can see.

    $folders = folder_get_available_by_forum($forum_fid);

    // Get the table prefix from the forum fid

    if ($table_data = forum_get_table_prefix($forum_fid)) {

        $sql = "SELECT TID, UNIX_TIMESTAMP(MODIFIED) AS MODIFIED ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD ";
        $sql.= "WHERE FID IN ($folders)";

        if (!$result = db_query($sql, $db_sitemap_forum_get_threads)) return false;

        if (db_num_rows($result) > 0) {

            while ($thread_data = db_fetch_array($result)) {
                $threads_array[$thread_data['TID']] = $thread_data['MODIFIED'];
            }

            return $threads_array;
        }
    }

    return false;
}

/**
* Check Sitemap path
*
* Checks that the sitemap file exists and is writable by PHP
*
* @return boolean
* @param void
*/

function sitemap_check_dir()
{
    if ($sitemap_path = forum_get_setting('sitemap_path')) {

        // If the file doesn't exist try and create it.

        if (!@file_exists($sitemap_path)) @file_put_contents($sitemap_path, '');

        // Check that the directory is writable.

        if (@is_writable($sitemap_path)) return $sitemap_path;
    }

    return false;
}

/**
* Generate sitemap
*
* Generates the sitemap file!
*
* @return boolean
* @param void
*/

function sitemap_create_file()
{
    // Header for the sitemap file

    $sitemap_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $sitemap_header.= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    // Sitemap URL entry

    $sitemap_url_entry = "  <url>\n";
    $sitemap_url_entry.= "    <loc>%s/lmessages.php?webtag=%s&amp;msg=%s.1</loc>\n";
    $sitemap_url_entry.= "    <lastmod>%s</lastmod>\n";
    $sitemap_url_entry.= "    <changefreq>%s</changefreq>\n";
    $sitemap_url_entry.= "  </url>\n";

    // Footer for the sitemap file.

    $sitemap_footer = "</urlset>";

    // Forum URL

    $forum_location = html_get_forum_uri();

    // Check that search engine spidering is enabled

    if (forum_get_setting('allow_search_spidering', 'N')) return false;

    // Check that the sitemap setting is enabled.

    if (forum_get_setting('sitemap_enabled', 'N')) return false;

    // Fetch the sitemap path.

    if (!$sitemap_path = forum_get_setting('sitemap_path')) return false;

    // Get the sitemap update frequencey (default: 24 hours)

    $sitemap_freq = forum_get_setting('sitemap_freq', false, DAY_IN_SECONDS);

    // Check the sitemap files already exists and if not create it.

    if (!@file_exists($sitemap_path)) file_put_contents($sitemap_path, '');

    // Check that the file is older than the update frequency.

    if (@(filemtime($sitemap_path) - mktime()) < $sitemap_freq) return false;

    // Check that it is writable.

    if (!@is_writable($sitemap_path)) return false;

    // Write the sitemap header to the file.

    if (!@file_put_contents($sitemap_path, $sitemap_header)) return false;

    // Fetch the data from the database, process it and add it to the sitemap.

    if ($available_forums_array = sitemap_get_available_forums()) {

        foreach ($available_forums_array as $forum_fid => $webtag) {

            if ($threads_array = sitemap_forum_get_threads($forum_fid)) {

                foreach ($threads_array as $thread_tid => $thread_modified) {

                    $thread_last_modified = date("Y-m-d", $thread_modified);

                    if ($thread_modified < mktime() - (90 * DAY_IN_SECONDS)) {

                        $change_frequency = "yearly";

                    }else if ($thread_modified < mktime() - (30 * DAY_IN_SECONDS)) {

                        $change_frequency = "monthly";

                    }else if ($thread_modified < mktime() - (4 * DAY_IN_SECONDS)) {

                        $change_frequency = "weekly";

                    }else {

                        $change_frequency = "daily";
                    }

                    $sitemap_url_entry = sprintf($sitemap_url_entry, $forum_location, $webtag, $thread_tid, $thread_last_modified, $change_frequency);

                    if (!@file_put_contents($sitemap_path, $sitemap_url_entry, FILE_APPEND)) return false;
                }
            }
        }
    }

    if (!@file_put_contents($sitemap_path, $sitemap_footer, FILE_APPEND)) return false;

    admin_add_log_entry(FORUM_AUTO_SITEMAP_UPDATED);

    return true;
}

?>