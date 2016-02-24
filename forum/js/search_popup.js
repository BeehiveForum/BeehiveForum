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

    $('input.search_input').each(function () {

        var $search_input = $(this);

        var $container = $('<div class="bhinputsearch">');

        var $search_button = $('<span class="image search_button">');

        $search_button.bind('click', function () {

            var popup_query = {
                webtag: beehive.webtag,
                obj_id: $search_input.prop('id'),
                type: $search_input.hasClass('search_logon') ? 1 : 2,
                multi: $search_input.hasClass('allow_multi') ? 'Y' : 'N',
                selected: $search_input.val()
            };

            window.open('search_popup.php?' + $.param(popup_query), 'search_popup', beehive.window_options.join(','));
        });

        $search_input.before($container);

        $search_input.appendTo($container);

        $search_button.appendTo($container);

        $search_input.css({
            border: 'none',
            width: $search_input.width() - $search_button.width()
        });

        if ($search_input.hasClass('search_logon')) {

            $search_input.autocomplete({

                minLength: 2,

                source: function (request, response) {

                    var term = request.term;

                    if ($search_input.hasClass('multiple')) {
                        term = term.split(/,\s*/).pop();
                    }

                    $.ajax({
                        cache: false,
                        data: {
                            webtag: beehive.webtag,
                            ajax: true,
                            action: 'user_autocomplete',
                            term: term
                        },
                        url: 'ajax.php',
                        success: function (data) {

                            //noinspection JSUnresolvedVariable
                            response($.map(data.results_array, function (item) {

                                //noinspection JSUnresolvedVariable
                                return {
                                    label: item.NICKNAME + ' (' + item.LOGON + ')',
                                    value: item.LOGON
                                };
                            }));
                        }
                    });
                },
                open: function () {
                    $('.ui-autocomplete').width($search_input.width() + 30);
                },
                focus: function () {
                    return false;
                },
                select: function (event, ui) {

                    if (!$search_input.hasClass('multiple')) {

                        this.value = ui.item.value;
                        return false;
                    }

                    var terms = this.value.split(/,\s*/);

                    terms.pop();

                    terms.push(ui.item.value);

                    terms.push('');

                    this.value = terms.join(', ');

                    return false;
                }
            });
        }
    });

    $('#select').bind('click', function () {

        var obj_id = $('#obj_id').val();

        var $search_input = $('#' + obj_id, window.opener.document);

        if ($search_input.length > 0) {

            var $search_container = $search_input.closest('div.bhinputsearch');

            if ($search_container.length !== 1) {
                return;
            }

            var result_array = [];

            $('input[name^=selected]:checked').each(function () {
                result_array.push($(this).val());
                return $search_input.hasClass('allow_multi');
            });

            $search_input.val(result_array.join(', '));
        }

        window.close();
    });
});