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

/* $Id: lang.inc.php,v 1.48 2009-04-13 11:54:49 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

class lang
{
    private static $instance;
    
    private $user_pref;
    
    private $lang_cache;
    
    private $compat_mode = false;
  
    private function __construct()
    {
        // Default language file.
        
        $default_language = forum_get_setting('default_language', false, 'en');
               
        // Initialise the file cache
        
        $this->lang_cache = array();
        
        // Set the user's preferred language

        if (($pref_language = bh_session_get_value("LANGUAGE"))) {

            if (@is_dir(BH_INCLUDE_PATH. "languages/$pref_language")) {

                $this->user_pref = $pref_language;
                return;
            
            }else if (file_exists(BH_INCLUDE_PATH. "languages/{$pref_language}.inc.php")) {
            
                $this->user_pref = $pref_language;
                $this->compat_mode = true;
                return;
            }
        }
        
        // if the browser doesn't send an Accept-Language header, give up and use the default language.

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        
            $this->user_pref = $default_language;
            return;
        }

        // Split the provided Accept-Language string into individual languages

        $langs_array = preg_split('/\s*,\s*/u', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        // Work out what the 'q' values associated with each language are

        foreach ($langs_array as $key => $value) {

            if (strstr($value, ";q=")) {

                $bits = explode(";q=", $value);
                $langs_array[$key] = $bits[0];
                $qvalue[$key] = $bits[1];

            }else {

                $qvalue[$key] = 1;
            }
        }

        // Sort the array in descending order of q value

        arsort($qvalue);

        // Go through the array and use the first language installed that matches

        foreach ($qvalue as $key => $value) {

            if ($langs_array[$key] == "*") $langs_array[$key] = $default_language;

            if (@is_dir(BH_INCLUDE_PATH. "languages/{$langs_array[$key]}")) {

                $this->user_pref = $langs_array[$key];
                return;

            }else if (file_exists(BH_INCLUDE_PATH. "languages/{$langs_array[$key]}.inc.php")) {
            
                $this->user_pref = $langs_array[$key];
                $this->compat_mode = true;
                return;
            }
        }
        
        // If we're still here, no languages matched, try the default.
        
        if (@is_dir(BH_INCLUDE_PATH. "languages/$default_language")) {

            $this->user_pref = $default_language;
            return;

        }else if (file_exists(BH_INCLUDE_PATH. "languages/{$default_language}.inc.php")) {

            $this->user_pref = $default_language;
            $this->compat_mode = true;
            return;
        }
        
        // If we got this far then we can't continue!
        
        trigger_error('Could not load default language file', E_USER_ERROR);
    }
    
    public static function get_instance()
    {
        if (!is_object(self::$instance)) {
            
            $class = __CLASS__;
            self::$instance = new $class();
        }
        
        return self::$instance;
    }
    
    public function load($filename)
    {
        if ($this->compat_mode === true) {
        
            if (sizeof($this->lang_cache) < 1) {
            
                if (!file_exists(BH_INCLUDE_PATH. "languages/{$this->user_pref}.inc.php")) {
                    trigger_error("<p>Could not load language file {$this->user_pref}.inc.php</p>", E_USER_ERROR);
                }
                
                $lang = array();

                include(BH_INCLUDE_PATH. "languages/{$this->user_pref}.inc.php");
                
                $this->lang_cache = $lang;
            }
            
            return $this->lang_cache;
            
        }else if (!array_key_exists($filename, $this->lang_cache)) {
        
            $filename = basename($filename);

            if (!file_exists(BH_INCLUDE_PATH. "languages/{$this->user_pref}/$filename")) {
                trigger_error("<p>Could not load language file for $filename</p>", E_USER_ERROR);
            }
            
            $lang = array();

            include(BH_INCLUDE_PATH. "languages/{$this->user_pref}/$filename");
            
            $this->lang_cache[$filename] = $lang;
        }
        
        return $this->lang_cache[$filename];
    }
}   

function lang_get_available($inc_browser_negotiation = true)
{
    $lang = lang::get_instance()->load(__FILE__);

    $available_langs = ($inc_browser_negotiation) ? array('' => $lang['browsernegotiation']) : array();

    if ((@$dir = opendir("include/languages"))) {

        while (($file = readdir($dir))) {

            if (($pos = mb_strpos($file, '.inc.php')) !== false) {

                $lang_name = mb_substr($file, 0, $pos);
                $available_langs[$lang_name] = $lang_name;
            }
        }

        closedir($dir);
    }

    asort($available_langs);

    return $available_langs;
}

?>