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

/**
* This plugin is based heavilly on code found on:
*
* http://www.travelogie.com/blog/post/2011/04/06/Youtube-plugin-for-TinyMCE.aspx
*
* It has been modified to support Beehive Forum's HTML parsing,
* so the user can switch mid-post from using TinyMCE to the built-in
* HTML toolbar editor.
*/
tinyMCEPopup.requireLangPack();

var YoutubeDialog = {
    
    decode : function(html) {
        
        span = document.createElement('span');

        span.innerHTML = html;

        return span.firstChild.nodeValue;        
    },

    init: function () {

        var html, matches, f = document.forms[0];

        html = tinyMCEPopup.editor.selection.getContent();

        matches = html.match(/<img class="mceItem youtube" src="[^"]+" alt="([^"]+)" \s?\/>/);
        
        if (matches && matches[1]) {
            f.youtubeURL.value = 'http://www.youtube.com/watch?v=' + matches[1];
        }
    },

    insert: function () {

        var url = YoutubeDialog.decode(document.forms[0].youtubeURL.value),
            html,
            matches;

        if (url === null) {
            return;
        }
        
        if (!(matches = url.match(/^((http|https):\/\/)?(www\.)?((youtube\.com\/watch\?(feature=([^&]+)&)?v=([^&]+))|youtu\.be\/(.+))/))) {
            return;
        }
        
        if (!matches[2]) {
            matches[2] = 'http';
        }
        
        if (matches[9] !== undefined) {

            html = '<img src="http://img.youtube.com/vi/' + matches[9] + '/0.jpg" class="mceItem youtube" alt="' + matches[9] + '" />';

        } else if (matches[8] !== undefined) {

            html = '<img src="http://img.youtube.com/vi/' + matches[8] + '/0.jpg" class="mceItem youtube" alt="' + matches[8] + '" />';

        } else {

            return;
        }

        tinyMCEPopup.editor.execCommand('mceInsertContent', false, html);

        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(YoutubeDialog.init, YoutubeDialog);
