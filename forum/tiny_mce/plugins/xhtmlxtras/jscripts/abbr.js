 /**
 * $Id: abbr.js,v 1.1 2008-01-12 01:38:35 decoyduck Exp $
 *
 * @author Moxiecode - based on work by Andrew Tetlaw
 * @copyright Copyright � 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

function preinit() {
	// Initialize
	tinyMCE.setWindowArg('mce_windowresize', false);
}

function init() {
	tinyMCEPopup.resizeToInnerSize();
	SXE.initElementDialog('abbr');
	if (SXE.currentAction == "update") {
		SXE.showRemoveButton();
	}
}

function insertAbbr() {
	SXE.insertElement(tinyMCE.isIE && !tinyMCE.isOpera ? 'html:ABBR' : 'abbr');
	tinyMCEPopup.close();
}

function removeAbbr() {
	SXE.removeElement('abbr');
	tinyMCEPopup.close();
}