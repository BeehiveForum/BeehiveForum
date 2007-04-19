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

/* $Id: pm.js,v 1.9 2007-04-19 20:32:45 decoyduck Exp $ */

var pm_logon_search = false;

function pm_toggle_all()
{
    for (var i = 0; i < document.pm.elements.length; i++) {

        if (document.pm.elements[i].type == 'checkbox') {

            if (document.pm.toggle_all.checked == true) {

                document.pm.elements[i].checked = true;

            }else {

                document.pm.elements[i].checked = false;
            }
        }
    }
}

function openRecipientSearch(webtag, obj_name)
{
    if (typeof pm_logon_search == 'object' && !pm_logon_search.closed) {
    
        pm_logon_search.focus();

    }else {

        var form_obj = getFormObjByName(obj_name);
        pm_logon_search = window.open('search_popup.php?webtag=' + webtag + 'allow_multi=1&type=1&search_query=' + form_obj.value + '&obj_name='+ obj_name, 'pm_logon_search', 'width=500, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
    }

    return false;
}

function returnSearchResult(obj_name, content)
{
    var form_obj = getFormObjByName(obj_name);

    if (form_obj.value.length == 0) {
        form_obj.value = content;
    }else {
        form_obj.value+= '; ' + content;
    }
}

function checkToRadio(num)
{
    document.f_post.to_radio[num].checked=true;
}
