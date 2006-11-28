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

/* $Id: openprofile.js,v 1.10 2006-11-28 22:27:32 decoyduck Exp $ */

function openProfile(uid, webtag) {
    window.open('user_profile.php?webtag=' + webtag + '&uid=' + uid, uid,'width=580, height=450, toolbars=no');
}

function openProfileByLogon(logon, webtag) {
    window.open('user_profile.php?webtag=' + webtag + '&logon=' + logon, logon,'width=580, height=450, toolbars=no');
}

function launchAttachProfileWin(webtag) {
    attachwin = window.open('edit_attachments.php?webtag=' + webtag + '&popup=1', 'edit_attachments', 'width=660, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
}

function findUserPosts(logon, webtag) {

    if (window.opener) {

        window.opener.top.document.location.href = 'search.php?webtag=' + webtag + '&logon=' + logon;
        document.location.href = 'user_profile.php?close_window';
        return false;
    }
}
