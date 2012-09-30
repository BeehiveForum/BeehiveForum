(function () {
    CKEDITOR.dialog.add('youtube',

    function (editor) {
        return {
            title: 'Embed Youtube Video',
            minWidth: CKEDITOR.env.ie && CKEDITOR.env.quirks ? 368 : 350,
            minHeight: 240,
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