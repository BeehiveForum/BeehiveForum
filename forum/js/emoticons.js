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

function openEmoticons(pack, webtag) {
	window.open('display_emoticons.php?webtag=' + webtag + '&pack=' + pack, 'emoticons','width=500, height=400, scrollbars=1');
}

function previewEmoticons(a) {
	var str = "";
	var p = a[0];
	for(var i=1; i<a.length; i++) {
		str += "<a href=\"#\" onclick=\"add_text('" + a[i][1] + "');return false;\" target=\"_self\">";
		str += "<img src=\"" + a[0] + a[i][0] + "\" title=\"" + a[i][1] + a[i][2] + "\" border=\"0\" /></a> ";
	}
	return(str);
}