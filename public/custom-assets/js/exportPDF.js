function exportPDF (editor, tablePrefix= 'nmr') {
    let body = typeof  editor.body == 'function'? editor.body() : editor.body;
    kendo.drawing.drawDOM($(body), {
            allPages: true,
            margin: {left: "1cm", top: "1.5cm", right: "1cm", bottom: "1cm"},
            multipage: true,
            scale: 0.7,
            forcePageBreak: ".page-break",
            //keepTogether: 'table, li',
            template: $(`#page-template-body_${tablePrefix}`).html()
        }
    )
        .then(function (group) {
            // Render the result as a PDF file
            return kendo.drawing.exportPDF(group, {
                allPages: true,
                paperSize: "A4",
                scale: 0.7,
                forcePageBreak: ".page-break",
                margin: {left: "1cm", top: "1cm", right: "1cm", bottom: "1cm"}
            });
        })
        .done(function (data) {
            // Save the PDF file
            kendo.saveAs({
                dataURI: data,
                fileName: "NMR.pdf",
            });
        });

}
