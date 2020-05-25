(function () {
    let saveaspdfCmd = {
        canUndo: false,
        modes: {wysiwyg: 1},
        exec: function (editor) {
            if (previewEditor) {
                editor.update();
                previewEditor.value(editor.element.getValue());
                toggleNonPrintableElements(previewEditor);
                previewEditor.saveAsPDF()
            }
            return true;
        }
    };

    let pluginName = 'saveaspdf';

    CKEDITOR.plugins.add('saveaspdf',
        {
            lang: 'en',
            icons: 'saveaspdf', // %REMOVE_LINE_CORE%
            hdpi: true, // %REMOVE_LINE_CORE%
            init: function (editor) {
                //CKEDITOR.dialog.add(pluginName, this.path + 'dialogs/footnote.js');
                editor.addCommand(pluginName, saveaspdfCmd);
                editor.ui.addButton('saveaspdf',
                    {
                        label: 'Save As PDF',
                        command: pluginName,
                        toolbar: 'document',
                        name: 'saveaspdf'
                    });
            }
        });
})();


