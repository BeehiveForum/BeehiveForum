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

/* $Id: search.js,v 1.31 2010/01/24 20:07:10 decoyduck Exp $ */

$(beehive).bind('init', function() {

    var search_logon = false;

    var return_result = function(obj_name, value) {
        $(obj_name).val(value);
    }

    $('a.logon_search').bind('click', function() {

        var $search_field = $('input.search_logon');

        var window_options = beehive.window_options;

        var search_query = { 'webtag'    : webtag,
                             'type'      : '1',
                             'selection' : $search_field.val(),
                             'obj_name'  : $search_field.attr('name') }

        if ($(this).hasClass('allow_multi')) {
            search_query['allow_multi'] = 'Y';
        }

        search_logon = window.open('search_popup.php?' + $.param(search_query), $(this).attr('id'), window_options.join(','));

        search_logon.return_result = return_result;
    });

    $('#search_submit').bind('click', function() {

        $(this).addClass('button_disabled').attr('disabled', 'true');
        $('#search_reset').addClass('button_disabled').attr('disabled', 'true');
    });

    $('div#search_success').each(function() {

        if (top.document.body.rows) {
            top.frames[beehive.frames.main].frames[beehive.frames.left].location.replace('search.php?webtag=' + beehive.webtag + '&offset=0');
        } else if (top.document.body.cols) {
            top.frames[beehive.frames.left].location.replace('search.php?webtag=$webtag&offset=0');
        }

        $(this).find('.success_msg_text').html($.sprintf(beehive.lang['searchsuccessfullycompleted'], ''));
    });
});