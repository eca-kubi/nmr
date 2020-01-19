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
                    <h5 class="box-title text-bold"><input type="text" id="draftTitleInput"
                                                           class="k-input <?php echo isset($title) ? '' : 'no-title' ?>"
                                                           value="<?php echo isset($title) ? $title : 'New Draft' ?>">
                    </h5>
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
                            <li class="k-state-active">Edit</li>
                            <li>Preview</li>
                        </ul>
                        <div id="editorTab">
                            <div id="editorActionToolbar"></div>
                            <div style="width: 100%">
                                <form id="editorForm">
                                    <textarea name="content" id="editor" cols="30" rows="10"
                                              style="height: 400px"><?php echo isset($content) ? $content : ''; ?></textarea>
                                    <input type="hidden" id="spreadsheetContent" name="spreadsheet_content"
                                           value='<?php echo isset($spreadsheet_content) ? $spreadsheet_content : ''; ?>'>
                                    <input type="hidden" id="title" name="title"
                                           value="<?php echo isset($title) ? $title : ''; ?>">
                                    <input type="hidden" id="draftId" name="draft_id"
                                           value="<?php echo isset($draft_id) ? $draft_id : ''; ?>">
                                    <input type="hidden" id="departmentName" name="department_name">
                                </form>
                            </div>
                        </div>
                        <div id="previewTab">
                            <div id="previewContent"></div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
            <div class="box collapsed border-warning">
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
    /** @type {kendo.ui.Editor}*/
    let editor;
    let firstSheetLoading = true;
    let editDraft = Boolean(<?php echo isset($edit_draft) ? $edit_draft : '' ?>);
    let isNewDraft = Boolean(<?php echo isset($is_new_draft) ? 'true' : '' ?>);
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
        budgetTonnage: "#ffcd9b"
    };
    let previewWindow;
    let previewViewer;
    let pdfViewer;
    let userDepartmentId = "<?php echo $current_user->department_id; ?>";
    $(function () {
      /*  previewWindow = $("<div id='previewWindow'><div id='previewViewer'></div></div>").appendTo("body").kendoWindow({
            modal: true,
            visible: false,
            width: "80%",
            scrollable: false,
            //height: "80%",
            // (Optional) Will limit the percentage dimensions as well:
            // maxWidth: 1200,
            // maxHeight: 800,
            //open: adjustSize
        }).data("kendoWindow");*/



        spreadsheetTemplates = JSON.parse($("#spreadsheetTemplates").val());
        $(window).on("resize", function () {
            kendo.resize($("#chartsTabstripHolder"));
            spreadsheet.resize(true);
        });

        editorTabStrip = $("#editorTabStrip").kendoTabStrip({
            select(e) {
                if (e.contentElement.id === "previewTab") {
                    if (!pdfViewer)
                    pdfViewer = $("#previewContent").kendoPDFViewer({
                        pdfjsProcessing: {
                            file: ""
                        },
                        width: "100%",
                        height: 550,
                        scale: 1,
                    }).getKendoPDFViewer();
                    //$("#previewContent").html($(".k-editable-area iframe")[0].contentDocument.documentElement.innerHTML);
                    kendo.drawing.drawDOM($(editor.body), {
                        paperSize: 'a3',
                        margin: "2cm",
                        multipage: true
                    }).then(function (group) {
                        // Render the result as a PDF file
                        return kendo.drawing.exportPDF(group, {});
                    })
                        .done(function (data) {
                            // Save the PDF file
                            /*kendo.saveAs({
                                dataURI: data,
                                fileName: draftName + ".pdf",
                                //proxyURL: "https://demos.telerik.com/kendo-ui/service/export"
                            });*/
                           // previewWindow.center().open();
                            pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                            setTimeout(() => pdfViewer.activatePage(1), 500)
                        });
                }
            }
        });

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
                    click: saveDraft
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
                    }
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
                <?php if (isSubmissionOpened()): ?>
                {
                    type: "button",
                    text: "Submit Report",
                    icon: "check",
                    id: "submitReportBtn",
                    attributes: {"class" : "submit-report-btn"},
                    click: submitReport,
                    hidden: Boolean("<?php echo isReportSubmitted(currentSubmissionMonth(), currentSubmissionYear(), $current_user->department_id)? 'true' : '' ?>")
                },
                <?php endif; ?>
                {
                    type: "button",
                    id: "updateSubmittedReportBtn",
                    icon: "upload",
                    attributes: {"class" : "update-submitted-report-btn"},
                    text: "Update Submitted Report",
                    click: submitReport,
                    hidden: Boolean("<?php echo isReportSubmitted(currentSubmissionMonth(), currentSubmissionYear(), $current_user->department_id)? '' : 'true' ?>")
                },

                <?php if (isITAdmin($current_user->user_id)): ?>
                {
                    type: "button",
                    text: "Save as Preloaded",
                    icon: "launch",
                    click: saveDraftAsPreloaded
                },
                <?php endif; ?>
            ]
        }).data("kendoToolBar");

        editor = $("#editor").kendoEditor({
            tools: [
                "bold",
                "italic",
                "underline",
                //"strikethrough",
                "justifyLeft",
                "justifyCenter",
                "justifyRight",
                "justifyFull",
                "insertUnorderedList",
                "insertOrderedList",
                "indent",
                "outdent",
                "createLink",
                "unlink",
                "insertImage",
                "insertFile",
                "subscript",
                "superscript",
                "tableWizard",
                "createTable",
                "addRowAbove",
                "addRowBelow",
                "addColumnLeft",
                "addColumnRight",
                "deleteRow",
                "deleteColumn",
                "mergeCellsHorizontally",
                "mergeCellsVertically",
                "splitCellHorizontally",
                "splitCellVertically",
                "print",
                "formatting",
                "cleanFormatting",
                "fontName",
                "fontSize",
                "foreColor",
                "backColor",
                "viewHtml"
            ],
            stylesheets: [
                "<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css",
               // "<?php echo URL_ROOT; ?>/public/custom-assets/css/editor.css"
            ],
            imageBrowser: {
                transport: {
                    read: {
                        url: URL_ROOT + "/image-service/read",
                        dataType: "json"
                    },
                    uploadUrl: URL_ROOT + "/image-service/upload",
                    thumbnailUrl: function (path, file) {
                        return URL_ROOT + "/image-service/thumbnail-service/?i=" + path + file;
                    },
                    imageUrl: function (e) {
                        return URL_ROOT + "/image-service/images/?i=" + e
                    }
                }
            },
            fileBrowser: {
                transport: {
                    read: {
                        url: URL_ROOT + "/file-service/read",
                        dataType: "json"
                    },
                    fileUrl: function (e) {
                        return URL_ROOT + "/file-service/files/?f=" + e;
                    },
                    uploadUrl: URL_ROOT + "/file-service/upload",
                    create: {
                        url() {
                            return URL_ROOT + "/file-service/create-directory"
                        },
                        dataType: "json"
                    },
                },
                fileTypes: "*.docx, *.doc, *.ppt, *.pptx"
            },
            resizable: {
                content: true,
                //toolbar: true
            },
            encoded: false
        }).data("kendoEditor");

        editor.document.title = "NZEMA MONTHLY REPORT " + moment().format("Y");

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
                    //"open",
                    "exportAs",
                    //["cut", "copy", "paste"],
                    ["bold", "italic", "underline"],
                    "fontSize",
                    //"fontFamily",
                    "alignment",
                    "backgroundColor",
                    "textColor",
                    "format"
                ],
                insert: false,
                data: false
            },
            columns: 13,
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

        $("#copyToEditorButton").on("click", function () {
            let activeSheetName = spreadsheet.activeSheet().name();
            if (charts[activeSheetName]) {
                addChartImageToEditor(activeSheetName, true);
                addSheetImageToEditor(activeSheetName, true);
            }
        });

        setTimeout(function () {
            $("div#spreadSheet").trigger("resize");
            //overlayScrollbarsInstances.body.scroll($("#editorTabStrip"), 5000, {x: 'swing', y: 'swing'})
            setTimeout(() => overlayScrollbarsInstances.body.scroll({y: '-100%'}, 1500, {x: 'swing', y: 'swing'}), 500);
        }, 3000);

        let chartMenuButton = $("#chartsMenuButton");
        let chartsMenuPopup = $("#chartsMenuPopup").kendoPopup({
            anchor: chartMenuButton
        }).data("kendoPopup");

        let chartsMenuListBox = $("#chartsMenuListBox").kendoListBox({
            dataSource: (() => {
                let ds = [];
                spreadsheetTemplates.map((e) => ds.push({id: e.id, description: e.description, departmentId: e.department_id}));
                if (!isITAdmin) {
                    ds = ds.filter(value => value.departmentId + "" === userDepartmentId);
                }
                if (ds.length === 0) chartMenuButton.hide();
                return ds;
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

        if (editDraft) {
            loadDraft();
        }
    });

    function loadDraft() {
        spreadsheet.fromJSON(JSON.parse($("#spreadsheetContent").val()));
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

            if (response[2].added.length > 0) {
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
                    editor.body.innerHTML = textarea.val();
                    editor.update();
                });
            }
        },
        queries: [
            {element: "[data-role=window]"},
            {element: ".k-item[role=tab]"},
            {element: "textarea"},
            {element: '.k-viewhtml-dialog'}
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
        if (sheetName.startsWith(CHART_RECOVERY_HEAD_GRADE)) {
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

        } else if (sheetName.startsWith(CHART_GOLD_PRODUCED_TONS_MILLED)) {
            let valueRange = sheet.range("B2:M4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
                title: {
                    text: CHART_GOLD_PRODUCED_TONS_MILLED
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
                        field: "['TONS MILLED']",
                        categoryField: categoryField,
                        type: "line",
                        name: "TONS MILLED",
                        color: seriesColor.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);

        } else if (sheetName.startsWith(CHART_GOLD_PRODUCED_BUDGET_OUNCES)) {
            let valueRange = sheet.range("B2:M4");
            let fieldRange = sheet.range("A2:A4");
            data = fetchData(sheet, valueRange, fieldRange);
            chart = div.kendoChart($.extend(kendoChartOptions, {
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
                        color: seriesColor.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
        } else if (sheetName.startsWith(CHART_PLANNED_VRS_ACTUAL_METRES)) {
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
        } else if (sheetName.startsWith(CHART_CLOSING_STOCKPILE_BALANCE)) {
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
        } else if (sheetName.startsWith(CHART_TOLL_DELIVERY)) {
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
        }
        scrollToChartsTabstrip();
    }

    function scrollToChartsTabstrip() {
        setTimeout(function () {
            overlayScrollbarsInstances['body'].scroll($("#chartsTabstripHolder"), 5500, {
                x: "linear",
                y: "easeOutBounce"
            })
        }, 1000)
    }

    function renderLegend(label, labelColor, color, width = 1.5, dashType = "solid") {
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

        //let space = new draw.Text("&nbsp;", [0, 0], {font: "0.2px"});

        layout.append(path, text);
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
            if ($(editor.body).find("img[data-id='chart_img_" + sheet.name() + "']").length) {
                addChartImageToEditor(sheet.name());
            }
            if ($(editor.body).find("img[data-id='sheet_img_" + sheet.name() + "']").length) {
                addSheetImageToEditor(sheet.name())
            }
        }
    }

    function addSheetImageToEditor(name, ignoreExisting = false) {
        let draw = kendo.drawing;
        let sheet = spreadsheet.sheetByName(name);
        let promises = [];
        sheet.draw({}, group => {
            if (group.children.length > 0) {
                for (var i = 0; i < group.children.length; i++) {
                    promises.push(draw.exportImage(group.children[i], {}));
                }
                for (let i = 0; i < promises.length; i++) {
                    if (ignoreExisting) {
                        promises[i].done(data => editor.paste("<img class='my-1' src='" + data + "' data-id='sheet_img_" + sheet.name() + "' style='display:block;margin-left:auto;margin-right:auto;'/>"));
                    } else {
                        let imgs = editor.body.querySelectorAll("img[data-id='sheet_img_" + sheet.name() + "']");
                        if (imgs)
                            promises[i].done(data => $(imgs).attr("src", data));
                        else
                            promises[i].done(data => editor.paste("<img class='my-1' src='" + data + "' data-id='sheet_img_" + sheet.name() + "' style='display:block;margin-left:auto;margin-right:auto;'/>"));
                    }
                }
            }
        })
    }


    function addChartImageToEditor(chartName, ignoreExisting) {
        let chart = charts[chartName];
        chart.exportImage().done(data => {
            if (ignoreExisting) {
                editor.paste("<img class='my-1' src='" + data + "' data-id='chart_img_" + chartName + "' style='display:block;margin-left:auto;margin-right:auto;' />");
            } else {
                let imgs = editor.body.querySelectorAll("img[data-id='chart_img_" + chartName + "']");
                if (!imgs) {
                    editor.paste("<img class='my-1' src='" + data + "' data-id='chart_img_" + chartName + "' style='display:block;margin-left:auto;margin-right:auto;' />");
                } else {
                    $(imgs).attr("src", data);
                }
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
        postDfrPromise.done(function (title) {
            spreadsheet.saveJSON().then(function (data) {
                $("#spreadsheetContent").val(JSON.stringify(data, null, 2));
                $.post({
                    url: "<?php echo isset($edit_preloaded_draft) ? URL_ROOT . '/pages/save-preloaded-draft' : URL_ROOT . '/pages/save-draft' ?>",
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
                    }
                });
            });
        });
        let draftTitleInput = $("#draftTitleInput");
        if (draftTitleInput.hasClass('no-title')) {
            kendo.prompt("Enter a title for your draft.", "New Draft").done(function (title) {
                $("#draftTitleInput, #title").removeClass('no-title').val(title);
                postDfr.resolve(title);
            });
        } else {
            let title = draftTitleInput.val();
            $("#title").val(title);
            postDfr.resolve(title);
        }
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
                            url: URL_ROOT + "/pages/save-draft-as-preloaded",
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
                    kendoAlert("Spreadsheet Template Saved", 'Spreadsheet template saved successfully!')
                });
            });
    }

    function submitReport(e) {
        let draftId = $("#draftId");
        let title = $("#draftTitleInput").val();
        $.post(URL_ROOT + "/pages/submit-report/", {
            title: title,
            draft_id: draftId.val()? draftId.val() : "",
            content: editor.value(),
            spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
        },null, "json").done((data) => {
            if(!draftId.val()) draftId.val(data.draftId);
            if ($(e.target).hasClass('update-submitted-report-btn')) {
                let alert = kendoAlert("Report Updated!", "Report updated successfully.");
                setTimeout(() => alert.close(), 3000);
            } else if($(e.target).hasClass("submit-report-btn")) {
                editorActionToolbar.hide(".submit-report-btn");
                editorActionToolbar.show(".update-submitted-report-btn");
                let alert = kendoAlert("Report Submitted!", "Report submitted successfully.");
                setTimeout(() => alert.close(), 3000);
            }
        })
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