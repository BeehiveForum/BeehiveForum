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

/* $Id: admin.js,v 1.19 2008-09-25 21:48:45 decoyduck Exp $ */

var search_logon = false;

function openLogonSearch(webtag, obj_name)
{
    if (typeof search_logon == 'object' && !search_logon.closed) {

        search_logon.focus();

    }else {

        var form_obj = getObjsByName(obj_name)[0];

        if (typeof form_obj == 'object') {

            search_logon = window.open('search_popup.php?webtag=' + webtag + '&type=1&selection=' + form_obj.value + '&obj_name=' + obj_name, 'search_logon', 'width=550, height=400, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
        }
    }

    return false;
}

function returnSearchResult(obj_name, content)
{
    var form_obj = getObjsByName(obj_name)[0];

    if (typeof form_obj == 'object') {
        
        form_obj.value = content;
        return true;
    }

    return false;
}

function changeColourSwatch(source_obj_id, button_obj_id)
{
    var source_obj = getObjById(source_obj_id);
    var button_obj = getObjById(button_obj_id);

    if ((typeof source_obj == 'object') && (typeof button_obj == 'object')) {

        button_obj.style.backgroundColor = source_obj.value;
    }
}