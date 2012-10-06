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

    $('.emoticon_preview .emoticon_preview_img').bind('click', function() {

        var $emoticon = $(this).closest('span.emoticon_preview_img');

        var element = new CKEDITOR.dom.text($emoticon.attr('title'));

        element.getOuterHtml = function() {
            return this.$.data;
        };

        element.getAttribute = function() {
            return null;
        }

        var fakeElement = beehive.active_editor.createFakeElement(element, $emoticon.attr('class'), 'emoticon', false);

        fakeElement.setAttribute('height', $emoticon.height());
        fakeElement.setAttribute('width', $emoticon.width());
        fakeElement.setAttribute('title', $emoticon.attr('title'));

        beehive.active_editor.insertElement(fakeElement);
    });
});