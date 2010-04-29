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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "/beehiveforum/home/beehiveforum/forum/include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// X7Chat Username Cookie

$auth_ucookie = "X7C2U";

// X7Chat Password Cookie

$auth_pcookie = "X7C2P";

// Registration link

$auth_register_link = "../register.php";

// Disable Guest access to X7Chat

$auth_disable_guest = true;

// See if we can try and logon automatically

logon_perform_auto();

// Check the session is active

if (($user_sess = bh_session_check())) {

    if ($user_data = user_get(bh_session_get_value('UID'))) {
        
        $_COOKIE[$auth_ucookie] = db_escape_string($user_data['LOGON']);
        $_COOKIE[$auth_pcookie] = db_escape_string($user_data['PASSWD']);
        
        $query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
        
        $row = $db->Do_Fetch_Row($query);
        
        if ($row[0] == '') {
        
            $time = time();
            
            $ip = db_escape_string($_SERVER['REMOTE_ADDR']);
            
            $activated = bh_session_user_approved() ? '1' : '0';
            
            $email = db_escape_string($user_data['EMAIL']);
            
            $db->DoQuery("INSERT INTO {$prefix}users (username,password,email,user_group,time,settings,hideemail,ip,activated) VALUES('$_COOKIE[$auth_ucookie]','$_COOKIE[$auth_pcookie]','{$email}', '{$x7c->settings['usergroup_default']}','$time','{$g_default_settings}','1','$ip','$activated')");
        }        
    }
}

// Authentication Encryption.

function auth_encrypt($data)
{
    return md5($data);
}

// Get password hash

function auth_getpass($auth_ucookie)
{
    if ($user_data = user_get_by_logon($_COOKIE[$auth_ucookie])) {
        return $user_data['PASSWD'];
    }
}

// Change password

function change_pass($user, $newpass)
{
    if ($user_data = user_get_by_logon($user)) {
        user_change_password($user_data['UID'], $newpass, $user_data['PASSWD']);
    }
}

?>