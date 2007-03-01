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

/* $Id: spoiler.js,v 1.3 2007-03-01 14:37:24 decoyduck Exp $ */

function spoilerInitialise() {

    var IE = (document.all ? true : false);

    var div_tags = document.getElementsByTagName('div');
    var div_count = div_tags.length;

    for (var i = 0; i < div_count; i++)  {

        if (div_tags[i].className == 'spoiler') {
            
            if (IE) {

                div_tags[i].attachEvent("onmouseover", spoilerReveal);
                div_tags[i].attachEvent("onmouseout", spoilerHide);

            }else {

                div_tags[i].addEventListener("mouseover", spoilerReveal, true);
                div_tags[i].addEventListener("mouseout", spoilerHide, true);
            }
        }
    }
}

function spoilerReveal(evt) {
    
    if (window.event) {
        if (window.event.srcElement.className == 'spoiler') {
            window.event.srcElement.className = 'spoiler_reveal';
        }
    }else if (evt.target) {                  
        if (evt.target.className == 'spoiler') {
            evt.target.className = 'spoiler_reveal';
        }
    }
}

function spoilerHide(evt) {
    
    if (window.event) {
        if (window.event.srcElement.className == 'spoiler_reveal') {
            window.event.srcElement.className = 'spoiler';
        }
    }else if (evt.target) {
        if (evt.target.className == 'spoiler_reveal') {
            evt.target.className = 'spoiler';
        }
    }
}
