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

/* $Id: forumlinks.js,v 1.7 2009-07-26 14:32:59 decoyduck Exp $ */

function openForumLink(obj)
{
    var url = obj.options[obj.selectedIndex].value;

    if (url.length > 0) {
    
        window.open(url);
        return false;
    }
    
    obj.selectedIndex = 0;
    return true;
}
