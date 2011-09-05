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

/* $Id: post.js 4775 2011-07-15 12:22:47Z decoyduck $ */

$(beehive).bind('init', function() {

    var add_process_running = false;

    var toggle_add_buttons = function()
    {
        $('button.add_question, button.add_option').toggleClass('disabled', !($('div.poll_options_list ol li').length < 20));
    };

    var toggle_delete_buttons = function()
    {
        var $poll_questions = $('fieldset.poll_question');

        $poll_questions.each(function() {

            var $delete_buttons = $(this).find('button.delete_option');
            $delete_buttons.toggleClass('disabled', $delete_buttons.length == 1);
        });

        var $delete_buttons = $poll_questions.find('button.delete_question');
        $delete_buttons.toggleClass('disabled', $delete_buttons.length == 1);
    }

    var hide_delete_buttons = function()
    {
        $(this).find('button.delete_question, button.delete_option').hide();
    };

    hide_delete_buttons.call($('body'));

    $('div.poll_question_input').live('mouseenter', function() {

        $(this).find('button.delete_question').show();

    }).live('mouseleave', function() {

        $(this).find('button.delete_question').hide();
    });

    $('div.poll_options_list ol li').live('mouseenter', function() {

        $(this).find('button.delete_option').show();

    }).live('mouseleave', function() {

        $(this).find('button.delete_option').hide();
    });

    $('button.delete_question').live('click', function() {

        if ($(this).hasClass('disabled')) return false;

       if (!window.confirm('Are you sure you want to delete this question?')) {
           return false;
       }

       $(this).closest('fieldset').hide(300, function() {

           $(this).remove();

           toggle_add_buttons();

           toggle_delete_buttons();
       });

       return false;
    });

    $('button.delete_option').live('click', function() {

        if ($(this).hasClass('disabled')) return false;

       if (!window.confirm('Are you sure you want to delete this option?')) {
           return false;
       }

       $(this).closest('li').hide(300, function() {

           $(this).remove();

           toggle_add_buttons();

           toggle_delete_buttons();
       });

       return false;
    });

    $('button.add_option').live('click', function() {

        if ($(this).hasClass('disabled')) return false;

        if (add_process_running) return false;

        var $poll_question_fieldset = $(this).closest('fieldset.poll_question');

        var $poll_options_list = $poll_question_fieldset.find('div.poll_options_list ol');

        var question_number = $('fieldset.poll_question').index($poll_question_fieldset) + 1;

        var option_number = $poll_question_fieldset.find('li').length + 1;

        add_process_running = true;

        $.ajax({

            'cache' : true,

            'data' : {
                'webtag' : beehive.webtag,
                'ajax' : 'true',
                'action' : 'poll_add_option',
                'question_number' : question_number,
                'option_number' : option_number
            },

            'url' : beehive.forum_path + '/ajax.php',

            'success' : function(data) {

                var $data = $(data);

                hide_delete_buttons.call($data);

                $data.hide().appendTo($poll_options_list).show(200, function() {

                    $(this).css('display', 'list-item');

                    toggle_add_buttons();

                    toggle_delete_buttons();

                    add_process_running = false;
                });
            }
        });

        return false;
    });

    $('button#add_question').bind('click', function() {

        if ($(this).hasClass('disabled')) return false;

        if (add_process_running) return false;

        var $poll_questions_container = $('.poll_questions_container');

        var question_number = $poll_questions_container.find('fieldset.poll_question').length + 1;

        add_process_running = true;

        $.ajax({

            'cache' : true,

            'data' : {
                'webtag' : beehive.webtag,
                'ajax' : 'true',
                'action' : 'poll_add_question',
                'question_number' : question_number
            },

            'url' : beehive.forum_path + '/ajax.php',

            'success' : function(data) {

                var $data = $(data);

                hide_delete_buttons.call($data);

                $data.hide().appendTo($poll_questions_container).show(200, function() {

                    toggle_add_buttons();

                    toggle_delete_buttons();

                    add_process_running = false;
                });
            }
        });

        return false;
    });

    $('.poll_bar_vertical .poll_bar_inner').animate({
        'bottom' : 0
    }, 2000);

    $('.poll_bar_horizontal .poll_bar_inner').animate({
        'left' : 0
    }, 2000);
});