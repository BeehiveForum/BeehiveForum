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

/* $Id: stats.js,v 1.2 2008-03-22 16:01:13 decoyduck Exp $ */

var stats_timeout;

var stats_data = new xml_http_request();

function stats_display_initialise()
{
    var forum_stats_obj = getObjById('forum_stats');

    if (typeof(forum_stats_obj) == 'object') {

        stats_timeout = setTimeout('stats_display_get_data()', 1000);
        return true;
    }
}

function stats_display_get_data()
{
    clearTimeout(stats_timeout);

    stats_data.set_handler(stats_display_handler);
    stats_data.get_url('user_stats.php?webtag=' + webtag + '&get_stats=true');
}

function stats_display_abort()
{
    stats_data.abort();
    stats_data.close();
    delete stats_data;
}

function stats_display_handler()
{
    var response_xml = stats_data.get_response_xml();

    if (typeof(response_xml) == 'object') {

        var user_stats_xml = response_xml.getElementsByTagName('users')[0];

        var thread_stats_xml = response_xml.getElementsByTagName('threads')[0];

        var post_stats_xml = response_xml.getElementsByTagName('posts')[0];

        active_user_counts_obj = document.getElementById('active_user_counts');

        if (typeof(active_user_counts_obj) == 'object') {

            if (typeof(user_stats_xml) == 'object') {

                var active_users_xml = user_stats_xml.getElementsByTagName('active')[0];

                var active_guest_count = active_users_xml.getElementsByTagName('guests')[0].childNodes[0].nodeValue;
                var active_nuser_count = active_users_xml.getElementsByTagName('visible')[0].childNodes[0].nodeValue;
                var active_auser_count = active_users_xml.getElementsByTagName('anonymous')[0].childNodes[0].nodeValue;

                var visitor_log_link = sprintf('[ <a href="start.php?webtag=' + webtag + '&amp;show=visitors" target="%s">%s<\/a> ]', '", bh_frame_main, "', lang['viewcompletelist']);

                var active_users_array = new Array();

                active_users_array[0] = (active_guest_count != 1) ? sprintf(lang['numactiveguests'], active_guest_count) : lang['oneactiveguest'];
                active_users_array[1] = (active_nuser_count != 1) ? sprintf(lang['numactivemembers'], active_nuser_count) : lang['oneactivemember'];
                active_users_array[2] = (active_auser_count != 1) ? sprintf(lang['numactiveanonymousmembers'], active_auser_count) : lang['oneactiveanonymousmember'];

                var active_user_text = sprintf(lang['usersactiveinthepasttimeperiod'], active_users_array.join(', '), active_sess_cutoff, visitor_log_link);

                active_user_counts_obj.innerHTML = active_user_text;
            }

        }

        active_user_list_obj = document.getElementById('active_user_list');

        if (typeof(active_user_list_obj) == 'object') {

            if (typeof(user_stats_xml) == 'object') {

                active_users_xml = user_stats_xml.getElementsByTagName('active')[0];

                active_user_list_xml = active_users_xml.getElementsByTagName('list')[0];

                if (typeof(active_user_list_xml) == 'object') {

                    var active_user_list_array = new Array(); var count = 0;

                    active_user_array_xml = active_user_list_xml.getElementsByTagName('user');

                    if (typeof(active_user_array_xml) == 'object') {

                        for (var i = 0; i < active_user_array_xml.length; i++) {

                            active_user_uid  = active_user_array_xml[i].getElementsByTagName('uid')[0].childNodes[0].nodeValue;
                            active_user_display = active_user_array_xml[i].getElementsByTagName('display')[0].childNodes[0].nodeValue;
                            active_user_relationship = active_user_array_xml[i].getElementsByTagName('relationship')[0].childNodes[0].nodeValue;
                            active_user_anonymous = active_user_array_xml[i].getElementsByTagName('anonymous')[0].childNodes[0].nodeValue;

                            if (active_user_uid == user_uid) {

                                if (active_user_anonymous > user_anon_disabled) {

                                    active_user_text = sprintf('<span class="user_stats_curuser" title="%s">%s<\/span>', lang['youinvisible'], active_user_display);

                                }else {

                                    active_user_text = sprintf('<span class="user_stats_curuser" title="%s">%s<\/span>', lang['younormal'], active_user_display);
                                }

                            }else if (active_user_relationship & user_friend) {

                                active_user_text = sprintf('<span class="user_stats_friend" title="%s">%s<\/span>', lang['friend'], active_user_display);

                            }else {

                                active_user_text = sprintf('<span class="user_stats_normal">%s<\/span>', active_user_display);
                            }

                            active_user_link = sprintf('<a href="user_profile.php?webtag=' + webtag + '&uid=%s" onclick="return openProfile(%s, \'' + webtag + '\')">%s<\/a>', active_user_uid, active_user_uid, active_user_text);
                            active_user_list_array[count] = active_user_link; count++
                        }
                        active_user_list_obj.innerHTML = active_user_list_array.join(', ');
                    }
                }
            }
        }

        thread_stats_obj = document.getElementById('thread_stats');

        if (typeof(thread_stats_obj) == 'object') {

            if (typeof(thread_stats_xml) == 'object') {

                num_threads = thread_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;
                num_posts = post_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;

                num_threads_display = (num_threads != 1) ? sprintf(lang['numthreadscreated'], num_threads) : lang['onethreadcreated'];
                num_posts_display = (num_posts != 1) ? sprintf(lang['numpostscreated'], num_posts) : lang['onepostcreated'];

                thread_post_stats_text = sprintf(lang['ourmembershavemadeatotalofnumthreadsandnumposts'] + '<br />', num_threads_display, num_posts_display);

                thread_stats_obj.innerHTML = thread_post_stats_text;

                longest_thread_xml = thread_stats_xml.getElementsByTagName('longest')[0];

                longest_thread_tid = longest_thread_xml.getElementsByTagName('tid')[0].childNodes[0].nodeValue;
                longest_thread_title = longest_thread_xml.getElementsByTagName('title')[0].childNodes[0].nodeValue;
                longest_thread_length = longest_thread_xml.getElementsByTagName('length')[0].childNodes[0].nodeValue;

                longest_thread_link = sprintf('<a href="index.php?webtag=' + webtag + '&amp;msg=%s.1">%s<\/a>', longest_thread_tid, longest_thread_title);
                longest_thread_post_count = (longest_thread_length != 1) ? sprintf(lang['numpostscreated'], longest_thread_length) : lang['onepostcreated'];

                longest_thread_text = sprintf(lang['longestthreadisthreadnamewithnumposts'], longest_thread_link, longest_thread_post_count);

                thread_stats_obj.innerHTML+= longest_thread_text;
            }
        }

        post_stats_obj = document.getElementById('post_stats');

        if (typeof(post_stats_obj) == 'object') {

            if (typeof(post_stats_xml) == 'object') {

                num_posts = post_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;

                post_stats_recent = post_stats_xml.getElementsByTagName('recent')[0];
                post_stats_record = post_stats_recent.getElementsByTagName('record')[0];

                if (typeof(post_stats_recent) == 'object') {

                    post_stats_recent_count = post_stats_recent.getElementsByTagName('count')[0].childNodes[0].nodeValue;
                    post_stats_recent_text = (post_stats_recent_count != 1) ? sprintf(lang['therehavebeenxpostsmadeinthelastsixtyminutes'] + '<br />', post_stats_recent_count) : lang['therehasbeenonepostmadeinthelastsxityminutes'];

                    post_stats_obj.innerHTML = post_stats_recent_text;

                    if (typeof(post_stats_record) == 'object') {

                        post_stats_record_count = post_stats_record.getElementsByTagName('count')[0].childNodes[0].nodeValue;
                        post_stats_record_date = post_stats_record.getElementsByTagName('date')[0].childNodes[0].nodeValue;

                        post_stats_record_text = sprintf(lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'], post_stats_record_count, post_stats_record_date);

                        post_stats_obj.innerHTML+= post_stats_record_text;
                    }

                }
            }
        }

        user_stats_obj = document.getElementById('user_stats');

        if (typeof(user_stats_obj) == 'object') {

            if (typeof(user_stats_xml) == 'object') {

                user_count = user_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;

                if (user_count != 1) {

                    user_newest_xml = user_stats_xml.getElementsByTagName('newest')[0];

                    if (typeof(user_newest_xml) == 'object') {

                        user_newest_uid = user_newest_xml.getElementsByTagName('uid')[0].childNodes[0].nodeValue;
                        user_newest_display = user_newest_xml.getElementsByTagName('display')[0].childNodes[0].nodeValue;

                        user_newest_profile_link = sprintf('<a href="user_profile.php?webtag=' + webtag + '&amp;uid=%s" target="_blank" onclick="return openProfile(%s, \'' + webtag + '\')">%s<\/a>', user_newest_uid, user_newest_uid, user_newest_display);

                        user_stats_text = sprintf(lang['wehavenumregisteredmembersandthenewestmemberismembername'] + '<br />', user_count, user_newest_profile_link);

                    }else {

                        user_stats_text = sprintf(lang['wehavenumregisteredmember'] + '<br />', user_count);
                    }

                }else {

                    user_stats_text = lang['wehaveoneregisteredmember'] + '<br />';
                }

                user_stats_obj.innerHTML = user_stats_text;

                user_stats_record = user_stats_xml.getElementsByTagName('record')[0];
                user_stats_record_count = user_stats_record.getElementsByTagName('count')[0].childNodes[0].nodeValue;
                user_stats_record_date = user_stats_record.getElementsByTagName('date')[0].childNodes[0].nodeValue;

                user_stats_record_text = sprintf(lang['mostuserseveronlinewasnumondate'], user_stats_record_count, user_stats_record_date);

                user_stats_obj.innerHTML+= user_stats_record_text;
            }
        }
    }
}