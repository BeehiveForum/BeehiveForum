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

function changeword(obj) {

    var i = obj.options[obj.selectedIndex].value;
	// IE doesn't like .value when <object>value</value> is used instead
	// of <object value="value">value</object> so we use innerText
    if (i.length == 0) i = obj.options[obj.selectedIndex].innerText;

    document.dictionary.change_to.value = i;

}

function updateFormObj(obj_id, content) {

    var form_obj;
    
    content = unescape(content);

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    form_obj.value = content;
}
