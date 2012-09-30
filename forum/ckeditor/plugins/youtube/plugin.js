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

    CKEDITOR.plugins.add('youtube', {

        requires: ['dialog'],

        init: function (editor) {

            var commandName = 'youtube',
                iconPath = this.path + 'images/icon.png',
                dialog;

            editor.addCommand(commandName, new CKEDITOR.dialogCommand(commandName));

            editor.ui.addButton('Youtube', {
                label: 'Embed Youtube Video',
                command: commandName,
                icon: iconPath
            });

            CKEDITOR.dialog.add(commandName, CKEDITOR.getUrl(this.path + 'dialogs/youtube.js'));

            CKEDITOR.dialog.on('resize', function(event) {

                var data = event.data,
                    dialog = data.dialog,
                    element = dialog.getContentElement('general', 'contents')
                        .getInputElement();

                if (dialog.getName() != 'youtube') {
                    return;
                }

                element.setSize('height', dialog.getSize().height - 150, true);
            });

            if (editor.contextMenu) {

                editor.addMenuGroup('youtube');

                editor.addMenuItem('youtube', {
                    label: 'Edit Youtube Video',
                    icon: iconPath,
                    command: commandName,
                    group: 'youtube'
                });

                editor.contextMenu.addListener(function (selectedElement) {
                    if (selectedElement && selectedElement.data('cke-real-element-type') && selectedElement.data('cke-real-element-type') == 'youtube') {

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

                        'iframe': function (element) {

                            var attributes = element.attributes,
                                fakeElement = editor.createFakeParserElement(element, 'cke_youtube', 'youtube', false);

                            fakeElement.attributes.height = attributes.height || 315;
                            fakeElement.attributes.width = attributes.width || 560;

                            return fakeElement;
                        }
                    }
                },
                9);
            }
        }
    });
})();