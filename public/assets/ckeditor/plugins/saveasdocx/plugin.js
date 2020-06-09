(function () {
    let saveasDocxCmd = {
        canUndo: false,
        modes: {wysiwyg: 1},
        exec: function (editor) {
            if (previewEditor) {
                editor.update();
                previewEditor.value(editor.element.getValue());
                toggleNonPrintableElements(previewEditor);
                saveAsDocx('<!DOCTYPE html>' + previewEditor.document.documentElement.outerHTML);
                toggleNonPrintableElements(previewEditor);
            }
            return true;
        }
    };

    let pluginName = 'saveasdocx';

    CKEDITOR.plugins.add('saveasdocx',
        {
            lang: 'en',
            icons: 'saveasdocx', // %REMOVE_LINE_CORE%
            hdpi: true, // %REMOVE_LINE_CORE%
            init: function (editor) {
                //CKEDITOR.dialog.add(pluginName, this.path + 'dialogs/footnote.js');
                editor.addCommand(pluginName, saveasDocxCmd);
                editor.ui.addButton('saveasdocx',
                    {
                        label: 'Save As Word Document',
                        command: pluginName,
                        toolbar: 'document',
                        name: 'saveasdocx'
                    });
            }
        });
})();


