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

var beehive = $.extend({}, beehive, {

    window_options : [ 'toolbox=0',
                       'location=0',
                       'directories=0',
                       'status=0',
                       'menubar=0',
                       'resizeable=yes',
                       'scrollbars=yes' ],

    ajax_error : function(message) {

        if ((typeof(console) !== 'undefined') && (typeof(console.log) !== 'undefined')) {
            console.log('AJAX ERROR', message);
        }
    },

    get_resize_width : function() {

        var $max_width = $(this).closest('.max_width[width]');

        if ($max_width.length > 0) {
            return $max_width.attr('width');
        }

        return $('body').prop('clientWidth');
    },

    get_frame_name : function(frame_name) {

        for(var key in beehive.frames) {
            if (beehive.frames[key] == frame_name) {
                return key;
            }
        }
    },

    reload_frame : function(context, frame_name) {

        $(context).find('frame').each(function() {

            if ($(this).attr('name') == frame_name) {

                $(this).attr('src', $(this).attr('src'));
                return false;
            }

            beehive.reload_frame(this.contentDocument, frame_name);
        });
    },

    reload_top_frame : function(context, src) {

        $(context).find('frame').each(function() {

            if ($(this).attr('name') == beehive.frames.ftop) {

                $(this).attr('src', src);
                return false;
            }

            beehive.reload_top_frame(this.contentDocument, src);
        });
    },

    reload_user_font : function(context) {

        $(context).find('frame').each(function() {

            if (!$.inArray($(this).attr('name'), beehive.frames)) {
                return true;
            }

            beehive.reload_user_font(this.contentDocument);
        });

        var $head = $(context).find('head');

        var $user_font = $head.find('link#user_font');

        $user_font.attr('href', beehive.forum_path + '/font_size.php?webtag=' + beehive.webtag + '&_=' + new Date().getTime() / 1000);
    },

    active_editor : null,

    init_editor : function() {

        CKEDITOR.on('dialogDefinition', function(event) {

            var dialogName = event.data.name;
            var dialogDefinition = event.data.definition;

            switch (dialogName) {

                case 'link':

                    dialogDefinition.removeContents('target');
                    dialogDefinition.removeContents('advanced');
                    dialogDefinition.minHeight = 150;
                    break;

                case 'image':

                    dialogDefinition.removeContents('Link');
                    dialogDefinition.removeContents('advanced');
                    break;

                case 'flash':

                    dialogDefinition.removeContents('advanced');
                    dialogDefinition.getContents('properties').remove('menu');
                    dialogDefinition.getContents('properties').remove('scale');
                    dialogDefinition.getContents('properties').remove('align');
                    dialogDefinition.getContents('properties').remove('bgcolor');
                    dialogDefinition.getContents('properties').remove('base');
                    dialogDefinition.getContents('properties').remove('flashvars');
                    dialogDefinition.getContents('properties').remove('allowScriptAccess');
                    dialogDefinition.getContents('properties').remove('allowFullScreen');
                    break;
            }
        });

        beehive.init_editor = function() {};
    },

    editor : function() {

        var $editor = $(this);

        var editor_id = $editor.attr('id');

        var skin = beehive.forum_path + '/styles/' + beehive.user_style + '/editor/';

        var emoticons = beehive.forum_path + '/emoticons/' + beehive.emoticons + '/style.css';

        var contents = skin + 'content.css';

        var toolbar = $editor.hasClass('mobile') ? 'mobile' : 'full';

        beehive.init_editor();

        $('<div id="toolbar">').insertBefore($editor);

        var editor = CKEDITOR.replace(editor_id, {
            browserContextMenuOnCtrl: true,
            contentsCss: [
                emoticons,
                contents
            ],
            customConfig: '',
            disableNativeSpellChecker: false,
            enterMode: CKEDITOR.ENTER_BR,
            extraPlugins: 'beehive,youtube',
            font_defaultLabel: 'Verdana',
            fontSize_defaultLabel: '12',
            height: $editor.height() - 35,
            width: $editor.width(),
            removePlugins: 'elementspath,contextmenu,tabletools,liststyle',
            resize_maxWidth: '100%',
            resize_minWidth: '100%',
            shiftEnterMode: CKEDITOR.ENTER_BR,
            skin: 'beehive,' + skin,
            startupFocus: $editor.hasClass('focus'),
            sharedSpaces : {
                top: 'toolbar'
            },
            toolbarCanCollapse: false,
            toolbar_mobile: [
                [
                    'Bold',
                    'Italic',
                    'Underline'
                ]
            ],
            toolbar_full: [
                [
                    'Bold',
                    'Italic',
                    'Underline',
                    'Strike',
                    'Superscript',
                    'Subscript',
                    'JustifyLeft',
                    'JustifyCenter',
                    'JustifyRight',
                    'NumberedList',
                    'BulletedList',
                    'Indent',
                    'Code',
                    'Quote',
                    'Spoiler',
                    'HorizontalRule',
                    'Image',
                    'Youtube',
                    'Flash',
                    'Link'
                ],
                [
                    'Font',
                    'FontSize',
                    'TextColor',
                    'Source'
                ]
            ],
            toolbar: toolbar
        });

        editor.on('focus', function(event) {
            beehive.active_editor = event.editor;
        });

        if ($editor.hasClass('quick_reply')) {

            var $post_button = $editor.closest('form').find('input#post');

            editor.on('key', function(event) {

                if (event.data.keyCode != CKEDITOR.CTRL + 13) {
                    return;
                }

                if (event.editor.getData().length == 0) {
                    return;
                }

                $editor.val(event.editor.getData());

                $post_button.click();
            });
        }
    },

    mobile_version : false
});

