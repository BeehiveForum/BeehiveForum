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

/* $Id: logon.js,v 1.1 2004-03-27 19:50:55 decoyduck Exp $ */

function changepassword() {

    var i = document.logonform.logonarray.selectedIndex;
    var password = eval("document.logonform.password"+ i +".value");
    var passhash = eval("document.logonform.passhash"+ i +".value");
    document.logonform.logon.value = document.logonform.logonarray.options[i].value;
    if (/^[A-Fa-f0-9]{32}$/.test(passhash) == true) {
        document.logonform.password.value = password;
        document.logonform.passhash.value = passhash;
        document.logonform.remember_user.checked = true;
    }else {
        document.logonform.password.value = '';
        document.logonform.passhash.value = '';
        document.logonform.remember_user.checked = false;
    }
}

var has_clicked = false;