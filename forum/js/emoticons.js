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

/* $Id$ */

$(beehive).bind('init', function() {

    $('.emoticon_preview_popup .emoticon_preview_img').bind('click', function() {
        if ($.isFunction(window.opener.htmltools.add_text)) {
            window.opener.htmltools.add_text(' ' + $(this).attr('title') + ' ');
        }
    });

    $('.emoticon_preview .emoticon_preview_img').bind('click', function() {
        htmltools.add_text(' ' + $(this).attr('title') + ' ');
    });

    $('.emoticon_preview .view_more').bind('click', function() {

        var popup_window_options = beehive.window_options;

        window.open($(this).attr('href'), $(this).attr('id'), popup_window_options.join(','));

        return false;
    });
});