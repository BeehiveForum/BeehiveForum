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
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function ajax_chat_online_user_count()
{
    if (!$db = db::get()) return 0;

    $config = ajax_chat_get_config();

    $ajax_chat_online = $db->escape($config['dbTableNames']['online']);

    $sql = "SELECT COUNT(*) FROM `$ajax_chat_online`";

    $result = $db->query($sql);

    list($ajax_chat_online_users) = $result->fetch_row();

    return $ajax_chat_online_users;
}

function ajax_chat_get_config()
{
    static $config = false;

    if (!$config) {

        if (@file_exists(BH_INCLUDE_PATH . '../chat/lib/config.php')) {
            require_once BH_INCLUDE_PATH . '../chat/lib/config.php';
        }
    }

    return $config;
}