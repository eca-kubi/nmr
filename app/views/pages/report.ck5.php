<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed border-primary">
                <div class="box-header">
                    <h3 class="box-title text-bold text-success">
                        <?php echo $title ?? ''; ?>
                    </h3>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="editorTabStrip">
                        <ul>
                            <?php if (!(isset($is_submission_closed) && $is_submission_closed)): ?>
                                <li class="k-state-active">Edit</li> <?php endif; ?>
                            <li class="<?php echo isset($is_submission_closed) && $is_submission_closed ? 'k-state-active' : '' ?>">
                                Preview
                            </li>
                        </ul>
                        <?php if (!(isset($is_submission_closed) && $is_submission_closed)): ?>
                            <div id="editorTab">
                                <div id="editorActionToolbar"></div>
                                <div class="document-editor">
                                    <div class="document-editor__toolbar"></div>
                                    <div class="document-editor__editable-container">
                                        <div class="document-editor__editable">

                                        </div>
                                    </div>
                                </div>
                                <div class="d-none" id="editorWrapper" style="width: 100%;">
                                    <!-- The toolbar will be rendered in this container. -->
                                    <div id="toolbar-container"></div>

                                    <!-- This container will become the editable. -->
                                    <div id="editor">
                                        <p>This is the initial editor content.</p>
                                    </div>
                                    <form id="editorForm">
                                        <input type="hidden" id="spreadsheetContent" name="spreadsheet_content"
                                               value='<?php echo $spreadsheet_content ?? ''; ?>'>
                                        <input type="hidden" id="title" name="title"
                                               value="<?php echo $title ?? ''; ?>">
                                        <input type="hidden" id="draftId" name="draft_id"
                                               value="<?php echo $draft_id ?? ''; ?>">
                                        <input type="hidden" id="draftTitleInput" name="draft_title_input"
                                               value="<?php echo $title ?? ''; ?>">

                                        <input type="hidden" id="targetYear" name="target_year"
                                               value="<?php echo $target_year ?? ''; ?>">
                                        <input type="hidden" id="targetMonth" name="target_month"
                                               value="<?php echo $target_month ?? ''; ?>">
                                        <input type="hidden" id="targetDepartmentID" name="target_department_id"
                                               value="<?php echo $target_department_id ?? ''; ?>">
                                        <input type="hidden" id="departmentName" name="department_name">
                                        <input type="hidden" id="reportSubmissionsId" name="report_submissions_id"
                                               value="<?php echo $report_submissions_id ?? ''; ?>">
                                        <input type="hidden" id="editSubmittedReport" name="edit_submitted_report"
                                               value="<?php echo $edit_submitted_report ?? ''; ?>">
                                        <input type="hidden" id="reportPartId" name="report_part_id"
                                               value="<?php echo $report_part_id ?? ''; ?>">
                                        <input type="hidden" id="reportPartIdTemp" name="report_part_id_temp">
                                        <input type="hidden" id="reportPartDescription" name="report_part_description"
                                               value="<?php echo $report_part_description ?? ''; ?>">
                                        <input type="hidden" id="finalReportId" name="final_report_id"
                                               value="<?php echo $final_report_id ?? ''; ?>">
                                    </form>
                                </div>
                            </div> <?php endif; ?>
                        <div id="previewTab">
                            <div id="previewContent"></div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
            <div class="box collapsed border-warning <?php echo isset($is_submission_closed) && $is_submission_closed ? 'd-none' : ''; ?>"
                 style="height: 800px">
                <div class="box-header">
                    <h5 class="box-title text-bold"><span class="fa fa-chart-bar text-warning"></span> Charts</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="height: 450px">
                    <div id="chartsContainer" class="border-left-0 border-top-0" style="height:450px">
                        <div class="pane-content" style="height:450px">
                            <div class="w-100" style="height:450px">
                                <div id="spreadSheet" class="w-100"></div>
                            </div>
                        </div>
                        <div class="pane-content" style="height:450px;overflow: hidden;">
                            <div id="chartsTabstripHolder" style="height:450px;">
                                <div id="chartsTabStrip" style="height:450px;"></div>
                                <span class="fa fa-10x fa-chart-bar text-gray" id="emptyChartPlaceHolder" style="
    position: absolute;
    top: 40%;
    right: 40%;
"></span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row" id="chartsContainer">
                        <div class="col-md-6">
                            <div id="spreadSheet" class="w-100" style="height: 400px; width: 100%"></div>
                        </div>
                        <div class="col-md-6" id="chartsTabstripHolder">
                            <div id="chartsTabStrip" style="height: 400px; width: 100%"></div>
                            <span class="fa fa-10x fa-chart-bar text-gray" id="emptyChartPlaceHolder" style="
    position: absolute;
    top: 30%;
    right: 40%;
"></span>
                        </div>
                    </div>-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php /*include_once(APP_ROOT . '/views/includes/scripts.php'); */?>

<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-mutation-observer/mutation-summary.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-mutation-observer/jquery-mutation-observer.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-ui/effects-core.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/moment/moment.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/bootnavbar/js/bootnavbar.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/adminlte/adminlte.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jszip/jszip.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/kendo-ui/kendo.all.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/letter-avatar/letter-avatar.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-scrollTo/jquery.scrollTo.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-toast/jquery-toast.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-dim-background/jquery-dim-background.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/clipboardjs/clipboard.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/html-docx/html-docx.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/pako-deflate/pako-deflate.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/pdfjs/pdf.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/ckfinder/ckfinder.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/ckeditor-5/ckeditor.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/node_modules/@ckeditor/ckeditor5-inspector/build/inspector.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/custom-assets/js/custom.js?t=<?php echo now(); ?>"></script>
<script src="<?php echo URL_ROOT; ?>/public/custom-assets/js/exportPDF.js?t=<?php echo now(); ?>"></script>


<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>
<input type="hidden" id="spreadsheetTemplates" value='<?php /** @var string $spreadsheet_templates */
echo $spreadsheet_templates; ?>'>
<?php
$table_prefixes = ['nmr', 'nmr_fr'];
$cover_pages = [];
foreach ($table_prefixes as $tb_p) {
    $cover_pages[$tb_p] = Database::getDbh()->where('name', 'cover_page')->getValue($tb_p . '_report_parts', 'content');
}
$distribution_list = Database::getDbh()->where('name', 'distribution_list')->getValue('nmr_report_parts', 'content');
$blank_page = Database::getDbh()->where('name', 'blank_page')->getValue('nmr_report_parts', 'content');
?>

