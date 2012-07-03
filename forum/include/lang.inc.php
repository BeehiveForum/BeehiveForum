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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
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

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

/**
 * lang_init
 * 
 * Initialise gettext functionality in PHP.
 * 
 * @param void
 * @return void
 */
function lang_init()
{
    if (!lang_detect()) {
        throw new Exception('Could not initialise language.');
    }

    bindtextdomain('messages', BH_INCLUDE_PATH. 'locale/');

    textdomain('messages');
    
    bind_textdomain_codeset('messages', 'UTF-8');
}

/**
 * lang_detect
 * 
 * Detect the language specified by the user
 * preferences / the browser's HTTP-ACCEPT-LANGUAGE
 * headers
 * 
 * @param void
 * @return string
 */
function lang_detect()
{   
    if (($language = session_get_value('LANGUAGE'))) {
        
        if (lang_set($language)) {
            return $language;
        }
    }
    
    $languages = array();
    
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        
        $accepted = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($accepted as $accept) {
            
            if (!preg_match('/^([a-z]{1,8}(?:[-_][a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accept, $matches)) {
                continue;
            }
            
            $quality = isset($matches[2]) ? (float)$matches[2] : 1.0;
            
            $countries = explode('-', $matches[1]);
            $region = array_shift($countries);
        
            $countries2 = explode('_', $region);
            $region = array_shift($countries2);
            
            foreach ($countries as $country) {
                $languages[$region. '_'. mb_strtoupper($country)] = $quality;
            }

            foreach ($countries2 as $country) {
                $languages[$region. '_'. mb_strtoupper($country)] = $quality;
            }

            if (!isset($languages[$region]) || ($languages[$region] < $quality)) {
                $languages[$region] = $quality;
            }
        }
    }
    
    foreach (array_keys($languages) as $language) {
        
        if (lang_set($language)) {
            return $language;            
        }
    }
    
    return lang_set('en_GB');
}

/**
 * lang_set
 * 
 * Attempt to set the specified language.
 * Returns the requested language if successful
 * or false on failure.
 * 
 * @param mixed $language
 * @return false | string
 */
function lang_set($language)
{
    putenv('LANG='. $language);
    putenv('LANGUAGE='. $language);
    
    $languages = array(
        $language. '.utf8',
        $language. '.UTF8',
        $language. '.utf-8',
        $language. '.UTF-8',
        $language    
    );
    
    if (setlocale(LC_ALL, $languages)) {
        return $language;
    }
    
    return false;
}

function lang_get_month_names()
{
    $month_names = array();
    
    for ($month = 1; $month <= 12; $month++) {
        $month_names[$month] = strftime('%B', mktime(0, 0, 0, $month, 1, date('Y')));
    }
    
    return $month_names;
}

/**
 * lang_get_available
 * 
 * Get an array of supported languages.
 * 
 * @param bool $inc_browser_negotiation
 * @return string[]
 */
function lang_get_available($inc_browser_negotiation = true)
{
    $include_path = BH_INCLUDE_PATH. 'locale/';
    
    $available_langs = ($inc_browser_negotiation) ? array('' => gettext("Browser negotiated")) : array();
    
    foreach (glob($include_path. '*/messages.po') as $lang) {
        
        $available_langs[] = preg_replace(
            sprintf('/%s\/([^\/]+)\/messages.po/', preg_quote($include_path, '/')), 
            '\1', 
            $lang
        );
    }
    
    asort($available_langs);

    return $available_langs;
}

?>