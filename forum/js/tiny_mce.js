tinyMCE.init({
    mode : "none",
    theme : "advanced",
    force_br_newlines : true,
    forced_root_block : '',
    inline_styles : false,
    plugins : "safari,table,inlinepopups,paste,beehive,youtube,flash",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,formatselect,fontselect,fontsizeselect,|,bhspellcheck",
    theme_advanced_buttons2 : "undo,redo,|,cleanup,code,removeformat,|,visualaid,|,tablecontrols",
    theme_advanced_buttons3 : "forecolor,backcolor,|,sub,sup,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,image,|,bhquote,bhcode,bhspoiler,youtube,flash,bhnoemots",
    extended_valid_elements : "b,marquee,span[class|align|title],div[class|align|id],font[face|size|color|style]",
    invalid_elements : "!doctype|applet|body|base|button|fieldset|form|frame|frameset|head|html|iframe|input|label|legend|link|meta|noframes|noscript|object|optgroup|option|param|plaintext|script|select|style|textarea|title|xmp",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    content_css : "tiny_mce/plugins/beehive/beehive.css,tiny_mce/plugins/flash/flash.css"
});

var htmltools = function()
{
    var auto_spell_check_started = false;

    return {

        auto_spell_check : function()
        {
            if (tinyMCE.activeEditor.getContent().length === 0) {
                 return true;
            }

            if ($('#t_check_spelling').is(':checked') && !auto_spell_check_started) {

                auto_spell_check_started = true;

                this.open_spell_check(tinyMCE.activeEditor.id);

                return false;
            }
        },

        get_content : function()
        {
            return tinyMCE.activeEditor.getContent();
        },

        set_content : function(content)
        {
            tinyMCE.activeEditor.setContent(content);
        },

        add_text : function(text)
        {
            if (tinyMCE.activeEditor.getContent().length < 1) {
                tinyMCE.activeEditor.setContent('');
            }

            tinyMCE.execCommand('mceInsertContent', false, text);
        }
    };
}();

$(document).ready(function() {

    $('.tinymce_editor').each(function() {
        tinyMCE.execCommand("mceAddControl", true, this.id);
    });
});