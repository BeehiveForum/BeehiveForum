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

// Compresses the output of the PHP scripts to save bandwidth.

require_once('./include/config.inc.php');

function bh_check_gzip()
{
    global $HTTP_SERVER_VARS, $gzip_compress_output;

    // check that no headers have already been sent
    // and that gzip compression is actually enabled.

    if (headers_sent() || $gzip_compress_output == false) {
        return false;
    }

    // Skip gzip compression if the browser/proxy reports it is HTTP/1.0
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
    global $gzip_compress_level;

    // check the compression level variable
    if (!isset($gzip_compress_level)) $gzip_compress_level = 1;
    if ($gzip_compress_level > 9) $gzip_compress_level = 9;
    if ($gzip_compress_level < 1) $gzip_compress_level = 1;

    // check that the encoding is possible.
    // and fetch the client's encoding method.
    if ($encoding = bh_check_gzip()) {

        // for debugging: add a HTML comment to the bottom of the page.
        $contents.= "<!-- bh_gzhandler: $encoding enabled (level: $gzip_compress_level) //-->\n";

        // do the compression
        if ($gz_contents = gzcompress($contents, $gzip_compress_level)) {

            // generate the error checking bits
            $size      = strlen($contents);
            $crc32     = crc32($contents);

            // send the headers to the client
            header("Etag: VT$crc32");
            header("Content-Encoding: $encoding");

            // construct the gzip output with gz headers and error checking bits
            $ret = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
            $ret.= substr($gz_contents, 0, strlen($gz_contents) - 4);
            $ret.= pack('V', $crc32);
            $ret.= pack('V', $size);

            // return the compressed text to PHP.
            return $ret;

        }else {

            // compression failed so add additional
            // debug message and return uncompressed string
            $contents.= "<!-- bh_gzhander: failed during compression //-->\n";
            return $contents;

        }

    }else {

        // for debugging: add a HTML comment to the bottom of the page.
        $contents.= "<!-- bh_gzhandler: compression disabled //-->\n";

        // return the text uncompressed as the client
        // doesn't support it or it has been disabled
        // in config.inc.php.
        return $contents;

    }
}

// Enabled the gzip handler
ob_start("bh_gzhandler");

?>