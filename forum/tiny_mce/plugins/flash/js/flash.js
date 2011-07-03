tinyMCEPopup.requireLangPack();

var FlashDialog = {

    init: function () {

        var f = document.forms[0], n = tinyMCEPopup.editor.selection.getNode();

        try {

            var properties = n.attributes['alt'].value.split(';wmode=');

            f.flashURL.value = decodeURIComponent(properties[0]) || '';

            f.flashWMode.value = decodeURIComponent(properties[1]) || 'opaque';

            f.flashWidth.value = n.attributes['width'].value;

            f.flashHeight.value = n.attributes['height'].value;

        } catch (e) {

        }
    },

    insert: function () {

        var url = document.forms[0].flashURL.value;

        if (url === null) {

            tinyMCEPopup.close();
            return;
        }

        var width = parseInt(document.forms[0].flashWidth.value);
        var height = parseInt(document.forms[0].flashHeight.value);
        var wmode = document.forms[0].flashWMode.value;

        tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img src="tiny_mce/plugins/flash/img/blank.gif" class="mceItem flash" alt="' + encodeURIComponent(url) + ';wmode=' + encodeURIComponent(wmode) + '" width="' + width + '" height="' + height + '" />');

        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(FlashDialog.init, FlashDialog);
