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

            var checkEmbedCode = function (code, returnElement) {

                var element, src, embedCode;

                try {

                    element = CKEDITOR.dom.element.createFromHtml(code, editor.document);

                    if (!element || !element.type) {
                        return false;
                    }

                    if (element.type == 1 && element.getName() == 'iframe' && element.getAttribute('src')) {

                        src = element.getAttribute('src');

                        if (!src || !src.match(/^http(s)?:\/\/www\.youtube\.com\/embed\//)) {
                            return false;
                        }

                    } else if (element.type == 3) {

                        src = element.getText();

                        embedCode = src.match(/^http(s)?:\/\/(www\.)?(youtube\.com\/watch\/?.*(\?|&)v=([^&]+)|youtu.be\/(.+))/);

                        if (!embedCode) {
                            return false;
                        }

                        element = CKEDITOR.dom.element.createFromHtml('<iframe>', editor.document);

                        if (embedCode[6]) {
                            element.setAttribute('src', 'https://www.youtube.com/embed/' + embedCode[6]);
                        } else if (embedCode[5]) {
                            element.setAttribute('src', 'https://www.youtube.com/embed/' + embedCode[5]);
                        }
                    }

                } catch (e) {

                }

                element.setStyle('display', 'block');
                element.setStyle('height', '360px');
                element.setStyle('margin', '0 auto');
                element.setStyle('width', '480px');

                element.removeAttribute('allowfullscreen');

                return returnElement ? element : true;
            };

            return {
                title: 'Embed Youtube Video',
                minHeight: 480,
                minWidth: 485,
                onShow: function () {

                    var inputElement = this.getContentElement('general', 'contents').getInputElement(),
                        selectedElement = this.getSelectedElement(),
                        originalElement;

                    if (selectedElement && selectedElement.data('cke-real-element-type') && selectedElement.data('cke-real-element-type') == 'youtube') {

                        this.fakeImage = selectedElement;
                        originalElement = editor.restoreRealElement(selectedElement);
                        inputElement.setValue(originalElement.getOuterHtml());
                        this.showPreview(inputElement.getValue());
                    }
                },
                onOk: function () {

                    var self = this,
                        embedCode = this.getContentElement('general', 'contents').getInputElement().getValue(),
                        realElement = checkEmbedCode(embedCode, true),
                        fakeElement = editor.createFakeElement(realElement, 'cke_youtube', 'youtube', false),
                        videoCode = realElement.getAttribute('src').match(/^http(s)?:\/\/www\.youtube\.com\/embed\/(.+)/);

                    fakeElement.setAttribute('src', 'http://img.youtube.com/vi/' + videoCode[2] + '/0.jpg');
                    fakeElement.setAttribute('height', realElement.getAttribute('height') || 360);
                    fakeElement.setAttribute('width', realElement.getAttribute('width') || 480);
                    fakeElement.setAttribute('title', 'Youtube Video');

                    if (self.fakeImage) {

                        fakeElement.replace(self.fakeImage);
                        editor.getSelection().selectElement(fakeElement);

                    } else {

                        editor.insertElement(fakeElement);
                    }
                },
                contents: [{
                    label: editor.lang.common.generalTab,
                    id: 'general',
                    elements: [{
                        type: 'hbox',
                        padding: 0,
                        children: [{
                            id: 'contents',
                            type: 'textarea',
                            label: editor.lang.youtube.youTubeEmbedCodeOrURL,
                            cols: 15,
                            rows: 3,
                            onLoad: function () {

                                var dialog = this.getDialog();

                                dialog.showPreview = function (code) {

                                    try {

                                        var element = checkEmbedCode(code, true),
                                            previewContainer = this.getContentElement('general', 'preview').getElement().getChild(2);

                                        if (element) {

                                            element.setStyle('display', 'block');
                                            element.setStyle('height', '360px');
                                            element.setStyle('margin', '0 auto');
                                            element.setStyle('width', '480px');

                                            element.removeAttribute('allowfullscreen');

                                            previewContainer.setHtml(element.getOuterHtml());

                                        } else {

                                            previewContainer.setHtml('');
                                        }

                                    } catch (e) {
                                    }
                                };

                                this.getInputElement().on('keyup', function () {
                                    dialog.showPreview(this.getValue());
                                }, this);
                            },
                            validate: function () {
                                return checkEmbedCode(this.getValue(), false);
                            },
                            required: true
                        }]
                    }, {
                        type: 'hbox',
                        children: [{
                            type: 'html',
                            id: 'preview',
                            style: 'width:100%;',
                            html: '<div>Preview:<br /><div id="cke_YoutubePreviewBox' + CKEDITOR.tools.getNextNumber() + '" style="width: 100%; height: 360px; background-color: #000000"></div></div>'
                        }]
                    }]
                }]
            };
        });
})();