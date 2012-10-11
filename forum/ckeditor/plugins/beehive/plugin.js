(function () {

    CKEDITOR.plugins.add('beehive', {

        init: function (editor) {

            var codeTag = new CKEDITOR.style({
                element: 'pre',
                attributes: {
                    'class': 'code'
                }
            });

            var quoteTag = new CKEDITOR.style({
                element: 'div',
                attributes: {
                    'class': 'quote'
                }
            });

            var spoilerTag = new CKEDITOR.style({
                element: 'span',
                attributes: {
                    'class': 'spoiler'
                }
            });

            editor.attachStyleStateChange(codeTag, function (state) {
                !editor.readOnly && editor.getCommand('code').setState(state);
            });

            editor.attachStyleStateChange(quoteTag, function (state) {
                !editor.readOnly && editor.getCommand('quote').setState(state);
            });

            editor.attachStyleStateChange(spoilerTag, function (state) {
                !editor.readOnly && editor.getCommand('spoiler').setState(state);
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

                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><b>code:</b>&nbsp;</div>');
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

                        quoteTextElement = CKEDITOR.dom.element.createFromHtml('<div class="quotetext"><b>quote:</b>&nbsp;</div>');
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

                    } else {

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
                dataFilter = dataProcessor && dataProcessor.dataFilter;

            if (dataFilter) {

                dataFilter.addRules({
                    elements: {

                        'span': function (element) {

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
        }
    });
}());