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
CKEDITOR.skins.add('beehive', (function () {
    return {
        editor: {
            css: ['editor.css']
        },
        dialog: {
            css: ['dialog.css']
        },
        separator: {
            canGroup: false
        },
        templates: {
            css: ['templates.css']
        },
        margins: [0, 14, 18, 14]
    };
})());
(function () {
    CKEDITOR.dialog ? a() : CKEDITOR.on('dialogPluginReady', a);

    function a() {
        CKEDITOR.dialog.on('resize', function (b) {
            var c = b.data,
                d = c.width,
                e = c.height,
                f = c.dialog,
                g = f.parts.contents;
            if (c.skin != 'beehive') return;
            g.setStyles({
                width: d + 'px',
                height: e + 'px'
            });
            if (!CKEDITOR.env.ie || CKEDITOR.env.ie9Compat) return;
            setTimeout(function () {
                var h = f.parts.dialog.getChild([0, 0, 0]),
                    i = h.getChild(0),
                    j = i.getSize('width');
                e += i.getChild(0)
                    .getSize('height') + 1;
                var k = h.getChild(2);
                k.setSize('width', j);
                k = h.getChild(7);
                k.setSize('width', j - 28);
                k = h.getChild(4);
                k.setSize('height', e);
                k = h.getChild(5);
                k.setSize('height', e);
            }, 100);
        });
    }
})();