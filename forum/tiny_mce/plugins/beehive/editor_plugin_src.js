tinyMCE.importPluginLanguagePack('beehive', 'en');

function TinyMCE_beehive_getControlHTML(control_name)
{
    if (tinyMCE.majorVersion == '2' && tinyMCE.minorVersion >= '0.3') {

        switch (control_name) {

            case 'bhquote':
                return '<a id="{$editor_id}_bhquote" href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhquote\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhquote\',false);return false;" onmousedown="return false;" class="mceButtonNormal" target="_self"><img src="{$pluginurl}/images/quote.gif" alt="{$lang_bh_quote_desc}" title="{$lang_bh_quote_desc}"></a>';

            case 'bhcode':
                return '<a id="{$editor_id}_bhcode" href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhcode\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhcode\',false);return false;" onmousedown="return false;" class="mceButtonNormal" target="_self"><img src="{$pluginurl}/images/code.gif" alt="{$lang_bh_code_desc}" title="{$lang_bh_quote_desc}"></a>';

            case 'bhspoiler':
                return '<a id="{$editor_id}_bhspoiler" href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspoiler\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspoiler\',false);return false;" onmousedown="return false;" class="mceButtonNormal" target="_self"><img src="{$pluginurl}/images/spoiler.gif" alt="{$lang_bh_spoiler_desc}" title="{$lang_bh_spoiler_desc}"></a>';

            case 'bhnoemots':
                return '<a id="{$editor_id}_bhnoemots" href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhnoemots\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhnoemots\',false);return false;" onmousedown="return false;" class="mceButtonNormal" target="_self"><img src="{$pluginurl}/images/noemots.gif" alt="{$lang_bh_noemots_desc}" title="{$lang_bh_noemots_desc}"></a>';

            case 'bhspellcheck':
                return '<a id="{$editor_id}_bhspellcheck" href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspellcheck\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspellcheck\',false);return false;" onmousedown="return false;" class="mceButtonNormal" target="_self"><img src="{$pluginurl}/images/spellcheck.gif" alt="{$lang_bh_spellcheck_desc}" title="{$lang_bh_spellcheck_desc}"></a>';

        }
    }
    
    return '';
}

function TinyMCE_beehive_execCommand(editor_id, element, command, user_interface, value)
{
    if (tinyMCE.majorVersion == '2' && tinyMCE.minorVersion >= '0.3') {

        switch (command) {

            case 'bhcode':
                
                tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="code-tinymce"><b>' + tinyMCELang['lang_bh_code_text'] + '</b> </div><pre class="code">{$selection}</pre>');
                return true;

            case 'bhquote':
                
                tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="quote"><b>' + tinyMCELang['lang_bh_quote_text'] + '</b> </div><div class="quote">{$selection}</div>');
                return true;

            case 'bhspoiler': 
                
                tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="spoiler"><b>' + tinyMCELang['lang_bh_spoiler_text'] + '</b> </div><div class="spoiler">{$selection}</div>');
                return true;

            case 'bhnoemots':
                
                tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<span class="noemots">{$selection}</span>');
                return true;

            case 'bhspellcheck':
                
                if (tinyMCE.getContent(editor_id).length > 0) {
                
                    window.open('dictionary.php?webtag=' + webtag + '&obj_id=' + tinyMCE.instances[editor_id].formTargetElementId, 'spellcheck','width=450, height=550, scrollbars=1');
                    return true;
                }

                return true;
        }
    }
    
    return false;
}