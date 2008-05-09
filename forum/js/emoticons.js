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

/* $Id: emoticons.js,v 1.11 2008-05-09 06:53:30 decoyduck Exp $ */

var emoticons_window = false;

function openEmoticons(pack, webtag)
{
    if (typeof emoticons_window == 'object' && !emoticons_window.closed) {
        emoticons_window.focus();
    }else {
        emoticons_window = window.open('display_emoticons.php?webtag=' + webtag + '&pack=' + pack, 'emoticons_window','width=500, height=400, resizable=yes, scrollbars=yes');
    }

    return false;
}

function insertEmoticon(text)
{
    if (window.opener.add_text) {

        window.opener.add_text(text);
    }
}
