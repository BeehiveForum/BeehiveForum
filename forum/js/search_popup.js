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

/* $Id: search_popup.js,v 1.1 2010-01-15 21:30:09 decoyduck Exp $ */

function return_result(obj_id, $data) {

    var $search_input = $('#' + obj_id);

    if ($search_input.length > 0) {

        $search_container = $search_input.closest('div.bhinputsearch');

        if ($search_container.length != 1) return false;

        var result_array = [];

        $data.each(function() {

            result_array.push($(this).val());
            return $search_input.hasClass('allow_multi');
        });

        $search_input.find('input:text').val(result_array.join(';'));
    }
}

$(document).ready(function() {

    $('body').bind('init', function() {

        $('div.bhinputsearch').each(function() {

            var $search_button = $('<img src="' + beehive.images['search_button.png'] + '" class="search_button" />');

            var $search_input = $(this).find('input:text');

            if ($search_input.length != 1) return false;

            var popup_query = { 'webtag'   : beehive.webtag,
                                'obj_id'   : $search_input.attr('id'),
                                'type'     : $(this).hasClass('search_logon') ? 1 : 2,
                                'multi'    : $(this).hasClass('allow_multi') ? 'Y' : 'N',
                                'selected' : $search_input.val() };

            $search_button.bind('click', function() {
                window.open('search_popup.php?' + $.param(popup_query), null, beehive.window_options.join(','));
            });

            $search_button.appendTo($(this));
        });

        $('#select').bind('click', function() {

            var obj_id = $('#obj_id').val();

            window.opener.return_result(obj_id, $('input#selected:checked'));

            window.close();
        });
    });

    var return_result
});