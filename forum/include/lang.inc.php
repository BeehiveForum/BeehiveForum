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

function lang_init()
{
    $available_languages = lang_get_available(false);

    if (isset($_SESSION['LANGUAGE']) && in_array($_SESSION['LANGUAGE'], $available_languages)) {
        $language = $_SESSION['LANGUAGE'];
    } else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $language = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    if (!isset($language)) {
        $language = forum_get_setting('default_language', 'strlen', 'en_GB');
    }

    $languages = array(
        $language . '.utf8',
        $language . '.UTF8',
        $language . '.utf-8',
        $language . '.UTF-8',
        $language
    );

    setlocale(LC_ALL, $languages);

    putenv('LC_ALL=' . $language);
    putenv('LANG=' . $language);
    putenv('LANGUAGE=' . $language);

    bindtextdomain('messages', realpath(BH_INCLUDE_PATH . 'locale'));

    bind_textdomain_codeset('messages', 'UTF-8');

    textdomain('messages');
}

function lang_get_month_names()
{
    $month_names = array();

    for ($month = 1; $month <= 12; $month++) {
        $month_names[$month] = strftime('%B', mktime(0, 0, 0, $month, 1, date('Y')));
    }

    return $month_names;
}

function lang_get_available($inc_browser_negotiation = true)
{
    $include_path = BH_INCLUDE_PATH . 'locale/';

    $available_langs = ($inc_browser_negotiation) ? array('' => gettext("Browser negotiated")) : array();

    foreach (glob($include_path . '*/LC_MESSAGES/messages.po') as $lang) {

        $lang = preg_replace(
            sprintf('/%s([^\/]+)\/LC_MESSAGES\/messages.po/', preg_quote($include_path, '/')),
            '\\1',
            $lang
        );

        $available_langs[$lang] = $lang;
    }

    ksort($available_langs);

    return $available_langs;
}