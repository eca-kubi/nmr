docEditor = editor.body();
kendo.drawing.drawDOM($(docEditor), {
        allPages: true,
        paperSize: 'A4',
        margin: {left: "1cm", top: "1cm", right: "1cm", bottom: "1cm"},
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
