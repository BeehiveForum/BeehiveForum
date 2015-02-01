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

    var add_process_running = false;

    var toggle_add_buttons = function () {
        $('button.add_question, button.add_option').toggleClass('disabled', !($('div.poll_options_list ol li').length < 20));
    };

    var toggle_delete_buttons = function () {
        var $poll_questions = $('fieldset.poll_question');

        $poll_questions.each(function () {

            var $delete_buttons = $(this).find('button.delete_option');
            $delete_buttons.toggleClass('disabled', $delete_buttons.length == 2);
        });

        var $delete_buttons = $poll_questions.find('button.delete_question');
        $delete_buttons.toggleClass('disabled', $delete_buttons.length == 1);
    };

    var hide_delete_buttons = function () {
        $(this).find('button.delete_question, button.delete_option').hide();
    };

    var option_html = function (question_id, option_id) {
        //noinspection JSUnresolvedVariable
        return $.vsprintf(
            '<li><input type="text" dir="ltr" maxlength="255" size="45" value="" class="bhinputtext" name="poll_questions[%(0)d][options][%(1)d]">&nbsp;\
               <button title="%(2)s" class="button_image delete_option disabled" name="delete_option[%(0)d][%(1)d]" type="submit">\
                 <span class="image delete"></span>\
               </button>\
             </li>', [
                [
                    question_id,
                    option_id,
                    top.window.beehive.lang.deleteoption
                ]
            ]);
    };

    var question_html = function (question_id) {
        //noinspection JSUnresolvedVariable
        return $.vsprintf(
            '<fieldset class="poll_question">\
               <div>\
                 <h2>%(1)s</h2>\
                 <div class="poll_question_input">\
                   <input type="text" dir="ltr" maxlength="255" size="40" value="" class="bhinputtext" name="poll_questions[%(0)d][question]">&nbsp;\
                   <button title="%(2)s" class="button_image delete_question disabled" name="delete_question[%(0)d]" type="submit">\
                     <span class="image delete"></span>\
                   </button>\
                 </div>\
                 <div class="poll_question_checkbox">\
                   <span class="bhinputcheckbox">\
                     <input type="checkbox" value="Y" id="poll_questions>%(3)sallow_multi" name="poll_questions[%(0)d][allow_multi]">\
                     <label for="poll_questions>%(3)sallow_multi">%(3)s</label>\
                   </span>\
                 </div>\
                 <div class="poll_options_list">\
                   <ol>%(4)s%(5)s</ol>\
                 </div>\
               </div>\
               <button class="button_image add_option" name="add_option[%(0)d]" type="submit"><span class="image add"></span>&nbsp;%(6)s</button>\
             </fieldset>', [
                [
                    question_id,
                    top.window.beehive.lang.pollquestion,
                    top.window.beehive.lang.deletequestion,
                    top.window.beehive.lang.allowmultipleoptions,
                    option_html(question_id, 1),
                    option_html(question_id, 2),
                    top.window.beehive.lang.addnewoption
                ]
            ]);
    };

    var $body = $('body');

    hide_delete_buttons.call($body);

    toggle_delete_buttons();

    $body.on('mouseenter', 'div.poll_question_input',function () {

        $(this).find('button.delete_question').show();

    }).on('mouseleave', 'div.poll_question_input', function () {

        $(this).find('button.delete_question').hide();
    });

    $body.on('mouseenter', 'div.poll_options_list ol li',function () {

        $(this).find('button.delete_option').show();

    }).on('mouseleave', 'div.poll_options_list ol li', function () {

        $(this).find('button.delete_option').hide();
    });

    $body.on('click', 'button.delete_question', function () {

        if ($(this).hasClass('disabled')) {
            return false;
        }

        if (!window.confirm('Are you sure you want to delete this question?')) {
            return false;
        }

        $(this).closest('fieldset').hide(300, function () {

            $(this).remove();

            toggle_add_buttons();

            toggle_delete_buttons();
        });

        return false;
    });

    $body.on('click', 'button.delete_option', function () {

        if ($(this).hasClass('disabled')) {
            return false;
        }

        if (!window.confirm('Are you sure you want to delete this option?')) {
            return false;
        }

        $(this).closest('li').hide(300, function () {

            $(this).remove();

            toggle_add_buttons();

            toggle_delete_buttons();
        });

        return false;
    });

    $body.on('click', 'button.add_option', function () {

        if ($(this).hasClass('disabled')) {
            return false;
        }

        if (add_process_running) {
            return false;
        }

        var $poll_question_fieldset = $(this).closest('fieldset.poll_question');

        var $poll_options_list = $poll_question_fieldset.find('div.poll_options_list ol');

        var question_id = $('fieldset.poll_question').index($poll_question_fieldset) + 1;

        var option_id = $poll_question_fieldset.find('li').length + 1;

        add_process_running = true;

        var $html = $(option_html(question_id, option_id));

        hide_delete_buttons.call($html);

        $html.hide().appendTo($poll_options_list).show(200, function () {

            $(this).css('display', 'list-item');

            toggle_add_buttons();

            toggle_delete_buttons();

            add_process_running = false;
        });

        return false;
    });

    $('button#add_question').bind('click', function () {

        if ($(this).hasClass('disabled')) {
            return false;
        }

        if (add_process_running) {
            return false;
        }

        var $poll_questions_container = $('.poll_questions_container');

        var question_id = $poll_questions_container.find('fieldset.poll_question').length + 1;

        add_process_running = true;

        var $html = $(question_html(question_id));

        hide_delete_buttons.call($html);

        $html.hide().appendTo($poll_questions_container).show(200, function () {

            toggle_add_buttons();

            toggle_delete_buttons();

            add_process_running = false;
        });

        return false;
    });

    $('.poll_bar_vertical .poll_bar_inner').animate({
        bottom: 0
    }, 2000);

    $('.poll_bar_horizontal .poll_bar_inner').animate({
        left: 0
    }, 2000);
});