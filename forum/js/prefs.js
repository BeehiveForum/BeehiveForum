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

    $('.upload').each(function() {

        var $option;

        var $upload = $(this);

        var $select = $upload.closest('td').find('select');

        var $upload_button = $('<a class="button upload">').text(beehive.lang['upload']);

        var $cancel_button = $('<a class="button cancel" style="display: none">').text(beehive.lang['cancel']);

        $upload.append($upload_button).append('&nbsp;').append($cancel_button);

        var uploader = new qq.FineUploaderBasic({

            button: $upload_button[0],

            debug: false,

            request: {
                endpoint: 'attachments.php',
                params: {
                    webtag: beehive.webtag
                },
                forceMultipart: false,
                inputName: 'upload[]'
            },

            callbacks: {

                onSubmit: function(id, filename) {

                    $option = $('<option value="upload">')
                        .attr('selected', true)
                        .text('Uploading&hellip;');

                    $select.append($option);

                    $upload_button.hide();

                    $cancel_button.show();
                },

                onCancel: function(id, filename) {

                    $option.remove();

                    $cancel_button.hide();

                    $upload_button.show();
                },

                onProgress: function(id, filename, loaded, total) {
                   $option.html('Uploading&hellip; ' + Math.round(loaded / total * 100) + '%');
                },

                onComplete: function(id, filename, responseJSON) {

                    $.ajax({
                        'cache' : true,
                        'data' : {
                            'webtag' : beehive.webtag,
                            'ajax'   : 'true',
                            'action' : 'pref_attachment',
                            'type'   : $select.attr('id')
                        },
                        'dataType' : 'json',
                        'url' : beehive.forum_path + '/ajax.php',
                        'success' : function(data) {

                            $option.remove();

                            $cancel_button.hide();

                            $upload_button.show();

                            $select.find('option').remove();

                            for (var key in data) {
                                $select.append($('<option>').val(key).html(data[key]));
                            }

                            $select.find('option[value=' + responseJSON.attachment.aid + ']').attr('selected', true);
                        }
                    });
                },

                onError: function(id, filename, errorReason) {

                    $option.remove();

                    $cancel_button.hide();

                    $upload_button.show();

                    alert(errorReason);
                }
            }
        });

        $cancel_button.on('click', function() {
            uploader.cancel($option.data('id'));
        });
    });
});