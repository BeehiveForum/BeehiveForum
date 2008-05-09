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

/* $Id: poll.js,v 1.5 2008-05-09 06:53:30 decoyduck Exp $ */

var poll_results = false;

function openPollResults(tid, webtag)
{
    if (typeof poll_results == 'object' && !poll_results.closed) {
        poll_results.focus();   
    }else {
        poll_results = window.open('poll_results.php?webtag=' + webtag + '&tid=' + tid, 'poll_results', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');
    }
    
    return false;
}