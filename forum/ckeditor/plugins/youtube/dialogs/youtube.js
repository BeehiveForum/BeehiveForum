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
    CKEDITOR.dialog.add('youtube',
    function (editor) {
        return {
            title: 'Embed Youtube Video',
            minHeight: 150,
            minWidth: 500,
            onShow: function () {

                var self = this,
                    selectedElement = this.getSelectedElement(),
                    originalElement;

                if (selectedElement && selectedElement.data('cke-real-element-type') && selectedElement.data('cke-real-element-type') == 'youtube') {

                    self.fakeImage = selectedElement;

                    originalElement = editor.restoreRealElement(selectedElement);

                    this.getContentElement('general', 'contents')
                        .getInputElement()
                        .setValue(originalElement.getOuterHtml());
                }
            },
            onOk: function () {

                var self = this,
                    embedCode = this.getContentElement('general', 'contents')
                        .getInputElement()
                        .getValue(),
                    realElement = CKEDITOR.dom.element.createFromHtml(embedCode, editor.document),
                    fakeElement = editor.createFakeElement(realElement, 'cke_youtube', 'youtube', true);

                if (self.fakeImage) {

                    fakeElement.replace(self.fakeImage);
                    editor.getSelection()
                        .selectElement(fakeElement);

                } else {

                    editor.insertElement(fakeElement);
                }
            },
            contents: [{
                label: editor.lang.common.generalTab,
                id: 'general',
                elements: [{
                    type: 'textarea',
                    id: 'contents',
                    label: 'Youtube Embed Code',
                    validate: CKEDITOR.dialog.validate.notEmpty('The Displayed Text field cannot be empty.'),
                    required: true
                }]
            }]
        };
    });
})();