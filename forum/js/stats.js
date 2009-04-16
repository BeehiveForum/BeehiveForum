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

/* $Id: stats.js,v 1.9 2009-04-16 18:35:34 decoyduck Exp $ */

var stats_timeout;

var stats_data = new xml_http_request();

function stats_display_initialise()
{
    var forum_stats_obj = getObjById('forum_stats');

    if (typeof(forum_stats_obj) == 'object' || typeof(forum_stats_obj) == 'function') {

        stats_timeout = setTimeout('stats_display_get_data()', 0);
        return true;
    }
}

function stats_display_get_data()
{
    clearTimeout(stats_timeout);
    
    var date = new Date();
    var timestamp = date.getTime();    

    stats_data.set_handler(stats_display_handler);
    stats_data.get_url('user_stats.php?webtag=' + webtag + '&get_stats=true&timestamp=' + timestamp);
}

function stats_display_abort()
{
    stats_data.abort();
    stats_data.close();
    delete stats_data;
}

function stats_display_handler()
{
    var response_html = stats_data.get_response_text();
    
    var forum_stats_obj = getObjById('forum_stats');

    if (typeof(forum_stats_obj) == 'object' || typeof(forum_stats_obj) == 'function') {
        forum_stats_obj.innerHTML = response_html;
    }
    
    return true;
}