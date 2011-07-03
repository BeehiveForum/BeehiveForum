tinyMCEPopup.requireLangPack();

var FlashDialog = {

    init: function () {

        var f = document.forms[0], n = tinyMCEPopup.editor.selection.getNode();

        f.flashURL.value = n.attributes['src'].value;
        f.flashWidth.value = n.attributes['width'].value;
        f.flashHeight.value = n.attributes['height'].value;
    },

    insert: function () {
        // Insert the contents from the input into the document
        var url = document.forms[0].flashURL.value;
        if (url === null) { tinyMCEPopup.close(); return; }

        var width = document.forms[0].flashWidth.value;
        var height = document.forms[0].flashHeight.value;

        tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img src="tiny_mce/plugins/flash/img/blank.gif" class="mceItem flash" alt="' + url + '" width="' + width + '" height="' + height + '" />');
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(FlashDialog.init, FlashDialog);
