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

/* $Id: logon.js,v 1.8 2008-12-09 18:26:46 decoyduck Exp $ */

function changePassword(webtag)
{
    var logon_array_obj = getObjsByName('logonarray')[0];

    if (typeof logon_array_obj == 'object') {
        
        var selected_logon = logon_array_obj.selectedIndex;

        if ((logon_array_obj.length - 1) == selected_logon) {

            self.location.href = 'logon.php?webtag=' + webtag + '&other_logon=true';
            return;

        }else {

            var user_logon_obj = getObjsByName('user_logon')[0];

            var user_password_obj = getObjsByName('user_password')[0];
            var user_passhash_obj = getObjsByName('user_passhash')[0];

            var password_selection_obj = getObjsByName('user_password' + selected_logon)[0];       
            var passhash_selection_obj = getObjsByName('user_passhash' + selected_logon)[0];

            var remember_password_obj = getObjsByName('remember_user')[0];

            if ((typeof user_logon_obj == 'object') && (typeof user_password_obj == 'object') && (typeof user_passhash_obj == 'object')) {

                if ((typeof password_selection_obj == 'object') && (typeof passhash_selection_obj == 'object') && (typeof remember_password_obj == 'object')) {

                    user_logon_obj.value = logon_array_obj.options[selected_logon].value;

                    if (/^[A-Fa-f0-9]{32}$/.test(passhash_selection_obj.value) == true) {

                        user_password_obj.value = password_selection_obj.value;
                        user_passhash_obj.value = passhash_selection_obj.value;

                        remember_password_obj.checked = true;

                    }else {

                        user_password_obj.value = '';
                        user_passhash_obj.value = '';

                        remember_password_obj.checked = false;
                    }
                }
            }
        }
    }
}

function clearPassword()
{
    var user_password_obj = getObjsByName('user_password')[0];
    var user_passhash_obj = getObjsByName('user_passhash')[0];

    if ((typeof user_password_obj == 'object') && (typeof user_passhash_obj == 'object')) {

        user_password_obj.value = '';
        user_passhash_obj.value = '';
    }
}

function toogleAutoLogon()
{
    var auto_logon_obj = getObjsByName('auto_logon')[0];

    var remember_password_obj = getObjsByName('remember_user')[0];
    
    var label_auto_logon_obj = getObjsByName('label_auto_logon');
    
    if ((typeof auto_logon_obj == 'object') && (typeof remember_password_obj == 'object')) {
        
        for (var i = 0; i < label_auto_logon_obj.length; i++) {
            label_auto_logon_obj[i].className = (remember_password_obj.checked == false) ? 'bhinputcheckboxdisabled' : '';
        }
        
        auto_logon_obj.checked = (remember_password_obj.checked) ? auto_logon_checked : false;
        auto_logon_obj.disabled = (remember_password_obj.checked == false);
        
    }
}    

function changeAutoLogon()
{
    var auto_logon_obj = getObjsByName('auto_logon')[0];
    
    if (typeof auto_logon_obj == 'object') {   
        auto_logon_checked = auto_logon_obj.checked;
    }
}

var has_clicked = false;
var auto_logon_checked = false;
