tinyMCE.importPluginLanguagePack('beehive', 'en');

function TinyMCE_beehive_getControlHTML(control_name) {
	switch (control_name) {
		case "bhquote":
			return '<img id="{$editor_id}_quote" src="{$pluginurl}/images/quote.gif" title="{$lang_bh_quote_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhquote\');" />';
		case "bhcode":
			return '<img id="{$editor_id}_code" src="{$pluginurl}/images/code.gif" title="{$lang_bh_code_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhcode\');" />';
		case "bhspoiler":
			return '<img id="{$editor_id}_spoiler" src="{$pluginurl}/images/spoiler.gif" title="{$lang_bh_spoiler_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspoiler\');" />';
		case "bhnoemots":
			return '<img id="{$editor_id}_noemots" src="{$pluginurl}/images/noemots.gif" title="{$lang_bh_noemots_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhnoemots\');" />';
		case "bhspellcheck":
			return '<img id="{$editor_id}_spellcheck" src="{$pluginurl}/images/spellcheck.gif" title="{$lang_bh_spellcheck_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'bhspellcheck\');" />';
	}
	return "";
}

function TinyMCE_beehive_execCommand(editor_id, element, command, user_interface, value) {
	switch (command) {
		case "bhcode":
			tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="code-tinymce"><b>' + tinyMCELang['lang_bh_code_text'] + '</b> </div><pre class="code">{$selection}</pre>');
			return true;
		case "bhquote":
			tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="quote"><b>' + tinyMCELang['lang_bh_quote_text'] + '</b> </div><div class="quote">{$selection}</div>');
			return true;
		case "bhspoiler": 
			tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<div class="quotetext" id="spoiler"><b>' + tinyMCELang['lang_bh_spoiler_text'] + '</b> </div><div class="spoiler">{$selection}</div>');
			return true;
		case "bhnoemots":
			tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, '<span class="noemots">{$selection}</span>');
			return true;
		case "bhspellcheck":
			window.open('dictionary.php?webtag=' + webtag + '&obj_id=' + tinyMCE.instances[editor_id].formTargetElementId, 'spellcheck','width=450, height=550, scrollbars=1');
			return true;

		return true;
	}
	return false;
}