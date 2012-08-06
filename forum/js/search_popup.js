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

    $('input.search_input').each(function() {

        var $search_input = $(this);

        var $container = $('<div class="bhinputsearch">');
        
        var $search_button = $('<img src="' + beehive.images['search_button.png'] + '" class="search_button" />');
        
        $search_button.bind('click', function() {

            var popup_query = { 
                'webtag' : beehive.webtag,
                'obj_id' : $search_input.attr('id'),
                'type' : $search_input.hasClass('search_logon') ? 1 : 2,
                'multi' : $search_input.hasClass('allow_multi') ? 'Y' : 'N',
                'selected' : $search_input.val() 
            };

            window.open('search_popup.php?' + $.param(popup_query), null, beehive.window_options.join(','));
        });

        $search_button.load(function() {
            
            $search_input.css({
                'border' : 'none',
                'width' : $search_input.width() - ($(this).width()),
            });
        });
        
        $search_input.before($container);
        
        $search_input.appendTo($container);
        
        $search_button.appendTo($container);
        
        if ($search_input.hasClass('search_logon')) {
            
            $search_input.autocomplete({
                
                'minLength': 2,

                'source': function(request, response) {
                    
                    $.ajax({
                        'cache' : false,
                        'data' : {
                            'webtag' : beehive.webtag,
                            'ajax' : true,
                            'action' : 'user_autocomplete',
                            'term' : request.term,
                        },
                        'url' : beehive.forum_path + '/ajax.php',
                        'success': function(data) {
                            
                            response($.map(data.results_array, function(item) {
                                return {
                                    'label': item.NICKNAME + ' (' + item.LOGON + ')',
                                    'value': item.LOGON
                                };
                            }));
                        },
                    });
                },
                'open': function(){
                    $('.ui-autocomplete').width($search_input.width() + 30);
                },
            });
        }
    });

    $('#select').bind('click', function() {

        var obj_id = $('#obj_id').val();

        var $search_input = $('#' + obj_id, window.opener.document);

        if ($search_input.length > 0) {

            var $search_container = $search_input.closest('div.bhinputsearch');

            if ($search_container.length != 1) {
                 return false;
            }

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