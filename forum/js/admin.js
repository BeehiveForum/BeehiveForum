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

function admin_change_folder () {
    
    var selected_folder = document.admin_user_form.folder_list.selectedIndex;
    var folder_count = document.admin_user_form.folder_list.options.length;
    
    var obj;
    
    for (var i = 0; i < folder_count; i++) {
        
        if (document.getElementById) {
           
           obj = eval("document.getElementById('folder_perms_" + i + "')");
           obj.style.display = 'none';
           
        }else if (document.all) {
               
	    eval("document.all.folder_perms_" + i + ".style.display = 'none'");
	    
	}else if (document.layers) {
	
	    eval("document.layers[folder_perms_" + i + "].display = 'none'");
	}
    }
        
    if (document.getElementById) {
        
        obj = eval("document.getElementById('folder_perms_" + selected_folder + "')");
        obj.style.display = 'block';
        
    }else if (document.all) {
    
        eval("document.all.folder_perms_" + selected_folder + ".style.display = 'block'");

    }else if (document.layers) {
    
        eval("document.layers[folder_perms_" + selected_folder + "].display = 'block'");
    }    
}