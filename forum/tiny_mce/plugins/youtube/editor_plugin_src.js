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

/**
* This plugin is based heavilly on code found on:
*
* http://www.travelogie.com/blog/post/2011/04/06/Youtube-plugin-for-TinyMCE.aspx
*
* It has been modified to support Beehive Forum's HTML parsing,
* so the user can switch mid-post from using TinyMCE to the built-in
* HTML toolbar editor.
*/
(function () {

    tinymce.PluginManager.requireLangPack('youtube');

    tinymce.create('tinymce.plugins.YoutubePlugin', {

        init: function (ed, url) {

            ed.addCommand('mceYoutube', function () {

                ed.windowManager.open({

                    file: url + '/youtube.htm',
                    width: 320 + parseInt(ed.getLang('example.delta_width', 0)),
                    height: 120 + parseInt(ed.getLang('example.delta_height', 0)),
                    inline: 1

                }, {

                    plugin_url: url,
                    some_custom_arg: 'custom arg'
                });
            });

            ed.addButton('youtube', {

                title: 'youtube.desc',
                cmd: 'mceYoutube',
                image: url + '/img/youtube.gif'
            });

            ed.onNodeChange.add(function (ed, cm, n) {

                var active = false;

                if (n.nodeName == 'IMG') {

                    try {

                        var title = n.attributes['title'].value;

                        var alt = n.attributes['alt'].value;

                        var matches = title.match(/(((http|https):\/\/)?(www\.)?(youtube\.com\/watch\?v=([^&|"]+)|youtu\.be\/([^"]+)))/);
                        
                        console.log(matches);

                        if (matches[4] !== undefined) {

                            active = matches[4] === alt;

                        } else if (matches[5] !== undefined) {

                            active = matches[5] === alt;

                        } else {

                            active = false;
                        }

                    } catch (err) {

                    }
                }

                cm.setActive('youtube', active);
            });
        },

        createControl: function (n, cm) {
            return null;
        },

        getInfo: function () {

            return {

                longname: 'Youtube TinyMCE plugin',
                author: 'Beehive Forum',
                authorurl: 'http://beehiveforum.co.uk',
                infourl: 'http://beehiveforum.co.uk',
                version: "2.0"
            };
        }
    });

    tinymce.PluginManager.add('youtube', tinymce.plugins.YoutubePlugin);
})();