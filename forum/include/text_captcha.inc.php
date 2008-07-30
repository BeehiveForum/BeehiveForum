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

/* $Id: text_captcha.inc.php,v 1.31 2008-07-30 17:41:41 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "gd_lib.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

        $this->key = forum_get_setting('text_captcha_key', false, '');

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

    function generate_keys()
    {
        if (!$this->generate_public_key() || !$this->generate_private_key()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return true;
    }

    function verify_keys($private_key_check)
    {
        $this->generate_private_key();
        return (strtolower($private_key_check) == strtolower($this->private_key));
    }

    function get_image_filename()
    {
        if (!$this->check_working_dir()) {
            $this->error = TEXT_CAPTCHA_DIR_ERROR;
            return false;
        }

        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return "text_captcha/images/{$this->public_key}.jpg";
    }


    function get_num_chars()
    {
        return $this->num_chars;
    }

    function get_public_key()
    {
        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return $this->public_key;
    }

    function get_error()
    {
        return $this->error;
    }

    function make_image()
    {
        if (!$this->check_working_dir()) {
            $this->error = TEXT_CAPTCHA_DIR_ERROR;
            return false;
        }

        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        if (($text_captcha_gd_info = get_gd_info())) {

            if ($text_captcha_gd_info['GD Version'] !== false && $text_captcha_gd_info['FreeType Support'] > 0) {

                $image = imagecreate($this->image_x, $this->image_y);
                $this->allocate_colours($image);

                $this->random_color(224, 255);
                $color = imagecolorallocate($image, $this->color_red, $this->color_green, $this->color_blue);
                imagefilledrectangle($image, 0, 0, $this->image_x, $this->image_y, $color);

                for ($i = 0; $i < $this->noise_level; $i++) {

                    $noise_size = intval(mt_rand((int)($this->min_char_size / 2.3), (int)($this->max_char_size / 1.7)));

                    $noise_angle  = intval(mt_rand(0, 360));

                    $noise_x = intval(mt_rand(0, $this->image_x));

                    $noise_y = intval(mt_rand(0, (int)($this->image_y - ($noise_size / 5))));

                    $this->random_color(160, 224);

                    $noise_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    $noise_text = chr(intval(mt_rand(45, 250)));

                    if (!@imagettftext($image, $noise_size, $noise_angle, $noise_x, $noise_y, $noise_color, $this->random_font(), $noise_text)) {

                        $this->error = TEXT_CAPTCHA_FONT_ERROR;
                        return false;
                    }
                }

                for ($i = 0; $i < $this->image_x; $i+= (int)($this->min_char_size / 1.5)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, $i, 0, $i, $this->image_y, $line_color);
                }

                for ($i = 0; $i < $this->image_y; $i+= (int)($this->min_char_size / 1.8)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, 0, $i, $this->image_x, $i, $line_color);
                }

                for ($i = 0, $text_x = intval(mt_rand($this->min_char_size,$this->max_char_size)); $i < $this->num_chars; $i++) {

                    $text = strtoupper(substr($this->private_key, $i, 1));

                    $text_angle = intval(mt_rand(($this->max_rotation * -1), $this->max_rotation));

                    $text_size = intval(mt_rand($this->min_char_size, $this->max_char_size));

                    $text_y = intval(mt_rand((int)($text_size * 1.5), (int)($this->image_y - ($text_size / 7))));

                    $this->random_color(0, 127);
                    $color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    $this->random_color(0, 127);
                    $shadow = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    if (!@imagettftext($image, $text_size, $text_angle, $text_x + (int)($text_size / 15), $text_y, $shadow, $this->random_font(), $text)) {

                        $this->error = TEXT_CAPTCHA_FONT_ERROR;
                        return false;
                    }

                    if (!@imagettftext($image, $text_size, $text_angle, $text_x, $text_y - (int)($text_size / 15), $color, $this->get_current_font(), $text)) {

                        $this->error = TEXT_CAPTCHA_FONT_ERROR;
                        return false;
                    }

                    $text_x += (int)($text_size + ($this->min_char_size / 5));
                }

                imagejpeg($image, $this->get_image_filename());
                return file_exists($this->get_image_filename());
            }
        }

        $this->error = TEXT_CAPTCHA_GD_ERROR;
        return false;
    }

    function destroy_image()
    {
        if (@file_exists($this->get_image_filename())) {
            @unlink($this->get_image_filename());
        }
    }

    // PRIVATE //

    function check_working_dir()
    {
        $forum_directory = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR);
        $text_captcha_dir = $forum_directory. DIRECTORY_SEPARATOR. 'text_captcha';

        mkdir_recursive("$text_captcha_dir/fonts", 0755);
        mkdir_recursive("$text_captcha_dir/images", 0755);

        if (@is_dir("$text_captcha_dir/fonts") && @is_dir("$text_captcha_dir/images")) {

            if (is_writable("$text_captcha_dir/images")) {

                $this->text_captcha_dir = $text_captcha_dir;
                return true;
            }
        }

        return false;
    }

    function load_fonts()
    {
        if (!$this->fonts_loaded) {

            if ((@$dir = opendir("{$this->text_captcha_dir}/fonts"))) {

                while (($file = readdir($dir)) !== false) {

                    if ($file != ".." && $file != "." && !is_dir($file) && $this->is_font($file)) {

                        $this->available_fonts[] = $file;
                        $this->fonts_loaded = true;
                    }
                }
            }
        }

        return $this->fonts_loaded;
    }

    function is_font($file)
    {
        return (substr($file, -3) == 'ttf');
    }

    function generate_public_key()
    {
        $this->public_key = substr(md5(uniqid(mt_rand(), true)), 0, $this->num_chars);
        $this->pub_key_done = true;

        return true;
    }

    function generate_private_key()
    {
        if (!$this->pub_key_done) {
            return false;
        }

        $this->private_key = substr(md5($this->key.$this->public_key), 16 - $this->num_chars / 2, $this->num_chars);
        $this->prv_key_done = true;

        return true;
    }

    function check_keys()
    {
        if (!$this->pub_key_done || !$this->prv_key_done) {
            return false;
        }

        return true;
    }

    function random_font()
    {
        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        $this->current_font = $this->available_fonts[array_rand($this->available_fonts)];

        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }

    function get_current_font()
    {
        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }

    function allocate_colours(&$image)
    {
        for ($red = 0; $red <= 255; $red += 51) {

            for ($green = 0; $green <= 255; $green += 51) {

                for ($blue = 0; $blue <= 255; $blue += 51) {

                    imagecolorallocate($image, $red, $green, $blue);
                }
            }
        }
    }

    function random_color($min, $max)
    {
        $this->color_red = intval(mt_rand($min ,$max));

        $this->color_green = intval(mt_rand($min, $max));

        $this->color_blue = intval(mt_rand($min, $max));
    }
}

function captcha_clean_up()
{
    $unlink_count = 0;

    $forum_directory = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR);

    $text_captcha_dir = $forum_directory. DIRECTORY_SEPARATOR. 'text_captcha';

    if ((@$dir = opendir($text_captcha_dir. DIRECTORY_SEPARATOR. "images"))) {

        while ((($file = @readdir($dir)) !== false) && $unlink_count < 10) {

            $unlink_count++;

            $captcha_image_file = "$text_captcha_dir/images/$file";

            if (($file != "." && $file != ".." && !is_dir($captcha_image_file))) {

                if (filemtime($captcha_image_file) < (time() - DAY_IN_SECONDS)) {

                    @unlink($captcha_image_file);
                }
            }
        }

        return true;
    }

    return false;
}

?>