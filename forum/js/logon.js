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

/* $Id: logon.js,v 1.12 2010-01-24 20:07:10 decoyduck Exp $ */

$(beehive).bind('init', function() {

    $('select#user_logon').bind('change', function() {

        var $selected = $('select#user_logon option:selected');

        if ($selected.hasClass('bhlogonother')) {

            $(this).replaceWith('<input id="user_logon" name="user_logon" class="bhinputlogon" />');

            $('input#user_password').val('');

            $('#remember_user').attr('checked', false);

            $('label[name="label_auto_logon"]').addClass('bhinputcheckboxdisabled');
            $('#auto_logon').attr('checked', false);
            $('#auto_logon').attr('disabled', true);

            $('input#user_logon').focus();

        } else {

            var $selected_password = $('#user_password' + $selected.attr('index'));
            var $selected_passhash = $('#user_passhash' + $selected.attr('index'));

            if (/^[A-Fa-f0-9]{32}$/.test($selected_passhash.val()) == true) {

                $('input#user_password').val($selected_password.val());
                $('input#user_passhash').val($selected_passhash.val());

                $('#remember_user').attr('checked', true);

            } else {

                $('input#user_password').val('');
                $('input#user_passhash').val('');

                $('#remember_user').attr('checked', false);
            }
        }
    });

    $('input#user_logon').bind('change', function() {
        $('input#user_password').val('');
    });

    $('#auto_logon').bind('click', function() {
        $(this).attr('defaultChecked', $(this).attr('checked'));
    });

    $('#remember_user').bind('click', function() {

        if ($(this).attr('checked')) {

            $('label[name="label_auto_logon"]').removeClass('bhinputcheckboxdisabled');
            $('#auto_logon').attr('checked', $('#auto_logon').attr('defaultChecked'));
            $('#auto_logon').attr('disabled', false);

        } else {

            $('label[name="label_auto_logon"]').addClass('bhinputcheckboxdisabled');
            $('#auto_logon').attr('checked', false);
            $('#auto_logon').attr('disabled', true);
        }
    });
    
    $('#auto_logon').attr('disabled', !$('#remember_user').attr('checked'));
});