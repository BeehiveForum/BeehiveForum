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

/* $Id: gzipenc.inc.php,v 1.17 2003-09-15 17:41:47 decoyduck Exp $ */

// Compresses the output of the PHP scripts to save bandwidth.

require_once('./include/config.inc.php');

function bh_script_start()
{
    static $start_time = false;
    if (!$start_time) $start_time = microtime();
    return $start_time;
}

function bh_script_stop()
{
    static $stop_time = false;
    if (!$stop_time) $stop_time = microtime();
    return $stop_time;
}

function bh_calculate_elapsed_time()
{
    static $elapsed_time = false;

    if ($elapsed_time) {
        return $elapsed_time;
    }else {

        $start_time = bh_script_start();
        $stop_time  = bh_script_stop();

        $start_u = substr($start_time, 0, 10);
        $start_s = substr($start_time, 11, 10);

        $stop_u = substr($stop_time, 0, 10);
        $stop_s = substr($stop_time, 11, 10);

        $start_total = doubleval($start_u) + $start_s;
        $stop_total  = doubleval($stop_u)  + $stop_s;

        $elapsed_time = round($stop_total  -  $start_total, 5);
        return $elapsed_time;
    }
}

function bh_check_gzip()
{
    global $HTTP_SERVER_VARS, $gzip_compress_output;

    // check that no headers have already been sent
    // and that gzip compression is actually enabled.

    if (headers_sent() || $gzip_compress_output == false) {
        return false;
    }

    // Only enable gzip compression for HTTP/1.1 and
    // browsers that aren't coming via a proxy server.

    if (isset($HTTP_SERVER_VARS['HTTP_VIA'])) return false;
    if (strpos($HTTP_SERVER_VARS['SERVER_PROTOCOL'], 'HTTP/1.0') !== false) return false;

    // determine which gzip encoding the client asked for
    // (x-gzip = IE; gzip = everything else).

    if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip";
    if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) return "gzip";

    // if everything else false prevent
    // compression just to be safe.

    return false;
}

function bh_gzhandler($contents)
{
    global $gzip_compress_level, $query_count, $script_start;

    // check the compression level variable
    if (!isset($gzip_compress_level)) $gzip_compress_level = 1;
    if ($gzip_compress_level > 9) $gzip_compress_level = 9;
    if ($gzip_compress_level < 1) $gzip_compress_level = 1;

    // work out how long it took the script to execute

    bh_script_stop();
    $script_time = bh_calculate_elapsed_time();

    // Change the comments to their literal string values

    /* -- Removed due to problems

    $contents = str_replace("<!-- bh_query_count //-->", $query_count, $contents);
    $contents = str_replace("<!-- bh_script_time //-->", $script_time, $contents);

    */

    // check that the encoding is possible.
    // and fetch the client's encoding method.
    if ($encoding = bh_check_gzip()) {

        //$contents = str_replace("<!-- bh_content_encoding //-->", "GZIP&nbsp;Enabled", $contents);

        // do the compression
        if ($gz_contents = gzcompress($contents, $gzip_compress_level)) {

            // generate the error checking bits
            $size  = strlen($contents);
            $crc32 = crc32($contents);

            // construct the gzip output with header
            // and error checking bits
            $ret = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
            $ret.= substr($gz_contents, 0, strlen($gz_contents) - 4);
            $ret.= pack('V', $crc32);
            $ret.= pack('V', $size);

            // get the length of the compressed page
            $length = strlen($ret);

            // sends the headers to the client while making
            // sure they are only sent once.
            header("Content-Encoding: $encoding", true);
            header("Vary: Accept-Encoding", true);
            header("Content-Length: $length", true);

            // return the compressed text to PHP.
            return $ret;

        }else {

            // compression failed so return uncompressed string
            return $contents;

        }

    }else {

        // $contents = str_replace("<!-- bh_content_encoding //-->", "GZIP&nbsp;Disabled", $contents);

        // return the text uncompressed as the client
        // doesn't support it or it has been disabled
        // in config.inc.php.
        return $contents;

    }
}

// Start the clock ticking
bh_script_start();

// Enabled the gzip handler
ob_start("bh_gzhandler");
ob_implicit_flush(0);

?>