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

/* $Id: admin.js 4499 2010-07-26 19:52:36Z decoyduck $ */

$(beehive).bind('init', function() {
    
    var $beehive_top = top.$(top.beehive);
    
    $beehive_top.bind('reload_top_frame', function(event, src) {
        
        $('frame').each(function() {
            
            if ($(this).attr('name') == top.beehive.frames.ftop) {
                $(this).attr('src', src);
            }
        });        
    });
});