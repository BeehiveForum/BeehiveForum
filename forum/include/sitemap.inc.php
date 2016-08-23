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
require_once BH_INCLUDE_PATH . 'html.inc.php';
// End Required includes

function sitemap_get_available_forums()
{
    if (!$db = db::get()) return false;

    // Query the database to get list of available forums.
    $sql = "SELECT FID, WEBTAG FROM FORUMS WHERE ACCESS_LEVEL = '0'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result;
}

function sitemap_forum_get_threads($forum_fid)
{
    if (!$db = db::get()) return false;

    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($forum_fid)) return false;

    // Constant for Guest access.
    $user_perm_guest_access = USER_PERM_GUEST_ACCESS;

    // Get the table prefix from the forum fid
    if (!($table_prefix = forum_get_table_prefix($forum_fid))) return false;

    $sql = "SELECT THREAD.TID, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "INNER JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE FOLDER.PERM & $user_perm_guest_access > 0 ";
    $sql .= "ORDER BY THREAD.TID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result;
}

function sitemap_get_dir()
{
    // Get the real forum directory by getting the parent directory of this
    // files current directory.
    $forum_directory = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR);

    // Once we have the forum directory we can find our sitemaps directory.
    $sitemap_path = $forum_directory . DIRECTORY_SEPARATOR . 'sitemaps';

    // Disable sitemap for get_attachment.php as that can cause problems.
    if (strstr($_SERVER['SCRIPT_NAME'], 'get_attachment.php')) return false;

    // Check to make sure the $sitemap_path exists and is writable.
    @mkdir($sitemap_path, 0755, true);

    // Check that it actually is a directory.
    if (!@is_dir($sitemap_path)) return false;

    // Check that the main index file is writable.
    if (is_writable($sitemap_path)) return $sitemap_path;

    // If the write check failed return false;
    return false;
}

function sitemap_create_file()
{
    // This can take a long time so we'll stop PHP timing out.
    set_time_limit(0);

    // Header for the sitemap index file
    $sitemap_index_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $sitemap_index_header .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    // Sitemap index entry
    $sitemap_index_entry = "<sitemap>\n";
    $sitemap_index_entry .= "<loc>%s/sitemaps/sitemap%s.xml</loc>\n";
    $sitemap_index_entry .= "<lastmod>%s</lastmod>\n";
    $sitemap_index_entry .= "</sitemap>\n";

    // Sitemap index footer.
    $sitemap_index_footer = "</sitemapindex>";

    // Header for the sitemap file
    $sitemap_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $sitemap_header .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    // Sitemap URL entry
    $sitemap_url_entry = "<url>\n";
    $sitemap_url_entry .= "<loc>%s/index.php?webtag=%s&amp;msg=%s.1</loc>\n";
    $sitemap_url_entry .= "<lastmod>%s</lastmod>\n";
    $sitemap_url_entry .= "<changefreq>%s</changefreq>\n";
    $sitemap_url_entry .= "</url>\n";

    // Footer for the sitemap file.
    $sitemap_footer = "</urlset>";

    // Sitemap file count
    $sitemap_file_count = 1;

    // Forum URL
    $forum_location = htmlentities_array(html_get_forum_uri());

    // Check that search engine spidering is enabled
    if (forum_get_setting('allow_search_spidering', 'N')) return false;

    // Check that the sitemap setting is enabled.
    if (forum_get_setting('sitemap_enabled', 'N')) return false;

    // Fetch the sitemap path.
    if (!$sitemap_path = sitemap_get_dir()) return false;

    // Get the sitemap update frequencey (default: 24 hours)
    $sitemap_freq = forum_get_setting('sitemap_freq', null, DAY_IN_SECONDS);

    // Clear the stat cache so we don't get any stale results.
    clearstatcache();

    // Check that the file is older than the update frequency.
    if (@file_exists("$sitemap_path/sitemap.xml")) {

        if ((@$file_modified = filemtime("$sitemap_path/sitemap.xml"))) {

            if ((time() - $file_modified) < $sitemap_freq) return false;
        }
    }

    // Number of bytes written to file
    $bytes_written = 0;

    // Open the index file for writing.
    if (!(@$fp_index = fopen("{$sitemap_path}/sitemap.xml", 'w'))) return false;

    // Write the sitemap index header to the index file
    fwrite($fp_index, $sitemap_index_header);

    // Open the sitemap file for writing.
    if (!(@$fp = fopen("{$sitemap_path}/sitemap{$sitemap_file_count}.xml", 'w'))) return false;

    // Write the header to the file
    $bytes_written += fwrite($fp, $sitemap_header);

    // Query the database to find available forums.
    if (!($result_forums = sitemap_get_available_forums())) return false;

    // Iterate over each of the forums.
    while (($forum_data = $result_forums->fetch_assoc()) !== null) {

        // Get the MySQL result set for the current forum's threads.
        if (!($result_threads = sitemap_forum_get_threads($forum_data['FID']))) return false;

        // Iterate over the threads and add them to the sitemap file.
        while (($thread_data = $result_threads->fetch_assoc()) !== null) {

            $thread_last_modified = date(MYSQL_DATE, $thread_data['MODIFIED']);

            if ($thread_last_modified < time() - (90 * DAY_IN_SECONDS)) {

                $change_frequency = "yearly";

            } else if ($thread_last_modified < time() - (30 * DAY_IN_SECONDS)) {

                $change_frequency = "monthly";

            } else if ($thread_last_modified < time() - (4 * DAY_IN_SECONDS)) {

                $change_frequency = "weekly";

            } else {

                $change_frequency = "daily";
            }

            // Generate the sitemap entry and write it to the file.
            $sitemap_entry = sprintf($sitemap_url_entry, $forum_location, $forum_data['WEBTAG'], $thread_data['TID'], $thread_last_modified, $change_frequency);

            // If the sitemap file is going to be larger than the 10MB max file size
            // We need to close the current file and open the next in sequence.
            if ($bytes_written + ((mb_strlen($sitemap_entry) + mb_strlen($sitemap_footer))) >= 10000000) {

                // Write the footer to the file
                fwrite($fp, $sitemap_footer);

                // Close the file
                fclose($fp);

                // Generate an index entry
                $sitemap_index = sprintf($sitemap_index_entry, $forum_location, $sitemap_file_count, date(MYSQL_DATE));

                // Write that to the index file.
                fwrite($fp_index, $sitemap_index);

                // Next sitemap file.
                $sitemap_file_count++;

                // Reset the written byte count
                $bytes_written = 0;

                // Try and open the file. If we fail write the footer to the index file, close and return false.
                if (!@$fp = fopen("{$sitemap_path}/sitemap{$sitemap_file_count}.xml", 'w')) {

                    fwrite($fp_index, $sitemap_index_footer);

                    fclose($fp_index);

                    return false;
                }
            }

            $bytes_written += fwrite($fp, $sitemap_entry);
        }
    }

    // Write the footer to the file
    fwrite($fp, $sitemap_footer);

    // Close the file
    fclose($fp);

    // Generate an index entry
    $sitemap_index = sprintf($sitemap_index_entry, $forum_location, $sitemap_file_count, date(MYSQL_DATE));

    // Write that to the index file.
    fwrite($fp_index, $sitemap_index);

    // Write the footer
    fwrite($fp_index, $sitemap_index_footer);

    // Close the file.
    fclose($fp_index);

    // Hurrah!
    return true;
}