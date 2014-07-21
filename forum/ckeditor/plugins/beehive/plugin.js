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

    CKEDITOR.plugins.add('beehive', {

        requires: ['dialog'],

        init: function (editor) {

            //noinspection JSPotentiallyInvalidConstructorUsage
            var allStyles = new CKEDITOR.style({
                element: $
            });

            var findAscendant = function (element, reference, className) {

                var ascendant = element.getAscendant(reference);
                return ascendant && ascendant.hasClass(className);
            };

            editor.attachStyleStateChange(allStyles, function () {

                var element = this.getSelection().getStartElement();

                if ((element.getName() == 'div' && element.hasClass('quote')) || findAscendant(element, 'div', 'quote')) {
                    !editor.readOnly && editor.getCommand('quote').setState(CKEDITOR.TRISTATE_ON);
                    return
                }

                if ((element.getName() == 'pre' && element.hasClass('code')) || findAscendant(element, 'pre', 'code')) {
                    !editor.readOnly && editor.getCommand('code').setState(CKEDITOR.TRISTATE_ON);
                    return
                }

                if ((element.getName() == 'span' && element.hasClass('spoiler')) || findAscendant(element, 'span', 'spoiler')) {
                    !editor.readOnly && editor.getCommand('spoiler').setState(CKEDITOR.TRISTATE_ON);
                    return;
                }

                if ((element.getName() == 'img' && element.hasClass('emoticon')) || findAscendant(element, 'img', 'emoticon')) {
                    !editor.readOnly && editor.getCommand('image').setState(CKEDITOR.TRISTATE_DISABLED);
                    return;
                }

                !editor.readOnly && editor.getCommand('quote').setState(CKEDITOR.TRISTATE_OFF);
                !editor.readOnly && editor.getCommand('code').setState(CKEDITOR.TRISTATE_OFF);
                !editor.readOnly && editor.getCommand('spoiler').setState(CKEDITOR.TRISTATE_OFF);
                !editor.readOnly && editor.getCommand('image').setState(CKEDITOR.TRISTATE_OFF);
            });

            editor.addCommand('code', {
                canUndo: false,
                exec: function (editor) {

                    var state = editor.getCommand('code').state,
                        quoteTextElement,
                        codeElement,
                        selection,
                        selectedText,
                        range;

                    if (state == CKEDITOR.TRISTATE_ON) {

                        codeElement = editor.getSelection().getStartElement();

                        quoteTextElement = codeElement.getPrevious(function (element) {
                            return (element && element.getName() == 'div' && element.hasClass('quotetext'));
                        });

                        if (quoteTextElement) {
                            quoteTextElement.remove(false);
                        }

                        codeElement.remove(true);

                    } else {

                        selection = editor.getSelection();

                        if (CKEDITOR.env.ie) {

                            selection.unlock();
                            selectedText = selection.getNative().createRange().text;

                        } else {

                            selectedText = selection.getNative();
                        }

                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><strong>' + beehive.lang.code + ':</strong>&nbsp;</div>');
                        codeElement = CKEDITOR.dom.element.createFromHtml('<pre class="code">' + selectedText + '</pre>');

                        selection.getRanges()[0].deleteContents();

                        //noinspection JSPotentiallyInvalidConstructorUsage
                        range = new CKEDITOR.dom.range(editor.document);

                        editor.insertElement(quoteTextElement);

                        editor.insertElement(codeElement);

                        range.moveToPosition(codeElement, CKEDITOR.POSITION_AFTER_END);

                        var nextElement = codeElement.getNext();

                        if (!nextElement || nextElement.type == CKEDITOR.NODE_ELEMENT && !nextElement.isEditable()) {
                            range.fixBlock(true, editor.config.enterMode == CKEDITOR.ENTER_DIV ? 'div' : 'p');
                        }

                        range.select();
                    }
                }
            });

            editor.addCommand('quote', {
                canUndo: false,
                exec: function (editor) {

                    var state = editor.getCommand('quote').state,
                        quoteTextElement,
                        quoteElement,
                        selection,
                        selectedText,
                        range;

                    if (state == CKEDITOR.TRISTATE_ON) {

                        quoteElement = editor.getSelection().getStartElement();

                        quoteTextElement = quoteElement.getPrevious(function (element) {
                            return (element && element.getName() == 'div' && element.hasClass('quotetext'));
                        });

                        if (quoteTextElement) {
                            quoteTextElement.remove(false);
                        }

                        quoteElement.remove(true);

                    } else {

                        selection = editor.getSelection();

                        if (CKEDITOR.env.ie) {

                            selection.unlock();
                            selectedText = selection.getNative().createRange().text;

                        } else {

                            selectedText = selection.getNative();
                        }

                        //noinspection JSUnresolvedVariable
                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><strong>' + beehive.lang.quote + ':</strong>&nbsp;</div>');
                        quoteElement = CKEDITOR.dom.element.createFromHtml('<div class="quote">' + selectedText + '</div>');

                        selection.getRanges()[0].deleteContents();

                        //noinspection JSPotentiallyInvalidConstructorUsage
                        range = new CKEDITOR.dom.range(editor.document);

                        editor.insertElement(quoteTextElement);
                        editor.insertElement(quoteElement);

                        range.moveToPosition(quoteElement, CKEDITOR.POSITION_AFTER_END);

                        var nextElement = quoteElement.getNext();

                        if (!nextElement || nextElement.type == CKEDITOR.NODE_ELEMENT && !nextElement.isEditable()) {
                            range.fixBlock(true, editor.config.enterMode == CKEDITOR.ENTER_DIV ? 'div' : 'p');
                        }

                        range.select();
                    }
                }
            });

            editor.addCommand('spoiler', {
                canUndo: false,
                exec: function (editor) {

                    var state = editor.getCommand('spoiler').state,
                        spoilerElement,
                        spoilerContainer,
                        selection,
                        selectedText,
                        range;

                    if (state == CKEDITOR.TRISTATE_ON) {

                        spoilerElement = editor.getSelection().getStartElement();
                        spoilerContainer = spoilerElement.getParent();

                        spoilerElement.remove(true);
                        spoilerContainer.remove(true);

                    } else if (editor.getSelection().getSelectedText().length > 0) {

                        selection = editor.getSelection();

                        if (CKEDITOR.env.ie) {

                            selection.unlock();
                            selectedText = selection.getNative().createRange().text;

                        } else {

                            selectedText = selection.getNative();
                        }

                        spoilerElement = CKEDITOR.dom.element.createFromHtml('<span class="spoiler"><span>' + selectedText + '</span></span>');

                        selection.getRanges()[0].deleteContents();

                        //noinspection JSPotentiallyInvalidConstructorUsage
                        range = new CKEDITOR.dom.range(editor.document);

                        editor.insertElement(spoilerElement);

                        range.moveToPosition(spoilerElement, CKEDITOR.POSITION_AFTER_END);

                        var nextElement = spoilerElement.getNext();

                        if (!nextElement || nextElement.type == CKEDITOR.NODE_ELEMENT && !nextElement.isEditable()) {
                            range.fixBlock(true, editor.config.enterMode == CKEDITOR.ENTER_DIV ? 'div' : 'p');
                        }

                        range.select();
                    }
                }
            });

            editor.ui.addButton('Code', {
                label: 'Add Code',
                command: 'code'
            });

            editor.ui.addButton('Quote', {
                label: 'Add Quote',
                command: 'quote'
            });

            editor.ui.addButton('Spoiler', {
                label: 'Add Spoiler',
                command: 'spoiler'
            });
        },

        afterInit: function (editor) {

            var dataProcessor = editor.dataProcessor,
                dataFilter = dataProcessor && dataProcessor.dataFilter;

            if (dataFilter) {

                dataFilter.addRules({
                    elements: {

                        span: function (element) {

                            var test = element.attributes &&
                                element.attributes['title'] &&
                                element.attributes['class'] &&
                                element.attributes['class'].match(/emoticon/);

                            if (!test || test.length == 0) {
                                return null;
                            }

                            var emoticon = editor.createFakeParserElement(element, 'cke_emoticon', 'emoticon', 'false');

                            emoticon.attributes.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAMAAAAoyzS7AAAABGdBTUEAALGPC/xhBQAAAANQTFRF////p8QbyAAAAAF0Uk5TAEDm2GYAAAAJcEhZcwAAHsEAAB7BAcNpVFMAAAAHdElNRQfcDB4LNzBmlcQgAAAACklEQVQIHWNgAAAAAgABz8g15QAAAABJRU5ErkJggg==";

                            emoticon.attributes['class'] = element.attributes['class'];
                            emoticon.attributes['title'] = element.attributes['title'];
                            emoticon.attributes['alt'] = element.attributes['title'];

                            return emoticon;
                        }
                    }
                },
                9);
            }
        }
    });
})();