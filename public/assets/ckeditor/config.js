/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
/*CKEDITOR.plugins.add('wordpagebreak', {
    icons : 'wordpagebreak',
    init : function(editor) {

        var pluginName = 'wordpagebreak';

        editor.addCommand(pluginName, {
            exec : function(editor) {
                var html = '<br class="wordpagebreak" clear="all" ' +
                    'style="mso-special-character: line-break; ' +
                    'page-break-before: always">';
                var element = CKEDITOR.dom.element.createFromHtml(html);
                editor.insertElement(element);
            }
        });

        editor.ui.addButton(pluginName, {
            label : 'Word Page Break',
            icon : 'wordpagebreak',
            command : pluginName,
            toolbar : 'insert'
        });
    }
});*/

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
   // config.skin = 'office2013';
    config.allowedContent = true;
    config.line_height = "1em;1.1em;1.2em;1.3em;1.4em;1.5em";
    config.autoGrow_onStartup = true;
    config.baseHref = URL_ROOT;
    config.uploadUrl = URL_ROOT;
    config.height = 500;
    config.autoGrow_minHeight = 200;
    config.autoGrow_maxHeight = 600;
    config.autoGrow_bottomSpace = 50;
    //config.pasteFromWord_inlineImages = true;
    //config.pasteFromWordRemoveFontStyles = false; //preserve ms format
    config.removePlugins = 'save, forms, preview, language, styles, iframe, specialchar, flash, about, bidi, newpage, stylescombo, div, preview';
    config.extraPlugins = 'image2, toc, tabletoolstoolbar, tableresize, tableresizerowandcolumn,pagebreak, pastebase64, uploadfile';
    //config.fontSize_sizes = '8/8pt;9/9pt;10/10pt;11/11pt;12/12pt;14/14pt;16/16pt;18/18pt;20/20pt;22/22pt;24/24pt;26/26pt;28/28pt;36/36pt;48/48pt;72/72pt';
};
