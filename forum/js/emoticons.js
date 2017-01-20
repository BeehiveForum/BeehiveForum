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

$(document).bind('beehive.init', function ($event, beehive) {

    'use strict';

    $('.emoticon_preview .emoticon').bind('click', function () {

        var $emoticon = $(this).closest('span.emoticon').clone();

        var html = $('<p>').append($emoticon).html();

        var element = CKEDITOR.dom.element.createFromHtml(
            '<img data-cke-real-element-type="emoticon" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAMAAAAoyzS7AAAABGdBTUEAALGPC/xhBQAAAANQTFRF////p8QbyAAAAAF0Uk5TAEDm2GYAAAAJcEhZcwAAHsEAAB7BAcNpVFMAAAAHdElNRQfcDB4LNzBmlcQgAAAACklEQVQIHWNgAAAAAgABz8g15QAAAABJRU5ErkJggg=="/>'
        );

        //noinspection JSCheckFunctionSignatures
        element.setAttributes({
            'data-cke-real-node-type': '1',
            'data-cke-realelement': encodeURIComponent(html),
            'data-cke-resizable': 'false',
            'class': $emoticon.prop('class'),
            'title': $emoticon.prop('title'),
            'alt': $emoticon.prop('title')
        });

        if (beehive.active_editor) {
            beehive.active_editor.insertText(' ');
            beehive.active_editor.insertElement(element);
            beehive.active_editor.insertText(' ');
        }
    });
});