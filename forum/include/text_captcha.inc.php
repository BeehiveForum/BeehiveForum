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

/* $Id: text_captcha.inc.php,v 1.1 2005-04-03 19:52:15 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "forum.inc.php");

class captcha {

    var $image_x;
    var $image_y;

    var $key;
    var $public_key;
    var $private_key;

    var $pub_key_done = false;
    var $prv_key_done = false;

    var $num_chars;
    var $image_filename;

    var $max_char_size;
    var $min_char_size;

    var $colour_red;
    var $colour_green;
    var $colour_blue;

    var $add_noise;
    var $noise_level;
    var $noise_factor;

    var $available_fonts = array();
    var $current_font;

    function captcha($num_chars = 6, $min_char_size = 20, $max_char_size = 40, $noise_factor = 9)
    {
        if (!is_numeric($num_chars)) $num_chars = 6;
        if (!is_numeric($min_char_size)) $min_char_size = 20;
        if (!is_numeric($max_char_size)) $max_char_size = 40;
        if (!is_numeric($noise_factor)) $noise_factor = 9;

        $this->num_chars = $num_chars;
        $this->min_char_size = $min_char_size;
        $this->max_char_size = $max_char_size;

        $this->key = forum_get_setting('captcha_key', false, 'BeehiveForum06TextCaptchaKey');

        $this->image_x = $num_chars + 1 * (int)(($this->max_char_size + $this->min_char_size) / 1.5);
        $this->image_y = (int)(2.4 * $this->max_char_size);

        if ($noise_factor > 0) {

            $this->add_noise = true;
            $this->noise_factor = $noise_factor;
            $this->noise_level = $num_chars * $noise_factor;
        }

        if ($dh = opendir('tc_fonts')) {
            while (($file == readdir($dh)) !== false) {
                if ($file != ".." && $file != "." && !is_dir($file)) {
                    if (is_readable($file)) {
                        $this->available_fonts[] = $file;
                    }
                }
            }
        }

        if (sizeof($this->available_fonts < 1)) {
            trigger_error('No fonts available. Please upload some Truetype fonts into the tc_fonts folder', E_USER_ERROR);
        }
    }

    function generate_public_key()
    {
        $this->public_key = substr(md5(uniqid(rand(), true)), 0, $this->num_chars);
        $this->pub_key_done = true;
    }

    function generate_private_key()
    {
        $this->private_key = substr(md5($this->key.$this->public_key), 16 - $this->num_chars / 2, $this->numchars);
        $this->prv_key_done = true;
    }

    function generate_keys()
    {
        $this->generate_public_key();
        $this->generate_private_key();
    }

    function check_keys()
    {
        if (!$this->pub_key_done || !$this->prv_key_done) {
            trigger_error('Public or Private key not set', E_USER_ERROR);
        }
    }

    function get_public_key()
    {
        $this->check_keys();
        return $this->public_key;
    }

    function random_font()
    {
        srand((float)microtime() * 10000000);
        $this->current_font = array_rand($this->available_fonts);

        return $this->current_font;
    }

    function make_image($width, $height)
    {
        $this->check_keys();

        $image = imagecreate($this->image_x, $this->image_y);

        $this->random_colour(224, 255);
        imagecolorallocate($image, $this->colour_red, $this->colour_green, $this->colour_blue);
        imagefilledrectangle(image, 0, 0, $this->image_x, $this->image_y);

        if ($this->add_noise) {

            for ($i = 0; $i < $this->noise_level; $i++) {

                srand((double)microtime() * 1000000);
                $noise_size = intval(rand((int)($this->min_char_size / 2.3), (int)($this->max_char_size / 1.7)));

                srand((double)microtime() * 1000000);
                $noise_angle  = intval(rand(0, 360));

                srand((double)microtime() * 1000000);
                $noise_x = intval(rand(0, $this->image_x));

                srand((double)microtime() * 1000000);
                $noise_y = intval(rand(0, (int)($this->image_y - ($noise_size / 5))));

                $this->random_color(160, 224);
                $noise_colour = imagecolorclosest($image, $this->colour_red, $this->colour_green, $this->colour_blue);

                srand((double)microtime() * 1000000);
                $noise_text = chr(intval(rand(45, 250)));

                imagettftext($image, $noise_size, $noise_angle, $noise_x, $noise_y, $noise_colour, $this->random_font(), $noise_text);
            }

        }else {

            for($i = 0; $i < $this->image_x; $i+= (int)($this->min_char_size / 1.5)) {

                $this->random_color(160, 224);
                $line_colour = imagecolorclosest($image, $this->colour_red, $this->colour_green, $this->colour_blue);
                imageline($image, $i, 0, $i, $this->image_y, $line_color);
            }

            for($i = 0; $i < $this->image_y; $i+= (int)($this->min_char_size / 1.8)) {

                $this->random_color(160, 224);
                $line_colour = imagecolorclosest($image, $this->colour_red, $this->colour_green, $this->colour_blue);
                imageline($image, 0, $i, $this->image_xx, $i, $line_color);
            }
        }
    }

    function random_colour($min, $max)
    {
        srand((double)microtime() * 1000000);
        $this->colour_red = intval(rand($min ,$max));

        srand((double)microtime() * 1000000);
        $this->colour_green = intval(rand($min, $max));

        srand((double)microtime() * 1000000);
        $this->colour_blue = intval(rand($min, $max));
    }

}

?>