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

require_once("./include/constants.inc.php");

// Included functions for checking user permissions

function perm_is_moderator()
{
    global $HTTP_COOKIE_VARS;
    return ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & PERM_CHECK_WORKER);
}

function perm_is_soldier()
{
    global $HTTP_COOKIE_VARS;
    return ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & PERM_CHECK_SOLDIER);
}

?>