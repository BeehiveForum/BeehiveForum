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

/* $Id: zip_lib.inc.php,v 1.5 2008-07-28 21:05:56 decoyduck Exp $ */

/**
* zip_lib.inc.php - Zip Creation Class Library
*
* Taken from phpMyAdmin 2.6.4.
*
* Zip file creation class.
* Makes zip files.
*
* Based on :
*
*  http://www.zend.com/codex.php?id=535&single=1
*  By Eric Mueller <eric@themepark.com>
*
*  http://www.zend.com/codex.php?id=470&single=1
*  by Denis125 <webmaster@atlant.ru>
*
*  a patch from Peter Listiak <mlady@users.sourceforge.net> for last modified
*  date and time of the compressed file
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

class zip_file
{
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;

    function unix2dostime($unixtime = 0)
    {

        $timearray = (!is_numeric($unixtime) || $unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {

            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        }

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    }

    function add_file($data, $name, $time = 0)
    {

        $name     = str_replace('\\', '/', $name);

        $dtime    = dechex($this->unix2dostime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];

        eval('$hexdtime = "' . $hexdtime . '";');

        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";
        $fr   .= "\x00\x00";
        $fr   .= "\x08\x00";
        $fr   .= $hexdtime;

        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);
        $fr      .= pack('V', $c_len);
        $fr      .= pack('V', $unc_len);
        $fr      .= pack('v', strlen($name));
        $fr      .= pack('v', 0);
        $fr      .= $name;
        $fr      .= $zdata;

        $this -> datasec[] = $fr;

        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x14\x00";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x08\x00";
        $cdrec .= $hexdtime;
        $cdrec .= pack('V', $crc);
        $cdrec .= pack('V', $c_len);
        $cdrec .= pack('V', $unc_len);
        $cdrec .= pack('v', strlen($name));
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('V', 32 );

        $cdrec .= pack('V', $this -> old_offset );
        $this -> old_offset += strlen($fr);

        $cdrec .= $name;

        $this -> ctrl_dir[] = $cdrec;
    }

    function output_zip()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);

        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .
            pack('v', sizeof($this -> ctrl_dir)) .
            pack('V', strlen($ctrldir)) .
            pack('V', strlen($data)) .
            "\x00\x00";
    }

}

?>