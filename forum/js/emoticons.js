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

$(beehive).bind('init', function() {

    $('.emoticon_preview .emoticon').bind('click', function() {

        var html = $('<p>').append($(this).closest('span.emoticon').clone()).html();

        var element = CKEDITOR.dom.element.createFromHtml(
            '<img data-cke-real-element-type="emoticon" src="/forum/styles/tehforum/images/emoticon.png" class="emoticon e_smile">'
        );

        element.setAttributes({
            'data-cke-real-node-type': '1',
            'data-cke-realelement' : encodeURIComponent(html),
            'data-cke-resizable' : 'false',
        });

        beehive.active_editor.insertElement(element);
        beehive.active_editor.insertText(' ');
    });
});