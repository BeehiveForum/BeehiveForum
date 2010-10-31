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

var beehive = $.extend({}, beehive, {

    window_options : [ 'toolbox=0',
                       'location=0',
                       'directories=0',
                       'status=0',
                       'menubar=0',
                       'resizeable=yes',
                       'scrollbars=yes' ],

    get_resize_width : function() {
        
        var $max_width = $(this).closest('.max_width[width]');
        
        if ($max_width.length > 0) {
            return $max_width.attr('width');
        }
        
        return $('body').attr('clientWidth');
    },
    
    get_frame_name : function(frame_name) {
        
        for(var key in beehive.frames) {
            if (beehive.frames[key] == frame_name) return key;
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
            
            if (!$.inArray($(this).attr('name'), beehive.frames)) return true;
                
            var $head = $(this.contentDocument).find('head');
            
            var $user_font = $head.find('link#user_font');
            
            $user_font.attr('href', beehive.forum_path + '/font_size.php?webtag=' + beehive.webtag + '&_=' + new Date().getTime() / 1000);
            
            beehive.reload_user_font(this.contentDocument);
        });
    }
});

$.ajaxSetup({
    cache: true
});

$(beehive).bind('init', function() {
    
    var frame_resize_timeout;
    
    $('.move_up_ctrl_disabled, .move_down_ctrl_disabled').bind('click', function() {
        return false;
    });

    $('#thread_mode').bind('change', function() {
        $(this).closest('form').submit();
    });

    $('a.popup').live('click', function() {

        var class_names = $(this).attr('class').split(' ');

        var window_options = beehive.window_options;

        for (var key in class_names) {

            if (dimensions = /^([0-9]+)x([0-9]+)$/.exec(class_names[key])) {

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
        $(this).closest('form').find('input:checkbox').attr('checked', $(this).attr('checked'));
    });

    $('a.font_size').live('click', function() {

        $parent = $(this).closest('td');
        
        if (beehive.uid == 0) return true;

        $.ajax({
            
            'cache': false,
            'url' : $(this).attr('href'),
            'data' : {
                'webtag' : beehive.webtag,
                'json' : 'true'
            },
            'success' : function(data) {
                
                if (!data.success) return false;
                
                $parent.html(data.html);

                beehive.font_size = data.font_size;
                
                beehive.reload_user_font(top.document);
                
                $(top.document).find('frameset#index').attr('rows', '60,' + Math.max(beehive.font_size * 2, 22) + ',*');
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
        
        if ($(this).attr('name') != beehive.frames.left) return;
        
        window.clearTimeout(frame_resize_timeout);
        
        frame_resize_timeout = window.setTimeout(function() {
            
            $.ajax({
                
                'cache' : false,
                
                'data' : { 
                    'webtag' : beehive.webtag,
                    'frame_resize' : this.innerWidth
                },
                
                'url' : beehive.forum_path + '/user.php'                
            });
            
        }, 500);    
    });
});