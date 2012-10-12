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

        var $emoticon = $(this).closest('span.emoticon').clone();

        var element = CKEDITOR.dom.element.createFromHtml(
            $.sprintf(
                '<span class="%s" title="%s"><span class="e__">%s</span></span>',
                $emoticon.attr('class'),
                $emoticon.attr('title'),
                $emoticon.attr('title')
            )
        );

        element.setAttributes({
            contentEditable: 'false',
        });

        for (var key in element.children) {
            element.children[key].attributes.contentEditable = "false";
        }

        beehive.active_editor.insertElement(element);
        beehive.active_editor.insertText(' ');
    });
});