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

function getFormObj(obj_id)
{
    var form_obj;

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    return form_obj;
}

function openThreadSearch(webtag, obj_name)
{
    var form_obj = document.getElementsByName(obj_name)[0];
    search_thread = window.open('search_popup.php?webtag=' + webtag + '&type=2&obj_id='+ form_obj.id, 'search_thread', 'width=500, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
    return false;
}

function returnSearchResult(obj_id, content)
{
    var form_obj = getFormObj(obj_id);
    form_obj.value = content;
}
