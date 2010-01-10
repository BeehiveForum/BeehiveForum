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

/* $Id: dictionary.js,v 1.33 2010-01-10 14:26:27 decoyduck Exp $ */

function read_content(obj_id) {
    return $('#' + obj_id).val();
}

function update_content(obj_id, content) {
    $('#' + obj_id).val(content);
}

$(document).ready(function() {

    $('body').bind('init', function() {

        var obj_id = $('#obj_id').val();

        var $content = $('#content');

        $('#dictionary_init').each(function() {

            $content.val(window.opener.read_content(obj_id));
            $(this).submit();
        });

        $('span#highlighted_word').each(function() {
            this.scrollIntoView(false);
        });

        $('#suggestions').bind('change', function() {
            $('#change_to').val($(this).val());
        });

        $('#close').bind('click', function() {
            window.opener.update_content(obj_id, $content.val());
            window.close();
        });

        $('#cancel').bind('click', function() {
            window.close();
        });
    });
});