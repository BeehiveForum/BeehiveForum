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

function addOverflow() {

        var IE = (document.all ? true : false);
        
        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var td_tags = document.getElementsByTagName('td');
        var td_count = td_tags.length;

        for (var i = 0; i < td_count; i++)  {

                if (td_tags[i].className == 'postbody') {
                        
                        if (td_tags[i].clientWidth >= body_tag.clientWidth) {

                                var new_div = document.createElement('div');

                                new_div.style.overflowX = 'scroll';
                                new_div.style.overflowY = 'auto';

                                new_div.style.overflow = 'auto';

                                new_div.className = 'bhoverflowfix';
                        
                                new_div.style.width = (body_tag.clientWidth * 0.94) + 'px';

                                while (td_tags[i].hasChildNodes()) {
                                        new_div.appendChild(td_tags[i].firstChild);
                                }

                                td_tags[i].style.width = (body_tag.clientWidth * 0.98) + 'px';
                                td_tags[i].appendChild(new_div);
                        }
                }
        }

        if (IE) {
        
                window.attachEvent("onresize", redoOverFlow);
        }else {
        
                window.addEventListener("resize", redoOverFlow, true);
        }
}

function redoOverFlow() {

        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var td_tags = document.getElementsByTagName('td');
        var td_count = td_tags.length;

        for (var i = 0; i < td_count; i++)  {

                if (td_tags[i].className == 'postbody') {
                        
                        td_tags[i].style.width = (body_tag.clientWidth * 0.98) + 'px';
                        
                        var div_tags = td_tags[i].getElementsByTagName('div');
                        var div_count = div_tags.length;

                        for (var j = 0; j < div_count; j++)  {

                                if (div_tags[j].className == 'bhoverflowfix') {

                                        div_tags[j].style.width = (body_tag.clientWidth * 0.94) + 'px';
                                }
                        }
                }
        }
}

function resizeImages() {
        
        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var img_tags = document.getElementsByTagName('img');
        var img_count = img_tags.length;

        for (var i = 0; i < img_count; i++)  {

                if (img_tags[i].width >= body_tag.clientWidth) {
                        
                        img_tags[i].style.width = Math.round(body_tag.clientWidth * 0.9) + 'px';
                        img_tags[i].style.cursor = 'pointer';

                        if (img_tags[i].attachEvent) {

                                img_tags[i].attachEvent("onclick", showFullImage);

                        }else if (img_tags[i].addEventListener) {

                                img_tags[i].addEventListener("click", showFullImage, false);
                        }                       
                }
        }
}

function showFullImage(evt) {

        if (window.event) {

                window.open(window.event.srcElement.src);

        }else if (evt.target) {
                
                window.open(evt.target.src);
        }
}
