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

/* $Id: openprofile.js,v 1.22 2008-09-08 21:59:59 decoyduck Exp $ */

var edit_attachments = false;
var email_window = false;

function openProfile(uid, webtag)
{
    window.open('user_profile.php?webtag=' + webtag + '&uid=' + uid, 'profile_window_' + uid, 'width=650, height=500, toolbars=no, resizable=yes, scrollbars=yes');
    return false;
}

function openProfileByLogon(logon, webtag)
{
    window.open('user_profile.php?webtag=' + webtag + '&logon=' + logon, 'profile_window_' + logon, 'width=650, height=500, toolbars=no, resizable=yes, scrollbars=yes');
    return false;
}

function launchAttachProfileWin(webtag)
{
    if (typeof edit_attachments == 'object' && !edit_attachments.closed) {
        edit_attachments.focus();
    }else {
        edit_attachments = window.open('edit_attachments.php?webtag=' + webtag + '&popup=1', 'edit_attachments', 'width=660, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
    }

    return false;
}

function findUserPosts(logon, webtag)
{
    if (window.opener) {

        window.opener.top.document.location.href = 'search.php?webtag=' + webtag + '&logon=' + logon;
        document.location.href = 'user_profile.php?webtag=' + webtag + '+&close_window';
        return false;
    }
}

function findUserThreads(logon, webtag)
{
    if (window.opener) {

        window.opener.top.document.location.href = 'search.php?webtag=' + webtag + '&logon=' + logon + '&user_include=1';
        document.location.href = 'user_profile.php?webtag=' + webtag + '&close_window';
        return false;
    }
}

function openEmailWindow(uid, webtag)
{
    if (typeof email_window == 'object' && !email_window.closed) {
        email_window.focus();
    }else {
        email_window = window.open('email.php?webtag=' + webtag + '&uid=' + uid, 'email_window', 'width=500, height=400, toolbars=no, resizable=yes, scrollbars=yes');
    }

    return false;
}

function delayProfileMenuClickHandler()
{
    menu_timeout = setTimeout('attachProfileMenuClickHandler()', 100);
}

function attachProfileMenuClickHandler()
{
    clearTimeout(menu_timeout);
    
    if (document.attachEvent) {
        document.attachEvent('onclick', closeProfileOptions);
    }else {
        document.addEventListener('click', closeProfileOptions, true);
    }
}

function cancelProfileMenuClickHandler()
{
    if (document.detachEvent) {    
        document.detachEvent('onclick', closeProfileOptions);
    }else {
        document.removeEventListener('click', closeProfileOptions, false);
    }
}

function closeProfileOptions()
{
    var div_tags  = document.getElementsByTagName('div');
    var div_count = div_tags.length;

    for (var i = 0; i < div_count; i++)  {

        if (div_tags[i].className == 'profile_options_container_opened') {                    

            div_tags[i].className = 'profile_options_container_closed';
        }
    }

    cancelProfileMenuClickHandler();
}

function openProfileOptions()
{
    var IE = (document.all ? true : false);

    closeProfileOptions();
    
    var profile_options_obj = getObjById('profile_options');
    var profile_options_container_obj = getObjById('profile_options_container');

    if (typeof profile_options_obj == 'object' && typeof profile_options_container_obj == 'object') {

        if (profile_options_container_obj.className == 'profile_options_container_closed') {

            profile_options_container_obj.style.left = '100px';

            profile_options_container_obj.className = 'profile_options_container_opened';

            profile_options_container_obj.style.width = '0px';
            profile_options_container_obj.style.height = '0px';

            if (IE) {

                var scroll_width = parseInt(profile_options_container_obj.scrollWidth);

                while (parseInt(profile_options_container_obj.scrollWidth) > scroll_width) {
                    scroll_width = parseInt(profile_options_container_obj.scrollWidth);
                }

                var scroll_height = parseInt(profile_options_container_obj.scrollHeight);

                while (parseInt(profile_options_container_obj.scrollHeight) > scroll_height) {
                    scroll_height = parseInt(profile_options_container_obj.scrollHeight);
                }

            }else {

                var scroll_width = profile_options_container_obj.scrollWidth;
                var scroll_height = profile_options_container_obj.scrollHeight;            
            }

            profile_options_container_obj.style.width = scroll_width + 'px';
            profile_options_container_obj.style.height = scroll_height + 'px';
            profile_options_container_obj.style.overflow = 'hidden';

            var container_left = findPosX(profile_options_obj);
            var container_top = findPosY(profile_options_obj);

            container_top  = profile_options_obj.height + container_top;

            profile_options_container_obj.style.left = container_left + 'px';
            profile_options_container_obj.style.top = container_top + 'px';

            delayProfileMenuClickHandler();
        }
    }
}