<script>
    const HEADER_BACKGROUND_COLOR = "#9c27b0";
    const HEADER_BORDER = {color: HEADER_BACKGROUND_COLOR, size: 2};
    const COVER_PAGES = {
        nmr: `<?php echo $cover_pages['nmr']; ?>`,
        nmr_fr: `<?php echo $cover_pages['nmr_fr']; ?>`
    };
    const BLANK_PAGE = `<?php echo $blank_page; ?>`;

    const DISTRIBUTION_LIST = `<?php echo $distribution_list ?>`;

    let spreadsheetTemplates;
    /**
     * @type {kendo.ui.Spreadsheet}
     * */
    let spreadsheet;
    /**
     * @type {kendo.ui.TabStrip}
     * */
    let chartsTabStrip;
    /**
     * @type {kendo.ui.TabStrip}
     * */
    let editorTabStrip;
    let chartTabs = [];
    let charts = [];
    let editor;
    let firstSheetLoading = true;
    let editDraft = Boolean(<?php echo $edit_draft ?? '' ?>);
    let isNewDraft = Boolean(<?php echo $is_new_draft ?? '' ?>);
    let editReport = Boolean(<?php echo $edit_report ?? ''; ?>);
    let editReportPart = Boolean(<?php echo $edit_report_part ?? ''; ?>);
    let addReportPart = Boolean(<?php echo $add_report_part ?? ''; ?>);
    let editPreloadedDraft = Boolean(<?php echo $edit_preloaded_draft ?? ''; ?>);
    let editSubmittedReport = Boolean(<?php echo $edit_submitted_report ?? ''; ?>);
    let editFinalReport = Boolean(<?php echo $edit_final_report ?? ''; ?>);
    let tablePrefix = "<?php echo $table_prefix ?? 'nmr'; ?>";
    let targetMonth = "<?php echo $target_month ?? DEFAULT_DRAFT_MONTH; ?>";
    let targetYear = "<?php echo $target_year ?? DEFAULT_DRAFT_YEAR; ?>";
    let targetDepartmentID = "<?php echo $target_department_id ?? ''; ?>";

    let clearedContents = "";
    /** @type {kendo.ui.ToolBar}*/
    let editorActionToolbar;
    let seriesColor = {
        goldProduced: "#5b9bd5",
        budgetOunces: "#ed7d31",
        plannedMetres: "#f2740f",
        actualMetres: "#7f9c45",
        lowGrade: "#5b9bd5",
        romGrade: "#ed7d31",
        milledTonnage: "#ff6eff",
        deliveryTonnage: "#03b855",
        budgetTonnage: "#ffcd9b",
        tonnesMilled: "#fbbd00",
        budgetTonnesMilled: "#70ad47",
        actualGoldProduced: "#43682b"
    };
    let previewWindow;
    let previewViewer;
    let pdfViewer;
    let userDepartmentId = "<?php echo $current_user->department_id ?? '' ; ?>";
    let previewEditor;
    let contentCover;
    let contentDistributionList;
    let fontSizeVariable = "12";
    let fontFamilyVariable = '"Times New Roman", sans-serif, Arial, Verdana, "Trebuchet MS"';

    $(function () {
        DecoupledDocumentEditor
            .create( document.querySelector( '.document-editor__editable' ), {
                placeholder: 'Type some text...',
                toolbar: ['exportPDF', '|', 'heading', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|', 'bold', 'italic', 'underline', 'strikethrough','highlight', '|', 'alignment', '|', 'bulletedList', 'numberedList', 'indent', 'outdent', 'undo', 'redo', '|', "BlockQuote", "CKFinder", "ImageUpload", "Link", "PageBreak", "RemoveFormat", "InsertTable"],
                fontFamily: {
                    supportAllValues: true
                },
                image: {
                    // Configure the available styles.
                    styles: [
                        'alignLeft', 'alignCenter', 'alignRight'
                    ],

                    // Configure the available image resize options.
                    resizeOptions: [
                        {
                            name: 'imageResize:original',
                            label: 'Original',
                            value: null
                        },
                        {
                            name: 'imageResize:50',
                            label: '50%',
                            value: '50'
                        },
                        {
                            name: 'imageResize:75',
                            label: '75%',
                            value: '75'
                        }
                    ],

                    // You need to configure the image toolbar, too, so it shows the new style
                    // buttons as well as the resize buttons.
                    toolbar: [
                        'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                        '|',
                        'imageResize',
                        '|',
                        'imageTextAlternative'
                    ]
                },

                table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells',
                        'tableProperties', 'tableCellProperties'
                    ],

                    // Configuration of the TableProperties plugin.
                    tableProperties: {
                        // ...
                    },

                    // Configuration of the TableCellProperties plugin.
                    tableCellProperties: {
                        // ...
                    }
                }

                //toolbar: ['heading', 'bulletedList', 'numberedList', 'fontColor', 'fontBackgroundColor', 'undo', 'redo', "Alignment", "Autoformat", "Autosave", "BlockQuote", "Bold", "CKFinder", "CKFinderUploadAdapter", "Essentials", "ExportPdf", "FontFamily", "FontSize", "Heading", "Highlight", "Image", "ImageUpload", "ImageCaption", "ImageResize", "ImageStyle", "ImageToolbar", "Indent", "IndentBlock", "Italic", "Link", "List", "MediaEmbed", "PageBreak", "Paragraph", "PasteFromOffice", "RemoveFormat", "Strikethrough", "InsertTable", "TableCellProperties", "TableProperties", "TableToolbar", "TextTransformation", "TodoList", "Underline", "WordCount"]
            } )
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                CKEditorInspector.attach( editor );

                window.editor = editor;
            } )
            .catch( err => {
                console.error( err );
            } );



        /*CKEDITOR.editor.prototype.value = function () {
            return this.getData();
        };
        CKEDITOR.editor.prototype.body = function () {
            return this.document.$.body;
        };
        CKEDITOR.editor.prototype.update = function () {
            this.updateElement();
        };
        CKEDITOR.editor.prototype.exec = function (command, content) {
            if (command === 'insertHtml')
                this.insertHtml(content);
        };
        CKEDITOR.editor.prototype.paste = function (content) {
            this.insertHtml(content);
        };


        CKEDITOR.on('instanceReady', (evt) => {
            /!**
             * @type CKEDITOR.editor;
             * *!/
            let editor = evt.editor;

            editor.document.$.querySelector('html').style.backgroundColor = "#eeeeee";
            editor.document.$.title = "NZEMA MONTHLY REPORT " + moment().format("Y");
            $(editor.document.$.body).addClass("document-editor");

            loadDraft();
        });

        CKEDITOR.replace('content', {
            qtRows: 8, // Count of rows
            qtColumns: 10, // Count of columns
            qtBorder: '1', // Border of inserted table
            qtWidth: '100%', // Width of inserted table
            qtStyle: {'border-collapse': 'collapse'},
            qtClass: 'test', // Class of table
            qtCellPadding: '0', // Cell padding table
            qtCellSpacing: '0', // Cell spacing table
            qtPreviewBorder: '1px solid gray', // preview table border
            qtPreviewSize: '16px', // Preview table cell size
            //qtPreviewBackground: '#c8def4', // preview table background (hover)
            //removePlugins: 'save, forms, language, styles, iframe, specialchar, flash, about, bidi, newpage, stylescombo, div',
            removePlugins: 'uploadimage', // Copy formatting prevents pastefromword from pasting tables properly
            extraPlugins: 'pastebase64,autosave,spacingsliders,autolink,saveaspdf,saveasdocx,pagebreak,balloontoolbar,openlink,quicktable,selectallcontextmenu,tableresizerowandcolumn,texttransform',
            autosave: {
                delay: 15,
                diffType: "inline",
                saveDetectionSelectors: "[id*='btnSave'], [id*='updateSubmittedReportBtn'], [id*='submitReportBtn']"
            },
            // allowedContent: true,
            allowedContent: {
                $1: {
                    // Use the ability to specify elements as an object.
                    elements: CKEDITOR.dtd,
                    attributes: true,
                    styles: true,
                    classes: true
                }
            },
            //extraAllowedContent: "img[width,height,align]",
            disallowedContent: "img{width,height,float}; *{text-indent};",
            format_tags: CKEDITOR.config.format_tags + ';div',
            font_names: 'Calibri Light; Calibri;Segoe UI Symbol;' + CKEDITOR.config.font_names,
            //font_defaultLabel: 'Times New Roman',
            //fontSize_defaultLabel: '11',
            customConfig: "",
            fontSize_sizes: '8/8pt;9/9pt;10/10pt;11/11pt;12/12pt;14/14pt;16/16pt;18/18pt;20/20pt;22/22pt;24/24pt;26/26pt;28/28pt;36/36pt;48/48pt;72/72pt',
            contentsCss: [
                URL_ROOT + '/public/assets/ckeditor/contents.css',
                URL_ROOT + '/public/custom-assets/css/ckeditor-sample-file.css',
                URL_ROOT + '/public/assets/ckeditor/plugins/pastefromword/pastefromword.css',
                URL_ROOT + '/public/custom-assets/css/ckeditor-fixes.css'
            ],
            bodyClass: "document-editor",
            height: "500",
            title: "Nzema Monthly Report",
            toolbar: [
                {name: 'document', items: ['saveaspdf', 'saveasdocx'/!*, 'Print'*!/]},
                {name: 'clipboard', items: ['Undo', 'Redo']},
                {name: 'styles', items: ['Format', 'Font', 'FontSize', 'spacingsliders']},
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', /!*'Strike',*!/ 'RemoveFormat', 'CopyFormatting']
                },
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
                {name: 'links', items: ['Link', 'Unlink']},
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'/!*, '-', 'Blockquote'*!/]
                },
                {name: 'insert', items: ['Image', 'Table', /!*'HorizontalRule'*!/]},
                {name: 'tools', items: ['Maximize']},
                //{name: 'editing', items: ['PageBreak', isITAdmin ? 'Source' : '']}
                {name: 'editing', items: ['PageBreak', 'Source']}
            ],
            uploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Files&responseType=json',
            filebrowserBrowseUrl: URL_ROOT + '/ckfinder/browse/',
            //filebrowserImageBrowseUrl: URL_ROOT + '/ckfinder/browse?type=Images',
            //filebrowserUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Files',
            //filebrowserImageUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Images'
        });

        editor = CKEDITOR.instances.editor;
*/


        previewEditor = $("<div id='previewEditorParent'><textarea id='previewEditor' style='width: 100%;'/> </div>").appendTo("body");
        previewEditor = $("#previewEditor").kendoEditor({
            //pasteCleanup: {none: true},
            pdf: $.extend({}, pdfExportOptions, {margin: "1cm", fileName: 'Nzema Report.pdf'}),
            tools: [],
            stylesheets: [
                //"<?php echo URL_ROOT; ?>/public/assets/ckeditor/contents.css?f=<?php echo now() ?> ",
                //"<?php echo URL_ROOT; ?>/public/custom-assets/css/ckeditor-sample-file.css?f=<?php echo now() ?> ",
                //"<?php echo URL_ROOT; ?>/public/assets/ckeditor/plugins/pastefromword/pastefromword.css?f=<?php echo now() ?> ",
                "<?php echo URL_ROOT; ?>/public/assets/fonts/font-face/css/fonts.css?f=<?php echo now() ?> ",
                "<?php echo URL_ROOT; ?>/public/custom-assets/css/k-editor.css?f=<?php echo now() ?> ",
            ]
        }).data("kendoEditor");

        $(previewEditor.body).addClass('document-editor');
        $(previewEditor.wrapper).find('td.k-editable-area').addClass('p-0'); // padding: 0


        $("#chartsContainer").kendoSplitter({
            //orientation: "vertical",
            panes: [
                {collapsible: true},
                {collapsible: true}
            ]
        });

        spreadsheetTemplates = JSON.parse($("#spreadsheetTemplates").val());


        if (editFinalReport) {
            let content = $("[name=content]").val();
            // Extract cover page and distribution list
            if (content) {
                // Remove  Cover and Distribution List
                content = removeTagAndContent('coverpage', content);
                content = removeTagAndContent('distributionlist', content);
                //update textarea
                $("[name=content]").val(content);
            }
        }

        function getPDFViewer() {
            return typeof pdfViewer === 'undefined' ? $("#previewContent").kendoPDFViewer({
                messages: {
                    defaultFileName: 'Nzema Monthly Report'
                },
                pdfjsProcessing: {
                    file: ""
                },
                width: "100%",
                height: 800,
                scale: 1.42,
                toolbar: {
                    items: [
                        "pager", "zoom", "toggleSelection", "search", "download", "print",
                        {
                            id: "cancel",
                            type: "button",
                            text: "Cancel",
                            icon: "cancel",
                            click: function () {
                                window.history.back()
                            },
                            hidden: isSubmissionClosed(targetMonth, targetYear, tablePrefix)
                        }
                    ]
                }
            }).getKendoPDFViewer() : pdfViewer;
        }

        pdfViewer = getPDFViewer();
        pdfViewer.pageContainer.attr('style', 'background-color:#eeeeee;' + pdfViewer.pageContainer.attr('style'));

        window.contentPreview = contentPreview;

        function contentPreview(saveAsPDF = false) {
            let drawing = kendo.drawing;

            function mm(val) {
                return val * 2.8347;
            }

            let PAGE_RECT = new kendo.geometry.Rect(
                [0, 0], [mm(210 - 20), mm(297 - 20)]
            );
            if (editFinalReport) {
                // first draw cover
                let targetMonth = $("#targetMonth").val();
                let targetYear = $("#targetYear").val();
                previewEditor.value(COVER_PAGES[tablePrefix].replace("#: monthYear #", targetMonth.toUpperCase() + ' ' + targetYear));
                kendo.drawing.drawDOM($(previewEditor.body), {
                    allPages: true,
                    paperSize: 'A4',
                    margin: tablePrefix === 'nmr_fr' ? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                    multipage: true,
                    scale: 0.7,
                    forcePageBreak: ".page-break",
                    keepTogether: 'table, li',
                    template: $(`#page-template-cover-toc_${tablePrefix}`).html()
                }).done(function (group) {
                    progress('.content-wrapper', true);
                    $.post({
                        url: URL_ROOT + '/pages/preview-content',
                        data: {content: editor.value()}
                    }).done(function (data) {
                        previewEditor.value(data);
                        kendo.drawing.drawDOM($(previewEditor.body), {
                            allPages: true,
                            paperSize: 'A4',
                            margin: tablePrefix === 'nmr_fr' ? {
                                top: "3cm",
                                right: "1cm",
                                bottom: "1cm",
                                left: "1cm"
                            } : "1cm",
                            multipage: true,
                            scale: 0.7,
                            forcePageBreak: ".page-break",
                            keepTogether: 'table, li',
                            template: $(`#page-template-body_${tablePrefix}`).html()
                        }).done((group2) => {
                            group.append(...group2.children);
                            kendo.drawing.exportPDF(group, {
                                allPages: true,
                                paperSize: 'A4',
                                margin: tablePrefix === 'nmr_fr' ? {
                                    top: "3cm",
                                    right: "1cm",
                                    bottom: "1cm",
                                    left: "1cm"
                                } : "1cm",
                                multipage: true,
                                scale: 0.7,
                                keepTogether: 'table, li',
                                forcePageBreak: ".page-break"
                            }).done(data2 => {
                                progress('.content-wrapper');
                                pdfViewer.fromFile({data: data2.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                                console.log('preview')
                                setTimeout(() => pdfViewer.activatePage(1), 1000)
                            })
                        })
                    })

                })
            } else {
                let template = $(`#page-template-body_${tablePrefix}`).html();
                let pdfOptions = $.extend({template: template}, pdfExportOptions);
                tablePrefix === 'nmr_fr' ? pdfOptions.margin = {
                    top: "3cm",
                    right: "1cm",
                    bottom: "1cm",
                    left: "1cm"
                } : pdfOptions.margin = "1cm";
                let content = editor ? editor.value() : previewEditor.value();
                previewEditor.value(content);
                drawing.drawDOM($(previewEditor.body), pdfOptions).then(group => {

                    let content = new kendo.drawing.Group();
                    content.append(group);
                    kendo.drawing.fit(content, PAGE_RECT);

                    return drawing.exportPDF(group, {});

                }).done(data => {
                    if (saveAsPDF) {
                        kendo.saveAs({
                            dataURI: data,
                            fileName: "Nzema Report.pdf",
                            //proxyURL: "https://demos.telerik.com/kendo-ui/service/export"
                        });
                    } else {
                        pdfViewer.fromFile({data: data.split(',')[1]});
                        setTimeout(() => pdfViewer.activatePage(1), 500);
                    }
                });
            }
        }

        editorTabStrip = $("#editorTabStrip").kendoTabStrip({
            select(e) {
                // Hide resize handle when showing preview
                //let resizeHandle = $(previewEditor.body).find('.k-table-resize-handle-wrapper');
                if (e.contentElement.id === "previewTab") {
                    //resizeHandle.hide();
                    /*$.post(URL_ROOT + "/pages/preview-content/", {
                        content: editor.value()
                    }, null, "html").done((data) => {
                        previewEditor.value(data);
                        previewContent();
                    });*/
                    toggleNonPrintableElements(previewEditor);
                    contentPreview();
                } /*else {
                    //resizeHandle.show();
                }*/
            }
        }).data('kendoTabStrip');

        chartsTabStrip = $("#chartsTabStrip").kendoTabStrip({
            activate(e) {
                let emptyChartPlaceholder = $("#emptyChartPlaceHolder");
                spreadsheet.activeSheet(spreadsheet.sheetByName($(e.item).text()));
                if (e.contentElement.innerHTML.length)
                    emptyChartPlaceholder.addClass('d-none');
                else
                    emptyChartPlaceholder.removeClass('d-none');
            }
        }).data("kendoTabStrip");

        editorActionToolbar = $("#editorActionToolbar").kendoToolBar({
            items: [
                {
                    id: "btnSaveDraft",
                    type: "button",
                    text: "Save Draft",
                    icon: "save",
                    click: saveDraft,
                    hidden: "<?php echo isset($edit_draft) ? '' : 'true' ?>"
                    //hidden: true
                },
                {
                    id: "btnSave",
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: saveReportPart,
                    hidden: "<?php echo isset($edit_report_part) ? '' : 'true' ?>"
                },
                {
                    id: "btnSaveFinalReport",
                    type: "button",
                    text: "Save Final Report",
                    icon: "save",
                    click: saveFinalReport,
                    hidden: "<?php echo isset($edit_final_report) ? '' : 'true' ?>"
                },
                {
                    id: "btnSave",
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: onEditSubmittedReport,
                    hidden: "<?php echo isset($edit_submitted_report) ? '' : 'true' ?>"
                },
                {
                    type: "button",
                    text: "Clear",
                    icon: "refresh-clear",
                    click: function () {
                        if (editor.value()) {
                            clearedContents = editor.value();
                            editor.value("");
                            editorActionToolbar.show("#undoClearContents");
                        }
                    },
                    hidden: true
                },
                {
                    type: "button",
                    text: "Undo Clear",
                    icon: "undo",
                    id: "undoClearContents",
                    click: function () {
                        if (clearedContents) {
                            editor.value(clearedContents);
                            editorActionToolbar.hide("#undoClearContents");
                            clearedContents = "";
                        }
                    },
                    hidden: true
                },
                <?php if (isset($edit_draft) && isSubmissionOpened($target_month ?? '', $target_year ?? '', $table_prefix ?? 'nmr')): ?>
                {
                    type: "button",
                    text: "Submit Report",
                    icon: "check",
                    id: "submitReportBtn",
                    attributes: {"class": "submit-report-btn"},
                    click: submitReport,
                    hidden: Boolean("<?php echo isReportSubmitted($target_month ?? '', $target_year ?? '', $department_id ?? '', $table_prefix ?? 'nmr') ? 'true' : '' ?>")
                },
                {
                    type: "button",
                    id: "updateSubmittedReportBtn",
                    icon: "upload",
                    attributes: {"class": "update-submitted-report-btn"},
                    text: "Update Submitted Report",
                    click: submitReport,
                    hidden: Boolean("<?php echo isReportSubmitted($target_month ?? '', $target_year ?? '', $department_id ?? '', $table_prefix ?? 'nmr') ? '' : 'true' ?>")
                },
                <?php endif; ?>

                <?php if (isITAdmin($current_user->user_id)): ?>
                {
                    id: "btnSave",
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: savePreloadedDraft,
                    hidden: editPreloadedDraft ? '' : true
                },
                {
                    id: "btnSaveReportPart",
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: saveReportPart,
                    hidden: addReportPart ? '' : true
                },
                {
                    id: "btnSaveAsPreloaded",
                    type: "button",
                    text: "Save as Preloaded",
                    icon: "launch",
                    click: saveDraftAsPreloaded,
                    hidden: true
                },
                <?php endif; ?>
                {
                    type: "button",
                    id: "cancelBtn",
                    icon: "cancel",
                    attributes: {"class": "cancel-btn"},
                    text: "Cancel",
                    click: e => history.back(),
                }
            ]
        }).data("kendoToolBar");

        let chartMenuCommand = {
            template: kendo.template($("#chartsMenuTemplate").html())
        };

        let copyToEditor = {
            template: kendo.template($("#copyToEditor").html())
        };

        spreadsheet = $("#spreadSheet").kendoSpreadsheet({
            columnWidth: 50,
            toolbar: {
                //home: [chartMenuCommand].concat(kendo.spreadsheet.ToolBar.fn.options.tools.home),
                home: [
                    chartMenuCommand,
                    copyToEditor,
                    <?php if (isITAdmin($current_user->user_id)) : ?>
                    {
                        type: "button",
                        template: '<a href="#" id="#saveSpreadsheetBtn" data-role="button" tabindex="0" title="Save Spreadsheet as Template" data-tool="saveSheetTemplate" class="k-button k-button-icon"  data-overflow="auto" onclick="saveSpreadsheetTemplate(event)"><span class="k-icon k-i-save"></span></a>',
                    }, <?php endif; ?>
                    "open",
                    "exportAs",
                    //["cut", "copy", "paste"],
                    ["bold", "italic", "underline"],
                    "fontSize",
                    "fontFamily",
                    "alignment",
                    "textWrap",
                    "borders",
                    ["formatDecreaseDecimal", "formatIncreaseDecimal"],
                    "backgroundColor",
                    "textColor",
                    "format",
                    "merge",
                    "freeze",
                    "filter",
                    "insertImage",
                    "insertComment",
                    "hyperlink"
                ],
                //insert: false,
                //data: false
            },
            //columns: 14,
            //rows: 8,
            removeSheet(e) {
                chartsTabStrip.remove("li[aria-controls=" + chartTabs[e.sheet.name()] + "]");  //remove chart related to sheet
                updateChartTabs();
                if (chartsTabStrip.items().length) {
                    setTimeout(function () {
                        $("#emptyChartPlaceHolder").addClass('d-none');
                        selectChartTab(spreadsheet.activeSheet().name());
                    }, 100)
                } else {
                    $("#emptyChartPlaceHolder").removeClass('d-none')
                }
            },
            selectSheet(e) {
                selectChartTab(e.sheet.name());
            }
        }).data("kendoSpreadsheet");
        $("#copyToEditorButton").on("click", function () {
            let activeSheetName = spreadsheet.activeSheet().name();
            if (charts[activeSheetName]) {
                addChartImageToEditor(activeSheetName, true).done(function () {
                    addSheetImageToEditor(activeSheetName, true);
                    editor.fire('change');
                });
            }
        });

        let chartMenuButton = $("#chartsMenuButton");
        let chartsMenuPopup = $("#chartsMenuPopup").kendoPopup({
            anchor: chartMenuButton
        }).data("kendoPopup");

        let chartsMenuListBox = $("#chartsMenuListBox").kendoListBox({
            dataSource: (() => {
                let ds = [];
                spreadsheetTemplates.map((e) => ds.push({
                    id: e.id,
                    description: e.description,
                    departmentId: e.department_id
                }));
                if (!(isITAdmin)) {
                    ds = ds.filter(value => value.departmentId + "" === userDepartmentId);
                }
                if (ds.length === 0) chartMenuButton.hide();
                return ds.sort((a, b) => a.description.localeCompare(b.description));
            })(),
            dataTextField: "description",
            dataValueField: "id",
            change() {
                chartsMenuPopup.close();
                $("#chartsTabstripHolder").removeClass("invisible");
                let id = this.dataItem(this.select()).id;
                this.clearSelection();
                let sheetTemplate = getSheetFromTemplate(id);
                if (sheetTemplate) {
                    if (spreadsheet.getSheetNames().includes(sheetTemplate.description)) {
                        let sheet = spreadsheet.sheetByName(sheetTemplate.description);
                        if (sheet) {
                            spreadsheet.activeSheet(sheet);
                            selectChartTab(sheetTemplate.description);
                        }
                    } else {
                        createChartFromSheet(appendSheetTemplate(sheetTemplate));
                    }
                }
            }
        }).data("kendoListBox");

        chartMenuButton.on("click", function () {
            chartsMenuPopup.toggle();
        });

        if (editor) editor.focus();

    });

    function loadDraft() {
        let json = $("#spreadsheetContent").val();
        if (json) {
            spreadsheet.fromJSON(JSON.parse(json));
            let sheets = spreadsheet.sheets();
            for (let i = 0; i < sheets.length; i++) {
                createChartFromSheet(sheets[i])
            }
            if (chartsTabStrip.items().length) {
                chartsTabStrip.select("li:first");
            }
        }
    }

    function fetchData(sheet, valueRange, fieldRange) {
        let values = valueRange.values();
        let columnLength = values[0].length;
        let fields = fieldRange.values().map((v) => v[0]);
        let data = [];
        for (let i = 0; i < columnLength; i++) {
            let dataItem = {};
            for (let m = 0; m < values.length; m++) {
                dataItem[fields[m]] = values[m][i];
            }
            data.push(dataItem);
        }
        return data;
    }

    function saveSheetTemplate(sheet, description) {
        return $.ajax({
            type: "POST",
            url: URL_ROOT + "/sheets/saveSpreadsheetTemplate/?description=" + description,
            data: JSON.stringify(sheet.toJSON()),
            contentType: "application/json",
            success: function (data) {
            },
            dataType: "json"
        });
    }

    function getSheetFromTemplate(id) {
        let sheetTemplate = spreadsheetTemplates.find((e) => e.id === id);
        if (sheetTemplate)
            return sheetTemplate;
        return false
    }

    function appendSheetTemplate(sheetTemplate) {
        let sheet;
        let sheets = spreadsheet.sheets().filter((s) => s.name().startsWith(sheetTemplate.description));
        let sheetJSON = JSON.parse(sheetTemplate.template);
        /*  if (sheets.length > 0) {
              sheetJSON.name = sheetJSON.name + " " + (parseInt(sheets.length) + 1);
          }*/
        /*if (firstSheetLoading) {
        This was necessary to replace Sheet1 which was loaded by default in the workbook
            firstSheetLoading = false;
            sheet = spreadsheet.activeSheet();
            sheet.fromJSON(sheetJSON);
        } else {
            sheet = spreadsheet.insertSheet({});
            sheet.fromJSON(sheetJSON);
        }*/
        sheet = spreadsheet.insertSheet({});
        sheet.fromJSON(sheetJSON);
        spreadsheet.activeSheet(sheet);
        return sheet;
    }

    /* $(document).mutationSummary("connect", {
         callback: function (response) {
             if (response[0].added.length > 0) {
                 adjustWindowHeight(response[0].added);
                 initOverlayScrollbars($(response[0].added).find("textarea"), {
                     resize: "both",
                     sizeAutoCapable: true,
                     paddingAbsolute: true,
                     scrollbars: {
                         clickScrolling: true
                     }
                 })
             }
             /!*if (response[1].added.length > 0) {
                 let chartTab = response[1].added.filter((e) => $(e).parents("#chartsTabStrip").length !== 0);
                 if (chartTab.length !== 0)
                     chartsTabStrip.activateTab($(chartTab));
             }*!/

             if (response[1].added.length > 0) {
                 response[1].added.forEach(function (e) {
                     if (e.id === 'k-editor-accessibility-summary')
                         initOverlayScrollbars(e, {
                             resize: "vertical",
                             sizeAutoCapable: true,
                             paddingAbsolute: true,
                             scrollbars: {
                                 clickScrolling: true
                             }
                         })
                 });
                 initOverlayScrollbars(response[2].added);
             }

             if (response[2].added.length > 0) {
                 let textarea = $(response[3].added).find('textarea');
                 textarea.attr('rows', 8);
                 $(response[2].added).find('.k-dialog-update').on('click', function (e) {
                     editor.body().innerHTML = textarea.val();
                     editor.update();
                 });
             }
         },
         queries: [
             {element: "[data-role=window]"},
             //{element: ".k-item[role=tab]"},
             {element: "textarea"},
             {element: '.k-viewhtml-dialog'}
         ]
     });
 */
    function adjustWindowHeight(w) {
        let overlayHeight = $(".k-overlay").height();
        let win = $(w);
        if (overlayHeight && win.height() > (overlayHeight * 0.7))
            win.height(0.7 * overlayHeight);
        win.getKendoWindow().center();
        initOverlayScrollbars(win);
    }

    function createChartFromSheet(sheet) {
        let categoryField = sheet.range(1, 0).value();
        if (categoryField === null) return;
        let data = [];
        let sheetName = sheet.name();
        let chart;
        chartsTabStrip.append([{
            text: sheetName,
            content: '<div id="' + sheetName + '" class="spreadsheet-chart" style="height: 100%; width: 100%"></div>'
        }]);
        let div = $("[id='" + sheetName + "']");
        let divParent = div.parent("[role=tabpanel]");
        chartTabs[sheetName] = divParent.attr("id");

        selectChartTab(sheetName);

        /** @type {kendo.dataviz.ui.ChartOptions}*/
        let kendoChartOptions = {
            legend: {
                visible: true,
                position: "bottom",
                item: {
                    cursor: "pointer",
                    visual: function (e) {
                        let layout;
                        let type = e.series.type;
                        let dashType = e.series.dashType;
                        let color = e.options.markers.background;
                        let labelColor = e.options.labels.color;
                        let label = e.series.name;

                        if (type === "line") {
                            return renderLegend(label, labelColor, color, 1.5, dashType)
                        } else if (type === "column") {
                            return renderLegend(label, labelColor, color, 10)
                        }


                        return e.createVisual();
                    }
                }
            },
            seriesDefaults: {
                type: "line",
                style: "smooth",
                labels: {
                    visible: false,
                    template: "#= kendo.toString(value, 'n') #"
                },
                tooltip: {
                    visible: true,
                    format: "{0:C}",
                    template: "#= series.name #: #= kendo.toString(value, 'n') #"
                }
            },
            dataBound: function (e) {
                // Sort categories (years) as grouping
                /*var axis = e.sender.options.categoryAxis;
                if (axis.categories) {
                    axis.categories.sort();
                }*/
            },
            transitions: false
        };
        if (sheetName === (CHART_RECOVERY_HEAD_GRADE)) {
            let valueRange = sheet.range("B2:M5");
            let fieldRange = sheet.range("A2:A5");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                legend: {
                    visible: true,
                    position: "bottom",
                    item: {
                        cursor: "pointer",
                        visual: function (e) {
                            let layout;
                            let type = e.series.type;
                            let dashType = e.series.dashType;
                            let color = e.options.markers.background;
                            let labelColor = e.options.labels.color;
                            let label = e.series.name;

                            if (type === "line") {
                                return renderLegend(label, labelColor, color, 1.5, dashType, {
                                    pathColor: "#873987",
                                    circleColor: "#9e480e"
                                })
                            } else if (type === "column") {
                                return renderLegend(label, labelColor, color, 10)
                            }

                            return e.createVisual();
                        }
                    }
                },
                title: {
                    text: "RECOVERY AND HEAD GRADE"
                },
                dataSource: {data: data},
                series: [
                    {
                        field: "['HEAD GRADE (g/t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "HEAD GRADE (g/t)",
                        color: "#00b0f0",
                        axis: "headGrade"
                    },
                    {
                        field: "['BUDGET HEAD GRADE (g/t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "BUDGET HEAD GRADE (g/t)",
                        color: "#ffc000",
                    },
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['RECOVERY (%)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        name: "RECOVERY (%)",
                        color: "#873987",
                        markers: {
                            background: "#9e480e",
                            border: {color: "#9e480e"},
                            visible: true
                        },
                        axis: "recovery"
                    },
                ],
                valueAxis: [
                    {
                        name: "headGrade",
                        title: {
                            text: "Head Grade (g/t)"
                        }
                    },
                    {
                        name: "recovery",
                        title: {
                            text: "Recovery (%)"
                        }
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName === (CHART_GOLD_RECOVERED_ARL_AND_TOLL)) {
            let valueRange = sheet.range("B2:C5");
            let fieldRange = sheet.range("A2:A5");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_GOLD_RECOVERED_ARL_AND_TOLL
                },
                dataSource: {data: data},
                series: [
                    {
                        field: "['ARL']",
                        categoryField: categoryField,
                        type: "column",
                        name: "ARL",
                        color: "#1d6f86",
                        stack: true
                    },
                    {
                        field: "['TOLL']",
                        categoryField: categoryField,
                        type: "column",
                        name: "TOLL",
                        color: "#f08527",
                    },
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['MONTHLY TOTAL']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        name: "MONTHLY TOTAL",
                        color: "#f37f7f",
                        markers: {
                            visible: false
                        }
                    }
                ],
                categoryAxis: {
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName === (CHART_GOLD_PRODUCTION)) {
            let valueRange = sheet.range("B2:M4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                legend: {
                    visible: true,
                    position: "bottom",
                    item: {
                        cursor: "pointer",
                        visual: function (e) {
                            let layout;
                            let type = e.series.type;
                            let dashType = e.series.dashType;
                            let color = e.options.markers.background;
                            let labelColor = e.options.labels.color;
                            let label = e.series.name;

                            if (type === "line") {
                                return renderLegend(label, labelColor, color, 1.5, dashType, {
                                    pathColor: seriesColor.budgetOunces,
                                    circleColor: seriesColor.budgetOunces
                                })
                            } else if (type === "column") {
                                return renderLegend(label, labelColor, color, 10)
                            }

                            return e.createVisual();
                        }
                    }
                },
                title: {
                    text: CHART_GOLD_PRODUCTION
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['ACTUAL GOLD PRODUCED (Oz)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "ACTUAL GOLD PRODUCED (Oz)",
                        color: seriesColor.goldProduced
                    },
                    {
                        field: "['BUDGET OUNCES']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        name: "BUDGET OUNCES",
                        color: seriesColor.budgetOunces,
                        markers: {
                            visible: true,
                            background: seriesColor.budgetOunces
                        }
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    },
                    labels: {
                        font: "10px sans-serif"
                    }
                },
                valueAxis: [
                    {
                        name: "goldProduced",
                        title: {
                            text: "Gold Produced (Oz)",
                            font: "10px sans-serif"
                        },
                        labels: {
                            format: "{0:n}"
                        }
                    }
                ]
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === CHART_TONS_MILLED_AND_GOLD_PRODUCED) {
            let valueRange = sheet.range("B2:M5");
            let fieldRange = sheet.range("A2:A5");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                legend: {
                    visible: true,
                    position: "bottom",
                    item: {
                        cursor: "pointer",
                        visual: function (e) {
                            let layout;
                            let type = e.series.type;
                            let dashType = e.series.dashType;
                            let color = e.options.markers.background;
                            let labelColor = e.options.labels.color;
                            let label = e.series.name;

                            if (type === "line") {
                                return renderLegend(label, labelColor, color, 1.5, dashType, {
                                    pathColor: seriesColor.actualGoldProduced,
                                    circleColor: seriesColor.actualGoldProduced
                                })
                            } else if (type === "column") {
                                return renderLegend(label, labelColor, color, 10)
                            }

                            return e.createVisual();
                        }
                    }
                },
                title: {
                    text: CHART_TONS_MILLED_AND_GOLD_PRODUCED
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['TONNES MILLED (t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "TONNES MILLED (t)",
                        color: seriesColor.tonnesMilled,
                        axis: "tonnes"
                    },
                    {
                        field: "['BUDGET TONNES MILLED (t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "BUDGET TONNES MILLED (t)",
                        color: seriesColor.budgetTonnesMilled,
                        axis: "tonnes"
                    },
                    {
                        field: "['ACTUAL GOLD PRODUCED (oz)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        name: "ACTUAL GOLD PRODUCED (oz)",
                        color: seriesColor.actualGoldProduced,
                        markers: {
                            visible: true,
                            background: seriesColor.actualGoldProduced
                        },
                        axis: "goldProduced"
                    }
                ],
                valueAxis: [
                    {
                        line: {visible: false},
                        labels: {
                            visible: false
                        }
                    },
                    {
                        name: "tonnes",
                        title: {
                            text: "Tonnes Milled (t)",
                            font: "0.5em sans-serif"
                        },
                        labels: {
                            font: "0.5em sans-serif",
                            format: "{0:n}"
                        },
                        narrowRange: true
                        // majorUnit: 20000
                    },
                    {
                        name: "goldProduced",
                        title: {
                            text: "Gold Produced (oz)",
                            font: "0.5em sans-serif",
                        },
                        labels: {
                            font: "0.5em sans-serif",
                            format: "{0:n}"
                        },
                        narrowRange: true
                        //majorUnit: 2000
                    },
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    },
                    labels: {
                        font: "0.5em sans-serif"
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName === (CHART_GOLD_PRODUCED_BUDGET_OUNCES)) {
            let valueRange = sheet.range("B2:C4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                legend: {
                    visible: true,
                    position: "bottom",
                    item: {
                        cursor: "pointer",
                        visual: function (e) {
                            let layout;
                            let type = e.series.type;
                            let dashType = e.series.dashType;
                            let color = e.options.markers.background;
                            let labelColor = e.options.labels.color;
                            let label = e.series.name;

                            if (type === "line") {
                                return renderLegend(label, labelColor, color, 1.5, dashType, {
                                    pathColor: "#873987",
                                    circleColor: "#9e480e"
                                })
                            } else if (type === "column") {
                                return renderLegend(label, labelColor, color, 10)
                            }

                            return e.createVisual();
                        }
                    }
                },
                title: {
                    text: CHART_GOLD_PRODUCED_BUDGET_OUNCES
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['GOLD PRODUCED']",
                        categoryField: categoryField,
                        type: "column",
                        name: "GOLD PRODUCED",
                        color: seriesColor.goldProduced
                    },
                    {
                        field: "['BUDGET OUNCES']",
                        categoryField: categoryField,
                        type: "line",
                        name: "BUDGET OUNCES",
                        color: seriesColor.budgetOunces,
                        markers: {
                            visible: true,
                            background: seriesColor.budgetOunces
                        }
                    }
                ]
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === (CHART_PLANNED_VRS_ACTUAL_METRES)) {
            let valueRange = sheet.range("B2:C4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_PLANNED_VRS_ACTUAL_METRES
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['PLANNED METRES']",
                        categoryField: categoryField,
                        type: "column",
                        name: "PLANNED METRES",
                        color: seriesColor.plannedMetres
                    },
                    {
                        field: "['ACTUAL METRES']",
                        categoryField: categoryField,
                        type: "column",
                        name: "ACTUAL METRES",
                        color: seriesColor.actualMetres
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === (CHART_CLOSING_STOCKPILE_BALANCE)) {
            let valueRange = sheet.range("B2:C6");
            let fieldRange = sheet.range("A2:A6");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_CLOSING_STOCKPILE_BALANCE
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['ROM (TONNES)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "ROM (TONNES)",
                        color: seriesColor.romGrade,
                        axis: "tonnes"
                    },
                    {
                        field: "['LOW (TONNES)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "LOW (TONNES)",
                        color: seriesColor.lowGrade,
                        axis: "tonnes"
                    },
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['ROM (GRADE)']",
                        categoryField: categoryField,
                        type: "line",
                        name: "ROM (GRADE)",
                        color: seriesColor.romGrade,
                        markers: {
                            visible: false
                        },
                        labels: {
                            visible: true
                        },
                        axis: "grade"
                    },
                    {
                        field: "['LOW (GRADE)']",
                        categoryField: categoryField,
                        type: "line",
                        name: "LOW (GRADE)",
                        color: seriesColor.lowGrade,
                        markers: {
                            visible: false
                        },
                        labels: {
                            visible: true
                        },
                        axis: "grade"
                    }
                ],
                valueAxis: [
                    {
                        name: "tonnes",
                        title: {
                            text: "Tonnes [t]"
                        }
                    },
                    {
                        name: "grade",
                        title: {
                            text: "Grade [g/t]"
                        },
                        min: 0,
                        max: 2
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === (CHART_TOLL_DELIVERY)) {
            let valueRange = sheet.range("B2:C8");
            let fieldRange = sheet.range("A2:A8");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_TOLL_DELIVERY,
                    align: "center"
                },
                dataSource: {data: data},
                series: [
                    {
                        field: "['BUDGET TONNAGE (t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "BUDGET TONNAGE (t)",
                        color: seriesColor.budgetTonnage,
                        axis: "tonnes",
                        stack: "Tonnage"
                    },
                    {
                        field: "['DELIVERY TONNAGE (t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "DELIVERY TONNAGE (t)",
                        color: seriesColor.deliveryTonnage,
                        axis: "tonnes",
                        stack: "Tonnage"
                    },
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['MILLED TONNAGE (t)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "MILLED TONNAGE (t)",
                        color: seriesColor.milledTonnage,
                        axis: "tonnes",
                        stack: "Tonnage"
                    },
                    {
                        field: "['DELIVERY GRADE (g/t)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        dashType: "solid",
                        name: "DELIVERY GRADE (g/t)",
                        color: seriesColor.deliveryTonnage,
                        markers: {
                            visible: false
                        },
                        axis: "grade"
                    },
                    {
                        field: "['BUDGET GRADE (g/t)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        name: "BUDGET GRADE (g/t)",
                        color: seriesColor.budgetTonnage,
                        markers: {
                            visible: false
                        },
                        axis: "grade"
                    },
                    {
                        field: "['MILLED GRADE (g/t)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        dashType: "solid",
                        name: "MILLED GRADE (g/t)",
                        color: seriesColor.milledTonnage,
                        markers: {
                            visible: false
                        },
                        axis: "grade"
                    }
                ],
                valueAxis: [
                    {
                        name: "tonnes",
                        title: {
                            text: "Tonnes [t]"
                        }
                    },
                    {
                        name: "grade",
                        title: {
                            text: "Grade [g/t]"
                        }
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === (CHART_MINE_SITE_EMPLOYEE_TURNOVER_2)) {
            sheet.range("B3:M5").format('#,###');
            sheet.range("B6:M6").format('#.0000');
            let valueRange = sheet.range("B2:C6");
            let fieldRange = sheet.range("A2:M6");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_MINE_SITE_EMPLOYEE_TURNOVER,
                    align: "center"
                },
                dataSource: {data: data},
                series: [
                    {
                        field: "['RESIGNATION(S)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "RESIGNATION(S)",
                        color: "#ed7d31",
                        tooltip: {
                            visible: true,
                            format: "{0:n}",
                            template: "#= series.name #: #= value #"
                        }
                    },
                    {
                        field: "['TERMINATION(S)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "TERMINATION(S)",
                        color: "#bfbfbf",
                        axis: "termination",
                        tooltip: {
                            visible: true,
                            format: "{0:n}",
                            template: "#= series.name #: #= value #"
                        }
                    },
                    {
                        field: "['TOTAL TURNOVER (%)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        color: "#ffc000",
                        dashType: "solid",
                        name: "TOTAL TURNOVER (%)",
                        markers: {
                            visible: false
                        },
                        axis: "turnover",
                        tooltip: {
                            visible: true,
                            format: "{0:p}",
                            template: "#= series.name #: #= value #"
                        }
                    }
                ],
                valueAxis: [
                    {
                        name: "termination",
                        title: {
                            text: ""
                        }
                    },
                    {
                        name: "turnover",
                        title: {
                            text: ""
                        },
                        labels: {
                            format: "{0:p}"
                        }
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName === (CHART_MINE_SITE_EMPLOYEE_TURNOVER)) {
            sheet.range("B3:M5").format('#,###');
            let valueRange = sheet.range("B2:C6");
            let fieldRange = sheet.range("A2:G6");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_MINE_SITE_EMPLOYEE_TURNOVER,
                    align: "center"
                },
                dataSource: {data: data},
                series: [
                    {
                        field: "['RESIGNATION(S)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "RESIGNATION(S)",
                        color: "#ed7d31",
                        tooltip: {
                            visible: true,
                            format: "{0:n}",
                            template: "#= series.name #: #= value #"
                        }
                    },
                    {
                        field: "['TERMINATION(S)']",
                        categoryField: categoryField,
                        type: "column",
                        name: "TERMINATION(S)",
                        color: "#bfbfbf",
                        axis: "termination",
                        tooltip: {
                            visible: true,
                            format: "{0:n}",
                            template: "#= series.name #: #= value #"
                        }
                    },
                    {
                        field: "['TOTAL TURNOVER (%)']",
                        categoryField: categoryField,
                        type: "line",
                        style: "normal",
                        color: "#ffc000",
                        dashType: "solid",
                        name: "TOTAL TURNOVER (%)",
                        markers: {
                            visible: false
                        },
                        axis: "turnover",
                        tooltip: {
                            visible: true,
                            format: "{0:p}",
                            template: "#= series.name #: #= value #"
                        }
                    }
                ],
                valueAxis: [
                    {
                        name: "termination",
                        title: {
                            text: ""
                        },
                        //majorUnit: 2.0,
                        //minorUnit: 0.5,
                    },
                    {
                        name: "turnover",
                        title: {
                            text: ""
                        },
                        labels: {
                            format: "{0:p}"
                            //template:  kendo.template("#= kendo.toString(value * (1/100), 'p') #")
                        },
                        //majorUnit: 1.5,
                        //minorUnit: 0.5,
                    }
                ],
                categoryAxis: {
                    axisCrossingValues: [0, 13],
                    majorGridLines: {
                        visible: false
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        }
    }

    function renderSolidDot(options = {}) {
        let draw = kendo.drawing;
        let geom = kendo.geometry;
        let path = new draw.Path({
            stroke: {
                color: options.pathColor ? options.pathColor : "#9999b6",
                width: 3,
                lineCap: "round"
            },
            fill: {
                color: options.pathColor ? options.pathColor : "#33ccff"
            },
            cursor: "pointer"
        });
        let dot = new geom.Circle([40, 200], 5);
        let circle = new draw.Circle(dot, {
            stroke: {
                color: options.circleColor ? options.circleColor : "#33ccff",
            },
            fill: {
                color: options.circleColor ? options.circleColor : "#33ccff",
            },
            cursor: "pointer"
        });
        // The following commands are interchangeable
        path.moveTo(20, 200);
        path.lineTo(60, 200);
        //path.lineTo([200, 200]);
        //path.lineTo(new geom.Point(200, 200));
        let group = new draw.Group();
        group.append(path, circle);

        return group;
    }

    function renderLegend(label, labelColor, color, width = 1.5, dashType = "solid", solidDot = null) {
        let draw = kendo.drawing;
        let geom = kendo.geometry;
        let rect = new kendo.geometry.Rect([0, 0], [500, 300]);
        let layout = new kendo.drawing.Layout(rect, {
            spacing: 5,
            alignItems: "center",
            wrap: false
        });

        let path = new draw.Path({
            cursor: "pointer",
            stroke: {
                color: color,
                width: width,
                dashType: dashType
            }
        });

        path.moveTo(0, 0).lineTo(30, 0);

        let text = new draw.Text(label, new geom.Point(0, 0), {
            font: "12px Arial;white-space:pre",
            cursor: "pointer",
            fill: {
                color: labelColor
            }
        });

        if (solidDot) {
            let group = renderSolidDot(solidDot);
            layout.append(group, text);
        } else {
            layout.append(path, text);
        }

        //let space = new draw.Text("&nbsp;", [0, 0], {font: "0.2px"});

        layout.reflow();


        return layout;
    }

    function bindChart(chart, sheet, valueRange, fieldRange) {
        // Change will fire when the sheet data changes
        // http://docs.telerik.com/kendo-ui/api/javascript/spreadsheet/sheet/events/change
        sheet.bind("change", function (e) {
            if (e.recalc) {
                update();
            }
        });

        // Populate chart immediately
        update();

        function update() {
            chart.dataSource.data(fetchData(sheet, valueRange, fieldRange));
            setTimeout(function () {
                if ($(editor.body()).find("img[data-id='chart_img_" + sheet.name() + "']").length) {
                    addChartImageToEditor(sheet.name());
                }
                if ($(editor.body()).find("img[data-id='sheet_img_" + sheet.name() + "']").length) {
                    addSheetImageToEditor(sheet.name())
                }
            }, 1000)

        }
    }

    function addSheetImageToEditor(name, insert = false) {
        let draw = kendo.drawing;
        let sheet = spreadsheet.sheetByName(name);
        let promises = [];
        sheet.draw({}, group => {
            if (group.children.length > 0) {
                for (var i = 0; i < group.children.length; i++) {
                    promises.push(draw.exportImage(group.children[i], {}));
                }
                for (let i = 0; i < promises.length; i++) {
                    if (insert) {
                        promises[i].done(data => {
                            var startRange = editor.getSelection(); //Cursor position
                            var parent = startRange.getStartElement(); //The parent <p> or <span> of the cursor
                            var node = CKEDITOR.dom.element.createFromHtml("<img class='my-1' src='" + data + "' data-id='sheet_img_" + sheet.name() + "' style='display:block;margin-left:auto;margin-right:auto;max-width:100%; height: auto;'/>");
                            parent.insertBeforeMe(node); //Places new node before the specified node
                            editor.widgets.initOn(node, 'image');
                        });
                    } else {
                        let imgs = editor.body().querySelectorAll("img[data-id='sheet_img_" + sheet.name() + "']");
                        if (imgs) {
                            promises[i].done(data => $(imgs).attr("src", data));
                            promises[i].done(data => $(imgs).attr("data-cke-saved-src", data));
                        }
                    }
                }
            }
        })
    }

    function addChartImageToEditor(chartName, insert = false) {
        let chart = charts[chartName];
        return chart.exportImage().done(data => {
            if (insert) {
                var startRange = editor.getSelection(); //Cursor position
                var parent = startRange.getStartElement(); //The parent <p> or <span> of the cursor
                var node = CKEDITOR.dom.element.createFromHtml("<img class='my-1' src='" + data + "' data-id='chart_img_" + chartName + "' style='display:block;margin-left:auto;margin-right:auto;max-width:100%; height: auto;' />");
                parent.insertBeforeMe(node); //Places new node before the specified node
                editor.widgets.initOn(node, 'image');
            } else {
                let imgs = editor.body().querySelectorAll("img[data-id='chart_img_" + chartName + "']");
                $(imgs).attr("src", data);
                $(imgs).attr("data-cke-saved-src", data);

            }
        })
    }

    function exportSheetToPDF(index, range) {
        let draw = kendo.drawing;
        let sheet = spreadsheet.sheetByIndex(index);
        let newGroup = new kendo.drawing.Group();
        sheet.draw(sheet.range(range), {}, group => {
            if (group.children.length > 0) {
                newGroup.append(...group.children);
            }
            draw.exportPDF(newGroup, {paperSize: 'A3'}).done(data => kendo.saveAs({
                dataURI: data,
                fileName: sheet.name()
            }))
        })
    }

    function selectChartTab(tabName) {
        let tab = $(chartsTabStrip.items()).filter((index, element) => $(element).text() === tabName);
        if (tab.length > 0)
            chartsTabStrip.select(tab[0]);
    }

    kendo.ui.Spreadsheet.prototype.getSheetNames = function () {
        return this.sheets().map(s => s.name());
    };

    function updateChartTabs() {
        chartTabs = [];
        Array.prototype.map.call(chartsTabStrip.items(), item => chartTabs[item.textContent] = $(item).attr("aria-controls"));
        return chartTabs;
    }

    function saveDraft(e) {
        let postDfr = jQuery.Deferred();
        let postDfrPromise = postDfr.promise();
        let targetMonth = $("#targetMonth").val();
        let targetYear = $("#targetYear").val();
        progress('.content-wrapper', true);
        postDfrPromise.done(function () {
            let draftId = $("#draftId");
            let title = $("#draftTitleInput").val();
            $.post(URL_ROOT + "/pages/save-draft/" + targetMonth + "/" + targetYear + "/" + tablePrefix, {
                title: title,
                draft_id: draftId.val(),
                content: editor.value(),
                spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
            }, null, "json").done(function (response, textStatus, jQueryXHR) {
                progress('.content-wrapper');
                if (response['session_expired']) {
                    let href = window.location.href.insert(URL_ROOT.length, '/users/login');
                    kendoAlert('Session Expired!', `Your session has expired! Please login and try saving your draft again. <br><a href="${href}" ><b><u>Click here to login.</u></b></a>`, 'danger');
                    return;
                }
                if (response.success) {
                    let kAlert = kendoAlert('Save Draft', 'Draft saved successfully!');
                    if (response.draft_id)
                        $('#draftId').val(response.draft_id);
                    setTimeout(() => kAlert.close(), 1500);
                } else {
                    let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                    setTimeout(() => kAlert.close(), 1500);
                }
            });
        });
        postDfr.resolve();
    }

    function saveReportPart() {
        let reportPartId = $("#reportPartId").val();
        let description = $("#reportPartDescription").val();
        let dfd = $.Deferred();
        let promise = dfd.promise();
        promise.done((description) => {
            progress('.content-wrapper', true);
            $.post(`${URL_ROOT}/pages/save-report-part/${tablePrefix}/${reportPartId}`, {
                content: editor.value(),
                description: description
            }, null, "json").done(d => {
                progress('.content-wrapper');
                let alert = kendoAlert('Success!', description + ' saved successfully!');
                setTimeout(() => alert.close(), 1500);
            });
        });
        if (!description) {
            kendo.prompt('Enter the description', '').done(description => {
                dfd.resolve(description);
            })
        } else {
            dfd.resolve(description)
        }
    }

    function savePreloadedDraft(e) {
        let postDfr = jQuery.Deferred();
        let postDfrPromise = postDfr.promise();
        postDfrPromise.done(function () {
            spreadsheet.saveJSON().then(function (data) {
                $("#spreadsheetContent").val(JSON.stringify(data, null, 2));
                $.post({
                    url: "<?php echo URL_ROOT . '/pages/save-preloaded-draft/' . ($table_prefix ?? 'nmr'); ?>",
                    data: $("#editorForm").serialize(),
                    dataType: 'json'
                }).done(function (response, textStatus, jQueryXHR) {
                    if (response.success) {
                        let kAlert = kendoAlert('Save Preloaded Draft', 'Draft saved successfully!');
                        if (response.draft_id)
                            $('#draftId').val(response.draft_id);
                        setTimeout(() => kAlert.close(), 1500);
                    } else {
                        let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                        setTimeout(() => kAlert.close(), 1500);
                    }
                });
            });
        });
        postDfr.resolve();
    }

    function saveFinalReport() {
        let targetMonth = $("#targetMonth").val();
        let targetYear = $("#targetYear").val();
        let html_content = editor.value();
        previewEditor.value(html_content);
        progress('.content-wrapper', true);
        kendo.drawing.drawDOM($(previewEditor.body), {
            paperSize: 'A4',
            margin: tablePrefix === 'nmr_fr' ? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
            multipage: true,
            scale: 0.7,
            forcePageBreak: ".page-break"
        }).then(function (group) {
            // Render the result as a PDF file
            return kendo.drawing.exportPDF(group, {});
        }).done(dataURI => {
            $.post(`${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`, {
                html_content: editor.value(),
                data_uri: dataURI
            }, (data) => {
                progress('.content-wrapper');
                if (!data.success && data['session_expired']) {
                    let href = window.location.href.insert(URL_ROOT.length, '/users/login');
                    kendoAlert('Session Expired!', `Your session has expired! Please login and try saving the report again. <br><a href="${href}" ><b><u>Click here to login.</u></b></a>`, 'danger');
                    return;
                }
                let alert = kendoAlert('Save Report', `${targetMonth} ${targetYear} Report saved successfully!`);
                setTimeout(() => alert.close(), 1500);
            }, "json")
        });

    }

    function saveDraftAsPreloaded(e) {
        let postDfr = jQuery.Deferred();
        let postDfrPromise = postDfr.promise();
        showWindow('', 'Select Department', '#selectDepartmentConfirmationTemplate').done(function (confirmed) {
            let departmentName = $("#departmentName").val();
            if (confirmed) {
                postDfrPromise.done(function (title) {
                    spreadsheet.saveJSON().then(function (data) {
                        $("#spreadsheetContent").val(JSON.stringify(data, null, 2));
                        $.post({
                            url: URL_ROOT + "/pages/save-draft-as-preloaded/" + tablePrefix,
                            data: $("#editorForm").serialize(),
                            dataType: 'json'
                        }).done(function (response, textStatus, jQueryXHR) {
                            if (response.success) {
                                let kAlert = kendoAlert('Save Draft As Preloaded', 'Draft saved successfully!');
                                setTimeout(() => kAlert.close(), 1500);
                            } else {
                                let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                            }
                        });
                    });
                });
                let draftTitleInput = $("#draftTitleInput");
                kendo.prompt("Enter a title for your draft.", departmentName).done(function (title) {
                    $("#draftTitleInput, #title").removeClass('no-title').val(title);
                    postDfr.resolve(title);
                });
                /*if (draftTitleInput.hasClass('no-title')) {
                    kendo.prompt("Enter a title for your draft.", departmentName).done(function (title) {
                        $("#draftTitleInput, #title").removeClass('no-title').val(title);
                        postDfr.resolve(title);
                    });
                } else {
                    let title = draftTitleInput.val();
                    $("#title").val(title);
                    postDfr.resolve(title);
                }*/
            }
        });
    }

    function selectDepartment_onChange(e) {
        $("#departmentName").val(this.value())
    }

    function saveSpreadsheetTemplate(e) {
        let activeSheet = spreadsheet.activeSheet();
        let description = activeSheet.name();
        showWindow('', 'Save Spreadsheet as Template', '#selectDepartmentConfirmationTemplate_2', () => $("#description").val(description))
            .done(function () {
                let departmentName = $("#departmentName").val();
                $.post({
                    url: URL_ROOT + '/pages/save-spreadsheet-template',
                    data: JSON.stringify({
                        template: activeSheet.toJSON(),
                        department: departmentName,
                        description: description
                    }, null, 2),
                    contentType: "application/json",
                    dataType: "json"
                }).done(function () {
                    let alert = kendoAlert("Spreadsheet Template Saved", 'Spreadsheet template saved successfully!');
                    setTimeout(() => alert.close(), 1500);
                });
            });
    }

    function onEditSubmittedReport(e) {
        let reportSubmissionsId = $("#reportSubmissionsId").val();
        let targetMonth = $("#targetMonth").val();
        let targetYear = $("#targetYear").val();
        progress('.content-wrapper', true);
        let submit = () => {
            let dfd = $.Deferred();
            let post = $.post(URL_ROOT + "/pages/update-submitted-report/" + reportSubmissionsId + "/" + tablePrefix, {
                content: editor.value(),
                spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
            }, null, "json");
            dfd.resolve(post);
            return dfd.promise();
        };

        submit().done(post => post.done(data => {
            if (!data.success && data['session_expired']) {
                let href = window.location.href.insert(URL_ROOT.length, '/users/login');
                kendoAlert('Session Expired!', `Your session has expired! Please login and try saving again. <br><a href="${href}" ><b><u>Click here to login.</u></b></a>`, 'danger');
                return;
            }
            let url = `${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`;
            progress('.content-wrapper');
            let alert = kendoAlert("Report Saved!", "Report saved successfully.");
            setTimeout(() => alert.close(), 1500);
            // Don't Modify Final Report
            /*$.get(url).done(html => {
                previewEditor.value(html);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'A4',
                    margin: tablePrefix === 'nmr_fr' ? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                    multipage: true,
                    forcePageBreak: '.page-break',
                    scale: 0.7,
                }).then(function (group) {
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (dataURI) {
                    progress('.content-wrapper');
                    $.post(url, {data_uri: dataURI, html_content: html}, null, "json").done(() => {
                        let alert = kendoAlert("Report Saved!", "Report saved successfully.");
                        setTimeout(() => alert.close(), 1500);
                    });
                });
            });*/
        }));
    }

    function submitReport(e) {
        let $draftId = $("#draftId");
        let draftId = $draftId.val();
        let title = $("#draftTitleInput").val();
        let targetMonth = $("#targetMonth").val();
        let targetYear = $("#targetYear").val();
        progress('.content-wrapper', true);
        // Save draft explicitly
        $.post(URL_ROOT + "/pages/save-draft/" + targetMonth + "/" + targetYear + "/" + tablePrefix, {
            title: title,
            draft_id: draftId,
            content: editor.value(),
            spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
        }, null, "json").always(function (data) {
            progress('.content-wrapper');
            if (!data.success && data['session_expired']) {
                let href = window.location.href.insert(URL_ROOT.length, '/users/login');
                kendoAlert('Session Expired!', `Your session has expired! Please login and try submission again. <br><a href="${href}" ><b><u>Click here to login.</u></b></a>`, 'danger');
                return;
            }
            if ($(e.target).hasClass('update-submitted-report-btn')) {
                showWindow('This report has already been submitted. Are you sure you want to update it?')
                    .done(e => {
                        progress('.content-wrapper', true);
                        $.post(URL_ROOT + "/pages/submit-report/" + tablePrefix + "/" + targetMonth + "/" + targetYear, {
                            title: title,
                            draft_id: draftId,
                            content: editor.value(),
                            spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
                        }, null, "json")
                            .done(data => {
                                progress('.content-wrapper');
                                $draftId.val(data.draftId);
                                let alert = kendoAlert("Report Updated!", "Report updated successfully.");
                                setTimeout(() => alert.close(), 1500);
                            });
                    });
            } else if ($(e.target).hasClass("submit-report-btn")) {
                showWindow('This report will be submitted. Are you sure you want to proceed?').done(function () {
                    progress('.content-wrapper', true);
                    $.post(URL_ROOT + "/pages/submit-report/" + tablePrefix + "/" + targetMonth + "/" + targetYear, {
                        title: title,
                        draft_id: draftId,
                        content: editor.value(),
                        spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
                    }, null, "json").done(data => {
                        progress('.content-wrapper');
                        $draftId.val(data.draftId);
                        let alert = kendoAlert("Report Submitted!", "Report submitted successfully.");
                        setTimeout(() => alert.close(), 1500);
                        editorActionToolbar.hide(".submit-report-btn");
                        editorActionToolbar.show(".update-submitted-report-btn");
                    });
                });
            }
        });
    }

    function getArrayData() {
        $.get(URL_ROOT + "/pages/get-array-data").done(function (data, successTextStatus, jQueryXHR) {
            decodeEntities(data);
        })
    }

    function decodeEntities(encodedString) {

        var textArea = document.createElement('textarea');

        textArea.innerHTML = encodedString;

        return textArea.value;

    }

    function getEditor() {
        return CKEDITOR.instances.editor;
    }

    function toWord() {
        $.post({
            url: URL_ROOT + '/pages/toWord',
            data: {content: editor.value()}
        }).done(function () {
            console.log('success');
        });
    }

    function convertImagesToBase64(contentDocument) {
        //contentDocument = tinymce.get('content').getDoc();
        // tailored for ckeditor
        progress(".content-wrapper", true);
        var regularImages = contentDocument.querySelectorAll("img.cke_widget_element");
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        [].forEach.call(regularImages, function (imgElement) {
            // preparing canvas for drawing
            canvas.width = imgElement.width;
            canvas.height = imgElement.height;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            //imgElement.crossOrigin = "Anonymous";
            ctx.drawImage(imgElement, 0, 0);
            // by default toDataURL() produces png image, but you can also export to jpeg
            // checkout function's documentation for more details
            var dataURL = canvas.toDataURL();
            //imgElement.width = "80%"
            imgElement.setAttribute('src', dataURL);
            imgElement.setAttribute('data-cke-saved-src', dataURL);
        })
        progress(".content-wrapper");
        canvas.remove();
    }

    function saveAsDocx(editor, orientation = "portrait") {
        documentElement = editor.document.$? editor.document.$.documentElement : editor.document.documentElement;
        docElemClone = documentElement.cloneNode(true);
        //contentDocument = contentDocument? contentDocument : '<!DOCTYPE html>' + editor.document.$.documentElement.outerHTML
        //convertImagesToBase64(documentElement)
        contentDocument = '<!DOCTYPE html>' + documentElement.outerHTML
        var converted = htmlDocx.asBlob(contentDocument, {
            orientation: orientation,
            /*margins: {
                left: 720,
                right: 720
            }*/
        });
        kendo.saveAs({
            dataURI: converted,
            fileName: "Document.docx"
        })
        //delete docElemClone;
        // saveAs(converted, 'Document.docx');
    }

    function styleFilter (element) {
        let style = element.attributes.style;
        if (!style)
            return;
        return style.replace(/font-size:(s)*small/gi, "font-size:12pt");
    }

</script>
</body>
</html>
