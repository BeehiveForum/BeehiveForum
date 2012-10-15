(function () {

    CKEDITOR.plugins.add('beehive', {

        init: function (editor) {

            var allStyles = new CKEDITOR.style({
                element: $,
            });

            var findAscendant = function (element, reference, className) {

                var ascendant = element.getAscendant(reference);
                return ascendant && ascendant.hasClass(className);
            };

            editor.attachStyleStateChange(allStyles, function (state) {

                var element = this.getSelection().getStartElement();

                if ((element.getName() == 'div' && element.hasClass('quote')) || findAscendant(element, 'div', 'quote')) {
                    return !editor.readOnly && editor.getCommand('quote').setState(CKEDITOR.TRISTATE_ON);
                }

                if ((element.getName() == 'pre' && element.hasClass('code')) || findAscendant(element, 'pre', 'code')) {
                    return !editor.readOnly && editor.getCommand('code').setState(CKEDITOR.TRISTATE_ON);
                }

                if ((element.getName() == 'span' && element.hasClass('spoiler')) || findAscendant(element, 'span', 'spoiler')) {
                    return !editor.readOnly && editor.getCommand('spoiler').setState(CKEDITOR.TRISTATE_ON);
                }

                !editor.readOnly && editor.getCommand('quote').setState(CKEDITOR.TRISTATE_OFF);
                !editor.readOnly && editor.getCommand('code').setState(CKEDITOR.TRISTATE_OFF);
                !editor.readOnly && editor.getCommand('spoiler').setState(CKEDITOR.TRISTATE_OFF);
            });

            editor.addCommand('code', {
                canUndo: false,
                exec: function (editor) {

                    var state = editor.getCommand('code').state,
                        quoteTextElement,
                        codeElement,
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

                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><b>' + beehive.lang.code + ':</b>&nbsp;</div>');
                        codeElement = CKEDITOR.dom.element.createFromHtml('<pre class="code">' + editor.getSelection().getNative() + '</pre>');
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

                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><b>' + beehive.lang.quote + ':</b>&nbsp;</div>');
                        quoteElement = CKEDITOR.dom.element.createFromHtml('<div class="quote">' + editor.getSelection().getNative() + '</div>');
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
                        range;

                    if (state == CKEDITOR.TRISTATE_ON) {

                        spoilerElement = editor.getSelection().getStartElement();
                        spoilerContainer = spoilerElement.getParent();

                        spoilerElement.remove(true);
                        spoilerContainer.remove(true);

                    } else if (editor.getSelection().getSelectedText().length > 0) {

                        spoilerElement = CKEDITOR.dom.element.createFromHtml('<span class="spoiler"><span>' + editor.getSelection().getNative() + '</span></span>');

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
                command: 'code',
            });

            editor.ui.addButton('Quote', {
                label: 'Add Quote',
                command: 'quote',
            });

            editor.ui.addButton('Spoiler', {
                label: 'Add Spoiler',
                command: 'spoiler',
            });
        },

        afterInit: function (editor) {

            var dataProcessor = editor.dataProcessor,
                dataFilter = dataProcessor && dataProcessor.dataFilter,
                htmlFilter = dataProcessor && dataProcessor.htmlFilter;

            if (dataFilter) {

                dataFilter.addRules({
                    elements: {

                        span: function (element) {

                            var test = element.attributes
                                && element.attributes.class
                                && element.attributes.class.match(/emoticon/);

                            if (!test || test.length == 0) {
                                return null;
                            }

                            element.attributes.contentEditable = "false";

                            for (var key in element.children) {
                                element.children[key].attributes.contentEditable = "false";
                            }

                            return element;
                        }
                    }
                },
                9);
            }

            if (htmlFilter) {

                htmlFilter.addRules({
                    elements: {
                        $: function (element) {

                            var test = element.attributes
                                && element.attributes.class
                                && element.attributes.class.match(/emoticon/);

                            if (!test || test.length == 0) {
                                return element;
                            }

                            delete element.attributes.contenteditable;

                            for (var key in element.children) {
                                delete element.children[key].attributes.contenteditable;
                            }

                            return element;
                        }
                    }
                });
            }
        }
    });
}());