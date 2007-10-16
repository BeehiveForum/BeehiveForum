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

/* $Id: edit_subscriptions.js,v 1.3 2007-10-16 17:09:23 decoyduck Exp $ */

function subscriptionsToggleAll()
{
    for (var i = 0; i < document.subscriptions.elements.length; i++) {

        if (document.subscriptions.elements[i].type == 'checkbox') {

            if (document.subscriptions.toggle_all.checked == true) {

                document.subscriptions.elements[i].checked = true;

            }else {

                document.subscriptions.elements[i].checked = false;
            }
        }
    }
}
