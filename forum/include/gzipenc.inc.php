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

/* $Id: gzipenc.inc.php,v 1.42 2005-03-29 10:47:33 decoyduck Exp $ */

function bh_check_gzip()
{
    global $gzip_compress_output;

    // check that no headers have already been sent
    // and that gzip compression is actually enabled.

    if (headers_sent()) {
        return false;
    }

    if (isset($gzip_compress_output) && $gzip_compress_output === false) {
        return false;
    }

    // Only enable gzip compression for HTTP/1.1 and
    // browsers that aren't coming via a proxy server.

    if (isset($_SERVER['HTTP_VIA'])) return false;

    if (isset($_SERVER['SERVER_PROTOCOL'])) {
        if (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTP/1.0') !== false) return false;
    }

    // determine which gzip encoding the client asked for
    // (x-gzip = IE; gzip = everything else).

    if (!isset($_SERVER['HTTP_ACCEPT_ENCODING'])) return false;

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip";
    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) return "gzip";

    // if everything else false prevent
    // compression just to be safe.

    return false;
}

function bh_gzhandler($contents)
{
    global $gzip_compress_level;

    // check the compression level variable is set

    if (!isset($gzip_compress_level)) $gzip_compress_level = 1;

    // check to make sure it is in range;

    if ($gzip_compress_level > 9) $gzip_compress_level = 9;
    if ($gzip_compress_level < 1) $gzip_compress_level = 1;

    // check that the encoding is possible.
    // and fetch the client's encoding method.

    if ($encoding = bh_check_gzip()) {

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

            // get the length of the un-compressed page

            $length = strlen($contents);

            // sends the headers to the client while making
            // sure they are only sent once.

            header("Content-Length: $length", true);

            // return the un-compressed text to PHP.

            return $contents;
        }

    }else {

        // return the text uncompressed as the client
        // doesn't support it or it has been disabled
        // in config.inc.php.

        // get the length of the un-compressed page

        $length = strlen($contents);

        // sends the headers to the client while making
        // sure they are only sent once.

        header("Content-Length: $length", true);

        // return the un-compressed text to PHP.

        return $contents;
    }
}

// Enabled the gzip handler
@ob_end_clean();
ob_start("bh_gzhandler");
ob_implicit_flush(0);

?>