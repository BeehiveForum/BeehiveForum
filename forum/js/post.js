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

function closeAttachWin () {
	if (typeof attachwin == 'object' && !attachwin.closed) {
		attachwin.close();
	}
}

function launchAttachWin (aid, webtag) {
	attachwin = window.open('attachments.php?webtag=' + webtag + '&aid='+ aid, 'attachments', 'width=660, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
}

function checkToRadio(num) {
	document.f_post.to_radio[num].checked=true;
}

function resizeImages() {

	var body_tag = document.getElementsByTagName('body');
	var body_tag = body_tag[0];

	var td_tags = document.getElementsByTagName('td');
	var td_count = td_tags.length;

	for (var i = 0; i < td_count; i++)  {

		if (td_tags[i].className == 'postbody') {
			
			if (td_tags[i].clientWidth > body_tag.clientWidth) {

				var img_tags = td_tags[i].getElementsByTagName('img');
				var img_count = img_tags.length;

				for (var j = 0; j < img_count; j++)  {

					if (img_tags[j].width > body_tag.clientWidth) {

						img_tags[j].width = (body_tag.clientWidth * 0.9);
					}
				}
				
				new_div = document.createElement('div')
				new_div.innerHTML = td_tags[i].innerHTML;

				td_tags[i].width = body_tag.clientWidth;
				td_tags[i].innerHTML = '<div style="overflow: auto">' + new_div.innerHTML + '</div>';

				delete new_div;
			}
		}
	}
}