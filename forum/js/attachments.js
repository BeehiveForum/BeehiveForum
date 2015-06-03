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

$(top.window.beehive).bind('init', function () {

    $('input#toggle_main').bind('click', function () {
        var $checkboxes = $(this).closest('table.posthead').find('input:checkbox');
        $(this).prop('checked') ? $checkboxes.prop('checked', 'checked') : $checkboxes.removeAttr('checked');
    });

    var format_file_size = function (filesize) {

        var b = 0;

        while (99 < filesize) {
            filesize /= 1024;
            b++;
        }

        return (Math.floor(filesize * 100) / 100).toFixed(2) + "B kB MB GB TB PB EB".split(" ")[b];
    };

    var format_file_name = function (filename) {

        33 < filename.length && (filename = filename.slice(0, 19) + "&hellip;" + filename.slice(-13));
        return filename
    };

    $('.attachments').each(function () {

        var $attachments = $(this);

        var $buttons = $attachments.find('.buttons');

        var $attachment_list = $attachments.find('ul');

        var $used_post_space = $attachments.find('span.used_post_space');

        var $free_post_space = $attachments.find('span.free_post_space');

        var $free_upload_space = $attachments.find('span.free_upload_space');

        $buttons.append($('<a class="button upload">' + top.window.beehive.lang['upload'] + '</a>')).append('&nbsp;');

        $buttons.append($('<a class="button delete" style="display: none">' + top.window.beehive.lang['delete'] + '</a>'));

        var $upload_button = $buttons.find('a.button.upload');

        var $delete_button = $buttons.find('a.button.delete');

        var refresh_summary = function () {

            var $selected = $attachments.find('li.attachment').has('input:checkbox:checked');

            $.ajax({
                data: {
                    webtag: top.window.beehive.webtag,
                    ajax: true,
                    summary: true,
                    hashes: $.map($selected, function (selected) {
                        return $(selected).data('hash');
                    })
                },
                type: 'POST',
                url: 'attachments.php',
                success: function (response) {

                    //noinspection JSUnresolvedVariable
                    $used_post_space.text(response.used_post_space);

                    //noinspection JSUnresolvedVariable
                    $free_post_space.text(response.free_post_space);

                    //noinspection JSUnresolvedVariable
                    $free_upload_space.text(response.free_upload_space);
                }
            });
        };

        if ($attachments.find('li.attachment input:checkbox:checked').length > 0) {
            $delete_button.show();
        }

        //noinspection JSUnresolvedVariable
        var uploader = new qq.FineUploaderBasic({

            button: $upload_button[0],

            debug: false,

            request: {
                endpoint: 'attachments.php',
                params: {
                    webtag: top.window.beehive.webtag
                },
                forceMultipart: false,
                inputName: 'upload[]'
            },

            validation: {
                sizeLimit: top.window.beehive.attachment_size_limit
            },

            callbacks: {

                onSubmit: function (id, filename) {

                    $attachment_list.append($.vsprintf(
                        '<li class="attachment" data-hash="%(0)s">\
                           <label>\
                             <input checked="checked" class="bhinputcheckbox" name="attachment[]" type="checkbox" value="%(0)s" />\
                             <span class="image"></span>\
                             <span class="filename">%(1)s</span>\
                             <span class="progress"></span>\
                             <span class="retry" title="%(2)s">%(2)s</span>\
                             <span class="cancel" title="%(3)s">%(3)s</span>\
                             <span class="filesize"></span>\
                           </label>\
                         </li>',
                        [
                            [
                                id,
                                format_file_name(filename),
                                top.window.beehive.lang.retry,
                                top.window.beehive.lang.cancel
                            ]
                        ]
                    ));
                },

                onUpload: function (id) {

                    $attachment_list.find('li.attachment[data-hash="' + id + '"]')
                        .removeClass('error')
                        .addClass('uploading');
                },

                onCancel: function (id) {

                    $attachment_list.find('li.attachment[data-hash="' + id + '"]')
                        .removeClass('error')
                        .removeClass('uploading')
                        .addClass('cancelled');
                },

                onProgress: function (id, filename, loaded, total) {

                    $attachment_list.find('li.attachment[data-hash="' + id + '"]')
                        .find('span.progress')
                        .html(Math.round(loaded / total * 100) + '%');

                    $attachment_list.find('li.attachment[data-hash="' + id + '"]')
                        .find('span.filesize')
                        .html(format_file_size(total));
                },

                onComplete: function (id, filename, responseJSON) {

                    var $attachment = $attachment_list.find('li.attachment[data-hash="' + id + '"]');

                    var $input = $attachment.find('input:checkbox');

                    var $filename = $attachment.find('span.filename');

                    //noinspection JSUnresolvedVariable
                    $attachment.data('hash', responseJSON.attachment.hash)
                        .removeClass('uploading')
                        .addClass(responseJSON.success ? 'complete' : 'error');

                    //noinspection JSUnresolvedVariable
                    $input.val(responseJSON.attachment.hash);

                    //noinspection JSUnresolvedVariable
                    $filename.html(
                        '<a href="'
                        + top.window.beehive.forum_path
                        + '/get_attachment.php?webtag='
                        + encodeURIComponent(top.window.beehive.webtag)
                        + '&amp;hash='
                        + encodeURIComponent(responseJSON.attachment.hash)
                        + '&amp;filename='
                        + encodeURIComponent(filename)
                        + '">'
                        + filename
                        + '</a>'
                    );

                    if ($attachments.find('li.attachment input:checkbox:checked').length > 0) {

                        $delete_button.show();
                        refresh_summary();
                    }
                },

                onError: function (id, filename, errorReason) {

                    $attachment_list.find('li.' + id + '.attachment')
                        .removeClass('uploading')
                        .addClass('error');

                    alert(errorReason);
                }
            }
        });

        $attachments.on('click', 'span.retry', function () {
            uploader.retry($(this).closest('li.attachment').data('hash'));
        });

        $attachments.on('click', 'span.cancel', function () {

            uploader.cancel($(this).closest('li.attachment').data('hash'));
            $(this).closest('li.attachment').remove();
        });

        $attachments.on('change', 'input:checkbox', function () {

            if ($attachments.find('li.attachment input:checkbox:checked').length > 0) {
                $delete_button.show();
            } else {
                $delete_button.hide();
            }

            refresh_summary();
        });

        $delete_button.on('click', function () {

            var $selected = $attachments.find('li.attachment').has('input:checkbox:checked');

            if ($selected.length == 0) {
                return;
            }

            //noinspection JSUnresolvedVariable
            if (!window.confirm(top.window.beehive.lang.deleteattachmentconfirmation)) {
                return;
            }

            $.ajax({
                data: {
                    webtag: top.window.beehive.webtag,
                    ajax: true,
                    delete: true,
                    hashes: $.map($selected, function (selected) {
                        return $(selected).data('hash');
                    })
                },
                type: 'POST',
                url: 'attachments.php',
                success: function () {

                    $selected.remove();

                    if ($attachments.find('li.attachment.complete').length == 0) {
                        $delete_button.hide();
                    }

                    refresh_summary();
                }
            });
        });
    });
});