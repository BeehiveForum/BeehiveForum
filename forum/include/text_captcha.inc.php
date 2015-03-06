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
require_once BH_INCLUDE_PATH . 'forum.inc.php';
// End Required includes

class captcha
{

    private $image_x;
    private $image_y;

    private $key;
    private $public_key;
    private $private_key;

    private $pub_key_done = false;
    private $prv_key_done = false;

    private $num_chars;

    private $max_char_size;
    private $min_char_size;

    private $max_rotation;

    private $color_red;
    private $color_green;
    private $color_blue;

    private $noise_level;
    private $noise_factor;

    private $fonts_loaded = false;
    private $available_fonts = array();
    private $current_font;

    private $error = false;
    private $text_captcha_dir = false;

    public function __construct($num_chars = 6, $min_char_size = 15, $max_char_size = 25, $noise_factor = 9, $max_rotation = 30)
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

        $this->key = forum_get_setting('text_captcha_key');

        $this->image_x = ($num_chars + 1) * (int)(($this->max_char_size + $this->min_char_size) / 1.5);
        $this->image_y = (int)(2.4 * $this->max_char_size);

        if (($text_captcha_dir = forum_get_setting('text_captcha_dir', 'strlen', false)) !== false) {
            $this->text_captcha_dir = rtrim($text_captcha_dir, '/');
        }

        if ($noise_factor > 0) {

            $this->noise_factor = $noise_factor;
            $this->noise_level = $num_chars * $noise_factor;

        } else {

            $this->noise_factor = 0;
            $this->noise_level = 0;
        }
    }

    public function set_public_key($public_key)
    {
        $this->public_key = $public_key;
        $this->pub_key_done = true;
    }

    public function generate_keys()
    {
        if (!$this->generate_public_key() || !$this->generate_private_key()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return true;
    }

    protected function generate_public_key()
    {
        $this->public_key = mb_substr(md5(uniqid(mt_rand(), true)), 0, $this->num_chars);
        $this->pub_key_done = true;

        return true;
    }

    protected function generate_private_key()
    {
        if (!$this->pub_key_done) {
            return false;
        }

        $this->private_key = mb_substr(md5($this->key . $this->public_key), 16 - $this->num_chars / 2, $this->num_chars);
        $this->prv_key_done = true;

        return true;
    }

    public function verify_keys($private_key_check)
    {
        $this->generate_private_key();
        return (mb_strtolower($private_key_check) == mb_strtolower($this->private_key));
    }

    public function get_num_chars()
    {
        return $this->num_chars;
    }

    public function get_private_key()
    {
        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return $this->private_key;
    }

    protected function check_keys()
    {
        if (!$this->pub_key_done || !$this->prv_key_done) {
            return false;
        }

        return true;
    }

    public function get_public_key()
    {
        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        return $this->public_key;
    }

    public function get_error()
    {
        return $this->error;
    }

    public function get_width()
    {
        return $this->image_x;
    }

    public function get_height()
    {
        return $this->image_y;
    }

    public function make_image()
    {
        if (!$this->check_keys()) {
            $this->error = TEXT_CAPTCHA_KEY_ERROR;
            return false;
        }

        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        if (function_exists('gd_info') && ($text_captcha_gd_info = gd_info())) {

            if ($text_captcha_gd_info['GD Version'] !== false && $text_captcha_gd_info['FreeType Support'] > 0) {

                $image = imagecreate($this->image_x, $this->image_y);
                $this->allocate_colours($image);

                $this->random_color(224, 255);
                $color = imagecolorallocate($image, $this->color_red, $this->color_green, $this->color_blue);
                imagefilledrectangle($image, 0, 0, $this->image_x, $this->image_y, $color);

                for ($i = 0; $i < $this->noise_level; $i++) {

                    $noise_size = intval(mt_rand((int)($this->min_char_size / 2.3), (int)($this->max_char_size / 1.7)));

                    $noise_angle = intval(mt_rand(0, 360));

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

                for ($i = 0; $i < $this->image_x; $i += (int)($this->min_char_size / 1.5)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, $i, 0, $i, $this->image_y, $line_color);
                }

                for ($i = 0; $i < $this->image_y; $i += (int)($this->min_char_size / 1.8)) {

                    $this->random_color(160, 224);
                    $line_color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);
                    imageline($image, 0, $i, $this->image_x, $i, $line_color);
                }

                for ($i = 0, $text_x = intval(mt_rand($this->min_char_size, $this->max_char_size)); $i < $this->num_chars; $i++) {

                    $text = mb_strtoupper(mb_substr($this->private_key, $i, 1));

                    $text_angle = intval(mt_rand(($this->max_rotation * -1), $this->max_rotation));

                    $text_size = intval(mt_rand($this->min_char_size, $this->max_char_size));

                    $text_y = intval(mt_rand((int)($text_size * 1.5), (int)($this->image_y - ($text_size / 7))));

                    $this->random_color(0, 127);
                    $color = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    $this->random_color(0, 127);
                    $shadow = imagecolorclosest($image, $this->color_red, $this->color_green, $this->color_blue);

                    if (!imagettftext($image, $text_size, $text_angle, $text_x + (int)($text_size / 15), $text_y, $shadow, $this->random_font(), $text)) {

                        $this->error = TEXT_CAPTCHA_FONT_ERROR;
                        return false;
                    }

                    if (!imagettftext($image, $text_size, $text_angle, $text_x, $text_y - (int)($text_size / 15), $color, $this->get_current_font(), $text)) {

                        $this->error = TEXT_CAPTCHA_FONT_ERROR;
                        return false;
                    }

                    $text_x += (int)($text_size + ($this->min_char_size / 5));
                }

                $image_filename = tempnam(sys_get_temp_dir(), 'bhtc');

                imagejpeg($image, $image_filename);

                return $image_filename;
            }
        }

        $this->error = TEXT_CAPTCHA_GD_ERROR;
        return false;
    }

    protected function check_working_dir()
    {
        if (!$this->text_captcha_dir) return false;

        if (@is_dir("{$this->text_captcha_dir}/fonts")) {
            return true;
        }

        return false;
    }

    protected function load_fonts()
    {
        if (!$this->text_captcha_dir) return false;

        if (!$this->fonts_loaded) {

            if ((@$dir = opendir("{$this->text_captcha_dir}/fonts"))) {

                while (($file = readdir($dir)) !== false) {

                    if ($file != ".." && $file != "." && !@is_dir($file) && $this->is_font($file)) {

                        $this->available_fonts[] = $file;
                        $this->fonts_loaded = true;
                    }
                }
            }
        }

        return $this->fonts_loaded;
    }

    protected function is_font($file)
    {
        return (mb_substr(mb_strtolower($file), -3) == 'ttf');
    }

    protected function allocate_colours(&$image)
    {
        for ($red = 0; $red <= 255; $red += 51) {

            for ($green = 0; $green <= 255; $green += 51) {

                for ($blue = 0; $blue <= 255; $blue += 51) {

                    imagecolorallocate($image, $red, $green, $blue);
                }
            }
        }
    }

    protected function random_color($min, $max)
    {
        $this->color_red = intval(mt_rand($min, $max));

        $this->color_green = intval(mt_rand($min, $max));

        $this->color_blue = intval(mt_rand($min, $max));
    }

    protected function random_font()
    {
        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        $this->current_font = $this->available_fonts[array_rand($this->available_fonts)];

        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }

    protected function get_current_font()
    {
        if (!$this->load_fonts()) {
            $this->error = TEXT_CAPTCHA_NO_FONTS;
            return false;
        }

        return "{$this->text_captcha_dir}/fonts/{$this->current_font}";
    }
}