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

/* $Id: attachments.js,v 1.12 2008-07-14 18:14:10 decoyduck Exp $ */

var attachments_window = false;
var attachments_window_edit = false;

function attachmentToggleMain()
{
    for (var i = 0; i < document.attachments.elements.length; i++) {

        if (document.attachments.elements[i].type == 'checkbox') {

            if (document.attachments.elements[i].name.substring(0, 17)  == 'delete_attachment') {
            
                if (document.attachments.toggle_main.checked == true) {

                    document.attachments.elements[i].checked = true;

                }else {

                    document.attachments.elements[i].checked = false;
                }
            }
        }
    }
}

function attachmentToggleOther()
{
    for (var i = 0; i < document.attachments.elements.length; i++) {

        if (document.attachments.elements[i].type == 'checkbox') {

            if (document.attachments.elements[i].name.substring(0, 23)  == 'delete_other_attachment') {
            
                if (document.attachments.toggle_other.checked == true) {

                    document.attachments.elements[i].checked = true;

                }else {

                    document.attachments.elements[i].checked = false;
                }
            }
        }
    }
}

function closeAttachWin()
{
    if (typeof attachments_window == 'object' && !attachments_window.closed) {
        attachments_window.close();
    }
}

function launchAttachWin(aid, webtag)
{
    if (typeof attachments_window == 'object' && !attachments_window.closed) {
        attachments_window.focus();
    }else {
        attachments_window = window.open('attachments.php?webtag=' + webtag + '&aid='+ aid, 'attachments_window', 'width=660, height=500, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
    }

    return false;
}

function launchAttachEditWin(uid, aid, webtag)
{
    if (typeof attachments_window_edit == 'object' && !attachments_window_edit.closed) {
        attachments_window_edit.focus();
    }else {
        attachments_window_edit = window.open('edit_attachments.php?webtag=' + webtag + '&uid=' + uid + '&aid=' + aid + '&popup=1', 'edit_attachments', 'width=660, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
    }

    return false;
}
