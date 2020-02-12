<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
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
                                <div style="width: 100%">
                                    <form id="editorForm">
                                    <textarea name="content" id="content" cols="30" rows="10"
                                              style="height: 500px;"><?php echo $content ?? ''; ?></textarea>
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
            <div class="box collapsed border-warning <?php echo isset($is_submission_closed) && $is_submission_closed ? 'd-none' : ''; ?>">
                <div class="box-header">
                    <h5 class="box-title text-bold"><span class="fa fa-chart-bar text-warning"></span> Charts</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
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
                    </div>
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
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>
<input type="hidden" id="spreadsheetTemplates" value='<?php /** @var string $spreadsheet_templates */
echo $spreadsheet_templates; ?>'>
<style>
    .k-editor {
        width: 842px;
    }
</style>
<?php if (!isITAdmin($current_user->user_id)): ?>
    <style>
        [title='View HTML'] {
            display: none !important;
        }
    </style>
<?php endif; ?>
<style>
    #previewEditorParent .k-editor {
        visibility: hidden;
        z-index: -1;
    }

    .cke_reset_all {
        z-index: 9999999 !important;
    }

    .cke_maximized {
        z-index: 99999995 !important;
    }

</style>
<script>
    const HEADER_BACKGROUND_COLOR = "#9c27b0";
    const HEADER_BORDER = {color: HEADER_BACKGROUND_COLOR, size: 2};
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
    /** @type {CKEDITOR.editor}*/
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
    let isSubmissionClosed = Boolean(<?php echo $is_submission_closed ?? ''; ?>);
    let tablePrefix = "<?php echo $table_prefix ?? 'nmr'; ?>";
    let clearedContents = "";
    let targetMonthYearsSubmissionStatus = JSON.parse('<?php echo json_encode(getTargetMonthYearsSubmissionStatus($table_prefix ?? 'nmr')) ?>');
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
    let userDepartmentId = "<?php echo $current_user->department_id; ?>";
    let previewEditor;

    $(function () {
        CKEDITOR.editor.prototype.value = function () {
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

        CKEDITOR.config.extraPlugins = 'image2, toc, tabletoolstoolbar, tableresize, tableresizerowandcolumn, autogrow, preview';
        CKEDITOR.config.removePlugins = 'save, forms, preview, sourcearea, language, styles, iframe, specialchar, flash, about, bidi, newpage, stylescombo, div';

        CKEDITOR.replace('content', {
            title: "Nzema Monthly Report",
            uploadUrl: '/nmr/ckfinder/?command=QuickUpload&type=Files&responseType=json',
            filebrowserBrowseUrl: URL_ROOT + '/ckfinder/browse/?type=Files',
            filebrowserImageBrowseUrl: URL_ROOT + '/ckfinder/browse?type=Images',
            filebrowserUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Images'
        });

        editor = CKEDITOR.instances.content;

        previewEditor = $("<div id='previewEditorParent'><textarea id='previewEditor' style='width: 100%;'/> </div>").appendTo("body");
        previewEditor = $("#previewEditor").kendoEditor({
            tools: [],
            stylesheets: [
                "<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css",
                "<?php echo URL_ROOT; ?>/public/custom-assets/css/editor.css",

            ]
        }).data("kendoEditor");
        spreadsheetTemplates = JSON.parse($("#spreadsheetTemplates").val());

        $(window).on("resize", function () {
            kendo.resize($("#chartsTabstripHolder"));
            spreadsheet.resize(true);
        });

        let previewContent = function (contentUrl, datafilter = false, fileName = "Document") {
            let showPdfViewer = () => {
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "1.3cm",
                    multipage: true,
                    forcePageBreak: '.page-break'
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (data) {
                    pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                    setTimeout(() => pdfViewer.activatePage(1), 500)
                });
            };
            let dataFilter = datafilter ? datafilter : (data, type) => JSON.parse(data).content;
            if (!pdfViewer)
                pdfViewer = $("#previewContent").kendoPDFViewer({
                    messages: {
                        defaultFileName: fileName
                    },
                    pdfjsProcessing: {
                        file: ""
                    },
                    width: "100%",
                    height: 550,
                    scale: 1,
                    toolbar: {
                        items: [
                            "pager", "zoom", "toggleSelection", "search", "download", "print", {
                                id: "cancel",
                                type: "button",
                                text: "Cancel",
                                icon: "cancel",
                                click: function () {
                                    window.history.back()
                                },
                                hidden: !isSubmissionClosed
                            }
                        ]
                    }
                }).getKendoPDFViewer();
            if (contentUrl) {
                $.get({
                    url: contentUrl,
                    dataType: "html",
                    dataFilter: dataFilter,
                    success: function (data) {
                        previewEditor.value(data);
                        showPdfViewer();
                    }
                });
            } else {
                showPdfViewer();
            }
        };

        if (!isSubmissionClosed) {
            editorTabStrip = $("#editorTabStrip").kendoTabStrip({
                select(e) {
                    if (e.contentElement.id === "previewTab") {
                        $.post(URL_ROOT + "/pages/preview-content/", {
                            content: editor.value()
                        }, null, "html").done((data) => {
                            previewEditor.value(data);
                            previewContent();
                        });
                    }
                }
            }).data('kendoTabStrip');
        } else {
            editorTabStrip = $("#editorTabStrip").kendoTabStrip().data("kendoTabStrip");
            let previewEditorValue = `<?php echo $content ?? '' ?>`;
            previewEditor.value(previewEditorValue);
            previewContent();
        }

        chartsTabStrip = $("#chartsTabStrip").kendoTabStrip({
            activate(e) {
                let emptyChartPlaceholder = $("#emptyChartPlaceHolder");
                spreadsheet.activeSheet(spreadsheet.sheetByName($(e.item).text()));
                updateChartTabs();
                if (e.contentElement.innerHTML.length)
                    emptyChartPlaceholder.hide();
                else
                    emptyChartPlaceholder.show();
            }
        }).data("kendoTabStrip");

        editorActionToolbar = $("#editorActionToolbar").kendoToolBar({
            items: [
                {
                    type: "button",
                    text: "Save Draft",
                    icon: "save",
                    click: saveDraft,
                    // hidden: "<?php echo isset($edit_draft) ? '' : 'true' ?>"
                    hidden: true
                },
                {
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: saveReportPart,
                    hidden: "<?php echo isset($edit_report_part) ? '' : 'true' ?>"
                },
                {
                    type: "button",
                    text: "Save Final Report",
                    icon: "save",
                    click: saveFinalReport,
                    hidden: "<?php echo isset($edit_final_report) ? '' : 'true' ?>"
                },
                {
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
                    hidden: Boolean("<?php echo isReportSubmitted($target_month ?? '', $target_year ?? '', $current_user->department_id, $table_prefix ?? 'nmr') ? 'true' : '' ?>")
                },
                {
                    type: "button",
                    id: "updateSubmittedReportBtn",
                    icon: "upload",
                    attributes: {"class": "update-submitted-report-btn"},
                    text: "Update Submitted Report",
                    click: submitReport,
                    hidden: Boolean("<?php echo isReportSubmitted($target_month ?? '', $target_year ?? '', $current_user->department_id, $table_prefix ?? 'nmr') ? '' : 'true' ?>")
                },
                <?php endif; ?>

                <?php if (isITAdmin($current_user->user_id)): ?>
                {
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: savePreloadedDraft,
                    hidden: editPreloadedDraft ? '' : true
                },
                {
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: saveReportPart,
                    hidden: addReportPart ? '' : true
                },
                {
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

        function appendTocHTag(value) {
            let randomId = value + 'tag_' + Date.now();
            editor.exec('insertHtml', {value: `<${value} id=${randomId}></${value}>`});
        }

        /*
        // Limit image upload size
        $(".k-i-image").on('click', function () {
            setTimeout(function(){
                // Attach a select handler to the Upload embedded in the ImageBrowser.
                $(".k-imagebrowser .k-upload").find("input").data("kendoUpload").bind("select", function (e) {
                    // Prevent the event if the selected file exceeds the specified limit.
                    if (e.files[0].size > 1048576) {
                        e.preventDefault();
                        alert("Maximum allowed file size: 1MB");
                    }
                });
            });
        });*/

        let chartMenuCommand = {
            template: kendo.template($("#chartsMenuTemplate").html())
        };

        let copyToEditor = {
            template: kendo.template($("#copyToEditor").html())
        };

        let updateCharts = {
            template: kendo.template($("#updateCharts").html())
        };

        spreadsheet = $("#spreadSheet").kendoSpreadsheet({
            columnWidth: 50,
            toolbar: {
                //home: [chartMenuCommand].concat(kendo.spreadsheet.ToolBar.fn.options.tools.home),
                home: [
                    chartMenuCommand,
                    copyToEditor,
                    //updateCharts,
                    <?php if (isITAdmin($current_user->user_id)) : ?>
                    {
                        type: "button",
                        template: '<a href="#" id="#saveSpreadsheetBtn" data-role="button" tabindex="0" title="Save Spreadsheet as Template" data-tool="saveSheetTemplate" class="k-button k-button-icon"  data-overflow="auto" onclick="saveSpreadsheetTemplate(event)"><span class="k-icon k-i-save"></span></a>',
                    }, <?php endif; ?>
                    //"open",
                    "exportAs",
                    //["cut", "copy", "paste"],
                    ["bold", "italic", "underline"],
                    "fontSize",
                    "fontFamily",
                    "alignment",
                    "backgroundColor",
                    "textColor",
                    "format"
                ],
                insert: false,
                data: false
            },
            columns: 14,
            rows: 8,
            removeSheet(e) {
                chartsTabStrip.remove("li[aria-controls=" + chartTabs[e.sheet.name()] + "]");  //remove chart related to sheet
                // updateChartTabs();
                setTimeout(() => selectChartTab(this.activeSheet().name()), 100
                )
            },
            selectSheet(e) {
                selectChartTab(e.sheet.name());
            }
        }).data("kendoSpreadsheet");
        spreadsheet.activeSheet().range("A:N").enable(false);

        $("#copyToEditorButton").on("click", function () {
            let name = spreadsheet.activeSheet().name();
            if (charts[name]) {
                appendChartSheet(name);
            }
        });

        $("#updateChartsButton").on("click", function () {
            let name = spreadsheet.activeSheet().name();
            if (charts[name]) {
                appendChartSheet(name, true);
            }
        });

        setTimeout(function () {
            //$("div#spreadSheet").trigger("resize");
            //overlayScrollbarsInstances.body.scroll($("#editorTabStrip"), 5000, {x: 'swing', y: 'swing'})
            //setTimeout(() => overlayScrollbarsInstances.body.scroll({y: '-100%'}, 1500, {x: 'swing', y: 'swing'}), 500);

        }, 3000);

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
                if (!(isITAdmin || isPowerUser)) {
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

        if (editDraft && !isSubmissionClosed) {
            loadDraft();
        }
    });

    function loadDraft() {
        let json = $("#spreadsheetContent").val();
        if (json)
            spreadsheet.fromJSON(JSON.parse(json));
        let sheets = spreadsheet.sheets();
        for (let i = 0; i < sheets.length; i++) {
            createChartFromSheet(sheets[i])
        }
        updateChartTabs();
        if (sheets.length > 0)
            selectChartTab(sheets[0].name());
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
        if (firstSheetLoading) {
            firstSheetLoading = false;
            sheet = spreadsheet.activeSheet();
            sheet.fromJSON(sheetJSON);
        } else {
            sheet = spreadsheet.insertSheet({});
            sheet.fromJSON(sheetJSON);
        }
        spreadsheet.activeSheet(sheet);
        return sheet;
    }

    $(document).mutationSummary("connect", {
        callback: function (response) {
            if (response[0].added.length > 0) {
                adjustWindowHeight(response[0].added);
                initOverlayScrollbars($(response[0].added).find("textarea"), {
                    resize: "vertical",
                    sizeAutoCapable: true,
                    paddingAbsolute: true,
                    scrollbars: {
                        clickScrolling: true
                    }
                })
            }
            if (response[1].added.length > 0) {
                let chartTab = response[1].added.filter((e) => $(e).parents("#chartsTabStrip").length !== 0);
                if (chartTab.length !== 0)
                    chartsTabStrip.activateTab($(chartTab));
            }

            /*if (response[2].added.length > 0) {
                response[2].added.forEach(function (e) {
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

            if (response[3].added.length > 0) {
                let textarea = $(response[3].added).find('textarea');
                textarea.attr('rows', 8);
                $(response[3].added).find('.k-dialog-update').on('click', function (e) {
                    editor.body().innerHTML = textarea.val();
                    editor.update();
                });
            }*/
        },
        queries: [
            {element: "[data-role=window]"},
            {element: ".k-item[role=tab]"},
            // {element: "textarea"},
            //{element: '.k-viewhtml-dialog'}
        ]
    });

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
        /* if (Array.prototype.map.call(chartsTabStrip.items(), (item => item.textContent)).includes(sheetName)) {
             spreadsheet.activeSheet(sheet);
             return;
         }*/
        chartsTabStrip.append([{
            text: sheetName,
            content: '<div id="' + sheetName + '" class="spreadsheet-chart" style="height: 100%; width: 100%"></div>'
        }]);
        let div = $("[id='" + sheetName + "']");
        let divParent = div.parent("[role=tabpanel]");
        chartsTabStrip.activateTab(divParent);
        //chartTabs[sheetName] = divParent.attr("id");
        //updateChartTabs();
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
            let valueRange = sheet.range("B2:M4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_RECOVERY_HEAD_GRADE
                },
                dataSource: {data: data},
                series: [
                    {
                        // Notice the syntax for fields
                        // that are not valid JS identifiers
                        field: "['RECOVERY']",
                        categoryField: categoryField,
                        type: "column",
                        name: "RECOVERY",
                        color: seriesColor.goldProduced
                    },
                    {
                        field: "['HEAD GRADE']",
                        categoryField: categoryField,
                        type: "line",
                        name: "HEAD GRADE",
                        color: seriesColor.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName === (CHART_RECOVERY_HEAD_GRADE_2)) {
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
            let valueRange = sheet.range("B2:M5");
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
        } else if (sheetName === CHART_PROCESSING) {
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
                    text: CHART_PROCESSING
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
                        color: seriesColor.budgetTonnesMilled
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
                            font: "10px sans-serif"
                        },
                        labels: {
                            font: "10px sans-serif",
                            format: "{0:n}"
                        },
                        narrowRange: true
                        // majorUnit: 20000
                    },
                    {
                        name: "goldProduced",
                        title: {
                            text: "Gold Produced (oz)",
                            font: "10px sans-serif",
                        },
                        labels: {
                            font: "10px sans-serif",
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
                        font: "10px sans-serif"
                    }
                }
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName === (CHART_GOLD_PRODUCED_BUDGET_OUNCES)) {
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
            let valueRange = sheet.range("B2:M4");
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
            let valueRange = sheet.range("B2:M6");
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
            let valueRange = sheet.range("B2:M8");
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
                        dashType: "dash",
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
                        dashType: "longDashDotDot",
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
        } else if (sheetName === (CHART_MINE_SITE_EMPLOYEE_TURNOVER)) {
            sheet.range("B3:M5").format('#,###');
            sheet.range("B6:M6").format('#.0000');
            let valueRange = sheet.range("B2:M6");
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
        } else if (sheetName === (CHART_MINE_SITE_EMPLOYEE_TURNOVER_2)) {
            sheet.range("B3:M5").format('#,###');
            let valueRange = sheet.range("B2:G6");
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
        //scrollToChartsTabstrip();
    }


    function scrollToChartsTabstrip() {
        setTimeout(function () {
            overlayScrollbarsInstances['body'].scroll($("#chartsTabstripHolder"), 5500, {
                x: "linear",
                y: "easeOutBounce"
            })
        }, 1000)
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
            /*if ($(editor.body()).find("img[id='chart_img_" + sheet.name() + "']").length || $(editor.body()).find("img[id='sheet_img_" + sheet.name() + "']").length) {
                appendChartSheet(sheet.name());
            }*/
        }
    }

    function addSheetImageToEditor(name, ignoreExisting = false) {
        let draw = kendo.drawing;
        let sheet = spreadsheet.sheetByName(name);
        let promises = [];
        sheet.draw({}, group => {
            let imgs = editor.body().querySelectorAll("div[id='sheet_img_" + name + "'] img");
            if (group.children.length > 0) {
                for (var i = 0; i < group.children.length; i++) {
                    promises.push(draw.exportImage(group.children[i], {}));
                }
                for (let i = 0; i < promises.length; i++) {
                    if (ignoreExisting || !imgs) {
                        promises[i].done(data => editor.paste("<div id='sheet_img_" + name + "'> <img src='" + data + "'   alt=''/> </div>"));
                    } else {
                        promises[i].done(data => $(imgs).attr("src", data));
                    }
                }
            }
        })
    }

    function appendChartSheet(name, ignoreExisting = false) {
        let draw = kendo.drawing;
        let chart = charts[name];
        let sheet = spreadsheet.sheetByName(name);
        let dataUri = {};
        let imgs = {};
        sheet.draw({}, group => {
            let editorDataHtml = $(editor.getData());
            let chartImg = $("img[id='chart_img_" + name + "']", editorDataHtml);
            let sheetImg = $("img[id='sheet_img_" + name + "']", editorDataHtml);
            let chartImgElem;
            let sheetImgElem;
            let exportChart = chart.exportImage().then(data => data);
            let exportSheet = draw.exportImage(group, {}).then(data => data);
            exportChart.done((data => {
                dataUri.chart = data;
                if (ignoreExisting || chartImg.length === 0) {
                    chartImgElem = CKEDITOR.dom.element.createFromHtml("<img id='chart_img_" + name + "' src='" + dataUri.chart + "' alt='' />");
                    editor.insertElement(chartImgElem);
                    editor.widgets.initOn(chartImgElem, 'image');
                } else {
                    chartImg.attr('src', dataUri.chart);
                }
                exportSheet.done(data => {
                    dataUri.sheet = data;
                    if (ignoreExisting || sheetImg.length === 0) {
                        sheetImgElem = CKEDITOR.dom.element.createFromHtml("<img id='sheet_img_" + name + "' src='" + dataUri.sheet + "'   alt=''/>");
                        editor.insertElement(sheetImgElem);
                        editor.widgets.initOn(sheetImgElem, 'image');
                    } else {
                        sheetImg.attr('src', dataUri.sheet);
                    }
                    if (editorDataHtml.length) {
                        editor.setData(CKEDITOR.dom.element.createFromHtml($('<div />').append(editorDataHtml).html()).getOuterHtml());
                    }
                });
            }));
        });
    }

    function addChartImageToEditor(name, ignoreExisting) {
        let chart = charts[name];
        chart.exportImage().done(data => {
            let imgs = editor.body().querySelectorAll("div[data-id='chart_img_" + name + "'] img");
            if (ignoreExisting || !imgs) {
                editor.paste("<div id='chart_img_" + name + "'><img  src='" + data + "' alt='' data-id='chart_img_" + name + "'/></div>");
            } else {
                $(imgs).attr("src", data);
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
            chartsTabStrip.activateTab(tab);
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
        postDfrPromise.done(function () {
            spreadsheet.saveJSON().then(function (data) {
                $("#spreadsheetContent").val(JSON.stringify(data, null, 2));
                $.post({
                    url: "<?php echo URL_ROOT . '/pages/save-draft' ?>",
                    data: $("#editorForm").serialize(),
                    dataType: 'json'
                }).done(function (response, textStatus, jQueryXHR) {
                    if (response.success) {
                        let kAlert = kendoAlert('Save Draft', 'Draft saved successfully!');
                        if (response.draft_id)
                            $('#draftId').val(response.draft_id);
                        setTimeout(() => kAlert.close(), 2500);
                    } else {
                        let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                        setTimeout(() => kAlert.close(), 2500);
                    }
                });
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
            $.post(`${URL_ROOT}/pages/save-report-part/${tablePrefix}/${reportPartId}`, {
                content: editor.value(),
                description: description
            }, null, "json").done(d => {
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
                        setTimeout(() => kAlert.close(), 2500);
                    } else {
                        let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                        setTimeout(() => kAlert.close(), 2500);
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
        kendo.drawing.drawDOM($(previewEditor.body), {
            paperSize: 'a3',
            margin: "1.3cm",
            multipage: true,
            forcePageBreak: ".page-break"
        }).then(function (group) {
            // Render the result as a PDF file
            return kendo.drawing.exportPDF(group, {});
        }).done(dataURI => {
            $.post(`${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`, {
                html_content: editor.value(),
                data_uri: dataURI
            }, () => {
                let alert = kendoAlert('Save Flash Report', `${targetMonth} ${targetYear} Flash Report saved successfully!`);
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
                                setTimeout(() => kAlert.close(), 2500);
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
                        template: JSON.stringify(activeSheet.toJSON(), null, 2),
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
            let url = `${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`;
            $.get(url).done(html => {
                previewEditor.value(html);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "1.3cm",
                    multipage: true,
                    forcePageBreak: '.page-break'
                }).then(function (group) {
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (dataURI) {
                    $.post(url, {data_uri: dataURI, html_content: html}, null, "json").done(() => {
                        let alert = kendoAlert("Report Saved!", "Report saved successfully.");
                        setTimeout(() => alert.close(), 1500);
                    });
                });
            });
        }));
    }


    function submitReport(e) {
        let draftId = $("#draftId");
        let title = $("#draftTitleInput").val();
        let targetMonth = $("#targetMonth").val();
        let targetYear = $("#targetYear").val();
        let submit = () => {
            let dfd = $.Deferred();
            let post = $.post(URL_ROOT + "/pages/submit-report/" + tablePrefix + "/" + targetMonth + "/" + targetYear, {
                title: title,
                draft_id: draftId.val(),
                content: editor.value(),
                spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
            }, null, "json");
            dfd.resolve(post);
            return dfd.promise();
        };

        if ($(e.target).hasClass('update-submitted-report-btn')) {
            showWindow('This report has already been submitted. Are you sure you want to update it?')
                .done(e => {
                    submit().done(post => post.done(data => {
                        draftId.val(data.draftId);
                        let alert = kendoAlert("Report Updated!", "Report updated successfully.");
                        setTimeout(() => alert.close(), 3000);
                    }));
                });
        } else if ($(e.target).hasClass("submit-report-btn")) {
            submit().done(post => post.done(data => {
                draftId.val(data.draftId);
                let alert = kendoAlert("Report Submitted!", "Report submitted successfully.");
                setTimeout(() => alert.close(), 3000);
                editorActionToolbar.hide(".submit-report-btn");
                editorActionToolbar.show(".update-submitted-report-btn");
            }));
        }
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

</script>
</body>
</html>