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

    beehive.quote_list = [];

    var hide_post_options_containers = function() {

        $('.post_options_container').each(function() {

            var $post_options_container = $(this);

            var $link = $(this).prev('span.post_options');

            if ($link.length == 1) {

                var link_offset = $link.offset();

                $post_options_container.hide();

                $post_options_container.css('top', link_offset.top + $link.height());

                $post_options_container.find('*').css('margin-left', -9999);
            }
        });
    };

    $('span.post_options').each(function() {

        var $link = $(this);

        $link.html(beehive.lang.more +'&nbsp;<img class="post_options" src="' + beehive.images['post_options.png'] + '" border="0" />');

        $link.bind('click', function() {

            hide_post_options_containers();

            if ($link.next('.post_options_container').length < 1) {

                $.ajax({

                    'cache' : true,

                    'data' : {
                        'webtag' : beehive.webtag,
                        'ajax'   : 'true',
                        'action' : 'post_options',
                        'msg'    : $link.attr('id').match(/post_options_([^\.]+\.[^\.]+)/)[1]
                    },

                    'url' : beehive.forum_path + '/ajax.php',

                    'success' : function(data) {

                        try {

                            $link.after(data);

                            $link.triggerHandler('click');

                        } catch (exception) {

                            beehive.ajax_error(exception);
                        }
                    }
                });

                return;
            }

            var $post_options_container = $link.next('.post_options_container');

            if ($post_options_container.length != 1) {
                 return;
            }

            var link_offset = $link.offset();

            $post_options_container.show();

            var container_offset = $post_options_container.offset();

            if (((container_offset.top - $(window).scrollTop()) + $post_options_container.height()) > $(window).height()) {
                $post_options_container.css('top', Math.floor(link_offset.top - $post_options_container.height()));
            } else {
                $post_options_container.css('top', Math.floor(link_offset.top + $link.height()));
            }

            $post_options_container.find('*').css('margin-left', 0);
            $post_options_container.css('left', Math.floor(link_offset.left - ($post_options_container.width() - $link.width())));

            return false;
        });
    });

    $('body').bind('click', function() {
        hide_post_options_containers();
    });

    $('#quick_reply_container input#cancel').bind('click', function() {

        if (CKEDITOR.instances.t_content) {
            CKEDITOR.instances.t_content.destroy();
        }

        $('#quick_reply_container').hide();
    });

    $('.quick_reply_link').live('click', function() {

        $('.post_options_container').hide();

        $('.post_options_container').find('*').css('margin-left', -9999);

        var quick_reply_data = /^([0-9]+)\.([0-9]+)$/.exec($(this).attr('rel'));

        if (CKEDITOR.instances.t_content) {
            CKEDITOR.instances.t_content.destroy();
        }

        if (quick_reply_data.length === 3) {

            var $quick_reply_location = $('#quick_reply_' + quick_reply_data[2]);

            var $quick_reply_container = $('#quick_reply_container');

            if ($quick_reply_location.length == 1) {

                $quick_reply_container.find('#t_rpid').val(quick_reply_data[2]);

                $quick_reply_container.appendTo($quick_reply_location).show();

                $quick_reply_container.find('#t_content').each(beehive.editor);

                $quick_reply_container.find('input#post').get(0).scrollIntoView(false);
            }
        }
    });

    $('a[id^="quote_"]').bind('click', function() {

        var pid = $(this).attr('rel');

        if ($.inArray(pid, beehive.quote_list) < 0) {

            $('img#quote_img_' + pid).attr('src', beehive.images['quote_enabled.png']);

            $(this).html(beehive.lang.unquote);

            beehive.quote_list.push(pid);

        } else {

            $('img#quote_img_' + pid).attr('src', beehive.images['quote_disabled.png']);

            $(this).html(beehive.lang.quote);

            for (var check_post_id in beehive.quote_list) {

                if (beehive.quote_list[check_post_id] == pid) {
                    beehive.quote_list.splice(check_post_id, 1);
                }
            }
        }

        $('a[id^="reply_"]').each(function() {

            var query_string = $.parseQuery($(this).attr('href').split('?')[1]);

            query_string.quote_list = beehive.quote_list.join(',');

            $(this).attr('href', 'post.php?' + $.param(query_string));
        });

        return false;
    });

    var $attachments = $('div#attachments');

    var $attachment_list = $attachments.find('ul');

    var $upload_button = $('<a class="button upload">Upload</a>');

    var $delete_button = $('<a class="button delete" style="display: none">Delete</a>');

    var format_file_size = function(filesize) {

        var b = -1;

        do filesize /= 1024, b++; while(99 < filesize);

        return Math.max(filesize, 0.1).toFixed(1) + "kB MB GB TB PB EB".split(" ")[b];
    };

    var format_file_name = function(filename) {

        33 < filename.length && (filename = filename.slice(0, 19) + "&hellip;" + filename.slice(-13));
        return filename
    };

    $attachments.append($upload_button).append('&nbsp;').append($delete_button);

    if ($attachments.find('li.file.complete').length > 0) {
        $delete_button.show();
    }

    var uploader = new qq.FineUploaderBasic({

        button: $upload_button[0],

        debug: false,

        request: {
            endpoint: 'attachments.php',
            params: {
                webtag: beehive.webtag,
                aid: $('input#aid').val(),
                ajax: true
            },
            forceMultipart: false,
            inputName: 'file[]'
        },

        callbacks: {

            onSubmit: function(id, filename) {

                $attachment_list.append($.vsprintf(
                    '<li class="file" id="%(0)s">\
                       <label for="file-%(0)s">\
                         <input type="checkbox" id="file-%(0)s">\
                         <span class="filename">%(1)s</span>\
                         <span class="filesize"></span>\
                         <span class="progress"></span>\
                       </label>\
                       <span class="retry" title="%(2)s">%(2)s</span>\
                       <span class="cancel" title="%(3)s">%(3)s</span>\
                     </li>',
                    [[
                        id,
                        format_file_name(filename),
                        beehive.lang.retry,
                        beehive.lang.cancel
                    ]]
                ));
            },

            onUpload: function(id, filename) {

                $attachment_list.find('li#' + id + '.file')
                    .removeClass('error')
                    .addClass('uploading');
            },

            onCancel: function(id, filename) {

                $attachment_list.find('li#' + id + '.file')
                    .removeClass('error')
                    .removeClass('uploading')
                    .addClass('cancelled');
            },

            onProgress: function(id, filename, loaded, total) {

                $attachment_list.find('li#' + id + '.file')
                    .find('span.progress')
                    .html(Math.round(loaded / total * 100) + '%');

                $attachment_list.find('li#' + id + '.file')
                    .find('span.filesize')
                    .html(format_file_size(total));
            },

            onComplete: function(id, filename, responseJSON) {

                var $file = $attachment_list.find('li#' + id + '.file');

                var $label = $file.find('label');

                var $input = $file.find('input:checkbox');

                var $filename = $file.find('span.filename');

                $file.attr('id', responseJSON.hash)
                    .removeClass('uploading')
                    .addClass(responseJSON.success ? 'complete' : 'error');

                $label.attr('for', 'file-' + responseJSON.hash);

                $input.attr('id', 'file-' + responseJSON.hash);

                $filename.html(
                    '<a href="'
                    + beehive.forum_path
                    + '/get_attachment.php?webtag='
                    + encodeURIComponent(beehive.webtag)
                    + '&amp;hash='
                    + encodeURIComponent(responseJSON.hash)
                    + '&amp;filename='
                    + encodeURIComponent(filename)
                    + '">'
                    + filename
                    + '</a>'
                );

                $delete_button.show();
            },

            onError: function(id, filename, errorReason) {

                $attachment_list.find('li#' + id + '.file')
                    .removeClass('uploading')
                    .addClass('error');
            }
        }
    });

    $attachments.on('click', 'span.retry', function() {
        uploader.retry($(this).closest('li.file').attr('id'));
    });

    $attachments.on('click', 'span.cancel', function() {

        uploader.cancel($(this).closest('li.file').attr('id'));

        $(this).closest('li.file').remove();
    });

    $delete_button.on('click', function() {

        var hashes = [];

        var $files = $attachments.find('li.file').has('input:checked').each(function() {
            hashes.push($(this).attr('id'));
        });

        $.ajax({
            data: {
                webtag: beehive.webtag,
                aid: $('input#aid').val(),
                ajax: true,
                delete_confirm: true,
                attachments_delete_confirm: hashes
            },
            type: 'POST',
            url: 'attachments.php',
            success: function(response) {

                $files.remove();

                if ($attachments.find('li.file.complete').length == 0) {
                    $delete_button.hide();
                }
            }
        });
    });
});