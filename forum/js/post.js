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

function closeAttachWin ()
{
        if (typeof attachwin == 'object' && !attachwin.closed) {
                attachwin.close();
        }
}

function launchAttachWin (aid, webtag)
{
        attachwin = window.open('attachments.php?webtag=' + webtag + '&aid='+ aid, 'attachments', 'width=660, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
        return false;
}

function checkToRadio(num)
{
        document.f_post.to_radio[num].checked=true;
}

function openLogonSearch(webtag, obj_name)
{
    var form_obj = document.getElementsByName(obj_name)[0];
    search_logon = window.open('search_popup.php?webtag=' + webtag + '&type=1&search_query=' + form_obj.value + '&obj_id=' + form_obj.id, 'search_logon', 'width=500, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');
    return false;
}

function returnSearchResult(obj_id, content)
{
    var form_obj = getFormObj(obj_id);
    form_obj.value = content;

    var to_radio_obj = document.getElementsByName('to_radio');
    to_radio_obj[to_radio_obj.length - 1].checked = true;
}
