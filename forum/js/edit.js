/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

function closeAttachWin () {
    if (typeof attachwin == 'object' && !attachwin.closed) {
        attachwin.close();
    }
}

function launchAttachEditWin (aid, webtag) {
    attachwin = window.open('edit_attachments.php?aid=' + aid + '&webtag=' + webtag + '&popup=1', 'edit_attachments', 'width=660, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
}

function clearFocus() {
    if (document.f_edit) {
        if (document.f_edit.t_content) {
            document.f_edit.t_content.caretPos = "";
        }
        if (document.f_edit.t_sig) {
            document.f_edit.t_sig.caretPos = "";
        }
    }
}

function checkToRadio(num) {
    document.f_edit.to_radio[num].checked=true;
}

function tools_feedback () {
    if (document.f_edit.t_post_html[0].checked == true) {
        document.f_edit.t_post_html[1].checked = true;
    }
}

function activate_tools () {
    show_hide('toolbar', 'block');
    document.f_edit.t_content.focus();
    active_text(document.f_edit.t_content);
}

function showContent (type) {
    if (type == "correct" && document.f_edit.current_t_content.value != "correct") {
        var temp = document.f_edit.t_content.value;
        document.f_edit.t_content.value = document.f_edit.old_t_content.value;
        document.f_edit.old_t_content.value = temp;
        document.f_edit.current_t_content.value = "correct";
    } else if (type == "submit" && document.f_edit.current_t_content.value != "submit") {
        var temp = document.f_edit.t_content.value;
        document.f_edit.t_content.value = document.f_edit.old_t_content.value;
        document.f_edit.old_t_content.value = temp;
        document.f_edit.current_t_content.value = "submit";
    }
}

function showSig (type) {
    if (type == "correct" && document.f_edit.current_t_sig.value != "correct") {
        var temp = document.f_edit.t_sig.value;
        document.f_edit.t_sig.value = document.f_edit.old_t_sig.value;
        document.f_edit.old_t_sig.value = temp;
        document.f_edit.current_t_sig.value = "correct";
    } else if (type == "submit" && document.f_edit.current_t_sig.value != "submit") {
        var temp = document.f_edit.t_sig.value;
        document.f_edit.t_sig.value = document.f_edit.old_t_sig.value;
        document.f_edit.old_t_sig.value = temp;
        document.f_edit.current_t_sig.value = "submit";
    }
}