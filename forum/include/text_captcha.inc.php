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

/* $Id: text_captcha.inc.php,v 1.10 2005-07-23 22:53:35 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "gd_lib.inc.php");

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

    var $max_rotation;

    var $color_red;
    var $color_green;
    var $color_blue;

    var $noise_level;
    var $noise_factor;

    var $fonts_loaded = false;
    var $available_fonts = array();
    var $current_font;

    var $error = false;
    var $text_captcha_dir = "";

    // PUBLIC //

    function captcha($num_chars = 6, $min_char_size = 15, $max_char_size = 25, $noise_factor = 9, $max_rotation = 30)
    {
        if (!is_numeric($num_chars)) $num_chars = 6;
        if (!is_numeric($min_char_size)) $min_char_size = 20;
        if (!is_numeric($max_char_size)) $max_char_size = 40;
        if (!is_numeric($noise_factor)) $noise_factor = 9;
        if (!is_numeric($max_rotation)) $max_rotation = 30;

        $this->num_chars = $num_chars;
        $this->min_char_size = $min_char_size;
        $this->max_char_size = $max_char_size;

        $this->max_rotation = $max_rotation;

        $this->key = md5(forum_get_setting('text_captcha_key', false, md5(uniqid(rand()))));

        $this->image_x = ($num_chars + 1) * (int)(($this->max_char_size + $this->min_char_size) / 1.5);
        $this->image_y = (int)(2.4 * $this->max_char_size);

        if ($noise_factor > 0) {

            $this->noise_factor = $noise_factor;
            $this->noise_level = $num_chars * $noise_factor;

        }else {

            $this->noise_factor = 0;
            $this->noise_level = 0;
        }
    }

    function set_public_key($public_key)
    {
        $this->public_key = $public_key;
        $this->pub_key_done = true;
    }

    function verify_keys($private_key_check)
    {
        if (file_exists($this->get_image_filename())) {
            @unlink($this->get_image_filename());
        }

        $this->generate_private_key();
        return (strtolower($private_key_check) == strtolower($this->private_key));
    }

    function get_image_filename()
    {
        if (!$this->check_keys()) {
            return false;
        }

        if (!$this->check_working_dir()) {
            return false;
        }

        return "{$this->text_captcha_dir}/images/{$this->public_key}.jpg";
    }

    function get_num_chars()
    {
        return $this->num_chars;
    }

    function get_public_key()
    {
        $this->check_keys();
        return $this->public_key;
    }

    function get_error()
    {
        return $this->error;
    }

    function make_image()
    {
        if (!$this->check_keys()) {
            return false;
        }

        $this->load_fonts();

        if (sizeof($this->available_fonts) < 1) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        if (!$this->check_working_dir()) {
            return false;
        }

        if ($text_captcha_gd_info = get_gd_info()) {

            if ($text_captcha_gd_info['GD Version'] !== false && $text_captcha_gd_info['FreeType Support'] > 0) {

                $image = imagecreate($this->image_x, $this->image_y);
                $this->allocate_colours($image);

                $this->random_color(224, 255);
                $color = imagecolorallocate($image, $this->color_red, $this->color_green, $this->color_blue);
                imagefilledrectangle($image, 0, 0, $this->image_x, $this->image_y, $color);

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
                    $noise_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    srand((double)microtime() * 1000000);
                    $noise_text = chr(intval(rand(45, 250)));

                    imagettftext($image, $noise_size, $noise_angle, $noise_x, $noise_y, $noise_color, $this->random_font(), $noise_text);
                }

                for($i = 0; $i < $this->image_x; $i+= (int)($this->min_char_size / 1.5)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, $i, 0, $i, $this->image_y, $line_color);
                }

                for($i = 0; $i < $this->image_y; $i+= (int)($this->min_char_size / 1.8)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, 0, $i, $this->image_x, $i, $line_color);
                }

                for($i = 0, $text_x = intval(rand($this->min_char_size,$this->max_char_size)); $i < $this->num_chars; $i++) {

                    $text = strtoupper(substr($this->private_key, $i, 1));

                    srand((double)microtime() * 1000000);
                    $text_angle = intval(rand(($this->max_rotation * -1), $this->max_rotation));

                    srand((double)microtime() * 1000000);
                    $text_size = intval(rand($this->min_char_size, $this->max_char_size));

                    srand((double)microtime() * 1000000);
                    $text_y = intval(rand((int)($text_size * 1.5), (int)($this->image_y - ($text_size / 7))));

                    $this->random_color(0, 127);
                    $color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    $this->random_color(0, 127);
                    $shadow = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    imagettftext($image, $text_size, $text_angle, $text_x + (int)($text_size / 15), $text_y, $shadow, $this->random_font(), $text);
                    imagettftext($image, $text_size, $text_angle, $text_x, $text_y - (int)($text_size / 15), $color, $this->get_current_font(), $text);

                    $text_x += (int)($text_size + ($this->min_char_size / 5));
                }

                @imagejpeg($image, $this->get_image_filename());
                return @file_exists($this->get_image_filename());

            }else {

                $this->error = TEXT_CAPTCHA_GD_ERROR;
                return false;
            }
        }

        return false;
    }

    // PRIVATE //

    function check_working_dir()
    {
        if ($text_captcha_dir = forum_get_setting('text_captcha_dir')) {

            if (!@is_dir("$text_captcha_dir")) {

                @mkdir("$text_captcha_dir", 0755);
                @chmod("$text_captcha_dir", 0777);
            }

            if (!@is_dir("$text_captcha_dir/fonts")) {

                @mkdir("$text_captcha_dir/fonts", 0755);
                @chmod("$text_captcha_dir/fonts", 0777);
            }

            if (!@is_dir("$text_captcha_dir/images")) {

                @mkdir("$text_captcha_dir/images", 0755);
                @chmod("$text_captcha_dir/images", 0777);
            }

            if (@is_dir("$text_captcha_dir/fonts") && @is_dir("$text_captcha_dir/images")) {

                if (is_writable("$text_captcha_dir/images")) {

                    $this->text_captcha_dir = $text_captcha_dir;
                    return true;
                }
            }
        }

        $this->error = TEXT_CAPTCHA_DIR_ERROR;
        return false;
    }

    function load_fonts()
    {
        if (!$this->check_working_dir()) {
            return false;
        }

        if (!$this->fonts_loaded) {

            if ($dh = opendir("{$this->text_captcha_dir}/fonts")) {

                while (($file = readdir($dh)) !== false) {

                    if ($file != ".." && $file != "." && !is_dir($file) && $this->is_font($file)) {

                        $this->available_fonts[] = $file;
                        $this->fonts_loaded = true;
                    }
                }
            }
        }
    }

    function is_font($file)
    {
        return (substr($file, -3) == 'ttf');
    }

    function generate_public_key()
    {
        $this->public_key = substr(md5(uniqid(rand(), true)), 0, $this->num_chars);
        $this->pub_key_done = true;
    }

    function generate_private_key()
    {
        if (!$this->pub_key_done) {

            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        $this->private_key = substr(md5($this->key.$this->public_key), 16 - $this->num_chars / 2, $this->num_chars);
        $this->prv_key_done = true;
    }

    function generate_keys()
    {
        $this->generate_public_key();
        $this->generate_private_key();

        return ($this->pub_key_done && $this->prv_key_done);
    }

    function check_keys()
    {
        if (!$this->pub_key_done || !$this->prv_key_done) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return true;
    }

    function random_font()
    {
        $this->load_fonts();

        srand((float)microtime() * 10000000);
        $this->current_font = $this->available_fonts[array_rand($this->available_fonts)];

        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }

    function get_current_font()
    {
        $this->load_fonts();
        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }

    function allocate_colours(&$image)
    {
        for($red = 0; $red <= 255; $red += 51) {

            for($green = 0; $green <= 255; $green += 51) {

                for($blue = 0; $blue <= 255; $blue += 51) {

                    $color = imagecolorallocate($image, $red, $green, $blue);
                }
            }
        }
    }

    function random_color($min, $max)
    {
        srand((double)microtime() * 1000000);
        $this->color_red = intval(rand($min ,$max));

        srand((double)microtime() * 1000000);
        $this->color_green = intval(rand($min, $max));

        srand((double)microtime() * 1000000);
        $this->color_blue = intval(rand($min, $max));
    }

}

?>