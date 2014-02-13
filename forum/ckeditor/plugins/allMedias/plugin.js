/**
 * @license Copyright (c) 2003-2013, webmote - codeex.cn. All rights reserved.
 * For licensing, see http://codeex.cn/
 * 2013-2-18 v1.0
 */

(function () {

    function isallMediasEmbed(element) {
        var attributes = element.attributes;
        return ( attributes.mtype == 'allMedias');
    }

    function createFakeElement(editor, realElement) {
        return editor.createFakeParserElement(realElement, 'cke_allMedias', 'allMedias', true);
    }

    CKEDITOR.plugins.add('allMedias', {

        requires: ['dialog', 'fakeobjects'],

        lang: ['en', 'zh-cn', 'zh'],

        icons: 'allMedias',

        onLoad: function () {

            CKEDITOR.addCss('img.cke_allMedias' +
                '{' +
                'background-image: url(' + CKEDITOR.getUrl(this.path + 'images/placeholder.png') + ');' +
                'background-position: center center;' +
                'background-repeat: no-repeat;' +
                'border: 1px solid #a9a9a9;' +
                'width: 80px;' +
                'height: 80px;' +
                '}'
            );
        },
        init: function (editor) {

            //noinspection JSPotentiallyInvalidConstructorUsage
            editor.addCommand('allMedias', new CKEDITOR.dialogCommand('allMedias'));

            editor.ui.addButton && editor.ui.addButton('allMedias', {
                label: editor.lang.allMedias.allMedias,
                command: 'allMedias',
                toolbar: 'insert,20'
            });

            CKEDITOR.dialog.add('allMedias', this.path + 'dialogs/allMedias.js');

            if (editor.addMenuItems) {

                editor.addMenuGroup('mediagroup');

                editor.addMenuItems({
                    mediamenu: {
                        label: editor.lang.allMedias.properties,
                        command: 'allMedias',
                        group: 'mediagroup',
                        icons: this.icons
                    }
                });
            }

            editor.on('doubleclick', function (evt) {

                var element = evt.data.element;

                if (element.is('img') && element.data('cke-real-element-type') == 'allMedias') {
                    evt.data.dialog = 'allMedias';
                }
            });

            if (editor.contextMenu) {

                editor.contextMenu.addListener(function (element) {

                    if (element && element.is('img') && !element.isReadOnly() && element.data('cke-real-element-type') == 'allMedias') {
                        return { mediamenu: CKEDITOR.TRISTATE_OFF };
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
                        'cke:object': function (element) {

                            if (!isallMediasEmbed(element)) {

                                for (var i = 0; i < element.children.length; i++) {

                                    if (element.children[ i ].name == 'cke:embed') {

                                        if (!isallMediasEmbed(element.children[ i ])) {
                                            return null;
                                        }

                                        return createFakeElement(editor, element);
                                    }
                                }

                                return null;
                            }
                            else {

                                return createFakeElement(editor, element);
                            }
                        },
                        'cke:embed': function (element) {

                            if (!isallMediasEmbed(element)) {
                                return null;
                            }

                            return createFakeElement(editor, element);
                        }
                    }

                }, 1);
            }
        }
    });
})();