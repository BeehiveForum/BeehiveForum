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
(function () {

    'use strict';

    CKEDITOR.plugins.add('youtube', {

        requires: ['dialog', 'fakeobjects'],

        lang: ['en'],

        init: function (editor) {

            //noinspection JSPotentiallyInvalidConstructorUsage
            var commandName = 'youtube',
                iconPath = this.path + 'images/icon.png',
                youtubeTag = new CKEDITOR.style({
                    element: 'img',
                    attributes: {
                        'class': 'cke_youtube'
                    }
                });

            editor.attachStyleStateChange(youtubeTag, function (state) {

                if (!editor.readOnly) {
                    editor.getCommand(commandName).setState(state);
                }
            });

            //noinspection JSPotentiallyInvalidConstructorUsage
            editor.addCommand(commandName, new CKEDITOR.dialogCommand(commandName));

            editor.ui.addButton('Youtube', {
                label: editor.lang.youtube.embedYouTubeVideo,
                command: commandName,
                icon: iconPath
            });

            CKEDITOR.dialog.add(commandName, CKEDITOR.getUrl(this.path + 'dialogs/youtube.js'));

            if (editor.contextMenu) {

                editor.addMenuGroup('youtube');

                editor.addMenuItem('youtube', {
                    label: 'Edit Youtube Video',
                    icon: iconPath,
                    command: commandName,
                    group: 'youtube'
                });

                editor.contextMenu.addListener(function (selectedElement) {
                    if (selectedElement && selectedElement.data('cke-real-element-type') && selectedElement.data('cke-real-element-type') === 'youtube') {

                        return {
                            'youtube': CKEDITOR.TRISTATE_OFF
                        };
                    }

                    return null;
                });
            }
        },

        afterInit: function (editor) {

            var dataProcessor = editor.dataProcessor,
                dataFilter = dataProcessor && dataProcessor.dataFilter;

            if (dataFilter) {

                dataFilter.addRules({
                    elements: {

                        iframe: function (element) {

                            var fakeElement,
                                videoCode;

                            if (element && element.attributes && element.attributes.src) {

                                videoCode = element.attributes.src.match(/^http(s)?:\/\/www\.youtube\.com\/embed\/(.+)/);

                                if (videoCode && videoCode[2]) {

                                    fakeElement = editor.createFakeParserElement(element, 'cke_youtube', 'youtube', false);

                                    fakeElement.attributes.src = 'http://img.youtube.com/vi/' + videoCode[2] + '/0.jpg';
                                    fakeElement.attributes.height = element.attributes.height || 360;
                                    fakeElement.attributes.width = element.attributes.width || 480;
                                    fakeElement.attributes.title = editor.lang.youtube.youTubeVideo;

                                    return fakeElement;
                                }
                            }

                            return null;
                        }
                    }
                }, 9);
            }
        }
    });
})();