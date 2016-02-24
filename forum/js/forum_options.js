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

    $('a.emoticon_preview_popup').bind('click', function () {

        var window_options = beehive.window_options;

        var emoticon_pack = $('select#emoticons').val();

        var emoticon_preview_href = 'display_emoticons.php?webtag=' + beehive.webtag + '&pack=' + emoticon_pack;

        window_options.unshift('width=400,height=500');

        window.open(emoticon_preview_href, 'emoticon_preview_popup', window_options.join(','));

        return false;
    });
});