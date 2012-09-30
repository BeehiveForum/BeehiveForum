(function () {

    CKEDITOR.plugins.add('youtube', {

        requires: ['dialog'],

        init: function (editor) {

            var commandName = 'youtube',
                iconPath = this.path + 'images/icon.png';

            editor.addCommand(commandName, new CKEDITOR.dialogCommand(commandName));

            editor.ui.addButton('Youtube', {
                label: 'Embed Youtube Video',
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