$.ajaxSetup({

    'cache' : true,

    'error' : function(data) {
        beehive.ajax_error(data);
    }
});

$(beehive).bind('init', function() {

    var frame_resize_timeout;

    beehive.mobile_version = $('body#mobile').length > 0;

    $('form[method="get"]').append(
        $('<input type="hidden" name="_">').val((new Date()).getTime())
    );

    $('.move_up_ctrl_disabled, .move_down_ctrl_disabled').bind('click', function() {
        return false;
    });

    $('select#mode').bind('change', function() {
        $(this).closest('form').submit();
    });

    $('a.popup').live('click', function() {

        var class_names = $(this).attr('class').split(' ');

        var window_options = beehive.window_options;

        var dimensions;

        for (var key = 0; key < class_names.length; key++) {

            dimensions = /^([0-9]+)x([0-9]+)$/.exec(class_names[key]);

            if (dimensions && dimensions[1] && dimensions[2]) {

                window_options.unshift('width=' + dimensions[1], 'height=' + dimensions[2]);
            }
        }

        window.open($(this).attr('href'), $(this).attr('id'), window_options.join(','));

        return false;
    });

    $('input#close_popup').bind('click', function() {
        window.close();
    });

    $('select.user_in_thread_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="in_thread"]').attr('checked', true);
    });

    $('select.recent_user_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="recent"]').attr('checked', true);
    });

    $('select.friends_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="friends"]').attr('checked', true);
    });

    $('input.post_to_others').bind('focus', function() {
        $('input[name="to_radio"][value="others"]').attr('checked', true);
    });

    $('input#toggle_all').bind('click', function() {

        var $checkboxes = $(this).closest('form').find('input:checkbox');
        $(this).attr('checked') ? $checkboxes.attr('checked', 'checked') : $checkboxes.removeAttr('checked');
    });

    $('a.font_size_larger, a.font_size_smaller').live('click', function() {

        var $this = $(this);

        var $parent = $this.closest('td');

        if (beehive.uid == 0) {
            return true;
        }

        $.ajax({
            'cache' : true,
            'data' : {
                'webtag' : beehive.webtag,
                'ajax'   : 'true',
                'action' : $this.attr('class'),
                'msg'    : $this.data('msg')
            },
            'dataType' : 'json',
            'url' : beehive.forum_path + '/ajax.php',
            'success' : function(data) {

                try {

                    $parent.html(data.html);

                    beehive.font_size = data.font_size;

                    beehive.reload_user_font(top.document);

                    $(top.document).find('frameset#index').attr('rows', '60,' + Math.max(beehive.font_size * 2, 22) + ',*');

                } catch (exception) {

                    beehive.ajax_error(exception);
                }
            }
        });

        return false;
    });

    $('#preferences_updated').each(function() {

        beehive.reload_frame(top.document, beehive.frames.fnav);
        beehive.reload_frame(top.document, beehive.frames.left);
        beehive.reload_top_frame(top.document, beehive.top_frame);
    });

    $('input#print').bind('click', function() {
        window.print();
    });

    $('a.button').bind('mousedown', function() {
        $(this).css('border', '1px inset');
    }).bind('mouseup mouseout', function() {
        $(this).css('border', '1px outset');
    });

    if ($('body').hasClass('window_title')) {
        top.document.title = document.title;
    }

    $(window).bind('resize', function() {

        var frame_name = $(this).attr('name');

        if ((frame_name != beehive.frames.left) && (frame_name != beehive.frames.pm_folders)) {
            return true;
        }

        if (beehive.uid == 0) {
            return true;
        }

        window.clearTimeout(frame_resize_timeout);

        frame_resize_timeout = window.setTimeout(function() {

            $.ajax({

                'cache' : true,

                'data' : {
                    'webtag' : beehive.webtag,
                    'ajax'   : true,
                    'action' : 'frame_resize',
                    'size'   : Math.max(100, this.innerWidth)
                },

                'url' : beehive.forum_path + '/ajax.php'
            });

        }, 500);
    });

    $('.toggle_button').bind('click', function() {

        var $button = $(this);

        var $element = $('.' + $button.attr('id'));

        if ($element.is(':visible')) {

            $element.slideUp(150, function() {

                $button.attr('src', beehive.images['show.png']);

                $.ajax({

                    'cache' : true,

                    'data' : {
                        'webtag'  : beehive.webtag,
                        'ajax'    : true,
                        'action'  : $button.attr('id'),
                        'display' : 'false'
                    },

                    'url' : beehive.forum_path + '/ajax.php'
                });
            });

        } else {

            $element.slideDown(150, function() {

                $button.attr('src', beehive.images['hide.png']);

                $.ajax({

                    'cache' : true,

                    'data' : {
                        'webtag'  : beehive.webtag,
                        'ajax'    : true,
                        'action'  : $button.attr('id'),
                        'display' : 'true'
                    },

                    'url' : beehive.forum_path + '/ajax.php',

                    'success' : function() {
                        $element.find('textarea.editor:visible').each(beehive.editor);
                    }
                });
            });
        }

        return false;
    });

    $('textarea.editor:visible').each(beehive.editor);

    $('input, textarea').placeholder();

    if (beehive.show_share_links == 'Y') {

        $.getScript(document.location.protocol + '//apis.google.com/js/plusone.js');

        $.getScript(document.location.protocol + '//platform.twitter.com/widgets.js');

        $.getScript(document.location.protocol + '//connect.facebook.net/en_US/all.js');
    }
});