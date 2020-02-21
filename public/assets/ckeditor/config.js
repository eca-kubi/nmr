/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.skin = 'office2013';
    config.allowedContent = true;
    config.line_height="1em;1.1em;1.2em;1.3em;1.4em;1.5em" ;
    config.autoGrow_onStartup = true;
    config.baseHref = URL_ROOT;
    config.uploadUrl = URL_ROOT;
    config.height = 500;
    config.autoGrow_minHeight = 200;
    config.autoGrow_maxHeight = 600;
    config.autoGrow_bottomSpace = 50;
    config.extraPlugins = 'image2, toc, tabletoolstoolbar, tableresize, tableresizerowandcolumn';
    config.removePlugins = 'save, forms, preview, language, styles, iframe, specialchar, flash, about, bidi, newpage, stylescombo, div, preview, pastebase64';
};
