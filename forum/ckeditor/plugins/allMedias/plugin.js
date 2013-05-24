/**
 * @license Copyright (c) 2003-2013, webmote - codeex.cn. All rights reserved.
 * For licensing, see http://codeex.cn/
 * 2013-2-18 v1.0
 */

(function() {

	function isallMediasEmbed(element)
    {
		var attributes = element.attributes;
		return (attributes.mtype == 'allMedias');
	}

    function createFakeElement(editor, realElement) {

        console.log(realElement);
        return editor.createFakeParserElement(realElement, 'cke_allMedias', 'allMedias', true);
    }

	CKEDITOR.plugins.add('allMedias', {
		requires: ['dialog'],
		lang: ['en', 'zh-cn', 'zh'],
		icons: 'allMedias', // %REMOVE_LINE_CORE%
		init: function(editor) {

            editor.addCommand('allMedias', new CKEDITOR.dialogCommand('allMedias'));

            editor.ui.addButton('allMedias', {
				label: editor.lang.allMedias.allMedias,
				command: 'allMedias',
				icon: this.path + 'icons/allMedias.png'
			});

            CKEDITOR.dialog.add('allMedias', this.path + 'dialogs/allMedias.js');

			if (editor.addMenuItems) {

            	editor.addMenuGroup('mediagroup');

            	editor.addMenuItems('allMedias', {
					label: editor.lang.allMedias.properties,
                    icon:  this.path + 'icons/allMedias.png',
					command: 'allMedias',
					group: 'allMedias'
				});
			}

			editor.on('doubleclick', function(evt) {

            	var element = evt.data.element;

				if (element.is('img') && element.data('cke-real-element-type') == 'allMedias') {
					evt.data.dialog = 'allMedias';
                }
			});

			if (editor.contextMenu) {

				editor.contextMenu.addListener(function(element, selection) {

                    if (element && element.is('img') && !element.isReadOnly() && element.data('cke-real-element-type') == 'allMedias') {
						return { mediamenu: CKEDITOR.TRISTATE_OFF };
                    }
				});
			}
		},

		afterInit: function(editor) {

			var dataProcessor = editor.dataProcessor,
				dataFilter = dataProcessor && dataProcessor.dataFilter;
				htmlFilter = dataProcessor && dataProcessor.htmlFilter;

			if (dataFilter) {

                dataFilter.addRules({
					elements: {
						'cke:object': function(element) {

							var attributes = element.attributes;

							if (!isallMediasEmbed(element)) {

								for (var i = 0; i < element.children.length; i++) {

									if (element.children[i].name == 'cke:embed') {

										if (!isallMediasEmbed(element.children[i])) {
											return null;
                                        }

										return createFakeElement(editor, element);
									}
								}

								return null;

                            } else {

								return createFakeElement(editor, element);
							}
						},

						'cke:embed': function(element) {

                            if (!isallMediasEmbed(element)) {
								return null;
                            }

							return createFakeElement(editor, element);
						}
					}
				},
                1);
			}
		}
	});
})();