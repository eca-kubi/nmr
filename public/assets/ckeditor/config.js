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
    config.autoGrow_onStartup = true;
    config.baseHref = URL_ROOT;
    config.uploadUrl = URL_ROOT;
    config.autoGrow_minHeight = 200;
    config.autoGrow_maxHeight = 600;
    config.autoGrow_bottomSpace = 50;
};
