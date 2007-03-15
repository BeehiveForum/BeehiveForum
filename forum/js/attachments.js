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

/* $Id: attachments.js,v 1.7 2007-03-15 14:51:08 decoyduck Exp $ */

var attachments_window = false;

function attachment_toggle_all()
{
    for (var i = 0; i < document.admin_user_form.elements.length; i++) {

        if (document.admin_user_form.elements[i].type == 'checkbox') {

            if (document.admin_user_form.elements[i].name.substring(0, 17)  == 'delete_attachment') {
            
                if (document.admin_user_form.toggle_all.checked == true) {

                    document.admin_user_form.elements[i].checked = true;

                }else {

                    document.admin_user_form.elements[i].checked = false;
                }
            }
        }
    }
}

function attachment_toggle_main()
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

function attachment_toggle_other()
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
        attachments_window = window.open('attachments.php?webtag=' + webtag + '&aid='+ aid, 'attachments_window', 'width=660, height=500, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
    }

    return false;
}
