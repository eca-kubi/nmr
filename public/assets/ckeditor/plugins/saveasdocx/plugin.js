(function () {
    let saveasDocxCmd = {
        canUndo: false,
        modes: {wysiwyg: 1},
        exec: function (editor) {
            editor.update()
            toggleNonPrintableElements(editor)
            saveAsDocx(editor)
            toggleNonPrintableElements(editor)
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


