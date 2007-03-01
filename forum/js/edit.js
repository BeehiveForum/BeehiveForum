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

/* $Id: edit.js,v 1.13 2007-03-01 14:37:24 decoyduck Exp $ */

function closeAttachWin () {
    if (typeof attachwin == 'object' && !attachwin.closed) {
        attachwin.close();
    }
}

function launchAttachEditWin (uid, aid, webtag) {
    attachwin = window.open('edit_attachments.php?uid=' + uid + '&aid=' + aid + '&webtag=' + webtag + '&popup=1', 'edit_attachments', 'width=660, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
    return false;
}

function checkToRadio(num) {
    document.f_edit.to_radio[num].checked=true;
}
