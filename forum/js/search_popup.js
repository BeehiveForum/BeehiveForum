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

    $('div.bhinputsearch').each(function() {

        var $container = $(this);

        var $search_input = $container.find('input:text');

        if ($search_input.length != 1) return false;
        
        var $search_button = $('<img src="' + beehive.images['search_button.png'] + '" class="search_button" />');
        
        $search_button.bind('click', function() {

            var popup_query = { 'webtag'   : beehive.webtag,
                                'obj_id'   : $search_input.attr('id'),
                                'type'     : $container.hasClass('search_logon') ? 1 : 2,
                                'multi'    : $container.hasClass('allow_multi') ? 'Y' : 'N',
                                'selected' : $search_input.val() };

            window.open('search_popup.php?' + $.param(popup_query), null, beehive.window_options.join(','));
        });

        $search_button.appendTo($container);
        
        $search_button.load(function() {
            $search_input.css('width', $container.width() - $(this).width());
        });
        
        if ($container.hasClass('search_logon')) {
        
            $search_input.autocomplete('json.php', {
                
                selectFirst : false,
                
                extraParams : { 'ajax'   : true,
                                'search' : true },
                
                formatItem : function(item) {
                    var data = JSON.parse(item);
                    return $.sprintf('%s (%s)', data['NICKNAME'], data['LOGON']);
                },
                
                formatResult : function(item) {
                    var data = JSON.parse(item);
                    return data['LOGON'];
                }
            });
        }
    });

    $('#select').bind('click', function() {

        var obj_id = $('#obj_id').val();

        var $search_input = $('#' + obj_id, window.opener.document);

        if ($search_input.length > 0) {

            $search_container = $search_input.closest('div.bhinputsearch');

            if ($search_container.length != 1) return false;

            var result_array = [];

            $('input[name^=selected]:checked').each(function() {

                result_array.push($(this).val());
                return $search_container.hasClass('allow_multi');
            });

            $search_input.val(result_array.join(';'));
        }

        window.close();
    });
});